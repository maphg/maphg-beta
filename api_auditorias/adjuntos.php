<?php
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('America/Cancun');

#ARRAY GLOBAL
$array = array();
$array['status'] = 'OK';
$array['version'] = '3.0.1 BETA';
$array['response'] = 'ERROR';
$array['data'] = array();

#OBTIENE EL TIPO DE PETICIÓN
$peticion = "";
if ($_SERVER['REQUEST_METHOD'])
    $peticion = $_SERVER['REQUEST_METHOD'];


#PETICIONES METODO _POST
if ($peticion === 'POST') {
    // $_POST = json_decode(file_get_contents('php://input'), true);

    #VARIABLES REQUERIDAS.
    $idDestino = $_POST['idDestino'];
    $idUsuario = $_POST['idUsuario'];
    $apartado = $_POST['apartado'];
    $accion = $_POST['accion'];

    #APARTADO DE AUDITORIAS.
    if ($apartado === 'auditorias') {
        include 'conexion.php';
        include_once "auditorias.php";

        if ($accion === "addTareasAdjuntos") {

            $rutaTemporal = $_FILES["file"]["tmp_name"];
            $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
            $adjunto =  $_POST['url'] . "." . $extension;

            $_POST['extension'] = $extension;
            $_POST['url'] = $adjunto;


            if (move_uploaded_file($rutaTemporal, "../Auditorias/adjuntos/" . $adjunto)) {
                #AGREGA TAREA
                $data = Auditorias::addTareasAdjuntos($_POST);

                #ARRAY DE RESULTADOS
                $array['response'] = "SUCCESS";
                $array['data'] = $data;
            }
        }
    }
}


echo json_encode($array);
