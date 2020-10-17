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

    if ($action == "consultaProyectos") {
        $idSeccion = $_GET['idSeccion'];
        $status = $_GET['status'];
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_proyectos.id_destino = $idDestino";
        }

        if ($status == "PENDIENTE" or $status == "N") {
            $filtroStatus = "and (t_proyectos.status = 'N' or t_proyectos.status = 'PENDIENTE' or t_proyectos.status = '')";
        } elseif ($status == "SOLUCIONADO") {
            $filtroStatus = "and (t_proyectos.status = 'F' or t_proyectos.status = 'SOLUCIONADO')";
        } else {
            $filtroStatus = "";
        }

        $query = "SELECT t_proyectos.id, t_proyectos.titulo, t_proyectos.rango_fecha, 
        t_proyectos.responsable, t_proyectos.fecha_creacion, t_proyectos.justificacion, t_proyectos.coste, c_destinos.destino, t_colaboradores.nombre, t_colaboradores.apellido, t_proyectos.tipo
        FROM t_proyectos 
        LEFT JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
        LEFT JOIN t_users ON t_proyectos.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos.id_seccion = $idSeccion and t_proyectos.activo = 1 
        $filtroDestino  $filtroStatus
        ORDER BY t_proyectos.id DESC
        ";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $p) {
                $idProyecto = $p['id'];
                $creadoPor = $p['nombre'] . " " . $p['apellido'];
                $destino = $p['destino'];
                $titulo = $p['titulo'];
                $idResponsable = $p['responsable'];
                $rangoFecha = $p['rango_fecha'];
                $fechaCreacion = (new DateTime($p['fecha_creacion']))->format('d/m/Y');
                $justificacion = $p['justificacion'];
                $coste = $p['coste'];
                $tipo = $p['tipo'];

                #Rango Fecha
                if ($rangoFecha != "") {
                    $rangoFecha = explode(" - ", $rangoFecha);
                    if (isset($rangoFecha[0])) {
                        $fechaInicio = $rangoFecha[0];
                    } else {
                        $fechaInicio = $fechaCreacion;
                    }

                    if (isset($rangoFecha[1])) {
                        $fechaFin = $rangoFecha[1];
                    } else {
                        $fechaFin = $fechaCreacion;
                    }
                } else {
                    $fechaInicio = $fechaCreacion;
                    $fechaFin = $fechaCreacion;
                }

                #Justifiacion
                if ($justificacion != "") {
                    $justificacion = "SI";
                } else {
                    $justificacion = "NO";
                }

                #Status de Proyecto
                if ($status == "N" or $status == "PENDIENTE") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                #Coste
                if ($coste <= 0) {
                    $coste = 0;
                }

                #Obtiene PDA de Proyectos
                $query = "SELECT id, status FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $totalActividadesCreadas = 0;
                    $totalActividadesSolucionadas = 0;
                    $pda = "";
                    foreach ($result as $x) {
                        $idActividad = $x['id'];
                        $statusActividad = $x['status'];
                        if ($statusActividad == "N" || $statusActividad == "PENDIENTE") {
                            $totalActividadesSolucionadas++;
                        }
                        $totalActividadesCreadas++;
                    }
                    $pda = "$totalActividadesSolucionadas / $totalActividadesCreadas";
                }

                #Obtiene el Responsable Asignado
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable
                ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $nombreResponsable = "";
                    foreach ($result as $x) {
                        $nombreResponsable = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #Comentarios de Proyecto
                $query = "SELECT count(id) FROM t_proyectos_comentarios WHERE id_proyecto = $idProyecto and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $totalComentarios = 0;
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #Adjuntos de Proyecto
                $query = "SELECT count(id) FROM t_proyectos_adjuntos WHERE id_proyecto = $idProyecto and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $totalAdjuntos = 0;
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                $query = "SELECT status_urgente, status_material, status_trabajando, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $sMaterialx = 0;
                    $sEnergeticox = 0;
                    $sDepartamentox = 0;
                    $sTrabajandox = 0;

                    foreach ($result as $x) {
                        $sUrgente = $x['status_urgente'];
                        $sMaterial = $x['status_material'];
                        $sTrabajando = $x['status_trabajando'];
                        $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                        $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);

                        if ($sUrgente > 0) {
                            $sUrgentex = 1;
                        } else {
                            $sUrgentex = 0;
                        }
                        if ($sMaterial > 0) {
                            $sMaterialx = 1;
                        } else {
                            $sMaterialx = 0;
                        }
                        if ($sTrabajando > 0) {
                            $sTrabajandox = 1;
                        } else {
                            $sTrabajandox = 0;
                        }
                        if ($sEnergetico > 0) {
                            $sEnergeticox = 1;
                        } else {
                            $sEnergeticox = 0;
                        }
                        if ($sDepartamento > 0) {
                            $sDepartamentox = 1;
                        } else {
                            $sDepartamentox = 0;
                        }
                    }
                }

                $arrayTemp = array(
                    "id" => $idProyecto,
                    "destino" => $destino,
                    "proyecto" => $titulo,
                    "creadoPor" => $creadoPor,
                    "pda" => $pda,
                    "responsable" => $nombreResponsable,
                    "fechaInicio" => $fechaInicio, "fechaFin" => $fechaFin,
                    "cotizaciones" => $totalAdjuntos,
                    "tipo" => $tipo,
                    "justificacion" => $justificacion,
                    "comentarios" => $totalComentarios,
                    "coste" => $coste,
                    "status" => $status,
                    "materiales" => $sMaterialx,
                    "energeticos" => $sEnergeticox,
                    "departamento" => $sDepartamentox,
                    "trabajando" => $sTrabajandox
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }

    if ($action == "obtenerPlanaccion") {
        $idProyecto = $_GET['idProyecto'];
        $array = array();

        $query = "SELECT t_proyectos_planaccion.id, c_destinos.destino, 
        t_proyectos_planaccion.responsable,
        t_proyectos_planaccion.justificacion, t_proyectos_planaccion.actividad, 
        t_colaboradores.nombre, t_colaboradores.apellido,t_proyectos_planaccion.rango_fecha, t_proyectos_planaccion.fecha_creacion,t_proyectos_planaccion.coste, 
        t_proyectos_planaccion.status,
        t_proyectos_planaccion.status_urgente,
        t_proyectos_planaccion.status_material,
        t_proyectos_planaccion.status_trabajando,
        t_proyectos_planaccion.energetico_electricidad,
        t_proyectos_planaccion.energetico_agua, 
        t_proyectos_planaccion.energetico_diesel,
        t_proyectos_planaccion.energetico_gas,
        t_proyectos_planaccion.departamento_calidad,
        t_proyectos_planaccion.departamento_compras,
        t_proyectos_planaccion.departamento_direccion,
        t_proyectos_planaccion.departamento_finanzas,
        t_proyectos_planaccion.departamento_rrhh
        FROM t_proyectos_planaccion 
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id 
        INNER JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id 
        LEFT JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos_planaccion.id_proyecto = $idProyecto and t_proyectos_planaccion.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idPlanaccion = $x['id'];
                $actividad = $x['actividad'];
                $creadoPor = $x['nombre'] . " " . $x['apellido'];
                $idResponsable = $x['responsable'];
                $coste = $x['coste'];
                $justificacion = $x['justificacion'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = $x['fecha_creacion'];
                $destino = $x['destino'];
                $status = $x['status'];
                $sUrgente = $x['status_urgente'];
                $sMaterial = $x['status_material'];
                $sTrabajando = $x['status_trabajando'];
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $subTareas = 0;

                #Rango Fecha
                if ($rangoFecha != "") {
                    $rangoFecha = explode(" - ", $rangoFecha);
                    if (isset($rangoFecha[0])) {
                        $fechaInicio = $rangoFecha[0];
                    } else {
                        $fechaInicio = $fechaCreacion;
                    }

                    if (isset($rangoFecha[1])) {
                        $fechaFin = $rangoFecha[1];
                    } else {
                        $fechaFin = $fechaCreacion;
                    }
                } else {
                    $fechaInicio = $fechaCreacion;
                    $fechaFin = $fechaCreacion;
                }


                #Justifiacion
                if ($justificacion != "") {
                    $justificacion = "SI";
                } else {
                    $justificacion = "NO";
                }

                #Status de Planacción
                if ($status == "N" or $status == "PENDIENTE") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                #Coste
                if ($coste <= 0) {
                    $coste = 0;
                }
                #Status (Trabajando, Departamentos, Energeticos, Material)
                if ($sUrgente > 0) {
                    $sUrgentex = 1;
                } else {
                    $sUrgentex = 0;
                }
                if ($sMaterial > 0) {
                    $sMaterialx = 1;
                } else {
                    $sMaterialx = 0;
                }
                if ($sTrabajando > 0) {
                    $sTrabajandox = 1;
                } else {
                    $sTrabajandox = 0;
                }
                if ($sEnergetico > 0) {
                    $sEnergeticox = 1;
                } else {
                    $sEnergeticox = 0;
                }
                if ($sDepartamento > 0) {
                    $sDepartamentox = 1;
                } else {
                    $sDepartamentox = 0;
                }

                #Obtiene el Responsable Asignado
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id IN ($idResponsable)
                ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $nombreResponsable = "";
                    foreach ($result as $x) {
                        $nombreResponsable = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #Comentarios de Planaccion
                $query = "SELECT count(id) FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $idPlanaccion and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $totalComentarios = 0;
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #Adjuntos de Planaccion
                $query = "SELECT count(id) FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idProyecto and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $totalAdjuntos = 0;
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                $arrayTemp = array(
                    "id" => $idPlanaccion,
                    "destino" => $destino,
                    "actividad" => $actividad,
                    "creadoPor" => $creadoPor,
                    "subTareas" => $subTareas,
                    "responsable" => $nombreResponsable,
                    "fechaInicio" => $fechaInicio,
                    "fechaFin" => $fechaFin,
                    "comentarios" => $totalComentarios,
                    "adjuntos" => $totalAdjuntos,
                    "justificacion" => $justificacion,
                    "coste" => $coste,
                    "status" => $status,
                    "materiales" => intval($sMaterial),
                    "energeticos" => intval($sEnergetico),
                    "departamentos" => intval($sDepartamento),
                    "trabajando" => intval($sTrabajando)
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }
}
