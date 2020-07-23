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

    document.getElementById('hora').innerHTML = horas + ':' + minutos;
    document.getElementById('mes').innerHTML = mes;
    document.getElementById('dia').innerHTML = dia;



    switch (hoydia) {
        case 'lunes':
            document.getElementById('btn-zia').classList.toggle('btn-activo');
            document.getElementById('btn-zhp').classList.toggle('btn-activo');
            document.getElementById('btn-dep').classList.toggle('btn-activo');
            document.getElementById('label-lunes').classList.add('text-gray-700');
            document.getElementById('colzia').classList.toggle('hidden');
            document.getElementById('colzhp').classList.toggle('hidden');
            document.getElementById('coldep').classList.toggle('hidden');
            break;
        case 'martes':
            document.getElementById('btn-dep').classList.toggle('btn-activo');
            document.getElementById('btn-zic').classList.toggle('btn-activo');
            document.getElementById('label-martes').classList.add('text-gray-700');
            document.getElementById('colzic').classList.toggle('hidden');
            document.getElementById('coldep').classList.toggle('hidden');
            break;
        case 'miercoles':
            document.getElementById('btn-dec').classList.toggle('btn-activo');
            document.getElementById('btn-dep').classList.toggle('btn-activo');
            document.getElementById('btn-zie').classList.toggle('btn-activo');
            document.getElementById('label-miercoles').classList.add('text-gray-700');
            document.getElementById('coldec').classList.toggle('hidden')
            document.getElementById('coldep').classList.toggle('hidden');
            document.getElementById('colzie').classList.toggle('hidden');
            break;
        case 'jueves':
            document.getElementById('btn-zhc').classList.toggle('btn-activo');
            document.getElementById('btn-zha').classList.toggle('btn-activo');
            document.getElementById('btn-dep').classList.toggle('btn-activo');
            document.getElementById('label-jueves').classList.add('text-gray-700');
            document.getElementById('colzhc').classList.toggle('hidden');
            document.getElementById('colzha').classList.toggle('hidden');
            document.getElementById('coldep').classList.toggle('hidden');
            break;
        case 'viernes':
            document.getElementById('btn-zil').classList.toggle('btn-activo');
            document.getElementById('btn-auto').classList.toggle('btn-activo');
            document.getElementById('btn-dep').classList.toggle('btn-activo');
            document.getElementById('label-viernes').classList.add('text-gray-700');
            document.getElementById('colzil').classList.toggle('hidden');
            document.getElementById('colauto').classList.toggle('hidden');
            document.getElementById('coldep').classList.toggle('hidden');
            break;
        default:
            document.getElementById('btn-zil').classList.toggle('btn-activo');
            document.getElementById('btn-auto').classList.toggle('btn-activo');
            document.getElementById('btn-dep').classList.toggle('btn-activo');
            document.getElementById('btn-zia').classList.toggle('btn-activo');
            document.getElementById('btn-zhp').classList.toggle('btn-activo');
            document.getElementById('btn-zic').classList.toggle('btn-activo');
            document.getElementById('btn-dec').classList.toggle('btn-activo');
            document.getElementById('btn-zie').classList.toggle('btn-activo');
            document.getElementById('btn-zhc').classList.toggle('btn-activo');
            document.getElementById('btn-zha').classList.toggle('btn-activo');
            document.getElementById('colzia').classList.toggle('hidden');
            document.getElementById('colzhp').classList.toggle('hidden');
            document.getElementById('coldep').classList.toggle('hidden');
            document.getElementById('colzic').classList.toggle('hidden');
            document.getElementById('coldec').classList.toggle('hidden');
            document.getElementById('colzie').classList.toggle('hidden');
            document.getElementById('colzhc').classList.toggle('hidden');
            document.getElementById('colzha').classList.toggle('hidden');
            document.getElementById('colzil').classList.toggle('hidden');
            document.getElementById('colauto').classList.toggle('hidden');
            break;
    }
}

function expandir(id) {
    idtoggle = id + 'toggle';
    var toggle = document.getElementById(idtoggle);
    toggle.classList.toggle("hidden");

    var titulox = document.getElementById(idtitulo);
    titulox.classList.remove("truncate");
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
    let hora = h.getHours() + ':' + h.getMinutes();
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
        dataType: "json",
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
            ordenarSubsecciones(data.listaZIL, 'ordenarPadreZIL', 'ordenarHijosZIL');
            // ordenarSubsecciones(data.listaZIE, 'ordenarPadreZIE', 'ordenarHijosZIE');

            // let listaZIE = data.listaZIE.split(',');
            // let listaZIEIndex = data.listaZIEIndex.split(',');
            // console.log(listaZIE);
            // console.log(listaZIEIndex);
            // console.log(listaZIE.sort());
            // var obj = JSON.parse(data.datalistaZIE);
            // console.log(obj);
            // let listaZIE = data.listaZIE.split(',');
            // listaZIE.pop();
        }
    });
}


// Función para Ordenar Columnas.
function ordenarSubsecciones(listaData, ordenarPadre, ordenarHijos) {
    let orden = listaData.split(',');
    // console.log(listaData);
    var subsecciones = document.getElementById(ordenarPadre);

    Sortable.create(
        subsecciones, {
        animation: 150,
        group: ordenarHijos,
        dataIdAttr: "data-identificador",
        store: {
            get: (sortable) => {
                orden.pop();
                orden.sort();
                orden.reverse();
                return orden ? orden : [];
            }
        },
    });
}


// Obtiene los pendientes de las secciones mediante la seccion seleccionada y el destinol.
function pendientesSubsecciones(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino) {
    $("#estiloSeccion").html('<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>');
    $("#modalTituloSeccion").html(nombreSeccion);
    $("#dataSubseccionesPendientes").html('Sin Datos');
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

            // Resultado de Consulta.
            $("#estiloSeccion").html(data.estiloSeccion);

            // Función para darle diseño del Logo según la Sección.
            estiloSeccion(data.estiloSeccion);

            $("#dataSubseccionesPendientes").html(data.resultData);
            $("#dataOpcionesSubseccionestoggle").html(data.dataOpcionesSubsecciones);

            // Pestañas para Mostrar Pendientes.
            $('#misPendientesUsuario').attr('onclick', 'pendientesSubsecciones(' + data.misPendientesUsuario + ')');
            $('#misPendientesSinUsuario').attr('onclick', 'pendientesSubsecciones(' + data.misPendientesSinUsuario + ')');
            $('#misPendientesSeccion').attr('onclick', 'pendientesSubsecciones(' + data.misPendientesSeccion + ')');

            // Pestañas para Exportar.
            exportarListarUsuarios(idUsuario, idDestino, idSeccion);
            $('#exportarSeccion').attr('onclick', 'exportarPendientes(' + data.exportarSeccion + ')');
            $('#exportarMisPendientes').attr('onclick', 'exportarPendientes(' + data.exportarMisPendientes + ')');
            $('#exportarMisPendientesPDF').attr('onclick', 'exportarPendientes(' + data.exportarMisPendientesPDF + ')');
            $("#dataModalOpciones").html(data.exportarSubseccion);

            console.log(data);
        }
    });
}


// El estilo se aplica DIV>H1(class="zie-logo").
function estiloSeccion(seccion) {
    let seccionClase = seccion.toLowerCase() + '-logo';
    console.log(seccionClase);

    $("#estiloSeccion").removeClass('zil-logo zie-logo auto-logo dec-logo dep-logo oma-logo zha-logo zhc-logo zhh-logo zhp-logo zia-logo zic-logo');
    $("#estiloSeccion").addClass(seccionClase);
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
            $("#dataExportarSeccionesUsuarios").html(data);
        }
    });
}


// Funcion para Ver y Exportar los pendientes de las secciones.
function exportarPendientes(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar) {
    console.log(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar);
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
        // dataType: "JSON",
        success: function (data) {
            let usuarioSession = localStorage.getItem('usuario');

            if (tipoExportar == "exportarMisPendientes") {
                page = 'php/generarPendientesExcel.php?listaIdMC=' + data;
                window.location = page;
            } else if (tipoExportar == "exportarSeccion") {
                page = 'php/generarPendientesExcel.php?listaIdMC=' + data;
                window.location = page;
            } else if (tipoExportar == "exportarSubseccion") {
                page = 'php/generarPendientesExcel.php?listaIdMC=' + data;
                window.location = page;
            } else if (tipoExportar == "exportarSeccionUsuario") {
                page = 'php/generarPendientesExcel.php?listaIdMC=' + data;
                window.location = page;
            } else if (tipoExportar == "exportarMisPendientesPDF") {
                page = 'php/generarPendientesPDF.php?listaIdMC=' + data + '&idDestino=' + idDestino +
                    '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                    usuarioSession;
                window.open(page, "Reporte Pendientes PDF",
                    "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                );
            } else if (tipoExportar == "exportarSeccionUsuarioPDF") {
                page = 'php/generarPendientesPDF.php?listaIdMC=' + data + '&idDestino=' + idDestino +
                    '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                    usuarioSession;
                window.open(page, "Reporte Pendientes PDF",
                    "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                );
            }
        }
    });
}

// Obtiene los equipos de las subsecciones y por destino, considerando AME, como Global.
function obtenerEquipos(idUsuario, idDestino, idSeccion, idSubseccion, rangoInicial, rangoFinal, tipoOrdenamiento) {
    console.log(idUsuario, idDestino, idSeccion, idSubseccion, rangoInicial, rangoFinal, tipoOrdenamiento);

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
        // dataType: "JSON",
        success: function (data) {
            console.log(data);
            // console.log(data.dataEquipos);


            document.getElementById("dataEquipos").innerHTML = data.dataEquipos;
            document.getElementById("seccionEquipos").innerHTML = data.seccionEquipos;
            document.getElementById("paginacionEquipos").innerHTML = data.paginacionEquipos;

            // alerta para mostrar información de los Equipos obtenidos.
            alertaImg(data.totalEquipos, '', 'success', 3000);
        }
    });
}

// Obtiene todos los MC-N por Equipo.
function obtenerMCN(idEquipo) {
    // Actualiza el MC seleccionado.
    localStorage.setItem('idEquipo', idEquipo);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    document.getElementById("modalMCN").classList.add('open');
    document.getElementById("seccionMCN").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
    document.getElementById("dataMCN").innerHTML = '';

    const action = "obtenerMCN";

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
            console.log(data);
            document.getElementById("seccionMCN").innerHTML = data.seccion;
            document.getElementById("nombreEquipoMCN").innerHTML = data.nombreEquipo;
            document.getElementById("dataMCN").innerHTML = data.MC;
            alertaImg('Pendientes: ' + data.contadorMC, '', 'info', 3000);
        }
    });
}


// Obtiene todos los MC-F por Equipo.
function obtenerMCF(idEquipo) {
    console.log(idEquipo);
    document.getElementById("modalMCF").classList.add('open');
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
        dataType: "JSON",
        success: function (data) {
            $("#dataExportarSeccionesUsuarios").html(data);
        }
    });
}


function obtenerUsuarios() {
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
            palabraUsuario: palabraUsuario
        },
        dataType: "JSON",
        success: function (data) {
            alertaImg('Usuarios Obtenidos: ' + data.totalUsuarios, '', 'info', 2000);
            document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
        }
    });

}


// Funcion para Obtener Adjuntos.
function obtenerAdjuntos(idMC) {
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
            console.log(data);
            document.getElementById("dataImagenes").classList.remove('justify-center');
            document.getElementById("dataImagenes").innerHTML = data.dataImagenes;

            document.getElementById("dataAdjuntos").classList.remove('justify-center');
            document.getElementById("dataAdjuntos").innerHTML = data.dataAdjuntos;

        }
    });
}


// Funcion para Obtener Comentarios.
function obtenerComentarios(idMC) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    document.getElementById("modalComentarios").classList.add('open');
    document.getElementById("dataComentarios").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

    const action = "obtenerComentarios";
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
            document.getElementById("dataComentarios").innerHTML = data.dataComentarios;
        }
    });
}


// Función para Status.
function statusMC() {
    document.getElementById("modalStatus").classList.add('open');
}


// Funciones para actualizar idSeccion y idSubseccion.
function actualizarSeccionSubseccion(idSeccion, idSubseccion) {
    localStorage.setItem('idSeccion', idSeccion);
    localStorage.setItem('idSubseccion', idSubseccion);
}

// Funciones para actualizar idSeccion y idSubseccion.
function actualizarSeccion(idSeccion) {
    localStorage.SetItem('idSeccion', idSeccion);
}

// Funciones para actualizar idSeccion y idSubseccion.
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
            console.log(idUsuario, idDestino, idSeccion, idSubseccion, 0, 49, 'MCN');
            break;
    }
}



// Función para comprobar session.
comprobarSession();