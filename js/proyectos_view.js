'use strict'

// ICONO LOADER MAPHG
const loaderMAPHG40 = '<div class="w-full p-1 flex items-center justify-center"><img src="svg/lineal_animated_loop.svg" width="30px" height="30px"></div>';

// CONTENEDORES DIVS
const loaderCotizacionesProyecto = document.getElementById("loaderCotizacionesProyecto");
const dataCotizacionesImagenes = document.getElementById("dataCotizacionesImagenes");
const dataCotizacionesDocumentos = document.getElementById("dataCotizacionesDocumentos");
const dataCatalogoConcepto = document.getElementById("dataCatalogoConcepto");
// CONTENEDORES DIVS

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
            valorTipo = '<div class="px-2 bg-yellow-300 text-yellow-600 rounded-full uppercase"><h1>FF&E</h1></div>';
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
    var fPresupuesto = '';

    if (params.status == "PENDIENTE" || params.status == "N") {
        fResponsable = ``;

        fStatus = ``;

        fRangoFecha = `onclick="obtenerDatoProyectos(${idProyecto},'rango_fecha');"`;

        fCotizaciones = `onclick="obtenerCotizaciones(${idProyecto}); obtenerCatalogoConceptos(${idProyecto}); abrirmodal('modalMediaProyectos');"`;

        fTipo = ``;

        fJustificacion = `onclick="obtenerDatoProyectos(${idProyecto},'justificacion'); abrirmodal('modalActualizarProyecto')"`;

        fCoste = ``;

        fToolTip = `onclick="tooltipProyectos(${idProyecto}); obtenerPlanaccion(${idProyecto});"`;

        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';

        fPresupuesto = `onclick="obtenerPresupuestoProyecto(${idProyecto}); toggleModalTailwind('modalPresupuestoProyecto')"`;

    } else {
        iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        fStatus = ``;
    }

    const coste = new Intl.NumberFormat('IN').format(params.coste);
    const presupuesto = new Intl.NumberFormat('IN').format(params.presupuesto);
    const statusI = params.sI == 1 ?
        `<p class="text-xs font-semibold text-green-500 bg-green-300 rounded-full p-1 mx-1 w-6">I</p>` : '';
    const statusAP = params.sAP == 1 ?
        `<p class="text-xs font-semibold text-blue-500 bg-blue-300 rounded-full p-1 mx-1 w-6">AP</p>` : '';

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
                <div class="font-semibold uppercase leading-4" data-title-proyecto="${params.proyecto}">
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

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable} data-title-proyecto="${params.responsable}">
                <h1 class="truncate">${params.responsable}</h1>
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

            <td class="whitespace-no-wrap border-b border-gray-200 text-center text-lg py-3"
            ${fStatus}>
                <div class="flex flex-row items-center justify-center">
                    ${statusI}
                    ${statusAP}
                </div>
            </td>
        </tr>
    `;
}


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
        fResponsable = ``;
        fComentarios = ``;
        fAdjuntos = `onclick="adjuntosPlanaccion(${idPlanaccion});"`;
        fStatus = ``;
        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
        fRangoFecha = `onclick="actualizarFechaPlanaccion(${idPlanaccion}, '${params.fechaInicio + ' - ' + params.fechaFin}');"`;
    } else {
        fStatus = ``;
        iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        statusPlanaccion = 'planaccion_SOLUCIONADO hidden';
    }

    return `
    <tr id="${idPlanaccion}planaccion" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-planaccion-select ${statusPlanaccion}" ${ocultarActividades}>
            <td class="px-4 border-b border-gray-200 py-3" style="max-width: 360px;" 
            ${fToolTip}>
                <div class="font-semibold uppercase leading-4" data-title-proyecto="${params.actividad}">
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
}


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
                    const presupuesto = array[x].presupuesto;
                    const status = array[x].status;
                    const materiales = array[x].materiales;
                    const energeticos = array[x].energeticos;
                    const departamento = array[x].departamento;
                    const trabajando = array[x].trabajando;
                    const sI = array[x].sI;
                    const sAP = array[x].sAP;

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
                        presupuesto: presupuesto,
                        status: status,
                        materiales: materiales,
                        energeticos: energeticos,
                        departamento: departamento,
                        trabajando: trabajando,
                        sI: sI,
                        sAP: sAP
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
// document.getElementById("destinosSelecciona").addEventListener('click', () => {
//     obtenerProyectosGlobal('PENDIENTE');
// });







// Obtienes las Cotizaciones de PROYECTOS
const obtenerCotizaciones = idProyecto => {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");

    loaderCotizacionesProyecto.innerHTML = loaderMAPHG40;

    const action = "obtenerCotizaciones";
    const URL = `php/adjuntos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idProyecto=${idProyecto}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataCotizacionesImagenes.innerHTML = '';
            dataCotizacionesDocumentos.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idAdjunto = array[x].idAdjunto;
                    const url = array[x].url;
                    const fecha = array[x].fecha;
                    const extension = array[x].extension;

                    const codigo = extension == 'png' || extension == 'jpeg' || extension == 'jpg' || extension == 'svg' ?
                        `
                        <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative">
                            <a href="planner/proyectos/${url}" target="_blank" data-title="Clic para Abrir">
                                <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer" style="background-image: url('planner/proyectos/${url}')">
                                </div>
                            </a>
                        </div>
                        `
                        : `
                        <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative w-full px-2">
                            <a href="planner/proyectos/${url}" target="_blank">
                                <div class="auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                                    <i class="fad fa-file-alt fa-3x"></i>
                                    <p class="text-sm font-normal ml-2">${url}</p>
                                </div>
                            </a>     
                        </div>  
                    `;

                    extension == 'png' || extension == 'jpeg' || extension == 'jpg' || extension == 'svg' ?
                        dataCotizacionesImagenes.insertAdjacentHTML('beforeend', codigo)
                        :
                        dataCotizacionesDocumentos.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .then(() => {
            loaderCotizacionesProyecto.innerHTML = '';
        })
        .catch(function (err) {
            loaderCotizacionesProyecto.innerHTML = '';
            dataCotizacionesImagenes.innerHTML = '';
            dataCotizacionesDocumentos.innerHTML = '';
            fetch(APIERROR + err);
        })
}



// OBTIENE CATALOGO DE CONCEP DE PROYECTOS
const obtenerCatalogoConceptos = idProyecto => {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");

    loaderCotizacionesProyecto.innerHTML = loaderMAPHG40;

    const action = "obtenerCatalogoConceptos";
    const URL = `php/adjuntos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idProyecto=${idProyecto}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataCatalogoConcepto.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idAdjunto = array[x].idAdjunto;
                    const url = array[x].url;
                    const fecha = array[x].fecha;
                    const extension = array[x].extension;

                    const codigo = extension == 'png' || extension == 'jpeg' || extension == 'jpg' || extension == 'svg' ?
                        `
                        <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative">
                            <a href="planner/proyectos/${url}" target="_blank" data-title="Clic para Abrir">
                                <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer" style="background-image: url('planner/proyectos/${url}')">
                                </div>
                            </a>
                        </div>
                        `
                        : extension == 'xls' || extension == 'xlsx' ?
                            `
                                <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative w-full px-2">
                                    <a href="planner/proyectos/${url}" target="_blank">
                                        <div class="auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                                            <i class="fad fa-file-excel fa-2x text-green-600 hover:text-green-400"></i>
                                            <p class="text-sm font-normal ml-2">${url}</p>
                                        </div>
                                    </a>     
                                </div>
                            `
                            : `
                                <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative w-full px-2">
                                    <a href="planner/proyectos/${url}" target="_blank">
                                        <div class="auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                                            <i class="fad fa-file-alt fa-3x"></i>
                                            <p class="text-sm font-normal ml-2">${url}</p>
                                        </div>
                                    </a>     
                                </div>  
                            `;
                    dataCatalogoConcepto.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .then(() => {
            loaderCotizacionesProyecto.innerHTML = '';
        })
        .catch(function (err) {
            dataCatalogoConcepto.innerHTML = '';
            dataCotizacionesDocumentos.innerHTML = '';
            fetch(APIERROR + err);
        })
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


// FUNCION GENERAL PARA OCULTAR ELEMENTOS CON HIDDEN TOGGLE
function toggleHiddenElemento(idElemento) {
    if (document.getElementById(idElemento)) {
        document.getElementById(idElemento).classList.toggle('hidden');
    }
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

    if (columna == "justificacion") {
        justificacionAdjuntosProyectos(idProyecto);
        document.getElementById("tituloActualizarProyecto").innerHTML = "JUSTIFICACIÓN";
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
            document.getElementById("justificacionProyecto").value = data.justificacion;
        },
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


// EVENTO PARA BUSCAR EN TABLA #dataProyectos
document.getElementById("palabraProyecto").addEventListener('keyup', function () {
    buscadorTabla('dataProyectos', 'palabraProyecto', 3);
})


// toggleClass Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
    if (document.getElementById(idModal)) {
        document.getElementById(idModal).classList.toggle("open");
    }
}


window.addEventListener('load', () => {
    let idDestino = window.location.hash.replace('#', '');
    console.log(idDestino);
    if (idDestino > 0) {
        localStorage.setItem('idDestino', idDestino);
        obtenerProyectosGlobal('PENDIENTE');
    } else {
        alertaImg('URL No Valido', '', 'info', 1500);
        
        setTimeout(() => {
            window.location = 'https://www.google.com';
        }, 1500);
    }
})