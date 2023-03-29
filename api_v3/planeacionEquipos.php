<?php

class PlaneacionEquipos extends Conexion
{

  public static function all($post)
  {
    $conexion = new Conexion();
    $conexion->conectar();

    $idDestino = $post['idDestino'];
    $año = $post['año'];

    $query = "SELECT
    d.ubicacion,
    e.id idEquipo,
    e.equipo,
    e.status,
    sec.id idSeccion,
    sec.seccion,
    sub.id idSubseccion,
    sub.grupo subseccion,
    pm.id idPlan,
    fmp.frecuencia,
    pm.grado,
    pm.tipo_plan,
    pp.semana_1,
    pp.semana_2,
    pp.semana_3,
    pp.semana_4,
    pp.semana_5,
    pp.semana_6,
    pp.semana_7,
    pp.semana_8,
    pp.semana_9,
    pp.semana_10,
    pp.semana_11,
    pp.semana_12,
    pp.semana_13,
    pp.semana_14,
    pp.semana_15,
    pp.semana_16,
    pp.semana_17,
    pp.semana_18,
    pp.semana_19,
    pp.semana_20,
    pp.semana_21,
    pp.semana_22,
    pp.semana_23,
    pp.semana_24,
    pp.semana_25,
    pp.semana_26,
    pp.semana_27,
    pp.semana_28,
    pp.semana_29,
    pp.semana_30,
    pp.semana_31,
    pp.semana_32,
    pp.semana_33,
    pp.semana_34,
    pp.semana_35,
    pp.semana_36,
    pp.semana_37,
    pp.semana_38,
    pp.semana_39,
    pp.semana_40,
    pp.semana_41,
    pp.semana_42,
    pp.semana_43,
    pp.semana_44,
    pp.semana_45,
    pp.semana_46,
    pp.semana_47,
    pp.semana_48,
    pp.semana_49,
    pp.semana_50,
    pp.semana_51,
    pp.semana_52
    FROM t_equipos_america AS e
    INNER JOIN c_destinos AS d ON d.id = e.id_destino
    INNER JOIN c_secciones AS sec ON sec.id = e.id_seccion
    INNER JOIN c_subsecciones AS sub ON sub.id = e.id_subseccion
    INNER JOIN t_mp_planeacion_proceso AS pp ON pp.id_equipo = e.id
    INNER JOIN t_mp_planes_mantenimiento AS pm ON pm.id = pp.id_plan
    INNER JOIN c_frecuencias_mp AS fmp ON fmp.id = pm.id_periodicidad
    WHERE e.activo = 1 AND pp.activo = 1 AND pp.año = ? AND e.id_destino = ?
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

      #SEMANAS
      $planeacion = array();
      for ($i = 1; $i < 53; $i++) {
        $planeacion[] = array(
          "semana_" . $i => $x['semana_' . $i]
        );
        unset($x['semana_' . $i]);
      }

      $array[$x['idEquipo']][0] = $x;

      #INFORMACIÓN DE PLAN
      $array[$x['idEquipo']]['planes'][] = array(
        "idPlan" => $idPlan,
        "tipoPlan" => $tipoPlan,
        "frecuencia" => $frecuencia,
        "grado" => $grado,
        "planeacion" => $planeacion
      );
    }

    foreach ($array as $x) {
      $arrayTemp[] =
        array(
          "destino" => $x[0]['ubicacion'],
          "idEquipo" => $x[0]['idEquipo'],
          "equipo" => $x[0]['equipo'],
          "idSeccion" => $x[0]['idSeccion'],
          "seccion" => $x[0]['seccion'],
          "idSubseccion" => $x[0]['idSubseccion'],
          "subseccion" => $x[0]['subseccion'],
          "totalPlanes" => count($x['planes']),
          "planes" => $x['planes'],

        );
    }
    return $arrayTemp;
  }
}