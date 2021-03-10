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
    if ($action == "obtenerProyectos") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
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
        t_proyectos.responsable, t_proyectos.fecha_creacion, t_proyectos.justificacion, t_proyectos.coste, t_proyectos.presupuesto, c_destinos.destino, t_colaboradores.nombre, t_colaboradores.apellido, t_proyectos.tipo, t_proyectos.status_i, t_proyectos.status_ap
        FROM t_proyectos 
        LEFT JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
        LEFT JOIN t_users ON t_proyectos.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos.id_seccion = $idSeccion and t_proyectos.id_subseccion = $idSubseccion 
        and t_proyectos.activo = 1
        $filtroDestino  $filtroStatus
        ORDER BY t_proyectos.id DESC";
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
                $presupuesto = $p['presupuesto'];
                $tipo = $p['tipo'];
                $sI = $p['status_i'];
                $sAP = $p['status_ap'];

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

                #Adjuntos Catálogo de Conceptos
                $query = "SELECT count(id) FROM t_proyectos_catalogo_conceptos 
                WHERE id_proyecto = $idProyecto and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $totalAdjuntos + intval($x['count(id)']);
                    }
                }

                $query = "SELECT status_urgente, status_material, status_trabajando, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, status_ep
                FROM t_proyectos_planaccion 
                WHERE id_proyecto = $idProyecto";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $sMaterialx = 0;
                    $sEnergeticox = 0;
                    $sDepartamentox = 0;
                    $sTrabajandox = 0;
                    $sEPx = 0;

                    foreach ($result as $x) {
                        $sUrgente = $x['status_urgente'];
                        $sMaterial = $x['status_material'];
                        $sTrabajando = $x['status_trabajando'];
                        $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                        $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                        $sEP = $x['status_ep'];

                        if ($sUrgente > 0) {
                            $sUrgentex = 1;
                        }
                        if ($sMaterial > 0) {
                            $sMaterialx = 1;
                        }
                        if ($sTrabajando > 0) {
                            $sTrabajandox = 1;
                        }
                        if ($sEnergetico > 0) {
                            $sEnergeticox = 1;
                        }
                        if ($sDepartamento >= 1) {
                            $sDepartamentox = 1;
                        }
                        if ($sEP >= 1) {
                            $sEPx = 1;
                        }
                    }
                }

                $array[] = array(
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
                    "presupuesto" => $presupuesto,
                    "status" => $status,
                    "materiales" => intval($sMaterialx),
                    "energeticos" => intval($sEnergeticox),
                    "departamento" => intval($sDepartamentox),
                    "trabajando" => intval($sTrabajandox),
                    "sEP" => intval($sEPx),
                    "sI" => intval($sI),
                    "sAP" => intval($sAP)
                );
            }
        }
        echo json_encode($array);
    }


    #OBTIENE LOS PLANES DE ACCIÓN POR PROYECTO
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
        t_proyectos_planaccion.departamento_rrhh,
        t_proyectos_planaccion.status_ep
        FROM t_proyectos_planaccion 
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id 
        INNER JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id 
        LEFT JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos_planaccion.id_proyecto = $idProyecto and t_proyectos_planaccion.activo = 1 ORDER BY t_proyectos_planaccion.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {

                // Valor Inicial STATUS 
                $sMaterialx = 0;
                $sEnergeticox = 0;
                $sDepartamentox = 0;
                $sTrabajandox = 0;
                // Valor Inicial STATUS 

                $idPlanaccion = $x['id'];
                $actividad = $x['actividad'];
                $creadoPor = $x['nombre'] . " " . $x['apellido'];
                $idResponsable = $x['responsable'];
                $coste = $x['coste'];
                $justificacion = $x['justificacion'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('d/m/Y');
                $destino = $x['destino'];
                $status = $x['status'];
                $sUrgente = $x['status_urgente'];
                $sMaterial = $x['status_material'];
                $sTrabajando = $x['status_trabajando'];
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $sEP = $x['status_ep'];

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
                }
                if ($sMaterial > 0) {
                    $sMaterialx = 1;
                }
                if ($sTrabajando > 0) {
                    $sTrabajandox = 1;
                }
                if ($sEnergetico > 0) {
                    $sEnergeticox = 1;
                }
                if ($sDepartamento > 0) {
                    $sDepartamentox = 1;
                }

                #Obtiene el Responsable Asignado
                $nombreResponsable = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id IN ($idResponsable)
                ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $nombreResponsable = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #Comentarios de Planaccion
                $totalComentarios = 0;
                $query = "SELECT count(id) FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $idPlanaccion and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #Adjuntos de Planaccion
                $totalAdjuntos = 0;
                $query = "SELECT count(id) FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idPlanaccion and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                #Planaccion Actividades
                $subTareas = 0;
                $query = "SELECT count(id) FROM t_proyectos_planaccion_actividades WHERE id_planaccion = $idPlanaccion and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $subTareas = $x['count(id)'];
                    }
                }

                $array[] = array(
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
                    "materiales" => intval($sMaterialx),
                    "energeticos" => intval($sEnergeticox),
                    "departamentos" => intval($sDepartamentox),
                    "trabajando" => intval($sTrabajandox),
                    "sEP" => intval($sEP)
                );
            }
        }
        echo json_encode($array);
    }


    #OBTIENE NOMBRE DE LA SUBSECCIÓN
    if ($action == "obtenerSubseccion") {
        $idSubseccion = $_GET['idSubseccion'];
        $array = array();

        $query = "SELECT grupo FROM c_subsecciones WHERE id = $idSubseccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            $subseccion = '';
            foreach ($result as $x) {
                $subseccion = $x['grupo'];
            }
            $array['subseccion'] = $subseccion;
        }

        echo json_encode($array);
    }


    #OBTIENE LOS PROYECTOS SEGÚN LA SECCIÓN Y DESTINO
    if ($action == "consultaProyectosDEP") {
        $idSubseccion = $_GET['idSubseccion'];
        $status = $_GET['status'];
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_proyectos.id_destino = $idDestino";
        }

        if ($status == "PENDIENTE") {
            $filtroStatus = "and (t_proyectos.status = 'N' or t_proyectos.status = 'PENDIENTE' or t_proyectos.status = '')";
        } else {
            $filtroStatus = "and (t_proyectos.status = 'F' or t_proyectos.status = 'SOLUCIONADO' or t_proyectos.status = 'FINALIZADO')";
        }

        $query = "SELECT t_proyectos.id, t_proyectos.titulo, t_proyectos.rango_fecha, 
        t_proyectos.responsable, t_proyectos.fecha_creacion, t_proyectos.justificacion, t_proyectos.coste, t_proyectos.presupuesto, c_destinos.destino, t_colaboradores.nombre, t_colaboradores.apellido, 
        t_proyectos.tipo, t_proyectos.status
        FROM t_proyectos
        LEFT JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
        LEFT JOIN t_users ON t_proyectos.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos.activo = 1 and t_proyectos.id_subseccion = $idSubseccion
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
                $presupuesto = $p['presupuesto'];
                $tipo = $p['tipo'];
                $status = $p['status'];

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
                        }
                        if ($sMaterial > 0) {
                            $sMaterialx = 1;
                        }
                        if ($sTrabajando > 0) {
                            $sTrabajandox = 1;
                        }
                        if ($sEnergetico > 0) {
                            $sEnergeticox = 1;
                        }
                        if ($sDepartamento >= 1) {
                            $sDepartamentox = 1;
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
                    "presupuesto" => $presupuesto,
                    "status" => $status,
                    "materiales" => intval($sMaterialx),
                    "energeticos" => intval($sEnergeticox),
                    "departamento" => intval($sDepartamentox),
                    "trabajando" => intval($sTrabajandox)
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    #OBTIENE LOS PLANES DE ACCIÓN POR PROYECTO
    if ($action == "obtenerPlanaccionDEP") {
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
        WHERE t_proyectos_planaccion.id_proyecto = $idProyecto and t_proyectos_planaccion.activo = 1 ORDER BY t_proyectos_planaccion.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {

                // Valor Inicial STATUS 
                $sMaterialx = 0;
                $sEnergeticox = 0;
                $sDepartamentox = 0;
                $sTrabajandox = 0;
                // Valor Inicial STATUS 

                $idPlanaccion = $x['id'];
                $actividad = $x['actividad'];
                $creadoPor = $x['nombre'] . " " . $x['apellido'];
                $idResponsable = $x['responsable'];
                $coste = $x['coste'];
                $justificacion = $x['justificacion'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('d/m/Y');
                $destino = $x['destino'];
                $status = $x['status'];
                $sUrgente = $x['status_urgente'];
                $sMaterial = $x['status_material'];
                $sTrabajando = $x['status_trabajando'];
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);

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
                }
                if ($sMaterial > 0) {
                    $sMaterialx = 1;
                }
                if ($sTrabajando > 0) {
                    $sTrabajandox = 1;
                }
                if ($sEnergetico > 0) {
                    $sEnergeticox = 1;
                }
                if ($sDepartamento > 0) {
                    $sDepartamentox = 1;
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
                $query = "SELECT count(id) FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idPlanaccion and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $totalAdjuntos = 0;
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                #Planaccion Actividades
                $query = "SELECT count(id) FROM t_proyectos_planaccion_actividades WHERE id_planaccion = $idPlanaccion and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $subTareas = 0;
                    foreach ($result as $x) {
                        $subTareas = intval($x['count(id)']);
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
                    "materiales" => intval($sMaterialx),
                    "energeticos" => intval($sEnergeticox),
                    "departamentos" => intval($sDepartamentox),
                    "trabajando" => intval($sTrabajandox)
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    #OBTIENE LAS ACTIVIDADES
    if ($action == "obtenerActividadesPlanaccion") {
        $idPlanaccion = $_GET['idPlanaccion'];
        $array = array();
        $query = "SELECT id, actividad, status FROM t_proyectos_planaccion_actividades WHERE id_planaccion = $idPlanaccion and activo = 1 ORDER BY id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $actividad = $i['actividad'];
                $status = $i['status'];
                $arrayTemp = array("id" => $id, "actividad" => $actividad, "status" => $status);
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    #AGREGA ACTIVDAD PARA PLANACCIÓN
    if ($action == "agregarActividadPlanaccion") {
        $idPlanaccion = $_GET['idPlanaccion'];
        $actividad = $_GET['actividad'];
        $array = array();
        $array['respuesta'] = "Error";

        $query = "INSERT INTO t_proyectos_planaccion_actividades (id_planaccion, actividad) VALUES ($idPlanaccion, '$actividad')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo json_encode($array['respuesta'] = "Agregado");
        }
    }


    #ACTUALIZA ACTIVIDAD DE PLAN DE ACCIÓN
    if ($action == "actualizarActividadPlanaccion") {
        $idActividad = $_GET['idActividad'];
        $parametro = $_GET['parametro'];
        $columna = $_GET['columna'];
        $array = array();
        $array['resp'] = "ERROR";

        $query = "SELECT id, status FROM t_proyectos_planaccion_actividades WHERE id = $idActividad and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $status = $x['status'];
            }

            if ($columna == "STATUS") {

                if ($status == "PENDIENTE" || $status == "N") {
                    $parametro = "SOLUCIONADO";
                } else {
                    $parametro = "PENDIENTE";
                }

                $query = "UPDATE t_proyectos_planaccion_actividades SET status = '$parametro' WHERE id = $idActividad";
                $array[] = $query;
                if ($result = mysqli_query($conn_2020, $query)) {
                    $array['resp'] = $parametro;
                }
            } elseif ($columna == "ACTIVO") {
                $query = "UPDATE t_proyectos_planaccion_actividades SET activo = '$parametro' WHERE id = $idActividad";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $array['resp'] = "ELIMINADO";
                }
            } elseif ($columna == "ACTIVIDAD") {
                $query = "UPDATE t_proyectos_planaccion_actividades SET actividad = '$parametro' WHERE id = $idActividad";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $array['resp'] = "TITULO";
                }
            }
        }
        echo json_encode($array);
    }


    #OBTIENE PROYECTOS, TAREAS, FALLAS, PREVENTIVOS, MARCADOS SEGÚN LA ETIQUETA(MATERIALES, FINANZAS, DIRECCIÓN)
    if ($action == "obtenerMarcados") {
        $idSubseccion = $_GET['idSubseccion'];
        $status = $_GET['status'];
        $array = array();

        if ($idSubseccion == 213) {
            $filtroEtiqueta_FALLAS = "and t_mc.status_material = '1'";
            $filtroEtiqueta_TAREAS = "and t_mp_np.status_material = 1";
            $filtroEtiqueta_PROYECTOS = "and t_proyectos_planaccion.status_material = '1'";
            $filtroEtiqueta_PREVENTIVOS = "and t_mp_planificacion_iniciada.status_material = '1'";
        } elseif ($idSubseccion == 214) {
            $filtroEtiqueta_FALLAS = "and t_mc.departamento_calidad = '1'";
            $filtroEtiqueta_TAREAS = "and t_mp_np.departamento_calidad = '1'";
            $filtroEtiqueta_PROYECTOS = "and t_proyectos_planaccion.departamento_calidad = '1'";
            $filtroEtiqueta_PREVENTIVOS = "and t_mp_planificacion_iniciada.departamento_calidad = '1'";
        } elseif ($idSubseccion == 211) {
            $filtroEtiqueta_FALLAS = "and t_mc.departamento_finanzas = '1'";
            $filtroEtiqueta_TAREAS = "and t_mp_np.departamento_finanzas = 1";
            $filtroEtiqueta_PROYECTOS = "and t_proyectos_planaccion.departamento_finanzas = 1";
            $filtroEtiqueta_PREVENTIVOS = "and t_mp_planificacion_iniciada.departamento_finanzas = 1";
        } else {
            $filtroEtiqueta_FALLAS = "and t_mc.id = 0";
            $filtroEtiqueta_TAREAS = "and t_mp_np.id = 0";
            $filtroEtiqueta_PROYECTOS = "and t_proyectos_planaccion.id = 0";
            $filtroEtiqueta_PREVENTIVOS = "and t_mp_planificacion_iniciada.id = 0";
        }

        if ($idDestino == 10) {
            $filtroDestino_PROYECTOS = "";
            $filtroDestino_FALLAS = "";
            $filtroDestino_TAREAS = "";
            $filtroDestino_PREVENTIVOS = "";
        } else {
            $filtroDestino_PROYECTOS = "and t_proyectos.id_destino = $idDestino";
            $filtroDestino_FALLAS = "and t_mc.id_destino = $idDestino";
            $filtroDestino_TAREAS = "and t_mp_np.id_destino = $idDestino";
            $filtroDestino_PREVENTIVOS = "and t_equipos_america.id_destino = $idDestino";
        }

        if ($status == "PENDIENTE") {
            $filtroStatus_FALLAS = "and (t_mc.status = 'P' or t_mc.status = 'N' or t_mc.status = 'PENDIENTE')";
            $filtroStatus_TAREAS = "and (t_mp_np.status = 'P' or t_mp_np.status = 'N' or t_mp_np.status = 'PENDIENTE')";
            $filtroStatus_PROYECTOS = "and (t_proyectos_planaccion.status = 'P' or t_proyectos_planaccion.status = 'N' or t_proyectos_planaccion.status = 'PENDIENTE')";
            $filtroStatus_PREVENTIVOS = "and (t_mp_planificacion_iniciada.status = 'P' or t_mp_planificacion_iniciada.status = 'N' or t_mp_planificacion_iniciada.status = 'PENDIENTE')";
        } else {
            $filtroStatus_FALLAS = "and (t_mc.status = 'F' or t_mc.status = 'SOLUCIONADO')";
            $filtroStatus_TAREAS = "and (t_mp_np.status = 'F' or t_mp_np.status = 'SOLUCIONADO')";
            $filtroStatus_PROYECTOS = "and (t_proyectos_planaccion.status = 'F' or t_proyectos_planaccion.status = 'SOLUCIONADO')";
            $filtroStatus_PREVENTIVOS = "and (t_mp_planificacion_iniciada.status = 'F' or t_mp_planificacion_iniciada.status = 'SOLUCIONADO')";
        }


        #FALLAS
        $FALLAS = "SELECT t_mc.id, t_mc.rango_fecha, t_mc.fecha_creacion, t_mc.actividad, 
        t_mc.responsable, t_mc.status, t_mc.status_material, t_mc.status_trabajare, t_mc.status_urgente, t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.departamento_direccion, t_mc.departamento_finanzas, t_mc.departamento_rrhh, t_mc.energetico_electricidad, t_mc.energetico_agua, t_mc.energetico_diesel, t_mc.energetico_gas, t_colaboradores.nombre, t_colaboradores.apellido, c_secciones.seccion, 
        c_subsecciones.grupo, t_equipos_america.equipo, t_mc.cod2bend, t_mc.codsap,t_mc.codsap
        FROM t_mc 
        INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id
        LEFT JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
        INNER JOIN t_users ON t_mc.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mc.activo = 1 $filtroEtiqueta_FALLAS $filtroDestino_FALLAS $filtroStatus_FALLAS";
        if ($result_FALLAS = mysqli_query($conn_2020, $FALLAS)) {
            foreach ($result_FALLAS as $x) {
                $sMaterialx = 0;
                $sEnergeticox = 0;
                $sDepartamentox = 0;
                $sTrabajandox = 0;

                $idFalla = $x["id"];
                $sMaterial = $x['status_material'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('d/m/Y');
                $status = $x['status'];
                $sUrgente = $x['status_urgente'];
                $sMaterial = $x['status_material'];
                $sTrabajando = $x['status_trabajare'];
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $equipo = $x['equipo'];
                $descripcion = $x['actividad'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $idResponsable = $x['responsable'];
                $cod2bend = $x['cod2bend'];
                $codsap = $x['codsap'];

                #Status (Trabajando, Departamentos, Energeticos, Material)
                if ($sUrgente > 0) {
                    $sUrgentex = 1;
                }
                if ($sMaterial > 0) {
                    $sMaterialx = 1;
                }
                if ($sTrabajando > 0) {
                    $sTrabajandox = 1;
                }
                if ($sEnergetico > 0) {
                    $sEnergeticox = 1;
                }
                if ($sDepartamento > 0) {
                    $sDepartamentox = 1;
                }
                if ($status == "N" or $status == "PENDIENTE") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                #EQUIPO
                if ($equipo == "" or $equipo == NULL) {
                    $equipo = "";
                }

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

                #RESPONSE
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                $responsable = '';
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable
                            = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #COMENTARIOS
                $query = "SELECT count(id) FROM t_mc_comentarios WHERE id_mc = $idFalla and activo = 1";
                $totalComentarios = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #ADJUNTOS
                $query = "SELECT count(id) FROM t_mc_adjuntos WHERE id_mc = $idFalla and activo = 1";
                $totalAdjuntos = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }


                $arrayTemp = array(
                    "id" => $idFalla,
                    "seccion" => $seccion,
                    "subseccion" => $subseccion,
                    "equipo" => $equipo,
                    "descripcion" => $descripcion,
                    "creadoPor" => $creadoPor,
                    "origen" => "FALLA",
                    "responsable" => $responsable,
                    "fechaInicio" => $fechaInicio,
                    "fechaFin" => $fechaFin,
                    "comentarios" => $totalComentarios,
                    "adjuntos" => $totalAdjuntos,
                    "energeticos" => $sEnergeticox,
                    "materiales" => $sMaterialx,
                    "departamentos" => $sDepartamentox,
                    "trabajando" => $sTrabajandox,
                    "status" => $status,
                    "cod2bend" => $cod2bend,
                    "codsap" => $codsap,
                    "ot" => "F-$idFalla"
                );

                $array[] = $arrayTemp;
            }
        }


        #TAREAS
        $TAREAS = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.rango_fecha, t_mp_np.fecha, t_mp_np.cod2bend, t_mp_np.codsap, t_equipos_america.equipo, t_mp_np.status, t_mp_np.responsable,
        t_mp_np.status_material, t_mp_np.status_trabajando, t_mp_np.status_urgente, 
        t_mp_np.departamento_calidad, t_mp_np.departamento_compras, t_mp_np.departamento_direccion, t_mp_np.departamento_finanzas, t_mp_np.departamento_rrhh, t_mp_np.energetico_electricidad, t_mp_np.energetico_agua, t_mp_np.energetico_diesel, t_mp_np.energetico_gas,
        c_secciones.seccion, c_subsecciones.grupo, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_mp_np
        LEFT JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
        INNER JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        LEFT JOIN t_users ON t_mp_np.id_usuario = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mp_np.activo = 1 $filtroDestino_TAREAS $filtroEtiqueta_TAREAS $filtroStatus_TAREAS";
        if ($result_TAREAS = mysqli_query($conn_2020, $TAREAS)) {
            foreach ($result_TAREAS as $x) {
                $sMaterialx = 0;
                $sEnergeticox = 0;
                $sDepartamentox = 0;
                $sTrabajandox = 0;

                $idTarea = $x['id'];
                $sMaterial = $x['status_material'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha']))->format('d/m/Y');
                $status = $x['status'];
                $sUrgente = $x['status_urgente'];
                $sMaterial = $x['status_material'];
                $sTrabajando = $x['status_trabajando'];
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $equipo = $x['equipo'];
                $descripcion = $x['titulo'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $idResponsable = $x['responsable'];
                $cod2bend = $x['cod2bend'];
                $codsap = $x['codsap'];

                #Status (Trabajando, Departamentos, Energeticos, Material)
                if ($sUrgente > 0) {
                    $sUrgentex = 1;
                }
                if ($sMaterial > 0) {
                    $sMaterialx = 1;
                }
                if ($sTrabajando > 0) {
                    $sTrabajandox = 1;
                }
                if ($sEnergetico > 0) {
                    $sEnergeticox = 1;
                }
                if ($sDepartamento > 0) {
                    $sDepartamentox = 1;
                }
                if ($status == "P" or $status == "N" or $status == "PENDIENTE") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                #EQUIPO
                if ($equipo == "" or $equipo == NULL) {
                    $equipo = "";
                }

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

                #RESPONSE
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                $responsable = '';
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable
                            = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #COMENTARIOS
                $query = "SELECT count(id) FROM comentarios_mp_np WHERE id_mp_np = $idTarea and activo = 1";
                $totalComentarios = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #ADJUNTOS
                $query = "SELECT count(id) FROM adjuntos_mp_np WHERE id_mp_np = $idTarea and activo = 1";
                $totalAdjuntos = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }
                $arrayTemp = array(
                    "id" => $idTarea,
                    "seccion" => $seccion,
                    "subseccion" => $subseccion,
                    "equipo" => $equipo,
                    "descripcion" => $descripcion,
                    "creadoPor" => $creadoPor,
                    "origen" => "TAREA",
                    "responsable" => $responsable,
                    "fechaInicio" => $fechaInicio,
                    "fechaFin" => $fechaFin,
                    "comentarios" => $totalComentarios,
                    "adjuntos" => $totalAdjuntos,
                    "energeticos" => $sEnergeticox,
                    "materiales" => $sMaterialx,
                    "departamentos" => $sDepartamentox,
                    "trabajando" => $sTrabajandox,
                    "status" => $status,
                    "cod2bend" => $cod2bend,
                    "codsap" => $codsap,
                    "ot" => "T-$idTarea"
                );

                $array[] = $arrayTemp;
            }
        }


        #PROYECTOS
        $PROYECTOS = "SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.rango_fecha, t_proyectos_planaccion.fecha_creacion, t_proyectos_planaccion.cod2bend, t_proyectos_planaccion.codsap, t_proyectos.titulo, t_proyectos_planaccion.status, 
        t_proyectos_planaccion.responsable, t_proyectos_planaccion.status_material, t_proyectos_planaccion.status_trabajando, t_proyectos_planaccion.status_urgente, 
        t_proyectos_planaccion.departamento_calidad, t_proyectos_planaccion.departamento_compras, t_proyectos_planaccion.departamento_direccion, t_proyectos_planaccion.departamento_finanzas, t_proyectos_planaccion.departamento_rrhh, t_proyectos_planaccion.energetico_electricidad, t_proyectos_planaccion.energetico_agua, t_proyectos_planaccion.energetico_diesel, t_proyectos_planaccion.energetico_gas,
        c_secciones.seccion, c_subsecciones.grupo, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_proyectos_planaccion
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id
        INNER JOIN c_secciones ON t_proyectos.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_proyectos.id_subseccion = c_subsecciones.id
        INNER JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos_planaccion.activo = 1 $filtroDestino_PROYECTOS $filtroEtiqueta_PROYECTOS $filtroStatus_PROYECTOS";
        if ($result_PROYECTOS = mysqli_query($conn_2020, $PROYECTOS)) {
            foreach ($result_PROYECTOS as $x) {
                $sMaterialx = 0;
                $sEnergeticox = 0;
                $sDepartamentox = 0;
                $sTrabajandox = 0;

                $idPlanaccion = $x['id'];
                $sMaterial = $x['status_material'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('d/m/Y');
                $status = $x['status'];
                $sUrgente = $x['status_urgente'];
                $sMaterial = $x['status_material'];
                $sTrabajando = $x['status_trabajando'];
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $equipo = $x['titulo'];
                $descripcion = $x['actividad'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $idResponsable = $x['responsable'];
                $cod2bend = $x['cod2bend'];
                $codsap = $x['codsap'];

                #Status (Trabajando, Departamentos, Energeticos, Material)
                if ($sUrgente > 0) {
                    $sUrgentex = 1;
                }
                if ($sMaterial > 0) {
                    $sMaterialx = 1;
                }
                if ($sTrabajando > 0) {
                    $sTrabajandox = 1;
                }
                if ($sEnergetico > 0) {
                    $sEnergeticox = 1;
                }
                if ($sDepartamento > 0) {
                    $sDepartamentox = 1;
                }
                if ($status == "N" or $status == "PENDIENTE") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                #EQUIPO
                if ($equipo == "" or $equipo == NULL) {
                    $equipo = "";
                }

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

                #RESPONSE
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                $responsable = '';
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable
                            = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #COMENTARIOS
                $query = "SELECT count(id) FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $idPlanaccion and activo = 1";
                $totalComentarios = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #ADJUNTOS
                $query = "SELECT count(id) FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idPlanaccion and status = 1";
                $totalAdjuntos = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }
                $arrayTemp = array(
                    "id" => $idPlanaccion,
                    "seccion" => $seccion,
                    "subseccion" => $subseccion,
                    "equipo" => $equipo,
                    "descripcion" => $descripcion,
                    "creadoPor" => $creadoPor,
                    "origen" => "PROYECTO",
                    "responsable" => $responsable,
                    "fechaInicio" => $fechaInicio,
                    "fechaFin" => $fechaFin,
                    "comentarios" => $totalComentarios,
                    "adjuntos" => $totalAdjuntos,
                    "energeticos" => $sEnergeticox,
                    "materiales" => $sMaterialx,
                    "departamentos" => $sDepartamentox,
                    "trabajando" => $sTrabajandox,
                    "status" => $status,
                    "cod2bend" => $cod2bend,
                    "codsap" => $codsap,
                    "ot" => "P-$idPlanaccion"
                );

                $array[] = $arrayTemp;
            }
        }


        #PREVENTIVOS
        $PREVENTIVOS = "SELECT t_mp_planificacion_iniciada.id, 
        t_mp_planes_mantenimiento.tipo_plan, t_mp_planes_mantenimiento.grado, t_mp_planificacion_iniciada.rango_fecha, t_mp_planificacion_iniciada.fecha_creacion, t_mp_planificacion_iniciada.cod2bend, t_mp_planificacion_iniciada.codsap, 
        t_equipos_america.equipo, t_mp_planificacion_iniciada.status, 
        t_mp_planificacion_iniciada.id_responsables, t_mp_planificacion_iniciada.status_material, t_mp_planificacion_iniciada.status_trabajando, t_mp_planificacion_iniciada.status_urgente, 
        t_mp_planificacion_iniciada.departamento_calidad, t_mp_planificacion_iniciada.departamento_compras, t_mp_planificacion_iniciada.departamento_direccion, t_mp_planificacion_iniciada.departamento_finanzas, t_mp_planificacion_iniciada.departamento_rrhh, t_mp_planificacion_iniciada.energetico_electricidad, t_mp_planificacion_iniciada.energetico_agua, t_mp_planificacion_iniciada.energetico_diesel, t_mp_planificacion_iniciada.energetico_gas,
        c_secciones.seccion, c_subsecciones.grupo, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        INNER JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        INNER JOIN t_users ON t_mp_planificacion_iniciada.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN t_mp_planes_mantenimiento 
            ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
        WHERE t_mp_planificacion_iniciada.activo = 1 $filtroDestino_PREVENTIVOS $filtroEtiqueta_PREVENTIVOS $filtroStatus_PREVENTIVOS";
        if ($result_PROYECTOS = mysqli_query($conn_2020, $PREVENTIVOS)) {
            foreach ($result_PROYECTOS as $x) {
                $sMaterialx = 0;
                $sEnergeticox = 0;
                $sDepartamentox = 0;
                $sTrabajandox = 0;

                $idPreventivo = $x['id'];
                $sMaterial = $x['status_material'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('d/m/Y');
                $status = $x['status'];
                $sUrgente = $x['status_urgente'];
                $sMaterial = $x['status_material'];
                $sTrabajando = $x['status_trabajando'];
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $equipo = $x['equipo'];
                $descripcion = $x['tipo_plan'] . " " . $x['grado'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $idResponsable = $x['id_responsables'];
                $cod2bend = $x['cod2bend'];
                $codsap = $x['codsap'];

                #Status (Trabajando, Departamentos, Energeticos, Material)
                if ($sUrgente > 0) {
                    $sUrgentex = 1;
                }
                if ($sMaterial > 0) {
                    $sMaterialx = 1;
                }
                if ($sTrabajando > 0) {
                    $sTrabajandox = 1;
                }
                if ($sEnergetico > 0) {
                    $sEnergeticox = 1;
                }
                if ($sDepartamento > 0) {
                    $sDepartamentox = 1;
                }
                if ($status == "N" or $status == "PENDIENTE") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                #EQUIPO
                if ($equipo == "" or $equipo == NULL) {
                    $equipo = "";
                }

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

                #RESPONSABLE
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id IN ($idResponsable)";
                $responsable = '';
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable
                            = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #COMENTARIOS
                $query = "SELECT count(id) FROM t_mp_planificacion_iniciada 
                WHERE id = $idPreventivo and comentario != ''";
                $totalComentarios = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #ADJUNTOS
                $query = "SELECT count(id) FROM t_mp_planificacion_iniciada_adjuntos 
                WHERE id_planificacion_iniciada = $idPreventivo and activo = 1";
                $totalAdjuntos = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                $arrayTemp = array(
                    "id" => $idPreventivo,
                    "seccion" => $seccion,
                    "subseccion" => $subseccion,
                    "equipo" => $equipo,
                    "descripcion" => $descripcion,
                    "creadoPor" => $creadoPor,
                    "origen" => "PREVENTIVO",
                    "responsable" => $responsable,
                    "fechaInicio" => $fechaInicio,
                    "fechaFin" => $fechaFin,
                    "comentarios" => $totalComentarios,
                    "adjuntos" => $totalAdjuntos,
                    "energeticos" => $sEnergeticox,
                    "materiales" => $sMaterialx,
                    "departamentos" => $sDepartamentox,
                    "trabajando" => $sTrabajandox,
                    "status" => $status,
                    "cod2bend" => $cod2bend,
                    "codsap" => $codsap,
                    "ot" => "MP-$idPreventivo"
                );

                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    #OBTEIENES TODOS LOS PROYECTOS POR DESTINOS
    if ($action == "obtenerProyectosGlobal") {
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
        t_proyectos.responsable, t_proyectos.fecha_creacion, t_proyectos.justificacion, t_proyectos.status_i, t_proyectos.status_ap, t_proyectos.coste, t_proyectos.presupuesto, c_destinos.destino, t_colaboradores.nombre, t_colaboradores.apellido, 
        t_proyectos.tipo, c_secciones.seccion
        FROM t_proyectos 
        INNER JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_proyectos.id_seccion = c_secciones.id
        LEFT JOIN t_users ON t_proyectos.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos.activo = 1 $filtroDestino  $filtroStatus ORDER BY t_proyectos.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idProyecto = $x['id'];
                $creadoPor = $x['nombre'] . " " . $x['apellido'];
                $destino = $x['destino'];
                $seccion = $x['seccion'];
                $titulo = $x['titulo'];
                $idResponsable = $x['responsable'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('d/m/Y');
                $año = (new DateTime($x['fecha_creacion']))->format('Y');
                $justificacion = $x['justificacion'];
                $coste = $x['coste'];
                $presupuesto = $x['presupuesto'];
                $tipo = $x['tipo'];
                $sI = $x['status_i'];
                $sAP = $x['status_ap'];

                #Rango Fecha
                if ($rangoFecha != "") {
                    $rangoFecha = explode(" - ", $rangoFecha);
                    if (isset($rangoFecha[0])) {
                        $fechaInicio = $rangoFecha[0];
                        $año = $fechaInicio[6] . $fechaInicio[7] . $fechaInicio[8] . $fechaInicio[9];
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
                $totalActividadesCreadas = 0;
                $totalActividadesSolucionadas = 0;
                $pda = "";
                $query = "SELECT id, status FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
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
                $nombreResponsable = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable
                ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $nombreResponsable = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #Comentarios de Proyecto
                $totalComentarios = 0;
                $query = "SELECT count(id) FROM t_proyectos_comentarios WHERE id_proyecto = $idProyecto and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #Adjuntos de Proyecto
                $totalAdjuntos = 0;
                $query = "SELECT count(id) FROM t_proyectos_adjuntos WHERE id_proyecto = $idProyecto and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = intval($x['count(id)']);
                    }
                }

                #Adjuntos Catálogo de Conceptos
                $query = "SELECT count(id) FROM t_proyectos_catalogo_conceptos 
                WHERE id_proyecto = $idProyecto and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $totalAdjuntos + intval($x['count(id)']);
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
                        }
                        if ($sMaterial > 0) {
                            $sMaterialx = 1;
                        }
                        if ($sTrabajando > 0) {
                            $sTrabajandox = 1;
                        }
                        if ($sEnergetico > 0) {
                            $sEnergeticox = 1;
                        }
                        if ($sDepartamento >= 1) {
                            $sDepartamentox = 1;
                        }
                    }
                }

                $arrayTemp = array(
                    "id" => $idProyecto,
                    "destino" => $destino,
                    "seccion" => $seccion,
                    "proyecto" => $titulo,
                    "creadoPor" => $creadoPor,
                    "pda" => $pda,
                    "responsable" => $nombreResponsable,
                    "fechaInicio" => $fechaInicio, "fechaFin" => $fechaFin,
                    "año" => $año,
                    "cotizaciones" => $totalAdjuntos,
                    "tipo" => $tipo,
                    "justificacion" => $justificacion,
                    "comentarios" => $totalComentarios,
                    "coste" => $coste,
                    "presupuesto" => $presupuesto,
                    "status" => $status,
                    "materiales" => intval($sMaterialx),
                    "energeticos" => intval($sEnergeticox),
                    "departamento" => intval($sDepartamentox),
                    "trabajando" => intval($sTrabajandox),
                    "sI" => intval($sI),
                    "sAP" => intval($sAP),
                );
                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    #OBTENER DATOS DE PROYECTO POR ID
    if ($action == "obtenerProyectoPorID") {
        $idProyecto = $_GET['idProyecto'];
        $array = array();

        $query = "SELECT id, titulo, justificacion, fecha_creacion, rango_fecha, status, tipo, coste, presupuesto, año FROM t_proyectos WHERE id = $idProyecto";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idProyecto = $x['id'];
                $titulo = $x['titulo'];
                $justificacion = $x['justificacion'];
                $fechaCreacion = $x['fecha_creacion'];
                $rangoFecha = $x['rango_fecha'];
                $status = $x['status'];
                $tipo = $x['tipo'];
                $coste = $x['coste'];
                $presupuesto = $x['presupuesto'];
                $año = $x['año'];

                $array[] = array(
                    "idProyecto" => intval($idProyecto),
                    "titulo" => $titulo,
                    "justificacion" => $justificacion,
                    "fechaCreacion" => $fechaCreacion,
                    "rangoFecha" => $rangoFecha,
                    "status" => $status,
                    "tipo" => $tipo,
                    "coste" => $coste,
                    "presupuesto" => $presupuesto,
                    "año" => $año
                );
            }
        }
        echo json_encode($array);
    }
    // CIERRE FINAL
}
