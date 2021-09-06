<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');


# CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

include '../php/conexion.php';


#ARRAY GLOBAL
$array = array();
$array['status'] = '404';
$array['response'] = 'ERROR';
$array['data'] = array();


#OBTIENE EL TIPO DE PETICIÓN
if ($_SERVER['REQUEST_METHOD'])
   $peticion = $_SERVER['REQUEST_METHOD'];

#PETICIONES METODO _POST
if ($peticion === "POST") {
   $_POST = json_decode(file_get_contents('php://input'), true);

   $action = $_POST['action'];
   $idDestino = $_POST['idDestino'];
   $idUsuario = $_POST['idUsuario'];

   if ($action === "filtros") {
      $array['response'] = "SUCCESS";

      $array['destinos'] = array();
      $array['secciones'] = array();
      $array['subsecciones'] = array();
      $array['tipos'] = array();
      $array['estados'] = ['PROCESO', 'SOLUCIONADO', 'PLANIFICADO'];
      $array['frecuencias'] = array();
      $array['años'] = array();
      $array['semanas'] = array();

      #FILTRO DESTINOS
      if ($idDestino == 10)
         $filtroDestino = "";
      else
         $filtroDestino = "and id = $idDestino";

      #DESTINOS
      $query = "SELECT id, destino
      FROM c_destinos
      WHERE status = 'A' $filtroDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idDestinoX = $x['id'];
            $destino = $x['destino'];

            $array['destinos'][] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
            );
         }
      }

      #SECCIONES
      $query = "SELECT seccion.id 'idSeccion', seccion.seccion, r_seccion.id 'idRelSeccion'
      FROM c_rel_destino_seccion AS r_seccion
      INNER JOIN c_secciones AS seccion ON r_seccion.id_seccion = seccion.id
      WHERE id_destino = $idDestino";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idSeccion = $x['idSeccion'];
            $seccion = $x['seccion'];
            $idRelSeccion = $x['idRelSeccion'];

            $subsecciones = array();
            $query = "SELECT subseccion.id 'idSubseccion', subseccion.grupo 'subseccion'
            FROM  c_rel_seccion_subseccion AS r_subseccion
            INNER JOIN c_subsecciones AS subseccion ON r_subseccion.id_subseccion = subseccion.id
            WHERE r_subseccion.id_rel_seccion = $idRelSeccion";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $idSubseccion = $x['idSubseccion'];
                  $subseccion = $x['subseccion'];

                  $subsecciones[] = array(
                     "idSubseccion" => $idSubseccion,
                     "subseccion" => $subseccion,
                  );
               }
            }

            #SECCIONES
            $array['secciones'][] = array(
               "idSeccion" => $idSeccion,
               "seccion" => $seccion,
               "subsecciones" => $subsecciones,
            );
         }
      }

      #TIPOS
      $query = "SELECT id, tipo FROM c_tipos
      WHERE status = 'A' ORDER BY tipo ASC";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idTipo = $x['id'];
            $tipo = $x['tipo'];

            $array['tipos'][] = array(
               "idTipo" => $idTipo,
               "tipo" => $tipo,
            );
         }
      }

      #FRECUENCIAS
      $query = "SELECT id, frecuencia
      FROM c_frecuencias_mp
      WHERE status = 'A'";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idFrecuencia = $x['id'];
            $frecuencia = $x['frecuencia'];

            $array['frecuencias'][] = array(
               "idFrecuencia" => $idFrecuencia,
               "frecuencia" => $frecuencia,
            );
         }
      }

      #AÑOS
      for ($i = 2020; $i < 2024; $i++) {
         $array['años'][] = $i;
      }

      #AÑOS
      for ($i = 1; $i < 53; $i++) {
         $array['semanas'][] = $i;
      }
   }

   if ($action == "registros") {
      $array['response'] = "SUCCESS";

      $semana = $_POST['semana'];
      $idSeccion = $_POST['idSeccion'];
      $idSubseccion = $_POST['idSubseccion'];
      $idTipo = $_POST['idTipo'];
      $año = $_POST['año'];
      $semanaInicial = $_POST['semanaInicial'];
      $semanaFinal = $_POST['semanaFinal'];
      $estado = $_POST['status'];
      $idFrecuencia = $_POST['idFrecuencia'];

      #FILTRO DESTINO
      if ($idDestino == 10) {
         $filtroDestino = "";
         $filtroDestinoEquipo = "";
      } else {
         $filtroDestino = "and id_destino = $idDestino";
         $filtroDestinoEquipo = "and e.id_destino = $idDestino";
      }

      #FILTRO SUBSECCIÓN
      if ($idSubseccion == 0)
         $filtroSubseccion = "";
      else
         $filtroSubseccion = "and e.id_subseccion = $idSubseccion";

      #FILTRO TIPO EQUIPO
      if ($idTipo == 0)
         $filtroTipoEquipo = "";
      else
         $filtroTipoEquipo = "and id_tipo = $idTipo";

      #FILTRO FRECUENCIA PLAN
      if ($idFrecuencia == 0)
         $filtroFrecuencia = "";
      else
         $filtroFrecuencia = "and frecuencia.id = $idFrecuencia";


      #QUERY
      $equipos = array();
      $totalPlaneacionesGlobal = 0;
      $totalEquipos = 0;

      $query = "SELECT e.id 'idEquipo', e.equipo, e.status, seccion.seccion,
      subseccion.grupo 'subseccion', tipo.tipo
      FROM t_equipos_america AS e
      INNER JOIN c_secciones AS seccion ON e.id_seccion = seccion.id
      INNER JOIN c_subsecciones AS subseccion ON e.id_subseccion = subseccion.id
      INNER JOIN c_tipos AS tipo ON e.id_tipo = tipo.id
      WHERE e.id_seccion = $idSeccion and e.activo = 1 and e.status IN('OPERATIVO')
      $filtroDestinoEquipo $filtroSubseccion $filtroTipoEquipo";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idEquipo = $x['idEquipo'];
            $equipo = $x['equipo'];
            $status = $x['status'];
            $seccion = $x['seccion'];
            $subseccion = $x['subseccion'];
            $tipo = $x['tipo'];
            $totalPlaneaciones = 0;

            $planeaciones = array();
            $query = "SELECT plan.*, frecuencia.frecuencia
            FROM t_mp_planeacion_semana AS plan
            INNER JOIN t_mp_planes_mantenimiento AS planes ON plan.id_plan = planes.id
            INNER JOIN c_frecuencias_mp AS frecuencia ON planes.id_periodicidad = frecuencia.id
            WHERE plan.id_equipo = $idEquipo and plan.activo = 1 $filtroFrecuencia";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $idSemana = $x['id'];
                  $idPlan = $x["id_plan"];
                  $frecuencia = $x['frecuencia'];

                  for ($i = $semanaInicial; $i < ($semanaFinal + 1); $i++) {
                     $semanaX = $x["semana_$i"];
                     $status = "";
                     if ($semanaX === "PLANIFICADO")
                        $status = "PLANIFICADO";

                     #PLANEACION EN INICIADA
                     $idOT = 0;
                     $query = "SELECT mp.id, mp.status, mp.id_plan
                     FROM t_mp_planificacion_iniciada AS mp
                     WHERE mp.id_equipo = $idEquipo and mp.semana = $i and mp.año = '$año' and
                     mp.status IN('PROCESO', 'SOLUCIONADO') and mp.id_plan = $idPlan and mp.activo = 1";
                     $array['message'] = $query;
                     if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $y) {
                           $idOT = $y['id'];
                           $status = $y['status'];
                           $idPlan = $y['id_plan'];
                        }
                     }

                     #FILTRO TODOS LOS STATUS
                     if (
                        $estado === "TODOS" &&
                        ($status === "PLANIFICADO" || $status === "PROCESO" || $status === "SOLUCIONADO")
                     ) {
                        $totalPlaneaciones++;
                        $totalPlaneacionesGlobal++;

                        $planeaciones[] = array(
                           "idOT" => $idOT,
                           "status" => $status,
                           "frecuencia" => $frecuencia,
                           "idEquipo" => $idEquipo,
                           "idPlan" => $idPlan,
                           "semana" => $i,
                        );
                     }

                     #FILTRO STATUS ESPECIFICO
                     if ($estado === $status) {
                        $totalPlaneaciones++;
                        $totalPlaneacionesGlobal++;

                        $planeaciones[] = array(
                           "idOT" => $idOT,
                           "status" => $status,
                           "frecuencia" => $frecuencia,
                           "idEquipo" => $idEquipo,
                           "idPlan" => $idPlan,
                           "semana" => $i,
                        );
                     }
                  }
               }
            }

            #EQUIPOS CON PLANITIFACION
            if (count($planeaciones)) {
               $totalEquipos++;
               $equipos[] = array(
                  "idEquipo" => $idEquipo,
                  "equipo" => $equipo,
                  "status" => $status,
                  "seccion" => $seccion,
                  "subseccion" => $subseccion,
                  "tipo" => $tipo,
                  "totalPlaneaciones" => $totalPlaneaciones,
                  "planeaciones" => $planeaciones,
               );
            }
         }
      }

      #DATA
      $array['data'] = array(
         "totalEquipos" => $totalEquipos,
         "totalPlaneaciones" => $totalPlaneacionesGlobal,
         "equipos" => $equipos,
      );
   }

   if ($action === "gantt") {
      $array['response'] = "SUCCESS";

      $semana = $_POST['semana'];
      $idSeccion = $_POST['idSeccion'];
      $idSubseccion = $_POST['idSubseccion'];
      $idTipo = $_POST['idTipo'];
      $año = $_POST['año'];
      $semanaInicial = $_POST['semanaInicial'];
      $semanaFinal = $_POST['semanaFinal'];
      $estado = $_POST['status'];
      $idFrecuencia = $_POST['idFrecuencia'];
      $vista = $_POST['vista'];

      #FILTRO DESTINO
      if ($idDestino == 10) {
         $filtroDestino = "";
         $filtroDestinoEquipo = "";
      } else {
         $filtroDestino = "and id_destino = $idDestino";
         $filtroDestinoEquipo = "and e.id_destino = $idDestino";
      }

      #FILTRO SUBSECCIÓN
      if ($idSubseccion == 0)
         $filtroSubseccion = "";
      else
         $filtroSubseccion = "and e.id_subseccion = $idSubseccion";

      #FILTRO TIPO EQUIPO
      if ($idTipo == 0)
         $filtroTipoEquipo = "";
      else
         $filtroTipoEquipo = "and id_tipo = $idTipo";

      #FILTRO FRECUENCIA PLAN
      if ($idFrecuencia == 0)
         $filtroFrecuencia = "";
      else
         $filtroFrecuencia = "and frecuencia.id = $idFrecuencia";


      #QUERY
      $equipos = array();
      $totalPlaneacionesGlobal = 0;
      $totalEquipos = 0;

      $query = "SELECT e.id 'idEquipo', e.equipo, e.status, seccion.seccion,
      subseccion.grupo 'subseccion', tipo.tipo
      FROM t_equipos_america AS e
      INNER JOIN c_secciones AS seccion ON e.id_seccion = seccion.id
      INNER JOIN c_subsecciones AS subseccion ON e.id_subseccion = subseccion.id
      INNER JOIN c_tipos AS tipo ON e.id_tipo = tipo.id
      WHERE e.id_seccion = $idSeccion and e.activo = 1 and e.status IN('OPERATIVO')
      $filtroDestinoEquipo $filtroSubseccion $filtroTipoEquipo";
      if ($result = mysqli_query($conn_2020, $query)) {
         foreach ($result as $x) {
            $idEquipo = $x['idEquipo'];
            $equipo = $x['equipo'];
            $status = $x['status'];
            $seccion = $x['seccion'];
            $subseccion = $x['subseccion'];
            $tipo = $x['tipo'];
            $totalPlaneaciones = 0;

            $planeaciones = array();
            $query = "SELECT plan.*, frecuencia.frecuencia
            FROM t_mp_planeacion_semana AS plan
            INNER JOIN t_mp_planes_mantenimiento AS planes ON plan.id_plan = planes.id
            INNER JOIN c_frecuencias_mp AS frecuencia ON planes.id_periodicidad = frecuencia.id
            WHERE plan.id_equipo = $idEquipo and plan.activo = 1 $filtroFrecuencia";
            if ($result = mysqli_query($conn_2020, $query)) {
               foreach ($result as $x) {
                  $idSemana = $x['id'];
                  $idPlan = $x["id_plan"];
                  $frecuencia = $x['frecuencia'];
                  $semanas = array();
                  $totalConActividad = 0;

                  for ($i = $semanaInicial; $i <= $semanaFinal; $i++) {
                     $semanaX = $x["semana_$i"];

                     $status = "NINGUNO";
                     if ($semanaX === "PLANIFICADO")
                        $status = "PLANIFICADO";

                     #PLANEACION EN INICIADA
                     $idOT = 0;
                     $query = "SELECT mp.id, mp.status, mp.id_plan
                     FROM t_mp_planificacion_iniciada AS mp
                     WHERE mp.id_equipo = $idEquipo and mp.semana = $i and mp.año = '$año' and
                     mp.status IN('PROCESO', 'SOLUCIONADO') and mp.id_plan = $idPlan and mp.activo = 1";
                     $array['message'] = $query;
                     if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $y) {
                           $idOT = $y['id'];
                           $status = $y['status'];
                           $idPlan = $y['id_plan'];
                        }
                     }

                     #FILTRO TODOS LOS STATUS
                     if ($estado === "TODOS") {
                        $totalPlaneaciones++;
                        $totalPlaneacionesGlobal++;

                        if ($status === "PLANIFICADO" || $status === "PROCESO" || $status === "SOLUCIONADO")
                           $totalConActividad++;

                        $semanas[$i] = array(
                           "idOT" => $idOT,
                           "status" => $status,
                           "frecuencia" => $frecuencia,
                           "idEquipo" => $idEquipo,
                           "idPlan" => $idPlan,
                           "semana" => $i,
                        );
                     } else {
                        #FILTRO STATUS ESPECIFICO
                        $totalPlaneaciones++;
                        $totalPlaneacionesGlobal++;

                        if ($status === $estado) {
                           $status = $estado;
                           $totalConActividad++;
                        } else
                           $status = "NINGUNO";

                        $semanas[$i] = array(
                           "idOT" => $idOT,
                           "status" => $status,
                           "frecuencia" => $frecuencia,
                           "idEquipo" => $idEquipo,
                           "idPlan" => $idPlan,
                           "semana" => $i,
                        );
                     }
                  }

                  #VISTA CON PLANES PLANIFICADOS
                  if ($vista == 1 && $totalConActividad > 0) {
                     $planeaciones[] = array(
                        "idSemana" => $idSemana,
                        "idPlan" => $idPlan,
                        "frecuencia" => $frecuencia,
                        "semanas" => $semanas,
                     );
                  }

                  // VISTA TODOS
                  if ($vista == 0) {
                     $planeaciones[] = array(
                        "idSemana" => $idSemana,
                        "idPlan" => $idPlan,
                        "frecuencia" => $frecuencia,
                        "semanas" => $semanas,
                     );
                  }
               }
            }

            #EQUIPOS CON PLANITIFACION
            if (count($planeaciones)) {
               $totalEquipos++;
               $equipos[] = array(
                  "idEquipo" => $idEquipo,
                  "equipo" => $equipo,
                  "status" => $status,
                  "seccion" => $seccion,
                  "subseccion" => $subseccion,
                  "tipo" => $tipo,
                  "totalPlaneaciones" => $totalPlaneaciones,
                  "planeaciones" => $planeaciones,
               );
            }
         }
      }

      #DATA
      $array['data'] = array(
         "totalEquipos" => $totalEquipos,
         "totalPlaneaciones" => $totalPlaneacionesGlobal,
         "equipos" => $equipos,
      );
   }
}

echo json_encode($array);
