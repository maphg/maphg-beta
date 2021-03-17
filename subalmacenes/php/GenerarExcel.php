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
// OBTIENE TODOS LOS ITEMS DISPONIBLES PARA EL DESTINO
    $idSubalmacen = $_GET['idSubalmacen'];
    $stock = $_GET['stock'];


    $query = "SELECT t_subalmacenes.nombre, c_fases.fase 
    FROM t_subalmacenes 
    INNER JOIN c_fases ON t_subalmacenes.id_fase = c_fases.id
    WHERE t_subalmacenes.id = $idSubalmacen";
    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
            $subalmacen = $x['nombre'];
            $fase = $x['fase'];

            $array['subalmacen'] = array(
                "subalmacen" => $subalmacen,
                "fase" => $fase
            );
        }
    }

    $query = "SELECT id, cod2bend, descripcion_cod2bend, descripcion_servicio_tecnico, id_seccion, area, categoria, marca, modelo, caracteristicas, subfamilia  
    FROM t_subalmacenes_items_globales 
    WHERE id_destino = $idDestino and activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
            $idItemGlobal = $x['id'];
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

            #SECCION
            $seccion = "ND";
            $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $seccion = $x['seccion'];
                }
            }

            #STOCK
            $idItemStock = 0;
            $stockActual = 0;
            $stockTeorico = 0;
            $query = "SELECT id, stock_actual, stock_teorico 
                FROM t_subalmacenes_items_stock 
                WHERE id_item_global = $idItemGlobal and id_destino = $idDestino and id_subalmacen = $idSubalmacen and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idItemStock = $x['id'];
                    $stockActual = $x['stock_actual'];
                    $stockTeorico = $x['stock_teorico'];
                }
            }

            if ($idItemStock == 0) {
                $query = "INSERT INTO t_subalmacenes_items_stock(id_subalmacen, id_destino, id_item_global, stock_actual, stock_anterior, stock_teorico, fecha_movimiento, fecha_creacion, activo) VALUES($idSubalmacen, $idDestino, $idItemGlobal, 0, 0, 0, '$fechaActual', '$fechaActual', 1)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = 1;
                }
            }

            #SUBALMACEN
            $subalmacen = "";
            $query = "SELECT nombre FROM t_subalmacenes WHERE id = $idSubalmacen";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $subalmacen = $x['nombre'];
                }
            }

            $stockCantidad = "";
            $query = "SELECT stock_entrada
                FROM t_subalmacenes_items_stock_entradas 
                WHERE id_usuario = $idUsuario and id_subalmacen = $idSubalmacen and id_destino = $idDestino and id_item_global = $idItemGlobal and status = 'ESPERA' and activo = 1 LIMIT 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $stockCantidad = $x['stock_entrada'];
                }
            }

            $array['items'][] = array(
                "idItemGlobal" => intval($idItemGlobal),
                "idSubalmacen" => intval($idSubalmacen),
                "cod2bend" => $cod2bend,
                "descripcionCod2bend" => $descripcionCod2bend,
                "servicioTecnico" => $servicioTecnico,
                "seccion" => $seccion,
                "area" => $area,
                "categoria" => $categoria,
                "stockTeorico" => $stockTeorico,
                "stockActual" => $stockActual,
                "marca" => $marca,
                "modelo" => $modelo,
                "caracteristicas" => $caracteristicas,
                "subfamilia" => $subfamilia,
                "subalmacen" => $subalmacen,
                "stockCantidad" => $stockCantidad,
                "resp" => $resp
            );

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
        $fila++;
        }
    }




    }
}

$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_Subalmacén_' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
