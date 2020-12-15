<?php
include 'conexion.php';
require 'PHPExcel.php';
$array = array();
$fila = 1;

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte MP");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'DESTINO');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'SECCION');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'SUBSECCION');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'EQUIPO');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'FOLIO');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'ACTIVIDADES');

$query = "SELECT t_ordenes_trabajo.id, t_ordenes_trabajo.folio, t_ordenes_trabajo.lista_actividades_realizadas, t_equipos.equipo, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo
FROM t_ordenes_trabajo
INNER JOIN t_equipos ON t_ordenes_trabajo.id_equipo = t_equipos.id
INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id
INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id
WHERE t_equipos.id_destino = 1 and t_equipos.id_seccion IN (8, 9, 10, 11, 12) and t_equipos.id_subseccion";
if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $x) {
        $fila++;
        $idMP = $x["id"];
        $destino = $x["destino"];
        $seccion = $x["seccion"];
        $subseccion = $x["grupo"];
        $folio = $x["folio"];
        $equipo = $x["equipo"];
        $idActividades = $x["lista_actividades_realizadas"];
        $list = preg_replace('([^A-Za-z0-9 ,])', '', $idActividades);

        $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $idMP);
        $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $destino);
        $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $seccion);
        $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $subseccion);
        $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $equipo);
        $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $folio);

        $actividades = array();
        if ($list != null  and $list != "") {
            $query = "SELECT actividad FROM t_planes_actividades WHERE id IN($list)";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $fila++;
                    $actividad = $x['actividad'];
                    $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $actividad);
                    $actividades[] = $actividad;
                }
            }
        }

        $array[] = array(
            "idMP" => $idMP,
            "destino" => $destino,
            "seccion" => $seccion,
            "subseccion" => $subseccion,
            "equipo" => $equipo,
            "folio" => $folio,
            "list" => $list,
            "actividades" => $actividades
        );
    }
}

$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte MP_' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
