<?php
header("Access-Control-Allow-Origin: *");

if (isset($_POST["action"])) {
   $action = $_POST["action"];
   $idDestino = $_POST["idDestino"];
   $idUsuario = $_POST["idUsuario"];

   # CONEXION DB
   include '../php/conexion.php';

   $array['status'] = '404';

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
         }
      }
   }
}

mysqli_close($conn_2020);
echo json_encode($array);
