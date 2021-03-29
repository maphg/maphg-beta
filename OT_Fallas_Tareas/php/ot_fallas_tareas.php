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
            $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.status, c_secciones.seccion, c_subsecciones.grupo, c_destinos.destino, t_mp_np.rango_fecha, t_mp_np.tipo_incidencia, t_mp_np.responsable
            FROM t_mp_np
            INNER JOIN c_destinos ON t_mp_np.id_destino = c_destinos.id
            INNER JOIN c_secciones ON t_mp_np.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON t_mp_np.id_subseccion = c_subsecciones.id
            WHERE t_mp_np.id = $idOT";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idOT = $x['id'];
                    $actividad = $x['titulo'];
                    $status = $x['status'];
                    $destino = $x['destino'];
                    $seccion = $x['seccion'];
                    $subseccion = $x['grupo'];
                    $rangoFecha = $x['rango_fecha'];
                    $tipoIncidencia = $x['tipo_incidencia'];
                    $idResponsable = $x['responsable'];
                    $equipo = "TAREA GENERAL";

                    if ($status == "N" or $status == "PENDIENTE" or $status == "P") {
                        $status = "PENDIENTE";
                    } else {
                        $status = "SOLUCIONADO";
                    }

                    #RESPONSABLE
                    $responsable = "NOMBRE Y FIRMA";
                    $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_users
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id IN($idResponsable)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $responsable = $x['nombre'] . " " . $x['apellido'];
                        }
                    }

                    #ADJUNTOS
                    $adjuntos = array();
                    $query = "SELECT id, url FROM adjuntos_mp_np WHERE activo = 1 and id_mp_np = $idOT";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idAdjunto = $x['id'];
                            $url = $x['url'];
                            $tipo = pathinfo($url, PATHINFO_EXTENSION);

                            $adjuntos[] = array(
                                "idAdjunto" => intval($idAdjunto),
                                "url" => "../img/equipos/mpnp/$url",
                                "tipo" => $tipo
                            );
                        }
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
                        "rangoFecha" => $rangoFecha,
                        "responsable" => $responsable,
                        "adjuntos" => $adjuntos
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
            $query = "SELECT t_mc.id, t_mc.actividad, t_mc.status, t_equipos_america.equipo, c_secciones.seccion, c_subsecciones.grupo, c_destinos.destino, t_mc.rango_fecha, t_mc.tipo_incidencia, t_mc.responsable
            FROM t_mc
            INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id
            INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id
            INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
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
                    $idResponsable = $x['responsable'];

                    if ($status == "N" or $status == "PENDIENTE" or $status == "P") {
                        $status = "PENDIENTE";
                    } else {
                        $status = "SOLUCIONADO";
                    }

                    #ADJUNTOS
                    $adjuntos = array();
                    $query = "SELECT id, url_adjunto FROM t_mc_adjuntos WHERE activo = 1 and id_mc = $idOT";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idAdjunto = $x['id'];
                            $url = $x['url_adjunto'];
                            $tipo = pathinfo($url, PATHINFO_EXTENSION);

                            $adjuntos[] = array(
                                "idAdjunto" => intval($idAdjunto),
                                "url" => "../planner/tareas/adjuntos/$url",
                                "tipo" => $tipo
                            );
                        }
                    }

                    $responsable = "NOMBRE Y FIRMA";
                    $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_users
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id IN($idResponsable)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $responsable = $x['nombre'] . " " . $x['apellido'];
                        }
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
                        "rangoFecha" => $rangoFecha,
                        "responsable" => $responsable,
                        "adjuntos" => $adjuntos
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
        } elseif ($tipo == "ENERGETICO") {

            $query = "SELECT t_energeticos.id, t_energeticos.actividad, t_energeticos.status, c_secciones.seccion, c_subsecciones.grupo, c_destinos.destino, t_energeticos.rango_fecha, t_energeticos.tipo_incidencia, t_energeticos.responsable
            FROM t_energeticos
            INNER JOIN c_destinos ON t_energeticos.id_destino = c_destinos.id
            INNER JOIN c_secciones ON t_energeticos.id_seccion = c_secciones.id
            INNER JOIN c_subsecciones ON t_energeticos.id_subseccion = c_subsecciones.id
            WHERE t_energeticos.id = $idOT";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idOT = $x['id'];
                    $actividad = $x['actividad'];
                    $status = $x['status'];
                    $equipo = 'Energetico';
                    $destino = $x['destino'];
                    $seccion = $x['seccion'];
                    $subseccion = $x['grupo'];
                    $rangoFecha = $x['rango_fecha'];
                    $tipoIncidencia = $x['tipo_incidencia'];
                    $idResponsable = $x['responsable'];

                    if ($status == "N" or $status == "PENDIENTE" or $status == "P") {
                        $status = "PENDIENTE";
                    } else {
                        $status = "SOLUCIONADO";
                    }

                    #RESPONSABLE
                    $responsable = "NOMBRE Y FIRMA";
                    $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_users
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id IN($idResponsable)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $responsable = $x['nombre'] . " " . $x['apellido'];
                        }
                    }

                    #ADJUNTOS
                    $adjuntos = array();
                    $query = "SELECT id, url FROM t_energeticos_adjuntos 
                    WHERE activo = 1 and id_energetico = $idOT";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idAdjunto = $x['id'];
                            $url = $x['url'];
                            $tipo = pathinfo($url, PATHINFO_EXTENSION);

                            $adjuntos[] = array(
                                "idAdjunto" => intval($idAdjunto),
                                "url" => "../planner/energeticos/$url",
                                "tipo" => $tipo
                            );
                        }
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
                        "rangoFecha" => $rangoFecha,
                        "responsable" => $responsable,
                        "adjuntos" => $adjuntos
                    );

                    $query = "SELECT id, actividad, status FROM t_mp_np_actividades_ot WHERE id_tarea = 0 and activo = 1 ORDER BY id DESC";
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
