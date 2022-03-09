<?php
include 'usuarios.php';

class Incidencias extends Conexion
{
   public $idEquipo;
   public $actividad;
   public $tipoIncidencia;
   public $status;
   public $creadoPor;
   public $responsable;
   public $fechaCreacion;
   public $ultimaModificacion;
   public $idDestino;
   public $idSeccion;
   public $idSubseccion;
   public $activo;

   public static function all($idDestino)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT
      i.id,
      i.actividad,
      i.tipo_incidencia,
      i.status,
      i.activo,
      i.creado_por,
      i.responsable,
      d.id 'idDestino',
      d.destino,
      sec.id 'idSeccion',
      sec.seccion,
      sub.id 'idSubseccion',
      sub.grupo 'subseccion',
      e.id 'idEquipo',
      e.equipo
      FROM t_mc AS i
      INNER JOIN c_destinos AS d ON i.id_destino = d.id
      INNER JOIN c_secciones AS sec ON i.id_seccion = sec.id
      INNER JOIN c_subsecciones AS sub ON i.id_subseccion = sub.id
      INNER JOIN t_equipos_america AS e ON i.id_equipo = e.id
      WHERE i.id_destino = ? and i.activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();
      $array['incidencias'] = array();

      foreach ($response as $x) {
         $idIncidencia = $x['id'];
         $incidencia = $x['actividad'];
         $tipoIncidencia = $x['tipo_incidencia'];
         $status = $x['status'];
         $creadoPor = $x['creado_por'];
         $responsable = $x['responsable'];
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
         $array['incidencias'][] =
            array(
               "idIncidencia" => $idIncidencia,
               "incidencia" => $incidencia,
               "tipoIncidencia" => $tipoIncidencia,
               "status" => $status,
               "creadoPor" => Usuarios::getById($creadoPor),
               "responsable" => Usuarios::getById($responsable),
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "idSeccion" => $idSeccion,
               "seccion" => $seccion,
               "idSubseccion" => $idSubseccion,
               "subseccion" => $subseccion,
               "idEquipo" => $idEquipo,
               "equipo" => $equipo,
               "activo" => $activo,
               // "comentarios" => ComentariosProyecto::comentarios($idProyecto),
               // "adjuntos" => AdjuntosProyecto::adjuntos($idProyecto),
               // "catalogoConceptos" => CatalogoConceptosProyecto::adjuntos($idProyecto),
            );
      }

      $array['totalIncidencias'] = count($array['incidencias']);

      return $array;
   }


   #INCIDENCIAS POR EQUIPO
   public static function porEquipo($idDestino, $idEquipo)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      #ARRAYS
      $array = array();

      $query = "SELECT
      i.id,
      i.actividad,
      i.tipo_incidencia,
      i.status,
      i.activo,
      i.creado_por,
      i.responsable,
      d.id 'idDestino',
      d.destino,
      sec.id 'idSeccion',
      sec.seccion,
      sub.id 'idSubseccion',
      sub.grupo 'subseccion',
      e.id 'idEquipo',
      e.equipo
      FROM t_mc AS i
      INNER JOIN c_destinos AS d ON i.id_destino = d.id
      INNER JOIN c_secciones AS sec ON i.id_seccion = sec.id
      INNER JOIN c_subsecciones AS sub ON i.id_subseccion = sub.id
      INNER JOIN t_equipos_america AS e ON i.id_equipo = e.id
      WHERE i.id_destino = ? and i.id_equipo = ? and i.activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("ii", $idDestino, $idEquipo);
      $prepare->execute();
      $response = $prepare->get_result();



      foreach ($response as $x) {
         $idIncidencia = $x['id'];
         $incidencia = $x['actividad'];
         $tipoIncidencia = $x['tipo_incidencia'];
         $status = $x['status'];
         $creadoPor = $x['creado_por'];
         $responsable = $x['responsable'];
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
         $array[] = array(
            "idIncidencia" => $idIncidencia,
            "incidencia" => $incidencia,
            "tipoIncidencia" => $tipoIncidencia,
            "status" => $status,
            "creadoPor" => Usuarios::getById($creadoPor),
            "responsable" => Usuarios::getById($responsable),
            "idDestino" => $idDestinoX,
            "destino" => $destino,
            "idSeccion" => $idSeccion,
            "seccion" => $seccion,
            "idSubseccion" => $idSubseccion,
            "subseccion" => $subseccion,
            "idEquipo" => $idEquipo,
            "equipo" => $equipo,
            "activo" => $activo,
            "comentarios" => array(),
            "adjuntos" => array(),
            "catalogoConceptos" => array()
         );
      }

      return $array;
   }


   public function crear()
   {
      $this->conectar();

      $query = "INSERT INTO t_mc(id_equipo, actividad, tipo_incidencia, status, creado_por, responsable, fecha_creacion, ultima_modificacion, id_destino, id_seccion, id_subseccion, activo)
      VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";

      $prepare = mysqli_prepare($this->con, $query);
      $prepare->bind_param(
         "isssiissiiii",
         $this->idEquipo,
         $this->actividad,
         $this->tipoIncidencia,
         $this->status,
         $this->creadoPor,
         $this->responsable,
         $this->fechaCreacion,
         $this->ultimaModificacion,
         $this->idDestino,
         $this->idSeccion,
         $this->idSubseccion,
         $this->activo
      );

      if ($prepare->execute())
         return true;
      else
         return false;
   }


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
         $filtroSeccion = "and i.id_seccion = $idSeccion";

      #FILTRO SUBSECCIÓN
      if ($idSubseccion === 0)
         $filtroSubseccion = "";
      else
         $filtroSubseccion = "and i.id_subseccion = $idSubseccion";

      #STATUS PENDIENTE
      if ($status === 'PENDIENTE')
         $filtroStatus = "and i.status IN('N', 'PENDIENTE', 'P')";

      #STATUS SOLUCIONADO
      if ($status === 'SOLUCIONADO')
         $filtroStatus = "and i.status IN('F', 'FINALIZADO', 'SOLUCIONADO')";

      #STATUS TODOS
      if ($status === 'TODOS')
         $filtroStatus = "and i.status IN('N', 'PENDIENTE', 'P', 'F', 'FINALIZADO', 'SOLUCIONADO')";

      #FECHA CREADO
      if ($fecha === 'CREADO')
         $filtroFecha = "and i.fecha_creacion BETWEEN '$fechaInicio' and '$fechaFin'";

      #FECHA CREADO
      if ($fecha === 'SOLUCIONADO')
         $filtroFecha = "and i.fecha_realizado BETWEEN '$fechaInicio' and '$fechaFin'";

      #FECHA CREADO
      if ($fecha === 'TODOS')
         $filtroFecha = "";

      $query = "SELECT
         i.id,
         i.actividad,
         i.tipo_incidencia,
         i.status,
         i.activo,
         i.creado_por,
         i.responsable,
         i.fecha_creacion,
         i.fecha_realizado,
         d.id 'idDestino',
         d.destino,
         sec.id 'idSeccion',
         sec.seccion,
         sub.id 'idSubseccion',
         sub.grupo 'subseccion',
         e.id 'idEquipo',
         e.equipo
         FROM t_mc AS i
         INNER JOIN c_destinos AS d ON i.id_destino = d.id
         INNER JOIN c_secciones AS sec ON i.id_seccion = sec.id
         INNER JOIN c_subsecciones AS sub ON i.id_subseccion = sub.id
         INNER JOIN t_equipos_america AS e ON i.id_equipo = e.id
         WHERE i.id_destino = ? and i.activo = 1 and i.id_equipo > 0
         $filtroSeccion $filtroStatus $filtroFecha $filtroSubseccion";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();

      foreach ($response as $x) {
         $idIncidencia = $x['id'];
         $incidencia = $x['actividad'];
         $tipoIncidencia = $x['tipo_incidencia'];
         $status = $x['status'];
         $creadoPor = $x['creado_por'];
         $responsable = $x['responsable'];
         $fechaCreado = $x['fecha_creacion'];
         $fechaFinalizado = $x['fecha_realizado'];
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
               "idIncidencia" => $idIncidencia,
               "incidencia" => $incidencia,
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
               "responsable" => $responsable,
               "arrayResponsable" => Usuarios::getById($responsable),
               "activo" => $activo
            );
      }
      return $array;
   }
}
