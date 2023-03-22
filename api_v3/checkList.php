<?php

class CheckList extends Conexion
{
  public static function all($post)
  {
    $conexion = new Conexion();
    $conexion->conectar();

    $idDestino = $post['idDestino'];
    $idHotel = $post['idHotel'];
    $idCheckList = $post['idCheckList'];
    $fechaInicio = $post['fechaInicio'];
    $fechaFin = $post['fechaFin'];

    $filtroDestino = $idDestino > 0 ? "and s.id_destino = $idDestino" : "";
    $filtroHotel = $idHotel > 0 ? "and s.id_hotel = $idHotel" : "";
    $filtroCheckList = $idCheckList > 0 ?
      "and s.id_privado = $idCheckList" : "";

    $query = "SELECT SELECT r.id_publico idRegistro, d.destino, d.ubicacion nombreDestino, h.hotel, s.sabana, e.equipo, CONCAT(c.nombre, ' ', c.apellido) creadoPor, r.fecha_creado fechaCreado, r.fecha_finalizado fechaFinalizado
    FROM t_sabanas_registros AS r
    INNER JOIN t_sabanas AS s ON r.id_sabana = s.id_publico
    INNER JOIN t_sabanas_equipos AS e ON e.id_equipo = r.id_equipo
    INNER JOIN t_users AS u ON u.id = r.creado_por
    INNER JOIN t_colaboradores AS c ON c.id = u.id_colaborador
    INNER JOIN c_destinos AS d ON d.id = s.id_destino
    INNER JOIN t_sabanas_hoteles AS h ON h.id = s.id_hotel
    WHERE r.fecha_creado BETWEEN ? AND ?
    r.activo = 1 AND r.status = 'SOLUCIONADO'
    $filtroDestino $filtroHotel $filtroCheckList
    LIMIT 100";
    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->bind_param("ss", $fechaInicio, $fechaFin);
    $prepare->execute();
    $response = $prepare->get_result();
    $array = array();

    foreach ($response as $x) {
      $actividades = CheckList::actividades($x['idActividad']);

      $array['actividades'] = $actividades;
      $array[] = $x;
    }
    return $array;
  }

  public static function actividades($idRegistro)
  {
    $conexion = new Conexion();
    $conexion->conectar();

    $query = "SELECT rc.id_publico idRegistro,
    aa.actividad,
    rc.valor,
    rc.comentario,
    rc.url_adjunto,
    rc.reportado
    FROM t_sabanas_registros_capturas AS rc
    INNER JOIN t_sabanas_apartados_actividades AS aa ON rc.id_actividad = aa.id_publico
    WHERE rc.id_registro = ?";

    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->bind_param("i", $idRegistro);
    $prepare->execute();
    $response = $prepare->get_result();
    $array = array();
    foreach ($response as $x)
      $array[] = $x;

    return $array;
  }
}
