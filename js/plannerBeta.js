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
            console.log(data);
            document.getElementById("dataEquipoTareasP").innerHTML = equipo;
            document.getElementById("dataTareasP").innerHTML = data.dataTareas;
            document.getElementById("textSeccion").innerHTML = data.seccion;
            document.getElementById("estiloSeccion").classList.remove();
            document.getElementById("estiloSeccion").classList.add(data.seccion);
            document.getElementById("dataEquipoTareasP").innerHTML = data.equipo;
        }
    });
}

function obtTareasF(idEquipo, equipo) {
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
            document.getElementById("textSeccion").innerHTML = data.seccion;
            document.getElementById("estiloSeccion").classList.remove();
            document.getElementById("estiloSeccion").classList.add(data.seccion);
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


function obtStatusActvidadTareaP(idActividad, idEquipo, equipo) {
    document.getElementById("modalStatusTareasP").classList.add('modal-fx-superScaled', 'is-active');

    document.getElementById("statusUrgenteATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "status_urgente")');

    document.getElementById("statusMaterialATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "status_material")');

    document.getElementById("statusTrabajandoATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "status_trabajando")');

    document.getElementById("statusSolucionarATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "statusP")');

    document.getElementById("btnTituloATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "titulo")');

    document.getElementById("btnEliminarATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "eliminar")');


    // Energeticos Status
    document.getElementById("statusElectricidadATP").setAttribute('onclick', 'aplicarCambioActividad('
        + idActividad + ', ' + idEquipo + ', "' + equipo + '", "energetico_electricidad")');

    document.getElementById("statusAguaATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "energetico_agua")');

    document.getElementById("statusDieselATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "energetico_diesel")');

    document.getElementById("statusGasATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "energetico_gas")');


    // Dertamentos Status.
    document.getElementById("statusCalidadATP").setAttribute('onclick', 'aplicarCambioActividad('
        + idActividad + ', ' + idEquipo + ', "' + equipo + '", "departamento_calidad")');

    document.getElementById("statusComprasATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "departamento_compras")');

    document.getElementById("statusDireccionATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "departamento_direccion")');

    document.getElementById("statusFinanzasATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "departamento_finanzas")');

    document.getElementById("statusRRHHATP").setAttribute('onclick',
        'aplicarCambioActividad(' + idActividad + ',' + idEquipo + ',"' + equipo + '", "departamento_rrhh")');
}


function aplicarCambioActividad(idActividad, idEquipo, equipo, columna) {
    let nuevoTitulo = document.getElementById("nuevoTituloATP").value;
    const action = "aplicarCambioActividad";
    if (columna == 'titulo' && nuevoTitulo.length < 2) {
        alertInformacion('Título Actividad, No Valido', 'question');
    } else {
        $.ajax({
            type: "POST",
            url: "php/crud.php",
            data: {
                action: action,
                idActividad: idActividad,
                columna: columna,
                nuevoTitulo: nuevoTitulo
            },
            // dataType: "JSON",
            success: function (data) {
                console.log(data);
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
                    alertInformacion('Actividad Eliminada', 'success');
                    obtTareasP(idEquipo, equipo);
                    document.getElementById("modalStatusTareasP").
                        classList.remove('modal-fx-superScaled', 'is-active');
                    document.getElementById("nuevoTituloATP").value = '';
                } else if (data == 4) {
                    alertInformacion('Actividad Finalizada', 'success');
                    document.getElementById("modalStatusTareasP").
                        classList.remove('modal-fx-superScaled', 'is-active');
                    obtTareasP(idEquipo, equipo);
                } else if (data == 0) {
                    alertInformacion('Intente de Nuevo', 'question');
                    obtTareasP(idEquipo, equipo);
                }
            }
        });
    }
}


function verSolucionados(idTareaP) {
    console.log(idTareaP);
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
            console.log(data);
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
    console.log(idTarea, idEquipo, equipo, columna);
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
            console.log(data);
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