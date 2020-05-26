<?php

//$idDestino = $_POST['idDestino'];
//$idSubseccion = $_POST['idSubseccion'];

/* Database connection start */
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_maphg";

$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

/* Database connection end */


// storing  request (ie, get/post) global array to a variable
$requestData = $_REQUEST;


$columns = array(
// datatable column index  => database column name
    0 => 'id',
    1 => 'id_destino',
    2 => 'fase',
    3 => 'cod2bend',
    4 => 'descripcion2bend',
    5 => 'naturaleza',
    6 => 'id_seccion',
    7 => 'familia',
    8 => 'subfamilia',
    9 => 'descripcion_nueva',
    10 => 'marca',
    11 => 'modelo',
    12 => 'caracteristicas_principales',
    13 => 'stock_necesario',
    14 => 'num_existencias_2bend',
    15 => 'num_existencias_subalmacenes',
    16 => 'precio',
    17 => 'consumo_anual'
);

// getting total number records without any search
$sql = "SELECT id, descripcion2bend, descripcion_nueva ";
$sql .= " FROM t_stock_necesario";
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn));
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT t_stock_necesario.id 'ID', "
        . "t_stock_necesario.id_destino 'IDDESTINO', "
        . "t_stock_necesario.fase 'FASE', "
        . "t_stock_necesario.cod2bend 'COD2BEND', "
        . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
        . "t_stock_necesario.naturaleza 'NATURALEZA', "
        . "t_stock_necesario.id_seccion 'IDSECCION', "
        . "t_stock_necesario.familia 'FAMILIA', "
        . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
        . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
        . "t_stock_necesario.marca 'MARCA', "
        . "t_stock_necesario.modelo 'MODELO', "
        . "t_stock_necesario.caracteristicas_principales 'CARACTPPALES', "
        . "t_stock_necesario.stock_necesario 'STOCKNEC', "
        . "t_stock_necesario.num_existencias_2bend 'EXIS2BEND', "
        . "t_stock_necesario.num_existencias_subalmacenes 'EXISSA', "
        . "t_stock_necesario.precio 'PRECIO', "
        . "t_stock_necesario.consumo_anual 'CONSUMOANUAL', "
        . "c_destinos.destino 'DESTINO', "
        . "c_secciones.seccion 'SECCION', "
        . "c_subsecciones.grupo 'SUBSECCION' "
        . "FROM t_stock_necesario "
        . "INNER JOIN c_destinos ON t_stock_necesario.id_destino = c_destinos.id "
        . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
        . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
        . "WHERE t_stock_necesario.id_destino = 1 ";

if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql .= " AND ( t_stock_necesario.id LIKE '" . $requestData['search']['value'] . "%' ";
    $sql .= " OR t_stock_necesario.descripcion2bend LIKE '" . $requestData['search']['value'] . "%' ";

    $sql .= " OR t_stock_necesario.descripcion_nueva LIKE '" . $requestData['search']['value'] . "%' )";
}

$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . " - " . $sql);

$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.

$sql .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . "   " . $requestData['order'][0]['dir'] . "";

/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
$query = mysqli_query($conn, $sql) or die(mysqli_error($conn) . " - " . $sql);

$data = array();
while ($row = mysqli_fetch_array($query)) {  // preparing an array
    $nestedData = array();

    $nestedData[] = $row["ID"];
    $nestedData[] = $row["DESTINO"];
    $nestedData[] = $row["FASE"];
    $nestedData[] = $row["COD2BEND"];
    $nestedData[] = $row["DESC2BEND"];
    $nestedData[] = $row["NATURALEZA"];
    $nestedData[] = $row["SECCION"];
    $nestedData[] = $row["SUBSECCION"];
    $nestedData[] = $row["SUBFAMILIA"];
    $nestedData[] = $row["DESCNUEVA"];
    $nestedData[] = $row["MARCA"];
    $nestedData[] = $row["MODELO"];
    $nestedData[] = $row["CARACTPPALES"];
    $nestedData[] = $row["STOCKNEC"];
    $nestedData[] = $row["EXIS2BEND"];
    $nestedData[] = $row["EXISSA"];
    $nestedData[] = $row["PRECIO"];
    $nestedData[] = $row["CONSUMOANUAL"];

    $data[] = $nestedData;
}



$json_data = array(
    "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
    "recordsTotal" => intval($totalData), // total number of records
    "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
    "data" => $data   // total data array
);

echo json_encode($json_data);  // send data as json format
?>
