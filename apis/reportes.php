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

                // $array[] = 
                //     array(
                //         "idDestino" => intval($idDestinoX),
                //         "destino" => $destino,
                //         "enProceso" => intval($enProceso),
                //         "creados" => intval($creados),
                //         "solucionados" => intval($solucionados),
                //         "mediaSolucionados" => intval($mediaSolucionados)
                //     );

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


    #REPORTE DE INCIDENCIAS
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


                        while ($tiempoInicio <= $tiempoFin) {

                            $fechaX = date('Y-m-d', $tiempoInicio);
                            $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                            $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                            #CONTADORES TOTAL
                            $creadas_dia = 0;
                            $enProceso_dia = 0;
                            $solucionadas_dia = 0;

                            $query = "SELECT mp.id, mp.fecha_creacion, mp.fecha_finalizado, 
                            mp.status
                            FROM t_mp_planificacion_iniciada AS mp
                            INNER JOIN t_equipos_america AS e ON mp.id_equipo = e.id
                            WHERE e.id_destino = $idDestinoX and e.id_seccion = $idSeccion and 
                            mp.status IN('PROCESO', 'SOLUCIONADO') and mp.activo = 1 and 
                            (
                                (mp.fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                                (mp.fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                            )";

                            #INCIDENCIAS EQUIPOS
                            // $query = "SELECT id, fecha_creacion, fecha_realizado, status
                            // FROM t_mc
                            // WHERE id_seccion = $idSeccion and id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                            // (
                            //     (fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                            //     (fecha_realizado BETWEEN '$fechaA' and '$fechaB')
                            // )";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $totalIncidencia = $x['id'];
                                    $fechaCreacion = $x['fecha_creacion'];
                                    $fechaFinalizado = $x['fecha_finalizado'];
                                    $status = $x['status'];

                                    // CONTADORES TOTAL
                                    $enProceso++;
                                    $enProceso_dia++;
                                    $enProceso_G++;

                                    #OBTIENE TIEMPOS EN HORAS
                                    $horasCreacion = strtotime($fechaCreacion);
                                    $horasSolucionado = strtotime($fechaFinalizado);
                                    $horasActual = strtotime($fechaActual);

                                    if ($status == "PROCESO") {
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


    #RANKIN DE TIEMPOS
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

                while ($tiempoInicio <= $tiempoFin) {

                    $fechaX = date('Y-m-d', $tiempoInicio);
                    $fechaA = date("Y-m-d H:i:s", ($tiempoInicio + 0));
                    $fechaB = date("Y-m-d H:i:s", ($tiempoInicio + 86400));

                    #INCIDENCIA EQUIPOS
                    // $query = "SELECT id, fecha_creacion, fecha_realizado, status
                    // FROM t_mc
                    // WHERE id_destino = $idDestinoX and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and activo = 1 and id_equipo > 0 and
                    // ((fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                    // (fecha_realizado BETWEEN '$fechaA' and '$fechaB'))";

                    $query = "SELECT mp.id, mp.fecha_creacion, mp.fecha_finalizado, 
                    mp.status
                    FROM t_mp_planificacion_iniciada AS mp
                    INNER JOIN t_equipos_america AS e ON mp.id_equipo = e.id
                    WHERE e.id_destino = $idDestinoX and mp.status IN('PROCESO', 'SOLUCIONADO') and mp.activo = 1 and 
                    (
                        (mp.fecha_creacion BETWEEN '$fechaA' and '$fechaB') OR 
                        (mp.fecha_finalizado BETWEEN '$fechaA' and '$fechaB')
                    )";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $fechaCreacion = $x['fecha_creacion'];
                            $fechaFinalizado = $x['fecha_finalizado'];
                            $status = $x['status'];

                            $enProceso++;

                            #OBTIENE TIEMPOS EN HORAS
                            $horasCreacion = strtotime($fechaCreacion);
                            $horasSolucionado = strtotime($fechaFinalizado);
                            $horasActual = strtotime($fechaActual);

                            if ($status == "PROCESO") {
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
