<?php

include_once 'conexion.php';

// CLASE DE PROYECTOS
class Proyectos extends Conexion
{
   // ATRIBUTOS
   public $idUsuario;
   public $idProyecto;
   public $idDestino;
   public $idSeccion;
   public $idSubseccion;
   public $proyecto;
   public $justificacion;

   // METODOS

   #CONSULTAR PROYECTOS
   public static function all($idDestino)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT
      p.id,
      p.titulo,
      p.justificacion,
      d.id 'idDestino',
      d.destino,
      sec.id 'idSeccion',
      sec.seccion,
      sub.id 'idSubseccion',
      sub.grupo 'subseccion'
      FROM t_proyectos AS p
      INNER JOIN c_destinos AS d ON p.id_destino = d.id
      INNER JOIN c_secciones AS sec ON p.id_seccion = sec.id
      INNER JOIN c_subsecciones AS sub ON p.id_subseccion = sub.id
      WHERE p.id_destino = ? and p.activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idDestino);
      $prepare->execute();
      $response = $prepare->get_result();

      #ARRAYS
      $array = array();
      $array['proyectos'] = array();

      foreach ($response as $x) {
         $idProyecto = $x['id'];
         $proyecto = $x['titulo'];
         $justificacion = $x['justificacion'];
         $idDestinoX = $x['idDestino'];
         $destino = $x['destino'];
         $idSeccion = $x['idSeccion'];
         $seccion = $x['seccion'];
         $idSubseccion = $x['idSubseccion'];
         $subseccion = $x['subseccion'];

         #JUSTIFICACIÓN
         if ($justificacion === null)
            $justificacion = "";

         #RESULTADO FINAL DE PROYECTOS
         $array['proyectos'][] =
            array(
               "idProyecto" => $idProyecto,
               "proyecto" => $proyecto,
               "justificacion" => $justificacion,
               "idDestino" => $idDestinoX,
               "destino" => $destino,
               "idSeccion" => $idSeccion,
               "seccion" => $seccion,
               "idSubseccion" => $idSubseccion,
               "subseccion" => $subseccion,
               "comentarios" => ComentariosProyecto::comentarios($idProyecto),
               "adjuntos" => AdjuntosProyecto::adjuntos($idProyecto),
               "catalogoConceptos" => CatalogoConceptosProyecto::adjuntos($idProyecto),
            );
      }

      return $array;
   }


   #CREAR PROYECTO
   public function crear()
   {
      $this->conectar();

      $query = "INSERT INTO t_proyectos(id_destino, id_seccion, id_subseccion, titulo, justificacion)
      VALUES(?,?,?,?,?)";

      $prepare = mysqli_prepare($this->con, $query);
      $prepare->bind_param(
         "iiiss",
         $this->idDestino,
         $this->idSeccion,
         $this->idSubseccion,
         $this->proyecto,
         $this->justificacion
      );

      if ($prepare->execute())
         return true;
      else
         return false;
   }


   #ACTUALIZAR PROYECTO
   public function actualizar()
   {
      try {
         $this->conectar();
         $query = "UPDATE t_proyectos SET titulo = ? WHERE id = ?";
         $prepare = mysqli_prepare($this->con, $query);
         $prepare->bind_param(
            "si",
            $this->proyecto,
            $this->idProyecto
         );

         if ($prepare->execute())
            return true;
         else
            return false;
      } catch (\Throwable $th) {
         return $th;
      }
   }


   #ELIMINAR PROYECTO
   public static function eliminar($idProyecto)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "UPDATE t_proyectos SET activo = 0 WHERE id = ?";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idProyecto);

      if ($prepare->execute())
         return true;
      else
         return false;
   }


   #CONSULTAR PROYECTO POR ID
   public static function getById($idProyecto)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $query = "SELECT id 'idProyecto', titulo FROM t_proyectos WHERE id = ?";
      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idProyecto);
      $prepare->execute();
      $response = $prepare->get_result();

      return $response->fetch_object(Proyectos::class);
   }
}


// CLASE COMENTARIOS DE PROYECTOS
class ComentariosProyecto extends Conexion
{
   // COMENTARIOS DE PROYECTOS
   public $idProyecto;
   public $idUsuario;

   #CONSULTAR COMENTARIOS POR ID DE PROYECTO
   public static function comentarios($idProyecto)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $comentarios = array();
      $query = "SELECT c.id, c.comentario, c.fecha, u.id 'idUsuario',
      colaborador.nombre, colaborador.apellido
      FROM t_proyectos_comentarios AS c
      INNER JOIN t_users AS u ON c.usuario = u.id
      INNER JOIN t_colaboradores AS colaborador ON u.id_colaborador = colaborador.id
      WHERE c.id_proyecto = ? and c.activo = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idProyecto);
      $prepare->execute();
      $response = $prepare->get_result();
      foreach ($response as $x) {
         $idComentario = $x['id'];
         $comentario = $x['comentario'];
         $idUsuario = $x['idUsuario'];
         $nombre = $x['nombre'] . " " . $x['apellido'];
         $fecha = $x['fecha'];

         #FECHA
         if ($fecha != '' && $fecha != "0000:00:00 00:00:00" && $fecha != null)
            $fecha = (new DateTime($fecha))->format('Y-m-d');
         else
            $fecha = '';

         #COMENTARIOS
         $comentarios[] =
            array(
               "idComentario" => $idComentario,
               "comentario" => $comentario,
               "idUsuario" => $idUsuario,
               "nombre" => $nombre,
               "fecha" => $fecha,
            );
      }

      return $comentarios;
   }
}


// CLASE ADJUNTOS DE PROYECTOS
class AdjuntosProyecto extends Conexion
{
   // COMENTARIOS DE PROYECTOS
   public $idProyecto;
   public $idUsuario;

   #CONSULTAR COMENTARIOS POR ID DE PROYECTO
   public static function adjuntos($idProyecto)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $adjuntos = array();
      $query = "SELECT a.id, a.url_adjunto, a.fecha, u.id 'idUsuario',
      colaborador.nombre, colaborador.apellido
      FROM t_proyectos_adjuntos AS a
      INNER JOIN t_users AS u ON a.subido_por = u.id
      INNER JOIN t_colaboradores AS colaborador ON u.id_colaborador = colaborador.id
      WHERE a.id_proyecto = ? and a.status = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idProyecto);
      $prepare->execute();
      $response = $prepare->get_result();

      $rutaAbsoluta = "";
      if (strpos($_SERVER['REQUEST_URI'], "america") == true)
         $rutaAbsoluta = "https://www.maphg.com/america";
      if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
         $rutaAbsoluta = "https://www.maphg.com/europa";
      if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
         $rutaAbsoluta = "http://10.30.30.104/maphg-beta";

      foreach ($response as $x) {
         $idAdjunto = $x['id'];
         $idUsuario = $x['idUsuario'];
         $nombre = $x['nombre'] . " " . $x['apellido'];
         $fecha = $x['fecha'];

         #URL
         $url = $rutaAbsoluta . "/planner/proyectos/" . $x['url_adjunto'];

         #FECHA
         if ($fecha != '' && $fecha != "0000:00:00 00:00:00" && $fecha != null)
            $fecha = (new DateTime($fecha))->format('Y-m-d');
         else
            $fecha = '';

         #COMENTARIOS
         $adjuntos[] =
            array(
               "idAdjunto" => $idAdjunto,
               "url" => $url,
               "idUsuario" => $idUsuario,
               "nombre" => $nombre,
               "fecha" => $fecha,
            );
      }

      return $adjuntos;
   }
}


// CLASE CATALOGO  DE CONCEPTOS DE PROYECTO
class CatalogoConceptosProyecto extends Conexion
{
   // COMENTARIOS DE PROYECTOS
   public $idProyecto;
   public $idUsuario;

   #CONSULTAR COMENTARIOS POR ID DE PROYECTO
   public static function adjuntos($idProyecto)
   {
      $conexion = new Conexion();
      $conexion->conectar();

      $adjuntos = array();
      $query = "SELECT c.id, c.url_adjunto, c.fecha, u.id 'idUsuario',
      colaborador.nombre, colaborador.apellido
      FROM t_proyectos_catalogo_conceptos AS c
      INNER JOIN t_users AS u ON c.subido_por = u.id
      INNER JOIN t_colaboradores AS colaborador ON u.id_colaborador = colaborador.id
      WHERE c.id_proyecto = ? and c.status = 1";

      $prepare = mysqli_prepare($conexion->con, $query);
      $prepare->bind_param("i", $idProyecto);
      $prepare->execute();
      $response = $prepare->get_result();

      $rutaAbsoluta = "";
      if (strpos($_SERVER['REQUEST_URI'], "america") == true)
         $rutaAbsoluta = "https://www.maphg.com/america";
      if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
         $rutaAbsoluta = "https://www.maphg.com/europa";
      if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
         $rutaAbsoluta = "http://10.30.30.104/maphg-beta";

      foreach ($response as $x) {
         $idAdjunto = $x['id'];
         $idUsuario = $x['idUsuario'];
         $nombre = $x['nombre'] . " " . $x['apellido'];
         $fecha = $x['fecha'];

         #URL
         $url = $rutaAbsoluta . "/planner/proyectos/" . $x['url_adjunto'];

         #FECHA
         if ($fecha != '' && $fecha != "0000:00:00 00:00:00" && $fecha != null)
            $fecha = (new DateTime($fecha))->format('Y-m-d');
         else
            $fecha = '';

         #COMENTARIOS
         $adjuntos[] =
            array(
               "idAdjunto" => $idAdjunto,
               "url" => $url,
               "idUsuario" => $idUsuario,
               "nombre" => $nombre,
               "fecha" => $fecha,
            );
      }

      return $adjuntos;
   }
}
