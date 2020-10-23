'use strict';

const $tablaProyectosDEP = document.getElementById('contenedorDeProyectosDEP');
const datosProyectosDEP = params => {
    var idProyecto = params.id;

    var cotizaciones = params.cotizaciones;
    var valorCotizaciones = 'X'

    var tipo = params.tipo;
    var valorTipo = 'X'

    var justificacion = params.justificacion;
    var valorjustificacion = 'X'

    var materiales = params.materiales;
    var materialesx = ''

    var departamento = params.departamento;
    var departamentox = ''

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

    switch (departamento) {
        case 1:
            departamentox = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
            break;
        default:
            departamentox = '';
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

    if (params.status == "PENDIENTE") {
        var fObtenerPlanaccion = `onclick="obtenerPlanaccionDEP(${idProyecto})"`;
    } else {
        var fObtenerPlanaccion = '';
    }

    return `
        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;"
            ${fObtenerPlanaccion}>
                <div class="font-semibold uppercase leading-4">
                    <h1>${params.proyecto}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1 class="mr-2 font-semibold">${params.destino}</h1>
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" 
            ${fObtenerPlanaccion}>
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
                    ${departamentox}
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

$tablaProyectosDEP.innerHTML += datosProyectosDEP({ id: '123', destino: 'CMU', proyecto: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '12/20', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', cotizaciones: 0, tipo: 'capin', justificacion: 'si', coste: '455467', status: 'pendiente', materiales: 'si', energeticos: 'no', departamento: 'si', trabajando: 'no' });

$tablaProyectosDEP.innerHTML += datosProyectosDEP({ id: '546', destino: 'CMU', proyecto: 'Aqui va el nombre o descripcion del proyecto djfhs dkjfhs kdfhksjd fhk', creadoPor: 'Eduardo Meneses', pda: '5/55', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', cotizaciones: 5, tipo: 'capex', justificacion: 'no', coste: '11111', status: 'pendiente', materiales: 'si', energeticos: 'si', departamento: 'si', trabajando: 'no' });




const $tablaPlanesDEP = document.getElementById('contenedorDePlanesdeaccionDEP');
const datosPlanesDEP = params => {
    var idPlanaccion = params.id;

    var comentarios = params.comentarios;
    var valorcomentarios = 'X'

    var adjuntos = params.adjuntos;
    var valoradjuntos = 'X'

    var tipo = params.tipo;
    var valorTipo = 'X'

    var materiales = params.materiales;
    var materialesx = ''

    var departamento = params.departamento;
    var departamentox = ''

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

    switch (materiales) {
        case 1:
            materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
            break;
        default:
            materialesx = '';
    }

    switch (departamento) {
        case 1:
            departamentox = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
            break;
        default:
            departamentox = '';
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
                <h1>${params.subTareas}</h1>
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
                    ${departamentox}
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

$tablaPlanesDEP.innerHTML += datosPlanesDEP({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'SI', coste: '345352', status: 'PENDIENTE', materiales: 0, energeticos: 0, departamento: 1, trabajando: 1 });


function obtenerDEP(idSubseccion) {
    console.log(idSubseccion);
    document.getElementById("modalProyectosDEP").classList.add('open');
}


// OBTIENES LOS PROYECTOS DEP
function obtenerProyectosDEP(idSubseccion, status = 'PENDIENTE') {
    document.getElementById("modalProyectosDEP").classList.add("open");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");

    // Atributos Iniciales
    document.getElementById("proyectosPendientes").setAttribute('onclick', `obtenerProyectos(${idSubseccion}, "PENDIENTE");`);
    document.getElementById("proyectosSolucionados").setAttribute('onclick', `obtenerProyectos(${idSubseccion}, "SOLUCIONADO");`);
    // Atributos Iniciales

    // Actualiza la Sección
    localStorage.setItem("idSubseccion", idSubseccion);

    // Estilo para Botones Superiores
    estiloBotonesProyectos(status, 'PROYECTOS');

    // Secciones de Botones.
    document.getElementById("btnCrearProyecto")
        .setAttribute("onclick", "agregarProyecto()");

    const action = "consultaProyectosDEP";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubseccion=${idSubseccion}&status=${status}`;

    document.getElementById("loadProyectosDEP").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';

    fetch(URL)
        .then(resp => resp.json())
        .then(array => {
            if (array.length > 0) {
                console.log(array);
                document.getElementById('contenedorDeProyectosDEP').innerHTML = '';
                document.getElementById('palabraProyecto').value = '';
                for (let x = 0; x < array.length; x++) {
                    const id = array[x].id;
                    const destino = array[x].destino;
                    const proyecto = array[x].proyecto;
                    const creadoPor = array[x].creadoPor;
                    const pda = array[x].pda;
                    const responsable = array[x].responsable;
                    const fechaInicio = array[x].fechaInicio;
                    const fechaFin = array[x].fechaFin;
                    const cotizaciones = array[x].cotizaciones;
                    const tipo = array[x].tipo;
                    const justificacion = array[x].justificacion;
                    const coste = array[x].coste;
                    const status = array[x].status;
                    const materiales = array[x].materiales;
                    const energeticos = array[x].energeticos;
                    const departamento = array[x].departamento;
                    const trabajando = array[x].trabajando;
                    $tablaProyectosDEP.innerHTML += datosProyectosDEP({

                        id: id,
                        destino: destino,
                        proyecto: proyecto,
                        creadoPor: creadoPor,
                        pda: pda,
                        responsable: responsable,
                        fechaInicio: fechaInicio,
                        fechaFin: fechaFin,
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
                }
            } else {
                alertaImg('Sin Proyectos', '', 'info', 1500);
                document.getElementById('contenedorDeProyectosDEP').innerHTML = '';
            }
        })
        .then(() => {
            // Quita el Loader hasta que Finalize la carga de Proyectos
            document.getElementById("loadProyectosDEP").innerHTML = '';
        })
        .catch(function () {
            document.getElementById("loadProyectosDEP").innerHTML = '';
            document.getElementById('contenedorDeProyectosDEP').innerHTML = '';
            alertaImg('Error', '', 'error', 2000);
        });
}


// OBTIEN LOS PLANES DE ACCIÓN POR PORYECTO DEP
function obtenerPlanaccionDEP(idProyecto) {
    console.log(idProyecto);
    localStorage.setItem('idProyecto', idProyecto);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = 'obtenerPlanaccionDEP';
    const ruta = 'php/proyectos_planacciones.php?';
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idProyecto=${idProyecto}`;
    if (document.getElementById('tooltipProyectos').classList.contains('hidden')) {
        document.getElementById("loadProyectosDEP").innerHTML =
            '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
        console.log(URL);
        fetch(URL)
            .then(array => array.json())
            .then(array => {
                console.log(array);
                if (array.length > 0) {
                    document.getElementById('contenedorDePlanesdeaccionDEP').innerHTML = '';
                    document.getElementById('palabraProyecto').value = '';
                    for (let x = 0; x < array.length; x++) {
                        const id = array[x].id;
                        const destino = array[x].destino;
                        const actividad = array[x].actividad;
                        const creadoPor = array[x].creadoPor;
                        const subTareas = array[x].subTareas;
                        const responsable = array[x].responsable;
                        const fechaInicio = array[x].fechaInicio;
                        const fechaFin = array[x].fechaFin;
                        const comentarios = array[x].comentarios;
                        const adjuntos = array[x].adjuntos;
                        const justificacion = array[x].justificacion;
                        const coste = array[x].coste;
                        const status = array[x].status;
                        const materiales = array[x].materiales;
                        const energeticos = array[x].energeticos;
                        const departamentos = array[x].departamentos;
                        const trabajando = array[x].trabajando;

                        $tablaPlanesDEP.innerHTML += datosPlanesDEP({
                            id: id,
                            destino: destino,
                            actividad: actividad,
                            creadoPor: creadoPor,
                            subTareas: subTareas,
                            responsable: responsable,
                            fechaInicio: fechaInicio,
                            fechaFin: fechaFin,
                            comentarios: comentarios,
                            adjuntos: adjuntos,
                            justificacion: justificacion,
                            coste: coste,
                            status: status,
                            materiales: materiales,
                            energeticos: energeticos,
                            departamentos: departamentos,
                            trabajando: trabajando
                        });
                    }
                } else {
                    alertaImg('Sin Plan de Acción', '', 'info', 1500);
                    document.getElementById('contenedorDePlanesdeaccionDEP').innerHTML = '';
                }
            })
            .then(() => {
                document.getElementById("loadProyectosDEP").innerHTML = '';
            })
            .catch(function () {
                document.getElementById("loadProyectosDEP").innerHTML = '';
                document.getElementById('contenedorDePlanesdeaccionDEP').innerHTML = '';
            });
    } else {
        document.getElementById('contenedorDePlanesdeaccionDEP').innerHTML = '';
    }
}

// ********** EVENTOS **********
document.getElementById("btnActualizarTitulo").addEventListener('click', function () {
    toggleHidden('segmentoTitulo');
});