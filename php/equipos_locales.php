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

    if ($action == "obtenerEquiposTemp") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $palabraEquipo = $_GET['palabraEquipo'];
        $contador = 0;
        $array = array();

        if ($palabraEquipo != "") {
            $filtroPalabra = "and (t_equipos_america.id = '$palabraEquipo' 
            or t_equipos_america.equipo LIKE '%$palabraEquipo%')";
        } else {
            $filtroPalabra = "";
        }

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo 
        FROM t_equipos_america
        WHERE t_equipos_america.id_destino = $idDestino and t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.status  = 'OPERATIVO' and t_equipos_america.activo = 1 $filtroPalabra
        ";
        if ($resultEquipo = mysqli_query($conn_2020, $query)) {
            foreach ($resultEquipo as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];
                $contador++;

                #FALLAS PENDIENTES
                $fallasPendientes = 0;

                #FALLAS PENDIENTES
                $fallasPendientes = 0;

                #FALLAS PENDIENTES
                $fallasSolucionadas = 0;

                #TAREAS PENDIENTES
                $tareasPendientes = 0;

                #TAREAS SOLUCIONADAS
                $tareasSolucionadas = 0;

                #MP SOLUCIONADOS, PENDIENTES y PROXIMO
                $mpPendientes = 0;
                $mpSolucionados = 0;
                $mpProximo = 0;
                $mpUltimo = 0;


                #TOTAL COTIZACIONES POR EQUIPOS
                $totalCotizaciones = 0;


                $arrayTemp = array(
                    "filaNumero" => intval($contador),
                    "idEquipo" => intval($idEquipo),
                    "equipo" => $equipo,
                    "fallasPendientes" => intval($fallasPendientes),
                    "fallasSolucionadas" => intval($fallasSolucionadas),
                    "tareasPendientes" => intval($tareasPendientes),
                    "tareasSolucionadas" => intval($tareasSolucionadas),
                    "mpSolucionados" => intval($mpSolucionados),
                    "mpPendientes" => intval($mpPendientes),
                    "mpUltimo" => intval($mpUltimo),
                    "mpProximo" => intval($mpProximo),
                    "totalCotizaciones" => intval($totalCotizaciones)
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }

    if ($action == "obtenerEquipos") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $palabraEquipo = $_GET['palabraEquipo'];
        $contador = 0;
        $array = array();

        if ($palabraEquipo != "") {
            $filtroPalabra = "and (t_equipos_america.id = '$palabraEquipo' 
            or t_equipos_america.equipo LIKE '%$palabraEquipo%')";
        } else {
            $filtroPalabra = "";
        }

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo 
        FROM t_equipos_america
        WHERE t_equipos_america.id_destino = $idDestino and t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.status  = 'OPERATIVO' and t_equipos_america.activo = 1 $filtroPalabra
        ";
        if ($resultEquipo = mysqli_query($conn_2020, $query)) {
            foreach ($resultEquipo as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];
                $contador++;

                #FALLAS PENDIENTES
                $fallasPendientes = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                    and (status = 'N' or status = '' or status = 'PENDIENTE') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasPendientes = $a['count(id)'];
                    }
                }

                #FALLAS PENDIENTES
                $fallasPendientes = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                    and (status = 'N' or status = '' or status = 'PENDIENTE') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasPendientes = $a['count(id)'];
                    }
                }

                #FALLAS PENDIENTES
                $fallasSolucionadas = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                    and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasSolucionadas = $a['count(id)'];
                    }
                }

                #TAREAS PENDIENTES
                $tareasPendientes = 0;
                $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                    and (status = 'N' or status = 'P' or status = 'PENDIENTE') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tareasPendientes = $a['count(id)'];
                    }
                }

                #TAREAS SOLUCIONADAS
                $tareasSolucionadas = 0;
                $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                    and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tareasSolucionadas = $a['count(id)'];
                    }
                }

                #MP SOLUCIONADOS, PENDIENTES y PROXIMO
                $mpPendientes = 0;
                $mpSolucionados = 0;
                $mpProximo = 0;
                $mpUltimo = 0;
                $query = "SELECT* FROM t_mp_planeacion_proceso WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $tareasSolucionadas = 0;
                    foreach ($result as $a) {
                        for ($x = 1; $x < 53; $x++) {
                            $semana_x = $a['semana_' . $x];
                            if ($semana_x == "PROCESO") {
                                $mpPendientes++;
                                if ($mpProximo == 0) {
                                    $mpProximo = $x;
                                }
                            } elseif ($semana_x == "SOLUCIONADO") {
                                $mpSolucionados++;
                                if ($mpUltimo == 0) {
                                    $mpUltimo = $x;
                                }
                            }
                        }
                    }
                }

                #TOTAL COTIZACIONES POR EQUIPOS
                $totalCotizaciones = 0;
                $query = "SELECT count(id) FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalCotizaciones = $a['count(id)'];
                    }
                }

                $arrayTemp = array(
                    "filaNumero" => intval($contador),
                    "idEquipo" => intval($idEquipo),
                    "equipo" => $equipo,
                    "fallasPendientes" => intval($fallasPendientes),
                    "fallasSolucionadas" => intval($fallasSolucionadas),
                    "tareasPendientes" => intval($tareasPendientes),
                    "tareasSolucionadas" => intval($tareasSolucionadas),
                    "mpSolucionados" => intval($mpSolucionados),
                    "mpPendientes" => intval($mpPendientes),
                    "mpUltimo" => intval($mpUltimo),
                    "mpProximo" => intval($mpProximo),
                    "totalCotizaciones" => intval($totalCotizaciones)
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }
}