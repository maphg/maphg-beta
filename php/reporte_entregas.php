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
    $array = array();

    // OBTINE RESULTADOS DE LAS INCIDENCIAS POR LOS FILTROS
    if ($action == "obtenerReporte") {

        $filtroPalabra = $_POST['filtroPalabra'];
        $filtroResponsable = $_POST['filtroResponsable'];
        $filtroSeccion = $_POST['filtroSeccion'];
        $filtroSubseccion = $_POST['filtroSubseccion'];
        $filtroEquipos = $_POST['filtroEquipos'];
        $filtroTipo = $_POST['filtroTipo'];
        $filtroTipoIncidencia = $_POST['filtroTipoIncidencia'];
        $filtroStatus = $_POST['filtroStatus'];
        $filtroStatusIncidencia = $_POST['filtroStatusIncidencia'];
        $filtroFecha = $_POST['filtroFecha'];
        $array = array();

        #FILTRO DESTINO
        if ($idDestino == 10) {
            $filtroDestino = "";
            $filtroDestino_General = "";
            $filtroDestino_Preventivo = "";
            $filtroDestino_Proyecto = "";
        } else {
            $filtroDestino = "and t_mc.id_destino = $idDestino";
            $filtroDestino_General = "and t_mp_np.id_destino = $idDestino";
            $filtroDestino_Preventivo = "and t_equipos_america.id_destino = $idDestino";
            $filtroDestino_Proyecto = "and t_proyectos.id_destino = $idDestino";
        }

        #FILTRO PALABRA
        if ($filtroPalabra == "" || $filtroPalabra == " ") {
            $filtroPalabraIncidencias = "";
            $filtroPalabra_General = "";
            $filtroPalabra_Preventivo = "";
            $filtroPalabra_Proyecto = "";
        } else {
            $filtroPalabraIncidencias = "and t_mc.actividad LIKE '%$filtroPalabra%'";
            $filtroPalabra_General = "and t_mp_np.titulo LIKE '%$filtroPalabra%'";
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
            $filtroResponsableIncidencias = "and t_mc.responsable IN($filtroResponsable)";
            $filtroResponsable_General = "and t_mp_np.responsable IN($filtroResponsable)";
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
            $filtroSeccionIncidencias = "and t_mc.id_seccion = $filtroSeccion";
            $filtroSeccion_General = "and t_mp_np.id_seccion = $filtroSeccion";
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
            $filtroSubseccionIncidencias = "and t_mc.id_subseccion = $filtroSubseccion";
            $filtroSubseccion_General = "and t_mp_np.id_subseccion = $filtroSubseccion";
            $filtroSubseccion_Preventivo = "and t_equipos_america.id_subseccion = $filtroSubseccion";
            $filtroSubseccion_Proyecto = "and t_proyectos.id_subseccion = $filtroSubseccion";
        }


        if ($filtroEquipos > 0) {
            $filtroEquiposIncidencias = "and t_equipos_america.id_equipo_principal = $filtroEquipos and t_equipos_america.jerarquia = 'SECUNDARIO'";
            $filtroEquipos_General = "and t_mp_np.id_equipo = 0";
            $filtroEquipos_Preventivo = "and t_equipos_america.id_equipo = $filtroEquipos";
            $filtroEquipos_Proyecto = "and t_proyectos.id_subseccion = 0";
        } else {
            $filtroEquiposIncidencias = "";
            $filtroEquipos_General = "";
            $filtroEquipos_Preventivo = "";
            $filtroEquipos_Proyecto = "";
        }

        #FILTRO TIPO INCIDENCIA (EMERGENCIA, URGENCIA, ALARMA, ALERTA, SEGUIMIENTO)
        if ($filtroTipoIncidencia == "TODOS") {
            $filtroTipoIncidenciaIncidencias = "";
            $filtroTipoIncidencia_General = "";
            $filtroTipoIncidencia_Preventivo = "";
            $filtroTipoIncidencia_Proyecto = "";
        } elseif ($filtroTipoIncidencia == "EMERGENCIA") {
            $filtroTipoIncidenciaIncidencias = "and t_mc.tipo_incidencia = 'EMERGENCIA'";
            $filtroTipoIncidencia_General = "and t_mp_np.tipo_incidencia = 'EMERGENCIA'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipoIncidencia == "URGENCIA") {
            $filtroTipoIncidenciaIncidencias = "and t_mc.tipo_incidencia = 'URGENCIA'";
            $filtroTipoIncidencia_General = "and t_mp_np.tipo_incidencia = 'URGENCIA'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipoIncidencia == "ALARMA") {
            $filtroTipoIncidenciaIncidencias = "and t_mc.tipo_incidencia = 'ALARMA'";
            $filtroTipoIncidencia_General = "and t_mp_np.tipo_incidencia = 'ALARMA'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipoIncidencia == "ALERTA") {
            $filtroTipoIncidenciaIncidencias = "and t_mc.tipo_incidencia = 'ALERTA'";
            $filtroTipoIncidencia_General = "and t_mp_np.tipo_incidencia = 'ALERTA'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipoIncidencia == "SEGUIMIENTO") {
            $filtroTipoIncidenciaIncidencias = "and t_mc.tipo_incidencia = 'SEGUIMIENTO'";
            $filtroTipoIncidencia_General = "and t_mp_np.tipo_incidencia = 'SEGUIMIENTO'";
            $filtroTipoIncidencia_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipoIncidencia_Proyecto = "and t_proyectos_planaccion.id = 0";
        } else {
            $filtroTipoIncidenciaIncidencias = "and t_mc.tipo_incidencia = 'ND'";
            $filtroTipoIncidencia_General = "and t_mp_np.tipo_incidencia = 'ND'";
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
            $filtroTipoIncidencias = "and t_mc.id = 0";
            $filtroTipo_General = "and t_mp_np.id = 0";
            $filtroTipo_Preventivo = "";
            $filtroTipo_Proyecto = "and t_proyectos_planaccion.id = 0";
        } elseif ($filtroTipo == "PROYECTOS") {
            $filtroTipoIncidencias = "and t_mc.id = 0";
            $filtroTipo_General = "and t_mp_np.id = 0";
            $filtroTipo_Preventivo = "and t_mp_planificacion_iniciada.id = 0";
            $filtroTipo_Proyecto = "";
        } else {
            $filtroTipoIncidencias = "and t_mc.id_destino = 0";
            $filtroTipo_General = "and t_mp_np.id_destino = 0";
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
                $filtroStatusIncidencias = "and t_mc.status_material = 1";
                $filtroStatus_General = "and t_mp_np.status_material = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.status_material = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.status_material = 1";
            } elseif ($filtroStatus == "TRABAJANDO") {
                $filtroStatusIncidencias = "and t_mc.status_trabajare = 1";
                $filtroStatus_General = "and t_mp_np.status_trabajando = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.status_trabajando = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.status_trabajando = 1";
            } elseif ($filtroStatus == "ELECTRICIDAD") {
                $filtroStatusIncidencias = "and t_mc.energetico_electricidad = 1";
                $filtroStatus_General = "and t_mp_np.energetico_electricidad = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.energetico_electricidad = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.energetico_electricidad = 1";
            } elseif ($filtroStatus == "AGUA") {
                $filtroStatusIncidencias = "and t_mc.energetico_agua = 1";
                $filtroStatus_General = "and t_mp_np.energetico_agua = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.energetico_agua = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.energetico_agua = 1";
            } elseif ($filtroStatus == "DIESEL") {
                $filtroStatusIncidencias = "and t_mc.energetico_diesel = 1";
                $filtroStatus_General = "and t_mp_np.energetico_diesel = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.energetico_diesel = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.energetico_diesel = 1";
            } elseif ($filtroStatus == "GAS") {
                $filtroStatusIncidencias = "and t_mc.energetico_gas = 1";
                $filtroStatus_General = "and t_mp_np.energetico_gas = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.energetico_gas = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.energetico_gas = 1";
            } elseif ($filtroStatus == "CALIDAD") {
                $filtroStatusIncidencias = "and t_mc.departamento_calidad = 1";
                $filtroStatus_General = "and t_mp_np.departamento_calidad = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_calidad = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_calidad = 1";
            } elseif ($filtroStatus == "COMPRAS") {
                $filtroStatusIncidencias = "and t_mc.departamento_compras = 1";
                $filtroStatus_General = "and t_mp_np.departamento_compras = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_compras = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_compras = 1";
            } elseif ($filtroStatus == "DIRECCION") {
                $filtroStatusIncidencias = "and t_mc.departamento_direccion = 1";
                $filtroStatus_General = "and t_mp_np.departamento_direccion = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_direccion = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_direccion = 1";
            } elseif ($filtroStatus == "FINANZAS") {
                $filtroStatusIncidencias = "and t_mc.departamento_finanzas = 1";
                $filtroStatus_General = "and t_mp_np.departamento_finanzas = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_finanzas = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_finanzas = 1";
            } elseif ($filtroStatus == "RRHH") {
                $filtroStatusIncidencias = "and t_mc.departamento_rrhh = 1";
                $filtroStatus_General = "and t_mp_np.departamento_rrhh = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.departamento_rrhh = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.departamento_rrhh = 1";
            } elseif ($filtroStatus == "EP") {
                $filtroStatusIncidencias = "and t_mc.status_ep = 1";
                $filtroStatus_General = "and t_mp_np.status_ep = 1";
                $filtroStatus_Preventivo = "and t_mp_planificacion_iniciada.status_ep = 1";
                $filtroStatus_Proyecto = "and t_proyectos_planaccion.status_ep = 1";
            } else {
                $filtroStatusIncidencias = "";
                $filtroStatus_General = "";
                $filtroStatus_Preventivo = "";
                $filtroStatus_Proyecto = "";
            }
        }

        #FILTRO PARA STATUS (PENDIENTE, SOLUCIONADO)
        if ($filtroStatusIncidencia == "TODOS") {
            $filtroStatusIncidenciaIncidencias = "";
            $filtroStatusIncidencia_General = "";
            $filtroStatusIncidencia_Preventivo = "";
            $filtroStatusIncidencia_Proyecto = "";
        } elseif ($filtroStatusIncidencia == "PENDIENTE") {
            $filtroStatusIncidenciaIncidencias = "and t_mc.status IN('PENDIENTE', 'N', 'P')";
            $filtroStatusIncidencia_General = "and t_mp_np.status IN('PENDIENTE', 'N', 'P')";
            $filtroStatusIncidencia_Preventivo = "and t_mp_planificacion_iniciada.status IN('PENDIENTE', 'N', 'P')";
            $filtroStatusIncidencia_Proyecto = "t_proyectos_planaccion.status IN('PENDIENTE', 'N', 'P')";
        } elseif ($filtroStatusIncidencia == "SOLUCIONADO") {
            $filtroStatusIncidenciaIncidencias = "and t_mc.status IN('SOLUCIONADO', 'F', 'FINALIZADO')";
            $filtroStatusIncidencia_General = "and t_mp_np.status IN('SOLUCIONADO', 'F', 'FINALIZADO')";
            $filtroStatusIncidencia_Preventivo = "and t_mp_planificacion_iniciada.status IN('SOLUCIONADO', 'F', 'FINALIZADO')";
            $filtroStatusIncidencia_Proyecto = "t_proyectos_planaccion.status IN('SOLUCIONADO', 'F', 'FINALIZADO')";
        }

        #FILTRO FECHA
        if ($filtroFecha == "TODOS") {
            $filtroFechaIncidencias = "";
            $filtroFecha_General = "";
            $filtroFecha_Preventivo = "";
            $filtroFecha_Proyecto = "";
        } elseif ($filtroFecha == "SINPLANIFICAR") {
            $filtroFechaIncidencias = "and t_mc.rango_fecha = ''";
            $filtroFecha_General = "and t_mp_np.rango_fecha = ''";
            $filtroFecha_Preventivo = "and t_mp_planificacion_iniciada.rango_fecha = ''";
            $filtroFecha_Proyecto = "and t_proyectos_planaccion.rango_fecha = ''";
        } elseif ($filtroFecha == "PLANIFICADO") {
            $filtroFechaIncidencias = "and t_mc.rango_fecha != ''";
            $filtroFecha_General = "and t_mp_np.rango_fecha != ''";
            $filtroFecha_Preventivo = "and t_mp_planificacion_iniciada.rango_fecha != ''";
            $filtroFecha_Proyecto = "and t_proyectos_planaccion.rango_fecha != ''";
        } elseif ($filtroFecha == "RANGO") {
            $fechaInicio = strtotime($_POST['filtroFechaInicio']);
            $fechaFin = strtotime($_POST['filtroFechaFin']);

            $rangoFechasIncidencias = "";
            $rangoFechasIncidenciasGenerales = "";
            $rangoFechasPreventivos = "";
            $rangoFechasPDA = "";

            for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
                if ($i == $fechaFin) {
                    $rangoFechasIncidencias .= "t_mc.rango_fecha LIKE '%" .
                        (new DateTime(date("d-m-Y", $i)))->format('d/m/Y') . "%'";
                    $rangoFechasIncidenciasGenerales .= "t_mp_np.rango_fecha LIKE '%" .
                        (new DateTime(date("d-m-Y", $i)))->format('d/m/Y') . "%'";
                    $rangoFechasPDA .= "t_proyectos_planaccion.rango_fecha LIKE '%" .
                        (new DateTime(date("d-m-Y", $i)))->format('d/m/Y') . "%'";
                    $rangoFechasPreventivos .= "t_mp_planificacion_iniciada.fecha_creacion LIKE '%" .
                        (new DateTime(date("d-m-Y", $i)))->format('Y-m-d') . "%'";
                } else {
                    $rangoFechasIncidencias .= "t_mc.rango_fecha LIKE '%" .
                        (new DateTime(date("d-m-Y", $i)))->format('d/m/Y') . "%' or ";
                    $rangoFechasIncidenciasGenerales .= "t_mp_np.rango_fecha LIKE '%" .
                        (new DateTime(date("d-m-Y", $i)))->format('d/m/Y') . "%' or ";
                    $rangoFechasPDA .= "t_proyectos_planaccion.rango_fecha LIKE '%" .
                        (new DateTime(date("d-m-Y", $i)))->format('d/m/Y') . "%' or ";
                    $rangoFechasPreventivos .= "t_mp_planificacion_iniciada.fecha_creacion LIKE '%" .
                        (new DateTime(date("d-m-Y", $i)))->format('Y-m-d') . "%' or ";
                }
            }

            $filtroFechaIncidencias = "and $rangoFechasIncidencias";
            $filtroFecha_General = "and $rangoFechasIncidenciasGenerales";
            $filtroFecha_Preventivo = "and ($rangoFechasPreventivos)";
            $filtroFecha_Proyecto = "and ($rangoFechasPDA)";
        } else {
            $filtroFechaIncidencias = "and t_mc.rango_fecha != ''";
            $filtroFecha_General = "and t_mp_np.rango_fecha != ''";
            $filtroFecha_Preventivo = "and t_mp_planificacion_iniciada.rango_fecha != ''";
            $filtroFecha_Proyecto = "and t_proyectos_planaccion.rango_fecha != ''";
        }

        #INCIDENCIAS
        $query = "SELECT 
        t_mc.id, 
        t_mc.actividad, 
        t_mc.status, 
        t_mc.rango_fecha, 
        t_mc.tipo_incidencia,
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
        t_mc.status_ep,
        t_mc.id_seccion,
        t_mc.id_subseccion,
        t_mc.id_equipo,
        c_secciones.seccion,
        c_subsecciones.grupo, 
        t_equipos_america.equipo,
        t_equipos_america.id 'idEquipo',
        t_equipos_america.id_equipo_principal
        FROM t_mc
        INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id
        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
        WHERE t_mc.activo = 1 and t_mc.id_equipo > 0 $filtroDestino $filtroPalabraIncidencias $filtroResponsableIncidencias $filtroSeccionIncidencias $filtroSubseccionIncidencias $filtroTipoIncidenciaIncidencias $filtroTipoIncidencias $filtroStatusIncidencias $filtroFechaIncidencias $filtroStatusIncidenciaIncidencias $filtroEquiposIncidencias
        ORDER BY t_mc.id DESC";
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
                $idSeccion = $x['id_seccion'];
                $idSubseccion = $x['id_subseccion'];
                $idEquipo = $x['id_equipo'];
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $equipoSecundario = $x['equipo'];
                $idEquipoSecundario = $x['id_equipo_principal'];
                $idEquipo = $x['idEquipo'];

                #EQUIPO PRINCIPAL
                $equipoPrincial = "";
                $idEquipoPrincipal = 0;
                $query = "SELECT id, equipo FROM t_equipos_america WHERE id = $idEquipoSecundario";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $equipoPrincial = $x['equipo'];
                        $idEquipoPrincipal = $x['id'];
                    }
                }

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
                        $ComentarioDe = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #DOCUMENTOS
                $totalAdjuntos = 0;
                $query = "SELECT count(id) 'total' FROM t_mc_adjuntos 
                WHERE id_mc = $idItem and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['total'];
                    }
                }

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
                    "ComentarioDe" => $ComentarioDe,
                    "idSeccion" => intval($idSeccion),
                    "idSubseccion" => intval($idSubseccion),
                    "totalAdjuntos" => intval($totalAdjuntos),
                    "equipoPrincial" => $equipoPrincial,
                    "equipoSecundario" => $equipoSecundario,
                    "seccion" => $seccion,
                    "subseccion" => $subseccion,
                    "idEquipo" => $idEquipo,
                    "idEquipoSecundario" => intval($idEquipoSecundario),
                    "idEquipoPrincipal" => intval($idEquipoPrincipal)
                );
            }
        }
        echo json_encode($array);
    }

    // OBTIENE OPCIONES DE EQUIPOS
    if ($action == "obtenerOpcionEquipos") {
        $filtroSeccion = $_GET['filtroSeccion'];
        $filtroSubseccion = $_GET['filtroSubseccion'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        $query = "SELECT id, equipo
        FROM t_equipos_america 
        WHERE id_seccion = $filtroSeccion and id_subseccion = $filtroSubseccion and activo = 1 $filtroDestino and status !='BAJA' and jerarquia = 'PRINCIPAL'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];

                $total = 0;
                $query = "SELECT count(id) 'total' FROM t_equipos_america WHERE id_equipo_principal = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $total = $x['total'];
                    }
                }
                if ($total > 0) {
                    $total = " ($total)";
                } else {
                    $total = "";
                }

                $array[] = array(
                    "idEquipo" => $idEquipo,
                    "equipo" => $equipo . $total
                );
            }
        }
        echo json_encode($array);
    }

    // OBTIENE LOS EQUIPOS PRINCIPALES
    if ($action == "obtenerEquiposPrincipales") {
        $filtroSeccion = $_GET['filtroSeccion'];
        $filtroSubseccion = $_GET['filtroSubseccion'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        $query = "SELECT id, equipo FROM t_equipos_america
        WHERE activo = 1 and id_seccion = $filtroSeccion and id_subseccion = $filtroSubseccion and jerarquia = 'PRINCIPAL' and status !='BAJA' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];

                $array[] = array(
                    "idEquipo" => $idEquipo,
                    "equipo" => $equipo
                );
            }
        }
        echo json_encode($array);
    }

    // OBTIENE LOS EQUIPOS SECUNDARIOS
    if ($action == "obtenerEquiposSecundarios") {
        $filtroEquipos = $_GET['filtroEquipos'];
        $filtroSeccion = $_GET['filtroSeccion'];
        $filtroSubseccion = $_GET['filtroSubseccion'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        $query = "SELECT id, equipo FROM t_equipos_america
        WHERE activo = 1 and id_seccion = $filtroSeccion and id_subseccion = $filtroSubseccion and id_equipo_principal = $filtroEquipos and jerarquia = 'SECUNDARIO' and status !='BAJA' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];

                $array[] = array(
                    "idEquipo" => $idEquipo,
                    "equipo" => $equipo
                );
            }
        }
        echo json_encode($array);
    }


    if ($action == "cambiarStatus") {
        $tipo = $_GET['tipo'];
        $idItem = $_GET['idItem'];
        $resp = 0;

        if ($tipo == "INCIDENCIA") {
            // OBTIENE STATUS ACTUAL
            $status = "PENDIENTE";
            $query = "SELECT status FROM t_mc WHERE id = $idItem";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $status = $x['status'];
                }
            }

            //TOGGLE DE STATUS 
            if ($status == "SOLUCIONADO") {
                $status = "PENDIENTE";
            } else {
                $status = "SOLUCIONADO";
            }

            // APLICA STATUS TOGGLE
            $query = "UPDATE t_mc SET status = '$status' WHERE id = $idItem";
            if ($result = mysqli_query($conn_2020, $query)) {
                if ($status == "SOLUCIONADO") {
                    $resp = 1;
                } else {
                    $resp = 2;
                }
            }
        }
    }
}
