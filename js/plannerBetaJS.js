// Recupera Datos Generales de la SESSION(LOCALSTORAGE.GETITEM)
var idUsuario = localStorage.getItem('usuario');
var idDestino = localStorage.getItem('idDestino');
var destinoSeleccionado = localStorage.getItem('idDestino');


if (idDestino <= 0 && idUsuario <= 0 && destinoSeleccionado <= 0) {
    location.replace("login.php");
} else {
    localStorage.setItem('idDestino', '3');
}

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
    console.log('2394:' + localStorage.getItem('idDestino'))
    let h = new Date();
    let hora = h.getHours() + ':' + h.getMinutes();
    let nombreDestinoArray = arrayDestino[idDestino];
    console.log('2399' + nombreDestinoArray);
    document.getElementById("hora").innerHTML = hora;
    document.getElementById("nombreDestino").innerHTML = nombreDestinoArray;
}
setInterval('hora()', 60100);

// Cierra o Abre Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
    $("#" + idModal).toggleClass('open');
}

// Obtiene las subsecciones para la pagina principal de Planner, mediante el idDestino.
function consultaSubsecciones(idDestino, idUsuario, idDestino) {
    console.log(idDestino, idUsuario);
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
            // console.log(data);
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
        }
    });
}

// Obtiene los pendientes de las secciones mediante la seccion seleccionada y el destinol.
function pendientesSubsecciones(idSeccion, tipoPendiente, nombreSeccion) {
    $("#modalTituloSeccion").html(nombreSeccion);
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
            $("#dataSubseccionesPendientes").html(data.result);
            console.log(data);

        }
    });
}


consultaSubsecciones(idUsuario, idDestino, idDestino);
