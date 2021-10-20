<?php

class Equipos extends Conexion
{

   /**
    * @param $idEquipo int(id) o 0 para omitir
    * @param $idDestino int(id) del destino o 0 para todos los destinos 
    * @param $idSeccion int(id) o 0 para omitir
    * @param $idSubseccion int(id) o 0 para omitir
    * @param $status string(OPERATIVO, TALLER, FUERASERVICIO, BAJA) o Vació para todos
    * @return Array
    */
   public static function equiposFiltrados($idEquipo, $idDestino, $idSeccion, $idSubseccion, $status, $limit = '')
   {
      // DEVULVE LOS EQUIPOS ENCONTRADAS (DESTINO, SECCION, SUBSECCION Y STATUS)

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
      if ($status === 'OPERATIVO' || $status === 'TALLER' || $status === 'FUERASERVICIO' || $status === 'BAJA')
         $filtroStatus = "and e.status IN('$status')";
      else
         $filtroStatus = "";

      #FILTRO ID EQUIPO
      if ($idEquipo === 0)
         $filtroId  = "";
      else {
         $filtroSeccion = "";
         $filtroSubseccion = "";
         $filtroStatus = "";
         $filtroId  = "and e.id = $idEquipo";
      }

      if ($limit === '')
         $filtroLimit = '';
      else
         $filtroLimit = "LIMIT $limit";

      $query = "SELECT
      e.id 'idEquipo',
      e.equipo,
      e.status,
      e.activo,
      d.id 'idDestino',
      d.destino,
      sec.id 'idSeccion',
      sec.seccion,
      sub.id 'idSubseccion',
      sub.grupo 'subseccion',
      tipo.id 'idTipoEquipo',
      tipo.tipo 'tipoEquipo'
      FROM t_equipos_america AS e
      INNER JOIN c_destinos AS d ON e.id_destino = d.id
      INNER JOIN c_secciones AS sec ON e.id_seccion = sec.id
      INNER JOIN c_subsecciones AS sub ON e.id_subseccion = sub.id
      INNER JOIN c_tipos AS tipo ON e.id_tipo = tipo.id
      WHERE e.id_destino = ? and e.activo = 1
      $filtroId $filtroSeccion $filtroSubseccion $filtroStatus $filtroLimit";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         $idEquipo = $x['idEquipo'];
         $equipo = $x['equipo'];
         $status = $x['status'];
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $idSeccion = $x['idSeccion'];
         $seccion = $x['seccion'];
         $idSubseccion = $x['idSubseccion'];
         $subseccion = $x['subseccion'];
         $idTipoEquipo = $x['idTipoEquipo'];
         $tipoEquipo = $x['tipoEquipo'];
         $activo = $x['activo'];

         #RESULTADO FINAL DE PROYECTOS
         $array[] = array(
            "idEquipo" => $idEquipo,
            "equipo" => $equipo,
            "status" => $status,
            "idDestino" => $idDestinoX,
            "destino" => $destino,
            "idSeccion" => $idSeccion,
            "seccion" => $seccion,
            "idSubseccion" => $idSubseccion,
            "subseccion" => $subseccion,
            "idTipoEquipo" => $idTipoEquipo,
            "tipoEquipo" => $tipoEquipo,
            "activo" => $activo
         );
      }
      return $array;
   }


   public static function listaTiposActivos($idDestino, $idTipoActivo = 0)
   {
      // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
      $conexion = new Conexion();
      $conexion->conectar();

      if ($idTipoActivo > 0)
         $filtroTipoActivo = "and id = $idTipoActivo";
      else
         $filtroTipoActivo = "";

      $query = "SELECT id 'idTipoActivo', tipo, tipo_activo 'tipoActivo'
      FROM c_tipos
      WHERE status = 'A' $filtroTipoActivo ORDER BY tipo_activo ASC";

      $prepare = mysqli_prepare($conexion->con, $query);
      // $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x)
         #RESULTADO FINAL DE PROYECTOS
         $array[] = $x;

      return $array;
   }
}
