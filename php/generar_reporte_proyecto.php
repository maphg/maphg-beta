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
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'FOTO 1');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'FOTO 2');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'FOTO 3');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'UND');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'CANTIDAD2');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'COSTE UNITARIO USD');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'COSTE TOTAL USD');


$fila = 2;
$query = "
    SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.status, t_proyectos_planaccion.coste, 
    t_proyectos_planaccion.fecha_creacion,
    t_proyectos_planaccion.area,
    t_proyectos_planaccion.unidad_medida,
    t_proyectos_planaccion.cantidad,
    t_proyectos_planaccion.coste
    FROM t_proyectos_planaccion 
    WHERE t_proyectos_planaccion.id_proyecto = $idProyecto and t_proyectos_planaccion.activo = 1
";
if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $e) {
        $fila++;
        $idP = $e['id'];
        $actividadP = $e['actividad'];
        $statusP = $e['status'];
        $fechaCreacionP = $e['fecha_creacion'];
        $areaP = $e['area'];
        $unidadP = $e['unidad_medida'];
        $cantidadP = $e['cantidad'];
        $costeP = $e['coste'];
        $totalP = $cantidadP * $costeP;

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $idP);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $areaP);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $actividadP);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $unidadP);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $cantidadP);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $costeP);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $totalP);

        $contador = 0;
        $query = "SELECT url_adjunto FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idP and status = 1 ORDER BY id ASC LIMIT 3";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $z) {
                $contador++;
                $url = $z['url_adjunto'];

                if (file_exists("../../planner/proyectos/$url")) {
                    $url2 = "http://www.maphg.com/planner/proyectos/$url";
                } elseif (file_exists("../planner/proyectos/$url")) {
                    $url2 = "http://www.maphg.com/beta/planner/proyectos/$url";
                } elseif (file_exists("../planner/proyectos/planaccion/$url")) {
                    $url2 = "http://www.maphg.com/beta/planner/proyectos/planaccion/$url";
                } else {
                    $url2 = "";
                }

                if ($contador == 1) {
                    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, '=Hyperlink("' . $url2 . '","Imagen 1")');
                } elseif ($contador == 2) {
                    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, '=Hyperlink("' . $url2 . '","Imagen 2")');
                } else {
                    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, '=Hyperlink("' . $url2 . '","Imagen 3")');
                }
            }
        }
    }
}


// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte Proyectos_' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');