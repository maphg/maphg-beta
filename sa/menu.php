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
                $accesoSA = "";
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
//if ($idDestino == 10) {
//    if (isset($_SESSION['idDestino'])) {
//        $idDestinoT = $_SESSION['idDestino'];
//    } else {
//        $idDestinoT = $idDestino;
//    }
//} else {
//    $idDestinoT = $idDestino;
//}
//
//$query = "SELECT * FROM c_destinos WHERE id = $idDestinoT";
//try {
//    $resp = $conn->obtDatos($query);
//    if ($conn->filasConsultadas > 0) {
//        foreach ($resp as $dts) {
//            $bandera = $dts['bandera'];
//            $destino = $dts['destino'];
//            $gp = $dts['gp'];
//            $trs = $dts['trs'];
//        }
//    }
//} catch (Exception $ex) {
//    echo $ex;
//}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MAPHG</title>
    <link rel="icon" href="svg/logo6.png">
    <link rel="stylesheet" href="css/bulma.css">
    <link rel="stylesheet" href="../css/tailwind.css">
    <link rel="stylesheet" href="css/clases.css">
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

    <?php
    if (!isset($_SESSION['usuario'])) {
    } else {
    ?>
    <div class="columns mt-5 mx-5">
        <div class="column">
            <a href="index.php" class="button is-primary">Lista de Bodegas</a>
        </div>
    </div>
    <?php
    }
    ?>

    <section class="hero">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column has-text-centered">
                        <img src="svg/logon.svg" width="190px" alt="">
                    </div>
                </div>
                <div class="columns is-centered">
                    <?php
                    if (!isset($_SESSION['usuario'])) {
                    } else {
                    ?>
                    <div class="column is-5-tablet is-4-desktop is-3-widescreen has-text-centered">
                        <a class="button is-large is-primary is-fullwidth"
                            href="acceso_entradas.php?idSubalmacen=<?php echo $idSubalmacen; ?>"><span
                                class="icon is-medium"><i
                                    class="fas fa-sign-in-alt"></i></span><span>ENTRADAS</span></a>
                    </div>
                    <?php
                    }
                    ?>

                    <div class="column is-5-tablet is-4-desktop is-3-widescreen has-text-centered">
                        <a class="button is-large is-warning is-fullwidth"
                            href="acceso_salidas.php?idSubalmacen=<?php echo $idSubalmacen; ?>"><span
                                class="icon is-medium"><i
                                    class="fas fa-sign-out-alt"></i></span><span>SALIDAS</span></a>
                    </div>

                    <div class="column is-5-tablet is-4-desktop is-3-widescreen has-text-centered">
                        <a class="button is-large is-info is-fullwidth"
                            href="existencias.php?idSubalmacen=<?php echo $idSubalmacen; ?>"><span
                                class="icon is-medium"><i class="fas fa-eye"></i></span><span>EXISTENCIAS</span></a>
                    </div>


                </div>
            </div>
        </div>
    </section>


</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="js/bulmajs.js"></script>

</html>