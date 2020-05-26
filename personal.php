<?php
session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');
include 'php/conexion.php';
include_once 'php/layout.php';

$layout = new Layout();
$conn = new Conexion();
$conn->conectar();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
} else {
    $conn->conectar();
    $idUsuario = $_SESSION['usuario'];
//Obtener datos del usuario
    $query = "SELECT * FROM t_users WHERE id = $idUsuario";
    try {
        $resp = $conn->obtDatos($query);
        if ($conn->filasConsultadas > 0) {
            foreach ($resp as $dts) {
                $idColaborador = $dts['id_colaborador'];
                $idPermiso = $dts['id_permiso'];
                $idDestino = $dts['id_destino'];
                $idFase = $dts['fase'];

                if ($idPermiso == 2 || $idPermiso == 1) {
                    header('Location: forbidden.php');
                }

                $query = "SELECT * FROM c_permisos WHERE id = $idPermiso";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $permiso = $dts['permiso'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

//Obtener datos del colaborador
                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
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
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }
            }
        }
    } catch (Exception $ex) {
        echo $ex;
    }
}
if ($idDestino == 10) {
    if (isset($_SESSION['idDestino'])) {
        $idDestinoT = $_SESSION['idDestino'];
    } else {
        $idDestinoT = $idDestino;
    }
} else {
    $idDestinoT = $idDestino;
}

$query = "SELECT * FROM c_destinos WHERE id = $idDestinoT";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $bandera = $dts['bandera'];
            $destino = $dts['destino'];
            $gp = $dts['gp'];
            $trs = $dts['trs'];
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
<!DOCTYPE html>
<html>

    <head>
        <?php echo $layout->styles(); ?>

        <link rel="stylesheet" type="text/css" href="DataTables/datatables.css"/>
        <style>
            .shadow-navbar{
                -webkit-box-shadow: 0px 4px 22px -22px rgba(0,0,0,0.98);
                -moz-box-shadow: 0px 4px 22px -22px rgba(0,0,0,0.98);
                box-shadow: 0px 4px 22px -22px rgba(0,0,0,0.98);
            }
        </style>
    </head>

    <body>
        <div id="loader" class="pageloader is-dark is-active"><span class="title">Cargando...</span></div>
        <div class="wrapper">
            <nav id="sidebar">
                <div id="dismiss">
                    <i class="fas fa-arrow-left"></i>
                </div>

                <div class="sidebar-header">
                    <!--<h3>Bootstrap Sidebar</h3>-->
                    <img src="svg/logon2.svg" alt="" width="112" height="28">
                </div>

                <?php echo $layout->menu($destino); ?>

            </nav>
            <div id="content">
                <!--MENU-->
                <nav id="nav-menu" class="navbar is-fixed-top">
                    <div class="navbar-brand">
                        <a id="sidebarCollapse" class="navbar-item" href="#">
                            <img src="svg/logon2.svg" alt="" width="112" height="28">
                        </a>

                        <div class="navbar-burger burger" data-target="navMenuPpal">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div id="navMenuPpal" class="navbar-menu">
                        <div class="navbar-end">

                        <nav class="navbar" role="navigation" aria-label="dropdown navigation">
                            <div class="navbar-item has-dropdown is-hoverable ">
                                <a class="bd-navbar-icon navbar-item">
                                    <span class="mr-1"><i class="fad fa-globe-americas has-text-info mr-1"></i><?php echo $destino; ?>
                                </a>

                                <?php
                                if ($idDestino == 10) {
                                    if ($idDestino == 10) {
                                        echo $layout->dropDownDestinos();
                                    }
                                }
                                ?>
                            </div>
                        </nav>


                        <nav class="navbar" role="navigation" aria-label="dropdown navigation">
                            <div class="navbar-item has-dropdown is-hoverable">
                                <a class="bd-navbar-icon navbar-item">
                                    <span class="mr-1"><i class="fad fa-grip-lines-vertical has-text-dark"></i></span><?php echo $nombre . " " . $apellido; ?>
                                </a>

                                <div class="navbar-dropdown">
                                    <a href="perfil.php" class="navbar-item">
                                        Mi perfil
                                    </a>
                                    <a href="mis-pendientes.php" class="navbar-item">
                                        Mis pendientes
                                    </a>
                                    <a href="#" class="navbar-item">
                                        Agenda personal
                                    </a>
                                    <hr class="navbar-divider">
                                    <a href="configuraciones.php" class="navbar-item">
                                        Configuraciones
                                    </a>
                                    <a class="navbar-item" onClick="showModal('modalLogout');">
                                        Cerrar Sesion
                                    </a>
                                </div>
                            </div>
                        </nav>


                    </div>
                    </div>
                    
                    <?php //echo $layout->menu();   ?>
                </nav>

                <!--HERO BAR-->
                <section class="mt-5">
                    <br>
                </section>

                <section class="mt-2">
                    <div class="columns mx-3">
                        <div class="column is-4">
                            <div class="columns">
                                <div class="column">
                                    <button class="button is-primary" onclick="showModal('modal-agregar-trabajador');">
                                        <span class="icon is-small">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span>Nuevo trabajador</span>
                                    </button>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <div class="control has-icons-left">
                                        <input id="txtBuscar" type="text" class="input" placeholder="Buscar trabajador..." onkeyup="buscarTrabajador();">
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="columns">
                                <div id="divListaUsuarios" class="column">
                                    <?php
                                    if ($idDestinoT == 10) {
                                        $query = "SELECT * FROM t_colaboradores "
                                                . "WHERE status = 'A'ORDER BY nombre";
                                    } else {
                                        $query = "SELECT * FROM t_colaboradores "
                                                . "WHERE id_destino = $idDestinoT OR id_destino = 10 AND status = 'A' ORDER BY nombre";
                                    }
// $query = "SELECT * FROM t_colaboradores WHERE id_destino = $idDestinoT AND status = 'A' ORDER BY nombre";
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

                                                echo "<h5 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"obtDatosEmpleado($idEmpleado);\">"
                                                . "<span><i class=\"fas fa-user\"></i></span> " . strtoupper($nombre) . " " . strtoupper($apellido) . ""
                                                . "<h5>";
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="column">
                            <div class="columns">
                                <div class="column">
                                    <div class="tabs is-centered is-boxed">
                                        <ul>
                                            <li id="tab-perfil" class="is-active">
                                                <a onclick="activeTab('perfil');">
                                                    <span class="icon is-small"><i class="fas fa-id-card" aria-hidden="true"></i></span>
                                                    <span>Perfil</span>
                                                </a>
                                            </li>
                                            <li id="tab-usuario">
                                                <a onclick="activeTab('usuario');">
                                                    <span class="icon is-small"><i class="fas fa-user" aria-hidden="true"></i></span>
                                                    <span>Usuario</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="columns">
                                        <div id="perfil" class="column tab-pane fade">
                                            <input id="idEmpleadoHdn" type="hidden">
                                            <div class="columns">
                                                <div id="divFormTrabajador" class="column" style="min-height:300px;">
                                                    <div class="field is-horizontal">
                                                        <div class="field-body">
                                                            <div class="field">
                                                                <label class="label is-small">Nombre</label>
                                                                <input id="nombreEmp" type="text" class="input" placeholder="Nombre">
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Apellido</label>
                                                                <input id="apellidoEmp" type="text" class="input" placeholder="Apellido">
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Telefono</label>
                                                                <input id="telefonoEmp" type="tel" class="input" placeholder="Telefono">
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Email</label>
                                                                <input id="emailEmp" type="email" class="input" placeholder="Email">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="field is-horizontal">
                                                        <div class="field-body">
                                                            <div class="field">
                                                                <label class="label is-small">Destino</label>
                                                                <div class="control">
                                                                    <div class="select is-fullwidth">
                                                                        <select id="cbDestEdit">
                                                                            <option value="0">-SELECCIONE-</option>
                                                                            <?php
                                                                            $query = "SELECT * FROM c_destinos ORDER BY destino";
                                                                            try {
                                                                                $resp = $conn->obtDatos($query);
                                                                                if ($conn->filasConsultadas > 0) {
                                                                                    foreach ($resp as $dts) {
                                                                                        $idD = $dts['id'];
                                                                                        $nombreD = $dts['destino'];
                                                                                        echo "<option value=\"$idD\">$nombreD</option>";
                                                                                    }
                                                                                }
                                                                            } catch (Exception $ex) {
                                                                                echo $ex;
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Fase</label>
                                                                <div class="control">
                                                                    <div class="select is-fullwidth">
                                                                        <select id="cbFaseEdit">
                                                                            <option value="0">-SELECCIONE-</option>
                                                                            <?php
                                                                            $conn->conectar();
                                                                            $query = "SELECT * FROM c_fases";
                                                                            try {
                                                                                $resp = $conn->obtDatos($query);
                                                                                if ($conn->filasConsultadas > 0) {
                                                                                    foreach ($resp as $fases) {
                                                                                        $idFase = $fases['id'];
                                                                                        $fase = $fases['fase'];
                                                                                        echo "<option value='$idFase'>$fase</option>";
                                                                                    }
                                                                                }
                                                                            } catch (Exception $ex) {
                                                                                echo $ex;
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Seccion</label>
                                                                <div class="control">
                                                                    <div class="select is-fullwidth">
                                                                        <select id="cbSeccionEdit">
                                                                            <option value="0">-SELECCIONE-</option>
                                                                            <?php
                                                                            $conn->conectar();
                                                                            $query = "SELECT * FROM c_secciones WHERE personal = 'SI'";
                                                                            try {
                                                                                $resp = $conn->obtDatos($query);
                                                                                if ($conn->filasConsultadas > 0) {
                                                                                    foreach ($resp as $fases) {
                                                                                        $idSeccion = $fases['id'];
                                                                                        $seccion = $fases['seccion'];
                                                                                        echo "<option value='$idSeccion'>$seccion</option>";
                                                                                    }
                                                                                }
                                                                            } catch (Exception $ex) {
                                                                                echo $ex;
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="field is-horizontal">
                                                        <div class="field-body">
                                                            <div class="field">
                                                                <label class="label is-small">Puesto</label>
                                                                <div class="control">
                                                                    <div class="select is-fullwidth">
                                                                        <select id="cbCargoEdit">
                                                                            <option value="0">-SELECCIONE-</option>
                                                                            <?php
                                                                            $conn->conectar();
                                                                            $query = "SELECT * FROM c_cargos ORDER BY cargo";
                                                                            try {
                                                                                $resp = $conn->obtDatos($query);
                                                                                if ($conn->filasConsultadas > 0) {
                                                                                    foreach ($resp as $puestos) {
                                                                                        $idPuesto = $puestos['id'];
                                                                                        $puesto = $puestos['cargo'];
                                                                                        echo "<option value='$idPuesto'>$puesto</option>";
                                                                                    }
                                                                                }
                                                                            } catch (Exception $ex) {
                                                                                echo $ex;
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Nivel</label>
                                                                <div class="control">
                                                                    <div class="select is-fullwidth">
                                                                        <select id="cbNivelEdit">
                                                                            <option value="0">-SELECCIONE-</option>
                                                                            <?php
                                                                            $conn->conectar();
                                                                            $query = "SELECT * FROM c_niveles";
                                                                            try {
                                                                                $resp = $conn->obtDatos($query);
                                                                                if ($conn->filasConsultadas > 0) {
                                                                                    foreach ($resp as $destinos) {
                                                                                        $idNiv = $destinos['id'];
                                                                                        $nivel = $destinos['nivel'];
                                                                                        echo "<option value='$idNiv'>$nivel</option>";
                                                                                    }
                                                                                }
                                                                            } catch (Exception $ex) {
                                                                                echo $ex;
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="columns">
                                                <div class="column">
                                                    <div class="columns mt-5">
                                                        <div class="column">
                                                            <button class="button is-danger" onclick="showModal('modal-eliminar-trabajador')">Eliminar registro</button>
                                                        </div>
                                                        <div class="column has-text-right">
                                                            <button class="button is-light">Cancelar</button>
                                                        </div>
                                                        <div class="column">
                                                            <button class="button is-primary" onclick="actualizarEmpleado();">Guardar cambios</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--SECCION DE INFORMACION DE DATOS DE ACCESO (USUARIO)-->
                                        <div id="usuario" class="column tab-pane fade" style="display:none;">
                                            <input id="idUsuarioHdn" type="hidden">
                                            <div class="columns">
                                                <div id="divFormUsuario" class="column" style="min-height:300px">
                                                    <div class="field is-horizontal">
                                                        <div class="field-body">
                                                            <div class="field">
                                                                <label class="label is-small">Nombre de usuario</label>
                                                                <input id="txtUsernameEdit" type="text" class="input" placeholder="Nombre de usuario">
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Contraseña</label>
                                                                <input id="txtPasswordEdit" type="text" class="input" placeholder="Contraseña">
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Permisos</label>
                                                                <div class="control">
                                                                    <div class="select is-fullwidth">
                                                                        <select id="cbPermisoEdit">
                                                                            <option value="0">-SELECCIONE-</option>
                                                                            <?php
                                                                            $conn->conectar();
                                                                            $query = "SELECT * FROM c_permisos";
                                                                            try {
                                                                                $resp = $conn->obtDatos($query);
                                                                                if ($conn->filasConsultadas > 0) {
                                                                                    foreach ($resp as $fases) {
                                                                                        $idPer = $fases['id'];
                                                                                        $permiso = $fases['permiso'];
                                                                                        if ($idPer == $idPermisoCol) {
                                                                                            echo "<option value='$idPer' selected>$permiso</option>";
                                                                                        } else {
                                                                                            echo "<option value='$idPer'>$permiso</option>";
                                                                                        }
                                                                                    }
                                                                                }
                                                                            } catch (Exception $ex) {
                                                                                echo $ex;
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="field">
                                                                <label class="label is-small">Codigo Subalmacen</label>
                                                                <input id="txtCodigoSAEdit" type="text" class="input" placeholder="Codigo Subalmacen">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="columns">
                                                        <div id="acciones" class="column">
                                                            <h1 class="title">Acciones</h1>
                                                            <?php
                                                            $query = "SHOW COLUMNS FROM c_acciones_usuarios";
                                                            try {
                                                                $resp = $conn->obtDatos($query);
                                                                for ($i = 2; $i < count($resp) - 1; $i++) {
                                                                    $campo = $resp[$i]['Field'];

                                                                    switch ($campo) {
                                                                        case 'entradas_sa':
                                                                            $textoCampos = "entradas subalmacen";
                                                                            break;
                                                                        case 'salidas_sa':
                                                                            $textoCampos = "salidas subalmacen";
                                                                            break;
                                                                        case 'importar_gastos':
                                                                            $textoCampos = "importar gastos";
                                                                            break;
                                                                    }

                                                                    echo "<div class=\"field\">"
                                                                    . "<input class=\"is-checkradio\" id=\"$campo\" type=\"checkbox\" name=\"acciones\"\">"
                                                                    . "<label for=\"$campo\">" . strtoupper($textoCampos) . "</label>"
                                                                    . "</div>";
                                                                }
                                                            } catch (Exception $ex) {
                                                                echo $ex;
                                                            }
                                                            ?>
                                                        </div>
                                                        <div id="accesoSA" class="column">
                                                            <h1 class="title">Acceso Subalmacenes</h1>
                                                            <?php
                                                            if($idDestinoT == 10){
                                                                $query = "SELECT * FROM t_subalmacenes "
                                                                    . "WHERE fase != ''";
                                                            }else{
                                                                $query = "SELECT * FROM t_subalmacenes "
                                                                    . "WHERE id_destino = $idDestinoT "
                                                                    . "AND fase != ''";
                                                            }
                                                            
                                                            try {
                                                                $resp = $conn->obtDatos($query);
                                                                if ($conn->filasConsultadas > 0) {
                                                                    foreach ($resp as $dts) {
                                                                        $idSA = $dts['id'];
                                                                        $nombreSA = $dts['nombre'];
                                                                        echo "<div class=\"field\">"
                                                                        . "<input class=\"is-checkradio\" id=\"chkbsa_$idSA\" type=\"checkbox\" name=\"subalmacenes\"\">"
                                                                        . "<label for=\"chkbsa_$idSA\">" . strtoupper($nombreSA) . "</label>"
                                                                        . "</div>";
                                                                    }
                                                                }
                                                            } catch (Exception $ex) {
                                                                echo $ex;
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="columns">
                                                <div class="column">
                                                    <div class="columns mt-5">
                                                        <div class="column">
                                                            <button class="button is-danger" onclick="showModal('modal-eliminar-usuario')">Eliminar usuario</button>
                                                        </div>
                                                        <div class="column has-text-right">
                                                            <button class="button is-light">Cancelar</button>
                                                        </div>
                                                        <div class="column">
                                                            <button class="button is-primary" onclick="actualizarUsuario();">Guardar cambios</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!--AREA DE MODALS-->
        <!--MODAL CERRAR SESION-->
        <div id="modalLogout" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-sm">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="content has-text-centered">
                                <p class="is-size-4">¿Desea cerrar su sesión?</p>
                            </div>
                            <div class="level">
                                <div class="level-item has-text-centered">
                                    <button id="" class="button is-success" onclick="logout();">ACEPTAR</button>
                                </div>
                                <div class="level-item has-text-centered">
                                    <button id="" class="button is-danger" onclick="closeModal('modalLogout');">CANCELAR</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--MODAL AGREGAR TRABAJADOR-->
        <div id="modal-agregar-trabajador" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-md">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <div class="columns">
                                    <div class="column has-text-centered">
                                        <h3 class="title is-size-4">Nuevo trabajador</h3>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <form>
                                            <div class="field is-horizontal">
                                                <div class="field-body">
                                                    <div class="field">
                                                        <label class="label is-small">Nombre</label>
                                                        <input id="txtNombre" type="text" class="input" placeholder="Nombre" required>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Apellido</label>
                                                        <input id="txtApellido" type="text" class="input" placeholder="Apellido" required>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Telefono</label>
                                                        <input id="txtTel" type="tel" class="input" placeholder="Telefono">
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Email</label>
                                                        <input id="txtEmail" type="email" class="input" placeholder="Email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field is-horizontal">
                                                <div class="field-body">
                                                    <div class="field">
                                                        <label class="label is-small">Destino</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select id="cbDest">
                                                                    <option value="0">-SELECCIONE-</option>
<?php
$query = "SELECT * FROM c_destinos ORDER BY destino";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $idD = $dts['id'];
            $nombreD = $dts['destino'];
            echo "<option value=\"$idD\">$nombreD</option>";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Fase</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select id="cbFase">
                                                                    <option value="0">-SELECCIONE-</option>
<?php
$conn->conectar();
$query = "SELECT * FROM c_fases";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $fases) {
            $idFase = $fases['id'];
            $fase = $fases['fase'];
            echo "<option value='$idFase'>$fase</option>";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Seccion</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select id="cbSeccion">
                                                                    <option value="0">-SELECCIONE-</option>
<?php
$conn->conectar();
$query = "SELECT * FROM c_secciones WHERE personal = 'SI'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $fases) {
            $idSeccion = $fases['id'];
            $seccion = $fases['seccion'];
            echo "<option value='$idSeccion'>$seccion</option>";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field is-horizontal">
                                                <div class="field-body">
                                                    <div class="field">
                                                        <label class="label is-small">Departamento</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select id="cbDepto">
                                                                    <option value="0">-SELECCIONE-</option>
<?php
$conn->conectar();
$query = "SELECT * FROM c_departamentos";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $deptos) {
            $idDepto = $deptos['id'];
            $depto = $deptos['departamento'];
            echo "<option value='$idDepto'>$depto</option>";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Puesto</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select id="cbCargo">
                                                                    <option value="0">-SELECCIONE-</option>
<?php
$conn->conectar();
$query = "SELECT * FROM c_cargos ORDER BY cargo";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $puestos) {
            $idPuesto = $puestos['id'];
            $puesto = $puestos['cargo'];
            echo "<option value='$idPuesto'>$puesto</option>";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Nivel</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select id="cbNivel">
                                                                    <option value="0">-SELECCIONE-</option>
<?php
$conn->conectar();
$query = "SELECT * FROM c_niveles";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $destinos) {
            $idNiv = $destinos['id'];
            $nivel = $destinos['nivel'];
            echo "<option value='$idNiv'>$nivel</option>";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="field">
                                                <input class="is-checkradio" type="checkbox" id="chkbUsuario" onchange="activarDatosUsuario();">
                                                <label class="label is-small" for="chkbUsuario">Crear usuario</label>
                                            </div>
                                            <div id="divDatosUser" class="field is-horizontal" style="display:none;">
                                                <div class="field-body">
                                                    <div class="field">
                                                        <label class="label is-small">Nombre de usuario</label>
                                                        <input id="txtUsername" type="text" class="input" placeholder="Nombre de usuario">
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Contraseña</label>
                                                        <input id="txtPassword" type="text" class="input" placeholder="Contraseña">
                                                    </div>
                                                    <div class="field">
                                                        <label class="label is-small">Permisos</label>
                                                        <div class="control">
                                                            <div class="select is-fullwidth">
                                                                <select id="cbPermiso">
                                                                    <option value="0">-SELECCIONE-</option>
<?php
$conn->conectar();
$query = "SELECT * FROM c_permisos";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $fases) {
            $idPer = $fases['id'];
            $permiso = $fases['permiso'];
            if ($idPer == $idPermisoCol) {
                echo "<option value='$idPer' selected>$permiso</option>";
            } else {
                echo "<option value='$idPer'>$permiso</option>";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="is-divider"></div>
                                <div class="columns is-centered">
                                    <div class="column has-text-centered">
                                        <button class="button is-light" onclick="closeModal('modal-agregar-trabajador');">Cancelar</button>
                                    </div>
                                    <div class="column has-text-centered">
                                        <button class="button is-primary" onclick="crearUsuario();">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--MODAL ELIMINAR TRABAJADOR-->
        <div id="modal-eliminar-trabajador" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-sm">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <div class="columns">
                                    <div class="column has-text-centered">
                                        <h5>¿Esta seguro que desea eliminar este registro?</h5>
                                        <p class="help is-danger">Esta accion no se puede deshacer</p>
                                    </div>
                                </div>
                                <div class="columns is-centered">
                                    <div class="column has-text-centered">
                                        <button class="button is-light" onclick="closeModal('modal-eliminar-trabajador');">Cancelar</button>
                                    </div>
                                    <div class="column has-text-centered">
                                        <button class="button is-danger" onclick="eliminarCol();">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--MODAL ELIMINAR USUARIO-->
        <div id="modal-eliminar-usuario" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-sm">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <div class="columns">
                                    <div class="column has-text-centered">
                                        <h5>¿Esta seguro que desea eliminar este registro?</h5>
                                        <p class="help is-danger">Esta accion no se puede deshacer</p>
                                    </div>
                                </div>
                                <div class="columns is-centered">
                                    <div class="column has-text-centered">
                                        <button class="button is-light" onclick="closeModal('modal-eliminar-usuario');">Cancelar</button>
                                    </div>
                                    <div class="column has-text-centered">
                                        <button class="button is-danger" onclick="eliminarUser();">Eliminar</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <a id="btnAncla" href="#nav-menu" class="button is-primary is-rounded ancla" style="display:none;"><i class="fa fa-arrow-up"></i></a>
    </body>

<?php echo $layout->scripts(); ?>
    <script type="text/javascript" src="js/plannerJS.js"></script>
    <script type="text/javascript" src="js/usuariosJS.js"></script>
    <script type="text/javascript">
                                            $(document).ready(function () {
                                                $("#sidebar").mCustomScrollbar({
                                                    theme: "minimal-dark"
                                                });

                                                $('#dismiss, .overlay').on('click', function () {
                                                    $('#sidebar').removeClass('active');
                                                    $('.overlay').removeClass('active');
                                                });

                                                $('#sidebarCollapse').on('click', function () {
                                                    $('#sidebar').addClass('active');
                                                    $('.overlay').addClass('active');
                                                    $('.collapse.in').toggleClass('in');
                                                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                                                });
                                            });
    </script>
    <script>
        $(document).ready(function () {

            var alturaListaUsuario = screen.height - 390;
            var alturaForm = screen.height - 500;
            $("#divListaUsuarios").attr("style", "max-height: " + alturaListaUsuario + "px; overflow-y: auto;");

            $("#divListaUsuarios").mCustomScrollbar({
                theme: "minimal-dark"
            });

            $("#divFormTrabajador").attr("style", "min-height: " + alturaForm + "px;");
            $("#divFormUsuario").attr("style", "min-height: " + alturaForm + "px;");

            var pageloader = document.getElementById("loader");
            if (pageloader) {

                var pageloaderTimeout = setTimeout(function () {
                    pageloader.classList.toggle('is-active');
                    clearTimeout(pageloaderTimeout);
                }, 3000);
            }

            $(window).scroll(function () {
                var position = $(this).scrollTop();
                if (position >= 200) {
                    $('#btnAncla').fadeIn('slow');
                } else {
                    $('#btnAncla').fadeOut('slow');
                }
            });
            $(function () {
                $("#btnAncla").on('click', function () {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 1000);
                    return false;
                });
            });
        });
    </script>
</html>
