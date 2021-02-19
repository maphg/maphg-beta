<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';

if (isset($_GET['action'])) {

    $APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');

    if ($action == "obtenerReporte") {

        $filtroPalabra = $_POST['filtroPalabra'];
        $filtroResponsable = $_POST['filtroResponsable'];
        $filtroSeccion = $_POST['filtroSeccion'];
        $filtroSubseccion = $_POST['filtroSubseccion'];
        $filtroTipo = $_POST['filtroTipo'];
        $filtroTipoIncidencia = $_POST['filtroTipoIncidencia'];
        $filtroStatus = $_POST['filtroStatus'];
        $filtroFecha = $_POST['filtroFecha'];
        $filtroFechaInicio = $_POST['filtroFechaInicio'];
        $filtroFechaFin = $_POST['filtroFechaFin'];
        $array = array();

        #FILTRO DESTINO
        if ($idDestino == 10) {
            $filtroDestino = "";
            $filtroDestino_General = "";
            $filtroDestino_Preventivo = "";
            $filtroDestino_Proyecto = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
            $filtroDestino_General = "and id_destino = $idDestino";
            $filtroDestino_Preventivo = "and t_equipos_america.id_destino = $idDestino";
            $filtroDestino_Proyecto = "and t_proyectos.id_destino = $idDestino";
        }

        #FILTRO PALABRA
        if ($filtroPalabra == "" and $filtroPalabra == " ") {
            $filtroPalabraIncidencias = "";
            $filtroPalabra_General = "";
            $filtroPalabra_Preventivo = "";
            $filtroPalabra_Proyecto = "";
        } else {
            $filtroPalabraIncidencias = "and actividad LIKE '%$filtroPalabra%'";
            $filtroPalabra_General = "and titulo LIKE '%$filtroPalabra%'";
            $filtroPalabra_Preventivo = "and t_mp_planificacion_iniciada.comentario LIKE '%$filtroPalabra%'";
            $filtroPalabra_Proyecto = "and t_proyectos_planaccion.actividad LIKE '%$filtroPalabra%'";
        }

        #FILTRO RESPONSABLE
        if ($filtroResponsable <= 0) {
            $filtroResponsableIncidencias = "";
            $filtroResponsable_General = "";
            $filtroResponsable_Preventivo = "";
            $filtroResponsable_Proyecto = "";
        } else {
            $filtroResponsableIncidencias = "and responsable IN($filtroResponsable)";
            $filtroResponsable_General = "and responsable IN($filtroResponsable)";
            $filtroResponsable_Preventivo = "and t_mp_planificacion_iniciada.id_responsables IN($filtroResponsable)";
            $filtroResponsable_Proyecto = "and t_proyectos_planaccion.responsable IN($filtroResponsable)";
        }

        #FILTRO SECCION
        if ($filtroSeccion <= 0) {
            $filtroSeccionIncidencias = "";
            $filtroSeccion_General = "";
            $filtroSeccion_Preventivo = "";
            $filtroSeccion_Proyecto = "";
        } else {
            $filtroSeccionIncidencias = "and id_seccion = $filtroSeccion";
            $filtroSeccion_General = "and id_seccion = $filtroSeccion";
            $filtroSeccion_Preventivo = "and t_equipos_america.id_seccion = $filtroSeccion";
            $filtroSeccion_Proyecto = "and t_proyectos.id_seccion = $filtroSeccion";
        }

        #FILTRO SUBSECCION
        if ($filtroSubseccion == 0) {
            $filtroSubseccionIncidencias = "";
            $filtroSubseccion_General = "";
            $filtroSubseccion_Preventivo = "";
            $filtroSubseccion_Proyecto = "";
        } else {
            $filtroSubseccionIncidencias = "and id_subseccion = $filtroSubseccion";
            $filtroSubseccion_General = "and id_subseccion = $filtroSubseccion";
            $filtroSubseccion_Preventivo = "and t_equipos_america.id_subseccion = $filtroSubseccion";
            $filtroSubseccion_Proyecto = "and t_proyectos.id_subseccion = $filtroSubseccion";
        }

        #FILTRO TIPO INCIDENCIA (EMERGENCIA, URGENCIA, ALARMA, ALERTA, SEGUIMIENTO)
        if ($filtroTipoIncidencia == "TODOS") {
            $filtroTipoIncidenciaIncidencias = "";
            $filtroTipoIncidencia_General = "";
            $filtroTipoIncidencia_Preventivo = "";
            $filtroTipoIncidencia_Proyecto = "";
        } elseif ($filtroTipoIncidencia == "EMERGENCIA") {
            $filtroTipoIncidenciaIncidencias = "and tipo_incidencia = 'EMERGENCIA'";
            $filtroTipoIncidencia_General = "and tipo_incidencia = 'EMERGENCIA'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipoIncidencia == "URGENCIA") {
            $filtroTipoIncidenciaIncidencias = "and tipo_incidencia = 'URGENCIA'";
            $filtroTipoIncidencia_General = "and tipo_incidencia = 'URGENCIA'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipoIncidencia == "ALARMA") {
            $filtroTipoIncidenciaIncidencias = "and tipo_incidencia = 'ALARMA'";
            $filtroTipoIncidencia_General = "and tipo_incidencia = 'ALARMA'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipoIncidencia == "ALERTA") {
            $filtroTipoIncidenciaIncidencias = "and tipo_incidencia = 'ALERTA'";
            $filtroTipoIncidencia_General = "and tipo_incidencia = 'ALERTA'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipoIncidencia == "SEGUIMIENTO") {
            $filtroTipoIncidenciaIncidencias = "and tipo_incidencia = 'SEGUIMIENTO'";
            $filtroTipoIncidencia_General = "and tipo_incidencia = 'SEGUIMIENTO'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } else {
            $filtroTipoIncidenciaIncidencias = "and tipo_incidencia = 'ND'";
            $filtroTipoIncidencia_General = "and tipo_incidencia = 'ND'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        }

        #FILTRO TIPO (INCIDENCIAS, INCIDENCIA GENERALES, PREVENTIVOS, PROYECTOS->PLANACCION)
        if ($filtroTipo == "TODOS") {
            $filtroTipoIncidencias = "";
            $filtroTipo_General = "";
            $filtroTipo_Preventivo = "";
            $filtroTipo_Proyecto = "";
        } elseif ($filtroTipo == "INCIDENCIAS") {
            $filtroTipoIncidencias = "";
            $filtroTipo_General = "";
            $filtroTipo_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipo_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipo == "PREVENTIVOS") {
            $filtroTipoIncidencias = "and id = 0";
            $filtroTipo_General = "and id = 0";
            $filtroTipo_Preventivo = "";
            $filtroTipo_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipo == "PROYECTOS") {
            $filtroTipoIncidencias = "and id = 0";
            $filtroTipo_General = "and id = 0";
            $filtroTipo_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipo_Proyecto = "";
        } else {
            $filtroTipoIncidencias = "and id_destino = 0";
            $filtroTipo_General = "and id_destino = 0";
            $filtroTipo_Preventivo = "and id_destino = 0";
            $filtroTipo_Proyecto = "and id_destino = 0";
        }

        #FILTRO STATUS
        if ($filtroStatus == "TODOS") {
            $filtroStatusIncidencias = "";
            $filtroStatus_General = "";
            $filtroStatus_Preventivo = "";
            $filtroStatus_Proyecto = "";
        } else {
            if ($filtroStatus == "MATERIAL") {
                $filtroStatusIncidencias = "and status_material = 1";
                $filtroStatus_General = "and status_material = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.status_material = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.status_material = 1";
            } elseif ($filtroStatus == "TRABAJANDO") {
                $filtroStatusIncidencias = "and status_trabajare = 1";
                $filtroStatus_General = "and status_trabajando = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.status_trabajando = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.status_trabajando = 1";
            } elseif ($filtroStatus == "ELECTRICIDAD") {
                $filtroStatusIncidencias = "and energetico_electricidad = 1";
                $filtroStatus_General = "and energetico_electricidad = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.energetico_electricidad = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.energetico_electricidad = 1";
            } elseif ($filtroStatus == "AGUA") {
                $filtroStatusIncidencias = "and energetico_agua = 1";
                $filtroStatus_General = "and energetico_agua = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.energetico_agua = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.energetico_agua = 1";
            } elseif ($filtroStatus == "DIESEL") {
                $filtroStatusIncidencias = "and energetico_diesel = 1";
                $filtroStatus_General = "and energetico_diesel = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.energetico_diesel = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.energetico_diesel = 1";
            } elseif ($filtroStatus == "GAS") {
                $filtroStatusIncidencias = "and energetico_gas = 1";
                $filtroStatus_General = "and energetico_gas = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.energetico_gas = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.energetico_gas = 1";
            } elseif ($filtroStatus == "CALIDAD") {
                $filtroStatusIncidencias = "and departamento_calidad = 1";
                $filtroStatus_General = "and departamento_calidad = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_calidad = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_calidad = 1";
            } elseif ($filtroStatus == "COMPRAS") {
                $filtroStatusIncidencias = "and departamento_compras = 1";
                $filtroStatus_General = "and departamento_compras = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_compras = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_compras = 1";
            } elseif ($filtroStatus == "DIRECCION") {
                $filtroStatusIncidencias = "and departamento_direccion = 1";
                $filtroStatus_General = "and departamento_direccion = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_direccion = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_direccion = 1";
            } elseif ($filtroStatus == "FINANZAS") {
                $filtroStatusIncidencias = "and departamento_finanzas = 1";
                $filtroStatus_General = "and departamento_finanzas = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_finanzas = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_finanzas = 1";
            } elseif ($filtroStatus == "RRHH") {
                $filtroStatusIncidencias = "and departamento_rrhh = 1";
                $filtroStatus_General = "and departamento_rrhh = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_rrhh = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_rrhh = 1";
            } elseif ($filtroStatus == "EP") {
                $filtroStatusIncidencias = "and status_ep = 1";
                $filtroStatus_General = "and status_ep = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.status_ep = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.status_ep = 1";
            } else {
                $filtroStatusIncidencias = "";
                $filtroStatus_General = "";
                $filtroStatus_Preventivo = "";
                $filtroStatus_Proyecto = "";
            }
        }

        #FILTRO FECHA
        if ($filtroFecha == "TODOS") {
            $filtroFechaIncidencias = "";
            $filtroFecha_General = "";
            $filtroFecha_Preventivo = "";
            $filtroFecha_Proyecto = "";
        } elseif ($filtroFecha == "SINPLANIFICAR") {
            $filtroFechaIncidencias = "and rango_fecha = ''";
            $filtroFecha_General = "and rango_fecha = ''";
            $filtroFecha_Preventivo = "and t_mp_planificacion_iniciada.rango_fecha = ''";
            $filtroFecha_Proyecto = "and t_proyectos_planaccion.rango_fecha = ''";
        } elseif ($filtroFecha == "PLANIFICADO") {
            $filtroFechaIncidencias = "and rango_fecha != ''";
            $filtroFecha_General = "and rango_fecha != ''";
            $filtroFecha_Preventivo = "and t_mp_planificacion_iniciada.rango_fecha != ''";
            $filtroFecha_Proyecto = "and t_proyectos_planaccion.rango_fecha != ''";
        } elseif ($filtroFecha == "RANGO") {
            $filtroFechaIncidencias = "and rango_fecha != ''";
            $filtroFecha_General = "and rango_fecha != ''";
            $filtroFecha_Preventivo = "and t_mp_planificacion_iniciada.rango_fecha != ''";
            $filtroFecha_Proyecto = "and t_proyectos_planaccion.rango_fecha != ''";
        } else {
            $filtroFechaIncidencias = "and rango_fecha != ''";
            $filtroFecha_General = "and rango_fecha != ''";
            $filtroFecha_Preventivo = "and t_mp_planificacion_iniciada.rango_fecha != ''";
            $filtroFecha_Proyecto = "and t_proyectos_planaccion.rango_fecha != ''";
        }

        #INCIDENCIAS
        $query = "SELECT id, actividad, status, rango_fecha, tipo_incidencia,
        t_mc.creado_por,
        t_mc.status_material,
        t_mc.status_trabajare,
        t_mc.energetico_electricidad,
        t_mc.energetico_agua,
        t_mc.energetico_diesel,
        t_mc.energetico_gas,
        t_mc.departamento_calidad,
        t_mc.departamento_compras,
        t_mc.departamento_direccion,
        t_mc.departamento_finanzas,
        t_mc.departamento_rrhh,
        t_mc.status_ep
        FROM t_mc 
        WHERE activo = 1 and id_equipo > 0 $filtroDestino $filtroPalabraIncidencias $filtroResponsableIncidencias $filtroSeccionIncidencias $filtroSubseccionIncidencias $filtroTipoIncidenciaIncidencias $filtroTipoIncidencias $filtroStatusIncidencias $filtroFechaIncidencias";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $idCreadoPor = $x['creado_por'];
                $titulo = $x['actividad'];
                $status = $x['status'];
                $rangoFecha = $x['rango_fecha'];
                $tipoIncidencia = $x['tipo_incidencia'];
                $sMaterial = intval($x['status_material']);
                $sTrabajando = intval($x['status_trabajare']);
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $sEP = $x['status_ep'];

                #STATUS
                if ($status == "SOLUCIONADO" || $status == "F" || $status == "FINALIZADO") {
                    $status = "SOLUCIONADO";
                } else {
                    $status = "PENDIENTE";
                }

                #CREADO POR
                $creadoPor = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idCreadoPor";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #ULTIMO COMENTARIO
                $comentario = "";
                $fecha = "";
                $ComentarioDe = "";
                $query = "SELECT t_mc_comentarios.comentario, t_mc_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido
                FROM t_mc_comentarios 
                INNER JOIN t_users ON t_mc_comentarios.id_usuario = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_mc_comentarios.id_mc = $idItem and t_mc_comentarios.activo = 1
                ORDER BY t_mc_comentarios.id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $comentario = $x['comentario'];
                        $fecha = $x['fecha'];
                        $ComentarioDe = strtok($x['apellido'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                $guardar = "SI";
                if ($filtroFecha == "RANGO") {
                    $guardar = "NO";
                    if (strlen($rangoFecha) == 23 and $filtroFechaInicio != "" and $filtroFechaFin != "") {

                        // TRATA LA FECHA SELECCIONADA POR EL USUARIO
                        // $filtroFechaInicio = (new DateTime($filtroFechaInicio))->format('Y-m-d');
                        // $filtroFechaFin = (new DateTime($filtroFechaFin))->format('Y-m-d');

                        // TRATA LA FECHA DEL REGISTRO
                        $rangoFecha = str_replace("/", "-", $rangoFecha);
                        $rangoFecha = explode(" - ", $rangoFecha);
                        $fechaInicio = (new DateTime($rangoFecha[0]))->format('Y-m-d');
                        $fechaFin = (new DateTime($rangoFecha[1]))->format('Y-m-d');

                        if ($fechaInicio >= date('Y-01-04') &&  $fechaInicio <= date('Y-01-05')) {
                            $guardar = "SI";
                        }
                        // if ($fechaFin >= date('Y-01-05') && $fechaFin <= date('Y-01-05')) {
                        //     $guardar = "SI";
                        // }
                    }
                }

                if ($guardar == "SI") {
                    $array[] = array(
                        "idItem" => intval($idItem),
                        "titulo" => $titulo,
                        "creadoPor" => $creadoPor,
                        "status" => $status,
                        "tipo" => "INCIDENCIA",
                        "tipoIncidencia" => $tipoIncidencia,
                        "sMaterial" => $sMaterial,
                        "sTrabajando" => $sTrabajando,
                        "sEnergetico" => $sEnergetico,
                        "sDepartamento" => $sDepartamento,
                        "sEP" => $sEP,
                        "comentario" => $comentario,
                        "comentarioFecha" => $fecha,
                        "ComentarioDe" => $ComentarioDe
                    );
                }
            }
        }

        #GENERAL
        $query = "SELECT id, titulo, status, rango_fecha, tipo_incidencia,
        t_mp_np.id_usuario,
        t_mp_np.status_material,
        t_mp_np.status_trabajando,
        t_mp_np.energetico_electricidad,
        t_mp_np.energetico_agua,
        t_mp_np.energetico_diesel,
        t_mp_np.energetico_gas,
        t_mp_np.departamento_calidad,
        t_mp_np.departamento_compras,
        t_mp_np.departamento_direccion,
        t_mp_np.departamento_finanzas,
        t_mp_np.departamento_rrhh,
        t_mp_np.status_ep
        FROM t_mp_np 
        WHERE activo = 1 and id_equipo = 0
        $filtroDestino_General $filtroPalabra_General $filtroResponsable_General $filtroSeccion_General $filtroSubseccion_General $filtroTipoIncidencia_General $filtroTipo_General $filtroStatus_General $filtroFecha_General";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $idCreadoPor = $x['id_usuario'];
                $titulo = $x['titulo'];
                $status = $x['status'];
                $rangoFecha = $x['rango_fecha'];
                $tipoIncidencia = $x['tipo_incidencia'];
                $sMaterial = intval($x['status_material']);
                $sTrabajando = intval($x['status_trabajando']);
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $sEP = $x['status_ep'];

                #STATUS
                if ($status == "SOLUCIONADO" || $status == "F" || $status == "FINALIZADO") {
                    $status = "SOLUCIONADO";
                } else {
                    $status = "PENDIENTE";
                }

                #CREADO POR
                $creadoPor = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idCreadoPor";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #ULTIMO COMENTARIO
                $comentario = "";
                $fecha = "";
                $ComentarioDe = "";
                $query = "SELECT comentarios_mp_np.comentario, comentarios_mp_np.fecha, t_colaboradores.nombre, t_colaboradores.apellido
                FROM comentarios_mp_np 
                INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE comentarios_mp_np.id_mp_np = $idItem and  comentarios_mp_np.activo = 1
                ORDER BY id_mp_np.id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $comentario = $x['comentario'];
                        $fecha = $x['fecha'];
                        $ComentarioDe = strtok($x['apellido'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                $guardar = "SI";
                if ($filtroFecha == "RANGO") {
                    $guardar = "NO";
                    if (strlen($rangoFecha) == 23 and $filtroFechaInicio != "" and $filtroFechaFin != "") {

                        // TRATA LA FECHA SELECCIONADA POR EL USUARIO
                        // $filtroFechaInicio = (new DateTime($filtroFechaInicio))->format('Y-m-d');
                        // $filtroFechaFin = (new DateTime($filtroFechaFin))->format('Y-m-d');

                        // TRATA LA FECHA DEL REGISTRO
                        $rangoFecha = str_replace("/", "-", $rangoFecha);
                        $rangoFecha = explode(" - ", $rangoFecha);
                        $fechaInicio = (new DateTime($rangoFecha[0]))->format('Y-m-d');
                        $fechaFin = (new DateTime($rangoFecha[1]))->format('Y-m-d');

                        if ($fechaInicio >= date('Y-01-04') &&  $fechaInicio <= date('Y-01-05')) {
                            $guardar = "SI";
                        }
                        // if ($fechaFin >= date('Y-01-05') && $fechaFin <= date('Y-01-05')) {
                        //     $guardar = "SI";
                        // }
                    }
                }

                if ($guardar == "SI") {
                    $array[] = array(
                        "idItem" => intval($idItem),
                        "titulo" => $titulo,
                        "creadoPor" => $creadoPor,
                        "status" => $status,
                        "tipo" => "GENERAL",
                        "tipoIncidencia" => $tipoIncidencia,
                        "sMaterial" => $sMaterial,
                        "sTrabajando" => $sTrabajando,
                        "sEnergetico" => $sEnergetico,
                        "sDepartamento" => $sDepartamento,
                        "sEP" => $sEP,
                        "comentario" => $comentario,
                        "comentarioFecha" => $fecha,
                        "ComentarioDe" => $ComentarioDe
                    );
                }
            }
        }

        #PREVENTIVOS
        $query = "SELECT t_mp_planificacion_iniciada.id, t_mp_planificacion_iniciada.status, t_mp_planificacion_iniciada.rango_fecha, t_mp_planificacion_iniciada.creado_por
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        WHERE t_mp_planificacion_iniciada.activo = 1
        $filtroDestino_Preventivo $filtroPalabra_Preventivo $filtroResponsable_Preventivo $filtroSeccion_Preventivo $filtroSubseccion_Preventivo $filtroTipoIncidencia_Preventivo $filtroTipo_Preventivo $filtroStatus_Preventivo $filtroFecha_Preventivo";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $idCreadoPor = $x['creado_por'];
                $titulo = "PREVENTIVO OT: # $idItem";
                $status = $x['status'];
                $rangoFecha = $x['rango_fecha'];

                #STATUS
                if ($status == "SOLUCIONADO" || $status == "F" || $status == "FINALIZADO") {
                    $status = "SOLUCIONADO";
                } else {
                    $status = "PENDIENTE";
                }

                #CREADO POR
                $creadoPor = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idCreadoPor";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                $array[] = array(
                    "idItem" => intval($idItem),
                    "titulo" => $titulo,
                    "creadoPor" => $creadoPor,
                    "status" => $status,
                    "tipo" => "PREVENTIVO",
                    "tipoIncidencia" => "PREVENTIVO",
                    "sMaterial" => 0,
                    "sTrabajando" => 0,
                    "sEnergetico" => 0,
                    "sDepartamento" => 0,
                    "sEP" => 0,
                    "comentario" => "",
                    "comentarioFecha" => "",
                    "ComentarioDe" => ""
                );
            }
        }

        #PROYECTOS PLANACCIONES
        $query = "SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.status, t_proyectos_planaccion.rango_fecha, t_proyectos_planaccion.creado_por
        FROM t_proyectos_planaccion
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id
        WHERE t_proyectos_planaccion.activo = 1
        $filtroDestino_Proyecto $filtroPalabra_Proyecto $filtroResponsable_Proyecto $filtroSeccion_Proyecto $filtroSubseccion_Proyecto $filtroTipoIncidencia_Proyecto $filtroTipo_Proyecto $filtroStatus_Proyecto $filtroFecha_Proyecto";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $titulo = $x['actividad'];
                $status = $x['status'];
                $rangoFecha = $x['rango_fecha'];
                $idCreadoPor = $x['creado_por'];

                #STATUS
                if ($status == "SOLUCIONADO" || $status == "F" || $status == "FINALIZADO") {
                    $status = "SOLUCIONADO";
                } else {
                    $status = "PENDIENTE";
                }

                #CREADO POR
                $creadoPor = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idCreadoPor";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #ULTIMO COMENTARIO
                $comentario = "";
                $fecha = "";
                $ComentarioDe = "";
                $query = "SELECT t_proyectos_planaccion_comentarios.comentario, t_proyectos_planaccion_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido
                FROM t_proyectos_planaccion_comentarios 
                INNER JOIN t_users ON t_proyectos_planaccion_comentarios.usuario = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_proyectos_planaccion_comentarios.id_actividad = $idItem and  
                t_proyectos_planaccion_comentarios.activo = 1 
                ORDER BY t_proyectos_planaccion_comentarios.id_actividad DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $comentario = $x['comentario'];
                        $fecha = $x['fecha'];
                        $ComentarioDe = strtok($x['apellido'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                $array[] = array(
                    "idItem" => intval($idItem),
                    "titulo" => $titulo,
                    "creadoPor" => $creadoPor,
                    "status" => $status,
                    "tipo" => "PROYECTO",
                    "tipoIncidencia" => "PROYECTO",
                    "sMaterial" => 0,
                    "sTrabajando" => 0,
                    "sEnergetico" => 0,
                    "sDepartamento" => 0,
                    "sEP" => 0,
                    "comentario" => $comentario,
                    "comentarioFecha" => $fecha,
                    "ComentarioDe" => $ComentarioDe
                );
            }
        }
        echo json_encode($array);
    }
}
