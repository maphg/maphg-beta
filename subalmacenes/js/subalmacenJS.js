// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';
// API PARA REPORTE DE ERRORES

const arrayDestino = { 1: "RM", 7: "CMU", 2: "PVR", 6: "MBJ", 5: "PUJ", 11: "CAP", 3: "SDQ", 4: "SSA", 10: "AME" };


function toggleModalTailwind(idModal) {
  $("#" + idModal).toggleClass('open');
}


// Funciones Principales para el Menu, donde se selecciona el destino.
(function () {
  let idDestinoDefault = localStorage.getItem('idDestino');
  $("#destinoSeleccionado").html(arrayDestino[idDestinoDefault]);
}());

function idDestinoSeleccionado(idDestinoSeleccionado) {
  $("#inputIdDestinoSeleccionado").val(idDestinoSeleccionado);
  $("#destinoSeleccionado").html(arrayDestino[idDestinoSeleccionado]);
}
// Fin de Funciones principales para seleccionar el menu.


function consultaSubalmacen() {
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
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
  let idSubalmacen = localStorage.getItem('idSubalmacen');
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
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  // console.log(idSubalmacen, idDestinoSeleccionado);
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
      // console.log(data);
    }
  });
}


// ****** Funciones para Salidas Subalmacénes y Carrito de Salidas. ******


// Función para Preparar Carrito.
function salidasSubalmacen() {
  $("#modalSalidasSubalmacen").addClass('open');
  let palabraBuscar = $("#inputPalabraBuscarSubalmacenSalida").val();
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let idSubalmacen = localStorage.getItem('idSubalmacen');

  document.getElementById("inputPalabraBuscarSubalmacenSalida").
    setAttribute('onkeyup', 'if(event.keyCode == 13) salidasSubalmacen()');

  const action = "consultaSalidaSubalmacen";
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
      $("#dataSalidasSubalmacen").html(data.dataSalidaSubalmacen);
      alertaImg(' Resultados Obtenidos: ' + data.totalResultados, '', 'success', 3000);
      $("#faseSalidaSubalmacen").html(data.faseSubalmacen);
      $("#nombreSalidaSubalmacen").html(data.nombreSubalmacen);
      $("#faseSalidaSubalmacen").html(data.nombreSubalmacen);
      consultaCarritoSalida(idDestinoSeleccionado, idSubalmacen);
    }
  });
}


function validarCantidaSalidaSubalmacen(idItem, Item, cantidadActual, idSubalmacen) {
  // idItem se refiera a idMaterial.
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let cantidad_tmp = $('#' + idItem).val();
  let cantidad = parseFloat(cantidad_tmp);

  if (cantidad >= 0.0) {
    // var cantidadValida = cantidadActual - cantidad;
    if (cantidadActual >= cantidad) {
      const action = "validarCantidaSalidaSubalmacen";
      $.ajax({
        type: "POST",
        url: "php/crud_subalmacen.php",
        data: {
          action: action,
          idDestinoSeleccionado: idDestinoSeleccionado,
          idItem: idItem,
          cantidadActual: cantidadActual,
          cantidad: cantidad,
          idSubalmacen: idSubalmacen
        },
        // dataType: "json",
        success: function (data) {
          consultaCarritoSalida(idDestinoSeleccionado, idSubalmacen);
          alertaImg(data + ' ' + Item, '', 'success', 3000);
        }
      });
    } else {
      alertaImg(' Cantidad No Suficiente ' + Item, '', 'question', 3000);
      // $('#' + idItem).val(0.0);
    }
  } else {
    alertaImg(' Cantidad NO Valida: ' + Item, '', 'question', 3000);
  }
}


function consultaCarritoSalida(idDestinoSeleccionado, idSubalmacen) {
  const action = "consultaCarritoSalida";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
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
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  consultaCarritoSalida(idDestinoSeleccionado, idSubalmacen);
}

// FUNCIÓN PARA RESTABLECER CARRITO.
function restablecerCarritoSalidasConfirmar() {
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let idSubalmacen = localStorage.getItem('idSubalmacen');
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
  let idDestino = localStorage.getItem('idDestino');


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
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let idSubalmacen = localStorage.getItem('idSubalmacen');

  var action = "consultaCarritoSalida";
  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestinoSeleccionado: idDestinoSeleccionado,
      idSubalmacen: idSubalmacen
    },
    dataType: "json",
    success: function (data) {
      console.log(data);
      let contadorLogintud = 1;
      var registro = data.idRegistro.split(',');
      let longitudCarrito = registro.length;
      if (longitudCarrito > 0) {
        registro.forEach((idRegistroSalida) => {
          if (idRegistroSalida > 0) {
            confirmarCapturaSalida(idRegistroSalida);
            contadorLogintud++;
          }
        });
      } else {
        alertaImg('Carrito Vacio', '', 'question', 3000);
      }
      // Función para Finalizar Carrito.
      function confirmarCapturaSalida(idRegistroSalida) {
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
              idRegistroSalida: idRegistroSalida,
              carritoSalidaMotivo: carritoSalidaMotivo,
              opcionEquipo: opcionEquipo,
              opcionMCE: opcionMCE,
              opcionMP: opcionMP,
              opcionMCTG: opcionMCTG,
              opcionSalidaOtro: opcionSalidaOtro,
              opcionSalidaGift: opcionSalidaGift,
              idDestinoSeleccionado: idDestinoSeleccionado
            },
            // dataType: "json",
            success: function (data) {
              alertaImg(data, 'text-orange-300', 'success', 3000);
              $("#confirmarSalidaCarrito").prop("disabled", false);
              $("#spinnerConfirmarSalida").removeClass('visible');
              $("#spinnerConfirmarSalida").addClass('invisible');
              $("#justifiacionSalidaCarrito").removeClass('invisible');
              recuperarCarrito();
              $("#modalSalidasSubalmacen").toggleClass('open');
            }
          });
        }
      }
    }
  });
}

document.getElementById("confirmarSalidaCarrito").addEventListener("click", () => {

  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let tipoSalida = document.getElementById("carritoSalidaMotivo").value;
  let OT = document.getElementById("OTSalida").value;
  console.log(tipoSalida, ' ', OT);
  const action = "finalizarCarrito";
  $.ajax({
    type: "GET",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestino: idDestino,
      idUsuario: idUsuario,
      idSubalmacen: idSubalmacen,
      tipoSalida: tipoSalida,
      OT: OT
    },
    dataType: "JSON",
    success: function (data) {
      if (data == 1) {
        alertaImg('Carrito Finalizado', 'text-orange-300', 'success', 3000);
        $("#confirmarSalidaCarrito").prop("disabled", false);
        $("#spinnerConfirmarSalida").removeClass('visible');
        $("#spinnerConfirmarSalida").addClass('invisible');
        $("#justifiacionSalidaCarrito").removeClass('invisible');
        recuperarCarrito();
        $("#modalSalidasSubalmacen").toggleClass('open');
      } else {
        alertaImg('Intente de Nuevo', '', 'success', 3000);
        recuperarCarrito();
      }
    }, error: function (err) {
      console.log(err);
    }
  });
})


// Función para Obtener idSubalmacen, Fase, Nombre Subalmacén.
function idSubalmacenSeleccionado(idSubalmacen, fase, nombre) {
  // Limpia los resultados obtenidos para no repetir el ID de los Inputs
  $("#dataSalidasSubalmacen").html('');
  $("#dataSubalmacenEntradas").html('');
  $("#dataMovimientos").html('');

  $("#inputIdSubalmacenSeleccionado").val(idSubalmacen);
  localStorage.setItem("idSubalmacen", idSubalmacen);
  $("#subalmacenEntradasFase").html(fase);
  $("#subalmacenEntradasTitulo").html(nombre);

}

// ****** Funciones para Entradas Subalmacénes. *******

function entradasSubalmacen() {
  $("#modalSubalmacenEntradas").addClass('open');
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let idSubalmacen = localStorage.getItem('idSubalmacen');
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
  let idSubalmacen = localStorage.getItem('idSubalmacen');
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
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
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
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
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
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let indexCantidadInput = $("#inputIndexEntradaCarrito").val().split(';');
  let contador = -1;
  indexCantidadInput.forEach(element => {
    contador++;
    if (element > 0) {
      var index = indexCantidadInput[contador];
      // console.log(index);
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
      // console.log(data);
      if (data == 1) {
        alertaImg(' Entradas Finalizas', '', 'success', 3000);
        // $("#" + idItemGlobal).val(0);
        $('#modalSubalmacenEntradas').removeClass('open');
        $('#modalConfirmacionEntradas').removeClass('open');
      } else {
        alertaImg('Intente de Nuevo', '', 'warning', 3000);
      }
    }
  });
}

// FUNCIÓN PARA RESTABLECER CARRITO.
function restablecerCarritoEntradasConfirmar() {
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let idSubalmacen = localStorage.getItem('idSubalmacen');
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
      restablecerCarritoEntradas(idDestinoSeleccionado, idSubalmacen)
    }
  })
}

function restablecerCarritoEntradas(idDestinoSeleccionado, idSubalmacen) {
  const action = "restablecerCarritoEntradas";
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
      $("#dataSubalmacenEntradas").html('');
      $("#modalSubalmacenEntradas").removeClass('open');

    }
  });
}
// FIN DE FUNCIONES PARA RESTABLECER CARRITO.


// Funciones para Movimientos Entre Bodegas.
function movimientoExistenciasItems() {
  $("#dataMovimientosCarrito").html('');
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
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
  // console.log('S;' + cantidadEntrada);
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  cantidadEntrada = parseFloat(cantidadEntrada);
  // console.log('C;' + cantidadEntrada);

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
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
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
      // console.log(data);
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
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idDestinoSeleccionado = localStorage.getItem('idDestino');
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
      // console.log(data);
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
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idOpcionSubalmacen = $("#idOpcionSubalmacenMovimientos").val();
  let seleccionadoSubalmacen = $("#idSubalmacenMovimientos").val();
  let idDestinoSeleccionado = localStorage.getItem('idDestino');

  if (idOpcionSubalmacen != "" && seleccionadoSubalmacen != "") {
    $("#dataCarritoEntradas").html('');
    let idRegistro = $("#inputIndexMovimientosCarrito").val().split(';');
    let idInput = $("#inputID").val().split(';');
    idRegistro.pop();
    idInput.pop();
    let longitudArray = idRegistro.length;
    // console.log(idRegistro);
    // console.log(longitudArray);
    let contador = -1;

    idRegistro.forEach(element => {
      contador++;
      // console.log(element);
      if (contador >= 0) {
        // var idRegistro_aux = idRegistro[contador];
        var idItemGlobal = idInput[contador];
        // console.log('*: ' + element, '*: ' + idItemGlobal);
        finalizarMovimientosCarrito(element, idOpcionSubalmacen, idDestinoSeleccionado, idItemGlobal);
      }
    });
  } else {
    alertaImg('Seleccione Subalmacén Destino', '', 'question', 3000);
  }
}

function finalizarMovimientosCarrito(idRegistro, idOpcionSubalmacen, idDestinoSeleccionado, idItemGlobal) {
  // console.log(idRegistro, idOpcionSubalmacen, idDestinoSeleccionado, idItemGlobal);

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
      // console.log(data);
      if (data == 2) {

        alertaImg('Se agrego Item con Stock', '', 'success', 3000);
        $("#" + idItemGlobal).val(0);
        $("#dataMovimientosCarrito").val('');
        // $("#modalConfirmarMovimiento").removeClass('open');
        $("#modalExistenciasSubalmacen").removeClass('open');
        $("#modalSubalmacenEntradas").removeClass('open');
        $("#modalMoverItems").removeClass('open');
        $("#dataMovimientosCarrito").html('');
      } else if (data == 1) {
        alertaImg('Stock Actualizado', '', 'success', 3000);
        $("#" + idItemGlobal).val(0);
        $("#dataMovimientosCarrito").val('');
        // $("#modalConfirmarMovimiento").removeClass('open');
        $("#modalExistenciasSubalmacen").removeClass('open');
        $("#modalSubalmacenEntradas").removeClass('open');
        $("#modalMoverItems").removeClass('open');
        $("#dataMovimientosCarrito").html('');
      } else {
        alertaImg('No se ha encontrado la OT', '', 'question', 3000);
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
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let palabraBuscar = document.getElementById("inputPalabraBuscarTodo").value;
  let contenedor = document.getElementById('dataTodosItems');

  const action = "consultaTodosItems";
  const URL = `php/crud_subalmacen.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&palabraBuscar=${palabraBuscar}`;
  console.log(URL);
  fetch(URL)
    .then(array => array.json())
    .then(array => {
      console.log(array);
      contenedor.innerHTML = '';

      if (array.length > 0) {
        for (let x = 0; x < array.length; x++) {
          const estilo = array[x].estilo;
          const categoria = array[x].categoria;
          const cod2bend = array[x].cod2bend;
          const gremio = array[x].gremio;
          const descripcion = array[x].descripcion;
          const caracteristicas = array[x].caracteristicas;
          const marca = array[x].marca;
          const stockTeorico = array[x].stockTeorico;
          const stockActual = array[x].stockActual;
          const unidad = array[x].unidad;
          const ubicacion = array[x].ubicacion;

          const codigo = `
            <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 rounded hover:bg-indigo-100 cursor-pointer text-center ${estilo}">
                <div class="w-32 flex h-full items-center justify-center truncate">
                    <h1>${categoria}</h1>
                </div>
                <div class="w-32 flex h-full items-center justify-center truncate">
                    <h1>${cod2bend}</h1>
                </div>
                <div class="w-32 flex h-full items-center justify-center truncate">
                    <h1>${gremio}</h1>
                </div>
                <div class="w-64 flex h-full items-center justify-center truncate">
                    <h1>${descripcion}</h1>
                </div>
                <div class="w-64 flex h-full items-center justify-center truncate">
                    <h1>${caracteristicas}</h1>
                </div>
                <div class="w-64 flex h-full items-center justify-center truncate">
                    <h1>${marca}</h1>
                </div>
                <div class="w-32 flex h-full items-center justify-center truncate">
                    <h1>${stockTeorico}</h1>
                </div>
                <div class="w-32 flex h-full items-center justify-center truncate">
                    <h1>${stockActual}</h1>
                </div>
                <div class="w-32 flex h-full items-center justify-center truncate">
                    <h1>${unidad}</h1>
                </div>
                <div class="w-64 flex h-full items-center justify-center truncate">
                    <h1>${ubicacion}</h1>
                </div>
            </div>         
          `;
          contenedor.insertAdjacentHTML('beforeend', codigo);
        }
      }
    })
    .catch(function (err) {
      fetch(APIERROR + err);
      contenedor.innerHTML = '';
    })


}


// FUNCION PARA OBTENER LAS OPCIONES DE LOS ITEMS
function modalAgregarItem(idSubalmacen) {
  document.getElementById("modalAgregarItem").classList.add('open');
  localStorage.setItem("idSubalmacen", idSubalmacen);
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  const action = "consultarOpcionesItem";
  const URL = `php/crud_subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

  document.getElementById("btnAgregarItems").
    setAttribute('onclick', 'agregarItems(' + idSubalmacen + ');');

  let contenedorMarca = document.getElementById("marcaItems");
  let contenedorGremio = document.getElementById("gremioItems");
  let contenedorUnidad = document.getElementById("unidadItems");

  console.log(URL);
  fetch(URL)
    .then(array => array.json())
    .then(array => {

      contenedorMarca.innerHTML = '';
      contenedorGremio.innerHTML = '';
      contenedorUnidad.innerHTML = '';

      if (array.marcas.length > 0) {
        for (let x = 0; x < array.marcas.length; x++) {
          const idMarca = array.marcas[x].idMarca;
          const marca = array.marcas[x].marca;
          const codigo = `<option value="${marca}">${marca}</option>`;
          contenedorMarca.insertAdjacentHTML('beforeend', codigo);
        }
      }

      if (array.gremios.length > 0) {
        for (let x = 0; x < array.gremios.length; x++) {
          const idGremio = array.gremios[x].idGremio;
          const gremio = array.gremios[x].gremio;
          const codigo = `<option value="${idGremio}">${gremio}</option>`;
          contenedorGremio.insertAdjacentHTML('beforeend', codigo);
        }
      }

      if (array.unidades.length > 0) {
        for (let x = 0; x < array.unidades.length; x++) {
          const idUnidad = array.unidades[x].idUnidad;
          const unidad = array.unidades[x].unidad;
          const codigo = `<option value="${unidad}">${unidad}</option>`;
          contenedorUnidad.insertAdjacentHTML('beforeend', codigo);
        }
      }

    })
    .catch(function (err) {
      contenedorMarca.innerHTML = '';
      contenedorGremio.innerHTML = '';
      contenedorUnidad.innerHTML = '';

      fetch(APIERROR + err + ` modalAgregarItem(${idSubalmacen})`);
    })
}


// FUNCION PARA AGREGAR ITEMS
function agregarItems(idSubalmacen) {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let marca = document.getElementById("marcaItems").value;
  let gremio = document.getElementById("gremioItems").value;
  let unidad = document.getElementById("unidadItems").value;
  let descripcion = document.getElementById("descripcionItems").value;
  let caracteristicas = document.getElementById("caracteristicasItems").value;
  let cod2bend = document.getElementById("cod2bendItems").value;
  let categoria = document.getElementById("categoriaItems").value;
  let stockTeorico = document.getElementById("stockTeoricoItems").value;
  let stockActual = document.getElementById("stockActualItems").value;

  const action = "agregarItems";
  const URL = `php/crud_subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}&marca=${marca}&gremio=${gremio}&unidad=${unidad}&descripcion=${descripcion}&caracteristicas=${caracteristicas}&cod2bend=${cod2bend}&categoria=${categoria}&stockTeorico=${stockTeorico}&stockActual=${stockActual}`;

  if (
    marca != "" && gremio != "" && unidad != "" && descripcion != "" && caracteristicas != "" && cod2bend != "" && categoria != "" && stockTeorico != "" && stockActual != ""
  ) {
    fetch(URL)
      .then(array => array.json())
      .then(array => {
        console.log(array);
        if (array == 1) {
          document.getElementById("modalAgregarItem").classList.remove('open');
          alertaImg('Item Agregado', '', 'success', 1200);

          document.getElementById("descripcionItems").value = '';
          document.getElementById("caracteristicasItems").value = '';
          document.getElementById("cod2bendItems").value = '';
          document.getElementById("categoriaItems").value = '';
          document.getElementById("stockTeoricoItems").value = '';
          document.getElementById("stockActualItems").value = '';
        } else {
          alertaImg('Intente de Nuevo', '', 'info', 1200);
        }
      })
      .catch(function (err) {
        fetch(APIERROR + err + `modalAgregarItem(${idSubalmacen})`);
      })
  } else {
    alertaImg('Datos Incorrectos', '', 'info', 1200);
  }
}


function generarXLSItems(tipoXLS) {
  // event.preventDefault();

  // Aquí se almacena el ID de los Items con Busqueda.
  // let idItems = $("#inputResultadosXLS").val();
  // let idInput = idItems.split(';');
  // idInput.pop();

  let idDestinoSeleccionado = localStorage.getItem('idDestino');
  let idSubalmacenSeleccionado = localStorage.getItem('idSubalmacen');
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


document.getElementById("destinosSelecciona").addEventListener("click", consultaSubalmacen);