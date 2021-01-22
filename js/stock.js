'use strict';
const destinosSelecciona = document.createElement('destinosSelecciona');
const contenedorDeItems = document.createElement('contenedorDeItems');

const consultarStock = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "consultarStock";
    const URL = `php/stock.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

    contenedorDeItems.innerHTML = '';

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            console.log(array)
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
                                ${categoria}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${stockTeorico}
                            </td>
                            
                            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                                ${stockActual}
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
                    console.log(codigo);
                }
            }
        })
        .catch(function (err) {
            contenedorDeItems.innerHTML = '';
        })
}

destinosSelecciona.addEventListener('click', consultarStock);

// INICIALIZA LA FUNCIÓN PRINCIPAL
window.onload(consultarStock());

