'use strict'

const $tablaMateriales = document.getElementById('contenedorDeMateriales');
const datosMateriales = params => {

    var categoria = params.categoria.toUpperCase();;
    var valorcategoria = ''

    var status = params.status.toUpperCase();;
    var valorstatus = ''

    switch (categoria) {
        case 'SEGURIDAD':
            valorcategoria = '<div class="py-1 bg-yellow-300 text-yellow-600 rounded-full uppercase"><h1>seguridad</h1></div>';
            break;
        case 'EMERGENCIA':
            valorcategoria = '<div class="py-1 bg-red-300 text-red-600 rounded-full uppercase"><h1>emergencia</h1></div>';
            break;

        case 'BAJAROTACION':
            valorcategoria = '<div class="py-1 bg-blue-300 text-blue-600 rounded-full uppercase"><h1>Baja Rotacion</h1></div>';
            break;
        case 'MEDIAROTACION':
            valorcategoria = '<div class="py-1 bg-indigo-300 text-indigo-600 rounded-full uppercase"><h1>media Rotacion</h1></div>';
            break;
        case 'ALTAROTACION':
            valorcategoria = '<div class="py-1 bg-purple-300 text-purple-600 rounded-full uppercase"><h1>alta Rotacion</h1></div>';
            break;

        default:
            valorcategoria = '';
    }

    switch (status) {
        case 'SOLICITADO':
            valorstatus = '<div class="py-1 bg-yellow-300 text-yellow-600 rounded-full uppercase"><h1>solicitado</h1></div>';
            break;
        case 'PDTEORDENDECOMPRA':
            valorstatus = '<div class="py-1 bg-red-300 text-red-600 rounded-full uppercase"><h1>Pdte Orden de compra</h1></div>';
            break;
        case 'PDTEDEPROVEEDOR':
            valorstatus = '<div class="py-1 bg-orange-300 text-orange-600 rounded-full uppercase"><h1>Pdte de Proveedor</h1></div>';
            break;
        case 'ENTREGADO':
            valorstatus = '<div class="py-1 bg-green-300 text-green-600 rounded-full uppercase"><h1>entregado</h1></div>';
            break;

        default:
            valorstatus = '';
    }

    return `
        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.seccion}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.subseccion}</h1>
            </td>
            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;">
                <div class="font-semibold uppercase leading-4">
                    <h1>${params.descripcion}</h1>
                </div>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.marca}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.modelo}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.caracteristicas}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.codigo}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${valorcategoria}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${valorstatus}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.fecha}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.stockReal}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.stockTeorico}</h1>
            </td>
        </tr>
        `;
};


// ********** EVENTOS **********

// GENERA EXCEL
document.getElementById("exportarStock").addEventListener('click', function () {
    let idDestino = localStorage.getItem('idDestino');
    const URL = `php/generar_reporte_stock.php?idDestino=${idDestino}`;
    window.open(URL, '_blank');
    alertaImg('Generando Excel...', '', 'info', 1200);
});

// BUSCADOR EN TABLA
document.getElementById("palabraMaterial").addEventListener('keyup', function () {
    buscdorTabla('tablaStock', 'palabraMaterial', 2);
});
document.getElementById("palabraMaterial").addEventListener('click', function () {
    buscdorTabla('tablaStock', 'palabraMaterial', 2);
});

document.getElementById("destinosSelecciona").addEventListener('click', function () {
    consultarStock();
});

document.getElementById("cerrarSession").addEventListener('click', function () {
    localStorage.clear();
    location.href = "https://www.maphg.com/beta/login.php";
    // location.href = "http://localhost/maphg-beta/login.php";
});
// ********** EVENTOS **********


function consultarStock() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "consultarStock";
    const URL = `php/stock.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById("contenedorDeMateriales").innerHTML = '';
            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const id = array[x].id;
                    const seccion = array[x].seccion;
                    const area = array[x].area;
                    const descripcion = array[x].descripcion;
                    const marca = array[x].marca;
                    const modelo = array[x].modelo;
                    const caracteristicas = array[x].caracteristicas;
                    const codigo = array[x].codigo;
                    const categoria = array[x].categoria;
                    const status = array[x].status;
                    const fecha = array[x].fecha;
                    const stock_real = array[x].stock_real;
                    const stock_teorico = array[x].stock_teorico;

                    var data = datosMateriales({
                        id: id,
                        seccion: seccion,
                        subseccion: area,
                        descripcion: descripcion,
                        marca: marca,
                        modelo: modelo,
                        caracteristicas: caracteristicas,
                        codigo: codigo,
                        categoria: categoria,
                        status: status,
                        fecha: fecha,
                        stockReal: stock_real,
                        stockTeorico: stock_teorico
                    });
                    document.getElementById("contenedorDeMateriales")
                        .insertAdjacentHTML('beforeend', data);
                }
            } else {
                alertaImg('Stock No Disponible', '', 'warning', 1200);
            }
            return array.length;
        })
        .then(function (registros) {
            if (registros > 0) {
                alertaImg('Registros Cargados', '', 'success', 1200);
            }
        })
        .catch(function () {
            alertaImg('sin Stock', '', 'warning', 1200);
            document.getElementById("contenedorDeMateriales").innerHTML = '';

        })
}

// INICIALIZA LA FUNCIÓN PRINCIPAL
window.onload(consultarStock());