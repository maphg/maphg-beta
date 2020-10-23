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
    $array = array();

    if ($action == "consultarStock") {
        $query = "SELECT id, seccion, area, descripcion, marca, modelo, caracteristicas, codigo, categoria, status, fecha, stock_real, stock_teorico   FROM t_stock_america WHERE id_destino = $idDestino  and activo =1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $id = $x['id'];
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

                $arrayTemp = array(
                    "id" => $id,
                    "seccion" => "$seccion",
                    "area" => "$area",
                    "descripcion" => "$descripcion",
                    "marca" => "$marca",
                    "modelo" => "$modelo",
                    "caracteristicas" => "$caracteristicas",
                    "codigo" => "$codigo",
                    "categoria" => "$categoria",
                    "status" => "$status",
                    "fecha" => "$fecha",
                    "stock_real" => "$stock_real",
                    "stock_teorico" => "$stock_teorico"
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }
}
