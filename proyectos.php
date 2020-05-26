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

if (isset($_SESSION['tipoProyecto'])) {
    $tipoProyecto = $_SESSION['tipoProyecto'];
} else {
    $tipoProyecto = "0";
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
                    <?php //echo $layout->menu();    ?>
                </nav>

                <!--HERO BAR-->
                <section class="mt-5">
                    <br>
                </section>
                <!--SECCION DE SELECTS-->
                <section class="mt-2">
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
                                    <select id="cbTipoProyectos" onchange="cargarTiposProyectos();">

                                        <?php
                                        if ($tipoProyecto == "0") {
                                            echo "<option value=\"PROYECTO\">PROYECTO</option>"
                                            . "<option value=\"CAPEX\">CAPEX</option>"
                                            . "<option value=\"CAPIN\">CAPIN</option>";
                                        } elseif ($tipoProyecto == "PROYECTO") {
                                            echo "<option value=\"PROYECTO\" selected>PROYECTO</option>"
                                            . "<option value=\"CAPEX\">CAPEX</option>"
                                            . "<option value=\"CAPIN\">CAPIN</option>";
                                        } elseif ($tipoProyecto == "CAPEX") {
                                            echo "<option value=\"PROYECTO\">PROYECTO</option>"
                                            . "<option value=\"CAPEX\" selected>CAPEX</option>"
                                            . "<option value=\"CAPIN\">CAPIN</option>";
                                        } elseif ($tipoProyecto == "CAPIN") {
                                            echo "<option value=\"PROYECTO\">PROYECTO</option>"
                                            . "<option value=\"CAPEX\">CAPEX</option>"
                                            . "<option value=\"CAPIN\" selected>CAPIN</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="seccionTablaProyectos" class="mt-2">
                    <div class="columns is-mobile is-centered px-4">
                        <div class="column">
                            <div class="table-container">
                                <table id="tablaProyectos" class="table" style="width: 100%">
                                    <thead class="is-size-7">
                                        <tr>
                                            <th style="display: none;">ID</th>
                                            <th>Destino</th>
                                            <th>Seccion</th>
                                            <th>Subseccion</th>
                                            <th>Titulo</th>
                                            <th>Justificacion</th>
                                            <th>Año</th>
                                            <th>Coste (USD)</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tfoot class="is-size-7">
                                        <tr>
                                            <th style="display: none;">ID</th>
                                            <th>Destino</th>
                                            <th>Seccion</th>
                                            <th>Subseccion</th>
                                            <th>Titulo</th>
                                            <th>Justificacion</th>
                                            <th>Año</th>
                                            <th>Coste (USD)</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </tfoot>

                                    <tbody>
                                        <?php
                                        if ($idDestinoT == 10) {
                                            if ($tipoProyecto == "0") {
                                                $query = "SELECT * FROM t_proyectos WHERE activo = 1 ORDER BY id_destino";
                                            } else {
                                                $query = "SELECT * FROM t_proyectos WHERE tipo = '$tipoProyecto' AND activo = 1 ORDER BY id_destino";
                                            }
                                        } else {
                                            if ($tipoProyecto == "0") {
                                                $query = "SELECT * FROM t_proyectos WHERE id_destino = $idDestinoT AND activo = 1 ORDER BY id_destino";
                                            } else {
                                                $query = "SELECT * FROM t_proyectos WHERE tipo = '$tipoProyecto' AND id_destino = $idDestinoT AND activo = 1 ORDER BY id_destino";
                                            }
                                        }

                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $idProyecto = $dts['id'];
                                                    $idDestinoTarea = $dts['id_destino'];
                                                    $idSeccionTarea = $dts['id_seccion'];
                                                    $idSubseccion = $dts['id_subseccion'];

                                                    $titulo = $dts['titulo'];
                                                    $justificacion = $dts['justificacion'];

                                                    $fechaI = $dts['fecha_creacion'];
                                                    //$fechaF = $dts['fecha_f'];
                                                    if ($dts['status'] == 'N') {
                                                        $status = "EN PROCESO";
                                                    } elseif ($dts['status'] == 'F') {
                                                        $status = "FINALIZADO";
                                                    }

                                                    $año = $dts['año'];
                                                    $total = $dts['coste'];

                                                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoTarea";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $nombreDestino = $dts['destino'];
                                                            }
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionTarea";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $nombreSeccion = $dts['seccion'];
                                                            }
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccion";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $nombreSubseccion = $dts['grupo'];
                                                            }
                                                        }
                                                    } catch (Exception $ex) {
                                                        echo $ex;
                                                    }

                                                    echo "<tr class=\"is-size-7\" data-toggle=\"modal\" data-target=\"#modal-detalle-planaccion-proyecto\">"
                                                    . "<td style=\"display: none;\">$idProyecto</td>"
                                                    . "<td>$nombreDestino</td>"
                                                    . "<td>$nombreSeccion</td>"
                                                    . "<td>$nombreSubseccion</td>"
                                                    . "<td style=\"width: 200px;\">$titulo</td>"
                                                    . "<td>$justificacion</td>"
                                                    . "<td>$año</td>";
                                                    if ($total != "") {
                                                        echo "<td>" . money_format("%.2n", $total) . "</td>";
                                                    } else {
                                                        echo "<td></td>";
                                                    }
                                                    echo "<td>$status</td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            echo $ex;
                                        }
                                        ?>
                                    </tbody>
                                </table>
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
                                    <a class="button is-link is-outlined" onclick="mostrarInfoProyecto2();">
                                        <span class="icon is-small"><i class="fas fa-home"></i></span>
                                    </a>
                                </p>
                                <p class="control">
                                    <a class="button is-danger is-outlined" onclick="mostrarInfoProyecto2();">
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
            </div>
        </div>

        <!--AREA DE MODALS-->

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

                                    echo "<h6 class=\"title is-6 hvr-grow manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"agregarResponsableProyecto($idUsuario)\"><span><i class=\"fas fa-user\"></i></span> $nombreT $apellidoT</h6>";
                                }
                            }
                            ?>

                        </div>
                    </div>
                </section>
                <footer class="modal-card-foot">
                </footer>
            </div>
            <button class="modal-close is-large" aria-label="close" onclick="closeModal('modalAgregarResponsable');"></button>
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

        <a id="btnAncla" href="#nav-menu" class="button is-primary is-rounded ancla" style="display:none;"><i class="fa fa-arrow-up"></i></a>
    </body>

    <?php echo $layout->scripts(); ?>

    <script src="js/plannerJS.js"></script>
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


            var capex = $('#tablaProyectos').DataTable({
                "select": true,
                "scrollY": '50vh',
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                "autoWidth": false,
                "order": [[1, "asc"]],
                "columnDefs": [
                    {"width": "50px", "targets": [4, 5]}
                ],
                fixedColumns: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Reporte ',
                        className: 'button is-primary is-small'
                    },
                    {
                        extend: 'pdf',
                        title: 'Reporte ',
                        orientation: 'landscape',
                        className: 'button is-primary is-small'

                    },
                ],

            });


            capex
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = capex.rows(indexes).data().toArray();
                        var idProyecto = rowData[0][0];
                        var idSubseccion = 200;
                        switch (rowData[0][1]) {
                            case 'RM':
                                var idDestino = 1;
                                break;
                            case 'PVR':
                                var idDestino = 2;
                                break;
                            case 'SDQ':
                                var idDestino = 3;
                                break;
                            case 'SSA':
                                var idDestino = 4;
                                break;
                            case 'PUJ':
                                var idDestino = 5;
                                break;
                            case 'MBJ':
                                var idDestino = 6;
                                break;
                            case 'CMU':
                                var idDestino = 7;
                                break;
                            case 'CAP':
                                var idDestino = 11;
                                break;

                        }

                        switch (rowData[0][2]) {
                            case 'AUTO':
                                var idSeccion = 24;
                                break;
                            case 'DEC':
                                var idSeccion = 1;
                                break;
                            case 'DEP':
                                var idSeccion = 23;
                                break;
                            case 'ZHA':
                                var idSeccion = 5;
                                break;
                            case 'ZHC':
                                var idSeccion = 6;
                                break;
                            case 'ZHH':
                                var idSeccion = 7;
                                break;
                            case 'ZHP':
                                var idSeccion = 12;
                                break;
                            case 'ZIA':
                                var idSeccion = 8;
                                break;
                            case 'ZIC':
                                var idSeccion = 9;
                                break;
                            case 'ZIE':
                                var idSeccion = 10;
                                break;
                            case 'ZIL':
                                var idSeccion = 11;
                                break;
                        }
                        obtDetalleProyecto2(idProyecto, idDestino, idSeccion, idSubseccion);
                    })
                    .on('deselect', function (e, dt, type, indexes) {
                        var rowData = capex.rows(indexes).data().toArray();
//                            alert(rowData);
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
