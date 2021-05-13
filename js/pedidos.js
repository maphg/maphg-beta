const dataCompras = document.querySelector('#dataCompras');
const tableCompras = document.querySelector('#tableCompras');
const dataSolicitudes = document.querySelector('#dataSolicitudes');

// OPTIONS
const cecoCompras = document.querySelector('#cecoCompras');
const solicitudCompras = document.querySelector('#solicitudCompras');
const fechaCompras = document.querySelector('#fechaCompras');
const materialCompras = document.querySelector('#materialCompras');
const materialDescipcionCompras = document.querySelector('#materialDescipcionCompras');
const cantidadCompras = document.querySelector('#cantidadCompras');
const unidadCompras = document.querySelector('#unidadCompras');
const grupoCompras = document.querySelector('#grupoCompras');
const seccionCompras = document.querySelector('#seccionCompras');
const borradaCompras = document.querySelector('#borradaCompras');
const palabraCompras = document.querySelector('#palabraCompras');
const palabraEntregas = document.querySelector('#palabraEntregas');
const fechaActualizacion = document.querySelector('#fechaActualizacion');
const cecoEntregas = document.querySelector('#cecoEntregas');
const solicitudEntregas = document.querySelector('#solicitudEntregas');
const fechaEntregas = document.querySelector('#fechaEntregas');
const documentoEntregas = document.querySelector('#documentoEntregas');
const fechaEntregEntregas = document.querySelector('#fechaEntregEntregas');
const fechaDocEntregas = document.querySelector('#fechaDocEntregas');
const proveedorEntregas = document.querySelector('#proveedorEntregas');
const materialEntregas = document.querySelector('#materialEntregas');
const descripcionMaterialEntregas = document.querySelector('#descripcionMaterialEntregas');
const cantidadEntregas = document.querySelector('#cantidadEntregas');
const porEntregarEntregas = document.querySelector('#porEntregarEntregas');
const tipoEntregas = document.querySelector('#tipoEntregas');
const valorEntregas = document.querySelector('#valorEntregas');
const seccionEntregas = document.querySelector('#seccionEntregas');

const destinoSolicitudes = document.querySelector('#destinoSolicitudes');
const numero2bendSolicitudes = document.querySelector('#numero2bendSolicitudes');
const nombreSolicitudes = document.querySelector('#nombreSolicitudes');
const costeSolicitudes = document.querySelector('#costeSolicitudes');
const estadoSolicitudes = document.querySelector('#estadoSolicitudes');
const fechaSolicitudes = document.querySelector('#fechaSolicitudes');
const pedriodoDESolicitudes = document.querySelector('#pedriodoDESolicitudes');
const periodoASolicitudes = document.querySelector('#periodoASolicitudes');
const hotelSolicitudes = document.querySelector('#hotelSolicitudes');
const centroCosteSolicitudes = document.querySelector('#centroCosteSolicitudes');
const solicitudSapSolicitudes = document.querySelector('#solicitudSapSolicitudes');

const palabraSolicitudes = document.querySelector('#palabraSolicitudes');
const destinoDetalle = document.querySelector('#destinoDetalle');
const nombreCecoDetalle = document.querySelector('#nombreCecoDetalle');
const solicitud2bendDetalle = document.querySelector('#solicitud2bendDetalle');
const fechaDetalle = document.querySelector('#fechaDetalle');
// OPTIONS

// CONTENEDORES
const contenedorSolicitudes = document.querySelector('#contenedorSolicitudes');
const contenedorCompras = document.querySelector('#contenedorCompras');
const contenedorEntregas = document.querySelector('#contenedorEntregas');
const dataSolicitudes2bend = document.querySelector('#dataSolicitudes2bend');
// CONTENEDORES

// BTN
const btnSolicitudes = document.querySelector('#btnSolicitudes');
const btnCompras = document.querySelector('#btnCompras');
const btnEntregasNo = document.querySelector('#btnEntregasNo');
const btnEntragasSi = document.querySelector('#btnEntragasSi');
const btnExportarSolicitudes = document.querySelector('#btnExportarSolicitudes');
const btnExportarCompras = document.querySelector('#btnExportarCompras');
const btnExportarEntregas = document.querySelector('#btnExportarEntregas');
// BTN

// LODAD
const loaderMAPHG40 = '<div class="w-full p-1 flex items-center justify-center"><img src="svg/lineal_animated_loop.svg" width="30px" height="30px"></div>';
const loadSolicitudes = document.querySelector('#loadSolicitudes');
const loadCompras = document.querySelector('#loadCompras');
const loadEntregas = document.querySelector('#loadEntregas');
// LODAD


// Buscador Tabla LIKE '%palabra%'
const buscadorX = (idTabla, idInput, columna) => {
    var input, filter, table, tr, td, i;
    input = document.getElementById(idInput);
    filter = input.value.toUpperCase();
    table = document.getElementById(idTabla);
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[columna];

        const txtValue = td.childNodes[1] ? td.childNodes[1].innerText || td.childNodes[1].textContent
            : td.childNodes[0] ? td.childNodes[0].innerText || td.childNodes[0].textContent
                : td ? td.innerText
                    : '';

        if (filter == "TODOS" || filter == "" || filter == undefined) {
            tr[i].style.display = "";
        } else {
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


// Buscador Tabla EXACTO
const buscador = (idTabla, idInput, columna) => {
    var input, filter, table, tr, td, i;
    input = document.getElementById(idInput);
    filter = input.value.toUpperCase();
    table = document.getElementById(idTabla);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[columna];

        const txtValue = td.childNodes[1] ? td.childNodes[1].innerText || td.childNodes[1].textContent
            : td.childNodes[0] ? td.childNodes[0].innerText || td.childNodes[0].textContent
                : td ? td.innerText
                    : '';

        if (filter == "TODOS" || filter == "" || filter == undefined) {
            tr[i].style.display = "";
        } else {
            if (txtValue.toUpperCase() == filter) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


// EVENTOS DE OPCION SELECIONADA
btnSolicitudes.addEventListener('click', () => {
    contenedorSolicitudes.classList.remove('hidden');
    contenedorCompras.classList.add('hidden');
    contenedorEntregas.classList.add('hidden');

    obtenerSolicitudes2bend();
    btnSolicitudes.classList.add('text-gray-700', 'border-gray-900');
    btnCompras.classList.remove('text-gray-700', 'border-gray-900');
    btnEntregasNo.classList.remove('text-gray-700', 'border-gray-900');
    btnEntragasSi.classList.remove('text-gray-700', 'border-gray-900');
})

btnCompras.addEventListener('click', () => {
    contenedorCompras.classList.remove('hidden');
    contenedorEntregas.classList.add('hidden');
    contenedorSolicitudes.classList.add('hidden');

    obtenerPedidosSinOrden();
    btnSolicitudes.classList.remove('text-gray-700', 'border-gray-900');
    btnCompras.classList.add('text-gray-700', 'border-gray-900');
    btnEntregasNo.classList.remove('text-gray-700', 'border-gray-900');
    btnEntragasSi.classList.remove('text-gray-700', 'border-gray-900');
})

btnEntregasNo.addEventListener('click', () => {
    contenedorCompras.classList.add('hidden');
    contenedorEntregas.classList.remove('hidden');
    contenedorSolicitudes.classList.add('hidden');

    obtenerPedidosEntregar('PENDIENTE');
    btnSolicitudes.classList.remove('text-gray-700', 'border-gray-900');
    btnCompras.classList.remove('text-gray-700', 'border-gray-900');
    btnEntregasNo.classList.add('text-gray-700', 'border-gray-900');
    btnEntragasSi.classList.remove('text-gray-700', 'border-gray-900');
    btnExportarEntregas.setAttribute('onclick', "exportarEntregas('PENDIENTE')");
})

btnEntragasSi.addEventListener('click', () => {
    contenedorCompras.classList.add('hidden');
    contenedorEntregas.classList.remove('hidden');
    contenedorSolicitudes.classList.add('hidden');

    obtenerPedidosEntregar('ENTREGADO');
    btnSolicitudes.classList.remove('text-gray-700', 'border-gray-900');
    btnCompras.classList.remove('text-gray-700', 'border-gray-900');
    btnEntregasNo.classList.remove('text-gray-700', 'border-gray-900');
    btnEntragasSi.classList.add('text-gray-700', 'border-gray-900');
    btnExportarEntregas.setAttribute('onclick', "exportarEntregas('ENTREGADO')");
})


// EXPORTAR
btnExportarSolicitudes.addEventListener('click', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerSolicitudes";

    window.open(`php/pedidosExcel.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`);
})


// EXPORTAR
btnExportarCompras.addEventListener('click', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerPedidosSinOrden";

    window.open(`php/pedidosExcel.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`);
})

// EXPORTAR
const exportarEntregas = status => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerPedidosEntregar";

    window.open(`php/pedidosExcel.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&status=${status}`);
}

// EXPORTAR
const exportarPedidos = status => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerPedidosEntregar";
    window.open(`php/pedidosExcel.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&status=${status}`);
}


// OBTIENE DATOS DE PEDIDOS SIN ORDEN DE COMPRA
const obtenerPedidosSinOrden = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerPedidosSinOrden";
    const URL = `php/pedidos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    loadCompras.innerHTML = loaderMAPHG40;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataSolicitudes.innerHTML = '';
            dataCompras.innerHTML = '';
            dataEntregas.innerHTML = '';

            cecoCompras.innerHTML = '<option value="">Todos</option>';
            solicitudCompras.innerHTML = '<option value="">Todos</option>';
            fechaCompras.innerHTML = '<option value="">Todos</option>';
            materialCompras.innerHTML = '<option value="">Todos</option>';
            materialDescipcionCompras.innerHTML = '<option value="">Todos</option>';
            cantidadCompras.innerHTML = '<option value="">Todos</option>';
            unidadCompras.innerHTML = '<option value="">Todos</option>';
            grupoCompras.innerHTML = '<option value="">Todos</option>';
            seccionCompras.innerHTML = '<option value="">Todos</option>';
            borradaCompras.innerHTML = '<option value="">Todos</option>';
            fechaActualizacion.innerHTML = '';
            return array;
        })
        .then(array => {
            const columna0 = new Set();
            const columna1 = new Set();
            const columna2 = new Set();
            const columna3 = new Set();
            const columna4 = new Set();
            const columna5 = new Set();
            const columna6 = new Set();
            const columna7 = new Set();
            const columna8 = new Set();
            const columna9 = new Set();

            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idItem = array[x].idItem;
                    const ceco = array[x].ceco;
                    const solicitud = array[x].solicitud;
                    const fechaSolicitud = array[x].fechaSolicitud;
                    const material = array[x].material;
                    const descripcionMaterial = array[x].descripcionMaterial;
                    const cantidaSolicitada = array[x].cantidaSolicitada;
                    const unidadMedida = array[x].unidadMedida;
                    const grupoCompras = array[x].grupoCompras;
                    const seccion = array[x].seccion;
                    const solicitudBorrada = array[x].solicitudBorrada;
                    const fechaModificacion = array[x].fechaModificacion;
                    fechaActualizacion.innerHTML = 'Actualizado: ' + fechaModificacion;

                    columna0.add(ceco);
                    columna1.add(solicitud);
                    columna2.add(fechaSolicitud);
                    columna3.add(material);
                    columna4.add(descripcionMaterial);
                    columna5.add(cantidaSolicitada);
                    columna6.add(unidadMedida);
                    columna7.add(grupoCompras);
                    columna8.add(seccion);
                    columna9.add(solicitudBorrada);

                    const codigo =
                        /*html*/
                        `<tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">
                            <td class="px-2 border-b border-gray-200 text-left py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${ceco}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${solicitud}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${fechaSolicitud}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${material}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-left py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${descripcionMaterial}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${cantidaSolicitada}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${unidadMedida}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${grupoCompras}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${seccion}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${solicitudBorrada}</p>
                            </td>
                        </tr>`;
                    dataCompras.insertAdjacentHTML('beforeend', codigo);
                }
            }
            return data = {
                "columna0": columna0,
                "columna1": columna1,
                "columna2": columna2,
                "columna3": columna3,
                "columna4": columna4,
                "columna5": columna5,
                "columna6": columna6,
                "columna7": columna7,
                "columna8": columna8,
                "columna9": columna9
            };
        })
        .then(data => {
            for (const item of data.columna0) {
                cecoCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna1) {
                solicitudCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna2) {
                fechaCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna3) {
                materialCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna4) {
                materialDescipcionCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna5) {
                cantidadCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna6) {
                unidadCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna7) {
                grupoCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna8) {
                seccionCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna9) {
                borradaCompras.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
        })
        .then(() => {
            loadCompras.innerHTML = '';
        })
        .catch(function (err) {
            loadCompras.innerHTML = '';
            dataCompras.innerHTML = err;
            cecoCompras.innerHTML = '';
            solicitudCompras.innerHTML = '';
            fechaCompras.innerHTML = '';
            materialCompras.innerHTML = '';
            materialDescipcionCompras.innerHTML = '';
            cantidadCompras.innerHTML = '';
            unidadCompras.innerHTML = '';
            grupoCompras.innerHTML = '';
            seccionCompras.innerHTML = '';
            solicitudCompras.innerHTML = '';
            borradaCompras.innerHTML = '';
            fechaActualizacion.innerHTML = '';
        })
}


palabraCompras.addEventListener('keyup', event => {
    if (event.keyCode === 13) {
        alertaImg('Procesando Datos...', '', 'info', 1500);
        buscadorX('dataCompras', 'palabraCompras', 0);
    }
})

// EVENTOS FILTROS TABLA COMPRAS
cecoCompras.addEventListener('change', () => {
    buscador('dataCompras', 'cecoCompras', 0);
})
solicitudCompras.addEventListener('change', () => {
    buscador('dataCompras', 'solicitudCompras', 1);
})
fechaCompras.addEventListener('change', () => {
    buscador('dataCompras', 'fechaCompras', 2);
})
materialCompras.addEventListener('change', () => {
    buscador('dataCompras', 'materialCompras', 3);
})
materialDescipcionCompras.addEventListener('change', () => {
    buscador('dataCompras', 'materialDescipcionCompras', 4);
})
cantidadCompras.addEventListener('change', () => {
    buscador('dataCompras', 'cantidadCompras', 5);
})
unidadCompras.addEventListener('change', () => {
    buscador('dataCompras', 'unidadCompras', 6);
})
grupoCompras.addEventListener('change', () => {
    buscador('dataCompras', 'grupoCompras', 7);
})
seccionCompras.addEventListener('change', () => {
    buscador('dataCompras', 'seccionCompras', 8);
})
borradaCompras.addEventListener('change', () => {
    buscador('dataCompras', 'borradaCompras', 9);
})


// OBTIENE PEDIDOS CON ORDEN DE COMPRAS (ENTREGADOS O POR ENTREGAR)
const obtenerPedidosEntregar = status => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerPedidosEntregar";
    const URL = `php/pedidos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&status=${status}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataSolicitudes.innerHTML = '';
            dataCompras.innerHTML = '';
            dataEntregas.innerHTML = '';

            fechaActualizacion.innerHTML = '';
            cecoEntregas.innerHTML = '<option value="">Todos</option>';
            solicitudEntregas.innerHTML = '<option value="">Todos</option>';
            fechaEntregas.innerHTML = '<option value="">Todos</option>';
            documentoEntregas.innerHTML = '<option value="">Todos</option>';
            fechaEntregEntregas.innerHTML = '<option value="">Todos</option>';
            fechaDocEntregas.innerHTML = '<option value="">Todos</option>';
            proveedorEntregas.innerHTML = '<option value="">Todos</option>';
            materialEntregas.innerHTML = '<option value="">Todos</option>';
            descripcionMaterialEntregas.innerHTML = '<option value="">Todos</option>';
            cantidadEntregas.innerHTML = '<option value="">Todos</option>';
            porEntregarEntregas.innerHTML = '<option value="">Todos</option>';
            tipoEntregas.innerHTML = '<option value="">Todos</option>';
            valorEntregas.innerHTML = '<option value="">Todos</option>';
            seccionEntregas.innerHTML = '<option value="">Todos</option>';
            return array;
        })
        .then(array => {
            const columna0 = new Set();
            const columna1 = new Set();
            const columna2 = new Set();
            const columna3 = new Set();
            const columna4 = new Set();
            const columna5 = new Set();
            const columna6 = new Set();
            const columna7 = new Set();
            const columna8 = new Set();
            const columna9 = new Set();
            const columna10 = new Set();
            const columna11 = new Set();
            const columna12 = new Set();
            const columna13 = new Set();

            if (array.length) {
                for (let x = 0; x < array.length; x++) {
                    const idItem = array[x].idItem;
                    const ceco = array[x].ceco;
                    const solicitudPedido = array[x].solicitudPedido;
                    const fechaSolicitud = array[x].fechaSolicitud;
                    const documentoCompras = array[x].documentoCompras;
                    const fechaEntrega = array[x].fechaEntrega;
                    const fechaDocumento = array[x].fechaDocumento;
                    const proveedor = array[x].proveedor;
                    const material = array[x].material;
                    const descripcionMaterial = array[x].descripcionMaterial;
                    const cantidadSolicitud = array[x].cantidadSolicitud;
                    const cantidadPorEntregar = array[x].cantidadPorEntregar;
                    const tipo = array[x].tipo;
                    const valorUSD = array[x].valorUSD;
                    const seccion = array[x].seccion;
                    const fechaModificacion = array[x].fechaModificacion;

                    if (array[x].fechaModificacion) {
                        fechaActualizacion.innerHTML = 'Actualizado: ' + fechaModificacion;
                    }

                    columna0.add(ceco);
                    columna1.add(solicitudPedido);
                    columna2.add(fechaSolicitud);
                    columna3.add(documentoCompras);
                    columna4.add(fechaEntrega);
                    columna5.add(fechaDocumento);
                    columna6.add(proveedor);
                    columna7.add(material);
                    columna8.add(descripcionMaterial);
                    columna9.add(cantidadSolicitud);
                    columna10.add(cantidadPorEntregar);
                    columna11.add(tipo);
                    columna12.add(valorUSD);
                    columna13.add(seccion);

                    const codigo =
                        /*html*/
                        `<tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">

                            <td class="px-2 border-b border-gray-200 text-left py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${ceco}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${solicitudPedido}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${fechaSolicitud}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${documentoCompras}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${fechaEntrega}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${fechaDocumento}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-left py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${proveedor}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${material}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-left py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${descripcionMaterial}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${cantidadSolicitud}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${cantidadPorEntregar}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${tipo}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${valorUSD}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${seccion}</p>
                            </td>

                        </tr>`;
                    dataEntregas.insertAdjacentHTML('beforeend', codigo);
                }
                return data = {
                    "columna0": columna0,
                    "columna1": columna1,
                    "columna2": columna2,
                    "columna3": columna3,
                    "columna4": columna4,
                    "columna5": columna5,
                    "columna6": columna6,
                    "columna7": columna7,
                    "columna8": columna8,
                    "columna9": columna9,
                    "columna10": columna10,
                    "columna11": columna11,
                    "columna12": columna12,
                    "columna13": columna13
                };
            }
        })
        .then(data => {
            for (const item of data.columna0) {
                cecoEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna1) {
                solicitudEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna2) {
                fechaEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna3) {
                documentoEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna4) {
                fechaEntregEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna5) {
                fechaDocEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna6) {
                proveedorEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna7) {
                materialEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna8) {
                descripcionMaterialEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna9) {
                cantidadEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna10) {
                porEntregarEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna11) {
                tipoEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna12) {
                valorEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna13) {
                seccionEntregas.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
        })
        .catch(function (err) {
            dataEntregas.innerHTML = err;
            fechaActualizacion.innerHTML = '';
            dataEntregas.innerHTML = '';
            cecoEntregas.innerHTML = '';
            solicitudEntregas.innerHTML = '';
            fechaEntregas.innerHTML = '';
            documentoEntregas.innerHTML = '';
            fechaEntregEntregas.innerHTML = '';
            fechaDocEntregas.innerHTML = '';
            proveedorEntregas.innerHTML = '';
            materialEntregas.innerHTML = '';
            descripcionMaterialEntregas.innerHTML = '';
            cantidadEntregas.innerHTML = '';
            porEntregarEntregas.innerHTML = '';
            tipoEntregas.innerHTML = '';
            valorEntregas.innerHTML = '';
            seccionEntregas.innerHTML = '';
            console.log(err);
        })
}

palabraEntregas.addEventListener('keyup', event => {
    if (event.keyCode == 13) {
        alertaImg('Procesando Datos...', '', 'info', 1500);
        buscadorX('dataEntregas', 'palabraEntregas', 0)
    }
})

// EVENTOS FILTROS TABLA COMPRAS
cecoEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'cecoEntregas', 0);
})
solicitudEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'solicitudEntregas', 1);
})
fechaEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'fechaEntregas', 2);
})
documentoEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'documentoEntregas', 3);
})
fechaEntregEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'fechaEntregEntregas', 4);
})
fechaDocEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'fechaDocEntregas', 5);
})
proveedorEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'proveedorEntregas', 6);
})
materialEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'materialEntregas', 7);
})
descripcionMaterialEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'descripcionMaterialEntregas', 8);
})
cantidadEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'cantidadEntregas', 9);
})
porEntregarEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'porEntregarEntregas', 10);
})
tipoEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'tipoEntregas', 11);
})
valorEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'valorEntregas', 12);
})
seccionEntregas.addEventListener('change', () => {
    buscador('dataEntregas', 'seccionEntregas', 13);
})


// OBTIENE SOLICITUDES 2BEND
const obtenerSolicitudes2bend = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSolicitudes2bend";
    const URL = `php/pedidos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
    loadSolicitudes.innerHTML = loaderMAPHG40;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataSolicitudes.innerHTML = '';
            dataCompras.innerHTML = '';
            dataEntregas.innerHTML = '';

            destinoSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            numero2bendSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            nombreSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            costeSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            estadoSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            fechaSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            pedriodoDESolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            periodoASolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            hotelSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            centroCosteSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            solicitudSapSolicitudes.innerHTML = '<option value="TODOS">Todos</option>';
            return array;
        })
        .then(array => {
            const columna0 = new Set();
            const columna1 = new Set();
            const columna2 = new Set();
            const columna3 = new Set();
            const columna4 = new Set();
            const columna5 = new Set();
            const columna6 = new Set();
            const columna7 = new Set();
            const columna8 = new Set();
            const columna9 = new Set();
            const columna10 = new Set();

            if (array.length) {
                for (let x = 0; x < array.length; x++) {
                    const idItem = array[x].idItem;
                    const destino = array[x].destino;
                    const numero2bend = array[x].numero2bend;
                    const nombre = array[x].nombre;
                    const coste = array[x].coste;
                    const estado = array[x].estado;
                    const fecha = array[x].fecha;
                    const periodoDe = array[x].periodoDe;
                    const periodoA = array[x].periodoA;
                    const hotel = array[x].hotel;
                    const centroCoste = array[x].centroCoste;
                    const solicitudSap = array[x].solicitudSap;

                    columna0.add(destino);
                    columna1.add(numero2bend);
                    columna2.add(nombre);
                    columna3.add(coste);
                    columna4.add(estado);
                    columna5.add(fecha);
                    columna6.add(periodoDe);
                    columna7.add(periodoA);
                    columna8.add(hotel);
                    columna9.add(centroCoste);
                    columna10.add(solicitudSap);

                    const codigo =
                        /*html*/
                        `<tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800 font-normal" onclick="obtenerDetalles(${idItem}, ${numero2bend});">
                            <td class="py-2 text-center font-semibold">${destino}</td>

                            <td class="py-2 text-center font-semibold">${numero2bend}</td>

                            <td class"py-2 text-left font-semibold text-xxs">${nombre}</td>

                            <td class="py-2 text-center font-semibold">${coste}</td>

                            <td class="py-2 text-left font-semibold">${estado}</td>

                            <td class="py-2 text-center font-semibold">${fecha}</td>

                            <td class="py-2 text-center font-semibold">${periodoDe}</td>

                            <td class="py-2 text-center font-semibold">${periodoA}</td>

                            <td class="py-2 text-left font-semibold">${hotel}</td>

                            <td class="py-2 text-left font-semibold">${centroCoste}</td>

                            <td class="py-2 text-center font-semibold">${solicitudSap}</td>
                        </tr>
                    `;
                    dataSolicitudes.insertAdjacentHTML('beforeend', codigo);
                }
            }

            return data = {
                "columna0": columna0,
                "columna1": columna1,
                "columna2": columna2,
                "columna3": columna3,
                "columna4": columna4,
                "columna5": columna5,
                "columna6": columna6,
                "columna7": columna7,
                "columna8": columna8,
                "columna9": columna9,
                "columna10": columna10,
            };
        })
        .then(data => {
            for (const item of data.columna0) {
                destinoSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna1) {
                numero2bendSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna2) {
                nombreSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna3) {
                costeSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna4) {
                estadoSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna5) {
                fechaSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna6) {
                pedriodoDESolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna7) {
                periodoASolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna8) {
                hotelSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna9) {
                centroCosteSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
            for (const item of data.columna10) {
                solicitudSapSolicitudes.insertAdjacentHTML('beforeend', `<option value="${item}">${item}</option>`);
            }
        })
        .then(() => {
            loadSolicitudes.innerHTML = '';
        })
        .catch(function (err) {
            console.log(err);
            loadSolicitudes.innerHTML = '';
        })
}


palabraSolicitudes.addEventListener('keyup', event => {
    if (event.key == "Enter" || event.keyCode == 13) {
        alertaImg('Procesando Datos...', '', 'info', 1500);
        buscadorX('dataSolicitudes', 'palabraSolicitudes', 1)
    }
})

// EVENTOS FILTROS TABLA COMPRAS
destinoSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'destinoSolicitudes', 0);
})
numero2bendSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'numero2bendSolicitudes', 1);
})
nombreSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'nombreSolicitudes', 2);
})
costeSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'costeSolicitudes', 3);
})
estadoSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'estadoSolicitudes', 4);
})
fechaSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'fechaSolicitudes', 5);
})
pedriodoDESolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'pedriodoDESolicitudes', 6);
})
periodoASolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'periodoASolicitudes', 7);
})
hotelSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'hotelSolicitudes', 8);
})
centroCosteSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'centroCosteSolicitudes', 9);
})
solicitudSapSolicitudes.addEventListener('change', () => {
    buscador('dataSolicitudes', 'solicitudSapSolicitudes', 10);
})


// OBTIENE LOS DETALLES CON EL NUMERO DE PEDIDO
const obtenerDetalles = (idItem, solicitud) => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerDetalles";
    const URL = `php/pedidos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idItem=${idItem}&solicitud=${solicitud}`;

    if (solicitud <= 0) {
        alertaImg('Numero de Solicitud, NO Valida', '', 'info', 1500);
        return;
    }

    abrirmodal('modalDetalles');

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataSolicitudes2bend.innerHTML = '';
            destinoDetalle.innerText = array.detalles.destino
            nombreCecoDetalle.innerText = array.detalles.nombreCeco
            solicitud2bendDetalle.innerText = array.detalles.solicitud2bend
            fechaDetalle.innerText = array.detalles.fechaSolicitud
            return array.resultados;
        })
        .then(array => {
            console.log(array)
            if (array.length) {
                for (let x = 0; x < array.length; x++) {
                    const solicitud = array[x].solicitud;
                    const fechaSolicitud = array[x].fechaSolicitud;
                    const documentoCompras = array[x].documentoCompras;
                    const fechaDocumento = array[x].fechaDocumento;
                    const fechaEntrega = array[x].fechaEntrega;
                    const proveedor = array[x].proveedor;
                    const material = array[x].material;
                    const descripcionMaterial = array[x].descripcionMaterial;
                    const cantidadSolicitada = array[x].cantidadSolicitada;
                    const cantidadEntregar = array[x].cantidadEntregar;
                    const valorUSD = array[x].valorUSD;
                    const grupoCompras = array[x].grupoCompras;
                    const seccion = array[x].seccion;
                    const estatusLiberacion = array[x].estatusLiberacion;
                    const solicitudBorrada = array[x].solicitudBorrada;
                    const tipo = array[x].tipo;

                    const codigo = /*html*/`
                        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">
                            <td class="py-2 px-2 text-center text-xs font-normal">${solicitud}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${fechaSolicitud}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${documentoCompras}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${fechaDocumento}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${fechaEntrega}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${proveedor}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${material}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${descripcionMaterial}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${cantidadSolicitada}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${cantidadEntregar}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${valorUSD}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${grupoCompras}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${seccion}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${estatusLiberacion}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${solicitudBorrada}</td>
                            <td class="py-2 px-2 text-center text-xs font-normal">${tipo}</td>
                        </tr>
                    `
                    dataSolicitudes2bend.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err);
        })
}


// CIERRA MODALES
const cerrarmodal = idModal => {
    if (modal = document.querySelector("#" + idModal)) {
        modal.classList.remove("open");
    }
}


// ABRIR MODALES
const abrirmodal = idModal => {
    if (modal = document.querySelector("#" + idModal)) {
        modal.classList.add("open");
    }
}



window.addEventListener('load', () => {
    document.querySelector('#destinosSelecciona').addEventListener('click', () => {
        contenedorCompras.classList.add('hidden');
        contenedorEntregas.classList.add('hidden');
    })
})