// VARIABLES GLOBALES, REQUERIDA PARA CADA CONSULTA AJAX
let idUsuario = localStorage.getItem('usuario');
let idDestino = localStorage.getItem('idDestino');
// VARIABLES GLOBALES, REQUERIDA PARA CADA CONSULTA AJAX


// Función principal.
function comprobarSession() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    // Comprueba que exista la session.
    if (idUsuario != '' && idDestino != '') {
        llamarFuncionX('consultaSubsecciones');
        hora();
    } else {
        location.replace("login.php");
    }
}

function obtenerDatosUsuario(idDestino) {
    localStorage.setItem('idDestino', idDestino);
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerDatosUsuario";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("avatarUsuario").innerHTML = '<img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=' + data.nombre + ' % ' + data.apellido + '"' + 'alt="avatar" class="menu-contenedor-6">';
            document.getElementById("nombreUsuarioNavBarTop").innerHTML = data.nombre + ' ' + data.apellido;
            document.getElementById("nombreUsuarioMenu").innerHTML = data.nombre + ' ' + data.apellido;
            document.getElementById("cargoUsuarioMeu").innerHTML = data.cargo;
            document.getElementById("destinoNavBarTop").innerHTML = data.destino;
            document.getElementById("destinosSelecciona").innerHTML = data.destinosOpcion;

            alertaImg('Destino Seleccionado: ' + data.destino, '', 'success', 2000);

            comprobarSession()
        }
    });
}

// Función autoCall.
(() => {
    let idDestino = localStorage.getItem('idDestino');
    obtenerDatosUsuario(idDestino);
})();


// Función para Input Fechas para Agregar MC.
$(function () {
    $('input[name="datefilter"]').daterangepicker({
        autoUpdateInput: false,
        showWeekNumbers: true,
        locale: {
            cancelLabel: 'Cancelar',
            applyLabel: "Aplicar",
            fromLabel: "De",
            toLabel: "A",
            customRangeLabel: "Personalizado",
            weekLabel: "S",
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        }
    });
    $('input[name="datefilter"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
    });
    $('input[name="datefilter"]').on('cancel.daterangepicker', function (ev, picker) {
        // console.log(picker);
        $(this).val('');
    });
});


// Función para Input Fechas PROYECTOS
$(function () {
    $('input[name="fechaProyecto"]').daterangepicker({
        autoUpdateInput: false,
        showWeekNumbers: true,
        locale: {
            cancelLabel: 'Cancelar',
            applyLabel: "Aplicar",
            fromLabel: "De",
            toLabel: "A",
            customRangeLabel: "Personalizado",
            weekLabel: "S",
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        }
    });
    $('input[name="fechaProyecto"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));

        // Actualiza fecha TAREAS cuando se Aplica el rango.
        let rangoFecha = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
        let idProyecto = localStorage.getItem('idProyecto');
        actualizarProyectos(rangoFecha, 'rango_fecha', idProyecto);
    });
    $('input[name="fechaProyecto"]').on('cancel.daterangepicker', function (ev, picker) {
        // console.log(picker);
        $(this).val('');
    });
});


// Función para Input Fechas TAREAS
$(function () {
    $('input[name="fechaTareas"]').daterangepicker({
        autoUpdateInput: false,
        showWeekNumbers: true,
        locale: {
            cancelLabel: 'Cancelar',
            applyLabel: "Aplicar",
            fromLabel: "De",
            toLabel: "A",
            customRangeLabel: "Personalizado",
            weekLabel: "S",
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        }
    });
    $('input[name="fechaTareas"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));

        // Actualiza fecha TAREAS cuando se Aplica el rango.
        let rangoFecha = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
        let idTarea = localStorage.getItem('idTarea');
        actualizarTareas(idTarea, 'rango_fecha', rangoFecha);
    });
    $('input[name="fechaTareas"]').on('cancel.daterangepicker', function (ev, picker) {
        // console.log(picker);
        $(this).val('');
    });
});


// Función para Input Fechas FALLAS
$(function () {
    $('input[name="fechaMC"]').daterangepicker({
        autoUpdateInput: false,
        showWeekNumbers: true,
        locale: {
            cancelLabel: 'Cancelar',
            applyLabel: "Aplicar",
            fromLabel: "De",
            toLabel: "A",
            customRangeLabel: "Personalizado",
            weekLabel: "S",
            daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        }
    });
    $('input[name="fechaMC"]').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));

        // Actualiza fecha MC cuando se Aplica el rango.
        let rangoFecha = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
        let idMC = localStorage.getItem('idMC');
        actualizarStatusMC(idMC, 'rango_fecha', rangoFecha);
    });
    $('input[name="fechaMC"]').on('cancel.daterangepicker', function (ev, picker) {
        // console.log(picker);
        $(this).val('');
    });
});

// Funcion para los Botones de los Calendario
function botones(idd) {
    let nombreCol = idd.toUpperCase();
    if (document.getElementById('col' + idd)) {

        switch (idd) {
            case 'zia':
                document.getElementById('colzia').classList.toggle('hidden');
                document.getElementById('btn-zia').classList.toggle('btn-activo');
                break;
            case 'zie':
                document.getElementById('colzie').classList.toggle('hidden');
                document.getElementById('btn-zie').classList.toggle('btn-activo');
                break;
            case 'zic':
                document.getElementById('colzic').classList.toggle('hidden');
                document.getElementById('btn-zic').classList.toggle('btn-activo');
                break;
            case 'zhp':
                document.getElementById('colzhp').classList.toggle('hidden');
                document.getElementById('btn-zhp').classList.toggle('btn-activo');
                break;
            case 'dec':
                document.getElementById('coldec').classList.toggle('hidden');
                document.getElementById('btn-dec').classList.toggle('btn-activo');
                break;
            case 'zhc':
                document.getElementById('colzhc').classList.toggle('hidden');
                document.getElementById('btn-zhc').classList.toggle('btn-activo');
                break;
            case 'zha':
                document.getElementById('colzha').classList.toggle('hidden');
                document.getElementById('btn-zha').classList.toggle('btn-activo');
                break;
            case 'zil':
                document.getElementById('colzil').classList.toggle('hidden');
                document.getElementById('btn-zil').classList.toggle('btn-activo');
                break;
            case 'auto':
                document.getElementById('colauto').classList.toggle('hidden');
                document.getElementById('btn-auto').classList.toggle('btn-activo');
                break;
            case 'dep':
                document.getElementById('coldep').classList.toggle('hidden');
                document.getElementById('btn-dep').classList.toggle('btn-activo');
                break;
        }
    } else {
        alertaImg('Acceso Denegado en: ' + nombreCol, '', 'warning', 4000);
    }
}


// Función para el calendario de Secciones.
function calendarioSecciones() {
    var numSem = new Date().getDay();
    var diasSem = ['domingo', 'lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado'];
    var hoydia = diasSem[numSem];
    var horas = new Date().getHours();
    var minutos = new Date().getMinutes();
    var mes = new Date().getMonth() + 1;
    var dia = new Date().getDate();

    if (dia < 10) {
        dia = '0' + dia;
    }

    if (mes < 10) {
        mes = '0' + mes;
    }

    document.getElementById('hora').innerHTML = horas + ': ' + minutos;
    document.getElementById('mes').innerHTML = mes;
    document.getElementById('dia').innerHTML = dia;

    // Restable Clases en los Botones.
    document.getElementById('btn-zil').classList.remove('btn-activo');
    document.getElementById('btn-auto').classList.remove('btn-activo');
    document.getElementById('btn-dep').classList.remove('btn-activo');
    document.getElementById('btn-zia').classList.remove('btn-activo');
    document.getElementById('btn-zhp').classList.remove('btn-activo');
    document.getElementById('btn-zic').classList.remove('btn-activo');
    document.getElementById('btn-dec').classList.remove('btn-activo');
    document.getElementById('btn-zie').classList.remove('btn-activo');
    document.getElementById('btn-zhc').classList.remove('btn-activo');
    document.getElementById('btn-zha').classList.remove('btn-activo');
    document.getElementById('colzia').classList.add('hidden');
    document.getElementById('colzhp').classList.add('hidden');
    document.getElementById('coldep').classList.add('hidden');
    document.getElementById('colzic').classList.add('hidden');
    document.getElementById('coldec').classList.add('hidden');
    document.getElementById('colzie').classList.add('hidden');
    document.getElementById('colzhc').classList.add('hidden');
    document.getElementById('colzha').classList.add('hidden');
    document.getElementById('colzil').classList.add('hidden');
    document.getElementById('colauto').classList.add('hidden');



    switch (hoydia) {
        case 'lunes':
            document.getElementById('btn-zia').classList.add('btn-activo');
            document.getElementById('btn-zhp').classList.add('btn-activo');
            document.getElementById('btn-dep').classList.add('btn-activo');
            document.getElementById('label-lunes').classList.add('text-gray-700');
            document.getElementById('colzia').classList.remove('hidden');
            document.getElementById('colzhp').classList.remove('hidden');
            document.getElementById('coldep').classList.remove('hidden');
            break;
        case 'martes':
            document.getElementById('btn-dep').classList.add('btn-activo');
            document.getElementById('btn-zic').classList.add('btn-activo');
            document.getElementById('label-martes').classList.add('text-gray-700');
            document.getElementById('colzic').classList.remove('hidden');
            document.getElementById('coldep').classList.remove('hidden');
            break;
        case 'miercoles':
            document.getElementById('btn-dec').classList.add('btn-activo');
            document.getElementById('btn-dep').classList.add('btn-activo');
            document.getElementById('btn-zie').classList.add('btn-activo');
            document.getElementById('label-miercoles').classList.add('text-gray-700');
            document.getElementById('coldec').classList.remove('hidden')
            document.getElementById('coldep').classList.remove('hidden');
            document.getElementById('colzie').classList.remove('hidden');
            break;
        case 'jueves':
            document.getElementById('btn-zhc').classList.add('btn-activo');
            document.getElementById('btn-zha').classList.add('btn-activo');
            document.getElementById('btn-dep').classList.add('btn-activo');
            document.getElementById('label-jueves').classList.add('text-gray-700');
            document.getElementById('colzhc').classList.remove('hidden');
            document.getElementById('colzha').classList.remove('hidden');
            document.getElementById('coldep').classList.remove('hidden');
            break;
        case 'viernes':
            document.getElementById('btn-zil').classList.add('btn-activo');
            document.getElementById('btn-auto').classList.add('btn-activo');
            document.getElementById('btn-dep').classList.add('btn-activo');
            document.getElementById('label-viernes').classList.add('text-gray-700');
            document.getElementById('colzil').classList.remove('hidden');
            document.getElementById('colauto').classList.remove('hidden');
            document.getElementById('coldep').classList.remove('hidden');
            break;
        default:
            document.getElementById('btn-zil').classList.add('btn-activo');
            document.getElementById('btn-auto').classList.add('btn-activo');
            document.getElementById('btn-dep').classList.add('btn-activo');
            document.getElementById('btn-zia').classList.add('btn-activo');
            document.getElementById('btn-zhp').classList.add('btn-activo');
            document.getElementById('btn-zic').classList.add('btn-activo');
            document.getElementById('btn-dec').classList.add('btn-activo');
            document.getElementById('btn-zie').classList.add('btn-activo');
            document.getElementById('btn-zhc').classList.add('btn-activo');
            document.getElementById('btn-zha').classList.add('btn-activo');
            document.getElementById('colzia').classList.remove('hidden');
            document.getElementById('colzhp').classList.remove('hidden');
            document.getElementById('coldep').classList.remove('hidden');
            document.getElementById('colzic').classList.remove('hidden');
            document.getElementById('coldec').classList.remove('hidden');
            document.getElementById('colzie').classList.remove('hidden');
            document.getElementById('colzhc').classList.remove('hidden');
            document.getElementById('colzha').classList.remove('hidden');
            document.getElementById('colzil').classList.remove('hidden');
            document.getElementById('colauto').classList.remove('hidden');
            break;
    }
}

function expandir(id) {
    // console.log(id);
    let idtoggle = id + 'toggle';
    let idtitulo = id + 'titulo';
    var toggle = document.getElementById(idtoggle);
    toggle.classList.toggle("hidden");
    document.getElementById(idtitulo).classList.toggle('truncate');
}


function expandirpapa(idpapa) {
    var expandeapapa = document.getElementById(idpapa);
    expandeapapa.classList.toggle("h-40");
}


// Función para actualizar la Hora.
function hora() {
    var arrayDestino = {
        1: "RM",
        7: "CMU",
        2: "PVR",
        6: "MBJ",
        5: "PUJ",
        11: "CAP",
        3: "SDQ",
        4: "SSA",
        10: "AME"
    };
    let idDestino = localStorage.getItem('idDestino');
    let h = new Date();
    let hora = h.getHours() + ': ' + h.getMinutes();
    let nombreDestinoArray = arrayDestino[idDestino];

    document.getElementById("hora").innerHTML = hora;
    document.getElementById("nombreDestino").innerHTML = nombreDestinoArray;
    // console.log(hora, nombreDestinoArray);
}
// Desde aquí se habla a la función hora(), cada 1min.
setInterval('hora()', 70000);


// toggleClass Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
    $("#" + idModal).toggleClass('open');
}


// Funcion para ocultar y mostrar con clases.
function mostrarOcultar(claseMostrar, claseOcultar) {
    $("." + claseMostrar).removeClass('hidden invisible');
    $("." + claseOcultar).addClass('hidden invisible');
}

// toggle Inivisible Generico.
function toggleInivisble(id) {
    $("#" + id).toggleClass('modal');
}


// Obtiene las subsecciones para la pagina principal de Planner, mediante el idDestino.
function consultaSubsecciones(idDestino, idUsuario) {
    const action = "consultaSubsecciones";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            $("#columnasSeccionesZIL").html(data.dataZIL);
            $("#columnasSeccionesZIE").html(data.dataZIE);
            $("#columnasSeccionesAUTO").html(data.dataAUTO);
            $("#columnasSeccionesDEC").html(data.dataDEC);
            $("#columnasSeccionesDEP").html(data.dataDEP);
            $("#columnasSeccionesOMA").html(data.dataOMA);
            $("#columnasSeccionesZHA").html(data.dataZHA);
            $("#columnasSeccionesZHC").html(data.dataZHC);
            $("#columnasSeccionesZHH").html(data.dataZHH);
            $("#columnasSeccionesZHP").html(data.dataZHP);
            $("#columnasSeccionesZIA").html(data.dataZIA);
            $("#columnasSeccionesZIC").html(data.dataZIC);
            calendarioSecciones();
        }
    });
}


// Obtiene los pendientes de las secciones mediante la seccion seleccionada y el destinol.
function pendientesSubsecciones(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino) {
    // console.log(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino);
    document.getElementById("dataOpcionesSubseccionestoggle").innerHTML = '';
    document.getElementById("modalPendientes").classList.add('open');
    document.getElementById("estiloSeccion").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    // document.getElementById("modalTituloSeccion").innerHTML = nombreSeccion;
    document.getElementById("dataSubseccionesPendientes").innerHTML = 'Obteniendo Datos...';

    const action = "consultarPendientesSubsecciones";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            tipoPendiente: tipoPendiente
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            // Tipo de Vista Seleccionado
            document.getElementById("tipoPendienteNombre").innerHTML = data.tipoPendienteNombre;

            // Resultado de Consulta.
            document.getElementById("estiloSeccion").innerHTML = data.estiloSeccion;

            // Función para darle diseño del Logo según la Sección.
            estiloSeccion('estiloSeccion', data.estiloSeccion);
            document.getElementById("dataSubseccionesPendientes").innerHTML = data.resultData;

            document.getElementById("dataExportarSubseccionesEXCEL").innerHTML = data.exportarSubseccion;
            document.getElementById("dataExportarSubseccionesPDF").innerHTML = data.exportarSubseccionPDF;

            // Pestañas para Mostrar Pendientes.
            document.getElementById("misPendientesUsuario").
                setAttribute('onclick', 'pendientesSubsecciones(' + data.misPendientesUsuario + ')');

            document.getElementById("misPendientesCreados").
                setAttribute('onclick', 'pendientesSubsecciones(' + data.misPendientesCreados + ')');

            document.getElementById("misPendientesSinUsuario").
                setAttribute('onclick', 'pendientesSubsecciones(' + data.misPendientesSinUsuario + ')');

            document.getElementById("misPendientesSeccion").
                setAttribute('onclick', 'pendientesSubsecciones(' + data.misPendientesSeccion + ')');


            // Pestaña Exportar
            document.getElementById("exportarMisPendientes").
                setAttribute('onclick', 'exportarPendientes(' + data.exportarMisPendientes + ')');

            document.getElementById("exportarSeccion").
                setAttribute('onclick', 'exportarPendientes(' + data.exportarSeccion + ')');

            // Subseccion EXCEL
            document.getElementById("exportarSeccion").
                setAttribute('onclick', 'exportarPendientes(' + data.exportarSeccion + ')');

            // Responsable EXCEL
            document.getElementById("responsableUsuario").
                setAttribute('onclick', 'exportarPorUsuario(' + data.exportarPorResponsable + ')');

            document.getElementById("exportarMisCreados").
                setAttribute('onclick', 'exportarPendientes(' + data.exportarMisCreados + ')');

            // Creados Por
            document.getElementById("exportarCreadosPorEXCEL").
                setAttribute('onclick', 'exportarPorUsuario(' + data.exportarMisCreados + ')');

            document.getElementById("exportarMisPendientesPDF").
                setAttribute('onclick', 'exportarPendientes(' + data.exportarMisPendientesPDF + ')');

            document.getElementById("exportarMisCreadosPDF").
                setAttribute('onclick', 'exportarPendientes(' + data.exportarMisCreadosPDF + ')');

            // Subsección PDF
            document.getElementById("exportarMisCreadosPDF").
                setAttribute('onclick', 'exportarPendientes(' + data + ')');

            // Colaborador PDF
            document.getElementById("exportarCreadosPorPDF").
                setAttribute('onclick', 'exportarPorUsuario(' + data.exportarMisCreadosPDF + ')');

        }
    });
}


function toggleSubseccionesTipo(mostrar, ocultar) {
    document.getElementById("modalExportarSubsecciones").classList.add('open');
    document.getElementById(mostrar).classList.remove('hidden');
    document.getElementById(ocultar).classList.add('hidden');
}

// Muestra Usuario para Exportar sus pendientes o Creados.
function exportarPorUsuario(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar) {
    document.getElementById("dataExportarSeccionesUsuarios").innerHTML = '';
    let palabraUsuario = document.getElementById("palabraUsuarioExportar").value;
    // Agrega la función en el Input palabraUsuarioExportar.
    document.getElementById("palabraUsuarioExportar").
        setAttribute('onkeyup', 'exportarPorUsuario(' + idUsuario + ', ' + idDestino + ', ' + idSeccion + ', ' + idSubseccion + ', "' + tipoExportar + '")');
    const action = "exportarPorUsuario";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion,
            tipoExportar: tipoExportar,
            palabraUsuario: palabraUsuario
        },
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("modalExportarSeccionesUsuarios").classList.add('open');
            document.getElementById("dataExportarSeccionesUsuarios").innerHTML = data;
        }
    });
}

// El estilo se aplica DIV>H1(class="zie-logo").
function estiloSeccionModal(padreSeccion, seccion) {
    let seccionClase = seccion.toLowerCase() + '-logo-modal';
    document.getElementById(padreSeccion).classList.remove('zil-logo-modal');
    document.getElementById(padreSeccion).classList.remove('zie-logo-modal');
    document.getElementById(padreSeccion).classList.remove('auto-logo-modal');
    document.getElementById(padreSeccion).classList.remove('dec-logo-modal');
    document.getElementById(padreSeccion).classList.remove('dep-logo-modal');
    document.getElementById(padreSeccion).classList.remove('zha-logo-modal');
    document.getElementById(padreSeccion).classList.remove('zhc-logo-modal');
    document.getElementById(padreSeccion).classList.remove('zhp-logo-modal');
    document.getElementById(padreSeccion).classList.remove('zia-logo-modal');
    document.getElementById(padreSeccion).classList.remove('zic-logo-modal');

    document.getElementById(padreSeccion).classList.add(seccionClase);
}

// El estilo se aplica DIV>H1(class="zie-logo").
function estiloSeccion(padreSeccion, seccion) {
    let seccionClase = seccion.toLowerCase() + '-logo';
    // console.log(seccionClase);
    document.getElementById(padreSeccion).classList.remove('zil-logo');
    document.getElementById(padreSeccion).classList.remove('zie-logo');
    document.getElementById(padreSeccion).classList.remove('auto-logo');
    document.getElementById(padreSeccion).classList.remove('dec-logo');
    document.getElementById(padreSeccion).classList.remove('dep-logo');
    document.getElementById(padreSeccion).classList.remove('zha-logo');
    document.getElementById(padreSeccion).classList.remove('zhc-logo');
    document.getElementById(padreSeccion).classList.remove('zhp-logo');
    document.getElementById(padreSeccion).classList.remove('zia-logo');
    document.getElementById(padreSeccion).classList.remove('zic-logo');

    document.getElementById(padreSeccion).classList.add(seccionClase);
}


// Función para buscar usuarios para Exportar.
function exportarListarUsuarios(idUsuario, idDestino, idSeccion) {
    const action = "exportarListarUsuarios";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
        },
        // dataType: "JSON",
        success: function (data) {
            document.getElementById("dataExportarSeccionesUsuarios").innerHTML = data;
        }
    });
}


// Funcion para Ver y Exportar los pendientes de las secciones.
function exportarPendientes(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar) {
    // console.log(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar);
    const action = "consultaFinalExcel";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion,
            tipoExportar: tipoExportar
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data.listaIdT);
            // console.log(data.listaIdF);
            let usuarioSession = localStorage.getItem('usuario');

            if (tipoExportar == "exportarMisPendientes") {
                page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                window.location = page;
            } else if (tipoExportar == "exportarSeccion") {
                page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                window.location = page;
            } else if (tipoExportar == "exportarSubseccion") {
                page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                window.location = page;
            } else if (tipoExportar == "exportarPorResponsable") {
                page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                window.location = page;
            } else if (tipoExportar == "exportarMisCreados") {
                page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                window.location = page;
            } else if (tipoExportar == "exportarCreadosDe") {
                page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                window.location = page;
            } else if (tipoExportar == "exportarMisCreadosPDF") {
                page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&idDestino=' + idDestino + '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                    usuarioSession;
                window.open(page, "Reporte Fallas Y Tareas PDF",
                    "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                );
            } else if (tipoExportar == "exportarMisPendientesPDF") {
                page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&idDestino=' + idDestino + '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                    usuarioSession;
                window.open(page, "Reporte Fallas Y Tareas PDF",
                    "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                );
            } else if (tipoExportar == "exportarCreadosPorPDF") {
                page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&idDestino=' + idDestino +
                    '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                    usuarioSession;
                window.open(page, "Reporte Fallas Y Tareas PDF",
                    "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                );
            } else if (tipoExportar == "exportarSubseccionPDF") {
                page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&idDestino=' + idDestino +
                    '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                    usuarioSession;
                window.open(page, "Reporte Fallas Y Tareas PDF",
                    "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                );
            }
        }
    });
}

// Obtiene los equipos de las subsecciones y por destino, considerando AME, como Global.
// rangoInicial y rangoFinal, ya no se necesita, solo se utilizaba para la paginación.
function obtenerEquipos(idUsuario, idDestino, idSeccion, idSubseccion, rangoInicial, rangoFinal, tipoOrdenamiento) {
    // console.log(idUsuario, idDestino, idSeccion, idSubseccion, rangoInicial, rangoFinal, tipoOrdenamiento);
    // Se agregan los filtros en las columnas de los equipos.
    document.getElementById("tipoOrdenamientoMCN").setAttribute('onclick', 'obtenerEquipos(' + idUsuario + ',' + idDestino + ',' + idSeccion + ',' + idSubseccion + ',' + rangoInicial + ',' + rangoFinal + ',"MCN")');
    document.getElementById("tipoOrdenamientoMCF").setAttribute('onclick', 'obtenerEquipos(' + idUsuario + ',' + idDestino + ',' + idSeccion + ',' + idSubseccion + ',' + rangoInicial + ',' + rangoFinal + ',"MCF")');
    document.getElementById("tipoOrdenamientoNombreEquipo").setAttribute('onclick', 'obtenerEquipos(' + idUsuario + ',' + idDestino + ',' + idSeccion + ',' + idSubseccion + ',' + rangoInicial + ',' + rangoFinal + ',"nombreEquipo")');

    document.getElementById("dataEquipos").innerHTML = '';
    document.getElementById("seccionEquipos").innerHTML =
        ('<i class="fas fa-spinner fa-pulse fa-2x fa-fw" ></i > ');
    document.getElementById('modalEquipos').classList.add('open');

    let palabraEquipo = document.getElementById("inputPalabraEquipo").value;
    const action = "obtenerEquipos";

    // Alerta para Notificar el tipo de ordenamiento.
    alertaImg('Ordenando Equipos', '', 'info', 3000);
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion,
            palabraEquipo: palabraEquipo,
            rangoInicial: rangoInicial,
            rangoFinal: rangoFinal,
            tipoOrdenamiento: tipoOrdenamiento
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataEquipos").innerHTML = data.dataEquipos;
            document.getElementById("seccionEquipos").innerHTML = data.seccionEquipos;
            estiloSeccionModal('estiloSeccionEquipos', data.seccionEquipos);
            // document.getElementById("paginacionEquipos").innerHTML = data.paginacionEquipos;
            paginacionEquipos();

            // alerta para mostrar información de los Equipos obtenidos.
            alertaImg(data.totalEquipos, '', 'success', 3000);
        }
    });
}

// Función para Paginar los resultados de los Equipos Obtenidos.
function paginacionEquipos() {
    $("div.holder").jPages({
        containerID: 'dataEquipos',
        perPage: 35,
        startPage: 1,
        endRange: 1,
        midRange: 1,
        previous: 'anterior',
        next: 'siguiente',
        animation: false
    });
    // console.log('Paginación');

    $(".holder>a").addClass('-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150');

}

// Obtiene todos los MC-N por Equipo.
function obtenerMCN(idEquipo) {
    // Actualiza el MC seleccionado.

    localStorage.setItem('idEquipo', idEquipo);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSubseccion = localStorage.getItem('idSubseccion');
    // console.log(idEquipo, idUsuario, idDestino, idSubseccion);

    document.getElementById("tipoPendientesX").innerHTML = 'FALLAS PENDIENTES';
    document.getElementById("modalPendientesX").classList.add('open');
    document.getElementById("seccionMCN").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("dataPendientes").innerHTML = '';
    document.getElementById("tipoPendiente").innerHTML = 'FALLA';
    document.getElementById("agregarPendiente").innerHTML = 'Agregar Falla';
    document.getElementById("btnAgregarPendiente").setAttribute('onclick', 'datosModalAgregarMC()');

    const action = "obtenerMCN";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idSubseccion: idSubseccion,
            idDestino: idDestino,
            idEquipo: idEquipo
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            estiloSeccionModal('estiloSeccionMCN', data.seccion);
            document.getElementById("seccionMCN").innerHTML = data.seccion;
            document.getElementById("nombreEquipoMCN").innerHTML = data.nombreEquipo;
            document.getElementById("dataPendientes").innerHTML = data.MC;
            alertaImg('Fallas Pendientes: ' + data.contadorMC, '', 'info', 3000);
        }
    });
}


// Función para Obtener el Status y agregar la funcion para poder actualizarlo.
function obtenerstatusMC(idMC) {
    document.getElementById("modalStatus").classList.add('open');
    localStorage.setItem('idMC', idMC);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = "obtenerStatusMC";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idMC: idMC
        },
        dataType: "JSON",
        success: function (data) {
            // Llama a la Función para reflejar los cambios en los MC por Equipo.

            // console.log(data);
            // Status
            document.getElementById("statusUrgente").
                setAttribute('onclick', data.dataStatusUrgente);
            document.getElementById("statusMaterial").
                setAttribute('onclick', data.dataStatusMaterial);
            document.getElementById("statusTrabajare").
                setAttribute('onclick', data.dataStatusTrabajare);
            // Status Departamento.
            document.getElementById("statusCalidad").
                setAttribute('onclick', data.dataStatusCalidad);
            document.getElementById("statusCompras").
                setAttribute('onclick', data.dataStatusCompras);
            document.getElementById("statusDireccion").
                setAttribute('onclick', data.dataStatusDireccion);
            document.getElementById("statusFinanzas").
                setAttribute('onclick', data.dataStatusFinanzas);
            document.getElementById("statusRRHH").
                setAttribute('onclick', data.dataStatusRRHH);
            // Status Energéticos.
            document.getElementById("statusElectricidad").
                setAttribute('onclick', data.dataStatusElectricidad);
            document.getElementById("statusAgua").
                setAttribute('onclick', data.dataStatusAgua);
            document.getElementById("statusDiesel").
                setAttribute('onclick', data.dataStatusDiesel);
            document.getElementById("statusGas").
                setAttribute('onclick', data.dataStatusGas);
            // Finalizar MC.
            document.getElementById("statusFinalizar").
                setAttribute('onclick', data.dataStatus);
            // Activo MC.
            document.getElementById("statusActivo").
                setAttribute('onclick', data.dataStatusActivo);
            // Titulo MC.
            document.getElementById("btnEditarTitulo").
                setAttribute('onclick', data.dataStatusTitulo);
            document.getElementById("inputEditarTitulo").value = data.dataTituloMC;
        }
    });
}


// Función para actualizar Status t_mc.
function actualizarStatusMC(idMC, status, valorStatus) {
    alertaImg('Procesando Cambios...', '', 'info', 1000);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');
    let tituloMC = document.getElementById("inputEditarTitulo").value;
    const action = "actualizarStatusMC";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idMC: idMC,
            status: status,
            valorStatus: valorStatus,
            tituloMC: tituloMC
        },
        // dataType: "JSON",
        success: function (data) {
            if (data == 1) {

                alertaImg('Información Actualizada', '', 'success', 2000);
                if (status == "activo" || status == "status") {
                    llamarFuncionX('obtenerEquipos');
                    obtenerDatosUsuario(idDestino);
                }
                if (valorStatus == 'F') {
                    obtenerMCF(idEquipo);
                } else {
                    obtenerMCN(idEquipo);
                    document.getElementById("modalEditarTitulo").classList.remove('open');
                    document.getElementById("modalStatus").classList.remove('open');
                }
                // Cierra el Modal de Fecha MC.
                document.getElementById("modalFechaMC").classList.remove('open');
            } else {
                alertaImg('Intente de Nuevo', '', 'question', 2000);
            }
        }
    });
}

// Obtiene todos los MC-F por Equipo.
function obtenerMCF(idEquipo) {
    // console.log(idEquipo);
    document.getElementById("tipoSolucionadosX").innerHTML = 'FALLAS SOLUCIONADAS';
    document.getElementById("seccionMCF").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("modalSolucionadosX").classList.add('open');
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSubseccion = localStorage.getItem('idSubseccion');

    const action = "obtenerMCF";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo,
            idSubseccion: idSubseccion
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataMCF").innerHTML = data.dataMCF;
            estiloSeccionModal('estiloSeccionMCF', data.seccion);
            document.getElementById("seccionMCF").innerHTML = data.seccion;
            document.getElementById("nombreEquipoMCF").innerHTML = data.nombreEquipo;
            alertaImg('Fallas Solucionadas: ' + data.totalMCF, '', 'info', 2000);
        }
    });
}


function datosModalAgregarMC() {
    document.getElementById("responsableMC").innerHTML = '';
    document.getElementById("modalAgregarMC").classList.add('open');
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');

    const action = "obtenerDatosAgregarMC";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo
        },
        dataType: "JSON",
        success: function (data) {
            let idUltimoMC = parseInt(data.idUltimoMC) + 1;
            // console.log(data);
            document.getElementById("btnAgregarMC").setAttribute('onclick', 'agregarMC(' + idUltimoMC + ');');
            document.getElementById("responsableMC").innerHTML = data.dataUsuarios;
            document.getElementById("nombreEquipoMC").innerHTML = data.nombreEquipo;
        }
    });
}


function agregarMC(idMC) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    let actividadMC = document.getElementById("inputActividadMC").value;
    let rangoFechaMC = document.getElementById("inputRangoFechaMC").value;
    let responsableMC = document.getElementById("responsableMC").value;
    let comentarioMC = document.getElementById("comentarioMC").value;
    // console.log(idUsuario, idDestino, idEquipo, idSeccion, idSubseccion, actividadMC, rangoFechaMC, responsableMC, comentarioMC);

    if (actividadMC != "" && rangoFechaMC != "" && responsableMC != "") {
        const action = "agregarMC";
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idMC: idMC,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idEquipo: idEquipo,
                idSeccion: idSeccion,
                idSubseccion: idSubseccion,
                actividadMC: actividadMC,
                rangoFechaMC: rangoFechaMC,
                responsableMC: responsableMC
            },
            // dataType: "JSON",
            success: function (data) {
                // console.log(data);
                document.getElementById("inputComentario").value = comentarioMC;
                if (data >= 1) {
                    agregarComentarioMC(idMC);
                    alertaImg('MC agregado', '', 'success', 1500);
                    obtenerDatosUsuario(idDestino);
                    obtenerMCN(idEquipo);
                    llamarFuncionX('obtenerEquipos');
                    datosModalAgregarMC();
                    document.getElementById("inputActividadMC").value = '';
                    document.getElementById("comentarioMC").value = '';
                    setTimeout(function () {
                        document.getElementById("modalAgregarMC").classList.remove('open');
                        document.getElementById("modalComentarios").classList.remove('open');
                    }, 1200);
                } else {
                    alertaImg('Intente de Nuevo', '', 'question', 1500);
                    datosModalAgregarMC();
                }
            }
        });
    } else {
        alertaImg('Información No Valida', '', 'question', 2000);
    }
}

// Obtener usuario recibe 2 parametros especificos, donde tipoAsignación se refiere a la tabla donde se va a utilizar el usuario y idItem es el identificador del registro que se le va asignar. 
function obtenerUsuarios(tipoAsginacion, idItem) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let palabraUsuario = document.getElementById('palabraUsuario').value;

    document.getElementById("modalUsuarios").classList.add('open');
    document.getElementById("dataUsuarios").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

    const action = "obtenerUsuarios";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            palabraUsuario: palabraUsuario,
            tipoAsginacion: tipoAsginacion,
            idItem: idItem
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            alertaImg('Usuarios Obtenidos: ' + data.totalUsuarios, '', 'info', 2000);
            document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
            document.getElementById("palabraUsuario").
                setAttribute('onkeydown', 'obtenerUsuarios("' + tipoAsginacion + '",' + idItem + ')');
        }
    });
}


// Función para Asignar usuario.
function asignarUsuario(idUsuarioSeleccionado, tipoAsginacion, idItem) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    const action = "asignarUsuario";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idUsuarioSeleccionado: idUsuarioSeleccionado,
            idDestino: idDestino,
            tipoAsginacion: tipoAsginacion,
            idItem: idItem
        },
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);

            if (data == "MC") {
                alertaImg('Responsable Actualizado', '', 'success', 2500);
                document.getElementById("modalUsuarios").classList.remove('open');
                let idEquipo = localStorage.getItem('idEquipo');
                obtenerMCN(idEquipo);

                // TAREAS
            } else if (data == "TAREA") {
                alertaImg('Responsable Actualizado', '', 'success', 2500);
                document.getElementById("modalUsuarios").classList.remove('open');
                let idEquipo = localStorage.getItem('idEquipo');
                obtenerTareasP(idEquipo);
            } else {
                alertaImg('Intenete de Nuevo', '', 'question', 2500);
            }
        }
    });
}


// Agregar Fecha MC.
function obtenerFechaMC(idMC, rangoFecha) {
    document.getElementById("modalFechaMC").classList.add('open');
    document.getElementById("fechaMC").value = rangoFecha;
    localStorage.setItem('idMC', idMC);
}

// Funcion para Obtener Adjuntos.
function obtenerAdjuntosMC(idMC) {
    // Actualiza el MC seleccionado.
    localStorage.setItem('idMC', idMC);

    // Recupera datos.
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');

    document.getElementById("dataImagenes").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("dataAdjuntos").classList.add('justify-center');

    document.getElementById("dataAdjuntos").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("dataImagenes").classList.add('justify-center');
    document.getElementById("modalMedia").classList.add('open');

    const action = "obtenerAdjuntosMC";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idMC: idMC
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataImagenes").classList.remove('justify-center');
            document.getElementById("dataImagenes").innerHTML = data.dataImagenes;
            document.getElementById("dataAdjuntos").classList.remove('justify-center');
            document.getElementById("dataAdjuntos").innerHTML = data.dataAdjuntos;
            document.getElementById("statusActivo").
                setAttribute('onclick', data.dataAdjuntos);
        }
    });
}


// Funcion para Obtener Comentarios MC.
function obtenerComentariosMC(idMC) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    document.getElementById("modalComentarios").classList.add('open');
    document.getElementById("dataComentarios").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

    const action = "obtenerComentariosMC";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idMC: idMC
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("btnComentario").
                setAttribute('onclick', 'agregarComentarioMC(' + idMC + ')');
            document.getElementById("inputComentario").
                setAttribute('onkeyup', 'if(event.keyCode == 13)agregarComentarioMC(' + idMC + ')');
            document.getElementById("dataComentarios").innerHTML = data.dataComentarios;

        }
    });
}


// Agregar Comentario MC.
function agregarComentarioMC(idMC) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');
    let comentarioMC = document.getElementById("inputComentario").value;
    const action = "agregarComentarioMC";
    if (comentarioMC.length > 0) {
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idMC: idMC,
                comentarioMC: comentarioMC
            },
            // dataType: "JSON",
            success: function (data) {
                if (data == 1) {
                    obtenerComentariosMC(idMC);
                    obtenerMCN(idEquipo);
                    document.getElementById("inputComentario").value = '';
                    alertaImg('Comentario Agregado', '', 'success', 2000);
                } else {
                    alertaImg('Intente de Nuevo', '', 'question', 2000);
                }
            }
        });
    } else {
        alertaImg('Comentario Vacio', '', 'info', 2000);
    }
}


// Se obtienen las Tareas Pendientes.
function obtenerTareasP(idEquipo) {
    document.getElementById("tipoPendientesX").innerHTML = 'TAREAS PENDIENTES';
    localStorage.setItem('idEquipo', idEquipo);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSubseccion = localStorage.getItem('idSubseccion');

    document.getElementById("modalPendientesX").classList.add('open');
    document.getElementById("seccionMCN").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("dataPendientes").innerHTML = '';
    document.getElementById("tipoPendiente").innerHTML = 'TAREAS';
    document.getElementById("agregarPendiente").innerHTML = 'Agregar Tarea';
    document.getElementById("btnAgregarPendiente").setAttribute('onclick', 'datosAgregarTarea()');
    document.getElementById("btnAgregarMC").setAttribute('onclick', 'agregarTarea()');
    const action = "obtenerTareasP";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idSubseccion: idSubseccion,
            idDestino: idDestino,
            idEquipo: idEquipo
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            estiloSeccionModal('estiloSeccionMCN', data.seccion);
            document.getElementById("seccionMCN").innerHTML = data.seccion;
            document.getElementById("nombreEquipoMCN").innerHTML = data.nombreEquipo;
            document.getElementById("dataPendientes").innerHTML = data.dataTareas;
            alertaImg('Tareas Pendientes: ' + data.contadorTareas, '', 'info', 3000);
        }
    });
}


//Se obtienen las Tareas Finaizadas. 
function obtenerTareasS(idEquipo) {
    // console.log(idEquipo);
    document.getElementById("tipoSolucionadosX").innerHTML = 'FALLAS SOLUCIONADAS';
    document.getElementById("seccionMCF").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("modalSolucionadosX").classList.add('open');
    document.getElementById("tipoPendiente").value = 'TAREAS';

    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSubseccion = localStorage.getItem('idSubseccion');

    const action = "obtenerTareasS";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo,
            idSubseccion: idSubseccion
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataMCF").innerHTML = data.dataTareas;
            estiloSeccionModal('estiloSeccionMCF', data.seccion);
            document.getElementById("seccionMCF").innerHTML = data.seccion;
            document.getElementById("nombreEquipoMCF").innerHTML = data.nombreEquipo;
            alertaImg('Tareas Solucionadas: ' + data.contadorTareas, '', 'info', 2000);
        }
    })
}


// Obtener Media para las TAREAS.
function obtenerAdjuntosTareas(idTarea) {
    // Actualiza id TAREA seleccionado.
    localStorage.setItem('idTarea', idTarea);

    // Recupera datos.
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    document.getElementById("dataImagenes").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("dataAdjuntos").classList.add('justify-center');

    document.getElementById("dataAdjuntos").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("dataImagenes").classList.add('justify-center');
    document.getElementById("modalMedia").classList.add('open');

    const action = "obtenerAdjuntosTareas";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTarea: idTarea
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataImagenes").classList.remove('justify-center');
            document.getElementById("dataImagenes").innerHTML = data.dataImagenes;
            document.getElementById("dataAdjuntos").classList.remove('justify-center');
            document.getElementById("dataAdjuntos").innerHTML = data.dataAdjuntos;
            document.getElementById("statusActivo").
                setAttribute('onclick', data.dataAdjuntos);
        }
    });
}

// Funcion para Obtener Comentarios TAREAS
function obtenerComentariosTareas(idTarea) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    document.getElementById("modalComentarios").classList.add('open');
    document.getElementById("dataComentarios").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

    const action = "obtenerComentariosTareas";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTarea: idTarea
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("btnComentario").
                setAttribute('onclick', 'agregarComentarioTarea(' + idTarea + ')');
            document.getElementById("inputComentario").
                setAttribute('onkeyup', 'if(event.keyCode == 13)agregarComentarioTarea(' + idTarea + ')');
            document.getElementById("dataComentarios").innerHTML = data.dataComentarios;

        }
    });
}

// Agregar Comentario TAREA.
function agregarComentarioTarea(idTarea) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');
    let comentarioTarea = document.getElementById("inputComentario").value;
    const action = "agregarComentarioTarea";
    if (comentarioTarea.length > 0) {
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idTarea: idTarea,
                comentarioTarea: comentarioTarea
            },
            // dataType: "JSON",
            success: function (data) {
                if (data == 1) {
                    obtenerComentariosTarea(idTarea);
                    obtenerTareasP(idEquipo);
                    document.getElementById("inputComentario").value = '';
                    alertaImg('Comentario Agregado', '', 'success', 2000);
                } else {
                    alertaImg('Intente de Nuevo', '', 'question', 2000);
                }
            }
        });
    } else {
        alertaImg('Comentario Vacio', '', 'info', 2000);
    }
}


// Modifica Status o alguna Columna(titulo, activo, status) en TAREAS
function obtenerInformacionTareas(idTarea, tituloTarea) {
    document.getElementById("modalStatus").classList.add('open');
    localStorage.setItem('idTarea', idTarea);

    // La función actulizarTarea(), recibe 3 parametros idTarea, columna a modificar y el tercer parametro solo funciona para el titulo por ahora

    // Status
    document.getElementById("statusUrgente").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "status_urgente", 0)');
    document.getElementById("statusMaterial").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "status_material", 0)');
    document.getElementById("statusTrabajare").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "status_trabajando", 0)');

    // Status Departamento.
    document.getElementById("statusCalidad").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "departamento_calidad", 0)');
    document.getElementById("statusCompras").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "departamento_compras", 0)');
    document.getElementById("statusDireccion").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "departamento_direccion", 0)');
    document.getElementById("statusFinanzas").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "departamento_finanzas", 0)');
    document.getElementById("statusRRHH").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "departamento_rrhh", 0)');

    // Status Energéticos.
    document.getElementById("statusElectricidad").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "energetico_electricidad", 0)');
    document.getElementById("statusAgua").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "energetico_agua", 0)');
    document.getElementById("statusDiesel").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "energetico_diesel", 0)');
    document.getElementById("statusGas").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "energetico_gas", 0)');

    // Finalizar MC.
    document.getElementById("statusFinalizar").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "status", "F")');
    // Activo MC.
    document.getElementById("statusActivo").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "activo", 0)');
    // Titulo MC.
    document.getElementById("btnEditarTitulo").
        setAttribute('onclick', 'actualizarTareas(' + idTarea + ', "titulo", 0)');
    document.getElementById("inputEditarTitulo").value = tituloTarea;
}


// Actualiza Datos de las Tareas
function actualizarTareas(idTarea, columna, valor) {
    let tituloNuevo = document.getElementById("inputEditarTitulo").value;
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');
    const action = "actualizarTareas";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTarea: idTarea,
            columna: columna,
            valor: valor,
            tituloNuevo: tituloNuevo
        },
        // dataType: "JSON",
        success: function (data) {

            if (data == 1) {
                obtenerTareasP(idEquipo);
                alertaImg('Status Actualizada', '', 'success', 2000);
                document.getElementById("modalStatus").classList.remove('open');
            } else if (data == 2) {
                obtenerDatosUsuario(idDestino);
                llamarFuncionX('obtenerEquipos');
                obtenerTareasP(idEquipo);
                alertaImg('Tarea SOLUCIONADA', '', 'success', 2000);
                document.getElementById("modalStatus").classList.remove('open');
            } else if (data == 3) {
                obtenerDatosUsuario(idDestino);
                obtenerTareasS(idEquipo);
                llamarFuncionX('obtenerEquipos');
                alertaImg('Tarea Recuperada como PENDIENTE', '', 'success', 2000);
                document.getElementById("modalStatus").classList.remove('open');
            } else if (data == 4) {
                obtenerTareasP(idEquipo);
                obtenerDatosUsuario(idDestino);
                llamarFuncionX('obtenerEquipos');
                alertaImg('Tarea Eliminada', '', 'success', 2000);
                document.getElementById("modalStatus").classList.remove('open');
            } else if (data == 5) {
                obtenerTareasP(idEquipo);
                alertaImg('Título Actualizado', '', 'success', 2000);
                document.getElementById("modalStatus").classList.remove('open');
            } else if (data == 6) {
                obtenerTareasP(idEquipo);
                alertaImg('Rango de Fecha, Actualizada', '', 'success', 2000);
                document.getElementById("modalStatus").classList.remove('open');
            } else {
                alertaImg('Intente de Nuevo', '', 'question', 2000);
            }
        }
    });
}


// Agregar Fecha MC.
function obtenerFechaTareas(idTarea, rangoFecha) {
    document.getElementById("modalFechaTareas").classList.add('open');
    document.getElementById("fechaTareas").value = rangoFecha;
    localStorage.setItem('idTarea', idTarea);
}


// Opciones Responsable para Agregar Tarea.
function datosAgregarTarea() {
    document.getElementById("responsableMC").innerHTML = '';
    document.getElementById("modalAgregarMC").classList.add('open');
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');

    const action = "obtenerDatosAgregarMC";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("responsableMC").innerHTML = data.dataUsuarios;
            document.getElementById("nombreEquipoMC").innerHTML = data.nombreEquipo;
        }
    });
}


// Agregar TAREA
function agregarTarea() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idEquipo = localStorage.getItem('idEquipo');
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    let titulo = document.getElementById("inputActividadMC").value;
    let rangoFecha = document.getElementById("inputRangoFechaMC").value;
    let responsable = document.getElementById("responsableMC").value;
    let comentario = document.getElementById("comentarioMC").value;

    if (titulo != "" && rangoFecha != "" && responsable != "") {
        const action = "agregarTarea";
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idEquipo: idEquipo,
                idSeccion: idSeccion,
                idSubseccion: idSubseccion,
                titulo: titulo,
                rangoFecha: rangoFecha,
                responsable: responsable,
                comentario: comentario
            },
            // dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    obtenerDatosUsuario(idDestino);
                    llamarFuncionX('obtenerEquipos');
                    obtenerTareasP(idEquipo);
                    document.getElementById("inputActividadMC").value = '';
                    document.getElementById("modalAgregarMC").classList.remove('open');
                    alertaImg('Tarea Agregada', '', 'success', 1500);
                } else if (data == 2) {
                    obtenerDatosUsuario(idDestino);
                    llamarFuncionX('obtenerEquipos');
                    obtenerTareasP(idEquipo);
                    document.getElementById("inputActividadMC").value = '';
                    document.getElementById("modalAgregarMC").classList.remove('open');
                    document.getElementById("comentarioMC").value = '';
                    alertaImg('Tarea Y Comentario, Agregado', '', 'success', 1500);
                } else {
                    alertaImg('Intente de Nuevo', '', 'question', 1500);
                }
            }
        });
    } else {
        alertaImg('Información No Valida', '', 'question', 2000);
    }
}


// Obtiene MEDIA de EQUIPOS (ADJUNTOS: IMAGENES Y DOCUMENTOS)
function obtenerMediaEquipo(idEquipo) {
    document.getElementById("modalMedia").classList.add('open');
    document.getElementById("inputAdjuntos").setAttribute('onchange', 'subirImagenGeneral(' + idEquipo + ',"t_equipos_adjuntos")');

    let idTabla = idEquipo;
    let tabla = "t_equipos_adjuntos";

    const action = "obtenerAdjuntos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTabla: idTabla,
            tabla: tabla

        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataImagenes").innerHTML = data.imagen;
            document.getElementById("dataAdjuntos").innerHTML = data.documento;
        }
    });
}



// ---------- PROYECTOS ----------

// Expande las actividades de los proyectos y Cambia el icono
function expandirProyectos(id, idProyecto) {
    document.getElementById(id + "toggle").classList.toggle("hidden");

    if (document.getElementById("icono" + idProyecto).classList[1] == "fa-chevron-down") {
        document.getElementById("icono" + idProyecto).classList.remove("fa-chevron-down");
        document.getElementById("icono" + idProyecto).classList.add("fa-chevron-right");
    } else {
        document.getElementById("icono" + idProyecto).classList.add("fa-chevron-down");
        document.getElementById("icono" + idProyecto).classList.remove("fa-chevron-right");
    }
}


// Obtiene los proyectos de las secciones
function obtenerProyectosP(tipoOrden) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    let palabraProyecto = document.getElementById("palabraProyecto").value;

    // Función para darle estilo a los botones
    claseBotonesProyecto('proyectosPendientes');

    // Agrega el tipo de orden en las columnas.
    document.getElementById("proyectoOrden").setAttribute('onclick', 'obtenerProyectosP("PROYECTO")');
    document.getElementById("proyectoOrdenPDA").setAttribute('onclick', 'obtenerProyectosP("PDA")');
    document.getElementById("proyectoOrdenRESP").setAttribute('onclick', 'obtenerProyectosP("RESP")');
    document.getElementById("proyectoOrdenFECHA").setAttribute('onclick', 'obtenerProyectosP("FECHA")');
    document.getElementById("proyectoOrdenCOT").setAttribute('onclick', 'obtenerProyectosP("COT")');
    document.getElementById("proyectoOrdenTIPO").setAttribute('onclick', 'obtenerProyectosP("TIPO")');
    document.getElementById("proyectoOrdenJUST").setAttribute('onclick', 'obtenerProyectosP("JUST")');
    document.getElementById("proyectoOrdenCOSTE").setAttribute('onclick', 'obtenerProyectosP("COSTE")');

    // Secciones de Botones.
    document.getElementById("seccionProyectos").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("btnProyecto").setAttribute('onclick', 'obtenerProyectosP("PROYECTO")');
    document.getElementById("palabraProyecto").setAttribute('onkeyup', 'obtenerProyectosP("PROYECTO")');
    document.getElementById("modalProyectos").classList.add('open');
    document.getElementById("btnCrearProyecto").setAttribute('onclick', 'agregarProyecto()');
    document.getElementById("btnNuevoProyecto").setAttribute('onclick', 'datosAgregarProyecto()');
    document.getElementById("btnSolucionadosProyectos").setAttribute('onclick', 'obtenerProyectosS("PROYECTO")');
    document.getElementById("btnGanttProyecto").setAttribute('onclick', 'ganttP()');

    // Oculta y Muestra contenido
    document.getElementById("contenidoProyectos").classList.remove('hidden');
    document.getElementById("paginacionProyectos").classList.remove('hidden');
    document.getElementById("contenidoGantt").classList.add('hidden');

    const action = "obtenerProyectosP";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion,
            palabraProyecto: palabraProyecto,
            tipoOrden: tipoOrden
        },
        dataType: "JSON",
        success: function (data) {
            alertaImg('Proyectos Pendientes: ' + data.totalProyectos, '', 'info', 4000);

            document.getElementById("dataProyectos").innerHTML = data.dataProyectos;
            document.getElementById("seccionProyectos").innerHTML = data.seccion;
            estiloSeccionModal('estiloSeccionProyectos', data.seccion);
            paginacionProyectos();

        }
    });
}


// Obtiene los proyectos de las secciones
function obtenerProyectosS(tipoOrden) {
    // Obtiene datos
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    let palabraProyecto = document.getElementById("palabraProyecto").value;

    // Función para Botones
    claseBotonesProyecto('proyectosSolucionados');

    // Agrega el tipo de orden en las columnas.
    document.getElementById("proyectoOrden").setAttribute('onclick', 'obtenerProyectosS("PROYECTO")');
    document.getElementById("proyectoOrdenPDA").setAttribute('onclick', 'obtenerProyectosS("PDA")');
    document.getElementById("proyectoOrdenRESP").setAttribute('onclick', 'obtenerProyectosS("RESP")');
    document.getElementById("proyectoOrdenFECHA").setAttribute('onclick', 'obtenerProyectosS("FECHA")');
    document.getElementById("proyectoOrdenCOT").setAttribute('onclick', 'obtenerProyectosS("COT")');
    document.getElementById("proyectoOrdenTIPO").setAttribute('onclick', 'obtenerProyectosS("TIPO")');
    document.getElementById("proyectoOrdenJUST").setAttribute('onclick', 'obtenerProyectosS("JUST")');
    document.getElementById("proyectoOrdenCOSTE").setAttribute('onclick', 'obtenerProyectosS("COSTE")');


    document.getElementById("seccionProyectos").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("palabraProyecto").setAttribute('onkeyup', 'obtenerProyectosS("PROYECTO")');
    document.getElementById("modalProyectos").classList.add('open');
    document.getElementById("btnCrearProyecto").setAttribute('onclick', 'agregarProyecto()');
    document.getElementById("btnNuevoProyecto").setAttribute('onclick', 'datosAgregarProyecto()');
    document.getElementById("btnPendientesProyectos").setAttribute('onclick', 'obtenerProyectosP("PROYECTO")');

    // Oculta y Muestra contenido
    document.getElementById("contenidoProyectos").classList.remove('hidden');
    document.getElementById("paginacionProyectos").classList.remove('hidden');
    document.getElementById("contenidoGantt").classList.add('hidden');

    const action = "obtenerProyectosS";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion,
            palabraProyecto: palabraProyecto,
            tipoOrden: tipoOrden
        },
        dataType: "JSON",
        success: function (data) {
            alertaImg('Proyectos Finalizados: ' + data.totalProyectos, '', 'info', 4000);
            document.getElementById("dataProyectos").innerHTML = data.dataProyectos;
            document.getElementById("seccionProyectos").innerHTML = data.seccion;
            estiloSeccionModal('estiloSeccionProyectos', data.seccion);
            paginacionProyectos();
        }
    });
}


// Función para Paginar los resultados de los Equipos Obtenidos.
function paginacionProyectos() {
    $("#paginacionProyectos").jPages({
        containerID: 'dataProyectos',
        perPage: 15,
        startPage: 1,
        endRange: 1,
        midRange: 1,
        previous: 'anterior',
        next: 'siguiente',
        animation: false,
    });
    // console.log('Paginación');

    $("#paginacionProyectos>a").addClass('-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150');

}


// Obtener Opciones de Responsables para Proyectos
function datosAgregarProyecto() {
    document.getElementById("responsableProyectoN").innerHTML = '';
    document.getElementById("modalAgregarProyecto").classList.add('open');
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    const action = "obtenerResponsables";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("responsableProyectoN").innerHTML = data.dataUsuarios;
        }
    });
}

// Agregar Proyecto
function agregarProyecto() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSeccion = localStorage.getItem('idSeccion');
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
                coste: coste
            },
            // dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data == 1) {
                    obtenerProyectosP('PROYECTO');
                    alertaImg('Proyecto Agregado', '', 'success', 2500);
                    document.getElementById("tituloProyectoN").value = '';
                    document.getElementById("tipoProyectoN").value = '';
                    document.getElementById("fechaProyectoN").value = '';
                    document.getElementById("responsableProyectoN").value = '';
                    document.getElementById("justificacionProyectoN").value = '';
                    document.getElementById("costeProyectoN").value = '';
                    document.getElementById("modalAgregarProyecto").classList.remove('open');
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 3000);
                }
            }
        });
    } else {
        alertaImg('Información NO Valida', '', 'warning', 3000);
    }
}


//Optienes Usuarios posible para asignar responsable en Proyectos. 
function obtenerResponsablesProyectos(idProyecto) {
    document.getElementById("palabraUsuario").setAttribute('onkeyup', 'obtenerResponsablesProyectos(' + idProyecto + ')');
    document.getElementById("modalUsuarios").classList.add('open');
    let idItem = idProyecto;
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
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
            palabraUsuario: palabraUsuario
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
            alertaImg('Usuarios Obtenidos: ' + data.totalUsuarios, '', 'info', 200);
        }
    });
}


// Función para  Actualizar Información de un proyecto en la tabla t_proyectos
function actualizarProyectos(valor, columna, idProyecto) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
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
            titulo: titulo
        },
        // dataType: "JSON",
        success: function (data) {
            console.log(data);
            if (data == 1) {
                obtenerProyectosP('PROYECTO');
                alertaImg('Responsable Actualizado', '', 'success', 2000);
                document.getElementById("modalUsuarios").classList.remove('open');
            } else if (data == 2) {
                obtenerProyectosP('PROYECTO');
                document.getElementById("modalActualizarProyecto").classList.remove('open');
                alertaImg('Justifiacion Actualizado', '', 'success', 2000);
            } else if (data == 3) {
                obtenerProyectosP('PROYECTO');
                document.getElementById("modalActualizarProyecto").classList.remove('open');
                alertaImg('Coste Actualizado', '', 'success', 2000);
            } else if (data == 4) {
                obtenerProyectosP('PROYECTO');
                document.getElementById("modalActualizarProyecto").classList.remove('open');
                alertaImg('Tipo Actualizado', '', 'success', 2000);
            } else if (data == 5) {
                obtenerProyectosP('PROYECTO');
                document.getElementById("modalFechaProyectos").classList.remove('open');
                alertaImg('Fecha Actualizada', '', 'success', 2000);
            } else if (data == 6) {
                obtenerProyectosP('PROYECTO');
                document.getElementById("modalTituloEliminar").classList.remove('open');
                alertaImg('Proyecto Eliminado', '', 'success', 2000);
            } else if (data == 7) {
                obtenerProyectosP('PROYECTO');
                document.getElementById("modalTituloEliminar").classList.remove('open');
                document.getElementById("modalEditarTitulo").classList.remove('open');
                alertaImg('Título Actualizado', '', 'success', 2000);
            } else if (data == 8) {
                obtenerProyectosP('PROYECTO');
                document.getElementById("modalTituloEliminar").classList.remove('open');
                alertaImg('Proyecto Finalizado', '', 'success', 2000);
            } else if (data == 9) {
                obtenerProyectosP('PROYECTO');
                document.getElementById("modalTituloEliminar").classList.remove('open');
                alertaImg('Proyecto Restaurado', '', 'success', 2000);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 3000);
            }
        }
    });
}


// ACTUALIZA LA JUSTIFICACION DE LOS PROYECTOS
function obtenerDatoProyectos(idProyecto, columna) {
    localStorage.setItem('idProyecto', idProyecto);

    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    document.getElementById("tipoProyectoDiv").classList.add('hidden');
    document.getElementById("justificacionProyectoDiv").classList.add('hidden');
    document.getElementById("costeProyectoDiv").classList.add('hidden');

    if (columna == "justificacion") {
        document.getElementById("modalActualizarProyecto").classList.add('open');
        document.getElementById("tituloActualizarProyecto").innerHTML = "JUSTIFIACIÓN";
        document.getElementById("justificacionProyectoDiv").classList.remove('hidden');
    } else if (columna == "coste") {
        document.getElementById("modalActualizarProyecto").classList.add('open');
        document.getElementById("tituloActualizarProyecto").innerHTML = "COSTE";
        document.getElementById("costeProyectoDiv").classList.remove('hidden');
    } else if (columna == "tipo") {
        document.getElementById("modalActualizarProyecto").classList.add('open');
        document.getElementById("tituloActualizarProyecto").innerHTML = "TIPO";
        document.getElementById("tipoProyectoDiv").classList.remove('hidden');
    } else if (columna == "rango_fecha") {
        document.getElementById("modalFechaProyectos").classList.add('open');
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
            columna: columna
        },
        dataType: "JSON",
        success: function (data) {

            document.getElementById("tipoProyecto").value = data.tipo;
            document.getElementById("justificacionProyecto").value = data.justificacion;
            document.getElementById("costeProyecto").value = data.coste;
            document.getElementById("fechaProyecto").value = data.rangoFecha;

            document.getElementById("btnGuardarInformacion").
                setAttribute('onclick', 'actualizarProyectos(0, "' + columna + '",' + idProyecto + ')');
        }
    });
}


// Obtener Status de proyectos
function statusProyecto(idProyecto) {
    document.getElementById("modalTituloEliminar").classList.add('open');
    let tituloActual = document.getElementById("tituloP" + idProyecto).innerHTML;
    document.getElementById("inputEditarTitulo").value = tituloActual;

    document.getElementById("btnEditarTitulo").
        setAttribute('onclick', 'actualizarProyectos(0, "titulo",' + idProyecto + ')');

    document.getElementById("eliminar").
        setAttribute('onclick', 'actualizarProyectos(0, "eliminar",' + idProyecto + ')');

    document.getElementById("finalizar").
        setAttribute('onclick', 'actualizarProyectos("F", "status",' + idProyecto + ')');
}


// Obtienes las Cotizaciones de PROYECTOS
function cotizacionesProyectos(idProyecto) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idTabla = idProyecto;
    let tabla = "t_proyectos_adjuntos";

    document.getElementById("modalMedia").classList.add('open');
    document.getElementById("inputAdjuntos").
        setAttribute('onchange', 'subirImagenGeneral(' + idProyecto + ', "t_proyectos_adjuntos")');

    const action = "obtenerAdjuntos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTabla: idTabla,
            tabla: tabla
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("dataImagenes").innerHTML = data.imagen;
            document.getElementById("dataAdjuntos").innerHTML = data.documento;
        }
    });
}


// Agrega una Actividad en PROYECTOS.
function agregarPlanaccion(idProyecto) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let actividad = document.getElementById("NA" + idProyecto).value;
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
                // console.log(data);
                if (data.length > 1) {
                    obtenerProyectosP('PROYECTO');
                    alertaImg('Actividad Agregada', '', 'success', 2500);
                    expandir('proyecto' + idProyecto);
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 3000);
                }
            }
        });
    } else {
        alertaImg('Intente de Nuevo', '', 'info', 3000);
    }
}


// Obtener posibles RESPONSABLES para PLANACCION
function obtenerResponsablesPlanaccion(idPlanaccion) {
    document.getElementById("palabraUsuario").setAttribute('onkeyup', 'obtenerResponsablesPlanaccion(' + idPlanaccion + ')');
    document.getElementById("modalUsuarios").classList.add('open');
    let idItem = idPlanaccion;
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
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
            palabraUsuario: palabraUsuario
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
            alertaImg('Usuarios Obtenidos: ' + data.totalUsuarios, '', 'info', 200);
        }
    });
}


// Actualizar PLANACCION
function actualizarPlanaccion(valor, columna, idPlanaccion) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let actividad = document.getElementById("inputEditarTitulo").value;

    const action = "actualizarPlanaccion";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idPlanaccion: idPlanaccion,
            valor: valor,
            columna: columna,
            actividad: actividad
        },
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);

            obtenerProyectosP('PROYECTO');
            if (data == 1) {
                document.getElementById("modalUsuarios").classList.remove('open');
                alertaImg('Responsable Actualizado', '', 'success', 2500);
            } else if (data == 2) {
                document.getElementById("modalEditarTitulo").classList.remove('open');
                document.getElementById("modalStatus").classList.remove('open');
                alertaImg('Actividad Actualizada', '', 'success', 2500);
            } else if (data == 3) {
                document.getElementById("modalStatus").classList.remove('open');
                alertaImg('Actividad Eliminada', '', 'success', 2500);
            } else if (data == 4) {
                document.getElementById("modalStatus").classList.remove('open');
                alertaImg('Actividad Solucionada', '', 'success', 2500);
            } else if (data == 5) {
                document.getElementById("modalStatus").classList.remove('open');
                alertaImg('Status Actualizado', '', 'success', 2500);
            } else if (data == 6) {
                document.getElementById("modalStatus").classList.remove('open');
                alertaImg('Actividad Restaurada', '', 'success', 2500);
            }
        }
    });
}


// Status para Planaccion
function statusPlanaccion(idPlanaccion) {
    let actividadActual = document.getElementById("AP" + idPlanaccion).innerHTML;
    document.getElementById("inputEditarTitulo").value = actividadActual;
    document.getElementById("modalStatus").classList.add('open');

    document.getElementById("btnEditarTitulo").
        setAttribute('onclick', 'actualizarPlanaccion(0,"actividad",' + idPlanaccion + ')');

    document.getElementById("statusActivo").
        setAttribute('onclick', 'actualizarPlanaccion(0,"activo",' + idPlanaccion + ')');

    document.getElementById("statusFinalizar").
        setAttribute('onclick', 'actualizarPlanaccion("F","status",' + idPlanaccion + ')');

    document.getElementById("statusMaterial").
        setAttribute('onclick', 'actualizarPlanaccion(1, "status_material",' + idPlanaccion + ')');

    document.getElementById("statusTrabajare").
        setAttribute('onclick', 'actualizarPlanaccion(1, "status_trabajando",' + idPlanaccion + ')');

    document.getElementById("statusElectricidad").
        setAttribute('onclick', 'actualizarPlanaccion(1, "energetico_electricidad",' + idPlanaccion + ')');

    document.getElementById("statusAgua").
        setAttribute('onclick', 'actualizarPlanaccion(1, "energetico_agua",' + idPlanaccion + ')');

    document.getElementById("statusDiesel").
        setAttribute('onclick', 'actualizarPlanaccion(1, "energetico_diesel",' + idPlanaccion + ')');

    document.getElementById("statusGas").
        setAttribute('onclick', 'actualizarPlanaccion(1, "energetico_gas",' + idPlanaccion + ')');

    document.getElementById("statusRRHH").
        setAttribute('onclick', 'actualizarPlanaccion(1, "departamento_rrhh",' + idPlanaccion + ')');

    document.getElementById("statusCalidad").
        setAttribute('onclick', 'actualizarPlanaccion(1, "departamento_calidad",' + idPlanaccion + ')');

    document.getElementById("statusDireccion").
        setAttribute('onclick', 'actualizarPlanaccion(1, "departamento_direccion",' + idPlanaccion + ')');

    document.getElementById("statusFinanzas").
        setAttribute('onclick', 'actualizarPlanaccion(1, "departamento_finanzas",' + idPlanaccion + ')');

    document.getElementById("statusCompras").
        setAttribute('onclick', 'actualizarPlanaccion(1, "departamento_compras",' + idPlanaccion + ')');
}


// Comentarios para Planaccion
function comentariosPlanaccion(idPlanaccion) {
    document.getElementById("btnComentario").
        setAttribute('onclick', 'agregarComentarioPlanaccion(' + idPlanaccion + ')');
    document.getElementById("modalComentarios").classList.add('open');

    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    const action = "comentariosPlanaccion";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idPlanaccion: idPlanaccion
        },
        // dataType: "JSON",
        success: function (data) {
            document.getElementById("dataComentarios").innerHTML = data;
        }
    });
}


// Muestra los adjuntos de Planaccion
function adjuntosPlanaccion(idPlanaccion) {
    document.getElementById("modalMedia").classList.add('open');
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idTabla = idPlanaccion;
    let tabla = "t_proyectos_planaccion_adjuntos";

    document.getElementById("inputAdjuntos").setAttribute
        ('onchange', 'subirImagenGeneral(' + idPlanaccion + ', "t_proyectos_planaccion_adjuntos")');

    const action = "obtenerAdjuntos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTabla: idTabla,
            tabla: tabla
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("dataImagenes").innerHTML = data.imagen;
            document.getElementById("dataAdjuntos").innerHTML = data.documento;
        }
    });
}


// Agrega Comentario en Planaccion
function agregarComentarioPlanaccion(idPlanaccion) {
    let comentario = document.getElementById("inputComentario").value;
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

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
                comentario: comentario
            },
            // dataType: "JSON",
            success: function (data) {
                if (data == 1) {
                    obtenerProyectosP('PROYECTO');
                    comentariosPlanaccion(idPlanaccion);
                    document.getElementById("inputComentario").value = '';
                    alertaImg('Comentario Agregado', '', 'success', 2500);
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 2500);
                }
            }
        });
    } else {
        alertaImg('Comentario NO Valido', '', 'info', 2500);
    }
}


// Sube imagenes con dos parametros, con el formulario #inputAdjuntos
function subirImagenGeneral(idTabla, tabla) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let img = document.getElementById("inputAdjuntos").files;

    for (let index = 0; index < img.length; index++) {

        let imgData = new FormData();
        const action = "subirImagenGeneral";
        document.getElementById("cargandoAdjunto").
            innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

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
                document.getElementById("cargandoAdjunto").innerHTML = '';
                document.getElementById("inputAdjuntos").value = '';
                if (data == 1) {
                    alertaImg('Proceso Cancelado', '', 'info', 3000);
                } else if (data == 2) {
                    alertaImg('Archivo Pesado (MAX:99MB)', '', 'info', 3000);

                    // Sube y Actualiza la Vista para las Cotizaciones de Proyectos.
                } else if (data == 3) {
                    alertaImg('Cotización Agregada', '', 'success', 2500);
                    obtenerProyectosP('PROYECTO');
                    cotizacionesProyectos(idTabla);

                    // Sube y Actualiza la Vista para los Adjuntos de Planaccion.
                } else if (data == 4) {
                    alertaImg('Adjunto Agregado', '', 'success', 2500);
                    obtenerProyectosP('PROYECTO');
                    adjuntosPlanaccion(idTabla);
                } else if (data == 5) {
                    alertaImg('Adjunto Agregado', '', 'success', 2500);
                    obtenerMediaEquipo(idTabla);
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 3000);
                }
                console.log(data);
            }
        });
    }
}


function ganttP() {
    // Cambia diseño de Botones en Proyectos
    claseBotonesProyecto('ganttPendientes');

    // Oculta y Muestra contenido
    document.getElementById("contenidoProyectos").classList.add('hidden');
    document.getElementById("paginacionProyectos").classList.add('hidden');
    document.getElementById("contenidoGantt").classList.remove('hidden');

    document.getElementById("btnPendientesProyectos").setAttribute('onclick', 'ganttP()');
    document.getElementById("btnSolucionadosProyectos").setAttribute('onclick', 'ganttS()');

    // Data URL
    const action = "ganttProyectosP";
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = 200;
    let dataURL = 'php/graficas_am4charts.php?action=' + action + '&idUsuario=' + idUsuario + '&idDestino=' + idDestino + '&idSeccion=' + idSeccion + '&idSubseccion=' + idSubseccion;


    fetch(dataURL)
        .then(res => res.json())
        .then(dataGantt => {

            const arrayTratado = new Promise((resolve, recject) => {
                for (var i = 0; i < dataGantt.length; i++) {
                    var colorSet = new am4core.ColorSet();
                    dataGantt[i]['color'] = colorSet.getIndex(i);
                }
                resolve(dataGantt);
            });

            arrayTratado.then((response) => {
                generarGantt(response);
            }).catch((error) => {
                console.log('Error' + error);
            });

            alertaImg('Gantt Solucionados: ' + dataGantt.length, '', 'info', 4000);
            let size = dataGantt.length * 50;
            document.getElementById("contenidoGantt").childNodes[1].setAttribute('style', 'height:' + size + 'px');
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
        series1.columns.template.tooltipText = "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

        series1.dataFields.openDateX = "start";
        series1.dataFields.dateX = "end";
        series1.dataFields.categoryY = "category";
        series1.columns.template.propertyFields.fill = "color"; // get color from data
        series1.columns.template.propertyFields.stroke = "color";
        series1.columns.template.strokeOpacity = 1;

        chart.scrollbarX = new am4core.Scrollbar();
    }
}

function ganttS() {
    // Cambia estilo de Botones en Proyectos
    claseBotonesProyecto('ganttSolucionados');

    // Oculta y Muestra contenido
    document.getElementById("contenidoProyectos").classList.add('hidden');
    document.getElementById("paginacionProyectos").classList.add('hidden');
    document.getElementById("contenidoGantt").classList.remove('hidden');

    document.getElementById("btnGanttProyecto").setAttribute('onclick', 'ganttS()');

    // Data URL
    const action = "ganttProyectosS";
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = 200;
    let dataURL = 'php/graficas_am4charts.php?action=' + action + '&idUsuario=' + idUsuario + '&idDestino=' + idDestino + '&idSeccion=' + idSeccion + '&idSubseccion=' + idSubseccion;


    fetch(dataURL)
        .then(res => res.json())
        .then(dataGantt => {

            const arrayTratado = new Promise((resolve, recject) => {
                for (var i = 0; i < dataGantt.length; i++) {
                    var colorSet = new am4core.ColorSet();
                    dataGantt[i]['color'] = colorSet.getIndex(i);
                }
                resolve(dataGantt);
            });

            arrayTratado.then((response) => {
                generarGantt(response);
            }).catch((error) => {
                console.log('Error' + error);
            });

            alertaImg('Gantt Solucionados: ' + dataGantt.length, '', 'info', 4000);
            let size = dataGantt.length * 50;
            document.getElementById("contenidoGantt").childNodes[1].setAttribute('style', 'height:' + size + 'px');
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
        series1.columns.template.tooltipText = "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

        series1.dataFields.openDateX = "start";
        series1.dataFields.dateX = "end";
        series1.dataFields.categoryY = "category";
        series1.columns.template.propertyFields.fill = "color"; // get color from data
        series1.columns.template.propertyFields.stroke = "color";
        series1.columns.template.strokeOpacity = 1;

        chart.scrollbarX = new am4core.Scrollbar();
    }
}














// Mantener de Ultimo.

//Funcion para los Botones de Proyectos (Gantt Proyectos)
function claseBotonesProyecto(tipoSeleccion) {
    document.getElementById("btnProyecto").classList.remove('bg-blue-300');
    document.getElementById("btnGanttProyecto").classList.remove('bg-blue-300');
    document.getElementById("btnSolucionadosProyectos").classList.remove('bg-green-300');
    document.getElementById("btnPendientesProyectos").classList.remove('bg-red-300');

    if (tipoSeleccion == "proyectosPendientes") {
        document.getElementById("btnProyecto").classList.add('bg-blue-300');
        document.getElementById("btnPendientesProyectos").classList.add('bg-red-300');
    } else if (tipoSeleccion == "proyectosSolucionados") {
        document.getElementById("btnProyecto").classList.add('bg-blue-300');
        document.getElementById("btnSolucionadosProyectos").classList.add('bg-green-300');
    } else if (tipoSeleccion == "ganttPendientes") {
        document.getElementById("btnGanttProyecto").classList.add('bg-blue-300');
        document.getElementById("btnPendientesProyectos").classList.add('bg-red-300');
    } else if (tipoSeleccion == "ganttSolucionados") {
        document.getElementById("btnGanttProyecto").classList.add('bg-blue-300');
        document.getElementById("btnSolucionadosProyectos").classList.add('bg-green-300');
    }
}

// Funcion toggle por CLASENAME 
function classNameToggle(nameClass) {
    var x = document.getElementsByClassName(nameClass);
    var i;
    for (i = 0; i < x.length; i++) {
        document.getElementsByClassName(nameClass)[i].classList.toggle('hidden');
        // console.log(nameClass, i);
    }
}


// Funciones para actualizar idSeccion y idSubseccion en localstorage..
function actualizarSeccionSubseccion(idSeccion, idSubseccion) {
    localStorage.setItem('idSeccion', idSeccion);
    localStorage.setItem('idSubseccion', idSubseccion);
}


// Funciones para actualizar idSeccion en localstorage.
function actualizarSeccion(idSeccion) {
    localStorage.SetItem('idSeccion', idSeccion);
}


// Funciones para actualizar idSeccion en localstorage.
function actualizarSubseccion(idSubseccion) {
    localStorage.SetItem('idSubseccion', idSubseccion);
}


function llamarFuncionX(nombreFuncion) {
    // Obtiene Datos Generales de la SESSION(LOCALSTORAGE.GETITEM)
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    // console.log(idUsuario, idDestino, idSeccion, idSubseccion);

    switch (nombreFuncion) {
        case (nombreFuncion = 'consultaSubsecciones'):
            consultaSubsecciones(idDestino, idUsuario);
            break;

        case (nombreFuncion = 'obtenerEquipos'):
            obtenerEquipos(idUsuario, idDestino, idSeccion, idSubseccion, 0, 49, 'MCN');
            break;
    }
}


// Función para comprobar session.
comprobarSession();