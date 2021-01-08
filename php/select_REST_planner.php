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


        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.status, t_mp_np.responsable, t_colaboradores.nombre, t_mp_np.fecha, t_mp_np.rango_fecha,
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

        $query = "SELECT t_mc.id, t_mc.actividad, t_mc.status, t_mc.responsable, t_colaboradores.nombre, t_mc.fecha_creacion, t_mc.rango_fecha, t_colaboradores.apellido,
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
        $array['equipo'] = "$tipoPendiente GENERAL";
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
        WHERE t_users.id = $idUsuario AND t_users.status = 'A' LIMIT 1;
        ";

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
        $arrayIndex = array();
        $array = array();
        $totalFallas = 0;
        $totalTareas = 0;
        $totalTareasGenerales = 0;
        $totalProyectos = 0;
        $totalMP = 0;

        // $query = "SELECT id, id_equipo FROM t_mp_np WHERE id_seccion = 0";
        // if ($result  = mysqli_query($conn_2020, $query)) {
        //     foreach ($result as $x) {
        //         $id = $x['id'];
        //         $idEquipo = $x['id_equipo'];
        //         $query = "SELECT id_seccion, id_subseccion FROM t_equipos WHERE id = $idEquipo";
        //         if ($result = mysqli_query($conn_2020, $query)) {
        //             foreach ($result as $x) {
        //                 $idSeccion = $x['id_seccion'];
        //                 $idSubseccion = $x['id_subseccion'];

        //                 $query = "UPDATE t_mp_np SET id_seccion = $idSeccion, id_subseccion = $idSubseccion WHERE id = $id";
        //                 if ($result = mysqli_query($conn_2020, $query)) {
        //                     echo 1;
        //                 }
        //             }
        //         }
        //     }
        // }

        $query = "SELECT t_mc.id, t_mc.actividad, c_secciones.seccion
        FROM t_mc 
        INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
        WHERE t_mc.responsable = $idUsuario and t_mc.activo = 1 and 
        (t_mc.status = 'N' or t_mc.status = 'PENDIENTE' or t_mc.status = 'P')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalFallas++;
                $idFalla = $x['id'];
                $seccion = $x['seccion'];
                $actividad = $x['actividad'];

                $arrayTemp = array(
                    "idPendiente" => intval($idFalla),
                    "tipoPendiente" => "INCIDENCIA",
                    "seccion" => $seccion,
                    "actividad" => $actividad
                );
                $arrayIndex[] = $arrayTemp;
            }
        }

        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.id_equipo, c_secciones.seccion 
        FROM t_mp_np 
        LEFT JOIN c_secciones  ON t_mp_np.id_seccion = c_secciones.id 
        WHERE t_mp_np.responsable = $idUsuario and t_mp_np.activo = 1 and 
        (t_mp_np.status='N' or t_mp_np.status='PENDIENTE' or t_mp_np.status='P')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTarea = $x['id'];
                $seccion = $x['seccion'];
                $actividad = $x['titulo'];
                $idEquipo = intval($x['id_equipo']);

                if ($idEquipo > 0) {
                    $tipoPendiente = "TAREA";
                    $totalTareas++;
                } else {
                    $tipoPendiente = "TAREAGENERAL";
                    $totalTareasGenerales++;
                }

                $arrayTemp = array(
                    "idPendiente" => intval($idTarea),
                    "tipoPendiente" => $tipoPendiente,
                    "seccion" => $seccion,
                    "actividad" => $actividad,
                );
                $arrayIndex[] = $arrayTemp;
            }
        }

        $query = "SELECT id, id_plan FROM t_mp_planificacion_iniciada WHERE id_responsables IN($idUsuario) and activo = 1 
        and (status='N' or status='PENDIENTE' or status='P' or status='PROCESO')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalMP++;
                $idMP = $x['id'];
                $actividad = $x['id_plan'];

                $arrayTemp = array(
                    "idPendiente" => intval($idMP),
                    "tipoPendiente" => "MP",
                    "seccion" => "MP",
                    "actividad" => "MP",
                );
                // $arrayIndex[] = $arrayTemp;
            }
        }

        $query = "SELECT id, titulo FROM t_proyectos WHERE responsable = $idUsuario and activo = 1 
        and (status='N' or status='PENDIENTE' or status='P' or status='PROCESO')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalProyectos++;
                $idProyecto = $x['id'];
                $actividad = $x['titulo'];

                $arrayTemp = array(
                    "idPendiente" => intval($idProyecto),
                    "tipoPendiente" => "PLANACCION",
                    "seccion" => "PROYECTO",
                    "actividad" => $actividad,
                );
                // $arrayIndex[] = $arrayTemp;
            }
        }

        $query = "SELECT id, actividad FROM t_proyectos_planaccion WHERE responsable = $idUsuario and activo = 1 and (status='N' or status='PENDIENTE' or status='P' or status='PROCESO')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalProyectos++;
                $idProyecto = $x['id'];
                $actividad = $x['actividad'];

                $arrayTemp = array(
                    "idPendiente" => intval($idProyecto),
                    "tipoPendiente" => "PLANACCION",
                    "seccion" => "PROYECTO",
                    "actividad" => $actividad,
                );
                $arrayIndex[] = $arrayTemp;
            }
        }

        $array['totalFallas'] = $totalFallas;
        $array['totalTareas'] = $totalTareas;
        $array['totalTareasGenerales'] = $totalTareasGenerales;
        $array['totalTareasX'] = $totalTareas + $totalTareasGenerales;
        $array['totalProyectos'] = $totalProyectos;
        $array['totalMP'] = $totalMP;
        $array['pendientes'] = $arrayIndex;

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
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_users.id_destino = $idDestino";
        }

        $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idUsuario = $x['id'];
                $nombre = $x['nombre'];
                $apellido = $x['apellido'];

                $array[] = array(
                    "idUsuario" => intval($idUsuario),
                    "nombre" => $nombre,
                    "apellido" => $apellido
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
        }
        echo json_encode($resp);
    }


    // OBTIENE LOS PENDIENTES DE ENERGETICOS
    if ($action == "obtenerEnergeticos") {
        $idSeccion = $_GET["idSeccion"];
        $idSubseccion = $_GET["idSubseccion"];

        $array = array();

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
        WHERE t_energeticos.id_seccion = $idSeccion and t_energeticos.id_subseccion = $idSubseccion and t_energeticos.activo = 1 ORDER BY t_energeticos.id DESC";
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
                    $fechaInicio = substr($rangoFecha, -10);
                    $fechaFin = substr($rangoFecha, -23, 10);
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


    //OBTIENES LAS SECCIONES SEGÚN EL DESTINO
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


    // OBTIENE EQUIPOS TIPO LOCAL O EQUIPO, SEGUN DESTINO, SECCION Y SUBSECCION
    if ($action == "obtenerEquipoLocal") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $tipo = $_GET['tipo'];
        $array = array();

        $query = "SELECT id, equipo FROM t_equipos_america 
        WHERE id_destino = $idDestino and id_seccion = $idSeccion and id_subseccion = $idSubseccion and local_equipo = '$tipo' and status = 'OPERATIVO' and activo = 1
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

        $query = "SELECT*  FROM t_equipos_america WHERE id = $idEquipo";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $id = $x['id'];
                $id_equipo_principal = $x['id_equipo_principal'];
                $equipo = $x['equipo'];
                $cod2bend = $x['cod2bend'];
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

                $array = array(
                    "idEquipo" => intval($id),
                    "idEquipo" => $equipo,
                    "matricula" => $matricula,
                    "cod2bend" => $cod2bend,
                    "serie" => $serie,
                    "idDestino" => intval($id_destino),
                    "idSeccion" => intval($id_seccion),
                    "idSubseccion" => intval($id_subseccion),
                    "idTipo" => intval($id_tipo),
                    "idCCoste" => intval($id_ccoste),
                    "idHotel" => intval($id_hotel),
                    "idArea" => intval($id_area),
                    "idLocalizacion" => intval($id_localizacion),
                    "idUbicacion" => intval($id_ubicacion),
                    "idSububicacion" => intval($id_sububicacion),
                    "categoria" => $categoria,
                    "local_equipo" => $local_equipo,
                    "jerrquia" => $jerarquia,
                    "idMarca" => $id_marca,
                    "modelo" => $modelo,
                    "numeroSerie" => $numero_serie,
                    "codigoFabricante" => $codigo_fabricante,
                    "codigoInternoCompras" => $codigo_interno_compras,
                    "largo" => $largo_cm,
                    "ancho" => $ancho_cm,
                    "alto" => $alto_cm,
                    "potenciaElectricaHP" => $potencia_electrica_hp,
                    "potenciaElectricaKW" => $potencia_electrica_kw,
                    "voalteje" => $voltaje_v,
                    "frecuencia" => $frecuencia_hz,
                    "caudalAguaM3H" => $caudal_agua_m3h,
                    "caudalAguaGPH" => $caudal_agua_gph,
                    "cargaMCA" => $carga_mca,
                    "potenciaEnergeticaFrioKM" => $potencia_energetica_frio_kw,
                    "potenciaEnergeticaFrioTR" => $potencia_energetica_frio_tr,
                    "potenciaEnergeticaFrioKCAL" => $potencia_energetica_calor_kcal,
                    "caudalAireM3H" => $caudal_aire_m3h,
                    "caudalAireCFM" => $caudal_aire_cfm,
                    "coste" => $coste,
                    "idFases" => intval($id_fases),
                    "status" => $status
                );
            }
        }
        echo json_encode($array);
    }


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

        if ($idEquipo > 0) {
            $query = "INSERT INTO t_mc(actividad, tipo_incidencia, id_equipo, status, creado_por, responsable, fecha_creacion, id_destino, id_seccion, id_subseccion, rango_fecha, activo) VALUES('$descripcion', '$tipo', $idEquipo, 'N', $idUsuario, $responsable,'$fechaActual', $idDestino, $idSeccion, $idSubseccion, '$rangoFecha', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } else {
            $query = "INSERT INTO t_mp_np(id_equipo, id_usuario, id_destino, id_seccion, id_subseccion, tipo_incidencia, titulo, responsable, fecha, rango_fecha, status, activo) VALUES(0, $idUsuario, $idDestino, $idSeccion, $idSubseccion, '$tipo', '$descripcion', $responsable, '$fechaActual', '$rangoFecha', 'PENDIENTE', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 2;
            }
        }
        echo json_encode($resp);
    }


    if ($action == "agregarEnergetico") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $titulo = $_GET['titulo'];
        $rangoFecha = $_GET['rangoFecha'];
        $responsable = $_GET['responsable'];
        $comentario = $_GET['comentario'];
        $resp = 0;

        $idMax = 0;
        $query = "SELECT max(id) 'id' FROM t_energeticos";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idMax = intval($x['id']) + 1;
            }
        }

        if ($idMax > 0) {
            $query = "INSERT INTO t_energeticos(id, id_destino, id_seccion, id_subseccion, actividad, creado_por, responsable, fecha_creacion, rango_fecha, status, activo) VALUES($idMax, $idDestino, $idSeccion, $idSubseccion, '$titulo', $idUsuario, $responsable, '$fechaActual', '$rangoFecha', 'PENDIENTE', 1)";
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




    // CIERRE FINAL
}
