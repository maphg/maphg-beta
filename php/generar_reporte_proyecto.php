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
        $totalP = $cantidadP * $costeP;
        if ($responsableP == "") {
            $responsableP = "Sin Responsable";
        }

        if ($statusP == "N") {
            $statusP = "PENDIENTE";
        } else {
            $statusP = "SOLUCIONADO";
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getRowDimension($fila)->setRowHeight(45);
        $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $idP);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $area);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $actividadP);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $unidadP);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $cantidadP);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $costeP);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $totalP);

        $contador = 0;
        $query = "SELECT url_adjunto FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idP and status = 1 ORDER BY id ASC LIMIT 3";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $z) {
                $contador++;
                $url = $z['url_adjunto'];

                if (file_exists("../../planner/proyectos/$url")) {
                    $url2 = "../../planner/proyectos/$url";
                } elseif (file_exists("../planner/proyectos/$url")) {
                    $url2 = "../planner/proyectos/$url";
                } elseif (file_exists("../planner/proyectos/planaccion/$url")) {
                    $url2 = "../planner/proyectos/planaccion/$url";
                } else {
                    $url2 = "../svg/B0E3C0DE.jpg";
                }

                if ($contador == 1) {
                    $gdImage = imagecreatefromjpeg($url2);
                    // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
                    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
                    $objDrawing->setName('Sample image');
                    $objDrawing->setDescription('Sample image');
                    $objDrawing->setImageResource($gdImage);
                    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
                    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
                    $objDrawing->setHeight(50);
                    $objDrawing->setCoordinates('D' . $fila);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                } elseif ($contador == 2) {
                    $gdImage = imagecreatefromjpeg($url2);
                    // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
                    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
                    $objDrawing->setName('Sample image');
                    $objDrawing->setDescription('Sample image');
                    $objDrawing->setImageResource($gdImage);
                    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
                    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
                    $objDrawing->setHeight(50);
                    $objDrawing->setCoordinates('E' . $fila);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                } else {
                    $gdImage = imagecreatefromjpeg($url2);
                    // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
                    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
                    $objDrawing->setName('Sample image');
                    $objDrawing->setDescription('Sample image');
                    $objDrawing->setImageResource($gdImage);
                    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
                    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
                    $objDrawing->setHeight(50);
                    $objDrawing->setCoordinates('F' . $fila);
                    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
                }
            }
        }
    }
}




// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
