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

    if ($action == "obtnerOTPlanaccion") {
        $idOT = $_GET['idOT'];
        $array = array();

        $query = "SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, 
        t_proyectos.titulo, t_proyectos_planaccion.status, t_proyectos_planaccion.fecha_creacion,
        c_secciones.seccion, c_subsecciones.grupo, c_destinos.destino
        FROM t_proyectos_planaccion 
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id
        INNER JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_proyectos.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_proyectos.id_subseccion = c_subsecciones.id
        WHERE t_proyectos_planaccion.id = $idOT";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idPlanaccion = $x['id'];
                $actividad = $x['actividad'];
                $status = $x['status'];
                $proyecto = $x['titulo'];
                $destino = $x['destino'];
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('d-m-Y');
                $año = (new DateTime($x['fecha_creacion']))->format('Y');

                if ($status == "N" || $status == "PENDIENTE" || $status == "") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                #ACTIVIDADES PLANACCION
                $query = "SELECT id, actividad FROM t_proyectos_planaccion_actividades WHERE id_planaccion = $idOT and activo = 1 ORDER BY id DESC";
                $arrayActividades = array();
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idActividadX = $x['id'];
                        $actividadX = $x['actividad'];
                        $arrayActividades[] =
                            array(
                                "id" => $idActividadX,
                                "actividad" => $actividadX
                            );
                    }
                }

                $query = "SELECT url_adjunto FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idPlanaccion and status = 1";
                $arrayAdjuntos = array();
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $url = $x['url_adjunto'];
                        if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {
                            $urlTemp = "../../planner/proyectos/planaccion/$url";
                            if (file_exists($urlTemp)) {
                                $url = "../planner/proyectos/planaccion/$url";
                                $arrayAdjuntos[] = array("url" => $url);
                            }
                        }
                    }
                }

                $array = array(
                    "idPlanaccion" => $idPlanaccion,
                    "actividad" => $actividad,
                    "proyecto" => $proyecto,
                    "seccion" => $seccion,
                    "destino" => $destino,
                    "seccion" => $seccion,
                    "subseccion" => $subseccion,
                    "status" => $status,
                    "año" => $año,
                    "fechaCreacion" => $fechaCreacion,
                    "actividades" => $arrayActividades,
                    "adjuntos" => $arrayAdjuntos
                );
            }
        }
        echo json_encode($array);
    }
}
