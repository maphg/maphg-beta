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
            $destinoT = $dts['destino'];
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
        <!--<div id="loader" class="pageloader is-active"><span class="title">Cargando...</span></div>-->
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

        <!--HERO BAR-->
        <section class="mt-5">
            <br>
        </section>
        <section>
            <div class="columns mx-4">
                <div class="column">
                    <a href="configuraciones.php" class="button">Volver al menu</a>
                </div>
            </div>
        </section>
        <!--SECCION DE SELECTS-->
        <section class="mt-2">
            <div class="columns is-centered px-3">

                <div class="column is-one-fifth">
                    <div class="control has-icons-left has-text-centered">
                        <div class="select is-medium is-fullwidth">
                            <select id="cbDestinos" onchange="cargarTareasDestino();">
                                <?php
                                $query = "SELECT * FROM c_destinos ORDER BY destino";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $idDest = $dts['id'];
                                            $nombreDest = $dts['destino'];
                                            if ($idDestino == 10) {
                                                if ($idDest == $idDestinoT) {
                                                    echo "<option value=\"$idDest\" selected>$nombreDest</option>";
                                                } else {
                                                    echo "<option value=\"$idDest\">$nombreDest</option>";
                                                }
                                            } else {
                                                if ($idDest == $idDestino) {
                                                    echo "<option value=\"$idDest\">$nombreDest</option>";
                                                }
                                            }
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                ?>
                            </select>
                            <span class="icon is-small is-left  has-text-info">
                                <img src="svg/banderas/<?php echo $bandera; ?>" width="20px" alt="">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <?php
            $busqueda = $_REQUEST['busqueda'];
            ?>
            <div class="columns is-centered mx-3">
                <div class="column is-4">
                    <button class="button">Agregar equipo</button>
                </div>
                <div class="column is-4 has-text-right">
                    <form action="equipos_buscar.php" method="get">
                        <div class="field has-addons has-addons-right is-fullwidth">
                            <div class="control">
                                <input id="busquedar" name="busqueda" class="input" type="text" placeholder="Buscar..." value="<?php echo $busqueda; ?>">
                            </div>
                            <div class="control">
                                <input type="submit" value="Buscar" class="button is-info">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="columns">
                        <div class="column is-2">
                            <div class="select is-fullwidth">
                                <select id="cbSeccion" onchange="obtenerSubsecciones();">
                                    <option>Seccion</option>
                                    <?php
                                    $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $idSeccion = $dts['id'];
                                                $seccion = $dts['seccion'];
                                                echo "<option value=\"$idSeccion\">$seccion</option>";
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="column is-2">
                            <div class="select is-fullwidth">
                                <select id="cbSubseccion">
                                    <option>Subseccion</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="column is-2">
                            <button class="button is-info">Filtrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="columns is-centered">
                <div class="column is-8">
                    <table class="table is-bordered is-hoverable is-striped is-fullwidth is-size-7" >
                        <thead>
                            <tr>
                                <th>Equipo</th>
                                <th>Destino</th>
                                <th>Seccion</th>
                                <th>Subseccion</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($idDestinoT == 10) {
                                $query = "SELECT t_equipos.equipo 'EQUIPO', "
                                        . "t_equipos.id_destino 'IDDESTINO', "
                                        . "t_equipos.id_seccion 'IDSECCION', "
                                        . "t_equipos.id_subseccion 'IDSUBSECCION', "
                                        . "c_destinos.destino 'DESTINO', "
                                        . "c_secciones.seccion 'SECCION', "
                                        . "c_subsecciones.grupo 'SUBSECCION' "
                                        . "FROM t_equipos "
                                        . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                                        . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                                        . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                                        . "WHERE t_equipos.status = 'A' "
                                        . "AND (t_equipos.id LIKE '%$busqueda%' "
                                        . "OR t_equipos.equipo LIKE '%$busqueda%')";
                            } else {
                                $query = "SELECT t_equipos.equipo 'EQUIPO', "
                                        . "t_equipos.id_destino 'IDDESTINO', "
                                        . "t_equipos.id_seccion 'IDSECCION', "
                                        . "t_equipos.id_subseccion 'IDSUBSECCION', "
                                        . "c_destinos.destino 'DESTINO', "
                                        . "c_secciones.seccion 'SECCION', "
                                        . "c_subsecciones.grupo 'SUBSECCION' "
                                        . "FROM t_equipos "
                                        . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                                        . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                                        . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                                        . "WHERE t_equipos.id_destino = $idDestinoT AND t_equipos.status = 'A' "
                                        . "AND (t_equipos.id LIKE '%$busqueda%' "
                                        . "OR t_equipos.equipo LIKE '%$busqueda%')";
                            }
                            try {
                                $resp = $conn->obtDatos($query);
                                $totalRegistros = $conn->filasConsultadas;
                                $porPagina = 10;
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                            if (empty($_GET['pagina'])) {
                                $pagina = 1;
                            } else {
                                $pagina = $_GET['pagina'];
                            }

                            $desde = ($pagina - 1) * $porPagina;
                            $totalPaginas = ceil($totalRegistros / $porPagina);

                            if ($idDestinoT == 10) {
                                $query = "SELECT t_equipos.equipo 'EQUIPO', "
                                        . "t_equipos.id_destino 'IDDESTINO', "
                                        . "t_equipos.id_seccion 'IDSECCION', "
                                        . "t_equipos.id_subseccion 'IDSUBSECCION', "
                                        . "c_destinos.destino 'DESTINO', "
                                        . "c_secciones.seccion 'SECCION', "
                                        . "c_subsecciones.grupo 'SUBSECCION' "
                                        . "FROM t_equipos "
                                        . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                                        . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                                        . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                                        . "WHERE t_equipos.status = 'A' "
                                        . "AND (t_equipos.id LIKE '%$busqueda%' "
                                        . "OR t_equipos.equipo LIKE '%$busqueda%')"
                                        . "ORDER BY t_equipos.id_destino "
                                        . "LIMIT $desde, $porPagina ";
                            } else {
                                $query = "SELECT t_equipos.equipo 'EQUIPO', "
                                        . "t_equipos.id_destino 'IDDESTINO', "
                                        . "t_equipos.id_seccion 'IDSECCION', "
                                        . "t_equipos.id_subseccion 'IDSUBSECCION', "
                                        . "c_destinos.destino 'DESTINO', "
                                        . "c_secciones.seccion 'SECCION', "
                                        . "c_subsecciones.grupo 'SUBSECCION' "
                                        . "FROM t_equipos "
                                        . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                                        . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                                        . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                                        . "WHERE t_equipos.id_destino = $idDestinoT AND t_equipos.status = 'A' "
                                        . "AND (t_equipos.id LIKE '%$busqueda%' "
                                        . "OR t_equipos.equipo LIKE '%$busqueda%') "
                                        . "ORDER BY t_equipos.id_destino "
                                        . "LIMIT $desde, $porPagina ";
                            }

                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $equipo = $dts['EQUIPO'];
                                        $destino = $dts['DESTINO'];
                                        $seccion = $dts['SECCION'];
                                        $subseccion = $dts['SUBSECCION'];

                                        echo "<tr>"
                                        . "<td>$equipo</td>"
                                        . "<td>$destino</td>"
                                        . "<td>$seccion</td>"
                                        . "<td>$subseccion</td>"
                                        . "<td>"
                                        . "<div class=\"field has-addons has-addons-centered\">"
                                        . "<p class=\"control\">"
                                        . "<button class=\"button is-info is-small\">"
                                        . "<span class=\"icon is-small\">"
                                        . "<i class=\"fas fa-edit\"></i>"
                                        . "</span>"
                                        . "<span>Editar</span>"
                                        . "</button>"
                                        . "</p>"
                                        . "<p class=\"control\">"
                                        . "<button class=\"button is-danger is-small\">"
                                        . "<span class=\"icon is-small\">"
                                        . "<i class=\"fas fa-trash\"></i>"
                                        . "</span>"
                                        . "<span>Eliminar</span>"
                                        . "</button>"
                                        . "</p>"
                                        . "</div>"
                                        . "</td>"
                                        . "</tr>";
                                    }
                                }
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="columns is-centered">
                <div class="column is-8">
                    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                        <?php
                        if ($pagina != 1) {
                            ?>
                            <a class="pagination-previous" href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">Inicio</a>
                            <a class="pagination-previous" href="?pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo $busqueda; ?>">Anterior</a>
                            <?php
                        } else {
                            ?>
                            <a class="pagination-previous" href="#" disabled>Inicio</a>
                            <a class="pagination-previous" href="#" disabled>Anterior</a>
                            <?php
                        }
                        if ($pagina != $totalPaginas) {
                            ?>
                            <a class="pagination-next" href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>">Sigiente</a>
                            <a class="pagination-next" href="?pagina=<?php echo $totalPaginas; ?>&busqueda=<?php echo $busqueda; ?>">Fin</a>
                            <?php
                        } else {
                            ?>
                            <a class="pagination-next" href="#" disabled>Sigiente</a>
                            <a class="pagination-next" href="#" disabled>Fin</a>
                            <?php
                        }
                        ?>
                        <ul class="pagination-list">
                            <?php
                            $rango = 2;
                            $desde = $pagina - $rango;
                            $hasta = $pagina + $rango;
                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                if ($i == 1 || $i == $totalPaginas || $i >= $desde && $i <= $hasta) {
                                    if ($i == $pagina) {

                                        if (($pagina - 1) == 0) {
                                            echo "<li class=\"pagination-link is-current\">1</li>";
                                        } elseif (($pagina - 1) == 1) {
                                            echo "<li><a class=\"pagination-link\" href=\"?pagina=" . intval($pagina - 1) . "&busqueda=$busqueda\">" . intval($pagina - 1) . "</a></li>";
                                            echo "<li class=\"pagination-link is-current\">$i</li>";
                                        } else {
                                            echo "<li><a class=\"pagination-link\" href=\"?pagina=1&busqueda=$busqueda\">1</a></li>";
                                            echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                            echo "<li><a class=\"pagination-link\" href=\"?pagina=" . intval($pagina - 1) . "&busqueda=$busqueda\">" . intval($pagina - 1) . "</a></li>";
                                            echo "<li class=\"pagination-link is-current\">$i</li>";
                                        }

                                        if ($pagina == $totalPaginas) {
                                            
                                        } else {
                                            echo "<li><a class=\"pagination-link\" href=\"?pagina=" . intval($i + 1) . "&busqueda=$busqueda\">" . intval($i + 1) . "</a></li>";
                                            echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                            echo "<li><a class=\"pagination-link\" href=\"?pagina=$totalPaginas&busqueda=$busqueda\">$totalPaginas</a></li>";
                                        }
                                    }
                                }
                            }
                            ?>
                            <!--                            <li><a class="pagination-link" aria-label="Goto page 1">1</a></li>
                                                        <li><span class="pagination-ellipsis">&hellip;</span></li>
                                                        <li><a class="pagination-link" aria-label="Goto page 45">45</a></li>
                                                        <li><a class="pagination-link is-current" aria-label="Page 46" aria-current="page">46</a></li>
                                                        <li><a class="pagination-link" aria-label="Goto page 47">47</a></li>
                                                        <li><span class="pagination-ellipsis">&hellip;</span></li>
                                                        <li><a class="pagination-link" aria-label="Goto page 86">86</a></li>-->
                        </ul>
                    </nav>
                </div>
            </div>
        </section>


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
