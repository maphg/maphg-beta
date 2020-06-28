<?php
session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');
include 'php/conexion.php';
$conn = new Conexion();
$conn->conectar();


if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
} else {
    //Variables Generales.
    $nombreUsuario = "No Identificado.";
    $avatar = "??";
    $cargo = " - - ";
    $conn->conectar();
    $idUsuario = $_SESSION['usuario'];
    //Obtener datos del usuario
    $query = "SELECT * FROM t_users WHERE id = $idUsuario";
    try {
        $zhh = "";
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
                        $nombreUsuario = $nombre . " " . $apellido;
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
            $destinoT = $dts['destino'];
            $ubicacion = $dts['ubicacion'];
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
    <meta charset="UTF-8">
    <title>MAPHG</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.csws" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/bulma.min.css">
    <link rel="icon" href="svg/logo6.png">



    <style>
    .shadow-navbar {
        -webkit-box-shadow: 0px 4px 22px -22px rgba(0, 0, 0, 0.98);
        -moz-box-shadow: 0px 4px 22px -22px rgba(0, 0, 0, 0.98);
        box-shadow: 0px 4px 22px -22px rgba(0, 0, 0, 0.98);
    }

    .my-iframe {
        height: 700px !important;
    }

    .my-iframe-all {
        height: 300px !important;
    }
    </style>
</head>

<body>

    <?php include 'navbartop.php' ?>
    <?php include 'menu-sidebar.php' ?>
    <br>
    <div class="wrapper">
        <div id="content" class="container">
            <!--MENU-->
            <section class="mt-2">
                <div class="columns">
                    <div class="column">
                        <?php
                        switch ($destinoT):
                            case 'AME':
                        ?>
                        <div class="columns is-multiline">
                            <div class="column is-4">
                                <iframe class="my-iframe-all" width="90%" height="700"
                                    src="https://app.powerbi.com/view?r=eyJrIjoiMTViYjllNTUtZDRhZC00ZWUwLTg3ZDUtM2M5MjMxMGM0ZDBkIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                                    frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                            <div class="column is-4">
                                <iframe class="my-iframe-all" width="90%" height="700"
                                    src="https://app.powerbi.com/view?r=eyJrIjoiMjgwNTYyNWItYWIzZi00OTFlLTg5ZTQtNzY1Y2RhY2JiN2U5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                                    frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                            <div class="column is-4">
                                <iframe class="my-iframe-all" width="90%" height="700"
                                    src="https://app.powerbi.com/view?r=eyJrIjoiZWU4YjcxMTktZGE5NS00ODU0LTkxYmUtMTUyMTlkYzIwYjZkIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                                    frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                            <div class="column is-4">
                                <iframe class="my-iframe-all" width="90%" height="700"
                                    src="https://app.powerbi.com/view?r=eyJrIjoiZDYyMDBhZTUtZjhjYS00MTM4LWJhODktOTBhNmY5ZjdjNzM1IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                                    frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                            <div class="column is-4">
                                <iframe class="my-iframe-all" width="90%" height="700"
                                    src="https://app.powerbi.com/view?r=eyJrIjoiMjM1ZGQ5ZWItMmQ2Yy00OTAzLTkyMGMtZWUzYWI0YzllYzQwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                                    frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                            <div class="column is-4">
                                <iframe class="my-iframe-all" width="90%" height="700"
                                    src="https://app.powerbi.com/view?r=eyJrIjoiM2RmY2ZhOGYtYmRkZi00YjQ5LTk1ODQtZDBkMTU4ZjUwNmIyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                                    frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                            <div class="column is-4">
                                <iframe class="my-iframe-all" width="90%" height="700"
                                    src="https://app.powerbi.com/view?r=eyJrIjoiY2VkYmVmYmUtNDJmNC00MGZmLTg2NGUtNzQ0NjEyNmU1MzE3IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                                    frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                            <div class="column is-4">
                                <iframe class="my-iframe-all" width="90%" height="700"
                                    src="https://app.powerbi.com/view?r=eyJrIjoiN2UzODRmZTgtNWQ3MS00OTMwLThhYWQtZTJlMjAzZmZkY2ZhIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                                    frameborder="0" allowFullScreen="true"></iframe>
                            </div>
                        </div>
                        <?php
                                break;
                            case 'CAP':
                            ?>
                        <iframe class="my-iframe" width="100%" height="700"
                            src="https://app.powerbi.com/view?r=eyJrIjoiMTViYjllNTUtZDRhZC00ZWUwLTg3ZDUtM2M5MjMxMGM0ZDBkIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                            frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                            case 'RM':
                            ?>
                        <iframe class="my-iframe" width="100%" height="700"
                            src="https://app.powerbi.com/view?r=eyJrIjoiMjgwNTYyNWItYWIzZi00OTFlLTg5ZTQtNzY1Y2RhY2JiN2U5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                            frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                            case 'CMU':
                            ?>
                        <iframe class="my-iframe" width="100%" height="700"
                            src="https://app.powerbi.com/view?r=eyJrIjoiZWU4YjcxMTktZGE5NS00ODU0LTkxYmUtMTUyMTlkYzIwYjZkIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                            frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                            case 'PVR':
                            ?>
                        <iframe class="my-iframe" width="100%" height="700"
                            src="https://app.powerbi.com/view?r=eyJrIjoiZDYyMDBhZTUtZjhjYS00MTM4LWJhODktOTBhNmY5ZjdjNzM1IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                            frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                            case 'MBJ':
                            ?>
                        <iframe class="my-iframe" width="100%" height="700"
                            src="https://app.powerbi.com/view?r=eyJrIjoiMjM1ZGQ5ZWItMmQ2Yy00OTAzLTkyMGMtZWUzYWI0YzllYzQwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                            frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                            case 'PUJ':
                            ?>
                        <iframe class="my-iframe" width="100%" height="700"
                            src="https://app.powerbi.com/view?r=eyJrIjoiM2RmY2ZhOGYtYmRkZi00YjQ5LTk1ODQtZDBkMTU4ZjUwNmIyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                            frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                            case 'SSA':
                            ?>
                        <iframe class="my-iframe" width="100%" height="700"
                            src="https://app.powerbi.com/view?r=eyJrIjoiY2VkYmVmYmUtNDJmNC00MGZmLTg2NGUtNzQ0NjEyNmU1MzE3IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                            frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                            case 'SDQ':
                            ?>
                        <iframe class="my-iframe" width="100%" height="700"
                            src="https://app.powerbi.com/view?r=eyJrIjoiN2UzODRmZTgtNWQ3MS00OTMwLThhYWQtZTJlMjAzZmZkY2ZhIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9"
                            frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                        endswitch;
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script defer="" src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
<script src="js/plannerJS.js"></script>
<script src="js/usuariosJS.js"></script>
<script>
$(document).ready(function() {
    var pageloader = document.getElementById("loader");
    if (pageloader) {

        var pageloaderTimeout = setTimeout(function() {
            pageloader.classList.toggle('is-active');
            clearTimeout(pageloaderTimeout);
        }, 3000);
    }

    $(window).scroll(function() {
        var position = $(this).scrollTop();
        if (position >= 200) {
            $('#btnAncla').fadeIn('slow');
        } else {
            $('#btnAncla').fadeOut('slow');
        }
    });
    $(function() {
        $("#btnAncla").on('click', function() {
            $("html, body").animate({
                scrollTop: 0
            }, 1000);
            return false;
        });
    });
});
</script>

</html>