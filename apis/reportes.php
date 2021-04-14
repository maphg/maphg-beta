<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../php/conexion.php';
header("Access-Control-Allow-Origin: *");
if (isset($_GET['action'])) {

    //Variables Globales
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $array = array();


    // DETALLES DE LAS SECCIONES
    if ($action == "reporteIncidencias") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        #FILTRO DESTINO
        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and c_destinos.id = $idDestino";
        }

        $query = "SELECT c_destinos.id 'idDestino', c_destinos.destino, c_destinos.ubicacion, c_secciones.id 'idSeccion', c_secciones.seccion
        FROM c_destinos
        INNER JOIN c_rel_destino_seccion ON c_destinos.id = c_rel_destino_seccion.id_destino
        INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_destinos.status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestino = $x['idDestino'];
                $destino = $x['destino'];
                $ubicacion = $x['ubicacion'];
                $idSeccion = $x['idSeccion'];
                $seccion = $x['seccion'];

                $totalIncidencias = 0;
                $actividad = "";
                $fechaCreacion = 0;
                $fechaRealizado = 0;
                $status = 0;
                $pendientes = 0;
                $solucionados = 0;
                $mediaPendientes = 0;
                $mediaSolucionados = 0;
                $totalComentarios = 0;
                $horasPentientesGlobal = 0;
                $horasSolucionadosGlobal = 0;
                $resultado = array();

                #INCIDENCIA EQUIPOS
                $query = "SELECT id, actividad, fecha_creacion, fecha_realizado, status FROM t_mc
                WHERE id_destino = $idDestino and id_seccion = $idSeccion and activo = 1 and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and ((fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin') OR 
                (fecha_realizado BETWEEN '$fechaInicio' and '$fechaFin')) and id_equipo > 0";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalIncidencias++;
                        $idActividad = $x['id'];
                        $actividad = $x['actividad'];
                        $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('Y-m-d H:m:s');
                        $fechaRealizado = $x['fecha_realizado'];
                        $status = $x['status'];
                        $tiempoPendiente = 0;
                        $tiempoSolucionado = 0;

                        #OBTIENE TIEMPOS EN HORAS
                        $horasCreacion = strtotime($fechaCreacion);
                        $horasSolucionado = strtotime($fechaRealizado);
                        $horasActual = strtotime($fechaActual);

                        $query = "SELECT count(id) 'total' FROM t_mc_comentarios 
                        WHERE id_mc = $idActividad and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $totalComentarios += intval($x['total']);
                            }
                        }

                        if ($status == "PENDIENTE" || $status == "N") {
                            $pendientes++;

                            if ($horasActual > 0 && $horasCreacion > 0) {
                                $tiempoPendiente = ($horasActual - $horasCreacion) / 3600;
                                $horasPentientesGlobal += $tiempoPendiente;
                            }

                            $resultado['PENDIENTE'][] = array(
                                "idOT" => intval($idActividad),
                                "incidencia" => $actividad,
                                "fechaCreacion" => $fechaCreacion,
                                "fechaFinalizado" => $fechaRealizado,
                                "tiempo" => number_format($tiempoPendiente, 2, '.', ''),
                                "status" => "PENDIENTE"
                            );
                        } else {
                            $solucionados++;

                            if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                $tiempoSolucionado = ($horasSolucionado - $horasCreacion) / 3600;
                                $horasSolucionadosGlobal += $tiempoSolucionado;
                            }

                            $resultado['SOLUCIONADO'][] = array(
                                "idOT" => intval($idActividad),
                                "incidencia" => $actividad,
                                "fechaCreacion" => $fechaCreacion,
                                "fechaFinalizado" => $fechaRealizado,
                                "tiempo" => number_format($tiempoSolucionado, 2, '.', ''),
                                "status" => "SOLUCIONADO"
                            );
                        }
                    }
                }


                #INCIDENCIA GENERAL
                $query = "SELECT id, titulo, fecha, fecha_finalizado, status 
                FROM t_mp_np
                WHERE id_destino = $idDestino and id_seccion = $idSeccion and activo = 1 and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and ((fecha BETWEEN '$fechaInicio' and '$fechaFin') OR 
                (fecha_finalizado BETWEEN '$fechaInicio' and '$fechaFin')) and id_equipo = 0";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalIncidencias++;
                        $idActividad = $x['id'];
                        $actividad = $x['titulo'];
                        $fechaCreacion = (new DateTime($x['fecha']))->format('Y-m-d H:m:s');
                        $fechaRealizado = $x['fecha_finalizado'];
                        $status = $x['status'];
                        $tiempoPendiente = 0;
                        $tiempoSolucionado = 0;

                        #OBTIENE TIEMPOS EN HORAS
                        $horasCreacion = strtotime($fechaCreacion);
                        $horasSolucionado = strtotime($fechaRealizado);
                        $horasActual = strtotime($fechaActual);

                        $query = "SELECT count(id) 'total' FROM comentarios_mp_np 
                        WHERE id_mp_np = $idActividad and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $totalComentarios += intval($x['total']);
                            }
                        }


                        if ($status == "PENDIENTE" || $status == "N") {
                            $pendientes++;

                            if ($horasActual > 0 && $horasCreacion > 0) {
                                $tiempoPendiente = ($horasActual - $horasCreacion) / 3600;
                                $horasPentientesGlobal += $tiempoPendiente;
                            }


                            $resultado['PENDIENTE'][] = array(
                                "idOT" => intval($idActividad),
                                "incidencia" => $actividad,
                                "fechaCreacion" => $fechaCreacion,
                                "fechaFinalizado" => $fechaRealizado,
                                "tiempo" => number_format($tiempoPendiente, 2, '.', ''),
                                "status" => "PENDIENTE"
                            );
                        } else {
                            $solucionados++;

                            if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                $tiempoSolucionado = ($horasSolucionado - $horasCreacion) / 3600;
                                $horasSolucionadosGlobal += $tiempoSolucionado;
                            }

                            $resultado['SOLUCIONADO'][] = array(
                                "idOT" => intval($idActividad),
                                "incidencia" => $actividad,
                                "fechaCreacion" => $fechaCreacion,
                                "fechaFinalizado" => $fechaRealizado,
                                "tiempo" => number_format($tiempoSolucionado, 2, '.', ''),
                                "status" => "SOLUCIONADO"
                            );
                        }
                    }
                }


                #MEDIA DE PENDIENTES POR HORAS
                if ($horasPentientesGlobal > 0 && $pendientes > 0) {
                    $mediaPendientes = $horasPentientesGlobal / $pendientes;
                }


                #MEDIA DE SOLUCIONADOS POR HORAS_SOLUCIONADO
                if ($horasSolucionadosGlobal > 0 && $solucionados > 0) {
                    $mediaSolucionados = $horasSolucionadosGlobal / $solucionados;
                }


                $array[$idDestino][$seccion] =
                    array(
                        "destino" => $destino,
                        "ubicacion" => $ubicacion,
                        "idSeccion" => intval($idSeccion),
                        "seccion" => $seccion,
                        "total" => intval($totalIncidencias),
                        "totalPendientes" => intval($pendientes),
                        "totalSolucionados" => intval($solucionados),
                        "mediaPendientes" => intval($mediaPendientes),
                        "mediaSolucionados" => intval($mediaSolucionados),
                        "totalComentarios" => $totalComentarios,
                        "resumen" => $resultado
                    );
            }
        }
        echo json_encode($array);
    }


    // REPORTE (DETALLES Y ARRAY PARA GRAFICAR)
    if ($action == "reporteIncidenciasGlobal") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and c_destinos.id =  $idDestino";
        }

        $query = "SELECT id, destino, ubicacion FROM c_destinos WHERE status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestino = $x['id'];
                $destino = $x['destino'];
                $ubicacion = $x['ubicacion'];

                $totalIncidencias = 0;
                $actividad = "";
                $fechaCreacion = 0;
                $fechaRealizado = 0;
                $status = 0;
                $pendientes = 0;
                $solucionados = 0;
                $mediaPendientes = 0;
                $mediaSolucionados = 0;
                $totalComentarios = 0;
                $horasPentientesGlobal = 0;
                $horasSolucionadosGlobal = 0;
                $tiempoPendiente = 0;
                $tiempoSolucionado = 0;
                $contador = 0;


                #INCIDENCIA EQUIPOS
                $query = "SELECT id, actividad, fecha_creacion, fecha_realizado, status 
                FROM t_mc
                WHERE id_destino = $idDestino and activo = 1 and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and 
                ((fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin') OR
                (fecha_realizado BETWEEN '$fechaInicio' and '$fechaFin'))
                and id_equipo > 0";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalIncidencias++;
                        $idActividad = $x['id'];
                        $actividad = $x['actividad'];
                        $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('Y-m-d H:m:s');
                        $fechaRealizado = $x['fecha_realizado'];
                        $status = $x['status'];
                        $contador++;

                        #OBTIENE TIEMPOS EN HORAS
                        $horasCreacion = strtotime($fechaCreacion);
                        $horasSolucionado = strtotime($fechaRealizado);
                        $horasActual = strtotime($fechaActual);

                        $query = "SELECT count(id) 'total' FROM t_mc_comentarios 
                                WHERE id_mc = $idActividad and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $totalComentarios += intval($x['total']);
                            }
                        }

                        if ($status == "PENDIENTE" || $status == "N") {
                            $pendientes++;

                            if ($horasActual > 0 && $horasCreacion > 0) {
                                $tiempoPendiente += ($horasActual - $horasCreacion) / 3600;
                            }
                        } else {
                            $solucionados++;

                            if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                $tiempoSolucionado += ($horasSolucionado - $horasCreacion) / 3600;
                            }
                        }
                    }
                }

                #INCIDENCIAS GENERALES
                $query = "SELECT id, fecha, fecha_finalizado, status 
                FROM t_mp_np
                WHERE id_destino = $idDestino and activo = 1 and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and 
                ((fecha BETWEEN '$fechaInicio' and '$fechaFin') OR
                (fecha_finalizado BETWEEN '$fechaInicio' and '$fechaFin'))
                and id_equipo = 0";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalIncidencias++;
                        $idActividad = $x['id'];
                        $fechaCreacion = (new DateTime($x['fecha']))->format('Y-m-d H:m:s');
                        $fechaRealizado = $x['fecha_finalizado'];
                        $status = $x['status'];
                        $contador++;

                        #OBTIENE TIEMPOS EN HORAS
                        $horasCreacion = strtotime($fechaCreacion);
                        $horasSolucionado = strtotime($fechaRealizado);
                        $horasActual = strtotime($fechaActual);

                        $query = "SELECT count(id) 'total' FROM comentarios_mp_np
                                WHERE id_mp_np = $idActividad and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $totalComentarios += intval($x['total']);
                            }
                        }

                        if ($status == "PENDIENTE" || $status == "N") {
                            $pendientes++;

                            if ($horasActual > 0 && $horasCreacion > 0) {
                                $tiempoPendiente += ($horasActual - $horasCreacion) / 3600;
                            }
                        } else {
                            $solucionados++;

                            if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                $tiempoSolucionado += ($horasSolucionado - $horasCreacion) / 3600;
                            }
                        }
                    }
                }


                #ARRAY PARA GRAFICA DE FECHAS
                $grafica = array();

                # Fecha como segundos
                $tiempoInicio = strtotime($fechaInicio);
                $tiempoFin = strtotime($fechaFin);
                $totalInicio = 0;
                $fechaX = "";

                while ($tiempoInicio <= $tiempoFin) {
                    $fechaX = date('Y-m-d', $tiempoInicio);
                    $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                    $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86399));
                    $totalPendientes = 0;
                    $totalSolucionados = 0;

                    $query = "SELECT id FROM t_mc
                    WHERE id_destino = $idDestino and activo = 1 and status IN('PENDIENTE', 'N') and ((fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR
                    (fecha_realizado BETWEEN '$fechaA' and '$fechaB'))
                    and id_equipo > 0";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $totalInicio++;
                            $totalPendientes++;
                        }
                    }

                    $query = "SELECT id FROM t_mc
                    WHERE id_destino = $idDestino and activo = 1 and status IN('SOLUCIONADO', 'F') and 
                    ((fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR
                    (fecha_realizado BETWEEN '$fechaA' and '$fechaB'))
                    and id_equipo > 0";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $totalInicio++;
                            $totalSolucionados++;
                        }
                    }

                    $grafica['PROCESO'][$fechaX] = $totalInicio;
                    $grafica['CREADAS'][$fechaX] = $totalPendientes;
                    $grafica['SOLUCIONADOS'][$fechaX] = $totalSolucionados;


                    $tiempoInicio += 86400;
                }


                $graficaSecciones = array();
                $query = "SELECT c_secciones.id, c_secciones.seccion 
                FROM c_rel_destino_seccion
                INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
                WHERE id_destino = $idDestino";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idSeccion = $x['id'];
                        $seccion = $x['seccion'];

                        # Fecha como segundos
                        $tiempoInicio = strtotime($fechaInicio);
                        $tiempoFin = strtotime($fechaFin);
                        $totalInicio = 0;

                        $graficaSecciones['CREADAS'] = array();
                        $graficaSecciones['PROCESO'] = array();
                        $graficaSecciones['SOLUCIONADOS'] = array();

                        while ($tiempoInicio <= $tiempoFin) {
                            $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                            $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86399));
                            $fechaZ = date("Y-m-d", $tiempoInicio);
                            $totalPendientes = 0;
                            $totalSolucionados = 0;

                            $query = "SELECT id FROM t_mc
                            WHERE id_seccion = $idSeccion and id_destino = $idDestino and activo = 1 and status IN('PENDIENTE', 'N') and ((fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR
                            (fecha_realizado BETWEEN '$fechaA' and '$fechaB'))
                            and id_equipo > 0";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $totalInicio++;
                                    $totalPendientes++;
                                }
                            }

                            $query = "SELECT id FROM t_mc
                            WHERE id_seccion = $idSeccion and id_destino = $idDestino and activo = 1 and status IN('SOLUCIONADO', 'F') and 
                            ((fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR
                            (fecha_realizado BETWEEN '$fechaA' and '$fechaB'))
                            and id_equipo > 0";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $totalInicio++;
                                    $totalSolucionados++;
                                }
                            }

                            #INCIDENCIAS GRAFICA
                            $graficaSecciones['CREADAS'][$fechaZ] = $totalPendientes;
                            $graficaSecciones['PROCESO'][$fechaZ] = $totalInicio;
                            $graficaSecciones['SOLUCIONADOS'][$fechaZ] = $totalSolucionados;

                            $tiempoInicio += 86400;
                        }

                        $graficaSecciones[$idSeccion] =
                            array(
                                [
                                    "name" => "CREADAS",
                                    "data" =>  $graficaSecciones['CREADAS']
                                ],
                                [
                                    "name" => "PROCESO",
                                    "data" =>  $graficaSecciones['PROCESO']
                                ],
                                [
                                    "name" => "SOLUCIONADOS",
                                    "data" =>  $graficaSecciones['SOLUCIONADOS']
                                ]
                            );
                    }
                }

                #MEDIA PARA SOLUCIONADOS
                if ($tiempoSolucionado > 0 && $solucionados > 0) {
                    $mediaSolucionados = $tiempoSolucionado / $solucionados;
                } else {
                    $mediaSolucionados = 0;
                }

                #MEDIA PARA PENDIENTES
                if ($tiempoPendiente > 0 && $pendientes > 0) {
                    $mediaPendientes = $tiempoPendiente / $pendientes;
                } else {
                    $mediaPendientes = 0;
                }

                #ARRAY CON RESULTADOS
                $array[$destino] = array(
                    "idDestino" => intval($idDestino),
                    "destino" => $destino,
                    "ubicacion" => $ubicacion,
                    "pendientes" => intval($pendientes),
                    "solucionados" => intval($solucionados),
                    "comentarios" => intval($totalComentarios),
                    "total" => intval($contador),
                    "mediaPendientes" => intval($mediaPendientes),
                    "mediaSolucionados" => intval($mediaSolucionados),
                    "grafica" =>
                    [
                        ["name" => "CREADAS", "data" => $grafica['CREADAS']],
                        ["name" => "PROCESO", "data" => $grafica['PROCESO']],
                        ["name" => "SOLUCIONADOS", "data" => $grafica['SOLUCIONADOS']]
                    ],
                    "graficaSecciones" => $graficaSecciones
                );
            }
        }
        echo json_encode($array);
    }


    #RANKIN DE TIEMPOS
    if ($action == "ranking") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        $query = "SELECT id, destino FROM c_destinos WHERE status = 'A'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['id'];
                $destino = $x['destino'];

                $enProceso = 0;
                $fechaCreacion = 0;
                $fechaRealizado = 0;
                $creados = 0;
                $solucionados = 0;
                $mediaSolucionados = 0;

                # Fecha como segundos
                $tiempoInicio = strtotime($fechaInicio);
                $tiempoFin = strtotime($fechaFin);
                $fechaX = "";

                while ($tiempoInicio <= $tiempoFin) {

                    $fechaX = date('Y-m-d', $tiempoInicio);
                    $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                    $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                    #INCIDENCIA EQUIPOS
                    $query = "SELECT id, fecha_creacion, fecha_realizado, status
                    FROM t_mc
                    WHERE id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                    ((fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                    (fecha_realizado BETWEEN '$fechaA' and '$fechaB'))";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $fechaCreacion = $x['fecha_creacion'];
                            $fechaFinalizado = $x['fecha_realizado'];
                            $status = $x['status'];

                            $enProceso++;

                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            if ($status == "PENDIENTE" || $status == "N") {
                                $creados++;
                            } else {
                                $solucionados++;

                                #OBTIENE TIEMPO EN HORAS DE SOLUCIONADO
                                if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                    $mediaSolucionados += ($horasSolucionado - $horasCreacion) / 3600;
                                }
                            }
                        }
                    }

                    #INCIDENCIAS GENERALES
                    $query = "SELECT id, fecha, fecha_finalizado, status
                    FROM t_mp_np
                    WHERE id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo = 0 and
                    ((fecha BETWEEN '$fechaA' and '$fechaB') OR 
                    (fecha_finalizado BETWEEN '$fechaA' and '$fechaB'))";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $fechaCreacion = $x['fecha'];
                            $fechaFinalizado = $x['fecha_finalizado'];
                            $status = $x['status'];
                            $tiempoSolucionado = 0;
                            $enProceso++;
                            $idDestinoX;

                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            if ($status == "PENDIENTE" || $status == "N") {
                                $creados++;
                            } else {
                                $solucionados++;

                                #OBTIENE TIEMPO EN HORAS DE SOLUCIONADO
                                if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                    $mediaSolucionados += ($horasSolucionado - $horasCreacion) / 3600;
                                }
                            }
                        }
                    }

                    $tiempoInicio += 86400;
                }

                #ALMACENA RESULTADOS DE RANKING
                if ($mediaSolucionados > 0 && $solucionados > 0) {
                    $mediaSolucionados = $mediaSolucionados / $solucionados;
                }

                $array[$idDestinoX] =
                    array(
                        "idDestino" => intval($idDestinoX),
                        "destino" => $destino,
                        "enProceso" => intval($enProceso),
                        "creados" => intval($creados),
                        "solucionados" => intval($solucionados),
                        "mediaSolucionados" => intval($mediaSolucionados)
                    );
            }
        }
        echo json_encode($array);
    }


    if ($action == "reporte") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id = $idDestino";
        }

        $query = "SELECT id, destino, ubicacion FROM c_destinos WHERE status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['id'];
                $destino = $x['destino'];
                $ubicacion = $x['ubicacion'];

                $creadas_G = 0;
                $enProceso_G = 0;
                $solucionadas_G = 0;
                $mediaEnProceso_G = 0;
                $mediaSolucionados_G = 0;
                $grafica = array();

                $query = "SELECT c_secciones.id, c_secciones.seccion
                FROM c_rel_destino_seccion AS rel
                INNER JOIN c_secciones ON rel.id_seccion = c_secciones.id
                WHERE rel.id_destino = $idDestinoX ORDER BY id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idSeccion = $x['id'];
                        $seccion = $x['seccion'];

                        #VARIABLES GLOBALES POR SECCION
                        $creadas = 0;
                        $enProceso = 0;
                        $solucionadas = 0;

                        # Fecha como segundos
                        $tiempoInicio = strtotime($fechaInicio);
                        $tiempoFin = strtotime($fechaFin);
                        $fechaX = "";

                        #ARRAY GRAFICA SECCIONES
                        $graficaSecciones = array();

                        #MEDIA
                        $mediaEnProceso = 0;
                        $mediaSolucionados = 0;


                        while ($tiempoInicio <= $tiempoFin) {

                            $fechaX = date('Y-m-d', $tiempoInicio);
                            $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                            $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                            #CONTADORES TOTAL
                            $creadas_dia = 0;
                            $enProceso_dia = 0;
                            $solucionadas_dia = 0;

                            #INCIDENCIAS EQUIPOS
                            $query = "SELECT id, fecha_creacion, fecha_realizado, status
                            FROM t_mc
                            WHERE id_seccion = $idSeccion and id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                            (
                                (fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                                (fecha_realizado BETWEEN '$fechaA' and '$fechaB')
                            )";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $totalIncidencia = $x['id'];
                                    $fechaCreacion = $x['fecha_creacion'];
                                    $fechaFinalizado = $x['fecha_realizado'];
                                    $status = $x['status'];

                                    // CONTADORES TOTAL
                                    $enProceso++;
                                    $enProceso_dia++;
                                    $enProceso_G++;

                                    #OBTIENE TIEMPOS EN HORAS
                                    $horasCreacion = strtotime($fechaCreacion);
                                    $horasSolucionado = strtotime($fechaFinalizado);
                                    $horasActual = strtotime($fechaActual);

                                    if ($status == "PENDIENTE" || $status == "N") {
                                        $creadas++;
                                        $creadas_dia++;
                                        $creadas_G++;

                                        #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                        if ($horasCreacion > 0 && $horasActual > 0) {
                                            $mediaEnProceso += ($horasActual - $horasCreacion) / 3600;
                                        }
                                    } else {

                                        #OBTIENE TIEMPO EN HORAS DE SOLUCIONADO
                                        if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                            $mediaSolucionados += ($horasSolucionado - $horasCreacion) / 3600;
                                        }

                                        $solucionadas++;
                                        $solucionadas_dia++;
                                        $solucionadas_G++;
                                    }
                                }
                            }

                            #INCIDENCIAS GENERALES
                            $query = "SELECT id, fecha, fecha_finalizado, status
                            FROM t_mp_np
                            WHERE id_seccion = $idSeccion and id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo = 0 and
                            (
                                (fecha BETWEEN '$fechaA' and '$fechaB') OR 
                                (fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                            )";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $totalIncidencia = $x['id'];
                                    $fechaCreacion = $x['fecha'];
                                    $fechaFinalizado = $x['fecha_finalizado'];
                                    $status = $x['status'];

                                    # CONTADORES TOTAL
                                    $enProceso++;
                                    $enProceso_dia++;
                                    $enProceso_G++;

                                    #OBTIENE TIEMPOS EN HORAS
                                    $horasCreacion = strtotime($fechaCreacion);
                                    $horasSolucionado = strtotime($fechaFinalizado);
                                    $horasActual = strtotime($fechaActual);

                                    if ($status == "PENDIENTE" || $status == "N") {
                                        $creadas++;
                                        $creadas_dia++;
                                        $creadas_G++;

                                        #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                        if ($horasCreacion > 0 && $horasActual > 0) {
                                            $mediaEnProceso += ($horasActual - $horasCreacion) / 3600;
                                        }
                                    } else {

                                        #OBTIENE TIEMPO EN HORAS DE SOLUCIONADO
                                        if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                            $mediaSolucionados += ($horasSolucionado - $horasCreacion) / 3600;
                                        }
                                        $solucionadas++;
                                        $solucionadas_dia++;
                                        $solucionadas_G++;
                                    }
                                }
                            }

                            #GRAFICA SECCIONES
                            $graficaSecciones['creadas'][$fechaX] = $creadas_dia;
                            $graficaSecciones['enProceso'][$fechaX] = $enProceso_dia;
                            $graficaSecciones['solucionadas'][$fechaX] = $solucionadas_dia;

                            #GRAFICA CREADAS
                            if (isset($grafica['creadas'][$fechaX])) {
                                $grafica['creadas'][$fechaX] =
                                    $grafica['creadas'][$fechaX] + $creadas_dia;
                            } else {
                                $grafica['creadas'][$fechaX] = $creadas_dia;
                            }

                            #GRAFICA ENPROCESO
                            if (isset($grafica['enProceso'][$fechaX])) {
                                $grafica['enProceso'][$fechaX] =
                                    $grafica['enProceso'][$fechaX] + $enProceso_dia;
                            } else {
                                $grafica['enProceso'][$fechaX] = $enProceso_dia;
                            }

                            #GRAFICA SOLUCIONADAS
                            if (isset($grafica['solucionadas'][$fechaX])) {
                                $grafica['solucionadas'][$fechaX] =
                                    $grafica['solucionadas'][$fechaX] + $solucionadas_dia;
                            } else {
                                $grafica['solucionadas'][$fechaX] = $solucionadas_dia;
                            }

                            #AUMENTA UN DÍA
                            $tiempoInicio += 86400;
                        }

                        #MEDIA EN PROCESO
                        if ($mediaEnProceso > 0 && $enProceso > 0) {
                            $mediaEnProceso_G += $mediaEnProceso;
                            $mediaEnProceso = $mediaEnProceso / $enProceso;
                        } else {
                            $mediaEnProceso = 0;
                        }

                        #MEDIA SOLUCIONADOS
                        if ($mediaSolucionados > 0 && $solucionadas > 0) {
                            $mediaSolucionados_G += $mediaSolucionados;
                            $mediaSolucionados = $mediaSolucionados / $solucionadas;
                        } else {
                            $mediaSolucionados = 0;
                        }

                        $arraySecciones[$idSeccion] = array(
                            "idSeccion" => $idSeccion,
                            "seccion" => $seccion,
                            "creadas" => intval($creadas),
                            "enProceso" => intval($enProceso),
                            "solucionadas" => intval($solucionadas),
                            "mediaEnProceso" => intval($mediaEnProceso),
                            "mediaSolucionados" => intval($mediaSolucionados),
                            "grafica" =>
                            [
                                ["name" => "creadas", "data" => $graficaSecciones['creadas']],
                                ["name" => "enProceso", "data" => $graficaSecciones['enProceso']],
                                ["name" => "solucionadas", "data" => $graficaSecciones['solucionadas']]
                            ],

                        );
                    }
                }

                #MEDIA EN PROCESO
                if ($mediaEnProceso_G > 0 && $enProceso_G > 0) {
                    $mediaEnProceso_G = $mediaEnProceso_G / $enProceso_G;
                } else {
                    $mediaEnProceso_G = 0;
                }

                #MEDIA SOLUCIONADOS
                if ($mediaSolucionados_G > 0 && $solucionadas_G > 0) {
                    $mediaSolucionados_G = $mediaSolucionados_G / $solucionadas_G;
                } else {
                    $mediaSolucionados_G = 0;
                }

                #ARRAY PRINCIPAL
                $array[$idDestinoX] = array(
                    "idDestino" => $idDestinoX,
                    "destino" => $destino,
                    "ubicacion" => $ubicacion,
                    "creadas" => $creadas_G,
                    "enProceso" => $enProceso_G,
                    "solucionadas" => $solucionadas_G,
                    "mediaEnProceso" => intval($mediaEnProceso_G),
                    "mediaSolucionados" => intval($mediaSolucionados_G),
                    "grafica" =>  [
                        ["name" => "creadas", "data" => $grafica['creadas']],
                        ["name" => "enProceso", "data" => $grafica['enProceso']],
                        ["name" => "solucionadas", "data" => $grafica['solucionadas']],
                    ],
                    "secciones" => $arraySecciones,
                );
            }
        }
        echo json_encode($array);
    }
}
