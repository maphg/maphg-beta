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
        <!--<link href="fontawesome/css/fontawesome.css" rel="stylesheet" type="text/css"/>-->
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
                    <?php //echo $layout->menu(); ?>
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

                <section>
                    <div class="columns is-centered mx-5">
                        <div class="column">
                            <button class="button modal-button" data-target="modal-agregar-equipo" aria-haspopup="true">Agregar equipo</button>
                        </div>
                        <div class="column">
                            <div class="columns">
                                <?php
                                if ($idDestinoT == 10) {
                                    ?>
                                    <div class="column">
                                        <div class="field">
                                            <div class="control">
                                                <div class="select is-fullwidth">
                                                    <select id="selectDestinos">
                                                        <option value="10">Destino</option>
                                                        <?php
                                                        $query = "SELECT * FROM c_destinos ORDER BY destino";
                                                        try {
                                                            $resp = $conn->obtDatos($query);
                                                            if ($conn->filasConsultadas > 0) {
                                                                foreach ($resp as $dts) {
                                                                    $destinoId = $dts['id'];
                                                                    $destinoNombre = $dts['destino'];
                                                                    echo "<option value=\"$destinoId\">$destinoNombre</option>";
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
                                    <?php
                                }
                                ?>
                                <div class="column">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbSeccion" onchange="obtenerSubsecciones();">
                                                    <option value="0">Seccion</option>
                                                    <?php
                                                    $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $seccionId = $dts['id'];
                                                                $seccionNombre = $dts['seccion'];
                                                                echo "<option value=\"$seccionId\">$seccionNombre</option>";
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
                                <div class="column">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbSubseccion">
                                                    <option value="0">Subseccion</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <button class="button is-info" onclick="obtEquiposXFiltrado(<?php echo $idDestinoT; ?>, 1);">Filtrar</button>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="columns is-centered">
                                <div class="column has-text-centered">
                                    <div class="control has-icons-left has-icons-right">
                                        <input id="txtBusqueda" class="input" type="text" placeholder="Buscar equipo"><span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                                <div class="column is-2">
                                    <button class="button is-info" onclick="obtEquipoXBusqueda(<?php echo $idDestinoT; ?>, 1);">Buscar...</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="columns is-centered mx-5">
                        <div id="divEquipos" class="column">
                            <div class="columns is-gapless my-1 is-mobile">
                                <div class="column">
                                    <div class="columns is-gapless">
                                        <div class="column is-4"><p class="t-titulos has-background-dark has-text-white">Equipo</p></div>
                                        <div class="column is-1"><p class="t-titulos has-background-dark has-text-white">Destino</p></div>
                                        <div class="column is-1"><p class="t-titulos has-background-dark has-text-white">Seccion</p></div>
                                        <div class="column is-3"><p class="t-titulos has-background-dark has-text-white">Subseccion</p></div>
                                        <div class="column"><p class="t-titulos has-background-dark has-text-white">Opciones</p></div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            if ($idDestinoT == 10) {
                                $query = "SELECT t_equipos.id 'ID', "
                                        . "t_equipos.equipo 'EQUIPO', "
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
                                        . "WHERE t_equipos.status = 'A'";
                            } else {
                                $query = "SELECT t_equipos.id 'ID', "
                                        . "t_equipos.equipo 'EQUIPO', "
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
                                        . "WHERE t_equipos.id_destino = $idDestinoT AND t_equipos.status = 'A'";
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
                                $query = "SELECT t_equipos.id 'ID', "
                                        . "t_equipos.equipo 'EQUIPO', "
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
                                        . "ORDER BY t_equipos.id_destino "
                                        . "LIMIT $desde, $porPagina ";
                            } else {
                                $query = "SELECT t_equipos.id 'ID', "
                                        . "t_equipos.equipo 'EQUIPO', "
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
                                        . "ORDER BY t_equipos.id_destino "
                                        . "LIMIT $desde, $porPagina ";
                            }
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idEquipo = $dts['ID'];
                                        $equipo = $dts['EQUIPO'];
                                        $destino = $dts['DESTINO'];
                                        $seccion = $dts['SECCION'];
                                        $subseccion = $dts['SUBSECCION'];


                                        echo "<div class=\"columns is-gapless my-1 is-mobile\">"
                                        . "<div class=\"column\">"
                                        . "<div class=\"columns is-gapless\">"
                                        . "<div class=\"column is-4\"><p class=\"t-normal\">$equipo</p></div>"
                                        . "<div class=\"column is-1\"><p class=\"t-normal\">$destino</p></div>"
                                        . "<div class=\"column is-1\"><p class=\"t-normal\">$seccion</p></div>"
                                        . "<div class=\"column is-3\"><p class=\"t-normal\">$subseccion</p></div>"
                                        . "<div class=\"column t-normal\">"
                                        . "<div class=\"field has-addons has-addons-centered\">"
                                        . "<p class=\"control\">"
                                        . "<button class=\"button is-info is-small\" onclick=\"showModal('modal-editar-equipo'); editarEquipo($idEquipo);\">"
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
                                        . "<p class=\"control\">"
                                        . "<a href=\"equipos_mp.php?idEquipo=$idEquipo\" class=\"button is-primary is-small\">"
                                        . "<span class=\"icon is-small\">"
                                        . "<i class=\"fas fa-wrench\"></i>"
                                        . "</span>"
                                        . "<span>MP</span>"
                                        . "</a>"
                                        . "</p>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>"
                                        . "</div>";
                                    }
                                }
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                            ?>

                            <div class="columns is-centered">
                                <div class="column is-8">
                                    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                                        <?php
                                        if ($pagina != 1) {
                                            ?>
                                            <a class="pagination-previous" onclick="obtEquipoXPagina(<?php echo $idDestinoT; ?>, 1);" href="#">Inicio</a>
                                            <a class="pagination-previous" onclick="obtEquipoXPagina(<?php echo $idDestinoT; ?>, <?php echo $pagina - 1; ?>);" href="#">Anterior</a>
                                            <?php
                                        } else {
                                            ?>
                                            <a class="pagination-previous" href="#" disabled>Inicio</a>
                                            <a class="pagination-previous" href="#" disabled>Anterior</a>
                                            <?php
                                        }
                                        if ($pagina != $totalPaginas) {
                                            ?>
                                            <a class="pagination-next" onclick="obtEquipoXPagina(<?php echo $idDestinoT; ?>,<?php echo $pagina + 1; ?>);" href="#">Siguiente</a>
                                            <a class="pagination-next" onclick="obtEquipoXPagina(<?php echo $idDestinoT; ?>,<?php echo $totalPaginas; ?>);" href="#">Fin</a>
                                            <?php
                                        } else {
                                            ?>
                                            <a class="pagination-next" href="#" disabled>Siguiente</a>
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
                                                            echo "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestinoT," . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                                                            echo "<li class=\"pagination-link is-current\">$i</li>";
                                                        } else {
                                                            echo "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina(1);\" href=\"#\">1</a></li>";
                                                            echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                                            echo "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestinoT," . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                                                            echo "<li class=\"pagination-link is-current\">$i</li>";
                                                        }

                                                        if ($pagina == $totalPaginas) {
                                                            
                                                        } else {
                                                            echo "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestinoT," . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                                                            echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                                            echo "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestinoT, $totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
                                                        }
                                                    }
                                                }
                                            }
                                            ?>

                                        </ul>
                                    </nav>
                                </div>
                            </div>
                                <!--                            <table class="table is-bordered is-hoverable is-striped is-fullwidth is-size-7" >
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
                                $query = "SELECT t_equipos.id 'ID', "
                                        . "t_equipos.equipo 'EQUIPO', "
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
                                        . "WHERE t_equipos.status = 'A'";
                            } else {
                                $query = "SELECT t_equipos.id 'ID', "
                                        . "t_equipos.equipo 'EQUIPO', "
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
                                        . "WHERE t_equipos.id_destino = $idDestinoT AND t_equipos.status = 'A'";
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
                                $query = "SELECT t_equipos.id 'ID', "
                                        . "t_equipos.equipo 'EQUIPO', "
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
                                        . "ORDER BY t_equipos.id_destino "
                                        . "LIMIT $desde, $porPagina ";
                            } else {
                                $query = "SELECT t_equipos.id 'ID', "
                                        . "t_equipos.equipo 'EQUIPO', "
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
                                        . "ORDER BY t_equipos.id_destino "
                                        . "LIMIT $desde, $porPagina ";
                            }

                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $idEquipo = $dts['ID'];
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
                                        . "<button class=\"button is-info is-small modal-button\" data-target=\"modal-editar-equipo\" aria-haspopup=\"true\">"
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
                                        . "<p class=\"control\">"
                                        . "<a href=\"equipos_mp.php?idEquipo=$idEquipo\" class=\"button is-primary is-small\">"
                                        . "<span class=\"icon is-small\">"
                                        . "<i class=\"fas fa-wrench\"></i>"
                                        . "</span>"
                                        . "<span>MP</span>"
                                        . "</a>"
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
                                                            </table>-->
                        </div>
                    </div>
                    <!--                    <div class="columns is-centered">
                                            <div class="column is-8">
                                                <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                    <?php
                    if ($pagina != 1) {
                        ?>
                                                                                                            <a class="pagination-previous" href="?pagina=<?php echo 1; ?>">Inicio</a>
                                                                                                            <a class="pagination-previous" href="?pagina=<?php echo $pagina - 1; ?>">Anterior</a>
                        <?php
                    } else {
                        ?>
                                                                                                            <a class="pagination-previous" href="#" disabled>Inicio</a>
                                                                                                            <a class="pagination-previous" href="#" disabled>Anterior</a>
                        <?php
                    }
                    if ($pagina != $totalPaginas) {
                        ?>
                                                                                                            <a class="pagination-next" href="?pagina=<?php echo $pagina + 1; ?>">Sigiente</a>
                                                                                                            <a class="pagination-next" href="?pagina=<?php echo $totalPaginas; ?>">Fin</a>
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
                                    echo "<li><a class=\"pagination-link\" href=\"?pagina=" . intval($pagina - 1) . "\">" . intval($pagina - 1) . "</a></li>";
                                    echo "<li class=\"pagination-link is-current\">$i</li>";
                                } else {
                                    echo "<li><a class=\"pagination-link\" href=\"?pagina=1\">1</a></li>";
                                    echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                    echo "<li><a class=\"pagination-link\" href=\"?pagina=" . intval($pagina - 1) . "\">" . intval($pagina - 1) . "</a></li>";
                                    echo "<li class=\"pagination-link is-current\">$i</li>";
                                }

                                if ($pagina == $totalPaginas) {
                                    
                                } else {
                                    echo "<li><a class=\"pagination-link\" href=\"?pagina=" . intval($i + 1) . "\">" . intval($i + 1) . "</a></li>";
                                    echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                    echo "<li><a class=\"pagination-link\" href=\"?pagina=$totalPaginas\">$totalPaginas</a></li>";
                                }
                            }
                        }
                    }
                    ?>
                    
                                                    </ul>
                                                </nav>
                                            </div>
                                        </div>-->
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

        <!--MODAL AGREGAR EQUIPO-->
        <div id="modal-agregar-equipo" class="modal">
            <div class="modal-background"></div>
            <div class="modal-card modal-md">
                <header class="modal-card-head">
                    <p class="modal-card-title">Agregar Equipo</p>
                    <button class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <!-- Content ... -->
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success">Save changes</button>
                    <button class="button">Cancel</button>
                </footer>
            </div>
        </div>

        <!--MODAL EDITAR EQUIPO-->
        <div id="modal-editar-equipo" class="modal">
            <div class="modal-background"></div>
            <div class="modal-card modal-md">
                <header class="modal-card-head">
                    <p class="modal-card-title">Editar equipo</p>
                    <button class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <div class="columns">
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Cod. 2Bend</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" placeholder="Codigo 2Bend">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Equipo</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" placeholder="Nombre equipo">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Matricula</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" placeholder="Matricula">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Tipo Equipo</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select>
                                                    <option>Select dropdown</option>
                                                    <option>With options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Marca</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select>
                                                    <option>Select dropdown</option>
                                                    <option>With options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Modelo</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" placeholder="Modelo">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Serie</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" placeholder="Serie">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">CECO</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select>
                                                    <option>Select dropdown</option>
                                                    <option>With options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Estado</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select>
                                                    <option>Select dropdown</option>
                                                    <option>With options</option>
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
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Jerarquia</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select>
                                                    <option>Select dropdown</option>
                                                    <option>With options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Seccion</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select>
                                                    <option>Select dropdown</option>
                                                    <option>With options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Subseccion</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select>
                                                    <option>Select dropdown</option>
                                                    <option>With options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-4">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Coste (USD)</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" placeholder="Coste (USD)">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Unidad</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select>
                                                    <option>Select dropdown</option>
                                                    <option>With options</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field is-horizontal">
                                <div class="field-label is-normal">
                                    <label class="label">Valor</label>
                                </div>
                                <div class="field-body">
                                    <div class="field">
                                        <p class="control">
                                            <input class="input" type="text" placeholder="Valor">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <button class="button is-info">Agregar</button>
                        </div>
                    </div>
                    <hr class="navbar-divider">
                    <div class="columns">
                        <div class="column">
                            <h1 class="subtitle">Fotografias</h1>
                        </div>
                    </div>
                    <div class="columns is-multiline">
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        <div class="column is-2">
                            <figure class="image is-128x128">
                                <img src="https://bulma.io/images/placeholders/128x128.png">
                            </figure>
                        </div>
                        
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <button class="button is-success">Save changes</button>
                    <button class="button">Cancel</button>
                </footer>
            </div>
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
