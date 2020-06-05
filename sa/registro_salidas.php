<?php
try {
    include 'libs/subalmacenesItemsPD.php';
    $conn = new Conexion();
    $idSubalmacen = $_GET['idSubalmacen'];
    $conn->conectar();
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
    $conn->cerrar();
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
        <link rel="stylesheet" href="css/hover.css">
        <link rel="stylesheet" href="DataTables/datatables.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                    <div class="columns is-centered is-mobile">
                        <div class="column is-6 has-text-centered">
                            <a class="button is-info is-fullwidth" href="existencias.php?idSubalmacen=<?php echo $idSubalmacen; ?>"><span class="icon is-medium"><i class="fas fa-eye"></i></span><span>EXISTENCIAS</span></a>
                        </div>
                    </div>
                    <div class="columns is-centered is-mobile">
                        <div class="column is-6 has-text-centered">
                            <h1 class="title is-size-5">REGISTROS DE SALIDA DE MATERIAL</h1>
                        </div>

                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="table-container">
                                <table id="tableEntradas" class="table" style="width:100%">
                                    <thead class="is-size-7">
                                        <tr>
                                            <th>SUBALMACEN</th>
                                            <?php
                                            if ($faseSA == "ZI") {
                                                ?>
                                                <th>TIPO</th>
                                                <th>MOTIVO</th>
                                                <?php
                                            } else {
                                                ?>
                                                <th>ID GIFT</th>
                                                <?php
                                            }
                                            ?>

                                            <th>COD. 2BEND</th>
                                            <th>MATERIAL</th>
                                            <th>CARACTERISTICAS</th>
                                            <th>CANTIDAD RETIRADA</th>
                                            <th>RETIRADO POR</th>
                                            <th>FECHA</th>
                                        </tr>
                                    </thead>
                                    <tbody class="is-size-7">
                                        <?php
                                        $conn->conectar();
                                        $query = "SELECT "
                                                . "t_subalmacenes_salidas.id_usuario 'IDUSUARIO', "
                                                . "t_subalmacenes_salidas.id_material 'IDMATERIAL', "
                                                . "t_subalmacenes_salidas.cantidad 'CANTIDAD', "
                                                . "t_subalmacenes_salidas.fecha 'FECHA', "
                                                . "t_subalmacenes_salidas.id_gift 'IDGIFT', "
                                                . "t_subalmacenes_salidas.tipo 'TIPO', "
                                                . "t_subalmacenes_salidas.motivo 'MOTIVO', "
                                                . "t_colaboradores.nombre 'NOMBREEMP', "
                                                . "t_colaboradores.apellido 'APELLIDOEMP', "
                                                . "t_subalmacenes_items.cod2bend 'COD2BEND', "
                                                . "t_subalmacenes_items.descripcion 'DESCRIPCION', "
                                                . "t_subalmacenes_items.caracteristicas 'CARACT',"
                                                . "t_subalmacenes_items.id_subalmacen 'IDSUBALMACEN', "
                                                . "t_subalmacenes.nombre 'NOMBRESA', "
                                                . "t_subalmacenes.fase 'FASE' "
                                                . "FROM t_subalmacenes_salidas "
                                                . "INNER JOIN t_colaboradores ON t_subalmacenes_salidas.id_usuario = t_colaboradores.codigo_sa "
                                                . "INNER JOIN t_subalmacenes_items ON t_subalmacenes_salidas.id_material = t_subalmacenes_items.id "
                                                . "INNER JOIN t_subalmacenes ON t_subalmacenes_items.id_subalmacen = t_subalmacenes.id "
                                                . "WHERE t_subalmacenes.id = $idSubalmacen";

                                        try {
                                            $resp = $conn->obtDatos($query);
                                            if ($conn->filasConsultadas > 0) {
                                                foreach ($resp as $dts) {
                                                    $subalmacen = $dts['NOMBRESA'];
                                                    $idGift = $dts['IDGIFT'];
                                                    $cod2bend = $dts['COD2BEND'];
                                                    $material = $dts['DESCRIPCION'];
                                                    $caract = $dts['CARACT'];
                                                    $cantidad = $dts['CANTIDAD'];
                                                    $agregado = $dts['NOMBREEMP'] . " " . $dts['APELLIDOEMP'];
                                                    $fecha = $dts['FECHA'];
                                                    $tipo = $dts['TIPO'];
                                                    $motivo = $dts['MOTIVO'];
                                                    echo "<tr>"
                                                    . "<td>$subalmacen</td>";
                                                    if ($faseSA == "ZI") {
                                                        echo "<td>$tipo</td>"
                                                        . "<td>$motivo</td>";
                                                    } else {
                                                        echo "<td>$idGift</td>";
                                                    }

                                                    echo "<td>$cod2bend</td>"
                                                    . "<td>$material</td>"
                                                    . "<td>$caract</td>"
                                                    . "<td>$cantidad</td>"
                                                    . "<td>$agregado</td>"
                                                    . "<td>$fecha</td>"
                                                    . "</tr>";
                                                }
                                            }
                                        } catch (Exception $ex) {
                                            echo $ex;
                                        }
                                        ?>
                                    </tbody>

                                </table>
                                <?php
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--        <div id="modal-agregar-item" class="modal">
                    <div class="modal-background"></div>
                    <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Agregar item</p>
                            <button class="delete close-modal" aria-label="close"></button>
                        </header>
                        <section class="modal-card-body">
                            <div class="columns is-centered is-mobile is-multiline">
                                <div class="column is-6">
                                    <div class="field">
                                        <div class="control">
                                            <input id="txtCod2bend" class="input" type="text" placeholder="Codigo 2Bend">
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <div class="control">
                                            <input id="txtMaterial" class="input" type="text" placeholder="Material">
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-12">
                                    <div class="field">
                                        <div class="control">
                                            <textarea id="txtDescripcion" class="textarea" rows="3" placeholder="Descripcion"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-4">
                                    <div class="field">
                                        <div class="control">
                                            <input id="txtCantidad" class="input" type="number" placeholder="Cantidad">
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-4">
                                    <div class="field">
                                        <div class="control">
                                            <input id="txtMarca" class="input" type="text" placeholder="Marca/Proveedor">
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-4">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbCategoria">
                                                    <option>-Categoria-</option>
                                                    <option value="ACCESORIOS DE BAÑO">ACCESORIOS DE BAÑO</option>
                                                    <option value="ALBAÑILERIA">ALBAÑILERIA</option>
                                                    <option value="CARPINTERIA">CARPINTERIA</option>
                                                    <option value="CONSUMIBLES">CONSUMIBLES</option>
                                                    <option value="DOMOTICA">DOMOTICA</option>
                                                    <option value="ELECTRICIDAD">ELECTRICIDAD</option>
                                                    <option value="FANCOIL">FANCOIL</option>
                                                    <option value="HIDROSANITARIO">HIDROSANITARIO</option>
                                                    <option value="ILUMINACION">ILUMINACION</option>
                                                    <option value="JACUZZI">JACUZZI</option>
                                                    <option value="PLOMERIA">PLOMERIA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                        </section>
                        <footer class="modal-card-foot">
                            <button class="button is-primary" onclick="guardarItem(<?php echo $idSubalmacen; ?>)">Guardar</button>
                            <button class="button close-modal">Cancelar</button>
                        </footer>
                    </div>
                </div>-->

        <!--        <div id="modal-editar-item" class="modal">
                    <div class="modal-background"></div>
                    <div class="modal-card">
                        <header class="modal-card-head">
                            <p class="modal-card-title">Editar item</p>
                            <button class="delete close-modal" aria-label="close"></button>
                        </header>
                        <section class="modal-card-body">
                            <input type="hidden" id="txtIdItem">
                            <div class="columns is-centered is-mobile is-multiline">
                                <div class="column is-6">
                                    <div class="field">
                                        <div class="control">
                                            <input id="txtCod2bendEdit" class="input" type="text" placeholder="Codigo 2Bend">
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-6">
                                    <div class="field">
                                        <div class="control">
                                            <input id="txtMaterialEdit" class="input" type="text" placeholder="Material">
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-12">
                                    <div class="field">
                                        <div class="control">
                                            <textarea id="txtDescripcionEdit" class="textarea" rows="3" placeholder="Descripcion"></textarea>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="column is-4">
                                    <div class="field">
                                        <div class="control">
                                            <input id="txtMarcaEdit" class="input" type="text" placeholder="Marca/Proveedor">
                                        </div>
                                    </div>
                                </div>
                                <div class="column is-4">
                                    <div class="field">
                                        <div class="control">
                                            <div class="select is-fullwidth">
                                                <select id="cbCategoriaEdit">
                                                    <option value="">-Categoria-</option>
                                                    <option value="ACCESORIOS DE BAÑO">ACCESORIOS DE BAÑO</option>
                                                    <option value="ALBAÑILERIA">ALBAÑILERIA</option>
                                                    <option value="CARPINTERIA">CARPINTERIA</option>
                                                    <option value="CONSUMIBLES">CONSUMIBLES</option>
                                                    <option value="DOMOTICA">DOMOTICA</option>
                                                    <option value="ELECTRICIDAD">ELECTRICIDAD</option>
                                                    <option value="FAN&COIL">FANCOIL</option>
                                                    <option value="HIDROSANITARIO">HIDROSANITARIO</option>
                                                    <option value="ILUMINACION">ILUMINACION</option>
                                                    <option value="JACUZZI">JACUZZI</option>
                                                    <option value="PLOMERIA">PLOMERIA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
                        </section>
                        <footer class="modal-card-foot">
                            <button class="button is-primary" onclick="actualizarItem()">Guardar</button>
                            <button class="button close-modal">Cancelar</button>
                        </footer>
                    </div>
                </div>-->
    </body>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<!--    <script src="js/bootstrap.js"></script>-->
    <script src="js/acceso.js"></script>
    <script src="js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="DataTables/datatables.js"></script>

    <script>
        var tablaItems = $('#tableEntradas').DataTable({
            "order": [[2, "asc"]],
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

//                        tablaItems
//                                .on('select', function (e, dt, type, indexes) {
//                                    var rowData = tablaItems.rows(indexes).data().toArray();
//                                    idItem = rowData[0][0];
//                                    $.ajax({
//                                        type: 'post',
//                                        url: 'libs//subalmacenesItemsPD.php',
//                                        data: 'action=obtenerItem&idItem=' + idItem,
//                                        success: function (data) {
//                                            try {
//                                                item = JSON.parse(data);
//                                                categoria = item.categoria;
//                                                $("#txtIdItem").val(item.id);
//                                                $("#txtCod2bendEdit").val(item.cod2bend);
//                                                $("#txtMaterialEdit").val(item.descripcion);
//                                                $("#txtDescripcionEdit").val(item.caracteristicas);
//                                                $("#txtCantidadEdit").val(item.cantidad);
//                                                $("#txtMarcaEdit").val(item.marca);
//                                                $("#cbCategoriaEdit").val(categoria.replace(/\s*$/, ""));
//
//                                            } catch (ex) {
//                                                toastr.error(ex + " - " + data, "Error!", {
//                                                    "closeButton": true,
//                                                    "newestOnTop": true,
//                                                    "positionClass": "toast-top-center",
//                                                    "showDuration": "300",
//                                                    "hideDuration": "1000",
//                                                    "timeOut": "5000",
//                                                    "extendedTimeOut": "1000",
//                                                    "showEasing": "swing",
//                                                    "hideEasing": "linear",
//                                                    "showMethod": "fadeIn",
//                                                    "hideMethod": "fadeOut"
//                                                });
//                                            }
//                                        }
//                                    });
//
//                                })
    </script>
    <script>
        function agregarItem(idItem, cantidadDisponible) {
            var cantidad = $("#cant" + idItem).val();
            if (cantidad != "") {
                if (cantidad <= cantidadDisponible) {
                    //alert("SE puede agregar");
                    $.ajax({
                        type: 'post',
                        url: 'libs/carrito.php',
                        data: 'action=1&idMaterial=' + idItem + '&cantidad=' + cantidad,
                        success: function (datos) {
                            try {
                                carrito = datos//JSON.parse(datos);

                            } catch (ex) {
                                alert(ex + " - " + datos);
                            }
                        }
                    });
                } else {
                    alert("No hay stock suficiente para la cantidad solicitada");
                }
            } else {
                alert("La cantidad solicitada no debe estar vacia");
            }

        }
    </script>
</html>