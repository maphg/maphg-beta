// Ejemplo para llamar a la función de las alertas.
// alertaImg('Item Agredado correctament!', 'has-text-danger', 'error', 3000)
//                      msj                         color-text  icon    time

const arrayDestino = { 1: "RM", 7: "CMU", 2: "PVR", 6: "MBJ", 5: "PUJ", 11: "CAP", 3: "SDQ", 4: "SSA", 10: "AME" };

function toggleModalTailwind(idModal) {
    $("#" + idModal).toggleClass('open');

    if (idModal == "modalCarritoSalidas") {
        $("#modalSalidasSubalmacen").addClass('open');
    }
}


// Funciones Principales para el Menu, donde se selecciona el destino.
(function () {
    let idDestinoDefault = $("#inputIdDestinoSeleccionado").val();
    $("#destinoSeleccionado").html(arrayDestino[idDestinoDefault]);
}());

function idDestinoSeleccionado(idDestinoSeleccionado) {
    $("#inputIdDestinoSeleccionado").val(idDestinoSeleccionado);
    $("#destinoSeleccionado").html(arrayDestino[idDestinoSeleccionado]);
}
// Fin de Funciones principales para seleccionar el menu.


function consultaSubalmacen() {
    let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
    const action = "consultaSubalmacen";

    $.ajax({
        type: "POST",
        url: "php/crud_subalmacen.php",
        data: {
            action: action,
            idDestinoSeleccionado: idDestinoSeleccionado
        },
        dataType: 'JSON',
        success: function (data) {
            $("#subalmacenGP").html(data.dataGP);
            $("#subalmacenTRS").html(data.dataTRS);
            $("#subalmacenZI").html(data.dataZI);
        }
    });
}


function eliminarSubalmacen(idSubalmacen = 0, nombre = 'error') {
    // Cambiar la accion cuando se finalice (eliminarSubalmacen), porque hay otro metodo con el mismo nombre.
    const action = "eliminar_Subalmacen";

    Swal.fire({
        title: '¿Eliminar Subalmacén: ' + nombre + '?',
        // text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Subalmacén Eliminado!',
                // 'Your file has been deleted.',
                'success',
                eliminarSubalmacenConfirmado()
            )
        }
    })
    function eliminarSubalmacenConfirmado() {

        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idSubalmacen: idSubalmacen
            },
            // dataType: "json",
            success: function (response) {
                console.log(response);
                consultaSubalmacen();
            }
        });
    }
}



// Función para obtener la fase donde se va agregar el subalmacén. 
function agregarSubalmacenFase(fase) {
    $("#inputFaseSubalmacen").val(fase);
    $("#faseSubalmacen").val(fase);
}


// Función para agregar el subalmacén.
function agregarSubalmacen() {
    var fase = $("#inputFaseSubalmacen").val();
    var titulo = $("#inputTituloSubalmacen").val();
    const action = "agregarSubalmacen";

    if (titulo.length > 1 && fase != "") {
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                fase: fase,
                titulo: titulo
            },
            // dataType: "json",
            success: function (response) {
                consultaSubalmacen();
                alertaImg(response, 'text-green-600', 'success', 3000);
                $("#inputTituloSubalmacen").val('');
                toggleModal('modalAgregarSubalmacen');
            }
        });
    } else {
        alertaImg('Información NO Valida', 'text-yellow-600', 'error', 3000);
    }
}


async function editarSubalmacen(idSubalmacen, nombre) {

    const { value: tituloSubalmacen } = await Swal.fire({
        title: 'Actualizar Subalmacén',
        text: nombre,
        input: 'text',
        inputValue: nombre,
        inputPlaceholder: 'Nuevo Título',
        // showCancelButton: true,
        allowOutsideClick: false
    })

    if (tituloSubalmacen !== "") {
        const action = "editarSubalmacen";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idSubalmacen: idSubalmacen,
                tituloSubalmacen: tituloSubalmacen
            },
            success: function (response) {
                console.log('--' + response + '--');
                consultaSubalmacen();
                alertaImg(response, 'text-green-300', 'success', 300000);
            }
        });
    }
}


// Función para buscar un Item de Subalmacén.
function busquedaExisenciaSubalmacen() {
    let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
    let palabraBuscar = $("#inputPalabraBuscarSubalmacen").val();

    if (palabraBuscar != "") {
        consultaExistenciasSubalmacen(idSubalmacen, palabraBuscar);
        recuperarCarrito();
    } else {
        consultaExistenciasSubalmacen(idSubalmacen, '');
        recuperarCarrito();
    }
}


function consultaExistenciasSubalmacen(idSubalmacen, palabraBuscar) {
    $("#modalExistenciasSubalmacen").addClass('open');
    $("#inputIdSubalmacenSeleccionado").val(idSubalmacen);
    const action = "consultaExistenciasSubalmacen";
    $.ajax({
        type: "POST",
        url: "php/crud_subalmacen.php",
        data: {
            action: action,
            idSubalmacen: idSubalmacen,
            palabraBuscar: palabraBuscar
        },
        dataType: "json",
        success: function (data) {
            $("#dataExistenciasSubalmacen").html(data.dataExistenciaSubalmacen);
            alertaImg(' Resultados Obtenidos: ' + data.totalResultados, 'text-orange-300', 'success', 3000);
            $("#nombreSubalmacen").html(data.nombreSubalmacen);
            $("#faseSubalmacen").html(data.faseSubalmacen);
        }
    });
}


// Función para buscar un Item de Subalmacén Salidas.
function inputBusquedaExisenciaSubalmacen() {
    let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
    let palabraBuscar = $("#inputPalabraBuscarSubalmacenSalida").val();

    if (palabraBuscar != "") {
        salidasSubalmacen(idSubalmacen, palabraBuscar);
    } else {
        salidasSubalmacen(idSubalmacen, '');
    }
}

// Función para Preparar Carrito.
function salidasSubalmacen(idSubalmacen, palabraBuscar) {
    let idDestino = $("#inputIdDestinoSeleccionado").val();
    $("#modalSalidasSubalmacen").addClass('open');
    $("#inputIdSubalmacenSeleccionado").val(idSubalmacen);
    const action = "consultaSalidaSubalmacen";
    $.ajax({
        type: "POST",
        url: "php/crud_subalmacen.php",
        data: {
            action: action,
            idSubalmacen: idSubalmacen,
            palabraBuscar: palabraBuscar
        },
        dataType: "json",
        success: function (data) {
            $("#dataSalidasSubalmacen").html(data.dataSalidaSubalmacen);
            alertaImg(' Resultados Obtenidos: ' + data.totalResultados, 'text-orange-300', 'success', 3000);
            $("#nombreSalidaSubalmacen").html(data.nombreSubalmacen);
            $("#faseSalidaSubalmacen").html(data.faseSubalmacen);
            consultaCarritoSalida(idDestino, idSubalmacen);
        }
    });
}


function validarCantidaSalidaSubalmacen(idItem, Item, cantidadActual, idSubalmacen) {
    // idItem se refiera a idMaterial.
    var cantidad = $('#' + idItem).val();
    var cantidadValida = parseInt(cantidadActual) - parseInt(cantidad);
    if (cantidadValida >= 0) {
        const action = "validarCantidaSalidaSubalmacen";
        let idDestino = $("#inputIdDestinoSeleccionado").val();
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idDestino: idDestino,
                idItem: idItem,
                cantidadActual: cantidadActual,
                cantidad: cantidad,
                idSubalmacen: idSubalmacen
            },
            // dataType: "json",
            success: function (data) {
                consultaCarritoSalida(idDestino, idSubalmacen);
                alertaImg(data + ' ' + Item, 'text-orange-300', 'success', 3000);
            }
        });
    } else {
        alertaImg(' Cantidad No Valida' + Item, 'text-orange-300', 'question', 3000);
        $('#' + idItem).val('');
    }
}


function consultaCarritoSalida(idDestino, idSubalmacen) {
    console.log(idDestino, idSubalmacen);
    const action = "consultaCarritoSalida";
    $.ajax({
        type: "POST",
        url: "php/crud_subalmacen.php",
        data: {
            action: action,
            idDestino: idDestino,
            idSubalmacen: idSubalmacen
        },
        dataType: "json",
        success: function (data) {
            $("#dataCarritoSalidas").html(data.dataCarritoSalidas);
            console.log('Array-', data.cantidadCarrito);

            var cantidad = data.cantidadCarrito.split(',');
            var idItemCarrito = data.idItemCarrito.split(',');
            console.log(cantidad[0]);
            let numCallbackRuns = -1;
            cantidad.forEach((element) => {
                console.log(element)
                if (element > 0) {
                    numCallbackRuns++;
                    console.log('Elemento Mayor' + element);
                    $('#' + idItemCarrito[numCallbackRuns]).val(element);
                }
            });
        }
    });
}


function recuperarCarrito() {
    let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
    let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
    consultaCarritoSalida(idDestinoSeleccionado, idSubalmacen);
}


function carritoSalidaMotivo(paso) {
    let opcionSeleccionada = $("#carritoSalidaMotivo").val();
    let idDestino = $("#inputIdDestinoSeleccionado").val();


    if (paso == 'paso1') {
        $("#opcionSalidaOtro").addClass('hidden');
        $("#opcionSalidaGift").addClass('hidden');
        $("#carritoSalidaSeccion").html('');
        $("#carritoSalidaSubseccion").html('');
        $("#carritoSalidaEquipo").html('');
        $("#carritoSalidaPendiente").html('');

        if (opcionSeleccionada == "MP") {
            opcionSeccion(idDestino);
        } else if (opcionSeleccionada == "MCE") {
            opcionSeccion(idDestino);
        } else if (opcionSeleccionada == "MCTG") {
            opcionSeccion(idDestino);
        } else if (opcionSeleccionada == "GIFT") {
            $("#opcionSalidaGift").removeClass('hidden');
        } else if (opcionSeleccionada == "OTRO") {
            $("#opcionSalidaOtro").removeClass('hidden');
        }
    } else if (paso == 'paso2') {

        let idSeccion = $("#opcionSeccion").val();
        opcionSubseccion(idSeccion);
    } else if (paso == 'paso3') {
        if (opcionSeleccionada == "MCE") {
            opcionEquipo();
        } else if (opcionSeleccionada == "MP") {
            opcionEquipo();
        } else if (opcionSeleccionada == "MCTG") {
            $("#carritoSalidaEquipo").html('');
            opcionTG();
        }

    } else if (paso == 'paso4') {
        if (opcionSeleccionada == "MCE") {
            opcionPendienteMCE();
        } else if (opcionSeleccionada == "MP") {
            opcionPendienteOT();
        }
    }


    function opcionSeccion(idDestino) {
        const action = "consultaSeccion";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idDestino: idDestino,
                paso: paso
            },
            // dataType: "json",
            success: function (data) {
                $("#carritoSalidaSeccion").html(data);
                console.log(data);
            }
        });
    }

    function opcionSubseccion(idSeccion) {
        const action = "consultaSeccion";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idDestino: idDestino,
                idSeccion: idSeccion,
                paso: paso
            },
            // dataType: "json",
            success: function (data) {
                $("#carritoSalidaSubseccion").html(data);
                console.log(data,);
            }
        });
    }

    function opcionEquipo() {
        let idSubseccion = $("#opcionSubseccion").val();
        let idSeccion = $("#opcionSeccion").val();
        const action = "consultaSeccion";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idDestino: idDestino,
                idSeccion: idSeccion,
                idSubseccion: idSubseccion,
                paso: paso
            },
            // dataType: "json",
            success: function (data) {
                $("#carritoSalidaEquipo").html(data);
                console.log(data);
            }
        });
    }

    function opcionPendienteMCE() {
        let paso = "MCE";
        let idEquipo = $("#opcionEquipo").val();
        const action = "consultaSeccion";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idDestino: idDestino,
                idEquipo: idEquipo,
                paso: paso
            },
            // dataType: "json",
            success: function (data) {
                $("#carritoSalidaPendiente").html(data);
                console.log(data);
            }
        });
    }

    function opcionPendiente() {
        let paso = "MP";
        let idEquipo = $("#opcionEquipo").val();
        const action = "consultaSeccion";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idDestino: idDestino,
                idEquipo: idEquipo,
                paso: paso
            },
            // dataType: "json",
            success: function (data) {
                $("#carritoSalidaPendiente").html(data);
                console.log(data);
            }
        });
    }

    function opcionPendienteOT() {
        let paso = "MP";
        let idEquipo = $("#opcionEquipo").val();
        const action = "consultaSeccion";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idDestino: idDestino,
                idEquipo: idEquipo,
                paso: paso
            },
            // dataType: "json",
            success: function (data) {
                $("#carritoSalidaPendiente").html(data);
                console.log(data);
            }
        });
    }

    function opcionTG() {
        let paso = "pasoTG";
        let idSubseccion = $("#opcionSubseccion").val();
        let idSeccion = $("#opcionSeccion").val();
        const action = "consultaSeccion";
        $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
                action: action,
                idDestino: idDestino,
                idSubseccion: idSubseccion,
                idSeccion: idSeccion,
                paso: paso
            },
            // dataType: "json",
            success: function (data) {
                $("#carritoSalidaPendiente").html(data);
            }
        });
    }

}


function confirmarSalidaCarrito() {
    let idDestino = $("#inputIdDestinoSeleccionado").val();
    let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();

    var action = "consultaCarritoSalida";
    $.ajax({
        type: "POST",
        url: "php/crud_subalmacen.php",
        data: {
            action: action,
            idDestino: idDestino,
            idSubalmacen: idSubalmacen
        },
        dataType: "json",
        success: function (data) {
            var registro = data.idRegistro.split(',');
            registro.forEach((idSalidaItem) => {
                if (idSalidaItem > 0) {
                    $("#spinnerConfirmarSalida").removeClass('invisible');
                    $("#confirmarSalidaCarrito").prop("disabled", true);
                    confirmarCapturaSalida(idSalidaItem);


                }
            });
            // Función para Finalizar Carrito.
            function confirmarCapturaSalida(idSalidaItem) {
                const action = "cerrarSalidaCarrito";
                $.ajax({
                    type: "POST",
                    url: "php/crud_subalmacen.php",
                    data: {
                        action: action,
                        idSalidaItem: idSalidaItem
                    },
                    // dataType: "json",
                    success: function (data) {
                        alertaImg(data, 'text-orange-300', 'success', 3000);
                        $("#confirmarSalidaCarrito").prop("disabled", false);
                        $("#spinnerConfirmarSalida").removeClass('visible');
                        $("#spinnerConfirmarSalida").addClass('invisible');
                        recuperarCarrito();
                        busquedaExisenciaSubalmacen();
                    }
                });
            }
        }
    });


    let opcion = $("#carritoSalidaMotivo").val();
}

// Función por Default, para mostrar subalmacén según la session.
consultaSubalmacen();