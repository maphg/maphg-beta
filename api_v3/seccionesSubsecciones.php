<?php

class seccionesSubsecciones extends Conexion
{
   public $idSeccion;
   public $seccion;
   public $idSubseccion;
   public $subseccion;

   #SECCIONES CON SUS SUBSECCIONES
   public static function all($idDestino)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT sec.id 'idSeccion', sec.seccion, sub.id 'idSubseccion', sub.grupo 'subseccion'
      FROM c_rel_destino_seccion AS relSec
      INNER JOIN c_secciones AS sec ON relSec.id_seccion = sec.id
      INNER JOIN c_rel_seccion_subseccion AS relSub ON relSec.id = relSub.id_rel_seccion
      INNER JOIN c_subsecciones AS sub ON relSub.id_subseccion = sub.id
      WHERE relSec.id_destino = ?";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      $array = array();
      foreach ($response as $x) {
         $array[] = $x;
      }

      return $array;
   }


   #SECCIONES
   public static function secciones($idDestino)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT sec.id 'idSeccion', sec.seccion
      FROM c_rel_destino_seccion AS relSec
      INNER JOIN c_secciones AS sec ON relSec.id_seccion = sec.id
      WHERE relSec.id_destino = ?";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      $array = array();
      foreach ($response as $x) {
         $array[] = $x;
      }

      return $array;
   }

   #SUBSECCIONES
   public static function subsecciones($idDestino, $idSeccion)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT sec.id 'idSeccion', sec.seccion, sub.id 'idSubseccion', sub.grupo 'subseccion'
      FROM c_rel_destino_seccion AS relSec
      INNER JOIN c_secciones AS sec ON relSec.id_seccion = sec.id
      INNER JOIN c_rel_seccion_subseccion AS relSub ON relSec.id = relSub.id_rel_seccion
      INNER JOIN c_subsecciones AS sub ON relSub.id_subseccion = sub.id
      WHERE relSec.id_destino = ? and relSec.id_seccion = ?";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("ii", $idDestino, $idSeccion);
      $prepare->execute();
      $response = $prepare->get_result();

      $array = array();
      foreach ($response as $x) {
         $array[] = $x;
      }

      return $array;
   }
}
