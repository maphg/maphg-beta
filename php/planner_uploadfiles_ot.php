<?php

session_start();
include 'conexion.php';
$conn = new Conexion();
$conn->conectar();
$ds = DIRECTORY_SEPARATOR; //1 
$storeFolder = '../planner/mp/'; //2
$idOT = $_POST['idOT'];
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
        $fileName = $idOT . "_$realFileName";
        $targetFile = $targetPath . $fileName;


        if (file_exists($targetFile)) {
            
        } else {
            if (move_uploaded_file($tempFile, $targetFile)) {
                //q$query = "INSERT INTO t_equipos_img(id_equipo, url_image) VALUES($idEquipo, '$fileName')";
                $query = "INSERT INTO t_mp_adjuntos (id_ot, url_adjunto, subido_por, fecha) "
                        . "VALUES ($idOT, '$fileName', $usuario, '$fecha')";
                try {
                    $resp = $conn->consulta($query);
                    if ($resp == 1) {
                        
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



