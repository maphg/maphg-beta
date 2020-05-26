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
            $destinoT = $dts['destino'];
            $gp = $dts['gp'];
            $trs = $dts['trs'];
        }
    }
} catch (Exception $ex) {
    echo $ex;
}

//OBTENER AVANCE A NIVEL COMPLEJO
//Total de tareas 
$totalPendientesCurrent = 0;
$totalSolucionadasCurrent = 0;
$porcentajeCurrent = 0;
$lstRanking = [];

//Se obtiene los totales del complejo seleccionado
if ($idDestinoT != 10) {
    $query = "SELECT * FROM t_mc WHERE id_destino = $idDestinoT";
    try {
        $resp = $conn->obtDatos($query);
        $totalTareasCurrent = $conn->filasConsultadas;
        if ($conn->filasConsultadas > 0) {
            foreach ($resp as $dts) {
                $statusMC = $dts['status'];
                if ($statusMC == "F") {
                    $totalSolucionadasCurrent += 1;
                } else {
                    $totalPendientesCurrent += 1;
                }
            }
        }
    } catch (Exception $ex) {
        echo $ex;
    }
    if ($totalTareasCurrent > 0) {
        $porcentajeCurrent = ($totalSolucionadasCurrent / $totalTareasCurrent ) * 100;
    } else {
        $porcentajeCurrent = 0;
    }
    $ranking = array("idDestino" => $idDestinoT, "porcentaje" => $porcentajeCurrent);
    $lstRanking[] = $ranking;
}


//Se obtienen los resultados de los destinos diferentes al actual evitando AME
$query = "SELECT * FROM c_destinos WHERE id != $idDestinoT AND id != 10";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $idD = $dts['id'];
            $nameDest = $dts['destino'];
            $totalTareas = 0;
            $totalPendientes = 0;
            $totalSolucionadas = 0;
            $query = "SELECT * FROM t_mc WHERE id_destino = $idD";
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

            if ($totalTareas > 0) {
                $porcentaje = ($totalSolucionadas / $totalTareas ) * 100;
            } else {
                $porcentaje = 0;
            }
            $ranking = array("idDestino" => $idD, "porcentaje" => $porcentaje);
            $lstRanking[] = $ranking;
        }
    }
} catch (Exception $ex) {
    echo $ex;
}

foreach ($lstRanking as $key => $row) {
    $aux[$key] = $row['porcentaje'];
}
$currenPosition = "NA";
$tablaRanking = "<div class=\"list is-hoverable has-text-left\">";
if (count($lstRanking) > 0 && count($aux) > 0) {
    //Se ordenan de mayor a menor para sacar el ranking
    array_multisort($aux, SORT_DESC, $lstRanking);

    //Se obtienen los datos y se muestran 
    for ($i = 0; $i < count($lstRanking); $i++) {
        if ($idDestinoT == $lstRanking[$i]['idDestino']) {
            $currenPosition = $i + 1;
        }
        $position = $i + 1;
        $query = "SELECT * FROM c_destinos WHERE id = " . $lstRanking[$i]['idDestino'] . "";
        try {
            $resultado = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resultado as $d) {
                    $destiny = $d['destino'];
                }
            }
            $tablaRanking .= "<a class=\"list-item\">$position.- $destiny - " . round($lstRanking[$i]['porcentaje']) . "% </a>";
        } catch (Exception $ex) {
            echo $ex;
        }
    }
}
$tablaRanking .= "</div>";

//var_dump($lstRanking);
?>
<!DOCTYPE html>
<html>

    <head>
        <?php echo $layout->styles(); ?>
        <link rel="stylesheet" href="DataTables/datatables.css">
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

        <!--HERO BAR-->
<!--        <section id="sectionHeroMain" class="hero is-primary is-small mt-5">
            Hero head: will stick at the top 
            <div class="hero-head">
                <div class="columns">
                    <div class="column">
                        <div class="container">
                            <div class="navbar-end">
                                <a class="navbar-item is-active">
                                    Planner
                                </a>
                                <a class="navbar-item" href="correctivos.php">
                                    Correctivo
                                </a>
                                <a class="navbar-item" href="preventivos.php">
                                    Preventivo
                                </a>
                                <a class="navbar-item" href="stock.php">
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

            Hero content: will be in the middle 
            <div class="hero-body">
                <div class="container has-text-centered">
                    <div class="columns is-centered">

                        <div class="column is-4 is-half">
                            <nav class="level is-mobile">
                                <div class="level-item has-text-centered">
                                    <div>
                                        <p class="heading">Pendientes</p>
                                        <p class="title has-text-white"><?php echo $totalPendientesCurrent; ?></p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered">
                                    <div>
                                        <p class="heading">Solucionados</p>
                                        <p class="title has-text-white"><?php echo $totalSolucionadasCurrent; ?></p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered">
                                    <div>
                                        <p class="heading">Avance</p>
                                        <p class="title has-text-white"><?php echo round($porcentajeCurrent) . "%"; ?></p>
                                    </div>
                                </div>
                                <div class="level-item has-text-centered">
                                    <div>
                                        <p class="heading">Ranking América</p>
                                        <div class="popover is-popover-right manita">
                                            <p class="title has-text-white popover-trigger"><span><i class="fas fa-medal has-text-warning"></i></span><?php echo $currenPosition; ?></p>
                                                                                        <article class="message is-info">
                                                                                            <div class="message-header">
                                                                                                <p>Info</p>
                                                                                                <button class="delete" aria-label="delete"></button>
                                                                                            </div>
                                                                                            <div class="message-body">
                                            <?php
                                            //echo $tablaRanking;
                                            ?>    
                                                                                            </div>
                                                                                        </article>
                                            <div class="popover-content">
                                                <?php
                                                echo $tablaRanking;
                                                ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </nav>
                        </div>
                    </div>
                </div>
            </div>

        </section>-->

        <section id="sectionHeroListaEquipos" class="hero is-light is-small mt-5">
            <!-- Hero head: will stick at the top -->
            <div class="hero-head mx-2">
                <div class="">
                    <div id="navbarMenuHeroA" class="navbar-menu">
                        <div class="navbar-start">
                            <span class="navbar-item">
                                <button class="button is-warning" onclick="showHide('')"><i class="fas fa-arrow-left"></i></button>
                            </span>
                            <span class="navbar-item">
                                <p id="divNameSubseccion" class="subtitle is-3">Aqui va nombre de la subseccion</p>
                            </span>
                        </div>
                        <div class="navbar-end">
                            <a class="navbar-item is-active">
                                <?php echo $destinoT; ?>
                            </a>
                            <span class="navbar-item">
                                <div class="field has-addons ">
                                    <p class="control">
                                        <button class="button is-light">
                                            <span class="icon is-small">
                                                <i class="fas fa-clipboard-check"></i>
                                            </span>
                                            <span>Bitácoras</span>
                                        </button>
                                    </p>
                                    <p class="control">
                                        <button class="button is-light">
                                            <span class="icon is-small">
                                                <i class="fas fa-info-circle"></i>
                                            </span>
                                            <span>Información</span>
                                        </button>
                                    </p>
                                    <p class="control">
                                        <button class="button is-light">
                                            <span class="icon is-small">
                                                <i class="fas fa-box-open"></i>
                                            </span>
                                            <span>Stock/Pedidos</span>
                                        </button>
                                    </p>
                                    <p class="control">
                                        <button class="button is-light">
                                            <span class="icon is-small">
                                                <i class="fas fa-file-excel"></i>
                                            </span>
                                            <span>Informes</span>
                                        </button>
                                    </p>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </section>

<!--        SECCION DE SELECTS
        <section id="seccionSelects" class="mt-2">
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

                <div class="column is-one-fifth">
                    <div class="control has-icons-left has-text-centered">
                        <div class="select is-medium is-fullwidth">
                            <?php
                            if ($idPermiso == 1 || $idPermiso == 3):
                                ?>
                                <select id="cbSecciones" name="basic[]" class="3col active" onchange="mostrarColumnasSeccion(<?php echo $idPermiso; ?>, <?php echo $idUsuario; ?>); return false;" multiple>
                                    <?php
                                    $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";
                                    try {
                                        $secciones = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($secciones as $dts) {
                                                $idSec = $dts['id'];
                                                $nombreSec = $dts['seccion'];
                                                switch ($nombreSec) {
                                                    case 'AUTO':
                                                        if ($auto == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'DEC':
                                                        if ($dec == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'DEP':
                                                        if ($dep == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'ZHA':

                                                        if ($zha == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }


                                                        break;
                                                    case 'ZHC':
                                                        if ($zhc == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'ZHH':
                                                        if ($zhh == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;

                                                    case 'ZHP':
                                                        if ($zhp == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }

                                                        break;
                                                    case 'ZIA':
                                                        if ($zia == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'ZIC':
                                                        if ($zic == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'ZIE':
                                                        if ($zie == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'ZIL':
                                                        if ($zil == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'OMA':
                                                        if ($oma == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                    case 'SEG':
                                                        if ($seg == 1) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
                                                        }
                                                        break;
                                                }
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                    ?>
                                </select>

                                <?php
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        SECCION COLUMNAS
        <section id="seccionColumnas" class="mt-2">
            <div id="dFilas" class="columns is-variable is-8 container-scroll mx-3">
                <?php
                if ($idPermiso == 1 || $idPermiso == 3) {
                    $cols = new Secciones();
                    $query = "SELECT * FROM c_secciones WHERE tareas = 'SI'";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $idSeccionTarea = $dts['id'];
                                $seccionName = $dts['seccion'];
                                $fotoSeccion = $dts['url_tab_image'];
                                switch ($seccionName) {
                                    case 'AUTO':
                                        if ($auto == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'DEC':
                                        if ($dec == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'DEP':
                                        if ($dep == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'ZHA':
                                        if ($zha == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'ZHC':
                                        if ($zhc == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'ZHH':
                                        if ($zhh == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'ZHP':
                                        if ($zhp == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;

                                    case 'ZIA':
                                        if ($zia == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'ZIC':
                                        if ($zic == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'ZIE':
                                        if ($zie == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'ZIL':
                                        if ($zil == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'OMA':
                                        if ($oma == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                    case 'SEG':
                                        if ($seg == 1) {
                                            echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                        }
                                        break;
                                }
                            }
                        } else {
                            echo "Sin resultados";
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }
                } else {
                    $cols = new Secciones();
                    $query = "SELECT * FROM t_tareas_secciones_permitidos WHERE id_usuario = $idUsuario";
                    try {
                        $seccionesPermitidas = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            $aux = "";
                            foreach ($seccionesPermitidas as $dts) {
                                $idSeccionPermitida = $dts['id_seccion'];
                                if ($aux != $idSeccionPermitida) {
                                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionPermitida AND tareas = 'SI'";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $idSeccionTarea = $dts['id'];
                                                $subcategoria = $dts['seccion'];
                                                $fotoSeccion = $dts['url_tab_image'];

                                                echo $cols->mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion);
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }
                                $aux = $idSeccionPermitida;
                            }
                        }
                    } catch (Exception $ex) {
                        echo $ex;
                    }
                }
                ?>
            </div>

        </section>-->

        <!--SECCION DE SLECCION DE HOTEL-->
<!--        <section id="seccionHoteles" style="display:none;">
            <div class="columns is-mobile is-centered mt-1">
                <div class="column is-10 has-text-centered">
                    <a class="button is-danger is-outlined mb-4">
                        <span onclick="showHide('')">Regresar</span>
                        <span class="icon is-small">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                    </a>

                    <div class="is-divider my-0" data-content="HOTELES"></div>

                </div>
            </div>
            <div id="listaHoteles" class="columns is-multiline is-mobile is-centered mt-1">
                <div class="column is-3 hvr-grow">
                    <a href="settings/destinos.php">
                        <div class="card rounded-3">
                            <div class="card-content">
                                <div class="container">
                                    <div class="columns is-centered">
                                        <div class="column has-text-centered">
                                            <h1 class="title is-size-6">Destinos</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>-->

        <!--*******SECCION LISTADO DE EQUIPOS*************-->
        <section id="seccionListaEquipos">
            <!--            <div class="columns is-mobile is-centered mt-1">
                            <div class="column is-10 has-text-centered">
                                <a class="button is-danger is-outlined mb-4">
                                    <span onclick="showHide('')">Regresar</span>
                                    <span class="icon is-small">
                                        <i class="fas fa-undo-alt"></i>
                                    </span>
                                </a>
            
                                <div id="divNameSubseccion" class="is-divider my-0" data-content="MC/MP/EQUIPOS"></div>
            
                            </div>
                        </div>-->

            <div class="columns is-centered my-2">
                <div class="column is-2 has-text-centered">
                    <form action="planner.php" method="get">
                        <div class="field has-addons has-addons-right is-fullwidth">
                            <div class="control">
                                <div class="control has-icons-left has-icons-right">
                                    <input id="busqueda" name="busqueda" class="input" type="text" placeholder="Buscar equipo"><span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                                </div>
                                            <!--<input id="busqueda" name="busqueda" class="input" type="text" placeholder="Buscar...">-->
                            </div>
                            <div class="control">
                                <input type="submit" value="Buscar" class="button is-info">
                            </div>
                        </div>
                    </form>
<!--                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="text" placeholder="Buscar equipo"><span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                    </div>-->
                </div>
                <div class="column is-1">
                    <button class="button is-warning"><i class="fas fa-sliders-h"></i></button>
                </div>
            </div>


            <div class="columns">
                <div id="divListaEquipos" class="column mx-5">

                </div>
            </div>



        </section>

        <!--************LISTA DE TAREAS*********************-->
        <section id="lista-tareas" style="display:none;">
            <input type="hidden" id="hddIdActividad">
            <input type="hidden" id="hddIdEquipo">
            <input type="hidden" id="hddIdDestino">
            <input type="hidden" id="hddIdCategoria">
            <input type="hidden" id="hddIdSubseccion">
            <input type="hidden" id="hddIdSubcategoria">
            <div class="columns is-centered px-4 has-background-dark my-4 pt-1">

                <div class="column has-text-centered">
                    <div class="field has-addons centerflex">
                        <p class="control">
                            <a class="button is-link is-outlined" onclick="home()">
                                <span class="icon is-small"><i class="fas fa-home"></i></span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-danger is-outlined" onclick="showListaTareas('')">
                                <span>Regresar</span>
                                <span class="icon is-small">
                                    <i class="fas fa-undo-alt"></i>
                                </span>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="column has-text-centered">
                    <div class="field has-addons centerflex">
                        <p class="control">
                            <button id="btnPendientesPA" class="button is-danger">
                                <span class="icon is-medium">
                                    <i class="far fa-times-circle"></i>
                                </span>
                                <span>Pendientes</span>
                            </button>
                        </p>
                        <p class="control">
                            <button id="btnSolucionadosPA" class="button is-primary is-outlined">
                                <span class="icon is-medium">
                                    <i class="far fa-check-circle"></i>
                                </span>
                                <span>Solucionados</span>
                            </button>>
                        </p>
                    </div>
                </div>

                <div class="column has-text-centered">
                    <div class="control has-icons-left has-icons-right">
                        <input id="txtTarea" class="input is-medium" type="text" placeholder="Añadir un correctivo">
                        <span class="icon is-left">
                            <i class="fas fa-fire-extinguisher"></i>
                        </span>
                        <span class="icon is-right">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="columns is-centered">
                <div class="column is-10">
                    <div id="divNombreSubseccion" class="is-divider mt-3" data-content="Aljibes"></div>
                </div>
            </div>

            <div class="columns mx-3 is-centered">
                <div id="divListaTareas" class="column is-9">
                    <div class="columns hvr-float">
                        <div class="column is-9">
                            <div class="field text-truncate">
                                <input class="is-checkradio is-success is-circle" id="chkb1" type="checkbox" name="chkb1" checked="checked">
                                <label for="chkb1"></label>
                                <span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) 
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="control ">
                                <div class="tags has-addons ">
                                    <span class="tag is-info ">Eduardo Meneses</span>
                                    <span class="tag is-dark"><i class="fas fa-paperclip"></i></span>
                                    <span class="tag is-info"><i class="fas fa-calendar-check"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns hvr-float">
                        <div class="column is-9">
                            <div class="field text-truncate">
                                <input class="is-checkradio is-success is-circle" id="chkb2" type="checkbox" name="chkb2" checked="checked">
                                <label for="chkb2"></label>
                                <span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) 
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="control ">
                                <div class="tags has-addons ">
                                    <span class="tag is-danger ">Sin responsable</span>
                                    <span class="tag is-dark"><i class="fas fa-paperclip"></i></span>
                                    <span class="tag is-danger"><i class="fas fa-calendar-times"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!--            <div class="columns is-centered mx-1">
                            <div class="column is-half">
                                <div class="columns hvr-float">
                                    <div class="column is-9">
                                        <div class="field text-truncate">
            
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle"></label>
                                            <span><i class="fas fa-bookmark has-text-danger"></i></span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) 
                                        </div>
                                    </div>
                                    <div class="column is-3">
                                        <div class="control ">
                                            <div class="tags has-addons ">
                                                <span class="tag is-info ">Eduardo Meneses</span>
                                                <span class="tag is-dark"><i class="fas fa-paperclip"></i></span>
                                                <span class="tag is-info"><i class="fas fa-calendar-check"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <div class="columns is-centered mx-1">
                            <div class="column is-half">
                                <div class="columns is-centered">
                                    <div class="column is-10">
                                        <div class="field text-truncate">
            
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle1" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle1"></label>
                                            (CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) 
                                        </div>
                                    </div>
                                    <div class="column is-5 has-text-centered">
                                        <div class="control ">
                                            <div class="tags has-addons ">
                                                <span class="tag is-danger ">Sin responsable</span>
                                                <span class="tag is-dark"><i class="fas fa-paperclip"></i></span>
                                                <span class="tag is-danger"><i class="fas fa-calendar-times"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->


        </section>

        <!--DETALLE DE LA TAREA-->
        <section id="detalle-tarea" class="mt-3" style="display:none;">
            <input type="hidden" id="hddIDTarea">
            <div class="columns is-mobile is-centered">
                <div class="column is-10 has-text-centered">
                    <a class="button is-danger is-outlined">
                        <span onclick="showDetallesTarea('')">Regresar</span>
                        <span class="icon is-small">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                    </a>

                    <div class="columns">
                        <div class="column">

                        </div>
                    </div>
                </div>
            </div>

            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="is-divider mt-3" data-content="Detalles de la tarea"></div>
                </div>
            </div>

            <div class="columns is-centered">
                <div class="column is-9">
                    <h3 id="tituloTarea" class="title is-3 has-text-centered">
                        "Aqui va el titulo de la tarea Lorem ipsum dolor sit amet, c"
                    </h3>
                </div>
                <div class="column is-1">
                    <span><a href="#" class="modal-button" data-target="modal-editar-tarea" aria-haspopup="false"><i class="fa fa-edit"></i></a></span>
                </div>
            </div>



            <div class="columns is-centered">

                <div class="column is-one-third has-text-centered">
                    <div id="myDatePicker" class="datepicker-here" data-date-format="mm/dd/yyyy"></div>
                       <!--                    <input id="txtDateRange1" type="date">
                                           <input id="txtDateRange2" type="date" style="display:none;">-->
                </div>

                <div class="column is-one-third">
                    <div class="columns is-centered px-3">
                        <div class="column is-10">
                            <div class="control has-icons-right">
                                <input id="txtComentario" class="input is-medium" type="text" placeholder="Agregar comentario">
                                <span class="icon is-right">
                                    <i class="fas fa-comment-dots"></i>
                                </span>
                            </div>
                        </div>
                        <div class="column is-2">

                            <a class="button is-primary">
                                <input class="file-input" type="file" name="resume" id="txtArchivo" multiple>
                                <span class="icon">
                                    <i class="fas fa-paperclip"></i>
                                </span>
                                <span>Adjuntar Archivo</span>
                            </a>
                        </div>
                    </div>
                    <div id="timeLine" class="timeline">
                        <header class="timeline-header">
                            <span class="tag is-small is-info">Inicio</span>
                        </header>

                        <div class="timeline-item is-danger">
                            <div class="timeline-marker is-danger is-icon">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <p class="heading">Creada por: <strong>Eduardo Meneses</strong></p>
                                <p class="heading">14/11/1989 20:30</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Eduardo Meneses</strong> 14/11/1989 20:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>
                        <div class="timeline-item is-danger">
                            <div class="timeline-marker is-danger is-icon">
                                <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span></h4>
                            </div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong>  14/11/1989 20:30</p>
                                <img src="svg/secciones/zia.svg" width="40px" alt="">
                                <img src="svg/secciones/zic.svg" width="40px" alt="">
                                <img src="svg/secciones/zil.svg" width="40px" alt="">
                                <img src="svg/secciones/zie.svg" width="40px" alt="">
                            </div>
                        </div>
                        <header class="timeline-header">
                            <span class="tag is-small is-info">Fin</span>
                        </header>
                    </div>

                </div>

            </div>
        </section>

        <!--***********SECCION MP/MC EQUIPOS*****************-->
        <section id="seccionMPMC" style="display: none;">
            <div class="columns is-centered px-4 has-background-dark my-4 pt-1">
                <div class="column has-text-centered">
                    <div class="field has-addons centerflex">
                        <p class="control">
                            <a class="button is-link is-outlined" onclick="home();">
                                <span class="icon is-small"><i class="fas fa-home"></i></span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-danger is-outlined" onclick="showMPMC();">
                                <span>Regresar</span>
                                <span class="icon is-small">
                                    <i class="fas fa-undo-alt"></i>
                                </span>
                            </a>
                        </p>
                    </div>
                </div>

                <div class="column has-text-centered">
                    <div class="field has-addons centerflex">
                        <p class="control">
                            <a id="mc" class="button is-warning" onclick="mostrarMCMP('mc');">
                                <span class="icon is-small">
                                    <i class="fas fa-fire-extinguisher"></i>
                                </span>
                                <span>Correctivos</span>
                            </a>
                        </p>
                        <p class="control">
                            <a id="mp" class="button is-link is-outlined" onclick="mostrarMCMP('mp');">
                                <span class="icon is-small">
                                    <i class="fas fa-wrench"></i>
                                </span>
                                <span>Preventivos</span>
                            </a>
                        </p>
                    </div>
                </div>

                <div id="columnaStatusMC" class="column has-text-centered">
                    <div class="field has-addons centerflex">
                        <p class="control">
                            <a id="btnPendientesMC" class="button is-danger">
                                <span class="icon is-medium">
                                    <i class="far fa-times-circle"></i>
                                </span>
                                <span>Pendientes</span>
                            </a>
                        </p>
                        <p class="control">
                            <a id="btnSolucionadosMC" class="button is-primary is-outlined">
                                <span class="icon is-medium">
                                    <i class="far fa-check-circle"></i>
                                </span>
                                <span>Solucionados</span>
                            </a>
                        </p>
                    </div>
                </div>

                <div id="columnaAñadirCorrectivo" class="column has-text-centered">
                    <div class="control has-icons-left has-icons-right">
                        <input id="txtTareaMC" class="input is-medium" type="text" placeholder="Añadir un correctivo">
                        <span class="icon is-left">
                            <i class="fas fa-fire-extinguisher"></i>
                        </span>
                        <span class="icon is-right">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                </div>

                <!--botones ver planeacion historial y datos-->
                <div id="columnaControles" class="column has-text-centered" style="display: none;">
                    <div class="field has-addons centerflex">
                        <p class="control">
                            <a id="btnPlaneacion" class="button is-primary" onclick="showMP('planeacion');">
                                <span class="icon is-medium">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                <span>Planeación</span>
                            </a>
                        </p>
                        <p class="control">
                            <a id="btnHistorial" class="button is-warning is-outlined" onclick="showMP('historial');">
                                <span class="icon is-medium">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span>Historial MP</span>
                            </a>
                        </p>
                        <p class="control">
                            <a id="btnManuales" class="button is-info is-outlined" onclick="showMP('manuales');">
                                <span class="icon is-medium">
                                    <i class="fas fa-history"></i>
                                </span>
                                <span>Manuales/Archivos</span>
                            </a>
                        </p>

                    </div>
                </div>
            </div>

            <div class="columns mx-3 is-centered">
                <!--Columna informacion equipo-->
                <div class="column is-3 mb-4">
                    <h6 class="title is-6 has-text-centered ">
                        Información del equipo
                    </h6>

                    <div class="tags has-addons is-centered">
                        <span id="txtNombreEq" class="tag is-info">Maquina de hielo 33s</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Destino</span>
                        <span id="txtDestinoEq" class="tag is-primary">CUN</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Tipo</span>
                        <span id="txtTipoEq" class="tag is-primary">Calderas</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Matricula</span>
                        <span id="txtMatriculaEq" class="tag is-primary">xxxxxxxx</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Ceco</span>
                        <span id="txtCECOEq" class="tag is-primary">Mantenimiento ZI CMU</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Seccion</span>
                        <span id="txtSeccionEq" class="tag is-primary">ZIA</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Sub seccion</span>
                        <span id="txtSubseccionEq" class="tag is-primary">Calderas</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Marca</span>
                        <span id="txtMarcaEq" class="tag is-dark">xxxxxxxx</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Modelo</span>
                        <span id="txtMarcaEq" class="tag is-dark">xxxxxxxx</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Serie</span>
                        <span id="txtSerieEq" class="tag is-dark">xxxxxxxx</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Estado</span>
                        <span id="txtStatusEq" class="tag is-dark">xxxxxxxx</span>
                    </div>

                    <div class="tags has-addons mb-0">
                        <span class="tag">Jerarquia</span>
                        <span id="txtJerarquiaEq" class="tag is-dark">xxxxxxxx</span>
                    </div>

                </div>

                <!--columna donde se ven las tareas correctivas-->
                <div id="columnaCorrectivos" class="column is-8">

                    <div class="columns hvr-float">
                        <div class="column is-9">
                            <div class="field text-truncate">
                                <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                <label for="exampleCheckboxSuccessCircle"><span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) </label>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="control ">
                                <div class="tags has-addons ">
                                    <span class="tag is-info ">Eduardo Meneses</span>
                                    <span class="tag is-dark"><i class="fas fa-paperclip"></i></span>
                                    <span class="tag is-info"><i class="fas fa-calendar-check"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns hvr-float">
                        <div class="column is-9">
                            <div class="field text-truncate">
                                <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                <label for="exampleCheckboxSuccessCircle"><span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) </label>
                            </div>
                        </div>
                        <div class="column is-3">
                            <div class="control ">
                                <div class="tags has-addons ">
                                    <span class="tag is-danger ">Sin responsable</span>
                                    <span class="tag is-dark"><i class="fas fa-paperclip"></i></span>
                                    <span class="tag is-danger"><i class="fas fa-calendar-times"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!--columna donde se ve la informacion del mp-->
                <div id="columnaPreventivos" class="column is-8" style="display: none">
                    <div class="columns mx-2 manita is-centered mb-0 pb-0">
                        <div class="column is-2">
                        </div>
                        <div class="column">
                            <img src="svg/semanas/s-1.svg" width="15px" alt="">
                            <img src="svg/semanas/s-2.svg" width="15px" alt="">
                            <img src="svg/semanas/s-3.svg" width="15px" alt="">
                            <img src="svg/semanas/s-4.svg" width="15px" alt="">
                            <img src="svg/semanas/s-5.svg" width="15px" alt="">
                            <img src="svg/semanas/s-6.svg" width="15px" alt="">
                            <img src="svg/semanas/s-7.svg" width="15px" alt="">
                            <img src="svg/semanas/s-8.svg" width="15px" alt="">
                            <img src="svg/semanas/s-9.svg" width="15px" alt="">
                            <img src="svg/semanas/s-10.svg" width="15px" alt="">
                            <img src="svg/semanas/s-11.svg" width="15px" alt="">
                            <img src="svg/semanas/s-12.svg" width="15px" alt="">
                            <img src="svg/semanas/s-13.svg" width="15px" alt="">
                            <img src="svg/semanas/s-14.svg" width="15px" alt="">
                            <img src="svg/semanas/s-15.svg" width="15px" alt="">
                            <img src="svg/semanas/s-16.svg" width="15px" alt="">
                            <img src="svg/semanas/s-17.svg" width="15px" alt="">
                            <img src="svg/semanas/s-18.svg" width="15px" alt="">
                            <img src="svg/semanas/s-19.svg" width="15px" alt="">
                            <img src="svg/semanas/s-20.svg" width="15px" alt="">
                            <img src="svg/semanas/s-21.svg" width="15px" alt="">
                            <img src="svg/semanas/s-22.svg" width="15px" alt="">
                            <img src="svg/semanas/s-23.svg" width="15px" alt="">
                            <img src="svg/semanas/s-24.svg" width="15px" alt="">
                            <img src="svg/semanas/s-25.svg" width="15px" alt="">
                            <img src="svg/semanas/s-26.svg" width="15px" alt="">
                            <img src="svg/semanas/s-27.svg" width="15px" alt="">
                            <img src="svg/semanas/s-28.svg" width="15px" alt="">
                            <img src="svg/semanas/s-29.svg" width="15px" alt="">
                            <img src="svg/semanas/s-30.svg" width="15px" alt="">
                            <img src="svg/semanas/s-31.svg" width="15px" alt="">
                            <img src="svg/semanas/s-32.svg" width="15px" alt="">
                            <img src="svg/semanas/s-33.svg" width="15px" alt="">
                            <img src="svg/semanas/s-34.svg" width="15px" alt="">
                            <img src="svg/semanas/s-35.svg" width="15px" alt="">
                            <img src="svg/semanas/s-36.svg" width="15px" alt="">
                            <img src="svg/semanas/s-37.svg" width="15px" alt="">
                            <img src="svg/semanas/s-38.svg" width="15px" alt="">
                            <img src="svg/semanas/s-39.svg" width="15px" alt="">
                            <img src="svg/semanas/s-40.svg" width="15px" alt="">
                            <img src="svg/semanas/s-41.svg" width="15px" alt="">
                            <img src="svg/semanas/s-42.svg" width="15px" alt="">
                            <img src="svg/semanas/s-43.svg" width="15px" alt="">
                            <img src="svg/semanas/s-44.svg" width="15px" alt="">
                            <img src="svg/semanas/s-45.svg" width="15px" alt="">
                            <img src="svg/semanas/s-46.svg" width="15px" alt="">
                            <img src="svg/semanas/s-47.svg" width="15px" alt="">
                            <img src="svg/semanas/s-48.svg" width="15px" alt="">
                            <img src="svg/semanas/s-49.svg" width="15px" alt="">
                            <img src="svg/semanas/s-50.svg" width="15px" alt="">
                            <img src="svg/semanas/s-51.svg" width="15px" alt="">
                            <img src="svg/semanas/s-52.svg" width="15px" alt="">
                        </div>
                    </div>

                    <div class="columns mx-2 manita is-centered">
                        <div class="column is-2">
                            <h6 class="title is-6 has-text-right ">Mantto mayor</h6>
                        </div>
                        <div class="column">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                        </div>
                    </div>

                    <div class="columns mx-2 manita is-centered">
                        <div class="column is-2">
                            <h6 class="title is-6 has-text-right ">Mantto menor</h6>
                        </div>
                        <div class="column">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/nulo.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                            <img src="svg/planificado.svg" width="15px" alt="">
                        </div>
                    </div>


                </div>

                <!--columna datos de los mp-->
                <div id="inicioMP" class="columns is-centered mt-4 border rounded" style="display: none;">
                    <div class="column is-half has-text-centered">
                        <h4 class="title is-4 ">Para poner en proceso este mantenimiento es necesario generar la OT.</h4>
                        <h6 id="titulomp" class="title is-6">"Mantenimiento mayor, semana 45"</h6>
                        <a id="btnGenerarOT" class="button is-warning">
                            <span class="icon is-small">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            <span>GENERAR OT</span>
                        </a>
                    </div>
                    <div class="column has-text-centered">
                        <div class="tags has-addons">
                            <span class="tag is-dark">Status</span>
                            <span class="tag is-info">Planificado</span>
                        </div>
                        <p class="mb-2">Actividades a realizar</p>
                        <ul id="ulActividades" class="has-text-left">
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In fermentum leo eu lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In fermentum leo eu lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In fermentum leo eu lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In fermentum leo eu lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In fermentum leo eu lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In fermentum leo eu lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In fermentum leo eu lectus mollis, quis dictum mi aliquet.</li>

                        </ul>
                    </div>
                </div>

                <div id="divDetalleOT" class="columns is-centered my-4 border rounded" style="display: none;">

                    <input type="hidden" id="hddidPlanMP">
                    <input type="hidden" id="hddidPlaneacion">
                    <div class="column has-text-centered">
                        <div class="columns is-centered">
                            <div class="column">
                                <div class="field is-grouped is-grouped-multiline">
                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark">Status</span>
                                            <span id="statusOT" class="tag is-warning">En proceso</span>
                                        </div>
                                    </div>

                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark">OT</span>
                                            <span id="folioOT" class="tag is-info">2041</span>
                                        </div>
                                    </div>

                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark"><i class="fas fa-user"></i></span>
                                            <span id="txtResponsable" class="tag is-danger">Sin responsable</span>
                                        </div>
                                    </div>

                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark"><i class="fas fa-calendar-times"></i></span>
                                            <span id="txtFechaRealizado" class="tag is-danger">Sin fecha</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="column has-text-centered">
                                <div class="field has-addons centerflex">
                                    <p class="control">
                                        <a id="btnImprimirOT" class="button is-dark is-small">
                                            <span class="icon is-small">
                                                <i class="fas fa-file-alt"></i>
                                            </span>
                                            <span>Imprimir OT</span>
                                        </a>
                                    </p>
                                    <p class="control">
                                        <a class="button is-primary is-small">
                                            <input class="file-input" type="file" name="resume" id="txtArchivoOT" multiple>
                                            <span class="icon">
                                                <i class="fas fa-paperclip"></i>
                                            </span>
                                            <span>Adjuntar Archivo</span>
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="column">
                                <div class="control has-icons-left has-icons-right">
                                    <input id="txtComentarioOT" class="input is-medium is-primary" type="text" placeholder="Añadir un comentario">
                                    <span class="icon is-left"><i class="fas fa-comment-dots"></i></span>
                                    <span class="icon is-right"><i class="fas fa-plus"></i></span>
                                </div>
                            </div>


                        </div>

                        <div class="columns">
                            <div id="listaActividadesMP" class="column is-8 is-half">

                                <div class="columns hvr-float">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>Mantenimiento mayor</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns is-centered">
                                    <div class="column ">
                                        <p class="control has-text-centered">
                                            <a class="button is-success">
                                                <span class="icon is-small">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span>Finalizar OT</span>
                                            </a>
                                        </p>
                                    </div>
                                </div>

                                <div class="columns is-centered">
                                    <div class="column ">
                                        <p class="control has-text-centered">
                                            <a class="button is-success">
                                                <span class="icon is-small">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span>Finalizar OT</span>
                                            </a>
                                        </p>
                                    </div>
                                </div>

                            </div>


                            <!--TIMELINE ORDEN TRABAJO-->
                            <div class="column has-text-left">
                                <div id="timeLineOT" class="timeline">
                                    <header class="timeline-header">
                                        <span class="tag is-small is-info">Inicio</span>
                                    </header>

                                    <div class="timeline-item is-danger">
                                        <div class="timeline-marker is-danger is-icon">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <p class="heading">OT Creada por: <strong>Eduardo Meneses</strong></p>
                                            <p class="heading">14/11/1989 20:30</p>
                                        </div>
                                    </div>

                                    <div class="timeline-item is-info">
                                        <div class="timeline-marker is-info"></div>
                                        <div class="timeline-content">
                                            <p class="heading"><strong>Eduardo Meneses</strong> 14/11/1989 20:30</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                                        </div>
                                    </div>

                                    <div class="timeline-item is-info">
                                        <div class="timeline-marker is-info"></div>
                                        <div class="timeline-content">
                                            <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item is-danger">
                                        <div class="timeline-marker is-danger is-icon">
                                            <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span></h4>
                                        </div>
                                        <div class="timeline-content">
                                            <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong>  14/11/1989 20:30</p>
                                            <img src="svg/secciones/zia.svg" width="40px" alt="">
                                            <img src="svg/secciones/zic.svg" width="40px" alt="">
                                            <img src="svg/secciones/zil.svg" width="40px" alt="">
                                            <img src="svg/secciones/zie.svg" width="40px" alt="">
                                        </div>
                                    </div>
                                    <div class="timeline-item is-success">
                                        <div class="timeline-marker is-success is-icon">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="timeline-content">
                                            <p class="heading">OT Cerrada por: <strong>Eduardo Meneses</strong></p>
                                            <p class="heading">14/11/1989 20:30</p>
                                        </div>
                                    </div>
                                    <header class="timeline-header">
                                        <span class="tag is-small is-info">Fin</span>
                                    </header>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!--columna donde se ve la informacion del historial de mp-->
                <div id="columnaHistorialMP" class="column is-8" style="display: none;">
                    <div class="columns is-centered">
                        <div class="column is-half">
                            <h6 class="title is-6 has-text-centered">Ultimas Órdenes de trabajo</h6>

                            <div id="timeLineHistorialOT" class="timeline is-centered">
                                <div class="timeline-item is-danger">
                                    <div class="timeline-marker is-danger ">
                                    </div>
                                    <div class="timeline-content">
                                        <p class="heading">OT# 342 Creada por: <strong>Eduardo Meneses</strong></p>
                                        <p class="heading">14/11/1989 20:30</p>
                                        <div class="field has-addons">
                                            <p class="control">
                                                <a class="button is-danger is-outlined is-small">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-file-download"></i>
                                                    </span>
                                                    <span>Descargar OT</span>
                                                </a>
                                            </p>
                                            <p class="control">
                                                <a class="button is-danger is-outlined is-small">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                    <span>Ver más</span>
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-item is-danger">
                                    <div class="timeline-marker is-danger">
                                    </div>
                                    <div class="timeline-content">
                                        <p class="heading">OT# 342 Creada por: <strong>Eduardo Meneses</strong></p>
                                        <p class="heading">14/11/1989 20:30</p>

                                        <div class="field has-addons">
                                            <p class="control">
                                                <a class="button is-danger is-outlined is-small">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-file-download"></i>
                                                    </span>
                                                    <span>Descargar OT</span>
                                                </a>
                                            </p>
                                            <p class="control">
                                                <a class="button is-danger is-outlined is-small">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-info-circle"></i>
                                                    </span>
                                                    <span>Ver más</span>
                                                </a>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="columnaAdjuntosEquipo" class="column is-8" style="display: none;">
                    <div class="columns">
                        <div class="column is-2">
                            <a class="button is-primary">
                                <input class="file-input" type="file" name="resume" id="txtArchivoEquipo" multiple>
                                <span class="icon">
                                    <i class="fas fa-paperclip"></i>
                                </span>
                                <span>Adjuntar Archivo</span>
                            </a>
                        </div>
                    </div>
                    <div id="adjuntosEquipo" class="columns is-multiline is-mobile">
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div><div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>
                        <div class="column">
                            <figure class="image is-128x128">
                                <img src="https://picsum.photos/300/300?random=1">
                            </figure>
                        </div>


                    </div>
                </div>
            </div>

        </section>

        <section id="detalle-tarea-mc" class="mt-3" style="display:none;">
            <input type="hidden" id="hddIDTarea">
            <div class="columns is-mobile is-centered">
                <div class="column is-10 has-text-centered">
                    <a class="button is-danger is-outlined">
                        <span onclick="showDetallesTareaMC('')">Regresar</span>
                        <span class="icon is-small">
                            <i class="fas fa-undo-alt"></i>
                        </span>
                    </a>

                    <div class="columns">
                        <div class="column">

                        </div>
                    </div>
                </div>
            </div>

            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="is-divider mt-3" data-content="Detalles de la tarea"></div>
                </div>
            </div>

            <div class="columns is-centered">
                <div class="column is-9">
                    <h3 id="tituloTareaMC" class="title is-3 has-text-centered">
                        "Aqui va el titulo de la tarea Lorem ipsum dolor sit amet, c"
                    </h3>

                </div>
                <div class="column is-1">
                    <span><a href="#" class="modal-button" data-target="modal-editar-tarea" aria-haspopup="false"><i class="fa fa-edit"></i></a></span>
                </div>
            </div>



            <div class="columns is-centered">

                <div class="column is-one-third has-text-centered">
                    <div id="myDatePickerMC" class="datepicker-here" data-date-format="mm/dd/yyyy"></div>
                       <!--                    <input id="txtDateRange1" type="date">
                                           <input id="txtDateRange2" type="date" style="display:none;">-->
                </div>

                <div class="column is-one-third">
                    <div class="columns is-centered px-3">
                        <div class="column is-10">
                            <div class="control has-icons-right">
                                <input id="txtComentarioMC" class="input is-medium" type="text" placeholder="Agregar comentario">
                                <span class="icon is-right">
                                    <i class="fas fa-comment-dots"></i>
                                </span>
                            </div>
                        </div>
                        <div class="column is-2">
                            <a class="button is-primary">
                                <input class="file-input" type="file" name="resume" id="txtArchivoMC" multiple>
                                <span class="icon">
                                    <i class="fas fa-paperclip"></i>
                                </span>
                                <span>Adjuntar Archivo</span>
                            </a>
                        </div>
                    </div>
                    <div id="timeLineMC" class="timeline">
                        <header class="timeline-header">
                            <span class="tag is-small is-info">Inicio</span>
                        </header>

                        <div class="timeline-item is-danger">
                            <div class="timeline-marker is-danger is-icon">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <p class="heading">Creada por: <strong>Eduardo Meneses</strong></p>
                                <p class="heading">14/11/1989 20:30</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Eduardo Meneses</strong> 14/11/1989 20:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>
                        <div class="timeline-item is-danger">
                            <div class="timeline-marker is-danger is-icon">
                                <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span></h4>
                            </div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong>  14/11/1989 20:30</p>
                                <img src="svg/secciones/zia.svg" width="40px" alt="">
                                <img src="svg/secciones/zic.svg" width="40px" alt="">
                                <img src="svg/secciones/zil.svg" width="40px" alt="">
                                <img src="svg/secciones/zie.svg" width="40px" alt="">
                            </div>
                        </div>
                        <header class="timeline-header">
                            <span class="tag is-small is-info">Fin</span>
                        </header>
                    </div>

                </div>

            </div>
        </section>

        <!--***********SECCION DE PROYECTOS*****************-->
        <section id="seccionDetalleProyectos" class="mt-3" style="display: none;">
            <input type="hidden" id="hddIdProyecto">
            <input type="hidden" id="hddIdDestinoProy">
            <input type="hidden" id="hddIdSeccionProy">
            <input type="hidden" id="hddIdSubseccionProy">
            <div class="columns is-centered px-4 has-background-dark my-4 pt-1">

                <div class="column has-text-centered">
                    <div class="field has-addons centerflex">
                        <p class="control">
                            <a class="button is-link is-outlined" onclick="home();">
                                <span class="icon is-small"><i class="fas fa-home"></i></span>
                            </a>
                        </p>
                        <p class="control">
                            <a class="button is-danger is-outlined" onclick="mostrarInfoProyecto();">
                                <span>Regresar</span>
                                <span class="icon is-small">
                                    <i class="fas fa-undo-alt"></i>
                                </span>
                            </a>
                        </p>
                    </div>
                </div>

                <div id="columnaStatusMC" class="column has-text-centered">
                    <div class="field has-addons centerflex">
                        <p class="control">
                            <a id="btnPendientesPAProyecto" class="button is-danger">
                                <span class="icon is-medium">
                                    <i class="far fa-times-circle"></i>
                                </span>
                                <span>Pendientes</span>
                            </a>
                        </p>
                        <p class="control">
                            <a id="btnSolucionadosPAProyecto" class="button is-primary is-outlined">
                                <span class="icon is-medium">
                                    <i class="far fa-check-circle"></i>
                                </span>
                                <span>Solucionados</span>
                            </a>
                        </p>
                    </div>
                </div>

                <div id="columnaAñadirPA" class="column has-text-centered">
                    <div class="control has-icons-left has-icons-right">
                        <input id="txtActividadPA" class="input is-medium" type="text" placeholder="Añadir Actividad Plan accion">
                        <span class="icon is-left">
                            <i class="fas fa-fire-extinguisher"></i>
                        </span>
                        <span class="icon is-right">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="columns mx-3 is-centered">
                <!--Columna informacion proyecto-->
                <div class="column mb-4">
                    <h6 class="title is-6 has-text-centered ">
                        Información del proyecto
                    </h6>

                    <div class="columns">
                        <div class="column is-2">
                            <div class="tags has-addons mb-0">
                                <span class="tag">Destino</span>
                                <span id="txtDestinoProyecto" class="tag is-primary">CUN</span>
                            </div>
                        </div>
                        <div class="column">
                            <input type="text" class="input is-small" id="txtTituloProyecto" placeholder="Titulo Proyecto">
                        </div>
                        <div id="divAñoProy" class="column is-2" style="display: none;">
                            <input type="text" class="input is-small" id="txtAñoProyecto" placeholder="Año">
                        </div>
                        <div id="divCosteProy" class="column is-2" style="display: none;">
                            <input type="text" class="input is-small" id="txtCosteProyecto" placeholder="Coste $$">
                        </div>
                        <div class="column">
                            <div class="select is-small is-fullwidth">
                                <select id="cbTipoProyecto" onchange="cambiarTipo();">
                                    <option value="PROYECTO">PROYECTO</option>
                                    <option value="CAPEX">CAPEX</option>
                                    <option value="CAPIN">CAPIN</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-2">
                            <div class="field text-truncate">
                                <input class="is-checkradio is-success is-circle is-small" id="chkbProyF" type="checkbox" name="chkbProyF" checked="checked">
                                <label for="chkbProyF"><span></span>PROYECTO TERMINADO</label>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <div class="control">
                                    <textarea id="txtJustificacion" class="textarea is-small" placeholder="Justificacion" rows="2"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns mx-3 is-centered">
                <!--columna donde se ven las tareas correctivas-->
                <div id="columnaPAProyectos" class="column is-5">

                    <div class="columns hvr-float">
                        <div class="column is-7">
                            <div class="field">
                                <input class="is-checkradio is-success is-circle is-small" id="exampleCheckboxSuccessCircle2" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                <label for="exampleCheckboxSuccessCircle2"></label>
                                <span class="is-size-7"><span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) </span>
                            </div>
                        </div>
                        <div class="column is-5">
                            <div class="control ">
                                <div class="tags has-addons ">
                                    <span class="tag is-info ">Eduardo Meneses</span>
                                    <span class="tag is-danger ">Eliminar</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns hvr-float">
                        <div class="column is-7">
                            <div class="field">
                                <input class="is-checkradio is-success is-circle is-small   " id="exampleCheckboxSuccessCircle3" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                <label for="exampleCheckboxSuccessCircle3"></label>
                                <span class="is-size-7"><span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) </span>
                            </div>
                        </div>
                        <div class="column is-5">
                            <div class="control ">
                                <div class="tags has-addons ">
                                    <span class="tag is-danger ">Sin responsable</span>
                                    <span class="tag is-danger ">Eliminar</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="columnaComentariosProyecto" class="column">

                    <input id="txtComentarioProyecto" type="text" class="input is-small mb-2" placeholder="Agregar comentario" style="display: none;">
                    <div id="timeLineComentariosProyecto" class="timeline" style="display: none;">
                        <header class="timeline-header">
                            <span class="tag is-small is-info">Inicio</span>
                        </header>

                        <div class="timeline-item is-danger">
                            <div class="timeline-marker is-danger is-icon">
                                <i class="fa fa-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <p class="heading">OT Creada por: <strong>Eduardo Meneses</strong></p>
                                <p class="heading">14/11/1989 20:30</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Eduardo Meneses</strong> 14/11/1989 20:30</p>
                                <p class="is-size-7">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>

                        <div class="timeline-item is-success">
                            <div class="timeline-marker is-success is-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <p class="heading">OT Cerrada por: <strong>Eduardo Meneses</strong></p>
                                <p class="heading">14/11/1989 20:30</p>
                            </div>
                        </div>
                        <header class="timeline-header">
                            <span class="tag is-small is-info">Fin</span>
                        </header>
                    </div>
                </div>

                <div id="columnaAdjuntosProyecto" class="column">
                    <div class="columns">
                        <div class="column">
                            <a class="button is-primary is-small mb-2">
                                <input class="file-input" type="file" name="txtCotProyecto" id="txtCotProyecto" multiple>
                                <span class="icon">
                                    <i class="fas fa-paperclip"></i>
                                </span>
                                <span>Adjuntar Cot./Fact.</span>
                            </a>
                            <div id="timeLineAdjuntosProyecto" class="timeline">
                                <header class="timeline-header">
                                    <span class="tag is-small is-info">Cot. y Fact.</span>
                                </header>


                                <div class="timeline-item is-danger">
                                    <div class="timeline-marker is-danger is-icon">
                                        <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span></h4>
                                    </div>
                                    <div class="timeline-content">
                                        <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong>  14/11/1989 20:30</p>
                                        <a class="example-image-link" href="https://picsum.photos/200/200" data-lightbox="cot-gallery" data-title=""><img width="64" height="64" class="example-image img-fluid" src="https://picsum.photos/200/200" alt=""/></a>

                                        <button class="button is-danger is-small is-rounded">
                                            <span class="icon is-small">
                                                <i class="fas fa-times"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <header class="timeline-header">
                                    <span class="tag is-small is-info">Fin</span>
                                </header>
                            </div>
                        </div>
                        <div class="column">
                            <a class="button is-primary is-small mb-2">
                                <input class="file-input" type="file" name="txtJustificacionProyecto" id="txtJustificacionProyecto" multiple>
                                <span class="icon">
                                    <i class="fas fa-paperclip"></i>
                                </span>
                                <span>Adjuntar justificacion</span>
                            </a>
                            <div id="timeLineJustificacionesProyecto" class="timeline">
                                <header class="timeline-header">
                                    <span class="tag is-small is-info">Justificaciones</span>
                                </header>


                                <div class="timeline-item is-danger">
                                    <div class="timeline-marker is-danger is-icon">
                                        <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span></h4>
                                    </div>
                                    <div class="timeline-content">
                                        <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong>  14/11/1989 20:30</p>
                                        <a class="example-image-link" href="https://picsum.photos/200/200" data-lightbox="just-gallery" data-title=""><img width="64" height="64" class="example-image img-fluid" src="https://picsum.photos/200/200" alt=""/></a>

                                        <button class="button is-danger is-small is-rounded">
                                            <span class="icon is-small">
                                                <i class="fas fa-times"></i>
                                            </span>
                                        </button>

                                    </div>
                                </div>

                                <header class="timeline-header">
                                    <span class="tag is-small is-info">Fin</span>
                                </header>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!--AREA DE MODALS-->
        <!--MODAL AGREGAR RESPONSABLE TAREA GENERAL-->
        <div id="modalAgregarResponsable" class="modal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">

                    <input class="input is-primary" type="text" placeholder="Buscar..." onkeyup="buscarUsuario(this, <?php echo $idDestinoT; ?>);">

                </header>
                <!-- Any other Bulma elements you want -->
                <section class="modal-card-body">
                    <div class="columns">
                        <div id="divListaUsuarios" class="column">

                            <?php
                            if ($idDestinoT == 10) {
                                $query = "SELECT * FROM t_users WHERE status = 'A' ORDER BY username";
                            } else {
                                $query = "SELECT * FROM t_users WHERE (id_destino = $idDestinoT OR id_destino = 10) AND status = 'A' ORDER BY username";
                            }
                            $usuarios = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($usuarios as $u) {
                                    $idUsuario = $u['id'];
                                    $idTrabajador = $u['id_colaborador'];
                                    $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                    try {
                                        $trabajador = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($trabajador as $t) {
                                                $nombreT = $t['nombre'];
                                                $apellidoT = $t['apellido'];
                                                $fotoT = $t['foto'];
                                            }
                                        } else {
                                            $nombreT = "";
                                            $apellidoT = "";
                                            $fotoT = "";
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    if ($fotoT != "") {
                                        $urlFoto = "img/users/$fotoT";
                                    } else {
                                        $urlFoto = "https://ui-avatars.com/api/?uppercase=false&name=$nombreT+$apellidoT&background=d8e6ff&rounded=true&color=4886ff&size=100%";
                                    }

                                    echo "<h6 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"agregarResponsable($idUsuario)\"><span><i class=\"fas fa-user\"></i></span> $nombreT $apellidoT</h6>";
                                }
                            }
                            ?>

                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <div class="container">
                        <div class="columns">
                            <div class="column has-text-right">
                                <button class="button is-danger" onclick="closeModal('modalAgregarResponsable');">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!--<button class="modal-close is-large" aria-label="close" onclick="closeModal('modalAgregarResponsable');"></button>-->
        </div>

        <!--MODAL CONFIRMAR COMPLETAR TAREA GENERAL-->
        <div id="modalConfirmacionTarea" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-sm">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="content has-text-centered">
                                <p class="is-size-4">¿Completar esta tarea?</p>
                            </div>
                            <div class="level">
                                <div class="level-item has-text-centered">
                                    <button id="btnFinalizarTarea" class="button is-success">ACEPTAR</button>
                                </div>
                                <div class="level-item has-text-centered">
                                    <button id="btnCancelarFinalizarTarea" class="button is-danger" onclick="closeModal('modalConfirmacionTarea');">CANCELAR</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--MODAL PARA FINALIZAR OT-->
        <div id="modalFinalizarOT" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <div class="media">

                        <div class="media-content">
                            <div class="content has-text-centered">
                                <div class="select is-fullwidth">
                                    <select id="cbResponsableMP" class="is-uppercase">
                                        <option value="0">-Responsable-</option>
                                        <?php
                                        if ($idDestinoT == 10) {
                                            $query = "SELECT * FROM t_colaboradores WHERE status = 'A' ORDER BY nombre";
                                        } else {
                                            $query = "SELECT * FROM t_colaboradores WHERE id_destino = $idDestinoT AND status = 'A' ORDER BY nombre";
                                        }
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $idEmpleado = $dts['id'];
                                                    $nombreEmpleado = $dts['nombre'];
                                                    $apellidoEmpleado = $dts['apellido'];
                                                    echo "<option value=\"$idEmpleado\">$nombreEmpleado $apellidoEmpleado</option>";
//                                                        $idUser = $dts['id'];
//                                                        $idEmpleado = $dts['id_colaborador'];
//                                                        $query = "SELECT * FROM t_colaboradores WHERE id = $idEmpleado";
//                                                        try {
//                                                            $empleado = $conn->obtDatos($query);
//                                                            if ($conn->filasConsultadas > 0) {
//                                                                foreach ($empleado as $e) {
//                                                                    $nombreEmpleado = $e['nombre'];
//                                                                    $apellidoEmpleado = $e['apellido'];
//                                                                }
//                                                            }
//                                                        } catch (Exception $ex) {
//                                                            echo $ex;
//                                                        }
//                                                        echo "<option value=\"$idUser\">$nombreEmpleado $apellidoEmpleado</option>";
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            echo $ex;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="level">
                                <div class="media-content">
                                    <input id="txtFechaRealizacion" type='text' class='input has-text-centered datepicker-here' data-language='es' data-auto-close="true" placeholder="Fecha de realizacion"/>
                                </div>
                            </div>
                            <div class="level">
                                <div class="media-content">
                                    <div class="level-item has-text-centered">
                                        <button id="btnFinalizarOT" class="button is-success mr-5">ACEPTAR</button>
                                        <button class="button is-danger ml-5" onclick="closeModal('modalFinalizarOT');">CANCELAR</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="modal-close is-large" aria-label="close" onclick="closeModal('modalFinalizarOT');"></button>
        </div>

        <!--MODAL RESPONSABLE TAREA DE PROYECTO-->
        <div id="modalAgregarResponsableProyecto" class="modal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">

                    <input class="input is-primary" type="text" placeholder="Buscar..." onkeyup="buscarUsuarioProy(this, <?php echo $idDestinoT; ?>);">

                </header>
                <!-- Any other Bulma elements you want -->
                <section class="modal-card-body">
                    <div class="columns">
                        <div id="divListaUsuariosProy" class="column">

                            <?php
                            if ($idDestinoT == 10) {
                                $query = "SELECT * FROM t_users WHERE status = 'A' ORDER BY username";
                            } else {
                                $query = "SELECT * FROM t_users WHERE (id_destino = $idDestinoT OR id_destino = 10) AND status = 'A' ORDER BY username";
                            }
                            $usuarios = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($usuarios as $u) {
                                    $idUsuario = $u['id'];
                                    $idTrabajador = $u['id_colaborador'];
                                    $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajador";
                                    try {
                                        $trabajador = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($trabajador as $t) {
                                                $nombreT = $t['nombre'];
                                                $apellidoT = $t['apellido'];
                                                $fotoT = $t['foto'];
                                            }
                                        } else {
                                            $nombreT = "";
                                            $apellidoT = "";
                                            $fotoT = "";
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    if ($fotoT != "") {
                                        $urlFoto = "img/users/$fotoT";
                                    } else {
                                        $urlFoto = "https://ui-avatars.com/api/?uppercase=false&name=$nombreT+$apellidoT&background=d8e6ff&rounded=true&color=4886ff&size=100%";
                                    }

                                    echo "<h6 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"agregarResponsableProyecto($idUsuario)\"><span><i class=\"fas fa-user\"></i></span> $nombreT $apellidoT</h6>";
                                }
                            }
                            ?>

                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                    <div class="container">
                        <div class="columns">
                            <div class="column has-text-right">
                                <button class="button is-danger" onclick="closeModal('modalAgregarResponsableProyecto');">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!--<button class="modal-close is-large" aria-label="close" onclick="closeModal('modalAgregarResponsableProyecto');"></button>-->
        </div>

        <!--MODAL FINALIZAR ACTIVIDAD PROYECTO-->
        <div id="modalConfirmacionTareaProy" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-sm">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="content has-text-centered">
                                <p class="is-size-4">¿Completar esta tarea?</p>
                            </div>
                            <div class="level">
                                <div class="level-item has-text-centered">
                                    <button id="btnFinalizarTareaProy" class="button is-success">ACEPTAR</button>
                                </div>
                                <div class="level-item has-text-centered">
                                    <button id="btnCancelarFinalizarTareaProy" class="button is-danger" onclick="closeModal('modalConfirmacionTareaProy');">CANCELAR</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--Modal finalizar PROYECTO-->
        <div id="modalFinalizarProyecto" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-sm">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="content has-text-centered">
                                <p class="is-size-4">¿Marcar el proyecto como terminado?</p>
                            </div>
                            <div class="level">
                                <div class="level-item has-text-centered">
                                    <button id="btnFinalizarProy" class="button is-success">ACEPTAR</button>
                                </div>
                                <div class="level-item has-text-centered">
                                    <button id="btnCancelarFinalizarProy" class="button is-danger" onclick="closeModal('modalFinalizarProyecto');">CANCELAR</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--MODAL PARA ELIMINAR UNA TAREA DE PROYECTO-->
        <div id="modalEliminarTareaProy" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-sm">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="content has-text-centered">
                                <p class="is-size-4">¿Desea eliminar esta actividad?</p>
                            </div>
                            <div class="level">
                                <div class="level-item has-text-centered">
                                    <button id="btnEliminarTareaProy" class="button is-success">ACEPTAR</button>
                                </div>
                                <div class="level-item has-text-centered">
                                    <button id="btnCancelarEliminarTareaProy" class="button is-danger" onclick="closeModal('modalEliminarTareaProy');">CANCELAR</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--MODAL PARA ELIMINAR UN ADJUNTO DEL PROYECTO-->
        <div id="modalEliminarAdjuntoProy" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content modal-sm">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="content has-text-centered">
                                <p class="is-size-4">¿Desea eliminar este archivo?</p>
                            </div>
                            <div class="level">
                                <div class="level-item has-text-centered">
                                    <button id="btnEliminarArchivoProy" class="button is-success">ACEPTAR</button>
                                </div>
                                <div class="level-item has-text-centered">
                                    <button id="btnCancelarEliminarArchivoProy" class="button is-danger" onclick="closeModal('modalEliminarAdjuntoProy');">CANCELAR</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
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

        <!--MODAL PARA AGREGAR PROYECTO-->
        <div id="modalCrearProyecto" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <input type="hidden" id="idSeccionHdd">
                                <input type="hidden" id="idSubseccionHdd">
                                <input type="hidden" id="idCategoriaHdd">
                                <div class="columns">
                                    <div class="column">
                                        <input type="text" id="txtTituloProy" class="input" placeholder="Titulo proyecto">
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <textarea type="text" id="txtJustificacionProy" class="input" placeholder="Justificacion"></textarea>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <div class="select is-fullwidth">
                                            <select id="cbTipoProyectoN" onchange="proyectos(this)">
                                                <option value="PROYECTO">PROYECTO</option>
                                                <option value="CAPEX">CAPEX</option>
                                                <option value="CAPIN">CAPIN</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="divDetalleCAP" class="columns" style="display: none;">
                                    <div class="column">
                                        <div class="columns">
                                            <div class="column">
                                                <input type="number" class="input" id="txtCosteN" placeholder="$"/>
                                            </div>
                                        </div>
                                        <div class="columns">
                                            <div class="column">
                                                <input type="number" maxlength="4" class="input" id="txtAñoN" placeholder="Año"/>
                                            </div>
                                        </div>
                                        <div class="columns">
                                            <div class="column">
                                                <a class="button is-primary">
                                                    <input class="file-input" type="file" name="resume" id="txtAdjuntoProyectoN" multiple>
                                                    <span class="icon">
                                                        <i class="fas fa-paperclip"></i>
                                                    </span>
                                                    <span>Adjuntar Archivo</span>
                                                </a>
                                                                    <!--<div class="upload-btn-wrapper hvr-shadow text-center"><button class="btn btn-sm bg-body text-negron manita border-normal">Adjuntar Cotizacion</button><input type="file" id="txtAdjuntoProyecto" name="txtAdjuntoProyecto"/></div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="columns has-text-centered">
                                    <div class="column">
                                        <button id="" class="button is-danger" onclick="closeModal('modalCrearProyecto');">CANCELAR</button>
                                    </div>
                                    <div class="column">
                                        <button id="" class="button is-success" onclick="agregarProyecto(<?php echo $idDestinoT; ?>, <?php echo $idPermiso; ?>, <?php echo $idUsuario; ?>)">CREAR PROYECTO</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!--            <button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--MODAL EDITAR DATOS DE UNA TAREA DE EQUIPO-->
        <div id="modal-editar-tarea" class="modal">
            <div class="modal-background"></div>
            <div class="modal-content">
                <div class="box">
                    <div class="media">
                        <div class="media-content">
                            <div class="container">
                                <div class="columns">
                                    <div class="column has-text-centered">
                                        <h1 class="title is-size-4">Editar titulo de tarea</h1>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <div class="field">
                                            <div class="control">
                                                <input id="txtEditTituloTarea" class="input" type="text" placeholder="Titulo tarea...">
                                            </div>
                                        </div>
                                        <div class="field">
                                            <input class="is-checkradio is-danger" id="chkbEliminarTarea" type="checkbox" name="chkbEliminarTarea">
                                            <label for="chkbEliminarTarea">Eliminar tarea</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column has-text-centered">
                                        <button id="btnActualizarTarea" class="button is-primary is-medium">Guardar</button>
                                    </div>
                                    <div class="column has-text-centered">
                                        <button class="button is-medium close-modal">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<button class="modal-close is-large" aria-label="close"></button>-->
        </div>

        <!--AREA DE MENSAJES-->
        <article id="article-mapas" class="message is-primary popup" style="display: none;">
            <div class="message-header">
                <p>Mapa</p>
                <button class="delete" aria-label="delete" onclick="cerrarMapa();"></button>
            </div>
            <div id="message-body" class="message-body">

            </div>
        </article>


        <a id="btnAncla" href="#nav-menu" class="button is-primary is-rounded ancla" style="display:none;"><i class="fa fa-arrow-up"></i></a>
    </body>
    <?php echo $layout->scripts(); ?>

    <script src="js/plannerJS.js?v4.0.1"></script>
    <script src="js/usuariosJS.js?v4.0.1"></script>
    <script src="js/paginator.min.js"></script>
    <!--DataTables-->
    <script src="DataTables/datatables.js"></script>

    <script>
                    $(document).ready(function () {
                        var alturaFilas = screen.height - 400;
                        var dFilas = document.getElementById("dFilas");
                        //dFilas.setAttribute("style", "min-height: " + alturaFilas + "px;");
                        var pageloader = document.getElementById("loader");
                        if (pageloader) {

                            var pageloaderTimeout = setTimeout(function () {
                                pageloader.classList.toggle('is-active');
                                clearTimeout(pageloaderTimeout);
                            }, 3000);
                        }

                        $(window).scroll(function () {
                            var position = $(this).scrollTop();
                            var positionHead = $(this).scrollTop();
                            if (position >= 200) {
                                $('#btnAncla').fadeIn('slow');
                            } else {
                                $('#btnAncla').fadeOut('slow');
                            }
                            if (positionHead >= 300) {
                                $(".tg").addClass("top-head");
                            } else {
                                $(".tg").removeClass("top-head");
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

            $(".ms-options").mCustomScrollbar({
                theme: "minimal-dark"
            });

        });
    </script>
    <script>
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
    </script>
</html>

<?php

Class Secciones {

    public function mostrarCols($idUsuario, $idSeccionTarea, $fotoSeccion) {
        $salida = "";
        $lstSecciones = [];
        if (isset($_SESSION['idDestino'])) {
            $idDestino = $_SESSION['idDestino'];
        } else {
            $idDestino = 10;
        }

        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
        try {
            $out = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($out as $s) {
                    $destino = $s['destino'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $query = "SELECT seccion, titulo_seccion, url_image, url_video FROM c_secciones WHERE id = $idSeccionTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $nombreSeccion = $dts['seccion'];
                    $tituloSeccion = $dts['titulo_seccion'];
                    $urlImage = $dts['url_image'];
                    $urlVideo = $dts['url_video'];
                }
            } else {
                $tituloSeccion = "";
                $urlImage = "";
                $urlVideo = "";
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $numeroTotalPendientes = 0;
        $numeroTotalSolucionadas = 0;
        $numeroTotalNuevos = 0;
        $numeroFinalizadas = 0;
        $fecHoy = date("Y-m-d");
        $fecAnterior = date("Y-m-d H:i:s", strtotime($fecHoy . " - 30 days"));

        //obtener el numero total de tareas pendientes y solucionadas
        if ($idDestino == 10) {
            $query = "SELECT status FROM t_mc WHERE id_seccion = $idSeccionTarea AND activo = 1";
        } else {
            $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
        }

        try {
            $tasks = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tasks as $t) {
                    $statusTask = $t['status'];
                    if ($statusTask == "N") {
                        $numeroTotalPendientes += 1;
                    } else if ($statusTask == "F") {
                        $numeroTotalSolucionadas += 1;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        if ($idDestino == 10) {
            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_seccion = $idSeccionTarea AND activo = 1";
        } else {
            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
        }

        try {
            $tasks = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tasks as $t) {
                    $statusTask = $t['status'];
                    if ($statusTask == "N") {
                        $numeroTotalNuevos += 1;
                    } else if ($statusTask == "F") {
                        $numeroFinalizadas += 1;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "<div class=\"column is-3 has-text-centered mr-5\">"
                . "<img src=\"svg/secciones/$urlImage\" class=\"mb-4\" width=\"40px\" alt=\"\">"
                . "<div class=\"columnaTarea\">";

        //Se buscan las subsecciones que esten asociadas a la seccion segun el destino
        if ($idDestino == 10) {
            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_seccion = $idSeccionTarea";
        } else {
            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idRelDestSecc = $dts['id'];
                }
                $query = "SELECT id, id_subseccion FROM c_rel_seccion_subseccion WHERE id_rel_seccion = $idRelDestSecc";
                try {
                    $rels = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($rels as $d) {
                            $idRelSubseccionCat = $d['id'];
                            $idSubseccion = $d['id_subseccion'];
                            $query = "SELECT grupo FROM c_subsecciones WHERE id = $idSubseccion";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $nombreSubsecion = $dts['grupo'];
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }
                            //Agregar las subsecciones a un arreglo para ordenarlos por orden alfabetico
                            $subSeccion = ["idSubseccion" => $idSubseccion, "nombreSubseccion" => $nombreSubsecion, "idRelSubseccionCat" => $idRelSubseccionCat];
                            $lstSecciones[] = $subSeccion;
                        }
                    }
                } catch (Exception $ex) {
                    $salida = $ex;
                }

                foreach ($lstSecciones as $key => $row) {
                    $aux[$key] = $row['nombreSubseccion'];
                }
                if (count($lstSecciones) > 0 && count($aux) > 0) {
                    array_multisort($aux, SORT_ASC, $lstSecciones);
                    foreach ($lstSecciones as $subseccion) {
                        $idRelSubseccionCat = $subseccion['idRelSubseccionCat'];
                        $query = "SELECT id, grupo FROM c_subsecciones WHERE id = " . $subseccion['idSubseccion'] . "";
                        try {
                            $resultsSS = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resultsSS as $ss) {
                                    $idSubseccion = $ss['id'];
                                    $nombreSubseccion = $ss['grupo'];
                                }
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }

                        //obtener total de tareas pendientes por subseccion
                        if ($idDestino == 10) {
                            $query = "SELECT id FROM t_mc "
                                    . "WHERE id_subseccion = $idSubseccion "
                                    . "AND activo = 1 "
                                    . "AND status = 'N'";
                        } else {
                            $query = "SELECT id FROM t_mc "
                                    . "WHERE id_destino = $idDestino "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND activo = 1 "
                                    . "AND status = 'N'";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            $penSubseccion = $conn->filasConsultadas;
                        } catch (Exception $ex) {
                            echo $ex;
                        }

                        //obtener total de tareas solucionadas por subseccion
                        if ($idDestino == 10) {
                            $query = "SELECT id FROM t_mc "
                                    . "WHERE id_subseccion = $idSubseccion "
                                    . "AND activo = 1 AND status = 'F'";
                        } else {
                            $query = "SELECT id FROM t_mc "
                                    . "WHERE id_destino = $idDestino "
                                    . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            $solSubseccion = $conn->filasConsultadas;
                        } catch (Exception $ex) {
                            echo $ex;
                        }

                        //********SECCION PROYECTOS************
                        if ($nombreSubseccion == "PROYECTOS") {//Si la subseccion son los proyectos
                            if ($idDestino == 10) {
                                $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                            } else {
                                $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                            }
                            try {
                                $proyectos = $conn->obtDatos($query);
                                $totalProys = $conn->filasConsultadas;
                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }

                            if ($idDestino == 10) {
                                $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                            } else {
                                $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                            }
                            try {
                                $proyectos = $conn->obtDatos($query);
                                $totalProysF = $conn->filasConsultadas;
                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }

                            $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\">"
                                    //Titulo de la subseccion
                                    . "<div class=\"column has-text-left is-8 pad-03 manita\">"
                                    . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
                                    . "</div>"
                                    //Contador de tareas
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($totalProysF > 0) {
                                $salida .= "<span class=\"tag is-success fs-10\">";
                                $numeroDigitos = strlen($totalProysF);
                                if ($numeroDigitos > 1) {
                                    $salida .= $totalProysF;
                                } else {
                                    $salida .= "0$totalProysF";
                                }
                                $salida .= "</span>";
                            }

                            $salida .= "</div>"
                                    . "</div>"
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($totalProys > 0) {
                                $salida .= "<span class=\"tag is-danger fs-10\">";
                                $numeroDigitos = strlen($totalProys);
                                if ($numeroDigitos > 1) {
                                    $salida .= $totalProys;
                                } else {
                                    $salida .= "0$totalProys";
                                }
                                $salida .= "</span>";
                            }

                            $salida .= "</div>"
                                    . "</div>"//Fin del contador de tareas
                                    . "</div>";
                            //Seccion del collapse
                            //*******LISTADO DE LOS PROYECTOS*********
                            $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">"
                                    . "<div class=\"columns is-mobile mb-2\">"
                                    . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
                                    . "<button class=\"button is-small\" onclick=\"showModal('modalCrearProyecto'); setProyectos($idSeccionTarea, $idSubseccion);\">Crear Proyecto</button>"
                                    . "</div>"
                                    . "</div>";
                            if ($idDestino == 10) {
                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino";
                            } else {
                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino ";
                            }

                            try {
                                $proyectos = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($proyectos as $pr) {
                                        $idProyecto = $pr['id'];
                                        $tituloProyecto = $pr['titulo'];
                                        $tipoProyecto = $pr['tipo'];
                                        $idDestinoProyecto = $pr['id_destino'];

                                        $query = "SELECT destino FROM c_destinos WHERE id = $idDestinoProyecto";
                                        try {
                                            $out = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($out as $s) {
                                                    $destinoProy = $s['destino'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }
                                        if ($tipoProyecto == "CAPEX") {
                                            $imgTipo = "<img src=\"svg/CAPEX1.svg\" width=\"100%\">";
                                        } else if ($tipoProyecto == "CAPIN") {
                                            $imgTipo = "<img src=\"svg/CAPIN1.svg\" width=\"100%\">";
                                        } else {
                                            $imgTipo = "";
                                        }

                                        $query = "SELECT id FROM t_proyectos_planaccion "
                                                . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'N'";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            $totalPA = $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }
                                        $query = "SELECT id FROM t_proyectos_planaccion "
                                                . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'F'";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            $totalPAF = $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }

                                        $salida .= "<div class=\"columns is-mobile mb-2 \" onclick=\"obtDetalleProyecto($idProyecto, $idDestino, $idSeccionTarea, $idSubseccion);\">"
                                                . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
                                                . "<h1 class=\"title is-7 text-truncate text-truncate-2 manita\" onclick=\"mostrarInfoProyecto('show');\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> ($destinoProy) " . strtoupper($tituloProyecto) . "</h1>"
                                                . "</div>"
                                                . "<div class=\"column is-1 pad-03\">"
                                                . "<div class=\"tags has-addons\">";
                                        if ($totalPAF > 0) {
                                            $salida .= "<span class=\"tag is-success fs-10\">";
                                            $numeroDigitos = strlen($totalPAF);
                                            if ($numeroDigitos > 1) {
                                                $salida .= $totalPAF;
                                            } else {
                                                $salida .= "0$totalPAF";
                                            }
                                            $salida .= "</span>";
                                        }
                                        $salida .= "</div>"
                                                . "</div>"
                                                . "<div class=\"column is-1 pad-03\">"
                                                . "<div class=\"tags has-addons\">";
                                        if ($totalPA > 0) {
                                            $salida .= "<span class=\"tag is-danger fs-10\">";
                                            $numeroDigitos = strlen($totalPA);
                                            if ($numeroDigitos > 1) {
                                                $salida .= $totalPA;
                                            } else {
                                                $salida .= "0$totalPA";
                                            }
                                            $salida .= "</span>";
                                        }
                                        $salida .= "</div>"
                                                . "</div>"
                                                . "</div>";
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }
                            $salida .= "</div>";
                        }
                        //******** RESTO DE LAS SECCIONES **********
                        else {//Las demas subsecciones
                            $salida .= "<div class=\"columns is-mobile mb-2 \">";
                            if ($idSubseccion == 12 || $idSubseccion == 342 || $idSubseccion == 343 || $idSubseccion == 344) {
                                $salida .= "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\" onclick=\"showHide('hoteles', $idDestino, $idSubseccion, 1);\">";
                            } else {
                                $salida .= "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, 1, 0, 0, 1);\">";
                            }

                            $salida .= "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
                                    . "</div>"
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($solSubseccion > 0) {
                                $salida .= "<span class=\"tag is-success fs-10\">";
                                $numeroDigitos = strlen($solSubseccion);
                                if ($numeroDigitos > 1) {
                                    $salida .= $solSubseccion;
                                } else {
                                    $salida .= "0$solSubseccion";
                                }
                                $salida .= "</span>";
                            }
                            $salida .= "</div>"
                                    . "</div>"
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($penSubseccion > 0) {
                                $salida .= "<span class=\"tag is-danger fs-10\">";
                                $numeroDigitos = strlen($penSubseccion);
                                if ($numeroDigitos > 1) {
                                    $salida .= $penSubseccion;
                                } else {
                                    $salida .= "0$penSubseccion";
                                }
                                $salida .= "</span>";
                            }
                            $salida .= "</div>"
                                    . "</div>"
                                    . "</div>";
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "</div>"
                . "</div>";

        $conn->cerrar();
        return $salida;
    }

    public function mostrarCols2($idUsuario, $idSeccionTarea, $fotoSeccion) {
        $salida = "";
        $lstSecciones = [];
        if (isset($_SESSION['idDestino'])) {
            $idDestino = $_SESSION['idDestino'];
        } else {
            $idDestino = 10;
        }

        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
        try {
            $out = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($out as $s) {
                    $destino = $s['destino'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $query = "SELECT seccion, titulo_seccion, url_image, url_video FROM c_secciones WHERE id = $idSeccionTarea";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $nombreSeccion = $dts['seccion'];
                    $tituloSeccion = $dts['titulo_seccion'];
                    $urlImage = $dts['url_image'];
                    $urlVideo = $dts['url_video'];
                }
            } else {
                $tituloSeccion = "";
                $urlImage = "";
                $urlVideo = "";
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $numeroTotalPendientes = 0;
        $numeroTotalSolucionadas = 0;
        $numeroTotalNuevos = 0;
        $numeroFinalizadas = 0;
        $fecHoy = date("Y-m-d");
        $fecAnterior = date("Y-m-d H:i:s", strtotime($fecHoy . " - 30 days"));

        //obtener el numero total de tareas pendientes y solucionadas
        if ($idDestino == 10) {
            $query = "SELECT status FROM t_mc WHERE id_seccion = $idSeccionTarea AND activo = 1";
        } else {
            $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
        }

        try {
            $tasks = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tasks as $t) {
                    $statusTask = $t['status'];
                    if ($statusTask == "N") {
                        $numeroTotalPendientes += 1;
                    } else if ($statusTask == "F") {
                        $numeroTotalSolucionadas += 1;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        if ($idDestino == 10) {
            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_seccion = $idSeccionTarea AND activo = 1";
        } else {
            $query = "SELECT status FROM t_mc WHERE fecha_creacion >= '$fecAnterior' AND id_destino = $idDestino AND id_seccion = $idSeccionTarea AND activo = 1";
        }

        try {
            $tasks = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($tasks as $t) {
                    $statusTask = $t['status'];
                    if ($statusTask == "N") {
                        $numeroTotalNuevos += 1;
                    } else if ($statusTask == "F") {
                        $numeroFinalizadas += 1;
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "<div class=\"column is-3 has-text-centered mr-5\">"
                . "<img src=\"svg/secciones/$urlImage\" class=\"mb-4\" width=\"40px\" alt=\"\">"
                . "<div class=\"columnaTarea\">";

        //Se buscan las subsecciones que esten asociadas a la seccion segun el destino
        if ($idDestino == 10) {
            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_seccion = $idSeccionTarea";
        } else {
            $query = "SELECT id FROM c_rel_destino_seccion WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idRelDestSecc = $dts['id'];
                }
                $query = "SELECT id, id_subseccion FROM c_rel_seccion_subseccion WHERE id_rel_seccion = $idRelDestSecc";
                try {
                    $rels = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($rels as $d) {
                            $idRelSubseccionCat = $d['id'];
                            $idSubseccion = $d['id_subseccion'];
                            $query = "SELECT grupo FROM c_subsecciones WHERE id = $idSubseccion";
                            try {
                                $resp = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($resp as $dts) {
                                        $nombreSubsecion = $dts['grupo'];
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }
                            //Agregar las subsecciones a un arreglo para ordenarlos por orden alfabetico
                            $subSeccion = ["idSubseccion" => $idSubseccion, "nombreSubseccion" => $nombreSubsecion, "idRelSubseccionCat" => $idRelSubseccionCat];
                            $lstSecciones[] = $subSeccion;
                        }
                    }
                } catch (Exception $ex) {
                    $salida = $ex;
                }

                foreach ($lstSecciones as $key => $row) {
                    $aux[$key] = $row['nombreSubseccion'];
                }
                if (count($lstSecciones) > 0 && count($aux) > 0) {
                    array_multisort($aux, SORT_ASC, $lstSecciones);
                    foreach ($lstSecciones as $subseccion) {
                        $idRelSubseccionCat = $subseccion['idRelSubseccionCat'];
                        $query = "SELECT id, grupo FROM c_subsecciones WHERE id = " . $subseccion['idSubseccion'] . "";
                        try {
                            $resultsSS = $conn->obtDatos($query);
                            if ($conn->filasConsultadas > 0) {
                                foreach ($resultsSS as $ss) {
                                    $idSubseccion = $ss['id'];
                                    $nombreSubseccion = $ss['grupo'];
                                }
                            }
                        } catch (Exception $ex) {
                            $salida = $ex;
                        }

                        //obtener total de tareas pendientes por subseccion
                        if ($idDestino == 10) {
                            $query = "SELECT id FROM t_mc "
                                    . "WHERE id_subseccion = $idSubseccion "
                                    . "AND activo = 1 "
                                    . "AND status = 'N'";
                        } else {
                            $query = "SELECT id FROM t_mc "
                                    . "WHERE id_destino = $idDestino "
                                    . "AND id_subseccion = $idSubseccion "
                                    . "AND activo = 1 "
                                    . "AND status = 'N'";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            $penSubseccion = $conn->filasConsultadas;
                        } catch (Exception $ex) {
                            echo $ex;
                        }

                        //obtener total de tareas solucionadas por subseccion
                        if ($idDestino == 10) {
                            $query = "SELECT id FROM t_mc "
                                    . "WHERE id_subseccion = $idSubseccion "
                                    . "AND activo = 1 AND status = 'F'";
                        } else {
                            $query = "SELECT id FROM t_mc "
                                    . "WHERE id_destino = $idDestino "
                                    . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                        }

                        try {
                            $resp = $conn->obtDatos($query);
                            $solSubseccion = $conn->filasConsultadas;
                        } catch (Exception $ex) {
                            echo $ex;
                        }

                        //********SECCION PROYECTOS************
                        if ($nombreSubseccion == "PROYECTOS") {//Si la subseccion son los proyectos
                            if ($idDestino == 10) {
                                $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                            } else {
                                $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N'";
                            }
                            try {
                                $proyectos = $conn->obtDatos($query);
                                $totalProys = $conn->filasConsultadas;
                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }

                            if ($idDestino == 10) {
                                $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                            } else {
                                $query = "SELECT id FROM t_proyectos "
                                        . "WHERE id_destino = $idDestino "
                                        . "AND id_seccion = $idSeccionTarea "
                                        . "AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'F'";
                            }
                            try {
                                $proyectos = $conn->obtDatos($query);
                                $totalProysF = $conn->filasConsultadas;
                                //$salida .= "<span class=\"badge bg-rojof text-white\">$totalProys</span>";
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }

                            $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\">"
                                    //Titulo de la subseccion
                                    . "<div class=\"column has-text-left is-8 pad-03 manita\">"
                                    . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
                                    . "</div>"
                                    //Contador de tareas
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($totalProysF > 0) {
                                $salida .= "<span class=\"tag is-success fs-10\">";
                                $numeroDigitos = strlen($totalProysF);
                                if ($numeroDigitos > 1) {
                                    $salida .= $totalProysF;
                                } else {
                                    $salida .= "0$totalProysF";
                                }
                                $salida .= "</span>";
                            }

                            $salida .= "</div>"
                                    . "</div>"
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($totalProys > 0) {
                                $salida .= "<span class=\"tag is-danger fs-10\">";
                                $numeroDigitos = strlen($totalProys);
                                if ($numeroDigitos > 1) {
                                    $salida .= $totalProys;
                                } else {
                                    $salida .= "0$totalProys";
                                }
                                $salida .= "</span>";
                            }

                            $salida .= "</div>"
                                    . "</div>"//Fin del contador de tareas
                                    . "</div>";
                            //Seccion del collapse
                            //*******LISTADO DE LOS PROYECTOS*********
                            $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">"
                                    . "<div class=\"columns is-mobile mb-2\">"
                                    . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
                                    . "<button class=\"button is-small\" onclick=\"showModal('modalCrearProyecto'); setProyectos($idSeccionTarea, $idSubseccion);\">Crear Proyecto</button>"
                                    . "</div>"
                                    . "</div>";
                            if ($idDestino == 10) {
                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino";
                            } else {
                                $query = "SELECT id, titulo, tipo, id_destino FROM t_proyectos WHERE id_destino = $idDestino AND id_seccion = $idSeccionTarea AND id_subseccion = $idSubseccion AND activo = 1 AND status = 'N' ORDER BY id_destino ";
                            }

                            try {
                                $proyectos = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($proyectos as $pr) {
                                        $idProyecto = $pr['id'];
                                        $tituloProyecto = $pr['titulo'];
                                        $tipoProyecto = $pr['tipo'];
                                        $idDestinoProyecto = $pr['id_destino'];

                                        $query = "SELECT destino FROM c_destinos WHERE id = $idDestinoProyecto";
                                        try {
                                            $out = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($out as $s) {
                                                    $destinoProy = $s['destino'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }
                                        if ($tipoProyecto == "CAPEX") {
                                            $imgTipo = "<img src=\"svg/CAPEX1.svg\" width=\"100%\">";
                                        } else if ($tipoProyecto == "CAPIN") {
                                            $imgTipo = "<img src=\"svg/CAPIN1.svg\" width=\"100%\">";
                                        } else {
                                            $imgTipo = "";
                                        }

                                        $query = "SELECT id FROM t_proyectos_planaccion "
                                                . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'N'";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            $totalPA = $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }
                                        $query = "SELECT id FROM t_proyectos_planaccion "
                                                . "WHERE id_proyecto = $idProyecto AND activo = 1 AND status = 'F'";
                                        try {
                                            $resp = $conn->obtDatos($query);
                                            $totalPAF = $conn->filasConsultadas;
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }

                                        $salida .= "<div class=\"columns is-mobile mb-2 \" onclick=\"obtDetalleProyecto($idProyecto, $idDestino, $idSeccionTarea, $idSubseccion);\">"
                                                . "<div class=\"column is-10 has-text-left is-three-fifths pad-03 ml-3\">"
                                                . "<h1 class=\"title is-7 text-truncate text-truncate-2 manita\" onclick=\"mostrarInfoProyecto('show');\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> ($destinoProy) " . strtoupper($tituloProyecto) . "</h1>"
                                                . "</div>"
                                                . "<div class=\"column is-1 pad-03\">"
                                                . "<div class=\"tags has-addons\">";
                                        if ($totalPAF > 0) {
                                            $salida .= "<span class=\"tag is-success fs-10\">";
                                            $numeroDigitos = strlen($totalPAF);
                                            if ($numeroDigitos > 1) {
                                                $salida .= $totalPAF;
                                            } else {
                                                $salida .= "0$totalPAF";
                                            }
                                            $salida .= "</span>";
                                        }
                                        $salida .= "</div>"
                                                . "</div>"
                                                . "<div class=\"column is-1 pad-03\">"
                                                . "<div class=\"tags has-addons\">";
                                        if ($totalPA > 0) {
                                            $salida .= "<span class=\"tag is-danger fs-10\">";
                                            $numeroDigitos = strlen($totalPA);
                                            if ($numeroDigitos > 1) {
                                                $salida .= $totalPA;
                                            } else {
                                                $salida .= "0$totalPA";
                                            }
                                            $salida .= "</span>";
                                        }
                                        $salida .= "</div>"
                                                . "</div>"
                                                . "</div>";
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }
                            $salida .= "</div>";
                        }
                        //******** RESTO DE LAS SECCIONES **********
                        else {//Las demas subsecciones
                            $salida .= "<div class=\"columns is-mobile mb-2 \" data-toggle=\"collapse\" href=\"#collpaseCategoria$idSeccionTarea$idSubseccion\" >"
                                    . "<div class=\"column has-text-left is-8 pad-03 manita\" data-tooltip=\"$nombreSubseccion\">"
                                    . "<h1 class=\"title is-6 text-truncate\"><span><i class=\"fas fa-caret-right has-text-info\"></i></span> $nombreSubseccion</h1>"
                                    . "</div>"
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($solSubseccion > 0) {
                                $salida .= "<span class=\"tag is-success fs-10\">";
                                $numeroDigitos = strlen($solSubseccion);
                                if ($numeroDigitos > 1) {
                                    $salida .= $solSubseccion;
                                } else {
                                    $salida .= "0$solSubseccion";
                                }
                                $salida .= "</span>";
                            }
                            $salida .= "</div>"
                                    . "</div>"
                                    . "<div class=\"column is-1 pad-03\">"
                                    . "<div class=\"tags has-addons\">";
                            if ($penSubseccion > 0) {
                                $salida .= "<span class=\"tag is-danger fs-10\">";
                                $numeroDigitos = strlen($penSubseccion);
                                if ($numeroDigitos > 1) {
                                    $salida .= $penSubseccion;
                                } else {
                                    $salida .= "0$penSubseccion";
                                }
                                $salida .= "</span>";
                            }
                            $salida .= "</div>"
                                    . "</div>"
                                    . "</div>";

                            $salida .= "<div class=\"column collapse pad-03\" id=\"collpaseCategoria$idSeccionTarea$idSubseccion\">";
                            $query = "SELECT id, id_categoria FROM c_rel_subseccion_categoria WHERE id_rel_subseccion = $idRelSubseccionCat";

                            try {
                                $relcategorias = $conn->obtDatos($query);
                                if ($conn->filasConsultadas > 0) {
                                    foreach ($relcategorias as $c) {
                                        $idRelSubcategoria = $c['id'];
                                        $idCategoria = $c['id_categoria'];

                                        $query = "SELECT categoria, equipos FROM c_categorias_planner WHERE id = $idCategoria";
                                        try {
                                            $cats = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($cats as $cc) {
                                                    $nombreCategoria = $cc['categoria'];
                                                    $verEquipos = $cc['equipos'];
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            $salida = $ex;
                                        }

                                        //*************PREVENTIVO CORRECTIVO Y EQUIPOS****************
                                        if ($nombreCategoria == "MP/MC - EQUIPOS") {//Equipos y tareas
                                            //obtener total por categoria
                                            if ($idDestino == 10) {
                                                $query = "SELECT id FROM t_mc "
                                                        . "WHERE id_subseccion = $idSubseccion "
                                                        //. "AND id_categoria = $idCategoria "
                                                        . "AND activo = 1 "
                                                        . "AND status = 'N'";
                                            } else {
                                                $query = "SELECT id FROM t_mc "
                                                        . "WHERE id_destino = $idDestino "
                                                        . "AND id_subseccion = $idSubseccion "
                                                        //. "AND id_categoria = $idCategoria "
                                                        . "AND activo = 1 "
                                                        . "AND status = 'N'";
                                            }
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                $penCategoria = $conn->filasConsultadas;
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }

                                            if ($idDestino == 10) {
                                                $query = "SELECT id FROM t_mc "
                                                        . "WHERE id_subseccion = $idSubseccion "
                                                        //. "AND id_categoria = $idCategoria "
                                                        . "AND activo = 1 "
                                                        . "AND status = 'F'";
                                            } else {
                                                $query = "SELECT id FROM t_mc "
                                                        . "WHERE id_destino = $idDestino "
                                                        . "AND id_subseccion = $idSubseccion "
                                                        //. "AND id_categoria = $idCategoria "
                                                        . "AND activo = 1 "
                                                        . "AND status = 'F'";
                                            }
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                $solCategoria = $conn->filasConsultadas;
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }

//                                            //obtener total de tareas generales 
//                                            if ($idDestino == 10) {
//                                                $query = "SELECT id FROM t_mc "
//                                                        . "WHERE id_subseccion = $idSubseccion "
//                                                        . "AND id_categoria = 6 "
//                                                        . "AND activo = 1 "
//                                                        . "AND status = 'N'";
//                                            } else {
//                                                $query = "SELECT id FROM t_mc "
//                                                        . "WHERE id_destino = $idDestino "
//                                                        . "AND id_subseccion = $idSubseccion "
//                                                        . "AND id_categoria = 6 "
//                                                        . "AND activo = 1 "
//                                                        . "AND status = 'N'";
//                                            }
//                                            try {
//                                                $resp = $conn->obtDatos($query);
//                                                $totalTareas = $conn->filasConsultadas;
//                                            } catch (Exception $ex) {
//                                                echo $ex;
//                                            }
                                            $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
                                            try {
                                                $result = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {//Si la categoria tiene subcategorias
                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                    if ($verEquipos == 1) {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    } else {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    }


                                                    $salida .= "<h1 class=\"title is-7\" data-toggle=\"collapse\" href=\"#collpaseSubcategoria$idRelSubcategoria\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";


                                                    $salida .= "</div>"
                                                            . "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($solCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-success fs-10\">";
                                                        //$totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($solCategoria);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $solCategoria;
                                                        } else {
                                                            $salida .= "0$solCategoria";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($penCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-danger fs-10\">";
                                                        //$totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($penCategoria);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $penCategoria;
                                                        } else {
                                                            $salida .= "0$penCategoria";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "</div>"
                                                            . "<div class=\"column collapse pad-06\" id=\"collpaseSubcategoria$idRelSubcategoria\">";
                                                    $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
                                                    try {
                                                        $relSC = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($relSC as $sc) {
                                                                $idRelCatSubcat = $sc['id'];
                                                                $idSubcategoria = $sc['id_subcategoria'];

                                                                $query = "SELECT subcategoria, equipos FROM c_subcategorias_planner WHERE id = $idSubcategoria";
                                                                try {
                                                                    $subcategorias = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($subcategorias as $scs) {
                                                                            $nombreSubcategoria = $scs['subcategoria'];
                                                                            $verEquipo = $scs['equipos'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                //Obtener pendientes po subcategoria
                                                                if ($idDestino == 10) {
                                                                    $query = "SELECT id FROM t_mc "
                                                                            . "WHERE id_subseccion = $idSubseccion "
                                                                            . "AND id_subcategoria = $idSubcategoria "
                                                                            . "AND activo = 1 "
                                                                            . "AND status = 'N'";
                                                                } else {
                                                                    $query = "SELECT id FROM t_mc "
                                                                            . "WHERE id_destino = $idDestino "
                                                                            . "AND id_subseccion = $idSubseccion "
                                                                            . "AND id_subcategoria = $idSubcategoria "
                                                                            . "AND activo = 1 AND status = 'N'";
                                                                }
                                                                try {
                                                                    $resp = $conn->obtDatos($query);
                                                                    $penSubcategoria = $conn->filasConsultadas;
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                if ($idDestino == 10) {
                                                                    $query = "SELECT id FROM t_mc "
                                                                            . "WHERE id_subseccion = $idSubseccion "
                                                                            . "AND id_subcategoria = $idSubcategoria "
                                                                            . "AND activo = 1 "
                                                                            . "AND status = 'F'";
                                                                } else {
                                                                    $query = "SELECT id FROM t_mc "
                                                                            . "WHERE id_destino = $idDestino "
                                                                            . "AND id_subseccion = $idSubseccion "
                                                                            . "AND id_subcategoria = $idSubcategoria "
                                                                            . "AND activo = 1 "
                                                                            . "AND status = 'F'";
                                                                }
                                                                try {
                                                                    $resp = $conn->obtDatos($query);
                                                                    $solSubcategoria = $conn->filasConsultadas;
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                                if ($verEquipos == 1) {
                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                                } else {
                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                                }


                                                                $salida .= "<h1 class=\"title is-7\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria);\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span>" . strtoupper($nombreSubcategoria) . "</h1>";


                                                                $salida .= "</div>"
                                                                        . "<div class=\"column is-1 pad-03\">"
                                                                        . "<div class=\"tags has-addons\">";
                                                                if ($solSubcategoria > 0) {
                                                                    $salida .= "<span class=\"tag is-success fs-10\">";
                                                                    //$totalTareasGrales = $penSubcategoria + $totalTareas;
                                                                    $numeroDigitos = strlen($solSubcategoria);
                                                                    if ($numeroDigitos > 1) {
                                                                        $salida .= $solSubcategoria;
                                                                    } else {
                                                                        $salida .= "0$solSubcategoria";
                                                                    }
                                                                    $salida .= "</span>";
                                                                }
                                                                $salida .= "</div>"
                                                                        . "</div>";
                                                                $salida .= "<div class=\"column is-1 pad-03\">"
                                                                        . "<div class=\"tags has-addons\">";
                                                                if ($penSubcategoria > 0) {
                                                                    $salida .= "<span class=\"tag is-danger fs-10\">";
                                                                    //$totalTareasGrales = $penSubcategoria + $totalTareas;
                                                                    $numeroDigitos = strlen($penSubcategoria);
                                                                    if ($numeroDigitos > 1) {
                                                                        $salida .= $penSubcategoria;
                                                                    } else {
                                                                        $salida .= "0$penSubcategoria";
                                                                    }
                                                                    $salida .= "</span>";
                                                                }
                                                                $salida .= "</div>"
                                                                        . "</div>";
                                                                $salida .= "</div>";
                                                            }
                                                        }
                                                    } catch (Exception $ex) {
                                                        $salida = $ex;
                                                    }
                                                    $salida .= "</div>";
                                                } else {
                                                    $idSubcategoria = 0;
                                                    $salida .= "<div class=\"columns is-mobile mb-2 \">";
                                                    if ($verEquipos == 1) {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03 manita\">";
                                                    } else {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03 manita\">";
                                                    }
                                                    $salida .= "<h1 class=\"title is-7\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, $idCategoria, $idSubcategoria, $idRelSubcategoria);\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>"
                                                            . "</div>"
                                                            . "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($solCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-success fs-10\">";
                                                        //$totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($solCategoria);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $solCategoria;
                                                        } else {
                                                            $salida .= "0$solCategoria";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($penCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-danger fs-10\">";
                                                        //$totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($penCategoria);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $penCategoria;
                                                        } else {
                                                            $salida .= "0$penCategoria";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "</div>";
                                                }
                                            } catch (Exception $ex) {
                                                $salida = $ex;
                                            }
                                        }
                                        //**********+BITACORAS STOCK INFORMACION*********************
                                        elseif ($nombreCategoria == "BITACORAS" || $nombreCategoria == "STOCK - PEDIDOS" || $nombreCategoria == "INFORMACION") {
                                            //obtener total por categoria
                                            if ($idDestino == 10) {
                                                $query = "SELECT id FROM t_mc WHERE id_subseccion = $idSubseccion AND id_categoria = $idCategoria AND activo = 1 AND status = 'N'";
                                            } else {
                                                $query = "SELECT id FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_categoria = $idCategoria AND activo = 1 AND status = 'N'";
                                            }
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                $penCategoria = $conn->filasConsultadas;
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }
                                            $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
                                            try {
                                                $result = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {//Si la categoria tiene subcategorias
                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                    if ($verEquipos == 1) {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    } else {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    }

                                                    if ($nombreCategoria == "STOCK - PEDIDOS") {
                                                        $salida .= "<h1 class=\"title is-7\" ><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a class=\"title is-7\" href=\"stock/stock-necesario.php?idSubseccion=$idSubseccion\">" . strtoupper($nombreCategoria) . "</a></h1>";
                                                    } else {
                                                        $salida .= "<h1 class=\"title is-7\" data-toggle=\"collapse\" href=\"#collpaseSubcategoria$idRelSubcategoria\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";
                                                    }

                                                    $salida .= "</div>";
                                                    $salida .= "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($penCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-danger\">";
                                                        $totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($totalTareasGrales);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $totalTareasGrales;
                                                        } else {
                                                            $salida .= "0$totalTareasGrales";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "</div>"
                                                            . "<div class=\"column collapse pad-06\" id=\"collpaseSubcategoria$idRelSubcategoria\">";
                                                    $query = "SELECT * FROM c_rel_categoria_subcategoria WHERE id_rel_categoria = $idRelSubcategoria";
                                                    try {
                                                        $relSC = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($relSC as $sc) {
                                                                $idRelCatSubcat = $sc['id'];
                                                                $idSubcategoria = $sc['id_subcategoria'];

                                                                $query = "SELECT * FROM c_subcategorias_planner WHERE id = $idSubcategoria";
                                                                try {
                                                                    $subcategorias = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($subcategorias as $scs) {
                                                                            $nombreSubcategoria = $scs['subcategoria'];
                                                                            $verEquipo = $scs['equipos'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                //Obtener pendientes po subcategoria
                                                                if ($idDestino == 10) {
                                                                    $query = "SELECT * FROM t_mc WHERE id_subseccion = $idSubseccion AND id_subcategoria = $idSubcategoria AND activo = 1 AND status = 'N'";
                                                                } else {
                                                                    $query = "SELECT * FROM t_mc WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion AND id_subcategoria = $idSubcategoria AND activo = 1 AND status = 'N'";
                                                                }
                                                                try {
                                                                    $resp = $conn->obtDatos($query);
                                                                    $penSubcategoria = $conn->filasConsultadas;
                                                                } catch (Exception $ex) {
                                                                    $salida = $ex;
                                                                }

                                                                $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                                if ($verEquipos == 1) {
                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                                } else {
                                                                    $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                                }


                                                                $salida .= "<h1 class=\"title is-7\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a href=\"file-explorer.php?p=/$destino/$nombreSubcategoria/$nombreSeccion/$nombreSubseccion\">" . strtoupper($nombreSubcategoria) . "</a></h1>";


                                                                $salida .= "</div>";
                                                                $salida .= "<div class=\"column is-1 pad-03\">"
                                                                        . "<div class=\"tags has-addons\">";
                                                                if ($penSubcategoria > 0) {
                                                                    $salida .= "<span class=\"tag is-danger\">";
                                                                    $totalTareasGrales = $penSubcategoria + $totalTareas;
                                                                    $numeroDigitos = strlen($totalTareasGrales);
                                                                    if ($numeroDigitos > 1) {
                                                                        $salida .= $totalTareasGrales;
                                                                    } else {
                                                                        $salida .= "0$totalTareasGrales";
                                                                    }
                                                                    $salida .= "</span>";
                                                                }
                                                                $salida .= "</div>"
                                                                        . "</div>";
                                                                $salida .= "</div>";
                                                            }
                                                        }
                                                    } catch (Exception $ex) {
                                                        $salida = $ex;
                                                    }
                                                    $salida .= "</div>";
                                                } else {
                                                    $idSubcategoria = 0;
                                                    $salida .= "<div class=\"columns is-mobile mb-2 manita \">";
                                                    if ($verEquipos == 1) {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    } else {
                                                        $salida .= "<div class=\"column is-10 ml-3 has-text-left is-three-fifths pad-03\">";
                                                    }

                                                    if ($nombreCategoria == "STOCK - PEDIDOS") {
                                                        $salida .= "<h1 class=\"title is-7\" ><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> <a class=\"title is-7\" href=\"stock/stock-necesario.php?idSubseccion=$idSubseccion\">" . strtoupper($nombreCategoria) . "</a></h1>";
                                                    } else {
                                                        $salida .= "<h1 class=\"title is-7\"><span><i class=\"fas fa-caret-right has-text-danger\" ></i></span> " . strtoupper($nombreCategoria) . "</h1>";
                                                    }

                                                    $salida .= "</div>";
                                                    $salida .= "<div class=\"column is-1 pad-03\">"
                                                            . "<div class=\"tags has-addons\">";
                                                    if ($penCategoria > 0) {
                                                        $salida .= "<span class=\"tag is-danger\">";
                                                        $totalTareasGrales = $penCategoria + $totalTareas;
                                                        $numeroDigitos = strlen($totalTareasGrales);
                                                        if ($numeroDigitos > 1) {
                                                            $salida .= $totalTareasGrales;
                                                        } else {
                                                            $salida .= "0$totalTareasGrales";
                                                        }
                                                        $salida .= "</span>";
                                                    }
                                                    $salida .= "</div>"
                                                            . "</div>";
                                                    $salida .= "</div>";
                                                }
                                            } catch (Exception $ex) {
                                                $salida = $ex;
                                            }
                                        }
                                    }
                                }
                            } catch (Exception $ex) {
                                $salida = $ex;
                            }

                            $salida .= "</div>";
                        }
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "</div>"
                . "</div>";

        $conn->cerrar();
        return $salida;
    }

}
?>