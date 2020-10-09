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
    $añoActual = date('Y');
    $semanaActual = date('W');

    if ($action == "obtenerProyecto") {
        $idProyecto = $_GET['idProyecto'];
        $contador = 0;
        $array = array();
        $actividades = array();
        $imagenes = array();

        $query = "
            SELECT t_proyectos.id, t_proyectos.titulo, t_proyectos.justificacion, t_proyectos.fecha_creacion, t_proyectos.rango_fecha, t_proyectos.status, 
            t_proyectos.tipo, t_proyectos.coste, t_colaboradores.nombre, t_colaboradores.apellido, c_destinos.destino, c_secciones.seccion, 
            c_subsecciones.grupo
            FROM t_proyectos
            LEFT JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
            LEFT JOIN c_secciones ON t_proyectos.id_seccion = c_secciones.id
            LEFT JOIN c_subsecciones ON t_proyectos.id_subseccion = c_subsecciones.id
            LEFT JOIN t_users ON t_proyectos.responsable = t_users.id
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_proyectos.id = $idProyecto
        ";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $titulo = $i['titulo'];
                $destino = $i['destino'];
                $seccion = $i['seccion'];
                $subseccion = $i['grupo'];
                $responsable = $i['nombre'] . " " . $i['apellido'];
                $coste = $i['coste'];
                $justifiacion = $i['justificacion'];
                $status = $i['status'];
                $tipo = $i['tipo'];
                $rangoFecha = $i['rango_fecha'];
                $fechaCreacion = $i['fecha_creacion'];

                if ($rangoFecha != "") {
                    $fecha = $rangoFecha;
                } else {
                    $fecha = $fechaCreacion;
                }

                if ($responsable == "") {
                    $responsable = "Sin Responsable";
                }

                if ($status == "N") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }



                $query = "
                    SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.status, t_proyectos_planaccion.coste, 
                    t_proyectos_planaccion.fecha_creacion, t_colaboradores.nombre, t_colaboradores.apellido
                    FROM t_proyectos_planaccion 
                    LEFT JOIN t_users ON t_proyectos_planaccion.responsable = t_users.id
                    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_proyectos_planaccion.id_proyecto = $idProyecto and t_proyectos_planaccion.activo = 1
                ";

                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $e) {
                        $contador++;
                        $idP = $e['id'];
                        $actividadP = $e['actividad'];
                        $statusP = $e['status'];
                        $fechaCreacionP = $e['fecha_creacion'];
                        $responsableP = $e['nombre'] . " " . $e['apellido'];
                        $costeP = $e['coste'];

                        if ($responsableP == "") {
                            $responsableP = "Sin Responsable";
                        }

                        if ($statusP == "N") {
                            $statusP = "PENDIENTE";
                        } else {
                            $statusP = "SOLUCIONADO";
                        }

                        $idImagen = "";
                        $url = "";
                        $query = "SELECT id, url_adjunto FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idP and status = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $a) {

                                if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {

                                    if (file_exists("../../planner/proyectos/planaccion/$url")) {
                                        $url2 = "https://www.maphg.com/beta/planner/proyectos/planaccion/$url";
                                    } elseif (file_exists("../../planner/proyectos/$url")) {
                                        $url2 = "https://www.maphg.com/beta/planner/proyectos/$url";
                                    } elseif (file_exists("../../../planner/proyectos/$url")) {
                                        $url2 = "https://www.maphg.com/planner/proyectos/$url";
                                    }

                                    $imagenesTemp = array("id" => $idImagen, "url" => $url2);
                                    $imagenes[] = $imagenesTemp;
                                }
                            }
                        }

                        $comentarios = "";
                        $comentario = "SELECT comentario FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $idP ORDER BY id ASC LIMIT 1";
                        if ($result = mysqli_query($conn_2020, $comentario)) {
                            foreach ($result as $x) {
                                $comentarios = $x['comentario'];
                            }
                        }

                        $actividadesTemp = array("idActividad" => $idP, "actividad" => $actividadP, "coste" => $costeP, "comentario" => $comentarios, "imagenes" => $imagenes);
                        $actividades[] = $actividadesTemp;
                    }
                }
                // Obtiene datos del Proyecto
                $proyecto = array("destino" => $destino, "seccion" => $seccion, "subseccion" => $subseccion, "proyecto" => $titulo, "actividades" => $contador);
                $array['proyecto'] = $proyecto;
                $array['actividades'] = $actividades;
            }
        }
        echo json_encode($array);
    }
}
