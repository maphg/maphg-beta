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
   $idUsuario = $_GET['idUsuario'];
   $idDestino = $_GET['idDestino'];
   $fechaActual = date('Y-m-d H:m:s');
   $añoActual = date('Y');
   $array = array();
   $permisos = 0;

   $query = "SELECT id FROM t_users WHERE id = $idUsuario";
   if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
         $permisos = 1;
      }
   }

   #OBTIENE INFORMACIÓN DE MATERIAL SEGÚN ID
   if ($action == "obtenerMaterial") {
      $query = "";
   }
}