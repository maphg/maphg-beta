<?php
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('America/Cancun');
$fechaActual = date('Y-m-d H:m:s');

#ARRAY GLOBAL
$array = array();
$array['status'] = 'OK';
$array['version'] = '3.0.1 BETA';
$array['response'] = 'ERROR';
$array['data'] = array();

#OBTIENE EL TIPO DE PETICIÓN
$peticion = "";
if ($_SERVER['REQUEST_METHOD'])
   $peticion = $_SERVER['REQUEST_METHOD'];


#PETICIONES METODO _POST
if ($peticion === 'POST') {
   $_POST = json_decode(file_get_contents('php://input'), true);

   #VARIABLES REQUERIDAS
   $apartado = $_POST['apartado'];
   $accion = $_POST['accion'];
   $idDestino = $_POST['idDestino'];
   $idUsuario = $_POST['idUsuario'];

   #APARTADO DE PROYECTOS
   if ($apartado === 'proyectos') {
      include 'conexion.php';
      include_once "proyectos.php";

      if ($accion === "all") {
         // OBTENER PROYECTOS FILTRADOS

         $proyecto = Proyectos::all($idDestino);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $proyecto;
      }

      if ($accion === "crear") {
         // CREAR PROYECTO

         $idSeccion = $_GET['idSeccion'];
         $idSubseccion = $_GET['idSubseccion'];
         $titulo = $_POST['proyecto'];
         $justificacion = $_POST['justificacion'];

         $proyecto = new Proyectos();
         $proyecto->idDestino = $idDestino;
         $proyecto->idSeccion = $idSeccion;
         $proyecto->idSubseccion = $idSubseccion;
         $proyecto->proyecto = $titulo;
         $proyecto->justificacion = $justificacion;

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $proyecto->crear();
      }

      if ($accion === "actualizar") {
         // ACTUALIZA PROYECTO

         $idProyecto = $_POST['idProyecto'];
         $titulo = $_POST['proyecto'];

         $proyecto = Proyectos::getById($idProyecto);
         $proyecto->proyecto = $titulo;

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $proyecto->actualizar();
      }

      if ($accion === 'eliminar') {
         // ELIMINAR PROYECTO
         $idProyecto = $_POST['idProyecto'];

         $proyecto = Proyectos::eliminar($idProyecto);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $proyecto;
      }
   }


   #APARTADO DE INCIDENCIAS
   if ($apartado === 'incidencias') {
      include 'conexion.php';
      include_once "incidencias.php";

      if ($accion === 'all') {
         // OBTENER INCIDENCIAS
         $incidencia = Incidencias::all($idDestino);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $incidencia;
      }

      if ($accion === 'crear') {

         // CREAR INCIDENCIA
         $idEquipo = $_POST['idEquipo'];
         $actividad = $_POST['actividad'];
         $tipoIncidencia = $_POST['tipoIncidencia'];
         $responsable = $_POST['responsable'];
         $idSeccion = $_POST['idSeccion'];
         $idSubseccion = $_POST['idSubseccion'];

         $incidencia = new Incidencias();
         $incidencia->idEquipo = $idEquipo;
         $incidencia->actividad = $actividad;
         $incidencia->tipoIncidencia = $tipoIncidencia;
         $incidencia->status = "PENDIENTE";
         $incidencia->creadoPor = $idUsuario;
         $incidencia->responsable = $responsable;
         $incidencia->fechaCreacion = $fechaActual;
         $incidencia->ultimaModificacion = $fechaActual;
         $incidencia->idDestino = $idDestino;
         $incidencia->idSeccion = $idSeccion;
         $incidencia->idSubseccion = $idSubseccion;
         $incidencia->activo = 1;

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $incidencia->crear();
      }

      if ($accion === 'actualizar') {
         // ACTUALIZAR INCIDENCIA
      }

      if ($accion === 'actualizar') {
         // ELIMINAR INCIDENCIA
      }
   }


   #APARTADO DE SECCIONES Y SUBSECCIONES
   if ($apartado === 'seccionesSubsecciones') {
      include_once "conexion.php";
      include_once "seccionesSubsecciones.php";

      if ($accion === 'all') {
         // OBTENER SECCIONES CON SUS SUBSECCIONES
         $data = seccionesSubsecciones::all($idDestino);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }

      if ($accion === 'secciones') {
         // OBTENER SECCIONES
         $data = seccionesSubsecciones::secciones($idDestino);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }

      if ($accion === 'subsecciones') {
         // OBTENER SUBSECCIONES
         $idSeccion = $_POST['idSeccion'];

         $data = seccionesSubsecciones::subsecciones($idDestino, $idSeccion);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }
   }


   #APARTADO DE REPORTES RANKING
   if ($apartado === 'ReporteRanking') {
      include_once "conexion.php";
      include_once "reporteRanking.php";
      include_once "destinos.php";
      include_once "equipos.php";
      include_once "incidencias.php";
      include_once "incidenciasGenerales.php";
      include_once "preventivos.php";
      include_once "seccionesSubsecciones.php";

      if ($accion === 'incidenciasSecciones') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $reporteRanking = ReporteRanking::incidenciasSecciones($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $reporteRanking;
         $array['destino'] = Destinos::all($idDestino);
      }

      if ($accion === 'incidenciasSubsecciones') {
         $idSeccion = $_POST['idSeccion'];
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $subsecciones = ReporteRanking::incidenciasSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $subsecciones;
      }

      if ($accion === 'destinos') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $pendientes = ReporteRanking::destinosPendientes($idDestino, $fechaInicio, $fechaFin);
         $solucionados = ReporteRanking::destinosSolucionados($idDestino, $fechaInicio, $fechaFin);
         $creados = ReporteRanking::destinosCreados($idDestino, $fechaInicio, $fechaFin);
         $mcmpCreados = ReporteRanking::mcmpCreados($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data']['pendientes'] = $pendientes;
         $array['data']['solucionados'] = $solucionados;
         $array['data']['creados'] = $creados;
         $array['data']['mcmpCreados'] = $mcmpCreados;
      }

      if ($accion === 'grafica') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $grafica = ReporteRanking::grafica($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $grafica;
      }

      if ($accion === 'mpSecciones') {
         // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $data = ReporteRanking::mpSecciones($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
         $array['destino'] = Destinos::all($idDestino);
      }

      if ($accion === 'mpPlaneaciones') {
         // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $data = ReporteRanking::mpPlanificaciones($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }

      if ($accion === 'mpPlanificacionesEquipos') {
         // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $data = ReporteRanking::mpPlanificacionesEquipos($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }

      if ($accion === 'mpSubsecciones') {
         // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)

         $idSeccion = $_POST['idSeccion'];
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $secciones = ReporteRanking::mpSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $secciones;
      }

      if ($accion === 'mpCreadasDestinos') {
         // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $destinos = ReporteRanking::mpCreadasDestinos($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $destinos;
      }

      if ($accion === 'mpCreadasDestinos') {
         // DATOS PARA GRAFICAR PREVENTIVOS POR DESTINO (fecha, creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $destinos = ReporteRanking::mpGrafica($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $destinos;
      }

      if ($accion === 'mpPlanificado') {
         // DATOS DEL AVANCE PLANIFICADO POR DESTINO (fecha, creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $equipos = ReporteRanking::mpPlanificado($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $equipos;
      }

      if ($accion === 'mpGantt') {
         // DATOS DEL AVANCE PLANIFICADO POR DESTINO (fecha, creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $equipos = ReporteRanking::mpGantt($idDestino, $idSeccion);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $equipos;
      }

      if ($accion === 'mpGrafica') {
         // DATOS DEL AVANCE PLANIFICADO POR DESTINO (fecha, creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $data = ReporteRanking::mpGrafica($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }

      if ($accion === 'MPvsMC') {
         // DATOS DEL AVANCE PLANIFICADO POR DESTINO (fecha, creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $status = $_POST['status'];

         $data = ReporteRanking::MCvsMP($idDestino, $fechaInicio, $fechaFin, $status);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }

      if ($accion === 'rankingMP') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $creados = ReporteRanking::mpCreados($idDestino, $fechaInicio, $fechaFin);
         $solucionados = ReporteRanking::mpSolucionados($idDestino, $fechaInicio, $fechaFin);
         $pendientes = ReporteRanking::mpPendientes($idDestino, $fechaInicio, $fechaFin);
         $mpmcCreados = ReporteRanking::mpmcCreados($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data']['creados'] = $creados;
         $array['data']['solucionados'] = $solucionados;
         $array['data']['pendientes'] = $pendientes;
         $array['data']['mpmcCreados'] = $mpmcCreados;
      }
   }

   #APARTADO DESTINOS
   if ($apartado === 'destinos') {
      include_once "conexion.php";
      include_once "destinos.php";

      if ($accion === 'all') {
         $destinos = Destinos::all(0);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $destinos;
      }
   }
}

echo json_encode($array);
