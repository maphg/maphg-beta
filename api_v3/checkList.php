<?php

class CheckList extends Conexion
{
  public static function all($post)
  {
    $conexion = new Conexion();
    $conexion->conectar();

    $query = "SELECT r.id_publico, r.status, s.sabana
    FROM t_sabanas_registros AS r
    INNER JOIN t_sabanas AS s ON r.id_sabana = s.id_publico
    INNER JOIN t_sabanas_registros_capturas AS rc ON r.id_publico = rc.id_registro
    LIMIT 10";

    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->execute();
    $response = $prepare->get_result();
    $array = array();
    foreach ($response as $x)
      $array[] = $x;

    return $array;
  }
}
