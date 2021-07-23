<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');

#CALCULA DÍA ACTUAL DE LA SEMANA.
$dias = array("domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
$diaSemana = $dias[date("w")];

# CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

#RUTA ABSOLUTA PARA ENLACES
$rutaAbsoluta = "";
if (strpos($_SERVER['REQUEST_URI'], "america") == true)
  $rutaAbsoluta = "https://www.maphg.com/america";
if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
  $rutaAbsoluta = "https://www.maphg.com/europa";
if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
  $rutaAbsoluta = "https://www.maphg.com/america";

# CONEXION DB
include '../php/conexion.php';

#FUNCIONES
include '../apis/functions_planner.php';

#ARRAY GLOBAL
$array = array();
$array['status'] = '404';

#PETICIÓN
$peticion = '';

#OBTIENE EL TIPO DE PETICIÓN
if ($_SERVER['REQUEST_METHOD'])
  $peticion = $_SERVER['REQUEST_METHOD'];


#PETICIONES METODO _GET
if ($peticion === "GET") {
  $array['status'] = 'ok';
  $array['GET'] = $_GET;
}

#PETICIONES METODO _POST
if ($peticion === "POST") {
  $_POST = json_decode(file_get_contents('php://input'), true);

  #VARIABLES POR METODO $_POST
  $idUsuario = $_POST['idUsuario'];
  $idDestino = $_POST['idDestino'];
  $action = $_POST['action'];

  #STATUS DE RESPUESTA DEL SERVER
  $array['status'] = 'ok';
  $array['resp'] = "ERROR";

  #PERMISO DE SECCIONES POR USUARIO
  $seccionesPermitidas = [0];
  $query = "SELECT* FROM t_users WHERE id = $idUsuario and id_permiso IN(1, 2, 3) and activo IN(1)";
  if ($result = mysqli_query($conn_2020, $query)) {
    foreach ($result as $x) {
      if ($x['DECC'] == 1)
        $seccionesPermitidas[] = 1;
      if ($x['ZIA'] == 1)
        $seccionesPermitidas[] = 8;
      if ($x['ZIC'] == 1)
        $seccionesPermitidas[] = 9;
      if ($x['ZIE'] == 1)
        $seccionesPermitidas[] = 10;
      if ($x['ZIL'] == 1)
        $seccionesPermitidas[] = 11;
      if ($x['OMA'] == 1)
        $seccionesPermitidas[] = 19;
      if ($x['DEP'] == 1)
        $seccionesPermitidas[] = 23;
      if ($x['AUTO'] == 1)
        $seccionesPermitidas[] = 24;
      if ($x['ZHA'] == 1)
        $seccionesPermitidas[] = 5;
      if ($x['ZHC'] == 1)
        $seccionesPermitidas[] = 6;
      if ($x['ZHP'] == 1)
        $seccionesPermitidas[] = 12;
      if ($x['ZHH'] == 1)
        $seccionesPermitidas[] = 7;
    }
  }

  #FILTRO PARA SECCIONES PERMITIDAS AL USUARIO. IN($seccionesPermitidas)
  $seccionesPermitidas = implode(", ", $seccionesPermitidas);

  #OBTIENE INFORMACIÓN DE USUARIO
  if ($action === "usuario") {

    #FILTRO PARA LIMITAR DESTINOS
    if ($idDestino == 10) {
      $filtroDestinoIncidencias = "";
      $filtroDestinoMP = "";
      $filtroDestinoProyectos = "";
      $filtroFavoritos = "";
      $filtroActivos = "";
      $filtroTodo = "";
    } else {
      $filtroDestinoIncidencias = "and mc.id_destino = $idDestino";
      $filtroDestinoMP = "and e.id_destino = $idDestino";
      $filtroDestinoProyectos = "and p.id_destino = $idDestino";
      $filtroFavoritos = "and id_destino = $idDestino";
      $filtroActivos = "and id_destino = $idDestino";
      $filtroTodo = "and id_destino = $idDestino";
    }

    #INFORMACIÓN DE DESTINO
    $array['destino'] = array();
    $query = "SELECT id, destino, ubicacion
    FROM c_destinos
    WHERE id = $idDestino";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idDestino = intval($x['id']);
        $destino = $x['destino'];
        $ubicacion = $x['ubicacion'];

        #TOTAL ACTIVOS POR DESTINO
        $activos = 0;
        $query = "SELECT count(id) 'total'
        FROM t_equipos_america
        WHERE activo = 1 and status IN('OPERATIVO') $filtroActivos";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $activos = $x['total'];
          }
        }

        #TOTAL ACTIVOS FUERA DE SERVICIO
        $fueraServicio = 0;
        $query = "SELECT count(id) 'total'
        FROM t_equipos_america
        WHERE activo = 1 and status IN('FUERASERVICIO') $filtroActivos";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $fueraServicio = $x['total'];
          }
        }

        #TOTAL ACTIVOS TALLER
        $taller = 0;
        $query = "SELECT count(id) 'total'
        FROM t_equipos_america
        WHERE activo = 1 and status IN('TALLER') $filtroActivos";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $taller = $x['total'];
          }
        }

        #TOTAL ACTIVOS OPERA MAL
        $operaMal = 0;
        $query = "SELECT count(id) 'total'
        FROM t_equipos_america
        WHERE activo = 1 and status IN('OPERAMAL') $filtroActivos";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $operaMal = $x['total'];
          }
        }

        $array['destino'] = array(
          "idDestino" => $idDestino,
          "destino" => $destino,
          "ubicacion" => $ubicacion,
          "activos" => intval($activos),
          "fueraServicio" => intval($fueraServicio),
          "taller" => intval($taller),
          "operaMal" => intval($operaMal),
        );
      }
    }

    #INFORMACIÓN DE USUARIO
    $query = "SELECT u.id, u.telegram_chat_id, c.nombre, c.apellido, c.foto, c.email, c.telefono, cargo.cargo
    FROM t_users u
    INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
    INNER JOIN c_cargos cargo ON c.id_cargo = cargo.id
    WHERE u.id = $idUsuario";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idUsuario = $x['id'];
        $nombreCompleto = $x['nombre'] . " " . $x['apellido'];
        $nombre = $x['nombre'];
        $apellido = $x['apellido'];
        $correo = $x['email'];
        $telefono = $x['telefono'];
        $telegram = $x['telegram_chat_id'];
        $cargo = $x['cargo'];
        $foto = $x['foto'];
        $emergencia = 0;
        $urgencia = 0;
        $alarma = 0;
        $alerta = 0;
        $seguimiento = 0;

        $totalPreventivos = 0;
        $totalProyectos = 0;
        $totalTareasproyectos = 0;
        $totalTodos = 0;
        $totalFavoritos = 0;

        #COMPROBACIÓN DE TELEGRAM.
        if ($telegram == "")
          $telegram = "NO";
        else
          $telegram = "SI";

        #VALIDACIÓN DE FOTO
        if ($foto == "")
          $foto = "https://ui-avatars.com/api/?format=svg&rounded=false&size=300&background=2d3748&color=edf2f7&name=$nombre%$apellido";
        else
          $foto = "$rutaAbsoluta/planner/avatars/$foto";

        #INCIDENCIAS DE EQUIPOS.
        $incidencias['pendientes'] = array();
        $incidencias['solucionadas'] = array();
        $incidencias['sinprogramar'] = array();

        #INCIDENCIAS DE EQUIPOS
        $query = "SELECT mc.id, mc.actividad, mc.tipo_incidencia, mc.responsable, mc.fecha_creacion,
        mc.status, mc.rango_fecha, c.nombre, c.apellido
        FROM t_mc AS mc
        INNER JOIN t_users AS u ON mc.creado_por = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE mc.responsable LIKE '%$idUsuario%' and mc.activo = 1 and
        mc.id_seccion IN($seccionesPermitidas) $filtroDestinoIncidencias";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idIncidencia = intval($x['id']);
            $incidencia = $x['actividad'];
            $tipoIncidencia = $x['tipo_incidencia'];
            $status = $x['status'];
            $creadoPor = $x['nombre'] . " " . $x['apellido'];
            $rangoFecha = $x['rango_fecha'];
            $responsable = preg_split("/[\s,]+/", $x['responsable']);
            $fechaCreado = $x['fecha_creacion'];

            if (in_array($idUsuario, $responsable, true)) {
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
              if ($result = mysqli_query($conn_2020, $query)) {
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
              if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                  $totalAdjuntos = $x['total'];
                }
              }

              #URL INCIDENCIA
              $url = $rutaAbsoluta . "incidencia/$idIncidencia";

              if ($tipoIncidencia == "EMERGENCIA")
                $emergencia++;
              if ($tipoIncidencia == "URGENCIA")
                $urgencia++;
              if ($tipoIncidencia == "ALARMA")
                $alarma++;
              if ($tipoIncidencia == "ALERTA")
                $alerta++;
              if ($tipoIncidencia == "SEGUIMIENTO")
                $seguimiento++;

              #COMPRUEBA EL STATUS DE LA INCIDENCIA
              if ($status == "N" || $status == "PENDIENTE" || $status == "P")
                $status = "PENDIENTE";
              else
                $status = "SOLUCIONADO";

              #INCIDENCIAS PENDIENTES
              if ($status === "PENDIENTE") {
                $incidencias['pendientes'][] = array(
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
                  "url" => $url,
                  "tipoRegistro" => "INCIDENCIA"
                );
              }

              #INCIDENCIAS SOLUCIONADAS
              if ($status === "SOLUCIONADO") {
                $incidencias['solucionadas'][] = array(
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
                  "url" => $url,
                  "tipoRegistro" => "INCIDENCIA"
                );
              }

              #INCIDENCIAS SIN PROGRAMAR (RANGO FECHA)
              if (($rangoFecha === "" || $rangoFecha === null) && $status === "PENDIENTE") {
                $incidencias['sinprogramar'][] = array(
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
                  "url" => $url,
                  "tipoRegistro" => "INCIDENCIA"
                );
              }
            }
          }
        }

        #INCIDENCIAS GENERALES
        $query = "SELECT mc.id, mc.titulo, mc.tipo_incidencia, mc.responsable, mc.fecha,
        mc.status, mc.rango_fecha, c.nombre, c.apellido
        FROM t_mp_np AS mc
        INNER JOIN t_users AS u ON mc.id_usuario = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE mc.responsable LIKE '%$idUsuario%' and mc.activo = 1 and
        mc.id_seccion IN($seccionesPermitidas) $filtroDestinoIncidencias";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idIncidencia = intval($x['id']);
            $incidencia = $x['titulo'] . "General";
            $tipoIncidencia = $x['tipo_incidencia'];
            $status = $x['status'];
            $creadoPor = $x['nombre'] . " " . $x['apellido'];
            $rangoFecha = $x['rango_fecha'];
            $responsable = preg_split("/[\s,]+/", $x['responsable']);
            $fechaCreado = $x['fecha'];

            if (in_array($idUsuario, $responsable, true)) {
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
              if ($result = mysqli_query($conn_2020, $query)) {
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
              if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                  $totalAdjuntos = $x['total'];
                }
              }

              #URL INCIDENCIA
              $url = $rutaAbsoluta . "incidenciaGeneral/$idIncidencia";

              if ($tipoIncidencia == "EMERGENCIA")
                $emergencia++;
              if ($tipoIncidencia == "URGENCIA")
                $urgencia++;
              if ($tipoIncidencia == "ALARMA")
                $alarma++;
              if ($tipoIncidencia == "ALERTA")
                $alerta++;
              if ($tipoIncidencia == "SEGUIMIENTO")
                $seguimiento++;

              #COMPRUEBA EL STATUS DE LA INCIDENCIA
              if ($status == "N" || $status == "PENDIENTE" || $status == "P")
                $status = "PENDIENTE";
              else
                $status = "SOLUCIONADO";

              #INCIDENCIAS PENDIENTES
              if ($status === "PENDIENTE") {
                $incidencias['pendientes'][] = array(
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
                  "url" => $url,
                  "tipoRegistro" => "INCIDENCIA"
                );
              }

              #INCIDENCIAS SOLUCIONADAS
              if ($status === "SOLUCIONADO") {
                $incidencias['solucionadas'][] = array(
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
                  "url" => $url,
                  "tipoRegistro" => "INCIDENCIA"
                );
              }

              #INCIDENCIAS SIN PROGRAMAR (RANGO FECHA)
              if (($rangoFecha === "" || $rangoFecha === null) && $status === "PENDIENTE") {
                $incidencias['sinprogramar'][] = array(
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
                  "url" => $url,
                  "tipoRegistro" => "INCIDENCIA"
                );
              }
            }
          }
        }

        #PREVENTIVOS
        $preventivos['pendientes'] = array();
        $preventivos['sinprogramar'] = array();
        $preventivos['estasemana'] = array();
        $preventivos['proximos'] = array();

        $query = "SELECT mp.id, mp.id_responsables, mp.status, mp.fecha_programada,
        mp.comentario, mp.fecha_creacion, plan.tipo_plan, e.equipo, c.nombre, c.apellido
        FROM t_mp_planificacion_iniciada mp
        INNER JOIN t_mp_planes_mantenimiento plan ON mp.id_plan = plan.id
        INNER JOIN t_equipos_america e ON mp.id_equipo = e.id
        INNER JOIN t_users AS u ON mp.id_usuario = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE mp.id_responsables LIKE '%$idUsuario%' and mp.activo = 1 and e.id_seccion IN($seccionesPermitidas) $filtroDestinoMP";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idMP = intval($x['id']);
            $tipoPlan = $x['tipo_plan'];
            $equipo = $x['equipo'];
            $status = $x['status'];
            $fechaProgramada = $x['fecha_programada'];
            $responsable = preg_split("/[\s,]+/", $x['id_responsables']);
            $fechaCreado = $x['fecha_creacion'];
            $creadoPor = $x['nombre'] . " " . $x['apellido'];

            if ($status === "N" || $status == "PENDIENTE" || $status == "P" || $status == "PROCESO")
              $status = "PENDIENTE";
            else
              $status = "SOLUCIONADO";

            #COMENTARIO
            $totalComentarios = 1;
            $comentario = $x['comentario'];
            $comentarioDe = "";
            $fechaComentario = "";

            if (in_array($idUsuario, $responsable, true)) {

              #FECHA CREADO
              if ($fechaCreado > '0000-00-00 00:00:00' && $fechaCreado != "")
                $fechaCreado = (new \DateTime($x['fecha_creacion']))->format('Y-m-d');

              #ADJUNTOS
              $totalAdjuntos = 0;
              $query = "SELECT count(id) 'total'
              FROM t_mp_planificacion_iniciada_adjuntos
              WHERE id_planificacion_iniciada = $idMP and activo = 1";
              if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                  $totalAdjuntos = $x['total'];
                }
              }

              #URL INCIDENCIA
              $url = $rutaAbsoluta . "mp/$idMP";

              #MP EN PROCESO
              if ($status == "PENDIENTE") {
                $totalPreventivos++;

                $preventivos['pendientes'][] =
                  array(
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
                    "url" => $url,
                    "tipoRegistro" => "MP"
                  );
              }

              #MP SIN PROGRAMAR
              if (($fechaProgramada === "" || $fechaProgramada === null) && $status === "PENDIENTE") {
                $totalPreventivos++;

                $preventivos['sinprogramar'][] =
                  array(
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
                    "url" => $url,
                    "tipoRegistro" => "MP"
                  );
              }

              #MP ESTA SEMANA
              if (($fechaProgramada === "" || $fechaProgramada === null) && $status === "PENDIENTE") {
                $preventivos['estasemana'][] =
                  array(
                    "idRegistro" => $idMP,
                    "titulo" => $idMP . " ☛ " . $equipo,
                    "tipo" => "MP"
                  );
              }

              #MP PROXIMOS
              if (($fechaProgramada === "" || $fechaProgramada === null) && $status === "PENDIENTE") {
                $preventivos['proximos'][] =
                  array(
                    "idRegistro" => $idMP,
                    "titulo" => $idMP . " ☛ " . $equipo,
                    "tipo" => "MP"
                  );
              }
            }
          }
        }

        #PROYECTOS
        $tareasproyectos['enproceso'] = array();
        $tareasproyectos['sinprogramar'] = array();
        $tareasproyectos['solucionadas'] = array();

        $query = "SELECT p.id 'idProyecto', p.titulo, a.id 'idPlanaccion', a.actividad,
        a.status, a.responsable, a.rango_fecha, a.fecha_creacion, c.nombre, c.apellido
        FROM t_proyectos p
        INNER JOIN t_proyectos_planaccion a ON p.id = a.id_proyecto
        INNER JOIN t_users AS u ON p.creado_por = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE a.responsable LIKE '%$idUsuario%' and p.activo = 1 and a.activo = 1 and 
        p.id_seccion IN($seccionesPermitidas) $filtroDestinoProyectos";
        if ($result = mysqli_query($conn_2020, $query)) {
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

            if (in_array($idUsuario, $responsable, true)) {
              $totalTareasproyectos++;

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
              if ($result = mysqli_query($conn_2020, $query)) {
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
              if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                  $totalAdjuntos = $x['total'];
                }
              }

              #URL INCIDENCIA
              $url = $rutaAbsoluta . "proyectos/$idProyecto";

              #PLANACCION EN PROCESO
              if ($status == "PENDIENTE") {
                $tareasproyectos['enproceso'][] =
                  array(
                    "idRegistro" => $idProyecto,
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
                    "url" => $url,
                    "tipoRegistro" => "PDA"
                  );
              }

              #PLANACCION SIN PROGRAMAR
              if ($status == "PENDIENTE" && ($rangoFecha === "" || $rangoFecha === null)) {
                $tareasproyectos['sinprogramar'][] =
                  array(
                    "idRegistro" => $idProyecto,
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
                    "url" => $url,
                    "tipoRegistro" => "PDA"
                  );
              }

              #PLANACCION SOLUCIONADAS
              if ($status == "SOLUCIONADO") {
                $tareasproyectos['solucionadas'][] =
                  array(
                    "idRegistro" => $idProyecto,
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
                    "url" => $url,
                    "tipoRegistro" => "PDA"
                  );
              }
            }
          }
        }

        #TODO
        $totalTodos = 0;
        $array['todo']['PENDIENTE'] = array();
        $array['todo']['SOLUCIONADO'] = array();
        $query = "SELECT id, descripcion, fecha_creacion, fecha_modificado, status
        FROM t_to_do
        WHERE id_usuario = $idUsuario and activo = 1 $filtroTodo";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idTodo = intval($x['id']);
            $todo = $x['descripcion'];
            $fechaCreacion = $x['fecha_creacion'];
            $fechaModificado = $x['fecha_modificado'];
            $status = $x['status'];
            $totalTodos++;

            #TO DO PENDIENTES
            if ($status === "PENDIENTE") {
              #ARRAY TODO
              $array['todo']['PENDIENTE'][] = array(
                "idTodo" => $idTodo,
                "todo" => $todo,
                "fechaCreacion" => $fechaCreacion,
                "fechaModificado" => $fechaModificado,
                "status" => $status,
              );
            }

            #TO DO SOLUCIONADOS
            if ($status === "SOLUCIONADO") {
              #ARRAY TODO
              $array['todo']['SOLUCIONADO'][] = array(
                "idTodo" => $idTodo,
                "todo" => $todo,
                "fechaCreacion" => $fechaCreacion,
                "fechaModificado" => $fechaModificado,
                "status" => $status,
              );
            }
          }
        }

        #FAVORITOS
        $totalFavoritos = 1;
        $favoritos = array();
        $favoritos = obtenerFavoritos($_POST);
        $totalFavoritos = count($favoritos);

        #ARRAY DATOS USUARIO
        $array['usuario'] = array(
          "idUsuario" => $idUsuario,
          "nombreCompleto" => $nombreCompleto,
          "nombre" => $nombre,
          "apellido" => $apellido,
          "telefono" => $telefono,
          "correo" => $correo,
          "telegram" => $telegram,
          "cargo" => $cargo,
          "foto" => $foto,
          "emergencia" => $emergencia,
          "urgencia" => $urgencia,
          "alarma" => $alarma,
          "alerta" => $alerta,
          "seguimiento" => $seguimiento,
          "totalPreventivos" => $totalPreventivos,
          "totalProyectos" => $totalProyectos,
          "totalTareasproyectos" => $totalTareasproyectos,
          "totalTodos" => $totalTodos,
          "totalFavoritos" => $totalFavoritos,
        );

        #INCIDENCIAS
        $array['incidencias'] = $incidencias;
        $array['preventivos'] = $preventivos;
        $array['tareasproyectos'] = $tareasproyectos;
        $array['favoritos'] = $favoritos;

        #ARRAY BOTÓN SECCIÓN USUARIO
        $array['seccionUsuario']['usuario'] = array(
          "idUsuario" => $idUsuario,
          "nombre" => $nombre,
          "cargo" => $cargo,
          "foto" => "$foto",
        );
      }
    }
  }

  #OBTIENE DATOS DE LAS SECCIONES
  if ($action === "planner") {
    #FILTROS PARA DESTINO
    if ($idDestino == 10) {
      $filtroDestinoUsuario = "";
      $filtroDestinoIncidencias = "";
      $filtroDestinoIncidenciasGeneral = "";
    } else {
      $filtroDestinoUsuario = "and u.id_destino IN($idDestino, 10)";
      $filtroDestinoIncidencias = "and i.id_destino = $idDestino";
      $filtroDestinoIncidenciasGeneral = "and i.id_destino = $idDestino";
    }

    #OBTIENE SECCIONES CON RESUMEN DE DATOS
    $query = "SELECT
    d.id 'idDestino',
    d.destino,
    d.ubicacion,
    sec.id 'idSeccion',
    sec.seccion,
    sec.titulo_seccion,
    rel_sec.id 'idRelSeccion'
    FROM c_destinos d 
    INNER JOIN c_rel_destino_seccion rel_sec ON d.id = rel_sec.id_destino
    INNER JOIN c_secciones sec ON rel_sec.id_seccion = sec.id
    WHERE d.id = $idDestino and rel_sec.id_seccion IN($seccionesPermitidas)";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idDestino = intval($x['idDestino']);
        $destino = $x['destino'];
        $ubicacion = $x['ubicacion'];
        $idSeccion = intval($x['idSeccion']);
        $seccion = $x['seccion'];
        $tituloSeccion = $x['titulo_seccion'];

        #RELACIÓN PARA OBTENER SUBSECCIONES POR DESTINO Y SECCIÓN
        $idRelSeccion = intval($x['idRelSeccion']);

        #TOTAL POROYECTOS POR SECCIONES
        $totalProyectos = 0;
        $query = "SELECT count(id) 'total'
        FROM t_proyectos
        WHERE id_destino = $idDestino and id_seccion = $idSeccion and
        id_subseccion = 200 and status IN('N' , 'PENDIENTE', 'P') and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $totalProyectos = $x['total'];
          }
        }

        #USUARIOS ASIGNADOS A SECCIÓN
        if ($idSeccion == 1)
          $columnaSeccion = "and u.DECC = 1";
        if ($idSeccion == 8)
          $columnaSeccion = "and u.ZIA = 1";
        if ($idSeccion == 9)
          $columnaSeccion = "and u.ZIC = 1";
        if ($idSeccion == 10)
          $columnaSeccion = "and u.ZIE = 1";
        if ($idSeccion == 11)
          $columnaSeccion = "and u.ZIL = 1";
        if ($idSeccion == 19)
          $columnaSeccion = "and u.OMA = 1";
        if ($idSeccion == 23)
          $columnaSeccion = "and u.DEP = 1";
        if ($idSeccion == 24)
          $columnaSeccion = "and u.AUTO = 1";
        if ($idSeccion == 5)
          $columnaSeccion = "and u.ZHA = 1";
        if ($idSeccion == 6)
          $columnaSeccion = "and u.ZHC = 1";
        if ($idSeccion == 12)
          $columnaSeccion = "and u.ZHP = 1";
        if ($idSeccion == 7)
          $columnaSeccion = "and u.ZHH = 1";

        $usuariosSeccion = array();
        $query = "SELECT u.id, c.nombre, c.apellido, c.foto
        FROM t_users u
        INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
        WHERE u.status IN('A') and u.activo = 1 $columnaSeccion $filtroDestinoUsuario
        ORDER BY c.nombre ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idUsuarioX = intval($x['id']);
            $nombreCompleto = $x['nombre'] . " " . $x['apellido'];
            $nombre = $x['nombre'];
            $apellido = $x['apellido'];
            $foto = $x['foto'];

            #VALIDACIÓN DE FOTO
            if ($foto === "" || $foto === " ")
              $foto = "https://ui-avatars.com/api/?format=svg&rounded=false&size=300&background=2d3748&color=edf2f7&name=$nombre[0]$apellido[0]";
            else
              $foto = "$rutaAbsoluta/planner/avatars/$foto";

            $usuariosSeccion[$idUsuarioX] = array(
              "idUsuario" => $idUsuarioX,
              "usuario" => $nombreCompleto,
              "avatar" => $foto,
              "emergencia" => 0,
              "urgencia" => 0,
              "alarma" => 0,
              "alerta" => 0,
              "seguimiento" => 0,
              "totalIncidencias" => 0,
            );
          }
        }

        #SUBSECCIONES
        $subsecciones = array();
        $query = "SELECT sub.id, sub.grupo
        FROM c_rel_seccion_subseccion rel_sub
        INNER JOIN c_subsecciones sub ON rel_sub.id_subseccion = sub.id and sub.id != 200
        WHERE rel_sub.id_rel_seccion = $idRelSeccion";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idSubseccion = intval($x['id']);
            $subseccion = $x['grupo'];
            $incidenciasSubseccion = 0;
            $emergencia = 0;
            $urgencia = 0;
            $alarma = 0;
            $alerta = 0;
            $seguimiento = 0;

            #INCIDENCIAS POR SUBSECCION Y TIPO DE INCIDENCIA
            $query = "SELECT i.id, i.status, i.tipo_incidencia, i.responsable
            FROM t_mc i
            INNER JOIN t_equipos_america e ON i.id_equipo = e.id
            WHERE i.id_seccion = $idSeccion and i.id_subseccion = $idSubseccion and 
            i.status IN('PENDIENTE', 'N', 'P') and i.activo = 1 and 
            e.status NOT IN('BAJA') and e.activo = 1 $filtroDestinoIncidencias";
            if ($result = mysqli_query($conn_2020, $query)) {
              foreach ($result as $x) {
                $idIncidencia = intval($x['id']);
                $status = $x['status'];
                $tipoIncidencia = $x['tipo_incidencia'];
                $responsables = explode(', ', $x['responsable']);

                foreach ($responsables as $key => $value) {
                  if (isset($usuariosSeccion[$value])) {

                    #TOTAL DE INCIDENCIAS POR USUARIO
                    if ($tipoIncidencia == "EMERGENCIA")
                      $usuariosSeccion[$value]['emergencia'] += 1;
                    if ($tipoIncidencia == "URGENCIA")
                      $usuariosSeccion[$value]['urgencia'] += 1;
                    if ($tipoIncidencia == "ALARMA")
                      $usuariosSeccion[$value]['alarma'] += 1;
                    if ($tipoIncidencia == "ALERTA")
                      $usuariosSeccion[$value]['alerta'] += 1;
                    if ($tipoIncidencia == "SEGUIMIENTO")
                      $usuariosSeccion[$value]['seguimiento'] += 1;

                    #TOTAL DE INCIDENCIAS POR USUARIO
                    $usuariosSeccion[$value]['totalIncidencias'] += 1;
                  }
                }

                #TOTAL DE INCIDENCIAS POR SUBSECCIONES
                if ($tipoIncidencia == "EMERGENCIA") {
                  $emergencia++;
                  $incidenciasSubseccion++;
                }
                if ($tipoIncidencia == "URGENCIA") {
                  $urgencia++;
                  $incidenciasSubseccion++;
                }
                if ($tipoIncidencia == "ALARMA") {
                  $alarma++;
                  $incidenciasSubseccion++;
                }
                if ($tipoIncidencia == "ALERTA") {
                  $alerta++;
                  $incidenciasSubseccion++;
                }
                if ($tipoIncidencia == "SEGUIMIENTO") {
                  $seguimiento++;
                  $incidenciasSubseccion++;
                }
              }
            }

            #INCIDENCIAS GENERALES POR SUBSECCION Y TIPO DE INCIDENCIA
            $query = "SELECT i.id, i.status, i.tipo_incidencia, i.responsable
            FROM t_mp_np i
            WHERE i.id_seccion = $idSeccion and i.id_subseccion = $idSubseccion and 
            i.status IN('PENDIENTE', 'N', 'P') and i.activo = 1 and i.id_equipo = 0
            $filtroDestinoIncidenciasGeneral";
            if ($result = mysqli_query($conn_2020, $query)) {
              foreach ($result as $x) {
                $idIncidencia = intval($x['id']);
                $status = $x['status'];
                $tipoIncidencia = $x['tipo_incidencia'];
                $responsables = explode(', ', $x['responsable']);

                foreach ($responsables as $key => $value) {
                  if (isset($usuariosSeccion[$value])) {

                    #TOTAL POR TIPO DE INCIDENCIAS POR USUARIO
                    if ($tipoIncidencia == "EMERGENCIA")
                      $usuariosSeccion[$value]['emergencia'] += 1;
                    if ($tipoIncidencia == "URGENCIA")
                      $usuariosSeccion[$value]['urgencia'] += 1;
                    if ($tipoIncidencia == "ALARMA")
                      $usuariosSeccion[$value]['alarma'] += 1;
                    if ($tipoIncidencia == "ALERTA")
                      $usuariosSeccion[$value]['alerta'] += 1;
                    if ($tipoIncidencia == "SEGUIMIENTO")
                      $usuariosSeccion[$value]['seguimiento'] += 1;

                    #TOTAL DE INCIDENCIAS POR USUARIO
                    $usuariosSeccion[$value]['totalIncidencias'] += 1;
                  }
                }

                #TOTAL DE INCIDENCIAS POR SUBSECCIONES
                if ($tipoIncidencia == "EMERGENCIA") {
                  $emergencia++;
                  $incidenciasSubseccion++;
                }
                if ($tipoIncidencia == "URGENCIA") {
                  $urgencia++;
                  $incidenciasSubseccion++;
                }
                if ($tipoIncidencia == "ALARMA") {
                  $alarma++;
                  $incidenciasSubseccion++;
                }
                if ($tipoIncidencia == "ALERTA") {
                  $alerta++;
                  $incidenciasSubseccion++;
                }
                if ($tipoIncidencia == "SEGUIMIENTO") {
                  $seguimiento++;
                  $incidenciasSubseccion++;
                }
              }
            }

            #DATOS DE LAS SUBSECCIONES
            $subsecciones[] = array(
              "idSubseccion" => $idSubseccion,
              "subseccion" => $subseccion,
              "emergencia" => $emergencia,
              "urgencia" => $urgencia,
              "alarma" => $alarma,
              "alerta" => $alerta,
              "seguimiento" => $seguimiento,
              "incidenciasSubseccion" => $incidenciasSubseccion,
            );
          }
        }

        #TOGGLE PARA LAS SECCIONES SEGÚN DÍA DE LA SEMANA
        $toggle = false;

        if ($diaSemana == "lunes") {
          if ($idSeccion === 8 || $idSeccion === 12)
            $toggle = true;
        }

        if ($diaSemana == "martes") {
          if ($idSeccion === 9)
            $toggle = true;
        }

        if ($diaSemana == "miercoles") {
          if ($idSeccion === 1 || $idSeccion === 10)
            $toggle = true;
        }

        if ($diaSemana == "jueves") {
          if ($idSeccion === 6 || $idSeccion === 5)
            $toggle = true;
        }

        if ($diaSemana == "viernes") {
          if ($idSeccion === 11 || $idSeccion === 24)
            $toggle = true;
        }

        $arrayUsuariosSeccion = array();
        foreach ($usuariosSeccion as $x) {
          $arrayUsuariosSeccion[] = array(
            "idUsuario" => $x['idUsuario'],
            "usuario" => $x['usuario'],
            "avatar" => $x['avatar'],
            "emergencia" => $x['emergencia'],
            "urgencia" => $x['urgencia'],
            "alarma" => $x['alarma'],
            "alerta" => $x['alerta'],
            "seguimiento" => $x['seguimiento'],
            "totalIncidencias" => $x['totalIncidencias'],
          );
        }

        #ARRAY CON RESULTADOS
        $array['secciones'][$seccion] = array(
          "idDestino" => $idDestino,
          "destino" => $destino,
          "ubicacion" => $ubicacion,
          "idSeccion" => intval($idSeccion),
          "seccion" => $seccion,
          "toggle" => $toggle,
          "tituloSeccion" => $tituloSeccion,
          "proyectos" => $totalProyectos,
          "subsecciones" => $subsecciones,
          "usuariosSeccion" => $arrayUsuariosSeccion,
        );
      }
    }
  }

  #ACTUALIZAR TO DO
  if ($action === "actualizarTodo") {
    $idTodo = $_POST['idTodo'];
    $status = $_POST['status'];

    #FILTRO POR DESTINO
    if ($idDestino == 10)
      $filtroTodo = "";
    else
      $filtroTodo = "and id_destino = $idDestino";

    #TOGGLE DE STATUS TO DO
    if ($status === "PENDIENTE")
      $status = "SOLUCIONADO";
    else
      $status = "PENDIENTE";


    $query = "UPDATE t_to_do SET status = '$status', fecha_modificado = '$fechaActual'
    WHERE id = $idTodo";
    if ($result = mysqli_query($conn_2020, $query)) {
      #TODO
      $array['resp'] = "SUCCESS";
      $array['todo']['PENDIENTE'] = array();
      $array['todo']['SOLUCIONADO'] = array();
      $query = "SELECT id, descripcion, fecha_creacion, fecha_modificado, status
      FROM t_to_do
      WHERE id_usuario = $idUsuario and activo = 1 $filtroTodo";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $idTodo = intval($x['id']);
          $todo = $x['descripcion'];
          $fechaCreacion = $x['fecha_creacion'];
          $fechaModificado = $x['fecha_modificado'];
          $status = $x['status'];

          #TO DO PENDIENTES
          if ($status === "PENDIENTE") {
            #ARRAY TODO
            $array['todo']['PENDIENTE'][] = array(
              "idTodo" => $idTodo,
              "todo" => $todo,
              "fechaCreacion" => $fechaCreacion,
              "fechaModificado" => $fechaModificado,
              "status" => $status,
            );
          }

          #TO DO SOLUCIONADOS
          if ($status === "SOLUCIONADO") {
            #ARRAY TODO
            $array['todo']['SOLUCIONADO'][] = array(
              "idTodo" => $idTodo,
              "todo" => $todo,
              "fechaCreacion" => $fechaCreacion,
              "fechaModificado" => $fechaModificado,
              "status" => $status,
            );
          }
        }
      }
    }
  }

  #ACTUALIZAR TO DO
  if ($action === "eliminarTodo") {
    $idTodo = $_POST['idTodo'];

    #FILTRO POR DESTINO
    if ($idDestino == 10)
      $filtroTodo = "";
    else
      $filtroTodo = "and id_destino = $idDestino";

    $query = "UPDATE t_to_do SET activo = 0, fecha_modificado = '$fechaActual'
    WHERE id = $idTodo";
    if ($result = mysqli_query($conn_2020, $query)) {
      #TODO
      $array['resp'] = "SUCCESS";
      $array['todo']['PENDIENTE'] = array();
      $array['todo']['SOLUCIONADO'] = array();
      $query = "SELECT id, descripcion, fecha_creacion, fecha_modificado, status
      FROM t_to_do
      WHERE id_usuario = $idUsuario and activo = 1 $filtroTodo";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $idTodo = intval($x['id']);
          $todo = $x['descripcion'];
          $fechaCreacion = $x['fecha_creacion'];
          $fechaModificado = $x['fecha_modificado'];
          $status = $x['status'];

          #TO DO PENDIENTES
          if ($status === "PENDIENTE") {
            #ARRAY TODO
            $array['todo']['PENDIENTE'][] = array(
              "idTodo" => $idTodo,
              "todo" => $todo,
              "fechaCreacion" => $fechaCreacion,
              "fechaModificado" => $fechaModificado,
              "status" => $status,
            );
          }

          #TO DO SOLUCIONADOS
          if ($status === "SOLUCIONADO") {
            #ARRAY TODO
            $array['todo']['SOLUCIONADO'][] = array(
              "idTodo" => $idTodo,
              "todo" => $todo,
              "fechaCreacion" => $fechaCreacion,
              "fechaModificado" => $fechaModificado,
              "status" => $status,
            );
          }
        }
      }
    }
  }

  #ACTUALIZAR TO DO
  if ($action === "agregarTodo") {
    $descripcion = $_POST['todo'];

    #FILTRO POR DESTINO
    if ($idDestino == 10)
      $filtroTodo = "";
    else
      $filtroTodo = "and id_destino = $idDestino";

    $query = "INSERT INTO t_to_do(id_destino, id_usuario, descripcion, fecha_creacion, status, activo) 
    VALUES($idDestino, $idUsuario, '$descripcion', '$fechaActual', 'PENDIENTE', 1)";
    if ($result = mysqli_query($conn_2020, $query)) {
      #TODO
      $array['resp'] = "SUCCESS";
      $array['todo']['PENDIENTE'] = array();
      $array['todo']['SOLUCIONADO'] = array();
      $query = "SELECT id, descripcion, fecha_creacion, fecha_modificado, status
      FROM t_to_do
      WHERE id_usuario = $idUsuario and activo = 1 $filtroTodo";
      if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $x) {
          $idTodo = intval($x['id']);
          $todo = $x['descripcion'];
          $fechaCreacion = $x['fecha_creacion'];
          $fechaModificado = $x['fecha_modificado'];
          $status = $x['status'];

          #TO DO PENDIENTES
          if ($status === "PENDIENTE") {
            #ARRAY TODO
            $array['todo']['PENDIENTE'][] = array(
              "idTodo" => $idTodo,
              "todo" => $todo,
              "fechaCreacion" => $fechaCreacion,
              "fechaModificado" => $fechaModificado,
              "status" => $status,
            );
          }

          #TO DO SOLUCIONADOS
          if ($status === "SOLUCIONADO") {
            #ARRAY TODO
            $array['todo']['SOLUCIONADO'][] = array(
              "idTodo" => $idTodo,
              "todo" => $todo,
              "fechaCreacion" => $fechaCreacion,
              "fechaModificado" => $fechaModificado,
              "status" => $status,
            );
          }
        }
      }
    }
  }

  if ($action === "actualizarUsuario") {
    $idUsuario = $_POST["idUsuario"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $telegram = $_POST["telegram"];

    if ($telegram == "NO" && $telefono == "SI")
      $telegram = "";
    else
      $telegram = ", u.telegram_chat_id = '$telegram'";


    $query = "UPDATE t_users u, t_colaboradores c
    SET c.nombre = '$nombre', c.apellido = '$apellido', c.email = '$correo', c.telefono = '$telefono' $telegram
    WHERE u.id_colaborador = c.id and u.id = $idUsuario";
    if ($result = mysqli_query($conn_2020, $query)) {
      $array['resp'] = "SUCCESS";
    }
  }

  if ($action === "subirFotoUsuario") {
    $array['resp'] = "SUCCESS";

    // $rutaTemporal = $_FILES["file"]["tmp_name"];
    // $extension = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    // $foto =  "AVATAR_ID_" . $idUsuario . "_" . rand(1, 999) . ".$extension";

    // $query = "UPDATE t_users u, t_colaboradores c SET c.foto = '" . $rutaTemporal = $_FILES["file"] . "'
    //   WHERE u.id_colaborador = c.id and u.id = $idUsuario";
    // if ($result = mysqli_query($conn_2020, $query)) {
    //   $array['resp'] = "SUCCESS";
    // }
    // if (move_uploaded_file($rutaTemporal, "../planner/avatars/" . $foto)) {
    // }

  }


  #QUITA FAVORITO DE LA LISTA
  if ($action == "elimiarFavorito") {
    $idTipo = $_POST['idTipo'];
    $tipo = $_POST['tipo'];
    $array['favoritos'] = array();

    $query = "UPDATE t_favoritos SET activo = 0 WHERE id_tipo = $idTipo and tipo = '$tipo' 
    and id_usuario = $idUsuario and activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      $array['favoritos'] = obtenerFavoritos($_POST);
      $array['resp'] = "SUCCESS";
    }
  }
}

echo json_encode($array);
