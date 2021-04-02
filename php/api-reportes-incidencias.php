<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';
header("Access-Control-Allow-Origin: *");
if (isset($_GET['action'])) {

    //Variables Globales
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $array = array();

    if ($action == "tiemposIncidencias") {
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


                #PREVENTIVOS
                $query = "SELECT mp.id, mp.fecha_creacion, mp.fecha_finalizado, mp.status 
                FROM t_mp_planificacion_iniciada AS mp
                INNER JOIN t_equipos_america AS e ON mp.id_equipo = e.id
                WHERE e.id_destino = $idDestino and e.id_seccion = $idSeccion and e.activo = 1 and mp.activo = 1 and
                ((mp.fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin') OR 
                (mp.fecha_finalizado BETWEEN '$fechaInicio' and '$fechaFin'))";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalIncidencias++;
                        $idOT = $x['id'];
                        $actividad = "PREVENTIVO";
                        $fechaCreacion = $x['fecha_creacion'];
                        $fechaRealizado = $x['fecha_finalizado'];
                        $status = $x['status'];
                        $tiempoPendiente = 0;
                        $tiempoSolucionado = 0;

                        #OBTIENE TIEMPOS EN HORAS
                        $horasCreacion = strtotime($fechaCreacion);
                        $horasSolucionado = strtotime($fechaRealizado);
                        $horasActual = strtotime($fechaActual);

                        if ($status == "PROCESO") {
                            $pendientes++;

                            if ($horasActual > 0 && $horasCreacion > 0) {
                                $tiempoPendiente = ($horasActual - $horasCreacion) / 3600;
                                $horasPentientesGlobal += $tiempoPendiente;
                            }

                            $resultado['PENDIENTE'][] = array(
                                "idOT" => $idOT,
                                "incidencia" => $actividad,
                                "fechaCreacion" => $fechaCreacion,
                                "fechaRealizado" => $fechaRealizado,
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
                                "idOT" => $idOT,
                                "incidencia" => $actividad,
                                "fechaCreacion" => $fechaCreacion,
                                "fechaRealizado" => $fechaRealizado,
                                "tiempo" => number_format($tiempoSolucionado, 2, '.', ''),
                                "status" => "SOLUCIONADO"
                            );
                        }
                    }
                }


                #PDA
                $query = "SELECT pda.id, pda.actividad, pda.fecha_creacion, pda.fecha_realizado, pda.status 
                FROM t_proyectos AS p
                INNER JOIN t_proyectos_planaccion AS pda ON pda.id_proyecto = p.id
                WHERE p.id_destino = $idDestino and p.id_seccion = $idSeccion and p.activo = 1 and pda.activo = 1 and
                ((pda.fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin') OR 
                (pda.fecha_realizado BETWEEN '$fechaInicio' and '$fechaFin'))";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalIncidencias++;
                        $idOT = $x['id'];
                        $actividad = $x['actividad'];
                        $fechaCreacion = $x['fecha_creacion'];
                        $fechaRealizado = $x['fecha_realizado'];
                        $status = $x['status'];
                        $tiempoPendiente = 0;
                        $tiempoSolucionado = 0;

                        #OBTIENE TIEMPOS EN HORAS
                        $horasCreacion = strtotime($fechaCreacion);
                        $horasSolucionado = strtotime($fechaRealizado);
                        $horasActual = strtotime($fechaActual);

                        if ($status == "PENDIENTE" || $status == "N") {
                            $pendientes++;

                            if ($horasActual > 0 && $horasCreacion > 0) {
                                $tiempoPendiente = ($horasActual - $horasCreacion) / 3600;
                                $horasPentientesGlobal += $tiempoPendiente;
                            }

                            $resultado['PENDIENTE'][] = array(
                                "idOT" => $idOT,
                                "incidencia" => $actividad,
                                "fechaCreacion" => $fechaCreacion,
                                "fechaRealizado" => $fechaRealizado,
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
                                "idOT" => $idOT,
                                "incidencia" => $actividad,
                                "fechaCreacion" => $fechaCreacion,
                                "fechaRealizado" => $fechaRealizado,
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

                $array[$destino]['ubicacion'] = $ubicacion;
                $array[$destino][$seccion] =
                    array(
                        "destino" => $destino,
                        "ubicacion" => $ubicacion,
                        "seccion" => $seccion,
                        "totalIncidencias" => intval($totalIncidencias),
                        "totalIncidenciasPendientes" => intval($pendientes),
                        "totalIncidenciasSolucionados" => intval($solucionados),
                        "mediaPendientes" => number_format($mediaPendientes, 2, '.', ''),
                        "mediaSolucionados" => number_format($mediaSolucionados, 2, '.', ''),
                        "totalComentarios" => $totalComentarios,
                        "resumen" => $resultado
                    );
            }
        }
        echo json_encode($array);
    }
}
