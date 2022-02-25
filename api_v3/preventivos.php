<?php
class MP extends Conexion
{

   public static function totalRangoFechaStatus(
      $idDestino,
      $idSeccion = 0,
      $idSubseccion = 0,
      $fechaInicio,
      $fechaFin,
      $fecha = 'TODOS',
      $status = 'TODOS'
   ) {
      // DEVULVE EL TOTAL DE INCIDENCIAS ENCONTRADAS CON RANGO DE FECHA Y STATUS
      $conexion = new Conexion();
      $conexion->conectar();

      #FILTRO SECCIÓN
      if ($idSeccion === 0)
         $filtroSeccion = "";
      else
         $filtroSeccion = "and e.id_seccion = $idSeccion";

      #FILTRO SUBSECCIÓN
      if ($idSubseccion === 0)
         $filtroSubseccion = "";
      else
         $filtroSubseccion = "and e.id_subseccion = $idSubseccion";

      #STATUS PENDIENTE
      if ($status === 'PENDIENTE')
         $filtroStatus = "and mp.status IN('N', 'PENDIENTE', 'P', 'PROCESO')";

      #STATUS SOLUCIONADO
      if ($status === 'SOLUCIONADO')
         $filtroStatus = "and mp.status IN('F', 'FINALIZADO', 'SOLUCIONADO')";

      #STATUS TODOS
      if ($status === 'TODOS')
         $filtroStatus = "";

      #FECHA CREADO
      if ($fecha === 'CREADO')
         $filtroFecha = "and mp.fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin'";

      #FECHA CREADO
      if ($fecha === 'SOLUCIONADO')
         $filtroFecha = "and mp.fecha_finalizado BETWEEN '$fechaInicio' and '$fechaFin'";

      #FECHA CREADO
      if ($fecha === 'TODOS')
         $filtroFecha = "";

      $query = "SELECT
         mp.id,
         mp.status,
         mp.activo,
         mp.id_usuario 'creado_por',
         mp.id_responsables,
         mp.realizado_por 'realizadoPor',
         mp.fecha_creacion,
         mp.fecha_finalizado,
         d.id 'idDestino',
         d.destino,
         sec.id 'idSeccion',
         sec.seccion,
         sub.id 'idSubseccion',
         sub.grupo 'subseccion',
         e.id 'idEquipo',
         e.equipo
         FROM t_mp_planificacion_iniciada AS mp
         INNER JOIN t_equipos_america AS e ON mp.id_equipo = e.id
         INNER JOIN c_destinos AS d ON e.id_destino = d.id
         INNER JOIN c_secciones AS sec ON e.id_seccion = sec.id
         INNER JOIN c_subsecciones AS sub ON e.id_subseccion = sub.id
         WHERE e.id_destino = ? and mp.activo = 1
         $filtroSeccion $filtroStatus $filtroFecha $filtroSubseccion";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         $idPreventivo = $x['id'];
         $preventivo = "PREVENTIVO";
         $tipoIncidencia = "PREVENTIVO";
         $status = $x['status'];
         $creadoPor = intval($x['creado_por']);
         $responsable = intval($x['id_responsables']);
         $realizadoPor = $x['realizadoPor'];
         $fechaCreado = $x['fecha_creacion'];
         $fechaFinalizado = $x['fecha_finalizado'];
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $idSeccion = $x['idSeccion'];
         $seccion = $x['seccion'];
         $idSubseccion = $x['idSubseccion'];
         $subseccion = $x['subseccion'];
         $idEquipo = $x['idEquipo'];
         $equipo = $x['equipo'];
         $activo = $x['activo'];

         if ($status === 'N' || $status === 'PENDIENTE' || $status === 'PROCESO')
            $status = 'PENDIENTE';
         else
            $status = 'SOLUCIONADO';

         #RESULTADO FINAL DE PROYECTOS
         $array[] =
            array(
               "idPreventivo" => $idPreventivo,
               "preventivo" => $preventivo,
               "tipoIncidencia" => $tipoIncidencia,
               "status" => $status,
               "fechaCreado" => $fechaCreado,
               "fechaFinalizado" => $fechaFinalizado,
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "idSeccion" => $idSeccion,
               "seccion" => $seccion,
               "idSubseccion" => $idSubseccion,
               "subseccion" => $subseccion,
               "idEquipo" => $idEquipo,
               "equipo" => $equipo,
               "creadoPor" => $creadoPor,
               "arrayCreadoPor" => Usuarios::getById($creadoPor),
               "responsable" => $responsable,
               "arrayResponsable" => Usuarios::getById($responsable),
               "activo" => $activo
            );
      }
      return $array;
   }


   public static function mpProgramados($idDestinoX, $idEquipo, $idTipoEquipo, $idSeccion = 0, $idSubseccion = 0)
   {
      // MP PROGRAMADOS
      $conexion = new Conexion();
      $conexion->conectar();

      #FILTRO SECCIÓN
      if ($idSeccion === 0)
         $filtroSeccion = "";
      else
         $filtroSeccion = "and e.id_seccion = $idSeccion";

      #FILTRO SUBSECCIÓN
      if ($idSubseccion === 0)
         $filtroSubseccion = "";
      else
         $filtroSubseccion = "and e.id_seccion = $idSubseccion";

      #PLANES PARA EL EQUIPO
      $query = "SELECT
      count(id) 'total'
      FROM t_mp_planes_mantenimiento
      WHERE id_destino = ? and tipo_local_equipo = ? and status = 'ACTIVO' and activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("ii", $idDestinoX, $idTipoEquipo);
      $prepare->execute();
      $response = $prepare->get_result();

      $totalPlanes = 0;

      foreach ($response as $x)
         $totalPlanes = $x['total'];

      #PLANIFICADOS
      $query = "SELECT
      count(id) 'total'
      FROM t_mp_planeacion_semana
      WHERE id_equipo = ? and activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idEquipo);
      $prepare->execute();
      $response = $prepare->get_result();

      $totalPlanificaciones = 0;

      foreach ($response as $x)
         $totalPlanificaciones = $x['total'];

      if ($totalPlanes > 0) {
         $porcentajePlanificado = (100 / $totalPlanes) * $totalPlanificaciones;
         $conPlanes = true;
      } else {
         $porcentajePlanificado = 0;
         $conPlanes = false;
      }

      return array(
         "totalPlanes" => $totalPlanes,
         "totalPlanificaciones" => $totalPlanificaciones,
         "conPlanes" => $conPlanes,
         "porcentajePlanificado" => $porcentajePlanificado,
      );
   }


   // OBTIENE PLANEACION CON FILTRO DE IDEQUIPO, SECCIÓN, SUBSECCIÓN
   public static function mpPlanificaciones(
      $idDestino,
      $idEquipo,
      $idSeccion = 0,
      $idSubseccion = 0,
      $fechaInicio,
      $fechaFin
   ) {

      // MP PROGRAMADOS
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      #FILTRO SECCIÓN
      if ($idSeccion == 0)
         $filtroSeccion = "";
      else
         $filtroSeccion = "and e.id_seccion = $idSeccion";

      #FILTRO SUBSECCIÓN
      if ($idSubseccion == 0)
         $filtroSubseccion = "";
      else
         $filtroSubseccion = "and e.id_subseccion = $idSubseccion";

      #FILTRO EQUIPO
      if ($idEquipo == 0)
         $filtroEquipo = "";
      else {
         $filtroEquipo = "and e.id = $idEquipo";
         $filtroSeccion = "";
         $filtroSubseccion = "";
      }

      #FECHAS
      $fechaI = new DateTime($fechaInicio);
      $fechaF = new DateTime($fechaFin);
      $semanaI = (int) $fechaI->format("W");
      $semanaF = (int) $fechaF->format("W");
      $semanas = array(0);

      if ($semanaI > 52)
         $semanaI = 1;

      if ($fechaI->format("Y-m-d") == '2022-01-01' || $fechaI->format("Y-m-d") == '2022-01-02' || $fechaI->format("Y-m-d") == '2022-01-03' || $fechaI->format("Y-m-d") == '2023-01-01' || $fechaI->format("Y-m-d") == '2023-01-02' || $fechaI->format("Y-m-d") == '2023-01-03')
         $semanaI = 1;

      if ($semanaI <= $semanaF) {
         for ($i = $semanaI; $i <= $semanaF; $i++) {
            $semanas[] = intval($i);
         }
      }

      #PLANES PARA EL EQUIPO
      $query = "SELECT 
      e.id 'idEquipo', e.equipo, mp.id 'idPlan', sem.id 'idPlaneacion', frecuencia.saltos,
      sem.semana_1, sem.semana_2, sem.semana_3, sem.semana_4, sem.semana_5, sem.semana_6, sem.semana_7, sem.semana_8, sem.semana_9, sem.semana_10, sem.semana_11, sem.semana_12, sem.semana_13, sem.semana_14, sem.semana_15, sem.semana_16, sem.semana_17, sem.semana_18, sem.semana_19, sem.semana_20, sem.semana_21, sem.semana_22, sem.semana_23, sem.semana_24, sem.semana_25, sem.semana_26, sem.semana_27, sem.semana_28, sem.semana_29, sem.semana_30, sem.semana_31, sem.semana_32, sem.semana_33, sem.semana_34, sem.semana_35, sem.semana_36, sem.semana_37, sem.semana_38, sem.semana_39, sem.semana_40, sem.semana_41, sem.semana_42, sem.semana_43, sem.semana_44, sem.semana_45, sem.semana_46, sem.semana_47, sem.semana_48, sem.semana_49, sem.semana_50, sem.semana_51, sem.semana_52
      FROM t_equipos_america AS e
      INNER JOIN t_mp_planeacion_semana AS sem ON e.id = sem.id_equipo
      INNER JOIN t_mp_planes_mantenimiento AS mp ON sem.id_plan = mp.id
      INNER JOIN c_frecuencias_mp AS frecuencia ON mp.id_periodicidad = frecuencia.id
      WHERE  e.id_destino = $idDestino and e.status NOT IN('BAJA', 'ELIMINADO') and e.activo = 1 and e.local_equipo = 'EQUIPO' 
      and mp.status = 'ACTIVO' and mp.activo = 1 and sem.activo = 1
      $filtroEquipo $filtroSeccion $filtroSubseccion";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->execute();
      $response = $prepare->get_result();

      $planificaciones = array();
      $totalConPlanificacionesGlobal = 0;
      $totalSinPlanificacionesGlobal = 0;
      $totalPlanificacionesGlobal = 0;
      $totalSemanasPlanificadasGlobal = 0;
      $totalPlanificadosCompletosGlobal = 0;
      $totalPlanificadosIncompletosGlobal = 0;

      foreach ($response as $x) {
         $saltos = $x['saltos'];

         $totalPlanificadosCompletos = 0;
         $totalPlanificadosIncompletos = 0;
         $totalConPlanificaciones = 0;
         $totalPlanificaciones = 0;
         $totalSinPlanificaciones = 0;
         $totalSemanasPlanificadas = 0;

         $semana_1 = $x['semana_1'];
         if ($semana_1 === 'PLANIFICADO' && in_array(1, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_2 = $x['semana_2'];
         if ($semana_2 === 'PLANIFICADO' && in_array(2, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_3 = $x['semana_3'];
         if ($semana_3 === 'PLANIFICADO' && in_array(3, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_4 = $x['semana_4'];
         if ($semana_4 === 'PLANIFICADO' && in_array(4, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_5 = $x['semana_5'];
         if ($semana_5 === 'PLANIFICADO' && in_array(5, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_6 = $x['semana_6'];
         if ($semana_6 === 'PLANIFICADO' && in_array(6, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_7 = $x['semana_7'];
         if ($semana_7 === 'PLANIFICADO' && in_array(7, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_8 = $x['semana_8'];
         if ($semana_8 === 'PLANIFICADO' && in_array(8, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_9 = $x['semana_9'];
         if ($semana_9 === 'PLANIFICADO' && in_array(9, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_10 = $x['semana_10'];
         if ($semana_10 === 'PLANIFICADO' && in_array(10, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_11 = $x['semana_11'];
         if ($semana_11 === 'PLANIFICADO' && in_array(11, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_12 = $x['semana_12'];
         if ($semana_12 === 'PLANIFICADO' && in_array(12, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_13 = $x['semana_13'];
         if ($semana_13 === 'PLANIFICADO' && in_array(13, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_14 = $x['semana_14'];
         if ($semana_14 === 'PLANIFICADO' && in_array(14, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_15 = $x['semana_15'];
         if ($semana_15 === 'PLANIFICADO' && in_array(15, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_16 = $x['semana_16'];
         if ($semana_16 === 'PLANIFICADO' && in_array(16, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_17 = $x['semana_17'];
         if ($semana_17 === 'PLANIFICADO' && in_array(17, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_18 = $x['semana_18'];
         if ($semana_18 === 'PLANIFICADO' && in_array(18, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_19 = $x['semana_19'];
         if ($semana_19 === 'PLANIFICADO' && in_array(19, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_20 = $x['semana_20'];
         if ($semana_20 === 'PLANIFICADO' && in_array(20, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_21 = $x['semana_21'];
         if ($semana_21 === 'PLANIFICADO' && in_array(21, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_22 = $x['semana_22'];
         if ($semana_22 === 'PLANIFICADO' && in_array(22, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_23 = $x['semana_23'];
         if ($semana_23 === 'PLANIFICADO' && in_array(23, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_24 = $x['semana_24'];
         if ($semana_24 === 'PLANIFICADO' && in_array(24, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_25 = $x['semana_25'];
         if ($semana_25 === 'PLANIFICADO' && in_array(25, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_26 = $x['semana_26'];
         if ($semana_26 === 'PLANIFICADO' && in_array(26, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_27 = $x['semana_27'];
         if ($semana_27 === 'PLANIFICADO' && in_array(27, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_28 = $x['semana_28'];
         if ($semana_28 === 'PLANIFICADO' && in_array(28, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_29 = $x['semana_29'];
         if ($semana_29 === 'PLANIFICADO' && in_array(29, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_30 = $x['semana_30'];
         if ($semana_30 === 'PLANIFICADO' && in_array(30, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_31 = $x['semana_31'];
         if ($semana_31 === 'PLANIFICADO' && in_array(31, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_32 = $x['semana_32'];
         if ($semana_32 === 'PLANIFICADO' && in_array(32, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_33 = $x['semana_33'];
         if ($semana_33 === 'PLANIFICADO' && in_array(33, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_34 = $x['semana_34'];
         if ($semana_34 === 'PLANIFICADO' && in_array(34, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_35 = $x['semana_35'];
         if ($semana_35 === 'PLANIFICADO' && in_array(35, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_36 = $x['semana_36'];
         if ($semana_36 === 'PLANIFICADO' && in_array(36, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_37 = $x['semana_37'];
         if ($semana_37 === 'PLANIFICADO' && in_array(37, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_38 = $x['semana_38'];
         if ($semana_38 === 'PLANIFICADO' && in_array(38, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_39 = $x['semana_39'];
         if ($semana_39 === 'PLANIFICADO' && in_array(39, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_40 = $x['semana_40'];
         if ($semana_40 === 'PLANIFICADO' && in_array(40, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_41 = $x['semana_41'];
         if ($semana_41 === 'PLANIFICADO' && in_array(41, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_42 = $x['semana_42'];
         if ($semana_42 === 'PLANIFICADO' && in_array(42, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_43 = $x['semana_43'];
         if ($semana_43 === 'PLANIFICADO' && in_array(43, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_44 = $x['semana_44'];
         if ($semana_44 === 'PLANIFICADO' && in_array(44, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_45 = $x['semana_45'];
         if ($semana_45 === 'PLANIFICADO' && in_array(45, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_46 = $x['semana_46'];
         if ($semana_46 === 'PLANIFICADO' && in_array(46, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_47 = $x['semana_47'];
         if ($semana_47 === 'PLANIFICADO' && in_array(47, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_48 = $x['semana_48'];
         if ($semana_48 === 'PLANIFICADO' && in_array(48, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_49 = $x['semana_49'];
         if ($semana_49 === 'PLANIFICADO' && in_array(49, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_50 = $x['semana_50'];
         if ($semana_50 === 'PLANIFICADO' && in_array(50, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_51 = $x['semana_51'];
         if ($semana_51 === 'PLANIFICADO' && in_array(51, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_52 = $x['semana_52'];
         if ($semana_52 === 'PLANIFICADO' && in_array(52, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         #CON PLANIFICACION
         if ($totalSemanasPlanificadas > 0) {
            $totalConPlanificaciones++;

            #PLANIFICACIONES COMPLETAS
            if ($totalSemanasPlanificadas >= $saltos)
               $totalPlanificadosCompletos++;

            #PLANIFICACIONES INCOMPLETAS
            if ($totalSemanasPlanificadas < $saltos && $totalSemanasPlanificadas > 0)
               $totalPlanificadosIncompletos++;
         }

         #SIN PLANIFICACION
         if ($totalSemanasPlanificadas == 0)
            $totalSinPlanificaciones++;

         #TOTAL PLANIFIACIONES
         $totalPlanificaciones++;

         $x['totalConPlanificaciones'] = $totalConPlanificaciones;
         $totalConPlanificacionesGlobal += $totalConPlanificaciones;

         $x['totalSinPlanificaciones'] = $totalSinPlanificaciones;
         $totalSinPlanificacionesGlobal += $totalSinPlanificaciones;

         $x['totalPlanificaciones'] = $totalPlanificaciones;
         $totalPlanificacionesGlobal += $totalPlanificaciones;

         $x['totalSemanasPlanificadas'] = $totalSemanasPlanificadas;
         $totalSemanasPlanificadasGlobal += $totalSemanasPlanificadas;

         $x['totalPlanificadosCompletos'] = $totalPlanificadosCompletos;
         $totalPlanificadosCompletosGlobal += $totalPlanificadosCompletos;

         $x['totalPlanificadosIncompletos'] = $totalPlanificadosIncompletos;
         $totalPlanificadosIncompletosGlobal += $totalPlanificadosIncompletos;

         #PLANIFICACIONES ARRAY
         $planificaciones[] = $x;
      }

      #DATA ARRAY
      $array = array(
         "planificaciones" => $planificaciones,
         "totalConPlanificacionesGlobal" => $totalConPlanificacionesGlobal,
         "totalSinPlanificacionesGlobal" => $totalSinPlanificacionesGlobal,
         "totalPlanificacionesGlobal" => $totalPlanificacionesGlobal,
         "totalSemanasPlanificadasGlobal" => $totalSemanasPlanificadasGlobal,
         "totalPlanificadosCompletosGlobal" => $totalPlanificadosCompletosGlobal,
         "totalPlanificadosIncompletosGlobal" => $totalPlanificadosIncompletosGlobal,
      );

      return $array;
   }



   // OBTIENE PLANEACION CON FILTRO DE IDEQUIPO, SECCIÓN, SUBSECCIÓN
   public static function mpPlanificacionesEquipos(
      $idDestino,
      $idEquipo,
      $idSeccion = 0,
      $idSubseccion = 0,
      $fechaInicio,
      $fechaFin
   ) {

      // MP PROGRAMADOS
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      #FILTRO SECCIÓN
      if ($idSeccion == 0)
         $filtroSeccion = "";
      else
         $filtroSeccion = "and e.id_seccion = $idSeccion";

      #FILTRO SUBSECCIÓN
      if ($idSubseccion == 0)
         $filtroSubseccion = "";
      else
         $filtroSubseccion = "and e.id_subseccion = $idSubseccion";

      #FILTRO EQUIPO
      if ($idEquipo == 0)
         $filtroEquipo = "";
      else {
         $filtroEquipo = "and e.id = $idEquipo";
         $filtroSeccion = "";
         $filtroSubseccion = "";
      }

      #FECHAS
      $fechaI = new DateTime($fechaInicio);
      $fechaF = new DateTime($fechaFin);
      $semanaI = (int) $fechaI->format("W");
      $semanaF = (int) $fechaF->format("W");
      $semanas = array(0);

      if ($semanaI > 52)
         $semanaI = 1;

      if ($semanaI <= $semanaF) {
         for ($i = $semanaI; $i <= $semanaF; $i++) {
            $semanas[] = intval($i);
         }
      }

      #PLANES PARA EL EQUIPO
      $query = "SELECT 
      e.id 'idEquipo', e.equipo, mp.id 'idPlan', sem.id 'idPlaneacion', frecuencia.saltos,
      sem.semana_1, sem.semana_2, sem.semana_3, sem.semana_4, sem.semana_5, sem.semana_6, sem.semana_7, sem.semana_8, sem.semana_9, sem.semana_10, sem.semana_11, sem.semana_12, sem.semana_13, sem.semana_14, sem.semana_15, sem.semana_16, sem.semana_17, sem.semana_18, sem.semana_19, sem.semana_20, sem.semana_21, sem.semana_22, sem.semana_23, sem.semana_24, sem.semana_25, sem.semana_26, sem.semana_27, sem.semana_28, sem.semana_29, sem.semana_30, sem.semana_31, sem.semana_32, sem.semana_33, sem.semana_34, sem.semana_35, sem.semana_36, sem.semana_37, sem.semana_38, sem.semana_39, sem.semana_40, sem.semana_41, sem.semana_42, sem.semana_43, sem.semana_44, sem.semana_45, sem.semana_46, sem.semana_47, sem.semana_48, sem.semana_49, sem.semana_50, sem.semana_51, sem.semana_52
      FROM t_equipos_america AS e
      INNER JOIN t_mp_planeacion_semana AS sem ON e.id = sem.id_equipo
      INNER JOIN t_mp_planes_mantenimiento AS mp ON sem.id_plan = mp.id
      INNER JOIN c_frecuencias_mp AS frecuencia ON mp.id_periodicidad = frecuencia.id
      WHERE  e.id_destino = $idDestino and e.status NOT IN('BAJA', 'ELIMINADO') and e.activo = 1 and e.local_equipo = 'EQUIPO' 
      and mp.status = 'ACTIVO' and mp.activo = 1 and sem.activo = 1
      $filtroEquipo $filtroSeccion $filtroSubseccion";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->execute();
      $response = $prepare->get_result();

      $planificaciones = array();
      $totalConPlanificacionesGlobal = 0;
      $totalSinPlanificacionesGlobal = 0;
      $totalPlanificacionesGlobal = 0;
      $totalSemanasPlanificadasGlobal = 0;
      $totalPlanificadosCompletosGlobal = 0;
      $totalPlanificadosIncompletosGlobal = 0;

      foreach ($response as $x) {
         $idEquipo = $x['idEquipo'];
         $saltos = $x['saltos'];

         $totalPlanificadosCompletos = 0;
         $totalPlanificadosIncompletos = 0;
         $totalConPlanificaciones = 0;
         $totalPlanificaciones = 0;
         $totalSinPlanificaciones = 0;
         $totalSemanasPlanificadas = 0;

         $semana_1 = $x['semana_1'];
         if ($semana_1 === 'PLANIFICADO' && in_array(1, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_2 = $x['semana_2'];
         if ($semana_2 === 'PLANIFICADO' && in_array(2, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_3 = $x['semana_3'];
         if ($semana_3 === 'PLANIFICADO' && in_array(3, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_4 = $x['semana_4'];
         if ($semana_4 === 'PLANIFICADO' && in_array(4, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_5 = $x['semana_5'];
         if ($semana_5 === 'PLANIFICADO' && in_array(5, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_6 = $x['semana_6'];
         if ($semana_6 === 'PLANIFICADO' && in_array(6, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_7 = $x['semana_7'];
         if ($semana_7 === 'PLANIFICADO' && in_array(7, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_8 = $x['semana_8'];
         if ($semana_8 === 'PLANIFICADO' && in_array(8, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_9 = $x['semana_9'];
         if ($semana_9 === 'PLANIFICADO' && in_array(9, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_10 = $x['semana_10'];
         if ($semana_10 === 'PLANIFICADO' && in_array(10, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_11 = $x['semana_11'];
         if ($semana_11 === 'PLANIFICADO' && in_array(11, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_12 = $x['semana_12'];
         if ($semana_12 === 'PLANIFICADO' && in_array(12, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_13 = $x['semana_13'];
         if ($semana_13 === 'PLANIFICADO' && in_array(13, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_14 = $x['semana_14'];
         if ($semana_14 === 'PLANIFICADO' && in_array(14, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_15 = $x['semana_15'];
         if ($semana_15 === 'PLANIFICADO' && in_array(15, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_16 = $x['semana_16'];
         if ($semana_16 === 'PLANIFICADO' && in_array(16, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_17 = $x['semana_17'];
         if ($semana_17 === 'PLANIFICADO' && in_array(17, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_18 = $x['semana_18'];
         if ($semana_18 === 'PLANIFICADO' && in_array(18, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_19 = $x['semana_19'];
         if ($semana_19 === 'PLANIFICADO' && in_array(19, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_20 = $x['semana_20'];
         if ($semana_20 === 'PLANIFICADO' && in_array(20, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_21 = $x['semana_21'];
         if ($semana_21 === 'PLANIFICADO' && in_array(21, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_22 = $x['semana_22'];
         if ($semana_22 === 'PLANIFICADO' && in_array(22, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_23 = $x['semana_23'];
         if ($semana_23 === 'PLANIFICADO' && in_array(23, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_24 = $x['semana_24'];
         if ($semana_24 === 'PLANIFICADO' && in_array(24, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_25 = $x['semana_25'];
         if ($semana_25 === 'PLANIFICADO' && in_array(25, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_26 = $x['semana_26'];
         if ($semana_26 === 'PLANIFICADO' && in_array(26, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_27 = $x['semana_27'];
         if ($semana_27 === 'PLANIFICADO' && in_array(27, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_28 = $x['semana_28'];
         if ($semana_28 === 'PLANIFICADO' && in_array(28, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_29 = $x['semana_29'];
         if ($semana_29 === 'PLANIFICADO' && in_array(29, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_30 = $x['semana_30'];
         if ($semana_30 === 'PLANIFICADO' && in_array(30, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_31 = $x['semana_31'];
         if ($semana_31 === 'PLANIFICADO' && in_array(31, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_32 = $x['semana_32'];
         if ($semana_32 === 'PLANIFICADO' && in_array(32, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_33 = $x['semana_33'];
         if ($semana_33 === 'PLANIFICADO' && in_array(33, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_34 = $x['semana_34'];
         if ($semana_34 === 'PLANIFICADO' && in_array(34, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_35 = $x['semana_35'];
         if ($semana_35 === 'PLANIFICADO' && in_array(35, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_36 = $x['semana_36'];
         if ($semana_36 === 'PLANIFICADO' && in_array(36, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_37 = $x['semana_37'];
         if ($semana_37 === 'PLANIFICADO' && in_array(37, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_38 = $x['semana_38'];
         if ($semana_38 === 'PLANIFICADO' && in_array(38, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_39 = $x['semana_39'];
         if ($semana_39 === 'PLANIFICADO' && in_array(39, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_40 = $x['semana_40'];
         if ($semana_40 === 'PLANIFICADO' && in_array(40, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_41 = $x['semana_41'];
         if ($semana_41 === 'PLANIFICADO' && in_array(41, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_42 = $x['semana_42'];
         if ($semana_42 === 'PLANIFICADO' && in_array(42, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_43 = $x['semana_43'];
         if ($semana_43 === 'PLANIFICADO' && in_array(43, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_44 = $x['semana_44'];
         if ($semana_44 === 'PLANIFICADO' && in_array(44, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_45 = $x['semana_45'];
         if ($semana_45 === 'PLANIFICADO' && in_array(45, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_46 = $x['semana_46'];
         if ($semana_46 === 'PLANIFICADO' && in_array(46, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_47 = $x['semana_47'];
         if ($semana_47 === 'PLANIFICADO' && in_array(47, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_48 = $x['semana_48'];
         if ($semana_48 === 'PLANIFICADO' && in_array(48, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_49 = $x['semana_49'];
         if ($semana_49 === 'PLANIFICADO' && in_array(49, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_50 = $x['semana_50'];
         if ($semana_50 === 'PLANIFICADO' && in_array(50, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_51 = $x['semana_51'];
         if ($semana_51 === 'PLANIFICADO' && in_array(51, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         $semana_52 = $x['semana_52'];
         if ($semana_52 === 'PLANIFICADO' && in_array(52, $semanas)) {
            $totalSemanasPlanificadas++;
         }

         #CON PLANIFICACION
         if ($totalSemanasPlanificadas > 0) {
            $totalConPlanificaciones++;

            #PLANIFICACIONES COMPLETAS
            if ($totalSemanasPlanificadas >= $saltos)
               $totalPlanificadosCompletos++;

            #PLANIFICACIONES INCOMPLETAS
            if ($totalSemanasPlanificadas < $saltos && $totalSemanasPlanificadas > 0)
               $totalPlanificadosIncompletos++;
         }

         #SIN PLANIFICACION
         if ($totalSemanasPlanificadas == 0)
            $totalSinPlanificaciones++;

         #TOTAL PLANIFIACIONES
         $totalPlanificaciones++;

         $x['totalConPlanificaciones'] = $totalConPlanificaciones;
         $totalConPlanificacionesGlobal += $totalConPlanificaciones;

         $x['totalSinPlanificaciones'] = $totalSinPlanificaciones;
         $totalSinPlanificacionesGlobal += $totalSinPlanificaciones;

         $x['totalPlanificaciones'] = $totalPlanificaciones;
         $totalPlanificacionesGlobal += $totalPlanificaciones;

         $x['totalSemanasPlanificadas'] = $totalSemanasPlanificadas;
         $totalSemanasPlanificadasGlobal += $totalSemanasPlanificadas;

         $x['totalPlanificadosCompletos'] = $totalPlanificadosCompletos;
         $totalPlanificadosCompletosGlobal += $totalPlanificadosCompletos;

         $x['totalPlanificadosIncompletos'] = $totalPlanificadosIncompletos;
         $totalPlanificadosIncompletosGlobal += $totalPlanificadosIncompletos;

         $x['totalSaltos'] = $saltos;
         $x['semanas'] = $semanas;

         #PLANIFICACIONES ARRAY
         $array[$idEquipo][] = $x;
      }

      #DATA ARRAY
      // $array = array(
      //    "planificaciones" => $planificaciones,
      //    "totalConPlanificacionesGlobal" => $totalConPlanificacionesGlobal,
      //    "totalSinPlanificacionesGlobal" => $totalSinPlanificacionesGlobal,
      //    "totalPlanificacionesGlobal" => $totalPlanificacionesGlobal,
      //    "totalSemanasPlanificadasGlobal" => $totalSemanasPlanificadasGlobal,
      //    "totalPlanificadosCompletosGlobal" => $totalPlanificadosCompletosGlobal,
      //    "totalPlanificadosIncompletosGlobal" => $totalPlanificadosIncompletosGlobal,
      // );

      return $array;
   }


   public static function mpEquipo($idEquipo)
   {
      // MP PROGRAMADOS
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      #PLANES PARA EL EQUIPO
      $query = "SELECT *
      FROM t_mp_planeacion_semana
      WHERE id_equipo = ? and activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idEquipo);
      $prepare->execute();
      $response = $prepare->get_result();
      foreach ($response as $x)
         $array[] = $x;

      return $array;
   }
}