<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

require '../../php/PHPExcel.php';
include "../../php/conexion.php";

$fecha = date('Y-m-d H:m:s');

if (isset($_GET['idDestino'])) {

    if ($_GET['idDestino'] == 10) {
        $idDestino = "";
    } else {
        $idDestino = "AND t_subalmacenes_items_stock.id_destino = " . $_GET['idDestino'];
    }
}

if (isset($_GET['idSubalmacen'])) {
    $idSubalmacen = "AND t_subalmacenes_items_stock.id_subalmacen = " . $_GET['idSubalmacen'];
} else {
    $idSubalmacen = "";
}

if (isset($_GET['stock'])) {
    $stock = "AND t_subalmacenes_items_stock.stock_actual = " . $_GET['stock'];
} else {
    $stock = "";
}



//Correctivos Generales.
$query = "SELECT
    t_subalmacenes_items_globales.categoria,
    t_subalmacenes_items_globales.cod2bend,
    t_subalmacenes_items_globales.descripcion,
    t_subalmacenes_items_globales.caracteristicas,
    t_subalmacenes_items_globales.marca,
    t_subalmacenes_items_globales.unidad,
    t_subalmacenes_items_stock.id 'idItemsResultado',
    t_subalmacenes_items_stock.stock_teorico,
    t_subalmacenes_items_stock.stock_actual,
    bitacora_gremio.nombre_gremio,
    t_subalmacenes.nombre 'ubicacion'
    FROM t_subalmacenes_items_stock
    INNER JOIN t_subalmacenes ON t_subalmacenes_items_stock.id_subalmacen = t_subalmacenes.id
    INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_globales.id
    INNER JOIN bitacora_gremio ON t_subalmacenes_items_globales.id_gremio = bitacora_gremio.id
    WHERE t_subalmacenes_items_stock.activo = 1 $idDestino $idSubalmacen $stock";

// Titulos XLS
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Categoria');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Cod2bend');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Gremio');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Descripción');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Caracteristicas');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Marca');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Unidad');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Stock Teorico');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'Stock Actual');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'Ubicación');


$fila = 2;
if ($result = mysqli_query($conn_2020, $query)) {
    while ($row = mysqli_fetch_array($result)) {
        $idItemsResultado = $row['idItemsResultado'];
        $categoria = $row['categoria'];
        $cod2bend = $row['cod2bend'];
        $gremio = $row['nombre_gremio'];
        $descripcion = $row['descripcion'];
        $caracteristicas = $row['caracteristicas'];
        $marca = $row['marca'];
        $stockTeorico = $row['stock_teorico'];
        $stockActual = $row['stock_actual'];
        $unidad = $row['unidad'];
        $ubicacion = $row['ubicacion'];

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $categoria);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $cod2bend);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $gremio);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $descripcion);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $caracteristicas);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $marca);
        $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $unidad);
        $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $stockTeorico);
        $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $stockActual);
        $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $ubicacion);
        //Inicializa variables.

        //Contador de Celdas
        $fila++;
    }
}

$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_Subalmacén_' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
