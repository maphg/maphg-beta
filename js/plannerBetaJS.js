// VARIABLES GLOBALES, (VALOR ESTATICO AL CARGAR LA PAGINA)
let idUsuario = localStorage.getItem("usuario");
let idDestino = localStorage.getItem("idDestino");
// VARIABLES GLOBALES, (VALOR ESTATICO AL CARGAR LA PAGINA)

// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

// ICONOS 
const iconoLoader = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
const iconoDefault = '<i class="fad fa-minus text-xl text-red-400"></i>';

// ELEMENTOS BUTTOM ID
const btnModalAgregarIncidencias = document.getElementById("btnModalAgregarIncidencias");
const btnTGIncidencias = document.getElementById("btnTGIncidencias");
const btnEquipoIncidencias = document.getElementById("btnEquipoIncidencias");
const btnLocalIncidencias = document.getElementById("btnLocalIncidencias");
const btnEmergenciaIncidencia = document.getElementById("btnEmergenciaIncidencia");
const btnUrgenciaIncidencia = document.getElementById("btnUrgenciaIncidencia");
const btnAlarmaIncidencia = document.getElementById("btnAlarmaIncidencia");
const btnAlertaIncidencia = document.getElementById("btnAlertaIncidencia");
const btnSeguimientoIncidencia = document.getElementById("btnSeguimientoIncidencia");
const btnAgregarIncidencia = document.getElementById("btnAgregarIncidencia");
const descripcionIncidencia = document.getElementById("descripcionIncidencia");
const rangoFechaIncidencia = document.getElementById("rangoFechaIncidencia");
const comentarioIncidencia = document.getElementById("comentarioIncidencia");
const btnFlotante = document.getElementById("btnFlotante");
const btnFlotanteOpciones = document.getElementById("btnFlotanteOpciones");
const btnAgregarEnergeticos = document.getElementById("btnAgregarEnergeticos");
const palabraEnergeticos = document.getElementById("palabraEnergeticos");
// ELEMENTOS BUTTOM ID

// ELEMENTOS <INPUTS> ID
const seccionIncidencias = document.getElementById("seccionIncidencias");
const subseccionIncidencias = document.getElementById("subseccionIncidencias");
const equipoLocalIncidencias = document.getElementById("equipoLocalIncidencias");
const responsablesIncidencias = document.getElementById("responsablesIncidencias");
const tituloPendienteEnergeticos = document.getElementById("tituloPendienteEnergeticos");
const rangoFechaEnergeticos = document.getElementById("rangoFechaEnergeticos");
const responsableEnergeticos = document.getElementById("responsableEnergeticos");
const comentarioEnergeticos = document.getElementById("comentarioEnergeticos");
// ELEMENTOS <INPUTS> ID

// CONTENEDORES DIV ID
const contenedorEquipoLocalIncidencias = document.
   getElementById("contenedorEquipoLocalIncidencias");
const btnModalAgregarEnergeticos = document.getElementById("btnModalAgregarEnergeticos");
const nombreSubseccionEnergeticos = document.getElementById("nombreSubseccionEnergeticos");
// CONTENEDORES DIV ID

// CONTENEDORES DIV CLASS
const btnOpcionIncidencia = document.getElementsByClassName("btnOpcionIncidencia");
// CONTENEDORES DIV CLASS


// Función principal.
function comprobarSession() {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   // Comprueba que exista la sessión
   if (idUsuario > 0 || idDestino > 0) {
      llamarFuncionX("consultaSubsecciones");
      hora();
   } else {
      alertaImg('Sessión No Iniciada', '', 'info', 3000);
      location.replace("login.php");
   }
}

document.getElementById("destinosSelecciona").addEventListener('click', () => {
   botonDestino();
});

// Obtiene información del usuario, para mostrarlo en el menú 
function obtenerDatosUsuario(idDestino) {
   localStorage.setItem("idDestino", idDestino);
   let idUsuario = localStorage.getItem("usuario");
   const action = "obtenerDatosUsuario";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("avatarUsuario").innerHTML =
            '<img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=' + data.nombre + " % " + data.apellido + '"' +
            'alt="avatar" class="menu-contenedor-6">';
         document.getElementById("nombreUsuarioNavBarTop").innerHTML =
            data.nombre + " " + data.apellido;
         document.getElementById("nombreUsuarioMenu").innerHTML =
            data.nombre + " " + data.apellido;
         document.getElementById("cargoUsuarioMeu").innerHTML = data.cargo;
         document.getElementById("destinoNavBarTop").innerHTML = data.destino;
         document.getElementById("destinosSelecciona").innerHTML =
            data.destinosOpcion;
         // alertaImg("Destino: " + data.destino, "", "success", 2000);
         comprobarSession();
      },
      error: function (err) {
         comprobarSession();
         fetch(APIERROR + ' ' + err);
      }
   });
}


// FUNCION PARA RANGO FECHA
function rangoFechaX(idInput) {
   let input = document.getElementById(idInput);

   $('#' + idInput).daterangepicker({
      autoUpdateInput: false,
      showWeekNumbers: true,
      locale: {
         cancelLabel: "Cancelar",
         applyLabel: "Aplicar",
         fromLabel: "De",
         toLabel: "A",
         customRangeLabel: "Personalizado",
         weekLabel: "S",
         daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
         monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      },
   });

   $('#' + idInput).on("apply.daterangepicker", function (
      ev,
      picker
   ) {
      $(this).val(
         picker.startDate.format("DD/MM/YYYY") +
         " - " +
         picker.endDate.format("DD/MM/YYYY")
      );
   });
}

// FUNCION PARA ACTUALIZAR RANGO FECHA #rangoFechaX
$(function () {
   $('input[name="rangoFechaX"]').daterangepicker({
      autoUpdateInput: false,
      showWeekNumbers: true,
      locale: {
         cancelLabel: "Cancelar",
         applyLabel: "Aplicar",
         fromLabel: "De",
         toLabel: "A",
         customRangeLabel: "Personalizado",
         weekLabel: "S",
         daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
         monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      },
   });

   $('input[name="rangoFechaX"]').on("apply.daterangepicker", function (
      ev,
      picker
   ) {
      $(this).val(
         picker.startDate.format("DD/MM/YYYY") +
         " - " +
         picker.endDate.format("DD/MM/YYYY")
      );
   });
})

// Función para Input Fechas para Agregar MC.
$(function () {
   $('input[name="datefilter"]').daterangepicker({
      autoUpdateInput: false,
      showWeekNumbers: true,
      locale: {
         cancelLabel: "Cancelar",
         applyLabel: "Aplicar",
         fromLabel: "De",
         toLabel: "A",
         customRangeLabel: "Personalizado",
         weekLabel: "S",
         daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
         monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      },
   });
   $('input[name="datefilter"]').on("apply.daterangepicker", function (
      ev,
      picker
   ) {
      $(this).val(
         picker.startDate.format("DD/MM/YYYY") +
         " - " +
         picker.endDate.format("DD/MM/YYYY")
      );
   });
   $('input[name="datefilter"]').on("cancel.daterangepicker", function (
      ev,
      picker
   ) {
      $(this).val("");
   });
});


// Función para Input Fechas PROYECTOS
$(function () {
   $('input[name="fechaProyecto"]').daterangepicker({
      autoUpdateInput: true,
      showWeekNumbers: true,
      locale: {
         cancelLabel: "Cancelar",
         applyLabel: "Aplicar",
         fromLabel: "De",
         toLabel: "A",
         customRangeLabel: "Personalizado",
         weekLabel: "S",
         daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
         monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      },
   });

   $('input[name="fechaProyecto"]').on("apply.daterangepicker", function (ev, picker) {
      $(this).val(picker.startDate.format("DD/MM/YYYY") + " - " + picker.endDate.format("DD/MM/YYYY")
      );

      // Actualiza fecha TAREAS cuando se Aplica el rango.
      let rangoFecha =
         picker.startDate.format("DD/MM/YYYY") +
         " - " +
         picker.endDate.format("DD/MM/YYYY");
      let idProyecto = localStorage.getItem("idProyecto");
      actualizarProyectos(rangoFecha, "rango_fecha", idProyecto);
   });
   $('input[name="fechaProyecto"]').on("cancel.daterangepicker", function (
      ev,
      picker
   ) {
      $(this).val("");
   });
});


// Función para Input Fechas TAREAS
$(function () {
   $('input[name="fechaTareas"]').daterangepicker({
      autoUpdateInput: false,
      showWeekNumbers: true,
      locale: {
         cancelLabel: "Cancelar",
         applyLabel: "Aplicar",
         fromLabel: "De",
         toLabel: "A",
         customRangeLabel: "Personalizado",
         weekLabel: "S",
         daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
         monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre",
         ],
      },
   });
   $('input[name="fechaTareas"]').on("apply.daterangepicker", function (
      ev,
      picker
   ) {
      $(this).val(
         picker.startDate.format("DD/MM/YYYY") +
         " - " +
         picker.endDate.format("DD/MM/YYYY")
      );

      // Actualiza fecha TAREAS cuando se Aplica el rango.
      let rangoFecha =
         picker.startDate.format("DD/MM/YYYY") +
         " - " +
         picker.endDate.format("DD/MM/YYYY");
      let idTarea = localStorage.getItem("idTarea");
      actualizarTareas(idTarea, "rango_fecha", rangoFecha);
   });
   $('input[name="fechaTareas"]').on("cancel.daterangepicker", function (
      ev,
      picker
   ) {
      $(this).val("");
   });
});


// Función para Input Fechas FALLAS
$(function () {
   $('input[name="fechaMC"]').daterangepicker({
      autoUpdateInput: true,
      showWeekNumbers: true,
      locale: {
         cancelLabel: "Cancelar",
         applyLabel: "Aplicar",
         fromLabel: "De",
         toLabel: "A",
         customRangeLabel: "Personalizado",
         weekLabel: "S",
         daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
         monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
      },
   });
   $('input[name="fechaMC"]').on("apply.daterangepicker", function (ev, picker) {
      $(this).val(
         picker.startDate.format("DD/MM/YYYY") +
         " - " +
         picker.endDate.format("DD/MM/YYYY")
      );

      // Actualiza fecha MC cuando se Aplica el rango.
      let rangoFecha =
         picker.startDate.format("DD/MM/YYYY") +
         " - " +
         picker.endDate.format("DD/MM/YYYY");
      let idMC = localStorage.getItem("idMC");
      actualizarStatusMC(idMC, "rango_fecha", rangoFecha);
   });
   $('input[name="fechaMC"]').on("cancel.daterangepicker", function (
      ev,
      picker
   ) {
      $(this).val("");
   });
});


// Funcion para los Botones de los Calendario
function botones(idd) {
   let nombreCol = idd.toUpperCase();
   if (document.getElementById("col" + idd)) {
      switch (idd) {
         case "zia":
            document.getElementById("colzia").classList.toggle("hidden");
            document.getElementById("btn-zia").classList.toggle("btn-activo");
            break;
         case "zie":
            document.getElementById("colzie").classList.toggle("hidden");
            document.getElementById("btn-zie").classList.toggle("btn-activo");
            break;
         case "zhh":
            document.getElementById("colzhh").classList.toggle("hidden");
            document.getElementById("btn-zhh").classList.toggle("btn-activo");
            break;
         case "zic":
            document.getElementById("colzic").classList.toggle("hidden");
            document.getElementById("btn-zic").classList.toggle("btn-activo");
            break;
         case "zhp":
            document.getElementById("colzhp").classList.toggle("hidden");
            document.getElementById("btn-zhp").classList.toggle("btn-activo");
            break;
         case "dec":
            document.getElementById("coldec").classList.toggle("hidden");
            document.getElementById("btn-dec").classList.toggle("btn-activo");
            break;
         case "zhc":
            document.getElementById("colzhc").classList.toggle("hidden");
            document.getElementById("btn-zhc").classList.toggle("btn-activo");
            break;
         case "zha":
            document.getElementById("colzha").classList.toggle("hidden");
            document.getElementById("btn-zha").classList.toggle("btn-activo");
            break;
         case "zil":
            document.getElementById("colzil").classList.toggle("hidden");
            document.getElementById("btn-zil").classList.toggle("btn-activo");
            break;
         case "auto":
            document.getElementById("colauto").classList.toggle("hidden");
            document.getElementById("btn-auto").classList.toggle("btn-activo");
            break;
         case "dep":
            document.getElementById("coldep").classList.toggle("hidden");
            document.getElementById("btn-dep").classList.toggle("btn-activo");
            break;
      }
   } else {
      alertaImg("Acceso Denegado: " + nombreCol, "", "info", 1500);
   }
}


// Función para el calendario de Secciones.
function calendarioSecciones() {
   var numSem = new Date().getDay();
   var diasSem = ["domingo", "lunes", "martes", "miercoles", "jueves", "viernes", "sabado"];
   var hoydia = diasSem[numSem];
   var horas = new Date().getHours();
   var minutos = new Date().getMinutes();
   var mes = new Date().getMonth() + 1;
   var dia = new Date().getDate();

   if (dia < 10) {
      dia = "0" + dia;
   }

   if (mes < 10) {
      mes = "0" + mes;
   }

   document.getElementById("hora").innerHTML = horas + ": " + minutos;
   document.getElementById("mes").innerHTML = mes;
   document.getElementById("dia").innerHTML = dia;

   // Restable Clases en los Botones.


   if (document.getElementById("colzia")) {
      document.getElementById("colzia").classList.add("hidden");
      document.getElementById("btn-zia").classList.remove("btn-activo");

   }

   if (document.getElementById("colzhp")) {
      document.getElementById("colzhp").classList.add("hidden");
      document.getElementById("btn-zhp").classList.remove("btn-activo");
   }

   if (document.getElementById("coldep")) {
      document.getElementById("coldep").classList.add("hidden");
      document.getElementById("btn-dep").classList.remove("btn-activo");
      document.getElementById("btn-dep").classList.remove("btn-activo");
   }

   if (document.getElementById("colzic")) {
      document.getElementById("colzic").classList.add("hidden");
      document.getElementById("btn-zic").classList.remove("btn-activo");
   }

   if (document.getElementById("coldec")) {
      document.getElementById("coldec").classList.add("hidden");
      document.getElementById("btn-dec").classList.remove("btn-activo");
   }

   if (document.getElementById("colzie")) {
      document.getElementById("colzie").classList.add("hidden");
      document.getElementById("btn-zie").classList.remove("btn-activo");
   }

   if (document.getElementById("colzhc")) {
      document.getElementById("colzhc").classList.add("hidden");
      document.getElementById("btn-zhc").classList.remove("btn-activo");
   }

   if (document.getElementById("colzha")) {
      document.getElementById("colzha").classList.add("hidden");
      document.getElementById("btn-zha").classList.remove("btn-activo");
   }

   if (document.getElementById("colzil")) {
      document.getElementById("colzil").classList.add("hidden");
      document.getElementById("btn-zil").classList.remove("btn-activo");
   }

   if (document.getElementById("colauto")) {
      document.getElementById("colauto").classList.add("hidden");
      document.getElementById("btn-auto").classList.remove("btn-activo");
   }

   switch (hoydia) {
      case "lunes":
         document.getElementById("label-lunes").classList.add("text-gray-700");

         if (document.getElementById("colzia")) {
            document.getElementById("btn-zia").classList.add("btn-activo");
            document.getElementById("colzia").classList.remove("hidden");
         }
         if (document.getElementById("colzhp")) {
            document.getElementById("btn-zhp").classList.add("btn-activo");
            document.getElementById("colzhp").classList.remove("hidden");
         }
         if (document.getElementById("coldep")) {
            document.getElementById("btn-dep").classList.add("btn-activo");
            document.getElementById("coldep").classList.remove("hidden");
         }

         break;

      case "martes":
         document.getElementById("label-martes").classList.add("text-gray-700");

         if (document.getElementById("colzic")) {
            document.getElementById("btn-zic").classList.add("btn-activo");
            document.getElementById("colzic").classList.remove("hidden");
         }
         if (document.getElementById("colzhh")) {
            document.getElementById("btn-zhh").classList.add("btn-activo");
            document.getElementById("colzhh").classList.remove("hidden");
         }
         if (document.getElementById("coldep")) {
            document.getElementById("btn-dep").classList.add("btn-activo");
            document.getElementById("coldep").classList.remove("hidden");
         }
         break;

      case "miercoles":
         document.getElementById("label-miercoles").classList.add("text-gray-700");

         if (document.getElementById("coldec")) {
            document.getElementById("btn-dec").classList.add("btn-activo");
            document.getElementById("coldec").classList.remove("hidden");
         }
         if (document.getElementById("coldep")) {
            document.getElementById("btn-dep").classList.add("btn-activo");
            document.getElementById("coldep").classList.remove("hidden");
         }
         if (document.getElementById("colzie")) {
            document.getElementById("btn-zie").classList.add("btn-activo");
            document.getElementById("colzie").classList.remove("hidden");
         }
         break;

      case "jueves":
         document.getElementById("label-jueves").classList.add("text-gray-700");

         if (document.getElementById("colzhc")) {
            document.getElementById("btn-zhc").classList.add("btn-activo");
            document.getElementById("colzhc").classList.remove("hidden");
         }
         if (document.getElementById("colzha")) {
            document.getElementById("btn-zha").classList.add("btn-activo");
            document.getElementById("colzha").classList.remove("hidden");
         }
         if (document.getElementById("coldep")) {
            document.getElementById("btn-dep").classList.add("btn-activo");
            document.getElementById("coldep").classList.remove("hidden");
         }
         break;

      case "viernes":
         document.getElementById("label-viernes").classList.add("text-gray-700");

         if (document.getElementById("colzil")) {
            document.getElementById("btn-zil").classList.add("btn-activo");
            document.getElementById("colzil").classList.remove("hidden");
         }
         if (document.getElementById("coldep")) {
            document.getElementById("btn-dep").classList.add("btn-activo");
            document.getElementById("coldep").classList.remove("hidden");
         }
         if (document.getElementById("colauto")) {
            document.getElementById("btn-auto").classList.add("btn-activo");
            document.getElementById("colauto").classList.remove("hidden");
         }
         break;

      default:
         if (document.getElementById("colzia")) {
            document.getElementById("btn-zia").classList.add("btn-activo");
            document.getElementById("colzia").classList.remove("hidden");
         }
         if (document.getElementById("colzhp")) {
            document.getElementById("btn-zhp").classList.add("btn-activo");
            document.getElementById("colzhp").classList.remove("hidden");
         }
         if (document.getElementById("coldep")) {
            document.getElementById("btn-dep").classList.add("btn-activo");
            document.getElementById("coldep").classList.remove("hidden");
         }
         if (document.getElementById("colzhh")) {
            document.getElementById("btn-zhh").classList.add("btn-activo");
            document.getElementById("colzhh").classList.remove("hidden");
         }
         if (document.getElementById("colzic")) {
            document.getElementById("btn-zic").classList.add("btn-activo");
            document.getElementById("colzic").classList.remove("hidden");
         }
         if (document.getElementById("coldec")) {
            document.getElementById("btn-dec").classList.add("btn-activo");
            document.getElementById("coldec").classList.remove("hidden");
         }
         if (document.getElementById("colzie")) {
            document.getElementById("btn-zie").classList.add("btn-activo");
            document.getElementById("colzie").classList.remove("hidden");
         }
         if (document.getElementById("colzhc")) {
            document.getElementById("btn-zhc").classList.add("btn-activo");
            document.getElementById("colzhc").classList.remove("hidden");
         }
         if (document.getElementById("colzha")) {
            document.getElementById("btn-zha").classList.add("btn-activo");
            document.getElementById("colzha").classList.remove("hidden");
         }
         if (document.getElementById("colzil")) {
            document.getElementById("btn-zil").classList.add("btn-activo");
            document.getElementById("colzil").classList.remove("hidden");
         }
         if (document.getElementById("colauto")) {
            document.getElementById("btn-auto").classList.add("btn-activo");
            document.getElementById("colauto").classList.remove("hidden");
         }
         break;
   }
}


function expandir(id) {
   let idtoggle = id + "toggle";
   let idtitulo = id + "titulo";

   if (document.getElementById(idtoggle)) {
      var toggle = document.getElementById(idtoggle);
      toggle.classList.toggle("hidden");

      if (document.getElementById(idtitulo)) {
         document.getElementById(idtitulo).classList.toggle("truncate");
      }
   }
}


function expandirpapa(idpapa) {
   var expandeapapa = document.getElementById(idpapa);
   expandeapapa.classList.toggle("h-40");
}


// Función para actualizar la Hora.
function hora() {
   var arrayDestino = {
      1: "RM",
      7: "CMU",
      2: "PVR",
      6: "MBJ",
      5: "PUJ",
      11: "CAP",
      3: "SDQ",
      4: "SSA",
      10: "AME",
   };
   let idDestino = localStorage.getItem("idDestino");
   let h = new Date();
   let hora = h.getHours() + ": " + h.getMinutes();
   let nombreDestinoArray = arrayDestino[idDestino];

   document.getElementById("hora").innerHTML = hora;
   document.getElementById("nombreDestino").innerHTML = nombreDestinoArray;
}


// Desde aquí se habla a la función hora(), cada 1min.
setInterval("hora()", 70000);

// toggleClass Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
   $("#" + idModal).toggleClass("open");
}


// Funcion para ocultar y mostrar con clases.
function mostrarOcultar(claseMostrar, claseOcultar) {
   $("." + claseMostrar).removeClass("hidden invisible");
   $("." + claseOcultar).addClass("hidden invisible");
}


// toggle Inivisible Generico.
function toggleInivisble(id) {
   $("#" + id).toggleClass("modal");
}


// Obtiene las subsecciones para la pagina principal de Planner, mediante el idDestino.
function consultaSubsecciones(idDestino, idUsuario) {
   const action = "consultaSubsecciones";

   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idDestino: idDestino,
         idUsuario: idUsuario,
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("columnasSeccionesZIL").innerHTML = data.dataZIL;
         document.getElementById("columnasSeccionesZIE").innerHTML = data.dataZIE;
         document.getElementById("columnasSeccionesAUTO").innerHTML = data.dataAUTO;
         document.getElementById("columnasSeccionesDEC").innerHTML = data.dataDEC;
         document.getElementById("columnasSeccionesDEP").innerHTML = data.dataDEP;
         document.getElementById("columnasSeccionesOMA").innerHTML = data.dataOMA;
         document.getElementById("columnasSeccionesZHA").innerHTML = data.dataZHA;
         document.getElementById("columnasSeccionesZHC").innerHTML = data.dataZHC;
         document.getElementById("columnasSeccionesZHH").innerHTML = data.dataZHH;
         document.getElementById("columnasSeccionesZHP").innerHTML = data.dataZHP;
         document.getElementById("columnasSeccionesZIA").innerHTML = data.dataZIA;
         document.getElementById("columnasSeccionesZIC").innerHTML = data.dataZIC;
         document.getElementById("columnasSeccionesZHH").innerHTML = data.dataZHH;
         document.getElementById("columnasSeccionesEnergeticos").innerHTML = data.dataEnergeticos;
         calendarioSecciones();
      },
   });
}


// Obtiene los pendientes de las secciones mediante la seccion seleccionada y el destinol.
function pendientesSubsecciones(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino) {
   let contenedorSubsecciones = document.getElementById("dataOpcionesSubseccionestoggle");
   document.getElementById("modalPendientes").classList.add("open");
   document.getElementById("estiloSeccion").innerHTML = iconoLoader;
   // document.getElementById("modalTituloSeccion").innerHTML = nombreSeccion;
   document.getElementById("dataSubseccionesPendientes").innerHTML =
      "Obteniendo Datos...";

   // Valores iniciales
   contenedorSubsecciones.innerHTML = "";

   const action = "consultarPendientesSubsecciones";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idSeccion: idSeccion,
         tipoPendiente: tipoPendiente,
      },
      dataType: "JSON",
      success: function (data) {

         // OPCIONES PARA SUBSECCIONES
         contenedorSubsecciones.innerHTML = data.dataOpcionesSubsecciones;

         // Tipo de Vista Seleccionado
         document.getElementById("tipoPendienteNombre").innerHTML =
            data.tipoPendienteNombre;

         // Resultado de Consulta.
         document.getElementById("estiloSeccion").innerHTML = data.estiloSeccion;

         // Función para darle diseño del Logo según la Sección.
         estiloSeccion("estiloSeccion", data.estiloSeccion);
         document.getElementById("dataSubseccionesPendientes").innerHTML = data.resultData;
         document.getElementById("dataExportarSubseccionesEXCEL").innerHTML = data.exportarSubseccion;
         document.getElementById("dataExportarSubseccionesPDF").innerHTML = data.exportarSubseccionPDF;

         // Pestañas para Mostrar Pendientes.
         document.getElementById("misPendientesUsuario")
            .setAttribute("onclick", "pendientesSubsecciones(" + data.misPendientesUsuario + ")");

         document.getElementById("misPendientesCreados")
            .setAttribute("onclick", "pendientesSubsecciones(" + data.misPendientesCreados + ")");

         document.getElementById("misPendientesSinUsuario")
            .setAttribute("onclick", "pendientesSubsecciones(" + data.misPendientesSinUsuario + ")");

         document.getElementById("misPendientesSeccion")
            .setAttribute("onclick", "pendientesSubsecciones(" + data.misPendientesSeccion + ")");

         // Pestaña Exportar
         document.getElementById("exportarMisPendientes")
            .setAttribute("onclick", "exportarPendientes(" + data.exportarMisPendientes + ")");

         document.getElementById("exportarSeccion")
            .setAttribute("onclick", "exportarPendientes(" + data.exportarSeccion + ")");

         // Subseccion EXCEL
         document.getElementById("exportarSeccion")
            .setAttribute("onclick", "exportarPendientes(" + data.exportarSeccion + ")");

         // Responsable EXCEL
         document.getElementById("responsableUsuario")
            .setAttribute("onclick", "exportarPorUsuario(" + data.exportarPorResponsable + ")");

         document.getElementById("exportarMisCreados")
            .setAttribute("onclick", "exportarPendientes(" + data.exportarMisCreados + ")");

         // Creados Por
         document.getElementById("exportarCreadosPorEXCEL")
            .setAttribute("onclick", "exportarPorUsuario(" + data.exportarMisCreados + ")");

         document.getElementById("exportarMisPendientesPDF")
            .setAttribute("onclick", "exportarPendientes(" + data.exportarMisPendientesPDF + ")");

         document.getElementById("exportarMisCreadosPDF")
            .setAttribute("onclick", "exportarPendientes(" + data.exportarMisCreadosPDF + ")");

         // Subsección PDF
         document.getElementById("exportarMisCreadosPDF")
            .setAttribute("onclick", "exportarPendientes(" + data + ")");

         // Colaborador PDF
         document.getElementById("exportarCreadosPorPDF")
            .setAttribute("onclick", "exportarPorUsuario(" + data.exportarMisCreadosPDF + ")");

         // Resultado Contador
         document.getElementById("tablaPendientes").childNodes[1].childNodes[1].childNodes[3].innerHTML = 'Pendientes ' + '(' + data.contadorTyF + ')';

         document.getElementById("tablaPendientes").childNodes[1].childNodes[1].childNodes[5].innerHTML = 'Pendientes DEP ' + '(' + data.contadorDEP + ')';

         document.getElementById("tablaPendientes").childNodes[1].childNodes[1].childNodes[7].innerHTML = 'Trabajando ' + '(' + data.contadorT + ')';

         document.getElementById("tablaPendientes").childNodes[1].childNodes[1].childNodes[9].innerHTML = 'Solucionados ' + '(' + data.contadorS + ')';

      },
   });
}


function toggleSubseccionesTipo(mostrar, ocultar) {
   document.getElementById("modalExportarSubsecciones").classList.add("open");
   document.getElementById(mostrar).classList.remove("hidden");
   document.getElementById(ocultar).classList.add("hidden");
}


// Muestra Usuario para Exportar sus pendientes o Creados.
function exportarPorUsuario(
   idUsuario,
   idDestino,
   idSeccion,
   idSubseccion,
   tipoExportar
) {
   document.getElementById("dataExportarSeccionesUsuarios").innerHTML = "";
   let palabraUsuario = document.getElementById("palabraUsuarioExportar").value;
   // Agrega la función en el Input palabraUsuarioExportar.
   document
      .getElementById("palabraUsuarioExportar")
      .setAttribute(
         "onkeyup",
         "exportarPorUsuario(" +
         idUsuario +
         ", " +
         idDestino +
         ", " +
         idSeccion +
         ", " +
         idSubseccion +
         ', "' +
         tipoExportar +
         '")'
      );
   const action = "exportarPorUsuario";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idSeccion: idSeccion,
         idSubseccion: idSubseccion,
         tipoExportar: tipoExportar,
         palabraUsuario: palabraUsuario,
      },
      // dataType: "JSON",
      success: function (data) {
         document
            .getElementById("modalExportarSeccionesUsuarios")
            .classList.add("open");
         document.getElementById("dataExportarSeccionesUsuarios").innerHTML = data;
      },
   });
}


// El estilo se aplica DIV>H1(class="zie-logo").
function estiloSeccionModal(padreSeccion, seccion = 0) {
   let seccionClase = seccion.toLowerCase() + "-logo-modal";
   document.getElementById(padreSeccion).classList.remove("zil-logo-modal");
   document.getElementById(padreSeccion).classList.remove("zie-logo-modal");
   document.getElementById(padreSeccion).classList.remove("auto-logo-modal");
   document.getElementById(padreSeccion).classList.remove("dec-logo-modal");
   document.getElementById(padreSeccion).classList.remove("dep-logo-modal");
   document.getElementById(padreSeccion).classList.remove("zha-logo-modal");
   document.getElementById(padreSeccion).classList.remove("zhc-logo-modal");
   document.getElementById(padreSeccion).classList.remove("zhp-logo-modal");
   document.getElementById(padreSeccion).classList.remove("zia-logo-modal");
   document.getElementById(padreSeccion).classList.remove("zic-logo-modal");
   document.getElementById(padreSeccion).classList.remove("zhh-logo-modal");

   document.getElementById(padreSeccion).classList.add(seccionClase);
}


// El estilo se aplica DIV>H1(class="zie-logo").
function estiloSeccion(padreSeccion, seccion) {
   let seccionClase = seccion.toLowerCase() + "-logo";
   document.getElementById(padreSeccion).classList.remove("zil-logo");
   document.getElementById(padreSeccion).classList.remove("zie-logo");
   document.getElementById(padreSeccion).classList.remove("auto-logo");
   document.getElementById(padreSeccion).classList.remove("dec-logo");
   document.getElementById(padreSeccion).classList.remove("dep-logo");
   document.getElementById(padreSeccion).classList.remove("zha-logo");
   document.getElementById(padreSeccion).classList.remove("zhc-logo");
   document.getElementById(padreSeccion).classList.remove("zhp-logo");
   document.getElementById(padreSeccion).classList.remove("zia-logo");
   document.getElementById(padreSeccion).classList.remove("zic-logo");
   document.getElementById(padreSeccion).classList.remove("zhh-logo");

   document.getElementById(padreSeccion).classList.add(seccionClase);
}


// Función para buscar usuarios para Exportar.
function exportarListarUsuarios(idUsuario, idDestino, idSeccion) {
   const action = "exportarListarUsuarios";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idSeccion: idSeccion,
      },
      // dataType: "JSON",
      success: function (data) {
         document.getElementById("dataExportarSeccionesUsuarios").innerHTML = data;
      },
   });
}


// Funcion para Ver y Exportar los pendientes de las secciones.
function exportarPendientes(
   idUsuario,
   idDestino,
   idSeccion,
   idSubseccion,
   tipoExportar
) {
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
         tipoExportar: tipoExportar,
      },
      dataType: "JSON",
      success: function (data) {
         let usuarioSession = localStorage.getItem("usuario");

         if (tipoExportar == "exportarMisPendientes") {
            page =
               "php/generarPendientesExcel.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&generadoPor=" +
               usuarioSession;
            window.location = page;
         } else if (tipoExportar == "exportarSeccion") {
            page =
               "php/generarPendientesExcel.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&generadoPor=" +
               usuarioSession;
            window.location = page;
         } else if (tipoExportar == "exportarSubseccion") {
            page =
               "php/generarPendientesExcel.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&generadoPor=" +
               usuarioSession;
            window.location = page;
         } else if (tipoExportar == "exportarPorResponsable") {
            page =
               "php/generarPendientesExcel.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&generadoPor=" +
               usuarioSession;
            window.location = page;
         } else if (tipoExportar == "exportarMisCreados") {
            page =
               "php/generarPendientesExcel.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&generadoPor=" +
               usuarioSession;
            window.location = page;
         } else if (tipoExportar == "exportarCreadosDe") {
            page =
               "php/generarPendientesExcel.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&generadoPor=" +
               usuarioSession;
            window.location = page;
         } else if (tipoExportar == "exportarMisCreadosPDF") {
            page =
               "php/generarPendientesPDF.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&idDestino=" +
               idDestino +
               "&idUsuario=" +
               idUsuario +
               "&idSeccion=" +
               idSeccion +
               "&usuarioSession=" +
               usuarioSession;
            window.open(
               page,
               "Reporte Fallas Y Tareas PDF",
               "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
            );
         } else if (tipoExportar == "exportarMisPendientesPDF") {
            page =
               "php/generarPendientesPDF.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&idDestino=" +
               idDestino +
               "&idUsuario=" +
               idUsuario +
               "&idSeccion=" +
               idSeccion +
               "&usuarioSession=" +
               usuarioSession;
            window.open(
               page,
               "Reporte Fallas Y Tareas PDF",
               "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
            );
         } else if (tipoExportar == "exportarCreadosPorPDF") {
            page =
               "php/generarPendientesPDF.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&idDestino=" +
               idDestino +
               "&idUsuario=" +
               idUsuario +
               "&idSeccion=" +
               idSeccion +
               "&usuarioSession=" +
               usuarioSession;
            window.open(
               page,
               "Reporte Fallas Y Tareas PDF",
               "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
            );
         } else if (tipoExportar == "exportarSubseccionPDF") {
            page =
               "php/generarPendientesPDF.php?listaIdT=" +
               data.listaIdT +
               "&listaIdF=" +
               data.listaIdF +
               "&idDestino=" +
               idDestino +
               "&idUsuario=" +
               idUsuario +
               "&idSeccion=" +
               idSeccion +
               "&usuarioSession=" +
               usuarioSession;
            window.open(
               page,
               "Reporte Fallas Y Tareas PDF",
               "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
            );
         }
      },
   });
}


// Obtiene los equipos de las subsecciones y por destino, considerando AME, como Global.
// rangoInicial y rangoFinal, ya no se necesita, solo se utilizaba para la paginación.
function obtenerEquipos(idUsuario, idDestino, idSeccion, idSubseccion, rangoInicial, rangoFinal, tipoOrdenamiento) {
   // Se agregan los filtros en las columnas de los equipos.
   document.getElementById("tipoOrdenamientoMCN")
      .setAttribute("onclick", "obtenerEquipos(" + idUsuario + "," + idDestino + "," + idSeccion + "," + idSubseccion + "," + rangoInicial + "," + rangoFinal + ',"MCN")');
   document.getElementById("tipoOrdenamientoMCF")
      .setAttribute("onclick", "obtenerEquipos(" + idUsuario + "," + idDestino + "," + idSeccion + "," + idSubseccion + "," + rangoInicial + "," + rangoFinal + ',"MCF")');

   document.getElementById("tipoOrdenamientoNombreEquipo")
      .setAttribute("onclick", "obtenerEquipos(" + idUsuario + "," + idDestino + "," + idSeccion + "," + idSubseccion + "," + rangoInicial + "," + rangoFinal + ',"nombreEquipo")');

   document.getElementById("dataEquipos").innerHTML = "";
   document.getElementById("seccionEquipos").innerHTML =
      '<i class="fas fa-spinner fa-pulse fa-2x fa-fw" ></i>';
   document.getElementById("modalEquipos").classList.add("open");

   let palabraEquipo = document.getElementById("inputPalabraEquipo").value;
   const action = "obtenerEquipos";

   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idSeccion: idSeccion,
         idSubseccion: idSubseccion,
         palabraEquipo: palabraEquipo,
         rangoInicial: rangoInicial,
         rangoFinal: rangoFinal,
         tipoOrdenamiento: tipoOrdenamiento,
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("dataEquipos").innerHTML = data.dataEquipos;
         document.getElementById("seccionEquipos").innerHTML = data.seccionEquipos;
         estiloSeccionModal("estiloSeccionEquipos", data.seccionEquipos);
         // document.getElementById("paginacionEquipos").innerHTML = data.paginacionEquipos;
         paginacionEquipos();

         // alerta para mostrar información de los Equipos obtenidos.
         if (data.totalEquipos <= 0) {
            alertaImg('Sin Equipos/Locales', '', 'info', 3000);
         }
      },
   });
}


// Función para Paginar los resultados de los Equipos Obtenidos.
function paginacionEquipos() {
   $("div.holder").jPages({
      containerID: "dataEquipos",
      perPage: 35,
      startPage: 1,
      endRange: 1,
      midRange: 1,
      previous: "anterior",
      next: "siguiente",
      animation: false,
   });
   $(".holder>a").addClass(
      "-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
   );
}


// Obtiene todos los MC-N por Equipo.
function obtenerMCN(idEquipo) {
   // Actualiza el MC seleccionado.

   localStorage.setItem("idEquipo", idEquipo);
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idSubseccion = localStorage.getItem("idSubseccion");

   document.getElementById("tipoPendientesX").innerHTML = "FALLAS PENDIENTES";
   document.getElementById("modalPendientesX").classList.add("open");
   document.getElementById("seccionMCN").innerHTML = iconoLoader;
   document.getElementById("dataPendientes").innerHTML = "";
   document.getElementById("tipoPendiente").innerHTML = "FALLA";
   document.getElementById("agregarPendiente").innerHTML = "Agregar Falla";
   // document.getElementById("btnAgregarPendiente")
   //    .setAttribute("onclick", "datosModalAgregarMC()");

   document.getElementById("btnAgregarPendiente")
      .setAttribute("onclick", "iniciarFormularioInicidencias()");

   const action = "obtenerMCN";

   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idSubseccion: idSubseccion,
         idDestino: idDestino,
         idEquipo: idEquipo,
      },
      dataType: "JSON",
      success: function (data) {
         estiloSeccionModal("estiloSeccionMCN", data.seccion);
         document.getElementById("seccionMCN").innerHTML = data.seccion;
         document.getElementById("nombreEquipoMCN").innerHTML = data.nombreEquipo;
         document.getElementById("dataPendientes").innerHTML = data.MC;
         alertaImg("Fallas Pendientes: " + data.contadorMC, "", "info", 3000);
      },
   });
}


// Función para Obtener el Status y agregar la funcion para poder actualizarlo.
function obtenerstatusMC(idMC) {
   document.getElementById("modalStatus").classList.add("open");
   localStorage.setItem("idMC", idMC);
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   const action = "obtenerStatusMC";

   // FUNCIÓN PARA DAR DISEÑO AL MODAL STATUS 
   estiloModalStatus(idMC, 'FALLA');

   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idMC: idMC,
      },
      dataType: "JSON",
      success: function (data) {

         // Status
         document.getElementById("statusUrgente")
            .setAttribute("onclick", data.dataStatusUrgente);
         document.getElementById("btnStatusMaterial")
            .setAttribute("onclick", data.dataStatusMaterial);
         document.getElementById("statusTrabajare")
            .setAttribute("onclick", data.dataStatusTrabajare);
         // Status Departamento.
         document.getElementById("statusCalidad")
            .setAttribute("onclick", data.dataStatusCalidad);
         document.getElementById("statusCompras")
            .setAttribute("onclick", data.dataStatusCompras);
         document.getElementById("statusDireccion")
            .setAttribute("onclick", data.dataStatusDireccion);
         document.getElementById("statusFinanzas")
            .setAttribute("onclick", data.dataStatusFinanzas);
         document.getElementById("statusRRHH")
            .setAttribute("onclick", data.dataStatusRRHH);
         // Status Energéticos.
         document.getElementById("statusElectricidad")
            .setAttribute("onclick", data.dataStatusElectricidad);
         document.getElementById("statusAgua")
            .setAttribute("onclick", data.dataStatusAgua);
         document.getElementById("statusDiesel")
            .setAttribute("onclick", data.dataStatusDiesel);
         document.getElementById("statusGas")
            .setAttribute("onclick", data.dataStatusGas);
         // Finalizar MC.
         document.getElementById("statusFinalizar")
            .setAttribute("onclick", data.dataStatus);
         // Activo MC.
         document.getElementById("statusActivo")
            .setAttribute("onclick", data.dataStatusActivo);
         // Titulo MC.
         document.getElementById("btnEditarTitulo")
            .setAttribute("onclick", data.dataStatusTitulo);

         // BITACORA GP, TRS, ZI
         document.getElementById("statusGP")
            .setAttribute("onclick", data.dataBitacoraGP);
         document.getElementById("statusTRS")
            .setAttribute("onclick", data.dataBitacoraTRS);
         document.getElementById("statusZI")
            .setAttribute("onclick", data.dataBitacoraZI);

      },
   });
}


// Función para actualizar Status t_mc.
function actualizarStatusMC(idMC, status, valorStatus) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let tituloMC = document.getElementById("editarTitulo").value;
   let cod2bend = document.getElementById("inputCod2bend").value;
   const action = "actualizarStatusMC";

   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idMC: idMC,
         status: status,
         valorStatus: valorStatus,
         tituloMC: tituloMC,
         cod2bend: cod2bend
      },
      // dataType: "JSON",
      success: function (data) {
         if (data == 1) {
            verEnPlanner('FALLA', idMC);
            alertaImg("Información Actualizada", "", "success", 2000);
            if (status == "activo" || status == "status") {
               llamarFuncionX("obtenerEquiposAmerica");
               obtenerDatosUsuario(idDestino);
            }
            if (valorStatus == "F") {
               obtenerFallas(idEquipo);
            } else {
               obtenerFallas(idEquipo);
               document.getElementById("modalEditarTitulo").classList.remove("open");
               document.getElementById("modalStatus").classList.remove("open");
            }
            // Cierra el Modal de Fecha MC.
            document.getElementById("modalFechaMC").classList.remove("open");
         } else {
            alertaImg("Intente de Nuevo", "", "info", 2000);
         }
      },
   });
}


// Obtiene todos los MC-F por Equipo.
function obtenerMCF(idEquipo) {
   document.getElementById("tipoSolucionadosX").innerHTML =
      "FALLAS SOLUCIONADAS";
   document.getElementById("seccionMCF").innerHTML = iconoLoader;
   document.getElementById("modalSolucionadosX").classList.add("open");
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idSubseccion = localStorage.getItem("idSubseccion");

   const action = "obtenerMCF";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idEquipo: idEquipo,
         idSubseccion: idSubseccion,
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("dataMCF").innerHTML = data.dataMCF;
         estiloSeccionModal("estiloSeccionMCF", data.seccion);
         document.getElementById("seccionMCF").innerHTML = data.seccion;
         document.getElementById("nombreEquipoMCF").innerHTML = data.nombreEquipo;
         alertaImg("Fallas Solucionadas: " + data.totalMCF, "", "info", 2000);
      },
   });
}


function datosModalAgregarMC() {
   document.getElementById("responsableMC").innerHTML = "";
   document.getElementById("modalAgregarMC").classList.add("open");
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");

   const action = "obtenerDatosAgregarMC";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idEquipo: idEquipo,
      },
      dataType: "JSON",
      success: function (data) {
         let idUltimoMC = parseInt(data.idUltimoMC) + 1;
         document
            .getElementById("btnAgregarMC")
            .setAttribute("onclick", "agregarMC(" + idUltimoMC + ");");
         document.getElementById("responsableMC").innerHTML = data.dataUsuarios;
         document.getElementById("nombreEquipoMC").innerHTML = data.nombreEquipo;
      },
   });
}


function agregarMC(idMC) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let idSeccion = localStorage.getItem("idSeccion");
   let idSubseccion = localStorage.getItem("idSubseccion");
   let actividadMC = document.getElementById("inputActividadMC").value;
   let rangoFechaMC = document.getElementById("inputRangoFechaMC").value;
   let responsableMC = document.getElementById("responsableMC").value;
   let comentarioMC = document.getElementById("comentarioMC").value;

   if (actividadMC != "" && actividadMC.length <= 65 && rangoFechaMC != "" && responsableMC != "") {
      const action = "agregarMC";
      $.ajax({
         type: "POST",
         url: "php/plannerCrudPHP.php",
         data: {
            action: action,
            idMC: idMC,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion,
            actividadMC: actividadMC,
            rangoFechaMC: rangoFechaMC,
            responsableMC: responsableMC,
         },
         // dataType: "JSON",
         success: function (data) {
            document.getElementById("inputComentario").value = comentarioMC;
            if (data >= 1) {
               agregarComentarioMC(idMC);
               alertaImg("FALLA AGREGADA", "", "success", 1500);
               obtenerDatosUsuario(idDestino);
               obtenerFallas(idEquipo);
               llamarFuncionX("obtenerEquiposAmerica");
               datosModalAgregarMC();
               document.getElementById("inputActividadMC").value = "";
               document.getElementById("comentarioMC").value = "";
               setTimeout(function () {
                  document.getElementById("modalAgregarMC").classList.remove("open");
                  document
                     .getElementById("modalComentarios")
                     .classList.remove("open");
               }, 1200);
            } else {
               alertaImg("Intente de Nuevo", "", "question", 1500);
               datosModalAgregarMC();
            }
         },
      });
   } else {
      alertaImg("Información No Valida", "", "question", 2000);
   }
}


// Obtener usuario recibe 2 parametros especificos, donde tipoAsignación se refiere a la tabla donde se va a utilizar el usuario y idItem es el identificador del registro que se le va asignar.
function obtenerUsuarios(tipoAsginacion, idItem) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let palabraUsuario = document.getElementById("palabraUsuario").value;

   document.getElementById("modalUsuarios").classList.add("open");
   document.getElementById("dataUsuarios").innerHTML = iconoLoader;

   const action = "obtenerUsuarios";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         palabraUsuario: palabraUsuario,
         tipoAsginacion: tipoAsginacion,
         idItem: idItem,
      },
      dataType: "JSON",
      success: function (data) {
         // alertaImg("Usuarios Obtenidos: " + data.totalUsuarios, "", "info", 2000);
         document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
         document.getElementById("palabraUsuario").setAttribute("onkeydown", 'obtenerUsuarios("' + tipoAsginacion + '",' + idItem + ")"
         );
      },
   });
}


// Función para Asignar usuario.
function asignarUsuario(idUsuarioSeleccionado, tipoAsignacion, idItem) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let modalUsuarios = document.getElementById("modalUsuarios");

   const action = "asignarUsuario";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idUsuarioSeleccionado: idUsuarioSeleccionado,
         idDestino: idDestino,
         tipoAsignacion: tipoAsignacion,
         idItem: idItem,
      },
      dataType: "JSON",
      success: function (data) {
         if (data == "MC") {
            // FALLAS
            alertaImg("Responsable Actualizado", "", "success", 1500);
            modalUsuarios.classList.remove("open");
            let idEquipo = localStorage.getItem("idEquipo");
            obtenerFallas(idEquipo);
            verEnPlanner('FALLA', idItem);

         } else if (data == "TAREA") {
            // TAREAS
            alertaImg("Responsable Actualizado", "", "success", 1500);
            modalUsuarios.classList.remove("open");
            let idEquipo = localStorage.getItem("idEquipo");
            obtenerTareas(idEquipo);
            verEnPlanner('TAREA', idItem);

         } else if (data == "TEST") {
            // TEST
            alertaImg("Responsable Actualizado", "", "success", 1500);
            modalUsuarios.classList.remove("open");
            obtenerTestEquipo(idEquipo);
         } else {
            alertaImg("Intenete de Nuevo", "", "question", 1500);
         }
      }
   });
}


// Agregar Fecha MC.
function obtenerFechaMC(idMC, rangoFecha) {
   document.getElementById("modalFechaMC").classList.add("open");
   document.getElementById("fechaMC").value = rangoFecha;
   localStorage.setItem("idMC", idMC);
}


// Funcion para Obtener Adjuntos.
function obtenerAdjuntosMC(idMC) {
   // Actualiza el MC seleccionado.
   localStorage.setItem("idMC", idMC);

   // Recupera datos.
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");

   document.getElementById("dataImagenes").innerHTML = iconoLoader;
   document.getElementById("dataAdjuntos").classList.add("justify-center");

   document.getElementById("dataAdjuntos").innerHTML = iconoLoader;
   document.getElementById("dataImagenes").classList.add("justify-center");
   document.getElementById("modalMedia").classList.add("open");
   document.getElementById("contenedorImagenes").classList.add('hidden');
   document.getElementById("contenedorDocumentos").classList.add('hidden');

   document.getElementById("inputAdjuntos").
      setAttribute("onchange", "subirImagenGeneral(" + idMC + ',"t_mc_adjuntos")');

   const action = "obtenerAdjuntosMC";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idMC: idMC
      },
      dataType: "JSON",
      success: function (data) {

         if (data.imagen != "") {
            document.getElementById("dataImagenes").innerHTML = data.imagen;
            document.getElementById("contenedorImagenes").classList.remove('hidden');
            document.getElementById("dataImagenes").classList.remove("justify-center");
         }

         if (data.documento != "") {
            document.getElementById("dataAdjuntos").innerHTML = data.documento;
            document.getElementById("contenedorDocumentos").classList.remove('hidden');
            document.getElementById("dataAdjuntos").classList.remove("justify-center");
         }

      },
   });
}


// Funcion para Obtener Comentarios MC.
function obtenerComentariosMC(idMC) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   document.getElementById("modalComentarios").classList.add("open");

   const action = "obtenerComentariosMC";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idMC: idMC,
      },
      dataType: "JSON",
      success: function (data) {
         document
            .getElementById("btnComentario")
            .setAttribute("onclick", "agregarComentarioMC(" + idMC + ")");
         document
            .getElementById("inputComentario")
            .setAttribute(
               "onkeyup",
               "if(event.keyCode == 13)agregarComentarioMC(" + idMC + ")"
            );
         if (data.dataComentarios != undefined && data.dataComentarios != '') {
            document.getElementById("dataComentarios").innerHTML =
               data.dataComentarios;
         } else {
            document.getElementById("dataComentarios").innerHTML = '<h1 class="text-center w-full text-gray-600 font-medium">SIN COMENTARIOS</h1>';
         }
      },
   });
}

// Agregar Comentario MC.
function agregarComentarioMC(idMC) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let comentarioMC = document.getElementById("inputComentario").value;
   const action = "agregarComentarioMC";
   if (comentarioMC.length > 0) {
      $.ajax({
         type: "POST",
         url: "php/plannerCrudPHP.php",
         data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idMC: idMC,
            comentarioMC: comentarioMC,
         },
         // dataType: "JSON",
         success: function (data) {
            if (data == 1) {
               obtenerComentariosMC(idMC);
               obtenerFallas(idEquipo);
               document.getElementById("inputComentario").value = "";
               alertaImg("Comentario Agregado", "", "success", 2000);
            } else {
               alertaImg("Intente de Nuevo", "", "question", 2000);
            }
         },
      });
   } else {
      alertaImg("Comentario Vacio", "", "info", 2000);
   }
}


// Se obtienen las Tareas Pendientes.
function obtenerTareasP(idEquipo) {
   document.getElementById("tipoPendientesX").innerHTML = "TAREAS PENDIENTES";
   localStorage.setItem("idEquipo", idEquipo);
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem("idSubseccion");

   document.getElementById("modalPendientesX").classList.add("open");
   document.getElementById("seccionMCN").innerHTML = iconoLoader;
   document.getElementById("dataPendientes").innerHTML = "";
   document.getElementById("tipoPendiente").innerHTML = "TAREAS";
   document.getElementById("agregarPendiente").innerHTML = "Agregar Tarea";
   document.getElementById("btnAgregarPendiente").setAttribute("onclick", "datosAgregarTarea()");
   document.getElementById("btnAgregarMC").setAttribute("onclick", "agregarTarea()");
   const action = "obtenerTareasP";

   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idSeccion: idSeccion,
         idSubseccion: idSubseccion,
         idDestino: idDestino,
         idEquipo: idEquipo,
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("seccionMCN").innerHTML = data.seccion;
         document.getElementById("nombreEquipoMCN").innerHTML = data.nombreEquipo;
         document.getElementById("dataPendientes").innerHTML = data.dataTareas;
         alertaImg("Tareas Pendientes: " + data.contadorTareas, "", "info", 3000);
         estiloSeccionModal("estiloSeccionMCN", data.seccion);
      },
   });
}


//Se obtienen las Tareas Finaizadas.
function obtenerTareasS(idEquipo) {
   document.getElementById("tipoSolucionadosX").innerHTML =
      "FALLAS SOLUCIONADAS";
   document.getElementById("seccionMCF").innerHTML = iconoLoader;
   document.getElementById("modalSolucionadosX").classList.add("open");
   document.getElementById("tipoPendiente").value = "TAREAS";

   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idSubseccion = localStorage.getItem("idSubseccion");

   const action = "obtenerTareasS";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idEquipo: idEquipo,
         idSubseccion: idSubseccion,
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("dataMCF").innerHTML = data.dataTareas;
         estiloSeccionModal("estiloSeccionMCF", data.seccion);
         document.getElementById("seccionMCF").innerHTML = data.seccion;
         document.getElementById("nombreEquipoMCF").innerHTML = data.nombreEquipo;
         alertaImg(
            "Tareas Solucionadas: " + data.contadorTareas,
            "",
            "info",
            2000
         );
      },
   });
}


// Obtener Media para las TAREAS.
function obtenerAdjuntosTareas(idTarea) {
   // Actualiza id TAREA seleccionado.
   localStorage.setItem("idTarea", idTarea);

   // Recupera datos.
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   document.getElementById("dataImagenes").innerHTML = iconoLoader;
   document.getElementById("dataAdjuntos").classList.add("justify-center");

   document.getElementById("dataAdjuntos").innerHTML = iconoLoader;
   document.getElementById("dataImagenes").classList.add("justify-center");
   document.getElementById("modalMedia").classList.add("open");
   document.getElementById("contenedorImagenes").classList.add('hidden');
   document.getElementById("contenedorDocumentos").classList.add('hidden');

   document.getElementById("inputAdjuntos").
      setAttribute("onchange", "subirImagenGeneral(" + idTarea + ',"adjuntos_mp_np")');

   const action = "obtenerAdjuntosTareas";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idTarea: idTarea,
      },
      dataType: "JSON",
      success: function (data) {

         if (data.dataImagenes != "") {
            document.getElementById("dataImagenes").innerHTML = data.dataImagenes;
            document.getElementById("dataImagenes").classList.remove("justify-center");
            document.getElementById("contenedorImagenes").classList.remove('hidden');
         }

         if (data.dataAdjuntos != "") {
            document.getElementById("dataAdjuntos").innerHTML = data.dataAdjuntos;
            document.getElementById("dataAdjuntos").classList.remove("justify-center");
            document.getElementById("contenedorDocumentos").classList.remove('hidden');
         }
      },
   });
}


// Funcion para Obtener Comentarios TAREAS
function obtenerComentariosTareas(idTarea) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   document.getElementById("modalComentarios").classList.add("open");
   document.getElementById("dataComentarios").innerHTML = iconoLoader;

   const action = "obtenerComentariosTareas";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idTarea: idTarea,
      },
      dataType: "JSON",
      success: function (data) {
         document
            .getElementById("btnComentario")
            .setAttribute("onclick", "agregarComentarioTarea(" + idTarea + ")");
         document
            .getElementById("inputComentario")
            .setAttribute(
               "onkeyup",
               "if(event.keyCode == 13)agregarComentarioTarea(" + idTarea + ")"
            );
         document.getElementById("dataComentarios").innerHTML =
            data.dataComentarios;
      },
   });
}


// Agregar Comentario TAREA.
function agregarComentarioTarea(idTarea) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let comentarioTarea = document.getElementById("inputComentario").value;
   const action = "agregarComentarioTarea";
   if (comentarioTarea.length > 0) {
      $.ajax({
         type: "POST",
         url: "php/plannerCrudPHP.php",
         data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idTarea: idTarea,
            comentarioTarea: comentarioTarea,
         },
         // dataType: "JSON",
         success: function (data) {
            if (data == 1) {
               obtenerComentariosTareas(idTarea);
               obtenerTareas(idEquipo);
               document.getElementById("inputComentario").value = "";
               alertaImg("Comentario Agregado", "", "success", 2000);
            } else {
               alertaImg("Intente de Nuevo", "", "question", 2000);
            }
         },
      });
   } else {
      alertaImg("Comentario Vacio", "", "info", 2000);
   }
}


// Modifica Status o alguna Columna(titulo, activo, status) en TAREAS
function obtenerInformacionTareas(idTarea, tituloTarea) {

   estiloModalStatus(idTarea, 'TAREA');
   document.getElementById("modalStatus").classList.add("open");
   localStorage.setItem("idTarea", idTarea);

   // La función actulizarTarea(?, ?, ?), recibe 3 parametros idTarea, columna a modificar y el tercer parametro solo funciona para el titulo por ahora

   // Status
   document.getElementById("statusUrgente")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "status_urgente", 0)'
      );
   document.getElementById("btnStatusMaterial")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "status_material", 0)'
      );
   document.getElementById("statusTrabajare")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "status_trabajando", 0)'
      );

   // Status Departamento.
   document.getElementById("statusCalidad")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "departamento_calidad", 0)'
      );
   document.getElementById("statusCompras")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "departamento_compras", 0)'
      );
   document.getElementById("statusDireccion")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "departamento_direccion", 0)'
      );
   document.getElementById("statusFinanzas")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "departamento_finanzas", 0)'
      );
   document.getElementById("statusRRHH")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "departamento_rrhh", 0)'
      );

   // Status Energéticos.
   document.getElementById("statusElectricidad")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "energetico_electricidad", 0)'
      );
   document.getElementById("statusAgua")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "energetico_agua", 0)'
      );
   document.getElementById("statusDiesel")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "energetico_diesel", 0)'
      );
   document.getElementById("statusGas")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "energetico_gas", 0)'
      );

   // Finalizar TAREA
   document.getElementById("statusFinalizar")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "status", "F")');
   // Activo TAREA
   document.getElementById("statusActivo")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "activo", 0)');
   // Titulo TAREA
   document.getElementById("btnEditarTitulo")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "titulo", 0)');

   // Bitacora GP
   document.getElementById("statusGP")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "bitacora_gp", 0)');
   // Bitacora TRS
   document.getElementById("statusTRS")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "bitacora_trs", 0)');
   // Bitacora ZI
   document.getElementById("statusZI")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "bitacora_zi", 0)');
}


// Actualiza Datos de las Tareas
function actualizarTareas(idTarea, columna, valor) {
   let tituloNuevo = document.getElementById("editarTitulo").value;
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let cod2bend = document.getElementById("inputCod2bend").value;
   const action = "actualizarTareas";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idTarea: idTarea,
         columna: columna,
         valor: valor,
         tituloNuevo: tituloNuevo,
         cod2bend: cod2bend
      },
      // dataType: "JSON",
      success: function (data) {
         verEnPlanner('TAREA', idTarea);
         if (data == 1) {
            obtenerTareas(idEquipo);
            alertaImg("Status Actualizado", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 2) {
            obtenerDatosUsuario(idDestino);
            llamarFuncionX("obtenerEquiposAmerica");
            obtenerTareas(idEquipo);
            alertaImg("Tarea SOLUCIONADA", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 3) {
            obtenerDatosUsuario(idDestino);
            obtenerTareas(idEquipo);
            llamarFuncionX("obtenerEquiposAmerica");
            alertaImg("Tarea Recuperada como PENDIENTE", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 4) {
            obtenerTareas(idEquipo);
            obtenerDatosUsuario(idDestino);
            llamarFuncionX("obtenerEquiposAmerica");
            alertaImg("Tarea Eliminada", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 5) {
            obtenerTareas(idEquipo);
            alertaImg("Título Actualizado", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 6) {
            obtenerTareas(idEquipo);
            alertaImg("Rango de Fecha, Actualizada", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 7) {
            obtenerTareas(idEquipo);
            alertaImg("Status Actualizado", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 8) {
            obtenerTareas(idEquipo);
            alertaImg("Status Actualizado", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else {
            alertaImg("Intente de Nuevo", "", "question", 2000);
         }
      },
   });
}


// Agregar Fecha MC.
function obtenerFechaTareas(idTarea, rangoFecha) {
   document.getElementById("modalFechaTareas").classList.add("open");
   document.getElementById("fechaTareas").value = rangoFecha;
   localStorage.setItem("idTarea", idTarea);
}


// Opciones Responsable para Agregar Tarea.
function datosAgregarTarea() {
   document.getElementById("responsableMC").innerHTML = "";
   document.getElementById("modalAgregarMC").classList.add("open");
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");

   const action = "obtenerDatosAgregarMC";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idEquipo: idEquipo,
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("responsableMC").innerHTML = data.dataUsuarios;
         document.getElementById("nombreEquipoMC").innerHTML = data.nombreEquipo;
      },
   });
}


// Agregar TAREA
function agregarTarea() {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let idSeccion = localStorage.getItem("idSeccion");
   let idSubseccion = localStorage.getItem("idSubseccion");
   let titulo = document.getElementById("inputActividadMC").value;
   let rangoFecha = document.getElementById("inputRangoFechaMC").value;
   let responsable = document.getElementById("responsableMC").value;
   let comentario = document.getElementById("comentarioMC").value;

   if (titulo != "" && rangoFecha != "" && responsable != "") {
      const action = "agregarTarea";
      $.ajax({
         type: "POST",
         url: "php/plannerCrudPHP.php",
         data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo,
            idSeccion: idSeccion,
            idSubseccion: idSubseccion,
            titulo: titulo,
            rangoFecha: rangoFecha,
            responsable: responsable,
            comentario: comentario,
         },
         // dataType: "JSON",
         success: function (data) {
            if (data == 1) {
               obtenerDatosUsuario(idDestino);
               llamarFuncionX("obtenerEquiposAmerica");
               obtenerTareas(idEquipo);
               document.getElementById("inputActividadMC").value = "";
               document.getElementById("modalAgregarMC").classList.remove("open");
               alertaImg("Tarea Agregada", "", "success", 1500);
            } else if (data == 2) {
               obtenerDatosUsuario(idDestino);
               llamarFuncionX("obtenerEquiposAmerica");
               obtenerTareas(idEquipo);
               document.getElementById("inputActividadMC").value = "";
               document.getElementById("modalAgregarMC").classList.remove("open");
               document.getElementById("comentarioMC").value = "";
               alertaImg("Tarea Agregada", "", "success", 1500);
               alertaImg("Comentario, Agregado", "", "success", 1500);
            } else {
               alertaImg("Intente de Nuevo", "", "question", 1500);
            }
         },
      });
   } else {
      alertaImg("Información No Valida", "", "question", 2000);
   }
}


// Obtiene MEDIA de EQUIPOS (ADJUNTOS: IMAGENES Y DOCUMENTOS)
function obtenerMediaEquipo(idEquipo) {
   document.getElementById("modalMedia").classList.add("open");
   document.getElementById("inputAdjuntos").
      setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_america_adjuntos")');
   document.getElementById("contenedorImagenes").classList.add('hidden');
   document.getElementById("contenedorDocumentos").classList.add('hidden');

   let idTabla = idEquipo;
   let tabla = "t_equipos_america_adjuntos";

   const action = "obtenerAdjuntos";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idTabla: idTabla,
         tabla: tabla,
      },
      dataType: "JSON",
      success: function (data) {

         if (data.imagen != "") {
            document.getElementById("dataImagenes").innerHTML = data.imagen;
            document.getElementById("contenedorImagenes").classList.remove('hidden');
         }

         if (data.documento != "") {
            document.getElementById("dataAdjuntos").innerHTML = data.documento;
            document.getElementById("contenedorDocumentos").classList.remove('hidden');
         }

      },
   });
}

// Obtiene MEDIA de EQUIPOS (ADJUNTOS: IMAGENES Y DOCUMENTOS)
function obtenerCotizacionesEquipo(idEquipo) {
   document.getElementById("modalMedia").classList.add("open");
   document.getElementById("inputAdjuntos").
      setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_cotizaciones")');
   document.getElementById("contenedorImagenes").classList.add('hidden');
   document.getElementById("contenedorDocumentos").classList.add('hidden');

   let idTabla = idEquipo;
   let tabla = "t_equipos_cotizaciones";

   const action = "obtenerAdjuntos";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idTabla: idTabla,
         tabla: tabla
      },
      dataType: "JSON",
      success: function (data) {

         if (data.imagen != "") {
            document.getElementById("dataImagenes").innerHTML = data.imagen;
            document.getElementById("contenedorImagenes").classList.remove('hidden');
         }

         if (data.documento != "") {
            document.getElementById("dataAdjuntos").innerHTML = data.documento;
            document.getElementById("contenedorDocumentos").classList.remove('hidden');
         }

      },
   });
}


function agregarComentarioEquipo(idEquipo) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');
   let comentario = document.getElementById("inputComentario").value;

   const action = "agregarComentarioEquipo";
   if (comentario.length > 1) {

      $.ajax({
         type: 'POST',
         url: 'php/plannerCrudPHP.php',
         data: {
            action: action,
            comentario: comentario,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo
         },
         // dataType: 'JSON',
         success: function (data) {
            if (data == 1) {
               obtenerComentariosEquipos(idEquipo);
               alertaImg('Comentario Agregado', '', 'success', 1500);
               document.getElementById("inputComentario").value = '';
               obtenerEquiposAmerica(idSeccion, idSubseccion);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
            }
            document.getElementById("dataComentarios").innerHTML = '';
         }
      })
   } else {
      alertaImg('Intente de Nuevo', '', 'info', 1500);
   }
}


function obtenerComentariosEquipos(idEquipo) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');

   document.getElementById("btnComentario").
      setAttribute('onclick', `agregarComentarioEquipo(${idEquipo})`);

   const action = "obtenerComentariosEquipos";
   $.ajax({
      type: 'POST',
      url: 'php/plannerCrudPHP.php',
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idEquipo: idEquipo
      },
      dataType: 'JSON',
      success: function (array) {
         document.getElementById("dataComentarios").innerHTML = '';
         if (array.length > 0) {
            for (let x = 0; x < array.length; x++) {
               const idComentario = array[x].idComentario;
               const comentario = array[x].comentario;
               const nombre = array[x].nombre;
               const fecha = array[x].fecha;
               const tipo = array[x].tipo;

               var estiloTipo =
                  tipo == "EMERGENCIA" ? 'border border-red-500 text-red-500' :
                     tipo == "URGENCIA" ? 'border border-orange-500 text-orange-500' :
                        tipo == "ALARMA" ? 'border border-yellow-500 text-yellow-500' :
                           tipo == "ALERTA" ? 'border border-blue-500 text-blue-500' :
                              tipo == "SEGUIMIENTO" ? 'border border-teal-500 text-teal-500' :
                                 'border border-black text-balck';

               const dataX = `
                  <div class=\"flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer\">
                     <div class=\"flex items-center justify-center\" style=\"width: 48px;\">
                           <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}\" width=\"48\" height=\"48\" alt=\"\">
                     </div>
                     <div class=\"flex flex-col justify-start items-start p-2 w-full\">
                           <div class=\"text-xs font-bold flex flex-row justify-between w-full\">
                              <div>
                                 <h1>${nombre}</h1>
                              </div>
                              <div>
                                 <p class=\"font-mono ml-2 text-gray-600\">${fecha}</p>
                                 <p class=\"font-mono text-center p-0 ${estiloTipo}\">${tipo}</p>
                              </div>
                           </div>
                           <div class=\"text-xs w-full\">
                              <p>${comentario}</p>
                           </div>
                     </div>
                  </div>        
               `;

               document.getElementById("dataComentarios").insertAdjacentHTML('beforeend', dataX);
            }
         }
      }
   })
}

// ---------- PROYECTOS ----------

// Expande las actividades de los proyectos y Cambia el icono
function expandirProyectos(id, idProyecto) {
   document.getElementById(id + "toggle").classList.toggle("hidden");

   if (
      document.getElementById("icono" + idProyecto).classList[1] ==
      "fa-chevron-down"
   ) {
      document
         .getElementById("icono" + idProyecto)
         .classList.remove("fa-chevron-down");
      document
         .getElementById("icono" + idProyecto)
         .classList.add("fa-chevron-right");
   } else {
      document
         .getElementById("icono" + idProyecto)
         .classList.add("fa-chevron-down");
      document
         .getElementById("icono" + idProyecto)
         .classList.remove("fa-chevron-right");
   }
}


// Sube imagenes con dos parametros, con el formulario #inputAdjuntos
function subirImagenGeneral(idTabla, tabla) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let img = document.getElementById("inputAdjuntos").files;
   let idProyecto = localStorage.getItem('idProyecto');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem("idSubseccion");
   let idEquipo = localStorage.getItem('idEquipo');
   for (let index = 0; index < img.length; index++) {
      let imgData = new FormData();
      const action = "subirImagenGeneral";
      document.getElementById("cargandoAdjunto").innerHTML = iconoLoader;

      imgData.append("adjuntoUrl", img[index]);
      imgData.append("action", action);
      imgData.append("idUsuario", idUsuario);
      imgData.append("idDestino", idDestino);
      imgData.append("tabla", tabla);
      imgData.append("idTabla", idTabla);

      $.ajax({
         data: imgData,
         type: "POST",
         url: "php/plannerCrudPHP.php",
         contentType: false,
         processData: false,
         success: function (data) {
            document.getElementById("cargandoAdjunto").innerHTML = "";
            document.getElementById("inputAdjuntos").value = "";
            if (data == -1) {
               alertaImg("Archivo NO Permitido", "", "warning", 2500);
            } else if (data == 1) {
               alertaImg("Proceso Cancelado", "", "info", 3000);
            } else if (data == 2) {
               alertaImg("Archivo Pesado (MAX:99MB)", "", "info", 3000);
               // Sube y Actualiza la Vista para las Cotizaciones de Proyectos.
            } else if (data == 3) {
               alertaImg("Cotización Agregada", "", "success", 2500);
               obtenerProyectos(idSeccion, 'PENDIENTE');
               cotizacionesProyectos(idTabla);
               // Sube y Actualiza la Vista para los Adjuntos de Planaccion.
            } else if (data == 4) {
               alertaImg("Adjunto Agregado", "", "success", 2500);
               obtenerPlanaccion(idProyecto);
               verEnPlanner('PLANACCION', idTabla);
               adjuntosPlanaccion(idTabla);
            } else if (data == 5) {
               alertaImg("Adjunto Agregado", "", "success", 2500);
               obtenerMediaEquipo(idTabla);
               obtenerEquiposAmerica(idSeccion, idSubseccion);
               obtenerImagenesEquipo(idTabla);
            } else if (data == 7) {
               obtenerAdjuntosTareas(idTabla);
               obtenerTareas(idEquipo);
               verEnPlanner('TAREA', idTabla);
               alertaImg("Adjunto Agregado", "", "success", 2500);
            } else if (data == 8) {
               obtenerAdjuntosMC(idTabla);
               obtenerFallas(idEquipo);
               verEnPlanner('FALLA', idTabla);
               alertaImg("Adjunto Agregado", "", "success", 2500);
            } else if (data == 9) {
               obtenerImagenesEquipo(idTabla);
               alertaImg("Adjunto Agregado", "", "success", 2500);
            } else if (data == 10) {
               consultaAdjuntosOT(idTabla);
               alertaImg("Adjunto Agregado", "", "success", 2500);
            } else if (data == 11) {
               alertaImg("Cotización Agregada", "", "success", 2500);
               obtenerCotizacionesEquipo(idTabla);
               obtenerEquiposAmerica(idSeccion, idSubseccion);
            } else if (data == 12) {
               obtenerProyectosDEP(idSubseccion, 'PENDIENTE');
               cotizacionesProyectosDEP(idTabla);
            } else if (data == 13) {
               obtenerPlanaccionDEP(idProyecto);
               adjuntosPlanaccionDEP(idTabla)
            } else {
               alertaImg("Intente de Nuevo", "", "info", 3000);
            }
         },
      });
   }
}


// Funcion para buscar pendiente Ver en Planner
function verEnPlanner(tipoPendiente, idPendiente) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   const action = "verEnPlanner";
   document.getElementById("dataStatusVP").
      setAttribute('onclick', `verEnPlanner('${tipoPendiente}', ${idPendiente});`);

   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         tipoPendiente: tipoPendiente,
         idPendiente: idPendiente
      },
      dataType: "JSON",
      success: function (data) {
         if (data != "") {
            document.getElementById("tipoPendienteVP").innerHTML = tipoPendiente + ': ' + data.idPendiente;
            document.getElementById("descripcionPendienteVP").innerHTML = data.actividad;
            document.getElementById("creadoPorVP").innerHTML = data.creadoPor;
            document.getElementById("dataResponsablesVP").innerHTML = data.responsable;
            document.getElementById("dataStatusVP").innerHTML = data.status;
            document.getElementById("dataComentariosVP").innerHTML = data.dataComentariosVP;
            document.getElementById("dataAdjuntosVP").innerHTML = data.adjuntos;

            if (tipoPendiente == "FALLA") {

               // FECHA
               document.getElementById("fechaVP").
                  setAttribute('onclick', 'obtenerFechaMC(' + idPendiente + ', "' + data.fecha + '")');
               document.getElementById("fechaVP").innerHTML = data.fecha;
               document.getElementById("fechaTareas").value = data.fecha;


               // RESPONSABLE
               document.getElementById("responsableVP").
                  setAttribute('onclick', 'obtenerUsuarios("asignarMC",' + idPendiente + ')');


               // ADJUNTOS
               document.getElementById("adjuntosVP").
                  setAttribute('onclick', 'obtenerAdjuntosMC(' + idPendiente + ')');

               // COMENTARIOS
               document.getElementById("btnComentarioVP").
                  setAttribute('onclick', 'agregarComentarioVP("' + tipoPendiente + '", ' + idPendiente + ')');

            } else if (tipoPendiente == "TAREA") {

               // FECHA
               document.getElementById("fechaVP").
                  setAttribute('onclick', 'obtenerFechaTareas(' + idPendiente + ', "' + data.fecha + '")');

               // RESPONSABLE
               document.getElementById("responsableVP").
                  setAttribute('onclick', 'obtenerUsuarios("asignarTarea",' + idPendiente + ')');

               // FECHA
               document.getElementById("fechaVP").innerHTML = data.fecha;
               document.getElementById("fechaTareas").value = data.fecha;

               // ADJUNTOS
               document.getElementById("adjuntosVP").
                  setAttribute('onclick', 'obtenerAdjuntosTareas(' + idPendiente + ')');

               // COMENTARIOS
               document.getElementById("btnComentarioVP").
                  setAttribute('onclick', 'agregarComentarioVP("' + tipoPendiente + '", ' + idPendiente + ')');
            } else if (tipoPendiente == "PLANACCION") {
               // FECHA
               document.getElementById("fechaVP").innerHTML = data.fecha;
               document.getElementById("rangoFechaX").value = data.fecha;

               document.getElementById("fechaVP").
                  setAttribute('onclick', "abrirmodal('modalRangoFechaX')");

               document.getElementById("btnAplicarRangoFecha").
                  setAttribute('onclick', `actualizarPlanaccion(1, 'rango_fecha', ${idPendiente});`);

               // RESPONSABLE
               document.getElementById("responsableVP").
                  setAttribute('onclick', 'obtenerResponsablesPlanaccion(' + idPendiente + ')');

               // ADJUNTOS
               document.getElementById("adjuntosVP").
                  setAttribute('onclick', 'adjuntosPlanaccion(' + idPendiente + ')');

               // COMENTARIOS
               document.getElementById("btnComentarioVP").
                  setAttribute('onclick', 'agregarComentarioPlanaccionVerEnPlanner(' + idPendiente + ')');

            }
         } else {
            document.getElementById("modalVerEnPlanner").classList.remove('open');
         }
      }
   });
}


// AGREGAR COMENTARIO PLANACCION VER EN PLANNER
// AGREGAR COMENTARIO PLAN DE ACCIÓN
function agregarComentarioPlanaccionVerEnPlanner(idPlanaccion) {
   let comentario = document.getElementById("comentarioVP").value;
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   const action = "agregarComentarioPlanaccion";
   if (comentario.length > 0) {
      $.ajax({
         type: "POST",
         url: "php/plannerCrudPHP.php",
         data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idPlanaccion: idPlanaccion,
            comentario: comentario,
         },
         // dataType: "JSON",
         success: function (data) {
            if (data == 1) {
               verEnPlanner('PLANACCION', idPlanaccion);
               document.getElementById("comentarioVP").value = "";
               alertaImg("Comentario Agregado", "", "success", 2500);
            } else {
               alertaImg("Intente de Nuevo", "", "info", 2500);
            }
         },
      });
   } else {
      alertaImg("Comentario NO Valido", "", "info", 2500);
   }
}


// Comentaio Ver en Planner
function agregarComentarioVP(tipoPendiente, idPendiente) {
   let comentario = document.getElementById("comentarioVP").value;
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   const action = "comentarioVP";

   if (comentario.length > 0) {
      $.ajax({
         type: "POST",
         url: "php/plannerCrudPHP.php",
         data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idPendiente: idPendiente,
            comentario: comentario,
            tipoPendiente: tipoPendiente
         },
         // dataType: "JSON",
         success: function (data) {

            if (data == 1) {
               verEnPlanner(tipoPendiente, idPendiente);
               alertaImg("Comentario Agregado", "", "success", 2000);
               document.getElementById("comentarioVP").value = "";
            } else {
               alertaImg("Intente de Nuevo", "", "question", 2000);
            }

         },
      });

   } else {
      alertaImg("Comentario Vacio", "", "info", 2000);
   }
}


/* ********** PLANES PREVENTIVOS DE EQUIPOS */

// Función para activar o desactivar Inputs de información de los equipos
function toggleInputsEquipo(estadoInputs) {
   let idEquipo = localStorage.getItem('idEquipo');
   const arrayBtnEquipo =
      [
         'nombreEquipo', 'seccionEquipo', 'subseccionEquipo', 'tipoEquipo', 'jerarquiaEquipo', 'marcaEquipo', 'modeloEquipo', 'serieEquipo', 'codigoFabricanteEquipo', 'codigoInternoComprasEquipo', 'largoEquipo', 'anchoEquipo', 'altoEquipo', 'potenciaElectricaHPEquipo', 'potenciaElectricaKWEquipo', 'voltajeEquipo', 'frecuenciaEquipo', 'caudalAguaM3HEquipo', 'caudalAguaGPHEquipo', 'cargaMCAEquipo', 'PotenciaEnergeticaFrioKWEquipo', 'potenciaEnergeticaFrioTREquipo', 'potenciaEnergeticaCalorKCALEquipo', 'caudalAireM3HEquipo', 'caudalAireCFMEquipo', 'estadoEquipo', 'idFaseEquipo', 'tipoLocalEquipo', 'contenedorDataOpcionesEquipos'
      ]

   arrayBtnEquipo.forEach(element => {
      if (estadoInputs == 1) {
         document.getElementById(element).removeAttribute('disabled');
      } else {
         document.getElementById(element).setAttribute('disabled', false);
      }
   });

   if (estadoInputs == 1) {
      alertaImg('Editar Equipo, Habilitado', '', 'info', 1500);
      document.getElementById("btnEditarEquipo").classList.remove('hidden');
      document.getElementById("btnEditarEquipo").setAttribute('onclick', 'toggleInputsEquipo(1)');

      document.getElementById("btnGuardarEquipo").classList.remove('hidden');
      document.getElementById("btnGuardarEquipo").setAttribute('onclick', 'actualizarEquipo(' + idEquipo + ')');

      document.getElementById("btnCancelarEquipo").classList.remove('hidden');
      document.getElementById("btnCancelarEquipo").setAttribute('onclick', 'toggleInputsEquipo(2)');
   } else if (estadoInputs == 0) {
      document.getElementById("btnEditarEquipo").classList.remove('hidden');
      document.getElementById("btnEditarEquipo").setAttribute('onclick', 'toggleInputsEquipo(1)');

      document.getElementById("btnGuardarEquipo").classList.add('hidden');
      document.getElementById("btnGuardarEquipo").setAttribute('onclick', 'actualizarEquipo(' + idEquipo + ')');

      document.getElementById("btnCancelarEquipo").classList.add('hidden');
      document.getElementById("btnCancelarEquipo").setAttribute('onclick', 'toggleInputsEquipo(2)');
   } else {
      let idEquipo = localStorage.getItem('idEquipo');
      informacionEquipo(idEquipo)
      alertaImg('Editar Equipo, Cancelado', '', 'error', 500);
      document.getElementById("btnEditarEquipo").classList.remove('hidden');
      document.getElementById("btnEditarEquipo").setAttribute('onclick', 'toggleInputsEquipo(1)');

      document.getElementById("btnGuardarEquipo").classList.add('hidden');
      document.getElementById("btnGuardarEquipo").setAttribute('onclick', 'actualizarEquipo(' + idEquipo + ')');

      document.getElementById("btnCancelarEquipo").classList.add('hidden');
      document.getElementById("btnCancelarEquipo").setAttribute('onclick', 'toggleInputsEquipo(2)');
   }
}


// Función para Obtener información de los equipos.
function informacionEquipo(idEquipo) {
   localStorage.setItem('idEquipo', idEquipo);
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   document.getElementById("modalMPEquipo").classList.add('open');
   document.getElementById("tooltipMP").classList.add('hidden');

   // Funciones principales

   consultarOpcionesEquipo();

   setTimeout(() => {
      const action = "informacionEquipo";
      $.ajax({
         type: "POST",
         url: "php/plannerCrudPHP.php",
         data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo
         },
         dataType: "JSON",
         success: function (data) {
            document.getElementById("inputAdjuntos").
               setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_america_adjuntos")');

            document.getElementById("QREquipo").
               setAttribute("src", "https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=svg&bgcolor=fff&color=4a5568&data=www.maphg.com/beta/gestion_equipos/index.php?" + idEquipo);

            document.getElementById("nombreEquipo").value = data.equipo;
            document.getElementById("seccionEquipo").value = data.idSeccion;
            document.getElementById("subseccionEquipo").value = data.idSubseccion;
            document.getElementById("jerarquiaEquipo").value = data.jerarquia;
            document.getElementById("dataOpcionesEquipos").value = data.idEquipoPrincipal;
            document.getElementById("jerarquiaEquipo2").innerHTML = data.jerarquia;
            document.getElementById("modeloEquipo").value = data.modelo;
            document.getElementById("serieEquipo").value = data.numero_serie;
            document.getElementById("codigoFabricanteEquipo").value = data.codigo_fabricante;
            document.getElementById("codigoInternoComprasEquipo").value = data.codigo_interno_compras;
            document.getElementById("largoEquipo").value = data.largo_cm;
            document.getElementById("anchoEquipo").value = data.ancho_cm;
            document.getElementById("altoEquipo").value = data.alto_cm;
            document.getElementById("potenciaElectricaHPEquipo").value = data.potencia_electrica_hp;
            document.getElementById("potenciaElectricaKWEquipo").value = data.potencia_electrica_kw;
            document.getElementById("voltajeEquipo").value = data.voltaje_v;
            document.getElementById("frecuenciaEquipo").value = data.frecuencia_hz;
            document.getElementById("caudalAguaM3HEquipo").value = data.caudal_agua_m3h;
            document.getElementById("caudalAguaGPHEquipo").value = data.caudal_agua_gph;
            document.getElementById("cargaMCAEquipo").value = data.carga_mca;
            document.getElementById("PotenciaEnergeticaFrioKWEquipo").value = data.potencia_energetica_frio_kw;
            document.getElementById("potenciaEnergeticaFrioTREquipo").value = data.potencia_energetica_frio_tr;
            document.getElementById("potenciaEnergeticaCalorKCALEquipo").value = data.potencia_energetica_calor_kcal;
            document.getElementById("caudalAireM3HEquipo").value = data.caudal_aire_m3h;
            document.getElementById("caudalAireCFMEquipo").value = data.caudal_aire_cfm;
            document.getElementById("estadoEquipo").value = data.status;
            document.getElementById("tipoEquipo").value = data.tipo;
            document.getElementById("idFaseEquipo").value = data.idFases;
            document.getElementById("tipoLocalEquipo").value = data.tipoLocalEquipo;
            document.getElementById("contenedorEstadoEquipo").classList.
               remove('bg-red-100', 'bg-green-100', 'bg-orange-100');
            document.getElementById("iconEstadoEquipo").classList.
               remove('text-red-400', 'text-green-400', 'text-orange-400');
            document.getElementById("estadoEquipo").classList.
               remove('text-red-400', 'text-green-400', 'text-orange-400');

            if (data.status == "TALLER") {
               document.getElementById("contenedorEstadoEquipo").classList.add('bg-orange-100');
               document.getElementById("iconEstadoEquipo").classList.add('text-orange-400');
               document.getElementById("estadoEquipo").classList.add('text-orange-400');
            } else if (data.status == "BAJA") {
               document.getElementById("contenedorEstadoEquipo").classList.add('bg-red-100');
               document.getElementById("iconEstadoEquipo").classList.add('text-red-400');
               document.getElementById("estadoEquipo").classList.add('text-red-400');
            } else {
               document.getElementById("contenedorEstadoEquipo").classList.add('bg-green-100');
               document.getElementById("iconEstadoEquipo").classList.add('text-green-400');
               document.getElementById("estadoEquipo").classList.add('text-green-400');
            }

            // Eventos
            document.getElementById("jerarquiaEquipo").addEventListener("change", function () { opcionesJerarquiaEquipo(idEquipo) });

            document.getElementById("btnAdjuntosEquipo").addEventListener("click", function () {
               document.getElementById("modalMedia").classList.add('open');
               obtenerImagenesEquipo(idEquipo);
            });

            // Funciones Secundarias
            toggleInputsEquipo(0);
            obtenerImagenesEquipo(idEquipo);
            consultarPlanEquipo(idEquipo);
            opcionesJerarquiaEquipo(idEquipo);

         }
      });

   }, 1200);
}


function opcionesJerarquiaEquipo(idEquipo) {

   let jerarquia = document.getElementById("jerarquiaEquipo").value;
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   const action = "opcionesJerarquiaEquipo";
   const URL = `gestion_equipos/php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}`;

   if (jerarquia == "SECUNDARIO") {
      fetch(URL)
         .then(res => res.json())
         .then(array => {
            let opcionesEquipo = `<option value="0">Equipo Principal </option>`;
            if (array.length > 0) {
               for (let index = 0; index < array.length; index++) {
                  var id = array[index].id;
                  var equipo = array[index].equipo;
                  opcionesEquipo += `<option value="${id}">${equipo} </option>`;
               }
               return opcionesEquipo;
            }
         }).then(opcionesEquipo => {
            document.getElementById("dataOpcionesEquipos").innerHTML = opcionesEquipo;
            document.getElementById("contenedorDataOpcionesEquipos").classList.remove('hidden');
         });

   } else {
      document.getElementById("contenedorDataOpcionesEquipos").classList.add('hidden');
      document.getElementById("dataOpcionesEquipos").value = 0;
   }
}


// Obtiene Images de los Equipos
function obtenerImagenesEquipo(idEquipo) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let tabla = "t_equipos_america_adjuntos";
   let idTabla = idEquipo;

   document.getElementById("inputAdjuntos").
      setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_america_adjuntos")');

   const action = "obtenerAdjuntos";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         tabla: tabla,
         idTabla: idTabla
      },
      dataType: "JSON",
      success: function (data) {
         if (data.imagen != "") {
            document.getElementById("dataImagenes").innerHTML = data.imagen;
            document.getElementById("dataImagenesEquipo").innerHTML = data.imagen;
            document.getElementById("contenedorImagenes").classList.remove('hidden');
            document.getElementById("dataImagenes").classList.remove("justify-center");
         } else {
            document.getElementById("contenedorImagenes").classList.add('hidden');
            document.getElementById("dataImagenes").innerHTML = '';
            document.getElementById("dataImagenesEquipo").innerHTML = '';
         }

         if (data.documento != "") {
            document.getElementById("dataAdjuntos").innerHTML = data.documento;
            document.getElementById("dataAdjuntos").classList.remove("justify-center");
         } else {
            document.getElementById("contenedorDocumentos").classList.add('hidden');
         }
      },
   });
}


// Actualiza la información de los Equipos
function actualizarEquipo(idEquipo) {
   let idSeccionX = localStorage.getItem('idSeccion');
   let idSubseccionX = localStorage.getItem('idSubseccion');
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');

   let nombreEquipo = document.getElementById("nombreEquipo").value;
   let seccionEquipo = document.getElementById("seccionEquipo").value;
   let subseccionEquipo = document.getElementById("subseccionEquipo").value;
   let tipoEquipo = document.getElementById("tipoEquipo").value;
   let jerarquiaEquipo = document.getElementById("jerarquiaEquipo").value;
   let equipoPrincipal = document.getElementById("dataOpcionesEquipos").value;
   let marcaEquipo = document.getElementById("marcaEquipo").value;
   let modeloEquipo = document.getElementById("modeloEquipo").value;
   let serieEquipo = document.getElementById("serieEquipo").value;
   let codigoFabricanteEquipo = document.getElementById("codigoFabricanteEquipo").value;
   let codigoInternoComprasEquipo = document.getElementById("codigoInternoComprasEquipo").value;
   let largoEquipo = document.getElementById("largoEquipo").value;
   let anchoEquipo = document.getElementById("anchoEquipo").value;
   let altoEquipo = document.getElementById("altoEquipo").value;
   let potenciaElectricaHPEquipo = document.getElementById("potenciaElectricaHPEquipo").value;
   let potenciaElectricaKWEquipo = document.getElementById("potenciaElectricaKWEquipo").value;
   let voltajeEquipo = document.getElementById("voltajeEquipo").value;
   let frecuenciaEquipo = document.getElementById("frecuenciaEquipo").value;
   let caudalAguaM3HEquipo = document.getElementById("caudalAguaM3HEquipo").value;
   let caudalAguaGPHEquipo = document.getElementById("caudalAguaGPHEquipo").value;
   let cargaMCAEquipo = document.getElementById("cargaMCAEquipo").value;
   let PotenciaEnergeticaFrioKWEquipo = document.getElementById("PotenciaEnergeticaFrioKWEquipo").value;
   let potenciaEnergeticaFrioTREquipo = document.getElementById("potenciaEnergeticaFrioTREquipo").value;
   let potenciaEnergeticaCalorKCALEquipo = document.getElementById("potenciaEnergeticaCalorKCALEquipo").value;
   let caudalAireM3HEquipo = document.getElementById("caudalAireM3HEquipo").value;
   let caudalAireCFMEquipo = document.getElementById("caudalAireCFMEquipo").value;
   let estadoEquipo = document.getElementById("estadoEquipo").value;
   let idFaseEquipo = document.getElementById("idFaseEquipo").value;
   let tipoLocalEquipo = document.getElementById("tipoLocalEquipo").value;
   const action = "actualizarEquipo";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idEquipo: idEquipo,
         nombreEquipo: nombreEquipo,
         seccionEquipo: seccionEquipo,
         subseccionEquipo: subseccionEquipo,
         tipoEquipo: tipoEquipo,
         jerarquiaEquipo: jerarquiaEquipo,
         equipoPrincipal: equipoPrincipal,
         marcaEquipo: marcaEquipo,
         modeloEquipo: modeloEquipo,
         serieEquipo: serieEquipo,
         codigoFabricanteEquipo: codigoFabricanteEquipo,
         codigoInternoComprasEquipo: codigoInternoComprasEquipo,
         largoEquipo: largoEquipo,
         anchoEquipo: anchoEquipo,
         altoEquipo: altoEquipo,
         potenciaElectricaHPEquipo: potenciaElectricaHPEquipo,
         potenciaElectricaKWEquipo: potenciaElectricaKWEquipo,
         voltajeEquipo: voltajeEquipo,
         frecuenciaEquipo: frecuenciaEquipo,
         caudalAguaM3HEquipo: caudalAguaM3HEquipo,
         caudalAguaGPHEquipo: caudalAguaGPHEquipo,
         cargaMCAEquipo: cargaMCAEquipo,
         PotenciaEnergeticaFrioKWEquipo: PotenciaEnergeticaFrioKWEquipo,
         potenciaEnergeticaFrioTREquipo: potenciaEnergeticaFrioTREquipo,
         potenciaEnergeticaCalorKCALEquipo: potenciaEnergeticaCalorKCALEquipo,
         caudalAireM3HEquipo: caudalAireM3HEquipo,
         caudalAireCFMEquipo: caudalAireCFMEquipo,
         estadoEquipo: estadoEquipo,
         idFaseEquipo: idFaseEquipo,
         tipoLocalEquipo: tipoLocalEquipo
      },
      // dataType: "JSON",
      success: function (data) {
         if (data = 1) {
            informacionEquipo(idEquipo);
            alertaImg('Equipo Actualizado', '', 'success', 2500);
            obtenerEquiposAmerica(idSeccionX, idSubseccionX);
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 3000);
         }
      }
   });
}




// Obtiene el Calendario de MP de los Equipos
function consultarPlanEquipo(idEquipo) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   const action = "consultarPlanEquipo";

   document.getElementById("contenedorPlanesEquipo").innerHTML = '';

   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idEquipo: idEquipo
      },
      dataType: "JSON",
      success: function (data) {
         if (data.planes) {
            if (data.planes.length > 0) {
               for (let index = 0; index < data.planes.length; index++) {

                  const planesX = datosPlanEquipo({
                     solucionado: data.planes[index].solucionado,
                     proceso: data.planes[index].proceso,
                     planificado: data.planes[index].planificado,
                     idSemana: data.planes[index].idSemana,
                     idProceso: data.planes[index].idProceso,
                     idEquipo: data.planes[index].idEquipo,
                     idPlan: data.planes[index].idPlan,
                     periodicidad: data.planes[index].periodicidad,
                     tipoPlan: data.planes[index].tipoPlan,
                     semana_1: data.planes[index].semana_1,
                     semana_2: data.planes[index].semana_2,
                     semana_3: data.planes[index].semana_3,
                     semana_4: data.planes[index].semana_4,
                     semana_5: data.planes[index].semana_5,
                     semana_6: data.planes[index].semana_6,
                     semana_7: data.planes[index].semana_7,
                     semana_8: data.planes[index].semana_8,
                     semana_9: data.planes[index].semana_9,
                     semana_10: data.planes[index].semana_10,
                     semana_11: data.planes[index].semana_11,
                     semana_12: data.planes[index].semana_12,
                     semana_13: data.planes[index].semana_13,
                     semana_14: data.planes[index].semana_14,
                     semana_15: data.planes[index].semana_15,
                     semana_16: data.planes[index].semana_16,
                     semana_17: data.planes[index].semana_17,
                     semana_18: data.planes[index].semana_18,
                     semana_19: data.planes[index].semana_19,
                     semana_20: data.planes[index].semana_20,
                     semana_21: data.planes[index].semana_21,
                     semana_22: data.planes[index].semana_22,
                     semana_23: data.planes[index].semana_23,
                     semana_24: data.planes[index].semana_24,
                     semana_25: data.planes[index].semana_25,
                     semana_26: data.planes[index].semana_26,
                     semana_27: data.planes[index].semana_27,
                     semana_28: data.planes[index].semana_28,
                     semana_29: data.planes[index].semana_29,
                     semana_30: data.planes[index].semana_30,
                     semana_31: data.planes[index].semana_31,
                     semana_32: data.planes[index].semana_32,
                     semana_33: data.planes[index].semana_33,
                     semana_34: data.planes[index].semana_34,
                     semana_35: data.planes[index].semana_35,
                     semana_36: data.planes[index].semana_36,
                     semana_37: data.planes[index].semana_37,
                     semana_38: data.planes[index].semana_38,
                     semana_39: data.planes[index].semana_39,
                     semana_40: data.planes[index].semana_40,
                     semana_41: data.planes[index].semana_41,
                     semana_42: data.planes[index].semana_42,
                     semana_43: data.planes[index].semana_43,
                     semana_44: data.planes[index].semana_44,
                     semana_45: data.planes[index].semana_45,
                     semana_46: data.planes[index].semana_46,
                     semana_47: data.planes[index].semana_47,
                     semana_48: data.planes[index].semana_48,
                     semana_49: data.planes[index].semana_49,
                     semana_50: data.planes[index].semana_50,
                     semana_51: data.planes[index].semana_51,
                     semana_52: data.planes[index].semana_52,
                     proceso_1: data.planes[index].proceso_1,
                     proceso_2: data.planes[index].proceso_2,
                     proceso_3: data.planes[index].proceso_3,
                     proceso_4: data.planes[index].proceso_4,
                     proceso_5: data.planes[index].proceso_5,
                     proceso_6: data.planes[index].proceso_6,
                     proceso_7: data.planes[index].proceso_7,
                     proceso_8: data.planes[index].proceso_8,
                     proceso_9: data.planes[index].proceso_9,
                     proceso_10: data.planes[index].proceso_10,
                     proceso_11: data.planes[index].proceso_11,
                     proceso_12: data.planes[index].proceso_12,
                     proceso_13: data.planes[index].proceso_13,
                     proceso_14: data.planes[index].proceso_14,
                     proceso_15: data.planes[index].proceso_15,
                     proceso_16: data.planes[index].proceso_16,
                     proceso_17: data.planes[index].proceso_17,
                     proceso_18: data.planes[index].proceso_18,
                     proceso_19: data.planes[index].proceso_19,
                     proceso_20: data.planes[index].proceso_20,
                     proceso_21: data.planes[index].proceso_21,
                     proceso_22: data.planes[index].proceso_22,
                     proceso_23: data.planes[index].proceso_23,
                     proceso_24: data.planes[index].proceso_24,
                     proceso_25: data.planes[index].proceso_25,
                     proceso_26: data.planes[index].proceso_26,
                     proceso_27: data.planes[index].proceso_27,
                     proceso_28: data.planes[index].proceso_28,
                     proceso_29: data.planes[index].proceso_29,
                     proceso_30: data.planes[index].proceso_30,
                     proceso_31: data.planes[index].proceso_31,
                     proceso_32: data.planes[index].proceso_32,
                     proceso_33: data.planes[index].proceso_33,
                     proceso_34: data.planes[index].proceso_34,
                     proceso_35: data.planes[index].proceso_35,
                     proceso_36: data.planes[index].proceso_36,
                     proceso_37: data.planes[index].proceso_37,
                     proceso_38: data.planes[index].proceso_38,
                     proceso_39: data.planes[index].proceso_39,
                     proceso_40: data.planes[index].proceso_40,
                     proceso_41: data.planes[index].proceso_41,
                     proceso_42: data.planes[index].proceso_42,
                     proceso_43: data.planes[index].proceso_43,
                     proceso_44: data.planes[index].proceso_44,
                     proceso_45: data.planes[index].proceso_45,
                     proceso_46: data.planes[index].proceso_46,
                     proceso_47: data.planes[index].proceso_47,
                     proceso_48: data.planes[index].proceso_48,
                     proceso_49: data.planes[index].proceso_49,
                     proceso_50: data.planes[index].proceso_50,
                     proceso_51: data.planes[index].proceso_51,
                     proceso_52: data.planes[index].proceso_52
                  });

                  document.getElementById("contenedorPlanesEquipo")
                     .insertAdjacentHTML('beforeend', planesX);
               }
               indicadorSemanaActual(data.planes[0].semanaActual);
            }
         } else {
            if (data.creado) {
               document.getElementById("contenedorPlanesEquipo").innerHTML = `<h1 class="w-full text-center text-gray-500 uppercase font-bold"> Creando Plan MP... </h1>`;
               if (data.creado == "SI") {
                  alertaImg('Creando Plan MP', '', 'success', 1900);
                  setTimeout(function () {
                     consultarPlanEquipo(idEquipo);
                  }, 1100)
               } else {
                  document.getElementById("contenedorPlanesEquipo").innerHTML = '';
               }
            } else {
               document.getElementById("contenedorPlanesEquipo").innerHTML = `<h1 class="w-full text-center text-gray-500 uppercase font-bold">Sin Planes</h1>`;
            }
         }
      }
   });
}


// Función para Agregar Evento ENTER y agregar alguna Actividad Extra
document.getElementById("inputActividadesExtra").addEventListener("keyup", function (event) {
   if (event.keyCode === 13) {
      let idOT = localStorage.getItem('idOT');
      agregarActividadesExtra(idOT);
   }
});

// Avento para guardarCambiosOT
document.getElementById("btnGuardarOT").addEventListener("click", guardarCambiosOT);


function actividadRealizadaOT(idOT, idActividad, tipoActividad) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let valor = 0;

   if (tipoActividad == "test") {
      valor = document.getElementById("test_" + idActividad).value;
   }

   if (tipoActividad == "checkList") {

      if (document.getElementById("check_si_" + idActividad).checked) {
         valor = document.getElementById("check_si_" + idActividad).value;
      }

      if (document.getElementById("check_no_" + idActividad).checked) {
         valor = document.getElementById("check_no_" + idActividad).value;
      }

      if (document.getElementById("check_na_" + idActividad).checked) {
         valor = document.getElementById("check_na_" + idActividad).value;
      }
   }

   const action = "actividadRealizadaOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&idActividad=${idActividad}&tipoActividad=${tipoActividad}&valor=${valor}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         if (array == "Actualizado") {
            consultarActividadRealizadaOT(idOT);
            alertaImg("Actividad Actualizada", "", "success", 2000);
         } else {
            consultarActividadRealizadaOT(idOT);
            alertaImg("Intente de Nuevo", "", "success", 2000);
         }
      });
}


function guardarCambiosOT() {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let comentario = document.getElementById("comentarioOT").value;
   let idOT = localStorage.getItem('idOT');
   const action = "guardarCambiosOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&comentario=${comentario}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         if (array == "Actualizado") {
            alertaImg(`OT #${idOT} Actualizada`, '', 'success', 3000);
         } else {
            alertaImg(`Intente de Nuevo`, '', 'info', 3000);
         }
      });
}


// Función para Agregar Actividades
function agregarActividadesExtra(idOT) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let actividadesExtra = document.getElementById("inputActividadesExtra").value;
   const action = "agregarActividadesExtra";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&actividadesExtra=${actividadesExtra}`;
   if (actividadesExtra.length > 0 && actividadesExtra != "0") {
      fetch(URL)
         .then(res => res.json())
         .then(array => {
            if (array == "Agregada") {
               consultarActividades(idOT);
               document.getElementById("inputActividadesExtra").value = '';
               alertaImg('Actividad Agregada', '', 'success', 2000);
            } else {
               alertaImg('Actividad Repetida', '', 'info', 2500);
               consultarActividades(idOT);
            }
         });
   } else {
      alertaImg('Actividad Vacia', '', 'info', 2500);
   }
}


// Elimina Actividades Extra de la OT
function eliminarActividadesExtra(idOT, posicionItem) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "eliminarActividadesExtra";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&posicionItem=${posicionItem}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         if (array == "Eliminada") {
            consultarActividades(idOT);
            alertaImg('Actividad Eliminada', '', 'success', 2000);
         } else {
            consultarActividades(idOT);
            alertaImg('Actividad NO Eliminada', '', 'info', 2500);
         }
      });
}


function actualizaStatusOT(idOT, status) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "actualizaStatusOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&status=${status}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         if (array.respuesta == "ACTIVADO") {
            alertaImg(`Status Activado`, '', 'success', 3000);
         } else if (array.respuesta == "DESACTIVADO") {
            alertaImg(`Status Desactivado`, '', 'success', 3000);
         } else if (array.respuesta == "SOLUCIONADO") {
            let idEquipo = localStorage.getItem('idEquipo');
            informacionEquipo(idEquipo);
            alertaImg(`OT #${array.idOT} Solucionado`, '', 'success', 3000);
            document.getElementById("modalSolucionarOT").classList.remove('open');
            document.getElementById("modalStatus").classList.remove('open');
         }
         consultaStatusOT(idOT);
      });
}


// Responsables asignados
function eliminarResponsbleOT(idOT, idResponsable) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "eliminarResponsbleOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&idResponsable=${idResponsable}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         if (array == "Agregado") {
            consultaResponsablesOT(idOT);
            document.getElementById("modalUsuarios").classList.remove('open');
            alertaImg("Usuario Asignado a la OT: " + idOT, "", "success", 2000);
         } else if (array == "Eliminado") {
            consultaResponsablesOT(idOT);
            document.getElementById("modalUsuarios").classList.remove('open');
            alertaImg("Usuario Eliminado", "", "success", 2000);
         }
      });
}


// Responsables asignados
function consultaResponsablesOT(idOT) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "consultaResponsablesOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         let responsables = `
                <div onclick="toggleModalTailwind('modalUsuarios'); obtenerUsuarios('asignarOT', ${idOT});" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                    <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                </div>
            `;

         for (let i = 0; i < array.length; i++) {
            var nombre = array[i].nombre + ' ' + array[i].apellido;
            var idResponsable = array[i].idUsuario;

            responsables += `
                    <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">${nombre}</h1>
                        <i onclick="eliminarResponsbleOT(${idOT}, ${idResponsable})" class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }
         document.getElementById("responsablesOT").innerHTML = responsables;
      });
}


function consultarActividadRealizadaOT(idOT) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "consultarActividadRealizadaOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         let actividades = array.actividades.split(';');
         for (let i = 0; i < actividades.length; i++) {
            if (actividades[i] != "") {
               document.getElementById("actividad_" + actividades[i]).checked = true;
            }
         }

         let test = array.test.split(';');
         for (let i = 0; i < test.length; i++) {
            if (test[i] != "") {
               const test_2 = test[i].split('=');
               const idTest = test_2[0];
               var valorTest = test_2[1];
               if (valorTest == undefined) {
                  valorTest = "";
               }
               document.getElementById("test_" + idTest).value = valorTest;
            }
         }

         let check = array.check.split(';');
         for (let i = 0; i < check.length; i++) {
            if (check[i] != "") {
               const check_2 = check[i].split('=');
               const idCheck = check_2[0];
               var valorCheck = check_2[1];

               if (valorCheck == "SI") {
                  document.getElementById("check_si_" + idCheck).checked = true;
               }
               if (valorCheck == "NO") {
                  document.getElementById("check_no_" + idCheck).checked = true;
               }
               if (valorCheck == "NA") {
                  document.getElementById("check_na_" + idCheck).checked = true;
               }
            }
         }
      });
}


// Consulta los Status de la OT
function consultaStatusOT(idOT) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "consultarStatusOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         estiloDefectoModalStatus();
         let status = `
                <div id="statusOT2" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                    <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                </div>            
            `;

         if (array.statusTrabajare == "1") {
            estiloStatusActivoModalStatus("statusTrabajare");
            status += `
                <div class="bg-blue-200 text-blue-700 px-2 rounded-full flex items-center mr-2">
                <h1 class="font-medium">Trabajando</h1>
                <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                </div>
                `;
         }

         if (array.statusMaterial == "1") {
            estiloStatusActivoModalStatus("statusMaterial");
            status += `
                    <div class="bg-orange-200 text-orange-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Material</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusElectricidad == "1") {
            estiloStatusActivoModalStatus("statusElectricidad");
            status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Electricidad</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusDiesel == "1") {
            estiloStatusActivoModalStatus("statusDiesel");
            status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Diesel</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusGas == "1") {
            estiloStatusActivoModalStatus("statusGas");
            status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Gas</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusAgua == "1") {
            estiloStatusActivoModalStatus("statusAgua");
            status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Agua</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusCalidad == "1") {
            estiloStatusActivoModalStatus("statusCalidad");
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Calidad</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusCompras == "1") {
            estiloStatusActivoModalStatus("statusCompras");
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Compras</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusDireccion == "1") {
            estiloStatusActivoModalStatus("statusDireccion");
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Dirección</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusFinanzas == "1") {
            estiloStatusActivoModalStatus("statusFinanzas");
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Finanzas</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusRRHH == "1") {
            estiloStatusActivoModalStatus("statusRRHH");
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">RRHH</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusCalidad == "1" || array.statusCompras == "1" || array.statusDireccion == "1" || array.statusFinanzas == "1" || array.statusRRHH == "1") {
            estiloStatusActivoModalStatus("statusdep");
         }

         if (array.statusElectricidad == "1" || array.statusDiesel == "1" || array.statusGas == "1" || array.statusAgua == "1") {
            estiloStatusActivoModalStatus("statusenergeticos");
         }

         return status;
      })
      .then(status => {
         document.getElementById("dataStatusOT").innerHTML = status;
         document.getElementById("statusOT2").setAttribute("onclick", `consultaStatusOT(${idOT}); toggleModalTailwind('modalStatus');`);
         document.getElementById("statusMaterial").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status_material');`);
         document.getElementById("statusTrabajare").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status_trabajando');`);
         document.getElementById("statusElectricidad").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_electricidad');`);
         document.getElementById("statusAgua").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_agua');`);
         document.getElementById("statusDiesel").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_diesel');`);
         document.getElementById("statusGas").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_gas');`);
         document.getElementById("statusRRHH").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_rrhh');`);
         document.getElementById("statusDireccion").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_direccion');`);
         document.getElementById("statusFinanzas").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_finanzas');`);
         document.getElementById("statusCalidad").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_calidad');`);
         document.getElementById("statusCompras").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_compras');`);
         document.getElementById("statusFinalizar").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status');`);
         document.getElementById("btnFinalizarOT").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status');`);
      });
}


function consultaAdjuntosOT(idOT) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "consultarAdjuntosOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         document.getElementById("imagenesOT").innerHTML = '';
         document.getElementById("documentosOT").innerHTML = '';
         document.getElementById("dataImagenes").innerHTML = '';
         document.getElementById("dataAdjuntos").innerHTML = '';

         let imagenes = '';
         let documentos = '';

         for (let i = 0; i < array.length; i++) {
            const id = array[i].id;
            const nombre = array[i].nombre;
            const url = array[i].url;
            const tipo = array[i].tipo;

            if (tipo == "imagenes") {
               imagenes += `
                    <a id="${id}" href="planner/mp_ot/${url}" target="_blank">
                        <div class="m-2 cursor-pointer overflow-hidden w-20 h-20 rounded-md">
                            <img src="planner/mp_ot/${url}" class="w-full" alt="">
                        </div>
                    </a>            
                    `;
            } else {
               documentos += `
                        <a id="${id}" href="planner/mp_ot/${url}" target="_blank">
                            <div class="w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                                <i class="fad fa-file-alt fa-2x"></i>
                                <p class=" font-normal ml-2">${url}</p>
                            </div>
                        </a>                   
                    `;
            }
         }

         document.getElementById("imagenesOT").innerHTML = imagenes;
         document.getElementById("documentosOT").innerHTML = documentos;

         document.getElementById("dataImagenes").innerHTML = imagenes;
         document.getElementById("dataAdjuntos").innerHTML = documentos;

         if (imagenes != "") {
            document.getElementById("contenedorImagenes").classList.remove('hidden');
         } else {
            document.getElementById("contenedorImagenes").classList.add('hidden');
         }

         if (documentos != "") {
            document.getElementById("contenedorDocumentos").classList.remove('hidden');
         } else {
            document.getElementById("contenedorDocumentos").classList.add('hidden');
         }

         // Eventos
         document.getElementById("inputAdjuntos").setAttribute("onchange", `subirImagenGeneral(${idOT}, "t_mp_planificacion_iniciada_adjuntos")`);
         document.getElementById("btnAdjuntosOT").setAttribute("onclick", `consultaAdjuntosOT(${idOT}); toggleModalTailwind('modalMedia');`);
      });
}


// Consulta las actividades Extra de la OT
function consultarActividades(idOT) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "consultarActividadesExtraOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         // ACTIVIDADES EXTRA
         var actividadesExtra = '';
         for (let i = 0; i < array[0].actividadesExtra.length; i++) {
            const actividad = array[0].actividadesExtra[i];
            if (actividad == "0") {
               document.getElementById("actividadesExtraOT").innerHTML = '';
            } else {
               actividadesExtra += `
                        <div class="p-2 rounded font-semibold flex items-center justify-start bg-green-100 text-green-500 cursor-pointer mb-1">
                            <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-green-600">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="w-full text-justify">
                                <h1>${actividad}</h1>
                            </div>
                            <div class="text-justify text-gray-500" onclick="eliminarActividadesExtra(${idOT}, ${i})";>
                                <i class="fas fa-trash"></i>
                            </div>
                        </div>                   
                    `;
            }

         }
         document.getElementById("actividadesExtraOT").innerHTML = actividadesExtra;
      });
}


// Muestra el Menú de los Planes
function opcionesMenuMP(id, idSemana, idProceso, idEquipo, idPlan, semanaX) {

   document.getElementById("tooltipMP").classList.remove('hidden');

   document.getElementById('semanaProgramacionMP').innerHTML = '(Semana ' + semanaX + ')';

   // Propiedades para el tooltip
   const button = document.getElementById(id);
   const tooltip = document.getElementById('tooltipMP');

   Popper.createPopper(button, tooltip, {
      placement: 'top',
   });

   document.getElementById("programarMPIndividual").
      setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "PROGRAMARINDIVIDUAL")`);

   document.getElementById("programarMPDesdeAqui").
      setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "PROGRAMARDESDEAQUI")`);

   document.getElementById("programarMPPersonalizado").
      setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "PROGRAMARPERSONALIZADO")`);
   document.getElementById("eliminarMPIndividual").
      setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "ELIMINARINDIVIDUAL")`);

   document.getElementById("eliminarMPDesdeAqui").
      setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "ELIMINARDESDEAQUI")`);

   document.getElementById("VerOTMP").
      setAttribute('onclick', `VerOTMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "VEROT")`);

   document.getElementById("generarOTMP").
      setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "GENERAROT")`);

   document.getElementById("solucionarOTMP").
      setAttribute('onclick', `obtenerOTDigital(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "SOLUCIONAROT")`);

   document.getElementById("cancelarOTMP").
      setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "CANCELAROT")`);
}


function obtenerOTDigital(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP) {
   document.getElementById("modalSolucionarOT").classList.add('open');
   document.getElementById("tooltipMP").classList.add('hidden');
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "obtenerOTDigital";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}&semanaX=${semanaX}&idPlan=${idPlan}`;
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         let idOT = array[0].OT;
         document.getElementById("numeroOT").innerHTML = idOT;
         localStorage.setItem('idOT', idOT);

         // Status de la OT
         document.getElementById("statusOT").innerHTML = array[0].statusOT;
         if (array[0].statusOT == "SOLUCIONADO") {
            document.getElementById("statusOT").classList.remove("bg-yellow-200", "text-yellow-500", "bg-green-200", "text-green-500");
            document.getElementById("statusOT").classList.add("bg-green-200", "text-green-500");
         } else {
            document.getElementById("statusOT").classList.remove("bg-yellow-200", "text-yellow-500", "bg-green-200", "text-green-500");
            document.getElementById("statusOT").classList.add("bg-yellow-200", "text-yellow-500");
         }

         document.getElementById("semanaOT").innerHTML = array[0].semana;
         document.getElementById("comentarioOT").value = array[0].comentario;
         document.getElementById("tipoOT").innerHTML = array[0].tipoPlan;


         // Actividades OT
         var actividades = '';

         for (let i = 0; i < array[0].actividades.length; i++) {
            var id = array[0].actividades[i].id;
            var actividad = array[0].actividades[i].actividad;
            var tipoActividad = array[0].actividades[i].tipoActividad;
            var medicion = array[0].actividades[i].medicion;

            if (tipoActividad == "actividad") {

               actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer mb-1">
                            <label class="mx-2 inline-flex items-center">
                                <input id="actividad_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="checkbox" class="form-checkbox w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600">
                                <div class="ml-2 text-justify">
                                    <h1>${actividad}</h1>
                                </div>
                            </label>
                        </div>
                    `;
            } else if (tipoActividad == "test") {

               actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start hover:bg-green-100 hover:text-green-500 cursor-pointer mb-1">
                            <div class="mr-2 flex flex-col leading-none">
                                <input id="test_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="text" name="" class="border-2 w-20 h-6 border-green-500 px-2 rounded font-bold" placeholder="Lectura" autocomplete="off">
                                <h1 class="font-bold text-xxs text-center text-bluegray-600">${medicion}</h1>
                            </div>
                            <div class=" text-justify flex items-center">
                                <h1>${actividad}</h1>
                            </div>
                        </div>
                    `;
            } else if (tipoActividad == "checkList") {
               actividades += `
                        <div class="p-2 rounded font-semibold text-bluegray-900 flex items-center justify-start cursor-pointer mb-1 leading-none  hover:bg-green-100 hover:text-green-500">

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_si_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="SI">
                                <div class=" text-justify">
                                    <h1>SI</h1>
                                </div>
                            </div>

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_no_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="NO">
                                <div class=" text-justify">
                                    <h1>NO</h1>
                                </div>
                            </div>

                            <div class="flex hover:bg-green-300 hover:text-green-700 items-center justify-start p-1 rounded">
                                <input id="check_na_${id}" onchange="actividadRealizadaOT(${idOT}, ${id}, '${tipoActividad}');" type="radio" class="form-radio w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-bluegray-600" name="${id}" value="NA">
                                <div class=" text-justify">
                                    <h1>N/A</h1>
                                </div>
                            </div>

                            <div class=" text-justify flex items-center">
                                <h1>${actividad}</h1>
                            </div>
                        </div>                    
                    `;
            }
         }
         document.getElementById("actividadesOT").innerHTML = actividades;

         // Funciones Complementarias Primarias
         consultarActividades(idOT);
         consultaAdjuntosOT(idOT);
         consultaStatusOT(idOT);

         return idOT;
      })
      .then(idOT => {
         // Funciones Complementarias Secunadarias
         consultarActividadRealizadaOT(idOT);
         consultaResponsablesOT(idOT);
      });
}

// Indicador de Semana actual para los MP
function indicadorSemanaActual(semana) {
   let totalElementos = document.getElementsByClassName("semana_" + semana);
   let codigo = '';

   if (semana < 10) {
      codigo = `
            0${semana}
            <i class="animated infinite heartBeat text-red-400 fas fa-circle absolute" style="left: 1px; bottom: -12px;"></i>
        `;
   } else {
      codigo = `
            ${semana}
            <i class="animated infinite heartBeat text-red-400 fas fa-circle absolute" style="left: 1px; bottom: -12px;"></i>
        `;
   }

   for (let i = 0; i < totalElementos.length; i++) {
      document.getElementsByClassName("semana_" + semana)[i].innerHTML = codigo;
   }
}


// Genera la Programación de los MP
function programarMP(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');
   let numeroSemanas = 0;

   if (accionMP == "PROGRAMARPERSONALIZADO") {
      numeroSemanas = document.getElementById("numeroSemanasPersonalizadasMP").value;
   }

   const action = "programarMP";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idSemana: idSemana,
         idProceso: idProceso,
         idEquipo: idEquipo,
         semanaX: semanaX,
         accionMP: accionMP,
         idPlan: idPlan,
         numeroSemanas: numeroSemanas
      },
      // dataType: "JSON",
      success: function (data) {
         if (data == 1) {
            alertaImg(`Programación Existente, Semana ${semanaX} `, '', 'error', 3000);
         } else if (data == 2) {
            alertaImg(`Programado en Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 3) {
            alertaImg(`Reprogramado Desde, Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 4) {
            alertaImg(`Personalizado Desde, Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 5) {
            alertaImg(`Eliminada, Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 6) {
            alertaImg(`Eliminada Desde, Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 7) {
            alertaImg(`Semana ${semanaX}, en Proceso`, '', 'success', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
            VerOTMP(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP);
         } else if (data == 8) {
            alertaImg(`Semana ${semanaX}, Solucionada`, '', 'success', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 9) {
            alertaImg(`Semana ${semanaX}, Cancelada`, '', 'success', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 10) {
            alertaImg(`Semana ${semanaX}, en Proceso Iniciado`, '', 'error', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 11) {
            alertaImg(`Semana ${semanaX}, Sin Proceso Iniciado`, '', 'error', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 12) {
            alertaImg(`Semana ${semanaX}, Sin Proceso Iniciado`, '', 'error', 3500);
            consultarPlanEquipo(idEquipo);
            cerrarTooltip('tooltipMP');
         } else {
            alertaImg(`Intente de Nuevo`, '', 'info', 3000);
         }
         obtenerEquiposAmerica(idSeccion, idSubseccion);
      }
   });
}


function consultarActividadesMP(idPlan) {

   document.getElementById('tooltipActividadesMP').classList.remove('hidden');

   window.addEventListener('click', function (e) {
      if (document.getElementById(idPlan + 'Actividades').contains(e.target)) {
         document.getElementById('tooltipActividadesMP').classList.remove('hidden');
      } else {
         document.getElementById('tooltipActividadesMP').classList.add('hidden');
      }
   });

   // Propiedades para el tooltip
   const button = document.getElementById(idPlan + 'Actividades');
   const tooltip = document.getElementById('tooltipActividadesMP');
   Popper.createPopper(button, tooltip);

   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   const action = "consultarActividadesMP";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idPlan: idPlan
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("tooltipActividadesMP").innerHTML = data.actividades;
      }
   });
}


// Obtiene las posibles opciones del Equipo para Actualizarlo
function consultarOpcionesEquipo() {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   const action = "consultarOpcionesEquipo";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino
      },
      dataType: "JSON",
      success: function (data) {
         document.getElementById("seccionEquipo").innerHTML = data.secciones;
         document.getElementById("subseccionEquipo").innerHTML = data.subsecciones;
         document.getElementById("tipoEquipo").innerHTML = data.tipos;
         document.getElementById("marcaEquipo").innerHTML = data.marcas;
      }
   });
}

// Proceso para Ver OT
function VerOTMP(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   let numeroSemanas = 0;

   const action = "programarMP";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idSemana: idSemana,
         idProceso: idProceso,
         idEquipo: idEquipo,
         semanaX: semanaX,
         accionMP: accionMP,
         idPlan: idPlan,
         numeroSemanas: numeroSemanas
      },
      // dataType: "JSON",
      success: function (data) {

         if (data == 10 || data == 13) {
            localStorage.setItem('URL', `${idSemana};${idProceso};${idEquipo};${semanaX};${idPlan}`);
            window.open('OT/index.php', "OT", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1200px, height=650px");
         }
      }
   });
}


// Habilita los Botones del Menu
function botonesMenuMP(x) {
   document.getElementById("VerOTMP").classList.add('hidden');
   document.getElementById("generarOTMP").classList.add('hidden');
   document.getElementById("solucionarOTMP").classList.add('hidden');
   document.getElementById("cancelarOTMP").classList.add('hidden');
   if (x == "PROCESO") {
      document.getElementById("VerOTMP").classList.remove('hidden');
      document.getElementById("solucionarOTMP").classList.remove('hidden');
      document.getElementById("cancelarOTMP").classList.remove('hidden');
   } else if (x == "0") {
      document.getElementById("generarOTMP").classList.remove('hidden');
   } else if (x == "SOLUCIONADO")
      document.getElementById("VerOTMP").classList.remove('hidden');
}


/* FUNCIONES PARA CAMBIO DE DISEÑOS GENERICOS */



// Funcion para restablecer Estilo ModalStatus
function estiloDefectoModalStatus() {
   document.getElementById("statusMaterial").classList.remove("bg-orange-200");
   document.getElementById("statusTrabajare").classList.remove("bg-blue-200");

   //Energeticos
   document.getElementById("statusenergeticos").classList.remove("bg-yellow-200");
   document.getElementById("statusElectricidad").classList.remove("bg-yellow-200");
   document.getElementById("statusAgua").classList.remove("bg-yellow-200");
   document.getElementById("statusDiesel").classList.remove("bg-yellow-200");
   document.getElementById("statusGas").classList.remove("bg-yellow-200");

   //Departamentos
   document.getElementById("statusdep").classList.remove("bg-teal-200");
   document.getElementById("statusRRHH").classList.remove("bg-teal-200");
   document.getElementById("statusCalidad").classList.remove("bg-teal-200");
   document.getElementById("statusDireccion").classList.remove("bg-teal-200");
   document.getElementById("statusFinanzas").classList.remove("bg-teal-200");
   document.getElementById("statusCompras").classList.remove("bg-teal-200");

   //Bitacora
   document.getElementById("statusbitacora").classList.remove("bg-lightblue-50");
   document.getElementById("statusGP").classList.remove("bg-lightblue-50");
   document.getElementById("statusTRS").classList.remove("bg-lightblue-50");
   document.getElementById("statusZI").classList.remove("bg-lightblue-50");
}


// Función para Aplicar Estilo a los Status activos
function estiloStatusActivoModalStatus(status) {
   if (status == "statusMaterial") {
      document.getElementById("statusMaterial").classList.add("bg-orange-200");
   }
   if (status == "statusTrabajare") {
      document.getElementById("statusTrabajare").classList.add("bg-blue-200");
   }
   if (status == "statusenergeticos") {
      document.getElementById("statusenergeticos").classList.add("bg-yellow-200");
   }
   if (status == "statusElectricidad") {
      document.getElementById("statusElectricidad").classList.add("bg-yellow-200");
   }
   if (status == "statusAgua") {
      document.getElementById("statusAgua").classList.add("bg-yellow-200");
   }
   if (status == "statusDiesel") {
      document.getElementById("statusDiesel").classList.add("bg-yellow-200");
   }
   if (status == "statusGas") {
      document.getElementById("statusGas").classList.add("bg-yellow-200");
   }
   if (status == "statusdep") {
      document.getElementById("statusdep").classList.add("bg-teal-200");
   }
   if (status == "statusCalidad") {
      document.getElementById("statusCalidad").classList.add("bg-teal-200");
   }
   if (status == "statusCompras") {
      document.getElementById("statusCompras").classList.add("bg-teal-200");
   }
   if (status == "statusDireccion") {
      document.getElementById("statusDireccion").classList.add("bg-teal-200");
   }
   if (status == "statusFinanzas") {
      document.getElementById("statusFinanzas").classList.add("bg-teal-200");
   }
   if (status == "statusRRHH") {
      document.getElementById("statusRRHH").classList.add("bg-teal-200");
   }
}


// Funcion toggle por CLASSNAME
function classNameToggle(nameClass) {
   var x = document.getElementsByClassName(nameClass);
   var i;
   for (i = 0; i < x.length; i++) {
      document.getElementsByClassName(nameClass)[i].classList.toggle("hidden");
   }
}


// Funciones para actualizar idSeccion y idSubseccion en localstorage..
function actualizarSeccionSubseccion(idSeccion, idSubseccion) {
   localStorage.setItem("idSeccion", idSeccion);
   localStorage.setItem("idSubseccion", idSubseccion);
}


// Funciones para actualizar idSeccion en localstorage.
function actualizarSeccion(idSeccion) {
   localStorage.SetItem("idSeccion", idSeccion);
}


// Funciones para actualizar idSeccion en localstorage.
function actualizarSubseccion(idSubseccion) {
   localStorage.SetItem("idSubseccion", idSubseccion);
}


// Oculta Vista con la clase HIDDEN
function hiddenVista(idVista) {
   document.getElementById(idVista).classList.add('hidden');
}

// toggle clase HIDDEN
function toggleHidden(idVista) {
   document.getElementById(idVista).classList.toggle('hidden');
}


// Funciones para Niveles de Vistas(Nivel 0: Elimina z-index, Nivel 1: z-index:101, Nivel 2: z-index:201)
function nivelVista(nivel, idVista) {
   if (nivel == 0) {
      document.getElementById(idVista).setAttribute('style', 'z-index:0;');
   } else if (nivel == 1) {
      document.getElementById(idVista).setAttribute('style', 'z-index:101;');
   } else if (nivel == 2) {
      document.getElementById(idVista).setAttribute('style', 'z-index:201;');
   }
}


function llamarFuncionX(nombreFuncion) {
   // Obtiene Datos Generales de la SESSION(LOCALSTORAGE.GETITEM)
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idSeccion = localStorage.getItem("idSeccion");
   let idSubseccion = localStorage.getItem("idSubseccion");

   switch (nombreFuncion) {
      case (nombreFuncion = "consultaSubsecciones"):
         consultaSubsecciones(idDestino, idUsuario);
         break;

      case (nombreFuncion = "obtenerEquiposAmerica"):
         obtenerEquiposAmerica(idSeccion, idSubseccion);
         break;
   }
}


// FUNCIÓN PARA MOSTRAL TOOLTIP DE ACTIVIDADES
function obtenerActividadesOT(idTipo, tipo) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "obtenerActividadesOT";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idTipo=${idTipo}&tipo=${tipo}`;

   document.getElementById("tooltipActividadesGeneral").classList.toggle('hidden');
   document.getElementById("btnAgregarActividadGeneral").
      setAttribute('onclick', `agregarActividadOT(${idTipo}, '${tipo}', 'nuevo', 0)`);

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         document.getElementById("dataActividadesGeneral").innerHTML = '';
         if (array.length > 0) {
            for (let x = 0; x < array.length; x++) {
               const idActividad = array[x].id;
               const idTipo = array[x].idTipo;
               const actividad = array[x].actividad;
               const tipo = array[x].tipo;
               var status = array[x].status;

               if (status == "SOLUCIONADO") {
                  status = 'bg-green-300';
               } else {
                  status = 'hove:bg-green-300';
               }

               const dataActividadesX = `
              <div id="${tipo + idActividad}" class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-fondos-2 fila-actividad-select">
                  <div class="w-4 h-4 border-2 border-gray-300 ${status} hover:border-green-400 cursor-pointer rounded-full mr-2 flex-none"></div>
                  <div class=" text-justify">
                      <h1 id="tituloActividad${idActividad}">${actividad}</h1>
                  </div>
                  <div class="px-2 text-gray-400 hover:text-purple-500 cursor-pointer" onclick="opcionesActividadesOT(${idTipo}, '${tipo}', ${idActividad})">
                      <i class="fas fa-ellipsis-h  text-sm"></i>
                  </div>
              </div>
          `;

               document.getElementById("dataActividadesGeneral").
                  insertAdjacentHTML('beforeend', dataActividadesX);
            }
         }
      })
      .then(function () {
         // Propiedades para el tooltip
         const elemento = tipo + idTipo;
         const button = document.getElementById(elemento);
         const tooltip = document.getElementById('tooltipActividadesGeneral');
         Popper.createPopper(button, tooltip);
      })
      .catch(function (err) {
         document.getElementById("tooltipActividadesGeneral").classList.add('hidden');
         document.getElementById("dataActividadesGeneral").innerHTML = '';
         fetch(`https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error(3099): ${err}`);
      })
}


// OPCIONES PARA LAS ACTIVIDADES OT
function opcionesActividadesOT(idTipo, tipo, idActividad) {

   // Propiedades para el tooltip
   document.getElementById("tooltipEditarEliminarSolucionar").classList.toggle('hidden');
   const elemento = tipo + idActividad;
   const button = document.getElementById(elemento);
   const tooltip = document.getElementById('tooltipEditarEliminarSolucionar');
   Popper.createPopper(button, tooltip, {
      placement: 'top'
   });
   // Propiedades para el tooltip

   document.getElementById("btnFinalizar").setAttribute('onclick',
      `actualizarActividadOT(${idTipo}, '${tipo}', 'status', ${idActividad})`);

   document.getElementById("btnTitulo").setAttribute('onclick',
      `actualizarActividadOT(${idTipo}, '${tipo}', 'actividad', ${idActividad})`);

   document.getElementById("btnEliminar").setAttribute('onclick',
      `actualizarActividadOT(${idTipo}, '${tipo}', 'activo', ${idActividad})`);

   let actividad = document.getElementById("tituloActividad" + idActividad).innerHTML;
   document.getElementById("inputTitulo").value = actividad;
}


// ACTUALIZA ACTIVIDAD OT
function actualizarActividadOT(idTipo, tipo, columna, idActividad) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idEquipo = localStorage.getItem('idEquipo');
   let actividad = document.getElementById("inputTitulo").value;
   const action = "actualizarActividadOT";
   const URL = `php/update_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idTipo=${idTipo}&tipo=${tipo}&columna=${columna}&actividad=${actividad}&idActividad=${idActividad}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         obtenerActividadesOT(idTipo, tipo);
         document.getElementById("tooltipEditarEliminarSolucionar").classList.add('hidden');
         document.getElementById("tooltipActividadesGeneral").classList.remove('hidden');

         if (array == "SOLUCIONADO") {
            alertaImg('Actividad, Solucionada', '', 'success', 1500);
         } else if (array == "ELIMINADO") {
            alertaImg('Actividad, Eliminada', '', 'success', 1500);
         } else if (array == "ACTIVIDAD") {
            alertaImg('Actividad, Actualizada', '', 'success', 1500);
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1500);
         }

         if (tipo == "FALLA") {
            obtenerFallas(idEquipo);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ': (actualizarActividadOT)');
      })
}


// AGREGAR ACTIVIDAD OT
function agregarActividadOT(idTipo, tipo, columna, idActividad) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idEquipo = localStorage.getItem('idEquipo');
   let actividad = document.getElementById("agregarActividadGeneral").value;
   const action = "actualizarActividadOT";
   const URL = `php/update_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idTipo=${idTipo}&tipo=${tipo}&columna=${columna}&actividad=${actividad}&idActividad=${idActividad}`;
   if (actividad.length > 1) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            obtenerActividadesOT(idTipo, tipo);
            if (array == "AGREGADO") {
               alertaImg('Actividad, Agregada', '', 'success', 1500);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
            }
         })
         .then(function () {
            document.getElementById("agregarActividadGeneral").value = '';
            document.getElementById("tooltipActividadesGeneral").classList.remove('hidden');
            if (tipo == "FALLA") {
               obtenerFallas(idEquipo);
            } else if (tipo == "TAREA") {
               obtenerTareas(idEquipo);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ': (agregarActividadOT)');
         })
   } else {
      alertaImg('Actividad NO Valida', '', 'info', 1500);
   }
}


// Cierra Sesión
async function cerrarSession() {
   alertaImg("Sessión Cerrada", "", "success", 1500);
   await localStorage.clear();
   await comprobarSession();
}


// FUNCION PARA DISEÑO DE FILA DE FALLA
const datosFallasTareas = params => {

   var idRegistro = params.id;

   var comentarios = params.comentarios;
   var valorcomentarios = '';

   var adjuntos = params.adjuntos;
   var valoradjuntos = '';

   var materiales = params.materiales;
   var materialesx = '';

   var departamentos = params.departamentos;
   var departamentosx = '';

   var energeticos = params.energeticos;
   var energeticosx = '';

   var trabajando = params.trabajando;
   var trabajandox = '';

   switch (comentarios) {
      case 0:
         valorcomentarios = '<i class="fad fa-minus text-xl text-red-400"></i>';
         break;
      default:
         valorcomentarios = params.comentarios;
   }

   switch (adjuntos) {
      case 0:
         valoradjuntos = '<i class="fad fa-minus text-xl text-red-400"></i>';
         break;
      default:
         valoradjuntos = params.adjuntos;
   }

   if (materiales >= 1) {
      materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
   } else {
      materialesx = '';
   }

   if (departamentos >= 1) {
      departamentosx = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
   } else {
      departamentosx = '';
   }

   if (energeticos >= 1) {
      energeticosx = '<div class="bg-yellow-300 w-5 h-5 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>E</h1></div>';
   } else {
      energeticosx = '';
   }

   if (trabajando >= 1) {
      trabajandox = '<div class="bg-cyan-300 w-5 h-5 rounded-full flex justify-center items-center text-cyan-600 mr-1"><h1>T</h1></div>';
   } else {
      trabajandox = '';
   }

   var fOT = `<a href="https://www.maphg.com/beta/OT_Fallas_Tareas/#${params.ot}" class="text-black" target="_blank">${params.ot}</a>`;
   if (params.status == "PENDIENTE" && params.tipo == "FALLA") {
      var statusX = 'S-PENDIENTE';
      var fResponsable = `onclick="obtenerUsuarios('asignarMC', ${idRegistro});"`;
      var fRangoFecha = `onclick="obtenerFechaMC(${idRegistro}, '${params.fechaInicio + ' - ' + params.fechaFin}');"`;
      var fAdjuntos = `onclick="obtenerAdjuntosMC(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosMC(${idRegistro});"`;
      var fStatus = `onclick="obtenerstatusMC(${idRegistro});"`;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'FALLA');"`;
      var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
      var enlaceToltip = `FALLA${idRegistro}`;
      var fVerEnPlanner = `onclick="verEnPlanner('FALLA', ${idRegistro}); toggleModalTailwind('modalVerEnPlanner');"`;
   } else if (params.status == "SOLUCIONADO" && params.tipo == "FALLA") {
      var statusX = 'S-SOLUCIONADO';
      var fResponsable = '';
      var fRangoFecha = '';
      var fAdjuntos = `onclick="obtenerAdjuntosMC(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosMC(${idRegistro});"`;
      var fStatus = `onclick="actualizarStatusMC(${idRegistro}, 'status', 'F')"`;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'FALLA');"`;
      var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
      var enlaceToltip = `FALLA${idRegistro}`;
      var fVerEnPlanner = `onclick="verEnPlanner('FALLA', ${idRegistro}); toggleModalTailwind('modalVerEnPlanner');"`;
   } else if (params.status == "PENDIENTE" && params.tipo == "TAREA") {
      var statusX = 'S-PENDIENTE';
      var fResponsable = `onclick="obtenerUsuarios('asignarTarea', ${idRegistro});"`;
      var fRangoFecha = `onclick="obtenerFechaTareas(${idRegistro}, '${params.fechaInicio + ' - ' + params.fechaFin}');"`;
      var fAdjuntos = `onclick="obtenerAdjuntosTareas(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosTareas(${idRegistro})"`;
      var fStatus = `onclick="obtenerInformacionTareas(${idRegistro}, '${params.actividad}')"`;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'TAREA');"`;
      var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
      var enlaceToltip = `TAREA${idRegistro}`;
      var fVerEnPlanner = `onclick="verEnPlanner('TAREA', ${idRegistro}); toggleModalTailwind('modalVerEnPlanner');"`;
   } else if (params.status == "SOLUCIONADO" && params.tipo == "TAREA") {
      var statusX = 'S-SOLUCIONADO';
      var fResponsable = `onclick="obtenerUsuarios('asignarTarea', ${idRegistro});"`;
      var fRangoFecha = '';
      var fAdjuntos = '';
      var fComentarios = '';
      var fStatus = `onclick="actualizarTareas(${idRegistro},  'status', 'P');"`;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'TAREA');"`;
      var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
      var enlaceToltip = `TAREA${idRegistro}`;
      var fVerEnPlanner = `onclick="verEnPlanner('TAREA', ${idRegistro}); toggleModalTailwind('modalVerEnPlanner');"`;
   }

   return `
        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal 
        ${statusX}">
           
        <td class="px-4 border-b border-gray-200 py-3" style="max-width: 360px;"
        ${fVerEnPlanner}>
            <div class="font-semibold uppercase leading-4" data-title="${params.actividad}">
               <h1 class="truncate">${params.actividad}</h1>
            </div>
            <div class="text-gray-500 leading-3 flex">
               <h1>Creado por: ${params.creadoPor}</h1>
            </div>
         </td>

         <td id="${enlaceToltip}" class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3"
         ${fActividades}>
            <h1>${params.pda}</h1>
         </td>
         
         <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" 
         ${fResponsable}>
            <h1>${params.responsable}</h1>
         </td>

         <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" 
         ${fRangoFecha}>
            <div class="leading-4">${params.fechaInicio}</div>
            <div class="leading-3">${params.fechaFin}</div>
         </td>

         <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3"
         ${fComentarios}>
            <h1>${valorcomentarios}</h1>
         </td>

         <td class=" whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fAdjuntos}>
            <h1>${valoradjuntos}</h1>
         </td>

         <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3">
            <div class="text-sm flex justify-center items-center font-bold">
               ${materialesx}
               ${energeticosx}
               ${departamentosx}
               ${trabajandox}
            </div>
         </td>
         
         <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
            <h1>${fOT}</h1>
         </td>

         <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
            <div class="px-2">
               ${iconoStatus}
            </div>
         </td>

      </tr>
   `;
};


// FUNCION PARA FALLAS (SOLUCIONADAS Y PENDIENTES)
function obtenerFallas(idEquipo = 0) {
   document.getElementById("pendientesFallasTareas").classList.remove('hidden');
   document.getElementById("ganttFallasTareas").classList.add('hidden');

   localStorage.setItem("idEquipo", idEquipo);
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem("idSubseccion");
   let tipoPendiente = 'FALLAS';
   const action = "obtenerFallas";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}&idSubseccion=${idSubseccion}`;

   document.getElementById("seccionFallaTarea").innerHTML = iconoLoader;
   document.getElementById("contenedorPrincipalTareasFallas").
      setAttribute('style', 'background:#fc8181; min-height: 60vh;');
   document.getElementById('tipoFallaTarea').innerHTML = tipoPendiente;
   document.getElementById("pendienteFallaTarea").
      setAttribute('onclick', `obtenerFallasPendientes(${idEquipo})`);
   document.getElementById("solucionadosFallaTarea").
      setAttribute('onclick', `obtenerFallasSolucionados(${idEquipo})`);
   // document.getElementById("agregarFallaTarea").setAttribute('onclick', 'datosModalAgregarMC()');
   document.getElementById("agregarFallaTarea").
      setAttribute('onclick', 'iniciarFormularioInicidencias()');
   document.getElementById("ganttFallaTarea").
      setAttribute('onclick', `ganttFallas(${idEquipo}, 'PENDIENTE')`);

   document.getElementById("exportarFallaTarea").
      setAttribute('onclick', 'reporteFallas(' + idEquipo + ')');

   document.getElementById("estiloEquipoFallaTarea").className = '';
   document.getElementById("estiloEquipoFallaTarea").
      classList.add('ml-4', 'font-bold', 'bg-red-200', 'text-red-500', 'text-xs', 'py-1', 'px-2', 'rounded'
      );

   // APLICA ESTILO A LAS OPCIONES
   let activos = ["pendienteFallaTarea", "opcionFallaPendiente"];
   let inactivos = ["ganttFallaTarea", "solucionadosFallaTarea", "agregarFallaTarea", "exportarFallaTarea"];
   estiloOpcionesModalTareasFallas(activos, inactivos, 'hover:bg-red-200', 'text-red-400', 'bg-red-200', 'bg-red-600');

   // OBTEIENE DATOS DE LAS FALLAS
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         document.getElementById("dataPendientesX").innerHTML = '';

         if (array.length > 0) {
            for (let x = 0; x < array.length; x++) {
               const id = array[x].id;
               const ot = array[x].ot;
               const actividad = array[x].actividad;
               const creadoPor = array[x].creadoPor;
               const pda = array[x].pda;
               const responsable = array[x].responsable;
               const fechaInicio = array[x].fechaInicio;
               const fechaFin = array[x].fechaFin;
               const comentarios = array[x].comentarios;
               const adjuntos = array[x].adjuntos;
               const status = array[x].status;
               const materiales = array[x].materiales;
               const energeticos = array[x].energeticos;
               const departamentos = array[x].departamentos;
               const trabajando = array[x].trabajando;
               const tipo = array[x].tipo;

               const data = datosFallasTareas({
                  id: id,
                  ot: ot,
                  actividad: actividad,
                  creadoPor: creadoPor,
                  pda: pda,
                  responsable: responsable,
                  fechaInicio: fechaInicio,
                  fechaFin: fechaFin,
                  comentarios: comentarios,
                  adjuntos: adjuntos,
                  status: status,
                  materiales: materiales,
                  trabajando: trabajando,
                  energeticos: energeticos,
                  departamentos: departamentos,
                  tipo: tipo
               });
               document.getElementById("dataPendientesX").insertAdjacentHTML('beforeend', data);
            }
         }
      })
      .then(function () {
         complementosFallasTareas();
      })
      .then(function () { obtenerFallasPendientes(idEquipo) })
      .catch(function (err) {
         fetch(APIERROR + err + ': (obtenerFallas)');
         complementosFallasTareas();
         document.getElementById("dataPendientesX").innerHTML = '';
         document.getElementById("seccionFallaTarea").innerHTML = '';
      })


   function complementosFallasTareas() {
      // OBTIENE NOMBRE DE EQUIPO Y SECCIÓN
      const URL2 = `php/select_REST_planner.php?action=DestinoSeccionSubseccionEquipo&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}&idSubseccion=${idSubseccion}&idSeccion=${idSeccion}&tipoPendiente=${tipoPendiente}`;
      fetch(URL2)
         .then(array => array.json())
         .then(array => {

            if (array.seccion) {
               let seccionX = array.seccion.toLowerCase();

               document.getElementById("estiloSeccionFallaTarea").className = '';
               document.getElementById("estiloSeccionFallaTarea").
                  classList.add(seccionX + '-logo-modal', 'flex', 'justify-center', 'items-center', 'rounded-b-md', 'w-16', 'h-10', 'shadow-xs');

               document.getElementById("seccionFallaTarea").innerHTML =
                  array.seccion.toUpperCase();
            }

            if (array.equipo) {
               document.getElementById("equipoFallaTarea").innerHTML = array.equipo + ' / ' + tipoPendiente;
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ': (complementosFallasTareas)');
         })
   }
};


function obtenerFallasSolucionados(idEquipo) {
   // APLICA ESTILO A LAS OPCIONES
   let activos = ["solucionadosFallaTarea", "opcionFallaPendiente"];
   let inactivos = ["pendienteFallaTarea", "ganttFallaTarea", "exportarFallaTarea", "agregarFallaTarea"];
   estiloOpcionesModalTareasFallas(activos, inactivos, 'hover:bg-red-200', 'text-red-400', 'bg-red-200', 'bg-red-600');

   let pendientes = document.getElementsByClassName("S-PENDIENTE");
   let solucionados = document.getElementsByClassName("S-SOLUCIONADO");

   if (pendientes.length > 0) {
      for (let x = 0; x < pendientes.length; x++) {
         document.getElementsByClassName("S-PENDIENTE")[x].classList.add('hidden');
      }
   }

   if (solucionados.length > 0) {
      for (let x = 0; x < solucionados.length; x++) {
         document.getElementsByClassName("S-SOLUCIONADO")[x].classList.remove('hidden');
      }
   } else {
      alertaImg('Sin Solucionados', '', 'info', 1500);
   }
}


function obtenerFallasPendientes(idEquipo) {
   // APLICA ESTILO A LAS OPCIONES
   let activos = ["pendienteFallaTarea", "opcionFallaPendiente"];
   let inactivos = ["ganttFallaTarea", "solucionadosFallaTarea", "agregarFallaTarea", "exportarFallaTarea"];
   estiloOpcionesModalTareasFallas(activos, inactivos, 'hover:bg-red-200', 'text-red-400', 'bg-red-200', 'bg-red-600');

   let pendientes = document.getElementsByClassName("S-PENDIENTE");
   let solucionados = document.getElementsByClassName("S-SOLUCIONADO");

   if (pendientes.length > 0) {
      for (let x = 0; x < pendientes.length; x++) {
         document.getElementsByClassName("S-PENDIENTE")[x].classList.remove('hidden');
      }
   }

   if (solucionados.length > 0) {
      for (let x = 0; x < solucionados.length; x++) {
         document.getElementsByClassName("S-SOLUCIONADO")[x].classList.add('hidden');
      }
   }
}


// FUNCION PARA FALLAS (SOLUCIONADAS Y PENDIENTES)
function obtenerTareas(idEquipo = 0) {
   document.getElementById("pendientesFallasTareas").classList.remove('hidden');
   document.getElementById("ganttFallasTareas").classList.add('hidden');

   localStorage.setItem("idEquipo", idEquipo);
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem("idSubseccion");
   let tipoPendiente = 'TAREAS';
   const action = "obtenerTareas";

   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;

   document.getElementById("seccionFallaTarea").innerHTML = iconoLoader;
   document.getElementById("contenedorPrincipalTareasFallas").
      setAttribute('style', 'background:#fbd38d; min-height: 60vh;');
   document.getElementById('tipoFallaTarea').innerHTML = tipoPendiente;
   document.getElementById("pendienteFallaTarea").
      setAttribute('onclick', `obtenerTareasPendientes(${idEquipo})`);
   document.getElementById("solucionadosFallaTarea").
      setAttribute('onclick', `obtenerTareasSolucionados(${idEquipo})`);

   document.getElementById("agregarFallaTarea").
      setAttribute("onclick", "datosAgregarTarea();");
   document.getElementById("btnAgregarMC").
      setAttribute("onclick", "agregarTarea();");

   document.getElementById("ganttFallaTarea").
      setAttribute("onclick", `ganttTareas(${idEquipo}, 'PENDIENTE')`);
   document.getElementById("opcionFallaPendiente").
      setAttribute("onclick", `obtenerTareas(${idEquipo})`);

   document.getElementById("estiloEquipoFallaTarea").className = '';
   document.getElementById("estiloEquipoFallaTarea").
      classList.add('ml-4', 'font-bold', 'bg-orange-200', 'text-orange-500', 'text-xs', 'py-1', 'px-2', 'rounded'
      );

   document.getElementById("exportarFallaTarea").
      setAttribute('onclick', 'reporteTareas(' + idEquipo + ')');


   // APLICA ESTILO A LAS OPCIONES
   let activos = ["pendienteFallaTarea", "opcionFallaPendiente"];
   let inactivos = ["ganttFallaTarea", "solucionadosFallaTarea", "agregarFallaTarea", "exportarFallaTarea"];
   estiloOpcionesModalTareasFallas(activos, inactivos, 'hover:bg-orange-200', 'text-orange-400', 'bg-orange-200', 'bg-orange-600');

   // OBTEIENE DATOS DE LAS FALLAS
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         document.getElementById("dataPendientesX").innerHTML = '';
         if (array.length > 0) {
            for (let x = 0; x < array.length; x++) {
               const id = array[x].id;
               const ot = array[x].ot;
               const actividad = array[x].actividad;
               const creadoPor = array[x].creadoPor;
               const pda = array[x].pda;
               const responsable = array[x].responsable;
               const fechaInicio = array[x].fechaInicio;
               const fechaFin = array[x].fechaFin;
               const comentarios = array[x].comentarios;
               const adjuntos = array[x].adjuntos;
               const status = array[x].status;
               const materiales = array[x].materiales;
               const energeticos = array[x].energeticos;
               const departamentos = array[x].departamentos;
               const trabajando = array[x].trabajando;
               const tipo = array[x].tipo;

               const data = datosFallasTareas({
                  id: id,
                  ot: ot,
                  actividad: actividad,
                  creadoPor: creadoPor,
                  pda: pda,
                  responsable: responsable,
                  fechaInicio: fechaInicio,
                  fechaFin: fechaFin,
                  comentarios: comentarios,
                  adjuntos: adjuntos,
                  status: status,
                  materiales: materiales,
                  trabajando: trabajando,
                  energeticos: energeticos,
                  departamentos: departamentos,
                  tipo: tipo
               });

               document.getElementById("dataPendientesX").insertAdjacentHTML('beforeend', data);
            }
         }
      })
      .then(function () {
         complementosFallasTareas();
      })
      .then(function () { obtenerTareasPendientes(idEquipo) })
      .catch(function (err) {
         fetch(APIERROR + err + ': (obtenerTareas)');
         document.getElementById("dataPendientesX").innerHTML = '';
         document.getElementById("seccionFallaTarea").innerHTML = '';
         complementosFallasTareas();
      })


   function complementosFallasTareas() {
      // OBTIENE NOMBRE DE EQUIPO Y SECCIÓN
      const URL2 = `php/select_REST_planner.php?action=DestinoSeccionSubseccionEquipo&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}&idSubseccion=${idSubseccion}&idSeccion=${idSeccion}&tipoPendiente=${tipoPendiente}`;
      fetch(URL2)
         .then(array => array.json())
         .then(array => {

            if (array.seccion) {
               let seccionX = array.seccion.toLowerCase();

               document.getElementById("estiloSeccionFallaTarea").className = '';
               document.getElementById("estiloSeccionFallaTarea").
                  classList.add(seccionX + '-logo-modal', 'flex', 'justify-center', 'items-center', 'rounded-b-md', 'w-16', 'h-10', 'shadow-xs');

               document.getElementById("seccionFallaTarea").innerHTML =
                  array.seccion.toUpperCase();
            }

            if (array.equipo) {
               document.getElementById("equipoFallaTarea").innerHTML = array.equipo + ' / ' + tipoPendiente;
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ': (complementosFallasTareas)');
         })
   }
}


function obtenerTareasSolucionados(idEquipo) {
   // APLICA ESTILO A LAS OPCIONES
   let activos = ["solucionadosFallaTarea", "opcionFallaPendiente"];
   let inactivos = ["pendienteFallaTarea", "ganttFallaTarea", "exportarFallaTarea", "agregarFallaTarea"];
   estiloOpcionesModalTareasFallas(activos, inactivos, 'hover:bg-orange-200', 'text-orange-400', 'bg-orange-200', 'bg-orange-600');

   let pendientes = document.getElementsByClassName("S-PENDIENTE");
   let solucionados = document.getElementsByClassName("S-SOLUCIONADO");

   if (pendientes.length > 0) {
      for (let x = 0; x < pendientes.length; x++) {
         document.getElementsByClassName("S-PENDIENTE")[x].classList.add('hidden');
      }
   }

   if (solucionados.length > 0) {
      for (let x = 0; x < solucionados.length; x++) {
         document.getElementsByClassName("S-SOLUCIONADO")[x].classList.remove('hidden');
      }
   }
}


function obtenerTareasPendientes(idEquipo) {
   // APLICA ESTILO A LAS OPCIONES
   let activos = ["pendienteFallaTarea", "opcionFallaPendiente"];
   let inactivos = ["ganttFallaTarea", "solucionadosFallaTarea", "agregarFallaTarea", "exportarFallaTarea"];
   estiloOpcionesModalTareasFallas(activos, inactivos, 'hover:bg-orange-200', 'text-orange-400', 'bg-orange-200', 'bg-orange-600');

   let pendientes = document.getElementsByClassName("S-PENDIENTE");
   let solucionados = document.getElementsByClassName("S-SOLUCIONADO");

   if (pendientes.length > 0) {
      for (let x = 0; x < pendientes.length; x++) {
         document.getElementsByClassName("S-PENDIENTE")[x].classList.remove('hidden');
      }
   }

   if (solucionados.length > 0) {
      for (let x = 0; x < solucionados.length; x++) {
         document.getElementsByClassName("S-SOLUCIONADO")[x].classList.add('hidden');
      }
   }
}

// FUNCION ARRAY PARA ESTILO DE OPCIONES EN MODAL #modalTareasFallas
// RECIBE 2 ARRAS PARA ACTIVOS E INACTIVOS
function estiloOpcionesModalTareasFallas(activos, inactivos, hover, texto, bgActivo, bgInactivo) {

   if (activos) {
      activos.forEach(function (x) {
         if (document.getElementById(x)) {
            document.getElementById(x).classList.remove('hover:bg-orange-200', 'text-orange-400', 'bg-orange-200', 'bg-orange-600', 'hover:bg-red-200', 'text-red-400', 'bg-red-200', 'bg-red-600');
         }
      })
   }

   if (inactivos) {
      inactivos.forEach(function (x) {
         if (document.getElementById(x)) {
            document.getElementById(x).classList.remove('hover:bg-orange-200', 'text-orange-400', 'bg-orange-200', 'bg-orange-600', 'hover:bg-red-200', 'text-red-400', 'bg-red-200', 'bg-red-600');
         }
      })
   }

   if (activos) {
      activos.forEach(function (x) {
         if (document.getElementById(x)) {
            document.getElementById(x).classList.add(bgActivo, texto);
         }
      })
   }

   if (inactivos) {
      inactivos.forEach(function (x) {
         if (document.getElementById(x)) {
            document.getElementById(x).classList.add(hover, bgInactivo, texto);
         }
      })
   }
}


//Función para Generar Grafica GANTT de PROYECTOS PENDIENTES 
function ganttTareas(idEquipo, status) {

   document.getElementById("pendientesFallasTareas").classList.add('hidden');
   document.getElementById("ganttFallasTareas").classList.remove('hidden');

   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idSeccion = localStorage.getItem("idSeccion");
   let idSubseccion = localStorage.getItem("idSubseccion");
   let palabraEquipo = document.getElementById("palabraFallaTarea").value;
   const action = "ganttTareas";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&idEquipo=${idEquipo}&status=${status}&palabraEquipo=${palabraEquipo}`;

   document.getElementById("pendienteFallaTarea").
      setAttribute("onclick", `ganttTareas(${idEquipo}, 'PENDIENTE')`);
   document.getElementById("solucionadosFallaTarea").
      setAttribute("onclick", `ganttTareas(${idEquipo}, 'SOLUCIONADO')`);
   document.getElementById("opcionFallaPendiente").
      setAttribute("onclick", `obtenerTareas(${idEquipo})`);

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         document.getElementById("dataGanttFallasPendientes").innerHTML = '';
         if (array.length > 0) {

            for (var i = 0; i < array.length; i++) {
               var colorSet = new am4core.ColorSet();
               array[i]["color"] = colorSet.getIndex(i);
            }

            const size = 100 + array.length * 50;
            document.getElementById("dataGanttFallasPendientes")
               .setAttribute("style", "height:" + size + "px");

         } else {
            alertaImg('No se Encontraron Datos', '', 'info', 1500);
         }
         return array;
      }).then(function (array) {
         generarGantt(array);
      })
      .catch(function (err) {
         fethc(APIERROR + err + ': (ganttTareas)');
      });


   function generarGantt(array) {
      am4core.useTheme(am4themes_animated);

      var chart = am4core.create("dataGanttFallasPendientes", am4charts.XYChart);
      chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

      chart.paddingRight = 30;
      chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

      var colorSet = new am4core.ColorSet();
      colorSet.saturation = 0.4;

      chart.data = array;
      chart.dateFormatter.dateFormat = "yyyy-MM-dd";
      chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

      var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "category";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.inversed = true;

      var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
      dateAxis.renderer.minGridDistance = 70;
      dateAxis.baseInterval = { count: 1, timeUnit: "day" };
      dateAxis.renderer.tooltipLocation = 0;

      var series1 = chart.series.push(new am4charts.ColumnSeries());
      series1.columns.template.height = am4core.percent(70);
      series1.columns.template.tooltipText =
         "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

      series1.dataFields.openDateX = "start";
      series1.dataFields.dateX = "end";
      series1.dataFields.categoryY = "category";
      series1.columns.template.propertyFields.fill = "color"; // get color from data
      series1.columns.template.propertyFields.stroke = "color";
      series1.columns.template.strokeOpacity = 1;

      chart.scrollbarX = new am4core.Scrollbar();
   }
}


//Función para Generar Grafica GANTT de PROYECTOS PENDIENTES 
function ganttFallas(idEquipo, status) {

   document.getElementById("pendientesFallasTareas").classList.add('hidden');
   document.getElementById("ganttFallasTareas").classList.remove('hidden');

   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idSeccion = localStorage.getItem("idSeccion");
   let idSubseccion = localStorage.getItem("idSubseccion");
   let palabraEquipo = document.getElementById("palabraFallaTarea").value;
   const action = "ganttFallas";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&idEquipo=${idEquipo}&status=${status}&palabraEquipo=${palabraEquipo}`;
   document.getElementById("pendienteFallaTarea").
      setAttribute("onclick", `ganttFallas(${idEquipo}, 'PENDIENTE')`);
   document.getElementById("solucionadosFallaTarea").
      setAttribute("onclick", `ganttFallas(${idEquipo}, 'SOLUCIONADO')`);
   document.getElementById("opcionFallaPendiente").
      setAttribute("onclick", `obtenerFallas(${idEquipo})`);

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         document.getElementById("dataGanttFallasPendientes").innerHTML = '';
         if (array.length > 0) {

            for (var i = 0; i < array.length; i++) {
               var colorSet = new am4core.ColorSet();
               array[i]["color"] = colorSet.getIndex(i);
            }

            const size = 100 + array.length * 50;
            document.getElementById("dataGanttFallasPendientes")
               .setAttribute("style", "height:" + size + "px");

         } else {
            alertaImg('No se Encontraron Datos', '', 'info', 1500);
         }
         return array;
      }).then(function (array) {
         generarGantt(array);
      })
      .catch(function (err) {
         fethc(APIERROR + err + ': (ganttFallas)');
      });

   function generarGantt(array) {
      am4core.useTheme(am4themes_animated);

      var chart = am4core.create("dataGanttFallasPendientes", am4charts.XYChart);
      chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

      chart.paddingRight = 30;
      chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

      var colorSet = new am4core.ColorSet();
      colorSet.saturation = 0.4;

      chart.data = array;
      chart.dateFormatter.dateFormat = "yyyy-MM-dd";
      chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

      var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
      categoryAxis.dataFields.category = "category";
      categoryAxis.renderer.grid.template.location = 0;
      categoryAxis.renderer.inversed = true;

      var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
      dateAxis.renderer.minGridDistance = 70;
      dateAxis.baseInterval = { count: 1, timeUnit: "day" };
      dateAxis.renderer.tooltipLocation = 0;

      var series1 = chart.series.push(new am4charts.ColumnSeries());
      series1.columns.template.height = am4core.percent(70);
      series1.columns.template.tooltipText =
         "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

      series1.dataFields.openDateX = "start";
      series1.dataFields.dateX = "end";
      series1.dataFields.categoryY = "category";
      series1.columns.template.propertyFields.fill = "color"; // get color from data
      series1.columns.template.propertyFields.stroke = "color";
      series1.columns.template.strokeOpacity = 1;

      chart.scrollbarX = new am4core.Scrollbar();
   }
}


// FUNCION PARA OBTENER DISEÑO DE LOS EQUIPOS
const dataEquiposAmerica = params => {
   var icono = '<i class="fad fa-minus text-xl text-red-400 leading-none"></i>';
   var tipoEquipo = params.tipoEquipo;
   var valorTipoEquipo = '';
   var idEquipo = params.idEquipo;

   if (tipoEquipo == "EQUIPO") {
      valorTipoEquipo = '<div class="text-blue-400 bg-blue-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class=""><i class="fas fa-cog mr-1"></i>Equipo</h1></div>';
   } else if (tipoEquipo == "LOCAL") {
      valorTipoEquipo = '<div class="text-teal-400 bg-teal-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class=""><i class="fas fa-home mr-1"></i>Local</h1></div>';
   } else {
      valorTipoEquipo = '<div class="text-red-400 bg-red-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class=""><i class="fas fa-question-circle mr-1"></i></h1></div>';
   }

   var statusEquipo = params.statusEquipo;
   var valorstatusEquipo = ''

   if (statusEquipo == 'OPERATIVO') {
      valorstatusEquipo = '<div class="text-green-400 bg-green-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class="">Operativo</h1></div>';
   } else if (statusEquipo == 'BAJA') {
      valorstatusEquipo = '<div class="text-red-400 bg-red-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class="">Baja</h1></div>';
   } else if (statusEquipo == 'TALLER') {
      valorstatusEquipo = '<div class="text-orange-400 bg-orange-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class="">Taller</h1></div>';
   }

   if (idEquipo > 0) {
      idEquipoX = `<div class=" bg-gray-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class="text-gray-600">ID: ${idEquipo}</h1></div>`;
   } else {
      idEquipoX = '';
   }

   var ultimoMpFecha = params.ultimoMpFecha;

   if (ultimoMpFecha == 0) {
      valorultimoMpFecha = icono;
   } else {
      valorultimoMpFecha = params.ultimoMpFecha;
   }

   var ultimoMpSemana = params.ultimoMpSemana;

   if (ultimoMpSemana == 0) {
      valorultimoMpSemana = '';
   } else {
      valorultimoMpSemana = "Sem " + params.ultimoMpSemana;
   }


   var proximoMpFecha = params.proximoMpFecha;

   if (proximoMpFecha == 0) {
      valorproximoMpFecha = icono;
   } else {
      valorproximoMpFecha = params.proximoMpFecha;
   }

   var proximoMpSemana = params.proximoMpSemana;

   if (proximoMpSemana == 0) {
      valorproximoMpSemana = '';
   } else {
      valorproximoMpSemana = "Sem " + params.proximoMpSemana;
   }

   var ultimoTestFecha = params.ultimoTestFecha;

   if (ultimoTestFecha == 0) {
      valorultimoTestFecha = icono;
   } else {
      valorultimoTestFecha = params.ultimoTestFecha;
   }


   var ultimoTestSemana = params.ultimoTestSemana;

   if (ultimoTestSemana == 0) {
      valorultimoTestSemana = '';
   } else {
      valorultimoTestSemana = "Sem " + params.ultimoTestSemana;
   }

   var cotizaciones = params.cotizaciones;

   if (cotizaciones == 0) {
      valorcotizaciones = icono;
   } else {
      valorcotizaciones = params.cotizaciones;
   }

   var imagenes = params.imagenes;

   if (imagenes == 0) {
      valorimagenes = icono;
   } else {
      valorimagenes = params.imagenes;
   }

   var comentarios = params.comentarios;

   if (comentarios == 0) {
      valorcomentarios = icono;
   } else {
      valorcomentarios = params.comentarios;
   }

   var totalTestR = params.testR;
   if (totalTestR == 0) {
      valorTestR = icono;
   } else {
      valorTestR = totalTestR;
   }

   if (params.fallasP == 0) {
      valorFallasP = '';
   } else {
      valorFallasP = params.fallasP;
   }

   if (params.fallasS == 0) {
      valorFallasS = '';
   } else {
      valorFallasS = params.fallasS;
   }

   if (params.tareasP == 0) {
      valorTareasP = '';
   } else {
      valorTareasP = params.tareasP;
   }

   if (params.tareasS == 0) {
      valorTareasS = '';
   } else {
      valorTareasS = params.tareasS;
   }

   if (params.mpP == 0) {
      valormpP = '';
   } else {
      valormpP = params.mpP;
   }

   if (params.mpS == 0) {
      valormpS = '';
   } else {
      valormpS = params.mpS;
   }

   if (valormpS == '' && valormpP == '') {
      valormpS = icono;
   }

   if (valorTareasP == '' && valorTareasS == '') {
      valorTareasP = icono;
   }

   if (valorFallasP == '' && valorFallasS == '') {
      valorFallasP = icono;
   }

   var totalDespiece = params.totalDespiece;
   if (totalDespiece == 0) {
      valorDespiece = icono;
      fDespiece = `onclick="obtenerDespieceEquipo(0)"`;
   } else {
      valorDespiece = totalDespiece;
      fDespiece = `onclick="obtenerDespieceEquipo(${idEquipo})"`;
   }

   var fFallas = `onclick="obtenerFallas(${idEquipo}); toggleModalTailwind('modalTareasFallas');"`;
   var fTareas = `onclick="obtenerTareas(${idEquipo}); toggleModalTailwind('modalTareasFallas');"`;
   var fComentarios = `onclick="obtenerComentariosEquipos(${idEquipo}); toggleModalTailwind('modalComentarios');"`;
   var fAdjuntos = `onclick="obtenerMediaEquipo(${idEquipo})"`;
   var fInfo = `onclick="informacionEquipo(${idEquipo});"`;
   var fCotizaciones = `onclick="obtenerCotizacionesEquipo(${idEquipo})"`;
   var fTest = `onclick="toggleModalTailwind('modalTestEquipo'); obtenerTestEquipo(${idEquipo})"`;

   return `
        <tr id="${idEquipo}EquipoAmerica" class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-700">
            
            <td class="px-4 border-b border-gray-200truncate py-2" style="max-width: 360px;"
            ${fInfo}>
                <div class="font-semibold uppercase text-sm" data-title="${params.equipo}">
                    <h1 class="truncate">${params.equipo}</h1>
                </div>
                <div class="text-gray-500 leading-none flex text-xxs">
                    ${valorTipoEquipo}
                    ${valorstatusEquipo}
                    ${idEquipoX}
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300" ${fFallas}">
                <div class="font-bold uppercase text-sm text-red-400" data-title="${'Fallas Pendientes: ' + params.fallasP}">
                    <h1>${valorFallasP}</h1>
                </div>
                <div class="font-semibold uppercase text-green-400" data-title="${'Fallas Solucionadas: ' + params.fallasS}">
                    <h1>${valorFallasS}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-bold uppercase text-sm text-red-400">
                    <h1>${valormpP}</h1>
                </div>
                <div class="font-semibold uppercase text-green-400">
                    <h1>${valormpS}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-semibold uppercase">
                    <h1>${valorultimoMpFecha}</h1>
                </div>
                <div class="">
                    <h1>${valorultimoMpSemana}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-semibold uppercase">
                    <h1>${valorproximoMpFecha}</h1>
                </div>
                <div class="uppercase">
                    <h1>${valorproximoMpSemana}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300" ${fTareas}>
                <div class="font-bold uppercase text-sm text-red-400">
                    <h1>${valorTareasP}</h1>
                </div>
                <div class="font-semibold uppercase text-green-400">
                    <h1>${valorTareasS}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300" ${fTest}>
                <div class="font-semibold uppercase">
                    <h1>${valorTestR}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-semibold uppercase">
                    <h1>${valorultimoTestFecha}</h1>
                </div>
                <div class="uppercase">
                    <h1>${valorultimoTestSemana}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300 hidden" ${fCotizaciones}>
                <div class="font-semibold uppercase">
                    <h1>${valorcotizaciones}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300" ${fAdjuntos}>
                <div class="font-semibold uppercase">
                    <h1>${valorimagenes}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300 truncate" ${fComentarios}>
                <div class="font-semibold uppercase">
                    <h1>${valorcomentarios}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300 truncate" ${fDespiece}>
                <div class="font-semibold uppercase">
                    <h1>${valorDespiece}</h1>
                </div>
            </td>

        </tr>
    `;
};


// OBTIENE EL DESPIECE DE EQUIPOS
function obtenerDespieceEquipo(idEquipo) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "obtenerDespieceEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}`;

   document.getElementById("modalEquiposAmericaBG").
      setAttribute('onclick', "expandir('tooltipDespieceEquipo')");

   if (idEquipo > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {

            document.getElementById("contenedorEquiposAmericaDespice").innerHTML = '';

            if (array.length > 0) {
               for (let x = 0; x < array.length; x++) {
                  const idEquipo = array[x].idEquipo;
                  const equipo = array[x].equipo;
                  const tipoEquipo = array[x].tipoEquipo;
                  const statusEquipo = array[x].statusEquipo;
                  const fallasP = array[x].fallasP;
                  const fallasS = array[x].fallasS;
                  const mpP = array[x].mpP;
                  const mpS = array[x].mpS;
                  const ultimoMpFecha = array[x].ultimoMpFecha;
                  const ultimoMpSemana = array[x].ultimoMpSemana;
                  const proximoMpFecha = array[x].proximoMpFecha;
                  const proximoMpSemana = array[x].proximoMpSemana;
                  const tareasP = array[x].tareasP;
                  const tareasS = array[x].tareasS;
                  const testR = array[x].testR;
                  const ultimoTestFecha = array[x].ultimoTestFecha;
                  const ultimoTestSemana = array[x].ultimoTestSemana;
                  const cotizaciones = array[x].cotizaciones;
                  const imagenes = array[x].imagenes;
                  const comentarios = array[x].comentarios;
                  const totalDespiece = array[x].totalDespiece;

                  const data = dataEquiposAmerica({
                     idEquipo: idEquipo,
                     equipo: equipo,
                     tipoEquipo: tipoEquipo,
                     statusEquipo: statusEquipo,
                     fallasP: fallasP,
                     fallasS: fallasS,
                     mpP: mpP,
                     mpS: mpS,
                     ultimoMpFecha: ultimoMpFecha,
                     ultimoMpSemana: ultimoMpSemana,
                     proximoMpFecha: proximoMpFecha,
                     proximoMpSemana: proximoMpSemana,
                     tareasP: tareasP,
                     tareasS: tareasS,
                     testR: testR,
                     ultimoTestFecha: ultimoTestFecha,
                     ultimoTestSemana: ultimoTestSemana,
                     cotizaciones: cotizaciones,
                     imagenes: imagenes,
                     comentarios: comentarios,
                     totalDespiece: totalDespiece
                  });

                  document.getElementById("contenedorEquiposAmericaDespice").
                     insertAdjacentHTML('beforeend', data);
               }
            } else {
               alertaImg('Sin Equipos/Locales DESPIECE', '', 'info', 1500);
            }
         })
         .then(function () {
            const button = document.getElementById(idEquipo + "EquipoAmerica");
            const tooltip = document.getElementById('tooltipDespieceEquipo');
            document.getElementById('tooltipDespieceEquipo').
               classList.toggle('hidden');
            Popper.createPopper(button, tooltip, {
               placement: 'bottom'
            });
         })
         .catch(function (err) {
            fetch(APIERROR + err + ': (obtenerDespieceEquipo)');
            document.getElementById("contenedorEquiposAmericaDespice").innerHTML = '';
         })
   } else {
      alertaImg('Equipo Sin Despiece', '', 'info', 1500);
   }
}


// OBTIENE LOS EQUIPOS AMERICA
function obtenerEquiposAmerica(idSeccion, idSubseccion) {
   localStorage.setItem('idSeccion', idSeccion);
   localStorage.setItem("idSubseccion", idSubseccion);

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let contenedor = document.getElementById("contenedorEquiposAmerica");

   document.getElementById("seccionSubseccionDestinoEquiposAmerica").innerHTML = iconoLoader;
   document.getElementById("tooltipDespieceEquipo").classList.add('hidden');

   const action = "obtenerEquiposAmerica";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;

   document.getElementById("tareasGeneralesEquipo").
      setAttribute('onclick', "obtenerTareas(0); toggleModalTailwind('modalTareasFallas');");

   document.getElementById('reporteEquipos').
      setAttribute('onclick', 'reporteEquipos()');

   // LIMPIA CONTENEDOR
   contenedor.innerHTML = '';

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         console.log(array);
         if (array.length > 0) {
            for (let x = 0; x < array.length; x++) {
               const idEquipo = array[x].idEquipo;
               const equipo = array[x].equipo;
               const tipoEquipo = array[x].tipoEquipo;
               const statusEquipo = array[x].statusEquipo;
               const fallasP = array[x].fallasP;
               const fallasS = array[x].fallasS;
               const mpP = array[x].mpP;
               const mpS = array[x].mpS;
               const ultimoMpFecha = array[x].ultimoMpFecha;
               const ultimoMpSemana = array[x].ultimoMpSemana;
               const proximoMpFecha = array[x].proximoMpFecha;
               const proximoMpSemana = array[x].proximoMpSemana;
               const tareasP = array[x].tareasP;
               const tareasS = array[x].tareasS;
               const testR = array[x].testR;
               const ultimoTestFecha = array[x].ultimoTestFecha;
               const ultimoTestSemana = array[x].ultimoTestSemana;
               const cotizaciones = array[x].cotizaciones;
               const imagenes = array[x].imagenes;
               const comentarios = array[x].comentarios;
               const totalDespiece = array[x].totalDespiece;

               const data = dataEquiposAmerica({
                  idEquipo: idEquipo,
                  equipo: equipo,
                  tipoEquipo: tipoEquipo,
                  statusEquipo: statusEquipo,
                  fallasP: fallasP,
                  fallasS: fallasS,
                  mpP: mpP,
                  mpS: mpS,
                  ultimoMpFecha: ultimoMpFecha,
                  ultimoMpSemana: ultimoMpSemana,
                  proximoMpFecha: proximoMpFecha,
                  proximoMpSemana: proximoMpSemana,
                  tareasP: tareasP,
                  tareasS: tareasS,
                  testR: testR,
                  ultimoTestFecha: ultimoTestFecha,
                  ultimoTestSemana: ultimoTestSemana,
                  cotizaciones: cotizaciones,
                  imagenes: imagenes,
                  comentarios: comentarios,
                  totalDespiece: totalDespiece
               });

               contenedor.insertAdjacentHTML('beforeend', data);
            }
         } else {
            alertaImg('Sin Equipos/Locales', '', 'info', 1500);
         }
      })
      .then(function () {
         const URL2 = `php/select_REST_planner.php?action=DestinoSeccionSubseccionEquipo&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&idEquipo=0&tipoPendiente=''`;
         fetch(URL2)
            .then(array => array.json())
            .then(array => {
               document.getElementById("seccionSubseccionDestinoEquiposAmerica").
                  innerHTML = array.seccion + ' - ' + array.subseccion + ' - ' + array.destino;
            }).catch(function (err) {
               fetch(APIERROR + err + ': (obtenerEquiposAmerica 1)')
               document.getElementById("seccionSubseccionDestinoEquiposAmerica").innerHTML = '';
            })
      })
      .then(function () {
         obtenerTodosPendientes();
      })
      .catch(function (err) {
         document.getElementById("seccionSubseccionDestinoEquiposAmerica").innerHTML = '';
         contenedor.innerHTML = '';
         alertaImg('No se Encontraron Equipos/Locales', '', 'info', 1500);
         fetch(APIERROR + err + ': (obtenerEquiposAmerica 2)');
      });
}


// OBTIENE TODOS LOS PENDIENTES DE  DESTINO->SECCIÓN->SUBSECCIÓN
function obtenerTodosPendientes() {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem("idSubseccion");

   let tg = document.getElementById("totalesTareasGenerales");
   let preventivos = document.getElementById("totalesPreventivos");
   let test = document.getElementById("totalesTest");
   let fallas = document.getElementById("totalesFallas");
   let tareas = document.getElementById("totalesTareas");

   tg.innerHTML = '<i class="text-white fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   preventivos.innerHTML = '<i class="text-blue-300 fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   test.innerHTML = '<i class="text-indigo-300 fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   fallas.innerHTML = '<i class="text-red-300 fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   tareas.innerHTML = '<i class="text-orange-300 fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

   setTimeout(function () {

   }, 1100);

   const action = "obtenerTodosPendientes";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {
            fallas.innerHTML = `
               <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
               </div>
               <h1 class="text-red-400">${array.fallasP}</h1>
               <h1 class=" text-green-400 text-xs font-semibold">${array.fallasS}</h1>
            `;

            tareas.innerHTML = `
               <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
               </div>
               <h1 class="text-red-400">${array.tareasP}</h1>
               <h1 class=" text-green-400 text-xs font-semibold">${array.tareasS}</h1>
            `;

            preventivos.innerHTML = `
               <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
               </div>
               <h1 class="text-red-400">${array.mpP}</h1>
               <h1 class=" text-green-400 text-xs font-semibold">${array.mpS}</h1>
            `;

            test.innerHTML = `
               <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
               </div>
               <h1 class=" text-white text-xs font-semibold py-1">${array.test}</h1>
            `;

            tg.innerHTML = `
               <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
               </div>
               <h1 class="text-red-400">${array.tareasGP}</h1>
               <h1 class=" text-green-400 text-xs font-semibold">${array.tareasGS}</h1>
            `;

         }
      })
}

// FUNCION UNIVERSAL PARA LA TABLA #dataPendientesX
// EVENTO PARA BUSCAR PROYECTOS EN LA TABLA
document.getElementById("palabraFallaTarea").addEventListener('keyup', function () {
   buscadorTabla('dataPendientesX', 'palabraFallaTarea', 0);
});

// EVENTO PARA BUSCAR PROYECTOS EN LA TABLA
document.getElementById("palabraEquipoAmerica").addEventListener('keyup', function () {
   buscadorTabla('contenedorEquiposAmerica', 'palabraEquipoAmerica', 0);
});



// FUNCIONES PARA GENERAR REPORTES
function reporteEquipos() {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem("idSubseccion");

   const action = "reporteEquipos";
   const URL = `php/exportar_excel_GET.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;
   window.location = URL;
   setTimeout(() => {
      alertaImg('Generando Reporte...', '', 'success', 1500);
   }, 820);
}

function reporteFallas(idEquipo) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "reporteFallas";
   const URL = `php/exportar_excel_GET.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;
   window.location = URL;
   setTimeout(() => {
      alertaImg('Generando Reporte...', '', 'success', 1500);
   }, 820);
}

function reporteTareas(idEquipo) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem("idSubseccion");

   const action = "reporteTareas";
   const URL = `php/exportar_excel_GET.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;
   window.location = URL;
   setTimeout(() => {
      alertaImg('Generando Reporte...', '', 'success', 1500);
   }, 820);
}


document.getElementById("statusMaterial").addEventListener('click', function () {
   alertaImg('Ingrese Código cod2bend', '', 'info', 2000);
});


// FUNCIÓN PARA RESALTAR STATUS APLICADOS (TAREAS, FALLAS, PREVENTIVOS, PROYECTOS)
function estiloModalStatus(idRegistro, tipoRegistro) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "obtenerStatus";
   const URL = `php/select_REST_planner.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idRegistro=${idRegistro}&tipoRegistro=${tipoRegistro}`;

   document.getElementById("statusenergeticostoggle").classList.add('hidden');
   document.getElementById("statusdeptoggle").classList.add('hidden');
   document.getElementById("statusMaterialCod2bend").classList.add('hidden');
   document.getElementById("statusMaterialCod2bend").classList.add('hidden');
   document.getElementById("statusbitacoratoggle").classList.add('hidden');
   document.getElementById("btnEditarTituloXtoggle").classList.add('hidden');

   let sMaterialX = document.getElementById("statusMaterial");
   let sTrabajareX = document.getElementById("statusTrabajare");
   let sCalidadX = document.getElementById("statusCalidad");
   let sComprasX = document.getElementById("statusCompras");
   let sDireccionX = document.getElementById("statusDireccion");
   let sFinanzasX = document.getElementById("statusFinanzas");
   let sRRHHX = document.getElementById("statusRRHH");
   let sElectricidadX = document.getElementById("statusElectricidad");
   let sAguaX = document.getElementById("statusAgua");
   let sDieselX = document.getElementById("statusDiesel");
   let sGasX = document.getElementById("statusGas");
   let sEnergeticosX = document.getElementById("statusenergeticos");
   let sDepartamentosX = document.getElementById("statusdep");
   let sGPX = document.getElementById("statusGP");
   let sTRSX = document.getElementById("statusTRS");
   let sZIX = document.getElementById("statusZI");
   let statusbitacoraX = document.getElementById("statusbitacora");

   sMaterialX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs";

   sTrabajareX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-blue-500 bg-gray-200 hover:bg-blue-200 text-xs";

   sCalidadX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

   sComprasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

   sDireccionX.className = "w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

   sFinanzasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

   sRRHHX.className = "w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

   sElectricidadX.className = "w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

   sAguaX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

   sDieselX.className = "w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

   sGasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

   sEnergeticosX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs";

   sDepartamentosX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs";

   sGPX.className = "w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs";

   sTRSX.className = "w-full text-center h-8  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs";

   sZIX.className = "w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs";

   statusbitacoraX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs";

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array[0]) {

            if (array[0].sMaterial == 1) {
               sMaterialX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-orange-500 bg-gray-200 bg-orange-200 text-xs";
            }

            if (array[0].sTrabajare == 1) {
               sTrabajareX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-blue-500 bg-gray-200 bg-blue-200 text-xs";
            }

            if (array[0].sCalidad == 1) {
               sCalidadX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
            }

            if (array[0].sCompras == 1) {
               sComprasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
            }

            if (array[0].sDireccion == 1) {
               sDireccionX.className = "w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
            }

            if (array[0].sFinanzas == 1) {
               sFinanzasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
            }

            if (array[0].sRRHH == 1) {
               sRRHHX.className = "w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
            }

            if (array[0].sElectricidad == 1) {
               sElectricidadX.className = "w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
            }

            if (array[0].sAgua == 1) {
               sAguaX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
            }

            if (array[0].sDiesel == 1) {
               sDieselX.className = "w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
            }

            if (array[0].sGas == 1) {
               sGasX.className = "w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
            }

            if (array[0].sEnergeticos > 0) {
               sEnergeticosX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-yellow-500 bg-gray-200 bg-yellow-200 text-xs";
            }

            if (array[0].sDepartamentos > 0) {
               sDepartamentosX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-teal-500 bg-gray-200 bg-teal-200 text-xs";
            }

            if (array[0].bitacoraGP > 0) {
               sGPX.className = "w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-lightblue-500 bg-gray-200 bg-lightblue-50 text-xs";
            }

            if (array[0].bitacoraTRS > 0) {
               sTRSX.className = "w-full text-center h-8  cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-lightblue-500 bg-gray-200 bg-lightblue-50 text-xs";
            }

            if (array[0].bitacoraZI > 0) {
               sZIX.className = "w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-lightblue-500 bg-gray-200 bg-lightblue-50 text-xs";
            }

            if (array[0].bitacoraGP > 0 || array[0].bitacoraTRS > 0 || array[0].bitacoraZI > 0) {
               statusbitacoraX.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center shadow-md shadow-md text-gray-500 text-lightblue-500 bg-gray-200 bg-lightblue-50 text-xs";
            }

            if (array[0].titulo) {
               document.getElementById("editarTitulo").value = array[0].titulo;
            } else {
               document.getElementById("editarTitulo").value = '';
            }

            if (array[0].cod2bend) {
               document.getElementById("inputCod2bend").value = array[0].cod2bend;
            } else {
               document.getElementById("inputCod2bend").value = '';
            }
         }

      })
      .catch(function (err) {
         fetch(APIERROR + err + ': (estiloModalStatus)');
      })
}


// OBTIENE LOS PENDIENTES DE LOS USUARIOS EN LAS COLUMNAS PRINCIPALES DE PLANNER
function obtenerPendientesUsuario() {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let contenedor = document.getElementById("dataPendientesUsuario");
   const action = "obtenerPendientesUsuario";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   document.getElementById("loadPendientes").innerHTML = iconoLoader;

   fetch(URL)
      .then(array => array.json())
      .then(array => {

         contenedor.innerHTML = '';

         if (array) {
            document.getElementById("totalPendientesFallas").
               innerHTML = `Incidencia (${array.totalFallas})`;
            document.getElementById("totalPendientesTareas").
               innerHTML = `Tareas (${array.totalTareasX})`;
            document.getElementById("totalPendientesPDA").
               innerHTML = `Proyectos (${array.totalProyectos})`;

            if (array.pendientes) {
               for (let x = 0; x < array.pendientes.length; x++) {
                  const idPendiente = array.pendientes[x].idPendiente;
                  const tipoPendiente = array.pendientes[x].tipoPendiente;
                  const seccion = array.pendientes[x].seccion;
                  const actividad = array.pendientes[x].actividad;
                  let fVerEnPlanner = '';

                  if (tipoPendiente == 'TAREA' || tipoPendiente == 'TAREAGENERAL') {
                     fVerEnPlanner = `onclick="verEnPlanner('TAREA', ${idPendiente}); toggleModalTailwind('modalVerEnPlanner');"`;
                  } else if (tipoPendiente == 'INCIDENCIA') {
                     fVerEnPlanner = `onclick="verEnPlanner('${tipoPendiente}', ${idPendiente}); toggleModalTailwind('modalVerEnPlanner');"`;
                  } else if (tipoPendiente == 'PLANACCION') {
                     fVerEnPlanner = `onclick="verEnPlanner('${tipoPendiente}', ${idPendiente}); toggleModalTailwind('modalVerEnPlanner');"`;
                  }

                  const codigo = `
                        <div class="misPendientes_ hidden p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center misPendientes_${tipoPendiente}"
                        ${fVerEnPlanner}>
                           <h1 class="truncate mr-2" data-title="${actividad}">
                              ${seccion + ' - ' + tipoPendiente + ' - ' + actividad}
                           </h1>
                           <div class="flex-none bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                              <h1>1</h1>
                           </div>
                        </div>   
                     `;

                  contenedor.insertAdjacentHTML('beforeend', codigo);
               }
            } else {
               alertaImg('Sin Pendientes', '', 'success', 3000);
            }

         }
      })
      .then(() => {
         document.getElementById("loadPendientes").innerHTML = '';
      })
      .catch(function (err) {
         fetch(APIERROR + err + ': (obtenerPendientesUsuario) ' + idUsuario);
         document.getElementById("loadPendientes").innerHTML = '';
         contenedor.innerHTML = '';
      })
}

// EVENTOS PARA COLUMNA DE MIS PENDIETES
document.getElementById("misPendientesIncidencias").addEventListener("click", () => {
   let array = document.getElementsByClassName("misPendientes_");
   for (let x = 0; x < array.length; x++) {

      if (document.getElementsByClassName("misPendientes_")[x]) {
         const elemento = document.getElementsByClassName("misPendientes_")[x];
         if (elemento.classList.contains("misPendientes_INCIDENCIA")) {
            elemento.classList.remove('hidden');
         } else {
            elemento.classList.add('hidden');
         }
      }
   }
})

document.getElementById("misPendientesTareas").addEventListener("click", () => {
   let array = document.getElementsByClassName("misPendientes_");
   for (let x = 0; x < array.length; x++) {

      if (document.getElementsByClassName("misPendientes_")[x]) {
         const elemento = document.getElementsByClassName("misPendientes_")[x];
         if (elemento.classList.contains("misPendientes_TAREA") || elemento.classList.contains("misPendientes_TAREAGENERAL")) {
            elemento.classList.remove('hidden');
         } else {
            elemento.classList.add('hidden');
         }
      }
   }
})


document.getElementById("misPendientesPDA").addEventListener("click", () => {
   let array = document.getElementsByClassName("misPendientes_");
   for (let x = 0; x < array.length; x++) {

      if (document.getElementsByClassName("misPendientes_")[x]) {
         const elemento = document.getElementsByClassName("misPendientes_")[x];
         if (elemento.classList.contains("misPendientes_PLANACCION")) {
            elemento.classList.remove('hidden');
         } else {
            elemento.classList.add('hidden');
         }
      }
   }
})


// FUNCION PARA AGREGAR TEST A EQUIPO
function obtenerTestEquipo(idEquipo) {
   localStorage.setItem('idEquipo', idEquipo);
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let iconoDefault = '<i class="fad fa-minus text-xl text-red-400"></i>';
   const action = "obtenerTestEquipo";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

   // CONTENEDORES PRINCIPALES
   let estiloSeccion = document.getElementById("estiloSeccionTest");
   let seccion = document.getElementById("seccionTest");
   let equipo = document.getElementById("equipoTest");
   let equipoAfectado = document.getElementById("nombreEquipoTest");
   let contenedor = document.getElementById("dataTestEquipo");

   document.getElementById("btnAgregarTest").setAttribute('onclick', 'agregarTestEquipo();');

   // LIMPIA CONTENEDORES
   estiloSeccion.className = '';
   seccion.innerText = '';
   equipo.innerText = '';
   equipoAfectado.innerText = '';

   fetch(`php/select_REST_planner.php?action=obtenerEDSS&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`)
      .then(array => array.json())
      .then(array => {
         if (array) {
            seccion.innerText = array.seccion;
            equipo.innerText = array.equipo;
            let seccionClass = array.seccion.toLowerCase();
            estiloSeccion.className = seccionClass + '-logo-modal flex justify-center items-center rounded-b-md w-16 h-10 shadow-xs bg-indigo-400';
            equipoAfectado.innerText = array.equipo;
         }

         fetch(URL)
            .then(array => array.json())
            .then(array => {
               contenedor.innerHTML = '';
               if (array.test) {
                  for (let x = 0; x < array.test.length; x++) {
                     const idTest = array.test[x].idTest;
                     const test = array.test[x].test;
                     const creadoPor = array.test[x].creadoPor;
                     const responsable = array.test[x].responsable;
                     const fechaInicio = array.test[x].fechaInicio;
                     const fechaFin = array.test[x].fechaFin;
                     const valor = array.test[x].valor;
                     const medida = array.test[x].medida;
                     let adjuntos = array.test[x].adjuntos;
                     let comentarios = array.test[x].comentarios;

                     if (adjuntos <= 0) {
                        adjuntos = iconoDefault;
                     }

                     if (comentarios <= 0) {
                        comentarios = iconoDefault;
                     }

                     fComentarios = `onclick="toggleModalTailwind('modalComentarios'); obtenerComentariosTest(${idTest})"`;
                     fAdjuntos = `onclick="toggleModalTailwind('modalMedia'); obtenerAdjuntosTest(${idTest});"`;
                     fResponsables = `onclick="toggleModalTailwind('modalUsuarios'); obtenerUsuarios('asignarTest', ${idTest});"`;

                     const codigo = `
                     
                        <tr id="test_${idTest}" class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
           
                           <td class="px-4 border-b border-gray-200 py-3" style="max-width: 360px;">
                              <div class="font-semibold uppercase leading-4" data-title="${test}">
                                 <h1 class="truncate">${test}</h1>
                              </div>
                              <div class="text-gray-500 leading-3 flex">
                                 <h1>Creado por: ${creadoPor}</h1>
                              </div>
                           </td>

                           <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                              <p class="underline font-bold">${valor} </p> ${medida}
                           </td>
                           
                           <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsables}>
                              <h1>${responsable}</h1>
                           </td>

                           <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3">
                              <div class="leading-4">${fechaInicio}</div>
                              <div class="leading-3">${fechaFin}</div>
                           </td>

                           <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fComentarios}>
                              <h1>${comentarios}</h1>
                           </td>

                           <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fAdjuntos}>
                              <h1>${adjuntos}</h1>
                           </td>

                           <td class="hidden whitespace-no-wrap border-b border-gray-200 text-center py-3">
                              <h1><i class="fad fa-minus text-xl text-red-400"></i></h1>
                           </td>

                        </tr>
                     `;
                     contenedor.insertAdjacentHTML('beforeend', codigo);
                  }
               }
            })
            .catch(function (err) {
               fetch(APIERROR + err + `1 agregarTestEquipo(${idEquipo})`);
               contenedor.innerHTML = '';
            })

      })
      .catch(function (err) {
         fetch(APIERROR + err + `2 agregarTestEquipo(${idEquipo})`);
         contenedor.innerHTML = '';
      })
}


// EVENTO PARA BUSCAR EN LA TABLA DE TEST DE EQUIPO
document.getElementById("palabraTest").addEventListener('keyup', function () {
   buscadorTabla('dataTestEquipo', 'palabraTest', 0);
});


// INICIA MODAL PARA AGREGAR TEST
document.getElementById("agregarTest").addEventListener('click', () => {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   document.getElementById("modalAgregarTest").classList.add('open');
   let contenedorUsuarios = document.getElementById("responsableTest");
   let contenedorMedidas = document.getElementById("medidaTest");

   // INICIALIZA FUNCION PARA RANGO DE FECHAS
   rangoFechaX("inputRangoFechaTest");

   // LIMPIA CONTENEDORES
   contenedorUsuarios.innerHTML = '<option value="0">Seleccione Responsable</option>';
   contenedorMedidas.innerHTML = '<option value="0">Seleccione Magnitud</option>';

   fetch(`php/select_REST_planner.php?action=obtenerUsuarios&idDestino=${idDestino}&idUsuario=${idUsuario}`)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idUsuario = array[x].idUsuario;
               const nombre = array[x].nombre;
               const apellido = array[x].apellido;
               const codigo = `<option value="${idUsuario}"> ${nombre + ' ' + apellido}</option>`;
               contenedorUsuarios.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })

   fetch(`php/select_REST_planner.php?action=obtenerUnidadesMedidas&idDestino=${idDestino}&idUsuario=${idUsuario}`)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idMedida = array[x].idMedida;
               const medida = array[x].medida;
               const codigo = `<option value="${idMedida}"> ${medida}</option>`;
               contenedorMedidas.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
})


// FUNCION PARA AGREGAR TEST DE EQUIPO
function agregarTestEquipo() {
   let idDestino = localStorage.getItem('idDestino');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');
   let idUsuario = localStorage.getItem('usuario');
   let idEquipo = localStorage.getItem('idEquipo');

   // VALORES
   let test = document.getElementById("descripcionTest");
   let idMedida = document.getElementById("medidaTest");
   let valor = document.getElementById("valorTest");
   let rangoFecha = document.getElementById("inputRangoFechaTest");
   let responsable = document.getElementById("responsableTest");

   const action = "agregarTestEquipo";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}&test=${test.value}&idMedida=${idMedida.value}&valor=${valor.value}&rangoFecha=${rangoFecha.value}&responsable=${responsable.value}`;

   if (test.value.length > 1 && idMedida.value > 0 && valor.value > 0 && rangoFecha.value.length > 22 && responsable.value > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               obtenerTestEquipo(idEquipo);
               obtenerEquiposAmerica(idSeccion, idSubseccion);
               alertaImg('Test Agregado', '', 'success', 1600);
               document.getElementById("modalAgregarTest").classList.remove('open');
               test.value = '';
               idMedida.value = '';
               valor.value = '';
               rangoFecha.value = '';
               responsable.value = '';
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ' agregarTestEquipo()');
         })
   } else {
      alertaImg('Datos Incorrectos', '', 'info', 1500);
   }
}


// OBTENER COMENTARIOS
function obtenerComentariosTest(idTest) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let contenedor = document.getElementById("dataComentarios");
   const action = "obtenerComentariosTest";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idTest=${idTest}`;

   document.getElementById("btnComentario").
      setAttribute('onclick', `agregarComentariosTest(${idTest})`);

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         contenedor.innerHTML = '';
         if (array.length > 0) {
            for (let x = 0; x < array.length; x++) {
               const idComentario = array[x].idComentario;
               const comentario = array[x].comentario;
               const fecha = array[x].fecha;
               const creadoPor = array[x].creadoPor;
               const codigo = `
                  <div class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                     <div class="flex items-center justify-center" style="width: 48px;">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=creadoPor" width="48" height="48">
                     </div>
                     <div class="flex flex-col justify-start items-start p-2 w-full">
                           <div class="text-xs font-bold flex flex-row justify-between w-full">
                              <div>
                                 <h1>${creadoPor}</h1>
                              </div>
                              <div>
                                 <p class="font-mono ml-2 text-gray-600">${fecha}</p>
                              </div>
                           </div>
                           <div class="text-xs w-full">
                              <p>${comentario}</p>
                           </div>
                     </div>
                  </div>
               `;
               contenedor.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .then(() => {
         let contenedorX = document.getElementById("scrollDataComentarios");
         contenedorX.scrollTop = contenedorX.scrollHeight;
      })
      .catch(function (err) {
         contenedor.innerHTML = '';
         fetch(APIERROR + err + ' obtenerComentariosTest(${idTest})');
      })
}


// AGREGAR COMENTARIOS
function agregarComentariosTest(idTest) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let comentario = document.getElementById("inputComentario");
   const action = "agregarComentariosTest";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idTest=${idTest}&comentario=${comentario.value}`;

   if (comentario.value.length > 1) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               alertaImg('Comentario Agregado', '', 'success', 1500);
               comentario.value = '';
               obtenerComentariosTest(idTest);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ` agregarComentariosTest(${idTest})`);
         })
   } else {
      alertaImg('Intente de Nuevo', '', 'info', 1500);
   }
}


// OBTENER ADJUNTOS DE TEST
function obtenerAdjuntosTest(idTest) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "obtenerAdjuntosTest";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idTest=${idTest}`;

   let contenedorImagenes = document.getElementById("contenedorImagenes");
   let contenedorDocumentos = document.getElementById("contenedorDocumentos");
   let dataImagenes = document.getElementById("dataImagenes");
   let dataAdjuntos = document.getElementById("dataAdjuntos");
   let cargandoAdjunto = document.getElementById("cargandoAdjunto");

   contenedorImagenes.classList.add('hidden');
   contenedorDocumentos.classList.add('hidden');
   dataImagenes.innerHTML = '';
   dataAdjuntos.innerHTML = '';
   cargandoAdjunto.innerHTML = iconoLoader;

   document.getElementById("inputAdjuntos").
      setAttribute('onchange', `agregarAdjuntoTest(${idTest})`);

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {

            // IMAGENES
            if (array.imagenes) {
               contenedorImagenes.classList.remove('hidden');
               for (let x = 0; x < array.imagenes.length; x++) {
                  const idAdjunto = array.imagenes[x].idAdjunto;
                  const url = array.imagenes[x].url;
                  const subidoPor = array.imagenes[x].subidoPor;
                  const fecha = array.imagenes[x].fecha;
                  const tipo = array.imagenes[x].tipo;
                  const codigo = `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative">
                        <a href="planner/test/${url}" target="_blank" data-title="${url}">
                           <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer hover:shadow-2xl" style="background-image: url(planner/test/${url})">
                           </div>
                        </a>
                        
                        <div class="w-full absolute text-transparent hover:text-red-700" style="bottom: 12px; left: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'TEST');">
                           <i class="fas fa-trash-alt fa-2x" data-title="Clic para Eliminar"></i>
                        </div>
                     </div>
                  `;
                  dataImagenes.insertAdjacentHTML('beforeend', codigo);
               }
            }

            // ADJUNTOS
            if (array.documentos) {
               contenedorDocumentos.classList.remove('hidden');
               for (let x = 0; x < array.documentos.length; x++) {
                  const idAdjunto = array.documentos[x].idAdjunto;
                  const url = array.documentos[x].url;
                  const subidoPor = array.documentos[x].subidoPor;
                  const fecha = array.documentos[x].fecha;
                  const tipo = array.documentos[x].tipo;
                  const codigo = `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative">

                        <a href="planner/test/${url}" target="_blank">
                           <div class="hover:placeholder-gray-500 w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                              <i class="fad fa-file-alt fa-3x"></i>
                              <p class="text-sm font-normal ml-2">${url}</p>
                           </div>
                        </a>
                        
                        <div class="absolute text-red-700" style="bottom: 22px; right: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'TEST');">
                           <i class="fas fa-trash-alt fa-2x"></i>
                        </div>

                     </div>
                  `;
                  dataAdjuntos.insertAdjacentHTML('beforeend', codigo);
               }
            }

         }
      })
      .then(() => {
         cargandoAdjunto.innerHTML = '';
      })
      .catch(function (err) {
         fetch(APIERROR + err + `obtenerAdjuntosTest(${idTest})`);
         dataImagenes.innerHTML = '';
         dataAdjuntos.innerHTML = '';
         cargandoAdjunto.innerHTML = '';
      })
}


// AGREGAR ADJUNTO A TEST
function agregarAdjuntoTest(idTest) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idEquipo = localStorage.getItem('idEquipo');
   let cargandoAdjunto = document.getElementById("cargandoAdjunto");
   cargandoAdjunto.innerHTML = iconoLoader;

   const action = "agregarAdjuntoTest";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idTest=${idTest}`;

   // VARIABLES DEL ADJUNTO
   const files = document.querySelector("#inputAdjuntos");
   const formData = new FormData()

   if (files.files) {
      for (let x = 0; x < files.files.length; x++) {
         formData.append('file', files.files[x]);

         fetch(URL, {
            method: "POST",
            body: formData
         })
            .then(array => array.json())
            .then(array => {
               if (array == 1) {
                  obtenerTestEquipo(idEquipo);
                  obtenerAdjuntosTest(idTest);
                  alertaImg('Adjunto Agregado', '', 'success', 1500);
               } else {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
               }
            })
            .then(() => {
               cargandoAdjunto.innerHTML = '';
               files.value = '';
            })
            .catch(function (err) {
               fetch(APIERROR + err + ` agregarAdjuntoTest(${idTest})`)
               cargandoAdjunto.innerHTML = '';
               alertaImg('Intente de Nuevo', '', 'info', 1500);
               files.value = '';
            })
      }
   }
}


// FUNCION PARA OBTENER LOS PENDIENTES DE ENERGETICOS
function obtenerEnergeticos(idSeccion, idSubseccion) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let contenedor = document.getElementById("dataEnergeticos");

   const action = 'obtenerEnergeticos';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {

         contenedor.innerHTML = '';

         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idEnergetico = array[x].idEnergetico;
               const actividad = array[x].actividad;
               const creadoPor = array[x].creadoPor;
               const responsable = array[x].responsable;
               const fechaInicio = array[x].fechaInicio;
               const fechaFin = array[x].fechaFin;
               const status = array[x].status;
               const statusTrabajare = array[x].statusTrabajare;
               const sUrgente = array[x].sUrgente;
               const sDepartamentos = array[x].sDepartamentos;
               const sEnergeticos = array[x].sEnergeticos;
               const adjuntos = array[x].adjuntos
               const comentarios = array[x].comentarios;

               if (adjuntos > 0) {
                  adjuntosX = adjuntos;
               } else {
                  adjuntosX = iconoDefault;
               }

               if (comentarios > 0) {
                  comentariosX = comentarios;
               } else {
                  comentariosX = iconoDefault;
               }

               const codigo = `
                  <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
           
                     <td class="px-4 border-b border-gray-200 py-3" style="max-width: 360px;">
                        <div class="font-semibold uppercase leading-4" data-title="${actividad}">
                           <h1 class="truncate">${actividad} </h1>
                        </div>
                        <div class="text-gray-500 leading-3 flex">
                           <h1>Creado por: ${creadoPor}</h1>
                        </div>
                     </td>

                     <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" data-test="${responsable}">
                        <h1>${responsable}</h1>
                     </td>

                     <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3">
                        <div class="leading-4">${fechaInicio}</div>
                        <div class="leading-3">${fechaFin}</div>
                     </td>

                     <td class=" whitespace-no-wrap border-b border-gray-200 text-center py-3">
                        <h1>${adjuntosX}</h1>
                     </td>

                     <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3">
                        <h1>${comentariosX}</h1>
                     </td>

                     <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3">
                        <div class="px-2">
                           <i class="fas fa-ellipsis-h  text-lg"></i>
                        </div>
                     </td>

                  </tr>
               `;
               contenedor.insertAdjacentHTML('beforeend', codigo);
            }

         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ``);
         contenedor.innerHTML = '';
      })
}


// ELIMINAR ADJUNTOS (TIPO DE ADJUNTO + IDADJUNTO)
function eliminarAdjunto(idAdjunto, tipoAdjunto) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idEquipo = localStorage.getItem('idEquipo');
   let idProyecto = localStorage.getItem('idProyecto');
   let idSeccion = localStorage.getItem('idSeccion');

   const action = 'eliminarAdjunto';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idAdjunto=${idAdjunto}&tipoAdjunto=${tipoAdjunto}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array == 1) {
            alertaImg('Adjunto Eliminado', '', 'success', 1500);

            // ELIMINA ADJUNTO DEL CONTENEDOR
            if (document.getElementById("modalMedia_adjunto_img_" + idAdjunto)) {
               document.getElementById("modalMedia_adjunto_img_" + idAdjunto).innerHTML = '';
            } else {
               alertaImg('Cierre la Ventana para Aplicar los Cambios', '', 'info', 1500);
            }

            // ACTUALIZA DATOS
            if (tipoAdjunto == "FALLA") {
               obtenerFallas(idEquipo);
            } else if (tipoAdjunto == "TAREA") {
               obtenerTareas(idEquipo);
            } else if (tipoAdjunto == "PLANACCION") {
               obtenerPlanaccion(idProyecto);
            } else if (tipoAdjunto == "COTIZACIONPROYECTO") {
               obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (tipoAdjunto == "TEST") {
               obtenerTestEquipo(idEquipo);
            }

         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1500);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ` eliminarAdjuntos(${idAdjunto}, ${tipoAdjunto})`);
      })
}


// TRANFIERE EQUIPOS DE LA TABLA T_EQUIPOS -> T_EQUIPOS_AMERICA, POR DESTINO
function exportarEquipos(idDestino) {
   let idUsuario = localStorage.getItem('usuario');
   const action = "exportarEquipos";
   const URL = `php/update_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   const URLConfirmado = `php/update_REST_planner.php?action=exportarEquiposConfirmado&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array.totalEquipos == 0) {
            alertify.confirm("Exportar Equipos a la Versión 3.0",
               function () {
                  alertaImg('Exportando Equipos...', '', 'success', 1300);
                  fetch(URLConfirmado)
                     .then(array => array.json())
                     .then(array => {

                        var codigo = '';
                        for (let x = 0; x < array.equipo.length; x++) {
                           const id = array.equipo[x].id;
                           const status = array.equipo[x].status;
                           codigo += `<p>Id Equipo: ${id} Status: ${status}</p>`;
                        }
                        alertify.minimalDialog || alertify.dialog('minimalDialog', function () {
                           return {
                              main: function (content) {
                                 this.setContent(content);
                              }
                           };
                        })
                        alertify.minimalDialog(`
                           Total: ${array.totalEquipos} 
                           <br>
                           Total Exportados: ${array.totalExportados} <br><br>
                           ${codigo}
                        `);
                     })
                     .catch(function (err) {
                        fetch(APIERROR + err + ': (exportarEquipos)');
                     })

               },
               function () {
                  alertaImg('Exportación Cancelada', '', 'error', 1300);
               })
               .set({ title: "EQUIPOS" })
               .set({ labels: { ok: 'Exportar', cancel: 'Cancelar' } });
         } else {
            alertaImg('Conflicto ID de Equipos', '', 'error', 1300);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ': (exportarEquipos)');
      })
}


// 
function actualizarTareasequipos() {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = 'actualizarTareasequipos';
   const URL = `php/update_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   fetch(URL)
      .then(array => array.json())
      .then(array => {
      })
      .catch(function (err) {
         fetch(APIERROR + err + `actualizarTareasequipos()`);
      })
}

// EXPORTAR TAREAS GENERALES POR DESTINO
function exportarTareasGenerales(idDestino) {
   let idUsuario = localStorage.getItem('usuario');
   const action = 'exportarTareasGenerales';
   const URL = `php/update_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array == 1) {
            alertaImg('Tareas exportadas', '', 'success', 1500);
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1500);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ``);
      })
}


window.addEventListener('load', () => {
   let idDestino = localStorage.getItem("idDestino");
   comprobarSession();
   obtenerDatosUsuario(idDestino);
   obtenerPendientesUsuario();
});


// FUNCIÓN EJECUTADA CADA 60s PARA ACTUALILZAR PENDIENTES DE LOS USUARIOS
setInterval(function () {
   alertaImg('Pendientes Actualizados', '', 'success', 500);
   obtenerPendientesUsuario();
   // comprobarSession();
}, 180000);


// CONTADOR DE CARACTERES EN #editarTitulo
document.getElementById("editarTitulo").addEventListener('keydown', event => {
   if (event.keyCode > 47 && event.keyCode < 91) {
      if (document.getElementById('editarTitulo').value.length >= 60) {
         alertaImg('60 Caracteres como Máximo', '', 'info', 500);
      }
   }
})


// FUNCIONES PARA ANIMACION DE MOVER ELEMENTOS
let sortableImagenesX = document.getElementById("dataImagenes");
let sortableDocumentosX = document.getElementById("dataAdjuntos");
new Sortable(sortableImagenesX, {
   animation: 1000,
   ghostClass: 'blue-background-class'
});
new Sortable(sortableDocumentosX, {
   animation: 1000,
   ghostClass: 'blue-background-class'
});


btnModalAgregarIncidencias.addEventListener('click', () => {
   abrirmodal("modalAgregarIncidencias");
   rangoFechaX('rangoFechaIncidencia');

   //LIMPIAR CONTENIDO 
   descripcionIncidencia.value = '';
   responsablesIncidencias.value = 0;
   comentarioIncidencia.value = '';
   equipoLocalIncidencias.value = 0;

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   seccionIncidencias.innerHTML = '<option value="0">Seleccione</option>';
   seccionIncidencias.value = 0;

   // DESBLOQUEA INPUTS
   seccionIncidencias.removeAttribute('disabled');
   subseccionIncidencias.removeAttribute('disabled');
   contenedorEquipoLocalIncidencias.classList.add('hidden');
   btnTGIncidencias.removeAttribute('disabled', true);
   btnEquipoIncidencias.removeAttribute('disabled', true);
   btnLocalIncidencias.removeAttribute('disabled', true);
   equipoLocalIncidencias.removeAttribute('disabled', true);

   // OBTIENES SECCIONES INICIALES
   const action = "obtenerSeccionesPorDestino";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   fetch(URL)
      .then(array => array.json())
      .then(array => {

         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idSeccion = array[x].idSeccion;
               const seccion = array[x].seccion;
               const codigo = `<option value="${idSeccion}">${seccion}</option>`;

               seccionIncidencias.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })

   // OBTIENES USUARIOS INICIALES
   responsablesIncidencias.innerHTML = '<option value="0">Seleccion Responsable</option>';
   responsablesIncidencias.value = 0;
   const action2 = "obtenerUsuarios";
   const URL2 = `php/select_REST_planner.php?action=${action2}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   fetch(URL2)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idResponsable = array[x].idUsuario;
               const nombre = array[x].nombre;
               const apellido = array[x].apellido;
               const codigo = `<option value="${idResponsable}">${nombre + ' ' + apellido}</option>`;

               responsablesIncidencias.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
});


function iniciarFormularioInicidencias() {
   abrirmodal("modalAgregarIncidencias");
   rangoFechaX('rangoFechaIncidencia');

   //LIMPIAR CONTENIDO 
   descripcionIncidencia.value = '';
   responsablesIncidencias.value = 0;
   comentarioIncidencia.value = '';
   equipoLocalIncidencias.value = 0;

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');
   let idEquipo = localStorage.getItem('idEquipo');

   seccionIncidencias.innerHTML = '<option value="0">Seleccione</option>';
   seccionIncidencias.value = 0;

   // DESBLOQUEA INPUTS
   btnTGIncidencias.classList.remove('hidden');
   btnEquipoIncidencias.classList.remove('hidden');
   btnLocalIncidencias.classList.remove('hidden');

   // ASIGNA VALORES POR DEFAULT

   // OBTIENES SECCIONES INICIALES
   const action = "obtenerSeccionesPorDestino";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   fetch(URL)
      .then(array => array.json())
      .then(array => {

         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idSeccion = array[x].idSeccion;
               const seccion = array[x].seccion;
               const codigo = `<option value="${idSeccion}">${seccion}</option>`;

               seccionIncidencias.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .then(() => {
         seccionIncidencias.value = idSeccion;
      })
      .then(() => {
         const action2 = "obtenerSubseccionPorSeccion";
         const URL2 = `php/select_REST_planner.php?action=${action2}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}`;

         fetch(URL2)
            .then(array => array.json())
            .then(array => {
               if (array) {
                  for (let x = 0; x < array.length; x++) {
                     const idSubseccion = array[x].idSubseccion;
                     const subseccion = array[x].subseccion;
                     const codigo = `<option value="${idSubseccion}">${subseccion}</option>`;
                     subseccionIncidencias.insertAdjacentHTML('beforeend', codigo);
                  }
               }
            })
            .then(() => {
               subseccionIncidencias.value = idSubseccion;
            })
            .catch(function (err) {
               fetch(APIERROR + err);
            })
      })
      .then(() => {
         const URL4 = `php/select_REST_planner.php?action=obtenerEquipoPorId&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`
         console.log(URL4);
         fetch(URL4)
            .then(array => array.json())
            .then(array => {
               console.log(array);
               if (array.local_equipo == "EQUIPO") {
                  btnEquipoIncidencias.click();
               } else {
                  btnLocalIncidencias.click();
               }
            })
      })
      .then(() => {
         const action3 = "obtenerEquipoLocal";
         const URL3 = `php/select_REST_planner.php?action=${action3}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&tipo=EQUIPO`;

         fetch(URL3)
            .then(array => array.json())
            .then(array => {
               if (array) {
                  for (let x = 0; x < array.length; x++) {
                     const idEquipo = array[x].idEquipo;
                     const equipo = array[x].equipo;
                     const codigo = `<option value="${idEquipo}">${equipo}</option>`;
                     equipoLocalIncidencias.insertAdjacentHTML('beforeend', codigo);
                  }
               }
            })
            .then(() => {
               equipoLocalIncidencias.value = idEquipo;
               contenedorEquipoLocalIncidencias.classList.remove('hidden');
               seccionIncidencias.setAttribute('disabled', true);
               subseccionIncidencias.setAttribute('disabled', true);
               btnTGIncidencias.setAttribute('disabled', true);
               btnEquipoIncidencias.setAttribute('disabled', true);
               btnLocalIncidencias.setAttribute('disabled', true);
               equipoLocalIncidencias.setAttribute('disabled', true);
            })
            .catch(function (err) {
               fetch(APIERROR + err);
            })
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })

   // OBTIENES USUARIOS INICIALES
   responsablesIncidencias.innerHTML = '<option value="0">Seleccion Responsable</option>';
   responsablesIncidencias.value = 0;
   const action4 = "obtenerUsuarios";
   const URL4 = `php/select_REST_planner.php?action=${action4}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   fetch(URL4)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idResponsable = array[x].idUsuario;
               const nombre = array[x].nombre;
               const apellido = array[x].apellido;
               const codigo = `<option value="${idResponsable}">${nombre + ' ' + apellido}</option>`;

               responsablesIncidencias.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
}


// BUSCA LAS POSIBLES OBSECCIONES CON LA SECCION
seccionIncidencias.addEventListener('change', () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   subseccionIncidencias.innerHTML = '<option value="0">Seleccione</option>';
   subseccionIncidencias.value = 0;

   const action = "obtenerSubseccionPorSeccion";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${seccionIncidencias.value}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idSubseccion = array[x].idSubseccion;
               const subseccion = array[x].subseccion;
               const codigo = `<option value="${idSubseccion}">${subseccion}</option>`;

               subseccionIncidencias.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
})


btnTGIncidencias.addEventListener('click', () => {
   btnTGIncidencias.classList.add("bg-blue-600");
   btnEquipoIncidencias.classList.remove("bg-blue-600");
   btnLocalIncidencias.classList.remove("bg-blue-600");
   equipoLocalIncidencias.innerHTML = '<option value="0">TG</option>';
   equipoLocalIncidencias.value = 0;
   contenedorEquipoLocalIncidencias.classList.add('hidden');
})

btnEquipoIncidencias.addEventListener('click', () => {
   btnTGIncidencias.classList.remove("bg-blue-600");
   btnEquipoIncidencias.classList.add("bg-blue-600");
   btnLocalIncidencias.classList.remove("bg-blue-600");
   equipoLocalIncidencias.innerHTML = '<option value="0">Seleccione Equipo</option>';
   contenedorEquipoLocalIncidencias.classList.remove('hidden');

   const idSeccion = seccionIncidencias.value;
   const idSubseccion = subseccionIncidencias.value;
   const action = "obtenerEquipoLocal";

   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&tipo=EQUIPO`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idEquipo = array[x].idEquipo;
               const equipo = array[x].equipo;
               const codigo = `<option value="${idEquipo}">${equipo}</option>`;
               equipoLocalIncidencias.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
})

btnLocalIncidencias.addEventListener('click', () => {
   btnTGIncidencias.classList.remove("bg-blue-600");
   btnEquipoIncidencias.classList.remove("bg-blue-600");
   btnLocalIncidencias.classList.add("bg-blue-600");
   equipoLocalIncidencias.innerHTML = '<option value="0">Seleccione Local </option>';
   contenedorEquipoLocalIncidencias.classList.remove('hidden');

   const idSeccion = seccionIncidencias.value;
   const idSubseccion = subseccionIncidencias.value;
   const action = "obtenerEquipoLocal";

   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&tipo=LOCAL`;
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idEquipo = array[x].idEquipo;
               const equipo = array[x].equipo;
               const codigo = `<option value="${idEquipo}">${equipo}</option>`;
               equipoLocalIncidencias.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
})


btnEmergenciaIncidencia.addEventListener('click', () => {

   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnEmergenciaIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-red-600');
})

btnUrgenciaIncidencia.addEventListener('click', () => {

   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnUrgenciaIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-orange-600');
})

btnAlarmaIncidencia.addEventListener('click', () => {

   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnAlarmaIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-yellow-600');
})

btnAlertaIncidencia.addEventListener('click', () => {

   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnAlertaIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-blue-600');
})

btnSeguimientoIncidencia.addEventListener('click', () => {

   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnSeguimientoIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-teal-600');
})


btnAgregarIncidencia.addEventListener('click', () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = seccionIncidencias.value;
   let idSubseccion = subseccionIncidencias.value;
   let descripcion = descripcionIncidencia.value;
   let rangoFecha = rangoFechaIncidencia.value;
   let responsable = responsablesIncidencias.value;
   let comentario = comentarioIncidencia.value;
   let idEquipo = equipoLocalIncidencias.value;

   if (tipo = document.getElementsByClassName("opcionSeleccionadaIncidencia")[0]) {
      let tipo = document.getElementsByClassName("opcionSeleccionadaIncidencia")[0].id;
      tipo =
         tipo == "btnEmergenciaIncidencia" ? 'EMERGENCIA' :
            tipo == "btnUrgenciaIncidencia" ? 'URGENCIA' :
               tipo == "btnAlarmaIncidencia" ? 'ALARMA' :
                  tipo == "btnAlertaIncidencia" ? 'ALERTA' :
                     tipo == "btnSeguimientoIncidencia" ? 'SEGUIMIENTO' :
                        '';
   } else {
      alertaImg('Seleccion el tipo de Incidencia', '', 'info', 1600);
   }

   const action = "agregarIncidencia";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&descripcion=${descripcion}&rangoFecha=${rangoFecha}&responsable=${responsable}&comentario=${comentario}&idEquipo=${idEquipo}&tipo=${tipo}`;
   if (idDestino > 0 && idUsuario > 0 && idSeccion > 0 && idSubseccion > 0 && descripcion.length > 0 && responsable > 0 && tipo != '') {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               alertaImg('Incidencia de Equipo, Agregada', '', 'success', 1600);
               cerrarmodal('modalAgregarIncidencias');
            } else if (array == 2) {
               alertaImg('Incidencia General, Agregada', '', 'success', 1600);
               cerrarmodal('modalAgregarIncidencias');
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1600);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Acomplete la Información Requerida', '', 'info', 1600);
   }
})


btnFlotante.addEventListener('click', () => {
   btnFlotanteOpciones.classList.remove('fadeOutLeft', 'fadeInLeft');

   if (btnFlotante.childNodes[1].classList.contains('fa-plus-circle')) {
      btnFlotanteOpciones.classList.remove('hidden');
      btnFlotanteOpciones.classList.add('fadeInLeft');
      btnFlotante.childNodes[1].classList.remove('fa-plus-circle');
      btnFlotante.childNodes[1].classList.add('fa-times-circle');
   } else {
      btnFlotanteOpciones.classList.add('fadeOutLeft');
      btnFlotante.childNodes[1].classList.remove('fa-times-circle');
      btnFlotante.childNodes[1].classList.add('fa-plus-circle');
      setTimeout(() => {
         btnFlotanteOpciones.classList.add('hidden');
      }, 1000);
   }
})


function consultarPlanes(idDestino) {
   let idUsuario = localStorage.getItem('usuario');

   const action = "obtenerPlanesX";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         fetch(APIERROR + 'PLANES EXPORTADOS');
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
}


// MODAL PARA FORMULARIO DE ENERGETICOS
btnModalAgregarEnergeticos.addEventListener('click', () => {
   abrirmodal('modalAgregarEnergeticos');
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSubseccion = localStorage.getItem('idSubseccion');

   //INICIALIZA VALORES 
   responsableEnergeticos.innerHTML = '<option value="0">Seleccione Responsable</option>';
   responsableEnergeticos.value = 0;
   tituloPendienteEnergeticos.value = '';
   rangoFechaEnergeticos.value = '';
   comentarioEnergeticos.value = '';

   fetch(`php/select_REST_planner.php?action=obtenerUsuarios&idDestino=${idDestino}&idUsuario=${idUsuario}`)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const id = array[x].idUsuario;
               const nombre = array[x].nombre;
               const apellido = array[x].apellido;
               const codigo = `<option value="${id}">${nombre + apellido}</option>`;
               responsableEnergeticos.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })

   fetch(`php/select_REST_planner.php?action=DestinoSeccionSubseccionEquipo&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=0&idEquipo=0&tipoPendiente=0&idSubseccion=${idSubseccion}`)
      .then(array => array.json())
      .then(array => {
         if (array) {
            nombreSubseccionEnergeticos.innerText = array.subseccion;
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
})


btnAgregarEnergeticos.addEventListener('click', () => {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');

   const action = "agregarEnergetico";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&titulo=${tituloPendienteEnergeticos.value}&rangoFecha=${rangoFechaEnergeticos.value}&responsable=${responsableEnergeticos.value}&comentario=${comentarioEnergeticos.value}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;
   console.log(URL);
   if (tituloPendienteEnergeticos.value != "" && rangoFechaEnergeticos.value != "" && responsableEnergeticos.value > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            console.log(array)
            if (array == 1 || array == 2) {
               alertaImg('Pendiente Agregado', '', 'success', 1500);
               cerrarmodal('modalAgregarEnergeticos');
               obtenerEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
               obtenerDatosUsuario(idDestino);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Acomplete la Información Requerida', '', 'info', 1500);
   }
})

// BUSCADOR PARA TABLA DE ENERGETICOS
palabraEnergeticos.addEventListener('keyup', () => {
   buscadorTabla('dataEnergeticos', 'palabraEnergeticos', 0);
})