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
                    const categoria = array[x].categoria.toUpperCase();
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

                    const estiloCategoria = categoria == 'BAJA' ? `yellow`
                        : categoria == 'ALTA' ? `red`
                            : categoria == 'MEIDA' ? `orange`
                                : categoria == 'BLUE' ? `blue`
                                    : `gray`;


                    const codigo = `
                        <tr id="item_ID_${idItem}" class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800 fila-proyectos-select">

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3 font-bold ">
                                ${destino}
                            </td>

                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 font-semibold">
                                ${cod2bend}
                            </td>

                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${descripcionCod2bend}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${descripcionSstt}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${seccion}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${area}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                <div class="px-2 bg-${estiloCategoria}-300 text-${estiloCategoria}-600 rounded-full uppercase">
                                    <h1>${categoria}</h1>
                                </div>    
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${stockTeorico}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${stockReal}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${marca}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${modelo}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${caracteristicas}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${subfamilia}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${subalmacen}
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
    buscadorTabla('dataItems', 'palabraItems', 0);
})


destinosSelecciona.addEventListener('click', consultarStock());
btnExportarItems.addEventListener('click', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    location.href = `php/exportar_excel_GET.php?action=reporteItems&idUsuario=${idUsuario}&idDestino=${idDestino}`;
})

// INICIALIZA LA FUNCIÓN PRINCIPAL
window.onload(consultarStock());