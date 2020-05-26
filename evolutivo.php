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
                $dec = $dts['DECC'];
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
//                $seg = $dts['SEG'];

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

                $query = "SELECT * FROM c_cargos WHERE id = $idCargo";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $cargo = $dts['cargo'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

                $query = "SELECT * FROM c_secciones WHERE id = $idSeccion";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $seccion = $dts['seccion'];
                            $imgSeccion = $dts['url_image'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

                $query = "SELECT * FROM c_destinos WHERE id = $idDestino";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $destino = $dts['destino'];
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
        <div id="loader" class="pageloader is-active"><span class="title">Cargando...</span></div>
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
                    <?php //echo $layout->menu(); ?>
                </nav>

                <!--HERO BAR-->
                <section class="mt-5">
                    <br>
                </section>
                <!--SECCION DE SELECTS-->
                <section class="mt-2">
                    <div class="columns px-3">
                        <div class="column">
                            <div class="tabs is-centered is-boxed">
                                <ul>
                                    <li id="tab-aa" class="is-active">
                                        <a onclick="activeTabEvolutivo('aa');">
                                            <span>Evolutivo Quejas A/A</span>
                                        </a>
                                    </li>
                                    <li id="tab-acs">
                                        <a onclick="activeTabEvolutivo('acs');">
                                            <span>Evolutivo Quejas ACS</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div id="aa" class="column tab-pane fade bg-light">
                            <canvas id="chart" width="100" height="30"></canvas>
                        </div>
                        <div id="acs" class="column tab-pane fade bg-light" style="display:none;">
                            <canvas id="chart2" width="100" height="30"></canvas>
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
    <script src="js/usuariosJS.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
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

<?php
$query = "SELECT * FROM t_evolutivo_ac";
try {
    $evolutivoac = $conn->obtDatos($query);
} catch (Exception $ex) {
    echo $ex;
}

$query = "SELECT * FROM t_evolutivo_acs";
try {
    $evolutivoacs = $conn->obtDatos($query);
} catch (Exception $ex) {
    echo $ex;
}
?>
    <script>
        var ctx = document.getElementById("chart");
        var myChart = new Chart(ctx, {
        type: 'line',
                data: {
                labels: [
<?php
foreach ($evolutivoac as $dts) {
    ?>
                    "<?php echo $dts['mes'] ?>",
    <?php
}
?>
                ],
                        datasets: [
                        {
                        label: 'CMU',
                                data: [
<?php
foreach ($evolutivoac as $cmu) {
    $dato = $cmu['cmu'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(0, 209, 178, 0)',
                                borderColor: 'rgba(0, 209, 178,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'CUN',
                                data: [
<?php
foreach ($evolutivoac as $cun) {
    $dato = $cun['cun'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(50, 115, 220, 0)',
                                borderColor: 'rgba(50, 115, 220,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'MBJ',
                                data: [
<?php
foreach ($evolutivoac as $mbj) {
    $dato = $mbj['mbj'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(32, 156, 238, 0)',
                                borderColor: 'rgba(32, 156, 238,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'PUJ',
                                data: [
<?php
foreach ($evolutivoac as $puj) {
    $dato = $puj['puj'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(5, 209, 96, 0)',
                                borderColor: 'rgba(5, 209, 96,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'PVR',
                                data: [
<?php
foreach ($evolutivoac as $pvr) {
    $dato = $pvr['pvr'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(255, 84, 5, 0)',
                                borderColor: 'rgba(255, 84, 5,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'SDQ',
                                data: [
<?php
foreach ($evolutivoac as $sdq) {
    $dato = $sdq['sdq'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(255, 56, 96, 0)',
                                borderColor: 'rgba(255, 56, 96,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'SSA',
                                data: [
<?php
foreach ($evolutivoac as $ssa) {
    $dato = $ssa['ssa'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(34 ,56, 189, 0)',
                                borderColor: 'rgba(34 ,56, 189,1)',
                                borderWidth: 1
                        }
                        ]
                },
                options: {
                scales: {
                yAxes: [{
                ticks: {
                beginAtZero: true
                }
                }]
                }
                }
        });
    </script>

    <script>
        var ctx = document.getElementById("chart2");
        var myChart = new Chart(ctx, {
        type: 'line',
                data: {
                labels: [
<?php
foreach ($evolutivoacs as $dts) {
    ?>
                    "<?php echo $dts['mes'] ?>",
    <?php
}
?>
                ],
                        datasets: [
                        {
                        label: 'CMU',
                                data: [
<?php
foreach ($evolutivoacs as $cmu) {
    $dato = $cmu['cmu'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(0, 209, 178, 0)',
                                borderColor: 'rgba(0, 209, 178,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'CUN',
                                data: [
<?php
foreach ($evolutivoacs as $cun) {
    $dato = $cun['cun'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(50, 115, 220, 0)',
                                borderColor: 'rgba(50, 115, 220,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'MBJ',
                                data: [
<?php
foreach ($evolutivoacs as $mbj) {
    $dato = $mbj['mbj'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(32, 156, 238, 0)',
                                borderColor: 'rgba(32, 156, 238,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'PUJ',
                                data: [
<?php
foreach ($evolutivoacs as $puj) {
    $dato = $puj['puj'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(5, 209, 96, 0)',
                                borderColor: 'rgba(5, 209, 96,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'PVR',
                                data: [
<?php
foreach ($evolutivoacs as $pvr) {
    $dato = $pvr['pvr'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(255, 84, 5, 0)',
                                borderColor: 'rgba(255, 84, 5,1)',
                                borderWidth: 1
                        }, {
                        label: 'SDQ',
                                data: [
<?php
foreach ($evolutivoacs as $sdq) {
    $dato = $sdq['sdq'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(255, 56, 96, 0)',
                                borderColor: 'rgba(255, 56, 96,1)',
                                borderWidth: 1
                        },
                        {
                        label: 'SSA',
                                data: [
<?php
foreach ($evolutivoacs as $ssa) {
    $dato = $ssa['ssa'];
    echo "$dato,";
}
?>
                                ],
                                backgroundColor: 'rgba(34 ,56, 189, 0)',
                                borderColor: 'rgba(34 ,56, 189,1)',
                                borderWidth: 1
                        }
                        ]
                },
                options: {
                scales: {
                yAxes: [{
                ticks: {
                beginAtZero: true
                }
                }]
                }
                }
        });
    </script>
</html>
