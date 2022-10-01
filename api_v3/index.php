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
      include_once "usuarios.php";

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
         $array['destino'] = Destinos::all($idDestino);
      }

      if ($accion === 'destinosIncidencias') {
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

      if ($accion === 'destinosIncidenciasSubsecciones') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         // FALTO CREAR LOS METODOS

         $pendientes = ReporteRanking::destinosPendientesSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);
         $solucionados =
            ReporteRanking::destinosSolucionadosSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);
         $creados = ReporteRanking::destinosCreadosSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);
         $mcmpCreados = ReporteRanking::mcmpCreadosSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data']['pendientes'] = $pendientes;
         $array['data']['solucionados'] = $solucionados;
         $array['data']['creados'] = $creados;
         $array['data']['mcmpCreados'] = $mcmpCreados;
      }

      if ($accion === 'graficaIncidencias') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];

         $graficaIncidencias = ReporteRanking::graficaIncidencias($idDestino, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $graficaIncidencias;
      }

      if ($accion === 'graficaIncidenciasSubsecciones') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $graficaIncidenciasSubsecciones =
            ReporteRanking::graficaIncidenciasSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $graficaIncidenciasSubsecciones;
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

      if ($accion === 'mpSubsecciones') {
         // REPORTE DE PREVENTIVOS POR SUBSECCIONES (creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $data = ReporteRanking::mpSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

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

      if ($accion === 'mpPlaneacionesSubsecciones') {
         // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $data = ReporteRanking::mpPlaneacionesSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

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

      if ($accion === 'mpPlanificacionesEquiposSubsecciones') {
         // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $data = ReporteRanking::mpPlanificacionesEquiposSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
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

      if ($accion === 'mpGraficaSubsecciones') {
         // DATOS DEL AVANCE PLANIFICADO POR DESTINO (fecha, creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $data = ReporteRanking::mpGraficaSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

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

      if ($accion === 'MPvsMCSubsecciones') {
         // DATOS DEL AVANCE PLANIFICADO POR DESTINO (fecha, creadas, pendientes, solucionados, acumulado)

         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $status = $_POST['status'];
         $idSeccion = $_POST['idSeccion'];

         $data = ReporteRanking::MPvsMCSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin, $status);

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

      if ($accion === 'rankingMPSubsecciones') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $creados = ReporteRanking::mpCreadosSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);
         $solucionados = ReporteRanking::mpSolucionadosSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);
         $pendientes = ReporteRanking::mpPendientesSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);
         $mpmcCreados = ReporteRanking::mpmcCreadosSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data']['creados'] = $creados;
         $array['data']['solucionados'] = $solucionados;
         $array['data']['pendientes'] = $pendientes;
         $array['data']['mpmcCreados'] = $mpmcCreados;
      }

      if ($accion === 'incidenciasUsuarios') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $data = ReporteRanking::incidenciasUsuarios($idDestino, $idSeccion, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }

      if ($accion === 'preventivosUsuarios') {
         $fechaInicio = $_POST['fechaInicio'];
         $fechaFin = $_POST['fechaFin'];
         $idSeccion = $_POST['idSeccion'];

         $data = ReporteRanking::preventivosUsuarios($idDestino, $idSeccion, $fechaInicio, $fechaFin);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
      }

      if ($accion === 'detalleSeccion') {
         $idSeccion = $_POST['idSeccion'];

         $data = seccionesSubsecciones::detalleSeccion($idDestino, $idSeccion);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $data;
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


   #APARTADO SABANAS
   if ($apartado === 'sabanas') {
      include_once "conexion.php";
      include_once "destinos.php";
      include_once "sabanas.php";
      include_once "equipos.php";
      include_once "usuarios.php";

      if ($accion === 'listaTiposActivos') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Equipos::listaTiposActivos($idDestinoSeleccionado);
      }

      if ($accion === 'destinos') {
         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::getDestinos($idDestino);
      }

      if ($accion === 'hoteles') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::getHoteles($idDestinoSeleccionado);
      }

      if ($accion === 'tiposActivos') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idHotel = $_POST['idHotel'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::getTiposActivos($idDestinoSeleccionado, $idHotel);
      }

      if ($accion === 'sabanas') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idHotel = $_POST['idHotel'];
         $idRegistroTipoActivo = $_POST['idRegistroTipoActivo'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::getSabanas($idDestinoSeleccionado, $idHotel, $idRegistroTipoActivo);
      }

      if ($accion === 'apartados') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idSabana = $_POST['idSabana'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::getApartados($idDestinoSeleccionado, $idSabana);
      }

      if ($accion === 'actividades') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idApartado = $_POST['idApartado'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::getActividades($idDestinoSeleccionado, $idApartado);
      }

      if ($accion === 'actualizarSabana') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idHotel = $_POST['idHotel'];
         $idRegistroTipoActivo = $_POST['idRegistroTipoActivo'];
         $idSabana = $_POST['idSabana'];
         $sabana = $_POST['sabana'];
         $activo = $_POST['activo'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::actualizarSabana(
            $idDestinoSeleccionado,
            $idHotel,
            $idRegistroTipoActivo,
            $idSabana,
            $sabana,
            $activo
         );
      }

      if ($accion === 'actualizarApartado') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idSabana = $_POST['idSabana'];
         $idApartado = $_POST['idApartado'];
         $apartado = $_POST['tituloApartado'];
         $opciones = $_POST['opciones'];
         $activo = $_POST['activo'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::actualizarApartado(
            $idDestino,
            $idSabana,
            $idApartado,
            $apartado,
            $opciones,
            $activo
         );
      }

      if ($accion === 'actualizarActividad') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idActividad = $_POST['idActividad'];
         $idApartado = $_POST['idApartado'];
         $actividad = $_POST['actividad'];
         $adjunto = $_POST['adjunto'];
         $comentario = $_POST['comentario'];
         $activo = $_POST['activo'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::actualizarActividad(
            $idDestinoSeleccionado,
            $idActividad,
            $idApartado,
            $actividad,
            $adjunto,
            $comentario,
            $activo
         );
      }

      if ($accion === 'agregarActividad') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idApartado = $_POST['idApartado'];
         $idActividad = $_POST['idActividad'];
         $actividad = $_POST['actividad'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::agregarActividad($idDestinoSeleccionado, $idActividad, $idApartado, $idUsuario, $actividad);
      }

      if ($accion === 'agregarRegistroTipoActivo') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idHotel = $_POST['idHotel'];
         $idTipoActivo = $_POST['idTipoActivo'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::agregarRegistroTipoActivo($idDestinoSeleccionado, $idHotel, $idTipoActivo, $idUsuario);
      }

      if ($accion === 'agregarChecklist') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idHotel = $_POST['idHotel'];
         $idRegistroTipoActivo = $_POST['idRegistroTipoActivo'];
         $idSabana = $_POST['idSabana'];
         $sabana = $_POST['sabana'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::agregarChecklist(
            $idDestinoSeleccionado,
            $idSabana,
            $idHotel,
            $idRegistroTipoActivo,
            $sabana,
            $idUsuario
         );
      }

      if ($accion === 'agregarApartado') {
         $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
         $idSabana = $_POST['idSabana'];
         $idApartado = $_POST['idApartado'];
         $tituloApartado = $_POST['tituloApartado'];
         $opciones = $_POST['opciones'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::agregarApartado(
            $idDestinoSeleccionado,
            $idApartado,
            $idSabana,
            $opciones,
            $tituloApartado,
            $idUsuario
         );

         // $array['data'] = $_POST;
      }

      if ($accion === 'reporte') {
         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::reporte($_POST);
      }

      if ($accion === 'filtrosReporte') {
         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::filtrosReporte($_POST);
      }

      if ($accion === 'filtrosClonarConfiguracion') {
         #ARRAY DE RESULTADOS PARA CLONAR
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::filtrosClonarConfiguracion($_POST);
      }

      if ($accion === 'consultarTipos') {
         #ARRAY DE RESULTADOS PARA CLONAR
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::getTiposActivos(0, $_POST['idHotel']);
      }

      if ($accion === 'consultaActividades') {
         #ARRAY DE RESULTADOS PARA CLONAR
         $array['response'] = "SUCCESS";
         $array['data'] = Sabanas::consultaActividades($_POST);
      }
   }


   #APARTADO PEDIDOS
   if ($apartado === 'pedidos') {
      include 'conexion.php';
      include 'pedidos.php';

      if ($accion === 'solicitudes2bend') {
         #SOLICITUDES COD2BEND

         $pagina = intval($_POST['pagina']);
         $rangoPaginas = intval($_POST['rangoPaginas']);
         $palabra = $_POST['palabra'];
         $columnaOrdenar = $_POST['columnaOrdenar'];
         $tipoOrden = $_POST['tipoOrden'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Pedidos::solicitudes2bend(
            $idDestino,
            $pagina,
            $rangoPaginas,
            $palabra,
            $columnaOrdenar,
            $tipoOrden
         );
      }


      if ($accion === 'totalPedidos') {
         #SOLICITUDES COD2BEND

         $palabra = $_POST['palabra'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Pedidos::totalPedidos($idDestino, $palabra);
      }


      if ($accion === 'pedidosSinOrden') {
         #PEDIDOS SIN ORDEN

         $pagina = intval($_POST['pagina']);
         $rangoPaginas = intval($_POST['rangoPaginas']);
         $palabra = $_POST['palabra'];
         $columnaOrdenar = $_POST['columnaOrdenar'];
         $tipoOrden = $_POST['tipoOrden'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Pedidos::pedidosSinOrden(
            $idDestino,
            $pagina,
            $rangoPaginas,
            $palabra,
            $columnaOrdenar,
            $tipoOrden
         );
      }


      if ($accion === 'totalPedidosSinOrden') {
         #PEDIDOS SIN ORDEN

         $palabra = $_POST['palabra'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Pedidos::totalPedidosSinOrden($idDestino, $palabra);
      }


      if ($accion === 'pedidosPorEntregar') {
         #PEDIDOS POR ENTREGAR

         $pagina = intval($_POST['pagina']);
         $rangoPaginas = intval($_POST['rangoPaginas']);
         $palabra = $_POST['palabra'];
         $columnaOrdenar = $_POST['columnaOrdenar'];
         $tipoOrden = $_POST['tipoOrden'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Pedidos::pedidosPorEntregar(
            $idDestino,
            $pagina,
            $rangoPaginas,
            $palabra,
            $columnaOrdenar,
            $tipoOrden
         );
      }


      if ($accion === 'totalPedidosPorEntregar') {
         #PEDIDOS POR ENTREGAR

         $palabra = $_POST['palabra'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Pedidos::totalPedidosPorEntregar($idDestino, $palabra);
      }


      if ($accion === 'pedidosEntregados') {
         #PEDIDOS ENTREGADOS

         $pagina = intval($_POST['pagina']);
         $rangoPaginas = intval($_POST['rangoPaginas']);
         $palabra = $_POST['palabra'];
         $columnaOrdenar = $_POST['columnaOrdenar'];
         $tipoOrden = $_POST['tipoOrden'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Pedidos::pedidosEntregados(
            $idDestino,
            $pagina,
            $rangoPaginas,
            $palabra,
            $columnaOrdenar,
            $tipoOrden
         );
      }


      if ($accion === 'totalPedidosEntregados') {
         #PEDIDOS ENTREGADOS

         $palabra = $_POST['palabra'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = Pedidos::totalPedidosEntregados($idDestino, $palabra);
      }
   }


   #APARTADO DE STAFF COVID
   if ($apartado === 'staffCovid') {
      include 'conexion.php';
      include_once "registros_staff_codiv.php";

      if ($accion === "all") {
         #PARAMETROS ADICIONALES
         $año = intval($_POST['año']);

         // OBTENER TODOS LOS REGISTROS STAFF
         $registros = StaffCovid::all($idDestino, $año);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $registros;
      }

      if ($accion === "crear") {

         // CREAR REGISTRO
         $fechaEstimada = $_POST['fechaEstimada'];
         $pais = "MEXICO";
         $mes = intval(date('m', strtotime($fechaEstimada)));
         $año = date('Y', strtotime($fechaEstimada));
         $staffAprobado = $_POST['staffAprobado'];
         $staffContratado = $_POST['staffContratado'];
         $staffFaltanteConCovid = $_POST['staffFaltanteConCovid'];
         $incapacidadesMedicas = $_POST['incapacidadesMedicas'];
         $observaciones = $_POST['observaciones'];

         $staff = new StaffCovid();
         $staff->idDestino = intval($idDestino);
         $staff->creadoPor = intval($idUsuario);
         $staff->fechaActual = $fechaActual;
         $staff->fechaEstimada = $fechaEstimada;
         $staff->pais = strtoupper($pais);
         $staff->mes = strtoupper($mes);
         $staff->año = intval($año);
         $staff->staffAprobado = intval($staffAprobado);
         $staff->staffContratado = intval($staffContratado);
         $staff->staffFaltanteConCovid = doubleval($staffFaltanteConCovid);
         $staff->incapacidadesMedicas = intval($incapacidadesMedicas);
         $staff->observaciones = $observaciones;
         $staff->activo = 1;

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $staff->crear();
      }

      if ($accion === "actualizar") {

         // ACTUALIZA REGISTRO
         $idRegistro = $_POST['idRegistro'];
         $fechaEstimada = $_POST['fechaEstimada'];
         $pais = "MEXICO";
         $mes = intval(date('m', strtotime($fechaEstimada)));
         $año = date('Y', strtotime($fechaEstimada));
         $staffAprobado = $_POST['staffAprobado'];
         $staffContratado = $_POST['staffContratado'];
         $staffFaltanteConCovid = $_POST['staffFaltanteConCovid'];
         $incapacidadesMedicas = $_POST['incapacidadesMedicas'];
         $observaciones = $_POST['observaciones'];
         $activo = $_POST['activo'];

         $staff = new StaffCovid();
         $staff->idRegistro = intval($idRegistro);
         $staff->idDestino = intval($idDestino);
         $staff->actualizadoPor = intval($idUsuario);
         $staff->fechaActual = $fechaActual;
         $staff->fechaEstimada = $fechaEstimada;
         $staff->pais = strtoupper($pais);
         $staff->mes = strtoupper($mes);
         $staff->año = intval($año);
         $staff->staffAprobado = intval($staffAprobado);
         $staff->staffContratado = intval($staffContratado);
         $staff->staffFaltanteConCovid = doubleval($staffFaltanteConCovid);
         $staff->incapacidadesMedicas = intval($incapacidadesMedicas);
         $staff->observaciones = $observaciones;
         $staff->activo = intval($activo);

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $staff->actualizar();
      }


      if ($accion === "opcionesDestino") {

         $staff = new StaffCovid();

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $staff->opcionesDestino($idUsuario);
      }
   }


   #APARTADO OT MP
   if ($apartado === 'otMp') {
      include 'conexion.php';
      include_once "otMp.php";

      if ($accion === "ot") {
         #PARAMETROS ADICIONALES
         $idOt = explode(",", $_POST['idOt']);
         $registros = array();

         // OBTENER TODOS LOS REGISTROS
         foreach ($idOt as $x) {
            $resultado =  OtMp::ot($idUsuario, $x);

            if (count($resultado))
               $registros[] = $resultado;
         }

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $registros;
      }
   }


   #APARTADO DE EQUIPOS
   if ($apartado === 'equipo') {
      include 'conexion.php';
      include_once "equipos.php";
      include_once "incidencias.php";
      include_once "preventivos.php";
      include_once "otMp.php";

      if ($accion === 'detalle') {
         $idEquipo = $_POST['idEquipo'];

         #OBTIENE INFORMACIÓN DEL EQUIPO
         $resultado = Equipos::equiposFiltrados($idEquipo, $idDestino, 0, 0, 0, '');
         $equipo = array();

         if (count($resultado)) {
            $equipo = $resultado;

            #INCIDENCIAS
            $equipo[0]['incidencias'] = Incidencias::porEquipo($idDestino, $idEquipo);

            #PLANIFICACIÓN
            $equipo[0]['planificacion'] = MP::mpEquipo($idEquipo);

            #PREVENTIVOS(Ots)
            $equipo[0]['preventivos'] = OtMp::otEquipo($idDestino, $idEquipo);
         }




         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = $equipo;
      }
   }


   #APARTADO DE AUDITORIA DE PROYECTOS
   if ($apartado === 'auditoriaProyectos') {
      include 'conexion.php';
      include_once "auditoriaProyectos.php";

      if ($accion === 'all') {

         #OBTIENE INFORMACIÓN DEL EQUIPO
         $destino = $_POST['destino'];

         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = AuditoriaProyectos::all($destino, $_POST);
      }

      if ($accion === 'actualizar') {
         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = AuditoriaProyectos::actualizarTareas($_POST);
      }

      if ($accion === 'actualizarAdjunto') {
         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = AuditoriaProyectos::actualizarAdjunto($_POST);
      }

      if ($accion === 'actualizarFase') {
         #ARRAY DE RESULTADOS
         $array['response'] = "SUCCESS";
         $array['data'] = AuditoriaProyectos::actualizarFase($_POST);
      }
   }
}

echo json_encode($array);
