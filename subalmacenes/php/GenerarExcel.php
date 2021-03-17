<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

require '../../php/PHPExcel.php';
include "../../php/conexion.php";

$fechaActual = date('Y-m-d H:m:s');

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $idDestino = $_GET['idDestino'];
    $idUsuario = $_GET['idUsuario'];

    if ($action == "generarExcel") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $stock = $_GET['stock'];

        if ($idSubalmacen == 0) {
            $filtroSubalmacen = "";
        } else {
            $filtroSubalmacen = "and id_subalmacen = $idSubalmacen";
        }

        if ($stock == 0) {
            $filtroStock = "and stock_actual == 0";
        } else {
            $filtroStock = "";
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Items");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID ITEM');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'COD2BEND');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'DESC. COD2BEND');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'DESC. SERV. TEC.');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'SECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'ÁREA');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'CATEGORÍA');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'STOCK TEORICO');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'STOCK REAL');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'MARCA');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'MODELO');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'CARACTERISTICAS');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'SUBFAMILIA');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'SUBALMACÉN / BODEGA');
        $fila = 2;

        $query = "SELECT id, stock_actual, stock_teorico, id_item_global, id_subalmacen
        FROM t_subalmacenes_items_stock 
        WHERE id_destino = $idDestino and activo = 1 $filtroSubalmacen $filtroStock
        ORDER BY id_subalmacen DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItemStock = $x['id'];
                $idItemGlobal = $x['id_item_global'];
                $stockActual = $x['stock_actual'];
                $stockTeorico = $x['stock_teorico'];
                $idSubalmacen = $x['id_subalmacen'];

                $cod2bend = "";
                $descripcionCod2bend = "";
                $servicioTecnico = "";
                $idSeccion = "";
                $area = "";
                $categoria = "";
                $marca = "";
                $modelo = "";
                $caracteristicas = "";
                $subfamilia = "";
                $query = "SELECT id, cod2bend, descripcion_cod2bend, descripcion_servicio_tecnico, id_seccion, area, categoria, marca, modelo, caracteristicas, subfamilia 
                FROM t_subalmacenes_items_globales
                WHERE id = $idItemGlobal";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $cod2bend = $x['cod2bend'];
                        $descripcionCod2bend = $x['descripcion_cod2bend'];
                        $servicioTecnico = $x['descripcion_servicio_tecnico'];
                        $idSeccion = $x['id_seccion'];
                        $area = $x['area'];
                        $categoria = $x['categoria'];
                        $marca = $x['marca'];
                        $modelo = $x['modelo'];
                        $caracteristicas = $x['caracteristicas'];
                        $subfamilia = $x['subfamilia'];
                    }
                }

                #SECCION
                $seccion = "ND";
                $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $seccion = $x['seccion'];
                    }
                }


                #SUBALMACEN
                $subalmacen = "NA";
                $query = "SELECT nombre FROM t_subalmacenes WHERE id = $idSubalmacen";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $subalmacen = $x['nombre'];
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $idItemStock);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $cod2bend);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $descripcionCod2bend);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $servicioTecnico);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $area);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $categoria);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $stockTeorico);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $stockActual);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $marca);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $modelo);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $caracteristicas);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $subfamilia);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $subalmacen);
                $fila++;
            }
        }
    }
}

header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_Subalmacén_' . $fechaActual . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
