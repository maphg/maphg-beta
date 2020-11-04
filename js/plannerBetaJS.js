// VARIABLES GLOBALES, (VALOR ESTATICO AL CARGAR LA PAGINA)
let idUsuario = localStorage.getItem("usuario");
let idDestino = localStorage.getItem("idDestino");
// VARIABLES GLOBALES, (VALOR ESTATICO AL CARGAR LA PAGINA)

// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

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
   });
}


// Función autoCall.
(() => {
   let idDestino = localStorage.getItem("idDestino");
   obtenerDatosUsuario(idDestino);
})();


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
      alertaImg("Acceso Denegado en: " + nombreCol, "", "warning", 2000);
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

   }

   if (document.getElementById("colzhp")) {
      document.getElementById("colzhp").classList.add("hidden");
      document.getElementById("btn-zia").classList.remove("btn-activo");
   }

   if (document.getElementById("coldep")) {
      document.getElementById("coldep").classList.add("hidden");
      document.getElementById("btn-zhp").classList.remove("btn-activo");
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
         calendarioSecciones();
      },
   });
}


// Obtiene los pendientes de las secciones mediante la seccion seleccionada y el destinol.
function pendientesSubsecciones(
   idSeccion,
   tipoPendiente,
   nombreSeccion,
   idUsuario,
   idDestino
) {
   document.getElementById("dataOpcionesSubseccionestoggle").innerHTML = "";
   document.getElementById("modalPendientes").classList.add("open");
   document.getElementById("estiloSeccion").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   // document.getElementById("modalTituloSeccion").innerHTML = nombreSeccion;
   document.getElementById("dataSubseccionesPendientes").innerHTML =
      "Obteniendo Datos...";

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
      '<i class="fas fa-spinner fa-pulse fa-2x fa-fw" ></i > ';
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
   document.getElementById("seccionMCN").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   document.getElementById("dataPendientes").innerHTML = "";
   document.getElementById("tipoPendiente").innerHTML = "FALLA";
   document.getElementById("agregarPendiente").innerHTML = "Agregar Falla";
   document
      .getElementById("btnAgregarPendiente")
      .setAttribute("onclick", "datosModalAgregarMC()");

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
         // Llama a la Función para reflejar los cambios en los MC por Equipo.

         // Status
         document
            .getElementById("statusUrgente")
            .setAttribute("onclick", data.dataStatusUrgente);
         document
            .getElementById("statusMaterial")
            .setAttribute("onclick", data.dataStatusMaterial);
         document
            .getElementById("statusTrabajare")
            .setAttribute("onclick", data.dataStatusTrabajare);
         // Status Departamento.
         document
            .getElementById("statusCalidad")
            .setAttribute("onclick", data.dataStatusCalidad);
         document
            .getElementById("statusCompras")
            .setAttribute("onclick", data.dataStatusCompras);
         document
            .getElementById("statusDireccion")
            .setAttribute("onclick", data.dataStatusDireccion);
         document
            .getElementById("statusFinanzas")
            .setAttribute("onclick", data.dataStatusFinanzas);
         document
            .getElementById("statusRRHH")
            .setAttribute("onclick", data.dataStatusRRHH);
         // Status Energéticos.
         document
            .getElementById("statusElectricidad")
            .setAttribute("onclick", data.dataStatusElectricidad);
         document
            .getElementById("statusAgua")
            .setAttribute("onclick", data.dataStatusAgua);
         document
            .getElementById("statusDiesel")
            .setAttribute("onclick", data.dataStatusDiesel);
         document
            .getElementById("statusGas")
            .setAttribute("onclick", data.dataStatusGas);
         // Finalizar MC.
         document
            .getElementById("statusFinalizar")
            .setAttribute("onclick", data.dataStatus);
         // Activo MC.
         document
            .getElementById("statusActivo")
            .setAttribute("onclick", data.dataStatusActivo);
         // Titulo MC.
         document
            .getElementById("btnEditarTitulo")
            .setAttribute("onclick", data.dataStatusTitulo);
         document.getElementById("inputEditarTitulo").value = data.dataTituloMC;
      },
   });
}


// Función para actualizar Status t_mc.
function actualizarStatusMC(idMC, status, valorStatus) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let tituloMC = document.getElementById("inputEditarTitulo").value;
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
      },
      // dataType: "JSON",
      success: function (data) {
         if (data == 1) {
            alertaImg("Información Actualizada", "", "success", 2000);
            if (status == "activo" || status == "status") {
               llamarFuncionX("obtenerEquipos");
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
   document.getElementById("seccionMCF").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
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
               llamarFuncionX("obtenerEquipos");
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
               alertaImg("Intente de Nuevo", "", "question", 900);
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
   document.getElementById("dataUsuarios").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

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
function asignarUsuario(idUsuarioSeleccionado, tipoAsginacion, idItem) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   const action = "asignarUsuario";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idUsuarioSeleccionado: idUsuarioSeleccionado,
         idDestino: idDestino,
         tipoAsginacion: tipoAsginacion,
         idItem: idItem,
      },
      // dataType: "JSON",
      success: function (data) {

         if (data == "MC") {
            alertaImg("Responsable Actualizado", "", "success", 2500);
            document.getElementById("modalUsuarios").classList.remove("open");
            let idEquipo = localStorage.getItem("idEquipo");
            obtenerFallas(idEquipo);

            // TAREAS
         } else if (data == "TAREA") {
            alertaImg("Responsable Actualizado", "", "success", 2500);
            document.getElementById("modalUsuarios").classList.remove("open");
            let idEquipo = localStorage.getItem("idEquipo");
            obtenerTareas(idEquipo);
         } else {
            alertaImg("Intenete de Nuevo", "", "question", 2500);
         }
      },
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

   document.getElementById("dataImagenes").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   document.getElementById("dataAdjuntos").classList.add("justify-center");

   document.getElementById("dataAdjuntos").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
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
   document.getElementById("seccionMCN").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
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
   document.getElementById("seccionMCF").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
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

   document.getElementById("dataImagenes").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   document.getElementById("dataAdjuntos").classList.add("justify-center");

   document.getElementById("dataAdjuntos").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
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
   document.getElementById("dataComentarios").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

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
   document.getElementById("modalStatus").classList.add("open");
   localStorage.setItem("idTarea", idTarea);

   // La función actulizarTarea(), recibe 3 parametros idTarea, columna a modificar y el tercer parametro solo funciona para el titulo por ahora

   // Status
   document
      .getElementById("statusUrgente")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "status_urgente", 0)'
      );
   document
      .getElementById("statusMaterial")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "status_material", 0)'
      );
   document
      .getElementById("statusTrabajare")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "status_trabajando", 0)'
      );

   // Status Departamento.
   document
      .getElementById("statusCalidad")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "departamento_calidad", 0)'
      );
   document
      .getElementById("statusCompras")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "departamento_compras", 0)'
      );
   document
      .getElementById("statusDireccion")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "departamento_direccion", 0)'
      );
   document
      .getElementById("statusFinanzas")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "departamento_finanzas", 0)'
      );
   document
      .getElementById("statusRRHH")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "departamento_rrhh", 0)'
      );

   // Status Energéticos.
   document
      .getElementById("statusElectricidad")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "energetico_electricidad", 0)'
      );
   document
      .getElementById("statusAgua")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "energetico_agua", 0)'
      );
   document
      .getElementById("statusDiesel")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "energetico_diesel", 0)'
      );
   document
      .getElementById("statusGas")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "energetico_gas", 0)'
      );

   // Finalizar MC.
   document
      .getElementById("statusFinalizar")
      .setAttribute(
         "onclick",
         "actualizarTareas(" + idTarea + ', "status", "F")'
      );
   // Activo MC.
   document
      .getElementById("statusActivo")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "activo", 0)');
   // Titulo MC.
   document
      .getElementById("btnEditarTitulo")
      .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "titulo", 0)');
   document.getElementById("inputEditarTitulo").value = tituloTarea;
}


// Actualiza Datos de las Tareas
function actualizarTareas(idTarea, columna, valor) {
   let tituloNuevo = document.getElementById("inputEditarTitulo").value;
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
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
      },
      // dataType: "JSON",
      success: function (data) {
         if (data == 1) {
            obtenerTareas(idEquipo);
            alertaImg("Status Actualizado", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 2) {
            obtenerDatosUsuario(idDestino);
            llamarFuncionX("obtenerEquipos");
            obtenerTareas(idEquipo);
            alertaImg("Tarea SOLUCIONADA", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 3) {
            obtenerDatosUsuario(idDestino);
            obtenerTareas(idEquipo);
            llamarFuncionX("obtenerEquipos");
            alertaImg("Tarea Recuperada como PENDIENTE", "", "success", 2000);
            document.getElementById("modalStatus").classList.remove("open");
         } else if (data == 4) {
            obtenerTareas(idEquipo);
            obtenerDatosUsuario(idDestino);
            llamarFuncionX("obtenerEquipos");
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
               llamarFuncionX("obtenerEquipos");
               obtenerTareas(idEquipo);
               document.getElementById("inputActividadMC").value = "";
               document.getElementById("modalAgregarMC").classList.remove("open");
               alertaImg("Tarea Agregada", "", "success", 1500);
            } else if (data == 2) {
               obtenerDatosUsuario(idDestino);
               llamarFuncionX("obtenerEquipos");
               obtenerTareas(idEquipo);
               document.getElementById("inputActividadMC").value = "";
               document.getElementById("modalAgregarMC").classList.remove("open");
               document.getElementById("comentarioMC").value = "";
               alertaImg("Tarea Y Comentario, Agregado", "", "success", 1500);
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
      setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_adjuntos")');
   document.getElementById("contenedorImagenes").classList.add('hidden');
   document.getElementById("contenedorDocumentos").classList.add('hidden');

   let idTabla = idEquipo;
   let tabla = "t_equipos_adjuntos";

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
               alertaImg('Comentario Agregado', '', 'success', 1200);
               document.getElementById("inputComentario").value = '';
               obtenerEquiposAmerica(idSeccion, idSubseccion);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
            document.getElementById("dataComentarios").innerHTML = '';
         }
      })
   } else {
      alertaImg('Intente de Nuevo', '', 'info', 1200);
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


// Comentarios para Planaccion
function comentariosPlanaccion(idPlanaccion) {
   document
      .getElementById("btnComentario")
      .setAttribute(
         "onclick",
         "agregarComentarioPlanaccion(" + idPlanaccion + ")"
      );
   document.getElementById("modalComentarios").classList.add("open");

   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   const action = "comentariosPlanaccion";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         idPlanaccion: idPlanaccion,
      },
      // dataType: "JSON",
      success: function (data) {
         document.getElementById("dataComentarios").innerHTML = data;
      },
   });
}


// Muestra los adjuntos de Planaccion
function adjuntosPlanaccion(idPlanaccion) {
   document.getElementById("modalMedia").classList.add("open");
   document.getElementById("contenedorImagenes").classList.add('hidden');
   document.getElementById("contenedorDocumentos").classList.add('hidden');

   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idTabla = idPlanaccion;
   let tabla = "t_proyectos_planaccion_adjuntos";

   document
      .getElementById("inputAdjuntos")
      .setAttribute(
         "onchange",
         "subirImagenGeneral(" +
         idPlanaccion +
         ', "t_proyectos_planaccion_adjuntos")'
      );

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
      document.getElementById("cargandoAdjunto").innerHTML =
         '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

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
               adjuntosPlanaccion(idTabla);
            } else if (data == 5) {
               alertaImg("Adjunto Agregado", "", "success", 2500);
               obtenerMediaEquipo(idTabla);
               obtenerEquiposAmerica(idSeccion, idSubseccion);
            } else if (data == 7) {
               obtenerAdjuntosTareas(idTabla);
               obtenerTareas(idEquipo);
               alertaImg("Adjunto Agregado", "", "success", 2500);
            } else if (data == 8) {
               obtenerAdjuntosMC(idTabla);
               obtenerFallas(idEquipo);
               alertaImg("Adjunto Agregado", "", "success", 2500);
            } else if (data == 9) {
               obtenerImagenesEquipo(idTabla);
               alertaImg("Adjunto Agregado", "", "success", 2500);
            } else if (data == 11) {
               alertaImg("Cotización Agregada", "", "success", 2500);
               obtenerCotizacionesEquipo(idTabla);
               obtenerEquiposAmerica(idSeccion, idSubseccion);
            } else {
               alertaImg("Intente de Nuevo", "", "info", 3000);
            }
         },
      });
   }
}


// Funcion para buscar pendiente Ver en Planner
function verEnPlanner(tipoPendiente, idPendiente) {
   document.getElementById("modalVerEnPlanner").classList.add('open');
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   const action = "verEnPlanner";
   document.getElementById("dataStatusVP").
      setAttribute('onclick', 'verEnPlanner("' + tipoPendiente + '",+' + idPendiente + ')');


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
         document.getElementById("tipoPendienteVP").innerHTML = tipoPendiente + ': ' + data.idPendiente;
         document.getElementById("descripcionPendienteVP").innerHTML = data.actividad;
         document.getElementById("creadoPorVP").innerHTML = data.creadoPor;
         document.getElementById("fechaVP").value = data.fecha;
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
            document.getElementById("fechaVP").innerHTML = data.fecha;
            document.getElementById("fechaTareas").value = data.fecha;


            // RESPONSABLE
            document.getElementById("responsableVP").
               setAttribute('onclick', 'obtenerUsuarios("asignarTarea",' + idPendiente + ')');


            // ADJUNTOS
            document.getElementById("adjuntosVP").
               setAttribute('onclick', 'obtenerAdjuntosTareas(' + idPendiente + ')');

            // COMENTARIOS
            document.getElementById("btnComentarioVP").
               setAttribute('onclick', 'agregarComentarioVP("' + tipoPendiente + '", ' + idPendiente + ')');
         }
      }
   });
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
         'nombreEquipo', 'seccionEquipo', 'subseccionEquipo', 'tipoEquipo', 'jerarquiaEquipo', 'marcaEquipo', 'modeloEquipo', 'serieEquipo', 'codigoFabricanteEquipo', 'codigoInternoComprasEquipo', 'largoEquipo', 'anchoEquipo', 'altoEquipo', 'potenciaElectricaHPEquipo', 'potenciaElectricaKWEquipo', 'voltajeEquipo', 'frecuenciaEquipo', 'caudalAguaM3HEquipo', 'caudalAguaGPHEquipo', 'cargaMCAEquipo', 'PotenciaEnergeticaFrioKWEquipo', 'potenciaEnergeticaFrioTREquipo', 'potenciaEnergeticaCalorKCALEquipo', 'caudalAireM3HEquipo', 'caudalAireCFMEquipo'
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

   consultarOpcionesEquipo();
   toggleInputsEquipo(0);

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
         document.getElementById("btnAdjuntosEquipo").setAttribute('onclick', 'toggleModalTailwind("modalMedia")');

         obtenerImagenesEquipo(idEquipo);
         consultarPlanEquipo(idEquipo);
         document.getElementById("inputAdjuntos").
            setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_adjuntos_america")');

         let URLQR = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=svg&bgcolor=fff&color=4a5568&data=www.maphg.com/beta/gestion_equipos/index.php?" + idEquipo;
         document.getElementById("QREquipo").
            setAttribute("src", URLQR);
         // document.getElementById("QREquipo").
         // setAttribute("src", "https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=svg&bgcolor=fff&color=4a5568&data=www.maphg.com/beta/planner-cols.php?id=" + idEquipo);

         document.getElementById("nombreEquipo").value = data.equipo;
         document.getElementById("seccionEquipo").value = data.idSeccion;
         document.getElementById("subseccionEquipo").value = data.idSubseccion;
         document.getElementById("jerarquiaEquipo").value = data.jerarquia;
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
         document.getElementById("estadoEquipo").innerHTML = data.status;
      }
   });
}


// Obtiene Images de los Equipos
function obtenerImagenesEquipo(idEquipo) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let tabla = "t_equipos_adjuntos_america";
   let idTabla = idEquipo;

   document.getElementById("inputAdjuntos").
      setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_adjuntos_america")');

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
         }

         if (data.documento != "") {
            document.getElementById("dataAdjuntos").innerHTML = data.documento;
            document.getElementById("contenedorDocumentos").classList.remove('hidden');
            document.getElementById("dataAdjuntos").classList.remove("justify-center");
         }
      },
   });
}


// Actualiza la información de los Equipos
function actualizarEquipo(idEquipo) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   let nombreEquipo = document.getElementById("nombreEquipo").value;
   let seccionEquipo = document.getElementById("seccionEquipo").value;
   let subseccionEquipo = document.getElementById("subseccionEquipo").value;
   let tipoEquipo = document.getElementById("tipoEquipo").value;
   let jerarquiaEquipo = document.getElementById("jerarquiaEquipo").value;
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
         caudalAireCFMEquipo: caudalAireCFMEquipo
      },
      // dataType: "JSON",
      success: function (data) {
         if (data = 1) {
            informacionEquipo(idEquipo);
            alertaImg('Equipo Actualizado', '', 'success', 2500);
            llamarFuncionX('obtenerEquipos');
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 3000);
         }
      }
   });
}


function consultarPlanEquipo(idEquipo) {
   document.getElementById("contenedorPlanesEquipo").innerHTML = '';
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   const action = "consultarPlanEquipo";
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
         if (data.length > 0) {
            for (let index = 0; index < data.length; index++) {

               $ContenedorPlanesEquipos.innerHTML += datosPlanEquipo({
                  solucionado: data[index].solucionado,
                  proceso: data[index].proceso,
                  planificado: data[index].planificado,
                  idSemana: data[index].idSemana,
                  idProceso: data[index].idProceso,
                  idEquipo: data[index].idEquipo,
                  idPlan: data[index].idPlan,
                  periodicidad: data[index].periodicidad,
                  tipoPlan: data[index].tipoPlan,
                  semana_1: data[index].semana_1,
                  semana_2: data[index].semana_2,
                  semana_3: data[index].semana_3,
                  semana_4: data[index].semana_4,
                  semana_5: data[index].semana_5,
                  semana_6: data[index].semana_6,
                  semana_7: data[index].semana_7,
                  semana_8: data[index].semana_8,
                  semana_9: data[index].semana_9,
                  semana_10: data[index].semana_10,
                  semana_11: data[index].semana_11,
                  semana_12: data[index].semana_12,
                  semana_13: data[index].semana_13,
                  semana_14: data[index].semana_14,
                  semana_15: data[index].semana_15,
                  semana_16: data[index].semana_16,
                  semana_17: data[index].semana_17,
                  semana_18: data[index].semana_18,
                  semana_19: data[index].semana_19,
                  semana_20: data[index].semana_20,
                  semana_21: data[index].semana_21,
                  semana_22: data[index].semana_22,
                  semana_23: data[index].semana_23,
                  semana_24: data[index].semana_24,
                  semana_25: data[index].semana_25,
                  semana_26: data[index].semana_26,
                  semana_27: data[index].semana_27,
                  semana_28: data[index].semana_28,
                  semana_29: data[index].semana_29,
                  semana_30: data[index].semana_30,
                  semana_31: data[index].semana_31,
                  semana_32: data[index].semana_32,
                  semana_33: data[index].semana_33,
                  semana_34: data[index].semana_34,
                  semana_35: data[index].semana_35,
                  semana_36: data[index].semana_36,
                  semana_37: data[index].semana_37,
                  semana_38: data[index].semana_38,
                  semana_39: data[index].semana_39,
                  semana_40: data[index].semana_40,
                  semana_41: data[index].semana_41,
                  semana_42: data[index].semana_42,
                  semana_43: data[index].semana_43,
                  semana_44: data[index].semana_44,
                  semana_45: data[index].semana_45,
                  semana_46: data[index].semana_46,
                  semana_47: data[index].semana_47,
                  semana_48: data[index].semana_48,
                  semana_49: data[index].semana_49,
                  semana_50: data[index].semana_50,
                  semana_51: data[index].semana_51,
                  semana_52: data[index].semana_52,
                  proceso_1: data[index].proceso_1,
                  proceso_2: data[index].proceso_2,
                  proceso_3: data[index].proceso_3,
                  proceso_4: data[index].proceso_4,
                  proceso_5: data[index].proceso_5,
                  proceso_6: data[index].proceso_6,
                  proceso_7: data[index].proceso_7,
                  proceso_8: data[index].proceso_8,
                  proceso_9: data[index].proceso_9,
                  proceso_10: data[index].proceso_10,
                  proceso_11: data[index].proceso_11,
                  proceso_12: data[index].proceso_12,
                  proceso_13: data[index].proceso_13,
                  proceso_14: data[index].proceso_14,
                  proceso_15: data[index].proceso_15,
                  proceso_16: data[index].proceso_16,
                  proceso_17: data[index].proceso_17,
                  proceso_18: data[index].proceso_18,
                  proceso_19: data[index].proceso_19,
                  proceso_20: data[index].proceso_20,
                  proceso_21: data[index].proceso_21,
                  proceso_22: data[index].proceso_22,
                  proceso_23: data[index].proceso_23,
                  proceso_24: data[index].proceso_24,
                  proceso_25: data[index].proceso_25,
                  proceso_26: data[index].proceso_26,
                  proceso_27: data[index].proceso_27,
                  proceso_28: data[index].proceso_28,
                  proceso_29: data[index].proceso_29,
                  proceso_30: data[index].proceso_30,
                  proceso_31: data[index].proceso_31,
                  proceso_32: data[index].proceso_32,
                  proceso_33: data[index].proceso_33,
                  proceso_34: data[index].proceso_34,
                  proceso_35: data[index].proceso_35,
                  proceso_36: data[index].proceso_36,
                  proceso_37: data[index].proceso_37,
                  proceso_38: data[index].proceso_38,
                  proceso_39: data[index].proceso_39,
                  proceso_40: data[index].proceso_40,
                  proceso_41: data[index].proceso_41,
                  proceso_42: data[index].proceso_42,
                  proceso_43: data[index].proceso_43,
                  proceso_44: data[index].proceso_44,
                  proceso_45: data[index].proceso_45,
                  proceso_46: data[index].proceso_46,
                  proceso_47: data[index].proceso_47,
                  proceso_48: data[index].proceso_48,
                  proceso_49: data[index].proceso_49,
                  proceso_50: data[index].proceso_50,
                  proceso_51: data[index].proceso_51,
                  proceso_52: data[index].proceso_52
               });
            }
         } else {
            alertaImg('Sin Planes MP', '', 'info', 3000);
         }

      }
   });
}


// Genera la Programación de los MP
function programarMP(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP) {

   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
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
         // consultarPlanEquipo(idEquipo);
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
         numeroSemanas: numeroSemanas
      },
      // dataType: "JSON",
      success: function (data) {
         if (data == 13) {
            localStorage.setItem('URL', `${idSemana};${idProceso};${idEquipo};${semanaX};${idPlan}`);
            window.open('OT/index.php', "OT", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1200px, height=650px");
         } else {
            alertaImg(`Semana ${semanaX}, Sin Proceso`, '', 'error', 3000);

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

      case (nombreFuncion = "obtenerEquipos"):
         obtenerEquipos(idUsuario, idDestino, idSeccion, idSubseccion, 0, 49, "MCN");
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
            alertaImg('Actividad, Solucionada', '', 'success', 1200);
         } else if (array == "ELIMINADO") {
            alertaImg('Actividad, Eliminada', '', 'success', 1200);
         } else if (array == "ACTIVIDAD") {
            alertaImg('Actividad, Actualizada', '', 'success', 1200);
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1200);
         }

         if (tipo == "FALLA") {
            obtenerFallas(idEquipo);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
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
               alertaImg('Actividad, Agregada', '', 'success', 1200);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1200);
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
            fetch(`${APIERROR + err}`);
         })
   } else {
      alertaImg('Actividad NO Valida', '', 'info', 1200);
   }
}


// Cierra Sesión
async function cerrarSession() {
   alertaImg("Sessión Cerrada", "", "success", 1200);
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
   }

   return `
        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal 
        ${statusX}">
           
        <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;"
        ${fActividades}>
            <div class="font-semibold uppercase leading-4">
               <h1>${params.actividad}</h1>
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
   document.getElementById("seccionFallaTarea").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
   document.getElementById("contenedorPrincipalTareasFallas").
      setAttribute('style', 'background:#fc8181; min-height: 60vh;');
   document.getElementById('tipoFallaTarea').innerHTML = tipoPendiente;
   document.getElementById("pendienteFallaTarea").
      setAttribute('onclick', `obtenerFallasPendientes(${idEquipo})`);
   document.getElementById("solucionadosFallaTarea").
      setAttribute('onclick', `obtenerFallasSolucionados(${idEquipo})`);
   document.getElementById("agregarFallaTarea").setAttribute('onclick', 'datosModalAgregarMC()');
   document.getElementById("ganttFallaTarea").
      setAttribute('onclick', `ganttFallas(${idEquipo}, 'PENDIENTE')`);

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
         } else {
            alertaImg('Equipo/Local, Sin Fallas', '', 'info', 1200);
         }
      })
      .then(function () {
         complementosFallasTareas();
      })
      .then(function () { obtenerFallasPendientes(idEquipo) })
      .catch(function (err) {
         fetch(APIERROR + '3466' + err);
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
            fetch(APIERROR + err);
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
      alertaImg('Sin Solucionados', '', 'info', 1200);
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
   } else {
      alertaImg('Sin PENDIENTES', '', 'info', 1200);
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

   document.getElementById("seccionFallaTarea").innerHTML =
      '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
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
         } else {
            alertaImg('Equipo/Local, Sin Fallas', '', 'info', 1200);
         }
      })
      .then(function () {
         complementosFallasTareas();
      })
      .then(function () { obtenerTareasPendientes(idEquipo) })
      .catch(function (err) {
         fetch(APIERROR + ' -3644- ' + err);
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
            fetch(APIERROR + err);
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
   } else {
      alertaImg('Sin Solucionados', '', 'info', 1200);
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
   } else {
      alertaImg('Sin PENDIENTES', '', 'info', 1200);
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
            alertaImg('No se Encontraron Datos', '', 'info', 1200);
         }
         return array;
      }).then(function (array) {
         generarGantt(array);
      })
      .catch(function (err) {
         fethc(APIERROR + err);
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
            alertaImg('No se Encontraron Datos', '', 'info', 1200);
         }
         return array;
      }).then(function (array) {
         generarGantt(array);
      })
      .catch(function (err) {
         fethc(APIERROR + err);
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

   var tipoEquipo = params.tipoEquipo;
   var valorTipoEquipo = '';

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


   var ultimoMpFecha = params.ultimoMpFecha;

   if (ultimoMpFecha == 0) {
      valorultimoMpFecha = '<i class="fad fa-minus text-xl text-red-400 leading-none"></i>';
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
      valorproximoMpFecha = '<i class="fad fa-minus text-xl text-red-400 leading-none"></i>';
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
      valorultimoTestFecha = '<i class="fad fa-minus text-xl text-red-400 leading-none"></i>';
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
      valorcotizaciones = '<i class="fad fa-minus text-xl text-red-400 leading-none"></i>';
   } else {
      valorcotizaciones = params.cotizaciones;
   }

   var imagenes = params.imagenes;

   if (imagenes == 0) {
      valorimagenes = '<i class="fad fa-minus text-xl text-red-400 leading-none"></i>';
   } else {
      valorimagenes = params.imagenes;
   }

   var comentarios = params.comentarios;

   if (comentarios == 0) {
      valorcomentarios = '<i class="fad fa-minus text-xl text-red-400 leading-none"></i>';
   } else {
      valorcomentarios = params.comentarios;
   }

   var idEquipo = params.idEquipo;
   var fFallas = `onclick="obtenerFallas(${idEquipo}); toggleModalTailwind('modalTareasFallas');"`;
   var fTareas = `onclick="obtenerTareas(${idEquipo}); toggleModalTailwind('modalTareasFallas');"`;
   var tComentarios = `onclick="obtenerComentariosEquipos(${idEquipo}); toggleModalTailwind('modalComentarios');"`;
   var tAdjuntos = `onclick="obtenerMediaEquipo(${idEquipo})"`;
   var tInfo = `onclick="informacionEquipo(${idEquipo});"`;
   var tCotizaciones = `onclick="obtenerCotizacionesEquipo(${idEquipo})"`;

   return `
        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-700">
            
            <td class="px-4 border-b border-gray-200truncate py-2" style="max-width: 360px;"
            ${tInfo}>
                <div class="font-semibold uppercase text-sm">
                    <h1>${params.equipo}</h1>
                </div>
                <div class="text-gray-500 leading-none flex text-xxs">
                    ${valorTipoEquipo}
                    ${valorstatusEquipo}
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300" ${fFallas}>
                <div class="font-bold uppercase text-sm text-red-400">
                    <h1>${params.fallasP}</h1>
                </div>
                <div class="font-semibold uppercase text-green-400">
                    <h1>${params.fallasS}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-bold uppercase text-sm text-red-400">
                    <h1>${params.mpP}</h1>
                </div>
                <div class="font-semibold uppercase text-green-400">
                    <h1>${params.mpS}</h1>
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
                    <h1>${params.tareasP}</h1>
                </div>
                <div class="font-semibold uppercase text-green-400">
                    <h1>${params.tareasS}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-semibold uppercase">
                    <h1>${params.testR}</h1>
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

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300" ${tCotizaciones}>
                <div class="font-semibold uppercase">
                    <h1>${valorcotizaciones}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200truncate py-2 text-center leading-none hover:bg-gray-300" ${tAdjuntos}>
                <div class="font-semibold uppercase">
                    <h1>${valorimagenes}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 truncate py-2 text-center leading-none hover:bg-gray-300" ${tComentarios}>
                <div class="font-semibold uppercase">
                    <h1>${valorcomentarios}</h1>
                </div>
            </td>
            
        </tr>
    `;
};


// OBTIENE LOS EQUIPOS AMERICA
function obtenerEquiposAmerica(idSeccion, idSubseccion) {
   localStorage.setItem('idSeccion', idSeccion);
   localStorage.setItem("idSubseccion", idSubseccion);

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   document.getElementById("seccionSubseccionDestinoEquiposAmerica").innerHTML = '<i class="fas fa-spinner fa-pulse fa-2x fa-fw"></i>';

   const action = "obtenerEquiposAmerica";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;

   document.getElementById("tareasGeneralesEquipo").
      setAttribute('onclick', "obtenerTareas(0); toggleModalTailwind('modalTareasFallas');");
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         document.getElementById("contenedorEquiposAmerica").innerHTML = '';
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
                  comentarios: comentarios
               });

               document.getElementById("contenedorEquiposAmerica").
                  insertAdjacentHTML('beforeend', data);
            }
         } else {
            alertaImg('Sin Equipos/Locales', '', 'info', 1200);
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
               fetch(APIERROR + err)
               document.getElementById("seccionSubseccionDestinoEquiposAmerica").innerHTML = '';
            })
      })
      .then(function () {
         obtenerTodosPendientes();
      })
      .catch(function (err) {
         document.getElementById("seccionSubseccionDestinoEquiposAmerica").innerHTML = '';
         fetch(APIERROR + err);
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
   buscdorTabla('dataPendientesX', 'palabraFallaTarea', 0);
});

// EVENTO PARA BUSCAR PROYECTOS EN LA TABLA
document.getElementById("palabraEquipoAmerica").addEventListener('keyup', function () {
   buscdorTabla('contenedorEquiposAmerica', 'palabraEquipoAmerica', 0);
});




// Función para comprobar session.
comprobarSession();