<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';

$idDestino = $_GET['idDestino'];
$año = $_GET['año'];

$meses = ["", "ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"]

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte Staff Covid");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'PAÍS');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'DESTINO');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'FECHA REGISTRO');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'MES');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'AÑO');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'REGISTRÓ');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'STAFF APROBADO');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'STAFF CONTRATADO');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'DIFERENCIA STAFF');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'STAFF FALT. Y CON COVID');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'INCAPACIDADES MEDICAS');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'TOTAL FALTANTE');
$objPHPExcel->getActiveSheet()->setCellValue('M1', 'TOTAL REAL');

$fila = 1;

$query = "SELECT
staff.id 'idRegistro',
staff.fecha_creado 'fechaCreado',
staff.fecha_estimada 'fechaEstimada',
staff.mes, staff.pais,
staff.mes, staff.mes,
staff.mes, staff.año,
staff.staff_aprovado 'staffAprobado',
staff.staff_contratado 'staffContratado',
staff.staff_faltante_con_covid 'staffFaltanteConCovid',
staff.incapacidades_medicas 'incapacidadesMedicas',
staff.observaciones,
staff.activo,
CONCAT(col.nombre, ' ', col.apellido) 'creadoPor',
destino.id 'idDestino',
destino.destino
FROM t_registro_staff AS staff
INNER JOIN c_destinos AS destino ON staff.id_destino = destino.id
INNER JOIN t_users AS u ON staff.creado_por = u.id
INNER JOIN t_colaboradores AS col ON u.id_colaborador = col.id
WHERE staff.id_destino = $idDestino and staff.año = $año and staff.activo = 1
ORDER BY staff.fecha_estimada ASC";
if ($result = mysqli_query($conn_2020, $query)) {
   foreach ($result as $x) {
      // CONTADOR
      $fila++;
      $idRegistro = $x['idRegistro'];
      $pais = $x['pais'];
      $destino = $x['destino'];
      $fechaCreado = $x['fechaCreado'];
      $mes = $meses[$x['mes']];
      $año = $x['año'];
      $creadoPor = $x['creadoPor'];
      $staffAprobado = $x['staffAprobado'];
      $staffContratado = $x['staffContratado'];
      $diferenciaStaff = $staffAprobado - $staffContratado;
      $staffFaltanteConCovid = $x['staffFaltanteConCovid'];
      $incapacidadesMedicas = $x['incapacidadesMedicas'];
      
      #operación
      $totalFaltante = $staffAprobado - $staffContratado +($staffFaltanteConCovid + $incapacidadesMedicas);
      
      #operación
      $totalReal = $staffContratado -
      ($staffAprobado -
        $staffContratado +
        ($staffFaltanteConCovid + $incapacidadesMedicas));

      $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $pais);
      $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $destino);
      $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $fechaCreado);
      $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $mes);
      $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $año);
      $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $creadoPor);
      $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $staffAprobado);
      $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $staffContratado);
      $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $diferenciaStaff);
      $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $staffFaltanteConCovid);
      $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $incapacidadesMedicas);
      $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $totalFaltante);
      $objPHPExcel->getActiveSheet()->setCellValue('M' . $fila, $totalReal);
   }
}


$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_Staff_Covid ' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
