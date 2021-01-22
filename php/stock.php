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

    if ($action == "consultarStock") {
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_stock_items.id_destino = $idDestino";
        }

        $query = "SELECT t_stock_items.id, t_stock_items.cod2bend, 
        t_stock_items.descripcion_cod2bend, t_stock_items.descripcion_sstt, t_stock_items.area, t_stock_items.categoria, t_stock_items.stock_teorico, t_stock_items.stock_real, t_stock_items.marca, t_stock_items.modelo, t_stock_items.caracteristicas, 
        t_stock_items.subfamilia, t_stock_items.subalmacen, t_stock_items.activo, 
        c_destinos.destino, c_secciones.seccion
        FROM t_stock_items
        INNER JOIN c_destinos ON t_stock_items.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_stock_items.id_seccion = c_secciones.id
        WHERE t_stock_items.activo = 1 $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $cod2bend = $x['cod2bend'];
                $descripcion_cod2bend = $x['descripcion_cod2bend'];
                $descripcion_sstt = $x['descripcion_sstt'];
                $area = $x['area'];
                $categoria = $x['categoria'];
                $stock_teorico = $x['stock_teorico'];
                $stock_real = $x['stock_real'];
                $marca = $x['marca'];
                $modelo = $x['modelo'];
                $caracteristicas = $x['caracteristicas'];
                $subfamilia = $x['subfamilia'];
                $subalmacen = $x['subalmacen'];
                $activo = $x['activo'];
                $destino = $x['destino'];
                $seccion = $x['seccion'];

                $array[] = array(
                    "idItem" => intval($idItem),
                    "cod2bend" => "$cod2bend",
                    "descripcionCod2bend" => "$descripcion_cod2bend",
                    "descripcionSstt" => "$descripcion_sstt",
                    "area" => "$area",
                    "categoria" => "$categoria",
                    "stockTeorico" => "$stock_teorico",
                    "stockReal" => "$stock_real",
                    "marca" => "$marca",
                    "modelo" => "$modelo",
                    "caracteristicas" => "$caracteristicas",
                    "subfamilia" => "$subfamilia",
                    "subalmacen" => "$subalmacen",
                    "activo" => "$activo",
                    "destino" => "$destino",
                    "seccion" => "$seccion"
                );
            }
        }
        echo json_encode($array);
    }
}
