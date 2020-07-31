<?php
session_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_MONETARY, 'en_US');
include 'php/conexion.php';
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
<html>

<head>
    <meta charset="UTF-8">
    <title>MAPHG</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/bulma.min.css">
    <link rel="icon" href="svg/logo6.png">



    <style>
        .shadow-navbar {
            -webkit-box-shadow: 0px 4px 22px -22px rgba(0, 0, 0, 0.98);
            -moz-box-shadow: 0px 4px 22px -22px rgba(0, 0, 0, 0.98);
            box-shadow: 0px 4px 22px -22px rgba(0, 0, 0, 0.98);
        }

        .my-iframe {
            height: 700px !important;
        }

        .my-iframe-all {
            height: 300px !important;
        }
    </style>
</head>

<body>

    <?php include 'navbartop.php' ?>
    <?php include 'menu-sidebar.php' ?>
    <br>
    <div class="wrapper">
        <div id="content" class="container">
            <!--MENU-->
            <section class="mt-2">
                <div class="columns">
                    <div class="column">
                        <?php
                        switch ($destinoT):
                            case 'AME':
                        ?>
                                <!-- CAP -->
                                <div class="columns is-multiline">
                                    <div class="column is-4">
                                        <iframe class="my-iframe-all" width="90%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNTUxM2E4MjktZWUxZS00ZWRlLTg0NTAtZDZmNTZjNTIxYzFiIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>

                                    <!-- RM -->
                                    <div class="column is-4">
                                        <iframe class="my-iframe-all" width="90%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMGIxMjI3ZTQtZDQ4ZS00NjUwLTkyMWQtZWE4YWUzNzNlOGE4IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>

                                    <!-- CMU -->
                                    <div class="column is-4">
                                        <iframe class="my-iframe-all" width="90%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiYTc5ODQzMDktNjZiNS00ZDJkLTllNDctOWU0ODU1YmNkZWI0IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>

                                    <!-- PVR -->
                                    <div class="column is-4">
                                        <iframe class="my-iframe-all" width="90%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiYjhkMWY3ZjItYzBmNS00M2UyLTg3ZWYtZWEwZDU5MTRlNTYyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>

                                    <!-- MBJ -->
                                    <div class="column is-4">
                                        <iframe class="my-iframe-all" width="90%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMWNiMDM0NGUtYWQyNy00NmQ0LTgyN2ItNzE2NjBmY2FkZDBlIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>

                                    <!-- PUJ -->
                                    <div class="column is-4">
                                        <iframe class="my-iframe-all" width="90%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNjg0NTY2MjMtMWUwNy00MTYwLWE4NDctMmU0MTUxMjU2NzI3IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>

                                    <!-- SSA -->
                                    <div class="column is-4">
                                        <iframe class="my-iframe-all" width="90%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMDZhMjA1YjYtYmQ2Ny00OTFkLWIwOTAtNTc3MTA4Yjk4ZGIwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>

                                    <!-- SDQ -->
                                    <div class="column is-4">
                                        <iframe class="my-iframe-all" width="90%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiYzQ5MmQ1NTAtOTkwYS00OTNhLThlOGItNmQ4NTcwODE2NzcwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                                    </div>
                                </div>
                            <?php
                                break;
                            case 'CAP':
                            ?>
                                <iframe class="my-iframe" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNTUxM2E4MjktZWUxZS00ZWRlLTg0NTAtZDZmNTZjNTIxYzFiIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                            <?php
                                break;
                            case 'RM':
                            ?>
                                <iframe class="my-iframe" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMGIxMjI3ZTQtZDQ4ZS00NjUwLTkyMWQtZWE4YWUzNzNlOGE4IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                            <?php
                                break;
                            case 'CMU':
                            ?>
                                <iframe class="my-iframe" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiYTc5ODQzMDktNjZiNS00ZDJkLTllNDctOWU0ODU1YmNkZWI0IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                            <?php
                                break;
                            case 'PVR':
                            ?>
                                <iframe class="my-iframe" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiYjhkMWY3ZjItYzBmNS00M2UyLTg3ZWYtZWEwZDU5MTRlNTYyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                            <?php
                                break;
                            case 'MBJ':
                            ?>
                                <iframe class="my-iframe" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMWNiMDM0NGUtYWQyNy00NmQ0LTgyN2ItNzE2NjBmY2FkZDBlIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                            <?php
                                break;
                            case 'PUJ':
                            ?>
                                <iframe class="my-iframe" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiNjg0NTY2MjMtMWUwNy00MTYwLWE4NDctMmU0MTUxMjU2NzI3IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                            <?php
                                break;
                            case 'SSA':
                            ?>
                                <iframe class="my-iframe" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiMDZhMjA1YjYtYmQ2Ny00OTFkLWIwOTAtNTc3MTA4Yjk4ZGIwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                            <?php
                                break;
                            case 'SDQ':
                            ?>
                                <iframe class="my-iframe" width="100%" height="700" src="https://app.powerbi.com/view?r=eyJrIjoiYzQ5MmQ1NTAtOTkwYS00OTNhLThlOGItNmQ4NTcwODE2NzcwIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
                        <?php
                                break;
                        endswitch;
                        ?>
                    </div>
                </div>
            </section>
            <section class="my-4">

                <div id="divServicios" class="row mt-4">
                    <div class="col-12">
                        <div class="row mt-4">
                            <div class="col">
                                <div class="table-responsive">
                                    <table id="tablaGastosServicios" class="table table-bordered table-striped compact table-sm" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">idDocumento</th>
                                                <th class="fs-12">Destino</th>
                                                <th class="fs-12">CECO</th>
                                                <th class="fs-12">Documento</th>
                                                <th class="fs-12">Fecha Cont.</th>
                                                <th class="fs-12">Importe (USD)</th>
                                                <th class="fs-12">Asignacion</th>
                                                <th class="fs-12">Descripcion</th>
                                                <th class="fs-12">Proveedor</th>
                                                <th class="fs-12">Nombre</th>

                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th style="display:none;">idDocumento</th>
                                                <th class="fs-12">Destino</th>
                                                <th class="fs-12">CECO</th>
                                                <th class="fs-12">Documento</th>
                                                <th class="fs-12">Fecha Cont.</th>
                                                <th class="fs-12">Importe (USD)</th>
                                                <th class="fs-12">Asignacion</th>
                                                <th class="fs-12">Descripcion</th>
                                                <th class="fs-12">Proveedor</th>
                                                <th class="fs-12">Nombre</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="tableBodyServicios" class="fs-11">
                                            <?php
                                            //$query = "SELECT * FROM t_gastos_servicios WHERE division = '$division'";
                                            $query = "CALL obtenerServicios(917)";
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($resp as $dts) {

                                                        $idDocumento = $dts['ID'];
                                                        $numDocumento = $dts['NUMDOC'];
                                                        $fechaConta = $dts['FECHACONT'];
                                                        $fechaDocumento = $dts['FECHADOC'];
                                                        $importe = $dts['IMPORTEML3'];
                                                        $ceco = $dts['CECO'];
                                                        $asignacion = $dts['ASIG'];
                                                        $descripcion = $dts['TEXTO'];
                                                        $proveedor = $dts['PROVEEDOR'];
                                                        $nombreDocumento = $dts['NOMBRE1'];
                                                        $destinoCECO = $dts['DESTINOCECO'];
                                                        $nombreCECO = $dts['NOMBRECECO'];

                                                        if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                                        } else {
                                                            if ($importe == "") {
                                                                $importe = 0;
                                                            }
                                                            $year = date('Y');
                                                            $fechaDocumento = strtotime($fechaConta);
                                                            $fecha = date("F", $fechaDocumento);
                                                            $añoDoc = date("Y", $fechaDocumento);
                                                            if ($añoDoc == $year) {
                                                                if ($idDestino == 10) {
                                                                    echo "<tr>"
                                                                        . "<td style=\"display: none;\">$idDocumento</td>"
                                                                        . "<td>$destinoCECO</td>"
                                                                        . "<td class=\"fs-9\">$nombreCECO</td>"
                                                                        . "<td>$numDocumento</td>"
                                                                        . "<td>$fechaConta</td>"
                                                                        . "<td> $importe</td>"
                                                                        . "<td>$asignacion</td>"
                                                                        . "<td>$descripcion</td>"
                                                                        . "<td>$proveedor</td>"
                                                                        . "<td>$nombreDocumento</td>"
                                                                        . "</tr>";
                                                                } else {
                                                                    if ($destino == $destinoCECO) {
                                                                        echo "<tr>"
                                                                            . "<td style=\"display: none;\">$idDocumento</td>"
                                                                            . "<td>$destinoCECO</td>"
                                                                            . "<td class=\"fs-9\">$nombreCECO</td>"
                                                                            . "<td>$numDocumento</td>"
                                                                            . "<td>$fechaConta</td>"
                                                                            . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                                            . "<td>$asignacion</td>"
                                                                            . "<td>$descripcion</td>"
                                                                            . "<td>$proveedor</td>"
                                                                            . "<td>$nombreDocumento</td>"
                                                                            . "</tr>";
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            } catch (Exception $ex) {
                                                echo $ex;
                                            }
                                            $conn->cerrar();
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="divMateriales" class="row mt-4" style="display:none;">
                    <div class="col-12">
                        <?php
                        if ($importarGastos == 1) :
                        ?>
                            <div class="row mt-4">
                                <div class="col-12 col-md-12 col-lg-12 text-center">
                                    <div class="upload-btn-wrapper">
                                        <button class="btn  bg-white text-negron fs-10">Adjuntar</button>
                                        <input id="txtFileMateriales" type="file" name="txtFileMateriales" onchange="importarArchivoGastos('materiales');">
                                    </div>

                                </div>

                            </div>
                        <?php
                        endif;
                        ?>

                        <div class="row mt-4">
                            <div class="col">
                                <div class="table-responsive">
                                    <table id="tablaGastosMateriales" class="table table-bordered table-striped compact table-sm" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="display:none;">idDocumento</th>
                                                <th class="fs-12">Destino</th>
                                                <th class="fs-12">CECO</th>
                                                <th class="fs-12">Documento</th>
                                                <th class="fs-12">Fecha Cont.</th>
                                                <th class="fs-12">Importe (USD)</th>
                                                <th class="fs-12">Asignacion</th>
                                                <th class="fs-12">Descripcion</th>
                                                <th class="fs-12">Proveedor</th>
                                                <th class="fs-12">Nombre</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th style="display:none;">idDocumento</th>
                                                <th class="fs-12">Destino</th>
                                                <th class="fs-12">CECO</th>
                                                <th class="fs-12">Documento</th>
                                                <th class="fs-12">Fecha Cont.</th>
                                                <th class="fs-12">Importe (USD)</th>
                                                <th class="fs-12">Asignacion</th>
                                                <th class="fs-12">Descripcion</th>
                                                <th class="fs-12">Proveedor</th>
                                                <th class="fs-12">Nombre</th>
                                            </tr>
                                        </tfoot>
                                        <tbody id="tableBodyMateriales" class="fs-11">
                                            <?php
                                            $conn->conectar();
                                            //$query = "SELECT * FROM t_gastos_materiales WHERE division = '$division'";
                                            $query = "CALL obtenerMateriales($division)";
                                            try {
                                                $resp = $conn->obtDatos($query);
                                                if ($conn->filasConsultadas > 0) {
                                                    foreach ($resp as $dts) {

                                                        $idDocumento = $dts['ID'];
                                                        $numDocumento = $dts['NUMDOC'];
                                                        $fechaConta = $dts['FECHACONT'];
                                                        $fechaDocumento = $dts['FECHADOC'];
                                                        $importe = $dts['IMPORTEML3'];
                                                        $ceco = $dts['CECO'];
                                                        $asignacion = $dts['ASIG'];
                                                        $descripcion = $dts['TEXTO'];
                                                        $proveedor = $dts['PROVEEDOR'];
                                                        $nombreDocumento = $dts['NOMBRE1'];
                                                        $destinoCECO = $dts['DESTINOCECO'];
                                                        $nombreCECO = $dts['NOMBRECECO'];

                                                        if (strpos($asignacion, 'OTRO CECO') !== false || strpos($asignacion, 'otro ceco') !== false || strpos($asignacion, 'CAPEX') !== false || strpos($asignacion, 'capex') !== false || strpos($asignacion, 'POBLADO') !== false || strpos($asignacion, 'poblado') !== false) {
                                                        } else {
                                                            if ($importe == "") {
                                                                $importe = 0;
                                                            }

                                                            $fechaDocumento = strtotime($fechaConta);
                                                            $fecha = date("F", $fechaDocumento);
                                                            $añoDoc = date("Y", $fechaDocumento);
                                                            if ($añoDoc == $year) {
                                                                if ($idDestino == 10) {
                                                                    echo "<tr>"
                                                                        . "<td style=\"display: none;\">$idDocumento</td>"
                                                                        . "<td>$destinoCECO</td>"
                                                                        . "<td class=\"fs-9\">$nombreCECO</td>"
                                                                        . "<td>$numDocumento</td>"
                                                                        . "<td>$fechaConta</td>"
                                                                        . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                                        . "<td>$asignacion</td>"
                                                                        . "<td>$descripcion</td>"
                                                                        . "<td>$proveedor</td>"
                                                                        . "<td>$nombreDocumento</td>"
                                                                        . "</tr>";
                                                                } else {
                                                                    if ($destino == $destinoCECO) {
                                                                        echo "<tr>"
                                                                            . "<td style=\"display: none;\">$idDocumento</td>"
                                                                            . "<td>$destinoCECO</td>"
                                                                            . "<td class=\"fs-9\">$nombreCECO</td>"
                                                                            . "<td>$numDocumento</td>"
                                                                            . "<td>$fechaConta</td>"
                                                                            . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                                            . "<td>$asignacion</td>"
                                                                            . "<td>$descripcion</td>"
                                                                            . "<td>$proveedor</td>"
                                                                            . "<td>$nombreDocumento</td>"
                                                                            . "</tr>";
                                                                    }
                                                                }
                                                            }
                                                        }
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
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script defer="" src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
<script src="js/plannerJS.js"></script>
<script src="js/usuariosJS.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>

<script>
    $(document).ready(function() {
        var pageloader = document.getElementById("loader");
        if (pageloader) {

            var pageloaderTimeout = setTimeout(function() {
                pageloader.classList.toggle('is-active');
                clearTimeout(pageloaderTimeout);
            }, 3000);
        }

        $(window).scroll(function() {
            var position = $(this).scrollTop();
            if (position >= 200) {
                $('#btnAncla').fadeIn('slow');
            } else {
                $('#btnAncla').fadeOut('slow');
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

</html>