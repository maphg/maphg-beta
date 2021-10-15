<?php

class Destinos extends Conexion
{
   public static function all($idDestino = 0)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $filtroDestino = "and id = 0";

      if ($idDestino > 0)
         $filtroDestino = "and id = $idDestino";

      if ($idDestino == 10)
         $filtroDestino = "";


      $query = "SELECT
      d.id 'idDestino',
      d.destino,
      d.ubicacion,
      d.status,
      d.bandera,
      d.division,
      d.superficie,
      d.habitaciones
      FROM c_destinos AS d
      WHERE status = 'A' $filtroDestino";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->execute();
      $response = $prepare->get_result();
      $array = array();
      foreach ($response as $x)
         $array[] = $x;

      return $array;
   }
}
