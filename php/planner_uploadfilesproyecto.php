<?php

session_start();
include 'conexion.php';
$conn = new Conexion();
$conn->conectar();
$ds = DIRECTORY_SEPARATOR; //1 
$storeFolder = '../planner/proyectos/'; //2
$idProyecto = $_POST['idProyecto'];
$justificacion = $_POST['justificacion'];

$idUsuario = $_SESSION['usuario'];
date_default_timezone_set('America/Cancun');
$fecha = date("Y-m-d H:i:s");

if (!empty($_FILES)) {
    $tempFile = $_FILES['fileToUpload']['tmp_name'];
    $realFileName = $_FILES['fileToUpload']['name'];
    $file = pathinfo($realFileName);
    $fileExtension = $file['extension'];
    $targetPath = $storeFolder;
    $fileName = $idProyecto . "_$realFileName";
    $targetFile = $targetPath . $fileName;


    if (file_exists($targetFile)) {
        
    } else {

        if (move_uploaded_file($tempFile, $targetFile)) {
            if ($justificacion == "SI") {
                $query = "INSERT INTO t_proyectos_justificaciones (id_proyecto, url_adjunto, fecha, subido_por) VALUES ($idProyecto, '$fileName', '$fecha', $idUsuario)";
            } else {
                $query = "INSERT INTO t_proyectos_adjuntos (id_proyecto, url_adjunto, fecha, subido_por) VALUES ($idProyecto, '$fileName', '$fecha', $idUsuario)";
            }

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
?>



