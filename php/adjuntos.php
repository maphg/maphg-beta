<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';

if (isset($_GET['action'])) {

    // VARIABLES GLOBALES 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');

    #RUTAS
    $urlProyectos = 'planner/proyectos/';
    $urlPlanaccion = 'planner/proyectos/planaccion/';
    $urlEquipos = '';
    $urlIncidencias = '';
    $urlIncidenciasGenerales = '';
    $urlEnergeticos = '';

    #OBTIENE COTIZACIONES DE PROYECTOS
    if ($action == "obtenerCotizaciones") {
        $idProyecto = $_GET['idProyecto'];
        $array = array();

        $query = "SELECT id, url_adjunto, fecha FROM t_proyectos_adjuntos 
        WHERE id_proyecto = $idProyecto and status = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idAdjunto = $x['id'];
                $url = $x['url_adjunto'];
                $fecha = $x['fecha'];
                $extension = pathinfo($url, PATHINFO_EXTENSION);

                $array[] = array(
                    "idAdjunto" => $idAdjunto,
                    "url" => $url,
                    "fecha" => $fecha,
                    "extension" => $extension
                );
            }
        }
        echo json_encode($array);
    }

    #AGREGAR COTIZACIONES EN PROYECTOS
    if ($action == "agregarCotizacion") {
        $idProyecto = $_GET['idProyecto'];
        $resp = 0;

        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $nombre = str_replace("." . $extension, '', $nombreTemporal);
        $nombre = str_replace(" ", '', $nombre);
        $nombre = preg_replace('([^A-Za-z0-9.-_])', '', $nombre);
        $url = "$nombre" . "_COT$idProyecto" . ".$extension";

        if (move_uploaded_file($rutaTemporal, "../$urlProyectos" . $url)) {
            $query = "INSERT INTO t_proyectos_adjuntos(id_proyecto, url_adjunto, fecha, subido_por, status) 
            VALUES($idProyecto, '$url', '$fechaActual', $idUsuario, 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }


    #OBTIENE CATÁLOGO DE CONCEPTOS DE PROYECTOS
    if ($action == "obtenerCatalogoConceptos") {
        $idProyecto = $_GET['idProyecto'];
        $array = array();

        $query = "SELECT id, url_adjunto, fecha FROM t_proyectos_catalogo_conceptos 
        WHERE id_proyecto = $idProyecto and status = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idAdjunto = $x['id'];
                $url = $x['url_adjunto'];
                $fecha = $x['fecha'];
                $extension = pathinfo($url, PATHINFO_EXTENSION);

                $array[] = array(
                    "idAdjunto" => $idAdjunto,
                    "url" => $url,
                    "fecha" => $fecha,
                    "extension" => $extension
                );
            }
        }
        echo json_encode($array);
    }

    #AGREGAR CATÁLOGO DE CONCEPTOS EN PROYECTOS
    if ($action == "agregarCatalogoConceptos") {
        $idProyecto = $_GET['idProyecto'];
        $resp = 0;

        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $nombre = str_replace("." . $extension, '', $nombreTemporal);
        $nombre = str_replace(
            " ",
            '',
            $nombre
        );
        $nombre = preg_replace('([^A-Za-z0-9.-_])', '', $nombre);
        $url = "$nombre" . "_CAT$idProyecto" . ".$extension";

        if (move_uploaded_file($rutaTemporal, "../$urlProyectos" . $url)) {
            $query = "INSERT INTO t_proyectos_catalogo_conceptos(id_proyecto, url_adjunto, fecha, subido_por, status) 
            VALUES($idProyecto, '$url', '$fechaActual', $idUsuario, 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }
}