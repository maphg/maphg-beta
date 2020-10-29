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
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $semanaActual = date('W');

    #OBTIENE LOS PROYECTOS SEGÚN LA SECCIÓN Y DESTINO
    if ($action == "actualizarActividadOT") {
        $idActividad = $_GET['idActividad'];
        $idTipo = $_GET['idTipo'];
        $tipo = $_GET['tipo'];
        $actividad = $_GET['actividad'];
        $columna = $_GET['columna'];
        $resp = array();
        $resp[0] = "ERROR";

        if ($tipo == "FALLA") {
            $tabla = "t_mc_actividades_ot";
        } elseif ($tipo == "TAREA") {
            $tabla = "t_mp_np_actividades_ot";
        }

        if ($columna == "activo") {
            $query = "UPDATE $tabla SET activo = 0 WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp[0] = "ELIMINADO";
            }
        } elseif ($columna == "status") {
            $query = "UPDATE $tabla SET status = 'SOLUCIONADO' WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp[0] = "SOLUCIONADO";
            }
        } elseif ($columna == "actividad") {
            $query = "UPDATE $tabla SET actividad = '$actividad' WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp[0] = "ACTIVIDAD";
            }
        } elseif ($columna == "nuevo") {
            $tipo = strtolower($tipo);
            $query  = "INSERT INTO $tabla (id_$tipo , actividad) VALUES($idTipo, '$actividad')";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp[0] = "AGREGADO";
            }
        } else {
            $resp[0] = "NOOPCION";
        }

        echo json_encode($resp);
    }
}
