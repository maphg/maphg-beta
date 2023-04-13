<?php

class PlaneacionEquipos extends Conexion
{

  public static function all($post)
  {
    $conexion = new Conexion();
    $conexion->conectar();

    $idDestino = $post['idDestino'];
    $año = $post['año'];
    $idSeccion = intval($post['idSeccion']);
    $idSubseccion = intval($post['idSubseccion']);

    $filtroSeccion = "";
    $filtroSubseccion = "";

    if ($idSeccion > 0)
      $filtroSeccion = "AND e.id_seccion = $idSeccion";

    if ($idSubseccion > 0)
      $filtroSubseccion = "AND e.id_subseccion = $idSubseccion";

    $query = "
    SELECT
    e.id idEquipo,
    e.equipo,
    ps.id idPlanSemanas,
    ps.id idPlanProceso,
    e.status,
    d.id idDestino,
    d.destino,
    d.ubicacion nombreDestino,
    sec.id idSeccion,
    sec.seccion,
    sub.id idSubseccion,
    sub.grupo subseccion,
    pm.id idPlan,
    fmp.frecuencia,
    pm.grado,
    pm.tipo_plan,
    t.tipo,
    pp.semana_1 pp_1,
    pp.semana_2 pp_2,
    pp.semana_3 pp_3,
    pp.semana_4 pp_4,
    pp.semana_5 pp_5,
    pp.semana_6 pp_6,
    pp.semana_7 pp_7,
    pp.semana_8 pp_8,
    pp.semana_9 pp_9,
    pp.semana_10 pp_10,
    pp.semana_11 pp_11,
    pp.semana_12 pp_12,
    pp.semana_13 pp_13,
    pp.semana_14 pp_14,
    pp.semana_15 pp_15,
    pp.semana_16 pp_16,
    pp.semana_17 pp_17,
    pp.semana_18 pp_18,
    pp.semana_19 pp_19,
    pp.semana_20 pp_20,
    pp.semana_21 pp_21,
    pp.semana_22 pp_22,
    pp.semana_23 pp_23,
    pp.semana_24 pp_24,
    pp.semana_25 pp_25,
    pp.semana_26 pp_26,
    pp.semana_27 pp_27,
    pp.semana_28 pp_28,
    pp.semana_29 pp_29,
    pp.semana_30 pp_30,
    pp.semana_31 pp_31,
    pp.semana_32 pp_32,
    pp.semana_33 pp_33,
    pp.semana_34 pp_34,
    pp.semana_35 pp_35,
    pp.semana_36 pp_36,
    pp.semana_37 pp_37,
    pp.semana_38 pp_38,
    pp.semana_39 pp_39,
    pp.semana_40 pp_40,
    pp.semana_41 pp_41,
    pp.semana_42 pp_42,
    pp.semana_43 pp_43,
    pp.semana_44 pp_44,
    pp.semana_45 pp_45,
    pp.semana_46 pp_46,
    pp.semana_47 pp_47,
    pp.semana_48 pp_48,
    pp.semana_49 pp_49,
    pp.semana_50 pp_50,
    pp.semana_51 pp_51,
    pp.semana_52 pp_52,
    ps.semana_1 ps_1,
    ps.semana_2 ps_2,
    ps.semana_3 ps_3,
    ps.semana_4 ps_4,
    ps.semana_5 ps_5,
    ps.semana_6 ps_6,
    ps.semana_7 ps_7,
    ps.semana_8 ps_8,
    ps.semana_9 ps_9,
    ps.semana_10 ps_10,
    ps.semana_11 ps_11,
    ps.semana_12 ps_12,
    ps.semana_13 ps_13,
    ps.semana_14 ps_14,
    ps.semana_15 ps_15,
    ps.semana_16 ps_16,
    ps.semana_17 ps_17,
    ps.semana_18 ps_18,
    ps.semana_19 ps_19,
    ps.semana_20 ps_20,
    ps.semana_21 ps_21,
    ps.semana_22 ps_22,
    ps.semana_23 ps_23,
    ps.semana_24 ps_24,
    ps.semana_25 ps_25,
    ps.semana_26 ps_26,
    ps.semana_27 ps_27,
    ps.semana_28 ps_28,
    ps.semana_29 ps_29,
    ps.semana_30 ps_30,
    ps.semana_31 ps_31,
    ps.semana_32 ps_32,
    ps.semana_33 ps_33,
    ps.semana_34 ps_34,
    ps.semana_35 ps_35,
    ps.semana_36 ps_36,
    ps.semana_37 ps_37,
    ps.semana_38 ps_38,
    ps.semana_39 ps_39,
    ps.semana_40 ps_40,
    ps.semana_41 ps_41,
    ps.semana_42 ps_42,
    ps.semana_43 ps_43,
    ps.semana_44 ps_44,
    ps.semana_45 ps_45,
    ps.semana_46 ps_46,
    ps.semana_47 ps_47,
    ps.semana_48 ps_48,
    ps.semana_49 ps_49,
    ps.semana_50 ps_50,
    ps.semana_51 ps_51,
    ps.semana_52 ps_52
    FROM t_equipos_america AS e
    INNER JOIN t_mp_planeacion_semana AS ps ON ps.id_equipo = e.id
    INNER JOIN t_mp_planeacion_proceso AS pp ON pp.id_equipo = e.id AND pp.id_plan = ps.id_plan
    INNER JOIN c_destinos AS d ON d.id = e.id_destino
    INNER JOIN c_secciones AS sec ON sec.id = e.id_seccion
    INNER JOIN c_subsecciones AS sub ON sub.id = e.id_subseccion
    INNER JOIN t_mp_planes_mantenimiento AS pm ON pm.id = pp.id_plan
    INNER JOIN c_frecuencias_mp AS fmp ON fmp.id = pm.id_periodicidad
    INNER JOIN c_tipos AS t ON t.id = e.id_tipo
    WHERE e.activo = 1 AND pp.activo = 1 AND pp.año = ? AND e.id_destino = ? $filtroSeccion $filtroSubseccion
    ORDER BY pp.ultima_modificacion ASC LIMIT 6000";
    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->bind_param("si", $año, $idDestino);
    $prepare->execute();
    $response = $prepare->get_result();
    $array = array();
    $arrayTemp = array();

    foreach ($response as $x) {

      // ELIMINAR VARIAS REPETIDAS
      $tipoPlan = $x['tipo_plan'];
      $frecuencia = $x['frecuencia'];
      $grado = $x['grado'];
      $idPlan = $x['idPlan'];

      unset($x['tipo_plan']);
      unset($x['frecuencia']);
      unset($x['grado']);
      unset($x['idPlan']);


      #DEFINICIONES
      # 0 = NADA
      # 1 = PLANIFICADO
      # 2 = SOLUCIONADO
      # 3 = EN PROCESO
      # 4 = PLANIFICADO Y SOLUCIONADO
      # 5 = PLANIFICADO y EN PROCESO

      #SEMANAS
      $planeacion = array();
      for ($i = 1; $i < 53; $i++) {

        $valor = 0;

        if ($x["ps_" . $i] == "PLANIFICADO") $valor = 1;

        if ($x["pp_" . $i] == "SOLUCIONADO") $valor = 2;

        if ($x["pp_" . $i] == "PROCESO") $valor = 3;

        if ($x["ps_" . $i] == "PLANIFICADO" && $x["pp_" . $i] == "SOLUCIONADO")
          $valor = 4;

        if ($x["ps_" . $i] == "PLANIFICADO" && $x["pp_" . $i] == "PROCESO")
          $valor = 5;

        $planeacion[] = $valor;

        unset($x['ps_' . $i]);
        unset($x['pp_' . $i]);
      }

      $array[$x['idEquipo']][0] = $x;

      #INFORMACIÓN DE PLAN
      $array[$x['idEquipo']]['planes'][] = array(
        "idPlan" => $idPlan,
        "tipoPlan" => $tipoPlan,
        "frecuencia" => $frecuencia,
        "grado" => $grado,
        "planeacion" => $planeacion,
      );
    }

    foreach ($array as $x) {
      $arrayTemp[] =
        array(
          "destino" => $x[0]['destino'],
          "nombreDestino" => $x[0]['nombreDestino'],
          "idEquipo" => $x[0]['idEquipo'],
          "equipo" => $x[0]['equipo'],
          "idSeccion" => $x[0]['idSeccion'],
          "seccion" => $x[0]['seccion'],
          "idSubseccion" => $x[0]['idSubseccion'],
          "subseccion" => $x[0]['subseccion'],
          "totalPlanes" => count($x['planes']),
          "status" => $x['status'],
          "planes" => $x['planes'],

        );
    }
    return $arrayTemp;
  }
}
