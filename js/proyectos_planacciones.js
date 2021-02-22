'use strict'
// const $tablaProyectos = document.getElementById('contenedorDeProyectos');
const datosProyectos = params => {
    var cotizaciones = params.cotizaciones;
    var valorCotizaciones = '';

    var tipo = params.tipo;
    var valorTipo = '';

    var justificacion = params.justificacion;
    var valorjustificacion = '';

    var materiales = params.materiales;
    var materialesx = ''

    var departamento = params.departamento;
    var departamentox = ''

    var energeticos = params.energeticos;
    var energeticosx = ''

    var trabajando = params.trabajando;
    var trabajandox = ''

    var idProyecto = params.id;

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

    const sEP = params.sEP >= 1 ?
        '<div class="bg-yellow-300 w-6 h-6 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>EP</h1></div>'
        : '';

    // Valor Inicial
    var fResponsable = '';
    var fJustificacionAdjunto = '';
    var fStatus = '';
    var fRangoFecha = '';
    var fCotizaciones = '';
    var fTipo = '';
    var fJustificacion = '';
    var fCoste = '';
    var fPresupuesto = '';
    var fToolTip = '';
    var iconoStatus = '';
    var ocultarActividades = `onclick="hiddenVista('tooltipActividadesPlanaccion'); hiddenVista('tooltipEditarEliminarSolucionar');"`;

    if (params.status == "PENDIENTE" || params.status == "N") {
        fResponsable = `onclick="hiddenVista('tooltipProyectos'); obtenerResponsablesProyectos(${idProyecto})"`;

        fStatus = `onclick="hiddenVista('tooltipProyectos'); statusProyecto(${idProyecto});"`;
        fRangoFecha = `onclick="hiddenVista('tooltipProyectos'); obtenerDatoProyectos(${idProyecto},'rango_fecha');"`;

        fCotizaciones = `onclick="hiddenVista('tooltipProyectos'); cotizacionesProyectos(${idProyecto});"`;

        fTipo = `onclick="hiddenVista('tooltipProyectos'); obtenerDatoProyectos(${idProyecto}, 'tipo');"`;

        fJustificacion = `onclick="hiddenVista('tooltipProyectos'); obtenerDatoProyectos(${idProyecto},'justificacion');"`;

        fCoste = `onclick="hiddenVista('tooltipProyectos'); obtenerDatoProyectos(${idProyecto},'coste');"`;

        fPresupuesto = `onclick="hiddenVista('tooltipProyectos'); obtenerPresupuestoProyecto(${idProyecto}); toggleModalTailwind('modalPresupuestoProyecto')"`;

        fToolTip = `onclick="tooltipProyectos(${idProyecto}); obtenerPlanaccion(${idProyecto});"`;
        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';

    } else {
        iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        fStatus = `onclick="actualizarProyectos('N', 'status', ${idProyecto});"`;
    }

    return `
        <tr id="${params.id}proyecto" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-proyectos-select" ${ocultarActividades}>

            <td class="px-4 border-b border-gray-200 py-3" ${fToolTip} style="max-width: 360px;">
                <div class="font-semibold uppercase leading-4" data-title="${params.proyecto}">
                    <h1 id="${params.id}tituloProyecto" class="truncate">${params.proyecto}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1 class="mr-2 font-semibold">${params.destino}</h1>
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fToolTip}>
                <h1>${params.pda}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable}>
                <h1>${params.responsable}</h1>
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fRangoFecha}>
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fCotizaciones}>
                <h1>${valorCotizaciones}</h1>
            </td>

            <td class="  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fTipo}>
                ${valorTipo}
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 text-center text-lg py-3" ${fJustificacion}>
                ${valorjustificacion}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" 
            ${fCoste}>
                <h1>$ ${params.coste}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" 
            ${fPresupuesto}>
                <h1>$ ${params.presupuesto}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3">
                <div class="text-sm flex justify-center items-center font-bold">
                    ${materialesx}
                    ${energeticosx}
                    ${departamentox}
                    ${trabajandox}                                                
                    ${sEP}                                                
                </div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                <div class="px-2">
                    ${iconoStatus}
                </div>
            </td>
            
        </tr>
        `;
}


// const $tablaPlanes = document.getElementById('contenedorDePlanesdeaccion');
const datosPlanaccion = params => {
    var idPlanaccion = params.id;

    var comentarios = params.comentarios;
    var valorcomentarios = 'X'

    var adjuntos = params.adjuntos;
    var valoradjuntos = 'X'

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

    const sEP = params.sEP >= 1 ?
        '<div class="bg-yellow-300 w-6 h-6 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>EP</h1></div>'
        : '';

    var fResponsable = '';
    var fComentarios = '';
    var fAdjuntos = '';
    var fStatus = '';
    var iconoStatus = '';
    var fToolTip = `onclick="tooltipPlanaccion(${idPlanaccion}); obtenerActividadesPlanaccion(${idPlanaccion});"`;
    // var fOT = `onclick="generarOTPlanaccion(${idPlanaccion});"`;
    var fOT = `<a href="OT_proyectos/#P${idPlanaccion}" class="text-black" target="_blank"> 
    ${idPlanaccion}</a>`;
    var fRangoFecha = '';
    var statusPlanaccion = '';
    var ocultarActividades = `onclick="hiddenVista('tooltipEditarEliminarSolucionar');"`;
    if (params.status == "PENDIENTE") {
        statusPlanaccion = 'planaccion_PENDIENTE';
        fResponsable = `onclick="hiddenVista('tooltipActividadesPlanaccion'); obtenerResponsablesPlanaccion(${idPlanaccion});"`;
        fComentarios = `onclick="hiddenVista('tooltipActividadesPlanaccion'); comentariosPlanaccion(${idPlanaccion}); nivelVista(1,'modalComentarios');"`;
        fAdjuntos = `onclick="hiddenVista('tooltipActividadesPlanaccion'); adjuntosPlanaccion(${idPlanaccion}); nivelVista(1,'modalMedia');"`;
        fStatus = `onclick="hiddenVista('tooltipActividadesPlanaccion'); statusPlanaccion(${idPlanaccion}); nivelVista(1,'modalStatus');"`;
        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
        fRangoFecha = `onclick="abrirmodal('modalRangoFechaX'); obtenerRangoFechaPlanaccion(${idPlanaccion})"`;
    } else {
        fStatus = `onclick="actualizarPlanaccion('N','status', ${idPlanaccion});"`;
        iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        statusPlanaccion = 'planaccion_SOLUCIONADO hidden';
    }

    return `
    <tr id="${idPlanaccion}planaccion" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-planaccion-select ${statusPlanaccion}" ${ocultarActividades}>
            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;" 
            ${fToolTip}>
                <div class="font-semibold uppercase leading-4">
                    <h1 id="AP${idPlanaccion}">${params.actividad}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>
            <td id="${idPlanaccion}planaccionX" class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" 
            ${fToolTip}>
                <h1>${params.subTareas}</h1>
            </td>
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable}>
                <h1>${params.responsable}</h1>
            </td>
            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fRangoFecha}>
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
                    ${departamentosx}
                    ${trabajandox}
                    ${sEP}
                </div>
            </td>
            
            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                <h1>${fOT}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                <div class="px-2">
                    ${iconoStatus}
                </div>
            </td>                        
        </tr>
        `;
}


// Función para Input Fechas PROYECTOS
$(function () {
    $('input[name="fechaProyecto"]').daterangepicker({
        autoUpdateInput: true,
        showWeekNumbers: true,
        locale: {
            cancelLabel: "Cancelar",
            applyLabel: "Aplicar",
            fromLabel: "De",
            toLabel: "A",
            customRangeLabel: "Personalizado",
            weekLabel: "S",
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        },
    });

    $('input[name="fechaProyecto"]').on("apply.daterangepicker", function (ev, picker) {
        $(this).val(picker.startDate.format("DD/MM/YYYY") + " - " + picker.endDate.format("DD/MM/YYYY")
        );

        // Actualiza fecha TAREAS cuando se Aplica el rango.
        let rangoFecha =
            picker.startDate.format("DD/MM/YYYY") +
            " - " +
            picker.endDate.format("DD/MM/YYYY");
        let idProyecto = localStorage.getItem("idProyecto");
        actualizarProyectos(rangoFecha, "rango_fecha", idProyecto);
    });
    $('input[name="fechaProyecto"]').on("cancel.daterangepicker", function (
        ev,
        picker
    ) {
        $(this).val("");
    });
})


// TOOLTIP PARA MOSTRAR LOS PLANESACCIÓN DE LOS PROYECTOS
function tooltipProyectos(idproyecto) {
    // Ciclo para quitar bg-gray-200
    let filas = document.getElementsByClassName("fila-proyectos-select");
    for (let x = 0; x < filas.length; x++) {
        filas[x].classList.remove('bg-gray-300');
    }
    document.getElementById("tooltipProyectos").classList.toggle('hidden');

    if (document.getElementById("tooltipProyectos").classList.contains('hidden')) {
        document.getElementById(idproyecto + 'proyecto').classList.remove('bg-gray-300');
    } else {
        document.getElementById(idproyecto + 'proyecto').classList.add('bg-gray-300');
    }

    // Propiedades para el tooltip
    const button = document.getElementById(idproyecto + 'proyecto');
    const tooltip = document.getElementById('tooltipProyectos');
    Popper.createPopper(button, tooltip, {
        placement: 'bottom-start'
    });
}


// TOOLTIP PARA MOSTRAR LOS PLANESACCIÓN DE LOS PROYECTOS
function tooltipPlanaccion(idPlanaccion) {
    // Ciclo para quitar bg-gray-200
    let filas = document.getElementsByClassName("fila-planaccion-select");
    for (let x = 0; x < filas.length; x++) {
        filas[x].classList.remove('bg-gray-300');
    }
    document.getElementById("tooltipActividadesPlanaccion").classList.toggle('hidden');

    if (document.getElementById("tooltipActividadesPlanaccion").classList.contains('hidden')) {
        document.getElementById(idPlanaccion + 'planaccion').classList.remove('bg-gray-300');
    } else {
        document.getElementById(idPlanaccion + 'planaccion').classList.add('bg-gray-300');
    }

    // Propiedades para el tooltip
    const button = document.getElementById(idPlanaccion + 'planaccionX');
    const tooltip = document.getElementById('tooltipActividadesPlanaccion');
    Popper.createPopper(button, tooltip, {
        placement: 'bottom'
    });
}


// TOOLTIP PARA MOSTRAR LOS PLANESACCIÓN DE LOS PROYECTOS
function tooltipEditarEliminarSolucionar(idActividad) {
    localStorage.setItem('idActividad', idActividad);
    let tituloActividad = document.getElementById('tituloActividad' + idActividad).innerHTML;
    document.getElementById("inputTitulo").value = tituloActividad;

    // Ciclo para quitar bg-gray-200
    let filas = document.getElementsByClassName("fila-actividad-select");
    for (let x = 0; x < filas.length; x++) {
        filas[x].classList.remove('bg-gray-300');
    }
    document.getElementById("tooltipEditarEliminarSolucionar").classList.toggle('hidden');

    if (document.getElementById("tooltipEditarEliminarSolucionar").classList.contains('hidden')) {
        document.getElementById(idActividad + 'actividad').classList.remove('bg-gray-300');
    } else {
        document.getElementById(idActividad + 'actividad').classList.add('bg-gray-300');
    }

    // Propiedades para el tooltip
    const button = document.getElementById(idActividad + 'actividad');
    const tooltip = document.getElementById('tooltipEditarEliminarSolucionar');
    Popper.createPopper(button, tooltip, {
        placement: 'top'
    });

    document.getElementById("btnFinalizar").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, 'SOLUCIONADO', 'STATUS')`);

    document.getElementById("btnTitulo").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, 'ACTIVIDAD', 'ACTIVIDAD')`);

    document.getElementById("btnEliminar").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, '0', 'ACTIVO')`);

    if (document.getElementById(idActividad + 'actividad').childNodes[1].classList.contains('bg-green-300')) {
        document.getElementById("btnFinalizar").classList.remove('hover:bg-green-200');
        document.getElementById("btnFinalizar").classList.add('bg-green-200');
    } else {
        document.getElementById("btnFinalizar").classList.add('hover:bg-green-200');
        document.getElementById("btnFinalizar").classList.remove('bg-green-200');
    }
}


// OBTIENES LOS PROYECTOS
function obtenerProyectos(idSeccion, status = 'PENDIENTE') {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSubseccion = localStorage.getItem('idSubseccion');

    // Atributos Iniciales
    document.getElementById("proyectosPendientes").setAttribute('onclick', `obtenerProyectos(${idSeccion}, "PENDIENTE");`);
    document.getElementById("proyectosSolucionados").setAttribute('onclick', `obtenerProyectos(${idSeccion}, "SOLUCIONADO");`);
    // Atributos Iniciales

    // Actualiza la Sección
    localStorage.setItem("idSeccion", idSeccion);

    // Estilo para Botones Superiores
    estiloBotonesProyectos(status, 'PROYECTOS');

    // Secciones de Botones.
    document.getElementById("btnCrearProyecto")
        .setAttribute("onclick", "agregarProyecto()");

    const action = "obtenerProyectos";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&status=${status}`;
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';

    fetch(URL)
        .then(resp => resp.json())
        .then(array => {
            if (array.length > 0) {
                document.getElementById('contenedorDeProyectos').innerHTML = '';
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
                    const presupuesto = array[x].presupuesto;
                    const status = array[x].status;
                    const materiales = array[x].materiales;
                    const energeticos = array[x].energeticos;
                    const departamento = array[x].departamento;
                    const trabajando = array[x].trabajando;
                    const sEP = array[x].sEP;


                    const dataProyectos = datosProyectos({
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
                        presupuesto: presupuesto,
                        status: status,
                        materiales: materiales,
                        energeticos: energeticos,
                        departamento: departamento,
                        trabajando: trabajando,
                        sEP: sEP,
                    });

                    document.getElementById("contenedorDeProyectos").insertAdjacentHTML('beforeend', dataProyectos);
                }
            } else {
                alertaImg('Sin Proyectos', '', 'info', 1500);
                document.getElementById('contenedorDeProyectos').innerHTML = '';
            }
        })
        .then(() => {
            // Quita el Loader hasta que Finalize la carga de Proyectos
            document.getElementById("loadProyectos").innerHTML = '';
        })
        .catch(function () {
            document.getElementById("loadProyectos").innerHTML = '';
            document.getElementById('contenedorDeProyectos').innerHTML = '';
        });
}


// FORMATEA Y APLICA EL ESTILO A LOS DE BOTONES, EN LA PARTE DE MODALPROYECTOS
function estiloBotonesProyectos(status, opcion = 'PROYECTOS') {
    let botones = ['opcionGanttProyectos', 'opcionProyectos', 'proyectosPendientes', 'proyectosSolucionados'];
    for (let x = 0; x < botones.length; x++) {
        const boton = botones[x];
        document.getElementById(boton).classList.remove('bg-purple-200');
        document.getElementById(boton).classList.add('bg-purple-600');
    }

    if (opcion == "PROYECTOS") {
        document.getElementById("opcionProyectos").classList.add('bg-purple-200');
        document.getElementById("opcionProyectos").classList.remove('bg-purple-600');
    } else {
        document.getElementById("opcionGanttProyectos").classList.add('bg-purple-200');
        document.getElementById("opcionGanttProyectos").classList.remove('bg-purple-600');
    }

    if (status == "PENDIENTE") {
        document.getElementById("proyectosPendientes").classList.add('bg-purple-200');
        document.getElementById("proyectosPendientes").classList.remove('bg-purple-600');
    } else {
        document.getElementById("proyectosSolucionados").classList.add('bg-purple-200');
        document.getElementById("proyectosSolucionados").classList.remove('bg-purple-600');
    }
}


function obtenerRangoFechaPlanaccion(idPlanaccion) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerRangoFechaPlanaccion";

    document.getElementById("btnAplicarRangoFecha").
        setAttribute('onclick', `actualizarPlanaccion(1, 'rango_fecha', ${idPlanaccion});`);

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario,
            idPlanaccion: idPlanaccion
        },
        dataType: "JSON",
        success: function (data) {
            if (document.getElementById("rangoFechaX")) {
                document.getElementById("rangoFechaX").value = data;
            }
        }
    })
}


// ACTUALIZA DATOS DEL PROYECTO (T_PROYECTOS)
function actualizarProyectos(valor, columna, idProyecto) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let tipo = document.getElementById("tipoProyecto").value;
    let justificacion = document.getElementById("justificacionProyecto").value;
    let coste = document.getElementById("costeProyecto").value;
    let titulo = document.getElementById("inputEditarTitulo").value;
    let presupuesto = presupuestoProyecto.value;

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
            presupuesto: presupuesto
        },
        // dataType: "JSON",
        success: function (data) {
            if (data == 1) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                alertaImg("Responsable Actualizado", "", "success", 2000);
                document.getElementById("modalUsuarios").classList.remove("open");
            } else if (data == 2) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalActualizarProyecto');
                alertaImg("Justifiación Actualizado", "", "success", 2000);
            } else if (data == 3) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalActualizarProyecto');
                alertaImg("Coste Actualizado", "", "success", 2000);
            } else if (data == 4) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalActualizarProyecto');
                alertaImg("Tipo Actualizado", "", "success", 2000);
            } else if (data == 5) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalFechaProyectos');
                alertaImg("Fecha Actualizada", "", "success", 2000);
            } else if (data == 6) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalTituloEliminar');
                alertaImg("Proyecto Eliminado", "", "success", 2000);
            } else if (data == 7) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalTituloEliminar');
                cerrarmodal('modalEditarTitulo');
                alertaImg("Título Actualizado", "", "success", 2000);
            } else if (data == 8) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalTituloEliminar');
                alertaImg("Proyecto Finalizado", "", "success", 2000);
            } else if (data == 9) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalTituloEliminar');
                alertaImg("Proyecto Restaurado", "", "success", 2000);
            } else if (data == 11) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalPresupuestoProyecto');
                alertaImg("Presupuesto Actualizado", "", "success", 2000);
            } else if (data == 10) {
                alertaImg("Solucione todas las actividades para poder Solucionar el Proyecto", "", "warning", 4000);
            } else {
                alertaImg("Intente de Nuevo", "", "info", 3000);
            }
        },
    });
}


// OBTIENE DATOS DE PROYECTOS
function obtenerDatoProyectos(idProyecto, columna) {
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
                "subirJustificacionProyectos(" + idProyecto + ', "t_proyectos_justificaciones")');

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
                .setAttribute("onclick", 'actualizarProyectos(0, "' + columna + '",' + idProyecto + ")");
        },
    });
}


const obtenerPresupuestoProyecto = (idProyecto) => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('idUsuario');

    btnPresupuestoProyecto.
        setAttribute('onclick', `actualizarProyectos(0, 'presupuesto', ${idProyecto})`);

    const action = "obtenerProyectoPorID";
    const URL = `php/proyectos_planacciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idProyecto=${idProyecto}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const presupuesto = array[x].presupuesto;
                    presupuestoProyecto.value = presupuesto;
                }
            }
        })
}

// Obtener Opciones de Responsables para Proyectos
function datosAgregarProyecto() {
    document.getElementById("responsableProyectoN").innerHTML = "";
    document.getElementById("modalAgregarProyecto").classList.add("open");
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");

    const action = "obtenerResponsables";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("responsableProyectoN").innerHTML = data.dataUsuarios;
        },
    });
}


// Agregar Proyecto
function agregarProyecto() {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let idSubseccion = localStorage.getItem('idSubseccion');
    let titulo = document.getElementById("tituloProyectoN").value;
    let tipo = document.getElementById("tipoProyectoN").value;
    let fecha = document.getElementById("fechaProyectoN").value;
    let responsable = document.getElementById("responsableProyectoN").value;
    let justificacion = document.getElementById("justificacionProyectoN").value;
    let coste = document.getElementById("costeProyectoN").value;
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
                    obtenerProyectos(idSeccion, "PENDIENTE");
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


//Optienes Usuarios posible para asignar responsable en Proyectos.
function obtenerResponsablesProyectos(idProyecto) {
    document.getElementById("palabraUsuario").setAttribute("onkeyup", `obtenerResponsablesProyectos(${idProyecto})`);

    document.getElementById("modalUsuarios").classList.add("open");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let palabraUsuario = document.getElementById("palabraUsuario").value;

    const action = "obtenerUsuarios";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&palabraUsuario=${palabraUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataUsuarios.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idUsuarioX = array[x].idUsuario;
                    const nombre = array[x].nombre;
                    const apellido = array[x].apellido;
                    const cargo = array[x].cargo;

                    const codigo = `
                        <div class="w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate" onclick="actualizarProyectos(${idUsuarioX}, 'asignarProyecto', ${idProyecto});">
                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="20" height="20" alt="">
                        <h1 class="ml-2">${nombre} ${apellido}</h1>
                        <p class="font-bold mx-1"> / </p>
                        <h1 class="font-normal text-xs">${cargo}</h1>
                        </div>
                        `;
                    dataUsuarios.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            dataUsuarios.innerHTML = '';
            fetch(APIERROR + err);
        })
}


//SUBÉ JUSTIFICACIÓN DE PROYECTOS
function subirJustificacionProyectos(idTabla, tabla) {
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
                    obtenerDatoProyectos(idTabla, 'justificacion');
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
                document.getElementById("cargandoAdjuntoJP").innerHTML = '';
            },
        });
    }
}


// JUSTIFICACIÓN PROYECTOS ADJUNTOS
function justificacionAdjuntosProyectos(idProyecto) {

    document.getElementById("mediaProyectos").classList.remove('hidden');
    document.getElementById("contenedorImagenesJP").classList.add('hidden');
    document.getElementById("contenedorDocumentosJP").classList.add('hidden');

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idTabla = idProyecto;
    const tabla = "t_proyectos_justificaciones";
    const action = "obtenerAdjuntos";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idProyecto: idProyecto,
            idTabla: idTabla,
            tabla: tabla
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("dataImagenesProyecto").innerHTML = '';
            document.getElementById("dataAdjuntosProyecto").innerHTML = '';
            if (data.imagen != "") {
                document.getElementById("dataImagenesProyecto").innerHTML = data.imagen;
                document.getElementById("contenedorImagenesJP").classList.remove('hidden');
            }

            if (data.documento != "") {
                document.getElementById("dataAdjuntosProyecto").innerHTML = data.documento;
                document.getElementById("contenedorDocumentosJP").classList.remove('hidden');
            }
        }
    });
}


// OBTENER STATUS PLANACCIÓN
function statusProyecto(idProyecto) {
    abrirmodal('modalTituloEliminar');
    let tituloActual = document.getElementById(idProyecto + 'tituloProyecto').innerHTML;
    document.getElementById("inputEditarTitulo").value = tituloActual;

    document.getElementById("btnconfirmEditarTituloX")
        .setAttribute("onclick", 'actualizarProyectos(0, "titulo",' + idProyecto + ")");

    document.getElementById("eliminar").
        setAttribute("onclick", 'actualizarProyectos(0, "eliminar",' + idProyecto + ")");

    document.getElementById("finalizar").
        setAttribute("onclick", 'actualizarProyectos("F", "status",' + idProyecto + ")");
}


// Obtienes las Cotizaciones de PROYECTOS
function cotizacionesProyectos(idProyecto) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idTabla = idProyecto;
    let tabla = "t_proyectos_adjuntos";

    document.getElementById("contenedorImagenes").classList.add('hidden');
    document.getElementById("contenedorDocumentos").classList.add('hidden');

    document.getElementById("modalMedia").classList.add("open");
    document
        .getElementById("inputAdjuntos")
        .setAttribute(
            "onchange",
            "subirImagenGeneral(" + idProyecto + ', "t_proyectos_adjuntos")'
        );

    const action = "obtenerAdjuntos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTabla: idTabla,
            tabla: tabla,
        },
        dataType: "JSON",
        success: function (data) {
            if (data.imagen != "") {
                document.getElementById("dataImagenes").innerHTML = data.imagen;
                document.getElementById("contenedorImagenes").classList.remove('hidden');
            }

            if (data.documento != "") {
                document.getElementById("dataAdjuntos").innerHTML = data.documento;
                document.getElementById("contenedorDocumentos").classList.remove('hidden');
            }
        },
    });
}


// OBTIEN LOS PLANES DE ACCIÓN POR PORYECTO
function obtenerPlanaccion(idProyecto) {
    localStorage.setItem('idProyecto', idProyecto);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    const action = 'obtenerPlanaccion';
    const URL = `php/proyectos_planacciones.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idProyecto=${idProyecto}`;

    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById("contenedorDePlanesdeaccion").innerHTML = '';
            if (!document.getElementById('tooltipProyectos').classList.contains('hidden')) {
                if (array.length > 0) {
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
                        const sEP = array[x].sEP;

                        const dataPlanaccion = datosPlanaccion({
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
                            sEP: sEP
                        });

                        document.getElementById("contenedorDePlanesdeaccion")
                            .insertAdjacentHTML('beforeend', dataPlanaccion);
                    }
                } else {
                    alertaImg('Sin Plan de Acción', '', 'info', 1500);
                }
            } else {
                document.getElementById('contenedorDePlanesdeaccion').innerHTML = '';
            }
        })
        .then(() => {
            document.getElementById("loadProyectos").innerHTML = '';
        })
        .catch(function () {
            document.getElementById("loadProyectos").innerHTML = '';
            document.getElementById('contenedorDePlanesdeaccion').innerHTML = '';
        });
}


// OBTIENE RESPONSABLE PARA PLAN DE ACCIÓN
function obtenerResponsablesPlanaccion(idPlanaccion) {
    document.getElementById("palabraUsuario").setAttribute("onkeyup", `obtenerResponsablesPlanaccion(${idPlanaccion})`);
    document.getElementById("modalUsuarios").classList.add("open");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let palabraUsuario = document.getElementById("palabraUsuario").value;

    const action = "obtenerUsuarios";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&palabraUsuario=${palabraUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataUsuarios.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idUsuarioX = array[x].idUsuario;
                    const nombre = array[x].nombre;
                    const apellido = array[x].apellido;
                    const cargo = array[x].cargo;

                    const codigo = `
                        <div class="w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate" onclick="actualizarPlanaccion(${idUsuarioX}, 'asignarPlanaccion', ${idPlanaccion});">
                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="20" height="20" alt="">
                        <h1 class="ml-2">${nombre} ${apellido}</h1>
                        <p class="font-bold mx-1"> / </p>
                        <h1 class="font-normal text-xs">${cargo}</h1>
                        </div>
                        `;
                    dataUsuarios.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            dataUsuarios.innerHTML = '';
            fetch(APIERROR + err);
        })

}


// ACTUALIZAR PLANACCIÓN
function actualizarPlanaccion(valor, columna, idPlanaccion) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let actividad = document.getElementById("editarTitulo").value;
    let idProyecto = localStorage.getItem('idProyecto');
    let codigoSeguimiento = document.getElementById("inputCod2bend").value;
    let rangoFecha = document.getElementById("rangoFechaX").value;
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
            codigoSeguimiento: codigoSeguimiento,
            rangoFecha: rangoFecha
        },
        // dataType: "JSON",
        success: function (data) {

            verEnPlanner('PLANACCION', idPlanaccion);
            if (data == 1) {
                document.getElementById("modalUsuarios").classList.remove("open");
                alertaImg("Responsable Actualizado", "", "success", 2500);
            } else if (data == 2) {
                document.getElementById("modalEditarTitulo").classList.remove("open");
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Actualizada", "", "success", 2500);
            } else if (data == 3) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Eliminada", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 4) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Solucionada", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 5) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Status Actualizado", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 6) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Restaurada", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 7) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Status Actualizado", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 8) {
                cerrarmodal('modalRangoFechaX');
                alertaImg("Fecha Actualizada", "", "success", 1500);
            } else if (data == 9) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Bitácora Actualizada", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 10) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Status EP Actualizado", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else {
                alertaImg("Intente de Nuevo", "", "info", 1200);
            }

            obtenerPlanaccion(idProyecto);
            obtenerPlanaccionDEP(idProyecto);
        },
    });
}


// STATUS PLANACCIÓN
function statusPlanaccion(idPlanaccion) {

    document.getElementById("modalStatus").classList.add("open");

    // Agregan Funciones en los Botones del modalStatus para poder Aplicar un Status
    document.getElementById("btnEditarTitulo").setAttribute("onclick", 'actualizarPlanaccion(0,"actividad",' + idPlanaccion + ")");

    document.getElementById("statusActivo").setAttribute("onclick", 'actualizarPlanaccion(0,"activo",' + idPlanaccion + ")");

    document.getElementById("statusFinalizar").setAttribute("onclick", 'actualizarPlanaccion("F","status",' + idPlanaccion + ")");

    document.getElementById("btnStatusMaterial").setAttribute("onclick", 'actualizarPlanaccion(1, "status_material",' + idPlanaccion + ")");

    document.getElementById("statusTrabajare").setAttribute("onclick", 'actualizarPlanaccion(1, "status_trabajando",' + idPlanaccion + ")");

    document.getElementById("statusElectricidad").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_electricidad",' + idPlanaccion + ")");

    document.getElementById("statusAgua").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_agua",' + idPlanaccion + ")");

    document.getElementById("statusDiesel").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_diesel",' + idPlanaccion + ")");

    document.getElementById("statusGas").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_gas",' + idPlanaccion + ")");

    document.getElementById("statusRRHH").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_rrhh",' + idPlanaccion + ")");

    document.getElementById("statusCalidad").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_calidad",' + idPlanaccion + ")");

    document.getElementById("statusDireccion").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_direccion",' + idPlanaccion + ")");

    document.getElementById("statusFinanzas").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_finanzas",' + idPlanaccion + ")");

    document.getElementById("statusCompras").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_compras",' + idPlanaccion + ")");

    document.getElementById("statusGP").setAttribute("onclick", 'actualizarPlanaccion(1, "bitacora_gp",' + idPlanaccion + ")");

    document.getElementById("statusTRS").setAttribute("onclick", 'actualizarPlanaccion(1, "bitacora_trs",' + idPlanaccion + ")");

    document.getElementById("statusZI").setAttribute("onclick", 'actualizarPlanaccion(1, "bitacora_zi",' + idPlanaccion + ")");

    document.getElementById("statusEP").setAttribute("onclick", 'actualizarPlanaccion(1, "status_ep",' + idPlanaccion + ")");

    document.getElementById("btnMover").setAttribute("onclick", `moverA(${idPlanaccion}, 'PROYECTO')`);

    nivelVista(2, 'modalEditarTitulo');
    estiloModalStatus(idPlanaccion, 'PLANACCION');
}


// Comentarios para Planaccion
function comentariosPlanaccion(idPlanaccion) {
    document.getElementById("modalComentarios").classList.add("open");

    document.getElementById("btnComentario")
        .setAttribute("onclick", "agregarComentarioPlanaccion(" + idPlanaccion + ")");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");

    const action = "comentariosPlanaccion";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idPlanaccion: idPlanaccion,
        },
        // dataType: "JSON",
        success: function (data) {
            document.getElementById("dataComentarios").innerHTML = data;
        },
    });
}



// AGREGAR COMENTARIO PLAN DE ACCIÓN
function agregarComentarioPlanaccion(idPlanaccion) {
    let comentario = document.getElementById("inputComentario").value;
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idProyecto = localStorage.getItem('idProyecto');
    const action = "agregarComentarioPlanaccion";
    if (comentario.length > 0) {
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idPlanaccion: idPlanaccion,
                comentario: comentario,
            },
            // dataType: "JSON",
            success: function (data) {
                if (data == 1) {
                    comentariosPlanaccion(idPlanaccion);
                    obtenerPlanaccion(idProyecto);
                    document.getElementById("inputComentario").value = "";
                    alertaImg("Comentario Agregado", "", "success", 2500);
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 2500);
                }
            },
        });
    } else {
        alertaImg("Comentario NO Valido", "", "info", 2500);
    }
}


// AGREGA PLANESACCIÓN A PROYECTOS
function agregarPlanaccion() {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let actividad = document.getElementById("agregarPlanaccion");
    let idSeccion = localStorage.getItem('idSeccion');
    let idProyecto = localStorage.getItem('idProyecto');
    if (actividad.value.length >= 1) {
        const action = "agregarPlanaccion";
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idProyecto: idProyecto,
                actividad: actividad.value
            },
            dataType: "JSON",
            success: function (data) {
                if (data == 1) {
                    document.getElementById("agregarPlanaccion").value = '';
                    obtenerProyectos(idSeccion, 'PENDIENTE');
                    obtenerPlanaccion(idProyecto);
                    alertaImg("Actividad Agregada", "", "success", 2500);
                    actividad.value = '';
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
            },
        });
    } else {
        alertaImg("Intente de Nuevo", "", "info", 3000);
    }
}


function statusPlanaccionx(status) {
    if (document.getElementsByClassName('planaccion_' + status).length > 0) {

        document.getElementById('planaccionPendientes').
            classList.remove('bg-purple-600', 'bg-purple-200');
        document.getElementById('planaccionSolucionados').
            classList.remove('bg-purple-600', 'bg-purple-200');

        if (status == "SOLUCIONADO") {
            for (let x = 0; x < document.getElementsByClassName('planaccion_SOLUCIONADO').length; x++) {
                document.getElementsByClassName('planaccion_SOLUCIONADO')[x].
                    classList.remove('hidden');
            }

            for (let x = 0; x < document.getElementsByClassName('planaccion_PENDIENTE').length; x++) {
                document.getElementsByClassName('planaccion_PENDIENTE')[x].
                    classList.add('hidden');
            }

            document.getElementById('planaccionPendientes').classList.add('bg-purple-200');
            document.getElementById('planaccionSolucionados').classList.add('bg-purple-600');

        } else {
            for (let x = 0; x < document.getElementsByClassName('planaccion_PENDIENTE').length; x++) {
                document.getElementsByClassName('planaccion_PENDIENTE')[x].
                    classList.remove('hidden');
            }

            for (let x = 0; x < document.getElementsByClassName('planaccion_SOLUCIONADO').length; x++) {
                document.getElementsByClassName('planaccion_SOLUCIONADO')[x].
                    classList.add('hidden');
            }
            document.getElementById('planaccionSolucionados').classList.add('bg-purple-200');
            document.getElementById('planaccionPendientes').classList.add('bg-purple-600');
        }
    } else {
        alertaImg('Sin: ' + status + 'S', '', 'info', 1000);
    }
}


// OBTIENE LAS ACTIVIDAD RELACIONADAS PARA EL PLAN DE ACCIÓN
function obtenerActividadesPlanaccion(idPlanaccion) {
    localStorage.setItem('idPlanaccion', idPlanaccion);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    const action = "obtenerActividadesPlanaccion";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idPlanaccion=${idPlanaccion}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            document.getElementById("dataActividades").innerHTML = '';
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

                    document.getElementById("dataActividades").innerHTML += `
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
                }
            }
        }).then(() => {
            document.getElementById("loadProyectos").innerHTML = '';
        })
        .catch(function () {
            document.getElementById("loadProyectos").innerHTML = '';
            document.getElementById("dataActividades").innerHTML = '';
            alertaImg('Sin Actividades', '', 'info', 1200);
        })
}


// AGREGA ACTIVIDAD PARA EL PLAN DE ACCIÓN
function agregarActividadPlanaccion() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idPlanaccion = localStorage.getItem('idPlanaccion');
    let actividad = document.getElementById("agregarActividadPlanaccion").value;
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
                    document.getElementById("agregarActividadPlanaccion").value = '';
                    obtenerPlanaccion(idProyecto);
                    obtenerActividadesPlanaccion(idPlanaccion);
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1200);
                }
            })
    } else {
        alertaImg('Intente de Nuevo', '', 'info', 1200);
    }
}


//Función para Generar Grafica GANTT de PROYECTOS PENDIENTES 
function ganttP() {
    // Cambia diseño de Botones en Proyectos

    // Oculta y Muestra contenido
    document.getElementById("palabraProyecto")
        .setAttribute("onkeyup", "ganttP()");
    estiloBotonesProyectos('PENDIENTE', 'GANTT');
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    // Data URL
    const action = "ganttProyectosP";
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let idSubseccion = 200;
    let palabraProyecto = document.getElementById("palabraProyecto").value;
    let dataURL =
        "php/graficas_am4charts.php?action=" +
        action +
        "&idUsuario=" +
        idUsuario +
        "&idDestino=" +
        idDestino +
        "&idSeccion=" +
        idSeccion +
        "&idSubseccion=" +
        idSubseccion +
        "&palabraProyecto=" +
        palabraProyecto;

    fetch(dataURL)
        .then((res) => res.json())
        .then((dataGantt) => {
            const arrayTratado = new Promise((resolve, recject) => {
                for (var i = 0; i < dataGantt.length; i++) {
                    var colorSet = new am4core.ColorSet();
                    dataGantt[i]["color"] = colorSet.getIndex(i);
                }
                resolve(dataGantt);
            });

            arrayTratado
                .then((response) => {
                    generarGantt(response);
                    document.getElementById("loadProyectos").innerHTML = '';
                })
                .catch((error) => {
                    document.getElementById("loadProyectos").innerHTML = '';
                });

            let size = 100 + dataGantt.length * 50;
            document
                .getElementById("chartdiv")
                .setAttribute("style", "height:" + size + "px");
        });

    function generarGantt(dataGantt) {
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

        chart.paddingRight = 30;
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

        var colorSet = new am4core.ColorSet();
        colorSet.saturation = 0.4;

        chart.data = dataGantt;
        chart.dateFormatter.dateFormat = "yyyy-MM-dd";
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "category";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.inversed = true;

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 70;
        dateAxis.baseInterval = { count: 1, timeUnit: "day" };
        dateAxis.renderer.tooltipLocation = 0;

        var series1 = chart.series.push(new am4charts.ColumnSeries());
        series1.columns.template.height = am4core.percent(70);
        series1.columns.template.tooltipText =
            "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

        series1.dataFields.openDateX = "start";
        series1.dataFields.dateX = "end";
        series1.dataFields.categoryY = "category";
        series1.columns.template.propertyFields.fill = "color"; // get color from data
        series1.columns.template.propertyFields.stroke = "color";
        series1.columns.template.strokeOpacity = 1;

        chart.scrollbarX = new am4core.Scrollbar();
    }
}


//Función para Generar Grafica GANTT de PROYECTOS SOLUCIONADOS 
function ganttS() {

    // Oculta y Muestra contenido
    document.getElementById("palabraProyecto")
        .setAttribute("onkeyup", "ganttS()");
    estiloBotonesProyectos('SOLUCIONADO', 'GANTT');
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    // Data URL
    const action = "ganttProyectosS";
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let idSubseccion = 200;
    let palabraProyecto = document.getElementById("palabraProyecto").value;
    let dataURL =
        "php/graficas_am4charts.php?action=" +
        action +
        "&idUsuario=" +
        idUsuario +
        "&idDestino=" +
        idDestino +
        "&idSeccion=" +
        idSeccion +
        "&idSubseccion=" +
        idSubseccion +
        "&palabraProyecto=" +
        palabraProyecto;

    fetch(dataURL)
        .then((res) => res.json())
        .then((dataGantt) => {
            const arrayTratado = new Promise((resolve, recject) => {
                for (var i = 0; i < dataGantt.length; i++) {
                    var colorSet = new am4core.ColorSet();
                    dataGantt[i]["color"] = colorSet.getIndex(i);
                }
                resolve(dataGantt);
            });

            arrayTratado
                .then((response) => {
                    generarGantt(response);
                    document.getElementById("loadProyectos").innerHTML = '';
                })
                .catch((error) => {
                    document.getElementById("loadProyectos").innerHTML = '';
                });
            let size = 100 + dataGantt.length * 50;
            document
                .getElementById("chartdiv")
                .setAttribute("style", "height:" + size + "px");
        });

    function generarGantt(dataGantt) {
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

        chart.paddingRight = 30;
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

        var colorSet = new am4core.ColorSet();
        colorSet.saturation = 0.4;

        chart.data = dataGantt;
        chart.dateFormatter.dateFormat = "yyyy-MM-dd";
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "category";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.inversed = true;

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 70;
        dateAxis.baseInterval = { count: 1, timeUnit: "day" };
        dateAxis.renderer.tooltipLocation = 0;

        var series1 = chart.series.push(new am4charts.ColumnSeries());
        series1.columns.template.height = am4core.percent(70);
        series1.columns.template.tooltipText =
            "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

        series1.dataFields.openDateX = "start";
        series1.dataFields.dateX = "end";
        series1.dataFields.categoryY = "category";
        series1.columns.template.propertyFields.fill = "color"; // get color from data
        series1.columns.template.propertyFields.stroke = "color";
        series1.columns.template.strokeOpacity = 1;

        chart.scrollbarX = new am4core.Scrollbar();
    }
}


// REDIRECIONA (OT_proyectos/) PARA GENERAR LA OT CON localStorage.setItem('URL', idPlanaccion)
function generarOTPlanaccion(idPlanaccion) {
    alertaImg('Generando... OT #' + idPlanaccion, '', 'success', 1200);
    localStorage.setItem('URL', idPlanaccion);
    let URL = 'https://www.maphg.com/beta/OT_proyectos/';
    window.open(URL, "OT PROYECTO #" + idPlanaccion, "width=1300px, height=900px");
}


function actualizarActividadPlanaccion(idActividad, parametro, columna) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let idProyecto = localStorage.getItem('idProyecto');
    let idPlanaccion = localStorage.getItem('idPlanaccion');

    if (columna == "ACTIVIDAD") {
        parametro = document.getElementById("inputTitulo").value;
    }

    const action = "actualizarActividadPlanaccion";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idActividad=${idActividad}&parametro=${parametro}&columna=${columna}`;
    fetch(URL)
        .then(resp => resp.json())
        .then(resp => {
            if (resp.resp == "ELIMINADO") {
                alertaImg('Actividad Eliminada', '', 'success', 1200);
                document.getElementById('tooltipEditarEliminarSolucionar').classList.add('hidden');
                obtenerPlanaccion(idProyecto);
                obtenerActividadesPlanaccion(idPlanaccion);
            } else if (resp.resp == "TITULO") {
                alertaImg('Actividad Actualizada', '', 'success', 1200);
                document.getElementById('segmentoTitulo').classList.add('hidden');
                document.getElementById('tooltipEditarEliminarSolucionar').classList.add('hidden');
                obtenerActividadesPlanaccion(idPlanaccion);
            } else if (resp.resp == "PENDIENTE" || resp.resp == "SOLUCIONADO") {
                alertaImg('Status Acualizado', '', 'success', 1200);
                document.getElementById('tooltipEditarEliminarSolucionar').classList.add('hidden');
                document.getElementById('tooltipEditarEliminarSolucionar').classList.add('hidden');
                obtenerActividadesPlanaccion(idPlanaccion);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
        })
        .catch(function () {
            obtenerPlanaccion(idProyecto);
        });
}


// Muestra los adjuntos de Planaccion
function adjuntosPlanaccion(idPlanaccion) {
    document.getElementById("modalMedia").classList.add("open");
    document.getElementById("contenedorImagenes").classList.add('hidden');
    document.getElementById("contenedorDocumentos").classList.add('hidden');

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idTabla = idPlanaccion;
    let tabla = "t_proyectos_planaccion_adjuntos";

    document.getElementById("inputAdjuntos")
        .setAttribute("onchange", "subirImagenGeneral(" + idPlanaccion + ',"t_proyectos_planaccion_adjuntos")');

    const action = "obtenerAdjuntos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTabla: idTabla,
            tabla: tabla,
        },
        dataType: "JSON",
        success: function (data) {
            if (data.imagen != "") {
                document.getElementById("dataImagenes").innerHTML = data.imagen;
                document.getElementById("contenedorImagenes").classList.remove('hidden');
            }

            if (data.documento != "") {
                document.getElementById("dataAdjuntos").innerHTML = data.documento;
                document.getElementById("contenedorDocumentos").classList.remove('hidden');
            }
        },
    });
}


// ********** FRAGMENTO PARA LOS EVENTOS **********
// EVENTO PARA EXPORTA PROYECTOS EN EXCEL
document.getElementById("exportarProyectos").addEventListener('click', function () {
    tableToExcel('contenedorDeProyectos', 'PROYECTOS');
});

// EVENTO PARA BUSCAR PROYECTOS EN LA TABLA
document.getElementById("palabraProyecto").addEventListener('keyup', function () {
    buscadorTabla('contenedorDeProyectos', 'palabraProyecto', 0);
});

// EVENTO PARA PROYECTOS SOLUCIONADOS
document.getElementById("btnCerrerModalProyectos").addEventListener('click', function () {
    document.getElementById("tooltipProyectos").classList.add('hidden');
    document.getElementById("tooltipActividadesPlanaccion").classList.add('hidden');
});

// EVENTO PARA  AGREGAR PROYECTO
document.getElementById("agregarProyecto").addEventListener('click', datosAgregarProyecto);

// EVENTO PARA  MOSTRAR PLANACCIÓN PENDIENTES
document.getElementById("planaccionPendientes").addEventListener('click', () => {
    statusPlanaccionx('PENDIENTE');
});

// EVENTO PARA  MOSTRAR PLANACCIÓN SOLUCIONADOS
document.getElementById("planaccionSolucionados").addEventListener('click', () => {
    statusPlanaccionx('SOLUCIONADO');
});

// EVENTO PARA  AGREGAR PLANACCIÓN
document.getElementById("agregarPlanaccion").addEventListener('keyup', event => {
    if (event.keyCode === 13) {
        agregarPlanaccion();
    }
});

// EVENTO PARA  AGREGAR PLANACCIÓN
document.getElementById("btnagregarPlanaccion").addEventListener('click', agregarPlanaccion);

// EVENTO PARA  AGREGAR ACTIVIDAD EN PLANACCIÓN
document.getElementById("agregarActividadPlanaccion").addEventListener('keyup', event => {
    if (event.keyCode === 13) {
        agregarActividadPlanaccion();
    }
});

// EVENTO PARA  AGREGAR ACTIVIDAD EN PLANACCIÓN
document.getElementById("btnAgregarActividadPlanaccion").addEventListener('click', agregarActividadPlanaccion);

// EVENTO PARA  MOSTRAR GANTT 
document.getElementById("opcionGanttProyectos").addEventListener('click', () => {
    document.getElementById("contenidoProyectos").classList.add("hidden");
    document.getElementById("contenidoGantt").classList.remove("hidden");
    estiloBotonesProyectos('PENDIENTE', 'PROYECTO');
    ganttP();

    document.getElementById("proyectosPendientes").setAttribute('onclick', 'ganttP()');
    document.getElementById("proyectosSolucionados").setAttribute('onclick', 'ganttS()');
});


// OCULTA SUBVENTANAS DE LOS PROYECTOS
document.getElementById("contenidoOpcionesProyectos").addEventListener('click', function () {
    hiddenVista("tooltipActividadesPlanaccion");
    hiddenVista("tooltipProyectos");
    hiddenVista("tooltipEditarEliminarSolucionar");
});

// EVENTO PARA  MOSTRAR PROYECTOS 
document.getElementById("opcionProyectos").addEventListener('click', () => {
    let idSeccion = localStorage.getItem('idSeccion');
    document.getElementById("contenidoProyectos").classList.remove("hidden");
    document.getElementById("contenidoGantt").classList.add("hidden");
    estiloBotonesProyectos('PENDIENTE', 'GANTT');
    obtenerProyectos(idSeccion, 'PENDIENTE');

    document.getElementById("proyectosPendientes").setAttribute('onclick', `obtenerProyectos(${idSeccion}, "PENDIENTE");`);

    document.getElementById("proyectosSolucionados").setAttribute('onclick', `obtenerProyectos(${idSeccion}, "SOLUCIONADO");`);

});

// ********** FRAGMENTO PARA LOS EVENTOS **********