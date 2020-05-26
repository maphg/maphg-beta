<?php
session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, "es_ES.UTF-8");
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
                $dep = $dts['DEP'];
                $auto = $dts['AUTO'];
                $zha = $dts['ZHA'];
                $zhc = $dts['ZHC'];
                $zhp = $dts['ZHP'];
                $seg = $dts['SEG'];

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
            $destinoT = $dts['destino'];
            $gp = $dts['gp'];
            $trs = $dts['trs'];
        }
    }
} catch (Exception $ex) {
    echo $ex;
}

//Log de accesos
$fechaAcceso = date('Y-m-d H:i:s');
$query = "INSERT INTO t_accesos(id_usuario, pagina, fecha) VALUES($idUsuario, 'CUADRO DE MANDO', '$fechaAcceso')";
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
        <link href="../datedropper/datedropper.css" rel="stylesheet">
        <link href="../timedropper/timedropper.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    </head>

    <body class="bg-body autoscroll">
        <div class="loader"></div>
        <div class="wrapper">

            <!-- Sidebar  -->
            <?php
            echo $layout->menu($destinoT);
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

                <?php
                if ($idDestinoT == 10) {
                    $idDestinoT = 1;
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
                }
                ?>

                <div class="container-fluid mt-3">
                    <div class="row justify-content-center">
                        <div class="col-6 text-center">
                            <div class="row justify-content-center">
                                <div class="col-1">
                                    <img src="svg/banderas/<?php echo $bandera; ?>" width="20">
                                </div>
                                <!--COMBO SELECT PARA ELEGIR DESTINO-->
                                <div class="col-8 col-md-4">
                                    <select id="cbDestinos" class="form-control form-control-sm bg-white border-0 rounded-0 shadow-sm" onchange="cargarTareasDestino();">
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

                    
                    <div class="row my-4">
                        <div class="col-12 text-center">
                            <p class="mn-bold texto-pavo fs-40">CUADRO DE MANDOS <span class="texto-gris fs-25"><?php echo $destinoT; ?></span> <span class="texto-gris fs-25"><?php echo strtoupper(strftime("%B", strtotime(date("F", strtotime("- 1 month"))))); ?></span></p>
                        </div>
                    </div>

                </div>

                <div class="container-fluid scroll-horizontal">

                    <!--ZONA DE ENERGETICOS-->
                    <div class="row">
                        <h1 class="mn-bold texto-negro fs-28 ml-4 mt-4">Energéticos</h1>
                    </div>

                    <div class="row mt-4 flex-nowrap pb-2 justify-content-center">

                        <?php
                        $año = date("Y");
                        $currentMonth = date('n');
                        if($currentMonth == 1){
                            $año = $año-1;
                        }
                        $month = date("F", strtotime("- 1 month"));
                        switch ($month) {
                            case 'January':
                                $mes = "ENERO";
                                break;
                            case 'February':
                                $mes = "FEBRERO";
                                break;
                            case 'March':
                                $mes = "MARZO";
                                break;
                            case 'April':
                                $mes = "ABRIL";
                                break;
                            case 'May':
                                $mes = "MAYO";
                                break;
                            case 'June':
                                $mes = "JUNIO";
                                break;
                            case 'July':
                                $mes = "JULIO";
                                break;
                            case 'August':
                                $mes = "AGOSTO";
                                break;
                            case 'September':
                                $mes = "SEPTIEMBRE";
                                break;
                            case 'October':
                                $mes = "OCTUBRE";
                                break;
                            case 'November':
                                $mes = "NOVIEMBRE";
                                break;
                            case 'December':
                                $mes = "DICIEMBRE";
                                break;
                        }

//Obtener informacion del informe 


                        $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = $idDestinoT AND mes = '$mes' AND year = $año";
                        try {
                            $result = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($result as $dts) {
                                    $agua = $dts['agua'];
                                    $ratioAgua = $dts['ratio_agua'];
                                    $electricidad = $dts['electricidad'];
                                    $ratioElectricidad = $dts['ratio_electricidad'];
                                    $diesel = $dts['diesel'];
                                    $ratioDiesel = $dts['ratio_diesel'];
                                    $gas = $dts['gas'];
                                    $ratioGas = $dts['ratio_gas'];
                                }
                            } else {
                                $agua = "";
                                $ratioAgua = "";
                                $electricidad = "";
                                $ratioElectricidad = "";
                                $diesel = "";
                                $ratioDiesel = "";
                                $gas = "";
                                $ratioGas = "";
                            }
                        } catch (Exception $ex) {
                            echo $ex;
                        }
                        ?>

                        <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg mx-2" data-toggle="collapse" href="#collapseagua" role="button" aria-expanded="false" aria-controls="collapseagua">
                            <div class="row">
                                <div class="col-12 card-header border-0 bg-white mb-2 text-center">
                                    <h4 class="my-0 mn-bold texto-negro">AGUA</h4>
                                    <img class="mt-2" src="svg/agua.svg" height="50px" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($agua, 2); ?> / <span class="texto-gris"><?php echo round($ratioAgua, 2); ?></span></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MES ACTUAL / RATIO IDEAL</p>
                                    <?php
                                    if ($ratioAgua > 0) {
                                        $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                        if ($difAgua > 0) {
                                            $svg = "subio.svg";
                                        } else if ($difAgua < 0) {
                                            $svg = "bajo.svg";
                                        } else {
                                            $svg = "";
                                        }
                                    } else {
                                        $difAgua = 0;
                                        $svg = "";
                                    }
                                    ?>
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/<?php echo $svg; ?>" height="40px" alt=""></span> <?php echo round($difAgua) . "%"; ?></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">DIFERENCIA</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg mx-2" data-toggle="collapse" href="#collapseelectricidad" role="button" aria-expanded="false" aria-controls="collapseelectricidad">
                            <div class="row">
                                <div class="col-12 card-header border-0 bg-white mb-2 text-center">
                                    <h4 class="my-0 mn-bold texto-negro">ELECTRICIDAD</h4>
                                    <img class="mt-2" src="svg/electricidad.svg" height="50px" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($electricidad, 2); ?> / <span class="texto-gris"><?php echo round($ratioElectricidad, 2); ?></span></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MES ACTUAL / RATIO IDEAL</p>
                                    <?php
                                    if ($ratioElectricidad > 0) {
                                        $difElec = (($electricidad / $ratioElectricidad) - 1) * 100;
                                        if ($difElec > 0) {
                                            $svg = "subio.svg";
                                        } else if ($difElec < 0) {
                                            $svg = "bajo.svg";
                                        } else {
                                            $svg = "";
                                        }
                                    } else {
                                        $difElec = 0;
                                        $svg = "";
                                    }
                                    ?>
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/<?php echo $svg; ?>" height="40px" alt=""></span> <?php echo round($difElec) . "%"; ?></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">DIFERENCIA</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg mx-2" data-toggle="collapse" href="#collapsegas" role="button" aria-expanded="false" aria-controls="collapsegas">
                            <div class="row">
                                <div class="col-12 card-header border-0 bg-white mb-2 text-center">
                                    <h4 class="my-0 mn-bold texto-negro">GAS</h4>
                                    <img class="mt-2" src="svg/gas.svg" height="50px" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($gas, 2); ?> / <span class="texto-gris"><?php echo round($ratioGas, 2); ?></span></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MES ACTUAL / RATIO IDEAL</p>
                                    <?php
                                    if ($ratioGas > 0) {
                                        $difGas = (($gas / $ratioGas) - 1) * 100;
                                        if ($difGas > 0) {
                                            $svg = "subio.svg";
                                        } else if ($difGas < 0) {
                                            $svg = "bajo.svg";
                                        } else {
                                            $svg = "";
                                        }
                                    } else {
                                        $difGas = 0;
                                        $svg = "";
                                    }
                                    ?>
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/<?php echo $svg; ?>" height="40px" alt=""></span><?php echo round($difGas) . "%"; ?></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">DIFERENCIA</p>
                                </div>
                            </div>
                        </div>


                        <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg mx-2" data-toggle="collapse" href="#collapsediesel" role="button" aria-expanded="false" aria-controls="collapsediesel">
                            <div class="row">
                                <div class="col-12 card-header border-0 bg-white mb-2 text-center">
                                    <h4 class="my-0 mn-bold texto-negro">DIESEL</h4>
                                    <img class="mt-2" src="svg/diesel.svg" height="50px" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($diesel, 2); ?> / <span class="texto-gris"><?php echo round($ratioDiesel, 2); ?></span></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MES ACTUAL / RATIO IDEAL</p>
                                    <?php
                                    if ($ratioDiesel > 0) {
                                        $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                        if ($difDiesel > 0) {
                                            $svg = "subio.svg";
                                        } else if ($difDiesel < 0) {
                                            $svg = "bajo.svg";
                                        } else {
                                            $svg = "";
                                        }
                                    } else {
                                        $difDiesel = 0;
                                        $svg = "";
                                    }
                                    ?>
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/<?php echo $svg; ?>" height="40px" alt=""></span> <?php echo round($difDiesel) . "%"; ?></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">DIFERENCIA</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- FILA OCULTA AL DARLE CLIC -->

                    <div class="accordion" id="energeticosAccordion">
                        <div class="container-fluid scroll-horizontal bg-dark rounded-lg collapse shadow-sm" id="collapseagua" data-parent="#energeticosAccordion">

                            <div class="row flex-nowrap bg-dark rounded-lg mt-3 mx-2">  
                                <?php
//Riviera maya
                                if ($idDestinoT == 1) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 1 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioAgua > 0) {
                                    $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                    if ($difAgua > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difAgua < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difAgua = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 1) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">RM</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($agua, 2) . " / <span>" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">RM</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($agua, 2) . " / <span class=\"texto-gris\">" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }

//Costa mujeres
                                if ($idDestinoT == 7) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 7 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 7 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioAgua > 0) {
                                    $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                    if ($difAgua > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difAgua < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difAgua = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 7) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($agua, 2) . " / <span>" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($agua, 2) . " / <span class=\"texto-gris\">" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }

//Riviera Nayarit
                                if ($idDestinoT == 2) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 2 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 2 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioAgua > 0) {
                                    $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                    if ($difAgua > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difAgua < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difAgua = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 2) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($agua, 2) . " / <span>" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-pvr.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($agua, 2) . " / <span class=\"texto-gris\">" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Jamaica
                                if ($idDestinoT == 6) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 6 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 6 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioAgua > 0) {
                                    $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                    if ($difAgua > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difAgua < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difAgua = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 6) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($agua, 2) . " / <span>" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-mbj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($agua, 2) . " / <span class=\"texto-gris\">" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Bavaro
                                if ($idDestinoT == 5) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 5 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 5 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioAgua > 0) {
                                    $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                    if ($difAgua > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difAgua < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difAgua = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 5) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($agua, 2) . " / <span>" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-puj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($agua, 2) . " / <span class=\"texto-gris\">" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Imbassai
                                if ($idDestinoT == 4) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 4 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 4 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioAgua > 0) {
                                    $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                    if ($difAgua > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difAgua < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difAgua = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 4) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($agua, 2) . " / <span>" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-ssa.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($agua, 2) . " / <span class=\"texto-gris\">" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Santo Domingo
                                if ($idDestinoT == 3) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 3 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 3 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioAgua > 0) {
                                    $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                    if ($difAgua > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difAgua < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difAgua = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 3) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($agua, 2) . " / <span>" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-sdq.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($agua, 2) . " / <span class=\"texto-gris\">" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Capcana

                                if ($idDestinoT == 11) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 11 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 11 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $agua = $dts['agua'];
                                                $ratioAgua = $dts['ratio_agua'];
                                            }
                                        } else {
                                            $agua = 0;
                                            $ratioAgua = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioAgua > 0) {
                                    $difAgua = (($agua / $ratioAgua) - 1) * 100;
                                    if ($difAgua > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difAgua < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difAgua = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 11) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($agua, 2) . " / <span>" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cap.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($agua, 2) . " / <span class=\"texto-gris\">" . round($ratioAgua, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difAgua) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
                                ?>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <h1 class="mn-bold text-white text-center fs-28 ml-4 mt-2">Evolutivo</h1>
                                </div>
                                <div class="col bg-white rounded-lg mx-4 my-4">
                                    <canvas id="chart1" height="40px"></canvas>
                                </div>

                            </div>


                        </div>

                        <div class="container-fluid scroll-horizontal bg-dark rounded-lg collapse shadow-sm" id="collapseelectricidad" data-parent="#energeticosAccordion">

                            <div class="row flex-nowrap bg-dark rounded-lg mt-3 mx-2">
                                <?php
//Riviera maya
                                if ($idDestinoT == 1) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 1 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioElectricidad > 0) {
                                    $difElectricidad = (($electricidad / $ratioElectricidad) - 1) * 100;
                                    if ($difElectricidad > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difElectricidad < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difElectricidad = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 1) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">RM</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span> " . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">RM</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span class=\"texto-gris\">" . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }

//Costa mujeres
                                if ($idDestinoT == 7) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 7 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 7 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioElectricidad > 0) {
                                    $difElectricidad = (($electricidad / $ratioElectricidad) - 1) * 100;
                                    if ($difElectricidad > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difElectricidad < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difElectricidad = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 7) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span> " . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span class=\"texto-gris\">" . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }

//Riviera Nayarit
                                if ($idDestinoT == 2) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 2 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 2 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioElectricidad > 0) {
                                    $difElectricidad = (($electricidad / $ratioElectricidad) - 1) * 100;
                                    if ($difElectricidad > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difElectricidad < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difElectricidad = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 2) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span> " . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-pvr.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span class=\"texto-gris\">" . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Jamaica
                                if ($idDestinoT == 6) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 6 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 6 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioElectricidad > 0) {
                                    $difElectricidad = (($electricidad / $ratioElectricidad) - 1) * 100;
                                    if ($difElectricidad > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difElectricidad < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difElectricidad = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 6) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span> " . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-mbj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span class=\"texto-gris\">" . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Bavaro
                                if ($idDestinoT == 5) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 5 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 5 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioElectricidad > 0) {
                                    $difElectricidad = (($electricidad / $ratioElectricidad) - 1) * 100;
                                    if ($difElectricidad > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difElectricidad < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difElectricidad = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 5) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span> " . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-puj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span class=\"texto-gris\">" . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Imbassai
                                if ($idDestinoT == 4) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 4 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 4 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioElectricidad > 0) {
                                    $difElectricidad = (($electricidad / $ratioElectricidad) - 1) * 100;
                                    if ($difElectricidad > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difElectricidad < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difElectricidad = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 4) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span> " . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-ssa.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span class=\"texto-gris\">" . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Santo Domingo
                                if ($idDestinoT == 3) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 3 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 3 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioElectricidad > 0) {
                                    $difElectricidad = (($electricidad / $ratioElectricidad) - 1) * 100;
                                    if ($difElectricidad > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difElectricidad < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difElectricidad = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 3) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span> " . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-sdq.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span class=\"texto-gris\">" . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Capcana

                                if ($idDestinoT == 11) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 11 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 11 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $electricidad = $dts['electricidad'];
                                                $ratioElectricidad = $dts['ratio_electricidad'];
                                            }
                                        } else {
                                            $electricidad = 0;
                                            $ratioElectricidad = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioElectricidad > 0) {
                                    $difElectricidad = (($electricidad / $ratioElectricidad) - 1) * 100;
                                    if ($difElectricidad > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difElectricidad < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difElectricidad = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 11) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span> " . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cap.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($electricidad, 2) . " / <span class=\"texto-gris\">" . round($ratioElectricidad, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difElectricidad) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
                                ?>

                            </div>


                            <div class="row mt-2">
                                <div class="col-12">
                                    <h1 class="mn-bold text-white text-center fs-28 ml-4 mt-2">Evolutivo</h1>
                                </div>
                                <div class="col bg-white rounded-lg mx-4 my-4">
                                    <canvas id="chart2" height="40px"></canvas>
                                </div>

                            </div>


                        </div>

                        <div class="container-fluid scroll-horizontal bg-dark rounded-lg collapse shadow-sm" id="collapsegas" data-parent="#energeticosAccordion">

                            <div class="row flex-nowrap bg-dark rounded-lg mt-3 mx-2">
                                <?php
//Riviera maya
                                if ($idDestinoT == 1) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 1 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioGas > 0) {
                                    $difGas = (($gas / $ratioGas) - 1) * 100;
                                    if ($difGas > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difGas < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difGas = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 1) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">RM</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($gas, 2) . " / <span> " . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">RM</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($gas, 2) . " / <span class=\"texto-gris\">" . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }

//Costa mujeres
                                if ($idDestinoT == 7) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 7 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 7 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioGas > 0) {
                                    $difGas = (($gas / $ratioGas) - 1) * 100;
                                    if ($difGas > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difGas < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difGas = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 7) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($gas, 2) . " / <span> " . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($gas, 2) . " / <span class=\"texto-gris\">" . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }

//Riviera Nayarit
                                if ($idDestinoT == 2) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 2 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 2 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioGas > 0) {
                                    $difGas = (($gas / $ratioGas) - 1) * 100;
                                    if ($difGas > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difGas < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difGas = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 2) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($gas, 2) . " / <span> " . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-pvr.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($gas, 2) . " / <span class=\"texto-gris\">" . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Jamaica
                                if ($idDestinoT == 6) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 6 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 6 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioGas > 0) {
                                    $difGas = (($gas / $ratioGas) - 1) * 100;
                                    if ($difGas > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difGas < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difGas = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 6) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($gas, 2) . " / <span> " . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-mbj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($gas, 2) . " / <span class=\"texto-gris\">" . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Bavaro
                                if ($idDestinoT == 5) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 5 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 5 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioGas > 0) {
                                    $difGas = (($gas / $ratioGas) - 1) * 100;
                                    if ($difGas > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difGas < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difGas = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 5) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($gas, 2) . " / <span> " . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-puj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($gas, 2) . " / <span class=\"texto-gris\">" . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Imbassai
                                if ($idDestinoT == 4) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 4 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 4 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioGas > 0) {
                                    $difGas = (($gas / $ratioGas) - 1) * 100;
                                    if ($difGas > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difGas < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difGas = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 4) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($gas, 2) . " / <span> " . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-ssa.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($gas, 2) . " / <span class=\"texto-gris\">" . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Santo Domingo
                                if ($idDestinoT == 3) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 3 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 3 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioGas > 0) {
                                    $difGas = (($gas / $ratioGas) - 1) * 100;
                                    if ($difGas > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difGas < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difGas = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 3) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($gas, 2) . " / <span> " . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-sdq.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($gas, 2) . " / <span class=\"texto-gris\">" . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Capcana

                                if ($idDestinoT == 11) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 11 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 11 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $gas = $dts['gas'];
                                                $ratioGas = $dts['ratio_gas'];
                                            }
                                        } else {
                                            $gas = 0;
                                            $ratioGas = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioGas > 0) {
                                    $difGas = (($gas / $ratioGas) - 1) * 100;
                                    if ($difGas > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difGas < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difGas = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 11) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($gas, 2) . " / <span> " . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cap.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($gas, 2) . " / <span class=\"texto-gris\">" . round($ratioGas, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difGas) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
                                ?>

                            </div>


                            <div class="row mt-2">
                                <div class="col-12">
                                    <h1 class="mn-bold text-white text-center fs-28 ml-4 mt-2">Evolutivo</h1>
                                </div>
                                <div class="col bg-white rounded-lg mx-4 my-4">
                                    <canvas id="chart3" height="40px"></canvas>
                                </div>

                            </div>


                        </div>

                        <div class="container-fluid scroll-horizontal bg-dark rounded-lg collapse shadow-sm" id="collapsediesel" data-parent="#energeticosAccordion">

                            <div class="row flex-nowrap bg-dark rounded-lg mt-3 mx-2">
                                <?php
//Riviera maya
                                if ($idDestinoT == 1) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 1 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioDiesel > 0) {
                                    $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                    if ($difDiesel > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difDiesel < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difDiesel = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 1) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">RM</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span> " . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">RM</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span class=\"texto-gris\">" . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }

//Costa mujeres
                                if ($idDestinoT == 7) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 7 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 7 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioDiesel > 0) {
                                    $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                    if ($difDiesel > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difDiesel < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difDiesel = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 7) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span> " . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span class=\"texto-gris\">" . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }

//Riviera Nayarit
                                if ($idDestinoT == 2) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 2 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 2 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioDiesel > 0) {
                                    $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                    if ($difDiesel > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difDiesel < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difDiesel = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 2) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span> " . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-pvr.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span class=\"texto-gris\">" . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Jamaica
                                if ($idDestinoT == 6) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 6 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 6 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioDiesel > 0) {
                                    $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                    if ($difDiesel > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difDiesel < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difDiesel = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 6) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span> " . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-mbj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span class=\"texto-gris\">" . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Bavaro
                                if ($idDestinoT == 5) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 5 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 5 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioDiesel > 0) {
                                    $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                    if ($difDiesel > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difDiesel < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difDiesel = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 5) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span> " . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-puj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span class=\"texto-gris\">" . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Imbassai
                                if ($idDestinoT == 4) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 4 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 4 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioDiesel > 0) {
                                    $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                    if ($difDiesel > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difDiesel < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difDiesel = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 4) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span> " . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-ssa.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span class=\"texto-gris\">" . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Santo Domingo
                                if ($idDestinoT == 3) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 3 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 3 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioDiesel > 0) {
                                    $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                    if ($difDiesel > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difDiesel < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difDiesel = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 3) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span> " . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-sdq.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span class=\"texto-gris\">" . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
//Capcana

                                if ($idDestinoT == 11) {
                                    $añoAnt = $año - 1;
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 11 AND mes = '$mes' AND year = $añoAnt";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                } else {
                                    $query = "SELECT * FROM t_informes_energeticos WHERE id_destino = 11 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $diesel = $dts['diesel'];
                                                $ratioDiesel = $dts['ratio_diesel'];
                                            }
                                        } else {
                                            $diesel = 0;
                                            $ratioDiesel = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }

                                if ($ratioDiesel > 0) {
                                    $difDiesel = (($diesel / $ratioDiesel) - 1) * 100;
                                    if ($difDiesel > 0) {
                                        $svg = "subio.svg";
                                    } else if ($difDiesel < 0) {
                                        $svg = "bajo.svg";
                                    } else {
                                        $svg = "";
                                    }
                                } else {
                                    $difDiesel = 0;
                                    $svg = "";
                                }

                                if ($idDestinoT == 11) {
                                    echo "<div class=\"col-2 shadow-sm bg-primary text-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 text-white mb-2 text-center\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\" text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span> " . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">AÑO PASADO / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                } else {
                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cap.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>
                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($diesel, 2) . " / <span class=\"texto-gris\">" . round($ratioDiesel, 2) . "</span></h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL / RATIO IDEAL</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/$svg\" height=\"40px\" alt=\"\"></span> " . round($difDiesel) . "%</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">DIFERENCIA</p>
                                        </div>
                                    </div>
                                </div>";
                                }
                                ?>

                            </div>


                            <div class="row mt-2">
                                <div class="col-12">
                                    <h1 class="mn-bold text-white text-center fs-28 ml-4 mt-2">Evolutivo</h1>
                                </div>
                                <div class="col bg-white rounded-lg mx-4 my-4">
                                    <canvas id="chart4" height="40px"></canvas>
                                </div>

                            </div>


                        </div>
                    </div>
                    <!-- FILA OCULTA AL DARLE CLIC -->

                    <hr class="my-4">

                    <!--ZONA DE GASTOS-->

                    <div class="row">
                        <h1 class="mn-bold texto-negro fs-28 ml-4 my-4">Gastos</h1>
                    </div>

                    <div class="row justify-content-center" data-toggle="collapse" href="#ocultogastos" role="button" aria-expanded="false" aria-controls="ocultogastos">

                        <?php
                        $query = "SELECT * FROM t_informes_gastos WHERE id_destino = $idDestinoT AND mes = '$mes' AND year = $año";
                        try {
                            $resp = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resp as $dts) {
                                    $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                    $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                    $anualGastado = $dts['anual_gastado'];

                                    $gastadoMPGP = $dts['mp_gp'];
                                    $gastadoMCGP = $dts['mc_gp'];
                                    $gastadoMPTRS = $dts['mp_trs'];
                                    $gastadoMCTRS = $dts['mc_trs'];
                                    $gastadoMPZI = $dts['mp_zi'];
                                    $gastadoMCZI = $dts['mc_zi'];

                                    $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                    $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                    $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                    $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                    $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                    $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                    $anualGastadoGP = $dts['anual_gastado_gp'];
                                    $anualGastadoTRS = $dts['anual_gastado_trs'];
                                    $anualGastadoZI = $dts['anual_gastado_zi'];
                                }
                            }
                        } catch (Exception $ex) {
                            echo $ex;
                        }
                        ?>
                        <div class="col-2 mx-3 rounded-lg mx-2 my-3">
                            <div class="row mt-4">
                                <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $destinoT; ?></h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTO ACOMULADO ESTE MES</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $gastoAcumuladoMPMes; ?>% / <?php echo $gastoAcumuladoMCMes; ?>%</h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MP / MC</p>
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $anualGastado; ?>%</h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($gp == "SI"):
                            ?>

                            <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header border-0 bg-white mb-2 text-center">
                                        <img class="mt-2" src="svg/gpl.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTADO ESTE MES</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $gastadoMPGP; ?>% / <?php echo $gastadoMCGP; ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PREVENTIVO / CORRECTIVO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $anualGastadoGP; ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>

                            <?php
                        endif;

                        if ($trs == "SI"):
                            ?>

                            <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header border-0 bg-white mb-2 text-center">
                                        <img class="mt-2" src="svg/trsl.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTADO ESTE MES</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $gastadoMPTRS; ?>% / <?php echo $gastadoMCTRS; ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PREVENTIVO / CORRECTIVO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $anualGastadoTRS; ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endif;
                        ?>
                        <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg mx-2 my-3">
                            <div class="row">
                                <div class="col-12 card-header border-0 bg-white mb-2 text-center">
                                    <img class="mt-2" src="svg/zill.svg" height="50px" alt="">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTADO ESTE MES</p>
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $gastadoMPZI; ?>% / <?php echo $gastadoMCZI; ?>%</h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PREVENTIVO / CORRECTIVO</p>
                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $anualGastadoZI; ?>%</h1>
                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid scroll-horizontal collapse" id="ocultogastos">

                        <div class="row bg-dark text-white  rounded-lg flex-nowrap">

                            <?php
                            if ($idDestinoT == 1) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_gastos WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                            $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                            $anualGastado = $dts['anual_gastado'];

                                            $gastadoMPGP = $dts['mp_gp'];
                                            $gastadoMCGP = $dts['mc_gp'];
                                            $gastadoMPTRS = $dts['mp_trs'];
                                            $gastadoMCTRS = $dts['mc_trs'];
                                            $gastadoMPZI = $dts['mp_zi'];
                                            $gastadoMCZI = $dts['mc_zi'];

                                            $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                            $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                            $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                            $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                            $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                            $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                            $anualGastadoGP = $dts['anual_gastado_gp'];
                                            $anualGastadoTRS = $dts['anual_gastado_trs'];
                                            $anualGastadoZI = $dts['anual_gastado_zi'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                echo "<div class=\"col-2 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row mt-4\">
                                    <div class=\"col-12 card-header border-0 mb-2 text-center bg-white\">
                                        <img class=\"mt-2\" src=\"svg/bandera-rm.svg\" height=\"50px\" alt=\"\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">RM</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">GASTO ACOMULADO ESTE MES</p>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$gastoAcumuladoMPMes% / $gastoAcumuladoMCMes%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MP / MC</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$anualGastado%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 2) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_gastos WHERE id_destino = 2 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                            $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                            $anualGastado = $dts['anual_gastado'];

                                            $gastadoMPGP = $dts['mp_gp'];
                                            $gastadoMCGP = $dts['mc_gp'];
                                            $gastadoMPTRS = $dts['mp_trs'];
                                            $gastadoMCTRS = $dts['mc_trs'];
                                            $gastadoMPZI = $dts['mp_zi'];
                                            $gastadoMCZI = $dts['mc_zi'];

                                            $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                            $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                            $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                            $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                            $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                            $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                            $anualGastadoGP = $dts['anual_gastado_gp'];
                                            $anualGastadoTRS = $dts['anual_gastado_trs'];
                                            $anualGastadoZI = $dts['anual_gastado_zi'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                echo "<div class=\"col-2 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row mt-4\">
                                    <div class=\"col-12 card-header border-0 mb-2 text-center bg-white\">
                                        <img class=\"mt-2\" src=\"svg/bandera-pvr.svg\" height=\"50px\" alt=\"\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PVR</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">GASTO ACOMULADO ESTE MES</p>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$gastoAcumuladoMPMes% / $gastoAcumuladoMCMes%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MP / MC</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$anualGastado%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 3) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_gastos WHERE id_destino = 3 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                            $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                            $anualGastado = $dts['anual_gastado'];

                                            $gastadoMPGP = $dts['mp_gp'];
                                            $gastadoMCGP = $dts['mc_gp'];
                                            $gastadoMPTRS = $dts['mp_trs'];
                                            $gastadoMCTRS = $dts['mc_trs'];
                                            $gastadoMPZI = $dts['mp_zi'];
                                            $gastadoMCZI = $dts['mc_zi'];

                                            $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                            $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                            $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                            $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                            $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                            $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                            $anualGastadoGP = $dts['anual_gastado_gp'];
                                            $anualGastadoTRS = $dts['anual_gastado_trs'];
                                            $anualGastadoZI = $dts['anual_gastado_zi'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                echo "<div class=\"col-2 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row mt-4\">
                                    <div class=\"col-12 card-header border-0 mb-2 text-center bg-white\">
                                        <img class=\"mt-2\" src=\"svg/bandera-sdq.svg\" height=\"50px\" alt=\"\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SDQ</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">GASTO ACOMULADO ESTE MES</p>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$gastoAcumuladoMPMes% / $gastoAcumuladoMCMes%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MP / MC</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$anualGastado%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 4) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_gastos WHERE id_destino = 4 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                            $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                            $anualGastado = $dts['anual_gastado'];

                                            $gastadoMPGP = $dts['mp_gp'];
                                            $gastadoMCGP = $dts['mc_gp'];
                                            $gastadoMPTRS = $dts['mp_trs'];
                                            $gastadoMCTRS = $dts['mc_trs'];
                                            $gastadoMPZI = $dts['mp_zi'];
                                            $gastadoMCZI = $dts['mc_zi'];

                                            $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                            $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                            $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                            $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                            $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                            $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                            $anualGastadoGP = $dts['anual_gastado_gp'];
                                            $anualGastadoTRS = $dts['anual_gastado_trs'];
                                            $anualGastadoZI = $dts['anual_gastado_zi'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                echo "<div class=\"col-2 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row mt-4\">
                                    <div class=\"col-12 card-header border-0 mb-2 text-center bg-white\">
                                        <img class=\"mt-2\" src=\"svg/bandera-ssa.svg\" height=\"50px\" alt=\"\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SSA</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">GASTO ACOMULADO ESTE MES</p>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$gastoAcumuladoMPMes% / $gastoAcumuladoMCMes%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MP / MC</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$anualGastado%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 5) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_gastos WHERE id_destino = 5 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                            $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                            $anualGastado = $dts['anual_gastado'];

                                            $gastadoMPGP = $dts['mp_gp'];
                                            $gastadoMCGP = $dts['mc_gp'];
                                            $gastadoMPTRS = $dts['mp_trs'];
                                            $gastadoMCTRS = $dts['mc_trs'];
                                            $gastadoMPZI = $dts['mp_zi'];
                                            $gastadoMCZI = $dts['mc_zi'];

                                            $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                            $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                            $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                            $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                            $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                            $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                            $anualGastadoGP = $dts['anual_gastado_gp'];
                                            $anualGastadoTRS = $dts['anual_gastado_trs'];
                                            $anualGastadoZI = $dts['anual_gastado_zi'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                echo "<div class=\"col-2 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row mt-4\">
                                    <div class=\"col-12 card-header border-0 mb-2 text-center bg-white\">
                                        <img class=\"mt-2\" src=\"svg/bandera-puj.svg\" height=\"50px\" alt=\"\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PUJ</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">GASTO ACOMULADO ESTE MES</p>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$gastoAcumuladoMPMes% / $gastoAcumuladoMCMes%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MP / MC</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$anualGastado%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 6) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_gastos WHERE id_destino = 6 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                            $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                            $anualGastado = $dts['anual_gastado'];

                                            $gastadoMPGP = $dts['mp_gp'];
                                            $gastadoMCGP = $dts['mc_gp'];
                                            $gastadoMPTRS = $dts['mp_trs'];
                                            $gastadoMCTRS = $dts['mc_trs'];
                                            $gastadoMPZI = $dts['mp_zi'];
                                            $gastadoMCZI = $dts['mc_zi'];

                                            $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                            $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                            $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                            $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                            $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                            $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                            $anualGastadoGP = $dts['anual_gastado_gp'];
                                            $anualGastadoTRS = $dts['anual_gastado_trs'];
                                            $anualGastadoZI = $dts['anual_gastado_zi'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                echo "<div class=\"col-2 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row mt-4\">
                                    <div class=\"col-12 card-header border-0 mb-2 text-center bg-white\">
                                        <img class=\"mt-2\" src=\"svg/bandera-mbj.svg\" height=\"50px\" alt=\"\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">MBJ</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">GASTO ACOMULADO ESTE MES</p>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$gastoAcumuladoMPMes% / $gastoAcumuladoMCMes%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MP / MC</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$anualGastado%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 7) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_gastos WHERE id_destino = 7 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                            $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                            $anualGastado = $dts['anual_gastado'];

                                            $gastadoMPGP = $dts['mp_gp'];
                                            $gastadoMCGP = $dts['mc_gp'];
                                            $gastadoMPTRS = $dts['mp_trs'];
                                            $gastadoMCTRS = $dts['mc_trs'];
                                            $gastadoMPZI = $dts['mp_zi'];
                                            $gastadoMCZI = $dts['mc_zi'];

                                            $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                            $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                            $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                            $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                            $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                            $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                            $anualGastadoGP = $dts['anual_gastado_gp'];
                                            $anualGastadoTRS = $dts['anual_gastado_trs'];
                                            $anualGastadoZI = $dts['anual_gastado_zi'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                echo "<div class=\"col-2 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row mt-4\">
                                    <div class=\"col-12 card-header border-0 mb-2 text-center bg-white\">
                                        <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CMU</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">GASTO ACOMULADO ESTE MES</p>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$gastoAcumuladoMPMes% / $gastoAcumuladoMCMes%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MP / MC</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$anualGastado%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 11) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_gastos WHERE id_destino = 11 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $gastoAcumuladoMPMes = $dts['gasto_acumulado_mp_mes'];
                                            $gastoAcumuladoMCMes = $dts['gasto_acumulado_mc_mes'];
                                            $anualGastado = $dts['anual_gastado'];

                                            $gastadoMPGP = $dts['mp_gp'];
                                            $gastadoMCGP = $dts['mc_gp'];
                                            $gastadoMPTRS = $dts['mp_trs'];
                                            $gastadoMCTRS = $dts['mc_trs'];
                                            $gastadoMPZI = $dts['mp_zi'];
                                            $gastadoMCZI = $dts['mc_zi'];

                                            $anualGastadoMPGP = $dts['anual_gastado_mp_gp'];
                                            $anualGastadoMCGP = $dts['anual_gastado_mc_gp'];
                                            $anualGastadoMPTRS = $dts['anual_gastado_mp_trs'];
                                            $anualGastadoMCTRS = $dts['anual_gastado_mc_trs'];
                                            $anualGastadoMPzi = $dts['anual_gastado_mp_zi'];
                                            $anualGastadoMCZI = $dts['anual_gastado_mc_zi'];

                                            $anualGastadoGP = $dts['anual_gastado_gp'];
                                            $anualGastadoTRS = $dts['anual_gastado_trs'];
                                            $anualGastadoZI = $dts['anual_gastado_zi'];
                                        }
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }
                                echo "<div class=\"col-2 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row mt-4\">
                                    <div class=\"col-12 card-header border-0 mb-2 text-center bg-white\">
                                        <img class=\"mt-2\" src=\"svg/bandera-cap.svg\" height=\"50px\" alt=\"\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CAP</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">GASTO ACOMULADO ESTE MES</p>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$gastoAcumuladoMPMes% / $gastoAcumuladoMCMes%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MP / MC</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$anualGastado%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">ANUAL GASTADO</p>
                                    </div>
                                </div>
                            </div>";
                            }
                            ?>

                            <!--                            <div class="col-2 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row mt-4">
                                                                <div class="col-12 card-header border-0 mb-2 text-center bg-white">
                                                                    <img class="mt-2" src="svg/bandera-pvr.svg" height="50px" alt="">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">PVR</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTO ACOMULADO ESTE MES</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">54% / 48%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MP / MC</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">72%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-2 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row mt-4">
                                                                <div class="col-12 card-header border-0 mb-2 text-center bg-white">
                                                                    <img class="mt-2" src="svg/bandera-cmu.svg" height="50px" alt="">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">CMU</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTO ACOMULADO ESTE MES</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">8% / 39%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MP / MC</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">72%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-2 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row mt-4">
                                                                <div class="col-12 card-header border-0 mb-2 text-center bg-white">
                                                                    <img class="mt-2" src="svg/bandera-mbj.svg" height="50px" alt="">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">MBJ</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTO ACOMULADO ESTE MES</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">41% / 51%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MP / MC</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">72%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-2 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row mt-4">
                                                                <div class="col-12 card-header border-0 mb-2 text-center bg-white">
                                                                    <img class="mt-2" src="svg/bandera-puj.svg" height="50px" alt="">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">PUJ</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTO ACOMULADO ESTE MES</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">18% / 84%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MP / MC</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">72%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-2 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row mt-4">
                                                                <div class="col-12 card-header border-0 mb-2 text-center bg-white">
                                                                    <img class="mt-2" src="svg/bandera-sdq.svg" height="50px" alt="">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">SDQ</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTO ACOMULADO ESTE MES</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">11% / 28%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MP / MC</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">72%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-2 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row mt-4">
                                                                <div class="col-12 card-header border-0 mb-2 text-center bg-white">
                                                                    <img class="mt-2" src="svg/bandera-cap.svg" height="50px" alt="">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">CAP</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTO ACOMULADO ESTE MES</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0% / 61%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MP / MC</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">72%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-2 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row mt-4">
                                                                <div class="col-12 card-header border-0 mb-2 text-center bg-white">
                                                                    <img class="mt-2" src="svg/bandera-ssa.svg" height="50px" alt="">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">SSA</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">GASTO ACOMULADO ESTE MES</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">52% / 220%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MP / MC</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">2%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">ANUAL GASTADO</p>
                                                                </div>
                                                            </div>
                                                        </div>-->

                        </div>
                    </div>


                    <hr class="my-4">

                    <div class="row">
                        <h1 class="mn-bold texto-negro fs-28 ml-4 my-4">Planner</h1>
                    </div>

                    <div class="container-fluid scroll-horizontal" data-toggle="collapse" href="#ocultoplanner" role="button" aria-expanded="false" aria-controls="ocultoplanner">
                        <div class="row flex-nowrap">

                            <?php
                            $query = "SELECT * FROM t_informes_planner WHERE id_destino = $idDestinoT AND mes = '$mes' AND year = $año";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $ziacreadomes = $dts['zia_creado_mes'];
                                        $ziasolmes = $dts['zia_sol_mes'];
                                        $ziccreadomes = $dts['zic_creado_mes'];
                                        $zicsolmes = $dts['zic_sol_mes'];
                                        $ziecreadomes = $dts['zie_creado_mes'];
                                        $ziesolmes = $dts['zie_sol_mes'];
                                        $zilcreadomes = $dts['zil_creado_mes'];
                                        $zilsolmes = $dts['zil_sol_mes'];
                                        $zhacreadomes = $dts['zha_creado_mes'];
                                        $zhasolmes = $dts['zha_sol_mes'];
                                        $zhccreadomes = $dts['zhc_creado_mes'];
                                        $zhcsolmes = $dts['zhc_sol_mes'];
                                        $zhpcreadomes = $dts['zhp_creado_mes'];
                                        $zhpsolmes = $dts['zhp_sol_mes'];
                                        $deccreadomes = $dts['dec_creado_mes'];
                                        $decsolmes = $dts['dec_sol_mes'];
                                        $depcreadomes = $dts['dep_creado_mes'];
                                        $depsolmes = $dts['dep_sol_mes'];
                                        $autocreadomes = $dts['auto_creado_mes'];
                                        $autosolmes = $dts['auto_sol_mes'];

                                        $otcreadaszia = $dts['ot_planificadas_zia'];
                                        $otrealizadaszia = $dts['ot_realizadas_zia'];
                                        $otcreadaszic = $dts['ot_planificadas_zic'];
                                        $otrealizadaszic = $dts['ot_realizadas_zic'];
                                        $otcreadaszie = $dts['ot_planificadas_zie'];
                                        $otrealizadaszie = $dts['ot_realizadas_zie'];
                                        $otcreadaszil = $dts['ot_planificadas_zil'];
                                        $otrealizadaszil = $dts['ot_realizadas_zil'];
                                        $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                        $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                        $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                        $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                        $otcreadasdec = $dts['ot_planificadas_dec'];
                                        $otrealizadasdec = $dts['ot_realizadas_dec'];
                                    }
                                } else {
                                    $ziacreadomes = 0;
                                    $ziasolmes = 0;
                                    $ziccreadomes = 0;
                                    $zicsolmes = 0;
                                    $ziecreadomes = 0;
                                    $ziesolmes = 0;
                                    $zilcreadomes = 0;
                                    $zilsolmes = 0;
                                    $zhacreadomes = 0;
                                    $zhasolmes = 0;
                                    $zhccreadomes = 0;
                                    $zhcsolmes = 0;
                                    $zhpcreadomes = 0;
                                    $zhpsolmes = 0;
                                    $deccreadomes = 0;
                                    $decsolmes = 0;
                                    $depcreadomes = 0;
                                    $depsolmes = 0;
                                    $autocreadomes = 0;
                                    $autosolmes = 0;

                                    $otcreadaszia = 0;
                                    $otrealizadaszia = 0;
                                    $otcreadaszic = 0;
                                    $otrealizadaszic = 0;
                                    $otcreadaszie = 0;
                                    $otrealizadaszie = 0;
                                    $otcreadaszil = 0;
                                    $otrealizadaszil = 0;
                                    $otcreadaszhc = 0;
                                    $otrealizadaszhc = 0;
                                    $otcreadaszhp = 0;
                                    $otrealizadaszhp = 0;
                                    $otcreadasdec = 0;
                                    $otrealizadasdec = 0;
                                }
                                $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                //porcentaje restante en tareas
                                if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                    $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                    $porPendiente = 100 - $porcentaje;
                                } else {
                                    $porPendiente = 0;
                                }

                                //Porc de avance en ots
                                if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                    $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                } else {
                                    $porcOT = 0;
                                }

                                if ($ziacreadomes > 0 && $ziasolmes > 0) {
                                    $porcentajezia = ($ziasolmes / $ziacreadomes) * 100;
                                    $porPendientezia = 100 - $porcentajezia;
                                } else {
                                    $porPendientezia = 0;
                                }

                                if ($ziccreadomes > 0 && $zicsolmes > 0) {
                                    $porcentajezic = ($zicsolmes / $ziccreadomes) * 100;
                                    $porPendientezic = 100 - $porcentajezic;
                                } else {
                                    $porPendientezic = 0;
                                }
                                if ($ziecreadomes > 0 && $ziesolmes > 0) {
                                    $porcentajezie = ($ziesolmes / $ziecreadomes) * 100;
                                    $porPendientezie = 100 - $porcentajezie;
                                } else {
                                    $porPendientezie = 0;
                                }
                                if ($zilcreadomes > 0 && $zilsolmes > 0) {
                                    $porcentajezil = ($zilsolmes / $zilcreadomes) * 100;
                                    $porPendientezil = 100 - $porcentajezil;
                                } else {
                                    $porPendientezil = 0;
                                }
                                if ($zhccreadomes > 0 && $zhcsolmes > 0) {
                                    $porcentajezhc = ($zhcsolmes / $zhccreadomes) * 100;
                                    $porPendientezhc = 100 - $porcentajezhc;
                                } else {
                                    $porPendientezhc = 0;
                                }
                                if ($zhpcreadomes > 0 && $zhpsolmes > 0) {
                                    $porcentajezhp = ($zhpsolmes / $zhpcreadomes) * 100;
                                    $porPendientezhp = 100 - $porcentajezhp;
                                } else {
                                    $porPendientezhp = 0;
                                }
                                if ($deccreadomes > 0 && $decsolmes > 0) {
                                    $porcentajedec = ($decsolmes / $deccreadomes) * 100;
                                    $porPendientedec = 100 - $porcentajedec;
                                } else {
                                    $porPendientedec = 0;
                                }

                                if ($otcreadaszia > 0 && $otrealizadaszia > 0) {
                                    $porcotzia = ($otrealizadaszia / $otcreadaszia) * 100;
                                } else {
                                    $porcotzia = 0;
                                }

                                if ($otcreadaszic > 0 && $otrealizadaszic > 0) {
                                    $porcotzic = ($otrealizadaszic / $otcreadaszic) * 100;
                                } else {
                                    $porcotzic = 0;
                                }

                                if ($otcreadaszie > 0 && $otrealizadaszie > 0) {
                                    $porcotzie = ($otrealizadaszie / $otcreadaszie) * 100;
                                } else {
                                    $porcotzie = 0;
                                }

                                if ($otcreadaszil > 0 && $otrealizadaszil > 0) {
                                    $porcotzil = ($otrealizadaszil / $otcreadaszil) * 100;
                                } else {
                                    $porcotzil = 0;
                                }

                                if ($otcreadaszhc > 0 && $otrealizadaszhc > 0) {
                                    $porcotzhc = ($otrealizadaszhc / $otcreadaszhc) * 100;
                                } else {
                                    $porcotzhc = 0;
                                }

                                if ($otcreadaszhp > 0 && $otrealizadaszhp > 0) {
                                    $porcotzhp = ($otrealizadaszhp / $otcreadaszhp) * 100;
                                } else {
                                    $porcotzhp = 0;
                                }

                                if ($otcreadasdec > 0 && $otrealizadasdec > 0) {
                                    $porcotdec = ($otrealizadasdec / $otcreadasdec) * 100;
                                } else {
                                    $porcotdec = 0;
                                }
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                            ?>

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header  bg-body border-0 mb-2 text-center">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $destinoT; ?></h1>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $totalCreadoMes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $totalCreadoMes; ?> / <?php echo $totalSolMes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porPendiente); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zia.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $ziacreadomes; ?> / <?php echo $ziasolmes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CREADO / SOLUCIONADO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porPendientezia); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zic.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $ziccreadomes; ?> / <?php echo $zicsolmes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CREADO / SOLUCIONADO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porPendientezic); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zie.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $ziecreadomes; ?> / <?php echo $ziesolmes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CREADO / SOLUCIONADO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porPendientezie); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zil.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $zilcreadomes; ?> / <?php echo $zilsolmes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CREADO / SOLUCIONADO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porPendientezil); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zhc.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $zhccreadomes; ?> / <?php echo $zhcsolmes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CREADO / SOLUCIONADO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porPendientezhc); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zhp.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $zhpcreadomes; ?> / <?php echo $zhpsolmes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CREADO / SOLUCIONADO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porPendientezhp); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-float rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/dec.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $deccreadomes; ?> / <?php echo $decsolmes; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CREADO / SOLUCIONADO</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porPendientedec); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row flex-nowrap">

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $destinoT; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MANTENIMIENTO PREVENTIVO</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $totalOTCreadas; ?> / <?php echo $totalOTRealizadas; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porcOT); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zia.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $otcreadaszia; ?> / <?php echo $otrealizadaszia; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porcotzia); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zic.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $otcreadaszic; ?> / <?php echo $otrealizadaszic; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porcotzic); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zie.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $otcreadaszie; ?> / <?php echo $otrealizadaszie; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porcotzie); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zil.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $otcreadaszil; ?> / <?php echo $otrealizadaszil; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porcotzil); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zhc.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $otcreadaszhc; ?> / <?php echo $otrealizadaszhc; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porcotzhc); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/zhp.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $otcreadaszhp; ?> / <?php echo $otrealizadaszhp; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porcotzhp); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 mx-3 hvr-grow rounded-lg mx-2 my-3">
                                <div class="row">
                                    <div class="col-12 card-header bg-body border-0 mb-2 text-center">
                                        <img class="mt-2" src="svg/secciones/dec.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $otcreadasdec; ?> / <?php echo $otrealizadasdec; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo round($porcotdec); ?>%</h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="container-fluid scroll-horizontal collapse bg-dark" id="ocultoplanner">

                        <div class="row flex-nowrap rounded-lg mt-2">

                            <?php
                            if ($idDestinoT == 1) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_planner WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $ziacreadomes = $dts['zia_creado_mes'];
                                            $ziasolmes = $dts['zia_sol_mes'];
                                            $ziccreadomes = $dts['zic_creado_mes'];
                                            $zicsolmes = $dts['zic_sol_mes'];
                                            $ziecreadomes = $dts['zie_creado_mes'];
                                            $ziesolmes = $dts['zie_sol_mes'];
                                            $zilcreadomes = $dts['zil_creado_mes'];
                                            $zilsolmes = $dts['zil_sol_mes'];
                                            $zhacreadomes = $dts['zha_creado_mes'];
                                            $zhasolmes = $dts['zha_sol_mes'];
                                            $zhccreadomes = $dts['zhc_creado_mes'];
                                            $zhcsolmes = $dts['zhc_sol_mes'];
                                            $zhpcreadomes = $dts['zhp_creado_mes'];
                                            $zhpsolmes = $dts['zhp_sol_mes'];
                                            $deccreadomes = $dts['dec_creado_mes'];
                                            $decsolmes = $dts['dec_sol_mes'];
                                            $depcreadomes = $dts['dep_creado_mes'];
                                            $depsolmes = $dts['dep_sol_mes'];
                                            $autocreadomes = $dts['auto_creado_mes'];
                                            $autosolmes = $dts['auto_sol_mes'];

                                            $otcreadaszia = $dts['ot_planificadas_zia'];
                                            $otrealizadaszia = $dts['ot_realizads_zia'];
                                            $otcreadaszic = $dts['ot_planificadas_zic'];
                                            $otrealizadaszic = $dts['ot_realizadas_zic'];
                                            $otcreadaszie = $dts['ot_planificadas_zie'];
                                            $otrealizadaszie = $dts['ot_realizadas_zie'];
                                            $otcreadaszil = $dts['ot_planificadas_zil'];
                                            $otrealizadaszil = $dts['ot_realizadas_zil'];
                                            $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                            $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                            $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                            $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                            $otcreadasdec = $dts['ot_planificadas_dec'];
                                            $otrealizadasdec = $dts['ot_realizadas_dec'];
                                        }
                                    } else {
                                        $ziacreadomes = 0;
                                        $ziasolmes = 0;
                                        $ziccreadomes = 0;
                                        $zicsolmes = 0;
                                        $ziecreadomes = 0;
                                        $ziesolmes = 0;
                                        $zilcreadomes = 0;
                                        $zilsolmes = 0;
                                        $zhacreadomes = 0;
                                        $zhasolmes = 0;
                                        $zhccreadomes = 0;
                                        $zhcsolmes = 0;
                                        $zhpcreadomes = 0;
                                        $zhpsolmes = 0;
                                        $deccreadomes = 0;
                                        $decsolmes = 0;
                                        $depcreadomes = 0;
                                        $depsolmes = 0;
                                        $autocreadomes = 0;
                                        $autosolmes = 0;

                                        $otcreadaszia = 0;
                                        $otrealizadaszia = 0;
                                        $otcreadaszic = 0;
                                        $otrealizadaszic = 0;
                                        $otcreadaszie = 0;
                                        $otrealizadaszie = 0;
                                        $otcreadaszil = 0;
                                        $otrealizadaszil = 0;
                                        $otcreadaszhc = 0;
                                        $otrealizadaszhc = 0;
                                        $otcreadaszhp = 0;
                                        $otrealizadaszhp = 0;
                                        $otcreadasdec = 0;
                                        $otrealizadasdec = 0;
                                    }
                                    $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                    $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                    $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                    $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                    //porcentaje restante en tareas
                                    if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                        $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                        $porPendiente = 100 - $porcentaje;
                                    } else {
                                        $porPendiente = 0;
                                    }

                                    //Porc de avance en ots
                                    if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                        $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                    } else {
                                        $porcOT = 0;
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                echo "<div class=\"col-4 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row justify-content-center\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/bandera-rm.svg\" height=\"50px\" alt=\"\"> </span> RM</h1>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-6\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes / $totalSolMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porPendiente) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTE DE SOLUCION</p>
                                    </div>
                                    <div class=\"col-6\">
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MANTENIMIENTO PREVENTIVO</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalOTCreadas / $totalOTRealizadas</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porcOT) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 2) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_planner WHERE id_destino = 2 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $ziacreadomes = $dts['zia_creado_mes'];
                                            $ziasolmes = $dts['zia_sol_mes'];
                                            $ziccreadomes = $dts['zic_creado_mes'];
                                            $zicsolmes = $dts['zic_sol_mes'];
                                            $ziecreadomes = $dts['zie_creado_mes'];
                                            $ziesolmes = $dts['zie_sol_mes'];
                                            $zilcreadomes = $dts['zil_creado_mes'];
                                            $zilsolmes = $dts['zil_sol_mes'];
                                            $zhacreadomes = $dts['zha_creado_mes'];
                                            $zhasolmes = $dts['zha_sol_mes'];
                                            $zhccreadomes = $dts['zhc_creado_mes'];
                                            $zhcsolmes = $dts['zhc_sol_mes'];
                                            $zhpcreadomes = $dts['zhp_creado_mes'];
                                            $zhpsolmes = $dts['zhp_sol_mes'];
                                            $deccreadomes = $dts['dec_creado_mes'];
                                            $decsolmes = $dts['dec_sol_mes'];
                                            $depcreadomes = $dts['dep_creado_mes'];
                                            $depsolmes = $dts['dep_sol_mes'];
                                            $autocreadomes = $dts['auto_creado_mes'];
                                            $autosolmes = $dts['auto_sol_mes'];

                                            $otcreadaszia = $dts['ot_planificadas_zia'];
                                            $otrealizadaszia = $dts['ot_realizads_zia'];
                                            $otcreadaszic = $dts['ot_planificadas_zic'];
                                            $otrealizadaszic = $dts['ot_realizadas_zic'];
                                            $otcreadaszie = $dts['ot_planificadas_zie'];
                                            $otrealizadaszie = $dts['ot_realizadas_zie'];
                                            $otcreadaszil = $dts['ot_planificadas_zil'];
                                            $otrealizadaszil = $dts['ot_realizadas_zil'];
                                            $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                            $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                            $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                            $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                            $otcreadasdec = $dts['ot_planificadas_dec'];
                                            $otrealizadasdec = $dts['ot_realizadas_dec'];
                                        }
                                    } else {
                                        $ziacreadomes = 0;
                                        $ziasolmes = 0;
                                        $ziccreadomes = 0;
                                        $zicsolmes = 0;
                                        $ziecreadomes = 0;
                                        $ziesolmes = 0;
                                        $zilcreadomes = 0;
                                        $zilsolmes = 0;
                                        $zhacreadomes = 0;
                                        $zhasolmes = 0;
                                        $zhccreadomes = 0;
                                        $zhcsolmes = 0;
                                        $zhpcreadomes = 0;
                                        $zhpsolmes = 0;
                                        $deccreadomes = 0;
                                        $decsolmes = 0;
                                        $depcreadomes = 0;
                                        $depsolmes = 0;
                                        $autocreadomes = 0;
                                        $autosolmes = 0;

                                        $otcreadaszia = 0;
                                        $otrealizadaszia = 0;
                                        $otcreadaszic = 0;
                                        $otrealizadaszic = 0;
                                        $otcreadaszie = 0;
                                        $otrealizadaszie = 0;
                                        $otcreadaszil = 0;
                                        $otrealizadaszil = 0;
                                        $otcreadaszhc = 0;
                                        $otrealizadaszhc = 0;
                                        $otcreadaszhp = 0;
                                        $otrealizadaszhp = 0;
                                        $otcreadasdec = 0;
                                        $otrealizadasdec = 0;
                                    }
                                    $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                    $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                    $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                    $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                    //porcentaje restante en tareas
                                    if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                        $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                        $porPendiente = 100 - $porcentaje;
                                    } else {
                                        $porPendiente = 0;
                                    }

                                    //Porc de avance en ots
                                    if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                        $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                    } else {
                                        $porcOT = 0;
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                echo "<div class=\"col-4 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row justify-content-center\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/bandera-pvr.svg\" height=\"50px\" alt=\"\"> </span> PVR</h1>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-6\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes / $totalSolMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porPendiente) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTE DE SOLUCION</p>
                                    </div>
                                    <div class=\"col-6\">
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MANTENIMIENTO PREVENTIVO</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalOTCreadas / $totalOTRealizadas</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porcOT) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 3) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_planner WHERE id_destino = 3 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $ziacreadomes = $dts['zia_creado_mes'];
                                            $ziasolmes = $dts['zia_sol_mes'];
                                            $ziccreadomes = $dts['zic_creado_mes'];
                                            $zicsolmes = $dts['zic_sol_mes'];
                                            $ziecreadomes = $dts['zie_creado_mes'];
                                            $ziesolmes = $dts['zie_sol_mes'];
                                            $zilcreadomes = $dts['zil_creado_mes'];
                                            $zilsolmes = $dts['zil_sol_mes'];
                                            $zhacreadomes = $dts['zha_creado_mes'];
                                            $zhasolmes = $dts['zha_sol_mes'];
                                            $zhccreadomes = $dts['zhc_creado_mes'];
                                            $zhcsolmes = $dts['zhc_sol_mes'];
                                            $zhpcreadomes = $dts['zhp_creado_mes'];
                                            $zhpsolmes = $dts['zhp_sol_mes'];
                                            $deccreadomes = $dts['dec_creado_mes'];
                                            $decsolmes = $dts['dec_sol_mes'];
                                            $depcreadomes = $dts['dep_creado_mes'];
                                            $depsolmes = $dts['dep_sol_mes'];
                                            $autocreadomes = $dts['auto_creado_mes'];
                                            $autosolmes = $dts['auto_sol_mes'];

                                            $otcreadaszia = $dts['ot_planificadas_zia'];
                                            $otrealizadaszia = $dts['ot_realizads_zia'];
                                            $otcreadaszic = $dts['ot_planificadas_zic'];
                                            $otrealizadaszic = $dts['ot_realizadas_zic'];
                                            $otcreadaszie = $dts['ot_planificadas_zie'];
                                            $otrealizadaszie = $dts['ot_realizadas_zie'];
                                            $otcreadaszil = $dts['ot_planificadas_zil'];
                                            $otrealizadaszil = $dts['ot_realizadas_zil'];
                                            $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                            $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                            $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                            $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                            $otcreadasdec = $dts['ot_planificadas_dec'];
                                            $otrealizadasdec = $dts['ot_realizadas_dec'];
                                        }
                                    } else {
                                        $ziacreadomes = 0;
                                        $ziasolmes = 0;
                                        $ziccreadomes = 0;
                                        $zicsolmes = 0;
                                        $ziecreadomes = 0;
                                        $ziesolmes = 0;
                                        $zilcreadomes = 0;
                                        $zilsolmes = 0;
                                        $zhacreadomes = 0;
                                        $zhasolmes = 0;
                                        $zhccreadomes = 0;
                                        $zhcsolmes = 0;
                                        $zhpcreadomes = 0;
                                        $zhpsolmes = 0;
                                        $deccreadomes = 0;
                                        $decsolmes = 0;
                                        $depcreadomes = 0;
                                        $depsolmes = 0;
                                        $autocreadomes = 0;
                                        $autosolmes = 0;

                                        $otcreadaszia = 0;
                                        $otrealizadaszia = 0;
                                        $otcreadaszic = 0;
                                        $otrealizadaszic = 0;
                                        $otcreadaszie = 0;
                                        $otrealizadaszie = 0;
                                        $otcreadaszil = 0;
                                        $otrealizadaszil = 0;
                                        $otcreadaszhc = 0;
                                        $otrealizadaszhc = 0;
                                        $otcreadaszhp = 0;
                                        $otrealizadaszhp = 0;
                                        $otcreadasdec = 0;
                                        $otrealizadasdec = 0;
                                    }
                                    $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                    $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                    $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                    $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                    //porcentaje restante en tareas
                                    if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                        $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                        $porPendiente = 100 - $porcentaje;
                                    } else {
                                        $porPendiente = 0;
                                    }

                                    //Porc de avance en ots
                                    if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                        $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                    } else {
                                        $porcOT = 0;
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                echo "<div class=\"col-4 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row justify-content-center\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/bandera-sdq.svg\" height=\"50px\" alt=\"\"> </span> SDQ</h1>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-6\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes / $totalSolMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porPendiente) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTE DE SOLUCION</p>
                                    </div>
                                    <div class=\"col-6\">
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MANTENIMIENTO PREVENTIVO</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalOTCreadas / $totalOTRealizadas</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porcOT) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 4) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_planner WHERE id_destino = 4 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $ziacreadomes = $dts['zia_creado_mes'];
                                            $ziasolmes = $dts['zia_sol_mes'];
                                            $ziccreadomes = $dts['zic_creado_mes'];
                                            $zicsolmes = $dts['zic_sol_mes'];
                                            $ziecreadomes = $dts['zie_creado_mes'];
                                            $ziesolmes = $dts['zie_sol_mes'];
                                            $zilcreadomes = $dts['zil_creado_mes'];
                                            $zilsolmes = $dts['zil_sol_mes'];
                                            $zhacreadomes = $dts['zha_creado_mes'];
                                            $zhasolmes = $dts['zha_sol_mes'];
                                            $zhccreadomes = $dts['zhc_creado_mes'];
                                            $zhcsolmes = $dts['zhc_sol_mes'];
                                            $zhpcreadomes = $dts['zhp_creado_mes'];
                                            $zhpsolmes = $dts['zhp_sol_mes'];
                                            $deccreadomes = $dts['dec_creado_mes'];
                                            $decsolmes = $dts['dec_sol_mes'];
                                            $depcreadomes = $dts['dep_creado_mes'];
                                            $depsolmes = $dts['dep_sol_mes'];
                                            $autocreadomes = $dts['auto_creado_mes'];
                                            $autosolmes = $dts['auto_sol_mes'];

                                            $otcreadaszia = $dts['ot_planificadas_zia'];
                                            $otrealizadaszia = $dts['ot_realizads_zia'];
                                            $otcreadaszic = $dts['ot_planificadas_zic'];
                                            $otrealizadaszic = $dts['ot_realizadas_zic'];
                                            $otcreadaszie = $dts['ot_planificadas_zie'];
                                            $otrealizadaszie = $dts['ot_realizadas_zie'];
                                            $otcreadaszil = $dts['ot_planificadas_zil'];
                                            $otrealizadaszil = $dts['ot_realizadas_zil'];
                                            $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                            $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                            $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                            $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                            $otcreadasdec = $dts['ot_planificadas_dec'];
                                            $otrealizadasdec = $dts['ot_realizadas_dec'];
                                        }
                                    } else {
                                        $ziacreadomes = 0;
                                        $ziasolmes = 0;
                                        $ziccreadomes = 0;
                                        $zicsolmes = 0;
                                        $ziecreadomes = 0;
                                        $ziesolmes = 0;
                                        $zilcreadomes = 0;
                                        $zilsolmes = 0;
                                        $zhacreadomes = 0;
                                        $zhasolmes = 0;
                                        $zhccreadomes = 0;
                                        $zhcsolmes = 0;
                                        $zhpcreadomes = 0;
                                        $zhpsolmes = 0;
                                        $deccreadomes = 0;
                                        $decsolmes = 0;
                                        $depcreadomes = 0;
                                        $depsolmes = 0;
                                        $autocreadomes = 0;
                                        $autosolmes = 0;

                                        $otcreadaszia = 0;
                                        $otrealizadaszia = 0;
                                        $otcreadaszic = 0;
                                        $otrealizadaszic = 0;
                                        $otcreadaszie = 0;
                                        $otrealizadaszie = 0;
                                        $otcreadaszil = 0;
                                        $otrealizadaszil = 0;
                                        $otcreadaszhc = 0;
                                        $otrealizadaszhc = 0;
                                        $otcreadaszhp = 0;
                                        $otrealizadaszhp = 0;
                                        $otcreadasdec = 0;
                                        $otrealizadasdec = 0;
                                    }
                                    $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                    $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                    $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                    $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                    //porcentaje restante en tareas
                                    if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                        $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                        $porPendiente = 100 - $porcentaje;
                                    } else {
                                        $porPendiente = 0;
                                    }

                                    //Porc de avance en ots
                                    if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                        $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                    } else {
                                        $porcOT = 0;
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                echo "<div class=\"col-4 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row justify-content-center\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/bandera-ssa.svg\" height=\"50px\" alt=\"\"> </span> SSA</h1>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-6\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes / $totalSolMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porPendiente) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTE DE SOLUCION</p>
                                    </div>
                                    <div class=\"col-6\">
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MANTENIMIENTO PREVENTIVO</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalOTCreadas / $totalOTRealizadas</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porcOT) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 5) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_planner WHERE id_destino = 5 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $ziacreadomes = $dts['zia_creado_mes'];
                                            $ziasolmes = $dts['zia_sol_mes'];
                                            $ziccreadomes = $dts['zic_creado_mes'];
                                            $zicsolmes = $dts['zic_sol_mes'];
                                            $ziecreadomes = $dts['zie_creado_mes'];
                                            $ziesolmes = $dts['zie_sol_mes'];
                                            $zilcreadomes = $dts['zil_creado_mes'];
                                            $zilsolmes = $dts['zil_sol_mes'];
                                            $zhacreadomes = $dts['zha_creado_mes'];
                                            $zhasolmes = $dts['zha_sol_mes'];
                                            $zhccreadomes = $dts['zhc_creado_mes'];
                                            $zhcsolmes = $dts['zhc_sol_mes'];
                                            $zhpcreadomes = $dts['zhp_creado_mes'];
                                            $zhpsolmes = $dts['zhp_sol_mes'];
                                            $deccreadomes = $dts['dec_creado_mes'];
                                            $decsolmes = $dts['dec_sol_mes'];
                                            $depcreadomes = $dts['dep_creado_mes'];
                                            $depsolmes = $dts['dep_sol_mes'];
                                            $autocreadomes = $dts['auto_creado_mes'];
                                            $autosolmes = $dts['auto_sol_mes'];

                                            $otcreadaszia = $dts['ot_planificadas_zia'];
                                            $otrealizadaszia = $dts['ot_realizads_zia'];
                                            $otcreadaszic = $dts['ot_planificadas_zic'];
                                            $otrealizadaszic = $dts['ot_realizadas_zic'];
                                            $otcreadaszie = $dts['ot_planificadas_zie'];
                                            $otrealizadaszie = $dts['ot_realizadas_zie'];
                                            $otcreadaszil = $dts['ot_planificadas_zil'];
                                            $otrealizadaszil = $dts['ot_realizadas_zil'];
                                            $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                            $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                            $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                            $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                            $otcreadasdec = $dts['ot_planificadas_dec'];
                                            $otrealizadasdec = $dts['ot_realizadas_dec'];
                                        }
                                    } else {
                                        $ziacreadomes = 0;
                                        $ziasolmes = 0;
                                        $ziccreadomes = 0;
                                        $zicsolmes = 0;
                                        $ziecreadomes = 0;
                                        $ziesolmes = 0;
                                        $zilcreadomes = 0;
                                        $zilsolmes = 0;
                                        $zhacreadomes = 0;
                                        $zhasolmes = 0;
                                        $zhccreadomes = 0;
                                        $zhcsolmes = 0;
                                        $zhpcreadomes = 0;
                                        $zhpsolmes = 0;
                                        $deccreadomes = 0;
                                        $decsolmes = 0;
                                        $depcreadomes = 0;
                                        $depsolmes = 0;
                                        $autocreadomes = 0;
                                        $autosolmes = 0;

                                        $otcreadaszia = 0;
                                        $otrealizadaszia = 0;
                                        $otcreadaszic = 0;
                                        $otrealizadaszic = 0;
                                        $otcreadaszie = 0;
                                        $otrealizadaszie = 0;
                                        $otcreadaszil = 0;
                                        $otrealizadaszil = 0;
                                        $otcreadaszhc = 0;
                                        $otrealizadaszhc = 0;
                                        $otcreadaszhp = 0;
                                        $otrealizadaszhp = 0;
                                        $otcreadasdec = 0;
                                        $otrealizadasdec = 0;
                                    }
                                    $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                    $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                    $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                    $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                    //porcentaje restante en tareas
                                    if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                        $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                        $porPendiente = 100 - $porcentaje;
                                    } else {
                                        $porPendiente = 0;
                                    }

                                    //Porc de avance en ots
                                    if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                        $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                    } else {
                                        $porcOT = 0;
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                echo "<div class=\"col-4 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row justify-content-center\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/bandera-puj.svg\" height=\"50px\" alt=\"\"> </span> PUJ</h1>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-6\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes / $totalSolMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porPendiente) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTE DE SOLUCION</p>
                                    </div>
                                    <div class=\"col-6\">
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MANTENIMIENTO PREVENTIVO</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalOTCreadas / $totalOTRealizadas</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porcOT) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 6) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_planner WHERE id_destino = 6 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $ziacreadomes = $dts['zia_creado_mes'];
                                            $ziasolmes = $dts['zia_sol_mes'];
                                            $ziccreadomes = $dts['zic_creado_mes'];
                                            $zicsolmes = $dts['zic_sol_mes'];
                                            $ziecreadomes = $dts['zie_creado_mes'];
                                            $ziesolmes = $dts['zie_sol_mes'];
                                            $zilcreadomes = $dts['zil_creado_mes'];
                                            $zilsolmes = $dts['zil_sol_mes'];
                                            $zhacreadomes = $dts['zha_creado_mes'];
                                            $zhasolmes = $dts['zha_sol_mes'];
                                            $zhccreadomes = $dts['zhc_creado_mes'];
                                            $zhcsolmes = $dts['zhc_sol_mes'];
                                            $zhpcreadomes = $dts['zhp_creado_mes'];
                                            $zhpsolmes = $dts['zhp_sol_mes'];
                                            $deccreadomes = $dts['dec_creado_mes'];
                                            $decsolmes = $dts['dec_sol_mes'];
                                            $depcreadomes = $dts['dep_creado_mes'];
                                            $depsolmes = $dts['dep_sol_mes'];
                                            $autocreadomes = $dts['auto_creado_mes'];
                                            $autosolmes = $dts['auto_sol_mes'];

                                            $otcreadaszia = $dts['ot_planificadas_zia'];
                                            $otrealizadaszia = $dts['ot_realizads_zia'];
                                            $otcreadaszic = $dts['ot_planificadas_zic'];
                                            $otrealizadaszic = $dts['ot_realizadas_zic'];
                                            $otcreadaszie = $dts['ot_planificadas_zie'];
                                            $otrealizadaszie = $dts['ot_realizadas_zie'];
                                            $otcreadaszil = $dts['ot_planificadas_zil'];
                                            $otrealizadaszil = $dts['ot_realizadas_zil'];
                                            $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                            $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                            $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                            $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                            $otcreadasdec = $dts['ot_planificadas_dec'];
                                            $otrealizadasdec = $dts['ot_realizadas_dec'];
                                        }
                                    } else {
                                        $ziacreadomes = 0;
                                        $ziasolmes = 0;
                                        $ziccreadomes = 0;
                                        $zicsolmes = 0;
                                        $ziecreadomes = 0;
                                        $ziesolmes = 0;
                                        $zilcreadomes = 0;
                                        $zilsolmes = 0;
                                        $zhacreadomes = 0;
                                        $zhasolmes = 0;
                                        $zhccreadomes = 0;
                                        $zhcsolmes = 0;
                                        $zhpcreadomes = 0;
                                        $zhpsolmes = 0;
                                        $deccreadomes = 0;
                                        $decsolmes = 0;
                                        $depcreadomes = 0;
                                        $depsolmes = 0;
                                        $autocreadomes = 0;
                                        $autosolmes = 0;

                                        $otcreadaszia = 0;
                                        $otrealizadaszia = 0;
                                        $otcreadaszic = 0;
                                        $otrealizadaszic = 0;
                                        $otcreadaszie = 0;
                                        $otrealizadaszie = 0;
                                        $otcreadaszil = 0;
                                        $otrealizadaszil = 0;
                                        $otcreadaszhc = 0;
                                        $otrealizadaszhc = 0;
                                        $otcreadaszhp = 0;
                                        $otrealizadaszhp = 0;
                                        $otcreadasdec = 0;
                                        $otrealizadasdec = 0;
                                    }
                                    $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                    $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                    $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                    $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                    //porcentaje restante en tareas
                                    if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                        $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                        $porPendiente = 100 - $porcentaje;
                                    } else {
                                        $porPendiente = 0;
                                    }

                                    //Porc de avance en ots
                                    if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                        $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                    } else {
                                        $porcOT = 0;
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                echo "<div class=\"col-4 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row justify-content-center\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/bandera-mbj.svg\" height=\"50px\" alt=\"\"> </span> MBJ</h1>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-6\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes / $totalSolMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porPendiente) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTE DE SOLUCION</p>
                                    </div>
                                    <div class=\"col-6\">
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MANTENIMIENTO PREVENTIVO</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalOTCreadas / $totalOTRealizadas</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porcOT) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 7) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_planner WHERE id_destino = 7 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $ziacreadomes = $dts['zia_creado_mes'];
                                            $ziasolmes = $dts['zia_sol_mes'];
                                            $ziccreadomes = $dts['zic_creado_mes'];
                                            $zicsolmes = $dts['zic_sol_mes'];
                                            $ziecreadomes = $dts['zie_creado_mes'];
                                            $ziesolmes = $dts['zie_sol_mes'];
                                            $zilcreadomes = $dts['zil_creado_mes'];
                                            $zilsolmes = $dts['zil_sol_mes'];
                                            $zhacreadomes = $dts['zha_creado_mes'];
                                            $zhasolmes = $dts['zha_sol_mes'];
                                            $zhccreadomes = $dts['zhc_creado_mes'];
                                            $zhcsolmes = $dts['zhc_sol_mes'];
                                            $zhpcreadomes = $dts['zhp_creado_mes'];
                                            $zhpsolmes = $dts['zhp_sol_mes'];
                                            $deccreadomes = $dts['dec_creado_mes'];
                                            $decsolmes = $dts['dec_sol_mes'];
                                            $depcreadomes = $dts['dep_creado_mes'];
                                            $depsolmes = $dts['dep_sol_mes'];
                                            $autocreadomes = $dts['auto_creado_mes'];
                                            $autosolmes = $dts['auto_sol_mes'];

                                            $otcreadaszia = $dts['ot_planificadas_zia'];
                                            $otrealizadaszia = $dts['ot_realizads_zia'];
                                            $otcreadaszic = $dts['ot_planificadas_zic'];
                                            $otrealizadaszic = $dts['ot_realizadas_zic'];
                                            $otcreadaszie = $dts['ot_planificadas_zie'];
                                            $otrealizadaszie = $dts['ot_realizadas_zie'];
                                            $otcreadaszil = $dts['ot_planificadas_zil'];
                                            $otrealizadaszil = $dts['ot_realizadas_zil'];
                                            $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                            $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                            $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                            $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                            $otcreadasdec = $dts['ot_planificadas_dec'];
                                            $otrealizadasdec = $dts['ot_realizadas_dec'];
                                        }
                                    } else {
                                        $ziacreadomes = 0;
                                        $ziasolmes = 0;
                                        $ziccreadomes = 0;
                                        $zicsolmes = 0;
                                        $ziecreadomes = 0;
                                        $ziesolmes = 0;
                                        $zilcreadomes = 0;
                                        $zilsolmes = 0;
                                        $zhacreadomes = 0;
                                        $zhasolmes = 0;
                                        $zhccreadomes = 0;
                                        $zhcsolmes = 0;
                                        $zhpcreadomes = 0;
                                        $zhpsolmes = 0;
                                        $deccreadomes = 0;
                                        $decsolmes = 0;
                                        $depcreadomes = 0;
                                        $depsolmes = 0;
                                        $autocreadomes = 0;
                                        $autosolmes = 0;

                                        $otcreadaszia = 0;
                                        $otrealizadaszia = 0;
                                        $otcreadaszic = 0;
                                        $otrealizadaszic = 0;
                                        $otcreadaszie = 0;
                                        $otrealizadaszie = 0;
                                        $otcreadaszil = 0;
                                        $otrealizadaszil = 0;
                                        $otcreadaszhc = 0;
                                        $otrealizadaszhc = 0;
                                        $otcreadaszhp = 0;
                                        $otrealizadaszhp = 0;
                                        $otcreadasdec = 0;
                                        $otrealizadasdec = 0;
                                    }
                                    $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                    $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                    $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                    $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                    //porcentaje restante en tareas
                                    if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                        $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                        $porPendiente = 100 - $porcentaje;
                                    } else {
                                        $porPendiente = 0;
                                    }

                                    //Porc de avance en ots
                                    if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                        $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                    } else {
                                        $porcOT = 0;
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                echo "<div class=\"col-4 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row justify-content-center\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\"> </span> CMU</h1>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-6\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes / $totalSolMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porPendiente) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTE DE SOLUCION</p>
                                    </div>
                                    <div class=\"col-6\">
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MANTENIMIENTO PREVENTIVO</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalOTCreadas / $totalOTRealizadas</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porcOT) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>";
                            }

                            if ($idDestinoT == 11) {
                                
                            } else {
                                $query = "SELECT * FROM t_informes_planner WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                try {
                                    $resp = $conn->obtDatos($query);
                                    if ($conn->filasConsultadas > 0) {
                                        foreach ($resp as $dts) {
                                            $ziacreadomes = $dts['zia_creado_mes'];
                                            $ziasolmes = $dts['zia_sol_mes'];
                                            $ziccreadomes = $dts['zic_creado_mes'];
                                            $zicsolmes = $dts['zic_sol_mes'];
                                            $ziecreadomes = $dts['zie_creado_mes'];
                                            $ziesolmes = $dts['zie_sol_mes'];
                                            $zilcreadomes = $dts['zil_creado_mes'];
                                            $zilsolmes = $dts['zil_sol_mes'];
                                            $zhacreadomes = $dts['zha_creado_mes'];
                                            $zhasolmes = $dts['zha_sol_mes'];
                                            $zhccreadomes = $dts['zhc_creado_mes'];
                                            $zhcsolmes = $dts['zhc_sol_mes'];
                                            $zhpcreadomes = $dts['zhp_creado_mes'];
                                            $zhpsolmes = $dts['zhp_sol_mes'];
                                            $deccreadomes = $dts['dec_creado_mes'];
                                            $decsolmes = $dts['dec_sol_mes'];
                                            $depcreadomes = $dts['dep_creado_mes'];
                                            $depsolmes = $dts['dep_sol_mes'];
                                            $autocreadomes = $dts['auto_creado_mes'];
                                            $autosolmes = $dts['auto_sol_mes'];

                                            $otcreadaszia = $dts['ot_planificadas_zia'];
                                            $otrealizadaszia = $dts['ot_realizads_zia'];
                                            $otcreadaszic = $dts['ot_planificadas_zic'];
                                            $otrealizadaszic = $dts['ot_realizadas_zic'];
                                            $otcreadaszie = $dts['ot_planificadas_zie'];
                                            $otrealizadaszie = $dts['ot_realizadas_zie'];
                                            $otcreadaszil = $dts['ot_planificadas_zil'];
                                            $otrealizadaszil = $dts['ot_realizadas_zil'];
                                            $otcreadaszhc = $dts['ot_planificadas_zhc'];
                                            $otrealizadaszhc = $dts['ot_realizadas_zhc'];
                                            $otcreadaszhp = $dts['ot_planificadas_zhp'];
                                            $otrealizadaszhp = $dts['ot_realizadas_zhp'];
                                            $otcreadasdec = $dts['ot_planificadas_dec'];
                                            $otrealizadasdec = $dts['ot_realizadas_dec'];
                                        }
                                    } else {
                                        $ziacreadomes = 0;
                                        $ziasolmes = 0;
                                        $ziccreadomes = 0;
                                        $zicsolmes = 0;
                                        $ziecreadomes = 0;
                                        $ziesolmes = 0;
                                        $zilcreadomes = 0;
                                        $zilsolmes = 0;
                                        $zhacreadomes = 0;
                                        $zhasolmes = 0;
                                        $zhccreadomes = 0;
                                        $zhcsolmes = 0;
                                        $zhpcreadomes = 0;
                                        $zhpsolmes = 0;
                                        $deccreadomes = 0;
                                        $decsolmes = 0;
                                        $depcreadomes = 0;
                                        $depsolmes = 0;
                                        $autocreadomes = 0;
                                        $autosolmes = 0;

                                        $otcreadaszia = 0;
                                        $otrealizadaszia = 0;
                                        $otcreadaszic = 0;
                                        $otrealizadaszic = 0;
                                        $otcreadaszie = 0;
                                        $otrealizadaszie = 0;
                                        $otcreadaszil = 0;
                                        $otrealizadaszil = 0;
                                        $otcreadaszhc = 0;
                                        $otrealizadaszhc = 0;
                                        $otcreadaszhp = 0;
                                        $otrealizadaszhp = 0;
                                        $otcreadasdec = 0;
                                        $otrealizadasdec = 0;
                                    }
                                    $totalCreadoMes = $ziacreadomes + $ziccreadomes + $ziecreadomes + $zilcreadomes + $zhacreadomes + $zhccreadomes + $zhpcreadomes + $deccreadomes + $depcreadomes + $autocreadomes;
                                    $totalSolMes = $ziasolmes + $zicsolmes + $ziesolmes + $zilsolmes + $zhasolmes + $zhcsolmes + $zhpsolmes + $decsolmes + $depsolmes + $autosolmes;

                                    $totalOTCreadas = $otcreadaszia + $otcreadaszic + $otcreadaszie + $otcreadaszil + $otcreadaszhc + $otcreadaszhp + $otcreadasdec;
                                    $totalOTRealizadas = $otrealizadaszia + $otrealizadaszic + $otrealizadaszie + $otrealizadaszil + $otrealizadaszhc + $otrealizadaszhp + $otrealizadasdec;

                                    //porcentaje restante en tareas
                                    if ($totalCreadoMes > 0 && $totalSolMes > 0) {
                                        $porcentaje = ($totalSolMes / $totalCreadoMes) * 100;
                                        $porPendiente = 100 - $porcentaje;
                                    } else {
                                        $porPendiente = 0;
                                    }

                                    //Porc de avance en ots
                                    if ($totalOTCreadas > 0 && $totalOTRealizadas > 0) {
                                        $porcOT = ($totalOTRealizadas / $totalOTCreadas) * 100;
                                    } else {
                                        $porcOT = 0;
                                    }
                                } catch (Exception $ex) {
                                    echo $ex;
                                }

                                echo "<div class=\"col-4 mx-3 rounded-lg mx-2 my-3 bg-white\">
                                <div class=\"row justify-content-center\">
                                    <div class=\"col-12\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\"><span><img src=\"svg/bandera-cap.svg\" height=\"50px\" alt=\"\"> </span> CAP</h1>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-6\">
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES CREADOS ESTE MES</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalCreadoMes / $totalSolMes</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTES / SOLUCIONADOS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porPendiente) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">PENDIENTE DE SOLUCION</p>
                                    </div>
                                    <div class=\"col-6\">
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MANTENIMIENTO PREVENTIVO</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$totalOTCreadas / $totalOTRealizadas</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">OT PLANIFICADAS / OT REALIZADAS</p>
                                        <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">" . round($porcOT) . "%</h1>
                                        <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">CUMPLIMIENTO PLANEACION</p>
                                    </div>
                                </div>
                            </div>";
                            }
                            ?>

                            <!--                            <div class="col-4 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/bandera-pvr.svg" height="50px" alt=""> </span> PVR</h1>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">81</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES CREADOS ESTE MES</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">81 / 30</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES / SOLUCIONADOS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">27%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MANTENIMIENTO PREVENTIVO</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0 / 0</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-4 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/bandera-cmu.svg" height="50px" alt=""> </span> CMU</h1>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">50</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES CREADOS ESTE MES</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">50 / 20</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES / SOLUCIONADOS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">29%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MANTENIMIENTO PREVENTIVO</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0 / 0</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-4 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/bandera-mbj.svg" height="50px" alt=""> </span> MBJ</h1>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">368</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES CREADOS ESTE MES</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">368 / 326</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES / SOLUCIONADOS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">47%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MANTENIMIENTO PREVENTIVO</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0 / 0</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-4 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/bandera-puj.svg" height="50px" alt=""> </span> PUJ</h1>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">11</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES CREADOS ESTE MES</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">11 / 3</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES / SOLUCIONADOS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">21%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MANTENIMIENTO PREVENTIVO</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0 / 0</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-4 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/bandera-sdq.svg" height="50px" alt=""> </span> SDQ</h1>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">10</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES CREADOS ESTE MES</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">10 / 0</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES / SOLUCIONADOS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MANTENIMIENTO PREVENTIVO</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0 / 0</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-4 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/bandera-cap.svg" height="50px" alt=""> </span> CAP</h1>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">7</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES CREADOS ESTE MES</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">7 / 2</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES / SOLUCIONADOS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">22%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MANTENIMIENTO PREVENTIVO</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0 / 0</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-4 mx-3 rounded-lg mx-2 my-3 bg-white">
                                                            <div class="row justify-content-center">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><span><img src="svg/bandera-ssa.svg" height="50px" alt=""> </span> SSA</h1>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">7</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES CREADOS ESTE MES</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">7 / 5</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTES / SOLUCIONADOS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">42%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">PENDIENTE DE SOLUCION</p>
                                                                </div>
                                                                <div class="col-6">
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">MANTENIMIENTO PREVENTIVO</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0 / 0</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">OT PLANIFICADAS / OT REALIZADAS</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0">0%</h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">CUMPLIMIENTO PLANEACION</p>
                                                                </div>
                                                            </div>
                                                        </div>-->

                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="container-fluid">
                        <div class="row">
                            <h1 class="mn-bold texto-negro fs-28 ml-4 my-4">Satisfaccion Gift</h1>
                        </div>
                        <div class="row justify-content-center">

                            <?php
                            $monthAnt = date("F", strtotime("- 2 month"));
                            switch ($monthAnt) {
                                case 'January':
                                    $mesAnt = "ENERO";
                                    break;
                                case 'February':
                                    $mesAnt = "FEBRERO";
                                    break;
                                case 'March':
                                    $mesAnt = "MARZO";
                                    break;
                                case 'April':
                                    $mesAnt = "ABRIL";
                                    break;
                                case 'May':
                                    $mesAnt = "MAYO";
                                    break;
                                case 'June':
                                    $mesAnt = "JUNIO";
                                    break;
                                case 'July':
                                    $mesAnt = "JULIO";
                                    break;
                                case 'August':
                                    $mesAnt = "AGOSTO";
                                    break;
                                case 'September':
                                    $mesAnt = "SEPTIEMBRE";
                                    break;
                                case 'October':
                                    $mesAnt = "OCTUBRE";
                                    break;
                                case 'November':
                                    $mesAnt = "NOVIEMBRE";
                                    break;
                                case 'December':
                                    $mesAnt = "DICIEMBRE";
                                    break;
                            }
                            $query = "SELECT * FROM t_informes_gift "
                                    . "WHERE id_destino = $idDestinoT AND mes = '$mes' AND year = $año";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $tip1 = $dts['tipificacion1'];
                                        $cant1 = $dts['cantidad1'];
                                        $cant1MesAnt = $dts['mesant1'];
                                        $cant1AñoAnt = $dts['anoant1'];
                                        $tip2 = $dts['tipificacion2'];
                                        $cant2 = $dts['cantidad2'];
                                        $cant2MesAnt = $dts['mesant2'];
                                        $cant2AñoAnt = $dts['anoant2'];
                                        $tip3 = $dts['tipificacion3'];
                                        $cant3 = $dts['cantidad3'];
                                        $cant3MesAnt = $dts['mesant3'];
                                        $cant3AñoAnt = $dts['anoant3'];
                                        $tip4 = $dts['tipificacion4'];
                                        $cant4 = $dts['cantidad4'];
                                        $cant4MesAnt = $dts['mesant4'];
                                        $cant4AñoAnt = $dts['anoant4'];
                                        $tip5 = $dts['tipificacion5'];
                                        $cant5 = $dts['cantidad5'];
                                        $cant5MesAnt = $dts['mesant5'];
                                        $cant5AñoAnt = $dts['anoant5'];

                                        $tiempMedioSolucion = $dts['tiempo_medio_solucion'];
                                        $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                        $tiempoMedioSolucionTRS = $dts['tiempo_medio_solucion_trs'];
                                        $tiempoMedioAsignacionTRS = $dts['tiempo_medio_asignacion_trs'];
                                        $tiempoMedioSolucionGP = $dts['tiempo_medio_solucion_gp'];
                                        $tiempoMedioAsignacionGP = $dts['tiempo_medio_asignacion_gp'];
                                    }
                                } else {
                                    $tip1 = "";
                                    $cant1 = 0;
                                    $cant1MesAnt = 0;
                                    $cant1AñoAnt = 0;
                                    $tip2 = "";
                                    $cant2 = 0;
                                    $cant2MesAnt = 0;
                                    $cant2AñoAnt = 0;
                                    $tip3 = "";
                                    $cant3 = 0;
                                    $cant3MesAnt = 0;
                                    $cant3AñoAnt = 0;
                                    $tip4 = "";
                                    $cant4 = 0;
                                    $cant4MesAnt = 0;
                                    $cant4AñoAnt = 0;
                                    $tip5 = "";
                                    $cant5 = 0;
                                    $cant5MesAnt = 0;
                                    $cant5AñoAnt = 0;

                                    $tiempMedioSolucion = 0;
                                    $tiempoMedioAsignacion = 0;
                                    $tiempoMedioSolucionTRS = 0;
                                    $tiempoMedioAsignacionTRS = 0;
                                    $tiempoMedioSolucionGP = 0;
                                    $tiempoMedioAsignacionGP = 0;
                                }
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                            ?>

                            <div class="col-6 bg-white rounded-lg shadow-sm mx-3" data-toggle="collapse" href="#ocultogift" role="button" aria-expanded="false" aria-controls="ocultogift">
                                <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">TOP 5 COMPLEJO</h1>
                                <table class="table table-borderless text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">TIPIFICACION</th>
                                            <th scope="col">ESTE MES</th>
                                            <th scope="col">MES ANTERIOR</th>
                                            <th scope="col">AÑO ANTERIOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td class="text-left"><?php echo $tip1; ?></td>
                                            <td><?php echo $cant1; ?></td>
                                            <td><?php echo $cant1MesAnt; ?> </td>
                                            <td><?php echo $cant1AñoAnt; ?> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td class="text-left"><?php echo $tip2; ?></td>
                                            <td><?php echo $cant2; ?></td>
                                            <td><?php echo $cant2MesAnt; ?> </td>
                                            <td><?php echo $cant2AñoAnt; ?> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td class="text-left"><?php echo $tip3; ?></td>
                                            <td><?php echo $cant3; ?></td>
                                            <td><?php echo $cant3MesAnt; ?> </td>
                                            <td><?php echo $cant3AñoAnt; ?> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td class="text-left"><?php echo $tip4; ?></td>
                                            <td><?php echo $cant4; ?></td>
                                            <td><?php echo $cant4MesAnt; ?> </td>
                                            <td><?php echo $cant4AñoAnt; ?> </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td class="text-left"><?php echo $tip5; ?></td>
                                            <td><?php echo $cant5; ?></td>
                                            <td><?php echo $cant5MesAnt; ?> </td>
                                            <td><?php echo $cant5AñoAnt; ?> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg my-3">
                                <div class="row">
                                    <div class="col-12 card-header border-0 bg-white mb-2 mt-4 text-center">
                                        <img class="mt-2" src="svg/gpl.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioSolucionGP; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE SOLUCIÓN</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioAsignacionGP; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if ($trs == "SI"):
                                ?>
                                <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg my-3">
                                    <div class="row">
                                        <div class="col-12 card-header border-0 bg-white mb-2 mt-4 text-center">
                                            <img class="mt-2" src="svg/trsl.svg" height="50px" alt="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioSolucionTRS; ?></h1>
                                            <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioAsignacionTRS; ?></h1>
                                            <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                            ?>

                        </div>

                        <div class="container-fluid scroll-horizontal collapse bg-dark" id="ocultogift">
                            <div class="row flex-nowrap">

                                <?php
                                if ($idDestinoT == 1) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-rm.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">RM</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 2) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 2 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-pvr.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 3) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 3 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-sdq.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }
                                if ($idDestinoT == 4) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 4 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-ssa.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }
                                if ($idDestinoT == 5) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 5 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-puj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 6) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 6 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-mbj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 7) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 7 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 11) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 11 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cap.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }
                                ?>




                            </div>

                            <div class="row mt-3">
                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS AGUA HELADA</h1>
                                    <canvas id="chart-aa" height="200px"></canvas>
                                </div>
                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS AGUA HELADA HABITACION</h1>
                                    <canvas id="chart-aa-hab" height="200px"></canvas>
                                </div>
                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS AGUA CALIENTE</h1>
                                    <canvas id="chart-acs" height="200px"></canvas>
                                </div>
                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS AGUA CALIENTE HABITACION</h1>
                                    <canvas id="chart-acs-hab" height="200px"></canvas>
                                </div>
                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERIAS HUMEDAD</h1>
                                    <canvas id="chart-humedad" height="200px"></canvas>
                                </div>
                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERIAS HUMEDAD HABITACION</h1>
                                    <canvas id="chart-humedad-hab" height="200px"></canvas>
                                </div>
                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS FRIGOBAR</h1>
                                    <canvas id="chart-frigos" height="200px"></canvas>
                                </div>
                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS FRIGOBAR HABITACION</h1>
                                    <canvas id="chart-frigos-hab" height="200px"></canvas>
                                </div>

                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS TV</h1>
                                    <canvas id="chart-tv" height="200px"></canvas>
                                </div>

                                <div class="col-6 bg-white rounded-lg mx-0 my-3">
                                    <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS TV HABITACION</h1>
                                    <canvas id="chart-tv-hab" height="200px"></canvas>
                                </div>
                            </div>
                        </div>

                        <!--                        <div class="row justify-content-around">
                        
                                                    <div class="col-3 bg-white mt-4 text-center">
                                                        <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS AGUA HELADA</h1>
                                                        <canvas id="chartjs-aa" class="chartjs" width="1155" height="577"></canvas>
                                                    </div>
                        
                                                    <div class="col-3 bg-white mt-4 text-center">
                                                        <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">AVERÍAS AGUA CALIENTE</h1>
                                                        <canvas id="chartjs-ac" class="chartjs" width="1155" height="577"></canvas>
                                                    </div>
                        
                                                </div>-->
                    </div>

                    <hr class="my-4">


                    <div class="container-fluid">
                        <div class="row">
                            <h1 class="mn-bold texto-negro fs-28 ml-4 my-4">Gift Cocinas</h1>
                        </div>
                        <div class="row justify-content-center" data-toggle="collapse" href="#ocultogiftcocinas" role="button" aria-expanded="false" aria-controls="ocultogiftcocinas">
                            <?php
                            $monthAnt = date("F", strtotime("- 2 month"));
                            switch ($monthAnt) {
                                case 'January':
                                    $mesAnt = "ENERO";
                                    break;
                                case 'February':
                                    $mesAnt = "FEBRERO";
                                    break;
                                case 'March':
                                    $mesAnt = "MARZO";
                                    break;
                                case 'April':
                                    $mesAnt = "ABRIL";
                                    break;
                                case 'May':
                                    $mesAnt = "MAYO";
                                    break;
                                case 'June':
                                    $mesAnt = "JUNIO";
                                    break;
                                case 'July':
                                    $mesAnt = "JULIO";
                                    break;
                                case 'August':
                                    $mesAnt = "AGOSTO";
                                    break;
                                case 'September':
                                    $mesAnt = "SEPTIEMBRE";
                                    break;
                                case 'October':
                                    $mesAnt = "OCTUBRE";
                                    break;
                                case 'November':
                                    $mesAnt = "NOVIEMBRE";
                                    break;
                                case 'December':
                                    $mesAnt = "DICIEMBRE";
                                    break;
                            }
                            $query = "SELECT * FROM t_informes_gift_cocinas WHERE id_destino = $idDestinoT AND mes = '$mes' AND year = $año";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $equipo1 = $dts['equipo1'];
                                        $cant1 = $dts['cantidad1'];
                                        $cant1MesAnt = $dts['mesant1'];
                                        $equipo2 = $dts['equipo2'];
                                        $cant2 = $dts['cantidad2'];
                                        $cant2MesAnt = $dts['mesant2'];
                                        $equipo3 = $dts['equipo3'];
                                        $cant3 = $dts['cantidad3'];
                                        $cant3MesAnt = $dts['mesant3'];
                                        $equipo4 = $dts['equipo4'];
                                        $cant4 = $dts['cantidad4'];
                                        $cant4MesAnt = $dts['mesant4'];
                                        $equipo5 = $dts['equipo5'];
                                        $cant5 = $dts['cantidad5'];
                                        $cant5MesAnt = $dts['mesant5'];
                                        
                                         
                                        $instalacion1 = $dts['instalacion1'];
                                        $cantInst1 = $dts['cantinst1'];
                                        $cantInst1MesAnt = $dts['mesinstant1'];
                                        $instalacion2 = $dts['instalacion2'];
                                        $cantInst2 = $dts['cantinst2'];
                                        $cantInst2MesAnt = $dts['mesinstant2'];
                                        $instalacion3 = $dts['instalacion3'];
                                        $cantInst3 = $dts['cantinst3'];
                                        $cantInst3MesAnt = $dts['mesinstant3'];
                                        $instalacion4 = $dts['instalacion4'];
                                        $cantInst4 = $dts['cantinst4'];
                                        $cantInst4MesAnt = $dts['mesinstant4'];
                                        $instalacion5 = $dts['instalacion5'];
                                        $cantInst5 = $dts['cantinst5'];
                                        $cantInst5MesAnt = $dts['mesinstant5'];
                                        

                                        $tiempMedioSolucion = $dts['tiempo_medio_solucion'];
                                        $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                        $tiempoMedioSolucionTRS = $dts['tiempo_medio_solucion_trs'];
                                        $tiempoMedioAsignacionTRS = $dts['tiempo_medio_asignacion_trs'];
                                        $tiempoMedioSolucionGP = $dts['tiempo_medio_solucion_gp'];
                                        $tiempoMedioAsignacionGP = $dts['tiempo_medio_asignacion_gp'];
                                    }
                                } else {
                                    $equipo1 = "";
                                    $cant1 = 0;
                                    $cant1MesAnt = 0;
                                    $equipo2 = "";
                                    $cant2 = 0;
                                    $cant2MesAnt = 0;
                                    $equipo3 = "";
                                    $cant3 = 0;
                                    $cant3MesAnt = 0;
                                    $equipo4 = "";
                                    $cant4 = 0;
                                    $cant4MesAnt = 0;
                                    $equipo5 = "";
                                    $cant5 = 0;
                                    $cant5MesAnt = 0;
                                    $instalacion1 = "";
                                    $cantInst1 = 0;
                                    $cantInst1MesAnt = 0;
                                    $instalacion2 = "";
                                    $cantInst2 = 0;
                                    $cantInst2MesAnt = 0;
                                    $instalacion3 = "";
                                    $cantInst3 = 0;
                                    $cantInst3MesAnt = 0;
                                    $instalacion4 = "";
                                    $cantInst4 = 0;
                                    $cantInst4MesAnt = 0;
                                    $instalacion5 = "";
                                    $cantInst5 = 0;
                                    $cantInst5MesAnt = 0;

                                    $tiempMedioSolucion = 0;
                                    $tiempoMedioAsignacion = 0;
                                    $tiempoMedioSolucionTRS = 0;
                                    $tiempoMedioAsignacionTRS = 0;
                                    $tiempoMedioSolucionGP = 0;
                                    $tiempoMedioAsignacionGP = 0;
                                }
                            } catch (Exception $ex) {
                                echo $ex;
                            }
                            ?>

                            <div class="col-5 bg-white rounded-lg shadow-sm mx-3">
                                <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">EQUIPOS MAS REPORTADOS</h1>
                                <table class="table table-borderless text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">TIPIFICACION</th>
                                            <th scope="col">ESTE MES</th>
                                            <th scope="col">MES ANTERIOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td class="text-left"><?php echo $equipo1; ?></td>
                                            <td><?php echo $cant1; ?></td>
                                            <td><?php echo $cant1MesAnt; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td class="text-left"><?php echo $equipo2; ?></td>
                                            <td><?php echo $cant2; ?></td>
                                            <td><?php echo $cant2MesAnt; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td class="text-left"><?php echo $equipo3; ?></td>
                                            <td><?php echo $cant3; ?></td>
                                            <td><?php echo $cant3MesAnt; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td class="text-left"><?php echo $equipo4; ?></td>
                                            <td><?php echo $cant4; ?></td>
                                            <td><?php echo $cant4MesAnt; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td class="text-left"><?php echo $equipo5; ?></td>
                                            <td><?php echo $cant5; ?></td>
                                            <td><?php echo $cant5MesAnt; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-5 bg-white rounded-lg shadow-sm mx-3">
                                <h1 class="card-title fs-22 mn-bold texto-negro text-center mt-3">INSTALACIONES MAS REPORTADAS</h1>
                                <table class="table table-borderless text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">TIPIFICACION</th>
                                            <th scope="col">ESTE MES</th>
                                            <th scope="col">MES ANTERIOR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">1</th>
                                            <td class="text-left"><?php echo $instalacion1; ?></td>
                                            <td><?php echo $cantInst1; ?></td>
                                            <td><?php echo $cantInst1MesAnt; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">2</th>
                                            <td class="text-left"><?php echo $instalacion2; ?></td>
                                            <td><?php echo $cantInst2; ?></td>
                                            <td><?php echo $cantInst2MesAnt; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">3</th>
                                            <td class="text-left"><?php echo $instalacion3; ?></td>
                                            <td><?php echo $cantInst3; ?></td>
                                            <td><?php echo $cantInst3MesAnt; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">4</th>
                                            <td class="text-left"><?php echo $instalacion4; ?></td>
                                            <td><?php echo $cantInst4; ?></td>
                                            <td><?php echo $cantInst4MesAnt; ?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">5</th>
                                            <td class="text-left"><?php echo $instalacion5; ?></td>
                                            <td><?php echo $cantInst5; ?></td>
                                            <td><?php echo $cantInst5MesAnt; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg my-3">
                                <div class="row">
                                    <div class="col-12 card-header border-0 bg-white mb-2 mt-4 text-center">
                                        <img class="mt-2" src="svg/gpl.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioSolucionGP; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE SOLUCIÓN</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioAsignacionGP; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg my-3">
                                <div class="row">
                                    <div class="col-12 card-header border-0 bg-white mb-2 mt-4 text-center">
                                        <img class="mt-2" src="svg/trsl.svg" height="50px" alt="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioSolucionTRS; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE SOLUCIÓN</p>
                                        <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioAsignacionTRS; ?></h1>
                                        <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                    </div>
                                </div>
                            </div>

                            <!--                            <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg my-3">
                                                            <div class="row">
                                                                <div class="col-12 card-header border-0 bg-white mb-2 mt-4 text-center">
                                                                    <img class="mt-2" src="svg/gpl.svg" height="50px" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioSolucionGP; ?></h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE SOLUCIÓN</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioAsignacionGP; ?></h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                                                </div>
                                                            </div>
                                                        </div>
                            
                                                        <div class="col-2 shadow-sm bg-white mx-3 hvr-float rounded-lg my-3">
                                                            <div class="row">
                                                                <div class="col-12 card-header border-0 bg-white mb-2 mt-4 text-center">
                                                                    <img class="mt-2" src="svg/trsl.svg" height="50px" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioSolucionTRS; ?></h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE SOLUCIÓN</p>
                                                                    <h1 class="card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0"><?php echo $tiempoMedioAsignacionTRS; ?></h1>
                                                                    <p class="texto-gris text-center fs-12 mt-0 py-0 mn-bold">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                                                </div>
                                                            </div>
                                                        </div>-->

                        </div>

                        <div class="container-fluid scroll-horizontal collapse bg-dark" id="ocultogiftcocinas">
                            <div class="row flex-nowrap">

                                <?php
                                if ($idDestinoT == 1) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 1 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-rm.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">RM</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 2) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 2 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-pvr.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PVR</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 3) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 3 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-sdq.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SDQ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }
                                if ($idDestinoT == 4) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 4 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-ssa.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">SSA</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }
                                if ($idDestinoT == 5) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 5 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-puj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">PUJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 6) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 6 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-mbj.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">MBJ</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 7) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 7 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cmu.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CMU</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }

                                if ($idDestinoT == 11) {
                                    
                                } else {
                                    $query = "SELECT * FROM t_informes_gift WHERE id_destino = 11 AND mes = '$mes' AND year = $año";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $tiempoMedioSolucion = $dts['tiempo_medio_solucion'];
                                                $tiempoMedioAsignacion = $dts['tiempo_medio_asignacion'];
                                            }
                                        } else {
                                            $tiempoMedioSolucion = 0;
                                            $tiempoMedioAsignacion = 0;
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "<div class=\"col-2 shadow-sm bg-white mx-3 my-4 hvr-float rounded-lg mx-2\">
                                    <div class=\"row\">
                                        <div class=\"col-12 card-header border-0 bg-white mb-2 text-center\">
                                            <img class=\"mt-2\" src=\"svg/bandera-cap.svg\" height=\"50px\" alt=\"\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">CAP</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">MES ACTUAL</p>
                                        </div>
                                    </div>

                                    <div class=\"row\">
                                        <div class=\"col-12\">
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempMedioSolucion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE SOLUCIÓN</p>
                                            <h1 class=\"card-title fs-24 mn-bold texto-negro text-center mb-0 pb-0\">$tiempoMedioAsignacion</h1>
                                            <p class=\"texto-gris text-center fs-12 mt-0 py-0 mn-bold\">TIEMPO MEDIO DE ASIGNACIÓN</p>
                                        </div>
                                    </div>

                                </div>";
                                }
                                ?>
                            </div>


                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <h1 class="mn-bold texto-negro fs-28 ml-4 my-4">Anticipación</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row justify-content-center">
                                    <div class="col-5 bg-white rounded-lg mx-1 my-1">
                                        <label>RM</label>
                                        <canvas id="myChart1" width="100%" height="50px"></canvas>
                                    </div>
                                    <div class="col-5 bg-white rounded-lg mx-1 my-1">
                                        <label>PVR</label>
                                        <canvas id="myChart2" width="100%" height="50px"></canvas>
                                    </div>
                                    <div class="col-5 bg-white rounded-lg mx-1 my-1">
                                        <label>SDQ</label>
                                        <canvas id="myChart3" width="100%" height="50px"></canvas>
                                    </div>
                                    <div class="col-5 bg-white rounded-lg mx-1 my-1">
                                        <label>SSA</label>
                                        <canvas id="myChart4" width="100%" height="50px"></canvas>
                                    </div>
                                    <div class="col-5 bg-white rounded-lg mx-1 my-1">
                                        <label>PUJ</label>
                                        <canvas id="myChart5" width="100%" height="50px"></canvas>
                                    </div>
                                    <div class="col-5 bg-white rounded-lg mx-1 my-1">
                                        <label>MBJ</label>
                                        <canvas id="myChart6" width="100%" height="50px"></canvas>
                                    </div>
                                    <div class="col-5 bg-white rounded-lg mx-1 my-1">
                                        <label>CMU</label>
                                        <canvas id="myChart7" width="100%" height="50px"></canvas>
                                    </div>
                                    <div class="col-5 bg-white rounded-lg mx-1 my-1">
                                        <label>CAP</label>
                                        <canvas id="myChart11" width="100%" height="50px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--content-->
                </div>

                <!--Modal logout-->
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
        </div>



    </body>
    <?php echo $layout->scripts(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <script src="js/moment.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.js"></script>
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
                                        }, 800);
                                        $('#sidebarCollapse').on('click', function () {
                                            //$('#sidebar').toggleClass('active');
                                            $(this).toggleClass('active');
                                        });
                                        $("#sidebar").mCustomScrollbar({
                                            theme: "minimal-dark"
                                        });
                                        $('#sidebarCollapse').on('click', function () {
                                            $('#sidebar, #content').toggleClass('active');
                                            $('.collapse.in').toggleClass('in');
                                            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                                        });
                                        $('[data-toggle="tooltip"]').tooltip();
                                    });
    </script>

    <?php
    $query = "SELECT * FROM t_informes_energeticos WHERE year = '$año' AND id_destino = $idDestinoT";

    try {
        $lstInfo = $conn->obtDatos($query);
    } catch (Exception $ex) {
        echo $ex;
    }

    $query = "SELECT * FROM t_informes_energeticos WHERE year = '$añoAnt' AND id_destino = $idDestinoT";

    try {
        $lstInfoAnt = $conn->obtDatos($query);
    } catch (Exception $ex) {
        echo $ex;
    }
    ?>


    <script>
        var ctx = document.getElementById("chart1");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
<?php
foreach ($lstInfo as $m) {
    echo "'" . $m['mes'] . "',";
}
?>
                ],
                datasets: [{
                        label: 'Ratio',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
foreach ($lstInfo as $m) {
    echo "" . $m['agua'] . ",";
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'Ratio ideal',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
foreach ($lstInfo as $m) {
    echo "" . $m['ratio_agua'] . ",";
}
?>
                        ],
                    }, {
                        label: 'Ratio año anterior',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
foreach ($lstInfoAnt as $m) {
    echo "" . $m['ratio_agua'] . ",";
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
//                        title: {
//                            display: false,
//                            text: 'Min and Max Settings'
//                        },
//                        scales: {
//                            yAxes: [{
//                                    ticks: {
//                                        min: 0,
//                                        max: 5
//                                    }
//                                }]
//                        }
            }

        });

        var ctx = document.getElementById("chart2");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
<?php
foreach ($lstInfo as $m) {
    echo "'" . $m['mes'] . "',";
}
?>
                ],
                datasets: [{
                        label: 'Ratio',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
foreach ($lstInfo as $m) {
    echo "" . $m['electricidad'] . ",";
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'Ratio ideal',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
foreach ($lstInfo as $m) {
    echo "" . $m['ratio_electricidad'] . ",";
}
?>
                        ],
                    }, {
                        label: 'Ratio año anterior',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
foreach ($lstInfoAnt as $m) {
    echo "" . $m['ratio_electricidad'] . ",";
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
//                        title: {
//                            display: false,
//                            text: 'Min and Max Settings'
//                        },
//                        scales: {
//                            yAxes: [{
//                                    ticks: {
//                                        min: 0,
//                                        max: 5
//                                    }
//                                }]
//                        }
            }

        });

        var ctx = document.getElementById("chart3");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
<?php
foreach ($lstInfo as $m) {
    echo "'" . $m['mes'] . "',";
}
?>
                ],
                datasets: [{
                        label: 'Ratio',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
foreach ($lstInfo as $m) {
    echo "" . $m['gas'] . ",";
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'Ratio ideal',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
foreach ($lstInfo as $m) {
    echo "" . $m['ratio_gas'] . ",";
}
?>
                        ],
                    }, {
                        label: 'Ratio año anterior',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
foreach ($lstInfoAnt as $m) {
    echo "" . $m['ratio_gas'] . ",";
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
//                        title: {
//                            display: false,
//                            text: 'Min and Max Settings'
//                        },
//                        scales: {
//                            yAxes: [{
//                                    ticks: {
//                                        min: 0,
//                                        max: 5
//                                    }
//                                }]
//                        }
            }

        });

        var ctx = document.getElementById("chart4");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
<?php
foreach ($lstInfo as $m) {
    echo "'" . $m['mes'] . "',";
}
?>
                ],
                datasets: [{
                        label: 'Ratio',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
foreach ($lstInfo as $m) {
    echo "" . $m['diesel'] . ",";
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'Ratio ideal',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
foreach ($lstInfo as $m) {
    echo "" . $m['ratio_diesel'] . ",";
}
?>
                        ],
                    }, {
                        label: 'Ratio año anterior',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
foreach ($lstInfoAnt as $m) {
    echo "" . $m['ratio_diesel'] . ",";
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
//                        title: {
//                            display: false,
//                            text: 'Min and Max Settings'
//                        },
//                        scales: {
//                            yAxes: [{
//                                    ticks: {
//                                        min: 0,
//                                        max: 5
//                                    }
//                                }]
//                        }
            }

        });
    </script>

    <script>

        var ctx = document.getElementById("chart-aa");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-aa-hab");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa_hab WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa_hab WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa_hab WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa_hab WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa_hab WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa_hab WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa_hab WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_aa_hab WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-acs");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-acs-hab");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs_hab WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs_hab WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs_hab WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs_hab WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs_hab WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs_hab WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs_hab WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_acs_hab WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-humedad");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-humedad-hab");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad_hab WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad_hab WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad_hab WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad_hab WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad_hab WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad_hab WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad_hab WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_humedad_hab WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-frigos");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-frigos-hab");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos_hab WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos_hab WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos_hab WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos_hab WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos_hab WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos_hab WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos_hab WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_frigos_hab WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-tv");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

        var ctx = document.getElementById("chart-tv-hab");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'RM',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv_hab WHERE id_destino = 1 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'CMU',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv_hab WHERE id_destino = 7 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'PVR',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv_hab WHERE id_destino = 2 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'MBJ',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv_hab WHERE id_destino = 6 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'PUJ',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv_hab WHERE id_destino = 5 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'CAP',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv_hab WHERE id_destino = 11 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SDQ',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv_hab WHERE id_destino = 3 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'SSA',
                        fill: false,
                        backgroundColor: "rgba(255, 232, 0, 1)",
                        borderColor: "rgba(255, 232, 0, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_informes_tv_hab WHERE id_destino = 4 AND year = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            echo "" . $dts['enero'] . ", " . $dts['febrero'] . ", " . $dts['marzo'] . ", " . $dts['abril'] . ", " . $dts['mayo'] . ", " . $dts['junio'] . ", " . $dts['julio'] . ", " . $dts['agosto'] . ", " . $dts['septiembre'] . ", " . $dts['octubre'] . ", " . $dts['noviembre'] . ", " . $dts['diciembre'] . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }]
            },
            options: {
                responsive: true,
            }

        });

    </script>

    <!--RM-->
    <script>
        var ctx = document.getElementById("myChart1");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'GP',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 1 AND departamento = 'GP' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {

            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            }
            if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            }
            if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            }
            if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            }
            if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            }
            if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            }
            if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            }
            if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            }
            if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            }
            if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            }
            if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            }
            if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }

            //echo "" . round($dts['enero']*100) . ", " . round($dts['febrero']*100) . ", " . round($dts['marzo']*100) . ", " . round($dts['abril']*100) . ", " . round($dts['mayo']*100) . ", " . round($dts['junio']*100) . ", " . round($dts['julio']*100) . ", " . round($dts['agosto']*100) . ", " . round($dts['septiembre']*100) . ", " . round($dts['octubre']*100) . ", " . round($dts['noviembre']*100) . ", " . round($dts['diciembre']*100) . "";
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'GP GIFT',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 1 AND departamento = 'GP GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            }
            if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            }
            if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            }
            if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            }
            if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            }
            if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            }
            if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            }
            if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            }
            if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            }
            if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            }
            if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            }
            if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'GP COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 1 AND departamento = 'GP COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            }
            if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            }
            if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            }
            if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            }
            if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            }
            if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            }
            if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            }
            if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            }
            if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            }
            if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            }
            if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            }
            if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 1 AND departamento = 'TRS' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            }
            if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            }
            if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            }
            if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            }
            if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            }
            if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            }
            if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            }
            if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            }
            if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            }
            if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            }
            if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            }
            if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS GIFT',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 1 AND departamento = 'TRS GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            }
            if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            }
            if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            }
            if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            }
            if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            }
            if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            }
            if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            }
            if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            }
            if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            }
            if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            }
            if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            }
            if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 1 AND departamento = 'TRS COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            }
            if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            }
            if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            }
            if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            }
            if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            }
            if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            }
            if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            }
            if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            }
            if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            }
            if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            }
            if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            }
            if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'ZONA IND.',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 1 AND departamento = 'ZONA IND' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            }
            if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            }
            if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            }
            if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            }
            if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            }
            if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            }
            if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            }
            if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            }
            if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            }
            if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            }
            if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            }
            if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, ]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + "%" || '';
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value + "%";
                                }
                            }
                        }]
                }
            }

        });
<?php
$conn->cerrar();
?>
    </script>

    <!--PVR-->
    <script>
        var ctx = document.getElementById("myChart2");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'GP',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 2 AND departamento = 'GP' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'GP GIFT',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 2 AND departamento = 'GP GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'GP COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 2 AND departamento = 'GP COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'ZONA IND.',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 2 AND departamento = 'ZONA IND' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, ]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + "%" || '';
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value + "%";
                                }
                            }
                        }]
                }
            }

        });
<?php
$conn->cerrar();
?>
    </script>

    <!--SDQ-->
    <script>
        var ctx = document.getElementById("myChart3");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'GP',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 3 AND departamento = 'GP' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'GP GIFT',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 3 AND departamento = 'GP GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'GP COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 3 AND departamento = 'GP COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'ZONA IND.',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 3 AND departamento = 'ZONA IND' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, ]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + "%" || '';
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value + "%";
                                }
                            }
                        }]
                }
            }

        });
<?php
$conn->cerrar();
?>
    </script>

    <!--SSA-->
    <script>
        var ctx = document.getElementById("myChart4");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'GP',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 4 AND departamento = 'GP' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'GP GIFT',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 4 AND departamento = 'GP GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'GP COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 4 AND departamento = 'GP COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'ZONA IND.',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 4 AND departamento = 'ZONA IND' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, ]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + "%" || '';
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value + "%";
                                }
                            }
                        }]
                }
            }

        });
<?php
$conn->cerrar();
?>
    </script>

    <!--PUJ-->
    <script>
        var ctx = document.getElementById("myChart5");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'GP',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 5 AND departamento = 'GP' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'GP GIFT',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 5 AND departamento = 'GP GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'GP COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 5 AND departamento = 'GP COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 5 AND departamento = 'TRS' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS GIFT',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 5 AND departamento = 'TRS GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 5 AND departamento = 'TRS COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'ZONA IND.',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 5 AND departamento = 'ZONA IND' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, ]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + "%" || '';
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value + "%";
                                }
                            }
                        }]
                }
            }

        });
<?php
$conn->cerrar();
?>
    </script>

    <!--MBJ-->
    <script>
        var ctx = document.getElementById("myChart6");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'GP',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 6 AND departamento = 'GP' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'GP GIFT',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 6 AND departamento = 'GP GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'GP COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 6 AND departamento = 'GP COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'ZONA IND.',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 6 AND departamento = 'ZONA IND' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, ]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + "%" || '';
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value + "%";
                                }
                            }
                        }]
                }
            }

        });
<?php
$conn->cerrar();
?>
    </script>

    <!--CMU-->
    <script>
        var ctx = document.getElementById("myChart7");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'GP',
                        backgroundColor: "rgba(255, 39, 137, 1)",
                        borderColor: "rgba(255, 39, 137, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 7 AND departamento = 'GP' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                        fill: false,
                    }, {
                        label: 'GP GIFT',
                        fill: false,
                        backgroundColor: "rgba(0, 123, 255, 1)",
                        borderColor: "rgba(0, 123, 255, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 7 AND departamento = 'GP GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],
                    }, {
                        label: 'GP COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 181, 133, 1)",
                        borderColor: "rgba(0, 181, 133, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 7 AND departamento = 'GP COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 7 AND departamento = 'TRS' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS GIFT',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 7 AND departamento = 'TRS GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 7 AND departamento = 'TRS COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'ZONA IND.',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 7 AND departamento = 'ZONA IND' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, ]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + "%" || '';
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value + "%";
                                }
                            }
                        }]
                }
            }

        });
<?php
$conn->cerrar();
?>
    </script>

    <!--CAP-->
    <script>
        var ctx = document.getElementById("myChart11");
        var myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: ['ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE'],
                datasets: [{
                        label: 'TRS',
                        fill: false,
                        backgroundColor: "rgba(114, 33, 126, 1)",
                        borderColor: "rgba(114, 33, 126, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 11 AND departamento = 'TRS' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS GIFT',
                        fill: false,
                        backgroundColor: "rgba(255, 40, 164, 1)",
                        borderColor: "rgba(255, 40, 164, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 11 AND departamento = 'TRS GIFT' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'TRS COBARE',
                        fill: false,
                        backgroundColor: "rgba(0, 203, 244, 1)",
                        borderColor: "rgba(0, 203, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 11 AND departamento = 'TRS COBARE' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, {
                        label: 'ZONA IND.',
                        fill: false,
                        backgroundColor: "rgba(255, 151, 244, 1)",
                        borderColor: "rgba(255, 151, 244, 1)",
                        data: [
<?php
$query = "SELECT * FROM t_anticipacion WHERE id_destino = 11 AND departamento = 'ZONA IND' AND año = '$año'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            if ($dts['enero'] != null) {
                echo "" . round($dts['enero'] * 100) . ", ";
            } else {
                echo "" . $dts['enero'] . ", ";
            } if ($dts['febrero'] != null) {
                echo "" . round($dts['febrero'] * 100) . ", ";
            } else {
                echo "" . $dts['febrero'] . ", ";
            } if ($dts['marzo'] != null) {
                echo "" . round($dts['marzo'] * 100) . ", ";
            } else {
                echo "" . $dts['marzo'] . ", ";
            } if ($dts['abril'] != null) {
                echo "" . round($dts['abril'] * 100) . ", ";
            } else {
                echo "" . $dts['abril'] . ", ";
            } if ($dts['mayo'] != null) {
                echo "" . round($dts['mayo'] * 100) . ", ";
            } else {
                echo "" . $dts['mayo'] . ", ";
            } if ($dts['junio'] != null) {
                echo "" . round($dts['junio'] * 100) . ", ";
            } else {
                echo "" . $dts['junio'] . ", ";
            } if ($dts['julio'] != null) {
                echo "" . round($dts['julio'] * 100) . ", ";
            } else {
                echo "" . $dts['julio'] . ", ";
            } if ($dts['agosto'] != null) {
                echo "" . round($dts['agosto'] * 100) . ", ";
            } else {
                echo "" . $dts['agosto'] . ", ";
            } if ($dts['septiembre'] != null) {
                echo "" . round($dts['septiembre'] * 100) . ", ";
            } else {
                echo "" . $dts['septiembre'] . ", ";
            } if ($dts['octubre'] != null) {
                echo "" . round($dts['octubre'] * 100) . ", ";
            } else {
                echo "" . $dts['octubre'] . ", ";
            } if ($dts['noviembre'] != null) {
                echo "" . round($dts['noviembre'] * 100) . ", ";
            } else {
                echo "" . $dts['noviembre'] . ", ";
            } if ($dts['diciembre'] != null) {
                echo "" . round($dts['diciembre'] * 100) . "";
            } else {
                echo "" . $dts['diciembre'] . "";
            }
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
?>
                        ],

                    }, ]
            },
            options: {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var label = data.datasets[tooltipItem.datasetIndex].label || '';

                            if (label) {
                                label += ': ';
                            }
                            label += tooltipItem.yLabel + "%" || '';
                            return label;
                        }
                    }
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value + "%";
                                }
                            }
                        }]
                }
            }

        });
<?php
$conn->cerrar();
?>
    </script>
</html>
