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


    #RANKIN DE TIEMPOS
    if ($action == "ranking") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        $query = "SELECT id, destino, habitaciones FROM c_destinos WHERE status = 'A' and id NOT IN(10)";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['id'];
                $destino = $x['destino'];
                $habitaciones = $x['habitaciones'];

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

                #IDS PARA EVITAR REPETIDOS
                $idA = array();
                $idB = array();

                while ($tiempoInicio <= $tiempoFin) {

                    $fechaX = date('Y-m-d', $tiempoInicio);
                    $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                    $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                    if (count($idA) > 0) {
                        $idx = implode(',', $idA);
                    } else {
                        $idx = 0;
                    }

                    #INCIDENCIA EQUIPOS
                    $query = "SELECT id, fecha_creacion, fecha_realizado, status
                    FROM t_mc
                    WHERE id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                    (
                        (fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                        (fecha_realizado BETWEEN '$fechaA' and '$fechaB')
                    ) and id NOT IN($idx)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idIncidencia = $x['id'];
                            $fechaCreacion = $x['fecha_creacion'];
                            $fechaFinalizado = $x['fecha_realizado'];
                            $status = $x['status'];

                            $creados++;


                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            $idA[] = $idIncidencia;

                            if ($status == "PENDIENTE" || $status == "N") {
                                $enProceso++;
                            } else {

                                $solucionados++;

                                #OBTIENE TIEMPO EN HORAS DE SOLUCIONADO
                                if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                    $mediaSolucionados += ($horasSolucionado - $horasCreacion) / 3600;
                                }
                            }
                        }
                    }

                    if (count($idB) > 0) {
                        $idy = implode(',', $idB);
                    } else {
                        $idy = 0;
                    }

                    #INCIDENCIAS GENERALES
                    $query = "SELECT id, fecha, fecha_finalizado, status
                    FROM t_mp_np
                    WHERE id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo = 0 and
                    (
                        (fecha BETWEEN '$fechaA' and '$fechaB') OR 
                        (fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                    ) and id NOT IN($idy)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idIncidencia = $x['id'];
                            $fechaCreacion = $x['fecha'];
                            $fechaFinalizado = $x['fecha_finalizado'];
                            $status = $x['status'];
                            $tiempoSolucionado = 0;
                            $idDestinoX;

                            $creados++;

                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            $idB[] = $idIncidencia;

                            if ($status == "PENDIENTE" || $status == "N") {
                                $enProceso++;
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

                $array['creados'][$destino] =  intval($creados);
                $array['solucionados'][$destino] = intval($solucionados);
                $array['mediaSolucionados'][$destino] = intval($mediaSolucionados);
                $array['habitaciones'] = intval($habitaciones);
            }
        }
        arsort($array['creados']);
        arsort($array['solucionados']);
        arsort($array['mediaSolucionados']);

        foreach ($array['creados'] as $key => $value) {
            $array['creadosX'][] = ["destino" => $key, "valor" => $value];
        }

        foreach ($array['solucionados'] as $key => $value) {
            $array['solucionadosX'][] = ["destino" => $key, "valor" => $value];
        }

        foreach ($array['mediaSolucionados'] as $key => $value) {
            $array['mediaSolucionadosX'][] = ["destino" => $key, "valor" => $value];
        }

        unset($array['creados']);
        unset($array['solucionados']);
        unset($array['mediaSolucionados']);

        echo json_encode($array);
    }


    #REPORTE DE INCIDENCIAS POR SECCIONES
    if ($action == "reporte") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id = $idDestino";
        }

        $query = "SELECT id, destino, habitaciones, ubicacion FROM c_destinos WHERE status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['id'];
                $destino = $x['destino'];
                $ubicacion = $x['ubicacion'];
                $habitaciones = $x['habitaciones'];

                $creadas_G = 0;
                $enProceso_G = 0;
                $solucionadas_G = 0;
                $mediaEnProceso_G = 0;
                $mediaSolucionados_G = 0;
                $grafica = array();

                $query = "SELECT c_secciones.id, c_secciones.seccion
                FROM c_rel_destino_seccion AS rel
                INNER JOIN c_secciones ON rel.id_seccion = c_secciones.id
                WHERE rel.id_destino = $idDestinoX and rel.id_seccion NOT IN(1001, 23) ORDER BY id DESC";
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

                        #IDS PARA EVITAR REPETIDOS
                        $idA = array();
                        $idB = array();

                        while ($tiempoInicio <= $tiempoFin) {

                            $fechaX = date('Y-m-d', $tiempoInicio);
                            $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                            $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                            #CONTADORES TOTAL
                            $creadas_dia = 0;
                            $enProceso_dia = 0;
                            $solucionadas_dia = 0;

                            if (count($idA) > 0) {
                                $idx = implode(',', $idA);
                            } else {
                                $idx = 0;
                            }

                            #INCIDENCIAS EQUIPOS
                            $query = "SELECT id, fecha_creacion, fecha_realizado, status
                            FROM t_mc
                            WHERE id_seccion = $idSeccion and id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                            (
                                (fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                                (fecha_realizado BETWEEN '$fechaA' and '$fechaB')
                            ) and id NOT IN($idx)";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idIncidencia = $x['id'];
                                    $fechaCreacion = $x['fecha_creacion'];
                                    $fechaFinalizado = $x['fecha_realizado'];
                                    $status = $x['status'];

                                    // CONTADORES TOTAL
                                    $creadas++;
                                    $creadas_dia++;
                                    $creadas_G++;

                                    #OBTIENE TIEMPOS EN HORAS
                                    $horasCreacion = strtotime($fechaCreacion);
                                    $horasSolucionado = strtotime($fechaFinalizado);
                                    $horasActual = strtotime($fechaActual);

                                    if ($status == "PENDIENTE" || $status == "N") {
                                        $enProceso++;
                                        $enProceso_dia++;
                                        $enProceso_G++;

                                        #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                        if ($horasCreacion > 0 && $horasActual > 0) {
                                            $mediaEnProceso += ($horasActual - $horasCreacion) / 3600;
                                        }
                                    } else {
                                        $idA[] = $idIncidencia;

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

                            if (count($idB) > 0) {
                                $idy = implode(',', $idB);
                            } else {
                                $idy = 0;
                            }

                            #INCIDENCIAS GENERALES
                            $query = "SELECT id, fecha, fecha_finalizado, status
                            FROM t_mp_np
                            WHERE id_seccion = $idSeccion and id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo = 0 and
                            (
                                (fecha BETWEEN '$fechaA' and '$fechaB') OR 
                                (fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                            ) and id NOT IN($idy)";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idIncidencia = $x['id'];
                                    $fechaCreacion = $x['fecha'];
                                    $fechaFinalizado = $x['fecha_finalizado'];
                                    $status = $x['status'];

                                    # CONTADORES TOTAL
                                    $creadas++;
                                    $creadas_dia++;
                                    $creadas_G++;

                                    #OBTIENE TIEMPOS EN HORAS
                                    $horasCreacion = strtotime($fechaCreacion);
                                    $horasSolucionado = strtotime($fechaFinalizado);
                                    $horasActual = strtotime($fechaActual);

                                    if ($status == "PENDIENTE" || $status == "N") {
                                        $enProceso++;
                                        $enProceso_dia++;
                                        $enProceso_G++;

                                        #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                        if ($horasCreacion > 0 && $horasActual > 0) {
                                            $mediaEnProceso += ($horasActual - $horasCreacion) / 3600;
                                        }
                                    } else {
                                        $idB[] = $idIncidencia;

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

                        #RATIOS
                        $ratioCreadas = 0;
                        $ratioSolucionados = 0;

                        if ($creadas > 0 && $habitaciones > 0)
                            $ratioCreadas = $creadas / $habitaciones;

                        if ($solucionadas > 0 && $habitaciones > 0)
                            $ratioSolucionados = $solucionadas / $habitaciones;

                        $arraySecciones[$idSeccion] = array(
                            "habitaciones" => intval($habitaciones),
                            "idSeccion" => $idSeccion,
                            "seccion" => $seccion,
                            "creadas" => intval($creadas),
                            "enProceso" => intval($enProceso),
                            "solucionadas" => intval($solucionadas),
                            "mediaEnProceso" => intval($mediaEnProceso),
                            "mediaSolucionados" => intval($mediaSolucionados),
                            "ratioSolucionados" => number_format($ratioSolucionados, 4, '.', ' '),
                            "ratioCreadas" => number_format($ratioCreadas, 4, '.', ' '),
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
                    "habitaciones" => intval($habitaciones),
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


    #REPORTE DE INCIDENCIAS POR SECCIONES
    if ($action == "reporteGlobal") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];

        $array['dataDestinos'] = array();
        $array['data'] = array();

        #DATOS GLOBALES
        $creados_global = 0;
        $enProceso_global = 0;
        $solucionadas_global = 0;
        $mediaEnProceso_global = 0;
        $mediaSolucionados_global = 0;

        $query = "SELECT id, destino, habitaciones, ubicacion FROM c_destinos WHERE status = 'A' and id NOT IN(10)";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['id'];
                $destino = $x['destino'];
                $ubicacion = $x['ubicacion'];
                $habitaciones = $x['habitaciones'];

                #DATOS POR DESTINO
                $creados_destino = 0;
                $enProceso_destino = 0;
                $solucionadas_destino = 0;
                $mediaEnProceso_destino = 0;
                $mediaSolucionados_destino = 0;

                # Fecha como segundos
                $tiempoInicio = strtotime($fechaInicio);
                $tiempoFin = strtotime($fechaFin);
                $fechaX = "";

                #IDS PARA EVITAR REPETIDOS
                $idA = array();
                $idB = array();
                while ($tiempoInicio <= $tiempoFin) {

                    $fechaX = date('Y-m-d', $tiempoInicio);
                    $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                    $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                    if (count($idA) > 0) {
                        $idx = implode(',', $idA);
                    } else {
                        $idx = 0;
                    }

                    #INCIDENCIAS EQUIPOS
                    $query = "SELECT id, fecha_creacion, fecha_realizado, status
                    FROM t_mc
                    WHERE id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                    (
                        (fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                        (fecha_realizado BETWEEN '$fechaA' and '$fechaB')
                    ) and id NOT IN($idx)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idIncidencia = $x['id'];
                            $status = $x['status'];
                            $fechaCreacion = $x['fecha_creacion'];
                            $fechaFinalizado = $x['fecha_realizado'];

                            // CONTADORES TOTAL
                            $creados_destino++;
                            $creados_global++;
                            $idA[] = $idIncidencia;

                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            if ($status == "PENDIENTE" || $status == "N") {
                                $enProceso_destino++;
                                $enProceso_global++;

                                #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                if ($horasCreacion > 0 && $horasActual > 0) {
                                    $mediaEnProceso_destino += ($horasActual - $horasCreacion) / 3600;
                                    $mediaEnProceso_global += ($horasActual - $horasCreacion) / 3600;
                                }
                            } else {
                                $solucionadas_destino++;
                                $solucionadas_global++;

                                #OBTIENE TIEMPO EN HORAS DE SOLUCIONADO
                                if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                    $mediaSolucionados_destino += ($horasSolucionado - $horasCreacion) / 3600;
                                    $mediaSolucionados_global += ($horasSolucionado - $horasCreacion) / 3600;
                                }
                            }
                        }
                    }

                    if (count($idB) > 0) {
                        $idy = implode(',', $idB);
                    } else {
                        $idy = 0;
                    }

                    #INCIDENCIAS GENERALES
                    $query = "SELECT id, fecha, fecha_finalizado, status
                    FROM t_mp_np
                    WHERE id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo = 0 and
                    (
                        (fecha BETWEEN '$fechaA' and '$fechaB') OR 
                        (fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                    ) and id NOT IN($idy)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idIncidencia = $x['id'];
                            $fechaCreacion = $x['fecha'];
                            $fechaFinalizado = $x['fecha_finalizado'];
                            $status = $x['status'];

                            // CONTADORES TOTAL
                            $creados_destino++;
                            $creados_global++;
                            $idA[] = $idIncidencia;

                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            if ($status == "PENDIENTE" || $status == "N") {
                                $enProceso_destino++;
                                $enProceso_global++;

                                #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                if ($horasCreacion > 0 && $horasActual > 0) {
                                    $mediaEnProceso_destino += ($horasActual - $horasCreacion) / 3600;
                                    $mediaEnProceso_global += ($horasActual - $horasCreacion) / 3600;
                                }
                            } else {
                                $solucionadas_destino++;

                                #OBTIENE TIEMPO EN HORAS DE SOLUCIONADO
                                if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                    $mediaSolucionados_destino += ($horasSolucionado - $horasCreacion) / 3600;
                                    $mediaSolucionados_global += ($horasSolucionado - $horasCreacion) / 3600;
                                }
                            }
                        }
                    }

                    #AUMENTA UN DÍA
                    $tiempoInicio += 86400;
                }

                #RATIOS
                $ratioCreadas = 0;
                $ratioSolucionados = 0;

                if ($creados_destino > 0 && $habitaciones > 0)
                    $ratioCreadas = $creados_destino / $habitaciones;

                if ($solucionadas_destino > 0 && $habitaciones > 0)
                    $ratioSolucionados = $solucionadas_destino / $habitaciones;

                #ARRAY DE RESULTADOS POR DESTINO
                $array['dataDestinos'][] = array(
                    "idDestino" => intval($idDestinoX),
                    "destino" => $destino,
                    "creadas" => $creados_destino,
                    "enProceso" => $enProceso_destino,
                    "solucionadas" => $solucionadas_destino,
                    "mediaEnProceso" => intval($mediaEnProceso_destino),
                    "mediaSolucionados" => intval($mediaSolucionados_destino),
                    "ratioCreadas" => number_format($ratioCreadas, 4, '.', ' '),
                    "ratioSolucionados" => number_format($ratioSolucionados, 4, '.', ' '),
                );
            }
        }

        #ARRAY GLOBAL
        $array['data'] = array(
            "creadas" => $creados_global,
            "enProceso" => $enProceso_global,
            "solucionadas" => $solucionadas_global,
            "mediaEnProceso" => intval($mediaEnProceso_global),
            "mediaSolucionados" => intval($mediaSolucionados_global),
        );
        echo json_encode($array);
    }


    #REPORTE DE INCIDENCIAS POR SECCION Y SUBSECCIONES
    if ($action == "reporteIncidenciasSubsecciones") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];
        $idSeccion = $_GET['idSeccion'];

        $query = "SELECT d.id 'idDestino', d.destino, d.ubicacion, s.id 'idSeccion', s.seccion 
        FROM c_destinos AS d
        INNER JOIN c_rel_destino_seccion AS rel ON d.id = rel.id_destino
        INNER JOIN c_secciones AS s ON rel.id_seccion = s.id
        WHERE d.status = 'A' and rel.id_seccion = $idSeccion and d.id = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['idDestino'];
                $destino = $x['destino'];
                $ubicacion = $x['ubicacion'];
                $idSeccion = $x['idSeccion'];
                $seccion = $x['seccion'];

                $creadas_G = 0;
                $enProceso_G = 0;
                $solucionadas_G = 0;
                $mediaEnProceso_G = 0;
                $mediaSolucionados_G = 0;
                $grafica = array();

                $query = "SELECT c_secciones.id 'idSeccion', c_secciones.seccion, c_subsecciones.id 'idSubseccion', c_subsecciones.grupo
                FROM c_rel_destino_seccion AS rel
                INNER JOIN c_secciones ON rel.id_seccion = c_secciones.id
                INNER JOIN c_subsecciones ON c_secciones.id = c_subsecciones.id_seccion
                WHERE rel.id_destino = $idDestinoX and c_secciones.id = $idSeccion
                ORDER BY c_subsecciones.id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {

                        $idSubseccion = $x['idSubseccion'];
                        $subseccion = $x['grupo'];

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

                        #IDS PARA EVITAR REPETIDOS
                        $idA = array();
                        $idB = array();

                        while ($tiempoInicio <= $tiempoFin) {

                            $fechaX = date('Y-m-d', $tiempoInicio);
                            $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                            $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                            #CONTADORES TOTAL
                            $creadas_dia = 0;
                            $enProceso_dia = 0;
                            $solucionadas_dia = 0;

                            if (count($idA) > 0) {
                                $idx = implode(',', $idA);
                            } else {
                                $idx = 0;
                            }

                            #INCIDENCIAS EQUIPOS
                            $query = "SELECT id, fecha_creacion, fecha_realizado, status
                            FROM t_mc
                            WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                            (
                                (fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                                (fecha_realizado BETWEEN '$fechaA' and '$fechaB')
                            ) and id NOT IN($idx)";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idIncidencia = $x['id'];
                                    $fechaCreacion = $x['fecha_creacion'];
                                    $fechaFinalizado = $x['fecha_realizado'];
                                    $status = $x['status'];

                                    // CONTADORES TOTAL
                                    $creadas++;
                                    $creadas_dia++;
                                    $creadas_G++;

                                    #OBTIENE TIEMPOS EN HORAS
                                    $horasCreacion = strtotime($fechaCreacion);
                                    $horasSolucionado = strtotime($fechaFinalizado);
                                    $horasActual = strtotime($fechaActual);

                                    if ($status == "PENDIENTE" || $status == "N") {
                                        $enProceso++;
                                        $enProceso_dia++;
                                        $enProceso_G++;

                                        #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                        if ($horasCreacion > 0 && $horasActual > 0) {
                                            $mediaEnProceso += ($horasActual - $horasCreacion) / 3600;
                                        }
                                    } else {
                                        $idA[] = $idIncidencia;

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

                            if (count($idB) > 0) {
                                $idy = implode(',', $idB);
                            } else {
                                $idy = 0;
                            }

                            #INCIDENCIAS GENERALES
                            $query = "SELECT id, fecha, fecha_finalizado, status
                            FROM t_mp_np
                            WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo = 0 and
                            (
                                (fecha BETWEEN '$fechaA' and '$fechaB') OR 
                                (fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                            ) and id NOT IN($idy)";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idIncidencia = $x['id'];
                                    $fechaCreacion = $x['fecha'];
                                    $fechaFinalizado = $x['fecha_finalizado'];
                                    $status = $x['status'];

                                    # CONTADORES TOTAL
                                    $creadas++;
                                    $creadas_dia++;
                                    $creadas_G++;

                                    #OBTIENE TIEMPOS EN HORAS
                                    $horasCreacion = strtotime($fechaCreacion);
                                    $horasSolucionado = strtotime($fechaFinalizado);
                                    $horasActual = strtotime($fechaActual);

                                    if ($status == "PENDIENTE" || $status == "N") {
                                        $enProceso++;
                                        $enProceso_dia++;
                                        $enProceso_G++;

                                        #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                        if ($horasCreacion > 0 && $horasActual > 0) {
                                            $mediaEnProceso += ($horasActual - $horasCreacion) / 3600;
                                        }
                                    } else {
                                        $idB[] = $idIncidencia;

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

                        $arraySubsecciones[$idSubseccion] = array(
                            "idSeccion" => $idSeccion,
                            "seccion" => $seccion,
                            "idSubseccion" => intval($idSubseccion),
                            "subseccion" => $subseccion,
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
                    "idSeccion" => intval($idSeccion),
                    "seccion" => $seccion,
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
                    "subsecciones" => $arraySubsecciones,
                );
            }
        }
        echo json_encode($array);
    }


    #RANKIN DE TIEMPOS
    if ($action == "rankingIncidenciasSubsecciones") {
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFin = $_GET['fechaFin'];
        $idSeccion = $_GET['idSeccion'];

        $query = "SELECT id, destino, habitaciones FROM c_destinos WHERE status = 'A' and id NOT IN(10)";

        $query = "SELECT d.id 'idDestino', d.habitaciones, d.destino, d.ubicacion, s.id 'idSeccion', s.seccion 
        FROM c_destinos AS d
        INNER JOIN c_rel_destino_seccion AS rel ON d.id = rel.id_destino
        INNER JOIN c_secciones AS s ON rel.id_seccion = s.id
        WHERE d.status = 'A' and rel.id_seccion = $idSeccion and d.id NOT IN(10)";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['idDestino'];
                $destino = $x['destino'];
                $habitaciones = $x['habitaciones'];
                $idSeccion = $x['idSeccion'];
                $seccion = $x['seccion'];

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

                #IDS PARA EVITAR REPETIDOS
                $idA = array();
                $idB = array();

                while ($tiempoInicio <= $tiempoFin) {

                    $fechaX = date('Y-m-d', $tiempoInicio);
                    $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                    $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                    if (count($idA) > 0) {
                        $idx = implode(',', $idA);
                    } else {
                        $idx = 0;
                    }

                    #INCIDENCIA EQUIPOS
                    $query = "SELECT id, fecha_creacion, fecha_realizado, status
                    FROM t_mc
                    WHERE id_destino = $idDestinoX and id_seccion = $idSeccion and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                    (
                        (fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                        (fecha_realizado BETWEEN '$fechaA' and '$fechaB')
                    ) and id NOT IN($idx)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idIncidencia = $x['id'];
                            $fechaCreacion = $x['fecha_creacion'];
                            $fechaFinalizado = $x['fecha_realizado'];
                            $status = $x['status'];

                            $creados++;


                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            $idA[] = $idIncidencia;

                            if ($status == "PENDIENTE" || $status == "N") {
                                $enProceso++;
                            } else {

                                $solucionados++;

                                #OBTIENE TIEMPO EN HORAS DE SOLUCIONADO
                                if ($horasCreacion > 0 && $horasSolucionado > 0) {
                                    $mediaSolucionados += ($horasSolucionado - $horasCreacion) / 3600;
                                }
                            }
                        }
                    }

                    if (count($idB) > 0) {
                        $idy = implode(',', $idB);
                    } else {
                        $idy = 0;
                    }

                    #INCIDENCIAS GENERALES
                    $query = "SELECT id, fecha, fecha_finalizado, status
                    FROM t_mp_np
                    WHERE id_destino = $idDestinoX and id_seccion = $idSeccion and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo = 0 and
                    (
                        (fecha BETWEEN '$fechaA' and '$fechaB') OR 
                        (fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                    ) and id NOT IN($idy) and id_seccion = $idSeccion";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idIncidencia = $x['id'];
                            $fechaCreacion = $x['fecha'];
                            $fechaFinalizado = $x['fecha_finalizado'];
                            $status = $x['status'];
                            $tiempoSolucionado = 0;
                            $idDestinoX;

                            $creados++;

                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            $idB[] = $idIncidencia;

                            if ($status == "PENDIENTE" || $status == "N") {
                                $enProceso++;
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

                $array['creados'][$destino] =  intval($creados);
                $array['solucionados'][$destino] = intval($solucionados);
                $array['mediaSolucionados'][$destino] = intval($mediaSolucionados);
                $array['habitaciones'] = intval($habitaciones);
            }
        }
        arsort($array['creados']);
        arsort($array['solucionados']);
        arsort($array['mediaSolucionados']);

        foreach ($array['creados'] as $key => $value) {
            $array['creadosX'][] = ["destino" => $key, "valor" => $value];
        }

        foreach ($array['solucionados'] as $key => $value) {
            $array['solucionadosX'][] = ["destino" => $key, "valor" => $value];
        }

        foreach ($array['mediaSolucionados'] as $key => $value) {
            $array['mediaSolucionadosX'][] = ["destino" => $key, "valor" => $value];
        }

        unset($array['creados']);
        unset($array['solucionados']);
        unset($array['mediaSolucionados']);

        echo json_encode($array);
    }


    #PREVENTIVOS
    if ($action == "preventivos") {
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

                        #IDS PARA EVITAR REPETIDOS
                        $idA = array();

                        while ($tiempoInicio <= $tiempoFin) {

                            $fechaX = date('Y-m-d', $tiempoInicio);
                            $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                            $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                            #CONTADORES TOTAL
                            $creadas_dia = 0;
                            $enProceso_dia = 0;
                            $solucionadas_dia = 0;

                            if (count($idA) > 0) {
                                $idx = implode(',', $idA);
                            } else {
                                $idx = 0;
                            }

                            $query = "SELECT mp.id, mp.fecha_creacion, mp.fecha_finalizado, 
                            mp.status
                            FROM t_mp_planificacion_iniciada AS mp
                            INNER JOIN t_equipos_america AS e ON mp.id_equipo = e.id
                            WHERE e.id_destino = $idDestinoX and e.id_seccion = $idSeccion and 
                            mp.status IN('PROCESO', 'SOLUCIONADO') and mp.activo = 1 and mp.año = '$añoActual' and
                            (
                                (mp.fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                                (mp.fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                            ) and mp.id NOT IN($idx)";

                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idIncidencia = $x['id'];
                                    $fechaCreacion = $x['fecha_creacion'];
                                    $fechaFinalizado = $x['fecha_finalizado'];
                                    $status = $x['status'];

                                    // CONTADORES TOTAL
                                    $creadas++;
                                    $creadas_dia++;
                                    $creadas_G++;

                                    #OBTIENE TIEMPOS EN HORAS
                                    $horasCreacion = strtotime($fechaCreacion);
                                    $horasSolucionado = strtotime($fechaFinalizado);
                                    $horasActual = strtotime($fechaActual);

                                    if ($status == "PROCESO") {

                                        // ACUMULADO
                                        $enProceso++;
                                        $enProceso_dia++;
                                        $enProceso_G++;

                                        #OBTIENE TIEMPO EN HORAS DE PENDIENTE
                                        if ($horasCreacion > 0 && $horasActual > 0) {
                                            $mediaEnProceso += ($horasActual - $horasCreacion) / 3600;
                                        }
                                    } else {
                                        $idA[] = $idIncidencia;

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


    #RANKIN DE TIEMPOS PREVENTIVOS
    if ($action == "rankingPreventivos") {
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

                #IDS PARA EVITAR REPETIDOS
                $idA = array();

                while ($tiempoInicio <= $tiempoFin) {

                    $fechaX = date('Y-m-d', $tiempoInicio);
                    $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                    $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                    if (count($idA) > 0) {
                        $idx = implode(',', $idA);
                    } else {
                        $idx = 0;
                    }

                    $query = "SELECT mp.id, mp.fecha_creacion, mp.fecha_finalizado, 
                    mp.status
                    FROM t_mp_planificacion_iniciada AS mp
                    INNER JOIN t_equipos_america AS e ON mp.id_equipo = e.id
                    WHERE e.id_destino = $idDestinoX and mp.status IN('PROCESO', 'SOLUCIONADO') and mp.activo = 1 and mp.año = '$añoActual' and 
                    (
                        (mp.fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                        (mp.fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                    ) and mp.id NOT IN($idx)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idIncidencia = $x['id'];
                            $fechaCreacion = $x['fecha_creacion'];
                            $fechaFinalizado = $x['fecha_finalizado'];
                            $status = $x['status'];
                            $creados++;

                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            if ($status == "PROCESO") {
                                $enProceso++;
                            } else {
                                $idA[] = $idIncidencia;

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

                $array['creados'][$destino] =  intval($creados);
                $array['solucionados'][$destino] = intval($solucionados);
                $array['mediaSolucionados'][$destino] = intval($mediaSolucionados);
            }
        }
        arsort($array['creados']);
        arsort($array['solucionados']);
        arsort($array['mediaSolucionados']);

        foreach ($array['creados'] as $key => $value) {
            $array['creadosX'][] = ["destino" => $key, "valor" => $value];
        }

        foreach ($array['solucionados'] as $key => $value) {
            $array['solucionadosX'][] = ["destino" => $key, "valor" => $value];
        }

        foreach ($array['mediaSolucionados'] as $key => $value) {
            $array['mediaSolucionadosX'][] = ["destino" => $key, "valor" => $value];
        }

        unset($array['creados']);
        unset($array['solucionados']);
        unset($array['mediaSolucionados']);

        echo json_encode($array);
    }
}
