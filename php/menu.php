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
    $array = array();

    if ($action == "obtenerMenu") {

        $query = "SELECT id, id_padre, nivel, titulo, link, icono FROM t_menu WHERE activo = 1 and nivel = 'NIVEL_1'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idOpcion = $x['id'];
                $idPadre = $x['id_padre'];
                $nivel = $x['nivel'];
                $titulo = $x['titulo'];
                $link = $x['link'];
                $icono = $x['icono'];

                $array['NIVEL_1'][] = array(
                    "idOpcion" => intval($idOpcion),
                    "idPadre" => intval($idPadre),
                    "nivel" => $nivel,
                    "titulo" => $titulo,
                    "link" => $link,
                    "icono" => $icono
                );
            }
        }

        $query = "SELECT id, id_padre, nivel, titulo, link, icono FROM t_menu WHERE activo = 1 and nivel = 'NIVEL_2'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idOpcion = $x['id'];
                $idPadre = $x['id_padre'];
                $nivel = $x['nivel'];
                $titulo = $x['titulo'];
                $link = $x['link'];
                $icono = $x['icono'];

                $array['NIVEL_2'][] = array(
                    "idOpcion" => intval($idOpcion),
                    "idPadre" => intval($idPadre),
                    "nivel" => $nivel,
                    "titulo" => $titulo,
                    "link" => $link,
                    "icono" => $icono
                );
            }
        }

        $query = "SELECT id, id_padre, nivel, titulo, link, icono FROM t_menu WHERE activo = 1 and nivel = 'NIVEL_3'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idOpcion = $x['id'];
                $idPadre = $x['id_padre'];
                $nivel = $x['nivel'];
                $titulo = $x['titulo'];
                $link = $x['link'];
                $icono = $x['icono'];

                $array['NIVEL_3'][] = array(
                    "idOpcion" => intval($idOpcion),
                    "idPadre" => intval($idPadre),
                    "nivel" => $nivel,
                    "titulo" => $titulo,
                    "link" => $link,
                    "icono" => $icono
                );
            }
        }

        echo json_encode($array);
    }

    if ($action == "obtenerDatosCalendario") {
        $query = "SELECT id, destino FROM c_destinos WHERE id  = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestino = $x['id'];
                $destino = $x['destino'];

                $array = array(
                    "idDestino" => intval($idDestino),
                    "destino" => $destino
                );
            }
        }
        echo json_encode($array);
    }
}
