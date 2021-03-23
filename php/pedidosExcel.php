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

    if ($action == "obtenerPedidosSinOrden") {
        $fila = 2;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Pedidos Sin Orden");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ceco');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'solicitud');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'fechaSolicitud');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'material');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'descripcionMaterial');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'cantidaSolicitada');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'grupoCompras');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'unidadMedida');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'seccion');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'solicitudBorrada');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'fechaModificacion');


        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and pedidos.id_destino = $idDestino";
        }

        $query = "SELECT pedidos.id, pedidos.denominacion_ceco, pedidos.solicitud_pedido, pedidos.fecha_solicitud, pedidos.material, pedidos.descripcion_material, pedidos.cantidad_solicitada, pedidos.unidad_medida, pedidos.grupo_compras, pedidos.solicitud_borrada, pedidos.fecha_modificado, c_secciones.seccion
        FROM t_pedidos_sin_orden_compra AS pedidos
        LEFT JOIN c_secciones ON pedidos.id_seccion = c_secciones.id
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

                if ($seccion == "") {
                    $seccion = "-";
                }

                $array[] = array(
                    "idItem" => intval($idItem),
                    "ceco" => $ceco,
                    "solicitud" => $solicitud,
                    "fechaSolicitud" => $fechaSolicitud,
                    "material" => $material,
                    "descripcionMaterial" => $descripcionMaterial,
                    "cantidaSolicitada" => $cantidaSolicitada,
                    "grupoCompras" => $grupoCompras,
                    "unidadMedida" => $unidadMedida,
                    "seccion" => $seccion,
                    "solicitudBorrada" => $solicitudBorrada,
                    "fechaModificacion" => $fechaModificacion
                );

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
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Pedidos Con Orden");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ceco');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'solicitudPedido');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'fechaSolicitud');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'documentoCompras');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'fechaEntrega');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'fechaDocumento');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'proveedor');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'material');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'descripcionMaterial');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'cantidadSolicitud');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'cantidadPorEntregar');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'tipo');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'valorUSD');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'seccion');

        $query = "SELECT entregar.id, entregar.nombre_ceco, entregar.solicitud_pedido, entregar.fecha_solicitud, entregar.documento_compras, entregar.fecha_entrega, entregar.fecha_documento, entregar.proveedor, 
        entregar.material, entregar.descripcion_material, entregar.cantidad_solicitud, entregar.cantidad_por_entregar, entregar.tipo, entregar.valor_usd, c_secciones.seccion, entregar.fecha_modificado
        FROM t_pedidos_por_entregar AS entregar
        LEFT JOIN c_secciones ON entregar.id_seccion = c_secciones.id
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

                if (
                    $seccion == ""
                ) {
                    $seccion = "-";
                }

                $array[] = array(
                    "idItem" => intval($idItem),
                    "ceco" => $ceco,
                    "solicitudPedido" => $solicitudPedido,
                    "fechaSolicitud" => $fechaSolicitud,
                    "documentoCompras" => $documentoCompras,
                    "fechaEntrega" => $fechaEntrega,
                    "fechaDocumento" => $fechaDocumento,
                    "proveedor" => $proveedor,
                    "material" => $material,
                    "descripcionMaterial" => $descripcionMaterial,
                    "cantidadSolicitud" => $cantidadSolicitud,
                    "cantidadPorEntregar" => $cantidadPorEntregar,
                    "tipo" => $tipo,
                    "valorUSD" => $valorUSD,
                    "seccion" => $seccion,
                    "fechaModificacion" => $fechaModificacion
                );
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $ceco);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $solicitudPedido);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $fechaSolicitud);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $documentoCompras);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $fechaEntrega);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $fechaDocumento);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $proveedor);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $material);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $descripcionMaterial);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $cantidadSolicitud);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $cantidadPorEntregar);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $tipo);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $valorUSD);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $seccion);
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_PEDIDOS_CON_ORDEN' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }
}
