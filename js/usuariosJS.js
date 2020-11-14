$(document).ready(function () {
    $("#needs-validation").keypress(function (e) {
        if (e.keyCode == 13) {
            $("#btnLogin").click();
        }
    });
});

// function cargarTareasDestinoPlanner(pagina, idDestino) {
//     if (pagina == 1) {
//         var url = "../php/tareasPHP.php";
//     } else {
//         var url = "php/tareasPHP.php";
//     }
//     if (idDestino == undefined) {
//         var destino = document.getElementById("cbDestinos").value;
//     } else {
//         var destino = idDestino;
//     }

//     //    for (i = 0; i <= destino.length; i++) {
//     //        if (destino[i].checked) {
//     //            var idDestino = destino[i].value;
//     //            break;
//     //        }
//     //    }
//     $.ajax({
//         type: 'post',
//         url: url,
//         data: 'action=34&idDestino=' + destino,
//         beforeSend: function () {
//             $(".loader").show();
//         },
//         success: function (data) {
//             $(".loader").fadeOut('slow');
//             location.reload();

//         }
//     });
// }

function validarUsuario() {
    var username = document.getElementById("inputusuario").value;
    var password = document.getElementById("inputcontrasena").value;

    if (username != "" && password != "") {
        try {
            $.ajax({
                type: 'post',
                url: 'php/usuariosPHP.php',
                data: 'action=' + 1 + '&txtUsername=' + username + '&txtPassword=' + password,
                dataType: 'json',
                success: function (data) {
                    if (data.respuesta == 1) {
                        if (data.usuario != "" && data.idDestino != "" && data.superAdmin != "") {
                            localStorage.setItem('usuario', data.usuario);
                            localStorage.setItem('idDestino', data.idDestino);
                            localStorage.setItem('superAdmin', data.superAdmin);
                            localStorage.setItem('idSeccion', 0);
                            localStorage.setItem('idSubseccion', 0);
                            localStorage.setItem('idEquipo', 0);
                            localStorage.setItem('idMC', 0);
                            alertaImg('Bienvenido a MAPHG', '', 'success', 4000);

                            if (data.idDestino == 2 || data.idDestino == 3 || data.idDestino == 11) {
                                location.href = "planner-cols.php";
                            } else {
                                location.href = "index.php";
                            }
                        } else {
                            location.href = "login.php";
                        }
                    } else if (data.respuesta == 2) {
                        alertaImg('Usuario/contraseña incorrecto', 'has-text-info', 'question', 3000);

                    } else if (data.respuesta == 3) {
                        alertaImg('No existe el usuario', 'has-text-danger', 'error', 3000);
                    } else {
                        // toastr.warning(data, 'Advertencia', {
                        alertaImg(data, 'has-text-warning', 'warning', 3000);
                    }
                }
            });
        } catch (ex) {
            toastr.error(ex, 'Error', {
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
        alertaImg('Ingrese usuario y contraseña', 'has-text-info', 'question', 3000);
    }

}

function logout() {
    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=2',
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                location.href = "login.php";
            } else {
                $("#msg").html("");
                $("#msg").html(data);
            }

        }
    });
}

// function logout2() {
//     $.ajax({
//         type: 'post',
//         url: '../php/usuariosPHP.php',
//         data: 'action=2',
//         beforeSend: function () {
//             $(".loader").show();
//         },
//         success: function (data) {
//             $(".loader").fadeOut('slow');
//             if (data == 1) {
//                 location.href = "../login.php";
//             } else {
//                 $("#msg").html("");
//                 $("#msg").html(data);
//             }

//         }
//     });
// }

function obtDatosEmpleado(idEmpleado) {
    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=3&idPersonal=' + idEmpleado,
        success: function (data) {
            try {
                var empleado = JSON.parse(data);
                $("#idEmpleadoHdn").val(empleado.id);
                $("#nombreEmp").val(empleado.nombre);
                $("#apellidoEmp").val(empleado.apellido);
                $("#telefonoEmp").val(empleado.telefono);
                $("#emailEmp").val(empleado.email);
                $("#cbDestEdit").val(empleado.idDestino);
                //$("#cbDeptoEdit").val(empleado.idDestino);
                $("#cbCargoEdit").val(empleado.idPuesto);
                $("#cbNivelEdit").val(empleado.idNivel);
                $("#cbFaseEdit").val(empleado.idFase);
                $("#cbSeccionEdit").val(empleado.idSeccion);
                $("#idUsuarioHdn").val(empleado.idUsuario);
                $("#txtUsernameEdit").val(empleado.username);
                $("#txtPasswordEdit").val(empleado.password);
                $("#cbPermisoEdit").val(empleado.idPermiso);
                $("#txtCodigoSAEdit").val(empleado.codigoSA);
                //            $("#dtFechaPropCol").val(empleado.fechaPropIngreso);
                //            $("#dtFechaRealCol").val(empleado.fechaRealIngreso);
                //            $("#trabajando").val(empleado.trabajando);
                //            $("#txtSD").val(empleado.sueldoDiario);
                $("#acciones").html("");
                $("#acciones").html(empleado.acciones);
                $("#accesoSA").html("");
                $("#accesoSA").html(empleado.accesoSA);

                if (empleado.foto != "") {
                    $("#fotoPerfil").attr("src", "img/users/" + empleado.foto);
                } else {
                    $("#fotoPerfil").attr("src", "https://ui-avatars.com/api/?uppercase=false&name=" + empleado.nombre + "+" + empleado.apellido + "&background=d8e6ff&rounded=true&color=4886ff&size=100%");
                }
            } catch (ex) {
                toastr.error(ex + " - " + data + 'Error', {
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

function editar() {
    document.getElementById("txtEmail").disabled = false;
    document.getElementById("txtTelefono").disabled = false;
    $("#txtEmail").removeClass("border-0");
    $("#txtEmail").removeClass("input-texto");
    $("#txtTelefono").removeClass("border-0");
    $("#txtTelefono").removeClass("input-texto");
    document.getElementById("divBtn").style.display = "block";
}

function actualizar(idUsuario) {
    var email = document.getElementById("txtEmail").value;
    var telefono = document.getElementById("txtTelefono").value;

    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=4&idUsuario=' + idUsuario + '&email=' + email + '&telefono=' + telefono,
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

function actualizarFoto(idUsuario) {
    var inputFileImage = document.getElementById("uploadFile");
    var file = inputFileImage.files[0];
    var data = new FormData();
    data.append('action', 5);
    data.append('fileToUpload', file);
    data.append('id', idUsuario);
    //data.append('id', id_slide);

    url = "php/usuariosPHP.php";

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
            location.reload();
        }
    });
}

//Funcion para llenar el select de puestos por departamento
function cargarPuestos() {
    var depto = document.getElementById("cbDepto").value;
    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=6&idDepto=' + depto,

        success: function (data) {
            $(".loader").fadeOut('slow');
            document.getElementById("cbCargo").innerHTML = data;
        }
    });

    return false;
}

function crearUsuario() {
    try {
        var nombre = document.getElementById("txtNombre").value;
        var apellido = document.getElementById("txtApellido").value;
        var telefono = document.getElementById("txtTel").value;
        var email = document.getElementById("txtEmail").value;
        var depto = document.getElementById("cbDepto").value;
        var cargo = document.getElementById("cbCargo").value;
        var nivel = document.getElementById("cbNivel").value;
        var destino = document.getElementById("cbDest").value;
        var fase = document.getElementById("cbFase").value;
        var seccion = document.getElementById("cbSeccion").value;
        //        var chkbPropInt = document.getElementById("chkbPropInt");
        //        var dtFechaProp = document.getElementById("dtFechaProp").value;
        //        var dtFechaReal = document.getElementById("dtFechaReal").value;
        //        var chkbContratado = document.getElementById("chkbContratado");
        //        var chkbTrabajando = document.getElementById("chkbTrabajando");

        var chkbUsuario = $("#chkbUsuario");
        if (chkbUsuario[0].checked) {
            chkbUsuario = "SI";
            var username = document.getElementById("txtUsername").value;
            var password = document.getElementById("txtPassword").value;
            var permiso = document.getElementById("cbPermiso").value;
        } else {
            chkbUsuario = "NO";
            var username = "";
            var password = "";
            var permiso = "";
        }

        //        if (chkbPropInt.checked) {
        //            var propInt = "SI";
        //        } else {
        //            var propInt = "NO";
        //        }
        //
        //        if (chkbContratado.checked) {
        var contratado = "SI";
        //        } else {
        //            var contratado = "NO";
        //        }
        //
        //        if (chkbTrabajando.checked) {
        var trabajando = "SI";
        //        } else {
        //            var trabajando = "NO";
        //        }

        if (nombre != "" && apellido != "" && depto != "" && cargo != "" && destino != 0 && fase != "" && seccion != "") {

            $.ajax({
                type: 'post',
                url: 'php/usuariosPHP.php',
                data: 'action=7&nombre=' + nombre + '&apellido=' + apellido +
                    '&telefono=' + telefono + '&email=' + email + '&depto=' + depto +
                    '&cargo=' + cargo + '&nivel=' + nivel + '&username=' + username + '&password=' + password +
                    '&permiso=' + permiso + '&destino=' + destino + '&fase=' + fase + '&seccion=' + seccion + '&contratado=' + contratado +
                    '&trabajando=' + trabajando + '&usuario=' + chkbUsuario,
                success: function (data) {
                    if (data == 1) {
                        obtListaTrabajadores();
                        closeModal('modal-agregar-trabajador');
                        toastr.success("Trabajador registrado", "Correcto!", {
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
                    } else {
                        toastr.error(data, "Error!", {
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

            return false;

        } else {
            //            $("#cbDest").removeClass("border-0");
            //            $("#txtNombre").removeClass("border-0");
            //            $("#txtApellido").removeClass("border-0");
            //            $("#cbDepto").removeClass("border-0");
            //            $("#cbCargo").removeClass("border-0");
            //            $("#cbNivel").removeClass("border-0");
            //            $("#cbFase").removeClass("border-0");
            //            $("#cbSeccion").removeClass("border-0");

            $("#cbDest").addClass("is-danger");
            $("#txtNombre").addClass("is-danger");
            $("#txtApellido").addClass("is-danger");
            //$("form .select").addClass("is-danger");
            //            $("#cbDepto").addClass("is-danger");
            //            $("#cbCargo").addClass("is-danger");
            //            $("#cbNivel").addClass("is-danger");
            //            $("#cbFase").addClass("is-danger");
            //            $("#cbSeccion").addClass("is-danger");
        }
    } catch (ex) {
        toastr.error(ex, "Error!", {
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

function actualizarEmpleado() {
    try {
        var idEmpleado = document.getElementById("idEmpleadoHdn").value;
        var nombre = document.getElementById("nombreEmp").value;
        var apellido = document.getElementById("apellidoEmp").value;
        var telefono = document.getElementById("telefonoEmp").value;
        var email = document.getElementById("emailEmp").value;
        var destino = document.getElementById("cbDestEdit").value;
        var cargo = document.getElementById("cbCargoEdit").value;
        var nivel = document.getElementById("cbNivelEdit").value;
        var fase = document.getElementById("cbFaseEdit").value;
        var seccion = document.getElementById("cbSeccionEdit").value;
        //        var fechaPropIngreso = document.getElementById("dtFechaPropCol").value;
        //        var fechaRealIngreso = document.getElementById("dtFechaRealCol").value;
        //        var trabajando = document.getElementById("trabajando").value;


        $.ajax({
            type: 'post',
            url: 'php/usuariosPHP.php',
            data: 'action=8&idEmpleado=' + idEmpleado + '&nombre=' + nombre + '&apellido=' + apellido +
                '&telefono=' + telefono + '&email=' + email + '&destino=' + destino + '&cargo=' + cargo +
                '&nivel=' + nivel + '&fase=' + fase + '&seccion=' + seccion,
            success: function (data) {
                $(".loader").fadeOut('slow');
                if (data == 1) {
                    obtListaTrabajadores();
                    toastr.success("Se han guardado los cambios", "Correcto!", {
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
                } else {
                    toastr.error(data, "Error!", {
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
    } catch (ex) {
        toastr.error(ex, "Error!", {
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

function actualizarUsuario() {
    try {
        var idEmpleado = document.getElementById("idEmpleadoHdn").value;
        var idUsuario = document.getElementById("idUsuarioHdn").value;
        var username = document.getElementById("txtUsernameEdit").value;
        var password = document.getElementById("txtPasswordEdit").value;
        var permiso = document.getElementById("cbPermisoEdit").value;
        var codigoSA = document.getElementById("txtCodigoSAEdit").value;

        var chkbAcciones = document.getElementsByName("acciones");
        var acciones = [];
        for (i = 0; i < chkbAcciones.length; i++) {
            if (chkbAcciones[i].checked) {
                acciones[i] = chkbAcciones[i].id + " = 1";
            } else {
                acciones[i] = chkbAcciones[i].id + " = 0";
            }
        }

        var chkbSA = document.getElementsByName("subalmacenes");
        var subalmacenes = [];
        for (i = 0; i < chkbSA.length; i++) {
            if (chkbSA[i].checked) {
                var idSA = chkbSA[i].id;
                var sa = idSA.split("_");
                subalmacenes.push(sa[1]);
            }
        }

        $.ajax({
            type: 'post',
            url: 'php/usuariosPHP.php',
            data: 'action=9&idEmpleado=' + idEmpleado + '&idUsuario=' + idUsuario + '&username=' + username + '&password=' + password +
                '&permiso=' + permiso + '&codigoSA=' + codigoSA + '&acciones=' + acciones + '&subalmacenes=' + subalmacenes,
            success: function (data) {
                if (data == 1) {
                    toastr.success("Se han guardado los cambios", "Correcto!", {
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
                } else {
                    toastr.error(data, "Error!", {
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
    } catch (ex) {
        toastr.error(ex, "Error!", {
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

function actualizarSueldo() {
    var idEmpleado = document.getElementById("idEmpleadoHdn").value;
    var sueldoD = $("#txtSD").val();

    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=12&idEmpleado=' + idEmpleado + '&sueldoD=' + sueldoD,
        beforeSend: function () {
            $(".loader").show();
        },
        success: function (data) {
            $(".loader").fadeOut('slow');
            if (data == 1) {
                alert("Datos actualizados");
            } else {
                alert(data);
            }
        }
    });
}

function activarDatosUsuario() {
    var chkbUsuario = document.getElementById("chkbUsuario");

    if (chkbUsuario.checked) {
        $("#divDatosUser").show();
    } else {
        $("#divDatosUser").hide();
    }
}

function eliminarCol() {
    var idColaborador = document.getElementById("idEmpleadoHdn").value;

    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=10&idEmpleado=' + idColaborador,
        success: function (data) {
            if (data == 1) {
                closeModal('modal-eliminar-trabajador');
                obtListaTrabajadores();
                //                $("#cbDest").removeClass("border-0");
                $("#idEmpleadoHdn").val("");
                $("#nombreEmp").val("");
                $("#apellidoEmp").val("");
                $("#telefonoEmp").val("");
                $("#emailEmp").val("");
                //                $("#cbDepto").removeClass("border-0");
                //                $("#cbCargo").removeClass("border-0");
                //                $("#cbNivel").removeClass("border-0");
                //                $("#cbFase").removeClass("border-0");
                //                $("#cbSeccion").removeClass("border-0");
                toastr.success("Registro eliminado!", "Correcto!", {
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
            } else {
                toastr.error(data, "Error!", {
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

function eliminarUser() {
    var idUser = document.getElementById("idUsuarioHdn").value;

    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=11&idUser=' + idUser,
        success: function (data) {
            if (data == 1) {
                closeModal('modal-eliminar-usuario');
                toastr.success("Usuario eliminado!", "Correcto!", {
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
            } else {
                toastr.error(data, "Error!", {
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

function obtListaTrabajadores() {
    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=13',
        success: function (data) {
            try {
                $("#divListaUsuarios .mCSB_container").html(data);
            } catch (ex) {
                toastr.error(ex, "Error!", {
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

function buscarTrabajador() {
    var trabajador = $("#txtBuscar").val();
    $.ajax({
        type: 'post',
        url: 'php/usuariosPHP.php',
        data: 'action=14&word=' + trabajador,
        success: function (data) {
            try {
                $("#divListaUsuarios .mCSB_container").html(data);
            } catch (ex) {
                toastr.error(ex, "Error!", {
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