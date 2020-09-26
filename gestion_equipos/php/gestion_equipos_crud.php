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

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, t_equipos_america.local_equipo, t_equipos_america.modelo, t_equipos_america.status, t_equipos_america.id_fases,
        c_secciones.seccion, c_subsecciones.grupo, c_tipos.tipo, c_marcas.marca, c_ubicaciones.ubicacion, 
        c_destinos.destino
        FROM t_equipos_america
        LEFT JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        LEFT JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        LEFT JOIN c_tipos ON t_equipos_america.id_tipo = c_tipos.id
        LEFT JOIN c_marcas ON t_equipos_america.id_marca = c_marcas.id
        LEFT JOIN c_ubicaciones ON t_equipos_america.id_ubicacion = c_ubicaciones.id
        LEFT JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
        WHERE t_equipos_america.activo = 1 
        $filtroDestino $filtroSeccion  $filtroSubseccion $filtroTipo $filtroStatus $filtroPalabra";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $equipo = $i['equipo'];
                $local_equipo = $i['local_equipo'];
                $status = $i['status'];
                $seccion = $i['seccion'];
                $subseccion = $i['grupo'];
                $tipo = $i['tipo'];
                $marca = $i['marca'];
                $ubicacion = $i['ubicacion'];
                $modelo = $i['modelo'];
                $idFases = $i['id_fases'];
                $destino = $i['destino'];

                $semana = "";
                $mp = "SELECT semana FROM t_mp_planificacion_iniciada WHERE id_equipo = $id ORDER BY id ASC LIMIT 1";
                if ($result = mysqli_query($conn_2020, $mp)) {
                    foreach ($result as $i) {
                        $semana = $i['semana'];
                    }
                }
 
                $fase = "";
                $fases = "SELECT fase FROM c_fases WHERE id IN($idFases)";
                if ($result = mysqli_query($conn_2020, $fases)) {
                    foreach ($result as $i) {
                        $fase .= $i['fase'] . " ";
                    }
                }


                $arrayTemp = array(
                    "id" => "$id",
                    "destino" => "$destino",
                    "equipo" => "$equipo",
                    "seccion" => "$seccion",
                    "subseccion" => "$subseccion",
                    "marca" => "$fase",
                    "tipoEquipo" => "$tipo",
                    "status" => "$status",
                    "marcaEquipo" => "$marca",
                    "modelo" => "$modelo",
                    "equipoLocal" => "$local_equipo",
                    "ubicacion" => "$ubicacion",
                    "ultimoMP" => "$semana"
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


    // Consulta el despiece de Equipos incluyendo el Equipo Padre
    if($action == "despieceEquipos"){
        $idEquipo = $_GET['idEquipo'];
        $array = array();
        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, t_equipos_america.jerarquia FROM t_equipos_america WHERE t_equipos_america.activo = 1 and (t_equipos_america.id = $idEquipo OR t_equipos_america.id_equipo_principal = $idEquipo)";

        if($result = mysqli_query($conn_2020, $query)){
            foreach ($result as $i) {
                $id = $i['id'];
                $equipo = $i['equipo'];
                $jerarquia = $i['jerarquia'];

                $arrayTemp = array("id" => "$id", "equipo" => "$equipo", "jerarquia"=>"$jerarquia");
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }


    // Consulta posibles Equipos Jerarquicos
    if($action == "opcionesJerarquiaEquipo"){
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT t_equipos_america.id, t_equipos_america.id_destino, t_equipos_america.id_subseccion FROM t_equipos_america WHERE t_equipos_america.activo = 1 AND t_equipos_america.id = $idEquipo";

        if($result = mysqli_query($conn_2020, $query)){
            foreach ($result as $i) {
                $idDestino = $i['id_destino'];
                $idSubseccion= $i['id_subseccion'];

                $query ="SELECT id, equipo FROM t_equipos_america WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion";
                if($result = mysqli_query($conn_2020, $query)){
                    foreach ($result as $i) {
                        $id = $i['id'];
                        $equipo = $i['equipo'];

                        $arrayTemp = array("id" => "$id", "equipo" => "$equipo");
                        $array[] = $arrayTemp;
                    }
                }
            }
            echo json_encode($array);
        }
    }
}
