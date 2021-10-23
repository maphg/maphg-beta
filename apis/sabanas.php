<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');
$caracteres = array("[", "]", "[ ", "] ");

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
            $query = "SELECT id_publico, apartado, opciones
            FROM t_sabanas_apartados
            WHERE id_sabana = '$idSabana' and activo = 1";
            if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
               foreach ($result as $x) {
                  $idApartado = $x['id_publico'];
                  $apartado = $x['apartado'];
                  $opciones = $x['opciones'];

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
                           "edit" => false,
                        );
                     }
                  }

                  $arrayApartados[] = array(
                     "idSabana" => $idSabana,
                     "idApartado" => $idApartado,
                     "apartado" => $apartado,
                     "sabana" => $sabana,
                     "actividades" => $arrayActividades,
                     "opciones" => $opciones,
                     "select" => false,
                     "edit" => false,
                  );
               }
            }

            // DATA
            $arraySabana = array(
               "idSabana" => $idSabana,
               "sabana" => $sabana,
               "apartados" => $arrayApartados,
               "select" => false,
               "edit" => false,
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

   // OBTIENE LAS SABANAS POR DESTINO Y SUS PROPIEDADES
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

   // CREA SABANA POR DESTINO
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

   // CREA SABANA POR DESTINO
   if ($action === "actualizarSabana") {
      $idSabana = $_POST['idSabana'];
      $sabana = $_POST['sabana'];
      $activo = $_POST['activo'];

      $query = "UPDATE t_sabanas
      SET sabana = '$sabana', activo = $activo
      WHERE id_publico = '$idSabana' and activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
      }
   }

   // CREA APARTADO DE LA SABANA
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

   // CREA SABANA POR DESTINO
   if ($action === "actualizarApartado") {
      $idApartado = $_POST['idApartado'];
      $apartado = $_POST['apartado'];
      $opciones = $_POST['opciones'];
      $activo = $_POST['activo'];

      $query = "UPDATE t_sabanas_apartados
      SET apartado = '$apartado', opciones = '$opciones', activo = $activo
      WHERE id_publico = '$idApartado' and activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
      }
   }

   // CREA ACTIVIDAD DEL APARTADO DE LA SABANA
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

   // CREA SABANA POR DESTINO
   if ($action === "actualizarActividad") {
      $idActividad = $_POST['idActividad'];
      $actividad = $_POST['actividad'];
      $activo = $_POST['activo'];

      $query = "UPDATE t_sabanas_apartados_actividades
      SET actividad = '$actividad', activo = $activo
      WHERE id_publico = '$idActividad' and activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
      }
   }

   // CONSULTA LAS SABANAS DISPONIBLES POR DESTINO
   if ($action === "consultarHoteles") {
      $array['response'] = 'SUCCESS';

      $filtroDestino = "and id_destino = 0";

      if ($idDestino > 0)
         $filtroDestino = "and id_destino = $idDestino";


      $query = "SELECT id 'idHotel', hotel, marca, fecha_creado
      FROM t_sabanas_hoteles 
      WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x)
            $array['data'][] = $x;
      }
   }

   // CONSULTA LAS SABANAS DISPONIBLES POR DESTINO
   if ($action === "consultarTiposActivos") {
      $array['response'] = 'SUCCESS';
      $idHotel = $_POST['idHotel'];

      $query = "SELECT registro.id 'idRegistroTipoActivo', tipo.id 'idTipoActivo', tipo.tipo
      FROM t_sabanas_hoteles_tipos_activos AS registro
      INNER JOIN c_tipos AS tipo ON registro.id_tipo_activo = tipo.id
      WHERE registro.activo = 1 and registro.id_hotel = $idHotel";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x)
            $array['data'][] = $x;
      }
   }

   // CONSULTA LAS SABANAS DISPONIBLES POR DESTINO
   if ($action === "consultaSabanas") {
      $array['response'] = 'SUCCESS';
      $idHotel = $_POST['idHotel'];
      $idRegistroTipoActivo = $_POST['idRegistroTipoActivo'];

      $query = "SELECT id_publico 'idSabana', sabana
      FROM t_sabanas
      WHERE id_destino = $idDestino and id_hotel = $idHotel and id_registro_tipo_activo = $idRegistroTipoActivo and activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idSabana = $x['idSabana'];
            $sabana = $x['sabana'];

            $array['data'][] = array(
               "idSabana" => $idSabana,
               "sabana" => $sabana,
            );
         }
      }
      $array['query'] = $query;
   }

   // CONSULTA EQUIPOS DISPONIBLES PARA LA SABANA
   if ($action === "consultarEquipos") {
      $array['response'] = 'SUCCESS';

      $idSabana = $_POST['idSabana'];
      $idHotel = $_POST['idHotel'];
      $idTipoActivo = $_POST['idTipoActivo'];

      $query = "SELECT id_equipo 'idEquipo', equipo
      FROM t_sabanas_equipos
      WHERE id_destino = $idDestino and id_hotel = $idHotel and
      id_tipo_activo =  $idTipoActivo and activo = 1";
      if ($result = mysqli_query($conn_2020, $query))
         foreach ($result as $x)
            $array['data'][] = $x;
   }

   // INICIA REGISTRO SIN CONFIRMAR DE LA SABANA DE LA HABITACIÓN
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

      $query = "INSERT INTO t_sabanas_registros(id_publico, id_destino, id_equipo, id_sabana, creado_por, ids_apartados, ids_actividades, semana, total_actividades, fecha_creado, activo)
      VALUES('$idRegistro', $idDestino, $idEquipo, '$idSabana', $idUsuario, '$idsApartados', '$idsActividades', $semana, $totalActividades, '$fechaActual', 0)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = 'SUCCESS';
         $array['data'] = array($data);
         $array['totalActividades'] = $totalActividades;
      }
   }

   // CREA REGISTRO DE LA ACTIVIDAD DE LA SABANA DE LA HABITACIÓN
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
            $array['data'] = $valor;
         }
      }

      // SE CAPTURA REGISTRO NUEVO
      if ($existe == 0) {
         $query = "INSERT INTO t_sabanas_registros_capturas(id_publico, id_registro, id_equipo, id_actividad, valor, comentario, url_adjunto, creado_por, fecha_creado, activo)
         VALUE('$idCaptura', '$idRegistro', '$idEquipo', '$idActividad', '$valor', '$comentario', '$adjunto', $idUsuario, '$fechaActual', 1)";
         if ($result = mysqli_query($conn_2020, $query)) {
            $array['response'] = 'SUCCESS';
            $array['accion'] = "CAPTURADO";
            $array['data'] = $valor;
         }
      }
   }

   // CONFIRMA EL REGISTRO DE LA SABANA DE LA HABITACIÓN
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

   // OBTIENE EL HISTORIAL DE LAS SEMANAS
   if ($action === "semanas") {
      $array['response'] = "SUCCESS";

      $fechaInicial = $_POST["fechaInicial"];
      $fechaFinal = $_POST["fechaFinal"];
      $idSabana = $_POST["idSabana"];
      $idHotel = $_POST["idHotel"];
      $villa = $_POST["villa"];
      $visualizar = $_POST["visualizar"]; // 0 = Todos, 1 = Con Registros.

      if ($idDestino == 10) {
         $filtroDestino = "";
         $filtroDestinoHotel = "";
         $filtroDestinoEquipo = "";
      } else {
         $filtroDestino = "and id_destino = $idDestino";
         $filtroDestinoHotel = "and h.id_destino = $idDestino";
         $filtroDestinoEquipo = "and e.id_destino = $idDestino";
      }

      if ($idSabana == "TODOS")
         $filtroSabana = "";
      else
         $filtroSabana = "and id_sabana = '$idSabana'";

      if ($villa == "TODOS")
         $filtroVilla = "";
      else
         $filtroVilla = "and villa_edificio = '$villa'";

      // SABANAS
      $query = "SELECT id 'idHotel', hotel
      FROM t_sabanas_hoteles
      WHERE activo = 1 and id = '$idHotel' $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idHotel = $x['idHotel'];
            $hotel = $x['hotel'];

            $equipos = array();
            $query = "SELECT id_equipo 'idEquipo', equipo
            FROM t_sabanas_equipos
            WHERE id_hotel = '$idHotel' and activo = 1 $filtroDestino $filtroVilla";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $totalRegistros = 0;

                  $idEquipo = $x['idEquipo'];
                  $equipo = $x['equipo'];

                  $registros = array();
                  $query = "SELECT id_publico 'idRegistro', semana, fecha_creado, creado_por
                  FROM t_sabanas_registros
                  WHERE id_equipo ='$idEquipo' and activo = 1 and
                  fecha_creado BETWEEN '$fechaInicial 00:00:01' and '$fechaFinal 23:59:59' $filtroSabana";
                  if ($result = mysqli_query($conn_2020, $query)) {
                     foreach ($result as $x) {
                        $idRegistro = $x['idRegistro'];
                        $semana = $x['semana'];
                        $fecha = $x['fecha_creado'];
                        $idUsuarioX = $x['creado_por'];
                        $totalRegistros++;
                        $reportadoRegistro = 0;
                        $color = 1;

                        $query = "SELECT valor, reportado FROM t_sabanas_registros_capturas
                        WHERE id_registro = '$idRegistro' and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                           foreach ($result as $x) {
                              $valor = $x['valor'];
                              $reportado = $x['reportado'];

                              if ($reportado === "SI")
                                 $reportadoRegistro = 1;


                              if ($valor == "NO")
                                 $color = 2;
                           }
                        }

                        $creadoPor = "";
                        $query = "SELECT u.id, c.nombre, c.apellido
                        FROM t_users AS u
                        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
                        WHERE u.id = $idUsuarioX";
                        if ($result = mysqli_query($conn_2020, $query)) {
                           foreach ($result as $x) {
                              $creadoPor = $x['nombre'] . " " . $x['apellido'];
                           }
                        }

                        $registros[] = array(
                           "idRegistro" => $idRegistro,
                           "semana" => $semana,
                           "fecha" => $fecha,
                           "creadoPor" => $creadoPor,
                           "totalRegistros" => $totalRegistros,
                           "color" => $color,
                           "reportado" => $reportadoRegistro
                        );
                     }
                  }

                  if ($visualizar == 0)
                     $equipos[] = array(
                        "idEquipo" => $idEquipo,
                        "equipo" => $equipo,
                        "registros" => $registros,
                     );

                  if ($visualizar == 1)
                     if ($totalRegistros > 0)
                        $equipos[] = array(
                           "idEquipo" => $idEquipo,
                           "equipo" => $equipo,
                           "registros" => $registros,
                        );
               }
            }
            // INCLUYE DATOS
            $array['data'][] = array(
               "idHotel" => $idHotel,
               "hotel" => $hotel,
               "equipos" => $equipos,
            );
         }
      }

      // OBTIENE LOS HOTELES
      $array['hoteles'] = array();
      $query = "SELECT id, hotel FROM t_sabanas_hoteles
      WHERE activo = 1 $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idHotel = $x['id'];
            $hotel = $x['hotel'];

            $array['hoteles'][] = array(
               "idHotel" => $idHotel,
               "hotel" => $hotel,
            );
         }
      }
   }

   // OBTIENE LAS SABANAS PARA FILTRO
   if ($action === "obtenerSabanas") {
      $array['response'] = "SUCCESS";
      $idHotel = $_POST["idHotel"];

      if ($idDestino == 10)
         $filtroDestino = "";
      else
         $filtroDestino = "and id_destino = $idDestino";

      $query = "SELECT id_publico, sabana FROM t_sabanas
      WHERE activo = 1 and id_hotel = '$idHotel' $filtroDestino";
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

   // OBTIENE LAS SABANAS PARA FILTRO
   if ($action === "obtenerVillas") {
      $array['response'] = "SUCCESS";
      $idHotel = $_POST["idHotel"];

      if ($idDestino == 10)
         $filtroDestino = "";
      else
         $filtroDestino = "and id_destino = $idDestino";
      $query = "SELECT villa_edificio FROM t_sabanas_equipos
      WHERE activo = 1 and id_hotel = '$idHotel' and villa_edificio != ''
      $filtroDestino ORDER BY villa_edificio ASC";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $villa = $x['villa_edificio'];

            $array['data'][] = $villa;
         }
      }
   }

   if ($action === "detallesActividad") {
      $array['response'] = "SUCCESS";
      $idRegistro = $_POST['idRegistro'];

      $query = "SELECT s.id_publico, s.sabana, c.nombre, c.apellido,
      r.fecha_creado, r.ids_apartados, r.ids_actividades, e.equipo
      FROM t_sabanas_registros AS r
      INNER JOIN t_sabanas AS s ON r.id_sabana = s.id_publico
      INNER JOIN t_users AS u ON r.creado_por = u.id
      INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
      INNER JOIN t_sabanas_equipos AS e ON r.id_equipo = e.id_equipo
      WHERE r.id_publico = '$idRegistro'";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idSabana  = $x['id_publico'];
            $sabana = $x['sabana'];
            $creadoPor = $x['nombre'] . " " . $x['apellido'];
            $fechaCreado = $x['fecha_creado'];
            $equipo = $x['equipo'];

            #APARTADOS
            $idsApartados = str_replace($caracteres, "", $x['ids_apartados']);
            $idsApartados = explode(", ", $idsApartados);

            #ACTIVIDADES
            $idsActividades = str_replace($caracteres, "", $x['ids_actividades']);
            $idsActividades = explode(", ", $idsActividades);
            $idsActividadesX = array();
            foreach ($idsActividades as $x) {
               $idsActividadesX[] = $x;
            }
            $idsActividadesX = implode("','", $idsActividadesX);

            $arrayApartados = array();
            foreach ($idsApartados as $x) {
               $idApartado = $x;
               $query = "SELECT id_publico, apartado FROM t_sabanas_apartados
               WHERE id_publico = '$idApartado'";
               if ($result = mysqli_query($conn_2020, $query)) {
                  foreach ($result as $x) {
                     $idApartadoX = $x['id_publico'];
                     $apartado = $x['apartado'];

                     $arrayActividades = array();
                     $query = "SELECT id_publico, actividad FROM t_sabanas_apartados_actividades
                     WHERE id_apartado = '$idApartadoX' and id_publico IN('$idsActividadesX')";
                     if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                           $idActividad = $x['id_publico'];
                           $actividad = $x['actividad'];

                           $idCaptura = "";
                           $tieneComentario = "NO";
                           $comentario = "";
                           $tieneFoto = "NO";
                           $foto = "";
                           $valor = "0";
                           $reportado = "NO";
                           $query = "SELECT id_publico, valor, comentario, url_adjunto, reportado
                           FROM t_sabanas_registros_capturas
                           WHERE id_registro = '$idRegistro' and id_actividad = '$idActividad'";
                           if ($result = mysqli_query($conn_2020, $query)) {
                              foreach ($result as $x) {
                                 $idCaptura = $x['id_publico'];
                                 $valor = $x['valor'];
                                 $comentario = $x['comentario'];
                                 $foto = $x['url_adjunto'];
                                 $reportado = $x['reportado'];

                                 if ($comentario != "")
                                    $tieneComentario = "SI";

                                 if ($foto != "")
                                    $tieneFoto = "SI";

                                 if ($valor === "SI")
                                    $valor = 1;
                                 elseif ($valor === "NO")
                                    $valor = 2;
                                 elseif ($valor === "N/A")
                                    $valor = 3;
                              }
                           }

                           $arrayActividades[] = array(
                              "idActividad" => $idActividad,
                              "actividad" => $actividad,
                              "idCaptura" => $idCaptura,
                              "tieneComentario" => $tieneComentario,
                              "comentario" => $comentario,
                              "tieneFoto" => $tieneFoto,
                              "foto" => $rutaAbsoluta . "/sabanas/fotos/" . $foto,
                              "valor" => $valor,
                              "reportado" => $reportado,
                           );
                        }
                     }

                     $arrayApartados[] = array(
                        "idApartado" => $idApartadoX,
                        "apartado" => $apartado,
                        "actividades" => $arrayActividades,
                     );
                  }
               }
            }

            $array['data'][] = array(
               "idSabana" => $idSabana,
               "equipo" => $equipo,
               "sabana" => $sabana,
               "creadoPor" => $creadoPor,
               "fechaCreado" => $fechaCreado,
               "idsApartados" => $idsApartados,
               "apartados" => $arrayApartados,
            );
         }
      }
   }

   if ($action === "reportado") {
      $idCaptura = $_POST['idCaptura'];
      $reportado = $_POST['reportado'];

      if ($reportado === "SI")
         $reportado = "NO";
      else
         $reportado = "SI";

      $query = "UPDATE t_sabanas_registros_capturas SET reportado = '$reportado'
      WHERE id_publico = '$idCaptura'";
      if ($result = mysqli_query($conn_2020, $query)) {
         $array['response'] = "SUCCESS";
         $array['data'] = $reportado;
      }
   }
}

echo json_encode($array);
