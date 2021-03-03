<?php
include '../../php/conexion.php';
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Variables Ajax.
$idDestino = $_GET['idDestino'];
$idSeccion = $_GET['idSeccion'];
$action = $_GET['action'];
$fechaActual = date('2020-07-01');
$fechaActual = date('Y-m-d');

if ($idDestino == 10) {
    $filtroDestino = "";
} else {
    $filtroDestino = "AND id_destino = $idDestino";
}

if ($action == "graficaSubsecciones") {
    // Fallas y Tareas
    // $array = array("Subseccion" => "POZOS", "Solucionado" => 23, "Pendientes" => 22);
    $fechaInicio = date('2020-01-01 00:00:00');
    $fechaFin = date('Y-m-d 23:59:59');

    $dataArray = array();
    $queryF = "
    SELECT c_rel_seccion_subseccion.fase, c_rel_destino_seccion.id_destino, c_destinos.id, c_destinos.destino,  c_rel_destino_seccion.id_seccion, c_secciones.id, c_secciones.titulo_seccion, c_rel_seccion_subseccion.id_subseccion, c_subsecciones.id, c_subsecciones.grupo
    FROM c_rel_destino_seccion
    INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
    INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
    INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
    INNER JOIN c_destinos ON c_rel_destino_seccion.id_destino = c_destinos.id
    WHERE c_rel_destino_seccion.id_destino = $idDestino AND c_secciones.id = $idSeccion AND c_subsecciones.id != 200";
    if ($resultF = mysqli_query($conn_2020, $queryF)) {
        foreach ($resultF as $F) {
            $idSubseccion = $F['id_subseccion'];
            $subseccion = $F['grupo'];

            $queryTotalPendientesF = "SELECT count(id) 'total' FROM t_mc 
            WHERE id_subseccion = $idSubseccion AND status IN('N', 'PENDIENTE', 'P') AND activo = 1 AND id_destino = $idDestino AND fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin' AND id_seccion = $idSeccion";

            $queryTotalSolucionadosF = "SELECT count(id) 'total' FROM t_mc 
            WHERE id_subseccion = $idSubseccion AND status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND activo = 1 AND id_destino = $idDestino AND fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin' AND id_seccion = $idSeccion";

            $queryTotalPendientesTareas = "SELECT count(id) 'total' FROM t_mp_np 
            WHERE id_equipo = 0 AND id_subseccion = $idSubseccion AND status IN('N', 'PENDIENTE', 'P') AND activo = 1 AND id_destino = $idDestino AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND id_seccion = $idSeccion";

            $queryTotalSolucionadosTareas = "SELECT count(id) 'total' FROM t_mp_np 
            WHERE id_equipo = 0 AND id_subseccion = $idSubseccion AND status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND activo = 1 AND id_destino = $idDestino AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND id_seccion = $idSeccion";

            if (
                $resultTotalPendientesF = mysqli_query($conn_2020, $queryTotalPendientesF) and
                $resultTotalSolucionadosF = mysqli_query($conn_2020, $queryTotalSolucionadosF) and
                $resultTotalPendientesTareas = mysqli_query($conn_2020, $queryTotalPendientesTareas) and
                $resultTotalSolucionadosTareas = mysqli_query($conn_2020, $queryTotalSolucionadosTareas)
            ) {

                foreach ($resultTotalPendientesF as $total) {
                    $totalPendientesF = intval($total['total']);
                }

                foreach ($resultTotalSolucionadosF as $total) {
                    $totalSolucionadosF = intval($total['total']);
                }

                foreach ($resultTotalPendientesTareas as $total) {
                    $totalPendientesTareas = intval($total['total']);
                }

                foreach ($resultTotalSolucionadosTareas as $total) {
                    $totalSolucionadosTareas = intval($total['total']);
                }

                // Da formato para los arrays.
                $dataArray[] = array(
                    "Subseccion" => $subseccion,
                    "Solucionado" => intval($totalSolucionadosF) + intval($totalSolucionadosTareas),
                    "Pendientes" => intval($totalPendientesF) + intval($totalPendientesTareas)
                );
            }
        }
    }
    echo json_encode($dataArray);
}

if ($action == "graficaResponsables") {
    // {"Responsable":"Responsable 1","Solucionado":23,"Pendientes":22}
    $fechaInicio = date('Y-m-d 23:59:59');
    $filtroRangoFechaFallas = "AND t_mc.fecha_creacion BETWEEN '2020-01-01 00:00:00' AND '$fechaInicio'";
    $filtroRangoFechaTareas = "AND fecha BETWEEN '2020-01-01 00:00:00' AND '$fechaInicio'";
    $dataArray = array();

    $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido 
    FROM t_users 
    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
    WHERE t_users.id_destino = $idDestino OR t_users.id_destino = 10
    ";
    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $value) {
            $idUsuarioX = $value['id'];
            $nombre = $value['nombre'];
            $apellido = $value['apellido'];
            $nombreCompleto = strtok($nombre, ' ') . " " . strtok($apellido, ' ');

            $queryPendientes = "SELECT count(t_mc.id) 'total' FROM t_mc 
            INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
            WHERE t_mc.id_equipo > 0 AND t_mc.responsable = $idUsuarioX AND t_mc.id_seccion = $idSeccion AND t_mc.id_destino = $idDestino AND t_mc.status IN('N', 'PENDIENTE', 'P') AND t_mc.activo = 1 $filtroRangoFechaFallas";

            $querySolucionados = "SELECT count(t_mc.id) 'total' FROM t_mc
            INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id 
            WHERE t_mc.id_equipo > 0 AND t_mc.responsable = $idUsuarioX AND t_mc.id_seccion = $idSeccion AND t_mc.id_destino = $idDestino AND t_mc.status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND t_mc.activo = 1 $filtroRangoFechaFallas";

            $queryPendientesTareas = "SELECT count(id) 'total' FROM t_mp_np 
            WHERE id_equipo = 0 AND responsable = $idUsuarioX AND id_seccion = $idSeccion AND id_destino = $idDestino AND status IN('N', 'PENDIENTE', 'P') AND activo = 1 $filtroRangoFechaTareas";

            $querySolucionadosTareas = "SELECT count(id) 'total' FROM t_mp_np
            WHERE id_equipo = 0 AND responsable = $idUsuarioX AND id_seccion = $idSeccion AND id_destino = $idDestino AND status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND activo = 1 $filtroRangoFechaTareas";

            if (
                $resultPendientes = mysqli_query($conn_2020, $queryPendientes) and
                $resultSolucionados = mysqli_query($conn_2020, $querySolucionados) and
                $resultPendientesTareas = mysqli_query($conn_2020, $queryPendientesTareas) and $resultSolucionadosTareas = mysqli_query($conn_2020, $querySolucionadosTareas)
            ) {

                foreach ($resultSolucionados as $value) {
                    $totalSolucionados = intval($value['total']);
                }

                foreach ($resultPendientes as $value) {
                    $totalPendientes = intval($value['total']);
                }

                foreach ($resultPendientesTareas as $value) {
                    $totalPendientesTareas = intval($value['total']);
                }
                
                foreach ($resultSolucionadosTareas as $value) {
                    $totalSolucionadosTareas = intval($value['total']);
                }

                if (
                    $totalSolucionados > 0 or $totalPendientes > 0 or
                    $totalSolucionadosTareas > 0 or $totalPendientesTareas > 0
                ) {

                    $dataArray[] = array(
                        "Responsable" => $nombreCompleto,
                        "Solucionado" => intval($totalSolucionados) + intval($totalSolucionadosTareas),
                        "Pendientes" => intval($totalPendientes) + intval($totalPendientesTareas)
                    );
                }
            }
        }
        echo json_encode($dataArray);
    }
}


if ($action == "graficaUltimaSemana") {
    // date("d-m-Y", strtotime($fechaActual . "- 10 days"));
    //   { "date": new Date(2020, 8, 8), "Creado": 15, "Solucionado": 18}
    $dataArray = array();
    $fecha = date("Y-m-d");
    $contador = -1;

    for ($i = 0; $i <= 6; $i++) {
        $contador++;
        $diaActual_inicio = date("Y-m-d 00:00:00", strtotime($fechaActual . "- $i days"));
        $diaActual_fin = date("Y-m-d 23:59:59", strtotime($fechaActual . "- $i days"));
        $diaActual = date("Y-m-d", strtotime($fechaActual . "- $i days"));
        // echo " -> $diaActual_inicio - $diaActual_fin - $diaActual <br>";

        $queryPendientes = "SELECT count(id) 'total' 
        FROM t_mc 
        WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND status IN('N', 'PENDIENTE', 'P') AND fecha_creacion BETWEEN '$diaActual_inicio' AND '$diaActual_fin'";

        $querySolucionados = "SELECT count(id) 'total' 
        FROM t_mc 
        WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND fecha_creacion BETWEEN '$diaActual_inicio' AND '$diaActual_fin'";

        $queryPendientesTareas = "SELECT count(id) 'total' 
        FROM t_mp_np
        WHERE id_equipo = 0 AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND status IN('N', 'PENDIENTE', 'P') 
        AND fecha BETWEEN '$diaActual_inicio' AND '$diaActual_fin'";

        $querySolucionadosTareas = "SELECT count(id) 'total' 
        FROM t_mp_np
        WHERE id_equipo = 0 AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND fecha BETWEEN '$diaActual_inicio' AND '$diaActual_fin'";

        if (
            $resultPendientes = mysqli_query($conn_2020, $queryPendientes) and
            $resultSolucionados = mysqli_query($conn_2020, $querySolucionados) and
            $resultPendientesTareas = mysqli_query($conn_2020, $queryPendientesTareas) and
            $resultSolucionadosTareas = mysqli_query($conn_2020, $querySolucionadosTareas)
        ) {

            foreach ($resultPendientes as $value) {
                $totalPendientes = intval($value['total']);
            }
            foreach ($resultSolucionados as $value) {
                $totalSolucionados = intval($value['total']);
            }

            foreach ($resultPendientesTareas as $value) {
                $totalPendientesTareas = intval($value['total']);
            }
            foreach ($resultSolucionadosTareas as $value) {
                $totalSolucionadosTareas = intval($value['total']);
            }

            $dataArray[] = array(
                "date" => "new Date($diaActual)",
                "Creado" => $totalPendientes + $totalPendientesTareas,
                "Solucionado" => $totalSolucionados + $totalSolucionadosTareas
            );
        }
    }
    echo json_encode(array_reverse($dataArray));
}


if ($action == "graficaHistorico") {
    //   { "date": new Date(2020, 0, 1), "Creado": 26, "Solucionado": 10, "Acumulado": 7 },

    $dataArray = array();
    $fechaInicio = date('2020-01-01 00:00:00');
    $fechaFin = date('Y-m-d 23:59:59');

    $tiempoInicio = strtotime($fechaInicio);
    $tiempoFin = strtotime($fechaFin);

    $acumuladoCreado = 0;
    $acumuladoSolucionado = 0;
    $aux = 0;
    $acumulado = 0;

    # 24 horas * 60 minutos por hora * 60 segundos por minuto
    $dia = 24 * (60 * 60);

    while ($tiempoInicio <= $tiempoFin) {

        $fechaActual = date("Y-m-d 23:59:59", $tiempoInicio);
        $fechaFin = date("Y-m-d 00:00:00", strtotime($fechaActual . "- 0 days"));
        $fecha = date("Y, m, d", $tiempoInicio);
        // echo "Fecha dentro del ciclo: " . $fechaActual . " - $fechaFin <br>";
        $tiempoInicio += $dia;

        $queryPendientes = "SELECT count(id) 'total' 
        FROM t_mc 
        WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaActual'";

        $querySolucionados = "SELECT count(id) 'total' 
        FROM t_mc 
        WHERE status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaActual'";

        $queryPendientesTareas = "SELECT count(id) 'total' 
        FROM t_mp_np 
        WHERE id_equipo = 0 AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND fecha BETWEEN '$fechaFin' AND '$fechaActual'";

        $querySolucionadosTareas = "SELECT count(id) 'total' 
        FROM t_mp_np 
        WHERE id_equipo = 0 AND status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND fecha BETWEEN '$fechaFin' AND '$fechaActual'";

        if (
            $resultPendientes = mysqli_query($conn_2020, $queryPendientes) and
            $resultSolucionados = mysqli_query($conn_2020, $querySolucionados) and
            $resultPendientesTareas = mysqli_query($conn_2020, $queryPendientesTareas) and
            $resultSolucionadosTareas = mysqli_query($conn_2020, $querySolucionadosTareas)
        ) {

            foreach ($resultPendientes as $value) {
                $totalPendientes = intval($value['total']);
            }

            foreach ($resultSolucionados as $value) {
                $totalSolucionados = intval($value['total']);
            }

            foreach ($resultPendientesTareas as $value) {
                $totalPendientesTareas = intval($value['total']);
            }

            foreach ($resultSolucionadosTareas as $value) {
                $totalSolucionadosTareas = intval($value['total']);
            }

            // Acumulado
            $acumuladoCreado = $acumuladoCreado + ($totalPendientes + $totalPendientesTareas);
            $acumuladoSolucionado = ($totalSolucionados + $totalSolucionadosTareas) + $acumuladoSolucionado;
            $acumulado = $acumuladoCreado - $acumuladoSolucionado;

            // {"date": new Date(2020, 0, 1), "Creado": 26, "Solucionado": 10, "Acumulado": 7}
            $dataArray[] = array(
                "date" => "new Date($fecha)",
                "Creado" => $totalPendientes + $totalPendientesTareas,
                "Solucionado" => $totalSolucionados + $totalSolucionadosTareas,
                "Acumulado" => $acumulado
            );
        }
    }
    echo json_encode($dataArray);
}

if ($action == "cargarSeccionEstilosGraficas") {
    $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $value) {
            $seccion = $value['seccion'];
        }
        echo $seccion;
    }
}


if ($action == "CuadrosUltimaSemana") {
    $dataArray = array();

    // Valor Inicial:
    $semanaCreados = 0;
    $semanaSolucionados = 0;
    $totalSinResponsable = 0;
    $totalAcumulado = 0;

    //Cuadro de Semana 
    $diaActual_inicio = date("Y-m-d 23:59:59", strtotime($fechaActual . "- 0 days"));
    $diaActual_fin = date("Y-m-d 00:00:00", strtotime($fechaActual . "- 7 days"));
    $diaActual = date("Y-m-d", strtotime($fechaActual . "- 7 days"));

    // Cuadros Semanal
    $queryCreados = "SELECT count(id) 'total'
    FROM t_mc
    WHERE id_destino = $idDestino 
    AND id_seccion = $idSeccion AND activo = 1 AND status IN('PENDIENTE', 'N', 'P')
    AND fecha_creacion BETWEEN '$diaActual_fin' AND '$diaActual_inicio'";

    $querySolucionados = "SELECT count(id) 'total'
    FROM t_mc 
    WHERE id_destino = $idDestino 
    AND id_seccion = $idSeccion AND activo = 1 AND status IN('SOLUCIONADO', 'F', 'FINALIZADO') 
    AND fecha_creacion BETWEEN '$diaActual_fin' AND '$diaActual_inicio'";

    $queryCreadosTareas = "SELECT count(id) 'total'
    FROM t_mp_np
    WHERE id_equipo = 0 AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND status IN('PENDIENTE', 'N', 'P')
    AND fecha BETWEEN '$diaActual_fin' AND '$diaActual_inicio'";

    $querySolucionadosTareas = "SELECT count(id) 'total'
    FROM t_mp_np
    WHERE id_equipo = 0 AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND status IN('SOLUCIONADO', 'F', 'FINALIZADO') AND fecha BETWEEN '$diaActual_fin' AND '$diaActual_inicio'";

    if (
        $resultCreados = mysqli_query($conn_2020, $queryCreados) and
        $resultSolucionados = mysqli_query($conn_2020, $querySolucionados) and
        $resultCreadosTareas = mysqli_query($conn_2020, $queryCreadosTareas) and
        $resultSolucionadosTareas = mysqli_query($conn_2020, $querySolucionadosTareas)
    ) {

        foreach ($resultCreados as $value) {
            $semanaCreados = intval($value['total']);
        }

        foreach ($resultSolucionados as $value) {
            $semanaSolucionados = intval($value['total']);
        }

        foreach ($resultCreadosTareas as $value) {
            $semanaCreadosTareas = intval($value['total']);
        }

        foreach ($resultSolucionadosTareas as $value) {
            $semanaSolucionadosTareas = intval($value['total']);
        }
    }


    // Cuadros Inicio 2020-01-01
    $fechaInicio = date('2020-01-01 00:00:00');
    $fechaFin = date('Y-m-d 23:59:59');

    $querySinAsignar = "SELECT count(id) 'total'
    FROM t_mc WHERE status IN('PENDIENTE', 'N', 'P') AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1  AND fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin' AND (responsable = 0 OR responsable = '')";

    $queryAcumulado = "SELECT count(id) 'total'
    FROM t_mc WHERE status IN('PENDIENTE', 'N', 'P') AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin'";

    $querySinAsignarTareas = "SELECT count(id) 'total'
    FROM t_mp_np 
    WHERE id_equipo = 0 AND status IN('PENDIENTE', 'N', 'P') AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin' AND (responsable = 0 OR responsable = '')";

    $queryAcumuladoTareas = "SELECT count(id) 'total'
    FROM t_mp_np 
    WHERE id_equipo = 0 AND status IN('PENDIENTE', 'N', 'P') AND id_destino = $idDestino AND id_seccion = $idSeccion 
    AND activo = 1 AND fecha BETWEEN '$fechaInicio' AND '$fechaFin'";

    if ($resultSA = mysqli_query($conn_2020, $querySinAsignar)) {
        foreach ($resultSA as $value) {
            $totalSinResponsable = intval($value['total']);
        }
    }

    if ($resultAcumulado = mysqli_query($conn_2020, $queryAcumulado)) {
        foreach ($resultAcumulado as $value) {
            $totalAcumulado = intval($value['total']);
        }
    }

    if ($resultSATarea = mysqli_query($conn_2020, $querySinAsignarTareas)) {
        foreach ($resultSATarea as $value) {
            $totalSinResponsableTareas = intval($value['total']);
        }
    }

    if ($resultAcumuladoTarea = mysqli_query($conn_2020, $queryAcumuladoTareas)) {
        foreach ($resultAcumuladoTarea as $value) {
            $totalAcumuladoTareas = intval($value['total']);
        }
    }

    $dataArray['semanaCreados'] = $semanaCreados + $semanaCreadosTareas;
    $dataArray['semanaSolucionados'] = $semanaSolucionados + $semanaSolucionadosTareas;
    $dataArray['totalSinResponsable'] = $totalSinResponsable + $totalSinResponsableTareas;
    $dataArray['totalAcumulado'] = $totalAcumulado + $totalAcumuladoTareas;
    echo json_encode($dataArray);
}
