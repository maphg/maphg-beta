<?php

class PlaneacionEquipos extends Conexion
{

  public static function all($post)
  {
    $conexion = new Conexion();
    $conexion->conectar();

    // $idDestino = $post['idDestino'];
    // $año = $post['año'];

    $query = "SELECT e.id idEquipo, e.equipo, e.status, sec.id idSeccion, sec.seccion, sub.id idSubseccion, sub.grupo subseccion, pp.*
    FROM t_equipos_america AS e
    INNER JOIN c_secciones AS sec ON sec.id = e.id_seccion
    INNER JOIN c_subsecciones AS sub ON sub.id = e.id_subseccion
    INNER JOIN t_mp_planeacion_proceso AS pp ON pp.id_equipo = e.id
    WHERE e.activo = 1
    LIMIT 10;";
    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->bind_param("ss", $fechaInicio, $fechaFin);
    $prepare->execute();
    $response = $prepare->get_result();
    $array = array();

    $meses = ['NULL', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

    foreach ($response as $x) {



      $array['totalActividades']++;
      $x['mes'] = $meses[intval((new DateTime($x['fechaCreado']))->format('m'))];

      $array['actividades'][] = $x;
    }
    return $array;
  }
}
