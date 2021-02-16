<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';

if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $semanaActual = date('W');
    $array = array();

    #OBTIENE DATOS POR DESTINO
    if ($action == "datosIniciales") {
        $array = array();

        #DESTINO
        $destino = "";
        $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $destino = $x['destino'];
            }
        }
        $array['destino'] = $destino;

        #TIPOS DE ACTIVOS
        $totalTipos = 0;
        $query = "SELECT count(id) 'total' FROM c_tipos WHERE status = 'A'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalTipos = $x['total'];
            }
        }
        $array['tipos'] = $totalTipos;

        #USUARIOS
        $totalUsuarios = 0;
        $query = "SELECT count(id) 'total' FROM t_users WHERE status = 'A' and activo = 1 and id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalUsuarios = $x['total'];
            }
        }
        $array['usuarios'] = $totalUsuarios;

        #SUBSECCIONES
        $totalSubsecciones = 0;
        $query = "SELECT count(id) 'total' FROM c_subsecciones";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalSubsecciones = $x['total'];
            }
        }
        $array['subsecciones'] = $totalSubsecciones;

        #EQUIPOS
        $totalEquipos = 0;
        $query = "SELECT count(id) 'total' FROM t_equipos_america 
        WHERE status IN('OPERATIVO', 'TALLER') and activo = 1 and id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalEquipos = $x['total'];
            }
        }
        $array['equipos'] = $totalEquipos;

        #PLANES
        $totalPlanes = 0;
        $query = "SELECT count(id) 'total' FROM t_mp_planes_mantenimiento 
        WHERE status IN('ACTIVO') and activo = 1 and id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $totalPlanes = $x['total'];
            }
        }

        $array['planes'] = $totalPlanes;
        $array['materiales'] = 0;
        $array['bodegas'] = 0;

        echo json_encode($array);
    }

    if ($action == "obtenerUsuarios") {
        $configuracionIdUsuario = $_GET['configuracionIdUsuario'];

        if ($configuracionIdUsuario > 0) {
            $filtroUsuario = "and t_users.id = $configuracionIdUsuario";
        } else {
            $filtroUsuario = "";
        }

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_users.id_destino = $idDestino";
        }


        $query = "SELECT t_users.id, t_users.username, t_users.password, t_users.status, t_colaboradores.email, t_colaboradores.nombre, t_colaboradores.apellido, 
        t_colaboradores.email, t_colaboradores.telefono, c_destinos.destino, c_cargos.cargo, c_permisos.permiso, c_fases.id 'idFase', c_fases.fase,
        t_users.DECC,
        t_users.ZIL,
        t_users.ZIE,
        t_users.AUTO,
        t_users.DEP,
        t_users.OMA,
        t_users.ZHA,
        t_users.ZHC,
        t_users.ZHH,
        t_users.ZHP,
        t_users.ZIA,
        t_users.ZIC
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN c_destinos ON t_users.id_destino = c_destinos.id
        LEFT JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        LEFT JOIN c_permisos ON t_users.id_permiso = c_permisos.id
        LEFT JOIN c_fases ON t_users.fase = c_fases.id
        WHERE t_users.activo = 1 $filtroDestino $filtroUsuario
        ORDER BY t_users.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idUsuario = $x['id'];
                $nombre = $x['nombre'];
                $apellido = $x['apellido'];
                $correo = $x['email'];
                $telefono = $x['telefono'];
                $idFase = $x['idFase'];
                $fase = $x['fase'];
                $status = $x['status'];
                $usuario = $x['username'];
                $contraseña = $x['password'];
                $destino = $x['destino'];
                $cargo = $x['cargo'];
                $rol = $x['permiso'];
                $DEC = $x['DECC'];
                $ZIL = $x['ZIL'];
                $ZIE = $x['ZIE'];
                $AUTO = $x['AUTO'];
                $DEP = $x['DEP'];
                $OMA = $x['OMA'];
                $ZHA = $x['ZHA'];
                $ZHC = $x['ZHC'];
                $ZHH = $x['ZHH'];
                $ZHP = $x['ZHP'];
                $ZIA = $x['ZIA'];
                $ZIC = $x['ZIC'];

                if ($cargo == "" || $cargo == " ") {
                    $cargo = "-";
                }

                if ($rol == "" || $rol == " ") {
                    $rol = "-";
                }

                if ($fase == "" || $fase == " ") {
                    $fase = "-";
                }

                $array[] = array(
                    "idUsuario" => $idUsuario,
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "correo" => $correo,
                    "telefono" => $telefono,
                    "fase" => $fase,
                    "status" => $status,
                    "usuario" => $usuario,
                    "contraseña" => $contraseña,
                    "destino" => $destino,
                    "cargo" => $cargo,
                    "rol" => $rol,
                    "DEC" => intval($DEC),
                    "ZIL" => intval($ZIL),
                    "ZIE" => intval($ZIE),
                    "AUTO" => intval($AUTO),
                    "DEP" => intval($DEP),
                    "OMA" => intval($OMA),
                    "ZHA" => intval($ZHA),
                    "ZHC" => intval($ZHC),
                    "ZHH" => intval($ZHH),
                    "ZHP" => intval($ZHP),
                    "ZIA" => intval($ZIA),
                    "ZIC" => intval($ZIC)
                );
            }
        }
        echo json_encode($array);
    }

    if ($action == "obtenerUsuariosX") {
        $configuracionIdUsuario = $_GET['configuracionIdUsuario'];
        $arrayX = array();

        if ($configuracionIdUsuario > 0) {
            $filtroUsuario = "and t_users.id = $configuracionIdUsuario";
        } else {
            $filtroUsuario = "";
        }

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_users.id_destino = $idDestino";
        }

        $query = "SELECT t_users.id, t_users.username, t_users.password, t_users.status, t_colaboradores.email, t_colaboradores.nombre, t_colaboradores.apellido, 
        t_colaboradores.email, t_colaboradores.telefono, c_destinos.id 'idDestino', c_destinos.destino, c_cargos.id 'idCargo', c_cargos.cargo, c_permisos.id 'idRol', c_permisos.permiso, c_fases.id 'idFase', c_fases.fase, c_acciones_usuarios.entradas_sa, 
        c_acciones_usuarios.salidas_sa, c_acciones_usuarios.importar_gastos, 
        c_acciones_usuarios.acceso_sa,
        t_users.DECC,
        t_users.ZIL,
        t_users.ZIE,
        t_users.AUTO,
        t_users.DEP,
        t_users.OMA,
        t_users.ZHA,
        t_users.ZHC,
        t_users.ZHH,
        t_users.ZHP,
        t_users.ZIA,
        t_users.ZIC
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN c_destinos ON t_users.id_destino = c_destinos.id
        LEFT JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        LEFT JOIN c_permisos ON t_users.id_permiso = c_permisos.id
        LEFT JOIN c_fases ON t_users.fase = c_fases.id
        LEFT JOIN c_acciones_usuarios ON t_users.id = c_acciones_usuarios.id_usuario
        WHERE t_users.activo = 1 $filtroDestino $filtroUsuario
        ORDER BY t_users.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idUsuario = $x['id'];
                $nombre = $x['nombre'];
                $apellido = $x['apellido'];
                $correo = $x['email'];
                $telefono = $x['telefono'];
                $idFase = $x['idFase'];
                $fase = $x['fase'];
                $status = $x['status'];
                $usuario = $x['username'];
                $contraseña = $x['password'];
                $idDestinoX = $x['idDestino'];
                $destino = $x['destino'];
                $idCargo = $x['idCargo'];
                $cargo = $x['cargo'];
                $idRol = $x['idRol'];
                $rol = $x['permiso'];
                $DEC = $x['DECC'];
                $ZIL = $x['ZIL'];
                $ZIE = $x['ZIE'];
                $AUTO = $x['AUTO'];
                $DEP = $x['DEP'];
                $OMA = $x['OMA'];
                $ZHA = $x['ZHA'];
                $ZHC = $x['ZHC'];
                $ZHH = $x['ZHH'];
                $ZHP = $x['ZHP'];
                $ZIA = $x['ZIA'];
                $ZIC = $x['ZIC'];
                $entradas_sa = $x['entradas_sa'];
                $salidas_sa = $x['salidas_sa'];
                $importar_gastos = $x['importar_gastos'];
                $acceso_sa = $x['acceso_sa'];

                if ($cargo == "" || $cargo == " ") {
                    $cargo = "-";
                }

                if ($rol == "" || $rol == " ") {
                    $rol = "-";
                }

                if ($fase == "" || $fase == " ") {
                    $fase = "-";
                }

                if ($status == "ACTIVO" || $status == "A") {
                    $idStatus = "ACTIVO";
                    $status = "ACTIVO";
                } else {
                    $idStatus = "BAJA";
                    $status = "BAJA";
                }

                if ($entradas_sa == 1) {
                    $entradas = 1;
                } else {
                    $entradas = 0;
                }

                if ($salidas_sa == 1) {
                    $salidas = 1;
                } else {
                    $salidas = 0;
                }

                if ($importar_gastos == 1) {
                    $importar = 1;
                } else {
                    $importar = 0;
                }

                if ($idDestinoX == 10) {
                    $filtroDestinoSubalmacen = "";
                } else {
                    $filtroDestinoSubalmacen = "and id_destino = $idDestino";
                }

                if ($acceso_sa != "") {
                    $query = "SELECT id, nombre FROM t_subalmacenes WHERE activo = 1 and 
                    id IN($acceso_sa)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $idSubalmacen = $x["id"];
                            $subalmacen = $x["nombre"];

                            $arrayX[] =
                                array(
                                    "idSubalmacen" => $idSubalmacen,
                                    "subalmacen" => $subalmacen
                                );
                        }
                    }
                }

                // SECCIONES
                $secciones[] = array("seccion" => "DEC", "valor" => intval($DEC));
                $secciones[] = array("seccion" => "ZIL", "valor" => intval($ZIL));
                $secciones[] = array("seccion" => "ZIE", "valor" => intval($ZIE));
                $secciones[] = array("seccion" => "AUTO", "valor" => intval($AUTO));
                $secciones[] = array("seccion" => "DEP", "valor" => intval($DEP));
                $secciones[] = array("seccion" => "OMA", "valor" => intval($OMA));
                $secciones[] = array("seccion" => "ZHA", "valor" => intval($ZHA));
                $secciones[] = array("seccion" => "ZHC", "valor" => intval($ZHC));
                $secciones[] = array("seccion" => "ZHH", "valor" => intval($ZHH));
                $secciones[] = array("seccion" => "ZHP", "valor" => intval($ZHP));
                $secciones[] = array("seccion" => "ZIA", "valor" => intval($ZIA));
                $secciones[] = array("seccion" => "ZIC", "valor" => intval($ZIC));

                $array[] = array(
                    "idUsuario" => intval($idUsuario),
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "correo" => $correo,
                    "telefono" => $telefono,
                    "idFase" => intval($idFase),
                    "fase" => $fase,
                    "idStatus" => $idStatus,
                    "status" => $status,
                    "usuario" => $usuario,
                    "contraseña" => $contraseña,
                    "idDestino" => $idDestinoX,
                    "destino" => $destino,
                    "idCargo" => intval($idCargo),
                    "cargo" => $cargo,
                    "idRol" => $idRol,
                    "rol" => $rol,
                    "entradas" => intval($entradas),
                    "salidas" => intval($salidas),
                    "importar" => intval($importar),
                    "secciones" => $secciones,
                    "subalmacenes" => $arrayX
                );
            }
        }
        echo json_encode($array);
    }

    if ($action == "opcionesUsuario") {
        $array = array();

        // FILTROS 
        if ($idDestino == 10) {
            $filtroDestinoSubalmacen = "";
        } else {
            $filtroDestinoSubalmacen = "and t_subalmacenes.id_destino = $idDestino";
        }


        // FASES
        $query = "SELECT id, fase FROM c_fases WHERE (status = 'A' or status = 'ACTIVO')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idFase = $x['id'];
                $fase = $x['fase'];

                $array['fases'][] = array("idFase" => $idFase, "fase" => $fase);
            }
        }

        // SECCIONES
        $query = "SELECT id, seccion FROM c_secciones WHERE (status = 'A' or status = 'ACTIVO')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSeccion = $x['id'];
                $seccion = $x['seccion'];

                $array['secciones'][] = array("idSeccion" => $idSeccion, "seccion" => $seccion);
            }
        }

        // DESTINOS
        $query = "SELECT id, destino FROM c_destinos WHERE (status = 'A' or status = 'ACTIVO')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['id'];
                $destino = $x['destino'];

                $array['destinos'][] = array("idDestino" => $idDestinoX, "destino" => $destino);
            }
        }

        // CARGOS
        $query = "SELECT id, cargo FROM c_cargos WHERE (status = 'A' or status = 'ACTIVO') 
        ORDER BY cargo ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idCargo = $x['id'];
                $cargo = $x['cargo'];

                $array['cargos'][] = array("idCargo" => $idCargo, "cargo" => $cargo);
            }
        }

        // ROLES O PERMISOS
        $query = "SELECT id, permiso FROM c_permisos";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idPermiso = $x['id'];
                $permiso = $x['permiso'];

                $array['roles'][] = array("idRol" => $idPermiso, "rol" => $permiso);
            }
        }

        // STATUS
        $array['status'][] = array("idStatus" => "ACTIVO", "status" => "ACTIVO");
        $array['status'][] = array("idStatus" => "BAJA", "status" => "BAJA");

        // PERMISOS SUBALMACENES
        $array['opcionSubalmacenes'][] =
            array("idOpcion" => "entradas_sa", "opcion" => "Entradas");
        $array['opcionSubalmacenes'][] =
            array("idOpcion" => "salidas_sa", "opcion" => "Salidas");
        $array['opcionSubalmacenes'][] =
            array("idOpcion" => "importar_gastos", "opcion" => "Importar");

        // SUBALMACENES
        $query = "SELECT t_subalmacenes.id, t_subalmacenes.nombre, t_subalmacenes.fase, 
        c_destinos.destino
        FROM t_subalmacenes
        LEFT JOIN c_destinos ON t_subalmacenes.id_destino = c_destinos.id
        WHERE t_subalmacenes.activo = 1 $filtroDestinoSubalmacen";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSubalmacen = $x['id'];
                $nombre = $x['nombre'];
                $fase = $x['fase'];
                $destino = $x['destino'];

                $array['subalmacenes'][] =
                    array(
                        "idSubalmacen" => $idSubalmacen,
                        "nombre" => $nombre,
                        "fase" => $fase,
                        "destino" => $destino
                    );
            }
        }

        // Regresa valores obtenidos
        echo json_encode($array);
    }

    if ($action == "actualizarUsuario") {
        $nombre = $_GET['nombre'];
        $apellido = $_GET['apellido'];
        $correo = $_GET['correo'];
        $telefono = $_GET['telefono'];
        $usuario = $_GET['usuario'];
        $contraseña = $_GET['contraseña'];
        $configuracionIdUsuario = $_GET['configuracionIdUsuario'];
        $resp = "0";

        if ($configuracionIdUsuario <= 0 && $nombre != "" && $apellido != "" && $correo != "" && $telefono != "" && $usuario != "" && $contraseña != "") {

            $query = "SELECT id FROM t_users WHERE username = '$usuario'";
            $existente = "0";
            if ($result = mysqli_query($conn_2020, $query)) {
                $existente = mysqli_num_rows($result);
            }

            if ($existente == "0") {
                $query = "SELECT max(id) 'id' FROM t_colaboradores";
                $idColaborador;
                $idUsuarioX;
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idColaborador = intval($x["id"]) + 1;
                    }

                    $query = "INSERT INTO t_colaboradores(id, nombre, apellido, telefono, email) 
                    VALUES($idColaborador, '$nombre', '$apellido', '$telefono', '$correo')";
                    if ($result = mysqli_query($conn_2020, $query)) {

                        $query = "INSERT INTO t_users(id, username, password, id_colaborador, id_permiso, id_destino, fase, status) VALUES (null, '$usuario', '$contraseña', $idColaborador, 2, $idDestino, 0, 'A')";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $resp = "1";
                        }
                    }
                }
            } else {
                $resp = "EXISTENTE";
            }
        } elseif ($configuracionIdUsuario > 0 && $nombre != "" && $apellido != "" && $correo != "" && $telefono != "" && $usuario != "" && $contraseña != "") {

            $query = "SELECT id, id_colaborador FROM t_users WHERE id = $configuracionIdUsuario";
            $idColaborador;
            $idUsuarioX;
            if ($result = mysqli_query($conn_2020, $query)) {

                foreach ($result as $x) {
                    $idUsuarioX = $x['id'];
                    $idColaborador = $x["id_colaborador"];
                }

                // MODIFICA DATOS DE LA TABLA t_colaboradores
                $query = "UPDATE t_colaboradores SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', email = '$correo' 
                WHERE id = $idColaborador";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "2";
                }

                // MODIFICA DATOS DE LA TABLA t_users
                $query = "UPDATE t_users SET usuario = '$usuario', password = '$contraseña' 
                WHERE id = $idUsuarioX";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = "2";
                }
            }
        } else {
            $resp = "3";
        }

        echo json_encode($resp);
    }

    if ($action == "actualizaUsuarioOpciones") {
        $idUsuarioX = $_GET['idUsuarioX'];
        $columna = $_GET['columna'];
        $valor = $_GET['valor'];
        $valorX = 0;
        $resp = 0;
        $idColaborador = 0;

        // OBTIENE EL ID COLABORADOR PARA OPCIONES ADICIONALES
        $query = "SELECT id_colaborador  FROM t_users WHERE id = $idUsuarioX";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idColaborador = $x['id_colaborador'];
            }
        }

        if ($columna == "fase") {
            $query = "UPDATE t_users SET fase = $valor WHERE id = $idUsuarioX";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "seccion") {

            if ($valor == "DEC") {
                $valor = "DECC";
            }

            $query = "SELECT $valor FROM t_users WHERE id = $idUsuarioX";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valorX = $x[$valor];
                }

                if ($valorX == 0) {
                    $valorX = 1;
                } else {
                    $valorX = 0;
                }

                $query = "UPDATE t_users SET $valor = $valorX WHERE id = $idUsuarioX";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = 2;
                }
            }
        } elseif ($columna == "destino") {
            $query = "UPDATE t_users SET id_destino = $valor WHERE id = $idUsuarioX";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 3;
            }
        } elseif ($columna == "cargo") {
            $query = "UPDATE t_colaboradores SET id_cargo = $valor WHERE id = $idColaborador";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 4;
            }
        } elseif ($columna == "rol") {
            $query = "UPDATE t_users SET id_permiso = $valor WHERE id = $idUsuarioX";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 5;
            }
        } elseif ($columna == "status") {

            if ($valor == "ACTIVO" || $valor == "A") {
                $valor = "A";
            } else {
                $valor = "B";
            }

            $query = "UPDATE t_users SET status = '$valor' WHERE id = $idUsuarioX";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 6;
            }
        } elseif ($columna == "entradas_sa" || $columna == "salidas_sa" || $columna == "importar_gastos" || $columna == "acceso_sa") {

            $query = "SELECT id FROM c_acciones_usuarios WHERE id_usuario = $idUsuarioX";
            $existente = 0;
            if ($result = mysqli_query($conn_2020, $query)) {
                $existente = mysqli_num_rows($result);
            }

            if ($existente == 0) {
                $query = "INSERT INTO c_acciones_usuarios(id_usuario, entradas_sa, salidas_sa, importar_gastos, acceso_sa) VALUES($idUsuarioX, 0, 0, 0, '0')";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = 7;
                }
            } else {
                $query = "SELECT $columna FROM c_acciones_usuarios WHERE id_usuario = $idUsuarioX";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $valorX = $x[$columna];
                    }
                }

                if ($columna == "entradas_sa" || $columna == "salidas_sa" || $columna == "importar_gastos") {
                    if ($valorX == 0) {
                        $valor = 1;
                    } else {
                        $valor = 0;
                    }

                    $query = "UPDATE c_acciones_usuarios SET $columna = $valor 
                    WHERE id_usuario = $idUsuarioX";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $resp = 8;
                    }
                } elseif ($columna == "acceso_sa") {
                    $subalmacenSeleccionados = explode(",", $valorX);
                    $indiceSubalmacen = 0;

                    foreach ($subalmacenSeleccionados as $key => $value) {
                        if ($value == $valor) {
                            $indiceSubalmacen = $key;
                        }
                    }

                    if ($indiceSubalmacen > 0) {
                        unset($subalmacenSeleccionados[$indiceSubalmacen]);
                    } else {
                        $subalmacenSeleccionados[] = "$valor";
                    }

                    $valor = implode(",", $subalmacenSeleccionados);
                    $query = "UPDATE c_acciones_usuarios SET acceso_sa = '$valor' 
                    WHERE id_usuario = $idUsuarioX";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $resp = 9;
                    }
                }
            }
        }

        echo json_encode($resp);
    }

    if ($action == "obtenerCargos") {
        $idCargo = $_GET['idCargo'];
        $array = array();

        if ($idDestino == 10) {
            $filtroDestinoUsuario = "";
        } else {
            $filtroDestinoUsuario = "and t_users.id_usuario = $idDestino";
        }

        if ($idCargo > 0) {
            $filtroCargo = "WHERE id = $idCargo";
        } else {
            $filtroCargo = "";
        }

        $query = "SELECT id, cargo, status FROM c_cargos $filtroCargo ORDER BY cargo DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idCargo = $x["id"];
                $cargo = $x["cargo"];
                $status = $x["status"];

                if ($status == "A" || $status == "ACTIVO") {
                    $status = "ACTIVO";
                } else {
                    $status = "BAJA";
                }

                $totalAsignados = 0;
                $query = "SELECT count(t_users.id) 'total' 
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_colaboradores.id_cargo = $idCargo $filtroDestinoUsuario";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $totalAsignados = $x["total"];
                    }
                }

                $array[] =
                    array(
                        "idCargo" => intval($idCargo),
                        "cargo" => $cargo,
                        "totalAsignados" => intval($totalAsignados),
                        "status" => $status
                    );
            }
        }
        echo json_encode($array);
    }

    if ($action == "actualizarCargo") {
        $idCargo = $_GET['idCargo'];
        $cargo = $_GET['cargo'];
        $status = $_GET['status'];
        $resp;
        if ($idCargo > 0 && $cargo != "" && $status != "") {
            $query = "UPDATE c_cargos SET cargo = '$cargo', status = '$status' 
            WHERE id = $idCargo";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($idCargo == 0 && $cargo != "" && $status != "") {
            $query = "INSERT INTO c_cargos(id, cargo, status) VALUES(null, '$cargo', '$status')";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 2;
            }
        } else {
            $resp = 0;
        }
        echo json_encode($resp);
    }

    #OBTIENE LA RELACION DE SECCIONES Y SUBSECCION POR DESTINO INCLUYENDO DESTINO GLOBAL
    if ($action == "obtenerSeccionesSubsecciones") {
        $array = array();

        $query = "SELECT c_rel_destino_seccion.id, c_rel_destino_seccion.id_destino, c_rel_destino_seccion.id_seccion, c_destinos.destino, c_secciones.seccion
        FROM c_rel_destino_seccion 
        INNER JOIN c_destinos ON c_rel_destino_seccion.id_destino = c_destinos.id
        INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idRelSeccion = $x['id'];
                $idDestino = $x['id_destino'];
                $destino = $x['destino'];
                $idSeccion = $x['id_seccion'];
                $seccion = $x['seccion'];


                $array['secciones'][] = array(
                    "idRelSeccion" => intval($idRelSeccion),
                    "idDestino" => intval($idDestino),
                    "destino" => $destino,
                    "idSeccion" => intval($idSeccion),
                    "seccion" => $seccion
                );

                $query = "SELECT c_rel_seccion_subseccion.id, c_rel_seccion_subseccion.id_subseccion, 
                c_subsecciones.grupo
                FROM c_rel_seccion_subseccion
                INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
                WHERE c_rel_seccion_subseccion.id_rel_seccion = $idRelSeccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idRelSubseccion = $x['id'];
                        $idSubseccion = $x['id_subseccion'];
                        $subseccion = $x['grupo'];

                        $array['subsecciones'][] = array(
                            "idRelSeccion" => intval($idRelSeccion),
                            "idDestino" => intval($idDestino),
                            "destino" => $destino,
                            "idSeccion" => intval($idSeccion),
                            "seccion" => $seccion,
                            "idRelSubseccion" => intval($idRelSubseccion),
                            "subseccion" => $subseccion,
                            "idSubseccion" => intval($idSubseccion),
                        );
                    }
                }
            }
        }
        echo json_encode($array);
    }

    #ELIMINA LA RELACIÓN DE SECCION SUBSECCION
    if ($action == "eliminarSeccionSubseccion") {
        $idRelSubseccion = $_GET['idRelSubseccion'];
        $resp = 0;
        $query = "DELETE FROM c_rel_seccion_subseccion WHERE id = $idRelSubseccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }

    #AGREGA RELACIÓN DE SECCION SUBSECCION
    if ($action == "agregarSeccionSubseccion") {
        $idRelSeccion = $_GET['idRelSeccion'];
        $idSeccion = $_GET['idSeccion'];
        $subseccion = $_GET['subseccion'];
        $resp = 0;

        $idMax = 0;
        $query = "SELECT max(id) 'idMax' FROM c_subsecciones";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idMax = intval($x['idMax']) + 1;
            }
        }

        if ($idMax > 0) {
            $query = "INSERT INTO c_subsecciones(id, id_seccion, grupo, id_destino) VALUES($idMax, $idSeccion, '$subseccion', 0)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $query = "INSERT INTO c_rel_seccion_subseccion(id_rel_seccion, id_subseccion) VALUES($idRelSeccion, $idMax)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = 1;
                }
            }
        }
        echo json_encode($resp);
    }

    #OBTIENE LOS TIPOS DE ACTIVOS
    if ($action == "obtenerTiposActivos") {
        $array = array();

        $query = "SELECT id, tipo, tipo_activo FROM c_tipos WHERE status = 'A'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTipo = $x['id'];
                $tipo = $x['tipo'];
                $tipoActivo = $x['tipo_activo'];

                $array[] = array(
                    "idTipo" => intval($idTipo),
                    "tipo" => $tipo,
                    "tipoActivo" => $tipoActivo
                );
            }
        }
        echo json_encode($array);
    }

    #AGREGAR TIPO DE ACTIVO
    if ($action == "agregarTipoActivo") {
        $tipo = $_GET['tipo'];
        $tipoActivo = $_GET['tipoActivo'];
        $resp = 0;

        $query = "INSERT INTO c_tipos(tipo, tipo_activo, status) VALUES('$tipo', '$tipoActivo', 'A')";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }

    #ELIMINA TIPO DE ACTIVO
    if ($action == "eliminarTipoActivo") {
        $idTipo = $_GET['idTipo'];
        $resp = 0;

        $query = "UPDATE c_tipos SET status = 'B' WHERE id = $idTipo";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    #OBTIENE LOS SUBALMACENES Y BODEGAS
    if ($action == "obtenerSubalmacenes") {
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        $query = "SELECT id, nombre, fase, tipo 
        FROM t_subalmacenes 
        WHERE activo = 1 $filtroDestino ORDER BY tipo ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSubalmacen = $x['id'];
                $nombre = $x['nombre'];
                $fase = $x['fase'];
                $tipo = $x['tipo'];

                $array[] = array(
                    "idSubalmacen" => intval($idSubalmacen),
                    "nombre" => $nombre,
                    "fase" => $fase,
                    "tipo" => $tipo,
                );
            }
        }
        echo json_encode($array);
    }


    #ELIMINA TIPO DE ACTIVO
    if ($action == "eliminarSubalmacen") {
        $idSubalmacen = $_GET['idSubalmacen'];
        $resp = 0;

        $query = "UPDATE t_subalmacenes SET activo = 0 WHERE id = $idSubalmacen";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }

    #AGREGA SUBALMACENES
    if ($action == "agregarSubalmacen") {
        $fase = $_GET['fase'];
        $subalmacen = $_GET['subalmacen'];
        $tipo = $_GET['tipo'];
        $resp = 0;

        if ($fase == "GP") {
            $idFase = 1;
        } elseif ($fase == "TRS") {
            $idFase = 2;
        } elseif ($fase == "ZI") {
            $idFase = 3;
        }

        $query = "INSERT INTO t_subalmacenes(id_destino, id_fase, nombre, fase, tipo, activo) VALUES ($idDestino, $idFase, '$subalmacen', '$fase', '$tipo', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    // Final
}
