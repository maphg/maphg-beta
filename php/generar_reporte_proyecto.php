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
$query = "
    SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.status, t_proyectos_planaccion.coste, 
    t_proyectos_planaccion.fecha_creacion, t_colaboradores.nombre, t_colaboradores.apellido, 
    t_proyectos_planaccion.area,
    t_proyectos_planaccion.unidad_medida,
    t_proyectos_planaccion.cantidad,
    t_proyectos_planaccion.coste
    FROM t_proyectos_planaccion 
    LEFT JOIN t_users ON t_proyectos_planaccion.responsable = t_users.id
    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
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
        $areaP = $e['area'];
        $unidadP = $e['unidad_medida'];
        $cantidadP = $e['cantidad'];
        $costeP = $e['coste'];
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




$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
