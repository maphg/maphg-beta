<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
// Modulo para importar la Conxión a la DB.
include 'conexion.php';

if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $array = array();

    if ($action == "obtenerPedidosSinOrden") {

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and pedidos.id_destino = $idDestino";
        }

        $query = "SELECT pedidos.id, pedidos.denominacion_ceco, pedidos.solicitud_pedido, pedidos.fecha_solicitud, pedidos.material, pedidos.descripcion_material, pedidos.cantidad_solicitada, pedidos.unidad_medida, pedidos.grupo_compras, pedidos.seccion, pedidos.solicitud_borrada, pedidos.fecha_modificado
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
            }
        }
        echo json_encode($array);
    }


    // OBTIENE PEDIDOS PENDIENTES Y ENTREGADOS
    if ($action == "obtenerPedidosEntregar") {
        $status = $_GET['status'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and entregar.id_destino = $idDestino";
        }

        if ($status == "PENDIENTE") {
            $filtroStatus = "and entregar.cantidad_por_entregar > 0";
        } else {
            $filtroStatus = "and entregar.cantidad_por_entregar = 0";
        }

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

                if ($seccion == "") {
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
            }
        }
        echo json_encode($array);
    }
}
