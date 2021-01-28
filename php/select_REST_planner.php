<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';

if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $semanaActual = date('W');


    #OBTIENE LOS PROYECTOS SEGÚN LA SECCIÓN Y DESTINO
    if ($action == "obtenerActividadesOT") {
        $idTipo = $_GET['idTipo'];
        $tipo = $_GET['tipo'];
        $array = array();

        if ($tipo == "FALLA") {
            $query = "SELECT id, actividad, status FROM t_mc_actividades_ot 
            WHERE id_falla = $idTipo and activo = 1 ORDER BY id DESC";
        } elseif ($tipo == "TAREA") {
            $query = "SELECT id, actividad, status FROM t_mp_np_actividades_ot 
            WHERE id_tarea = $idTipo and activo = 1 ORDER BY id DESC";
        }

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $id = $x['id'];
                $actividad = $x['actividad'];
                $status = $x['status'];

                $arrayTemp = array(
                    "id" => $id,
                    "idTipo" => $idTipo,
                    "tipo" => $tipo,
                    "actividad" => $actividad,
                    "status" => $status
                );

                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }


    // OBTIENES LAS TAREAS EN GENERAL (PENDIENTES Y SOLUCIONADOS);
    if ($action == "obtenerTareas") {
        $idEquipo = $_GET['idEquipo'];
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_mp_np.id_destino = $idDestino";
        }

        if ($idEquipo <= 0) {
            $filtroEquipo = "and t_mp_np.id_seccion = $idSeccion and 
            t_mp_np.id_subseccion = $idSubseccion";
            $idEquipo = 0;
        } else {
            $filtroEquipo = "";
        }


        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.status, t_mp_np.responsable, t_colaboradores.nombre, t_mp_np.fecha, t_mp_np.rango_fecha, t_mp_np.tipo_incidencia,
        t_colaboradores.apellido,
        t_mp_np.status_urgente,
        t_mp_np.status_material,
        t_mp_np.status_trabajando,
        t_mp_np.energetico_electricidad,
        t_mp_np.energetico_agua,
        t_mp_np.energetico_diesel,
        t_mp_np.energetico_gas,
        t_mp_np.departamento_calidad,
        t_mp_np.departamento_compras,
        t_mp_np.departamento_direccion,
        t_mp_np.departamento_finanzas,
        t_mp_np.departamento_rrhh
        FROM t_mp_np
        LEFT JOIN t_users ON t_mp_np.id_usuario = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mp_np.id_equipo = $idEquipo and t_mp_np.activo = 1 $filtroEquipo $filtroDestino
        ORDER BY t_mp_np.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTarea = $x['id'];
                $actividad = $x['titulo'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $idResponsable = $x['responsable'];
                $rangoFecha = $x['rango_fecha'];
                $tipoIncidencia = $x['tipo_incidencia'];
                $fechaCreacion = (new DateTime($x['fecha']))->format("d/m/Y");
                $status = $x['status'];
                $sUrgente = intval($x['status_urgente']);
                $sMaterial = intval($x['status_material']);
                $sTrabajando = intval($x['status_trabajando']);
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);

                #RESPONSABLE
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                $responsable = " ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable = strtok($x['nombre'], ' ') . " " .
                            strtok($x['apellido'], ' ');
                    }
                }

                #COMENTARIOS
                $query = "SELECT count(id) FROM comentarios_mp_np 
                WHERE id_mp_np = $idTarea and activo = 1";
                $totalComentarios = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #ADJUNTOS
                $query = "SELECT count(id) FROM adjuntos_mp_np 
                WHERE id_mp_np = $idTarea and activo = 1";
                $totalAdjuntos = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                #ACTIVIDADES
                $query = "SELECT count(id) FROM t_mp_np_actividades_ot 
                WHERE id_tarea = $idTarea and activo = 1";
                $totalActividades = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalActividades = $x['count(id)'];
                    }
                }


                #Rango Fecha
                if ($rangoFecha != "") {
                    $rangoFecha = explode(" - ", $rangoFecha);
                    if (isset($rangoFecha[0])) {
                        $fechaInicio = $rangoFecha[0];
                    } else {
                        $fechaInicio = $fechaCreacion;
                    }

                    if (isset($rangoFecha[1])) {
                        $fechaFin = $rangoFecha[1];
                    } else {
                        $fechaFin = $fechaCreacion;
                    }
                } else {
                    $fechaInicio = $fechaCreacion;
                    $fechaFin = $fechaCreacion;
                }

                #STATUS 
                if ($status == "N" or $status == "PENDIENTE" or $status == "" or $status == "P") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                if ($sMaterial > 0) {
                    $materiales = 1;
                } else {
                    $materiales = 0;
                }
                if ($sTrabajando > 0) {
                    $trabajando = 1;
                } else {
                    $trabajando = 0;
                }
                if ($sEnergetico > 0) {
                    $energeticos = 1;
                } else {
                    $energeticos = 0;
                }
                if ($sDepartamento > 0) {
                    $departamentos = 1;
                } else {
                    $departamentos = 0;
                }

                $arrayTemp = array(
                    "id" => $idTarea,
                    "ot" => "T$idTarea",
                    "actividad" => $actividad,
                    "responsable" => $responsable,
                    "tipoIncidencia" => $tipoIncidencia,
                    "creadoPor" => $creadoPor,
                    "comentarios" => intval($totalComentarios),
                    "adjuntos" => intval($totalAdjuntos),
                    "pda" => intval($totalActividades),
                    "fechaInicio" => $fechaInicio,
                    "fechaFin" => $fechaFin,
                    "status" => $status,
                    "materiales" => $materiales,
                    "energeticos" => $energeticos,
                    "departamentos" => $departamentos,
                    "trabajando" => $trabajando,
                    "tipo" => "TAREA"
                );

                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    // OBTIENES LAS FALLAS EN GENERAL (PENDIENTES Y SOLUCIONADOS);
    if ($action == "obtenerFallas") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT t_mc.id, t_mc.actividad, t_mc.status, t_mc.responsable, 
        t_mc.tipo_incidencia, t_colaboradores.nombre, t_mc.fecha_creacion, t_mc.rango_fecha, t_colaboradores.apellido,
        t_mc.status_urgente,
        t_mc.status_material,
        t_mc.status_trabajare,
        t_mc.energetico_electricidad,
        t_mc.energetico_agua,
        t_mc.energetico_diesel,
        t_mc.energetico_gas,
        t_mc.departamento_calidad,
        t_mc.departamento_compras,
        t_mc.departamento_direccion,
        t_mc.departamento_finanzas,
        t_mc.departamento_rrhh
        FROM t_mc 
        LEFT JOIN t_users ON t_mc.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mc.id_equipo = $idEquipo and t_mc.activo = 1 ORDER BY t_mc.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idFalla = $x['id'];
                $actividad = $x['actividad'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $idResponsable = $x['responsable'];
                $tipoIncidencia = $x['tipo_incidencia'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format("d/m/Y");
                $status = $x['status'];
                $sUrgente = intval($x['status_urgente']);
                $sMaterial = intval($x['status_material']);
                $sTrabajando = intval($x['status_trabajare']);
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);

                #RESPONSABLE
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                $responsable = " ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable = strtok($x['nombre'], ' ') . " " .
                            strtok($x['apellido'], ' ');
                    }
                }

                #COMENTARIOS
                $query = "SELECT count(id) FROM t_mc_comentarios 
                WHERE id_mc = $idFalla and activo = 1";
                $totalComentarios = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #ADJUNTOS
                $query = "SELECT count(id) FROM t_mc_adjuntos 
                WHERE id_mc = $idFalla and activo = 1";
                $totalAdjuntos = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                #ACTIVIDADES
                $query = "SELECT count(id) FROM t_mc_actividades_ot 
                WHERE id_falla = $idFalla and activo = 1";
                $totalActividades = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalActividades = $x['count(id)'];
                    }
                }


                #Rango Fecha
                if ($rangoFecha != "") {
                    $rangoFecha = explode(" - ", $rangoFecha);
                    if (isset($rangoFecha[0])) {
                        $fechaInicio = $rangoFecha[0];
                    } else {
                        $fechaInicio = $fechaCreacion;
                    }

                    if (isset($rangoFecha[1])) {
                        $fechaFin = $rangoFecha[1];
                    } else {
                        $fechaFin = $fechaCreacion;
                    }
                } else {
                    $fechaInicio = $fechaCreacion;
                    $fechaFin = $fechaCreacion;
                }

                #STATUS 
                if ($status == "N" or $status == "PENDIENTE" or $status == "" or $status == "P") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }


                if ($sMaterial > 0) {
                    $materiales = 1;
                } else {
                    $materiales = 0;
                }
                if ($sTrabajando > 0) {
                    $trabajando = 1;
                } else {
                    $trabajando = 0;
                }
                if ($sEnergetico > 0) {
                    $energeticos = 1;
                } else {
                    $energeticos = 0;
                }
                if ($sDepartamento > 0) {
                    $departamentos = 1;
                } else {
                    $departamentos = 0;
                }

                $arrayTemp = array(
                    "id" => $idFalla,
                    "ot" => "F$idFalla",
                    "actividad" => $actividad,
                    "responsable" => $responsable,
                    "tipoIncidencia" => $tipoIncidencia,
                    "creadoPor" => $creadoPor,
                    "comentarios" => intval($totalComentarios),
                    "adjuntos" => intval($totalAdjuntos),
                    "pda" => intval($totalActividades),
                    "fechaInicio" => $fechaInicio,
                    "fechaFin" => $fechaFin,
                    "status" => $status,
                    "materiales" => $materiales,
                    "energeticos" => $energeticos,
                    "departamentos" => $departamentos,
                    "trabajando" => $trabajando,
                    "tipo" => "FALLA"
                );

                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    #OBTIENE, SECCION, SUBSECCION, NOMBRE EQUIPO
    if ($action == "DestinoSeccionSubseccionEquipo") {
        $idEquipo = $_GET["idEquipo"];
        $idSeccion = $_GET["idSeccion"];
        $idSubseccion = $_GET["idSubseccion"];
        $tipoPendiente = $_GET['tipoPendiente'];
        $array = array();

        $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
        $array['destino'] = "-";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $destino = $x['destino'];
                $array['destino'] = $destino;
            }
        }

        $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
        $array['seccion'] = "-";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $seccion = $x['seccion'];
                $array['seccion'] = $seccion;
            }
        }

        $query = "SELECT grupo FROM c_subsecciones WHERE id = $idSubseccion";
        $array['subseccion'] = "-";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $subseccion = $x['grupo'];
                $array['subseccion'] = $subseccion;
            }
        }

        $query = "SELECT equipo FROM t_equipos_america WHERE id = $idEquipo";
        $array['equipo'] = "INCIDENCIA GENERAL";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $equipo = $x['equipo'];
                $array['equipo'] = $equipo;
            }
        }
        echo json_encode($array);
    }


    #GANTT PARA TAREAS (PENDIENTES Y SOLUCIONADOS)
    if ($action == "ganttTareas") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $idEquipo = $_GET['idEquipo'];
        $status = $_GET['status'];
        $palabraEquipo = $_GET['palabraEquipo'];
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        if ($idEquipo == 0) {
            $filtroEquipo = "and id_seccion = $idSeccion and id_subseccion = $idSubseccion";
        } else {
            $filtroEquipo = "";
        }

        if ($status == "PENDIENTE") {
            $filtroStatus = "and (status = 'P' or status = 'PENDIENTE' or status = 'N' or status = '')";
        } else {
            $filtroStatus = "and (status = 'SOLUCIONADO' or status = 'F')";
        }

        if ($palabraEquipo == "") {
            $filtroPalabra = "";
        } else {
            $filtroPalabra = "and equipo LIKE '%$palabraEquipo%'";
        }

        $query = "SELECT id, titulo, rango_fecha, fecha FROM t_mp_np WHERE activo = 1 and id_equipo = $idEquipo $filtroDestino $filtroEquipo $filtroPalabra $filtroStatus";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTarea = $x['id'];
                $actividad = $x['titulo'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = $x['fecha'];

                #Rango Fecha
                if ($rangoFecha != "" and strlen($rangoFecha) >= 22) {
                    $fechaInicio = "$rangoFecha[6]$rangoFecha[7]$rangoFecha[8]$rangoFecha[9]-$rangoFecha[3]$rangoFecha[4]-$rangoFecha[0]$rangoFecha[1]";

                    $fechaFin = "$rangoFecha[19]$rangoFecha[20]$rangoFecha[21]$rangoFecha[22]-$rangoFecha[16]$rangoFecha[17]-$rangoFecha[13]$rangoFecha[14]";
                } else {
                    $fechaInicio = (new DateTime($fechaCreacion))->format('Y-m-d');
                    $fechaFin = date("Y-m-d", strtotime($fechaInicio . "+ 1 days"));
                }

                $arrayAux = array(
                    "category" => $actividad,
                    "start" => $fechaInicio,
                    "end" => $fechaFin,
                    "task" => $actividad
                );
                $array[] = $arrayAux;
            }
        }
        echo json_encode($array);
    }


    #GANTT PARA FALLAS (PENDIENTES Y SOLUCIONADOS)
    if ($action == "ganttFallas") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $idEquipo = $_GET['idEquipo'];
        $status = $_GET['status'];
        $palabraEquipo = $_GET['palabraEquipo'];
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        if ($idEquipo == 0) {
            $filtroEquipo = "and id_seccion = $idSeccion and id_subseccion = $idSubseccion";
        } else {
            $filtroEquipo = "";
        }

        if ($status == "PENDIENTE") {
            $filtroStatus = "and (status = 'P' or status = 'PENDIENTE' or status = 'N' or status = '')";
        } else {
            $filtroStatus = "and (status = 'SOLUCIONADO' or status = 'F')";
        }

        if ($palabraEquipo == "") {
            $filtroPalabra = "";
        } else {
            $filtroPalabra = "and equipo LIKE '%$palabraEquipo%'";
        }

        $query = "SELECT id, actividad, rango_fecha, fecha_creacion FROM t_mc WHERE activo = 1 and id_equipo = $idEquipo $filtroStatus";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTarea = $x['id'];
                $actividad = $x['actividad'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = $x['fecha_creacion'];

                #Rango Fecha
                if ($rangoFecha != "" and strlen($rangoFecha) >= 22) {
                    $fechaInicio = "$rangoFecha[6]$rangoFecha[7]$rangoFecha[8]$rangoFecha[9]-$rangoFecha[3]$rangoFecha[4]-$rangoFecha[0]$rangoFecha[1]";

                    $fechaFin = "$rangoFecha[19]$rangoFecha[20]$rangoFecha[21]$rangoFecha[22]-$rangoFecha[16]$rangoFecha[17]-$rangoFecha[13]$rangoFecha[14]";
                } else {
                    $fechaInicio = (new DateTime($fechaCreacion))->format('Y-m-d');
                    $fechaFin = date("Y-m-d", strtotime($fechaInicio . "+ 1 days"));
                }

                $arrayAux = array(
                    "category" => $actividad,
                    "start" => $fechaInicio,
                    "end" => $fechaFin,
                    "task" => $actividad
                );
                $array[] = $arrayAux;
            }
        }
        echo json_encode($array);
    }


    #OBTIENE VALOR DE LOS STATUS((TAREAS, FALLAS, PREVENTIVOS, PROYECTOS) DONDE 1 = ACTIVO
    if ($action == "obtenerStatus") {
        $idRegistro = $_GET['idRegistro'];
        $tipoRegistro = $_GET['tipoRegistro'];
        $array = array();

        $sMaterial = 0;
        $sTrabajare = 0;
        $sCalidad = 0;
        $sCompras = 0;
        $sDireccion = 0;
        $sFinanzas = 0;
        $sRRHH = 0;
        $sElectricidad = 0;
        $sAgua = 0;
        $sDiesel = 0;
        $sGas = 0;
        $titulo = "";
        $cod2bend = "";
        $bitacoraGP = "";
        $bitacoraTRS = "";
        $bitacoraZI = "";

        if ($tipoRegistro == "FALLA") {
            $query = "SELECT actividad, status_material, status_trabajare, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, cod2bend,
            bitacora_gp, bitacora_trs, bitacora_zi
             FROM t_mc WHERE id = $idRegistro";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $sMaterial = $x['status_material'];
                    $sTrabajare = $x['status_trabajare'];
                    $sCalidad = $x['departamento_calidad'];
                    $sCompras = $x['departamento_compras'];
                    $sDireccion = $x['departamento_direccion'];
                    $sFinanzas = $x['departamento_finanzas'];
                    $sRRHH = $x['departamento_rrhh'];
                    $sElectricidad = $x['energetico_electricidad'];
                    $sAgua = $x['energetico_agua'];
                    $sDiesel = $x['energetico_diesel'];
                    $sGas = $x['energetico_gas'];
                    $titulo = $x['actividad'];
                    $cod2bend = $x['cod2bend'];
                    $bitacoraGP = $x['bitacora_gp'];
                    $bitacoraTRS = $x['bitacora_trs'];
                    $bitacoraZI = $x['bitacora_zi'];
                }
            }
        } elseif ($tipoRegistro == "TAREA") {
            $query = "SELECT titulo, status_material, status_trabajando, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, cod2bend, bitacora_gp, bitacora_trs, bitacora_zi 
            FROM t_mp_np WHERE id = $idRegistro";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $sMaterial = $x['status_material'];
                    $sTrabajare = $x['status_trabajando'];
                    $sCalidad = $x['departamento_calidad'];
                    $sCompras = $x['departamento_compras'];
                    $sDireccion = $x['departamento_direccion'];
                    $sFinanzas = $x['departamento_finanzas'];
                    $sRRHH = $x['departamento_rrhh'];
                    $sElectricidad = $x['energetico_electricidad'];
                    $sAgua = $x['energetico_agua'];
                    $sDiesel = $x['energetico_diesel'];
                    $sGas = $x['energetico_gas'];
                    $titulo = $x['titulo'];
                    $cod2bend = $x['cod2bend'];
                    $bitacoraGP = $x['bitacora_gp'];
                    $bitacoraTRS = $x['bitacora_trs'];
                    $bitacoraZI = $x['bitacora_zi'];
                }
            }
        } elseif ($tipoRegistro == "PROYECTO") {
            $query = "SELECT titulo, status_material, status_trabajare
            -- departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, energetico_electricidad, energetico_agua, 
            -- energetico_diesel, energetico_gas 
            FROM t_proyectos WHERE id = $idRegistro";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $sMaterial = $x['status_material'];
                    $sTrabajare = $x['status_trabajare'];
                    // $sCalidad = $x['departamento_calidad'];
                    // $sCompras = $x['departamento_compras'];
                    // $sDireccion = $x['departamento_direccion'];
                    // $sFinanzas = $x['departamento_finanzas'];
                    // $sRRHH = $x['departamento_rrhh'];
                    // $sElectricidad = $x['energetico_electricidad'];
                    // $sAgua = $x['energetico_agua'];
                    // $sDiesel = $x['energetico_diesel'];
                    // $sGas = $x['energetico_gas'];
                    $titulo = $x['titulo'];
                }
            }
        } elseif ($tipoRegistro == "PLANACCION") {
            $query = "SELECT actividad, status_material, status_trabajando, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, cod2bend, bitacora_gp, bitacora_trs, bitacora_zi 
            FROM t_proyectos_planaccion WHERE id = $idRegistro";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $sMaterial = $x['status_material'];
                    $sTrabajare = $x['status_trabajando'];
                    $sCalidad = $x['departamento_calidad'];
                    $sCompras = $x['departamento_compras'];
                    $sDireccion = $x['departamento_direccion'];
                    $sFinanzas = $x['departamento_finanzas'];
                    $sRRHH = $x['departamento_rrhh'];
                    $sElectricidad = $x['energetico_electricidad'];
                    $sAgua = $x['energetico_agua'];
                    $sDiesel = $x['energetico_diesel'];
                    $sGas = $x['energetico_gas'];
                    $titulo = $x['actividad'];
                    $cod2bend = $x['cod2bend'];
                    $bitacoraGP = $x['bitacora_gp'];
                    $bitacoraTRS = $x['bitacora_trs'];
                    $bitacoraZI = $x['bitacora_zi'];
                }
            }
        } elseif ($tipoRegistro == "ENERGETICO") {
            $query = "SELECT actividad, status_material, status_trabajare, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, cod2bend, bitacora_gp, bitacora_trs, bitacora_zi 
            FROM t_energeticos WHERE id = $idRegistro";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $sMaterial = $x['status_material'];
                    $sTrabajare = $x['status_trabajare'];
                    $sCalidad = $x['departamento_calidad'];
                    $sCompras = $x['departamento_compras'];
                    $sDireccion = $x['departamento_direccion'];
                    $sFinanzas = $x['departamento_finanzas'];
                    $sRRHH = $x['departamento_rrhh'];
                    $sElectricidad = $x['energetico_electricidad'];
                    $sAgua = $x['energetico_agua'];
                    $sDiesel = $x['energetico_diesel'];
                    $sGas = $x['energetico_gas'];
                    $titulo = $x['actividad'];
                    $cod2bend = $x['cod2bend'];
                    $bitacoraGP = $x['bitacora_gp'];
                    $bitacoraTRS = $x['bitacora_trs'];
                    $bitacoraZI = $x['bitacora_zi'];
                }
            }
        } elseif ($tipoRegistro == "ACTIVIDADPLANACCION") {
            $query = "SELECT actividad FROM t_proyectos_planaccion_actividades 
            WHERE id = $idRegistro";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $titulo = $x['actividad'];
                }
            }
        }

        if ($sMaterial != "" and $sMaterial != 0) {
            $sMaterial = 1;
        } else {
            $sMaterial = 0;
        }
        if ($sTrabajare != "" and $sTrabajare != 0) {
            $sTrabajare = 1;
        } else {
            $sTrabajare = 0;
        }
        if ($sCalidad != "" and $sCalidad != 0) {
            $sCalidad = 1;
        } else {
            $sCalidad = 0;
        }
        if ($sCompras != "" and $sCompras != 0) {
            $sCompras = 1;
        } else {
            $sCompras = 0;
        }
        if ($sDireccion != "" and $sDireccion != 0) {
            $sDireccion = 1;
        } else {
            $sDireccion = 0;
        }
        if ($sFinanzas != "" and $sFinanzas != 0) {
            $sFinanzas = 1;
        } else {
            $sFinanzas = 0;
        }
        if ($sRRHH != "" and $sRRHH != 0) {
            $sRRHH = 1;
        } else {
            $sRRHH = 0;
        }
        if ($sElectricidad != "" and $sElectricidad != 0) {
            $sElectricidad = 1;
        } else {
            $sElectricidad = 0;
        }
        if ($sAgua != "" and $sAgua != 0) {
            $sAgua = 1;
        } else {
            $sAgua = 0;
        }
        if ($sDiesel != "" and $sDiesel != 0) {
            $sDiesel = 1;
        } else {
            $sDiesel = 0;
        }
        if ($sGas != "" and $sGas != 0) {
            $sGas = 1;
        } else {
            $sGas = 0;
        }

        $array[] = array(
            "sMaterial" => intval($sMaterial),
            "sTrabajare" => intval($sTrabajare),
            "sCalidad" => intval($sCalidad),
            "sCompras" => intval($sCompras),
            "sDireccion" => intval($sDireccion),
            "sFinanzas" => intval($sFinanzas),
            "sRRHH" => intval($sRRHH),
            "sElectricidad" => intval($sElectricidad),
            "sAgua" => intval($sAgua),
            "sDiesel" => intval($sDiesel),
            "sGas" => intval($sGas),
            "sDepartamentos" => intval($sCompras) + intval($sDireccion) + intval($sCalidad) + intval($sFinanzas) + intval($sRRHH),
            "sEnergeticos" => intval($sAgua) + intval($sDiesel) + intval($sGas) + intval($sElectricidad),
            "titulo" => $titulo,
            "cod2bend" => $cod2bend,
            "bitacoraGP" => $bitacoraGP,
            "bitacoraTRS" => $bitacoraTRS,
            "bitacoraZI" => $bitacoraZI
        );

        echo json_encode($array);
    }


    // Consulta los Destinos que tiene acceso el usuario.
    if ($action == "obtenerDatosUsuario") {
        $data = array();
        $destinosOpcion = "";

        $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido, c_cargos.cargo, c_destinos.id, c_destinos.destino
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN c_destinos ON t_users.id_destino = c_destinos.id
        INNER JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        WHERE t_users.id = $idUsuario AND t_users.status = 'A' LIMIT 1";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idDestinoUsuario = $value['id'];
                $nombre = $value['nombre'];
                $apellido = $value['apellido'];
                $cargo = $value['cargo'];
            }
            $data['nombre'] = $nombre;
            $data['apellido'] = $apellido;
            $data['cargo'] = $cargo;
        }

        if ($idDestinoUsuario == 10) {
            $query = "SELECT id, destino FROM c_destinos WHERE status='A' ORDER BY destino ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                while ($row = mysqli_fetch_array($result)) {
                    $idDestinoS = $row['id'];
                    $nombreDestino = $row['destino'];
                    $destinosOpcion .= "<a href=\"#\" onclick=\"obtenerDatosUsuario($idDestinoS);\" class=\"hover:text-white d6 m-0 p-2 mb-2\">$nombreDestino</a>";
                }

                $queryDestino = "SELECT destino FROM c_destinos WHERE id = $idDestino";
                if ($resultDestino = mysqli_query($conn_2020, $queryDestino)) {
                    if ($row = mysqli_fetch_array($resultDestino)) {
                        $destino = $row['destino'];
                    }
                    $data['destino'] = $destino;
                }
            }
        } else {
            $query = "SELECT id, destino FROM c_destinos WHERE id = $idDestinoUsuario";
            if ($result = mysqli_query($conn_2020, $query)) {
                if ($row = mysqli_fetch_array($result)) {
                    $idDestinoS = $row['id'];
                    $nombreDestino = $row['destino'];
                    $data['destino'] = $nombreDestino;
                    $destinosOpcion .= "<a href=\"#\" onclick=\"obtenerDatosUsuario($idDestinoS);\" class=\"hover:text-white d6 m-0 p-2 mb-2\">$nombreDestino</a>";
                }
            }
        }

        $data['destinosOpcion'] = $destinosOpcion;
        echo json_encode($data);
    }


    if ($action == "obtenerPendientesUsuario") {
        $array = array();

        if ($idDestino == 10) {
            $filtroDestinoPlanaccion = "";
            $filtroDestinoInicidencias = "";
            $filtroDestinoInicidenciasG = "";
        } else {
            $filtroDestinoPlanaccion = "and t_proyectos.id_destino = $idDestino";
            $filtroDestinoInicidencias = "and t_mc.id_destino = $idDestino";
            $filtroDestinoInicidenciasG = "and t_mp_np.id_destino = $idDestino";
        }

        #PLANES DE ACCION
        $array['planaccion'] = array();
        $query = "SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos.titulo
        FROM t_proyectos_planaccion 
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id
        WHERE t_proyectos_planaccion.responsable = $idUsuario and t_proyectos_planaccion.activo = 1 and t_proyectos.activo = 1 and (t_proyectos_planaccion.status='N' or t_proyectos_planaccion.status='PENDIENTE' or t_proyectos_planaccion.status='P' or t_proyectos_planaccion.status='PROCESO') $filtroDestinoPlanaccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idPlanaccion = $x['id'];
                $actividad = $x['actividad'];
                $proyecto = $x['titulo'];

                $array['planaccion'][] = array(
                    "idPlanaccion" => intval($idPlanaccion),
                    "tipoPendiente" => "PLANACCION",
                    "proyecto" => $proyecto,
                    "actividad" => $actividad
                );
            }
        }

        #INCIDENCIAS
        $array['incidencias'] = array();
        $query = "SELECT t_mc.id, t_mc.actividad, t_mc.tipo_incidencia, t_equipos_america.equipo 
        FROM  t_mc
        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
        WHERE t_mc.responsable = $idUsuario and (t_mc.status = 'P' or t_mc.status = 'N' or t_mc.status = 'PENDIENTE') and t_mc.activo = 1 $filtroDestinoInicidencias";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idIncidencia = $x['id'];
                $actividad = $x['actividad'];
                $equipo = $x['equipo'];
                $tipoIncidencia = $x['tipo_incidencia'];

                $array['incidencias'][] = array(
                    "idIncidencia" => intval($idIncidencia),
                    "actividad" => $actividad,
                    "equipo" => $equipo,
                    "tipoIncidencia" => $tipoIncidencia
                );
            }
        }

        #INCIDENCIAS
        $array['incidenciasG'] = array();
        $query = "SELECT id, titulo, tipo_incidencia
        FROM t_mp_np      
        WHERE responsable = $idUsuario and (status = 'P' or status = 'N' or status = 'PENDIENTE') and activo = 1 $filtroDestinoInicidenciasG";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idIncidencia = $x['id'];
                $actividad = $x['titulo'];
                $tipoIncidencia = $x['tipo_incidencia'];

                $array['incidenciasG'][] = array(
                    "idIncidencia" => intval($idIncidencia),
                    "actividad" => $actividad,
                    "tipoIncidencia" => $tipoIncidencia
                );
            }
        }
        echo json_encode($array);
    }


    // OBTIENE IDEQUIPO, EQUIPO, DESTINO, SECCION Y SUBSECCION, POR ID DE EQUIPO
    if ($action == "obtenerEDSS") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo 
        FROM t_equipos_america
        INNER JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        WHERE t_equipos_america.id = $idEquipo";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipoX = $x['id'];
                $equipo = $x['equipo'];
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];

                $array =
                    array(
                        "idEquipo" => $idEquipoX,
                        "equipo" => $equipo,
                        "seccion" => $seccion,
                        "subseccion" => $subseccion
                    );
            }
        }
        echo json_encode($array);
    }


    // OBTIENE LOS TESTE DE EQUIPOS
    if ($action == "obtenerTestEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT t_test_equipos.id, t_test_equipos.test, t_test_equipos.rango_fecha, t_test_equipos.responsable, t_test_equipos.valor, t_colaboradores.nombre, t_colaboradores.apellido, t_unidades_medidas.medida
        FROM t_test_equipos 
        INNER JOIN t_users ON t_test_equipos.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN t_unidades_medidas ON t_test_equipos.id_unidad_medida = t_unidades_medidas.id
        WHERE t_test_equipos.id_equipo = $idEquipo ORDER BY t_test_equipos.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTest = intval($x['id']);
                $test = $x['test'];
                $valor = $x['valor'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $rangoFecha = $x['rango_fecha'];
                $responsable = intval($x['responsable']);
                $medida = $x['medida'];

                #RESPONSABLE
                if ($responsable > 0) {
                    $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $responsable";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $responsable = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                        }
                    }
                } else {
                    $responsable = "";
                }

                #ADJUNTOS
                $totalAdjuntos = 0;
                $query = "SELECT count(id) FROM t_test_equipos_adjuntos WHERE id_test = $idTest and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                #COMENTARIOS
                $totalComentarios = 0;
                $query = "SELECT count(id) FROM t_test_equipos_comentarios WHERE id_test = $idTest and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #RANGO FECHA
                $fechaInicio = "";
                $fechaFin = "";
                if ($rangoFecha != "") {
                    $fechaInicio = substr($rangoFecha, -10);
                    $fechaFin = substr($rangoFecha, -23, 10);
                }

                $array['test'][] =
                    array(
                        "idTest" => intval($idTest),
                        "test" => $test,
                        "creadoPor" => $creadoPor,
                        "rangoFecha" => $rangoFecha,
                        "fechaInicio" => $fechaInicio,
                        "fechaFin" => $fechaFin,
                        "responsable" => $responsable,
                        "valor" => $valor,
                        "medida" => $medida,
                        "adjuntos" => intval($totalAdjuntos),
                        "comentarios" => intval($totalComentarios)
                    );
            }
        }
        echo json_encode($array);
    }


    // AGREGAR TEST POR EQUIPO
    if ($action == "agregarTestEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $test = $_GET['test'];
        $valor = $_GET['valor'];
        $idMedida = $_GET['idMedida'];
        $rangoFecha = $_GET['rangoFecha'];
        $responsable = $_GET['responsable'];
        $resp = 0;

        $query = "INSERT INTO t_test_equipos(id_destino, id_equipo, test, valor, id_unidad_medida, fecha_creado, rango_fecha, creado_por, responsable, activo) VALUES($idDestino, $idEquipo, '$test', '$valor', $idMedida, '$fechaActual', '$rangoFecha', $idDestino, $responsable, 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // OBTIENE USUARIOS SEGÚN DESTINO
    if ($action == "obtenerUsuarios") {
        if (isset($_GET["palabraUsuario"])) {
            $palabraUsuario = $_GET["palabraUsuario"];
        } else {
            $palabraUsuario = "";
        }

        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_users.id_destino IN($idDestino)";
        }

        if ($palabraUsuario != "") {
            $filtroUsuario = "and (t_colaboradores.nombre LIKE '%$palabraUsuario%' or t_colaboradores.apellido LIKE '%$palabraUsuario%')";
        } else {
            $filtroUsuario = "";
        }

        $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido, 
        c_cargos.cargo
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        LEFT JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        WHERE t_users.status = 'A' $filtroDestino $filtroUsuario
        ORDER BY t_colaboradores.nombre ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idUsuario = $x['id'];
                $nombre = $x['nombre'];
                $apellido = $x['apellido'];
                $cargo = $x['cargo'];

                $array[] = array(
                    "idUsuario" => intval($idUsuario),
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "cargo" => $cargo
                );
            }
        }
        echo json_encode($array);
    }


    // OBTIENES TODAS LOS TIPOS DE MEDIDAS DE LA TABLA t_unidades_medidas
    if ($action == "obtenerUnidadesMedidas") {
        $array = array();
        $query = "SELECT id, medida FROM  t_unidades_medidas WHERE activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idMedida = $x['id'];
                $medida = $x['medida'];

                $array[] = array(
                    "idMedida" => intval($idMedida),
                    "medida" => $medida
                );
            }
        }
        echo json_encode($array);
    }


    // OBTIENE TODOS LOS COMENTARIOS DEL TEST SELECCIONADO
    if ($action == "obtenerComentariosTest") {
        $idTest = $_GET['idTest'];
        $array = array();

        $query = "SELECT t_test_equipos_comentarios.id, t_test_equipos_comentarios.comentario, t_test_equipos_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido 
        FROM t_test_equipos_comentarios
        INNER JOIN t_users ON t_test_equipos_comentarios.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
        WHERE t_test_equipos_comentarios.id_test = $idTest
        ORDER BY t_test_equipos_comentarios.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idComentario = $x['id'];
                $comentario = $x['comentario'];
                $fecha = $x['fecha'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');

                $array[] = array(
                    "idComentario" => intval($idComentario),
                    "comentario" => $comentario,
                    "fecha" => $fecha,
                    "creadoPor" => $creadoPor
                );
            }
        }
        echo json_encode($array);
    }


    // AGREGA COMENTAIOS A LOS TEST
    if ($action == "agregarComentariosTest") {
        $idTest = $_GET["idTest"];
        $comentario = $_GET["comentario"];
        $resp = 0;

        $query = "INSERT INTO t_test_equipos_comentarios(id_test, comentario, creado_por, fecha,activo) VALUES ($idTest, '$comentario', $idUsuario, '$fechaActual', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // OBTENER ADJUNTOS TEST
    if ($action == "obtenerAdjuntosTest") {
        $idTest = $_GET["idTest"];
        $array = array();

        $query = "SELECT t_test_equipos_adjuntos.id, t_test_equipos_adjuntos.url_adjunto, t_test_equipos_adjuntos.fecha, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_test_equipos_adjuntos 
        INNER JOIN t_users ON t_test_equipos_adjuntos.subido_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_test_equipos_adjuntos.id_test = $idTest and t_test_equipos_adjuntos.activo = 1 ORDER BY t_test_equipos_adjuntos.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idAdjunto = $x['id'];
                $url = $x['url_adjunto'];
                $fecha = $x['fecha'];
                $subidoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $extension = pathinfo($url, PATHINFO_EXTENSION);

                if ($extension === "jpg" || $extension === "jpeg" || $extension === "png" || $extension === "JPG" || $extension === "JPEG" || $extension === "PNG") {
                    $array['imagenes'][] = array(
                        "idAdjunto" => $idAdjunto,
                        "url" => $url,
                        "fecha" => $fecha,
                        "subidoPor" => $subidoPor,
                        "tipo" => "imagenes"
                    );
                } else {
                    $array['documentos'][] = array(
                        "idAdjunto" => $idAdjunto,
                        "url" => $url,
                        "fecha" => $fecha,
                        "subidoPor" => $subidoPor,
                        "tipo" => "documentos"
                    );
                }
            }
        }
        echo json_encode($array);
    }


    if ($action == "agregarAdjuntoTest") {
        $idTest = $_GET['idTest'];
        $resp = 0;

        // VARIABLES DEL ADJUNTO
        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $nombre = 'TEST_ID_' . $idTest . '_' . rand(50, 1500) . '.' . $extension;

        if (move_uploaded_file($rutaTemporal, '../planner/test/' . $nombre)) {
            $query = "INSERT INTO t_test_equipos_adjuntos(id_test, url_adjunto, subido_por, fecha, activo) VALUES($idTest, '$nombre', $idUsuario, '$fechaActual', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }


    // ELIMINAR ADJUNTO
    if ($action == "eliminarAdjunto") {
        $idAdjunto = $_GET['idAdjunto'];
        $tipoAdjunto = $_GET['tipoAdjunto'];
        $resp = 0;

        if ($tipoAdjunto == "FALLA") {
            $query = "UPDATE t_mc_adjuntos SET activo = 0 WHERE id = $idAdjunto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($tipoAdjunto == "TAREA") {
            $query = "UPDATE adjuntos_mp_np SET activo = 0 WHERE id = $idAdjunto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($tipoAdjunto == "PLANACCION") {
            $query = "UPDATE t_proyectos_planaccion_adjuntos SET status = 0 WHERE id = $idAdjunto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($tipoAdjunto == "JUSTIFICACIONPROYECTO") {
            $query = "UPDATE t_proyectos_justificaciones SET status = 0 WHERE id = $idAdjunto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($tipoAdjunto == "COTIZACIONPROYECTO") {
            $query = "UPDATE t_proyectos_adjuntos SET status = 0 WHERE id = $idAdjunto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($tipoAdjunto == "TEST") {
            $query = "UPDATE t_test_equipos_adjuntos SET activo = 0 WHERE id = $idAdjunto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($tipoAdjunto == "ENERGETICO") {
            $query = "UPDATE t_energeticos_adjuntos SET activo = 0 WHERE id = $idAdjunto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($tipoAdjunto == "equipo") {
            $query = "UPDATE t_equipos_america_adjuntos SET activo = 0 WHERE id = $idAdjunto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }


    // OBTIENE LOS PENDIENTES DE ENERGETICOS
    if ($action == "obtenerEnergeticos") {
        $idSeccion = $_GET["idSeccion"];
        $idSubseccion = $_GET["idSubseccion"];
        $status = $_GET["status"];
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_energeticos.id_destino = $idDestino";
        }

        if ($status == "PENDIENTE") {
            $filtroStatus = "and t_energeticos.status IN('PENDIENTE', 'N', 'P')";
        } else {
            $filtroStatus = "and t_energeticos.status IN('SOLUCIONADO', 'F', 'FINALIZADO')";
        }

        $query = "SELECT t_energeticos.id, t_energeticos.actividad, t_energeticos.responsable,
        t_energeticos.rango_fecha,
        t_energeticos.status,
        t_energeticos.status_trabajare,
        t_energeticos.status_urgente,
        t_energeticos.departamento_calidad,
        t_energeticos.departamento_compras,
        t_energeticos.departamento_direccion,
        t_energeticos.departamento_finanzas,
        t_energeticos.departamento_rrhh,
        t_energeticos.energetico_electricidad,
        t_energeticos.energetico_agua,
        t_energeticos.energetico_diesel,
        t_energeticos.energetico_gas,
        t_energeticos.cod2bend,
        t_energeticos.codsap,
        t_energeticos.bitacora_gp,
        t_energeticos.bitacora_trs,
        t_energeticos.bitacora_zi,
        t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_energeticos
        INNER JOIN t_users ON t_energeticos.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_energeticos.id_seccion = $idSeccion and t_energeticos.id_subseccion = $idSubseccion and t_energeticos.activo = 1  $filtroDestino $filtroStatus
        ORDER BY t_energeticos.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEnergetico = $x['id'];
                $actividad = $x['actividad'];
                $idResponsable = $x['responsable'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $rangoFecha = $x['rango_fecha'];
                $status = $x['status'];
                $sTrabajare = $x['status_trabajare'];
                $sUrgente = $x['status_urgente'];
                $cod2bend = $x['cod2bend'];
                $codsap = $x['codsap'];
                $bitacoraGP = $x['bitacora_gp'];
                $bitacoraTRS = $x['bitacora_trs'];
                $bitacoraZI = $x['bitacora_zi'];

                $sDepartamentos = intval($x['departamento_calidad']) + intval($x['departamento_compras']);
                +intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);

                $sEnergeticos = $x['energetico_electricidad'] + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);

                #RANGO FECHA
                $fechaInicio = "";
                $fechaFin = "";
                if ($rangoFecha != "") {
                    $fechaInicio = substr($rangoFecha, -23, 10);
                    $fechaFin = substr($rangoFecha, -10);
                }

                #RESPONSABLE
                $responsable = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador  = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable = strtok($x['nombre'], ' ') . " " .
                            strtok($x['apellido'], ' ');
                    }
                }

                # ADJUNTOS
                $totalAdjuntos = 0;
                $query = "SELECT count(id) 'id' FROM t_energeticos_adjuntos 
                WHERE id_energetico = $idEnergetico and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['id'];
                    }
                }

                # COMENTARIOS
                $totalComentarios = 0;
                $query = "SELECT count(id) 'id' FROM t_energeticos_comentarios 
                WHERE id_energetico = $idEnergetico and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['id'];
                    }
                }

                $array[] = array(
                    "idEnergetico" => intval($idEnergetico),
                    "actividad" => $actividad,
                    "creadoPor" => $creadoPor,
                    "responsable" => $responsable,
                    "fechaInicio" => $fechaInicio,
                    "fechaFin" => $fechaFin,
                    "status" => $status,
                    "sTrabajare" => intval($sTrabajare),
                    "sUrgente" => intval($sUrgente),
                    "sEnergeticos" => intval($sEnergeticos),
                    "sDepartamentos" => intval($sDepartamentos),
                    "cod2bend" => $cod2bend,
                    "codsap" => $codsap,
                    "bitacoraGP" => $bitacoraGP,
                    "bitacoraTRS" => $bitacoraTRS,
                    "bitacoraZI" => $bitacoraZI,
                    "comentarios" => intval($totalComentarios),
                    "adjuntos" => intval($totalAdjuntos)
                );
            }
        }
        echo json_encode($array);
    }


    // OBTENER REPOSABLE ENERGETICOS
    if ($action == "obtenerUsuariosEnergeticos") {
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_users.id_destino = $idDestino";
        }

        $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido, c_cargos.cargo
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        LEFT JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        WHERE t_users.status = 'A' and t_users.activo = 1 $filtroDestino 
        ORDER BY t_colaboradores.nombre ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idUsuario = $x['id'];
                $nombre = $x['nombre'];
                $apellido = $x['apellido'];
                $puesto = $x['cargo'];

                if ($puesto == "") {
                    $puesto = "NA";
                }

                $array[] = array(
                    "idUsuario" => intval($idUsuario),
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "puesto" => $puesto
                );
            }
        }
        echo json_encode($array);
    }


    // ACTUALIZAR ENERGETICOS (IDENERGETICO, COLUMNA, VALOR)
    if ($action == "actualizarEnergetico") {
        $idEnergetico = $_GET['idEnergetico'];
        $columna = $_GET['columna'];
        $valor = $_GET['valor'];
        $titulo = $_GET['titulo'];
        $resp = "ninguno";
        $cod2bend = $_GET['cod2bend'];

        // BUSCA VALORES EN LOS STATUS PARA CREA EL TOGGLE
        if ($columna == "status_material" || $columna == "status_trabajare" || $columna == "status_urgente" || $columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh" || $columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas" || $columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $query = "SELECT $columna FROM t_energeticos WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valor = intval($x[$columna]);
                }
            }

            if ($valor == 0) {
                $valor = 1;
            } else {
                $valor = 0;
            }
        }

        if ($columna == "responsable") {
            $query = "UPDATE t_energeticos SET responsable = $valor WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "responsable";
            }
        } elseif ($columna == "titulo") {
            $query = "UPDATE t_energeticos SET actividad = '$titulo' WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "titulo";
            }
        } elseif ($columna == "status_trabajare") {
            $query = "UPDATE t_energeticos SET status_trabajare = $valor WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "trabajare";
            }
        } elseif ($columna == "status_material" and $cod2bend != "") {
            $query = "UPDATE t_energeticos SET status_material = $valor, cod2bend = '$cod2bend' WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "material";
            }
        } elseif ($columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh") {
            $query = "UPDATE t_energeticos SET $columna = $valor WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "departamento";
            }
        } elseif ($columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas") {
            $query = "UPDATE t_energeticos SET $columna = $valor WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "energetico";
            }
        } elseif ($columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $query = "UPDATE t_energeticos SET $columna = $valor WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "bitacora";
            }
        } elseif ($columna == "status") {
            $query = "UPDATE t_energeticos SET status = 'SOLUCIONADO', fecha_finalizado = '$fechaActual' WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "solucionado";
            }
        } elseif ($columna == "activo") {
            $query = "UPDATE t_energeticos SET activo = 0 WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "eliminado";
            }
        } elseif ($columna == "restaurar") {
            $query = "UPDATE t_energeticos SET status = 'PENDIENTE' WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "restuarado";
            }
        } else if ($columna == "rangoFecha" && $valor != "") {
            $query = "UPDATE t_energeticos SET rango_fecha = '$valor' WHERE id = $idEnergetico";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "rangoFecha";
            }
        }
        echo json_encode($resp);
    }


    // OBTIENE LOS COMENTARIOS DE LAS SUBSECCIONES DE ENERGETICOS
    if ($action == "obtenerComentariosEnergetico") {
        $idEnergetico = $_GET['idEnergetico'];
        $array = array();

        $query = "SELECT t_energeticos_comentarios.id, t_energeticos_comentarios.comentario, t_energeticos_comentarios.fecha_creado, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_energeticos_comentarios 
        INNER JOIN t_users ON t_energeticos_comentarios.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_energeticos_comentarios.id_energetico = $idEnergetico and t_energeticos_comentarios.activo = 1
        ORDER BY t_energeticos_comentarios.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idComentario = $x['id'];
                $comentario = $x['comentario'];
                $nombre = $x['nombre'];
                $apellido = $x['apellido'];
                $fecha = $x['fecha_creado'];

                $array[] = array(
                    "idComentario" => intval($idComentario),
                    "comentario" => $comentario,
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "fecha" => $fecha
                );
            }
        }
        echo json_encode($array);
    }


    // AGREGA COMENTARIOS EN ENERGETICOS
    if ($action == "agregarComentariosEnergetico") {
        $idEnergetico = $_GET['idEnergetico'];
        $comentario = $_GET['comentario'];
        $resp = 0;

        $query = "INSERT INTO t_energeticos_comentarios(id_energetico, creado_por, fecha_creado, comentario, activo) VALUES($idEnergetico, $idUsuario, '$fechaActual', '$comentario', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // AGREGA ADJUNTO EN ENERGETICOS
    if ($action == "agregarAdjuntosEnergetico") {
        $idEnergetico = $_GET['idEnergetico'];
        $resp = 0;

        // VARIABLES DEL ADJUNTO
        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $nombre = 'ENERGETICO_ID_' . $idEnergetico . '_' . rand(50, 1500) . '.' . $extension;

        if (move_uploaded_file($rutaTemporal, '../planner/energeticos/' . $nombre)) {
            $query = "INSERT INTO t_energeticos_adjuntos(id_energetico, subido_por, fecha, url, activo) VALUES($idEnergetico, $idUsuario, '$fechaActual', '$nombre', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }


    // OBTENER ADJUNTOS
    if ($action == "obtenerAdjuntosEnergetico") {
        $idEnergetico = $_GET['idEnergetico'];
        $array = array();

        $query = "SELECT id, url FROM t_energeticos_adjuntos 
        WHERE id_energetico = $idEnergetico and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idAdjunto = $x['id'];
                $url = $x['url'];
                $tipo = pathinfo($url, PATHINFO_EXTENSION);

                $array[] = array(
                    "idAdjunto" => intval($idAdjunto),
                    "url" => $url,
                    "tipo" => $tipo
                );
            }
        }
        echo json_encode($array);
    }


    //OBTIENES LAS SECCIONES SEGÚN EL DESTINO
    if ($action == "obtenerSeccionesPorDestino") {
        $array = array();

        $query = "SELECT c_secciones.id, c_secciones.seccion 
        FROM c_rel_destino_seccion
        INNER JOIN c_secciones  ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino 
        ORDER BY c_secciones.seccion ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSeccion = $x['id'];
                $seccion = $x['seccion'];

                $array[] = array(
                    "idSeccion" => intval($idSeccion),
                    "seccion" => $seccion
                );
            }
        }
        echo json_encode($array);
    }


    //OBTIENES LAS SUBSECCIONES SEGÚN EL DESTINO
    if ($action == "obtenerSubseccionPorSeccion") {
        $idSeccion = $_GET['idSeccion'];
        $array = array();

        $query = "SELECT id, grupo 
        FROM c_subsecciones WHERE id_seccion = $idSeccion
        ORDER BY grupo ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSubseccion = $x['id'];
                $subseccion = $x['grupo'];

                $array[] = array(
                    "idSubseccion" => intval($idSubseccion),
                    "subseccion" => $subseccion
                );
            }
        }
        echo json_encode($array);
    }


    //OBTIENES LAS SECCIONES, SUBSECCION SEGÚN EL DESTINO
    if ($action == "obtenerSeccionesSubseccionPorDestino") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        // SECCIONES Y SUBSECCIONES
        $query = "SELECT c_secciones.id, c_secciones.seccion 
        FROM c_rel_destino_seccion
        INNER JOIN c_secciones  ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino 
        ORDER BY c_secciones.seccion ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSeccion = $x['id'];
                $seccion = $x['seccion'];

                $array['secciones'][] = array(
                    "idSeccion" => intval($idSeccion),
                    "seccion" => $seccion
                );

                $query = "SELECT id, grupo 
                FROM c_subsecciones WHERE id_seccion = $idSeccion
                ORDER BY grupo ASC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idSubseccion = $x['id'];
                        $subseccion = $x['grupo'];

                        $array['subsecciones'][] = array(
                            "idSubseccion" => intval($idSubseccion),
                            "subseccion" => $subseccion
                        );
                    }
                }
            }
        }

        // TIPOS DE EQUIPOS
        $array['tipos'] = array();
        $query = "SELECT id, tipo FROM c_tipos 
        WHERE status = 'A' ORDER BY tipo ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTipo = $x['id'];
                $tipo = $x['tipo'];

                $array['tipos'][] = array(
                    "idTipo" => intval($idTipo),
                    "tipo" => $tipo
                );
            }
        }

        // EQUIPOS PADRES
        $array['equipos'] = array();
        $query = "SELECT id_destino, id_seccion, id_subseccion 
        FROM t_equipos_america
        WHERE id = $idEquipo";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id_destino'];
                $idSeccion = $x['id_seccion'];
                $idSubseccion = $x['id_subseccion'];

                $query = "SELECT id, equipo FROM t_equipos_america 
                WHERE id_destino = $idDestino and id_seccion = $idSeccion and id_subseccion = $idSubseccion and status = 'OPERATIVO' and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idEquipo = $x['id'];
                        $equipo = $x['equipo'];

                        $array['equipos'][] = array(
                            "idEquipo" => intval($idEquipo),
                            "equipo" => $equipo
                        );
                    }
                }
            }
        }

        // MARCAS
        $array['marcas'] = array();
        $query = "SELECT id, marca FROM c_marcas WHERE status = 'A' ORDER BY marca ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idMarca = $x["id"];
                $marca = $x["marca"];

                $array['marcas'][] = array(
                    "idMarca" => intval($idMarca),
                    "marca" => $marca
                );
            }
        }


        echo json_encode($array);
    }


    // OBTIENE EQUIPOS TIPO LOCAL O EQUIPO, SEGUN DESTINO, SECCION Y SUBSECCION
    if ($action == "obtenerEquipoLocal") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $tipo = $_GET['tipo'];
        $array = array();

        if ($tipo == "EQUIPO") {
            $filtroTipo = "and local_equipo = 'EQUIPO'";
        } elseif ($tipo == "LOCAL") {
            $filtroTipo = "and local_equipo = 'LOCAL'";
        } else {
            $filtroTipo = "";
        }

        $query = "SELECT id, equipo FROM t_equipos_america 
        WHERE id_destino = $idDestino and id_seccion = $idSeccion and id_subseccion = $idSubseccion and status = 'OPERATIVO' and activo = 1 $filtroTipo
        ORDER BY equipo ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];

                $array[] = array(
                    "idEquipo" => $idEquipo,
                    "equipo" => $equipo
                );
            }
        }
        echo json_encode($array);
    }


    // OBTIENE INFORMACION DE EQUIPO por ID
    if ($action == "obtenerEquipoPorId") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT*  FROM t_equipos_america WHERE id = $idEquipo and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $id  = $x['id'];
                $id_equipo_principal  = $x['id_equipo_principal'];
                $equipo = $x['equipo'];
                $cod2bend = $x['cod2bend'];
                $cantidad = $x['cantidad'];
                $matricula = $x['matricula'];
                $serie = $x['serie'];
                $id_destino = $x['id_destino'];
                $id_seccion = $x['id_seccion'];
                $id_subseccion = $x['id_subseccion'];
                $id_tipo = $x['id_tipo'];
                $id_ccoste = $x['id_ccoste'];
                $id_hotel = $x['id_hotel'];
                $id_area = $x['id_area'];
                $id_localizacion = $x['id_localizacion'];
                $id_ubicacion = $x['id_ubicacion'];
                $id_sububicacion = $x['id_sububicacion'];
                $categoria = $x['categoria'];
                $local_equipo = $x['local_equipo'];
                $jerarquia = $x['jerarquia'];
                $id_marca = $x['id_marca'];
                $modelo = $x['modelo'];
                $numero_serie = $x['numero_serie'];
                $codigo_fabricante = $x['codigo_fabricante'];
                $codigo_interno_compras = $x['codigo_interno_compras'];
                $largo_cm = $x['largo_cm'];
                $ancho_cm = $x['ancho_cm'];
                $alto_cm = $x['alto_cm'];
                $potencia_electrica_hp = $x['potencia_electrica_hp'];
                $potencia_electrica_kw = $x['potencia_electrica_kw'];
                $voltaje_v = $x['voltaje_v'];
                $frecuencia_hz = $x['frecuencia_hz'];
                $caudal_agua_m3h = $x['caudal_agua_m3h'];
                $caudal_agua_gph = $x['caudal_agua_gph'];
                $carga_mca = $x['carga_mca'];
                $potencia_energetica_frio_kw = $x['potencia_energetica_frio_kw'];
                $potencia_energetica_frio_tr = $x['potencia_energetica_frio_tr'];
                $potencia_energetica_calor_kcal = $x['potencia_energetica_calor_kcal'];
                $caudal_aire_m3h = $x['caudal_aire_m3h'];
                $caudal_aire_cfm = $x['caudal_aire_cfm'];
                $coste = $x['coste'];
                $id_fases = $x['id_fases'];
                $status = $x['status'];
                $activo = $x['activo'];


                $array = array(
                    "idEquipo" => intval($id),
                    "idEquipoPrincipal" => intval($id_equipo_principal),
                    "equipo" => $equipo,
                    "cod2bend" => $cod2bend,
                    "cantidad" => $cantidad,
                    "matricula" => $matricula,
                    "serie" => $serie,
                    "idDestino" => intval($id_destino),
                    "idSeccion" => intval($id_seccion),
                    "idSubseccion" => intval($id_subseccion),
                    "idTipo" => intval($id_tipo),
                    "idCcoste" => intval($id_ccoste),
                    "idHotel" => intval($id_hotel),
                    "idArea" => intval($id_area),
                    "idLocalizacion" => intval($id_localizacion),
                    "idUbicacion" => intval($id_ubicacion),
                    "idSububicacion" => intval($id_sububicacion),
                    "categoria" => $categoria,
                    "localEquipo" => $local_equipo,
                    "jerarquia" => $jerarquia,
                    "idMarca" => $id_marca,
                    "modelo" => $modelo,
                    "numeroSerie" => $numero_serie,
                    "codigoFabricante" => $codigo_fabricante,
                    "codigoInternoCompras" => $codigo_interno_compras,
                    "largo_cm" => $largo_cm,
                    "ancho_cm" => $ancho_cm,
                    "alto_cm" => $alto_cm,
                    "potencia_electrica_hp" => $potencia_electrica_hp,
                    "potencia_electrica_kw" => $potencia_electrica_kw,
                    "voltaje_v" => $voltaje_v,
                    "frecuencia_hz" => $frecuencia_hz,
                    "caudal_agua_m3h" => $caudal_agua_m3h,
                    "caudal_agua_gph" => $caudal_agua_gph,
                    "carga_mca" => $carga_mca,
                    "potencia_energetica_frio_kw" => $potencia_energetica_frio_kw,
                    "potencia_energetica_frio_tr" => $potencia_energetica_frio_tr,
                    "potencia_energetica_calor_kcal" => $potencia_energetica_calor_kcal,
                    "caudal_aire_m3h" => $caudal_aire_m3h,
                    "caudal_aire_cfm" => $caudal_aire_cfm,
                    "coste" => $coste,
                    "idFases" => $id_fases,
                    "status" => $status,
                    "activo" => intval($activo)
                );
            }
        }
        echo json_encode($array);
    }


    // NUEVO METODO PARA ACTUALIZAR INFORMACIÓN DE LOS EQUIPOS
    if ($action == "actualizarEquipo") {
        $idEquipo = $_POST['idEquipo'];
        $equipo = $_POST['equipo'];
        $status = $_POST['status'];
        $localEquipo = $_POST['localEquipo'];
        $idFases = $_POST['idFases'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $idTipo = $_POST['idTipo'];
        $jerarquia = $_POST['jerarquia'];
        $idEquipoPrincipal = $_POST['idEquipoPrincipal'];
        $idMarca = $_POST['idMarca'];
        $modelo = $_POST['modelo'];
        $serie = $_POST['serie'];
        $codigoFabricante = $_POST['codigoFabricante'];
        $codigoInternoCompras = $_POST['codigoInternoCompras'];
        $cantidad = $_POST['cantidad'];
        $largo_cm = $_POST['largo_cm'];
        $ancho_cm = $_POST['ancho_cm'];
        $alto_cm = $_POST['alto_cm'];
        $potencia_electrica_hp = $_POST['potencia_electrica_hp'];
        $potencia_electrica_kw = $_POST['potencia_electrica_kw'];
        $voltaje_v = $_POST['voltaje_v'];
        $frecuencia_hz = $_POST['frecuencia_hz'];
        $caudal_agua_m3h = $_POST['caudal_agua_m3h'];
        $caudal_agua_gph = $_POST['caudal_agua_gph'];
        $carga_mca = $_POST['carga_mca'];
        $potencia_energetica_frio_kw = $_POST['potencia_energetica_frio_kw'];
        $potencia_energetica_frio_tr = $_POST['potencia_energetica_frio_tr'];
        $potencia_energetica_calor_kcal = $_POST['potencia_energetica_calor_kcal'];
        $caudal_aire_m3h = $_POST['caudal_aire_m3h'];
        $caudal_aire_cfm = $_POST['caudal_aire_cfm'];

        $resp = 0;

        if ($jerarquia == "PRINCIPAL" || $jerarquia == "0" || $jerarquia == "") {
            $idEquipoPrincipal = 0;
            $jerarquia = "PRINCIPAL";
        } elseif ($jerarquia == "SECUNDARIO" and $idEquipoPrincipal <= 0) {
            $idEquipoPrincipal = 0;
            $jerarquia = "PRINCIPAL";
        }

        $query = "UPDATE t_equipos_america SET 
                id_equipo_principal = '$idEquipoPrincipal',
                equipo = '$equipo',
                cantidad = '$cantidad',
                serie = '$serie',
                id_seccion = '$idSeccion',
                id_subseccion = '$idSubseccion',
                id_tipo = '$idTipo',
                local_equipo = '$localEquipo',
                jerarquia = '$jerarquia',
                id_marca = '$idMarca',
                modelo = '$modelo',
                numero_serie = '$serie',
                codigo_fabricante = '$codigoFabricante',
                codigo_interno_compras = '$codigoInternoCompras',
                largo_cm = '$largo_cm',
                ancho_cm = '$ancho_cm',
                alto_cm = '$alto_cm',
                potencia_electrica_hp = '$potencia_electrica_hp',
                potencia_electrica_kw = '$potencia_electrica_kw',
                voltaje_v = '$voltaje_v',
                frecuencia_hz = '$frecuencia_hz',
                caudal_agua_m3h = '$caudal_agua_m3h',
                caudal_agua_gph = '$caudal_agua_gph',
                carga_mca = '$carga_mca',
                potencia_energetica_frio_kw = '$potencia_energetica_frio_kw',
                potencia_energetica_frio_tr = '$potencia_energetica_frio_tr',
                potencia_energetica_calor_kcal = '$potencia_energetica_calor_kcal',
                caudal_aire_m3h = '$caudal_aire_m3h',
                caudal_aire_cfm = '$caudal_aire_cfm',
                id_fases = '$idFases',
                status = '$status'
        WHERE id = $idEquipo";

        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // AGREGA LAS INCIDENCIAS DESDE LAS COLUMNAS PRINCIPALES DE PLANNER
    if ($action == "agregarIncidencia") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $descripcion = $_GET['descripcion'];
        $rangoFecha = $_GET['rangoFecha'];
        $responsable = $_GET['responsable'];
        $comentario = $_GET['comentario'];
        $tipo = $_GET['tipo'];
        $idEquipo = $_GET['idEquipo'];
        $resp = 0;
        $idMax = 0;

        if ($idEquipo > 0) {
            $query = "SELECT max(id) 'id' FROM t_mc";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idMax = intval($x['id']) + 1;
                }
            }
            if ($idMax > 0) {
                $query = "INSERT INTO t_mc(id, actividad, tipo_incidencia, id_equipo, status, creado_por, responsable, fecha_creacion, id_destino, id_seccion, id_subseccion, rango_fecha, activo) VALUES($idMax, '$descripcion', '$tipo', $idEquipo, 'N', $idUsuario, $responsable,'$fechaActual', $idDestino, $idSeccion, $idSubseccion, '$rangoFecha', 1)";

                if ($comentario != "") {
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $query = "INSERT INTO t_mc_comentarios(id_mc, comentario, id_usuario, fecha, activo) VALUES($idMax, '$comentario', $idUsuario, '$fechaActual', 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $resp = 1;
                        }
                    }
                } else {
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $resp = 1;
                    }
                }
            }
        } else {

            $query = "SELECT max(id) 'id' FROM t_mp_np";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idMax = intval($x['id']) + 1;
                }
            }
            if ($idMax > 0) {
                $query = "INSERT INTO t_mp_np(id, id_equipo, id_usuario, id_destino, id_seccion, id_subseccion, tipo_incidencia, titulo, responsable, fecha, rango_fecha, status, activo) VALUES($idMax, 0, $idUsuario, $idDestino, $idSeccion, $idSubseccion, '$tipo', '$descripcion', $responsable, '$fechaActual', '$rangoFecha', 'PENDIENTE', 1)";
                if ($result = mysqli_query($conn_2020, $query)) {

                    if ($comentario != "") {
                        $query = "INSERT INTO comentarios_mp_np(id_mp_np, id_usuario, comentario, fecha, activo) VALUES($idMax, $idUsuario, '$comentario', '$fechaActual', 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $resp = 2;
                        }
                    } else {
                        $resp = 2;
                    }
                }
            }
        }
        echo json_encode($resp);
    }


    // AGREGA INCIDENCIAS EN ENERGETICOS
    if ($action == "agregarEnergetico") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $titulo = $_GET['titulo'];
        $rangoFecha = $_GET['rangoFecha'];
        $responsable = $_GET['responsable'];
        $comentario = $_GET['comentario'];
        $tipo = $_GET['tipo'];
        $resp = 0;

        $idMax = 0;
        $query = "SELECT max(id) 'id' FROM t_energeticos";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idMax = intval($x['id']) + 1;
            }
        }

        if ($idMax > 0) {
            $query = "INSERT INTO t_energeticos(id, id_destino, id_seccion, id_subseccion, actividad, creado_por, responsable, fecha_creacion, rango_fecha, tipo_incidencia, status, activo) VALUES($idMax, $idDestino, $idSeccion, $idSubseccion, '$titulo', $idUsuario, $responsable, '$fechaActual', '$rangoFecha', '$tipo', 'PENDIENTE', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
                if ($comentario != "") {
                    $query = "INSERT INTO t_energeticos_comentarios(id_energetico, creado_por, fecha_creado, comentario, activo) VALUES($idMax, $idUsuario, '$fechaActual', '$comentario', 1)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $resp = 2;
                    }
                }
            }
        }

        echo json_encode($resp);
    }


    // CONSULTAR PLANES PARA MIGRAR
    if ($action == "obtenerPlanesX") {
        $array = array();

        $query = "SELECT id, id_destino, periodicidad, id_tipo_equipo, notas FROM t_planes_mantto 
        WHERE id_destino = $idDestino and exportado = 'NO'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idPlan = $x['id'];
                $periodicidad = $x['periodicidad'];
                $idTipoEquipo = $x['id_tipo_equipo'];
                $notas = $x['notas'];

                if ($periodicidad == "Semanal") {
                    $idPeriodicidad = 1;
                } elseif ($periodicidad == "Mensual") {
                    $idPeriodicidad = 2;
                } elseif ($periodicidad == "Bimestral") {
                    $idPeriodicidad = 3;
                } elseif ($periodicidad == "Trimestral") {
                    $idPeriodicidad = 4;
                } elseif ($periodicidad == "Cuatrimestral") {
                    $idPeriodicidad = 5;
                } elseif ($periodicidad == "Semestral") {
                    $idPeriodicidad = 6;
                } elseif ($periodicidad == "Octamestral") {
                    $idPeriodicidad = 7;
                } elseif ($periodicidad == "Anual") {
                    $idPeriodicidad = 8;
                } elseif ($periodicidad == "Bianual") {
                    $idPeriodicidad = 9;
                } else {
                    $idPeriodicidad = 10;
                }

                $arrayActividades = array();
                $query = "SELECT actividad FROM t_planes_actividades WHERE id_mantto = $idPlan";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $actividad = $x['actividad'];
                        $arrayActividades[] = array(
                            "actividad" => $actividad
                        );
                    }
                }
                $array[] = array(
                    "idPlan" => intval($idPlan),
                    "periodicidad" => $idPeriodicidad,
                    "idTipoEquipo" => intval($idTipoEquipo),
                    "actividades" => $arrayActividades
                );

                $idPlanMax = 0;
                $query = "SELECT max(id) 'id' FROM t_mp_planes_mantenimiento";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idPlanMax = intval($x['id']) + 1;
                    }
                }

                if ($idPlanMax > 0) {

                    $query = "INSERT INTO t_mp_planes_mantenimiento(id, id_fase, local_equipo, tipo_local_equipo, tipo_plan, grado, id_periodicidad, id_destino, descripcion, numero_personas_requeridas, creado_por, fecha_creado, status, activo) 
                    VALUES($idPlanMax, 3, 'EQUIPO', $idTipoEquipo, 'PREVENTIVO', 'MAYOR', $idPeriodicidad, $idDestino, '$notas', 1, $idUsuario, '$fechaActual', 'ACTIVO', 1)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $query = "SELECT actividad FROM t_planes_actividades 
                        WHERE id_mantto = $idPlan";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $actividad = $x['actividad'];

                                $query = "INSERT INTO t_mp_planes_actividades_preventivos(tipo_actividad, id_plan, descripcion_actividad, promedio_ejecucion, creado_por, fecha_creado, status, activo) VALUES('actividad', $idPlanMax, '$actividad', 1.0, $idUsuario, '$fechaActual', 'ACTIVO', 1)";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    $query = "UPDATE t_planes_mantto SET exportado = 'SI' 
                                    WHERE id = $idPlan";
                                    if ($result = mysqli_query($conn_2020, $query)) {
                                        $resp = 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        echo json_encode($array);
    }


    // OBTIENE INFORMACION DE LAS INCIDENCIAS PARA VER EN PLANNER
    if ($action == "obtenerIncidencia") {
        $idIncidencia = $_GET['idIncidencia'];
        $array = array();

        $query = "SELECT t_mc.id, t_mc.actividad, t_mc.status, responsable, ";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {

                $array = array(
                    "idIncidencia" => intval($x['id']),
                    "tipo" => $x['tipo'],
                );
            }
        }
        echo json_encode($array);
    }


    // OBTIENE INFORMACIÓN DE PLANACCION DE LOS PROYECTO PARA VER EN PLANNER
    if ($action == "obtenerPlanaccion") {
        $idPlanaccion = $_GET['idPlanaccion'];
        $array = array();

        $query = "SELECT t_proyectos_planaccion.id 'idPlanaccion', t_proyectos_planaccion.actividad 'planaccion', t_proyectos_planaccion.rango_fecha , t_proyectos.id 'idProyecto', t_proyectos.titulo 'proyecto', t_proyectos.tipo, c_secciones.id 'idSeccion', c_subsecciones.id 'idSubseccion', t_proyectos_planaccion.responsable,
        t_proyectos_planaccion.fecha_creacion, t_proyectos_planaccion.rango_fecha, 
        t_colaboradores.nombre, t_colaboradores.apellido,
        t_proyectos_planaccion.status_material,
        t_proyectos_planaccion.status_trabajando,
        t_proyectos_planaccion.departamento_calidad,
        t_proyectos_planaccion.departamento_compras,
        t_proyectos_planaccion.departamento_direccion,
        t_proyectos_planaccion.departamento_finanzas,
        t_proyectos_planaccion.departamento_rrhh,
        t_proyectos_planaccion.energetico_electricidad,
        t_proyectos_planaccion.energetico_agua,
        t_proyectos_planaccion.energetico_diesel,
        t_proyectos_planaccion.energetico_gas,
        t_proyectos_planaccion.status
        FROM t_proyectos_planaccion
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id
        INNER JOIN c_secciones  ON t_proyectos.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_proyectos.id_subseccion = c_subsecciones.id
        INNER JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos_planaccion.id = $idPlanaccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idPlanaccion = $x['idPlanaccion'];
                $idProyecto = $x['idProyecto'];
                $proyecto = $x['proyecto'];
                $tipoProyecto = $x['tipo'];
                $planaccion = $x['planaccion'];
                $idSeccion = $x['idSeccion'];
                $idSubseccion = $x['idSubseccion'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('Y-m-d');
                $creadoPor = $x['nombre'] . " " . $x['apellido'];
                $rangoFecha = $x['rango_fecha'];
                $status_material = $x['status_material'];
                $status_trabajando = $x['status_trabajando'];
                $departamento_calidad = $x['departamento_calidad'];
                $departamento_compras = $x['departamento_compras'];
                $departamento_direccion = $x['departamento_direccion'];
                $departamento_finanzas = $x['departamento_finanzas'];
                $departamento_rrhh = $x['departamento_rrhh'];
                $energetico_electricidad = $x['energetico_electricidad'];
                $energetico_agua = $x['energetico_agua'];
                $energetico_diesel = $x['energetico_diesel'];
                $energetico_gas = $x['energetico_gas'];
                $status = $x['status'];
                $responsables = $x['responsable'];

                #ACTIVIDADES DE PLANACCION
                $array['actividades'] = array();
                $query = "SELECT id, actividad, status FROM t_proyectos_planaccion_actividades WHERE id_planaccion = $idPlanaccion and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idActividad = $x['id'];
                        $actividad = $x['actividad'];
                        $status = $x['status'];

                        $array['actividades'][] = array(
                            "idActividad" => intval($idActividad),
                            "actividad" => $actividad,
                            "status" => $status
                        );
                    }
                }

                #ADJUNTOS
                $array['adjuntos'] = array();
                $query = "SELECT id, url_adjunto FROM t_proyectos_planaccion_adjuntos 
                WHERE id_actividad = $idPlanaccion and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idAdjunto = $x['id'];
                        $url = $x['url_adjunto'];
                        $tipo = pathinfo($url, PATHINFO_EXTENSION);

                        $array['adjuntos'][] = array(
                            "idAdjunto" => intval($idAdjunto),
                            "url" => $url,
                            "tipo" => $tipo
                        );
                    }
                }

                #COMENTARIOS
                $array['comentarios'] = array();
                $query = "SELECT t_proyectos_planaccion_comentarios.id, t_proyectos_planaccion_comentarios.comentario, 
                t_proyectos_planaccion_comentarios.fecha, t_colaboradores.nombre, 
                t_colaboradores.apellido
                FROM t_proyectos_planaccion_comentarios 
                INNER JOIN t_users ON t_proyectos_planaccion_comentarios.usuario = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_proyectos_planaccion_comentarios.id_actividad = $idPlanaccion and t_proyectos_planaccion_comentarios.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idComentario = $x['id'];
                        $comentario = $x['comentario'];
                        $fecha = $x['fecha'];
                        $nombre = $x['nombre'];
                        $apellido = $x['apellido'];

                        $array['comentarios'][] = array(
                            "idComentario" => intval($idComentario),
                            "comentario" => $comentario,
                            "fecha" => $fecha,
                            "nombre" => $nombre,
                            "apellido" => $apellido
                        );
                    }
                }

                #RESPONSABLES
                $array['responsables'] = array();
                $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id IN($responsables)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idResponsable = $x['id'];
                        $responsable = $x['nombre'] . " " . $x['apellido'];

                        $array['responsables'][] = array(
                            "idResponsable" => $idResponsable,
                            "responsable" => $responsable
                        );
                    }
                }

                $array = array(
                    "idPlanaccion" => intval($idPlanaccion),
                    "idProyecto" => intval($idProyecto),
                    "idSeccion" => intval($idSeccion),
                    "idSubseccion" => intval($idSubseccion),
                    "proyecto" => $proyecto,
                    "tipoProyecto" => $tipoProyecto,
                    "planaccion" => $planaccion,
                    "fechaCreacion" => $fechaCreacion,
                    "creadoPor" => $creadoPor,
                    "rangoFecha" => $rangoFecha,
                    "status_material" => intval($status_material),
                    "status_trabajando" => intval($status_trabajando),
                    "departamento_calidad" => intval($departamento_calidad),
                    "departamento_compras" => intval($departamento_compras),
                    "departamento_direccion" => intval($departamento_direccion),
                    "departamento_finanzas" => intval($departamento_finanzas),
                    "departamento_rrhh" => intval($departamento_rrhh),
                    "energetico_electricidad" => intval($energetico_electricidad),
                    "energetico_agua" => intval($energetico_agua),
                    "energetico_diesel" => intval($energetico_diesel),
                    "energetico_gas" => intval($energetico_gas),
                    "status" => $status,

                    "actividades" => $array['actividades'],
                    "adjuntos" => $array['adjuntos'],
                    "comentarios" => $array['comentarios'],
                    "responsables" => $array['responsables']
                );
            }
        }
        echo json_encode($array);
    }


    // AGREGA COMENTARIOS DE LOS PLANES DE ACCION
    if ($action == "agregarComentarioPlanaccion") {
        $idPlanaccion = $_GET['idPlanaccion'];
        $comentario = $_GET['comentario'];
        $resp = 0;

        $query = "INSERT INTO t_proyectos_planaccion_comentarios(id_actividad, comentario, usuario, fecha) VALUES($idPlanaccion, '$comentario', $idUsuario, '$fechaActual')";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // AGREGA ACTIVIDADES A LOS PLANES DE ACCION
    if ($action == "agregarActividadPlanaccion") {
        $idPlanaccion = $_GET['idPlanaccion'];
        $actividad = $_GET['actividad'];
        $resp = 0;

        $query = "INSERT INTO t_proyectos_planaccion_actividades(id_planaccion, actividad, status, creado_por, fecha_creado, activo) VALUES($idPlanaccion, '$actividad', 'PENDIENTE', $idUsuario, '$fechaActual', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // ACTUALIZAR LA INFORMACIÓN DE LOS PLANES DE ACCION EN PROYECTOS (ID, COLUMNA, VALOR)
    if ($action == "actualizarInfoPlanaccion") {
        $idPlanaccion = $_GET['idPlanaccion'];
        $columna = $_GET['columna'];
        $valor = $_GET['valor'];
        $resp = "";


        if ($columna == "rangoFecha") {
            $query = "UPDATE t_proyectos_planaccion SET rango_fecha = '$valor' 
            WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "rangoFecha";
            }
        } elseif ($columna == "status") {
            $query = "UPDATE t_proyectos_planaccion SET status = 'SOLUCIONADO', fecha_realizado = '$fechaActual' 
            WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "solucionado";
            }
        } elseif ($columna == "activo") {
            $query = "UPDATE t_proyectos_planaccion SET activo = 0 
            WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "eliminado";
            }
        } elseif ($columna == "actividad" and $valor != "") {
            $query = "UPDATE t_proyectos_planaccion SET actividad = '$valor'
            WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "actividad";
            }
        } elseif (
            $columna == "status_material" ||
            $columna == "status_trabajando" ||
            $columna == "departamento_calidad" ||
            $columna == "departamento_compras" ||
            $columna == "departamento_direccion" ||
            $columna == "departamento_finanzas" ||
            $columna == "departamento_rrhh" ||
            $columna == "energetico_electricidad" ||
            $columna == "energetico_agua" ||
            $columna == "energetico_diesel" ||
            $columna == "energetico_gas" ||
            $columna == "activo" ||
            $columna == "bitacora_gp" ||
            $columna == "bitacora_trs" ||
            $columna == "bitacora_zi"
        ) {
            $valorX = 1;
            $query = "SELECT $columna FROM t_proyectos_planaccion WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valorX = $x[$columna];
                }
            }

            if ($valorX == 1) {
                $valorX = 0;
            } else {
                $valorX = 1;
            }


            if ($columna == "status_material") {
                $query = "UPDATE t_proyectos_planaccion 
                SET status_material = $valorX, cod2bend = '$valor' 
                WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "material";
                }
            } elseif ($columna == "status_trabajando") {
                $query = "UPDATE t_proyectos_planaccion 
                SET status_trabajando = $valorX 
                WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "material";
                }
            } elseif ($columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh") {
                $query = "UPDATE t_proyectos_planaccion 
                SET $columna = $valorX
                WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "departamento";
                }
            } elseif (
                $columna == "energetico_electricidad" || $columna == "energetico_agua"
                ||  $columna == "energetico_diesel" || $columna == "energetico_gas"
            ) {
                $query = "UPDATE t_proyectos_planaccion 
                SET $columna = $valorX
                WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "energetico";
                }
            } elseif ($columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
                $query = "UPDATE t_proyectos_planaccion 
                SET $columna = $valorX
                WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "bitacora";
                }
            }
        }

        echo json_encode($resp);
    }


    // AGREGA ADJUNTOS EN LOS PLANES DE ACCION
    if ($action == "agregarAdjuntoPlanaccion") {
        $idPlanaccion = $_GET['idPlanaccion'];
        $resp = 0;

        // VARIABLES DEL ADJUNTO
        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $nombre = 'PLANACCION_ID_' . $idPlanaccion . '_' . rand(50, 1500) . '.' . $extension;

        if (move_uploaded_file($rutaTemporal, '../planner/proyectos/planaccion/' . $nombre)) {
            $query = "INSERT INTO t_proyectos_planaccion_adjuntos(id_actividad, url_adjunto, subido_por, fecha_creado, status) VALUES($idPlanaccion, '$nombre', $idUsuario, '$fechaActual', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }


    // ACTUALIZA LA INFORMACIÓN DE LAS ACTIVIDADES DEL PLAN DE ACCIÓN
    if ($action == "actualizarActividadesPlanaccion") {
        $idActividad = $_GET['idActividad'];
        $columna = $_GET['columna'];
        $valor = $_GET['valor'];
        $resp = "NO";

        if ($columna == "titulo" and $valor != "") {
            $query = "UPDATE t_proyectos_planaccion_actividades SET actividad = '$valor' 
            WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "titulo";
            }
        } elseif ($columna == "eliminar") {
            $query = "UPDATE t_proyectos_planaccion_actividades SET activo = 0 
            WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "eliminar";
            }
        }
        echo json_encode($resp);
    }


    // OBTIENE LAS INCIDENCIAS EN T_MC
    if ($action == "obtenerIncidenciaEquipos") {
        $idIncidencia = $_GET['idIncidencia'];
        $array = array();

        $query = "SELECT t_mc.id, t_mc.actividad, t_mc.tipo_incidencia, t_mc.status,
        t_equipos_america.id 'idEquipo', t_equipos_america.equipo, t_colaboradores.nombre, t_colaboradores.apellido, t_mc.tipo_incidencia, t_mc.fecha_creacion, t_mc.rango_fecha, t_mc.responsable,
        t_mc.status_material,
        t_mc.status_trabajare,
        t_mc.departamento_calidad,
        t_mc.departamento_compras,
        t_mc.departamento_direccion,
        t_mc.departamento_finanzas,
        t_mc.departamento_rrhh,
        t_mc.energetico_electricidad,
        t_mc.energetico_agua,
        t_mc.energetico_diesel,
        t_mc.energetico_gas
        FROM t_mc 
        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id 
        INNER JOIN t_users ON t_mc.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
        WHERE t_mc.id = $idIncidencia";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idIncidencia = $x['id'];
                $actividad = $x['actividad'];
                $equipo = $x['equipo'];
                $idEquipo = $x['idEquipo'];
                $fecha = (new DateTime($x['fecha_creacion']))->format('Y-m-d');
                $rangoFecha = $x['rango_fecha'];
                $creadoPor = $x['nombre'] . " " . $x['apellido'];
                $tipoIncidencia = $x['tipo_incidencia'];
                $responsable = $x['responsable'];
                $status_material = $x['status_material'];
                $status_trabajare = $x['status_trabajare'];
                $departamento_calidad = $x['departamento_calidad'];
                $departamento_compras = $x['departamento_compras'];
                $departamento_direccion = $x['departamento_direccion'];
                $departamento_finanzas = $x['departamento_finanzas'];
                $departamento_rrhh = $x['departamento_rrhh'];
                $energetico_electricidad = $x['energetico_electricidad'];
                $energetico_agua = $x['energetico_agua'];
                $energetico_diesel = $x['energetico_diesel'];
                $energetico_gas = $x['energetico_gas'];

                #RESPONSABLE 
                $nombreResponsable = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $responsable";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $nombreResponsable = $x['nombre'] . " " . $x['apellido'];
                    }
                }

                #VALIDACION DE RANO FECHA
                if ($rangoFecha == "") {
                    $rangoFecha = "Sin Fecha Asignada";
                }

                $array['incidencia'][] = array(
                    "idIncidencia" => intval($idIncidencia),
                    "actividad" => $actividad,
                    "equipo" => $equipo,
                    "idEquipo" => intval($idEquipo),
                    "fecha" => $fecha,
                    "rangoFecha" => $rangoFecha,
                    "creadoPor" => $creadoPor,
                    "tipoIncidencia" => $tipoIncidencia,
                    "nombreResponsable" => $nombreResponsable,
                    "status_material" => intval($status_material),
                    "status_trabajare" => intval($status_trabajare),
                    "departamento_calidad" => intval($departamento_calidad),
                    "departamento_compras" => intval($departamento_compras),
                    "departamento_direccion" => intval($departamento_direccion),
                    "departamento_finanzas" => intval($departamento_finanzas),
                    "departamento_rrhh" => intval($departamento_rrhh),
                    "energetico_electricidad" => intval($energetico_electricidad),
                    "energetico_agua" => intval($energetico_agua),
                    "energetico_diesel" => intval($energetico_diesel),
                    "energetico_gas" => intval($energetico_gas)
                );

                #COMENTARIOS
                $array['comentarios'] = array();
                $query = "SELECT t_mc_comentarios.id, t_mc_comentarios.comentario, t_mc_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_mc_comentarios 
                INNER JOIN t_users ON t_mc_comentarios.id_usuario = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                WHERE t_mc_comentarios.id_mc = $idIncidencia and t_mc_comentarios.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idComentario = $x['id'];
                        $comentario = $x['comentario'];
                        $nombre = $x['nombre'];
                        $apellido = $x['apellido'];
                        $fecha = $x['fecha'];

                        $array['comentarios'][] = array(
                            "idComentario" => intval($idComentario),
                            "comentario" => $comentario,
                            "nombre" => $nombre,
                            "apellido" => $apellido,
                            "fecha" => $fecha
                        );
                    }
                }

                #ADJUNTOS
                $array['adjuntos'] = array();
                $query = "SELECT t_mc_adjuntos.id, t_mc_adjuntos.url_adjunto, t_mc_adjuntos.fecha FROM t_mc_adjuntos 
                WHERE t_mc_adjuntos.id_mc = $idIncidencia and t_mc_adjuntos.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idAdjunto = $x['id'];
                        $url = $x['url_adjunto'];
                        $extension = pathinfo($url, PATHINFO_EXTENSION);

                        $array['adjuntos'][] = array(
                            "idAdjunto" => intval($idAdjunto),
                            "url" => $url,
                            "extension" => $extension
                        );
                    }
                }

                #ACTIVIDADES
                $array['actividades'] = array();
                $query = "SELECT id, actividad, status FROM t_mc_actividades_ot 
                WHERE id_falla = $idIncidencia and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idActividad = $x['id'];
                        $actividad = $x['actividad'];
                        $status = $x['status'];

                        $array['actividades'][] = array(
                            "idActividad" => intval($idActividad),
                            "actividad" => $actividad,
                            "status" => $status
                        );
                    }
                }
            }
        }
        echo json_encode($array);
    }


    // OBTIENE LAS INCIDENCIAS EN T_MC
    if ($action == "obtenerIncidenciaGeneral") {
        $idIncidencia = $_GET['idIncidencia'];
        $array = array();

        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.tipo_incidencia, t_mp_np.status,
        t_colaboradores.nombre, t_colaboradores.apellido, t_mp_np.tipo_incidencia, 
        t_mp_np.fecha_finalizado, t_mp_np.rango_fecha, t_mp_np.responsable,
        t_mp_np.id_seccion, t_mp_np.id_subseccion,
        t_mp_np.status_material,
        t_mp_np.status_trabajando,
        t_mp_np.departamento_calidad,
        t_mp_np.departamento_compras,
        t_mp_np.departamento_direccion,
        t_mp_np.departamento_finanzas,
        t_mp_np.departamento_rrhh,
        t_mp_np.energetico_electricidad,
        t_mp_np.energetico_agua,
        t_mp_np.energetico_diesel,
        t_mp_np.energetico_gas
        FROM t_mp_np 
        INNER JOIN t_users ON t_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
        WHERE t_mp_np.id = $idIncidencia";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idIncidencia = $x['id'];
                $actividad = $x['titulo'];
                $fecha = (new DateTime($x['fecha_finalizado']))->format('Y-m-d');
                $rangoFecha = $x['rango_fecha'];
                $creadoPor = $x['nombre'] . " " . $x['apellido'];
                $tipoIncidencia = $x['tipo_incidencia'];
                $responsable = $x['responsable'];
                $status_material = $x['status_material'];
                $status_trabajando = $x['status_trabajando'];
                $departamento_calidad = $x['departamento_calidad'];
                $departamento_compras = $x['departamento_compras'];
                $departamento_direccion = $x['departamento_direccion'];
                $departamento_finanzas = $x['departamento_finanzas'];
                $departamento_rrhh = $x['departamento_rrhh'];
                $energetico_electricidad = $x['energetico_electricidad'];
                $energetico_agua = $x['energetico_agua'];
                $energetico_diesel = $x['energetico_diesel'];
                $energetico_gas = $x['energetico_gas'];
                $idSeccion = $x['id_seccion'];
                $idSubseccion = $x['id_subseccion'];
                $idSubseccion = $x['id_subseccion'];

                #RESPONSABLE 
                $nombreResponsable = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $responsable";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $nombreResponsable = $x['nombre'] . " " . $x['apellido'];
                    }
                }

                #VALIDACION DE RANO FECHA
                if ($rangoFecha == "") {
                    $rangoFecha = "Sin Fecha Asignada";
                }

                $array['incidencia'][] = array(
                    "idIncidencia" => intval($idIncidencia),
                    "actividad" => $actividad,
                    "fecha" => $fecha,
                    "rangoFecha" => $rangoFecha,
                    "creadoPor" => $creadoPor,
                    "tipoIncidencia" => $tipoIncidencia,
                    "nombreResponsable" => $nombreResponsable,
                    "idSeccion" => intval($idSeccion),
                    "idSubseccion" => intval($idSubseccion),
                    "status_material" => intval($status_material),
                    "status_trabajando" => intval($status_trabajando),
                    "departamento_calidad" => intval($departamento_calidad),
                    "departamento_compras" => intval($departamento_compras),
                    "departamento_direccion" => intval($departamento_direccion),
                    "departamento_finanzas" => intval($departamento_finanzas),
                    "departamento_rrhh" => intval($departamento_rrhh),
                    "energetico_electricidad" => intval($energetico_electricidad),
                    "energetico_agua" => intval($energetico_agua),
                    "energetico_diesel" => intval($energetico_diesel),
                    "energetico_gas" => intval($energetico_gas)
                );

                #COMENTARIOS
                $array['comentarios'] = array();
                $query = "SELECT comentarios_mp_np.id, comentarios_mp_np.comentario, comentarios_mp_np.fecha, t_colaboradores.nombre, t_colaboradores.apellido 
                FROM comentarios_mp_np 
                INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                WHERE comentarios_mp_np.id_mp_np = $idIncidencia and comentarios_mp_np.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idComentario = $x['id'];
                        $comentario = $x['comentario'];
                        $nombre = $x['nombre'];
                        $apellido = $x['apellido'];
                        $fecha = $x['fecha'];

                        $array['comentarios'][] = array(
                            "idComentario" => intval($idComentario),
                            "comentario" => $comentario,
                            "nombre" => $nombre,
                            "apellido" => $apellido,
                            "fecha" => $fecha
                        );
                    }
                }

                #ADJUNTOS
                $array['adjuntos'] = array();
                $query = "SELECT adjuntos_mp_np.id, adjuntos_mp_np.url, adjuntos_mp_np.fecha FROM adjuntos_mp_np
                WHERE adjuntos_mp_np.id_mp_np = $idIncidencia and adjuntos_mp_np.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idAdjunto = $x['id'];
                        $url = $x['url'];
                        $extension = pathinfo($url, PATHINFO_EXTENSION);

                        $array['adjuntos'][] = array(
                            "idAdjunto" => intval($idAdjunto),
                            "url" => $url,
                            "extension" => $extension
                        );
                    }
                }

                #ACTIVIDADES
                $array['actividades'] = array();
                $query = "SELECT id, actividad, status FROM t_mp_np_actividades_ot 
                WHERE id_tarea = $idIncidencia and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idActividad = $x['id'];
                        $actividad = $x['actividad'];
                        $status = $x['status'];

                        $array['actividades'][] = array(
                            "idActividad" => intval($idActividad),
                            "actividad" => $actividad,
                            "status" => $status
                        );
                    }
                }
            }
        }
        echo json_encode($array);
    }


    // TAREAS A INCIDENCIAS
    if ($action == "exportarTareasAIncidencias") {
        $resp = 0;
        $resp1 = 0;
        $resp2 = 0;

        $query = "SELECT* FROM t_mp_np WHERE id_destino = '$idDestino' and id_equipo > 0 and activo IN(1, 0)";
        // $query = "SELECT* FROM t_mp_np WHERE id = 16358";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $id = $x['id'];
                $id_equipo = $x['id_equipo'];
                $id_usuario = $x['id_usuario'];
                $id_destino = $x['id_destino'];
                $id_seccion = $x['id_seccion'];
                $id_subseccion = $x['id_subseccion'];
                $tipo_incidencia = $x['tipo_incidencia'];
                $titulo = $x['titulo'];
                $responsable = $x['responsable'];
                $fecha = $x['fecha'];
                $fecha_finalizado = $x['fecha_finalizado'];
                $rango_fecha = $x['rango_fecha'];
                $status = $x['status'];
                $status_urgente = $x['status_urgente'];
                $status_material = $x['status_material'];
                $status_trabajando = $x['status_trabajando'];
                $energetico_electricidad = $x['energetico_electricidad'];
                $energetico_agua = $x['energetico_agua'];
                $energetico_diesel = $x['energetico_diesel'];
                $energetico_gas = $x['energetico_gas'];
                $departamento_calidad = $x['departamento_calidad'];
                $departamento_compras = $x['departamento_compras'];
                $departamento_direccion = $x['departamento_direccion'];
                $departamento_finanzas = $x['departamento_finanzas'];
                $departamento_rrhh = $x['departamento_rrhh'];
                $cod2bend = $x['cod2bend'];
                $codsap = $x['codsap'];
                $bitacora_gp = $x['bitacora_gp'];
                $bitacora_trs = $x['bitacora_trs'];
                $bitacora_zi = $x['bitacora_zi'];
                $activo = $x['activo'];

                $idMax = 0;
                $query = "SELECT max(id) 'id' FROM t_mc";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idMax = intval($x['id']) + 1;
                    }
                }

                if ($idMax > 0) {
                    $query = "INSERT INTO t_mc(id, id_tarea, id_equipo, actividad, tipo_incidencia, status, creado_por, responsable, fecha_inicio, fecha_realizado, realizado_por, fecha_creacion, ultima_modificacion, id_destino, id_seccion, id_subseccion, id_categoria, id_subcategoria, semana_inicio, semana_fin, fecha_fin, rango_fecha, compartir, status_default, status_material, status_trabajare, status_urgente, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, zona, cod2bend, codsap, bitacora_gp, bitacora_trs, bitacora_zi, activo)  
                    VALUES('$idMax','$id','$id_equipo','$titulo','$tipo_incidencia','$status','$id_usuario','$responsable','$fecha','$fecha_finalizado','$responsable','$fecha','$fechaActual','$id_destino','$id_seccion','$id_subseccion','0','0','0','0','$fecha_finalizado','$rango_fecha','','0','$status_material','$status_trabajando','$status_urgente','$departamento_calidad','$departamento_compras','$departamento_direccion','$departamento_finanzas','$departamento_rrhh','$energetico_electricidad','$energetico_agua','$energetico_diesel','$energetico_gas','NA','$cod2bend','$codsap','$bitacora_gp','$bitacora_trs','$bitacora_zi','$activo'
                    )";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $query = "UPDATE t_mp_np SET activo = 2 WHERE id = $id";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $resp++;

                            $query = "SELECT* FROM adjuntos_mp_np 
                            WHERE id_mp_np = $id and activo = 1";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idUsuario = $x['id'];
                                    $id_mp_np = $x['id_mp_np'];
                                    $url = $x['url'];
                                    $fecha = $x['fecha'];
                                    $activo = $x['activo'];

                                    $query = "INSERT INTO t_mc_adjuntos(id_mc, url_adjunto, fecha, subido_por, activo) VALUES($idMax, '$url', '$fecha', '$idUsuario', $activo)";
                                    if ($result = mysqli_query($conn_2020, $query)) {
                                        $resp1 = "adjunto";
                                    }
                                }
                            }

                            $query = "SELECT* FROM comentarios_mp_np 
                            WHERE id_mp_np = $id and activo = 1";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $id_mp_np = $x['id_mp_np'];
                                    $id_usuario = $x['id_usuario'];
                                    $comentario = $x['comentario'];
                                    $fecha = $x['fecha'];
                                    $activo = $x['activo'];

                                    $query = "INSERT INTO t_mc_comentarios(id_mc, comentario, id_usuario, fecha, activo) VALUES($idMax, '$comentario', $id_usuario, '$fecha', $activo)";
                                    if ($result = mysqli_query($conn_2020, $query)) {
                                        $resp2 = "comentario";
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        echo json_encode($resp);
    }


    // AGREGA ACTIVIDADES EN INCIDENCIAS
    if ($action == "agregarActividadesIncidencias") {
        $idIncidencia = $_GET['idIncidencia'];
        $actividad = $_GET['actividad'];
        $resp = 0;

        $query = "INSERT INTO t_mc_actividades_ot(id_falla, actividad, status, activo) VALUES($idIncidencia, '$actividad', 'SOLUCIONADO', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // AGREGA ACTIVIDADES EN INCIDENCIAS
    if ($action == "agregarActividadesIncidenciaGeneral") {
        $idIncidencia = $_GET['idIncidencia'];
        $actividad = $_GET['actividad'];
        $resp = 0;

        $query = "INSERT INTO t_mp_np_actividades_ot(id_tarea, actividad, status, activo) VALUES($idIncidencia, '$actividad', 'SOLUCIONADO', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // AGREGA COMENTARIOS EN INCIDENCIAS
    if ($action == "agregarComentarioIncidencia") {
        $idIncidencia = $_GET['idIncidencia'];
        $comentario = $_GET['comentario'];
        $resp = 0;

        $query = "INSERT INTO t_mc_comentarios(id_mc, comentario, id_usuario, fecha, activo) VALUES($idIncidencia, '$comentario', $idUsuario, '$fechaActual', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // AGREGA COMENTARIOS EN INCIDENCIAS
    if ($action == "agregarComentarioIncidenciaGeneral") {
        $idIncidencia = $_GET['idIncidencia'];
        $comentario = $_GET['comentario'];
        $resp = 0;

        $query = "INSERT INTO comentarios_mp_np(id_mp_np, id_usuario,comentario,  fecha, activo) VALUES($idIncidencia, $idUsuario, '$comentario', '$fechaActual', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // OBTIENE LOS PENDIENTES TRABAJANDO DE MP
    if ($action == "obtenerPendientesMP") {
        $idSeccion = $_GET['idSeccion'];
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_equipos_america.id_destino = $idDestino";
        }

        // SECCIONES Y SUBSECCIONES
        $array['secciones'] = array();
        $query = "SELECT c_secciones.id, c_secciones.seccion 
        FROM c_rel_destino_seccion
        INNER JOIN c_secciones  ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino and c_secciones.id = $idSeccion
        ORDER BY c_secciones.seccion ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSeccion = $x['id'];
                $seccion = $x['seccion'];

                $array['secciones'][] = array(
                    "idSeccion" => intval($idSeccion),
                    "seccion" => $seccion
                );

                $array['subsecciones'] = array();
                $query = "SELECT id, grupo 
                FROM c_subsecciones WHERE id_seccion = $idSeccion
                ORDER BY grupo ASC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idSubseccion = $x['id'];
                        $subseccion = $x['grupo'];

                        $array['subsecciones'][] = array(
                            "idSubseccion" => intval($idSubseccion),
                            "subseccion" => $subseccion
                        );
                    }
                }

                $array['mp'] = array();
                $query = "SELECT id, grupo 
                FROM c_subsecciones WHERE id_seccion = $idSeccion
                ORDER BY grupo ASC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idSubseccion = $x['id'];
                        $subseccion = $x['grupo'];

                        #OBTIENES LOS TRABAJANDO MP
                        #DATOS PARA OT: idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP
                        $query = "SELECT t_mp_planificacion_iniciada.id, t_mp_planes_mantenimiento.tipo_plan, t_mp_planificacion_iniciada.comentario, t_mp_planificacion_iniciada.id_equipo, t_mp_planificacion_iniciada.semana, t_mp_planificacion_iniciada.id_plan, t_mp_planificacion_iniciada.fecha_creacion, t_mp_planificacion_iniciada.status, 
                        t_mp_planificacion_iniciada.status_trabajando,
                        t_mp_planificacion_iniciada.departamento_calidad,
                        t_mp_planificacion_iniciada.departamento_compras,
                        t_mp_planificacion_iniciada.departamento_direccion,
                        t_mp_planificacion_iniciada.departamento_finanzas,
                        t_mp_planificacion_iniciada.departamento_rrhh,
                        t_mp_planificacion_iniciada.status_material,
                        t_mp_planificacion_iniciada.cod2bend,
                        t_mp_planificacion_iniciada.id_responsables, t_equipos_america.equipo, c_destinos.destino, t_colaboradores.nombre, t_colaboradores.apellido
                        FROM t_mp_planificacion_iniciada
                        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                        INNER JOIN t_users ON t_mp_planificacion_iniciada.creado_por = t_users.id
                        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
                        INNER JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
                        WHERE t_mp_planificacion_iniciada.activo = 1 
                        and (t_mp_planificacion_iniciada.status = 'PROCESO' or (t_mp_planificacion_iniciada.status = 'SOLUCIONADO')) 
                        and t_equipos_america.id_subseccion = $idSubseccion $filtroDestino
                        ORDER BY t_mp_planificacion_iniciada.id ASC";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $idMP = $x['id'];
                                $tipoPlan = $x['tipo_plan'];
                                $comentario = $x['comentario'];
                                $creadoPor = strtok($x['nombre'], ' ') . " " .
                                    strtok($x['apellido'], ' ');
                                $idResponsable = $x['id_responsables'];
                                $fecha = (new DateTime($x['fecha_creacion']))->format('Y-m-d');
                                $equipo = $x['equipo'];
                                $destino = $x['destino'];
                                $status = $x['status'];
                                $sTrabajando = $x['status_trabajando'];
                                $sCalidad = intval($x['departamento_calidad']);
                                $sCompras = intval($x['departamento_compras']);
                                $sDireccion = intval($x['departamento_direccion']);
                                $sFinanzas = intval($x['departamento_finanzas']);
                                $sRRHH = intval($x['departamento_rrhh']);
                                $sMaterial = intval($x['status_material']);
                                $cod2bend = $x['cod2bend'];

                                #DATOS PARA ABRIR OT
                                $idEquipo = $x['id_equipo'];
                                $idPlan = $x['id_plan'];
                                $semana = $x['semana'];

                                #ADJUNTOS
                                $totalAdjuntos = 0;
                                $query = "SELECT count(id) 'id' FROM t_mp_planificacion_iniciada_adjuntos 
                                WHERE id_planificacion_iniciada = $idMP and activo = 1";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $totalAdjuntos = $x['id'];
                                    }
                                }

                                #RESPONSABLE
                                $responsable = "";
                                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido FROM t_users
                                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                                WHERE t_users.id IN($idResponsable)";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $responsable = strtok($x['nombre'], ' ') . " " .
                                            strtok($x['apellido'], ' ');
                                    }
                                }

                                #DATOS
                                $array['mp'][] = array(
                                    "idMP" => intval($idMP),
                                    "tipoPlan" => $tipoPlan,
                                    "creadoPor" => $creadoPor,
                                    "responsable" => $responsable,
                                    "comentario" => $comentario,
                                    "fecha" => $fecha,
                                    "adjuntos" => intval($totalAdjuntos),
                                    "idSubseccion" => intval($idSubseccion),
                                    "subseccion" => $subseccion,
                                    "equipo" => $equipo,
                                    "destino" => $destino,
                                    "idEquipo" => $idEquipo,
                                    "idPlan" => $idPlan,
                                    "semana" => $semana,
                                    "status" => $status,
                                    "sTrabajando" => intval($sTrabajando),
                                    "sCalidad" => intval($sCalidad),
                                    "sCompras" => intval($sCompras),
                                    "sDireccion" => intval($sDireccion),
                                    "sFinanzas" => intval($sFinanzas),
                                    "sRRHH" => intval($sRRHH),
                                    "sMaterial" => intval($sMaterial),
                                    "cod2bend" => $cod2bend
                                );
                            }
                        }
                    }
                }
            }
        }


        echo json_encode($array);
    }


    // OBTIENE LOS PENDIENTES TRABAJANDO DE MP
    if ($action == "obtenerPendientesIncidencias") {
        $idSeccion = $_GET['idSeccion'];
        $tipoBusqueda = $_GET['tipoBusqueda'];
        $rango = date("Y-m-d", strtotime($fechaActual . "- 10 days"));
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
            $filtroDestinoIG = "";
        } else {
            $filtroDestino = "and t_mc.id_destino = $idDestino";
            $filtroDestinoIG = "and t_mp_np.id_destino = $idDestino";
        }


        if ($tipoBusqueda == "MISPENDIENTES") {
            $filtroIncidenciasTipoBusqueda = "and t_mc.responsable = $idUsuario";
            $filtroIncidenciasGTipoBusqueda = "and t_mp_np.responsable = $idUsuario";
        } elseif ($tipoBusqueda == "MISCREADOS") {
            $filtroIncidenciasTipoBusqueda = "and t_mc.creado_por = $idUsuario";
            $filtroIncidenciasGTipoBusqueda = "and t_mp_np.id_usuario = $idUsuario";
        } elseif ($tipoBusqueda == "SINASIGNAR") {
            $filtroIncidenciasTipoBusqueda = "and t_mc.responsable = 0";
            $filtroIncidenciasGTipoBusqueda = "and t_mp_np.responsable = 0";
        } else {
            $filtroIncidenciasTipoBusqueda = "";
            $filtroIncidenciasGTipoBusqueda = "";
        }

        // SECCIONES Y SUBSECCIONES
        $array['secciones'] = array();
        $query = "SELECT c_secciones.id, c_secciones.seccion 
        FROM c_rel_destino_seccion
        INNER JOIN c_secciones  ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino and c_secciones.id = $idSeccion
        ORDER BY c_secciones.seccion ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSeccion = $x['id'];
                $seccion = $x['seccion'];

                $array['secciones'][] = array(
                    "idSeccion" => intval($idSeccion),
                    "seccion" => $seccion
                );

                $array['subsecciones'] = array();
                $query = "SELECT id, grupo 
                FROM c_subsecciones WHERE id_seccion = $idSeccion
                ORDER BY grupo ASC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idSubseccion = $x['id'];
                        $subseccion = $x['grupo'];

                        $array['subsecciones'][] = array(
                            "idSubseccion" => intval($idSubseccion),
                            "subseccion" => $subseccion
                        );
                    }
                }

                $array['mp'] = array();
                $query = "SELECT id, grupo 
                FROM c_subsecciones WHERE id_seccion = $idSeccion
                ORDER BY grupo ASC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idSubseccion = $x['id'];
                        $subseccion = $x['grupo'];

                        // INCIDENCIAS DE EQUIPOS
                        $query = "SELECT t_mc.id, t_mc.actividad, t_mc.tipo_incidencia, t_mc.status, t_mc.responsable, t_mc.fecha_creacion, t_mc.rango_fecha,
                        t_mc.status_trabajare, t_mc.departamento_calidad, t_mc.status_material,
                        t_mc.departamento_compras, t_mc.departamento_direccion, 
                        t_mc.departamento_finanzas, t_mc.departamento_rrhh, t_mc.cod2bend, t_colaboradores.nombre, t_colaboradores.apellido, c_destinos.destino
                        FROM t_mc
                        INNER JOIN t_users ON t_mc.creado_por = t_users.id
                        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                        INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id
                        WHERE t_mc.id_seccion = $idSeccion and t_mc.id_subseccion = $idSubseccion 
                        and t_mc.activo = 1 and ((t_mc.status IN('N', 'PENDIENTE', 'P')) or 
                        (t_mc.fecha_realizado BETWEEN '$rango' and '$fechaActual' 
                        and t_mc.status IN('SOLUCIONADO', 'F'))) 
                        $filtroDestino $filtroIncidenciasTipoBusqueda
                        ORDER BY t_mc.id ASC";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $idIncidencia = $x['id'];
                                $actividad = $x['actividad'];
                                $tipoIncidencia = $x['tipo_incidencia'];
                                $creadoPor = strtok($x['nombre'], ' ') . " " .
                                    strtok($x['apellido'], ' ');
                                $idResponsable = $x['responsable'];
                                $fecha = (new DateTime($x['fecha_creacion']))->format('Y-m-d');
                                $destino = $x['destino'];
                                $status = $x['status'];
                                $sTrabajando = $x['status_trabajare'];
                                $sCalidad = intval($x['departamento_calidad']);
                                $sCompras = intval($x['departamento_compras']);
                                $sDireccion = intval($x['departamento_direccion']);
                                $sFinanzas = intval($x['departamento_finanzas']);
                                $sRRHH = intval($x['departamento_rrhh']);
                                $sMaterial = ($x['status_material']);
                                $cod2bend = $x['cod2bend'];

                                if ($status == "N" or $status == "P" or $status == "PENDIENTE") {
                                    $status = "PENDIENTE";
                                } else {
                                    $status = "SOLUCIONADO";
                                }

                                #ADJUNTOS
                                $totalAdjuntos = 0;
                                $query = "SELECT count(id) 'id' FROM t_mc_adjuntos 
                                WHERE id_mc = $idIncidencia and activo = 1";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $totalAdjuntos = $x['id'];
                                    }
                                }

                                #ULTIMO COMENTARIOS
                                $comentario = "";
                                $nombreComentario = "";
                                $fechaComentario = "";
                                $query = "SELECT t_mc_comentarios.comentario, t_mc_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido 
                                FROM t_mc_comentarios
                                INNER JOIN t_users ON t_mc_comentarios.id_usuario = t_users.id
                                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                                WHERE t_mc_comentarios.id_mc = $idIncidencia and t_mc_comentarios.activo = 1 ORDER BY t_mc_comentarios.id ASC LIMIT 1";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $comentario = $x['comentario'];
                                        $fechaComentario =
                                            (new DateTime($x['fecha']))->format('Y-m-d');
                                        $nombreComentario = strtok($x['nombre'], ' ') .
                                            " " . strtok($x['apellido'], ' ');
                                    }
                                }

                                #RESPONSABLE
                                $responsable = "";
                                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido FROM t_users
                                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                                WHERE t_users.id IN($idResponsable)";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $responsable = strtok($x['nombre'], ' ') . " " .
                                            strtok($x['apellido'], ' ');
                                    }
                                }

                                #DATOS
                                $array['incidencias'][] = array(
                                    "idIncidencia" => intval($idIncidencia),
                                    "actividad" => $actividad,
                                    "tipoIncidencia" => $tipoIncidencia,
                                    "creadoPor" => $creadoPor,
                                    "responsable" => $responsable,
                                    "comentario" => $comentario,
                                    "nombreComentario" => $nombreComentario,
                                    "fechaComentario" => $fechaComentario,
                                    "fecha" => $fecha,
                                    "adjuntos" => intval($totalAdjuntos),
                                    "idSubseccion" => intval($idSubseccion),
                                    "subseccion" => $subseccion,
                                    "destino" => $destino,
                                    "status" => $status,
                                    "sCalidad" => intval($sCalidad),
                                    "sCompras" => intval($sCompras),
                                    "sDireccion" => intval($sDireccion),
                                    "sFinanzas" => intval($sFinanzas),
                                    "sRRHH" => intval($sRRHH),
                                    "sTrabajando" => intval($sTrabajando),
                                    "sMaterial" => intval($sMaterial),
                                    "cod2bend" => $cod2bend,
                                    "tipo" => "F"
                                );
                            }
                        }

                        // INCIDENCIAS GENERALES
                        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.tipo_incidencia, t_mp_np.status, t_mp_np.responsable, t_mp_np.fecha, t_mp_np.rango_fecha,
                        t_mp_np.status_trabajando, t_mp_np.departamento_calidad, 
                        t_mp_np.status_material, t_mp_np.departamento_compras, 
                        t_mp_np.departamento_direccion, t_mp_np.departamento_finanzas, 
                        t_mp_np.departamento_rrhh, t_colaboradores.nombre, 
                        t_colaboradores.apellido, c_destinos.destino
                        FROM t_mp_np
                        INNER JOIN t_users ON t_mp_np.id_usuario = t_users.id
                        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                        INNER JOIN c_destinos ON t_mp_np.id_destino = c_destinos.id
                        WHERE t_mp_np.id_seccion = $idSeccion and t_mp_np.id_subseccion = $idSubseccion 
                        and t_mp_np.activo = 1 and ((t_mp_np.status IN('N', 'PENDIENTE', 'P')) or 
                        (t_mp_np.fecha_finalizado BETWEEN '$rango' and '$fechaActual' 
                        and t_mp_np.status IN('SOLUCIONADO', 'F'))) 
                        $filtroIncidenciasGTipoBusqueda $filtroDestinoIG
                        ORDER BY t_mp_np.id ASC";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $idIncidencia = $x['id'];
                                $actividad = $x['titulo'];
                                $tipoIncidencia = $x['tipo_incidencia'];
                                $creadoPor = strtok($x['nombre'], ' ') . " " .
                                    strtok($x['apellido'], ' ');
                                $idResponsable = $x['responsable'];
                                $fecha = (new DateTime($x['fecha']))->format('Y-m-d');
                                $destino = $x['destino'];
                                $status = $x['status'];
                                $sTrabajando = $x['status_trabajando'];
                                $sDEP = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']) + intval($x['status_material']);

                                if ($status == "N" or $status == "P" or $status == "PENDIENTE") {
                                    $status = "PENDIENTE";
                                } else {
                                    $status = "SOLUCIONADO";
                                }

                                #ADJUNTOS
                                $totalAdjuntos = 0;
                                $query = "SELECT count(id) 'id' FROM adjuntos_mp_np 
                                WHERE id_mp_np = $idIncidencia and activo = 1";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $totalAdjuntos = $x['id'];
                                    }
                                }

                                #ULTIMO COMENTARIOS
                                $comentario = "";
                                $nombreComentario = "";
                                $fechaComentario = "";
                                $query = "SELECT comentarios_mp_np.comentario, comentarios_mp_np.fecha, t_colaboradores.nombre, t_colaboradores.apellido 
                                FROM comentarios_mp_np
                                INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
                                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                                WHERE comentarios_mp_np.id_mp_np = $idIncidencia and comentarios_mp_np.activo = 1 
                                ORDER BY comentarios_mp_np.id ASC LIMIT 1";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $comentario = $x['comentario'];
                                        $fechaComentario =
                                            (new DateTime($x['fecha']))->format('Y-m-d');
                                        $nombreComentario = strtok($x['nombre'], ' ') .
                                            " " . strtok($x['apellido'], ' ');
                                    }
                                }

                                #RESPONSABLE
                                $responsable = "";
                                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido FROM t_users
                                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                                WHERE t_users.id IN($idResponsable)";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $responsable = strtok($x['nombre'], ' ') . " " .
                                            strtok($x['apellido'], ' ');
                                    }
                                }

                                #DATOS
                                $array['incidencias'][] = array(
                                    "idIncidencia" => intval($idIncidencia),
                                    "actividad" => $actividad,
                                    "tipoIncidencia" => $tipoIncidencia,
                                    "creadoPor" => $creadoPor,
                                    "responsable" => $responsable,
                                    "comentario" => $comentario,
                                    "nombreComentario" => $nombreComentario,
                                    "fechaComentario" => $fechaComentario,
                                    "fecha" => $fecha,
                                    "adjuntos" => intval($totalAdjuntos),
                                    "idSubseccion" => intval($idSubseccion),
                                    "subseccion" => $subseccion,
                                    "destino" => $destino,
                                    "status" => $status,
                                    "sDEP" => intval($sDEP),
                                    "sTrabajando" => intval($sTrabajando),
                                    "tipo" => "T"
                                );
                            }
                        }
                    }
                }
            }
        }


        echo json_encode($array);
    }


    // ACTUALIZA LA INFORMACIÓN DE INCIDENCIAS (t_mc)
    if ($action == "actualizarStatusIncidencia") {
        $idIncidencia = $_GET['idIncidencia'];
        $columna = $_GET['columna'];
        $valor = $_GET['valor'];
        $resp = "error";
        $cod2bend = $_GET['cod2bend'];

        // BUSCA VALORES EN LOS STATUS PARA CREA EL TOGGLE
        if ($columna == "status_material" || $columna == "status_trabajare" || $columna == "status_urgente" || $columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh" || $columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas" || $columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $query = "SELECT $columna FROM t_mc WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valor = intval($x[$columna]);
                }
            }

            if ($valor == 0) {
                $valor = 1;
            } else {
                $valor = 0;
            }
        }

        if ($columna == "responsable") {
            $query = "UPDATE t_mc SET responsable = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "responsable";
            }
        } elseif ($columna == "titulo") {
            $query = "UPDATE t_mc SET actividad = '$valor' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "titulo";
            }
        } elseif ($columna == "status_trabajare") {
            $query = "UPDATE t_mc SET status_trabajare = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "trabajare";
            }
        } elseif ($columna == "status_material" and $cod2bend != "") {
            $query = "UPDATE t_mc SET status_material = $valor, cod2bend = '$cod2bend' 
            WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "material";
            }
        } elseif ($columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh") {
            $query = "UPDATE t_mc SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "departamento";
            }
        } elseif ($columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas") {
            $query = "UPDATE t_mc SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "energetico";
            }
        } elseif ($columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $query = "UPDATE t_mc SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "bitacora";
            }
        } elseif ($columna == "status") {
            $query = "UPDATE t_mc SET status = 'SOLUCIONADO', fecha_realizado = '$fechaActual' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "solucionado";
            }
        } elseif ($columna == "eliminar") {
            $query = "UPDATE t_mc SET activo = 0 WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "eliminado";
            }
        } elseif ($columna == "restaurar") {
            $query = "UPDATE t_mc SET status = 'PENDIENTE' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "restaurado";
            }
        } elseif ($columna == "rango_fecha" && $valor != "") {
            $query = "UPDATE t_mc SET rango_fecha = '$valor' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "rangoFecha";
            }
        }
        echo json_encode($resp);
    }


    // ACTUALIZA LA INFORMACIÓN DE INCIDENCIAS (t_mc)
    if ($action == "actualizarDatosIncidenciaGeneral") {
        $idIncidencia = $_GET['idIncidencia'];
        $columna = $_GET['columna'];
        $valor = $_GET['valor'];
        $resp = "error";
        $cod2bend = $_GET['cod2bend'];

        // BUSCA VALORES EN LOS STATUS PARA CREA EL TOGGLE
        if ($columna == "status_material" || $columna == "status_trabajando" || $columna == "status_urgente" || $columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh" || $columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas" || $columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $query = "SELECT $columna FROM t_mp_np WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valor = intval($x[$columna]);
                }
            }

            if ($valor == 0) {
                $valor = 1;
            } else {
                $valor = 0;
            }
        }

        if ($columna == "responsable") {
            $query = "UPDATE t_mp_np SET responsable = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "responsable";
            }
        } elseif ($columna == "titulo") {
            $query = "UPDATE t_mp_np SET titulo = '$valor' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "titulo";
            }
        } elseif ($columna == "status_trabajando") {
            $query = "UPDATE t_mp_np SET status_trabajando = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "trabajare";
            }
        } elseif ($columna == "status_material" and $cod2bend != "") {
            $query = "UPDATE t_mp_np SET status_material = $valor, cod2bend = '$cod2bend' 
            WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "material";
            }
        } elseif ($columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh") {
            $query = "UPDATE t_mp_np SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "departamento";
            }
        } elseif ($columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas") {
            $query = "UPDATE t_mp_np SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "energetico";
            }
        } elseif ($columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $query = "UPDATE t_mp_np SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "bitacora";
            }
        } elseif ($columna == "status") {
            $query = "UPDATE t_mp_np SET status = 'SOLUCIONADO', fecha_finalizado = '$fechaActual'  WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "solucionado";
            }
        } elseif ($columna == "eliminar") {
            $query = "UPDATE t_mp_np SET activo = 0 WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "eliminado";
            }
        } elseif ($columna == "restaurar") {
            $query = "UPDATE t_mp_np SET status = 'PENDIENTE' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "restaurado";
            }
        } elseif ($columna == "rango_fecha" && $valor != " ") {
            $query = "UPDATE t_mp_np SET rango_fecha = '$valor' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "rangoFecha";
            }
        }
        echo json_encode($resp);
    }


    // AGREGA ADJUNTOS EN LAS INCIDENCAS (t_mc y t_mp_np)
    if ($action == "agregarAdjuntosIncidenicas") {
        $idIncidencia = $_GET['idIncidencia'];
        $tipoIncidencia = $_GET['tipoIncidencia'];
        $resp = "ERROR";

        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);

        if ($tipoIncidencia == "INCIDENCIA") {
            $nombre = 'INCIDENCIA_ID_' . $idIncidencia . '_' . rand(50, 1500) . '.' . $extension;
            if (move_uploaded_file($rutaTemporal, '../planner/tareas/adjuntos/' . $nombre)) {
                $query = "INSERT INTO t_mc_adjuntos(id_mc, url_adjunto, fecha, subido_por, activo) VALUES($idIncidencia, '$nombre', '$fechaActual', $idUsuario, 1)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "INCIDENCIA";
                }
            }
        } elseif ($tipoIncidencia == "INCIDENCIAGENERAL") {
            $nombre = 'INCIDENCIA_GENERAL_ID_' . $idIncidencia . '_' . rand(50, 1500) . '.' . $extension;
            if (move_uploaded_file($rutaTemporal, '../img/equipos/mpnp/' . $nombre)) {
                $query = "INSERT INTO adjuntos_mp_np(id_usuario, id_mp_np, url, fecha, activo) VALUES($idUsuario, $idIncidencia, '$nombre', '$fechaActual', 1)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "INCIDENCIAGENERAL";
                }
            }
        }
        echo json_encode($resp);
    }


    // ACTULIZA LAS ACTIVIDADES DE INCIDENCIAS
    if ($action == "actualizarActividadesIncidencia") {
        $idActividad = $_GET['idActividad'];
        $columna = $_GET['columna'];
        $valor = $_GET['valor'];
        $resp = "error";

        if ($columna == "titulo" && $valor != "" && $valor != " ") {
            $query = "UPDATE t_mc_actividades_ot SET actividad = '$valor' WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "titulo";
            }
        } elseif ($columna == "eliminar") {
            $query = "UPDATE t_mc_actividades_ot SET activo = 0 WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "eliminado";
            }
        }
        echo json_encode($resp);
    }


    // ACTULIZA LAS ACTIVIDADES DE INCIDENCIAS
    if ($action == "actualizarActividadesIncidenciaGeneral") {
        $idActividad = $_GET['idActividad'];
        $columna = $_GET['columna'];
        $valor = $_GET['valor'];
        $resp = "error";

        if ($columna == "titulo" && $valor != "" && $valor != " ") {
            $query = "UPDATE t_mp_np_actividades_ot SET actividad = '$valor' WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "titulo";
            }
        } elseif ($columna == "eliminar") {
            $query = "UPDATE t_mp_np_actividades_ot SET activo = 0 WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "eliminado";
            }
        }
        echo json_encode($resp);
    }

    // CIERRE FINAL
}
