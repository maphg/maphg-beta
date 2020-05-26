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

//OBTENER AVANCE A NIVEL COMPLEJO
//Total de tareas 
$totalPendientesCurrent = 0;
$totalSolucionadasCurrent = 0;
$porcentajeCurrent = 0;
$lstRanking = [];

//Se obtiene los totales del complejo seleccionado
if ($idDestinoT != 10) {
    $query = "SELECT * FROM t_ordenes_trabajo WHERE id_destino = $idDestinoT";
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
            $query = "SELECT * FROM t_ordenes_trabajo WHERE id_destino = $idD";
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

if (isset($_SESSION['idSeccion'])) {
    $idSeccionSesion = $_SESSION['idSeccion'];
} else {
    $idSeccionSesion = 0;
}

//obtener datos de pendientes de MC

$hoy = date('m/d/Y');
$hoyMysql = date("Y-m-d H:i:s", strtotime($hoy . "23:59:59"));
$mesAtras = date("m/d/Y", strtotime('-1 month'));
$mesAtrasMysql = date("Y-m-d H:i:s", strtotime($mesAtras));


if ($idDestinoT == 10) {
    if ($idSeccionSesion != 0) {
        $query = "SELECT * FROM t_equipos "
                . "WHERE id_seccion = $idSeccionSesion "
                . "AND status = 'A' "
                . "ORDER BY id_destino";
    } else {
        $query = "SELECT * FROM t_equipos "
                . "WHERE status = 'A' "
                . "ORDER BY id_destino";
    }
} else {
    if ($idSeccionSesion != 0) {
        $query = "SELECT * FROM t_equipos "
                . "WHERE id_destino = $idDestinoT "
                . "AND id_seccion = $idSeccionSesion "
                . "AND status = 'A' "
                . "ORDER BY id_destino";
    } else {
        $query = "SELECT * FROM t_equipos "
                . "WHERE id_destino = $idDestinoT "
                . "AND status = 'A' "
                . "ORDER BY id_destino";
    }
}

try {
    $equipos = $conn->obtDatos($query);
} catch (Exception $ex) {
    echo $ex;
}
?>
<!DOCTYPE html>
<html>

    <head>
        <?php echo $layout->styles(); ?>
        <link rel="stylesheet" href="DataTables/datatables.css">
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
                    <?php //echo $layout->menu();   ?>
                </nav>

                <!--SECCIO HERO-->
                <section class="hero is-primary is-small mt-5">
                    <!--Hero head: will stick at the top--> 
                    <div class="hero-head">
                        <div class="columns">
                            <div class="column">
                                <div class="container">
                                    <div class="navbar-end">
                                        <a class="navbar-item " href="index.php">
                                            Planner
                                        </a>
                                        <a class="navbar-item" href="correctivos.php">
                                            Correctivo
                                        </a>
                                        <a class="navbar-item is-active" href="preventivos.php">
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

                    <!--Hero content: will be in the middle--> 
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

                </section>

                <!--SECCION DE SELECTS-->
                <section class="mt-2">
                    <div class="columns is-centered px-3">

                        <div class="column is-one-fifth">
                            <div class="control has-icons-left has-text-centered">
                                <div class="select is-medium is-fullwidth">
                                    <?php
                                    if ($idPermiso == 1 || $idPermiso == 3):
                                        ?>
                                        <select id="cbSecciones" onchange="cargarSeccionSession(); return false;">
                                            <option value="0">-TODOS-</option>
                                            <?php
                                            $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";
                                            try {
                                                $secciones = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($secciones as $dts) {
                                                        $idSec = $dts['id'];
                                                        $nombreSec = $dts['seccion'];

                                                        if ($idSeccionSesion == $idSec) {
                                                            echo "<option value=\"$idSec\" selected>$nombreSec</option>";
                                                        } else {
                                                            echo "<option value=\"$idSec\">$nombreSec</option>";
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

                <!--SECCION BARRA DE OPCIONES-->
                <section>
                    <div class="columns is-centered px-4 has-background-dark my-4 pt-1">
                        <div class="column is-1">
                            <div class="field has-addons">
                                <p class="control">
                                    <a class="button is-link is-outlined" href="index.php">
                                        <span class="icon is-small"><i class="fas fa-home"></i></span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="column has-text-centered">
                            <div class="columns is-centered">
                                <div class="column is-3">
                                    <div class="control has-icons-left has-icons-right">
                                        <input id="rangoFechas" class="input is-small datepicker-here" type="text" data-date-format="mm/dd/yyyy" placeholder="Inicio - Fin">
                                        <span class="icon is-left">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="column is-2">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-small">
                                                <select id="cbSubsecciones" onchange="buscarEquipos();">
                                                    <?php
                                                    if ($idSeccionSesion == 0) {
                                                        $query = "SELECT * FROM c_subsecciones WHERE id != 200 ORDER BY id_seccion";
                                                        echo "<option value=\"0\" selected>-Todas las subsecciones-</option>";
                                                    } else {
                                                        $query = "SELECT * FROM c_subsecciones WHERE id_seccion = $idSeccionSesion AND id != 200 ORDER BY id_seccion";
                                                        echo "<option value=\"0\">-Todas las subsecciones-</option>";
                                                    }
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idSubsec = $dts['id'];
                                                                $nombreSubseccion = $dts['grupo'];
                                                                echo "<option value=\"$idSubsec\">$nombreSubseccion</option>";
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
                                <div class="column is-2">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-small">
                                                <select id="cbEquipos" >
                                                    <option value="0">-Todos los equipos-</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-4">
                                    <div class="field has-text-white">
                                        <input class="is-checkradio is-small" id="rdbtnTodos" type="radio" name="estatus" value="todos" checked>
                                        <label for="rdbtnTodos">Todos</label>
                                        <input class="is-checkradio is-small" id="rdbtnPen" type="radio" name="estatus" value="pendientes">
                                        <label for="rdbtnPen">Pendientes</label>
                                        <input class="is-checkradio is-small" id="rdbtnSol" type="radio" name="estatus" value="solucionados">
                                        <label for="rdbtnSol">Solucionados</label>
                                    </div>
                                </div>

                                <div class="column">
                                    <button class="button is-info is-small" onclick="buscarMP();">
                                        Buscar
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                </section>

                <!--SECCION DATOS DE USUARIO Y CORRECTIVOS-->
                <section>
                    <div class="columns is-centered">
                        <div class="column is-4 has-text-centered">
                            <h4 class="subtitle is-4">
                                Preventivos
                            </h4>
                        </div>
                    </div>
                    <div class="columns px-3">

                        <div class="column is-12">
                            <h5 class="subtitle is-5">
                                Preventivos Complejo
                            </h5>

                            <div class="columns is-centered container-scroll">
                                <div class="column is-12 is-mobile px-4">
                                    <div class="table-container">
                                        <table id="tablaMP" class="table is-size-7" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>SUBSECCION</th>
                                                    <th>PLAN MP</th>
                                                    <th>EQUIPO</th>
                                                    <th># OT</th>
                                                    <th>ESTATUS</th>
                                                    <th>REALIZADO POR</th>
                                                    <th>FECHA REALIZADO</th>
                                                    <th>Ver OT</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>SUBSECCION</th>
                                                    <th>PLAN MP</th>
                                                    <th>EQUIPO</th>
                                                    <th># OT</th>
                                                    <th>ESTATUS</th>
                                                    <th>REALIZADO POR</th>
                                                    <th>FECHA REALIZADO</th>
                                                    <th>Ver OT</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="tbodyTabla">
                                                <?php
                                                foreach ($equipos as $dts) {
                                                    $idEquipo = $dts['id'];
                                                    $equipo = $dts['equipo'];
                                                    $idSubseccionEq = $dts['id_subseccion'];
                                                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionEq";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $nombreSubseccion = $dts['grupo'];
                                                            }
                                                        } else {
                                                            $nombreSubseccion = "Todas las subsecciones";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    $query = "SELECT * FROM t_ordenes_trabajo WHERE id_equipo = $idEquipo "
                                                            . "AND (fecha_creacion >= '$mesAtrasMysql' AND fecha_creacion <= '$hoyMysql')";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idOT = $dts['id'];
                                                                $folio = $dts['folio'];
                                                                $idPlaneacion = $dts['id_planeacion_mp'];
                                                                $fechaCreacion = $dts['fecha_creacion'];
                                                                $listaActividades = $dts['lista_actividades'];

                                                                $query = "SELECT * FROM t_mp_planeacion WHERE id = $idPlaneacion";
                                                                try {
                                                                    $result = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($result as $d) {
                                                                            $idPlan = $d['id_plan'];
                                                                            $status = $d['status'];

                                                                            $query = "SELECT * FROM t_planes_mantto WHERE id = $idPlan";
                                                                            try {
                                                                                $r = $conn->obtDatos($query);
                                                                                if ($conn->filasConsultadas > 0) {
                                                                                    foreach ($r as $f) {
                                                                                        $nombrePlan = $f['nombre'];
                                                                                    }
                                                                                } else {
                                                                                    $nombrePlan = "";
                                                                                }
                                                                            } catch (Exception $ex) {
                                                                                echo $ex;
                                                                            }
                                                                        }
                                                                    } else {
                                                                        $array = explode(",", $listaActividades);
                                                                        for ($i = 0; $i < count($array); $i++) {
                                                                            if ($array[$i] != "") {
                                                                                $idActividad = $array[$i];
                                                                            }
                                                                        }

                                                                        $query = "SELECT * FROM t_planes_actividades WHERE id = $idActividad";

                                                                        try {
                                                                            $resp = $conn->obtDatos($query);
                                                                            if ($conn->filasConsultadas > 0) {
                                                                                foreach ($resp as $dts) {
                                                                                    $idPlan = $dts['id_mantto'];
                                                                                }
                                                                            }
                                                                        } catch (Exception $ex) {
                                                                            echo $ex;
                                                                        }

                                                                        //Obtener el nombre del plan
                                                                        $query = "SELECT * FROM t_planes_mantto WHERE id = $idPlan";
                                                                        try {
                                                                            $resp = $conn->obtDatos($query);
                                                                            if ($conn->filasConsultadas > 0) {
                                                                                foreach ($resp as $dts) {
                                                                                    $nombrePlan = $dts['nombre'];
                                                                                }
                                                                            } else {
                                                                                $nombrePlan = "";
                                                                            }
                                                                        } catch (Exception $ex) {
                                                                            echo $ex;
                                                                        }
                                                                    }

                                                                    if ($status == "F") {
                                                                        $status = "FINALIZADO";
                                                                        $query = "SELECT * FROM t_mp_realizado WHERE id_ot = $idOT";
                                                                        try {
                                                                            $resp = $conn->obtDatos($query);
                                                                            if ($conn->filasConsultadas > 0) {
                                                                                foreach ($resp as $dts) {
                                                                                    $fechaRealizado = $dts['fecha_realizado'];
                                                                                    $realizadoPor = $dts['realizado_por'];

                                                                                    $query = "SELECT * FROM t_colaboradores WHERE id = $realizadoPor";
                                                                                    try {
                                                                                        $resp = $conn->obtDatos($query);
                                                                                        if ($conn->filasConsultadas > 0) {
                                                                                            foreach ($resp as $dts) {
                                                                                                $nombre = $dts['nombre'];
                                                                                                $apellido = $dts['apellido'];
                                                                                            }
                                                                                        } else {
                                                                                            $nombre = "";
                                                                                            $apellido = "";
                                                                                        }
                                                                                    } catch (Exception $ex) {
                                                                                        echo $ex;
                                                                                    }
                                                                                }
                                                                            } else {
                                                                                $fechaRealizado = "";
                                                                                $nombre = "";
                                                                                $apellido = "";
                                                                            }
                                                                        } catch (Exception $ex) {
                                                                            echo $ex;
                                                                        }
                                                                    } else {
                                                                        $status = "PENDIENTE";
                                                                        $fechaRealizado = "";
                                                                        $nombre = "";
                                                                        $apellido = "";
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    echo $ex;
                                                                }

                                                                echo "<tr>"
                                                                . "<td>$nombreSubseccion</td>"
                                                                . "<td>$nombrePlan</td>"
                                                                . "<td>$equipo</td>"
                                                                . "<td>$folio</td>"
                                                                . "<td>$status</td>"
                                                                . "<td>$nombre $apellido</td>"
                                                                . "<td>$fechaRealizado</td>"
                                                                . "<td><a href=\"planner/ver-orden-trabajo.php?idEquipo=$idEquipo&idOT=$idOT\" target=\"_blank\">Ver OT</a></td>"
                                                                . "</tr>";
                                                            }
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
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

        <a id="btnAncla" href="#nav-menu" class="button is-primary is-rounded ancla" style="display:none;"><i class="fa fa-arrow-up"></i></a>
    </body>
    <?php echo $layout->scripts(); ?>

    <script src="js/plannerJS.js"></script>
    <script src="js/usuariosJS.js"></script>
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



            var tablaMP = $('#tablaMP').DataTable({
                "order": [[1, "desc"]],
                "select": true,
                "scrollY": "50vh",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                "autoWidth": true,
                'dom': 'Rlfrtip',
                'colReorder': {
                    'allowReorder': false
                },
                "columnDefs": [
                    {"width": "100%", "targets": 2}
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Reporte de pendientes de Usuarios',
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

            tablaMP
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = tablaMC.rows(indexes).data().toArray();
                        $("#hddIdRegistro").val(rowData[0][0]);
                        $.ajax({
                            type: 'post',
                            url: '../php/stockPHP.php',
                            data: 'action=6&idRegistro=' + rowData[0][0],
                            success: function (data) {
                                var registro = JSON.parse(data);

//                                                                $("#cbDestinoRegEdit").val(registro.idDestino);
//                                                                $("#cbDestinoRegEdit").selectpicker('refresh');
//                                                                $("#cbFaseEdit").val(registro.fase);
//                                                                $("#cbFaseEdit").selectpicker('refresh');
////                                                        $("#txtUbicacionEdit").val(registro.ubicacion);
//                                                                $("#txtCod2bendEdit").val(registro.cod2bend);
//                                                                $("#txtDesc2bendEdit").val(registro.descripcion2bend);
//                                                                $("#cbNaturalezaEdit").val(registro.naturaleza);
//                                                                $("#cbNaturalezaEdit").selectpicker('refresh');
//                                                                $("#cbSeccionEdit").val(registro.seccion);
//                                                                $("#cbSeccionEdit").selectpicker('refresh');
//                                                                $("#cbFamiliaEdit").val(registro.familia);
//                                                                $("#cbFamiliaEdit").selectpicker('refresh');
//                                                                $("#cbSubfamiliaEdit").val(registro.subfamilia);
//                                                                $("#cbSubfamiliaEdit").selectpicker('refresh');
//                                                                $("#txtDescNuevaEdit").val(registro.descripcionNueva);
//                                                                $("#txtMarcaEdit").val(registro.marca);
//                                                                $("#txtModeloEdit").val(registro.modelo);
//                                                                $("#txtCaracteristicasPpalesEdit").val(registro.caracteristicasPpales);
//                                                                $("#txtExistencias2bendEdit").val(registro.existencias2bend);
//                                                                $("#txtExistenciasSubalmacenEdit").val(registro.existenciasSubalmacen);
//                                                                $("#txtPrecioEdit").val(registro.precio)
//                                                                $("#txtConsumoAnualEdit").val(registro.consumoAnual);
//                                                                $("#txtStockNecesarioEdit").val(registro.stockNecesario);
//                                                                $("#txtUnidadesAPedirEdit").val(registro.unidadesPedir);
//                                                                $("#txtFechaPedidoEdit").val(registro.fechaPedido);
//                                                                $("#txtPrioridadEdit").val(registro.prioridad);
//                                                                $("#txtFechaLlegadaEdit").val(registro.fechaLlegada);
//                                                                $("#searchResultEdit").html("");
//                                                                $("#searchResultEdit").hide();
                            }
                        });


                    });


            var config = {
                language: 'es',
                range: true,
                toggleSelected: false,
                multipleDatesSeparator: ' - '
            };

            var dp = $('#rangoFechas').datepicker(config).data('datepicker');
            dp.selectDate([new Date('<?php echo $mesAtras; ?>'), new Date('<?php echo $hoy; ?>')]);
//                                            if (datos.fechaInicio != null && datos.fechaFin != null) {
//                                                dp.selectDate([new Date('' + datos.fechaInicio + ''), new Date('' + datos.fechaFin + '')]);
//                                            }
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
    <script>
        $('#rangoFechas').datepicker({
            // Let's make a function which will add class 'my-class' to every 11 of the month
            // and make these cells disabled.

            onSelect: function onSelect(fd, date) {

                if (date.length == 2) {

                }
            }
        });

//        $('#myDatePickerMC').datepicker({
//            // Let's make a function which will add class 'my-class' to every 11 of the month
//            // and make these cells disabled.
//
//            onSelect: function onSelect(fd, date) {
//                var idEquipo = $("#hddIdEquipo").val();
//                var idDestino = $("#hddIdDestino").val();
//                var idSubseccion = $("#hddIdSubseccion").val();
//                var idCategoria = $("#hddIdCategoria").val();
//                var idSubcategoria = $("#hddIdSubcategoria").val();
//                if (date.length == 2) {
//                    var idTarea = $("#hddIDTarea").val();
//                    actualizarRangoFechas(idTarea, fd);
//
//                    recargarListaTareasMC(idEquipo);
//                    // alert(date + " " + idTarea);
//                }
//            }
//        });
    </script>
</html>
