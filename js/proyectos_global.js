'use strict'

const datosProyectos = params => {
    var cotizaciones = params.cotizaciones;
    var valorCotizaciones = '';

    var tipo = params.tipo;
    var valorTipo = '';

    var justificacion = params.justificacion;
    var valorjustificacion = '';

    var materiales = params.materiales;
    var materialesx = '';

    var direccion = params.direccion;
    var direccionx = '';

    var energeticos = params.energeticos;
    var energeticosx = '';

    var trabajando = params.trabajando;
    var trabajandox = '';

    switch (cotizaciones) {
        case (cotizaciones == 0):
            valorCotizaciones = '<i class="fad fa-minus text-xl text-red-400"></i>';
            break;
        default:
            valorCotizaciones = params.cotizaciones;
    }

    switch (tipo) {
        case 'CAPIN':
            valorTipo = '<div class="px-2 bg-red-300 text-red-600 rounded-full uppercase"><h1>capin</h1></div>';
            break;

        case 'CAPEX':
            valorTipo = '<div class="px-2 bg-yellow-300 text-yellow-600 rounded-full uppercase"><h1>capex</h1></div>';
            break;

        case 'PROYECTO':
            valorTipo = '<div class="px-2 bg-blue-300 text-blue-600 rounded-full uppercase"><h1>proyecto</h1></div>';
            break;

        default:
            valorTipo = '';
    }

    switch (justificacion) {
        case 'NO':
            valorjustificacion = '<i class="fad fa-minus text-xl text-red-400"></i>';
            break;
        case 'SI':
            valorjustificacion = '<i class="fas fa-check text-xl text-green-300"></i>';
            break;
        default:
            valorjustificacion = params.justificacion;
    }

    switch (materiales) {
        case 1:
            materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
            break;
        default:
            materialesx = '';
    }

    switch (direccion) {
        case 1:
            direccionx = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
            break;
        default:
            direccionx = '';
    }

    switch (energeticos) {
        case 1:
            energeticosx = '<div class="bg-yellow-300 w-5 h-5 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>E</h1></div>';
            break;
        default:
            energeticosx = '';
    }

    switch (trabajando) {
        case 1:
            trabajandox = '<div class="bg-cyan-300 w-5 h-5 rounded-full flex justify-center items-center text-cyan-600 mr-1"><h1>T</h1></div>';
            break;
        default:
            trabajandox = '';
    }

    return `
        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800">

            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3 font-bold ">
                ${params.destino}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 font-semibold">
                ${params.año}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                ${params.seccion}
            </td>

            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;">
                <div class="font-semibold uppercase leading-4">
                    <h1>${params.proyecto}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    Creado por: ${params.creadoPor}
                </div>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                ${params.pda}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                ${params.responsable}
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                ${valorCotizaciones}
            </td>

            <td class="  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                ${valorTipo}
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 text-center text-lg py-3">
                ${valorjustificacion}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                $ ${params.coste}
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


// $tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });



function obtenerProyectosGlobal(statusProyectos = 'PENDIENTE') {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerProyectosGlobal";
    const URL = `php/proyectos_planacciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&status=${statusProyectos}`;

    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';

    document.getElementById("btnProyectos").
        setAttribute('onclick', "obtenerProyectosGlobal('PENDIENTE');");

    document.getElementById("btnPendientes").
        setAttribute('onclick', "obtenerProyectosGlobal('PENDIENTE');");

    document.getElementById("btnSolucionados").
        setAttribute('onclick', "obtenerProyectosGlobal('SOLUCIONADO');");

    fetch(URL)
        .then(array => array.json())
        .then(array => {

            document.getElementById('contenedorDeProyectos').innerHTML = '';

            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const id = array[x].id;
                    const destino = array[x].destino;
                    const seccion = array[x].seccion;
                    const proyecto = array[x].proyecto;
                    const creadoPor = array[x].creadoPor;
                    const pda = array[x].pda;
                    const responsable = array[x].responsable;
                    const fechaInicio = array[x].fechaInicio;
                    const fechaFin = array[x].fechaFin;
                    const año = array[x].año;
                    const cotizaciones = array[x].cotizaciones;
                    const tipo = array[x].tipo;
                    const justificacion = array[x].justificacion;
                    const coste = array[x].coste;
                    const status = array[x].status;
                    const materiales = array[x].materiales;
                    const energeticos = array[x].energeticos;
                    const departamento = array[x].departamento;
                    const trabajando = array[x].trabajando;
                    const dataProyectos = datosProyectos({
                        id: id,
                        destino: destino,
                        seccion: seccion,
                        proyecto: proyecto,
                        creadoPor: creadoPor,
                        pda: pda,
                        responsable: responsable,
                        fechaInicio: fechaInicio,
                        fechaFin: fechaFin,
                        año: año,
                        cotizaciones: cotizaciones,
                        tipo: tipo,
                        justificacion: justificacion,
                        coste: coste,
                        status: status,
                        materiales: materiales,
                        energeticos: energeticos,
                        departamento: departamento,
                        trabajando: trabajando
                    });

                    document.getElementById("contenedorDeProyectos").insertAdjacentHTML('beforeend', dataProyectos);
                }
            } else {
                alertaImg('Sin Proyectos', '', 'info', 1500);
            }
        })
        .then(
            function () {
                document.getElementById("loadProyectos").innerHTML = '';
            })
        .catch(function (err) {
            fetch(APIERROR + err);
            document.getElementById("loadProyectos").innerHTML = '';
            document.getElementById("contenedorDeProyectos").innerHTML = '';

        })
}


document.getElementById("destinosSelecciona").addEventListener('click', () => {
    obtenerProyectosGlobal('PENDIENTE');
});


obtenerProyectosGlobal('PENDIENTE');