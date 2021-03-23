const dataCompras = document.querySelector('#dataCompras');
const tableCompras = document.querySelector('#tableCompras');
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
// OPTIONS

// CONTENEDORES
const contenedorCompras = document.querySelector('#contenedorCompras');
const contenedorEntregas = document.querySelector('#contenedorEntregas');
// CONTENEDORES

// BTN
const btnCompras = document.querySelector('#btnCompras');
const btnEntregasNo = document.querySelector('#btnEntregasNo');
const btnEntragasSi = document.querySelector('#btnEntragasSi');
const btnExportarCompras = document.querySelector('#btnExportarCompras');
const btnExportarEntregas = document.querySelector('#btnExportarEntregas');
// BTN

// LODAD
const loaderMAPHG40 = '<div class="w-full p-1 flex items-center justify-center"><img src="svg/lineal_animated_loop.svg" width="30px" height="30px"></div>';

const loadCompras = document.querySelector('#loadCompras');
const loadEntregas = document.querySelector('#loadEntregas');
// LODAD


// EVENTOS DE OPCION SELECIONADA
btnCompras.addEventListener('click', () => {
    contenedorCompras.classList.remove('hidden');
    contenedorEntregas.classList.add('hidden');
    obtenerPedidosSinOrden();
    btnCompras.classList.add('text-gray-700', 'border-gray-900');
    btnEntregasNo.classList.remove('text-gray-700', 'border-gray-900');
    btnEntragasSi.classList.remove('text-gray-700', 'border-gray-900');
})

btnEntregasNo.addEventListener('click', () => {
    contenedorCompras.classList.add('hidden');
    contenedorEntregas.classList.remove('hidden');
    obtenerPedidosEntregar('PENDIENTE');
    btnCompras.classList.remove('text-gray-700', 'border-gray-900');
    btnEntregasNo.classList.add('text-gray-700', 'border-gray-900');
    btnEntragasSi.classList.remove('text-gray-700', 'border-gray-900');
})

btnEntragasSi.addEventListener('click', () => {
    contenedorCompras.classList.add('hidden');
    contenedorEntregas.classList.remove('hidden');
    obtenerPedidosEntregar('ENTREGADO');
    btnCompras.classList.remove('text-gray-700', 'border-gray-900');
    btnEntregasNo.classList.remove('text-gray-700', 'border-gray-900');
    btnEntragasSi.classList.add('text-gray-700', 'border-gray-900');
})


// EXPORTAR
btnExportarCompras.addEventListener('click', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerPedidosSinOrden";

    window.open(`php/pedidosExcel.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`);
})

const exportarPedidos = status => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerPedidosEntregar";
    window.open(`php/pedidosExcel.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&status=${status}`);
}


const obtenerPedidosSinOrden = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerPedidosSinOrden";
    const URL = `php/pedidos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    loadCompras.innerHTML = loaderMAPHG40;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataCompras.innerHTML = '';
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
                        `<tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
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

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
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


palabraCompras.addEventListener('keyup', () => { buscadorTabla('dataCompras', 'palabraCompras', 0) })

// EVENTOS FILTROS TABLA COMPRAS
cecoCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'cecoCompras', 0);
})
solicitudCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'solicitudCompras', 1);
})
fechaCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'fechaCompras', 2);
})
materialCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'materialCompras', 3);
})
materialDescipcionCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'materialDescipcionCompras', 4);
})
cantidadCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'cantidadCompras', 5);
})
unidadCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'unidadCompras', 6);
})
grupoCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'grupoCompras', 7);
})
seccionCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'seccionCompras', 8);
})
borradaCompras.addEventListener('change', () => {
    buscadorX('dataCompras', 'borradaCompras', 9);
})


const obtenerPedidosEntregar = status => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerPedidosEntregar";
    const URL = `php/pedidos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&status=${status}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
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

            if (array) {
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
                        `<tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
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

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${proveedor}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
                                <p class="truncate whitespace-no-wrap">${material}</p>
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-2 font-semibold w-auto">
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

palabraEntregas.addEventListener('keyup', () => { buscadorTabla('dataEntregas', 'palabraEntregas', 0) })

// EVENTOS FILTROS TABLA COMPRAS
cecoEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'cecoEntregas', 0);
})
solicitudEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'solicitudEntregas', 1);
})
fechaEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'fechaEntregas', 2);
})
documentoEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'documentoEntregas', 3);
})
fechaEntregEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'fechaEntregEntregas', 4);
})
fechaDocEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'fechaDocEntregas', 5);
})
proveedorEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'proveedorEntregas', 6);
})
materialEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'materialEntregas', 7);
})
descripcionMaterialEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'descripcionMaterialEntregas', 8);
})
cantidadEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'cantidadEntregas', 9);
})
porEntregarEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'porEntregarEntregas', 10);
})
tipoEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'tipoEntregas', 11);
})
valorEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'valorEntregas', 12);
})
seccionEntregas.addEventListener('change', () => {
    buscadorX('dataEntregas', 'seccionEntregas', 13);
})

// Buscador Tabla
function buscadorX(idTabla, idInput, columna) {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(idInput);
    filter = input.value.toUpperCase();
    table = document.getElementById(idTabla);
    tr = table.getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[columna];
        if (td.childNodes[1].innerText) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


window.addEventListener('load', () => {
    document.querySelector('#destinosSelecciona').addEventListener('click', () => {
        contenedorCompras.classList.add('hidden');
        contenedorEntregas.classList.add('hidden');
    })
})