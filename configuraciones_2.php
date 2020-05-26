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
?>
<!DOCTYPE html>
<html>

    <head>
        <?php echo $layout->styles(); ?>
        <link rel="stylesheet" type="text/css" href="css/sidebar.css" />
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
        <div id="loader" class="pageloader is-active"><span class="title">Cargando...</span></div>
        <!--MENU-->
        <nav id="nav-menu" class="navbar is-fixed-top is-size-7 navbar-height">
            <div class="navbar-brand">
                <a class="navbar-item" href="index.php">
                    <img src="svg/logon2.svg" alt="" width="112" height="28">
                </a>
                <div class="navbar-burger burger" data-target="navMenuPpal">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <?php echo $layout->menu(); ?>
        </nav>
        <br>
        <div id="contenedor" class="mt-4-5">
            <div id="sidebar">
                <div id="sidebar-contenido">
                    <aside class="menu ml-1">
                        <p class="menu-label white-text">
                            General
                        </p>
                        <ul class="menu-list">
                            <li><a onclick="destinos();">Destinos</a></li>
                            <li><a onclick="secciones();">Secciones</a></li>
                            <li><a onclick="subsecciones();">Subsecciones</a></li>
                            <li><a onclick="categorias();">Categorias</a></li>
                            <li><a onclick="subcategorias();">Subcategorias</a></li>
                        </ul>
                        <p class="menu-label white-text">
                            Administracion
                        </p>
                        <ul class="menu-list">
                            <li><a>Departamentos</a></li>
                            <li><a>Puestos</a></li>
                        </ul>
                        <p class="menu-label white-text">
                            Operacion
                        </p>
                        <ul class="menu-list">
                            <li><a>Tipos de equipos</a></li>
                            <li><a>Marcas</a></li>
                            <li><a>CECOS</a></li>
                            <li><a onclick="equipos();">Equipos</a></li>
                            <li><a>Unidades de medida</a></li>
                            <li><a>Agregar subseccion a seccion</a></li>
                            <li><a>Autorizar usuarios a secciones</a></li>
                            <li><a>Planes de mantenimiento</a></li>
                            <li><a>Planificacion de mantenimientos</a></li>

                        </ul>
                    </aside>
                </div>
            </div>
            <div id="contenido">
                <div id="contenido-principal">
                    <section>
                        <div class="columns my-1 mx-1">
                            <div class="column">
                                <h1 class="title">Configuraciones Generales</h1>
                            </div>
                        </div>
                        <div id="divLoader" class="columns my-1 mx-1" style="display:none;">
                            <div class="column has-text-centered">
                                <img src="img/loader.gif">
                            </div>
                        </div>
                    </section>

                </div>
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

        <div id="modal-agregar-equipo" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-lg">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <div class="columns is-centered has-text-centered">
                                    <div class="column is-half">
                                        <h1 class="title is-6">Agregar Equipo</h1>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <div class="columns">
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Nombre equipo</label>
                                                    <div class="control has-icons-left has-icons-right">
                                                        <input class="input is-small" type="text" placeholder="Nombre equipo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Tipo equipo</label>
                                                    <div class="control">
                                                        <div class="select is-small is-fullwidth">
                                                            <select>
                                                                <option>-Tipo equipo-</option>
                                                                <option>Chiller</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Matricula</label>
                                                    <div class="control has-icons-left has-icons-right">
                                                        <input class="input is-small" type="text" placeholder="Matricula">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Modelo</label>
                                                    <div class="control">
                                                        <div class="select is-small is-fullwidth">
                                                            <select>
                                                                <option>-Marca-</option>
                                                                <option>Carrier</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Modelo</label>
                                                    <div class="control has-icons-left has-icons-right">
                                                        <input class="input is-small" type="text" placeholder="Modelo">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Numero de serie</label>
                                                    <div class="control has-icons-left has-icons-right">
                                                        <input class="input is-small" type="text" placeholder="Numero de serie">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="columns">
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">CECO</label>
                                                    <div class="control">
                                                        <div class="select is-small is-fullwidth">
                                                            <select>
                                                                <option>-Marca-</option>
                                                                <option>Carrier</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Estatus</label>
                                                    <div class="control">
                                                        <div class="select is-small is-fullwidth">
                                                            <select>
                                                                <option>-Marca-</option>
                                                                <option>Carrier</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Jerarquia</label>
                                                    <div class="control">
                                                        <div class="select is-small is-fullwidth">
                                                            <select>
                                                                <option>-Marca-</option>
                                                                <option>Carrier</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="column">
                                                <div class="field">
                                                    <label class="label is-small">Codigo 2Bend</label>
                                                    <div class="control has-icons-left has-icons-right">
                                                        <input class="input is-small" type="text" placeholder="Codigo 2Bend">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="columns">
                                                <div class="column">
                                                    <div class="field">
                                                        <label class="label is-small">Destino</label>
                                                        <div class="control">
                                                            <div class="select is-small is-fullwidth">
                                                                <select>
                                                                    <option>-Marca-</option>
                                                                    <option>Carrier</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="field">
                                                        <label class="label is-small">Seccion</label>
                                                        <div class="control">
                                                            <div class="select is-small is-fullwidth">
                                                                <select>
                                                                    <option>-Marca-</option>
                                                                    <option>Carrier</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="column">
                                                    <div class="field">
                                                        <label class="label is-small">Subseccion</label>
                                                        <div class="control">
                                                            <div class="select is-small is-fullwidth">
                                                                <select>
                                                                    <option>-Marca-</option>
                                                                    <option>Carrier</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>

                                </div>
                                <div class="columns is-centered has-text-centered">
                                    <div class="column is-half">
                                        <button id="" class="button is-success">ACEPTAR</button>
                                    </div>
                                    <div class="column is-half">
                                        <button id="" class="button is-danger" onclick="closeModal('modal-agregar-equipo');">CANCELAR</button>
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
    <script type="text/javascript" src="js/configuracionesJS.js"></script>
    <script type="text/javascript" src="js/plannerJS.js"></script>
    <!--DataTables-->
    <script src="DataTables/datatables.js"></script>
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

                                                $("#sidebar").mCustomScrollbar({
                                                    theme: "minimal-dark"
                                                });
//            $("#contenido").mCustomScrollbar({
//                theme: "minimal-dark"
//            });
                                            });
    </script>
</html>
