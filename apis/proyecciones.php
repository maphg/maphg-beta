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
   if ($action == "obtenerInfoDestino") {

      #OBTIENE INFORMACIÓN DEL DESTINO
      $query = "SELECT destino, ubicacion, habitaciones, edad_hotel, propietario, region, fecha_apertura, fecha_expansion, expansion_habitaciones
      FROM c_destinos
      WHERE id = $idDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $destino = $x['destino'];
            $ubicacion = $x['ubicacion'];
            $habitaciones = $x['habitaciones'];
            $edadHotel = $x['edad_hotel'];
            $propietario = $x['propietario'];
            $region = $x['region'];
            $fechaApertura = $x['fecha_apertura'];
            $fechaExpansion = $x['fecha_expansion'];
            $expansionHabitaciones = $x['expansion_habitaciones'];

            $array[0]['destino'] =  $destino;
            $array[0]['ubicacion'] =  $ubicacion;
            $array[0]['habitaciones'] =  $habitaciones;
            $array[0]['edadHotel'] =  $edadHotel;
            $array[0]['propietario'] =  $propietario;
            $array[0]['region'] =  $region;
            $array[0]['fechaApertura'] =  $fechaApertura;
            $array[0]['fechaExpansion'] =  $fechaExpansion;
            $array[0]['expansionHabitaciones'] =  $expansionHabitaciones;
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


   // OBTIENE ITEMS 3 NIVELES
   if ($action == "obtenerItems") {
      $data = json_decode(file_get_contents('php://input'), true);

      $palabra = $data['palabra'];
      $ceco = $data['ceco'];
      $departamento = $data['departamento'];
      $vidaUtil = $data['vidaUtil'];
      $añoInstalacion = $data['añoInstalacion'];
      $inversion = $data['inversion'];

      if ($palabra == "") {
         $filtroPalabraNivel2y3 = "";
      } else {
         $filtroPalabraNivel2y3 = "and (titulo LIKE '%$palabra%' OR vida_util LIKE '%$palabra%' OR inversion LIKE '%$palabra%' OR coste LIKE '%$palabra%' OR unidades LIKE '%$palabra%' OR total LIKE '%$palabra%')";
      }

      if ($departamento == "TODOS") {
         $filtroDepartamento = "";
      } else {
         $filtroDepartamento = "and departamento = '$departamento'";
      }

      if (
         $ceco == "TODOS"
      ) {
         $filtroCeco = "";
      } else {
         $filtroCeco = "and seccion = '$ceco'";
      }

      if (
         $vidaUtil == "TODOS"
      ) {
         $filtroVidaUtil = "";
      } else {
         $filtroVidaUtil = "and vida_util = '$vidaUtil'";
      }

      if (
         $añoInstalacion == "TODOS"
      ) {
         $filtroAñoInstalacion = "";
      } else {
         $filtroAñoInstalacion = " and año_instalacion = '$añoInstalacion'";
      }

      if ($inversion == "TODOS") {
         $filtroInversion = "";
      } else {
         $filtroInversion = "inversion = '$inversion'";
      }

      #OBTENER DEPARTAMENTOS POR DESTINO
      $query = "SELECT id, departamento, seccion, coste
      FROM t_proyecciones_departamentos
      WHERE id_destino = $idDestino and activo = 1 $filtroCeco $filtroDepartamento";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idDepartamento = $x['id'];
            $departamento = $x['departamento'];
            $seccion = $x['seccion'];
            $coste = 0;
            $total = 0;

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
                  $totalHijos_2 = 0;

                  $arrayNivel3 = array();

                  $query = "SELECT* FROM t_proyecciones_anuales
                  WHERE nivel = 3 and id_nivel = $idItem_2 and activo = 1 $filtroPalabraNivel2y3 $filtroVidaUtil $filtroAñoInstalacion $filtroInversion";
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
                        $totalHijos_2++;

                        $arrayNivel3[] = array(
                           "idItem" => $idItem_3,
                           "idDepartamento" => $idDepartamento_3,
                           "idNivel" => $idNivel_3,
                           "nivel" => $nivel_3,
                           "titulo" => $titulo_3,
                           "vidaUtil" => intval($vidaUtil_3),
                           "añoInstalacion" => intval($añoInstalacion_3),
                           "inversion" => $inversion_3,
                           "coste" => floatval($coste_3),
                           "unidades" => intval($unidades_3),
                           "total" => $total_3
                        );
                     }
                  }

                  if ($totalHijos_2 == 0) {
                     #TOTAL GLOBAL POR DEPARTAMENTO
                     $total += $total_2;
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
                        "totalNivel2" => $total_2,
                        "itemsNivel3" => $arrayNivel3
                     );
                  } else {
                     #TOTAL GLOBAL POR DEPARTAMENTO
                     $total += $totalNivel2_2;

                     #ARRAY
                     $arrayItems[] = array(
                        "idItem" => $idItem_2,
                        "idDepartamento" => $idDepartamento_2,
                        "idNivel" => $idNivel_2,
                        "nivel" => $nivel_2,
                        "titulo" => $titulo_2,
                        "vidaUtil" => '',
                        "añoInstalacion" => '',
                        "inversion" => '',
                        "coste" => '',
                        "unidades" => '',
                        "total" => $totalNivel2_2,
                        "totalNivel2" => $total_2,
                        "itemsNivel3" => $arrayNivel3
                     );
                  }
               }
            }

            #OBTIENE ARRAY DE DATOS
            $array[] = array(
               "idDepartamento" => intval($idDepartamento),
               "departamento" => $departamento,
               "seccion" => $seccion,
               "coste" => $coste,
               "total" => $total,
               "items" => $arrayItems
            );
         }
      }
      echo json_encode($array);
   }


   // OBTIENE ITEMS CON NIVEL 5
   if ($action == "obtenerItems5") {
      $data = json_decode(file_get_contents('php://input'), true);

      $palabra = $data['palabra'];
      $ceco = $data['ceco'];
      $departamento = $data['departamento'];
      $vidaUtil = $data['vidaUtil'];
      $añoInstalacion = $data['añoInstalacion'];
      $inversion = $data['inversion'];

      if ($palabra == "") {
         $filtroPalabraNivel2y3 = "";
      } else {
         $filtroPalabraNivel2y3 = "and (titulo LIKE '%$palabra%' OR vida_util LIKE '%$palabra%' OR inversion LIKE '%$palabra%' OR coste LIKE '%$palabra%' OR unidades LIKE '%$palabra%' OR total LIKE '%$palabra%')";
      }

      if ($departamento == "TODOS") {
         $filtroDepartamento = "";
      } else {
         $filtroDepartamento = "and departamento = '$departamento'";
      }

      if ($ceco == "TODOS") {
         $filtroCeco = "";
      } else {
         $filtroCeco = "and seccion = '$ceco'";
      }

      if ($vidaUtil == "TODOS") {
         $filtroVidaUtil = "";
      } else {
         $filtroVidaUtil = "and vida_util = '$vidaUtil'";
      }

      if ($añoInstalacion == "TODOS") {
         $filtroAñoInstalacion = "";
      } else {
         $filtroAñoInstalacion = " and año_instalacion = '$añoInstalacion'";
      }

      if ($inversion == "TODOS") {
         $filtroInversion = "";
      } else {
         $filtroInversion = "inversion = '$inversion'";
      }

      #OBTENER DEPARTAMENTOS POR DESTINO
      $query = "SELECT id, departamento, seccion, coste
      FROM t_proyecciones_departamentos
      WHERE id_destino = $idDestino and activo = 1 $filtroCeco $filtroDepartamento";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idDepartamento = $x['id'];
            $departamento = $x['departamento'];
            $seccion = $x['seccion'];
            $coste = 0;
            $total = 0;
            $totalHijos = 0;
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
                  $totalHijos_2 = 0;
                  $totalHijos++;

                  $arrayNivel3 = array();
                  $query = "SELECT* FROM t_proyecciones_anuales
                  WHERE nivel = 3 and id_nivel = $idItem_2 and activo = 1 $filtroPalabraNivel2y3 $filtroVidaUtil $filtroAñoInstalacion $filtroInversion";
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
                        $totalHijos_2++;
                        $totalHijos_3 = 0;

                        #NIVEL 4
                        $arrayNivel4 = array();
                        $query = "SELECT* FROM t_proyecciones_anuales
                        WHERE nivel = 4 and id_nivel = $idItem_3 and activo = 1 $filtroPalabraNivel2y3 $filtroVidaUtil $filtroAñoInstalacion $filtroInversion";
                        if ($result = mysqli_query($conn_2020, $query)) {
                           foreach ($result as $x) {
                              $idItem_4 = $x['id'];
                              $idDepartamento_4 = $x['id_departamento'];
                              $idNivel_4 = $x['id_nivel'];
                              $nivel_4 = $x['nivel'];
                              $titulo_4 = $x['titulo'];
                              $vidaUtil_4 = $x['vida_util'];
                              $añoInstalacion_4 = $x['año_instalacion'];
                              $inversion_4 = $x['inversion'];
                              $coste_4 = $x['coste'];
                              $unidades_4 = $x['unidades'];
                              $total_4 = $x['total'];
                              $totalHijos_4 = 0;


                              $arrayNivel5 = array();
                              $query = "SELECT* FROM t_proyecciones_anuales
                              WHERE nivel = 5 and id_nivel = $idItem_4 and activo = 1 $filtroPalabraNivel2y3 $filtroVidaUtil $filtroAñoInstalacion $filtroInversion";
                              if ($result = mysqli_query($conn_2020, $query)) {
                                 foreach ($result as $x) {
                                    $idItem_5 = $x['id'];
                                    $idDepartamento_5 = $x['id_departamento'];
                                    $idNivel_5 = $x['id_nivel'];
                                    $nivel_5 = $x['nivel'];
                                    $titulo_5 = $x['titulo'];
                                    $vidaUtil_5 = $x['vida_util'];
                                    $añoInstalacion_5 = $x['año_instalacion'];
                                    $inversion_5 = $x['inversion'];
                                    $coste_5 = $x['coste'];
                                    $unidades_5 = $x['unidades'];
                                    $total_5 = $x['total'];

                                    #SUMA TOTAL PARA EL RESTO DE LAS ITERACIONES
                                    if ($totalHijos_4 > 0) {
                                       $totalHijos_4++;
                                       $total_4 += $total_5;
                                    }

                                    #INICIA VALORES CON LA PRIMERA ITERACIÓN
                                    if ($totalHijos_4 == 0) {
                                       $totalHijos_4++;
                                       $total_4 = 0;
                                       $total_4 += $total_5;
                                    }

                                    #NIVEL 5
                                    $arrayNivel5[] = array(
                                       "idItem" => $idItem_5,
                                       "idDepartamento" => $idDepartamento_5,
                                       "idNivel" => $idNivel_5,
                                       "nivel" => $nivel_5,
                                       "titulo" => $titulo_5,
                                       "vidaUtil" => intval($vidaUtil_5),
                                       "añoInstalacion" => intval($añoInstalacion_5),
                                       "inversion" => $inversion_5,
                                       "coste" => floatval($coste_5),
                                       "unidades" => intval($unidades_5),
                                       "total" => $total_5
                                    );
                                 }
                              }

                              #SUMA TOTAL PARA EL RESTO DE LAS ITERACIONES
                              if ($totalHijos_3 > 0) {
                                 $totalHijos_3++;
                                 $total_3 += $total_4;
                              }

                              #INICIA VALORES CON LA PRIMERA ITERACIÓN
                              if ($totalHijos_3 == 0) {
                                 $totalHijos_3++;
                                 $total_3 = 0;
                                 $total_3 += $total_4;
                              }

                              #NIVEL 4
                              $arrayNivel4[] = array(
                                 "idItem" => $idItem_4,
                                 "idDepartamento" => $idDepartamento_4,
                                 "idNivel" => $idNivel_4,
                                 "nivel" => $nivel_4,
                                 "titulo" => $titulo_4,
                                 "vidaUtil" => intval($vidaUtil_4),
                                 "añoInstalacion" => intval($añoInstalacion_4),
                                 "inversion" => $inversion_4,
                                 "coste" => floatval($coste_4),
                                 "unidades" => intval($unidades_4),
                                 "total" => $total_4,
                                 "arrayNivel5" => $arrayNivel5
                              );
                           }
                        }


                        #SUMA TOTAL PARA EL RESTO DE LAS ITERACIONES
                        if ($totalHijos_2 > 0) {
                           $totalHijos_2++;
                           $total_2 += $total_3;
                        }

                        #INICIA VALORES CON LA PRIMERA ITERACIÓN
                        if ($totalHijos_2 == 0) {
                           $totalHijos_2++;
                           $total_2 = 0;
                           $total_2 += $total_3;
                        }


                        #NIVEL 3
                        $arrayNivel3[] = array(
                           "idItem" => $idItem_3,
                           "idDepartamento" => $idDepartamento_3,
                           "idNivel" => $idNivel_3,
                           "nivel" => $nivel_3,
                           "titulo" => $titulo_3,
                           "vidaUtil" => intval($vidaUtil_3),
                           "añoInstalacion" => intval($añoInstalacion_3),
                           "inversion" => $inversion_3,
                           "coste" => floatval($coste_3),
                           "unidades" => intval($unidades_3),
                           "total" => $total_3,
                           "itemsNivel4" => $arrayNivel4
                        );
                     }
                  }


                  #SUMA TOTAL PARA EL RESTO DE LAS ITERACIONES
                  if ($totalHijos > 0) {
                     $totalHijos++;
                     $total += $total_2;
                  }

                  #INICIA VALORES CON LA PRIMERA ITERACIÓN
                  if ($totalHijos == 0) {
                     $totalHijos++;
                     $total = 0;
                     $total += $total_2;
                  }

                  #NIVEL 2
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
                     "totalNivel2" => $total_2,
                     "itemsNivel3" => $arrayNivel3
                  );
               }
            }

            #NIVEL 1
            $array[] = array(
               "idDepartamento" => intval($idDepartamento),
               "departamento" => $departamento,
               "seccion" => $seccion,
               "coste" => $coste,
               "total" => $total,
               "items" => $arrayItems
            );
         }
      }
      echo json_encode($array);
   }


   // OBTIENE ITEMS CON PROYECCIONES
   if ($action == "obtenerProyeccionItems5") {
      $data = json_decode(file_get_contents('php://input'), true);

      $palabra = $data['palabra'];
      $ceco = $data['ceco'];
      $departamento = $data['departamento'];
      $vidaUtil = $data['vidaUtil'];
      $añoInstalacion = $data['añoInstalacion'];
      $inversion = $data['inversion'];

      if ($palabra == "") {
         $filtroPalabraNivel2y3 = "";
      } else {
         $filtroPalabraNivel2y3 = "and (titulo LIKE '%$palabra%' OR vida_util LIKE '%$palabra%' OR inversion LIKE '%$palabra%' OR coste LIKE '%$palabra%' OR unidades LIKE '%$palabra%' OR total LIKE '%$palabra%')";
      }

      if ($departamento == "TODOS") {
         $filtroDepartamento = "";
      } else {
         $filtroDepartamento = "and departamento = '$departamento'";
      }

      if ($ceco == "TODOS") {
         $filtroCeco = "";
      } else {
         $filtroCeco = "and seccion = '$ceco'";
      }

      if ($vidaUtil == "TODOS") {
         $filtroVidaUtil = "";
      } else {
         $filtroVidaUtil = "and vida_util = '$vidaUtil'";
      }

      if ($añoInstalacion == "TODOS") {
         $filtroAñoInstalacion = "";
      } else {
         $filtroAñoInstalacion = " and año_instalacion = '$añoInstalacion'";
      }

      if ($inversion == "TODOS") {
         $filtroInversion = "";
      } else {
         $filtroInversion = "inversion = '$inversion'";
      }

      #OBTENER DEPARTAMENTOS POR DESTINO
      $query = "SELECT id, departamento, seccion, coste
      FROM t_proyecciones_departamentos
      WHERE id_destino = $idDestino and activo = 1 $filtroCeco $filtroDepartamento";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idDepartamento = $x['id'];
            $departamento = $x['departamento'];
            $seccion = $x['seccion'];
            $coste = 0;
            $total = 0;
            $totalHijos = 0;
            $arrayItems = array();

            #PROYECCION DE AÑOS
            $año2021_1 = 0;
            $año2022_1 = 0;
            $año2023_1 = 0;
            $año2024_1 = 0;
            $año2025_1 = 0;
            $año2026_1 = 0;
            $año2027_1 = 0;
            $año2028_1 = 0;
            $año2029_1 = 0;
            $año2030_1 = 0;
            $año2031_1 = 0;
            $año2032_1 = 0;
            $año2033_1 = 0;
            $año2034_1 = 0;
            $año2035_1 = 0;

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
                  $añoInstalacion_2 = intval($x['año_instalacion']);
                  $inversion_2 = $x['inversion'];
                  $coste_2 = $x['coste'];
                  $unidades_2 = $x['unidades'];
                  $total_2 = $x['total'];
                  $totalHijos_2 = 0;
                  $totalHijos++;

                  #PROYECCIÓN DE AÑOS
                  $año2021_2 = 0;
                  $año2022_2 = 0;
                  $año2023_2 = 0;
                  $año2024_2 = 0;
                  $año2025_2 = 0;
                  $año2026_2 = 0;
                  $año2027_2 = 0;
                  $año2028_2 = 0;
                  $año2029_2 = 0;
                  $año2030_2 = 0;
                  $año2031_2 = 0;
                  $año2032_2 = 0;
                  $año2033_2 = 0;
                  $año2034_2 = 0;
                  $año2035_2 = 0;

                  $arrayNivel3 = array();
                  $query = "SELECT* FROM t_proyecciones_anuales
                  WHERE nivel = 3 and id_nivel = $idItem_2 and activo = 1 $filtroPalabraNivel2y3 $filtroVidaUtil $filtroAñoInstalacion $filtroInversion";
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
                        $totalHijos_2++;
                        $totalHijos_3 = 0;

                        #PROYECCIÓN DE AÑOS
                        $año2021_3 = 0;
                        $año2022_3 = 0;
                        $año2023_3 = 0;
                        $año2024_3 = 0;
                        $año2025_3 = 0;
                        $año2026_3 = 0;
                        $año2027_3 = 0;
                        $año2028_3 = 0;
                        $año2029_3 = 0;
                        $año2030_3 = 0;
                        $año2031_3 = 0;
                        $año2032_3 = 0;
                        $año2033_3 = 0;
                        $año2034_3 = 0;
                        $año2035_3 = 0;

                        #NIVEL 4
                        $arrayNivel4 = array();
                        $query = "SELECT* FROM t_proyecciones_anuales
                        WHERE nivel = 4 and id_nivel = $idItem_3 and activo = 1 $filtroPalabraNivel2y3 $filtroVidaUtil $filtroAñoInstalacion $filtroInversion";
                        if ($result = mysqli_query($conn_2020, $query)) {
                           foreach ($result as $x) {
                              $idItem_4 = $x['id'];
                              $idDepartamento_4 = $x['id_departamento'];
                              $idNivel_4 = $x['id_nivel'];
                              $nivel_4 = $x['nivel'];
                              $titulo_4 = $x['titulo'];
                              $vidaUtil_4 = $x['vida_util'];
                              $añoInstalacion_4 = $x['año_instalacion'];
                              $inversion_4 = $x['inversion'];
                              $coste_4 = $x['coste'];
                              $unidades_4 = $x['unidades'];
                              $total_4 = $x['total'];
                              $totalHijos_4 = 0;
                              $totalHijos_3++;

                              #PROYECCIÓN DE AÑOS
                              $año2021_4 = 0;
                              $año2022_4 = 0;
                              $año2023_4 = 0;
                              $año2024_4 = 0;
                              $año2025_4 = 0;
                              $año2026_4 = 0;
                              $año2027_4 = 0;
                              $año2028_4 = 0;
                              $año2029_4 = 0;
                              $año2030_4 = 0;
                              $año2031_4 = 0;
                              $año2032_4 = 0;
                              $año2033_4 = 0;
                              $año2034_4 = 0;
                              $año2035_4 = 0;

                              $arrayNivel5 = array();
                              $query = "SELECT* FROM t_proyecciones_anuales
                              WHERE nivel = 5 and id_nivel = $idItem_4 and activo = 1 $filtroPalabraNivel2y3 $filtroVidaUtil $filtroAñoInstalacion $filtroInversion";
                              if ($result = mysqli_query($conn_2020, $query)) {
                                 foreach ($result as $x) {
                                    $idItem_5 = $x['id'];
                                    $idDepartamento_5 = $x['id_departamento'];
                                    $idNivel_5 = $x['id_nivel'];
                                    $nivel_5 = $x['nivel'];
                                    $titulo_5 = $x['titulo'];
                                    $vidaUtil_5 = $x['vida_util'];
                                    $añoInstalacion_5 = $x['año_instalacion'];
                                    $inversion_5 = $x['inversion'];
                                    $coste_5 = $x['coste'];
                                    $unidades_5 = $x['unidades'];
                                    $total_5 = $x['total'];
                                    $totalHijos_4++;

                                    #PROYECCIÓN DE AÑOS
                                    $año2021_5 = 0;
                                    $año2022_5 = 0;
                                    $año2023_5 = 0;
                                    $año2024_5 = 0;
                                    $año2025_5 = 0;
                                    $año2026_5 = 0;
                                    $año2027_5 = 0;
                                    $año2028_5 = 0;
                                    $año2029_5 = 0;
                                    $año2030_5 = 0;
                                    $año2031_5 = 0;
                                    $año2032_5 = 0;
                                    $año2033_5 = 0;
                                    $año2034_5 = 0;
                                    $año2035_5 = 0;

                                    #RECORRE AÑOS
                                    if ($añoInstalacion_5 > 0 and $vidaUtil_5 > 0) {
                                       while ($añoInstalacion_5 < 2032) {

                                          if ($añoInstalacion_5 == 2021) {
                                             $año2021_5 = $total_5;
                                             $año2021_4 += $total_5;
                                             $año2021_3 += $total_5;
                                             $año2021_2 += $total_5;
                                             $año2021_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2022) {
                                             $año2022_5 = $total_5;
                                             $año2022_4 += $total_5;
                                             $año2022_3 += $total_5;
                                             $año2022_2 += $total_5;
                                             $año2022_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2023) {
                                             $año2023_5 = $total_5;
                                             $año2023_4 += $total_5;
                                             $año2023_3 += $total_5;
                                             $año2023_2 += $total_5;
                                             $año2023_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2024) {
                                             $año2024_5 = $total_5;
                                             $año2024_4 += $total_5;
                                             $año2024_3 += $total_5;
                                             $año2024_2 += $total_5;
                                             $año2024_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2025) {
                                             $año2025_5 = $total_5;
                                             $año2025_4 += $total_5;
                                             $año2025_3 += $total_5;
                                             $año2025_2 += $total_5;
                                             $año2025_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2026) {
                                             $año2026_5 = $total_5;
                                             $año2026_4 += $total_5;
                                             $año2026_3 += $total_5;
                                             $año2026_2 += $total_5;
                                             $año2026_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2027) {
                                             $año2027_5 = $total_5;
                                             $año2027_4 += $total_5;
                                             $año2027_3 += $total_5;
                                             $año2027_2 += $total_5;
                                             $año2027_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2028) {
                                             $año2028_5 = $total_5;
                                             $año2028_4 += $total_5;
                                             $año2028_3 += $total_5;
                                             $año2028_2 += $total_5;
                                             $año2028_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2029) {
                                             $año2029_5 = $total_5;
                                             $año2029_4 += $total_5;
                                             $año2029_3 += $total_5;
                                             $año2029_2 += $total_5;
                                             $año2029_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2030) {
                                             $año2030_5 = $total_5;
                                             $año2030_4 += $total_5;
                                             $año2030_3 += $total_5;
                                             $año2030_2 += $total_5;
                                             $año2030_1 += $total_5;
                                          }

                                          if ($añoInstalacion_5 == 2031) {
                                             $año2031_5 = $total_5;
                                             $año2031_4 += $total_5;
                                             $año2031_3 += $total_5;
                                             $año2031_2 += $total_5;
                                             $año2031_1 += $total_5;
                                          }

                                          #AUMENTA AÑO SEGÚN VIDA UTIL
                                          $añoInstalacion_5 += $vidaUtil_5;
                                       }
                                    }

                                    #NIVEL 5
                                    $arrayNivel5[] = array(
                                       "idItem" => $idItem_5,
                                       "idDepartamento" => $idDepartamento_5,
                                       "idNivel" => $idNivel_5,
                                       "nivel" => $nivel_5,
                                       "titulo" => $titulo_5,
                                       "vidaUtil" => intval($vidaUtil_5),
                                       "añoInstalacion" => intval($añoInstalacion_5),
                                       "inversion" => $inversion_5,
                                       "coste" => floatval($coste_5),
                                       "unidades" => intval($unidades_5),
                                       "total" => $total_5,
                                       "año2021" => $año2021_5,
                                       "año2022" => $año2022_5,
                                       "año2023" => $año2023_5,
                                       "año2024" => $año2024_5,
                                       "año2025" => $año2025_5,
                                       "año2026" => $año2026_5,
                                       "año2027" => $año2027_5,
                                       "año2028" => $año2028_5,
                                       "año2029" => $año2029_5,
                                       "año2030" => $año2030_5,
                                       "año2031" => $año2031_5,
                                       "año2032" => $año2032_5,
                                       "año2033" => $año2033_5,
                                       "año2034" => $año2034_5,
                                       "año2035" => $año2035_5,
                                    );
                                 }
                              }

                              if ($totalHijos_4 == 0) {
                                 #RECORRE AÑOS
                                 if ($añoInstalacion_4 > 0 and $vidaUtil_4 > 0) {
                                    while ($añoInstalacion_4 < 2032) {

                                       if ($añoInstalacion_4 == 2021) {
                                          $año2021_4 += $total_4;
                                          $año2021_3 += $total_4;
                                          $año2021_2 += $total_4;
                                          $año2021_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2022) {
                                          $año2022_4 += $total_4;
                                          $año2022_3 += $total_4;
                                          $año2022_2 += $total_4;
                                          $año2022_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2023) {
                                          $año2023_4 += $total_4;
                                          $año2023_3 += $total_4;
                                          $año2023_2 += $total_4;
                                          $año2023_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2024) {
                                          $año2024_4 += $total_4;
                                          $año2024_3 += $total_4;
                                          $año2024_2 += $total_4;
                                          $año2024_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2025) {
                                          $año2025_4 += $total_4;
                                          $año2025_3 += $total_4;
                                          $año2025_2 += $total_4;
                                          $año2025_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2026) {
                                          $año2026_4 += $total_4;
                                          $año2026_3 += $total_4;
                                          $año2026_2 += $total_4;
                                          $año2026_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2027) {
                                          $año2027_4 += $total_4;
                                          $año2027_3 += $total_4;
                                          $año2027_2 += $total_4;
                                          $año2027_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2028) {
                                          $año2028_4 += $total_4;
                                          $año2028_3 += $total_4;
                                          $año2028_2 += $total_4;
                                          $año2028_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2029) {
                                          $año2029_4 += $total_4;
                                          $año2029_3 += $total_4;
                                          $año2029_2 += $total_4;
                                          $año2029_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2030) {
                                          $año2030_4 += $total_4;
                                          $año2030_3 += $total_4;
                                          $año2030_2 += $total_4;
                                          $año2030_1 += $total_4;
                                       }

                                       if ($añoInstalacion_4 == 2031) {
                                          $año2031_4 += $total_4;
                                          $año2031_3 += $total_4;
                                          $año2031_2 += $total_4;
                                          $año2031_1 += $total_4;
                                       }

                                       #AUMENTA AÑO SEGÚN VIDA UTIL
                                       $añoInstalacion_4 += $vidaUtil_4;
                                    }
                                 }
                              }

                              #NIVEL 4
                              $arrayNivel4[] = array(
                                 "idItem" => $idItem_4,
                                 "idDepartamento" => $idDepartamento_4,
                                 "idNivel" => $idNivel_4,
                                 "nivel" => $nivel_4,
                                 "titulo" => $titulo_4,
                                 "vidaUtil" => intval($vidaUtil_4),
                                 "añoInstalacion" => intval($añoInstalacion_4),
                                 "inversion" => $inversion_4,
                                 "coste" => floatval($coste_4),
                                 "unidades" => intval($unidades_4),
                                 "total" => $total_4,
                                 "arrayNivel5" => $arrayNivel5,
                                 "año2021" => $año2021_4,
                                 "año2022" => $año2022_4,
                                 "año2023" => $año2023_4,
                                 "año2024" => $año2024_4,
                                 "año2025" => $año2025_4,
                                 "año2026" => $año2026_4,
                                 "año2027" => $año2027_4,
                                 "año2028" => $año2028_4,
                                 "año2029" => $año2029_4,
                                 "año2030" => $año2030_4,
                                 "año2031" => $año2031_4,
                                 "año2032" => $año2032_4,
                                 "año2033" => $año2033_4,
                                 "año2034" => $año2034_4,
                                 "año2035" => $año2035_4,
                              );
                           }
                        }


                        if ($totalHijos_3 == 0) {
                           #RECORRE AÑOS
                           if ($añoInstalacion_3 > 0 and $vidaUtil_3 > 0) {
                              while ($añoInstalacion_3 < 2032) {

                                 if ($añoInstalacion_3 == 2021) {
                                    $año2021_3 += $total_3;
                                    $año2021_2 += $total_3;
                                    $año2021_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2022) {
                                    $año2022_3 += $total_3;
                                    $año2022_2 += $total_3;
                                    $año2022_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2023) {
                                    $año2023_3 += $total_3;
                                    $año2023_2 += $total_3;
                                    $año2023_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2024) {
                                    $año2024_3 += $total_3;
                                    $año2024_2 += $total_3;
                                    $año2024_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2025) {
                                    $año2025_3 += $total_3;
                                    $año2025_2 += $total_3;
                                    $año2025_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2026) {
                                    $año2026_3 += $total_3;
                                    $año2026_2 += $total_3;
                                    $año2026_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2027) {
                                    $año2027_3 += $total_3;
                                    $año2027_2 += $total_3;
                                    $año2027_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2028) {
                                    $año2028_3 += $total_3;
                                    $año2028_2 += $total_3;
                                    $año2028_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2029) {
                                    $año2029_3 += $total_3;
                                    $año2029_2 += $total_3;
                                    $año2029_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2030) {
                                    $año2030_3 += $total_3;
                                    $año2030_2 += $total_3;
                                    $año2030_1 += $total_3;
                                 }

                                 if ($añoInstalacion_3 == 2031) {
                                    $año2031_3 += $total_3;
                                    $año2031_2 += $total_3;
                                    $año2031_1 += $total_3;
                                 }

                                 #AUMENTA AÑO SEGÚN VIDA UTIL
                                 $añoInstalacion_3 += $vidaUtil_3;
                              }
                           }
                        }

                        #NIVEL 3
                        $arrayNivel3[] = array(
                           "idItem" => $idItem_3,
                           "idDepartamento" => $idDepartamento_3,
                           "idNivel" => $idNivel_3,
                           "nivel" => $nivel_3,
                           "titulo" => $titulo_3,
                           "vidaUtil" => intval($vidaUtil_3),
                           "añoInstalacion" => intval($añoInstalacion_3),
                           "inversion" => $inversion_3,
                           "coste" => floatval($coste_3),
                           "unidades" => intval($unidades_3),
                           "total" => $total_3,
                           "itemsNivel4" => $arrayNivel4,
                           "año2021" => $año2021_3,
                           "año2022" => $año2022_3,
                           "año2023" => $año2023_3,
                           "año2024" => $año2024_3,
                           "año2025" => $año2025_3,
                           "año2026" => $año2026_3,
                           "año2027" => $año2027_3,
                           "año2028" => $año2028_3,
                           "año2029" => $año2029_3,
                           "año2030" => $año2030_3,
                           "año2031" => $año2031_3,
                           "año2032" => $año2032_3,
                           "año2033" => $año2033_3,
                           "año2034" => $año2034_3,
                           "año2035" => $año2035_3
                        );
                     }
                  }

                  if ($totalHijos_2 == 0) {
                     #RECORRE AÑOS
                     if ($añoInstalacion_2 > 0 and $vidaUtil_2 > 0) {
                        while ($añoInstalacion_2 < 2032) {

                           if ($añoInstalacion_2 == 2021) {
                              $año2021_2 += $total_2;
                              $año2021_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2022) {
                              $año2022_2 += $total_2;
                              $año2022_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2023) {
                              $año2023_2 += $total_2;
                              $año2023_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2024) {
                              $año2024_2 += $total_2;
                              $año2024_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2025) {
                              $año2025_2 += $total_2;
                              $año2025_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2026) {
                              $año2026_2 += $total_2;
                              $año2026_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2027) {
                              $año2027_2 += $total_2;
                              $año2027_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2028) {
                              $año2028_2 += $total_2;
                              $año2028_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2029) {
                              $año2029_2 += $total_2;
                              $año2029_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2030) {
                              $año2030_2 += $total_2;
                              $año2030_1 += $total_2;
                           }

                           if ($añoInstalacion_2 == 2031) {
                              $año2031_2 += $total_2;
                              $año2031_1 += $total_2;
                           }

                           #AUMENTA AÑO SEGÚN VIDA UTIL
                           $añoInstalacion_2 += $vidaUtil_2;
                        }
                     }
                  }

                  #NIVEL 2
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
                     "totalNivel2" => $total_2,
                     "itemsNivel3" => $arrayNivel3,
                     "año2021" => $año2021_2,
                     "año2022" => $año2022_2,
                     "año2023" => $año2023_2,
                     "año2024" => $año2024_2,
                     "año2025" => $año2025_2,
                     "año2026" => $año2026_2,
                     "año2027" => $año2027_2,
                     "año2028" => $año2028_2,
                     "año2029" => $año2029_2,
                     "año2030" => $año2030_2,
                     "año2031" => $año2031_2,
                     "año2032" => $año2032_2,
                     "año2033" => $año2033_2,
                     "año2034" => $año2034_2,
                     "año2035" => $año2035_2
                  );
               }
            }

            #NIVEL 1
            $array[] = array(
               "idDepartamento" => intval($idDepartamento),
               "departamento" => $departamento,
               "seccion" => $seccion,
               "coste" => $coste,
               "total" => $total,
               "items" => $arrayItems,
               "año2021" => $año2021_1,
               "año2022" => $año2022_1,
               "año2023" => $año2023_1,
               "año2024" => $año2024_1,
               "año2025" => $año2025_1,
               "año2026" => $año2026_1,
               "año2027" => $año2027_1,
               "año2028" => $año2028_1,
               "año2029" => $año2029_1,
               "año2030" => $año2030_1,
               "año2031" => $año2031_1,
               "año2032" => $año2032_1,
               "año2033" => $año2033_1,
               "año2034" => $año2034_1,
               "año2035" => $año2035_1
            );
         }
      }
      echo json_encode($array);
   }


   #CREA UN NUEVO DEPARTAMENTO
   if ($action == "agregarDepartamento") {
      $data = json_decode(file_get_contents('php://input'), true);

      $departamento = $data['departamento'];
      $seccion = $data['seccion'];

      $resp = 0;
      $query = "INSERT INTO t_proyecciones_departamentos(id_destino, creado_por, departamento, seccion, activo) VALUES($idDestino, $idUsuario, '$departamento', '$seccion', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }


   #AGREGA ITEM NIVEL 2 
   if ($action == "agregarNivel2") {
      $data = json_decode(file_get_contents('php://input'), true);
      $titulo = $data['titulo'];
      $idDepartamento = $_GET['idDepartamento'];

      $resp = 0;
      $query = "INSERT INTO t_proyecciones_anuales(id_destino, creado_por, id_departamento, id_nivel, nivel, titulo, activo) VALUES($idDestino, $idUsuario, $idDepartamento, 0, 2, '$titulo', 1)";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }


   #AGREGA ITEM NIVEL 2 
   if ($action == "agregarNivel3") {
      $data = json_decode(file_get_contents('php://input'), true);
      $titulo = $data['titulo'];
      $vidaUtil = intval($data['vidaUtil']);
      $añoInstalacion = intval($data['añoInstalacion']);
      $inversion = $data['inversion'];
      $coste = floatval($data['coste']);
      $unidades = intval($data['unidades']);
      $idDepartamento = $_GET['idDepartamento'];
      $idNivel = $_GET['idNivel'];
      $total = 0;

      // if ($inversion != "FF&E" || $inversion != "OS&E")
      //    $inversion = "";

      if ($coste > 0 && $unidades > 0)
         $total = $coste * $unidades;



      $resp = 0;
      $query = "INSERT INTO t_proyecciones_anuales(id_destino, creado_por, id_departamento, id_nivel, nivel, titulo, vida_util, año_instalacion, inversion, coste, unidades, total, activo) VALUES($idDestino, $idUsuario, $idDepartamento, $idNivel, 3, '$titulo', $vidaUtil, '$añoInstalacion', '$inversion', $coste, $unidades, $total, 1)";
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
      $titulo = $data['titulo2'];
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


   #ACTUALIZAR NIVEL 3
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


   #ACTUALIZAR NIVEL 3
   if ($action == "actualizar") {
      $resp = 0;
      $data = json_decode(file_get_contents('php://input'), true);

      $idItem = $data['idItem'];
      $titulo = $data['titulo'];
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

      if ($idItem > 0) {
         $query = "UPDATE t_proyecciones_anuales
         SET titulo = '$titulo', vida_util = $vidaUtil, año_instalacion = '$añoInstalacion', inversion = '$inversion', coste = $coste, unidades = $unidades, total = $total, ultima_modificacion = '$fechaActual', modificado_por = $idUsuario
         WHERE id = $idItem";
         if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
         }
      }
      echo json_encode($resp);
   }

   #ELIMINA ITEM
   if ($action == "eliminarItem") {
      $resp = 0;
      $data = json_decode(file_get_contents('php://input'), true);

      $idItem = $data['idItem'];
      $query = "UPDATE t_proyecciones_anuales SET activo = 0 WHERE id = $idItem";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }

      echo json_encode($resp);
   }


   #PROYECCIONES POR AÑOS
   if ($action == "obtenerProyecciones") {

      $data = json_decode(file_get_contents('php://input'), true);

      $palabra = $data['palabra'];
      $ceco = $data['ceco'];
      $departamento = $data['departamento'];
      $vidaUtil = $data['vidaUtil'];
      $añoInstalacion = $data['añoInstalacion'];
      $inversion = $data['inversion'];

      if ($palabra == "") {
         $filtroPalabraNivel2y3 = "";
      } else {
         $filtroPalabraNivel2y3 = "and (titulo LIKE '%$palabra%' OR vida_util LIKE '%$palabra%' OR inversion LIKE '%$palabra%' OR coste LIKE '%$palabra%' OR unidades LIKE '%$palabra%' OR total LIKE '%$palabra%')";
      }

      if ($departamento == "TODOS") {
         $filtroDepartamento = "";
      } else {
         $filtroDepartamento = "and departamento = '$departamento'";
      }

      if ($ceco == "TODOS") {
         $filtroCeco = "";
      } else {
         $filtroCeco = "and seccion = '$ceco'";
      }

      if ($vidaUtil == "TODOS") {
         $filtroVidaUtil = "";
      } else {
         $filtroVidaUtil = "and vida_util = '$vidaUtil'";
      }

      if ($añoInstalacion == "TODOS") {
         $filtroAñoInstalacion = "";
      } else {
         $filtroAñoInstalacion = " and año_instalacion = '$añoInstalacion'";
      }

      if ($inversion == "TODOS") {
         $filtroInversion = "";
      } else {
         $filtroInversion = "inversion = '$inversion'";
      }

      #OBTENER DEPARTAMENTOS POR DESTINO
      $query = "SELECT id, departamento, seccion, coste
      FROM t_proyecciones_departamentos
      WHERE id_destino = $idDestino and activo = 1 $filtroCeco $filtroDepartamento";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idDepartamento = $x['id'];
            $departamento = $x['departamento'];
            $seccion = $x['seccion'];
            $coste = 0;

            $año2021_1 = 0;
            $año2022_1 = 0;
            $año2023_1 = 0;
            $año2024_1 = 0;
            $año2025_1 = 0;
            $año2026_1 = 0;
            $año2027_1 = 0;
            $año2028_1 = 0;
            $año2029_1 = 0;
            $año2030_1 = 0;
            $año2031_1 = 0;

            $arrayItems = array();

            #OBTIENE ITEMS POR DESTINO
            $query = "SELECT* FROM t_proyecciones_anuales
            WHERE activo = 1 and id_departamento = $idDepartamento and
            ((nivel = 2 and id_nivel = 0))";
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
                  $totalHijos_2 = 0;

                  $año2021_2 = 0;
                  $año2022_2 = 0;
                  $año2023_2 = 0;
                  $año2024_2 = 0;
                  $año2025_2 = 0;
                  $año2026_2 = 0;
                  $año2027_2 = 0;
                  $año2028_2 = 0;
                  $año2029_2 = 0;
                  $año2030_2 = 0;
                  $año2031_2 = 0;

                  $arrayNivel3 = array();

                  $query = "SELECT* FROM t_proyecciones_anuales
                  WHERE nivel = 3 and id_nivel = $idItem_2 and activo = 1 and inversion = 'FF&E'
                  $filtroPalabraNivel2y3 $filtroVidaUtil $filtroAñoInstalacion $filtroInversion";
                  if ($result = mysqli_query($conn_2020, $query)) {
                     foreach ($result as $x) {
                        $idItem_3 = $x['id'];
                        $idDepartamento_3 = $x['id_departamento'];
                        $idNivel_3 = $x['id_nivel'];
                        $nivel_3 = $x['nivel'];
                        $titulo_3 = $x['titulo'];
                        $vidaUtil_3 = intval($x['vida_util']);
                        $añoInstalacion_3 = intval($x['año_instalacion']);
                        $inversion_3 = $x['inversion'];
                        $coste_3 = $x['coste'];
                        $unidades_3 = $x['unidades'];
                        $total_3 = $x['total'];
                        $totalNivel2_2 += $total_3;
                        $coste += $total_3;
                        $totalHijos_2++;

                        $año2021_3 = 0;
                        $año2022_3 = 0;
                        $año2023_3 = 0;
                        $año2024_3 = 0;
                        $año2025_3 = 0;
                        $año2026_3 = 0;
                        $año2027_3 = 0;
                        $año2028_3 = 0;
                        $año2029_3 = 0;
                        $año2030_3 = 0;
                        $año2031_3 = 0;

                        $año = intval($añoInstalacion_3);
                        if ($vidaUtil_3 > 0 && $año > 0) {
                           while ($año <= 2031) {

                              if ($año == 2021) {
                                 $año2021_1 += $total_3;
                                 $año2021_2 += $total_3;
                                 $año2021_3 = $total_3;
                              }

                              if ($año == 2022) {
                                 $año2022_1 += $total_3;
                                 $año2022_2 += $total_3;
                                 $año2022_3 = $total_3;
                              }

                              if ($año == 2023) {
                                 $año2023_1 += $total_3;
                                 $año2023_2 += $total_3;
                                 $año2023_3 = $total_3;
                              }

                              if ($año == 2024) {
                                 $año2024_1 += $total_3;
                                 $año2024_2 += $total_3;
                                 $año2024_3 = $total_3;
                              }

                              if ($año == 2025) {
                                 $año2025_1 += $total_3;
                                 $año2025_2 += $total_3;
                                 $año2025_3 = $total_3;
                              }

                              if ($año == 2026) {
                                 $año2026_1 += $total_3;
                                 $año2026_2 += $total_3;
                                 $año2026_3 = $total_3;
                              }

                              if ($año == 2027) {
                                 $año2027_1 += $total_3;
                                 $año2027_2 += $total_3;
                                 $año2027_3 = $total_3;
                              }

                              if ($año == 2028) {
                                 $año2028_1 += $total_3;
                                 $año2028_2 += $total_3;
                                 $año2028_3 = $total_3;
                              }

                              if ($año == 2029) {
                                 $año2029_1 += $total_3;
                                 $año2029_2 += $total_3;
                                 $año2029_3 = $total_3;
                              }

                              if ($año == 2030) {
                                 $año2030_1 += $total_3;
                                 $año2030_2 += $total_3;
                                 $año2030_3 = $total_3;
                              }

                              if ($año == 2031) {
                                 $año2031_1 += $total_3;
                                 $año2031_2 += $total_3;
                                 $año2031_3 = $total_3;
                              }

                              $año += $vidaUtil_3;
                           }
                        }

                        $arrayNivel3[] = array(
                           "idItem" => $idItem_3,
                           "idDepartamento" => $idDepartamento_3,
                           "idNivel" => $idNivel_3,
                           "nivel" => $nivel_3,
                           "titulo" => $titulo_3,
                           "vidaUtil" => intval($vidaUtil_3),
                           "añoInstalacion" => intval($añoInstalacion_3),
                           "inversion" => $inversion_3,
                           "coste" => floatval($coste_3),
                           "unidades" => intval($unidades_3),
                           "total" => $total_3,
                           "año2021" => $año2021_3,
                           "año2022" => $año2022_3,
                           "año2023" => $año2023_3,
                           "año2024" => $año2024_3,
                           "año2025" => $año2025_3,
                           "año2026" => $año2026_3,
                           "año2027" => $año2027_3,
                           "año2028" => $año2028_3,
                           "año2029" => $año2029_3,
                           "año2030" => $año2030_3,
                           "año2031" => $año2031_3,
                        );
                     }
                  }

                  if ($totalHijos_2 === 0) {

                     $año = intval($añoInstalacion_2);
                     if ($vidaUtil_2 > 0 && $año > 0) {
                        while ($año <= 2031) {

                           if ($año == 2021) {
                              $año2021_1 += $total_2;
                              $año2021_2 += $total_2;
                           }

                           if ($año == 2022) {
                              $año2022_1 += $total_2;
                              $año2022_2 += $total_2;
                           }

                           if ($año == 2023) {
                              $año2023_1 += $total_2;
                              $año2023_2 += $total_2;
                           }

                           if ($año == 2024) {
                              $año2024_1 += $total_2;
                              $año2024_2 += $total_2;
                           }

                           if ($año == 2025) {
                              $año2025_1 += $total_2;
                              $año2025_2 += $total_2;
                           }

                           if ($año == 2026) {
                              $año2026_1 += $total_2;
                              $año2026_2 += $total_2;
                           }

                           if ($año == 2027) {
                              $año2027_1 += $total_2;
                              $año2027_2 += $total_2;
                           }

                           if ($año == 2028) {
                              $año2028_1 += $total_2;
                              $año2028_2 += $total_2;
                           }

                           if ($año == 2029) {
                              $año2029_1 += $total_2;
                              $año2029_2 += $total_2;
                           }

                           if ($año == 2030) {
                              $año2030_1 += $total_2;
                              $año2030_2 += $total_2;
                           }

                           if ($año == 2031) {
                              $año2031_1 += $total_2;
                              $año2031_2 += $total_2;
                           }

                           $año += $vidaUtil_2;
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
                        "itemsNivel3" => $arrayNivel3,
                        "año2021" => $año2021_2,
                        "año2022" => $año2022_2,
                        "año2023" => $año2023_2,
                        "año2024" => $año2024_2,
                        "año2025" => $año2025_2,
                        "año2026" => $año2026_2,
                        "año2027" => $año2027_2,
                        "año2028" => $año2028_2,
                        "año2029" => $año2029_2,
                        "año2030" => $año2030_2,
                        "año2031" => $año2031_2,
                     );
                  } else {

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
                        "itemsNivel3" => $arrayNivel3,
                        "año2021" => $año2021_2,
                        "año2022" => $año2022_2,
                        "año2023" => $año2023_2,
                        "año2024" => $año2024_2,
                        "año2025" => $año2025_2,
                        "año2026" => $año2026_2,
                        "año2027" => $año2027_2,
                        "año2028" => $año2028_2,
                        "año2029" => $año2029_2,
                        "año2030" => $año2030_2,
                        "año2031" => $año2031_2,
                     );
                  }
               }
            }

            #OBTIENE ARRAY DE DATOS
            $array[] = array(
               "idDepartamento" => intval($idDepartamento),
               "departamento" => $departamento,
               "seccion" => $seccion,
               "coste" => $coste,
               "items" => $arrayItems,
               "año2021" => $año2021_1,
               "año2022" => $año2022_1,
               "año2023" => $año2023_1,
               "año2024" => $año2024_1,
               "año2025" => $año2025_1,
               "año2026" => $año2026_1,
               "año2027" => $año2027_1,
               "año2028" => $año2028_1,
               "año2029" => $año2029_1,
               "año2030" => $año2030_1,
               "año2031" => $año2031_1,
            );
         }
      }
      echo json_encode($array);
   }


   #ACTUALIZA DATOS DEL DESTINO
   if ($action == "editarDestino") {
      $data = json_decode(file_get_contents('php://input'), true);
      $habitaciones = $data['habitaciones'];
      $edadHotel = $data['edadHotel'];
      $propietario = $data['propietario'];
      $region = $data['region'];
      $fechaApertura = $data['fechaApertura'];
      $fechaExpansion = $data['fechaExpansion'];
      $expansionHabitaciones = $data['expansionHabitaciones'];
      $resp = 0;

      $query = "UPDATE c_destinos SET habitaciones = $habitaciones, edad_hotel = '$edadHotel', propietario = '$propietario', region = '$region', fecha_apertura = '$fechaApertura', fecha_expansion = '$fechaExpansion', expansion_habitaciones = '$expansionHabitaciones'
      WHERE id = $idDestino and status = 'A'";
      if ($result = mysqli_query($conn_2020, $query)) {
         $resp = 1;
      }
      echo json_encode($resp);
   }
}
