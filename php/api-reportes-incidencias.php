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

        $query = "SELECT c_destinos.id 'idDestino', c_destinos.destino, c_secciones.id 'idSeccion', c_secciones.seccion
        FROM c_destinos
        INNER JOIN c_rel_destino_seccion ON c_destinos.id = c_rel_destino_seccion.id_destino
        INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_destinos.status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestino = $x['idDestino'];
                $destino = $x['destino'];
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
                $resultado = array();

                $query = "SELECT id, actividad, fecha_creacion, fecha_realizado, status FROM t_mc WHERE id_destino = $idDestino and id_seccion = $idSeccion and activo = 1 and status IN('PENDIENTE', 'N', 'SOLUCIONADO', 'F') and ((fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin') OR 
                (fecha_realizado BETWEEN '$fechaInicio' and '$fechaFin'))";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalIncidencias++;
                        $idActividad = $x['id'];
                        $actividad = $x['actividad'];
                        $fechaCreacion = $x['fecha_creacion'];
                        $fechaRealizado = $x['fecha_realizado'];
                        $status = $x['status'];

                        $horaCreacion = (new DateTime($fechaCreacion))->format('H:m:s');
                        $horaFin = (new DateTime($fechaFin))->format('H:m:s');

                        $query = "SELECT count(id) 'total' FROM t_mc_comentarios 
                        WHERE id_mc = $idActividad and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $totalComentarios += intval($x['total']);
                            }
                        }

                        if ($status == "PENDIENTE" || $status == "N") {
                            $pendientes++;
                            $mediaPendientes = $horaCreacion . $horaFin;
                            $status = "PENDIENTE";
                            $resultado['PENDIENTE'][] = array(
                                "OT Incidencia" => intval($idActividad),
                                "Incidencia" => $actividad,
                                "Fecha Creacion" => $fechaCreacion,
                                "Fecha Finalizado" => $fechaRealizado,
                                "Status" => $status
                            );
                        } else {
                            $solucionados++;
                            $horaRealizado = (new DateTime($fechaRealizado))->format('H:m:s');
                            $mediaSolucionados = $horaCreacion . $horaRealizado;
                            $status = "SOLUCIONADO";
                            $resultado['SOLUCIONADO'][] = array(
                                "OT Incidencia" => intval($idActividad),
                                "Incidencia" => $actividad,
                                "Fecha Creacion" => $fechaCreacion,
                                "Fecha Finalizado" => $fechaRealizado,
                                "Status" => $status
                            );
                        }
                    }
                }

                $array[$destino][$seccion][] = array(
                    "TOTAL INCIDENCIAS" => intval($totalIncidencias),
                    "TOTAL INCIDENCIAS PENDIENTES" => intval($pendientes),
                    "TOTAL INCIDENCIAS SOLUCIONADOS" => intval($solucionados),
                    "MEDIA TIEMPO PENDIENTES" => $mediaPendientes,
                    "MEDIA TIEMPO SOLUCIONADOS" => 0,
                    "TOTAL COMENTARIOS" => $totalComentarios,
                    "RESUMEN: " => $resultado
                );
            }
        }
        echo json_encode($array);
    }
}
