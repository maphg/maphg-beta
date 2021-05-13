<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../php/conexion.php';
header("Access-Control-Allow-Origin: *");
if (isset($_GET['action'])) {

    //Variables Globales
    $action = $_GET['action'];
    // $idUsuario = $_GET['idUsuario'];
    // $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $array = array();

    if ($action == "proyecto") {
        $idProyecto = $_GET['idProyecto'];

        $query = "SELECT p.id 'idItem', 
        p.titulo, 
        p.justificacion, 
        p.fecha_creacion, 
        p.rango_fecha, 
        p.responsable, 
        p.status,
        p.tipo,
        p.coste, 
        p.presupuesto, 
        p.año,
        p.fecha_finalizado,
        d.destino,
        s.seccion,
        sb.grupo, 
        c.nombre, c.apellido
        FROM t_proyectos AS p
        INNER JOIN c_destinos AS d ON p.id_destino = d.id
        INNER JOIN c_secciones AS s ON p.id_seccion = s.id
        INNER JOIN c_subsecciones AS sb ON p.id_subseccion = sb.id
        INNER JOIN t_users AS u ON p.creado_por = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE p.activo = 1 and p.id = $idProyecto";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['idItem'];
                $destino = $x['destino'];
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $titulo = $x['titulo'];
                $justificacion = $x['justificacion'];
                $fechaCreacion = (new \DateTime($x['fecha_creacion']))->format('Y-m-d');
                $ragoFecha = $x['rango_fecha'];
                $creadoPor = $x['nombre'] . ' ' . $x['apellido'];
                $idResponsable = $x['responsable'];
                $status = $x['status'];
                $tipo = $x['tipo'];
                $coste = $x['coste'];
                $presupuesto = $x['presupuesto'];
                $año = $x['año'];
                $fechaFinalizado = (new \DateTime($x['fecha_finalizado']))->format('Y-m-d');

                #PLANES DE ACCIÓN
                $acciones = array();
                $query = "SELECT pda.id, 
                pda.actividad, 
                pda.status, 
                pda.fecha_creacion, 
                pda.rango_fecha
                FROM t_proyectos_planaccion AS pda
                WHERE pda.id_proyecto = $idItem and pda.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idPlanaccion = $x['id'];
                        $actividad = $x['actividad'];
                        $status = $x['status'];
                        $fechaCreacion = (new \DateTime($x['fecha_creacion']))->format('Y-m-d');
                        $rangoFecha = $x['rango_fecha'];

                        if ($status == "PENDIENTE" || $status == "N") {
                            $status = "PENDIENTE";
                        } else {
                            $status = "SOLUCIONADO";
                        }

                        $acciones[] = array(
                            "idPlan" => intval($idPlanaccion),
                            "actividad" => $actividad,
                            "status" => $status,
                            "fechaCreacion" => $fechaCreacion,
                            "rangoFecha" => $rangoFecha,
                        );
                    }
                }

                #CATALOGOS DE CONCEPTOS
                $catalogosConcepto = array();
                $query = "SELECT c.id, c.url_adjunto, c.fecha
                FROM t_proyectos_catalogo_conceptos AS c
                WHERE c.id_proyecto = $idItem and c.status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idCatalogo = $x['id'];
                        $url = $x['url_adjunto'];
                        $extension = pathinfo($url, PATHINFO_EXTENSION);
                        $fecha = (new \DateTime($x['fecha']))->format('Y-m-d');

                        $catalogosConcepto[] = array(
                            "idCatalogo" => intval($idCatalogo),
                            "url" => $url,
                            "extension" => $extension,
                            "fecha" => $fecha
                        );
                    }
                }

                #ADJUNTOS
                $adjuntos = array();
                $query = "SELECT a.id, a.url_adjunto, a.fecha
                FROM t_proyectos_adjuntos AS a
                WHERE a.id_proyecto = $idItem and a.status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idAdjunto = $x['id'];
                        $url = $x['url_adjunto'];
                        $extension = pathinfo($url, PATHINFO_EXTENSION);
                        $fecha = (new \DateTime($x['fecha']))->format('Y-m-d');

                        $adjuntos[] = array(
                            "idCatalogo" => intval($idAdjunto),
                            "url" => $url,
                            "extension" => $extension,
                            "fecha" => $fecha
                        );
                    }
                }

                #COTIZACIONES
                $cotizaciones = array();
                $query = "SELECT a.id, a.url_adjunto, a.fecha
                FROM t_proyectos_justificaciones AS a
                WHERE a.id_proyecto = $idItem and a.status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idCotizacion = $x['id'];
                        $url = $x['url_adjunto'];
                        $extension = pathinfo($url, PATHINFO_EXTENSION);
                        $fecha = (new \DateTime($x['fecha']))->format('Y-m-d');

                        $cotizaciones[] = array(
                            "idCatalogo" => intval($idCotizacion),
                            "url" => $url,
                            "extension" => $extension,
                            "fecha" => $fecha
                        );
                    }
                }

                $array[] = array(
                    "idItem" => intval($idItem),
                    "destino" => $destino,
                    "seccion" => $seccion,
                    "subseccion" => $subseccion,
                    "titulo" => $titulo,
                    "justificacion" => $justificacion,
                    "fechaCreacion" => $fechaCreacion,
                    "ragoFecha" => $ragoFecha,
                    "creadoPor" => $creadoPor,
                    "idResponsable" => $idResponsable,
                    "status" => $status,
                    "tipo" => $tipo,
                    "coste" => $coste,
                    "presupuesto" => $presupuesto,
                    "año" => $año,
                    "fechaFinalizado" => $fechaFinalizado,
                    "acciones" =>  $acciones,
                    "cotizaciones" => $cotizaciones,
                    "adjuntos" => $adjuntos,
                    "catalogoConceptos" => $catalogosConcepto

                );
            }
        }
        echo json_encode($array);
    }
}
