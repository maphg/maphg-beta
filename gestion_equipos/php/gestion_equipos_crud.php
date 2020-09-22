<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../../php/conexion.php';

if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');

    if ($action == "consultaEquiposLocales") {
        $filtroDestino = intval($_GET['filtroDestino']);
        $filtroSeccion = intval($_GET['filtroSeccion']);
        $filtroSubseccion = intval($_GET['filtroSubseccion']);
        $filtroTipo = $_GET['filtroTipo'];
        $filtroStatus = $_GET['filtroStatus'];
        $filtroPalabra = $_GET['filtroPalabra'];
        $array = array();

        if ($filtroDestino > 0) {
            $filtroDestino = "and t_equipos_america.id_destino = $filtroDestino";
        } else {
            $filtroDestino = "";
        }

        if ($filtroTipo == "0") {
            $filtroTipo = "";
        } else {
            $filtroTipo = "and t_equipos_america.local_equipo = '$filtroTipo'";
        }

        if ($filtroStatus == "0") {
            $filtroStatus = "";
        } else {
            $filtroStatus = "and t_equipos_america.status = '$filtroStatus'";
        }

        if ($filtroSeccion > 0 and $filtroSubseccion > 0) {
            $filtroSeccion = "and t_equipos_america.id_destino = $filtroSeccion";
            $filtroSubseccion = "and t_equipos_america.id_destino = $filtroSubseccion";
        } else {
            $filtroSeccion = "";
            $filtroSubseccion = "";
        }

        if ($filtroPalabra == "") {
            $filtroPalabra = "";
        } else {
            $filtroPalabra = "and (t_equipos_america.equipo LIKE '%$filtroPalabra%')";
        }

        $query = "SELECT* FROM t_equipos_america WHERE t_equipos_america.activo = 1 
        $filtroDestino $filtroSeccion  $filtroSubseccion $filtroTipo $filtroStatus $filtroPalabra";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $equipo = $i['equipo'];
                $local_equipo = $i['local_equipo'];

                $arrayTemp = array(
                    "id" => "$id",
                    "destino" => "rm",
                    "equipo" => "$equipo",
                    "seccion" => "ZIC",
                    "subseccion" => "FAN&COILS",
                    "marca" => "TRS",
                    "tipoEquipo" => "Junnior Suite",
                    "status" => "OPERATIVO",
                    "marcaEquipo" => "MARCA",
                    "modelo" => "MODELO",
                    "equipoLocal" => "$local_equipo",
                    "ubicacion" => "Habitacion 1104",
                    "ultimoMP" => "2(X)"
                );

                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }

    if ($action == "consultarDestinos") {
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id = $idDestino";
        }

        $query = "SELECT id, destino FROM c_destinos WHERE status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $destino = $i['destino'];

                $arrayTemp = array("id" => "$id", "destino" => "$destino");
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }

    if ($action == "consultarSecciones") {
        $array = array();

        $query = "SELECT id, seccion FROM c_secciones WHERE status = 'A' and id IN(11,10,24,1,23,19,5,6,7,12,8,9)";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $seccion = $i['seccion'];

                $arrayTemp = array("id" => "$id", "seccion" => "$seccion");
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }

    // Opciones para el Filtro de Subsecciones según la Seccion Asignada en el Filtro
    if ($action == "consultarSubsecciones") {
        $idSeccion =  $_GET['idSeccion'];
        $array = array();

        $query = "SELECT id, grupo FROM c_subsecciones WHERE id_seccion = $idSeccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $subseccion = $i['grupo'];

                $arrayTemp = array("id" => "$id", "subseccion" => "$subseccion");
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }
}
