'use strict'
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

const datosProyectos = params => {

    var idProyecto = params.id;

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

    var fResponsable = '';
    var fJustificacionAdjunto = '';
    var fStatus = '';
    var fRangoFecha = '';
    var fCotizaciones = '';
    var fTipo = '';
    var fJustificacion = '';
    var fCoste = '';
    var fToolTip = '';
    var iconoStatus = '';

    if (params.status == "PENDIENTE" || params.status == "N") {
        fResponsable = `onclick="obtenerResponsablesProyectos(${idProyecto})"`;
        fStatus = `onclick="statusProyecto(${idProyecto});"`;
        fRangoFecha = `onclick="obtenerDatoProyectos(${idProyecto},'rango_fecha');"`;
        fCotizaciones = `onclick="cotizacionesProyectos(${idProyecto});"`;
        fTipo = `onclick="obtenerDatoProyectos(${idProyecto}, 'tipo');"`;
        fJustificacion = `onclick="obtenerDatoProyectos(${idProyecto},'justificacion');"`;
        fCoste = `onclick="obtenerDatoProyectos(${idProyecto},'coste');"`;
        fToolTip = `onclick="tooltipProyectos(${idProyecto}); obtenerPlanaccion(${idProyecto});"`;
        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
    } else {
        iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        fStatus = `onclick="actualizarProyectos('N', 'status', ${idProyecto});"`;
    }

    return `
        <tr id="${idProyecto + 'proyecto'}" class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-800 fila-proyectos-select">

            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3 font-bold ">
                ${params.destino}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 font-semibold">
                ${params.año}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3 uppercase font-semibold">
                ${params.seccion}
            </td>

            <td class="px-4 border-b border-gray-200 py-3" style="max-width: 360px;">
                <div class="font-semibold uppercase leading-4" data-title="${params.proyecto}">
                    <h1 class="truncate">${params.proyecto}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    Creado por: ${params.creadoPor}
                </div>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3"
            ${fToolTip}>
                ${params.pda}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable}>
                ${params.responsable}
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3"
            ${fRangoFecha}>
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3"
            ${fCotizaciones}>
                ${valorCotizaciones}
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3"
            ${fTipo}>
                ${valorTipo}
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center text-lg py-3"
            ${fJustificacion}>
                ${valorjustificacion}
            </td>

            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3"
            ${fCoste}>
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

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                <div class="px-2">
                    ${iconoStatus}
                </div>
            </td>
            
        </tr>
    `;
};


const datosPlanes = params => {
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
    var ocultarActividades = '';

    if (params.status == "PENDIENTE") {
        statusPlanaccion = 'planaccion_PENDIENTE';
        fResponsable = `onclick="obtenerResponsablesPlanaccion(${idPlanaccion});"`;
        fComentarios = `onclick="comentariosPlanaccion(${idPlanaccion});"`;
        fAdjuntos = `onclick="adjuntosPlanaccion(${idPlanaccion});"`;
        fStatus = `onclick="statusPlanaccion(${idPlanaccion});"`;
        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
        fRangoFecha = `onclick="actualizarFechaPlanaccion(${idPlanaccion}, '${params.fechaInicio + ' - ' + params.fechaFin}');"`;
    } else {
        fStatus = `onclick="actualizarPlanaccion('N','status', ${idPlanaccion});"`;
        iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        statusPlanaccion = 'planaccion_SOLUCIONADO hidden';
    }

    return `
    <tr id="${idPlanaccion}planaccion" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-planaccion-select ${statusPlanaccion}" ${ocultarActividades}>
            <td class="px-4 border-b border-gray-200 py-3" style="max-width: 360px;" 
            ${fToolTip}>
                <div class="font-semibold uppercase leading-4" data-title="${params.actividad}">
                    <h1 id="AP${idPlanaccion}" class="truncate">${params.actividad}</h1>
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
            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3"
            ${fRangoFecha}>
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
};


function obtenerProyectosGlobal(statusProyectos) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerProyectosGlobal";
    const URL = `php/proyectos_planacciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&status=${statusProyectos}`;

    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-m"></i>';

    document.getElementById("btnProyectos").
        setAttribute('onclick', "obtenerProyectosGlobal('PENDIENTE');");

    document.getElementById("btnGantt").
        setAttribute('onclick', "ganttProyectosGlobal('PENDIENTE');");

    document.getElementById("btnPendientes").
        setAttribute('onclick', "obtenerProyectosGlobal('PENDIENTE');");

    document.getElementById("btnSolucionados").
        setAttribute('onclick', "obtenerProyectosGlobal('SOLUCIONADO');");

    document.getElementById("btnExportar").
        setAttribute('onclick', "reporteProyectos();");

    document.getElementById("dataProyectos").classList.remove("hidden");
    document.getElementById("chartProyectos").classList.add("hidden");

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
            fetch(APIERROR + err + ': (obtenerProyectosGlobal)');
            document.getElementById("loadProyectos").innerHTML = '';
            document.getElementById("contenedorDeProyectos").innerHTML = '';

        })
}


//Función para Generar Grafica GANTT de PROYECTOS PENDIENTES 
function ganttProyectosGlobal(statusProyectos) {
    // Cambia diseño de Botones en Proyectos

    // Oculta y Muestra contenido
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-m"></i>';

    document.getElementById("btnPendientes").
        setAttribute('onclick', "ganttProyectosGlobal('PENDIENTE');");

    document.getElementById("btnSolucionados").
        setAttribute('onclick', "ganttProyectosGlobal('SOLUCIONADO');");

    document.getElementById("chartProyectos").classList.remove("hidden");
    document.getElementById("dataProyectos").classList.add("hidden");

    // Data URL
    const action = "ganttProyectosGlobal";
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let palabraProyecto = document.getElementById("palabraProyecto").value;
    let dataURL = "php/graficas_am4charts.php?action=" + action + "&idUsuario=" + idUsuario + "&idDestino=" + idDestino + "&statusProyectos=" + statusProyectos + "&palabraProyecto=" + palabraProyecto;
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
                .getElementById("chartProyectos")
                .setAttribute("style", "height:" + size + "px");
        })
        .then(function () {
            document.getElementById("loadProyectos").innerHTML = '';
        })

    function generarGantt(dataGantt) {
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartProyectos", am4charts.XYChart);
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


// EVENTOS
document.getElementById("destinosSelecciona").addEventListener('click', () => {
    obtenerProyectosGlobal('PENDIENTE');
});


// FUNCIONES
//Optienes Usuarios posible para asignar responsable en Proyectos.
function obtenerResponsablesProyectos(idProyecto) {
    document.getElementById("palabraUsuario").setAttribute("onkeyup", "obtenerResponsablesProyectos(" + idProyecto + ")");
    document.getElementById("modalUsuarios").classList.add("open");
    let idItem = idProyecto;
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let tipoAsginacion = "asignarProyecto";
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


// ACTUALIZA DATOS DEL PROYECTO (T_PROYECTOS)
function actualizarProyectos(valor, columna, idProyecto) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let tipo = document.getElementById("tipoProyecto").value;
    let justificacion = document.getElementById("justificacionProyecto").value;
    let coste = document.getElementById("costeProyecto").value;
    let titulo = document.getElementById("inputEditarTituloX").value;
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
                obtenerProyectosGlobal("PENDIENTE");
                alertaImg("Responsable Actualizado", "", "success", 2000);
                document.getElementById("modalUsuarios").classList.remove("open");
            } else if (data == 2) {
                obtenerProyectosGlobal("PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Justifiación Actualizado", "", "success", 2000);
            } else if (data == 3) {
                obtenerProyectosGlobal("PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Coste Actualizado", "", "success", 2000);
            } else if (data == 4) {
                obtenerProyectosGlobal("PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Tipo Actualizado", "", "success", 2000);
            } else if (data == 5) {
                obtenerProyectosGlobal("PENDIENTE");
                document.getElementById("modalFechaProyectos").classList.remove("open");
                alertaImg("Fecha Actualizada", "", "success", 2000);
            } else if (data == 6) {
                obtenerProyectosGlobal("PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Proyecto Eliminado", "", "success", 2000);
            } else if (data == 7) {
                obtenerProyectosGlobal("PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Título Actualizado", "", "success", 2000);
            } else if (data == 8) {
                obtenerProyectosGlobal("PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Proyecto Finalizado", "", "success", 2000);
            } else if (data == 9) {
                obtenerProyectosGlobal("PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Proyecto Restaurado", "", "success", 2000);
            } else if (data == 10) {
                alertaImg("Solucione todas las actividades", "", "warning", 4000);
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


// Función para Input Fechas PROYECTOS
$(function () {
    $('input[name="rangoFechaX"]').daterangepicker({
        autoUpdateInput: false,
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

    $('input[name="rangoFechaX"]').on("apply.daterangepicker", function (ev, picker) {
        $(this).val(picker.startDate.format("DD/MM/YYYY") + " - " + picker.endDate.format("DD/MM/YYYY")
        );
    });
})


// Función para Input Fechas PROYECTOS
$(function () {
    $('input[name="fechaProyecto"]').daterangepicker({
        autoUpdateInput: false,
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
})



// Obtienes las Cotizaciones de PROYECTOS
function cotizacionesProyectos(idProyecto) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idTabla = idProyecto;
    let tabla = "t_proyectos_adjuntos";

    document.getElementById("contenedorImagenes").classList.add('hidden');
    document.getElementById("contenedorDocumentos").classList.add('hidden');

    document.getElementById("modalMedia").classList.add("open");
    document.getElementById("inputAdjuntos")
        .setAttribute("onchange", "subirImagenGeneral(" + idProyecto + ', "t_proyectos_adjuntos")');

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


// Sube imagenes con dos parametros, con el formulario #inputAdjuntos
function subirImagenGeneral(idTabla, tabla) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let img = document.getElementById("inputAdjuntos").files;
    let idProyecto = localStorage.getItem('idProyecto');

    for (let index = 0; index < img.length; index++) {
        let imgData = new FormData();
        const action = "subirImagenGeneral";
        document.getElementById("cargandoAdjunto").innerHTML =
            '<i class="fa fa-spinner fa-pulse fa-m"></i>';

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
                document.getElementById("cargandoAdjunto").innerHTML = "";
                document.getElementById("inputAdjuntos").value = "";
                if (data == -1) {
                    alertaImg("Archivo NO Permitido", "", "warning", 2500);
                } else if (data == 1) {
                    alertaImg("Proceso Cancelado", "", "info", 3000);
                } else if (data == 2) {
                    alertaImg("Archivo Pesado (MAX:99MB)", "", "info", 3000);
                } else if (data == 3) {
                    // Sube y Actualiza la Vista para las Cotizaciones de Proyectos
                    alertaImg("Cotización Agregada", "", "success", 2500);
                    obtenerProyectosGlobal('PENDIENTE');
                    cotizacionesProyectos(idTabla);
                } else if (data == 4) {
                    // Sube y Actualiza la Vista para los Adjuntos de Planaccion
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                    obtenerPlanaccion(idProyecto);
                    adjuntosPlanaccion(idTabla);
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
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


//SUBÉ JUSTIFICACIÓN DE PROYECTOS
function subirJustificacionProyectos(idTabla, tabla) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let img = document.getElementById("inputAdjuntosJP").files;

    for (let index = 0; index < img.length; index++) {
        let imgData = new FormData();
        const action = "subirImagenGeneral";
        document.getElementById("cargandoAdjuntoJP").innerHTML =
            '<i class="fa fa-spinner fa-pulse fa-m"></i>';

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


// OBTENER STATUS PLANACCIÓN
function statusProyecto(idProyecto) {
    document.getElementById("modalTituloEliminar").classList.add("open");
    document.getElementById("editarTituloXtoggle").classList.add("hidden");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    const action = "obtenerStatus";
    const URL = `php/select_REST_planner.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idRegistro=${idProyecto}&tipoRegistro=PROYECTO`;
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array[0]) {
                document.getElementById("inputEditarTituloX").value = array[0].titulo;
            }
        })
        .then(function () {
            document.getElementById("btnEditarTituloX")
                .setAttribute("onclick", 'actualizarProyectos(0, "titulo",' + idProyecto + ")");

            document.getElementById("eliminar").
                setAttribute("onclick", 'actualizarProyectos(0, "eliminar",' + idProyecto + ")");

            document.getElementById("finalizar").
                setAttribute("onclick", 'actualizarProyectos("F", "status",' + idProyecto + ")");
        })
        .catch(function (err) {
            fetch(APIERROR + err + ': (statusProyecto)');
        })
}


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


// OBTIEN LOS PLANES DE ACCIÓN POR PORYECTO
function obtenerPlanaccion(idProyecto) {
    localStorage.setItem('idProyecto', idProyecto);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = 'obtenerPlanaccion';
    const ruta = 'php/proyectos_planacciones.php?';
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idProyecto=${idProyecto}`;

    document.getElementById("btnagregarPlanaccion").
        setAttribute('onclick', 'agregarPlanaccion()');

    document.getElementById("planaccionPendientes").
        setAttribute('onclick', "statusPlanaccionx('PENDIENTE');");

    document.getElementById("planaccionSolucionados").
        setAttribute('onclick', "statusPlanaccionx('SOLUCIONADO');");

    if (!document.getElementById('tooltipProyectos').classList.contains('hidden')) {
        document.getElementById("loadProyectos").innerHTML =
            '<i class="fa fa-spinner fa-pulse fa-m"></i>';

        fetch(URL)
            .then(array => array.json())
            .then(array => {
                document.getElementById("contenedorDePlanesdeaccion").innerHTML = '';

                if (array.length > 0) {
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

                        const dataPlanaccion = datosPlanes({
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

                        document.getElementById("contenedorDePlanesdeaccion")
                            .insertAdjacentHTML('beforeend', dataPlanaccion);
                    }
                } else {
                    alertaImg('Sin Plan de Acción', '', 'info', 1500);
                }

            })
            .then(() => {
                document.getElementById("loadProyectos").innerHTML = '';
            })
            .catch(function () {
                document.getElementById("loadProyectos").innerHTML = '';
                document.getElementById('contenedorDePlanesdeaccion').innerHTML = '';
            });
    } else {
        document.getElementById("contenedorDePlanesdeaccion").innerHTML = '';
    }
}


// STATUS PLANACCIÓN
function statusPlanaccion(idPlanaccion) {
    document.getElementById("modalStatus").classList.add("open");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion")

    estiloModalStatus(idPlanaccion, 'PLANACCION');

    // Agregan Funciones en los Botones del modalStatus para poder Aplicar un Status
    document.getElementById("btnConfirmEditarTitulo").setAttribute("onclick", 'actualizarPlanaccion(0,"actividad",' + idPlanaccion + ")");

    document.getElementById("statusActivo").setAttribute("onclick", 'actualizarPlanaccion(0,"activo",' + idPlanaccion + ")");

    document.getElementById("statusFinalizar").setAttribute("onclick", 'actualizarPlanaccion("F","status",' + idPlanaccion + ")");

    document.getElementById("btnConfirmEditarTitulo").setAttribute("onclick", 'actualizarPlanaccion(1, "status_material",' + idPlanaccion + ")");

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
}


function estiloModalStatus(idRegistro, tipoRegistro) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerStatus";
    const URL = `php/select_REST_planner.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idRegistro=${idRegistro}&tipoRegistro=${tipoRegistro}`;

    if (document.getElementById("statusenergeticostoggle")) {
        document.getElementById("statusenergeticostoggle").classList.add('hidden');
    }
    if (document.getElementById("statusdeptoggle")) {
        document.getElementById("statusdeptoggle").classList.add('hidden');
    }
    if (document.getElementById("editarTitulotoggle")) {
        document.getElementById("editarTitulotoggle").classList.add('hidden');
    }

    let sMaterialX = document.getElementById("statusMaterial");
    let sTrabajareX = document.getElementById("statusTrabajare");
    let sCalidadX = document.getElementById("statusCalidad");
    let sComprasX = document.getElementById("statusCompras");
    let sDireccionX = document.getElementById("statusDireccion");
    let sFinanzasX = document.getElementById("statusFinanzas");
    let sRRHHX = document.getElementById("statusRRHH");
    let sElectricidadX = document.getElementById("statusElectricidad");
    let sAguaX = document.getElementById("statusAgua");
    let sDieselX = document.getElementById("statusDiesel");
    let sGasX = document.getElementById("statusGas");
    let sEnergeticosX = document.getElementById("statusenergeticos");
    let sDepartamentosX = document.getElementById("statusdep");

    sMaterialX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs";

    sTrabajareX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-blue-500 bg-gray-200 hover:bg-blue-200 text-xs";

    sCalidadX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

    sComprasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

    sDireccionX.className = "w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

    sFinanzasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

    sRRHHX.className = "w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

    sElectricidadX.className = "w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

    sAguaX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

    sDieselX.className = "w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

    sGasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

    sEnergeticosX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

    sDepartamentosX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array[0]) {

                if (array[0].sMaterial == 1) {
                    sMaterialX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-orange-500 bg-gray-200 bg-orange-200 text-xs";
                }

                if (array[0].sTrabajare == 1) {
                    sTrabajareX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-blue-500 bg-gray-200 bg-blue-200 text-xs";
                }

                if (array[0].sCalidad == 1) {
                    sCalidadX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
                }

                if (array[0].sCompras == 1) {
                    sComprasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
                }

                if (array[0].sDireccion == 1) {
                    sDireccionX.className = "w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
                }

                if (array[0].sFinanzas == 1) {
                    sFinanzasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
                }

                if (array[0].sRRHH == 1) {
                    sRRHHX.className = "w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
                }

                if (array[0].sElectricidad == 1) {
                    sElectricidadX.className = "w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
                }

                if (array[0].sAgua == 1) {
                    sAguaX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
                }

                if (array[0].sDiesel == 1) {
                    sDieselX.className = "w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
                }

                if (array[0].sGas == 1) {
                    sGasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
                }

                if (array[0].sEnergeticos > 0) {
                    sEnergeticosX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
                }

                if (array[0].sDepartamentos > 0) {
                    sDepartamentosX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
                }

                if (array[0].titulo) {
                    document.getElementById("editarTitulo").value = array[0].titulo;
                }

            }

        })
        .catch(function (err) {
            fetch(APIERROR + err + ': (estiloModalStatus)');
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
            obtenerPlanaccion(idProyecto);
            if (data == 1) {
                document.getElementById("modalUsuarios").classList.remove("open");
                alertaImg("Responsable Actualizado", "", "success", 2500);
            } else if (data == 2) {
                alertaImg("Actividad Actualizada", "", "success", 2500);
                expandir('btnEditarTitulo');
                document.getElementById("modalStatus").classList.remove("open");
            } else if (data == 3) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Eliminada", "", "success", 2500);
                obtenerProyectosGlobal('PENDIENTE');
            } else if (data == 4) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Solucionada", "", "success", 2500);
                obtenerProyectosGlobal('PENDIENTE');
            } else if (data == 5) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Status Actualizado", "", "success", 2500);
                obtenerProyectosGlobal('PENDIENTE');
            } else if (data == 6) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Restaurada", "", "success", 2500);
                obtenerProyectosGlobal('PENDIENTE');
            } else if (data == 7) {
                alertaImg("Status Material, Actualizado", "", "success", 2500);
                document.getElementById("modalStatus").classList.remove("open");
            } else if (data == 8) {
                alertaImg("Rango de Fecha, Actualizado", "", "success", 2500);
                toggleModalX("modalRangoFecha");
            } else {
                alertaImg("Intente de Nuevo", "", "info", 2500);
            }
        },
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


// OBTIENE LAS ACTIVIDAD RELACIONADAS PARA EL PLAN DE ACCIÓN
function obtenerActividadesPlanaccion(idPlanaccion) {
    localStorage.setItem('idPlanaccion', idPlanaccion);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-m"></i>';
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


// OBTIENE RESPONSABLE PARA PLAN DE ACCIÓN
function obtenerResponsablesPlanaccion(idPlanaccion) {
    document.getElementById("palabraUsuario")
        .setAttribute("onkeyup", "obtenerResponsablesPlanaccion(" + idPlanaccion + ")");
    document.getElementById("modalUsuarios").classList.add("open");
    let idItem = idPlanaccion;
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let tipoAsginacion = "asignarPlanaccion";
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
            document.getElementById("dataAdjuntos").innerHTML = '';
            document.getElementById("dataImagenes").innerHTML = '';
            if (data.imagen != "") {
                document.getElementById("contenedorImagenes").classList.remove('hidden');
                document.getElementById("dataImagenes").innerHTML = data.imagen;
            }

            if (data.documento != "") {
                document.getElementById("contenedorDocumentos").classList.remove('hidden');
                document.getElementById("dataAdjuntos").innerHTML = data.documento;
            }
        },
    });
}


// CREA REPORTE GENERAL DE PROYECTOS
function reporteProyectos() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem("idSubseccion");

    const action = "reporteProyectosGlobal";
    const URL = `php/exportar_excel_GET.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;
    window.location = URL;
    setTimeout(() => {
        alertaImg('Generando Reporte...', '', 'success', 1200);
    }, 820);
}


// TOOLTIP PARA MOSTRAR LOS PLANESACCIÓN DE LOS PROYECTOS
function tooltipEditarEliminarSolucionar(idActividad) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    localStorage.setItem('idActividad', idActividad);

    document.getElementById("tooltipEditarEliminarSolucionar").classList.add('open');
    document.getElementById("btnActualizarTitulotoggle").classList.add('hidden');

    document.getElementById("btnFinalizar").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, 'SOLUCIONADO', 'STATUS')`);

    document.getElementById("btnConfirmEditarTituloActividad").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, 'ACTIVIDAD', 'ACTIVIDAD')`);

    document.getElementById("btnEliminar").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, '0', 'ACTIVO')`);

    const action = "obtenerStatus";
    const URL = `php/select_REST_planner.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idRegistro=${idActividad}&tipoRegistro=ACTIVIDADPLANACCION`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById("editarTituloActividad").value = array[0].titulo;
        })
        .catch(function (err) {
            fetch(APIERROR + err + ': (tooltipEditarEliminarSolucionar)');
        })
}


// ACUTALIZA INFORMACIÓN DE LAS ACTIVIDADES DE PLANACCION
function actualizarActividadPlanaccion(idActividad, parametro, columna) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let idProyecto = localStorage.getItem('idProyecto');
    let idPlanaccion = localStorage.getItem('idPlanaccion');

    if (columna == "ACTIVIDAD") {
        parametro = document.getElementById("editarTituloActividad").value;
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
        .then(function () {
            cerrarmodal('tooltipEditarEliminarSolucionar');
        })
        .catch(function () {
            obtenerPlanaccion(idProyecto);
        });
}


// AGREGA PLANESACCIÓN A PROYECTOS
function agregarPlanaccion() {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let actividad = document.getElementById("agregarPlanaccion").value;
    let idProyecto = localStorage.getItem('idProyecto');
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
                    document.getElementById("agregarPlanaccion").value = '';
                    obtenerProyectosGlobal('PENDIENTE');
                    obtenerPlanaccion(idProyecto);
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



function actualizarFechaPlanaccion(idPlanaccion, fecha) {
    toggleModalX("modalRangoFecha");
    document.getElementById("rangoFechaX").value = fecha;
    document.getElementById("rangoFechaX").
        setAttribute('onchange', `actualizarPlanaccion(1, 'rango_fecha', ${idPlanaccion})`);
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



// Expande elementos ocultos con ID, terminacion (toggle, titulo)
function expandir(id) {
    let idtoggle = id + "toggle";
    let idtitulo = id + "titulo";

    if (document.getElementById(idtoggle)) {
        var toggle = document.getElementById(idtoggle);
        toggle.classList.toggle("hidden");

        if (document.getElementById(idtitulo)) {
            document.getElementById(idtitulo).classList.toggle("truncate");
        }
    }
}


// CIERRA EN MODAL CON LA CLASE "OPEN"
function toggleModalX(idModal) {
    if (document.getElementById(idModal)) {
        document.getElementById(idModal).classList.toggle('open');
    }
}


// FUNCION GENERAL PARA OCULTAR ELEMENTOS CON HIDDEN TOGGLE
function toggleHiddenElemento(idElemento) {
    if (document.getElementById(idElemento)) {
        document.getElementById(idElemento).classList.toggle('hidden');
    }
}


// EVENTO PARA BUSCAR EN TABLA #dataProyectos
document.getElementById("palabraProyecto").addEventListener('keyup', function () {
    buscadorTabla('dataProyectos', 'palabraProyecto', 3);
});

obtenerProyectosGlobal('PENDIENTE');