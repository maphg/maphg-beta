<?php
# ZONA HORARIA
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
$fechaActual = date('Y-m-d H:m:s');
$caracteres = array("[", "]", "[ ", "] ");

# CABECERA PARA JSON
header("Access-Control-Allow-Origin: *");

# CONEXION DB
include '../php/conexion.php';

#RUTA ABSOLUTA PARA ENLACES
$rutaAbsoluta = "";

if (strpos($_SERVER['REQUEST_URI'], "america") == true) {
    $rutaAbsoluta = "https://www.maphg.com/america";
}


if (strpos($_SERVER['REQUEST_URI'], "europa") == true) {
    $rutaAbsoluta = "https://www.maphg.com/europa";
}


if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true) {
    $rutaAbsoluta = "https://www.maphg.com/america";
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


#NOTIFICACIONES TELEGRAM
function notificarTelegram($msj, $idsUsuarios)
{
    $query = "SELECT u.telegram_chat_id, c.nombre
    FROM t_users AS u
    INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
    WHERE u.id IN($idsUsuarios)";
    if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
            $idTelegram = $x['telegram_chat_id'];
            $nombre = $x['nombre'];

            try {
                $url = "https://api.telegram.org/bot1652304972:AAETvxYiru38gHZ0nnx3DURU_583HULYKYI/sendMessage?chat_id=$idTelegram&text=𝗛𝗼𝗹𝗮, $nombre, $msj";
                if (file_get_contents($url))
                    $response = "OK";
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}


#CREAR INCIDENCIA
function crearIncidencia($idEquipo, $idIncidencia, $creadoPor, $tituloIncidencia, $tipoIncidencia)
{

    #OBTIENE DATOS COMPLEMENTARIOS PARA LA INCIDENCIA
    $fechaActual = date('Y-m-d H:m:s');
    $idDestino = 0;
    $idSeccion = 0;
    $idSubseccion = 0;
    $query = "SELECT id_destino, id_seccion, id_subseccion FROM t_equipos_america WHERE id = $idEquipo";
    if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        foreach ($result as $x) {
            $idDestino = $x['id_destino'];
            $idSeccion = $x['id_seccion'];
            $idSubseccion = $x['id_subseccion'];
        }
    }

    #CREACIÓN DE INCIDENCIA
    $query = "INSERT INTO t_mc(id, id_equipo, actividad, tipo_incidencia, status, creado_por, fecha_creacion, id_destino, id_seccion, id_subseccion, activo) VALUES($idIncidencia, $idEquipo, '$tituloIncidencia', '$tipoIncidencia', 'PENDIENTE', $creadoPor, '$fechaActual', $idDestino, $idSeccion, $idSubseccion, 1)";
    if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
        $response = true;
    }
}


#ARRAY GLOBAL
$array = array();
$array['status'] = '505';
$array['response'] = "ERROR";
$array['message'] = "";
$array['conexion'] = false;


#OBTIENE EL TIPO DE PETICIÓN
$peticion = "";
if ($_SERVER['REQUEST_METHOD']) {
    $peticion = $_SERVER['REQUEST_METHOD'];
}


#PETICIONES METODO _POST
if ($peticion === "POST") {

    #CONVERSIÓN ASOCIATIVO
    $_POST = json_decode(file_get_contents('php://input'), true);

    $idDestino = $_POST['idDestino'];
    $idUsuario = $_POST['idUsuario'];
    $action = $_POST['action'];

    #CONEXION
    if ($action === "conexion") {
        $array['response'] = "SUCCESS";
        $array['message'] = "Conexión Exitosa!";
        $array['conexion'] = true;
    }

    #OBTIENE EL LISTADO DE LAS BITACORAS
    if ($action === "listadoBitacoras") {
        $array['response'] = "SUCCESS";
        $array['listadoBitacoras'] = array();

        if (10 == $idDestino) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and ids_destinos LIKE '%[$idDestino]%'";
        }

        $query = "SELECT b.id_publico, b.descripcion, b.ids_destinos, b.ids_tipos_equipos, b.fecha_creado,
        b.status, c.nombre, c.apellido
        FROM t_bitacoras_configuracion AS b
        INNER JOIN t_users AS u ON b.creado_por = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE b.activo = 1 $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idBitacora = $x['id_publico'];
                $descripcion = $x['descripcion'];
                $fechaCreado = $x['fecha_creado'];
                $creadoPor = $x['nombre'] . " " . $x['apellido'];
                $status = $x['status'];

                $idsDestinos = str_replace($caracteres, "", $x['ids_destinos']);
                $idsTiposEquipos = str_replace($caracteres, "", $x['ids_tipos_equipos']);

                #DESTINOS
                $destinos = array();
                $query = "SELECT id, destino FROM c_destinos WHERE id IN($idsDestinos)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idDestinox = intval($x['id']);
                        $destino = $x['destino'];

                        $destinos[] = $destino;
                    }
                }

                #TIPOS DE EQUIPOS
                $tiposEquipos = array();
                $query = "SELECT id, tipo FROM c_tipos WHERE id IN($idsTiposEquipos)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idTipo = intval($x['id']);
                        $tipo = $x['tipo'];

                        $tiposEquipos[] = $tipo;
                    }
                }

                $array['listadoBitacoras'][] = array(
                    "idBitacora" => $idBitacora,
                    "descripcion" => $descripcion,
                    "creadoPor" => $creadoPor,
                    "fechaCreado" => $fechaCreado,
                    "destinos" => $destinos,
                    "tiposEquipos" => $tiposEquipos,
                    "status" => $status,
                );
            }
        }
    }


    #AGREGA BITACORA CON VALORES DEFAULT
    if ($action === "agregarBitacora") {
        $idBitacora = $_POST['idBitacora'];

        if (10 == $idDestino) {
            $idsDestinos = "";
        } else {
            $idsDestinos = "[$idDestino]";
        }

        $query = "INSERT INTO t_bitacoras_configuracion(id_publico, creado_por, ids_destinos, descripcion, status, fecha_creado, activo) VALUES('$idBitacora', $idUsuario, '$idsDestinos', '', 'DESACTIVADO', '$fechaActual', 0)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $array['response'] = "SUCCESS";
            $array['message'] = "Bitácora Creada!";
        }
    }


    #OBTIENE DATOS DE LA BITACORA
    if ($action === "bitacora") {
        $idBitacora = $_POST['idBitacora'];

        #FILTRO DESTINO
        if (10 == $idDestino) {
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
        WHERE u.telegram_chat_id !='' and u.telegram_chat_id != ' ' and 
        u.activo IN(1) and u.status = 'A'
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
        WHERE rel.id_destino = 10 and c.id NOT IN(19, 23, 1001)";
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
                            "subseccion" => $subseccion,
                        );
                    }
                }

                $array['seccionesSubsecciones'][] = array(
                    "idSeccion" => $idSeccion,
                    "seccion" => $seccion,
                    "subsecciones" => $subsecciones,
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

        $array['usuariosPermitidos'] = array();

        $query = "SELECT id_publico, ids_destinos, ids_usuarios, ids_tipos_equipos, ids_equipos, descripcion, fecha_inicio,
        hora_inicio, horas, dias, semanas, meses, status
        FROM t_bitacoras_configuracion
        WHERE activo IN(0, 1) and id_publico = '$idBitacora'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idBitacora = $x['id_publico'];
                $descripcion_bitacora = $x['descripcion'];
                $fechaInicio_bitacora = $x['fecha_inicio'];
                $horaInicio_bitacora = $x['hora_inicio'];
                $horas_bitacora = intval($x['horas']);
                $dias_bitacora = intval($x['dias']) > 0 ? $x['dias'] / 24 : 0;
                $semanas_bitacora = intval($x['semanas']) > 0 ? $x['semanas'] / 168 : 0;
                $meses_bitacora = intval($x['meses']) > 0 ? $x['meses'] / 730 : 0;
                $status_bitacora = $x['status'];

                $idsDestinos = str_replace($caracteres, "", $x['ids_destinos']);
                $idsUsuarios = str_replace($caracteres, "", $x['ids_usuarios']);
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
                            "destino" => $destino,
                        );
                    }
                }

                #USUARIOS
                $usuarios = array();
                $query = "SELECT u.id, c.nombre, c.apellido
                FROM t_users AS u
                INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
                WHERE u.id IN($idsUsuarios)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idUsuariosX = $x['id'];
                        $usuario = $x['nombre'] . " " . $x['apellido'];

                        $usuarios[] = array(
                            "idUsuario" => $idUsuariosX,
                            "idBitacora" => $idBitacora,
                            "usuario" => $usuario,
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
                            "tipo" => $tipo,
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
                            "equipo" => $equipo,
                        );
                    }
                }

                #USUARIOS PERMITIDOS EN LA BITACORA
                $query = "SELECT u.id, cargo.cargo, c.foto, c.nombre, c.apellido, d.destino
                FROM t_users AS u
                INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
                INNER JOIN c_destinos AS d ON u.id_destino = d.id
                INNER JOIN c_cargos AS cargo ON c.id_cargo = cargo.id
                WHERE (u.id_destino IN($idsDestinos) || u.id_destino = 10) and u.status = 'A' and u.activo = 1
                ORDER BY c.nombre ASC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idUsuarioX = $x['id'];
                        $usuario = $x['nombre'] . " " . $x['apellido'];
                        $nombre = $x['nombre'];
                        $apellido = $x['apellido'];
                        $destino = $x['destino'];
                        $cargo = $x['cargo'];
                        $avatar = $x['foto'];

                        #VALIDACIÓN DE FOTO
                        if ("" === $avatar || " " === $avatar) {
                            $avatar = "https://ui-avatars.com/api/?format=svg&rounded=false&size=300&background=2d3748&color=edf2f7&name=$nombre[0]$apellido[0]";
                        } else {
                            $avatar = "$rutaAbsoluta/planner/avatars/$avatar";
                        }

                        $array['usuariosPermitidos'][] = array(
                            "idBitacora" => $idBitacora,
                            "destino" => $destino,
                            "idUsuario" => $idUsuarioX,
                            "usuario" => $usuario,
                            "cargo" => $cargo,
                            "avatar" => $avatar,
                        );
                    }
                }

                #PARAMETROS
                $parametros = array();
                $query = "SELECT id_publico, usuarios_globales, ids_usuarios, parametro, configuracion_global, fecha_inicio, hora_inicio, horas, dias, semanas, meses, id_unidad_medida, parametro_minimo, parametro_maximo, generar_incidencia, titulo_incidencia, tipo_incidencia, notificar_telegram, notificar_ids_usuarios, fecha_creado, activo
                FROM t_bitacoras_lista_parametros
                WHERE id_bitacoras_configuracion = '$idBitacora' and activo = 1 ORDER BY fecha_creado ASC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idsUsuarios = $x["ids_usuarios"];
                        $idParametro = $x["id_publico"];
                        $parametro = $x["parametro"];
                        $usuariosGlobales = $x['usuarios_globales'];
                        $configuracionGlobal = $x['configuracion_global'];
                        $fechaInicio = $x['fecha_inicio'];
                        $horaInicio = $x['hora_inicio'];
                        $horas = intval($x['horas']);
                        $dias = intval($x['dias']) > 0 ? $x['dias'] / 24 : 0;
                        $semanas = intval($x['semanas']) > 0 ? $x['semanas'] / 168 : 0;
                        $meses = intval($x['meses']) > 0 ? $x['meses'] / 730 : 0;
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
                        if ($configuracionGlobal == "true") {
                            $configuracionGlobal = true;
                        } else {
                            $configuracionGlobal = false;
                        }

                        #CONVIERTE EN BOOLEAN
                        if ($usuariosGlobales == "true") {
                            $usuariosGlobales = true;
                        } else {
                            $usuariosGlobales = false;
                        }

                        #CONVIERTE EN BOOLEAN
                        if ($generarIncidencia == "true") {
                            $generarIncidencia = true;
                        } else {
                            $generarIncidencia = false;
                        }

                        #CONVIERTE EN BOOLEAN
                        if ($notificarTelegram == "true") {
                            $notificarTelegram = true;
                        } else {
                            $notificarTelegram = false;
                        }

                        #USUARIOS SELECCIONADOS EN PARAMETRO
                        $usuariosParametro = array();
                        $idsUsuarios = str_replace($caracteres, "", $idsUsuarios);
                        $query = "SELECT u.id, c.nombre, c.apellido, d.destino
                        FROM t_users AS u
                        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
                        INNER JOIN c_destinos AS d ON u.id_destino = d.id
                        WHERE u.id IN($idsUsuarios)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $idUsuario = $x["id"];
                                $usuario = $x['nombre'] . " " . $x['apellido'];
                                $destino = $x['destino'];

                                $usuariosParametro[] = array(
                                    "idUsuario" => $idUsuario,
                                    "usuario" => $usuario,
                                    "destino" => $destino,
                                    "idParametro" => $idParametro,
                                );
                            }
                        }

                        #USUARIOS A NOTIFICAR POR TELEGRAM
                        $usuariosTelegram = array();
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
                                    "idParametro" => $idParametro,
                                );
                            }
                        }

                        #ARRAY DE PARAMETROS
                        $parametros[] = array(
                            "idParametro" => $idParametro,
                            "parametro" => $parametro,
                            "usuariosGlobales" => $usuariosGlobales,
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
                            "usuariosParametro" => $usuariosParametro,
                            "activo" => $activo,
                            "change" => 0,
                        );
                    }
                }

                #ARRAY DE RESULTADOS
                $array['bitacoras'][] = array(
                    "idBitacora" => $idBitacora,
                    "descripcion" => $descripcion_bitacora,
                    "fechaInicio" => $fechaInicio_bitacora,
                    "horaInicio" => $horaInicio_bitacora,
                    "repetir" => 0,
                    "parametros" => $parametros,
                    "destinos" => $destinos,
                    "usuarios" => $usuarios,
                    "tipos" => $tipos,
                    "equipos" => $equipos,
                    "horas" => $horas_bitacora,
                    "dias" => $dias_bitacora,
                    "semanas" => $semanas_bitacora,
                    "meses" => $meses_bitacora,
                    "status" => $status_bitacora,
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
        if ("descripcion" == $opcion) {
            $query = "UPDATE t_bitacoras_configuracion SET descripcion = '$value', activo = 1
            WHERE id_publico = '$idBitacora'";
            if ($result = mysqli_query($conn_2020, $query)) {
                $array['response'] = "SUCCESS";
                $array['message'] = "Descripción Actualizada!";
            }
        }

        #ACTUALIZA FECHA DE INICIO DE LA BITACORA
        if ("fechaInicio" == $opcion) {
            $query = "UPDATE t_bitacoras_configuracion SET fecha_inicio = '$value'
            WHERE id_publico = '$idBitacora'";
            if ($result = mysqli_query($conn_2020, $query)) {
                $array['response'] = "SUCCESS";
                $array['message'] = "Fecha de Inicio, Actualizada!";
            }
        }

        #ACTUALIZA HORA DE INICIO DE LA BITACORA
        if ("horaInicio" == $opcion) {
            $query = "UPDATE t_bitacoras_configuracion SET hora_inicio = '$value'
            WHERE id_publico = '$idBitacora'";
            if ($result = mysqli_query($conn_2020, $query)) {
                $array['response'] = "SUCCESS";
                $array['message'] = "Hora de Inicio, Actualizada!";
            }
        }

        #ACTUALIZA HORA DE INICIO DE LA BITACORA
        if (("horas" == $opcion || "dias" == $opcion || "semanas" == $opcion || "meses" == $opcion) && $value >= 0) {

            if ("horas" == $opcion) {
                $value = $value * 1;
            }

            if ("dias" == $opcion) {
                $value = $value * 24;
            }

            if ("semanas" == $opcion) {
                $value = $value * 168;
            }

            if ("meses" == $opcion) {
                $value = $value * 730;
            }

            $query = "UPDATE t_bitacoras_configuracion SET $opcion = '$value'
            WHERE id_publico = '$idBitacora'";
            if ($result = mysqli_query($conn_2020, $query)) {
                $array['response'] = "SUCCESS";
                $array['message'] = strtoupper($opcion) . ", Actualizadas!";
            }
        }

        #ACTUALIZA HORA DE INICIO DE LA BITACORA
        if (("status" == $opcion) && ('ACTIVADO' === $value || 'DESACTIVADO' === $value)) {
            $query = "UPDATE t_bitacoras_configuracion SET status = '$value'
            WHERE id_publico = '$idBitacora'";
            if ($result = mysqli_query($conn_2020, $query)) {
                $array['response'] = "SUCCESS";
                $array['message'] = "Status Actualizado!";
            }
        }
    }


    #OBTENER EQUIPOS POR SECCION Y SUBSECCION
    if ($action === "equipos") {
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $idBitacora = $_POST['idBitacora'];

        $idsDestinos = 0;
        $query = "SELECT ids_destinos
        FROM t_bitacoras_configuracion
        WHERE id_publico = '$idBitacora'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idsDestinos = str_replace($caracteres, "", $x['ids_destinos']);
            }
        }

        $array['equipos'] = array();
        $query = "SELECT e.id, e.equipo, d.id 'idDestino', d.destino
        FROM t_equipos_america AS e
        INNER JOIN c_destinos AS d ON e.id_destino = d.id
        WHERE e.id_destino IN($idsDestinos) and e.id_seccion = $idSeccion and e.id_subseccion = $idSubseccion
        and e.status IN('OPERATIVO') and e.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            $array['response'] = "SUCCESS";
            $array['message'] = "Lista de Equipos, Actualizado!";
            foreach ($result as $x) {
                $idEquipo = intval($x['id']);
                $equipo = $x['equipo'];
                $idDestino = intval($x['idDestino']);
                $destino = $x['destino'];

                $array['equipos'][] = array(
                    "idEquipo" => $idEquipo,
                    "idBitacora" => $idBitacora,
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
                if ("" == $idsTiposEquipos) {
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
                    $array['message'] = "Tipos de Equipos, Actualizado!";
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
                    if ("[$idTipoEquipo]" === $value) {
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
                    $array['message'] = "Equipo Eliminado!";
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
                if ("" == $idsEquipos) {
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
                    $array['message'] = "Equipo Agregado!";
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
                    if ("[$idEquipo]" === $value) {
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
                    $array['message'] = "Equipo Eliminado!";
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
                if ("" == $idsDestinos) {
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
                    $array['message'] = "Destino Agregado!";
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
                    if ("[$idDestino]" === $value) {
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
                    $array['message'] = "Destino Eliminado!";
                }
            }
        }
    }


    #AGREGAR USUARIO A LA BITACORA
    if ($action === "agregarUsuario") {
        $idBitacora = $_POST['idBitacora'];
        $idUsuarioX = $_POST['idUsuarioX'];

        $query = "SELECT ids_usuarios
        FROM t_bitacoras_configuracion
        WHERE id_publico = '$idBitacora' LIMIT 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idsUsuario = trim($x['ids_usuarios']);

                #AGREGA NUEVO TIPO EQUIPO
                if ("" == $idsUsuario) {
                    $idsUsuario = array("[$idUsuarioX]");
                } else {
                    $idsUsuario = preg_split("/[\s,]+/", $idsUsuario);
                    $idsUsuario[] = "[$idUsuarioX]";
                }

                #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
                if (
                    count($idsUsuario) > 0
                ) {
                    $idsUsuario = implode(", ", $idsUsuario);
                } else {
                    $idsUsuario = implode("", $idsUsuario);
                }

                $query = "UPDATE t_bitacoras_configuracion SET ids_usuarios = '$idsUsuario'
                WHERE id_publico = '$idBitacora'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $array['response'] = "SUCCESS";
                    $array['message'] = "Usuario Agregado!";
                }
            }
        }
    }


    #ELIMINA USUARIO DE LA BITACORA
    if ($action === "eliminarUsuario") {
        $idBitacora = $_POST['idBitacora'];
        $idUsuarioX = $_POST['idUsuarioX'];

        $query = "SELECT ids_usuarios
        FROM t_bitacoras_configuracion
        WHERE id_publico = '$idBitacora' LIMIT 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idsUsuarios = $x['ids_usuarios'];
                $idsUsuarios = preg_split("/[\s,]+/", $idsUsuarios);

                #ELIMINA EL TIPO EQUIPO
                foreach ($idsUsuarios as $key => $value) {
                    if ("[$idUsuarioX]" === $value) {
                        unset($idsUsuarios[$key]);
                    }
                }

                #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
                $idsUsuarios = implode(",", $idsUsuarios);
                $array['x'] = $idsUsuarios;

                $query = "UPDATE t_bitacoras_configuracion SET ids_usuarios = '$idsUsuarios'
                WHERE id_publico = '$idBitacora'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $array['response'] = "SUCCESS";
                    $array['message'] = "Usuario Eliminado!";
                }
            }
        }
    }


    #AGREGAR PARAMETRO A BITACORA
    if ($action === "agregarParametro") {
        $idBitacora = $_POST['idBitacora'];
        $idParametro = $_POST['idParametro'];
        $parametro = $_POST['parametro'];

        $query = "INSERT INTO t_bitacoras_lista_parametros(id_publico, id_destino, creado_por, id_bitacoras_configuracion, usuarios_globales, parametro, configuracion_global, generar_incidencia, notificar_telegram, fecha_creado, activo)
        VALUES('$idParametro', $idDestino, $idUsuario, '$idBitacora', 'true', '$parametro', 'true', 'false', 'false', '$fechaActual',  1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $array['response'] = "SUCCESS";
            $array['message'] = "Parámetro  Agregado!";
        }
    }


    #ACTUALIZA DATOS DE LOS PARAMETROS
    if ($action === "actualizarParametro") {
        $idParametro = $_POST['idParametro'];
        $parametro = $_POST['parametro'];
        $idUnidad = $_POST['idUnidad'];
        $usuariosGlobales = $_POST['usuariosGlobales'];
        $configuracionGlobal = $_POST['configuracionGlobal'];
        $fechaInicio = $_POST['fechaInicio'];
        $horaInicio = $_POST['horaInicio'];
        $horas = $_POST['horas'];
        $dias = $_POST['dias'] * 24;
        $semanas = $_POST['semanas'] * 168;
        $meses = $_POST['meses'] * 730;
        $parametroMinimo = $_POST['parametroMinimo'];
        $parametroMaximo = $_POST['parametroMaximo'];
        $generarIncidencia = $_POST['generarIncidencia'];
        $tituloIncidencia = $_POST['tituloIncidencia'];
        $tipoIncidencia = $_POST['tipoIncidencia'];
        $activo = $_POST['activo'];

        if ($configuracionGlobal === true || $configuracionGlobal == 'true') {
            $configuracionGlobal = 'true';
        } else {
            $configuracionGlobal = 'false';
        }

        if ($usuariosGlobales === true || $usuariosGlobales == 'true') {
            $usuariosGlobales = 'true';
        } else {
            $usuariosGlobales = 'false';
        }

        if ($generarIncidencia === true || $generarIncidencia == 'true') {
            $generarIncidencia = 'true';
        } else {
            $generarIncidencia = 'false';
        }

        $query = "UPDATE t_bitacoras_lista_parametros SET
        parametro = '$parametro',
        usuarios_globales = '$usuariosGlobales',
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
            $array['message'] = "Parámetro Actualizado!";
        }
    }


    #ELIMINA USUARIO DE PARAMETRO
    if ($action === "eliminarUsuarioParametro") {
        $idParametro = $_POST['idParametro'];
        $idUsuarioX = $_POST['idUsuarioX'];

        $query = "SELECT ids_usuarios
        FROM t_bitacoras_lista_parametros
        WHERE id_publico = '$idParametro' LIMIT 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idsUsuarios = $x['ids_usuarios'];
                $idsUsuarios = preg_split("/[\s,]+/", $idsUsuarios);

                #ELIMINA EL TIPO EQUIPO
                foreach ($idsUsuarios as $key => $value) {
                    if ("[$idUsuarioX]" === $value) {
                        unset($idsUsuarios[$key]);
                    }
                }

                #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
                $idsUsuarios = implode(",", $idsUsuarios);
                $array['x'] = $idsUsuarios;

                $query = "UPDATE t_bitacoras_lista_parametros SET ids_usuarios = '$idsUsuarios'
                WHERE id_publico = '$idParametro'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $array['response'] = "SUCCESS";
                    $array['message'] = "Usuario Eliminado!";
                }
            }
        }
    }


    #AGREGAR DESTINO A LA BITACORA
    if ($action === "agregarUsuarioParametro") {
        $idParametro = $_POST['idParametro'];
        $idUsuarioX = $_POST['idUsuarioX'];

        $query = "SELECT ids_usuarios
        FROM t_bitacoras_lista_parametros
        WHERE id_publico = '$idParametro' LIMIT 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idsUsuario = trim($x['ids_usuarios']);

                #AGREGA NUEVO TIPO EQUIPO
                if ("" == $idsUsuario) {
                    $idsUsuario = array("[$idUsuarioX]");
                } else {
                    $idsUsuario = preg_split("/[\s,]+/", $idsUsuario);
                    $idsUsuario[] = "[$idUsuarioX]";
                }

                #PREPARA EL ARRAY PARA ACTUALIZAR LA TABLA
                if (
                    count($idsUsuario) > 0
                ) {
                    $idsUsuario = implode(", ", $idsUsuario);
                } else {
                    $idsUsuario = implode("", $idsUsuario);
                }

                $query = "UPDATE t_bitacoras_lista_parametros SET ids_usuarios = '$idsUsuario'
                WHERE id_publico = '$idParametro'";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $array['response'] = "SUCCESS";
                    $array['message'] = "Usuario Agregado";
                }
            }
        }
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
                if ("" == $idsUsuarios) {
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
                    $array['message'] = "Usuario Agregado!";

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
                            $array['message'] = "Usuario Notificado!";
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
                    if ("[$idUsuario]" === $value) {
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
                    $array['message'] = "Usuario Eliminado!";

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
                            $array['message'] = "Usuario Notificado!";
                        }
                    }
                }
            }
        }
    }


    if ($action === "getArray") {
        $array['response'] = "SUCCESS";
        $array['data'] = array();
        $array['tiposEquipos'] = array();
        $array['conexion'] = true;

        if ($idDestino == 10)
            $filtroDestino = "";
        else
            $filtroDestino = "and b.ids_destinos LIKE '%[$idDestino]%'";

        #QUERY PRINCIPAL DE LAS BITACORAS
        $query = "SELECT
        b.id_publico,
        b.ids_destinos,
        b.ids_usuarios,
        b.ids_tipos_equipos,
        b.ids_equipos,
        b.descripcion,
        b.fecha_inicio,
        b.hora_inicio,
        b.horas,
        b.dias,
        b.semanas,
        b.meses,
        b.status
        FROM t_bitacoras_configuracion AS b
        WHERE 
        b.activo = 1 and
        b.status = 'ACTIVADO'
        $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idBitacora = $x['id_publico'];
                $bitacora_b = $x['descripcion'];
                $fechaInicio_b = $x['fecha_inicio'];
                $horaInicio_b = $x['hora_inicio'];
                $ciclo_b = ($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);

                $idsDestinos = str_replace($caracteres, "", $x['ids_destinos']);
                $idsTiposEquipos = str_replace($caracteres, "", $x['ids_tipos_equipos']);
                $idsEquipos = str_replace($caracteres, "", $x['ids_equipos']);
                $idsUsuarios_b = str_replace($caracteres, "", $x['ids_usuarios']);

                $query = "SELECT
                p.id_publico,
                p.ids_usuarios,
                p.parametro,
                p.configuracion_global,
                p.usuarios_globales,
                p.fecha_inicio,
                p.hora_inicio,
                p.horas,
                p.dias,
                p.semanas,
                p.meses,
                p.parametro_minimo,
                p.parametro_maximo,
                medida.medida
                FROM t_bitacoras_lista_parametros AS p
                INNER JOIN t_unidades_medidas AS medida ON p.id_unidad_medida = medida.id
                WHERE p.id_bitacoras_configuracion = '$idBitacora' and p.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idParametro = $x['id_publico'];
                        $parametro = $x['parametro'];
                        $medida = $x['medida'];
                        $fechaInicio_p = $x['fecha_inicio'];
                        $horaInicio_p = $x['hora_inicio'];
                        $ciclo_p = ($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);
                        $parametroMinimo = $x['parametro_minimo'];
                        $parametroMaximo = $x['parametro_maximo'];
                        $configuracionGlobal = $x['configuracion_global'];
                        $usuariosGlobales = $x['usuarios_globales'];
                        $idsUsuarios_p = str_replace($caracteres, "", $x['ids_usuarios']);

                        #ARRAY PARA ALAMCENAR DATOS DEL PARAMETRO
                        $equipos = array();

                        $arrayUsuariosPermitidos = [];
                        if ($usuariosGlobales == true) {
                            $arrayUsuariosPermitidos = explode(", ", $idsUsuarios_b);
                        }

                        if ($usuariosGlobales == false) {
                            $arrayUsuariosPermitidos = explode(", ", $idsUsuarios_p);
                        }

                        #VALIDA PERMISOS DE USUARIO
                        if (in_array($idUsuario, $arrayUsuariosPermitidos)) {

                            if ($idsTiposEquipos == "")
                                $idsTiposEquipos = -1;

                            if ($idsEquipos == "")
                                $idsEquipos = 0;

                            if ($idsDestinos == "")
                                $idsDestinos = 0;

                            if ($configuracionGlobal == 'true') {
                                $filtroParametro = "and id_parametro = ''";
                                $filtroFechaRegistro = "and fecha_inicio_registro = '$fechaInicio_b'";
                                $filtroHoraRegistro = "and hora_inicio_registro = '$horaInicio_b'";
                                $filtroCiclosHoras = "and ciclo_horas = '$ciclo_b'";
                            } else {
                                $filtroParametro = "and id_parametro = '$idParametro'";
                                $filtroFechaRegistro = "and fecha_inicio_registro = '$fechaInicio_p'";
                                $filtroHoraRegistro = "and hora_inicio_registro = '$horaInicio_p'";
                                $filtroCiclosHoras = "and ciclo_horas = '$ciclo_p'";
                            }

                            $query = "SELECT lt.id, fecha_token
                            FROM t_bitacoras_linea_tiempo AS lt
                            WHERE id_bitacora = '$idBitacora' and
                            fecha_token BETWEEN '" . date("Y-m-d 00:00:01") . "' and '" . date("Y-m-d 23:59:59") . "' and activo = 1
                            $filtroParametro $filtroFechaRegistro $filtroHoraRegistro $filtroCiclosHoras";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idLineaTiempo = $x['id'];
                                    $fechaToken = $x['fecha_token'];
                                    $horarioInput = (new \DateTime($fechaToken))->format('H:m');
                                    $query = "SELECT e.id, e.equipo, t.tipo
                                    FROM t_equipos_america AS e
                                    LEFT JOIN c_tipos AS t ON e.id_tipo = t.id
                                    WHERE e.id_destino IN($idsDestinos) and (e.id_tipo IN($idsTiposEquipos) or e.id IN($idsEquipos)) and e.status IN('OPERATIVO') and e.activo = 1";
                                    if ($result = mysqli_query($conn_2020, $query)) {
                                        foreach ($result as $x) {
                                            $idEquipo = $x['id'];
                                            $equipo = $x['equipo'];
                                            $tipoEquipo = $x['tipo'];

                                            #TIPOS DE EQUIPOS
                                            $array['tiposEquipos'][] = $tipoEquipo;

                                            $idValor = 0;
                                            $valor = "";
                                            $crearIncidencia = "NO";
                                            $idIncidencia = "";
                                            $fechaCaptura = "";
                                            $enTiempo = "";
                                            $status = "PENDIENTE";
                                            $enTiempo = "";
                                            $estado = "ESPERA";

                                            $query = "SELECT id, valor, crear_incidencia,
                                            id_incidencia, fecha_captura, status
                                            FROM t_bitacora_capturas
                                            WHERE id_bitacora = '$idBitacora' and id_parametro = '$idParametro' 
                                            and id_equipo = '$idEquipo' and fecha_token = '$fechaToken' and activo = 1";
                                            if ($result = mysqli_query($conn_2020, $query)) {
                                                foreach ($result as $x) {
                                                    $idValor = $x['id'];
                                                    $valor = $x['valor'];
                                                    $crearIncidencia = $x['crear_incidencia'];
                                                    $idIncidencia = $x['id_incidencia'];
                                                    $fechaCaptura = $x['fecha_captura'];
                                                    $status = $x['status'];
                                                    $estado = "CAPTURADO";
                                                    $fechaLR = strtotime($fechaToken);
                                                    $fechaL = strtotime("+30 minutes", strtotime($fechaToken));
                                                    $fechaR = strtotime("-30 minutes", strtotime($fechaToken));

                                                    if ($fechaL <= $fechaLR && $fechaR >= $fechaLR)
                                                        $enTiempo = "SI";
                                                    else
                                                        $enTiempo = "NO";
                                                }
                                            }

                                            $equipos[] = array(
                                                "idBitacora" => $idBitacora,
                                                "idParametro" => $idParametro,
                                                "idLineaTiempo" => $idLineaTiempo,
                                                "idEquipo" => $idEquipo,
                                                "idValor" => $idValor,
                                                "equipo" => $equipo,
                                                "medida" => $medida,
                                                "parametroMinimo" => $parametroMinimo,
                                                "parametroMaximo" => $parametroMaximo,
                                                "valor" => $valor,
                                                "crearIncidencia" => $crearIncidencia,
                                                "idIncidencia" => $idIncidencia,
                                                "fechaCaptura" => $fechaCaptura,
                                                "tipoEquipo" => $tipoEquipo,
                                                "horarioInput" => $horarioInput,
                                                "fechaToken" => $fechaToken,
                                                "status" => $status,
                                                "enTiempo" => $enTiempo,
                                                "estado" => $estado,
                                            );
                                        }
                                    }
                                }
                            }

                            $array['data'][] = array(
                                "parametro" => $parametro,
                                "equipos" => $equipos,
                                "idParametro" => $idParametro,
                            );
                        }
                    }
                }
            }
        }
    }


    if ($action === "capturar") {
        $idValor = $_POST['idValor'];
        $idBitacora = $_POST['idBitacora'];
        $idParametro = $_POST['idParametro'];
        $idEquipo = $_POST['idEquipo'];
        $fechaToken = $_POST['fechaToken'];
        $parametroMaximo = $_POST['parametroMaximo'];
        $parametroMinimo = $_POST['parametroMinimo'];
        $valor = $_POST['valor'];
        $fechaCapturaActual = $_POST['fechaCapturaActual'];
        $idIncidencia = $_POST['idIncidencia'];

        #DECISIÓN PARA CREAR INCIDENCIA
        $idNuevaIncidencia = 0;
        $crearIncidencia = "NO";

        #CADA VEZ QUE SE MODIFICA EL PARAMETRO ELIMINA LA INCIDENCIA CREADA ANTERIORMENTE.
        $query = "UPDATE t_mc SET activo = 0 WHERE id = $idIncidencia";
        if ($result = mysqli_query($conn_2020, $query)) {
            $idIncidencia = 0;
        }

        if ($parametroMinimo <= $valor && $parametroMaximo >= $valor) {
            $crearIncidencia = "NO";
        } else {
            $crearIncidencia = "SI";

            #OBTIENE NUEVO ID DE INCIDENCIA
            $query = "SELECT max(id) 'idIncidencia' FROM t_mc";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idNuevaIncidencia = $x['idIncidencia'] + 1;
                }
            }

            #NOTIFICAR TELEGRAM
            $query = "SELECT p.titulo_incidencia, p.tipo_incidencia, p.notificar_ids_usuarios,
            p.notificar_telegram, p.parametro, b.descripcion, u.medida
            FROM t_bitacoras_configuracion AS b
            INNER JOIN t_bitacoras_lista_parametros AS p ON b.id_publico = p.id_bitacoras_configuracion 
            and p.id_publico = '$idParametro'
            LEFT JOIN t_unidades_medidas AS u ON p.id_unidad_medida = u.id
            WHERE b.id_publico = '$idBitacora' and b.activo = 1 and p.generar_incidencia = 'true'";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idsUsuariosTelegram = str_replace($caracteres, "", $x['notificar_ids_usuarios']);
                    $tituloIncidencia = $x['titulo_incidencia'];
                    $tipoIncidencia = $x['tipo_incidencia'];
                    $notificar = $x['notificar_telegram'];
                    $bitacora = $x['descripcion'];
                    $parametro = $x['parametro'];
                    $medida = $x['medida'];

                    if ($idsUsuariosTelegram == "")
                        $idsUsuariosTelegram = 0;

                    $equipo = "";
                    $destio = "";
                    $query = "SELECT e.equipo, d.destino
                    FROM t_equipos_america AS e
                    INNER JOIN c_destinos AS d ON e.id_destino = d.id
                    WHERE e.id = $idEquipo";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $equipo = $x['equipo'];
                            $destino = $x['destino'];
                        }
                    }

                    $msj = "Se ha creado una 𝗜𝗻𝗰𝗶𝗱𝗲𝗻𝗰𝗶𝗮⠘ $tituloIncidencia, 𝗧𝗶𝗽𝗼⠘ $tipoIncidencia, 𝙀𝙦𝙪𝙞𝙥𝙤⠘ $destino -➤ $equipo. Debido a que se registro en la 𝗕𝗶𝘁𝗮́𝗰𝗼𝗿𝗮⠘ $bitacora, en el 𝗣𝗮𝗿𝗮́𝗺𝗲𝘁𝗿𝗼⠘ $parametro, el 𝗩𝗮𝗹𝗼𝗿⠘ $valor $medida";

                    #VERIFICA SI SE CREARA LA INCIDENCIA
                    crearIncidencia($idEquipo, $idNuevaIncidencia, $idUsuario, $tituloIncidencia, $tipoIncidencia);

                    #VERIFICA SI SE NOTIFICARA VÍA TELEGRAM
                    notificarTelegram($msj, $idsUsuariosTelegram);
                }
            }
        }

        if ($idValor == 0) {
            $query = "INSERT INTO t_bitacora_capturas(id_bitacora, id_parametro, id_equipo, creado_por, fecha_token, valor, parametro_minimo, parametro_maximo, crear_incidencia, id_incidencia, fecha_captura, status, activo) VALUES('$idBitacora', '$idParametro', '$idEquipo', $idUsuario, '$fechaToken', '$valor', '$parametroMinimo','$parametroMaximo', '$crearIncidencia', '$idNuevaIncidencia', '$fechaCapturaActual', 'CAPTURADO', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $array['response'] = "SUCCESS";
                $array['conexion'] = true;
            }
        }

        if ($idValor > 0) {
            $query = "UPDATE t_bitacora_capturas SET
            creado_por = '$idUsuario',
            valor = '$valor',
            parametro_minimo = '$parametroMinimo',
            parametro_maximo = '$parametroMaximo',
            crear_incidencia = '$crearIncidencia',
            id_incidencia = '$idNuevaIncidencia',
            fecha_captura = '$fechaCapturaActual'
            WHERE id = '$idValor' and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $array['response'] = "SUCCESS";
                $array['conexion'] = true;
            }
        }
    }


    if ($action === "historico") {

        $array['response'] = "SUCCESS";
        $array['conexion'] = true;

        $array['data'] = array();
        $array['destinos'] = array();
        $array['bitacoras'] = array();
        $array['parametros'] = array();
        $array['tiposEquipos'] = array();

        if ($idDestino == 10)
            $filtroDestino = "";
        else
            $filtroDestino = "and b.ids_destinos LIKE '%[$idDestino]%'";

        $fechaInicio = $_POST['fechaInicio'] . " 00:00:01";
        $fechaFin = $_POST['fechaFin'] . " 23:59:59";

        #QUERY PRINCIPAL DE LAS BITACORAS
        $query = "SELECT
        b.id_publico,
        b.ids_destinos,
        b.ids_usuarios,
        b.ids_tipos_equipos,
        b.ids_equipos,
        b.descripcion,
        b.fecha_inicio,
        b.hora_inicio,
        b.horas,
        b.dias,
        b.semanas,
        b.meses,
        b.status
        FROM t_bitacoras_configuracion AS b
        WHERE 
        b.activo = 1 and
        b.status = 'ACTIVADO'
        $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idBitacora = $x['id_publico'];
                $bitacora = $x['descripcion'];
                $fechaInicio_b = $x['fecha_inicio'];
                $horaInicio_b = $x['hora_inicio'];
                $ciclo_b = ($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);

                $array['bitacoras'][] = $bitacora;

                $idsDestinos = str_replace($caracteres, "", $x['ids_destinos']);
                $idsTiposEquipos = str_replace($caracteres, "", $x['ids_tipos_equipos']);
                $idsEquipos = str_replace($caracteres, "", $x['ids_equipos']);
                $idsUsuarios_b = str_replace($caracteres, "", $x['ids_usuarios']);

                $query = "SELECT
                p.id_publico,
                p.ids_usuarios,
                p.parametro,
                p.configuracion_global,
                p.usuarios_globales,
                p.fecha_inicio,
                p.hora_inicio,
                p.horas,
                p.dias,
                p.semanas,
                p.meses,
                p.parametro_minimo,
                p.parametro_maximo,
                medida.medida
                FROM t_bitacoras_lista_parametros AS p
                INNER JOIN t_unidades_medidas AS medida ON p.id_unidad_medida = medida.id
                WHERE p.id_bitacoras_configuracion = '$idBitacora' and p.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idParametro = $x['id_publico'];
                        $usuariosGlobales = $x['usuarios_globales'];
                        $parametro = $x['parametro'];
                        $medida = $x['medida'];
                        $fechaInicio_p = $x['fecha_inicio'];
                        $horaInicio_p = $x['hora_inicio'];
                        $ciclo_p = ($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);
                        $parametroMinimo = $x['parametro_minimo'];
                        $parametroMaximo = $x['parametro_maximo'];
                        $configuracionGlobal = $x['configuracion_global'];
                        $idsUsuarios_p = str_replace($caracteres, "", $x['ids_usuarios']);

                        $array['parametros'][] = $parametro;

                        #ARRAY PARA ALAMCENAR DATOS DEL PARAMETRO
                        $equipos = array();

                        $arrayUsuariosPermitidos = [];
                        if ($usuariosGlobales == true) {
                            $arrayUsuariosPermitidos = explode(", ", $idsUsuarios_b);
                        }

                        if ($usuariosGlobales == false) {
                            $arrayUsuariosPermitidos = explode(", ", $idsUsuarios_p);
                        }

                        #VALIDA PERMISOS DE USUARIO
                        if (in_array($idUsuario, $arrayUsuariosPermitidos)) {

                            if ($idsTiposEquipos == "")
                                $idsTiposEquipos = -1;

                            if ($idsEquipos == "")
                                $idsEquipos = 0;

                            if ($idsDestinos == "")
                                $idsDestinos = 0;

                            if ($configuracionGlobal == 'true') {
                                $filtroParametro = "and id_parametro = ''";
                                $filtroFechaRegistro = "and fecha_inicio_registro = '$fechaInicio_b'";
                                $filtroHoraRegistro = "and hora_inicio_registro = '$horaInicio_b'";
                                $filtroCiclosHoras = "and ciclo_horas = '$ciclo_b'";
                            } else {
                                $filtroParametro = "and id_parametro = '$idParametro'";
                                $filtroFechaRegistro = "and fecha_inicio_registro = '$fechaInicio_p'";
                                $filtroHoraRegistro = "and hora_inicio_registro = '$horaInicio_p'";
                                $filtroCiclosHoras = "and ciclo_horas = '$ciclo_p'";
                            }

                            $query = "SELECT id, fecha_token
                            FROM t_bitacoras_linea_tiempo
                            WHERE id_bitacora = '$idBitacora' and
                            fecha_token BETWEEN '$fechaInicio' and '$fechaFin' and activo = 1
                            $filtroParametro $filtroFechaRegistro $filtroHoraRegistro $filtroCiclosHoras
                            ORDER BY fecha_token ASC";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idLineaTiempo = $x['id'];
                                    $fechaToken = $x['fecha_token'];
                                    $horarioInput = (new \DateTime($fechaToken))->format('H:m');

                                    $query = "SELECT e.id, e.equipo, t.tipo, d.destino
                                    FROM t_equipos_america AS e
                                    INNER JOIN c_destinos AS d ON e.id_destino = d.id
                                    LEFT JOIN c_tipos AS t ON e.id_tipo = t.id
                                    WHERE e.id_destino IN($idsDestinos) and (e.id_tipo IN($idsTiposEquipos) or e.id IN($idsEquipos)) and e.status IN('OPERATIVO') and e.activo = 1";
                                    if ($result = mysqli_query($conn_2020, $query)) {
                                        foreach ($result as $x) {
                                            $idEquipo = $x['id'];
                                            $equipo = $x['equipo'];
                                            $tipoEquipo = $x['tipo'];
                                            $destino = $x['destino'];

                                            #TIPOS DE EQUIPOS
                                            $array['tiposEquipos'][] = $tipoEquipo;

                                            #DESTINOS DE EQUIPOS
                                            $array['destinos'][] = $destino;

                                            $fechaRegistro = "";
                                            $horaRegistro = "";

                                            #Registro
                                            $idValor = 0;
                                            $valor = "";
                                            $fueraRango = "";
                                            $crearIncidencia = "";
                                            $idIncidencia = "";
                                            $fechaCaptura = "";
                                            $status = "";
                                            $enTiempo = "";
                                            $estado = "PENDIENTE";
                                            $nombre = "";
                                            $fechaSolicitada = (new \DateTime($fechaToken))->format('Y-m-d');
                                            $horaSolicitada = (new \DateTime($fechaToken))->format('H:m');

                                            $query = "SELECT captura.id, captura.valor, captura.parametro_minimo, captura.parametro_maximo, captura.crear_incidencia,
                                            captura.id_incidencia, captura.fecha_captura, captura.status,
                                            c.nombre, c.apellido
                                            FROM t_bitacora_capturas AS captura
                                            INNER JOIN t_users AS u ON captura.creado_por = u.id
                                            INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
                                            WHERE captura.id_bitacora = '$idBitacora' and
                                            captura.id_parametro = '$idParametro' and
                                            captura.id_equipo = '$idEquipo' and
                                            captura.fecha_token = '$fechaToken' and
                                            captura.activo = 1";
                                            if ($result = mysqli_query($conn_2020, $query)) {
                                                foreach ($result as $x) {
                                                    $idValor = $x['id'];
                                                    $valor = $x['valor'];
                                                    $parametroMinimo = $x['parametro_minimo'];
                                                    $parametroMaximo = $x['parametro_maximo'];
                                                    $crearIncidencia = $x['crear_incidencia'];
                                                    $idIncidencia = $x['id_incidencia'];
                                                    $fechaCaptura = $x['fecha_captura'];
                                                    $status = $x['status'];
                                                    $estado = "CAPTURADO";
                                                    $fechaLR = strtotime($fechaToken);
                                                    $fechaL = strtotime("+30 minutes", strtotime($fechaToken));
                                                    $fechaR = strtotime("-30 minutes", strtotime($fechaToken));
                                                    $nombre = $x['nombre'] . " " . $x['apellido'];

                                                    if ($fechaCaptura != "")
                                                        $fechaRegistro = (new \DateTime($fechaCaptura))->format('Y-m-d');

                                                    if ($fechaCaptura != "")
                                                        $horaRegistro = (new \DateTime($fechaCaptura))->format('H:i:s');

                                                    if ($fechaL <= $fechaLR && $fechaR >= $fechaLR)
                                                        $enTiempo = "SI";
                                                    else
                                                        $enTiempo = "NO";

                                                    if ($parametroMinimo <= $valor && $parametroMaximo >= $valor)
                                                        $fueraRango = "NO";
                                                    else
                                                        $fueraRango = "SI";
                                                }
                                            }

                                            $array['data'][] = array(
                                                "destino" => $destino,
                                                "idBitacora" => $idBitacora,
                                                "bitacora" => $bitacora,
                                                "idParametro" => $idParametro,
                                                "parametro" => $parametro,
                                                "idLineaTiempo" => $idLineaTiempo,
                                                "idEquipo" => $idEquipo,
                                                "idValor" => $idValor,
                                                "equipo" => $equipo,
                                                "medida" => $medida,
                                                "parametroMinimo" => $parametroMinimo,
                                                "parametroMaximo" => $parametroMaximo,
                                                "valor" => $valor,
                                                "fueraRango" => $fueraRango,
                                                "crearIncidencia" => $crearIncidencia,
                                                "idIncidencia" => $idIncidencia,
                                                "fechaCaptura" => $fechaCaptura,
                                                "fechaRegistro" => $fechaRegistro,
                                                "horaRegistro" => $horaRegistro,
                                                "tipoEquipo" => $tipoEquipo,
                                                "horarioInput" => $horarioInput,
                                                "fechaToken" => $fechaToken,
                                                "fechaSolicitada" => $fechaSolicitada,
                                                "horaSolicitada" => $horaSolicitada,
                                                "status" => $status,
                                                "enTiempo" => $enTiempo,
                                                "estado" => $estado,
                                                "nombre" => $nombre,
                                            );
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    // ARRAY DE GRAFICOS
    if ($action === "graficos") {
        $array['response'] = "SUCCESS";
        $array['conexion'] = true;

        $array['data'] = array();
        $array['graficos'] = array();
        $array['destinos'] = array();
        $array['bitacoras'] = array();
        $array['parametros'] = array();
        $array['tiposEquipos'] = array();

        if ($idDestino == 10)
            $filtroDestino = "";
        else
            $filtroDestino = "and b.ids_destinos LIKE '%[$idDestino]%'";

        $fechaInicio = $_POST['fechaInicio'] . " 00:00:01";
        $fechaFin = $_POST['fechaFin'] . " 23:59:59";

        #QUERY PRINCIPAL DE LAS BITACORAS
        $query = "SELECT
        b.id_publico,
        b.ids_destinos,
        b.ids_usuarios,
        b.ids_tipos_equipos,
        b.ids_equipos,
        b.descripcion,
        b.fecha_inicio,
        b.hora_inicio,
        b.horas,
        b.dias,
        b.semanas,
        b.meses,
        b.status
        FROM t_bitacoras_configuracion AS b
        WHERE 
        b.activo = 1 and
        b.status = 'ACTIVADO'
        $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idBitacora = $x['id_publico'];
                $bitacora = $x['descripcion'];
                $fechaInicio_b = $x['fecha_inicio'];
                $horaInicio_b = $x['hora_inicio'];
                $ciclo_b = ($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);

                $array['bitacoras'][] = $bitacora;

                $idsDestinos = str_replace($caracteres, "", $x['ids_destinos']);
                $idsTiposEquipos = str_replace($caracteres, "", $x['ids_tipos_equipos']);
                $idsEquipos = str_replace($caracteres, "", $x['ids_equipos']);
                $idsUsuarios_b = str_replace($caracteres, "", $x['ids_usuarios']);

                $query = "SELECT
                p.id_publico,
                p.ids_usuarios,
                p.parametro,
                p.configuracion_global,
                p.usuarios_globales,
                p.fecha_inicio,
                p.hora_inicio,
                p.horas,
                p.dias,
                p.semanas,
                p.meses,
                p.parametro_minimo,
                p.parametro_maximo,
                medida.medida
                FROM t_bitacoras_lista_parametros AS p
                INNER JOIN t_unidades_medidas AS medida ON p.id_unidad_medida = medida.id
                WHERE p.id_bitacoras_configuracion = '$idBitacora' and p.activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idParametro = $x['id_publico'];
                        $usuariosGlobales = $x['usuarios_globales'];
                        $parametro = $x['parametro'];
                        $medida = $x['medida'];
                        $fechaInicio_p = $x['fecha_inicio'];
                        $horaInicio_p = $x['hora_inicio'];
                        $ciclo_p = ($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);
                        $parametroMinimo = $x['parametro_minimo'];
                        $parametroMaximo = $x['parametro_maximo'];
                        $configuracionGlobal = $x['configuracion_global'];
                        $idsUsuarios_p = str_replace($caracteres, "", $x['ids_usuarios']);

                        $array['parametros'][] = $parametro;

                        #ARRAY PARA ALAMCENAR DATOS DEL PARAMETRO
                        $equipos = array();

                        $arrayUsuariosPermitidos = [];
                        if ($usuariosGlobales == true) {
                            $arrayUsuariosPermitidos = explode(", ", $idsUsuarios_b);
                        }

                        if ($usuariosGlobales == false) {
                            $arrayUsuariosPermitidos = explode(", ", $idsUsuarios_p);
                        }

                        #VALIDA PERMISOS DE USUARIO
                        if (in_array($idUsuario, $arrayUsuariosPermitidos)) {

                            if ($idsTiposEquipos == "")
                                $idsTiposEquipos = -1;

                            if ($idsEquipos == "")
                                $idsEquipos = 0;

                            if ($idsDestinos == "")
                                $idsDestinos = 0;

                            if ($configuracionGlobal == 'true') {
                                $filtroParametro = "and id_parametro = ''";
                                $filtroFechaRegistro = "and fecha_inicio_registro = '$fechaInicio_b'";
                                $filtroHoraRegistro = "and hora_inicio_registro = '$horaInicio_b'";
                                $filtroCiclosHoras = "and ciclo_horas = '$ciclo_b'";
                            } else {
                                $filtroParametro = "and id_parametro = '$idParametro'";
                                $filtroFechaRegistro = "and fecha_inicio_registro = '$fechaInicio_p'";
                                $filtroHoraRegistro = "and hora_inicio_registro = '$horaInicio_p'";
                                $filtroCiclosHoras = "and ciclo_horas = '$ciclo_p'";
                            }

                            $query = "SELECT lt.id, fecha_token
                            FROM t_bitacoras_linea_tiempo AS lt
                            WHERE id_bitacora = '$idBitacora' and
                            fecha_token BETWEEN '$fechaInicio' and '$fechaFin' and activo = 1
                            $filtroParametro $filtroFechaRegistro $filtroHoraRegistro $filtroCiclosHoras";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idLineaTiempo = $x['id'];
                                    $fechaToken = $x['fecha_token'];
                                    $horarioInput = (new \DateTime($fechaToken))->format('H:m');

                                    $query = "SELECT e.id, e.equipo, t.tipo, d.destino
                                    FROM t_equipos_america AS e
                                    INNER JOIN c_destinos AS d ON e.id_destino = d.id
                                    LEFT JOIN c_tipos AS t ON e.id_tipo = t.id
                                    WHERE e.id_destino IN($idsDestinos) and (e.id_tipo IN($idsTiposEquipos) or e.id IN($idsEquipos)) and e.status IN('OPERATIVO') and e.activo = 1";
                                    if ($result = mysqli_query($conn_2020, $query)) {
                                        foreach ($result as $x) {
                                            $idEquipo = $x['id'];
                                            $equipo = $x['equipo'];
                                            $tipoEquipo = $x['tipo'];
                                            $destino = $x['destino'];

                                            #TIPOS DE EQUIPOS
                                            $array['tiposEquipos'][] = $tipoEquipo;

                                            #DESTINOS DE EQUIPOS
                                            $array['destinos'][] = $destino;

                                            $data = array();
                                            $fechaRegistro = "";
                                            $horaRegistro = "";
                                            $query = "SELECT id, valor, parametro_minimo, parametro_maximo, crear_incidencia,
                                            id_incidencia, fecha_captura, status
                                            FROM t_bitacora_capturas
                                            WHERE id_bitacora = '$idBitacora' and id_parametro = '$idParametro' 
                                            and id_equipo = '$idEquipo' and fecha_token = '$fechaToken' and activo = 1 ORDER BY fecha_captura ASC";
                                            if ($result = mysqli_query($conn_2020, $query)) {
                                                foreach ($result as $x) {
                                                    $idValor = $x['id'];
                                                    $valor = $x['valor'];
                                                    $parametroMinimo = $x['parametro_minimo'];
                                                    $parametroMaximo = $x['parametro_maximo'];
                                                    $crearIncidencia = $x['crear_incidencia'];
                                                    $idIncidencia = $x['id_incidencia'];
                                                    $fechaCaptura = $x['fecha_captura'];
                                                    $status = $x['status'];
                                                    $estado = "CAPTURADO";
                                                    $fechaLR = strtotime($fechaToken);
                                                    $fechaL = strtotime("+30 minutes", strtotime($fechaToken));
                                                    $fechaR = strtotime("-30 minutes", strtotime($fechaToken));

                                                    $data[] = array(
                                                        "fecha" => $fechaCaptura,
                                                        "valor" => floatval($valor),
                                                        "parametroMinimo" => floatval($parametroMinimo),
                                                        "parametroMaximo" => floatval($parametroMaximo),
                                                        "medida" => $medida
                                                    );
                                                }
                                            }
                                            if (count($data)) {
                                                $array['graficos'][] = array(
                                                    "idEquipo" => $idEquipo,
                                                    "equipo" => $equipo,
                                                    "tipoEquipo" => $tipoEquipo,
                                                    "destino" => $destino,
                                                    "parametro" => $parametro,
                                                    "bitacora" => $bitacora,
                                                    "data" => $data,
                                                );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    // ARRAY NUEVA FORMA
    if ($action === "getArrayNueva") {
        $array['response'] = "SUCCESS";
        $array['data'] = array();
        $array['tiposEquipos'] = array();
        $array['conexion'] = true;

        if ($idDestino == 10) {
            $filtroDestino = "";
            $filtroEquiposDestinos = "";
        } else {
            $filtroDestino = "and b.ids_destinos LIKE '%[$idDestino]%'";
            $filtroEquiposDestinos = "and e.id_destino = $idDestino";
        }

        #QUERY PRINCIPAL DE LAS BITACORAS
        $query = "SELECT
        b.id_publico,
        b.ids_destinos,
        b.ids_usuarios,
        b.ids_tipos_equipos,
        b.ids_equipos,
        b.descripcion,
        b.fecha_inicio,
        b.hora_inicio,
        b.horas,
        b.dias,
        b.semanas,
        b.meses,
        b.status
        FROM t_bitacoras_configuracion AS b
        WHERE 
        b.activo = 1 and
        b.status = 'ACTIVADO'
        $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idBitacora = $x['id_publico'];
                $bitacora = $x['descripcion'];
                $fechaInicio_b = $x['fecha_inicio'];
                $horaInicio_b = $x['hora_inicio'];
                $ciclo_b = ($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);

                $idsDestinos = str_replace($caracteres, "", $x['ids_destinos']);
                $idsTiposEquipos = str_replace($caracteres, "", $x['ids_tipos_equipos']);
                $idsEquipos = str_replace($caracteres, "", $x['ids_equipos']);
                $idsUsuarios_b = str_replace($caracteres, "", $x['ids_usuarios']);

                #TIPOS DE EQUIPOS
                if ($idsTiposEquipos === "")
                    $idsTiposEquipos = "-1";

                #IDS EQUIPOS
                if ($idsEquipos === "")
                    $idsEquipos = "-1";
                $filtroEquipos = "and (e.id IN($idsEquipos) OR e.id_tipo IN($idsTiposEquipos))";

                #IDS DESTINOS
                if ($idsDestinos == "")
                    $idsDestinos = 0;
                $filtroEquiposDestinosX = "and e.id_destino IN($idsDestinos) $filtroEquiposDestinos";

                #EQUIPOS
                $array['tiposEquipos'] = array();
                $equipos = array();
                $query = "SELECT e.id, e.equipo, d.id 'idDestinoX', d.destino, t.tipo
                FROM t_equipos_america AS e
                INNER JOIN c_destinos AS d ON e.id_destino = d.id
                INNER JOIN c_tipos AS t ON e.id_tipo = t.id
                WHERE  e.activo = 1 and e.status IN('OPERATIVO') $filtroEquipos $filtroEquiposDestinosX";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idEquipo = $x['id'];
                        $equipo = $x['equipo'];
                        $idDestinoX = $x['idDestinoX'];
                        $destino = $x['destino'];
                        $tipoEquipo = $x['tipo'];
                        $array['tiposEquipos'][] = $tipoEquipo;

                        #PARAMETROS
                        $parametros = array();
                        $query = "SELECT
                        p.id_publico,
                        p.ids_usuarios,
                        p.parametro,
                        p.configuracion_global,
                        p.usuarios_globales,
                        p.fecha_inicio,
                        p.hora_inicio,
                        p.horas,
                        p.dias,
                        p.semanas,
                        p.meses,
                        p.parametro_minimo,
                        p.parametro_maximo,
                        medida.medida
                        FROM t_bitacoras_lista_parametros AS p
                        INNER JOIN t_unidades_medidas AS medida ON p.id_unidad_medida = medida.id
                        WHERE p.id_bitacoras_configuracion = '$idBitacora' and p.activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $idParametro = $x['id_publico'];
                                $parametro = $x['parametro'];
                                $medida = $x['medida'];
                                $fechaInicio_p = $x['fecha_inicio'];
                                $horaInicio_p = $x['hora_inicio'];
                                $ciclo_p = ($x['horas'] + $x['dias'] + $x['semanas'] + $x['meses']);
                                $parametroMinimo = $x['parametro_minimo'];
                                $parametroMaximo = $x['parametro_maximo'];
                                $configuracionGlobal = $x['configuracion_global'];
                                $usuariosGlobales = $x['usuarios_globales'];
                                $idsUsuarios_p = str_replace($caracteres, "", $x['ids_usuarios']);

                                #FILTROS
                                if ($configuracionGlobal == 'true') {
                                    $filtroParametro = "and id_parametro = ''";
                                    $filtroFechaRegistro = "and fecha_inicio_registro = '$fechaInicio_b'";
                                    $filtroHoraRegistro = "and hora_inicio_registro = '$horaInicio_b'";
                                    $filtroCiclosHoras = "and ciclo_horas = '$ciclo_b'";
                                } else {
                                    $filtroParametro = "and id_parametro = '$idParametro'";
                                    $filtroFechaRegistro = "and fecha_inicio_registro = '$fechaInicio_p'";
                                    $filtroHoraRegistro = "and hora_inicio_registro = '$horaInicio_p'";
                                    $filtroCiclosHoras = "and ciclo_horas = '$ciclo_p'";
                                }

                                #LINEA DE TIEMPO
                                $query = "SELECT lt.id, fecha_token
                                FROM t_bitacoras_linea_tiempo AS lt
                                WHERE id_bitacora = '$idBitacora' and
                                fecha_token BETWEEN '" . date("Y-m-d 00:00:01") . "' and '" . date("Y-m-d 23:59:59") . "' and activo = 1
                                $filtroParametro $filtroFechaRegistro $filtroHoraRegistro $filtroCiclosHoras";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    foreach ($result as $x) {
                                        $idLineaTiempo = $x['id'];
                                        $fechaToken = $x['fecha_token'];
                                        $horarioInput = (new \DateTime($fechaToken))->format('H:m');

                                        $idValor = 0;
                                        $valor = "";
                                        $crearIncidencia = "NO";
                                        $idIncidencia = "";
                                        $fechaCaptura = "";
                                        $enTiempo = "";
                                        $status = "PENDIENTE";
                                        $enTiempo = "";
                                        $estado = "ESPERA";

                                        #VALOR
                                        $query = "SELECT id, valor, crear_incidencia,
                                        id_incidencia, fecha_captura, status
                                        FROM t_bitacora_capturas
                                        WHERE id_bitacora = '$idBitacora' and id_parametro = '$idParametro' 
                                        and id_equipo = '$idEquipo' and fecha_token = '$fechaToken' and activo = 1";
                                        if ($result = mysqli_query($conn_2020, $query)) {
                                            foreach ($result as $x) {
                                                $idValor = $x['id'];
                                                $valor = $x['valor'];
                                                $crearIncidencia = $x['crear_incidencia'];
                                                $idIncidencia = $x['id_incidencia'];
                                                $fechaCaptura = $x['fecha_captura'];
                                                $status = $x['status'];
                                                $estado = "CAPTURADO";
                                                $fechaLR = strtotime($fechaToken);
                                                $fechaL = strtotime("+30 minutes", strtotime($fechaToken));
                                                $fechaR = strtotime("-30 minutes", strtotime($fechaToken));

                                                if ($fechaL <= $fechaLR && $fechaR >= $fechaLR)
                                                    $enTiempo = "SI";
                                                else
                                                    $enTiempo = "NO";
                                            }
                                        }

                                        $parametros[] = array(
                                            "idBitacora" => $idBitacora,
                                            "bitacora" => $bitacora,
                                            "idParametro" => $idParametro,
                                            "parametro" => $parametro,
                                            "idEquipo" => $idEquipo,
                                            "equipo" => $equipo,
                                            "tipoEquipo" => $tipoEquipo,
                                            "medida" => $medida,
                                            "parametroMinimo" => $parametroMinimo,
                                            "parametroMaximo" => $parametroMaximo,
                                            "idLineaTiempo" => $idLineaTiempo,
                                            "idLineaTiempo" => $idLineaTiempo,
                                            "fechaToken" => $fechaToken,
                                            "horarioInput" => $horarioInput,
                                            "idValor" => $idValor,
                                            "valor" => $valor,
                                            "crearIncidencia" => $crearIncidencia,
                                            "idIncidencia" => $idIncidencia,
                                            "fechaCaptura" => $fechaCaptura,
                                            "enTiempo" => $enTiempo,
                                            "status" => $status,
                                            "enTiempo" => $enTiempo,
                                            "estado" => $estado,
                                        );
                                    }
                                }
                            }
                        }

                        $array['data'][] = array(
                            "idDestino" => $idDestinoX,
                            "destino" => $destino,
                            "idEquipo" => $idEquipo,
                            "equipo" => $equipo,
                            "idBitacora" => $idBitacora,
                            "bitacora" => $bitacora,
                            "parametros" => $parametros,
                            "tipoEquipo" => $tipoEquipo,
                        );
                    }
                }
            }
        }
    }

    // Cierre
}



echo json_encode($array);
