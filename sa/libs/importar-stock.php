<?php

include 'simplexlsx.class.php';
include 'conexion.php';

$conn = new Conexion();
$conn->conectar();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['fileToUpload']['type'])) {
    
    //$tipoGasto = $_POST['tipoGasto'];
    $target_dir = '../files/';
    $target_file = $target_dir . basename($_FILES['fileToUpload']['name']);
    $salida = "";
    if (file_exists($target_file)) {
        echo 'Ya existe el archivo';
    } else {
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)) {
            $xlsx = new SimpleXLSX($target_file);
            $cont = 0;
            $salida = "";

            foreach ($xlsx->rows() as $fields) {
                $cont++;
                date_default_timezone_set('America/Mexico_City');
                if ($cont > 1) {
                    $query = "INSERT INTO t_subalmacenes_items (id_subalmacen, barcode, cod2bend, descripcion, marca, modelo, caracteristicas, tipo_material, cantidad, unidad, precio, fecha_registro, id_usuario, categoria, color) "
                            . "VALUES($fields[0], '$fields[1]', '$fields[2]','$fields[3]','$fields[4]','$fields[5]','$fields[6]','$fields[7]',$fields[8],'$fields[9]',$fields[10],'$fields[11]',$fields[12],'$fields[13]','$fields[14]')";



                    try {
                        $resp = $conn->consulta($query);
                    } catch (Exception $ex) {
                        echo $ex . " - " . $query . " <br>";
                    }
                }
            }

            echo $resp;
        } else {
            echo 'No se subio el archivo';
        }
    }
    unlink($target_file);
    $conn->cerrar();
}
?>



