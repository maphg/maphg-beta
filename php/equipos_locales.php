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

    #OBTIENE TODOS LOS EQUIPO POR DESTINO->SECCION->SUBSECCION
    if ($action == "obtenerEquiposAmerica") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $contador = 0;
        $array = array();

        if ($idDestino == 10) {
            $filtroDestinoEquipo = "";
        } else {
            $filtroDestinoEquipo = "and t_equipos_america.id_destino = $idDestino";
        }

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, 
        t_equipos_america.local_equipo, t_equipos_america.status
        FROM t_equipos_america
        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and 
        t_equipos_america.jerarquia = 'PRINCIPAL' $filtroDestinoEquipo";
        if ($resultEquipo = mysqli_query($conn_2020, $query)) {
            foreach ($resultEquipo as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];
                $statusEquipo = $x['status'];
                $tipoEquipo = $x['local_equipo'];
                $contador++;

                #FALLAS PENDIENTES
                $fallasPendientes = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                and (status = 'N' or status = '' or status = 'PENDIENTE' or status = 'P') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasPendientes = $a['count(id)'];
                    }
                }

                #FALLAS SOLUCIONADOS
                $fallasSolucionadas = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasSolucionadas = $a['count(id)'];
                    }
                }

                #TAREAS SOLUCIONADOS
                $tareasSolucionadas = 0;
                $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                    and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tareasSolucionadas = $a['count(id)'];
                    }
                }

                #TAREAS PENDIENTES
                $tareasPendientes = 0;
                $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                    and (status = 'N' or status = 'P' or status = 'PENDIENTE') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tareasPendientes = $a['count(id)'];
                    }
                }

                #TOTAL COTIZACIONES POR EQUIPO
                $totalCotizaciones = 0;
                $query = "SELECT count(id) FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalCotizaciones = $a['count(id)'];
                    }
                }

                #TOTAL ADJUNTOS POR EQUIPO
                $totalAdjuntos = 0;
                $query = "SELECT count(id) FROM t_equipos_america_adjuntos WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalAdjuntos = $a['count(id)'];
                    }
                }

                #TOTAL COMENTARIOS POR EQUIPO
                $totalComentarios = 0;
                $query = "SELECT count(id) FROM t_equipos_america_comentarios WHERE id_equipo = $idEquipo and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalComentarios = $a['count(id)'];
                    }
                }

                #ULTIMO PREVENTIVO POR EQUIPO
                $ultimoMpFecha = "";
                $ultimoMpSemana = 0;
                $query = "SELECT semana, fecha_creacion FROM t_mp_planificacion_iniciada WHERE id_equipo = $idEquipo and status = 'SOLUCIONADO' and activo = 1
                ORDER BY id DESC LIMIT 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $ultimoMpFecha = $a['fecha_creacion'];
                        if ($ultimoMpFecha != "") {
                            $ultimoMpFecha = (new DateTime($ultimoMpFecha))->format('d-m-Y');
                        }
                        $ultimoMpSemana = $a['semana'];
                    }
                }

                #PREVENTIVOS SOLUCIONADOS POR EQUIPO
                $mpS = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO' ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $mpS = $a['id'];
                    }
                }

                #PREVENTIVOS PENDIENTES POR EQUIPO
                $mpP = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id'
                FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'PROCESO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $mpP = $a['id'];
                    }
                }

                #MP PRIXIMO POR EQUIPO
                $proximoMpFecha = "";
                $proximoMpSemana = 0;
                $query = "SELECT* FROM t_mp_planeacion_semana WHERE id_equipo = $idEquipo and activo = 1 and año = '$añoActual' ORDER BY id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $proximoMpFechaX = (new DateTime($a['ultima_modificacion']))
                            ->format("d/m/Y");
                        for ($x = 1; $x < 53; $x++) {
                            $semana_x = $a['semana_' . $x];
                            if ($semana_x == "PLANIFICADO") {
                                $proximoMpSemana = $x;
                                $proximoMpFecha = $proximoMpFechaX;
                                $x = 52;
                            }
                        }
                    }
                }

                #PREVENTIVOS SOLUCIONADOS POR EQUIPO
                $testR = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'TEST' ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $testR = $a['id'];
                    }
                }

                #TEST
                $query = "SELECT count(id) FROM t_test_equipos 
                WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $testR = $x['count(id)'];
                    }
                }

                #PREVENTIVOS TEST SOLUCIONADOS POR EQUIPO
                $ultimoTestFecha = 0;
                $ultimoTestSemana = 0;
                $query = "SELECT t_mp_planificacion_iniciada.semana, 
                t_mp_planificacion_iniciada.fecha_creacion 
                FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'TEST'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $ultimoTestFecha = $a['fecha_creacion'];
                        $ultimoTestSemana = $a['semana'];
                        if ($ultimoTestFecha != "") {
                            $ultimoTestFecha = (new DateTime($ultimoTestFecha))->format('d-m-Y');
                        }
                    }
                }

                #DESPIECE 
                $query = "SELECT count(id) FROM t_equipos_america WHERE id_equipo_principal = $idEquipo and activo = 1";
                $totalDespiece = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalDespiece = $x['count(id)'];
                    }
                }



                $arrayTemp = array(
                    "filaNumero" => intval($contador),
                    "idEquipo" => intval($idEquipo),
                    "equipo" => $equipo,
                    "tipoEquipo" => $tipoEquipo,
                    "statusEquipo" => $statusEquipo,
                    "fallasP" => intval($fallasPendientes),
                    "fallasS" => intval($fallasSolucionadas),
                    "mpP" => intval($mpP),
                    "mpS" => intval($mpS),
                    "ultimoMpFecha" => $ultimoMpFecha,
                    "ultimoMpSemana" => $ultimoMpSemana,
                    "proximoMpFecha" => $proximoMpFecha,
                    "proximoMpSemana" => intval($proximoMpSemana),
                    "tareasP" => intval($tareasPendientes),
                    "tareasS" => intval($tareasSolucionadas),
                    "testR" => intval($testR),
                    "ultimoTestFecha" => $ultimoTestFecha,
                    "ultimoTestSemana" => intval($ultimoTestSemana),
                    "cotizaciones" => intval($totalCotizaciones),
                    "imagenes" => intval($totalAdjuntos),
                    "comentarios" => intval($totalComentarios),
                    "totalDespiece" => intval($totalDespiece)
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    #OBTIENE EL DESPIECE POR EQUIPO
    if ($action == "obtenerDespieceEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();
        $contador = 0;

        $query = "SELECT id, equipo, local_equipo, status
        FROM t_equipos_america
        WHERE id_equipo_principal = $idEquipo and jerarquia = 'SECUNDARIO' and activo = 1";
        if ($resultEquipo = mysqli_query($conn_2020, $query)) {
            foreach ($resultEquipo as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];
                $statusEquipo = $x['status'];
                $tipoEquipo = $x['local_equipo'];
                $contador++;

                #FALLAS PENDIENTES
                $fallasPendientes = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                and (status = 'N' or status = '' or status = 'PENDIENTE' or status = 'P') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasPendientes = $a['count(id)'];
                    }
                }

                #FALLAS SOLUCIONADOS
                $fallasSolucionadas = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasSolucionadas = $a['count(id)'];
                    }
                }

                #TAREAS SOLUCIONADOS
                $tareasSolucionadas = 0;
                $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                    and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tareasSolucionadas = $a['count(id)'];
                    }
                }

                #TAREAS PENDIENTES
                $tareasPendientes = 0;
                $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                    and (status = 'N' or status = 'P' or status = 'PENDIENTE') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tareasPendientes = $a['count(id)'];
                    }
                }

                #TOTAL COTIZACIONES POR EQUIPO
                $totalCotizaciones = 0;
                $query = "SELECT count(id) FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalCotizaciones = $a['count(id)'];
                    }
                }

                #TOTAL ADJUNTOS POR EQUIPO
                $totalAdjuntos = 0;
                $query = "SELECT count(id) FROM t_equipos_america_adjuntos WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalAdjuntos = $a['count(id)'];
                    }
                }

                #TOTAL COMENTARIOS POR EQUIPO
                $totalComentarios = 0;
                $query = "SELECT count(id) FROM t_equipos_america_comentarios WHERE id_equipo = $idEquipo and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalComentarios = $a['count(id)'];
                    }
                }

                #ULTIMO PREVENTIVO POR EQUIPO
                $ultimoMpFecha = "";
                $ultimoMpSemana = 0;
                $query = "SELECT semana, fecha_creacion FROM t_mp_planificacion_iniciada WHERE id_equipo = $idEquipo and status = 'SOLUCIONADO' and activo = 1
                ORDER BY id DESC LIMIT 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $ultimoMpFecha = $a['fecha_creacion'];
                        if ($ultimoMpFecha != "") {
                            $ultimoMpFecha = (new DateTime($ultimoMpFecha))->format('d-m-Y');
                        }
                        $ultimoMpSemana = $a['semana'];
                    }
                }

                #PREVENTIVOS SOLUCIONADOS POR EQUIPO
                $mpS = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO' ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $mpS = $a['id'];
                    }
                }

                #PREVENTIVOS PENDIENTES POR EQUIPO
                $mpP = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id'
                FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'PROCESO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $mpP = $a['id'];
                    }
                }

                #MP PRIXIMO POR EQUIPO
                $proximoMpFecha = "";
                $proximoMpSemana = 0;
                $query = "SELECT* FROM t_mp_planeacion_semana WHERE id_equipo = $idEquipo and activo = 1 and año = '$añoActual' ORDER BY id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $tareasSolucionadas = 0;
                    foreach ($result as $a) {
                        $proximoMpFechaX = (new DateTime($a['ultima_modificacion']))
                            ->format("d/m/Y");
                        for ($x = 1; $x < 53; $x++) {
                            $semana_x = $a['semana_' . $x];
                            if ($semana_x == "PLANIFICADO") {
                                $proximoMpSemana = $x;
                                $proximoMpFecha = $proximoMpFechaX;
                                $x = 52;
                            }
                        }
                    }
                }

                #PREVENTIVOS SOLUCIONADOS POR EQUIPO
                $testR = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'TEST' ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $testR = $a['id'];
                    }
                }

                #PREVENTIVOS TEST SOLUCIONADOS POR EQUIPO
                $ultimoTestFecha = 0;
                $ultimoTestSemana = 0;
                $query = "SELECT t_mp_planificacion_iniciada.semana, 
                t_mp_planificacion_iniciada.fecha_creacion 
                FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'TEST'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $ultimoTestFecha = $a['fecha_creacion'];
                        $ultimoTestSemana = $a['semana'];
                        if ($ultimoTestFecha != "") {
                            $ultimoTestFecha = (new DateTime($ultimoTestFecha))->format('d-m-Y');
                        }
                    }
                }

                $query = "SELECT count(id) FROM t_equipos_america WHERE id_equipo_principal = $idEquipo and activo = 1";
                $totalDespiece = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalDespiece = $x['count(id)'];
                    }
                }

                $arrayTemp = array(
                    "filaNumero" => intval($contador),
                    "idEquipo" => intval($idEquipo),
                    "equipo" => $equipo,
                    "tipoEquipo" => $tipoEquipo,
                    "statusEquipo" => $statusEquipo,
                    "fallasP" => intval($fallasPendientes),
                    "fallasS" => intval($fallasSolucionadas),
                    "mpP" => intval($mpP),
                    "mpS" => intval($mpS),
                    "ultimoMpFecha" => $ultimoMpFecha,
                    "ultimoMpSemana" => $ultimoMpSemana,
                    "proximoMpFecha" => $proximoMpFecha,
                    "proximoMpSemana" => intval($proximoMpSemana),
                    "tareasP" => intval($tareasPendientes),
                    "tareasS" => intval($tareasSolucionadas),
                    "testR" => intval($testR),
                    "ultimoTestFecha" => $ultimoTestFecha,
                    "ultimoTestSemana" => intval($ultimoTestSemana),
                    "cotizaciones" => intval($totalCotizaciones),
                    "imagenes" => intval($totalAdjuntos),
                    "comentarios" => intval($totalComentarios),
                    "totalDespiece" => intval($totalDespiece)
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    #OBTIENE TODOS PENDIENTES POR DESTINO->SUBSECCION
    if ($action == "obtenerTodosPendientes") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $contador = 0;
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
            $filtroDestinoTarea = "";
            $filtroDestinoMP = "";
            $filtroDestinoTG = "";
            $filtroDestinoEquipo = "";
        } else {
            $filtroDestino = "and id_destino = '$idDestino'";
            $filtroDestinoTarea = "and t_equipos_america.id_destino = '$idDestino'";
            $filtroDestinoMP = "and t_equipos_america.id_destino = '$idDestino'";
            $filtroDestinoTG = "and id_destino = $idDestino";
            $filtroDestinoEquipo = "and t_equipos_america.id_destino = $idDestino";
        }

        #FALLAS SOLUCIONADOS
        $array['fallasS'] = 0;
        $queryFallas = "SELECT count(t_mc.id) 
        FROM t_mc
        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
        WHERE t_equipos_america.id_seccion = $idSeccion and 
        t_equipos_america.id_subseccion = $idSubseccion and 
        t_equipos_america.activo = 1 and
        (t_mc.status = 'PENDIENTE' or t_mc.status = 'F' or t_mc.status = 'SOLUCIONADO') 
        and t_mc.activo = 1 $filtroDestinoEquipo";
        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
            foreach ($resultFallas as $x) {
                $totalFallas = $x['count(t_mc.id)'];
                $array['fallasS'] = $totalFallas;
            }
        }

        #FALLAS PENDIENTES
        $array['fallasP'] = 0;
        $queryFallas = "SELECT count(t_mc.id) 
        FROM t_mc
        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
        WHERE t_equipos_america.id_seccion = $idSeccion and 
        t_equipos_america.id_subseccion = $idSubseccion and 
        t_equipos_america.activo = 1 and
        (t_mc.status = 'N' or t_mc.status = 'P' or t_mc.status = 'PENDIENTE') 
        and t_mc.activo = 1 $filtroDestinoEquipo";
        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
            foreach ($resultFallas as $x) {
                $totalFallas = $x['count(t_mc.id)'];
                $array['fallasP'] = $totalFallas;
            }
        }

        #TAREAS GENERALES SOLUCIONADAS
        $array['tareasGS'] = 0;
        $query = "SELECT count(id) 'id'
        FROM t_mp_np
        WHERE activo = 1 and 
        (status = 'F' or status = 'SOLUCIONADO') and 
        id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 
        $filtroDestinoTG";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalTareasGS = $x['id'];
                $array['tareasGS'] = intval($totalTareasGS);
            }
        }

        #TAREAS GENERALES PENDIENTES
        $array['tareasGP'] = 0;
        $query = "SELECT count(id) 'id'
        FROM t_mp_np
        WHERE activo = 1 and 
        (status = 'N' or status = 'P' or status = 'PENDIENTE' or status = '') and 
        id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 
        $filtroDestinoTG";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalTareasGP = $x['id'];
                // $array['tareasGP'] = intval($totalTareasGP);
                $array['tareasGP'] = $query;
            }
        }

        #TAREAS SOLUCIONADAS
        $array['tareasS'] = 0;
        $queryTareas = "SELECT count(t_mp_np.id) 'id'
        FROM t_mp_np 
        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
        WHERE t_mp_np.activo = 1 and 
        (t_mp_np.status = 'F' or t_mp_np.status = 'SOLUCIONADO') and 
        t_equipos_america.id_seccion = $idSeccion and 
        t_equipos_america.id_subseccion = $idSubseccion 
        $filtroDestinoTarea";
        if ($result = mysqli_query($conn_2020, $queryTareas)) {
            foreach ($result as $x) {
                $totalTareasS = $x['id'];
                $array['tareasS'] = intval($totalTareasS);
            }
        }

        #TAREAS PENDIENTES
        $array['tareasP'] = 0;
        $queryTareas = "SELECT count(t_mp_np.id) 
        FROM t_mp_np
        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
        $totalTareas = 0;
        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
            foreach ($resultTareas as $x) {
                $totalTareas = $x['count(t_mp_np.id)'];
                $array['tareasP'] = intval($totalTareas);
            }
        }

        #PREVENTIVOS SOLUCIONADO POR EQUIPO
        $array['mpS'] = 0;
        $query = "SELECT count(.t_mp_planificacion_iniciada.id) 'id' 
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id 
        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and t_mp_planificacion_iniciada.activo = 1 and 
        t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO' $filtroDestinoMP";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalMPS = $x['id'];

                $array['mpS'] = $totalMPS;
            }
        }

        #PREVENTIVOS PENDIENTE POR EQUIPO
        $array['mpP'] = 0;
        $query = "SELECT count(.t_mp_planificacion_iniciada.id) 'id' 
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id 
        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_mp_planificacion_iniciada.status = 'PROCESO' and t_mp_planificacion_iniciada.activo = 1 and 
        t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO' $filtroDestinoMP";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalMPP = $x['id'];

                $array['mpP'] = $totalMPP;
            }
        }

        #TEST REALIZADO POR EQUIPO
        $array['test'] = 0;
        $query = "SELECT count(.t_mp_planificacion_iniciada.id) 'id' 
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id 
        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and t_mp_planificacion_iniciada.activo = 1 and 
        t_mp_planes_mantenimiento.tipo_plan = 'TEST' $filtroDestinoMP";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalTest = $x['id'];

                $array['test'] =
                    $$totalTest = $x['id'];;
            }
        }
        echo json_encode($array);
    }

    // Final
}
