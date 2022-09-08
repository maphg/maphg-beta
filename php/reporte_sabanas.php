<?php

include 'conexion.php';
require 'PHPExcel.php';

$fechaActual = date('Y-m-d H:m:s');
$array = array();

// HEAD EXCEL

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'HOTEL');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'HABITACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'SABANA');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'ID REGISTRO');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'FECHA REGISTRO - SABANA');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'FECHA REGISTRO - CAPTURA');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ACTIVIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'STATUS');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'REPORTADO');
$fila = 1;

// CONSULTA
$query = "SELECT h.hotel, e.equipo, s.sabana, r.id_publico, sa.fecha_creado 'fechaSabana', r.fecha_creado 'fechaCaptura', a.actividad, sa.valor, sa.reportado, sa.activo
FROM `t_sabanas_registros_capturas` AS sa
INNER JOIN t_sabanas_registros AS r ON sa.id_registro = r.id_publico
INNER JOIN t_sabanas_apartados_actividades AS a ON sa.id_actividad = a.id_publico
INNER JOIN t_sabanas AS s ON r.id_sabana = s.id_publico
INNER JOIN t_sabanas_equipos AS e ON r.id_equipo = e.id_equipo
INNER JOIN t_sabanas_hoteles AS h ON e.id_hotel = h.id
WHERE r.activo = 1 and r.fecha_finalizado > '01-01-2020'
ORDER BY sa.id_privado";

if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $x) {
        $fila++;
        $a = $x['hotel'];
        $b = $x['equipo'];
        $c = $x['sabana'];
        $d = $x['id_publico'];
        $e = $x['fechaSabana'];
        $f = $x['fechaCaptura'];
        $g = $x['actividad'];
        $h = $x['valor'];
        $i = $x['reportado'];

        $objPHPExcel->getActiveSheet()->setCellValue("A$fila", $a);
        $objPHPExcel->getActiveSheet()->setCellValue("B$fila", $b);
        $objPHPExcel->getActiveSheet()->setCellValue("C$fila", $c);
        $objPHPExcel->getActiveSheet()->setCellValue("D$fila", $d);
        $objPHPExcel->getActiveSheet()->setCellValue("E$fila", $e);
        $objPHPExcel->getActiveSheet()->setCellValue("F$fila", $f);
        $objPHPExcel->getActiveSheet()->setCellValue("G$fila", $g);
        $objPHPExcel->getActiveSheet()->setCellValue("H$fila", $h);
        $objPHPExcel->getActiveSheet()->setCellValue("I$fila", $i);
    }
}


// EXPORTAR EXCEL
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_' . $fechaActual . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
