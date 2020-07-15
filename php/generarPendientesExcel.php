<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';

$fecha = date('Y-m-d H:m:s');
if (isset($_GET['listaIdMC'])) {
    $listaIdMC = $_GET['listaIdMC'];

    if ($listaIdMC != "") {
        $filtroMC = "AND t_mc.id IN($listaIdMC)";
    } else {
        $filtroMC = "AND t_mc.id IN(0)";
    }



    //Correctivos Generales.
    $query = "SELECT t_mc.id, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, t_equipos.equipo, t_mc.actividad, t_colaboradores.nombre, t_colaboradores.apellido 
    FROM t_mc 
    INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id 
    INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id 
    INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id 
    LEFT JOIN t_equipos ON t_mc.id_equipo = t_equipos.id 
    LEFT JOIN t_users ON t_mc.responsable = t_users.id 
    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
    WHERE t_mc.activo = 1 $filtroMC;
    ";


    if ($result = mysqli_query($conn_2020, $query)) {

        // Titulos XLS
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle("Reporte MC y TG");
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Destino');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Sección');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Subsección');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'Equipo - TG');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', 'Título');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'Responsable');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'U. Comentario');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', 'Comentario de:');


        $fila = 2;
        while ($row = mysqli_fetch_array($result)) {
            $idMC = $row['id'];
            $destino = $row['destino'];
            $seccion = $row['seccion'];
            $subseccion = $row['grupo'];
            $equipo = $row['equipo'];
            $actividad = $row['actividad'];
            $responsable = $row['nombre'] . " " . $row['apellido'];

            $queryComentario = "SELECT t_mc_comentarios.comentario, t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_mc_comentarios 
            INNER JOIN t_users ON t_mc_comentarios.id_usuario = t_users.id
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_mc_comentarios.id_mc = $idMC 
            ORDER BY t_mc_comentarios.fecha DESC LIMIT 1";

            $resultComentaio = mysqli_query($conn_2020, $queryComentario);
            if ($rowComentario = mysqli_fetch_array($resultComentaio)) {
                $comentario = $rowComentario['comentario'];
                $realizoComentario = $rowComentario['nombre'] . " " . $rowComentario['apellido'];
            } else {
                $realizoComentario = "";
                $comentario = "";
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
            $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $comentario);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $realizoComentario);

            //Contador de Celdas
            $fila++;
        }

        $fecha = date('d-m-Y H:m:s');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment;filename="Reporte_Pendientes_' . $fecha . '.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save('PHP://output');
    }
}