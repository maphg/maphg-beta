<?php
class Sabanas extends Conexion
{
   public static function getDestinos($idDestino)
   {
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      $destinos = Destinos::all($idDestino);
      foreach ($destinos as $x)
         if ($x['idDestino'] != 10)
            $array[] = $x;

      return $array;
   }


   public static function getHoteles($idDestino)
   {
      // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT id 'idHotel', id_destino 'idDestino', hotel, marca
      FROM t_sabanas_hoteles
      WHERE id_destino = ? and activo = 1 ORDER BY id DESC";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x)
         #RESULTADO FINAL DE PROYECTOS
         $array[] = $x;

      return $array;
   }


   public static function getTiposActivos($idDestino, $idHotel)
   {
      // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT registroTipoActivo.id 'idRegistroTipoActivo',
      registroTipoActivo.id_hotel 'idHotel',
      tipo.id 'idTipoActivo',
      tipo.tipo,
      tipo.tipo_activo 'tipoActivo'
      FROM t_sabanas_hoteles_tipos_activos AS registroTipoActivo
      INNER JOIN c_tipos AS tipo ON registroTipoActivo.id_tipo_activo = tipo.id
      WHERE registroTipoActivo.id_hotel = ? and registroTipoActivo.activo = 1
      ORDER BY registroTipoActivo.id DESC";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idHotel);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x)
         $array[] = $x;

      return $array;
   }


   public static function getSabanas($idDestino, $idHotel, $idRegistroTipoActivo)
   {
      // DEVULVE LAS SABANAS ENCONTRADAS (DESTINO, HOTEL Y TIPOACTIVO)
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT id_publico 'idSabana',
      id_destino 'idDestino',
      id_hotel 'idHotel',
      id_registro_tipo_activo 'idRegistroTipoActivo',
      sabana,
      fecha_creado 'fechaCreado'
      FROM t_sabanas
      WHERE id_destino = ? and id_hotel = ? and id_registro_tipo_activo = ? and activo = 1
      ORDER BY id_privado DESC";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("iii", $idDestino, $idHotel, $idRegistroTipoActivo);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x)
         #RESULTADO FINAL DE PROYECTOS
         $array[] = $x;

      return $array;
   }


   public static function getApartados($idDestino, $idSabana)
   {
      // DEVULVE LOS APRTADOS ENCONTRADAS (SABANA)
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT
      id_publico  'idApartado',
      id_sabana 'idSabana',
      apartado,
      opciones,
      fecha_creado 'fechaCreado'
      FROM t_sabanas_apartados
      WHERE id_sabana = ? and activo = 1 ORDER BY id_privado DESC";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("s", $idSabana);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x)
         #RESULTADO FINAL DE PROYECTOS
         $array[] = $x;

      return $array;
   }


   public static function getActividades($idDestino, $idApartado)
   {
      // DEVULVE LOS APRTADOS ENCONTRADAS (SABANA)
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      $query = "SELECT
      id_publico  'idActividad',
      id_apartado 'idApartado',
      actividad,
      fecha_creado 'fechaCreado'
      FROM t_sabanas_apartados_actividades
      WHERE id_apartado = ? and activo = 1
      ORDER BY id_privado DESC";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("s", $idApartado);
      $prepare->execute();
      $response = $prepare->get_result();

      foreach ($response as $x) {
         #RESULTADO FINAL
         $x['editar'] = false;
         $array[] = $x;
      }

      return $array;
   }


   public static function actualizarActividad($idDestino, $idActividad, $idApartado, $actividad, $activo)
   {
      // DEVULVE LOS APRTADOS ENCONTRADAS (SABANA)
      $conexion = new Conexion();
      $conexion->conectar();
      $array = array();

      $query = "UPDATE t_sabanas_apartados_actividades
      SET actividad = ?, activo = ?
      WHERE id_publico = ?";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("ssi", $actividad, $activo, $idActividad);

      if ($prepare->execute()) {
         $actividades = Sabanas::getActividades($idDestino, $idApartado);
         foreach ($actividades as $x)
            $array[] = $x;
      }

      return $array;
   }


   public static function agregarActividad($idDestino, $idActividad, $idApartado, $idUsuario, $actividad)
   {
      $conexion = new Conexion();
      $conexion->conectar();
      $fechaActual = date('Y-m-d H:m:s');
      $activo = 1;
      $array = array();

      $query = "INSERT INTO t_sabanas_apartados_actividades(id_publico, id_apartado, creado_por, actividad, fecha_creado, activo) VALUES(?,?,?,?,?,?)";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param(
         "ssissi",
         $idActividad,
         $idApartado,
         $idUsuario,
         $actividad,
         $fechaActual,
         $activo
      );

      if ($prepare->execute()) {
         $actividades = Sabanas::getActividades($idDestino, $idApartado);

         foreach ($actividades as $x)
            $array[] = $x;
      }

      return $array;
   }


   public static function agregarRegistroTipoActivo($idDestino, $idHotel, $idTipoActivo, $idUsuario)
   {
      $conexion = new Conexion();
      $conexion->conectar();
      $fechaActual = date('Y-m-d H:m:s');
      $activo = 1;
      $array = array();

      $query = "INSERT INTO t_sabanas_hoteles_tipos_activos(id_hotel, id_tipo_activo, creado_por, fecha_creado, activo)
      VALUES(?, ?, ?, ?, ?)";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("iiisi", $idHotel, $idTipoActivo, $idUsuario, $fechaActual, $activo);

      if ($prepare->execute()) {
         $listaTiposActivos = Sabanas::getTiposActivos($idDestino, $idHotel);
         foreach ($listaTiposActivos as $x)
            $array[] = $x;
      }

      return $array;
   }


   public static function agregarChecklist(
      $idDestino,
      $idSabana,
      $idHotel,
      $idRegistroTipoActivo,
      $sabana,
      $idUsuario
   ) {
      $conexion = new Conexion();
      $conexion->conectar();
      $fechaActual = date('Y-m-d H:m:s');
      $activo = 1;
      $array = array();

      $query = "INSERT INTO t_sabanas(id_publico, id_destino, id_hotel, id_registro_tipo_activo,
      creado_por, sabana, fecha_creado, activo)
      VALUES(?, ?, ?, ?, ?, ?, ?, ?)";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param(
         "siiiissi",
         $idSabana,
         $idDestino,
         $idHotel,
         $idRegistroTipoActivo,
         $idUsuario,
         $sabana,
         $fechaActual,
         $activo
      );

      if ($prepare->execute()) {
         $listaTiposActivos = Sabanas::getSabanas($idDestino, $idHotel, $idRegistroTipoActivo);
         foreach ($listaTiposActivos as $x)
            $array[] = $x;
      }

      return $array;
   }


   public static function agregarApartado(
      $idDestino,
      $idApartado,
      $idSabana,
      $opciones,
      $tituloApartado,
      $idUsuario
   ) {
      $conexion = new Conexion();
      $conexion->conectar();
      $fechaActual = date('Y-m-d H:m:s');
      $activo = 1;
      $array = array();

      $query = "INSERT INTO t_sabanas_apartados(id_publico, id_sabana, creado_por, apartado, opciones,
      fecha_creado, activo)
      VALUES(?, ?, ?, ?, ?, ?, ?)";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param(
         "ssisssi",
         $idApartado,
         $idSabana,
         $idUsuario,
         $tituloApartado,
         $opciones,
         $fechaActual,
         $activo
      );

      if ($prepare->execute()) {
         $listaTiposActivos = Sabanas::getApartados($idDestino, $idSabana);
         foreach ($listaTiposActivos as $x)
            $array[] = $x;
      }

      return $array;
   }
}
