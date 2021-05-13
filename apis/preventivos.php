<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../php/conexion.php';
header("Access-Control-Allow-Origin: *");
if (isset($_GET['action'])) {

   //Variables Globales
   $action = $_GET['action'];
   // $idUsuario = $_GET['idUsuario'];
   // $idDestino = $_GET['idDestino'];
   $fechaActual = date('Y-m-d H:m:s');
   $añoActual = date('Y');
   $array = array();

   if ($action == "preventivo") {
      $idPreventivo = $_GET['idPreventivo'];

      $query = "SELECT mp.id
      FROM t_mp_planificacion_iniciada AS mp
      INNER JOIN t_equipos_america AS e ON mp.id_equipo = e.id
      WHERE mp.id = $idPreventivo and mp.activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idPreventivo = $x['id'];

            $array[] = array(
               "idPreventivo" => intval($idPreventivo)
            );
         }
      }
      echo json_encode($array);
   }
}
