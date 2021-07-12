<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../php/conexion.php';
header("Access-Control-Allow-Origin: *");
// header('Content-Type: application/json');

if (isset($_GET['action'])) {

   //Variables Globales
   $action = $_GET['action'];
   $idUsuario = $_GET['idUsuario'];
   $idDestino = $_GET['idDestino'];
   $fechaActual = date('Y-m-d H:m:s');
   $añoActual = date('Y');
   $array = array();

   if ($action == "obtenerActivos") {
      $data = json_decode(file_get_contents('php://input'), true);
      $palabra = $data['palabra'];

      #FILTRO PARA DESTINO
      if ($idDestino == 10) {
         $filtroDestino = "";
         $filtroDestinoEquipos = "";
      } else {
         $filtroDestino = "and m.id_destino = $idDestino";
         $filtroDestinoEquipos = "and e.id_destino = $idDestino";
      }

      if ($palabra == "") {
         $filtroPalabraMaterial = "";
         $filtroPalabraEquipo = "";
      } else {
         $filtroPalabraMaterial = " 
         AND (m.cod2bend LIKE '%$palabra%' OR 
         m.descripcion_cod2bend LIKE '%$palabra%' OR 
         m.descripcion_servicio_tecnico LIKE '%$palabra%' OR
         seccion.seccion LIKE '%$palabra%' OR
         subseccion.grupo LIKE '%$palabra%' OR
         m.marca LIKE '%$palabra%' OR 
         m.modelo LIKE '%$palabra%' OR
         m.caracteristicas LIKE '%$palabra%' OR
         m.categoria LIKE '%$palabra%' OR
         m.stock_teorico LIKE '%$palabra%' OR
         m.precio LIKE '%$palabra%' OR
         m.subfamilia LIKE '%$palabra%' OR 
         m.tiempo_vida_util LIKE '%$palabra%' OR
         m.fecha_instalacion LIKE '%$palabra%' OR
         m.fecha_estimada_remplazo LIKE '%$palabra%' OR
         m.clasificacion LIKE '%$palabra%')";

         $filtroPalabraEquipo = "
         AND (e.id LIKE '%$palabra%' OR
         e.cod2bend LIKE '%$palabra%' OR
         e.equipo LIKE '%$palabra%' OR
         seccion.seccion LIKE '%$palabra%' OR
         subseccion.grupo LIKE '%$palabra%' OR
         marca.marca LIKE '%$palabra%' OR
         e.modelo LIKE '%$palabra%' OR
         e.coste LIKE '%$palabra%' OR
         e.clasificacion LIKE '%$palabra%')";
      }

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
      m.fecha_estimada_remplazo,
      m.clasificacion
      FROM t_subalmacenes_items_globales AS m 
      LEFT JOIN c_secciones AS seccion ON m.id_seccion = seccion.id
      LEFT JOIN c_subsecciones AS subseccion ON m.id_subseccion = subseccion.id
      WHERE m.activo = 1 $filtroDestino $filtroPalabraMaterial";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idItem = $x['id'];
            $cod2bend = $x['cod2bend'];
            $descripcionCod2bend = $x['descripcion_cod2bend'];
            $descripcionSST = $x['descripcion_servicio_tecnico'];
            $seccion = $x['seccion'];
            $subseccion = $x['grupo'];
            $grupo = "";
            $clasificacion = $x['clasificacion'];
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
               "coste" => "",
               "costeTeorico" => "",
               "costeReal" => "",
               "subfamiliaSSTT" => "",
               "tiempoVidaUtil" => $tiempoVidaUtil,
               "fechaInstalacion" => $fechaInstalacion,
               "fechaEstimadaRemplazo" => $fechaEstimadaRemplazo,
               "tipoActivo" => "/materiales/" . intval($idItem)
            );
         }
      }

      #EQUIPOS
      $query = "SELECT
      e.id,
      e.cod2bend,
      e.equipo,
      seccion.seccion,
      subseccion.grupo,
      marca.marca,
      e.modelo,
      e.coste,
      e.clasificacion
      FROM t_equipos_america AS e
      INNER JOIN c_secciones AS seccion ON e.id_seccion = seccion.id
      INNER JOIN c_subsecciones AS subseccion ON e.id_subseccion = subseccion.id
      LEFT JOIN c_marcas AS marca ON e.id_marca = marca.id
      WHERE e.activo = 1 and e.status NOT IN('BAJA') $filtroDestinoEquipos $filtroPalabraEquipo";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idItem = $x['id'];
            $cod2bend = $x['cod2bend'];
            $descripcionCod2bend = "EQUIPO";
            $descripcionSST = $x['equipo'];
            $seccion = $x['seccion'];
            $subseccion = $x['grupo'];
            $grupo = "";
            $clasificacion = $x['clasificacion'];
            $marca = $x['marca'];
            $modelo = $x['modelo'];
            $caracteristicas = "";
            $rotacion = "";
            $stockTeorico = "";
            $coste = $x['coste'];
            $subfamilia = "";
            $tiempoVidaUtil = "";
            $fechaInstalacion = "";
            $fechaEstimadaRemplazo = "";
            $referencia = "";
            $stockReal = 0;

            #STOCK REAL
            $query = "SELECT sum(stock_actual) 'total' 
            FROM t_subalmacenes_items_stock 
            WHERE activo = 1 and id_item_global = $idItem LIMIT 1";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $stockReal = $x['total'];
               }
            }

            #SECCION VACIA
            if (
               $seccion == null || $seccion == ''
            )
               $seccion = "";

            #SUBSECCION VACIA
            if (
               $subseccion == null || $subseccion == ''
            )
               $subseccion = "";

            #FECHA VACIA
            if (
               $fechaInstalacion == null || $fechaInstalacion == ''
            )
               $fechaInstalacion = "";

            #FECHA VACIA
            if ($fechaEstimadaRemplazo == null || $fechaEstimadaRemplazo == '')
               $fechaEstimadaRemplazo = "";

            #MARCA VACIA
            if ($marca == null || $marca == '')
               $marca = "";

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
               "coste" => "",
               "costeTeorico" => "",
               "costeReal" => "",
               "subfamiliaSSTT" => "",
               "tiempoVidaUtil" => $tiempoVidaUtil,
               "fechaInstalacion" => $fechaInstalacion,
               "fechaEstimadaRemplazo" => $fechaEstimadaRemplazo,
               "tipoActivo" => "/activos/" . intval($idItem)
            );
         }
      }

      #REGRESA LOS VALORES ENCONTRADOS
      echo json_encode($array);
   }
}
