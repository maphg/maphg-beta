<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
include "../../php/conexion.php";

if (isset($_POST['action'])) {
  // Variables Globales.
  $action = $_POST['action'];
  $idDestino = $_POST['idDestino'];
  $idUsuario = $_POST['idUsuario'];
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


  if ($action == "consultaSubalmacen") {
    $arraySubalmacen = array();
    $dataGP = "";
    $dataTRS = "";
    $dataZI = "";

    if ($idDestino == 10) {
      $filtroDestino = " AND id IN($subalmacenesAcceso)";
    } else {
      $filtroDestino = "AND id_destino = $idDestino AND id IN($subalmacenesAcceso)";
    }

    $query = "SELECT id, id_destino, id_fase, nombre, fase, tipo 
    FROM t_subalmacenes 
    WHERE activo = 1 $filtroDestino ORDER BY tipo DESC";
    if ($result = mysqli_query($conn_2020, $query)) {
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
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); subalmacenSeleccionado($idSubalmacen);\"
            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"" . $idSubalmacen . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

            if ($entradasPermiso == 1) {
              $dataGP .= "
              <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\"
              onclick=\"entradasSubalmacen($idSubalmacen);\">
                <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
              </div>
            ";
            }

            if ($salidasPermiso == 1) {
              $dataGP .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>";
            }

            $dataGP .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
                </div>
            </div>
            <!-- SUBALMACEN -->              
          ";
          } elseif ($tipo == "BODEGA") {
            $dataGP .= "
            <!-- BODEGA -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); subalmacenSeleccionado($idSubalmacen);\"
            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"" . $idSubalmacen . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

            if ($entradasPermiso == 1) {
              $dataGP .= "
              <div class=\"hidden w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md\" onclick=\"entradasSubalmacen($idSubalmacen);\">
                <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
              </div>
            ";
            }

            if ($salidasPermiso == 1) {
              $dataGP .= "
             <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen);\">
              <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
              </div>
            ";
            }

            $dataGP .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen);\">
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
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); subalmacenSeleccionado($idSubalmacen);\"
            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"" . $idSubalmacen . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

            if ($entradasPermiso == 1) {
              $dataTRS .= "        
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"entradasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
            </div>
            ";
            }

            if ($salidasPermiso == 1) {

              $dataTRS .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>
            ";
            }

            $dataTRS .= " 
          <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
            </div>
            </div>
            <!-- SUBALMACEN -->              
          ";
          } elseif ($tipo == "BODEGA") {
            $dataTRS .= "
            <!-- BODEGA -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); subalmacenSeleccionado($idSubalmacen);\"
            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"$idSubalmacen" . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
            ";

            if ($entradasPermiso == 1) {
              $dataTRS .= "
              <div class=\"invisible w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md\" onclick=\"entradasSubalmacen($idSubalmacen);\">
                <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
              </div>
            ";
            }

            if ($salidasPermiso == 1) {
              $dataTRS .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>
            ";
            }

            $dataTRS .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen);\">
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
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); subalmacenSeleccionado($idSubalmacen);\"
            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"$idSubalmacen" . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

            if ($entradasPermiso == 1) {
              $dataZI .= "
              <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"entradasSubalmacen($idSubalmacen);\">
                <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
              </div>
            ";
            }

            if ($salidasPermiso == 1) {
              $dataZI .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>
            ";
            }

            $dataZI .= "
            <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
            </div>
            </div>
            <!-- SUBALMACEN -->              
          ";
          } elseif ($tipo == "BODEGA") {
            $dataZI .= "
            <!-- BODEGA -->
            <div id=\"$idDiv\" onclick=\"expandir('$idDiv'); subalmacenSeleccionado($idSubalmacen);\"
            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
            <div>
            <h1 class=\"truncate\">$nombre</h1>
            </div>
            <div id=\"$idSubalmacen" . "subtoggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
          ";

            if ($entradasPermiso == 1) {
              $dataZI .= "
              <div class=\"invisible w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"entradasSubalmacen($idSubalmacen);\">
                <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
              </div>
            ";
            }

            if ($salidasPermiso == 1) {
              $dataZI .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
            </div>
            ";
            }

            $dataZI .= "
            <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen);\">
            <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
            </div>
            </div>
            </div>
            <!-- BODEGA -->            
          ";
          }
        }
      }
    }

    $arraySubalmacen['dataGP'] = $dataGP;
    $arraySubalmacen['dataTRS'] = $dataTRS;
    $arraySubalmacen['dataZI'] = $dataZI;

    echo json_encode($arraySubalmacen);
  }
}
mysqli_close($conn_2020);
