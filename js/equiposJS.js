function obtenerSubsecciones() {
    var idSeccion = $("#cbSeccion").val();
    $.ajax({
        type: 'post',
        url: 'php/equiposPHP.php',
        data: 'action=obtenerSubsecciones&idSeccion=' + idSeccion,
        success: function (data) {
            $("#cbSubseccion").html(data);
        }
    })
}

function agregarMP(idPlan, idEquipo, semana) {
    $.ajax({
        type: 'post',
        url: 'php/equiposPHP.php',
        data: 'action=agregarMP&idPlan=' + idPlan + '&idEquipo=' + idEquipo + '&semana=' + semana,
        success: function (data) {
            if (data == 1) {
                location.reload();
            } else {
                toastr.error(data, 'Error', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-center",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            }
        }
    })
}

function obtEquipoXPagina(idDestino, pagina) {
    $.ajax({
        type: 'post',
        url: 'php/equiposPHP.php',
        data: 'action=obtEquipoXPagina&idDestino=' + idDestino + '&pagina=' + pagina,
        success: function (data) {
            $("#divEquipos").html("");
            $("#divEquipos").html(data);
        }
    });
}

function obtEquipoXBusqueda(idDestino, pagina) {
    var busqueda = $("#txtBusqueda").val();
    $.ajax({
        type: 'post',
        url: 'php/equiposPHP.php',
        data: 'action=busqueda&idDestino=' + idDestino + '&pagina=' + pagina + '&busqueda=' + busqueda,
        success: function (data) {
            $("#divEquipos").html("");
            $("#divEquipos").html(data);
        }
    });
}

function obtEquipoXBusquedaXPagina(idDestino, pagina) {
    var busqueda = $("#txtBusqueda").val();
    $.ajax({
        type: 'post',
        url: 'php/equiposPHP.php',
        data: 'action=busqueda&idDestino=' + idDestino + '&pagina=' + pagina + '&busqueda=' + busqueda,
        success: function (data) {
            $("#divEquipos").html("");
            $("#divEquipos").html(data);
        }
    });
}

function obtEquiposXFiltrado(idDestino, pagina) {
    if (idDestino == 10) {
        var destino = $("#selectDestinos").val();
    } else {
        var destino = idDestino;
    }
    var seccion = $("#cbSeccion").val();
    var subseccion = $("#cbSubseccion").val();

    $.ajax({
        type: 'post',
        url: 'php/equiposPHP.php',
        data: 'action=filtrar&idDestino=' + destino + '&seccion='
                + seccion + '&subseccion=' + subseccion + '&pagina=' + pagina,
        success: function (data) {
            $("#divEquipos").html("");
            $("#divEquipos").html(data);
        }
    });
}

function obtEquiposXFiltradoXPagina(idDestino, pagina) {
    if (idDestino == 10) {
        var destino = $("#selectDestinos").val();
    } else {
        var destino = idDestino;
    }
    var seccion = $("#cbSeccion").val();
    var subseccion = $("#cbSubseccion").val();

    $.ajax({
        type: 'post',
        url: 'php/equiposPHP.php',
        data: 'action=filtrar&idDestino=' + destino + '&seccion='
                + seccion + '&subseccion=' + subseccion + '&pagina=' + pagina,
        success: function (data) {
            $("#divEquipos").html("");
            $("#divEquipos").html(data);
        }
    });
}

function editarEquipo(idEquipo){
    
}