<?php

session_start();
include 'conexion.php';
$conn = new Conexion();
$conn->conectar();
$ds = DIRECTORY_SEPARATOR; //1 
$storeFolder = '../img/equipos/mpnp/'; //2
$idMPNP = $_POST['idMPNP'];
$idActividad = $_POST['idActividad'];
$usuario = $_SESSION['usuario'];
date_default_timezone_set('America/Cancun');
$fecha = date("Y-m-d H:i:s");
$resp ="";

if (!empty($_FILES)) {
    foreach ($_FILES as $key) {
        $tempFile = $key['tmp_name'];
        $realFileName = $key['name'];
        $file = pathinfo($realFileName);
        $fileExtension = $file['extension'];
        $targetPath = $storeFolder;
        $fileName = "idMPNP_".$idMPNP."_".rand().".".$fileExtension;
        $targetFile = $targetPath . $fileName;
        $nuevoNombre = "";
        $texto = preg_replace('([^A-Za-z0-9 .])', '', $fileName);


        if (file_exists($targetFile)) {
            echo "El archivo ya Existe.";
        } else {
            if (move_uploaded_file($tempFile, $targetFile)) {
                $query = "INSERT INTO adjuntos_mp_np (id_usuario, id_mp_np, id_actividad, url, fecha)VALUES ($usuario, $idMPNP, $idActividad, '$fileName', '$fecha')";
                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        $resp = "Adjunto Cargado";
                    } else { 
                        $resp = "-1";
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }else{
                $resp = $targetFile;
            }
        }
    }
} else {
    $resp = "No hay archivos";
}

echo $resp;
?>