<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');

# CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

# CONEXION DB
include '../php/conexion.php';

$rutaAbsoluta = "";
if (strpos($_SERVER['REQUEST_URI'], "america") == true)
  $rutaAbsoluta = "https://www.maphg.com/america";
if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
  $rutaAbsoluta = "https://www.maphg.com/europa";
if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
  $rutaAbsoluta = "https://www.maphg.com/america";

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
      $filtroDestinoIncidencias = "and id_destino = $idDestino";
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


    #TODO
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

        $query = "SELECT id, actividad, tipo_incidencia, responsable, status, rango_fecha
        FROM t_mc
        WHERE responsable LIKE '%$idUsuario%' and activo = 1 and
        id_seccion IN($seccionesPermitidas) $filtroDestinoIncidencias";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idIncidencia = intval($x['id']);
            $incidencia = $x['actividad'];
            $tipoIncidencia = $x['tipo_incidencia'];
            $status = $x['status'];
            $rangoFecha = $x['rango_fecha'];
            $responsable = explode(", ", $x['responsable']);

            if (in_array($idUsuario, $responsable, true)) {

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
                );
              }

              #INCIDENCIAS SOLUCIONADAS
              if ($status === "SOLUCIONADO") {
                $incidencias['solucionadas'][] = array(
                  "idRegistro" => $idIncidencia,
                  "titulo" => $incidencia,
                  "tipo" => $tipoIncidencia,
                );
              }

              #INCIDENCIAS SIN PROGRAMAR (RANGO FECHA)
              if (($rangoFecha === "" || $rangoFecha === null) && $status === "PENDIENTE") {
                $incidencias['sinprogramar'][] = array(
                  "idRegistro" => $idIncidencia,
                  "titulo" => $incidencia,
                  "tipo" => $tipoIncidencia,
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

        $query = "SELECT mp.id, mp.id_responsables, mp.status, mp.fecha_programada, plan.tipo_plan, e.equipo
        FROM t_mp_planificacion_iniciada mp
        INNER JOIN t_mp_planes_mantenimiento plan ON mp.id_plan = plan.id
        INNER JOIN t_equipos_america e ON mp.id_equipo = e.id
        WHERE mp.id_responsables LIKE '%$idUsuario%' and mp.activo = 1 and e.id_seccion IN($seccionesPermitidas) $filtroDestinoMP";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idMP = intval($x['id']);
            $tipoPlan = $x['tipo_plan'];
            $equipo = $x['equipo'];
            $status = $x['status'];
            $fechaProgramada = $x['fecha_programada'];
            $responsable = explode(", ", $x['id_responsables']);

            if (in_array($idUsuario, $responsable, true)) {
              $totalPreventivos++;

              #MP EN PROCESO
              if ($status === "PROCESO") {
                $preventivos['pendientes'][] =
                  array(
                    "idRegistro" => $idMP,
                    "titulo" => $idMP . " ☛ " . $equipo,
                    "tipo" => "MP"
                  );
              }

              #MP SIN PROGRAMAR
              if (($fechaProgramada === "" || $fechaProgramada === null) && $status === "PROCESO") {
                $preventivos['sinprogramar'][] =
                  array(
                    "idRegistro" => $idMP,
                    "titulo" => $idMP . " ☛ " . $equipo,
                    "tipo" => "MP"
                  );
              }

              #MP ESTA SEMANA
              if (($fechaProgramada === "" || $fechaProgramada === null) && $status === "PROCESO") {
                $preventivos['estasemana'][] =
                  array(
                    "idRegistro" => $idMP,
                    "titulo" => $idMP . " ☛ " . $equipo,
                    "tipo" => "MP"
                  );
              }

              #MP PROXIMOS
              if (($fechaProgramada === "" || $fechaProgramada === null) && $status === "PROCESO") {
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
        a.status, a.responsable, a.rango_fecha
        FROM t_proyectos p
        INNER JOIN t_proyectos_planaccion a ON p.id = a.id_proyecto
        WHERE a.responsable LIKE '%$idUsuario%' and p.activo = 1 and a.activo = 1 and 
        p.id_seccion IN($seccionesPermitidas) $filtroDestinoProyectos";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idProyecto = $x['idProyecto'];
            $idPlanaccion = $x['idPlanaccion'];
            $actividad = $x['actividad'];
            $status = $x['status'];
            $rangoFecha = $x['rango_fecha'];
            $responsable = explode(", ", $x['responsable']);

            if ($status === "N" or $status == "PENDIENTE" or $status == "P")
              $status = "PENDIENTE";
            else
              $status = "SOLUCIONADO";

            if (in_array($idUsuario, $responsable, true)) {
              $totalTareasproyectos++;

              #PLANACCION EN PROCESO
              if ($status == "PENDIENTE") {
                $tareasproyectos['enproceso'][] =
                  array(
                    "idRegistro" => $idProyecto,
                    "titulo" => $actividad,
                    "tipo" => "PDA"
                  );
              }

              #PLANACCION SIN PROGRAMAR
              if ($status == "PENDIENTE" && ($rangoFecha === "" || $rangoFecha === null)) {
                $tareasproyectos['sinprogramar'][] =
                  array(
                    "idRegistro" => $idProyecto,
                    "titulo" => $actividad,
                    "tipo" => "PDA"
                  );
              }

              #PLANACCION SOLUCIONADAS
              if ($status == "SOLUCIONADO") {
                $tareasproyectos['solucionadas'][] =
                  array(
                    "idRegistro" => $idProyecto,
                    "titulo" => $actividad,
                    "tipo" => "PDA"
                  );
              }
            }
          }
        }

        $todos[] = array("titulo" => "xx", "tipo" => "");

        #FAVORITOS
        $favoritos['favoritos'] = array();

        $query = "SELECT id, tipo, url, descripcion
        FROM t_favoritos
        WHERE id_usuario = $idUsuario and activo = 1 $filtroFavoritos";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idRegistro = $x['id'];
            $tipo = $x['tipo'];
            $url = $x['url'];
            $descripcion = $x['descripcion'];

            $favoritos['favoritos'][] =
              array(
                "idRegistro" => $idRegistro,
                "titulo" => $tipo . " 👉 " . $descripcion,
                "tipo" => "favorito"
              );
          }
        }

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
          "preventivos" => array($preventivos),
          "tareasproyectos" => array($tareasproyectos),
          "todos" => $todos,
          "favoritos" => $favoritos,
          "incidencias" => array($incidencias),
        );

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

        #ARRAY CON RESULTADOS
        $array['secciones'][$seccion] = array(
          "idDestino" => $idDestino,
          "destino" => $destino,
          "ubicacion" => $ubicacion,
          "idSeccion" => intval($idSeccion),
          "seccion" => $seccion,
          "toggle" => false,
          "tituloSeccion" => $tituloSeccion,
          "proyectos" => $totalProyectos,
          "subsecciones" => $subsecciones,
          "usuariosSeccion" => $usuariosSeccion,
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
    $array['file'] = json_encode($_POST);

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
}
echo json_encode($array);
