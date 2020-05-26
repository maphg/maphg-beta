<?php
session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');
include_once 'php/layout.php';
include 'php/conexion.php';
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

if (isset($_GET['idEquipo'])) {
    $idEquipo = $_GET['idEquipo'];
    $query = "SELECT t_equipos.id 'ID', "
            . "t_equipos.equipo 'EQUIPO', "
            . "t_equipos.id_destino 'IDDESTINO', "
            . "t_equipos.id_tipo 'TIPO'"
            . "FROM t_equipos WHERE id = $idEquipo";
    try {
        $resp = $conn->obtDatos($query);
        if ($conn->filasConsultadas > 0) {
            foreach ($resp as $dts) {
                $idDestinoEquipo = $dts['IDDESTINO'];
                $equipo = $dts['EQUIPO'];
                $idTipo = $dts['TIPO'];
            }
        }
    } catch (Exception $ex) {
        echo $ex;
    }
} else {
    header('Location: equipos.php');
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
        <!--<div id="loader" class="pageloader is-active"><span class="title">Cargando...</span></div>-->
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
                    <div class="navbar-end">

                        <nav class="navbar" role="navigation" aria-label="dropdown navigation">
                            <div class="navbar-item has-dropdown is-hoverable ">
                                <a class="bd-navbar-icon navbar-item">
                                    <span class="mr-1"><i class="fad fa-globe-americas has-text-info mr-1"></i><?php echo $destino; ?>
                                </a>

                                <?php
                                if ($idDestino == 10) {
                                    echo "<div class=\"navbar-dropdown\">";

                                    $query = "SELECT * FROM c_destinos ORDER BY destino";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $idDest = $dts['id'];
                                                $nombreDest = $dts['destino'];
                                                echo "<a href=\"\" onclick=\"cargarTareasDestino(0, $idDest);\" class=\"navbar-item\">$nombreDest</a>";
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "</div>";
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
                    <?php //echo $layout->menu(); ?>
                </nav>

                <!--HERO BAR-->
                <section class="mt-5">
                    <br>
                </section>
                <section>
                    <div class="columns mx-4">
                        <div class="column">
                            <a href="equipos.php" class="button">Volver a equipos</a>
                        </div>
                    </div>
                </section>

                <section>
                    <div class="columns mx-4">
                        <div class="column">
                            <h1><?php echo $equipo; ?></h1>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column has-text-centered">

                            <div class="columns mx-2 manita is-centered mb-0 pb-0">
                                <div class="column is-2">
                                </div>
                                <div class="column">
                                    <img src="svg/semanas/s-1.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-2.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-3.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-4.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-5.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-6.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-7.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-8.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-9.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-10.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-11.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-12.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-13.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-14.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-15.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-16.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-17.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-18.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-19.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-20.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-21.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-22.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-23.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-24.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-25.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-26.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-27.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-28.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-29.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-30.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-31.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-32.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-33.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-34.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-35.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-36.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-37.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-38.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-39.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-40.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-41.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-42.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-43.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-44.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-45.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-46.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-47.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-48.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-49.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-50.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-51.svg" width="15px" alt="">
                                    <img src="svg/semanas/s-52.svg" width="15px" alt="">
                                </div>
                            </div>

                            <?php
                            $year = date('Y');
                            $query = "SELECT * FROM t_planes_mantto "
                                    . "WHERE id_tipo_equipo = $idTipo AND id_destino = $idDestinoT";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idPlanMantto = $dts['id'];
                                        $nombrePlan = $dts['nombre'];

                                        echo "<div class=\"columns mx-2 manita is-centered\">"
                                        . "<div class=\"column is-2\">"
                                        . "<h6 class=\"title is-6 has-text-right\">$nombrePlan</h6>"
                                        . "</div>"
                                        . "<div class=\"column\">";
                                        for ($i = 1; $i <= 52; $i++) {
                                            $query = "SELECT * FROM t_mp_planeacion "
                                                    . "WHERE id_equipo = $idEquipo "
                                                    . "AND id_plan = $idPlanMantto "
                                                    . "AND semana = $i "
                                                    . "AND año = $year "
                                                    . "AND activo = 1";
                                            try {
                                                $result = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($result as $d) {
                                                        $estatus = $d['status'];
                                                        if ($estatus == "N") {
                                                            echo "<img class=\"mr-1\" src=\"svg/planificado.svg\" width=\"15px\">";
                                                        } else if ($estatus == "P") {
                                                            echo "<img class=\"mr-1\" src=\"svg/planificado.svg\" width=\"15px\">";
                                                        } else {
                                                            echo "<img class=\"mr-1\" src=\"svg/planificado.svg\" width=\"15px\" >";
                                                        }
                                                    }
                                                } else {
                                                    echo "<img class=\"mr-1\" src=\"svg/nulo.svg\" width=\"15px\" onclick=\"agregarMP($idPlanMantto, $idEquipo, $i);\">";
                                                }
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }
                                        }

                                        echo "</div>"
                                        . "</div>";
                                    }
                                }
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                            ?>
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
    <script type="text/javascript" src="js/equiposJS.js"></script>
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
//                                            var pageloader = document.getElementById("loader");
//                                            if (pageloader) {
//
//                                                var pageloaderTimeout = setTimeout(function () {
//                                                    pageloader.classList.toggle('is-active');
//                                                    clearTimeout(pageloaderTimeout);
//                                                }, 3000);
//                                            }

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
