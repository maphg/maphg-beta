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

    // OBTIENE SOLICITUDES 2BEND
    if ($action == "obtenerSolicitudes2bend") {
        $query = "SELECT 
        s.id,
        d.destino, 
        s.numero_2bend,
        s.nombre,
        s.estado,
        s.coste,
        s.fecha,
        s.periodo_de,
        s.periodo_a,
        s.hotel,
        s.centro_coste,
        s.solicitud_sap
        FROM t_solicitudes_cod2bend AS s
        INNER JOIN c_destinos AS d ON s.id_destino = d.id
        WHERE s.id_destino = $idDestino and s.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $id = $x['id'];
                $destino = $x['destino'];
                $numero_2bend = $x['numero_2bend'];
                $nombre = $x['nombre'];
                $estado = $x['estado'];
                $coste = $x['coste'];
                $fecha = $x['fecha'];
                $periodo_de = $x['periodo_de'];
                $periodo_a = $x['periodo_a'];
                $hotel = $x['hotel'];
                $centro_coste = $x['centro_coste'];
                $solicitud_sap = $x['solicitud_sap'];

                $array[] = array(
                    "idItem" => $id,
                    "destino" => $destino,
                    "numero2bend" => $numero_2bend,
                    "nombre" => $nombre,
                    "estado" => $estado,
                    "coste" => $coste,
                    "fecha" => $fecha,
                    "periodoDe" => $periodo_de,
                    "periodoA" => $periodo_a,
                    "hotel" => $hotel,
                    "centroCoste" => $centro_coste,
                    "solicitudSap" => $solicitud_sap
                );
            }
        }
        echo json_encode($array);
    }


    // OBTENER SOLICITUDES
    if ($action == "obtenerDetalles") {
        $idItem = $_GET['idItem'];
        $solicitud = $_GET['solicitud'];

        $array['detalles'] = array();
        $array['resultados'] = array();

        $query = "SELECT d.destino, s.nombre, s.numero_2bend, s.fecha
        FROM t_solicitudes_cod2bend AS s
        INNER JOIN c_destinos AS d ON s.id_destino = d.id
        WHERE s.id = $idItem and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $destino = $x['destino'];
                $nombreCeco = $x['nombre'];
                $solicitud2bend = $x['numero_2bend'];
                $fechaSolicitud = $x['fecha'];

                $array['detalles'] = array(
                    "destino" => $destino,
                    "nombreCeco" => $nombreCeco,
                    "solicitud2bend" => $solicitud2bend,
                    "fechaSolicitud" => $fechaSolicitud
                );
            }
        }

        $query = "SELECT 
        p.id, 
        p.denominacion_ceco, 
        p.solicitud_pedido, 
        p.fecha_solicitud, 
        p.material, 
        p.descripcion_material, 
        p.cantidad_solicitada, 
        p.unidad_medida, 
        p.grupo_compras, 
        p.seccion, 
        p.solicitud_borrada, 
        p.fecha_modificado
        FROM t_pedidos_sin_orden_compra AS p
        WHERE p.activo = 1 and p.solicitud_pedido = '$solicitud'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $solicitud = $x['solicitud_pedido'];
                $fechaSolicitud = $x['fecha_solicitud'];
                $documentoCompras = "SIN DOCUMENTO";
                $fechaDocumento = "-";
                $fechaEntrega = "";
                $proveedor = "";
                $material = $x['material'];
                $descripcionMaterial = $x['descripcion_material'];
                $cantidadSolicitada = $x['cantidad_solicitada'];
                $cantidadEntregar = "";
                $valorUSD = "";
                $grupoCompras = $x['grupo_compras'];
                $seccion = $x['seccion'];
                $estatusLiberacion = "";
                $solicitudBorrada = $x['solicitud_borrada'];
                $tipo = "";

                $array['resultados'][] = array(
                    "solicitud" => "1 $solicitud",
                    "fechaSolicitud" => $fechaSolicitud,
                    "documentoCompras" => $documentoCompras,
                    "fechaDocumento" => $fechaDocumento,
                    "fechaEntrega" => $fechaEntrega,
                    "proveedor" => $proveedor,
                    "material" => $material,
                    "descripcionMaterial" => $descripcionMaterial,
                    "cantidadSolicitada" => $cantidadSolicitada,
                    "cantidadEntregar" => $cantidadEntregar,
                    "valorUSD" => $valorUSD,
                    "grupoCompras" => $grupoCompras,
                    "seccion" => $seccion,
                    "estatusLiberacion" => $estatusLiberacion,
                    "solicitudBorrada" => $solicitudBorrada,
                    "tipo" => $tipo
                );
            }
        }

        $query = "SELECT 
        e.id, 
        e.nombre_ceco, 
        e.solicitud_pedido, 
        e.fecha_solicitud, 
        e.documento_compras, 
        e.fecha_entrega, 
        e.fecha_documento, 
        e.proveedor, 
        e.material, 
        e.descripcion_material, 
        e.cantidad_solicitud, 
        e.cantidad_por_entregar, 
        e.tipo, 
        e.valor_usd, 
        e.seccion
        FROM t_pedidos_por_entregar AS e
        WHERE e.activo = 1 and e.solicitud_pedido = '$solicitud'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $solicitud = $x['solicitud_pedido'];
                $fechaSolicitud = $x['fecha_solicitud'];
                $documentoCompras = $x['documento_compras'];
                $fechaDocumento = $x['fecha_documento'];
                $fechaEntrega = $x['fecha_entrega'];
                $proveedor = $x['proveedor'];
                $material = $x['material'];
                $descripcionMaterial = $x['descripcion_material'];
                $cantidadSolicitada = $x['cantidad_solicitud'];
                $cantidadEntregar = $x['cantidad_por_entregar'];
                $valorUSD = $x['valor_usd'];
                $grupoCompras = "";
                $seccion = $x['seccion'];
                $estatusLiberacion = "";
                $solicitudBorrada = "";
                $tipo = "";

                $array['resultados'][] = array(
                    "solicitud" => "2 $solicitud",
                    "fechaSolicitud" => $fechaSolicitud,
                    "documentoCompras" => $documentoCompras,
                    "fechaDocumento" => $fechaDocumento,
                    "fechaEntrega" => $fechaEntrega,
                    "proveedor" => $proveedor,
                    "material" => $material,
                    "descripcionMaterial" => $descripcionMaterial,
                    "cantidadSolicitada" => $cantidadSolicitada,
                    "cantidadEntregar" => $cantidadEntregar,
                    "valorUSD" => $valorUSD,
                    "grupoCompras" => $grupoCompras,
                    "seccion" => $seccion,
                    "estatusLiberacion" => $estatusLiberacion,
                    "solicitudBorrada" => $solicitudBorrada,
                    "tipo" => $tipo
                );
            }
        }

        echo json_encode($array);
    }
}
