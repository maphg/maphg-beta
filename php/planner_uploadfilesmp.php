<?php

include 'conexion.php';
$conn = new Conexion();
$conn->conectar();
$ds = DIRECTORY_SEPARATOR; //1 
$storeFolder = '../planner/mp/'; //2
$idMP = $_POST['idMP'];

if (!empty($_FILES)) {
    foreach ($_FILES as $key) { 
        $tempFile = $key['tmp_name'];
        $realFileName = $key['name'];
        $file = pathinfo($realFileName);
        $fileExtension = $file['extension'];
        $targetPath = $storeFolder;
        $fileName = $idMP . rand() . ".$fileExtension";
        $targetFile = $targetPath . $fileName;


        if (file_exists($targetFile)) {
            
        } else {
            //q$query = "INSERT INTO t_equipos_img(id_equipo, url_image) VALUES($idEquipo, '$fileName')";
            $query = "INSERT INTO t_mp_adjuntos (id_mp, url_adjunto) VALUES ($idMP, '$fileName')";
            try {
                $resp = $conn->consulta($query);
                if ($resp == 1) {
                    move_uploaded_file($tempFile, $targetFile);
                    echo "Archivo cargado con exito";
                }else{
                    echo "-1";
                }
            } catch (Exception $ex) {
                echo $ex;
            }
        }
    }
}else{
    echo "No hay archivos";
}
?>



