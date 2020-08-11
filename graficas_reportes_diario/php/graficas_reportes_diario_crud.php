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

if ($action == 1) {
    // $array = array("Subseccion" => "POZOS", "Solucionado" => 23, "Pendientes" => 22);
    $fechaInicio = date('Y-m-d 23:59:59');
    $filtroRangoFecha = "AND fecha_creacion BETWEEN '2020-01-01 00:00:00' AND '$fechaInicio'";

    $dataArray = array();
    $query = "
        SELECT c_rel_seccion_subseccion.fase, c_rel_destino_seccion.id_destino, c_destinos.id, c_destinos.destino,  c_rel_destino_seccion.id_seccion, c_secciones.id, c_secciones.titulo_seccion, c_rel_seccion_subseccion.id_subseccion, c_subsecciones.id, c_subsecciones.grupo
        FROM c_rel_destino_seccion
        INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
        INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
        INNER JOIN c_destinos ON c_rel_destino_seccion.id_destino = c_destinos.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino AND c_secciones.id = $idSeccion AND c_subsecciones.id != 200 
    ";
    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $value) {
            $idSubseccion = $value['id_subseccion'];
            $subseccion = $value['grupo'];
            // echo $subseccion . "<br>";

            $queryTotalPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino $filtroRangoFecha";

            $queryTotalSolucionados = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'F' AND activo = 1 $filtroDestino $filtroRangoFecha";

            if (
                $resultTotalPendientes = mysqli_query($conn_2020, $queryTotalPendientes) and
                $resultTotalSolucionados = mysqli_query($conn_2020, $queryTotalSolucionados)
            ) {

                foreach ($resultTotalSolucionados as $total) {
                    $totalSolucionados = $total['count(id)'];
                }

                foreach ($resultTotalPendientes as $total) {
                    $totalPendientes = $total['count(id)'];
                }

                // Da formato para los arrays.
                $arrayAux = array("Subseccion" => $subseccion, "Solucionado" => $totalSolucionados, "Pendientes" => $totalPendientes);
                // Se almacenan los Arrays.
                $dataArray[] = $arrayAux;
            }
        }
    }
    echo json_encode($dataArray);
}

if ($action == 2) {
    // {"Responsable":"Responsable 1","Solucionado":23,"Pendientes":22}
    $fechaInicio = date('Y-m-d 23:59:59');
    $filtroRangoFecha = "AND fecha_creacion BETWEEN '2020-01-01 00:00:00' AND '$fechaInicio'";
    $dataArray = array();
    $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido 
    FROM t_users 
    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
    WHERE t_users.id_destino = $idDestino and t_users.status = 'A'";
    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $value) {
            $idUsuario = $value['id'];
            $nombre = $value['nombre'];
            $apellido = $value['apellido'];
            $nombreCompleto = strtok($nombre, ' ') . " " . strtok($apellido, ' ');

            $queryPendientes = "SELECT count(id) FROM t_mc 
            WHERE responsable = $idUsuario AND id_seccion = $idSeccion AND id_destino = $idDestino AND status = 'N' $filtroRangoFecha";

            $querySolucionados = "SELECT count(id) FROM t_mc 
            WHERE responsable = $idUsuario AND id_seccion = $idSeccion AND id_destino = $idDestino AND status = 'F' $filtroRangoFecha";

            if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes) and $resultSolucionados = mysqli_query($conn_2020, $querySolucionados)) {

                foreach ($resultSolucionados as $value) {
                    $totalSolucionados = $value['count(id)'];
                }

                foreach ($resultPendientes as $value) {
                    $totalPendientes = $value['count(id)'];
                }
                if ($totalSolucionados > 0 or $totalPendientes > 0) {

                    $arrayAux = array("Responsable" => $nombreCompleto, "Solucionado" => $totalSolucionados, "Pendientes" => $totalPendientes);

                    $dataArray[] = $arrayAux;
                }
            }
        }
        echo json_encode($dataArray);
    }
}


if ($action == 3) {
    // date("d-m-Y", strtotime($fechaActual . "- 10 days"));
    //   { "date": new Date(2020, 8, 8), "Creado": 15, "Solucionado": 18}
    $dataArray = array();
    $fecha = date("Y-m-d");
    $contador = -1;

    for ($i = 0; $i <= 10; $i++) {
        $contador++;
        $diaActual_inicio = date("Y-m-d 00:00:00", strtotime($fechaActual . "- $i days"));
        $diaActual_fin = date("Y-m-d 23:59:59", strtotime($fechaActual . "- $i days"));
        $diaActual = date("Y-m-d", strtotime($fechaActual . "- $i days"));
        // echo " -> $diaActual_inicio - $diaActual_fin - $diaActual <br>";

        $queryPendientes = "SELECT count(id) 
        FROM t_mc WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 
        AND fecha_creacion BETWEEN '$diaActual_inicio' AND '$diaActual_fin'";

        $querySolucionados = "SELECT count(id) 
        FROM t_mc WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND status = 'F' 
        AND fecha_creacion BETWEEN '$diaActual_inicio' AND '$diaActual_fin'";

        if (
            $resultPendientes = mysqli_query($conn_2020, $queryPendientes) and
            $resultSolucionados = mysqli_query($conn_2020, $querySolucionados)
        ) {

            foreach ($resultPendientes as $value) {
                $totalPendientes = $value['count(id)'];
                // echo $totalPendientes;
            }
            foreach ($resultSolucionados as $value) {
                $totalSolucionados = $value['count(id)'];
                // echo $totalSolucionados;
            }

            $arrayAux = array("date" => "new Date($diaActual)", "Creado" => $totalPendientes, "Solucionado" => $totalSolucionados);

            $dataArray[] = $arrayAux;
        }
    }
    echo json_encode(array_reverse($dataArray));
}


if ($action == 4) {
    //   { "date": new Date(2020, 0, 1), "Creado": 26, "Solucionado": 10, "Acumulado": 7 },

    $dataArray = array();
    $fechaInicio = date('2020-01-01 00:00:00');
    $fechaInicio = $fechaInicio;
    $fechaFin = date('Y-m-d 00:00:00');

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

        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaActual'";

        $querySolucionados = "SELECT count(id) FROM t_mc WHERE status ='F' AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 AND fecha_creacion BETWEEN '$fechaFin' AND '$fechaActual'";

        if (
            $resultPendientes = mysqli_query($conn_2020, $queryPendientes)
            and $resultSolucionados = mysqli_query($conn_2020, $querySolucionados)
        ) {

            foreach ($resultPendientes as $value) {
                $totalPendientes = $value['count(id)'];
            }

            foreach ($resultSolucionados as $value) {
                $totalSolucionados = $value['count(id)'];
            }

            // Acumulado
            $acumuladoCreado = $acumuladoCreado + $totalPendientes;
            $acumuladoSolucionado = $totalSolucionados + $acumuladoSolucionado;
            $acumulado = $acumuladoCreado - $acumuladoSolucionado;
            // $acumulado = $aux + $acumulado;

            // {"date": new Date(2020, 0, 1), "Creado": 26, "Solucionado": 10, "Acumulado": 7}
            $arrayAux = array("date" => "new Date($fecha)", "Creado" => $totalPendientes, "Solucionado" => $totalSolucionados, "Acumulado" => $acumulado);

            $dataArray[] = $arrayAux;
        }
    }
    echo json_encode($dataArray);
}

if ($action == 5) {
    $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $value) {
            $seccion = $value['seccion'];
        }
        echo $seccion;
    }
}


if ($action == 6) {
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
    $queryCreados = "SELECT count(id) FROM t_mc WHERE id_destino = $idDestino 
    AND id_seccion = $idSeccion AND activo = 1
    AND fecha_creacion BETWEEN '$diaActual_fin' AND '$diaActual_inicio'";

    $querySolucionados = "SELECT count(id) FROM t_mc WHERE id_destino = $idDestino 
    AND id_seccion = $idSeccion AND activo = 1 AND status = 'F' 
    AND fecha_creacion BETWEEN '$diaActual_fin' AND '$diaActual_inicio'";

    if (
        $resultCreados = mysqli_query($conn_2020, $queryCreados) and
        $resultSolucionados = mysqli_query($conn_2020, $querySolucionados)
    ) {

        foreach ($resultCreados as $value) {
            $semanaCreados = $value['count(id)'];
            // echo $totalPendientes;
        }
        foreach ($resultSolucionados as $value) {
            $semanaSolucionados = $value['count(id)'];
            // echo $totalSolucionados;
        }
    }


    // Cuadros Inicio 2020-01-01
    $fechaInicio = date('2020-01-01 00:00:00');
    $fechaFin = date('Y-m-d 23:59:59');

    $querySinAsignar = "SELECT count(id) FROM t_mc WHERE status ='N' AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 
    AND fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin' AND (responsable = 0 OR responsable = '')";

    if ($resultSA = mysqli_query($conn_2020, $querySinAsignar)) {
        foreach ($resultSA as $value) {
            $totalSinResponsable = $value['count(id)'];
        }
    }

    $queryAcumulado = "SELECT count(id) FROM t_mc WHERE status ='N' AND id_destino = $idDestino AND id_seccion = $idSeccion AND activo = 1 
    AND fecha_creacion BETWEEN '$fechaInicio' AND '$fechaFin'";

    if ($resultAcumulado = mysqli_query($conn_2020, $queryAcumulado)) {
        foreach ($resultAcumulado as $value) {
            $totalAcumulado = $value['count(id)'];
        }
    }


    $dataArray['semanaCreados'] = $semanaCreados;
    $dataArray['semanaSolucionados'] = $semanaSolucionados;
    $dataArray['totalSinResponsable'] = $totalSinResponsable;
    $dataArray['totalAcumulado'] = $totalAcumulado;
    echo json_encode($dataArray);
}
