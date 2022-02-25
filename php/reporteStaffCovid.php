<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';

$idDestino = $_GET['idDestino'];
$año = $_GET['año'];

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte Staff Covid");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'DESTINO');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'MES');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'AÑO');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'FECHA DE REGISTRO');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'REGISTRADO POR');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Nº FALTANTES (CIFRA CON STAFF COVID INCLUIDO)');
$objPHPExcel->getActiveSheet()->setCellValue('G1', '% FALTANTES VS STAFFING PPTO');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Nº EMPLEADOS CON COVID');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'INCAPACIDADES MEDICAS');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'OBSERVACIONES');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'ACTUALIZADO POR');
$objPHPExcel->getActiveSheet()->setCellValue('L1', 'FECHA ACTUALIZADO');

$fila = 1;

$query = "SELECT st.id 'idRegistro', st.fecha_creado 'fechaRegistro',
st.mes, st.año, st.numero_faltantes 'numeroFaltantes', st.porcentaje_faltantes_vs_staffing 'porcentajeFaltantes',
st.numero_empleados_covid 'numeroEmpleadosCovid', st.incapacidades_medica 'incapacidadesMedica',
st.observaciones, CONCAT(c.nombre, ' ', c.apellido) 'registradoPor',
CONCAT(c2.nombre, ' ', c2.apellido) 'modificadoPor', st.fecha_modificado 'fechaModificado', d.destino
FROM t_registro_staff AS st
INNER JOIN c_destinos AS d ON st.id_destino = d.id
INNER JOIN t_users AS u ON st.creado_por = u.id
INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
LEFT JOIN t_users AS u2 ON st.modificado_por = u2.id
LEFT JOIN t_colaboradores AS c2 ON u2.id_colaborador = c2.id
WHERE st.id_destino = $idDestino and st.año = '$año' and st.activo = 1";
if ($result = mysqli_query($conn_2020, $query)) {
   foreach ($result as $x) {
      // CONTADOR
      $fila++;
      $idRegistro = $x['idRegistro'];
      $destino = $x['destino'];
      $mes = $x['mes'];
      $año = $x['año'];
      $fechaRegistro = $x['fechaRegistro'];
      $registradoPor = $x['registradoPor'];
      $numeroFaltantes = $x['numeroFaltantes'];
      $porcentajeFaltantes = $x['porcentajeFaltantes'];
      $numeroEmpleadosCovid = $x['numeroEmpleadosCovid'];
      $incapacidadesMedica = $x['incapacidadesMedica'];
      $observaciones = $x['observaciones'];
      $fechaModificado = $x['fechaModificado'];
      $modificadoPor = $x['modificadoPor'];

      if ($mes == "ENERO") $fila = 2;
      if ($mes == "FEBRERO") $fila = 3;
      if ($mes == "MARZO") $fila = 4;
      if ($mes == "ABRIL") $fila = 5;
      if ($mes == "MAYO") $fila = 6;
      if ($mes == "JUNIO") $fila = 7;
      if ($mes == "JULIO") $fila = 8;
      if ($mes == "AGOSTO") $fila = 9;
      if ($mes == "SEPTIEMBRE") $fila = 10;
      if ($mes == "OCTUBRE") $fila = 11;
      if ($mes == "NOVIEMBRE") $fila = 12;
      if ($mes == "DICIEMBRE") $fila = 13;

      $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $destino);
      $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $mes);
      $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $año);
      $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $fechaRegistro);
      $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $registradoPor);
      $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $numeroFaltantes);
      $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $porcentajeFaltantes);
      $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $numeroEmpleadosCovid);
      $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $incapacidadesMedica);
      $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $observaciones);
      $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $modificadoPor);
      $objPHPExcel->getActiveSheet()->setCellValue('L' . $fila, $fechaModificado);
   }
}


$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_Staff_Covid ' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
