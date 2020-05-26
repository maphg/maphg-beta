<?php
session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');
include 'php/conexion.php';
include_once 'php/layout.php';
$layout = new Layout();
$conn = new Conexion();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
} else {
    $conn->conectar();
    $idUsuario = $_SESSION['usuario'];
//Obtener datos del usuario
    $query = "SELECT "
            . "t_users.username 'USERNAME', "
            . "t_users.password 'PASSWORD', "
            . "t_users.id_colaborador 'IDCOLABORADOR', "
            . "t_users.id_permiso 'IDPERMISO', "
            . "t_users.id_destino 'IDDESTINO', "
            . "t_users.fase 'FASE', "
            . "t_users.status 'STATUS', "
            . "t_users.id_seccion 'IDSECCION', "
            . "t_users.DECC 'DEC', "
            . "t_users.ZHAGP 'ZHAGP', "
            . "t_users.ZHATRS 'ZHATRS', "
            . "t_users.ZHCGP 'ZHCGP', "
            . "t_users.ZHCTRS 'ZHCTRS', "
            . "t_users.ZHHGP 'ZHHGP', "
            . "t_users.ZHHTRS 'ZHHTRS', "
            . "t_users.ZHPGP 'ZHPGP', "
            . "t_users.ZHPTRS 'ZHPTRS', "
            . "t_users.ZIA 'ZIA', "
            . "t_users.ZIC 'ZIC', "
            . "t_users.ZIE 'ZIE', "
            . "t_users.ZIL 'ZIL', "
            . "t_users.OMA 'OMA', "
            . "t_users.DEP 'DEP', "
            . "t_users.AUTO 'AUTO', "
            . "t_users.ZHA 'ZHA', "
            . "t_users.ZHC 'ZHC', "
            . "t_users.ZHP 'ZHP', "
            . "t_users.SEG 'SEG', "
            . "t_users.ZHH 'ZHH', "
            . "t_colaboradores.nombre 'NOMBRE',"
            . "t_colaboradores.apellido 'APELLIDO' "
            . "FROM t_users "
            . "INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id "
            . "WHERE t_users.id = $idUsuario";
    try {
        $resp = $conn->obtDatos($query);
        if ($conn->filasConsultadas > 0) {
            foreach ($resp as $dts) {
                $idColaborador = $dts['IDCOLABORADOR'];
                $idPermiso = $dts['IDPERMISO'];
                $idDestino = $dts['IDDESTINO'];
                $idFase = $dts['FASE'];
                $auto = 1;
                $dec = 1;
                $dep = 1;
                $zha = 1;
                $zhc = 1;
                $zhh = 1;
                $zhp = 1;
                $zia = 1;
                $zic = 1;
                $zie = 1;
                $zil = 1;
                $oma = 0;
                $seg = 0;
                $dec = $dts['DEC'];
                $zhagp = $dts['ZHAGP'];
                $zhatrs = $dts['ZHATRS'];
                $zhcgp = $dts['ZHCGP'];
                $zhctrs = $dts['ZHCTRS'];
                $zhhgp = $dts['ZHHGP'];
                $zhhtrs = $dts['ZHHTRS'];
                $zhpgp = $dts['ZHPGP'];
                $zhptrs = $dts['ZHPTRS'];
                $zia = $dts['ZIA'];
                $zic = $dts['ZIC'];
                $zie = $dts['ZIE'];
                $zil = $dts['ZIL'];
//                $oma = $dts['OMA'];
                $dep = $dts['DEP'];
                $auto = $dts['AUTO'];
                $zha = $dts['ZHA'];
                $zhh = $dts['ZHH'];
                $zhc = $dts['ZHC'];
                $zhp = $dts['ZHP'];
                $nombre = $dts['NOMBRE'];
                $apellido = $dts['APELLIDO'];
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

//Total de tareas 
$totalPendientes = 0;
$totalSolucionadas = 0;

$query = "SELECT id, status FROM t_mc WHERE responsable = $idUsuario";
try {
    $resp = $conn->obtDatos($query);
    $totalTareas = $conn->filasConsultadas;
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $statusMC = $dts['status'];
            if ($statusMC == "F") {
                $totalSolucionadas += 1;
            } else {
                $totalPendientes += 1;
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}

$porcentaje = ($totalSolucionadas / $totalTareas ) * 100;

if (isset($_GET['idSubseccion'])) {
    $idSubseccionStock = $_GET['idSubseccion'];
} else {
    $idSubseccionStock = 0;
}

$query = "SELECT id_seccion, id, grupo FROM c_subsecciones WHERE id = $idSubseccionStock";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $idSeccionStock = $dts['id_seccion'];
            $idFamilia = $dts['id'];
            $familia = $dts['grupo'];
        }
    } else {
        $idSeccionStock = 0;
        $idFamilia = 0;
        $familia = "";
    }
} catch (Exception $ex) {
    echo $ex;
}

$conn->cerrar();
?>
<!DOCTYPE html>
<html>

    <head>
        <?php echo $layout->styles(); ?>
        <link rel="stylesheet" type="text/css" href="DataTables/datatables.css"/>
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
                    <?php //echo $layout->menu();    ?>
                </nav>

<!--        <section class="hero is-primary is-small mt-5">
            Hero head: will stick at the top 
            <div class="hero-head">
                <div class="columns">
                    <div class="column">
                        <div class="container">
                            <div class="navbar-end">
                                <a class="navbar-item " href="index.php">
                                    Planner
                                </a>
                                <a class="navbar-item " href="correctivos.php">
                                    Correctivo
                                </a>
                                <a class="navbar-item " href="preventivos.php">
                                    Preventivo
                                </a>
                                <a class="navbar-item is-active" href="stock.php">
                                    Stock/Pedidos
                                </a>
                                <span class="navbar-item">
                                    <a class="button is-primary is-inverted" href="mis-pendientes.php">
                                        <span class="icon">
                                            <i class="fas fa-check-double"></i>
                                        </span>
                                        <span>Mis pendientes</span>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>-->

                <section class="hero is-light is-small mt-5">
                    <!-- Hero head: will stick at the top -->
                    <div class="hero-head mx-2">
                        <div class="">


                            <div id="navbarMenuHeroA" class="navbar-menu">
                                <div class="navbar-start">
                                    <span class="navbar-item">
                                        <a href="index.php" class="button is-warning"><i class="fas fa-arrow-left"></i></a>

                                    </span>
                                    <span class="navbar-item">
                                        <p class="subtitle is-3">Comparativo</p>
                                    </span>

                                </div>
                                <div class="navbar-end">
                                    <span class="navbar-item ">
                                        <button class="button is-success"><i class="fas fa-file-excel mr-1"> </i>Exportar</button>
                                    </span>


                                </div>
                            </div>



                        </div>
                    </div>

                    <!-- Hero content: will be in the middle -->


                </section>

                <!--SECCION DE SELECTS-->
        <!--        <section class="mt-2">
                    <div class="columns is-centered px-3">
        
                        <div class="column is-one-fifth">
                            <div class="control has-icons-left has-text-centered">
                                <div class="select is-medium is-fullwidth">
                                    <select id="cbDestinos" onchange="cargarTareasDestino();">
                <?php
                $conn->conectar();
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
                $conn->cerrar();
                ?>
                                    </select>
                                    <span class="icon is-small is-left  has-text-info">
                                        <img src="svg/banderas/<?php echo $bandera; ?>" width="20px" alt="">
                                    </span>
                                </div>
                            </div>
                        </div>
        
                    </div>
                </section>-->

<!--        <section>
            <div class="columns is-centered px-4 has-background-dark my-4 pt-1">

                <div class="column is-1 has-text-centered">
                    <a class="button is-link is-outlined" href="index.php">
                        <span class="icon is-small"><i class="fas fa-home"></i></span>
                    </a>
                </div>
                <div class="column is-1 has-text-centered">
                    <button class="button is-link is-outlined" onclick="showModal('modalAgregarItem');">
                        Agregar Item
                    </button>
                </div>
                <div class="column has-text-centered">
                    <form>
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <div class="select">
                                            <select id="cbSecciones" onchange="cargarSubsecciones();">
                                                <option>Seccion</option>
                <?php
                $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $idSec = $dts['id'];
                            $nombreSec = $dts['seccion'];
                            echo "<option value=\"$idSec\">$nombreSec</option>";
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
                                    <div class="control">
                                        <div class="select">
                                            <select id="cbSubsecciones">
                                                <option>Subseccion</option>
                                                <option>With options</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <button class="button is-link" onclick="filtrar(<?php echo $idDestinoT; ?>);">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="column has-text-centered">
                    <form>
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input id="txtBusqueda" class="input" type="text" placeholder="Buscar...">
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <button class="button is-link" onclick="busqueda(<?php echo $idDestinoT; ?>, 1);">Filtrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </section>-->
                <section>
                    <div class="columns is-centered my-2">
                        <div class="column is-2 has-text-centered">
                            <div class="control has-icons-left has-icons-right">
                                <input id="txtBusqueda" class="input" type="text" placeholder="Buscar"><span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="column is-1 has-text-left">
                            <button class="button is-link" onclick="busqueda(<?php echo $idDestinoT; ?>, 1);">Buscar</button>
                        </div>
                    </div>
                </section>
                <section id="sectionStock">
                    <div class="columns mt-2 mx-5">
                        <div class="column is-mobile is-centered px-4">
                            <div class="columns is-gapless my-1 is-mobile">
                                <div class="column"><p class="t-titulos has-background-dark has-text-white">Item</p></div>
                                <div class="column"><p class="t-titulos has-background-dark has-text-white">Seccion</p></div>
                                <div class="column"><p class="t-titulos has-background-dark has-text-white">Familia</p></div>
                                <div class="column"><p class="t-titulos has-background-dark has-text-white">Subfamilia</p></div>
                                <div class="column"><p class="t-titulos has-background-info has-text-white">Precio compras</p></div>
                                <div class="column"><p class="t-titulos has-background-info has-text-white">Proveedor</p></div>
                                <div class="column"><p class="t-titulos has-background-info has-text-white">Cotizacion</p></div>
                                <div class="column"><p class="t-titulos has-background-link has-text-white">Precio Mantto</p></div>
                                <div class="column"><p class="t-titulos has-background-link has-text-white">Proveedor</p></div>
                                <div class="column"><p class="t-titulos has-background-link has-text-white">Cotizacion</p></div>
                            </div>
                            <?php
                            $conn->conectar();

                            if ($idDestinoT == 10) {
                                if ($idSubseccionStock > 0) {
                                    $query = "SELECT * FROM t_stock_necesario "
                                            . "WHERE familia = $idSubseccionStock ORDER BY fecha_pedido";
                                } else {
                                    $query = "SELECT * FROM t_stock_necesario "
                                            . "ORDER BY fecha_pedido";
                                }
                            } else {
                                if ($idSubseccionStock > 0) {
                                    $query = "SELECT * FROM t_stock_necesario "
                                            . "WHERE id_destino = $idDestinoT AND familia = $idSubseccionStock ORDER BY fecha_pedido";
                                } else {
                                    $query = "SELECT * FROM t_stock_necesario "
                                            . "WHERE id_destino = $idDestinoT ORDER BY fecha_pedido";
                                }
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
                                if ($idSubseccionStock > 0) {
                                    $query = "SELECT t_stock_necesario.id 'ID', "
                                            . "t_stock_necesario.id_destino 'IDDESTINO', "
                                            . "t_stock_necesario.cod2bend 'COD2BEND', "
                                            . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                                            . "t_stock_necesario.id_seccion 'IDSECCION', "
                                            . "t_stock_necesario.familia 'IDFAMILIA', "
                                            . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                                            . "t_stock_necesario.precio_compras 'PRECIOC', "
                                            . "t_stock_necesario.proveedor_compras 'PROVC', "
                                            . "t_stock_necesario.cotizacion_compras 'COTC', "
                                            . "t_stock_necesario.precio_mantto 'PRECIOM', "
                                            . "t_stock_necesario.proveedor_mantto 'PROVM', "
                                            . "t_stock_necesario.cotizacion_mantto 'COTM', "
                                            . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                                            . "c_secciones.seccion 'SECCION', "
                                            . "c_subsecciones.grupo 'FAMILIA' "
                                            . "FROM t_stock_necesario "
                                            . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                                            . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                                            . "WHERE t_stock_necesario.familia = $idSubseccionStock "
                                            . "ORDER BY fecha_pedido "
                                            . "LIMIT $desde, $porPagina";
                                } else {
                                    $query = "SELECT t_stock_necesario.id 'ID', "
                                            . "t_stock_necesario.id_destino 'IDDESTINO', "
                                            . "t_stock_necesario.cod2bend 'COD2BEND', "
                                            . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                                            . "t_stock_necesario.id_seccion 'IDSECCION', "
                                            . "t_stock_necesario.familia 'IDFAMILIA', "
                                            . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                                            . "t_stock_necesario.precio_compras 'PRECIOC', "
                                            . "t_stock_necesario.proveedor_compras 'PROVC', "
                                            . "t_stock_necesario.cotizacion_compras 'COTC', "
                                            . "t_stock_necesario.precio_mantto 'PRECIOM', "
                                            . "t_stock_necesario.proveedor_mantto 'PROVM', "
                                            . "t_stock_necesario.cotizacion_mantto 'COTM', "
                                            . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                                            . "c_secciones.seccion 'SECCION', "
                                            . "c_subsecciones.grupo 'FAMILIA' "
                                            . "FROM t_stock_necesario "
                                            . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                                            . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                                            . "ORDER BY fecha_pedido "
                                            . "LIMIT $desde, $porPagina";
                                }
                            } else {
                                if ($idSubseccionStock > 0) {
                                    $query = "SELECT t_stock_necesario.id 'ID', "
                                            . "t_stock_necesario.id_destino 'IDDESTINO', "
                                            . "t_stock_necesario.cod2bend 'COD2BEND', "
                                            . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                                            . "t_stock_necesario.id_seccion 'IDSECCION', "
                                            . "t_stock_necesario.familia 'IDFAMILIA', "
                                            . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                                            . "t_stock_necesario.precio_compras 'PRECIOC', "
                                            . "t_stock_necesario.proveedor_compras 'PROVC', "
                                            . "t_stock_necesario.cotizacion_compras 'COTC', "
                                            . "t_stock_necesario.precio_mantto 'PRECIOM', "
                                            . "t_stock_necesario.proveedor_mantto 'PROVM', "
                                            . "t_stock_necesario.cotizacion_mantto 'COTM', "
                                            . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                                            . "c_secciones.seccion 'SECCION', "
                                            . "c_subsecciones.grupo 'FAMILIA' "
                                            . "FROM t_stock_necesario "
                                            . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                                            . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                                            . "WHERE t_stock_necesario.id_destino = $idDestinoT "
                                            . "AND t_stock_necesario.familia = $idSubseccionStock "
                                            . "ORDER BY fecha_pedido "
                                            . "LIMIT $desde, $porPagina";
                                } else {
                                    $query = "SELECT t_stock_necesario.id 'ID', "
                                            . "t_stock_necesario.id_destino 'IDDESTINO', "
                                            . "t_stock_necesario.cod2bend 'COD2BEND', "
                                            . "t_stock_necesario.descripcion2bend 'DESC2BEND', "
                                            . "t_stock_necesario.id_seccion 'IDSECCION', "
                                            . "t_stock_necesario.familia 'IDFAMILIA', "
                                            . "t_stock_necesario.subfamilia 'SUBFAMILIA', "
                                            . "t_stock_necesario.precio_compras 'PRECIOC', "
                                            . "t_stock_necesario.proveedor_compras 'PROVC', "
                                            . "t_stock_necesario.cotizacion_compras 'COTC', "
                                            . "t_stock_necesario.precio_mantto 'PRECIOM', "
                                            . "t_stock_necesario.proveedor_mantto 'PROVM', "
                                            . "t_stock_necesario.cotizacion_mantto 'COTM', "
                                            . "t_stock_necesario.descripcion_nueva 'DESCNUEVA', "
                                            . "c_secciones.seccion 'SECCION', "
                                            . "c_subsecciones.grupo 'FAMILIA' "
                                            . "FROM t_stock_necesario "
                                            . "INNER JOIN c_secciones ON t_stock_necesario.id_seccion = c_secciones.id "
                                            . "INNER JOIN c_subsecciones ON t_stock_necesario.familia = c_subsecciones.id "
                                            . "WHERE t_stock_necesario.id_destino = $idDestinoT "
                                            . "ORDER BY fecha_pedido "
                                            . "LIMIT $desde, $porPagina";
                                }
                            }

                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $id = $dts['ID'];
                                        $idDestinoReg = $dts['IDDESTINO'];
                                        $cod2bend = $dts['COD2BEND'];
                                        $descripcion2bend = $dts['DESC2BEND'];
                                        $seccion = $dts['SECCION'];
                                        $familia = $dts['FAMILIA'];
                                        $subfamilia = $dts['SUBFAMILIA'];
                                        $descripcionNueva = $dts['DESCNUEVA'];
                                        $precioCompras = $dts['PRECIOC'];
                                        $proveedorCompras = $dts['PROVC'];
                                        $cotizacionCompras = $dts['COTC'];
                                        $precioMantto = $dts['PRECIOM'];
                                        $proveedorMantto = $dts['PROVM'];
                                        $cotizacionMantto = $dts['COTM'];


                                        echo "<div class=\"columns is-gapless my-1 is-mobile\">"
                                        . "<div class=\"column\">"
                                        . "<div class=\"columns is-gapless modal-button\" data-target=\"modal-datos-compra-mantto\" aria-haspopup=\"true\">";
                                        if ($descripcionNueva == "") {
                                            echo "<div class=\"column text-truncate\"><p class=\"t-normal\">$descripcion2bend</p></div>";
                                        } else {
                                            echo "<div class=\"column text-truncate\"><p class=\"t-normal\">$descripcionNueva</p></div>";
                                        }
                                        echo "<div class=\"column\"><p class=\"t-normal\">$seccion</p></div>"
                                        . "<div class=\"column\"><p class=\"t-normal\">$familia</p></div>"
                                        . "<div class=\"column\"><p class=\"t-normal\">$subfamilia</p></div>"
                                        . "<div class=\"column\"><p class=\"t-normal\">$precioCompras</p></div>"
                                        . "<div class=\"column\"><p class=\"t-normal\">$proveedorCompras</p></div>";
                                        if ($cotizacionCompras != "") {
                                            echo "<div class=\"column\"><p class=\"t-solucionado\"><i class=\"fas fa-file-download\"></i> Descargar</p></div>";
                                        } else {
                                            echo "<div class=\"column\"><p class=\"t-proceso\"><i class=\"fas fa-exclamation-triangle\"></i> Sin cotizacion</p></div>";
                                        }

                                        echo "<div class=\"column\"><p class=\"t-normal\">$precioMantto</p></div>"
                                        . "<div class=\"column\"><p class=\"t-normal\">$proveedorMantto</p></div>";
                                        if ($cotizacionMantto != "") {
                                            echo "<div class=\"column\"><p class=\"t-solucionado\"><i class=\"fas fa-file-download\"></i> Descargar</p></div>";
                                        } else {
                                            echo "<div class=\"column\"><p class=\"t-proceso\"><i class=\"fas fa-exclamation-triangle\"></i> Sin cotizacion</p></div>";
                                        }

                                        echo "</div>"
                                        . "</div>"
                                        . "</div>";
                                    }
                                }
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                            ?>

                        </div>
                    </div>
                    <div class="columns is-centered">
                        <div class="column is-8">
                            <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                                <?php
                                if ($pagina != 1) {
                                    ?>
                                    <a class="pagination-previous" onclick="obtenerStockXPagina(<?php echo $idDestinoT; ?>, 1);" href="#">Inicio</a>
                                    <a class="pagination-previous" onclick="obtenerStockXPagina(<?php echo $idDestinoT; ?>, <?php echo $pagina - 1; ?>);" href="#">Anterior</a>
                                    <?php
                                } else {
                                    ?>
                                    <a class="pagination-previous" href="#" disabled>Inicio</a>
                                    <a class="pagination-previous" href="#" disabled>Anterior</a>
                                    <?php
                                }
                                if ($pagina != $totalPaginas) {
                                    ?>
                                    <a class="pagination-next" onclick="obtenerStockXPagina(<?php echo $idDestinoT; ?>, <?php echo $pagina + 1; ?>);" href="#">Siguiente</a>
                                    <a class="pagination-next" onclick="obtenerStockXPagina(<?php echo $idDestinoT; ?>, <?php echo $totalPaginas; ?>);" href="#">Fin</a>
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
                                                    echo "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestinoT, " . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                                                    echo "<li class=\"pagination-link is-current\">$i</li>";
                                                } else {
                                                    echo "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestinoT, 1);\" href=\"#\">1</a></li>";
                                                    echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                                    echo "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestinoT, " . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                                                    echo "<li class=\"pagination-link is-current\">$i</li>";
                                                }

                                                if ($pagina == $totalPaginas) {
                                                    
                                                } else {
                                                    echo "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestinoT, " . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                                                    echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                                    echo "<li><a class=\"pagination-link\" onclick=\"obtenerStockXPagina($idDestinoT, $totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
                                                }
                                            }
                                        }
                                    }
                                    ?>

                                </ul>
                            </nav>
                        </div>
                    </div>

                </section>
            </div>
        </div>

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

        <!--MODAL AGREGAR ITEM DE STOCK-->
        <div id="modalAgregarItem" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-lg">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <div class="columns">
                                    <div class="column has-text-centered">
                                        <h1 class="title is-size-5">Agregar item nuevo</h1>
                                    </div>
                                </div>
                                <div class="columns is-multiline">
                                    <div class="column is-4">
                                        <div class="select is-fullwidth">
                                            <select id="cbDestinoReg">

                                                <?php
                                                if ($idDestinoT == 10) {
                                                    $query = "SELECT * FROM c_destinos ORDER BY destino";
                                                } else {
                                                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoT ORDER BY destino";
                                                }

                                                try {
                                                    $resp = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($resp as $dts) {
                                                            $idDestinoReg = $dts['id'];
                                                            $destinoReg = $dts['destino'];
                                                            if ($idDestinoT == $idDestinoReg) {
                                                                echo "<option value=\"$idDestinoReg\" selected>$destinoReg</option>";
                                                            } else {
                                                                echo "<option value=\"$idDestinoReg\">$destinoReg</option>";
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

                                    <div class="column is-4">
                                        <div class="select is-fullwidth">
                                            <select id="cbSeccion" onchange="cargarSubsecciones();">

                                                <?php
                                                $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";


                                                try {
                                                    $resp = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($resp as $dts) {
                                                            $idSeccionReg = $dts['id'];
                                                            $seccionReg = $dts['seccion'];
                                                            if ($idSeccionStock == $idSeccionReg) {
                                                                echo "<option value=\"$idSeccionReg\" selected>$seccionReg</option>";
                                                            } else {
                                                                echo "<option value=\"$idSeccionReg\">$seccionReg</option>";
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

                                    <div class="column is-4">
                                        <div class="select is-fullwidth">
                                            <select id="cbFamilia">
                                                <?php
                                                if ($idSubseccionStock != 0) {
                                                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionStock ORDER BY grupo";
                                                } else {
                                                    $query = "SELECT * FROM c_subsecciones ORDER BY grupo";
                                                }
                                                try {
                                                    $resp = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($resp as $dts) {
                                                            $idFamilia = $dts['id'];
                                                            $familia = $dts['grupo'];
                                                            if ($idSubseccionStock == $idFamilia) {
                                                                echo "<option value=\"$idFamilia\" selected>$familia</option>";
                                                            } else {
                                                                echo "<option value=\"$idFamilia\">$familia</option>";
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

                                    <div class="column is-4">
                                        <div class="select is-fullwidth">
                                            <select id="cbFase">

                                                <option value="GP">GP</option>
                                                <option value="TRS">TRS</option>
                                                <option value="ZI">ZI</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="column is-4">
                                        <div class="select is-fullwidth">
                                            <select id="cbNaturaleza">
                                                <?php
                                                if ($idDestinoT == 10) {
                                                    $query = "SELECT * FROM c_naturalezas ORDER BY id_destino";
                                                } else {
                                                    $query = "SELECT * FROM c_naturalezas WHERE id_destino = $idDestinoT ORDER BY naturaleza";
                                                }
                                                try {
                                                    $resp = $conn->obtDatos($query);
                                                    if ($conn->filasConsultadas > 0) {
                                                        foreach ($resp as $dts) {
                                                            $idDestinoNaturaleza = $dts['id_destino'];
                                                            $idNaturaleza = $dts['id'];
                                                            $naturaleza = $dts['naturaleza'];

                                                            $query = "SELECT * FROM c_destinos WHERE id = $idDestinoNaturaleza";
                                                            try {
                                                                $resp = $conn->obtDatos($query);
                                                                if ($conn->filasConsultadas > 0) {
                                                                    foreach ($resp as $d) {
                                                                        $destinoNat = $d['destino'];
                                                                    }
                                                                }
                                                            } catch (Exception $ex) {
                                                                echo $ex;
                                                            }
                                                            if ($idDestinoT == 10) {
                                                                echo "<option value=\"$naturaleza\">($destinoNat) $naturaleza</option>";
                                                            } else {
                                                                echo "<option value=\"$naturaleza\">$naturaleza</option>";
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

                                    <div class="column is-4">
                                        <div class="select is-fullwidth">
                                            <select id="cbSubfamilia">

                                                <option value="CONSUMIBLE">CONSUMIBLE</option>
                                                <option value="DESPIECE-EQUIPO">DESPIECE-EQUIPO</option>
                                                <option value="HERRAMIENTA">HERRAMIENTA</option>
                                                <!--<option class="fs-11" value="MOBILIARIO EQUIPO DECORACION">MOBILIARIO EQUIPO DECORACION</option>-->
                                            </select>
                                        </div>
                                    </div>

                                    <div id="divEqPpal" class="column is-3  " style="display: none;">
                                        <input type="text" id="txtEquipoPpal" class="input " placeholder="Equipo ppal">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="number" id="txtCod2bend" class="input " placeholder="Codigo 2Bend" onkeyup="buscarMaterial(this);">
                                        <div id="searchResult" class="container bg-white mt-1 border border-1 rounded-2 shadow-sm" style="width: auto; max-height: 100px; height: auto; display: none; position: fixed; z-index: 1000; overflow-y: auto;">

                                        </div>
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="number" id="txtExistencias2bend" class="input " placeholder="Existencias 2Bend">
                                    </div>

                                    <div class="column is-3  ">
                                        <textarea type="text" id="txtDesc2bend" class="input " placeholder="Descripcion 2Bend"></textarea>
                                    </div>

                                    <div class="column is-3  ">
                                        <textarea type="text" id="txtDescNueva" class="input " placeholder="Descripcion nueva"></textarea>
                                    </div>

                                    <div class="column is-3  ">
                                        <textarea type="text" id="txtCaracteristicasPpales" class="input " placeholder="Caracteristicas Ppales"></textarea>
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="text" id="txtMarca" class="input " placeholder="Marca">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="text" id="txtModelo" class="input " placeholder="Modelo - Cod. Fabricante">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="number" id="txtExistenciasSubalmacen" class="input " placeholder="Existencias Subalmacenes">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="number" id="txtPrecio" class="input " placeholder="$ Precio">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="number" id="txtConsumoAnual" class="input " placeholder="Consumo anual">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="number" id="txtStockNecesario" class="input " placeholder="Stock Necesario">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="number" id="txtUnidadesAPedir" class="input " placeholder="Unidades a pedir">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="text" class="input" id="txtFechaPedido" placeholder="Fecha de pedido"/>
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="text" id="txtPrioridad" class="input " placeholder="Prioridad">
                                    </div>

                                    <div class="column is-3  ">
                                        <input type="text" class="input" id="txtFechaLlegada" placeholder="Fecha de llegada"/>
                                    </div>
                                </div>
                            </div>

                            <div class="container">
                                <div class="columns has-text-centered">
                                    <div class="column">
                                        <button id="" class="button is-light" onclick="closeModal('modalAgregarItem');">CANCELAR</button>
                                    </div>
                                    <div class="column">
                                        <button id="" class="button is-primary" onclick="guardarRegistroStockNecesario();">ACEPTAR</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--MODAL EDITAR ITEM DE STOCK-->
        <div id="modalEditarItem" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-lg">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <input type="hidden" id="hddIdRegistro">
                                <div class="columns">
                                    <div class="column has-text-centered">
                                        <h1 class="title is-size-5">Editar item</h1>
                                    </div>
                                </div>
                                <div class="columns is-multiline">
                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label is-small">Destino</label>
                                            <div class="select is-fullwidth">
                                                <select id="cbDestinoRegEdit" >

                                                    <?php
                                                    if ($idDestinoT == 10) {
                                                        $query = "SELECT * FROM c_destinos ORDER BY destino";
                                                    } else {
                                                        $query = "SELECT * FROM c_destinos WHERE id = $idDestinoT ORDER BY destino";
                                                    }

                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idDestinoReg = $dts['id'];
                                                                $destinoReg = $dts['destino'];
                                                                echo "<option class=\"fs-11\" value=\"$idDestinoReg\">$destinoReg</option>";
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
                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label is-small">Fase</label>
                                            <div class="select is-fullwidth">
                                                <select id="cbFaseEdit">
                                                    <option class="fs-11" value="GP">GP</option>
                                                    <option class="fs-11" value="TRS">TRS</option>
                                                    <option class="fs-11" value="ZI">ZI</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label is-small">Naturaleza</label>
                                            <div class="select is-fullwidth">
                                                <select id="cbNaturalezaEdit">
                                                    <?php
                                                    if ($idDestinoT == 10) {
                                                        $query = "SELECT * FROM c_naturalezas ORDER BY naturaleza";
                                                    } else {
                                                        $query = "SELECT * FROM c_naturalezas WHERE id_destino = $idDestinoT ORDER BY naturaleza";
                                                    }
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idNaturaleza = $dts['id'];
                                                                $idDestinoNat = $dts['id_destino'];
                                                                $naturaleza = $dts['naturaleza'];

                                                                $query = "SELECT * FROM c_destinos WHERE id = $idDestinoNat ORDER BY destino";


                                                                try {
                                                                    $resp = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($resp as $dts) {
                                                                            $destinoNat = $dts['destino'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    echo $ex;
                                                                }

                                                                echo "<option class=\"fs-11\" value=\"$naturaleza\">$naturaleza ($destinoNat)</option>";
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
                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label is-small">Seccion</label>
                                            <div class="select is-fullwidth">
                                                <select id="cbSeccionEdit">

                                                    <?php
                                                    $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";


                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idSeccionReg = $dts['id'];
                                                                $seccionReg = $dts['seccion'];
                                                                echo "<option class=\"fs-11\" value=\"$idSeccionReg\">$seccionReg</option>";
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
                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label is-small">Familia</label>
                                            <div class="select is-fullwidth">
                                                <select id="cbFamiliaEdit" >
                                                    <?php
                                                    $query = "SELECT * FROM c_subsecciones ORDER BY grupo";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idFamilia = $dts['id'];
                                                                $familia = $dts['grupo'];
                                                                echo "<option class=\"fs-11\" value=\"$idFamilia\">$familia</option>";
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

                                    <div class="column is-4">
                                        <div class="field">
                                            <label class="label is-small">Subfamilia</label>
                                            <div class="select is-fullwidth">
                                                <select id="cbSubfamiliaEdit">
                                                    <option class="fs-11" value="CONSUMIBLE">CONSUMIBLE</option>
                                                    <option class="fs-11" value="DESPIECE-EQUIPO">DESPIECE-EQUIPO</option>
                                                    <option class="fs-11" value="HERRAMIENTA">HERRAMIENTA</option>
                                                    <!--<option class="fs-11" value="MOBILIARIO EQUIPO DECORACION">MOBILIARIO EQUIPO DECORACION</option>-->
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Codigo 2Bend</label>
                                            <input type="number" id="txtCod2bendEdit" class="input " placeholder="Codigo 2Bend" onkeyup="buscarMaterial(this);">

                                        </div>
                                        <div id="searchResultEdit" class="container bg-white mt-1 border border-1 rounded-2 shadow-sm" style="width: auto; max-height: 100px; height: auto; display: none; position: fixed; z-index: 1000; overflow-y: auto;">

                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Existencias 2Bend</label>
                                            <input type="number" id="txtExistencias2bendEdit" class="input " placeholder="Existencias 2Bend">
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Descripcion 2bend</label>
                                            <textarea type="text" id="txtDesc2bendEdit" class="input " placeholder="Descripcion 2Bend"></textarea>
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Descripcion nueva</label>
                                            <textarea type="text" id="txtDescNuevaEdit" class="input " placeholder="Descripcion nueva" required></textarea>
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Caracteristicas Ppales</label>
                                            <textarea type="text" id="txtCaracteristicasPpalesEdit" class="input " placeholder="Caracteristicas Ppales" required></textarea>
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Marca</label>
                                            <input type="text" id="txtMarcaEdit" class="input " placeholder="Marca" required>
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Modelo - Cod. Fabricante</label>
                                            <input type="text" id="txtModeloEdit" class="input " placeholder="Modelo - Cod. Fabricante" required>
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Existencia subalmacen</label>
                                            <input type="number" id="txtExistenciasSubalmacenEdit" class="input " placeholder="Existencias Subalmacenes">
                                        </div>

                                    </div>
                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Ubicacion</label>
                                            <input type="text" id="txtUbicacionEdit" class="input  datetimepicker-input text-center rounded-3" placeholder="Ubicacion">
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Precio</label>
                                            <input type="number" id="txtPrecioEdit" class="input " placeholder="$ Precio">
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Consumo anual</label>
                                            <input type="number" id="txtConsumoAnualEdit" class="input " placeholder="Consumo anual">
                                        </div>

                                    </div>

                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Stock necesario</label>
                                            <input type="number" id="txtStockNecesarioEdit" class="input " placeholder="Stock Necesario" required>
                                        </div>

                                    </div>
                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Unidades a pedir</label>
                                            <input type="number" id="txtUnidadesAPedirEdit" class="input " placeholder="Unidades a pedir">
                                        </div>

                                    </div>
                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Fecha pedido</label>
                                            <input type="text" class="input" id="txtFechaPedidoEdit" placeholder="Fecha de pedido"/>
                                        </div>

                                    </div>
                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Prioridad</label>
                                            <input type="text" id="txtPrioridadEdit" class="input " placeholder="Prioridad">
                                        </div>

                                    </div>
                                    <div class="column is-3">
                                        <div class="field">
                                            <label class="label is-small">Fecha llegada</label>
                                            <input type="text" class="input" id="txtFechaLlegadaEdit" placeholder="Fecha de llegada"/>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="container">
                                <div class="columns has-text-centered">
                                    <div class="column has-text-left">
                                        <button id="" class="button is-danger" onclick="showModal('modalEliminarItem');">ELIMINAR</button>
                                    </div>
                                    <div class="column has-text-right">
                                        <button id="" class="button is-light" onclick="closeModal('modalEditarItem');">CANCELAR</button>
                                    </div>
                                    <div class="column">
                                        <button id="" class="button is-primary" onclick="actualizarRegistroStockNecesario();">ACEPTAR</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <div id="modalEliminarItem" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <div class="columns">
                                    <div class="column">
                                        ¿Seguro que desea eliminar este registro?, esta acción no se puede deshacer.
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="columns">
                                    <div class="column">
                                        <button type="button" class="button" onclick="closeModal('modalEliminarItem');">Cancelar</button>

                                    </div>
                                    <div class="column">
                                        <button type="button" class="button is-danger" onclick="eliminarRegistroStockNecesario();">Eliminar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--MODAL AGREGAR DATOS COMPRAS MANTTO-->
        <div class="modal" id="modal-datos-compra-mantto">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head has-background-white has-text-centered">
                    <p class="modal-card-title">Cotizaciones Compras</p>
                    <button class="delete" aria-label="close"></button>
                </header>
                <section class="modal-card-body">
                    <!-- Content ... -->
                    <div class="columns">
                        <div class="column">

                            <div class="columns">
                                <div class="column">
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input is-large" type="email" placeholder="Coste en USD">
                                        <span class="icon is-medium is-left">
                                            <i class="fas fa-dollar-sign"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <div class="control has-icons-left has-icons-right">
                                        <input class="input is-large" type="email" placeholder="Nombre del proveedor">
                                        <span class="icon is-medium is-left">
                                            <i class="fas fa-store"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <button class="button is-dark is-large is-fullwidth">
                                        <span class="icon">
                                            <i class="fas fa-paperclip"></i>
                                        </span>
                                        <span>Adjuntar Cotizacion</span>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot has-background-white">
                    <button class="button is-success is-fullwidth">Guardar Cambios</button>
                    <button class="button  is-fullwidth close-modal">Cancelar</button>
                </footer>
            </div>
        </div>

        <a id="btnAncla" href="#nav-menu" class="button is-primary is-rounded ancla" style="display:none;"><i class="fa fa-arrow-up"></i></a>
    </body>
    <?php echo $layout->scripts(); ?>

    <script src="js/plannerJS.js"></script>
    <script src="js/usuariosJS.js"></script>
    <script src="js/stockJS.js"></script>
    <!--DataTables-->
    <script src="DataTables/datatables.js"></script>
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

            var config = {
                language: 'es',
                range: false,
                toggleSelected: false,
                multipleDatesSeparator: ' - ',
                position: "left bottom"
            };

            var dp1 = $('#txtFechaPedido').datepicker(config).data('datepicker');
            var dp2 = $('#txtFechaLlegada').datepicker(config).data('datepicker');

            var dp3 = $('#txtFechaPedidoEdit').datepicker(config).data('datepicker');
            var dp4 = $('#txtFechaLlegadaEdit').datepicker(config).data('datepicker');

            var pedidos = $('#tablaPedidos').DataTable({
                "processing": true,
                "serverSide": true,
                "scrollY": "50vh",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                "ajax": {
                    url: "php/getDataStock.php", // json datasource
                    type: "post", // method  , by default get
                    data: "idDestino=<?php echo $idDestinoT; ?>&idSubseccion=<?php echo $idSubseccionStock; ?>",
                    error: function (data) {  // error handling
                        alert(data.responseText);
                        $(".tablaPedidos-error").html("");
                        $("#tablaPedidos").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        $("#tablaPedidos_processing").css("display", "none");

                    }
                },
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Reporte de Stock',
                        className: 'button is-primary is-small'
                    },
                ],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                            );
                                    column
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                });
                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }
            });
//                                                var pedidos = $('#tablaPedidos').DataTable({
//                                                    "order": [[0, "asc"]],
//                                                    "select": true,
//                                                    "scrollY": "50vh",
//                                                    "scrollX": true,
//                                                    "scrollCollapse": true,
//                                                    "paging": false,
//                                                    "autoWidth": true,
//                                                    'dom': 'Rlfrtip',
//                                                    'colReorder': {
//                                                        'allowReorder': false
//                                                    },
//                                                    "columnDefs": [
//                                                        {"width": "100%", "targets": 2}
//                                                    ],
//                                                    "language": {
//                                                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
//                                                    },
//                                                    dom: 'Bfrtip',
//                                                    buttons: [
//                                                        {
//                                                            extend: 'excel',
//                                                            title: 'Reporte de Stock',
//                                                            className: 'button is-primary is-small'
//                                                        },
//                                                    ],
//                                                    initComplete: function () {
//                                                        this.api().columns().every(function () {
//                                                            var column = this;
//                                                            var select = $('<select><option value=""></option></select>')
//                                                                    .appendTo($(column.footer()).empty())
//                                                                    .on('change', function () {
//                                                                        var val = $.fn.dataTable.util.escapeRegex(
//                                                                                $(this).val()
//                                                                                );
//                                                                        column
//                                                                                .search(val ? '^' + val + '$' : '', true, false)
//                                                                                .draw();
//                                                                    });
//                                                            column.data().unique().sort().each(function (d, j) {
//                                                                select.append('<option value="' + d + '">' + d + '</option>')
//                                                            });
//                                                        });
//                                                    }
//
//                                                });
//
            pedidos
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = pedidos.rows(indexes).data().toArray();
                        $("#hddIdRegistro").val(rowData[0][0]);
                        $.ajax({
                            type: 'post',
                            url: 'php/stockPHP.php',
                            data: 'action=6&idRegistro=' + rowData[0][0],
                            success: function (data) {
                                var registro = JSON.parse(data);

                                $("#cbDestinoRegEdit").val(registro.idDestino);
                                $("#cbFaseEdit").val(registro.fase);
//                                                        $("#txtUbicacionEdit").val(registro.ubicacion);
                                $("#txtCod2bendEdit").val(registro.cod2bend);
                                $("#txtDesc2bendEdit").val(registro.descripcion2bend);
                                $("#cbNaturalezaEdit").val(registro.naturaleza);
                                $("#cbSeccionEdit").val(registro.seccion);
                                $("#cbFamiliaEdit").val(registro.familia);
                                $("#cbSubfamiliaEdit").val(registro.subfamilia);
                                $("#txtDescNuevaEdit").val(registro.descripcionNueva);
                                $("#txtMarcaEdit").val(registro.marca);
                                $("#txtModeloEdit").val(registro.modelo);
                                $("#txtCaracteristicasPpalesEdit").val(registro.caracteristicasPpales);
                                $("#txtExistencias2bendEdit").val(registro.existencias2bend);
                                $("#txtExistenciasSubalmacenEdit").val(registro.existenciasSubalmacen);
                                $("#txtPrecioEdit").val(registro.precio)
                                $("#txtConsumoAnualEdit").val(registro.consumoAnual);
                                $("#txtStockNecesarioEdit").val(registro.stockNecesario);
                                $("#txtUnidadesAPedirEdit").val(registro.unidadesPedir);
                                $("#txtFechaPedidoEdit").val(registro.fechaPedido);
                                $("#txtPrioridadEdit").val(registro.prioridad);
                                $("#txtFechaLlegadaEdit").val(registro.fechaLlegada);
                                $("#searchResultEdit").html("");
                                $("#searchResultEdit").hide();
//                                                        $("#cbDestinoRegEdit").val();
//                                                        $("#cbFaseEdit").val();
//                                                        $("#txtUbicacionEdit").val();
//                                                        $("#txtCod2bendEdit").val();
//                                                        $("#txtDesc2bendEdit").val();
//                                                        $("#cbNaturalezaEdit").val();
//                                                        $("#cbSeccionEdit").val();
//                                                        $("#cbFamiliaEdit").val();
//                                                        $("#cbSubfamiliaEdit").val();
//                                                        $("#txtDescNuevaEdit").val();
//                                                        $("#txtMarcaEdit").val();
//                                                        $("#txtModeloEdit").val();
//                                                        $("#txtCaracteristicasPpalesEdit").val();
//                                                        $("#txtExistencias2bendEdit").val();
//                                                        $("#txtExistenciasSubalmacenEdit").val();
//                                                        $("#txtPrecioEdit").val()
//                                                        $("#txtConsumoAnualEdit").val();
//                                                        $("#txtStockNecesarioEdit").val();
//                                                        $("#txtUnidadesAPedirEdit").val();
//                                                        $("#txtFechaPedidoEdit").val();
//                                                        $("#txtPrioridadEdit").val();
//                                                        $("#txtFechaLlegadaEdit").val();

                            }
                        });


                    });

        });
    </script>
    <script>
        $(function () {
            $('select[multiple].active.3col').multiselect({
                columns: 1,
                placeholder: 'Secciones',
                search: false,
                searchOptions: {
                    'default': 'Buscar secciones'
                },
            });

            $(".container-scroll").mCustomScrollbar({
                theme: "minimal-dark"
            });

        });
    </script>
<!--    <script>
        $('#myDatePicker').datepicker({
            // Let's make a function which will add class 'my-class' to every 11 of the month
            // and make these cells disabled.

            onSelect: function onSelect(fd, date) {
                var idEquipo = $("#hddIdEquipo").val();
                var idDestino = $("#hddIdDestino").val();
                var idSubseccion = $("#hddIdSubseccion").val();
                var idCategoria = $("#hddIdCategoria").val();
                var idSubcategoria = $("#hddIdSubcategoria").val();
                if (date.length == 2) {
                    var idTarea = $("#hddIDTarea").val();
                    actualizarRangoFechas(idTarea, fd);
                    recargarListaTareas(idSubseccion, idDestino, idCategoria, idSubcategoria);

                    // alert(date + " " + idTarea);
                }
            }
        });

        $('#myDatePickerMC').datepicker({
            // Let's make a function which will add class 'my-class' to every 11 of the month
            // and make these cells disabled.

            onSelect: function onSelect(fd, date) {
                var idEquipo = $("#hddIdEquipo").val();
                var idDestino = $("#hddIdDestino").val();
                var idSubseccion = $("#hddIdSubseccion").val();
                var idCategoria = $("#hddIdCategoria").val();
                var idSubcategoria = $("#hddIdSubcategoria").val();
                if (date.length == 2) {
                    var idTarea = $("#hddIDTarea").val();
                    actualizarRangoFechas(idTarea, fd);

                    recargarListaTareasMC(idEquipo);
                    // alert(date + " " + idTarea);
                }
            }
        });
    </script>-->
</html>
