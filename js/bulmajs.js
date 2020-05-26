//document.addEventListener('DOMContentLoaded', () => {
//
//    // Get all "navbar-burger" elements
//    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);
//
//    // Check if there are any navbar burgers
//    if ($navbarBurgers.length > 0) {
//
//        // Add a click event on each of them
//        $navbarBurgers.forEach(el => {
//            el.addEventListener('click', () => {
//
//                // Get the target from the "data-target" attribute
//                const target = el.dataset.target;
//                const $target = document.getElementById(target);
//
//                // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
//                el.classList.toggle('is-active');
//                $target.classList.toggle('is-active');
//
//            });
//        });
//    }
//
//});

function showHide(action, idDestino, idSubseccion, pagina) {
    if (action == "show") {
        $("#seccionSelects").hide();
        $("#seccionColumnas").hide();
        $("#seccionHoteles").hide();
        $("#sectionHeroMain").hide();
        $("#sectionHeroListaEquipos").show();
        $("#seccionListaEquipos").show();
    } else if (action == "hoteles") {
        $("#seccionSelects").hide();
        $("#seccionColumnas").hide();
        $("#seccionListaEquipos").hide();
        $.ajax({
            type: 'post',
            url: 'php/hotelesPHP.php',
            data: 'action=obtHoteles&idDestino=' + idDestino
                    + '&idSubseccion=' + idSubseccion
                    + '&pagina=' + pagina,
            success: function (data) {
                $("#listaHoteles").html(data);
                $("#seccionHoteles").show();
            }
        });
    } else {
        $("#seccionSelects").show();
        $("#seccionColumnas").show();
        $("#sectionHeroMain").show();
        $("#sectionHeroListaEquipos").hide();
        $("#seccionListaEquipos").hide();
        $("#seccionHoteles").hide();
    }
}

function showListaTareas(action) {
    if (action == "show") {
        $("#seccionListaEquipos").hide();
        $("#lista-tareas").show();
    } else {
        $("#seccionListaEquipos").show();
        $("#lista-tareas").hide();
    }
}

function showDetallesTarea(action) {
    if (action == "show") {
        $("#lista-tareas").hide();
        $("#detalle-tarea").show();
    } else {
        $("#lista-tareas").show();
        $("#detalle-tarea").hide();
    }
}

function showMPMC(action, mantto) {
    if (action == "show") {
        if (mantto == "MC") {
            $("#seccionListaEquipos").hide();
            $("#columnaCorrectivos").show();
            $("#columnaPreventivos").hide();
            $("#mc").removeClass("is-outlined");
            $("#mp").addClass("is-outlined");
            $("#columnaStatusMC").show();
            $("#columnaAñadirCorrectivo").show();
            $("#columnaControles").hide();
            $("#columnaHistorialMP").hide();
            $("#inicioMP").hide();
            $("#divDetalleOT").hide();
            $("#seccionMPMC").show();
            $("#divDetalleOT").hide();
            $("#columnaAdjuntosEquipo").hide();
        } else {
            $("#seccionListaEquipos").hide();
            $("#columnaCorrectivos").hide();
            $("#columnaPreventivos").show();
            $("#mc").addClass("is-outlined");
            $("#mp").removeClass("is-outlined");
            $("#columnaStatusMC").hide();
            $("#columnaAñadirCorrectivo").hide();
            $("#columnaControles").show();
            $("#columnaHistorialMP").hide();
            $("#inicioMP").hide();
            $("#divDetalleOT").hide();
            $("#seccionMPMC").show();
            $("#divDetalleOT").hide();
            $("#columnaAdjuntosEquipo").hide();
        }

    } else {
        $("#seccionListaEquipos").show();
        $("#seccionMPMC").hide();
    }
}

function home() {
    $("#seccionColumnas").show();
    $("#seccionListaEquipos").hide();
    $("#lista-tareas").hide();
    $("#detalle-tarea").hide();
    $("#seccionMPMC").hide();
    $("#seccionDetalleProyectos").hide();
}

function showModal(idModal) {
    $("#" + idModal + "").toggleClass('is-active');
}

function closeModal(idModal) {
    $("#" + idModal + "").toggleClass('is-active');
}

function mostrarMCMP(action) {
    if (action == "mp") {
        $("#columnaCorrectivos").hide();
        $("#columnaPreventivos").show();
        $("#mc").addClass("is-outlined");
        $("#mp").removeClass("is-outlined");
        $("#btnPlaneacion").removeClass('is-outlined');
        $("#btnHistorial").addClass('is-outlined');
        $("#btnManuales").addClass('is-outlined');
        $("#columnaStatusMC").hide();
        $("#columnaAñadirCorrectivo").hide();
        $("#columnaControles").show();
        $("#inicioMP").hide();
        $("#columnaHistorialMP").hide();
        $("#divDetalleOT").hide();
        $("#columnaAdjuntosEquipo").hide();
    } else {
        $("#columnaCorrectivos").show();
        $("#columnaPreventivos").hide();
        $("#columnaHistorialMP").hide();
        $("#mc").removeClass("is-outlined");
        $("#mp").addClass("is-outlined");
        $("#columnaStatusMC").show();
        $("#columnaAñadirCorrectivo").show();
        $("#columnaControles").hide();
        $("#inicioMP").hide();
        $("#divDetalleOT").hide();
        $("#columnaAdjuntosEquipo").hide();
    }
}

function showDetallesTareaMC(action) {
    if (action == "show") {
        $("#seccionMPMC").hide();
        $("#detalle-tarea-mc").show();
    } else {
        $("#seccionMPMC").show();
        $("#detalle-tarea-mc").hide();
    }
}

function showMP(action) {
    if (action == "planeacion") {
        $("#btnPlaneacion").removeClass('is-outlined');
        $("#btnHistorial").addClass('is-outlined');
        $("#btnManuales").addClass('is-outlined');
        $("#columnaPreventivos").show();
        $("#columnaHistorialMP").hide();
        $("#inicioMP").hide();
        $("#divDetalleOT").hide();
        $("#columnaAdjuntosEquipo").hide();
    } else if (action == "historial") {
        $("#btnPlaneacion").addClass('is-outlined');
        $("#btnHistorial").removeClass('is-outlined');
        $("#btnManuales").addClass('is-outlined');
        $("#columnaHistorialMP").show();
        $("#columnaPreventivos").hide();
        $("#inicioMP").hide();
        $("#divDetalleOT").hide();
        $("#columnaAdjuntosEquipo").hide();
    } else {
        $("#btnPlaneacion").addClass('is-outlined');
        $("#btnHistorial").addClass('is-outlined');
        $("#btnManuales").removeClass('is-outlined');
        $("#columnaPreventivos").hide();
        $("#columnaHistorialMP").hide();
        $("#inicioMP").hide();
        $("#divDetalleOT").hide();
        $("#columnaAdjuntosEquipo").show();
    }
}

function mostrarInicioMP() {
    $("#columnaPreventivos").hide();

    $("#divDetalleOT").hide();
    $("#inicioMP").show();
}

function mostrarDetalleOT() {
    $("#columnaPreventivos").hide();
    $("#columnaHistorialMP").hide();
    $("#inicioMP").hide();
    $("#columnaAdjuntosEquipo").hide();
    $("#divDetalleOT").show();
}

function mostrarInfoProyecto(action) {
    if (action == "show") {
        $("#seccionColumnas").hide();
        $("#seccionListaEquipos").hide();
        $("#seccionDetalleProyectos").show();
    } else {
        $("#seccionColumnas").show();
        $("#seccionListaEquipos").hide();
        $("#seccionDetalleProyectos").hide();
    }
}

function mostrarInfoProyecto2(action) {
    if (action == "show") {
        $("#seccionTablaProyectos").hide();
        $("#seccionDetalleProyectos").show();
    } else {
        location.reload();
    }
}

function activeTab(idTab) {
    if (idTab == "usuario") {
        $("#tab-usuario").addClass("is-active");
        $("#tab-perfil").removeClass("is-active");
    } else {
        $("#tab-usuario").removeClass("is-active");
        $("#tab-perfil").addClass("is-active");
    }
    $(".tab-pane").hide();
    $("#" + idTab + "").show();
}

function activeTabEvolutivo(idTab) {
    if (idTab == "acs") {
        $("#tab-acs").addClass("is-active");
        $("#tab-aa").removeClass("is-active");
    } else {
        $("#tab-acs").removeClass("is-active");
        $("#tab-aa").addClass("is-active");
    }
    $(".tab-pane").hide();
    $("#" + idTab + "").show();
}

function activeTabGastos(idTab) {
    switch (idTab) {
        case 'tab-materiales':
            $("#materiales").addClass("is-active");
            $("#servicios").removeClass("is-active");
            $("#tab-materiales").show();
            $("#tab-servicios").hide();
            break;
        case 'tab-servicios':
            $("#materiales").removeClass("is-active");
            $("#servicios").addClass("is-active");
            $("#tab-materiales").hide();
            $("#tab-servicios").show();
            break;

    }

    $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
}

function activeTabInfo(idTab) {
    switch (idTab) {
        case 'todo':
            $("#todo-tab").addClass("is-active");
            $("#materiales-tab").removeClass("is-active");
            $("#servicios-tab").removeClass("is-active");

            $("#pill-todo").show();
            $("#pill-servicios").hide();
            $("#pill-materiales").hide();
            break;
        case 'materiales':
            $("#todo-tab").removeClass("is-active");
            $("#materiales-tab").addClass("is-active");
            $("#servicios-tab").removeClass("is-active");

            $("#pill-todo").hide();
            $("#pill-servicios").hide();
            $("#pill-materiales").show();
            break;
        case 'servicios':
            $("#todo-tab").removeClass("is-active");
            $("#materiales-tab").removeClass("is-active");
            $("#servicios-tab").addClass("is-active");

            $("#pill-todo").hide();
            $("#pill-servicios").show();
            $("#pill-materiales").hide();
            break;
    }


}