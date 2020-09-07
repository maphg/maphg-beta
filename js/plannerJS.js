function cargarTareasDestino(pagina, destino) {
    localStorage.setItem("idDestino", destino);
    if (pagina == 1) {
        var url = "../php/plannerPHP.php";
    } else {
        var url = "php/plannerPHP.php";
    }
    //var destino = document.getElementById("cbDestinos").value;
    $.ajax({
        type: "post",
        url: url,
        data: "action=1&idDestino=" + destino,
        success: function (data) {
            if (data == 1) {
                location.reload();
            } else {
                toastr.error(data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function cargarTiposProyectos(pagina) {
    if (pagina == 1) {
        var url = "../php/plannerPHP.php";
    } else {
        var url = "php/plannerPHP.php";
    }
    var tipoProyecto = document.getElementById("cbTipoProyectos").value;
    $.ajax({
        type: "post",
        url: url,
        data: "action=34&tipoProyecto=" + tipoProyecto,

        success: function (data) {
            location.reload();
        },
    });
}

function cargarSeccionSession(pagina) {
    if (pagina == 1) {
        var url = "../php/plannerPHP.php";
    } else {
        var url = "php/plannerPHP.php";
    }
    var idSeccion = document.getElementById("cbSecciones").value;
    $.ajax({
        type: "post",
        url: url,
        data: "action=35&idSeccion=" + idSeccion,

        success: function (data) {
            location.reload();
        },
    });
}

function mostrarColumnasSeccion(idPermiso, idUsuario) {
    var rdbtnTipo = document.getElementsByName("tipo");
    for (i = 0; i < rdbtnTipo.length; i++) {
        if (rdbtnTipo[i].checked) {
            var tipo = rdbtnTipo[i].value;
            break;
        }
    }
    var selected = $("#cbSecciones").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=2&idSeccion=" +
            selected +
            "&idUsuario=" +
            idUsuario +
            "&idPermiso=" +
            idPermiso +
            "&tipo=" +
            tipo,

        success: function (data) {
            $(".loader").fadeOut("slow");
            document.getElementById("dFilas").innerHTML = "";
            document.getElementById("dFilas").innerHTML = data;
            $('[data-toggle="tooltip"]').tooltip();
        },
    });
}


//OBTENER LA LISTA DE EQUIPOS DE LA SUBSECCION
function obtenerEquipos(
    idGrupo,
    idDestino,
    idCategoria,
    idSubcategoria,
    idRelCatSubcat,
    pagina,
    destino,
    seccion,
    subseccion
) {
    // Envia a modal-MPNP
    $("#hddIdSubseccion").val(idGrupo);
    $("#hddIdDestino").val(idDestino);
    $("#hddIdCategoria").val(idCategoria);
    $("#hddIdSubcategoria").val(idSubcategoria);
    $("#subseccionMPNP").html(subseccion);
    //$("#hddIdEquipo").val(idEquipo);
    $("#busqueda").val("");
    $("#btnBuscar").attr(
        "onclick",
        "obtenerEquiposxPalabra(" +
        idGrupo +
        "," +
        idDestino +
        "," +
        idCategoria +
        "," +
        idSubcategoria +
        "," +
        idRelCatSubcat +
        "," +
        pagina +
        ")"
    );
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=3&idGrupo=" +
            idGrupo +
            "&idDestino=" +
            idDestino +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria +
            "&idRelCatSubcat=" +
            idRelCatSubcat +
            "&pagina=" +
            pagina,
        beforeSend: function () {
            var pageloader = document.getElementById("loader");
            if (pageloader) {
                pageloader.classList.toggle("is-active");
            }
        },
        success: function (data) {
            $("#modalHotel").removeClass('is-active');
            var pageloader = document.getElementById("loader");
            pageloader.classList.toggle("is-active");
            try {
                var datos = JSON.parse(data);
                $("#divNameSeccion").removeClass();
                $("#divNameSeccion").last().addClass(seccion);
                $("#divNameSeccionMPNP").removeClass();
                $("#divNameSeccionMPNP").last().addClass(seccion);
                $("#link-stock").attr("href", "stock.php?idSubseccion=" + idGrupo);
                $("#link-auditorias").attr(
                    "href",
                    "file-explorer.php?p=" +
                    destino +
                    "/AUDITORIAS/" +
                    seccion +
                    "/" +
                    subseccion
                );
                $("#link-certificaciones").attr(
                    "href",
                    "file-explorer.php?p=" +
                    destino +
                    "/CERTIFICACIONES - NORMATIVAS/" +
                    seccion +
                    "/" +
                    subseccion
                );
                $("#link-cotizaciones").attr(
                    "href",
                    "file-explorer.php?p=" +
                    destino +
                    "/COTIZACIONES -  FACTURAS/" +
                    seccion +
                    "/" +
                    subseccion
                );
                $("#link-planos").attr(
                    "href",
                    "file-explorer.php?p=" +
                    destino +
                    "/PLANOS/" +
                    seccion +
                    "/" +
                    subseccion
                );
                $("#link-otros").attr(
                    "href",
                    "file-explorer.php?p=" +
                    destino +
                    "/OTROS/" +
                    seccion +
                    "/" +
                    subseccion
                );
                $("#divNameSeccion").html(
                    '<p class="seccion-logo">' + seccion + "</p>"
                );
                $("#divNameSeccionMPNP").html(
                    '<p class="seccion-logo">' + seccion + "</p>"
                );
                $("#divNameSubseccion").html(datos.nombreSubseccion);
                $("#divNombreSubseccion").attr("data-content", datos.nombreSubseccion);
                $("#sectionHeroListaEquipos").show();
                $("#divListaEquipos").html(datos.listaEquipos);
                $("#divListaEquipos").show();
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//OBTENER LA LISTA DE EQUIPOS DE LA SUBSECCION POR PAGINA
function obtenerEquiposxPagina(
    idGrupo,
    idDestino,
    idCategoria,
    idSubcategoria,
    idRelCatSubcat,
    pagina
) {
    //$("#hddIdEquipo").val(idEquipo);
    $("#hddIdDestino").val(idDestino);
    $("#hddIdSubseccion").val(idGrupo);
    $("#hddIdCategoria").val(idCategoria);
    $("#hddIdSubcategoria").val(idSubcategoria);
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=3&idGrupo=" +
            idGrupo +
            "&idDestino=" +
            idDestino +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria +
            "&idRelCatSubcat=" +
            idRelCatSubcat +
            "&pagina=" +
            pagina,
        success: function (data) {
            var datos = JSON.parse(data);
            $("#divNameSubseccion").attr("data-content", datos.nombreSubseccion);
            $("#divNombreSubseccion").attr("data-content", datos.nombreSubseccion);
            $("#divListaEquipos").html(datos.listaEquipos);
            $("#divListaEquipos").show();
        },
    });
}

//Buscar equipo por palabra
function obtenerEquiposxPalabra(
    idGrupo,
    idDestino,
    idCategoria,
    idSubcategoria,
    idRelCatSubcat,
    pagina
) {
    //    $("#txtBuscarEquipo").val("");
    //    $("#txtBuscarEquipo").attr("onkeyup", "buscarEquipo(this, " + idDestino + ", " + idGrupo + ", " + idCategoria + ", " + idSubcategoria + ")");
    var palabra = $("#busqueda").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=buscarPorPalabra&idGrupo=" +
            idGrupo +
            "&idDestino=" +
            idDestino +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria +
            "&idRelCatSubcat=" +
            idRelCatSubcat +
            "&pagina=" +
            pagina +
            "&palabra=" +
            palabra,
        beforeSend: function () {
            var pageloader = document.getElementById("loader");
            if (pageloader) {
                pageloader.classList.toggle("is-active");
            }
        },
        success: function (data) {
            var pageloader = document.getElementById("loader");
            pageloader.classList.toggle("is-active");
            try {
                var datos = JSON.parse(data);
                $("#divNameSubseccion").html(datos.nombreSubseccion);
                $("#divNombreSubseccion").attr("data-content", datos.nombreSubseccion);
                $("#sectionHeroListaEquipos").show();
                $("#divListaEquipos").html(datos.listaEquipos);
                $("#divListaEquipos").show();
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//OBTENER LA LISTA DE EQUIPOS DE LA SUBSECCION POR PAGINA
function obtenerEquiposxPaginaxPalabra(
    idGrupo,
    idDestino,
    idCategoria,
    idSubcategoria,
    idRelCatSubcat,
    pagina
) {
    var palabra = $("#busqueda").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=buscarPorPalabra&idGrupo=" +
            idGrupo +
            "&idDestino=" +
            idDestino +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria +
            "&idRelCatSubcat=" +
            idRelCatSubcat +
            "&pagina=" +
            pagina +
            "&palabra=" +
            palabra,
        success: function (data) {
            var datos = JSON.parse(data);
            $("#divNameSubseccion").attr("data-content", datos.nombreSubseccion);
            $("#divNombreSubseccion").attr("data-content", datos.nombreSubseccion);
            $("#divListaEquipos").html(datos.listaEquipos);
            $("#divListaEquipos").show();
        },
    });
}

function buscarEquipo(
    element,
    idDestino,
    idGrupo,
    idCategoria,
    idSubcategoria
) {
    var equipo = element.value;
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=21&equipo=" +
            equipo +
            "&idDestino=" +
            idDestino +
            "&idSubseccion=" +
            idGrupo +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria,
        success: function (data) {
            $("#divListaEquipos").html(data);
        },
    });
}

function obtenerComentariosEquipo(idEquipo) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtenerComentarios&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#colComentariosEquipo").show();
                $("#colComentariosEquipoMCMP").show();
                $("#divHeaderComentarios").html(datos.header);
                $("#colComentariosEquipo").html(datos.comentariosGenerales);
                $("#colComentariosEquipoMCMP").html(datos.comentariosMCMPM);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function agregarComentarioEquipo(idEquipo) {
    var comentario = $("#txtComentarioEquipo").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=insertarComentarioEquipo&idEquipo=" +
            idEquipo +
            "&comentario=" +
            comentario,
        success: function (data) {
            if (data == 1) {
                obtenerComentariosEquipo(idEquipo);
            } else {
                toastr.error(data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function obtenerFotosEquipo(idEquipo) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtenerFotos&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var datos = JSON.parse(data);

                // Información de equipos.
                $("#colFotosEquipo1").html(datos.fotosGenerales1);
                $("#colInfoEquipoAdjuntos").html(datos.fotosGeneralesArchivos);

                $("#colFotosEquipo").show();
                $("#colFotosMPMC").show();
                $("#divHeaderFotos").html(datos.header);
                $("#colFotosEquipo").html(datos.fotosGenerales);
                $("#colFotosMPMC").html(datos.fotosMCMPM);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function cargarFotosEquipo(idEquipo) {
    var inputFileImage = document.getElementById("txtFotoEquipo");
    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idEquipo", idEquipo);

    var url = "php/planner_uploadfiles_equipo.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                obtenerFotosEquipo(idEquipo);
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function obtenerCotizacionesEquipo(idEquipo) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtenerCotizaciones&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#divHeaderCot").html(datos.header);
                $("#colCotEquipo").html(datos.cotizaciones);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function cargarCotizacionesEquipo(idEquipo) {
    var inputFileImage = document.getElementById("txtCotEquipo");
    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idEquipo", idEquipo);

    var url = "php/planner_uploadcot_equipo.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                obtenerCotizacionesEquipo(idEquipo);
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}


function eliminarCotEquipo(idEquipo, idCot, nombreCot) {
    var action = "eliminarCotEquipo"
    $.ajax({
        type: "POST",
        url: "php/crud.php",
        data: {
            action: action,
            idCot: idCot,
            nombreCot: nombreCot
        },
        success: function (response) {
            alertInformacionActualiza(response);
            obtenerCotizacionesEquipo(idEquipo)
        }
    });
}


function obtenerInfoEquipo(idEquipo) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtenerInfo&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#rowInfoEquipo").show();
                $("#rowEditarInfo").hide();
                $("#divHeaderInfo").html(datos.header);
                $("#colInfoEquipo").html(datos.informacion);
                $("#colEditarInfo").html(datos.editarInfo);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function editarInfoEquipo() {
    $("#rowInfoEquipo").hide();
    $("#rowEditarInfo").show();
}

function actualizarInfoEquipo(idEquipo) {
    var marca = $("#cbEditMarca").val();
    var modelo = $("#txtEditModelo").val();
    var serie = $("#txtEditSerie").val();
    var estado = $("#cbEditStatus").val();

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=actualizarInfoEq&idEquipo=" +
            idEquipo +
            "&marca=" +
            marca +
            "&modelo=" +
            modelo +
            "&serie=" +
            serie +
            "&estado=" +
            estado,
        success: function (data) {
            if (data == 1) {
                obtenerInfoEquipo(idEquipo);
                toastr.success("Informacion actualizada", "Correcto!", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            } else {
                toastr.error(data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//*********************************************
//TARES GENERALES DE AREA
function obtDetalleSubcategoria(
    idGrupo,
    idDestino,
    idCategoria,
    idSubcategoria,
    idRelSubcategoria
) {
    var idEquipo = 0;
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=4&idSubseccion=" +
            idGrupo +
            "&idDestino=" +
            idDestino +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria +
            "&idRelSubcategoria=" +
            idRelSubcategoria,
        success: function (data) {
            try {
                var detalleEquipo = JSON.parse(data);
                $("#divListaTareas").html("");
                $("#divListaTareas").html(detalleEquipo.planMC);
                $("#btnPendientesPA").attr(
                    "onclick",
                    "verPenSubcategorias(this, " +
                    idDestino +
                    ", " +
                    idGrupo +
                    ", " +
                    idCategoria +
                    "," +
                    idSubcategoria +
                    ")"
                );
                $("#btnSolucionadosPA").attr(
                    "onclick",
                    "verPenSubcategorias(this, " +
                    idDestino +
                    ", " +
                    idGrupo +
                    ", " +
                    idCategoria +
                    "," +
                    idSubcategoria +
                    ")"
                );
                $("#txtTarea").attr(
                    "onkeypress",
                    "agregarTarea(" +
                    idEquipo +
                    ", " +
                    idGrupo +
                    ", " +
                    idDestino +
                    ", " +
                    idSubcategoria +
                    ", " +
                    idCategoria +
                    ")"
                );
                $("#hddIdEquipo").val(idEquipo);
                $("#hddIdDestino").val(idDestino);
                $("#hddIdSubseccion").val(idGrupo);
                $("#hddIdCategoria").val(idCategoria);
                $("#hddIdSubcategoria").val(idSubcategoria);
            } catch (ex) {
                toastr.error(data, ex, {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function obtCorrectivosG(
    idGrupo,
    idDestino,
    idCategoria,
    idSubcategoria,
    idRelSubcategoria,
    status
) {
    $("#hddIdEquipo").val(0);
    $("#hddIdDestino").val(idDestino);
    $("#hddIdCategoria").val(idCategoria);
    $("#hddIdSubseccion").val(idGrupo);
    $("#hddIdSubcategoria").val(idSubcategoria);
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtMCG&idSubseccion=" +
            idGrupo +
            "&idDestino=" +
            idDestino +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria +
            "&idRelSubcategoria=" +
            idRelSubcategoria +
            "&status=" +
            status,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#colMC").html("");
                $("#colMC").html(datos.correctivos);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function obtDetalleTarea(idTarea) {
    $("#txtComentario").attr(
        "onkeypress",
        "insertarComentario(" + idTarea + ", this);"
    );
    $("#txtArchivo").attr("onchange", "cargar_archivos_mc(" + idTarea + ");");
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=6&idTarea=" + idTarea,
        success: function (data) {
            var datos = JSON.parse(data);
            $("#hddIDTarea").val(idTarea);
            $("#tituloTarea").html(datos.actividad);
            $("#txtEditTituloTarea").val(datos.actividad);
            $("#btnActualizarTarea").attr(
                "onclick",
                "actualizarTarea(" + idTarea + ")"
            );
            $("#timeLine").html(datos.timeLine);
            var chkb = document.getElementById("chkbEliminarTarea");
            chkb.checked = false;

            var config = {
                language: "es",
                range: true,
                toggleSelected: false,
                multipleDatesSeparator: " - ",
            };

            var dp = $("#myDatePicker").datepicker(config).data("datepicker");
            if (datos.fechaInicio != null && datos.fechaFin != null) {
                dp.selectDate([
                    new Date("" + datos.fechaInicio + ""),
                    new Date("" + datos.fechaFin + ""),
                ]);
            }
            //            else{
            //                dp.destroy();
            //                var dp = $('#myDatePicker').datepicker(config).data('datepicker');
            //            }
        },
    });
}

function actualizarTarea(idTarea) {
    var chkb = document.getElementById("chkbEliminarTarea");
    if (chkb.checked) {
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=eliminarTarea&idTarea=" + idTarea + "&titulo=" + titulo,
            success: function (data) {
                if (data == 1) {
                    var idDestino = $("#hddIdDestino").val();
                    var idGrupo = $("#hddIdSubseccion").val();
                    var idCategoria = $("#hddIdCategoria").val();
                    var idSubcategoria = $("#hddIdSubcategoria").val();
                    recargarListaTareas(idGrupo, idDestino, idCategoria, idSubcategoria);
                    showDetallesTarea("");
                    closeModal("modal-editar-tarea");
                } else {
                    toastr.error(data, "Error:", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    } else {
        var titulo = $("#txtEditTituloTarea").val();
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=actualizarTarea&idTarea=" + idTarea + "&titulo=" + titulo,
            success: function (data) {
                if (data == 1) {
                    obtDetalleTarea(idTarea);
                    closeModal("modal-editar-tarea");
                } else {
                    toastr.error(data, "Error:", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    }
}

function verPenSubcategorias(
    element,
    idDestino,
    idSubseccion,
    idCategoria,
    idSubcategoria
) {
    var idCHKB = element.id;

    if (idCHKB == "btnPendientesPA") {
        $("#btnPendientesPA").removeClass("is-outlined");
        $("#btnSolucionadosPA").addClass("is-outlined");
    } else {
        $("#btnPendientesPA").addClass("is-outlined");
        $("#btnSolucionadosPA").removeClass("is-outlined");
    }

    if (idCHKB == "btnPendientesPA") {
        var status = "N";
    } else {
        var status = "F";
    }

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=5&idDestino=" +
            idDestino +
            "&idSubseccion=" +
            idSubseccion +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria +
            "&status=" +
            status,
        success: function (data) {
            $("#divListaTareas").html(data);
        },
    });
}

function insertarComentario(idTarea, element) {
    var comentario = element.value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: "post",
                url: "php/plannerPHP.php",
                data: "action=7&idTarea=" + idTarea + "&comentario=" + comentario,

                success: function (data) {
                    if (data == 1) {
                        $("#" + element.id + "").val("");
                        actualizarTimeLine(idTarea);
                    } else {
                        toastr.warning(data, "Aviso", {
                            closeButton: true,
                            newestOnTop: true,
                            positionClass: "toast-top-center",
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        });
                    }
                },
            });
        } else {
            toastr.warning("El campo comentario no debe estar vacio", "Aviso", {
                closeButton: true,
                newestOnTop: true,
                positionClass: "toast-top-center",
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            });
        }
    }
}

function actualizarTimeLine(idTarea) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=8&idTarea=" + idTarea,
        success: function (data) {
            $("#timeLine").html(data);
            $("#timeLineMC").html(data);
        },
    });
}

function cargar_archivos_mc(idTarea) {
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();

    var inputFileImage = document.getElementById("txtArchivo");

    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idTarea", idTarea);

    var url = "php/planner_uploadfiles.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                actualizarTimeLine(idTarea);
                recargarListaTareas(
                    idSubseccion,
                    idDestino,
                    idCategoria,
                    idSubcategoria
                );
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                actualizarTimeLine(idTarea);
                recargarListaTareas(
                    idSubseccion,
                    idDestino,
                    idCategoria,
                    idSubcategoria
                );
            }

            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        },
    });
}

function actualizarRangoFechas(idTarea, fd) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=9&idTarea=" + idTarea + "&fechas=" + fd,
        success: function (data) { },
    });
}

function buscarUsuario(element, idDestino) {
    var palabra = element.value;
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=10&idDestino=" + idDestino + "&palabra=" + palabra,
        success: function (data) {
            $("#divListaUsuarios").html(data);
        },
    });
}

function agregarResponsable(idUsuario) {
    var idActividad = $("#hddIdActividad").val();
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();
    var idRelSubcategoria = 0;
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=11&idUsuario=" + idUsuario + "&idActividad=" + idActividad,
        success: function (data) {
            if (data == 1) {
                if (idEquipo != 0) {
                    //recargarListaTareasMC(idEquipo);
                    obtCorrectivos(idEquipo, "N");
                } else {
                    obtCorrectivosG(
                        idSubseccion,
                        idDestino,
                        idCategoria,
                        idSubcategoria,
                        idRelSubcategoria,
                        "N"
                    );
                    //recargarListaTareas(idSubseccion, idDestino, idCategoria, idSubcategoria);
                }

                closeModal("modalAgregarResponsable");
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function setIdActividad(idActividad) {
    $("#hddIdActividad").val(idActividad);
}

function recargarListaTareas(idGrupo, idDestino, idCategoria, idSubcategoria) {
    if ($("#btnPendientesPA").hasClass("is-outlined")) {
        var status = "F";
    } else {
        var status = "N";
    }

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=5&idDestino=" +
            idDestino +
            "&idSubseccion=" +
            idGrupo +
            "&idCategoria=" +
            idCategoria +
            "&idSubcategoria=" +
            idSubcategoria +
            "&status=" +
            status,
        success: function (data) {
            $("#divListaTareas").html(data);
        },
    });
}

function completarTarea(idActividad, element, idUsuario) {
    //        var chkb = element.checked;
    //        var idCheckbox = element.id;

    showModal("modalConfirmacionTarea");

    //    $("#modal-completar-tarea").modal('show');
    $("#btnFinalizarTarea").attr(
        "onclick",
        "finalizarTarea(" + idActividad + "," + "'chkb'" + "," + idUsuario + ")"
    );
    //$("#btnCancelarFinalizarTarea").attr("onclick", "cancelarCompletarTarea(" + idCheckbox + "); closeModal('modalConfirmacionTarea');");
}

function cancelarCompletarTarea(idCheckbox) {
    if ($("#btnPendientesPA").hasClass("is-outlined")) {
        var status = "F";
        idCheckbox.checked = true;
    } else {
        var status = "N";
        idCheckbox.checked = false;
    }
}

function finalizarTarea(idActividad, chkb, idUsuario) {
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();
    //var chkb = element.checked;
    //        if (chkb == true) {
    //            var status = "F";
    //        } else {
    //            var status = "N";
    //        }
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=12&idActividad=" +
            idActividad +
            "&status=F&completo=" +
            idUsuario,
        success: function (data) {
            if (data == 1) {
                if (idEquipo != 0) {
                    //recargarListaTareasMC(idEquipo)
                    obtCorrectivos(idEquipo, "N");
                } else {
                    recargarListaTareas(
                        idSubseccion,
                        idDestino,
                        idCategoria,
                        idSubcategoria
                    );
                }

                closeModal("modalConfirmacionTarea");
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function agregarTarea(idEquipo) {
    //    if (event.keyCode == 13) {
    //        if (idEquipo != 0) {
    //            var actividad = $("#txtTareaMC").val();
    //        } else {
    //            var actividad = $("#txtTarea").val();
    //        }

    var idDestino = $("#hddIdDestino").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();
    var idRelSubcategoria = 0;
    var actividad = $("#txtTituloTareaMC").val();

    if (actividad != "") {
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=13&idEquipo=" +
                idEquipo +
                "&actividad=" +
                actividad +
                "&idGrupo=" +
                idSubseccion +
                "&idDestino=" +
                idDestino +
                "&idCategoria=" +
                idCategoria +
                "&idSubcategoria=" +
                idSubcategoria,
            success: function (data) {
                if (data == 1) {
                    if (idEquipo != 0) {
                        obtCorrectivos(idEquipo, "N");
                        //recargarListaTareasMC(idEquipo);
                        $("#txtTituloTareaMC").val("");
                    } else {
                        obtCorrectivosG(
                            idSubseccion,
                            idDestino,
                            idCategoria,
                            idSubcategoria,
                            idRelSubcategoria,
                            "N"
                        );
                        //recargarListaTareas(idSubseccion, idDestino, idCategoria, idSubcategoria);
                        $("#txtTituloTareaMC").val("");
                    }
                } else {
                    toastr.error(data, "Error", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    } else {
        toastr.error("El campo no debe estar vacio", "Error", {
            closeButton: true,
            newestOnTop: true,
            positionClass: "toast-top-center",
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });
    }

    //    }
}

//*********************************************
//TAREAS MC MP DE EQUIPO
function obtDetalleEquipo(
    idEquipo,
    idGrupo,
    idDestino,
    idCategoria,
    idSubcategoria
) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=14&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var detalleEquipo = JSON.parse(data);
                $("#btnPendientesMC").attr(
                    "onclick",
                    "verPenSolMC(this, " + idEquipo + ")"
                );
                $("#btnSolucionadosMC").attr(
                    "onclick",
                    "verPenSolMC(this, " + idEquipo + ")"
                );
                $("#txtArchivoEquipo").attr("onchange", "cargar_archivos_eq()");
                $("#txtTareaMC").attr(
                    "onkeypress",
                    "agregarTarea(" +
                    idEquipo +
                    ", " +
                    idGrupo +
                    ", " +
                    idDestino +
                    ", " +
                    idSubcategoria +
                    ", " +
                    idCategoria +
                    ")"
                );
                $("#txtNombreEq").html(detalleEquipo.nombre);
                $("#txtDestinoEq").html(detalleEquipo.destino);
                $("#txtTipoEq").html(detalleEquipo.tipo);
                $("#txtMatriculaEq").html(detalleEquipo.matricula);
                $("#txtCECOEq").html(detalleEquipo.CECO);
                $("#txtSeccionEq").html(detalleEquipo.seccion);
                $("#txtSubseccionEq").html(detalleEquipo.subseccion);
                $("#txtMarcaEq").html(detalleEquipo.marca);
                $("#txtSerieEq").html(detalleEquipo.serie);
                $("#txtStatusEq").html(detalleEquipo.statusEquipo);
                $("#txtJerarquiaEq").html(detalleEquipo.jerarquia);
                $("#columnaCorrectivos").html(detalleEquipo.tareasMC);
                $("#columnaPreventivos").html(detalleEquipo.planeacionMP);
                $("#adjuntosEquipo").html(detalleEquipo.adjuntos);
                $("#timeLineHistorialOT").html(detalleEquipo.historialOT);
                $("#hddIdEquipo").val(idEquipo);
                $("#hddIdDestino").val(idDestino);
                $("#hddIdSubseccion").val(idGrupo);
                $("#hddIdCategoria").val(idCategoria);
                $("#hddIdSubcategoria").val(idSubcategoria);
            } catch (ex) {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//Obtener la lista de tareas correctivas de cada equipo
function obtCorrectivos(idEquipo, status) {
    $("#hddIdEquipo").val(idEquipo);
    $("#hddIdCategoria").val(1);
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtMC&idEquipo=" + idEquipo + "&status=" + status,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#colMC").html("");
                $("#colMC").html(datos.correctivos);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//Obtener los comentarios de una tarea correctivo
function obtComentariosMC(idMC) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtenerComentariosMC&idMC=" + idMC,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#divHeaderComentarios").html(datos.header);
                $("#colComentariosEquipo").html(datos.comentariosGenerales);
                $("#colComentariosEquipoMCMP").hide();
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//Insertar comentario en la tarea de correctivo
function agregarComentarioMC(idMC) {
    var comentario = $("#txtComentariosMC").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=insertarComentarioMC&idMC=" + idMC + "&comentario=" + comentario,
        success: function (data) {
            if (data == 1) {
                obtComentariosMC(idMC);
            } else {
                toastr.error(data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function borrarComentariosMC(idComentario, idMC) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=borrarComentario&idComentario=" + idComentario,
        success: function (data) {
            if (data == 1) {
                obtComentariosMC(idMC);
            } else {
                toastr.error(data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//Obtener las fotos de las tareas
function obtenerFotosMC(idMC) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtenerFotosMC&idMC=" + idMC,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#divHeaderFotos").html(datos.header);
                $("#colFotosEquipo").html(datos.fotosGenerales);
                $("#colFotosMPMC").hide();
                //$("#colFotosMPMC").html(datos.fotosMCMPM);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//Insertar fotos a la tarea
function cargarFotosMC(idMC) {
    var inputFileImage = document.getElementById("txtFotoMC");
    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idMC", idMC);

    var url = "php/planner_uploadfiles.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                obtenerFotosMC(idMC);
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function borrarFotosMC(idAdjunto, idMC) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=borrarFotoMC&idAdjunto=" + idAdjunto,
        success: function (data) {
            if (data == 1) {
                obtenerFotosMC(idMC);
            } else {
                toastr.error(data, "Error:", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//Obtener fechas de incio y fin de una tarea
function obtenerFechasMC(idMC) {
    $("#hddIDTarea").val(idMC);
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtFechasMC&idMC=" + idMC,
        success: function (data) {
            var datos = JSON.parse(data);
            var config = {
                language: "es",
                range: true,
                toggleSelected: false,
                multipleDatesSeparator: " - ",
            };

            var dp = $("#myDatePickerMC").datepicker(config).data("datepicker");
            if (datos.fechaInicio != null && datos.fechaFin != null) {
                dp.selectDate([
                    new Date("" + datos.fechaInicio + ""),
                    new Date("" + datos.fechaFin + ""),
                ]);
            }
        },
    });
}

function obtPreventivos(
    idEquipo,
    idGrupo,
    idDestino,
    idCategoria,
    idSubcategoria
) {
    $("#hddIdEquipo").val(idEquipo);
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtMP&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#colMP").html("");
                $("#inicioMP").hide();
                $("#divDetalleOT").hide();
                $("#divHistorialMP").show();
                $("#colMP").html(datos.preventivos);
                $("#timeLineHistorialOT").html(datos.historicoMP);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function obtTest(idEquipo, idGrupo, idDestino, idCategoria, idSubcategoria) {
    $("#hddIdEquipo").val(idEquipo);
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=obtTEST&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#colMP").html("");
                $("#inicioMP").hide();
                $("#divDetalleOT").hide();
                $("#divHistorialMP").show();
                $("#colMP").html(datos.preventivos);
                $("#timeLineHistorialOT").html(datos.historicoMP);
            } catch (ex) {
                toastr.error(ex + " - " + data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//TAREAS MC MP DE EQUIPO
//*********************************************

function obtDetalleTareaMC(idTarea) {
    $("#txtComentarioMC").attr(
        "onkeypress",
        "insertarComentario(" + idTarea + ", this);"
    );
    $("#txtArchivoMC").attr(
        "onchange",
        "cargar_archivos_mc_eq(" + idTarea + ");"
    );
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=6&idTarea=" + idTarea,
        success: function (data) {
            var datos = JSON.parse(data);
            $("#hddIDTarea").val(idTarea);
            $("#tituloTareaMC").html(datos.actividad);
            $("#timeLineMC").html(datos.timeLine);
            $("#txtEditTituloTarea").val(datos.actividad);
            $("#btnActualizarTarea").attr(
                "onclick",
                "actualizarTareaMC(" + idTarea + ")"
            );
            var chkb = document.getElementById("chkbEliminarTarea");
            chkb.checked = false;

            var config = {
                language: "es",
                range: true,
                toggleSelected: false,
                multipleDatesSeparator: " - ",
            };

            var dp = $("#myDatePickerMC").datepicker(config).data("datepicker");
            if (datos.fechaInicio != null && datos.fechaFin != null) {
                dp.selectDate([
                    new Date("" + datos.fechaInicio + ""),
                    new Date("" + datos.fechaFin + ""),
                ]);
            }
            //            else{
            //                dp.destroy();
            //                var dp = $('#myDatePicker').datepicker(config).data('datepicker');
            //            }
        },
    });
}

function actualizarTareaMC(idTarea) {
    var chkb = document.getElementById("chkbEliminarTarea");
    if (chkb.checked) {
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=eliminarTarea&idTarea=" + idTarea + "&titulo=" + titulo,
            success: function (data) {
                if (data == 1) {
                    var idEquipo = $("#hddIdEquipo").val();
                    recargarListaTareasMC(idEquipo);
                    showDetallesTareaMC("");
                    closeModal("modal-editar-tarea");
                } else {
                    toastr.error(data, "Error:", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    } else {
        var titulo = $("#txtEditTituloTarea").val();
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=actualizarTarea&idTarea=" + idTarea + "&titulo=" + titulo,
            success: function (data) {
                if (data == 1) {
                    obtDetalleTareaMC(idTarea);
                    closeModal("modal-editar-tarea");
                } else {
                    toastr.error(data, "Error:", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    }
}

function cargar_archivos_mc_eq(idTarea) {
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();

    var inputFileImage = document.getElementById("txtArchivoMC");
    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idTarea", idTarea);

    var url = "php/planner_uploadfiles.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                actualizarTimeLine(idTarea);
                recargarListaTareasMC(idEquipo);
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                actualizarTimeLine(idTarea);
                recargarListaTareasMC(
                    idSubseccion,
                    idDestino,
                    idCategoria,
                    idSubcategoria
                );
            }

            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        },
    });
}

function recargarListaTareasMC(idEquipo) {
    if ($("#btnPendientesMC").hasClass("is-outlined")) {
        var status = "F";
    } else {
        var status = "N";
    }

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=15&idEquipo=" + idEquipo + "&status=" + status,
        success: function (data) {
            $("#columnaCorrectivos").html(data);
        },
    });
}

function verPenSolMC(element, idEquipo) {
    var idCHKB = element.id;

    if (idCHKB == "btnPendientesMC") {
        $("#btnPendientesMC").removeClass("is-outlined");
        $("#btnSolucionadosMC").addClass("is-outlined");
    } else {
        $("#btnPendientesMC").addClass("is-outlined");
        $("#btnSolucionadosMC").removeClass("is-outlined");
    }

    if (idCHKB == "btnPendientesMC") {
        var status = "N";
    } else {
        var status = "F";
    }

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=15&idEquipo=" + idEquipo + "&status=" + status,
        success: function (data) {
            $("#columnaCorrectivos").html(data);
        },
    });
}

function verDetalleMP(idPlan, semana, nombreplan, idPlaneacion, tipoplan) {
    var idEquipo = $("#hddIdEquipo").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=16&idPlan=" + idPlan,
        success: function (data) {
            $("#titulomp").html("" + nombreplan + ", " + semana);
            $("#btnGenerarOT").attr(
                "onclick",
                "generarOrdenTrabajo(" +
                idPlan +
                ", " +
                idPlaneacion +
                ",'', '" +
                tipoplan +
                "')"
            );
            $("#ulActividades").html(data);
            $("#hddidPlanMP").val(idPlan);
            $("#hddidPlaneacion").val(idPlaneacion);

            $("#btnImprimirOT").attr(
                "onclick",
                "window.open('planner/orden-trabajo.php?idEquipo=" +
                idEquipo +
                "&idPlanMP=" +
                idPlan +
                "&idPlaneacion=" +
                idPlaneacion +
                ")"
            );
        },
    });
}

function generarOrdenTrabajo(idPlanMP, idPlaneacionMP, modal, tipoplan) {
    var idEquipo = $("#hddIdEquipo").val();
    window.open(
        "planner/orden-trabajo.php?idEquipo=" +
        idEquipo +
        "&idPlanMP=" +
        idPlanMP +
        "&idPlaneacion=" +
        idPlaneacionMP
    );

    setTimeout(function () {
        $("#inicioMP").hide();
        if (tipoplan == "TEST") {
            obtTest(idEquipo, 0, 0, 0, 0);
        } else {
            obtPreventivos(idEquipo, 0, 0, 0, 0);
        }

        mostrarDetalleOT(idPlaneacionMP, idEquipo);
        $("#divDetalleOT").show();
    }, 1000);
}

function mostrarDetalleOT(idPlaneacion, idEquipo, tipoplan) {
    $("#columnaPreventivos").hide();
    $("#columnaHistorialMP").hide();
    $("#inicioMP").hide();
    $("#divDetalleOT").show();

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=17&idEquipo=" + idEquipo + "&idPlaneacion=" + idPlaneacion,
        success: function (data) {
            try {
                var datos = JSON.parse(data);
                $("#btnImprimirOT").attr(
                    "onclick",
                    "imprimirOT(" + idEquipo + ", " + datos.id + ")"
                );
                $("#btnFinalizarOT").attr(
                    "onclick",
                    "marcarOTRealizada(" + datos.id + ", '" + tipoplan + "')"
                );
                $("#txtComentarioOT").attr(
                    "onkeypress",
                    "insertarComentarioOT(this, " + datos.id + ");"
                );
                $("#txtArchivoOT").attr(
                    "onchange",
                    "cargar_archivos_ot(" + datos.id + ");"
                );
                if (datos.status == "Finalizado") {
                    $("#statusOT").removeClass("is-warning");
                    $("#statusOT").addClass("is-success");
                } else {
                    $("#statusOT").addClass("is-warning");
                    $("#statusOT").removeClass("is-success");
                }
                $("#statusOT").html(datos.status);
                $("#folioOT").html(datos.folio);
                $("#txtResponsable").html(datos.realizadoPor);
                $("#txtFechaRealizado").html(datos.fechaRealizado);
                $("#listaActividadesMP").html(datos.listActividades);
                $("#timeLineOT").html(datos.timeLine);
            } catch (ex) {
                toastr.error(data, "Aviso", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function selectAll(element, idPM) {
    if (element.checked) {
        var chkbs = document.getElementsByName("listchkbOT_" + idPM);
        for (i = 0; i < chkbs.length; i++) {
            chkbs[i].checked = true;
        }
    } else {
        var chkbs = document.getElementsByName("listchkbOT_" + idPM);
        for (i = 0; i < chkbs.length; i++) {
            chkbs[i].checked = false;
        }
    }
}

function insertarComentarioOT(element, idOT) {
    var comentario = element.value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: "post",
                url: "php/plannerPHP.php",
                data: "action=18&idOT=" + idOT + "&comentario=" + comentario,

                success: function (data) {
                    if (data == 1) {
                        $("#" + element.id + "").val("");
                        actualizarTimeLineOT(idOT);
                    } else {
                        toastr.warning(data, "Aviso", {
                            closeButton: true,
                            newestOnTop: true,
                            positionClass: "toast-top-center",
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        });
                    }
                },
            });
        } else {
            toastr.warning("El campo comentario no debe estar vacio", "Aviso", {
                closeButton: true,
                newestOnTop: true,
                positionClass: "toast-top-center",
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            });
        }
    }
}

function actualizarTimeLineOT(idOT) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=19&idOT=" + idOT,
        success: function (data) {
            $("#timeLineOT").html(data);
        },
    });
}

function cargar_archivos_ot(idOT) {
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();

    var inputFileImage = document.getElementById("txtArchivoOT");

    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idOT", idOT);

    var url = "php/planner_uploadfiles_ot.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data != -1) {
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                actualizarTimeLineOT(idOT);
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                actualizarTimeLineOT(idOT);
            }

            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        },
    });
}

function imprimirOT(idEquipo, idOT) {
    window.open(
        "planner/ver-orden-trabajo.php?idEquipo=" + idEquipo + "&idOT=" + idOT
    );
}

function cerrarOT(idModal) {
    var listaActividades = [];
    $("input:checkbox:checked").each(function () {
        try {
            if ($(this).attr("name")) {
                var chkb = $(this).attr("name");

                var datos = chkb.split("_");

                var namechkb = datos[0];
                if (namechkb == "listchkbPMOT") {
                    var idPM = datos[1];
                } else {
                    var idPM = datos[1];
                    var idchkb = $(this).attr("id");
                    var data = idchkb.split("_");
                    if (data[1] != undefined) {
                        listaActividades.push(data[1]);
                    }
                }
            }
        } catch (ex) {
            alert(ex);
        }
    });

    if (listaActividades.length > 0) {
        showModal(idModal);
    } else {
        toastr.error("Debe de marcar al menos una actividad", "Error", {
            closeButton: true,
            newestOnTop: true,
            positionClass: "toast-top-center",
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });
    }
}

function marcarOTRealizada(idOT, tipoplan) {
    var listaActividades = [];
    $("input:checkbox:checked").each(function () {
        try {
            if ($(this).attr("name")) {
                var chkb = $(this).attr("name");

                var datos = chkb.split("_");

                var namechkb = datos[0];
                if (namechkb == "listchkbPMOT") {
                    var idPM = datos[1];
                } else {
                    var idPM = datos[1];
                    var idchkb = $(this).attr("id");
                    var data = idchkb.split("_");
                    if (data[1] != undefined) {
                        listaActividades.push(data[1]);
                    }
                }
            }
        } catch (ex) {
            alert(ex);
        }
    });

    var idUsuario = $("#cbResponsableMP").val();
    var fechaFin = $("#txtFechaRealizacion").val();
    var idEquipo = $("#hddIdEquipo").val();

    if (idUsuario != 0 && fechaFin != "" && listaActividades.length > 0) {
        var datos = new FormData();
        datos.append("realizadoPor", idUsuario);
        datos.append("fechaRealizado", fechaFin);
        datos.append("action", "20");
        datos.append("idOT", idOT);
        datos.append("lstActividades", JSON.stringify(listaActividades));
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: datos,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data) {
                if (data == 1) {
                    if (tipoplan == "TEST") {
                        obtTest(idEquipo, 0, 0, 0, 0);
                    } else {
                        obtPreventivos(idEquipo, 0, 0, 0, 0);
                    }

                    //$("#btnFinalizarOT").attr("disabled", "true");
                    //                    recargarGraficaMP();
                    closeModal("modalFinalizarOT");
                    toastr.success("Se ha cerrado la OT!", "Finalizado", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                } else {
                    toastr.error(data, "Error", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    }
}

function recargarGraficaMP() {
    var idEquipo = $("#hddIdEquipo").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=14&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var detalleEquipo = JSON.parse(data);

                $("#columnaPreventivos").html(detalleEquipo.planeacionMP);
            } catch (ex) {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function cargar_archivos_eq() {
    var idEquipo = $("#hddIdEquipo").val();

    var inputFileImage = document.getElementById("txtArchivoEquipo");
    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idEquipo", idEquipo);

    var url = "php/planner_uploadfiles_equipo.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });

                actualizarAdjuntos(idEquipo);
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function actualizarAdjuntos(idEquipo) {
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=14&idEquipo=" + idEquipo,
        success: function (data) {
            try {
                var detalleEquipo = JSON.parse(data);
                $("#adjuntosEquipo").html(detalleEquipo.adjuntos);
            } catch (ex) {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//*****************************
//*         PROYECTOS         *
//*****************************

function setProyectos(idSeccion, idSubseccion) {
    $("#idSeccionHdd").val(idSeccion);
    $("#idSubseccionHdd").val(idSubseccion);
    //$("#idCategoriaHdd").val(idCategoria);
}

function proyectos(element) {
    var tipoProyecto = element.value;
    if (tipoProyecto == "PROYECTO") {
        $("#divDetalleCAP").hide();
    } else {
        $("#divDetalleCAP").show();
    }
}

function agregarProyecto(idDestino, idPermiso, idUsuario) {
    var idSeccion = $("#idSeccionHdd").val();
    var idSubseccion = $("#idSubseccionHdd").val();
    //var idCategoria = $("#idCategoriaHdd").val();
    var tituloProyecto = $("#txtTituloProy").val();
    var justificacion = $("#txtJustificacionProy").val();
    var tipoProyecto = $("#cbTipoProyectoN").val();
    if (tipoProyecto != "PROYECTO") {
        var coste = $("#txtCosteN").val();
        var año = $("#txtAñoN").val();
        var inputFileImage = document.getElementById("txtAdjuntoProyectoN");
        var file = inputFileImage.files[0];
    } else {
        var coste = "";
        var año = "";
        var file = "";
    }

    var datos = new FormData();
    datos.append("fileToUpload", file);
    datos.append("idDestino", idDestino);
    datos.append("idSeccion", idSeccion);
    datos.append("idSubseccion", idSubseccion);
    //datos.append('idCategoria', idCategoria);
    datos.append("tituloProyecto", tituloProyecto);
    datos.append("justificacion", justificacion);
    datos.append("tipoProyecto", tipoProyecto);
    datos.append("coste", coste);
    datos.append("año", año);
    datos.append("action", "40");

    if (tituloProyecto != "" && tipoProyecto != "") {
        if (tipoProyecto != "PROYECTO") {
            if (año != "" && coste != "") {
                $.ajax({
                    type: "post",
                    url: "php/plannerPHP.php",
                    data: datos,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function (data) {
                        if (data == 1) {
                            toastr.success("Proyecto creado", "Correcto", {
                                closeButton: true,
                                newestOnTop: true,
                                positionClass: "toast-top-center",
                                showDuration: "300",
                                hideDuration: "1000",
                                timeOut: "5000",
                                extendedTimeOut: "1000",
                                showEasing: "swing",
                                hideEasing: "linear",
                                showMethod: "fadeIn",
                                hideMethod: "fadeOut",
                            });
                            closeModal("modalCrearProyecto");
                            mostrarColumnasSeccion(idPermiso, idUsuario);
                            //recargarMP(idEquipo);
                            //$("#modal-agregar-proyecto").modal('hide');
                        } else {
                            toastr.error(data, "Error", {
                                closeButton: true,
                                newestOnTop: true,
                                positionClass: "toast-top-center",
                                showDuration: "300",
                                hideDuration: "1000",
                                timeOut: "5000",
                                extendedTimeOut: "1000",
                                showEasing: "swing",
                                hideEasing: "linear",
                                showMethod: "fadeIn",
                                hideMethod: "fadeOut",
                            });
                        }
                    },
                });
            } else {
                toastr.error("Agregue el año y el coste", "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        } else {
            $.ajax({
                type: "post",
                url: "php/plannerPHP.php",
                data: datos,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function (data) {
                    if (data == 1) {
                        toastr.success("Proyecto creado", "Correcto", {
                            closeButton: true,
                            newestOnTop: true,
                            positionClass: "toast-top-center",
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        });
                        closeModal("modalCrearProyecto");
                        mostrarColumnasSeccion(idPermiso, idUsuario);
                        //recargarMP(idEquipo);
                        //$("#modal-agregar-proyecto").modal('hide');
                    } else {
                        toastr.error(data, "Error", {
                            closeButton: true,
                            newestOnTop: true,
                            positionClass: "toast-top-center",
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        });
                    }
                },
            });
        }
    } else {
        toastr.error("Indique el nombre y el tipo de proyecto", "Error", {
            closeButton: true,
            newestOnTop: true,
            positionClass: "toast-top-center",
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });
    }
}

function obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion) {
    var idEquipo = 0;
    $("#hddIdDestinoProy").val(idDestino);
    $("#hddIdSeccionProy").val(idSeccion);
    $("#hddIdSubseccionProy").val(idSubseccion);
    $("#hddIdProyecto").val(idProyecto);

    try {
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=22&idProyecto=" +
                idProyecto +
                "&idDestino=" +
                idDestino +
                "&idSeccion=" +
                idSeccion +
                "&idSubseccion=" +
                idSubseccion,
            success: function (data) {
                try {
                    var detalleProyecto = JSON.parse(data);
                    $("#btnPendientesPAProyecto").attr(
                        "onclick",
                        "verPendSolProyecto(this, " + idProyecto + ")"
                    );
                    $("#btnSolucionadosPAProyecto").attr(
                        "onclick",
                        "verPendSolProyecto(this, " + idProyecto + ")"
                    );
                    $("#txtActividadPA").attr(
                        "onkeypress",
                        "agregarActividadMCProyecto(" +
                        idProyecto +
                        ", " +
                        idDestino +
                        ", " +
                        idSeccion +
                        ", " +
                        idSubseccion +
                        ")"
                    );

                    $("#txtCotProyecto").attr(
                        "onchange",
                        "upload_cots_proyecto(" +
                        idProyecto +
                        ", " +
                        idDestino +
                        ", " +
                        idSeccion +
                        ", " +
                        idSubseccion +
                        ")"
                    );
                    $("#txtJustificacionProyecto").attr(
                        "onchange",
                        "upload_just_proyecto(" +
                        idProyecto +
                        ", " +
                        idDestino +
                        ", " +
                        idSeccion +
                        ", " +
                        idSubseccion +
                        ")"
                    );
                    $("#txtTituloProyecto").attr(
                        "onkeypress",
                        "actualizarDatosProyecto(" + idProyecto + ")"
                    );
                    $("#txtJustificacion").attr(
                        "onkeypress",
                        "actualizarDatosProyecto(" + idProyecto + ")"
                    );
                    $("#txtAñoProyecto").attr(
                        "onkeypress",
                        "actualizarDatosProyecto(" + idProyecto + ")"
                    );
                    $("#txtCosteProyecto").attr(
                        "onkeypress",
                        "actualizarDatosProyecto(" + idProyecto + ")"
                    );
                    $("#cbTipoProyecto").attr(
                        "onchange",
                        "cambiarTipo(" + idProyecto + ")"
                    );
                    $("#txtDestinoProyecto").html(detalleProyecto.destinoProyecto);
                    $("#txtTituloProyecto").val(detalleProyecto.titulo);
                    $("#cbTipoProyecto").val(detalleProyecto.tipo);
                    if (detalleProyecto.tipo == "PROYECTO") {
                        $("#divAñoProy").hide();
                        $("#divCosteProy").hide();
                    } else {
                        $("#divAñoProy").show();
                        $("#divCosteProy").show();
                        $("#txtAñoProyecto").val(detalleProyecto.año);
                        $("#txtCosteProyecto").val(detalleProyecto.coste);
                    }
                    $("#chkbProyF").attr("onchange", "completarProyecto(this);");
                    var chkbProyF = document.getElementById("chkbProyF");
                    if (detalleProyecto.status == "F") {
                        chkbProyF.checked = true;
                    } else {
                        chkbProyF.checked = false;
                    }
                    $("#txtJustificacion").val(detalleProyecto.justificacion);
                    $("#columnaPAProyectos").html(detalleProyecto.planAccion);
                    $("#txtComentarioProyecto").hide();
                    $("#timeLineComentariosProyecto").hide();
                    $("#timeLineComentariosProyecto").html(detalleProyecto.comentarios);
                    $("#timeLineAdjuntosProyecto").html(detalleProyecto.adjuntos);
                    $("#timeLineJustificacionesProyecto").html(
                        detalleProyecto.justificaciones
                    );
                } catch (ex) {
                    toastr.error(ex + " - " + data, "Error", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    } catch (ex) {
        toastr.error(ex, "Error", {
            closeButton: true,
            newestOnTop: true,
            positionClass: "toast-top-center",
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });
    }
}

function obtDetalleProyecto2(idProyecto, idDestino, idSeccion, idSubseccion) {
    $("#seccionTablaProyectos").hide();
    $("#seccionDetalleProyectos").show();
    var idEquipo = 0;
    $("#hddIdDestinoProy").val(idDestino);
    $("#hddIdSeccionProy").val(idSeccion);
    $("#hddIdSubseccionProy").val(idSubseccion);
    $("#hddIdProyecto").val(idProyecto);

    try {
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=22&idProyecto=" +
                idProyecto +
                "&idDestino=" +
                idDestino +
                "&idSeccion=" +
                idSeccion +
                "&idSubseccion=" +
                idSubseccion,
            success: function (data) {
                try {
                    var detalleProyecto = JSON.parse(data);
                    $("#btnPendientesPAProyecto").attr(
                        "onclick",
                        "verPendSolProyecto(this, " + idProyecto + ")"
                    );
                    $("#btnSolucionadosPAProyecto").attr(
                        "onclick",
                        "verPendSolProyecto(this, " + idProyecto + ")"
                    );
                    $("#txtActividadPA").attr(
                        "onkeypress",
                        "agregarActividadMCProyecto(" +
                        idProyecto +
                        ", " +
                        idDestino +
                        ", " +
                        idSeccion +
                        ", " +
                        idSubseccion +
                        ")"
                    );

                    $("#txtCotProyecto").attr(
                        "onchange",
                        "upload_cots_proyecto(" +
                        idProyecto +
                        ", " +
                        idDestino +
                        ", " +
                        idSeccion +
                        ", " +
                        idSubseccion +
                        ")"
                    );
                    $("#txtJustificacionProyecto").attr(
                        "onchange",
                        "upload_just_proyecto(" +
                        idProyecto +
                        ", " +
                        idDestino +
                        ", " +
                        idSeccion +
                        ", " +
                        idSubseccion +
                        ")"
                    );
                    $("#txtTituloProyecto").attr(
                        "onkeypress",
                        "actualizarDatosProyecto(" + idProyecto + ")"
                    );
                    $("#txtJustificacion").attr(
                        "onkeypress",
                        "actualizarDatosProyecto(" + idProyecto + ")"
                    );
                    $("#txtAñoProyecto").attr(
                        "onkeypress",
                        "actualizarDatosProyecto(" + idProyecto + ")"
                    );
                    $("#txtCosteProyecto").attr(
                        "onkeypress",
                        "actualizarDatosProyecto(" + idProyecto + ")"
                    );
                    $("#cbTipoProyecto").attr(
                        "onchange",
                        "cambiarTipo(" + idProyecto + ")"
                    );
                    $("#txtDestinoProyecto").html(detalleProyecto.destinoProyecto);
                    $("#txtTituloProyecto").val(detalleProyecto.titulo);
                    $("#cbTipoProyecto").val(detalleProyecto.tipo);
                    if (detalleProyecto.tipo == "PROYECTO") {
                        $("#divAñoProy").hide();
                        $("#divCosteProy").hide();
                    } else {
                        $("#divAñoProy").show();
                        $("#divCosteProy").show();
                        $("#txtAñoProyecto").val(detalleProyecto.año);
                        $("#txtCosteProyecto").val(detalleProyecto.coste);
                    }
                    $("#chkbProyF").attr("onchange", "completarProyecto(this);");
                    var chkbProyF = document.getElementById("chkbProyF");
                    if (detalleProyecto.status == "F") {
                        chkbProyF.checked = true;
                    } else {
                        chkbProyF.checked = false;
                    }
                    $("#txtJustificacion").val(detalleProyecto.justificacion);
                    $("#columnaPAProyectos").html(detalleProyecto.planAccion);
                    $("#txtComentarioProyecto").hide();
                    $("#timeLineComentariosProyecto").hide();
                    $("#timeLineComentariosProyecto").html(detalleProyecto.comentarios);
                    $("#timeLineAdjuntosProyecto").html(detalleProyecto.adjuntos);
                    $("#timeLineJustificacionesProyecto").html(
                        detalleProyecto.justificaciones
                    );
                } catch (ex) {
                    toastr.error(ex, "Error", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    } catch (ex) {
        toastr.error(ex, "Error", {
            closeButton: true,
            newestOnTop: true,
            positionClass: "toast-top-center",
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });
    }
}

function agregarActividadMCProyecto(
    idProyecto,
    idDestino,
    idSeccion,
    idSubseccion
) {
    if (event.keyCode == 13) {
        var actividad = $("#txtActividadPA").val();
        if (actividad != "") {
            $.ajax({
                type: "post",
                url: "php/plannerPHP.php",
                data: "action=23&idProyecto=" + idProyecto + "&actividad=" + actividad,
                success: function (data) {
                    if (data == 1) {
                        obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
                        $("#txtActividadPA").val("");
                    } else {
                        toastr.error(data, "Error", {
                            closeButton: true,
                            newestOnTop: true,
                            positionClass: "toast-top-center",
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        });
                    }
                },
            });
        } else {
            toastr.error("No se puede agregar activiades vacias", "Error", {
                closeButton: true,
                newestOnTop: true,
                positionClass: "toast-top-center",
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            });
        }
    }
}

function agregarComentariosProy(
    idProyecto,
    idDestino,
    idSeccion,
    idSubseccion
) {
    var url = "php/plannerPHP.php";
    var comentario = document.getElementById("txtComentarioProyecto").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: "post",
                url: url,
                data: "action=24&idProyecto=" + idProyecto + "&comentario=" + comentario,

                success: function (data) {
                    try {
                        document.getElementById("txtComentarioProyecto").value = "";
                        obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
                    } catch (ex) {
                        toastr.error(data, "Error", {
                            closeButton: true,
                            newestOnTop: true,
                            positionClass: "toast-top-center",
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        });
                    }
                },
            });
        } else {
            toastr.error("No puede enviar comentarios vacios", "Error", {
                closeButton: true,
                newestOnTop: true,
                positionClass: "toast-top-center",
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            });
        }
    }
}

function verComentariosActividad(idActividad, element) {
    var spanActividad = element.id;
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=33&idActividad=" + idActividad,
        success: function (data) {
            try {
                $(".titulo-actividad").removeClass(
                    "has-text-danger has-text-weight-bold"
                );
                $("#" + spanActividad + "").addClass(
                    "has-text-danger has-text-weight-bold"
                );

                $("#txtComentarioProyecto").attr(
                    "onkeypress",
                    "agregarComentariosActividad(" + idActividad + ", " + element.id + ")"
                );
                $("#txtComentarioProyecto").show();
                $("#timeLineComentariosProyecto").show();
                $("#timeLineComentariosProyecto").html(data);
            } catch (ex) {
                toastr.error(ex, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function agregarComentariosActividad(idActividad, element) {
    var url = "php/plannerPHP.php";
    var comentario = document.getElementById("txtComentarioProyecto").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: "post",
                url: url,
                data: "action=24&idActividad=" + idActividad + "&comentario=" + comentario,

                success: function (data) {
                    try {
                        document.getElementById("txtComentarioProyecto").value = "";
                        verComentariosActividad(idActividad, element);
                    } catch (ex) {
                        toastr.error(ex, "Error", {
                            closeButton: true,
                            newestOnTop: true,
                            positionClass: "toast-top-center",
                            showDuration: "300",
                            hideDuration: "1000",
                            timeOut: "5000",
                            extendedTimeOut: "1000",
                            showEasing: "swing",
                            hideEasing: "linear",
                            showMethod: "fadeIn",
                            hideMethod: "fadeOut",
                        });
                    }
                },
            });
        } else {
            toastr.error("No puede enviar comentarios vacios", "Error", {
                closeButton: true,
                newestOnTop: true,
                positionClass: "toast-top-center",
                showDuration: "300",
                hideDuration: "1000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
            });
        }
    }
}

function upload_cots_proyecto(idProyecto, idDestino, idSeccion, idSubseccion) {
    var inputFileImage = document.getElementById("txtCotProyecto");

    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append("fileToUpload", file);
    data.append("idProyecto", idProyecto);
    data.append("justificacion", "NO");

    var url = "php/planner_uploadfilesproyecto.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            try {
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
            } catch (ex) {
                toastr.error(ex, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function upload_just_proyecto(idProyecto, idDestino, idSeccion, idSubseccion) {
    var inputFileImage = document.getElementById("txtJustificacionProyecto");

    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append("fileToUpload", file);
    data.append("idProyecto", idProyecto);
    data.append("justificacion", "SI");

    var url = "php/planner_uploadfilesproyecto.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            try {
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
            } catch (ex) {
                toastr.error(ex, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function cambiarTipo(idProyecto) {
    var tipo = $("#cbTipoProyecto").val();
    if (tipo == "PROYECTO") {
        $("#divAñoProy").hide();
        $("#divCosteProy").hide();
    } else {
        $("#divAñoProy").show();
        $("#divCosteProy").show();
    }

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=25&idProyecto=" + idProyecto + "&tipo=" + tipo,
        success: function (data) {
            try {
                if (data == 1) {
                    toastr.success("", "Correcto", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                } else {
                    toastr.error(data, "Error", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            } catch (ex) {
                toastr.error(ex, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function actualizarDatosProyecto(idProyecto) {
    if (event.keyCode == 13) {
        var titulo = $("#txtTituloProyecto").val();
        var justificacion = $("#txtJustificacion").val();
        var año = $("#txtAñoProyecto").val();
        var coste = $("#txtCosteProyecto").val();

        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=26&idProyecto=" +
                idProyecto +
                "&titulo=" +
                titulo +
                "&justificacion=" +
                justificacion +
                "&año=" +
                año +
                "&coste=" +
                coste,
            success: function (data) {
                if (data == 1) {
                    toastr.success("", "Correcto", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                } else {
                    toastr.error(data, "Error", {
                        closeButton: true,
                        newestOnTop: true,
                        positionClass: "toast-top-center",
                        showDuration: "300",
                        hideDuration: "1000",
                        timeOut: "5000",
                        extendedTimeOut: "1000",
                        showEasing: "swing",
                        hideEasing: "linear",
                        showMethod: "fadeIn",
                        hideMethod: "fadeOut",
                    });
                }
            },
        });
    }
}

function agregarResponsableProyecto(idUsuario) {
    var idActividad = $("#hddIdActividad").val();
    //    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestinoProy").val();
    var idSeccion = $("#hddIdSeccionProy").val();
    var idSubseccion = $("#hddIdSubseccionProy").val();
    var idProyecto = $("#hddIdProyecto").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=27&idUsuario=" + idUsuario + "&idActividad=" + idActividad,
        success: function (data) {
            if (data == 1) {
                obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
                closeModal("modalAgregarResponsableProyecto");
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function buscarUsuarioProy(element, idDestino) {
    var palabra = element.value;
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=10&idDestino=" +
            idDestino +
            "&palabra=" +
            palabra +
            "&proyecto=SI",
        success: function (data) {
            $("#divListaUsuariosProy").html(data);
        },
    });
}

function verPendSolProyecto(element, idProyecto) {
    var idCHKB = element.id;

    if (idCHKB == "btnPendientesPAProyecto") {
        $("#btnPendientesPAProyecto").removeClass("is-outlined");
        $("#btnSolucionadosPAProyecto").addClass("is-outlined");
    } else {
        $("#btnPendientesPAProyecto").addClass("is-outlined");
        $("#btnSolucionadosPAProyecto").removeClass("is-outlined");
    }

    if (idCHKB == "btnPendientesPAProyecto") {
        var status = "N";
    } else {
        var status = "F";
    }

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=28&idProyecto=" + idProyecto + "&status=" + status,
        success: function (data) {
            $("#columnaPAProyectos").html(data);
        },
    });
}

function completarTareaProyecto(idActividad, element, idUsuario) {
    var chkb = element.checked;
    var idCheckbox = element.id;

    showModal("modalConfirmacionTareaProy");

    //    $("#modal-completar-tarea").modal('show');
    $("#btnFinalizarTareaProy").attr(
        "onclick",
        "finalizarTareaProy(" + idActividad + "," + chkb + "," + idUsuario + ")"
    );
    $("#btnCancelarFinalizarTareaProy").attr(
        "onclick",
        "cancelarCompletarTareaProy(" +
        idCheckbox +
        "); closeModal('modalConfirmacionTareaProy');"
    );
}

function cancelarCompletarTareaProy(idCheckbox) {
    if ($("#btnPendientesPAProyecto").hasClass("is-outlined")) {
        var status = "F";
        idCheckbox.checked = true;
    } else {
        var status = "N";
        idCheckbox.checked = false;
    }
}

function finalizarTareaProy(idActividad, chkb, idUsuario) {
    var idDestino = $("#hddIdDestinoProy").val();
    var idSeccion = $("#hddIdSeccionProy").val();
    var idSubseccion = $("#hddIdSubseccionProy").val();
    var idProyecto = $("#hddIdProyecto").val();
    //var chkb = element.checked;
    if (chkb == true) {
        var status = "F";
    } else {
        var status = "N";
    }
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=29&idActividad=" +
            idActividad +
            "&status=" +
            status +
            "&completo=" +
            idUsuario,
        success: function (data) {
            if (data == 1) {
                obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
                closeModal("modalConfirmacionTareaProy");
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function completarProyecto(element) {
    var idProyecto = $("#hddIdProyecto").val();
    var chkb = element.checked;
    var idCheckbox = element.id;

    showModal("modalFinalizarProyecto");

    //    $("#modal-completar-tarea").modal('show');
    $("#btnFinalizarProy").attr(
        "onclick",
        "finalizarProyecto(" + idProyecto + "," + chkb + ")"
    );
    $("#btnCancelarFinalizarProy").attr(
        "onclick",
        "cancelarCompletarProy(" +
        idCheckbox +
        "); closeModal('modalFinalizarProyecto');"
    );
}

function cancelarCompletarProy(idCheckbox) {
    if ($("#btnPendientesPAProyecto").hasClass("is-outlined")) {
        var status = "F";
        idCheckbox.checked = true;
    } else {
        var status = "N";
        idCheckbox.checked = false;
    }
}

function finalizarProyecto(idProyecto, chkb) {
    var idDestino = $("#hddIdDestinoProy").val();
    var idSeccion = $("#hddIdSeccionProy").val();
    var idSubseccion = $("#hddIdSubseccionProy").val();
    var idProyecto = $("#hddIdProyecto").val();
    //var chkb = element.checked;
    if (chkb == true) {
        var status = "F";
    } else {
        var status = "N";
    }
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=30&idProyecto=" + idProyecto + "&status=" + status,
        success: function (data) {
            if (data == 1) {
                obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
                closeModal("modalFinalizarProyecto");
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function quitarTareaProyecto(idActividad) {
    showModal("modalEliminarTareaProy");
    $("#btnEliminarTareaProy").attr(
        "onclick",
        "eliminarTareaProy(" + idActividad + ")"
    );
}

function eliminarTareaProy(idActividad) {
    var idDestino = $("#hddIdDestinoProy").val();
    var idSeccion = $("#hddIdSeccionProy").val();
    var idSubseccion = $("#hddIdSubseccionProy").val();
    var idProyecto = $("#hddIdProyecto").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=31&idActividad=" + idActividad,
        success: function (data) {
            if (data == 1) {
                toastr.success("Actividad eliminada", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
                closeModal("modalEliminarTareaProy");
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function quitarAdjuntoProyecto(idAdjunto, tipo) {
    showModal("modalEliminarAdjuntoProy");
    $("#btnEliminarArchivoProy").attr(
        "onclick",
        "eliminarAdjuntoProy(" + idAdjunto + ", '" + tipo + "')"
    );
}

function eliminarAdjuntoProy(idAdjunto, tipo) {
    var idDestino = $("#hddIdDestinoProy").val();
    var idSeccion = $("#hddIdSeccionProy").val();
    var idSubseccion = $("#hddIdSubseccionProy").val();
    var idProyecto = $("#hddIdProyecto").val();
    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=32&idAdjunto=" + idAdjunto + "&tipo=" + tipo,
        success: function (data) {
            if (data == 1) {
                toastr.success("Archivo eliminado", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
                obtDetalleProyecto(idProyecto, idDestino, idSeccion, idSubseccion);
                closeModal("modalEliminarAdjuntoProy");
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

//*****************************************************
//*
//* Reporte de pendientes y preventivos
//*****************************************************

function buscarMC() {
    var idSeccion = $("#cbSecciones").val();
    var rangoFechas = $("#rangoFechas").val();
    var idSubseccion = $("#cbSubsecciones").val();
    var idEquipo = $("#cbEquipos").val();
    var estado = $("input:radio[name=estatus]:checked").val();
    var rangoFechas = rangoFechas.split("-");
    var fechaI = rangoFechas[0].trim();
    var fechaF = rangoFechas[1].trim();

    if (fechaI != "" && fechaF != "") {
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=36&idSeccion=" +
                idSeccion +
                "&idSubseccion=" +
                idSubseccion +
                "&idEquipo=" +
                idEquipo +
                "&fechaI=" +
                fechaI +
                "&fechaF=" +
                fechaF +
                "&estado=" +
                estado,
            beforeSend: function () {
                var pageloader = document.getElementById("loader");
                if (pageloader) {
                    pageloader.classList.toggle("is-active");
                }
            },
            success: function (data) {
                var pageloader = document.getElementById("loader");
                var pageloaderTimeout = setTimeout(function () {
                    pageloader.classList.toggle("is-active");
                    clearTimeout(pageloaderTimeout);
                }, 3000);
                $("#tbodyTabla").html("");
                $("#tablaMC").dataTable().fnDestroy();
                $("#tbodyTabla").html(data);
                var tablaMC = $("#tablaMC").DataTable({
                    order: [
                        [1, "desc"]
                    ],
                    select: true,
                    scrollY: "50vh",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    autoWidth: true,
                    dom: "Rlfrtip",
                    colReorder: {
                        allowReorder: false,
                    },
                    columnDefs: [{ width: "100%", targets: 2 }],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                    },
                    dom: "Bfrtip",
                    buttons: [{
                        extend: "excel",
                        title: "Reporte de pendientes de Usuarios",
                        className: "button is-primary is-small",
                    },],
                    initComplete: function () {
                        this.api()
                            .columns()
                            .every(function () {
                                var column = this;
                                var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on("change", function () {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                        column
                                            .search(val ? "^" + val + "$" : "", true, false)
                                            .draw();
                                    });
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        select.append(
                                            '<option value="' + d + '">' + d + "</option>"
                                        );
                                    });
                            });
                    },
                });

                tablaMC.on("select", function (e, dt, type, indexes) {
                    var rowData = tablaMC.rows(indexes).data().toArray();
                    $("#hddIdRegistro").val(rowData[0][0]);
                    $.ajax({
                        type: "post",
                        url: "../php/stockPHP.php",
                        data: "action=6&idRegistro=" + rowData[0][0],
                        success: function (data) {
                            var registro = JSON.parse(data);

                            $("#cbDestinoRegEdit").val(registro.idDestino);
                            $("#cbDestinoRegEdit").selectpicker("refresh");
                            $("#cbFaseEdit").val(registro.fase);
                            $("#cbFaseEdit").selectpicker("refresh");
                            //                                                        $("#txtUbicacionEdit").val(registro.ubicacion);
                            $("#txtCod2bendEdit").val(registro.cod2bend);
                            $("#txtDesc2bendEdit").val(registro.descripcion2bend);
                            $("#cbNaturalezaEdit").val(registro.naturaleza);
                            $("#cbNaturalezaEdit").selectpicker("refresh");
                            $("#cbSeccionEdit").val(registro.seccion);
                            $("#cbSeccionEdit").selectpicker("refresh");
                            $("#cbFamiliaEdit").val(registro.familia);
                            $("#cbFamiliaEdit").selectpicker("refresh");
                            $("#cbSubfamiliaEdit").val(registro.subfamilia);
                            $("#cbSubfamiliaEdit").selectpicker("refresh");
                            $("#txtDescNuevaEdit").val(registro.descripcionNueva);
                            $("#txtMarcaEdit").val(registro.marca);
                            $("#txtModeloEdit").val(registro.modelo);
                            $("#txtCaracteristicasPpalesEdit").val(
                                registro.caracteristicasPpales
                            );
                            $("#txtExistencias2bendEdit").val(registro.existencias2bend);
                            $("#txtExistenciasSubalmacenEdit").val(
                                registro.existenciasSubalmacen
                            );
                            $("#txtPrecioEdit").val(registro.precio);
                            $("#txtConsumoAnualEdit").val(registro.consumoAnual);
                            $("#txtStockNecesarioEdit").val(registro.stockNecesario);
                            $("#txtUnidadesAPedirEdit").val(registro.unidadesPedir);
                            $("#txtFechaPedidoEdit").val(registro.fechaPedido);
                            $("#txtPrioridadEdit").val(registro.prioridad);
                            $("#txtFechaLlegadaEdit").val(registro.fechaLlegada);
                            $("#searchResultEdit").html("");
                            $("#searchResultEdit").hide();
                        },
                    });
                });
            },
        });
    } else {
        toastr.warning("Revise los campos!", "Advertencia", {
            closeButton: true,
            newestOnTop: true,
            positionClass: "toast-top-center",
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });
    }
}

function buscarEquipos() {
    var idSeccion = $("#cbSecciones").val();
    var idSubseccion = $("#cbSubsecciones").val();

    $.ajax({
        type: "post",
        url: "php/plannerPHP.php",
        data: "action=37&idSeccion=" + idSeccion + "&idSubseccion=" + idSubseccion,
        success: function (data) {
            try {
                $("#cbEquipos").html(data);
            } catch (ex) {
                toastr.warning(ex, "Advertencia", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function buscarMP() {
    var idSeccion = $("#cbSecciones").val();
    var rangoFechas = $("#rangoFechas").val();
    var idSubseccion = $("#cbSubsecciones").val();
    var idEquipo = $("#cbEquipos").val();
    var estado = $("input:radio[name=estatus]:checked").val();
    var rangoFechas = rangoFechas.split("-");
    var fechaI = rangoFechas[0].trim();
    var fechaF = rangoFechas[1].trim();

    if (fechaI != "" && fechaF != "") {
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=38&idSeccion=" +
                idSeccion +
                "&idSubseccion=" +
                idSubseccion +
                "&idEquipo=" +
                idEquipo +
                "&fechaI=" +
                fechaI +
                "&fechaF=" +
                fechaF +
                "&estatus=" +
                estado,
            success: function (data) {
                $("#tablaMP").dataTable().fnDestroy();
                $("#tbodyTabla").html(data);
                var tResultadoOTS = $("#tablaMP").DataTable({
                    order: [
                        [1, "desc"]
                    ],
                    select: true,
                    scrollY: "50vh",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    autoWidth: true,
                    dom: "Rlfrtip",
                    colReorder: {
                        allowReorder: false,
                    },
                    columnDefs: [{ width: "100%", targets: 2 }],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                    },
                    dom: "Bfrtip",
                    buttons: [{
                        extend: "excel",
                        title: "Reporte de pendientes de Usuarios",
                        className: "button is-primary is-small",
                    },],
                    initComplete: function () {
                        this.api()
                            .columns()
                            .every(function () {
                                var column = this;
                                var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on("change", function () {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                        column
                                            .search(val ? "^" + val + "$" : "", true, false)
                                            .draw();
                                    });

                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        select.append(
                                            '<option value="' + d + '">' + d + "</option>"
                                        );
                                    });
                            });
                    },
                });

                $(".container-scroll").mCustomScrollbar({
                    theme: "minimal-dark",
                });
            },
        });
    } else {
        toastr.warning("Revise los campos!", "Advertencia", {
            closeButton: true,
            newestOnTop: true,
            positionClass: "toast-top-center",
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });
    }
}

function buscarMisPendientes(idResponsable) {
    var idSeccion = $("#cbSecciones").val();
    var rangoFechas = $("#rangoFechas").val();
    var idSubseccion = $("#cbSubsecciones").val();
    var idEquipo = $("#cbEquipos").val();
    var estado = $("input:radio[name=estatus]:checked").val();
    var rangoFechas = rangoFechas.split("-");
    var fechaI = rangoFechas[0].trim();
    var fechaF = rangoFechas[1].trim();

    if (fechaI != "" && fechaF != "") {
        $.ajax({
            type: "post",
            url: "php/plannerPHP.php",
            data: "action=39&idSeccion=" +
                idSeccion +
                "&idSubseccion=" +
                idSubseccion +
                "&idEquipo=" +
                idEquipo +
                "&fechaI=" +
                fechaI +
                "&fechaF=" +
                fechaF +
                "&estado=" +
                estado +
                "&idResponsable=" +
                idResponsable,
            beforeSend: function () {
                var pageloader = document.getElementById("loader");
                if (pageloader) {
                    pageloader.classList.toggle("is-active");
                }
            },
            success: function (data) {
                var pageloader = document.getElementById("loader");
                var pageloaderTimeout = setTimeout(function () {
                    pageloader.classList.toggle("is-active");
                    clearTimeout(pageloaderTimeout);
                }, 3000);
                $("#tbodyTabla").html("");
                $("#tablaMC").dataTable().fnDestroy();
                $("#tbodyTabla").html(data);
                var tablaMC = $("#tablaMC").DataTable({
                    order: [
                        [1, "desc"]
                    ],
                    select: true,
                    scrollY: "50vh",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    autoWidth: true,
                    dom: "Rlfrtip",
                    colReorder: {
                        allowReorder: false,
                    },
                    columnDefs: [{ width: "100%", targets: 2 }],
                    language: {
                        url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                    },
                    dom: "Bfrtip",
                    buttons: [{
                        extend: "excel",
                        title: "Reporte de pendientes de Usuarios",
                        className: "button is-primary is-small",
                    },],
                    initComplete: function () {
                        this.api()
                            .columns()
                            .every(function () {
                                var column = this;
                                var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on("change", function () {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                        column
                                            .search(val ? "^" + val + "$" : "", true, false)
                                            .draw();
                                    });
                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function (d, j) {
                                        select.append(
                                            '<option value="' + d + '">' + d + "</option>"
                                        );
                                    });
                            });
                    },
                });

                tablaMC.on("select", function (e, dt, type, indexes) {
                    var rowData = tablaMC.rows(indexes).data().toArray();
                    $("#hddIdRegistro").val(rowData[0][0]);
                    $.ajax({
                        type: "post",
                        url: "../php/stockPHP.php",
                        data: "action=6&idRegistro=" + rowData[0][0],
                        success: function (data) {
                            var registro = JSON.parse(data);

                            $("#cbDestinoRegEdit").val(registro.idDestino);
                            $("#cbDestinoRegEdit").selectpicker("refresh");
                            $("#cbFaseEdit").val(registro.fase);
                            $("#cbFaseEdit").selectpicker("refresh");
                            //                                                        $("#txtUbicacionEdit").val(registro.ubicacion);
                            $("#txtCod2bendEdit").val(registro.cod2bend);
                            $("#txtDesc2bendEdit").val(registro.descripcion2bend);
                            $("#cbNaturalezaEdit").val(registro.naturaleza);
                            $("#cbNaturalezaEdit").selectpicker("refresh");
                            $("#cbSeccionEdit").val(registro.seccion);
                            $("#cbSeccionEdit").selectpicker("refresh");
                            $("#cbFamiliaEdit").val(registro.familia);
                            $("#cbFamiliaEdit").selectpicker("refresh");
                            $("#cbSubfamiliaEdit").val(registro.subfamilia);
                            $("#cbSubfamiliaEdit").selectpicker("refresh");
                            $("#txtDescNuevaEdit").val(registro.descripcionNueva);
                            $("#txtMarcaEdit").val(registro.marca);
                            $("#txtModeloEdit").val(registro.modelo);
                            $("#txtCaracteristicasPpalesEdit").val(
                                registro.caracteristicasPpales
                            );
                            $("#txtExistencias2bendEdit").val(registro.existencias2bend);
                            $("#txtExistenciasSubalmacenEdit").val(
                                registro.existenciasSubalmacen
                            );
                            $("#txtPrecioEdit").val(registro.precio);
                            $("#txtConsumoAnualEdit").val(registro.consumoAnual);
                            $("#txtStockNecesarioEdit").val(registro.stockNecesario);
                            $("#txtUnidadesAPedirEdit").val(registro.unidadesPedir);
                            $("#txtFechaPedidoEdit").val(registro.fechaPedido);
                            $("#txtPrioridadEdit").val(registro.prioridad);
                            $("#txtFechaLlegadaEdit").val(registro.fechaLlegada);
                            $("#searchResultEdit").html("");
                            $("#searchResultEdit").hide();
                        },
                    });
                });
            },
        });
    } else {
        toastr.warning("Revise los campos!", "Advertencia", {
            closeButton: true,
            newestOnTop: true,
            positionClass: "toast-top-center",
            showDuration: "300",
            hideDuration: "1000",
            timeOut: "5000",
            extendedTimeOut: "1000",
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
        });
    }
}

function mostrarMapa(destino, seccion, subseccion) {
    $("#article-mapas").fadeIn("slow");

    imagen =
        "<figure class='image'>" +
        "<a class='example-image-link' href='repositorio/maphg/" +
        destino +
        "/PLANOS/" +
        seccion +
        "/" +
        subseccion +
        "/mapa.png' data-lightbox='mapas-areas' data-title=''>" +
        "<img class='example-image img-fluid' src='repositorio/maphg/" +
        destino +
        "/PLANOS/" +
        seccion +
        "/" +
        subseccion +
        "/mapa.png' alt=''/>" +
        "</a>" +
        "</figure>";

    $("#message-body").html(imagen);
}

function cerrarMapa() {
    $("#article-mapas").fadeOut("slow");
}

// **************************    INICIO VERSION BETA 2020  *******************************************

// Alertas Generales programadas con Funciones.

function alertInformacionVacia() {
    Swal.fire("", "Ingrese información valida!", "error");
}

function alertInformacionActualiza(mensajeSuccess) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: "success",
        title: mensajeSuccess,
    });
}

function refreshProyectos() {
    var idDestino = $("#idDestinoProyectos").val();
    var idSeccion = $("#idSeccionProyectos").val();
    var idUsuario = $("#idUsuarioProyectos").val();
    var idSubseccion = $("#idSubseccionProyectos").val();

    listarProyectos(idUsuario, idDestino, idSeccion, idSubseccion);
}

function proyectosFinalizados() {
    var action = "proyectosFinalizados";
    var id_Destino = $("#idDestinoProyectos").val();
    var id_Seccion = $("#idSeccionProyectos").val();
    $("#modal-proyectos").css("display", "none");
    $("#modal-proyectos-finalizados").removeClass();
    $("#modal-proyectos-finalizados").addClass(" modal-fx-superScaled is-active");

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: { action: action, id_Destino: id_Destino, id_Seccion: id_Seccion },

        success: function (datos) {
            // Asignar valor a las variables de proyecto.
            $("#data-proyectos-finalizados").html(datos);
        },
    });
}


function restaurarProyecto(idProyecto) {
    const action = "restaurarProyecto";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto
        },
        success: function (data) {
            if (data == 1) {
                alertInformacion('Proyecto Restaurado', 'success');
                refreshProyectos();
            } else {
                alertInformacion('Intente de Nuevo', 'question');
            }
        },
    });
}

function regresarProyectos() {
    $("#modal-proyectos-finalizados").removeClass();
    $("#modal-proyectos-finalizados").addClass("modal");
    $("#modal-proyectos").css("display", "block");
}

function mostrarJustificacion(idProyecto) {
    var id = $(this).attr("id");

    $.ajax({
        url: "../php/stockPHP.php",
        type: "POST",
        data: "action=41&idProyecto=" + idProyecto,
        dataType: "json",
        success: function (data) {
            $("#id_articulo").val(id);
            $("#cantidad_articulo").val(data);
        },
    });
}


function listarProyectos(idUsuario, id_Destino, id_Seccion, idSubseccion, nombreSeccion) {
    document.getElementById("modal-proyectos").setAttribute('style', 'display:none');
    // Nueva version
    localStorage.setItem('usuario', idUsuario);
    localStorage.setItem('idDestino', id_Destino);
    localStorage.setItem('idSeccion', id_Seccion);
    localStorage.setItem('idSubseccion', idSubseccion);

    // idSeccion = 1 & idDestino = 1 & tipoPendiente = MCS & idUsuario = 1#
    page = 'modalProyectos.php';
    window.open(page, "Proyectos",
        "directories=no, toolbar=no,location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1200px, height=800px"
    );

    // document.getElementById("modal-proyectos")
    // document.getElementById("btnProyectosFinalizados").setAttribute('onclick', 'listarProyectosF(' + idUsuario + ',' + id_Destino + ',' + id_Seccion + ',' + idSubseccion + ',"' + nombreSeccion + '")');
    // document.getElementById("btnProyectosFinalizados").classList.remove('is-hidden');
    // document.getElementById("btnProyectosPendientes").classList.add('is-hidden');

    // $("#data-proyectos-TG").html("");
    // var action = "listarProyectos";
    // let statusProyecto = "N";

    // $.ajax({
    //     type: "post",
    //     url: "php/crud.php",
    //     data: {
    //         action: action,
    //         id_Destino: id_Destino,
    //         id_Seccion: id_Seccion,
    //         idSubseccion: idSubseccion,
    //         idUsuario: idUsuario,
    //         statusProyecto: statusProyecto
    //     },

    //     success: function (datos) {
    //         $("#titulo_proyectos").html(datos);

    //         // Asignar valor a las variables de proyecto.
    //         $("#idDestinoProyectos").val(id_Destino);
    //         $("#idSeccionProyectos").val(id_Seccion);
    //         $("#idUsuarioProyectos").val(idUsuario);
    //         $("#idSubseccionProyectos").val(idSubseccion);
    //         $("#data-proyectos").html(datos);
    //     },
    // });
}

function listarProyectosF(idUsuario, id_Destino, id_Seccion, idSubseccion) {
    document.getElementById("btnProyectosPendientes").setAttribute('onclick', 'listarProyectos(' + idUsuario + ',' + id_Destino + ',' + id_Seccion + ',' + idSubseccion + ')');
    document.getElementById("btnProyectosPendientes").classList.remove('is-hidden');
    document.getElementById("btnProyectosFinalizados").classList.add('is-hidden');

    $("#data-proyectos-TG").html("");
    var action = "listarProyectos";
    let statusProyecto = "F";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            id_Destino: id_Destino,
            id_Seccion: id_Seccion,
            idSubseccion: idSubseccion,
            idUsuario: idUsuario,
            statusProyecto: statusProyecto
        },

        success: function (datos) {
            $("#titulo_proyectos").html(datos);

            // Asignar valor a las variables de proyecto.
            $("#idDestinoProyectos").val(id_Destino);
            $("#idSeccionProyectos").val(id_Seccion);
            $("#idUsuarioProyectos").val(idUsuario);
            $("#idSubseccionProyectos").val(idSubseccion);
            $("#data-proyectos").html(datos);
        },
    });
}

// Datos basados en la funcion listarProyecto donde se tiene datos previos.
function nuevoProyecto() {
    var tituloProyecto = $("#tituloProyectoNuevo").val();
    var action = "nuevoProyecto";
    var id_DestinoProyecto = $("#idDestinoProyectos").val();
    var id_SeccionProyecto = $("#idSeccionProyectos").val();
    var id_UsuarioProyecto = $("#idUsuarioProyectos").val();
    var idSubseccionProyecto = $("#idSubseccionProyectos").val();

    if (tituloProyecto != "") {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                tituloProyecto: tituloProyecto,
                id_DestinoProyecto: id_DestinoProyecto,
                id_SeccionProyecto: id_SeccionProyecto,
                id_UsuarioProyecto: id_UsuarioProyecto,
                idSubseccionProyecto: idSubseccionProyecto,
            },

            success: function (datos) {
                $("#tituloProyectoNuevo").val("");
                refreshProyectos();
                alertInformacionActualiza("Proyecto Agregado");
            },
        });
    } else {
        alertInformacionVacia();
    }
}

function btnEditarProyecto() {
    $("#btnInputProyecto").toggleClass("hidden");
}

function eliminarProyecto() {
    var action = "eliminarProyecto";
    Swal.fire({
        title: "¿Desea Eliminar el Proyecto?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar Proyecto",
    }).then((result) => {
        if (result.value) {
            Swal.fire("", "Proyecto Eliminado", "success", eliminarProyectoConfirm());
        }
    });

    function eliminarProyectoConfirm() {
        var idProyecto = $("#idProyectoStatus").val();
        var action = "eliminarProyecto";
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: { action: action, idProyecto: idProyecto },

            success: function (datos) {
                refreshProyectos();
                show_hide_modal("modal-Status", "hide");
                btnEditarProyecto();
            },
        });
    }
}

function editarProyecto() {
    var idProyecto = $("#idProyectoStatus").val();
    var tituloProyecto = $("#editarTituloProyecto").val();
    var action = "editarProyecto";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto,
            tituloProyecto: tituloProyecto,
        },

        success: function (datos) {
            refreshProyectos();
            show_hide_modal("modal-Status", "hide");
            alertInformacionActualiza("Proyecto Actualizado");
            $("#editarTituloProyecto").val("");
            btnEditarProyecto();
        },
    });
}

// Seccion para visualizar los modal de proyecto con los Datos
function modalJustificacion(idProyecto, idJustificacion) {
    var action = "consultaJustificacionProyecto";
    var idProyecto = idProyecto;
    var idJustificacion = idJustificacion;
    $("#modal-Justificacion").addClass("modal-fx-superScaled is-active");

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto,
            idJustificacion: idJustificacion,
        },

        success: function (datos) {
            $("#dataJustificacion").val(datos);
            $("#idProyectoJustificacion").val(idProyecto);
            refreshProyectos();
        },
    });
}

function modalCosto(idProyecto, coste) {
    var idProyecto = idProyecto;
    var coste = coste;

    $("#dataCoste").val(coste);
    $("#idProyectoCoste").val(idProyecto);
    $("#modal-Costo").addClass("modal-fx-superScaled is-active");
}

function modalStatus(idProyecto) {
    $("#idProyectoStatus").val(idProyecto);
    $("#modal-Status").addClass("modal-fx-superScaled is-active");
}

function modalTipo(idProyecto) {
    var idProyecto = idProyecto;

    $("#idProyectoTipo").val(idProyecto);
    $("#modal-Tipo").addClass("modal-fx-superScaled is-active");
}

// Funcion para Abrir Modal Usuarios
function modalResponsable(idProyecto) {
    var idProyecto = idProyecto;

    $("#responsableProyecto").val(idProyecto);
    $("#modaResponsableProyecto").addClass("modal-fx-superScaled is-active");
}

// Actualizacion de informacion de los proyectos mediante los Modals
function actualizarCostoProyecto() {
    var action = "actualizarCostoProyecto";
    var idProyecto = $("#idProyectoCoste").val();
    var costo = $("#dataCoste").val();

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: { action: action, idProyecto: idProyecto, costo: costo },

        success: function (datos) {
            $("#modal-Costo").removeClass("modal-fx-superScaled is-active");
            refreshProyectos();
            alertInformacionActualiza("Costo Actualizado");
        },
    });
}

function actualizarJustificacionProyecto() {
    var action = "actualizarJustificacionProyecto";
    var idProyecto = $("#idProyectoJustificacion").val();
    var justificacion = $("#dataJustificacion").val();

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto,
            justificacion: justificacion,
        },

        success: function (datos) {
            $("#modal-Justificacion").removeClass("modal-fx-superScaled is-active");
            refreshProyectos();
            alertInformacionActualiza("Justificion Actualizada");
        },
    });
}

function actualizarTipoProyecto() {
    var action = "actualizarTipoProyecto";
    var idProyecto = $("#idProyectoTipo").val();
    var tipo = $("#dataTipo").val();

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: { action: action, idProyecto: idProyecto, tipo: tipo },

        success: function (datos) {
            $("#modal-Tipo").removeClass("modal-fx-superScaled is-active");
            refreshProyectos();
            alertInformacionActualiza("Tipo de Proyecto Actualizado");
        },
    });
}

// Modal para asignar responsable a un proyecto.
function asignarResponsableProyecto(idUsuario) {
    var action = "asignarResponsableProyecto";
    var idProyecto = $("#responsableProyecto").val();
    var idUsuario = idUsuario;

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: { action: action, idProyecto: idProyecto, idUsuario: idUsuario },

        success: function (datos) {
            $("#modal-Tipo").removeClass("modal-fx-superScaled is-active");
            cerrarModalResponsableProyecto();
            refreshProyectos();
            alertInformacionActualiza("Responsable Asignado");
        },
    });
}

function modalAgregarComentarioProyectos(idProyecto, idUsuario) {
    var action = "consultaComentariosProyecto";

    $("#idProyecto").val(idProyecto);
    $("#idUsuarioProyecto").val(idUsuario);
    $("#modalComentario").addClass(" modal-fx-superScaled is-active");
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto,
        },

        success: function (datos) {
            $("#comentarioProyecto").html(datos);
            refreshProyectos();
        },
    });
}

function agregarComentarioProyectos() {
    var action = "agregarComentarioProyecto";
    var idProyecto = $("#idProyecto").val();
    var idUsuario = $("#idUsuarioProyecto").val();
    var comentario = $("#textComentarioProyecto").val();

    if (comentario != "") {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idProyecto: idProyecto,
                idUsuario: idUsuario,
                comentario: comentario,
            },

            success: function (datos) {
                modalAgregarComentarioProyectos(idProyecto, idUsuario);
                $("#textComentarioProyecto").val("");
                refreshProyectos();
                alertInformacionActualiza("Comentario Agregado");
            },
        });
    } else {
        alertInformacionVacia();
    }
}

function statusProyecto(statusProyecto) {
    var action = "agregarStatusProyecto";
    var idProyecto = $("#idProyectoStatus").val();
    var idUsuario = $("#idUsuarioProyecto").val();
    var statusProyecto = statusProyecto;

    if (statusProyecto == "solucionado") {
        Swal.fire({
            title: "¿Desea Finalizar el Proyecto?",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Finalizar Proyecto",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    "",
                    "Proyecto Finalizado",
                    "success",
                    finalizarProyecto(idProyecto)
                );
            }
        });
    } else {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idProyecto: idProyecto,
                idUsuario: idUsuario,
                statusProyecto: statusProyecto,
            },
            success: function (datos) {
                refreshProyectos();
                $("#modal-Status").removeClass();
                $("#modal-Status").addClass("modal");
                alertInformacionActualiza("Status Actualizado");
            },
        });
    }
}

function finalizarProyecto(idProyecto) {
    var action = "finalizarProyecto";
    var idProyecto = idProyecto;
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto,
        },
        success: function (datos) {
            refreshProyectos();
            $("#modal-Status").removeClass();
            $("#modal-Status").addClass("modal");
            alertInformacionActualiza("Proyecto Finalizado");
        },
    });
}

function showmodalproyectos(nombreSeccion) {
    $("#textSeccion").html(nombreSeccion);
    $("#estiloSeccionProyectos").removeClass('');
    $("#estiloSeccionProyectos").addClass(nombreSeccion);
    $("#textSeccionProyectosFinalizados").html(nombreSeccion);
}

// Funcion para Cerrar modal Asignar Proyectos.
function cerrarModalResponsableProyecto() {
    $("#modaResponsableProyecto").removeClass(" modal-fx-superScaled is-active");
}

// Codigo para MC
function modalStatusMC(idMC, idUsuario, tipoMCMCG) {
    $("#idMC").val(idMC);
    $("#idUsuarioMC").val(idUsuario);
    $("#modalStatusMC").addClass("modal-fx-superScaled is-active");
    $("#tipoMCMCG").val(tipoMCMCG);
}

function statusMC(statusMC) {
    var action = "agregarStatusMC";
    var idMC = $("#idMC").val();
    var idUsuarioMC = $("#idUsuarioMC").val();
    var tipoMCMCG = $("#tipoMCMCG").val();
    var statusMC = statusMC;
    var idEquipo = $("#hddIdEquipo").val();

    if (statusMC == "solucionado") {
        Swal.fire({
            title: "¿Desea Finalizar?",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Finalizar",
        }).then((result) => {
            if (result.value) {
                Swal.fire("", "Finalizado", "success", finalizarMC(idMC));
            }
        });
    } else {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idMC: idMC,
                idUsuarioMC: idUsuarioMC,
                statusMC: statusMC,
            },
            success: function (datos) {
                alertInformacionActualiza("Status Actualizado");
                if (tipoMCMCG == "MCG") {
                    recargarMC();
                } else {
                    obtCorrectivos(idEquipo, 'N');
                }
                $("#modalStatusMC").removeClass("modal-fx-superScaled is-active");
            },
        });
    }

}

function finalizarMC(idMC) {
    var action = "finalizarMC";
    var idEquipo = $("#hddIdEquipo").val();
    var tipoMCMCG = $("#tipoMCMCG").val();
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMC: idMC,
            statusMC: statusMC,
        },
        success: function (datos) {
            alertInformacionActualiza("Mantenimiento Correctivo Finalizado!");
            $("#modalStatusMC").removeClass("modal-fx-superScaled is-active");
            if (tipoMCMCG == "MCG") {
                recargarMC();
            } else {
                obtCorrectivos(idEquipo, 'N');
            }
        },
    });
}

function recargarMC() {
    var idActividad = $("#hddIdActividad").val();
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();
    var idRelSubcategoria = 0;

    obtCorrectivosG(
        idSubseccion,
        idDestino,
        idCategoria,
        idSubcategoria,
        idRelSubcategoria,
        "N"
    );
    // recargarListaTareas(idSubseccion, idDestino, idCategoria, idSubcategoria);
}

// Restaurar un Mantinimiento Correctivo.
function modalRestaurarMC(idMC, idUsuario) {
    $("#idMC").val(idMC);
    $("#idUsuarioMC").val(idUsuario);
    $("#modalRestaurarMC").addClass("modal-fx-superScaled is-active");
}

function restaurarMC(idMC, idUsuario, tipoMCMCG) {
    var action = "restaurarMC";
    var idMC = idMC;
    var idUsuario = idUsuario;

    Swal.fire({
        title: "¿Desea Restaurar?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Restaurar",
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                "",
                "Restaurado!",
                "success",
                restaurar(action, idMC, idUsuario, tipoMCMCG)
            );
        }
    });

    function restaurar(action, idMC, idUsuario, tipoMCMCG) {
        var idEquipo = $("#hddIdEquipo").val();
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idMC: idMC,
                idUsuario: idUsuario,
            },
            success: function (datos) {
                alertInformacionActualiza("Mantenimiento Correctivo Restaurado!");
                if (tipoMCMCG == "MC") {
                    obtCorrectivos(idEquipo, 'N');
                } else {
                    recargarMC();
                }
                $("#modalRestaurarMC").removeClass(" modal-fx-superScaled is-active");
            },
        });
    }
}

function modalSubirArchivo(tabla, id) {
    var action = "consultaArchivo";
    $("#tablaArchivo").val(tabla);
    $("#idGeneral").val(id);
    $("#modalSubirArchivo").addClass("modal-fx-superScaled is-active");
    $("#barra_estado").removeClass();
    $("#barra_estado").addClass("barra_azul");

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            tabla: tabla,
            id: id,
        },
        success: function (datos) {
            alertInformacionActualiza("Datos Obtenidos!");
            $("#archivos").html(datos);
        },
    });
}

function subirArchivoProceso() {
    var action = "subirArchivoGeneral";
    var tabla = $("#tablaArchivo").val();
    var idGeneral = $("#idGeneral").val();
    var fileName = $(".file-name").html();

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            tabla: tabla,
            idGeneral: idGeneral,
            fileName: fileName,
        },
        success: function (datos) {
            alertInformacionActualiza(datos);
            modalSubirArchivo(tabla, idGeneral);
            if (tabla == "t_proyectos_planaccion_adjuntos") {
                adjuntosPlanAccion(idGeneral);
            }
        },
    });
}

function subirArchivo() {
    let form = document.getElementById("form_subir");
    form.addEventListener("submit", function (event) {
        event.preventDefault();
        subir_archivo(this);
    });
    subirArchivoProceso();
}

function subir_archivo(form) {
    let barra_estado = form.children[1].children[0],
        span = barra_estado.children[0],
        botom_cancelar = form.children[2].children[1];

    //peticion
    let peticion = new XMLHttpRequest();

    //progreso
    peticion.upload.addEventListener("progress", (event) => {
        let porcentaje = Math.round((event.loaded / event.total) * 100);
        barra_estado.style.width = porcentaje + "%";
        span.innerHTML = porcentaje + "%";
    });

    //finalizado
    peticion.addEventListener("load", () => {
        barra_estado.classList.add("barra_verde");
        span.innerHTML = "proceso completado";
    });

    //enviar datos
    peticion.open("post", "./php/crud.php");
    peticion.send(new FormData(form));
    //form.preventDefault();

    //cancelar
    //botom_cancelar.addEventListener("click", () => {
    //   peticion.abort();
    // barra_estado.classList.remove('barra_verde');
    //barra_estado.classList.add('barra_roja');
    //span.innerHTML = "proceso cancelado";
    //});
}

function eliminarArchivo(idArchivo, tabla, idProyecto) {
    var idProyecto = idProyecto;
    var idArchivo = idArchivo;
    var tabla = tabla;

    Swal.fire({
        title: "¿Desea Eliminar el Archivo?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                "",
                "Eliminado!",
                "success",
                eliminarConfirmado(idArchivo, tabla, idProyecto)
            );
        }
    });

    function eliminarConfirmado(idArchivo, tabla, idProyecto) {
        var action = "eliminarArchivo";
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idArchivo: idArchivo,
                tabla: tabla,
            },
            success: function (datos) {
                if (tabla == "t_proyectos_planaccion_adjuntos") {
                    var idGeneral = $("#idPlanAccion").val();
                    adjuntosPlanAccion(idGeneral);
                } else {
                    alertInformacionActualiza("Archivo Eliminado");
                    modalSubirArchivo(tabla, idProyecto);
                }
            },
        });
    }
}

// Funcion para Guardar Status de las Tareas en General
function CapturarStatusGeneral(
    idUsuarioTG,
    idDestinoTG,
    idSeccionTG,
    idSubseccionTG,
    tablaTG
) {
    // <input type="hidden" id="idUsuarioTG">
    // <input type="hidden" id="idDestinoTG">
    // <input type="hidden" id="idSeccionTG">
    // <input type="hidden" id="idSubseccionTG">
    // <input type="hidden" id="idTareaTG">
    // <input type="hidden" id="statusTG">
    // <input type="hidden" id="tablaTG">

    $("#idUsuarioTG").val(idUsuarioTG);
    $("#idDestinoTG").val(idDestinoTG);
    $("#idSeccionTG").val(idSeccionTG);
    $("#idSubseccionTG").val(idSubseccionTG);
    $("#tablaTG").val(tablaTG);
}

function guardarStatus(idProyecto, statusProyecto) {
    var action = "guardarStatus";
    var idUsuarioTG = $("#idUsuarioTG").val();
    var idDestinoTG = $("#idDestinoTG").val();
    var idSeccionTG = $("#idSeccionTG").val();
    var idSubseccionTG = $("#idSubseccionTG").val();
    var tablaTG = $("#tablaTG").val();

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idUsuarioTG: idUsuarioTG,
            idDestinoTG: idDestinoTG,
            idSeccionTG: idSeccionTG,
            idSubseccionTG: idSubseccionTG,
            idProyecto: idProyecto,
            statusProyecto: statusProyecto,
            tablaTG: tablaTG,
        },
        success: function (datos) {
            alertInformacionActualiza(datos);
        },
    });
}

// Funcion General para Mostrar u Ocultar cualquier Modal con la clase(modal) no con(Style display:none;) Argumentando el id y la Accion (hide y Show).
function show_hide_modal(idModal, actionModal) {
    if (actionModal == "show") {
        $("#" + idModal).addClass("modal-fx-superScaled is-active");
    } else {
        $("#" + idModal).removeClass("modal-fx-superScaled is-active");
        $("#" + idModal).addClass("modal");
    }
}

//funcion solo para modal proyecto.
function show_hide_modalProyectos(idModal, actionModal) {
    if (actionModal == "show") {
        $("#" + idModal).removeClass("modal modal-fx-superScaled is-active");
    } else {
        $("#" + idModal).removeClass("modal-fx-superScaled is-active");
        $("#" + idModal).addClass("modal");
    }
}

function verPlan(idProyecto) {
    $(".verPlan" + idProyecto).toggleClass("modal  timeline-item");
}

function modalPlanAccion(idProyecto) {
    $("#idProyectoPlanAccion").val(idProyecto);
    $("#comentarioPlanAccion").html("");
    var action = "consultaPlanAccion";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto,
        },
        success: function (datos) {
            $("#planAccion" + idProyecto).html(datos);

            // refreshProyectos(); Error de Recar para ver plan de acción, se recargan los proyecto al hacer clic de desaparece todo.
        },
    });
}

function planAccionClic(idPlanAccion) {
    $(".planAccionActividad").addClass("has-background-warning");
    $("#" + idPlanAccion).removeClass("has-background-warning");
    $("#" + idPlanAccion).addClass("has-background-primary");
    $("#idPlanAccion").val(idPlanAccion);

    modalSubirArchivo("t_proyectos_planaccion_adjuntos", idPlanAccion);
}

function comentariosPlanAccion(idPlanAccion, idProyecto) {
    $("#idProyecto").val(idProyecto);

    var action = "comentarioPlanAccion";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idPlanAccion: idPlanAccion,
        },
        success: function (datos) {
            $("#comentarioPlanAccion" + idProyecto).html(datos);
            // refreshProyectos();
        },
    });
}

function agregarPlanAccion(idProyecto) {
    var action = "agregarPlanAccion";
    var actividad = $("#inputPlanAccion" + idProyecto).val();

    if (actividad != "") {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idProyecto: idProyecto,
                actividad: actividad,
            },
            success: function (datos) {
                $("#inputPlanAccion" + idProyecto).val("");
                modalPlanAccion(idProyecto);
                comentariosPlanAccion(idPlanAccion, idProyecto);
                // $("#comentarioPlanAccion").html(datos);
                // refreshProyectos();
            },
        });
    } else {
        alertInformacionVacia();
    }
}

function btnEditarPlan() {
    $("#editarTituloPlan").toggleClass("hidden");
    $("#btnTituloPlan").toggleClass("hidden");
}

function eliminarPlanAccion() {
    var idPlan = $("#statusIdPlanAccion").val();
    var action = "eliminarPlanAccion";

    Swal.fire({
        title: "¿Desea Eliminar el Plan de Acción?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                "",
                "Plan Acción, Eliminado!",
                "success",
                eliminarPlanAccionConfirm()
            );
        }
    });

    function eliminarPlanAccionConfirm() {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idPlan: idPlan,
            },
            success: function (datos) {
                refreshProyectos();
                alertInformacionActualiza("Eliminado");
            },
        });
    }
}

function actualizarPlanAccion() {
    var tituloPlan = $("#editarTituloPlan").val();
    var idPlan = $("#statusIdPlanAccion").val();
    var action = "actualizarPlanAccion";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            tituloPlan: tituloPlan,
            idPlan: idPlan,
        },
        success: function (datos) {
            $("#editarTituloPlan").val("");
            refreshProyectos();
            alertInformacionActualiza("Plan Acción, Actualizado");
        },
    });
}

function agregarComentarioPlanAccion(idProyecto) {
    var action = "agregarComentarioPlanAccion";
    var idProyecto = $("#idProyectoPlanAccion").val();
    var idPlanAccion = $("#idPlanAccion").val();
    var comentario = $("#inputComentarioPlanAccion" + idProyecto).val();

    if (comentario != "") {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idPlanAccion: idPlanAccion,
                comentario: comentario,
            },
            success: function (datos) {
                $("#inputComentarioPlanAccion" + idProyecto).val("");
                comentariosPlanAccion(idPlanAccion, idProyecto);
                // refreshProyectos();
                // modalPlanAccion(idProyecto);
                // comentariosPlanAccion(idPlanAccion, idProyecto);
                // planAccionClic(idPlanAccion);
            },
        });
    } else {
        alertInformacionVacia();
    }
}

function adjuntosPlanAccion(idPlanAccion) {
    var id = idPlanAccion;
    var idProyecto = $("#idProyecto").val();
    var action = "consultaArchivo";
    var tabla = "t_proyectos_planaccion_adjuntos";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            id: id,
            tabla: tabla,
        },
        success: function (datos) {
            $("#adjuntosPlanAccion" + idProyecto).html(datos);
            // refreshProyectos();
        },
    });
}

function hide_show_clase(idElemento) {
    $("#" + idElemento).toggleClass("modal");
}

function consultaArchivoJustificacion() {
    var id = $("#idProyectoJustificacion").val();
    modalSubirArchivo("t_proyectos_justificaciones", id);
}

// Agregar
function datosStatusProyecto(
    idDestino,
    idSeccion,
    idSubseccion,
    idTabla,
    idPlanAccion,
    tabla
) {
    // idTabla recibe el id del Proyecto, Tarea General, MP o MC, si no recibe es =0
    $("#statusIdDestino").val(idDestino);
    $("#statusIdSeccion").val(idSeccion);
    $("#statusIdSubseccion").val(idSubseccion);
    $("#statusIdTabla").val(idTabla);
    $("#statusIdPlanAccion").val(idPlanAccion);
    $("#statusTabla").val(tabla);
}


function obtenerStatusPlanaccion(idPlanAccion) {
    // Tabla: reporte_status_proyecto
    const action = "obtenerStatusPlanaccion";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idPlanAccion: idPlanAccion
        },
        dataType: 'json',
        success: function (data) {
            document.getElementById("dataStatusDepartamento").innerHTML = data.dataStatus;
        },
    });
}


function eliminarStatusPlanAccion(idPlanAccion, status) {
    const action = "eliminarStatusPlanAccion";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idPlanAccion: idPlanAccion,
            status: status
        },
        // dataType: 'json',
        success: function (data) {
            $("#modalStatusPlanAccion").removeClass("is-active");
            $("#modalDepartamento").removeClass("is-active");
            refreshProyectos();
        },
    });
}


function aplicarStatus(statusProyecto) {
    var action = "agregarStatusProyectoPlanAccion";
    var idDestino = $("#statusIdDestino").val();
    var idSeccion = $("#statusIdSeccion").val();
    var idSubseccion = $("#statusIdSubseccion").val();
    var idTabla = $("#statusIdTabla").val();
    var idPlanAccion = $("#statusIdPlanAccion").val();
    var tabla = $("#statusTabla").val();
    var statusProyecto = statusProyecto;

    if (statusProyecto == "solucionado") {
        Swal.fire({
            title: "¿Desea Finalizar el Proyecto?",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Finalizar Proyecto",
        }).then((result) => {
            if (result.value) {
                Swal.fire(
                    "",
                    "Proyecto Finalizado",
                    "success",
                    finalizarProyectoPlanAccion(idPlanAccion),
                    guardarStatusProyectoPlanAccion(
                        action,
                        idDestino,
                        idSeccion,
                        idSubseccion,
                        idTabla,
                        idPlanAccion,
                        tabla,
                        statusProyecto
                    )
                );
            }
        });
    } else {
        guardarStatusProyectoPlanAccion(
            action,
            idDestino,
            idSeccion,
            idSubseccion,
            idTabla,
            idPlanAccion,
            tabla,
            statusProyecto
        );
    }

    function guardarStatusProyectoPlanAccion(
        action,
        idDestino,
        idSeccion,
        idSubseccion,
        idTabla,
        idPlanAccion,
        tabla,
        statusProyecto
    ) {
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idDestino: idDestino,
                idSeccion: idSeccion,
                idSubseccion: idSubseccion,
                idTabla: idTabla,
                idPlanAccion: idPlanAccion,
                tabla: tabla,
                statusProyecto: statusProyecto,
            },
            success: function (datos) {
                $("#modalStatusPlanAccion").removeClass("is-active");
                $("#modalDepartamento").removeClass("is-active");
                refreshProyectos();
                alertInformacionActualiza("Status Actualizado");
            },
        });
    }
}

//Funcion actualizada.
//function aplicarStatus(statusProyecto) {
//     var action = "agregarStatusProyectoPlanAccion";
//     var idDestino = $("#statusIdDestino").val();
//     var idSeccion = $("#statusIdSeccion").val();
//     var idSubseccion = $("#statusIdSubseccion").val();
//     var idTabla = $("#statusIdTabla").val();
//     var idPlanAccion = $("#statusIdPlanAccion").val();
//     var tabla = $("#statusTabla").val();
//     var statusProyecto = statusProyecto;

//     if (statusProyecto == "solucionado") {
//         Swal.fire({
//             title: '¿Desea Finalizar el Proyecto?',
//             text: "",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonColor: '#3085d6',
//             cancelButtonColor: '#d33',
//             confirmButtonText: 'Finalizar Proyecto'
//         }).then((result) => {
//             if (result.value) {
//                 Swal.fire(
//                     '',
//                     'Proyecto Finalizado',
//                     'success',
//                     finalizarProyectoPlanAccion(idPlanAccion)
//                 )
//             }
//         })
//     } else {
//         $.ajax({
//             type: "post",
//             url: "php/crud.php",
//             data: {
//                 action: action,
//                 idDestino: idDestino,
//                 idSeccion: idSeccion,
//                 idSubseccion: idSubseccion,
//                 idTabla: idTabla,
//                 idPlanAccion: idPlanAccion,
//                 tabla: tabla,
//                 statusProyecto: statusProyecto
//             },
//             success: function (datos) {
//                 $("#modalStatusPlanAccion").removeClass();
//                 $("#modalStatusPlanAccion").addClass("modal");
//                 refreshProyectos();
//                 alertInformacionActualiza('Status Actualizado');
//             }
//         });
//     }
// }

function finalizarProyectoPlanAccion(idPlanAccion) {
    var action = "finalizarPlanAccion";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idPlanAccion: idPlanAccion
        },
        success: function (datos) {
            $("#modalStatusPlanAccion").removeClass();
            $("#modalStatusPlanAccion").addClass("modal");
            refreshProyectos();
            // alertInformacionActualiza('Plan de Accion, Finalizado!');
        },
    });
}

//funcion para Status de los Departamentos.
function reporteStatusDEP(
    idGrupo,
    idDestino,
    idSeccion,
    b,
    c,
    d,
    destinoTNombre,
    seccionNombre,
    grupo
) {
    //Inputs para generar Reporte
    $("#xlsIdGrupo").val(idGrupo);
    $("#xlsIdDestino").val(idDestino);
    $("#xlsIdSeccion").val(idSeccion);

    $("#seccionDEP").addClass("DEP");
    $("#reporteStatusDEP").removeClass(" modal");
    $("#nombreSubseccionDEP").html(seccionNombre);

    var action = "reporteStatusDEP";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idGrupo: idGrupo,
            idDestino: idDestino,
            idSeccion: idSeccion
        },
        // dataType:'json',
        success: function (datos) {
            // refreshProyectos();
            $("#reporteStatusDEPData").html(datos);
        },
    });
}

function capturarCodigo(idMC, tipoCodigo) {
    if (tipoCodigo == "cod2bend") {
        var codigo = $("#cod2ben" + idMC).val();
    } else {
        var codigo = $("#codsap" + idMC).val();
    }

    var action = "capturarCodigo";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMC: idMC,
            tipoCodigo: tipoCodigo,
            codigo: codigo
        },
        // dataType:'json',
        success: function (datos) {
            if (datos == "ok") {
                alertInformacionActualiza('Codigo Actualizado: ' + codigo);
            } else {
                alertInformacionVacia();
            }
        },
    });
}

function regresarProyectosDEP() {
    $("#reporteStatusDEP").addClass(" modal");
    $("#content").css("display", "block");
}

function reloadPlanner() {
    location.reload();
}

function aplicarStatusMC(departamento) {
    var idMC = $("#idMC").val();
    var action = "aplicarDepartamentoMC";

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMC: idMC,
            departamento: departamento
        },
        // dataType:'json',
        success: function (datos) {
            alertInformacionActualiza(datos);
            show_hide_modal("modalDepartamentoMC", "hide");
            show_hide_modal("modalEnergeticoMC", "hide");
            recargarMC();
        },
    });
}

// función para consultar el Status seleccionado de Energaticos o Departamentos.
// Recibe como parametro el nombre del status Energetico o Departamento.
function consultaEDMC(statusConsulta) {
    var action = "consultaEDMC";
    var idMC = $("#idMC").val();

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMC: idMC,
            statusConsulta: statusConsulta,
        },
        // dataType:'json',
        success: function (datos) {
            recargarMC();
            if ((statusConsulta = "energetico")) {
                $("#consultaEnergeticoMC").html(datos);
            }
            if ((statusConsulta = "departamento")) {
                $("#consultaDepartamentoMC").html(datos);
            }
        },
    });
}

// Funcion para eliminar estatus Departamento o Energetico en Mantenimineto Correctivo o Tareas Generales.
function eliminarED(tabla, columna, idMC) {
    var action = "eliminarED";
    var idMC = $("#idMC").val();

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMC: idMC,
            tabla: tabla,
            columna: columna,
        },
        // dataType:'json',
        success: function (datos) {
            recargarMC();
            alertInformacionActualiza(datos);
            show_hide_modal("modalEnergeticoMC", "hide");
            show_hide_modal("modalDepartamentoMC", "hide");
        },
    });
}

function cargarFotosEquipo1(idEquipo) {
    var inputFileImage = document.getElementById("txtFotoEquipo1");
    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idEquipo", idEquipo);

    var url = "php/planner_uploadfiles_equipo.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                obtenerFotosEquipo(idEquipo);
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function cargarEquipoAdjuntos(idEquipo) {
    var inputFileImage = document.getElementById("txtFotoEquipoAdjuntos");
    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append("fileToUpload" + i, file[i]);
    }
    data.append("idEquipo", idEquipo);

    var url = "php/planner_uploadfiles_equipo.php";

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false

        success: function (data) {
            if (data == 1) {
                obtenerFotosEquipo(idEquipo);
                toastr.success("Se ha cargado el archivo!", "Correcto", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            } else {
                toastr.error(data, "Error", {
                    closeButton: true,
                    newestOnTop: true,
                    positionClass: "toast-top-center",
                    showDuration: "300",
                    hideDuration: "1000",
                    timeOut: "5000",
                    extendedTimeOut: "1000",
                    showEasing: "swing",
                    hideEasing: "linear",
                    showMethod: "fadeIn",
                    hideMethod: "fadeOut",
                });
            }
        },
    });
}

function modalProyectosDEP(showHide) {
    if (showHide == "show") {
        $("#modal-proyectos").css("display", "block");
        $("#seccionColumnas").css("display", "none");
    } else {
        $("#modal-proyectos").css("display", "none");
        $("#seccionColumnas").css("display", "block");
    }
}

function consultaDEP(idUsuario, idDestino, idSeccion, idSubseccion) {
    var action = "consultaDEP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion
        },
        // dataType:'json',
        success: function (datos) {
            $("#data-proyectos-TG").html(datos);
            $("#textSeccion").html('DEP');
        },
    });
}

//$('btnEXLS').observe('click', function (event) {
//    Event.stop(event); // suppress default click behavior, cancel the event
//});

// Funciones para Tareas Generales MC.
function btnEditarMC() {
    $("#btnInputMC").toggleClass("hidden");
}

function eliminarMC() {
    Swal.fire({
        title: "¿Desea Eliminar Tarea General?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Eliminar",
    }).then((result) => {
        if (result.value) {
            Swal.fire("", "Tarea General, Eliminada", "success", eliminarMCConfirm());
        }
    });

    function eliminarMCConfirm() {
        var action = "eliminarMC";
        var idMC = $("#idMC").val();

        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idMC: idMC,
            },
            success: function (datos) {
                recargarMC();
                btnEditarMC();
                show_hide_modal("modalStatusMC", "hide");
            },
        });
    }
}

function editarMC() {
    var action = "editarMC";
    var idMC = $("#idMC").val();
    var tituloMC = $("#editarTituloMC").val();

    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idMC: idMC,
            tituloMC: tituloMC,
        },
        success: function (datos) {
            recargarMC();
            btnEditarMC();
            show_hide_modal("modalStatusMC", "hide");
            $("#editarTituloMC").val("");
            alertInformacionActualiza(datos);
        },
    });
}


// Función para seleccionar GP - TRS - ZI en los mantenimientos preventivos, para las subsecciones no clasificadas.
function zonaMC(idMC, zona, idEquipo, statusMC, idSubseccion) {
    if (idMC != "" && zona != "") {

        const action = "zonaMC";
        $.ajax({
            type: "post",
            url: "php/crud.php",
            data: {
                action: action,
                idMC: idMC,
                zona: zona
            },
            success: function (datos) {
                // obtCorrectivos(idEquipo, statusMC);
                // recargarMC();
                alertInformacionActualiza(datos);
            },
        });
    } else {
        alertInformacionVacia();
    }
}


function consultaFaseProyectoDEP(idProyecto) {
    $("#dataOptionDEP").html('');
    const action = "consultaFaseProyectoDEP";
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto,
        },
        success: function (datos) {
            if (datos != "") {
                alertInformacionActualiza('Registro Actualizado', datos);
                $("#dataOptionDEP").html(datos);
            }
        },
    });
}


function agregarFaseProyectoDEP(fase) {
    const action = "agregarFaseProyectoDEP";
    const idProyecto = $("#idProyectoStatus").val();
    $.ajax({
        type: "post",
        url: "php/crud.php",
        data: {
            action: action,
            idProyecto: idProyecto,
            fase: fase
        },
        success: function (datos) {
            if (datos != "") {
                alertInformacionActualiza(datos);
                // consultaFaseProyectoDEP(idProyecto);
            }
        },
    });
}