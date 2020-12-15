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
                // console.log(data);
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
    document.getElementById("modal-equipo-pictures").classList.add('is-active');
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


function cargarAdjuntoMPNP(idMPNP,) {
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
    localStorage.setItem("idSeccion", idSeccion);
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
            // console.log(data);
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


function toggleModal(id) {
    document.getElementById("actividad" + id).classList.toggle('modal');
}


function obtTareasP(idEquipo, equipo) {
    document.getElementById("statusSolucionarATP").classList.remove("is-hidden");
    document.getElementById("statusRestaurarATP").classList.add("is-hidden");
    document.getElementById("modal-tareas-p").classList.add('is-active');
    let status = "P";
    document.getElementById("btnTareas").
        setAttribute('onclick', 'obtTareasF(' + idEquipo + ', "' + equipo + '")');
    document.getElementById("btnTareas").classList.remove("is-danger");
    document.getElementById("btnTareas").classList.add("is-success");
    document.getElementById("txtTareas").innerHTML = 'Ver Solucionados';
    document.getElementById("btnAgregarTareaP")
        .setAttribute('onclick', 'agregarTareaP(' + idEquipo + ', "' + equipo + '")');
    const action = "obtTareasP";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idEquipo: idEquipo,
            equipo: equipo,
            status: status
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("dataEquipoTareasP").innerHTML = equipo;
            document.getElementById("dataTareasP").innerHTML = data.dataTareas;
            document.getElementById("textSeccionTareas").innerHTML = data.seccion;
            document.getElementById("estiloSeccionTareas").classList.remove();
            document.getElementById("estiloSeccionTareas").classList.add(data.seccion);
            document.getElementById("dataEquipoTareasP").innerHTML = data.equipo;
        }
    });
}

function obtTareasF(idEquipo, equipo) {
    document.getElementById("statusSolucionarATP").classList.add("is-hidden");
    document.getElementById("statusRestaurarATP").classList.remove("is-hidden");
    document.getElementById("modal-tareas-p").classList.add('is-active');
    document.getElementById("btnTareas").
        setAttribute('onclick', 'obtTareasP(' + idEquipo + ', "' + equipo + '")');
    document.getElementById("btnTareas").classList.add("is-danger");
    document.getElementById("btnTareas").classList.remove("is-success");
    document.getElementById("txtTareas").innerHTML = 'Ver Pendientes';
    let status = "F";
    document.getElementById("btnAgregarTareaP")
        .setAttribute('onclick', 'agregarTareaP(' + idEquipo + ', "' + equipo + '")');
    const action = "obtTareasP";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idEquipo: idEquipo,
            equipo: equipo,
            status: status
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("dataEquipoTareasP").innerHTML = equipo;
            document.getElementById("dataTareasP").innerHTML = data.dataTareas;
            document.getElementById("textSeccionTareas").innerHTML = data.seccion;
            document.getElementById("estiloSeccionTareas").classList.remove();
            document.getElementById("estiloSeccionTareas").classList.add(data.seccion);
            document.getElementById("dataEquipoTareasP").innerHTML = data.equipo;
        }
    });
}


function agregarTareaP(idEquipo, equipo) {
    let titulo = document.getElementById("tituloTareaP").value;
    const action = "agregarTareaP";
    if (titulo.length > 2 && titulo.length < 61) {
        $.ajax({
            type: "POST",
            url: "php/crud.php",
            data: {
                action: action,
                idEquipo: idEquipo,
                equipo: equipo,
                titulo: titulo
            },
            // dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data = 1) {
                    alertInformacion('Tarea Agregada', 'success');
                    document.getElementById("tituloTareaP").value = '';
                    obtTareasP(idEquipo, equipo);
                } else {
                    alertInformacion('Intente de Nuevo', 'question');
                }
            }
        });
    } else {
        alertInformacion('Título No Valido', 'question');
    }
}


function agregarActividadTareaP(idTareaP, idEquipo, equipo) {
    let actividad = document.getElementById("tituloActividad" + idTareaP).value;
    const action = "agregarActividadTareaP";
    if (actividad.length > 2 && actividad.length < 61) {
        $.ajax({
            type: "POST",
            url: "php/crud.php",
            data: {
                action: action,
                idTareaP: idTareaP,
                actividad: actividad
            },
            // dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data = 1) {
                    alertInformacion('Actividad Agregada', 'success');
                    document.getElementById("tituloTareaP").value = '';
                    obtTareasP(idEquipo, equipo);
                    alertInformacion('Actividad Agregada', 'success');
                } else {
                    alertInformacion('Intente de Nuevo', 'question');
                }
            }
        });
    } else {
        alertInformacion('Título Actividad No Valido', 'question');
    }
}


function actividadSeleccionada(idActividad) {
    $(".tituloActividadS").removeClass("has-background-primary has-background-success");
    $(".tituloActividadP").removeClass("has-background-warning has-background-primary");
    $(".tituloActividadP").addClass("has-background-warning");
    $(".tituloActividadS").addClass("has-background-success");
    $("#actividad" + idActividad).removeClass("has-background-warning has-background-success");
    $("#actividad" + idActividad).addClass("has-background-primary");
}


function agregarComentarioActividad(idActividad, idTareaP) {
    let comentario = document.getElementById("comentarioActividad" + idTareaP).value;
    const action = "agregarComentarioActividad";
    if (comentario.length > 2 && comentario.length < 120) {
        $.ajax({
            type: "POST",
            url: "php/crud.php",
            data: {
                action: action,
                comentario: comentario,
                idActividad: idActividad,
                idTareaP: idTareaP
            },
            // dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data = 1) {
                    alertInformacion('Comentario Agregado', 'success');
                    document.getElementById("comentarioActividad" + idTareaP).value = '';
                    obtenerComentarioActividad(idActividad, idTareaP);
                    alertInformacion('Actividad Agregada', 'success');
                } else {
                    alertInformacion('Intente de Nuevo', 'question');
                }
            }
        });
    } else {
        alertInformacion('Comentario No Valido', 'question');
    }
}

function obtenerComentarioActividad(idActividad, idTareaP) {
    document.getElementById("btnAgregarComentario" + idTareaP).
        setAttribute('onclick', 'agregarComentarioActividad(' + idActividad + ',' + idTareaP + ')');
    const action = "obtenerComentarioActividad";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idActividad: idActividad,
            idTareaP: idTareaP
        },
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataComentario" + idTareaP).innerHTML = data;
        }
    });
}


function obtUsuariosTareasP(idTareaP, idEquipo, equipo) {
    document.getElementById("modaResponsableTareasP").classList.add('modal-fx-superScaled', 'is-active');
    document.getElementById("dataResposansableTareaP").innerHTML = '';
    const action = "obtUsuariosTareasP";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idTareaP: idTareaP,
            idEquipo: idEquipo,
            equipo: equipo
        },
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataResposansableTareaP").innerHTML = data;
        }
    });
}


function asignarResponsableTareasP(idTarea, idUsuario, idEquipo, equipo) {
    const action = "asignarUsuarioTareasP";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idTarea: idTarea,
            idUsuario: idUsuario
        },
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);
            if (data == 1) {
                alertInformacion('Responsable Asignado', 'success');
                obtTareasP(idEquipo, equipo);
                document.getElementById("modaResponsableTareasP").
                    classList.remove('modal-fx-superScaled', 'is-active');
            } else {
                alertInformacion('Intente de Nuevo', 'question');
            }
        }
    });
}


function obtStatusActvidadTareaP(idTareaP, titulo, idEquipo, equipo) {
    document.getElementById("modalStatusTareasP").classList.add('modal-fx-superScaled', 'is-active');
    document.getElementById("codigoSeguimientoTareas").classList.add('is-hidden');
    document.getElementById("nuevoTituloATP").value = titulo;

    document.getElementById("statusUrgenteATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "status_urgente")');

    document.getElementById("statusMaterialATP").setAttribute('onclick',
        'consultarCodigoSeguimientoTareaas(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "status_material")');

    document.getElementById("statusMaterialTareas").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "status_material")');

    document.getElementById("statusTrabajandoATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "status_trabajando")');

    // Finalizar la Tarea
    document.getElementById("statusSolucionarATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "statusP")');

    // Restaura la Tarea.
    document.getElementById("statusRestaurarATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "statusF")');

    document.getElementById("btnTituloATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "titulo")');

    document.getElementById("btnEliminarATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "eliminar")');


    // Energeticos Status
    document.getElementById("statusElectricidadATP").setAttribute('onclick', 'aplicarCambioActividad('
        + idTareaP + ', ' + idEquipo + ', "' + equipo + '", "energetico_electricidad")');

    document.getElementById("statusAguaATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "energetico_agua")');

    document.getElementById("statusDieselATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "energetico_diesel")');

    document.getElementById("statusGasATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "energetico_gas")');


    // Dertamentos Status.
    document.getElementById("statusCalidadATP").setAttribute('onclick', 'aplicarCambioActividad('
        + idTareaP + ', ' + idEquipo + ', "' + equipo + '", "departamento_calidad")');

    document.getElementById("statusComprasATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "departamento_compras")');

    document.getElementById("statusDireccionATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "departamento_direccion")');

    document.getElementById("statusFinanzasATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "departamento_finanzas")');

    document.getElementById("statusRRHHATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idTareaP + ',' + idEquipo + ',"' + equipo + '", "departamento_rrhh")');
}


function aplicarCambioActividad(idTareaP, idEquipo, equipo, columna) {
    let nuevoTitulo = document.getElementById("nuevoTituloATP").value;
    let codigoSeguimiento = document.getElementById("inputCodigoSeguimientoTareas").value;
    const action = "aplicarCambioActividad";

    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idTareaP: idTareaP,
            columna: columna,
            nuevoTitulo: nuevoTitulo,
            codigoSeguimiento: codigoSeguimiento
        },
        // dataType: "JSON",
        success: function (data) {
            if (data == 1) {
                alertInformacion('Status Actualizado', 'success');
                obtTareasP(idEquipo, equipo);
                document.getElementById("modalStatusTareasP").
                    classList.remove('modal-fx-superScaled', 'is-active');
                document.getElementById("nuevoTituloATP").value = '';
            } else if (data == 2) {
                alertInformacion('Título Actualizado', 'success');
                obtTareasP(idEquipo, equipo);
                document.getElementById("modalStatusTareasP").
                    classList.remove('modal-fx-superScaled', 'is-active');
                document.getElementById("nuevoTituloATP").value = '';
            } else if (data == 3) {
                alertInformacion('Tarea Eliminada', 'success');
                obtTareasP(idEquipo, equipo);
                document.getElementById("modalStatusTareasP").
                    classList.remove('modal-fx-superScaled', 'is-active');
                document.getElementById("nuevoTituloATP").value = '';
            } else if (data == 4) {
                alertInformacion('Tarea Finalizada', 'success');
                document.getElementById("modalStatusTareasP").
                    classList.remove('modal-fx-superScaled', 'is-active');
                obtTareasP(idEquipo, equipo);
            } else if (data == 5) {
                alertInformacion('Tarea Restaurada', 'success');
                document.getElementById("modalStatusTareasP").
                    classList.remove('modal-fx-superScaled', 'is-active');
                obtTareasP(idEquipo, equipo);
            } else if (data == 6) {
                alertInformacion('Status Material, Activado', 'success');
                obtTareasP(idEquipo, equipo);
            } else if (data == 7) {
                alertInformacion('Status Material, Desactivado', 'success');
                obtTareasP(idEquipo, equipo);
            } else {
                alertInformacion('Intente de Nuevo', 'question');
                obtTareasP(idEquipo, equipo);
            }
        }
    });
}


function consultarCodigoSeguimientoTareaas(idTareaP, idEquipo, equipo, columna) {
    document.getElementById("codigoSeguimientoTareas").classList.remove('is-hidden');
    const action = "consultarCodigoSeguimientoTareaas";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idTareaP: idTareaP
        },
        // dataType: "JSON",
        success: function (data) {
            document.getElementById("inputCodigoSeguimientoTareas").value = data;
        }
    });
}


function verSolucionados(idTareaP) {
    $(".actividadSolucionada" + idTareaP).toggleClass("is-sr-only");
}


function finalizarTareaP(idTarea, idEquipo, equipo, status) {
    const action = "finalizarTareaP";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idTarea: idTarea,
            status: status
        },
        // dataType: "JSON",
        success: function (data) {
            if (data == 1) {
                alertInformacion('Tarea Finalizada', 'success');
                obtTareasP(idEquipo, equipo);
            } else {
                alertInformacion('Intente de Nuevo', 'question');
            }
        }
    });
}


function obtDatosTarea(idTarea, titulo, idEquipo, equipo) {
    document.getElementById("modal-titulo-tareas").classList.add('is-active');
    document.getElementById("nuevoTituloTP").value = titulo;

    document.getElementById("btnEliminarATP")
        .setAttribute('onclick', 'actualizarTarea(' + idTarea + ',' + idEquipo + ', "' + equipo + '", "eliminar")');
    document.getElementById("btnTituloTP")
        .setAttribute('onclick', 'actualizarTarea(' + idTarea + ',' + idEquipo + ', "' + equipo + '", "titulo")');
}

function actualizarTarea(idTarea, idEquipo, equipo, columna) {
    let titulo = document.getElementById("nuevoTituloTP").value;
    const action = "actualizarTarea";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idTarea: idTarea,
            titulo: titulo,
            columna: columna
        },
        // dataType: "JSON",
        success: function (data) {
            if (data == 1) {
                alertInformacion('Título Actualizado', 'success');
                obtTareasP(idEquipo, equipo);
                document.getElementById("modal-titulo-tareas").classList.remove('is-active');
            } else if (data = 2) {
                alertInformacion('Tarea Eliminada', 'success');
                obtTareasP(idEquipo, equipo);
                document.getElementById("modal-titulo-tareas").classList.remove('is-active');
            } else {
                alertInformacion('Intente de Nuevo', 'question');
            }
        }
    });
}


function adjuntosTareas(idTareas, idEquipo, equipo) {
    document.getElementById("modal-tareas-pictures").classList.add('is-active', 'modal-fx-superScaled');
    $("#colFotosTareas").html('');
    const action = "adjuntosTareas";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idTareas: idTareas,
            idEquipo: idEquipo,
            equipo: equipo
        },
        // dataType: "dataType",
        success: function (data) {
            $("#colFotosTareas").html(data);
        }
    });
}


function cargarAdjuntoTarea(idTarea, idEquipo, equipo) {
    var inputFileImage = document.getElementById("inputAdjuntoTarea");
    var file = inputFileImage.files;
    var data = new FormData();
    let idMPNP = idTarea;
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
                alertInformacion('Adjunto Cargado', 'success');
                adjuntosTareas(idTarea, idEquipo, equipo);
                obtTareasP(idEquipo, equipo);

            } else {
                alertInformacion('Intente de Nuevo', 'info');
            }
        },
    });
}


function obtComentariosTarea(idEquipo, equipo, idTareaP, titulo) {
    document.getElementById("agregarComentarioTarea").setAttribute('onclick', 'agregarComentarioTarea(' + idEquipo + ', "' + equipo + '", ' + idTareaP + ', "' + titulo + '")');
    document.getElementById("dataComentariosTareas").innerHTML = '';
    document.getElementById("dataHeaderComentarios").innerHTML = ''; document.getElementById("modal-comentarios-tareas").classList.add('is-active');
    const action = "obtComentariosTarea";
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idTareaP: idTareaP,
            idEquipo: idEquipo,
            titulo: titulo,
            equipo: equipo
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("dataComentariosTareas").innerHTML = data.dataComentarios;
            document.getElementById("dataHeaderComentarios").innerHTML = data.dataHeaderComentario;
        }
    });
}


function eliminarComentarioTarea(idComentario, idEquipo, equipo, idTareaP, titulo) {
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
            if (data == "Comentario Eliminado.") {
                alertInformacion('Comentario Eliminado.', 'success');
                obtComentariosTarea(idEquipo, equipo, idTareaP, titulo);
                obtTareasP(idEquipo, equipo);
            } else {
                alertInformacion('Intente de Nuevo.', 'question');
                obtComentariosTarea(idEquipo, equipo, idTareaP, titulo);
            }
        }
    });
}


function agregarComentarioTarea(idEquipo, equipo, idTareaP, titulo) {
    let comentario = document.getElementById("textComentarioTareas").value;

    var action = "agregarComentarioMPNP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            comentario: comentario,
            idMPNP: idTareaP
        },
        // dataType: "dataType",
        success: function (data) {
            if (data == 1) {
                alertInformacion('Comentario Agregado.', 'success');
                document.getElementById("textComentarioTareas").value = '';
                obtComentariosTarea(idEquipo, equipo, idTareaP, titulo);
                obtTareasP(idEquipo, equipo);
            } else {
                alertInformacion('Intente de Nuevo.', 'question');
                obtComentariosTarea(idEquipo, equipo, idTareaP, titulo);
            }
        }
    });
}


function eliminarAdjuntoTarea(idImg, idTarea, idEquipo, equipo) {
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
            if (data == "Adjunto Eliminado.") {
                adjuntosTareas(idTarea, idEquipo, equipo);
                obtTareasP(idEquipo, equipo);
                alertInformacion('Adjunto Eliminado', 'success');
            } else {
                alertInformacion('Intente de Nuevo.', 'question');

            }
        }
    });
}


function obtStatusTareas() {
    document.getElementById("modalStatusTareasP").classList.add('modal-fx-superScaled', 'is-active');
}


// FUNCIÓN PARA ENERGETICOS
function obtenerPendientesEnergeticos(idSeccion, idSubseccion, status) {
    localStorage.setItem('idSeccion', idSeccion);
    localStorage.setItem('idSubseccion', idSubseccion);
    const action = "obtenerPendientesEnergeticos";
    document.getElementById("modal-energeticos").classList.add("is-active");
    let contenedor = document.getElementById("dataEnergeticos");
    let btn = document.getElementById("btnObtenerEnergeticos");
    document.getElementById("btnCrearEnergetico").
        setAttribute('onclick', `agregarEnergetico(${idSeccion}, ${idSubseccion});`);

    btn.classList = "";

    if (status == "PENDIENTE") {
        btn.setAttribute('onclick', `obtenerPendientesEnergeticos(${idSeccion}, ${idSubseccion}, 'SOLUCIONADO');`);
        btn.classList = "button is-success";
        btn.childNodes[2].textContent = 'Ver Solucionados';
    } else {
        btn.setAttribute('onclick', `obtenerPendientesEnergeticos(${idSeccion}, ${idSubseccion}, 'PENDIENTE');`);
        btn.classList = "button is-danger";
        btn.childNodes[2].textContent = 'Ver Pendientes';
    }

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion,
            status: status
        },
        dataType: "JSON",
        success: function (array) {
            console.log(array);
            contenedor.innerHTML = '';
            document.getElementById("textSeccionEnergeticos").
                innerHTML = array.subseccion[0] + ' / PENDIENTES';
            document.getElementById("textSeccionEnergeticos").
                innerHTML = array.subseccion[0] + ' / PENDIENTES';

            if (array.pendientes.length > 0) {
                for (let x = 0; x < array.pendientes.length; x++) {
                    const id = array.pendientes[x].id;
                    const actividad = array.pendientes[x].actividad;
                    const responsable = array.pendientes[x].responsable;
                    const nombre = array.pendientes[x].nombre;
                    const fecha = array.pendientes[x].fecha;
                    const adjuntos = array.pendientes[x].adjuntos;
                    const comentarios = array.pendientes[x].comentarios;
                    const status = array.pendientes[x].status;
                    const sDepartamento = array.pendientes[x].sDepartamento;
                    const sEnergetico = array.pendientes[x].sEnergetico;

                    if (comentarios <= 0) {
                        comentariosX = '<i class="fad fa-minus has-text-danger fa-1x"></i>';
                    } else {
                        comentariosX = comentarios;
                    }

                    if (adjuntos <= 0) {
                        adjuntosX = '<i class="fad fa-minus has-text-danger fa-1x"></i>';
                    } else {
                        adjuntosX = adjuntos;
                    }

                    if (sDepartamento >= 1 && status == "PENDIENTE") {
                        iconoDepartamento = '<strong class="has-text-primary">D</strong>';
                    } else {
                        iconoDepartamento = '';
                    }

                    if (sEnergetico >= 1 && status == "PENDIENTE") {
                        iconoEnergetico = '<strong class="has-text-warning">E</strong>';
                    } else {
                        iconoEnergetico = '';
                    }

                    if (status == "PENDIENTE" && sDepartamento < 1 && sEnergetico < 1) {
                        fStatusIcono = '<i class="fad fa-exclamation-circle has-text-info fa-lg"></i>';
                    } else {
                        fStatusIcono = '';
                    }

                    if (status == "PENDIENTE") {
                        restaurarIcono = '';
                    } else {
                        restaurarIcono = `<i class="fas fa-redo fa-lg has-text-danger" onclick="actualizarEnergetico(${id}, 'status', 'SOLUCIONADO')"></i>`;
                    }

                    if (status == "PENDIENTE") {
                        estiloStatus = "is-danger";
                        fStatus = `onclick="toggleModalBulma('modalStatusEnergeticos'); obtenerStatusEnergetico(${id});"`;
                        fResponsable = `onclick="obtenerResponsablesEnergeticos(${id})"`;
                        fAdjuntos = `onclick="obtenerAdjuntosEnergeticos(${id})"`;
                        fComentarios = `onclick="obtenerComentariosEnergeticos(${id})"`;
                    } else {
                        estiloStatus = "is-success";
                        fStatus = '';
                        fResponsable = '';
                        fAdjuntos = `onclick="obtenerAdjuntosEnergeticos(${id})"`;
                        fComentarios = `onclick="obtenerComentariosEnergeticos(${id})"`;
                    }

                    const codigo = `
                        <div id="energetico_${id}" class="columns is-gapless my-2 is-mobile hvr-grow-sm manita mx-2">
                            <div class="column is-half">
                                <div class="columns">
                                    <div class="column">
                                        <div class="message is-small ${estiloStatus}">
                                            <p class="message-body"><strong>${actividad}</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="columns is-gapless">

                                    <div class="column" ${fResponsable}>
                                        <p class="t-normal" data-tooltip="${responsable}">
                                            ${nombre}
                                        </p>
                                    </div>

                                    <div class="column">
                                        <p class="t-normal">${fecha}</p>
                                    </div>

                                    <div class="column" ${fAdjuntos}>
                                        <p class="t-normal">${adjuntosX}</p>
                                    </div>

                                    <div class="column" ${fComentarios}>
                                        <p class="t-normal">${comentariosX}</p>
                                    </div>

                                    <div class="column" ${fStatus}>
                                        <p class="t-normal">
                                            ${fStatusIcono}
                                            ${iconoEnergetico}
                                            ${iconoDepartamento}
                                            ${restaurarIcono}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    `;
                    contenedor.insertAdjacentHTML('beforeend', codigo);
                }
            }

            if (array.seccion[0]) {
                document.getElementById("textSeccionEnergeticos").
                    innerHTML = array.seccion[0];
            }

            if (array.subseccion[0]) {
                document.getElementById("textSubseccionEnergeticos").
                    innerHTML = array.subseccion[0];
            }
        },
        error: function (e) {
            console.log(e);
            contenedor.innerHTML = '';
            document.getElementById("textSeccionEnergeticos").innerHTML = '';
            document.getElementById("textSubseccionEnergeticos").innerHTML = '';
        }
    });
}


// FUNCIÓN PARA AGREGAR ENERGETICO
function agregarEnergetico(idSeccion, idSubseccion) {
    localStorage.setItem('idSeccion', idSeccion);
    localStorage.setItem('idSubseccion', idSubseccion);
    let actividad = document.getElementById("inputEnergetico");

    const action = "agregarEnergetico";
    if (actividad.value.length > 1) {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idSeccion: idSeccion,
                idSubseccion: idSubseccion,
                status: status,
                actividad: actividad.value
            },
            dataType: "JSON",
            success: function (array) {
                if (array == 1) {
                    obtenerPendientesEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
                    alertaImg('PENDIENTE Agregado ', '', 'success', 1200);
                    actividad.value = '';
                } else {
                    alertaImg('Intente de Nuevo ', '', 'info', 1200);
                }
            },
            error: function (e) {
            }
        })
    } else {
        alertaImg('Intente de Nuevo ', '', 'info', 1200);
    }
}


// OBTIENE RESPONSABLES
function obtenerResponsablesEnergeticos(idPendiente) {
    let palabraUsuario = document.getElementById("inputResponsableEnergeticos");
    let contenedor = document.getElementById("divListaUsuariosEnergeticos");

    document.getElementById("modalAgregarResponsableEnergeticos").
        classList.add('is-active');

    document.getElementById("inputResponsableEnergeticos").
        setAttribute('onkeyup', 'obtenerResponsablesEnergeticos()');

    const action = "obtenerResponsablesEnergeticos";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            palabraUsuario: palabraUsuario.value
        },
        dataType: "JSON",
        success: function (array) {
            contenedor.innerHTML = '';
            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const idUsuario = array[x].idUsuario;
                    const usuario = array[x].usuario;
                    codigo = `
                        <h6 class="title is-6 manita border rounded py-1 px-1 my-1 mx-2 text-truncate usuario" 
                        onclick="actualizarEnergetico(${idPendiente}, 'responsable', 
                        ${idUsuario})">
                            <i class="fas fa-user"></i> 
                            ${usuario}
                        </h6>
                    `;
                    contenedor.insertAdjacentHTML('beforeend', codigo);
                }
            }
        },
        error: function (e) {
            contenedor.innerHTML = '';
        }
    })
}


// ACTUALIZA DATOS DE LOS PENDIENTES DE ENERGETICOS
function actualizarEnergetico(idPendiente, columna, valor) {
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    const action = "actualizarEnergetico";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idPendiente: idPendiente,
            columna: columna,
            valor: valor
        },
        dataType: "JSON",
        success: function (array) {
            obtenerPendientesEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
            document.getElementById("modalAgregarResponsableEnergeticos").
                classList.remove('is-active');

            if (array == 1) {
                alertaImg('Responsable Asignado', '', 'success', 1200);
            } else if (array == 2) {
                alertaImg('Status Actualizado', '', 'success', 1200);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
        },
        error: function (e) {
            alertaImg('Intente de Nuevo', '', 'info', 1200);
        }
    })
}


// OBTENER ADJUNTOS
function obtenerAdjuntosEnergeticos(idPendiente) {
    localStorage.setItem('idEnergetico', idPendiente);
    document.getElementById("modal-energeticos-pictures").classList.add("is-active");
    let contenedor = document.getElementById("dataAdjuntosEnergeticos");
    const action = "obtenerAdjuntosEnergeticos";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idPendiente: idPendiente
        },
        dataType: "JSON",
        success: function (array) {
            contenedor.innerHTML = '';
            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const idAdjunto = array[x].idAdjunto;
                    const url = array[x].url;
                    const subidoPor = array[x].subidoPor;
                    const fecha = array[x].fecha;
                    const tipo = array[x].tipo;
                    const codigo = `
                        <div class="timeline-item py-0" data-tipo="${url}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong> </strong>
                                <button class="is-delete is-size-7 manita" onclick="borrarAdjuntoEnergeticos(${idAdjunto});">
                                    <a class="delete is-medium"></a>
                                    </button></p>
                                <p class="heading"></p>
                                <a href="planner/energeticos/${url}" target="_BLANCK"><img class="ximg" src="planner/energeticos/${url}" alt=""></a>
                            </div>
                        </div>                    
                    `;
                    contenedor.insertAdjacentHTML('beforeend', codigo);
                }
            }
        },
        error: function (e) {
            alertaImg('Intente de Nuevo', '', 'info', 1200);
        }
    })
}


// BORRA ADJUNTOS DE ENERGETICOS
function borrarAdjuntoEnergeticos(idAdjunto) {
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    let idEnergetico = localStorage.getItem('idEnergetico');
    const action = "borrarAdjuntoEnergeticos";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idAdjunto: idAdjunto
        },
        dataType: "JSON",
        success: function (data) {
            if (data == 1) {
                alertaImg('Adjunto Eliminado', '', 'success', 1200);
                obtenerAdjuntosEnergeticos(idEnergetico);
                obtenerPendientesEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
        },
        error: function (e) {
            alertaImg('Intente de Nuevo', '', 'info', 1200);
            obtenerAdjuntosEnergeticos(idEnergetico);
        }
    })
}


// OBTENER COMENTARIOS
function obtenerComentariosEnergeticos(idPendiente) {
    document.getElementById("modal-energeticos-comentarios").classList.add("is-active");
    let contenedor = document.getElementById("dataComentariosEnergetico");
    const action = "obtenerComentariosEnergeticos";
    document.getElementById("btnAgregarComentarioEnergetico").
        setAttribute('onclick', `agregarComentariosEnergeticos(${idPendiente})`);
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idPendiente: idPendiente
        },
        dataType: "JSON",
        success: function (array) {
            contenedor.innerHTML = '';

            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const id = array[x].id;
                    const comentario = array[x].comentario;
                    const fecha_creado = array[x].fecha_creado;
                    const usuario = array[x].usuario;

                    const codigo = `
                        <div class="timeline-item py-0">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <p class="heading"><strong>${usuario}</strong></p>
                                <p class="heading">${fecha_creado}</p>
                                <p class="has-text-justified">${comentario}</p>
                            </div>
                        </div>
                    `;
                    contenedor.insertAdjacentHTML('beforeend', codigo);
                }
            }
        },
        error: function (e) {
            alertaImg('Intente de Nuevo', '', 'info', 1200);
            contenedor.innerHTML = '';
        }
    })
}


// AGREGAR COMENTARIOS
function agregarComentariosEnergeticos(idPendiente) {
    let comentario = document.getElementById("inputComentarioEnergetico").value;
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    document.getElementById("modal-energeticos-comentarios").classList.add("is-active");
    const action = "agregarComentarioEnergtico";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idPendiente: idPendiente,
            comentario: comentario
        },
        dataType: "JSON",
        success: function (array) {
            if (array == 1) {
                obtenerComentariosEnergeticos(idPendiente);
                obtenerPendientesEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
                alertaImg('Comentario Agregado', '', 'success', 1200);
                document.getElementById("inputComentarioEnergetico").value = '';
            } else {
                alertaImg('Intente de Nuevo ', '', 'info', 1200);
            }
        },
        error: function (e) {
            alertaImg('Intente de Nuevo', '', 'info', 1200);
            obtenerComentariosEnergeticos(idPendiente);
        }
    })
}


// SUBIR ADJUNTO   
document.getElementById("inputAdjuntosEnergeticos").addEventListener('change', () => {
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    let idEnergetico = localStorage.getItem('idEnergetico');
    let file = document.getElementById("inputAdjuntosEnergeticos");

    var data = new FormData();
    for (i = 0; i < file.files.length; i++) {
        data.append("fileToUpload" + i, file.files[i]);
    }
    data.append("idEnergetico", idEnergetico);
    var url = "php/planner_uploadcot_energetico.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            file.value = '';
            if (data == 1) {
                alertaImg('Adjunto Agregado', '', 'success', 1200);
                obtenerAdjuntosEnergeticos(idEnergetico);
                obtenerPendientesEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
        },
    });
})


function toggleModalBulma(idModal) {
    if (document.getElementById(idModal)) {
        document.getElementById(idModal).classList.add('is-active');
    }
}


function toggleHidden(idElemento) {
    if (document.getElementById(idElemento)) {
        document.getElementById(idElemento).classList.toggle('hidden');
    }
}


function obtenerStatusEnergetico(idEnergetico) {
    let inputTitulo = document.getElementById("inputTituloEnergetico");
    inputTitulo.value = '';

    document.getElementById("btnStatusSolucionarEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'status')`);

    document.getElementById("btnStatusEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'status_material');`);

    document.getElementById("btnStatusElectricidadEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'energetico_electricidad');`);

    document.getElementById("btnStatusAguaEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'energetico_agua');`);

    document.getElementById("btnStatusDieselEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'energetico_diesel');`);

    document.getElementById("btnStatusGasEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'energetico_gas');`);

    document.getElementById("btnStatusCalidadEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'departamento_calidad');`);

    document.getElementById("btnStatusComprasEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'departamento_compras');`);

    document.getElementById("btnStatusDireccionEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'departamento_direccion');`);

    document.getElementById("btnStatusFinanzasEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'departamento_finanzas');`);

    document.getElementById("btnStatusRRHHEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'departamento_rrhh');`);

    document.getElementById("btnEliminarEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'eliminar');`);

    document.getElementById("btnActualizarTituloEnergetico").
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, 'titulo');`);

    let titulo = document.getElementById("energetico_" + idEnergetico).childNodes[1].innerText;
    inputTitulo.value = titulo;
}


// ACTUALIZAR INFORMACIÓN DE ENERGETICO
function actualizarEnergetico(idEnergetico, columna) {
    console.log(idEnergetico, columna);
    let idSeccion = localStorage.getItem('idSeccion');
    let idSubseccion = localStorage.getItem('idSubseccion');
    let cod2bend = document.getElementById("inputCod2bendEnergetico").value;
    let titulo = document.getElementById("inputTituloEnergetico");
    const action = "actualizarDatosEnergetico";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idEnergetico: idEnergetico,
            columna: columna,
            cod2bend: cod2bend,
            titulo: titulo.value
        },
        dataType: "JSON",
        success: function (array) {
            console.log(array);
            document.getElementById("modalStatusEnergeticos").classList.remove('is-active');
            obtenerPendientesEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
            titulo.value = '';
            if (array == 1) {
                alertaImg('Pendiente Solucionado', '', 'success', 1200);
            } else if (array == 2) {
                alertaImg('Pendiente Restaurado', '', 'success', 1200);
            } else if (array == 3) {
                alertaImg('Status Material, Actualizado', '', 'success', 1200);
            } else if (array == 4) {
                alertaImg('Status Actualizado', '', 'success', 1200);
            } else if (array == 5) {
                alertaImg('Titulo Actualizado', '', 'success', 1200);
            } else if (array == 6) {
                alertaImg('Pendiente Eliminado', '', 'success', 1200);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
        },
        error: function (e) {
            console.log(e);
        }
    })
}