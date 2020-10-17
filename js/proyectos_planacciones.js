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
            valorTipo = '- - -';
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

    // Valor Inicial
    var fResponsable = '';
    var fJustificacionAdjunto = '';
    var fStatus = '';
    var fRangoFecha = '';
    var fCotizaciones = '';
    var fTipo = '';
    var fJustificacion = '';
    var fCoste = '';


    if (params.status == "PENDIENTE" || params.status == "N") {
        fResponsable = `onclick="obtenerResponsablesProyectos(${idProyecto})"`;
        fStatus = `onclick="statusProyecto(${idProyecto});"`;
        fRangoFecha = `onclick="obtenerDatoProyectos(${idProyecto},'rango_fecha');"`;
        fCotizaciones = `onclick="cotizacionesProyectos(${idProyecto});"`;
        fTipo = `onclick="obtenerDatoProyectos(${idProyecto}, 'tipo');"`;
        fJustificacion = `onclick="obtenerDatoProyectos(${idProyecto},'justificacion');"`;
        fCoste = `onclick="obtenerDatoProyectos(${idProyecto},'coste');""`;
        fToolTip = `onclick="tooltipProyectos(${idProyecto})"`;
    }


    return `
        <tr id="${params.id}proyecto" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-proyectos-select">

            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;">
                <div class="font-semibold uppercase leading-4" ${fToolTip}>
                    <h1 id="${params.id}tituloProyecto">${params.proyecto}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1 class="mr-2 font-semibold">${params.destino}</h1>
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
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

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fCoste}>
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
    Popper.createPopper(button, tooltip);
}


// OBTIENES LOS PROYECTOS
function obtenerProyectos(idSeccion, status = 'PENDIENTE') {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSubseccion = 200;

    // Actualiza la Sección
    localStorage.setItem("idSeccion", idSeccion);

    // Estilo para Botones Superiores
    estiloBotonesProyectos(status, 'PROYECTOS');

    // Secciones de Botones.
    document.getElementById("seccionProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("btnProyecto")
        .setAttribute("onclick", 'obtenerProyectosP("PROYECTO")');
    document.getElementById("modalProyectos").classList.add("open");
    document.getElementById("btnCrearProyecto")
        .setAttribute("onclick", "agregarProyecto()");
    document.getElementById("btnNuevoProyecto")
        .setAttribute("onclick", "datosAgregarProyecto()");
    document.getElementById("btnSolucionadosProyectos")
        .setAttribute("onclick", 'obtenerProyectosS("PROYECTO")');
    document.getElementById("btnGanttProyecto")
        .setAttribute("onclick", "ganttP()");

    // Oculta y Muestra contenido
    document.getElementById("contenidoProyectos").classList.remove("hidden");
    document.getElementById("contenidoGantt").classList.add("hidden");

    const action = "consultaProyectos";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&status=${status}`;

    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';

    fetch(URL)
        .then(resp => resp.json())
        .then(array => {
            if (array.length > 0) {
                document.getElementById('contenedorDeProyectos').innerHTML = '';
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
                    console.log(status);
                    $tablaProyectos.innerHTML += datosProyectos({
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
                document.getElementById('contenedorDeProyectos').innerHTML = '';
            }
        })
        .then(() => {
            // Quita el Loader hasta que Finalize la carga de Proyectos
            document.getElementById("loadProyectos").innerHTML = '';
        })
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


// ACTUALIZA DATOS DEL PROYECTO (T_PROYECTOS)
function actualizarProyectos(valor, columna, idProyecto) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let tipo = document.getElementById("tipoProyecto").value;
    let justificacion = document.getElementById("justificacionProyecto").value;
    let coste = document.getElementById("costeProyecto").value;
    let titulo = document.getElementById("inputEditarTitulo").value;
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
                obtenerProyectos(idSeccion, "PENDIENTE");
                alertaImg("Responsable Actualizado", "", "success", 2000);
                document.getElementById("modalUsuarios").classList.remove("open");
            } else if (data == 2) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Justifiacion Actualizado", "", "success", 2000);
            } else if (data == 3) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Coste Actualizado", "", "success", 2000);
            } else if (data == 4) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                document.getElementById("modalActualizarProyecto")
                    .classList.remove("open");
                alertaImg("Tipo Actualizado", "", "success", 2000);
            } else if (data == 5) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                document.getElementById("modalFechaProyectos").classList.remove("open");
                alertaImg("Fecha Actualizada", "", "success", 2000);
            } else if (data == 6) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Proyecto Eliminado", "", "success", 2000);
            } else if (data == 7) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                document.getElementById("modalEditarTitulo").classList.remove("open");
                alertaImg("Título Actualizado", "", "success", 2000);
            } else if (data == 8) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                document.getElementById("modalTituloEliminar").classList.remove("open");
                alertaImg("Proyecto Finalizado", "", "success", 2000);
            } else if (data == 9) {
                obtenerProyectos(idSeccion, "PENDIENTE");
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
            // console.log(data);
            document.getElementById("responsableProyectoN").innerHTML = data.dataUsuarios;
        },
    });
}


// Agregar Proyecto
function agregarProyecto() {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let idSubseccion = 200;
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
                // console.log(data);
                if (data == 1) {
                    obtenerProyectosP("PROYECTO");
                    obtenerDatosUsuario(idDestino);
                    alertaImg("Proyecto Agregado", "", "success", 2500);
                    document.getElementById("tituloProyectoN").value = "";
                    document.getElementById("tipoProyectoN").value = "";
                    document.getElementById("fechaProyectoN").value = "";
                    document.getElementById("responsableProyectoN").value = "";
                    document.getElementById("justificacionProyectoN").value = "";
                    document.getElementById("costeProyectoN").value = "";
                    document.getElementById("modalAgregarProyecto").classList.remove("open");
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
            // console.log(data);
            document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
            alertaImg("Usuarios Obtenidos: " + data.totalUsuarios, "", "info", 200);
        },
    });
}


//Sube Justificacion de Proyectos
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
                // console.log(data);
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


// Justificación Proyectos Adjuntos
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
            console.log(data);
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


// Obtener Status de proyectos
function statusProyecto(idProyecto) {
    document.getElementById("modalTituloEliminar").classList.add("open");
    let tituloActual = document.getElementById(idProyecto + 'tituloProyecto').innerHTML;
    document.getElementById("inputEditarTitulo").value = tituloActual;

    document.getElementById("btnEditarTitulo")
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


$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });
$tablaPlanes.innerHTML += datosPlanes({ id: '588', destino: 'CMU', actividad: 'Aqui va el nombre o descripcion del proyecto', creadoPor: 'Eduardo Meneses', pda: '44/66', responsable: 'Pedro Rego', fechaInicio: '15/10/2020', fechaFin: '16/10/2020', comentarios: 0, adjuntos: 7, justificacion: 'si', coste: '345352', status: 'pendiente', materiales: 'no', energeticos: 'no', direccion: 'si', trabajando: 'si' });



// ********** FRAGMENTO PARA LOS EVENTOS **********
// EVENTO PARA EXPORTA PROYECTOS EN EXCEL
document.getElementById("exportarProyectos").addEventListener('click', function () {
    tableToExcel('contenedorDeProyectos', 'PROYECTOS');
});


// EVENTO PARA BUSCAR PROYECTOS EN LA TABLA
document.getElementById("palabraProyecto").addEventListener('keyup', function () {
    buscadorEquipo('contenedorDeProyectos', 'palabraProyecto', 0);
});


// EVENTO PARA PROYECTOS PENDIENTES
document.getElementById("proyectosPendientes").addEventListener('click', function () {
    let idSeccion = localStorage.getItem('idSeccion');
    obtenerProyectos(idSeccion, 'PENDIENTE');
    alertaImg('Proyectos Pendientes', '', 'success', 1500);
});


// EVENTO PARA PROYECTOS SOLUCIONADOS
document.getElementById("proyectosSolucionados").addEventListener('click', function () {
    let idSeccion = localStorage.getItem('idSeccion');
    obtenerProyectos(idSeccion, 'SOLUCIONADO');
    alertaImg('Proyectos Solucionados', '', 'success', 1500);
});


// EVENTO PARA PROYECTOS SOLUCIONADOS
document.getElementById("btnCerrerModalProyectos").addEventListener('click', function () {
    document.getElementById("tooltipProyectos").classList.add('hidden');
});
// ********** FRAGMENTO PARA LOS EVENTOS **********