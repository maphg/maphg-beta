<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';

if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];

    if ($action == "seguridad_session") {
        $query = "SELECT count(id) FROM t_users WHERE id = $idUsuario and status ='A'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $id = intval($x['count(id)']);
            }

            if ($id == 0) {
                echo json_encode(0);
            } else {
                echo json_encode(1);
            }
        }
    }
}
