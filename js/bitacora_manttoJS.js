// Function para mostrar el formulario de Personal.
document.addEventListener('click', function(e) {
    e = e || window.event;
    var target = e.target || e.srcElement;

    if (target.hasAttribute('data-toggle') && target.getAttribute('data-toggle') == 'modal') {
        if (target.hasAttribute('data-target')) {
            var m_ID = target.getAttribute('data-target');
            document.getElementById(m_ID).classList.add('open');
            e.preventDefault();
        }
    }

    // Close modal window with 'data-dismiss' attribute or when the backdrop is clicked
    if ((target.hasAttribute('data-dismiss') && target.getAttribute('data-dismiss') == 'modal') || target.classList.contains('modal')) {
        var modal = document.querySelector('[class="modal open"]');
        modal.classList.remove('open');
        e.preventDefault();
    }
}, false);

// ************* Aréa de Graficas ********************************************************************
// Funcion para Date.
const MONTH_NAMES = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
const DAYS = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];

function app() {
    return {
        showDatepicker: false,
        datepickerValue: '',

        month: '',
        year: '',
        no_of_days: [],
        blankdays: [],
        days: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],

        initDate() {
            let today = new Date();
            this.month = today.getMonth();
            this.year = today.getFullYear();
            this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
        },

        isToday(date) {
            const today = new Date();
            const d = new Date(this.year, this.month, date);

            return today.toDateString() === d.toDateString() ? true : false;
        },

        getDateValue(date) {
            let selectedDate = new Date(this.year, this.month, date);
            this.datepickerValue = selectedDate.toDateString();

            this.$refs.date.value = selectedDate.getFullYear() + "-" + ('0' + selectedDate.getMonth()).slice(-2) + "-" + ('0' + selectedDate.getDate()).slice(-2);

            // console.log(this.$refs.date.value);

            this.showDatepicker = false;
        },

        getNoOfDays() {
            let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

            // find where to start calendar day of week
            let dayOfWeek = new Date(this.year, this.month).getDay();
            let blankdaysArray = [];
            for (var i = 1; i <= dayOfWeek; i++) {
                blankdaysArray.push(i);
            }

            let daysArray = [];
            for (var i = 1; i <= daysInMonth; i++) {
                daysArray.push(i);
            }

            this.blankdays = blankdaysArray;
            this.no_of_days = daysArray;
        }
    }
}


/* PERSONAL DONA */
var ctx = document.getElementById("tmat").getContext("2d");

function graficaPlantilla(totalGlobal, totalGremio) {
    if (totalGlobal <= 0) {
        totalGlobal = 1;
    }

    if (totalGremio <= 0) {
        totalGlobal = 1;
    }
    var tmat = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ['Plantilla total', 'Plantilla Hoy'],
            datasets: [{
                label: 'Num datos',
                data: [totalGlobal, totalGremio],
                borderWidth: 1,

                borderColor: ['#edf2f7', '#63b3ed'],
                backgroundColor: [
                    '#edf2f7',
                    'rgba(54, 162, 235, 0.2)'
                ]
            }]
        },
        options: {
            aspectRatio: 1,
            legend: {
                display: true,
                position: 'bottom',
                align: 'center',
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            tooltips: {
                enabled: true,
            }

        }
    });
}


/* PERSONAL BARRAS */
function graficaGremio(nombre, cantidad) {

    var ctx = document.getElementById('personalbarras');
    var personalbarras = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: nombre,
            datasets: [{
                label: 'Colaboradores',
                data: cantidad,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 56, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 08, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 56, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            aspectRatio: 2,
            legend: {
                display: false,
                position: 'bottom',
                align: 'center',
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            tooltips: {
                enabled: true,
            }
        }

    });
}


/* HMC*/
function graficaMC(diaSemana, MC) {

    var ctx = document.getElementById('hmc');

    var hmc = new Chart(ctx, {
        type: 'line',
        data: {
            labels: diaSemana,
            datasets: [{
                label: 'Historico',
                data: MC,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {

            legend: {
                display: false,
                position: 'bottom',
                align: 'center',
            },

            tooltips: {
                enabled: true,
            }
        }

    });
}


/* HMP*/
function graficaMP(diaSemana, MP) {
    var ctx = document.getElementById('hmp');
    var hmp = new Chart(ctx, {
        type: 'line',
        data: {
            labels: diaSemana,
            datasets: [{
                label: 'Historico',
                data: MP,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {

            legend: {
                display: false,
                position: 'bottom',
                align: 'center',
            },

            tooltips: {
                enabled: true,
            }
        }

    });
}

/* PY*/
function graficaProyectos(dia, graficaP) {
    // console.log(graficaData);
    var ctx = document.getElementById('py');
    var py = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dia,
            datasets: [{
                label: 'Historico',
                data: graficaP,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {

            legend: {
                display: false,
                position: 'bottom',
                align: 'center',
            },

            tooltips: {
                enabled: true,
            }
        }

    });
}


/* empresas*/
function graficaEmpresas(dia, graficaEmpresas) {
    var ctx = document.getElementById('empresas');
    var empresas = new Chart(ctx, {
        type: 'line',
        data: {
            labels: dia,
            datasets: [{
                label: 'Historico',
                data: graficaEmpresas,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {

            legend: {
                display: false,
                position: 'bottom',
                align: 'center',
            },

            tooltips: {
                enabled: true,
            }
        }

    });
}


/* acontecimiento */
function graficaAcontecimiento(diaSemana, graficaAcontecimiento) {
    var ctx = document.getElementById('acontecimiento');
    var acontecimiento = new Chart(ctx, {
        type: 'line',
        data: {
            labels: diaSemana,
            datasets: [{
                label: 'Historico',
                data: graficaAcontecimiento,
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        },
        options: {

            legend: {
                display: false,
                position: 'bottom',
                align: 'center',
            },

            tooltips: {
                enabled: true,
            }
        }

    });
}


function graficaOrigenGH(no_alojado_origen, trabajador_origen, husped_origen) {
    var ctx = document.getElementById("origen").getContext("2d");
    var origen = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: ['No alojado', 'Habitacion', 'Trabajador'],
            datasets: [{
                label: 'Origen',
                data: [no_alojado_origen, trabajador_origen, husped_origen],
                borderWidth: 1,

                borderColor: ['rgba(255, 99, 132, 1)', '#68d391', 'rgba(246, 224, 94)'],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(104, 211, 145, 0.2)',
                    'rgba(246, 224, 94, 0.2)'
                ]
            }]
        },
        options: {
            aspectRatio: 1,
            legend: {
                display: true,
                position: 'bottom',
                align: 'center',
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            tooltips: {
                enabled: true,
            }

        }
    });
}



/* TOP 5 HABITACIONES */
function graficaTop5Habitaciones(total_top1, total_top2, total_top3, total_top4, total_top5, tipificacion_top1, tipificacion_top2, tipificacion_top3, tipificacion_top4, tipificacion_top5) {
    var ctx = document.getElementById('top5');
    var top5 = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [tipificacion_top1, tipificacion_top2, tipificacion_top3, tipificacion_top4, tipificacion_top5],
            datasets: [{
                label: 'Colaboradores',
                data: [total_top1, total_top2, total_top3, total_top4, total_top5],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            aspectRatio: 2,
            legend: {
                display: false,
                position: 'bottom',
                align: 'center',
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            tooltips: {
                enabled: true,
            }
        }
    });
}


/* TOP 5 COCINAS */
function graficaTop5Cocinas(tipificacion_top1, tipificacion_top2, tipificacion_top3, tipificacion_top4, tipificacion_top5, total_top1, total_top2, total_top3, total_top4, total_top5) {


    var ctx = document.getElementById('top5c');
    var top5c = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: [tipificacion_top1, tipificacion_top2, tipificacion_top3, tipificacion_top4, tipificacion_top5],
            datasets: [{
                label: 'Colaboradores',
                data: [total_top1, total_top2, total_top3, total_top4, total_top5],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
            aspectRatio: 2,
            legend: {
                display: false,
                position: 'bottom',
                align: 'center',
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            tooltips: {
                enabled: true,
            }
        }
    });
}

// Fin Aréa Graficas ************************************************+


//Función para Mostrar el Turno Seleccionado en el modal Formulario de Personal por Turno 
function turnoSeleccionado() {
    var turno = { 1: "Primer Turno", 2: "Segundo Turno", 3: "Tercer Turno" };
    var txtTurno = $("#turnoSeleccionado").val();
    $("#tituloTurno").html(turno[txtTurno]);
}


// Seccion de JS para ALertas:
// Alertas Generales programadas con Funciones.

function alertInformacionVacia() {
    Swal.fire({
        title: '',
        text: 'Ingrese información valida!',
        icon: 'error',
        showClass: {
            popup: 'sweetZIndex',
            contianer: 'sweetZIndex'
        },
        customClass: {
            popup: 'sweetZIndex',
            contianer: 'sweetZIndex'
        }
    });
}

function alertSuccess(mensajeSuccess) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: mensajeSuccess
    })
}



function alertError(mensajeError) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        showClass: { popup: 'sweetZIndex', contianer: 'sweetZIndex' },
        customClass: { popup: 'sweetZIndex', contianer: 'sweetZIndex' },
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'error',
        title: mensajeError
    })
}
// Fin de Seccion de Alertas.



// Funcion para registrar gremio por turno
function bitacoraPersonal() {
    var action = "bitacoraPersonal";
    var dateGeneral = $("#dateGeneral").val();
    var idDestino = $("#idDestino").val();
    var zona = $("#zona").val();
    var turnoSeleccionado = $("#turnoSeleccionado").val();
    var totalPlantillaPorTurno = $("#totalPlantillaPorTurno").val();
    var gremio = $("#gremio").val();
    var cantidadPorGremio = $("#cantidadPorGremio").val();

    if (dateGeneral != "" && idDestino != 0 && zona != "" && turnoSeleccionado != 0 && totalPlantillaPorTurno >= 0 && gremio != "" && cantidadPorGremio != 0) {
        $.ajax({
            type: "post",
            url: "php/crud_bitacora_mantto.php",
            data: {
                action: action,
                dateGeneral: dateGeneral,
                idDestino: idDestino,
                zona: zona,
                turnoSeleccionado: turnoSeleccionado,
                totalPlantillaPorTurno: totalPlantillaPorTurno,
                gremio: gremio,
                cantidadPorGremio: cantidadPorGremio
            },
            success: function(datos) {
                alertSuccess('Captura Agregada!');
                funcionNombre('gremioCantidad');
                $("#gremio").val(1);
                $("#cantidadPorGremio").val('');
                modalStatus('modal-personal', 'close');
                setTimeout(function() { modalStatus('modal-personal', 'open');; }, 1000);
                // console.log(datos);

            }
        });

    } else {
        alertInformacionVacia();
        modalStatus('modal-personal', 'close');
    }
}


// Función para eliminar Gremio por Turno donde activo=1 | activo=0 en la DB, esta función puele eliminar cualquier registro con dos parametros.
//  1.- El nombre de la Tabla.
// 2.- El id a eliminar donde activo=0. (solo se cambia el activo para ocultar el registro).
// QUERY: UPDATE TABLA SET ACTIVO=0 WHERE ID=ID.
function eliminarItemPersonal(tabla, id, modal) {
    modalStatus(modal, 'close');
    Swal.fire({
        title: 'Eliminar Registro?',
        text: "",
        icon: 'warning',
        toast: 'true',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Deleted!',
                '',
                'success',
                eliminarItemPersonalConfirmado(),
                modalStatus(modal, 'open')
            )
        }
        modalStatus(modal, 'open');
    })

    function eliminarItemPersonalConfirmado() {
        var action = "eliminarItemPersonal";
        $.ajax({
            type: "post",
            url: "php/crud_bitacora_mantto.php",
            data: {
                action: action,
                tabla: tabla,
                id: id

            },
            success: function(datos) {
                // console.log(datos);
                // alertSuccess('Datos Obtenidos!');
                alertSuccess("Registro Eliminado!");
                funcionNombre('gremioCantidad');
                funcionNombre('acontecimientoConsulta');
            }
        });
    }
}


// Obtine la cantidad de personal por Gremio y se muestra en el DIV #gremioCantidad.
function gremioCantidad(idDestino, zona, dateGeneral, turnoSeleccionado) {
    var action = "consultaGremiocantidad";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_mantto.php",
        data: {
            action: action,
            idDestino: idDestino,
            zona: zona,
            dateGeneral: dateGeneral,
            turnoSeleccionado: turnoSeleccionado
        },
        success: function(datos) {
            // console.log(datos);
            // alertSuccess('Datos Obtenidos!');
            $("#gremioCantidad").html(datos);
        }
    });
}




// Funcion para mostrar total de Colaboradores por turno en General.
function cantidadTurno(idDestino, zona, dateGeneral) {
    var action = "cantidadTurno";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_mantto.php",
        data: {
            action: action,
            idDestino: idDestino,
            zona: zona,
            dateGeneral: dateGeneral
        },
        dataType: 'json',
        success: function(data) {
            $("#totalgremio1").html(data.total_turno_1_1);
            $("#totalColaboradores1").html(data.total_turno_1_2);
            $("#totalgremio2").html(data.total_turno_2_1);
            $("#totalColaboradores2").html(data.total_turno_2_2);
            $("#totalgremio3").html(data.total_turno_3_1);
            $("#totalColaboradores3").html(data.total_turno_3_2);

            var canvas = document.getElementById("personalbarras");
            var contexto = canvas.getContext("2d");
            contexto.clearRect(0, 0, canvas.width, canvas.height);


            graficaPlantilla(data.totalPlantillaGlobal, data.totalPlantilla)
                // console.log(data);
        }
    });
}



function consultaGraficaGremio(idDestino, zona, dateGeneral) {
    var action = "graficaGremio";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_mantto.php",
        data: {
            action: action,
            idDestino: idDestino,
            zona: zona,
            dateGeneral: dateGeneral
        },
        dataType: 'json',
        success: function(data) {
            var arrayGremio = data.labelNombre.split(',');
            var arrayData = data.labelData.split(',');
            // console.log(arrayGremio);
            $("#personalbarras").html();
            graficaGremio(arrayGremio, arrayData);

            // console.log(data);
            // console.log(data.labelNombre);
        }
    });
}



function MPMCPROYECTOS(idDestino, zona, dateGeneral) {
    var action = "MPMCPROYECTOS";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_mantto.php",
        data: {
            action: action,
            idDestino: idDestino,
            zona: zona,
            dateGeneral: dateGeneral
        },
        dataType: 'json',
        success: function(data) {
            // console.log(data.fecha);
            // console.log(data.dia);
            // console.log(data.diaSemana);
            // console.log(data.graficaMC);
            // console.log(data.graficaMP);
            // console.log(data.graficaP);
            // console.log(data.fecha);
            // console.log(data.bitacoraMC);
            console.log('Here', data);

            $("#bitacoraMP").html(data.bitacoraMP);
            $("#totalMP").html(data.totalMP);

            $("#bitacoraMC").html(data.bitacoraMC);
            $("#totalmc").html(data.totalmc);

            if (data.bitacoraProyecto != "") {
                $("#bitacoraProyecto").html(data.bitacoraProyecto);
                $("#bitacoraProyectoTotal").html(data.totalProyecto);
            } else {
                $("#bitacoraProyecto").html("");
                $("#bitacoraProyectoTotal").html("0");
            }
            graficaMC(data.diaSemana, data.graficaMC);
            graficaMP(data.diaSemana, data.graficaMP);
            graficaProyectos(data.diaSemana, data.graficaP);
        }
    });
}


// Funciones para Bitacora empresas Externas
function empresasExternasCaptura(idDestino, zona, dateGeneral) {
    var empresa = $("#bitacoraNombreEmpresaExterna").val();
    var motivo = $("#bitacoraMotivoEmpresaExterna").val();
    var action = "empresasExternasCaptura";

    if (empresa != "" && motivo != "" && idDestino != "" && zona != "" && dateGeneral != "") {
        $.ajax({

            type: "post",
            url: "php/crud_bitacora_mantto.php",
            data: {
                action: action,
                idDestino: idDestino,
                zona: zona,
                dateGeneral: dateGeneral,
                empresa: empresa,
                motivo: motivo
            },
            // dataType: 'json',
            success: function(data) {
                alertSuccess('Empresa y Motivo Capturado!');
                $("#bitacoraNombreEmpresaExterna").val('');
                $("#bitacoraMotivoEmpresaExterna").val('');
                // graficaEmpresas(arrayGremio, arrayData);
                modalStatus('modal-empresas', 'close');

            }
        });
    } else {
        alertInformacionVacia();
        modalStatus('modal-empresas', 'close');
    }
}


function empresasExternasConsulta(idDestino, zona, dateGeneral) {
    // console.log("empresasExternasConsulta");
    var action = "consultaEmpresas";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_mantto.php",
        data: {
            action: action,
            idDestino: idDestino,
            zona: zona,
            dateGeneral: dateGeneral
        },
        dataType: 'json',
        success: function(data) {
            $("#registrosBitacoraEmpresa").html(data.consultaEmpresasModal); //Modal
            $("#registroEmpresas").html(data.consultaEmpresas);
            $("#totalEmpresas").html(data.totalEmpresas);
            graficaEmpresas(data.diaSemana, data.graficaEmpresas);

        }
    });
}



// Funciones para Bitacora Acontecimientos.
function acontecimientoCaptura(idDestino, zona, dateGeneral) {
    var acontecimiento = $("#bitacoraAcontecimiento").val();
    var descripcion = $("#bitacoraAcontecimientoDescripcion").val();
    var action = "acontecimientoCaptura";

    if (acontecimiento != "" && descripcion != "" && idDestino != "" && zona != "" && dateGeneral != "") {
        $.ajax({

            type: "post",
            url: "php/crud_bitacora_mantto.php",
            data: {
                action: action,
                idDestino: idDestino,
                zona: zona,
                dateGeneral: dateGeneral,
                acontecimiento: acontecimiento,
                descripcion: descripcion
            },
            // dataType: 'json',
            success: function(data) {
                // console.log(data);
                alertSuccess('Acontecimiento Y Descripción Capturado!');
                $("#bitacoraAcontecimiento").val('');
                $("#bitacoraAcontecimientoDescripcion").val('');
                modalStatus('modal-acontecimientos', 'close');

                // graficaEmpresas(arrayGremio, arrayData);

            }
        });
    } else {
        alertInformacionVacia();
        modalStatus('modal-acontecimientos', 'close');
    }
}


function acontecimientoConsulta(idDestino, zona, dateGeneral) {
    var action = "consultaAcontecimiento";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_mantto.php",
        data: {
            action: action,
            idDestino: idDestino,
            zona: zona,
            dateGeneral: dateGeneral
        },
        dataType: 'json',
        success: function(data) {
            $("#bitacoraAcontecimientoConsulta").html(data.consultaAcontecimientoModal); //Modal
            $("#registroAcontecimiento").html(data.consultaAcontecimiento);
            $("#totalAcontecimiento").html(data.totalAcontecimiento);
            graficaAcontecimiento(data.diaSemana, data.graficaAcontecimiento);

        }
    });
}


function giftHabitacionesCaptura(idDestino, zona, dateGeneral) {
    var action = "giftHabitacionesCaptura";
    var pendientes = $("#giftHPendientes").val();
    var solucionados = $("#giftHSolucionados").val();
    var media_solucion_tiempo = $("#giftHMediaSolucion").val();
    var media_asignacion_tiempo = $("#giftHMediaAsignacion").val();
    var media_reparacion_tiempo = $("#giftHMediaReparacion").val();
    var satisfaccion = $("#giftHSatisfaccion").val();
    var no_alojado_origen = $("#giftHNoAlojadoOrigen").val();
    var trabajador_origen = $("#giftHTrabajadorOrigen").val();
    var husped_origen = $("#giftHHuspedOrigen").val();
    var tipificacion_top1 = $("#giftHTTop1").val();
    var total_top1 = $("#giftHTop1").val();
    var tipificacion_top2 = $("#giftHTTop2").val();
    var total_top2 = $("#giftHTop2").val();
    var tipificacion_top3 = $("#giftHTTop3").val();
    var total_top3 = $("#giftHTop3").val();
    var tipificacion_top4 = $("#giftHTTop4").val();
    var total_top4 = $("#giftHTop4").val();
    var tipificacion_top5 = $("#giftHTTop5").val();
    var total_top5 = $("#giftHTop5").val();
    var id = $("#idGiftHabitaciones").val();

    if (pendientes != "" &&
        solucionados != "" &&
        media_solucion_tiempo != "" &&
        media_asignacion_tiempo != "" &&
        media_reparacion_tiempo != "" &&
        satisfaccion != "" &&
        no_alojado_origen != "" &&
        trabajador_origen != "" &&
        husped_origen != "" &&
        tipificacion_top1 != "" &&
        total_top1 != "" &&
        tipificacion_top2 != "" &&
        total_top2 != "" &&
        tipificacion_top3 != "" &&
        total_top3 != "" &&
        tipificacion_top4 != "" &&
        total_top4 != "" &&
        tipificacion_top5 != "" &&
        total_top5 != "") {

        $.ajax({
            type: "post",
            url: "php/crud_bitacora_mantto.php",
            data: {
                action: action,
                idDestino: idDestino,
                zona: zona,
                dateGeneral: dateGeneral,
                pendientes: pendientes,
                solucionados: solucionados,
                media_solucion_tiempo: media_solucion_tiempo,
                media_asignacion_tiempo: media_asignacion_tiempo,
                media_reparacion_tiempo: media_reparacion_tiempo,
                satisfaccion: satisfaccion,
                no_alojado_origen: no_alojado_origen,
                trabajador_origen: trabajador_origen,
                husped_origen: husped_origen,
                tipificacion_top1: tipificacion_top1,
                total_top1: total_top1,
                tipificacion_top2: tipificacion_top2,
                total_top2: total_top2,
                tipificacion_top3: tipificacion_top3,
                total_top3: total_top3,
                tipificacion_top4: tipificacion_top4,
                total_top4: total_top4,
                tipificacion_top5: tipificacion_top5,
                total_top5: total_top5,
                id: id
            },
            // dataType: 'json',
            success: function(data) {
                // console.log(data);
                alertSuccess(data);
                modalStatus('modal-gift', 'close');

            }
        });
    } else {
        alertInformacionVacia();
        modalStatus('modal-gift', 'close');

    }
}


function giftHabitacionesConsulta(idDestino, zona, dateGeneral) {
    var action = "giftHabitacionesConsulta";
    // Limpia la informacion para recibir nuevaa
    $("#satisfaccionGH").html('0');
    $("#MSGH").html('0d 0h 0m');
    $("#MAGH").html('0d 0h 0m');
    $("#MRGH").html('0d 0h 0m');
    $("#solucionadoGH").html('0');
    $("#pendienteGH").html('0');
    graficaOrigenGH();
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_mantto.php",
        data: {
            action: action,
            idDestino: idDestino,
            zona: zona,
            dateGeneral: dateGeneral
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);
            $("#idGiftHabitaciones").val(data.idGiftHabitaciones);
            $("#giftHPendientes").val(data.pendientes);
            $("#giftHSolucionados").val(data.solucionados);
            $("#giftHMediaSolucion").val(data.media_solucion_tiempo);
            $("#giftHMediaAsignacion").val(data.media_asignacion_tiempo);
            $("#giftHMediaReparacion").val(data.media_reparacion_tiempo);
            $("#giftHSatisfaccion").val(data.satisfaccion);
            $("#giftHNoAlojadoOrigen").val(data.no_alojado_origen);
            $("#giftHTrabajadorOrigen").val(data.trabajador_origen);
            $("#giftHHuspedOrigen").val(data.husped_origen);
            $("#giftHTTop1").val(data.tipificacion_top1);
            $("#giftHTop1").val(data.total_top1);
            $("#giftHTTop2").val(data.tipificacion_top2);
            $("#giftHTop2").val(data.total_top2);
            $("#giftHTTop3").val(data.tipificacion_top3);
            $("#giftHTop3").val(data.total_top3);
            $("#giftHTTop4").val(data.tipificacion_top4);
            $("#giftHTop4").val(data.total_top4);
            $("#giftHTTop5").val(data.tipificacion_top5);
            $("#giftHTop5").val(data.total_top5);
            $("#btnGiftHabitaciones").html(data.btnGiftHabitaciones);

            // datos para las estadisticas.
            $("#satisfaccionGH").html(data.satisfaccion);
            $("#MSGH").html(data.media_solucion_tiempo);
            $("#MAGH").html(data.media_asignacion_tiempo);
            $("#MRGH").html(data.media_reparacion_tiempo);
            $("#solucionadoGH").html(data.pendientes);
            $("#pendienteGH").html(data.solucionados);
            graficaOrigenGH(data.no_alojado_origen, data.trabajador_origen, data.husped_origen);
            graficaTop5Habitaciones(data.total_top1, data.total_top2, data.total_top3, data.total_top4, data.total_top5, data.tipificacion_top1, data.tipificacion_top2, data.tipificacion_top3, data.tipificacion_top4, data.tipificacion_top5);
        }
    });
}


function giftCocinasCaptura(idDestino, zona, dateGeneral) {
    var action = "giftCocinasCaptura";
    var id = $("#idGiftCocinas").val();
    var giftCocinasPendientes = $("#giftCocinasPendientes").val();
    var giftCocinasSolucionados = $("#giftCocinasSolucionados").val();
    var giftCocinasMediaSolucion = $("#giftCocinasMediaSolucion").val();
    var giftCocinasMediaAsignacion = $("#giftCocinasMediaAsignacion").val();
    var giftCocinasMediaReparacion = $("#giftCocinasMediaReparacion").val();
    var giftCocinasAveriaTop1 = $("#giftCocinasAveriaTop1").val();
    var giftCocinasTop1 = $("#giftCocinasTop1").val();
    var giftCocinasAveriasTop2 = $("#giftCocinasAveriasTop2").val();
    var giftCocinasTop2 = $("#giftCocinasTop2").val();
    var giftCocinasAveriasTop3 = $("#giftCocinasAveriasTop3").val();
    var giftCocinasTop3 = $("#giftCocinasTop3").val();
    var giftCocinasAveriasTop4 = $("#giftCocinasAveriasTop4").val();
    var giftCocinasTop4 = $("#giftCocinasTop4").val();
    var giftCocinasAveriasTop5 = $("#giftCocinasAveriasTop5").val();
    var giftCocinasTop5 = $("#giftCocinasTop5").val();

    if (giftCocinasPendientes != "" &&
        giftCocinasSolucionados != "" &&
        giftCocinasMediaSolucion != "" &&
        giftCocinasMediaAsignacion != "" &&
        giftCocinasMediaReparacion != "" &&
        giftCocinasAveriaTop1 != "" &&
        giftCocinasTop1 != "" &&
        giftCocinasAveriasTop2 != "" &&
        giftCocinasTop2 != "" &&
        giftCocinasAveriasTop3 != "" &&
        giftCocinasTop3 != "" &&
        giftCocinasAveriasTop4 != "" &&
        giftCocinasTop4 != "" &&
        giftCocinasAveriasTop5 != "" &&
        giftCocinasTop5 != "") {


        $.ajax({

            type: "post",
            url: "php/crud_bitacora_mantto.php",
            data: {
                action: action,
                id: id,
                idDestino: idDestino,
                zona: zona,
                dateGeneral: dateGeneral,
                giftCocinasPendientes: giftCocinasPendientes,
                giftCocinasSolucionados: giftCocinasSolucionados,
                giftCocinasMediaSolucion: giftCocinasMediaSolucion,
                giftCocinasMediaAsignacion: giftCocinasMediaAsignacion,
                giftCocinasMediaReparacion: giftCocinasMediaReparacion,
                giftCocinasAveriaTop1: giftCocinasAveriaTop1,
                giftCocinasTop1: giftCocinasTop1,
                giftCocinasAveriasTop2: giftCocinasAveriasTop2,
                giftCocinasTop2: giftCocinasTop2,
                giftCocinasAveriasTop3: giftCocinasAveriasTop3,
                giftCocinasTop3: giftCocinasTop3,
                giftCocinasAveriasTop4: giftCocinasAveriasTop4,
                giftCocinasTop4: giftCocinasTop4,
                giftCocinasAveriasTop5: giftCocinasAveriasTop5,
                giftCocinasTop5: giftCocinasTop5

            },
            // dataType: 'json',
            success: function(data) {
                // console.log(data);
                modalStatus('modal-cobare', 'close');
                alertSuccess(data);

                // graficaEmpresas(arrayGremio, arrayData);

            }
        });



    } else {
        modalStatus('modal-cobare', 'close');
        alertInformacionVacia();
    }
}



function giftCocinasConsulta(idDestino, zona, dateGeneral) {
    var action = "giftCocinasConsulta";

    // Envio de datos a las estadisticas.
    $("#solucionadoGC").html('0');
    $("#pendientesGC").html('0');
    $("#mediaSolucionGC").html('0d 0h 0m');
    $("#mediaAsignacionGC").html('0d 0h 0m');
    $("#mediaReparacionGC").html('0d 0h 0m');
    // Envia datos a la grafica.
    graficaTop5Cocinas();

    $.ajax({

        type: "post",
        url: "php/crud_bitacora_mantto.php",
        data: {
            action: action,
            idDestino: idDestino,
            zona: zona,
            dateGeneral: dateGeneral

        },
        dataType: 'json',
        success: function(data) {
            // console.log(data);

            // Envia los datos a su input correspondiente para actualizar.
            $("#idGiftCocinas").val(data.id);
            $("#giftCocinasPendientes").val(data.pendientes);
            $("#giftCocinasSolucionados").val(data.solucionados);
            $("#giftCocinasMediaSolucion").val(data.media_solucion_tiempo);
            $("#giftCocinasMediaAsignacion").val(data.media_asignacion_tiempo);
            $("#giftCocinasMediaReparacion").val(data.media_reparacion_tiempo);
            $("#giftCocinasAveriaTop1").val(data.tipificacion_top1);
            $("#giftCocinasTop1").val(data.total_top1);
            $("#giftCocinasAveriasTop2").val(data.tipificacion_top2);
            $("#giftCocinasTop2").val(data.total_top2);
            $("#giftCocinasAveriasTop3").val(data.tipificacion_top3);
            $("#giftCocinasTop3").val(data.total_top3);
            $("#giftCocinasAveriasTop4").val(data.tipificacion_top4);
            $("#giftCocinasTop4").val(data.total_top4);
            $("#giftCocinasAveriasTop5").val(data.tipificacion_top5);
            $("#giftCocinasTop5").val(data.total_top5);
            $("#btnGiftCocinas").html(data.btnGiftCocinas);

            // Envio de datos a las estadisticas.
            $("#solucionadoGC").html(data.pendientes);
            $("#pendientesGC").html(data.solucionados);
            $("#mediaSolucionGC").html(data.media_solucion_tiempo);
            $("#mediaAsignacionGC").html(data.media_asignacion_tiempo);
            $("#mediaReparacionGC").html(data.media_reparacion_tiempo);

            // Envia datos a la grafica.
            graficaTop5Cocinas(data.tipificacion_top1,
                data.tipificacion_top2,
                data.tipificacion_top3,
                data.tipificacion_top4,
                data.tipificacion_top5,
                data.total_top1,
                data.total_top2,
                data.total_top3,
                data.total_top4,
                data.total_top5
            );
        }
    });
}



// Funcion para ocultar la seccion de Gift Cocinas y Gift Habitaciones cuando se selecciona la zona ZI.
function ocultarGift() {
    var ocultarGift = $("#zona").val();
    if (ocultarGift == "ZI") {
        $("#seccion4Gift").addClass('modal');
    } else {
        $("#seccion4Gift").removeClass('modal');
    }
}




// Funcion para cerrar o Abrir Modal donde se requiere el #ID y palabre Close u Open.
function modalStatus(idModal, status) {
    if (status == "open") {
        $("#" + idModal).addClass("open");
    } else {
        $("#" + idModal).removeClass("open");
    }
}


// Funcion para mostrar detalles consultaMPMCPROYECTOS.
function consultaMPMCPROYECTOS(id, seccion, subseccion, descripcion, comentario, status1, status2) {

    $("#seccionModalMCMPProyectos").html(seccion);
    $("#subseccionModalMCMPProyectos").html(subseccion);
    $("#descripcionModalMCMPProyectos").html(descripcion);
    $("#comentarioModalMCMPProyectos").html(comentario);
    $("#status1ModalMCMPProyectos").html(status1);
    $("#status2ModalMCMPProyectos").html(status2);
    console.log(id, seccion, subseccion, descripcion, comentario, status1, status2);
}


// funcion para cerrar modal con clase Modal.
function toggleModal(idModal) {
    $("#" + idModal).toggleClass('modal');
}


// Funcion que llama otra funciones para refrescar los datos donde enviar parametros Generales como: Fecha Seleccionada, Zona, Destino y Turno, depende de la funcion son los parametros que se le envia.
function funcionNombre(nombreFuncion) {
    var idDestino = $("#idDestino").val();
    var zona = $("#zona").val();
    var dateGeneral = $("#dateGeneral").val();
    var turnoSeleccionado = $("#turnoSeleccionado").val();

    if (zona == "ENERGETICOS") {
        location.href = "bitacora-energeticos.php";
    }

    switch (nombreFuncion) {
        case nombreFuncion = "gremioCantidad":
            // Llama a la funcion que muestra la cantidad por gremio en el formulario de personal
            gremioCantidad(idDestino, zona, dateGeneral, turnoSeleccionado);
            break;

        case nombreFuncion = "cantidadTurno":
            // Llama a la funcion que muestra el total de plantilla por turno.
            cantidadTurno(idDestino, zona, dateGeneral);
            consultaGraficaGremio(idDestino, zona, dateGeneral);
            break;

        case nombreFuncion = "MPMCPROYECTOS":
            MPMCPROYECTOS(idDestino, zona, dateGeneral);
            break;

            // Funcion para Caputras Bitacora de Empresas y Llama a la funcion para consultar los capturados.
        case nombreFuncion = "empresasExternasCaptura":
            empresasExternasCaptura(idDestino, zona, dateGeneral);
            empresasExternasConsulta(idDestino, zona, dateGeneral);
            break;

            // Funcion para consultar las empresas caputuradas.
        case nombreFuncion = "empresasExternasConsulta":
            empresasExternasConsulta(idDestino, zona, dateGeneral);
            break;

            // Funcion para Bitacora de Aconteciminetos.
        case nombreFuncion = "acontecimientoCaptura":
            acontecimientoCaptura(idDestino, zona, dateGeneral);
            acontecimientoConsulta(idDestino, zona, dateGeneral);
            break;

            // Funcion para Bitacora de Aconteciminetos.
        case nombreFuncion = "acontecimientoConsulta":
            acontecimientoConsulta(idDestino, zona, dateGeneral);
            break;

            // Captura Gift Habitaciones
        case nombreFuncion = "giftHabitacionesCaptura":
            giftHabitacionesCaptura(idDestino, zona, dateGeneral);
            giftHabitacionesConsulta(idDestino, zona, dateGeneral);
            break;

            // Consulta de Gift Habitaciones
        case nombreFuncion = "giftHabitacionesConsulta":
            giftHabitacionesConsulta(idDestino, zona, dateGeneral);
            break;

            // Captura de Gift Cocinas
        case nombreFuncion = "giftCocinasCaptura":
            giftCocinasCaptura(idDestino, zona, dateGeneral);
            giftCocinasConsulta(idDestino, zona, dateGeneral);
            break;

            // Consulta de Gift Cocinas
        case nombreFuncion = "giftCocinasConsulta":
            giftCocinasConsulta(idDestino, zona, dateGeneral);
            break;

        default:
    }
}


// Llama a la funcion para mostrar total por turnos en personal.
funcionNombre('cantidadTurno');
funcionNombre('MPMCPROYECTOS');
funcionNombre('empresasExternasConsulta');
funcionNombre('acontecimientoConsulta');
funcionNombre('giftHabitacionesConsulta');
funcionNombre('giftCocinasConsulta');