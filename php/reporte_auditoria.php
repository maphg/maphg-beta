<?php
include 'conexion.php';
require 'PHPExcel.php';

$fechaActual = date('Y-m-d H:m:s');
$array = array();
$idDestino = intval($_GET['idDestino']);

// HEAD EXCEL
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'DESTINO');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'PROYECTO');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'ACTIVIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'STATUS');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'ADJUNTOS');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'COMENTARIO');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'FECHA ALTA');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'FECHA CADUCIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'FEHCA SUBSANACIÓN');

$fila = 1;
$filaPadre = 1;
$filaHijo = 2;

$filtroDestinos = "id_destino = 0";

if ($idDestino == 10)
    $filtroDestinos = "";
else
    $filtroDestinos = "and p.id_destino = $idDestino";


// CONSULTA
$query = "SELECT
p.id idProyecto,
p.titulo proyecto,
p.activo,
d.ubicacion,
s.seccion
FROM t_proyectos AS p
INNER JOIN c_destinos AS d ON p.id_destino = d.id
INNER JOIN c_secciones as s ON p.id_seccion = s.id
WHERE  p.titulo LIKE '%Auditoria Propco%' and p.activo = 1 $filtroDestinos";

if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $x) {
        $fila++;
        $filaPadre++;
        $filaHijo++;

        $idProyecto = $x['idProyecto'];

        $a = strtoupper($x['ubicacion']);
        $b = $x['proyecto'];
        $c = $x['seccion'];

        $query = "SELECT
        a.id idActividad,
        a.actividad,
        a.status,
        a.fecha_alta fechaAlta,
        a.fecha_caducidad fechaCaducidad,
        a.fecha_subsanacion fechaSubsanacion,
        CONCAT(c.nombre, ' ', c.apellido) responsable
        FROM t_proyectos_planaccion AS a
        INNER JOIN t_users AS u ON a.responsable = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id  
        WHERE a.id_proyecto = $idProyecto and a.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $y) {
                $idActividad = $y['idActividad'];
                $d = $y['actividad'];
                $e = $y['responsable'];

                #STATUS
                $f = $y['status'];
                if ($f == "F" || $f = "SOLUCIONADO" || $f == "S")
                    $f = "FINALIZADO";
                else
                    $f = "PROCESO";

                #COMENTARIO
                $g = 0;
                $query = "SELECT id FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $idActividad and activo = 1";
                if ($result = mysqli_query($conn_2020, $query))
                    $g = mysqli_num_rows($result);

                #ADJUNTOS
                $h = 0;
                $query = "SELECT id FROM t_proyectos_planaccion_adjuntos
                WHERE id_actividad = $idActividad and status = 1";
                if ($result = mysqli_query($conn_2020, $query))
                    $h = mysqli_num_rows($result);

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
    }
}

// EXPORTAR EXCEL
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_' . $fechaActual . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');