function ocultarTarjetas2(elemento, idDestino) {
    var tarjeta = elemento.id;
    switch (tarjeta) {
        case 'cardTRS':
            $("#cardTRS").show();
            $("#cardDetalles").show();
            $("#cardDetalles").addClass('animated fadeIn');
            $("#cardGP").hide();
            $("#cardZI").hide();
            var idPptoMC = document.getElementById("idPresupuestoMCTRS").value;
            var idPptoMP = document.getElementById("idPresupuestoMPTRS").value;
            break;
        case 'cardGP':

            $("#cardTRS").hide();
            $("#cardGP").show();
            $("#cardDetalles").show();
            $("#cardZI").hide();
            var idPptoMC = document.getElementById("idPresupuestoMCGP").value;
            var idPptoMP = document.getElementById("idPresupuestoMPGP").value;
            break;
        case 'cardZI':
            $("#cardTRS").hide();
            $("#cardGP").hide();
            $("#cardZI").show();
            $("#cardDetalles").show();
            var idPptoMC = document.getElementById("idPresupuestoMCZI").value;
            var idPptoMP = document.getElementById("idPresupuestoMPZI").value;
            break;
        case 'btnDetalles':
            $("#cardTRS").show();
            $("#cardTRS").addClass('animated fadeIn');
            $("#cardGP").show();
            $("#cardGP").addClass('animated fadeIn');
            $("#cardZI").show();
            $("#cardZI").addClass('animated fadeIn');
            $("#cardDetalles").hide();
            var idPptoMC = 0;
            var idPptoMP = 0;
            break;
    }

    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: 'action=10&idPptoMC=' + idPptoMC + '&idPptoMP=' + idPptoMP + '&idDestino=' + idDestino + '&fase=' + tarjeta,
//        beforeSend: function () {
//            $(".loader").show();
//        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            //$("#tablaGastos").DataTable().clear();
            //$("#tablaGastos").DataTable().destroy();
            var ppto = JSON.parse(data);
            $("#tableBodyServicios").html(ppto.tablaGastosServicios);
            $("#tableBodyMateriales").html(ppto.tablaGastosMateriales);
//            $("#divPptoAnual").html(ppto.pptoAnual);
//            $("#divPptosTotal").html(ppto.pptoMensualTotal);
//            $("#divPptosServicios").html(ppto.pptoMensualServicios);
//            $("#divPptosMateriales").html(ppto.pptoMensualMateriales);

            var meses = ppto.arrayMeses;
            var pptoMC = ppto.arrayPptoMC;
            var pptoMP = ppto.arrayPptoMP;
            var gastoMC = ppto.arrayGastoMC;
            var gastoMP = ppto.arrayGastoMP;

            var pptoMCServ = ppto.arrayPptoMCServ;
            var pptoMPServ = ppto.arrayPptoMPServ;
            var gastoMCServ = ppto.arrayGastoMCServ;
            var gastoMPServ = ppto.arrayGastoMPServ;

            var pptoMCMat = ppto.arrayPptoMCMat;
            var pptoMPMat = ppto.arrayPptoMPMat;
            var gastoMCMat = ppto.arrayGastoMCMat;
            var gastoMPMat = ppto.arrayGastoMPMat;

            var ctx = document.getElementById("myChart1");
            var myChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: meses,
                    datasets: [{
                            label: 'PRESUPUESTO MC',
                            backgroundColor: "rgba(81,113,175, 1)",
                            borderColor: "rgba(81,113,175, 1)",
                            data: pptoMC,
                            fill: false,
                        }, {
                            label: 'GASTO MC',
                            fill: false,
                            backgroundColor: "rgba(142, 169, 220, 1)",
                            borderColor: "rgba(142, 169, 220, 1)",
                            data: gastoMC,

                        },
                        {
                            label: 'PRESUPUESTO MP',
                            fill: false,
                            backgroundColor: "rgba(183,122,86, 1)",
                            borderColor: "rgba(183,122,86, 1)",
                            data: pptoMP,
                        }, {
                            label: 'GASTO MP',
                            fill: false,
                            backgroundColor: "rgba(245, 174, 132, 1)",
                            borderColor: "rgba(245, 174, 132, 1)",
                            data: gastoMP,

                        }, ]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                if (label) {
                                    label += ': $';
                                }
                                label += tooltipItem.yLabel || '';
                                return label;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                                ticks: {
                                    // Include a dollar sign in the ticks
                                    callback: function (value, index, values) {
                                        return "$" + value;
                                    }
                                }
                            }]
                    }
                }

            });

            var ctx = document.getElementById("myChart2");
            var myChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: meses,
                    datasets: [{
                            label: 'PRESUPUESTO MC',
                            backgroundColor: "rgba(81,113,175, 1)",
                            borderColor: "rgba(81,113,175, 1)",
                            data: pptoMCServ,
                            fill: false,
                        }, {
                            label: 'GASTO MC',
                            fill: false,
                            backgroundColor: "rgba(142, 169, 220, 1)",
                            borderColor: "rgba(142, 169, 220, 1)",
                            data: gastoMCServ,

                        },
                        {
                            label: 'PRESUPUESTO MP',
                            fill: false,
                            backgroundColor: "rgba(183,122,86, 1)",
                            borderColor: "rgba(183,122,86, 1)",
                            data: pptoMPServ,
                        }, {
                            label: 'GASTO MP',
                            fill: false,
                            backgroundColor: "rgba(245, 174, 132, 1)",
                            borderColor: "rgba(245, 174, 132, 1)",
                            data: gastoMPServ,

                        }, ]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                if (label) {
                                    label += ': $';
                                }
                                label += tooltipItem.yLabel || '';
                                return label;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                                ticks: {
                                    // Include a dollar sign in the ticks
                                    callback: function (value, index, values) {
                                        return "$" + value;
                                    }
                                }
                            }]
                    }
                }

            });

            var ctx = document.getElementById("myChart3");
            var myChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: meses,
                    datasets: [{
                            label: 'PRESUPUESTO MC',
                            backgroundColor: "rgba(81,113,175, 1)",
                            borderColor: "rgba(81,113,175, 1)",
                            data: pptoMCMat,
                            fill: false,
                        }, {
                            label: 'GASTO MC',
                            fill: false,
                            backgroundColor: "rgba(142, 169, 220, 1)",
                            borderColor: "rgba(142, 169, 220, 1)",
                            data: gastoMCMat,

                        },
                        {
                            label: 'PRESUPUESTO MP',
                            fill: false,
                            backgroundColor: "rgba(183,122,86, 1)",
                            borderColor: "rgba(183,122,86, 1)",
                            data: pptoMPMat,
                        }, {
                            label: 'GASTO MP',
                            fill: false,
                            backgroundColor: "rgba(245, 174, 132, 1)",
                            borderColor: "rgba(245, 174, 132, 1)",
                            data: gastoMPMat,

                        }, ]
                },
                options: {
                    responsive: true,
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                if (label) {
                                    label += ': $';
                                }
                                label += tooltipItem.yLabel || '';
                                return label;
                            }
                        }
                    },
                    scales: {
                        yAxes: [{
                                ticks: {
                                    // Include a dollar sign in the ticks
                                    callback: function (value, index, values) {
                                        return "$" + value;
                                    }
                                }
                            }]
                    }
                }

            });
        }
    });
}

function ocultarTarjetas(elemento, idDestino) {
    var tarjeta = elemento.id;
    switch (tarjeta) {
        case 'cardTRS':
            $("#cardTRS").show();
            $("#cardDetalles").show();
            $("#cardDetalles").addClass('animated fadeIn');
            $("#cardGP").hide();
            $("#cardZI").hide();
            var idPresupuesto = document.getElementById("idPresupuestoTRS").value;
            break;
        case 'cardGP':

            $("#cardTRS").hide();
            $("#cardGP").show();
            $("#cardDetalles").show();
            $("#cardZI").hide();
            var idPresupuesto = document.getElementById("idPresupuestoGP").value;
            break;
        case 'cardZI':
            $("#cardTRS").hide();
            $("#cardGP").hide();
            $("#cardZI").show();
            $("#cardDetalles").show();
            var idPresupuesto = document.getElementById("idPresupuestoZI").value;
            break;
        case 'btnDetalles':
            $("#cardTRS").show();
            $("#cardTRS").addClass('animated fadeIn');
            $("#cardGP").show();
            $("#cardGP").addClass('animated fadeIn');
            $("#cardZI").show();
            $("#cardZI").addClass('animated fadeIn');
            $("#cardDetalles").hide();
            var idPresupuesto = 0;
            break;
    }

    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: 'action=1&idPresupuesto=' + idPresupuesto + '&idDestino=' + idDestino + '&fase=' + tarjeta,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            //$("#tablaGastos").DataTable().clear();
            //$("#tablaGastos").DataTable().destroy();
            var ppto = JSON.parse(data);
            $("#tableBody").html(ppto.tablaGastos);
            $("#divPptoAnual").html(ppto.pptoAnual);
            $("#divPptos").html(ppto.pptoMensual);
        }
    });
}

function agregarGasto(idDestino, tipoGasto) {
    if (tipoGasto == 1) {
        var presupuesto = document.getElementById("cbPresupuesto").value;
        var cod2bend = document.getElementById("txtCod2Bend").value;
        var descripcion = document.getElementById("txtDescInterna").value;
        var tipo = document.getElementById("cbTipo").value;
        var fechaSol = document.getElementById("txtFechaSol").value;
        var fechaTentLlegada = document.getElementById("txtFechaTentLlegada").value;
        var gasto = document.getElementById("txtGasto").value;
        var seccion = document.getElementById("cbSeccion").value;
        var ubicacion = document.getElementById("cbUbicacion").value;
        var data = 'action=2&idPresupuesto=' + presupuesto + '&idDestino=' + idDestino + '&cod2bend=' + cod2bend
                + '&descripcion=' + descripcion + '&tipo=' + tipo + '&fechaSol=' + fechaSol + '&fechaTentLlegada=' + fechaTentLlegada +
                '&gasto=' + gasto + '&seccion=' + seccion + '&ubicacion=' + ubicacion + '&tipoGasto=' + tipoGasto;
    } else {
        var presupuesto = document.getElementById("cbPresupuestoSC").value;
        var descripcion = document.getElementById("txtDescInternaSC").value;
        var fechaAp = document.getElementById("txtFechaApr").value;
        var fechaTentInicio = document.getElementById("txtFechaPosibleInicioSC").value;
        var gasto = document.getElementById("txtGastoSub").value;
        var seccion = document.getElementById("cbSeccionSub").value;
        var ubicacion = document.getElementById("cbUbicacionSub").value;
        var data = 'action=2&idPresupuesto=' + presupuesto + '&idDestino=' + idDestino + '&cod2bend='
                + cod2bend + '&descripcion=' + descripcion + '&tipo=' + tipo + '&fechaAp=' + fechaAp + '&fechaTentInicio=' + fechaTentInicio +
                '&gasto=' + gasto + '&seccion=' + seccion + '&ubicacion=' + ubicacion + '&tipoGasto=' + tipoGasto;
    }





    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: data,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 11) {
                location.reload();
            } else {
                alert(data);
            }
        }
    });
}

function changeForm(form) {
    if (form == "m") {
        $("#btnSer").removeClass("active");
        $("#btnMat").addClass("active");
        $("#btnSub").removeClass("active");
        $("#formMateriales").show();
        $("#formSubcontrata").hide();
        $("#formServicios").hide();
    } else if (form == "s") {
        $("#btnSer").addClass("active");
        $("#btnMat").removeClass("active");
        $("#btnSub").removeClass("active");
        $("#formMateriales").hide();
        $("#formSubcontrata").hide();
        $("#formServicios").show();
    } else {
        $("#btnSer").removeClass("active");
        $("#btnMat").removeClass("active");
        $("#btnSub").addClass("active");
        $("#formMateriales").hide();
        $("#formSubcontrata").show();
        $("#formServicios").hide();
    }
}

function addNewItem() {
    $("#tableBodyAdd").append(
            "<tr>" +
            "<td><select name='tipo[]' class='form-control form-control-sm'><option value='1'>001 (Almacen)</option><option value='2'>002 (Externo)</option></select></td>" +
            "<td><input type='text' class='form-control form-control-ms' name='cod2bend[]' placeholder='Codigo 2Bend'></td>" +
            "<td><input type='text' class='form-control form-control-ms' name='descripcion[]' placeholder='Descripcion'></td>" +
            "<td><input type='text' class='form-control form-control-ms' name='cantidad[]' placeholder='Cantidad'></td>" +
            "<td><input type='text' class='form-control form-control-ms' name='importe[]' placeholder='Importe neto'></td>" +
            "<td><a href='#' class='ml-3' onclick='eliminar(this)'><img src='../svg/cerrarn.svg' width='10px'></a></td>" +
            "</tr>");
}

function addNewItemSC() {
    $("#tableBodyAddSC").append(
            "<tr>" +
            "<td><input type='text' class='form-control form-control-ms' name='descripcionSC[]' placeholder='Descripcion'></td>" +
            "<td><input type='text' class='form-control form-control-ms' name='cantidadSC[]' placeholder='Cantidad'></td>" +
            "<td><input type='text' class='form-control form-control-ms' name='importeSC[]' placeholder='Importe neto'></td>" +
            "<td><a href='#' class='ml-3' onclick='eliminar(this)'><img src='../svg/cerrarn.svg' width='10px'></a></td>" +
            "</tr>");
}

function addNewItemS() {
    $("#tableBodyAddS").append(
            "<tr>" +
            "<td><input type='text' class='form-control form-control-ms' name='descripcionSC[]' placeholder='Descripcion'></td>" +
            "<td><input type='text' class='form-control form-control-ms' name='cantidadSC[]' placeholder='Cantidad'></td>" +
            "<td><input type='text' class='form-control form-control-ms' name='importeSC[]' placeholder='Importe neto'></td>" +
            "<td><a href='#' class='ml-3' onclick='eliminar(this)'><img src='../svg/cerrarn.svg' width='10px'></a></td>" +
            "</tr>");
}
function eliminar(e) {
    $(e).parent().parent().fadeOut(400).remove();
    /**
     * el boton eliminar esta jerarquicamente asi:
     *      form > table > tr > td > input.eliminar
     * por esta razon se debe subir dos posiciones
     */
}

//Guardar orden de material
function guardar() {
    var idDestino = document.getElementById("hdnDestino").value;
    var tipoGasto = document.getElementById("hdnTipoGasto").value;
    var numDoc = document.getElementById("txtNumDoc").value;
    var fechaSol = document.getElementById("txtFechaSol").value;
    var fechaPosibleLlegada = document.getElementById("txtFechaPosibleLlegada").value;
    var proveedor = document.getElementById("cbProveedores").value;
    var presupuesto = document.getElementById("cbPresupuesto").value;
    var seccion = document.getElementById("cbSeccion").value;
    var ubicacion = document.getElementById("cbUbicacion").value;
    //NOTA: Recuerda SIMPRE VALIDAR los campos del formulario del lado del servidor y el cliente.
    //e.preventDefault()
    var res = $("form#frmItems").serializeArray();
    //console.log(res)//descomenta esta linea y mira la consola, así llegan nuestros datos,
    var nprod = res.length;
    var num_campos = 5;
    var cont = 0;

    var productos = [];//un array que contendra a los arrays (filas o productos)
    var producto = [];//array para cada una de las filas
    for (i = 0; i < nprod; i++) {//debe imprimer de 4 en 4 porque estan todos los inputs en un solo array

        //VALIDAR SIEMPRE
        producto.push(res[i].value);//esta linea agrega los datos a nuestro array

        if (cont < num_campos - 1) {
            cont++;
        } else {
            $("#result").append(" <br />");
            productos.push(producto);
            producto = [];
            cont = 0;
        }
    }

    var data = 'action=2&idDestino=' + idDestino + '&tipoGasto=' + tipoGasto + '&numDoc=' + numDoc + '&fechaSol=' + fechaSol
            + '&fechaPosibleLlegada=' + fechaPosibleLlegada + '&proveedor=' + proveedor + '&idPresupuesto=' + presupuesto + '&seccion=' + seccion + '&ubicacion=' + ubicacion
            + '&items=' + JSON.stringify(productos);
    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: data,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                alert("Gasto agregado");
                location.reload();
            } else {
                alert(data);
            }
        }
    });

}
//Guardar registro de subcontrata
function guardarSC() {
    var idDestino = document.getElementById("hdnDestino").value;
    var tipoGasto = document.getElementById("hdnTipoGastoSC").value;
    var numDoc = document.getElementById("txtNumDocSC").value;
    var fechaApr = document.getElementById("txtFechaApr").value;
    var fechaPosibleInicio = document.getElementById("txtFechaPosibleInicioSC").value;
    var proveedor = document.getElementById("txtProveedorSC").value;
    var presupuesto = document.getElementById("cbPresupuestoSC").value;
    var seccion = document.getElementById("cbSeccionSC").value;
    var ubicacion = document.getElementById("cbUbicacionSC").value;
    //NOTA: Recuerda SIMPRE VALIDAR los campos del formulario del lado del servidor y el cliente.
    //e.preventDefault()
    var res = $("form#frmItemsSC").serializeArray();
    //console.log(res)//descomenta esta linea y mira la consola, así llegan nuestros datos,
    var nprod = res.length;
    var num_campos = 3;
    var cont = 0;

    var productos = [];//un array que contendra a los arrays (filas o productos)
    var producto = [];//array para cada una de las filas
    for (i = 0; i < nprod; i++) {//debe imprimer de 4 en 4 porque estan todos los inputs en un solo array

        //VALIDAR SIEMPRE
        producto.push(res[i].value);//esta linea agrega los datos a nuestro array

        if (cont < num_campos - 1) {
            cont++;
        } else {
            $("#result").append(" <br />");
            productos.push(producto);
            producto = [];
            cont = 0;
        }
    }
    //productos es un array que contiene n arrays (n productos)
    var data = 'action=2&idDestino=' + idDestino + '&tipoGasto=' + tipoGasto + '&numDoc=' + numDoc + '&fechaSol=' + fechaApr
            + '&fechaPosibleLlegada=' + fechaPosibleInicio + '&proveedor=' + proveedor + '&idPresupuesto=' + presupuesto + '&seccion=' + seccion + '&ubicacion=' + ubicacion
            + '&items=' + JSON.stringify(productos);
    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: data,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                alert("Gasto agregado");
                location.reload();
            } else {
                alert(data);
            }
        }
    });

}
//Guardar registro de servicio
function guardarS() {
    var idDestino = document.getElementById("hdnDestino").value;
    var tipoGasto = document.getElementById("hdnTipoGastoS").value;
    var numDoc = document.getElementById("txtNumDocS").value;
    var fechaApr = document.getElementById("txtFechaAprS").value;
    var fechaPosibleInicio = document.getElementById("txtFechaPosibleInicioS").value;
    var proveedor = document.getElementById("txtProveedorS").value;
    var presupuesto = document.getElementById("cbPresupuestoS").value;
    var seccion = document.getElementById("cbSeccionS").value;
    var ubicacion = document.getElementById("cbAreaS").value;
    //NOTA: Recuerda SIMPRE VALIDAR los campos del formulario del lado del servidor y el cliente.
    //e.preventDefault()
    var res = $("form#frmItemsS").serializeArray();
    //console.log(res)//descomenta esta linea y mira la consola, así llegan nuestros datos,
    var nprod = res.length;
    var num_campos = 3;
    var cont = 0;

    var productos = [];//un array que contendra a los arrays (filas o productos)
    var producto = [];//array para cada una de las filas
    for (i = 0; i < nprod; i++) {//debe imprimer de 4 en 4 porque estan todos los inputs en un solo array

        //VALIDAR SIEMPRE
        producto.push(res[i].value);//esta linea agrega los datos a nuestro array

        if (cont < num_campos - 1) {
            cont++;
        } else {
            $("#result").append(" <br />");
            productos.push(producto);
            producto = [];
            cont = 0;
        }
    }
    //productos es un array que contiene n arrays (n productos)
    var data = 'action=2&idDestino=' + idDestino + '&tipoGasto=' + tipoGasto + '&numDoc=' + numDoc + '&fechaSol=' + fechaApr
            + '&fechaPosibleLlegada=' + fechaPosibleInicio + '&proveedor=' + proveedor + '&idPresupuesto=' + presupuesto + '&seccion=' + seccion + '&ubicacion=' + ubicacion
            + '&items=' + JSON.stringify(productos);
    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: data,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                alert("Gasto agregado");
                location.reload();
            } else {
                alert(data);
            }
        }
    });

}

function iniciar() {
    //alert("Hola Jquery")
    //si dan click a #newp ejecutar nuevo
    $("#btnAgregarGasto").on("click", guardar)
}

$(document).on("ready", iniciar)

function agregarPresupuesto(idDestino) {

    var ppto = $("#txtPpto").val();
    var mantto = $("#cbMantto").val();
    var año = $("#cbAño").val();
    if (ppto != "" && mantto != "" && año != "") {
        $.ajax({
            type: 'post',
            url: '../php/gastosPHP.php',
            data: 'action=3&idDestino=' + idDestino + '&ppto=' + ppto + '&año=' + año + '&mantto=' + mantto,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    location.reload();
                } else {
                    alert(data);
                }
            }
        });
    } else {
        alert("Llene los campos");
    }


//    var idDestino = document.getElementById("hdnDestinoPresupuesto").value;
//    var idFase = document.getElementById("cbFase").value;
//    var presupuesto = document.getElementById("txtPresupuesto").value;
//    var mes = document.getElementById("cbMes").value;
//    var año = document.getElementById("cbAño").value;
//
//    if (idFase != "" && presupuesto != "") {
//        $.ajax({
//            type: 'post',
//            url: '../php/gastosPHP.php',
//            data: 'action=3&idDestino=' + idDestino + '&idFase=' + idFase + '&presupuesto=' + presupuesto
//                    + '&mes=' + mes + '&año=' + año,
//            beforeSend: function () {
//                $(".loader").show();
//            },
//            success: function (data) {
//                $(".loader").fadeOut('slow');
//                if (data == 1) {
//                    location.reload();
//                } else {
//                    alert(data);
//                }
//            }
//
//        });
//    } else {
//        alert("Llene todos los campos");
//    }

}

function actualizarPresupuesto(idPpto, mantto) {
    if (event.keyCode == 13 || event.keyCode == 9) {
        if (mantto == "MC") {
            var ppto = $("#txtPptoMC").val();
        } else {
            var ppto = $("#txtPptoMP").val();
        }

        $.ajax({
            type: 'post',
            url: '../php/gastosPHP.php',
            data: 'action=8&idPresupuesto=' + idPpto + '&presupuesto=' + ppto + '&mantto=' + mantto,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    location.reload();
                } else {
                    alert(data);
                }
            }
        });
    }
}

function setPorcentaje(fase, element, idPpto, mantto) {
    var porc = element.value;
    if (event.keyCode == 13 || event.keyCode == 9) {
        $.ajax({
            type: 'post',
            url: '../php/gastosPHP.php',
            data: 'action=7&idPpto=' + idPpto + '&fase=' + fase + '&porc=' + porc + '&mantto=' + mantto,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                if (data == 1) {
                    location.reload();
                } else {
                    $(".loader").fadeOut();
                    alert(data);
                }
            }
        });
    }

}

function setPorcentajeMes(idPpto, element, idPptoMes, fase) {
    var porc = element.value;
    if (event.keyCode == 13 || event.keyCode == 9) {
        $.ajax({
            type: 'post',
            url: '../php/gastosPHP.php',
            data: 'action=9&idPpto=' + idPpto + '&idPptoMes=' + idPptoMes + '&porc=' + porc + '&fase=' + fase,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                if (data == 1) {
                    location.reload();
                } else {
                    $(".loader").fadeOut();
                    alert(data);
                }
            }
        });
    }

}

function cargarEntregasDestino() {
    var destino = document.getElementById("cbDestinos").value;
//    for (i = 0; i <= destino.length; i++) {
//        if (destino[i].checked) {
//            var idDestino = destino[i].value;
//            break;
//        }
//    }
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=34&idDestino=' + destino,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            location.reload();

        }
    });
}

function cargarAreas(element) {
    var idSeccion = element.value;

    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: 'action=5&idSeccion=' + idSeccion,

        success: function (data) {
            $(".loader").fadeOut('slow');
            $("#cbAreaS").html(data);
        }
    });
}

function actualizarGasto(idItem, element) {
    var tipoGasto = $("#hdnTipoGastoSedit").val();
    var campo = element.id;
    var fecha = element.value;
    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: 'action=6&idItem=' + idItem + '&campo=' + campo + '&fecha=' + fecha + '&tipoGasto=' + tipoGasto,

        success: function (data) {

        }
    });
}

function actualizarRegistroGasto() {
    location.reload();
}

function createDatepicker(element) {
    $("#" + element.id + "").datetimepicker({
        format: "L"
    });
}

function obtRegistro(idDocumento) {
    $.ajax({
        type: 'post',
        url: '../php/gastosPHP.php',
        data: 'action=4&idDocumento=' + idDocumento,
        success: function (data) {
            var pedido = JSON.parse(data);
            $("#hdnTipoGastoSedit").val(pedido.tipoGasto);
            $("#numDocumentoEdit").html(pedido.numeroDocumento);
            $("#fechaDocEdit").html(pedido.fechaSolicitud);
            $("#proveedorEdit").html(pedido.proveedor);
            $("#bodyItems").html(pedido.items);

        }
    });
}

function importarArchivoGastos(tipoGasto) {
    if (tipoGasto == "servicios") {
        var inputFile = document.getElementById("txtFileServicios");
    } else {
        var inputFile = document.getElementById("txtFileMateriales");
    }

    var file = inputFile.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('tipoGasto', tipoGasto);

    $.ajax({
        url: "../php/importar-gastos.php", // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
//            $("#sucesoBody").html(data);
            if (data == 1) {
                alert("Carga exitosa.");
                location.reload();
            } else {
                alert(data);
            }
        }
    });
}

function select(element) {
    var btn = element.id;
    var divSer = document.getElementById("divServicios");
    var divMat = document.getElementById("divMateriales");
    switch (btn) {
        case 'btnServicios':
            divSer.style.display = "block";
            divMat.style.display = "none";
            $("#btnServicios").addClass('active2');
            $("#btnMateriales").removeClass('active2');
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();

//            $($.fn.dataTable.tables(true)).css('width', '100%');
//            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();

            break;
        case 'btnMateriales':
            divSer.style.display = "none";
            divMat.style.display = "block";
            $("#btnServicios").removeClass('active2');
            $("#btnMateriales").addClass('active2');
            $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
//            $($.fn.dataTable.tables(true)).css('width', '100%');
//            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
            break;
    }
}