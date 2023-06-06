<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

#CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

#CONEXION DB
include '../php/conexion.php';

function capturar($x)
{
  $fechaActual = date('Y-m-d H:m:s');
  $idPlan = $x['idPlan'];
  $idEquipo = $x['idEquipo'];
  $semana = $x['semana'];
  $año = $x['año'];
  $status = $x['status'];

  $query = "UPDATE t_mp_planeacion_proceso
  SET semana_$semana = '$status', ultima_modificacion = '$fechaActual'
  WHERE id_plan = $idPlan AND id_equipo = $idEquipo AND semana_$semana = 0
  AND año = $año AND activo = 1";
  if (mysqli_query($GLOBALS['conn_2020'], $query)) {
    return true;
  }
}


function obtenerLineaTiempo()
{
  $query = "SELECT id_plan idPlan, id_equipo idEquipo, semana, año, status
  FROM t_mp_planificacion_iniciada
  WHERE año = '2023' AND activo = 1 AND status = 'SOLUCIONADO' and id = 587";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    foreach ($result as $x) {
      capturar($x);
    }
  }
}

obtenerLineaTiempo();
