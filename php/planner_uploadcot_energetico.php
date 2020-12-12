<?php

session_start();
include 'conexion.php';
$conn = new Conexion();
$conn->conectar();
$ds = DIRECTORY_SEPARATOR; //1 
$storeFolder = '../planner/energeticos/'; //2
$idEnergetico = $_POST['idEnergetico'];
$usuario = $_SESSION['usuario'];
date_default_timezone_set('America/Cancun');
$fecha = date("Y-m-d H:i:s");

if (!empty($_FILES)) {
    foreach ($_FILES as $key) {
        $tempFile = $key['tmp_name'];
        $realFileName = $key['name'];
        $file = pathinfo($realFileName);
        $fileExtension = $file['extension'];
        $targetPath = $storeFolder;
        $fileName = "Energetico_ID_" . $idEnergetico . "_" . rand(1, 1000) . "." . $fileExtension;
        $targetFile = $targetPath . $fileName;

        if (file_exists($targetFile)) {
            $resp = 0;
        } else {
            if (move_uploaded_file($tempFile, $targetFile)) {
                $query = "INSERT INTO t_energeticos_adjuntos(id_energetico, subido_por, fecha, url, activo) VALUES ($idEnergetico, $usuario, '$fecha', '$fileName', 1)";
                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                    } else {
                        $resp = "-1";
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            } else {
                $resp = $targetFile;
            }
        }
    }
} else {
    $resp = 0;
}

echo $resp;
