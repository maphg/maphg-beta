<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';
$idDestino = $_GET['idDestino'];

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte Proyecto");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'id');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sección');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Área');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Descripción');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Marca');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Modelo');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Características');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Código');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Categoria');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Status');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'Fecha');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'Stock_real');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'Stock_teorico');

$fila = 1;
$query = "SELECT id, id_destino, seccion, area, descripcion, marca, modelo, caracteristicas, codigo, categoria, status, fecha, stock_real, stock_teorico   FROM t_stock_america WHERE id_destino = $idDestino  and activo =1";
if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $x) {
        // CONTADOR
        $fila++;
        $id = $x['id'];
        $idDestino = $x['id_destino'];
        $seccion = $x['seccion'];
        $area = $x['area'];
        $descripcion = $x['descripcion'];
        $marca = $x['marca'];
        $modelo = $x['modelo'];
        $caracteristicas = $x['caracteristicas'];
        $codigo = $x['codigo'];
        $categoria = $x['categoria'];
        $status = $x['status'];
        $fecha = $x['fecha'];
        $stock_real = $x['stock_real'];
        $stock_teorico = $x['stock_teorico'];

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $id);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $seccion);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $area);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $descripcion);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $marca);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $modelo);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $caracteristicas);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $codigo);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $categoria);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $status);
        $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $fecha);
        $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $stock_real);
        $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $stock_teorico);
    }
}

// $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
// $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte STOCK ' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
