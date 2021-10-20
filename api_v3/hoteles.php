<?php
class Sabanas extends Conexion
{
   
   public static function all($idDestino)
   {
      // DEVULVE LOS EQUIPOS ENCONTRADAS (DESTINO, SECCION, SUBSECCION Y STATUS)

      $conexion = new Conexion();
      $conexion->conectar();

      $query = "";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {

         #RESULTADO FINAL DE PROYECTOS
         $array[] = array();
      }
      return $array;
   }
}
