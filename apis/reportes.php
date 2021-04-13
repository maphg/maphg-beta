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
            $filtroDestino = "and c_destinos.id = " . $idDestino;
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
                $query = "SELECT id, actividad, fecha_creacion, fecha_realizado, status FROM t_mc
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

                    $grafica['CREADAS'][$fechaX] = $totalInicio;
                    $grafica['PROCESO'][$fechaX] = $totalPendientes;
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

                            #CREADAS
                            $graficaSecciones['CREADAS'][$fechaZ] = $totalPendientes;
                            $graficaSecciones['PROCESO'][$fechaZ] = $totalSolucionados;
                            $graficaSecciones['SOLUCIONADOS'][$fechaZ] = $totalInicio;

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

                $totalIncidencias = 0;
                $fechaCreacion = 0;
                $fechaRealizado = 0;
                $creados = 0;
                $solucionados = 0;
                $mediaSolucionados = 0;
                $horasSolucionadosGlobal = 0;
                $totalIncidencias = 0;

                #INCIDENCIA EQUIPOS
                $query = "SELECT fecha_creacion, fecha_realizado, status 
                FROM t_mc
                WHERE id_destino = $idDestinoX and activo = 1 and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and ((fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin') OR
                (fecha_realizado BETWEEN '$fechaInicio' and '$fechaFin')) and id_equipo > 0";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $fechaCreacion = $x['fecha_creacion'];
                        $fechaRealizado = $x['fecha_realizado'];
                        $status = $x['status'];
                        $tiempoSolucionado = 0;
                        $totalIncidencias++;
                        $idDestinoX;

                        #OBTIENE TIEMPOS EN HORAS
                        $horasCreacion = strtotime($fechaCreacion);
                        $horasSolucionado = strtotime($fechaRealizado);

                        if ($status == "PENDIENTE" || $status == "N") {
                            $creados++;
                        } else {
                            if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                $tiempoSolucionado = ($horasSolucionado - $horasCreacion) / 3600;
                                $horasSolucionadosGlobal += $tiempoSolucionado;
                            }
                            $solucionados++;
                        }
                    }
                }

                #INCIDENCIA GENERALES
                $query = "SELECT fecha, fecha_finalizado, status 
                FROM t_mp_np
                WHERE id_destino = $idDestinoX and activo = 1 and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and ((fecha BETWEEN '$fechaInicio' and '$fechaFin') OR
                (fecha_finalizado BETWEEN '$fechaInicio' and '$fechaFin')) and id_equipo = 0";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $fechaCreacion = $x['fecha'];
                        $fechaRealizado = $x['fecha_finalizado'];
                        $status = $x['status'];
                        $tiempoSolucionado = 0;
                        $totalIncidencias++;
                        $idDestinoX;

                        #OBTIENE TIEMPOS EN HORAS
                        $horasCreacion = strtotime($fechaCreacion);
                        $horasSolucionado = strtotime($fechaRealizado);

                        if ($status == "PENDIENTE" || $status == "N") {
                            $creados++;
                        } else {
                            if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                $tiempoSolucionado = ($horasSolucionado - $horasCreacion) / 3600;
                                $horasSolucionadosGlobal += $tiempoSolucionado;
                            }
                            $solucionados++;
                        }
                    }
                }

                #ALMACENA RESULTADOS DE RANKING
                if ($horasSolucionadosGlobal > 0 && $solucionados > 0) {
                    $mediaSolucionados = $horasSolucionadosGlobal / $solucionados;
                }

                $array[$idDestinoX] =
                    array(
                        "idDestino" => intval($idDestinoX),
                        "destino" => $destino,
                        "totalIncidencias" => intval($totalIncidencias),
                        "creados" => intval($creados),
                        "solucionados" => intval($solucionados),
                        "mediaSolucionados" => intval($mediaSolucionados)
                    );
            }
        }
        echo json_encode($array);
    }
}
