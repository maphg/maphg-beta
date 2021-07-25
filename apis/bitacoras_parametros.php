<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');

# CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

# CONEXION DB
include '../php/conexion.php';

#ARRAY GLOBAL
$array = array();
$array['status'] = '404';
$array['response'] = "ERROR";

#OBTIENE EL TIPO DE PETICIÓN
$peticion = "";
if ($_SERVER['REQUEST_METHOD'])
  $peticion = $_SERVER['REQUEST_METHOD'];

#PETICIONES METODO _POST
if ($peticion === "POST") {

  #CONVERSIÓN ASOCIATIVO
  $_POST = json_decode(file_get_contents('php://input'), true);

  $idDestino = $_POST['idDestino'];
  $idUsuario = $_POST['idUsuario'];
  $action = $_POST['action'];

  #OBTIENE LAS BITACORAS
  if ($action === "bitacoras") {
    $idBitacora = $_POST['idBitacora'];

    #FILTRO DESTINO
    if ($idDestino == 10) {
      $filtroDestino = "";
      $filtroDestinos = "";
    } else {
      $filtroDestino = "and ids_destinos LIKE '%[$idDestino]%'";
      $filtroDestinos = "and id = $idDestino";
    }

    $array['response'] = 'SUCCESS';
    $array['bitacoras'] = array();

    #TIPOS DE EQUIPOS
    $array['tiposEquipos'] = array();
    $query = "SELECT id, tipo FROM c_tipos  ORDER BY tipo ASC";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idTipoEquipo = intval($x["id"]);
        $tipo = $x["tipo"];

        $array['tiposEquipos'][] = array(
          "idTipoEquipo" => $idTipoEquipo,
          "tipo" => $tipo,
        );
      }
    }

    #USUARIOS VINCULADOS A TELEGRAM
    $array['usuariosTelegram'] = array();
    $query = "SELECT u.id, c.nombre, c.apellido, d.destino
    FROM t_users AS u 
    INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
    INNER JOIN c_destinos AS d ON u.id_destino = d.id
    WHERE u.telegram_chat_id !='' and u.telegram_chat_id != ' ' and u.activo = 1 and u.status = 'A'
    ORDER BY c.nombre ASC";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idUsuario = $x['id'];
        $usuario = $x['nombre'] . " " . $x['apellido'];
        $destino = $x['destino'];

        $array['usuariosTelegram'][] = array(
          "idUsuario" => $idUsuario,
          "usuario" => $usuario,
          "destino" => $destino,
        );
      }
    }

    #SECCIONES -> SUBSECCIONES
    $array['seccionesSubsecciones'] = array();
    $query = "SELECT c.id, c.seccion
    FROM c_rel_destino_seccion AS rel
    INNER JOIN c_secciones AS c ON rel.id_seccion = c.id
    WHERE rel.id_destino = 10";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idSeccion = intval($x['id']);
        $seccion = $x['seccion'];

        $subsecciones = array();
        $query = "SELECT id, grupo FROM c_subsecciones WHERE id_seccion = $idSeccion";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idSubseccion = intval($x['id']);
            $subseccion = $x['grupo'];

            $subsecciones[] = array(
              "idSeccion" => $idSeccion,
              "seccion" => $seccion,
              "idSubseccion" => $idSubseccion,
              "subseccion" => $subseccion
            );
          }
        }

        $array['seccionesSubsecciones'][] = array(
          "idSeccion" => $idSeccion,
          "seccion" => $seccion,
          "subsecciones" => $subsecciones
        );
      }
    }

    #DESTINOS
    $array['destinos'] = array();
    $query = "SELECT id, destino FROM c_destinos WHERE id != 10 $filtroDestinos";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idDestino = intval($x['id']);
        $destino = $x['destino'];

        #ARRAY DE DESTINOS
        $array['destinos'][] = array(
          "idDestino" => $idDestino,
          "destino" => $destino,
        );
      }
    }

    #UNIDADES DE MEDIDA
    $array['unidades'] = array();
    $query = "SELECT id, medida FROM t_unidades_medidas WHERE activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idUnidad = intval($x['id']);
        $unidad = $x['medida'];

        #UNIDADES DE MEDIDA
        $array['unidades'][] = array(
          "idUnidad" => $idUnidad,
          "unidad" => $unidad,
        );
      }
    }

    $query = "SELECT id, ids_destinos, ids_tipos_equipos, ids_equipos, descripcion, fecha_inicio, 
    hora_inicio, horas, dias, semanas, meses, status
    FROM t_bitacoras_configuracion
    WHERE activo = 1 and id_publico = '$idBitacora'";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idBitacora = $x['id'];
        $descripcion = $x['descripcion'];
        $fechaInicio = $x['fecha_inicio'];
        $horaInicio = $x['hora_inicio'];
        $horas = intval($x['horas']);
        $dias = intval($x['dias']);
        $semanas = intval($x['semanas']);
        $meses = intval($x['meses']);
        $status = $x['status'];

        $caracteres = array("[", "]", "[ ", "] ");
        $idsDestinos = str_replace($caracteres, "", $x['ids_destinos']);
        $idsTiposEquipos = str_replace($caracteres, "", $x['ids_tipos_equipos']);
        $idsEquipos = str_replace($caracteres, "", $x['ids_equipos']);

        #DESTINOS
        $destinos = array();
        $query = "SELECT id, destino FROM c_destinos WHERE id IN($idsDestinos)";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idDestino = $x['id'];
            $destino = $x['destino'];

            $destinos[] = array(
              "idDestino" => $idDestino,
              "destino" => $destino
            );
          }
        }

        #TIPOS DE EQUIPOS
        $tipos = array();
        $query = "SELECT id, tipo FROM c_tipos WHERE id IN($idsTiposEquipos)";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idTipoEquipo = $x['id'];
            $tipo = $x['tipo'];

            $tipos[] = array(
              "idTipoEquipo" => $idTipoEquipo,
              "tipo" => $tipo
            );
          }
        }

        #EQUIPOS
        $equipos = array();
        $query = "SELECT id, equipo FROM t_equipos_america WHERE id IN($idsEquipos)";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idEquipo = $x['id'];
            $equipo = $x['equipo'];

            $equipos[] = array(
              "idEquipo" => $idEquipo,
              "equipo" => $equipo
            );
          }
        }

        #PARAMETROS
        $parametros = array();
        $query = "SELECT id_publico, parametro, configuracion_global, fecha_inicio, hora_inicio, horas, dias, semanas, meses, id_unidad_medida, parametro_minimo, parametro_maximo, generar_incidencia, titulo_incidencia, tipo_incidencia, notificar_telegram, notificar_ids_usuarios, fecha_creado, activo
        FROM t_bitacoras_lista_parametros
        WHERE id_bitacoras_configuracion = '$idBitacora' and activo = 1 ORDER BY fecha_creado ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
          foreach ($result as $x) {
            $idParametro = $x["id_publico"];
            $parametro = $x["parametro"];
            $configuracionGlobal = $x['configuracion_global'];
            $fechaInicio = $x['fecha_inicio'];
            $horaInicio = $x['hora_inicio'];
            $horas = intval($x['horas']);
            $dias = intval($x['dias']);
            $semanas = intval($x['semanas']);
            $meses = intval($x['meses']);
            $idUnidadMedida = $x['id_unidad_medida'];
            $parametroMinimo = $x['parametro_minimo'];
            $parametroMaximo = $x['parametro_maximo'];
            $generarIncidencia = $x['generar_incidencia'];
            $tituloIncidencia = $x['titulo_incidencia'];
            $tipoIncidencia = $x['tipo_incidencia'];
            $notificarTelegram = $x['notificar_telegram'];
            $notificarIdsUsuarios = $x['notificar_ids_usuarios'];
            $fechaCreado = $x['fecha_creado'];
            $activo = intval($x['activo']);

            #CONVIERTE EN BOOLEAN
            if ($configuracionGlobal === "true")
              $configuracionGlobal = true;
            else
              $configuracionGlobal = false;

            #CONVIERTE EN BOOLEAN
            if ($generarIncidencia === "true")
              $generarIncidencia = true;
            else
              $generarIncidencia = false;

            #CONVIERTE EN BOOLEAN
            if ($notificarTelegram === "true")
              $notificarTelegram = true;
            else
              $notificarTelegram = false;

            #USUARIOS A NOTIFICAR POT TELEGRAM
            $usuariosTelegram = array();
            $caracteres = array("[", "]", "[ ", "] ");
            $notificarIdsUsuarios = str_replace($caracteres, "", $notificarIdsUsuarios);
            $query = "SELECT u.id, c.nombre, c.apellido, d.destino
            FROM t_users AS u 
            INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
            INNER JOIN c_destinos AS d ON u.id_destino = d.id
            WHERE u.id IN($notificarIdsUsuarios)";
            if ($result = mysqli_query($conn_2020, $query)) {
              foreach ($result as $x) {
                $idUsuario = $x["id"];
                $usuario = $x['nombre'] . " " . $x['apellido'];
                $destino = $x['destino'];

                $usuariosTelegram[] = array(
                  "idUsuario" => $idUsuario,
                  "usuario" => $usuario,
                  "destino" => $destino,
                  "idParametro" => $idParametro
                );
              }
            }

            #ARRAY DE PARAMETROS
            $parametros[] = array(
              "idParametro" => $idParametro,
              "parametro" => $parametro,
              "configuracionGlobal" => $configuracionGlobal,
              "fechaInicio" => $fechaInicio,
              "horaInicio" => $horaInicio,
              "horas" => $horas,
              "dias" => $dias,
              "semanas" => $semanas,
              "meses" => $meses,
              "idUnidad" => $idUnidadMedida,
              "parametroMinimo" => $parametroMinimo,
              "parametroMaximo" => $parametroMaximo,
              "generarIncidencia" => $generarIncidencia,
              "tituloIncidencia" => $tituloIncidencia,
              "tipoIncidencia" => $tipoIncidencia,
              "notificarTelegram" => $notificarTelegram,
              "usuariosTelegram" => $usuariosTelegram,
              "activo" => $activo,
              "change" => 0,
            );
          }
        }

        #ARRAY DE RESULTADOS
        $array['bitacoras'][] = array(
          "idBitacora" => $idBitacora,
          "descripcion" => $descripcion,
          "fechaInicio" => $fechaInicio,
          "horaInicio" => $horaInicio,
          "repetir" => 0,
          "parametros" => $parametros,
          "destinos" => $destinos,
          "tipos" => $tipos,
          "equipos" => $equipos,
          "horas" => $horas,
          "dias" => $dias,
          "semanas" => $semanas,
          "meses" => $meses,
          "status" => $status,
        );
      }
    }
  }

  #ACTUALIZA COLUMNAS DE LA BITACORA
  if ($action === "actualizarBitacora") {
    $idBitacora = $_POST['idBitacora'];
    $opcion = $_POST['opcion'];
    $value = $_POST['value'];

    #ACTUALIZA LA DESCRIPCION DE LA BITACORA
    if ($opcion == "descripcion") {
      $query = "UPDATE t_bitacoras_configuracion SET descripcion = '$value'
      WHERE id_publico = '$idBitacora'";
      if ($result = mysqli_query($conn_2020, $query)) {
        $array['response'] = "SUCCESS";
      }
    }

    #ACTUALIZA FECHA DE INICIO DE LA BITACORA
    if ($opcion == "fechaInicio") {
      $query = "UPDATE t_bitacoras_configuracion SET fecha_inicio = '$value'
      WHERE id_publico = '$idBitacora'";
      if ($result = mysqli_query($conn_2020, $query)) {
        $array['response'] = "SUCCESS";
      }
    }

    #ACTUALIZA HORA DE INICIO DE LA BITACORA
    if ($opcion == "horaInicio") {
      $query = "UPDATE t_bitacoras_configuracion SET hora_inicio = '$value'
      WHERE id_publico = '$idBitacora'";
      if ($result = mysqli_query($conn_2020, $query)) {
        $array['response'] = "SUCCESS";
      }
    }

    #ACTUALIZA HORA DE INICIO DE LA BITACORA
    if (($opcion == "horas" || $opcion == "dias" || $opcion == "semanas" || $opcion == "meses") && $value >= 0) {
      $query = "UPDATE t_bitacoras_configuracion SET $opcion = '$value'
      WHERE id_publico = '$idBitacora'";
      if ($result = mysqli_query($conn_2020, $query)) {
        $array['response'] = "SUCCESS";
      }
    }

    #ACTUALIZA HORA DE INICIO DE LA BITACORA
    if (($opcion == "status") && ($value === 'ACTIVADO' || $value === 'DESACTIVADO')) {
      $query = "UPDATE t_bitacoras_configuracion SET status = '$value'
      WHERE id_publico = '$idBitacora'";
      if ($result = mysqli_query($conn_2020, $query)) {
        $array['response'] = "SUCCESS";
      }
    }
  }

  #OBTENER EQUIPOS POR SECCION Y SUBSECCION
  if ($action === "equipos") {
    $idSeccion = $_POST['idSeccion'];
    $idSubseccion = $_POST['idSubseccion'];

    $array['equipos'] = array();
    $query = "SELECT e.id, e.equipo, d.id 'idDestino', d.destino
    FROM t_equipos_america AS e
    INNER JOIN c_destinos AS d ON e.id_destino = d.id
    WHERE e.id_seccion = $idSeccion and e.id_subseccion = $idSubseccion and e.status IN('OPERATIVO') and e.activo = 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      $array['response'] = "SUCCESS";
      foreach ($result as $x) {
        $idEquipo = intval($x['id']);
        $equipo = $x['equipo'];
        $idDestino = intval($x['idDestino']);
        $destino = $x['destino'];

        $array['equipos'][] = array(
          "idEquipo" => $idEquipo,
          "equipo" => $equipo,
          "idDestino" => $idDestino,
          "destino" => $destino,
        );
      }
    }
  }

  #AGREGAR TIPO EQUIPO
  if ($action === "agregarTipoEquipo") {
    $idBitacora = $_POST['idBitacora'];
    $idTipoEquipo = $_POST['idTipoEquipo'];

    $query = "SELECT ids_tipos_equipos FROM t_bitacoras_configuracion
    WHERE id_publico = '$idBitacora' LIMIT 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idsTiposEquipos = trim($x['ids_tipos_equipos']);

        #AGREGA NUEVO TIPO EQUIPO
        if ($idsTiposEquipos == "") {
          $idsTiposEquipos = array("[$idTipoEquipo]");
        } else {
          $idsTiposEquipos = preg_split("/[\s,]+/", $idsTiposEquipos);
          $idsTiposEquipos[] = "[$idTipoEquipo]";
        }

        #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
        if (count($idsTiposEquipos) > 0) {
          $idsTiposEquipos = implode(", ", $idsTiposEquipos);
        } else {
          $idsTiposEquipos = implode("", $idsTiposEquipos);
        }

        $query = "UPDATE t_bitacoras_configuracion SET ids_tipos_equipos = '$idsTiposEquipos'
        WHERE id_publico = '$idBitacora'";
        if ($result = mysqli_query($conn_2020, $query)) {
          $array['response'] = "SUCCESS";
        }
      }
    }
  }

  #ELIMINAR TIPO EQUIPO
  if ($action === "eliminarTipoEquipo") {
    $idBitacora = $_POST['idBitacora'];
    $idTipoEquipo = $_POST['idTipoEquipo'];

    $query = "SELECT ids_tipos_equipos FROM t_bitacoras_configuracion
    WHERE id_publico = '$idBitacora' LIMIT 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idsTiposEquipos = $x['ids_tipos_equipos'];
        $idsTiposEquipos = preg_split("/[\s,]+/", $idsTiposEquipos);

        #ELIMINA EL TIPO EQUIPO
        foreach ($idsTiposEquipos as $key => $value) {
          if ($value === "[$idTipoEquipo]") {
            unset($idsTiposEquipos[$key]);
          }
        }

        #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
        $idsTiposEquipos = implode(",", $idsTiposEquipos);
        $array['x'] = $idsTiposEquipos;

        $query = "UPDATE t_bitacoras_configuracion SET ids_tipos_equipos = '$idsTiposEquipos'
        WHERE id_publico = '$idBitacora'";
        if ($result = mysqli_query($conn_2020, $query)) {
          $array['response'] = "SUCCESS";
        }
      }
    }
  }

  #AGREGAR EQUIPO A LA BITACORA
  if ($action === "agregarEquipo") {
    $idBitacora = $_POST['idBitacora'];
    $idEquipo = $_POST['idEquipo'];

    $query = "SELECT ids_equipos
    FROM t_bitacoras_configuracion
    WHERE id_publico = '$idBitacora' LIMIT 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idsEquipos = trim($x['ids_equipos']);

        #AGREGA NUEVO TIPO EQUIPO
        if ($idsEquipos == "") {
          $idsEquipos = array("[$idEquipo]");
        } else {
          $idsEquipos = preg_split("/[\s,]+/", $idsEquipos);
          $idsEquipos[] = "[$idEquipo]";
        }

        #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
        if (count($idsEquipos) > 0) {
          $idsEquipos = implode(", ", $idsEquipos);
        } else {
          $idsEquipos = implode("", $idsEquipos);
        }

        $query = "UPDATE t_bitacoras_configuracion SET ids_equipos = '$idsEquipos'
        WHERE id_publico = '$idBitacora'";
        if ($result = mysqli_query($conn_2020, $query)) {
          $array['response'] = "SUCCESS";
        }
      }
    }
  }

  #ELIMINAR TIPO EQUIPO
  if ($action === "eliminarEquipo") {
    $idBitacora = $_POST['idBitacora'];
    $idEquipo = $_POST['idEquipo'];

    $query = "SELECT ids_equipos
    FROM t_bitacoras_configuracion
    WHERE id_publico = '$idBitacora' LIMIT 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idsEquipos = $x['ids_equipos'];
        $idsEquipos = preg_split("/[\s,]+/", $idsEquipos);

        #ELIMINA EL TIPO EQUIPO
        foreach ($idsEquipos as $key => $value) {
          if ($value === "[$idEquipo]") {
            unset($idsEquipos[$key]);
          }
        }

        #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
        $idsEquipos = implode(",", $idsEquipos);
        $array['x'] = $idsEquipos;

        $query = "UPDATE t_bitacoras_configuracion SET ids_equipos = '$idsEquipos'
        WHERE id_publico = '$idBitacora'";
        if ($result = mysqli_query($conn_2020, $query)) {
          $array['response'] = "SUCCESS";
        }
      }
    }
  }

  #AGREGAR DESTINO A LA BITACORA
  if ($action === "agregarDestino") {
    $idBitacora = $_POST['idBitacora'];
    $idDestino = $_POST['idDestino'];

    $query = "SELECT ids_destinos
    FROM t_bitacoras_configuracion
    WHERE id_publico = '$idBitacora' LIMIT 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idsDestinos = trim($x['ids_destinos']);

        #AGREGA NUEVO TIPO EQUIPO
        if ($idsDestinos == "") {
          $idsDestinos = array("[$idDestino]");
        } else {
          $idsDestinos = preg_split("/[\s,]+/", $idsDestinos);
          $idsDestinos[] = "[$idDestino]";
        }

        #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
        if (
          count($idsDestinos) > 0
        ) {
          $idsDestinos = implode(", ", $idsDestinos);
        } else {
          $idsDestinos = implode("", $idsDestinos);
        }

        $query = "UPDATE t_bitacoras_configuracion SET ids_destinos = '$idsDestinos'
        WHERE id_publico = '$idBitacora'";
        if ($result = mysqli_query($conn_2020, $query)) {
          $array['response'] = "SUCCESS";
        }
      }
    }
  }


  #ELIMINA DESTINO DE LA BITACORA
  if ($action === "eliminarDestino") {
    $idBitacora = $_POST['idBitacora'];
    $idDestino = $_POST['idDestino'];

    $query = "SELECT ids_destinos
    FROM t_bitacoras_configuracion
    WHERE id_publico = '$idBitacora' LIMIT 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idsDestinos = $x['ids_destinos'];
        $idsDestinos = preg_split("/[\s,]+/", $idsDestinos);

        #ELIMINA EL TIPO EQUIPO
        foreach ($idsDestinos as $key => $value) {
          if ($value === "[$idDestino]") {
            unset($idsDestinos[$key]);
          }
        }

        #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
        $idsDestinos = implode(",", $idsDestinos);
        $array['x'] = $idsDestinos;

        $query = "UPDATE t_bitacoras_configuracion SET ids_destinos = '$idsDestinos'
        WHERE id_publico = '$idBitacora'";
        if ($result = mysqli_query($conn_2020, $query)) {
          $array['response'] = "SUCCESS";
        }
      }
    }
  }

  #AGREGAR PARAMETRO A BITACORA
  if ($action === "agregarParametro") {
    $idBitacora = $_POST['idBitacora'];
    $idParametro = $_POST['idParametro'];
    $parametro = $_POST['parametro'];

    $query = "INSERT INTO t_bitacoras_lista_parametros(id_publico, id_destino, creado_por, id_bitacoras_configuracion, parametro, configuracion_global, generar_incidencia, notificar_telegram, fecha_creado, activo)
    VALUES('$idParametro', $idDestino, $idUsuario, '$idBitacora', '$parametro', 'true', 'false', 'false', '$fechaActual',  1)";
    if ($result = mysqli_query($conn_2020, $query)) {
      $array['response'] = "SUCCESS";
    }
  }


  #ACTUALIZA DATOS DE LOS PARAMETROS
  if ($action === "actualizarParametro") {
    $idParametro = $_POST['idParametro'];
    $parametro = $_POST['parametro'];
    $idUnidad = $_POST['idUnidad'];
    $configuracionGlobal = $_POST['configuracionGlobal'];
    $fechaInicio = $_POST['fechaInicio'];
    $horaInicio = $_POST['horaInicio'];
    $horas = $_POST['horas'];
    $dias = $_POST['dias'];
    $semanas = $_POST['semanas'];
    $meses = $_POST['meses'];
    $parametroMinimo = $_POST['parametroMinimo'];
    $parametroMaximo = $_POST['parametroMaximo'];
    $generarIncidencia = $_POST['generarIncidencia'];
    $tituloIncidencia = $_POST['tituloIncidencia'];
    $tipoIncidencia = $_POST['tipoIncidencia'];
    $activo = $_POST['activo'];

    if ($configuracionGlobal === true || $configuracionGlobal === 'true')
      $configuracionGlobal = 'true';
    else
      $configuracionGlobal = 'false';

    if ($generarIncidencia === true || $generarIncidencia === 'true')
      $generarIncidencia = 'true';
    else
      $generarIncidencia = 'false';

    $query = "UPDATE t_bitacoras_lista_parametros SET
    parametro = '$parametro',
    id_unidad_medida = '$idUnidad',
    configuracion_global = '$configuracionGlobal',
    fecha_inicio = '$fechaInicio',
    hora_inicio = '$horaInicio',
    horas = '$horas',
    dias = '$dias',
    semanas = '$semanas',
    meses = '$meses',
    parametro_minimo = '$parametroMinimo',
    parametro_maximo = '$parametroMaximo',
    generar_incidencia = '$generarIncidencia',
    titulo_incidencia = '$tituloIncidencia',
    tipo_incidencia = '$tipoIncidencia',
    notificar_telegram = '$generarIncidencia',
    fecha_modificado = '$fechaActual',
    modificado_por = '$idUsuario',
    activo = '$activo'
    WHERE id_publico = '$idParametro'";
    if ($result = mysqli_query($conn_2020, $query)) {
      $array['response'] = "SUCCESS";
    }
    $array['POST'] = $_POST;
  }

  #AGREGAR DESTINO A LA BITACORA
  if ($action === "agregarUsuarioTelegram") {
    $idParametro = $_POST['idParametro'];
    $idUsuario = $_POST['idUsuario'];

    $query = "SELECT notificar_ids_usuarios
    FROM t_bitacoras_lista_parametros
    WHERE id_publico = '$idParametro' LIMIT 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idsUsuarios = trim($x['notificar_ids_usuarios']);

        #AGREGA NUEVO TIPO EQUIPO
        if ($idsUsuarios == "") {
          $idsUsuarios = array("[$idUsuario]");
        } else {
          $idsUsuarios = preg_split("/[\s,]+/", $idsUsuarios);
          $idsUsuarios[] = "[$idUsuario]";
        }

        #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
        if (
          count($idsUsuarios) > 0
        ) {
          $idsUsuarios = implode(", ", $idsUsuarios);
        } else {
          $idsUsuarios = implode("", $idsUsuarios);
        }

        $query = "UPDATE t_bitacoras_lista_parametros SET notificar_ids_usuarios = '$idsUsuarios'
        WHERE id_publico = '$idParametro'";
        if ($result = mysqli_query($conn_2020, $query)) {
          $array['response'] = "SUCCESS";

          $query = "SELECT u.telegram_chat_id, c.nombre
          FROM t_users AS u
          INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
          WHERE u.id = $idUsuario LIMIT 1";
          if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
              $idTelegram = $x['telegram_chat_id'];
              $nombre = $x['nombre'];

              $url = "https://api.telegram.org/bot1652304972:AAETvxYiru38gHZ0nnx3DURU_583HULYKYI/sendMessage?chat_id=$idTelegram&text=Hola $nombre, Te han Activado las Notificaciones para las Bitacoras!";
              file_get_contents($url);
            }
          }
        }
      }
    }
  }

  #ELIMINA DESTINO DE LA BITACORA
  if ($action === "eliminarUsuarioTelegram") {
    $idParametro = $_POST['idParametro'];
    $idUsuario = $_POST['idUsuario'];

    $query = "SELECT notificar_ids_usuarios
    FROM t_bitacoras_lista_parametros
    WHERE id_publico = '$idParametro' LIMIT 1";
    if ($result = mysqli_query($conn_2020, $query)) {
      foreach ($result as $x) {
        $idsUsuariosTelegram = $x['notificar_ids_usuarios'];
        $idsUsuariosTelegram = preg_split("/[\s,]+/", $idsUsuariosTelegram);

        #ELIMINA EL TIPO EQUIPO
        foreach ($idsUsuariosTelegram as $key => $value) {
          if ($value === "[$idUsuario]") {
            unset($idsUsuariosTelegram[$key]);
          }
        }

        #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
        $idsUsuariosTelegram = implode(",", $idsUsuariosTelegram);
        $array['x'] = $idsUsuariosTelegram;

        $query = "UPDATE t_bitacoras_lista_parametros
        SET notificar_ids_usuarios = '$idsUsuariosTelegram'
        WHERE id_publico = '$idParametro'";
        if ($result = mysqli_query($conn_2020, $query)) {
          $array['response'] = "SUCCESS";

          $query = "SELECT u.telegram_chat_id, c.nombre
          FROM t_users AS u
          INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
          WHERE u.id = $idUsuario LIMIT 1";
          if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
              $idTelegram = $x['telegram_chat_id'];
              $nombre = $x['nombre'];

              $url = "https://api.telegram.org/bot1652304972:AAETvxYiru38gHZ0nnx3DURU_583HULYKYI/sendMessage?chat_id=$idTelegram&text=Hola $nombre, Te han Desactivado las Notificaciones para las Bitacoras!";
              file_get_contents($url);
            }
          }

        }
      }
    }
  }
}

#FUNCIONES
function obtenerBitacora($idBitacora)
{
  $bitacora = array();

  #BITACORA
  $query = "SELECT id
  FROM t_bitacoras_configuracion_parametros
  WHERE id = '$idBitacora'";
  if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
    foreach ($result as $x) {
      $idParametro = intval($x['id']);

      $parametros[] = array(
        "idParametro" => $idParametro,
      );
    }
  }

  return $bitacora;
}

echo json_encode($array);
