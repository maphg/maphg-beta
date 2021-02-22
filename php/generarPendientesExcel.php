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

    //Inicio Tipo Tareas.
    if ($listaIdT != "") {
        $filtroT = "AND t_mp_np.id IN($listaIdT)";
    } else {
        $filtroT = "AND t_mp_np.id IN(0)";
    }



    // Titulos XLS
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte Fallas y Tareas");
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle("Reporte Incidencias");
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'OT');
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Destino');
    $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Sección');
    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Subsección');
    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Equipo - TG');
    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Título');
    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'Responsable');
    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Creado Por');
    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'U. Comentario');
    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'Comentario de:');
    $objPHPExcel->getActiveSheet()->setCellValue('K1', 'Tipo Incidencia');
    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'Material');
    $objPHPExcel->getActiveSheet()->setCellValue('M1', 'CODSAP');
    $objPHPExcel->getActiveSheet()->setCellValue('N1', 'COD2BEND');

    //FALLAS Generales
    $queryF = " SELECT t_mc.id, t_mc.status_material, t_mc.cod2bend, t_mc.codsap, t_mc.creado_por, c_destinos.destino, c_secciones.seccion, t_mc.tipo_incidencia, c_subsecciones.grupo, t_equipos_america.equipo, t_mc.actividad, t_colaboradores.nombre, t_colaboradores.apellido 
    FROM t_mc 
    INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id 
    INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id 
    INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id 
    LEFT JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id 
    LEFT JOIN t_users ON t_mc.responsable = t_users.id 
    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
    WHERE t_mc.activo = 1 $filtroF";
    //Fin Tipo de Pendiente es MC ahora -> Fallas.

    $fila = 2;
    if ($resultF = mysqli_query($conn_2020, $queryF)) {

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
            $cod2bendF = $row['cod2bend'];
            $tipoIncidencia = $row['tipo_incidencia'];

            if ($materialF == 1) {
                $materialF = "SI";
            } else {
                $materialF = "";
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
                $equipo = "INCIDENCIA";
            }


            $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, "F$idMC");
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $destino);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $seccion);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $subseccion);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $equipo);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $actividad);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $responsable);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $nombreCreadoF);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $comentario);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $realizoComentario);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $tipoIncidencia);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $materialF);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $codsapF);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $cod2bendF);

            //Contador de Celdas
            $fila++;
        }
    }


    //TAREAS Generales
    $queryT = "SELECT t_mp_np.id, t_mp_np.status_material, t_mp_np.codsap, t_mp_np.cod2bend, t_mp_np.id_usuario, t_mp_np.tipo_incidencia, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, 
    t_mp_np.titulo, t_colaboradores.nombre, t_colaboradores.apellido
    FROM t_mp_np
    INNER JOIN c_destinos ON t_mp_np.id_destino = c_destinos.id 
    INNER JOIN c_secciones ON t_mp_np.id_seccion = c_secciones.id
    INNER JOIN c_subsecciones ON t_mp_np.id_subseccion = c_subsecciones.id
    LEFT JOIN t_users ON t_mp_np.responsable = t_users.id 
    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
    WHERE t_mp_np.activo = 1 $filtroT";
    //Fin Tipo Tareas.
    if ($resulT = mysqli_query($conn_2020, $queryT)) {
        while ($x = mysqli_fetch_array($resulT)) {
            $idT = $x['id'];
            $destino = $x['destino'];
            $seccion = $x['seccion'];
            $subseccion = $x['grupo'];
            $equipo = "INCIDENCIA GENERAL";
            $titulo = $x['titulo'];
            $responsable = $x['nombre'] . " " . $x['apellido'];
            $creadoPorT = $x['id_usuario'];
            $materialT = $x['status_material'];
            $codsapT = $x['codsap'];
            $cod2bendT = $x['cod2bend'];
            $tipoIncidenciaT = $x['tipo_incidencia'];

            if ($materialT == 1) {
                $materialT = "SI";
            } else {
                $materialT = "";
            }

            $comentarioT = "";
            $comentarioDeT = "";
            $query = "SELECT comentarios_mp_np.comentario, 
            t_colaboradores.nombre, t_colaboradores.apellido 
            FROM comentarios_mp_np 
            INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id 
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE comentarios_mp_np.id_mp_np = $idT and comentarios_mp_np.activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $comentarioT = $x['comentario'];
                    $comentarioDeT = $x['nombre'] . " " . $x['apellido'];
                }
            }

            $nombreCreado = "";
            $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
            FROM t_users
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_users.id = $creadoPorT";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $nombreCreado = $x['nombre'] . " " . $x['apellido'];
                }
            }

            $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, "T$idT");
            $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $destino);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $seccion);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $subseccion);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $equipo);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $titulo);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $responsable);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $nombreCreado);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $comentarioT);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $comentarioDeT);
            $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $tipoIncidenciaT);
            $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $materialT);
            $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $codsapT);
            $objPHPExcel->getActiveSheet()->setCellValue('N' . $fila, $cod2bendT);

            //Contador de Celdas
            $fila++;
        }
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
    header('Content-Disposition: attachment;filename="Reporte_INCIDENCIAS ' . $nombreCompletoG . ' ' . $fecha . '.xlsx"');
    header('Cache-Control: max-age=0');
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save('PHP://output');
}
