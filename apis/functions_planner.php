<?php

#FUNCION PARA OBTENER FAVORITOS DE USUARIO
function obtenerFavoritos($x)
{
  $obtenerFavoritos = array();
  #ARRAY PARA ALMACENAR RESULTADOS

  $idDestino = $x['idDestino'];
  $idUsuario = $x['idUsuario'];

  #FILTRO DESTINO
  if ($idDestino == 10)
    $filtroDestino = "";
  else
    $filtroDestino = "and id_destino = $idDestino";

  $query = "SELECT f.id, f.tipo, f.id_tipo
  FROM t_favoritos AS f
  WHERE id_usuario = $idUsuario and activo = 1 $filtroDestino";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    foreach ($result as $x) {
      $idFavorito = $x['id'];
      $tipo = $x['tipo'];
      $idTipo = $x['id_tipo'];

      #INCIDENCIAS DE EQUIPOS
      if ($tipo === "INCIDENCIA") {
        $return = obtenerIncidencia($idTipo, 'FAVORITO');
        if (empty($return[0])) {
          $obtenerFavoritos[] = $return;
        }
      }

      #INCIDENCIAS GENERALES
      if ($tipo === "INCIDENCIAGENERAL") {
        $return = obtenerIncidenciaGeneral($idTipo, 'FAVORITO');
        if (empty($return[0])) {
          $obtenerFavoritos[] = $return;
        }
      }

      #PREVENTIVOS DE EQUIPOS
      if ($tipo === "MP") {
        $return = obtenerPreventivo($idTipo, 'FAVORITO');
        if (empty($return[0])) {
          $obtenerFavoritos[] = $return;
        }
      }

      #PLANES DE ACCIÓN DE PROYECTOS
      if ($tipo === "PDA") {
        $return = obtenerPlanaccionProyectos($idTipo, 'FAVORITO');
        if (empty($return[0])) {
          $obtenerFavoritos[] = $return;
        }
      }
    }
  }

  return $obtenerFavoritos;
}

#FUNCIÓN PARA OBTENER DETALLES DE INCIDENCIA EQUIPO POR ID
function obtenerIncidencia($idIncidencia, $tipoRegistro)
{
  $obtenerIncidencia = " ";
  #INCIDENCIAS DE EQUIPOS
  $query = "SELECT mc.id, mc.actividad, mc.tipo_incidencia, mc.responsable, mc.fecha_creacion,
  mc.status, mc.rango_fecha, c.nombre, c.apellido
  FROM t_mc AS mc
  INNER JOIN t_users AS u ON mc.creado_por = u.id
  INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
  WHERE mc.id = $idIncidencia and mc.activo = 1";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    foreach ($result as $x) {
      $idIncidencia = intval($x['id']);
      $incidencia = $x['actividad'];
      $tipoIncidencia = $x['tipo_incidencia'];
      $status = $x['status'];
      $creadoPor = $x['nombre'] . " " . $x['apellido'];
      $rangoFecha = $x['rango_fecha'];
      $responsable = preg_split("/[\s,]+/", $x['responsable']);
      $fechaCreado = $x['fecha_creacion'];

      #FECHA CREADO
      if ($fechaCreado > '0000-00-00 00:00:00' && $fechaCreado != "")
        $fechaCreado = (new \DateTime($x['fecha_creacion']))->format('Y-m-d');

      #COMENTARIO
      $totalComentarios = 0;
      $comentario = "";
      $comentarioDe = "";
      $fechaComentario = "";
      $query = "SELECT com.comentario, com.fecha, c.nombre, c.apellido
      FROM t_mc_comentarios com
      INNER JOIN t_users u ON com.id_usuario = u.id
      INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
      WHERE com.id_mc = $idIncidencia and com.activo = 1 ORDER BY com.id";
      if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
          $totalComentarios++;
          $comentario = $x['comentario'];
          $comentarioDe = $x['nombre'] . " " . $x['apellido'];
          $fechaComentario = $x['fecha'];
        }
      }

      #ADJUNTOS
      $totalAdjuntos = 0;
      $query = "SELECT count(id) 'total'
      FROM t_mc_adjuntos
      WHERE id_mc = $idIncidencia and activo = 1";
      if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
          $totalAdjuntos = $x['total'];
        }
      }

      #COMPRUEBA STATUS DE LA INCIDENCIA
      if ($status == "N" || $status == "PENDIENTE" || $status == "P")
        $status = "PENDIENTE";
      else
        $status = "SOLUCIONADO";

      #INCIDENCIAS PENDIENTES
      $obtenerIncidencia = array(
        "idRegistro" => $idIncidencia,
        "titulo" => $incidencia,
        "tipo" => $tipoIncidencia,
        "tipoRegistro" => $tipoRegistro,
        "clasificado" => "INCIDENCIA",
        "fechaCreado" => $fechaCreado,
        "creadoPor" => $creadoPor,
        "status" => $status,
        "totalAdjuntos" => $totalAdjuntos,
        "totalComentarios" => $totalComentarios,
        "comentario" => $comentario,
        "comentarioDe" => $comentarioDe,
        "fechaComentario" => $fechaComentario,
        "url" => "",
      );
    }
  }
  return $obtenerIncidencia;
}

#FUNCIÓN PARA OBTENER DETALLES DE INCIDENCIA GENERAL POR ID
function obtenerIncidenciaGeneral($idIncidencia, $tipoRegistro)
{
  $obtenerIncidenciaGeneral = " ";
  $query = "SELECT mc.id, mc.titulo, mc.tipo_incidencia, mc.responsable, mc.fecha,
  mc.status, mc.rango_fecha, c.nombre, c.apellido
  FROM t_mp_np AS mc
  INNER JOIN t_users AS u ON mc.id_usuario = u.id
  INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
  WHERE mc.id = $idIncidencia and mc.activo = 1 ";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    foreach ($result as $x) {
      $idIncidencia = intval($x['id']);
      $incidencia = $x['titulo'] . "General";
      $tipoIncidencia = $x['tipo_incidencia'];
      $status = $x['status'];
      $creadoPor = $x['nombre'] . " " . $x['apellido'];
      $rangoFecha = $x['rango_fecha'];
      $responsable = preg_split("/[\s,]+/", $x['responsable']);
      $fechaCreado = $x['fecha'];

      #FECHA CREADO
      if ($fechaCreado > '0000-00-00 00:00:00' && $fechaCreado != "")
        $fechaCreado = (new \DateTime($x['fecha']))->format('Y-m-d');

      #COMENTARIO
      $totalComentarios = 0;
      $comentario = "";
      $comentarioDe = "";
      $fechaComentario = "";
      $query = "SELECT com.comentario, com.fecha, c.nombre, c.apellido
      FROM comentarios_mp_np com
      INNER JOIN t_users u ON com.id_usuario = u.id
      INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
      WHERE com.id_mp_np = $idIncidencia and com.activo = 1 ORDER BY com.id";
      if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
          $totalComentarios++;
          $comentario = $x['comentario'];
          $comentarioDe = $x['nombre'] . " " . $x['apellido'];
          $fechaComentario = $x['fecha'];
        }
      }

      #ADJUNTOS
      $totalAdjuntos = 0;
      $query = "SELECT count(id) 'total'
      FROM adjuntos_mp_np
      WHERE id_mp_np = $idIncidencia and activo = 1";
      if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
          $totalAdjuntos = $x['total'];
        }
      }

      #COMPRUEBA EL STATUS DE LA INCIDENCIA
      if ($status == "N" || $status == "PENDIENTE" || $status == "P")
        $status = "PENDIENTE";
      else
        $status = "SOLUCIONADO";

      #INCIDENCIAS PENDIENTES
      $obtenerIncidenciaGeneral = array(
        "idRegistro" => $idIncidencia,
        "titulo" => $incidencia,
        "tipo" => $tipoIncidencia,
        "fechaCreado" => $fechaCreado,
        "creadoPor" => $creadoPor,
        "status" => $status,
        "totalAdjuntos" => $totalAdjuntos,
        "totalComentarios" => $totalComentarios,
        "comentario" => $comentario,
        "comentarioDe" => $comentarioDe,
        "fechaComentario" => $fechaComentario,
        "url" => "",
        "tipoRegistro" => $tipoRegistro,
        "clasificado" => "INCIDENCIAGENERAL",
      );
    }
  }

  return $obtenerIncidenciaGeneral;
}

#FUNCIÓN PARA OBTENER DETALLES DE INCIDENCIA GENERAL POR ID
function obtenerPreventivo($idPreventivo, $tipoRegistro)
{
  $obtenerPreventivo = " ";

  $query = "SELECT mp.id, mp.id_responsables, mp.status, mp.fecha_programada,
  mp.comentario, mp.fecha_creacion, plan.tipo_plan, e.equipo, c.nombre, c.apellido
  FROM t_mp_planificacion_iniciada mp
  INNER JOIN t_mp_planes_mantenimiento plan ON mp.id_plan = plan.id
  INNER JOIN t_equipos_america e ON mp.id_equipo = e.id
  INNER JOIN t_users AS u ON mp.id_usuario = u.id
  INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
  WHERE mp.id = $idPreventivo and mp.activo = 1";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    foreach ($result as $x) {
      $idMP = intval($x['id']);
      $tipoPlan = $x['tipo_plan'];
      $equipo = $x['equipo'];
      $status = $x['status'];
      $fechaProgramada = $x['fecha_programada'];
      $responsable = preg_split("/[\s,]+/", $x['id_responsables']);
      $fechaCreado = $x['fecha_creacion'];
      $creadoPor = $x['nombre'] . " " . $x['apellido'];

      #COMENTARIO
      $totalComentarios = 1;
      $comentario = $x['comentario'];
      $comentarioDe = "";
      $fechaComentario = "";

      #FECHA CREADO
      if ($fechaCreado > '0000-00-00 00:00:00' && $fechaCreado != "")
        $fechaCreado = (new \DateTime($x['fecha_creacion']))->format('Y-m-d');

      #ADJUNTOS
      $totalAdjuntos = 0;
      $query = "SELECT count(id) 'total'
      FROM t_mp_planificacion_iniciada_adjuntos
      WHERE id_planificacion_iniciada = $idMP and activo = 1";
      if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
          $totalAdjuntos = $x['total'];
        }
      }

      #MP EN PROCESO
      $obtenerPreventivo = array(
        "idRegistro" => $idMP,
        "titulo" => $idMP . " ☛ " . $equipo,
        "tipo" => "MP",
        "fechaCreado" => $fechaCreado,
        "creadoPor" => $creadoPor,
        "status" => $status,
        "totalAdjuntos" => $totalAdjuntos,
        "totalComentarios" => $totalComentarios,
        "comentario" => $comentario,
        "comentarioDe" => $comentarioDe,
        "fechaComentario" => $fechaComentario,
        "url" => "",
        "tipoRegistro" => $tipoRegistro,
        "clasificado" => "MP",
      );
    }
  }

  return $obtenerPreventivo;
}

#FUNCIÓN PARA OBTENER DETALLES DE INCIDENCIA GENERAL POR ID
function obtenerProyecto($idProyecto, $tipoRegistro)
{
  $obtenerProyecto = " ";

  return $obtenerProyecto;
}

#FUNCIÓN PARA OBTENER DETALLES DE INCIDENCIA GENERAL POR ID
function obtenerPlanaccionProyectos($idPlanaccion, $tipoRegistro)
{
  $obtenerPlanaccionProyectos = " ";

  $query = "SELECT p.id 'idProyecto', p.titulo, a.id 'idPlanaccion', a.actividad,
  a.status, a.responsable, a.rango_fecha, a.fecha_creacion, c.nombre, c.apellido
  FROM t_proyectos p
  INNER JOIN t_proyectos_planaccion a ON p.id = a.id_proyecto
  INNER JOIN t_users AS u ON p.creado_por = u.id
  INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
  WHERE a.id = $idPlanaccion and p.activo = 1 and a.activo = 1";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    foreach ($result as $x) {
      $idProyecto = $x['idProyecto'];
      $idPlanaccion = $x['idPlanaccion'];
      $actividad = $x['actividad'];
      $status = $x['status'];
      $rangoFecha = $x['rango_fecha'];
      $responsable = preg_split("/[\s,]+/", $x['responsable']);
      $creadoPor = $x['nombre'] . " " . $x['apellido'];
      $fechaCreado = $x['fecha_creacion'];

      if ($status === "N" or $status == "PENDIENTE" or $status == "P")
        $status = "PENDIENTE";
      else
        $status = "SOLUCIONADO";

      #FECHA CREADO
      if ($fechaCreado > '0000-00-00 00:00:00' && $fechaCreado != "")
        $fechaCreado = (new \DateTime($fechaCreado))->format('Y-m-d');

      #COMENTARIO
      $totalComentarios = 0;
      $comentario = "";
      $comentarioDe = "";
      $fechaComentario = "";
      $query = "SELECT com.comentario, com.fecha, c.nombre, c.apellido
      FROM t_proyectos_planaccion_comentarios com
      INNER JOIN t_users u ON com.usuario = u.id
      INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
      WHERE com.id_actividad = $idPlanaccion and com.activo = 1 ORDER BY com.id";
      if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
          $totalComentarios++;
          $comentario = $x['comentario'];
          $comentarioDe = $x['nombre'] . " " . $x['apellido'];
          $fechaComentario = $x['fecha'];
        }
      }

      #ADJUNTOS
      $totalAdjuntos = 0;
      $query = "SELECT count(id) 'total'
      FROM t_proyectos_planaccion_adjuntos
      WHERE id_actividad = $idPlanaccion and status = 1";
      if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
          $totalAdjuntos = $x['total'];
        }
      }

      #PLANACCION EN PROCESO
      $obtenerPlanaccionProyectos = array(
        "idRegistro" => $idPlanaccion,
        "titulo" => $actividad,
        "tipo" => "PDA",
        "fechaCreado" => $fechaCreado,
        "creadoPor" => $creadoPor,
        "status" => $status,
        "totalAdjuntos" => $totalAdjuntos,
        "totalComentarios" => $totalComentarios,
        "comentario" => $comentario,
        "comentarioDe" => $comentarioDe,
        "fechaComentario" => $fechaComentario,
        "url" => "",
        "tipoRegistro" => $tipoRegistro,
        "clasificado" => "PDA",
      );
    }
  }

  return $obtenerPlanaccionProyectos;
}
