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

        if ($idEquipo == 0) {
            $filtroEquipo = "and t_mp_np.id_seccion = $idSeccion and 
            t_mp_np.id_subseccion = $idSubseccion ";
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
        WHERE t_mp_np.id_equipo = $idEquipo and t_mp_np.activo = 1 $filtroEquipo
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


    #OBTIENE LOS EQUIPOS AMERICA CON SUS DETALLES DE PENDIENTES



    // CIERRE FINAL
}
