<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

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
  if ($action == "usuario") {

    #FILTRO PARA LIMITAR DESTINOS
    if ($idDestino == 10) {
      $filtroDestinoIncidencias = "";
      $filtroDestinoMP = "";
      $filtroDestinoProyectos = "";
      $filtroFavoritos = "";
      $filtroActivos = "";
    } else {
      $filtroDestinoIncidencias = "and id_destino = $idDestino";
      $filtroDestinoMP = "and e.id_destino = $idDestino";
      $filtroDestinoProyectos = "and p.id_destino = $idDestino";
      $filtroFavoritos = "and id_destino = $idDestino";
      $filtroActivos = "and id_destino = $idDestino";
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
    $query = "SELECT c.nombre, c.apellido, c.foto, cargo.cargo
    FROM t_users u
    INNER JOIN t_colaboradores c ON u.id_colaborador = c.id
    INNER JOIN c_cargos cargo ON c.id_cargo = cargo.id
    WHERE u.id = $idUsuario";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $nombre = $x['nombre'] . " " . $x['apellido'];
        $cargo = $x['cargo'];
        $foto = $x['foto'];
        $fotox = $x['foto'];
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

        #VALIDACIÓN DE FOTO
        if ($foto == "")
          $foto = "$rutaAbsoluta/planner/avatars/AVATAR_ID_0_0.svg";
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
          "nombre" => $nombre,
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
  if ($action == "planner") {

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
            $nombre = $x['nombre'] . " " . $x['apellido'];
            $foto = $x['foto'];

            #VALIDACIÓN DE FOTO
            if ($foto == "")
              $foto = "$rutaAbsoluta/planner/avatars/AVATAR_ID_0_0.svg";
            else
              $foto = "$rutaAbsoluta/planner/avatars/$foto";
            $usuariosSeccion[$idUsuarioX] = array(
              "idUsuario" => $idUsuarioX,
              "usuario" => $nombre,
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
}
echo json_encode($array);
