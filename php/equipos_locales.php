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
        $pagina = intval($_GET['pagina']);
        $contador = 0;
        $array = array();

        if (isset($_POST['palabraEquipo'])) {
            $palabraEquipo = $_POST['palabraEquipo'];
            $filtroPalabra = "";
            if ($palabraEquipo != "") {
                $filtroPalabra = "and t_equipos_america.equipo LIKE '%$palabraEquipo%'";
            }
        } else {
            $filtroPalabra = "";
        }

        if ($idDestino == 10) {
            $filtroDestinoEquipo = "";
        } else {
            $filtroDestinoEquipo = "and t_equipos_america.id_destino = $idDestino";
        }

        if ($pagina == 0) {
            $pagina = intval(0);
            $filtroPagina = "LIMIT $pagina, 65";
        } elseif ($pagina > 0) {
            $pagina = intval(($pagina * 65));
            $filtroPagina = "LIMIT $pagina, 65";
        } else {
            $filtroPagina = "";
        }

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, 
        t_equipos_america.local_equipo, t_equipos_america.status, t_equipos_america.jerarquia, c_destinos.destino
        FROM t_equipos_america
        INNER JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
        WHERE t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and t_equipos_america.status IN('OPERATIVO', 'TALLER', 'FUERASERVICIO', 'OPERAMAL') and t_equipos_america.jerarquia = 'PRINCIPAL' 
        $filtroPalabra $filtroDestinoEquipo $filtroPagina";
        if ($resultEquipo = mysqli_query($conn_2020, $query)) {
            foreach ($resultEquipo as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];
                $statusEquipo = $x['status'];
                $tipoEquipo = $x['local_equipo'];
                $jerarquia = $x['jerarquia'];
                $destino = $x['destino'];
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

                #INCIDENCIA EMERCENCIA
                $emergenciaS = 0;
                $urgenciaS = 0;
                $alarmaS = 0;
                $alertaS = 0;
                $seguimientoS = 0;
                // $query = "SELECT tipo_incidencia FROM t_mc WHERE id_equipo = $idEquipo 
                // and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $tipoIncidencia = $a['tipo_incidencia'];

                //         if ($tipoIncidencia == "EMERGENCIA") {
                //             $emergenciaS++;
                //         } elseif ($tipoIncidencia == "URGENCIA") {
                //             $urgenciaS++;
                //         } elseif ($tipoIncidencia == "ALARMA") {
                //             $alarmaS++;
                //         } elseif ($tipoIncidencia == "ALERTA") {
                //             $alertaS++;
                //         } else {
                //             $seguimientoS++;
                //         }
                //     }
                // }

                #INCIDENCIA EMERCENCIA
                $emergenciaP = 0;
                $urgenciaP = 0;
                $alarmaP = 0;
                $alertaP = 0;
                $seguimientoP = 0;
                $query = "SELECT tipo_incidencia FROM t_mc WHERE id_equipo = $idEquipo 
                and (status = 'N' or status = 'PENDIENTE' or status = 'P') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tipoIncidencia = $a['tipo_incidencia'];

                        if ($tipoIncidencia == "EMERGENCIA") {
                            $emergenciaP++;
                        } elseif ($tipoIncidencia == "URGENCIA") {
                            $urgenciaP++;
                        } elseif ($tipoIncidencia == "ALARMA") {
                            $alarmaP++;
                        } elseif ($tipoIncidencia == "ALERTA") {
                            $alertaP++;
                        } else {
                            $seguimientoP++;
                        }
                    }
                }

                #TAREAS SOLUCIONADOS
                $tareasSolucionadas = 0;
                // $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                //     and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $tareasSolucionadas = $a['count(id)'];
                //     }
                // }

                #TAREAS PENDIENTES
                $tareasPendientes = 0;
                // $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                //     and (status = 'N' or status = 'P' or status = 'PENDIENTE') and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $tareasPendientes = $a['count(id)'];
                //     }
                // }

                #TOTAL COTIZACIONES POR EQUIPO
                $totalCotizaciones = 0;
                // $query = "SELECT count(id) FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $totalCotizaciones = $a['count(id)'];
                //     }
                // }

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

                #PREVENTIVOS SOLUCIONADOS POR AÑO Y POR EQUIPO
                $mpS = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan IN('PREVENTIVO', 'CHECKLIST')";
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
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan IN('PREVENTIVO', 'CHECKLIST')";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $mpP = $a['id'];
                    }
                }

                #MP PRIXIMO POR EQUIPO
                $proximoMpSemana = "";
                $query = "SELECT* FROM t_mp_planeacion_semana WHERE id_equipo = $idEquipo and activo = 1 and año = '$añoActual' ORDER BY id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $proximoMpFechaX = (new DateTime($a['ultima_modificacion']))
                            ->format("d/m/Y");
                        for ($x = intval($ultimoMpSemana)  + 1; $x < 53; $x++) {
                            $semana_x = $a['semana_' . $x];
                            if ($semana_x == "PLANIFICADO") {
                                $proximoMpSemana = $x;
                                $proximoMpFecha = $proximoMpFechaX;
                                $x = 52;
                            }
                        }
                    }
                }
                $proximoMpFecha = "";

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

                #TEST ULTIMO SOLUCIONADOS POR EQUIPO
                $ultimoTestFecha = 0;
                $ultimoTestSemana = 0;
                $query = "SELECT fecha_creado FROM t_test_equipos 
                WHERE id_equipo = $idEquipo and activo = 1 and fecha_creado !='' 
                ORDER BY id DESC LIMIT 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $ultimoTestFecha = (new DateTime($x['fecha_creado']))->format('d/m/Y');
                    }
                }

                #TOTAL ADJUNTOS POR EQUIPO
                $totalAdjuntos = 0;
                // $query = "SELECT count(id) FROM t_equipos_america_adjuntos WHERE id_equipo = $idEquipo and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $totalAdjuntos = $a['count(id)'];
                //     }
                // }

                #TOTAL COMENTARIOS POR EQUIPO
                $totalComentarios = 0;
                // $query = "SELECT count(id) FROM t_equipos_america_comentarios WHERE id_equipo = $idEquipo and status = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $totalComentarios = $a['count(id)'];
                //     }
                // }

                #DESPIECE 
                $totalDespiece = 0;
                $query = "SELECT count(id) FROM t_equipos_america WHERE id_equipo_principal = $idEquipo and 
                status IN('OPERATIVO', 'TALLER', 'FUERASERVICIO', 'OPERAMAL') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalDespiece = $x['count(id)'];
                    }
                }

                $array[] = array(
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
                    "totalDespiece" => intval($totalDespiece),
                    "emergenciaP" => intval($emergenciaP),
                    "urgenciaP" => intval($urgenciaP),
                    "alarmaP" => intval($alarmaP),
                    "alertaP" => intval($alertaP),
                    "seguimientoP" => intval($seguimientoP),
                    "emergenciaS" => intval($emergenciaS),
                    "urgenciaS" => intval($urgenciaS),
                    "alarmaS" => intval($alarmaS),
                    "alertaS" => intval($alertaS),
                    "seguimientoS" => intval($seguimientoS),
                    "jerarquia" => $jerarquia,
                    "destino" => $destino
                );
            }
        }
        echo json_encode($array);
    }


    #OBTIENE TODOS LOS EQUIPO POR DESTINO->SECCION->SUBSECCION
    if ($action == "obtenerDespieceEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();
        $contador = 0;

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, t_equipos_america.local_equipo, t_equipos_america.status, t_equipos_america.jerarquia, c_destinos.destino
        FROM t_equipos_america
        INNER JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
        WHERE t_equipos_america.id_equipo_principal = $idEquipo and t_equipos_america.jerarquia = 'SECUNDARIO' and t_equipos_america.activo = 1 and t_equipos_america.status IN('OPERATIVO', 'TALLER', 'FUERASERVICIO', 'OPERAMAL')";
        if ($resultEquipo = mysqli_query($conn_2020, $query)) {
            foreach ($resultEquipo as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];
                $statusEquipo = $x['status'];
                $tipoEquipo = $x['local_equipo'];
                $jerarquia = $x['jerarquia'];
                $destino = $x['destino'];
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

                #INCIDENCIA EMERCENCIA
                $emergenciaS = 0;
                $urgenciaS = 0;
                $alarmaS = 0;
                $alertaS = 0;
                $seguimientoS = 0;
                // $query = "SELECT tipo_incidencia FROM t_mc WHERE id_equipo = $idEquipo 
                // and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $tipoIncidencia = $a['tipo_incidencia'];

                //         if ($tipoIncidencia == "EMERGENCIA") {
                //             $emergenciaS++;
                //         } elseif ($tipoIncidencia == "URGENCIA") {
                //             $urgenciaS++;
                //         } elseif ($tipoIncidencia == "ALARMA") {
                //             $alarmaS++;
                //         } elseif ($tipoIncidencia == "ALERTA") {
                //             $alertaS++;
                //         } else {
                //             $seguimientoS++;
                //         }
                //     }
                // }

                #INCIDENCIA EMERCENCIA
                $emergenciaP = 0;
                $urgenciaP = 0;
                $alarmaP = 0;
                $alertaP = 0;
                $seguimientoP = 0;
                $query = "SELECT tipo_incidencia FROM t_mc WHERE id_equipo = $idEquipo 
                and (status = 'N' or status = 'PENDIENTE' or status = 'P') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tipoIncidencia = $a['tipo_incidencia'];

                        if ($tipoIncidencia == "EMERGENCIA") {
                            $emergenciaP++;
                        } elseif ($tipoIncidencia == "URGENCIA") {
                            $urgenciaP++;
                        } elseif ($tipoIncidencia == "ALARMA") {
                            $alarmaP++;
                        } elseif ($tipoIncidencia == "ALERTA") {
                            $alertaP++;
                        } else {
                            $seguimientoP++;
                        }
                    }
                }

                #TAREAS SOLUCIONADOS
                $tareasSolucionadas = 0;
                // $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                //     and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $tareasSolucionadas = $a['count(id)'];
                //     }
                // }

                #TAREAS PENDIENTES
                $tareasPendientes = 0;
                // $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                //     and (status = 'N' or status = 'P' or status = 'PENDIENTE') and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $tareasPendientes = $a['count(id)'];
                //     }
                // }

                #TOTAL COTIZACIONES POR EQUIPO
                $totalCotizaciones = 0;
                // $query = "SELECT count(id) FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $totalCotizaciones = $a['count(id)'];
                //     }
                // }

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

                #PREVENTIVOS SOLUCIONADOS POR AÑO Y POR EQUIPO
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
                $proximoMpSemana = "";
                $query = "SELECT* FROM t_mp_planeacion_semana WHERE id_equipo = $idEquipo and activo = 1 and año = '$añoActual' ORDER BY id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $proximoMpFechaX = (new DateTime($a['ultima_modificacion']))
                            ->format("d/m/Y");
                        for ($x = intval($ultimoMpSemana)  + 1; $x < 53; $x++) {
                            $semana_x = $a['semana_' . $x];
                            if ($semana_x == "PLANIFICADO") {
                                $proximoMpSemana = $x;
                                $proximoMpFecha = $proximoMpFechaX;
                                $x = 52;
                            }
                        }
                    }
                }
                $proximoMpFecha = "";



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

                #TEST ULTIMO SOLUCIONADOS POR EQUIPO
                $ultimoTestFecha = 0;
                $ultimoTestSemana = 0;
                $query = "SELECT fecha_creado FROM t_test_equipos 
                WHERE id_equipo = $idEquipo and activo = 1 and fecha_creado !='' 
                ORDER BY id DESC LIMIT 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $ultimoTestFecha = (new DateTime($x['fecha_creado']))->format('d/m/Y');
                    }
                }

                #TOTAL ADJUNTOS POR EQUIPO
                $totalAdjuntos = 0;
                // $query = "SELECT count(id) FROM t_equipos_america_adjuntos WHERE id_equipo = $idEquipo and activo = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $totalAdjuntos = $a['count(id)'];
                //     }
                // }

                #TOTAL COMENTARIOS POR EQUIPO
                $totalComentarios = 0;
                // $query = "SELECT count(id) FROM t_equipos_america_comentarios WHERE id_equipo = $idEquipo and status = 1";
                // if ($result = mysqli_query($conn_2020, $query)) {
                //     foreach ($result as $a) {
                //         $totalComentarios = $a['count(id)'];
                //     }
                // }

                #DESPIECE 
                $totalDespiece = 0;
                $query = "SELECT count(id) FROM t_equipos_america WHERE id_equipo_principal = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalDespiece = $x['count(id)'];
                    }
                }

                $array[] = array(
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
                    "totalDespiece" => intval($totalDespiece),
                    "emergenciaP" => intval($emergenciaP),
                    "urgenciaP" => intval($urgenciaP),
                    "alarmaP" => intval($alarmaP),
                    "alertaP" => intval($alertaP),
                    "seguimientoP" => intval($seguimientoP),
                    "emergenciaS" => intval($emergenciaS),
                    "urgenciaS" => intval($urgenciaS),
                    "alarmaS" => intval($alarmaS),
                    "alertaS" => intval($alertaS),
                    "seguimientoS" => intval($seguimientoS),
                    "jerarquia" => $jerarquia,
                    "destino" => $destino
                );
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
        WHERE t_equipos_america.id_subseccion = $idSubseccion and 
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
        WHERE t_equipos_america.id_subseccion = $idSubseccion and 
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
        (status = 'F' or status = 'SOLUCIONADO') and id_subseccion = $idSubseccion and id_equipo = 0 
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
        (status = 'N' or status = 'P' or status = 'PENDIENTE') 
        and id_subseccion = $idSubseccion and id_equipo = 0 
        $filtroDestinoTG";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalTareasGP = $x['id'];
                $array['tareasGP'] = intval($totalTareasGP);
            }
        }

        #TAREAS SOLUCIONADAS
        $array['tareasS'] = 0;
        $queryTareas = "SELECT count(t_mp_np.id) 'id'
        FROM t_mp_np 
        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
        WHERE t_mp_np.activo = 1 and 
        (t_mp_np.status = 'F' or t_mp_np.status = 'SOLUCIONADO') 
        and t_equipos_america.id_subseccion = $idSubseccion 
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
        WHERE t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
        $totalTareas = 0;
        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
            foreach ($resultTareas as $x) {
                $totalTareas = $x['count(t_mp_np.id)'];
                $array['tareasP'] = intval($totalTareas);
            }
        }

        #PREVENTIVOS SOLUCIONADO POR EQUIPO
        $array['mpS'] = 0;
        $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' 
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id 
        WHERE t_equipos_america.id_subseccion = $idSubseccion and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and t_mp_planificacion_iniciada.activo = 1 and 
        t_mp_planes_mantenimiento.tipo_plan IN('PREVENTIVO', 'CHECKLIST') $filtroDestinoMP";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalMPS = $x['id'];

                $array['mpS'] = $totalMPS;
            }
        }

        #PREVENTIVOS PENDIENTE POR EQUIPO
        $array['mpP'] = 0;
        $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' 
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id 
        WHERE t_equipos_america.id_subseccion = $idSubseccion and t_mp_planificacion_iniciada.status = 'PROCESO' and t_mp_planificacion_iniciada.activo = 1 and 
        t_mp_planes_mantenimiento.tipo_plan IN('PREVENTIVO', 'CHECKLIST') $filtroDestinoMP";
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
        WHERE t_equipos_america.id_subseccion = $idSubseccion and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and t_mp_planificacion_iniciada.activo = 1 and 
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

    #OBTENER PAGINACIÓN
    if ($action == "obtenerPaginacionEquipos") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        if (isset($_POST['palabraEquipo'])) {
            $palabraEquipo = $_POST['palabraEquipo'];
            $filtroPalabra = "";
            if ($palabraEquipo != "") {
                $filtroPalabra = "and t_equipos_america.equipo LIKE '%$palabraEquipo%'";
            }
        } else {
            $filtroPalabra = "";
        }

        $totalEquipos = 0;
        $query = "SELECT count(id)
        FROM t_equipos_america
        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and activo = 1 and 
        status IN('OPERATIVO', 'TALLER', 'FUERASERVICIO', 'OPERAMAL') and jerarquia = 'PRINCIPAL' $filtroPalabra $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalEquipos = $x['count(id)'];
            }

            if ($totalEquipos > 0) {
                $totalPaginas = intval($totalEquipos / 65);
            } else {
                $totalPaginas = 0;
            }
        }
        echo json_encode($totalPaginas);
    }

    #OBTIENE ADJUNTOS DE EQUIPOS (MANUALES)
    if ($action == "obtenerAdjuntosEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT id, documento, fecha_subida 
        FROM t_equipos_documentos 
        WHERE id_equipo = $idEquipo and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idAdjunto = $x['id'];
                $url = $x['documento'];
                $fecha = $x['fecha_subida'];
                $tipo = pathinfo($url, PATHINFO_EXTENSION);

                $array[] = array(
                    "idAdjunto" => intval($idAdjunto),
                    "url" => $url,
                    "fecha" => $fecha,
                    "tipo" => $tipo
                );
            }
        }
        echo json_encode($array);
    }

    #SUBIR ADJUNTOS DE EQUIPOS (MANUALES)
    if ($action == "subirAdjuntosEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $resp = 0;

        // VARIABLES DEL ADJUNTO
        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $nombre = 'ADJUNTO_ID_' . $idEquipo . '_' . rand(50, 1500) . '.' . $extension;

        if (move_uploaded_file($rutaTemporal, '../planner/equipos/' . $nombre)) {
            $query = "INSERT INTO t_equipos_documentos(id_equipo, subido_por, documento, fecha_subida, activo) VALUES($idEquipo, $idUsuario, '$nombre', '$fechaActual', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }

    #OBTIENE COTIZACIONES DE EQUIPOS
    if ($action == "obtenerCotizacionesEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT id, url_archivo, fecha 
        FROM t_equipos_cotizaciones 
        WHERE id_equipo = $idEquipo and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idAdjunto = $x['id'];
                $url = $x['url_archivo'];
                $fecha = $x['fecha'];
                $tipo = pathinfo($url, PATHINFO_EXTENSION);

                $array[] = array(
                    "idAdjunto" => intval($idAdjunto),
                    "url" => $url,
                    "fecha" => $fecha,
                    "tipo" => $tipo
                );
            }
        }
        echo json_encode($array);
    }

    #SUBIR COTIZACIONES DE EQUIPOS
    if ($action == "subirCotizacionesEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $resp = 0;

        // VARIABLES DEL ADJUNTO
        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $nombre = 'COTIZACIONES_ID_' . $idEquipo . '_' . rand(50, 1500) . '.' . $extension;

        if (move_uploaded_file($rutaTemporal, '../planner/equipos/' . $nombre)) {
            $query = "INSERT INTO t_equipos_cotizaciones(id_equipo, url_archivo, fecha, subido_por, activo) VALUES($idEquipo, '$nombre', '$fechaActual', $idUsuario, 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }

    #SUBIR IMEGENES DE EQUIPOS
    if ($action == "obtenerImagenesEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT id, url_adjunto, fecha 
        FROM t_equipos_america_adjuntos
        WHERE id_equipo = $idEquipo and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idImagen = $x['id'];
                $url = $x['url_adjunto'];
                $fecha = $x['fecha'];
                $tipo = pathinfo($url, PATHINFO_EXTENSION);

                $array[] = array(
                    "idImagen" => intval($idImagen),
                    "url" => $url,
                    "fecha" => $fecha,
                    "tipo" => $tipo
                );
            }
        }
        echo json_encode($array);
    }

    #SUBIR IMEGENES DE EQUIPOS
    if ($action == "subirImagenEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $resp = 0;

        // VARIABLES DEL ADJUNTO
        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $nombre = 'EQUIPO_ID_' . $idEquipo . '_' . rand(50, 1500) . '.' . $extension;

        if (move_uploaded_file($rutaTemporal, '../planner/equipos/' . $nombre)) {
            $query = "INSERT INTO t_equipos_america_adjuntos(id_equipo, url_adjunto, fecha, subido_por, activo) VALUES($idEquipo, '$nombre', '$fechaActual', $idUsuario, 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }

    # OBTIENES LAS FALLAS EN GENERAL (PENDIENTES Y SOLUCIONADOS);
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
                if (
                    $rangoFecha != ""
                ) {
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
                if (
                    $status == "N" or $status == "PENDIENTE" or $status == "" or $status == "P"
                ) {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }


                if (
                    $sMaterial > 0
                ) {
                    $materiales = 1;
                } else {
                    $materiales = 0;
                }
                if (
                    $sTrabajando > 0
                ) {
                    $trabajando = 1;
                } else {
                    $trabajando = 0;
                }
                if (
                    $sEnergetico > 0
                ) {
                    $energeticos = 1;
                } else {
                    $energeticos = 0;
                }
                if (
                    $sDepartamento > 0
                ) {
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

    # Consulta el despiece de Equipos incluyendo el Equipo Padre
    if ($action == "despieceEquipos") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT id, equipo, jerarquia, id_equipo_principal 
        FROM t_equipos_america
        WHERE activo = 1 and (id = $idEquipo OR id_equipo_principal = $idEquipo) and status IN('OPERATIVO', 'TALLER', 'FUERASERVICIO', 'OPERAMAL')";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $idPrincipal = $i['id_equipo_principal'];
                $equipo = $i['equipo'];
                $jerarquia = $i['jerarquia'];

                $array[] = array(
                    "id" => "$id",
                    "equipo" => "$equipo",
                    "jerarquia" => "$jerarquia"
                );

                if ($jerarquia == "SECUNDARIO") {
                    $query = "SELECT id, equipo, jerarquia 
                    FROM t_equipos_america 
                    WHERE activo = 1 and id = $idPrincipal and status IN('OPERATIVO', 'TALLER', 'FUERASERVICIO', 'OPERAMAL') LIMIT 1";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $id = $i['id'];
                            $equipo = $i['equipo'];
                            $jerarquia = $i['jerarquia'];

                            $array[0] = array(
                                "id" => "$id",
                                "equipo" => "$equipo",
                                "jerarquia" => "$jerarquia"
                            );
                        }
                    }
                }
            }
            echo json_encode($array);
        }
    }

    # OBTIENE LOS MATERIAL POSIBLE PARA ASIGNAR AL EQUIPO
    if ($action == "obtenerOpcionesMaterialesEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $tipoAsignacion = $_GET['tipoAsignacion'];
        $array = array();

        $query = "SELECT id , cod2bend, descripcion_cod2bend, descripcion_servicio_tecnico, caracteristicas, marca, modelo
        FROM t_subalmacenes_items_globales
        WHERE activo = 1 and id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $cod2bend = $x['cod2bend'];
                $descripcion = $x['descripcion_cod2bend'];
                $sstt = $x['descripcion_servicio_tecnico'];
                $caracteristicas = $x['caracteristicas'];
                $marca = $x['marca'];
                $modelo = $x['modelo'];
                $cantidad = 0;

                $query = "SELECT cantidad FROM t_equipos_materiales 
                WHERE id_equipo = $idEquipo and id_item_global = $idItem and tipo_asignacion = '$tipoAsignacion' and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $cantidad = $x['cantidad'];
                    }
                }

                $array[] = array(
                    "idItem" => $idItem,
                    "cod2bend" => $cod2bend,
                    "descripcion" => $descripcion,
                    "sstt" => $sstt,
                    "caracteristicas" => $caracteristicas,
                    "marca" => $marca,
                    "modelo" => $modelo,
                    "cantidad" => $cantidad
                );
            }
        }
        echo json_encode($array);
    }

    # ASIGNA MATERIAL AL EQUIPO
    if ($action == "asignarMaterialEquipo") {
        $idItem = $_GET['idItem'];
        $idEquipo = $_GET['idEquipo'];
        $cantidad = $_GET['cantidad'];
        $tipoAsignacion = $_GET['tipoAsignacion'];
        $resp = 0;

        $total = 0;
        $query = "SELECT id FROM t_equipos_materiales WHERE id_equipo = $idEquipo and id_item_global = $idItem and tipo_asignacion = '$tipoAsignacion' and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            $total = mysqli_num_rows($result);
        }

        if ($total >= 1) {
            $query = "UPDATE t_equipos_materiales SET cantidad = '$cantidad' WHERE id_equipo = $idEquipo and id_item_global = $idItem and tipo_asignacion = '$tipoAsignacion' and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "ACTUALIZADO";
            }
        } else {
            $query = "INSERT INTO t_equipos_materiales(id_usuario, id_equipo, id_item_global, cantidad, tipo_asignacion, fecha, activo) VALUES($idUsuario, $idEquipo, $idItem, '$cantidad', '$tipoAsignacion', '$fechaActual', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "AGREGADO";
            }
        }
        echo json_encode($resp);
    }

    # OBTIENE EL MATERIAL ASIGNADO AL EQUIPO
    if ($action == "despieceMaterailesEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $tipoAsignacion = $_GET['tipoAsignacion'];
        $array = array();

        $query = "SELECT t_equipos_materiales.id, t_equipos_materiales.cantidad, 
        t_subalmacenes_items_globales.cod2bend, t_subalmacenes_items_globales.descripcion_cod2bend
        FROM t_equipos_materiales 
        INNER JOIN t_subalmacenes_items_globales ON t_equipos_materiales.id_item_global = t_subalmacenes_items_globales.id
        WHERE t_equipos_materiales.id_equipo = $idEquipo and t_equipos_materiales.tipo_asignacion = '$tipoAsignacion' and t_equipos_materiales.activo = 1 and t_equipos_materiales.cantidad > 0";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idRegistro = $x['id'];
                $cantidad = $x['cantidad'];
                $cod2bend = $x['cod2bend'];
                $descripcion = $x['descripcion_cod2bend'];

                $array[] = array(
                    "idRegistro" => intval($idRegistro),
                    "cantidad" => $cantidad,
                    "cod2bend" => $cod2bend,
                    "descripcion" => $descripcion
                );
            }
        }
        echo json_encode($array);
    }
    // Final
}
