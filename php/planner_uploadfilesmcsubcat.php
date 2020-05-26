<?php

include 'conexion.php';
$conn = new Conexion();
$conn->conectar();
$ds = DIRECTORY_SEPARATOR; //1 
$storeFolder = '../planner/tareas/adjuntos/'; //2

//$general = $_POST['general'];

    $idActividad = $_POST['idEquipo'];

    if (!empty($_FILES)) {
        $tempFile = $_FILES['fileToUpload']['tmp_name'];
        $realFileName = $_FILES['fileToUpload']['name'];
        $file = pathinfo($realFileName);
        $fileExtension = $file['extension'];
        $targetPath = $storeFolder;
        $fileName = $idActividad . rand() . ".$fileExtension";
        $targetFile = $targetPath . $fileName;


        if (file_exists($targetFile)) {
            
        } else {
            //q$query = "INSERT INTO t_equipos_img(id_equipo, url_image) VALUES($idEquipo, '$fileName')";
            $query = "INSERT INTO t_mc_subcategoria_adjuntos_generales (id_equipo, url_adjunto) VALUES ($idActividad, '$fileName')";
            try {
                $resp = $conn->consulta($query);
                if ($resp == 1) {
                    move_uploaded_file($tempFile, $targetFile);
                    echo "Archivo cargado con exito";
                }
            } catch (Exception $ex) {
                echo $ex;
            }
        }
    }

?>



