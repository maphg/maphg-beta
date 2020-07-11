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


// función expandir.
function expandir(id) {
    idtoggle = id + 'toggle';
    var toggle = document.getElementById(idtoggle);
    toggle.classList.toggle("hidden");
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
    // let idDestino = localStorage.getItem('idDestino');
    console.log('2394:' + localStorage.getItem('idDestino'));
    let h = new Date();
    let hora = h.getHours() + ':' + h.getMinutes();
    let nombreDestinoArray = arrayDestino[idDestino];
    console.log(nombreDestinoArray);
    document.getElementById("hora").innerHTML = hora;
    document.getElementById("nombreDestino").innerHTML = nombreDestinoArray;
}
// Desde aquí se habla a la función hora(), cada 1min.
setInterval('hora()', 70000);

// toggleClass Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
    $("#" + idModal).toggleClass('open');
}

// Obtiene las subsecciones para la pagina principal de Planner, mediante el idDestino.
function consultaSubsecciones(idDestino, idUsuario, idDestino) {

    const action = "consultaSubsecciones";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario,
            idDestino: idDestino
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            // console.log(data.dataZIL);
            // console.log(data.dataZIE);
            // console.log(data.dataAUTO);
            // console.log(data.dataDEC);
            // console.log(data.dataDEP);
            // console.log(data.dataOMA);
            // console.log(data.dataZHA);
            // console.log(data.dataZHC);
            // console.log(data.dataZHH);
            // console.log(data.dataZHP);
            // console.log(data.dataZIA);
            // console.log(data.dataZIC);
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
function pendientesSubsecciones(idSeccion, tipoPendiente, nombreSeccion) {
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
        // dataType: "JSON",
        success: function (data) {
            $("#dataSubseccionesPendientes").html(data);
            console.log(data);
        }
    });
}

function comprobarSession() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let destinoSeleccionado = localStorage.getItem('idDestino');

    // Comprueba que exista la session.
    if (idUsuario != '' && idDestino != '') {
        llamarFuncionX('consultaSubsecciones');
    } else {
        location.replace("login.php");
    }
}

function llamarFuncionX(nombreFuncion) {
    // Obtiene Datos Generales de la SESSION(LOCALSTORAGE.GETITEM)
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let destinoSeleccionado = localStorage.getItem('idDestino');
    switch (nombreFuncion) {
        case nombreFuncion = 'consultaSubsecciones':
            consultaSubsecciones(idUsuario, idDestino, destinoSeleccionado);
            break;

        default:
            break;
    }
}

// Función para comprobar session.
comprobarSession();