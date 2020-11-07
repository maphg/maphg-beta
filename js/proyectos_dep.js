'use strict';

// const $tablaProyectosDEP = document.getElementById('contenedorDeProyectosDEP');
const datosProyectosDEP = params => {
    var idProyecto = params.id;

    var cotizaciones = params.cotizaciones;
    var valorCotizaciones = 'X'

    var tipo = params.tipo;
    var valorTipo = 'X';

    var justificacion = params.justificacion;
    var valorjustificacion = 'X'

    var materiales = params.materiales;
    var materialesx = '';

    var departamento = params.departamento;
    var departamentox = '';

    var energeticos = params.energeticos;
    var energeticosx = '';

    var trabajando = params.trabajando;
    var trabajandox = '';

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
        var statusX = 'S-DEP-PENDIENTE';
        var fObtenerPlanaccion = `onclick="obtenerPlanaccionDEP(${idProyecto}); tooltipProyectosDEP(${idProyecto})"`;
        var fResponsable = `onclick="hiddenVista('tooltipProyectosDEP'); obtenerResponsablesProyectosDEP(${idProyecto})"`;
        var fRangoFecha = `onclick="hiddenVista('tooltipProyectosDEP'); obtenerDatoProyectosDEP(${idProyecto},'rango_fecha');"`;
        var fCotizaciones = `onclick="hiddenVista('tooltipProyectosDEP'); cotizacionesProyectos(${idProyecto});"`;
        var fTipo = `onclick="hiddenVista('tooltipProyectosDEP'); obtenerDatoProyectosDEP(${idProyecto}, 'tipo');"`;
        var fJustificacion = `onclick="hiddenVista('tooltipProyectosDEP'); obtenerDatoProyectosDEP(${idProyecto},'justificacion');"`;
        var fCoste = `onclick="hiddenVista('tooltipProyectosDEP'); obtenerDatoProyectosDEP(${idProyecto},'coste');"`;
        var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
        var fStatus = `onclick="hiddenVista('tooltipProyectosDEP'); statusProyectoDEP(${idProyecto});"`;

    } else {
        var statusX = 'S-DEP-SOLUCIONADO hidden';
        var fObtenerPlanaccion = `onclick="obtenerPlanaccionDEP(${idProyecto}); tooltipProyectosDEP(${idProyecto})"`;
        var fResponsable = `onclick="hiddenVista('tooltipProyectosDEP');"`;
        var fRangoFecha = `onclick="hiddenVista('tooltipProyectosDEP');"`;
        var fCotizaciones = `onclick="hiddenVista('tooltipProyectosDEP'); cotizacionesProyectos(${idProyecto});"`;
        var fTipo = `onclick="hiddenVista('tooltipProyectosDEP');"`;
        var fJustificacion = `onclick="hiddenVista('tooltipProyectosDEP'); obtenerDatoProyectosDEP(${idProyecto},'justificacion');"`;
        var fCoste = `onclick="hiddenVista('tooltipProyectosDEP');"`;
        var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        var fStatus = `onclick="actualizarProyectosDEP('N', 'status', ${idProyecto});"`;
    }

    return `
        <tr id="${idProyecto}proyectoDEP" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-proyectos-select-DEP ${statusX}">

            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;"
            ${fObtenerPlanaccion}>
                <div class="font-semibold uppercase leading-4">
                    <h1 id="${params.id}tituloProyectoDEP">${params.proyecto}</h1>
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

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable}>
                <h1>${params.responsable}</h1>
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fRangoFecha}>
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" 
            ${fCotizaciones}>
                <h1>${valorCotizaciones}</h1>
            </td>

            <td class="  whitespace-no-wrap border-b border-gray-200 text-center py-3" 
            ${fTipo}>
                ${valorTipo}
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 text-center text-lg py-3"
            ${fJustificacion}>
                ${valorjustificacion}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3"
            ${fCoste}>
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

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                <div class="px-2">
                    ${iconoStatus}
                </div>
            </td>
            
        </tr>
        `;
};


// const $tablaPlanesDEP = document.getElementById('contenedorDePlanesdeaccionDEP');
const datosPlanesDEP = params => {

    var idPlanaccion = params.id;

    var comentarios = params.comentarios;
    var valorcomentarios = 'X';

    var adjuntos = params.adjuntos;
    var valoradjuntos = 'X';

    var tipo = params.tipo;
    var valorTipo = 'X';

    var materiales = params.materiales;
    var materialesx = '';

    var departamento = params.departamento;
    var departamentox = '';

    var energeticos = params.energeticos;
    var energeticosx = '';

    var trabajando = params.trabajando;
    var trabajandox = '';

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

    if (params.status == "PENDIENTE") {
        var statusPlanaccion = 'planaccion_PENDIENTE';
        var fResponsable = `onclick="hiddenVista('tooltipActividadesPlanaccionDEP'); obtenerResponsablesPlanaccion(${idPlanaccion}); nivelVista(1,'modalUsuarios');"`;
        var fComentarios = `onclick="hiddenVista('tooltipActividadesPlanaccionDEP'); comentariosPlanaccion(${idPlanaccion}); nivelVista(1,'modalComentarios');"`;
        var fAdjuntos = `onclick="hiddenVista('tooltipActividadesPlanaccionDEP'); adjuntosPlanaccion(${idPlanaccion}); nivelVista(1,'modalMedia');"`;
        var fToolTip = `onclick="tooltipPlanaccionDEP(${idPlanaccion}); obtenerActividadesPlanaccionDEP(${idPlanaccion});"`;
        var fStatus = `onclick="hiddenVista('tooltipActividadesPlanaccionDEP'); statusPlanaccionDEP(${idPlanaccion}); nivelVista(1,'modalStatus');"`;
        var fOT = `onclick="generarOTPlanaccion(${idPlanaccion});"`;
        var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
        var ocultarActividades = `onclick="hiddenVista('tooltipEditarEliminarSolucionar');"`;
    } else {
        var statusPlanaccion = 'planaccion_SOLUCIONADO hidden';
        var fResponsable = '';
        var fComentarios = '';
        var fAdjuntos = '';
        var fToolTip = `onclick="tooltipPlanaccionDEP(${idPlanaccion}); obtenerActividadesPlanaccionDEP(${idPlanaccion});"`;
        var fStatus = `onclick="actualizarPlanaccionDEP('N','status', ${idPlanaccion});"`;
        var fOT = `onclick="generarOTPlanaccion(${idPlanaccion});"`;
        var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        var ocultarActividades = `onclick="hiddenVista('tooltipEditarEliminarSolucionar');"`;
    }

    return `
        <tr id="${idPlanaccion}planaccionDEP" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-planaccion-select-DEP ${statusPlanaccion}" ${ocultarActividades}>
           
            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;" 
            ${fToolTip}>
                <div class="font-semibold uppercase leading-4">
                    <h1 id="APDEP${idPlanaccion}">${params.actividad}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>
           
            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3"
            ${fToolTip}>
                <h1>${params.subTareas}</h1>
            </td>
           
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable}>
                <h1>${params.responsable}</h1>
            </td>
           
            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>
           
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fComentarios}>
                <h1>${valorcomentarios}</h1>
            </td>
           
            <td class=" whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fAdjuntos}>
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
            
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fOT}>
                <h1>${params.id}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                <div class="px-2">
                    ${iconoStatus}
                </div>
            </td>
            
        </tr>
        `;
};


const datosEtiquetados = params => {
    var id = params.id;

    var comentarios = params.comentarios;
    var valorcomentarios = '';

    var adjuntos = params.adjuntos;
    var valoradjuntos = '';

    var tipo = params.tipo;
    var valorTipo = '';

    var origen = params.origen;
    var valorOrigen = '';


    var materiales = params.materiales;
    var materialesx = ''

    var departamentos = params.departamentos;
    var departamentosx = ''

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

    switch (origen) {
        case 'PROYECTO':
            valorOrigen = '<div class="px-2 bg-purple-300 py-1 text-purple-600 rounded-full uppercase"><h1>Proyectos</h1></div>';
            break;
        case 'FALLA':
            valorOrigen = '<div class="px-2 bg-red-300 py-1 text-red-600 rounded-full uppercase"><h1>Fallas</h1></div>';
            break;
        case 'TAREA':
            valorOrigen = '<div class="px-2 bg-orange-300 py-1 text-orange-600 rounded-full uppercase"><h1>Tareas</h1></div>';
            break;
        case 'PREVENTIVO':
            valorOrigen = '<div class="px-2 bg-blue-300 py-1 text-blue-600 rounded-full uppercase"><h1>MP</h1></div>';
            break;
        default:
            valorOrigen = '';
    }

    switch (materiales) {
        case 1:
            materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
            break;
        default:
            materialesx = '';
    }

    switch (departamentos) {
        case 1:
            departamentosx = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
            break;
        default:
            departamentosx = '';
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

    var fActividades = '';
    var fResponsable = '';
    var fFecha = '';
    var fComentarios = '';
    var fAdjuntos = '';
    var fStatus = '';
var fOT = '';
    if (origen == "FALLA") {
        fActividades = `onclick="obtenerActividadesOT(${id}, 'FALLA');"`;
        fResponsable = `onclick="obtenerUsuarios('asignarMC', ${id});"`;
        fFecha = `onclick="obtenerFechaMC(${id}, '${params.fechaInicio} - ${params.fechaFin}');"`;
        fComentarios = `onclick="obtenerComentariosMC(${id});"`;
        fAdjuntos = `onclick="obtenerAdjuntosMC(${id});"`;
        fStatus = `onclick="obtenerstatusMC(${id});"`;
        fOT = `<a href="https://www.maphg.com/beta/OT_Fallas_Tareas/#F${id}" class="text-black" target="_blank">F${id}</a>`;
    } else if (origen == "TAREA") {
        fActividades = `onclick="obtenerActividadesOT(${id}, 'TAREA');"`;
        fResponsable = `onclick="obtenerUsuarios('asignarTarea', ${id});"`;
        fFecha = `onclick="obtenerFechaTareas(${id}, '${params.fechaInicio} - ${params.fechaFin}');"`;
        fComentarios = `onclick="obtenerComentariosTareas(${id});"`;
        fAdjuntos = `onclick="obtenerAdjuntosTareas(${id});"`;
        fStatus = `onclick="obtenerInformacionTareas(${id}, '${params.descripcion}')"`;
        fOT = `<a href="https://www.maphg.com/beta/OT_Fallas_Tareas/#T${id}" class="text-black" target="_blank">T${id}</a>`;
    } else if (origen == "PROYECTO") {
        fActividades = `onclick="tooltipPlanaccion(${id}); obtenerActividadesPlanaccion(${id});"`;
        fResponsable = `onclick="obtenerResponsablesPlanaccion(${id})"`;
        fFecha = ``;
        fComentarios = `onclick="comentariosPlanaccion(${id});"`;
        fAdjuntos = `onclick="adjuntosPlanaccion(${id});"`;
        fStatus = `onclick="statusPlanaccion(${id});"`;
        fOT = `<a href="OT_proyectos/#P${id}" class="text-black" target="_blank">P${id}</a>`;
    } else if (origen == "PREVENTIVO") {
        fActividades = ``;
        fResponsable = `onclick="toggleModalTailwind('modalUsuarios'); 
        obtenerUsuarios('asignarOT', ${id});"`;
        fFecha = ``;
        fComentarios = ``;
        fAdjuntos = `onclick="consultaAdjuntosOT(${id}); toggleModalTailwind('modalMedia');"`;
        fStatus = `onclick="consultaStatusOT(${id}); toggleModalTailwind('modalStatus');"`;
        fOT = ``;
    }

    if (params.status == "PENDIENTE") {
        var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
    } else {
        var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
    }

    return `
        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">

            <td class="px-4 border-b border-gray-200 py-3 truncate" style="max-width: 360px;" 
            ${fActividades}>
                <div class="font-semibold uppercase leading-4">
                    ${params.descripcion}
                </div>
                <div class="text-gray-500 leading-none flex items-center">
                    ${valorOrigen}<h1 class="mx-2 text-bluegray-500 uppercase font-semibold">${params.equipo}</h1> <h1 class="">Creado: ${params.creadoPor}</h1> 
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-3 text-center truncate" style="max-width: 360px;">
                <div class="font-semibold uppercase leading-none">
                    ${params.seccion}
                </div>
                <div class="text-gray-500 leading-none">
                 ${params.subseccion}
                </div>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                <h1>${fOT}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable}>
                <h1>${params.responsable}</h1>
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3"
            ${fFecha}>
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" 
            ${fComentarios}>
                <h1>${valorcomentarios}</h1>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 text-center py-3"
            ${fAdjuntos}>
            <h1>${valoradjuntos}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3">
                <div class="text-sm flex justify-center items-center font-bold">
                    ${materialesx}
                    ${energeticosx}
                    ${departamentosx}
                    ${trabajandox}
                </div>
            </td>
            
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <h1>${params.cod2bend}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <h1>${params.codsap}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                <div class="px-2">
                    ${iconoStatus}
                </div>
            </td>
            
        </tr>
        `;
};

// TOOLTIP PARA MOSTRAR LOS PLANESACCIÓN DE LOS PROYECTOS
function tooltipProyectosDEP(idProyecto) {
    // Ciclo para quitar bg-gray-200
    let filas = document.getElementsByClassName("fila-proyectos-select-DEP");
    for (let x = 0; x < filas.length; x++) {
        filas[x].classList.remove('bg-gray-300');
    }
    document.getElementById("tooltipProyectosDEP").classList.toggle('hidden');

    if (document.getElementById("tooltipProyectosDEP").classList.contains('hidden')) {
        document.getElementById(idProyecto + 'proyectoDEP').classList.remove('bg-gray-300');
    } else {
        document.getElementById(idProyecto + 'proyectoDEP').classList.add('bg-gray-300');
    }

    // Propiedades para el tooltip
    const button = document.getElementById(idProyecto + 'proyectoDEP');
    const tooltip = document.getElementById('tooltipProyectosDEP');
    Popper.createPopper(button, tooltip);
}


// TOOLTIP PARA MOSTRAR LOS PLANESACCIÓN DE LOS PROYECTOS
function tooltipPlanaccionDEP(idPlanaccion) {
    // Ciclo para quitar bg-gray-200
    let filas = document.getElementsByClassName("fila-planaccion-select-DEP");
    for (let x = 0; x < filas.length; x++) {
        filas[x].classList.remove('bg-gray-300');
    }
    document.getElementById("tooltipActividadesPlanaccionDEP").classList.toggle('hidden');

    if (document.getElementById("tooltipActividadesPlanaccionDEP").classList.contains('hidden')) {
        document.getElementById(idPlanaccion + 'planaccionDEP').classList.remove('bg-gray-300');
    } else {
        document.getElementById(idPlanaccion + 'planaccionDEP').classList.add('bg-gray-300');
    }

    // Propiedades para el tooltip
    const button = document.getElementById(idPlanaccion + 'planaccionDEP');
    const tooltip = document.getElementById('tooltipActividadesPlanaccionDEP');
    Popper.createPopper(button, tooltip, {
        placement: 'bottom'
    });
}


// OBTIENES LOS PROYECTOS DEP
function obtenerProyectosDEP(idSubseccion, statusProyecto, etiquetado) {
    document.getElementById("modalProyectosDEP").classList.add("open");
    document.getElementById("contendorEtiquetado").classList.add("hidden");
    document.getElementById("contenedorDEP").classList.remove("hidden");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    localStorage.setItem("idSubseccion", idSubseccion);

    // Atributos Iniciales
    document.getElementById("proyectosPendientesDEP").
        setAttribute('onclick', `obtenerProyectosDEP(${idSubseccion}, "PENDIENTE");`);
    document.getElementById("proyectosSolucionadosDEP").
        setAttribute('onclick', `obtenerProyectosDEP(${idSubseccion}, "SOLUCIONADO");`);
    document.getElementById("opcionProyectosDEP").
        setAttribute('onclick', `obtenerProyectosDEP(${idSubseccion}, "PENDIENTE");`);
    document.getElementById("etiquetadoProyectosDEP").
        setAttribute('onclick', "obtenerEtiquetados('PENDIENTE');");
    // Atributos Iniciales

    // Estilo para Botones Superiores
    estiloBotonesProyectos(statusProyecto, 'PROYECTOS');

    // Secciones de Botones.
    document.getElementById("btnCrearProyecto")
        .setAttribute("onclick", "agregarProyectoDEP()");
    document.getElementById("loadProyectosDEP").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';

    const action = "consultaProyectosDEP";
    const ruta = "php/proyectos_planacciones.php?";

    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubseccion=${idSubseccion}&status=${statusProyecto}&etiquetado=${etiquetado}`;
    console.log(URL);

    // OBTIENE NOMBRE DE LA SUBSECCIÓN
    fetch(`php/proyectos_planacciones.php?action=obtenerSubseccion&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubseccion=${idSubseccion}`)
        .then(array => array.json())
        .then(array => {
            document.getElementById("ProyectosSubseccionDEP").innerHTML = array.subseccion;
            document.getElementById("etiquetadoDEP").innerHTML = array.subseccion;
        });

    // OBTIENE LOS PROYECTOS
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById('contenedorDeProyectosDEP').innerHTML = '';
            if (array.length > 0) {
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

                    const dataProyectosz = datosProyectosDEP({
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
                    console.log(status);
                    document.getElementById("contenedorDeProyectosDEP").insertAdjacentHTML('beforeend', dataProyectosz);
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
    localStorage.setItem('idProyecto', idProyecto);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = 'obtenerPlanaccion';
    const ruta = 'php/proyectos_planacciones.php?';
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idProyecto=${idProyecto}`;
    document.getElementById("loadProyectosDEP").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById("contenedorDePlanesdeaccionDEP").innerHTML = '';
            if (!document.getElementById('tooltipProyectosDEP').classList.contains('hidden')) {
                if (array.length > 0) {
                    document.getElementById('palabraProyectoDEP').value = '';
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
                        const cod2bend = array[x].cod2bend;
                        const codsap = array[x].codsap;

                        const dataPlanaccion = datosPlanesDEP({
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
                            trabajando: trabajando,
                            cod2bend: cod2bend,
                            codsap: codsap
                        });

                        document.getElementById("contenedorDePlanesdeaccionDEP")
                            .insertAdjacentHTML('beforeend', dataPlanaccion);
                    }
                } else {
                    alertaImg('Sin Plan de Acción', '', 'info', 1500);
                }
            } else {
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

}


// OBTIENE LAS ACTIVIDAD RELACIONADAS PARA EL PLAN DE ACCIÓN
function obtenerActividadesPlanaccionDEP(idPlanaccion) {

    document.getElementById("loadProyectosDEP").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';

    localStorage.setItem('idPlanaccion', idPlanaccion);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = "obtenerActividadesPlanaccion";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idPlanaccion=${idPlanaccion}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            document.getElementById("dataActividadesDEP").innerHTML = '';
            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const idActividad = array[x].id;
                    const actividad = array[x].actividad;
                    var status = array[x].status;

                    if (status == "SOLUCIONADO") {
                        status = 'bg-green-300';
                    } else {
                        status = 'hove:bg-green-300';
                    }

                    const dataActividadesX = `
                        <div id="${idActividad}actividad" class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-fondos-2 fila-actividad-select">
                            <div class="w-4 h-4 border-2 border-gray-300 ${status} hover:border-green-400 cursor-pointer rounded-full mr-2 flex-none"></div>
                            <div class=" text-justify">
                                <h1 id="tituloActividad${idActividad}">${actividad}</h1>
                            </div>
                            <div class="px-2 text-gray-400 hover:text-purple-500 cursor-pointer" onclick="tooltipEditarEliminarSolucionar(${idActividad})">
                                <i class="fas fa-ellipsis-h  text-sm"></i>
                            </div>
                        </div>
                    `;

                    document.getElementById("dataActividadesDEP").
                        insertAdjacentHTML('beforeend', dataActividadesX);
                }
            }
        }).then(() => {
            document.getElementById("loadProyectosDEP").innerHTML = '';
        })
        .catch(function () {
            document.getElementById("loadProyectosDEP").innerHTML = '';
            document.getElementById("dataActividadesDEP").innerHTML = '';
            alertaImg('Sin Actividades', '', 'info', 1200);
        })
}


// Agregar Proyecto
function agregarProyectoDEP() {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let titulo = document.getElementById("tituloProyectoN").value;
    let tipo = document.getElementById("tipoProyectoN").value;
    let fecha = document.getElementById("fechaProyectoN").value;
    let responsable = document.getElementById("responsableProyectoN").value;
    let justificacion = document.getElementById("justificacionProyectoN").value;
    let coste = document.getElementById("costeProyectoN").value;
    let idSubseccion = localStorage.getItem('idSubseccion');
    const action = "agregarProyecto";
    if (titulo.length >= 1 && tipo.length >= 1 && fecha.length >= 1 && justificacion.length >= 1 && coste >= 0 && responsable > 0) {
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idSeccion: idSeccion,
                idSubseccion: idSubseccion,
                titulo: titulo,
                tipo: tipo,
                fecha: fecha,
                responsable: responsable,
                justificacion: justificacion,
                coste: coste,
            },
            // dataType: "JSON",
            success: function (data) {
                if (data == 1) {
                    obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                    obtenerDatosUsuario(idDestino);
                    alertaImg("Proyecto Agregado", "", "success", 2500);
                    document.getElementById("tituloProyectoN").value = "";
                    document.getElementById("tipoProyectoN").value = "";
                    document.getElementById("fechaProyectoN").value = "";
                    document.getElementById("responsableProyectoN").value = "";
                    document.getElementById("justificacionProyectoN").value = "";
                    document.getElementById("costeProyectoN").value = "";
                    document.getElementById("modalAgregarProyecto").classList.remove("open");
                    document.getElementById("contenidoProyectos").classList.remove('hidden');
                    document.getElementById("contenidoGantt").classList.add('hidden');
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
            },
        });
    } else {
        alertaImg("Información NO Valida", "", "warning", 3000);
    }
}


// AGREGA PLANESACCIÓN A PROYECTOS
function agregarPlanaccionDEP() {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let actividad = document.getElementById("agregarPlanaccionDEP").value;
    let idSeccion = localStorage.getItem('idSeccion');
    let idProyecto = localStorage.getItem('idProyecto');
    let idSubseccion = localStorage.getItem('idSubseccion');

    if (actividad.length >= 1) {
        const action = "agregarPlanaccion";
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idProyecto: idProyecto,
                actividad: actividad
            },
            // dataType: "JSON",
            success: function (data) {
                if (data.length > 1) {
                    document.getElementById("agregarPlanaccionDEP").value = '';
                    obtenerProyectosDEP(idSubseccion, 'PENDIENTE');
                    obtenerPlanaccionDEP(idProyecto);
                    alertaImg("Actividad Agregada", "", "success", 2500);
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
            },
        });
    } else {
        alertaImg("Intente de Nuevo", "", "info", 3000);
    }
}


// ACTUALIZA DATOS DEL PROYECTO (T_PROYECTOS)
function actualizarProyectosDEP(valor, columna, idProyecto) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let tipo = document.getElementById("tipoProyecto").value;
    let justificacion = document.getElementById("justificacionProyecto").value;
    let coste = document.getElementById("costeProyecto").value;
    let titulo = document.getElementById("inputEditarTitulo").value;
    let idSubseccion = localStorage.getItem('idSubseccion');
    const action = "actualizarProyectos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            valor: valor,
            columna: columna,
            idProyecto: idProyecto,
            justificacion: justificacion,
            tipo: tipo,
            coste: coste,
            titulo: titulo,
        },
        // dataType: "JSON",
        success: function (data) {
            if (data == 1) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                alertaImg("Responsable Actualizado", "", "success", 2000);
                document.getElementById("modalUsuarios").classList.remove("open");
            } else if (data == 2) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Justifiacion Actualizado", "", "success", 2000);
            } else if (data == 3) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Coste Actualizado", "", "success", 2000);
            } else if (data == 4) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Tipo Actualizado", "", "success", 2000);
            } else if (data == 5) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                document.getElementById("modalFechaProyectos").classList.remove("open");
                alertaImg("Fecha Actualizada", "", "success", 2000);
            } else if (data == 6) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Proyecto Eliminado", "", "success", 2000);
            } else if (data == 7) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                document.getElementById("modalEditarTitulo").classList.remove("open");
                alertaImg("Título Actualizado", "", "success", 2000);
            } else if (data == 8) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Proyecto Finalizado", "", "success", 2000);
            } else if (data == 9) {
                obtenerProyectosDEP(idSubseccion, "PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Proyecto Restaurado", "", "success", 2000);
            } else if (data == 10) {
                alertaImg("Solucione todas las actividades para poder Solucionar el Proyecto", "", "warning", 4000);
            } else {
                alertaImg("Intente de Nuevo", "", "info", 3000);
            }
        },
    });
}

//Optienes Usuarios posible para asignar responsable en Proyectos.
function obtenerResponsablesProyectosDEP(idProyecto) {
    document.getElementById("palabraUsuario").setAttribute("onkeyup", "obtenerResponsablesProyectos(" + idProyecto + ")");
    document.getElementById("modalUsuarios").classList.add("open");
    let idItem = idProyecto;
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let tipoAsginacion = "asignarProyectoDEP";
    let palabraUsuario = document.getElementById("palabraUsuario").value;
    const action = "obtenerUsuarios";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idItem: idItem,
            tipoAsginacion: tipoAsginacion,
            palabraUsuario: palabraUsuario,
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
        },
    });
}

// OBTIENE DATOS DE PROYECTOS
function obtenerDatoProyectosDEP(idProyecto, columna) {
    localStorage.setItem("idProyecto", idProyecto);

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");

    // Oculta Media en Justificación
    document.getElementById("mediaProyectos").classList.add('hidden');
    document.getElementById("dataImagenesProyecto").innerHTML = '';
    document.getElementById("dataAdjuntosProyecto").innerHTML = '';


    document.getElementById("tipoProyectoDiv").classList.add("hidden");
    document.getElementById("justificacionProyectoDiv").classList.add("hidden");
    document.getElementById("costeProyectoDiv").classList.add("hidden");

    if (columna == "justificacion") {
        justificacionAdjuntosProyectos(idProyecto);
        document.getElementById("modalActualizarProyecto").classList.add("open");
        document.getElementById("tituloActualizarProyecto").innerHTML = "JUSTIFIACIÓN";

        document.getElementById("justificacionProyectoDiv").classList.remove("hidden");

        document.getElementById("inputAdjuntosJP")
            .setAttribute("onchange",
                "subirJustificacionProyectosDEP(" + idProyecto + ', "t_proyectos_justificaciones")');

    } else if (columna == "coste") {
        document.getElementById("modalActualizarProyecto").classList.add("open");
        document.getElementById("tituloActualizarProyecto").innerHTML = "COSTE";
        document.getElementById("costeProyectoDiv").classList.remove("hidden");
    } else if (columna == "tipo") {
        document.getElementById("modalActualizarProyecto").classList.add("open");
        document.getElementById("tituloActualizarProyecto").innerHTML = "TIPO";
        document.getElementById("tipoProyectoDiv").classList.remove("hidden");
    } else if (columna == "rango_fecha") {
        document.getElementById("modalFechaProyectos").classList.add("open");
    }

    const action = "obtenerDatoProyectos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idProyecto: idProyecto,
            columna: columna,
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("tipoProyecto").value = data.tipo;
            document.getElementById("justificacionProyecto").value = data.justificacion;
            document.getElementById("costeProyecto").value = data.coste;
            document.getElementById("fechaProyecto").value = data.rangoFecha;

            document.getElementById("btnGuardarInformacion")
                .setAttribute("onclick", 'actualizarProyectosDEP(0, "' + columna + '",' + idProyecto + ")");
        },
    });
}

//SUBÉ JUSTIFICACIÓN DE PROYECTOS
function subirJustificacionProyectosDEP(idTabla, tabla) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let img = document.getElementById("inputAdjuntosJP").files;

    for (let index = 0; index < img.length; index++) {
        let imgData = new FormData();
        const action = "subirImagenGeneral";
        document.getElementById("cargandoAdjuntoJP").innerHTML =
            '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

        imgData.append("adjuntoUrl", img[index]);
        imgData.append("action", action);
        imgData.append("idUsuario", idUsuario);
        imgData.append("idDestino", idDestino);
        imgData.append("tabla", tabla);
        imgData.append("idTabla", idTabla);

        $.ajax({
            data: imgData,
            type: "POST",
            url: "php/plannerCrudPHP.php",
            contentType: false,
            processData: false,
            success: function (data) {
                if (data == 1) {
                    alertaImg("Proceso Cancelado", "", "info", 3000);
                } else if (data == 6) {
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                    obtenerDatoProyectosDEP(idTabla, 'justificacion');
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
                document.getElementById("cargandoAdjuntoJP").innerHTML = '';
            },
        });
    }
}


// OBTENER STATUS PLANACCIÓN
function statusProyectoDEP(idProyecto) {
    document.getElementById("modalTituloEliminar").classList.add("open");
    let tituloActual = document.getElementById(idProyecto + 'tituloProyectoDEP').innerHTML;
    document.getElementById("inputEditarTitulo").value = tituloActual;

    document.getElementById("btnEditarTitulo")
        .setAttribute("onclick", 'actualizarProyectosDEP(0, "titulo",' + idProyecto + ")");

    document.getElementById("eliminar").
        setAttribute("onclick", 'actualizarProyectosDEP(0, "eliminar",' + idProyecto + ")");

    document.getElementById("finalizar").
        setAttribute("onclick", 'actualizarProyectosDEP("F", "status",' + idProyecto + ")");
}


// STATUS PLANACCIÓN
function statusPlanaccionDEP(idPlanaccion) {
    let actividadActual = document.getElementById("APDEP" + idPlanaccion).innerHTML;
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion")

    document.getElementById("inputEditarTitulo").value = actividadActual;
    document.getElementById("modalStatus").classList.add("open");

    // Agregan Funciones en los Botones del modalStatus para poder Aplicar un Status
    document.getElementById("btnEditarTitulo").setAttribute("onclick", 'actualizarPlanaccionDEP(0,"actividad",' + idPlanaccion + ")");

    document.getElementById("statusActivo").setAttribute("onclick", 'actualizarPlanaccionDEP(0,"activo",' + idPlanaccion + ")");

    document.getElementById("statusFinalizar").setAttribute("onclick", 'actualizarPlanaccionDEP("F","status",' + idPlanaccion + ")");

    document.getElementById("statusMaterial").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "status_material",' + idPlanaccion + ")");

    document.getElementById("statusTrabajare").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "status_trabajando",' + idPlanaccion + ")");

    document.getElementById("statusElectricidad").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "energetico_electricidad",' + idPlanaccion + ")");

    document.getElementById("statusAgua").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "energetico_agua",' + idPlanaccion + ")");

    document.getElementById("statusDiesel").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "energetico_diesel",' + idPlanaccion + ")");

    document.getElementById("statusGas").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "energetico_gas",' + idPlanaccion + ")");

    document.getElementById("statusRRHH").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "departamento_rrhh",' + idPlanaccion + ")");

    document.getElementById("statusCalidad").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "departamento_calidad",' + idPlanaccion + ")");

    document.getElementById("statusDireccion").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "departamento_direccion",' + idPlanaccion + ")");

    document.getElementById("statusFinanzas").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "departamento_finanzas",' + idPlanaccion + ")");

    document.getElementById("statusCompras").setAttribute("onclick", 'actualizarPlanaccionDEP(1, "departamento_compras",' + idPlanaccion + ")");

    nivelVista(2, 'modalEditarTitulo');

    const action = "statusPlanaccion";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idPlanaccion: idPlanaccion,
        },
        dataType: "JSON",
        success: function (data) {
            // Llama la función para formatear el Modal de Status
            estiloDefectoModalStatus();

            if (data.sMaterial == 1) {
                estiloStatusActivoModalStatus("statusMaterial");
            }

            if (data.sTrabajando == 1) {
                estiloStatusActivoModalStatus("statusTrabajare");
            }

            if (data.eElectricidad == 1 || data.eAgua == 1 || data.eDiesel == 1 || data.eGas == 1) {
                estiloStatusActivoModalStatus("statusenergeticos");
            }

            if (data.eElectricidad == 1) {
                estiloStatusActivoModalStatus("statusElectricidad");
            }

            if (data.eAgua == 1) {
                estiloStatusActivoModalStatus("statusAgua");
            }

            if (data.eDiesel == 1) {
                estiloStatusActivoModalStatus("statusDiesel");
            }

            if (data.eGas == 1) {
                estiloStatusActivoModalStatus("statusGas");
            }

            if (data.dCalidad == 1 || data.dCompras == 1 || data.dDireccion == 1 || data.dFinanzas == 1 || data.dRRHH == 1) {
                estiloStatusActivoModalStatus("statusdep");
            }

            if (data.dCalidad == 1) {
                estiloStatusActivoModalStatus("statusCalidad");
            }

            if (data.dCompras == 1) {
                estiloStatusActivoModalStatus("statusCompras");
            }

            if (data.dDireccion == 1) {
                estiloStatusActivoModalStatus("statusDireccion");
            }

            if (data.dFinanzas == 1) {
                estiloStatusActivoModalStatus("statusFinanzas");
            }

            if (data.dRRHH == 1) {
                estiloStatusActivoModalStatus("statusRRHH");
            }
        },
    });
}


// ACTUALIZAR PLANACCIÓN
function actualizarPlanaccionDEP(valor, columna, idPlanaccion) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let actividad = document.getElementById("inputEditarTitulo").value;
    let idProyecto = localStorage.getItem('idProyecto');
    let idSubseccion = localStorage.getItem('idSubseccion');
    const action = "actualizarPlanaccion";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idPlanaccion: idPlanaccion,
            valor: valor,
            columna: columna,
            actividad: actividad,
        },
        // dataType: "JSON",
        success: function (data) {
            obtenerPlanaccionDEP(idProyecto);
            if (data == 1) {
                document.getElementById("modalUsuarios").classList.remove("open");
                alertaImg("Responsable Actualizado", "", "success", 2500);
                nivelVista(0, 'modalUsuarios')
            } else if (data == 2) {
                document.getElementById("modalEditarTitulo").classList.remove("open");
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Actualizada", "", "success", 2500);
            } else if (data == 3) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Eliminada", "", "success", 2500);
                obtenerProyectosDEP(idSubseccion, 'PENDIENTE');
            } else if (data == 4) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Solucionada", "", "success", 2500);
                obtenerProyectosDEP(idSubseccion, 'PENDIENTE');
            } else if (data == 5) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Status Actualizado", "", "success", 2500);
                obtenerProyectosDEP(idSubseccion, 'PENDIENTE');
            } else if (data == 6) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Restaurada", "", "success", 2500);
                obtenerProyectosDEP(idSubseccion, 'PENDIENTE');
            }
        },
    });
}


// AGREGA ACTIVIDAD PARA EL PLAN DE ACCIÓN
function agregarActividadPlanaccionDEP() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idPlanaccion = localStorage.getItem('idPlanaccion');
    let actividad = document.getElementById("agregarActividadPlanaccionDEP").value;
    let idProyecto = localStorage.getItem('idProyecto');
    const ruta = "php/proyectos_planacciones.php?";
    const action = "agregarActividadPlanaccion";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idPlanaccion=${idPlanaccion}&actividad=${actividad}`;
    if (actividad.length > 0) {
        fetch(URL)
            .then(res => res.json())
            .then(array => {
                if (array == "Agregado") {
                    alertaImg('Actividas Agregada', '', 'success', 1200);
                    document.getElementById("agregarActividadPlanaccionDEP").value = '';
                    obtenerPlanaccionDEP(idProyecto);
                    obtenerActividadesPlanaccionDEP(idPlanaccion);
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1200);
                }
            })
    } else {
        alertaImg('Intente de Nuevo', '', 'info', 1200);
    }
}


function obtenerEtiquetados(status) {
    document.getElementById("contendorEtiquetado").classList.remove("hidden");
    document.getElementById("contenedorDEP").classList.add("hidden");
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let idSubseccion = localStorage.getItem('idSubseccion');
    const action = "obtenerMarcados";
    const URL = `php/proyectos_planacciones.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSubseccion=${idSubseccion}&status=${status}`;

    // Atributos Iniciales
    document.getElementById("proyectosPendientesDEP").
        setAttribute('onclick', "obtenerEtiquetados('PENDIENTE');");

    document.getElementById("proyectosSolucionadosDEP").
        setAttribute('onclick', "obtenerEtiquetados('SOLUCIONADO');");

    document.getElementById("opcionProyectosDEP").
        setAttribute('onclick', `obtenerProyectosDEP(${idSubseccion}, "PENDIENTE");`);
    // Atributos Iniciales

    document.getElementById("loadProyectosDEP").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    console.log(URL);
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById("contenedorDeEtiquetados").innerHTML = '';
            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const id = array[x].id;
                    const seccion = array[x].seccion;
                    const subseccion = array[x].subseccion;
                    const equipo = array[x].equipo;
                    const descripcion = array[x].descripcion;
                    const creadoPor = array[x].creadoPor;
                    const origen = array[x].origen;
                    const responsable = array[x].responsable;
                    const fechaInicio = array[x].fechaInicio;
                    const fechaFin = array[x].fechaFin;
                    const comentarios = array[x].comentarios;
                    const adjuntos = array[x].adjuntos;
                    const energeticos = array[x].energeticos;
                    const materiales = array[x].materiales;
                    const departamentos = array[x].departamentos;
                    const trabajando = array[x].trabajando;
                    const status = array[x].status;
                    const cod2bend = array[x].cod2bend;
                    const codsap = array[x].codsap;
                    const ot = array[x].ot;

                    const dataEtiquetado = datosEtiquetados({
                        id: id,
                        seccion: seccion,
                        subseccion: subseccion,
                        equipo: equipo,
                        descripcion: descripcion,
                        creadoPor: creadoPor,
                        origen: origen,
                        responsable: responsable,
                        fechaInicio: fechaInicio,
                        fechaFin: fechaFin,
                        comentarios: comentarios,
                        adjuntos: adjuntos,
                        energeticos: energeticos,
                        materiales: materiales,
                        departamentos: departamentos,
                        trabajando: trabajando,
                        status: status,
                        cod2bend: cod2bend,
                        codsap: codsap,
                        ot: ot
                    });
                    document.getElementById("contenedorDeEtiquetados").insertAdjacentHTML('beforeend', dataEtiquetado);
                }
            } else {
                alertaImg('SIN ETIQUETADOS', '', 'info', 1200);
            }

        })
        .then(function () {
            document.getElementById("loadProyectosDEP").innerHTML = '';
        })
        .catch(function (err) {
            document.getElementById("loadProyectosDEP").innerHTML = '';
            document.getElementById("contenedorDeEtiquetados").innerHTML = '';
        });
}

// ********** EVENTOS **********

document.getElementById("btnActualizarTitulo").addEventListener('click', function () {
    toggleHidden('segmentoTitulo');
});

// EVENTO PARA MOSTRAR MODAL PARA AGREGAR PROYECTO
document.getElementById("agregarProyectoDEP").addEventListener('click', datosAgregarProyecto);

// EVENTO PARA  AGREGAR PLANACCIÓN
document.getElementById("btnagregarPlanaccionDEP").addEventListener('click', agregarPlanaccionDEP);

// EVENTO PARA  AGREGAR ACTIVIDAD EN PLANACCIÓN
document.getElementById("agregarActividadPlanaccionDEP").addEventListener('keyup', event => {
    if (event.keyCode === 13) {
        agregarActividadPlanaccionDEP();
    }
});


// EVENTO PARA  MOSTRAR PLANACCIÓN PENDIENTES
document.getElementById("planaccionPendientesDEP").addEventListener('click', () => {
    statusPlanaccionx('PENDIENTE');
});

// EVENTO PARA  MOSTRAR PLANACCIÓN SOLUCIONADOS
document.getElementById("planaccionSolucionadosDEP").addEventListener('click', () => {
    statusPlanaccionx('SOLUCIONADO');
});

// EVENTO PARA  AGREGAR ACTIVIDAD EN PLANACCIÓN
document.getElementById("btnAgregarActividadPlanaccionDEP").addEventListener('click', agregarActividadPlanaccionDEP);

// EVENTO PARA PROYECTOS SOLUCIONADOS
document.getElementById("btnCerrerModalProyectosDEP").addEventListener('click', function () {
    document.getElementById("tooltipProyectosDEP").classList.add('hidden');
    document.getElementById("tooltipActividadesPlanaccionDEP").classList.add('hidden');
});


// EVENTO PARA BUSCAR PROYECTOS EN LA TABLA
document.getElementById("palabraProyectoDEP").addEventListener('keyup', function () {
    buscdorTabla('contenedorDeProyectosDEP', 'palabraProyectoDEP', 0);
    buscdorTabla('contenedorDeEtiquetados', 'palabraProyectoDEP', 0);
});

// document.getElementById("opcionProyectosDEP").addEventListener('click', function () {
//     document.getElementById("contenedorDEP").classList.remove('hidden');
//     document.getElementById("contendorEtiquetado").classList.add('hidden');
// });

// document.getElementById("etiquetadoProyectosDEP").addEventListener('click', function () {
//     document.getElementById("contenedorDEP").classList.add('hidden');
//     document.getElementById("contendorEtiquetado").classList.remove('hidden');
//     obtenerEtiquetados();
// });