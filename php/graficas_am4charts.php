<?php
include 'conexion.php';
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Variables Ajax.
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $idDestino = $_GET['idDestino'];
    $idSeccion = $_GET['idSeccion'];
    $idSubseccion = $_GET['idSubseccion'];
    $fechaActual = date('Y-m-d');

    if ($action == "ganttProyectosP") {
        $palabraProyecto = $_GET['palabraProyecto'];
        $dataArray = array();
        $contador = 0;

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND id_destino = $idDestino";
        }

        if ($palabraProyecto != "") {
            $filtroPalabra = "and titulo LIKE '%$palabraProyecto%'";
        } else {
            $filtroPalabra = "";
        }

        $query = "SELECT id, titulo, rango_fecha, fecha_creacion FROM t_proyectos 
        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and 
        activo = 1 and (status = 'P' or status = 'N' or status = '') $filtroDestino $filtroPalabra ORDER BY id ASC";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idProyecto = $i['id'];
                $titulo = $i['titulo'];
                $rangoFecha = $i['rango_fecha'];
                $fechaCreacion = $i['fecha_creacion'];
                $contador++;

                if (strlen($titulo) > 31) {
                    // Entonces corta la cadena y ponle el sufijo
                    $titulo = substr($titulo, 0, 30) . "...";
                }

                if ($rangoFecha != "" and strlen($rangoFecha) >= 23) {
                    $fechaInicio = "$rangoFecha[6]$rangoFecha[7]$rangoFecha[8]$rangoFecha[9]-$rangoFecha[3]$rangoFecha[4]-$rangoFecha[0]$rangoFecha[1]";

                    $fechaFin = "$rangoFecha[19]$rangoFecha[20]$rangoFecha[21]$rangoFecha[22]-$rangoFecha[16]$rangoFecha[17]-$rangoFecha[13]$rangoFecha[14]";
                } else {
                    $fechaInicio = (new DateTime($fechaCreacion))->format('Y-m-d');
                    $fechaFin = date("Y-m-d", strtotime($fechaInicio . "+ 4 days"));
                }

                // Array Temportal
                $arrayAux = array(
                    "category" => "$titulo",
                    "start" => "$fechaInicio",
                    "end" => "$fechaFin",
                    "color" => "colorSet.getIndex($contador)",
                    "task" => "$titulo"
                );


                // Se almacenan los Arrays Temporales
                $dataArray[] = $arrayAux;
            }
        }
        echo json_encode($dataArray);
    }

    if ($action == "ganttProyectosS") {
        $palabraProyecto = $_GET['palabraProyecto'];
        $dataArray = array();
        $contador = 0;

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND id_destino = $idDestino";
        }

        if ($palabraProyecto != "") {
            $filtroPalabra = "and titulo LIKE '%$palabraProyecto%'";
        } else {
            $filtroPalabra = "";
        }

        $query = "SELECT id, titulo, rango_fecha, fecha_creacion FROM t_proyectos 
        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and 
        activo = 1 and (status = 'F' or status = 'SOLUCIONADO' or status ='FINALIZADO') $filtroDestino $filtroPalabra ORDER BY id ASC";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idProyecto = $i['id'];
                $titulo = $i['titulo'];
                $rangoFecha = $i['rango_fecha'];
                $fechaCreacion = $i['fecha_creacion'];
                $contador++;

                if (strlen($titulo) > 31) {
                    // Entonces corta la cadena y ponle el sufijo
                    $titulo = substr($titulo, 0, 30) . "...";
                }

                if ($rangoFecha != "" and strlen($rangoFecha) >= 23) {
                    $fechaInicio = "$rangoFecha[6]$rangoFecha[7]$rangoFecha[8]$rangoFecha[9]-$rangoFecha[3]$rangoFecha[4]-$rangoFecha[0]$rangoFecha[1]";

                    $fechaFin = "$rangoFecha[19]$rangoFecha[20]$rangoFecha[21]$rangoFecha[22]-$rangoFecha[16]$rangoFecha[17]-$rangoFecha[13]$rangoFecha[14]";
                } else {
                    $fechaInicio = (new DateTime($fechaCreacion))->format('Y-m-d');
                    $fechaFin = date("Y-m-d", strtotime($fechaInicio . "+ 4 days"));
                }

                // Array Temportal
                $arrayAux = array(
                    "category" => "$titulo",
                    "start" => "$fechaInicio",
                    "end" => "$fechaFin",
                    "color" => "colorSet.getIndex($contador)",
                    "task" => "$titulo"
                );

                // Se almacenan los Arrays Temporales
                $dataArray[] = $arrayAux;
            }
        }
        echo json_encode($dataArray);
    }
}
