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
            $destinoT = $dts['destino'];
        }
    }
} catch (Exception $ex) {
    echo $ex;
}

if ($idPermiso != 3) {
    header("Location: forbiden.php");
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
            <!--sidebar-->
            <nav id="sidebar">
                <div id="dismiss">
                    <i class="fas fa-arrow-left"></i>
                </div>

                <div class="sidebar-header">
                    <!--<h3>Bootstrap Sidebar</h3>-->
                    <img src="svg/logon2.svg" alt="" width="112" height="28">
                </div>

                <?php echo $layout->menu($destinoT); ?>

            </nav>
            <div id="content">
                <!--MENU-->
                <nav id="nav-menu" class="navbar is-fixed-top">
                    <div class="navbar-brand">
                        <a id="sidebarCollapse" class="navbar-item" href="#">
                            <img src="svg/logon2.svg" alt="" width="112" height="28">
                        </a>
                        <!--                        <button type="button" id="sidebarCollapse" class="btn btn-info">
                                                    <i class="fas fa-align-left"></i>
                                                    <span>Toggle Sidebar</span>
                                                </button>-->
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
                                    <span class="mr-1"><i class="fad fa-globe-americas has-text-info mr-1"></i><?php echo $destinoT; ?>
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
                    <?php //echo $layout->menu(); ?>
                </nav>

                <!--HERO BAR-->
                <section class="mt-5">
                    <br>
                </section>
                <!--SECCION DE SELECTS-->
                <section class="mt-2">
                    <div class="container">
                        <div class="columns is-centered">
                            <div class="column has-text-centered">
                                <img src="svg/logon.svg" width="190px" alt="">
                            </div>
                        </div>
                        <div id="opciones" class="columns is-multiline is-mobile">
                            <div class="column is-3 hvr-grow">
                                <a href="settings/destinos.php">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Destinos</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="settings/hoteles.php">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Hoteles</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="settings/secciones.php">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Secciones</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="settings/subsecciones.php">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Subsecciones</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Categorias</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Subcategorias</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Departamentos</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Puestos</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Hoteles</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Tipos de equipo</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Marcas</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">CECOS</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="equipos.php">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Equipos</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Unidades de medida</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Agregar subseccion a seccion</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Autorizar usuarios a secciones</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Planes de mantenimiento</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="column is-3 hvr-grow">
                                <a href="#">
                                    <div class="card rounded-3">
                                        <div class="card-content">
                                            <div class="container">
                                                <div class="columns is-centered">
                                                    <div class="column has-text-centered">
                                                        <h1 class="title is-size-6">Planificacion de mantenimientos</h1>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
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

        <a id="btnAncla" href="#nav-menu" class="button is-primary is-rounded ancla" style="display:none;"><i class="fa fa-arrow-up"></i></a>
    </body>

    <?php echo $layout->scripts(); ?>
    <script type="text/javascript" src="js/configuracionesJS.js"></script>
    <script type="text/javascript" src="js/plannerJS.js"></script>
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
