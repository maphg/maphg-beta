<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';

$fecha = date('Y-m-d H:m:s');
if (isset($_GET['listaIdF']) and isset($_GET['listaIdT']) and isset($_GET['generadoPor'])) {
    // Variables Principales.
    $listaIdF = $_GET['listaIdF'];
    $listaIdT = $_GET['listaIdT'];
    $generadoPor = $_GET['generadoPor'];

    //Inicio Tipo de Pendiente es MC ahora -> Fallas.
    if ($listaIdF != "") {
        $filtroF = "AND t_mc.id IN($listaIdF)";
    } else {
        $filtroF = "AND t_mc.id IN(0)";
    }

    //FALLAS Generales
    $queryF = "
        SELECT t_mc.id, t_mc.status_material, t_mc.codsap, t_mc.creado_por, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, t_equipos.equipo, t_mc.actividad, t_colaboradores.nombre, t_colaboradores.apellido 
        FROM t_mc 
        INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id 
        INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id 
        INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id 
        LEFT JOIN t_equipos ON t_mc.id_equipo = t_equipos.id 
        LEFT JOIN t_users ON t_mc.responsable = t_users.id 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
        WHERE t_mc.activo = 1 $filtroF
    ";
    //Fin Tipo de Pendiente es MC ahora -> Fallas.

    //Inicio Tipo Tareas.
    if ($listaIdT != "") {
        $filtroT = "AND t_mp_np.id IN($listaIdT)";
    } else {
        $filtroT = "AND t_mp_np.id IN(0)";
    }

    //TAREAS Generales
    $queryT = "SELECT t_mp_np.id, t_mp_np.status_material, t_mc.codsap, t_mp_np.id_usuario, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, t_equipos.equipo, t_mp_np.titulo,  t_mp_np.titulo, t_colaboradores.nombre, t_colaboradores.apellido
    FROM t_mp_np
    INNER JOIN c_destinos ON t_mp_np.id_destino = c_destinos.id 
    INNER JOIN t_equipos ON t_mp_np.id_equipo = t_equipos.id
    INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
    INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id
    -- id_usuario, hace referencia quíen lo Creo.
    INNER JOIN t_users ON t_mp_np.responsable = t_users.id 
    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
    WHERE t_mp_np.activo = 1 $filtroT
    ";
    //Fin Tipo Tareas.


    if ($resultF = mysqli_query($conn_2020, $queryF) and $resulT = mysqli_query($conn_2020, $queryT)) {

        // Titulos XLS
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte Fallas y Tareas");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte Fallas y Tareas");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Destino');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sección');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Subsección');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Equipo - TG');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Título');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Responsable');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Creado Por');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'U. Comentario');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', 'Comentario de:');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Tipo Pendiente');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Material');

        $fila = 2;
        while ($row = mysqli_fetch_array($resultF)) {
            $idMC = $row['id'];
            $destino = $row['destino'];
            $seccion = $row['seccion'];
            $subseccion = $row['grupo'];
            $equipo = $row['equipo'];
            $actividad = $row['actividad'];
            $responsable = $row['nombre'] . " " . $row['apellido'];
            $creadoPorF = $row['creado_por'];
            $materialF = $row['status_material'];
            $codsapF = $row['codsap'];

            if ($materialF != "" and $materialF != "0") {
                $materialF = "SI";
                $codsapF = $codsap;
            } else {
                $materialF = "";
                $codsapF = "";
            }

            $queryComentario = "SELECT t_mc_comentarios.comentario, t_colaboradores.nombre, 
                t_colaboradores.apellido
                FROM t_mc_comentarios 
                INNER JOIN t_users ON t_mc_comentarios.id_usuario = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_mc_comentarios.id_mc = $idMC 
                ORDER BY t_mc_comentarios.fecha DESC LIMIT 1";

            $resultComentario = mysqli_query($conn_2020, $queryComentario);
            if ($rowComentario = mysqli_fetch_array($resultComentario)) {
                $comentario = $rowComentario['comentario'];
                $realizoComentario = $rowComentario['nombre'] . " " . $rowComentario['apellido'];
            } else {
                $realizoComentario = "";
                $comentario = "";
            }

            $queryCreadoF = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
            FROM t_users
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_users.id = $creadoPorF";
            if ($resultCreadoF = mysqli_query($conn_2020, $queryCreadoF)) {
                if ($rowCreadoF = mysqli_fetch_array($resultCreadoF)) {
                    $nombreCreadoF = $rowCreadoF['nombre'] . " " . $rowCreadoF['apellido'];
                } else {
                    $nombreCreadoF = "";
                }
            } else {
                $nombreCreadoF = "";
            }

            if ($equipo == "") {
                $equipo = "Tarea General";
            }


            $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $destino);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $seccion);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $subseccion);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $equipo);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $actividad);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $responsable);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $nombreCreadoF);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $comentario);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $realizoComentario);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, 'Fallas');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $materialF);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $codsapF);

            //Contador de Celdas
            $fila++;
        }

        while ($rowT = mysqli_fetch_array($resulT)) {
            $idT = $rowT['id'];
            $destino = $rowT['destino'];
            $seccion = $rowT['seccion'];
            $subseccion = $rowT['grupo'];
            $equipo = $rowT['equipo'];
            $titulo = $rowT['titulo'];
            $responsable = $rowT['nombre'] . " " . $rowT['apellido'];
            $creadoPorT = $rowT['id_usuario'];
            $materialT = $row['status_material'];
            $codsapT = $row['codsap'];

            if ($materialT != "" and $materialT != "0") {
                $materialT = "SI";
                $codsapT = $codsap;
            } else {
                $materialT = "";
                $codsapT = "";
            }

            $queryComentarioT = "SELECT comentario.comentarios_mp_np, 
            t_colaboradores.nombre, t_colaboradores.apellido 
            FROM comentarios_mp_np 
            INNER JOIN t_users ON t_mp_np.id_usuario = t_users.id 
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE id_mp_np = $idT AND activo = 1";
            if ($resultComentarioT = mysqli_query($conn_2020, $queryComentarioT)) {
                if ($rowComentarioT = mysqli_fetch_array($resultComentarioT)) {
                    $comentarioT = $rowComentarioT['comentario'];
                    $comentarioDeT = $rowComentarioT['nombre'] . "" . $rowComentarioT['apellido'];
                } else {
                    $comentarioT = "";
                    $comentarioDeT = "";
                }
            } else {
                $comentarioT = "";
                $comentarioDeT = "";
            }

            $queryCreadoT = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
            FROM t_users
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_users.id = $creadoPorT";
            if ($resultCreadoT = mysqli_query($conn_2020, $queryCreadoT)) {
                if ($rowCreadoT = mysqli_fetch_array($resultCreadoT)) {
                    $nombreCreado = $rowCreadoT['nombre'] . " " . $rowCreadoT['apellido'];
                } else {
                    $nombreCreado = "";
                }
            } else {
                $nombreCreado = "";
            }

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $destino);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $seccion);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $subseccion);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $equipo);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $titulo);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $responsable);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $nombreCreado);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $comentarioT);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $comentarioDeT);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, 'Tareas');
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $materialT);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $codsapT);

            //Contador de Celdas
            $fila++;
        }

        // Busca el Nombre Completo de quien Genero el Reporte.
        $queryGenerado = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.id = $generadoPor";
        if ($resultGenerado = mysqli_query($conn_2020, $queryGenerado)) {
            if ($rowGenerado = mysqli_fetch_array($resultGenerado)) {
                $nombreCompletoG = $rowGenerado['nombre'] . " " . $rowGenerado['apellido'];
            } else {
                $nombreCompletoG = "";
            }
        } else {
            $nombreCompletoG = "";
        }
        $fecha = date('d-m-Y H:m:s');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_FallasYTareas ' . $nombreCompletoG . ' ' . $fecha . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }
}
