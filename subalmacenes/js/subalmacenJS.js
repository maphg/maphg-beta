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
        // console.log(response);
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
        // console.log('--' + response + '--');
        consultaSubalmacen();
        alertaImg(response, 'text-green-300', 'success', 3000);
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
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  console.log(idSubalmacen, idDestinoSeleccionado);
  const action = "consultaExistenciasSubalmacen";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idSubalmacen: idSubalmacen,
      palabraBuscar: palabraBuscar,
      idDestinoSeleccionado: idDestinoSeleccionado
    },
    dataType: "json",
    success: function (data) {
      $("#dataExistenciasSubalmacen").html(data.dataExistenciaSubalmacen);
      alertaImg(' Resultados Obtenidos: ' + data.totalResultados, 'text-orange-300', 'success', 3000);
      $("#nombreSubalmacen").html(data.nombreSubalmacen);
      $("#faseSubalmacen").html(data.faseSubalmacen);
      console.log(data);
    }
  });
}


// ****** Funciones para Salidas Subalmacénes y Carrito de Salidas. ******

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
  var cantidad_tmp = $('#' + idItem).val();
  var cantidad = parseFloat(cantidad_tmp);

  // console.log('Float 1: ', cantidad_tmp);
  // console.log('idItem : ', idItem);
  var cantidadActual = parseFloat(cantidadActual);
  // console.log('Float 2: ', cantidad);
  // console.log('cantidadActual: ', cantidadActual);
  if (cantidad > 0.000000000000001) {
    var cantidadValida = cantidadActual - cantidad;
    // console.log(cantidadValida);
    if (parseFloat(cantidadValida) >= 0.00) {
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
      alertaImg(' Cantidad No Suficiente 1 ' + Item, 'text-orange-300', 'question', 3000);
      $('#' + idItem).val(0.0);
    }
  } else {
    alertaImg(' Cantidad No Suficiente 2: ' + Item, 'text-orange-300', 'question', 3000);
  }
}


function consultaCarritoSalida(idDestino, idSubalmacen) {
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
      var cantidad = data.cantidadCarrito.split(',');
      var idItemCarrito = data.idItemCarrito.split(',');
      let numCallbackRuns = -1;
      cantidad.forEach((element) => {
        if (element > 0) {
          numCallbackRuns++;
          if (element > 0) {
            $('#' + idItemCarrito[numCallbackRuns]).val(element);
          } else {
            $('#' + idItemCarrito[numCallbackRuns]).val(0.0);
          }
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

// FUNCIÓN PARA RESTABLECER CARRITO.
function restablecerCarritoSalidasConfirmar() {
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  Swal.fire({
    toast: true,
    title: '¿Desea Eliminar los items del Carrito?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar'
  }).then((result) => {
    if (result.value) {
      restablecerCarritoSalidas(idDestinoSeleccionado, idSubalmacen)
    }
  })
}

function restablecerCarritoSalidas(idDestinoSeleccionado, idSubalmacen) {
  const action = "restablecerCarritoSalidas";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
      idSubalmacen: idSubalmacen
    },
    // dataType: "dataType",
    success: function (data) {
      alertaImg(data, '', 'success', 3000);
      $("#dataSalidasSubalmacen").html('');
      $("#modalSalidasSubalmacen").removeClass('open');

    }
  });
}
// FIN DE FUNCIONES PARA RESTABLECER CARRITO.


function carritoSalidaMotivo(paso) {
  let opcionSeleccionada = $("#carritoSalidaMotivo").val();
  let idDestino = $("#inputIdDestinoSeleccionado").val();


  if (paso == 'opcionSeccion') {
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
  } else if (paso == 'opcionSubseccion') {

    let idSeccion = $("#opcionSeccion").val();
    opcionSubseccion(idSeccion);
  } else if (paso == 'opcionEquipo') {
    if (opcionSeleccionada == "MCE") {
      opcionEquipo('MCE');
    } else if (opcionSeleccionada == "MP") {
      opcionEquipo('MP');
    } else if (opcionSeleccionada == "MCTG") {
      $("#carritoSalidaEquipo").html('');
      opcionPendientesTG();
    }

  } else if (paso == 'opcionPendiente') {
    if (opcionSeleccionada == "MCE") {
      opcionPendienteMCE();
    } else if (opcionSeleccionada == "MP") {
      opcionPendienteOT();
    }
  } else if (paso == 'opcionFinal') {
    alertaImg('Fin de Opciones', '', 'success', 3000);
  }


  function opcionSeccion(idDestino) {
    const action = "consultaOpcion";
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
        // console.log(data);
      }
    });
  }

  function opcionSubseccion(idSeccion) {
    const action = "consultaOpcion";

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
        // console.log(data);
      }
    });
  }

  function opcionEquipo(tipoPendiente) {
    let idSubseccion = $("#opcionSubseccion").val();
    let idSeccion = $("#opcionSeccion").val();
    const action = "consultaOpcion";
    $.ajax({
      type: "POST",
      url: "php/crud_subalmacen.php",
      data: {
        action: action,
        idDestino: idDestino,
        idSeccion: idSeccion,
        idSubseccion: idSubseccion,
        paso: paso,
        tipoPendiente: tipoPendiente
      },
      // dataType: "json",
      success: function (data) {
        $("#carritoSalidaEquipo").html(data);
        // console.log(data);
      }
    });
  }

  function opcionPendienteMCE() {
    let paso = "MCE";
    let idEquipo = $("#opcionEquipo").val();
    const action = "consultaOpcion";
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
        // console.log(data);
      }
    });
  }


  function opcionPendienteOT() {
    let paso = "MP";
    let idEquipo = $("#opcionEquipo").val();
    const action = "consultaOpcion";
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
        // console.log(data);
      }
    });
  }

  function opcionPendientesTG() {
    let paso = "MCTG";
    let idSubseccion = $("#opcionSubseccion").val();
    let idSeccion = $("#opcionSeccion").val();
    const action = "consultaOpcion";
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
      let contadorLogintud = 1;
      var registro = data.idRegistro.split(',');
      let longitudCarrito = registro.length;
      if (longitudCarrito > 0) {
        registro.forEach((idSalidaItem) => {
          if (idSalidaItem > 0) {
            confirmarCapturaSalida(idSalidaItem);
            contadorLogintud++;
            // console.log('Contador: ', contadorLogintud, ' Longitud: ', longitudCarrito);
          }
        });
      } else {
        alertaImg('Carrito Vacio', '', 'question', 3000);
      }
      // Función para Finalizar Carrito.
      function confirmarCapturaSalida(idSalidaItem) {
        let opcionEquipo = "0";
        let opcionMCE = "0";
        let opcionMP = "0";
        let opcionMCTG = "0";
        let opcionSalidaOtro = "NA";
        let opcionSalidaGift = "0";

        let carritoSalidaMotivo = $("#carritoSalidaMotivo").val();
        if (carritoSalidaMotivo == "GIFT") {
          opcionSalidaGift = $("#giftSalida").val();
          if (opcionSalidaGift > 0) {
            confirmarSalidaFinal();
          } else {
            justifiqueSalida();
          }
        } else if (carritoSalidaMotivo == "OTRO") {
          opcionSalidaOtro = $("#inputJustificacionOtro").val();
          if (opcionSalidaOtro != "") {
            confirmarSalidaFinal();
          } else {
            justifiqueSalida();
          }
        } else if (carritoSalidaMotivo == "MP") {
          opcionEquipo = $("#opcionEquipo").val();
          opcionMP = $("#opcionMP").val();
          if (opcionEquipo > 0 && opcionMP > 0) {
            confirmarSalidaFinal();
          } else {
            justifiqueSalida();
          }
        } else if (carritoSalidaMotivo == "MCE") {
          opcionEquipo = $("#opcionEquipo").val();
          opcionMCE = $("#opcionMCE").val();
          if (opcionEquipo > 0 && opcionMCE > 0) {
            confirmarSalidaFinal();
          } else {
            justifiqueSalida();
          }
        } else if (carritoSalidaMotivo == "MCTG") {
          opcionMCTG = $("#opcionMCTG").val();
          if (opcionMCTG > 0) {
            confirmarSalidaFinal();
          } else {
            justifiqueSalida();
          }
        } else {
          justifiqueSalida();
        }

        function justifiqueSalida() {
          alertaImg('Justifique la Salida', '', 'question', 3000);
        }

        function confirmarSalidaFinal() {
          $("#spinnerConfirmarSalida").removeClass('invisible');
          $("#confirmarSalidaCarrito").prop("disabled", true);
          $("#justifiacionSalidaCarrito").addClass('invisible');
          const action = "cerrarSalidaCarrito";
          $.ajax({
            type: "POST",
            url: "php/crud_subalmacen.php",
            data: {
              action: action,
              idSalidaItem: idSalidaItem,
              carritoSalidaMotivo: carritoSalidaMotivo,
              opcionEquipo: opcionEquipo,
              opcionMCE: opcionMCE,
              opcionMP: opcionMP,
              opcionMCTG: opcionMCTG,
              opcionSalidaOtro: opcionSalidaOtro,
              opcionSalidaGift: opcionSalidaGift
            },
            // dataType: "json",
            success: function (data) {
              alertaImg(data, 'text-orange-300', 'success', 3000);
              $("#confirmarSalidaCarrito").prop("disabled", false);
              $("#spinnerConfirmarSalida").removeClass('visible');
              $("#spinnerConfirmarSalida").addClass('invisible');
              $("#justifiacionSalidaCarrito").removeClass('invisible');
              recuperarCarrito();
            }
          });
        }
      }
    }
  });
}

// Función para Obtener idSubalmacen, Fase, Nombre Subalmacén.
function idSubalmacenSeleccionado(idSubalmacen, fase, nombre) {
  // Limpia los resultados obtenidos para no repetir el ID de los Inputs
  $("#dataSalidasSubalmacen").html('');
  $("#dataSubalmacenEntradas").html('');
  $("#dataMovimientos").html('');

  $("#inputIdSubalmacenSeleccionado").val(idSubalmacen);
  $("#subalmacenEntradasFase").val(fase);
  $("#subalmacenEntradasTitulo").val(nombre);

}

// ****** Funciones para Entradas Subalmacénes. *******

function entradasSubalmacen() {
  $("#modalSubalmacenEntradas").addClass('open');
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  let palabraBuscar = $("#inputPablabraBuscarEntradas").val();

  if (palabraBuscar == "") {
    palabraBuscar = "Vacio";
  } else {
    palabraBuscar = palabraBuscar;
  }

  const action = "consultaEntradasSubalmacen";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idSubalmacen: idSubalmacen,
      idDestinoSeleccionado: idDestinoSeleccionado,
      palabraBuscar: palabraBuscar
    },
    dataType: "json",
    success: function (data) {
      $("#dataSubalmacenEntradas").html(data.dataSubalmacenEntradas);
      $("#dataCarritoEntradas").html('');
      consultaEntradaCarrito();
    }
  });
}

function validarCantidadEntradaSubalmacen(idItemGlobal, idStock, descripcionItem, stockActual) {
  // $idSubalmacenItemsGlobales, $idSubalmacenItemsStock, '$descripcion', $stockActual
  let cantidadEntrada = $("#" + idItemGlobal).val();
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  cantidadEntrada = parseFloat(cantidadEntrada);

  if (cantidadEntrada > 0.0) {
    capturarEntraSubalmacenStock(idStock, idSubalmacen, idItemGlobal, cantidadEntrada, stockActual);
    // console.log(idStock, idSubalmacen, idItemGlobal, cantidadEntrada, stockActual);
  } else {
    alertaImg('Cantidad No Valida (' + cantidadEntrada + ')' + descripcionItem, '', 'question', 3000);
  }
}


function capturarEntraSubalmacenStock(idStock, idSubalmacen, idItemGlobal, cantidadEntrada, stockActual) {
  // console.log('Aqui');
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  const action = "capturarEntradaSubalmacenStock";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
      idStock: idStock,
      idSubalmacen: idSubalmacen,
      idItemGlobal: idItemGlobal,
      cantidadEntrada: cantidadEntrada,
      stockActual: stockActual
    },
    // dataType: "json",
    success: function (data) {
      if (data == 1) {
        alertaImg('Stock Agregado para Confirmar', '', 'success', 3000);
      } else {
        alertaImg('Intente de Nuevo', '', 'question', 3000);
      }
      // console.log(data);
    }
  });
}

function consultaEntradaCarrito() {
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  const action = "consultaEntradaCarrito";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
      idSubalmacen: idSubalmacen,
    },
    dataType: "json",
    success: function (data) {
      if (data.dataCarritoEntradas != "") {
        $("#dataCarritoEntradas").html(data.dataCarritoEntradas);
        $("#inputIndexEntradaCarrito").val(data.indexCantidadInput);
        $("#inputValueEntradaCarrito").val(data.valueCantidadInput);

        let indexCantidadInput = data.indexCantidadInput.split(';');
        let valueCantidadInput = data.valueCantidadInput.split(';');
        let contador = -1;
        indexCantidadInput.forEach(element => {
          contador++;
          if (element > 0) {
            var index = indexCantidadInput[contador];
            var value = valueCantidadInput[contador];
            $("#" + index).val(value);
          }
        });

      } else {
        alertaImg('Stock de Entradas, Vacio', '', 'question', 3000);
      }
    }
  });
}

function confirmarEntradaCarrito() {
  $("#dataCarritoEntradas").html('');
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  let indexCantidadInput = $("#inputIndexEntradaCarrito").val().split(';');
  let contador = -1;
  indexCantidadInput.forEach(element => {
    contador++;
    if (element > 0) {
      var index = indexCantidadInput[contador];
      console.log(index);
      finalizarEntradaCarrito(index, idSubalmacen, idDestinoSeleccionado);
    }
  });
}

function finalizarEntradaCarrito(idItemGlobal, idSubalmacen, idDestinoSeleccionado) {
  const action = "finalizarEntradaCarrito";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idItemGlobal: idItemGlobal,
      idSubalmacen: idSubalmacen,
      idDestinoSeleccionado: idDestinoSeleccionado
    },
    // dataType: "json",
    success: function (data) {
      console.log(data);
      if (data == 1) {
        alertaImg(' Entradas Finalizas', '', 'success', 3000);
        $("#" + idItemGlobal).val(0);
        toggleModalTailwind('modalSubalmacenEntradas');
      } else {
        alertaImg('Intente de Nuevo', '', 'warning', 3000);
      }
    }
  });
}


// Funciones para Movimientos Entre Bodegas.
function movimientoExistenciasItems() {
  $("#dataMovimientosCarrito").html('');
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  let palabraBuscar = $("#inputBuscarMovimientos").val();
  const action = "consultaMoverExistenciasItems";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idSubalmacen: idSubalmacen,
      idDestinoSeleccionado: idDestinoSeleccionado,
      palabraBuscar: palabraBuscar
    },
    dataType: "json",
    success: function (data) {
      if (data.dataSubalmacenMovimientos == "accesoDenegado") {
        $("#modalMoverItems").toggleClass('open');
        alertaImg('Acceso Denegado', '', 'danger', 5000);
        Swal.fire(
          'Acceso Denegado',
          '',
          'warning'
        )

      } else {
        $("#dataMovimientos").html(data.dataSubalmacenMovimientos);
        consultaMovimientoCarrito();
      }
      //  else {
      //   $("#dataMovimientos").html('');
      //   alertaImg('Intente de Nuevo', '', 'warning', 3000);
      // }
    }
  });
}

function validarCantidadMovimientoSubalmacen(idItemGlobal, idStock, descripcionItem, stockActual) {
  // $idSubalmacenItemsGlobales, $idSubalmacenItemsStock, '$descripcion', $stockActual
  var cantidadEntrada = $("#" + idItemGlobal).val();
  console.log('S;' + cantidadEntrada);
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  cantidadEntrada = parseFloat(cantidadEntrada);
  console.log('C;' + cantidadEntrada);

  if (cantidadEntrada >= 0.0) {
    if (cantidadEntrada <= stockActual) {
      capturarMovimientoSubalmacenStock(idStock, idSubalmacen, idItemGlobal, cantidadEntrada, stockActual);
    } else {
      alertaImg('Cantidad No Valida (' + cantidadEntrada + ')' + descripcionItem, '', 'question', 3000);
    }
  } else {
    alertaImg('Cantidad No Valida (' + cantidadEntrada + ')' + descripcionItem, '', 'question', 3000);
  }
}

function capturarMovimientoSubalmacenStock(idStock, idSubalmacen, idItemGlobal, cantidadEntrada, stockActual) {
  // console.log('Aqui');
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  const action = "capturarMovimientoSubalmacenStock";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
      idStock: idStock,
      idSubalmacen: idSubalmacen,
      idItemGlobal: idItemGlobal,
      cantidadEntrada: cantidadEntrada,
      stockActual: stockActual
    },
    // dataType: "json",
    success: function (data) {
      console.log(data);
      if (data != "error") {
        alertaImg('Stock' + data, '', 'success', 3500);
      } else {
        alertaImg('Intente de Nuevo', '', 'question', 3500);
      }
      // console.log(data);
    }
  });
}


function consultaMovimientoCarrito() {
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  const action = "consultaMovimientoCarrito";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
      idSubalmacen: idSubalmacen,
    },
    dataType: "json",
    success: function (data) {
      console.log(data);
      if (data.dataMovimientos != "") {

        $("#dataMovimientosCarrito").html(data.dataMovimientos);
        $("#opctionSubalmacenes").html(data.opcionesSubalmacenes);
        $("#subalmacenSeleccionado").html(data.seleccionadoSubalmacen);
        $("#inputIndexMovimientosCarrito").val(data.idRegistros);
        $("#inputID").val(data.index);

        let indexCantidadInput = data.index.split(';');
        let valueCantidadInput = data.value.split(';');
        let contador = -1;
        indexCantidadInput.forEach(element => {
          contador++;
          if (element > 0) {
            var index = indexCantidadInput[contador];
            var value = valueCantidadInput[contador];
            $("#" + index).val(value);
          }
        });

      } else {
        alertaImg('Stock de Entradas, Vacio', '', 'question', 3500);
      }
    }
  });
}

function confirmarMovimientoCarrito() {
  let idSubalmacen = $("#inputIdSubalmacenSeleccionado").val();
  let idOpcionSubalmacen = $("#idOpcionSubalmacenMovimientos").val();
  let seleccionadoSubalmacen = $("#idSubalmacenMovimientos").val();
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();

  if (idOpcionSubalmacen != "" && seleccionadoSubalmacen != "") {
    $("#dataCarritoEntradas").html('');
    let idRegistro = $("#inputIndexMovimientosCarrito").val().split(';');
    let idInput = $("#inputID").val().split(';');
    idRegistro.pop();
    idInput.pop();
    let longitudArray = idRegistro.length;
    console.log(idRegistro);
    console.log(longitudArray);
    let contador = -1;

    idRegistro.forEach(element => {
      contador++;
      console.log(element);
      if (contador >= 0) {
        // var idRegistro_aux = idRegistro[contador];
        var idItemGlobal = idInput[contador];
        console.log('*: ' + element, '*: ' + idItemGlobal);
        finalizarMovimientosCarrito(element, idOpcionSubalmacen, idDestinoSeleccionado, idItemGlobal);
      }
    });
  } else {
    alertaImg('Seleccione Subalmacén Destino', '', 'question', 3000);
  }
}

function finalizarMovimientosCarrito(idRegistro, idOpcionSubalmacen, idDestinoSeleccionado, idItemGlobal) {
  console.log(idRegistro, idOpcionSubalmacen, idDestinoSeleccionado, idItemGlobal);

  const action = "finalizarMovimientoCarrito";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
      idOpcionSubalmacen: idOpcionSubalmacen,
      idItemGlobal: idItemGlobal,
      idRegistro: idRegistro
    },
    // dataType: "json",
    success: function (data) {
      console.log(data);
      if (data == 2) {
        alertaImg('Se agrego Item con Stock', '', 'success', 3000);
        $("#" + idItemGlobal).val(0);
        $("#dataMovimientosCarrito").val('');
        $("#modalConfirmarMovimiento").removeClass('open');
        $("#modalExistenciasSubalmacen").removeClass('open');
        $("#modalSubalmacenEntradas").removeClass('open');
      } else if (data == 1) {
        alertaImg('Stock Actualizado', '', 'success', 3000);
        $("#" + idItemGlobal).val(0);
        $("#dataMovimientosCarrito").val('');
        $("#modalConfirmarMovimiento").removeClass('open');
        $("#modalExistenciasSubalmacen").removeClass('open');
        $("#modalSubalmacenEntradas").removeClass('open');
      } else {
        alertaImg('Intente de Nuevo', '', 'question', 3000);
      }
    }
  });
}

function activarBtnFinalizarMovimiento() {
  let opcionSubalmacen = $("#idOpcionSubalmacenMovimientos").val();
  let seleccionadoSubalmacen = $("#idSubalmacenMovimientos").val();
  if (opcionSubalmacen != "" && seleccionadoSubalmacen != "") {
    $("#btnFinalizarMovimiento").removeClass('invisible');

  } else {
    alertaImg('Seleccione Subalmacén Destino', '', 'question', 3000);
    $("#btnFinalizarMovimiento").addClass('invisible');
  }
}


// Funciones para mostrar todo los Items.

function obtenerTodosItemsGlobales() {
  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  let palabraBuscar = $("#inputPalabraBuscarTodo").val();

  const action = "consultaTodosItems";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
      palabraBuscar: palabraBuscar
    },
    dataType: "json",
    success: function (data) {
      $("#dataTodosItems").html(data.dataTodo);
      // console.log(data);
      $("#inputResultadosXLS").val(data.ItemsResultado);
    }
  });
}


function generarXLSItems(tipoXLS) {
  // event.preventDefault();

  // Aquí se almacena el ID de los Items con Busqueda.
  // let idItems = $("#inputResultadosXLS").val();
  // let idInput = idItems.split(';');
  // idInput.pop();

  let idDestinoSeleccionado = $("#inputIdDestinoSeleccionado").val();
  let idSubalmacenSeleccionado = $("#inputIdSubalmacenSeleccionado").val();
  let page = "";

  if (tipoXLS == "generalPorDestino") {
    page = 'php/GenerarExcel.php?idDestino=' + idDestinoSeleccionado;
    window.location = page;
  } else if (tipoXLS == "generarStock0") {
    page = 'php/GenerarExcel.php?idDestino=' + idDestinoSeleccionado + '&stock=0';
    window.location = page;
  } else if (tipoXLS == "generalPorSubalmacen") {
    page = 'php/GenerarExcel.php?idDestino=' + idDestinoSeleccionado + '&idSubalmacen=' + idSubalmacenSeleccionado;
    window.location = page;
  } else if (tipoXLS == "generalPorSubalmacenStock0") {
    page = 'php/GenerarExcel.php?idDestino=' + idDestinoSeleccionado + '&idSubalmacen=' + idSubalmacenSeleccionado + '&stock=0';
    window.location = page;
  }
}

// Función por Default, para mostrar subalmacén según la session.
consultaSubalmacen();


// Funciones de Prueba.
function obtnerValorHTML(id) {
  console.log($("#" + id).html());
}
function obtnerValorINPUT(id) {
  console.log($("#" + id).html());
}
