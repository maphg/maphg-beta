'use strict';
const destinosSelecciona = document.getElementById('destinosSelecciona');
const contenedorDeItems = document.getElementById('contenedorDeItems');
const palabraItems = document.getElementById('palabraItems');
const btnExportarItems = document.getElementById('btnExportarItems');

const consultarStock = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "consultarStock";
    const URL = `php/stock.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            contenedorDeItems.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idItem = array[x].idItem;
                    const cod2bend = array[x].cod2bend;
                    const descripcionCod2bend = array[x].descripcionCod2bend;
                    const descripcionSstt = array[x].descripcionSstt;
                    const area = array[x].area;
                    const categoria = array[x].categoria;
                    const stockTeorico = array[x].stockTeorico;
                    const stockReal = array[x].stockReal;
                    const marca = array[x].marca;
                    const modelo = array[x].modelo;
                    const caracteristicas = array[x].caracteristicas;
                    const subfamilia = array[x].subfamilia;
                    const subalmacen = array[x].subalmacen;
                    const activo = array[x].activo;
                    const destino = array[x].destino;
                    const seccion = array[x].seccion;

                    const cod2bendX = cod2bend == "" || cod2bend == " " ? 'S/C' : cod2bend;
                    const stockT = stockTeorico <= 0 ? 0 : stockTeorico;
                    const stockR = stockReal <= 0 ? 0 : stockReal;

                    const estiloCategoria =
                        categoria == 'BAJA' || categoria == 'Baja' ? `yellow`
                            : categoria == 'ALTA' || categoria == 'Alta' ? `red`
                                : categoria == 'MEDIA' || categoria == 'Media' ? `orange`
                                    : categoria == 'SEGURIDAD' || categoria == 'Seguridad' ? `blue`
                                        : `gray`;
                    const categoriaX =
                        categoria == 'BAJA' || categoria == 'Baja' ? 'Rotación ' + categoria
                            : categoria == 'ALTA' || categoria == 'Alta' ? 'Rotación ' + categoria
                                : categoria == 'MEDIA' || categoria == 'Media' ? 'Rotación ' + categoria
                                    : categoria;

                    const codigo = `
                        <tr id="item_ID_${idItem}" class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800 fila-proyectos-select">

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3 font-bold ">
                                ${destino}
                            </td>

                            <td class="px-2 border-b border-gray-200 text-center py-3 font-semibold w-48" data-title-stock="Descripción: ${descripcionCod2bend}">
                                <p class="text-bluegray-600 text-left whitespace-no-wrap"> cod2bend: ${cod2bendX}</p>
                                <p class="truncate text-left whitespace-no-wrap">${descripcionCod2bend}</p>
                            </td>
                            
                            <td class="px-2 border-b border-gray-200 text-center py-4 uppercase font-semibold w-40" data-title-stock="Descripción: ${descripcionSstt}">
                                <p class="truncate whitespace-no-wrap">${descripcionSstt}</p>
                            </td>
                            
                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                <p class="truncate">${seccion}</p>
                            </td>
                            
                            <td class="px-2 border-b border-gray-200 text-center py-3 uppercase font-semibold" data-title-stock="${area}">
                                <p class="truncate whitespace-no-wrap">${area}</p>
                            </td>
                            
                            <td class="px-2  border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                <div class="px-2 bg-${estiloCategoria}-300 text-${estiloCategoria}-600 rounded-full" data-title-stock="${categoriaX}">
                                    <h1>${categoriaX}</h1>
                                </div>    
                            </td>
                            
                            <td class="px-2  border-b border-gray-200 text-center py-3 font-semibold">
                                <p class="truncate text-bluegray-600">Teorico: ${stockT}</p>
                                <p class="truncate text-bluegray-800">Real: ${stockR}</p>
                            </td>
                            
                            <td class="px-2  border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                <p class="truncate whitespace-no-wrap">${marca}</p>
                            </td>
                            
                            <td class="px-2  border-b border-gray-200 text-center py-3 uppercase font-semibold" data-title-stock="${modelo}">
                                <p class="truncate whitespace-no-wrap">${modelo}</p>
                            </td>
                            
                            <td class="px-2  border-b border-gray-200 text-center py-3 uppercase font-semibold" data-title-stock="${caracteristicas}">
                                <p class="truncate whitespace-no-wrap">${caracteristicas}</p>
                            </td>
                            
                            <td class="px-2  border-b border-gray-200 text-center py-3 uppercase font-semibold" data-title-stock="${subfamilia}">
                                <p class="truncate whitespace-no-wrap">${subfamilia}</p>
                            </td>
                            
                            <td class="px-2 border-b border-gray-200 text-center py-3" data-title-stock="${subalmacen}">
                                <p class="truncate whitespace-no-wrap">${subalmacen}</p>
                            </td>
                            
                        </tr>    
                    `;
                    contenedorDeItems.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            contenedorDeItems.innerHTML = '';
            console.log(err);
        })
}

palabraItems.addEventListener('keyup', () => {
    buscadorTabla('dataItems', 'palabraItems', 1);
})


destinosSelecciona.addEventListener('click', consultarStock);

btnExportarItems.addEventListener('click', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    location.href = `php/exportar_excel_GET.php?action=reporteItems&idUsuario=${idUsuario}&idDestino=${idDestino}`;
})

// INICIALIZA LA FUNCIÓN PRINCIPAL
window.onload(consultarStock());