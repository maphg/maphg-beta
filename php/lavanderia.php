<?php
session_start();
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'en_US');
include 'conexion.php';
include_once 'layout.php';
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
                // $zhh = $dts['ZHH'];
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

        <?php echo $layout->styles(); ?>
        <link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
        <link href="datedropper/datedropper.css" rel="stylesheet">
        <link href="timedropper/timedropper.css" rel="stylesheet">
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
            <?php
            echo $layout->menu($destino);
            ?>

            <!-- Page Content  -->
            <div id="content" class="active">
                <!--navbar top-->
                <nav class="navbar fixed-top navbar-expand-lg navbar-light my-bg-light" style="height: 40px; position: absolute;">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="navbar-btn active">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

                        <div class="dropdown">
                            <span class="navbar-brand" href="#" style="font-size:15px; cursor: pointer;" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                if ($foto != ""):
                                    ?>
                                    <img class="rounded-circle" src="img/users/<?php echo $foto; ?>" alt="" width="24" height="24" data-toggle="tooltip" title="<?php echo $nombre . " " . $apellido; ?>">
                                    <?php
                                else:
                                    ?>
                                    <img class="rounded-circle" src="https://ui-avatars.com/api/?uppercase=false&name=<?php echo $nombre . "+" . $apellido; ?>&background=d8e6ff&rounded=true&color=4886ff&size=100%" alt="" width="24" height="24" data-toggle="tooltip" title="<?php echo $nombre . " " . $apellido; ?>">
                                <?php
                                endif;
                                ?>
<!--<img class="rounded-circle" src="../img/users/<?php echo $foto; ?>" alt="" width="24" height="24" data-toggle="tooltip" title="<?php echo $nombre . " " . $apellido; ?>">-->
                            </span>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="margin-right: 10;">
                                <a class="dropdown-item" href="perfil.php"><i class="ti-user"></i> <span class="small">Perfil</span></a>
                                <a class="dropdown-item" href="configuraciones.php"><i class="ti-settings"></i> <span class="small">Configuracion</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#mLogout"><i class="ti-power-off"></i> <span class="small">Cerrar sesión</span></a>
                            </div>
                        </div>

                    </div>

                </nav>

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

            <div class="modal fade" id="mLogout" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mLogout" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">¿Cerrar sesión?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="msg" class="modal-body">
                            ¿Desea cerrar su sesión?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="logout();">Cerrar sesión</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        <?php echo $layout->scripts(); ?>

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
