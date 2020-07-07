// Recupera Datos Generales de la SESSION(LOCALSTORAGE.GETITEM)
let idDestino = localStorage.getItem('idDestino');
let idUsuario = localStorage.getItem('idUsuario');
let idDestinoSeleccionado = $("#idDestinoSeleccionado").val();

function consultaSubsecciones(idDestino) {
    const action = "consultaSubsecciones";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario,
            idDestinoSeleccionado: idDestinoSeleccionado
        },
        dataType: "json",
        success: function (data) {
            console.log(data);
            $("#columnasSecciones").html(data.dataZIC);
        }
    });
}

consultaSubsecciones(1);