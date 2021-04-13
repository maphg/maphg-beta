<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';

if (isset($_GET['action'])) {
    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $semanaActual = date('W');
    $fila = 1;

    if ($action == "obtenerPedidosSinOrden") {
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Pedidos Sin Orden");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'CECO');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Solicitud');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Fecha Solicitud');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Material');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Descripcion Material');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Cantida Solicitada');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Grupo Compras');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Unidad Medida');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Sección');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Solicitud Borrada');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Fecha Modificacion');


        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and pedidos.id_destino = $idDestino";
        }

        $query = "SELECT pedidos.id, pedidos.denominacion_ceco, pedidos.solicitud_pedido, pedidos.fecha_solicitud, pedidos.material, pedidos.descripcion_material, pedidos.cantidad_solicitada, pedidos.unidad_medida, pedidos.grupo_compras, pedidos.solicitud_borrada, pedidos.fecha_modificado, pedidos.seccion
        FROM t_pedidos_sin_orden_compra AS pedidos
        WHERE pedidos.activo = 1 $filtroDestino 
        ORDER BY pedidos.fecha_modificado ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $ceco = $x['denominacion_ceco'];
                $solicitud = $x['solicitud_pedido'];
                $fechaSolicitud = $x['fecha_solicitud'];
                $material = $x['material'];
                $descripcionMaterial = $x['descripcion_material'];
                $cantidaSolicitada = $x['cantidad_solicitada'];
                $unidadMedida = $x['unidad_medida'];
                $grupoCompras = $x['grupo_compras'];
                $seccion = $x['seccion'];
                $solicitudBorrada = $x['solicitud_borrada'];
                $fechaModificacion = $x['fecha_modificado'];
                $fila++;


                if ($seccion == "") {
                    $seccion = "-";
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $ceco);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $solicitud);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $fechaSolicitud);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $material);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $descripcionMaterial);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $cantidaSolicitada);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $grupoCompras);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $unidadMedida);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $solicitudBorrada);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $fechaModificacion);
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_PEDIDOS_SIN_ORDEN' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }


    // OBTIENE PEDIDOS PENDIENTES Y ENTREGADOS
    if ($action == "obtenerPedidosEntregar") {
        $status = $_GET['status'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and entregar.id_destino = $idDestino";
        }

        if (
            $status == "PENDIENTE"
        ) {
            $filtroStatus = "and entregar.cantidad_por_entregar > 0";
        } else {
            $filtroStatus = "and entregar.cantidad_por_entregar = 0";
        }


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Pedidos Sin Orden");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'CECO');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Solicitud Pedido');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Fecha Solicitud');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Documento Compras');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Fecha Entrega');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Fecha Documento');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Proveedor');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Material');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Descripción Material');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Cantidad Solicitud');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Cantidad Por Entregar');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Tipo');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'Valor USD');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'Sección');
        $fila = 1;

        $query = "SELECT entregar.id, entregar.nombre_ceco, entregar.solicitud_pedido, entregar.fecha_solicitud, entregar.documento_compras, entregar.fecha_entrega, entregar.fecha_documento, entregar.proveedor, 
        entregar.material, entregar.descripcion_material, entregar.cantidad_solicitud, entregar.cantidad_por_entregar, entregar.tipo, entregar.valor_usd, entregar.seccion, entregar.fecha_modificado
        FROM t_pedidos_por_entregar AS entregar
        WHERE entregar.activo = 1 $filtroDestino $filtroStatus";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $ceco = $x['nombre_ceco'];
                $solicitudPedido = $x['solicitud_pedido'];
                $fechaSolicitud = $x['fecha_solicitud'];
                $documentoCompras = $x['documento_compras'];
                $fechaEntrega = $x['fecha_entrega'];
                $fechaDocumento = $x['fecha_documento'];
                $proveedor = $x['proveedor'];
                $material = $x['material'];
                $descripcionMaterial = $x['descripcion_material'];
                $cantidadSolicitud = $x['cantidad_solicitud'];
                $cantidadPorEntregar = $x['cantidad_por_entregar'];
                $tipo = $x['tipo'];
                $valorUSD = $x['valor_usd'];
                $seccion = $x['seccion'];
                $fechaModificacion = $x['fecha_modificado'];
                $fila++;

                if (
                    $seccion == ""
                ) {
                    $seccion = "-";
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $ceco);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $solicitudPedido);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $documentoCompras);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $fechaEntrega);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $fechaDocumento);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $proveedor);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $material);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $descripcionMaterial);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $cantidadSolicitud);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $cantidadPorEntregar);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $tipo);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $valorUSD);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $fechaModificacion);
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_PEDIDOS_POR_ENTREGAR' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }
}
