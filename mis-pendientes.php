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

//Total de tareas 
$totalPendientes = 0;
$totalSolucionadas = 0;

$query = "SELECT * FROM t_mc WHERE responsable = $idUsuario";
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

if (isset($_SESSION['idSeccion'])) {
    $idSeccionSesion = $_SESSION['idSeccion'];
} else {
    $idSeccionSesion = 0;
}

//obtener datos de pendientes de MC

if (isset($_GET['idResponsable'])) {
    $idResponsable = $_GET['idResponsable'];
} else {
    $idResponsable = $idUsuario;
}

$query = "SELECT * FROM t_users WHERE id = $idResponsable AND status = 'A' ORDER BY username";


try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $idUsuarioR = $dts['id'];
            $idTrabajadorR = $dts['id_colaborador'];

            $query = "SELECT * FROM t_colaboradores WHERE id = $idTrabajadorR";
            try {
                $result = $conn->obtDatos($query);
                if ($conn->filasConsultadas > 0) {
                    foreach ($result as $d) {
                        $nombreR = $d['nombre'];
                        $apellidoR = $d['apellido'];
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

$hoy = date('m/d/Y');
$hoyMysql = date("Y-m-d H:i:s", strtotime($hoy . "23:59:59"));
$mesAtras = date("m/d/Y", strtotime('-1 month'));
$mesAtrasMysql = date("Y-m-d H:i:s", strtotime($mesAtras));



if ($idSeccionSesion != 0) {
    $query = "SELECT * FROM t_mc "
            . "WHERE (fecha_creacion >= '$mesAtrasMysql' AND fecha_creacion <= '$hoy') AND "
            . "responsable = $idResponsable AND activo = 1 ORDER BY id_destino";
} else {
    $query = "SELECT * FROM t_mc "
            . "WHERE (fecha_creacion >= '$mesAtrasMysql' AND fecha_creacion <= '$hoy') AND "
            . "id_seccion = $idSeccionSesion AND responsable = $idResponsable AND activo = 1 ORDER BY id_destino";
}


try {
    $correctivos = $conn->obtDatos($query);
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
        <!--<div id="loader2" class="preloader is-active"><span class="title">Cargando...</span></div>-->
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
                                    echo "<div class=\"navbar-dropdown\">";

                                    $query = "SELECT * FROM c_destinos ORDER BY destino";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $idDest = $dts['id'];
                                                $nombreDest = $dts['destino'];
                                                echo "<a href=\"\" onclick=\"cargarTareasDestino(0, $idDest);\" class=\"navbar-item\">$nombreDest</a>";
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }

                                    echo "</div>";
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

                    <!--Hero content: will be in the middle--> 
                    <div class="hero-body">
                        <div class="container has-text-centered">
                            <div class="columns is-centered">

                                <div class="column is-4 is-half">
                                    <nav class="level is-mobile">
                                        <div class="level-item has-text-centered">
                                            <div>
                                                <p class="heading">Pendientes</p>
                                                <p class="title has-text-white"><?php echo $totalPendientes; ?></p>
                                            </div>
                                        </div>
                                        <div class="level-item has-text-centered">
                                            <div>
                                                <p class="heading">Solucionados</p>
                                                <p class="title has-text-white"><?php echo $totalSolucionadas; ?></p>
                                            </div>
                                        </div>
                                        <div class="level-item has-text-centered">
                                            <div>
                                                <p class="heading">Avance</p>
                                                <p class="title has-text-white"><?php echo round($porcentaje) . "%"; ?></p>
                                            </div>
                                        </div>
                                        <div class="level-item has-text-centered">
                                            <div>
                                                <p class="heading">Ranking América</p>
                                                <p class="title has-text-white"><span><i class="fas fa-medal has-text-warning"></i></span>4</p>
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
                                    <button class="button is-info is-small" onclick="buscarMisPendientes(<?php echo $idResponsable; ?>);">
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
                                Mis Pendientes - <?php echo $nombreR . " " . $apellidoR; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="columns">

                        <div class="column is-12 px-3">


                            <div class="columns is-centered container-scroll">
                                <div class="column is-mobile is-centered ">
                                    <div class="table-container">
                                        <table id="tablaMC" class="table is-size-7" style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th style="display:none;">ID</th>
                                                    <th>Destino</th>
                                                    <th>Seccion</th>
                                                    <th>Subseccion</th>
                                                    <th>Equipo</th>
                                                    <th>Responsable</th>
                                                    <th>Actividad</th>
                                                    <th>Fecha creacion</th>
                                                    <th>Semana creacion</th>
                                                    <th>Semana programada</th>
                                                    <th>Estatus</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th style="display:none;">ID</th>
                                                    <th>Destino</th>
                                                    <th>Seccion</th>
                                                    <th>Subseccion</th>
                                                    <th>Equipo</th>
                                                    <th>Responsable</th>
                                                    <th>Actividad</th>
                                                    <th>Fecha creacion</th>
                                                    <th>Semana creacion</th>
                                                    <th>Semana programada</th>
                                                    <th>Estatus</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="tbodyTabla">
                                                <?php
                                                foreach ($correctivos as $dts) {
                                                    $idMC = $dts['id'];
                                                    $idEquipoMC = $dts['id_equipo'];
                                                    $actividad = $dts['actividad'];
                                                    $status = $dts['status'];
                                                    $idResponsable = $dts['responsable'];
                                                    $idSeccionMC = $dts['id_seccion'];
                                                    $idSubseccionMC = $dts['id_subseccion'];
                                                    $idDestinoMC = $dts['id_destino'];
                                                    $fechaCreacion = $dts['fecha_creacion'];
                                                    $semanaI = $dts['semana_inicio'];

                                                    if ($semanaI == "") {
                                                        $semanaI = date("W", strtotime($fechaCreacion));
                                                    }

                                                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoMC";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $nombreDestino = $dts['destino'];
                                                            }
                                                        } else {
                                                            $nombreDestino = "NA";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionMC";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $nombreSeccion = $dts['seccion'];
                                                            }
                                                        } else {
                                                            $nombreSeccion = "Todas las secciones";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionMC";
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

                                                    $query = "SELECT * FROM t_users WHERE id = $idResponsable";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idColaborador = $dts['id_colaborador'];
//Obtener datos del colaborador
                                                                $query = "SELECT * FROM t_colaboradores WHERE id = $idColaborador";
                                                                try {
                                                                    $resp = $conn->obtDatos($query);
                                                                    if ($conn->filasConsultadas > 0) {
                                                                        foreach ($resp as $dts) {
                                                                            $nombre = $dts['nombre'];
                                                                            $apellido = $dts['apellido'];
                                                                        }
                                                                    }
                                                                } catch (Exception $ex) {
                                                                    echo $ex;
                                                                }
                                                            }
                                                        } else {
                                                            $nombre = "";
                                                            $apellido = "";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    $query = "SELECT * FROM t_equipos WHERE id = $idEquipoMC";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idEquipo = $dts['id'];
                                                                $equipo = $dts['equipo'];
                                                            }
                                                        } else {
                                                            $equipo = "GENERALES";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    if ($status == "N") {
                                                        $status = "PENDIENTE";
                                                        $bg = "bg-rojoc";
                                                    } else if ($status == "F") {
                                                        $status = "SOLUCIONADO";
                                                        $bg = "bg-verdec";
                                                    }

                                                    $query = "SELECT * FROM t_mc_planeacion WHERE id_mc = $idMC";
                                                    try {
                                                        $result = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($result as $r) {
                                                                $semanaP = $r['semana'];
                                                            }
                                                        } else {
                                                            $semanaP = "";
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    echo "<tr class=\"$bg\">"
                                                    . "<td style=\"display:none;\">$idMC</td>"
                                                    . "<td>$nombreDestino</td>"
                                                    . "<td>$nombreSeccion</td>"
                                                    . "<td>$nombreSubseccion</td>"
                                                    . "<td>$equipo</td>"
                                                    . "<td>$nombre $apellido</td>"
                                                    . "<td>$actividad</td>"
                                                    . "<td>$fechaCreacion</td>"
                                                    . "<td>$semanaI</td>"
                                                    . "<td>$semanaP</td>"
                                                    . "<td>$status</td>"
                                                    . "</tr>";
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

            var usuarios = $('#tablaUsuarios').DataTable({
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

            usuarios
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = usuarios.rows(indexes).data().toArray();
                        $("#hddIdRegistro").val(rowData[0][0]);
                        $.ajax({
                            type: 'post',
                            url: '../php/stockPHP.php',
                            data: 'action=6&idRegistro=' + rowData[0][0],
                            success: function (data) {
                                var registro = JSON.parse(data);

                                $("#cbDestinoRegEdit").val(registro.idDestino);
                                $("#cbDestinoRegEdit").selectpicker('refresh');
                                $("#cbFaseEdit").val(registro.fase);
                                $("#cbFaseEdit").selectpicker('refresh');
//                                                        $("#txtUbicacionEdit").val(registro.ubicacion);
                                $("#txtCod2bendEdit").val(registro.cod2bend);
                                $("#txtDesc2bendEdit").val(registro.descripcion2bend);
                                $("#cbNaturalezaEdit").val(registro.naturaleza);
                                $("#cbNaturalezaEdit").selectpicker('refresh');
                                $("#cbSeccionEdit").val(registro.seccion);
                                $("#cbSeccionEdit").selectpicker('refresh');
                                $("#cbFamiliaEdit").val(registro.familia);
                                $("#cbFamiliaEdit").selectpicker('refresh');
                                $("#cbSubfamiliaEdit").val(registro.subfamilia);
                                $("#cbSubfamiliaEdit").selectpicker('refresh');
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
                            }
                        });


                    });

            var tablaMC = $('#tablaMC').DataTable({
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

            tablaMC
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = tablaMC.rows(indexes).data().toArray();
                        $("#hddIdRegistro").val(rowData[0][0]);
                        $.ajax({
                            type: 'post',
                            url: '../php/stockPHP.php',
                            data: 'action=6&idRegistro=' + rowData[0][0],
                            success: function (data) {
                                var registro = JSON.parse(data);

                                $("#cbDestinoRegEdit").val(registro.idDestino);
                                $("#cbDestinoRegEdit").selectpicker('refresh');
                                $("#cbFaseEdit").val(registro.fase);
                                $("#cbFaseEdit").selectpicker('refresh');
//                                                        $("#txtUbicacionEdit").val(registro.ubicacion);
                                $("#txtCod2bendEdit").val(registro.cod2bend);
                                $("#txtDesc2bendEdit").val(registro.descripcion2bend);
                                $("#cbNaturalezaEdit").val(registro.naturaleza);
                                $("#cbNaturalezaEdit").selectpicker('refresh');
                                $("#cbSeccionEdit").val(registro.seccion);
                                $("#cbSeccionEdit").selectpicker('refresh');
                                $("#cbFamiliaEdit").val(registro.familia);
                                $("#cbFamiliaEdit").selectpicker('refresh');
                                $("#cbSubfamiliaEdit").val(registro.subfamilia);
                                $("#cbSubfamiliaEdit").selectpicker('refresh');
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
