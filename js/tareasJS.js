//function insertarCausa() {
//    var btnCancelar = document.getElementById("btnCancelarCausa");
//    $.ajax({
//        type: 'post',
//        url: 'php/tareasPHP.php',
//        data: 'action=27',
//        beforeSend: function () {
//            $(".loader").show();
//        },
//        success: function (data) {
//            $(".loader").fadeOut('slow');
//            document.getElementById("hdIdTareaCausa").value = data;
//            btnCancelar.setAttribute("onclick", "borrarCausaVacia(" + data + ")");
//        }
//    });
//}
//
//function crearCausa(idTarea, idUsuario) {
//    try {
//        var idCausa = document.getElementById("hdIdTareaCausa").value;
//        var titulo = document.getElementById("txtCausa").value;
//
//        if (titulo != "") {
//            $.ajax({
//                type: 'post',
//                url: 'php/tareasPHP.php',
//                data: 'action=28&idTarea=' + idTarea + '&titulo=' + titulo + '&idUsuario=' + idUsuario +
//                        '&idCausa=' + idCausa,
//                beforeSend: function () {
//                    $(".loader").show();
//                },
//                success: function (data) {
//                    $(".loader").fadeOut('slow');
//                    if (data == 1) {
//                        location.reload();
//                    } else {
//                        app.toast(data, {
//                            actionTitle: "ACEPTAR",
//                            actionColor: "danger",
//                            duration: 5000
//                        });
//                    }
//                }
//            });
//        }
//    } catch (ex) {
//        app.toast('Exception: ' + ex, {
//            duration: 5000
//        });
//    }
//
//}
//
//function borrarCausaVacia(idCausa) {
//    try {
//        $.ajax({
//            type: 'post',
//            url: 'php/tareasPHP.php',
//            data: 'action=29&idCausa=' + idCausa,
//            beforeSend: function () {
//                $(".loader").show();
//            },
//            success: function (data) {
//                $(".loader").fadeOut('slow');
//                if (data == 1) {
//                    app.toast('CAUSA CANCELADA', {
//                        actionTitle: "ACEPTAR",
//                        actionColor: "success",
//                        duration: 5000
//                    });
//                } else {
//                    app.toast(data, {
//                        actionTitle: "ACEPTAR",
//                        actionColor: "danger",
//                        duration: 5000
//                    });
//                }
//            }
//        });
//    } catch (ex) {
//        app.toast('Exception: ' + ex, {
//            duration: 5000
//        });
//    }
//}

//INICIO SECCION DE GESTION DE TAREAS

//Insertar tareas nuevas 
function insertarTarea(idSubcategoria, idSeccion) {
    var btnCancelar = document.getElementById("btnCancelar");
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=1&idSubcategoria=' + idSubcategoria,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("hdIdTarea").value = data;
            btnCancelar.setAttribute("onclick", "borrarTareaVacia(" + data + ")");
        }
    });
    if (idSeccion == 13 || idSeccion == 14) {
        $.ajax({
            type: 'post',
            url: '../php/tareasPHP.php',
            data: 'action=37&idSubcategoria=' + idSubcategoria + '&idSeccion=' + idSeccion,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                $("#divCbHab").html(data);
            }
        });
    } else {
        $.ajax({
            type: 'post',
            url: '../php/tareasPHP.php',
            data: 'action=14&idGrupo=' + idSubcategoria + '&idSeccion=' + idSeccion,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                $("#cbEquipos").html(data);
                $('.selectpicker').selectpicker('refresh');
            }
        });
    }

}

/*Creado 21-08-2018
 * Funciona para recoger los datos del formulario y enviarlos a la base de datos
 */
function crearTarea(idSeccion, idUsuario, idDestino) {
    try {
        var idTarea = document.getElementById("hdIdTarea").value;
        var desc = document.getElementById("txtDescTarea").value;
        var descripcion = desc.split("\n").join(" ");
        var fecI = document.getElementById("txtFechaInicio").value;
        var fecF = document.getElementById("txtFechaFin").value;
        var tipo = document.getElementById("cbTipo").value;
        var cap = "";
        if (tipo == 1 || tipo == 3) {
            var titulo = document.getElementById("cbSituacion").value;
        } else {
            var titulo = document.getElementById("cbSituacion").value;
            var tipoCap = document.getElementsByName("cap");
            for (i = 0; i < tipoCap.length; i++) {
                if (tipoCap[i].checked) {
                    cap = tipoCap[i].value;
                    break;
                }
            }
        }

        if (idDestino == 10) {
            idDestino = document.getElementById("cbDestinosPer").value;
        }

        if (idSeccion == 13 || idSeccion == 14) {
            var chkb = document.getElementById("chkbHab");
            if (chkb.checked) {
                var numHab = document.getElementById("cbHab").value;
            } else {
                var numHab = 0;
            }
        } else {
            var numHab = 0;
        }

        var aImgU = document.getElementById("cbResponsable").value;
        var mc = document.getElementById("chkbMC");
        if (mc.checked) {
            mc = "SI";
            var equipos = $("#cbEquipos").val();
            var eext = document.getElementById("chkbEEx");
            if (eext.checked) {
                var empresa = document.getElementById("cbEmpresaEx").value;
                var coste = document.getElementById("txtTotalMPC").value;
            } else {
                var empresa = 0;
                var coste = "";
            }
        } else {
            mc = "NO";
            var equipos = "";
            var empresa = 0;
            var coste = "";
        }

        if (titulo != "" && fecI != "" && aImgU.length > 0) {
            $.ajax({
                type: 'post',
                url: '../php/tareasPHP.php',
                data: 'action=2&idTarea=' + idTarea + '&titulo=' + titulo + '&descripcion=' + descripcion + '&fecI=' + fecI +
                        '&fecF=' + fecF + '&aImgU=' + aImgU +
                        '&idUsuario=' + idUsuario + '&idDestino=' + idDestino + '&idSeccion=' + idSeccion
                        + '&tipo=' + tipo + '&cap=' + cap + '&numHab=' + numHab + '&mc=' + mc + '&equipos=' + JSON.stringify(equipos)
                        + '&empresa=' + empresa + '&coste=' + coste,
                beforeSend: function (data) {
                    $(".loader").show();
                },
                success: function (data) {
                    if (data == 1) {
                        $(".loader").fadeOut('slow');
                        location.reload();
                    } else {
                        alert(data);
                    }
                }
            });
        } else {
            alert("Verifique los campos");
        }
    } catch (ex) {
        alert(ex);
    }

}

//Hablita los select para la copia de una tarea 
function habilitarCB(element) {
    var destino = document.getElementById("chkbDestino");
    var subcategoria = document.getElementById("chkbSubcat");

    if (destino.checked) {
        document.getElementById("cbColDestino").disabled = false;
    } else {
        document.getElementById("cbColDestino").disabled = true;
    }

    if (subcategoria.checked) {
        document.getElementById("cbColSubcategoria").disabled = false;
    } else {
        document.getElementById("cbColSubcategoria").disabled = true;
    }
}

//Copia una tarea 
function copiarTarea(pagina) {

    var chkbDestino = document.getElementById("chkbDestino");
    var chkbSubcategoria = document.getElementById("chkbSubcat");

    if (pagina == 1) {
        var url = '../php/tareasPHP.php';
    } else {
        var url = 'php/tareasPHP.php';
    }
    var idTarea = document.getElementById("idTareaHidden").value;

    if (chkbDestino.checked) {
        var columnaDestino = document.getElementById("cbColDestino").value;
    } else {
        var columnaDestino = "";
    }
    if (chkbSubcategoria.checked) {
        var columnaSubCat = document.getElementById("cbColSubcategoria").value;
    } else {
        var columnaSubCat = "";
    }
    if (chkbDestino.checked || chkbSubcategoria.checked) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'action=31&idTarea=' + idTarea + '&columnaDestino=' + columnaSubCat + '&destino=' + columnaDestino,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    alert("Tarea copiada");
                    location.reload();
                } else {
                    alert(data);
                }
            }
        });
    }

}

//Elimina una tarea
function eliminarTarea(pagina) {
    if (pagina == 1) {
        var url = '../php/tareasPHP.php';
    } else {
        var url = 'php/tareasPHP.php';
    }
    var idTarea = document.getElementById("idTareaHidden").value;
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=32&idTarea=' + idTarea,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                alert("Tarea eliminada");
                location.reload();
            } else {
                alert(data);
            }
        }
    });
}
/*Creado 31-08-2018
 * Funciona para eliminar una tarea vacia
 */
function borrarTareaVacia(idTarea) {
    try {
        $.ajax({
            type: 'post',
            url: '../php/tareasPHP.php',
            data: 'action=3&idTarea=' + idTarea,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');

            }
        });
    } catch (ex) {
        alert(ex);
    }
}

//Obtener detalles de las tareas
function obtDetalleTarea(idTarea) {
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=43&idTarea=' + idTarea + '&pagina=1',
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            try {
                var tarea = JSON.parse(data);
                document.getElementById("idTareaHidden").value = tarea.id;
                document.getElementById("titulo-tarea").value = tarea.titulo;
                document.getElementById("descripcion-tarea").value = tarea.descripcion;
                document.getElementById("fechaI").value = tarea.fechaI
                document.getElementById("fechaF").value = tarea.fechaF;
                document.getElementById("cbStatus").value = tarea.status;
                document.getElementById("cbSeccion").value = tarea.idSeccion;
                document.getElementById("logoSeccion").setAttribute("src", "../svg/" + tarea.logoSeccion + "");
                document.getElementById("cbColumna").value = tarea.idSubcategoria;
                document.getElementById("comentariosSeccion").innerHTML = tarea.comentarios;
                document.getElementById("adjuntos").innerHTML = tarea.adjuntos;
                document.getElementById("planAccion").innerHTML = tarea.planAccion;
                document.getElementById("btnResponsable").innerHTML = tarea.responsable;
                document.getElementById("btnResponsable2").innerHTML = tarea.responsable2;
                document.getElementById("numHab").innerHTML = tarea.numHabitacion;
                document.getElementById("creador").innerHTML = tarea.creador;
                if (tarea.idDestinoCreador == 10) {
                    $("#imgOMA").show();
                } else {
                    $("#imgOMA").hide();
                }

                if (tarea.tipoCap == "capex" || tarea.tipoCap == "capin") {//Si son tareas CAPEX o CAPIN
                    $("#btnAddCot").show();
                    $("#divDatosCap").show();
                    document.getElementById("txtAño").value = tarea.año;
                    document.getElementById("txtTotal").value = tarea.total;
                    document.getElementById("hddTipoCap").value = tarea.tipoCap;
                    if (tarea.tipoCap == 'capex') {
                        document.getElementById("cbTipoDet").value = 4;
                    } else {
                        document.getElementById("cbTipoDet").value = 3;
                    }

                    $("#cbTipoDet").attr('onchange', "cambiarTipo(" + tarea.id + ", 1)");
                    h1 = screen.height - 640;
                    h2 = screen.height - 350;
                    h3 = screen.height - 250;
                } else {
                    if (tarea.mc == "SI") {//Si es una tarea con MC ZHC
                        $("#divManttoC").show();
                        $("#empresaMC").html(tarea.empresaEx);
                        $("#equiposMC").html(tarea.equiposMC);
                        h1 = screen.height - 700;
                        h2 = screen.height - 350;
                        h3 = screen.height - 250;
                    } else {
                        $("#divManttoC").hide();
                        h1 = screen.height - 600;
                        h2 = screen.height - 350;
                        h3 = screen.height - 250;
                    }

                    document.getElementById("cbTipoDet").value = tarea.tipo;
                    $("#cbTipoDet").attr('onchange', "cambiarTipo(" + tarea.id + ", 1)");
                    $("#btnAddCot").hide();
                    $("#divDatosCap").hide();
                }



                $("#cbColumna").attr('onchange', "cambiarCol(" + tarea.id + ", 1)");
                $("#cbSeccion").attr('onchange', "cambiarSeccion(" + tarea.id + ", 1)");
                $('[data-toggle="tooltip"]').tooltip();

                var divPA = document.getElementById("planAccion");
                divPA.setAttribute("style", "width: 100%; height: " + h1 + "px; overflow: auto;")
                var seccionComentario = document.getElementById("comentariosSeccion");
                seccionComentario.setAttribute("style", "width: 100%; height: " + h2 + "px; overflow: auto;");
                var divComentarios = document.getElementById("divComentarios");
                divComentarios.setAttribute("onmousedown", "obtenerComentarios(" + idTarea + "); obtenerAdjuntosTarea(" + idTarea + ", 0, 1);");

            } catch (ex) {
                alert(ex);
            }
        }
    });
}
//Ibtener detalles de una tarea desde el dashboard
function obtDetalleTarea2(idTarea) {
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=43&idTarea=' + idTarea + '&pagina=0',
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            try {
                var tarea = JSON.parse(data);
                document.getElementById("idTareaHidden").value = tarea.id;
                document.getElementById("titulo-tarea").value = tarea.titulo;
                document.getElementById("descripcion-tarea").value = tarea.descripcion;
                document.getElementById("fechaI").value = tarea.fechaI
                document.getElementById("fechaF").value = tarea.fechaF;
                document.getElementById("cbStatus").value = tarea.status;
                document.getElementById("cbSeccion").value = tarea.idSeccion;
                document.getElementById("logoSeccion").setAttribute("src", "svg/" + tarea.logoSeccion + "");
                document.getElementById("cbColumna").value = tarea.idSubcategoria;
                document.getElementById("comentariosSeccion").innerHTML = tarea.comentarios;
                document.getElementById("adjuntos").innerHTML = tarea.adjuntos;
                document.getElementById("planAccion").innerHTML = tarea.planAccion;
                document.getElementById("btnResponsable").innerHTML = tarea.responsable;
                document.getElementById("btnResponsable2").innerHTML = tarea.responsable2;
                document.getElementById("numHab").innerHTML = tarea.numHabitacion;
                document.getElementById("creador").innerHTML = tarea.creador;
                if (tarea.idDestinoCreador == 10) {
                    $("#imgOMA").show();
                } else {
                    $("#imgOMA").hide();
                }

                if (tarea.tipoCap == "capex" || tarea.tipoCap == "capin") {//Si son tareas CAPEX o CAPIN
                    $("#btnAddCot").show();
                    $("#divDatosCap").show();
                    document.getElementById("txtAño").value = tarea.año;
                    document.getElementById("txtTotal").value = tarea.total;
                    document.getElementById("hddTipoCap").value = tarea.tipoCap;
                    if (tarea.tipoCap == 'capex') {
                        document.getElementById("cbTipoDet").value = 4;
                    } else {
                        document.getElementById("cbTipoDet").value = 3;
                    }

                    $("#cbTipoDet").attr('onchange', "cambiarTipo(" + tarea.id + ", 0)");
                    h1 = screen.height - 640;
                    h2 = screen.height - 350;
                    h3 = screen.height - 250;
                } else {
                    if (tarea.mc == "SI") {//Si es una tarea con MC ZHC
                        $("#divManttoC").show();
                        $("#empresaMC").html(tarea.empresaEx);
                        $("#equiposMC").html(tarea.equiposMC);
                        h1 = screen.height - 700;
                        h2 = screen.height - 350;
                        h3 = screen.height - 250;
                    } else {
                        $("#divManttoC").hide();
                        h1 = screen.height - 600;
                        h2 = screen.height - 350;
                        h3 = screen.height - 250;
                    }

                    document.getElementById("cbTipoDet").value = tarea.tipo;
                    $("#cbTipoDet").attr('onchange', "cambiarTipo(" + tarea.id + ", 0)");
                    $("#btnAddCot").hide();
                    $("#divDatosCap").hide();
                }



                $("#cbColumna").attr('onchange', "cambiarCol(" + tarea.id + ", 0)");
                $("#cbSeccion").attr('onchange', "cambiarSeccion(" + tarea.id + ", 0)");
                $('[data-toggle="tooltip"]').tooltip();


                var divPA = document.getElementById("planAccion");
                divPA.setAttribute("style", "width: 100%; height: " + h1 + "px; overflow: auto;")
                var seccionComentario = document.getElementById("comentariosSeccion");
                seccionComentario.setAttribute("style", "width: 100%; height: " + h2 + "px; overflow: auto;");
                var divComentarios = document.getElementById("divComentarios");
                divComentarios.setAttribute("onmousedown", "obtenerComentarios(" + idTarea + ", 0, 0); obtenerAdjuntosTarea(" + idTarea + ", 0, 0);");

            } catch (ex) {
                alert(ex);
            }

        }
    });
}
//Cambiar el responsable de la tarea
function actualizarResponsable(idTarea, idUsuario, pagina, modal, resp) {
    if (modal == 1) {
        idTareaAccion = document.getElementById("idTareaHidden").value;
        idTarea = document.getElementById("idSubtareaHidden").value;
    } else {
        idTarea = document.getElementById("idTareaHidden").value;
    }
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=47&idTarea=' + idTarea + '&idUsuario=' + idUsuario + '&pagina=' + pagina + '&modal=' + modal + '&resp=' + resp,

        success: function (data) {
            $(".loader").fadeOut('slow');
            if (modal == 1) {
                obtenerSubtareas(idTareaAccion, pagina);
                $('[data-toggle="tooltip"]').tooltip();
            } else {
                if (resp == 1) {
                    document.getElementById("btnResponsable").innerHTML = data;
                } else {
                    document.getElementById("btnResponsable2").innerHTML = data;
                }

                $('[data-toggle="tooltip"]').tooltip();
            }

        }
    });
}
//Agregar usuario a cada seccion 
function agregarUsuarioPermitido(idDestino, idSeccion, idUsuario) {
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=12&idSeccion=' + idSeccion + '&idUsuario=' + idUsuario + '&idDestino=' + idDestino,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                location.reload();
            } else {
                alert(data);
            }
        }
    });
}
//obtiene usuario permitido en seccion
function obtUsuarioPermitido(idSP) {
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=51&idSP=' + idSP,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            var user = JSON.parse(data);
            document.getElementById("tituloSeccion").innerHTML = user.seccion;
            document.getElementById("nombreUsuario").innerHTML = user.nombre;
            $("#btnRemove").attr('onclick', 'removerPermitido(' + idSP + ')');
        }
    });
}
//remover usuario de seccion
function removerPermitido(idSP) {
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=52&idSP=' + idSP,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                location.reload();
            } else {
                alert(data);
            }
        }
    });
}

/*
 * Vuelve una tarea al status no iniciada
 */
function reiniciarTarea(idTarea, container) {
    try {
        var pagina = document.getElementById("hiddenPagina").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=11&idTarea=' + idTarea,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadColTarea(container, 'N', pagina);
            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=11&idTarea=' + idTarea,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('TAREA PENDIENTE', {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}
/*
 * vuelve una tarea al estado procesar
 */
function procesarTarea(idTarea, container) {
    try {
        var pagina = document.getElementById("hiddenPagina").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=10&idTarea=' + idTarea,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadColTarea(container, 'P', pagina);
            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=10&idTarea=' + idTarea,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('TAREA EN PROCESO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "warning",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}
/*
 * vuelve una tarea al status solucionado
 */
function completarTarea(idTarea, idUsuario, container) {
    try {
        var pagina = document.getElementById("hiddenPagina").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=9&idTarea=' + idTarea + '&idUsuario=' + idUsuario,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadColTarea(container, 'F', pagina);
            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=9&idTarea=' + idTarea + '&idUsuario=' + idUsuario,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('TAREA SOLUCIONADA', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function reloadColTarea(columna, status, pagina) {
    var col = document.getElementById(columna);
    var idSeccion = document.getElementById("hiddenSeccion").value;
    var idUser = document.getElementById("hiddenIdUser").value;
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=19&idSeccion=' + idSeccion + '&status=' + status + '&idUsuario=' + idUser + '&pagina=' + pagina,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            col.innerHTML = "";
            col.innerHTML += data;
        }
    });
}

function capinRechazado(idTarea, container) {
    try {
        var idSeccion = document.getElementById("hdSeccion").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=15&idTarea=' + idTarea + '&status=',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadCol(container, idSeccion, '');

            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=15&idTarea=' + idTarea + '&status=',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('CAPIN RECHAZADO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function capinAprobado(idTarea, container) {
    try {
        var idSeccion = document.getElementById("hdSeccion").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=15&idTarea=' + idTarea + '&status=A',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadCol(container, idSeccion, 'A');

            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=15&idTarea=' + idTarea + '&status=A',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('CAPIN APROBADO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function capinProceso(idTarea, container) {
    try {
        var idSeccion = document.getElementById("hdSeccion").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=15&idTarea=' + idTarea + '&status=P',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadCol(container, idSeccion, 'P');

            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=15&idTarea=' + idTarea + '&status=P',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('CAPIN EN PROCESO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function capinSolucionado(idTarea, container) {
    try {
        var idSeccion = document.getElementById("hdSeccion").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=15&idTarea=' + idTarea + '&status=F',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadCol(container, idSeccion, 'F');

            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=15&idTarea=' + idTarea + '&status=F',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('CAPIN FINALIZADO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function reloadCol(columna, idSeccion, status) {
    var col = document.getElementById(columna);
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=17&idSeccion=' + idSeccion + '&status=' + status,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            col.innerHTML = "";
            col.innerHTML += data;
        }
    });
}

function capexRechazado(idTarea, container) {
    try {
        var idSeccion = document.getElementById("hdSeccion").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=16&idTarea=' + idTarea + '&status=',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadColCapex(container, idSeccion, '');

            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=16&idTarea=' + idTarea + '&status=',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('CAPEX RECHAZADO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function capexAprobado(idTarea, container) {
    try {
        var idSeccion = document.getElementById("hdSeccion").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=16&idTarea=' + idTarea + '&status=A',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadColCapex(container, idSeccion, 'A');

            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=16&idTarea=' + idTarea + '&status=A',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('CAPEX APROBADO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function capexProceso(idTarea, container) {
    try {
        var idSeccion = document.getElementById("hdSeccion").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=16&idTarea=' + idTarea + '&status=P',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadColCapex(container, idSeccion, 'P');

            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=16&idTarea=' + idTarea + '&status=P',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('CAPEX EN PROCESO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function capexSolucionado(idTarea, container) {
    try {
        var idSeccion = document.getElementById("hdSeccion").value;
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=16&idTarea=' + idTarea + '&status=F',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                reloadColCapex(container, idSeccion, 'F');

            }
        });
    } catch (ex) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=16&idTarea=' + idTarea + '&status=F',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    app.toast('CAPEX SOLUCIONADO', {
                        actionTitle: "ACEPTAR",
                        actionColor: "success",
                        duration: 5000
                    });
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }

}

function reloadColCapex(columna, idSeccion, status) {
    var col = document.getElementById(columna);
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=18&idSeccion=' + idSeccion + '&status=' + status,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            col.innerHTML = "";
            col.innerHTML += data;
        }
    });
}
//envia una tarea a capin 
function tareaToCapin(idTarea, idUsuario) {
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=13&idTarea=' + idTarea + '&idUsuario=' + idUsuario,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                app.toast('TAREA SE ENVIO A CAPIN', {
                    actionTitle: "ACEPTAR",
                    actionColor: "success",
                    duration: 5000
                });
            } else {
                app.toast(data, {
                    actionTitle: "ACEPTAR",
                    actionColor: "danger",
                    duration: 5000
                });
            }
        }
    });
}
//envia una tarea a capex
function tareaToCapex(idTarea, idUsuario) {
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=14&idTarea=' + idTarea + '&idUsuario=' + idUsuario,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                app.toast('TAREA SE ENVIO A CAPEX', {
                    actionTitle: "ACEPTAR",
                    actionColor: "success",
                    duration: 5000
                });
            } else {
                app.toast(data, {
                    actionTitle: "ACEPTAR",
                    actionColor: "danger",
                    duration: 5000
                });
            }
        }
    });
}
//envia comentarios a la tarea
function enviarComentario(idTarea, idUsuario) {
    var comentario = document.getElementById("txtComentario").value;
    if (comentario != "") {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=4&idTarea=' + idTarea + '&idUsuario=' + idUsuario + '&comentario=' + comentario,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    document.getElementById("txtComentario").value = "";
                    obtenerComentarios(idTarea);
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }
}
//obtiene todos los comentarios de la tarea
function obtenerComentarios(idTarea, pagina, idSubtarea) {
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    if (idSubtarea == undefined) {
        idSubtarea = 0;
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=5&idTarea=' + idTarea + '&pagina=' + pagina + '&idSubtarea=' + idSubtarea,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaComent = document.getElementById("comentariosSeccion");
            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

//FIN SECCION DE GESTION DE TAREAS

//INICIO SECCION DE GESTION DE SUBTAREAS
//agrega una subtarea a la tarea
function crearSubtarea(idTarea, idUsuario) {
    var planAccion = document.getElementById("txtPlanAccion").value;
    var duracion = document.getElementById("cbDuracion").value;
    var fechaLim = document.getElementById("txtFecL").value;

    var chkbEE = document.getElementById("chkbEE");
    if (chkbEE.checked) {
        var empresaE = document.getElementById("cbEE").value;
    } else {
        var empresaE = 0;
    }

    var aImgU = [];
    var imgU = $(".avatar-list-pa>img");
    //Obtener id de los usuarios involucrados
    for (i = 0; i < $(".avatar-list-pa>img").length; i++) {
        aImgU[i] = imgU[i].id;
    }

    if (planAccion != "") {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=6&idTarea=' + idTarea + '&planaccion=' + planAccion + '&duracion=' + duracion + '&fechaL=' + fechaLim +
                    '&aImgU=' + JSON.stringify(aImgU) + '&idUsuario=' + idUsuario + '&empresaE=' + empresaE,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    document.getElementById("txtPlanAccion").value = "";
                    obtenerSubtareas(idTarea);
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }
}
//obtiene una subtarea
function obtenerSubtarea(idSubtarea, pagina, idUsuario) {
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=24&idSubtarea=' + idSubtarea,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var subtarea = JSON.parse(data);
            document.getElementById("txtEditTituloSubtarea").value = subtarea.subtarea;
            document.getElementById("txtFechaFinSubtarea").value = subtarea.fecLimite;
            $("#btnSalvar").attr("onclick", "actualizarSubtarea(" + idSubtarea + ", " + subtarea.idTarea + ",  " + pagina + ")");

        }
    });
}

function actualizarSubtarea(idSubtarea, idTarea, pagina, idUsuario) {
    var titulo = document.getElementById("txtEditTituloSubtarea").value;
    var fechaLimite = document.getElementById("txtFechaFinSubtarea").value;
    var eliminar = document.getElementById("chkbEliminar");
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }

    if (eliminar.checked) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'action=23&idSubtarea=' + idSubtarea + '&titulo=' + titulo + '&fechaLimite=' + fechaLimite + '&evento=delete',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    obtenerSubtareas(idTarea, pagina);
                    $("#modal-editar-subtarea").modal('hide');
                } else {
                    alert(data);
                }
            }
        });
    } else {
        $.ajax({
            type: 'post',
            url: url,
            data: 'action=23&idSubtarea=' + idSubtarea + '&titulo=' + titulo + '&fechaLimite=' + fechaLimite + '&evento=update',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    obtenerSubtareas(idTarea, pagina);
                    $("#modal-editar-subtarea").modal('hide');
                } else {
                    alert(data);
                }
            }
        });
    }
}

function eliminarSubtarea(element, idTarea) {
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=23&idSubtarea=' + element.id + '&evento=delete',
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            obtenerSubtareas(idTarea);
        }

    });
}
//obtener la lista de subtareas
function obtenerSubtareas(idTarea, pagina) {

    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }

    $.ajax({
        type: 'post',
        url: url,
        data: 'action=7&idTarea=' + idTarea + '&pagina=' + pagina,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaSubtareas = document.getElementById("planAccion");
            cajaSubtareas.innerHTML = "";
            cajaSubtareas.innerHTML = data;
            $('[data-toggle="tooltip"]').tooltip();
            $('.fecha-accion').dateDropper();
        }
    });
}
//marca una subtarea como terminada
function completarSubTarea(element, idTarea, pagina) {
    var idST = element.id;
    var idSubtarea = idST.split("_");

    if (element.checked) {
        var status = "F"
    } else {
        var status = "N";
    }

    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }

    $.ajax({
        type: 'post',
        url: url,
        data: 'action=8&idSubtarea=' + idSubtarea[1] + '&status=' + status,

        success: function (data) {
            $(".loader").fadeOut('slow');

        }
    });
}

function obtenerComentariosSubtarea(idTarea, pagina, idSubtarea) {
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=5&idTarea=' + idTarea + '&pagina=' + pagina + '&idSubtarea=' + idSubtarea,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaComent = document.getElementById("comentariosSeccion");
            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

//FIN SECCION DE GESTION DE SUBTAREAS

//carga un archivo al servidor
function tarea_subir_doc(pagina, idTarea, idSubtarea) {
    var idTarea = document.getElementById("idTareaHidden").value;
    if (idSubtarea == undefined) {
        idSubtarea = 0;
        var inputFileImage = document.getElementById("tareaDoc");
    } else {
        var inputFileImage = document.getElementById("tareaDoc" + idSubtarea + "");
    }

    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('id', idTarea);

    data.append('idSubtarea', idSubtarea);
    //data.append('id', id_slide);

    if (pagina == 0) {
        var url = "php/tareas_subir_adjunto.php";
    } else {
        var url = "../php/tareas_subir_adjunto.php";
    }

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            alert(data);
            obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

//SUBIR ADJUNTO PARA CAUSAS
function tarea_causas_subir_doc() {

    var idCausa = document.getElementById("hdIdTareaCausa").value;
    var inputFileImage = document.getElementById("tareaCausaDoc");
    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('id', idCausa);
    //data.append('id', id_slide);

    $.ajax({
        url: "php/tareas_causas_subir_adjunto.php", // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            //            $(".upload-msg").html("<div class='alert alert-success alert-dismissible fade show' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button><strong>Completado!</strong> El archivo se cargo correctamente.</div>");
            $(".upload-msg").html(data);
        }
    });
}

function tarea_subir_cap(pagina) {
    var idTarea = document.getElementById("idTareaHidden").value;
    var tipoCap = document.getElementById("hddTipoCap").value;
    var inputFileImage1 = document.getElementById("tareaCot1");
    var inputFileImage2 = document.getElementById("tareaCot2");
    var inputFileImage3 = document.getElementById("tareaCot3");
    var file1 = inputFileImage1.files[0];
    var file2 = inputFileImage2.files[0];
    var file3 = inputFileImage3.files[0];
    var coste1 = document.getElementById("txtCot1").value;
    var coste2 = document.getElementById("txtCot2").value;
    var coste3 = document.getElementById("txtCot3").value;
    var data = new FormData();
    data.append('fileToUpload1', file1);
    data.append('fileToUpload2', file2);
    data.append('fileToUpload3', file3);
    data.append('cot1', coste1);
    data.append('cot2', coste2);
    data.append('cot3', coste3);
    data.append('tipoCap', tipoCap);
    data.append('id', idTarea);

    //data.append('id', id_slide);

    if (pagina == 0) {
        var url = "php/tareas_cap_subir_adjunto.php";
    } else {
        var url = "../php/tareas_cap_subir_adjunto.php";
    }

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            alert(data);
            obtenerAdjuntosTarea(idTarea, 0, pagina);
        }
    });
}

function costeCap(idTarea, tipo) {
    var coste = document.getElementById("txtCoste").value;
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=20&idTarea=' + idTarea + '&coste=' + coste,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            app.toast("Cotizacion Almacenada", {
                actionTitle: "ACEPTAR",
                actionColor: "success",
                duration: 5000
            });
        }
    });
}

function updateStatCap(element, idDocCap, idTarea) {
    if (element.checked) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=22&idDoc=' + idDocCap + '&idTarea=' + idTarea + '&stat=SI',
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');

            }
        });
    }
}

function getUserByDestiny(pagina, modal, element) {
    if (modal == 1) {
        var idDestino = document.getElementById("cbUsuariosDestinoAccion").value;
        var idTarea = document.getElementById("idTareaHidden").value;
    } else {
        var idDestino = element.value;
        var idTarea = document.getElementById("idTareaHidden").value;
    }


    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }

    $.ajax({
        type: 'post',
        url: url,
        data: 'action=26&idDestino=' + idDestino + '&idTarea=' + idTarea + '&pagina=' + pagina + '&modal=' + modal,

        success: function (data) {
            $(".loader").fadeOut('slow');
            if (modal == 1) {
                document.getElementById("userListAccion").innerHTML = "";
                document.getElementById("userListAccion").innerHTML = data;
            } else if (modal == 2) {
                document.getElementById("userListPermitidos").innerHTML = "";
                document.getElementById("userListPermitidos").innerHTML = data;

            } else {
                if (element.id == "cbUsuariosDestino") {
                    document.getElementById("userList").innerHTML = "";
                    document.getElementById("userList").innerHTML = data;
                } else {
                    document.getElementById("userList2").innerHTML = "";
                    document.getElementById("userList2").innerHTML = data;
                }

            }

        }
    });
}

function obtUserSeccion(idSeccion) {

    var idDestino = document.getElementById("cbUserPerDest").value;

    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=50&idDestino=' + idDestino + '&idSeccion=' + idSeccion,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("userListPermitidos").innerHTML = "";
            document.getElementById("userListPermitidos").innerHTML = data;
        }
    });
}

function showRep() {
    var reprogramar = document.getElementById("chkbReprogramar");
    if (reprogramar.checked) {
        document.getElementById("fecRep").style.display = "block";
    } else {
        document.getElementById("fecRep").style.display = "none";
    }
}

function showEE() {
    var empresaE = document.getElementById("chkbEE");
    if (empresaE.checked) {
        document.getElementById("divEE").style.display = "block";
    } else {
        document.getElementById("divEE").style.display = "none";
    }
}

function addGastoDiario(idTarea) {
    var gastoD = document.getElementById("txtGastoDiario").value;
    if (gastoD != "") {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=30&idTarea=' + idTarea + '&gastoD=' + gastoD,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    location.reload();
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }
}

function addGastoG(idTarea) {
    var gastoG = document.getElementById("txtDescripcionG").value;
    var costeG = document.getElementById("txtCosteG").value;
    if (gastoG != "" && costeG) {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=31&idTarea=' + idTarea + '&gastoG=' + gastoG + '&costeG=' + costeG,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    location.reload();
                } else {
                    app.toast(data, {
                        actionTitle: "ACEPTAR",
                        actionColor: "danger",
                        duration: 5000
                    });
                }
            }
        });
    }
}

function tipoTarea() {
    var tipo = document.getElementById("cbTipo").value;
    if (tipo == 1 || tipo == 3) {
        //document.getElementById("divSituaciones").style.display = "block";
        document.getElementById("divProyecto").style.display = "none";
    } else {
        //document.getElementById("divSituaciones").style.display = "none";
        document.getElementById("divProyecto").style.display = "block";
    }
}

function mostrarTipo(idDestino) {
    var rdbtnTipo = document.getElementsByName("tipo");
    for (i = 0; i < rdbtnTipo.length; i++) {
        if (rdbtnTipo[i].checked) {
            var tipo = rdbtnTipo[i].value;
            break;
        }
    }
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=33&tipo=' + tipo + '&idDestino=' + idDestino,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            $("#dFilas").html("");
            $("#dFilas").html(data);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function mostrarTipoMisTareas(idDestino, idUsuario, tipo) {

    switch (tipo) {
        case 1:
            $("#btnPendientes").addClass("active2");
            $("#btnProyectos").removeClass("active2");
            break;
        case 2:
            $("#btnPendientes").removeClass("active2");
            $("#btnProyectos").addClass("active2");
            break;

    }

    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=38&tipo=' + tipo + '&idUsuario=' + idUsuario + '&idDestino=' + idDestino,

        success: function (data) {
            $(".loader").fadeOut('slow');
            $("#dFilas").html("");
            $("#dFilas").html(data);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function cargarTableroDestino() {
    var destino = document.getElementsByName("destinos");
    for (i = 0; i <= destino.length; i++) {
        if (destino[i].checked) {
            var idDestino = destino[i].value;
            break;
        }
    }
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=34&idDestino=' + idDestino,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            $("#btnresumen").attr('href', 'tareas-resumen.php?idDestino=' + idDestino);
            $("#btnresumenusers").attr('href', 'tareas-resumen-usuarios.php?idDestino=' + idDestino);
            $("#divTableros").html(data);

        }
    });
}

function cargarTareasDestino(pagina) {
    if (pagina == 1) {
        var url = "../php/tareasPHP.php";
    } else {
        var url = "php/tareasPHP.php";
    }
    var destino = document.getElementById("cbDestinos").value;
//    for (i = 0; i <= destino.length; i++) {
//        if (destino[i].checked) {
//            var idDestino = destino[i].value;
//            break;
//        }
//    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=34&idDestino=' + destino,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            location.reload();

        }
    });
}

function enviarSolicitud(idUsuario) {
    var seccion = document.getElementById("cbSeccion").value;
    var subseccion = document.getElementById("cbSubseccion").value;
    var titulo = document.getElementById("txtTitulo").value;
    var email = document.getElementById("txtEmail").value;

    if (titulo != "") {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=35&seccion=' + seccion + '&subseccion=' + subseccion + '&titulo=' + titulo +
                    '&idUsuario=' + idUsuario + '&email=' + email,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                var idTarea = document.getElementById("hdIdTarea").value
                borrarTareaVacia(idTarea);
                location.reload();
            }
        });
    }

}

function readNot(idNot) {
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=36&idNotificacion=' + idNot,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');

        }
    });
}

function readAll() {
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=46',
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');

        }
    });
}

$(document).ready(function () {
    var refresh = setInterval(buscarNot, 5000);
    $.ajaxSetup({cache: false});
});

function buscarNot() {
    $("#liNot").load(" #divNot");
}

function mostrarHab() {
    var chkbHab = document.getElementById("chkbHab");
    if (chkbHab.checked) {
        document.getElementById("divCbHab").style.display = "block";
    } else {
        document.getElementById("divCbHab").style.display = "none";
    }
}

function agregarMotivoBloq(idTarea, idUsuario) {
    var motivo = document.getElementById("txtMotivoBloq").value;
    if (motivo != "") {
        $.ajax({
            type: 'post',
            url: 'php/tareasPHP.php',
            data: 'action=39&idTarea=' + idTarea + '&idUsuario=' + idUsuario + '&motivo=' + motivo,
            beforeSend: function () {
                $(".loader").show();
            },
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    location.reload();
                }
            }
        });
    }
}

function desbloquearHab(idTarea, idUsuario) {
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=40&idTarea=' + idTarea + '&idUsuario=' + idUsuario,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                location.reload();
            }
        }
    });
}

function showToMove() {
    $(".toMove").show();
}

function hideToMove() {
    $(".toMove").hide();
}

function agregarClass(element) {
    event.preventDefault();
    $("#" + element.id + "").addClass("bg-gris-2");
}

function quitarClass(element) {
    $("#" + element.id + "").removeClass("bg-gris-2");
}

function dragstart(caja, evento) {
    // el elemento a arrastrar
    event.dataTransfer.setData('Data', caja.id);
}

function drop(target, evento) {
    // obtenemos los datos
    var caja = event.dataTransfer.getData('Data');//La tarejta de la tarea
    // agregamos el elemento de arrastre al contenedor
    target.appendChild(document.getElementById(caja));
    $("div.columnas").removeClass("bg-gris-2");
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=41&idTarea=' + caja + '&idSubcategoria=' + target.id,
        success: function (data) {
            $(".loader").fadeOut('slow');

        }
    });
}

function showhideCols(idPermiso, idUsuario) {
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
        url: "php/tareasPHP.php",
        data: "action=42&idSeccion=" + selected + "&idUsuario=" + idUsuario + '&idPermiso=' + idPermiso + '&tipo=' + tipo,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("dFilas").innerHTML = "";
            document.getElementById("dFilas").innerHTML = data;
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function editarTitulo(idTarea) {
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=43&idTarea=' + idTarea,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            var tarea = JSON.parse(data);
            document.getElementById("txtTitulo").value = tarea.titulo;
            document.getElementById("txtDesc").value = tarea.descripcion;
        }
    });
}

function guardarTitulo(idTarea) {
    var tituloNuevo = document.getElementById("txtTitulo").value;
    var descripcion = document.getElementById("txtDesc").value;
    $.ajax({
        type: 'post',
        url: 'php/tareasPHP.php',
        data: 'action=44&idTarea=' + idTarea + '&titulo=' + tituloNuevo + '&descripcion=' + descripcion,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                app.toast("Titulo cambiado", {
                    actionTitle: "ACEPTAR",
                    actionColor: "success",
                    duration: 5000
                });
            } else {
                app.toast(data, {
                    actionTitle: "ACEPTAR",
                    actionColor: "danger",
                    duration: 5000
                });
            }
        }
    });
}

function setFocus() {
    document.getElementById("txtChecklist").focus();
}

function setIdSubtarea(idSubtarea) {
    document.getElementById("idSubtareaHidden").value = idSubtarea;
}

//CAMBIAR EL TIPO DE TAREA, PENDIENTE, SITUACION O PROYECTO
function cambiarTipo(idTarea, pagina) {
    var tipo = document.getElementById("cbTipoDet").value;
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=45&idTarea=' + idTarea + '&tipo=' + tipo,

        success: function (data) {
            $(".loader").fadeOut('slow');

        }
    });
}

//CAMBIAR LA SECCION A LA QUE PÉRTECNE LA TAREA
function cambiarSeccion(idTarea, pagina) {
    var seccion = document.getElementById("cbSeccion").value;
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=39&idTarea=' + idTarea + '&seccion=' + seccion,
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (pagina == 0) {
                $("#logoSeccion").attr("src", "svg/" + data + "");
            } else {
                $("#logoSeccion").attr("src", "../svg/" + data + "");
            }

        }
    });
}

//CAMBIAR LA SUBCATEGORIA A LA QUE PÉRTECNE LA TAREA
function cambiarCol(idTarea, pagina) {
    var col = document.getElementById("cbColumna").value;
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=46&idTarea=' + idTarea + '&col=' + col,

        success: function (data) {
            $(".loader").fadeOut('slow');

        }
    });
}

//ACTUALIZA LAS FECHAS DE INICIO Y DE FIN 
function cambiarFecha(tipoFec, pagina) {
    var idTarea = document.getElementById("idTareaHidden").value;
    if (tipoFec == "i") {
        var fecha = document.getElementById("fechaI").value;
    } else {
        var fecha = document.getElementById("fechaF").value;
    }

    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }

    $.ajax({
        type: 'post',
        url: url,
        data: 'action=48&tipoFec=' + tipoFec + '&fecha=' + fecha + '&idTarea=' + idTarea,

        success: function (data) {
            $(".loader").fadeOut('slow');

        }
    });
}

//CMABIAR EL ESTADO DE LA TAREA, PENDIENTE, EN PROCESO, FINALIZADA
function cambiarEstado(pagina) {
    var idTarea = document.getElementById("idTareaHidden").value;
    var estado = document.getElementById("cbStatus").value;

    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }

    $.ajax({
        type: 'post',
        url: url,
        data: 'action=49&idTarea=' + idTarea + '&estado=' + estado,

        success: function (data) {
            $(".loader").fadeOut('slow');

        }
    });
}

function cargarPermitidosDestino(idSeccion) {
    var destino = document.getElementById("cbDestinosPer").value;
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=53&idDestino=' + destino + '&idSeccion=' + idSeccion,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("cbResponsable").innerHTML = "";
            document.getElementById("cbResponsable").innerHTML = data;
        }
    });

}

function obtenerPlanAccion(idSeccion, idDestino) {
    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=54&idSeccion=' + idSeccion + '&idDestino=' + idDestino,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("bodyTablaAcciones").innerHTML = data;
        }
    });
}

function obtenerAdjuntosTarea(idTarea, idSubtarea, pagina) {
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=55&idTarea=' + idTarea + '&idSubtarea=' + idSubtarea + '&pagina=' + pagina,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("adjuntos").innerHTML = data;
        }
    });
}

function obtUsuariosPorDestino() {
    var cbDestino = document.getElementById("cbDestinos").value;

    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=56&idDestino=' + cbDestino,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("cbUsuarios").innerHTML = data;
        }
    });
}

function obtPenFin(idSeccion, idDestino, element) {
    var status = element.checked;

    $.ajax({
        type: 'post',
        url: '../php/tareasPHP.php',
        data: 'action=57&idSeccion=' + idSeccion + '&idDestino=' + idDestino + '&status=' + status,

        success: function (data) {
            $(".loader").fadeOut('slow');
            $("#dFilas").html("");
            $("#dFilas").html(data);
            $('[data-toggle="tooltip"]').tooltip();
            h1 = screen.height - 220;
            h2 = screen.height - 230;
            h3 = screen.height - 300;
            h4 = screen.height - 260;
            var divFilas = document.getElementById("dFilas");
            var divColumnas = document.getElementsByClassName("columnas");
            divFilas.setAttribute("style", "width: 100%; height: " + h1 + "px;");
            for (i = 0; i < divColumnas.length; i++) {
                divColumnas[i].setAttribute("style", "width: 100%; height: " + h2 + "px; overflow: auto;");
            }
            $(".columnas").mCustomScrollbar({
                theme: "minimal-dark"
            });
        }
    });
}

function buscarTarea(idSeccion, idDestino, word) {
    var chkb = document.getElementById("chkbPendFin");
    var statusTask = "";
    if (chkb.checked) {
        statusTask = "N";
    } else {
        statusTask = "F";
    }
    var w = word.value;
    if (w != "") {
        $.ajax({
            type: 'post',
            url: '../php/tareasPHP.php',
            data: 'action=13&word=' + w + '&idSeccion=' + idSeccion + '&idDestino=' + idDestino + '&statusTask=' + statusTask,

            success: function (data) {
                $(".loader").fadeOut('slow');
                $("#dFilas").html(data);
                h1 = screen.height - 220;
                h2 = screen.height - 230;

                var divFilas = document.getElementById("dFilas");
                var divColumnas = document.getElementsByClassName("columnas");
                divFilas.setAttribute("style", "width: 100%; height: " + h1 + "px;");
                for (i = 0; i < divColumnas.length; i++) {
                    divColumnas[i].setAttribute("style", "width: 100%; height: " + h2 + "px; overflow: auto;");
                }
            }
        });
    }

}

function mostrarEmpresaExterna() {
    var eEx = document.getElementById("chkbMC");
    if (eEx.checked) {
        $("#divMC").show();
    } else {
        $("#divMC").hide();
    }

}

function mostrarEE() {
    var eEx = document.getElementById("chkbEEx");
    if (eEx.checked) {
        $("#datosEE").show();
    } else {
        $("#datosEE").hide();

    }

}

function agregarComentarioST(pagina, idTarea, idSubtarea, idUsuario) {
    if (pagina == 0) {
        var url = 'php/tareasPHP.php';
    } else {
        var url = '../php/tareasPHP.php';
    }
    var comentario = document.getElementById("txtComentarioST" + idSubtarea + "").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: url,
                data: 'action=4&idTarea=' + idTarea + '&idSubtarea=' + idSubtarea + '&idUsuario=' + idUsuario + '&comentario=' + comentario,

                success: function (data) {
                    $(".loader").fadeOut('slow');
                    document.getElementById("txtComentarioST" + idSubtarea + "").value = "";
                    obtenerComentarios(idTarea, pagina, idSubtarea);
                }
            });
        } else {
            alert("No puede enviar comentarios vacios");
        }
    }

}
function filtrarComentarios(idSubtarea) {

}