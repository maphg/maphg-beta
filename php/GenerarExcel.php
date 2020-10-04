<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';
require 'PHPExcel.php';
$xlsIdGrupo = $_POST['xlsIdGrupo'];
$xlsIdDestino = $_POST['xlsIdDestino'];
$xlsIdSeccion = $_POST['xlsIdSeccion'];

//Variables Generales.
$arrayDestino = array(1 => "RM", 2 => "PVR", 3 => "SDQ", 4 => "SSA", 5 => "PUJ", 6 => "MBJ", 7 => "CMU", 10 => "AME", 11 => "CAP");
$arrayDEP = array(62 => "RRHH", 211 => "Finanzas", 212 => "Dirección", 213 => "Compras Almacén", 214 => "Calidad", 200 => "Proyectos");


if ($xlsIdGrupo == 213) {
    $status = "AND t_mc.status_material != ''";
    $departamento = "Material";
    $status_P = "";
}
if ($xlsIdGrupo == 62) {
    $status = "AND t_mc.departamento_rrhh != ''";
    $departamento = "RRHH";
    $status_P = "";
}
if ($xlsIdGrupo == 211) {
    $status = "AND t_mc.departamento_finanzas != ''";
    $departamento = "Finanzas";
    $status_P = "";
}
if ($xlsIdGrupo == 212) {
    $status = "AND t_mc.departamento_direccion != ''";
    $departamento = "Direccion";
    $status_P = "";
}
if ($xlsIdGrupo == 214) {
    $status = "AND t_mc.departamento_calidad != ''";
    $departamento = "Calidad";
    $status_P = "";
}

if ($xlsIdDestino != 10) {
    $destino_P = "AND t_proyectos.id_destino = $xlsIdDestino";
} else {
    $destino_P = "";
}



//Correctivos Generales
if ($xlsIdDestino != 10) {
    $query = "SELECT
	t_mc.id, t_mc.id_destino, t_mc.actividad, t_mc.fecha_creacion, t_mc.status_material, t_mc.status_trabajare, t_mc.departamento_direccion,t_mc.departamento_rrhh, 
	t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.fecha_creacion,
	t_mc.departamento_finanzas, t_mc.responsable, 
	t_colaboradores.nombre, t_colaboradores.apellido,
    t_mc.cod2bend, t_mc.codsap,
	c_secciones.seccion, c_subsecciones.grupo
	FROM t_mc 
	
	LEFT JOIN t_users ON t_mc.creado_por = t_users.id
    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
	INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
	INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id

	WHERE t_mc.status='N' AND t_mc.activo=1 AND t_mc.id_destino = $xlsIdDestino $status";
} else {

    $query = "SELECT
	t_mc.id, t_mc.id_destino, t_mc.actividad, t_mc.fecha_creacion, t_mc.status_material, t_mc.status_trabajare, t_mc.departamento_direccion,t_mc.departamento_rrhh, 
	t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.fecha_creacion,
	t_mc.departamento_finanzas, t_mc.responsable, 
	t_colaboradores.nombre, t_colaboradores.apellido,
	c_secciones.seccion, c_subsecciones.grupo,
    t_mc.cod2bend, t_mc.codsap
	
	FROM t_mc 
	
	LEFT JOIN t_users ON t_mc.creado_por = t_users.id
    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
	INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id
	INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id
	WHERE t_mc.status='N' AND t_mc.activo=1 $status";
}




$result = mysqli_query($conn_2020, $query);



// XLS
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Reporte")->setDescription("Reporte");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle("Reporte");
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ID');
$objPHPExcel->getActiveSheet()->setCellValue('B1', 'Actividad');
$objPHPExcel->getActiveSheet()->setCellValue('C1', 'Creado Por');
$objPHPExcel->getActiveSheet()->setCellValue('D1', 'Destino');
$objPHPExcel->getActiveSheet()->setCellValue('E1', 'Sección');
$objPHPExcel->getActiveSheet()->setCellValue('F1', 'Subsección');
$objPHPExcel->getActiveSheet()->setCellValue('G1', 'Departamentos');
$objPHPExcel->getActiveSheet()->setCellValue('H1', 'Comentario');
$objPHPExcel->getActiveSheet()->setCellValue('I1', 'fecha de Creación');
$objPHPExcel->getActiveSheet()->setCellValue('J1', 'CODSAP');
$objPHPExcel->getActiveSheet()->setCellValue('K1', 'COD2BEND');


$fila = 2;
while ($row = mysqli_fetch_array($result)) {
    $id = $row['id'];
    $actividad = $row['actividad'];
    $creado_por = $row['nombre'] . " " . $row['apellido'];
    $rrhh = $row['departamento_rrhh'];
    $direccion = $row['departamento_direccion'];
    $calidad = $row['departamento_calidad'];
    $compras = $row['departamento_compras'];
    $finanzas = $row['departamento_finanzas'];
    $comentario = "Sin Comentario";
    $seccion = $row['seccion'];
    $subseccion = $row['grupo'];
    $cod2bend = $row['cod2bend'];
    $codsap = $row['codsap'];
    $fecha = $row['fecha_creacion'];
    $fecha = new DateTime($fecha);
    $fecha = $fecha->format('d-m-Y H:m:s');

    //Se obtiene el destino por array.
    $destinoID = $row['id_destino'];
    $destino = $arrayDestino[$destinoID];

    $query_comentario = "SELECT comentario FROM t_mc_comentarios WHERE id_mc=$id";
    $result_comentario = mysqli_query($conn_2020, $query_comentario);
    if ($row_comentario = mysqli_fetch_array($result_comentario)) {
        $comentario = $row_comentario['comentario'];
    }

    if ($rrhh != "") {
        $rrhh = "RRHH";
    } else {
        $rrhh = "";
    }

    if ($direccion != "") {
        $direccion = "DIRECCION";
    } else {
        $direccion = "";
    }
    if ($calidad != "") {
        $calidad = "CALIDAD";
    } else {
        $calidad = "";
    }
    if ($compras != "") {
        $compras = "COMPRAS";
    } else {
        $compras = "";
    }
    if ($finanzas != "") {
        $finanzas = "FINANAS";
    } else {
        $finanzas = "";
    }

    $departamentos = $rrhh . "  " . $direccion . "  " . $calidad . "  " . $compras . "  " . $finanzas;




    $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $fila);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $actividad);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $creado_por);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $destino);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $seccion);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $subseccion);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $departamentos);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $comentario);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $fecha);
    $objPHPExcel->getActiveSheet()->setCellValue('J' . $fila, $codsap);
    $objPHPExcel->getActiveSheet()->setCellValue('K' . $fila, $cod2bend);
    //Inicializa variables.
    $departamentos = "";
    $destino = "";

    //Contador de Celdas
    $fila++;
}

$fila  = $fila + 1;
$objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, 'Proyectos');



    $query_P = "SELECT
        t_proyectos_planaccion.id,
        t_proyectos_planaccion.codsap,
        t_proyectos_planaccion.status_material,
        t_proyectos_planaccion.departamento_rrhh,
        t_proyectos_planaccion.departamento_finanzas,
        t_proyectos_planaccion.departamento_direccion,
        t_proyectos_planaccion.departamento_calidad,
        t_proyectos_planaccion.actividad,
        t_proyectos_planaccion.creado_por,
        t_proyectos_planaccion.fecha_creacion,
        t_proyectos_planaccion.responsable,
        t_proyectos.titulo,
        t_colaboradores.nombre,
        t_colaboradores.apellido
        FROM t_proyectos_planaccion
        INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id
        INNER JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN c_destinos ON t_proyectos_planaccion.id_destino
        WHERE t_proyectos_planaccion.activo = 1 and t_proyectos_planaccion.status = 'N' $status_P $destino_P
    ";

$result_P = mysqli_query($conn_2020, $query_P);
while ($row_P = mysqli_fetch_array($result_P)) {

    $id = $row_P['id'];
    $actvidad = $row_P['actividad'];
    $creado_por = $row_P['nombre'] . " " . $row_P['apellido'];



    //Contador para las filas.
    $fila++;

    $objPHPExcel->getActiveSheet()->setCellValue('A' . $fila, $fila);
    $objPHPExcel->getActiveSheet()->setCellValue('B' . $fila, $actividad);
    $objPHPExcel->getActiveSheet()->setCellValue('C' . $fila, $creado_por);
    $objPHPExcel->getActiveSheet()->setCellValue('D' . $fila, $destino);
    $objPHPExcel->getActiveSheet()->setCellValue('E' . $fila, $seccion);
    $objPHPExcel->getActiveSheet()->setCellValue('F' . $fila, $subseccion);
    $objPHPExcel->getActiveSheet()->setCellValue('G' . $fila, $departamentos);
    $objPHPExcel->getActiveSheet()->setCellValue('H' . $fila, $comentario);
    $objPHPExcel->getActiveSheet()->setCellValue('I' . $fila, $fecha);
}













$fecha = date('d-m-Y H:m:s');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Disposition: attachment;filename="Reporte_' . $fecha . '.xlsx"');
header('Cache-Control: max-age=0');
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
$objWriter->save('PHP://output');
