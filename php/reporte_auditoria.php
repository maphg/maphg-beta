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
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'SECCIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'ACTIVIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'RESPONSABLE');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'STATUS');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ADJUNTOS');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'COMENTARIO');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'FECHA ALTA');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'FECHA CADUCIDAD');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'FEHCA SUBSANACIÓN');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'FASES');

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
s.seccion,
p.fase
FROM t_proyectos AS p
INNER JOIN c_destinos AS d ON p.id_destino = d.id
INNER JOIN c_secciones as s ON p.id_seccion = s.id
WHERE  p.titulo LIKE '%Auditoria%' and p.activo = 1 $filtroDestinos";

if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $x) {
        $filaPadre++;
        $filaHijo++;

        $idProyecto = $x['idProyecto'];

        $a = strtoupper($x['ubicacion']);
        $b = $x['proyecto'];
        $c = $x['seccion'];
        $l = $x['fase'];

        $query = "SELECT
        a.id idActividad,
        a.actividad,
        a.status,
        a.departamento_compras 'proveedor',
        a.departamento_direccion 'aprobado',
        a.fecha_alta fechaAlta,
        a.fecha_caducidad fechaCaducidad,
        a.fecha_subsanacion fechaSubsanacion,
        CONCAT(c.nombre, ' ', c.apellido) responsable
        FROM t_proyectos_planaccion AS a
        LEFT JOIN t_users AS u ON a.responsable = u.id
        LEFT JOIN t_colaboradores AS c ON u.id_colaborador = c.id  
        WHERE a.id_proyecto = $idProyecto and a.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $y) {
                $fila++;

                $idActividad = $y['idActividad'];
                $d = $y['actividad'];
                $e = $y['responsable'];

                #STATUS
                $f = $y['status'];
                $fTemp = "PROCESO";

                if (
                    $f['status'] == "F" ||
                    $f['status'] == "FINALIZADO" ||
                    $f['status'] == "SOLUCIONADO"
                )
                    $fTemp = "FINALIZADO";

                if ($f['proveedor'] == 1 && $fTemp == "PROCESO")
                    $fTemp = "P. PROVEEDOR";

                if ($f['aprobado'] == 1 && $fTemp == "PROCESO")
                    $fTemp = "P. APROBACION";


                $f = $fTemp;



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

                $i = $y['fechaAlta'];
                $j = $y['fechaCaducidad'];
                $k = $y['fechaSubsanacion'];

                #RESULTADOS
                $objPHPExcel->getActiveSheet()->setCellValue("A$fila", $a);
                $objPHPExcel->getActiveSheet()->setCellValue("B$fila", $b);
                $objPHPExcel->getActiveSheet()->setCellValue("C$fila", $c);
                $objPHPExcel->getActiveSheet()->setCellValue("D$fila", $d);
                $objPHPExcel->getActiveSheet()->setCellValue("E$fila", $e);
                $objPHPExcel->getActiveSheet()->setCellValue("F$fila", $f);
                $objPHPExcel->getActiveSheet()->setCellValue("G$fila", $g);
                $objPHPExcel->getActiveSheet()->setCellValue("H$fila", $h);
                $objPHPExcel->getActiveSheet()->setCellValue("I$fila", $i);
                $objPHPExcel->getActiveSheet()->setCellValue("J$fila", $j);
                $objPHPExcel->getActiveSheet()->setCellValue("K$fila", $k);
                $objPHPExcel->getActiveSheet()->setCellValue("L$fila", $l);
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
