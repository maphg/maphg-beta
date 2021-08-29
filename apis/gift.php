<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');


# CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

include '../php/conexion.php';


#ARRAY GLOBAL
$array = array();
$array['status'] = '404';
$array['response'] = 'ERROR';
$array['data'] = array();


#OBTIENE EL TIPO DE PETICIÓN
if ($_SERVER['REQUEST_METHOD'])
   $peticion = $_SERVER['REQUEST_METHOD'];

#PETICIONES METODO _POST
if ($peticion === "POST") {
   $_POST = json_decode(file_get_contents('php://input'), true);

   $action = $_POST['action'];
   $idDestino = $_POST['idDestino'];
   $idUsuario = $_POST['idUsuario'];

   if ($action === "registros") {
      $array['response'] = "SUCCESS";

      if ($idDestino == 10)
         $filtroDestino = "";
      else
         $filtroDestino = "and id_destino = $idDestino";

      $query = "SELECT id_publico, averia FROM t_gift_averias WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idAveria = $x['id_publico'];
            $averia = $x['averia'];

            $array['averias'][] = array(
               "idAveria" => $idAveria,
               "averia" => $averia,
            );
         }
      }

      $query = "SELECT id_publico, solucion FROM t_gift_soluciones WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idSolucion = $x['id_publico'];
            $solucion = $x['solucion'];

            $array['soluciones'][] = array(
               "idSolucion" => $idSolucion,
               "solucion" => $solucion,
            );
         }
      }

      $query = "SELECT id_publico, tecnico FROM t_gift_tecnicos WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idTecnico = $x['id_publico'];
            $tecnico = $x['tecnico'];

            $array['tecnicos'][] = array(
               "idTecnico" => $idTecnico,
               "tecnico" => $tecnico,
            );
         }
      }

      $query = "SELECT id_publico FROM t_gift WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idRegistro = $x['id_publico'];
            $data = registro($idRegistro);

            if (count($data))
               $array['data'][] = $data;
         }
      }
   }

   if ($action === "crearRegistro") {
      $idRegistro = $_POST['idRegistro'];
      $idGift = $_POST['idGift'];
      $idAveria = $_POST['idAveria'];
      $idSolucion = $_POST['idSolucion'];
      $idTecnico = $_POST['idTecnico'];

      $query = "INSERT INTO t_gift(id_publico, id_destino, creado_por, id_gift, id_averia, id_solucion, id_tecnico, fecha_captura, activo) VALUES('$idRegistro', $idDestino, $idUsuario, '$idGift', '$idAveria', '$idSolucion', '$idTecnico', '$fechaActual', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = "SUCCESS";
         $array['data'] = registro($idRegistro);
      }
   }

   if ($action === "eliminarRegistro") {
      $idRegistro = $_POST['idRegistro'];

      $query = "UPDATE t_gift SET activo = 0 WHERE id_publico = '$idRegistro'";
      $array['data'] = $query;
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = "SUCCESS";
      }
   }

   if ($action === "graficas") {
      $array['response'] = "SUCCESS";
      $fechaInicial = $_POST['fechaInicial'];
      $fechaFinal = $_POST['fechaFinal'];

      if ($idDestino == 10)
         $filtroDestino = "";
      else
         $filtroDestino = "and id_destino = $idDestino";

      $query = "SELECT id_publico, averia FROM t_gift_averias
      WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idAveria = $x['id_publico'];
            $averia = $x['averia'];

            $soluciones = array();
            $query = "SELECT g.id_publico 'idRegistro', g.id_gift 'idGift',
            s.id_publico 'idSolucion', s.solucion
            FROM t_gift AS g
            INNER JOIN t_gift_soluciones AS s ON g.id_solucion = s.id_publico
            WHERE g.id_averia = '$idAveria' and g.activo = 1 and
            fecha_captura BETWEEN '$fechaInicial' and '$fechaFinal'";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $idRegistro = $x['idRegistro'];
                  $idGift = $x['idGift'];
                  $idSolucion = $x['idSolucion'];
                  $solucion = $x['solucion'];

                  $soluciones[] = array(
                     "idRegistro" => $idRegistro,
                     "idGift" => $idGift,
                     "idSolucion" => $idSolucion,
                     "solucion" => $solucion,
                  );
               }
            }

            if (count($soluciones))
               $array['data'][] = array(
                  "idAveria" => $idAveria,
                  "averia" => $averia,
                  "soluciones" => $soluciones,
               );
         }
      }

      $array['tecnicos'] = array();
      $query = "SELECT id_publico, tecnico FROM t_gift_tecnicos
      WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idTecnico = $x['id_publico'];
            $tecnico = $x['tecnico'];
            $total = 0;

            $query = "SELECT count(id_privado) 'total' FROM t_gift
            WHERE id_solucion = '1kswdwcd41kswdwcd5' and id_tecnico = '$idTecnico' and activo = 1
            and fecha_captura BETWEEN '$fechaInicial 00:00:01' and '$fechaFinal 23:59:59'";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $total = $x['total'];
               }
            }

            if ($total > 0)
               $array['tecnicos'][] = array(
                  "idTecnico" => $idTecnico,
                  "tecnico" => $tecnico,
                  "total" => $total,
               );
         }
      }
   }
}


function registro($idRegistro)
{

   $arrayRegistro = array();

   $query = "SELECT id_publico, id_destino, creado_por, id_gift, id_averia, id_solucion, id_tecnico, fecha_captura
   FROM t_gift WHERE id_publico = '$idRegistro'";
   if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
      foreach ($result as $x) {
         $idRegistro = $x['id_publico'];
         $idGift = $x['id_gift'];
         $idAveria = $x['id_averia'];
         $idSolucion = $x['id_solucion'];
         $idTecnico = $x['id_tecnico'];
         $idDestino = $x['id_destino'];
         $fechaCaptura = $x['fecha_captura'];
         $averia = "";
         $solucion = "";
         $tecnico = "";
         $destino = "";

         $query = "SELECT id_publico, averia FROM t_gift_averias
         WHERE id_publico = '$idAveria'";
         if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
               $averia = $x['averia'];
            }
         }

         $query = "SELECT id_publico, solucion
         FROM t_gift_soluciones WHERE id_publico = '$idSolucion'";
         if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
               $solucion = $x['solucion'];
            }
         }

         $query = "SELECT id_publico, tecnico FROM t_gift_tecnicos WHERE id_publico = '$idTecnico'";
         if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
               $tecnico = $x['tecnico'];
            }
         }

         $arrayRegistro = array(
            "idRegistro" => $idRegistro,
            "idGift" => $idGift,
            "idAveria" => $idAveria,
            "averia" => $averia,
            "idSolucion" => $idSolucion,
            "solucion" => $solucion,
            "idTecnico" => $idTecnico,
            "tecnico" => $tecnico,
            "idDestino" => $idDestino,
            "destino" => $destino,
            "fechaCaptura" => $fechaCaptura,
         );
      }
   }

   return $arrayRegistro;
}

echo json_encode($array);
