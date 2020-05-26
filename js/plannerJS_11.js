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

function mostrarColumnas(element) {
    var id = element.id;
    switch (id) {
        case 'btnMC':
            $("#btnMC").addClass("active");
            $("#btnMP").removeClass("active");
            $("#btnTest").removeClass("active");
            $("#btnSol").removeClass("active");
            $("#btnInfo").removeClass("active");
            $("#colMC").show();
            $("#colMP").hide();
            $("#colTest").hide();
            $("#colSol").hide();
            $("#colInfo").hide();

            break;
        case 'btnMP':
            $("#btnMC").removeClass("active");
            $("#btnMP").addClass("active");
            $("#btnTest").removeClass("active");
            $("#btnSol").removeClass("active");
            $("#btnInfo").removeClass("active");
            $("#colMC").hide();
            $("#colMP").show();
            $("#colTest").hide();
            $("#colSol").hide();
            $("#colInfo").hide();

            break;
        case 'btnTest':
            $("#btnMC").removeClass("active");
            $("#btnMP").removeClass("active");
            $("#btnTest").addClass("active");
            $("#btnSol").removeClass("active");
            $("#btnInfo").removeClass("active");
            $("#colMC").hide();
            $("#colMP").hide();
            $("#colTest").show();
            $("#colSol").hide();
            $("#colInfo").hide();

            break;
        case 'btnSol':
//            $("#btnMC").removeClass("active");
//            $("#btnMP").removeClass("active");
//            $("#btnTest").removeClass("active");
//            $("#btnSol").addClass("active");
//            $("#colMC").hide();
//            $("#colMP").hide();
//            $("#colTest").hide();
//            $("#colSol").show();

            break;
        case 'btnInfo':
            $("#btnMC").removeClass("active");
            $("#btnMP").removeClass("active");
            $("#btnTest").removeClass("active");
            $("#btnSol").removeClass("active");
            $("#btnInfo").addClass("active");
            $("#colMC").hide();
            $("#colMP").hide();
            $("#colTest").hide();
            $("#colSol").hide();
            $("#colInfo").show();
            break;
    }
}

function buscarEquipoPorPalabra(element, idDestino, idSubseccion, idCategoria, idSubcategoria) {
    var word = element.value;
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=1&word=' + word + '&idDestino=' + idDestino + '&idCategoria=' + idCategoria
                + '&idSubseccion=' + idSubseccion + '&idSubcategoria=' + idSubcategoria,
        success: function (data) {
            $("#colListaEquipos").html(data);
//            var $table = $('#tablePlaneacion');
//            var $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');
//
//            $fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();
//
//            $fixedColumn.find('tr').each(function (i, elem) {
//                $(this).height($table.find('tr:eq(' + i + ')').height());
//            });
        }
    });
}

//OBTENER LA LISTA DE EQUIPOS DE LA SUBSECCION
function obtenerEquipos(idGrupo, idDestino, idCategoria, idSubcategoria, idRelCatSubcat) {
    //$("#txtAddActividad").attr("onkeypress", "agregarActivdadPA(" + 0 + ", " + idGrupo + ", " + idDestino + ", " + idSubcategoria + ", " + 6 + ", " + idRelCatSubcat + ")");
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=2&idGrupo=' + idGrupo + '&idDestino=' + idDestino + '&idCategoria=' + idCategoria + '&idSubcategoria=' + idSubcategoria + '&idRelCatSubcat=' + idRelCatSubcat,

        success: function (data) {
            var datos = JSON.parse(data);
            //document.getElementById("divLoader").style.display = "none";
//$("#divListaEquipos").html("");
            $("#divNombreSubseccion").attr('data-content', datos.nombreSubseccion);

            $("#divListaEquipos").html(datos.listaEquipos);
            $("#divListaEquipos").show();
//            $("#txtBuscarEquipo").attr("onkeyup", "buscarEquipoPorPalabra(this, " + idDestino + ", " + idGrupo + ", " + idCategoria + ", " + idSubcategoria + ")");
//            var tPlaneacion = $("#tablePlaneacion").DataTable({
//                "order": [[1, "asc"]],
//                "select": true,
//                scrollY: "50vh",
//                scrollX: true,
//                scrollCollapse: true,
//                paging: true,
//                ordering: false,
//                pageLength: 50,
//                fixedHeader: true, 
//                fixedColumns: {
//                    leftColumns: 1,
//                },
//                "language": {
//                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
//                }
//            });

            //cargarEquipos(idGrupo, idDestino, idCategoria, idSubcategoria, idRelCatSubcat);

        }
    });
}

function mostrarListaEquipos(element) {
    var idRdbtn = element.id;
    if (idRdbtn == "rdbtnTipoTarea1") {
        $("#divListEquipos").hide();
    } else {
        $("#divListEquipos").show();
    }
}

function cargarEquipos(idGrupo, idDestino, idCategoria, idSubcategoria, idRelCatSubcat) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=81&idGrupo=' + idGrupo + '&idDestino=' + idDestino + '&idCategoria=' + idCategoria + '&idSubcategoria=' + idSubcategoria + '&idRelCatSubcat=' + idRelCatSubcat,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $("#cbTareaEquipo").html(data);
            $("#cbTareaEquipo").selectpicker("refresh");
        }
    });
}

function agregarActivdadPA(idEquipo, idGrupo, idDestino, idSubcategoria, idCategoria, idRelSubcategoria) {
    //
    var actividad = $("#txtAddActividadPA").val();
    var rdbtnchecked = $("input:radio[name=tipoTarea]:checked").val();
    if (rdbtnchecked == "equipo" && rdbtnchecked != undefined) {
        var idEquipo = $("#cbTareaEquipo").val();
    }
    var responsable = $("#cbResponsableTarea").val();
    var semana = $("#cbSemanaRealizacion").val();

    if (actividad != "") {
        if (rdbtnchecked != undefined) {
            if (rdbtnchecked != "equipo") {
                idEquipo = 0;
            }
            $.ajax({
                type: 'post',
                url: 'php/plannerPHP.php',
                data: 'action=4&idEquipo=' + idEquipo + '&actividad=' + actividad
                        + '&idGrupo=' + idGrupo + '&idDestino=' + idDestino + '&idCategoria='
                        + idCategoria + '&idSubcategoria=' + idSubcategoria + '&responsable=' + responsable + '&semana=' + semana,
                success: function (data) {
                    if (data == 1) {
                        $("#txtAddActividadPA").val("");
                        if (rdbtnchecked == "equipo") {//Si esta checkeado tarea a equipo
                            obtDetalleEquipo(idEquipo, idGrupo, idDestino, idCategoria, idSubcategoria);
                            $("#modal-detalle-tarea").modal("show");
                        } else {
                            obtDetalleSubcategoria(idGrupo, idDestino, idCategoria, idSubcategoria, idRelSubcategoria);
                            $("#modal-detalle-planaccion").modal("show");
                        }
                        $("#modal-agregar-tarea").modal("hide");


                    } else {
                        toastr.error(data, 'Error', {
                            "closeButton": true,
                            "newestOnTop": true,
                            "positionClass": "toast-top-right",
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
            });
        } else {
            toastr.warning("Debe de seleccionar si es tarea general o para un equipo.", 'Revise los campos', {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right",
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

    } else {
        toastr.warning("El campo de actividad no debe estar vacio", 'Revise los campos', {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right",
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

    //}

}


function obtGantEquipo(idEquipo) {
    $("#hddIdEquipo").val(idEquipo);
    $("#hddModal").val('acumulado');
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=74&idEquipo=' + idEquipo,
        success: function (data) {
            $("#divGantEquipoAcumulado").html(data);
            $("#tablePlaneacionMP").dataTable().fnDestroy();
            var tPlaneacion = $("#tablePlaneacionMP").DataTable({
                "order": [[1, "asc"]],
                "select": false,
                scrollY: "50vh",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                ordering: false,
                fixedColumns: true,
                autoWidth: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                }
            });
        }
    });
}

//SECCION PARA FUNCIONES QUE SE REALIZAN POR MEDIO DE EQUIPOS EN CONCRETO

function obtDetalleEquipo(idEquipo, idGrupo, idDestino, idCategoria, idSubcategoria) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=3&idEquipo=' + idEquipo,
        success: function (data) {
            try {
                var detalleEquipo = JSON.parse(data);

                $("#txtAddActividad").attr("onkeypress", "agregarActivdadMC(" + idEquipo + ", " + idGrupo + ", " + idDestino + ", " + idSubcategoria + ", " + idCategoria + ")");
                $("#txtActividadExtra").attr("onkeypress", "insertarActividadAdicional(" + detalleEquipo.idTipoEquipo + ")");
                $("#txtAddComentariosMC").attr("onkeypress", "agregarComentariosMC(0, " + idEquipo + ")");
                $("#txtAddComentariosTest").attr("onkeypress", "agregarComentariosTestGeneral(0, " + idEquipo + ")");
                $("#planAccion").html(detalleEquipo.planMC);
                $("#planMP").html(detalleEquipo.planMP);
                $("#historicoMP").html(detalleEquipo.historicoMP);
                $("#historicoOT").html(detalleEquipo.historicoOT);
//                $("#historicoMP").html("");
//                $("#historicoOT").html("");
                $("#graficaGant").html(detalleEquipo.graficaGant);
                $("#tests").html(detalleEquipo.test);
                $("#info").html(detalleEquipo.infoEquipo);
                $("#hddIdEquipo").val(idEquipo);
                $("#nombreEquipo").html(detalleEquipo.nombreEquipo);
                $("#comentariosSeccion").html(detalleEquipo.comentarios);
                $("#adjuntos").html(detalleEquipo.adjuntos);
                $("#comentariosSeccionTest").html(detalleEquipo.comentariosTest);
                $("#adjuntosTest").html(detalleEquipo.adjuntosTest);

                var divComentarios = document.getElementById("comentariosSeccion");
                divComentarios.setAttribute("onmousedown", "obtenerComentariosMC(0, " + idEquipo + ");");
                var divComentariosTest = document.getElementById("divComentariosTest");
                divComentariosTest.setAttribute("onmousedown", "obtenerComentariosTestGeneral(0, " + idEquipo + ");");

                var tPlaneacion = $("#tablePlaneacionMP").DataTable({
                    "order": [[1, "asc"]],
                    "select": false,
                    scrollY: "50vh",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    ordering: false,
                    fixedColumns: true,
                    autoWidth: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    }
                });

                var historicoMP = $("#tablaHistorico").DataTable({
                    "order": [[1, "asc"]],
                    "select": true,
                    "scrollY": "30vh",
                    "scrollCollapse": true,
                    "paging": false,
                    "autoWidth": false,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Mantenimiento Preventivo',
                            className: 'btn-no btn-sm shadow-sm'
                        },
                        {
                            extend: 'pdf',
                            title: 'Mantenimiento Preventivo',
                            className: 'btn-no btn-sm shadow-sm',
                            orientation: 'landscape',

                        },
                    ],
                    initComplete: function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                                );

                                        column
                                                .search(val ? '^' + val + '$' : '', true, false)
                                                .draw();
                                    });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        });
                    }

                });

                var historicoOT = $("#tablaHistoricoOT").DataTable({
                    "order": [[1, "asc"]],
                    "select": true,
                    "scrollY": "30vh",
                    "scrollCollapse": true,
                    "paging": false,
                    "autoWidth": false,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Mantenimiento Preventivo',
                            className: 'btn-no btn-sm shadow-sm'
                        },
                        {
                            extend: 'pdf',
                            title: 'Mantenimiento Preventivo',
                            className: 'btn-no btn-sm shadow-sm',
                            orientation: 'landscape',

                        },
                    ],
                    initComplete: function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                                );

                                        column
                                                .search(val ? '^' + val + '$' : '', true, false)
                                                .draw();
                                    });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        });
                    }

                });

                historicoOT
                        .on('select', function (e, dt, type, indexes) {
                            var rowData = historicoOT.rows(indexes).data().toArray();
                            verOT(rowData[0][1], rowData[0][0]);
                        })


                $(".selectpicker").selectpicker('refresh');
                $('[data-toggle="tooltip"]').tooltip();
            } catch (ex) {
                alert(ex + " - " + data);
            }


        }
    });
}

function guardarCambiosEquipo() {
    var idEquipo = $("#hddIdEquipo").val();
    var matricula = $("#txtMatriculaEquipo").val();
    var marca = $("#cbMarcaEquipo").val();
    var modelo = $("#txtModeloEquipo").val();
    var serie = $("#txtSerieEquipo").val();
    var estado = $("#cbEstadoEquipo").val();

    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=57&idEquipo=' + idEquipo + '&matricula=' + matricula + '&marca=' + marca + '&modelo=' + modelo
                + '&serie=' + serie + '&estado=' + estado,
        success: function (data) {
            if (data == 1) {
                recargarDatosEquipo(idEquipo);
            } else {
                alert(data);
            }
        }
    });
}

function agregarValorUnidadEquipo() {
    var idEquipo = $("#hddIdEquipo").val();
    var campo = document.getElementById("cbUnidad").value;
    var valor = document.getElementById("txtValorUnidad").value;

    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=59&idEquipo=' + idEquipo + '&campo=' + campo + '&valor=' + valor,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                recargarDatosEquipo(idEquipo);
            }
        }
    });
}

function recargarDatosEquipo(idEquipo) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=58&idEquipo=' + idEquipo,
        success: function (data) {
            $("#info").html(data);
            $(".selectpicker").selectpicker('refresh');
        }
    });
}

function agregarActivdadMC(idEquipo, idGrupo, idDestino, idSubcategoria, idCategoria) {
    if (event.keyCode == 13) {
        var actividad = $("#txtAddActividad").val();
        if (actividad != "") {
            $.ajax({
                type: 'post',
                url: 'php/plannerPHP.php',
                data: 'action=4&idEquipo=' + idEquipo + '&actividad=' + actividad
                        + '&idGrupo=' + idGrupo + '&idDestino=' + idDestino + '&idCategoria=' + idCategoria + '&idSubcategoria=' + idSubcategoria,
                success: function (data) {
                    if (data == 1) {
                        recargarMC(idEquipo);
                        $("#txtAddActividad").val("");
                    } else {
                        alert(data);
                    }
                }
            });
        }

    }

}

function recargarMC(idEquipo) {
    var chkb = document.getElementById("myonoffswitch");
    if (chkb.checked == true) {
        var status = "N";
    } else {
        var status = "F";
    }
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=5&idEquipo=' + idEquipo + '&status=' + status,
        success: function (data) {
            $("#planAccion").html(data);
        }
    });
}

function agregarResponsable(idUsuario) {
    var idActividad = $("#hddIdActividad").val();
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=7&idUsuario=' + idUsuario + '&idActividad=' + idActividad,
        success: function (data) {
            if (data == 1) {
                if (idEquipo != 0) {
                    recargarMC(idEquipo);
                } else {
                    recargarMCPA(idSubseccion, idDestino, idCategoria, idSubcategoria);
                }
                $('#modal-agregar-responsable').modal('hide');

            } else {
                alert(data);
            }
        }
    });
}

function completarTarea(idActividad, element, idUsuario) {
    var chkb = element.checked;
    var idCheckbox = element.id;
    $("#modal-completar-tarea").modal('show');
    $("#btnFinalizarTarea").attr("onclick", "finalizarTarea(" + idActividad + "," + chkb + "," + idUsuario + ")");
    $("#btnCancelarFinalizarTarea").attr("onclick", "cancelarCompletarTarea(" + idCheckbox + ")");
}

function cancelarCompletarTarea(idCheckbox) {
    var verPenFin = $("#myonoffswitch");
    var verPenFin2 = $("#myonoffswitch2");
    if (verPenFin[0].checked == true) {
        idCheckbox.checked = false;
    } else {
        idCheckbox.checked = true;
    }
    if (verPenFin2[0].checked == true) {
        idCheckbox.checked = false;
    } else {
        idCheckbox.checked = true;
    }

}

function finalizarTarea(idActividad, chkb, idUsuario) {
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();
    //var chkb = element.checked;
    if (chkb == true) {
        var status = "F";
    } else {
        var status = "N";
    }
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=8&idActividad=' + idActividad + '&status=' + status + '&completo=' + idUsuario,
        success: function (data) {
            if (idEquipo != 0) {
                recargarMC(idEquipo);
            } else {
                recargarMCPA(idSubseccion, idDestino, idCategoria, idSubcategoria);
            }
            $("#modal-completar-tarea").modal('hide');
            //$("#modal-completar-tarea").modal('dispose');
        }
    });
}

function verPenFin(element) {
    var idCHKB = element.id;
    var chkb = element.checked;
    if (idCHKB == "myonoffswitch") {
        var idEquipo = $("#hddIdEquipo").val();
    } else {
        var idEquipo = 0;
    }

    if (chkb == true) {
        var status = "N";
    } else {
        var status = "F";
    }

    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=10&idEquipo=' + idEquipo + '&status=' + status,
        success: function (data) {
            if (idCHKB == "myonoffswitch") {
                $("#planAccion").html(data);
            } else {
                $("#planAccionPA").html(data);
            }

        }
    });

}

//FIN SECCION PARA FUNCIONES QUE SE REALIZAN POR MEDIO DE EQUIPOS EN CONCRETO

//SECCION PARA REALIZAR FUNCIONES QUE SE REALIZAN POR MEDIO DE UNA SUBCATEGORIA

function obtDetalleSubcategoria(idGrupo, idDestino, idCategoria, idSubcategoria, idRelSubcategoria) {
    var idEquipo = 0;
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=27&idSubseccion=' + idGrupo + '&idDestino=' + idDestino + '&idCategoria='
                + idCategoria + '&idSubcategoria=' + idSubcategoria + '&idRelSubcategoria=' + idRelSubcategoria,
        success: function (data) {
            try {
                var detalleEquipo = JSON.parse(data);
                $("#divListaTareas").html("");
                $("#divListaTareas").html(detalleEquipo.planMC);
                $("#btnPendientesPA").attr("onclick", "verPenSubcategorias(this, " + idDestino + ", " + idGrupo + ", " + idCategoria + "," + idSubcategoria + ")");
                $("#btnSolucionadosPA").attr("onclick", "verPenSubcategorias(this, " + idDestino + ", " + idGrupo + ", " + idCategoria + "," + idSubcategoria + ")");
//                $("#myonoffswitch2").attr("onchange", "verPenSubcategorias(this, " + idDestino + ", " + idGrupo + ", " + idCategoria + "," + idSubcategoria + ")");
//                $("#txtAddActividadPA").attr("onkeypress", "agregarActivdadMCPA(" + idEquipo + ", " + idGrupo + ", " + idDestino + ", " + idSubcategoria + ", " + idCategoria + ")");
//                //$("#txtAddComentariosPAGeneral").attr("onkeypress", "agregarComentariosPAGeneral(0, " + idRelSubcategoria + ")");
//                $("#planAccionPA").html(detalleEquipo.planMC);
//                $("#hddIdEquipo").val(idEquipo);
//                $("#hddIdDestino").val(detalleEquipo.idDestino);
//                $("#hddIdSubseccion").val(detalleEquipo.idSubseccion);
//                $("#hddIdCategoria").val(idCategoria);
//                $("#hddIdSubcategoria").val(detalleEquipo.idSubcategoria);
//                $("#nombreEquipoPA").html(detalleEquipo.nombreEquipo);
//                $("#comentariosSeccionPA").html(detalleEquipo.comentarios);
//                $("#adjuntosPA").html(detalleEquipo.adjuntos);
//                $("#tareaDocPAGeneral").attr("onchange", "upload_filesPAGeneral(0, " + idRelSubcategoria + ");");
//
//                var divComentarios = document.getElementById("divComentariosPA");
//                divComentarios.setAttribute("onmousedown", "obtenerComentariosPAGeneral(0, " + idRelSubcategoria + ");");


            } catch (ex) {
                toastr.error(data, ex, {
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
    });
}

function obtDetalleTarea(idTarea){
    $.ajax({
        type: 'post',
        url: ''
    });
}

function agregarActivdadMCPA(idEquipo, idGrupo, idDestino, idSubcategoria, idCategoria) {
    if (event.keyCode == 13) {
        var actividad = $("#txtAddActividadPA").val();

        if (actividad != "") {
            $.ajax({
                type: 'post',
                url: 'php/plannerPHP.php',
                data: 'action=4&idEquipo=' + idEquipo + '&actividad=' + actividad
                        + '&idGrupo=' + idGrupo + '&idDestino=' + idDestino + '&idCategoria=' + idCategoria + '&idSubcategoria=' + idSubcategoria,
                success: function (data) {
                    if (data == 1) {
                        recargarMCPA(idGrupo, idDestino, idCategoria, idSubcategoria);
                        $("#txtAddActividadPA").val("");
                    } else {
                        alert(data);
                    }
                }
            });
        }
    }
}

function recargarMCPA(idGrupo, idDestino, idCategoria, idSubcategoria) {
    var chkb = document.getElementById("myonoffswitch2");
    if (chkb.checked == true) {
        var status = "N";
    } else {
        var status = "F";
    }
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=29&idDestino=' + idDestino + '&idSubseccion=' + idGrupo + '&idCategoria=' + idCategoria + '&idSubcategoria=' + idSubcategoria + '&status=' + status,
        success: function (data) {
            $("#planAccionPA").html(data);
        }
    });
}

//Ver pendientes y solucionados tareas generales
function verPenSubcategorias(element, idDestino, idSubseccion, idCategoria, idSubcategoria) {
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
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=28&idDestino=' + idDestino + '&idSubseccion=' + idSubseccion + '&idCategoria=' + idCategoria + '&idSubcategoria=' + idSubcategoria + '&status=' + status,
        success: function (data) {

            $("#divListaTareas").html(data);


        }
    });

}

function agregarComentariosPAGeneral(pagina, idEquipo) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    var comentario = document.getElementById("txtAddComentariosPAGeneral").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: url,
                data: 'action=54&idEquipo=' + idEquipo + '&comentario=' + comentario,

                success: function (data) {
                    //$(".loader").fadeOut('slow');
                    document.getElementById("txtAddComentariosPAGeneral").value = "";
                    obtenerComentariosPAGeneral(pagina, idEquipo);
                }
            });
        } else {
            alert("No puede enviar comentarios vacios");
        }
    }

}

function obtenerComentariosPAGeneral(pagina, idEquipo) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=55&pagina=' + pagina + '&idEquipo=' + idEquipo,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaComent = document.getElementById("comentariosSeccionPA");

            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            obtenerArchivosPAGeneral(idEquipo, pagina);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function obtenerArchivosPAGeneral(idEquipo, pagina) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=56&idEquipo=' + idEquipo + '&pagina=' + pagina,

        success: function (data) {
            $(".loader").fadeOut('slow');

            document.getElementById("adjuntosPA").innerHTML = data;


        }
    });
}

function upload_filesPAGeneral(pagina, idEquipo) {
    var idSubcategoria = $("#hddIdSubcategoria").val();
    var inputFileImage = document.getElementById("tareaDocPAGeneral");


    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('idEquipo', idEquipo);
    data.append('general', 'SI');


    if (pagina == 0) {
        var url = "php/planner_uploadfilesmcsubcat.php";
    } else {
        var url = "../php/planner_uploadfilesmcsubcat.php";
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
            obtenerArchivosPAGeneral(idSubcategoria, pagina);
            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

//FIN SECCION PARA REALIZAR FUNCIONES QUE SE REALIZAN POR MEDIO DE UNA SUBCATEGORIA


function buscarUsuario(element, idDestino) {
    var palabra = element.value;
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=6&idDestino=' + idDestino + '&palabra=' + palabra,
        success: function (data) {
            $("#body-usuarios").html(data);
        }
    });
}

function setIdActividad(idActividad) {
    $("#hddIdActividad").val(idActividad);
}

function cerrarModal() {
//    $('#modal-detalle-tarea').modal('hide');
//    $('#modal-detalle-tarea').modal('dispose');
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

//Pendientes de ajustar y reprogramar
function upload_files(pagina, idSubtarea, subcategorias) {
    //var idTarea = document.getElementById("idTareaHidden").value;
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();

    if (idSubtarea == undefined) {
        idSubtarea = 0;
        var inputFileImage = document.getElementById("tareaDoc");
    } else {
        var inputFileImage = document.getElementById("tareaDoc" + idSubtarea + "");
    }

    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('idActividad', idSubtarea);


    if (pagina == 0) {
        var url = "php/planner_uploadfiles.php";
    } else {
        var url = "../php/planner_uploadfiles.php";
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
            recargarMCPA(idSubseccion, idDestino, idCategoria, idSubcategoria);
            obtenerArchivosST(idSubtarea, pagina);
            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

function agregarComentarioActividad(pagina, idSubtarea, idUsuario) {
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    var comentario = document.getElementById("txtComentarioST" + idSubtarea + "").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: url,
                data: 'action=11&idActividad=' + idSubtarea + '&idUsuario=' + idUsuario + '&comentario=' + comentario,

                success: function (data) {
                    //$(".loader").fadeOut('slow');
                    document.getElementById("txtComentarioST" + idSubtarea + "").value = "";
                    obtenerComentariosST(pagina, idSubtarea);
                }
            });
        } else {
            alert("No puede enviar comentarios vacios");
        }
    }

}

function obtenerComentariosST(pagina, idActividad) {
    var idEquipo = $("#hddIdEquipo").val();
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=12&pagina=' + pagina + '&idActividad=' + idActividad,

        success: function (data) {
            $(".loader").fadeOut('slow');
            if (idEquipo != 0) {
                var cajaComent = document.getElementById("comentariosSeccion");
            } else {
                var cajaComent = document.getElementById("comentariosSeccionPA");
            }

            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            obtenerArchivosST(idActividad, pagina);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function obtenerArchivosST(idActividad, pagina) {
    var idEquipo = $("#hddIdEquipo").val();
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=13&idActividad=' + idActividad + '&pagina=' + pagina,

        success: function (data) {
            $(".loader").fadeOut('slow');
            if (idEquipo != 0) {
                document.getElementById("adjuntos").innerHTML = data;
            } else {
                document.getElementById("adjuntosPA").innerHTML = data;
            }

        }
    });
}

//AGREGAR COMENTARIOS GENERALES AL PLAN DE ACCION
function agregarComentariosMC(pagina, idEquipo) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    var comentario = document.getElementById("txtAddComentariosMC").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: url,
                data: 'action=48&idEquipo=' + idEquipo + '&comentario=' + comentario,

                success: function (data) {
                    //$(".loader").fadeOut('slow');
                    document.getElementById("txtAddComentariosMC").value = "";
                    obtenerComentariosMC(pagina, idEquipo);
                }
            });
        } else {
            alert("No puede enviar comentarios vacios");
        }
    }

}

function obtenerComentariosMC(pagina, idEquipo) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=49&pagina=' + pagina + '&idEquipo=' + idEquipo,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaComent = document.getElementById("comentariosSeccion");

            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            obtenerArchivosMC(idEquipo, pagina);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function obtenerArchivosMC(idEquipo, pagina) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=50&idEquipo=' + idEquipo + '&pagina=' + pagina,

        success: function (data) {
            $(".loader").fadeOut('slow');

            document.getElementById("adjuntos").innerHTML = data;


        }
    });
}

function upload_filesMC(pagina) {
    var idEquipo = $("#hddIdEquipo").val();
    var inputFileImage = document.getElementById("tareaDocMC");


    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('idEquipo', idEquipo);
    data.append('general', 'SI');


    if (pagina == 0) {
        var url = "php/planner_uploadfiles.php";
    } else {
        var url = "../php/planner_uploadfiles.php";
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
            obtenerArchivosMC(idEquipo, pagina);
            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

//Fin de pendientes de ajustar y reprogramar

function generarOrdenTrabajo(idPlanMP, idPlaneacionMP, modal) {
    var idEquipo = $("#hddIdEquipo").val();
//    var listaActividades = [];
//    $("input:checkbox:checked").each(function () {
//        try {
//            if ($(this).attr('name')) {
//                var chkb = $(this).attr('name');
//
//                var datos = chkb.split("_");
//
//                var namechkb = datos[0];
//                if (namechkb == "listchkbPM") {
//                    var idPM = datos[1];
//                } else if (namechkb == "listchkb") {
//                    var idPM = datos[1];
//                    var idchkb = $(this).attr('id');
//                    var data = idchkb.split("_");
//                    listaActividades.push(data[1]);
//                }
//            }
//        } catch (ex) {
//            alert(ex);
//        }
//    });
    //window.open('planner/orden-trabajo.php?idEquipo=' + idEquipo + '&listaActividades=' + JSON.stringify(listaActividades));

    window.open('planner/orden-trabajo.php?idEquipo=' + idEquipo + '&idPlanMP=' + idPlanMP + '&idPlaneacion=' + idPlaneacionMP);

    setTimeout(function () {
        $("#inicioMP").hide();
        $("#divDetalleOT").show();
//        obtenerEquiposMP(idEquipo, modal);
//        recargarOT(idEquipo);
    }, 1000);


}

function cerrarOT(idOT, modal) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=71&idOT=' + idOT,
        success: function (data) {
            var datos = JSON.parse(data);
            $("#hddIdOT").val(datos.id);
            $("#folioOT").html(datos.folio);
            $("#nombreEquipoOT").html(datos.equipo);
            $("#listaPlan").html("");
            $("#listaPlan").html(datos.listActividades);
            $("#hddModal").val(modal);
        }
    });
}

function marcarRealizado(idDestino) {
    var idEquipo = $("#hddIdEquipo").val();
    var idOT = $("#hddIdOT").val();
    var modal = $("#hddModal").val();
    var idUsuario = $("#cbUsuarios").val();
    var fechaFin = $("#txtFechaFin").val();
    var comentario = $("#txtComentario").val();
    var inputFileImage = document.getElementById("txtFile");
    var file = inputFileImage.files;

    var listaActividades = [];
    $("input:checkbox:checked").each(function () {
        try {
            if ($(this).attr('name')) {
                var chkb = $(this).attr('name');

                var datos = chkb.split("_");

                var namechkb = datos[0];
                if (namechkb == "listchkbPMOT") {
                    var idPM = datos[1];
                } else {
                    var idPM = datos[1];
                    var idchkb = $(this).attr('id');
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

    if (idUsuario != 0 && fechaFin != "" && listaActividades.length > 0) {
        var datos = new FormData();
        for (i = 0; i < file.length; i++) {
            datos.append('fileToUpload' + i, file[i]);
        }
        datos.append('idEquipo', idEquipo);
        datos.append('idUsuario', idUsuario);
        datos.append('fechaFin', fechaFin);
        datos.append('comentario', comentario);
        datos.append('action', '9');
        datos.append('idOT', idOT);
        datos.append('listaActividades', JSON.stringify(listaActividades));

        $.ajax({
            type: 'post',
            url: 'php/plannerPHP.php',
            data: datos,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (data) {
                if (data == 1) {
                    toastr.success('Se ha cerrado la OT!', 'Finalizado', {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right",
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    });
                    recargarMP(idEquipo);
                    obtenerEquiposMP(idEquipo, modal);
                    $("#modal-cerrar-ot").modal('hide');
                } else {
                    toastr.error(data, 'Error', {
                        "closeButton": true,
                        "newestOnTop": true,
                        "positionClass": "toast-top-right",
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
        });
    } else {
        alert("Complete los datos, debe de marcar al menos una actividad, ingresar una fecha y seleccionar un usuario");
    }
    //window.open('planner/orden-trabajo.php?idEquipo=' + idEquipo + '&listaActividades=' + JSON.stringify(listaActividades));
}

function recargarMP(idEquipo) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=30&idEquipo=' + idEquipo,
        success: function (data) {
            $("#historicoMP").html(data);
            var historicoMP = $("#tablaHistorico").DataTable({
                "order": [[1, "asc"]],
                "select": true,
                "scrollY": "30vh",
                "scrollCollapse": true,
                "paging": false,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Mantenimiento Preventivo',
                        className: 'btn-no btn-sm shadow-sm'
                    },
                    {
                        extend: 'pdf',
                        title: 'Mantenimiento Preventivo',
                        className: 'btn-no btn-sm shadow-sm',
                        orientation: 'landscape',

                    },
                ],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                            );

                                    column
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                });

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }

            });
        }
    });

}

function recargarOT(idEquipo) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=31&idEquipo=' + idEquipo,
        success: function (data) {
            $("#historicoOT").html(data);
            var historicoOT = $("#tablaHistoricoOT").DataTable({
                "order": [[1, "asc"]],
                "select": true,
                "scrollY": "30vh",
                "scrollCollapse": true,
                "paging": false,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Mantenimiento Preventivo',
                        className: 'btn-no btn-sm shadow-sm'
                    },
                    {
                        extend: 'pdf',
                        title: 'Mantenimiento Preventivo',
                        className: 'btn-no btn-sm shadow-sm',
                        orientation: 'landscape',

                    },
                ],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                                .appendTo($(column.footer()).empty())
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex(
                                            $(this).val()
                                            );

                                    column
                                            .search(val ? '^' + val + '$' : '', true, false)
                                            .draw();
                                });

                        column.data().unique().sort().each(function (d, j) {
                            select.append('<option value="' + d + '">' + d + '</option>')
                        });
                    });
                }

            });
            historicoOT
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = historicoOT.rows(indexes).data().toArray();
                        verOT(rowData[0][1], rowData[0][0]);
                    })
        }
    });

}

function obtenerInfoST(idAccion, pagina) {
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=14&idSubtarea=' + idAccion,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var subtarea = JSON.parse(data);
            document.getElementById("txtEditTituloSubtarea").value = subtarea.actividad;
            //document.getElementById("txtFechaFinSubtarea").value = subtarea.fecLimite;
            $("#btnSalvar").attr("onclick", "actualizarST(" + idAccion + ", " + pagina + ")");

        }
    });
}

function actualizarST(idSubtarea, pagina) {
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();
    var titulo = document.getElementById("txtEditTituloSubtarea").value;
//    var fechaLimite = document.getElementById("txtFechaFinSubtarea").value;
    var eliminar = document.getElementById("chkbEliminar");
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }

    if (eliminar.checked) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'action=15&idSubtarea=' + idSubtarea + '&titulo=' + titulo + '&evento=delete',
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    if (idEquipo != 0) {
                        recargarMC(idEquipo);
                    } else {
                        recargarMCPA(idSubseccion, idDestino, idCategoria, idSubcategoria);
                    }

                    $("#modal-editar-subtarea").modal('hide');
                    eliminar.checked = false;
                } else {
                    alert(data);
                }
            }
        });
    } else {
        $.ajax({
            type: 'post',
            url: url,
            data: 'action=15&idSubtarea=' + idSubtarea + '&titulo=' + titulo + '&evento=update',
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    if (idEquipo != 0) {
                        recargarMC(idEquipo);
                    } else {
                        recargarMCPA(idSubseccion, idDestino, idCategoria, idSubcategoria);
                    }
                    $("#modal-editar-subtarea").modal('hide');
                } else {
                    alert(data);
                }
            }
        });
    }
}

function verHistorico(element) {
    if (element.value == "historico") {
        $("#planMP").hide();
        $("#historicoOT").hide();
        $("#historicoMP").show();
        $("#txtActividadExtra").hide();
        $("#graficaGant").hide();

        $("#btnPlanMP").removeClass("active");
        $("#btnHistoricoMP").addClass("active");
        $("#btnHistoricoOT").removeClass("active");
        $("#btnGant").removeClass("active");
//        element.value = "planMP";
//        element.innerHTML = "Plan MP";
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
    } else {
        $("#planMP").show();
        $("#historicoOT").hide();
        $("#historicoMP").hide();
        $("#txtActividadExtra").show();
        $("#graficaGant").hide();

        $("#btnPlanMP").addClass("active");
        $("#btnHistoricoMP").removeClass("active");
        $("#btnHistoricoOT").removeClass("active");
        $("#btnGant").removeClass("active");
//        element.value = "historico";
//        element.innerHTML = "Historico MP";
    }
}

function verHistoricoOT(element) {
    if (element.value == "ot") {
        $("#planMP").hide();
        $("#historicoMP").hide();
        $("#historicoOT").show();
        $("#txtActividadExtra").hide();
        $("#graficaGant").hide();

        $("#btnPlanMP").removeClass("active");
        $("#btnHistoricoMP").removeClass("active");
        $("#btnHistoricoOT").addClass("active");
        $("#btnGant").removeClass("active");

        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
    }
}

function verGant(element) {
    if (element.value == "grafica") {
        $("#graficaGant").show();
        $("#planMP").hide();
        $("#historicoMP").hide();
        $("#historicoOT").hide();
        $("#txtActividadExtra").hide();

        $("#btnPlanMP").removeClass("active");
        $("#btnHistoricoMP").removeClass("active");
        $("#btnHistoricoOT").removeClass("active");
        $("#btnGant").addClass("active");

        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
    }
}

function insertarActividadAdicional(idTipoEquipo) {
    var actividad = $("#txtActividadExtra").val();
    var idEquipo = $("#hddIdEquipo").val();
    if (event.keyCode == 13) {
        if (actividad != "") {
            $.ajax({
                type: 'post',
                url: 'php/plannerPHP.php',
                data: 'action=16&idTipoEquipo=' + idTipoEquipo + '&actividad=' + actividad,
                success: function (data) {
                    if (data == 1) {
                        $("#txtActividadExtra").val("");
                        recargarPMP(idEquipo);
                    } else {
                        alert(data);
                    }
                }
            });
        } else {
            alert("Ingrese el titulo de la actividad");
        }
    }
}

function recargarPMP(idEquipo) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=17&idEquipo=' + idEquipo,
        success: function (data) {
            $("#planMP").html(data);
        }
    });
}

//TEST
function insertarTest() {
    var idEquipo = $("#hddIdEquipo").val();
    var descripcionTest = $("#txtDescripcionTest").val();
    var fechaTest = $("#txtFechaTest").val();
    var realizo = $("#cbUsuariosTest").val();
    var inputFileImage = document.getElementById("txtFileTest");
    var file = inputFileImage.files[0];

    if (descripcionTest != "" && fechaTest != "" && realizo != 0) {
        var datos = new FormData();
        datos.append('fileToUpload', file);
        datos.append('idEquipo', idEquipo);
        datos.append('idUsuario', realizo);
        datos.append('fecha', fechaTest);
        datos.append('test', descripcionTest);
        datos.append('action', '18');
        try {
            $.ajax({
                type: 'post',
                url: 'php/plannerPHP.php',
                data: datos,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function (data) {
                    if (data == 1) {
                        recargarTest(idEquipo);
                    } else {
                        alert(data);
                    }
                }
            });
        } catch (ex) {
            alert(ex);
        }
    }
}

function recargarTest(idEquipo) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=19&idEquipo=' + idEquipo,
        success: function (data) {
            $("#tests").html(data);
        }
    });
}

function upload_files_test(pagina, idSubtarea) {
    //var idTarea = document.getElementById("idTareaHidden").value;
    if (idSubtarea == undefined) {
        idSubtarea = 0;
        var inputFileImage = document.getElementById("tareaDocTest");
    } else {
        var inputFileImage = document.getElementById("tareaDocTest" + idSubtarea + "");
    }

    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('idTest', idSubtarea);


    if (pagina == 0) {
        var url = "php/planner_uploadfilestest.php";
    } else {
        var url = "../php/planner_uploadfilestest.php";
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
            obtenerArchivosTest(idSubtarea, pagina);
            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

function upload_files_test_general(pagina, idSubtarea) {
    var idEquipo = $("#hddIdEquipo").val();
    var inputFileImage = document.getElementById("tareaDocTest");


    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('idEquipo', idEquipo);
    data.append('general', 'SI');


    if (pagina == 0) {
        var url = "php/planner_uploadfilestest.php";
    } else {
        var url = "../php/planner_uploadfilestest.php";
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
            obtenerArchivosTestGeneral(idEquipo, pagina);
            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

function agregarComentarioTest(pagina, idSubtarea, idUsuario) {
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    var comentario = document.getElementById("txtComentarioTest" + idSubtarea + "").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: url,
                data: 'action=21&idActividad=' + idSubtarea + '&idUsuario=' + idUsuario + '&comentario=' + comentario,

                success: function (data) {
                    //$(".loader").fadeOut('slow');
                    document.getElementById("txtComentarioTest" + idSubtarea + "").value = "";
                    obtenerComentariosTest(pagina, idSubtarea);
                }
            });
        } else {
            alert("No puede enviar comentarios vacios");
        }
    }

}

function obtenerComentariosTest(pagina, idActividad) {
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=22&pagina=' + pagina + '&idActividad=' + idActividad,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaComent = document.getElementById("comentariosSeccionTest");
            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            obtenerArchivosTest(idActividad, pagina);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function obtenerArchivosTest(idActividad, pagina) {
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=20&idActividad=' + idActividad + '&pagina=' + pagina,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("adjuntosTest").innerHTML = data;
        }
    });
}

function agregarComentariosTestGeneral(pagina, idEquipo) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    var comentario = document.getElementById("txtAddComentariosTest").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: url,
                data: 'action=52&idEquipo=' + idEquipo + '&comentario=' + comentario,

                success: function (data) {
                    //$(".loader").fadeOut('slow');
                    document.getElementById("txtAddComentariosTest").value = "";
                    obtenerComentariosTestGeneral(pagina, idEquipo);
                }
            });
        } else {
            alert("No puede enviar comentarios vacios");
        }
    }

}

function obtenerComentariosTestGeneral(pagina, idEquipo) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=53&pagina=' + pagina + '&idEquipo=' + idEquipo,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaComent = document.getElementById("comentariosSeccionTest");

            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            obtenerArchivosTestGeneral(idEquipo, pagina);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function obtenerArchivosTestGeneral(idEquipo, pagina) {
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=51&idEquipo=' + idEquipo + '&pagina=' + pagina,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("adjuntosTest").innerHTML = data;
        }
    });
}

//FIN TEST
function obtenerComentariosMP(idMP) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=23&idMP=' + idMP,
        success: function (data) {
            var datos = JSON.parse(data);
            $("#hiddenIdMP").val(idMP);
            $("#divAdjuntosMPR").html(datos.adjuntos);
            $("#divComentariosMPR").html(datos.comentarios);
            $("#divActRealizadas").html(datos.listActividades);
            //obtenerArchivosMP(idMP);
        }
    });
}

function agregarComentarioMP() {
    var idMP = $("#hiddenIdMP").val();
    var comentario = $("#comentarioMP").val();
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: 'php/plannerPHP.php',
                data: 'action=24&idMP=' + idMP + '&comentario=' + comentario,
                success: function (data) {
                    if (data == 1) {
                        $("#comentarioMP").val("");
                        obtenerComentariosMP(idMP);
                    } else {
                        alert(data);
                    }
                }
            });
        }
    }
}

function upload_files_mp() {
    var idMP = document.getElementById("hiddenIdMP").value;
    var inputFileImage = document.getElementById("txtFileMP")

    var file = inputFileImage.files;
    var data = new FormData();
    for (i = 0; i < file.length; i++) {
        data.append('fileToUpload' + i, file[i]);
    }
    data.append('idMP', idMP);

    var url = "php/planner_uploadfilesmp.php";

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
            if (data == 1) {
                toastr.success('Se ha cargado el archivo!', 'Correcto', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                obtenerArchivosMP(idMP);
            } else {
                toastr.error(data, 'Error', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
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

            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

function obtenerArchivosMP(idMP) {

    var url = 'php/plannerPHP.php';

    $.ajax({
        type: 'post',
        url: url,
        data: 'action=25&idMP=' + idMP,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("divAdjuntosMPR").innerHTML = data;
        }
    });
}

function verOT(idEquipo, idOT) {
    window.open("planner/ver-orden-trabajo.php?idEquipo=" + idEquipo + "&idOT=" + idOT);
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
        data: "action=26&idSeccion=" + selected + "&idUsuario=" + idUsuario + '&idPermiso=' + idPermiso + '&tipo=' + tipo,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("dFilas").innerHTML = "";
            document.getElementById("dFilas").innerHTML = data;
//            alturaFilas = screen.height - 425;
//            alturaCols = screen.height - 370;
//            var dFilas = document.getElementById("dFilas");
//            dFilas.setAttribute("style", "max-height: " + alturaFilas + "px;");
//            var divColumnas = document.getElementsByClassName("columnaTarea");
//            for (i = 0; i < divColumnas.length; i++) {
//                divColumnas[i].setAttribute("style", "height: " + alturaCols + "px;");
//            }

//            alturaPA = screen.height - 440;
//            var pAccion = document.getElementById("planAccion");
//            pAccion.setAttribute("style", "height: " + alturaPA + "px; max-height: " + alturaPA + "px; overflow: auto;");
//
//            alturaComentarios = screen.height - 357;
//            alturaAdjuntos = screen.height - 350;
//            var comentarios = document.getElementById("comentariosSeccion");
//            comentarios.setAttribute("style", "height: " + alturaComentarios + "px; max-height: " + alturaComentarios + "px; overflow: auto;");
//            var adjuntos = document.getElementById("adjuntos");
//            adjuntos.setAttribute("style", "height: " + alturaAdjuntos + "px; max-height: " + alturaAdjuntos + "px; overflow: auto;");
//
//            alturaMP = screen.height - 443;
//            alturaHistorico = screen.height - 405;
//            var mp = document.getElementById("graficaGant");
//            var historicoMP = document.getElementById("historicoMP");
//            var historicoOT = document.getElementById("historicoOT");
//            mp.setAttribute("style", "height: " + alturaMP + "px; max-height: " + alturaMP + "px; overflow: auto;");
//            historicoMP.setAttribute("style", "display: none; height: " + alturaHistorico + "px; max-height: " + alturaHistorico + "px; overflow: auto;");
//            historicoOT.setAttribute("style", "display: none; height: " + alturaHistorico + "px; max-height: " + alturaHistorico + "px; overflow: auto;");
//
//            alturaTest = screen.height - 420;
//            var test = document.getElementById("tests");
//            test.setAttribute("style", "height: " + alturaTest + "px; max-height: " + alturaTest + "px; overflow: auto;");
//            alturaComentariosTest = screen.height - 429;
//            alturaAdjuntosTest = screen.height - 429;
//            var comentariosTest = document.getElementById("comentariosSeccionTest");
//            comentariosTest.setAttribute("style", "height: " + alturaComentariosTest + "px; max-height: " + alturaComentariosTest + "px; overflow: auto;");
//            var adjuntosTest = document.getElementById("adjuntosTest");
//            adjuntosTest.setAttribute("style", "height: " + alturaAdjuntosTest + "px; max-height: " + alturaAdjuntosTest + "px; overflow: auto;");
//            $(".columnaTarea").mCustomScrollbar({
//                theme: "minimal-dark"
//            });
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

//***************************************************************************
//PROYECTOS
//***************************************************************************

function proyectos(idSeccion, idSubseccion) {
    $("#idSeccionHdd").val(idSeccion);
    $("#idSubseccionHdd").val(idSubseccion);
    //$("#idCategoriaHdd").val(idCategoria);
}

function agregarProyecto(idDestino) {
    var idSeccion = $("#idSeccionHdd").val();
    var idSubseccion = $("#idSubseccionHdd").val();
    //var idCategoria = $("#idCategoriaHdd").val();
    var tituloProyecto = $("#txtTituloProy").val();
    var justificacion = $("#txtJustificacion").val();
    var tipoProyecto = $("#cbTipoProyecto").val();
    if (tipoProyecto != "PROYECTO") {
        var coste = $("#txtCoste").val();
        var año = $("#txtAño").val();
        var inputFileImage = document.getElementById("txtAdjuntoProyecto");
        var file = inputFileImage.files[0];
    } else {
        var coste = "";
        var año = "";
        var file = "";
    }

    var datos = new FormData();
    datos.append('fileToUpload', file);
    datos.append('idDestino', idDestino);
    datos.append('idSeccion', idSeccion);
    datos.append('idSubseccion', idSubseccion);
    //datos.append('idCategoria', idCategoria);
    datos.append('tituloProyecto', tituloProyecto);
    datos.append('justificacion', justificacion);
    datos.append('tipoProyecto', tipoProyecto);
    datos.append('coste', coste);
    datos.append('año', año);
    datos.append('action', '32');

    if (tituloProyecto != "" && tipoProyecto != "") {
        if (tipoProyecto != "PROYECTO") {
            if (año != "" && coste != "") {
                $.ajax({
                    type: 'post',
                    url: 'php/plannerPHP.php',
                    data: datos,
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file it is set to false
                    success: function (data) {
                        if (data == 1) {
                            alert("Registro correcto");
                            location.reload();
                            //recargarMP(idEquipo);
                            //$("#modal-agregar-proyecto").modal('hide');
                        } else {
                            alert(data);
                        }

                    }
                });
            } else {
                alert("Agregue el año y el coste del proyecto");
            }
        } else {
            $.ajax({
                type: 'post',
                url: 'php/plannerPHP.php',
                data: datos,
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function (data) {
                    if (data == 1) {
                        alert("Registro correcto");
                        location.reload();
                        //recargarMP(idEquipo);
                        //$("#modal-agregar-proyecto").modal('hide');
                    } else {
                        alert(data);
                    }

                }
            });
        }
    } else {
        alert("Indique el nombre y el tipo de proyecto");
    }

}

function obtDetalleProyecto(idProyecto, idDestino, idSeccion, idGrupo) {
    var idEquipo = 0;
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=33&idProyecto=' + idProyecto + '&idDestino=' + idDestino + '&idSeccion=' + idSeccion + '&idSubseccion=' + idGrupo,
        success: function (data) {
            try {
                var detalleProyecto = JSON.parse(data);

                $("#myonoffswitchProy").attr("onchange", "verPenProyecto(this, " + idDestino + ", " + idSeccion + "," + idGrupo + ")");
                $("#txtAddActividadProy").attr("onkeypress", "agregarActividadMCProyecto(" + idProyecto + ")");
                $("#txtAddComentariosProy").attr("onkeypress", "agregarComentariosProy(0, " + idProyecto + ")");

                $("#planAccionProy").html(detalleProyecto.planAccion);
                $("#hddIdProyecto").val(idProyecto);
                $("#hddIdDestinoProy").val(idDestino);
                $("#hddIdSeccionProy").val(idSeccion);
                $("#hddIdSubseccionProy").val(idGrupo);
                $("#destinoProyecto").html(detalleProyecto.destinoProyecto);
                $("#nombreEquipoProy").val(detalleProyecto.titulo);
                $("#justificacionProy").val(detalleProyecto.justificacion);
                $("#cbTipoProy").val(detalleProyecto.tipo);
                if (detalleProyecto.tipo == "PROYECTO") {
                    $("#divAñoProy").hide();
                    $("#divCosteProy").hide();
                } else {
                    $("#divAñoProy").show();
                    $("#divCosteProy").show();
                    $("#añoProy").val(detalleProyecto.año);
                    $("#costeProy").val(detalleProyecto.coste);
                }

                var chkbProyF = document.getElementById("chkbProyF");
                if (detalleProyecto.status == "F") {
                    chkbProyF.checked = true;
                } else {
                    chkbProyF.checked = false;
                }


                $("#comentariosSeccionProy").html(detalleProyecto.comentarios);
                $("#cotProy").html(detalleProyecto.adjuntos);
                $("#justProy").html(detalleProyecto.justificaciones);
                var divComentarios = document.getElementById("divComentariosProy");
                divComentarios.setAttribute("onmousedown", "obtenerComentariosProyecto(0, " + idProyecto + ");");

                var chkFinalizar = document.getElementById("chkbProyF");
                chkFinalizar.setAttribute("onclick", "finalizarProyecto(" + idProyecto + ");");


            } catch (ex) {
                alert(ex + " - " + data);
            }


        }
    });
}

function obtDetalleProyecto2(idProyecto) {
    var idEquipo = 0;
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=33&idProyecto=' + idProyecto + '&idDestino=' + 0 + '&idSeccion=' + 0 + '&idSubseccion=' + 0,
        success: function (data) {
            try {
                var detalleProyecto = JSON.parse(data);

                $("#myonoffswitchProy").attr("onchange", "verPenProyecto(this, " + detalleProyecto.idDestino + ", " + detalleProyecto.idSeccion + "," + detalleProyecto.idSubseccion + ")");
                $("#txtAddActividadProy").attr("onkeypress", "agregarActividadMCProyecto(" + idProyecto + ")");
                $("#txtAddComentariosProy").attr("onkeypress", "agregarComentariosProy(0, " + idProyecto + ")");

                $("#planAccionProy").html(detalleProyecto.planAccion);
                $("#hddIdProyecto").val(idProyecto);
//                $("#hddIdDestinoProy").val(idDestino);
//                $("#hddIdSeccionProy").val(idSeccion);
//                $("#hddIdSubseccionProy").val(idGrupo);
                $("#destinoProyecto").html(detalleProyecto.destinoProyecto);
                $("#nombreEquipoProy").val(detalleProyecto.titulo);
                $("#justificacionProy").val(detalleProyecto.justificacion);
                $("#cbTipoProy").val(detalleProyecto.tipo);
                if (detalleProyecto.tipo == "PROYECTO") {
                    $("#divAñoProy").hide();
                    $("#divCosteProy").hide();
                } else {
                    $("#divAñoProy").show();
                    $("#divCosteProy").show();
                    $("#añoProy").val(detalleProyecto.año);
                    $("#costeProy").val(detalleProyecto.coste);
                }

                var chkbProyF = document.getElementById("chkbProyF");
                if (detalleProyecto.status == "F") {
                    chkbProyF.checked = true;
                } else {
                    chkbProyF.checked = false;
                }

                $("#comentariosSeccionProy").html(detalleProyecto.comentarios);
                $("#cotProy").html(detalleProyecto.adjuntos);
                $("#justProy").html(detalleProyecto.justificaciones);
                var divComentarios = document.getElementById("divComentariosProy");
                divComentarios.setAttribute("onmousedown", "obtenerComentariosProyecto(0, " + idProyecto + ");");

                var chkFinalizar = document.getElementById("chkbProyF");
                chkFinalizar.setAttribute("onclick", "finalizarProyecto(" + idProyecto + ");");


            } catch (ex) {
                alert(ex + " - " + data);
            }


        }
    });
}

function agregarActividadMCProyecto(idProyecto) {
    if (event.keyCode == 13) {
        var actividad = $("#txtAddActividadProy").val();
        if (actividad != "") {
            $.ajax({
                type: 'post',
                url: 'php/plannerPHP.php',
                data: 'action=34&idProyecto=' + idProyecto + '&actividad=' + actividad,
                success: function (data) {
                    if (data == 1) {
                        recargarMCProyecto(idProyecto);
                        $("#txtAddActividadProy").val("");
                    } else {
                        alert(data);
                    }
                }
            });
        }

    }
}

function recargarMCProyecto(idProyecto) {
    var chkb = document.getElementById("myonoffswitchProy");
    if (chkb.checked == true) {
        var status = "N";
    } else {
        var status = "F";
    }
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=35&idProyecto=' + idProyecto + '&status=' + status,
        success: function (data) {
            $("#planAccionProy").html(data);
        }
    });
}

function agregarResponsableProy(idUsuario) {
    var idActividad = $("#hddIdActividad").val();
    var idProyecto = $("#hddIdProyecto").val();
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=36&idUsuario=' + idUsuario + '&idActividad=' + idActividad,
        success: function (data) {
            if (data == 1) {

                recargarMCProyecto(idProyecto);

                $('#modal-agregar-responsable-proy').modal('hide');

            } else {
                alert(data);
            }
        }
    });
}

function completarTareaProy(idActividad, element, idUsuario) {

    var chkb = element.checked;
    var idCheckbox = element.id;
    $("#modal-completar-tarea").modal('show');
    $("#btnFinalizarTarea").attr("onclick", "finalizarTareaProy(" + idActividad + "," + chkb + "," + idUsuario + ")");
    $("#btnCancelarFinalizarTarea").attr("onclick", "cancelarCompletarTareaProy(" + idCheckbox + ")");


}

function cancelarCompletarTareaProy(idCheckbox) {
    var verPenFin = $("#myonoffswitchProy");

    if (verPenFin[0].checked == true) {
        idCheckbox.checked = false;
    } else {
        idCheckbox.checked = true;
    }


}

function finalizarTareaProy(idActividad, chkb, idUsuario) {
    var idProyecto = $("#hddIdProyecto").val();
    //var chkb = element.checked;
    if (chkb == true) {
        var status = "F";
    } else {
        var status = "N";
    }
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=37&idActividad=' + idActividad + '&status=' + status + '&completo=' + idUsuario,
        success: function (data) {
            recargarMCProyecto(idProyecto);
            $("#modal-completar-tarea").modal('hide');
            //$("#modal-completar-tarea").modal('dispose');
        }
    });

}

function finalizarProyecto(idProyecto) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=75&idProyecto=' + idProyecto,
        success: function (data) {
            if (data == 1) {
                toastr.success('', 'Correcto', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
            } else {
                toastr.error(data, 'Error', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
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
    });
}

function eliminarProyecto() {
    var idProyecto = $("#hddIdProyecto").val();
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=76&idProyecto=' + idProyecto,
        success: function (data) {
            if (data == 1) {
                toastr.success('', 'Correcto', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                setTimeout(function () {
                    location.reload();
                }, 2300);
            } else {
                toastr.error(data, 'Error', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
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
    });
}

function verPenProyecto(element, idDestino, idSubseccion, idCategoria, idSubcategoria) {
    var idProyecto = $("#hddIdProyecto").val();
    var chkb = element.checked;

    if (chkb == true) {
        var status = "N";
    } else {
        var status = "F";
    }

    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=38&idProyecto=' + idProyecto + '&status=' + status,
        success: function (data) {

            $("#planAccionProy").html(data);


        }
    });
}

function agregarComentarioProy(pagina, idSubtarea, idUsuario) {
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    var comentario = document.getElementById("txtComentarioProy" + idSubtarea + "").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: url,
                data: 'action=39&idActividad=' + idSubtarea + '&idUsuario=' + idUsuario + '&comentario=' + comentario,

                success: function (data) {
                    //$(".loader").fadeOut('slow');
                    document.getElementById("txtComentarioProy" + idSubtarea + "").value = "";
                    obtenerComentariosProy(pagina, idSubtarea);
                }
            });
        } else {
            alert("No puede enviar comentarios vacios");
        }
    }

}

function obtenerComentariosProy(pagina, idActividad) {
    var idEquipo = $("#hddIdEquipo").val();
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=40&pagina=' + pagina + '&idActividad=' + idActividad,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaComent = document.getElementById("comentariosSeccionProy");

            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            obtenerArchivosProy(idActividad, pagina);
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function obtenerArchivosProy(idActividad, pagina) {
    var idEquipo = $("#hddIdEquipo").val();
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=41&idActividad=' + idActividad + '&pagina=' + pagina,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("justProy").innerHTML = data;


        }
    });
}

function upload_files_proy(pagina, idSubtarea, subcategorias) {
    //var idTarea = document.getElementById("idTareaHidden").value;
    if (idSubtarea == undefined) {
        idSubtarea = 0;
        var inputFileImage = document.getElementById("tareaDoc");
    } else {
        var inputFileImage = document.getElementById("tareaDocProy" + idSubtarea + "");
    }

    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('idActividad', idSubtarea);


    if (pagina == 0) {
        var url = "php/planner_uploadfilesproy.php";
    } else {
        var url = "../php/planner_uploadfilesproy.php";
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
            obtenerArchivosProy(idSubtarea, pagina);
            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

function obtenerInfoProy(idAccion, pagina) {
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=42&idSubtarea=' + idAccion,

        success: function (data) {
            $(".loader").fadeOut('slow');
            try {
                var subtarea = JSON.parse(data);
                document.getElementById("txtEditTituloSubtarea").value = subtarea.actividad;
                //document.getElementById("txtFechaFinSubtarea").value = subtarea.fecLimite;
                $("#btnSalvar").attr("onclick", "actualizarProy(" + idAccion + ", " + pagina + ")");
            } catch (ex) {
                alert(ex + " - " + data);
            }

        }
    });
}

function actualizarProy(idSubtarea, pagina) {
    var idProyecto = $("#hddIdProyecto").val();
    var idEquipo = $("#hddIdEquipo").val();
    var idDestino = $("#hddIdDestino").val();
    var idCategoria = $("#hddIdCategoria").val();
    var idSubseccion = $("#hddIdSubseccion").val();
    var idSubcategoria = $("#hddIdSubcategoria").val();
    var titulo = document.getElementById("txtEditTituloSubtarea").value;
//    var fechaLimite = document.getElementById("txtFechaFinSubtarea").value;
    var eliminar = document.getElementById("chkbEliminar");
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }

    if (eliminar.checked) {
        $.ajax({
            type: 'post',
            url: url,
            data: 'action=43&idSubtarea=' + idSubtarea + '&titulo=' + titulo + '&evento=delete',
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    recargarMCProyecto(idProyecto);

                    $("#modal-editar-subtarea").modal('hide');
                    eliminar.checked = false;
                } else {
                    alert(data);
                }
            }
        });
    } else {
        $.ajax({
            type: 'post',
            url: url,
            data: 'action=43&idSubtarea=' + idSubtarea + '&titulo=' + titulo + '&evento=update',
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    recargarMCProyecto(idProyecto);
                    $("#modal-editar-subtarea").modal('hide');
                } else {
                    alert(data);
                }
            }
        });
    }
}

function buscarUsuarioProy(element, idDestino) {
    var palabra = element.value;
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=44&idDestino=' + idDestino + '&palabra=' + palabra,
        success: function (data) {
            $("#body-usuarios-proy").html(data);
        }
    });
}

function agregarComentariosProy(pagina, idProyecto) {

    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    var comentario = document.getElementById("txtAddComentariosProy").value;
    if (event.keyCode == 13) {
        if (comentario != "") {
            $.ajax({
                type: 'post',
                url: url,
                data: 'action=45&idProyecto=' + idProyecto + '&comentario=' + comentario,

                success: function (data) {
                    //$(".loader").fadeOut('slow');
                    document.getElementById("txtAddComentariosProy").value = "";
                    obtenerComentariosProyecto(pagina, idProyecto);
                }
            });
        } else {
            alert("No puede enviar comentarios vacios");
        }
    }

}

function obtenerComentariosProyecto(pagina, idProyecto) {
    var idEquipo = $("#hddIdEquipo").val();
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=46&pagina=' + pagina + '&idProyecto=' + idProyecto,

        success: function (data) {
            $(".loader").fadeOut('slow');
            var cajaComent = document.getElementById("comentariosSeccionProy");

            cajaComent.innerHTML = "";
            cajaComent.innerHTML = data;
            obtenerArchivosProyecto(idProyecto, pagina, 'NO');
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function obtenerArchivosProyecto(idProyecto, pagina, justificacion) {
    var idEquipo = $("#hddIdEquipo").val();
    if (pagina == 0) {
        var url = 'php/plannerPHP.php';
    } else {
        var url = '../php/plannerPHP.php';
    }
    $.ajax({
        type: 'post',
        url: url,
        data: 'action=47&idProyecto=' + idProyecto + '&pagina=' + pagina + '&justificacion=' + justificacion,

        success: function (data) {
            $(".loader").fadeOut('slow');
            if (justificacion == "SI") {
                document.getElementById("justProy").innerHTML = data;
            } else {
                document.getElementById("cotProy").innerHTML = data;
            }

        }
    });
}

function upload_cots_proyecto(pagina) {
    var idProyecto = document.getElementById("hddIdProyecto").value;

    var inputFileImage = document.getElementById("tareaDocProy");


    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('idProyecto', idProyecto);
    data.append('justificacion', 'NO');


    if (pagina == 0) {
        var url = "php/planner_uploadfilesproyecto.php";
    } else {
        var url = "../php/planner_uploadfilesproyecto.php";
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
            toastr.success('Se ha cargado el archivo!', 'Correcto', {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
            obtenerArchivosProyecto(idProyecto, pagina);
            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

//Carga un archivo de justificacion del proyecto
function upload_just_proyecto(pagina) {
    var idProyecto = document.getElementById("hddIdProyecto").value;

    var inputFileImage = document.getElementById("tareaDocProy2");

    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('fileToUpload', file);
    data.append('idProyecto', idProyecto);
    data.append('justificacion', 'SI');


    if (pagina == 0) {
        var url = "php/planner_uploadfilesproyecto.php";
    } else {
        var url = "../php/planner_uploadfilesproyecto.php";
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
            toastr.success('Se ha cargado el archivo!', 'Correcto', {
                "closeButton": true,
                "newestOnTop": true,
                "positionClass": "toast-top-right",
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            });
            obtenerArchivosProyecto(idProyecto, pagina, 'SI');
            //obtenerAdjuntosTarea(idTarea, idSubtarea, pagina);
        }
    });
}

function eliminarAdjunto(idProyecto, pagina, idAdjunto, justificacion) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=67&idAdjunto=' + idAdjunto + '&justificacion=' + justificacion,
        success: function (data) {
            if (data == 1) {
                toastr.success('Se ha eliminado el archivo!', 'Correcto', {
                    "closeButton": true,
                    "newestOnTop": true,
                    "positionClass": "toast-top-right",
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                });
                obtenerArchivosProyecto(idProyecto, pagina, justificacion);
            }
        }
    });
}

function mostrarMCMP(element) {
    var idBtn = element.id;

    if (idBtn == "btnExportMC") {
        $("#divColUsers").hide();
        $("#divColMC").show();
        $("#divColMP").hide();
        $("#divColStock").hide();
        $("#btnExportUsers").removeClass("active2");
        $("#btnExportMC").addClass("active2");
        $("#btnExportMP").removeClass("active2");
        $("#btnStock").removeClass("active2");
    } else if (idBtn == "btnExportMP") {
        $("#divColUsers").hide();
        $("#divColMC").hide();
        $("#divColMP").show();
        $("#divColStock").hide();
        $("#btnExportUsers").removeClass("active2");
        $("#btnExportMC").removeClass("active2");
        $("#btnExportMP").addClass("active2");
        $("#btnStock").removeClass("active2");
    } else if (idBtn == "btnStock") {
        $("#divColUsers").hide();
        $("#divColMC").hide();
        $("#divColMP").hide();
        $("#divColStock").show();
        $("#btnExportUsers").removeClass("active2");
        $("#btnExportMC").removeClass("active2");
        $("#btnExportMP").removeClass("active2");
        $("#btnStock").addClass("active2");
    } else {
        $("#divColUsers").show();
        $("#divColMC").hide();
        $("#divColMP").hide();
        $("#divColStock").hide();
        $("#btnExportUsers").addClass("active2");
        $("#btnExportMC").removeClass("active2");
        $("#btnExportMP").removeClass("active2");
        $("#btnStock").removeClass("active2");
    }
}

function mostrarMPR(element) {
    var idBtn = element.id;

    if (idBtn == "btnMPRealizado") {
        $("#divActividadesMP").show();
        $("#divOTRealizadas").hide();
        $("#btnMPRealizado").addClass("active2");
        $("#btnOTRealizadas").removeClass("active2");
        $("#btnBuscarMP").attr("onclick", "buscarMP()");
    } else if (idBtn == "btnOTRealizadas") {
        $("#divActividadesMP").hide();
        $("#divOTRealizadas").show();
        $("#btnMPRealizado").removeClass("active2");
        $("#btnOTRealizadas").addClass("active2");
        $("#btnBuscarMP").attr("onclick", "buscarOTS()");
    }
}

function cargarSubseccionModal(idSeccion) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=60&idSeccion=' + idSeccion,
        success: function (data) {
            $("#idSeccionHidden").val(idSeccion);
            $("#cbSubseccion").html(data);
            $("#cbSubseccion").selectpicker('refresh');
            $("#cbSubseccionMP").html(data);
            $("#cbSubseccionMP").selectpicker('refresh');


        }
    });
    $("#divResult").html("");
    $("#divResultMP").html("");

    cargarUsuarios(idSeccion);
    cargarFamilias(idSeccion);
    cargarStock(idSeccion);

}

function cargarEquipoMC(idSubseccion, idDestino) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=63&idSubseccion=' + idSubseccion + '&idDestino=' + idDestino,
        success: function (data) {
            $("#cbEquipoMC").html(data);
            $("#cbEquipoMC").selectpicker('refresh');
        }
    });
}

function buscarMC() {
    var idSeccion = $("#idSeccionHidden").val();
    var fechaI = $("#txtMCFecI").val();
    var fechaF = $("#txtMCFecF").val();
    var idSubseccion = $("#cbSubseccion").val();
    var idEquipo = $("#cbEquipoMC").val();
    var estado = $('input:radio[name=opciones]:checked').val()

    if (fechaI != "" && fechaF != "") {
        $.ajax({
            type: 'post',
            url: 'php/plannerPHP.php',
            data: 'action=61&idSeccion=' + idSeccion + '&idSubseccion=' + idSubseccion + '&idEquipo=' + idEquipo + '&fechaI=' + fechaI + '&fechaF=' + fechaF
                    + '&estado=' + estado,
            success: function (data) {
                $("#bodyTablaMC").html("");
                $("#tablaMC").dataTable().fnDestroy();
                $("#bodyTablaMC").html(data);
                var tablaMC = $("#tablaMC").DataTable({
                    "order": [[1, "asc"]],
                    "select": true,
                    "scrollY": "30vh",
                    "scrollX": true,
                    "scrollCollapse": true,
                    "paging": false,
                    "autoWidth": false,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Plan de accion',
                            className: 'btn-no btn-sm shadow-sm'
                        },
                        {
                            extend: 'pdf',
                            title: 'Plan de accion',
                            className: 'btn-no btn-sm shadow-sm',
                            orientation: 'landscape',

                        },
                    ],
                    initComplete: function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                                );

                                        column
                                                .search(val ? '^' + val + '$' : '', true, false)
                                                .draw();
                                    });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        });
                    }

                });
            }
        });
    } else {
        toastr.warning('Revise los campos!', 'Advertencia', {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right",
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

function exportarMC() {
    var idSeccion = $("#idSeccionHidden").val();
    var fechaI = $("#txtMCFecI").val();
    var fechaF = $("#txtMCFecF").val();
    var idSubseccion = $("#cbSubseccion").val();
    var idEquipo = $("#cbEquipoMC").val();
    var estado = $('input:radio[name=opciones]:checked').val()

    if (fechaI != "" && fechaF != "") {
        window.open("planner/plan-accion.php?idSeccion=" + idSeccion + "&idSubseccion=" + idSubseccion + "&idEquipo=" + idEquipo + "&estado=" + estado + "&fechaI=" + fechaI + "&fechaF=" + fechaF);
    } else {
        toastr.warning('Revise los campos!', 'Advertencia', {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right",
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

function cargarEquipoMP(idSubseccion, idDestino) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=63&&idSubseccion=' + idSubseccion + '&idDestino=' + idDestino,
        success: function (data) {
            $("#cbEquipoMP").html(data);
            $("#cbEquipoMP").selectpicker('refresh');
        }
    });
}

function buscarMP() {
    var idSeccion = $("#idSeccionHidden").val();
    var fechaI = $("#txtMPFecI").val();
    var fechaF = $("#txtMPFecF").val();
    var idSubseccion = $("#cbSubseccionMP").val();
    var idEquipo = $("#cbEquipoMP").val();

    if (fechaI != "" && fechaF != "") {
        $.ajax({
            type: 'post',
            url: 'php/plannerPHP.php',
            data: 'action=62&idSeccion=' + idSeccion + '&idSubseccion=' + idSubseccion + '&idEquipo=' + idEquipo + '&fechaI=' + fechaI + '&fechaF=' + fechaF,
            success: function (data) {
                $("#divResultMP").html(data);
                var tResultadoMP = $("#tablaResultadosMP").DataTable({
                    "order": [[1, "asc"]],
                    "select": true,
                    scrollY: "30vh",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    pageLength: 50,
                    fixedColumns: false,
                    autoWidth: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Mantenimiento Preventivo',
                            className: 'btn-no btn-sm shadow-sm'
                        },
                    ],
                    initComplete: function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                                );

                                        column
                                                .search(val ? '^' + val + '$' : '', true, false)
                                                .draw();
                                    });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        });
                    }
                });

            }
        });
    } else {
        toastr.warning('Revise los campos!', 'Advertencia', {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right",
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

function buscarOTS() {
    var idSeccion = $("#idSeccionHidden").val();
    var fechaI = $("#txtMPFecI").val();
    var fechaF = $("#txtMPFecF").val();
    var idSubseccion = $("#cbSubseccionMP").val();
    var idEquipo = $("#cbEquipoMP").val();

    if (fechaI != "" && fechaF != "") {
        $.ajax({
            type: 'post',
            url: 'php/plannerPHP.php',
            data: 'action=79&idSeccion=' + idSeccion + '&idSubseccion=' + idSubseccion + '&idEquipo=' + idEquipo + '&fechaI=' + fechaI + '&fechaF=' + fechaF,
            success: function (data) {
                $("#divResultOT").html(data);
                var tResultadoOTS = $("#tablaResultadosOTS").DataTable({
                    "order": [[1, "asc"]],
                    "select": true,
                    scrollY: "30vh",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    pageLength: 50,
                    fixedColumns: false,
                    autoWidth: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'Mantenimiento Preventivo',
                            className: 'btn-no btn-sm shadow-sm'
                        },
                    ],
                    initComplete: function () {
                        this.api().columns().every(function () {
                            var column = this;
                            var select = $('<select><option value=""></option></select>')
                                    .appendTo($(column.footer()).empty())
                                    .on('change', function () {
                                        var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                                );

                                        column
                                                .search(val ? '^' + val + '$' : '', true, false)
                                                .draw();
                                    });

                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d + '</option>')
                            });
                        });
                    }
                });

            }
        });
    } else {
        toastr.warning('Revise los campos!', 'Advertencia', {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right",
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

function exportarMP() {
    var idSeccion = $("#idSeccionHidden").val();
    var fechaI = $("#txtMPFecI").val();
    var fechaF = $("#txtMPFecF").val();
    var idSubseccion = $("#cbSubseccionMP").val();
    var idEquipo = $("#cbEquipoMP").val();

    if (fechaI != "" && fechaF != "") {
        window.open("planner/plan-accion-mp.php?idSeccion=" + idSeccion + "&idSubseccion=" + idSubseccion + "&idEquipo=" + idEquipo + "&fechaI=" + fechaI + "&fechaF=" + fechaF);
    } else {
        toastr.warning('Revise los campos!', 'Advertencia', {
            "closeButton": true,
            "newestOnTop": true,
            "positionClass": "toast-top-right",
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

function cargarUsuarios(idSeccion) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=64&idSeccion=' + idSeccion,
        success: function (data) {
            $("#tbodyTabla").html(data);

            if ($.fn.dataTable.isDataTable('#tablaUsuarios')) {
                table = $('#tablaUsuarios').DataTable();
            } else {
                var tablaUsuarios = $("#tablaUsuarios").DataTable({
                    "order": [[1, "desc"]],
                    "select": true,
                    "scrollY": "50vh",
                    "scrollCollapse": true,
                    "paging": false,
                    "autoWidth": false,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: '',
                            className: 'btn-no btn-sm shadow-sm'
                        },
                        {
                            extend: 'pdf',
                            title: '',
                            className: 'btn-no btn-sm shadow-sm',
                            orientation: 'landscape',

                        },
                    ],

                });
            }


        }
    });


}

function cargarStock(idSeccion) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=80&idSeccion=' + idSeccion,
        success: function (data) {
            $("#tablaStock").dataTable().fnDestroy();
            $("#tbodyTablaStock").html(data);
            var tablaStock = $("#tablaStock").DataTable({
                "order": [[1, "desc"]],
                "select": true,
                "scrollY": "50vh",
                "scrollX": true,
                "scrollCollapse": true,
                "paging": false,
                "autoWidth": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: '',
                        className: 'btn-no btn-sm shadow-sm'
                    },
                    {
                        extend: 'pdf',
                        title: '',
                        className: 'btn-no btn-sm shadow-sm',
                        orientation: 'landscape',

                    },
                ],

            });
            tablaStock
                    .on('select', function (e, dt, type, indexes) {
                        var rowData = tablaStock.rows(indexes).data().toArray();
                        $("#hddIdRegistro").val(rowData[0][0]);
                        $("#hddIdSeccionReg").val(idSeccion)
                        $.ajax({
                            type: 'post',
                            url: 'php/stockPHP.php',
                            data: 'action=6&idRegistro=' + rowData[0][0],
                            success: function (data) {
                                var registro = JSON.parse(data);

                                $("#cbDestinoRegEdit").val(registro.idDestino);
                                $("#cbDestinoRegEdit").selectpicker('refresh');
                                $("#cbFaseEdit").val(registro.fase);
                                $("#cbFaseEdit").selectpicker('refresh');
//                                                        $("#txtUbicacionEdit").val(registro.ubicacion);
                                $("#txtCod2bendEdit").val(registro.cod2bend);
                                $("#txtDesc2bendEdit").val(registro.descripcion2bend);
                                $("#cbNaturalezaEdit").val(registro.naturaleza);
                                $("#cbNaturalezaEdit").selectpicker('refresh');
                                $("#cbSeccionEdit").val(registro.seccion);
                                $("#cbSeccionEdit").selectpicker('refresh');
                                $("#cbFamiliaEdit").val(registro.familia);
                                $("#cbFamiliaEdit").selectpicker('refresh');
                                $("#cbSubfamiliaEdit").val(registro.subfamilia);
                                $("#cbSubfamiliaEdit").selectpicker('refresh');
                                $("#txtDescNuevaEdit").val(registro.descripcionNueva);
                                $("#txtMarcaEdit").val(registro.marca);
                                $("#txtModeloEdit").val(registro.modelo);
                                $("#txtCaracteristicasPpalesEdit").val(registro.caracteristicasPpales);
                                $("#txtExistencias2bendEdit").val(registro.existencias2bend);
                                $("#txtExistenciasSubalmacenEdit").val(registro.existenciasSubalmacen);
                                $("#txtPrecioEdit").val(registro.precio)
                                $("#txtConsumoAnualEdit").val(registro.consumoAnual);
                                $("#txtStockNecesarioEdit").val(registro.stockNecesario);
                                $("#txtUnidadesAPedirEdit").val(registro.unidadesPedir);
                                $("#txtFechaPedidoEdit").val(registro.fechaPedido);
                                $("#txtPrioridadEdit").val(registro.prioridad);
                                $("#txtFechaLlegadaEdit").val(registro.fechaLlegada);
                            }
                        });


                    });

        }
    });
}

function cargarFamilias(idSeccion) {
    $.ajax({
        type: 'post',
        url: 'php/stockPHP.php',
        data: 'action=9&idSeccion=' + idSeccion,
        success: function (data) {
            $("#cbFamiliaEdit").html(data);
            $("#cbFamiliaEdit").selectpicker("refresh");
        }
    });
}

function exportarPendienteUsuario(idUsuario, status) {
    window.open("planner/tareas-usuario.php?idUsuario=" + idUsuario + "&status=" + status);
}

function validarSesion() {
    $.ajax({
        type: 'post',
        url: 'php/validarSesionPHP.php',
        data: 'sesion=1',
        success: function (data) {
            if (data != 1) {
                location.href = "login.php";
            }
        }
    });
}

function agregarMP(idEquipo, idPlan, semana, idDestino, idSubseccion, modal) {
    //var idSubseccion = $("#cbSubseccion").val();
    //var idPlan = $("#cbPlanes").val();
//    var semanaInicial = $("#cbSemana").val();

    if (idEquipo != 0 && idPlan != "" && semana != 0) {
        $.ajax({
            type: 'post',
            url: 'php/plannerPHP.php',
            data: 'action=68&idEquipo=' + idEquipo + '&idPlan=' + idPlan + '&semana=' + semana,
            success: function (data) {
                try {
                    if (data == 1) {
                        obtenerEquiposMP(idEquipo, modal);
                    } else {
                        alert(data);
                    }
                } catch (ex) {
                    alert(ex + " - " + data);
                }
            }
        });
    } else {
        alert("Seleccione las opciones");
    }
}

function obtenerEquiposMP(idEquipo, modal) {
    //var idSubseccion = element.value;
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=69&idEquipo=' + idEquipo + '&modal=' + modal,
        success: function (data) {

            if (modal == "acumulado") {
                $("#divGantEquipoAcumulado").html(data);
                $("#tablePlaneacionMP").dataTable().fnDestroy();
                var tPlaneacion = $("#tablePlaneacionMP").DataTable({
                    "order": [[1, "asc"]],
                    "select": false,
                    scrollY: "50vh",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    ordering: false,
                    fixedColumns: true,
                    autoWidth: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    }
                });
            } else {
                $("#graficaGant").html(data);
                $("#tablePlaneacionMP").dataTable().fnDestroy();
                var tablaGant = $("#tablePlaneacionMP").DataTable({
                    "order": [[1, "asc"]],
                    "select": false,
                    scrollY: "50vh",
                    scrollX: true,
                    scrollCollapse: true,
                    paging: false,
                    ordering: false,
                    fixedColumns: true,
                    autoWidth: true,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                    }
                });
            }





        }
    });
}

function openmodaldetalleMP(idPlan) {
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=70&idPlanMP=' + idPlan,
        success: function (data) {
            $('#content-plan').html(data);
            $('#detalle-plan-mp').modal('show');
        }
    });

}

function agregarPlaneacionMC(idAccion, semana, pa, idGrupo, idDestino, idCategoria, idSubcategoria) {
    var idEquipo = $("#hddIdEquipo").val();
    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=78&idAccion=' + idAccion + '&semana=' + semana,
        success: function (data) {
            if (data == 1) {
//                if(pa == 1){
//                    recargarMCPA(idGrupo, idDestino, idCategoria, idSubcategoria);
//                }else{
//                    recargarMC(idEquipo);
//                }

            } else {
                alert(data);
            }
        }
    });
}

function programarPA(idAccion, idGrupo, idDestino, idCategoria, idSubcategoria) {
    $("#hddnIdActividad").val(idAccion);
    $("#btnGuardarProgramacionPA").attr("onclick", "guardarPlaneacionActividad(1, " + idGrupo + ", " + idDestino + ", " + idCategoria + ", " + idSubcategoria + ")");
    ;
}

function guardarPlaneacionActividad(pa, idGrupo, idDestino, idCategoria, idSubcategoria) {
    var idEquipo = $("#hddIdEquipo").val();
    var idActividad = $("#hddnIdActividad").val();
    var semanaI = $("#cbSemanaI").val();
    var semanaF = $("#cbSemanaF").val();

    $.ajax({
        type: 'post',
        url: 'php/plannerPHP.php',
        data: 'action=77&idActividad=' + idActividad + '&semanaI=' + semanaI + '&semanaF=' + semanaF,
        success: function (data) {
            if (data == 1) {
                if (pa == 1) {
                    recargarMCPA(idGrupo, idDestino, idCategoria, idSubcategoria);
                } else {
                    recargarMC(idEquipo);
                }

            } else {
                alert(data);
            }
        }
    });
}
