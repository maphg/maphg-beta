<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';

if (isset($_GET['action'])) {
    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $semanaActual = date('W');

    if ($action == "reporteEquipos") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $fila = 2;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Equipos");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'EQUIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'LOCAL/EQUIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'FALLAS S');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'FALLAS P');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'PREVENTIVO S');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'PREVENTIVO P');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'ULTIMO MP');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'PROXIMO MP');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'TAREAS S');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'TAREAS P');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'TEST');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'ULTOMO TEST');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'COT');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'PICS');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'COMENTS');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'DESPIECE');

        if ($idDestino == 10) {
            $filtroDestinoEquipo = "";
        } else {
            $filtroDestinoEquipo = "and t_equipos_america.id_destino = $idDestino";
        }

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, 
        t_equipos_america.local_equipo, t_equipos_america.status
        FROM t_equipos_america
        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and 
        t_equipos_america.jerarquia = 'PRINCIPAL' $filtroDestinoEquipo";
        if ($resultEquipo = mysqli_query($conn_2020, $query)) {
            foreach ($resultEquipo as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];
                $statusEquipo = $x['status'];
                $tipoEquipo = $x['local_equipo'];
                $fila++;

                #FALLAS PENDIENTES
                $fallasPendientes = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                and (status = 'N' or status = '' or status = 'PENDIENTE' or status = 'P') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasPendientes = $a['count(id)'];
                    }
                }

                #FALLAS SOLUCIONADOS
                $fallasSolucionadas = 0;
                $query = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo 
                and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $fallasSolucionadas = $a['count(id)'];
                    }
                }

                #TAREAS SOLUCIONADOS
                $tareasSolucionadas = 0;
                $query = "SELECT count(id) FROM t_mp_np WHERE id_equipo = $idEquipo 
                    and (status = 'F' or status = 'SOLUCIONADO') and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $tareasSolucionadas = $a['count(id)'];
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

                #TOTAL COTIZACIONES POR EQUIPO
                $totalCotizaciones = 0;
                $query = "SELECT count(id) FROM t_equipos_cotizaciones WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalCotizaciones = $a['count(id)'];
                    }
                }

                #TOTAL ADJUNTOS POR EQUIPO
                $totalAdjuntos = 0;
                $query = "SELECT count(id) FROM t_equipos_america_adjuntos WHERE id_equipo = $idEquipo and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalAdjuntos = $a['count(id)'];
                    }
                }

                #TOTAL COMENTARIOS POR EQUIPO
                $totalComentarios = 0;
                $query = "SELECT count(id) FROM t_equipos_america_comentarios WHERE id_equipo = $idEquipo and status = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $totalComentarios = $a['count(id)'];
                    }
                }

                #ULTIMO PREVENTIVO POR EQUIPO
                $ultimoMpFecha = "";
                $ultimoMpSemana = 0;
                $query = "SELECT semana, fecha_creacion FROM t_mp_planificacion_iniciada WHERE id_equipo = $idEquipo and status = 'SOLUCIONADO' and activo = 1
                ORDER BY id DESC LIMIT 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $ultimoMpFecha = $a['fecha_creacion'];
                        if ($ultimoMpFecha != "") {
                            $ultimoMpFecha = (new DateTime($ultimoMpFecha))->format('d-m-Y');
                        }
                        $ultimoMpSemana = $a['semana'];
                    }
                }

                #PREVENTIVOS SOLUCIONADOS POR EQUIPO
                $mpS = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO' ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $mpS = $a['id'];
                    }
                }

                #PREVENTIVOS PENDIENTES POR EQUIPO
                $mpP = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id'
                FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'PROCESO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $mpP = $a['id'];
                    }
                }

                #MP PRIXIMO POR EQUIPO
                $proximoMpFecha = "";
                $proximoMpSemana = 0;
                $query = "SELECT* FROM t_mp_planeacion_semana WHERE id_equipo = $idEquipo and activo = 1 and año = '$añoActual' ORDER BY id DESC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $tareasSolucionadas = 0;
                    foreach ($result as $a) {
                        $proximoMpFechaX = (new DateTime($a['ultima_modificacion']))
                            ->format("d/m/Y");
                        for ($x = 1; $x < 53; $x++) {
                            $semana_x = $a['semana_' . $x];
                            if ($semana_x == "PLANIFICADO") {
                                $proximoMpSemana = $x;
                                $proximoMpFecha = $proximoMpFechaX;
                                $x = 52;
                            }
                        }
                    }
                }

                #PREVENTIVOS SOLUCIONADOS POR EQUIPO
                $testR = 0;
                $query = "SELECT count(t_mp_planificacion_iniciada.id) 'id' FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'TEST' ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $testR = $a['id'];
                    }
                }

                #PREVENTIVOS TEST SOLUCIONADOS POR EQUIPO
                $ultimoTestFecha = 0;
                $ultimoTestSemana = 0;
                $query = "SELECT t_mp_planificacion_iniciada.semana, 
                t_mp_planificacion_iniciada.fecha_creacion 
                FROM t_mp_planificacion_iniciada 
                INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
                WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.status = 'SOLUCIONADO' and 
                t_mp_planificacion_iniciada.activo = 1 and año = '$añoActual' and t_mp_planes_mantenimiento.tipo_plan = 'TEST'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $a) {
                        $ultimoTestFecha = $a['fecha_creacion'];
                        $ultimoTestSemana = $a['semana'];
                        if ($ultimoTestFecha != "") {
                            $ultimoTestFecha = (new DateTime($ultimoTestFecha))->format('d-m-Y');
                        }
                    }
                }

                $query = "SELECT count(id) FROM t_equipos_america WHERE id_equipo_principal = $idEquipo and activo = 1";
                $totalDespiece = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalDespiece = $x['count(id)'];
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $tipoEquipo);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $statusEquipo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $fallasSolucionadas);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $fallasPendientes);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $mpS);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $mpP);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $ultimoMpFecha);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $proximoMpFecha);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $tareasSolucionadas);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $tareasPendientes);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $testR);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $ultimoTestFecha);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $totalCotizaciones);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $totalDespiece);
            }
        }

        $fecha = date('d-m-Y H:m:s');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_Equipos_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }

    if ($action == "reporteFallas") {
        // OBTIENES LAS FALLAS EN GENERAL (PENDIENTES Y SOLUCIONADOS);
        $idEquipo = $_GET['idEquipo'];
        $fila = 1;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Equipos");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ACTIVIDAD');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'CREADO POR');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'SUBTAREAS');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'RESPONSABLE');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'FECHA INICIO');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'FECHA FIN');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'MATERIALES');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'ENERGETICOS');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'DEPARTAMENTOS');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'TRABAJANDO');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'TIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'OT');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'COMENTARIOS');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'ADJUNTOS');

        $query = "SELECT t_mc.id, t_mc.actividad, t_mc.status, t_mc.responsable, t_colaboradores.nombre, t_mc.fecha_creacion, t_mc.rango_fecha, t_colaboradores.apellido,
            t_mc.status_urgente,
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
            t_mc.departamento_rrhh
            FROM t_mc 
            LEFT JOIN t_users ON t_mc.creado_por = t_users.id
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_mc.id_equipo = $idEquipo and t_mc.activo = 1 ORDER BY t_mc.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idFalla = $x['id'];
                $actividad = $x['actividad'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $idResponsable = $x['responsable'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format("d/m/Y");
                $status = $x['status'];
                $sUrgente = intval($x['status_urgente']);
                $sMaterial = intval($x['status_material']);
                $sTrabajando = intval($x['status_trabajare']);
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $fila++;

                #RESPONSABLE
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_users 
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id = $idResponsable";
                $responsable = " ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable = strtok($x['nombre'], ' ') . " " .
                            strtok($x['apellido'], ' ');
                    }
                }

                #COMENTARIOS
                $query = "SELECT count(id) FROM t_mc_comentarios 
                    WHERE id_mc = $idFalla and activo = 1";
                $totalComentarios = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #ADJUNTOS
                $query = "SELECT count(id) FROM t_mc_adjuntos 
                    WHERE id_mc = $idFalla and activo = 1";
                $totalAdjuntos = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                #ACTIVIDADES
                $query = "SELECT count(id) FROM t_mc_actividades_ot 
                    WHERE id_falla = $idFalla and activo = 1";
                $totalActividades = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalActividades = $x['count(id)'];
                    }
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

                #STATUS 
                if ($status == "N" or $status == "PENDIENTE" or $status == "" or $status == "P") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                if ($sMaterial > 0) {
                    $materiales = 1;
                } else {
                    $materiales = 0;
                }
                if ($sTrabajando > 0) {
                    $trabajando = 1;
                } else {
                    $trabajando = 0;
                }
                if ($sEnergetico > 0) {
                    $energeticos = 1;
                } else {
                    $energeticos = 0;
                }
                if ($sDepartamento > 0) {
                    $departamentos = 1;
                } else {
                    $departamentos = 0;
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $actividad);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $totalActividades);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $responsable);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $fechaInicio);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $fechaFin);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $materiales);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $energeticos);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $departamentos);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $trabajando);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, "FALLA");
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, "F" . $idFalla);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $totalAdjuntos);
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_FALLAS_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }

    if ($action == "reporteTareas") {

        $idEquipo = $_GET['idEquipo'];
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $fila = 1;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Equipos");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ACTIVIDAD');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'CREADO POR');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'SUBTAREAS');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'RESPONSABLE');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'FECHA INICIO');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'FECHA FIN');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'MATERIALES');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'ENERGETICOS');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'DEPARTAMENTOS');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'TRABAJANDO');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'TIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'OT');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'COMENTARIOS');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'ADJUTNOS');

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_mp_np.id_destino = $idDestino";
        }

        if ($idEquipo == 0) {
            $filtroEquipo = "and t_mp_np.id_seccion = $idSeccion and 
            t_mp_np.id_subseccion = $idSubseccion ";
        } else {
            $filtroEquipo = "";
        }


        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.status, t_mp_np.responsable, t_colaboradores.nombre, t_mp_np.fecha, t_mp_np.rango_fecha,
        t_colaboradores.apellido,
        t_mp_np.status_urgente,
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
        t_mp_np.departamento_rrhh
        FROM t_mp_np
        LEFT JOIN t_users ON t_mp_np.id_usuario = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mp_np.id_equipo = $idEquipo and t_mp_np.activo = 1 $filtroEquipo
        ORDER BY t_mp_np.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTarea = $x['id'];
                $actividad = $x['titulo'];
                $creadoPor = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $idResponsable = $x['responsable'];
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha']))->format("d/m/Y");
                $status = $x['status'];
                $sUrgente = intval($x['status_urgente']);
                $sMaterial = intval($x['status_material']);
                $sTrabajando = intval($x['status_trabajando']);
                $sEnergetico = intval($x['energetico_electricidad']) + intval($x['energetico_agua']) + intval($x['energetico_diesel']) + intval($x['energetico_gas']);
                $sDepartamento = intval($x['departamento_calidad']) + intval($x['departamento_compras']) + intval($x['departamento_direccion']) + intval($x['departamento_finanzas']) + intval($x['departamento_rrhh']);
                $fila++;

                #RESPONSABLE
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                $responsable = " ";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable = strtok($x['nombre'], ' ') . " " .
                            strtok($x['apellido'], ' ');
                    }
                }

                #COMENTARIOS
                $query = "SELECT count(id) FROM comentarios_mp_np 
                WHERE id_mp_np = $idTarea and activo = 1";
                $totalComentarios = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalComentarios = $x['count(id)'];
                    }
                }

                #ADJUNTOS
                $query = "SELECT count(id) FROM adjuntos_mp_np 
                WHERE id_mp_np = $idTarea and activo = 1";
                $totalAdjuntos = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['count(id)'];
                    }
                }

                #ACTIVIDADES
                $query = "SELECT count(id) FROM t_mp_np_actividades_ot 
                WHERE id_tarea = $idTarea and activo = 1";
                $totalActividades = 0;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalActividades = $x['count(id)'];
                    }
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

                #STATUS 
                if ($status == "N" or $status == "PENDIENTE" or $status == "" or $status == "P") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                if ($sMaterial > 0) {
                    $materiales = 1;
                } else {
                    $materiales = 0;
                }
                if ($sTrabajando > 0) {
                    $trabajando = 1;
                } else {
                    $trabajando = 0;
                }
                if ($sEnergetico > 0) {
                    $energeticos = 1;
                } else {
                    $energeticos = 0;
                }
                if ($sDepartamento > 0) {
                    $departamentos = 1;
                } else {
                    $departamentos = 0;
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $actividad);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $totalActividades);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $responsable);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $fechaInicio);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $fechaFin);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $materiales);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $energeticos);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $departamentos);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $trabajando);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, "TAREA");
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, "T" . $idTarea);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $totalAdjuntos);
            }
        }
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_TAREAS_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }

    if ($action == "reporteProyectosGlobal") {
        $array = array();
        $fila = 1;

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_proyectos.id_destino = $idDestino";
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Proyectos");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'DESTINO');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'SECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'PROYECTO');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'CREADO POR');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'PDA(PENDIENTES/TOTAL)');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'RESPONSABLE');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'FECHA INICIO');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'FECHA FIN');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'AÑO');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'COTIZACIONES');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'TIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'JUSTIFIACIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'COMENTARIOS');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'COSTE');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'MATERIALES');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'ENERGETICOS');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', 'DEPARTAMENTOS');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', 'TRABAJANDO');


        $query = "SELECT t_proyectos.id, t_proyectos.titulo, t_proyectos.rango_fecha, 
        t_proyectos.responsable, t_proyectos.fecha_creacion, t_proyectos.justificacion, 
        t_proyectos.coste, c_destinos.destino, t_colaboradores.nombre, t_colaboradores.apellido, 
        t_proyectos.tipo, c_secciones.seccion, t_proyectos.status
        FROM t_proyectos 
        INNER JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_proyectos.id_seccion = c_secciones.id
        LEFT JOIN t_users ON t_proyectos.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos.activo = 1 $filtroDestino ORDER BY t_proyectos.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $p) {
                $idProyecto = $p['id'];
                $creadoPor = $p['nombre'] . " " . $p['apellido'];
                $destino = $p['destino'];
                $seccion = $p['seccion'];
                $titulo = $p['titulo'];
                $idResponsable = $p['responsable'];
                $rangoFecha = $p['rango_fecha'];
                $fechaCreacion = (new DateTime($p['fecha_creacion']))->format('d/m/Y');
                $año = (new DateTime($p['fecha_creacion']))->format('Y');
                $justificacion = $p['justificacion'];
                $coste = $p['coste'];
                $tipo = $p['tipo'];
                $status = $p['status'];
                $fila++;

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
                    "status" => $status,
                    "materiales" => intval($sMaterialx),
                    "energeticos" => intval($sEnergeticox),
                    "departamento" => intval($sDepartamentox),
                    "trabajando" => intval($sTrabajandox)
                );

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $destino);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $titulo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $pda);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $nombreResponsable);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $fechaInicio);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $fechaFin);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $año);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $tipo);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $justificacion);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $coste);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, intval($sMaterialx));
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, intval($sEnergeticox));
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $fila, intval($sDepartamentox));
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $fila, intval($sTrabajandox));
            }
        }
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_PROYECTOS_GLOBAL_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }


    if ($action == "reporteProyectosDEP") {
        $idSubseccion = $_GET['idSubseccion'];
        $fila = 1;

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_proyectos.id_destino = $idDestino";
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Proyectos DEP");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'DESTINO');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'PROYECTO');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'CREADO POR');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'PDA (PENDIENTES / TOTAL)');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'RESPONSABLE');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'FECHA INICIO');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'FECHA FIN');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'COTIZACIONES');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'TIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'JUSTIFICACIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'COMENTARIOS');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'COSTE');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'MATERIALES');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'ENERGETICOS');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'DEPARTAMENTOS');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'TRABAJANDO');

        $query = "SELECT t_proyectos.id, t_proyectos.titulo, t_proyectos.rango_fecha, 
        t_proyectos.responsable, t_proyectos.fecha_creacion, t_proyectos.justificacion, t_proyectos.coste, c_destinos.destino, t_colaboradores.nombre, t_colaboradores.apellido, 
        t_proyectos.tipo, t_proyectos.status
        FROM t_proyectos
        LEFT JOIN c_destinos ON t_proyectos.id_destino = c_destinos.id
        LEFT JOIN t_users ON t_proyectos.creado_por = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos.activo = 1 and t_proyectos.id_subseccion = $idSubseccion
        $filtroDestino ORDER BY t_proyectos.id DESC";
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
                $status = $p['status'];
                $fila++;

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

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $destino);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $titulo);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $pda);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $nombreResponsable);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $fechaInicio);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $fechaFin);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $tipo);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $justificacion);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $coste);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $sMaterialx);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $sEnergeticox);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $sDepartamentox);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $sTrabajandox);
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_PROYECTOS_DEP_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }


    if ($action == "reporteProyectosDEPEtiquetados") {
        $idSubseccion = $_GET['idSubseccion'];
        $fila = 1;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Proyectos DEP");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'SECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'SUBSECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'ACTIVIDAD O EQUIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'DESCRIPCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'CREADO POR');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'ORIGÉN');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'RESPONSABLE');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'FECHA INICIO');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'FECHA FIN');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'COMENTARIOS');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'ADJUNTOS');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'ENERGÉTICOS');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'MATERIALES');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'DEPARTAMENTOS');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'TRABAJANDO');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'COOD2BEND');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', 'CODSAP');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', 'OT');

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
        WHERE t_mc.activo = 1 $filtroEtiqueta_FALLAS $filtroDestino_FALLAS";
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
                $fila++;

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

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $subseccion);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $descripcion);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, "FALLA");
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $responsable);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $fechaInicio);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $fechaFin);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $sEnergeticox);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $sMaterialx);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $sDepartamentox);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $sTrabajandox);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $cod2bend);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $fila, $codsap);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $fila, "F-$idFalla");
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
        WHERE t_mp_np.activo = 1 $filtroDestino_TAREAS $filtroEtiqueta_TAREAS";
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
                $fila++;

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

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $subseccion);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $descripcion);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, "TAREA");
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $responsable);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $fechaInicio);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $fechaFin);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $sEnergeticox);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $sMaterialx);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $sDepartamentox);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $sTrabajandox);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $cod2bend);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $fila, $codsap);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $fila, "T-$idTarea");
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
        WHERE t_proyectos_planaccion.activo = 1 $filtroDestino_PROYECTOS $filtroEtiqueta_PROYECTOS";
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
                $fila++;

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

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $subseccion);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $descripcion);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, "PROYECTO");
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $responsable);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $fechaInicio);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $fechaFin);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $sEnergeticox);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $sMaterialx);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $sDepartamentox);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $sTrabajandox);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $cod2bend);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $fila, $codsap);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $fila, "P-$idPlanaccion");
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
        WHERE t_mp_planificacion_iniciada.activo = 1 $filtroDestino_PREVENTIVOS $filtroEtiqueta_PREVENTIVOS";
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
                $fila++;

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

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $subseccion);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $descripcion);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, "PREVENTIVO");
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $responsable);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $fechaInicio);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $fechaFin);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $sEnergeticox);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $sMaterialx);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $sDepartamentox);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $sTrabajandox);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $cod2bend);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $fila, $codsap);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $fila, "MP-$idPreventivo");
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_PROYECTOS_ETIQUETADOS_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }
}
