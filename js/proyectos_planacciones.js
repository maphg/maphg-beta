'use strict'
const $tablaProyectos = document.getElementById('contenedorDeProyectos');
const datosProyectos = params => {
    var cotizaciones = params.cotizaciones;
    var valorCotizaciones = 'X'

    var tipo = params.tipo;
    var valorTipo = 'X'

    var justificacion = params.justificacion;
    var valorjustificacion = 'X'

    var materiales = params.materiales;
    var materialesx = ''

    var direccion = params.direccion;
    var direccionx = ''

    var energeticos = params.energeticos;
    var energeticosx = ''

    var trabajando = params.trabajando;
    var trabajandox = ''

    switch (cotizaciones) {
        case 0:
            valorCotizaciones = '<i class="fad fa-minus text-xl text-red-400"></i>';
            break;
        default:
            valorCotizaciones = params.cotizaciones;
    }

    switch (tipo) {
        case 'capin':
            valorTipo = '<div class="px-2 bg-red-300 text-red-600 rounded-full uppercase"><h1>capin</h1></div>';
            break;
        case 'capex':
            valorTipo = '<div class="px-2 bg-yellow-300 text-yellow-600 rounded-full uppercase"><h1>capex</h1></div>';
            break;
        case 'proyecto':
            valorTipo = '<div class="px-2 bg-blue-300 text-blue-600 rounded-full uppercase"><h1>proyecto</h1></div>';
            break;

        default:
            valorTipo = '---';
    }

    switch (justificacion) {
        case 'no':
            valorjustificacion = '<i class="fad fa-minus text-xl text-red-400"></i>';
            break;
        case 'si':
            valorjustificacion = '<i class="fas fa-check text-xl text-green-300"></i>';
            break;
        default:
            valorjustificacion = params.justificacion;
    }

    switch (materiales) {
        case 'si':
            materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
            break;
        default:
            materialesx = '';
    }

    switch (direccion) {
        case 'si':
            direccionx = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
            break;
        default:
            direccionx = '';
    }

    switch (energeticos) {
        case 'si':
            energeticosx = '<div class="bg-yellow-300 w-5 h-5 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>E</h1></div>';
            break;
        default:
            energeticosx = '';
    }

    switch (trabajando) {
        case 'si':
            trabajandox = '<div class="bg-cyan-300 w-5 h-5 rounded-full flex justify-center items-center text-cyan-600 mr-1"><h1>T</h1></div>';
            break;
        default:
            trabajandox = '';
    }

    return `
        <tr id="${params.id}proyecto" class="hover:bg-gray-200 cursor-pointer text-xs font-normal" onclick="tooltipProyectos(${params.id})">

            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;">
                <div class="font-semibold uppercase leading-4">
                    <h1>${params.proyecto}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1 class="mr-2 font-semibold">${params.destino}</h1>
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.pda}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.responsable}</h1>
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <h1>${valorCotizaciones}</h1>
            </td>

            <td class="  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                ${valorTipo}
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 text-center text-lg py-3">
                ${valorjustificacion}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <h1>$ ${params.coste}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3">
                <div class="text-sm flex justify-center items-center font-bold">
                    ${materialesx}
                    ${energeticosx}
                    ${direccionx}
                    ${trabajandox}                                                
                </div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3">
                <div class="px-2">
                    <i class="fas fa-ellipsis-h  text-lg"></i>
                </div>
            </td>
            
        </tr>
        `;
};

$tablaProyectos.innerHTML += datosProyectos({ id: '123', destino: 'CMU', proyecto: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '12/20', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', cotizaciones: 0, tipo: 'capin', justificacion: 'si', coste: '455467', status: 'pendiente', materiales: 'si', energeticos: 'no', direccion: 'si', trabajando: 'no' });

$tablaProyectos.innerHTML += datosProyectos({ id: '546', destino: 'CMU', proyecto: 'Aqui va el nombre o descripcion del proyecto djfhs dkjfhs kdfhksjd fhk', creadoPor: 'Eduardo Meneses', pda: '5/55', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', cotizaciones: 5, tipo: 'capex', justificacion: 'no', coste: '11111', status: 'pendiente', materiales: 'si', energeticos: 'si', direccion: 'si', trabajando: 'no' });

$tablaProyectos.innerHTML += datosProyectos({ id: '588', destino: 'CMU', proyecto: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', cotizaciones: 0, tipo: 'proyecto', justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });


const $tablaPlanes = document.getElementById('contenedorDePlanesdeaccion');
const datosPlanes = params => {
    var comentarios = params.comentarios;
    var valorcomentarios = 'X'

    var adjuntos = params.adjuntos;
    var valoradjuntos = 'X'

    var tipo = params.tipo;
    var valorTipo = 'X'

    var materiales = params.materiales;
    var materialesx = ''

    var direccion = params.direccion;
    var direccionx = ''

    var energeticos = params.energeticos;
    var energeticosx = ''

    var trabajando = params.trabajando;
    var trabajandox = ''

    switch (comentarios) {
        case 0:
            valorcomentarios = '<i class="fad fa-minus text-xl text-red-400"></i>';
            break;
        default:
            valorcomentarios = params.comentarios;
    }

    switch (adjuntos) {
        case 0:
            valoradjuntos = '<i class="fad fa-minus text-xl text-red-400"></i>';
            break;
        default:
            valoradjuntos = params.adjuntos;
    }

    switch (tipo) {
        case 'capin':
            valorTipo = '<div class="px-2 bg-red-300 text-red-600 rounded-full uppercase"><h1>capin</h1></div>';
            break;
        case 'capex':
            valorTipo = '<div class="px-2 bg-yellow-300 text-yellow-600 rounded-full uppercase"><h1>capex</h1></div>';
            break;
        case 'proyecto':
            valorTipo = '<div class="px-2 bg-blue-300 text-blue-600 rounded-full uppercase"><h1>proyecto</h1></div>';
            break;

        default:
            valorTipo = '---';
    }

    switch (materiales) {
        case 'si':
            materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
            break;
        default:
            materialesx = '';
    }

    switch (direccion) {
        case 'si':
            direccionx = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
            break;
        default:
            direccionx = '';
    }

    switch (energeticos) {
        case 'si':
            energeticosx = '<div class="bg-yellow-300 w-5 h-5 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>E</h1></div>';
            break;
        default:
            energeticosx = '';
    }

    switch (trabajando) {
        case 'si':
            trabajandox = '<div class="bg-cyan-300 w-5 h-5 rounded-full flex justify-center items-center text-cyan-600 mr-1"><h1>T</h1></div>';
            break;
        default:
            trabajandox = '';
    }

    return `
        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;">
                <div class="font-semibold uppercase leading-4">
                    <h1>${params.actividad}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.pda}</h1>
            </td>
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${params.responsable}</h1>
            </td>
            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <h1>${valorcomentarios}</h1>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 text-center py-3">
            <h1>${valoradjuntos}</h1>
            </td>
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3">
                <div class="text-sm flex justify-center items-center font-bold">
                    ${materialesx}
                    ${energeticosx}
                    ${direccionx}
                    ${trabajandox}
                </div>
            </td>
            
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <h1>${params.id}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3">
                <div class="px-2">
                    <i class="fas fa-ellipsis-h  text-lg"></i>
                </div>
            </td>                        
        </tr>
        `;
};

$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });

document.getElementById("exportarProyectos").addEventListener('click', function () {
    tableToExcel('contenedorDeProyectos', 'PROYECTOS');
});

document.getElementById("palabraProyecto").addEventListener('keyup', function () {
    buscadorEquipo('contenedorDeProyectos', 'palabraProyecto', 0);
});

function tooltipProyectos(idproyecto) {
    // Propiedades para el tooltip
    console.log('tool');
    document.getElementById("tooltipProyectoPlanacciones").classList.toggle('hidden');
    const button = document.getElementById(idproyecto + 'proyecto');
    const tooltip = document.getElementById('tooltipProyectoPlanacciones');
    Popper.createPopper(button, tooltip, {
        placement: 'bottom',
    });

}