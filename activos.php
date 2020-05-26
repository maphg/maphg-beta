<?php
session_start();
include_once 'php/layout.php';
include 'php/conexion.php';
$layout = new Layout();
$conn = new Conexion();
$conn->conectar();
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MAPHG -  Lista Activos</title>
        <link rel="icon" href="svg/logo6.png">
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="css/bulma-docs.min.css">
        <link rel="stylesheet" href="css/clases.css">
        <link rel="stylesheet" href="css/hover.css">
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <style>
            .container-scroll {
                overflow-x: scroll;
                overflow-y: hidden;
                white-space: nowrap;
            }
        </style>
    </head>

    <body>


        <nav class="navbar is-transparent">
            <div class="navbar-brand">
                <a class="navbar-item" href="index.php">
                    <img src="svg/logon2.svg" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28">
                </a>
                <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div id="navbarExampleTransparentExample" class="navbar-menu">


            </div>
        </nav>


        <section class="hero is-light is-small">
            <!-- Hero head: will stick at the top -->
            <div class="hero-head mx-2">
                <div class="navbar">


                    <div id="navbarMenuHeroA" class="navbar-menu">
                        <div class="navbar-start">
                            <span class="navbar-item">
                                <button class="button is-warning"><i class="fas fa-arrow-left"></i></button>

                            </span>
                            <span class="navbar-item">
                                <p class="subtitle is-3">Lista de activos</p>
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

        <section>
            <div class="columns is-centered my-2">
                <div class="column is-2 has-text-centered">
                    <div class="control has-icons-left has-icons-right">
                        <input id="txtBusqueda" class="input" type="text" placeholder="Buscar activos"><span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                    </div>
                </div>
                <div class="column is-2">
                    <button class="button is-info" onclick="obtActivoXBusqueda(1);">Buscar...</button>
                </div>

            </div>
        </section>

        <section id="sectionActivos" class="mt-4 mx-4">

            <div class="columns is-gapless my-1 is-mobile">
                <div class="column">
                    <div class="columns is-gapless">
                        <div class="column"><p class="t-titulos has-background-dark has-text-white">Naturaleza</p></div>
                        <div class="column"><p class="t-titulos has-background-dark has-text-white">SubFam 2bend</p></div>
                        <div class="column"><p class="t-titulos has-background-dark has-text-white">MaTerial</p></div>
                        <div class="column"><p class="t-titulos has-background-dark has-text-white">Texto breve</p></div>
                        <div class="column"><p class="t-titulos has-background-dark has-text-white">Unidad</p></div>
                        <div class="column"><p class="t-titulos has-background-dark has-text-white">Subfamilia</p></div>
                        <div class="column"><p class="t-titulos has-background-dark has-text-white">Activo/No Activo</p></div>
                    </div>
                </div>
            </div>

            <?php
            $query = "SELECT * FROM t_activos";
            try {
                $resp = $conn->obtDatos($query);
                $totalRegistros = $conn->filasConsultadas;
                $porPagina = 50;
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

            $query = "SELECT * FROM t_activos "
                    . "LIMIT $desde, $porPagina";
            try {
                $resp = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($resp as $dts) {
                        $id = $dts['id'];
                        $naturaleza = $dts['naturaleza'];
                        $subfamilia2Bend = $dts['subfamilia2bend'];
                        $cod2bend = $dts['material_cod2bend'];
                        $texto = $dts['texto_breve'];
                        $unidad = $dts['unidad'];
                        $subfamilia = $dts['subfamilia'];
                        $activo = $dts['activo'];


                        echo "<div class=\"columns is-gapless my-1 is-mobile\">"
                        . "<div class=\"column\">"
                        . "<div class=\"columns is-gapless\">"
                        . "<div class=\"column\"><p class=\"t-normal\">$naturaleza</p></div>"
                        . "<div class=\"column\"><p class=\"t-normal\">$subfamilia2Bend</p></div>"
                        . "<div class=\"column\"><p class=\"t-normal\">$cod2bend</p></div>"
                        . "<div class=\"column\"><p class=\"t-normal text-truncate\">$texto</p></div>"
                        . "<div class=\"column\"><p class=\"t-normal\">$unidad</p></div>"
                        . "<div class=\"column\"><p class=\"t-normal\">$subfamilia</p></div>";
                        if ($activo == "ACTIVO") {
                            echo "<div class=\"column\"><p class=\"t-solucionado\"><span></span>$activo</p></div>";
                        } else {
                            echo "<div class=\"column\"><p class=\"t-proceso\"><span></span>$activo</p></div>";
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
            
            <div class="columns is-centered">
                <div class="column is-8">
                    <nav class="pagination is-centered" role="navigation" aria-label="pagination">
                        <?php
                        if ($pagina != 1) {
                            ?>
                        <a class="pagination-previous" onclick="obtActivoXPagina(1);" href="#">Inicio</a>
                            <a class="pagination-previous" onclick="obtActivoXPagina(<?php echo $pagina - 1; ?>);" href="#">Anterior</a>
                            <?php
                        } else {
                            ?>
                            <a class="pagination-previous" href="#" disabled>Inicio</a>
                            <a class="pagination-previous" href="#" disabled>Anterior</a>
                            <?php
                        }
                        if ($pagina != $totalPaginas) {
                            ?>
                            <a class="pagination-next" onclick="obtActivoXPagina(<?php echo $pagina + 1; ?>);" href="#">Siguiente</a>
                            <a class="pagination-next" onclick="obtActivoXPagina(<?php echo $totalPaginas; ?>);" href="#">Fin</a>
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
                                            echo "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina(" . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                                            echo "<li class=\"pagination-link is-current\">$i</li>";
                                        } else {
                                            echo "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina(1);\" href=\"#\">1</a></li>";
                                            echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                            echo "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina(" . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                                            echo "<li class=\"pagination-link is-current\">$i</li>";
                                        }

                                        if ($pagina == $totalPaginas) {
                                            
                                        } else {
                                            echo "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina(" . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                                            echo "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                                            echo "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina($totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
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
        <script src="js/bulmajs.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/activosJS.js"></script>

</html>
