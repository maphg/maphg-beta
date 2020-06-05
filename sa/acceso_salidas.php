<?php
session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');
include 'libs/subalmacenesItemsPD.php';
$idSubalmacen = $_GET['idSubalmacen'];
$conn = new Conexion();
$conn->conectar();
if (!isset($_SESSION['usuario'])) {
    //header('Location: ../login.php');
    $codigoSA = "";
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

                if ($idPermiso == 2) {
                    header('Location: forbidden.php');
                }

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

                $query = "SELECT * FROM c_acciones_usuarios WHERE id_usuario = $idUsuario";
                try {
                    $resp = $conn->obtDatos($query);
                    if ($conn->filasConsultadas > 0) {
                        foreach ($resp as $dts) {
                            $accesoSA = $dts['acceso_sa'];
                        }
                    }
                } catch (Exception $ex) {
                    echo $ex;
                }

                if ($accesoSA != "") {
                    $subalmacenes = explode(",", $accesoSA);
                } else {
                    $subalmacenes = [];
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
                            $codigoSA = $dts['codigo_sa'];
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


$query = "SELECT * FROM t_subalmacenes WHERE id = $idSubalmacen";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $idDestinoSA = $dts['id_destino'];
            $faseSA = $dts['fase'];
        }
    }
} catch (Exception $ex) {
    echo $ex;
}
if($faseSA == "ZI" && !isset($_SESSION['usuario'])){
    header('Location: ../login.php');
}
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>MAPHG</title>
        <link rel="icon" href="svg/logo6.png">
        <link rel="stylesheet" href="css/bulma.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <style>
            .container-scroll {
                overflow-x: scroll;
                overflow-y: hidden;
                white-space: nowrap;
            }
        </style>
    </head>
    <body>
        <section class="hero is-fullheight">
            <div class="hero-body">
                <div class="container">
                    <div class="columns is-centered">
                        <div class="column has-text-centered">
                            <img src="svg/logon.svg" width="190px" alt="">
                        </div>
                    </div>
                    <div class="columns is-centered">
                        <div class="column is-5-tablet is-4-desktop is-3-widescreen">
                            <form action="" class="">
                                <div class="field">
                                    <label for="" class="label">Código de acceso</label>
                                    <div class="control has-icons-left">
                                        <input id="txtCodigoAcceso" type="number" 
                                               placeholder="codigo de acceso" 
                                               class="input is-large" 
                                               <?php
                                               if ($codigoSA != "") {
                                                   ?>
                                                   value="<?php echo $codigoSA; ?>"
                                                   <?php
                                               }
                                               ?>
                                               required>
                                        <span class="icon is-small is-left">
                                            <i class="fas fa-key"></i>
                                        </span>
                                    </div>
                                </div>
                                <?php
                                if ($faseSA == "ZI") {
                                    ?>
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbTipo" onchange="seleccionarTipo();">
                                                    <option value="0">Tipo</option>
                                                    <option value="mc">MC</option>
                                                    <option value="mp">MP</option>
                                                    <option value="otro">OTROS</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="divSecciones" class="field" style="display:none;">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbSecciones" onchange="cargarSubsecciones();">
                                                    <option value="0">Seccion</option>
                                                    <?php
                                                    $query = "SELECT * FROM c_secciones WHERE tareas = 'SI' ORDER BY seccion";
                                                    try {
                                                        $resp = $conn->obtDatos($query);
                                                        if ($conn->filasConsultadas > 0) {
                                                            foreach ($resp as $dts) {
                                                                $idSec = $dts['id'];
                                                                $nombreSeccion = $dts['seccion'];
                                                                echo "<option value=\"$idSec\">$nombreSeccion</option>";
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
                                    <div id="divSubsecciones" class="field" style="display:none;">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbSubsecciones" onchange="cargarEquipos(<?php echo $idDestinoSA; ?>);">
                                                    <option value="0">Subseccion</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="divEquipos" class="field" style="display:none;">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbEquipos" onchange="cargarMotivos()">
                                                    <option value="0">Equipo</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="divMotivo" class="field" style="display:none;">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbMotivo">
                                                    <option value="0">Motivo</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="divOtros" class="field" style="display:none;">
                                        <label for="" class="label">Otro</label>
                                        <div class="control has-icons-left">
                                            <textarea id="txtOtro" type="text" placeholder="Otro" class="input is-large" required></textarea>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="field">
                                        <label for="" class="label">Número GIFT</label>
                                        <div class="control has-icons-left">
                                            <input id="txtCodigoGift" type="number" placeholder="GIFT" class="input is-large" required>
                                            <span class="icon is-small is-left">
                                                <i class="fab fa-slack-hash"></i>
                                            </span>
                                        </div>
                                    </div>                         
                                    <?php
                                }
                                ?>

                                <div class="field">
                                    <button type="button" class="button is-fullwidth" onclick="validarAcceso(<?php echo $idSubalmacen; ?>, '','<?php echo $faseSA; ?>');">
                                        Acceder
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/bulmajs.js"></script>
    <script src="js/acceso.js"></script>

</html>
