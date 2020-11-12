$("#opcion").val('ENERGETICOS');
// Funcion para seleccionar fecha.
const MONTH_NAMES = [
    "Enero",
    "Febrero",
    "Marzo",
    "Abril",
    "Mayo",
    "Junio",
    "Julio",
    "Agosto",
    "Septiembre",
    "Octubre",
    "Noviembre",
    "Diciembre",
];
const DAYS = ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];

function app() {
    return {
        showDatepicker: false,
        datepickerValue: "",

        month: "",
        year: "",
        no_of_days: [],
        blankdays: [],
        days: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],

        initDate() {
            let today = new Date();
            this.month = today.getMonth();
            this.year = today.getFullYear();
            this.datepickerValue = new Date(
                this.year,
                this.month,
                today.getDate()
            ).toDateString();
        },

        isToday(date) {
            const today = new Date();
            const d = new Date(this.year, this.month, date);

            return today.toDateString() === d.toDateString() ? true : false;
        },

        getDateValue(date) {
            let selectedDate = new Date(this.year, this.month, date);
            this.datepickerValue = selectedDate.toDateString();

            this.$refs.date.value =
                selectedDate.getFullYear() +
                "-" +
                ("0" + selectedDate.getMonth()).slice(-2) +
                "-" +
                ("0" + selectedDate.getDate()).slice(-2);

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
        },
    };
}

// Graficos para Bitacora Energeticos.

var ctx = document.getElementById("gelectricidad");
var gelectricidad = new Chart(ctx, {
    type: "line",
    data: {
        labels: [],
        datasets: [{
            label: "Historico",
            data: [],
            backgroundColor: "rgb(254, 252, 191)",
            borderColor: "rgba(255, 99, 132, 1)",
            borderWidth: 1,
        }, ],
    },
    options: {
        legend: {
            display: false,
            position: "bottom",
            align: "center",
        },

        tooltips: {
            enabled: true,
        },
    },
});


var ctx = document.getElementById("gagua");
var gagua = new Chart(ctx, {
    type: "line",
    data: {
        labels: [],
        datasets: [{
            label: "Historico",
            data: [],
            backgroundColor: "rgb(190, 227, 248)",
            borderColor: "rgba(255, 99, 132, 1)",
            borderWidth: 1,
        }, ],
    },
    options: {
        legend: {
            display: false,
            position: "bottom",
            align: "center",
        },

        tooltips: {
            enabled: true,
        },
    },
});


var ctx = document.getElementById("ggas");
var ggas = new Chart(ctx, {
    type: "line",
    data: {
        labels: [],
        datasets: [{
            label: "Historico",
            data: [],
            backgroundColor: "rgba(255, 99, 132, 0.2)",
            borderColor: "rgba(255, 99, 132, 1)",
            borderWidth: 1,
        }, ],
    },
    options: {
        legend: {
            display: false,
            position: "bottom",
            align: "center",
        },

        tooltips: {
            enabled: true,
        },
    },
});


var ctx = document.getElementById("gdiesel");
var gdiesel = new Chart(ctx, {
    type: "line",
    data: {
        labels: [],
        datasets: [{
            label: "Historico",
            data: [],
            backgroundColor: "rgb(254, 235, 200)",
            borderColor: "rgba(255, 99, 132, 1)",
            borderWidth: 1,
        }, ],
    },
    options: {
        legend: {
            display: false,
            position: "bottom",
            align: "center",
        },

        tooltips: {
            enabled: true,
        },
    },
});

// Funciones para Consumo del Dia.
function consumoDia(idDestino, opcion, fechaSeleccionada) {
    var action = "consumoDia";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_energeticos.php",
        data: {
            action: action,
            idDestino: idDestino,
            opcion: opcion,
            fechaSeleccionada: fechaSeleccionada
        },
        dataType: 'json',
        success: function(datos) {

            // Se envian los resultados al HTML.
            $("#dataElectricidad").html(datos.dataElectricidad);
            $("#iconElectricidad").html(datos.iconElectricidad);

            $("#dataAgua").html(datos.dataAgua);
            $("#iconAgua").html(datos.iconAgua);

            $("#dataGas").html(datos.dataGas);
            $("#iconGas").html(datos.iconGas);

            $("#dataDiesel").html(datos.dataDiesel);
            $("#iconDiesel").html(datos.iconDiesel);

            $("#dataOcupacion").html(datos.dataOcupacion);
            $("#iconOcupacion").html(datos.iconOcupacion);

            $("#dataPax").html(datos.dataPax);
            $("#iconPax").html(datos.iconPax);
        },
    });
}


// funcion para consultar acontecimientos.
function consultaAcontecimientos(idDestino, opcion, fechaSeleccionada) {
    // Segmento de codigo para el Modal de Acontecimientos.
    var energetico = $("#acontecimientosEnergetico").val().toLowerCase();

    // Se inicializa el contenido del Modal Acontecimientos.
    $("#dataModalAcontecimientosElectricidad").html('');
    $("#dataModalAcontecimientosAgua").html('');
    $("#dataModalAcontecimientosGas").html('');
    $("#dataModalAcontecimientosDiesel").html('');

    var action = "consultaAcontecimientos";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_energeticos.php",
        data: {
            action: action,
            idDestino: idDestino,
            opcion: opcion,
            fechaSeleccionada: fechaSeleccionada
        },
        dataType: 'json',
        success: function(datos) {
            // console.log(datos);

            // Se envian los resultados al HTML.
            $("#dataAcontecimientosElectricidad").html(datos.dataAcontecimientosElectricidad);

            $("#dataAcontecimientosElectricidadAgua").html(datos.dataAcontecimientosElectricidadAgua);

            $("#dataAcontecimientosElectricidadGas").html(datos.dataAcontecimientosElectricidadGas);

            $("#dataAcontecimientosElectricidadDiesel").html(datos.dataAcontecimientosElectricidadDiesel);

            // Comprueba la opción de Energético seleccionado.
            if (energetico == "electricidad") {
                $("#dataModalAcontecimientosElectricidad").html(datos.dataModalAcontecimientosElectricidad);
            }
            if (energetico == "agua") {
                $("#dataModalAcontecimientosAgua").html(datos.dataModalAcontecimientosAgua);
            }
            if (energetico == "gas") {
                $("#dataModalAcontecimientosGas").html(datos.dataModalAcontecimientosGas);
            }
            if (energetico == "diesel") {
                $("#dataModalAcontecimientosDiesel").html(datos.dataModalAcontecimientosDiesel);
            }
        },
    });
}


// funcion para consultar acontecimientos de una Semana.
function consultaAcontecimientosSemana(idDestino, opcion, fechaSeleccionada) {
    var action = "consultaAcontecimientosSemana";
    $.ajax({
        type: "post",
        url: "php/crud_bitacora_energeticos.php",
        data: {
            action: action,
            idDestino: idDestino,
            opcion: opcion,
            fechaSeleccionada: fechaSeleccionada
        },
        dataType: 'json',
        success: function(datos) {
            // console.log(datos);
            // console.log('Inicio: ' + datos.semanaInicio);
            // console.log('Fin: ' + datos.semanaFin);
            // console.log('Fin--: ' + datos.graficaSemanaGeneral);
            // console.log('Grafica Electricidad: ' + datos.graficaElectricidadCantidad);
            // console.log(datos.dataAcontecimientosElectricidad);
            $("#dataAcontecimientosElectricidadSemana").html(datos.dataAcontecimientosElectricidad);
            $("#dataAcontecimientosAguaSemana").html(datos.dataAcontecimientosAgua);
            $("#dataAcontecimientosGasSemana").html(datos.dataAcontecimientosGas);
            $("#dataAcontecimientosDiselSemana").html(datos.dataAcontecimientosDiesel);

            // Se convierten los datos en Arreglos para enviarlos a las Graficas.
            // el Arreglo arraySemana se envia a todas las graficas porque es el mismo dato para todas y no cambia.
            var arraySemana = datos.graficaSemanaGeneral.split(',');
            var cantidadElectricidad = datos.graficaElectricidadCantidad.split(',');
            var cantidadAgua = datos.graficaAgua.split(',');
            var cantidadGas = datos.graficaGas.split(',');
            var cantidadDiesel = datos.graficaDiesel.split(',');

            // Llama a las funciones que Generan las Graficas.


            async function graficaElectricidad() {

                gelectricidad.data.datasets[0].data = [];
                gelectricidad.data.labels = [];

                arraySemana.forEach(element => gelectricidad.data.labels.push(element));
                cantidadElectricidad.forEach(element => gelectricidad.data.datasets[0].data.push(element));

                // Función para Actualizar datos de la Grafica.
                await gelectricidad.update();
            }

            async function graficaAgua() {

                gagua.data.datasets[0].data = [];
                gagua.data.labels = [];

                arraySemana.forEach(element => gagua.data.labels.push(element));
                cantidadAgua.forEach(element => gagua.data.datasets[0].data.push(element));

                // Función para Actualizar datos de la Grafica.
                await gagua.update();
            }

            async function graficaGas() {

                ggas.data.datasets[0].data = [];
                ggas.data.labels = [];

                arraySemana.forEach(element => ggas.data.labels.push(element));
                cantidadGas.forEach(element => ggas.data.datasets[0].data.push(element));

                // Función para Actualizar datos de la Grafica.
                await ggas.update();
            }

            async function graficaDiesel() {

                gdiesel.data.datasets[0].data = [];
                gdiesel.data.labels = [];

                arraySemana.forEach(element => gdiesel.data.labels.push(element));
                cantidadDiesel.forEach(element => gdiesel.data.datasets[0].data.push(element));

                // Función para Actualizar datos de la Grafica.
                await gdiesel.update();
            }

            graficaElectricidad();
            graficaAgua();
            graficaGas();
            graficaDiesel();
        },
    });
}


function agregarAcontecimiento(idDestino, opcion, fechaSeleccionada) {
    var action = "agregarAcontecimiento";
    var titulo = $("#acontecimientosTitulo").val();
    var descripcion = $("#acontecimientosDescripcion").val();
    var energetico = $("#acontecimientosEnergetico").val();

    $.ajax({
        type: "post",
        url: "php/crud_bitacora_energeticos.php",
        data: {
            action: action,
            idDestino: idDestino,
            opcion: opcion,
            fechaSeleccionada: fechaSeleccionada,
            titulo: titulo,
            descripcion: descripcion,
            energetico: energetico
        },
        dataType: 'json',
        success: function(datos) {
            $("#acontecimientosTitulo").val('');
            $("#acontecimientosDescripcion").val('');
            alertInformacion('Acontecimiento Agregado.', 'success');
            llamarFuncion('consultaAcontecimientos');
            llamarFuncion('consultaAcontecimientosSemana');
        },
    });
}

function eliminarAcontecimiento(idAcontecimiento, contenido) {
    Swal.fire({
        title: '¿Eliminar Acontecimiento?',
        text: contenido,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Eliminado',
                '',
                'success',
                eliminarAcontecimientoConfir(idAcontecimiento)
            )
        }
    })

    function eliminarAcontecimientoConfir(idAcontecimiento) {
        var action = "eliminarAcontecimiento";
        $.ajax({
            type: "post",
            url: "php/crud_bitacora_energeticos.php",
            data: {
                action: action,
                idAcontecimiento: idAcontecimiento
            },
            dataType: 'json',
            success: function(datos) {
                llamarFuncion('consultaAcontecimientos');
                llamarFuncion('consultaAcontecimientosSemana');
            },
        });

    }
}


// Funcion para obtener parametros iniciales al cargar la pagina y llamar a Funciones.
function llamarFuncion(nombreFuncion) {
    var idDestino = $("#idDestino").val();
    var opcion = $("#opcion").val();
    var fechaSeleccionada = $("#dateGeneral").val();

    var zona = opcion;

    if (zona != "ENERGETICOS") {
        location.href = "bitacora_mantto.php";
    }

    switch (nombreFuncion) {

        //Llama a la función Consumo del Día.
        case (nombreFuncion = "consumoDia"):
            consumoDia(idDestino, opcion, fechaSeleccionada);
            break;

            // Llama a la función Acontecimiento del Día.
        case (nombreFuncion = "consultaAcontecimientos"):
            consultaAcontecimientos(idDestino, opcion, fechaSeleccionada);
            break;

            // Llama a la función Acontecimiento Semana.
        case (nombreFuncion = "consultaAcontecimientosSemana"):
            consultaAcontecimientosSemana(idDestino, opcion, fechaSeleccionada);
            break;

            // Llama a la función agregarAcontecimiento.
        case (nombreFuncion = "agregarAcontecimiento"):
            agregarAcontecimiento(idDestino, opcion, fechaSeleccionada);
            break;

        default:
            break;
    }
}


function modalTailwind(modal, opcion) {
    $("#" + modal).toggleClass('hidden');
}



// Llamada de funciones iniciales.
llamarFuncion('consumoDia');
llamarFuncion('consultaAcontecimientos');
llamarFuncion('consultaAcontecimientosSemana');