<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';
$idProyecto = $_GET['idProyecto'];

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte Proyecto");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'ÁREA');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'INCIDENCIA');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'FOTO ANTES');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'FOTO DESPUÉS');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'UND');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'CANTIDAD2');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'COSTE UNITARIO USD');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'COSTE TOTAL USD');

$fila = 2;
$objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, 'PROYECTO');

$query = "
    SELECT t_proyectos.id, t_proyectos.titulo, t_proyectos.justificacion, t_proyectos.fecha_creacion, t_proyectos.rango_fecha, t_proyectos.status, 
    t_proyectos.tipo, t_proyectos.coste, t_colaboradores.nombre, t_colaboradores.apellido, c_destinos.destino, c_secciones.seccion, 
    c_subsecciones.grupo
    FROM t_proyectos
    LEFT JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
    LEFT JOIN c_secciones ON t_proyectos.id_seccion = c_secciones.id
    LEFT JOIN c_subsecciones ON t_proyectos.id_subseccion = c_subsecciones.id
    LEFT JOIN t_users ON t_proyectos.responsable = t_users.id
    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
    WHERE t_proyectos.id = $idProyecto
";

if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $i) {
        $fila = 3;
        $id = $i['id'];
        $titulo = $i['titulo'];
        $destino = $i['destino'];
        $seccion = $i['seccion'];
        $subseccion = $i['grupo'];
        $responsable = $i['nombre'] . " " . $i['apellido'];
        $coste = $i['coste'];
        $justifiacion = $i['justificacion'];
        $status = $i['status'];
        $tipo = $i['tipo'];
        $rangoFecha = $i['rango_fecha'];
        $fechaCreacion = $i['fecha_creacion'];


        if ($rangoFecha != "") {
            $fecha = $rangoFecha;
        } else {
            $fecha = $fechaCreacion;
        }

        if ($responsable == "") {
            $responsable = "Sin Responsable";
        }

        if ($status == "N") {
            $status = "PENDIENTE";
        } else {
            $status = "SOLUCIONADO";
        }

        // $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $id);
        // $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $area);
        // $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $titulo);
        // $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $subseccion);
        // $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $titulo);
        // $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $responsable);
        // $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $coste);
        // $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $justifiacion);
        // $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $fecha);
        // $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $tipo);
        // $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $status);

        // //Contador de Celdas
        // $fila = 4;
        // $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, 'PLANES ACCIÓN');

        $query = "
            SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.status, t_proyectos_planaccion.coste, 
            t_proyectos_planaccion.fecha_creacion, t_colaboradores.nombre, t_colaboradores.apellido, 
            t_proyectos_planaccion.area,
            t_proyectos_planaccion.unidad_medida,
            t_proyectos_planaccion.cantidad,
            t_proyectos_planaccion.coste
            FROM t_proyectos_planaccion 
            INNER JOIN t_users ON t_proyectos_planaccion.responsable = t_users.id
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_proyectos_planaccion.id_proyecto = $idProyecto and t_proyectos_planaccion.activo = 1
        ";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $e) {
                $fila++;
                $idP = $e['id'];
                $actividadP = $e['actividad'];
                $statusP = $e['status'];
                $fechaCreacionP = $e['fecha_creacion'];
                $responsableP = $e['nombre'] . " " . $e['apellido'];
                $areaP = $i['area'];
                $unidadP = $i['unidad_medida'];
                $cantidadP = $i['cantidad_medida'];
                $costeP = $i['coste'];
                $totalP = $cantidad * $coste;
                if ($responsableP == "") {
                    $responsableP = "Sin Responsable";
                }

                if ($statusP == "N") {
                    $statusP = "PENDIENTE";
                } else {
                    $statusP = "SOLUCIONADO";
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $idP);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $area);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $actividadP);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $unidadP);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $cantidadP);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $costeP);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $totalP);
            }
        }
    }
}


$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
