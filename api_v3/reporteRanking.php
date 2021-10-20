<?php

class ReporteRanking extends Conexion
{


   // REPORTE DE INCIDENCIAS POR SECCIONES
   public static function incidenciasSecciones($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $array = array();
      $arraySecciones = array();

      #DATOS GLOBALES
      $acumuladoGlobales = 0;
      $creadosGlobales = 0;
      $solucionadosGlobales = 0;
      $pendientesGlobales = 0;
      $mediaHoras = 0;

      $secciones = seccionesSubsecciones::secciones($idDestino);
      foreach ($secciones as $x) {
         $idSeccionX = $x['idSeccion'];
         $seccion = $x['seccion'];
         $pendientes = 0;
         $creados = 0;
         $solucionados = 0;

         #ACUMULADO GLOBAL DESDE LOS INICIOS.
         $acumuladoGlobales += count(IncidenciasGenerales::totalRangoFechaStatus(
            $idDestino,
            $idSeccionX,
            0,
            "2021-01-01 00:00:01",
            date('Y-m-d 23:59:59'),
            'CREADO',
            'PENDIENTE'
         ));
         $acumuladoGlobales += count(Incidencias::totalRangoFechaStatus(
            $idDestino,
            $idSeccionX,
            0,
            "2021-01-01 00:00:01",
            date('Y-m-d 23:59:59'),
            'CREADO',
            'PENDIENTE'
         ));

         #INCIDENCIAS
         $incidencias = Incidencias::totalRangoFechaStatus(
            $idDestino,
            $idSeccionX,
            0,
            "$fechaInicio 00:00:01",
            "$fechaFin 23:59:59",
            'CREADO',
            'TODOS'
         );
         foreach ($incidencias as $x) {
            $status = $x['status'];
            $fechaA = $x['fechaCreado'];
            $fechaB = $x['fechaFinalizado'];

            #CREADOS
            $creados++;
            $creadosGlobales++;

            #PENDIENTES O ACUMULADO
            if (
               $status == 'PENDIENTE'
            ) {
               $pendientes++;
               $pendientesGlobales++;

               if ($fechaA != '') {
                  $fechaA = strtotime($fechaA);
                  $fechaB = strtotime(date('Y-m-d H:m:s'));

                  $diferencia = $fechaA - $fechaB;
                  if ($diferencia > 0)
                     $mediaHoras += $diferencia / 3600;
               }
            }

            #SOLUCIONADOS
            if ($status == 'SOLUCIONADO') {
               $solucionados++;
               $solucionadosGlobales++;

               if ($fechaA != '' && $fechaB != '') {
                  $fechaA = strtotime($fechaA);
                  $fechaB = strtotime($fechaB);

                  $diferencia = $fechaA - $fechaB;
                  if ($diferencia > 0)
                     $mediaHoras += $diferencia / 3600;
               }
            }
         }

         #INCIDENCIAS GENERALES
         $incidenciasGenerales = IncidenciasGenerales::totalRangoFechaStatus(
            $idDestino,
            $idSeccionX,
            0,
            "$fechaInicio 00:00:01",
            "$fechaFin 23:59:59",
            'CREADO',
            'TODOS'
         );
         foreach ($incidenciasGenerales as $x) {
            $status = $x['status'];
            $fechaA = $x['fechaCreado'];
            $fechaB = $x['fechaFinalizado'];

            $creados++;
            $creadosGlobales++;

            if (
               $status == 'PENDIENTE'
            ) {
               $pendientes++;
               $pendientesGlobales++;

               if ($fechaA != '') {
                  $fechaA = strtotime($fechaA);
                  $fechaB = strtotime(date('Y-m-d H:m:s'));

                  $diferencia = $fechaA - $fechaB;
                  if ($diferencia > 0)
                     $mediaHoras += $diferencia / 3600;
               }
            }

            if ($status == 'SOLUCIONADO') {
               $solucionados++;
               $solucionadosGlobales++;

               if ($fechaA != '' && $fechaB != '') {
                  $fechaA = strtotime($fechaA);
                  $fechaB = strtotime($fechaB);

                  $diferencia = $fechaA - $fechaB;
                  if ($diferencia > 0)
                     $mediaHoras += $diferencia / 3600;
               }
            }
         }

         #DATA ARRAY
         if ($idSeccionX != 1001)
            $arraySecciones[] = array(
               "idSeccion" => $idSeccionX,
               "seccion" => $seccion,
               "creados" => $creados,
               "pendientes" => $pendientes,
               "solucionados" => $solucionados,
               "fechaInicio" => $fechaInicio,
               "fechaFin" => $fechaFin,
               "incidencias" => $incidencias,
               "incidenciasGenerales" => $incidenciasGenerales,
            );
      }

      $array['secciones'] = $arraySecciones;

      #MEDIA HORAS
      if ($mediaHoras > 0 && $creadosGlobales > 0)
         $mediaHoras = $mediaHoras / $creadosGlobales;
      else
         $mediaHoras = 0;

      #RATIO
      $habitaciones = 0;
      $destinos = Destinos::all($idDestino);
      foreach ($destinos as $x)
         $habitaciones = $x['habitaciones'];

      #CREADAS
      $ratioCredas = 0;
      if ($habitaciones > 0 && $creadosGlobales > 0)
         $ratioCredas = $creadosGlobales / $habitaciones;

      #SOLUCIONADAS
      $ratioFinalizadas = 0;
      if ($habitaciones > 0 && $solucionadosGlobales > 0)
         $ratioFinalizadas = $solucionadosGlobales  / $habitaciones;

      #RESULTADOS GLOBALES
      $array['global'] = array(
         "creadosGlobales" => $creadosGlobales,
         "solucionadosGlobales" => $solucionadosGlobales,
         "pendientesGlobales" => $pendientesGlobales,
         "acumuladoGlobales" => $acumuladoGlobales,
         "mediaHoras" => $mediaHoras,
         "ratioCredas" => $ratioCredas,
         "ratioFinalizadas" => $ratioFinalizadas,
      );

      return $array;
   }


   // REPORTE DE INCIDENCIAS POR SUBSECCIONES
   public static function incidenciasSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $array = array();
      $subsecciones = seccionesSubsecciones::subsecciones($idDestino, $idSeccion);
      foreach ($subsecciones as $x) {
         $idSeccionX = $x['idSeccion'];
         $seccion = $x['seccion'];
         $idSubseccionX = $x['idSubseccion'];
         $subseccion = $x['subseccion'];
         $pendientes = 0;
         $creados = 0;
         $solucionados = 0;
         $acumulado = 0;

         #INCIDENCIAS
         $acumulado +=
            count(Incidencias::totalRangoFechaStatus($idDestino, $idSeccionX, $idSubseccionX, '2021-01-01 00:00:01', date('Y-m-d 23:59:59'), 'CREADO', 'TODOS'));

         $incidencias = Incidencias::totalRangoFechaStatus(
            $idDestino,
            $idSeccionX,
            $idSubseccionX,
            "$fechaInicio 00:00:01",
            "$fechaFin 23:59:59",
            'CREADO',
            'TODOS'
         );
         foreach ($incidencias as $x) {
            $status = $x['status'];

            $creados++;

            if ($status === 'PENDIENTE')
               $pendientes++;

            if ($status === 'SOLUCIONADO')
               $solucionados++;
         }

         #INCIDENCIAS GENERALES
         $acumulado +=
            count(IncidenciasGenerales::totalRangoFechaStatus($idDestino, $idSeccionX, $idSubseccionX, '2021-01-01 00:00:01', date('Y-m-d 23:59:59'), 'CREADO', 'TODOS'));

         $incidencias = IncidenciasGenerales::totalRangoFechaStatus(
            $idDestino,
            $idSeccionX,
            $idSubseccionX,
            "$fechaInicio 00:00:01",
            "$fechaFin 23:59:59",
            'CREADO',
            'TODOS'
         );
         foreach ($incidencias as $x) {
            $status = $x['status'];

            $creados++;

            if ($status === 'PENDIENTE')
               $pendientes++;

            if ($status === 'SOLUCIONADO')
               $solucionados++;
         }

         #DATA ARRAY
         $array[] = array(
            "idSeccion" => $idSeccionX,
            "seccion" => $seccion,
            "idSubseccion" => $idSubseccionX,
            "subseccion" => $subseccion,
            "creados" => $creados,
            "acumulado" => $acumulado,
            "pendientes" => $pendientes,
            "solucionados" => $solucionados,
            "fechaInicio" => $fechaInicio,
            "fechaFin" => $fechaFin,
         );
      }

      return $array;
   }


   // REPORTE DE INCIDENCIAS POR DESTINO (PENDIENTES)
   public static function destinosPendientes($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $total = 0;

         #MC
         $total +=
            count(Incidencias::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "PENDIENTE"
            ));

         #MC
         $total +=
            count(IncidenciasGenerales::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "PENDIENTE"
            ));

         #DESTINO SELECCIONADO
         if ($idDestinoX == $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         #ARRAY DATA
         if ($idDestinoX != 10)
            $array[] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "total" => $total,
               "destinoActual" => $destinoActual
            );
      }

      return $array;
   }


   // REPORTE DE INCIDENCIAS POR DESTINO (SOLUCIONADOS)
   public static function destinosSolucionados($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $total = 0;

         #MC
         $total +=
            count(Incidencias::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "SOLUCIONADO"
            ));

         #MC
         $total +=
            count(IncidenciasGenerales::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "SOLUCIONADO"
            ));

         #DESTINO SELECCIONADO
         if ($idDestinoX == $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         #ARRAY DATA
         if ($idDestinoX != 10)
            $array[] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "total" => $total,
               "destinoActual" => $destinoActual
            );
      }

      return $array;
   }


   // REPORTE DE INCIDENCIAS POR DESTINO (SOLUCIONADOS)
   public static function destinosCreados($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $total = 0;

         #MC
         $total +=
            count(Incidencias::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         #MC
         $total +=
            count(IncidenciasGenerales::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         #DESTINO SELECCIONADO
         if ($idDestinoX == $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         #ARRAY DATA
         if ($idDestinoX != 10)
            $array[] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "total" => $total,
               "destinoActual" => $destinoActual
            );
      }

      return $array;
   }


   // REPORTE DE INCIDENCIAS POR DESTINO (SOLUCIONADOS)
   public static function mcmpCreados($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $mc = 0;
         $mp = 0;

         #MC
         $mc +=
            count(IncidenciasGenerales::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         #MC
         $mc +=
            count(Incidencias::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         #MP
         $mp +=
            count(MP::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         $total = 0;
         if ($mc > 0)
            $total = intval((100 / ($mc + $mp)) * $mc);

         #DESTINO SELECCIONADO
         if ($idDestinoX == $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         #ARRAY DATA
         if ($idDestinoX != 10)
            $array[] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "mc" => $mc,
               "mp" => $mp,
               "total" => $total,
               "destinoActual" => $destinoActual
            );
      }

      return $array;
   }


   // GRAFICA POR DESTINO
   public static function grafica($idDestino, $fechaInicio, $fechaFin)
   {

      $array = array();
      $meses = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ag', 'Sep', 'Oct', 'Nov', 'Dic'];
      $fechaInicioX = strtotime($fechaInicio);
      $fechaFinX = strtotime($fechaFin);

      while ($fechaInicioX <= $fechaFinX) {
         $fechaA = date('Y-m-d 00:00:01', $fechaInicioX);
         $fechaB = date('Y-m-d 23:59:59', $fechaInicioX);
         $pendientes = 0;
         $creados = 0;
         $solucionados = 0;
         $acumulado = 0;

         #INCIDENCIAS
         $acumulado += count(Incidencias::totalRangoFechaStatus(
            $idDestino,
            0,
            0,
            '2021-01-01 00:00:01',
            $fechaB,
            'CREADO',
            'PENDIENTE'
         ));

         $incidencias = Incidencias::totalRangoFechaStatus($idDestino, 0, 0, $fechaA, $fechaB, 'CREADO', 'TODOS');
         foreach ($incidencias as $x) {
            $status = $x['status'];

            $creados++;

            if ($status === 'PENDIENTE')
               $pendientes++;

            if ($status === 'SOLUCIONADO')
               $solucionados++;
         }

         #INCIDENCIAS GENERALES
         $acumulado += count(IncidenciasGenerales::totalRangoFechaStatus(
            $idDestino,
            0,
            0,
            '2021-01-01 00:00:01',
            $fechaB,
            'CREADO',
            'PENDIENTE'
         ));

         $incidenciasGeneradas = IncidenciasGenerales::totalRangoFechaStatus($idDestino, 0, 0, $fechaA, $fechaB, 'CREADO', 'TODOS');
         foreach ($incidenciasGeneradas as $x) {
            $status = $x['status'];

            $creados++;

            if ($status === 'PENDIENTE')
               $pendientes++;

            if ($status === 'SOLUCIONADO')
               $solucionados++;
         }

         $mesX = intval(date('m', $fechaInicioX));
         $fecha = $meses[$mesX] . " " . date('d', $fechaInicioX);

         #DATA PARA GRAFICAR -> OPCIÓN 1
         $array['data'][] = array(
            "fechaA" => $fechaA,
            "fechaB" => $fechaB,
            "date" => $fecha,
            "creado" => $creados,
            "acumulado" => $acumulado,
            "pendientes" => $pendientes,
            "finalizado" => $solucionados,
         );

         #DATA PARA GRAFICAR -> OPCIÓN 2
         // $array['fecha'][] = $fecha;
         // $array['creados'][] = $creados;
         // $array['acumulado'][] = $acumulado;
         // $array['pendientes'][] = $pendientes;
         // $array['solucionados'][] = $solucionados;

         $fechaInicioX += 86400;
      }

      return $array;
   }


   public static function mpSecciones($idDestino, $fechaInicio, $fechaFin)
   {
      // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)
      $conexion = new Conexion();
      $conexion->conectar();
      $secciones = seccionesSubsecciones::secciones($idDestino);

      $creadasGlobal = 0;
      $pendientesGlobal = 0;
      $solucionadosGlobal = 0;
      $mediaHoras = 0;
      $planificadoGlobal = MP::mpPlanificaciones(
         $idDestino,
         0,
         0,
         0,
         "$fechaInicio 00:00:01",
         "$fechaFin 23:59:59"
      );

      $acumuladoGlobal = count(MP::totalRangoFechaStatus(
         $idDestino,
         0,
         0,
         "2021-01-01 00:00:01",
         date('Y-m-d 23:59:59'),
         'CREADO',
         'PENDIENTE'
      ));

      $array['secciones'] = array();
      $array['global'] = array();

      foreach ($secciones as $x) {
         $idSeccion = $x['idSeccion'];
         $seccion = $x['seccion'];

         #VARIABLES GENERALES
         $preventivos =
            MP::totalRangoFechaStatus(
               $idDestino,
               $idSeccion,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               'TODOS'
            );
         $creadas = 0;
         $pendientes = 0;
         $solucionados = 0;

         $planificado = MP::mpPlanificaciones(
            $idDestino,
            0,
            $idSeccion,
            0,
            "$fechaInicio 00:00:01",
            "$fechaFin 23:59:59"
         );

         foreach ($preventivos as $x) {
            $status = $x['status'];
            $fechaA = $x['fechaCreado'];
            $fechaB = $x['fechaFinalizado'];

            #CREADOS
            $creadas++;
            $creadasGlobal++;

            #PENDIENTES
            if ($status === 'PENDIENTE') {
               $pendientes++;
               $pendientesGlobal++;

               if ($fechaA != '') {
                  $fechaA = strtotime($fechaA);
                  $fechaB = strtotime(date('Y-m-d H:m:s'));

                  $diferencia = $fechaA - $fechaB;
                  if ($diferencia > 0)
                     $mediaHoras += $diferencia / 3600;
               }
            }

            #SOLUCIONADOS
            if ($status === 'SOLUCIONADO') {
               $solucionados++;
               $solucionadosGlobal++;

               if ($fechaA != '' && $fechaB != '') {
                  $fechaA = strtotime($fechaA);
                  $fechaB = strtotime($fechaB);

                  $diferencia = $fechaA - $fechaB;
                  if ($diferencia > 0)
                     $mediaHoras += $diferencia / 3600;
               }
            }
         }

         #DATA ARRAY
         if ($idSeccion != 1001)
            $array['secciones'][] = array(
               "idSeccion" => $idSeccion,
               "seccion" => $seccion,
               "fechaInicio" => $fechaInicio,
               "fechaFin" => $fechaFin,
               "creadas" => $creadas,
               "pendientes" => $pendientes,
               "solucionados" => $solucionados,
               "totalPreventivos" => count($preventivos),
               "planificado" => $planificado['totalSemanasPlanificadasGlobal']
            );
      }

      $solucionadosExtraGlobal = 0;
      if ($solucionadosGlobal > 0)
         $solucionadosExtraGlobal = $solucionadosGlobal - $planificadoGlobal['totalSemanasPlanificadasGlobal'];

      if ($solucionadosExtraGlobal < 0)
         $solucionadosExtraGlobal = 0;

      #MEDIA HORAS
      if ($mediaHoras > 0 && $creadasGlobal > 0)
         $mediaHoras = $mediaHoras / $creadasGlobal;
      else
         $mediaHoras = 0;

      #RATIO
      $habitaciones = 0;
      $destinos = Destinos::all($idDestino);
      foreach ($destinos as $x)
         $habitaciones = $x['habitaciones'];

      #CREADAS
      $ratioCredas = 0;
      if ($habitaciones > 0 && $creadasGlobal > 0)
         $ratioCredas = $creadasGlobal / $habitaciones;

      #SOLUCIONADAS
      $ratioFinalizadas = 0;
      if ($habitaciones > 0 && $solucionadosGlobal > 0)
         $ratioFinalizadas = $solucionadosGlobal  / $habitaciones;


      $array['global'] = array(
         "creadasGlobal" => $creadasGlobal,
         "pendientesGlobal" => $pendientesGlobal,
         "solucionadosGlobal" => $solucionadosGlobal,
         "acumuladoGlobal" => $acumuladoGlobal,
         "planificadoGlobal" => $planificadoGlobal['totalConPlanificacionesGlobal'],
         "solucionadosExtraGlobal" => $solucionadosExtraGlobal,
         "ratioCredas" => $ratioCredas,
         "ratioFinalizadas" => $ratioFinalizadas,
         "mediaHoras" => $mediaHoras,
         "totalSemanasPlanificadasGlobal" => $planificadoGlobal['totalSemanasPlanificadasGlobal']
      );
      return $array;
   }


   public static function mpSubsecciones($idDestino, $idSeccion, $fechaInicio, $fechaFin)
   {
      // REPORTE DE PREVENTIVOS POR SECCIONES (creadas, pendientes, solucionados, acumulado)
      $conexion = new Conexion();
      $conexion->conectar();
      $subseccion = seccionesSubsecciones::subsecciones($idDestino, $idSeccion);;

      $array = array();
      foreach ($subseccion as $x) {
         $idSeccion = $x['idSeccion'];
         $seccion = $x['seccion'];
         $idSubseccion = $x['idSubseccion'];
         $subseccion = $x['subseccion'];
         $creadas = 0;
         $pendientes = 0;
         $solucionados = 0;

         $preventivos = MP::totalRangoFechaStatus(
            $idDestino,
            $idSeccion,
            $idSubseccion,
            "$fechaInicio 00:00:01",
            "$fechaFin 23:59:59",
            'CREADO',
            'TODOS'
         );

         $acumulado = count(MP::totalRangoFechaStatus(
            $idDestino,
            $idSeccion,
            $idSubseccion,
            '2021-01-01 00:00:01',
            date('Y-m-d 23:59:59'),
            'CREADO',
            'PENDIENTE'
         ));

         foreach ($preventivos as $x) {
            $status = $x['status'];

            $creadas++;

            if ($status === 'PENDIENTE')
               $pendientes++;

            if ($status === 'SOLUCIONADO')
               $solucionados++;
         }

         #DATA ARRAY
         $array[] = array(
            "idSeccion" => $idSeccion,
            "seccion" => $seccion,
            "idSubseccion" => $idSubseccion,
            "subseccion" => $subseccion,
            "fechaInicio" => $fechaInicio,
            "fechaFin" => $fechaFin,
            "creadas" => $creadas,
            "pendientes" => $pendientes,
            "solucionados" => $solucionados,
            "acumulado" => $acumulado,
            "totalPreventivos" => count($preventivos),
            // "preventivos" => $preventivos,
         );
      }

      return $array;
   }


   public static function mpGrafica($idDestino, $fechaInicio, $fechaFin)
   {
      // DATOS PARA GRAFICAR PREVENTIVOS

      $array = array();
      $meses = ['', 'Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ag', 'Sep', 'Oct', 'Nov', 'Dic'];
      $fechaInicioX = strtotime($fechaInicio);
      $fechaFinX = strtotime($fechaFin);

      while ($fechaInicioX <= $fechaFinX) {
         $fechaA = date('Y-m-d 00:00:01', $fechaInicioX);
         $fechaB = date('Y-m-d 23:59:59', $fechaInicioX);
         $pendientes = 0;
         $creados = 0;
         $solucionados = 0;
         $acumulado = 0;

         #INCIDENCIAS
         $acumulado += count(MP::totalRangoFechaStatus(
            $idDestino,
            0,
            0,
            '2021-01-01 00:00:01',
            $fechaB,
            'CREADO',
            'PENDIENTE'
         ));

         $mp = MP::totalRangoFechaStatus($idDestino, 0, 0, $fechaA, $fechaB, 'CREADO', 'TODOS');
         foreach ($mp as $x) {
            $status = $x['status'];

            $creados++;

            if ($status === 'PENDIENTE')
               $pendientes++;

            if ($status === 'SOLUCIONADO')
               $solucionados++;
         }

         $mesX = intval(date('m', $fechaInicioX));
         $fecha = $meses[$mesX] . " " . date('d', $fechaInicioX);

         #DATA PARA GRAFICAR -> OPCIÓN 1
         $array[] = array(
            "fechaA" => $fechaA,
            "fechaB" => $fechaB,
            "date" => $fecha,
            "creado" => $creados,
            "acumulado" => $acumulado,
            "pendientes" => $pendientes,
            "finalizado" => $solucionados,
         );

         #DATA PARA GRAFICAR -> OPCIÓN 2
         // $array['fecha'][] = $fecha;
         // $array['creados'][] = $creados;
         // $array['acumulado'][] = $acumulado;
         // $array['pendientes'][] = $pendientes;
         // $array['solucionados'][] = $solucionados;

         $fechaInicioX += 86400;
      }

      return $array;
   }


   public static function mpCreadasDestinos($idDestino, $fechaInicio, $fechaFin)
   {
      // REPORTE DE PREVENTIVOS POR DESTINOS (creadas, pendientes, solucionados, acumulado)
      $conexion = new Conexion();
      $conexion->conectar();
      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $creadas = 0;
         $pendientes = 0;
         $solucionados = 0;
         $acumulado =
            count(MP::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               '2021-01-01 00:00:01',
               date('Y-m-d 23:59:59'),
               'CREADO',
               'PENDIENTE'
            ));

         #DESTINO SELECCIONADO
         if ($idDestinoX === $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         $preventivos = MP::totalRangoFechaStatus(
            $idDestinoX,
            0,
            0,
            "$fechaInicio 00:00:01",
            "$fechaFin 23:59:59",
            'CREADO',
            'TODOS'
         );

         foreach ($preventivos as $x) {
            $status = $x['status'];

            $creadas++;

            if ($status === 'PENDIENTE')
               $pendientes++;

            if ($status === 'SOLUCIONADO')
               $solucionados++;
         }

         #DATA ARRAY
         $array[] = array(
            "idDestino" => $idDestinoX,
            "destino" => $destino,
            "creadas" => $creadas,
            "pendientes" => $pendientes,
            "solucionados" => $solucionados,
            "acumulado" => $acumulado,
            "destinoActual" => $destinoActual,
         );
      }

      return $array;
   }


   public static function mpPlanificado($idDestino)
   {
      // REPORTE DE PREVENTIVOS POR DESTINOS (creadas, pendientes, solucionados, acumulado)
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      $secciones = seccionesSubsecciones::secciones($idDestino);

      foreach ($secciones as $x) {
         $idSeccion = $x['idSeccion'];
         $seccion = $x['seccion'];
         $totalEquipos = 0;
         $planificados = 0;
         $planificadosFull = 0;
         $sinPlanificar = 0;
         $sinPlanes = 0;

         $equipos = Equipos::equiposFiltrados(0, $idDestino, $idSeccion, 0, 'OPERATIVO');
         $arrayEquipos = array();
         foreach ($equipos as $x) {
            $idEquipo = $x['idEquipo'];
            $equipo = $x['equipo'];
            $status = $x['status'];
            $idTipoEquipo = $x['idTipoEquipo'];
            $tipoEquipo = $x['tipoEquipo'];
            $idDestinoX = $x['idDestino'];
            $destino = $x['destino'];
            $idSeccion = $x['idSeccion'];
            $seccion = $x['seccion'];
            $idSubseccion = $x['idSubseccion'];
            $subseccion = $x['subseccion'];
            $planeacion = MP::mpProgramados($idDestinoX, $idEquipo, $idTipoEquipo);

            #DATOS PARA LA SECCIÓN
            $totalEquipos++;

            foreach ($planeacion as $x) {
               $totalPlanes = $x['totalPlanes'];
               $totalPlanificaciones = $x['totalPlanificaciones'];
               $conPlanes = $x['conPlanes'];
               $porcentajePlanificado = $x['porcentajePlanificado'];

               if (($totalPlanificaciones <= $totalPlanes) && $totalPlanificaciones > 0)
                  $planificados++;

               if ($porcentajePlanificado == 100)
                  $planificadosFull++;

               if (($conPlanes) && $totalPlanificaciones == 0)
                  $sinPlanificar++;

               if (!$conPlanes)
                  $sinPlanes++;
            }

            // #ARRAY EQUIPOS
            // $arrayEquipos[] = array(
            //    "idEquipo" => $idEquipo,
            //    "equipo" => $equipo,
            //    "status" => $status,
            //    "idDestino" => $idDestinoX,
            //    "destino" => $destino,
            //    "idSeccion" => $idSeccion,
            //    "seccion" => $seccion,
            //    "idSubseccion" => $idSubseccion,
            //    "subseccion" => $subseccion,
            //    "idTipoEquipo" => $idTipoEquipo,
            //    "tipoEquipo" => $tipoEquipo,
            //    "planeacion" => $planeacion,
            // );
         }

         #DATA ARRAY
         $array[] = array(
            "idSeccion" => $idSeccion,
            "seccion" => $seccion,
            "totalEquipos" => $totalEquipos,
            "planificados" => $planificados,
            "planificadosFull" => $planificadosFull,
            "sinPlanificar" => $sinPlanificar,
            "sinPlanes" => $sinPlanes,
            "equipos" => $arrayEquipos,
         );
      }

      return $array;
   }


   public static function mpGantt($idDestino, $idSeccion)
   {
      // GANTT SEMANAS
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      $equipos = Equipos::equiposFiltrados(0, $idDestino, $idSeccion, 0, 'OPERATIVO', '');
      $index = 1;

      foreach ($equipos as $x) {
         $idEquipo = $x['idEquipo'];

         $x['index'] = $index++;
         $x['x'] = MP::mpEquipo($idEquipo);

         $array[] = $x;
      }

      return $array;
   }


   // REPORTE DE PREVENTIVOS POR DESTINO (CREADOS)
   public static function mpCreados($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $total = 0;

         #MP
         $total +=
            count(MP::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         #DESTINO SELECCIONADO
         if ($idDestinoX == $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         #ARRAY DATA
         if (
            $idDestinoX != 10
         )
            $array[] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "total" => $total,
               "destinoActual" => $destinoActual
            );
      }

      return $array;
   }


   // REPORTE DE PREVENTIVOS POR DESTINO (SOLUCIONADOS)
   public static function mpSolucionados($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $total = 0;

         #MP
         $total +=
            count(MP::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "SOLUCIONADO"
            ));

         #DESTINO SELECCIONADO
         if ($idDestinoX == $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         #ARRAY DATA
         if (
            $idDestinoX != 10
         )
            $array[] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "total" => $total,
               "destinoActual" => $destinoActual
            );
      }

      return $array;
   }


   // REPORTE DE PREVENTIVOS POR DESTINO (CREADOS)
   public static function mpPendientes($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $total = 0;

         #MP
         $total +=
            count(MP::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "PENDIENTE"
            ));

         #DESTINO SELECCIONADO
         if ($idDestinoX == $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         #ARRAY DATA
         if (
            $idDestinoX != 10
         )
            $array[] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "total" => $total,
               "destinoActual" => $destinoActual
            );
      }

      return $array;
   }


   // REPORTE DE INCIDENCIAS POR DESTINO (SOLUCIONADOS)
   public static function mpmcCreados($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $destinos = Destinos::all(10);
      $array = array();

      foreach ($destinos as $x) {
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $mc = 0;
         $mp = 0;

         #MC
         $mc +=
            count(IncidenciasGenerales::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         #MC
         $mc +=
            count(Incidencias::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         #MP
         $mp +=
            count(MP::totalRangoFechaStatus(
               $idDestinoX,
               0,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               "TODOS"
            ));

         $total = 0;
         if ($mp > 0)
            $total = intval((100 / ($mc + $mp)) * $mp);

         #DESTINO SELECCIONADO
         if ($idDestinoX == $idDestino)
            $destinoActual = true;
         else
            $destinoActual = false;

         #ARRAY DATA
         if (
            $idDestinoX != 10
         )
            $array[] = array(
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "mc" => $mc,
               "mp" => $mp,
               "total" => $total,
               "destinoActual" => $destinoActual
            );
      }

      return $array;
   }


   public static function MCvsMP($idDestino, $fechaInicio, $fechaFin, $status)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $array['secciones'] = array();
      $array['global'] = array();

      // COMPARA INCIDENCIAS CON MP
      $secciones = seccionesSubsecciones::secciones($idDestino);
      $mcGlobal = 0;
      $mpGlobal = 0;

      foreach ($secciones as $x) {
         $idSeccion = $x['idSeccion'];
         $seccion = $x['seccion'];
         $mc = 0;
         $mcg = 0;
         $mp = 0;

         #MC
         $mc =
            count(IncidenciasGenerales::totalRangoFechaStatus(
               $idDestino,
               $idSeccion,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               $status
            ));

         #MC
         $mcg =
            count(Incidencias::totalRangoFechaStatus(
               $idDestino,
               $idSeccion,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               $status
            ));
         $mcGlobal += $mc + $mcg;

         #MP
         $mp +=
            count(MP::totalRangoFechaStatus(
               $idDestino,
               $idSeccion,
               0,
               "$fechaInicio 00:00:01",
               "$fechaFin 23:59:59",
               'CREADO',
               $status
            ));
         $mpGlobal += $mp;

         #DATA
         if ($idSeccion != 1001)
            $array['secciones'][] = array(
               "idSeccion" => $idSeccion,
               "seccion" => $seccion,
               "mc" => $mc + $mcg,
               "mp" => $mp,
               "status" => $status,
            );
      }

      #DATA GLOBAL
      $array['global'] = array(
         "mcGlobal" => $mcGlobal,
         "mpGlobal" => $mpGlobal
      );

      return $array;
   }


   public static function mpPlanificaciones($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      $totalequiposGlobal = 0;
      $totalConPlanificacionesGlobal = 0;
      $totalSinPlanificacionesGlobal = 0;
      $totalPlanificacionesGlobal = 0;
      $totalPlanificadosCompletosGlobal = 0;
      $totalPlanificadosIncompletosGlobal = 0;

      $secciones = seccionesSubsecciones::secciones($idDestino);

      $planeacionesSecciones = array();
      foreach ($secciones as $x) {
         $idSeccion = $x['idSeccion'];
         $seccion = $x['seccion'];

         $totalEquipos = count(Equipos::equiposFiltrados(
            0,
            $idDestino,
            $idSeccion,
            0,
            'OPERATIVO',
            ''
         ));
         $totalequiposGlobal += $totalEquipos;

         $planeacion = MP::mpPlanificaciones($idDestino, 0, $idSeccion, 0, $fechaInicio, $fechaFin);
         $totalConPlanificaciones = $planeacion['totalConPlanificacionesGlobal'];
         $totalSinPlanificaciones = $planeacion['totalSinPlanificacionesGlobal'];
         $totalPlanificaciones = $planeacion['totalPlanificacionesGlobal'];
         $totalSemanasPlanificadas = $planeacion['totalSemanasPlanificadasGlobal'];
         $totalPlanificadosCompletos = $planeacion['totalPlanificadosCompletosGlobal'];
         $totalPlanificadosIncompletos = $planeacion['totalPlanificadosIncompletosGlobal'];

         #DATOS GLOBALES
         $totalConPlanificacionesGlobal += $totalConPlanificaciones;
         $totalSinPlanificacionesGlobal += $totalSinPlanificaciones;
         $totalPlanificacionesGlobal += $totalPlanificaciones;
         $totalPlanificadosCompletosGlobal += $totalPlanificadosCompletos;
         $totalPlanificadosIncompletosGlobal += $totalPlanificadosIncompletos;

         #DATA
         if ($idSeccion != 1001)
            $planeacionesSecciones[] = array(
               "idSeccion" => $idSeccion,
               "seccion" => $seccion,
               "totalConPlanificaciones" => $totalConPlanificaciones,
               "totalSinPlanificaciones" => $totalSinPlanificaciones,
               "totalPlanificaciones" => $totalPlanificaciones,
               "totalSemanasPlanificadas" => $totalSemanasPlanificadas,
               "totalPlanificadosCompletos" => $totalPlanificadosCompletos,
               "totalPlanificadosIncompletos" => $totalPlanificadosIncompletos,
               "totalEquipos" => $totalEquipos
            );
      }

      #DATA
      $array = array(
         "planeacionesSecciones" => $planeacionesSecciones,
         "totalequiposGlobal" => $totalequiposGlobal,
         "totalConPlanificacionesGlobal" => $totalConPlanificacionesGlobal,
         "totalSinPlanificacionesGlobal" => $totalSinPlanificacionesGlobal,
         "totalPlanificacionesGlobal" => $totalPlanificacionesGlobal,
         "totalPlanificadosCompletosGlobal" => $totalPlanificadosCompletosGlobal,
         "totalPlanificadosIncompletosGlobal" => $totalPlanificadosIncompletosGlobal
      );

      return $array;
   }

   
   public static function mpPlanificacionesEquipos($idDestino, $fechaInicio, $fechaFin)
   {
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();
      $equipos = array();

      #DATOS GLOBLES
      $totalEquipos = count(Equipos::equiposFiltrados(0, $idDestino, 0, 0, 'OPERATIVO'));
      $totalEquiposPlanificadosGlobal = 0;
      $totalEquiposPlanCompleto = 0;

      $planeaciones = MP::mpPlanificacionesEquipos($idDestino, 0, 0, 0, $fechaInicio, $fechaFin);
      foreach ($planeaciones as $x) {

         $idEquipo = 0;
         $equipo = "";
         $totalPlanes = 0;
         $totalConPlanificaciones = 0;
         $totalSinPlanificaciones = 0;
         $totalPlanificaciones = 0;
         $totalSemanasPlanificadas = 0;
         $totalPlanificadosCompletos = 0;
         $totalPlanificadosIncompletos = 0;
         $totalSaltos = 0;
         $porcentaje = 0;
         $semanas = array();
         $data = array();
         $totalEquiposPlanificadosGlobal++;

         foreach ($x as $y) {
            $idEquipo = $y['idEquipo'];
            $equipo = $y['equipo'];
            $totalConPlanificaciones += $y['totalConPlanificaciones'];
            $totalSinPlanificaciones += $y['totalSinPlanificaciones'];
            $totalPlanificaciones += $y['totalPlanificaciones'];
            $totalSemanasPlanificadas += $y['totalSemanasPlanificadas'];
            $totalPlanificadosCompletos += $y['totalPlanificadosCompletos'];
            $totalPlanificadosIncompletos += $y['totalPlanificadosIncompletos'];
            $totalSaltos += $y['totalSaltos'];
            $semanas = $y['semanas'];

            #CALCULO DE PORCENTAJE
            if ($y['totalSaltos'] > 0)
               $porcentaje = (100 / intval($y['totalSaltos'])) * intval($y['totalSemanasPlanificadas']);

            if ($porcentaje >= 100)
               $porcentaje = 100;

            $porcentaje += $porcentaje;

            $totalPlanes++;
            $data[] = $y;
         }

         if ($porcentaje > 0)
            $porcentaje = $porcentaje / $totalPlanes;

         if ($porcentaje >= 100)
            $porcentaje = 100;

         if ($porcentaje >= 100)
            $totalEquiposPlanCompleto++;

         #DATA
         $equipos[] = array(
            "idEquipo" => $idEquipo,
            "equipos" => $equipo,
            "totalPlanes" => $totalPlanes,
            "totalConPlanificaciones" => $totalConPlanificaciones,
            "totalSinPlanificaciones" => $totalSinPlanificaciones,
            "totalPlanificaciones" => $totalPlanificaciones,
            "totalSemanasPlanificadas" => $totalSemanasPlanificadas,
            "totalPlanificadosCompletos" => $totalPlanificadosCompletos,
            "totalPlanificadosIncompletos" => $totalPlanificadosIncompletos,
            "totalSaltos" => $totalSaltos,
            "porcentaje" => $porcentaje,
            "data" => $data,
         );
      }

      $array = array(
         "totalEquipos" => $totalEquipos,
         "totalEquiposConPlanificacion" => intval($totalEquiposPlanificadosGlobal),
         "totalEquiposSinPlanificacion" => intval($totalEquipos - $totalEquiposPlanificadosGlobal),
         "totalEquiposPlanCompleto" => $totalEquiposPlanCompleto,
      );

      return $array;
   }
}
