<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../../php/conexion.php';
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-D H:m:s');

    if ($action == "generarOT") {
        $idOT = $_GET['idOT'];
        $tipo = $_GET['tipo'];
        $array = array();
        $act = array();

        if ($tipo == "TAREA") {
            $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.status, t_equipos_america.equipo, c_secciones.seccion, c_subsecciones.grupo, c_destinos.destino, t_mp_np.rango_fecha, t_mp_np.tipo_incidencia
            FROM t_mp_np
            INNER JOIN c_destinos ON t_mp_np.id_destino = c_destinos.id
            LEFT JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
            INNER JOIN c_secciones ON t_mp_np.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON t_mp_np.id_subseccion = c_subsecciones.id
            WHERE t_mp_np.id = $idOT";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idOT = $x['id'];
                    $actividad = $x['titulo'];
                    $status = $x['status'];
                    $equipo = $x['equipo'];
                    $destino = $x['destino'];
                    $seccion = $x['seccion'];
                    $subseccion = $x['grupo'];
                    $rangoFecha = $x['rango_fecha'];
                    $tipoIncidencia = $x['tipo_incidencia'];

                    if ($status == "N" or $status == "PENDIENTE" or $status == "P") {
                        $status = "PENDIENTE";
                    } else {
                        $status = "SOLUCIONADO";
                    }

                    if ($equipo == "") {
                        $equipo = "TAREA GENERAL";
                    }

                    $array['datos'] = array(
                        "idOT" => $idOT,
                        "actividad" => $actividad,
                        "status" => $status,
                        "equipo" => $equipo,
                        "destino" => $destino,
                        "seccion" => $seccion,
                        "subseccion" => $subseccion,
                        "tipo" => $tipo,
                        "tipoIncidencia" => $tipoIncidencia,
                        "rangoFecha" => $rangoFecha
                    );

                    $query = "SELECT id, actividad, status FROM t_mp_np_actividades_ot WHERE id_tarea = $idOT and activo = 1 ORDER BY id DESC";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idActividad = $x['id'];
                            $actividadX = $x['actividad'];
                            $statusX = $x['status'];

                            if ($statusX == "N" or $statusX == "PENDIENTE" or $statusX == "P") {
                                $statusX = "PENDIENTE";
                            } else {
                                $statusX = "SOLUCIONADO";
                            }

                            $array['actividades'][] = array(
                                "idActividad" => $idActividad,
                                "actividad" => $actividadX,
                                "status" => $statusX
                            );
                        }
                    }
                }
            }
        } elseif ($tipo == "FALLA") {
            $query = "SELECT t_mc.id, t_mc.actividad, t_mc.status, t_equipos_america.equipo, c_secciones.seccion, c_subsecciones.grupo, c_destinos.destino, t_mc.rango_fecha, t_mc.tipo_incidencia
            FROM t_mc
            INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id
            INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id
            LEFT JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
            WHERE t_mc.id = $idOT";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idOT = $x['id'];
                    $actividad = $x['actividad'];
                    $status = $x['status'];
                    $equipo = $x['equipo'];
                    $destino = $x['destino'];
                    $seccion = $x['seccion'];
                    $subseccion = $x['grupo'];
                    $rangoFecha = $x['rango_fecha'];
                    $tipoIncidencia = $x['tipo_incidencia'];

                    if ($status == "N" or $status == "PENDIENTE" or $status == "P") {
                        $status = "PENDIENTE";
                    } else {
                        $status = "SOLUCIONADO";
                    }

                    $array['datos'] = array(
                        "idOT" => $idOT,
                        "actividad" => $actividad,
                        "status" => $status,
                        "equipo" => $equipo,
                        "destino" => $destino,
                        "seccion" => $seccion,
                        "subseccion" => $subseccion,
                        "tipo" => $tipo,
                        "tipoIncidencia" => $tipoIncidencia,
                        "rangoFecha" => $rangoFecha
                    );

                    $query = "SELECT id, actividad, status FROM t_mc_actividades_ot WHERE id_falla = $idOT and activo = 1 ORDER BY id DESC";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idActividad = $x['id'];
                            $actividadX = $x['actividad'];
                            $statusX = $x['status'];

                            if ($statusX == "N" or $statusX == "PENDIENTE" or $statusX == "P") {
                                $statusX = "PENDIENTE";
                            } else {
                                $statusX = "SOLUCIONADO";
                            }

                            $array['actividades'][] = array(
                                "idActividad" => $idActividad,
                                "actividad" => $actividadX,
                                "status" => $statusX
                            );
                        }
                    }
                }
            }
        }
    }
    echo json_encode($array);
}
