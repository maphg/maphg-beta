<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');

#CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

#CONEXION DB
include '../php/conexion.php';

function agregarLineaTiempo($x)
{
  $idBitacora = $x['idBitacora'];
  $idParametro = $x['idParametro'];
  $fechaInicio = $x['fechaInicio'];
  $horaInicio = $x['horaInicio'];
  $cicloHoras = $x['cicloHoras'];
  $fechaToken = $x['fechaToken'];

  $query = "INSERT INTO t_bitacoras_linea_tiempo(id_bitacora, id_parametro, fecha_inicio_registro, hora_inicio_registro, ciclo_horas, fecha_token, fecha_creado, activo) VALUES('$idBitacora', '$idParametro', '$fechaInicio', '$horaInicio', '$cicloHoras', '$fechaToken', '" . date('Y-m-d') . "', 1)";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    return true;
  } else {
    return false;
  }
}

function obtenerLineaTiempo($idBitacora, $idParametro, $fechaInicio_p, $horaInicio_p, $ciclo_p)
{
  $array = array();

  $query = "SELECT id, id_bitacora, id_parametro, fecha_inicio_registro,
  hora_inicio_registro, ciclo_horas, fecha_token, fecha_creado
  FROM t_bitacoras_linea_tiempo
  WHERE id_bitacora = '$idBitacora' and id_parametro = '$idParametro' and
  fecha_inicio_registro = '$fechaInicio_p' and hora_inicio_registro = '$horaInicio_p' and
  ciclo_horas = '$ciclo_p' and activo = 1
  ORDER BY id DESC LIMIT 1";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    foreach ($result as $x) {
      $array = array(
        "idParametro" => $x['id_parametro'],
        "idParametro" => $x['id_parametro'],
        "fechaInicio" => $x['fecha_inicio_registro'],
        "horaInicio" => $x['hora_inicio_registro'],
        "cicloHoras" => $x['ciclo_horas'],
        "fechaToken" => $x['fecha_token'],
        "fechaCreado" => $x['fecha_creado'],
      );
    }
  }
  return $array;
}

$query = "SELECT id_publico, fecha_inicio, hora_inicio, horas, dias, semanas, meses
FROM t_bitacoras_configuracion
WHERE status = 'ACTIVADO' and activo = 1";
if ($result = mysqli_query($conn_2020, $query)) {
  foreach ($result as $x) {

    $idBitacora = $x['id_publico'];
    $fechaInicio_b = $x['fecha_inicio'];
    $horaInicio_b = $x['hora_inicio'];
    $ciclo_b = intval($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);
    $fechaLarga_b = (new DateTime("$fechaInicio_b $horaInicio_b"))->format('Y-m-d H:m:s');
    
    $query = "SELECT *
    FROM t_bitacoras_lista_parametros
    WHERE activo = 1 and id_bitacoras_configuracion = '$idBitacora'";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idParametro = $x['id_publico'];
        $configuracionGlobal = $x['configuracion_global'];
        $fechaInicio_p = $x['fecha_inicio'];
        $horaInicio_p = $x['hora_inicio'];
        $ciclo_p = intval($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);
        $fechaLarga_p = (new DateTime("$fechaInicio_p $horaInicio_p"))->format('Y-m-d H:m:s');

        #CONFIGURACIÓN GLOBAL
        if ($configuracionGlobal === "true" && $ciclo_b > 0) {

          $cicloX = 1;
          if ($ciclo_b > 0) {
            $cicloX += intval(24 / $ciclo_b);
          }

          for ($i = 0; $i <= $cicloX; $i++) {
            $x = obtenerLineaTiempo($idBitacora, '', $fechaInicio_b, $horaInicio_b, $ciclo_b);

            if (!empty($x)) {
              echo " Opción 1 <br/>";

              #AGREGA NUEVA LINEA DE TIEMPO
              $fechaToken = $x['fechaToken'];
              $nuevoFechaToken = strtotime(
                "+$ciclo_b hour",
                strtotime($fechaToken)
              );

              $nuevoFechaCreado = date("Y-m-d", $nuevoFechaToken);
              $nuevoFechaToken = date("Y-m-d H:m:s", $nuevoFechaToken);

              $fechaA = strtotime(date("d-m-Y 23:59:59", time()));
              $fechaB = strtotime("$nuevoFechaToken");

              if ($fechaB <= $fechaA) {

                #AGREGA NUEVA LINEA DE TIEMPO
                $datos = array(
                  "idBitacora" => $idBitacora,
                  "idParametro" => "",
                  "fechaInicio" => $fechaInicio_b,
                  "horaInicio" => $horaInicio_b,
                  "cicloHoras" => $ciclo_b,
                  "fechaToken" => $nuevoFechaToken,
                );

                agregarLineaTiempo($datos);
              }
            } else {
              echo "Opción 2 <br/>";

              #AGREGA NUEVA LINEA DE TIEMPO
              $nuevoFechaToken = strtotime(
                "+$ciclo_b hour",
                strtotime($fechaLarga_b)
              );
              $nuevoFechaToken = date("Y-m-d H:m:s", $nuevoFechaToken);

              $datos = array(
                "idBitacora" => $idBitacora,
                "idParametro" => "",
                "fechaInicio" => $fechaInicio_b,
                "horaInicio" => $horaInicio_b,
                "cicloHoras" => $ciclo_b,
                "fechaToken" => $nuevoFechaToken,
              );

              agregarLineaTiempo($datos);
            }
          }
        }

        #CONFIGURACIÓN INDIVIDUAL
        if ($configuracionGlobal === "false" && $ciclo_p > 0) {

          $cicloX = 1;
          if ($ciclo_p > 0) {
            $cicloX += intval(24 / $ciclo_p);
          }

          for ($i = 0; $i <= $cicloX; $i++) {
            $x = obtenerLineaTiempo($idBitacora, $idParametro, $fechaInicio_p, $horaInicio_p, $ciclo_p);

            if (!empty($x)) {
              echo " Opción 3 <br/>";

              #AGREGA NUEVA LINEA DE TIEMPO
              $fechaToken = $x['fechaToken'];
              $nuevoFechaToken = strtotime(
                "+$ciclo_p hour",
                strtotime($fechaToken)
              );

              $nuevoFechaCreado = date("Y-m-d", $nuevoFechaToken);
              $nuevoFechaToken = date("Y-m-d H:m:s", $nuevoFechaToken);

              $fechaA = strtotime(date("d-m-Y 23:59:59", time()));
              $fechaB = strtotime("$nuevoFechaToken");

              if ($fechaB <= $fechaA) {

                #AGREGA NUEVA LINEA DE TIEMPO
                $datos = array(
                  "idBitacora" => $idBitacora,
                  "idParametro" => $idParametro,
                  "fechaInicio" => $fechaInicio_p,
                  "horaInicio" => $horaInicio_p,
                  "cicloHoras" => $ciclo_p,
                  "fechaToken" => $nuevoFechaToken,
                );

                agregarLineaTiempo($datos);
              }
            } else {
              echo "Opción 4 <br/>";

              #AGREGA NUEVA LINEA DE TIEMPO
              $nuevoFechaToken = strtotime(
                "+$ciclo_p hour",
                strtotime($fechaLarga_p)
              );
              $nuevoFechaToken = date("Y-m-d H:m:s", $nuevoFechaToken);

              $datos = array(
                "idBitacora" => $idBitacora,
                "idParametro" => $idParametro,
                "fechaInicio" => $fechaInicio_p,
                "horaInicio" => $horaInicio_p,
                "cicloHoras" => $ciclo_p,
                "fechaToken" => $nuevoFechaToken,
              );

              agregarLineaTiempo($datos);
            }
          }
        }
      }
    }
  }
}
