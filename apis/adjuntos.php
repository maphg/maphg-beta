<?php
header("Access-Control-Allow-Origin: *");

if (isset($_POST["action"])) {
   $action = $_POST["action"];
   $idDestino = $_POST["idDestino"];
   $idUsuario = $_POST["idUsuario"];

   # CONEXION DB
   include '../php/conexion.php';

   #RUTA ABSOLUTA PARA ENLACES
   $rutaAbsoluta = "";
   if (strpos($_SERVER['REQUEST_URI'], "america") == true)
      $rutaAbsoluta = "https://www.maphg.com/america";
   if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
      $rutaAbsoluta = "https://www.maphg.com/europa";
   if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
      $rutaAbsoluta = "http://10.30.30.104/maphg-beta";

   #STATUS DE RESPUESTA DEL SERVER
   $array['status'] = 'OK';
   $array['resp'] = "ERROR";
   $array['data'] = array();

   if ($action === "subirFotoUsuario") {
      $array['files'] = $_FILES;
      $array['resp'] = "SUCCESS";

      $rutaTemporal = $_FILES["file"]["tmp_name"];
      $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
      $foto =  "AVATAR_ID_" . $idUsuario . "_" . rand(1, 999) . ".$extension";

      if (move_uploaded_file($rutaTemporal, "../planner/avatars/" . $foto)) {
         $query = "UPDATE t_users u, t_colaboradores c SET c.foto = '$foto' WHERE u.id_colaborador = c.id and u.id = $idUsuario";
         if ($result = mysqli_query($conn_2020, $query)) {
            $array['resp'] = "SUCCESS";
            $array['data'] = $rutaAbsoluta . "/planner/avatars/" . $foto;
         }
      }
   }
}

mysqli_close($conn_2020);
echo json_encode($array);
