// Funciones para la nueva version de Planer.

// nombre de la función de alertas tipo notificaciones: alertInformacion(msj, icono) -> Iconos: i-success, i-error, i-warning, i-info, i-question.

// Alertas tipo msj: alertaMSJ(title, msj, icon)  -> Iconos: success, error, warning, info, question.

// Función para agregar el titulo de los MP No Planeados, a partir de ello se crea el registro para guardar la información.
function obtMPNP(idEquipo) {
    $("#idEquipoMPNP").val(idEquipo);
    var action = "consultaMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idEquipo: idEquipo
        },
        success: function(data) {
            $("#dataMPNP").html(data);
        },
    });
}


function tituloMPNP() {
    var idEquipo = $("#idEquipoMPNP").val();
    var titulo = $("#tituloMPNP").val();
    if (titulo.length >= 5) {

        $("#formMPNP").removeClass('hidden');

        var action = "agregarTitoloMPNP";

        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                titulo: titulo,
                idEquipo: idEquipo
            },
            success: function(idMPNP) {
                $("#idMPNP").val(idMPNP);
                console.log(idMPNP);
                alertaMSJ('MP NO PLANEADO', 'Debe contener al menos una Actividad, para ser Valido.', 'info');
            },
        });
    } else {
        alertInformacion('Título No Valido.', 'error');
    }
}


function agregarResponsableMPNP() {
    var action = "agregarResponsableMPNP";
    var idResponsable = $("#responsableMPNP").val();
    var idMPNP = $("#idMPNP").val();

    if (idResponsable >= 1) {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idResponsable: idResponsable,
                idMPNP: idMPNP
            },
            success: function(data) {
                console.log(data);
                $("#responsableMPNP").val(0);
                alertInformacion('Responsable Agregado.', 'success');
                $("#dataResponsablesMPNP").html(data);
            },
        });
    }
}

function eliminarResponsableMPNP(key, value, idMPNP) {
    var action = "eliminarResponsableMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            key: key,
            value: value,
            idMPNP: idMPNP
        },
        success: function(data) {
            console.log(data);
            alertInformacion('Responsable Eliminado.', 'success');
            $("#dataResponsablesMPNP").html(data);
        },
    });
}


function agregarActividadMPNP() {
    var action = "agregarActividadMPNP";
    var idMPNP = $("#idMPNP").val();
    var actividadMPNP = $("#actividadMPNP").val();

    if (actividadMPNP.length >= 5) {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idMPNP: idMPNP,
                actividadMPNP: actividadMPNP
            },
            dataType: 'json',
            success: function(data) {
                $("#actividadMPNP").val('');
                console.log(data);
                alertInformacion(data.msj, data.icon);
                consultaActividadMPNP(idMPNP);
            },
        });
    } else {
        alertInformacion('Actividad No Valida', 'error');
    }
}

// El ID que recibe la función, es el id de la actividad a eliminar y el IDMPNP, es el MP NO Planeado.
function eliminarActividadMPNP(id) {
    var idMPNP = $("#idMPNP").val();
    var action = "eliminarActividadMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            id: id
        },
        // dataType: 'json',
        success: function(data) {
            console.log(data);
            alertInformacion('Actividad Eliminada', 'success');
            consultaActividadMPNP(idMPNP);
        },
    });
}


function consultaActividadMPNP(idMPNP) {
    var action = "consultaActividadMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMPNP: idMPNP
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);
            if (data.total >= 1) {
                $("#btnGuardarMPNP").prop("disabled", false);
            } else {
                $("#btnGuardarMPNP").prop("disabled", true);
            }
            $("#dataActividadesMPNP").html(data.result);
        },
    });
}



// Función para Activar el MP No Planeado.
function btnConfirmarMPNP() {
    var fecha = $("#dateMPNP").val();
    var idEquipo = $("#idEquipoMPNP").val();
    var titulo = $("#tituloMPNP").val();
    var idMPNP = $("#idMPNP").val();
    var action = "btnConfirmarMPNP";
    if (fecha != "" && idEquipo != "" && titulo.length >= 5 && idMPNP > 0) {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idMPNP: idMPNP,
                idEquipo: idEquipo,
                titulo: titulo,
                fecha: fecha
            },
            // dataType: 'json',
            success: function(data) {
                console.log(data);
                alertInformacion('MP NO PLANEADO, Finalizado.', 'success');
                $("#btnGuardarMPNP").prop("disabled", true);
                $("#tituloMPNP").val('');
                $("#formMPNP").addClass('hidden');
                $("#dataResponsablesMPNP").html('');
                $("#dataActividadesMPNP").html('');
                refreshModalMPNP();

            },
        });
    } else {
        alertInformacion('Información NO Valida.', 'error');
    }
}


function refreshModalMPNP() {
    var idEquipo = $("#idEquipoMPNP").val();
    obtMPNP(idEquipo);
}


function comentariosMPNP(idMPNP, divOcultar) {
    $("#" + divOcultar).addClass("modal");
    $("#" + divOcultar).html("");
    $("#colComentariosEquipo").html("");
    var action = "comentariosMPNP";
    console.log(idMPNP);
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMPNP: idMPNP
        },
        // dataType: 'json',
        success: function(data) {
            console.log(data);
            $("#colComentariosEquipo").html(data);
        },
    });
}


function agregarComentarioMPNP(idMPNP) {
    var action = "agregarComentarioMPNP";
    var comentario = $("#inputComentarioMPNP").val();

    if (comentario != "") {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idMPNP: idMPNP,
                comentario: comentario
            },
            // dataType: "dataType",
            success: function(data) {
                alertInformacion('Comentario Agregado', 'success');
                comentariosMPNP(idMPNP, '');
                refreshModalMPNP();
                Console.log(data);
            }
        });
    } else {
        alertInformacion('Comentario NO Valido.', 'info');
    }
}


function eliminarComentarioMPNP(idComentario, idMPNP) {
    var action = "eliminarComentarioMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idComentario: idComentario
        },
        // dataType: "dataType",
        success: function(data) {
            alertInformacion('Comentario Eliminado.', 'success');
            comentariosMPNP(idMPNP, '');
            refreshModalMPNP();
        }
    });
}