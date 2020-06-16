<?php
session_start();
include 'libs/subalmacenesItemsPD.php';
$idSubalmacen = $_GET['idSubalmacen'];
$codigoSA = $_GET['codigoAcceso'];
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    $motivo = $_GET['motivo'];
} else {
    $codigoGift = $_GET['codigoGift'];
}

$conn = new Conexion();
date_default_timezone_set('America/Mexico_City');
$conn->conectar();

$query = "SELECT * FROM t_colaboradores WHERE codigo_sa = '$codigoSA'";
try {
    $resp = $conn->obtDatos($query);
    if ($conn->filasConsultadas > 0) {
        foreach ($resp as $dts) {
            $nombreEmpleado = $dts['nombre'];
            $apellidoEmpleado = $dts['apellido'];
            $idPermiso = $dts['id_permiso'];
        }
    } else {
        header("Location: menu.php?idSubalmacen=$idSubalmacen");
    }
} catch (Exception $ex) {
    echo $ex;
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
    <link rel="stylesheet" href="css/clases.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="DataTables/datatables.css">
    <style>
    .container-scroll {
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
    }

    @media (min-width: 640px) {

        .modal-large {
            width: 90%;
        }

    }

    @media (min-width: 768px) {

        .modal-large {
            width: 90%;
        }

    }

    @media (min-width: 1024px) {

        .modal-large {
            width: 90%;
        }

    }

    @media (min-width: 1200px) {

        .modal-large {
            width: 90%;
        }

    }
    </style>
</head>

<body>
    <section class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered is-mobile ">

                    <div class="column has-text-centered ">
                        <p class=""><?php echo date("Y-m-d H:i:s"); ?></p>
                        <p class=""><strong><?php echo "$nombreEmpleado $apellidoEmpleado"; ?></strong></p>
                    </div>

                    <div class="column has-text-centered ">
                        <button class="button is-info modal-button" data-target="modal" aria-haspopup="true">
                            <span class="icon is-medium"><i class="fas fa-plus"></i></span><span>Añadir</span>
                        </button>
                    </div>

                    <div class="column has-text-centered ">
                        <?php
                        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) :
                        ?>
                        <button class="button is-success modal-button" data-target="finalizarModal"
                            aria-haspopup="true">
                            <span class="icon is-medium"><i class="fas fa-check"></i></span><span>Finalizar</span>
                        </button>
                        <?php
                        else :
                        ?>
                        <button class="button is-success modal-button" data-target="finalizarModal" aria-haspopup="true"
                            disabled>
                            <span class="icon is-medium"><i class="fas fa-check"></i></span><span>Finalizar</span>
                        </button>
                        <?php
                        endif;
                        ?>
                    </div>

                    <div class="column has-text-centered ">
                        <a class="button is-danger" href="menu.php?idSubalmacen=<?php echo $idSubalmacen; ?>"
                            onclick="eliminarCarrito();">
                            <span class="icon is-medium"><i class="fas fa-ban"></i></span><span>Cancelar</span>
                        </a>
                    </div>
                </div>
                <div class="table-container">

                    <table id="tablaSalidas" class="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th style="display:none;">ID</th>
                                <th>Categoria</th>
                                <th>Cod2bend</th>
                                <th>Material</th>
                                <th>Caracteristicas</th>
                                <th>Marca/Proveedor</th>
                                <th>Cantidad</th>
                                <th>Items solicitados</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="is-size-7">
                            <?php
                            if (isset($_SESSION['cart'])) {
                                $resp = $conn->conectar();
                                foreach ($_SESSION['cart'] as $item) {
                                    $idItem = $item['idMaterial'];
                                    $query = "SELECT * FROM t_subalmacenes_items WHERE id = $idItem";
                                    try {
                                        $resp = $conn->obtDatos($query);
                                        if ($conn->filasConsultadas > 0) {
                                            foreach ($resp as $dts) {
                                                $categoria = $dts['categoria'];
                                                $cod2bend = $dts['cod2bend'];
                                                $descripcion = $dts['descripcion'];
                                                $caract = $dts['caracteristicas'];
                                                $marca = $dts['marca'];
                                                $cantidadActual = $dts['cantidad'];

                                                echo "<tr>"
                                                    . "<td style=\"display:none\">$idItem</td>"
                                                    . "<td>$categoria</td>"
                                                    . "<td>$cod2bend</td>"
                                                    . "<td>$descripcion</td>"
                                                    . "<td>$caract</td>"
                                                    . "<td>$marca</td>"
                                                    . "<td>$cantidadActual</td>"
                                                    . "<td>" . $item['cantidad'] . "</td>"
                                                    . "<td><button class=\"button is-danger\" onclick=\"removeCart($idItem)\"><span class=\"icon\"><i class=\"fas fa-trash-alt\"></i></span></button></td>"
                                                    . "</tr>";
                                            }
                                        }
                                    } catch (Exception $ex) {
                                        echo $ex;
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div id="modal" class="modal">
        <div class="modal-background"></div>
        <div class="modal-card modal-large">
            <header class="modal-card-head">
                <div class="container">
                    <div class="columns">
                        <div class="column">
                            <p class="modal-card-title">Lista de items</p>
                        </div>
                        <!--                            <div class="column is-9">
                                                            <input id="txtBuscar" type="text" class="input is-medium" placeholder="Buscar..." onkeyup="buscarItemPalabra(<?php echo $idSubalmacen; ?>)">
                                                        </div>-->
                        <div class="column is-1 has-text-right">
                            <button class="delete" aria-label="close"></button>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column has-text-right">
                            <button class="button is-primary" onclick="agregarCarritoSalida();"><span class="icon"><i
                                        class="fa fa-cart-arrow-down"></i></span><span>Agregar</span></button>
                        </div>
                    </div>
                </div>
            </header>
            <section class="modal-card-body">
                <div class="columns is-centered">
                    <div id="listItems" class="column is-12">
                        <table id="tablaItems" class="table is-fullwidth" style="width:99%;">
                            <thead>
                                <tr>
                                    <th class="column is-12">Item</th>
                                    <th>Cantidad disponible</th>
                                    <th>Cantidad Seleccionada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $items = new SubalmacenesItemsPD();

                                $listaItems = $items->obtenerListaItems($idSubalmacen);

                                foreach ($listaItems as $item) {
                                    echo "<tr>"
                                        . "<td>" . strtoupper($item->descripcion) . " - " . $item->caracteristicas . "</td>";
                                    if ($item->cantidad == 0) {
                                        echo "<td><h6 class=\"mt-2 mr-2 tag is-danger\">" . $item->cantidad . "</h6></td>";
                                    } else {
                                        echo "<td><h6 class=\"mt-2 mr-2 tag is-success\">" . $item->cantidad . "</h6></td>";
                                    }
                                    if ($item->cantidad == 0) {
                                        echo "<td><input id=\"txtCantidadMaterial_$item->id " . "_$item->cantidad\" type=\"number\" class=\"input is-small\" disabled></td>"
                                            . "</tr>";
                                    } else {
                                        echo "<td><input id=\"txtCantidadMaterial_$item->id " . "_$item->cantidad\" type=\"number\" class=\"input is-small\" min=\"1\" max=\"$item->cantidad\" pattern=\"[^[0-9]+]\"></td>"
                                            . "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </section>
        </div>
    </div>

    <div id="finalizarModal" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <div class="media">
                    <div class="media-content">
                        <div class="container">
                            <div class="columns">
                                <div class="column has-text-centered">
                                    <h1 class="title is-size-3">¿Desea finalizar el registro de salida de material?</h1>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column has-text-centered">
                                    <?php
                                    if (isset($_GET['tipo'])) {
                                    ?>
                                    <button id="" class="button is-primary is-fullwidth is-block"
                                        onclick="registrarSalidaMaterialZI('<?php echo $codigoSA; ?>', <?php echo $idSubalmacen; ?>, '<?php echo $tipo; ?>', '<?php echo $motivo; ?>')">ACEPTAR</button>
                                    <?php
                                    } else {
                                    ?>
                                    <button id="" class="button is-primary is-fullwidth is-block"
                                        onclick="registrarSalidaMaterial('<?php echo $codigoSA; ?>', <?php echo $idSubalmacen; ?>, <?php echo $codigoGift; ?>)">ACEPTAR</button>
                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="column has-text-centered">
                                    <button class="button close-modal is-fullwidth is-block">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--            <button class="modal-close is-large" aria-label="close"></button>-->
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="DataTables/datatables.js"></script>
<!--    <script src="js/bootstrap.js"></script>-->
<script src="js/main.js?v=1.0.1"></script>
<script src="js/acceso.js?v=1.0.1"></script>
<script>
var items = $('#tablaItems').DataTable({
    "scrollY": "50vh",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
    },
    dom: 'Bfrtip',
    buttons: [{
        extend: 'excel',
        title: 'Reporte de pendientes de Usuarios',
        className: 'button is-primary is-small'
    }, ]

});

var tablaItems = $('#tablaSalidas').DataTable({
    "order": [
        [2, "asc"]
    ],
    "select": true,
    "scrollY": "50vh",
    "scrollX": true,
    "scrollCollapse": true,
    "paging": false,
    "autoWidth": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
    },
    dom: 'Bfrtip',
    buttons: [{
        extend: 'excel',
        title: 'Reporte de pendientes de Usuarios',
        className: 'button is-primary is-small'
    }, ],
    initComplete: function() {
        this.api().columns().every(function() {
            var column = this;
            var select = $('<select><option value=""></option></select>')
                .appendTo($(column.footer()).empty())
                .on('change', function() {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );
                    column
                        .search(val ? '^' + val + '$' : '', true, false)
                        .draw();
                });
            column.data().unique().sort().each(function(d, j) {
                select.append('<option value="' + d + '">' + d + '</option>')
            });
        });
    }

});

//                                            tablaItems
//                                                    .on('select', function (e, dt, type, indexes) {
//                                                        var rowData = tablaItems.rows(indexes).data().toArray();
//                                                        idItem = rowData[0][0];
//                                                        $.ajax({
//                                                            type: 'post',
//                                                            url: 'libs//subalmacenesItemsPD.php',
//                                                            data: 'action=obtenerItem&idItem=' + idItem,
//                                                            success: function (data) {
//                                                                try {
//                                                                    item = JSON.parse(data);
//                                                                    categoria = item.categoria;
//                                                                    $("#txtIdItem").val(item.id);
//                                                                    $("#txtCod2bendEdit").val(item.cod2bend);
//                                                                    $("#txtMaterialEdit").val(item.descripcion);
//                                                                    $("#txtDescripcionEdit").val(item.caracteristicas);
//                                                                    $("#txtCantidadEdit").val(item.cantidad);
//                                                                    $("#txtMarcaEdit").val(item.marca);
//                                                                    $("#cbCategoriaEdit").val(categoria.replace(/\s*$/, ""));
//
//                                                                } catch (ex) {
//                                                                    toastr.error(ex + " - " + data, "Error!", {
//                                                                        "closeButton": true,
//                                                                        "newestOnTop": true,
//                                                                        "positionClass": "toast-top-center",
//                                                                        "showDuration": "300",
//                                                                        "hideDuration": "1000",
//                                                                        "timeOut": "5000",
//                                                                        "extendedTimeOut": "1000",
//                                                                        "showEasing": "swing",
//                                                                        "hideEasing": "linear",
//                                                                        "showMethod": "fadeIn",
//                                                                        "hideMethod": "fadeOut"
//                                                                    });
//                                                                }
//                                                            }
//                                                        });
//
//                                                    })
</script>

</html>