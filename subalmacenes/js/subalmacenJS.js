// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';
// API PARA REPORTE DE ERRORES

// INPUTS
const inputPablabraBuscarEntradas = document.getElementById("inputPablabraBuscarEntradas");
const inputPalabraBuscarSalida = document.getElementById("inputPalabraBuscarSalida");
const inputPalabraExistencias = document.getElementById("inputPalabraExistencias");
const motivoSalidaCarrito = document.getElementById("motivoSalidaCarrito");
const OTSalida = document.getElementById("OTSalida");
const cod2bendItem = document.getElementById("cod2bendItem");
const seccionItem = document.getElementById("seccionItem");
const descripcionCod2bendItem = document.getElementById("descripcionCod2bendItem");
const SSTItem = document.getElementById("SSTItem");
const areaItem = document.getElementById("areaItem");
const categoriaItem = document.getElementById("categoriaItem");
const stockTeoricoItem = document.getElementById("stockTeoricoItem");
const marcaItem = document.getElementById("marcaItem");
const subfamiliaItem = document.getElementById("subfamiliaItem");
const modeloItem = document.getElementById("modeloItem");
const caracteristicasItem = document.getElementById("caracteristicasItem");
// INPUTS

// CONTENEDORES DATA
const dataSubalmacenEntradas = document.getElementById("dataSubalmacenEntradas");
const dataCarritoEntradas = document.getElementById("dataCarritoEntradas");
const dataCarritoSalidas = document.getElementById("dataCarritoSalidas");
const dataSubalmacenExistencias = document.getElementById("dataSubalmacenExistencias");
const dataSalidasSubalmacen = document.getElementById("dataSalidasSubalmacen");
const dataTodosItems = document.getElementById("dataTodosItems");
// CONTENEDORES DATA

// CONTENEDORES DIV
const contendorOTSalida = document.getElementById("contendorOTSalida");
const subalmacenEntradasFase = document.getElementById("subalmacenEntradasFase");
const subalmacenEntradasTitulo = document.getElementById("subalmacenEntradasTitulo");
const subalmacenSalidasFase = document.getElementById("subalmacenSalidasFase");
const subalmacenSalidasTitulo = document.getElementById("subalmacenSalidasTitulo");
const subalmacenExistenciasTitulo = document.getElementById("subalmacenExistenciasTitulo");
const subalmacenExistenciasFase = document.getElementById("subalmacenExistenciasFase");
// CONTENEDORES DIV

// BTN
const btnConfirmarEntrada = document.getElementById("btnConfirmarEntrada");
const btnConsultaEntradaCarrito = document.getElementById("btnConsultaEntradaCarrito");
const btnRestablecerEntradas = document.getElementById("btnRestablecerEntradas");
const btnModalAgregarItem = document.getElementById("btnModalAgregarItem");
const btnRestablecerSalidas = document.getElementById("btnRestablecerSalidas");
const btnConsultaSalidaCarrito = document.getElementById("btnConsultaSalidaCarrito");
const btnConfirmarSalidaCarrito = document.getElementById("btnConfirmarSalidaCarrito");
const btnAgregarItems = document.getElementById("btnAgregarItems");
const btnBusquedaGeneral = document.getElementById("btnBusquedaGeneral");
// BTN


function consultaSubalmacen() {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  const action = "consultaSubalmacen";

  $.ajax({
    type: "POST",
    url: "php/crud_subalmacen.php",
    data: {
      action: action,
      idDestino: idDestino,
      idUsuario: idUsuario
    },
    dataType: 'JSON',
    success: function (data) {
      $("#subalmacenGP").html(data.dataGP);
      $("#subalmacenTRS").html(data.dataTRS);
      $("#subalmacenZI").html(data.dataZI);
    }
  });
}


const subalmacenSeleccionado = idSubalmacen => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  const action = "subalmacenSeleccionado";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      if (array) {
        subalmacenEntradasFase.innerText = array.fase;
        subalmacenEntradasTitulo.innerText = array.subalmacen;
        subalmacenSalidasFase.innerText = array.fase;
        subalmacenSalidasTitulo.innerText = array.subalmacen;
        subalmacenExistenciasFase.innerText = array.fase;
        subalmacenExistenciasTitulo.innerText = array.subalmacen;
      }
    })
    .catch(function (err) {
      fetch(APIERROR + err + ` subalmacenSeleccionado(${idSubalmacen})`);
    })
}



btnBusquedaGeneral.addEventListener('click', () => {
  obtenerTodosItemsGlobales();
  abrirmodal('modalBusquedaGeneral');
});


// Funciones para mostrar todo los Items.
const obtenerTodosItemsGlobales = () => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let palabraBuscar = document.getElementById("inputPalabraBuscarTodo").value;


  const action = "consultaTodosItems";
  const URL = `php/subalmacen.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&palabraBuscar=${palabraBuscar}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      dataTodosItems.innerHTML = '';
      return array;
    })
    .then(array => {
      if (array.length) {
        for (let x = 0; x < array.length; x++) {
          const cod2bend = array[x].cod2bend;
          const descripcionCod2bend = array[x].descripcionCod2bend;
          const servicioTecnico = array[x].servicioTecnico;
          const seccion = array[x].seccion;
          const area = array[x].area;
          const categoria = array[x].categoria;
          const stockTeorico = array[x].stockTeorico;
          const stockActual = array[x].stockActual;
          const marca = array[x].marca;
          const modelo = array[x].modelo;
          const caracteristicas = array[x].caracteristicas;
          const subfamilia = array[x].subfamilia;
          const subalmacen = array[x].subalmacen;

          const codigo = `
            <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24" 
                data-title-items="${cod2bend}">
                    <p class="truncate whitespace-no-wrap">${cod2bend}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24" 
                data-title-items="${descripcionCod2bend}">
                    <p class="truncate whitespace-no-wrap">${descripcionCod2bend}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${servicioTecnico}">
                    <p class="truncate whitespace-no-wrap">${servicioTecnico}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${seccion}">
                    <p class="truncate whitespace-no-wrap">${seccion}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${area}">
                    <p class="truncate whitespace-no-wrap">${area}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${categoria}">
                    <p class="truncate whitespace-no-wrap">${categoria}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-12"
                data-title-items="${stockTeorico}">
                    <p class="truncate whitespace-no-wrap">${stockTeorico}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-12"
                data-title-items="${stockActual}">
                    <p class="truncate whitespace-no-wrap">${stockActual}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${marca}">
                    <p class="truncate whitespace-no-wrap">${marca}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${modelo}">
                    <p class="truncate whitespace-no-wrap">${modelo}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-32"
                data-title-items="${caracteristicas}">
                    <p class="truncate whitespace-no-wrap">${caracteristicas}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${subfamilia}">
                    <p class="truncate whitespace-no-wrap">${subfamilia}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${subalmacen}">
                    <p class="truncate whitespace-no-wrap">${subalmacen}</p>
                </td>
                
            </tr>    
          `;
          dataTodosItems.insertAdjacentHTML('beforeend', codigo);
        }
      }
    })
    .catch(function (err) {
      dataTodosItems.innerHTML = '';
      fetch(APIERROR + err);
    })


}



function generarXLSItems(tipoXLS) {

  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let page = "";

  if (tipoXLS == "destino0") {
    page =
      `php/GenerarExcel.php?action=generarExcel&idDestino=${idDestino}&idUsuario=${idUsuario}&idSubalmacen=0&stock=0`;
  } else if (tipoXLS == "destino1") {
    page =
      `php/GenerarExcel.php?action=generarExcel&idDestino=${idDestino}&idUsuario=${idUsuario}&idSubalmacen=0&stock=1`;
  } else if (tipoXLS == "subalmacen0") {
    page =
      `php/GenerarExcel.php?action=generarExcel&idDestino=${idDestino}&idUsuario=${idUsuario}&idSubalmacen=${idSubalmacen}&stock=0`;
  } else if (tipoXLS == "subalmacen1") {
    page =
      `php/GenerarExcel.php?action=generarExcel&idDestino=${idDestino}&idUsuario=${idUsuario}&idSubalmacen=${idSubalmacen}&stock=1`;
  }
  window.location = page;
}


// OBTIENE LOS ITEMS PARA ASIGNAR STOCK
const entradasSubalmacen = idSubalmacen => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  localStorage.setItem('idSubalmacen', idSubalmacen)

  abrirmodal('modalSubalmacenEntradas');

  const action = "obtenerItems";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}&palabraBuscar=${inputPablabraBuscarEntradas.value}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      dataSubalmacenEntradas.innerHTML = '';

      return array;
    })
    .then(array => {
      if (array.length) {
        for (let x = 0; x < array.length; x++) {
          const idItemGlobal = array[x].idItemGlobal;
          const idSubalmacen = array[x].idSubalmacen;
          const cod2bend = array[x].cod2bend;
          const descripcionCod2bend = array[x].descripcionCod2bend;
          const servicioTecnico = array[x].servicioTecnico;
          const seccion = array[x].seccion;
          const area = array[x].area;
          const categoria = array[x].categoria;
          const stockTeorico = array[x].stockTeorico;
          const stockActual = array[x].stockActual;
          const marca = array[x].marca;
          const modelo = array[x].modelo;
          const caracteristicas = array[x].caracteristicas;
          const subfamilia = array[x].subfamilia;
          const subalmacen = array[x].subalmacen;
          const stockCantidadEntrada = array[x].stockCantidadEntrada;

          const fAgregarEntrada = `onchange="agregarEntrada(${idItemGlobal}, ${idSubalmacen});"`;

          const codigo = `
            <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24" 
                data-title-items="${cod2bend}">
                    <p class="truncate whitespace-no-wrap">${cod2bend}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24" 
                data-title-items="${descripcionCod2bend}">
                    <p class="truncate whitespace-no-wrap">${descripcionCod2bend}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${servicioTecnico}">
                    <p class="truncate whitespace-no-wrap">${servicioTecnico}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${seccion}">
                    <p class="truncate whitespace-no-wrap">${seccion}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${area}">
                    <p class="truncate whitespace-no-wrap">${area}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${categoria}">
                    <p class="truncate whitespace-no-wrap">${categoria}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-12"
                data-title-items="${stockTeorico}">
                    <p class="truncate whitespace-no-wrap">${stockTeorico}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-12"
                data-title-items="${stockActual}">
                    <p class="truncate whitespace-no-wrap">${stockActual}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${marca}">
                    <p class="truncate whitespace-no-wrap">${marca}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${modelo}">
                    <p class="truncate whitespace-no-wrap">${modelo}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-32"
                data-title-items="${caracteristicas}">
                    <p class="truncate whitespace-no-wrap">${caracteristicas}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${subfamilia}">
                    <p class="truncate whitespace-no-wrap">${subfamilia}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${subalmacen}">
                    <p class="truncate whitespace-no-wrap">${subalmacen}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-16" data-title-items="Ingrese Cantidad">
                    <p class="whitespace-no-wrap">
                      <input id="item_entrada_${idItemGlobal}" class="border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 rounded-md text-sm focus:outline-none w-full" type="number" placeholder="#" min="0" value="${stockCantidadEntrada}" ${fAgregarEntrada}>
                    </p>
                </td>
                
            </tr>    
          `;
          dataSubalmacenEntradas.insertAdjacentHTML('beforeend', codigo);
        }
      }
    })
    .catch(function (err) {
      dataSubalmacenEntradas.innerHTML = '';
      fetch(APIERROR + err);
    })
}


// EVENTO PARA BUSCAR ITEMS
inputPablabraBuscarEntradas.addEventListener('keypress', event => {
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  if (event.key == "Enter") {
    entradasSubalmacen(idSubalmacen);
  }
})


// AGREGA AL CARRITO ENTRADAS DE STOCK
const agregarEntrada = (idItemGlobal, idSubalmacen) => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  if (input = document.getElementById("item_entrada_" + idItemGlobal)) {
    if (input.value >= 0 && input.value != 'e') {

      const action = "agregarEntrada";
      const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}&idItemGlobal=${idItemGlobal}&cantidad=${input.value}`;

      fetch(URL)
        .then(array => array.json())
        .then(array => {
          if (array == "AGREGADO") {
            alertaImg('Cantidad Agregada: ' + input.value, '', 'success', 1500);
          } else if (array == "ACTUALIZADO") {
            alertaImg('Cantidad Actualizada: ' + input.value, '', 'success', 1500);
          } else {
            alertaImg('Intende de Nuevo', '', 'info', 1500);
          }
        })
        .catch(function (err) {
          fetch(APIERROR + err);
        })

    } else {
      input.value = '';
      alertaImg('Cantidad No Valida', '', 'info', 1500);
    }
  }
}


// CONSULTA LAS ENTRADAS PENDIENTES DEL CARRITO
btnConsultaEntradaCarrito.addEventListener('click', () => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let idSubalmacen = localStorage.getItem('idSubalmacen');

  abrirmodal('modalConfirmacionEntradas');

  const action = "consultaEntradaCarrito";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      dataCarritoEntradas.innerHTML = '';

      return array;
    })
    .then(array => {
      if (array) {
        for (let x = 0; x < array.length; x++) {
          const idItemGlobal = array[x].idItemGlobal;
          const stockEntrada = array[x].stockEntrada;
          const descripcion = array[x].descripcion;
          const caracteristicas = array[x].caracteristicas;
          const coste = array[x].coste;
          const codigo = `
            <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer">
                <div class="w-32 flex h-full items-center justify-center">
                    <h1 class="truncate">${stockEntrada}</h1>
                </div>
                <div class="w-64 flex h-full items-center justify-center" data-title-items="${descripcion}">
                    <h1 class="truncate">${descripcion}</h1>
                </div>
                <div class="w-64 flex h-full items-center justify-center" data-title-items="${caracteristicas}">
                    <h1 class="truncate">${caracteristicas}</h1>
                </div>
                <div class="w-32 flex h-full items-center justify-center">
                    <h1>${stockEntrada * coste}</h1>
                </div>
            </div>
          `;
          dataCarritoEntradas.insertAdjacentHTML('beforeend', codigo);
        }
      }
    })
    .catch(function (err) {
      dataCarritoEntradas.innerHTML = '';
      fetch(APIERROR + err);
    })
})



// FINALIZA LAS ENTRADAS PENDIENTES DEL CARRITO
btnConfirmarEntrada.addEventListener('click', () => {
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  const action = "confirmarEntradaSubalmacen";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}`;

  alertify.confirm('MAPHG', '¿Desea Finalizar Entrada?', () => {
    fetch(URL)
      .then(array => array.json())
      .then(array => {
        if (array == 1) {
          alertaImg('Carrito Finalizado con Exito', '', 'success', 1500);
          entradasSubalmacen(idSubalmacen);
          cerrarmodal('modalConfirmacionEntradas');
        } else {
          alertaImg('Intente de Nuevo', '', 'info', 1500);
        }
      })
      .catch(function (err) {
        fetch(APIERROR + err);
      })
  },
    () => { alertaImg('Proceso Cancelado', '', 'error', 1500) });
})


// RESTABLECE LAS ENTRADAS PENDIENTES DEL CARRITO
btnRestablecerEntradas.addEventListener('click', () => {
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  const action = "restablecerEntradaSubalmacen";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}`;

  alertify.confirm('MAPHG', '¿Desea Restablecer el Carrito de Entradas?', () => {
    fetch(URL)
      .then(array => array.json())
      .then(array => {
        if (array == 1) {
          alertaImg('Carrito Restablecido con Exito', '', 'success', 1500);
          entradasSubalmacen(idSubalmacen);
        } else {
          alertaImg('Intente de Nuevo', '', 'info', 1500);
        }
      })
      .catch(function (err) {
        fetch(APIERROR + err);
      })
  },
    () => { alertaImg('Proceso Cancelado', '', 'error', 1500) });
})


// OBTIENE LAS EXISTENCIAS DE SUBALMACENES POR DESTINO
const consultaExistenciasSubalmacen = idSubalmacen => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  localStorage.setItem('idSubalmacen', idSubalmacen);

  abrirmodal('modalExistenciasSubalmacen');

  const action = "obtenerItems";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}&palabraBuscar=${inputPalabraExistencias.value}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      dataSubalmacenExistencias.innerHTML = '';
      return array;
    })
    .then(array => {
      if (array) {
        for (let x = 0; x < array.length; x++) {
          const idItemGlobal = array[x].idItemGlobal;
          const idSubalmacen = array[x].idSubalmacen;
          const cod2bend = array[x].cod2bend;
          const descripcionCod2bend = array[x].descripcionCod2bend;
          const servicioTecnico = array[x].servicioTecnico;
          const seccion = array[x].seccion;
          const area = array[x].area;
          const categoria = array[x].categoria;
          const stockTeorico = array[x].stockTeorico;
          const stockActual = array[x].stockActual;
          const marca = array[x].marca;
          const modelo = array[x].modelo;
          const caracteristicas = array[x].caracteristicas;
          const subfamilia = array[x].subfamilia;
          const subalmacen = array[x].subalmacen;

          const porcentaje = (100 / (stockTeorico + .01)) * stockActual;
          const estilo = porcentaje <= 20 ? 'text-red-500 bg-red-200'
            : stockActual >= stockTeorico ? 'text-yellow-700 bg-yellow-200'
              : 'text-bluegray-500 bg-bluegray-50';
          const fItem = `onclick="obtenerItem(${idItemGlobal})"`;

          const codigo = `
            <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal ${estilo}">

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24" 
                data-title-items="${cod2bend}">
                    <p class="truncate whitespace-no-wrap">${cod2bend}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24" 
                data-title-items="${descripcionCod2bend}">
                    <p class="truncate whitespace-no-wrap">${descripcionCod2bend}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${servicioTecnico}">
                    <p class="truncate whitespace-no-wrap">${servicioTecnico}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${seccion}">
                    <p class="truncate whitespace-no-wrap">${seccion}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${area}">
                    <p class="truncate whitespace-no-wrap">${area}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${categoria}">
                    <p class="truncate whitespace-no-wrap">${categoria}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-12"
                data-title-items="${stockTeorico}">
                    <p class="truncate whitespace-no-wrap">${stockTeorico}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-12"
                data-title-items="${stockActual}">
                    <p class="truncate whitespace-no-wrap">${stockActual}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${marca}">
                    <p class="truncate whitespace-no-wrap">${marca}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${modelo}">
                    <p class="truncate whitespace-no-wrap">${modelo}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-32"
                data-title-items="${caracteristicas}">
                    <p class="truncate whitespace-no-wrap">${caracteristicas}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${subfamilia}">
                    <p class="truncate whitespace-no-wrap">${subfamilia}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-32"
                data-title-items="${subalmacen}">
                    <p class="truncate whitespace-no-wrap">${subalmacen}</p>
                </td> 

                <td class="px-2 border-b border-gray-200 text-center py-1 font-bold w-8">
                    <i class="fas fa-edit hover:text-blue-500 text-blue-700 fa-lg" ${fItem}></i>
                </td> 
            </tr>    
          `;
          dataSubalmacenExistencias.insertAdjacentHTML('beforeend', codigo);
        }
      }
    })
    .catch(function (err) {
      dataSubalmacenExistencias.innerHTML = '';
      fetch(APIERROR + err);
    })
}


// OBTIENE ITEMS CON EXISTENCIAS PARA LAS SALIDAS
const salidasSubalmacen = idSubalmacen => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  localStorage.setItem('idSubalmacen', idSubalmacen);

  abrirmodal('modalSalidasSubalmacen');

  const action = "obtenerItems";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}&palabraBuscar=${inputPalabraBuscarSalida.value}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      dataSalidasSubalmacen.innerHTML = '';

      return array;
    })
    .then(array => {
      if (array) {
        for (let x = 0; x < array.length; x++) {
          const idItemGlobal = array[x].idItemGlobal;
          const idSubalmacen = array[x].idSubalmacen;
          const cod2bend = array[x].cod2bend;
          const descripcionCod2bend = array[x].descripcionCod2bend;
          const servicioTecnico = array[x].servicioTecnico;
          const seccion = array[x].seccion;
          const area = array[x].area;
          const categoria = array[x].categoria;
          const stockTeorico = array[x].stockTeorico;
          const stockActual = array[x].stockActual;
          const marca = array[x].marca;
          const modelo = array[x].modelo;
          const caracteristicas = array[x].caracteristicas;
          const subfamilia = array[x].subfamilia;
          const subalmacen = array[x].subalmacen;
          const stockCantidadSalida = array[x].stockCantidadSalida;

          const fAgregarSalida = `onchange="agregarSalida(${idItemGlobal}, ${idSubalmacen});"`;

          if (stockActual > 0) {
            const codigo = `
            <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24" 
                data-title-items="${cod2bend}">
                    <p class="truncate whitespace-no-wrap">${cod2bend}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24" 
                data-title-items="${descripcionCod2bend}">
                    <p class="truncate whitespace-no-wrap">${descripcionCod2bend}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${servicioTecnico}">
                    <p class="truncate whitespace-no-wrap">${servicioTecnico}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${seccion}">
                    <p class="truncate whitespace-no-wrap">${seccion}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${area}">
                    <p class="truncate whitespace-no-wrap">${area}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${categoria}">
                    <p class="truncate whitespace-no-wrap">${categoria}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-12"
                data-title-items="${stockTeorico}">
                    <p class="truncate whitespace-no-wrap">${stockTeorico}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-12"
                data-title-items="${stockActual}">
                    <p class="truncate whitespace-no-wrap">${stockActual}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${marca}">
                    <p class="truncate whitespace-no-wrap">${marca}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${modelo}">
                    <p class="truncate whitespace-no-wrap">${modelo}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-32"
                data-title-items="${caracteristicas}">
                    <p class="truncate whitespace-no-wrap">${caracteristicas}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${subfamilia}">
                    <p class="truncate whitespace-no-wrap">${subfamilia}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-24"
                data-title-items="${subalmacen}">
                    <p class="truncate whitespace-no-wrap">${subalmacen}</p>
                </td>

                <td class="px-1 border-b border-gray-200 text-center py-1 font-bold w-16" data-title-items="Ingrese Cantidad">
                    <p class="whitespace-no-wrap">
                      <input id="item_salida_${idItemGlobal}" class="border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 rounded-md text-sm focus:outline-none w-full" type="number" placeholder="#" min="0" value="${stockCantidadSalida}" ${fAgregarSalida}>
                    </p>
                </td>
                
            </tr>    
          `;
            dataSalidasSubalmacen.insertAdjacentHTML('beforeend', codigo);
          }
        }
      }
    })
    .catch(function (err) {
      dataSalidasSubalmacen.innerHTML = '';
      // fetch(APIERROR + err);
    })
}


// AGREGA AL CARRITO ENTRADAS DE STOCK
const agregarSalida = (idItemGlobal, idSubalmacen) => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  if (input = document.getElementById("item_salida_" + idItemGlobal)) {
    if (input.value >= 0 && input.value != 'e') {

      const action = "agregarSalida";
      const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}&idItemGlobal=${idItemGlobal}&cantidad=${input.value}`;

      fetch(URL)
        .then(array => array.json())
        .then(array => {
          if (array == "AGREGADO") {
            alertaImg('Cantidad Agregada: ' + input.value, '', 'success', 1500);
          } else if (array == "ACTUALIZADO") {
            alertaImg('Cantidad Actualizada: ' + input.value, '', 'success', 1500);
          } else if (array == "INSUFICIENTE") {
            alertaImg('Stock Real, No Disponible', '', 'info', 1500);
            salidasSubalmacen(idSubalmacen);
          } else {
            alertaImg('Intende de Nuevo', '', 'info', 1500);
            salidasSubalmacen(idSubalmacen);
          }
        })
        .catch(function (err) {
          salidasSubalmacen(idSubalmacen);
          fetch(APIERROR + err);
        })
    } else {
      input.value = '';
      alertaImg('Cantidad No Valida', '', 'info', 1500);
    }
  }
}


// EVENTO PARA BUSCAR ITEMS
inputPalabraBuscarSalida.addEventListener('keypress', event => {
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  if (event.key == "Enter") {
    salidasSubalmacen(idSubalmacen);
  }
})


// RESTABLECE LAS SALIDAS PENDIENTES DEL CARRITO
btnRestablecerSalidas.addEventListener('click', () => {
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  const action = "restablecerSalidasSubalmacen";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}`;

  alertify.confirm('MAPHG', '¿Desea Restablecer el Carrito de Salidas?', () => {
    fetch(URL)
      .then(array => array.json())
      .then(array => {
        if (array == 1) {
          alertaImg('Carrito Restablecido con Exito', '', 'success', 1500);
          salidasSubalmacen(idSubalmacen);
        } else {
          alertaImg('Intente de Nuevo', '', 'info', 1500);
        }
      })
      .catch(function (err) {
        fetch(APIERROR + err);
      })
  },
    () => { alertaImg('Proceso Cancelado', '', 'error', 1500) });
})

// CONSULTA LAS ENTRADAS PENDIENTES DEL CARRITO
btnConsultaSalidaCarrito.addEventListener('click', () => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let idSubalmacen = localStorage.getItem('idSubalmacen');

  abrirmodal('modalCarritoSalidas');

  const action = "consultaSalidaCarrito";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      dataCarritoSalidas.innerHTML = '';

      return array;
    })
    .then(array => {
      if (array) {
        for (let x = 0; x < array.length; x++) {
          const idItemGlobal = array[x].idItemGlobal;
          const stockSalida = array[x].stockSalida;
          const descripcion = array[x].descripcion;
          const caracteristicas = array[x].caracteristicas;
          const coste = array[x].coste;
          const codigo = `
            <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer">
                <div class="w-32 flex h-full items-center justify-center">
                    <h1 class="truncate">${stockSalida}</h1>
                </div>
                <div class="w-64 flex h-full items-center justify-center" data-title-items="${descripcion}">
                    <h1 class="truncate">${descripcion}</h1>
                </div>
                <div class="w-64 flex h-full items-center justify-center" data-title-items="${caracteristicas}">
                    <h1 class="truncate">${caracteristicas}</h1>
                </div>
                <div class="w-32 flex h-full items-center justify-center">
                    <h1>${stockSalida * coste}</h1>
                </div>
            </div>
          `;
          dataCarritoSalidas.insertAdjacentHTML('beforeend', codigo);
        }
      }
    })
    .catch(function (err) {
      dataCarritoSalidas.innerHTML = '';
      fetch(APIERROR + err);
    })
})


// FINALIZA LAS SALIDAS PENDIENTES DEL CARRITO
btnConfirmarSalidaCarrito.addEventListener('click', () => {
  let idSubalmacen = localStorage.getItem('idSubalmacen');
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  const action = "confirmarSalidaSubalmacen";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}&tipoSalida=${motivoSalidaCarrito.value}&OTSalida=${OTSalida.value}`;

  alertify.confirm('MAPHG', '¿Desea Finalizar Salida?', () => {
    fetch(URL)
      .then(array => array.json())
      .then(array => {
        if (array == 1) {
          alertaImg('Carrito Finalizado con Exito', '', 'success', 1500);
          salidasSubalmacen(idSubalmacen);
          cerrarmodal('modalCarritoSalidas');
        } else if (array == 2) {
          alertaImg('Numero OT, NO Existe', '', 'info', 1500);
        } else {
          alertaImg('Comprueba sus Datos e Intente de Nuevo', '', 'info', 1500);
        }
      })
      .catch(function (err) {
        fetch(APIERROR + err);
      })
  },
    () => { alertaImg('Proceso Cancelado', '', 'error', 1500) });
})


// VALIDA EL MOTIVO DE SALIDA
motivoSalidaCarrito.addEventListener('change', () => {
  const msj = motivoSalidaCarrito.value == "INCIDENCIA" ? 'Ingrese Numero OT'
    : motivoSalidaCarrito.value == "INCIDENCIAGENERAL" ? 'Ingrese Numero OT'
      : motivoSalidaCarrito.value == "PREVENTIVO" ? 'Ingrese Numero OT'
        : motivoSalidaCarrito.value == "GIFT" ? 'Ingrese Numero GIFT'
          : 'Justifique la Salida';

  if (motivoSalidaCarrito.value == "") {
    alertaImg('Justifique la Salida', '', 'error', 1400);
    contendorOTSalida.classList.add('hidden');
  } else {
    contendorOTSalida.classList.remove('hidden');
    OTSalida.setAttribute('placeholder', msj);
  }
})



// INICIA PARAMETROS PARA AGREGAR ITEM
const iniciarFomularioItem = () => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  const action = "consultarOpcionesItem";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      seccionItem.innerHTML = '<option value="0">SELECCIONE</option>';
      return array;
    })
    .then(array => {
      if (secciones = array.secciones) {
        for (let x = 0; x < secciones.length; x++) {
          const idSeccion = secciones[x].idSeccion;
          const seccion = secciones[x].seccion;
          const codigo = `<option value="${idSeccion}">${seccion}</option>`;
          seccionItem.insertAdjacentHTML('beforeend', codigo);
        }
      }
    })
    .catch(function (err) {
      seccionItem.innerHTML = '';
      fetch(APIERROR + err);
    })
}


//INICIA FORMULARIO PARA AGREGAR ITEMS 
btnModalAgregarItem.addEventListener('click', () => {
  abrirmodal('modalAgregarItem');
  btnAgregarItems.setAttribute('onclick', 'agregarItem()');
  btnAgregarItems.innerText = 'Agregar Item';
  cod2bendItem.value = '';
  seccionItem.value = 0;
  descripcionCod2bendItem.value = '';
  SSTItem.value = '';
  areaItem.value = '';
  categoriaItem.value = '';
  stockTeoricoItem.value = '';
  marcaItem.value = '';
  subfamiliaItem.value = 0;
  modeloItem.value = '';
  caracteristicasItem.value = '';
})


// AGREGA ITEM GLOBAL POR DESTINO
const agregarItem = () => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let idSubalmacen = localStorage.getItem('idSubalmacen');

  const data = new FormData();
  data.append("cod2bendItem", cod2bendItem.value)
  data.append("seccionItem", seccionItem.value)
  data.append("descripcionCod2bendItem", descripcionCod2bendItem.value)
  data.append("SSTItem", SSTItem.value)
  data.append("areaItem", areaItem.value)
  data.append("categoriaItem", categoriaItem.value)
  data.append("stockTeoricoItem", stockTeoricoItem.value)
  data.append("marcaItem", marcaItem.value)
  data.append("subfamiliaItem", subfamiliaItem.value)
  data.append("modeloItem", modeloItem.value)
  data.append("caracteristicasItem", caracteristicasItem.value)

  const action = "agregarItem";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

  fetch(URL, {
    method: "POST",
    body: data
  })
    .then(array => array.json())
    .then(array => {
      if (array == 1) {
        alertaImg('Item Agregado', '', 'success', 1500);
        consultaExistenciasSubalmacen(idSubalmacen);
        cod2bendItem.value = '';
        seccionItem.value = '';
        descripcionCod2bendItem.value = '';
        SSTItem.value = '';
        areaItem.value = '';
        categoriaItem.value = '';
        stockTeoricoItem.value = '';
        marcaItem.value = '';
        subfamiliaItem.value = '';
        modeloItem.value = '';
        caracteristicasItem.value = '';
        cerrarmodal('modalAgregarItem');
      } else {
        alertaImg('Intente de Nuevo', '', 'info', 1500);
      }
    })
    .catch(function (err) {
      cod2bendItem.value = '';
      seccionItem.value = '';
      descripcionCod2bendItem.value = '';
      SSTItem.value = '';
      areaItem.value = '';
      categoriaItem.value = '';
      stockTeoricoItem.value = '';
      marcaItem.value = '';
      subfamiliaItem.value = '';
      modeloItem.value = '';
      caracteristicasItem.value = '';
      cerrarmodal('modalAgregarItem');
      fetch(APIERROR + err);
    })
}


// OBTIENE INFORMACIÓN DE ITEM SELECCIONADO
const obtenerItem = idItem => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');

  abrirmodal('modalAgregarItem');
  btnAgregarItems.setAttribute('onclick', `actualizarItem(${idItem})`);
  btnAgregarItems.innerText = 'Actualizar Item';

  const action = "obtenerItem";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idItem=${idItem}`;

  fetch(URL)
    .then(array => array.json())
    .then(array => {
      if (array) {
        cod2bendItem.value = array.cod2bend;
        seccionItem.value = array.idSeccion;
        descripcionCod2bendItem.value = array.descripcionCod2bend;
        SSTItem.value = array.SST;
        areaItem.value = array.area;
        categoriaItem.value = array.categoria;
        stockTeoricoItem.value = array.stockTeorico;
        marcaItem.value = array.marca;
        subfamiliaItem.value = array.subfamilia;
        modeloItem.value = array.modelo;
        caracteristicasItem.value = array.caracteristicas;
      }
    })
    .catch(function (err) {
      cerrarmodal('modalAgregarItem');
      fetch(APIERROR + err);
    })
}


// ACTUALIZA ITEM GLOBAL
const actualizarItem = idItem => {
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let idSubalmacen = localStorage.getItem('idSubalmacen');

  const data = new FormData();
  data.append("idItem", idItem)
  data.append("cod2bendItem", cod2bendItem.value)
  data.append("seccionItem", seccionItem.value)
  data.append("descripcionCod2bendItem", descripcionCod2bendItem.value)
  data.append("SSTItem", SSTItem.value)
  data.append("areaItem", areaItem.value)
  data.append("categoriaItem", categoriaItem.value)
  data.append("stockTeoricoItem", stockTeoricoItem.value)
  data.append("marcaItem", marcaItem.value)
  data.append("subfamiliaItem", subfamiliaItem.value)
  data.append("modeloItem", modeloItem.value)
  data.append("caracteristicasItem", caracteristicasItem.value)

  const action = "actualizarItem";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

  fetch(URL, {
    method: "POST",
    body: data
  })
    .then(array => array.json())
    .then(array => {
      if (array == 1) {
        alertaImg('Item Actualizado', '', 'success', 1500);
        consultaExistenciasSubalmacen(idSubalmacen);
        cerrarmodal('modalAgregarItem');
      } else {
        alertaImg('Intente de Nuevo', '', 'info', 1500);
      }
    })
    .catch(function (err) {
      cod2bendItem.value = '';
      seccionItem.value = '';
      descripcionCod2bendItem.value = '';
      SSTItem.value = '';
      areaItem.value = '';
      categoriaItem.value = '';
      stockTeoricoItem.value = '';
      marcaItem.value = '';
      subfamiliaItem.value = '';
      modeloItem.value = '';
      caracteristicasItem.value = '';
      cerrarmodal('modalAgregarItem');
      fetch(APIERROR + err);
    })
}


// LOAD DEL NAVEGADOR
window.addEventListener('load', () => {
  consultaSubalmacen();
  iniciarFomularioItem();
  document.getElementById("destinosSelecciona").addEventListener("click", consultaSubalmacen);
})


const leerExcel = () => {
  fetch('php/excel.json')
    .then(array => array.json())
    .then(array => {
      console.log(array);
      if (array.length) {
        const procesoExcel = array => {
          let idDestino = localStorage.getItem('idDestino');
          let idUsuario = localStorage.getItem('usuario');
          let idSubalmacen = localStorage.getItem('idSubalmacen');

          const action = "procesoExcel";
          const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}`;

          fetch(URL, {
            method: "POST",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(array)
          })
            .then(array2 => array2.json())
            .then(array2 => {
              console.log(array2)

              if (array2.REGISTRADOS.length == array.length) {
                alertify.confirm('MAPHG', `¿Cargar Existencias? <br>
                - Registrados: ${array2.REGISTRADOS.length} <br>
                - Faltantes: ${array.length - array2.REGISTRADOS.length} <br>
                - Total: ${array.length}`,
                  () => { cargarExistencias(array) }
                  , () => { alertaImg('Proceso Cancelado', '', 'error') });
              } else {
                alertify.confirm('MAPHG', `¿Desea Agregar Registros Faltantes? <br>
                                - Registrados: ${array2.REGISTRADOS.length} <br>
                                - Faltantes: ${array.length - array2.REGISTRADOS.length} <br>
                                - Total: ${array.length}`,
                  () => { leerExcel() }
                  , () => { alertaImg('Proceso Cancelado', '', 'error') });
              }
            })
            .catch(function (err) {
              // fetch(APIERROR + err);
              console.log(err);
            })
        }
        procesoExcel(array)
      }
    })
    .catch(function (err) {
      fetch(APIERROR + err);
    })
}


const cargarExistencias = array => {
  console.log(array);
  let idDestino = localStorage.getItem('idDestino');
  let idUsuario = localStorage.getItem('usuario');
  let idSubalmacen = localStorage.getItem('idSubalmacen');

  const action = "cargarExistencias";
  const URL = `php/subalmacen.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubalmacen=${idSubalmacen}`;

  fetch(URL, {
    method: "POST",
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(array)
  })
    .then(array => array.json())
    .then(array => {
      console.log(array)
    })
    .catch(function (err) {
      fetch(APIERROR + err);
    })

}