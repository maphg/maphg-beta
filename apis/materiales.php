<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../php/conexion.php';
header("Access-Control-Allow-Origin: *");
if (isset($_GET['action'])) {

   #Variables Globales
   $action = $_GET['action'];
   $fechaActual = date('Y-m-d H:m:s');
   $idPermisos = 0;
   $idMaterial = $_GET['id'];
   $array = array();

   #OBTIENE EL ID DE PERMSISOS DE USUARIO
   if (isset($_GET['idUsuario'])) {
      $idUsuario = $_GET['idUsuario'];
      $query = "SELECT id_permiso FROM t_users WHERE id = $idUsuario";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idPermisos = 1;
         }
      }
   }


   #OBTIENE INFORMACIÓN DE MATERIAL SEGÚN ID
   if ($action == "obtenerMaterial" && ($idPermisos == 0 || $idPermisos == 1 || $idPermisos == 2 || $idPermisos == 3)) {
      $idItem  = $_GET['id'];

      #MATERIALES
      $query = "SELECT 
      m.id,
      m.cod2bend, 
      m.descripcion_cod2bend, 
      m.descripcion_servicio_tecnico,
      seccion.seccion,
      subseccion.grupo,
      m.marca, 
      m.modelo,
      m.caracteristicas,
      m.categoria,
      m.stock_teorico,
      m.precio,
      m.subfamilia, 
      m.tiempo_vida_util,
      m.fecha_instalacion,
      m.fecha_estimada_remplazo
      FROM t_subalmacenes_items_globales AS m 
      LEFT JOIN c_secciones AS seccion ON m.id_seccion = seccion.id
      LEFT JOIN c_subsecciones AS subseccion ON m.id_subseccion = subseccion.id
      WHERE m.id = $idItem";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idItem = $x['id'];
            $clasificacion = "FF&E";
            $cod2bend = $x['cod2bend'];
            $descripcionCod2bend = $x['descripcion_cod2bend'];
            $descripcionSST = $x['descripcion_servicio_tecnico'];
            $seccion = $x['seccion'];
            $subseccion = $x['grupo'];
            $grupo = "";
            $marca = $x['marca'];
            $modelo = $x['modelo'];
            $caracteristicas = $x['caracteristicas'];
            $referencia = "";
            $rotacion = $x['categoria'];
            $stockTeorico = $x['stock_teorico'];
            $coste = $x['precio'];
            $subfamilia = $x['subfamilia'];
            $tiempoVidaUtil = $x['tiempo_vida_util'];
            $fechaInstalacion = $x['fecha_instalacion'];
            $fechaEstimadaRemplazo = $x['fecha_estimada_remplazo'];
            $informacionAdicional = "";

            $stockReal = 0;
            $query = "SELECT sum(stock_actual) 'total' 
            FROM t_subalmacenes_items_stock 
            WHERE activo = 1 and id_item_global = $idItem";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $stockReal = $x['total'];
               }
            }

            if ($seccion == null || $seccion == '')
               $seccion = "";

            if ($subseccion == null || $subseccion == '')
               $subseccion = "";

            if ($fechaInstalacion == null || $fechaInstalacion == '')
               $fechaInstalacion = "";

            if ($fechaEstimadaRemplazo == null || $fechaEstimadaRemplazo == '')
               $fechaEstimadaRemplazo = "";

            #COSTE REAL
            if ($coste > 0 && $stockReal > 0)
               $costeReal = $coste * $stockReal;
            else
               $costeReal = 0;

            #COSTE TEORICO
            if ($coste > 0 && $stockTeorico > 0)
               $costeTeorico = $coste * $stockTeorico;
            else
               $costeTeorico = 0;

            #COSTE UNITARIO
            if ($coste <= 0)
               $coste = 0;

            $array[] = array(
               "idItem" => intval($idItem),
               "cod2bend" => $cod2bend,
               "descripcionCod2bend" => $descripcionCod2bend,
               "descripcionSST" => $descripcionSST,
               "seccion" => $seccion,
               "subseccion" => $subseccion,
               "grupo" => $grupo,
               "clasificacion" => $clasificacion,
               "marca" => $marca,
               "modelo" => $modelo,
               "caracteristicas" => $caracteristicas,
               "referencia" => $referencia,
               "rotacion" => $rotacion,
               "stockTeorico" => $stockTeorico,
               "stockReal" => $stockReal,
               "coste" => strval($coste),
               "costeTeorico" => strval($costeTeorico),
               "costeReal" => strval($costeReal),
               "subfamiliaSSTT" => "",
               "tiempoVidaUtil" => $tiempoVidaUtil,
               "fechaInstalacion" => $fechaInstalacion,
               "fechaEstimadaRemplazo" => $fechaEstimadaRemplazo,
               "informacionAdicional" => $informacionAdicional,
               "tipoActivo" => "/materiales/" . intval($idItem),
            );
         }
      }
      echo json_encode($array);
   }
}
