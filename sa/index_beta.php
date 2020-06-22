<?php
session_start();
include 'libs/conexion.php';
$nombreUsuario = "No Identificado.";
$avatar = "??";
$cargo = " - - ";

$conn = new Conexion();
$conn->conectar();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
} else {
    //Variables Generales.

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/tailwind.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
    <title>MAPHG</title>
</head>
<style>
* {
    border: solid, red 1px;
}
</style>

<body class="bg-gray-300" style="font-family: 'Manrope', sans-serif;">
    <!-- Inputs ocultos para almacenar datos temporales. -->
    <input type="hidden" id="inputFaseSubalmacen">

    <!-- Archivos para el Sidebar y Menu -->
    <?php
    include 'navbartop.php';
    include 'menu-sidebar.php';
    ?>
    <!-- Archivos para el Sidebar y Menu -->



    <div class="flex mb-4">
        <div class="w-full h-12">
            <p class="text-4xl text-center">Subalmacén</p>
        </div>
    </div>

    <div class="flex mb-4 p-6">
        <div class="w-1/3 bg-gray-200 h-12">
            <p class="text-3xl text-center">GP
                <span class="hover:text-green-800 text-2xl text-center text-green-600"
                    onclick="toggleModal('modalAgregarSubalmacen'); agregarSubalmacenFase('GP');"><i
                        class="fad fa-plus-circle"></i></span>
            </p>

            <div id="subalmacenGP" class="text-left p-5"></div>

        </div>

        <div class="w-1/3 bg-gray-400 h-12">
            <p class="text-3xl text-center">TRS
                <span class="hover:text-green-800 text-2xl text-center text-green-600"
                    onclick="toggleModal('modalAgregarSubalmacen'); agregarSubalmacenFase('TRS');">
                    <i class="fad fa-plus-circle"></i>
                </span>
            </p>

            <div id="subalmacenTRS" class="text-left p-5"></div>
        </div>

        <div class="w-1/3 bg-gray-200 h-12 content-center text-center items-center">
            <p class="text-3xl text-center">ZI
                <span class="hover:text-green-800 text-2xl text-center text-green-600"
                    onclick="toggleModal('modalAgregarSubalmacen'); agregarSubalmacenFase('ZI');">
                    <i class="fad fa-plus-circle"></i>
                </span>
            </p>
            <div id="subalmacenZI" class="text-left p-5"></div>
        </div>
    </div>


    <!--Modal para Agregar Subalmacén-->
    <div id="modalAgregarSubalmacen"
        class="hidden modal fixed w-full h-full top-0 left-0 flex items-center justify-center">

        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
            onclick="toggleModal('modalAgregarSubalmacen');"></div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

            <div class="modal-content py-4 px-6">
                <!--Title-->
                <div class="flex justify-between items-center pb-3">
                    <p class="text-2xl font-bold text-center w-full">Agregar Subalmacén
                        <span id="faseSubalmacen"></span>
                    </p>
                    <p class="text-right text-2xl m-0 p-0" onclick="toggleModal('modalAgregarSubalmacen');">
                        <i class="far fa-times-circle"></i>
                    </p>

                </div>

                <!--Body-->
                <div class="w-full md:w-2/2 px-3 py-5">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-last-name">
                        Nuevo Subalmacén
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="inputTituloSubalmacen" type="text" placeholder="Título Subalmacén"
                        onkeyup="if(event.keyCode == 13) agregarSubalmacen();" autocomplet="off">

                </div>

                <!--Footer-->
                <div class="flex justify-center pt-2 text-center">
                    <button class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400"
                        onclick="agregarSubalmacen();">
                        Agregar <i class="far fa-plus-circle"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script src="js/jquery-3.3.1.js"></script>
    <script src="../js/sweetalert2@9.js"></script>
    <script src="../js/alertasSweet.js"></script>
    <script src="js/subalmacenJS.js"></script>
</body>

</html>