<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');


# CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

#RUTA ABSOLUTA PARA ENLACES
$rutaAbsoluta = "";
if (strpos($_SERVER['REQUEST_URI'], "america") == true)
   $rutaAbsoluta = "https://www.maphg.com/america";
if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
   $rutaAbsoluta = "https://www.maphg.com/europa";
if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
   $rutaAbsoluta = "http://10.30.30.104/maphg-beta";

# CONEXION DB
include '../php/conexion.php';


#ARRAY GLOBAL
$array = array();
$array['status'] = '404';
$array['response'] = 'ERROR';
$array['data'] = array();


#OBTIENE EL TIPO DE PETICIÓN
if ($_SERVER['REQUEST_METHOD'])
   $peticion = $_SERVER['REQUEST_METHOD'];


function obtenerSabana($idSabana)
{
   try {
      $arraySabana = array();
      $query = "SELECT id_publico, sabana
      FROM t_sabanas
      WHERE id_publico = '$idSabana'";
      if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
         $array['response'] = 'SUCCESS';

         foreach ($result as $x) {
            $idSabana = $x['id_publico'];
            $sabana = $x['sabana'];


            $arrayApartados = array();
            $query = "SELECT id_publico, apartado
            FROM t_sabanas_apartados
            WHERE id_sabana = '$idSabana' and activo = 1";
            if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
               foreach ($result as $x) {
                  $idApartado = $x['id_publico'];
                  $apartado = $x['apartado'];

                  $arrayActividades = array();
                  $query = "SELECT id_publico, actividad
                  FROM t_sabanas_apartados_actividades
                  WHERE id_apartado = '$idApartado' and activo = 1";
                  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
                     foreach ($result as $x) {
                        $idActividad = $x['id_publico'];
                        $actividad = $x['actividad'];

                        $arrayActividades[] = array(
                           "idSabana" => $idSabana,
                           "idApartado" => $idApartado,
                           "idActividad" => $idActividad,
                           "actividad" => $actividad,
                           "select" => false,
                        );
                     }
                  }

                  $arrayApartados[] = array(
                     "idSabana" => $idSabana,
                     "idApartado" => $idApartado,
                     "apartado" => $apartado,
                     "sabana" => $sabana,
                     "actividades" => $arrayActividades,
                     "select" => false,
                  );
               }
            }

            // DATA
            $arraySabana = array(
               "idSabana" => $idSabana,
               "sabana" => $sabana,
               "apartados" => $arrayApartados,
               "select" => false,
            );
         }
      }

      return $arraySabana;
   } catch (\Throwable $th) {
      return $arraySabana =  array();
   }
}


#PETICIONES METODO _POST
if ($peticion === "POST") {
   $_POST = json_decode(file_get_contents('php://input'), true);

   $action = $_POST['action'];
   $idDestino = $_POST['idDestino'];
   $idUsuario = $_POST['idUsuario'];

   if ($action === "sabana") {
      $array['response'] = 'SUCCESS';
      if ($idDestino == 10)
         $filtroDestino = "";
      else
         $filtroDestino = "and id_destino = $idDestino";

      // HOTELES PARA VINCULAR
      $array['hoteles'] = array();
      $query = "SELECT id, hotel, marca FROM t_sabanas_hoteles WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idHotel = $x['id'];
            $hotel = $x['hotel'];
            $marca = $x['marca'];

            $array['hoteles'][] = array(
               "idHotel" => $idHotel,
               "hotel" => $hotel,
               "marca"  => $marca,
            );
         }
      }

      // SABANAS CREADAS
      $query = "SELECT id_publico
      FROM t_sabanas
      WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idSabana = $x['id_publico'];
            $data = obtenerSabana($idSabana);
            $array['data'][] = $data;
         }
      }
   }

   if ($action === "crearSabana") {
      $idSabana = $_POST['idSabana'];
      $idHotel = $_POST['idHotel'];
      $sabana = $_POST['sabana'];

      $query = "INSERT INTO t_sabanas(id_publico, id_destino, id_hotel, creado_por, sabana, fecha_creado, activo)
         VALUES ('$idSabana', $idDestino, $idHotel, $idUsuario, '$sabana', '$fechaActual', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
         $data = obtenerSabana($idSabana);
         $array['data'] = $data;
      }
   }

   if ($action === "crearApartado") {
      $idSabana = $_POST['idSabana'];
      $idApartado = $_POST['idApartado'];
      $apartado = $_POST['apartado'];

      $query = "INSERT INTO t_sabanas_apartados(id_publico, id_sabana, creado_por, apartado, fecha_creado, activo)
         VALUES ('$idApartado', '$idSabana', $idUsuario, '$apartado', '$fechaActual', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
         $array['data'] = obtenerSabana($idSabana);
      }
   }

   if ($action === "crearActividad") {
      $idSabana = $_POST['idSabana'];
      $idApartado = $_POST['idApartado'];
      $idActividad = $_POST['idActividad'];
      $actividad = $_POST['actividad'];

      $query = "INSERT INTO t_sabanas_apartados_actividades(id_publico, id_apartado, creado_por, actividad, fecha_creado, activo)
      VALUES ('$idActividad', '$idApartado', $idUsuario, '$actividad', '$fechaActual', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
         $array['data'] = obtenerSabana($idSabana);
      }
   }

   if ($action === "eliminarApartado") {
      $idApartado = $_POST['idApartado'];
      $query = "UPDATE t_sabanas_apartados SET activo = 0 WHERE id_publico = '$idApartado'";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
      }
   }

   if ($action === "eliminarActividad") {
      $idActividad = $_POST['idActividad'];
      $query = "UPDATE t_sabanas_apartados_actividades SET activo = 0 WHERE id_publico = '$idActividad'";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
      }
   }

   if ($action === "consultaSabanas") {

      $array['response'] = 'SUCCESS';
      if ($idDestino == 10)
         $filtroDestino = "";
      else
         $filtroDestino = "and id_destino = $idDestino";

      $query = "SELECT id_publico, sabana
      FROM t_sabanas
      WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idSabana = $x['id_publico'];
            $sabana = $x['sabana'];

            $array['data'][] = array(
               "idSabana" => $idSabana,
               "sabana" => $sabana,
            );
         }
      }
   }

   if ($action === "consultarEquipos") {
      $array['response'] = 'SUCCESS';

      $idSabana = $_POST['idSabana'];

      if ($idDestino == 10)
         $filtroDestino = "";
      else
         $filtroDestino = "and e.id_destino = $idDestino";

      $query = "SELECT e.id_equipo, e.equipo
      FROM t_sabanas_equipos AS e
      INNER JOIN t_sabanas as s ON e.id_hotel = s.id_hotel
      WHERE e.activo = 1 and s.id_publico = '$idSabana' $filtroDestino";
      $array['o'] = $query;
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idEquipo = $x['id_equipo'];
            $equipo = $x['equipo'];

            $array['data'][] = array(
               "idEquipo" => $idEquipo,
               "equipo" => $equipo,
            );
         }
      }
   }

   if ($action === "crearRegistro") {
      $idRegistro = $_POST['idRegistro'];
      $idEquipo = $_POST['idEquipo'];
      $idSabana = $_POST['idSabana'];

      // NUMERO SEMANA
      $dia   = substr($fechaActual, 8, 2);
      $mes = substr($fechaActual, 5, 2);
      $año = substr($fechaActual, 0, 4);
      $semana = date('W',  mktime(0, 0, 0, $mes, $dia, $año));

      $data = obtenerSabana($idSabana);
      $array['data'] = $data;

      $idsApartados = array();
      $idsActividades = array();
      $totalActividades = 0;

      foreach ($data['apartados'] as $x) {
         $idApartado = $x['idApartado'];
         $idsApartados[] = "[$idApartado]";

         $apartados = $x;
         foreach ($apartados['actividades'] as $y) {
            $totalActividades++;
            $idActividad = $y['idActividad'];
            $idsActividades[] = "[$idActividad]";
         }
      }
      $idsApartados = implode(", ", $idsApartados);
      $idsActividades = implode(", ", $idsActividades);

      $query = "INSERT INTO t_sabanas_registros(id_publico, id_destino, id_equipo, id_sabana, ids_apartados, ids_actividades, semana, total_actividades, fecha_creado, activo)
      VALUES('$idRegistro', $idDestino, $idEquipo, '$idSabana', '$idsApartados', '$idsActividades', $semana, $totalActividades, '$fechaActual', 0)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
         $array['data'] = array($data);
         $array['totalActividades'] = $totalActividades;
      }
   }

   if ($action === "crearCaptura") {
      $idCaptura = $_POST['idCaptura'];
      $idRegistro = $_POST['idRegistro'];
      $idEquipo = $_POST['idEquipo'];
      $idActividad = $_POST['idActividad'];
      $valor = $_POST['valor'];
      $comentario = $_POST['comentario'];
      $adjunto = $_POST['adjunto'];

      // COMPRUEBA SI EXISTE LA CAPTURA
      $existe = 0;
      $query = "SELECT id_publico FROM t_sabanas_registros_capturas WHERE id_publico = '$idCaptura'";
      if ($result = mysqli_query($conn_2020, $query)) {
         $existe = mysqli_num_rows($result);
      }

      $array['existe'] = $existe;

      // SE ACTUALIZA EL REGISTRO
      if ($existe == 1) {
         $query = "UPDATE t_sabanas_registros_capturas SET
         valor = '$valor',
         comentario = '$comentario',
         url_adjunto = '$adjunto'
         WHERE id_publico = '$idCaptura' and activo = 1";
         if ($result = mysqli_query($conn_2020, $query)) {
            $array['response'] = 'SUCCESS';
            $array['accion'] = "ACTUALIZADO";
         }
      }

      // SE CAPTURA REGISTRO NUEVO
      if ($existe == 0) {
         $query = "INSERT INTO t_sabanas_registros_capturas(id_publico, id_registro, id_equipo, id_actividad, valor, comentario, url_adjunto, creado_por, fecha_creado, activo)
         VALUE('$idCaptura', '$idRegistro', '$idEquipo', '$idActividad', '$valor', '$comentario', '$adjunto', $idUsuario, '$fechaActual', 1)";
         if ($result = mysqli_query($conn_2020, $query)) {
            $array['response'] = 'SUCCESS';
            $array['accion'] = "CAPTURADO";
         }
      }
   }

   if ($action === "confirmarRegistro") {
      $idRegistro = $_POST['idRegistro'];
      $totalActividades = $_POST['totalActividades'];

      $totalActividadesCompletadas = 0;
      $query = "SELECT count(id_publico) 'total' FROM t_sabanas_registros_capturas
      WHERE id_registro = '$idRegistro'";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $totalActividadesCompletadas = $x['total'];
         }
      }


      if ($totalActividadesCompletadas == $totalActividades) {
         $query = "UPDATE t_sabanas_registros SET activo = 1 WHERE id_publico = '$idRegistro'";
         if ($result = mysqli_query($conn_2020, $query)) {
            $array['response'] = 'SUCCESS';
            $array['completado'] = true;
            $array['restantes'] = 0;
         }
      } else {
         $array['response'] = 'SUCCESS';
         $array['completado'] = false;
         $array['restantes'] = $totalActividades - $totalActividadesCompletadas;
      }
   }
}



echo json_encode($array);
