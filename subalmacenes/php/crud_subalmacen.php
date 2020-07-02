<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
include "conexion.php";
session_start();

if (isset($_POST['action'])) {
  // Variables Globales.
  $idDestino = $_SESSION['idDestino'];
  $idUsuario = $_SESSION['usuario'];
  $superAdmin = $_SESSION['super_admin'];
  $fechaActual = date('Y-m-d H:m:s');

  // Permisos Generales.
  $queryPermisos = "SELECT* FROM c_acciones_usuarios WHERE id_usuario = $idUsuario LIMIT 1";
  if ($resultPermisos = mysqli_query($conn_2020, $queryPermisos)) {
    if ($rowPermisos = mysqli_fetch_array($resultPermisos)) {
      $entradasPermiso = $rowPermisos['entradas_sa'];
      $salidasPermiso = $rowPermisos['salidas_sa'];
      // Importar se consideta como Movimiento de Stock entre Subalmacenes.
      $movientosPermiso = $rowPermisos['importar_gastos'];
      $subalmacenesAcceso = $rowPermisos['acceso_sa'];

      // Comprueba si tiene información.
      if ($subalmacenesAcceso != "") {
        $subalmacenesAcceso = $subalmacenesAcceso;
      } else {
        $subalmacenesAcceso = 0;
      }
    }
  }

  $action = $_POST['action'];

  if ($action == "Agregar") {
    $idFase = $_POST['idFase'];
    $subalmacen = $_POST['subalmacen'];

    switch ($idFase) {
      case 1:
        $fase = "GP";
        break;

      case 2:
        $fase = "TRS";
        break;

      case 3:
        $fase = "ZI";
        break;
    }


    $query = "INSERT INTO  t_subalmacenes(id_destino, id_fase, nombre, fase) VALUES($idDestino, $idFase, '$subalmacen', '$fase')";
    $result = mysqli_query($conn_2020, $query);
    if ($result) {
      echo "1";
    } else {
      echo "0";
    }
  }

  if ($action == "Actualizar") {
    $idDestino = $_POST['idDestino'];
    $idFase = $_POST['idFase'];
    $subalmacen = $_POST['subalmacen'];
    $idSubalmacen = $_POST['idSubalmacen'];

    switch ($idFase) {
      case 1:
        $fase = "GP";
        break;

      case 2:
        $fase = "TRS";
        break;

      case 3:
        $fase = "ZI";
        break;
    }


    $query = "UPDATE  t_subalmacenes SET nombre='$subalmacen', id_fase=$idFase,  fase='$fase' WHERE id=$idSubalmacen";
    $result = mysqli_query($conn_2020, $query);
    if ($result) {
      echo "Agregado";
    } else {
      echo "Error Agregar";
    }
  }

  if ($action == "eliminarSubalmacen") {
    $idDestino = $_POST['idDestino'];
    $idFase = $_POST['idFase'];
    $subalmacen = $_POST['subalmacen'];
    $idSubalmacen = $_POST['idSubalmacen'];

    switch ($idFase) {
      case 1:
        $fase = "GP-eliminado";
        break;

      case 2:
        $fase = "TRS-eliminado";
        break;

      case 3:
        $fase = "ZI-eliminado";
        break;
    }


    $query = "UPDATE  t_subalmacenes SET fase='$fase' WHERE id=$idSubalmacen";
    $result = mysqli_query($conn_2020, $query);
    if ($result) {
      echo "Agregado";
    } else {
      echo "Error Agregar";
    }
  }



  if ($action == "consultaSubalmacen") {
    $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
    $arraySubalmacen = array();
    $dataGP = "";
    $dataTRS = "";
    $dataZI = "";

    if ($idDestinoSeleccionado == 10) {
      $filtroDestino = " AND id IN($subalmacenesAcceso)";
    } else {
      $filtroDestino = "AND id_destino = $idDestinoSeleccionado AND id IN($subalmacenesAcceso)";
    }

    $query = "SELECT 
        id, id_destino, id_fase, nombre, fase, tipo 
        FROM t_subalmacenes 
        WHERE activo = 1 $filtroDestino";
    $result = mysqli_query($conn_2020, $query);

    while ($row = mysqli_fetch_array($result)) {
      $idSubalmacen = $row['id'];
      $idFase = $row['id_fase'];
      $nombre = $row['nombre'];
      $fase = $row['fase'];
      $tipo = $row['tipo'];
      $idDiv = $idSubalmacen . 'sub';
      if ($fase == "GP") {
        if ($tipo == "SUBALMACEN") {
          $dataGP .= "
            <!-- SUBALMACEN -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); idSubalmacenSeleccionado($idSubalmacen, '$fase', '$nombre');\"
            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"" . $idSubalmacen . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

          if ($entradasPermiso == 1) {
            $dataGP .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md\"
            onclick=\"entradasSubalmacen($idSubalmacen,'');\">
            <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
            </div>
            ";
          }

          if ($salidasPermiso == 1) {
            $dataGP .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>";
          }

          $dataGP .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
                </div>
            </div>
            <!-- SUBALMACEN -->              
          ";
        } elseif ($tipo == "BODEGA") {
          $dataGP .= "
            <!-- BODEGA -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); idSubalmacenSeleccionado($idSubalmacen, '$fase', '$nombre');\"
            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"" . $idSubalmacen . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

          if ($entradasPermiso == 1) {
            $dataGP .= "
              <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md\" onclick=\"entradasSubalmacen($idSubalmacen,'');\">
              <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
              </div>
            ";
          }

          if ($salidasPermiso == 1) {
            $dataGP .= "
             <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
              <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
              </div>
            ";
          }

          $dataGP .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
            </div>
            </div>
            <!-- BODEGA -->            
          ";
        }
      } elseif ($fase == "TRS") {
        if ($tipo == "SUBALMACEN") {
          $dataTRS .= "
            <!-- SUBALMACEN -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); idSubalmacenSeleccionado($idSubalmacen, '$fase', '$nombre');\"
            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"" . $idSubalmacen . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

          if ($entradasPermiso == 1) {
            $dataTRS .= "  
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md\" onclick=\"entradasSubalmacen($idSubalmacen,'');\">
            <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
            </div>
            ";
          }

          if ($salidasPermiso == 1) {

            $dataTRS .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>
            ";
          }

          $dataTRS .= " 
          <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
            </div>
            </div>
            <!-- SUBALMACEN -->              
          ";
        } elseif ($tipo == "BODEGA") {
          $dataTRS .= "
            <!-- BODEGA -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); idSubalmacenSeleccionado($idSubalmacen, '$fase', '$nombre');\"
            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"$idSubalmacen" . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
            ";

          if ($entradasPermiso == 1) {
            $dataTRS .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md\" onclick=\"entradasSubalmacen($idSubalmacen,'');\">
            <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
            </div>
            ";
          }

          if ($salidasPermiso == 1) {
            $dataTRS .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>
            ";
          }

          $dataTRS .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
            </div>
            </div>
            <!-- BODEGA -->            
          ";
        }
      } elseif ($fase == "ZI") {
        if ($tipo == "SUBALMACEN") {
          $dataZI .= "
            <!-- SUBALMACEN -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); idSubalmacenSeleccionado($idSubalmacen, '$fase', '$nombre');\"
            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"$idSubalmacen" . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

          if ($entradasPermiso == 1) {
            $dataZI .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md\" onclick=\"entradasSubalmacen($idSubalmacen,'');\">
            <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
            </div>
            ";
          }

          if ($salidasPermiso == 1) {
            $dataZI .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>
            ";
          }

          $dataZI .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
            </div>
            </div>
            <!-- SUBALMACEN -->              
          ";
        } elseif ($tipo == "BODEGA") {
          $dataZI .= "
            <!-- BODEGA -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); idSubalmacenSeleccionado($idSubalmacen, '$fase', '$nombre');\"
            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"$idSubalmacen" . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

          if ($entradasPermiso == 1) {
            $dataZI .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md\" onclick=\"entradasSubalmacen($idSubalmacen,'');\">
            <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
            </div>
            ";
          }

          if ($salidasPermiso == 1) {
            $dataZI .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>
            ";
          }

          $dataZI .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
            </div>
            </div>
            <!-- BODEGA -->            
          ";
        }
      }
    }

    $arraySubalmacen['dataGP'] = $dataGP;
    $arraySubalmacen['dataTRS'] = $dataTRS;
    $arraySubalmacen['dataZI'] = $dataZI;

    echo json_encode($arraySubalmacen);
  }


  if ($action == "agregarSubalmacen") {
    // $idDestino Se obtiene de la session.
    $titulo = $_POST['titulo'];
    $fase = $_POST['fase'];
    $faseArray = array("GP" => 1, "TRS" => 2, "ZI" => 3);
    $idFase = $faseArray[$fase];

    $query = "INSERT INTO 
        t_subalmacenes(id_destino, id_fase, nombre, fase) 
        VALUES($idDestino, $idFase, '$titulo', '$fase')";

    if (mysqli_query($conn_2020, $query)) {
      echo "Se agrego Subalmacén ($titulo)";
    } else {
      echo "Error al agregar Subalmacén ($titulo)";
    }
  }


  // Nuevas funciones para la version Beta_2020.

  if ($action == "eliminar_Subalmacen") {
    $idSubalmacen = $_POST['idSubalmacen'];
    $query = "UPDATE t_subalmacenes SET activo = 0 WHERE id = $idSubalmacen";
    if (mysqli_query($conn_2020, $query)) {
      echo "Subalmacén Eliminado";
    } else {
      echo "Error al Eliminar Subalmacén";
    }
  }


  if ($action == "editarSubalmacen") {
    $idSubalmacen = $_POST['idSubalmacen'];
    $tituloSubalmacen = $_POST['tituloSubalmacen'];

    $query = "UPDATE t_subalmacenes SET nombre = '$tituloSubalmacen' WHERE id = $idSubalmacen";
    if (mysqli_query($conn_2020, $query)) {
      echo "Subalmacén Actualizado";
    } else {
      echo "Error al Actualizar";
    }
  }


  if ($action == "consultaExistenciasSubalmacen") {
    $idSubalmacen = $_POST['idSubalmacen'];
    $arrayExistenciaSubalmacen = array();
    $dataExistenciaSubalmacen = "";
    $palabraBuscar = $_POST['palabraBuscar'];
    $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
    $contador = 0;
    $totalResultados = 0;

    if ($palabraBuscar != "") {
      $palabraBuscar = "AND (t_subalmacenes_items_globales.categoria LIKE '%$palabraBuscar%' 
      OR t_subalmacenes_items_globales.cod2bend LIKE '%$palabraBuscar%' 
      OR t_subalmacenes_items_globales.descripcion LIKE '%$palabraBuscar%' 
      OR t_subalmacenes_items_globales.caracteristicas LIKE '%$palabraBuscar%' 
      OR bitacora_gremio.nombre_gremio LIKE '%$palabraBuscar%' 
      OR t_subalmacenes_items_globales.marca LIKE '%$palabraBuscar%')";
    } else {
      $palabraBuscar = "";
    }

    $query_subalmacen = "SELECT nombre, fase FROM t_subalmacenes 
    WHERE id = $idSubalmacen AND id_destino = $idDestinoSeleccionado";
    $result_subalmacen = mysqli_query($conn_2020, $query_subalmacen);
    if ($row_subalmacen = mysqli_fetch_array($result_subalmacen)) {
      $nombre = $row_subalmacen['nombre'];
      $fase = $row_subalmacen['fase'];

      $arrayExistenciaSubalmacen['nombreSubalmacen'] = $nombre;
      $arrayExistenciaSubalmacen['faseSubalmacen'] = $fase;
    }

    $query = "SELECT
    t_subalmacenes_items_globales.id,
    t_subalmacenes_items_globales.categoria,
    t_subalmacenes_items_globales.cod2bend,
    t_subalmacenes_items_globales.tipo_material,
    t_subalmacenes_items_globales.descripcion,
    t_subalmacenes_items_globales.caracteristicas,
    t_subalmacenes_items_globales.marca,
    t_subalmacenes_items_globales.unidad,
    t_subalmacenes_items_stock.stock_teorico,
    t_subalmacenes_items_stock.stock_actual,
    bitacora_gremio.nombre_gremio
    FROM t_subalmacenes_items_stock 
    INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock.id_item_global =  t_subalmacenes_items_globales.id
    INNER JOIN bitacora_gremio ON t_subalmacenes_items_globales.id_gremio =  bitacora_gremio.id
    WHERE t_subalmacenes_items_stock.id_subalmacen = $idSubalmacen AND
    t_subalmacenes_items_stock.id_destino = $idDestinoSeleccionado $palabraBuscar
    ";
    if ($result = mysqli_query($conn_2020, $query)) {
      while ($row = mysqli_fetch_array($result)) {
        $contador++;
        $idItem = $row['id'];
        $categoria = $row['categoria'];
        $cod2bend = $row['cod2bend'];
        $gremio = $row['nombre_gremio'];
        $descripcion = $row['descripcion'];
        $caracteristicas = $row['caracteristicas'];
        $marca = $row['marca'];
        $cantidadActual = $row['stock_actual'];
        $cantidadTeorico = $row['stock_teorico'];
        $unidad = $row['unidad'];


        if ($cantidadActual < 1) {
          $colorstilo = "text-red-500 bg-red-200";
        } elseif ($cantidadActual >= $cantidadTeorico) {
          $colorstilo = "text-yellow-700 bg-yellow-200";
        } else {
          $colorstilo = "text-bluegray-500 bg-bluegray-50";
        }

        $dataExistenciaSubalmacen .= "
                <div
                    class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 rounded hover:bg-indigo-100 cursor-pointer $colorstilo\">
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$categoria</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cod2bend</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$gremio</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$descripcion</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$caracteristicas</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$marca</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cantidadTeorico</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cantidadActual</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center\">
                        <h1>$unidad</h1>
                    </div>
                </div>            
            ";
      }
      if ($totalResultados = mysqli_num_rows($result)) {
        $arrayExistenciaSubalmacen['totalResultados'] = $totalResultados;
      } else {
        $arrayExistenciaSubalmacen['totalResultados'] = 0;
      }
      $arrayExistenciaSubalmacen['dataExistenciaSubalmacen'] = $dataExistenciaSubalmacen;
    }

    echo json_encode($arrayExistenciaSubalmacen);
  }


  if ($action == "consultaSalidaSubalmacen") {

    $idSubalmacen = $_POST['idSubalmacen'];
    $arraySalidaSubalmacen = array();
    $dataSalidaSubalmacen = "";
    $palabraBuscar = $_POST['palabraBuscar'];
    $contador = 0;

    if ($palabraBuscar != "") {
      $palabraBuscar = "AND (categoria LIKE '%$palabraBuscar%' OR cod2bend LIKE '%$palabraBuscar%' OR descripcion LIKE '%$palabraBuscar%' OR caracteristicas LIKE '%$palabraBuscar%' OR marca LIKE '%$palabraBuscar%')";
    } else {
      $palabraBuscar = "";
    }

    $query_subalmacen = "SELECT nombre, fase FROM t_subalmacenes WHERE id = $idSubalmacen";
    $result_subalmacen = mysqli_query($conn_2020, $query_subalmacen);
    if ($row_subalmacen = mysqli_fetch_array($result_subalmacen)) {
      $nombre = $row_subalmacen['nombre'];
      $fase = $row_subalmacen['fase'];

      $arraySalidaSubalmacen['nombreSubalmacen'] = $nombre;
      $arraySalidaSubalmacen['faseSubalmacen'] = $fase;
    }

    $query = "SELECT* FROM t_subalmacenes_items WHERE id_subalmacen = $idSubalmacen $palabraBuscar AND cantidad > 0";
    $result = mysqli_query($conn_2020, $query);
    while ($row = mysqli_fetch_array($result)) {
      $contador++;
      $idItem = $row['id'];
      $idSubalmacen = $row['id_subalmacen'];
      $categoria = $row['categoria'];
      $cod2bend = $row['cod2bend'];
      $gremio = $row['tipo_material'];
      $descripcion = $row['descripcion'];
      $caracteristicas = $row['caracteristicas'];
      $marca = $row['marca'];
      $cantidadTeorico = $row['cantidad'];
      $cantidadActual = floatval($row['cantidad']);
      $unidad = $row['unidad'];

      $dataSalidaSubalmacen .= "
                <!-- ITEM -->
                <div class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer\">
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$categoria</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cod2bend</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$gremio</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$descripcion</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$caracteristicas</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$marca</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cantidadTeorico</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cantidadActual</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center\">
                        <h1>$unidad</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center\">
                      
                      <input id=\"$idItem\" class=\"border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 px-2 rounded-r-md text-sm focus:outline-none w-full\" type=\"number\" placeholder=\"Cantidad Max $cantidadActual\" 
                      onkeyup=\"if(event.keyCode == 48 | event.keyCode == 49 | event.keyCode == 50 | event.keyCode == 51 | event.keyCode == 52 | event.keyCode == 53 | event.keyCode == 54 | event.keyCode == 55 | event.keyCode == 56 | event.keyCode == 57 | event.keyCode == 58)validarCantidaSalidaSubalmacen($idItem, '$descripcion', $cantidadActual, $idSubalmacen);\">
                    </div>
                </div>
                <!-- ITEM -->            
            ";
    }

    if ($totalResultados = mysqli_num_rows($result)) {
      $arraySalidaSubalmacen['totalResultados'] = $totalResultados;
    } else {
      $arraySalidaSubalmacen['totalResultados'] = 0;
    }
    $arraySalidaSubalmacen['dataSalidaSubalmacen'] = $dataSalidaSubalmacen;
    echo json_encode($arraySalidaSubalmacen);
  }


  if ($action == "validarCantidaSalidaSubalmacen") {
    $idDestino = $_POST['idDestino'];
    $idItem = $_POST['idItem'];
    $cantidadAnterior = floatval($_POST['cantidadActual']);
    $cantidad = floatval($_POST['cantidad']);
    $cantidadActual = floatval($cantidadAnterior - $cantidad);
    $idSubalmacen = $_POST['idSubalmacen'];
    $query_consulta = "SELECT id FROM t_subalmacenes_movimientos_salidas_temp 
    WHERE id_usuario = $idUsuario AND id_destino = $idDestino AND id_material = $idItem AND id_subalmacen = $idSubalmacen";
    if ($resultado_consulta = mysqli_query($conn_2020, $query_consulta)) {
      if (mysqli_num_rows($resultado_consulta) >= 1) {
        if ($row = mysqli_fetch_array($resultado_consulta)) {
          $idConsulta = $row['id'];
          $fechaMovimiento = date('Y-m-d H:m:s');

          $query = "UPDATE t_subalmacenes_movimientos_salidas_temp 
          SET cantidad_salida = $cantidad, fecha_salida = '$fechaMovimiento'
          WHERE status ='ESPERA' AND id = $idConsulta";
          if ($result = mysqli_query($conn_2020, $query)) {
            echo "Cantidad Actualizada";
          } else {
            echo "Cantidad No Valida";
          }
        }
      } else {
        $query = "INSERT INTO t_subalmacenes_movimientos_salidas_temp(id_usuario, id_destino, id_subalmacen, id_material, cantidad_salida, cantidad_anterior, cantidad_actual) 
            VALUES($idUsuario, $idDestino, $idSubalmacen, $idItem, $cantidad, $cantidadAnterior, $cantidadActual)";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
          echo "Se agrego al Carrito";
        } else {
          echo "Error al Agregar";
        }
      }
    }
  }
  if ($action == "consultaCarritoSalida") {
    $idDestino = $_POST['idDestino'];
    $idSubalmacen = $_POST['idSubalmacen'];
    $arrayCarritoSalidas = array();
    $dataCarritoSalidas = "";
    $cantidadCarrito = "";
    $idItemCarrito = "";
    $idRegistro = "";

    $query = "SELECT 
            t_subalmacenes_movimientos_salidas_temp.id,
            t_subalmacenes_movimientos_salidas_temp.cantidad_salida, 
            t_subalmacenes_items.descripcion, 
            t_subalmacenes_items.caracteristicas,
            t_subalmacenes_items.precio,
            t_subalmacenes_movimientos_salidas_temp.id_material
            FROM t_subalmacenes_movimientos_salidas_temp 
            INNER JOIN t_subalmacenes_items ON t_subalmacenes_movimientos_salidas_temp.id_material = t_subalmacenes_items.id
            WHERE 
            t_subalmacenes_movimientos_salidas_temp.id_usuario = $idUsuario 
            AND t_subalmacenes_movimientos_salidas_temp.id_subalmacen = $idSubalmacen 
            AND t_subalmacenes_movimientos_salidas_temp.id_destino = $idDestino
            AND t_subalmacenes_movimientos_salidas_temp.status = 'ESPERA'
            AND t_subalmacenes_movimientos_salidas_temp.cantidad_salida > 0.00000000000001 

            ORDER BY t_subalmacenes_movimientos_salidas_temp.fecha_salida ASC
            ";


    $result = mysqli_query($conn_2020, $query);
    if ($result) {
      while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $idItem = $row['id_material'];
        $cantidad = $row['cantidad_salida'];
        $descripcion = $row['descripcion'];
        $caracteristicas = $row['caracteristicas'];
        $precio = $row['precio'];

        $idItemCarrito .= $idItem . ",";
        $cantidadCarrito .= $cantidad . ",";
        $idRegistro .= $id . ",";

        $dataCarritoSalidas .= " 
                    <!-- ITEM -->
                    <div
                        class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer\">
                        <div class=\"w-32 flex h-full items-center justify-center truncate\">
                            <h1>$cantidad</h1>
                        </div>
                        <div class=\"w-64 flex h-full items-center justify-center truncate\">
                            <h1>$descripcion</h1>
                        </div>
                        <div class=\"w-64 flex h-full items-center justify-center truncate\">
                            <h1>$caracteristicas</h1>
                        </div>
                        <div class=\"w-32 flex h-full items-center justify-center\">
                            <h1>$precio</h1>
                        </div>
                    </div>
                    <!-- ITEM -->
                ";
      }
    }

    $arrayCarritoSalidas['dataCarritoSalidas'] = $dataCarritoSalidas;
    $arrayCarritoSalidas['cantidadCarrito'] = $cantidadCarrito;
    $arrayCarritoSalidas['idItemCarrito'] = $idItemCarrito;
    $arrayCarritoSalidas['idRegistro'] = $idRegistro;
    echo json_encode($arrayCarritoSalidas);
  }


  if ($action == "restablecerCarritoSalidas") {
    $idDestino = $_POST['idDestinoSeleccionado'];
    $idSubalmacen = $_POST['idSubalmacen'];
    $query = "UPDATE t_subalmacenes_movimientos_salidas_temp 
    SET status = 'CANCELADO'
      WHERE 
      id_usuario = $idUsuario 
      AND id_subalmacen = $idSubalmacen 
      AND id_destino = $idDestino
      AND status = 'ESPERA'
    ";
    if ($result = mysqli_query($conn_2020, $query)) {
      echo "Carrito Restablecido";
    } else {
      echo "Intenta de Nuevo";
    }
  }


  if ($action == "consultaOpcion") {
    $idDestino = $_POST['idDestino'];
    $paso = $_POST['paso'];
    $dataSecciones = "";
    $dataSubsecciones = "";
    $dataEquipos = "";
    $dataMCE = "";
    $dataMCTG = "";
    $dataMP = "";

    if ($paso == "opcionSeccion") {
      $query = "SELECT c_secciones.id, c_secciones.seccion 
        FROM c_rel_destino_seccion
        INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino";

      if ($result = mysqli_query($conn_2020, $query)) {
        $dataSecciones .= "
            <select id=\"opcionSeccion\"
                class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('opcionSubseccion');\">
        ";

        while ($row = mysqli_fetch_array($result)) {
          $idSeccion = $row['id'];
          $seccion = $row['seccion'];

          $dataSecciones .= "
            <option value=\"$idSeccion\">$seccion</option>
          ";
        }

        $dataSecciones .= "</select>";
      }
      echo $dataSecciones;
    } elseif ($paso == "opcionSubseccion") {
      $idSeccion = $_POST['idSeccion'];

      $query = "
            SELECT 
            c_subsecciones.id, c_subsecciones.grupo
            FROM c_rel_destino_seccion
            INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
            INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
            WHERE c_rel_destino_seccion.id_destino= $idDestino AND c_rel_destino_seccion.id_seccion = $idSeccion            
            ";
      if ($result = mysqli_query($conn_2020, $query)) {
        $dataSubsecciones .= "
                    <select id=\"opcionSubseccion\"
                        class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('opcionEquipo');\">
                 ";
        while ($row = mysqli_fetch_array($result)) {
          $idSubseccion = $row['id'];
          $subseccion = $row['grupo'];

          $dataSubsecciones .= "
                        <option value=\"$idSubseccion\">$subseccion</option>
                    ";
        }
        $dataSubsecciones .= "$idDestino</select>";
      }
      echo $dataSubsecciones;
    } elseif ($paso == "opcionEquipo") {
      $idSeccion = $_POST['idSeccion'];
      $idSubseccion = $_POST['idSubseccion'];
      $tipoPendiente = $_POST['tipoPendiente'];

      $query = "SELECT id, equipo FROM t_equipos 
            WHERE 
            id_destino = $idDestino AND 
            id_seccion = $idSeccion AND 
            id_subseccion = $idSubseccion AND 
            status = 'A'
            ";

      if ($result = mysqli_query($conn_2020, $query)) {
        $dataEquipos .= "
          <select id=\"opcionEquipo\"
              class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('opcionPendiente');\">
        ";
        while ($row = mysqli_fetch_array($result)) {
          $idEquipo = $row['id'];
          $equipo = $row['equipo'];
          if ($tipoPendiente == "MP") {
            $queryMP = "SELECT id FROM t_mp_planeacion WHERE id_equipo = $idEquipo AND status='P' AND activo=1 AND tipoplan='MP' AND id_destino = $idDestino";
            if ($resultMP = mysqli_query($conn_2020, $queryMP)) {
              if (mysqli_num_rows($resultMP) > 0) {
                $dataEquipos .= " <option value=\"$idEquipo\">$equipo </option>";
              }
            }
          } elseif ($tipoPendiente == "MCE") {
            $queryMCE = "SELECT id FROM t_mc WHERE id_equipo = $idEquipo AND status='N' AND activo=1 AND id_destino = $idDestino";
            if ($resultMCE = mysqli_query($conn_2020, $queryMCE)) {
              if (mysqli_num_rows($resultMCE) > 0) {
                $dataEquipos .= " <option value=\"$idEquipo\">$equipo </option>";
              }
            }
          }
        }
        $dataEquipos .= "</select>";
      }
      echo $dataEquipos;
    } elseif ($paso == "MCE") {
      $idEquipo = $_POST['idEquipo'];

      $query = "SELECT id, actividad FROM t_mc 
            WHERE id_equipo = $idEquipo AND activo = 1 AND status = 'N'";

      if ($result = mysqli_query($conn_2020, $query)) {
        $dataMCE .= "
                    <select id=\"opcionMCE\"
                        class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('opcionFinal');\">
                ";
        while ($row = mysqli_fetch_array($result)) {
          $idMCE = $row['id'];
          $actividad = $row['actividad'];

          $dataMCE .= "
            <option value=\"$idMCE\">$actividad </option>
          ";
        }
        $dataMCE .= "</select>";
      }
      echo $dataMCE;
    } elseif ($paso == "MP") {
      $idEquipo = $_POST['idEquipo'];

      $query = "SELECT t_mp_planeacion.id, t_mp_planeacion.semana, t_ordenes_trabajo.folio 
        FROM t_mp_planeacion 
        INNER JOIN t_ordenes_trabajo ON t_mp_planeacion.id = t_ordenes_trabajo.id_planeacion_mp
        WHERE t_mp_planeacion.id_equipo = $idEquipo AND 
        t_mp_planeacion.status = 'P' AND t_mp_planeacion.activo = 1 AND t_mp_planeacion.tipoplan = 'MP'";

      if ($result = mysqli_query($conn_2020, $query)) {
        $dataMP .= "
          <select id=\"opcionMP\"
              class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('opcionFinal');\">
        ";
        while ($row = mysqli_fetch_array($result)) {
          $idMP = $row['id'];
          $semana = $row['semana'];
          $folio = $row['folio'];

          $dataMP .= "
            <option value=\"$idMP\">Semana: $semana  Folio:$folio </option>
          ";
        }
        $dataMP .= "</select>";
      }
      echo $dataMP;
    } elseif ($paso == "MCTG") {
      $idSeccion = $_POST['idSeccion'];
      $idSubseccion = $_POST['idSubseccion'];

      $query = "SELECT id, actividad FROM t_mc 
            WHERE id_equipo = 0 AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion AND id_destino = $idDestino AND activo = 1 AND status = 'N'";

      if ($result = mysqli_query($conn_2020, $query)) {
        $dataMCTG .= "
                    <select id=\"opcionMCTG\"
                        class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('opcionFinal');\">
                ";
        while ($row = mysqli_fetch_array($result)) {
          $idMCTG = $row['id'];
          $actividad = $row['actividad'];

          $dataMCTG .= "
                        <option value=\"$idMCTG\">$actividad </option>
                    ";
        }
        $dataMCTG .= "</select>";
      }
      echo $dataMCTG;
    }
  }

  if ($action == "cerrarSalidaCarrito") {
    $tipoSalida = $_POST['carritoSalidaMotivo'];
    $idEquipo = $_POST['opcionEquipo'];
    $idMCE = $_POST['opcionMCE'];
    $idMP = $_POST['opcionMP'];
    $idMCTG = $_POST['opcionMCTG'];
    $motivo = $_POST['opcionSalidaOtro'];
    $gift = $_POST['opcionSalidaGift'];
    $idItemRegistro = $_POST['idSalidaItem'];

    $query = "SELECT* FROM t_subalmacenes_movimientos_salidas_temp 
            WHERE id = $idItemRegistro AND status = 'ESPERA' AND activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      while ($row = mysqli_fetch_array($result)) {
        $idUsuario = $row['id_usuario'];
        $idDestino = $row['id_destino'];
        $idSubalmacen = $row['id_subalmacen'];
        $idMaterial = $row['id_material'];
        $cantidadSalida = $row['cantidad_salida'];
        $cantidadAnterior = $row['cantidad_anterior'];
        $cantidadActual = $row['cantidad_actual'];

        $query_comprobar_cantidad = "SELECT cantidad FROM t_subalmacenes_items WHERE id = $idMaterial";
        if ($result_comprobar_cantidad = mysqli_query($conn_2020, $query_comprobar_cantidad)) {
          if ($row_comprobar_cantidad = mysqli_fetch_array($result_comprobar_cantidad)) {
            $cantidad_actual_item = $row_comprobar_cantidad['cantidad'];
            $resultado_comprobacion = floatval($cantidad_actual_item) - floatval($cantidadSalida);
            echo $idUsuario . "-" . $idDestino . "-" . $tipoSalida . "-" . $gift . "-" . $motivo . "-" . $idMCE . "-" . $idMP . "-" . $idMCTG . "-" . $idSubalmacen . "-" . $idMaterial . "-" . $cantidadSalida . "-" . $cantidadAnterior . "-" . $cantidadActual;
            // 1-7-MP-0-0-0-20628-0-1-8-1-1-0Error al Finalizar Salida 2
            if ($resultado_comprobacion >= 0) {
              // $query_insert = "INSERT INTO t_subalmacenes_movimientos_salidas(id_usuario, id_destino, tipo_salida, GIFT, motivo_descripcion, id_equipo, id_MCE, id_MP, id_MCTG, id_subalmacen, id_material, cantidad_salida, cantidad_anterior, cantidad_actual) VALUES($idUsuario, $idDestino, '$tipoSalida', $gift, '$motivo', $idMCE, $idMP, $idMCTG, $idSubalmacen, $idMaterial, $cantidadSalida,$cantidadAnterior, $cantidadActual)";

              $query_insert = "INSERT INTO t_subalmacenes_movimientos_salidas(id_usuario, id_destino, tipo_salida, GIFT, motivo_descripcion, id_equipo, id_MCE, id_MP, id_MCTG, id_subalmacen, id_material, cantidad_salida, cantidad_anterior, cantidad_actual) VALUES($idUsuario, $idDestino, '$tipoSalida', $gift, '$motivo',$idEquipo, $idMCE, $idMP, $idMCTG, $idSubalmacen, $idMaterial, $cantidadSalida,$cantidadAnterior, $cantidadActual)";

              if ($result_insert = mysqli_query($conn_2020, $query_insert)) {
                $query_update = "UPDATE t_subalmacenes_movimientos_salidas_temp SET status = 'FINALIZADO' WHERE id = $idItemRegistro";

                if ($result_update = mysqli_query($conn_2020, $query_update)) {
                  $query_nueva_cantidad_item = "UPDATE t_subalmacenes_items SET cantidad = $resultado_comprobacion WHERE id = $idMaterial";
                  if ($result_nueva_cantidad_item = mysqli_query($conn_2020, $query_nueva_cantidad_item)) {
                    echo "Carrito Finalizado";
                  }
                } else {
                  echo "Error al Finalizar Salida 1";
                }
              } else {
                echo "Error al Finalizar Salida 2";
              }
            } else {
              echo "Cantidad NO Suficiente";
            }
          }
        } else {
          echo "Item No Encontrado";
        }
      }
    } else {
      echo "Error al Finalizar Carrito";
    }
  }



  if ($action == "consultaEntradasSubalmacen") {

    $arraySubalmacenEntradas = array();
    $idSubalmacen = $_POST['idSubalmacen'];
    $idDestino = $_POST['idDestinoSeleccionado'];
    $palabraBuscar = $_POST['palabraBuscar'];
    $dataSubalmacenEntradas = "";

    if ($palabraBuscar != "Vacio") {
      $palabraBuscar = "AND (t_subalmacenes_items_globales.categoria LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.cod2bend LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.descripcion LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.caracteristicas LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.marca LIKE '%$palabraBuscar%')";
    } else {
      $palabraBuscar = "";
    }


    $query = "SELECT 
    t_subalmacenes_items_stock.id 't_subalmacenes_items_stock.id',  
    t_subalmacenes_items_globales.id 't_subalmacenes_items_globales.id',
    t_subalmacenes_items_globales.categoria,  
    t_subalmacenes_items_globales.cod2bend,  
    bitacora_gremio.nombre_gremio,  
    t_subalmacenes_items_globales.descripcion,  
    t_subalmacenes_items_globales.caracteristicas,  
    t_subalmacenes_items_globales.marca,  
    t_subalmacenes_items_stock.stock_teorico,
    t_subalmacenes_items_stock.stock_actual,
    t_subalmacenes_items_globales.unidad  
    FROM t_subalmacenes_items_stock
    INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_globales.id
    INNER JOIN bitacora_gremio ON t_subalmacenes_items_globales.id_gremio = bitacora_gremio.id
    WHERE t_subalmacenes_items_stock.id_subalmacen = $idSubalmacen 
    AND t_subalmacenes_items_stock.id_destino = $idDestino
    AND t_subalmacenes_items_stock.activo = 1
    AND t_subalmacenes_items_globales.activo = 1 $palabraBuscar
    ";
    if ($result = mysqli_query($conn_2020, $query)) {
      while ($row = mysqli_fetch_array($result)) {
        $idSubalmacenItemsStock = $row['t_subalmacenes_items_stock.id'];
        $idSubalmacenItemsGlobales = $row['t_subalmacenes_items_globales.id'];
        $categoria = $row['categoria'];
        $cod2bend = $row['cod2bend'];
        $nombreGremio = $row['nombre_gremio'];
        $descripcion = $row['descripcion'];
        $caracteristicas = $row['caracteristicas'];
        $marca = $row['marca'];
        $stockTeorico = $row['stock_teorico'];
        $stockActual = $row['stock_actual'];
        $unidadMedida = $row['unidad'];

        $dataSubalmacenEntradas .= "
          <div class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer\">
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$categoria</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$cod2bend</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$nombreGremio</h1>
            </div>
            <div class=\"w-64 flex h-full items-center justify-center truncate\">
                <h1>$descripcion de rosca corrida</h1>
            </div>
            <div class=\"w-64 flex h-full items-center justify-center truncate\">
                <h1>$caracteristicas</h1>
            </div>
            <div class=\"w-64 flex h-full items-center justify-center truncate\">
                <h1>$marca</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$stockTeorico</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$stockActual</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center\">
                <h1>$unidadMedida</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center\">
                <input id=\"$idSubalmacenItemsGlobales\" class=\"border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 px-2 rounded-r-md text-sm focus:outline-none w-full\" type=\"number\" name=\"cantidad\" placeholder=\"#\" 

                // Evento para Calcular Cantidades.
                onkeyup=\"if(event.keyCode == 48 | event.keyCode == 49 | event.keyCode == 50 | event.keyCode == 51 | event.keyCode == 52 | event.keyCode == 53 | event.keyCode == 54 | event.keyCode == 55 | event.keyCode == 56 | event.keyCode == 57 | event.keyCode == 58)validarCantidadEntradaSubalmacen($idSubalmacenItemsGlobales, $idSubalmacenItemsStock, '$descripcion', $stockActual);\">
            </div>
          </div>        
        ";
      }
    }
    $arraySubalmacenEntradas['dataSubalmacenEntradas'] = $dataSubalmacenEntradas;
    echo json_encode($arraySubalmacenEntradas);
  }


  if ($action == "capturarEntradaSubalmacenStock") {
    $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
    $idStock = $_POST['idStock'];
    $idSubalmacen = $_POST['idSubalmacen'];
    $idItemGlobal = $_POST['idItemGlobal'];
    $stockEntrada = $_POST['cantidadEntrada'];
    $stockActual = $_POST['stockActual'];
    $fechaMovimiento = date('Y-m-d H:m:s');

    $query = "SELECT id FROM t_subalmacenes_items_stock_reporte 
    WHERE id_t_subalmacenes_items_stock = $idStock AND id_usuario = $idUsuario AND id_subalmacen = $idSubalmacen AND id_destino = $idDestinoSeleccionado AND id_item_global = $idItemGlobal AND status = 'ESPERA' AND activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      if (mysqli_num_rows($result) >= 1) {
        if ($row = mysqli_fetch_array($result)) {
          $id = $row['id'];
          $query = "UPDATE t_subalmacenes_items_stock_reporte SET stock_entrada = $stockEntrada, stock_actual = $stockActual, fecha_movimiento = '$fechaMovimiento' WHERE id = $id";
          if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
          }
        }
      } else {
        $query = "INSERT INTO t_subalmacenes_items_stock_reporte(id_t_subalmacenes_items_stock, id_usuario, id_subalmacen, id_destino, id_item_global, stock_entrada, stock_actual, fecha_movimiento) 
        VALUES($idStock, $idUsuario, $idSubalmacen, $idDestinoSeleccionado, $idItemGlobal, $stockEntrada, $stockActual, '$fechaMovimiento')";
        if ($result = mysqli_query($conn_2020, $query)) {
          echo 1;
        } else {
          echo 0;
        }
      }
    }
  }


  if ($action == "consultaEntradaCarrito") {
    $arrayCarritoEntradas = array();
    $dataCarritoEntradas = "";
    $indexCantidadInput = "";
    $valueCantidadInput = "";
    $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
    $idSubalmacen = $_POST['idSubalmacen'];

    $query = "SELECT 
    t_subalmacenes_items_globales.id,
    t_subalmacenes_items_stock_reporte.stock_entrada,
    t_subalmacenes_items_globales.descripcion,
    t_subalmacenes_items_globales.caracteristicas,
    t_subalmacenes_items_globales.precio
    FROM t_subalmacenes_items_stock_reporte 
    INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock_reporte.id_item_global = t_subalmacenes_items_globales.id
    WHERE t_subalmacenes_items_stock_reporte.id_usuario = $idUsuario 
    AND t_subalmacenes_items_stock_reporte.id_subalmacen = $idSubalmacen 
    AND t_subalmacenes_items_stock_reporte.id_destino = $idDestinoSeleccionado 
    AND t_subalmacenes_items_stock_reporte.status = 'ESPERA' 
    AND t_subalmacenes_items_stock_reporte.activo = 1
    AND t_subalmacenes_items_stock_reporte.stock_entrada > 0.00000000000001";

    if ($result = mysqli_query($conn_2020, $query)) {
      while ($row = mysqli_fetch_array($result)) {
        $idItemGlobal = $row['id'];
        $stockEntrada = $row['stock_entrada'] + 0.0;
        $descripcion = $row['descripcion'];
        $caracteristicas = $row['caracteristicas'];
        $coste = $row['precio'];


        $dataCarritoEntradas .= "
          <div class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer\">
              <div class=\"w-32 flex h-full items-center justify-center truncate\">
                  <h1>$stockEntrada</h1>
              </div>
              <div class=\"w-64 flex h-full items-center justify-center truncate\">
                  <h1>$descripcion</h1>
              </div>
              <div class=\"w-64 flex h-full items-center justify-center truncate\">
                  <h1>$caracteristicas</h1>
              </div>
              <div class=\"w-32 flex h-full items-center justify-center\">
                  <h1>$coste</h1>
              </div>
          </div>
        ";

        $indexCantidadInput .= $idItemGlobal . ";";
        $valueCantidadInput .= $stockEntrada . ";";
      }
      $arrayCarritoEntradas['dataCarritoEntradas'] = $dataCarritoEntradas;
      $arrayCarritoEntradas['indexCantidadInput'] = $indexCantidadInput;
      $arrayCarritoEntradas['valueCantidadInput'] = "$valueCantidadInput";
    }
    echo json_encode($arrayCarritoEntradas);
  }

  if ($action == "finalizarEntradaCarrito") {
    $idItemGlobal = $_POST['idItemGlobal'];
    $idSubalmacen = $_POST['idSubalmacen'];
    $idDestino = $_POST['idDestinoSeleccionado'];

    $query = "SELECT id, stock_entrada FROM t_subalmacenes_items_stock_reporte 
    WHERE id_usuario = $idUsuario AND id_subalmacen = $idSubalmacen AND id_destino = $idDestino AND 
    id_item_global AND status = 'ESPERA' 
    AND activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      if ($row = mysqli_fetch_array($result)) {
        // Variable para Sumar con la Entrada.
        $stockEntrada_1 = $row['stock_entrada'];
        $idStockEntrada = $row['id'];

        $query_consulta_stock = "SELECT id, stock_actual FROM t_subalmacenes_items_stock WHERE id_subalmacen = $idSubalmacen AND id_destino = $idDestino AND id_item_global = $idItemGlobal AND activo =1";
        if ($result_consulta_stock = mysqli_query($conn_2020, $query_consulta_stock)) {
          if ($row_consulta_stock = mysqli_fetch_array($result_consulta_stock)) {
            // Variable para sumamar con stockEntrada_1
            $stockActual_2 = $row_consulta_stock['stock_actual'];
            $id_t_subalmacenes_items_stock = $row_consulta_stock['id'];
            $nuevoStock = $stockEntrada_1 + $stockActual_2;
            $query_sumar_stock = "UPDATE t_subalmacenes_items_stock 
            SET stock_actual = $nuevoStock, stock_anterior = $stockActual_2 WHERE id = $id_t_subalmacenes_items_stock";
            if ($result_sumar_stock = mysqli_query($conn_2020, $query_sumar_stock)) {
              $query_finalizar_reporte = "UPDATE t_subalmacenes_items_stock_reporte SET status = 'FINALIZADO' WHERE id = $idStockEntrada";
              if (mysqli_query($conn_2020, $query_finalizar_reporte)) {
                echo 1;
              } else {
                echo 0;
              }
            } else {
              echo 0;
            }
          }
        }
      }
    }
  }

  if ($action == "consultaMoverExistenciasItems") {
    $arraySubalmacenMovimientos = array();
    $idSubalmacen = $_POST['idSubalmacen'];
    $idDestino = $_POST['idDestinoSeleccionado'];
    $palabraBuscar = $_POST['palabraBuscar'];
    $dataSubalmacenMovimientos = "";

    if ($palabraBuscar != "") {
      $palabraBuscar = "AND (t_subalmacenes_items_globales.categoria LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.cod2bend LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.descripcion LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.caracteristicas LIKE '%$palabraBuscar%' OR t_subalmacenes_items_globales.marca LIKE '%$palabraBuscar%')";
    } else {
      $palabraBuscar = "";
    }


    $query = "SELECT 
    t_subalmacenes_items_stock.id 't_subalmacenes_items_stock.id',  
    t_subalmacenes_items_globales.id 't_subalmacenes_items_globales.id',
    t_subalmacenes_items_globales.categoria,  
    t_subalmacenes_items_globales.cod2bend,  
    bitacora_gremio.nombre_gremio,  
    t_subalmacenes_items_globales.descripcion,  
    t_subalmacenes_items_globales.caracteristicas,  
    t_subalmacenes_items_globales.marca,  
    t_subalmacenes_items_stock.stock_teorico,
    t_subalmacenes_items_stock.stock_actual,
    t_subalmacenes_items_globales.unidad  
    FROM t_subalmacenes_items_stock
    INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_globales.id
    INNER JOIN bitacora_gremio ON t_subalmacenes_items_globales.id_gremio = bitacora_gremio.id
    WHERE t_subalmacenes_items_stock.id_subalmacen = $idSubalmacen 
    AND t_subalmacenes_items_stock.id_destino = $idDestino
    AND t_subalmacenes_items_stock.activo = 1
    AND t_subalmacenes_items_globales.activo = 1 $palabraBuscar
    AND t_subalmacenes_items_stock.stock_actual > 0.0000000000000000001
    ";

    if ($result = mysqli_query($conn_2020, $query) and $movientosPermiso == 1) {
      while ($row = mysqli_fetch_array($result)) {
        $idSubalmacenItemsStock = $row['t_subalmacenes_items_stock.id'];
        $idSubalmacenItemsGlobales = $row['t_subalmacenes_items_globales.id'];
        $categoria = $row['categoria'];
        $cod2bend = $row['cod2bend'];
        $nombreGremio = $row['nombre_gremio'];
        $descripcion = $row['descripcion'];
        $caracteristicas = $row['caracteristicas'];
        $marca = $row['marca'];
        $stockTeorico = $row['stock_teorico'];
        $stockActual = $row['stock_actual'];
        $unidadMedida = $row['unidad'];

        $dataSubalmacenMovimientos .= "
          <div class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer\">
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$categoria</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$cod2bend</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$nombreGremio</h1>
            </div>
            <div class=\"w-64 flex h-full items-center justify-center truncate\">
                <h1>$descripcion de rosca corrida</h1>
            </div>
            <div class=\"w-64 flex h-full items-center justify-center truncate\">
                <h1>$caracteristicas</h1>
            </div>
            <div class=\"w-64 flex h-full items-center justify-center truncate\">
                <h1>$marca</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$stockTeorico</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center truncate\">
                <h1>$stockActual</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center\">
                <h1>$unidadMedida</h1>
            </div>
            <div class=\"w-32 flex h-full items-center justify-center\">
                <input id=\"$idSubalmacenItemsGlobales\" class=\"border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 px-2 rounded-r-md text-sm focus:outline-none w-full\" type=\"number\" name=\"cantidad\" placeholder=\"#\" 

                // Evento para Calcular Cantidades.
                onkeyup=\"if(event.keyCode == 48 | event.keyCode == 49 | event.keyCode == 50 | event.keyCode == 51 | event.keyCode == 52 | event.keyCode == 53 | event.keyCode == 54 | event.keyCode == 55 | event.keyCode == 56 | event.keyCode == 57 | event.keyCode == 58 | event.keyCode == 38 | event.keyCode == 40)validarCantidadMovimientoSubalmacen($idSubalmacenItemsGlobales, $idSubalmacenItemsStock, '$descripcion', $stockActual);\">
            </div>
          </div>        
        ";
      }
      $arraySubalmacenMovimientos['dataSubalmacenMovimientos'] = $dataSubalmacenMovimientos;
    } else {
      $arraySubalmacenMovimientos['dataSubalmacenMovimientos'] = "accesoDenegado";
    }
    echo json_encode($arraySubalmacenMovimientos);
  }

  if ($action == "capturarMovimientoSubalmacenStock") {
    $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
    $idStock = $_POST['idStock'];
    $idSubalmacen = $_POST['idSubalmacen'];
    $idItemGlobal = $_POST['idItemGlobal'];
    $stockSalida = $_POST['cantidadEntrada'];
    $stockActual = $_POST['stockActual'];


    $query = "SELECT id FROM  t_subalmacenes_items_stock_transferencias WHERE id_usuario = $idUsuario AND id_destino = $idDestinoSeleccionado AND id_item_global = $idItemGlobal AND id_subalmacen_envia = $idSubalmacen AND status = 'ESPERA' AND activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      if (mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_array($result)) {
          $idResultado = $row['id'];
          $update = "UPDATE t_subalmacenes_items_stock_transferencias SET stock_salida_envia = $stockSalida, stock_anterior_envia = $stockActual, fecha_movimiento = '$fechaActual' WHERE id = $idResultado";
          if (mysqli_query($conn_2020, $update)) {
            echo "actualizado";
          } else {
            echo "error";
          }
        }
      } else {
        $insert = "INSERT INTO t_subalmacenes_items_stock_transferencias(id_usuario, id_destino, id_item_global, id_subalmacen_envia, stock_salida_envia, stock_anterior_envia, fecha_movimiento) 
        VALUES($idUsuario, $idDestinoSeleccionado, $idItemGlobal, $idSubalmacen, $stockSalida, $stockActual, '$fechaActual')";
        if (mysqli_query($conn_2020, $insert)) {
          echo "Agregado";
        } else {
          echo "error";
        }
      }
    } else {
      echo "error";
    }
  }

  if ($action == "consultaMovimientoCarrito") {
    $arraySubalmacenMovimientos = array();
    $idSubalmacen = $_POST['idSubalmacen'];
    $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
    $dataMovimientos = "";
    $idRegistros = "";
    $index = "";
    $value = "";
    $opcionesSubalmacenes = "";
    $seleccionadoSubalmacen = "";

    $query = "SELECT 
    t_subalmacenes_items_stock_transferencias.id 'IDREGISTRO',  
    t_subalmacenes_items_globales.id 'IDITEMGLOBAL',
    t_subalmacenes_items_stock_transferencias.stock_salida_envia,  
    t_subalmacenes_items_globales.descripcion,  
    t_subalmacenes_items_globales.caracteristicas,  
    t_subalmacenes_items_globales.precio
    FROM t_subalmacenes_items_stock_transferencias
    INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock_transferencias.id_item_global = t_subalmacenes_items_globales.id
    WHERE t_subalmacenes_items_stock_transferencias.id_subalmacen_envia = $idSubalmacen 
    AND t_subalmacenes_items_stock_transferencias.id_usuario = $idUsuario
    AND t_subalmacenes_items_stock_transferencias.id_destino = $idDestinoSeleccionado
    AND t_subalmacenes_items_stock_transferencias.tipo_salida = 'TRANSFERENCIA'
    AND t_subalmacenes_items_stock_transferencias.status = 'ESPERA'
    AND t_subalmacenes_items_stock_transferencias.activo = 1
    AND t_subalmacenes_items_stock_transferencias.stock_salida_envia > 0.0000000000000000001
    ";
    if ($result = mysqli_query($conn_2020, $query)) {
      while ($row = mysqli_fetch_array($result)) {
        $IDREGISTRO = $row['IDREGISTRO'];
        $IDITEMGLOBAL = $row['IDITEMGLOBAL'];
        $cantidad = $row['stock_salida_envia'];
        $descripcion = $row['descripcion'];
        $caracteristicas = $row['caracteristicas'];
        $precio = $row['precio'];

        $dataMovimientos .= "
          <div class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer\">
              <div class=\"w-32 flex h-full items-center justify-center truncate\">
                  <h1>$cantidad</h1>
              </div>
              <div class=\"w-64 flex h-full items-center justify-center truncate\">
                  <h1>$descripcion</h1>
              </div>
              <div class=\"w-64 flex h-full items-center justify-center truncate\">
                  <h1>$caracteristicas</h1>
              </div>
              <div class=\"w-32 flex h-full items-center justify-center\">
                  <h1>$precio</h1>
              </div>
          </div>
        ";

        $index .= $IDITEMGLOBAL . ";";
        $value .= $cantidad . ";";
        $idRegistros .= $IDREGISTRO . ";";
      }
      $arraySubalmacenMovimientos['index'] = $index;
      $arraySubalmacenMovimientos['value'] = $value;
      $arraySubalmacenMovimientos['idRegistros'] = "$idRegistros";
      $arraySubalmacenMovimientos['dataMovimientos'] = $dataMovimientos;
    }

    $query = "SELECT id, nombre, fase FROM t_subalmacenes WHERE id_destino = $idDestinoSeleccionado AND activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      $opcionesSubalmacenes .= "
        <select id=\"idOpcionSubalmacenMovimientos\" class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500\"
          id=\"grid-state\" onclick=\"activarBtnFinalizarMovimiento();\">      
      ";

      while ($row = mysqli_fetch_array($result)) {
        $idSubalmacenOpciones = $row['id'];
        $nombre = $row['nombre'];
        $fase = $row['fase'];

        if ($idSubalmacen == $idSubalmacenOpciones) {
          $seleccionadoSubalmacen = "
            <select id=\"idSubalmacenMovimientos\" class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500\"
            id=\"grid-state\">
              <option value=\"$idSubalmacenOpciones\">$nombre $fase</option>    
            </select>
          ";
        } else {
          $opcionesSubalmacenes .= "<option value=\"$idSubalmacenOpciones\">$nombre $fase</option>";
        }
      }
      $opcionesSubalmacenes .= "</select>";

      $arraySubalmacenMovimientos['opcionesSubalmacenes'] = $opcionesSubalmacenes;
      $arraySubalmacenMovimientos['seleccionadoSubalmacen'] = $seleccionadoSubalmacen;
    }
    echo json_encode($arraySubalmacenMovimientos);
  }

  if ($action == "finalizarMovimientoCarrito") {
    $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
    $idOpcionSubalmacen = $_POST['idOpcionSubalmacen'];
    $idItemGlobal = $_POST['idItemGlobal'];
    $idRegistro = $_POST['idRegistro'];

    $query = "SELECT* FROM t_subalmacenes_items_stock_transferencias 
    WHERE id_usuario = $idUsuario AND id_destino = $idDestinoSeleccionado AND id = $idRegistro";
    if ($result  = mysqli_query($conn_2020, $query)) {
      if ($row = mysqli_fetch_array($result)) {
        $idRegistroTransferencia = $row['id'];
        $idItemGlobal = $row['id_item_global'];
        $idUsuario = $row['id_usuario'];
        $stockSalida_envia = $row['stock_salida_envia'];
        $idSubalmacen_envia = $row['id_subalmacen_envia'];

        // Nuevo stock_actual para el Subalmacen que Envia.
        $query_envia = "SELECT* FROM t_subalmacenes_items_stock WHERE id_destino = $idDestinoSeleccionado AND id_item_global = $idItemGlobal AND id_subalmacen = $idSubalmacen_envia";
        if ($result_envia = mysqli_query($conn_2020, $query_envia)) {
          if ($row_envia = mysqli_fetch_array($result_envia)) {
            // Variables para llenar el Stock que Recibe.
            $idEnvia = $row_envia['id'];
            $idItemGlobal_envia = $row_envia['id_item_global'];
            $stockActual_envia = $row_envia['stock_actual'];
            $stockTeorico_envia = $row_envia['stock_teorico'];

            // Nuevo stock_actual para el Subalmacen que Envia.
            $nuevoStockActual_envia = $stockActual_envia - $stockSalida_envia;
            $queryUpdate_envia = "UPDATE t_subalmacenes_items_stock SET stock_actual = $nuevoStockActual_envia, stock_anterior = $stockActual_envia, fecha_movimiento = '$fechaActual' WHERE id_destino = $idDestinoSeleccionado AND id = $idEnvia AND id_subalmacen = $idSubalmacen_envia";
            if ($resultUpdate_envia = mysqli_query($conn_2020, $queryUpdate_envia)) {
              $query_recibe = "SELECT* FROM t_subalmacenes_items_stock WHERE id_subalmacen = $idOpcionSubalmacen AND id_destino = $idDestinoSeleccionado AND id_item_global = $idItemGlobal LIMIT 1";
              if ($result_recibe = mysqli_query($conn_2020, $query_recibe)) {
                if (mysqli_num_rows($result_recibe) > 0) {
                  // Si tiene el Item Global Vinculado Actualiza el Stock.
                  if ($row_recibe = mysqli_fetch_array($result_recibe)) {
                    $idRecibe = $row_recibe['id'];
                    $stockActual_recibe = $row_recibe['stock_actual'];
                    $nuevoStock_recibe = $stockActual_recibe + $stockSalida_envia;
                    $queryUpdate_recibe = "UPDATE t_subalmacenes_items_stock SET stock_actual= $nuevoStock_recibe, stock_anterior = $stockActual_recibe, fecha_movimiento = '$fechaActual' WHERE id_destino = $idDestinoSeleccionado AND id = $idRecibe";
                    if ($resultUpdate_recibe = mysqli_query($conn_2020, $queryUpdate_recibe)) {
                      $queryUpdate_registro = "UPDATE t_subalmacenes_items_stock_transferencias SET status = 'FINALIZADO', id_subalmacen_recibe = $idOpcionSubalmacen, stock_entrada_recibe = $nuevoStock_recibe, stock_anterior_recibe = 0.0, fecha_movimiento = '$fechaActual' WHERE id_destino = $idDestinoSeleccionado AND id = $idRegistro";
                      if (mysqli_query($conn_2020, $queryUpdate_registro)) {
                        // echo "Stock Actualizado";
                        echo "1";
                      } else {
                        echo "0";
                      }
                    }
                  }
                } else {
                  // No tiene el Item Global, Lo crea y le asigna el Stock.
                  $queryInsert_recibe = "INSERT INTO t_subalmacenes_items_stock(id_subalmacen, id_destino, id_item_global, stock_actual, stock_anterior, stock_teorico) VALUES($idOpcionSubalmacen, $idDestinoSeleccionado, $idItemGlobal, $stockSalida_envia, 0.0, $stockTeorico_envia)";
                  if ($resultInsert_recibe = mysqli_query($conn_2020, $queryInsert_recibe)) {
                    $queryUpdate_registro = "UPDATE t_subalmacenes_items_stock_transferencias SET status = 'FINALIZADO', id_subalmacen_recibe = $idOpcionSubalmacen, stock_entrada_recibe =  $stockSalida_envia, stock_anterior_recibe = 0.0, fecha_movimiento = '$fechaActual' WHERE id_destino = $idDestinoSeleccionado AND id = $idRegistro";
                    if (mysqli_query($conn_2020, $queryUpdate_registro)) {
                      // echo "Stock Actualizado";
                      echo "2";
                    } else {
                      echo "0";
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
  }

  if ($action == "consultaTodosItems") {
    $arrayItemGeneral = array();
    $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
    $palabraBuscar = $_POST['palabraBuscar'];
    $dataTodo = "";
    $ItemsResultado = "";

    if ($palabraBuscar != "") {
      $palabraBuscar = "AND (t_subalmacenes_items_globales.categoria LIKE '%$palabraBuscar%' 
      OR t_subalmacenes_items_globales.cod2bend LIKE '%$palabraBuscar%' 
      OR t_subalmacenes_items_globales.descripcion LIKE '%$palabraBuscar%' 
      OR t_subalmacenes_items_globales.caracteristicas LIKE '%$palabraBuscar%' 
      OR bitacora_gremio.nombre_gremio LIKE '%$palabraBuscar%' 
      OR t_subalmacenes_items_globales.marca LIKE '%$palabraBuscar%')";
    } else {
      $palabraBuscar = "";
    }


    $query = "SELECT
    t_subalmacenes_items_globales.categoria,
    t_subalmacenes_items_globales.cod2bend,
    t_subalmacenes_items_globales.descripcion,
    t_subalmacenes_items_globales.caracteristicas,
    t_subalmacenes_items_globales.marca,
    t_subalmacenes_items_globales.unidad,
    t_subalmacenes_items_stock.id 'idItemsResultado',
    t_subalmacenes_items_stock.stock_teorico,
    t_subalmacenes_items_stock.stock_actual,
    bitacora_gremio.nombre_gremio,
    t_subalmacenes.nombre 'ubicacion'
    FROM t_subalmacenes_items_stock
    INNER JOIN t_subalmacenes ON t_subalmacenes_items_stock.id_subalmacen = t_subalmacenes.id
    INNER JOIN t_subalmacenes_items_globales ON t_subalmacenes_items_stock.id_item_global = t_subalmacenes_items_globales.id
    INNER JOIN bitacora_gremio ON t_subalmacenes_items_globales.id_gremio = bitacora_gremio.id
    WHERE t_subalmacenes_items_stock.id_destino = $idDestinoSeleccionado $palabraBuscar";
    if ($result = mysqli_query($conn_2020, $query)) {
      while ($row = mysqli_fetch_array($result)) {
        $idItemsResultado = $row['idItemsResultado'];
        $categoria = $row['categoria'];
        $cod2bend = $row['cod2bend'];
        $gremio = $row['nombre_gremio'];
        $descripcion = $row['descripcion'];
        $caracteristicas = $row['caracteristicas'];
        $marca = $row['marca'];
        $stockTeorico = $row['stock_teorico'];
        $stockActual = $row['stock_actual'];
        $unidad = $row['unidad'];
        $ubicacion = $row['ubicacion'];

        $ItemsResultado .= $idItemsResultado . ";";

        if ($stockActual < 1) {
          $colorstilo = "text-red-500 bg-red-200";
        } elseif ($stockActual >= $stockTeorico) {
          $colorstilo = "text-yellow-700 bg-yellow-200";
        } else {
          $colorstilo = "text-bluegray-500 bg-bluegray-50";
        }

        $dataTodo .= "
          <div class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 rounded hover:bg-indigo-100 cursor-pointer text-center $colorstilo\">
              <div class=\"w-32 flex h-full items-center justify-center truncate\">
                  <h1>$categoria</h1>
              </div>
              <div class=\"w-32 flex h-full items-center justify-center truncate\">
                  <h1>$cod2bend</h1>
              </div>
              <div class=\"w-32 flex h-full items-center justify-center truncate\">
                  <h1>$gremio</h1>
              </div>
              <div class=\"w-64 flex h-full items-center justify-center truncate\">
                  <h1>$descripcion</h1>
              </div>
              <div class=\"w-64 flex h-full items-center justify-center truncate\">
                  <h1>$caracteristicas</h1>
              </div>
              <div class=\"w-64 flex h-full items-center justify-center truncate\">
                  <h1>$marca</h1>
              </div>
              <div class=\"w-32 flex h-full items-center justify-center truncate\">
                  <h1>$stockTeorico</h1>
              </div>
              <div class=\"w-32 flex h-full items-center justify-center truncate\">
                  <h1>$stockActual</h1>
              </div>
              <div class=\"w-32 flex h-full items-center justify-center truncate\">
                  <h1>$unidad</h1>
              </div>
              <div class=\"w-64 flex h-full items-center justify-center truncate\">
                  <h1>$ubicacion</h1>
              </div>
          </div>         
            ";
      }
      $arrayItemGeneral['dataTodo'] = $dataTodo;
      $arrayItemGeneral['ItemsResultado'] = $ItemsResultado;
    }
    echo json_encode($arrayItemGeneral);
  }
}//Fin $action.