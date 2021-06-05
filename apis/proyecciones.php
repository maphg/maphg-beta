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
   $idDestino = $_GET['idDestino'];
   $idUsuario = $_GET['idUsuario'];
   $fechaActual = date('Y-m-d H:m:s');
   $idPermisos = 0;
   $array = array();


   #OBTIENE INFORMACIÓN DEL DESTINO
   if ($action == "obtenerInfo") {

      #OBTIENE INFORMACIÓN DEL DESTINO
      $query = "SELECT destino, ubicacion, habitaciones 
      FROM c_destinos
      WHERE id = $idDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $destino = $x['destino'];
            $ubicacion = $x['ubicacion'];
            $habitaciones = $x['habitaciones'];

            $array[0]['destino'] =  $destino;
            $array[0]['ubicacion'] =  $ubicacion;
            $array[0]['destino'] =  $destino;
            $array[0]['habitaciones'] =  $habitaciones;
            $array[0]['edadHotel'] =  $habitaciones;
            $array[0]['propietario'] =  $habitaciones;
            $array[0]['region'] =  $habitaciones;
            $array[0]['fechaApertura'] =  $habitaciones;
            $array[0]['fechaExpansion'] =  $habitaciones;
            $array[0]['expansionHabitaciones'] =  $habitaciones;
         }
      }
      echo json_encode($array);
   }


   // OBTIENE LOS DEPARTAMENTOS
   if ($action == "obtenerDepartamentos") {
      $query = "SELECT id, departamento, seccion, coste
      FROM t_proyecciones_departamentos
      WHERE id_destino = $idDestino and activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idItem = $x['id'];
            $departamento = $x['departamento'];
            $seccion = $x['seccion'];
            $coste = $x['coste'];

            #OBTIENE ARRAY DE DATOS
            $array[] = array(
               "idITem" => intval($idITem),
               "departamento" => $departamento,
               "seccion" => $seccion,
               "coste" => $coste
            );
         }
      }
      echo json_encode($array);
   }

   // OBTIENE
   if ($action == "obtenerItems") {
      #OBTENER DEPARTAMENTOS POR DESTINO
      $query = "SELECT id, departamento, seccion, coste
      FROM t_proyecciones_departamentos
      WHERE id_destino = $idDestino and activo = 1";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idDepartamento = $x['id'];
            $departamento = $x['departamento'];
            $seccion = $x['seccion'];
            $coste = 0;

            $arrayItems = array();

            #OBTIENE ITEMS POR DESTINO
            $query = "SELECT* FROM t_proyecciones_anuales
            WHERE activo = 1 and id_departamento = $idDepartamento and
            ((nivel = 2 and id_nivel = 0) or (nivel = 3 and id_nivel = 0))";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $idItem_2 = $x['id'];
                  $idDepartamento_2 = $x['id_departamento'];
                  $idNivel_2 = $x['id_nivel'];
                  $nivel_2 = $x['nivel'];
                  $titulo_2 = $x['titulo'];
                  $vidaUtil_2 = $x['vida_util'];
                  $añoInstalacion_2 = $x['año_instalacion'];
                  $inversion_2 = $x['inversion'];
                  $coste_2 = $x['coste'];
                  $unidades_2 = $x['unidades'];
                  $total_2 = $x['total'];
                  $totalNivel2_2 = 0;

                  $arrayNivel3 = array();

                  $query = "SELECT* FROM t_proyecciones_anuales
                  WHERE nivel = 3 and id_nivel = $idItem_2 and activo = 1";
                  if ($result = mysqli_query($conn_2020, $query)) {
                     foreach ($result as $x) {
                        $idItem_3 = $x['id'];
                        $idDepartamento_3 = $x['id_departamento'];
                        $idNivel_3 = $x['id_nivel'];
                        $nivel_3 = $x['nivel'];
                        $titulo_3 = $x['titulo'];
                        $vidaUtil_3 = $x['vida_util'];
                        $añoInstalacion_3 = $x['año_instalacion'];
                        $inversion_3 = $x['inversion'];
                        $coste_3 = $x['coste'];
                        $unidades_3 = $x['unidades'];
                        $total_3 = $x['total'];
                        $totalNivel2_2 += $total_3;
                        $coste += $total_3;

                        $arrayNivel3[] = array(
                           "idItem" => $idItem_3,
                           "idDepartamento" => $idDepartamento_3,
                           "idNivel" => $idNivel_3,
                           "nivel" => $nivel_3,
                           "titulo" => $titulo_3,
                           "vidaUtil" => $vidaUtil_3,
                           "añoInstalacion" => $añoInstalacion_3,
                           "inversion" => $inversion_3,
                           "coste" => $coste_3,
                           "unidades" => $unidades_3,
                           "total" => $total_3
                        );
                     }
                  }

                  #ARRAY
                  $arrayItems[] = array(
                     "idItem" => $idItem_2,
                     "idDepartamento" => $idDepartamento_2,
                     "idNivel" => $idNivel_2,
                     "nivel" => $nivel_2,
                     "titulo" => $titulo_2,
                     "vidaUtil" => $vidaUtil_2,
                     "añoInstalacion" => $añoInstalacion_2,
                     "inversion" => $inversion_2,
                     "coste" => $coste_2,
                     "unidades" => $unidades_2,
                     "total" => $total_2,
                     "totalNivel2" => $totalNivel2_2,
                     "itemsNivel3" => $arrayNivel3
                  );
               }
            }

            #OBTIENE ARRAY DE DATOS
            $array[] = array(
               "idDepartamento" => intval($idDepartamento),
               "departamento" => $departamento,
               "seccion" => $seccion,
               "coste" => $coste,
               "items" => $arrayItems
            );
         }
      }
      echo json_encode($array);
   }

   #CREA UN NUEVO DEPARTAMENTO
   if ($action == "agregarDepartamento") {
      $resp = 0;
      $query = "INSERT INTO t_proyecciones_departamentos(id_destino, creado_por, departamento, seccion, activo) VALUES($idDestino, $idUsuario, '', '', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }

   #AGREGA ITEM NIVEL 2 
   if ($action == "agregarNivel2") {
      $idDepartamento = $_GET['idDepartamento'];

      $resp = 0;
      $query = "INSERT INTO t_proyecciones_anuales(id_destino, creado_por, id_departamento, id_nivel, nivel, activo) VALUES($idDestino, $idUsuario, $idDepartamento, 0, 2, 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }

   #AGREGA ITEM NIVEL 2 
   if ($action == "agregarNivel3") {
      $idDepartamento = $_GET['idDepartamento'];
      $idNivel = $_GET['idNivel'];

      $resp = 0;
      $query = "INSERT INTO t_proyecciones_anuales(id_destino, creado_por, id_departamento, id_nivel, nivel, activo) VALUES($idDestino, $idUsuario, $idDepartamento, $idNivel, 3, 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }

   #ELIMINAR ITEM NIVEL 2 
   if ($action == "eliminarNivel2") {
      $idNivel = $_GET['idNivel'];

      $resp = 0;
      $query = "UPDATE t_proyecciones_anuales SET activo = 0 WHERE id = $idNivel";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }

   #ELIMINAR ITEM NIVEL 3 
   if ($action == "eliminarNivel3") {
      $idItem = $_GET['idItem'];

      $resp = 0;
      $query = "UPDATE t_proyecciones_anuales
      SET ultima_modificacion = '$fechaActual', modificado_por = $idUsuario, activo = 0
      WHERE id = $idItem";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }

   #ELIMINAR ITEM NIVEL 3 
   if ($action == "eliminarDepartamento") {
      $idDepartamento = $_GET['idDepartamento'];

      $resp = 0;
      $query = "UPDATE t_proyecciones_departamentos
      SET ultima_modificacion = '$fechaActual', modificado_por = $idUsuario, activo = 0 
      WHERE id = $idDepartamento";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }

   #ACTUALIZAR DEPARTAMENTO
   if ($action == "editarDepartamento") {
      $resp = 0;
      $data = json_decode(file_get_contents('php://input'), true);

      $idDepartamento = $_GET['idDepartamento'];
      $seccion = $data['seccion'];
      $departamento = $data['departamento'];

      $query = "UPDATE t_proyecciones_departamentos 
      SET seccion = '$seccion', departamento = '$departamento', ultima_modificacion = '$fechaActual', modificado_por = $idUsuario WHERE id = $idDepartamento";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }

   #ACTUALIZAR NIVEL 2
   if ($action == "editarNivel2") {
      $resp = 0;
      $data = json_decode(file_get_contents('php://input'), true);

      $idItem = $_GET['idItem'];
      $titulo = $data['titulo'];

      $query = "UPDATE t_proyecciones_anuales
      SET titulo = '$titulo', ultima_modificacion = '$fechaActual', modificado_por = $idUsuario 
      WHERE id = $idItem";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }

   #ACTUALIZAR NIVEL 2
   if ($action == "editarNivel3") {
      $resp = 0;
      $data = json_decode(file_get_contents('php://input'), true);

      $idItem = $_GET['idItem'];
      $titulo = $data['titulo3'];
      $vidaUtil = $data['vidaUtil'];
      $añoInstalacion = $data['añoInstalacion'];
      $inversion = $data['inversion'];
      $coste = $data['coste'];
      $unidades = $data['unidades'];
      $total = 0;

      if ($vidaUtil <= 0)
         $vidaUtil = 0;

      if ($coste <= 0)
         $coste = 0;

      if ($unidades <= 0)
         $unidades = 0;

      if ($coste > 0 && $unidades > 0)
         $total = $coste * $unidades;

      $query = "UPDATE t_proyecciones_anuales
      SET titulo = '$titulo', vida_util = $vidaUtil, año_instalacion = '$añoInstalacion', inversion = '$inversion', coste = $coste, unidades = $unidades, total = $total, ultima_modificacion = '$fechaActual', modificado_por = $idUsuario
      WHERE id = $idItem";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }
}
