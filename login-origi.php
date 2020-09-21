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
                            $bandera = $dts['bandera'];
                            $gp = $dts['gp'];
                            $trs = $dts['trs'];
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
            $division = $dts['division'];
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
    <title>Tablas</title>
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="icon" href="svg/logo6.png">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-html5-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.3/css/buttons.dataTables.min.css">

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

        select {
            width: 80px;
        }

        /* DataTable */
        /*Form fields*/
        .dataTables_wrapper select,
        .dataTables_wrapper .dataTables_filter input {
            color: #4a5568;
            /*text-gray-700*/
            padding-left: 1rem;
            /*pl-4*/
            padding-right: 1rem;
            /*pl-4*/
            padding-top: .5rem;
            /*pl-2*/
            padding-bottom: .5rem;
            /*pl-2*/
            line-height: 1.25;
            /*leading-tight*/
            border-width: 2px;
            /*border-2*/
            border-radius: .25rem;
            border-color: #edf2f7;
            /*border-gray-200*/
            background-color: #edf2f7;
            /*bg-gray-200*/
        }

        /*Row Hover*/
        table.dataTable.hover tbody tr:hover,
        table.dataTable.display tbody tr:hover {
            background-color: #ebf4ff;
            /*bg-indigo-100*/
        }

        /*Pagination Buttons*/
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Pagination Buttons - Current selected */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            color: #fff !important;
            /*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            /*shadow*/
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            background: #667eea !important;
            /*bg-indigo-500*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Pagination Buttons - Hover */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #fff !important;
            /*text-white*/
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
            /*shadow*/
            font-weight: 700;
            /*font-bold*/
            border-radius: .25rem;
            /*rounded*/
            background: #667eea !important;
            /*bg-indigo-500*/
            border: 1px solid transparent;
            /*border border-transparent*/
        }

        /*Add padding to bottom border */
        table.dataTable.no-footer {
            border-bottom: 1px solid #e2e8f0;
            /*border-b-1 border-gray-300*/
            margin-top: 0.75em;
            margin-bottom: 0.75em;
        }

        /*Change colour of responsive icon*/
        table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child:before {
            background-color: #667eea !important;
            /*bg-indigo-500*/
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <div id="content" class="w-10/12 mx-auto p-4">
            <table id="table_id" class="display stripe hover" style="width:100%; padding-top: 1em;  padding-bottom: 1em;" data-page-length='50'>
                <thead>
                    <tr>
                        <th style="display:none;">idDocumento</th>
                        <th>Destino</th>
                        <th>CECO</th>
                        <th>Documento</th>
                        <th>Fecha Cont.</th>
                        <th>Importe (USD)</th>
                        <th>Asignación</th>
                        <th>Descripción</th>
                        <th>Proveedor</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
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
                                $textoCeco = $dts['TEXTCECO'];
                                $NOMBRE1 = $dts['NOMBRE1'];
                                $DOCCOMPRAS = $dts['DOCCOMPRAS'];

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
                                                . "<td class=\"fs-9\">$textoCeco</td>"
                                                . "<td>$DOCCOMPRAS</td>"
                                                . "<td>$fechaConta</td>"
                                                . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                . "<td>$asignacion</td>"
                                                . "<td>$descripcion</td>"
                                                . "<td>$proveedor</td>"
                                                . "<td>$NOMBRE1</td>"
                                                . "</tr>";
                                        } else {
                                            if ($destino == $destinoCECO) {
                                                echo "<tr>"
                                                    . "<td style=\"display: none;\">$idDocumento</td>"
                                                    . "<td>$destinoCECO</td>"
                                                    . "<td class=\"fs-9\">$textoCeco</td>"
                                                    . "<td>$DOCCOMPRAS</td>"
                                                    . "<td>$fechaConta</td>"
                                                    . "<td>" . money_format("%.0n", $importe) . "</td>"
                                                    . "<td>$asignacion</td>"
                                                    . "<td>$descripcion</td>"
                                                    . "<td>$proveedor</td>"
                                                    . "<td>$NOMBRE1</td>"
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
                <tfoot>
                    <tr>
                        <th style="display:none;">idDocumento</th>
                        <th>Destino</th>
                        <th>CECO</th>
                        <th>Documento</th>
                        <th>Fecha Cont.</th>
                        <th>Importe (USD)</th>
                        <th>Asignación</th>
                        <th>Descripción</th>
                        <th>Proveedor</th>
                        <th>Nombre</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.3/b-html5-1.6.3/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'excel', 'pdf'
                    ],
                    initComplete: function() {
                        this.api().columns().every(function() {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.header())).on('change', function() {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );

                                    column
                                        .search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });

                            column.data().unique().sort().each(function(d, j) {
                                select.append('<option value="' + d + '">' + d.substr(0, 30) + '</option>');
                            });
                        });
                    },
                    responsive: true
                })
                .columns.adjust()
                .responsive.recalc();
        });
    </script>
</body>

</html>