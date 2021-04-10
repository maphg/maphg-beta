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
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID EQUIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'EQUIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'LOCAL/EQUIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'FALLAS S');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'FALLAS P');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'PREVENTIVO S');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'PREVENTIVO P');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'ULTIMO MP');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'PROXIMO MP');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'TAREAS S');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'TAREAS P');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'TEST');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'ULTOMO TEST');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'COT');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'PICS');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'COMENTS');
        $objPHPExcel->getActiveSheet()->setCellValue('R1', 'DESPIECE');
        $objPHPExcel->getActiveSheet()->setCellValue('S1', 'JERARQUIA');
        $objPHPExcel->getActiveSheet()->setCellValue('T1', 'STATUS');

        if ($idDestino == 10) {
            $filtroDestinoEquipo = "";
        } else {
            $filtroDestinoEquipo = "and t_equipos_america.id_destino = $idDestino";
        }

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, 
        t_equipos_america.local_equipo, t_equipos_america.status, t_equipos_america.jerarquia
        FROM t_equipos_america
        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 $filtroDestinoEquipo";
        if ($resultEquipo = mysqli_query($conn_2020, $query)) {
            foreach ($resultEquipo as $x) {
                $idEquipo = $x['id'];
                $equipo = $x['equipo'];
                $statusEquipo = $x['status'];
                $jerarquia = $x['jerarquia'];
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

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $idEquipo);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $tipoEquipo);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $statusEquipo);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $fallasSolucionadas);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $fallasPendientes);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $mpS);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $mpP);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $ultimoMpFecha);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $proximoMpFecha);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $tareasSolucionadas);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $tareasPendientes);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $testR);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $ultimoTestFecha);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $totalCotizaciones);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $fila, $totalDespiece);
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $fila, $jerarquia);
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $fila, $statusEquipo);
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
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'STATUS EP');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'EMPRESA RESPONSABLE EJECUCIÓN');

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
            t_mc.departamento_rrhh,
            t_mc.status_ep,
            t_mc.responsable_empresa
            FROM t_mc 
            LEFT JOIN t_users ON t_mc.creado_por = t_users.id
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_mc.id_equipo = $idEquipo and t_mc.activo = 1
            ORDER BY t_mc.id DESC";
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
                $sEP = $x['status_ep'];
                $idEmpresa = $x['responsable_empresa'];
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

                #STATUS EP
                if ($sEP == 1) {
                    $sEP = "SI";
                } else {
                    $sEP = "";
                }

                #EMPRESA RESPONSABLE
                $empresa = "";
                $query = "SELECT empresa FROM t_empresas_responsables WHERE id = $idEmpresa";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $empresa = $x['empresa'];
                    }
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
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, "INCIDENCIAS");
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, "F" . $idFalla);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $totalComentarios);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $totalAdjuntos);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $sEP);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $empresa);
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_FALLAS_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }


    // EXPORTA GASTOS MATERIALES EN GASTOS.PHP
    if ($action == "exportarExcelGastos") {
        $fila = 1;

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Materiales");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'FECHA');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'CECO');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'ASIGNACIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'DESCRIPCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'PROVEEDOR AF');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'IMPORTE');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'CUENTA MAYOR');

        $query = "SELECT* FROM t_compras_america_materiales 
            WHERE activo = 1 and id_destino = $idDestino";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {

                $fecha = $x['fecha_contabilizacion'];
                $cc = $x['centro_coste'];
                $asignacion = $x['asignacion'];
                $textoCeco = $x['texto_ceco'];
                $nombre_1 = $x['nombre_cuenta'];
                $texto = $x['texto'];
                $importe = $x['importe_usd'];
                $nombreProveedorAF = $x['nombre_proveedor'];
                $documentoCompras = $x['documento_compras'];
                $fila++;

                // $arrayTemp = array(
                //     "fecha" => $fecha,
                //     "importe" => $importe,
                //     "cc" => $cc,
                //     "asignacion" => $asignacion,
                //     "texto" => $texto,
                //     "nombreProveedorAF" => $nombreProveedorAF,
                //     "nombre_1" => $nombre_1,
                //     "documentoCompras" => $documentoCompras,
                //     "textoCeco" => $textoCeco
                // );
                // $array[] = $arrayTemp;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $fecha);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $textoCeco);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $asignacion);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $texto);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $nombreProveedorAF);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, '$' + $importe);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $nombre_1);
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_MATERIALES_' . $fechaActual . '.xlsx"');
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
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'STATUS EP');
        $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'EMPRESA RESPONSABLE EJECUCIÓN');

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
        t_mp_np.departamento_rrhh, 
        t_mp_np.status_ep,
        t_mp_np.responsable_empresa
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
                $sEP = $x['status_ep'];
                $idEmpresa = $x['responsable_empresa'];
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

                if ($sEP == 1) {
                    $sEP = "SI";
                } else {
                    $sEP = "";
                }


                #EMPRESA RESPONSABLE
                $empresa = "";
                $query = "SELECT empresa FROM t_empresas_responsables WHERE id = $idEmpresa";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $empresa = $x['empresa'];
                    }
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
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $sEP);
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, $empresa);
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
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'JUSTIFICACIÓN');
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


    if ($action == "reporteGestionEquipos") {
        $filtroDestino = intval($_GET['filtroDestino']);
        $filtroSeccion = intval($_GET['filtroSeccion']);
        $filtroSubseccion = intval($_GET['filtroSubseccion']);
        $filtroTipo = $_GET['filtroTipo'];
        $filtroStatus = $_GET['filtroStatus'];
        $filtroSemana = $_GET['filtroSemana'];
        $filtroPalabra = $_GET['filtroPalabra'];
        $array = array();
        $fila = 1;

        if ($filtroDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_equipos_america.id_destino = $filtroDestino";
        }

        if ($filtroTipo > 0) {
            $filtroTipo = "and t_equipos_america.id_tipo = '$filtroTipo'";
        } else {
            $filtroTipo = "";
        }

        if ($filtroStatus != "") {
            $filtroStatus = "and t_equipos_america.status = '$filtroStatus'";
        } else {
            $filtroStatus = "";
        }

        if ($filtroSeccion > 0) {
            $filtroSeccion = "and t_equipos_america.id_seccion = $filtroSeccion";
        } else {
            $filtroSeccion = "";
        }

        if ($filtroSubseccion > 0) {
            $filtroSubseccion = "and t_equipos_america.id_subseccion = $filtroSubseccion";
        } else {
            $filtroSubseccion = "";
        }

        if ($filtroPalabra == "") {
            $filtroPalabra = "";
        } else {
            $filtroPalabra = "and (t_equipos_america.equipo LIKE '%$filtroPalabra%')";
        }


        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte EQUIPOS");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID EQUIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'ID EQUIPO PADRE');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'DESTINO');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'EQUIPO PADRE');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'EQUIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'SECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'SUBSECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'FASE');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'ID TIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'TIPO');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'MARCA');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'MODELO');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'EQUIPO / LOCAL');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'UBICACIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', 'PROMIXO MP');

        $query = "SELECT t_equipos_america.id, t_equipos_america.id_equipo_principal, t_equipos_america.equipo, t_equipos_america.local_equipo, t_equipos_america.modelo, t_equipos_america.status, t_equipos_america.id_fases,
        c_secciones.seccion, c_subsecciones.grupo, c_tipos.id 'id_tipo', c_tipos.tipo, c_marcas.marca, c_ubicaciones.ubicacion, 
        c_destinos.destino
        FROM t_equipos_america
        LEFT JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        LEFT JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        LEFT JOIN c_tipos ON t_equipos_america.id_tipo = c_tipos.id
        LEFT JOIN c_marcas ON t_equipos_america.id_marca = c_marcas.id
        LEFT JOIN c_ubicaciones ON t_equipos_america.id_ubicacion = c_ubicaciones.id
        LEFT JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
        WHERE t_equipos_america.activo = 1 and t_equipos_america.status IN('OPERATIVO', 'TALLER')
        $filtroDestino $filtroSeccion  $filtroSubseccion $filtroTipo $filtroStatus $filtroPalabra";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $equipo = $i['equipo'];
                $idEquipoPrincipal = $i['id_equipo_principal'];
                $local_equipo = $i['local_equipo'];
                $status = $i['status'];
                $seccion = $i['seccion'];
                $subseccion = $i['grupo'];
                $idTipo = $i['id_tipo'];
                $tipo = $i['tipo'];
                $marca = $i['marca'];
                $ubicacion = $i['ubicacion'];
                $modelo = $i['modelo'];
                $idFases = $i['id_fases'];
                $destino = $i['destino'];
                $resultx = array();
                $fila++;

                // Contadores para Resumen MP
                $contadorPlanificado = 0;
                $contadorProceso = 0;
                $contadorSolucionado = 0;

                if ($filtroSemana <= 0 || $filtroSemana == "") {
                    $mp = "SELECT* FROM t_mp_planeacion_proceso WHERE id_equipo = $id AND activo = 1 AND año = '$añoActual'";
                    if ($result = mysqli_query($conn_2020, $mp)) {

                        foreach ($result as $x) {
                            for ($i = $semanaActual; $i < 53; $i++) {
                                $semana = $x['semana_' . $i];
                                if ($semana == "PROCESO") {
                                    $proximoMP = $i;
                                    $resultx[] = $proximoMP;
                                    $i = 52;
                                }
                            }
                        }

                        foreach ($result as $x) {
                            // Resumen MP
                            for ($i = 1; $i < 52; $i++) {
                                $semana = $x['semana_' . $i];
                                if ($semana == "PROCESO") {
                                    $contadorProceso++;
                                }
                                if ($semana == "SOLUCIONADO") {
                                    $contadorSolucionado++;
                                }
                            }
                        }
                    }

                    $mp = "SELECT* FROM t_mp_planeacion_semana WHERE id_equipo = $id AND activo = 1 AND año = '$añoActual'";
                    if ($result = mysqli_query($conn_2020, $mp)) {
                        foreach ($result as $x) {
                            for ($i = $semanaActual; $i < 53; $i++) {
                                $semana = $x['semana_' . $i];
                                if ($semana == "PLANIFICADO") {
                                    $proximoMP = $i;
                                    $resultx[] = $proximoMP;
                                    $i = 52;
                                }
                            }
                        }

                        foreach ($result as $x) {
                            for ($i = 1; $i < 53; $i++) {
                                $semana = $x['semana_' . $i];
                                if ($semana == "PLANIFICADO") {
                                    $contadorPlanificado++;
                                }
                            }
                        }
                    }
                } else {
                    $filtroSemana = intval($filtroSemana);
                    $mp = "SELECT semana_$filtroSemana FROM t_mp_planeacion_proceso WHERE id_equipo = $id AND activo = 1 AND año = '$añoActual'";
                    if ($result = mysqli_query($conn_2020, $mp)) {

                        foreach ($result as $x) {
                            $semana = $x['semana_' . $filtroSemana];
                            if ($semana == "PROCESO") {
                                $resultx[] = $filtroSemana;
                            }
                        }

                        foreach ($result as $x) {
                            // Resumen MP
                            $semana = $x['semana_' . $filtroSemana];
                            if ($semana == "PROCESO") {
                                $contadorProceso++;
                            }
                            if ($semana == "SOLUCIONADO") {
                                $contadorSolucionado++;
                            }
                        }
                    }

                    $mp = "SELECT semana_$filtroSemana FROM t_mp_planeacion_semana WHERE id_equipo = $id AND activo = 1 AND año = '$añoActual'";
                    if ($result = mysqli_query($conn_2020, $mp)) {
                        foreach ($result as $x) {
                            $semana = $x['semana_' . $filtroSemana];
                            if ($semana == "PLANIFICADO") {
                                $resultx[] = $filtroSemana;
                            }
                        }

                        foreach ($result as $x) {
                            $semana = $x['semana_' . $filtroSemana];
                            if ($semana == "PLANIFICADO") {
                                $contadorPlanificado++;
                            }
                        }
                    }
                }

                $resuly = array_count_values($resultx);
                $xc = "";
                foreach ($resuly as $key => $value) {
                    if ($value > 1) {
                        $xc .= " " . $key . "(" . $value . ") ";
                    } else {
                        $xc .= " " . $key;
                    }
                }


                $fase = "NO ASIGNADO";
                $fases = "SELECT fase FROM c_fases WHERE id IN($idFases)";
                if ($result = mysqli_query($conn_2020, $fases)) {
                    foreach ($result as $i) {
                        $fase .= $i['fase'] . " ";
                    }
                }

                $equipoPadre = "";
                $query = "SELECT equipo FROM t_equipos_america WHERE id = $idEquipoPrincipal";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $equipoPadre = $x['equipo'];
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $idEquipoPrincipal);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $destino);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $equipoPadre);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $subseccion);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $fase);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $idTipo);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $tipo);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $marca);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $modelo);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $local_equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $ubicacion);
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, $xc);
            }
        }
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_EQUIPOS_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }


    // EXPORTA ITEMS DE stock.php 
    if ($action == "reporteItems") {
        $fila = 1;

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_stock_items.id_destino = $idDestino";
        }

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte STOCK");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'DESTINO');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'COD2BEND');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'DESCRIPCIÓN COD2BEND');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'DESCRIPCIÓN SSTT');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'SECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'ÁREA');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'CATEGORIA');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'STOCK TEORICO');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'STOCK REAL');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'MARCA');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'MODELO');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'CARACTERISTICAS');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', 'SUBFAMILIA');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', 'SUBALMACÉN');

        $query = "SELECT t_stock_items.id, t_stock_items.cod2bend, 
        t_stock_items.descripcion_cod2bend, t_stock_items.descripcion_sstt, t_stock_items.area, t_stock_items.categoria, t_stock_items.stock_teorico, t_stock_items.stock_real, t_stock_items.marca, t_stock_items.modelo, t_stock_items.caracteristicas, 
        t_stock_items.subfamilia, t_stock_items.subalmacen, t_stock_items.activo, 
        c_destinos.destino, c_secciones.seccion
        FROM t_stock_items
        INNER JOIN c_destinos ON t_stock_items.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_stock_items.id_seccion = c_secciones.id
        WHERE t_stock_items.activo = 1 $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $cod2bend = $x['cod2bend'];
                $descripcion_cod2bend = $x['descripcion_cod2bend'];
                $descripcion_sstt = $x['descripcion_sstt'];
                $area = $x['area'];
                $categoria = $x['categoria'];
                $stock_teorico = $x['stock_teorico'];
                $stock_real = $x['stock_real'];
                $marca = $x['marca'];
                $modelo = $x['modelo'];
                $caracteristicas = $x['caracteristicas'];
                $subfamilia = $x['subfamilia'];
                $subalmacen = $x['subalmacen'];
                $activo = $x['activo'];
                $destino = $x['destino'];
                $seccion = $x['seccion'];
                $fila++;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, intval($idItem));
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $destino);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $cod2bend);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $descripcion_cod2bend);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $descripcion_sstt);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $area);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $categoria);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $stock_teorico);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $stock_real);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $marca);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $modelo);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $caracteristicas);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $subfamilia);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, $subalmacen);
            }
        }

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_STOCK_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }


    if ($action == "reporteIncidencia") {
        $filtroPalabra = $_GET['filtroPalabra'];
        $filtroResponsable = $_GET['filtroResponsable'];
        $filtroSeccion = $_GET['filtroSeccion'];
        $filtroSubseccion = $_GET['filtroSubseccion'];
        $filtroTipo = $_GET['filtroTipo'];
        $filtroTipoIncidencia = $_GET['filtroTipoIncidencia'];
        $filtroStatus = $_GET['filtroStatus'];
        $filtroStatusIncidencia = $_GET['filtroStatusIncidencia'];
        $filtroFecha = $_GET['filtroFecha'];

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
            $fechaInicio = strtotime($_GET['filtroFechaInicio']);
            $fechaFin = strtotime($_GET['filtroFechaFin']);

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


        #CABECERAS DE EXCEL
        $fila = 1;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Incidencias");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'DESTINO');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'SECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'SUBSECCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'CREADO POR');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'RESPONSABLE');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'ACTIVIDAD');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'EQUIPO / LOCAL');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'STATUS');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'ULTIMO COMENTARIO');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'FECHA CREADO');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'FECHA FINALIZADO');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', 'STATUS EP');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'EMPRESA RESPONSABLE EJECUCIÓN');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '');
        $objPHPExcel->getActiveSheet()->setCellValue('O1', '');
        $objPHPExcel->getActiveSheet()->setCellValue('P1', '');
        #CABECERAS DE EXCEL

        #INCIDENCIAS
        $query = "SELECT t_mc.id, t_mc.actividad, t_mc.status, t_mc.rango_fecha, t_mc.tipo_incidencia,
        t_mc.creado_por, t_mc.responsable,
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
        c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, t_equipos_america.equipo, 
        t_mc.fecha_creacion, t_mc.fecha_realizado, t_mc.responsable_empresa
        FROM t_mc
        INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id
        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
        WHERE t_mc.activo = 1 and t_mc.id_equipo > 0 $filtroDestino $filtroPalabraIncidencias $filtroResponsableIncidencias $filtroSeccionIncidencias $filtroSubseccionIncidencias $filtroTipoIncidenciaIncidencias $filtroTipoIncidencias $filtroStatusIncidencias $filtroFechaIncidencias $filtroStatusIncidenciaIncidencias
        ORDER BY t_mc.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idItem = $x['id'];
                $idCreadoPor = $x['creado_por'];
                $idResponsable = $x['responsable'];
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
                $destino = $x['destino'];
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $equipo = $x['equipo'];
                $fechaCreacion = $x['fecha_creacion'];
                $fechaFinalizado = $x['fecha_realizado'];
                $sEP = $x['status_ep'];
                $idEmpresa = $x['responsable_empresa'];
                $fila++;

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

                #RESPONSABLE
                $responsable = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
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

                if ($sEP == 1) {
                    $sEP = "SI";
                } else {
                    $sEP = "";
                }

                #EMPRESA RESPONSABLE
                $empresa = "";
                $query = "SELECT empresa FROM t_empresas_responsables WHERE id = $idEmpresa";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $empresa = $x['empresa'];
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $destino);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $subseccion);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $responsable);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $titulo);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $equipo);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $comentario);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $fechaCreacion);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $fechaFinalizado);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $sEP);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $empresa);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $fila, '');
            }
        }

        #GENERAL
        $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.status, t_mp_np.rango_fecha, t_mp_np.tipo_incidencia,
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
        t_mp_np.status_ep,
        t_mp_np.fecha,
        t_mp_np.fecha_finalizado,
        t_mp_np.responsable_empresa,
        t_mp_np.responsable,
        c_destinos.destino,
        c_secciones.seccion,
        c_subsecciones.grupo
        FROM t_mp_np
        INNER JOIN c_destinos ON t_mp_np.id_destino = c_destinos.id
        INNER JOIN c_secciones ON t_mp_np.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_mp_np.id_subseccion = c_subsecciones.id
        WHERE t_mp_np.activo = 1 and t_mp_np.id_equipo = 0
        $filtroDestino_General $filtroPalabra_General $filtroResponsable_General $filtroSeccion_General $filtroSubseccion_General $filtroTipoIncidencia_General $filtroTipo_General $filtroStatus_General $filtroFecha_General $filtroStatusIncidencia_General ORDER BY t_mp_np.id ASC";
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
                $idResponsable = $x['responsable'];
                $fechaCreacion = $x['fecha'];
                $fechaFinalizado = $x['fecha_finalizado'];
                $destino = $x['destino'];
                $seccion = $x['seccion'];
                $subseccion = $x['grupo'];
                $idEmpresa = $x['responsable_empresa'];
                $fila++;

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

                #RESPONSABLE
                $responsable = "";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
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
                        $ComentarioDe = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                    }
                }

                #DOCUMENTOS
                $totalAdjuntos = 0;
                $query = "SELECT count(id) 'total' FROM adjuntos_mp_np 
                WHERE id_mp_np = $idItem and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAdjuntos = $x['total'];
                    }
                }

                #EMPRESA RESPONSABLE
                $empresa = "";
                $query = "SELECT empresa FROM t_empresas_responsables WHERE id = $idEmpresa";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $empresa = $x['empresa'];
                    }
                }

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $destino);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $seccion);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $subseccion);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $creadoPor);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $responsable);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $titulo);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, 'INCIDENCIA DEL ÁREA');
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $status);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $comentario);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $fechaCreacion);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $fechaFinalizado);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $sEP);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $empresa);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('P' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('Q' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('R' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('S' . $fila, '');
                $objPHPExcel->getActiveSheet()->setCellValue('T' . $fila, '');
            }
        }

        // GENERA EL EXCEL
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_Incidencias_' . $fechaActual . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }
}
