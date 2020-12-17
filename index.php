<?php
session_set_cookie_params(60 * 60 * 24 * 364);
session_start();
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'en_US');
include 'php/conexion.php';
include_once 'php/layout.php';
$layout = new Layout();
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
        // $zhh = "";
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

                //Obtener datos del colaborador.
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
        $porcentajeCurrent = ($totalSolucionadasCurrent / $totalTareasCurrent) * 100;
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
                $porcentaje = ($totalSolucionadas / $totalTareas) * 100;
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
    <meta charset="UTF-8">
    <?php echo $layout->styles(); ?>
    <link href="css/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bulma.css">
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style3.css">
    <link rel="stylesheet" href="DataTables/datatables.css">
    <link rel="stylesheet" href="css/clases.css">
    <link rel="stylesheet" href="css/hover.css">
    <link rel="stylesheet" href="css/modal-fx.min.css">
    <link rel="stylesheet" href="css/clasesproyectosypendientes.css" />
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/alertify.min.css">

</head>

<body>

    <!-- <div id="loader" class="pageloader is-dark"><span class="title">Cargando...</span></div> -->
    <!--Menu principal latelar izquierdo SIDEBAR-->


    <!--contetn-->
    <div id="content" class="">

        <!--MENU-->
        <?php include 'navbartop.php'; ?>
        <?php include 'menu-sidebar.php'; ?>

        <!-- Select para Versión Movil -->
        <div id="opcionMovil" class="bg-white rounded-t-lg overflow-hidden border-t border-l border-r border-gray-400 text-center pt-3 hidden">
            <div class="inline-block relative">
                <!-- <select id="mostrarSeccionMovil"
                    class="block appearance-none w-full border border-gray-400 bg-gray-200 hover:border-gray-500 px-4 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline p-2">
                    <option>Secciones</option>
                    <option value="11" onclick="mostrarSeccion();">ZIL</option>
                    <option value="10" onclick="mostrarSeccion();">ZIE</option>
                    <option value="24" onclick="mostrarSeccion();">AUTO</option>
                    <option value="1">DEC</option>
                    <option value="23">DEP</option>
                    <option value="19">OMA</option>
                    <option value="5">ZHA</option>
                    <option value="6">ZHC</option>
                    <option value="7">ZHH</option>
                    <option value="12">ZHP</option>
                    <option value="8">ZIA</option>
                    <option value="9">ZIC</option>
                </select> -->
                <div class="buttons has-addons">
                    <button onclick="mostrarSeccion('id-11');" class="button btn-id-11">ZIL</button>
                    <button onclick="mostrarSeccion('id-10');" class="button btn-id-10">ZIE</button>
                    <button onclick="mostrarSeccion('id-24');" class="button btn-id-24">AUTO</button>
                    <button onclick="mostrarSeccion('id-1');" class="button btn-id-1">DEC</button>
                    <button onclick="mostrarSeccion('id-23');" class="button btn-id-23">DEP</button>
                    <button onclick="mostrarSeccion('id-19');" class="button btn-id-19">OMA</button>
                    <button onclick="mostrarSeccion('id-5');" class="button btn-id-5">ZHA</button>
                    <button onclick="mostrarSeccion('id-6');" class="button btn-id-6">ZHC</button>
                    <button onclick="mostrarSeccion('id-7');" class="button btn-id-7">ZHH</button>
                    <button onclick="mostrarSeccion('id-12');" class="button btn-id-12">ZHP</button>
                    <button onclick="mostrarSeccion('id-8');" class="button btn-id-8">ZIA</button>
                    <button onclick="mostrarSeccion('id-9');" class="button btn-id-9">ZIC</button>
                </div>
            </div>
        </div>
        <!-- Select para Versión Movil -->

        <nav id="nav-menu" class="navbar is-fixed-top modal">

            <div id="navMenuPpal" class="navbar-menu modal">
                <div class="navbar-end">
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
            </div>
        </nav>

        <!-- *********************************************************************************** -->
        <!-- Hidden para Obtener Datos de Tareas Generales -->

        <input type="hidden" id="idUsuarioTG">
        <input type="hidden" id="idDestinoTG">
        <input type="hidden" id="idSeccionTG">
        <input type="hidden" id="idSubseccionTG">
        <input type="hidden" id="idTareaTG">
        <input type="hidden" id="statusTG">
        <input type="hidden" id="tablaTG">
        <input type="hidden" id="idProyectoPlanAccion">
        <input type="hidden" id="idPlanAccion">
        <input type="hidden" id="idDestinoProyectos">
        <input type="hidden" id="idSeccionProyectos">
        <input type="hidden" id="idUsuarioProyectos">
        <input type="hidden" id="idSubseccionProyectos">
        <input type="hidden" id="tipoMCMCG">

        <!-- Fin de hidden para Tareas Generales -->


        <!-- Inputs para Status -->
        <input type="hidden" id="statusIdDestino">
        <input type="hidden" id="statusIdSeccion">
        <input type="hidden" id="statusIdSubseccion">
        <input type="hidden" id="statusIdTabla">
        <!--Input donde se guarda el Id de Proyecto, MC, MP o TareaGeneral-->
        <input type="hidden" id="statusIdPlanAccion">
        <!--Input donde se guarda el Id de Proyecto, MC, MP o TareaGeneral-->
        <input type="hidden" id="statusTabla">
        <!--Input donde se guarda el nombre de la tabla-->
        <input type="hidden" id="status">
        <!-- ************************************************************************************** -->
        <!-- INPUT DE MPNP, GUARDA ID, PARA COMPLEMENTAR EL FORMULARIO  -->
        <input type="hidden" id="idMPNP">
        <input type="hidden" id="idEquipoMPNP">

        <!--SECCION DE SLECCION DE HOTEL-->
        <section id="seccionHoteles" style="display:none;">
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
                                <span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS
                                HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU)
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
                                <span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS
                                HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU)
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
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>
                        <div class="timeline-item is-danger">
                            <div class="timeline-marker is-danger is-icon">
                                <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span></h4>
                            </div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong> 14/11/1989 20:30</p>
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


        <section id="sectionHeroListaEquipos" style="display:none;" class="hero is-light is-small mt-5">
            <!-- Hero head: will stick at the top -->
            <div class="hero-head mx-2">
                <div class="">
                    <div id="navbarMenuHeroA" class="navbar-menu">
                        <div class="navbar-start">
                            <span class="navbar-item">
                                <button class="button is-warning" onclick="reloadPlanner('')"><i class="fas fa-arrow-left"></i></button>
                            </span>
                            <!-- Cambia el estilo de las categorias en la barra -->
                            <div id="divNameSeccion" class="navbar-item bannerbit3">
                                <p class="seccion-logo-desactivado">Seccion</p>
                            </div>
                            <span class="navbar-item">

                                <p id="divNameSubseccion" class="subtitle is-3">Subseccion</p>

                            </span>
                        </div>
                        <div class="navbar-end">

                            <span class="navbar-item modal">
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
                                        <div class="dropdown is-active">
                                            <div class="dropdown-trigger">
                                                <button class="button is-light" aria-haspopup="true" aria-controls="dropdown-menu">
                                                    <span class="icon is-small">
                                                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                                                    </span>
                                                    <span>Información</span>

                                                </button>
                                            </div>
                                            <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                                <div class="dropdown-content">
                                                    <a id="link-auditorias" href="#" class="dropdown-item">
                                                        AUDITORIAS - INFORMES
                                                    </a>
                                                    <a id="link-certificaciones" href="#" class="dropdown-item">
                                                        CERTIFICACIONES - NORMATIVAS
                                                    </a>
                                                    <a id="link-cotizaciones" href="#" class="dropdown-item">
                                                        COTIZACIONES - FACTURAS
                                                    </a>
                                                    <a id="link-planos" href="#" class="dropdown-item">
                                                        PLANOS
                                                    </a>
                                                    <a id="link-otros" href="#" class="dropdown-item">
                                                        OTROS
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <a id="link-informes" class="button is-light">
                                                <<span class="icon is-small">
                                                <i class="fas fa-info-circle"></i>
                                                </span>
                                                <span>Información</span>
                                                </a>-->
                                    </p>
                                    <p class="control">
                                        <a id="link-stock" class="button is-light">
                                            <span class="icon is-small">
                                                <i class="fas fa-box-open"></i>
                                            </span>
                                            <span>Stock/Pedidos</span>
                                        </a>
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

        <!--*******SECCION LISTADO DE EQUIPOS*************-->
        <section id="seccionListaEquipos" style="display: none;">
            <div class="columns is-centered my-2">
                <div class="column is-2 has-text-centered">
                    <div class="field has-addons has-addons-right is-fullwidth">
                        <div class="control">
                            <div class="control has-icons-left has-icons-right">
                                <input id="busqueda" name="busqueda" class="input" type="text" placeholder="Buscar equipo" autocomplete="off"><span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="control">
                            <button id="btnBuscar" type="button" class="button is-info">Buscar</button>
                        </div>
                    </div>
                    <!--<div class="control has-icons-left has-icons-right">
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


        <!-- ******************************** Codigo para la comnas de subsecciones ********************************************************************* -->
        <!-- <br> -->
        <section id="seccion-bar" class="hero is-light is-small mt-5">
            <!-- Hero head: will stick at the top -->
            <div class="hero-head">
                <div class="navbar-menu">
                    <div class="navbar-start has-text-centered">
                        <div class="bannerbit3">
                            <p class="">Planner</p>
                        </div>
                        <div class="bannerbit">
                            <p><?php echo $destinoT;  ?></p>
                        </div>
                    </div>
                    <div class="navbar-start has-text-centered">
                        <div class="navbar-item">
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-1">AUTO</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-2">DEC</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-3">DEP</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-4">OMA</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-5">ZHA</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-6">ZHC</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-7">ZHH</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-8">ZHP</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-9">ZIA</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-10">ZIC</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-11">ZIE</p>
                            </a>
                            <a href="#">
                                <p class="bannersec2 btn-seccion btn-12">ZIL</p>
                            </a>
                        </div>
                    </div>

                    <div class="navbar-end mr-4">
                        <?php
                        $hoy = getdate();
                        $dia = $hoy['weekday'];
                        switch ($dia) {
                            case 'Monday':
                                echo "<img src=\"svg/calendario/lunes.svg\" class=\"img-fluid\" width=\"280px\">";
                                break;
                            case 'Tuesday':
                                echo "<img src=\"svg/calendario/martes.svg\" class=\"img-fluid\" width=\"280px\">";
                                break;
                            case 'Wednesday':
                                echo "<img src=\"svg/calendario/miercoles.svg\" class=\"img-fluid\" width=\"280px\">";
                                break;
                            case 'Thursday':
                                echo "<img src=\"svg/calendario/jueves.svg\" class=\"img-fluid\" width=\"280px\">";
                                break;
                            case 'Friday':
                                echo "<img src=\"svg/calendario/viernes.svg\" class=\"img-fluid\" width=\"280px\">";
                                break;
                            case 'Saturday':
                                echo "<img src=\"svg/calendario/syd.svg\" class=\"img-fluid\" width=\"280px\">";
                                break;
                            case 'Sunday':
                                echo "<img src=\"svg/calendario/syd.svg\" class=\"img-fluid\" width=\"280px\"><br>";
                                break;
                        }
                        ?>
                    </div>

                </div>
            </div>
        </section>
        <!-- <br> -->

        <!-- ******************* CONSULTAS PARA LA COLUMNA DE SECCIONES********************************** -->
        <section id="seccionColumnas" class="mt-2 container is-fluid">
            <div class="columns is-variable is-2  mx-3" style="overflow-X: scroll;">
                <?php
                $id_destino = $idDestinoT;
                if ($id_destino != 10) {
                ?>
                    <?php
                    $id_seccion = 24;
                    $nombre_seccion = "AUTO";
                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-24'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id <> 200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {

                                $query_t_mc = "SELECT id, count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);


                                if ($row_count = mysqli_fetch_array($result_t_mc)) {

                                    // Array para almacenar datos y ordenarlos.
                                    $array_auto[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_auto);

                        // Recorre el arreglo.
                        foreach ($array_auto as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        }

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {


                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\"CapturarStatusGeneral($idUsuario, $idDestinoT, 24, 200, 'reporte_status_proyecto' ); listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200); \"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\"CapturarStatusGeneral($idUsuario, $idDestinoT, 24, 200, 'reporte_status_proyecto'); listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>


                    <?php
                    $id_seccion = 1;
                    $nombre_seccion = "DEC";
                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-1'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    // Array para almacenar datos y ordenarlos.
                                    $array_dec[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }



                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_dec);

                        // Recorre el arreglo.
                        foreach ($array_dec as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        }

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\"listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\"listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 23;
                    $nombre_seccion = "DEP";
                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion AND id_destino=$id_destino";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-23'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    // Array para almacenar datos y ordenarlos.
                                    $array_dep_a[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_dep_a);

                        // Recorre el arreglo.
                        foreach ($array_dep_a as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {
                                $nombreSubseccion = $row_subsecciones['grupo'];
                                $idSubseccion = $row_subsecciones['id'];


                                //echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                // Muestra el Modal directo de Tareas Generales
                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\" modalProyectosDEP('show'); listarProyectosDEP($idUsuario, $idDestinoT, 23, $idSubseccion); consultaDEP($idUsuario, $idDestinoT, 23, $idSubseccion);\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4 xxx\">$nombreSubseccion</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        }

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino=$id_destino AND id_seccion=" . $id_seccion . " and status='N' and activo=1 and id_subseccion = 200";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\"listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\"listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>


                    <?php
                    $id_seccion = 19;
                    $nombre_seccion = "OMA";
                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-19'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_oma[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_oma);

                        // Recorre el arreglo.
                        foreach ($array_oma as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 5;
                    $nombre_seccion = "ZHA";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-5'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zha[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zha);

                        // Recorre el arreglo.
                        foreach ($array_zha as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 6;
                    $nombre_seccion = "ZHC";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-6'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zhc[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }


                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zhc);

                        // Recorre el arreglo.
                        foreach ($array_zhc as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 7;
                    $nombre_seccion = "ZHH";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-7'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zhh[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zhh);

                        // Recorre el arreglo.
                        foreach ($array_zhh as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 12;
                    $nombre_seccion = "ZHP";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-12'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zhp[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zhp);

                        // Recorre el arreglo.
                        foreach ($array_zhp as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 8;
                    $nombre_seccion = "ZIA";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-8'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zia[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zia);

                        // Recorre el arreglo.
                        foreach ($array_zia as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 9;
                    $nombre_seccion = "ZIC";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-9'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zic[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zic);

                        // Recorre el arreglo.
                        foreach ($array_zic as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {
                                $idSubseccion = $row_subsecciones['id'];
                                $nombreGrupo = $row_subsecciones['grupo'];

                                if ($id_destino == 1444 and $idSubseccion == 12) {
                                    echo
                                        "<div class=\"columns is-gapless my-1 is-mobile\">"
                                            . "<div class=\"column is-10\" onclick=\"show_hide_modal('modalHotelRM', 'show')\">"
                                            . "<p class=\"t-normal has-text-left px-4\">"
                                            . "$nombreGrupo"
                                            . "</p>"
                                            . "</div>"
                                            . "<div class=\"column\">";
                                } elseif ($id_destino == 74444 and $idSubseccion == 12) {
                                    echo
                                        "<div class=\"columns is-gapless my-1 is-mobile\">"
                                            . "<div class=\"column is-10\" onclick=\"show_hide_modal('modalHotelCMU', 'show')\">"
                                            . "<p class=\"t-normal has-text-left px-4\">"
                                            . "$nombreGrupo"
                                            . "</p>"
                                            . "</div>"
                                            . "<div class=\"column\">";
                                } else {
                                    echo
                                        "<div class=\"columns btn-subsecciones is-gapless my-1 is-mobile\"  onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                            . "<div class=\"column is-10\">"
                                            . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo']
                                            . "</p>"
                                            . "</div>"
                                            . "<div class=\"column\">";
                                }
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>";
                            }
                        } //fin Foreach


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 10;
                    $nombre_seccion = "ZIE";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-10'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";

                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zie[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }
                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zie);

                        // Recorre el arreglo.
                        foreach ($array_zie as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 11;
                    $nombre_seccion = "ZIL";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-11'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and activo=1 and activo=1 and id_destino=$id_destino and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zil[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zil);

                        // Recorre el arreglo.
                        foreach ($array_zil as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 1001;
                    $nombre_seccion = "Energéticos";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_destino= $id_destino and id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3- is-mobile id-11'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_energeticos WHERE status = 'PENDIENTE' and activo = 1 and id_destino = $id_destino and id_seccion = $id_seccion and id_subseccion = " . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_energeticos[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_energeticos);

                        // Recorre el arreglo.
                        foreach ($array_energeticos as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {
                                $idSubseccionX = $row_subsecciones['id'];
                                $subseccionX = $row_subsecciones['grupo'];

                                if ($total > 0) {
                                    echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" obtenerPendientesEnergeticos($id_seccion, $idSubseccionX, 'PENDIENTE');\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\"> $subseccionX</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $total. " </p></div></div></a>";
                                } else {
                                    echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" obtenerPendientesEnergeticos($id_seccion, $idSubseccionX, 'PENDIENTE');\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\"> $subseccionX</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                                }
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_destino =" . $id_destino . " and id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                <?php } else {

                    //COLUMNAS PARA EL DESTINO DE AMERICA ID:10 
                    $id_seccion = 24;
                    $nombre_seccion = "AUTO";
                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-24'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id <> 200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {

                                $query_t_mc = "SELECT id, count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);


                                if ($row_count = mysqli_fetch_array($result_t_mc)) {

                                    // Array para almacenar datos y ordenarlos.
                                    $array_auto_a[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_auto_a);

                        // Recorre el arreglo.
                        foreach ($array_auto_a as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {

                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        }


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\"CapturarStatusGeneral($idUsuario, $idDestinoT, 24, 200, 'reporte_status_proyecto'); listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\"CapturarStatusGeneral($idUsuario, $idDestinoT, 24, 200, 'reporte_status_proyecto'); listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                ?>



                    <?php
                    $id_seccion = 1;
                    $nombre_seccion = "DEC";
                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-1'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    // Array para almacenar datos y ordenarlos.
                                    $array_dec_a[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }



                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_dec_a);

                        // Recorre el arreglo.
                        foreach ($array_dec_a as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        }

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>


                    <?php
                    $id_seccion = 23;
                    $nombre_seccion = "DEP";
                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-23'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    // Array para almacenar datos y ordenarlos.
                                    $array_dep_a[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_dep_a);

                        // Recorre el arreglo.
                        foreach ($array_dep_a as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {
                                $nombreSubseccion = $row_subsecciones['grupo'];
                                $idSubseccion = $row_subsecciones['id'];


                                //echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                // Muestra el Modal directo de Tareas Generales
                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\" modalProyectosDEP('show'); listarProyectosDEP($idUsuario, $idDestinoT, 23, $idSubseccion); consultaDEP($idUsuario, $idDestinoT, 23, $idSubseccion);\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">$nombreSubseccion</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        }

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1 and id_subseccion = 200";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>




                    <?php
                    $id_seccion = 19;
                    $nombre_seccion = "OMA";
                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-19'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_oma[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_oma);

                        // Recorre el arreglo.
                        foreach ($array_oma as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 5;
                    $nombre_seccion = "ZHA";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-5'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zha[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zha);

                        // Recorre el arreglo.
                        foreach ($array_zha as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 6;
                    $nombre_seccion = "ZHC";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-6'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zhc[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }


                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zhc);

                        // Recorre el arreglo.
                        foreach ($array_zhc as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 7;
                    $nombre_seccion = "ZHH";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-7'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zhh[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zhh);

                        // Recorre el arreglo.
                        foreach ($array_zhh as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 12;
                    $nombre_seccion = "ZHP";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-12'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zhp[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zhp);

                        // Recorre el arreglo.
                        foreach ($array_zhp as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 8;
                    $nombre_seccion = "ZIA";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-8'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zia[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zia);

                        // Recorre el arreglo.
                        foreach ($array_zia as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 9;
                    $nombre_seccion = "ZIC";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-9'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zic[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zic);

                        // Recorre el arreglo.
                        foreach ($array_zic as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach


                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 10;
                    $nombre_seccion = "ZIE";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-10'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";

                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zie[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }
                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zie);

                        // Recorre el arreglo.
                        foreach ($array_zie as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>

                    <?php
                    $id_seccion = 11;
                    $nombre_seccion = "ZIL";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3 is-mobile id-11'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_mc WHERE status='N' and activo=1 and activo=1 and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_zil[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_zil);

                        // Recorre el arreglo.
                        foreach ($array_zil as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {


                                echo "<a class=\"btn-subsecciones\" href=\"#\" onclick=\"showHide('show'); obtenerEquipos($id, $id_destino, 1, 0, 0, 1, '$destinoT', '$nombre_seccion', '" . $row_subsecciones['grupo'] . "');\">"
                                    . "<div class=\"columns is-gapless my-1 is-mobile\">"
                                    . "<div class=\"column is-10\">"
                                    . "<p class=\"t-normal has-text-left px-4\">" . $row_subsecciones['grupo'] . "</p>"
                                    . "</div>"
                                    . "<div class=\"column\">";
                                if ($total > 0) {
                                    echo "<p class=\"t-pendiente\">$total</p>";
                                } else {

                                    echo  "<p class=\"t-normal\">0</p>";
                                }
                                echo
                                    "</div>"
                                        . "</div>"
                                        . "</a>";
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }


                    // Fin America Total.

                    ?>


                <?php
                    $id_seccion = 1001;
                    $nombre_seccion = "Energéticos";

                    $query_c_rel_destino_seccion = "SELECT* FROM c_rel_destino_seccion WHERE id_seccion=$id_seccion";
                    $result_c_rel_destino_seccion = mysqli_query($conn_2020, $query_c_rel_destino_seccion);

                    if ($row_c_rel_destino_seccion = mysqli_fetch_array($result_c_rel_destino_seccion)) {
                        $query_c_rel_seccion_subseccion = "SELECT* FROM c_rel_seccion_subseccion WHERE id_rel_seccion=" . $row_c_rel_destino_seccion['id'] . "";
                        $result_c_rel_seccion_subseccion = mysqli_query($conn_2020,  $query_c_rel_seccion_subseccion);
                        echo "<div class='column is-3 hide-seccion-is-3- is-mobile id-1001'>";
                        echo "<p onclick=\"pendientesSubseccion($id_seccion, 'MCS', '$nombre_seccion', $idUsuario, $id_destino);\" class='$nombre_seccion column has-text-centered'> $nombre_seccion </p>";
                        while ($row_c_rel_seccion = mysqli_fetch_array($result_c_rel_seccion_subseccion)) {
                            $query_subseccion_nombre = "SELECT* FROM c_subsecciones WHERE id=" . $row_c_rel_seccion['id_subseccion'] . " and id<>200";
                            $result_subseccion_nombre = mysqli_query($conn_2020, $query_subseccion_nombre);

                            while ($row_subseccion_nombre = mysqli_fetch_array($result_subseccion_nombre)) {
                                $query_t_mc = "SELECT count(id) FROM t_energeticos WHERE status='PENDIENTE' and activo=1 and id_seccion=$id_seccion and id_subseccion=" . $row_subseccion_nombre['id'] . "";
                                $result_t_mc = mysqli_query($conn_2020, $query_t_mc);
                                $row_cnt = mysqli_num_rows($result_t_mc);

                                if ($row_count = mysqli_fetch_array($result_t_mc)) {
                                    $array_energeticos[$row_subseccion_nombre['id']] = $row_count['count(id)'];
                                }
                            }
                        }

                        // Imprime las subcategorias Ordenadas.

                        // Ordena el arreglo segun las cantidades de pendientes y el index es el id de la Subcategoria.
                        arsort($array_energeticos);

                        // Recorre el arreglo.
                        foreach ($array_energeticos as $id => $total) {
                            $query_subsecciones = "SELECT* FROM c_subsecciones WHERE id=$id";
                            $result_subsecciones = mysqli_query($conn_2020, $query_subsecciones);
                            if ($row_subsecciones = mysqli_fetch_array($result_subsecciones)) {
                                $idSubseccionX = $row_subsecciones['id'];
                                $subseccionX = $row_subsecciones['grupo'];

                                if ($total > 0) {
                                    echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" obtenerPendientesEnergeticos($id_seccion, $idSubseccionX, 'PENDIENTE');\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\"> $subseccionX</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $total . " </p></div></div></a>";
                                } else {
                                    echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" obtenerPendientesEnergeticos($id_seccion, $idSubseccionX, 'PENDIENTE');\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\"> $subseccionX</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                                }
                            }
                        } //fin Foreach

                        $query_t_proyectos = "SELECT count(id) FROM t_proyectos WHERE id_seccion=" . $id_seccion . " and status='N' and activo=1";
                        $result_t_proyectos = mysqli_query($conn_2020, $query_t_proyectos);

                        if ($row_t_proyectos = mysqli_fetch_array($result_t_proyectos)) {

                            if ($row_t_proyectos['count(id)'] <= 0 || $row_t_proyectos['count(id)'] == "") {
                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-normal\">0</p></div></div></a>";
                            } else {

                                echo "<a class=\"btn-proyectos\" href=\"#\" onclick=\" listarProyectos($idUsuario, $idDestinoT, $id_seccion, 200);\"><div class=\"columns is-gapless my-1 is-mobile\"><div class=\"column is-10\"><p class=\"t-normal has-text-left px-4\">PROYECTOS</p></div><div class=\"column\"><p class=\"t-pendiente\">" . $row_t_proyectos['count(id)'] . " </p></div></div></a>";
                            }
                        }
                        echo "</div>";
                    }


                    // Fin America Total.
                }
                ?>
            </div>
        </section>


        <!--SECCION DE SLECCION DE HOTEL-->
        <section id="seccionHoteles" style="display:none;">
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
        </section>

        <!--*******SECCION LISTADO DE EQUIPOS*************-->
        <section id="seccionListaEquipos" style="display: none;">

            <div class="columns is-centered my-2">
                <div class="column is-2 has-text-centered">
                    <div class="field has-addons has-addons-right is-fullwidth">
                        <div class="control">
                            <div class="control has-icons-left has-icons-right">
                                <input id="busqueda" name="busqueda" class="input" type="text" placeholder="Buscar equipo"><span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                        <div class="control">
                            <button id="btnBuscar" type="button" class="button is-info">Buscar</button>
                        </div>
                    </div>
                    <!--                    <div class="control has-icons-left has-icons-right">
                                                    <input class="input" type="text" placeholder="Buscar equipo"><span class="icon is-small is-left"><i class="fas fa-search"></i></span>
                                                </div>-->
                </div>
                <div class="column is-1" id="btn-regresar-subseccion">
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
                                <span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS
                                HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU)
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
                                <span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS
                                HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU)
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
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>
                        <div class="timeline-item is-danger">
                            <div class="timeline-marker is-danger is-icon">
                                <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span></h4>
                            </div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong> 14/11/1989 20:30</p>
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
                                <span>Fallas</span>
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
                                <label for="exampleCheckboxSuccessCircle"><span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS
                                    HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) </label>
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
                                <label for="exampleCheckboxSuccessCircle"><span><i class="fas fa-bookmark has-text-danger"></i> </span>(CMU) SONDAS
                                    HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) </label>
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
                <div id="inicioMP2" class="columns is-centered mt-4 border rounded" style="display: none;">
                    <div class="column is-half has-text-centered">
                        <h4 class="title is-4 ">Para poner en proceso este mantenimiento es necesario generar la OT.
                        </h4>
                        <h6 id="titulomp2" class="title is-6">"Mantenimiento mayor, semana 45"</h6>
                        <a id="btnGenerarOT2" class="button is-warning">
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
                        <ul id="ulActividades2" class="has-text-left">
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>

                        </ul>
                    </div>
                </div>

                <div id="divDetalleOT2" class="columns is-centered my-4 border rounded" style="display: none;">
                    <input type="hidden" id="hddidPlanMP2">
                    <input type="hidden" id="hddidPlaneacion2">
                    <div class="column has-text-centered">
                        <div class="columns is-centered">
                            <div class="column">
                                <div class="field is-grouped is-grouped-multiline">
                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark">Status</span>
                                            <span id="statusOT2" class="tag is-warning">En proceso</span>
                                        </div>
                                    </div>

                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark">OT</span>
                                            <span id="folioOT2" class="tag is-info">2041</span>
                                        </div>
                                    </div>

                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark"><i class="fas fa-user"></i></span>
                                            <span id="txtResponsable2" class="tag is-danger">Sin responsable</span>
                                        </div>
                                    </div>

                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark"><i class="fas fa-calendar-times"></i></span>
                                            <span id="txtFechaRealizado2" class="tag is-danger">Sin fecha</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="column has-text-centered">
                                <div class="field has-addons centerflex">
                                    <p class="control">
                                        <a id="btnImprimirOT2" class="button is-dark is-small">
                                            <span class="icon is-small">
                                                <i class="fas fa-file-alt"></i>
                                            </span>
                                            <span>Imprimir OT</span>
                                        </a>
                                    </p>
                                    <p class="control">
                                        <a class="button is-primary is-small">
                                            <input class="file-input" type="file" name="resume" id="txtArchivoOT2" multiple>
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
                                    <input id="txtComentarioOT2" class="input is-medium is-primary" type="text" placeholder="Añadir un comentario">
                                    <span class="icon is-left"><i class="fas fa-comment-dots"></i></span>
                                    <span class="icon is-right"><i class="fas fa-plus"></i></span>
                                </div>
                            </div>


                        </div>

                        <div class="columns">
                            <div id="listaActividadesMP2" class="column is-8 is-half">

                                <div class="columns hvr-float">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>Mantenimiento
                                                mayor</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
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
                                <div id="timeLineOT2" class="timeline">
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
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                                        </div>
                                    </div>

                                    <div class="timeline-item is-info">
                                        <div class="timeline-marker is-info"></div>
                                        <div class="timeline-content">
                                            <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item is-danger">
                                        <div class="timeline-marker is-danger is-icon">
                                            <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span>
                                            </h4>
                                        </div>
                                        <div class="timeline-content">
                                            <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong> 14/11/1989
                                                20:30</p>
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

                            <div id="timeLineHistorialOT2" class="timeline is-centered">
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

                <!--                        <div class="column is-one-third has-text-centered">
                                                    <div id="myDatePickerMC" class="datepicker-here" data-date-format="mm/dd/yyyy"></div>
                                                                           <input id="txtDateRange1" type="date">
                                                                           <input id="txtDateRange2" type="date" style="display:none;">
                                                </div>-->

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
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>
                        <div class="timeline-item is-danger">
                            <div class="timeline-marker is-danger is-icon">
                                <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span></h4>
                            </div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong> 14/11/1989 20:30</p>
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
        <section id="seccionDetalleProyectos" class="mt-3" style="display:none;">
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
                                <span class="is-size-7"><span><i class="fas fa-bookmark has-text-danger"></i>
                                    </span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) </span>
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
                                <span class="is-size-7"><span><i class="fas fa-bookmark has-text-danger"></i>
                                    </span>(CMU) SONDAS HIDROESTÁTICAS (CMU) SONDAS HIDROESTÁTICAS (CMU) </span>
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
                                <p class="is-size-7">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                    do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                    veniam, quis nostrud exercitation ullamco laboris n</p>
                            </div>
                        </div>

                        <div class="timeline-item is-info">
                            <div class="timeline-marker is-info"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris n</p>
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
                                        <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong> 14/11/1989
                                            20:30</p>
                                        <a class="example-image-link" href="https://picsum.photos/200/200" data-lightbox="cot-gallery" data-title=""><img width="64" height="64" class="example-image img-fluid" src="https://picsum.photos/200/200" alt="" /></a>

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
                                        <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong> 14/11/1989
                                            20:30</p>
                                        <a class="example-image-link" href="https://picsum.photos/200/200" data-lightbox="just-gallery" data-title=""><img width="64" height="64" class="example-image img-fluid" src="https://picsum.photos/200/200" alt="" /></a>

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

    <!-- Modal Para Seleccionar Hotel para los Fans&Cols -->
    <div id="modalHotelRM" class="modal">
        <!-- <div class="modal-background"></div> -->
        <div class="modal-content columns is-centered">
            <div class="box column is-8">
                <a class="is-pulled-right	 delete is-medium" onclick="show_hide_modal('modalHotelRM','hide');"></a>
                <article class="media mt-4">
                    <div class="buttons">
                        <button class="button is-info btn-subsecciones" onclick="showHide('show'); obtenerEquipos(12, 1, 1, 18, 6694, 1, 'RM', 'ZIC', 'FAN&COILS');">GRAND
                            PALLADIUM COLONIAL
                            RESORT & SPA</button>
                        <button class="button is-info btn-subsecciones" onclick="showHide('show'); obtenerEquipos(12, 1, 1, 19, 6695, 1, 'RM', 'ZIC', 'FAN&COILS');">GRAND
                            PALLADIUM KANTENAH
                            RESORT & SPA</button>
                        <button class="button is-info btn-subsecciones" onclick="showHide('show'); obtenerEquipos(12, 1, 1, 21, 6696, 1, 'RM', 'ZIC', 'FAN&COILS');">TRS
                            YUCATÁN
                            HOTEL</button>
                        <button class="button is-info btn-subsecciones" onclick="showHide('show'); obtenerEquipos(12, 1, 1, 20, 6697, 1, 'RM', 'ZIC', 'FAN&COILS');">GRAND
                            PALLADIUM
                            WHITE SAND RESORT &
                            SPA</button>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <!-- Modal Para Seleccionar Hotel para los Fans&Cols -->

    <!-- Modal Para Seleccionar Hotel para los Fans&Cols -->
    <div id="modalHotelCMU" class="modal">
        <!-- <div class="modal-background"></div> -->
        <div class="modal-content columns is-centered">
            <div class="box column is-8">
                <a class="is-pulled-right	 delete is-medium" onclick="show_hide_modal('modalHotelCMU','hide');"></a>
                <article class="media mt-4">
                    <div class="buttons">
                        <button class="button is-info btn-subsecciones" onclick="showHide('show'); obtenerEquipos(12, 7, 1, 22, 6703, 1, 'CMU', 'ZIC', 'FAN&COILS');">GRAND
                            PALLADIUM COSTA MUJERES RESORT & SPA</button>
                        <button class="button is-info btn-subsecciones" onclick="showHide('show'); obtenerEquipos(12, 7, 1, 23, 6704, 1, 'CMU', 'ZIC', 'FAN&COILS');">TRS
                            CORAL HOTEL</button>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <!-- Modal Para Seleccionar Hotel para los Fans&Cols -->


    <!--MODAL MC-->
    <div id="modal-mc" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-lg">
            <section class="modal-card-body">

                <div class="columns">
                    <div id="colMC" class="column">
                        <section class="hero is-light is-small">
                            <!-- Hero head: will stick at the top -->
                            <div class="hero-head">
                                <nav class="navbar">
                                    <div class="navbar-start has-text-centered">
                                        <div class="navbar-item zia-background">
                                            <p class="seccion-logo">ZIA</p>
                                        </div>
                                        <a class="navbar-item">Subseccion / Equipo / Fallas</a>
                                    </div>
                                    <div class="navbar-end has-text-centered">
                                        <div class="navbar-item">
                                            <button type="button" class="button is-success" name="button">
                                                <i class="fad fa-check-double mr-2"></i></i> Ver solucionado
                                            </button>
                                        </div>
                                        <div class="navbar-item">
                                            <button type="button" class="button is-warning" name="button" onclick="closeModal('modal-mc');">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </section>
                        <section class="mt-4">
                            <div class="columns is-centered">
                                ; <div class="column is-3">
                                    <div class="field has-addons">
                                        <div class="control is-expanded">
                                            <input class="input" type="text" placeholder="Agregar Nueva Falla">
                                        </div>
                                        <div class="control">
                                            <a class="button is-warning">
                                                <i class="fad fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </section>

                        <section class="mt-4">

                            <div class="columns is-gapless my-1 is-mobile tg mx-2">
                                <div class="column is-half">
                                    <div class="columns is-mobile">
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Responsable"><strong>Descripción de
                                                    Falla</strong></p>
                                        </div>

                                    </div>
                                </div>
                                <div class="column is-white">
                                    <div class="columns is-gapless is-mobile">
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Responsable">
                                                <strong>Responsable</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Fecha estimada de solucion">
                                                <strong>Fecha</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Documentos e imagenes adjuntoas">
                                                <strong>Adjuntos</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Feedback/Comentarios">
                                                <strong>Comentarios</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos"></p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2">
                                <div class="column is-half">
                                    <div class="columns">
                                        <div class="column">
                                            <div class="message is-small is-danger">
                                                <p class="message-body"><strong>FUGA DE AGUA CALIENTE</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="columns is-gapless">
                                        <div class="column">
                                            <p class="t-icono-rojo"><i class="fad fa-user-slash"></i></p>
                                        </div>
                                        <div class="column">
                                            <p class="t-icono-rojo"><i class="fad fa-calendar-times"></i></p>
                                        </div>
                                        <div class="column">
                                            <p class="t-icono-rojo"><i class="fad fa-file-minus"></i></p>
                                        </div>
                                        <div class="column">
                                            <p class="t-icono-rojo"><i class="fad fa-comment-alt-times"></i></p>
                                        </div>
                                        <div class="column">
                                            <p class="t-solucionado">SOLUCIONAR</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2">
                                <div class="column is-half">
                                    <div class="columns">
                                        <div class="column">
                                            <div class="message is-small is-danger">
                                                <p class="message-body"><strong>FUGA DE AGUA CALIENTE</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="columns is-gapless">
                                        <div class="column">
                                            <p class="t-normal">Eduardo Meneses</p>
                                        </div>
                                        <div class="column">
                                            <p class="t-normal">14 FEB</p>
                                        </div>
                                        <div class="column">
                                            <p class="t-normal">4</p>
                                        </div>
                                        <div class="column">
                                            <p class="t-normal">14</p>
                                        </div>
                                        <div class="column">
                                            <p class="t-solucionado">SOLUCIONAR</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>

                    </div>
                </div>
            </section>
        </div>
    </div>

    <!--MODAL ENERGETICOS-->
    <div id="modal-energeticos" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-lg">
            <section class="modal-card-body">
                <div class="columns">
                    <div class="column">
                        <section class="hero is-light is-small">
                            <!-- Hero head: will stick at the top -->
                            <div class="hero-head">
                                <nav class="navbar">
                                    <div class="navbar-start has-text-centered">
                                        <div class="navbar-item has-background-warning">
                                            <p id="textSeccionEnergeticos" class="navbar-item has-text-weight-bold is-uppercase"></p>
                                        </div>
                                        <a id="textSubseccionEnergeticos" class="navbar-item"></a>
                                    </div>
                                    <div class="navbar-end has-text-centered">

                                        <div class="navbar-item">
                                            <button id="btnObtenerEnergeticos" type="button" class="button is-success" name="button">
                                                <i class="fad fa-check-double mr-2"></i>
                                                Ver solucionado
                                            </button>
                                        </div>

                                        <div class="navbar-item">
                                            <button type="button" class="button is-warning" name="button" onclick="closeModal('modal-energeticos');">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>

                                    </div>
                                </nav>
                            </div>
                        </section>
                        <section class="mt-4">
                            <div class="columns is-centered">
                                <div class="column is-3">
                                    <div class="field has-addons">
                                        <div class="control is-expanded">
                                            <input id="inputEnergetico" class="input" type="text" placeholder="Agregar Pendiente" autocomplete="off">
                                        </div>
                                        <div id="btnCrearEnergetico" class="control">
                                            <a class="button is-warning">
                                                <i class="fad fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </section>

                        <section class="mt-4">

                            <div class="columns is-gapless my-1 is-mobile tg mx-2">
                                <div class="column is-half">
                                    <div class="columns is-mobile">
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Responsable">
                                                <strong>Descripción</strong>
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                <div class="column is-white">
                                    <div class="columns is-gapless is-mobile">
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Responsable">
                                                <strong>Responsable</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Fecha estimada de solución">
                                                <strong>Fecha</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Documentos e imagenes adjuntos">
                                                <strong>Adjuntos</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Comentarios">
                                                <strong>Comentarios</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos"><strong>Status</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="dataEnergeticos" class="scrollbar" style="overflow-x: hidden;overflow-y: scroll;max-height: 50vh;"></div>

                        </section>

                    </div>
                </div>
            </section>
        </div>
    </div>

    <!--INICIO MODAL MPNP-->
    <div id="modal-MPNP" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-lg">
            <section class="modal-card-body">

                <div class="columns">
                    <div id="colMC" class="column">
                        <section class="hero is-light is-small">
                            <!-- Hero head: will stick at the top -->
                            <div class="hero-head">
                                <nav class="navbar">
                                    <div class="navbar-item">
                                        <button type="button" class="button is-warning" name="button" onclick="closeModal('modal-MPNP');">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="navbar-start has-text-centered">
                                        <div id="divNameSeccionMPNP" class="navbar-item zia-background">
                                            <p class="seccion-logo">ZIA</p>
                                        </div>
                                        <a class="navbar-item"> <span id="subseccionMPNP"> </span> / <span id="equipoMPNP"> </span> /
                                            Preventivo No Planificado</a>
                                    </div>
                                </nav>
                            </div>
                        </section>
                        <section class="mt-4">
                            <div class="columns is-centered">
                                <div class="column is-2">
                                    <div class="field has-addons">
                                        <div class="control is-expanded">
                                            <button class="button is-success is-rounded" onclick="showModal('modal-agregar-MPNP'); modalInicialMPNP();">
                                                Agregar MP No Planificado</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="mt-4">

                            <div class="columns is-gapless my-1 is-mobile tg mx-2">
                                <div class="column is-half">
                                    <div class="columns is-mobile">
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Responsable"><strong>Descripcion de
                                                    los Preventivos NO Planeados</strong></p>
                                        </div>

                                    </div>
                                </div>
                                <div class="column is-white">
                                    <div class="columns is-gapless is-mobile">
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Responsable">
                                                <strong>Actividades</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Fecha estimada de solucion">
                                                <strong>Responsable</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Documentos e imagenes adjuntoas">
                                                <strong>Fecha Creado</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Feedback/Comentarios">
                                                <strong>Adjuntos</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Feedback/Comentarios">
                                                <strong>Comentario</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="dataMPNP">
                                <div class="columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2">
                                    <div class="column is-half">
                                        <div class="columns">
                                            <div class="column">
                                                <div class="message is-small is-danger">
                                                    <p class="message-body"><strong>Sin MP</strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <div class="columns is-gapless">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <!-- FIN MODAL MPNP -->

    <!-- INICIO MODAL AGREGAR MPNP -->
    <div id="modal-agregar-MPNP" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title has-text-centered subtitle is-3 my-0"> MP NO PLANIFICADO</p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            Título:
                            <div class="control">
                                <input id="tituloMPNP" class="input is-primary" type="text" placeholder="título MP (5 Caracteres Mínimo)" onkeyup="if(event.keyCode == 13) tituloMPNP('');">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="formMPNP" class="hidden">
                    <div class="columns">
                        <div class="column is-6">
                            Responsable:
                            <div class="field">
                                <p class="control has-icons-left">
                                    <span class="select">
                                        <select id="responsableMPNP" onclick="agregarResponsableMPNP('');">
                                            <option selected value="0"> Seleccione </option>
                                            <?php
                                            if ($idDestinoT == 10) {
                                                $destinoMPNP = "t_users.id_destino IN(1, 7, 2, 6, 5, 11, 3, 4, 10)";
                                            } else {
                                                $destinoMPNP = "t_users.id_destino IN($idDestinoT, 10)";
                                            }
                                            $queryData = "SELECT
                                                t_users.id,
                                                t_colaboradores.nombre,  
                                                t_colaboradores.apellido  
                                                FROM t_users 
                                                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                                                WHERE $destinoMPNP";

                                            $resultData = mysqli_query($conn_2020, $queryData);
                                            while ($rowData = mysqli_fetch_array($resultData)) {
                                                $id = $rowData['id'];
                                                $nombre = $rowData['nombre'];
                                                $apellido = $rowData['apellido'];
                                                echo "<option value=\"$id\">$nombre $apellido</option>";
                                            }
                                            ?>
                                        </select>
                                    </span>
                                    <span class="icon is-small is-left">
                                        <i class="fad fa-user-plus"></i>
                                    </span>
                                </p>
                            </div>
                            <div id="dataResponsablesMPNP" class="column">
                                <!-- <div class="field is-grouped is-grouped-multiline">
                                        <div class="control">
                                            <div class="tags has-addons">
                                                <p class="tag is-primary">
                                                    <span class="mr-2"><i class="fa fa-user"></i></span>
                                                    Eduardo Pool
                                                </p>
                                                <p class="tag is-delete"></p>
                                            </div>
                                        </div>
                                    </div> -->
                            </div>
                        </div>

                        <div class="column is-5">
                            Fecha Realizado:
                            <div class="control">
                                <input id="dateMPNP" class="input is-primary" type="date" placeholder="" value="<?= date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-12 has-text-centered">
                            <div class="field has-addons">
                                <div class="control is-expanded">
                                    <input id="actividadMPNP" class="input" type="text" placeholder="titulo de la actividad">
                                </div>
                                <div class="control">
                                    <a class="button is-info" onclick="agregarActividadMPNP('');">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns">
                        <div id="dataActividadesMPNP" class="column flex inline">

                            <!-- <div class="tags has-addons is-rounded">
                                    <p class="tag is-medium is-info">
                                        <i class="fad fa-angle-right"></i>
                                        <span class="mx-2">
                                            Eduardo Pool
                                        </span>
                                    </p>
                                    <p class="tag is-medium is-delete"></p>
                                </div> -->

                        </div>
                    </div>
                </div>
            </section>
            <footer class="modal-card bd-notificatio has-text-centered has-background-white">
                <div class="columns">
                    <div class="column my-3">
                        <button id="btnGuardarMPNP" class="button is-success" disabled onclick="btnConfirmarMPNP('');">Guardar MP</button>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- FIN MODAL AGREGAR MPNP -->

    <div id="modal-mc-fecha" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <section class="modal-card-body">

                <div class="columns">
                    <div class="column has-text-right">
                        <section class="hero is-light is-small">
                            <!-- Hero head: will stick at the top -->
                            <div class="hero-head">
                                <nav class="navbar">
                                    <div class="navbar-start has-text-centered">

                                    </div>
                                    <div class="navbar-end has-text-centered">

                                        <div class="navbar-item">
                                            <button type="button" class="button is-warning" name="button" onclick="closeModal('modal-mc-fecha');">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </section>
                        <!--<button class="delete" aria-label="close" onclick="closeModal('modal-mc-fecha');"></button>-->
                    </div>
                </div>
                <div class="columns">
                    <div id="colFechaMC" class="column">
                        <h4 class="subtitle is-4 has-text-centered">Rango de Fecha</h4>
                    </div>
                </div>
                <div class="columns is-centered">
                    <div class="column is-6">
                        <div id="myDatePickerMC" class="datepicker-here" data-date-format="mm/dd/yyyy"></div>
                    </div>
                </div>



            </section>
        </div>
    </div>

    <!--MODAL AGREGAR RESPONSABLE TAREA GENERAL-->
    <div id="modalAgregarResponsable" class="modal">
        <br>
        <br>
        <br>
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


    <!--MODAL AGREGAR RESPONSABLE TAREA GENERAL-->
    <div id="modalAgregarResponsableEnergeticos" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <input id="inputResponsableEnergeticos" class="input is-primary" type="text" placeholder="Buscar...">
            </header>
            <!-- Any other Bulma elements you want -->
            <section class="modal-card-body">
                <div class="columns">
                    <div id="divListaUsuariosEnergeticos" class="column"></div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <div class="container">
                    <div class="columns">
                        <div class="column has-text-right">
                            <button class="button is-danger" onclick="closeModal('modalAgregarResponsableEnergeticos');">Cerrar</button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <button class="modal-close is-large" aria-label="close" onclick="closeModal('modalAgregarResponsableEnergeticos');"></button>
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


    <!--MODAL MP/TEST-->
    <div id="modal-mp" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-lg">
            <section class="modal-card-body">

                <div class="columns">
                    <div id="colMP" class="column">
                        <section class="hero is-light is-small">
                            <!-- Hero head: will stick at the top -->
                            <div class="hero-head">
                                <nav class="navbar">
                                    <div class="navbar-start has-text-centered">
                                        <div class="navbar-item zil-background">
                                            <p class="seccion-logo">ZIA</p>
                                        </div>
                                        <a class="navbar-item">Subseccion / Equipo / Falla</a>
                                    </div>
                                    <div class="navbar-end has-text-centered">
                                        <div class="navbar-item">
                                            <button type="button" class="button is-success" name="button">
                                                <i class="fad fa-check-double mr-2"></i></i> Ver solucionado
                                            </button>
                                        </div>
                                        <div class="navbar-item">
                                            <button type="button" class="button is-warning" name="button" onclick="closeModal('modal-mp');">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </nav>
                            </div>
                        </section>
                        <section class="mt-4">
                            <div class="columns is-centered">
                                <div class="column is-3">
                                    <div class="field has-addons">
                                        <div class="control is-expanded">
                                            <input class="input" type="text" placeholder="Agregar Falla">
                                        </div>
                                        <div class="control">
                                            <a class="button is-warning">
                                                <i class="fad fa-plus-circle"></i>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </section>

                        <section class="mt-4">

                            <div class="columns is-gapless my-1 is-mobile tg mx-2">
                                <div class="column is-half">
                                    <div class="columns is-mobile">
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Responsable"><strong>Descripcion de
                                                    los correctivos</strong></p>
                                        </div>

                                    </div>
                                </div>
                                <div class="column is-white">
                                    <div class="columns is-gapless is-mobile">
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Responsable">
                                                <strong>Responsable</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Fecha estimada de solucion">
                                                <strong>Fecha</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Documentos e imagenes adjuntoas">
                                                <strong>Adjuntos</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos" data-tooltip="Feedback/Comentarios">
                                                <strong>Comentarios</strong>
                                            </p>
                                        </div>
                                        <div class="column">
                                            <p class="t-titulos"></p>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2">
                                <div class="column is-half">
                                    <div class="columns">
                                        <div class="column">
                                            <div class="message is-small is-danger">
                                                <p class="message-body"><strong>FUGA DE AGUA CALIENTE</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="columns is-gapless">
                                        <div class="column">
                                            <p class="t-icono-rojo"><i class="fad fa-user-slash"></i></p>
                                        </div>
                                        <div class="column">
                                            <p class="t-icono-rojo"><i class="fad fa-calendar-times"></i></p>
                                        </div>
                                        <div class="column">
                                            <p class="t-icono-rojo"><i class="fad fa-file-minus"></i></p>
                                        </div>
                                        <div class="column">
                                            <p class="t-icono-rojo"><i class="fad fa-comment-alt-times"></i></p>
                                        </div>
                                        <div class="column">
                                            <p class="t-solucionado">SOLUCIONAR</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="columns is-gapless my-1 is-mobile hvr-grow-sm manita mx-2">
                                <div class="column is-half">
                                    <div class="columns">
                                        <div class="column">
                                            <div class="message is-small is-danger">
                                                <p class="message-body"><strong>FUGA DE AGUA CALIENTE</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="columns is-gapless">
                                        <div class="column">
                                            <p class="t-normal">Eduardo Meneses</p>
                                        </div>
                                        <div class="column">
                                            <p class="t-normal">14 FEB</p>
                                        </div>
                                        <div class="column">
                                            <p class="t-normal">4</p>
                                        </div>
                                        <div class="column">
                                            <p class="t-normal">14</p>
                                        </div>
                                        <div class="column">
                                            <p class="t-solucionado">SOLUCIONAR</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </section>

                    </div>
                </div>
                <div id="inicioMP" class="columns is-centered mt-4 border rounded" style="display: none;">
                    <div class="column is-half has-text-centered">
                        <h4 class="title is-4 ">Para poner en proceso este mantenimiento es necesario generar la OT.
                        </h4>
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
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>
                            <li class="hvr-grow manita"><span><i class="fas fa-caret-right has-text-info"></i></span> In
                                fermentum leo eu
                                lectus mollis, quis dictum mi aliquet.</li>

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
                                            <label for="exampleCheckboxSuccessCircle "><span></span>Mantenimiento
                                                mayor</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="columns hvr-float ml-4">
                                    <div class="column">
                                        <div class="field text-truncate has-text-left">
                                            <input class="is-checkradio is-success is-circle" id="exampleCheckboxSuccessCircle" type="checkbox" name="exampleCheckboxSuccessCircle" checked="checked">
                                            <label for="exampleCheckboxSuccessCircle "><span></span>In fermentum leo
                                                eu lectus mollis, quis dictum mi aliquet.</label>
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
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                                        </div>
                                    </div>

                                    <div class="timeline-item is-info">
                                        <div class="timeline-marker is-info"></div>
                                        <div class="timeline-content">
                                            <p class="heading"><strong>Manuel Cervera</strong> 14/11/1989 21:30</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                ad minim veniam, quis nostrud exercitation ullamco laboris n</p>
                                        </div>
                                    </div>
                                    <div class="timeline-item is-danger">
                                        <div class="timeline-marker is-danger is-icon">
                                            <h4 class="title is-4"><span><i class="fas fa-paperclip"></i></span>
                                            </h4>
                                        </div>
                                        <div class="timeline-content">
                                            <p class="heading"><strong>Eduardo Meneses <span class="has-text-danger">Andjuntó</span></strong> 14/11/1989
                                                20:30</p>
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
                <div id="divHistorialMP" class="columns" style="display: none;">
                    <div class="column">
                        <div class="columns is-centered">
                            <div class="column is-half">
                                <h6 class="title is-6 has-text-centered">Ultimas Órdenes de trabajo</h6>

                                <div id="timeLineHistorialOT" class="timeline is-centered">
                                    <div class="timeline-item is-danger">
                                        <div class="timeline-marker is-danger ">
                                        </div>
                                        <div class="timeline-content">
                                            <p class="heading">OT# 342 Creada por: <strong>Eduardo Meneses</strong>
                                            </p>
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
                                            <p class="heading">OT# 342 Creada por: <strong>Eduardo Meneses</strong>
                                            </p>
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
                </div>
            </section>
        </div>
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
                                <input id="txtFechaRealizacion" type='text' class='input has-text-centered datepicker-here' data-language='es' data-auto-close="true" data-date-format="mm/dd/yyyy" placeholder="Fecha de realizacion" />
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
        <br>
        <br>
        <br>
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
        <br>
        <br>
        <br>
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
                                            <input type="number" class="input" id="txtCosteN" placeholder="$" />
                                        </div>
                                    </div>
                                    <div class="columns">
                                        <div class="column">
                                            <input type="number" maxlength="4" class="input" id="txtAñoN" placeholder="Año" />
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
                                    <button id="" class="button is-success" onclick="agregarProyecto(<?php echo $idDestinoT; ?>, <?php echo $idPermiso; ?>, <?php echo $idUsuario; ?>)">CREAR
                                        PROYECTO</button>
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


    <!--MODAL COMENTARIOS EQUIPO-->
    <div id="modal-equipo-comentarios" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-md">
            <section class="modal-card-body">
                <div class="columns">
                    <div id="divHeaderComentarios" class="column">
                        <button class="delete" aria-label="close" onclick="closeModal('modal-equipo-comentarios');"></button>
                    </div>
                </div>
                <div class="columns">
                    <div id="colComentariosEquipo" class="column">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Comentarios generales</h4>

                            <div class="columns is-centered">
                                <div class="column is-8">
                                    <div class="field">
                                        <p class="control has-icons-right">
                                            <input class="input" type="text" placeholder="Añadir comentario">

                                            <span class="icon is-small is-right">
                                                <i class="fas fa-comment-alt-medical"></i>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="heading ">
                                        <strong>
                                            <!-- Here User -->
                                        </strong>
                                    </p>
                                    <p class="heading ">
                                        <!-- Here Date -->
                                    </p>
                                    <p class="has-text-justified">
                                        <!-- Here Coment -->
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item ">
                                <div class="timeline-marker"></div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="colComentariosEquipoMCMP" class="column">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Comentarios Relacionados (MP/MC)</h4>

                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="heading "><strong>Eduardo Meneses</strong></p>
                                    <p class="heading ">14/11/1989 20:30</p>
                                    <div class="control">
                                        <div class="tags has-addons">
                                            <span class="tag is-dark">MP</span>
                                            <span class="tag is-info">OT 86</span>
                                        </div>
                                    </div>
                                    <p class="has-text-justified	">Lorem ipsum dolor sit amet, consectetur
                                        adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris n
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item ">
                                <div class="timeline-marker"></div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!--MODAL COMENTARIOS EQUIPO-->
    <div id="modal-energeticos-comentarios" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <section class="modal-card-body">
                <div class="columns">
                    <div id="divHeaderComentarios" class="column">
                        <button class="delete" aria-label="close" onclick="closeModal('modal-energeticos-comentarios');"></button>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Comentarios</h4>

                            <div class="columns is-centered">
                                <div class="field has-addons has-addons-centered is-fullwidth">
                                    <div class="control">
                                        <div class="control has-icons-left has-icons-right">
                                            <input id="inputComentarioEnergetico" class="input" type="text" placeholder="Añadir comentario" autocomplete="off">
                                            <span class="icon is-small is-left">
                                                <i class="fas fa-comment"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="control"><button id="btnAgregarComentarioEnergetico" type="button" class="button is-info">Agregar</button></div>
                                </div>
                            </div>

                            <div id="dataComentariosEnergetico"></div>

                            <div class="timeline-item ">
                                <div class="timeline-marker"></div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!--MODAL FOTOS EQUIPO-->
    <div id="modal-equipo-pictures" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-md">
            <section class="modal-card-body">
                <div class="columns">
                    <div id="divHeaderFotos" class="column has-text-right">
                        <button class="delete" aria-label="close" onclick="closeModal('modal-equipo-pictures');"></button>
                    </div>
                </div>
                <div class="columns">
                    <div id="colFotosEquipo" class="column is-6">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Fotografias generales</h4>

                            <div class="columns is-centered">
                                <div class="column is-8 has-text-centered">

                                    <a class="button is-warning">
                                        <input class="file-input" type="file" name="resume" id="txtFotoEquipo" multiple>
                                        <span class="icon">
                                            <i class="fad fa-camera-alt"></i>
                                        </span>
                                        <span>Añadir fotografias</span>
                                    </a>
                                </div>
                            </div>


                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="heading "><strong>Eduardo Meneses</strong></p>
                                    <p class="heading ">14/11/1989 20:30</p>

                                </div>
                            </div>

                            <div class="timeline-item ">
                                <div class="timeline-marker"></div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div id="colFotosMPMC" class="column is-6">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Fotografias Relacionados (MP/MC)</h4>

                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="heading "><strong>Eduardo Meneses</strong></p>
                                    <p class="heading ">14/11/1989 20:30</p>
                                    <div class="control mb-2">
                                        <div class="tags has-addons">
                                            <span class="tag is-info">MP</span>
                                            <span class="tag is-dark">OT 86</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="heading "><strong>Eduardo Meneses</strong></p>
                                    <p class="heading ">14/11/1989 20:30</p>
                                    <div class="control mb-2">
                                        <div class="tags has-addons">
                                            <span class="tag is-warning">MC</span>
                                            <span class="tag is-dark">NOMBRE DE LA TAREA</span>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="timeline-item ">
                                <div class="timeline-marker"></div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!--                <footer class="modal-card-foot">
                                    <button class="button is-success">Save changes</button>
                                    <button class="button">Cancel</button>
                                </footer>-->
        </div>
    </div>


    <!--MODAL FOTOS EQUIPO-->
    <div id="modal-energeticos-pictures" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <section class="modal-card-body">
                <div class="columns">
                    <div class="column is-6">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Fotografias generales</h4>
                            <div class="columns is-centered">
                                <div class="column is-8 has-text-centered">
                                    <a class="button is-warning">
                                        <input class="file-input" type="file" name="resume" id="inputAdjuntosEnergeticos" multiple>
                                        <span class="icon">
                                            <i class="fad fa-camera-alt"></i>
                                        </span>
                                        <span>Añadir fotografias</span>
                                    </a>
                                </div>
                            </div>

                            <div id="dataAdjuntosEnergeticos"></div>

                            <div class="timeline-item ">
                                <div class="timeline-marker"></div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!--MODAL COTIZACIONES EQUIPO-->
    <div id="modal-equipo-cotizaciones" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-md">

            <!--                <header class="modal-card-head">
                                    <p class="modal-card-title">Modal title</p>
                                    <button class="delete" aria-label="close"></button>
                                </header>-->
            <section class="modal-card-body">
                <div class="columns">
                    <div id="divHeaderCot" class="column has-text-right">
                        <button class="delete" aria-label="close" onclick="closeModal('modal-equipo-cotizaciones');"></button>
                    </div>
                </div>
                <div class="columns">
                    <div id="colCotEquipo" class="column">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Cotizaciones</h4>

                            <div class="columns is-centered">
                                <div class="column is-8 has-text-centered">

                                    <a class="button is-warning">
                                        <input class="file-input" type="file" name="resume" id="txtCotEquipo" multiple>
                                        <span class="icon">
                                            <i class="fas fa-plus"></i>
                                        </span>
                                        <span>Añadir cotizaciones</span>
                                    </a>
                                </div>
                            </div>


                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="heading "><strong>Eduardo Meneses</strong></p>
                                    <p class="heading ">14/11/1989 20:30</p>

                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <p class="heading "><strong>Eduardo Meneses</strong></p>
                                    <p class="heading ">14/11/1989 20:30</p>

                                </div>
                            </div>

                            <div class="timeline-item ">
                                <div class="timeline-marker"></div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!--                <footer class="modal-card-foot">
                                    <button class="button is-success">Save changes</button>
                                    <button class="button">Cancel</button>
                                </footer>-->
        </div>
    </div>


    <!--MODAL INFORMACION DE EQUIPO-->
    <div id="modal-equipo-info" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-md">
            <section class="modal-card-body">
                <div class="columns">
                    <div id="divHeaderInfo" class="column has-text-right">
                        <button class="delete" aria-label="close" onclick="closeModal('modal-equipo-info');"></button>
                    </div>
                </div>

                <div id="rowInfoEquipo" class="columns">

                    <!-- Columna donde se muestran las fotografias Adjuntas. -->
                    <div id="colInfoEquipoImagenes" class="column">
                        <div id="colFotosEquipo1" class="column"></div>
                    </div>

                    <!-- Columna donde se muestra la información del equipo. -->
                    <div id="colInfoEquipo" class="column">
                        <h4 class="subtitle is-4 has-text-centered">Informacion del equipo</h4>

                        <div class="columns is-centered">
                            <div class="column is-8 has-text-centered">
                                <button class="button is-warning">
                                    <span class="icon is-small">
                                        <i class="fad fa-edit"></i>
                                    </span>
                                    <span>Editar información</span>
                                </button>
                            </div>
                        </div>

                        <div class="columns is-mobile is-gapless">
                            <div class="column has-text-right">
                                <h4 class="subtitle is-6 mr-2">Nombre: </h4>
                                <h4 class="subtitle is-6 mr-2">Destino: </h4>
                                <h4 class="subtitle is-6 mr-2">Tipo: </h4>
                                <h4 class="subtitle is-6 mr-2">Matricula: </h4>
                                <h4 class="subtitle is-6 mr-2">Ceco: </h4>
                                <h4 class="subtitle is-6 mr-2">Seccion: </h4>
                                <h4 class="subtitle is-6 mr-2">Marca: </h4>
                                <h4 class="subtitle is-6 mr-2">Modelo: </h4>
                                <h4 class="subtitle is-6 mr-2">Serie: </h4>
                                <h4 class="subtitle is-6 mr-2">Estado: </h4>
                                <h4 class="subtitle is-6 mr-2">Jerarquia: </h4>
                            </div>
                            <div class="column has-text-left">
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                                <h4 class="subtitle is-6">xxxxxxxxxxxxxx</h4>
                            </div>
                        </div>
                        <div class="columns">lorem </div>
                    </div>

                    <!-- Columna donde e muestran archivos Adjuntos. -->
                    <div id="colInfoEquipoAdjuntos" class="column">
                        <h4 class="subtitle is-4 has-text-centered">Archivos Adjuntos</h4>
                    </div>

                </div>
                <div id="rowEditarInfo" class="column" style="display: none;">
                    <div id="colEditarInfo" class="column">
                        <h4 class="subtitle is-4 has-text-centered">Editar Información</h4>

                        <div class="columns ">
                            <div class="column has-text-left">
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">Marca</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns ">
                            <div class="column has-text-left">
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">Modelo</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <p class="control">
                                                <input class="input" type="text" placeholder="Modelo">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns ">
                            <div class="column has-text-left">
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">Serie</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <p class="control">
                                                <input class="input" type="text" placeholder="Serie">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns ">
                            <div class="column has-text-left">
                                <div class="field is-horizontal">
                                    <div class="field-label is-normal">
                                        <label class="label">Estado</label>
                                    </div>
                                    <div class="field-body">
                                        <div class="field">
                                            <div class="control">
                                                <div class="select">
                                                    <select>
                                                        <option>Operativo</option>
                                                        <option>Baja</option>
                                                        <option>Taller</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns is-centered">
                            <div class="column is-8 has-text-centered">
                                <button class="button is-warning">
                                    <span class="icon is-small">
                                        <i class="fad fa-save"></i>
                                    </span>
                                    <span>Guardar Cambios</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal TAREAS P -->
    <div id="modal-tareas-p" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content bg-white p-2" style="width:90%; height:auto">
            <section class="hero is-light is-small">
                <div class="hero-head">
                    <nav class=" navbar-menu">
                        <div class="navbar-start has-text-centered">
                            <span class="navbar-item">
                                <button class="button is-warning is-large" onclick="closeModal('modal-tareas-p');"><i class="fas fa-arrow-left"></i></button>
                            </span>
                            <div id="estiloSeccionTareas" class="flex items-center">
                                <p id="textSeccionTareas" class="seccion-logo">--</p>
                            </div>
                            <a class="navbar-item">Equipo / <span id="dataEquipoTareasP"> </span></a>
                        </div>
                        <div class="navbar-end has-text-centered">
                            <div class="navbar-item">
                                <button type="button" class="button is-warning" name="button">
                                    <i class="fad fa-file-excel mr-2"></i>Exportar
                                </button>
                            </div>
                            <div class="navbar-item">
                                <button id="btnTareas" type="button" class="button" name="button">
                                    <i class="fad fa-check-double mr-2"></i><span id="txtTareas"></span>
                                </button>
                            </div>
                        </div>
                    </nav>
                </div>
            </section>

            <section class="flex justify-center my-4">
                <div class="columns is-centered">
                    <div class="column is-12">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input id="tituloTareaP" class="input" type="text" placeholder="Agregar Tarea" maxlength="60" autocomplete="off">
                            </div>
                            <div id="btnAgregarTareaP" class="control">
                                <a class="button is-warning">
                                    <i class="fad fa-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
            </section>

            <section class="">
                <div class="columns is-gapless rounded">
                    <div class="column column is-half">
                        <div class="columns">
                            <div class="column">
                                <p class="t-titulos"><strong>Descripción Tarea</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="columns is-gapless">
                            <div class="column">
                                <p class="t-titulos" data-tooltip="Plan Acción"><strong>Responsable</strong></p>
                            </div>
                            <div class="column">
                                <p class="t-titulos" data-tooltip="Responsable"><strong>Fecha</strong></p>
                            </div>
                            <div class="column">
                                <p class="t-titulos" data-tooltip="Fecha estimada de solucion"><strong>Adjuntos</strong>
                                </p>
                            </div>
                            <div class="column">
                                <p class="t-titulos" data-tooltip="Status"><strong>Comentarios</strong></p>
                            </div>
                            <div class="column">
                                <p class="t-titulos" data-tooltip="Status"><strong>Status</strong></p>
                            </div>
                            <div class="column">
                                <p class="t-titulos" data-tooltip="Status"><strong>Opción</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--FILA DE TITULOS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->


                <!-- Aquí se imprimen la información de los ProyectosXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
            </section>

            <section class="mb-4">
                <div id="dataTareasP"></div>
            </section>

        </div>
    </div>
    <!-- Modal TAREAS P -->


    <!--MODAL COMENTARIOS EQUIPO-->
    <div id="modal-comentarios-tareas" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-md">
            <section class="modal-card-body">
                <div class="columns">
                    <div id="dataHeaderComentarios" class="column"></div>

                    <div class="column is-1">
                        <button class="button is-warning" onclick="closeModal('modal-comentarios-tareas');">
                            <span class="icon is-small">
                                <i class="fas fa-times"></i>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="columns">
                    <div id="" class="column">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Comentarios Tareas</h4>

                            <div class="columns is-centered">
                                <div class="column is-3">

                                    <div class="field has-addons">
                                        <div class="control">
                                            <input id="textComentarioTareas" class="input" type="text" placeholder="Agregar Comentaio" autocomplete="off">
                                        </div>
                                        <div id="agregarComentarioTarea" class="control">
                                            <a class="button is-info">
                                                Agregar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="columns">
                                <!-- Data Comentarios -->
                                <div id="dataComentariosTareas"></div>
                            </div>
                        </div>
                    </div>
            </section>
        </div>
    </div>

    <!--MODAL FOTOS EQUIPO-->
    <div id="modal-tareas-pictures" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-md">
            <section class="modal-card-body">
                <div class="columns">
                    <div id="" class="column has-text-right">
                        <button class="delete" aria-label="close" onclick="closeModal('modal-tareas-pictures');"></button>
                    </div>
                </div>
                <div class="columns">
                    <div id="colFotosTareas" class="column is-6">
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!-- Status TareasP -->
    <div id="modalStatusTareasP" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column">

                                <button id="statusUrgenteATP" class="button is-danger is-fullwidth">
                                    <i class="fad fa-siren-on mr-4 fa-lg animated infinite flash"></i>
                                    Es urgente!
                                </button>

                                <button id="statusMaterialATP" class="button is-dark is-fullwidth mt-2">
                                    <span class="mr-4 fa-lg"><strong> M
                                        </strong></span> No hay material
                                </button>

                                <div id="codigoSeguimientoTareas" class="columns is-fullwidth is-centered mt-2 is-hidden">
                                    <input id="inputCodigoSeguimientoTareas" class="column button is-6 mt-2" type="text" placeholder="COD2BEND" autocomplete="off">
                                    <button id="statusMaterialTareas" class="column button is-2 mt-2 is-dark text-bold p-1 mx-2" onclick="statusMateriales()">Aplicar</button>
                                </div>

                                <button id="" class="button is-warning is-fullwidth mt-2" onclick="toggleModal('StatusEnergeticos');">
                                    <span class="mr-4 fa-lg"><strong>E</strong></span>Energéticos
                                </button>
                                <div id="actividadStatusEnergeticos" class="modal has-background-light p-3 m-2">

                                    <button id="statusElectricidadATP" class="button is-warning has-text-centered m-1">Electricidad</button>

                                    <button id="statusAguaATP" class="button is-warning has-text-centered m-1">Agua</button>

                                    <button id="statusDieselATP" class="button is-warning has-text-centered m-1">Diésel</button>

                                    <button id="statusGasATP" class="button is-warning has-text-centered m-1">Gas</button>
                                </div>

                                <button class="button is-primary is-fullwidth mt-2" onclick="toggleModal('StatusDepartamentos');"><span class="mr-4 fa-lg"><strong>D</strong></span>Departamento
                                </button>
                                <div id="actividadStatusDepartamentos" class="modal has-background-light p-3 m-2">

                                    <button id="statusCalidadATP" class="button is-primary has-text-centered m-1">Calidad
                                    </button>

                                    <button id="statusComprasATP" class="button is-primary has-text-centered m-1">Compras
                                    </button>

                                    <button id="statusDireccionATP" class="button is-primary has-text-centered m-1">Dirección
                                    </button>

                                    <button id="statusFinanzasATP" class="button is-primary has-text-centered m-1">Finanzas
                                    </button>

                                    <button id="statusRRHHATP" class="button is-primary has-text-centered m-1">RRHH
                                    </button>

                                </div>

                                <button id="statusTrabajandoATP" class="button is-info is-fullwidth mt-2">
                                    <span class="mr-4 fa-lg"><strong>T</strong></span>Trabajando
                                </button>

                                <button id="statusSolucionarATP" class="button is-success is-fullwidth mt-2">
                                    <i class="fad fa-check-double mr-4 fa-lg"></i>Solucionar
                                </button>

                                <button id="statusRestaurarATP" class="button is-danger is-fullwidth mt-2">
                                    <i class="fad fa-undo mr-4 fa-lg"></i>Restaurar
                                </button>

                                <div class="column has-text-centered">

                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center" onclick="toggleModal('NuevoTituloATP');">
                                        <i class="far fa-edit"></i>
                                        <span> Editar</span>
                                    </button>
                                    <button id="btnEliminarATP" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center">
                                        <i class="far fa-trash-alt"></i>
                                        <span> Eliminar</span>
                                    </button>
                                </div>

                                <div id="actividadNuevoTituloATP" class="column has-text-centered modal">
                                    <input id="nuevoTituloATP" class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="text" placeholder="Nuevo Titulo">
                                    <button id="btnTituloATP" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded inline-flex items-center">
                                        <i class="far fa-save"></i>
                                        <span> Guardar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Status TareasP -->



    <!-- Status Energeticos -->
    <div id="modalStatusEnergeticos" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column">

                                <button id="" class="button is-danger is-fullwidth">
                                    <i class="fad fa-siren-on mr-4 fa-lg animated infinite flash"></i> Es urgente!
                                </button>

                                <button class="button is-dark is-fullwidth mt-2" onclick=" toggleHidden('contenedorstatusMaterial');">
                                    <span class="mr-4 fa-lg">
                                        <strong> M </strong>
                                    </span> No hay material
                                </button>

                                <div id="contenedorstatusMaterial" class="is-fullwidth is-centered mt-2 hidden">
                                    <input id="inputCod2bendEnergetico" class="button is-6 mt-2" type="text" placeholder="COD2BEND" autocomplete="off">
                                    <button id="btnStatusEnergetico" class="button is-2 mt-2 is-dark text-bold p-1 mx-2" onclick="">Aplicar</button>
                                </div>

                                <button class="button is-warning is-fullwidth mt-2" onclick="toggleHidden('contenedorEnergeticosToggle');">
                                    <span class="mr-4 fa-lg"><strong>E</strong></span>Energéticos
                                </button>
                                <div id="contenedorEnergeticosToggle" class="has-background-light p-3 m-2 hidden">

                                    <button id="btnStatusElectricidadEnergetico" class="button is-warning has-text-centered m-1">Electricidad</button>

                                    <button id="btnStatusAguaEnergetico" class="button is-warning has-text-centered m-1">Agua</button>

                                    <button id="btnStatusDieselEnergetico" class="button is-warning has-text-centered m-1">Diésel</button>

                                    <button id="btnStatusGasEnergetico" class="button is-warning has-text-centered m-1">Gas</button>
                                </div>

                                <button class="button is-primary is-fullwidth mt-2" onclick="toggleHidden('contenedorDepartamentosToggle');"><span class="mr-4 fa-lg"><strong>D</strong></span>Departamento
                                </button>
                                <div id="contenedorDepartamentosToggle" class="has-background-light p-3 m-2 hidden">

                                    <button id="btnStatusCalidadEnergetico" class="button is-primary has-text-centered m-1">Calidad
                                    </button>

                                    <button id="btnStatusComprasEnergetico" class="button is-primary has-text-centered m-1">Compras
                                    </button>

                                    <button id="btnStatusDireccionEnergetico" class="button is-primary has-text-centered m-1">Dirección
                                    </button>

                                    <button id="btnStatusFinanzasEnergetico" class="button is-primary has-text-centered m-1">Finanzas
                                    </button>

                                    <button id="btnStatusRRHHEnergetico" class="button is-primary has-text-centered m-1">RRHH
                                    </button>
                                </div>

                                <button id="btnStatusTrabajandoEnergetico" class="button is-info is-fullwidth mt-2">
                                    <span class="mr-4 fa-lg"><strong>T</strong></span>Trabajando
                                </button>

                                <button id="btnStatusSolucionarEnergetico" class="button is-success is-fullwidth mt-2">
                                    <i class="fad fa-check-double mr-4 fa-lg"></i>Solucionar
                                </button>

                                <div class="column has-text-centered">

                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center" onclick="toggleHidden('nuevoTituloEnergeticos');">
                                        <i class="far fa-edit"></i>
                                        <span> Editar</span>
                                    </button>
                                    <button id="btnEliminarEnergetico" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center">
                                        <i class="far fa-trash-alt"></i>
                                        <span> Eliminar</span>
                                    </button>
                                </div>

                                <div id="nuevoTituloEnergeticos" class="has-text-centered hidden">
                                    <input id="inputTituloEnergetico" class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="text" placeholder="Nuevo Titulo">
                                    <button id="btnActualizarTituloEnergetico" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded inline-flex items-center">
                                        <i class="far fa-save"></i>
                                        <span> Guardar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Status Energeticos -->


    <!-- ************************************************************************ En Proceso ************************************************************************** -->
    <div id="modal-proyectos" style="display: none;">
        <br>
        <br>
        <br>
        <section class="hero is-light is-small">
            <!-- Hero head: will stick at the top -->
            <div class="hero-head">
                <nav class="navbar-menu">
                    <div class="navbar-start has-text-centered">
                        <span class="navbar-item">
                            <button class="button is-warning" onclick="showsubsecciones('')"><i class="fas fa-arrow-left"></i></button>
                        </span>
                        <div id="estiloSeccionProyectos" class="">
                            <input id="textSeccionAux" type="hidden">
                            <p class="seccion-logo" id="textSeccion"></p>
                        </div>
                        <!-- Aqui imprimes el nombre de la subseccion, el nombre del equipo o si es tareas generales va "tareas generales" y por ultimo tiene que decir correctivos -->
                        <a class="navbar-item">Proyectos / Plan de Acción</a>
                    </div>
                    <div class="navbar-end has-text-centered">
                        <div class="navbar-item">
                            <button type="button" class="button is-warning" name="button">
                                <i class="fad fa-file-excel mr-2"></i>Exportar
                            </button>
                        </div>
                        <div class="navbar-item">
                            <button id="btnProyectosFinalizados" type="button" class="button is-success is-hidden" name="button">
                                <i id="" class="fad fa-check-double mr-2"></i>Ver Finalizados
                            </button>
                            <button id="btnProyectosPendientes" type="button" class="button is-danger" name="button">
                                <i id="" class="fad fa-check-double mr-2"></i>Ver Pendientes
                            </button>
                        </div>
                    </div>
                </nav>
            </div>
        </section>


        <section class="mt-4">
            <div class="columns">
                <div class="column is-3 has-text-left">
                    <div class="field has-addons">
                        <div class="control is-expanded ml-5">
                            <input id="tituloProyectoNuevo" class="input" type="text" placeholder="Agregar Proyecto" maxlength="60" autocomplete="off">
                        </div>
                        <div class="control">
                            <a class="button is-warning" onclick="nuevoProyecto();">
                                <i class="fad fa-plus-circle"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </section>


        <!--FILA DE TITULOS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
        <section class="mt-4">
            <div class="columns is-gapless mx-4 rounded mb-3 has-text-white">
                <div class="column is-one-third">
                    <div class="columns">
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Responsable">Descripcion de los proyectos</p>
                        </div>

                    </div>
                </div>
                <div class="column ">
                    <div class="columns is-gapless">
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Plan Acción">Plan Acción</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Responsable">Responsable</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Fecha estimada de solucion">Fecha</p>
                        </div>
                        <!-- <div class="column">
                            <p class="barratitulos" data-tooltip="Documentos e imagenes adjuntos">Adjuntos</p>
                        </div> -->
                        <!-- <div class="column">
                            <p class="barratitulos" data-tooltip="Comentarios">Comentarios</p>
                        </div> -->
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Cotizaciones">Cotizaciones</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Tipo">Tipo</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Justificación">Justificación</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Coste">Coste</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Status">Status</p>
                        </div>
                    </div>
                </div>
            </div>
            <!--FILA DE TITULOS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->


            <!-- Aquí se imprimen la información de los ProyectosXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
        </section>
        <!--FIN FILA DE TITULOS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->


        <!-- RECIBE DATOS DE LOS PROYECTOS ******************************************************************************************* -->
        <section class="mt-4">
            <div id="data-proyectos"></div>

            <!-- Tareas Generales convertidos a proyectos! -->
            <div id="data-proyectos-TG"></div>

        </section>
        <!-- RECIBE DATOS DE LOS PROYECTOS ******************************************************************************************* -->

    </div>


    <!-- ****************************************************************** Modal para mostrar el Status de los Departamentos *****************************************************  -->
    <div id="reporteStatusDEP" class="modal p-4 mt-5">
        <section class="hero is-light is-small" style="width: 100%;">
            <!-- Hero head: will stick at the top -->
            <div class="hero-head">
                <nav class="navbar-menu">
                    <div class="navbar-start has-text-centered">
                        <button class="button is-warning m-2" onclick="show_hide_modal('reporteStatusDEP','hide'); show_hide_modalProyectos('modal-proyectos','show');"><i class=" fas fa-arrow-left"></i></button>
                        <div class="DEP" style="background: #c8a7fc; width:60px;">
                            <!-- Aqui imprimes el nombre de la seccion y se cambian las clases de colores segun la seccion -->
                            <h3 class="title  is-4 has-text-centered mt-2">DEP</h3>
                        </div>
                        <!-- Aqui imprimes el nombre de la subseccion, el nombre del equipo o si es tareas generales va "tareas generales" y por ultimo tiene que decir correctivos -->
                        <a class="navbar-item"> Departamento &nbsp; <span id="nombreSubseccionDEP"> </span>&nbsp;/
                            Status</a>
                    </div>
                    <div class="navbar-end has-text-centered">
                        <div class="navbar-item">
                            <form method="POST" action="php/GenerarExcel.php">
                                <!-- Agregar para general XLS -->
                                <input type="hidden" id="xlsIdGrupo" name="xlsIdGrupo">
                                <input type="hidden" id="xlsIdDestino" name="xlsIdDestino">
                                <input type="hidden" id="xlsIdSeccion" name="xlsIdSeccion">
                                <button type="submit" id="btnEXLS" class="button is-warning" name="button" onclick="">
                                    <i class="fad fa-file-excel mr-2"></i>Exportar
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </section>



        <section class="mt-4" style="width: 100%;">
            <section class="mt-4">

                <div class="columns is-gapless mx-4 rounded mb-3 has-text-white">
                    <div class="column is-half">
                        <div class="columns is-mobile">
                            <div class="column">
                                <p class="barratitulos" data-tooltip="Responsable"><strong class="has-text-white">Descripcion de Falla</strong></p>
                            </div>

                        </div>
                    </div>
                    <div class="column is-white">
                        <div class="columns is-gapless is-mobile">
                            <div class="column">
                                <p class="barratitulos" data-tooltip="Responsable"><strong class="has-text-white">Responsable</strong></p>
                            </div>
                            <div class="column">
                                <p class="barratitulos" data-tooltip="Fecha estimada de solucion"><strong class="has-text-white">Fecha</strong></p>
                            </div>
                            <div class="column">
                                <p class="barratitulos" data-tooltip="Documentos e imagenes adjuntoas"><strong class="has-text-white">Adjuntos</strong></p>
                            </div>
                            <div class="column">
                                <p class="barratitulos" data-tooltip="Feedback/Comentarios"><strong class="has-text-white">Comentarios</strong></p>
                            </div>
                            <div class="column">
                                <p class="barratitulos">Status</p>
                            </div>
                            <div class="column">
                                <p class="barratitulos">CODSAP</p>
                            </div>
                            <div class="column">
                                <p class="barratitulos">COD2BEND</p>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <div id="reporteStatusDEPData"></div>
        </section>
    </div>
    <!-- ***************************************************************************************************************************************************************** -->


    <!-- ************************************************************************ En Proceso ************************************************************************** -->
    <div id="modal-proyectos-finalizados" class="modal">
        <br><br><br>
        <section class="hero is-light is-small" style="width: 100%;">
            <!-- Hero head: will stick at the top -->
            <div class="hero-head">
                <nav class="navbar-menu">
                    <div class="navbar-start has-text-centered">
                        <span class="navbar-item">
                            <button class="button is-warning" onclick="regresarProyectos()"><i class="fas fa-arrow-left"></i></button>
                        </span>
                        <div class="s-zia">
                            <!-- Aqui imprimes el nombre de la seccion y se cambian las clases de colores segun la seccion -->
                            <p id="textSeccionProyectosFinalizados">--</p>
                        </div>
                        <!-- Aqui imprimes el nombre de la subseccion, el nombre del equipo o si es tareas generales va "tareas generales" y por ultimo tiene que decir correctivos -->
                        <a class="navbar-item"> Proyectos / Finalizados</a>
                    </div>
                    <div class="navbar-end has-text-centered">
                        <div class="navbar-item">
                            <button type="button" class="button is-warning" name="button">
                                <i class="fad fa-file-excel mr-2"></i>Exportar
                            </button>
                        </div>

                    </div>
                </nav>
            </div>
        </section>

        <section class="mt-4">
        </section>

        <section class="mt-4" style="width: 100%;">
            <!--FILA DE TITULOS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
            <div class="columns is-gapless mx-4 rounded mb-3 has-text-white">
                <div class="column is-one-third">
                    <div class="columns">
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Responsable">Descripcion de los proyectos</p>
                        </div>

                    </div>
                </div>
                <div class="column ">
                    <div class="columns is-gapless">
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Responsable Asignado">Responsable</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Fecha estimada de solucion">Fecha</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Documentos e imagenes adjuntoas">Adjuntos</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Comentarios">Comentarios</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Cotizaciones">Cotizaciones</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Tipo">Tipo</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Justificación">Justificación</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Coste">Coste</p>
                        </div>
                        <div class="column">
                            <p class="barratitulos" data-tooltip="Status Actual">Status</p>
                        </div>

                    </div>
                </div>
            </div>
            <!--FILA DE TITULOS XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->

            <!-- Aquí se imprimen la información de los ProyectosXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX -->
            <div id="data-proyectos-finalizados"></div>
        </section>
    </div>


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL JUSTIFICACION xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modal-Justificacion" class="modal">
        <input type="hidden" id="idProyectoJustificacion">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->

            <div class="card">
                <div class="card-content">
                    <div class="content">

                        <div class="columns">
                            <div class="column">
                                <textarea id="dataJustificacion" class="textarea" placeholder="Escriba la justificacion del proyecto..."></textarea>
                                <button class="button is-info is-fullwidth mt-2" onclick="actualizarJustificacionProyecto();"><i class="fad fa-save mr-4 fa-lg"></i>Guardar</button>
                                <br><button class="button is-info is-fullwidth mt-2" onclick="consultaArchivoJustificacion();"><i class="fad fa-cloud-upload-alt fa-lg"></i>Adjuntos</button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL JUSTIFICACION xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL COSTE xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modal-Costo" class="modal">
        <input type="hidden" id="idProyectoCoste">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">

                <div class="card-content">
                    <div class="content">

                        <div class="columns">
                            <div class="column">
                                <div class="control">
                                    <span></span><input id="dataCoste" class="input" type="text" placeholder="Coste en USD">
                                </div>
                                <button class="button is-info is-fullwidth mt-2" onclick="actualizarCostoProyecto();"><i class="fad fa-save mr-4 fa-lg"></i>Guardar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL COSTE xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS  PLAN ACCIÓN xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modalStatusPlanAccion" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column">
                                <button class="button is-danger is-fullwidth" onclick="aplicarStatus('urgente');"><i class="fad fa-siren-on mr-4 fa-lg animated infinite flash"></i>Es
                                    urgente!</button>
                                <button class="button is-dark is-fullwidth mt-2" onclick="aplicarStatus('material');"><span class="mr-4 fa-lg"><strong> M
                                        </strong></span> No hay material</button>
                                <button class="button is-warning is-fullwidth mt-2" onclick="show_hide_modal('modalEnergetico', 'show');"><span class="mr-4 fa-lg"><strong>E</strong></span>Energéticos</button>
                                <button class="button is-primary is-fullwidth mt-2" onclick="show_hide_modal('modalDepartamento', 'show');"><span class="mr-4 fa-lg"><strong>D</strong></span>Departamento</button>
                                <button class="button is-info is-fullwidth mt-2" onclick="aplicarStatus('trabajare');"><span class="mr-4 fa-lg"><strong>T</strong></span>Trabajando</button>
                                <button class="button is-success is-fullwidth mt-2" onclick="aplicarStatus('solucionado');"><i class="fad fa-check-double mr-4 fa-lg"></i>Solucionar</button>
                                <div class="column has-text-centered">
                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center" onclick="btnEditarPlan();">
                                        <i class="far fa-edit"></i>
                                        <span> Editar</span>
                                    </button>
                                    <button id="btnEditarPlan" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center" onclick="eliminarPlanAccion('');">
                                        <i class="far fa-trash-alt"></i>
                                        <span> Eliminar</span>
                                    </button>
                                </div>
                                <div class="column has-text-centered">
                                    <input id="editarTituloPlan" class="hidden bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="text" placeholder="Nuevo Titulo">
                                    <button id="btnTituloPlan" class="hidden bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded inline-flex items-center" onclick="actualizarPlanAccion('');">
                                        <i class="far fa-save"></i>
                                        <span> Guardar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modal-Status" class="modal">
        <input type="hidden" id="idProyectoStatus">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column">
                                <button class="button is-danger is-fullwidth" onclick="statusProyecto('urgente');"><i class="fad fa-siren-on mr-4 fa-lg animated infinite flash"></i>Es
                                    urgente!</button>
                                <button class="button is-dark is-fullwidth mt-2" onclick="statusProyecto('material');"><span class="mr-4 fa-lg"><strong> M
                                        </strong></span> No hay material</button>
                                <button class="button is-warning is-fullwidth mt-2" onclick="show_hide_modal('modalEnergetico', 'show');"><span class="mr-4 fa-lg"><strong>E</strong></span>Energéticos</button>
                                <button class="button is-primary is-fullwidth mt-2" onclick="show_hide_modal('modalDepartamento', 'show');"><span class="mr-4 fa-lg"><strong>D</strong></span>Departamento</button>
                                <button class="button is-info is-fullwidth mt-2" onclick="statusProyecto('trabajare');"><span class="mr-4 fa-lg"><strong>T</strong></span>Trabajando</button>
                                <!--<button class="button is-success is-fullwidth mt-2" onclick="statusProyecto('solucionado');"><i class="fad fa-check-double mr-4 fa-lg"></i>Solucionar</button>-->
                            </div>
                        </div>
                        <div class="columns">
                            <div id="dataOptionDEP" class="column has-text-centered">

                            </div>
                        </div>
                        <div class="columns my-0">
                            <div class="column has-text-centered my-0">
                                <div class="has-text-centered">
                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center" onclick="btnEditarProyecto();">
                                        <i class="far fa-edit"></i>
                                        <span> Editar</span>
                                    </button>
                                    <button id="btnEditarPlan" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center" onclick="eliminarProyecto('');">
                                        <i class="far fa-trash-alt"></i>
                                        <span> Eliminar</span>
                                    </button>
                                </div>
                                <div id="btnInputProyecto" class="has-text-centered hidden">
                                    <input id="editarTituloProyecto" class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="text" placeholder="Nuevo Titulo">
                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded inline-flex items-center" onclick="editarProyecto('');">
                                        <i class="far fa-save"></i>
                                        <span> Guardar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS  MC xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modalStatusMC" class="modal">
        <input type="hidden" id="idMC">
        <input type="hidden" id="idUsuarioMC">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column mb-0">
                                <button class="button is-danger is-fullwidth" onclick="statusMC('urgente');"><i class="fad fa-siren-on mr-4 fa-lg animated infinite flash"></i>Es
                                    urgente!</button>
                                <button class="button is-dark is-fullwidth mt-2" onclick="consultaCodigoSeguimientoMC()"><span class="mr-4 fa-lg"><strong>M</strong></span>No hay material</button>
                                <div id="codigoSeguimientoMC" class="columns is-fullwidth is-centered mt-2 is-hidden">
                                    <input id="codigoSeguimiento" class="column button is-6 mt-2" type="text" placeholder="COD2BEND" autocomplete="off">
                                    <button class="column button is-2 mt-2 is-dark text-bold p-1 mx-2" onclick="statusMateriales()">Aplicar</button>
                                </div>
                                <button class="button is-warning is-fullwidth mt-2" onclick="show_hide_modal('modalStatusMC', 'hide');show_hide_modal('modalEnergeticoMC', 'show'); consultaEDMC('energetico');"><span class="mr-4 fa-lg"><strong>E</strong></span>Energéticos</button>
                                <button class="button is-primary is-fullwidth mt-2" onclick="show_hide_modal('modalStatusMC', 'hide');show_hide_modal('modalDepartamentoMC', 'show'); consultaEDMC('departamento');"><span class="mr-4 fa-lg"><strong>D</strong></span>Departamento</button>
                                <button class="button is-info is-fullwidth mt-2" onclick="statusMC('trabajare');"><span class="mr-4 fa-lg"><strong>T</strong></span>Trabajando</button>
                                <button class="button is-success is-fullwidth mt-2" onclick="statusMC('solucionado');"><i class="fad fa-check-double mr-4 fa-lg"></i>Solucionar</button>
                            </div>
                        </div>
                        <div class="columns my-0">
                            <div class="column has-text-centered my-0">
                                <div class="has-text-centered">
                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center" onclick="btnEditarMC();">
                                        <i class="far fa-edit"></i>
                                        <span> Editar</span>
                                    </button>
                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold m-4 rounded inline-flex items-center" onclick="eliminarMC('');">
                                        <i class="far fa-trash-alt"></i>
                                        <span> Eliminar</span>
                                    </button>
                                </div>
                                <div id="btnInputMC" class="has-text-centered hidden">
                                    <input id="editarTituloMC" class="bg-white focus:outline-none focus:shadow-outline border border-gray-300 rounded-lg py-2 px-4 block w-full appearance-none leading-normal" type="text" placeholder="Nuevo Titulo">
                                    <button class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded inline-flex items-center" onclick="editarMC('');">
                                        <i class="far fa-save"></i>
                                        <span> Guardar</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL TIPO PROYECTO xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modal-Tipo" class="modal">
        <input type="hidden" id="idProyectoTipo">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column"><br>
                                <div class="control">
                                    <div class="select is-fullwidth">
                                        <select id="dataTipo">
                                            <option value="CAPEX">CAPEX</option>
                                            <option value="CAPIN">CAPIN</option>
                                            <option value="PROYECTO">PROYECTO</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="button is-info is-fullwidth mt-2" onclick="actualizarTipoProyecto();"><i class="fad fa-save mr-4 fa-lg"></i>Guardar</button><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL TIPO PROYECTO xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--MODAL Subir Archivos -->
    <div id="modalSubirArchivo" class="modal">
        <input type="hidden" id="idProyecto"></input>
        <input type="hidden" id="idUsuarioProyecto"></input>
        <div class="modal-background"></div>
        <div class="modal-card modal-md">
            <section class="modal-card-body">
                <div class="columns">
                    <div class="column is-4 has-text-centered">
                        <div class="principal">
                            <h1 class="title is-4 has-text-centered">Subir Archivo</h1>
                            <form id="form_subir">
                                <div class="form-1-2">
                                    <div class="field">
                                        <div class="file is-info has-name fileName">
                                            <label class="file-label">
                                                <input class="file-input" type="file" name="archivo" required>
                                                <span class="file-cta">
                                                    <span class="file-icon">
                                                        <i class="fas fa-upload"></i>
                                                    </span>
                                                </span>
                                                <span class="file-name"> Nombre Archivo </span>
                                            </label>
                                            <button class="btn button is-primary" type="submit" onclick="subirArchivo();"><span class="fas fa-save fa-lg">
                                                </span></button>
                                            <!-- <span class="fas fa-save"> </span><input class="btn button is-primary" value="Subir" onclick="subirArchivo();"> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="progress is-primary barra">
                                    <div class="barra_azul" id="barra_estado">
                                        <span></span>
                                    </div>
                                </div>


                                <div class="acciones has-text-centered">
                                    <input type="button" class="cancel " id="cancelar" value="cancelar" hidden>
                                </div>
                                <input type="hidden" id="tablaArchivo" name="tablaArchivo">
                                <input type="hidden" id="idGeneral" name="idGeneral">
                            </form>

                        </div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div id="archivos">
                            Sin Adjuntos
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
    <!-- Fin Modal Archivos -->


    <!--MODAL RESPONSABLE DE PROYECTO-->
    <div id="modaResponsableProyecto" class="modal">
        <input type="hidden" id="responsableProyecto">
        <br>
        <br>
        <br>
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

                                echo "<h6 class=\"title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario\" onclick=\"asignarResponsableProyecto($idUsuario)\"><span><i class=\"fas fa-user\"></i></span> $nombreT $apellidoT</h6>";
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
                            <button class="button is-danger" onclick="cerrarModalResponsableProyecto();">Cerrar</button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!--<button class="modal-close is-large" aria-label="close" onclick="closeModal('modalAgregarResponsableProyecto');"></button>-->
    </div>


    <!--MODAL RESPONSABLE DE PROYECTO-->
    <div id="modaResponsableTareasP" class="modal">
        <br>
        <br>
        <br>
        <div class="modal-background"></div>
        <div class="modal-card">
            <!-- <header class="modal-card-head">
                <input class="input is-primary" type="text" placeholder="Buscar..." onkeyup="buscarUsuarioProy(this, <?php echo $idDestinoT; ?>);">
            </header> -->
            <!-- Any other Bulma elements you want -->
            <section class="modal-card-body">
                <div class="columns">
                    <div id="dataResposansableTareaP" class="column">
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <div class="container">
                    <div class="columns">
                        <div class="column has-text-right">
                            <button class="button is-danger" onclick="closeModal();">Cerrar</button>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!--MODAL COMENTARIOS -->
    <div id="modalComentario" class="modal">
        <input type="hidden" id="idProyecto"></input>
        <input type="hidden" id="idUsuarioProyecto"></input>
        <div class="modal-background"></div>
        <div class="modal-card modal-md">
            <section class="modal-card-body">
                <div class="columns">
                    <div id="divHeaderComentarios" class="column">
                        <button class="delete" aria-label="close"></button>
                    </div>
                </div>
                <div class="columns">
                    <div id="colComentariosEquipo" class="column">
                        <div class="timeline is-left">
                            <h4 class="subtitle is-4 has-text-centered">Comentarios</h4>
                            <div class="columns is-centered">
                                <div class="field has-addons">
                                    <div class="control">
                                        <input id="textComentarioProyecto" class="input" type="text" placeholder="Agregar Comentarios...">
                                    </div>
                                    <div class="control" onclick="agregarComentarioProyectos()">
                                        <a class="button is-info">Agregar</a>
                                    </div>
                                </div>
                            </div>

                            <div id="comentarioProyecto"></div>

                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>


    <!-- *********************** PLAN DE ACCIÓN ******************************************************** -->
    <div id="modalPlanAccion" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-md modal-md-91">
            <section class="modal-card-body">
                <div class="columns">
                    <div class="column is-4">
                        <h4 class="subtitle is-4 has-text-centered">Plan de acción</h4>
                        <input id="inputPlanAccion" class="input is-rounded" type="text" placeholder="Agregar Plan Acción"><br><br>

                        <div class="timeline is-left">

                            <div id="planAccion"></div>

                            <div class="timeline-item">
                                <div class="timeline-marker is-icon">
                                    <i class="fad fa-genderless"></i>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="column is-0"></div>

                    <div class="column is-5">
                        <h4 class="subtitle is-4 has-text-centered">Comentarios</h4>
                        <input id="inputComentarioPlanAccion" class="input is-rounded is-fullwidth is-4" type="text" placeholder="Añadir comentario"><br>

                        <div id="comentarioPlanAccion"></div>
                    </div>

                    <div class="column">
                        <h4 class="subtitle is-4 has-text-centered">Adjuntos</h4>
                        <input id="inputAdjuntoPlanAccion" class="file is-fullwidth" type="file" placeholder="Añadir Adjunto"><br>

                        <img src="svg/formatos/avi.svg" alt="" width="80px">

                    </div>
            </section>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>

    <!-- *********************** PLAN DE ACCIÓN ******************************************************** -->


    <!--AREA DE MENSAJES-->
    <article id="article-mapas" class="message is-primary popup" style="display: none;">
        <div class="message-header">
            <p>Mapareregregrgrer</p>
            <button class="delete" aria-label="delete" onclick="cerrarMapa();"></button>
        </div>
        <div id="message-body" class="message-body">

        </div>
    </article>


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS  DEPARTAMENTOS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modalDepartamento" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column">
                                <h3 class="title is-3 has-text-centered has-text-primary">Departamentos</h3>
                            </div>
                        </div>
                        <div class=" columns">
                            <div class="column buttons">
                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered" onclick="aplicarStatus('departamento_calidad')">Calidad</button>

                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatus('departamento_compras')">Compras</button>

                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatus('departamento_direccion')">Dirección</button>

                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatus('departamento_finanzas')">Finanzas</button>

                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatus('departamento_rrhh')">RRHH</button>
                            </div>
                        </div>
                        <div class="columns columns is-centered p-2">
                            Departamentos Selecionados
                        </div>
                        <div id="dataStatusDepartamento" class="columns p-2 flex-wrap"></div>
                    </div>
                </div>
            </div>

        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS  DEPARTAMENTOS MC xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modalDepartamentoMC" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column">
                                <h3 class="title is-3 has-text-centered has-text-primary">Departamentos</h3>
                            </div>
                        </div>
                        <div class="has-text-centered title is-5 mb-2">
                            Opción
                        </div>
                        <div class=" columns">
                            <div class="column buttons">
                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered" onclick="aplicarStatusMC('departamento_calidad')">Calidad</button>

                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatusMC('departamento_compras')">Compras</button>

                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatusMC('departamento_direccion')">Dirección</button>

                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatusMC('departamento_finanzas')">Finanzas</button>

                                <button class="button is-primary is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatusMC('departamento_rrhh')">RRHH</button>
                            </div>
                        </div>
                        <div class="has-text-centered title is-5 mb-2">
                            Seleccionado
                        </div>
                        <div id="consultaDepartamentoMC" class="column"></div>
                    </div>
                </div>
            </div>

        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS  ENERGETICOS MC xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modalEnergeticoMC" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column">
                                <h3 class="title is-3 has-text-centered has-text-warning">Energéticos</h3>
                            </div>
                        </div>
                        <div class="has-text-centered title is-5 mb-2">
                            Opción
                        </div>
                        <div class=" columns">
                            <div class="column buttons">
                                <button class="button is-warning is-rounded is-medium is-fullwidth has-text-centered" onclick="aplicarStatusMC('energetico_electricidad');">Electricidad</button>

                                <button class="button is-warning is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatusMC('energetico_agua');">Agua</button>

                                <button class="button is-warning is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatusMC('energetico_diesel');">Diésel</button>

                                <button class="button is-warning is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatusMC('energetico_gas');">Gas</button>
                            </div>
                        </div>
                        <div class="has-text-centered title is-5 mb-2">
                            Seleccionado
                        </div>
                        <div id="consultaEnergeticoMC" class="column"></div>
                    </div>
                </div>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS  ENERGETICOS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->
    <div id="modalEnergetico" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content is-tiny has-background-white rounded">
            <!-- Any other Bulma elements you want -->
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <div class="columns">
                            <div class="column">
                                <h3 class="title is-3 has-text-centered has-text-warning">Energéticos</h3>
                            </div>
                        </div>
                        <div class=" columns">
                            <div class="column buttons">

                                <button class="button is-warning is-rounded is-medium is-fullwidth has-text-centered" onclick="aplicarStatus('energetico_electricidad')">Electricidad</button>

                                <button class="button is-warning is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatus('energetico_agua')">Agua</button>

                                <button class="button is-warning is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatus('energetico_diesel')">Diésel</button>

                                <button class="button is-warning is-rounded is-medium is-fullwidth has-text-centered my-2" onclick="aplicarStatus('energetico_gas')">Gas</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
    <!--xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx MODAL STATUS xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx -->


    <!-- Modal Justificacion -->
    <div id="modal-justificacion" style="display:none">
        <p id="justificacion-proyecto">dfs</p>
        <button class="modal-close is-large" aria-label="close" onclick="cerrarComentario();"></button>
    </div>


    <a id="btnAncla" href="#nav-menu" class="button is-primary is-rounded ancla" style="display:none;"><i class="fa fa-arrow-up"></i></a>


</body>

<?php echo $layout->scripts(); ?>

<script src="js/plannerJS.js"></script>
<script src="js/usuariosJS.js?v4.0.3"></script>
<script src="js/paginator.min.js"></script>
<!--DataTables-->
<script src="DataTables/datatables.js"></script>
<script type="text/javascript" src="js/modal-fx.min.js"></script>
<script src="js/sweetalert2@9.js"></script>

<!-- Librerias JS requeridas para la version Beta. -->
<!-- Libreria para notificaciones prediseñadas sweetAlert -->
<script src="js/alertasSweet.js"></script>
<script src="js/plannerBeta.js"></script>
<script src="js/refreshSession.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="js/seguridad_session.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal-dark"
        });

        $('#dismiss, .overlay').on('click', function() {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
    });
</script>
<script>
    $(document).ready(function() {
        var alturaFilas = screen.height - 400;
        var dFilas = document.getElementById("dFilas");
        //dFilas.setAttribute("style", "min-height: " + alturaFilas + "px;");
        var pageloader = document.getElementById("loader");
        if (pageloader) {

            var pageloaderTimeout = setTimeout(function() {
                pageloader.classList.toggle('is-active');
                clearTimeout(pageloaderTimeout);
            }, 3000);
        }

        $(window).scroll(function() {
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
<script>
    $(function() {
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
        onSelect: function onSelect(fd, date) {
            var idEquipo = $("#hddIdEquipo").val();
            var idDestino = $("#hddIdDestino").val();
            var idSubseccion = $("#hddIdSubseccion").val();
            var idCategoria = $("#hddIdCategoria").val();
            var idSubcategoria = $("#hddIdSubcategoria").val();
            var idRelSubcategoria = 0;
            if (date.length == 2) {
                var idTarea = $("#hddIDTarea").val();
                actualizarRangoFechas(idTarea, fd);
                //closeModal('modal-mc-fecha');
                if (idEquipo != 0) {
                    obtCorrectivos(idEquipo, 'N');
                } else {
                    obtCorrectivosG(idSubseccion, idDestino, idCategoria, idSubcategoria, idRelSubcategoria,
                        'N');
                }
            }
        }
    });
</script>

<script>
    // Obtener Día
    var fecha = new Date();

    switch (fecha.getDay()) {
        case 1:
            $('.hide-seccion-is-3').hide();
            $('.id-12, .id-23, .id-8').show();
            $('.btn-id-12, .btn-id-23, .btn-id-8').addClass('is-success');
            $(".btn-8, .btn-3, .btn-9").addClass("bannersec")
            break;
        case 2:
            $('.hide-seccion-is-3').hide();
            $('.id-9, .id-23').show();
            $('.id-9, .btn-id-23').addClass('is-success');
            $(".btn-10, .btn-3").addClass("bannersec")
            break;
        case 3:
            $('.hide-seccion-is-3').hide();
            $('.id-1, .id-23, .id-10').show();
            $('.btn-id-1, .btn-id-23, .btn-id-10').addClass('is-success');
            $(".btn-2, .btn-3, .btn-11").addClass("bannersec")
            break;
        case 4:
            $('.hide-seccion-is-3').hide();
            $('.id-5, .id-23, .id-6').show();
            $('.btn-id-5, .btn-id-23, .btn-id-6').addClass('is-success');
            $(".btn-5, .btn-3, .btn-6").addClass("bannersec")
            break;
        case 5:
            $('.hide-seccion-is-3').hide();
            $('.id-24, .id-23, .id-11').show();
            $('.btn-id-24, .btn-id-23, .btn-id-11').addClass('is-success');
            $('.btn-1, .btn-3, .btn-12').addClass("bannersec");
            break;
        default:
            $('.btn-seccion').addClass("bannersec");
    }

    $(".btn-1").click(function() {
        $(".id-24").toggle("hide");
        $(".btn-1").toggleClass("bannersec");
    });

    $(".btn-2").click(function() {
        $(".id-1").toggle("hide");
        $(".btn-2").toggleClass("bannersec");
    });

    $(".btn-3").click(function() {
        $(".id-23").toggle("hide");
        $(".btn-3").toggleClass("bannersec");
    });

    $(".btn-4").click(function() {
        $(".id-19").toggle("hide");
        $(".btn-4").toggleClass("bannersec");
    });

    $(".btn-5").click(function() {
        $(".id-5").toggle("hide");
        $(".btn-5").toggleClass("bannersec");
    });

    $(".btn-6").click(function() {
        $(".id-6").toggle("hide");
        $(".btn-6").toggleClass("bannersec");
    });

    $(".btn-7").click(function() {
        $(".id-7").toggle("hide");
        $(".btn-7").toggleClass("bannersec");
    });

    $(".btn-8").click(function() {
        $(".id-12").toggle("hide");
        $(".btn-8").toggleClass("bannersec");
    });

    $(".btn-9").click(function() {
        $(".id-8").toggle("hide");
        $(".btn-9").toggleClass("bannersec");
    });

    $(".btn-10").click(function() {
        $(".id-9").toggle("hide");
        $(".btn-10").toggleClass("bannersec");
    });

    $(".btn-11").click(function() {
        $(".id-10").toggle("hide");
        $(".btn-11").toggleClass("bannersec");
    });

    $(".btn-12").click(function() {
        $(".id-11").toggle("hide");
        $(".btn-12").toggleClass("bannersec");
    });


    $(".btn-subsecciones").click(function() {
        $("#seccion-bar").css('display', 'none');
    });

    // $(".btn-proyectos").click(function() {
    //     $("#seccion-bar").css('display', 'none');
    //     $("#seccionColumnas").css('display', 'none');
    //     $("#modal-proyectos").css('display', 'block');
    // });

    $(".btn-regresar-subsecciones").click(function() {
        $("#sectionHeroListaEquipos").css('display', 'none');
        $("#seccionListaEquipos").css('display', 'none');
        $("#seccion-bar").css('display', 'block');
    });

    function modalproyectos() {
        $("#modal-proyectos").css("display", "none");
        $("#seccionColumnas").css('display', 'block');
    }

    function showsubsecciones() {
        $("#sectionHeroListaEquipos").css('display', 'none');
        $("#seccionListaEquipos").css('display', 'none');
        $("#modal-proyectos").css('display', 'none');
        $("#seccion-bar").css('display', 'block');
        $("#seccionColumnas").css('display', 'block');
    }

    function crearProyecto(idDestino) {
        $("#idDestino-p").val(idDestino);
        alert(idDestino);
    }

    function showcomentarioproyecto(comentario) {
        $("#comentario-proyecto").val(comentario);
        $("#modal-justificacion").css("display", "block");
    }

    function cerrarComentario() {
        $("#modal-justificacion").css("display", "none");
    }
</script>


<script>
    const fileInput = document.querySelector('.fileName input[type=file]');
    fileInput.onchange = () => {
        if (fileInput.files.length > 0) {
            const fileName = document.querySelector('.fileName .file-name');
            fileName.textContent = fileInput.files[0].name;
        }
    }

    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        $("#opcionMovil").removeClass('hidden');
        $("#seccion-bar").removeClass('mt-5');
        // $(".hide-seccion-is-3").addClass('hide');

        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: 'success',
            title: 'Versión Móvil'
        })
    } else {
        $("#opcionMovil").addClass('hidden');
        $("#seccion-bar").addClass('mt-5');
    }

    function mostrarSeccion(idSeccion) {
        // let idSeccion = $("#mostrarSeccionMovil").val();
        $("." + idSeccion).toggle('hide');
        $(".btn-" + idSeccion).toggleClass('is-success');
    }
</script>

</html>