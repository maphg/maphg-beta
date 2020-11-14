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


    if ($action == "exportarEquipos") {
        $array = array();
        $contador = 0;

        $query = "SELECT id FROM t_equipos WHERE id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id'];

                $query = "SELECT id FROM t_equipos_america WHERE id = $idEquipo";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $contador++;
                        $idEquiposX = $x['id'];
                        $arrayTemp = array("idEquipo" => intval($idEquiposX));
                        $array['equipo'][] = $arrayTemp;
                    }
                }
                $array['totalEquipos'] = $contador;
            }
        }
        echo json_encode($array);
    }

    if ($action == "exportarEquiposConfirmado") {
        $array = array();
        $contadorExportados = 0;
        $contadorEquipos = -1;

        $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id'];
                $cod2bend = $x['cod2bend'];
                $equipo = $x['equipo'];
                $matricula = $x['matricula'];
                $id_marca = $x['id_marca'];
                $modelo = $x['modelo'];
                $serie = $x['serie'];
                $id_tipo = $x['id_tipo'];
                $id_ccoste = $x['id_ccoste'];
                $id_destino = $x['id_destino'];
                $id_hotel = $x['id_hotel'];
                $id_seccion = $x['id_seccion'];
                $id_subseccion = $x['id_subseccion'];
                $id_area = $x['id_area'];
                $id_localizacion = $x['id_localizacion'];
                $id_ubicacion = $x['id_ubicacion'];
                $id_sububicacion = $x['id_sububicacion'];
                $status_equipo = $x['status_equipo'];
                $categoria = $x['categoria'];
                $status = $x['status'];
                $coste = $x['coste'];
                $contadorEquipos++;

                if ($status == "A") {
                    $status = "OPERATIVO";
                } else {
                    $status = "BAJA";
                }
                $arrayTemp = array("id" => $idEquipo, "status" => "No Agregado");
                $array['equipo'][] = $arrayTemp;

                $query = "INSERT INTO  t_equipos_america(id, equipo, cod2bend, matricula, serie, id_destino, id_seccion, id_subseccion, id_tipo, id_ccoste, id_hotel, id_area, id_localizacion, id_ubicacion, id_sububicacion, categoria, local_equipo, jerarquia, id_marca, modelo, numero_serie, codigo_fabricante, coste, id_fases, status, activo) VALUES($idEquipo, '$equipo', '$cod2bend', '$matricula', '$serie', '$id_destino', '$id_seccion', '$id_subseccion', '$id_tipo', '$id_ccoste', '$id_hotel', '$id_area', '$id_localizacion', '$id_ubicacion', '$id_sububicacion', '$categoria', 'EQUIPO', 'PRINCIPAL', '$id_marca', '$modelo', '', '', '$coste', '', '$status', 1)";
                // $array['EQUIPO'][$idEquipo]['QUERY'] = $query;

                if ($result = mysqli_query($conn_2020, $query)) {
                    $arrayTemp = array("id" => $idEquipo, "status" => "Agregado");
                    $array['equipo'][$contadorEquipos] = $arrayTemp;
                    $contadorExportados++;
                }
            }
            $array['totalEquipos'] = intval($contadorEquipos) + 1;
            $array['totalExportados'] = $contadorExportados;
        }
        echo json_encode($array);
    }
}
