function cargarSubsecciones() {
    var familia = $("#cbSecciones").val();
    $.ajax({
        type: 'post',
        url: 'php/stockPHP.php',
        data: 'action=1&idFamilia=' + familia,
        success: function (data) {
            $("#cbSubsecciones").html(data);
            //$("#cbFamilia").selectpicker('refresh');
        }
    });
}

function cargarSubseccionesEdit() {
    var familia = $("#cbSeccionEdit").val();
    $.ajax({
        type: 'post',
        url: 'php/stockPHP.php',
        data: 'action=1&idFamilia=' + familia,
        success: function (data) {
            $("#cbFamiliaEdit").html(data);
            $("#cbFamiliaEdit").selectpicker('refresh');
        }
    });
}

function guardarRegistroStockNecesario() {
    var destino = $("#cbDestinoReg").val();
    var fase = $("#cbFase").val();
    var ubicacion = $("#txtUbicacion").val();
    var cod2bend = $("#txtCod2bend").val();
    var descripcion2bend = $("#txtDesc2bend").val();
    var naturaleza = $("#cbNaturaleza").val();
    var seccion = $("#cbSeccion").val();
    var familia = $("#cbFamilia").val();
    var subfamilia = $("#cbSubfamilia").val();
    if (subfamilia == "DESPIECE-EQUIPO") {
        var equipoppal = $("#txtEquipoPpal").val();
    } else {
        var equipoppal = "";
    }
    var descripcionNueva = $("#txtDescNueva").val();
    var marca = $("#txtMarca").val();
    var modelo = $("#txtModelo").val();
    var caracteristicasPpales = $("#txtCaracteristicasPpales").val();

    if ($("#txtExistencias2bend").val() != "") {
        var existencias2bend = $("#txtExistencias2bend").val();
    } else {
        var existencias2bend = 0;
    }

    if ($("#txtExistenciasSubalmacen").val() != "") {
        var existenciasSubalmacen = $("#txtExistenciasSubalmacen").val();
    } else {
        var existenciasSubalmacen = 0;
    }
    if ($("#txtPrecio").val() != "") {
        var precio = $("#txtPrecio").val();
    } else {
        var precio = 0;
    }
    if ($("#txtConsumoAnual").val() != "") {
        var consumoAnual = $("#txtConsumoAnual").val();
    } else {
        var consumoAnual = 0;
    }

    if ($("#txtStockNecesario").val() != "") {
        var stockNecesario = $("#txtStockNecesario").val();
    } else {
        var stockNecesario = 0;
    }

    if ($("#txtUnidadesAPedir").val() != "") {
        var unidadesPedir = $("#txtUnidadesAPedir").val();
    } else {
        var unidadesPedir = 0;
    }

    var fechaPedido = $("#txtFechaPedido").val();
    var prioridad = $("#txtPrioridad").val();
    var fechaLlegada = $("#txtFechaLlegada").val();



    var data = new FormData();
    data.append('action', 3);
    data.append('idDestino', destino);
    data.append('fase', fase);
    data.append('ubicacion', ubicacion);
    data.append('cod2bend', cod2bend);
    data.append('descripcion2bend', descripcion2bend);
    data.append('naturaleza', naturaleza);
    data.append('seccion', seccion);
    data.append('familia', familia);
    data.append('subfamilia', subfamilia);
    data.append('equipoppal', equipoppal);
    data.append('descripcionNueva', descripcionNueva);
    data.append('marca', marca);
    data.append('modelo', modelo);
    data.append('caracteristicasPpales', caracteristicasPpales);
    data.append('existencias2bend', existencias2bend);
    data.append('existenciasSubalmacen', existenciasSubalmacen);
    data.append('precio', precio);
    data.append('consumoAnual', consumoAnual);
    data.append('stockNecesario', stockNecesario);
    data.append('unidadesPedir', unidadesPedir);
    data.append('fechaPedido', fechaPedido);
    data.append('prioridad', prioridad);
    data.append('fechaLlegada', fechaLlegada);


    $.ajax({
        url: "php/stockPHP.php",
        type: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data == 1) {
                toastr.success('', 'Registro Correcto', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-center",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                setTimeout(function () {
                    location.reload();
                }, 2300);
            } else {
                toastr.error(data, 'Error', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-center",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        }
    });



}

function actualizarRegistroStockNecesario(pagina) {
    var idRegistro = $("#hddIdRegistro").val();

    if ($("#cbDestinoRegEdit").val() != "") {
        var destino = $("#cbDestinoRegEdit").val();
    } else {
        var destino = 0;
    }
    var fase = $("#cbFaseEdit").val();
    var ubicacion = $("#txtUbicacionEdit").val();
    var cod2bend = $("#txtCod2bendEdit").val();
    var descripcion2bend = $("#txtDesc2bendEdit").val();
    var naturaleza = $("#cbNaturalezaEdit").val();
    if ($("#cbSeccionEdit").val() != "") {
        var seccion = $("#cbSeccionEdit").val();
    } else {
        var seccion = 0;
    }

    if ($("#cbFamiliaEdit").val() != "") {
        var familia = $("#cbFamiliaEdit").val();
    } else {
        var familia = 0;
    }

    var subfamilia = $("#cbSubfamiliaEdit").val();
    var descripcionNueva = $("#txtDescNuevaEdit").val();
    var marca = $("#txtMarcaEdit").val();
    var modelo = $("#txtModeloEdit").val();
    var caracteristicasPpales = $("#txtCaracteristicasPpalesEdit").val();

    if ($("#txtExistencias2bendEdit").val() != "") {
        var existencias2bend = $("#txtExistencias2bendEdit").val();
    } else {
        var existencias2bend = 0;
    }

    if ($("#txtExistenciasSubalmacenEdit").val() != "") {
        var existenciasSubalmacen = $("#txtExistenciasSubalmacenEdit").val();
    } else {
        var existenciasSubalmacen = 0;
    }
    if ($("#txtPrecioEdit").val() != "") {
        var precio = $("#txtPrecioEdit").val();
    } else {
        var precio = 0;
    }
    if ($("#txtConsumoAnualEdit").val() != "") {
        var consumoAnual = $("#txtConsumoAnualEdit").val();
    } else {
        var consumoAnual = 0;
    }

    if ($("#txtStockNecesarioEdit").val() != "") {
        var stockNecesario = $("#txtStockNecesarioEdit").val();
    } else {
        var stockNecesario = 0;
    }

    if ($("#txtUnidadesAPedirEdit").val() != "") {
        var unidadesPedir = $("#txtUnidadesAPedirEdit").val();
    } else {
        var unidadesPedir = 0;
    }

    var fechaPedido = $("#txtFechaPedidoEdit").val();
    var prioridad = $("#txtPrioridadEdit").val();
    var fechaLlegada = $("#txtFechaLlegadaEdit").val();



    var data = new FormData();
    data.append('action', 7);
    data.append('idRegistro', idRegistro);
    data.append('idDestino', destino);
    data.append('fase', fase);
//    data.append('ubicacion', ubicacion);
    data.append('cod2bend', cod2bend);
    data.append('descripcion2bend', descripcion2bend);
    data.append('naturaleza', naturaleza);
    data.append('seccion', seccion);
    data.append('familia', familia);
    data.append('subfamilia', subfamilia);
    data.append('descripcionNueva', descripcionNueva);
    data.append('marca', marca);
    data.append('modelo', modelo);
    data.append('caracteristicasPpales', caracteristicasPpales);
    data.append('existencias2bend', existencias2bend);
    data.append('existenciasSubalmacen', existenciasSubalmacen);
    data.append('precio', precio);
    data.append('consumoAnual', consumoAnual);
    data.append('stockNecesario', stockNecesario);
    data.append('unidadesPedir', unidadesPedir);
    data.append('fechaPedido', fechaPedido);
    data.append('prioridad', prioridad);
    data.append('fechaLlegada', fechaLlegada);

    if (pagina == 0) {
        var url = "php/stockPHP.php";
    } else {
        var url = "php/stockPHP.php";
    }

    $.ajax({
        url: url,
        type: "POST",
        data: data,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            if (data == 1) {
                toastr.success('', 'Registro Correcto', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-center",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                if (pagina != 0) {
                    setTimeout(function () {
                        location.reload();
                    }, 2300);
                } else {
                    var idSeccion = $("#hddIdSeccionReg").val();
                    cargarStock(idSeccion);
                }

            } else {
                toastr.error(data, 'Error', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-center",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        }
    });
}

function eliminarRegistroStockNecesario(pagina) {
    if (pagina == 0) {
        var url = "php/stockPHP.php";
    } else {
        var url = "php/stockPHP.php";
    }
    var idRegistro = $("#hddIdRegistro").val();
    $.ajax({
        url: url,
        type: "POST",
        data: 'action=8&idRegistro=' + idRegistro,
        success: function (data) {
            if (data == 1) {
                toastr.success('', 'Registro Eliminado', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-center",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                if (pagina != 0) {
                    setTimeout(function () {
                        location.reload();
                    }, 2300);
                } else {
                    $("#modal-eliminar-registro").modal('hide');
                    $("#modal-editar-registro").modal('hide');
                    var idSeccion = $("#hddIdSeccionReg").val();
                    cargarStock(idSeccion);
                }

            } else {
                toastr.error(data, 'Error', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-center",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        }
    });
}

function buscarMaterial(element) {
    var id = element.id;
    var word = element.value;

    if (word != "") {
        $.ajax({
            type: 'post',
            url: 'php/stockPHP.php',
            data: 'action=10&word=' + word,

            success: function (data) {
//            $(".loader").fdeOut('slow');
                if (id == "txtCod2bendEdit") {
                    $("#searchResultEdit").html(data);
                    $("#searchResultEdit").show();
                } else {
                    $("#searchResult").html(data);
                    $("#searchResult").show();
                }

            }
        });
    } else {
        $("#searchResult").html("");
        $("#searchResult").fadeOut('slow');
    }

}

function selectItem(element) {
    var texto = element.innerText;
    $("#searchResult").html("");
    $("#searchResult").fadeOut('slow');
    $("#txtDesc2bend").val(texto);

    $("#searchResultEdit").html("");
    $("#searchResultEdit").fadeOut('slow');
    $("#txtDesc2bendEdit").val(texto);

}

function obtenerStockXPagina(idDestino, pagina) {
    $.ajax({
        type: 'post',
        url: 'php/stockPHP.php',
        data: 'action=obtStockXPagina&idDestino=' + idDestino + '&pagina=' + pagina,
        success: function (data) {
            $("#sectionStock").html("");
            $("#sectionStock").html(data);
        }
    });
}

function filtrar(idDestino) {
    var seccion = $("#cbSecciones").val();
    var subseccion = $("#cbSubsecciones").val();
    $.ajax({
        type: 'post',
        url: 'php/stockPHP.php',
        data: 'action=filtrar&idDestino=' + idDestino + '&pagina=' + 1 + '&seccion=' + seccion + '&subseccion=' + subseccion,
        success: function (data) {
            $("#sectionStock").html("");
            $("#sectionStock").html(data);
        }
    });
}

function obtenerStockXPaginaFiltro(idDestino, pagina) {
    var seccion = $("#cbSecciones").val();
    var subseccion = $("#cbSubsecciones").val();
    $.ajax({
        type: 'post',
        url: 'php/stockPHP.php',
        data: 'action=filtrar&idDestino=' + idDestino + '&pagina=' + pagina + '&seccion=' + seccion + '&subseccion=' + subseccion,
        success: function (data) {
            $("#sectionStock").html("");
            $("#sectionStock").html(data);
        }
    });
}

function busqueda(idDestino, pagina) {
    var seccion = $("#cbSecciones").val();
    var subseccion = $("#cbSubsecciones").val();
    var busqueda = $("#txtBusqueda").val();
    $.ajax({
        type: 'post',
        url: 'php/stockPHP.php',
        data: 'action=busqueda&idDestino=' + idDestino + '&pagina='
                + pagina + '&seccion=' + seccion + '&subseccion=' + subseccion
                + '&busqueda=' + busqueda,
        success: function (data) {
            $("#sectionStock").html("");
            $("#sectionStock").html(data);
        }
    });
}

function obtenerStockXPaginaBusqueda(idDestino, pagina) {
    var seccion = $("#cbSecciones").val();
    var subseccion = $("#cbSubsecciones").val();
    var busqueda = $("#txtBusqueda").val();
    $.ajax({
        type: 'post',
        url: 'php/stockPHP.php',
        data: 'action=busqueda&idDestino=' + idDestino
                + '&pagina=' + pagina + '&seccion=' + seccion + '&subseccion=' + subseccion
                + '&busqueda=' + busqueda,
        success: function (data) {
            $("#sectionStock").html("");
            $("#sectionStock").html(data);
        }
    });
}