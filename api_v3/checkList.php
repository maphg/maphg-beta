<?php

class CheckList extends Conexion
{

  public static function all2($post)
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

    $query = "SELECT
    r.id_publico idRegistro,
    d.destino,
    d.ubicacion nombreDestino,
    h.hotel,
    s.sabana, e.equipo,
    CONCAT(c.nombre, ' ', c.apellido) creadoPor,
    r.fecha_creado fechaCreado,
    r.fecha_finalizado fechaFinalizado,
    aa.actividad,
    rc.id_publico idActividad,
    rc.valor,
    rc.comentario,
    rc.url_adjunto adjunto,
    rc.reportado
    FROM t_sabanas_registros AS r
    INNER JOIN t_sabanas AS s ON r.id_sabana = s.id_publico
    INNER JOIN t_sabanas_equipos AS e ON e.id_equipo = r.id_equipo
    INNER JOIN t_users AS u ON u.id = r.creado_por
    INNER JOIN t_colaboradores AS c ON c.id = u.id_colaborador
    INNER JOIN c_destinos AS d ON d.id = s.id_destino
    INNER JOIN t_sabanas_hoteles AS h ON h.id = s.id_hotel
    INNER JOIN t_sabanas_registros_capturas AS rc ON rc.id_registro = r.id_publico
    INNER JOIN t_sabanas_apartados_actividades AS aa ON aa.id_publico = rc.id_actividad
    WHERE r.activo = 1 AND r.status = 'SOLUCIONADO' AND
    r.fecha_creado BETWEEN ? AND ? AND s.id_publico IN('l8kljcm2l8kljcm3','kxf4737gkxf4737h','kxz78xcokxz78xcp','kxf479ekkxf479el','l8omdxhgl8omdxhh','l8kvs3wxl8kvs3wy','1ksughzxo1ksughzxp','1ksughzxk1ksughzxl','1ksughzxm1ksughzxn','1kstplatj1kstplatk','l9yecydrl9yecyds','kwhbhy8qkwhbhy8r','kzfvzmjgkzfvzmjh','kzg53oyskzg53oyt','kx6ie4l8kx6ie4l9','kx6ijjt0kx6ijjt1','kx6ijb2lkx6ijb2m','1kupp1fde1kupp1fdf')
    $filtroDestino $filtroHotel $filtroCheckList";
    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->bind_param("ss", $fechaInicio, $fechaFin);
    $prepare->execute();
    $response = $prepare->get_result();
    $array = array();

    $meses = ['NULL', 'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'];

    foreach ($response as $x) {
      $array['totalActividades']++;
      $x['mes'] = $meses[intval((new DateTime($x['fechaCreado']))->format('m'))];

      if ($x['adjunto'] != "")
        $x['adjunto'] = 'https://maphg.com/america/sabanas/fotos/' . $x['adjunto'];

      $array['actividades'][] = $x;
    }
    return $array;
  }



  public static function actualizarActividad($post)
  {
    $conexion = new Conexion();
    $conexion->conectar();
    $array = array();
    $array = "ERROR";
    $idActividad = $post['idActividad'];
    $idUsuario = $post['idUsuario'];
    $valor = $post['valor'];

    $query = "UPDATE t_sabanas_registros_capturas
    SET reportado = ?, reportado_por = ?
    WHERE id_publico = ? AND activo = 1";

    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->bind_param("sss", $valor, $idUsuario, $idActividad);


    if ($prepare->execute()) $array = "SUCCESS";

    return $array;
  }



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

    $query = "SELECT
    r.id_publico idRegistro,
    d.destino,
    d.ubicacion nombreDestino,
    h.hotel,
    s.sabana, e.equipo,
    CONCAT(c.nombre, ' ', c.apellido) creadoPor,
    r.fecha_creado fechaCreado,
    r.fecha_finalizado fechaFinalizado
    FROM t_sabanas_registros AS r
    INNER JOIN t_sabanas AS s ON r.id_sabana = s.id_publico
    INNER JOIN t_sabanas_equipos AS e ON e.id_equipo = r.id_equipo
    INNER JOIN t_users AS u ON u.id = r.creado_por
    INNER JOIN t_colaboradores AS c ON c.id = u.id_colaborador
    INNER JOIN c_destinos AS d ON d.id = s.id_destino
    INNER JOIN t_sabanas_hoteles AS h ON h.id = s.id_hotel
    WHERE r.fecha_creado BETWEEN ? AND ? AND
    r.activo = 1 AND r.status = 'SOLUCIONADO'
    $filtroDestino $filtroHotel $filtroCheckList";
    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->bind_param("ss", $fechaInicio, $fechaFin);
    $prepare->execute();
    $response = $prepare->get_result();
    $array = array();

    foreach ($response as $x) {
      $idRegistro = $x['idRegistro'];
      $actividades = CheckList::actividades($idRegistro);
      $x['actividades'] = $actividades;

      $array['totalActividades'] += count($actividades);


      $array['data'][] = $x;
    }
    return $array;
  }


  public static function actividades($idRegistro)
  {
    $conexion = new Conexion();
    $conexion->conectar();

    $query = "SELECT
	rc.id_publico idRegistro,
    aa.actividad,
    rc.valor,
    rc.comentario,
    rc.url_adjunto,
    rc.reportado
    FROM t_sabanas_registros_capturas AS rc
    INNER JOIN t_sabanas_apartados_actividades AS aa ON rc.id_actividad = aa.id_publico
    WHERE rc.id_registro = ?";

    $prepare = mysqli_prepare($conexion->con, $query);
    $prepare->bind_param("s", $idRegistro);
    $prepare->execute();
    $response = $prepare->get_result();
    $array = array();
    foreach ($response as $x)
      $array[] = $x;

    return $array;
  }
}
