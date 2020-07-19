// Funciones para la nueva version de Planer.

// nombre de la función de alertas tipo notificaciones: alertInformacion(msj, icono) -> Iconos: i-success, i-error, i-warning, i-info, i-question.

// Alertas tipo msj: alertaMSJ(title, msj, icon)  -> Iconos: success, error, warning, info, question.

// Función para agregar el titulo de los MP No Planeados, a partir de ello se crea el registro para guardar la información.
function modalInicialMPNP() {
    $("#btnGuardarMPNP").prop("disabled", true);
    $("#tituloMPNP").val('');
    $("#formMPNP").addClass('hidden');
    $("#dataResponsablesMPNP").html('');
    $("#dataActividadesMPNP").html('');
    refreshModalMPNP();
}


function obtMPNP(idEquipo, equipo) {
    $("#btnGuardarMPNP").html('Guardar MP');
    $("#idEquipoMPNP").val(idEquipo);
    var action = "consultaMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idEquipo: idEquipo
        },
        success: function (data) {
            $("#dataMPNP").html(data);
            $("#equipoMPNP").html(equipo);
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
            success: function (idMPNP) {
                $("#idMPNP").val(idMPNP);
                // console.log(idMPNP);
                alertaMSJ('MP NO PLANEADO', 'Debe contener al menos una Actividad, para ser Valido.', 'info');
            },
        });
    } else {
        alertInformacion('Título No Valido.', 'error');
    }
}


function consultaResponsableMPNP(idMPNP) {
    var action = "consultaResponsableMPNP";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMPNP: idMPNP
        },
        success: function (data) {
            $("#responsableMPNP").val(0);
            $("#dataResponsablesMPNP").html(data);
        },
    });
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
            dataType: 'json',
            success: function (data) {
                console.log(data);
                $("#responsableMPNP").val(0);
                alertInformacion(data.msj, data.icon);
                $("#dataResponsablesMPNP").html(data);
                consultaResponsableMPNP(idMPNP);
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
        success: function (data) {
            // console.log(data);
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
            success: function (data) {
                $("#actividadMPNP").val('');
                // console.log(data);
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
        success: function (data) {
            alertInformacion('Actividad Eliminada', 'success');
            consultaActividadMPNP(idMPNP);
            refreshModalMPNP();
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
        success: function (data) {
            // console.log(data);
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
            success: function (data) {
                alertInformacion('MP NO PLANEADO, Finalizado.', 'success');
                $("#btnGuardarMPNP").prop("disabled", true);
                $("#tituloMPNP").val('');
                $("#formMPNP").addClass('hidden');
                $("#dataResponsablesMPNP").html('');
                $("#dataActividadesMPNP").html('');
                refreshModalMPNP();
                $("#modal-agregar-MPNP").removeClass('is-active');

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
    $("#" + divOcultar).html("");
    $("#colComentariosEquipo").html("");
    var action = "comentariosMPNP";
    // console.log(idMPNP);
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMPNP: idMPNP
        },
        // dataType: 'json',
        success: function (data) {
            // console.log(data);
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
            success: function (data) {
                alertInformacion('Comentario Agregado', 'success');
                comentariosMPNP(idMPNP, '');
                refreshModalMPNP();
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
        success: function (data) {
            alertInformacion('Comentario Eliminado.', 'success');
            comentariosMPNP(idMPNP, '');
            refreshModalMPNP();
        }
    });
}


function adjuntosMPNP(idMPNP) {
    $("#colFotosEquipo").html('');
    $("#colFotosMPMC").html('');
    var action = "adjuntosMPNP";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMPNP: idMPNP
        },
        // dataType: "dataType",
        success: function (data) {
            refreshModalMPNP();
            $("#colFotosEquipo").html(data);
        }
    });
}


function cargarAdjuntoMPNP(idMPNP) {
    $("#colFotosMPMC").html('');
    var inputFileImage = document.getElementById("inputAdjuntoMPNP");
    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idMPNP", idMPNP);

    var url = "php/planner_uploadfiles_mpnp.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                // console.log(data);
                alertInformacion('Adjunto Cargado.', 'success');

            } else {
                alertInformacion(data, 'info');
            }
            adjuntosMPNP(idMPNP);
            refreshModalMPNP();
        },
    });
}


function eliminarAdjuntoMPNP(idImg, idMPNP) {
    var action = "eliminarAdjuntoMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idImg: idImg
        },
        // dataType: "dataType",
        success: function (data) {
            refreshModalMPNP();
            adjuntosMPNP(idMPNP);
            alertInformacion(data, 'success');
        }
    });
}


function detalleMPNP(idMPNP) {
    $("#idMPNP").val(idMPNP);
    showModal('modal-agregar-MPNP');
    $('#formMPNP').removeClass('hidden');
    consultaActividadMPNP(idMPNP);
    consultaResponsableMPNP(idMPNP)
    $("#btnGuardarMPNP").html('Actualizar');

    var action = "consultaTituloMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMPNP: idMPNP
        },
        // dataType: "dataType",
        success: function (data) {
            $("#tituloMPNP").val(data);
        }
    });
}

// Función para el modal de pendientes.

function pendientesSubseccion(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino) {
    console.log(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino);
    if (tipoPendiente != "") {
        // idSeccion = 1 & idDestino = 1 & tipoPendiente = MCS & idUsuario = 1#
        page = 'modalPendientes.php?idSeccion=' + idSeccion + '&tipoPendiente=' + tipoPendiente + '&idUsuario=' +
            idUsuario + '&idDestino=' + idDestino;
        window.open(page, "Pendientes",
            "directories=no, toolbar=no,location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1200px, height=800px"
        );
    }
}

// Exportación de Pendientes.
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
            // $("#dataExportarSeccionesUsuarios").html(data);
            console.log(data);
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
                page = 'php/generarPendientesPDF.php?listaIdMC=' + data + '&idDestino=' + idDestino + '&idUsuario=' + idUsuario;
                window.open(page, "Reporte Pendientes PDF", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800");
            } else if (tipoExportar == "exportarSeccionUsuarioPDF") {
                page = 'php/generarPendientesPDF.php?listaIdMC=' + data + '&idDestino=' + idDestino + '&idUsuario=' + idUsuario;
                window.open(page, "Reporte Pendientes PDF", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800");
            }
        }
    });
}