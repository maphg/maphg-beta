<?php
session_start();
include_once '../php/template.php';
include 'php/conexion.php';
date_default_timezone_set('America/Mexico_City');
$layout = new Template();
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
                $oma = $dts['OMA'];

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
                            if ($dts['foto'] != "") {
                                $foto = $dts['foto'];
                            } else {
                                $foto = "";
                            }
                            $idSeccion = $dts['id_seccion'];
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
            $destino = $dts['destino'];
            $bandera = $dts['bandera'];
        }
    }
} catch (Exception $ex) {
    echo $ex;
}

$query = "SELECT * FROM t_eventos WHERE id_usuario = $idUsuario";
try {
    $eventos = $conn->obtDatos($query);
} catch (Exception $ex) {
    echo $ex;
}
//Log de accesos
$fechaAcceso = date('Y-m-d H:i:s');
$query = "INSERT INTO t_accesos(id_usuario, pagina, fecha) VALUES($idUsuario, 'LAVANDERIA', '$fechaAcceso')";
try {
    $resp = $conn->consulta($query);
} catch (Exception $ex) {
    echo $ex;
}
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">

        <title>MAPHG</title>

        <link href='../fullcalendar/fullcalendar.css' rel='stylesheet' />
        <link href="../datedropper/datedropper.css" rel="stylesheet">
        <link href="../timedropper/timedropper.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

        <style>
            #calendar {
                max-width: 900px;
                margin: 0 auto;
            }
        </style>
    </head>

    <body>
        <div class="loader"></div>
        <div class="wrapper">
            <!-- Sidebar  -->

            <!-- Page Content  -->
            <div id="content" class="active">
                <!--navbar top-->

                <div class="mt-4 container-fluid">
                    <div class="row mb-3">
                        <div class="col-4 col-md-1">
                            <a href="#">
                                <?php
                                if ($foto != ""):
                                    ?>
                                    <img class="rounded-circle" src="img/users/<?php echo $foto; ?>" alt="" width="80" height="80" data-toggle="tooltip" title="<?php echo $nombre . " " . $apellido; ?>">
                                    <?php
                                else:
                                    ?>
                                    <img class="rounded-circle" src="https://ui-avatars.com/api/?uppercase=false&name=<?php echo $nombre . "+" . $apellido; ?>&background=d8e6ff&rounded=true&color=4886ff&size=100%" alt="" data-toggle="tooltip" title="<?php echo $nombre . " " . $apellido; ?>">
                                <?php
                                endif;
                                ?>
                <!--<img class="img-fluid rounded-circle" width="80" height="80" src="img/users/<?php echo $foto; ?>" alt="">-->
                <!--<img src="svg/user.svg" alt="">-->
                            </a>
                        </div>
                        <div class="col-8 col-md-2">
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0">Bienvenido</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h6><?php echo $nombre . " " . $apellido; ?></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-1">
                                            <img src="svg/banderas/<?php echo $bandera; ?>" width="15">
                                        </div>
                                        <div class="col-9">
                                            <select id="cbDestinos" class="form-control form-control-sm input-texto" onchange="cargarTareasDestino();">
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
                                        </div>

                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="container-fluid bg-white mt-3 rounded py-2">

                    <div class="row justify-content-center">
                        <div class="col-12 text-center">
                            <?php
                            switch ($destino):
                                case 'AME':
                                    ?>
                                    <div class="row">
                                        <div class="col-4">
                                            <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMzgzM2YzYWYtMGY4NC00MTIzLThjNmQtN2ZhN2YxMDE0MmI1IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                        </div>
                                        <div class="col-4">
                                            <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiM2QwY2QxNmQtNDI1Ny00ZTc0LTlhYTYtYTkxNTI3ZWJhYjYyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                        </div>
                                        <div class="col-4">
                                            <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNDlhODU1ODktMTE1Mi00YWZmLWIxMDItM2EzNmY3YzE3OWE2IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                        </div>
                                        <div class="col-4">
                                            <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiZjNkN2Y2M2QtNjNhMC00ZWU0LTljMmUtMTA5MzE1MTMwOWY5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                        </div>
                                        <div class="col-4">
                                            <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNDhjYzE0MmEtMDViNi00YzVjLWE3MWQtYTM5ZDhkOGMxNjExIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                        </div>
                                        <div class="col-4">
                                          <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMzdhYjBmZjUtMDAzNi00ZWVkLWI3MjYtNGU2MGE1ODZiODk5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                        </div>
                                        <div class="col-4">
                                            <!-- <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=" frameborder="0" allowFullScreen="true"></iframe> -->
                                        </div>
                                        <div class="col-4">
                                            <!-- <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=" frameborder="0" allowFullScreen="true"></iframe> -->
                                        </div>                                        
                                    </div>
                                    <?php
                                    break;
                                case 'CAP':
                                    ?>                                    
                                    <iframe width="100%" height="700" src="" frameborder="0" allowFullScreen="true"></iframe>
                                    <?php
                                    break;
                                case 'RM':
                                    ?>
                                    <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiM2QwY2QxNmQtNDI1Ny00ZTc0LTlhYTYtYTkxNTI3ZWJhYjYyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    <?php
                                    break;
                                case 'CMU':
                                    ?>
                                    <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMzgzM2YzYWYtMGY4NC00MTIzLThjNmQtN2ZhN2YxMDE0MmI1IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    <?php
                                    break;
                                case 'PVR':
                                    ?>
                                    <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNDhjYzE0MmEtMDViNi00YzVjLWE3MWQtYTM5ZDhkOGMxNjExIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    <?php
                                    break;
                                case 'MBJ':
                                    ?>
                                    <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiZjNkN2Y2M2QtNjNhMC00ZWU0LTljMmUtMTA5MzE1MTMwOWY5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    <?php
                                    break;
                                case 'PUJ':
                                    ?>
                                    <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMzdhYjBmZjUtMDAzNi00ZWVkLWI3MjYtNGU2MGE1ODZiODk5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    <?php
                                    break;
                                case 'SSA':
                                    ?>
                                    <iframe width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNDlhODU1ODktMTE1Mi00YWZmLWIxMDItM2EzNmY3YzE3OWE2IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    <?php
                                    break;
                                case 'SDQ':
                                    ?>
                                    <iframe width="100%" height="700" src="" frameborder="0" allowFullScreen="true"></iframe>
                                    <?php
                                    break;
                            endswitch;
                            ?>
                        </div>
                    </div>

                </div>
                <!--content-->
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


        <script type="text/javascript">
                                $(document).ready(function () {

                                    setInterval(function () {
                                        $.ajax({
                                            type: 'post',
                                            url: 'php/verificarSesionActiva.php',
                                            data: 'action=1',
                                            success: function (data) {
                                            }
                                        });
                                    }, 5000);

                                    setTimeout(function () {
                                        $(".loader").fadeOut('slow');
                                    }, 100);

                                    $('#sidebarCollapse').on('click', function () {
                                        //$('#sidebar').toggleClass('active');
                                        $(this).toggleClass('active');
                                    });
                                    $("#sidebar").mCustomScrollbar({
                                        theme: "minimal"
                                    });

                                    $('#sidebarCollapse').on('click', function () {
                                        $('#sidebar, #content').toggleClass('active');
                                        $('.collapse.in').toggleClass('in');
                                        $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                                    });
                                });
        </script>
    </body>

</html>
