<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../php/conexion.php';
header("Access-Control-Allow-Origin: *");
if (isset($_GET['action'])) {

    //Variables Globales
    $action = $_GET['action'];
    // $idUsuario = $_GET['idUsuario'];
    // $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $array = array();

    if ($action == "proyecto") {
        $idProyecto = $_GET['idProyecto'];
    }
}