<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');

# CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

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

#PETICIONES METODO _POST
if ($peticion === "POST") {
   $_POST = json_decode(file_get_contents('php://input'), true);
   $action = $_POST['action'];

   if ($action === "comprobarSesion") {
      $idDestino = $_POST['idDestino'];
      $idUsuario = $_POST['idUsuario'];

      $query = "SELECT u.id, u.id_destino, c.nombre, c.apellido, d.destino
      FROM t_users AS u
      INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
      INNER JOIN c_destinos AS d ON u.id_destino = d.id
      WHERE u.id = $idUsuario and u.status  = 'A'
      and u.activo = 1 LIMIT 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idUsuarioX = $x['id'];
            $idDestinoX = $x['id_destino'];
            $nombre = $x['nombre'];
            $apellido = $x['apellido'];
            $destino = $x['destino'];

            if ($idUsuario === $idUsuarioX) {
               $array['response'] = "SUCCESS";

               $array['data'] = array(
                  "idUsuario" => $idUsuarioX,
                  "nombre" => $nombre,
                  "destino" => $destino,
               );
            }
         }
      }
   }

   if ($action === "sesion") {
      $usuario = $_POST['usuario'];
      $contrasena = $_POST['contrasena'];

      $query = "SELECT u.id, u.id_destino, c.nombre, c.apellido
      FROM t_users AS u
      INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
      WHERE u.username = '$usuario' and u.password = '$contrasena' and
      activo = 1 and u.status = 'A' LIMIT 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idDestino = $x['id_destino'];
            $idUsuario = $x['id'];

            $array['response'] = "SUCCESS";

            $array['data'] = array(
               "idDestino" => $idDestino,
               "idUsuario" => $idUsuario,
            );
         }
      }
   }
}

echo json_encode($array);
