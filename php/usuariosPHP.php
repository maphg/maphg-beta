<?php
session_set_cookie_params(60 * 60 * 24 * 364);
session_start();
include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == 1) {
        $username = $_POST['txtUsername'];
        $password = $_POST['txtPassword'];
        $obj = new Usuarios();
        $resp = $obj->validarUsuario($username, $password);
        echo $resp;
    }

    if ($action == 2) {
        $obj = new Usuarios();
        $resp = $obj->logout();
        echo $resp;
    }

    if ($action == 3) {
        $idPersonal = $_POST['idPersonal'];
        $obj = new Usuarios();
        $resp = $obj->obtEmpleado($idPersonal);
        echo json_encode($resp);
    }

    if ($action == 4) {
        $idUsuario = $_POST['idUsuario'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $obj = new Usuarios();
        $resp = $obj->actualizar($idUsuario, $telefono, $email);
        echo $resp;
    }

    if ($action == 5) {
        $conn = new Conexion();
        $conn->conectar();
        $ds = DIRECTORY_SEPARATOR; //1 
        $storeFolder = '../img/users/'; //2
        $idUsuario = $_POST['id'];

        if (!empty($_FILES)) {
            $tempFile = $_FILES['fileToUpload']['tmp_name'];
            $realFileName = $_FILES['fileToUpload']['name'];
            $file = pathinfo($realFileName);
            $fileExtension = $file['extension'];
            $targetPath = $storeFolder;
            $fileName = $idUsuario . rand() . ".$fileExtension";
            $targetFile = $targetPath . $fileName;


            if (file_exists($targetFile)) {
            } else {
                $query = "SELECT * FROM t_users WHERE id = $idUsuario";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idCol = $dts['id_colaborador'];
                        }
                        //q$query = "INSERT INTO t_equipos_img(id_equipo, url_image) VALUES($idEquipo, '$fileName')";
                        $query = "UPDATE t_colaboradores SET foto = '$fileName' WHERE id = $idCol";
                        try {
                            $resp = $conn->consulta($query);
                            if ($resp == 1) {
                                move_uploaded_file($tempFile, $targetFile);
                                $resp = "Archivo cargado con exito";
                            }
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        }
        $conn->cerrar();
        echo $resp;
    }

    if ($action == 6) {
        $col = new Usuarios();
        $idDepto = $_POST['idDepto'];
        $resp = $col->cargarPuestos($idDepto);
        echo $resp;
    }

    if ($action == 7) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $depto = $_POST['depto'];
        $cargo = $_POST['cargo'];
        $nivel = $_POST['nivel'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $permiso = $_POST['permiso'];
        $destino = $_POST['destino'];
        $fase = $_POST['fase'];
        $seccion = $_POST['seccion'];
        //        $propInt = $_POST['propInt'];
        //        $fecProp = $_POST['fechaProp'];
        //        $fecReal = $_POST['fechaReal'];
        $contratado = $_POST['contratado'];
        $trabajando = $_POST['trabajando'];
        $usuario = $_POST['usuario'];

        $col = new Usuarios();
        $resp = $col->agregarColaborador($nombre, $apellido, $telefono, $email, $depto, $cargo, $nivel, $username, $password, $permiso, $destino, $fase, $seccion, $contratado, $trabajando, $usuario);
        echo $resp;
    }

    if ($action == 8) {
        $idEmpleado = $_POST['idEmpleado'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $email = $_POST['email'];
        $destino = $_POST['destino'];
        $cargo = $_POST['cargo'];
        $nivel = $_POST['nivel'];
        $fase = $_POST['fase'];
        $seccion = $_POST['seccion'];
        //        $fechaPropIng = $_POST['fechaPropIng'];
        //        $fechaRealIng = $_POST['fechaRealIng'];
        //        $trabajando = $_POST['trabajando'];

        $obj = new Usuarios();
        $resp = $obj->actualizarEmpleado($idEmpleado, $nombre, $apellido, $telefono, $email, $destino, $cargo, $nivel, $fase, $seccion);
        echo $resp;
    }

    if ($action == 9) {
        $idEmpleado = $_POST['idEmpleado'];
        $idUsuario = $_POST['idUsuario'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $permiso = $_POST['permiso'];
        $codigoSA = $_POST['codigoSA'];
        $acciones = $_POST['acciones'];
        $subalmacenes = $_POST['subalmacenes'];

        $obj = new Usuarios();
        $resp = $obj->actualizarUsuario($idEmpleado, $idUsuario, $username, $password, $permiso, $codigoSA, $acciones, $subalmacenes);
        echo $resp;
    }

    if ($action == 10) {
        $idEmpleado = $_POST['idEmpleado'];
        $obj = new Usuarios();
        $resp = $obj->eliminarEmpleado($idEmpleado);
        echo $resp;
    }

    if ($action == 11) {
        $idUser = $_POST['idUser'];
        $obj = new Usuarios();
        $resp = $obj->eliminarUsuario($idUser);
        echo $resp;
    }

    if ($action == 12) {
        $idEmpleado = $_POST['idEmpleado'];
        $sueldoD = $_POST['sueldoD'];
        $obj = new Usuarios();
        $resp = $obj->actualizarSueldo($idEmpleado, $sueldoD);
        echo $resp;
    }

    if ($action == 13) {
        $obj = new Usuarios();
        $resp = $obj->obtListaTrabajadores();
        echo $resp;
    }

    if ($action == 14) {
        $word = $_POST['word'];
        $obj = new Usuarios();
        $resp = $obj->buscarTrabajador($word);
        echo $resp;
    }

    if ($action == "iniciarSession") {
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $array = array();

        $array[0] = array(
            "idUsuario" => 0,
            "idDestino" => 0,
            "nombre" => 0,
            "apellido" => 0,
            "destino" => 0,
            "superAdmin" => 0,
            "acceso" => "DENEGADO"
        );

        $query = "SELECT t_users.id 'idUsuario', t_users.super_admin 'superAdmin', c_destinos.destino, c_destinos.id 'idDestino', t_colaboradores.nombre, t_colaboradores.apellido, c_cargos.cargo
        FROM t_users 
        INNER JOIN c_destinos ON t_users.id_destino = c_destinos.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        WHERE t_users.username = '$usuario' and t_users.password = '$contraseña' and t_users.status = 'A' and t_users.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idUsuario = $x['idUsuario'];
                $nombre = $x['nombre'];
                $apellido = $x['apellido'];
                $cargo = $x['cargo'];
                $idDestino = $x['idDestino'];
                $destino = $x['destino'];
                $superAdmin = $x['superAdmin'];

                $array[0] = array(
                    "idUsuario" => intval($idUsuario),
                    "idDestino" => intval($idDestino),
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "destino" => $destino,
                    "superAdmin" => $superAdmin,
                    "acceso" => "ACCESO"
                );
            }
        }
        echo json_encode($array);
    }
}

class Empleado
{

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $idPuesto;
    public $idNivel;
    public $foto;
    public $idDestino;
    public $super_admin;
    public $idSeccion;
    public $idFase;
    public $idUsuario;
    public $username;
    public $password;
    public $idPermiso;
    public $fechaPropIngreso;
    public $fechaRealIngreso;
    public $trabajando;
    public $statusCol;
    public $statusUser;
    public $sueldoDiario;
    public $acciones;
    public $accesoSA;
    public $codigoSA;
}

class Usuarios
{

    public function validarUsuario($username, $password)
    {
        $arrayData = array();
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT * FROM t_users WHERE username = '$username' AND status = 'A'";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idUsuario = $dts['id'];
                    $idPermiso = $dts['id_permiso'];
                    $idDestino = $dts['id_destino'];
                    $pass = $dts['password'];
                    $super_admin = $dts['super_admin'];
                }
                if ($password == $pass) {
                    $arrayData['usuario'] = $idUsuario;
                    $arrayData['idDestino'] = $idDestino;
                    $arrayData['superAdmin'] = $super_admin;

                    $_SESSION['usuario'] = $idUsuario;
                    $_SESSION['idDestino'] = $idDestino;
                    $_SESSION['super_admin'] = $super_admin;
                    $resp = "1";
                    date_default_timezone_set('America/Cancun');
                    $hoy = getdate();
                    $dia = $hoy['weekday'];

                    // Función comentada para evitar quitar permisos en la nueva version. 2020
                    // switch ($dia) {
                    //     case 'Monday':
                    //         if ($idPermiso == 1 || $idPermiso == 3) {
                    //             $query = "UPDATE t_users SET "
                    //                 . "DECC = 0, ZHAGP = 0, ZHATRS = 0, ZHCGP = 0, ZHCTRS = 0, ZHHGP = 0, ZHHTRS = 0,"
                    //                 . "ZHPGP = 0, ZHPTRS = 0, ZIA = 1, ZIC = 0, ZIE = 0, ZIL = 0, AUTO = 0, ZHA = 0, "
                    //                 . "ZHC = 0, ZHP = 1, DEP = 0, SEG = 0, OMA = 0, ZHH = 0 WHERE id = $idUsuario";
                    //             try {
                    //                 $resp = $conn->consulta($query);
                    //             } catch (Exception $ex) {
                    //                 echo $ex;
                    //             }
                    //         }
                    //         break;
                    //     case 'Tuesday':
                    //         if ($idPermiso == 1 || $idPermiso == 3) {
                    //             $query = "UPDATE t_users SET "
                    //                 . "DECC = 0, ZHAGP = 0, ZHATRS = 0, ZHCGP = 0, ZHCTRS = 0, ZHHGP = 0, ZHHTRS = 0,"
                    //                 . "ZHPGP = 0, ZHPTRS = 0, ZIA = 0, ZIC = 1, ZIE = 0, ZIL = 0, AUTO = 0, ZHA = 0, "
                    //                 . "ZHC = 0, ZHP = 0, DEP = 0, SEG = 0, OMA = 0, ZHH = 0 WHERE id = $idUsuario";
                    //             try {
                    //                 $resp = $conn->consulta($query);
                    //             } catch (Exception $ex) {
                    //                 echo $ex;
                    //             }
                    //         }

                    //         break;
                    //     case 'Wednesday':
                    //         if ($idPermiso == 1 || $idPermiso == 3) {
                    //             $query = "UPDATE t_users SET "
                    //                 . "DECC = 1, ZHAGP = 0, ZHATRS = 0, ZHCGP = 0, ZHCTRS = 0, ZHHGP = 0, ZHHTRS = 0,"
                    //                 . "ZHPGP = 0, ZHPTRS = 0, ZIA = 0, ZIC = 0, ZIE = 1, ZIL = 0, AUTO = 0, ZHA = 0, "
                    //                 . "ZHC = 0, ZHP = 0, DEP = 0, SEG = 0, OMA = 0, ZHH = 0 WHERE id = $idUsuario";
                    //             try {
                    //                 $resp = $conn->consulta($query);
                    //             } catch (Exception $ex) {
                    //                 echo $ex;
                    //             }
                    //         }

                    //         break;
                    //     case 'Thursday':
                    //         if ($idPermiso == 1 || $idPermiso == 3) {
                    //             $query = "UPDATE t_users SET "
                    //                 . "DECC = 0, ZHAGP = 0, ZHATRS = 0, ZHCGP = 0, ZHCTRS = 0, ZHHGP = 0, ZHHTRS = 0, "
                    //                 . "ZHPGP = 0, ZHPTRS = 0, ZIA = 0, ZIC = 0, ZIE = 0, ZIL = 0, AUTO = 0, "
                    //                 . "ZHA = 1, ZHC = 1, ZHP = 0, DEP = 0, SEG = 0, OMA = 0, ZHH = 1 WHERE id = $idUsuario";

                    //             try {
                    //                 $resp = $conn->consulta($query);
                    //             } catch (Exception $ex) {
                    //                 echo $ex;
                    //             }
                    //         }

                    //         break;
                    //     case 'Friday':
                    //         if ($idPermiso == 1 || $idPermiso == 3) {
                    //             $query = "UPDATE t_users SET "
                    //                 . "DECC = 0, ZHAGP = 0, ZHATRS = 0, ZHCGP = 0, ZHCTRS = 0, ZHHGP = 0, ZHHTRS = 0,"
                    //                 . "ZHPGP = 0, ZHPTRS = 0, ZIA = 0, ZIC = 0, ZIE = 0, ZIL = 1, AUTO = 1, ZHA = 0, "
                    //                 . "ZHC = 0, ZHP = 0, DEP = 0, SEG = 0, OMA = 0, ZHH = 0 WHERE id = $idUsuario";


                    //             try {
                    //                 $resp = $conn->consulta($query);
                    //             } catch (Exception $ex) {
                    //                 echo $ex;
                    //             }
                    //         }

                    //         break;
                    //     case 'Saturday':
                    //         if ($idPermiso == 1 || $idPermiso == 3) {
                    //             $query = "UPDATE t_users SET "
                    //                 . "DECC = 0, ZHAGP = 0, ZHATRS = 0, ZHCGP = 0, ZHCTRS = 0, ZHHGP = 0, ZHHTRS = 0,"
                    //                 . "ZHPGP = 0, ZHPTRS = 0, ZIA = 0, ZIC = 0, ZIE = 0, ZIL = 0, AUTO = 0, ZHA = 0, "
                    //                 . "ZHC = 0, ZHP = 0, DEP = 0, SEG = 0, OMA = 0, ZHH = 0 WHERE id = $idUsuario";


                    //             try {
                    //                 $resp = $conn->consulta($query);
                    //             } catch (Exception $ex) {
                    //                 echo $ex;
                    //             }
                    //         }

                    //         break;
                    // }
                    //header('Location: ../index.php');
                } else {
                    $resp = "2";
                }
            } else {
                $resp = "3";
            }

            // NOTIFIACIÓN ACCESO PLATAFORMA - TELEGRAM
            if ($resp == 1) {
                $status = "(CONCEDIDO)";
            } else {
                $status = "(DENEGADO)";
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        // return $resp;
        $arrayData['respuesta'] = $resp;
        echo json_encode($arrayData);
    }

    public function logout()
    {
        if (isset($_SESSION['usuario'])) {
            unset($_SESSION['usuario']);
            $resp = "1";
        } else {
            $resp = "Hubo un error al cerrar la sesión";
        }

        return $resp;
    }

    public function obtEmpleado($idPersonal)
    {
        $conn = new Conexion();
        $conn->conectar();
        $empleado = new Empleado();
        $idDestino = $_SESSION['idDestino'];
        $query = "SELECT * FROM t_colaboradores WHERE id = $idPersonal";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $empleado->id = $dts['id'];
                    $empleado->nombre = $dts['nombre'];
                    $empleado->apellido = $dts['apellido'];
                    $empleado->telefono = $dts['telefono'];
                    $empleado->email = $dts['email'];
                    $empleado->idPuesto = $dts['id_cargo'];
                    $empleado->idNivel = $dts['id_nivel'];
                    $empleado->foto = $dts['foto'];
                    $empleado->idDestino = $dts['id_destino'];
                    $empleado->idSeccion = $dts['id_seccion'];
                    $empleado->idFase = $dts['id_fase'];
                    $empleado->fechaPropIngreso = $dts['incorporacion_propuesta'];
                    $empleado->fechaRealIngreso = $dts['incorporacion_real'];
                    $empleado->trabajando = $dts['trabajando'];
                    $empleado->status = $dts['status'];
                    $empleado->sueldoDiario = $dts['sueldo_diario'];
                    $empleado->codigoSA = $dts['codigo_sa'];

                    $query = "SELECT * FROM t_users "
                        . "WHERE id_colaborador = " . $empleado->id . " "
                        . "AND status = 'A'";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $empleado->idUsuario = $dts['id'];
                                $empleado->username = $dts['username'];
                                $empleado->password = $dts['password'];
                                $empleado->idPermiso = $dts['id_permiso'];
                                $empleado->statusUser = $dts['status'];
                            }
                            $query = "SELECT * FROM c_acciones_usuarios "
                                . "WHERE id_usuario = $empleado->idUsuario";
                            $empleado->acciones = "<h1 class=\"title\">Acciones</h1>";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $entrada = $dts['entradas_sa'];
                                        $salidas = $dts['salidas_sa'];
                                        $importarGastos = $dts['importar_gastos'];
                                        $accesoSA = $dts['acceso_sa'];

                                        if ($entrada == 1) {
                                            $empleado->acciones .= "<div class=\"field\">"
                                                . "<input class=\"is-checkradio\" id=\"entradas_sa\" type=\"checkbox\" name=\"acciones\" checked>"
                                                . "<label for=\"entradas_sa\">" . strtoupper("entradas subalmancen") . "</label>"
                                                . "</div>";
                                        } else {
                                            $empleado->acciones .= "<div class=\"field\">"
                                                . "<input class=\"is-checkradio\" id=\"entradas_sa\" type=\"checkbox\" name=\"acciones\">"
                                                . "<label for=\"entradas_sa\">" . strtoupper("entradas subalmancen") . "</label>"
                                                . "</div>";
                                        }

                                        if ($salidas == 1) {
                                            $empleado->acciones .= "<div class=\"field\">"
                                                . "<input class=\"is-checkradio\" id=\"salidas_sa\" type=\"checkbox\" name=\"acciones\" checked>"
                                                . "<label for=\"salidas_sa\">" . strtoupper("salidas subalmacen") . "</label>"
                                                . "</div>";
                                        } else {
                                            $empleado->acciones .= "<div class=\"field\">"
                                                . "<input class=\"is-checkradio\" id=\"salidas_sa\" type=\"checkbox\" name=\"acciones\">"
                                                . "<label for=\"salidas_sa\">" . strtoupper("salidas subalmacen") . "</label>"
                                                . "</div>";
                                        }

                                        if ($importarGastos == 1) {
                                            $empleado->acciones .= "<div class=\"field\">"
                                                . "<input class=\"is-checkradio\" id=\"importar_gastos\" type=\"checkbox\" name=\"acciones\" checked>"
                                                . "<label for=\"importar_gastos\">" . strtoupper("importar gastos") . "</label>"
                                                . "</div>";
                                        } else {
                                            $empleado->acciones .= "<div class=\"field\">"
                                                . "<input class=\"is-checkradio\" id=\"importar_gastos\" type=\"checkbox\" name=\"acciones\">"
                                                . "<label for=\"importar_gastos\">" . strtoupper("importar gastos") . "</label>"
                                                . "</div>";
                                        }
                                    }
                                } else {
                                    $accesoSA = "";
                                    $empleado->acciones .= "<div class=\"field\">"
                                        . "<input class=\"is-checkradio\" id=\"entradas_sa\" type=\"checkbox\" name=\"acciones\">"
                                        . "<label for=\"entradas_sa\">" . strtoupper("entradas subalmancen") . "</label>"
                                        . "</div>";
                                    $empleado->acciones .= "<div class=\"field\">"
                                        . "<input class=\"is-checkradio\" id=\"salidas_sa\" type=\"checkbox\" name=\"acciones\">"
                                        . "<label for=\"salidas_sa\">" . strtoupper("salidas subalmacen") . "</label>"
                                        . "</div>";
                                    $empleado->acciones .= "<div class=\"field\">"
                                        . "<input class=\"is-checkradio\" id=\"importar_gastos\" type=\"checkbox\" name=\"acciones\"\">"
                                        . "<label for=\"importar_gastos\">" . strtoupper("importar gastos") . "</label>"
                                        . "</div>";
                                }
                            } catch (Exception $ex) {
                                $empleado = $ex;
                            }
                            if ($accesoSA != "") {
                                $subalmacenes = explode(",", $accesoSA);
                            } else {
                                $subalmacenes = [];
                            }

                            $empleado->accesoSA = "<h1 class=\"title\">Acceso Subalmacenes</h1>";

                            if ($idDestino == 10) {
                                $query = "SELECT * FROM t_subalmacenes "
                                    . "WHERE fase != ''";
                            } else {
                                $query = "SELECT * FROM t_subalmacenes "
                                    . "WHERE id_destino = $idDestino "
                                    . "AND fase != ''";
                            }
                            try {
                                $result = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($result as $dt) {
                                        $idSA = $dt['id'];
                                        $nombreSA = $dt['nombre'];

                                        //var_dump($subalmacenes);
                                        //                                        $empleado->accesoSA .= json_encode($subalmacenes);
                                        if (in_array($idSA, $subalmacenes)) {
                                            $empleado->accesoSA .= "<div class=\"field\">"
                                                . "<input class=\"is-checkradio\" id=\"chkbsa_$idSA\" type=\"checkbox\" name=\"subalmacenes\" checked>"
                                                . "<label for=\"chkbsa_$idSA\">" . strtoupper($nombreSA) . "</label>"
                                                . "</div>";
                                        } else {
                                            $empleado->accesoSA .= "<div class=\"field\">"
                                                . "<input class=\"is-checkradio\" id=\"chkbsa_$idSA\" type=\"checkbox\" name=\"subalmacenes\">"
                                                . "<label for=\"chkbsa_$idSA\">" . strtoupper($nombreSA) . "</label>"
                                                . "</div>";
                                        }
                                    }
                                }
                            } catch (Exception $ex) {
                                $empleado = $ex;
                            }
                        } else {
                            $empleado->idUsuario = 0;
                        }
                    } catch (Exception $ex) {
                        $empleado = $ex;
                    }
                }
            }
        } catch (Exception $ex) {
            $empleado = $ex;
        }

        $conn->cerrar();
        return $empleado;
    }

    public function actualizar($idUsuario, $telefono, $email)
    {
        $conn = new Conexion();
        $conn->conectar();
        $query = "SELECT * FROM t_users WHERE id = $idUsuario";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idColaborador = $dts['id_colaborador'];
                }

                $query = "UPDATE t_colaboradores SET telefono = '$telefono', email = '$email' WHERE id = $idColaborador";
                try {
                    $resp = $conn->consulta($query);
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }
        $conn->cerrar();
        return $resp;
    }

    //funcion para obtener la lista de puestos de cada departamento.
    public function cargarPuestos($idDepto)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM c_cargos WHERe id_depto = $idDepto ORDER BY cargo";
        try {
            $resp = $conn->obtDatos($query);
            $salida = "";
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) { //Se recorreo el array para obtener los datos de cada puesto
                    $idCargo = $dts['id'];
                    $cargo = $dts['cargo'];

                    $salida .= "<option value='$idCargo'>" . ($cargo) . "</option>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function agregarColaborador($nombre, $apellido, $telefono, $email, $depto, $cargo, $nivel, $username, $password, $permiso, $destino, $fase, $seccion, $contratado, $trabajando, $usuario)
    {
        $conn = new Conexion();
        $conn->conectar();
        //        date_default_timezone_set('America/Cancun');
        //        $fProp = date("Y-m-d H:i:s", strtotime($fecProp));
        //        $fReal = date("Y-m-d H:i:s", strtotime($fecReal));

        $query = "INSERT INTO t_colaboradores(nombre, apellido, telefono, email, id_cargo, id_nivel, status, id_destino, id_fase, id_seccion, "
            . "contratado, trabajando) "
            . "VALUES('$nombre', '$apellido', '$telefono', '$email', $cargo, $nivel, 'A', $destino, $fase, $seccion, '$contratado', '$trabajando')";

        try {
            $resp = $conn->consulta($query);
            if ($resp == 1) {

                if ($usuario == "SI") { //Si es usuario se crea el usuario y contraseña
                    $query = "SELECT * FROM t_colaboradores ORDER BY id DESC LIMIT 1";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idColaborador = $dts['id'];
                            }

                            $query = "INSERT INTO t_users(username, password, id_colaborador, id_permiso, id_destino, fase, status, id_seccion) "
                                . "VALUES('$username', '$password', $idColaborador, $permiso, $destino, $fase, 'A', $seccion)";

                            try {
                                $resp = $conn->consulta($query);
                            } catch (Exception $ex) {
                                $resp = $ex;
                            }
                        }
                    } catch (Exception $ex) {
                        $resp = $ex;
                    }
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();

        return $resp;
    }

    public function actualizarEmpleado($idEmpleado, $nombre, $apellido, $telefono, $email, $destino, $cargo, $nivel, $fase, $seccion)
    {
        $conn = new Conexion();
        $conn->conectar();
        date_default_timezone_set('America/Cancun');
        //        $fechaPropIng = date("Y-m-d H:i:s", strtotime($fechaPropIng));
        //        $fechaRealIng = date("Y-m-d H:i:s", strtotime($fechaRealIng));
        $query = "UPDATE t_colaboradores SET nombre = '$nombre', apellido = '$apellido', telefono = '$telefono', email = '$email', "
            . "id_cargo = $cargo, id_nivel = $nivel, id_destino = $destino, id_fase = $fase, id_seccion = $seccion "
            . " WHERE id = $idEmpleado";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $query = "UPDATE t_users SET id_destino = $destino, fase = $fase WHERE id_colaborador = $idEmpleado";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function actualizarUsuario($idColaborador, $idUsuario, $username, $password, $permiso, $codigoSA, $acciones, $subalmacenes)
    {
        $conn = new Conexion();
        $conn->conectar();

        $resp = $acciones;
        $query = "UPDATE t_users SET username = '$username', password = '$password', id_permiso = $permiso"
            . " WHERE id = $idUsuario";
        try {
            $resp = $conn->consulta($query);
            if ($resp == 1) {
                $actions = explode(",", $acciones);

                $query = "SELECT * FROM c_acciones_usuarios WHERE id_usuario = $idUsuario";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        $query = "UPDATE c_acciones_usuarios "
                            . "SET $actions[0], $actions[1], $actions[2], acceso_sa = '$subalmacenes' "
                            . "WHERE id_usuario = $idUsuario";
                        try {
                            $resp = $conn->consulta($query);
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    } else {
                        $entrada = explode("=", $actions[0]);
                        $salida = explode("=", $actions[1]);
                        $importarGastos = explode("=", $actions[2]);
                        $query = "INSERT INTO c_acciones_usuarios (id_usuario, entradas_sa, salidas_sa, importar_gastos) "
                            . "VALUES($idUsuario, " . trim($entrada[1]) . ", " . trim($salida[1]) . ", " . trim($importarGastos[1]) . ")";
                        try {
                            $resp = $conn->consulta($query);
                        } catch (Exception $ex) {
                            $resp = $ex;
                        }
                    }
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $query = "SELECT * FROM t_colaboradores WHERE codigo_sa = '$codigoSA'";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                $resp = "Ya existe ese codigo, intente uno diferente";
            } else {
                if ($idUsuario != 0) {
                    $query = "UPDATE t_colaboradores SET codigo_sa = '$codigoSA', id_permiso = 1 WHERE id = $idColaborador";
                } else {
                    $query = "UPDATE t_colaboradores SET codigo_sa = '$codigoSA', id_permiso = 2 WHERE id = $idColaborador";
                }

                try {
                    $resp = $conn->consulta($query);
                } catch (Exception $ex) {
                    $resp = $ex;
                    exit($ex);
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
            exit($ex);
        }

        $conn->cerrar();
        return $resp;
    }

    public function eliminarEmpleado($idEmpleado)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_colaboradores SET status = 'B' WHERE id = $idEmpleado";
        try {
            $resp = $conn->consulta($query);
            if ($resp == 1) {
                $query = "UPDATE t_users SET status = 'B' WHERE id_colaborador = $idEmpleado";
                try {
                    $resp = $conn->consulta($query);
                } catch (Exception $ex) {
                    $resp = $ex;
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function eliminarUsuario($idUser)
    {
        $conn = new Conexion();
        $conn->conectar();

        $query = "UPDATE t_users SET status = 'B' WHERE id = $idUser";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function actualizarSueldo($idEmpleado, $sueldo)
    {
        $conn = new Conexion();
        $conn->conectar();
        $query = "UPDATE t_colaboradores SET sueldo_diario = $sueldo WHERE id = $idEmpleado";
        try {
            $resp = $conn->consulta($query);
        } catch (Exception $ex) {
            $resp = $ex;
        }

        $conn->cerrar();
        return $resp;
    }

    public function obtListaTrabajadores()
    {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if (isset($_SESSION['idDestino'])) {
            $idDestinoT = $_SESSION['idDestino'];
        } else {
            $idDestinoT = 10;
        }
        if ($idDestinoT == 10) {
            $query = "SELECT * FROM t_colaboradores WHERE status = 'A'ORDER BY nombre";
        } else {
            $query = "SELECT * FROM t_colaboradores WHERE id_destino = $idDestinoT AND status = 'A' ORDER BY nombre";
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEmpleado = $dts['id'];
                    $nombre = $dts['nombre'];
                    $apellido = $dts['apellido'];
                    $telefono = $dts['telefono'];
                    $email = $dts['email'];
                    $idCargo = $dts['id_cargo'];
                    $idSeccion = $dts['id_seccion'];
                    if ($dts['foto'] != "") {
                        $foto = $dts['foto'];
                    } else {
                        $foto = "";
                    }

                    $salida .= "<h5 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"obtDatosEmpleado($idEmpleado);\"><span><i class=\"fas fa-user\"></i></span> " . strtoupper($nombre) . " " . strtoupper($apellido) . "<h5>";
                }
            }
        } catch (Exception $ex) {
            $salida .= $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function buscarTrabajador($word)
    {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "";
        if (isset($_SESSION['idDestino'])) {
            $idDestinoT = $_SESSION['idDestino'];
        } else {
            $idDestinoT = 10;
        }
        if ($idDestinoT == 10) {
            if ($word == "") {
                $query = "SELECT * FROM t_colaboradores "
                    . "WHERE status = 'A' ORDER BY nombre";
            } else {
                $query = "SELECT * FROM t_colaboradores "
                    . "WHERE (nombre LIKE '%$word%' OR apellido LIKE '%$word%') "
                    . "AND status = 'A' "
                    . "ORDER BY nombre";
            }
        } else {
            if ($word == "") {
                $query = "SELECT * FROM t_colaboradores "
                    . "WHERE id_destino = $idDestinoT "
                    . "OR id_destino = 10 "
                    . "AND status = 'A' ORDER BY nombre";
            } else {
                $query = "SELECT * FROM t_colaboradores "
                    . "WHERE (nombre LIKE '%$word%' OR apellido LIKE '%$word%') "
                    . "AND id_destino = $idDestinoT "
                    . "OR id_destino = 10 "
                    . "AND status = 'A' "
                    . "ORDER BY nombre";
            }
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEmpleado = $dts['id'];
                    $nombre = $dts['nombre'];
                    $apellido = $dts['apellido'];
                    $telefono = $dts['telefono'];
                    $email = $dts['email'];
                    $idCargo = $dts['id_cargo'];
                    $idSeccion = $dts['id_seccion'];
                    if ($dts['foto'] != "") {
                        $foto = $dts['foto'];
                    } else {
                        $foto = "";
                    }

                    $salida .= "<h5 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"obtDatosEmpleado($idEmpleado);\"><span><i class=\"fas fa-user\"></i></span> " . strtoupper($nombre) . " " . strtoupper($apellido) . "<h5>";
                }
            }
        } catch (Exception $ex) {
            $salida .= $ex;
        }

        $conn->cerrar();
        return $salida;
    }
}
