// VARIABLES GLOBALES, (VALOR ESTATICO AL CARGAR LA PAGINA)
let idUsuario = localStorage.getItem("usuario");
let idDestino = localStorage.getItem("idDestino");
// VARIABLES GLOBALES, (VALOR ESTATICO AL CARGAR LA PAGINA)


// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';


// ICONOS 
const iconoLoader = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
const iconoDefault = '<i class="fad fa-minus text-xl text-red-400"></i>';
const loaderMAPHG75 = '<div class="w-full p-12 flex items-center justify-center"><img src="svg/lineal_animated_loop.svg" width="75px" height="75px"></div>';
const loaderMAPHG40 = '<div class="w-full p-1 flex items-center justify-center"><img src="svg/lineal_animated_loop.svg" width="30px" height="30px"></div>';


// ELEMENTOS BUTTOM ID
const btnEmergenciaEntregas = document.getElementById("btnEmergenciaEntregas");
const btnUrgenciaEntregas = document.getElementById("btnUrgenciaEntregas");
const btnAlarmaEntregas = document.getElementById("btnAlarmaEntregas");
const btnAlertaEntregas = document.getElementById("btnAlertaEntregas");
const btnSeguimientoEntregas = document.getElementById("btnSeguimientoEntregas");
const btnCrearEntregas = document.getElementById("btnCrearEntregas");
const btnTGEntregas = document.getElementById("btnTGEntregas");
const btnEquipoEntregas = document.getElementById("btnEquipoEntregas");
const btnLocalEntregas = document.getElementById("btnLocalEntregas");
const btnModalAgregarIncidencias = document.getElementById("btnModalAgregarIncidencias");
const btnModalAgregarIncidenciasEntrega = document.getElementById("btnModalAgregarIncidenciasEntrega");
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
const btnEmergenciaEnergetico = document.getElementById("btnEmergenciaEnergetico");
const btnUrgenciaEnergetico = document.getElementById("btnUrgenciaEnergetico");
const btnAlarmaEnergetico = document.getElementById("btnAlarmaEnergetico");
const btnAlertaEnergetico = document.getElementById("btnAlertaEnergetico");
const btnSeguimientoEnergetico = document.getElementById("btnSeguimientoEnergetico");
const inputComentarioPlanaccion = document.getElementById("inputComentarioPlanaccion");
const btnAgregarComentarioPlanaccion = document.getElementById("btnAgregarComentarioPlanaccion");
const btnAbrirOTPlanaccion = document.getElementById("btnAbrirOTPlanaccion");
const btnAgregarActividadPlanaccionX = document.getElementById("btnAgregarActividadPlanaccionX");
const btnAplicarRangoFecha = document.getElementById("btnAplicarRangoFecha");
const btnStatusPlanaccion = document.getElementById("btnStatusPlanaccion");
const btnResponsablePlanaccion = document.getElementById("btnResponsablePlanaccion");
const btnAplicarNuevoTituloPlanacciontoggle =
   document.getElementById("btnAplicarNuevoTituloPlanacciontoggle");
const btnEliminarActividadPlanaccion = document.getElementById("btnEliminarActividadPlanaccion");
const btnGraficasReportesDiario = document.getElementById("btnGraficasReportesDiario");
const btnPresupuestoProyecto = document.getElementById("btnPresupuestoProyecto");
const btnModalAgregarEnergeticos = document.getElementById("btnModalAgregarEnergeticos");
const btnColumnasInicdencias = document.getElementById("btnColumnasInicdencias");
const btnColumnasPreventivos = document.getElementById("btnColumnasPreventivos");
const btnColumnasPredictivos = document.getElementById("btnColumnasPredictivos");
const btnCerrarModalEquiposAmerica = document.getElementById("btnCerrarModalEquiposAmerica");
const btnAgregarActividadVerEnPlanner = document.getElementById("btnAgregarActividadVerEnPlanner");
const btnAgregarComentarioVerEnPlanner =
   document.getElementById("btnAgregarComentarioVerEnPlanner");
const btnPendientesIncidencias = document.getElementById("btnPendientesIncidencias");
const misPendientesUsuario = document.getElementById("misPendientesUsuario");
const misPendientesCreados = document.getElementById("misPendientesCreados");
const misPendientesSinUsuario = document.getElementById("misPendientesSinUsuario");
const misPendientesSeccion = document.getElementById("misPendientesSeccion");
const btnStatusVerEnPlanner = document.getElementById("btnStatusVerEnPlanner");
const btnResponsablesIncidencias = document.getElementById("btnResponsablesIncidencias");
const aplicarTituloIncidenca = document.getElementById("aplicarTituloIncidenca");
const btnEliminarActividadIncidencia = document.getElementById("btnEliminarActividadIncidencia");
const btnExpandirMenu = document.getElementById("btnExpandirMenu");
const btnvisualizarpendientesde = document.getElementById("btnvisualizarpendientesde");
const misPendientesIncidencias = document.getElementById("misPendientesIncidencias");
const misPendientesPDA = document.getElementById("misPendientesPDA");
const misPendientesTareas = document.getElementById("misPendientesTareas");
const btnPendientesEnergeticos = document.getElementById("btnPendientesEnergeticos");
const btnSolucionadosEnergeticos = document.getElementById("btnSolucionadosEnergeticos");
const btnBuscarOT = document.getElementById("btnBuscarOT");
const btnBuscarNumeroOT = document.getElementById("btnBuscarNumeroOT");
const btnAñadirMaterialEquipo = document.getElementById("btnAñadirMaterialEquipo");
const btnMover = document.getElementById("btnMover");
// ELEMENTOS BUTTOM ID


// ELEMENTOS <INPUTS> ID
const inputAdjuntosEntregas = document.getElementById("inputAdjuntosEntregas");
const descripcionEntregas = document.getElementById("descripcionEntregas");
const comentarioEntregas = document.getElementById("comentarioEntregas");
const equipoLocalEntregas = document.getElementById("equipoLocalEntregas");
const nuevoTituloIncidencia = document.getElementById("nuevoTituloIncidencia");
const seccionIncidencias = document.getElementById("seccionIncidencias");
const subseccionIncidencias = document.getElementById("subseccionIncidencias");
const equipoLocalIncidencias = document.getElementById("equipoLocalIncidencias");
const responsablesIncidencias = document.getElementById("responsablesIncidencias");
const tituloPendienteEnergeticos = document.getElementById("tituloPendienteEnergeticos");
const rangoFechaEnergeticos = document.getElementById("rangoFechaEnergeticos");
const responsableEnergeticos = document.getElementById("responsableEnergeticos");
const comentarioEnergeticos = document.getElementById("comentarioEnergeticos");
const inputActividadPlanaccion = document.getElementById("inputActividadPlanaccion");
const inputRangoFecha = document.getElementById("rangoFechaX");
const inputCod2bend = document.getElementById("inputCod2bend");
const inputFilePlanaccion = document.getElementById("inputFilePlanaccion");
const nuevoTituloPlanaccion = document.getElementById("nuevoTituloPlanaccion");
const presupuestoProyecto = document.getElementById("presupuestoProyecto");
const actividadVerEnPlanner = document.getElementById("actividadVerEnPlanner");
const comentarioIncidenciaVerEnPlanner =
   document.getElementById("comentarioIncidenciaVerEnPlanner");
const palabraFallaTarea = document.getElementById("palabraFallaTarea");
const palabraProyecto = document.getElementById("palabraProyecto");
const inputFileIncidencias = document.getElementById("inputFileIncidencias");
const palabraUsuario = document.getElementById("palabraUsuario");
const palabraUsuarioExportar = document.getElementById("palabraUsuarioExportar");
const palabraEquipoAmerica = document.getElementById("palabraEquipoAmerica");
const inputNumeroOT = document.getElementById("inputNumeroOT");
const inputAdjuntos = document.getElementById("inputAdjuntos");
const inputDespieceMaterialesEquipo = document.getElementById("inputDespieceMaterialesEquipo");
const selectMoverOpcion = document.getElementById("selectMoverOpcion");
const selectMoverSeccion = document.getElementById("selectMoverSeccion");
const selectMoverSubseccion = document.getElementById("selectMoverSubseccion");
const selectMoverEquipo = document.getElementById("selectMoverEquipo");
const selectMoverProyecto = document.getElementById("selectMoverProyecto");
const fechaOT = document.getElementById("fechaOT");
const fechaProgramadaOT = document.getElementById("fechaProgramadaOT");
const seccionEntregas = document.getElementById("seccionEntregas");
const responsablesEntregas = document.getElementById("responsablesEntregas");
const responsablesEjecucionEntregas = document.getElementById("responsablesEjecucionEntregas");
// ELEMENTOS <INPUTS> ID


// CONTENEDORES DIV ID
const contenedorEquipoLocalEntregas = document.getElementById("contenedorEquipoLocalEntregas");
const cantidadAdjuntosEntregas = document.getElementById("cantidadAdjuntosEntregas");
const contenedorEquipoLocalIncidencias = document.
   getElementById("contenedorEquipoLocalIncidencias");
const nombreSubseccionEnergeticos = document.getElementById("nombreSubseccionEnergeticos");
const dataOpcionesSubseccionestoggle = document.getElementById("dataOpcionesSubseccionestoggle");
const dataActividadesPlanaccion = document.getElementById("dataActividadesPlanaccion");
const dataComentariosPlanaccion = document.getElementById("dataComentariosPlanaccion");
const dataAdjutnosPlanaccion = document.getElementById("dataAdjutnosPlanaccion");
const tiluloPlanaccion = document.getElementById("tiluloPlanaccion");
const fechaCreacionPlanaccion = document.getElementById("fechaCreacionPlanaccion");
const creadoPorPlanaccion = document.getElementById("creadoPorPlanaccion");
const rangoFechaPlanaccion = document.getElementById("rangoFechaPlanaccion");
const proyectoPlanaccion = document.getElementById("proyectoPlanaccion");
const tipoProyectoPlanaccion = document.getElementById("tipoProyectoPlanaccion");
const dataStatusPlanaccion = document.getElementById("dataStatusPlanaccion");
const dataResponsablesAsignadosPlanaccion =
   document.getElementById("dataResponsablesAsignadosPlanaccion");
const dataPendientesUsuario = document.getElementById("dataPendientesUsuario");
const loadPendientes = document.getElementById("loadPendientes");
const totalPendientesFallas = document.getElementById("totalPendientesFallas");
const totalPendientesPDA = document.getElementById("totalPendientesPDA");
const tooltipOpcionesActividadPlanaccion =
   document.getElementById("tooltipOpcionesActividadPlanaccion");
const tooltipOpcionesActividadIncidencias =
   document.getElementById("tooltipOpcionesActividadIncidencias");
const tipoIncidenciaVerEnPlanner = document.getElementById("tipoIncidenciaVerEnPlanner");
const tituloVerEnPlanner = document.getElementById("tituloVerEnPlanner");
const fechaVerEnPlanner = document.getElementById("fechaVerEnPlanner");
const creadoPorVerEnPlanner = document.getElementById("creadoPorVerEnPlanner");
const responsablesVerEnPlanner = document.getElementById("responsablesVerEnPlanner");
const statusVerEnPlanner = document.getElementById("statusVerEnPlanner");
const rangoFechaVerEnPlanner = document.getElementById("rangoFechaVerEnPlanner");
const asignadoAVerEnPlanner = document.getElementById("asignadoAVerEnPlanner");
const btnVerOTVerEnPlanner = document.getElementById("btnVerOTVerEnPlanner");
const dataActividadesIncidenciaVerEnPlanner =
   document.getElementById("dataActividadesIncidenciaVerEnPlanner");
const dataComentariosIncidenciaVerEnPlanner =
   document.getElementById("dataComentariosIncidenciaVerEnPlanner");
const dataAdjuntosIncidenciaVerEnPlanner =
   document.getElementById("dataAdjuntosIncidenciaVerEnPlanner");
const estiloSeccion = document.getElementById("estiloSeccion");
const dataUsuarios = document.getElementById("dataUsuarios");
const theadEquipoLocal = document.getElementById("theadEquipoLocal");
const paginacionEquiposAmerica = document.getElementById("paginacionEquiposAmerica");
const contenedorEquiposAmericaDespice3 =
   document.getElementById("contenedorEquiposAmericaDespice3");
const tooltipDespieceEquipo3 = document.getElementById("tooltipDespieceEquipo3");
const tituloSegundoNivel = document.getElementById("tituloSegundoNivel");
const tituloTercerNivel = document.getElementById("tituloTercerNivel");
const columnas_x = document.getElementById("columnas_x");
const dataBuscarOT = document.getElementById("dataBuscarOT");
const cantidadDespieceMaterialEquipo = document.getElementById("cantidadDespieceMaterialEquipo");
const contenedorMover = document.getElementById("contenedorMover");
const statusMaterialCod2bend = document.getElementById("statusMaterialCod2bend");
// CONTENEDORES DIV ID

// CONTENEDORES DIV CLASS
const btnOpcionIncidencia = document.getElementsByClassName("btnOpcionIncidencia");
const opcionSelectsMover = document.getElementsByClassName("opcionSelectsMover");
// CONTENEDORES DIV CLASS

// CONTENEDOR DE TABLAS
const contenedorEquiposAmerica = document.getElementById("contenedorEquiposAmerica");
const contenedorEquiposAmericaDespice = document.getElementById("contenedorEquiposAmericaDespice");
const dataSubseccionesPendientes = document.getElementById("dataSubseccionesPendientes");
const dataOpcionesMaterialesEquipo = document.getElementById("dataOpcionesMaterialesEquipo");
// CONTENEDOR DE TABLAS

// THEADS DE TABLAS
const tablaPendientesSubseccion = document.getElementById("tablaPendientesSubseccion");
const tablaPendientesPendientes = document.getElementById("tablaPendientesPendientes");
const tablaPendientesPendientesDEP = document.getElementById("tablaPendientesPendientesDEP");
const tablaPendientesTrabajando = document.getElementById("tablaPendientesTrabajando");
const tablaPendientesSolucionado = document.getElementById("tablaPendientesSolucionado");
const dataDespieceMaterialesEquipo = document.getElementById("dataDespieceMaterialesEquipo");
// THEADS DE TABLAS

// SCROLLS
const scrollContenedorEquiposPrincipales = document.getElementById("scrollContenedorEquiposPrincipales");
// SCROLLS

// MODALES
const modalVerEnPlannerIncidencia = document.getElementById("modalVerEnPlannerIncidencia");
// MODALES


// BOTONES PARA EL MODAL STATUS
const btnStatusUrgente = document.getElementById("statusUrgente");
const btnStatusMaterial = document.getElementById("btnStatusMaterial");
const btnStatusTrabajare = document.getElementById("statusTrabajare");
const btnStatusCalidad = document.getElementById("statusCalidad");
const btnStatusCompras = document.getElementById("statusCompras");
const btnStatusDireccion = document.getElementById("statusDireccion");
const btnStatusFinanzas = document.getElementById("statusFinanzas");
const btnStatusRRHH = document.getElementById("statusRRHH");
const btnStatusElectricidad = document.getElementById("statusElectricidad");
const btnStatusAgua = document.getElementById("statusAgua");
const btnStatusDiesel = document.getElementById("statusDiesel");
const btnStatusGas = document.getElementById("statusGas");
const btnStatusFinalizar = document.getElementById("statusFinalizar");
const btnStatusActivo = document.getElementById("statusActivo");
const btnEditarTitulo = document.getElementById("btnEditarTitulo");
const btnStatusGP = document.getElementById("statusGP");
const btnStatusTRS = document.getElementById("statusTRS");
const btnStatusZI = document.getElementById("statusZI");
const editarTitulo = document.getElementById("editarTitulo");
const btnStatusEP = document.getElementById("statusEP");
// BOTONES PARA EL MODAL STATUS


// ELEMENTOS PARA MODAL INFORMACION DE EQUIPO
const e_capacidadEquipo = document.getElementById("capacidadEquipo");
const e_fechaInstalacionEquipo = document.getElementById("fechaInstalacionEquipo");
const e_fechaCompraEquipo = document.getElementById("fechaCompraEquipo");
const e_añoGarantiaEquipo = document.getElementById("añoGarantiaEquipo");
const e_añoVidaUtilEquipo = document.getElementById("añoVidaUtilEquipo");
const e_estadoEquipo = document.getElementById("estadoEquipo");
const e_tipoLocalEquipo = document.getElementById("tipoLocalEquipo");
const e_idFaseEquipo = document.getElementById("idFaseEquipo");
const e_seccionEquipo = document.getElementById("seccionEquipo");
const e_subseccionEquipo = document.getElementById("subseccionEquipo");
const e_tipoEquipo = document.getElementById("tipoEquipo");
const e_jerarquiaEquipo = document.getElementById("jerarquiaEquipo");
const e_dataOpcionesEquipos = document.getElementById("dataOpcionesEquipos");
const e_marcaEquipo = document.getElementById("marcaEquipo");
const e_modeloEquipo = document.getElementById("modeloEquipo");
const e_serieEquipo = document.getElementById("serieEquipo");
const e_codigoFabricanteEquipo = document.getElementById("codigoFabricanteEquipo");
const e_codigoInternoComprasEquipo = document.getElementById("codigoInternoComprasEquipo");
const e_largoEquipo = document.getElementById("largoEquipo");
const e_anchoEquipo = document.getElementById("anchoEquipo");
const e_altoEquipo = document.getElementById("altoEquipo");
const e_potenciaElectricaHPEquipo = document.getElementById("potenciaElectricaHPEquipo");
const e_potenciaElectricaKWEquipo = document.getElementById("potenciaElectricaKWEquipo");
const e_voltajeEquipo = document.getElementById("voltajeEquipo");
const e_frecuenciaEquipo = document.getElementById("frecuenciaEquipo");
const e_caudalAguaM3HEquipo = document.getElementById("caudalAguaM3HEquipo");
const e_caudalAguaGPHEquipo = document.getElementById("caudalAguaGPHEquipo");
const e_cargaMCAEquipo = document.getElementById("cargaMCAEquipo");
const e_PotenciaEnergeticaFrioKWEquipo = document.getElementById("PotenciaEnergeticaFrioKWEquipo");
const e_potenciaEnergeticaFrioTREquipo = document.getElementById("potenciaEnergeticaFrioTREquipo");
const e_potenciaEnergeticaCalorKCALEquipo =
   document.getElementById("potenciaEnergeticaCalorKCALEquipo");
const e_caudalAireM3HEquipo = document.getElementById("caudalAireM3HEquipo");
const e_caudalAireCFMEquipo = document.getElementById("caudalAireCFMEquipo");
const e_dataDespieceEquipo = document.getElementById("dataDespieceEquipo");
const e_contenedorDataOpcionesEquipos = document.getElementById("contenedorDataOpcionesEquipos");
const e_cantidadEquipo = document.getElementById("cantidadEquipo");
const e_nombreEquipo = document.getElementById("nombreEquipo");
const btnEditarEquipo = document.getElementById("btnEditarEquipo");
const btnGuardarEquipo = document.getElementById("btnGuardarEquipo");
const btnCancelarEquipo = document.getElementById("btnCancelarEquipo");
const QREquipo = document.getElementById("QREquipo");
const inputFotografiaEquipo = document.getElementById("inputFotografiaEquipo");
const btnInformacionEquipo = document.getElementById("btnInformacionEquipo");
const btnDespieceEquipo = document.getElementById("btnDespieceEquipo");
const btnDocumentosEquipo = document.getElementById("btnDocumentosEquipo");
const btnCotizacionesEquipo = document.getElementById("btnCotizacionesEquipo");
const contenedorCaracteristicasEquipo = document.getElementById("contenedorCaracteristicasEquipo");
const contenedorDespiedeEquipo = document.getElementById("contenedorDespiedeEquipo");
const contenedorAdjuntosEquipo = document.getElementById("contenedorAdjuntosEquipo");
const inputAdjuntosEquipo = document.getElementById("inputAdjuntosEquipo");
const dataAdjuntosEquipo = document.getElementById("dataAdjuntosEquipo");
const btnPreventivosEquipo = document.getElementById("btnPreventivosEquipo");
const btnIncidenciasEquipo = document.getElementById("btnIncidenciasEquipo");
const btnChecklistEquipo = document.getElementById("btnChecklistEquipo");
const btnBitacorasEquipo = document.getElementById("btnBitacorasEquipo");
const contenedorPlanesEquipo = document.getElementById("contenedorPlanesEquipo");
const contenedorIncidenciasEquipo = document.getElementById("contenedorIncidenciasEquipo");
const contenedorChecklistEquipo = document.getElementById("contenedorChecklistEquipo");
const contenedorBitacoraEquipo = document.getElementById("contenedorBitacoraEquipo");
const dataIncidenciasEquipo = document.getElementById("dataIncidenciasEquipo");
// ELEMENTOS PARA MODAL INFORMACION DE EQUIPO

// BOTONES CALENDARIO SECCIÓN
const btnSeccion_8 = document.getElementById("btnSeccion_8");
const btnSeccion_12 = document.getElementById("btnSeccion_12");
const btnSeccion_9 = document.getElementById("btnSeccion_9");
const btnSeccion_1 = document.getElementById("btnSeccion_1");
const btnSeccion_10 = document.getElementById("btnSeccion_10");
const btnSeccion_6 = document.getElementById("btnSeccion_6");
const btnSeccion_5 = document.getElementById("btnSeccion_5");
const btnSeccion_11 = document.getElementById("btnSeccion_11");
const btnSeccion_24 = document.getElementById("btnSeccion_24");
const btnSeccion_23 = document.getElementById("btnSeccion_23");
const btnSeccion_7 = document.getElementById("btnSeccion_7");
// BOTONES CALENDARIO SECCIÓN

// Función principal.
function comprobarSession() {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   // Comprueba que exista la sessión
   if (idUsuario > 0 || idDestino > 0) {
      hora();
   } else {
      alertaImg('Sessión No Iniciada', '', 'info', 3000);
      location.replace("login.php");
   }
}

window.addEventListener('load', () => {
   obtenerPendientesUsuario();
   calendarioSecciones();
   comprobarSession();

   document.getElementById("destinosSelecciona").addEventListener('click', () => {
      comprobarSession();
      obtenerPendientesUsuario();
      calendarioSecciones();
   })
})



// OBTIENE LAS SECCIONES SEGÚN EL DESTINO
const obtenerSecciones = (idSeccion, status) => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "obtenerSecciones";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}`;

   // ELIMINA CONTENEDOR
   if (status == 2) {
      if (document.getElementById("contenedor_seccion_" + idSeccion)) {
         columnas_x.removeChild(document.getElementById("contenedor_seccion_" + idSeccion))
         if (document.getElementById("btnSeccion_" + idSeccion)) {
            document.getElementById("btnSeccion_" + idSeccion).classList.remove('btn-activo');
         }
      }
   } else if (document.getElementById("contenedor_seccion_" + idSeccion) && status === 0) {
      if (document.getElementById("btnSeccion_" + idSeccion)) {
         document.getElementById("btnSeccion_" + idSeccion).classList.remove('btn-activo');
      }
      if (document.getElementById("contenedor_seccion_" + idSeccion)) {
         columnas_x.removeChild(document.getElementById("contenedor_seccion_" + idSeccion))
      }

   } else {
      if (document.getElementById("btnSeccion_" + idSeccion)) {
         document.getElementById("btnSeccion_" + idSeccion).classList.add('btn-activo');
      }
      if (document.getElementById("contenedor_seccion_" + idSeccion)) {
         columnas_x.removeChild(document.getElementById("contenedor_seccion_" + idSeccion))
      }

      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array) {
               // s(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino)
               for (let x = 0; x < array.secciones.length; x++) {
                  const idSeccion = array.secciones[x].idSeccion;
                  const seccion = array.secciones[x].seccion;
                  const estiloLogo = seccion ? seccion.toLowerCase() + '-logo' : '';
                  const logoSeccion = idSeccion == 1001 ? `<i class="fas fa-plug fa-lg"></i>` : `${seccion}`;

                  const codigo = `
                     <div id="contenedor_seccion_${idSeccion}" class="flex items-center py-3"> 
                        <div id="col${seccion.toLowerCase()}" class="scrollbar flex flex-col justify-center items-center w-22rem mr-4">
                           <div class="bg-white rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative">
                              <div class="absolute flex justify-center items-center top-20 rounded-lg w-12 h-12 cursor-pointer ${estiloLogo}" onclick="pendientesSubsecciones(${idSeccion}, 'MCS', '${seccion}', ${idUsuario}, ${idDestino});">
                                 <h1 class="font-medium text-md">${logoSeccion}</h1>
                              </div>
                              <div class="flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900">
                                 <i class="fad fa-expand-arrows" onclick="pendientesSubsecciones(${idSeccion}, 'MCS', '${seccion}', ${idUsuario}, ${idDestino});"></i>
                              </div>
                              <div class="w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar">
                                 <div id="elementos_seccion_${idSeccion}" class="flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>            
                  `;
                  columnas_x.insertAdjacentHTML('beforeend', codigo);
               }

               // ORDENA LAS SUBSECCIONES POR PENDIENTES
               array.subsecciones.sort(function (a, b) {
                  return b.total - a.total;
               });
               return array.subsecciones;
            }
         })
         .then(array => {
            if (array) {
               for (let x = 0; x < array.length; x++) {
                  const subseccion = array[x].subseccion;
                  const idSubseccion = array[x].idSubseccion;
                  const idSeccion = array[x].idSeccion;
                  const total = array[x].total;
                  const totalX = total > 0 ? total : '';
                  const emergencia = array[x].emergencia;
                  const urgencia = array[x].urgencia;
                  const alarma = array[x].alarma;
                  const alerta = array[x].alerta;
                  const seguimiento = array[x].seguimiento;
                  const proyectos = array[x].proyectos;

                  if (idSubseccion == 200) {
                     fSubseccion = `onclick="actualizarSeccionSubseccion(${idSeccion}, ${idSubseccion}); obtenerProyectos(${idSeccion}, 'PENDIENTE'); toggleModalTailwind('modalProyectos');"`;
                  } else if (idSubseccion == 1006 || idSubseccion == 1007 || idSubseccion == 1008 || idSubseccion == 1009 || idSubseccion == 1010 || idSubseccion == 1011 || idSubseccion == 1012 || idSubseccion == 1013) {
                     fSubseccion = `onclick="actualizarSeccionSubseccion(${idSeccion}, ${idSubseccion}); obtenerEnergeticos(${idSeccion}, ${idSubseccion}, 'PENDIENTE'); toggleModalTailwind('modalEnergeticos')"`;
                  } else if (idSubseccion == 62 || idSubseccion == 211 || idSubseccion == 212 || idSubseccion == 213 || idSubseccion == 214) {
                     fSubseccion = `onclick="actualizarSeccionSubseccion(${idSeccion}, ${idSubseccion}); obtenerProyectosDEP(${idSubseccion}, 'PENDIENTE');"`;
                  } else {
                     fSubseccion = `onclick="obtenerEquiposAmerica(${idSeccion}, ${idSubseccion}); toggleModalTailwind('modalEquiposAmerica');"`;
                  }

                  const emergenciaX = emergencia > 0 ?
                     `<h1 class="text-xxs h-5 w-5 bg-red-300 text-red-600 rounded-md font-bold flex justify-center items-center ml-1">${emergencia}</h1>` : '';

                  const urgenciaX = urgencia > 0 ?
                     `<h1 class="text-xxs h-5 w-5 bg-orange-300 text-orange-600 rounded-md font-bold flex justify-center items-center ml-1">${urgencia}</h1>` : '';

                  const alarmaX = alarma > 0 ?
                     `<h1 class="text-xxs h-5 w-5 bg-yellow-300 text-yellow-600 rounded-md font-bold flex justify-center items-center ml-1">${alarma}</h1>` : '';

                  const alertaX = alerta > 0 ?
                     `<h1 class="text-xxs h-5 w-5 bg-blue-300 text-blue-600  rounded-md font-bold flex justify-center items-center ml-1">${alerta}</h1>` : '';

                  const seguimientoX = seguimiento > 0 ?
                     `<h1 class="text-xxs h-5 w-5 bg-teal-300 text-teal-600  rounded-md font-bold flex justify-center items-center ml-1">${seguimiento}</h1>` : '';

                  const proyectosX = proyectos > 0 ?
                     `<h1 class="text-xxs h-5 w-5 text-red-700 bg-red-400  rounded-md font-bold flex justify-center items-center ml-1">${proyectos}</h1>` : '';

                  const codigo = `
                     <div class="ordenarHijosEnergéticos p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center" data-title-subseccion="${subseccion}" ${fSubseccion}>
                        <h1 class="truncate mr-2"> ${subseccion}</h1>
                        <div class="flex flex-row justify-center">
                           ${emergenciaX}
                           ${urgenciaX}
                           ${alarmaX}
                           ${alertaX}
                           ${seguimientoX}
                           ${proyectosX}
                        </div>
                     </div >
                  `;
                  if (document.getElementById("elementos_seccion_" + idSeccion)) {
                     document.getElementById("elementos_seccion_" + idSeccion).insertAdjacentHTML('beforeend', codigo);
                  }
               }
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ` obtenerSecciones = (${idSeccion})`);
         })
   }
}


// EVENTOS PARA LOS BOTONES DE LA SEMANA
btnSeccion_8.addEventListener("click", () => { obtenerSecciones(8, 0) });
btnSeccion_12.addEventListener("click", () => { obtenerSecciones(12, 0) });
btnSeccion_9.addEventListener("click", () => { obtenerSecciones(9, 0) });
btnSeccion_1.addEventListener("click", () => { obtenerSecciones(1, 0) });
btnSeccion_10.addEventListener("click", () => { obtenerSecciones(10, 0) });
btnSeccion_6.addEventListener("click", () => { obtenerSecciones(6, 0) });
btnSeccion_5.addEventListener("click", () => { obtenerSecciones(5, 0) });
btnSeccion_11.addEventListener("click", () => { obtenerSecciones(11, 0) });
btnSeccion_24.addEventListener("click", () => { obtenerSecciones(24, 0) });
btnSeccion_23.addEventListener("click", () => { obtenerSecciones(23, 0) });
btnSeccion_7.addEventListener("click", () => { obtenerSecciones(7, 0) });


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

   // obtenerSecciones(1001, 2);
   obtenerSecciones(8, 2);
   obtenerSecciones(12, 2);
   obtenerSecciones(9, 2);
   obtenerSecciones(1, 2);
   obtenerSecciones(10, 2);
   obtenerSecciones(6, 2);
   obtenerSecciones(5, 2);
   obtenerSecciones(11, 2);
   obtenerSecciones(24, 2);
   obtenerSecciones(23, 2);
   obtenerSecciones(7, 2);
   obtenerSecciones(19, 2);

   switch (hoydia) {
      case "lunes":
         obtenerSecciones(19, 1)
         // obtenerSecciones(1001, 1);
         obtenerSecciones(8, 1);
         obtenerSecciones(12, 1);
         obtenerSecciones(23, 1);
         break;

      case "martes":
         obtenerSecciones(19, 1)
         // obtenerSecciones(1001, 1);
         obtenerSecciones(9, 1);
         obtenerSecciones(23, 1);
         break;

      case "miercoles":
         obtenerSecciones(19, 1)
         // obtenerSecciones(1001, 1);
         obtenerSecciones(1, 1);
         obtenerSecciones(10, 1);
         obtenerSecciones(23, 1);
         break;

      case "jueves":
         obtenerSecciones(19, 1)
         // obtenerSecciones(1001, 1);
         obtenerSecciones(6, 1);
         obtenerSecciones(5, 1);
         obtenerSecciones(23, 1);
         break;

      case "viernes":
         obtenerSecciones(19, 1)
         // obtenerSecciones(1001, 1);
         obtenerSecciones(11, 1);
         obtenerSecciones(24, 1);
         obtenerSecciones(7, 1);
         obtenerSecciones(23, 1);
         break;

      default:
         obtenerSecciones(19, 1)
         // obtenerSecciones(1001, 1);
         obtenerSecciones(8, 1);
         obtenerSecciones(12, 1);
         obtenerSecciones(9, 1);
         obtenerSecciones(1, 1);
         obtenerSecciones(10, 1);
         obtenerSecciones(6, 1);
         obtenerSecciones(5, 1);
         obtenerSecciones(11, 1);
         obtenerSecciones(24, 1);
         obtenerSecciones(23, 1);
         obtenerSecciones(7, 1);
         break;
   }
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


// FUNCION PARA TOGGLE HIDDEN
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

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario')
   let h = new Date();
   let hora = h.getHours() + ": " + h.getMinutes();

   const action = "obtenerDatosCalendario";
   const URL = `php/menu.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {
            document.getElementById("nombreDestino").innerHTML = array.destino;
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
   document.getElementById("hora").innerHTML = hora;
}


// Desde aquí se habla a la función hora(), cada 1min.
setInterval("hora()", 70000);

// toggleClass Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
   if (document.getElementById(idModal)) {
      document.getElementById(idModal).classList.toggle("open");
   }
}


// Funcion para ocultar y mostrar con clases.
function mostrarOcultar(claseMostrar, claseOcultar) {
   $("." + claseMostrar).removeClass("hidden invisible");
   $("." + claseOcultar).addClass("hidden invisible");
}


// toggle Inivisible Generico.
function toggleInivisble(id) {
   // $("#" + id).toggleClass("modal");
   if (document.getElementById(id)) {
      document.getElementById(id).classList.toggle("hidden");
   }
}


// Obtiene los pendientes de las secciones mediante la seccion seleccionada y el destinol.
function pendientesSubsecciones(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino) {

   document.getElementById("btnExpandirMenutoggle").classList.add('hidden');
   document.getElementById("btnvisualizarpendientesdetoggle").classList.add('hidden');

   localStorage.setItem('idSeccion', idSeccion);
   dataSubseccionesPendientes.innerHTML = '';
   btnPendientesIncidencias.setAttribute('onclick', "obtenerPendientesIncidencias('TODOS')");
   misPendientesUsuario.setAttribute('onclick', "obtenerPendientesIncidencias('MISPENDIENTES')");
   misPendientesCreados.setAttribute('onclick', "obtenerPendientesIncidencias('MISCREADOS')");
   misPendientesSinUsuario.setAttribute('onclick', "obtenerPendientesIncidencias('SINASIGNAR')");
   misPendientesSeccion.setAttribute('onclick', "obtenerPendientesIncidencias('TODOS')");
   btnExpandirMenu.classList.add('hidden');
   btnvisualizarpendientesde.classList.add('hidden');
   estiloSeccion.innerHTML = nombreSeccion;

   estiloSeccionPendientes("estiloSeccion", nombreSeccion);

   document.getElementById("modalPendientes").classList.add("open");

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

         // Función para darle diseño del Logo según la Sección.

         document.getElementById("dataExportarSubseccionesEXCEL").
            innerHTML = data.exportarSubseccion;

         document.getElementById("dataExportarSubseccionesPDF").
            innerHTML = data.exportarSubseccionPDF;


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
      },
   });
}


// OBTIENE LOS PENDIENTES MARCADOS COMO TRABAJANDO
const obtenerPendientesIncidencias = tipoBusqueda => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');

   let pendientesI = 0;
   let pendientesDEP = 0;
   let pendientesT = 0;
   let pendientesS = 0;

   // 
   document.getElementById("btnExpandirMenutoggle").classList.add('hidden');
   document.getElementById("btnvisualizarpendientesdetoggle").classList.add('hidden');

   btnPendientesModal('btnPendientesIncidencias');
   estiloSeccion.innerHTML = iconoLoader;

   // MUESTRA LAS OPCIONES
   btnExpandirMenu.classList.remove('hidden');
   btnvisualizarpendientesde.classList.remove('hidden');

   const action = "obtenerPendientesIncidencias";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&tipoBusqueda=${tipoBusqueda}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataSubseccionesPendientes.innerHTML = '';
         dataOpcionesSubseccionestoggle.innerHTML = '';
         tablaPendientesPendientes.innerText = `PENDIENTES (${pendientesI})`;
         tablaPendientesPendientesDEP.innerText = `PENDIENTES DEP (${pendientesDEP})`;
         tablaPendientesTrabajando.innerText = `TRABAJANDO (${pendientesT})`;
         tablaPendientesSolucionado.innerText = `SOLUCIONADOS (${pendientesS})`;
         return array;
      })
      .then(array => {

         if (array.subsecciones) {
            for (let x = 0; x < array.subsecciones.length; x++) {
               const idSubseccion = array.subsecciones[x].idSubseccion;
               const subseccion = array.subsecciones[x].subseccion;
               const codigo = `
                  <tr id="row_subseccion_${idSubseccion}" class="hover:shadow-md cursor-pointer">
                     
                     <td id="row_subseccion_${idSubseccion}_" class="px-2 py-3 font-semibold text-xs text-center text-gray-800">
                           <h1>${subseccion}</h1>
                     </td>
                
                    <td class="px-2 py-3">
                        <div id="row_subseccion_${idSubseccion}_MP" ondblclick="expandirpapa(this.id)" class="h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto" style="width: 270px;">
                        </div>
                    </td>
                    
                     <td class="px-2 py-3">
                        <div id="row_subseccion_${idSubseccion}_DEP" ondblclick="expandirpapa(this.id)" class="h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto" style="width: 270px;">
                        </div>
                     </td>
                
                     <td class="px-2 py-3">
                           <div id="row_subseccion_${idSubseccion}_T" ondblclick="expandirpapa(this.id)" class="h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto" style="width: 270px;">
                           </div>
                     </td>
                
                     <td class="px-2 py-3">
                        <div id="row_subseccion_${idSubseccion}_S" ondblclick="expandirpapa(this.id)" class="h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto" style="width: 270px;">
                        </div>
                    </td>
                
                  </tr>
               `;

               // CREA FILAS DE LAS SUBSECCIONES
               dataSubseccionesPendientes.insertAdjacentHTML('beforeend', codigo);
            }

            for (let x = 0; x < array.subsecciones.length; x++) {
               const idSubseccion = array.subsecciones[x].idSubseccion;
               const subseccion = array.subsecciones[x].subseccion;
               const codigo = `
               <div class="py-1 px-2 w-full hover:bg-gray-700" onchange="toggleInivisble('row_subseccion_${idSubseccion}');">
                        <div class="py-1 px-2 w-full hover:bg-gray-700"></div>
                        <label class="md:w-2/3 block text-gray-500 font-bold">
                            <input class="leading-tight" type="checkbox" checked="">
                            <span class="">
                                ${subseccion}
                            </span>
                        </label>
                    </div>
               `;
               dataOpcionesSubseccionestoggle.insertAdjacentHTML('beforeend', codigo);
            }
         }

         if (array.incidencias) {
            for (let x = 0; x < array.incidencias.length; x++) {
               const idIncidencia = array.incidencias[x].idIncidencia;
               const actividad = array.incidencias[x].actividad;
               const adjuntos = array.incidencias[x].adjuntos;
               const comentario = array.incidencias[x].comentario;
               const nombreComentario = array.incidencias[x].nombreComentario;
               const fechaComentario = array.incidencias[x].fechaComentario;
               const creadoPor = array.incidencias[x].creadoPor;
               const fecha = array.incidencias[x].fecha;
               const responsable = array.incidencias[x].responsable;
               const tipoIncidencia = array.incidencias[x].tipoIncidencia;
               const idSubseccion = array.incidencias[x].idSubseccion;
               const status = array.incidencias[x].status;
               const sTrabajando = array.incidencias[x].sTrabajando;
               const tipo = array.incidencias[x].tipo;
               const sCalidad = array.incidencias[x].sCalidad;
               const sCompras = array.incidencias[x].sCompras;
               const sDireccion = array.incidencias[x].sDireccion;
               const sFinanzas = array.incidencias[x].sFinanzas;
               const sRRHH = array.incidencias[x].sRRHH;
               const sMaterial = array.incidencias[x].sMaterial;
               const cod2bend = array.incidencias[x].cod2bend;

               const iconoMaterial = sMaterial > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" data-title="COD2BEND">
                     <h1 class="font-medium text-black">${cod2bend}</h1>
                  </div>
                  <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Material</h1>
                  </div>`: '';

               const iconoCalidad = sCalidad > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Calidad</h1>
                  </div>`: '';

               const iconoCompras = sCompras > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Compras</h1>
                  </div>` : '';

               const iconoDireccion = sDireccion > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Dirección</h1>
                  </div>` : '';

               const iconoFinanzas = sFinanzas > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Finanzas</h1>
                  </div>` : '';

               const iconoRRHH = sRRHH > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">RRHH</h1>
                  </div>` : '';

               const responsableX = responsable.length > 1 ? responsable : creadoPor;

               const iconoComentario = comentario.length >= 1 ?
                  '<i class="fas fa-comment-dots"></i>' : '';

               const iconoNombreComentario = comentario.length >= 1 ?
                  `<img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombreComentario}" width="20" height="20">` : '';

               const iconoAdjunto = adjuntos >= 1 ?
                  '<i class="fas fa-paperclip mx-1"></i>' : '';

               const iconoT = sTrabajando == 1 ?
                  '<p class="text-xs font-black bg-blue-200 text-blue-500 px-1 rounded mx-1">T</p>' : '';

               const iconoS = status == 'SOLUCIONADO' ?
                  '<p class="text-xs font-black bg-green-200 text-green-500 px-1 mx-1 rounded">F</p >' : '';

               // OPCIONES PARA EDITAR Y PDF
               const btnOpcion = status ==
                  "PENDIENTE" && tipo == "F" ?
                  `
                  <button class="mx-1 py-1 px-2 my-2 rounded-md bg-blue-200 text-blue-500 hover:shadow-sm w-1/3 font-semibold" onclick="obtenerIncidenciaEquipos(${idIncidencia}); toggleModalTailwind('modalVerEnPlannerIncidencia');">
                  <i class="fas fa-edit mr-1 text-sm"></i>Editar</button>
                  
                  <button class="mx-1 py-1 px-2 my-2 rounded-md bg-blue-200 text-blue-500 hover:shadow-sm w-1/3 font-semibold">
                  <a href="OT_Fallas_Tareas/#${tipo + idIncidencia}" class="text-blue-500" target="_blank"><i class="fas fa-file-pdf mr-1  text-xsm"></i> PDF</a>
                  </button>
                  `
                  : status == "PENDIENTE" && tipo == "T" ?
                     `<button class="mx-1 py-1 px-2 my-2 rounded-md bg-blue-200 text-blue-500 hover:shadow-sm w-1/3 font-semibold" onclick="obtenerIncidenciaGeneral(${idIncidencia}); toggleModalTailwind('modalVerEnPlannerIncidencia');">
                        <i class="fas fa-edit mr-1 text-sm"></i>Editar
                     </button>

                     <button class="mx-1 py-1 px-2 my-2 rounded-md bg-blue-200 text-blue-500 hover:shadow-sm w-1/3 font-semibold">
                        <a href="OT_Fallas_Tareas/#${tipo + idIncidencia}" class="text-blue-500" target="_blank"><i class="fas fa-file-pdf mr-1  text-xsm"></i> PDF</a>
                     </button>`
                     :
                     `<button class="py-1 px-2 my-2 rounded-md bg-blue-200 text-blue-500 hover:shadow-sm w-full font-semibold">
                        <a href="OT_Fallas_Tareas/#F${tipo + idIncidencia}" class="text-blue-500" target="_blank"><i class="fas fa-file-pdf mr-1  text-xsm"></i> PDF</a>
                     </button>                  
                  `;

               // ESTILO DE BORDE PARA INDENTIDICAR TIPOS DE INCIDENCIAS
               const estiloBorde =
                  tipoIncidencia == 'URGENCIA' ?
                     `border-2 border-red-500`
                     : tipoIncidencia == "EMERGENCIA" ?
                        `border-2 border-orange-500`
                        : tipoIncidencia == "ALARMA" ?
                           `border-2 border-yellow-500`
                           : tipoIncidencia == "ALERTA" ?
                              `border-2 border-blue-500`
                              : `border-2 border-teal-500`;



               //PENDIENTE INCIDENCIAS 
               const codigo = `
                  <div id="${idIncidencia + '_MP_'}" onclick="expandir(this.id)" class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative ${estiloBorde}">

                     <div class="my-1" data-title-300="${actividad}">
                        <p id="${idIncidencia + '_MP_titulo'}" class="truncate">${actividad}</p>
                     </div>

                     <div class="flex flex-col justify-between text-sm">
                        <div class="flex flex-row justify-start">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${responsableX}" width="20" height="20" alt="">
                           <p class="text-xs font-bold ml-1 text-gray-600">${responsableX}</p>
                        </div>
                        <div class="text-gray-600 flex flex-row justify-end">
                              ${iconoComentario}
                              ${iconoAdjunto}
                              ${iconoT}
                              ${iconoS}
                              ${iconoCalidad}
                              ${iconoCompras}
                              ${iconoDireccion}
                              ${iconoFinanzas}
                              ${iconoRRHH}
                              ${iconoMaterial}
                        </div>
                     </div>

                     <!-- Toogle -->
                     <div id="${idIncidencia + '_MP_toggle'}" class="mt-2 hidden">
                        <div class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                           <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                           <p class="uppercase">${comentario}</p>
                           <div class="flex flex-row self-center mt-1">
                              ${iconoNombreComentario}
                              <p class="text-xs font-bold text-gray-600 mx-1">
                                 ${nombreComentario}
                              </p>
                              <p class="text-xs font-bold text-gray-600 mx-2">
                                 ${fechaComentario}
                              </p>
                           </div>
                        </div>
                        <div class="flex flex-row mt-1 justify-center">
                           ${btnOpcion}
                        </div>
                     </div>
                  </div>               
               `;

               // PENDIENTES DEP
               const codigoDEP = `
                  <div id="${idIncidencia + '_MP_DEP_'}" onclick="expandir(this.id)" class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative ${estiloBorde}">

                     <div class="my-1" data-title-300="${actividad}">
                        <p id="${idIncidencia + '_MP_DEP_titulo'}" class="truncate">${actividad}</p>
                     </div>

                     <div class="flex flex-col justify-between text-sm">
                        <div class="flex flex-row justify-start">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${responsableX}" width="20" height="20" alt="">
                           <p class="text-xs font-bold ml-1 text-gray-600">${responsableX}</p>
                        </div>
                        <div class="text-gray-600 flex flex-row justify-end">
                              ${iconoComentario}
                              ${iconoAdjunto}
                              ${iconoT}
                              ${iconoS}
                              ${iconoCalidad}
                              ${iconoCompras}
                              ${iconoDireccion}
                              ${iconoFinanzas}
                              ${iconoRRHH}
                              ${iconoMaterial}
                        </div>
                     </div>

                     <!-- Toogle -->
                     <div id="${idIncidencia + '_MP_DEP_toggle'}" class="mt-2 hidden">
                        <div class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                           <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                           <p class="uppercase">${comentario} </p>
                           <div class="flex flex-row self-center mt-1">
                              ${iconoNombreComentario}
                              <p class="text-xs font-bold text-gray-600 mx-1">
                                 ${nombreComentario}
                              </p>
                              <p class="text-xs font-bold text-gray-600 mx-2">
                                 ${fechaComentario}
                              </p>
                           </div>
                        </div>
                        <div class="flex flex-row mt-1 justify-center">
                           ${btnOpcion}
                        </div>
                     </div>
                  </div>               
               `;

               // PENDIENTES TRABAJANDO
               const codigoT = `
                  <div id="${idIncidencia + '_MP_T_'}" onclick="expandir(this.id)" class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative ${estiloBorde}">

                     <div class="my-1" data-title-300="${actividad}">
                        <p id="${idIncidencia + '_MP_T_titulo'}" class="truncate">${actividad}</p>
                     </div>

                     <div class="flex flex-col justify-between text-sm">
                        <div class="flex flex-row justify-start">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${responsableX}" width="20" height="20" alt="">
                           <p class="text-xs font-bold ml-1 text-gray-600">${responsableX}</p>
                        </div>
                        <div class="text-gray-600 flex flex-row justify-end">
                              ${iconoComentario}
                              ${iconoAdjunto}
                              ${iconoT}
                              ${iconoS}
                              ${iconoCalidad}
                              ${iconoCompras}
                              ${iconoDireccion}
                              ${iconoFinanzas}
                              ${iconoRRHH}
                              ${iconoMaterial}
                        </div>
                     </div>

                     <!-- Toogle -->
                     <div id="${idIncidencia + '_MP_T_toggle'}" class="mt-2 hidden">
                        <div class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                           <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                           <p class="uppercase">${comentario} </p>
                           <div class="flex flex-row self-center mt-1">
                              ${iconoNombreComentario}
                              <p class="text-xs font-bold text-gray-600 mx-1">
                                 ${nombreComentario}
                              </p>
                              <p class="text-xs font-bold text-gray-600 mx-2">
                                 ${fechaComentario}
                              </p>
                           </div>
                        </div>
                        <div class="flex flex-row mt-1 justify-center">
                           ${btnOpcion}
                        </div>
                     </div>
                  </div>               
               `;

               // PENDIENTES SOLUCIONADOS
               const codigoS = `
                  <div id="${idIncidencia + '_MP_S_'}" onclick="expandir(this.id)" class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative ${estiloBorde}">

                     <div class="my-1" data-title-300="${actividad}">
                        <p id="${idIncidencia + '_MP_S_titulo'}" class="truncate">${actividad}</p>
                     </div>

                     <div class="flex flex-col justify-between text-sm">
                        <div class="flex flex-row justify-start">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${responsableX}" width="20" height="20" alt="">
                           <p class="text-xs font-bold ml-1 text-gray-600">${responsableX}</p>
                        </div>
                        <div class="text-gray-600 flex flex-row justify-end">
                              ${iconoComentario}
                              ${iconoAdjunto}
                              ${iconoT}
                              ${iconoS}                              
                        </div>
                     </div>

                     <!-- Toogle -->
                     <div id="${idIncidencia + '_MP_S_toggle'}" class="mt-2 hidden">
                        <div class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                           <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                           <p class="uppercase">${comentario} </p>
                           <div class="flex flex-row self-center mt-1">
                              ${iconoNombreComentario}
                              <p class="text-xs font-bold text-gray-600 mx-1">
                                 ${nombreComentario}
                              </p>
                              <p class="text-xs font-bold text-gray-600 mx-2">
                                 ${fechaComentario}
                              </p>
                           </div>
                        </div>
                        <div class="flex flex-row mt-1 justify-center">
                           ${btnOpcion}
                        </div>
                     </div>
                  </div>               
               `;

               if (status == "PENDIENTE")
                  if (document.getElementById(`row_subseccion_${idSubseccion}_MP`)) {
                     document.getElementById(`row_subseccion_${idSubseccion}_MP`).
                        insertAdjacentHTML('beforeend', codigo);
                     pendientesI++;
                     tablaPendientesPendientes.innerText = `PENDIENTES (${pendientesI})`;
                  }

               if (status == "PENDIENTE" && (sCalidad > 0 || sCompras > 0 || sDireccion > 0 || sFinanzas > 0 || sRRHH > 0)) {
                  if (document.getElementById(`row_subseccion_${idSubseccion}_DEP`)) {
                     document.getElementById(`row_subseccion_${idSubseccion}_DEP`).
                        insertAdjacentHTML('beforeend', codigoDEP);
                     pendientesDEP++;
                     tablaPendientesPendientesDEP.innerText = `PENDIENTES DEP (${pendientesDEP})`;
                  }
               }

               if (sTrabajando == 1 && status == "PENDIENTE") {
                  if (document.getElementById(`row_subseccion_${idSubseccion}_T`)) {
                     document.getElementById(`row_subseccion_${idSubseccion}_T`).
                        insertAdjacentHTML('beforeend', codigoT);
                     pendientesT++;
                     tablaPendientesTrabajando.innerText = `TRABAJANDO (${pendientesT})`;
                  }
               }

               if (status == "SOLUCIONADO") {
                  if (document.getElementById(`row_subseccion_${idSubseccion}_S`)) {
                     document.getElementById(`row_subseccion_${idSubseccion}_S`).
                        insertAdjacentHTML('beforeend', codigoS);
                     pendientesS++;
                     tablaPendientesSolucionado.innerText = `SOLUCIONADOS (${pendientesS})`;
                  }
               }

            }
         }

         return array.secciones;
      })
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idSeccion = array[x].idSeccion;
               const seccion = array[x].seccion;
               estiloSeccionPendientes("estiloSeccion", seccion);
               estiloSeccion.innerText = seccion;
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
         dataSubseccionesPendientes.innerHTML = '';
         dataOpcionesSubseccionestoggle.innerHTML = '';
         tablaPendientesPendientes.innerText = `PENDIENTES (${pendientesI})`;
         tablaPendientesPendientesDEP.innerText = `PENDIENTES DEP (${pendientesDEP})`;
         tablaPendientesTrabajando.innerText = `TRABAJANDO (${pendientesT})`;
         tablaPendientesSolucionado.innerText = `SOLUCIONADOS (${pendientesS})`;
         estiloSeccion.innerHTML = 'SIN DATOS';

      })
}


// OBTIENE LOS PENDIENTES MARCADOS COMO TRABAJANDO
btnPendientesPreventivos.addEventListener('click', () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');

   let pendientesI = 0;
   let pendientesDEP = 0;
   let pendientesT = 0;
   let pendientesS = 0;

   // 
   document.getElementById("btnExpandirMenutoggle").classList.add('hidden');
   document.getElementById("btnvisualizarpendientesdetoggle").classList.add('hidden');

   // OCULTA LAS OPCIONES
   btnExpandirMenu.classList.add('hidden');
   btnvisualizarpendientesde.classList.add('hidden');
   btnPendientesModal('btnPendientesPreventivos');
   estiloSeccion.innerHTML = iconoLoader;
   const action = "obtenerPendientesMP";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataSubseccionesPendientes.innerHTML = '';
         dataOpcionesSubseccionestoggle.innerHTML = '';
         tablaPendientesPendientes.innerText = `PENDIENTES (${pendientesI})`;
         tablaPendientesPendientesDEP.innerText = `PENDIENTES DEP (${pendientesDEP})`;
         tablaPendientesTrabajando.innerText = `TRABAJANDO (${pendientesT})`;
         tablaPendientesSolucionado.innerText = `SOLUCIONADOS (${pendientesS})`;
         return array;
      })
      .then(array => {

         if (array) {
            for (let x = 0; x < array.subsecciones.length; x++) {
               const idSubseccion = array.subsecciones[x].idSubseccion;
               const subseccion = array.subsecciones[x].subseccion;
               const codigo = `
                  <tr id="row_subseccion_${idSubseccion}" class="hover:shadow-md cursor-pointer">
                     
                     <td id="row_subseccion_${idSubseccion}_" class="px-2 py-3 font-semibold text-xs text-center text-gray-800">
                           <h1>${subseccion}</h1>
                     </td>
                
                    <td class="px-2 py-3">
                        <div id="row_subseccion_${idSubseccion}_MP" ondblclick="expandirpapa(this.id)" class="h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto" style="width: 270px;">
                        </div>
                    </td>
                    
                     <td class="px-2 py-3">
                        <div id="row_subseccion_${idSubseccion}_DEP" ondblclick="expandirpapa(this.id)" class="h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto" style="width: 270px;">
                        </div>
                     </td>
                
                     <td class="px-2 py-3">
                           <div id="row_subseccion_${idSubseccion}_T" ondblclick="expandirpapa(this.id)" class="h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto" style="width: 270px;">
                           </div>
                     </td>
                
                     <td class="px-2 py-3">
                        <div id="row_subseccion_${idSubseccion}_S" ondblclick="expandirpapa(this.id)" class="h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto" style="width: 270px;">
                        </div>
                    </td>
                
                  </tr>
               `;

               // CREA FILAS DE LAS SUBSECCIONES
               dataSubseccionesPendientes.insertAdjacentHTML('beforeend', codigo);
            }

            for (let x = 0; x < array.subsecciones.length; x++) {
               const idSubseccion = array.subsecciones[x].idSubseccion;
               const subseccion = array.subsecciones[x].subseccion;
               const codigo = `
               <div class="py-1 px-2 w-full hover:bg-gray-700" onchange="toggleInivisble('row_subseccion_${idSubseccion}');">
                        <div class="py-1 px-2 w-full hover:bg-gray-700"></div>
                        <label class="md:w-2/3 block text-gray-500 font-bold">
                            <input class="leading-tight" type="checkbox" checked="">
                            <span class="">
                                ${subseccion}
                            </span>
                        </label>
                    </div>
               `;
               dataOpcionesSubseccionestoggle.insertAdjacentHTML('beforeend', codigo);
            }
         }

         if (array) {

            for (let x = 0; x < array.mp.length; x++) {
               const idMP = array.mp[x].idMP;
               const adjuntos = array.mp[x].adjuntos;
               const comentario = array.mp[x].comentario;
               const creadoPor = array.mp[x].creadoPor;
               const fecha = array.mp[x].fecha;
               const responsable = array.mp[x].responsable;
               const tipoPlan = array.mp[x].tipoPlan;
               const idSubseccion = array.mp[x].idSubseccion;
               const idEquipo = array.mp[x].idEquipo;
               const idPlan = array.mp[x].idPlan;
               const semana = array.mp[x].semana;
               const status = array.mp[x].status;
               const sTrabajando = array.mp[x].sTrabajando;
               const sCalidad = array.mp[x].sCalidad;
               const sCompras = array.mp[x].sCompras;
               const sDireccion = array.mp[x].sDireccion;
               const sFinanzas = array.mp[x].sFinanzas;
               const sRRHH = array.mp[x].sRRHH;
               const sMaterial = array.mp[x].sMaterial;
               const cod2bend = array.mp[x].cod2bend;

               const iconoMaterial = sMaterial > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" data-title="COD2BEND">
                     <h1 class="font-medium text-black">${cod2bend}</h1>
                  </div>
                  <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Material</h1>
                  </div>`: '';

               const iconoCalidad = sCalidad > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Calidad</h1>
                  </div>`: '';

               const iconoCompras = sCompras > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Compras</h1>
                  </div>` : '';

               const iconoDireccion = sDireccion > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Dirección</h1>
                  </div>` : '';

               const iconoFinanzas = sFinanzas > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">Finanzas</h1>
                  </div>` : '';

               const iconoRRHH = sRRHH > 0 ?
                  `<div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">RRHH</h1>
                  </div>` : '';

               const responsableX = responsable.length > 1 ? responsable : creadoPor;

               const iconoComentario = comentario.length > 1 ?
                  '<i class="fas fa-comment-dots"></i>' : '';

               const iconoAdjunto = adjuntos >= 1 ?
                  '<i class="fas fa-paperclip mx-2"></i>' : '';

               const iconoT = sTrabajando == 1 ?
                  '<p class="text-xs font-black bg-blue-200 text-blue-500 px-1 rounded">T</p>' : '';

               const iconoS = status == 'SOLUCIONADO' ?
                  '<p class="text-xs font-black bg-green-200 text-green-500 px-1 mx-2 rounded">F</p >' : '';

               const btnOpcion = status == "PROCESO" ?
                  `
                  <button class="mx-1 py-1 px-2 my-2 rounded-md bg-blue-200 text-blue-500 hover:shadow-sm w-1/3 font-semibold" onclick="obtenerOTDigital(${idEquipo}, ${semana}, ${idPlan})">
                  <i class="fas fa-edit mr-1 text-sm"></i>Editar</button>
                  
                  <button class="mx-1 py-1 px-2 my-2 rounded-md bg-blue-200 text-blue-500 hover:shadow-sm w-1/3 font-semibold" onclick="VerOTMPSolucionado(${idEquipo}, ${semana}, ${idPlan})">
                  <i class="fas fa-file-pdf mr-1  text-xsm"></i>PDF</button>
                  `
                  : `
                  <button class="py-1 px-2 my-2 rounded-md bg-blue-200 text-blue-500 hover:shadow-sm w-full font-semibold" onclick="VerOTMPSolucionado(${idEquipo}, ${semana}, ${idPlan})">
                  <i class="fas fa-file-pdf mr-1  text-xsm"></i>PDF</button>                  
                  `;

               const codigo = `
                  <div id="${idMP + '_MP_'}" onclick="expandir(this.id)" class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative">

                     <div class="my-1">
                        <p id="${idMP + '_MP_titulo'}" class="truncate">${tipoPlan + ' OT: #' + idMP}</p>
                     </div>

                     <div class="flex flex-col justify-between text-sm">
                        <div class="flex flex-row justify-start">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${responsableX}" width="20" height="20" alt="">
                           <p class="text-xs font-bold ml-1 text-gray-600">${responsableX}</p>
                        </div>
                        <div class="text-gray-600 flex flex-row justify-end">
                              ${iconoComentario}
                              ${iconoAdjunto}
                              ${iconoT}
                              ${iconoS}
                              ${iconoCalidad}
                              ${iconoCompras}
                              ${iconoDireccion}
                              ${iconoFinanzas}
                              ${iconoRRHH}
                              ${iconoMaterial}
                        </div>
                     </div>

                     <!-- Toogle -->
                     <div id="${idMP + '_MP_toggle'}" class="mt-2 hidden">
                        <div class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                           <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                           <p class="uppercase">${comentario} </p>
                        </div>

                        <div class="flex flex-row mt-1 self-center">
                           <p class="text-xs font-bold ml-6 text-gray-600">${fecha}</p>
                           </div>
                           <div class="flex flex-row items-center justify-center">
                              ${btnOpcion}
                           </div>
                     </div>
                  </div>               
               `;

               const codigoDEP = `
                  <div id="${idMP + '_MP_DEP_'}" onclick="expandir(this.id)" class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative">

                     <div class="my-1">
                        <p id="${idMP + '_MP_DEP_titulo'}" class="truncate">${tipoPlan + ' OT: #' + idMP}</p>
                     </div>

                     <div class="flex flex-col justify-between text-sm">
                        <div class="flex flex-row justify-start">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${responsableX}" width="20" height="20" alt="">
                           <p class="text-xs font-bold ml-1 text-gray-600">${responsableX}</p>
                        </div>
                        <div class="text-gray-600 flex flex-row justify-end">
                              ${iconoComentario}
                              ${iconoAdjunto}
                              ${iconoT}
                              ${iconoS}
                              ${iconoCalidad}
                              ${iconoCompras}
                              ${iconoDireccion}
                              ${iconoFinanzas}
                              ${iconoRRHH}
                              ${iconoMaterial}
                        </div>
                     </div>

                     <!-- Toogle -->
                     <div id="${idMP + '_MP_DEP_toggle'}" class="mt-2 hidden">
                        <div class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                           <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                           <p class="uppercase">${comentario} </p>
                        </div>

                        <div class="flex flex-row mt-1 self-center">
                           <p class="text-xs font-bold ml-6 text-gray-600">${fecha}</p>
                           </div>
                           <div class="flex flex-row items-center justify-center">
                              ${btnOpcion}
                           </div>
                     </div>
                  </div>               
               `;

               const codigoT = `
                  <div id="${idMP + '_MP_T_'}" onclick="expandir(this.id)" class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative">

                     <div class="my-1">
                        <p id="${idMP + '_MP_T_titulo'}" class="truncate">${tipoPlan + ' OT: #' + idMP}</p>
                     </div>

                     <div class="flex flex-col justify-between text-sm">
                        <div class="flex flex-row justify-start">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${responsableX}" width="20" height="20" alt="">
                           <p class="text-xs font-bold ml-1 text-gray-600">${responsableX}</p>
                        </div>
                        <div class="text-gray-600 flex flex-row justify-end">
                              ${iconoComentario}
                              ${iconoAdjunto}
                              ${iconoT}
                              ${iconoS}
                              ${iconoCalidad}
                              ${iconoCompras}
                              ${iconoDireccion}
                              ${iconoFinanzas}
                              ${iconoRRHH}
                              ${iconoMaterial}
                        </div>
                     </div>

                     <!-- Toogle -->
                     <div id="${idMP + '_MP_T_toggle'}" class="mt-2 hidden">
                        <div class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                           <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                           <p class="uppercase">${comentario} </p>
                        </div>

                        <div class="flex flex-row mt-1 self-center">
                           <p class="text-xs font-bold ml-6 text-gray-600">${fecha}</p>
                           </div>
                           <div class="flex flex-row items-center justify-center">
                              ${btnOpcion}
                           </div>
                     </div>
                  </div>               
               `;

               const codigoS = `
                  <div id="${idMP + '_MP_S_'}" onclick="expandir(this.id)" class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative">

                     <div class="my-1">
                        <p id="${idMP + '_MP_S_titulo'}" class="truncate">${tipoPlan + ' OT: #' + idMP}</p>
                     </div>

                     <div class="flex flex-col justify-between text-sm">
                        <div class="flex flex-row justify-start">
                           <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${responsableX}" width="20" height="20" alt="">
                           <p class="text-xs font-bold ml-1 text-gray-600">${responsableX}</p>
                        </div>
                        <div class="text-gray-600 flex flex-row justify-end">
                              ${iconoComentario}
                              ${iconoAdjunto}
                              ${iconoT}
                              ${iconoS}
                              ${iconoMaterial}
                        </div>
                     </div>

                     <!-- Toogle -->
                     <div id="${idMP + '_MP_S_toggle'}" class="mt-2 hidden">
                        <div class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                           <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                           <p class="uppercase">${comentario} </p>
                        </div>

                        <div class="flex flex-row mt-1 self-center">
                           <p class="text-xs font-bold ml-6 text-gray-600">${fecha}</p>
                           </div>
                           <div class="flex flex-row items-center justify-center">
                              ${btnOpcion}
                           </div>
                     </div>
                  </div>               
               `;

               if (status == "PROCESO") {
                  if (document.getElementById(`row_subseccion_${idSubseccion}_MP`)) {
                     document.getElementById(`row_subseccion_${idSubseccion}_MP`).
                        insertAdjacentHTML('beforeend', codigo);
                     pendientesI++;
                     tablaPendientesPendientes.innerText = `PENDIENTES (${pendientesI})`;
                  }

                  if (sCalidad > 0 || sCompras > 0 || sDireccion > 0 || sFinanzas > 0 || sRRHH > 0 || sMaterial > 0) {
                     if (document.getElementById(`row_subseccion_${idSubseccion}_DEP`)) {
                        document.getElementById(`row_subseccion_${idSubseccion}_DEP`).
                           insertAdjacentHTML('beforeend', codigoDEP);
                        pendientesDEP++;
                        tablaPendientesPendientesDEP.innerText = `PENDIENTES DEP (${pendientesDEP})`;
                     }
                  }

                  if (sTrabajando == 1) {
                     if (document.getElementById(`row_subseccion_${idSubseccion}_T`)) {
                        document.getElementById(`row_subseccion_${idSubseccion}_T`).
                           insertAdjacentHTML('beforeend', codigoT);
                        pendientesT++;
                        tablaPendientesTrabajando.innerText = `TRABAJANDO (${pendientesT})`;
                     }
                  }
               }

               if (status == "SOLUCIONADO") {
                  if (document.getElementById(`row_subseccion_${idSubseccion}_S`)) {
                     document.getElementById(`row_subseccion_${idSubseccion}_S`).
                        insertAdjacentHTML('beforeend', codigoS);
                     pendientesS++;
                     tablaPendientesSolucionado.innerText = `SOLUCIONADOS (${pendientesS})`;
                  }
               }

            }
         }
         return array.secciones;
      })
      .then(array => {
         for (let x = 0; x < array.length; x++) {
            const idSeccion = array[x].idSeccion;
            const seccion = array[x].seccion;
            estiloSeccionPendientes("estiloSeccion", seccion);
            estiloSeccion.innerText = seccion;
         }
      })
      .catch(function (err) {
         // fetch(APIERROR + err);
         dataSubseccionesPendientes.innerHTML = '';
         dataOpcionesSubseccionestoggle.innerHTML = '';
         tablaPendientesPendientes.innerText = `PENDIENTES (${pendientesI})`;
         tablaPendientesPendientesDEP.innerText = `PENDIENTES DEP (${pendientesDEP})`;
         tablaPendientesTrabajando.innerText = `TRABAJANDO (${pendientesT})`;
         tablaPendientesSolucionado.innerText = `SOLUCIONADOS (${pendientesS})`;
         estiloSeccion.innerHTML = 'SIN DATOS';
      })
})


// ACTIVDA BOTON
const btnPendientesModal = (btn) => {

   if (btn == "btnPendientesIncidencias") {

      btnPendientesIncidencias.className = 'py-1 px-2 text-red-900 bg-red-200 hover:text-red-500 font-normal cursor-pointer rounded-l';

      btnPendientesPreventivos.className = 'py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer';

   } else if (btn == "btnPendientesPreventivos") {

      btnPendientesPreventivos.className = 'py-1 px-2 text-red-900 bg-red-200 hover:text-red-500 font-normal cursor-pointer';

      btnPendientesIncidencias.className = 'py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer rounded-l';
   }
}


function toggleSubseccionesTipo(mostrar, ocultar) {
   document.getElementById("modalExportarSubsecciones").classList.add("open");
   document.getElementById(mostrar).classList.remove("hidden");
   document.getElementById(ocultar).classList.add("hidden");
}


// Muestra Usuario para Exportar sus pendientes o Creados.
function exportarPorUsuario(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar) {
   // Agrega la función en el Input palabraUsuarioExportar.
   palabraUsuarioExportar.setAttribute("onkeyup", `exportarPorUsuario(${idUsuario}, ${idDestino}, ${idSeccion}, ${idSubseccion}, '${tipoExportar}')`);

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
         palabraUsuario: palabraUsuarioExportar.value
      },
      // dataType: "JSON",
      success: function (data) {
         document.getElementById("dataExportarSeccionesUsuarios").innerHTML = "";
         document.getElementById("modalExportarSeccionesUsuarios").classList.add("open");
         document.getElementById("dataExportarSeccionesUsuarios").innerHTML = data;
      },
      error: function (err) {
         document.getElementById("dataExportarSeccionesUsuarios").innerHTML = "";
      }
   });
}


// El estilo se aplica DIV>H1(class="zie-logo").
function estiloSeccionModal(padreSeccion, seccion = 0) {
   let seccionClase = seccion.toLowerCase() + "-logo-modal";
   document.getElementById(padreSeccion).classList.remove("zil-logo-modal", "zie-logo-modal", "auto-logo-modal", "dec-logo-modal", "dep-logo-modal", "zha-logo-modal", "zhc-logo-modal", "zhp-logo-modal", "zia-logo-modal", "zic-logo-modal", "zhh-logo-modal");

   document.getElementById(padreSeccion).classList.add(seccionClase);
}


// El estilo se aplica DIV>H1(class="zie-logo").
function estiloSeccionPendientes(padreSeccion, seccion) {
   let seccionClase = seccion.toLowerCase() + "-logo";
   document.getElementById(padreSeccion).classList.remove("zil-logo", "zie-logo", "auto-logo", "dec-logo", "dep-logo", "zha-logo", "zhc-logo", "zhp-logo", "zia-logo", "zic-logo", "zhh-logo");

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
function exportarPendientes(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar) {
   let usuarioSession = localStorage.getItem("usuario");
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

   localStorage.setItem("idMC", idMC);
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   const action = "obtenerStatusMC";

   // FUNCIÓN PARA DAR DISEÑO AL MODAL STATUS 
   abrirmodal('modalStatus');
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

         document.getElementById("statusEP")
            .setAttribute("onclick", data.datasEP);

         btnMover.setAttribute("onclick", `moverA(${idMC}, 'EQUIPO')`);
      },
   });
}


// Función para actualizar Status t_mc.
function actualizarStatusMC(idMC, status, valorStatus) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let tituloMC = editarTitulo.value;
   let cod2bend = inputCod2bend.value;
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
function obtenerUsuarios(tipoAsignacion, idItem) {
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   document.getElementById("modalUsuarios").classList.add("open");
   dataUsuarios.innerHTML = iconoLoader;

   const action = "obtenerUsuarios";
   $.ajax({
      type: "POST",
      url: "php/plannerCrudPHP.php",
      data: {
         action: action,
         idUsuario: idUsuario,
         idDestino: idDestino,
         palabraUsuario: palabraUsuario.value,
         tipoAsignacion: tipoAsignacion,
         idItem: idItem,
      },
      dataType: "JSON",
      success: function (data) {
         // alertaImg("Usuarios Obtenidos: " + data.totalUsuarios, "", "info", 2000);
         dataUsuarios.innerHTML = data.dataUsuarios;
         palabraUsuario.
            setAttribute("onkeydown", 'obtenerUsuarios("' + tipoAsignacion + '",' + idItem + ")"
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

   inputAdjuntos.setAttribute("onchange", "subirImagenGeneral(" + idMC + ',"t_mc_adjuntos")');

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
   // document.getElementById("btnAgregarPendiente").setAttribute("onclick", "datosAgregarTarea()");
   document.getElementById("btnAgregarPendiente").
      setAttribute("onclick", "iniciarFormularioInicidencias()");

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

   inputAdjuntos.setAttribute("onchange", "subirImagenGeneral(" + idTarea + ',"adjuntos_mp_np")');

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

   abrirmodal('modalStatus');

   localStorage.setItem("idTarea", idTarea);

   // La función actulizarTarea(?, ?, ?), recibe 3 parametros idTarea, columna a modificar y el tercer parametro solo funciona para el titulo por ahora

   // Status
   btnStatusUrgente.setAttribute("onclick", `actualizarTareas(${idTarea} , 'status_urgente', 0)`);
   btnStatusMaterial.setAttribute("onclick", `actualizarTareas(${idTarea}, 'status_material', 0)`);
   btnStatusTrabajare.setAttribute("onclick", `actualizarTareas(${idTarea}, 'status_trabajando', 0)`);

   // Status Departamento.
   btnStatusCalidad.setAttribute("onclick", `actualizarTareas(${idTarea}, 'departamento_calidad', 0)`);
   btnStatusCompras.setAttribute("onclick", `actualizarTareas(${idTarea}, "'epartamento_compras', 0)`);
   btnStatusDireccion.setAttribute("onclick", `actualizarTareas(${idTarea}, 'departamento_direccion', 0)`);
   btnStatusFinanzas.setAttribute("onclick", `actualizarTareas(${idTarea}, 'departamento_finanzas', 0)`);
   btnStatusRRHH.setAttribute("onclick", `actualizarTareas(${idTarea}, 'departamento_rrhh', 0)`);

   // Status Energéticos.
   btnStatusElectricidad.setAttribute("onclick", `actualizarTareas(${idTarea}, 'energetico_electricidad', 0)`);
   btnStatusAgua.setAttribute("onclick", `actualizarTareas(${idTarea}, 'energetico_agua', 0)`);
   btnStatusDiesel.setAttribute("onclick", `actualizarTareas(${idTarea}, 'energetico_diesel', 0)`);
   btnStatusGas.setAttribute("onclick", `actualizarTareas(${idTarea}, 'energetico_gas', 0)`);

   // Finalizar TAREA
   btnStatusFinalizar.setAttribute("onclick", `actualizarTareas(${idTarea}, 'status', 'F')`);

   // Activo TAREA
   btnStatusActivo.setAttribute("onclick", `actualizarTareas(${idTarea}, 'activo', 0)`);
   // Titulo TAREA
   btnEditarTitulo.setAttribute("onclick", `actualizarTareas(${idTarea}, 'titulo', 0)`);

   // Bitacora GP
   btnStatusGP.setAttribute("onclick", `actualizarTareas(${idTarea}, 'bitacora_gp', 0)`);
   // Bitacora TRS
   btnStatusTRS.setAttribute("onclick", `actualizarTareas(${idTarea}, 'bitacora_trs', 0)`);
   // Bitacora ZI
   btnStatusZI.setAttribute("onclick", `actualizarTareas(${idTarea}, 'bitacora_zi', 0)`);

   // ENTREGA PROYECTO
   btnStatusEP.setAttribute("onclick", `actualizarTareas(${idTarea}, 'status_ep', 0)`);

   btnMover.setAttribute('onclick', `moverA(${idTarea}, 'GENERAL')`);
}


// Actualiza Datos de las Tareas
function actualizarTareas(idTarea, columna, valor) {
   let tituloNuevo = editarTitulo.value;
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");
   let idEquipo = localStorage.getItem("idEquipo");
   let cod2bend = inputCod2bend.value;
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
            cerrarmodal("modalStatus");
         } else if (data == 2) {
            llamarFuncionX("obtenerEquiposAmerica");
            obtenerTareas(idEquipo);
            alertaImg("Tarea SOLUCIONADA", "", "success", 2000);
            cerrarmodal("modalStatus");
         } else if (data == 3) {
            obtenerTareas(idEquipo);
            llamarFuncionX("obtenerEquiposAmerica");
            alertaImg("Tarea Recuperada como PENDIENTE", "", "success", 2000);
            cerrarmodal("modalStatus");
         } else if (data == 4) {
            obtenerTareas(idEquipo);
            llamarFuncionX("obtenerEquiposAmerica");
            alertaImg("Tarea Eliminada", "", "success", 2000);
            cerrarmodal("modalStatus");
         } else if (data == 5) {
            obtenerTareas(idEquipo);
            alertaImg("Título Actualizado", "", "success", 2000);
            cerrarmodal("modalStatus");
         } else if (data == 6) {
            obtenerTareas(idEquipo);
            alertaImg("Rango de Fecha, Actualizada", "", "success", 2000);
            cerrarmodal("modalStatus");
            cerrarmodal("modalFechaTareas");
         } else if (data == 7) {
            obtenerTareas(idEquipo);
            alertaImg("Status Actualizado", "", "success", 2000);
            cerrarmodal("modalStatus");
         } else if (data == 8) {
            obtenerTareas(idEquipo);
            alertaImg("Status Actualizado", "", "success", 2000);
            cerrarmodal("modalStatus");
         } else if (data == 9) {
            obtenerTareas(idEquipo);
            alertaImg("Status EP Actualizado", "", "success", 2000);
            cerrarmodal("modalStatus");
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
               llamarFuncionX("obtenerEquiposAmerica");
               obtenerTareas(idEquipo);
               document.getElementById("inputActividadMC").value = "";
               document.getElementById("modalAgregarMC").classList.remove("open");
               alertaImg("Tarea Agregada", "", "success", 1500);
            } else if (data == 2) {
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
   inputAdjuntos.setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_america_adjuntos")');
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


// AGREGA COMENTARIO A EQUIPO
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
         if (array.length) {
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
   let img = inputAdjuntos.files;
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
            inputAdjuntos.value = "";
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
               // obtenerMediaEquipo(idTabla);
               // obtenerEquiposAmerica(idSeccion, idSubseccion);
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
         }
      },
      error: function (err) {
      }
   });
}


// OBTIENE INFORMACION DE LAS INCIDENCIAS
function obtenerIncidenciaEquipos(idIncidencia) {
   localStorage.setItem('idIncidencia', idIncidencia);
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = 'obtenerIncidenciaEquipos';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         tipoIncidenciaVerEnPlanner.className = '';
         tipoIncidenciaVerEnPlanner.innerHTML = '';
         tituloVerEnPlanner.innerText = '';
         fechaVerEnPlanner.innerText = '';
         creadoPorVerEnPlanner.innerText = '';
         rangoFechaVerEnPlanner.innerText = '';
         asignadoAVerEnPlanner.innerText = '';
         dataComentariosIncidenciaVerEnPlanner.innerHTML = '';
         dataAdjuntosIncidenciaVerEnPlanner.innerHTML = '';
         dataActividadesIncidenciaVerEnPlanner.innerHTML = '';
         responsablesVerEnPlanner.innerHTML = '';
         statusVerEnPlanner.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array) {

            // DATOS
            if (array.incidencia) {
               for (let x = 0; x < array.incidencia.length; x++) {
                  const idIncidencia = array.incidencia[x].idIncidencia;
                  const actividad = array.incidencia[x].actividad;
                  const equipo = array.incidencia[x].equipo;
                  const idEquipo = array.incidencia[x].idEquipo;
                  const tipoIncidencia = array.incidencia[x].tipoIncidencia;
                  const fecha = array.incidencia[x].fecha;
                  const creadoPor = array.incidencia[x].creadoPor;
                  const nombreResponsable = array.incidencia[x].nombreResponsable;
                  const rangoFecha = array.incidencia[x].rangoFecha;

                  const estiloTipoIncidencia =
                     tipoIncidencia == "URGENCIA" ? 'text-red-500 bg-red-200' :
                        tipoIncidencia == "EMERGENCIA" ? 'text-orange-500 bg-orange-200' :
                           tipoIncidencia == "ALARMA" ? 'text-yellow-500 bg-yellow-200' :
                              tipoIncidencia == "ALERTA" ? 'text-blue-500 bg-blue-200' :
                                 'text-teal-500 bg-teal-200';

                  const status_material = array.incidencia[x].status_material == 0 ? ''
                     : `
               <div class="bg-gray-700 text-gray-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'status_material', 0)">
                     <h1 class="font-medium">Material</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const status_trabajando = array.incidencia[x].status_trabajare == 0 ? ''
                     : `
               <div class="text-blue-500 bg-blue-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'status_trabajare', 0)">
                     <h1 class="font-medium">TRABAJANDO</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const departamento_calidad = array.incidencia[x].departamento_calidad == 0 ? ''
                     : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'departamento_calidad', 0)">
                     <h1 class="font-medium">CALIDAD</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const departamento_compras = array.incidencia[x].departamento_compras == 0 ? ''
                     : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'departamento_compras', 0)">
                     <h1 class="font-medium">COMPRAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const departamento_direccion = array.incidencia[x].departamento_direccion == 0 ? ''
                     : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'departamento_direccion', 0)">
                     <h1 class="font-medium">DIRECCIÓN</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const departamento_finanzas = array.incidencia[x].departamento_finanzas == 0 ? ''
                     : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'departamento_finanzas', 0)">
                     <h1 class="font-medium">FINANZAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const departamento_rrhh = array.incidencia[x].departamento_rrhh == 0 ? ''
                     : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'departamento_rrhh', 0)">
                     <h1 class="font-medium">RRHH</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const energetico_electricidad = array.incidencia[x].energetico_electricidad == 0 ? ''
                     : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'energetico_electricidad', 0)">
                     <h1 class="font-medium">ELECTRICIDAD</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const energetico_agua = array.incidencia[x].energetico_agua == 0 ? ''
                     : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'energetico_agua', 0)">
                     <h1 class="font-medium">AGUA</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const energetico_diesel = array.incidencia[x].energetico_diesel == 0 ? ''
                     : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'energetico_diesel', 0)">
                     <h1 class="font-medium">DIESEL</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  const energetico_gas = array.incidencia[x].energetico_gas == 0 ? ''
                     : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarStatusIncidencia(${idIncidencia}, 'energetico_gas', 0)">
                     <h1 class="font-medium">GAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

                  statusVerEnPlanner.insertAdjacentHTML('beforeend', status_material);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', status_trabajando);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_calidad);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_compras);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_direccion);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_finanzas);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_rrhh);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', energetico_electricidad);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', energetico_agua);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', energetico_diesel);
                  statusVerEnPlanner.insertAdjacentHTML('beforeend', energetico_gas);


                  tipoIncidenciaVerEnPlanner.innerHTML = `<h1>${tipoIncidencia}</h1>`;
                  tipoIncidenciaVerEnPlanner.
                     className = 'font-bold text-xs py-1 px-2 rounded-b-md ' + estiloTipoIncidencia;
                  tituloVerEnPlanner.innerHTML = actividad;
                  fechaVerEnPlanner.innerText = fecha;
                  creadoPorVerEnPlanner.innerText = creadoPor;
                  rangoFechaVerEnPlanner.innerText = rangoFecha;
                  asignadoAVerEnPlanner.innerText = equipo;
                  asignadoAVerEnPlanner.
                     setAttribute('onclick', `obtenerFallas(${idEquipo}); toggleModalTailwind('modalTareasFallas'); cerrarmodal('modalVerEnPlannerIncidencia');`)
                  palabraFallaTarea.value = actividad;
                  dispatchEvent(new Event('keyup'));
                  responsablesVerEnPlanner.innerHTML = `
                  <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">${nombreResponsable}</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer" onclick="actualizarStatusIncidencia(${idIncidencia}, 'responsable', 0);"></i>
                  </div>
               `;

                  btnVerOTVerEnPlanner.
                     setAttribute('onclick', `redireccionarOTVerEnPlanner('INCIDENCIA', ${idIncidencia})`);

                  btnAgregarActividadVerEnPlanner.
                     setAttribute('onclick', `agregarActividadesIncidencias(${idIncidencia})`);

                  btnAgregarComentarioVerEnPlanner.
                     setAttribute('onclick', `agregarComentarioIncidencia(${idIncidencia});`);

                  btnStatusVerEnPlanner.
                     setAttribute('onclick', `obtenerStatusIncidencias(${idIncidencia}, 'INCIDENCIA'); toggleModalTailwind('modalStatus');`);

                  btnResponsablesIncidencias.
                     setAttribute('onclick', `obtenerResponsablesIncidencias(${idIncidencia}, 'INCIDENCIA'); toggleModalTailwind('modalUsuarios');`);

                  palabraUsuario.setAttribute('onkeyup', `obtenerResponsablesIncidencias(${idIncidencia}, 'INCIDENCIA');`);

                  inputFileIncidencias.
                     setAttribute('onchange', `agregarAdjuntosIncidenicas(${idIncidencia}, 'INCIDENCIA');`);

                  rangoFechaVerEnPlanner.
                     setAttribute('onclick', `toggleModalTailwind('modalRangoFechaX');`);

                  btnAplicarRangoFecha.
                     setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'rango_fecha', 0)`);
               }
            }

            // COMENTARIOS
            if (array.comentarios) {
               for (let x = 0; x < array.comentarios.length; x++) {
                  const idComentario = array.comentarios[x].idComentario;
                  const comentario = array.comentarios[x].comentario;
                  const nombre = array.comentarios[x].nombre;
                  const apellido = array.comentarios[x].apellido;
                  const fecha = array.comentarios[x].fecha;
                  const codigo = `
                  <div class="flex flex-row justify-center items-center mb-3 w-full bg-teal-100 text-teal-600 p-2 rounded-md hover:shadow-md cursor-pointer relative">
                     <div class="flex items-center justify-center" style="width: 30px;">
                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="30" height="30" alt="">
                     </div>
                     <div class="flex flex-col justify-start items-start p-2 w-full">
                        <div class="font-bold flex flex-row justify-between w-full text-xxs">
                              <div>
                                 <h1>${nombre + ' ' + apellido}</h1>
                              </div>
                              <div class="absolute bottom-0 right-0 mr-1 mb-1">
                                 <p class="font-mono ml-2 text-teal-400">${fecha}</p>
                              </div>
                        </div>
                        <div class="w-full text-xs text-justify">
                              <p>${comentario}</p>
                        </div>
                     </div>
                  </div>
               `;
                  dataComentariosIncidenciaVerEnPlanner.insertAdjacentHTML('beforeend', codigo);
                  dataComentariosIncidenciaVerEnPlanner.
                     scrollTop = dataComentariosIncidenciaVerEnPlanner.scrollHeight;

               }
            }

            // ADJUNTO
            if (array.adjuntos) {
               for (let x = 0; x < array.adjuntos.length; x++) {
                  const idAdjunto = array.adjuntos[x].idAdjunto;
                  const url = array.adjuntos[x].url;
                  const extension = array.adjuntos[x].extension;

                  if (extension == "png" || extension == "jpg" || extension == "jpeg") {
                     codigo = `
                     <a href="planner/tareas/adjuntos/${url}" target="_blank">
                        <div class="bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 m-2 cursor-pointer" style="background-image: url(planner/tareas/adjuntos/${url})"></div>
                     </a>
                  `;
                  } else {
                     codigo = `
                     <a href="planner/tareas/adjuntos/${url}" target="_blank">
                        <div class="w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                           <i class="fad fa-file-alt fa-3x"></i>
                           <p class="text-sm font-normal ml-2">
                           ${url}
                           </p>
                        </div>
                     </a>
                  `;
                  }
                  dataAdjuntosIncidenciaVerEnPlanner.insertAdjacentHTML('beforeend', codigo);
               }
            }

            // ACTIVIDADES
            if (array.actividades) {
               for (let x = 0; x < array.actividades.length; x++) {
                  const idActividad = array.actividades[x].idActividad;
                  const actividad = array.actividades[x].actividad;
                  const status = array.actividades[x].status;
                  const fOpciones = `onclick="mostrarOpcionesActividadIncidencias(${idActividad})"`;

                  const codigo = `
                  <div id="actividad_incidencia_${idActividad}" class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-gray-50">
                     <div class="w-2 h-2 border-2 border-gray-300 hove:bg-green-300 hover:border-green-400 cursor-pointer rounded-full mr-2 flex-none"></div>
                     <div class="text-justify w-full">
                        <h1>${actividad}</h1>
                     </div>
                     <div class="px-2 text-gray-400 hover:text-purple-500 cursor-pointer" ${fOpciones}>
                        <i class="fas fa-ellipsis-h  text-sm"></i>
                     </div>
                  </div>
               `;
                  dataActividadesIncidenciaVerEnPlanner.insertAdjacentHTML('beforeend', codigo);
               }
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ` obtenerIncidenciaEquipos(${idIncidencia})`);
         toggleModalTailwind('modalVerEnPlannerIncidencia');
      })
}


// OBTIENE INFORMACIÓN DE LAS INCIDENCIAS GENERALES
const obtenerIncidenciaGeneral = (idIncidencia) => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   localStorage.setItem('idIncidencia', idIncidencia);

   const action = 'obtenerIncidenciaGeneral';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         tipoIncidenciaVerEnPlanner.className = '';
         tipoIncidenciaVerEnPlanner.innerHTML = '';
         tituloVerEnPlanner.innerText = '';
         fechaVerEnPlanner.innerText = '';
         creadoPorVerEnPlanner.innerText = '';
         rangoFechaVerEnPlanner.innerText = '';
         asignadoAVerEnPlanner.innerText = '';
         dataComentariosIncidenciaVerEnPlanner.innerHTML = '';
         dataAdjuntosIncidenciaVerEnPlanner.innerHTML = '';
         dataActividadesIncidenciaVerEnPlanner.innerHTML = '';
         responsablesVerEnPlanner.innerHTML = '';
         statusVerEnPlanner.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array) {

            // DATOS
            for (let x = 0; x < array.incidencia.length; x++) {
               const idIncidencia = array.incidencia[x].idIncidencia;
               const actividad = array.incidencia[x].actividad;
               const tipoIncidencia = array.incidencia[x].tipoIncidencia;
               const fecha = array.incidencia[x].fecha;
               const creadoPor = array.incidencia[x].creadoPor;
               const nombreResponsable = array.incidencia[x].nombreResponsable;
               const rangoFecha = array.incidencia[x].rangoFecha;
               const idSeccion = array.incidencia[x].idSeccion;
               const idSubseccion = array.incidencia[x].idSubseccion;

               localStorage.setItem('idSeccion', idSeccion);
               localStorage.setItem('idSubseccion', idSubseccion);

               const estiloTipoIncidencia =
                  tipoIncidencia == "URGENCIA" ? 'text-red-500 bg-red-200' :
                     tipoIncidencia == "EMERGENCIA" ? 'text-orange-500 bg-orange-200' :
                        tipoIncidencia == "ALARMA" ? 'text-yellow-500 bg-yellow-200' :
                           tipoIncidencia == "ALERTA" ? 'text-blue-500 bg-blue-200' :
                              'text-teal-500 bg-teal-200';

               const status_material = array.incidencia[x].status_material == 0 ? ''
                  : `
               <div class="bg-gray-700 text-gray-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'status_material', 0)">
                     <h1 class="font-medium">Material</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const status_trabajando = array.incidencia[x].status_trabajando == 0 ? ''
                  : `
               <div class="text-blue-500 bg-blue-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'status_trabajando', 0)">
                     <h1 class="font-medium">TRABAJANDO</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const departamento_calidad = array.incidencia[x].departamento_calidad == 0 ? ''
                  : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_calidad', 0)">
                     <h1 class="font-medium">CALIDAD</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const departamento_compras = array.incidencia[x].departamento_compras == 0 ? ''
                  : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_compras', 0)">
                     <h1 class="font-medium">COMPRAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const departamento_direccion = array.incidencia[x].departamento_direccion == 0 ? ''
                  : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_direccion', 0)">
                     <h1 class="font-medium">DIRECCIÓN</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const departamento_finanzas = array.incidencia[x].departamento_finanzas == 0 ? ''
                  : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_finanzas', 0)">
                     <h1 class="font-medium">FINANZAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const departamento_rrhh = array.incidencia[x].departamento_rrhh == 0 ? ''
                  : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_rrhh', 0)">
                     <h1 class="font-medium">RRHH</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const energetico_electricidad = array.incidencia[x].energetico_electricidad == 0 ? ''
                  : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'energetico_electricidad', 0)">
                     <h1 class="font-medium">ELECTRICIDAD</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const energetico_agua = array.incidencia[x].energetico_agua == 0 ? ''
                  : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'energetico_agua', 0)">
                     <h1 class="font-medium">AGUA</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const energetico_diesel = array.incidencia[x].energetico_diesel == 0 ? ''
                  : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'energetico_diesel', 0)">
                     <h1 class="font-medium">DIESEL</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               const energetico_gas = array.incidencia[x].energetico_gas == 0 ? ''
                  : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'energetico_gas', 0)">
                     <h1 class="font-medium">GAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

               statusVerEnPlanner.insertAdjacentHTML('beforeend', status_material);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', status_trabajando);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_calidad);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_compras);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_direccion);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_finanzas);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', departamento_rrhh);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', energetico_electricidad);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', energetico_agua);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', energetico_diesel);
               statusVerEnPlanner.insertAdjacentHTML('beforeend', energetico_gas);

               tipoIncidenciaVerEnPlanner.innerHTML = `<h1>${tipoIncidencia}</h1>`;

               tipoIncidenciaVerEnPlanner.
                  className = 'font-bold text-xs py-1 px-2 rounded-b-md ' + estiloTipoIncidencia;

               tituloVerEnPlanner.innerHTML = actividad;

               fechaVerEnPlanner.innerText = fecha;

               creadoPorVerEnPlanner.innerText = creadoPor;

               rangoFechaVerEnPlanner.innerText = rangoFecha;

               asignadoAVerEnPlanner.innerText = 'INCIDENCIA GENERAL';

               asignadoAVerEnPlanner.
                  setAttribute('onclick', `obtenerTareas(0); toggleModalTailwind('modalTareasFallas'); cerrarmodal('modalVerEnPlannerIncidencia');`)

               palabraFallaTarea.value = actividad;

               dispatchEvent(new Event('keyup'));

               responsablesVerEnPlanner.innerHTML = `
                  <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">${nombreResponsable}</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer" onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'responsable', 0);"></i>
                  </div>
               `;

               btnVerOTVerEnPlanner.
                  setAttribute('onclick', `redireccionarOTVerEnPlanner('INCIDENCIAGENERAL', ${idIncidencia})`);

               btnAgregarActividadVerEnPlanner.
                  setAttribute('onclick', `agregarActividadesIncidenciaGeneral(${idIncidencia})`);

               btnAgregarComentarioVerEnPlanner.
                  setAttribute('onclick', `agregarComentarioIncidenciaGeneral(${idIncidencia});`);

               btnStatusVerEnPlanner.
                  setAttribute('onclick', `obtenerStatusIncidencias(${idIncidencia}, 'INCIDENCIAGENERAL'); toggleModalTailwind('modalStatus');`);

               btnResponsablesIncidencias.
                  setAttribute('onclick', `obtenerResponsablesIncidencias(${idIncidencia}, 'INCIDENCIAGENERAL'); toggleModalTailwind('modalUsuarios');`);

               palabraUsuario.setAttribute('onkeyup', `obtenerResponsablesIncidencias(${idIncidencia}, 'INCIDENCIAGENERAL');`);

               inputFileIncidencias.
                  setAttribute('onchange', `agregarAdjuntosIncidenicas(${idIncidencia}, 'INCIDENCIAGENERAL');`);

               rangoFechaVerEnPlanner.
                  setAttribute('onclick', `toggleModalTailwind('modalRangoFechaX');`);

               btnAplicarRangoFecha.
                  setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'rango_fecha', 0)`);
            }

            // COMENTARIOS
            for (let x = 0; x < array.comentarios.length; x++) {
               const idComentario = array.comentarios[x].idComentario;
               const comentario = array.comentarios[x].comentario;
               const nombre = array.comentarios[x].nombre;
               const apellido = array.comentarios[x].apellido;
               const fecha = array.comentarios[x].fecha;
               const codigo = `
                  <div class="flex flex-row justify-center items-center mb-3 w-full bg-teal-100 text-teal-600 p-2 rounded-md hover:shadow-md cursor-pointer relative">
                     <div class="flex items-center justify-center" style="width: 30px;">
                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="30" height="30" alt="">
                     </div>
                     <div class="flex flex-col justify-start items-start p-2 w-full">
                        <div class="font-bold flex flex-row justify-between w-full text-xxs">
                              <div>
                                 <h1>${nombre + ' ' + apellido}</h1>
                              </div>
                              <div class="absolute bottom-0 right-0 mr-1 mb-1">
                                 <p class="font-mono ml-2 text-teal-400">${fecha}</p>
                              </div>
                        </div>
                        <div class="w-full text-xs text-justify">
                              <p>${comentario}</p>
                        </div>
                     </div>
                  </div>
               `;
               dataComentariosIncidenciaVerEnPlanner.insertAdjacentHTML('beforeend', codigo);
               dataComentariosIncidenciaVerEnPlanner.
                  scrollTop = dataComentariosIncidenciaVerEnPlanner.scrollHeight;
               dataComentariosIncidenciaVerEnPlanner.sc
            }

            // ADJUNTO
            for (let x = 0; x < array.adjuntos.length; x++) {
               const idAdjunto = array.adjuntos[x].idAdjunto;
               const url = array.adjuntos[x].url;
               const extension = array.adjuntos[x].extension;

               if (extension == "png" || extension == "jpg" || extension == "jpeg") {
                  codigo = `
                     <a href="img/equipos/mpnp/${url}" target="_blank">
                        <div class="bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 m-2 cursor-pointer" style="background-image: url(img/equipos/mpnp/${url})"></div>
                     </a>
                  `;
               } else {
                  codigo = `
                     <a href="img/equipos/mpnp/${url}" target="_blank">
                        <div class="w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                           <i class="fad fa-file-alt fa-3x"></i>
                           <p class="text-sm font-normal ml-2">
                           ${url}
                           </p>
                        </div>
                     </a>
                  `;
               }
               dataAdjuntosIncidenciaVerEnPlanner.insertAdjacentHTML('beforeend', codigo);
            }

            // ACTIVIDADES
            for (let x = 0; x < array.actividades.length; x++) {
               const idActividad = array.actividades[x].idActividad;
               const actividad = array.actividades[x].actividad;
               const status = array.actividades[x].status;
               const fOpciones = `onclick="mostrarOpcionesActividadIncidenciaGeneral(${idActividad})"`;

               const codigo = `
                  <div id="actividad_incidencia_${idActividad}" class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-gray-50">
                     <div class="w-2 h-2 border-2 border-gray-300 hove:bg-green-300 hover:border-green-400 cursor-pointer rounded-full mr-2 flex-none"></div>
                     <div class="text-justify w-full">
                        <h1>${actividad}</h1>
                     </div>
                     <div class="px-2 text-gray-400 hover:text-purple-500 cursor-pointer" ${fOpciones}>
                        <i class="fas fa-ellipsis-h  text-sm"></i>
                     </div>
                  </div>
               `;
               dataActividadesIncidenciaVerEnPlanner.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ` obtenerIncidenciaEquipos(${idIncidencia})`);
         toggleModalTailwind('modalVerEnPlannerIncidencia');
      })
}


// ACTUALIZA LOS STATUS E INFORMACIÓN
function actualizarDatosIncidenciaGeneral(idIncidencia, columna, valor) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   if (columna == "titulo") {
      valor = editarTitulo.value;
   } else if (columna == "rango_fecha") {
      valor = inputRangoFecha.value;
   }

   const action = 'actualizarDatosIncidenciaGeneral';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&columna=${columna}&valor=${valor}&cod2bend=${inputCod2bend.value}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         obtenerIncidenciaGeneral(idIncidencia);
         estiloModalStatus(idIncidencia, 'TAREA');
         if (array == "responsable") {
            alertaImg('Responsable Actualizado', '', 'success', 1500);
            cerrarmodal('modalUsuarios');
         } else if (array == "titulo") {
            alertaImg('Título Trabajando, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "trabajare") {
            alertaImg('Status Trabajando, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "material") {
            alertaImg('Status Matarial, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "departamento") {
            alertaImg('Status Departamento, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "energetico") {
            alertaImg('Status Energético, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "bitacora") {
            alertaImg('Bitacora Actualizada', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "solucionado") {
            obtenerPendientesUsuario();
            alertaImg('Incidencia Solucionada', '', 'success', 1500);
            cerrarmodal('modalStatus');
            cerrarmodal('modalVerEnPlannerIncidencia');
         } else if (array == "eliminado") {
            alertaImg('Incidencia Eliminada', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "restaurado") {
            alertaImg('Incidencia Restaurada', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "rangoFecha") {
            alertaImg('Rango de Fecha Actualizado', '', 'success', 1500);
            cerrarmodal('modalRangoFechaX');
            inputRangoFecha.value = '';
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ` actualizarDatosIncidenciaGeneral(${idIncidencia}, ${columna}, ${valor})`);
      })
}


// OBTIENE DISEÑO DE MODAL STATUS Y AGREGA
function obtenerStatusIncidencias(idIncidencia, tipoIncidencia) {

   if (tipoIncidencia == "INCIDENCIA") {
      estiloModalStatus(idIncidencia, 'FALLA');

      // OPCIONES PARA APLICAR STATUS
      btnStatusUrgente.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'status_urgente', 0)`);
      btnStatusMaterial.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'status_material', 0)`);
      btnStatusTrabajare.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'status_trabajare', 0)`);
      btnStatusCalidad.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'departamento_calidad', 0)`);
      btnStatusCompras.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'departamento_compras', 0)`);
      btnStatusDireccion.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'departamento_direccion', 0)`);
      btnStatusFinanzas.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'departamento_finanzas', 0)`);
      btnStatusRRHH.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'departamento_rrhh', 0)`);
      btnStatusElectricidad.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'energetico_electricidad', 0)`);
      btnStatusAgua.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'energetico_agua', 0)`);
      btnStatusDiesel.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'energetico_diesel', 0)`);
      btnStatusGas.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'energetico_gas', 0)`);
      btnStatusFinalizar.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'status', 0)`);
      btnStatusEP.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'status_ep', 0)`);
      btnStatusActivo.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'eliminar', 0)`);
      btnStatusGP.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'bitacora_gp', 0)`);
      btnStatusTRS.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'bitacora_trs', 0)`);
      btnStatusZI.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'bitacora_zi', 0)`);
      btnEditarTitulo.
         setAttribute('onclick', `actualizarStatusIncidencia(${idIncidencia}, 'titulo', 0)`);

   } else if (tipoIncidencia == "INCIDENCIAGENERAL") {
      estiloModalStatus(idIncidencia, 'TAREA');

      // OPCIONES PARA APLICAR STATUS
      btnStatusUrgente.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'status_urgente', 0)`);
      btnStatusMaterial.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'status_material', 0)`);
      btnStatusTrabajare.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'status_trabajando', 0)`);
      btnStatusCalidad.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_calidad', 0)`);
      btnStatusCompras.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_compras', 0)`);
      btnStatusDireccion.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_direccion', 0)`);
      btnStatusFinanzas.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_finanzas', 0)`);
      btnStatusRRHH.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'departamento_rrhh', 0)`);
      btnStatusElectricidad.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'energetico_electricidad', 0)`);
      btnStatusAgua.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'energetico_agua', 0)`);
      btnStatusDiesel.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'energetico_diesel', 0)`);
      btnStatusGas.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'energetico_gas', 0)`);
      btnStatusFinalizar.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'status', 0)`);
      btnStatusEP.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'status_ep', 0)`);
      btnStatusActivo.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'eliminar', 0)`);
      btnStatusGP.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'bitacora_gp', 0)`);
      btnStatusTRS.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'bitacora_trs', 0)`);
      btnStatusZI.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'bitacora_zi', 0)`);
      btnEditarTitulo.
         setAttribute('onclick', `actualizarDatosIncidenciaGeneral(${idIncidencia}, 'titulo', 0)`);

   }

}


// OBTIENE RESPONSABLES PARA ASIGNA EN INCIDENCIAS
function obtenerResponsablesIncidencias(idIncidencia, tipoIncidencia) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = 'obtenerUsuarios';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&palabraUsuario=${palabraUsuario.value}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataUsuarios.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idUsuario = array[x].idUsuario;
               const nombre = array[x].nombre;
               const apellido = array[x].apellido;
               const cargo = array[x].cargo;

               if (tipoIncidencia == "INCIDENCIA") {
                  fResponsable = `onclick="actualizarStatusIncidencia(${idIncidencia}, 'responsable', ${idUsuario});"`
               } else if (tipoIncidencia == "INCIDENCIAGENERAL") {
                  fResponsable = `onclick="actualizarDatosIncidenciaGeneral(${idIncidencia}, 'responsable', ${idUsuario});"`
               } else if (tipoIncidencia == 'PDA') {
                  fResponsable = `onclick="actualizarInfoPlanaccion(${idIncidencia}, 'responsable', ${idUsuario});"`
               }
               const codigo = `
               <div class="w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate" ${fResponsable}>
                  <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="20" height="20" alt="">
                     <h1 class="ml-2">${nombre + ' ' + apellido}</h1>
                     <p class="font-bold mx-1"> / </p>
                     <h1 class="font-normal text-xs">${cargo}</h1>
               </div>              
              `;
               dataUsuarios.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         dataUsuarios.innerHTML = '';
         fetch(APIERROR + err + ` obtenerResponsablesIncidencias(${idIncidencia}, ${tipoIncidencia})`);
      })
}


// ACTUALIZA LOS STATUS E INFORMACIÓN
function actualizarStatusIncidencia(idIncidencia, columna, valor) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   if (columna == "titulo") {
      valor = editarTitulo.value;
   } else if (columna == "rango_fecha") {
      valor = inputRangoFecha.value;
   }

   const action = 'actualizarStatusIncidencia';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&columna=${columna}&valor=${valor}&cod2bend=${inputCod2bend.value}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         obtenerIncidenciaEquipos(idIncidencia);
         estiloModalStatus(idIncidencia, 'FALLA');
         if (array == "responsable") {
            alertaImg('Responsable Actualizado', '', 'success', 1500);
            cerrarmodal('modalUsuarios');
         } else if (array == "titulo") {
            alertaImg('Título Trabajando, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "trabajare") {
            alertaImg('Status Trabajando, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "material") {
            alertaImg('Status Matarial, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "departamento") {
            alertaImg('Status Departamento, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "energetico") {
            alertaImg('Status Energético, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "bitacora") {
            alertaImg('Bitacora Actualizada', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "solucionado") {
            obtenerPendientesUsuario();
            alertaImg('Incidencia Solucionada', '', 'success', 1500);
            cerrarmodal('modalStatus');
            cerrarmodal('modalVerEnPlannerIncidencia');
         } else if (array == "eliminado") {
            alertaImg('Incidencia Eliminada', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "restaurado") {
            alertaImg('Incidencia Restaurada', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else if (array == "rangoFecha") {
            alertaImg('Rango Fecha Actualizado', '', 'success', 1500);
            cerrarmodal('modalRangoFechaX');
            inputRangoFecha.value = '';
         } else if (array == "ep") {
            alertaImg('Status Entrega Proyecto, Actualizado', '', 'success', 1500);
            cerrarmodal('modalStatus');
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1500);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ` actualizarStatusIncidencia(${idIncidencia}, ${columna}, ${valor})`);
      })
}


// ABRE OT DE INCIDENCIAS E INCICDENCIAS GENERALES
function redireccionarOTVerEnPlanner(tipoOT, idOT) {
   if (tipoOT == "INCIDENCIA") {
      window.open(`OT_Fallas_Tareas/#F${idOT}`, 'OT');
   } else if (tipoOT == "INCIDENCIAGENERAL") {
      window.open(`OT_Fallas_Tareas/#T${idOT}`, 'OT');
   } else if (tipoOT == "PDA") {
      window.open(`OT_proyectos/#P${idOT}`, 'OT');
   }
}


// AGREGA ADJUNTOS EN INCIDENCIAS
function agregarAdjuntosIncidenicas(idIncidencia, tipoIncidencia) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "agregarAdjuntosIncidenicas";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&tipoIncidencia=${tipoIncidencia}`;
   const formData = new FormData();

   if (inputFileIncidencias.files) {
      for (let x = 0; x < inputFileIncidencias.files.length; x++) {
         formData.append('file', inputFileIncidencias.files[x]);

         fetch(URL, {
            method: "POST",
            body: formData
         })
            .then(array => array.json())
            .then(array => {
               if (array == "INCIDENCIA") {
                  alertaImg('Adjunto Agregado', '', 'success', 1500);
                  obtenerIncidenciaEquipos(idIncidencia);
               } else if (array == "INCIDENCIAGENERAL") {
                  alertaImg('Adjunto Agregado', '', 'success', 1500);
                  obtenerIncidenciaGeneral(idIncidencia);
               } else {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
               }
            })
            .then(() => {
               inputFileIncidencias.value = '';
            })
            .catch(function (err) {
               fetch(APIERROR + err + ` agregarAdjuntosIncidenicas(${idIncidencia}, ${tipoIncidencia}) `)
               alertaImg('Intente de Nuevo', '', 'info', 1500);
               inputFileIncidencias.value = '';
            })
      }
   }
}


function agregarActividadesIncidencias(idIncidencia) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "agregarActividadesIncidencias";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&actividad=${actividadVerEnPlanner.value}`;

   if (actividadVerEnPlanner.value.length > 1) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               actividadVerEnPlanner.value = '';
               alertaImg('Acción Agregada', '', 'success', 1400);
               obtenerIncidenciaEquipos(idIncidencia);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1400);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Actividad NO Valida', '', 'info', 1400);
   }
}


function agregarActividadesIncidenciaGeneral(idIncidencia) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "agregarActividadesIncidenciaGeneral";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&actividad=${actividadVerEnPlanner.value}`;

   if (actividadVerEnPlanner.value.length > 1) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               actividadVerEnPlanner.value = '';
               alertaImg('Acción Agregada', '', 'success', 1400);
               obtenerIncidenciaGeneral(idIncidencia);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1400);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Actividad NO Valida', '', 'info', 1400);
   }
}


// AGREGA COMENTARIO EN LA INCIDENCIA
function agregarComentarioIncidencia(idIncidencia) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "agregarComentarioIncidencia";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&comentario=${comentarioIncidenciaVerEnPlanner.value}`;

   if (comentarioIncidenciaVerEnPlanner.value.length) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               comentarioIncidenciaVerEnPlanner.value = '';
               alertaImg('Comentario Agregado', '', 'success', 1400);
               obtenerIncidenciaEquipos(idIncidencia);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1400);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Comentario Vacio', '', 'info', 1400);
   }
}


// AGREGA COMENTARIO EN LA INCIDENCIA GENRAL
function agregarComentarioIncidenciaGeneral(idIncidencia) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "agregarComentarioIncidenciaGeneral";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&comentario=${comentarioIncidenciaVerEnPlanner.value}`;

   if (comentarioIncidenciaVerEnPlanner.value.length) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               comentarioIncidenciaVerEnPlanner.value = '';
               alertaImg('Comentario Agregado', '', 'success', 1400);
               obtenerIncidenciaGeneral(idIncidencia);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1400);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Comentario Vacio', '', 'info', 1400);
   }
}


// OPCIONES PARA ACTIVIDADES EN INCIDENCIAS
function mostrarOpcionesActividadIncidencias(idActividad) {

   aplicarTituloIncidenca.
      setAttribute('onclick', `actualizarActividadesIncidencia(${idActividad}, 'titulo', 0)`);

   btnEliminarActividadIncidencia.
      setAttribute('onclick', `actualizarActividadesIncidencia(${idActividad}, 'eliminar', 0)`);

   // Propiedades para el tooltip
   const button = document.getElementById(`actividad_incidencia_${idActividad}`);
   const tooltip = tooltipOpcionesActividadIncidencias;
   Popper.createPopper(button, tooltip, {
      placement: 'bottom-end'
   });

   if (tooltipOpcionesActividadIncidencias.classList.contains('hidden')) {
      tooltipOpcionesActividadIncidencias.classList.remove('hidden');
   } else {
      tooltipOpcionesActividadIncidencias.classList.add('hidden');
   }
}


// OPCIONES PARA ACTIVIDADES EN INCIDENCIAS
function mostrarOpcionesActividadIncidenciaGeneral(idActividad) {

   aplicarTituloIncidenca.
      setAttribute('onclick', `actualizarActividadesIncidenciaGeneral(${idActividad}, 'titulo', 0)`);

   btnEliminarActividadIncidencia.
      setAttribute('onclick', `actualizarActividadesIncidenciaGeneral(${idActividad}, 'eliminar', 0)`);

   // Propiedades para el tooltip
   const button = document.getElementById(`actividad_incidencia_${idActividad}`);
   const tooltip = tooltipOpcionesActividadIncidencias;
   Popper.createPopper(button, tooltip, {
      placement: 'bottom-end'
   });

   if (tooltipOpcionesActividadIncidencias.classList.contains('hidden')) {
      tooltipOpcionesActividadIncidencias.classList.remove('hidden');
   } else {
      tooltipOpcionesActividadIncidencias.classList.add('hidden');
   }
}


// ACTUALIZA LAS ACTIVIDADES DE LAS INCIDENCIAS
function actualizarActividadesIncidencia(idActividad, columna, valor) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idIncidencia = localStorage.getItem('idIncidencia');

   if (columna == 'titulo') {
      valor = nuevoTituloIncidencia.value;
   }

   const action = 'actualizarActividadesIncidencia';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idActividad=${idActividad}&columna=${columna}&valor=${valor}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         obtenerIncidenciaEquipos(idIncidencia);
         toggleHidden('tooltipOpcionesActividadIncidencias');
         if (array == "titulo") {
            nuevoTituloIncidencia.value = '';
            alertaImg('Actividad Actualizada', '', 'success', 1400);
         } else if (array == "eliminado") {
            alertaImg('Actividad Eliminada', '', 'success', 1400);
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1400);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ` actualizarActividadesIncidencia(${idActividad}, ${columna}, ${valor})`);
      })
}


// ACTUALIZA LAS ACTIVIDADES DE LAS INCIDENCIAS
function actualizarActividadesIncidenciaGeneral(idActividad, columna, valor) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idIncidencia = localStorage.getItem('idIncidencia');

   if (columna == 'titulo') {
      valor = nuevoTituloIncidencia.value;
   }

   const action = 'actualizarActividadesIncidenciaGeneral';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idActividad=${idActividad}&columna=${columna}&valor=${valor}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         obtenerIncidenciaGeneral(idIncidencia);
         toggleHidden('tooltipOpcionesActividadIncidencias');
         if (array == "titulo") {
            nuevoTituloIncidencia.value = '';
            alertaImg('Actividad Actualizada', '', 'success', 1400);
         } else if (array == "eliminado") {
            alertaImg('Actividad Eliminada', '', 'success', 1400);
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1400);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ` actualizarActividadesIncidencia(${idActividad}, ${columna}, ${valor})`);
      })
}


// OBTIENE INFORMACION DE LAS INCIDENCIAS
function verEnPlannerPlanaccion(idPlanaccion) {
   localStorage.setItem('idPlanaccion', idPlanaccion);

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   // EVENTOS
   btnAplicarRangoFecha.setAttribute('onclick', `actualizarInfoPlanaccion(${idPlanaccion}, 'rangoFecha', 0);`)

   const action = 'obtenerPlanaccion';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idPlanaccion=${idPlanaccion}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         // LIMPIA CONTENEDORES
         dataActividadesPlanaccion.innerHTML = '';
         dataComentariosPlanaccion.innerHTML = '';
         dataAdjutnosPlanaccion.innerHTML = '';
         tiluloPlanaccion.innerText = '';
         fechaCreacionPlanaccion.innerText = '';
         creadoPorPlanaccion.innerText = '';
         dataStatusPlanaccion.innerHTML = '';
         dataResponsablesAsignadosPlanaccion.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array) {
            const idSeccion = array.idSeccion;
            const idSubseccion = array.idSubseccion;
            const idProyecto = array.idProyecto;
            const idPlanaccion = array.idPlanaccion;
            const proyecto = array.proyecto;
            const planaccion = array.planaccion;
            const fechaCreacion = array.fechaCreacion;
            const creadoPor = array.creadoPor;
            const rangoFecha = array.rangoFecha;
            const tipoProyecto = array.tipoProyecto;

            const status_material = array.status_material == 0 ? ''
               : `
               <div class="bg-gray-700 text-gray-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'status_material', 0)">
                     <h1 class="font-medium">Material</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const status_trabajando = array.status_trabajando == 0 ? ''
               : `
               <div class="text-blue-500 bg-blue-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'status_trabajando', 0)">
                     <h1 class="font-medium">TRABAJANDO</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const departamento_calidad = array.departamento_calidad == 0 ? ''
               : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_calidad', 0)">
                     <h1 class="font-medium">CALIDAD</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const departamento_compras = array.departamento_compras == 0 ? ''
               : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_compras', 0)">
                     <h1 class="font-medium">COMPRAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const departamento_direccion = array.departamento_direccion == 0 ? ''
               : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_direccion', 0)">
                     <h1 class="font-medium">DIRECCIÓN</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const departamento_finanzas = array.departamento_finanzas == 0 ? ''
               : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_finanzas', 0)">
                     <h1 class="font-medium">FINANZAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const departamento_rrhh = array.departamento_rrhh == 0 ? ''
               : `
               <div class="text-teal-500 bg-teal-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_rrhh', 0)">
                     <h1 class="font-medium">RRHH</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const energetico_electricidad = array.energetico_electricidad == 0 ? ''
               : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'energetico_electricidad', 0)">
                     <h1 class="font-medium">ELECTRICIDAD</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const energetico_agua = array.energetico_agua == 0 ? ''
               : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'energetico_agua', 0)">
                     <h1 class="font-medium">AGUA</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const energetico_diesel = array.energetico_diesel == 0 ? ''
               : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'energetico_diesel', 0)">
                     <h1 class="font-medium">DIESEL</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            const energetico_gas = array.energetico_gas == 0 ? ''
               : `
               <div class="text-yellow-500 bg-yellow-200 px-2 rounded-full flex items-center mr-2" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'energetico_gas', 0)">
                     <h1 class="font-medium">GAS</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
               </div>
            `;

            dataStatusPlanaccion.insertAdjacentHTML('beforeend', status_material);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', status_trabajando);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', departamento_calidad);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', departamento_compras);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', departamento_direccion);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', departamento_finanzas);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', departamento_rrhh);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', energetico_electricidad);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', energetico_agua);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', energetico_diesel);
            dataStatusPlanaccion.insertAdjacentHTML('beforeend', energetico_gas);

            tiluloPlanaccion.innerText = planaccion;
            fechaCreacionPlanaccion.innerText = fechaCreacion;
            creadoPorPlanaccion.innerText = creadoPor;
            rangoFechaPlanaccion.innerText = rangoFecha
            proyectoPlanaccion.innerText = proyecto;
            tipoProyectoPlanaccion.innerText = tipoProyecto;

            proyectoPlanaccion.setAttribute('onclick', `actualizarSeccionSubseccion(${idSeccion}, ${idSubseccion});  toggleModalTailwind('modalProyectos'); obtenerProyectos(${idSeccion}, 'PENDIENTE');`);

            btnResponsablePlanaccion.setAttribute('onclick', `obtenerResponsablesIncidencias(${idPlanaccion}, 'PDA'); toggleModalTailwind('modalUsuarios');`);

            palabraUsuario.
               setAttribute('onkeyup', `obtenerResponsablesIncidencias(${idPlanaccion}, 'PDA');`);

            palabraProyecto.value = proyecto;
            palabraProyecto.dispatchEvent(new Event('keyup'));

            // REOCORRE LOS ELEMENTOS OBTENIDOS (ADJUNTOS)
            for (let x = 0; x < array.adjuntos.length; x++) {
               const idAdjunto = array.adjuntos[x].idAdjunto;
               const url = array.adjuntos[x].url;
               const tipo = array.adjuntos[x].tipo;

               if (tipo == "jpg" || tipo == "png" || tipo == "jpeg") {
                  codigo = `
                     <a href="${'planner/proyectos/planaccion/' + url}" target="_blank">
                        <div class="bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 m-2 cursor-pointer" style="background-image: url(${'planner/proyectos/planaccion/' + url})"></div>
                     </a>
                  `;
               } else {
                  codigo = `
                     <a href="${'planner/proyectos/planaccion/' + url}" target="_blank">
                        <div class="w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                           <i class="fad fa-file-alt fa-3x"></i>
                           <p class="text-sm font-normal ml-2">
                              ${url}
                           </p>
                        </div>
                     </a>

                  `;
               }
               dataAdjutnosPlanaccion.insertAdjacentHTML('beforeend', codigo);
            }

            // REOCORRE LOS ELEMENTOS OBTENIDOS (COMENTARIOS)
            for (let x = 0; x < array.comentarios.length; x++) {
               const idComentario = array.comentarios[x].idComentario;
               const comentario = array.comentarios[x].comentario;
               const fecha = array.comentarios[x].fecha;
               const nombre = array.comentarios[x].nombre;
               const apellido = array.comentarios[x].apellido;

               const codigo = `
                  <div class="flex flex-row justify-center items-center mb-3 w-full bg-teal-100 text-teal-600 p-2 rounded-md hover:shadow-md cursor-pointer relative">

                     <div class="flex items-center justify-center" style="width: 30px;">
                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="30" height="30" alt="">
                     </div>
                     <div class="flex flex-col justify-start items-start p-2 w-full">
                        <div class="font-bold flex flex-row justify-between w-full text-xxs">
                              <div>
                                 <h1>${nombre + ' ' + apellido}</h1>
                              </div>
                              <div class="absolute bottom-0 right-0 mr-1 mb-1">
                                 <p class="font-mono ml-2 text-teal-400">${fecha}</p>
                              </div>
                        </div>
                        <div class="w-full text-xs text-justify">
                              <p>${comentario}</p>
                        </div>
                     </div>
                  </div>
               `;
               dataComentariosPlanaccion.insertAdjacentHTML('beforeend', codigo);
               dataComentariosPlanaccion.scrollTop = dataComentariosPlanaccion.scrollHeight;
            }

            // REOCORRE LOS ELEMENTOS OBTENIDOS (ACTIVIDADES)
            for (let x = 0; x < array.actividades.length; x++) {
               const idActividad = array.actividades[x].idActividad;
               const actividad = array.actividades[x].actividad;
               const status = array.actividades[x].status;

               const fOpciones = `onclick="mostrarOpcionesActividadPlanaccion(${idActividad})"`;

               const codigo = `
                  <div id="actividad_planaccion_${idActividad}" class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-gray-50">
                     <div class="w-2 h-2 border-2 border-gray-300 hove:bg-green-300 hover:border-green-400 cursor-pointer rounded-full mr-2 flex-none"></div>
                        <div class="text-justify w-full">
                           <h1>${actividad}</h1>
                        </div>
                        <div class="px-2 text-gray-400 hover:text-purple-500 cursor-pointer" ${fOpciones}>
                           <i class="fas fa-ellipsis-h  text-sm"></i>
                     </div>
                  </div>
               `;
               dataActividadesPlanaccion.insertAdjacentHTML('beforeend', codigo);
            }

            // RECORRE LOS ELEMENTOS OBTENIDOS (REPSONSABLES)
            for (let x = 0; x < array.responsables.length; x++) {
               const idResponsable = array.responsables[x].idResponsable;
               const responsable = array.responsables[x].responsable;
               const codigo = `
                  <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                     <h1 class="font-medium">${responsable}</h1>
                     <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer" onclick="actualizarInfoPlanaccion(${idPlanaccion}, 'responsable', ${idResponsable});"></i>
                  </div>
               `;
               dataResponsablesAsignadosPlanaccion.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ``);
         // LIMPIA CONTENEDORES
         dataActividadesPlanaccion.innerHTML = '';
         dataComentariosPlanaccion.innerHTML = '';
         dataAdjutnosPlanaccion.innerHTML = '';
         tiluloPlanaccion.innerText = '';
         fechaCreacionPlanaccion.innerText = '';
         creadoPorPlanaccion.innerText = '';
         dataStatusPlanaccion.innerHTML = '';
         dataResponsablesAsignadosPlanaccion.innerHTML = '';
      })
}


btnAgregarComentarioPlanaccion.addEventListener('click', () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idPlanaccion = localStorage.getItem('idPlanaccion');

   const action = "agregarComentarioPlanaccion";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idPlanaccion=${idPlanaccion}&comentario=${inputComentarioPlanaccion.value}`;

   if (inputComentarioPlanaccion.value.length > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               inputComentarioPlanaccion.value = '';
               verEnPlannerPlanaccion(idPlanaccion);
               alertaImg('Comentario Agregado', '', 'success', 1400);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1400);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Comentario Vacio', '', 'info', 1400);
   }
})


btnAgregarActividadPlanaccionX.addEventListener('click', () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idPlanaccion = localStorage.getItem('idPlanaccion');

   const action = "agregarActividadPlanaccion";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idPlanaccion=${idPlanaccion}&actividad=${inputActividadPlanaccion.value}`;

   if (inputActividadPlanaccion.value.length > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               inputActividadPlanaccion.value = '';
               verEnPlannerPlanaccion(idPlanaccion);
               alertaImg('Actividad Agregada', '', 'success', 1400);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1400);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Actividad Vacia', '', 'info', 1400);
   }
})


btnAbrirOTPlanaccion.addEventListener('click', () => {
   let idPlanaccion = localStorage.getItem('idPlanaccion');
   if (idPlanaccion > 0) {
      window.open(`OT_proyectos/#P${idPlanaccion}`, 'OT PLANACCIÓN');
   } else {
      alert(`OT #${idPlanaccion} No Encontrada`, 'info', 1500);
   }
})


btnStatusPlanaccion.addEventListener('click', () => {
   let idPlanaccion = localStorage.getItem('idPlanaccion');

   abrirmodal('modalStatus');
   estiloModalStatus(idPlanaccion, 'PLANACCION');

   btnStatusMaterial.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'status_material', 0);`);

   btnStatusTrabajare.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'status_trabajando', 0);`);

   btnStatusCalidad.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_calidad', 0);`);

   btnStatusCompras.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_compras', 0);`);

   btnStatusDireccion.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_direccion', 0);`);

   btnStatusFinanzas.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_finanzas', 0);`);

   btnStatusRRHH.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'departamento_rrhh', 0);`);

   btnStatusElectricidad.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'energetico_electricidad', 0);`);

   btnStatusAgua.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'energetico_agua', 0);`);

   btnStatusDiesel.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'energetico_diesel', 0);`);

   btnStatusGas.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'energetico_gas', 0);`);

   btnStatusFinalizar.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'status', 0);`);

   btnStatusEP.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'status_ep', 0);`);

   btnStatusActivo.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'activo', 0);`);

   btnEditarTitulo.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'actividad', 0);`);

   btnStatusGP.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'bitacora_gp', 0);`);

   btnStatusTRS.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'bitacora_trs', 0);`);

   btnStatusZI.setAttribute('onclick',
      `actualizarInfoPlanaccion(${idPlanaccion}, 'bitacora_zi', 0);`);
})


// ACTUALIZA LA INFORMACIÓN DE PLAN DE ACCIÓN
function actualizarInfoPlanaccion(idPlanaccion, columna, valor) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');

   if (columna == "rangoFecha") {
      valor = inputRangoFecha.value;
   } else if (columna == "status_material") {
      valor = inputCod2bend.value;
   } else if (columna == "actividad") {
      valor = editarTitulo.value;
   }

   const action = "actualizarInfoPlanaccion";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idPlanaccion=${idPlanaccion}&columna=${columna}&valor=${valor}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         verEnPlannerPlanaccion(idPlanaccion);
         estiloModalStatus(idPlanaccion, 'PLANACCION');

         if (array == "rangoFecha") {
            cerrarmodal('modalRangoFechaX');
            alertaImg('Rango de Fecha, Actualizado', '', 'success', 1500);
         } else if (array == "material") {
            alertaImg('Status Material, Actualizado', '', 'success', 1500);
         } else if (array == "departamento") {
            alertaImg('Status Departamento, Actualizado', '', 'success', 1500);
         } else if (array == "energetico") {
            alertaImg('Status Energetico, Actualizado', '', 'success', 1500);
         } else if (array == "bitacora") {
            alertaImg('Status Bitacora, Actualizado', '', 'success', 1500);
         } else if (array == "solucionado") {
            alertaImg('Planaccion Solucionado', '', 'success', 1500);
            obtenerPendientesUsuario();
            cerrarmodal('modalStatus');
            cerrarmodal('modalVerEnPlannerPlanaccion');
         } else if (array == "actividad") {
            alertaImg('Planaccion Solucionado', '', 'success', 1500);
         } else if (array == "eliminado") {
            alertaImg('Planaccion Solucionado', '', 'success', 1500);
         } else if (array == "responsable") {
            alertaImg('Resposable Actualizado', '', 'success', 1500);
         } else {
            alertaImg('Intente de Nuevo', '', 'success', 1500);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
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


inputFilePlanaccion.addEventListener('change', () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idPlanaccion = localStorage.getItem('idPlanaccion');

   const action = "agregarAdjuntoPlanaccion";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idPlanaccion=${idPlanaccion}`;

   // VARIABLES DEL ADJUNTO

   if (inputFilePlanaccion.files) {
      for (let x = 0; x < inputFilePlanaccion.files.length; x++) {
         const formData = new FormData();
         formData.append('file', inputFilePlanaccion.files[x]);

         fetch(URL, {
            method: "POST",
            body: formData
         })
            .then(array => array.json())
            .then(array => {
               if (array == 1) {
                  verEnPlannerPlanaccion(idPlanaccion);
                  alertaImg('Adjunto Agregado', '', 'success', 1500);
               } else {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
               }
            })
            .then(() => {
               inputFilePlanaccion.value = '';
            })
            .catch(function (err) {
               fetch(APIERROR + err + ` agregarAdjuntoTest(${idTest})`)
               alertaImg('Intente de Nuevo', '', 'info', 1500);
               inputFilePlanaccion.value = '';
            })
      }
   }
})


// OPCIONES PARA ACTIVIDADES EN PLANACCION
function mostrarOpcionesActividadPlanaccion(idActividad) {

   btnAplicarNuevoTituloPlanacciontoggle.
      setAttribute('onclick', `actualizarActividadesPlanaccion(${idActividad}, 'titulo', 0)`);

   btnEliminarActividadPlanaccion.
      setAttribute('onclick', `actualizarActividadesPlanaccion(${idActividad}, 'eliminar', 0)`);

   // Propiedades para el tooltip
   const button = document.getElementById(`actividad_planaccion_${idActividad}`);
   const tooltip = tooltipOpcionesActividadPlanaccion;
   Popper.createPopper(button, tooltip, {
      placement: 'bottom-end'
   });

   if (tooltipOpcionesActividadPlanaccion.classList.contains('hidden')) {
      tooltipOpcionesActividadPlanaccion.classList.remove('hidden');
   } else {
      tooltipOpcionesActividadPlanaccion.classList.add('hidden');
   }
}


// ACTUALIZA LA INFORMACION DE LA ACTIVIDADES DEL PLANA DE ACCION
function actualizarActividadesPlanaccion(idActividad, columna, valor) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idPlanaccion = localStorage.getItem('idPlanaccion');

   if (columna == "titulo") {
      valor = nuevoTituloPlanaccion.value;
   }

   const action = "actualizarActividadesPlanaccion";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idActividad=${idActividad}&columna=${columna}&valor=${valor}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         nuevoTituloPlanaccion.value = '';

         if (array == "titulo") {
            expandir('btnNuevoTituloPlanaccion');
            expandir('btnAplicarNuevoTituloPlanaccion')
            verEnPlannerPlanaccion(idPlanaccion);
            alertaImg('Actividad Actuliaza', '', 'success', 1500)
            mostrarOpcionesActividadPlanaccion(idActividad);
         } else if (array == "eliminar") {
            mostrarOpcionesActividadPlanaccion(idActividad);
            verEnPlannerPlanaccion(idPlanaccion);
            alertaImg('Actividad Eliminada', '', 'success', 1500)
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1500)
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + `actualizarActividadesPlanaccion(${idActividad}, ${columna}, ${valor})`);
      })
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


// DISEÑO DE CONTENEDORES PARA modalMPEquipo
const diseñoOpcionesSuperioresEquipo = (contenedor, btn) => {
   // OCULTA CONTENEDORES
   const contenedoresArray = ["contenedorCaracteristicasEquipo", "contenedorDespiedeEquipo", "contenedorAdjuntosEquipo"];
   contenedoresArray.forEach(x => {
      const y = document.getElementById(x);
      if (x != contenedor) {
         y.classList.add('hidden');
      } else {
         y.classList.remove('hidden');
      }
   });

   // APLICA ESTILO A BTN ACTIVO
   const btnArray = ["btnInformacionEquipo", "btnDespieceEquipo", "btnDocumentosEquipo", "btnCotizacionesEquipo"];
   btnArray.forEach(x => {
      const y = document.getElementById(x);
      if (x == btn) {
         y.classList.add('bg-purple-200', 'text-purple-500');
      } else {
         y.classList.remove('bg-purple-200', 'text-purple-500');
      }
   });
}


// DISEÑO DE CONTENEDORES PARA modalMPEquipo
const diseñoOpcionesInferioresEquipo = (contenedor, btn) => {
   // OCULTA CONTENEDORES
   const contenedoresArray = ["contenedorPlanesEquipo", "contenedorIncidenciasEquipo", "contenedorChecklistEquipo", "contenedorBitacoraEquipo"];
   contenedoresArray.forEach(x => {
      const y = document.getElementById(x);
      if (x != contenedor) {
         y.classList.add('hidden');
      } else {
         y.classList.remove('hidden');
      }
   });

   // APLICA ESTILO A BTN ACTIVO
   const btnArray = ["btnPreventivosEquipo", "btnIncidenciasEquipo", "btnChecklistEquipo", "btnBitacorasEquipo"];
   btnArray.forEach(x => {
      const y = document.getElementById(x);
      if (x == btn) {
         y.classList.add('bg-purple-200', 'text-purple-500');
      } else {
         y.classList.remove('bg-purple-200', 'text-purple-500');
      }
   });
}


// HABILITA O DESAHABILITA INPUTS Y BOTONES modalMPEquipos
function toggleDisabledEditarEquipo(estadoInputs) {
   let idEquipo = localStorage.getItem('idEquipo');

   const arrayBtnEquipo =
      ['capacidadEquipo', 'fechaInstalacionEquipo', 'fechaCompraEquipo', 'añoGarantiaEquipo', 'añoVidaUtilEquipo', 'nombreEquipo', 'seccionEquipo', 'subseccionEquipo', 'tipoEquipo', 'jerarquiaEquipo', 'marcaEquipo', 'modeloEquipo', 'serieEquipo', 'codigoFabricanteEquipo', 'codigoInternoComprasEquipo', 'largoEquipo', 'anchoEquipo', 'altoEquipo', 'potenciaElectricaHPEquipo', 'potenciaElectricaKWEquipo', 'voltajeEquipo', 'frecuenciaEquipo', 'caudalAguaM3HEquipo', 'caudalAguaGPHEquipo', 'cargaMCAEquipo', 'PotenciaEnergeticaFrioKWEquipo', 'potenciaEnergeticaFrioTREquipo', 'potenciaEnergeticaCalorKCALEquipo', 'caudalAireM3HEquipo', 'caudalAireCFMEquipo', 'estadoEquipo', 'idFaseEquipo', 'tipoLocalEquipo', 'dataOpcionesEquipos']

   arrayBtnEquipo.forEach(element => {
      if (estadoInputs == 1) {
         document.getElementById(element).removeAttribute('disabled');
      } else {
         document.getElementById(element).setAttribute('disabled', false);
      }
   });

   btnEditarEquipo.setAttribute('onclick', `toggleDisabledEditarEquipo(1); cancelarInformacionEquipo(${idEquipo})`);
   btnCancelarEquipo.
      setAttribute('onclick', `toggleDisabledEditarEquipo(2); cancelarInformacionEquipo(${idEquipo})`);
   btnGuardarEquipo.setAttribute('onclick', `actualizarEquipo(${idEquipo})`);

   if (estadoInputs == 1) {
      alertaImg('Editar Equipo, Habilitado', '', 'info', 1500);
      btnEditarEquipo.classList.add('hidden');
      btnGuardarEquipo.classList.remove('hidden');
      btnCancelarEquipo.classList.remove('hidden');
   } else if (estadoInputs == 0) {
      btnEditarEquipo.classList.remove('hidden');
      btnGuardarEquipo.classList.add('hidden');
      btnCancelarEquipo.classList.add('hidden');
   } else if (estadoInputs == 2) {
      alertaImg('Restaurando Datos...', '', 'info', 1500);
      btnEditarEquipo.classList.remove('hidden');
      btnGuardarEquipo.classList.add('hidden');
      btnCancelarEquipo.classList.add('hidden');
   }
}


// OBTIENE LA INFORMACION ACTUAL DE EQUIPO
function cancelarInformacionEquipo(idEquipo) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const URL = `php/select_REST_planner.php?action=obtenerEquipoPorId&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         e_capacidadEquipo.value = '';
         e_fechaInstalacionEquipo.value = '';
         e_fechaCompraEquipo.value = '';
         e_añoGarantiaEquipo.value = '';
         e_añoVidaUtilEquipo.value = '';
         e_nombreEquipo.value = '';
         e_estadoEquipo.value = '';
         e_tipoLocalEquipo.value = '';
         e_idFaseEquipo.value = '';
         e_seccionEquipo.value = '';
         e_subseccionEquipo.value = '';
         e_tipoEquipo.value = '';
         e_jerarquiaEquipo.value = '';
         e_dataOpcionesEquipos.value = '';
         e_marcaEquipo.value = '';
         e_modeloEquipo.value = '';
         e_serieEquipo.value = '';
         e_codigoFabricanteEquipo.value = '';
         e_codigoInternoComprasEquipo.value = '';
         e_cantidadEquipo.value = '';
         e_largoEquipo.value = '';
         e_anchoEquipo.value = '';
         e_altoEquipo.value = '';
         e_potenciaElectricaHPEquipo.value = '';
         e_potenciaElectricaKWEquipo.value = '';
         e_voltajeEquipo.value = '';
         e_frecuenciaEquipo.value = '';
         e_caudalAguaM3HEquipo.value = '';
         e_caudalAguaGPHEquipo.value = '';
         e_cargaMCAEquipo.value = '';
         e_PotenciaEnergeticaFrioKWEquipo.value = '';
         e_potenciaEnergeticaFrioTREquipo.value = '';
         e_potenciaEnergeticaCalorKCALEquipo.value = '';
         e_caudalAireM3HEquipo.value = '';
         e_caudalAireCFMEquipo.value = '';

         return array;
      })
      .then(array => {
         if (array) {
            e_nombreEquipo.value = array.equipo;
            e_estadoEquipo.value = array.status;
            e_tipoLocalEquipo.value = array.localEquipo;
            e_idFaseEquipo.value = array.idFases;

            e_seccionEquipo.value = array.idSeccion;
            e_subseccionEquipo.value = array.idSubseccion;
            e_tipoEquipo.value = array.idTipo;
            e_jerarquiaEquipo.value = array.jerarquia;
            e_dataOpcionesEquipos.value = array.idEquipoPrincipal;

            e_fechaInstalacionEquipo.value = array.fechaInstalacion;
            e_fechaCompraEquipo.value = array.fechaCompra;
            e_añoGarantiaEquipo.value = array.añoGarantia;
            e_añoVidaUtilEquipo.value = array.añoVidaUtil;

            e_marcaEquipo.value = array.idMarca;
            e_modeloEquipo.value = array.modelo;
            e_serieEquipo.value = array.serie;
            e_codigoFabricanteEquipo.value = array.codigoFabricante;
            e_codigoInternoComprasEquipo.value = array.codigoInternoCompras;

            e_cantidadEquipo.value = array.cantidad;
            e_largoEquipo.value = array.largo_cm;
            e_anchoEquipo.value = array.ancho_cm;
            e_altoEquipo.value = array.alto_cm;

            e_potenciaElectricaHPEquipo.value = array.potencia_electrica_hp;
            e_potenciaElectricaKWEquipo.value = array.potencia_electrica_kw;
            e_voltajeEquipo.value = array.voltaje_v;
            e_frecuenciaEquipo.value = array.frecuencia_hz;
            e_capacidadEquipo.value = array.capacidad;

            e_caudalAguaM3HEquipo.value = array.caudal_agua_m3h;
            e_caudalAguaGPHEquipo.value = array.caudal_agua_gph;
            e_cargaMCAEquipo.value = array.carga_mca;

            e_PotenciaEnergeticaFrioKWEquipo.value = array.potencia_energetica_frio_kw;
            e_potenciaEnergeticaFrioTREquipo.value = array.potencia_energetica_frio_tr;

            e_potenciaEnergeticaCalorKCALEquipo.value =
               array.potencia_energetica_calor_kcal;

            e_caudalAireM3HEquipo.value = array.caudal_aire_m3h;
            e_caudalAireCFMEquipo.value = array.caudal_aire_cfm;
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
         e_fechaInstalacionEquipo.value = '';
         e_fechaCompraEquipo.value = '';
         e_añoGarantiaEquipo.value = '';
         e_añoVidaUtilEquipo.value = '';
         e_capacidadEquipo.value = '';
         e_nombreEquipo.value = '';
         e_estadoEquipo.value = '';
         e_tipoLocalEquipo.value = '';
         e_idFaseEquipo.value = '';
         e_seccionEquipo.value = '';
         e_subseccionEquipo.value = '';
         e_tipoEquipo.value = '';
         e_jerarquiaEquipo.value = '';
         e_dataOpcionesEquipos.value = '';
         e_marcaEquipo.value = '';
         e_modeloEquipo.value = '';
         e_serieEquipo.value = '';
         e_codigoFabricanteEquipo.value = '';
         e_codigoInternoComprasEquipo.value = '';
         e_cantidadEquipo.value = '';
         e_largoEquipo.value = '';
         e_anchoEquipo.value = '';
         e_altoEquipo.value = '';
         e_potenciaElectricaHPEquipo.value = '';
         e_potenciaElectricaKWEquipo.value = '';
         e_voltajeEquipo.value = '';
         e_frecuenciaEquipo.value = '';
         e_caudalAguaM3HEquipo.value = '';
         e_caudalAguaGPHEquipo.value = '';
         e_cargaMCAEquipo.value = '';
         e_PotenciaEnergeticaFrioKWEquipo.value = '';
         e_potenciaEnergeticaFrioTREquipo.value = '';
         e_potenciaEnergeticaCalorKCALEquipo.value = '';
         e_caudalAireM3HEquipo.value = '';
         e_caudalAireCFMEquipo.value = '';
      })
}


// ACTUALIZA INFORMACIÓN DE LOS EQUIPOS
function actualizarEquipo(idEquipo) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "actualizarEquipo";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

   const data = new FormData()
   data.append('idEquipo', idEquipo);
   data.append('fechaInstalacion', e_fechaInstalacionEquipo.value);
   data.append('fechaCompra', e_fechaCompraEquipo.value);
   data.append('añoGarantia', e_añoGarantiaEquipo.value);
   data.append('añoVidaUtil', e_añoVidaUtilEquipo.value);
   data.append('capacidad', e_capacidadEquipo.value);
   data.append('equipo', e_nombreEquipo.value);
   data.append('status', e_estadoEquipo.value);
   data.append('localEquipo', e_tipoLocalEquipo.value);
   data.append('idFases', e_idFaseEquipo.value);
   data.append('idSeccion', e_seccionEquipo.value);
   data.append('idSubseccion', e_subseccionEquipo.value);
   data.append('idTipo', e_tipoEquipo.value);
   data.append('jerarquia', e_jerarquiaEquipo.value);
   data.append('idEquipoPrincipal', e_dataOpcionesEquipos.value);
   data.append('idMarca', e_marcaEquipo.value);
   data.append('modelo', e_modeloEquipo.value);
   data.append('serie', e_serieEquipo.value);
   data.append('codigoFabricante', e_codigoFabricanteEquipo.value);
   data.append('codigoInternoCompras', e_codigoInternoComprasEquipo.value);
   data.append('cantidad', e_cantidadEquipo.value);
   data.append('largo_cm', e_largoEquipo.value);
   data.append('ancho_cm', e_anchoEquipo.value);
   data.append('alto_cm', e_altoEquipo.value);
   data.append('potencia_electrica_hp', e_potenciaElectricaHPEquipo.value);
   data.append('potencia_electrica_kw', e_potenciaElectricaKWEquipo.value);
   data.append('voltaje_v', e_voltajeEquipo.value);
   data.append('frecuencia_hz', e_frecuenciaEquipo.value);
   data.append('caudal_agua_m3h', e_caudalAguaM3HEquipo.value);
   data.append('caudal_agua_gph', e_caudalAguaGPHEquipo.value);
   data.append('carga_mca', e_cargaMCAEquipo.value);
   data.append('potencia_energetica_frio_kw', e_PotenciaEnergeticaFrioKWEquipo.value);
   data.append('potencia_energetica_frio_tr', e_potenciaEnergeticaFrioTREquipo.value);
   data.append('potencia_energetica_calor_kcal', e_potenciaEnergeticaCalorKCALEquipo.value);
   data.append('caudal_aire_m3h', e_caudalAireM3HEquipo.value);
   data.append('caudal_aire_cfm', e_caudalAireCFMEquipo.value);

   if (e_nombreEquipo.value.length > 0 && e_estadoEquipo.value != ""
      && e_tipoLocalEquipo.value != "" && e_seccionEquipo.value > 0
      && e_subseccionEquipo.value > 0 && e_tipoEquipo.value > 0 && e_jerarquiaEquipo.value != "") {

      fetch(URL, {
         method: "POST",
         body: data
      })
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               alertaImg('Datos Actualizados', '', 'success', 1200)
               informacionEquipo(idEquipo)
            } else {
               alertaImg('No se Guardaron los Cambios', '', 'info', 1400)
               informacionEquipo(idEquipo)
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
            informacionEquipo(idEquipo)
         })
   } else {
      alertaImg('Datos NO Validos', '', 'info', 1200);
   }
}


// OBTIENE INFORMACION DE EQUIPO
function informacionEquipo(idEquipo) {
   localStorage.setItem("idEquipo", idEquipo);
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   // FUNCIONES INICIALES
   toggleDisabledEditarEquipo(0);
   inputFotografiaEquipo.setAttribute('onchange', `subirImagenEquipo(${idEquipo})`);
   btnAñadirMaterialEquipo.setAttribute('onclick', `obtenerOpcionesMaterialesEquipo(${idEquipo}, 'PREVENTIVO'); abrirmodal('modalOpcionesMaterialesEquipo')`);

   // OPCIONES SUPERIORES
   btnInformacionEquipo.setAttribute('onclick', `informacionEquipo(${idEquipo})`);
   btnDespieceEquipo.setAttribute('onclick', `despieceEquipos(${idEquipo}); despieceMaterailesEquipo(${idEquipo}, 'PREVENTIVO')`);
   btnDocumentosEquipo.setAttribute('onclick', `obtenerAdjuntosEquipo(${idEquipo})`);
   btnCotizacionesEquipo.setAttribute('onclick', `obtenerCotizacionesEquipo(${idEquipo})`);

   // OPCIONES INFERIORES
   btnPreventivosEquipo.setAttribute('onclick', `consultarPlanEquipo(${idEquipo});`);
   btnIncidenciasEquipo.setAttribute('onclick', `obtenerIncidenciasEquipo(${idEquipo})`);
   btnChecklistEquipo.setAttribute('onclick', `consultarPlanLocal(${idEquipo})`);
   btnBitacorasEquipo.setAttribute('onclick', `obtenerBitacoraEquipo(${idEquipo})`);

   const URL = `php/select_REST_planner.php?action=obtenerSeccionesSubseccionPorDestino&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;
   let promesa = new Promise((resolve, reject) => {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            // LIMPIA CONTENEDORES DE OPCIONES
            e_seccionEquipo.innerHTML = '<option value="0">No Seleccionado</option>';
            e_subseccionEquipo.innerHTML = '<option value="0">No Seleccionado</option>';
            e_tipoEquipo.innerHTML = '<option value="0">No Seleccionado</option>';
            e_dataOpcionesEquipos.innerHTML = '<option value="0">No Seleccionado</option>';
            e_marcaEquipo.innerHTML = '<option value="0">No Seleccionado</option>';
            e_jerarquiaEquipo.value = 0;
            diseñoOpcionesSuperioresEquipo('contenedorCaracteristicasEquipo', 'btnInformacionEquipo');
            obtenerImagenesEquipo(idEquipo);

            return array;
         })
         .then(array => {
            if (array) {

               // OBTIENES SECCIONES
               for (let x = 0; x < array.secciones.length; x++) {
                  const idSeccion = array.secciones[x].idSeccion;
                  const seccion = array.secciones[x].seccion;

                  const codigo = `<option value="${idSeccion}">${seccion}</option>`;
                  e_seccionEquipo.insertAdjacentHTML('beforeend', codigo);

               }

               // OBTIENES SUBSECCIONES
               for (let x = 0; x < array.subsecciones.length; x++) {
                  const idSubseccion = array.subsecciones[x].idSubseccion;
                  const subseccion = array.subsecciones[x].subseccion;

                  const codigo = `<option value="${idSubseccion}">${subseccion}</option>`;
                  e_subseccionEquipo.insertAdjacentHTML('beforeend', codigo);
               }

               // OBTIENE TIPOS
               for (let x = 0; x < array.tipos.length; x++) {
                  const idTipo = array.tipos[x].idTipo;
                  const tipo = array.tipos[x].tipo;

                  const codigo = `<option value="${idTipo}">${tipo}</option>`;
                  e_tipoEquipo.insertAdjacentHTML('beforeend', codigo);
               }

               // EQUIPOS PADRE
               for (let x = 0; x < array.equipos.length; x++) {
                  const idEquipo = array.equipos[x].idEquipo;
                  const equipo = array.equipos[x].equipo;

                  const codigo = `<option value="${idEquipo}">${equipo}</option>`;
                  e_dataOpcionesEquipos.insertAdjacentHTML('beforeend', codigo);
               }

               // MARCAS
               for (let x = 0; x < array.marcas.length; x++) {
                  const idMarca = array.marcas[x].idMarca;
                  const marca = array.marcas[x].marca;

                  const codigo = `<option value="${idMarca}">${marca}</option>`;
                  e_marcaEquipo.insertAdjacentHTML('beforeend', codigo);
               }

            } else {
               alert('No se Encontraron Datos..', '', 'info', 1200);
            }
            resolve(resolve, reject)

         })
         .catch(function (err) {
            fetch(APIERROR + err + ' < ' + URL + ' >');

            // LIMPIA CONTENEDORES DE OPCIONES
            e_seccionEquipo.innerHTML = '<option value="0">No Seleccionado</option>';
            e_subseccionEquipo.innerHTML = '<option value="0">No Seleccionado</option>';
            e_tipoEquipo.innerHTML = '<option value="0">No Seleccionado</option>';
            e_dataOpcionesEquipos.innerHTML = '<option value="0">No Seleccionado</option>';
            e_marcaEquipo.innerHTML = '<option value="0">No Seleccionado</option>';
            e_jerarquiaEquipo.value = 0;
         })

   })
   promesa.then((resolve, reject) => {

      const URL2 = `php/select_REST_planner.php?action=obtenerEquipoPorId&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

      fetch(URL2)
         .then(array => array.json())
         .then(array => {
            if (array) {
               e_nombreEquipo.value = array.equipo;
               e_estadoEquipo.value = array.status;
               e_tipoLocalEquipo.value = array.localEquipo;
               e_idFaseEquipo.value = array.idFases;

               e_seccionEquipo.value = array.idSeccion;
               e_subseccionEquipo.value = array.idSubseccion;
               e_tipoEquipo.value = array.idTipo;
               e_jerarquiaEquipo.value = array.jerarquia;
               e_dataOpcionesEquipos.value = array.idEquipoPrincipal;

               e_fechaInstalacionEquipo.value = array.fechaInstalacion;
               e_fechaCompraEquipo.value = array.fechaCompra;
               e_añoGarantiaEquipo.value = array.añoGarantia;
               e_añoVidaUtilEquipo.value = array.añoVidaUtil;

               e_marcaEquipo.value = array.idMarca;
               e_modeloEquipo.value = array.modelo;
               e_serieEquipo.value = array.serie;
               e_codigoFabricanteEquipo.value = array.codigoFabricante;
               e_codigoInternoComprasEquipo.value = array.codigoInternoCompras;

               e_cantidadEquipo.value = array.cantidad;
               e_largoEquipo.value = array.largo_cm;
               e_anchoEquipo.value = array.ancho_cm;
               e_altoEquipo.value = array.alto_cm;

               e_potenciaElectricaHPEquipo.value = array.potencia_electrica_hp;
               e_potenciaElectricaKWEquipo.value = array.potencia_electrica_kw;
               e_voltajeEquipo.value = array.voltaje_v;
               e_frecuenciaEquipo.value = array.frecuencia_hz;
               e_capacidadEquipo.value = array.capacidad;

               e_caudalAguaM3HEquipo.value = array.caudal_agua_m3h;
               e_caudalAguaGPHEquipo.value = array.caudal_agua_gph;
               e_cargaMCAEquipo.value = array.carga_mca;

               e_PotenciaEnergeticaFrioKWEquipo.value = array.potencia_energetica_frio_kw;
               e_potenciaEnergeticaFrioTREquipo.value = array.potencia_energetica_frio_tr;

               e_potenciaEnergeticaCalorKCALEquipo.value =
                  array.potencia_energetica_calor_kcal;

               e_caudalAireM3HEquipo.value = array.caudal_aire_m3h;
               e_caudalAireCFMEquipo.value = array.caudal_aire_cfm;

               QREquipo.setAttribute("src", `https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=svg&bgcolor=fff&color=4a5568&data=www.maphg.com/america/gestion_equipos/index.php?${array.idEquipo}`);

               if (array.localEquipo == "EQUIPO") {
                  btnPreventivosEquipo.classList.remove('hidden');
                  btnIncidenciasEquipo.classList.remove('hidden');
                  btnChecklistEquipo.classList.add('hidden');
                  btnBitacorasEquipo.classList.remove('hidden');
                  consultarPlanEquipo(idEquipo);
               } else {
                  btnPreventivosEquipo.classList.add('hidden');
                  btnIncidenciasEquipo.classList.remove('hidden');
                  btnChecklistEquipo.classList.remove('hidden');
                  btnBitacorasEquipo.classList.add('hidden');
                  obtenerIncidenciasEquipo(idEquipo);
               }
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
            e_nombreEquipo.value = '';
            e_capacidadEquipo.value = '';
            e_fechaInstalacionEquipo.value = '';
            e_fechaCompraEquipo.value = '';
            e_añoGarantiaEquipo.value = '';
            e_añoVidaUtilEquipo.value = '';
            e_estadoEquipo.value = '';
            e_tipoLocalEquipo.value = '';
            e_idFaseEquipo.value = '';
            e_seccionEquipo.value = '';
            e_subseccionEquipo.value = '';
            e_tipoEquipo.value = '';
            e_jerarquiaEquipo.value = '';
            e_dataOpcionesEquipos.value = '';
            e_marcaEquipo.value = '';
            e_modeloEquipo.value = '';
            e_serieEquipo.value = '';
            e_codigoFabricanteEquipo.value = '';
            e_codigoInternoComprasEquipo.value = '';
            e_cantidadEquipo.value = '';
            e_largoEquipo.value = '';
            e_anchoEquipo.value = '';
            e_altoEquipo.value = '';
            e_potenciaElectricaHPEquipo.value = '';
            e_potenciaElectricaKWEquipo.value = '';
            e_voltajeEquipo.value = '';
            e_frecuenciaEquipo.value = '';
            e_caudalAguaM3HEquipo.value = '';
            e_caudalAguaGPHEquipo.value = '';
            e_cargaMCAEquipo.value = '';
            e_PotenciaEnergeticaFrioKWEquipo.value = '';
            e_potenciaEnergeticaFrioTREquipo.value = '';
            e_potenciaEnergeticaCalorKCALEquipo.value = '';
            e_caudalAireM3HEquipo.value = '';
            e_caudalAireCFMEquipo.value = '';
         })
   })
   promesa.catch((err) => {
      fetch(APIERROR + err);
   })
}


// OBTIENE MATERIALES PARA ASIGNAR A EQUIPO
const obtenerOpcionesMaterialesEquipo = (idEquipo, tipoAsignacion) => {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');

   const action = "obtenerOpcionesMaterialesEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}&tipoAsignacion=${tipoAsignacion}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataOpcionesMaterialesEquipo.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idItem = array[x].idItem;
               const cod2bend = array[x].cod2bend;
               const descripcion = array[x].descripcion;
               const sstt = array[x].sstt;
               const caracteristicas = array[x].caracteristicas;
               const marca = array[x].marca;
               const modelo = array[x].modelo;
               const cantidad = array[x].cantidad;

               const codigo = `
                  <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
             
                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1" data-title-material="${cod2bend}">
                           <h1 class="truncate w-16">${cod2bend}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${descripcion}">
                           <h1 class="truncate w-40">${descripcion}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${sstt}">
                           <h1 class="truncate w-40">${sstt}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${caracteristicas}">
                           <h1 class="truncate w-32">${caracteristicas}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${marca}">
                           <h1 class="truncate w-24">${marca}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${modelo}">
                           <h1 class="truncate w-24">${modelo}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-12">
                        <div class="w-12">
                           <input id="item_material_equipo_${idItem}" class="border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 w-12 rounded-md text-sm focus:outline-none" type="text" placeholder="Cantidad" min="0" value="${cantidad}" autocomplete="off" onchange="asignarMaterialEquipo(${idItem}, ${idEquipo}, '${tipoAsignacion}')">
                        </div>
                     </td>
                  </tr>               
               `;
               dataOpcionesMaterialesEquipo.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
}


// ASINGA MATERIALES A EQUIPO
const asignarMaterialEquipo = (idItem, idEquipo, tipoAsignacion) => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let cantidad = 0;

   if (document.getElementById("item_material_equipo_" + idItem)) {
      cantidad = parseFloat(document.getElementById("item_material_equipo_" + idItem).value);
   }

   const action = "asignarMaterialEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}&tipoAsignacion=${tipoAsignacion}&idItem=${idItem}&cantidad=${cantidad}`;

   if (cantidad >= 0 && cantidad != "NaN") {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (tipoAsignacion == "PREVENTIVO") {
               if (array == "AGREGADO") {
                  alertaImg('Material Agregado', '', 'success', 1400);
               } else if (array == "ACTUALIZADO") {
                  alertaImg('Cantidad Material Actualizado', '', 'success', 1400);
               } else {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
               }
               despieceMaterailesEquipo(idEquipo, 'PREVENTIVO')
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ` asignarMaterialEquipo = (${idItem}, ${idEquipo}, ${tipoAsignacion})`);
         })

   } else {
      alertaImg('Cantidad NO Valida', '', 'info', 1500);
   }
}


// BUSCA MATERIALES PARA EQUIPO
inputDespieceMaterialesEquipo.addEventListener('keyup', () => {
   buscadorTabla('dataOpcionesMaterialesEquipo', 'inputDespieceMaterialesEquipo', 1);
})


// OBTIENE EL DESPIECE DE EQUIPO
function despieceEquipos(idEquipo) {
   e_dataDespieceEquipo.innerHTML = '';
   let idUsuario = localStorage.getItem("usuario");
   let idDestino = localStorage.getItem("idDestino");

   const action = "despieceEquipos";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}`;

   diseñoOpcionesSuperioresEquipo('contenedorDespiedeEquipo', 'btnDespieceEquipo');

   // Fetch ASYC
   fetch(URL)
      .then(res => res.json())
      .then(array => {
         let despiece = "";
         for (let index = 0; index < array.length; index++) {

            var id = array[index].id;
            var equipo = array[index].equipo;
            var jerarquia = array[index].jerarquia;

            if (jerarquia == "PRINCIPAL") {
               codigo = `
                        <div class="flex-none cursor-pointer hover:bg-purple-200 hover:text-purple-700 w-full px-2 py-2 rounded-sm truncate flex items-center" onclick="informacionEquipo(${id});  abrirmodal('modalMPEquipo');">
                            <i class="fas fa-cog mr-1 fa-lg"></i>
                            <h1>${equipo} (${array.length})</h1>
                        </div>`
                  ;
               e_dataDespieceEquipo.insertAdjacentHTML('beforeend', codigo);
            } else {
               codigo = `
                        <div class="flex-none cursor-pointer hover:bg-purple-200 hover:text-purple-700 w-full px-2 py-2 rounded-sm truncate flex items-center pl-6" onclick="informacionEquipo(${id});  abrirmodal('modalMPEquipo');">
                            <i class="fad fa-cogs mr-1 fa-lg"></i>
                            <h1>${equipo}</h1>
                        </div>`
                  ;
               e_dataDespieceEquipo.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(err => {
         fetch(APIERROR + err + ` despieceEquipos(${idEquipo})`)
      })
}


//OBTIENE EL DESPIECE DE MATERIALES DE EQUIPO
const despieceMaterailesEquipo = (idEquipo, tipoAsignacion) => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "despieceMaterailesEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}&tipoAsignacion=${tipoAsignacion}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataDespieceMaterialesEquipo.innerHTML = '';
         cantidadDespieceMaterialEquipo.innerText = 'Despiece Materiales (0)';
         return array;
      })
      .then(array => {
         if (array) {
            cantidadDespieceMaterialEquipo.innerText = 'Despiece Materiales (' + array.length + ')';
            for (let x = 0; x < array.length; x++) {
               const idRegistro = array[x].idRegistro;
               const cod2bend = array[x].cod2bend;
               const cantidad = array[x].cantidad;
               const descripcion = array[x].descripcion;
               const codigo = `
                  <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal S-SOLUCIONADO">
                     <td id="" class="whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" onclick="obtenerActividadesOT(31620, 'FALLA');">
                        <h1>${cod2bend}</h1>
                     </td>
                     <td id="" class="whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" onclick="obtenerActividadesOT(31620, 'FALLA');">
                        <h1>${cantidad}</h1>
                     </td>
                     <td class="px-4 border-b border-gray-200 py-3" style="max-width: 300px;">
                        <h1 class="truncate">${descripcion}</h1>
                     </td>
                  </tr>               
               `;
               dataDespieceMaterialesEquipo.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         dataDespieceMaterialesEquipo.innerHTML = '';
         cantidadDespieceMaterialEquipo.innerText = 'Despiece Materiales (0)';
         fetch(APIERROR + err + ` despieceMaterailesEquipo(${idEquipo}, ${tipoAsignacion})`);
      })
}


// OBTIENE LOS ADJUNTOS DE EQUIPO (MANUALES)
const obtenerAdjuntosEquipo = idEquipo => {
   let idUsuario = localStorage.getItem('idUsuario');
   let idDestino = localStorage.getItem('idDestino');

   diseñoOpcionesSuperioresEquipo('contenedorAdjuntosEquipo', 'btnDocumentosEquipo');

   inputAdjuntosEquipo.setAttribute('onchange', `subirAdjuntosEquipo(${idEquipo})`);

   const action = "obtenerAdjuntosEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataAdjuntosEquipo.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idAdjunto = array[x].idAdjunto;
               const url = array[x].url;
               const tipo = array[x].tipo;

               if (tipo == "png" || tipo == "gif" || tipo == "jpeg" || tipo == "jpg") {
                  codigo = `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative px-1 h-20">
                        <a href="planner/equipos/${url}" target="_blank">
                           <div class="bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 p-2 cursor-pointer" style="background-image: url(planner/equipos/${url})">
                           </div>
                        </a>
                        <div class="w-full absolute text-transparent hover:text-red-700 text-center" style="bottom: 12px; left: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'ADJUNTOSEQUIPO');">
                           <i class="fas fa-trash-alt fa-2x" data-title="Clic para Eliminar"></i>
                        </div>
                     </div>
                  `;
               } else {
                  codigo = `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative px-1 h-20">
                        <a href="planner/equipos/${url}" target="_blank" data-title="${url}">
                           <div class="rounded-md cursor-pointer flex flex-col justify-center text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2 w-20 h-20">
                              <i class="fad fa-file-contract fa-3x"></i>
                              <p class="text-xxs font-normal text-indigo-500 ml-2 truncate w-20">${url}</p>
                           </div>
                        </a>

                        <div class="w-full absolute text-transparent hover:text-red-700 text-center" style="bottom: 22px; right: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'ADJUNTOSEQUIPO');">
                           <i class="fas fa-trash-alt fa-2x"></i>
                        </div>
                     </div>              
                  `;
               }

               dataAdjuntosEquipo.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         dataAdjuntosEquipo.innerHTML = '';
         fetch(APIERROR + err);
      })
}


// SUBE LOS ADJUNTOS DE EQUIPO (MANUALES)
const subirAdjuntosEquipo = idEquipo => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "subirAdjuntosEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

   if (inputAdjuntosEquipo.files) {
      for (let x = 0; x < inputAdjuntosEquipo.files.length; x++) {
         const formData = new FormData();
         formData.append('file', inputAdjuntosEquipo.files[x]);

         fetch(URL, {
            method: "POST",
            body: formData
         })
            .then(array => array.json())
            .then(array => {
               if (array == 1) {
                  obtenerAdjuntosEquipo(idEquipo);
                  alertaImg('Adjunto Agregado', '', 'success', 1500);
               } else {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
               }
            })
            .then(() => {
               inputAdjuntosEquipo.value = '';
            })
            .catch(function (err) {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
               inputAdjuntosEquipo.value = '';
               fetch(APIERROR + err + ` subirAdjuntosEquipo(${idEquipo})`)
            })
      }
   }
}


// OBTIENE LOS COTIZACIONES DE EQUIPO
const obtenerCotizacionesEquipo = idEquipo => {
   let idUsuario = localStorage.getItem('idUsuario');
   let idDestino = localStorage.getItem('idDestino');

   diseñoOpcionesSuperioresEquipo('contenedorAdjuntosEquipo', 'btnCotizacionesEquipo');

   inputAdjuntosEquipo.setAttribute('onchange', `subirCotizacionesEquipo(${idEquipo})`);

   const action = "obtenerCotizacionesEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataAdjuntosEquipo.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idAdjunto = array[x].idAdjunto;
               const url = array[x].url;
               const tipo = array[x].tipo;

               if (tipo == "png" || tipo == "gif" || tipo == "jpeg" || tipo == "jpg") {
                  codigo = `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative px-1 h-20">
                        <a href="planner/equipos/${url}" target="_blank">
                           <div class="bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 p-2 cursor-pointer" style="background-image: url(planner/equipos/${url})">
                           </div>
                        </a>
                        <div class="w-full absolute text-transparent hover:text-red-700 text-center" style="bottom: 12px; left: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'COTIZACIONEQUIPO');">
                           <i class="fas fa-trash-alt fa-2x" data-title="Clic para Eliminar"></i>
                        </div>
                     </div>
                  `;
               } else {
                  codigo = `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative px-1 h-20">
                        <a href="planner/equipos/${url}" target="_blank" data-title="${url}">
                           <div class="rounded-md cursor-pointer flex flex-col justify-center text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2 w-20 h-20">
                              <i class="fad fa-file-contract fa-3x"></i>
                              <p class="text-xxs font-normal text-indigo-500 ml-2 truncate w-20">${url}</p>
                           </div>
                        </a>

                        <div class="w-full absolute text-transparent hover:text-red-700 text-center" style="bottom: 22px; right: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'COTIZACIONEQUIPO');">
                           <i class="fas fa-trash-alt fa-2x"></i>
                        </div>
                     </div>              
                  `;
               }

               dataAdjuntosEquipo.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         dataAdjuntosEquipo.innerHTML = '';
         fetch(APIERROR + err);
      })
}


// SUBE LOS ADJUNTOS DE EQUIPO (COTIZACIONES)
const subirCotizacionesEquipo = idEquipo => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "subirCotizacionesEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

   if (inputAdjuntosEquipo.files) {
      for (let x = 0; x < inputAdjuntosEquipo.files.length; x++) {
         const formData = new FormData();
         formData.append('file', inputAdjuntosEquipo.files[x]);

         fetch(URL, {
            method: "POST",
            body: formData
         })
            .then(array => array.json())
            .then(array => {
               if (array == 1) {
                  obtenerCotizacionesEquipo(idEquipo);
                  alertaImg('Adjunto Agregado', '', 'success', 1500);
               } else {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
               }
            })
            .then(() => {
               inputAdjuntosEquipo.value = '';
            })
            .catch(function (err) {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
               inputAdjuntosEquipo.value = '';
               fetch(APIERROR + err + ` subirAdjuntosEquipo(${idEquipo})`)
            })
      }
   }
}


// FOTOGRAFIAS DE EQUIPOS (PNG, JPEG, JPG)
const subirImagenEquipo = idEquipo => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "subirImagenEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

   if (inputFotografiaEquipo.files) {
      for (let x = 0; x < inputFotografiaEquipo.files.length; x++) {
         const formData = new FormData();
         formData.append('file', inputFotografiaEquipo.files[x]);
         const tipo = inputFotografiaEquipo.files[x].type;
         if (tipo == "image/jpeg" || tipo == "image/png" || tipo == "image/jpg") {
            fetch(URL, {
               method: "POST",
               body: formData
            })
               .then(array => array.json())
               .then(array => {
                  if (array == 1) {
                     obtenerImagenesEquipo(idEquipo);
                     alertaImg('Imagen Agregada', '', 'success', 1500);
                  } else {
                     alertaImg('Intente de Nuevo', '', 'info', 1500);
                  }
               })
               .then(() => {
                  inputFotografiaEquipo.value = '';
               })
               .catch(function (err) {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
                  inputFotografiaEquipo.value = '';
                  fetch(APIERROR + err + ` subirImagenEquipo(${idEquipo})`)
               })
         } else {
            alertaImg('Adjunto NO Permitido', '', 'info', 1500);
         }
      }
   }
}


// OBTIENE INCIDENCIAS DE EQUIPO
const obtenerIncidenciasEquipo = idEquipo => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   diseñoOpcionesInferioresEquipo('contenedorIncidenciasEquipo', 'btnIncidenciasEquipo');

   const action = "obtenerFallas";
   const URL = `php/equipos_locales.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;
   // OBTEIENE DATOS DE LAS FALLAS
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataIncidenciasEquipo.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array) {
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
               const tipoIncidencia = array[x].tipoIncidencia;

               const data = codigoIncidenciasEquipo({
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
                  tipo: tipo,
                  tipoIncidencia: tipoIncidencia
               });
               dataIncidenciasEquipo.insertAdjacentHTML('beforeend', data);
            }
         }
      })
      .catch(function (err) {
         dataIncidenciasEquipo.innerHTML = '';
         fetch(APIERROR + err + ` obtenerIncidenciasEquipo(${idEquipo})`);
      })
}


// OBTIENE LA BITACORA DE EQUIPO
const obtenerBitacoraEquipo = idEquipo => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   diseñoOpcionesInferioresEquipo('contenedorBitacoraEquipo', 'btnBitacorasEquipo');
}


// OBTIENES OPCIONES PARA ASIGNAR EQUIPO PRINCIPAL A EQUIPOS SECUNDARIOS
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
            if (array.length) {
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

   inputAdjuntos.setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_america_adjuntos")');

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
            document.getElementById("dataImagenesEquipo").innerHTML = `
               <div id="modalMedia_adjunto_img_xxx" class="relative">
                  <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 p-2 cursor-pointer" style="background-image: url(planner/equipos/equipo.png)">
                  </div>
               </div>
            `;
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


// Obtiene el Calendario de MP de los Equipos
function consultarPlanEquipo(idEquipo) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   const action = "consultarPlanEquipo";

   diseñoOpcionesInferioresEquipo('contenedorPlanesEquipo', 'btnPreventivosEquipo');
   contenedorPlanesEquipo.innerHTML = '';

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
            if (data.planes.length) {
               for (let index = 0; index < data.planes.length; index++) {

                  const planesX = datosPlanEquipo({
                     solucionado: data.planes[index].solucionado,
                     proceso: data.planes[index].proceso,
                     planificado: data.planes[index].planificado,
                     idSemana: data.planes[index].idSemana,
                     idProceso: data.planes[index].idProceso,
                     idEquipo: data.planes[index].idEquipo,
                     idPlan: data.planes[index].idPlan,
                     grado: data.planes[index].grado,
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

                  contenedorPlanesEquipo.insertAdjacentHTML('beforeend', planesX);
               }
               indicadorSemanaActual(data.planes[0].semanaActual);
            }
         } else {
            if (data.creado) {
               contenedorPlanesEquipo.innerHTML = `<h1 class="w-full text-center text-gray-500 uppercase font-bold"> Creando Plan MP... </h1>`;
               if (data.creado == "SI") {
                  alertaImg('Creando Plan MP', '', 'success', 1900);
                  setTimeout(function () {
                     consultarPlanEquipo(idEquipo);
                  }, 1100)
               } else {
                  contenedorPlanesEquipo.innerHTML = '<h1 class="w-full text-center text-gray-500 uppercase font-bold"><img src="svg/SINPREVENTIVOS.svg"></h1>';
               }
            } else {
               contenedorPlanesEquipo.innerHTML = `<h1 class="w-full text-center text-gray-500 uppercase font-bold"><img src="svg/SINPREVENTIVOS.svg"></h1>`;
            }
         }
      }
   });
}


// Obtiene el Calendario de MP de los Equipos
function consultarPlanLocal(idEquipo) {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   const action = "consultarPlanLocal";
   diseñoOpcionesInferioresEquipo('contenedorChecklistEquipo', 'btnChecklistEquipo');
   contenedorChecklistEquipo.innerHTML = '';

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

                  const planesX = datosPlanLocal({
                     solucionado: data.planes[index].solucionado,
                     proceso: data.planes[index].proceso,
                     planificado: data.planes[index].planificado,
                     idSemana: data.planes[index].idSemana,
                     idProceso: data.planes[index].idProceso,
                     idEquipo: data.planes[index].idEquipo,
                     idPlan: data.planes[index].idPlan,
                     grado: data.planes[index].grado,
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

                  contenedorChecklistEquipo.insertAdjacentHTML('beforeend', planesX);
               }
               indicadorSemanaActual(data.planes[0].semanaActual);
            }
         } else {
            if (data.creado) {
               contenedorChecklistEquipo.innerHTML = `<h1 class="w-full text-center text-gray-500 uppercase font-bold"> Creando Plan MP... </h1>`;
               if (data.creado == "SI") {
                  alertaImg('Creando Plan MP', '', 'success', 1900);
                  setTimeout(function () {
                     consultarPlanLocal(idEquipo);
                  }, 1100)
               } else {
                  contenedorChecklistEquipo.innerHTML = '<h1 class="w-full text-center text-gray-500 uppercase font-bold"><img src="svg/SINPREVENTIVOS.svg"></h1>';
               }
            } else {
               contenedorChecklistEquipo.innerHTML = `<h1 class="w-full text-center text-gray-500 uppercase font-bold"><img src="svg/SINPREVENTIVOS.svg"></h1>`;
            }
         }
      },
      error: function (err) {
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
// document.getElementById("btnGuardarOT").addEventListener("click", guardarCambiosOT);


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
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&status=${status}&cod2bend=${inputCod2bend.value}`;

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
         estiloModalStatus(idOT, 'PREVENTIVO');
         let status = `
                <div id="statusOT2" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                    <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                </div>            
            `;

         if (array.statusTrabajare == "1") {
            status += `
                <div class="bg-blue-200 text-blue-700 px-2 rounded-full flex items-center mr-2">
                <h1 class="font-medium">Trabajando</h1>
                <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                </div>
                `;
         }

         if (array.statusMaterial == "1") {
            status += `
                    <div class="bg-orange-200 text-orange-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Material</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusElectricidad == "1") {
            status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Electricidad</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusDiesel == "1") {
            status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Diesel</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusGas == "1") {
            status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Gas</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusAgua == "1") {
            status += `
                    <div class="bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Agua</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusCalidad == "1") {
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Calidad</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusCompras == "1") {
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Compras</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusDireccion == "1") {
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Dirección</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusFinanzas == "1") {
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">Finanzas</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusRRHH == "1") {
            status += `
                    <div class="bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2">
                        <h1 class="font-medium">RRHH</h1>
                        <i class="fas fa-times ml-1 hover:text-red-500 cursor-pointer"></i>
                    </div>
                `;
         }

         if (array.statusCalidad == "1" || array.statusCompras == "1" || array.statusDireccion == "1" || array.statusFinanzas == "1" || array.statusRRHH == "1") {
         }

         if (array.statusElectricidad == "1" || array.statusDiesel == "1" || array.statusGas == "1" || array.statusAgua == "1") {
         }

         return status;
      })
      .then(status => {
         statusMaterialCod2bend.classList.add('hidden');
         document.getElementById("dataStatusOT").innerHTML = status;
         document.getElementById("statusOT2").
            setAttribute("onclick", `consultaStatusOT(${idOT}); toggleModalTailwind('modalStatus');`);
         document.getElementById("btnStatusMaterial").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status_material');`);
         document.getElementById("statusTrabajare").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status_trabajando');`);

         // ENERGETICOS
         document.getElementById("statusElectricidad").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_electricidad');`);
         document.getElementById("statusAgua").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_agua');`);
         document.getElementById("statusDiesel").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_diesel');`);
         document.getElementById("statusGas").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'energetico_gas');`);
         document.getElementById("statusRRHH").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_rrhh');`);

         // DEPARTAMENTOS
         document.getElementById("statusDireccion").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_direccion');`);
         document.getElementById("statusFinanzas").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_finanzas');`);
         document.getElementById("statusCalidad").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_calidad');`);
         document.getElementById("statusCompras").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'departamento_compras');`);

         document.getElementById("statusFinalizar").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status');`);
         document.getElementById("statusEP").
            setAttribute("onclick", `actualizaStatusOT(${idOT}, 'status_ep');`);
         document.getElementById("btnFinalizarOT").
            setAttribute("onclick", `guardarCambiosOT(); actualizaStatusOT(${idOT}, 'status');`);

         // BITACORA
         document.getElementById("statusGP").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'bitacora_gp');`);
         document.getElementById("statusTRS").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'bitacora_trs');`);
         document.getElementById("statusZI").setAttribute("onclick", `actualizaStatusOT(${idOT}, 'bitacora_zi');`);

         document.getElementById("btnGuardarOT").setAttribute("onclick", 'guardarCambiosOT()');
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

         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idAdjunto = array[x].id;
               const url = array[x].url;
               const tipo = array[x].tipo;

               if (tipo == "imagenes") {
                  imagenes += `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative px-1 h-20">
                        <a href="planner/mp_ot/${url}" target="_blank">
                           <div class="bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 p-2 cursor-pointer" style="background-image: url(planner/mp_ot/${url})">
                           </div>
                        </a>
                        <div class="w-full absolute text-transparent hover:text-red-700 text-center" style="bottom: 12px; left: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'PREVENTIVO');">
                           <i class="fas fa-trash-alt fa-2x" data-title="Clic para Eliminar"></i>
                        </div>
                     </div>
                  `;
               } else {
                  documentos += `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative px-1 h-20">
                        <a href="planner/mp_ot/${url}" target="_blank" data-title="${url}">
                           <div class="rounded-md cursor-pointer flex flex-col justify-center text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2 w-20 h-20">
                              <i class="fad fa-file-alt fa-3x"></i>
                              <p class="text-xxs font-normal text-indigo-500 ml-2 truncate w-20">${url}</p>
                           </div>
                        </a>
                        <div class="w-full absolute text-transparent hover:text-red-700 text-center" style="bottom: 22px; right: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'PREVENTIVO');">
                           <i class="fas fa-trash-alt fa-2x"></i>
                        </div>
                     </div>
                  `;
               }
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
         inputAdjuntos.setAttribute("onchange", `subirImagenGeneral(${idOT}, "t_mp_planificacion_iniciada_adjuntos")`);
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
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

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
      setAttribute('onclick', `obtenerOTDigital(${idEquipo}, ${semanaX}, ${idPlan})`);

   document.getElementById("cancelarOTMP").
      setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "CANCELAROT")`);

   fechaProgramadaOT.setAttribute('onchange', `programarFechaMP(${idEquipo}, ${semanaX}, ${idPlan})`);

   const action = "obtenerDatosOT";
   const URL = `php/plannerCrudPHP.php`;

   const data = new FormData();
   data.append('action', action);
   data.append('idDestino', idDestino);
   data.append('idUsuario', idUsuario);
   data.append('idEquipo', idEquipo);
   data.append('semana', semanaX);
   data.append('idPlan', idPlan);

   fetch(URL, {
      method: 'POST',
      body: data,
   })
      .then(array => array.json())
      .then(array => {
         fechaProgramadaOT.value = array.fechaProgramada;
      })
      .catch(function (err) {
         fechaProgramadaOT.value = '';
         fetch(APIERROR + err);
      })


}

const programarFechaMP = (idEquipo, semana, idPlan) => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "programarFechaMP";
   const URL = `php/plannerCrudPHP.php`;

   const data = new FormData();
   data.append('action', action);
   data.append('idDestino', idDestino);
   data.append('idUsuario', idUsuario);
   data.append('idEquipo', idEquipo);
   data.append('semana', semana);
   data.append('idPlan', idPlan);
   data.append('fecha', fechaProgramadaOT.value);


   fetch(URL, {
      method: 'POST',
      body: data,
   })
      .then(array => array.json())
      .then(array => {
         if (array == 1) {
            alertaImg('Fecha de Programación, Actualizada', '', 'success', 1500);
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1500);
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
}


// Muestra el Menú de los Planes
function opcionesMenuMPLocal(id, idSemana, idProceso, idEquipo, idPlan, semanaX) {

   document.getElementById("tooltipMP").classList.remove('hidden');

   document.getElementById('semanaProgramacionMP').innerHTML = '(Semana ' + semanaX + ')';

   // Propiedades para el tooltip
   const button = document.getElementById(id);
   const tooltip = document.getElementById('tooltipMP');

   Popper.createPopper(button, tooltip, {
      placement: 'top',
   });

   document.getElementById("programarMPIndividual").
      setAttribute('onclick', `programarMPLocal(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "PROGRAMARINDIVIDUAL")`);

   document.getElementById("programarMPDesdeAqui").
      setAttribute('onclick', `programarMPLocal(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "PROGRAMARDESDEAQUI")`);

   document.getElementById("programarMPPersonalizado").
      setAttribute('onclick', `programarMPLocal(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "PROGRAMARPERSONALIZADO")`);
   document.getElementById("eliminarMPIndividual").
      setAttribute('onclick', `programarMPLocal(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "ELIMINARINDIVIDUAL")`);

   document.getElementById("eliminarMPDesdeAqui").
      setAttribute('onclick', `programarMPLocal(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "ELIMINARDESDEAQUI")`);

   document.getElementById("VerOTMP").
      setAttribute('onclick', `VerOTMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "VEROT")`);

   document.getElementById("generarOTMP").
      setAttribute('onclick', `programarMPLocal(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "GENERAROT")`);

   document.getElementById("solucionarOTMP").
      setAttribute('onclick', `obtenerOTDigital(${idEquipo}, ${semanaX}, ${idPlan})`);

   document.getElementById("cancelarOTMP").
      setAttribute('onclick', `programarMPLocal(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "CANCELAROT")`);
}


function obtenerOTDigital(idEquipo, semanaX, idPlan) {
   document.getElementById("modalSolucionarOT").classList.add('open');
   document.getElementById("tooltipMP").classList.add('hidden');
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "obtenerOTDigital";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}&semanaX=${semanaX}&idPlan=${idPlan}`;

   fetch(URL)
      .then(res => res.json())
      .then(array => {
         fechaOT.value = '';
         document.getElementById("actividadesOT").innerHTML = '';
         document.getElementById("semanaOT").innerHTML = '';
         document.getElementById("comentarioOT").value = '';
         document.getElementById("inputActividadesExtra").value = '';
         document.getElementById("tipoOT").innerHTML = '';
         return array;
      })
      .then(array => {
         let idOT = array[0].OT;
         document.getElementById("numeroOT").innerHTML = idOT;
         localStorage.setItem('idOT', idOT);

         fechaOT.setAttribute('onchange', `actualizarFechaOT(${array[0].OT})`)

         fechaOT.value = array[0].fechaProgramada;

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
      })
      .catch(err => {
         localStorage.setItem('idOT', 0);
         fechaOT.value = '';
         document.getElementById("actividadesOT").innerHTML = '';
         document.getElementById("semanaOT").innerHTML = '';
         document.getElementById("comentarioOT").value = '';
         document.getElementById("inputActividadesExtra").value = '';
         document.getElementById("tipoOT").innerHTML = '';
         fechaOT.removeAttribute('onchange');
      })
}


const actualizarFechaOT = idOT => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "actualizarFechaOT";
   const URL = `php/OT_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&fecha=${fechaOT.value}`;

   if (fechaOT.value.replace('^\d{ 4}([\-/.])(0?[1-9]|1[1-2])\1(3[01]|[12][0-9]|0?[1-9])$')) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               alertaImg('Fecha de OT, Actualizada', '', 'success', 1500);
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Fecha NO Valida', '', 'info', 1500);
   }
}

// Indicador de Semana actual para los MP
function indicadorSemanaActual(semana) {
   let totalElementos = document.getElementsByClassName("semana_" + semana);
   let codigo = '';

   if (semana < 10) {
      codigo = `
            0${semana}
            <i class="animated infinite heartBeat text-red-400 fas fa-circle absolute" style="left: 1px; bottom: -10px;"></i>
        `;
   } else {
      codigo = `
            ${semana}
            <i class="animated infinite heartBeat text-red-400 fas fa-circle absolute" style="left: 1px; bottom: -10px;"></i>
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


// Genera la Programación de los MP
function programarMPLocal(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP) {
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
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 3) {
            alertaImg(`Reprogramado Desde, Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 4) {
            alertaImg(`Personalizado Desde, Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 5) {
            alertaImg(`Eliminada, Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 6) {
            alertaImg(`Eliminada Desde, Semana ${semanaX}`, '', 'success', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 7) {
            alertaImg(`Semana ${semanaX}, en Proceso`, '', 'success', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
            VerOTMP(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP);
         } else if (data == 8) {
            alertaImg(`Semana ${semanaX}, Solucionada`, '', 'success', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 9) {
            alertaImg(`Semana ${semanaX}, Cancelada`, '', 'success', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 10) {
            alertaImg(`Semana ${semanaX}, en Proceso Iniciado`, '', 'error', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 11) {
            alertaImg(`Semana ${semanaX}, Sin Proceso Iniciado`, '', 'error', 3500);
            consultarPlanLocal(idEquipo);
            cerrarTooltip('tooltipMP');
         } else if (data == 12) {
            alertaImg(`Semana ${semanaX}, Sin Proceso Iniciado`, '', 'error', 3500);
            consultarPlanLocal(idEquipo);
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
         } else {
            alertaImg('No se encontro la OT', '', 'info', 1400);
         }
      }
   });
}


// Proceso para Ver OT
function VerOTMPSolucionado(idEquipo, semanaX, idPlan) {
   localStorage.setItem('URL', '');

   if (idEquipo != "" && semanaX != "") {
      localStorage.setItem('URL', `0;0;${idEquipo};${semanaX};${idPlan}`);
      window.open('OT/index.php', "OT", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1200px, height=650px");
   } else {
      alertaImg('No se encontro la OT', '', 'info', 1400);
   }
}



// Habilita los Botones del Menu
function botonesMenuMP(x) {
   document.getElementById("VerOTMP").classList.add('hidden');
   document.getElementById("contenedorFechaProgramadaOT").classList.add('hidden');
   document.getElementById("generarOTMP").classList.add('hidden');
   document.getElementById("solucionarOTMP").classList.add('hidden');
   document.getElementById("cancelarOTMP").classList.add('hidden');

   if (x == "PROCESO") {
      document.getElementById("VerOTMP").classList.remove('hidden');
      document.getElementById("contenedorFechaProgramadaOT").classList.remove('hidden');
      document.getElementById("solucionarOTMP").classList.remove('hidden');
      document.getElementById("cancelarOTMP").classList.remove('hidden');
   } else if (x == "0") {
      document.getElementById("generarOTMP").classList.remove('hidden');
   } else if (x == "SOLUCIONADO") {
      document.getElementById("VerOTMP").classList.remove('hidden');
      document.getElementById("contenedorFechaProgramadaOT").classList.add('hidden');
   }
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
   if (document.getElementById(idVista)) {
      let idVistaX = document.getElementById(idVista);

      if (idVistaX.classList.contains('hidden')) {
         idVistaX.classList.remove('hidden');
      } else {
         idVistaX.classList.add('hidden');
      }
   }
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
         if (array.length) {
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

   const sEP = params.sEP >= 1 ?
      '<div class="bg-yellow-300 w-6 h-6 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>EP</h1></div>'
      : '';

   var fOT = `<a href="OT_Fallas_Tareas/#${params.ot}" class="text-black" target="_blank">${params.ot}</a>`;
   if (params.status == "PENDIENTE" && params.tipo == "FALLA") {
      var statusX = 'S-PENDIENTE';
      var fResponsable = `onclick="obtenerUsuarios('asignarMC', ${idRegistro});"`;
      var fRangoFecha = `onclick="obtenerFechaMC(${idRegistro}, '${params.fechaInicio + ' - ' + params.fechaFin}');"`;
      var fAdjuntos = `onclick="obtenerAdjuntosMC(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosMC(${idRegistro});"`;
      var fStatus = `onclick="obtenerstatusMC(${idRegistro});"`;
      var fStatus1 = `onclick="obtenerstatusMC(${idRegistro});"`;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'FALLA');"`;
      var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
      var enlaceToltip = `FALLA${idRegistro}`;
      var fVerEnPlanner = `onclick="obtenerIncidenciaEquipos(${idRegistro}); toggleModalTailwind('modalVerEnPlannerIncidencia');"`;
      var fMateriales = `onclick="obtenerMaterialesIncidencias(${idRegistro}, 'INCIDENCIA')"`;
   } else if (params.status == "SOLUCIONADO" && params.tipo == "FALLA") {
      var statusX = 'S-SOLUCIONADO';
      var fResponsable = '';
      var fRangoFecha = '';
      var fAdjuntos = `onclick="obtenerAdjuntosMC(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosMC(${idRegistro});"`;
      var fStatus = `onclick="actualizarStatusMC(${idRegistro}, 'restaurar', 'F')"`;
      var fStatus1 = ``;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'FALLA');"`;
      var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
      var enlaceToltip = `FALLA${idRegistro}`;
      var fVerEnPlanner = ``;
      var fMateriales = '';
   } else if (params.status == "PENDIENTE" && params.tipo == "TAREA") {
      var statusX = 'S-PENDIENTE';
      var fResponsable = `onclick="obtenerUsuarios('asignarTarea', ${idRegistro});"`;
      var fRangoFecha = `onclick="obtenerFechaTareas(${idRegistro}, '${params.fechaInicio + ' - ' + params.fechaFin}');"`;
      var fAdjuntos = `onclick="obtenerAdjuntosTareas(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosTareas(${idRegistro})"`;
      var fStatus = `onclick="obtenerInformacionTareas(${idRegistro}, '${params.actividad}')"`;
      var fStatus1 = `onclick="obtenerInformacionTareas(${idRegistro}, '${params.actividad}')"`;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'TAREA');"`;
      var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
      var enlaceToltip = `TAREA${idRegistro}`;
      var fVerEnPlanner = `onclick="obtenerIncidenciaGeneral(${idRegistro}); toggleModalTailwind('modalVerEnPlannerIncidencia');"`;
      var fMateriales = `onclick="obtenerMaterialesIncidencias(${idRegistro}, 'INCIDENCIAGENERAL')"`;
   } else if (params.status == "SOLUCIONADO" && params.tipo == "TAREA") {
      var statusX = 'S-SOLUCIONADO';
      var fResponsable = `onclick="obtenerUsuarios('asignarTarea', ${idRegistro});"`;
      var fRangoFecha = '';
      var fAdjuntos = `onclick="obtenerAdjuntosTareas(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosTareas(${idRegistro})"`;
      var fStatus = `onclick="actualizarTareas(${idRegistro},  'status', 'P');"`;
      var fStatus1 = ``;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'TAREA');"`;
      var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
      var enlaceToltip = `TAREA${idRegistro}`;
      var fVerEnPlanner = ``;
      var fMateriales = `onclick="obtenerMaterialesIncidencias(${idRegistro}, 'INCIDENCIA')"`;
   }

   // DISEÑO TIPO INCIDENCIA
   const estiloTipoIncidencia =
      params.tipoIncidencia == 'URGENCIA' ?
         `<span class="text-red-500 text-xs">${params.tipoIncidencia}</span>`
         : params.tipoIncidencia == "EMERGENCIA" ?
            `<span class="text-orange-500 text-xs">${params.tipoIncidencia}</span>`
            : params.tipoIncidencia == "ALARMA" ?
               `<span class="text-yellow-500 text-xs">${params.tipoIncidencia}</span>`
               : params.tipoIncidencia == "ALERTA" ?
                  `<span class="text-blue-500 text-xs">${params.tipoIncidencia}</span>`
                  : `<span class="text-teal-500 text-xs">${params.tipoIncidencia}</span>`;

   // DISEÑO PARA MATERIALES ASIGNADOS
   const materialesAsignados = params.materialesAsignados > 0 ? `${params.materialesAsignados}`
      : '<i class="fad fa-minus text-xl text-red-400"></i>';

   const fechaX = params.fechaInicio == "" || params.fechaFin == "" ?
      '<i class="fad fa-minus text-xl text-red-400"></i>'
      : `<div class="leading-4">${params.fechaInicio}</div>
         <div class="leading-3">${params.fechaFin}</div>`;

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

         <td id="${enlaceToltip}" class="whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3"
         ${fActividades}>
            <h1>${params.pda}</h1>
         </td>
         
         <td class="px-2 whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" 
         ${fResponsable}>
            <h1>${params.responsable}</h1>
         </td>

         <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" 
         ${fRangoFecha}>
            ${fechaX}
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3"
         ${fComentarios}>
            <h1>${valorcomentarios}</h1>
         </td>

         <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fAdjuntos}>
            <h1>${valoradjuntos}</h1>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3" ${fStatus1}>
            <div class="text-sm flex justify-center items-center font-bold">
               ${materialesx}
               ${energeticosx}
               ${departamentosx}
               ${trabajandox}
               ${sEP}
            </div>
         </td>
         
         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3">
            <h1>${fOT}</h1>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
            <div class="px-2">
               ${iconoStatus}
            </div>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3">
            <h1>${estiloTipoIncidencia}</h1>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3">
            <h1>${params.empresa}</h1>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fMateriales}>
            <h1>${materialesAsignados}</h1>
         </td>
      </tr>
   `;
}


// OBTENER INCIDENCIAS DE EQUIPO
// FUNCION PARA DISEÑO DE FILA DE FALLA
const codigoIncidenciasEquipo = params => {

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

   var fOT = `<a href="OT_Fallas_Tareas/#${params.ot}" class="text-black" target="_blank">${params.ot}</a>`;
   if (params.status == "PENDIENTE" && params.tipo == "FALLA") {
      var statusX = 'S-PENDIENTE';
      var fResponsable = `onclick="obtenerUsuarios('asignarMC', ${idRegistro});"`;
      var fRangoFecha = `onclick="obtenerFechaMC(${idRegistro}, '${params.fechaInicio + ' - ' + params.fechaFin}');"`;
      var fAdjuntos = `onclick="obtenerAdjuntosMC(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosMC(${idRegistro});"`;
      var fStatus = `onclick="obtenerstatusMC(${idRegistro});"`;
      var fStatus1 = `onclick="obtenerstatusMC(${idRegistro});"`;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'FALLA');"`;
      var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
      var enlaceToltip = `FALLA${idRegistro}`;
      var fVerEnPlanner = `onclick="obtenerIncidenciaEquipos(${idRegistro}); toggleModalTailwind('modalVerEnPlannerIncidencia');"`;
   } else if (params.status == "SOLUCIONADO" && params.tipo == "FALLA") {
      var statusX = 'S-SOLUCIONADO';
      var fResponsable = '';
      var fRangoFecha = '';
      var fAdjuntos = `onclick="obtenerAdjuntosMC(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosMC(${idRegistro});"`;
      var fStatus = `onclick="actualizarStatusMC(${idRegistro}, 'restaurar', 'F')"`;
      var fStatus1 = ``;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'FALLA');"`;
      var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
      var enlaceToltip = `FALLA${idRegistro}`;
      var fVerEnPlanner = ``;
   } else if (params.status == "PENDIENTE" && params.tipo == "TAREA") {
      var statusX = 'S-PENDIENTE';
      var fResponsable = `onclick="obtenerUsuarios('asignarTarea', ${idRegistro});"`;
      var fRangoFecha = `onclick="obtenerFechaTareas(${idRegistro}, '${params.fechaInicio + ' - ' + params.fechaFin}');"`;
      var fAdjuntos = `onclick="obtenerAdjuntosTareas(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosTareas(${idRegistro})"`;
      var fStatus = `onclick="obtenerInformacionTareas(${idRegistro}, '${params.actividad}')"`;
      var fStatus1 = `onclick="obtenerInformacionTareas(${idRegistro}, '${params.actividad}')"`;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'TAREA');"`;
      var iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
      var enlaceToltip = `TAREA${idRegistro}`;
      var fVerEnPlanner = `onclick="obtenerIncidenciaGeneral(${idRegistro}); toggleModalTailwind('modalVerEnPlannerIncidencia');"`;
   } else if (params.status == "SOLUCIONADO" && params.tipo == "TAREA") {
      var statusX = 'S-SOLUCIONADO';
      var fResponsable = `onclick="obtenerUsuarios('asignarTarea', ${idRegistro});"`;
      var fRangoFecha = '';
      var fAdjuntos = `onclick="obtenerAdjuntosTareas(${idRegistro});"`;
      var fComentarios = `onclick="obtenerComentariosTareas(${idRegistro})"`;
      var fStatus = `onclick="actualizarTareas(${idRegistro},  'status', 'P');"`;
      var fStatus1 = ``;
      var fActividades = `onclick="obtenerActividadesOT(${idRegistro}, 'TAREA');"`;
      var iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
      var enlaceToltip = `TAREA${idRegistro}`;
      var fVerEnPlanner = ``;
   }

   // DISEÑO TIPO INCIDENCIA
   const estiloTipoIncidencia =
      params.tipoIncidencia == 'URGENCIA' ?
         `<span class="text-red-500 text-xs">${params.tipoIncidencia}</span>`
         : params.tipoIncidencia == "EMERGENCIA" ?
            `<span class="text-orange-500 text-xs">${params.tipoIncidencia}</span>`
            : params.tipoIncidencia == "ALARMA" ?
               `<span class="text-yellow-500 text-xs">${params.tipoIncidencia}</span>`
               : params.tipoIncidencia == "ALERTA" ?
                  `<span class="text-blue-500 text-xs">${params.tipoIncidencia}</span>`
                  : `<span class="text-teal-500 text-xs">${params.tipoIncidencia}</span>`;

   const textStatus = params.status == "PENDIENTE" ? 'text-red-400' : 'text-green-400';

   return `
      <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal S-SOLUCIONADO">
           
        <td class="px-4 border-b border-gray-200 py-3" style="max-width: 300px;"
        ${fVerEnPlanner}>
            <div class="font-semibold uppercase leading-4" data-title="${params.actividad}">
               <h1 class="truncate ${textStatus}">${params.actividad}</h1>
            </div>
            <div class="text-gray-500 leading-3 flex">
               <h1>Creado por: ${params.creadoPor}</h1>
            </div>
         </td>

         <td id="${enlaceToltip}" class="whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3"
         ${fActividades}>
            <h1>${params.pda}</h1>
         </td>
         
         <td class="px-2 whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" 
         ${fResponsable}>
            <h1>${params.responsable}</h1>
         </td>

         <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" 
         ${fRangoFecha}>
            <div class="leading-4">${params.fechaInicio}</div>
            <div class="leading-3">${params.fechaFin}</div>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3"
         ${fComentarios}>
            <h1>${valorcomentarios}</h1>
         </td>

         <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fAdjuntos}>
            <h1>${valoradjuntos}</h1>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3" ${fStatus1}>
            <div class="text-sm flex justify-center items-center font-bold">
               ${materialesx}
               ${energeticosx}
               ${departamentosx}
               ${trabajandox}
            </div>
         </td>
         
         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3">
            <h1>${fOT}</h1>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
            <div class="px-2">
               ${iconoStatus}
            </div>
         </td>

         <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center py-3 hidden">
            <h1>${estiloTipoIncidencia}</h1>
         </td>
      </tr>
   `;
}


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
   document.getElementById('tipoFallaTarea').innerHTML = 'INCIDENCIA';
   document.getElementById("pendienteFallaTarea").
      setAttribute('onclick', `obtenerFallasPendientes(${idEquipo})`);
   document.getElementById("solucionadosFallaTarea").
      setAttribute('onclick', `obtenerFallasSolucionados(${idEquipo})`);
   // document.getElementById("agregarFallaTarea").setAttribute('onclick', 'datosModalAgregarMC()');
   document.getElementById("agregarFallaTarea").
      setAttribute('onclick', 'iniciarFormularioInicidencias()');
   document.getElementById("ganttFallaTarea").
      setAttribute('onclick', `ganttFallas(${idEquipo}, 'PENDIENTE')`);

   document.getElementById("opcionFallaPendiente").
      setAttribute("onclick", `obtenerFallas(${idEquipo})`);

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
         return array;
      })
      .then(array => {
         if (array.length) {
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
               const tipoIncidencia = array[x].tipoIncidencia;
               const sEP = array[x].sEP;
               const empresa = array[x].empresa;
               const materialesAsignados = array[x].materialesAsignados;

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
                  tipo: tipo,
                  tipoIncidencia: tipoIncidencia,
                  sEP: sEP,
                  empresa: empresa,
                  materialesAsignados: materialesAsignados
               });
               document.getElementById("dataPendientesX").insertAdjacentHTML('beforeend', data);
            }
         } else {
            alertaImg('No se Encontraron Incidencias', '', 'info', 1500);
         }

      })
      .then(function () {
         complementosFallasTareas();
      })
      .then(function () { obtenerFallasPendientes(idEquipo) })
      .catch(function (err) {
         complementosFallasTareas();
         document.getElementById("dataPendientesX").innerHTML = '';
         document.getElementById("seccionFallaTarea").innerHTML = '';
         fetch(APIERROR + err + ': (obtenerFallas)');
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
               document.getElementById("equipoFallaTarea").innerHTML = array.equipo + ' / ' + 'INCIDENCIAS';
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ': (complementosFallasTareas) ' + URL2);
         })
   }
}


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
   document.getElementById('tipoFallaTarea').innerHTML = 'INCIDENCIA';
   document.getElementById("pendienteFallaTarea").
      setAttribute('onclick', `obtenerTareasPendientes(${idEquipo})`);
   document.getElementById("solucionadosFallaTarea").
      setAttribute('onclick', `obtenerTareasSolucionados(${idEquipo})`);

   document.getElementById("agregarFallaTarea").
      setAttribute("onclick", "iniciarFormularioInicidencias();");
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
         return array;
      })
      .then(array => {
         if (array.length) {
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
               const tipoIncidencia = array[x].tipoIncidencia;
               const sEP = array[x].sEP;
               const empresa = array[x].empresa;
               const materialesAsignados = array[x].materialesAsignados;

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
                  tipo: tipo,
                  tipoIncidencia: tipoIncidencia,
                  sEP: sEP,
                  empresa: empresa,
                  materialesAsignados: materialesAsignados
               });

               document.getElementById("dataPendientesX").insertAdjacentHTML('beforeend', data);
            }
         } else {
            alertaImg('No se Encontraron Incidencias', '', 'info', 1500);
         }
      })
      .then(function () {
         complementosFallasTareas();
      })
      .then(function () { obtenerTareasPendientes(idEquipo) })
      .catch(function (err) {
         document.getElementById("dataPendientesX").innerHTML = '';
         document.getElementById("seccionFallaTarea").innerHTML = '';
         complementosFallasTareas();
         fetch(APIERROR + err + ': (obtenerTareas)');
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
               document.getElementById("equipoFallaTarea").innerHTML = array.equipo + ' / ' + 'INCIDENCIAS';
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
   let palabraEquipo = palabraFallaTarea.value;
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
         if (array.length) {

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
   let palabraEquipo = palabraFallaTarea.value;
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
         if (array.length) {

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
   } else if (statusEquipo == 'FUERASERVICIO') {
      valorstatusEquipo = '<div class="text-red-400 bg-red-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class="">Fuera de Servicio</h1></div>';
   } else if (statusEquipo == 'OPERAMAL') {
      valorstatusEquipo = '<div class="text-yellow-400 bg-yellow-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class="">OPERA MAL</h1></div>';
   }

   if (idEquipo > 0) {
      idEquipoX = `<div class=" bg-gray-200 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class="text-gray-600">ID: ${idEquipo}</h1></div>`;
   } else {
      idEquipoX = '';
   }

   var ultimoMpSemana = params.ultimoMpSemana;

   if (ultimoMpSemana <= 0) {
      valorultimoMpFecha = icono;
      valorultimoMpSemana = '';
   } else {
      valorultimoMpFecha = params.ultimoMpFecha;
      valorultimoMpSemana = "Sem " + params.ultimoMpSemana;
   }

   var proximoMpSemana = params.proximoMpSemana;

   if (proximoMpSemana <= 0) {
      valorproximoMpFecha = icono;
      valorproximoMpSemana = '';
   } else {
      valorproximoMpFecha = params.proximoMpFecha;
      valorproximoMpSemana = "Sem " + params.proximoMpSemana;
   }

   var ultimoTestFecha = params.ultimoTestFecha;

   if (ultimoTestFecha == 0) {
      valorultimoTestFecha = icono;
      valorultimoTestSemana = '';
   } else {
      valorultimoTestFecha = params.ultimoTestFecha;
      valorultimoTestSemana = "Sem " + params.ultimoTestSemana;
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


   if (valorFallasP == '' && valorFallasS == '') {
      valorFallasP = icono;
   }

   var totalDespiece = params.totalDespiece;
   if (totalDespiece == 0) {
      valorDespiece = icono;
      // fDespiece = `onclick="obtenerDespieceEquipo(0)"`;
   } else {
      valorDespiece = totalDespiece;
      // fDespiece = ``;
   }

   const fDespiece =
      params.jerarquia == "PRINCIPAL" ? `onclick="obtenerDespieceEquipo(${idEquipo})"`
         : params.jerarquia == "SECUNDARIO" ? `onclick="obtenerDespieceEquipo3(${idEquipo})"`
            : `onclick="obtenerDespieceEquipo(0)"`;

   if (params.emergenciaP <= 0 && params.emergenciaS <= 0) {
      emergenciaS = '';
   }

   if (params.urgenciaS <= 0 && params.urgenciaP <= 0) {
      urgenciaS = '';
   }

   if (params.alarmaS <= 0 && params.alarmaP <= 0) {
      alarmaS = '';
   }

   if (params.alertaS <= 0 && params.alertaP <= 0) {
      alertaS = '';
   }

   if (params.seguimientoS <= 0 && params.seguimientoP <= 0) {
      seguimientoS = '';
   }


   const emergenciaPTag = params.emergenciaP <= 0 ? ''
      : `<div class="flex justify-center items-center w-4 h-4 bg-red-300 text-red-600 rounded-full text-xxs font-bold" data-title-info="Emergencia">
         <h1 class="">${params.emergenciaP}</h1>
      </div>`;

   const urgenciaPTag = params.urgenciaP <= 0 ? ''
      : `<div class="flex justify-center items-center w-4 h-4 bg-orange-300 text-orange-600 rounded-full text-xxs font-bold" data-title-info="Urgencia">
         <h1 class="">${params.urgenciaP}</h1>
      </div>`;

   const alarmaPTag = params.alarmaP <= 0 ? ''
      : `<div class="flex justify-center items-center w-4 h-4 bg-yellow-300 text-yellow-600 rounded-full text-xxs font-bold" data-title-info="Alarma">
         <h1 class="">${params.alarmaP}</h1>
      </div>`;

   const alertaPTag = params.alertaP <= 0 ? ''
      : `<div class="flex justify-center items-center w-4 h-4 bg-blue-300 text-blue-600 rounded-full text-xxs font-bold" data-title-info="Alerta">
         <h1 class="">${params.alertaP}</h1>
      </div>`;

   const seguimientoPTag = params.seguimientoP <= 0 ? ''
      : `<div class="flex justify-center items-center w-4 h-4 bg-teal-300 text-teal-600 rounded-full text-xxs font-bold" data-title-info="Seguimiento">
         <h1 class="">${params.seguimientoP}</h1>
      </div>`;

   const destino = `<div class="mx-1 bg-gray-900 px-1 rounded-full font-semibold mr-1 py-1 flex items-center"><h1 class="text-white">${params.destino}</h1></div>`;

   // FUNCIONALIDADES
   const fFallas = `onclick="obtenerFallas(${idEquipo}); toggleModalTailwind('modalTareasFallas');"`;
   const fInfo = `onclick="informacionEquipo(${idEquipo});  abrirmodal('modalMPEquipo');"`;
   const fTest = `onclick="toggleModalTailwind('modalTestEquipo'); obtenerTestEquipo(${idEquipo})"`;

   return `
        <tr id="${idEquipo}EquipoAmerica" class="hover:bg-gray-200 cursor-pointer text-xs font-normal text-bluegray-700">
            
            <td class="px-4 border-b border-gray-200truncate py-2" style="max-width: 360px;"
            ${fInfo}>
                <div class="font-semibold uppercase text-sm" data-title="${params.equipo}">
                    <h1 class="truncate">${params.equipo}</h1>
                </div>
                <div class="text-gray-500 leading-none flex items-center text-xxs">
                    ${valorTipoEquipo}
                    ${valorstatusEquipo}
                    ${idEquipoX}
                    ${emergenciaPTag}
                    ${urgenciaPTag}
                    ${alarmaPTag}
                    ${alertaPTag}
                    ${seguimientoPTag}
                    ${destino}
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300" ${fFallas}">
                <div class="font-bold uppercase text-sm text-red-400" data-title="${'Incidencias Pendientes: ' + params.fallasP}">
                    <h1>${valorFallasP}</h1>
                </div>
                <div class="font-semibold uppercase text-green-400" data-title="${'Incidencias Solucionadas: ' + params.fallasS}">
                    <h1>${valorFallasS}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-bold uppercase text-sm text-red-400" data-title="Preventivo Pendiente: ${params.mpP}">
                    <h1>${valormpP}</h1>
                </div>
                <div class="font-semibold uppercase text-green-400" data-title="Preventivo Solucionado: ${params.mpS}">
                    <h1>${valormpS}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-semibold uppercase">
                    <h1>${valorultimoMpFecha}</h1>
                </div>
                <div class="">
                    <h1>${valorultimoMpSemana}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-semibold uppercase">
                    <h1>${valorproximoMpFecha}</h1>
                </div>
                <div class="uppercase">
                    <h1>${valorproximoMpSemana}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300" ${fTest}>
                <div class="font-semibold uppercase">
                    <h1>${valorTestR}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300">
                <div class="font-semibold uppercase">
                    <h1>${valorultimoTestFecha}</h1>
                </div>
                <div class="uppercase">
                    <h1>${valorultimoTestSemana}</h1>
                </div>
            </td>

            <td class="px-4 border-b border-gray-200 py-2 text-center leading-none hover:bg-gray-300" ${fDespiece}>
                <div class="font-semibold uppercase">
                    <h1>${valorDespiece}</h1>
                </div>
            </td>

        </tr>
    `;
}


// DESPIEDE TERCER NIVEL
const obtenerDespieceEquipo3 = idEquipo => {
   const button = document.getElementById(idEquipo + "EquipoAmerica");
   tooltipDespieceEquipo3.classList.toggle('hidden');
   Popper.createPopper(button, tooltipDespieceEquipo3);

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "obtenerDespieceEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}`;

   contenedorEquiposAmericaDespice3.innerHTML = '';

   if (idEquipo > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {

            if (array) {
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
                  const emergenciaS = array[x].emergenciaS;
                  const urgenciaS = array[x].urgenciaS;
                  const alarmaS = array[x].alarmaS;
                  const alertaS = array[x].alertaS;
                  const seguimientoS = array[x].seguimientoS;
                  const emergenciaP = array[x].emergenciaP;
                  const urgenciaP = array[x].urgenciaP;
                  const alarmaP = array[x].alarmaP;
                  const alertaP = array[x].alertaP;
                  const seguimientoP = array[x].seguimientoP;
                  const jerarquia = array[x].jerarquia;
                  const destino = array[x].destino;

                  const codigo = dataEquiposAmerica({
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
                     totalDespiece: totalDespiece,
                     emergenciaS: emergenciaS,
                     urgenciaS: urgenciaS,
                     alarmaS: alarmaS,
                     alertaS: alertaS,
                     seguimientoS: seguimientoS,
                     emergenciaP: emergenciaP,
                     urgenciaP: urgenciaP,
                     alarmaP: alarmaP,
                     alertaP: alertaP,
                     seguimientoP: seguimientoP,
                     jerarquia: jerarquia,
                     destino: destino
                  });
                  contenedorEquiposAmericaDespice3.insertAdjacentHTML('beforeend', codigo);
               }
            } else {
               alertaImg('Sin Equipos/Locales DESPIECE', '', 'info', 1500);
            }
         })
         .then(() => {
            fetch(`php/select_REST_planner.php?action=obtenerEquipoPorId&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}`)
               .then(array => array.json())
               .then(array => {
                  tituloTercerNivel.innerText = 'DESPICE DE: ' + array.equipo;
               })
         })
         .catch(function (err) {
            fetch(APIERROR + err + ': (obtenerDespieceEquipo)');
            contenedorEquiposAmericaDespice3.innerHTML = '';
         })
   } else {
      alertaImg('Equipo Sin Despiece', '', 'info', 1500);
   }
}


// OBTIENE EL DESPIECE DE EQUIPOS
function obtenerDespieceEquipo(idEquipo) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const action = "obtenerDespieceEquipo";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}`;

   document.getElementById("modalEquiposAmericaBG").removeAttribute('onclick');
   contenedorEquiposAmericaDespice.innerHTML = loaderMAPHG75;

   // FUNCIONES TOOLTIP
   scrollContenedorEquiposPrincipales.scrollTop = 0;
   tooltipDespieceEquipo3.classList.add('hidden');
   const button = document.getElementById("contenedorEquiposPrincipales");
   const tooltip = document.getElementById('tooltipDespieceEquipo');
   document.getElementById('tooltipDespieceEquipo').
      classList.toggle('hidden');
   Popper.createPopper(button, tooltip);

   document.getElementById("modalEquiposAmericaBG").
      setAttribute('onclick', "expandir('tooltipDespieceEquipo')");

   if (idEquipo > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            contenedorEquiposAmericaDespice.innerHTML = '';
            return array;
         })
         .then(array => {
            if (array) {
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
                  const emergenciaS = array[x].emergenciaS;
                  const urgenciaS = array[x].urgenciaS;
                  const alarmaS = array[x].alarmaS;
                  const alertaS = array[x].alertaS;
                  const seguimientoS = array[x].seguimientoS;
                  const emergenciaP = array[x].emergenciaP;
                  const urgenciaP = array[x].urgenciaP;
                  const alarmaP = array[x].alarmaP;
                  const alertaP = array[x].alertaP;
                  const seguimientoP = array[x].seguimientoP;
                  const jerarquia = array[x].jerarquia;
                  const destino = array[x].destino;

                  const codigo = dataEquiposAmerica({
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
                     totalDespiece: totalDespiece,
                     emergenciaS: emergenciaS,
                     urgenciaS: urgenciaS,
                     alarmaS: alarmaS,
                     alertaS: alertaS,
                     seguimientoS: seguimientoS,
                     emergenciaP: emergenciaP,
                     urgenciaP: urgenciaP,
                     alarmaP: alarmaP,
                     alertaP: alertaP,
                     seguimientoP: seguimientoP,
                     jerarquia: jerarquia,
                     destino: destino
                  });
                  contenedorEquiposAmericaDespice.insertAdjacentHTML('beforeend', codigo);
               }
            } else {
               alertaImg('Sin Equipos/Locales DESPIECE', '', 'info', 1500);
            }
         })
         .then(() => {
            fetch(`php/select_REST_planner.php?action=obtenerEquipoPorId&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}`)
               .then(array => array.json())
               .then(array => {
                  tituloSegundoNivel.innerText = 'DESPICE DE: ' + array.equipo;
               })
         })
         .catch(function (err) {
            fetch(APIERROR + err + ': (obtenerDespieceEquipo)');
            contenedorEquiposAmericaDespice.innerHTML = '';
         })
   } else {
      alertaImg('Equipo Sin Despiece', '', 'info', 1500);
   }
}


// OBTIENE LOS EQUIPOS AMERICA
function obtenerEquiposAmerica(idSeccion, idSubseccion, pagina = 0) {
   localStorage.setItem('idSeccion', idSeccion);
   localStorage.setItem("idSubseccion", idSubseccion);

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   document.getElementById("seccionSubseccionDestinoEquiposAmerica").innerHTML = loaderMAPHG40;
   document.getElementById("tooltipDespieceEquipo").classList.add('hidden');

   const action = "obtenerEquiposAmerica";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&pagina=${pagina}`;

   const data = new FormData()
   data.append("palabraEquipo", palabraEquipoAmerica.value);

   document.getElementById("tareasGeneralesEquipo").
      setAttribute('onclick', "obtenerTareas(0); toggleModalTailwind('modalTareasFallas');");

   document.getElementById('reporteEquipos').
      setAttribute('onclick', 'reporteEquipos()');

   contenedorEquiposAmerica.innerHTML = loaderMAPHG75;

   fetch(URL, {
      method: 'POST',
      body: data
   })
      .then(array => array.json())
      .then(array => {
         obtenerPaginacionEquipos(idSeccion, idSubseccion, pagina);
         // LIMPIA CONTENEDOR
         contenedorEquiposAmerica.innerHTML = '';
         tooltipDespieceEquipo3.classList.add('hidden');
         return array;
      })
      .then(array => {
         if (array) {
            theadEquipoLocal.innerHTML = `EQUIPO/LOCAL (${array.length})`;
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
               const emergenciaS = array[x].emergenciaS;
               const urgenciaS = array[x].urgenciaS;
               const alarmaS = array[x].alarmaS;
               const alertaS = array[x].alertaS;
               const seguimientoS = array[x].seguimientoS;
               const emergenciaP = array[x].emergenciaP;
               const urgenciaP = array[x].urgenciaP;
               const alarmaP = array[x].alarmaP;
               const alertaP = array[x].alertaP;
               const seguimientoP = array[x].seguimientoP;
               const jerarquia = array[x].jerarquia;
               const destino = array[x].destino;

               const codigo = dataEquiposAmerica({
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
                  totalDespiece: totalDespiece,
                  emergenciaS: emergenciaS,
                  urgenciaS: urgenciaS,
                  alarmaS: alarmaS,
                  alertaS: alertaS,
                  seguimientoS: seguimientoS,
                  emergenciaP: emergenciaP,
                  urgenciaP: urgenciaP,
                  alarmaP: alarmaP,
                  alertaP: alertaP,
                  seguimientoP: seguimientoP,
                  jerarquia: jerarquia,
                  destino: destino
               });
               contenedorEquiposAmerica.insertAdjacentHTML('beforeend', codigo);
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
         contenedorEquiposAmerica.innerHTML = '';
         obtenerTodosPendientes();
         document.getElementById("seccionSubseccionDestinoEquiposAmerica").innerHTML = '';
         alertaImg('No se Encontraron Equipos/Locales', '', 'info', 1500);
         fetch(APIERROR + err + ` 2 obtenerEquiposAmerica(${iDseccion},${idSubseccion},${pagina}) ${idDestino}`);
      });
}


// OBTIENES EL NUMERO DE PAGINAS
const obtenerPaginacionEquipos = (idSeccion, idSubseccion, pagina) => {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');

   const action = "obtenerPaginacionEquipos";
   const URL = `php/equipos_locales.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;

   const data = new FormData()
   data.append("palabraEquipo", palabraEquipoAmerica.value);

   fetch(URL, {
      method: "POST",
      body: data
   })
      .then(array => array.json())
      .then(array => {
         paginacionEquiposAmerica.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array > 0) {
            for (let x = 0; x < array + 1; x++) {

               const fx = `onclick="obtenerEquiposAmerica(${idSeccion}, ${idSubseccion}, ${x});"`;
               const paginaSelected =
                  x == pagina ? 'bg-blue-200 text-blue-500 animated pulse infinite' : '';

               if (x == 0) {
                  codigo = `
                     <a id="pagina_equipo_america_${x}" href="#" class="relative inline-flex items-center px-3 py-1 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-blue-200 hover:text-blue-500 rounded-l-lg ${paginaSelected}" ${fx}>
                        ${x + 1}
                     </a>
                     `;
               } else if (x == array) {
                  codigo = `
                     <a id="pagina_equipo_america_${x}" href="#" class="relative inline-flex items-center px-3 py-1 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-blue-200 hover:text-blue-500 rounded-r-lg ${paginaSelected}" ${fx}>
                        ${x + 1}
                     </a>
                  `;

               } else {
                  codigo = `
                     <a id="pagina_equipo_america_${x}" href="#" class="relative inline-flex items-center px-3 py-1 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-blue-200 hover:text-blue-500 ${paginaSelected}" ${fx}>
                        ${x + 1}
                    </a>
                  `;
               }
               paginacionEquiposAmerica.insertAdjacentHTML('beforeend', codigo);
            }
         } else {
            paginacionEquiposAmerica.innerHTML = '';
         }
      })
      .catch(function (err) {
         paginacionEquiposAmerica.innerHTML = '';
         fetch(APIERROR + err + ` obtenerPaginacionEquipos(${idSeccion}, ${idSubseccion})`);
      })
}


// EVENTO PARA BUSCAR EQUIPOS EN LA DB
palabraEquipoAmerica.addEventListener('keyup', event => {
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');

   if (
      (event.key === "Enter" && palabraEquipoAmerica.value.length > 1) ||
      (event.key === "Backspace" && palabraEquipoAmerica.value.length == 0)) {
      obtenerEquiposAmerica(idSeccion, idSubseccion, 0);
   }
});


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
palabraFallaTarea.addEventListener('keyup', function () {
   buscadorTabla('dataPendientesX', 'palabraFallaTarea', 0);
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

   // INCIALIZA ESTILO DE MODALSTATUS
   document.getElementById("statusenergeticostoggle").classList.add('hidden');
   document.getElementById("statusdeptoggle").classList.add('hidden');
   statusMaterialCod2bend.classList.add('hidden');
   document.getElementById("statusbitacoratoggle").classList.add('hidden');
   document.getElementById("btnEditarTituloXtoggle").classList.add('hidden');
   contenedorMover.classList.add('hidden');

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

   btnStatusUrgente.removeAttribute('onclick');
   btnStatusMaterial.removeAttribute('onclick');
   btnStatusTrabajare.removeAttribute('onclick');
   btnStatusCalidad.removeAttribute('onclick');
   btnStatusCompras.removeAttribute('onclick');
   btnStatusDireccion.removeAttribute('onclick');
   btnStatusFinanzas.removeAttribute('onclick');
   btnStatusRRHH.removeAttribute('onclick');
   btnStatusElectricidad.removeAttribute('onclick');
   btnStatusAgua.removeAttribute('onclick');
   btnStatusDiesel.removeAttribute('onclick');
   btnStatusGas.removeAttribute('onclick');
   btnStatusFinalizar.removeAttribute('onclick');
   btnStatusActivo.removeAttribute('onclick');
   btnEditarTitulo.removeAttribute('onclick');
   btnStatusGP.removeAttribute('onclick');
   btnStatusTRS.removeAttribute('onclick');
   btnStatusZI.removeAttribute('onclick');
   editarTitulo.removeAttribute('onclick');

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

   btnStatusEP.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs";

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

            if (array[0].sEP > 0) {
               btnStatusEP.className = "w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-green-500 bg-green-200 text-xs";
            }

            if (array[0].titulo) {
               editarTitulo.value = array[0].titulo;
            } else {
               editarTitulo.value = '';
            }

            if (array[0].cod2bend) {
               inputCod2bend.value = array[0].cod2bend;
            } else {
               inputCod2bend.value = '';
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

   // LIMPIAR CONTENEDORES
   loadPendientes.innerHTML = iconoLoader;

   const action = "obtenerPendientesUsuario";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;


   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataPendientesUsuario.innerHTML = '';
         return array;
      })
      .then(array => {

         if (array) {

            // PEDIENTES PLANES DE ACCIÓN
            if (array.planaccion) {
               for (let x = 0; x < array.planaccion.length; x++) {
                  const idPlanaccion = array.planaccion[x].idPlanaccion;
                  const tipoPendiente = array.planaccion[x].tipoPendiente;
                  const proyecto = array.planaccion[x].proyecto;
                  const actividad = array.planaccion[x].actividad;
                  const materiales = array.planaccion[x].sMaterial;
                  const departamentos = array.planaccion[x].sDepartamento;
                  const energeticos = array.planaccion[x].sEnergetico;
                  const trabajando = array.planaccion[x].sTrabajando;

                  const sMaterial = materiales >= 1 ? `<div class="bg-bluegray-800 w-3 h-3 rounded-full flex justify-center items-center text-white mr-1 font-semibold text-xxs"><h1>M</h1></div>` : '';
                  const sDepartamentos = departamentos >= 1 ? `<div class="bg-teal-300 w-3 h-3 rounded-full flex justify-center items-center text-teal-600 mr-1 font-semibold text-xxs"><h1>D</h1></div>` : '';
                  const sEnergeticos = energeticos >= 1 ? `<div class="bg-yellow-300 w-3 h-3 rounded-full flex justify-center items-center text-yellow-600 mr-1 font-semibold text-xxs"><h1>E</h1></div>` : '';
                  const sTrabajando = trabajando >= 1 ? `<div class="bg-cyan-300 w-3 h-3 rounded-full flex justify-center items-center text-cyan-600 mr-1 font-semibold text-xxs"><h1>T</h1></div>` : '';

                  const fVerEnPlanner = `onclick="verEnPlannerPlanaccion(${idPlanaccion}); toggleModalTailwind('modalVerEnPlannerPlanaccion');"`;

                  const codigo = `
                    <div class="misPendientes_ hidden w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-left items-center py-1 misPendientes_PLANACCION" data-title-100="${actividad}" 
                     ${fVerEnPlanner}>
                        <div class="flex flex-wrap w-full overflow-hidden">
                           <div class="flex flex-row w-full justify-left items-center">
                              <h1 class="truncate"> ${proyecto}</h1>
                              <i class="fas fa-arrow-right px-1"></i> 
                              <h1 class="truncate">${actividad}</h1>
                           </div>
                           <div class="flex flex-row space-between pl-5">
                              ${sMaterial}
                              ${sDepartamentos}
                              ${sEnergeticos}
                              ${sTrabajando}
                           </div>
                        </div>
                     </div>                     
                  `;
                  dataPendientesUsuario.insertAdjacentHTML('beforeend', codigo);
               }
            }

            // PENDIENTES INCIDENCIAS DE EQUIPOS
            if (array.incidencias) {
               for (let x = 0; x < array.incidencias.length; x++) {
                  const idIncidencia = array.incidencias[x].idIncidencia;
                  const actividad = array.incidencias[x].actividad;
                  const equipo = array.incidencias[x].equipo;
                  const tipoIncidencia = array.incidencias[x].tipoIncidencia;
                  const materiales = array.incidencias[x].sMaterial;
                  const departamentos = array.incidencias[x].sDepartamento;
                  const energeticos = array.incidencias[x].sEnergetico;
                  const trabajando = array.incidencias[x].sTrabajando;

                  const estiloTipoIncidencia =
                     tipoIncidencia == 'URGENCIA' ?
                        `<div class="flex justify-center items-center w-4 h-full bg-orange-300 text-orange-600 rounded text-xxs font-bold px-2"><h1>U</h1></div>`
                        : tipoIncidencia == "EMERGENCIA" ?
                           ` <div class="flex justify-center items-center w-4 h-full bg-red-300 text-red-600 rounded text-xxs font-bold px-2"><h1>E</h1></div>`
                           : tipoIncidencia == "ALARMA" ?
                              ` <div class="flex justify-center items-center w-4 h-full bg-yellow-300 text-yellow-600 rounded text-xxs font-bold px-2"><h1>A</h1></div>`
                              : tipoIncidencia == "ALERTA" ?
                                 `<div class="flex justify-center items-center w-4 h-full bg-blue-300 text-blue-600 rounded text-xxs font-bold px-2"><h1>A</h1></div>`
                                 : ` <div class="flex justify-center items-center w-4 h-full bg-teal-300 text-teal-600 rounded text-xxs font-bold px-2"><h1>S</h1></div>`;

                  const sMaterial = materiales >= 1 ? `<div class="bg-bluegray-800 w-3 h-3 rounded-full flex justify-center items-center text-white mr-1 font-semibold text-xxs"><h1>M</h1></div>` : '';
                  const sDepartamentos = departamentos >= 1 ? `<div class="bg-teal-300 w-3 h-3 rounded-full flex justify-center items-center text-teal-600 mr-1 font-semibold text-xxs"><h1>D</h1></div>` : '';
                  const sEnergeticos = energeticos >= 1 ? `<div class="bg-yellow-300 w-3 h-3 rounded-full flex justify-center items-center text-yellow-600 mr-1 font-semibold text-xxs"><h1>E</h1></div>` : '';
                  const sTrabajando = trabajando >= 1 ? `<div class="bg-cyan-300 w-3 h-3 rounded-full flex justify-center items-center text-cyan-600 mr-1 font-semibold text-xxs"><h1>T</h1></div>` : '';
                  const fVerEnPlanner = `onclick="obtenerIncidenciaEquipos(${idIncidencia}); toggleModalTailwind('modalVerEnPlannerIncidencia');"`;

                  const codigo = `
                     <div class="misPendientes_ hidden w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-left items-center misPendientes_INCIDENCIA" data-title-100="${actividad}" 
                     ${fVerEnPlanner}>
                        <div class="py-2">${estiloTipoIncidencia}</div> 
                        <div class="flex flex-wrap w-full overflow-hidden">
                           <div class="flex flex-row w-full justify-left items-center">
                              <h1 class="truncate ml-1"> ${equipo}</h1> 
                              <i class="fas fa-arrow-right px-1"></i> 
                              <h1 class="truncate">${actividad}</h1>
                           </div>
                           <div class="flex flex-row space-between pl-5">
                              ${sMaterial}
                              ${sDepartamentos}
                              ${sEnergeticos}
                              ${sTrabajando}
                           </div>
                        </div>
                     </div>
                  `;
                  dataPendientesUsuario.insertAdjacentHTML('beforeend', codigo);
               }
            }

            // PENDIENTES INCIDENCIAS GENERALES
            if (array.incidenciasG) {
               for (let x = 0; x < array.incidenciasG.length; x++) {
                  const idIncidencia = array.incidenciasG[x].idIncidencia;
                  const actividad = array.incidenciasG[x].actividad;
                  const tipoIncidencia = array.incidenciasG[x].tipoIncidencia;
                  const materiales = array.incidenciasG[x].sMaterial;
                  const departamentos = array.incidenciasG[x].sDepartamento;
                  const energeticos = array.incidenciasG[x].sEnergetico;
                  const trabajando = array.incidenciasG[x].sTrabajando;

                  const estiloTipoIncidencia =
                     tipoIncidencia == 'URGENCIA' ?
                        `<div class="flex justify-center items-center w-4 h-4 bg-orange-300 text-orange-600 rounded text-xxs font-bold px-2"><h1>U</h1></div>`
                        : tipoIncidencia == "EMERGENCIA" ?
                           ` <div class="flex justify-center items-center w-4 h-4 bg-red-300 text-red-600 rounded text-xxs font-bold px-2"><h1>E</h1></div>`
                           : tipoIncidencia == "ALARMA" ?
                              ` <div class="flex justify-center items-center w-4 h-4 bg-yellow-300 text-yellow-600 rounded text-xxs font-bold px-2"><h1>A</h1></div>`
                              : tipoIncidencia == "ALERTA" ?
                                 `<div class="flex justify-center items-center w-4 h-4 bg-blue-300 text-blue-600 rounded text-xxs font-bold px-2"><h1>A</h1></div>`
                                 : ` <div class="flex justify-center items-center w-4 h-4 bg-teal-300 text-teal-600 rounded text-xxs font-bold px-2"><h1>S</h1></div>`;

                  const sMaterial = materiales >= 1 ? `<div class="bg-bluegray-800 w-3 h-3 rounded-full flex justify-center items-center text-white mr-1 font-semibold"><h1>M</h1></div>` : '';
                  const sDepartamentos = departamentos >= 1 ? `<div class="bg-teal-300 w-3 h-3 rounded-full flex justify-center items-center text-teal-600 mr-1 font-semibold"><h1>D</h1></div>` : '';
                  const sEnergeticos = energeticos >= 1 ? `<div class="bg-yellow-300 w-3 h-3 rounded-full flex justify-center items-center text-yellow-600 mr-1 font-semibold"><h1>E</h1></div>` : '';
                  const sTrabajando = trabajando >= 1 ? `<div class="bg-cyan-300 w-3 h-3 rounded-full flex justify-center items-center text-cyan-600 mr-1 font-semibold"><h1>T</h1></div>` : '';

                  const fVerEnPlanner = `onclick="obtenerIncidenciaGeneral(${idIncidencia}); toggleModalTailwind('modalVerEnPlannerIncidencia');"`;

                  const codigo = `
                     <div class="misPendientes_ hidden w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-left items-center misPendientes_INCIDENCIA" data-title-100="${actividad}" 
                     ${fVerEnPlanner}>
                        <div class="py-2">${estiloTipoIncidencia}</div> 
                        <div class="flex flex-wrap w-full overflow-hidden">
                           <div class="flex flex-row w-full justify-left items-center">
                              <h1 class="ml-1"> General</h1>
                              <i class="fas fa-arrow-right px-1"></i> 
                              <h1 class="truncate">${actividad}</h1>
                           </div>
                           <div class="flex flex-row space-between pl-5">
                              ${sMaterial}
                              ${sDepartamentos}
                              ${sEnergeticos}
                              ${sTrabajando}
                           </div>
                        </div>
                     </div>
                  `;
                  dataPendientesUsuario.insertAdjacentHTML('beforeend', codigo);
               }
            }
         }
         return array;
      })
      .then(array => {
         if (array) {
            // TOTAL INCIDENCIAS
            let TI = 0;
            let TPDA = 0;

            if (array.incidencias) {
               TI += array.incidencias.length;
            }

            if (array.incidenciasG) {
               TI += array.incidenciasG.length;
            }

            if (array.planaccion.length) {
               TPDA = array.planaccion.length;
            }

            totalPendientesPDA.innerHTML = `PDA Proyectos (${TPDA})`;
            totalPendientesFallas.innerHTML = `Incidencias (${TI})`;

            if (TI > 0) {
               opcionMisPendientes('misPendientesIncidencias');
               misPendientesIncidencias.click();
            } else if (TPDA > 0) {
               opcionMisPendientes('misPendientesPDA');
               misPendientesPDA.click();
            }
         }
         loadPendientes.innerHTML = '';
      })
      .catch(function (err) {
         fetch(APIERROR + err + ': (obtenerPendientesUsuario) ' + idUsuario + ' | ' + URL);
         loadPendientes.innerHTML = '';
         dataPendientesUsuario.innerHTML = '';
      })
}


// OPCION SELECCIONADA MIS PENDIETES
const opcionMisPendientes = opcion => {
   if (opcion == "misPendientesIncidencias") {
      misPendientesPDA.classList.remove('bg-purple-200', 'text-purple-500');
      misPendientesIncidencias.classList.add('bg-red-200', 'text-red-500');
   } else {
      misPendientesPDA.classList.add('bg-purple-200', 'text-purple-500');
      misPendientesIncidencias.classList.remove('bg-red-200', 'text-red-500');
   }
}


// EVENTOS PARA COLUMNA DE MIS PENDIETES
misPendientesIncidencias.addEventListener("click", () => {
   opcionMisPendientes('misPendientesIncidencias');

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


misPendientesTareas.addEventListener("click", () => {
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


misPendientesPDA.addEventListener("click", () => {
   opcionMisPendientes('misPendientesPDA');

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
   let estiloSeccionTest = document.getElementById("estiloSeccionTest");
   let seccion = document.getElementById("seccionTest");
   let equipo = document.getElementById("equipoTest");
   let equipoAfectado = document.getElementById("nombreEquipoTest");
   let contenedor = document.getElementById("dataTestEquipo");

   document.getElementById("btnAgregarTest").setAttribute('onclick', 'agregarTestEquipo();');

   // LIMPIA CONTENEDORES
   estiloSeccionTest.className = '';
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
            estiloSeccionTest.className = seccionClass + '-logo-modal flex justify-center items-center rounded-b-md w-16 h-10 shadow-xs bg-indigo-400';
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
         if (array.length) {
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

   inputAdjuntos.setAttribute('onchange', `agregarAdjuntoTest(${idTest})`);

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
   const files = inputAdjuntos;
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
function obtenerEnergeticos(idSeccion, idSubseccion, status) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let contenedor = document.getElementById("dataEnergeticos");

   // obtenerEnergeticos(1001, 1009, 'PENDIENTE');
   btnPendientesEnergeticos.
      setAttribute('onclick', `obtenerEnergeticos(${idSeccion}, ${idSubseccion}, 'PENDIENTE')`);

   btnSolucionadosEnergeticos.
      setAttribute('onclick', `obtenerEnergeticos(${idSeccion}, ${idSubseccion}, 'SOLUCIONADO')`);

   const action = 'obtenerEnergeticos';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&status=${status}`;

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

               const fResponsable = status == "PENDIENTE" ?
                  `onclick="obtenerResponsableEnergetico(${idEnergetico}); abrirmodal('modalUsuarios')"` : '';

               const fRangoFecha = status == "PENDIENTE" ?
                  `onclick="obtenerRangoFecha(${idEnergetico}, 'rangoFecha', '${fechaInicio} - ${fechaFin}'); abrirmodal('modalRangoFechaX')"` : '';

               const fAdjuntos = `onclick="obtenerAdjuntosEnergetico(${idEnergetico}); abrirmodal('modalMedia')"`;

               const fComentarios = `onclick="obtenerComentariosEnergetico(${idEnergetico}); abrirmodal('modalComentarios')"`;

               if (status == "PENDIENTE") {
                  fStatus = `onclick="obtenerStatusEnergetico(${idEnergetico}); abrirmodal('modalStatus')"`;
                  iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
               } else {
                  fStatus = `onclick="actualizarEnergetico(${idEnergetico}, 'restaurar', 'F')"`;
                  iconoStatus = '<i class="fas fa-redo-alt fa-lg text-red-500"></i>';
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

                     <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" data-title="${responsable}" ${fResponsable}>
                        <h1>${responsable}</h1>
                     </td>

                     <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fRangoFecha}>
                        <div class="leading-4">${fechaInicio}</div>
                        <div class="leading-3">${fechaFin}</div>
                     </td>

                     <td class=" whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fAdjuntos}>
                        <h1>${adjuntosX}</h1>
                     </td>

                     <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fComentarios}>
                        <h1>${comentariosX}</h1>
                     </td>

                     <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                        <div class="px-2">
                           ${iconoStatus}
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


// ACTUALIZAR ENERGETICOS
function actualizarEnergetico(idEnergetico, columna, valor) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');
   let cod2bend = document.getElementById('inputCod2bend');

   if (columna == "rangoFecha") {
      valor = inputRangoFecha.value;
   }

   const action = 'actualizarEnergetico';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEnergetico=${idEnergetico}&columna=${columna}&valor=${valor}&titulo=${editarTitulo.value}&cod2bend=${cod2bend.value}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {

         if (array == "responsable") {
            alertaImg('Responsable Actualizado', '', 'success', 1400);
            cerrarmodal('modalUsuarios');
         } else if (array == "titulo") {
            alertaImg('Título Actualizado', '', 'success', 1400);
            cerrarmodal('modalStatus');
         } else if (array == "trabajare") {
            alertaImg('Status Trabajando, Actualizado', '', 'success', 1400);
         } else if (array == "energetico") {
            alertaImg('Status Energético, Actualizado', '', 'success', 1400);
         } else if (array == "departamento") {
            alertaImg('Status Departamento, Actualizado', '', 'success', 1400);
         } else if (array == "bitacora") {
            alertaImg('Bitácora Actualizada', '', 'success', 1400);
         } else if (array == "solucionado") {
            alertaImg('Energético Solucionado', '', 'success', 1400);
            cerrarmodal('modalStatus');
         } else if (array == "eliminado") {
            alertaImg('Energético Eliminado', '', 'success', 1400);
            cerrarmodal('modalStatus');
         } else if (array == "restuarado") {
            alertaImg('Energético Restaurado', '', 'success', 1400);
            cerrarmodal('modalStatus');
         } else if (array == "material") {
            alertaImg('Status Material, Actualizado', '', 'success', 1400);
         } else if (array == "rangoFecha") {
            alertaImg('Rango Fecha, Actualizado', '', 'success', 1400);
            cerrarmodal('modalRangoFechaX');
         } else {
            alertaImg('Intente de Nuevo', '', 'info', 1400);
            cerrarmodal('modalStatus');
         }

         obtenerEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
         estiloModalStatus(idEnergetico, 'ENERGETICO');
      })
      .catch(function (err) {
         fetch(APIERROR + err + `actualizarEnergetico(${idEnergetico}, ${columna}, ${valor})`);
      })
}


// OBTENER STATUS ENERGETICOS
function obtenerStatusEnergetico(idEnergetico) {

   // FUNCIÓN PARA DARL ESTIOLO AL MODALSTATUS
   estiloModalStatus(idEnergetico, 'ENERGETICO');

   // La función actulizarTarea(?, ?, ?), recibe 3 parametros idTarea, columna a modificar y el tercer parametro solo funciona para el titulo por ahora

   // Status
   btnStatusUrgente.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "status_urgente", 0)`);
   btnStatusMaterial.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "status_material", 0)`);
   btnStatusTrabajare.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "status_trabajare", 0)`);

   // Status Departamento
   btnStatusCalidad.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "departamento_calidad", 0)`);
   btnStatusCompras.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "departamento_compras", 0)`);
   btnStatusDireccion.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "departamento_direccion", 0)`);
   btnStatusFinanzas.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "departamento_finanzas", 0)`);
   btnStatusRRHH.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "departamento_rrhh", 0)`);

   // Status Energéticos
   btnStatusElectricidad.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "energetico_electricidad", 0)`);
   btnStatusAgua.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "energetico_agua", 0)`);
   btnStatusDiesel.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "energetico_diesel", 0)`);
   btnStatusGas.
      setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "energetico_gas", 0)`);

   // Finalizar TAREA
   btnStatusFinalizar.setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "status", "F")`);

   // PROYECTO ENTREGADO
   btnStatusEP.setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "status_ep", "F")`);

   // Activo TAREA
   btnStatusActivo.setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "activo", 0)`);
   // Titulo TAREA
   btnEditarTitulo.setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "titulo", 0)`);

   // Bitacoras
   btnStatusGP.setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "bitacora_gp", 0)`);
   btnStatusTRS.setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "bitacora_trs", 0)`);
   btnStatusZI.setAttribute("onclick", `actualizarEnergetico(${idEnergetico}, "bitacora_zi", 0)`);
}


// OBTIENE RESPONSABLES
function obtenerResponsableEnergetico(idEnergetico) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   dataUsuarios.innerHTML = '';
   const action = "obtenerUsuariosEnergeticos";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEnergetico=${idEnergetico}`;
   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idUsuarioX = array[x].idUsuario;
               const nombre = array[x].nombre;
               const apellido = array[x].apellido;
               const puesto = array[x].puesto;

               const codigo = `
                  <div class="w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate" onclick="actualizarEnergetico(${idEnergetico}, 'responsable', ${idUsuarioX});">
                     <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="20" height="20" alt="">
                        <h1 class="ml-2">${nombre + ' ' + apellido}</h1>
                        <p class="font-bold mx-1"> / </p>
                        <h1 class="font-normal text-xs">${puesto}</h1>
                  </div>
               `;
               dataUsuarios.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
}


// OBTIEN RANGO DE FECHA ENERGETICO
function obtenerRangoFecha(idEnergetico, columna, valor) {
   btnAplicarRangoFecha.
      setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, '${columna}', 0)`);
   inputRangoFecha.value = valor;
}


// OBTENER COMENTARIOS
function obtenerComentariosEnergetico(idEnergetico) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const contendor = document.getElementById("dataComentarios");
   contendor.innerHTML = '';
   let btnComentario = document.getElementById("btnComentario");
   btnComentario.setAttribute('onclick', `agregarComentariosEnergetico(${idEnergetico})`);

   const action = 'obtenerComentariosEnergetico';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEnergetico=${idEnergetico}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idComentario = array[x].idComentario;
               const comentario = array[x].comentario;
               const nombre = array[x].nombre;
               const apellido = array[x].apellido;
               const fecha = array[x].fecha;

               codigo = `
            <div class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
               <div class="flex items-center justify-center" style="width: 48px;">
                     <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="48" height="48" alt="">
               </div>
               <div class="flex flex-col justify-start items-start p-2 w-full">
                     <div class="text-xs font-bold flex flex-row justify-between w-full">
                        <div>
                           <h1>${nombre + ' ' + apellido}</h1>
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
               contendor.insertAdjacentHTML('beforeend', codigo);
            }
         }

      })
      .catch(function (err) {
         fetch(APIERROR + err + ``);
      })
}


// AGREGA COMENTARIOS EN ENERGETICOS
function agregarComentariosEnergetico(idEnergetico) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');
   let comentario = document.getElementById("inputComentario");

   const action = "agregarComentariosEnergetico";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEnergetico=${idEnergetico}&comentario=${comentario.value}`;

   if (comentario.value.length > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1) {
               alertaImg('Comentario Agregado', '', 'success', 1500);
               obtenerComentariosEnergetico(idEnergetico);
               obtenerEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
               comentario.value = '';
            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1400);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err);
         })
   } else {
      alertaImg('Comentario Vacio', '', 'info', 1400);
   }
}


// OBTENER ADJUNTOS ENERGETICOS
function obtenerAdjuntosEnergetico(idEnergetico) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   const contenedorImg = document.getElementById("dataImagenes");
   const contenedorAdjuntos = document.getElementById("dataAdjuntos");
   const contenedorImagenes = document.getElementById("contenedorImagenes");
   const contenedorDocumentos = document.getElementById("contenedorDocumentos");

   inputAdjuntos.setAttribute('onchange', `agregarAdjuntosEnergetico(${idEnergetico})`);

   // VALORES Y DESEÑO INICIAL
   contenedorImg.innerHTML = '';
   contenedorAdjuntos.innerHTML = '';
   contenedorImagenes.classList.add('hidden');
   contenedorDocumentos.classList.add('hidden');

   const action = 'obtenerAdjuntosEnergetico';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEnergetico=${idEnergetico}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         if (array) {
            for (let x = 0; x < array.length; x++) {
               const idAdjunto = array[x].idAdjunto;
               const url = array[x].url;
               const tipo = array[x].tipo;

               if (tipo == "jpg" || tipo == "png" || tipo == "jpeg") {
                  codigo = `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative">

                        <a href="planner/energeticos/${url}" target="_blank" data-title="Clic para Abrir">
                           <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer" style="background-image: url(planner/energeticos/${url})">
                           </div>
                        </a>

                        <div class="w-full absolute text-transparent hover:text-red-700" style="bottom: 12px; left: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'ENERGETICO');">
                           <i class="fas fa-trash-alt fa-2x" data-title="Clic para Eliminar"></i>
                        </div>

                     </div>               
                  `;
                  contenedorImg.insertAdjacentHTML('beforeend', codigo);
                  contenedorImagenes.classList.remove('hidden');
               } else {
                  codigo = `
                     <div id="modalMedia_adjunto_img_${idAdjunto}" class="relative">
                           
                        <a href="planner/energeticos/${url}" target="_blank">
                           <div class="auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                              <i class="fad fa-file-alt fa-3x"></i>
                              <p class="text-sm font-normal ml-2">${url}
                              </p>
                           </div>
                        </a>
                        
                        <div class="absolute text-red-700" style="bottom: 22px; right: 0px;" onclick="eliminarAdjunto(${idAdjunto}, 'ENERGETICO');">
                           <i class="fas fa-trash-alt fa-2x"></i>
                        </div>
                     </div>                  
                  `;
                  contenedorAdjuntos.insertAdjacentHTML('beforeend', codigo);
                  contenedorDocumentos.classList.remove('hidden');
               }
            }
         }
      })
      .catch(function (err) {
         fetch(APIERROR + err + ``);
      })
}


// AGREGAR ADJUNTO A ENERGETICOS
function agregarAdjuntosEnergetico(idEnergetico) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');
   let cargandoAdjunto = document.getElementById("cargandoAdjunto");
   cargandoAdjunto.innerHTML = iconoLoader;

   const action = "agregarAdjuntosEnergetico";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEnergetico=${idEnergetico}`;

   // VARIABLES DEL ADJUNTO
   const files = inputAdjuntos;
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
                  obtenerEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
                  obtenerAdjuntosEnergetico(idEnergetico);
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
               fetch(APIERROR + err + ` agregarAdjuntoTest(${idEnergetico})`)
               cargandoAdjunto.innerHTML = '';
               alertaImg('Intente de Nuevo', '', 'info', 1500);
               files.value = '';
            })
      }
   }
}


// ELIMINAR ADJUNTOS (TIPO DE ADJUNTO + IDADJUNTO)
function eliminarAdjunto(idAdjunto, tipoAdjunto) {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idEquipo = localStorage.getItem('idEquipo');
   let idProyecto = localStorage.getItem('idProyecto');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');

   const action = 'eliminarAdjunto';
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idAdjunto=${idAdjunto}&tipoAdjunto=${tipoAdjunto}`;

   alertify.confirm('MAPHG', '¿Eliminar Adjunto?', function () {
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
               } else if (tipoAdjunto == "ENERGETICO") {
                  obtenerEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
               } else if (tipoAdjunto == "EQUIPO") {
                  obtenerImagenesEquipo(idEquipo);
               }

            } else {
               alertaImg('Intente de Nuevo', '', 'info', 1500);
            }
         })
         .catch(function (err) {
            fetch(APIERROR + err + ` eliminarAdjunto(${idAdjunto}, ${tipoAdjunto})`);
         })
   }
      , function () { alertify.error('Proceso Cancelado') });
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


// ACTUALIZA TAREAS DE EQUIPO
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


// FUNCIÓN EJECUTADA CADA 60s PARA ACTUALILZAR PENDIENTES DE LOS USUARIOS
setInterval(function () {
   alertaImg('Pendientes Actualizados', '', 'success', 800);
   obtenerPendientesUsuario();
   comprobarSession();
}, 180000);


// CONTADOR DE CARACTERES EN #editarTitulo
editarTitulo.addEventListener('keydown', event => {
   if (event.keyCode > 47 && event.keyCode < 91) {
      if (editarTitulo.value.length >= 60) {
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


async function iniciarFormularioInicidencias() {
   await abrirmodal("modalAgregarIncidencias");
   await rangoFechaX('rangoFechaIncidencia');

   //DESBLOQUE BOTONES PARA LANZAR EVENTO CLIC() 
   btnTGIncidencias.removeAttribute('disabled',);
   btnEquipoIncidencias.removeAttribute('disabled',);
   btnLocalIncidencias.removeAttribute('disabled',);

   //LIMPIAR CONTENIDO 
   descripcionIncidencia.value = '';
   comentarioIncidencia.value = '';

   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');
   let idEquipo = localStorage.getItem('idEquipo');

   // DESBLOQUEA INPUTS
   btnTGIncidencias.classList.remove('hidden');
   btnEquipoIncidencias.classList.remove('hidden');
   btnLocalIncidencias.classList.remove('hidden');


   // APLICA ESTILO PARA BTN
   const URL4 = `php/select_REST_planner.php?action=obtenerEquipoPorId&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`

   if (idEquipo == 0) {
      btnTGIncidencias.click();
   } else {
      await fetch(URL4)
         .then(array => array.json())
         .then(array => {
            if (array) {
               if (array.localEquipo == "EQUIPO") {
                  btnEquipoIncidencias.click();
               } else if (array.localEquipo == "LOCAL") {
                  btnLocalIncidencias.click();
               }
            }
         })
   }


   // OBTIENE LA SECCION
   const action = "obtenerSeccionesPorDestino";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;
   await fetch(URL)
      .then(array => array.json())
      .then(array => {
         seccionIncidencias.innerHTML = '<option value="0">Seleccione Sección</option>';
         seccionIncidencias.value = 0;
         return array;
      })
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
      .catch(function (err) {
         seccionIncidencias.innerHTML = '<option value="0">Seleccione Sección</option>';
         fetch(APIERROR + err);
      })


   // OBTIENE SUBSECCIONES
   const action2 = "obtenerSubseccionPorSeccion";
   const URL2 = `php/select_REST_planner.php?action=${action2}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}`;

   await fetch(URL2)
      .then(array => array.json())
      .then(array => {
         subseccionIncidencias.innerHTML = '<option value="0">Seleccione Subsección</option>';
         subseccionIncidencias.value = 0;
         return array;
      })
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
         subseccionIncidencias.innerHTML = '<option value="0">Seleccione Subsección</option>';
         fetch(APIERROR + err);
      })


   // OBTIENES USUARIOS INICIALES
   const action5 = "obtenerUsuarios";
   const URL5 = `php/select_REST_planner.php?action=${action5}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

   await fetch(URL5)
      .then(array => array.json())
      .then(array => {
         responsablesIncidencias.innerHTML = '<option value="0">Seleccion Responsable</option>';
         responsablesIncidencias.value = 0;
         return array;
      })
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


   // ASIGNA EQUIPO, LOCAL O TG
   const action3 = "obtenerEquipoPorId";
   const URL3 = `php/select_REST_planner.php?action=${action3}&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

   await fetch(URL3)
      .then(array => array.json())
      .then(array => {
         equipoLocalIncidencias.innerHTML = '<option value="0">Seleccione</option>';
         equipoLocalIncidencias.value = 0;

         return array;
      })
      .then(array => {
         if (array) {
            const idEquipoX = array.idEquipo;
            const equipo = array.equipo;
            const codigo = `<option value="${idEquipoX}">${equipo}</option>`;
            equipoLocalIncidencias.insertAdjacentHTML('beforeend', codigo);
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
         equipoLocalIncidencias.innerHTML = '<option value="0">Seleccione</option>';
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
   equipoLocalIncidencias.innerHTML = '<option value="0">Seleccion Equipo</option>';
   btnTGIncidencias.classList.add("bg-blue-600");
   btnEquipoIncidencias.classList.remove("bg-blue-600");
   btnLocalIncidencias.classList.remove("bg-blue-600");
   equipoLocalIncidencias.value = 0;
   contenedorEquipoLocalIncidencias.classList.add('hidden');
   // equipoLocalIncidencias.classList.add('hidden');
})

btnEquipoIncidencias.addEventListener('click', () => {
   btnTGIncidencias.classList.remove("bg-blue-600");
   btnEquipoIncidencias.classList.add("bg-blue-600");
   btnLocalIncidencias.classList.remove("bg-blue-600");
   contenedorEquipoLocalIncidencias.classList.remove('hidden');

   const idSeccion = seccionIncidencias.value;
   const idSubseccion = subseccionIncidencias.value;
   const action = "obtenerEquipoLocal";

   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&tipo=EQUIPO`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         equipoLocalIncidencias.innerHTML = '<option value="0">Seleccione Equipo</option>';
         equipoLocalIncidencias.value = 0;
         return array;
      })
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
         equipoLocalIncidencias.innerHTML = '<option value="0">Seleccione Equipo</option>';
         equipoLocalIncidencias.value = 0;
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
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'text-white', 'opcionSeleccionadaIncidencia');
      }
   }
   btnEmergenciaIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-red-600');
   btnEmergenciaIncidencia.setAttribute('style', 'color: white');
})


btnUrgenciaIncidencia.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnUrgenciaIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-orange-600');
   btnUrgenciaIncidencia.setAttribute('style', 'color: white');
})


btnAlarmaIncidencia.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnAlarmaIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-yellow-600');
   btnAlarmaIncidencia.setAttribute('style', 'color: white');
})


btnAlertaIncidencia.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnAlertaIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-blue-600');
   btnAlertaIncidencia.setAttribute('style', 'color: white');
})


btnSeguimientoIncidencia.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionSeleccionadaIncidencia')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionSeleccionadaIncidencia');
      }
   }
   btnSeguimientoIncidencia.classList.add('opcionSeleccionadaIncidencia', 'bg-teal-600');
   btnSeguimientoIncidencia.setAttribute('style', 'color: white');
})


function estiloDefaultBotonesIncidencias() {
   btnEmergenciaIncidencia.removeAttribute('style');
   btnUrgenciaIncidencia.removeAttribute('style');
   btnAlarmaIncidencia.removeAttribute('style');
   btnAlertaIncidencia.removeAttribute('style');
   btnSeguimientoIncidencia.removeAttribute('style');
   btnEmergenciaEnergetico.removeAttribute('style');
   btnUrgenciaEnergetico.removeAttribute('style');
   btnAlarmaEnergetico.removeAttribute('style');
   btnAlertaEnergetico.removeAttribute('style');
   btnSeguimientoEnergetico.removeAttribute('style');
}


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

   if (document.getElementsByClassName("opcionSeleccionadaIncidencia")[0]) {
      let tipoX = document.getElementsByClassName("opcionSeleccionadaIncidencia")[0].id;
      tipo =
         tipoX == "btnEmergenciaIncidencia" ? 'EMERGENCIA' :
            tipoX == "btnUrgenciaIncidencia" ? 'URGENCIA' :
               tipoX == "btnAlarmaIncidencia" ? 'ALARMA' :
                  tipoX == "btnAlertaIncidencia" ? 'ALERTA' :
                     tipoX == "btnSeguimientoIncidencia" ? 'SEGUIMIENTO' :
                        'SEGUIMIENTO';
   } else {
      alertaImg('Seleccion el tipo de Incidencia', '', 'info', 1600);
      tipo = '';
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
               obtenerFallas(idEquipo);
            } else if (array == 2) {
               alertaImg('Incidencia General, Agregada', '', 'success', 1600);
               cerrarmodal('modalAgregarIncidencias');
               obtenerTareas(0);
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
               const codigo = `<option value="${id}">${nombre + ' ' + apellido}</option>`;
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
         fetch(APIERROR + err + ` btnModalAgregarEnergeticos`);
      })
})


btnAgregarEnergeticos.addEventListener('click', () => {
   let idUsuario = localStorage.getItem('usuario');
   let idDestino = localStorage.getItem('idDestino');
   let idSeccion = localStorage.getItem('idSeccion');
   let idSubseccion = localStorage.getItem('idSubseccion');

   if (document.getElementsByClassName("opcionIncidenciaEnergetico")[0]) {
      let tipoX = document.getElementsByClassName("opcionIncidenciaEnergetico")[0].id;
      tipo =
         tipoX == "btnEmergenciaEnergetico" ? 'EMERGENCIA' :
            tipoX == "btnUrgenciaEnergetico" ? 'URGENCIA' :
               tipoX == "btnAlarmaEnergetico" ? 'ALARMA' :
                  tipoX == "btnAlertaEnergetico" ? 'ALERTA' :
                     tipoX == "btnSeguimientoEnergetico" ? 'SEGUIMIENTO' :
                        'SEGUIMIENTO';
   } else {
      alertaImg('Seleccion el tipo de Incidencia', '', 'info', 1600);
      tipo = '';
   }

   const action = "agregarEnergetico";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&titulo=${tituloPendienteEnergeticos.value}&rangoFecha=${rangoFechaEnergeticos.value}&responsable=${responsableEnergeticos.value}&comentario=${comentarioEnergeticos.value}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&tipo=${tipo}`;

   if (tituloPendienteEnergeticos.value != "" && rangoFechaEnergeticos.value != "" && responsableEnergeticos.value > 0 && tipo != "") {

      fetch(URL)
         .then(array => array.json())
         .then(array => {
            if (array == 1 || array == 2) {
               alertaImg('Pendiente Agregado', '', 'success', 1500);
               cerrarmodal('modalAgregarEnergeticos');
               obtenerEnergeticos(idSeccion, idSubseccion, 'PENDIENTE');
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


btnEmergenciaEnergetico.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionIncidenciaEnergetico')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'text-white', 'opcionIncidenciaEnergetico');
      }
   }
   btnEmergenciaEnergetico.classList.add('opcionIncidenciaEnergetico', 'bg-red-600');
   btnEmergenciaEnergetico.setAttribute('style', 'color: white');
})


btnUrgenciaEnergetico.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionIncidenciaEnergetico')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionIncidenciaEnergetico');
      }
   }
   btnUrgenciaEnergetico.classList.add('opcionIncidenciaEnergetico', 'bg-orange-600');
   btnUrgenciaEnergetico.setAttribute('style', 'color: white');
})


btnAlarmaEnergetico.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionIncidenciaEnergetico')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionIncidenciaEnergetico');
      }
   }
   btnAlarmaEnergetico.classList.add('opcionIncidenciaEnergetico', 'bg-yellow-600');
   btnAlarmaEnergetico.setAttribute('style', 'color: white');
})


btnAlertaEnergetico.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionIncidenciaEnergetico')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionIncidenciaEnergetico');
      }
   }
   btnAlertaEnergetico.classList.add('opcionIncidenciaEnergetico', 'bg-blue-600');
   btnAlertaEnergetico.setAttribute('style', 'color: white');
})


btnSeguimientoEnergetico.addEventListener('click', () => {
   estiloDefaultBotonesIncidencias();
   for (let x = 0; x < btnOpcionIncidencia.length; x++) {
      if (btnOpcionIncidencia[x].classList.contains('opcionIncidenciaEnergetico')) {
         btnOpcionIncidencia[x].classList.remove('bg-red-600', 'bg-orange-600', 'bg-yellow-600', 'bg-blue-600', 'bg-teal-600', 'opcionIncidenciaEnergetico');
      }
   }
   btnSeguimientoEnergetico.classList.add('opcionIncidenciaEnergetico', 'bg-teal-600');
   btnSeguimientoEnergetico.setAttribute('style', 'color: white');
})


// BUSCADOR PARA TABLA DE ENERGETICOS
palabraEnergeticos.addEventListener('keyup', () => {
   buscadorTabla('dataEnergeticos', 'palabraEnergeticos', 0);
})


// LIMPIA EL CONTENEDOR DE EQUIPOS EN MODALEQUIPO
btnCerrarModalEquiposAmerica.addEventListener('click', () => {
   dataEquiposAmerica
})


btnGraficasReportesDiario.addEventListener('click', () => {

   alertify.Gift || alertify.dialog('Gift', function () {
      var iframe;
      return {
         // dialog constructor function, this will be called when the user calls alertify.Gift(videoId)
         main: function (videoId) {
            //set the videoId setting and return current instance for chaining.
            return this.set({
               'videoId': videoId
            });
         },
         // we only want to override two options (padding and overflow).
         setup: function () {
            return {
               options: {
                  //disable both padding and overflow control.
                  padding: !1,
                  overflow: !1,
               }
            };
         },
         // This will be called once the DOM is ready and will never be invoked again.
         // Here we create the iframe to embed the video.
         build: function () {
            // create the iframe element
            iframe = document.createElement('iframe');
            iframe.frameBorder = "no";
            iframe.width = "100%";
            iframe.height = "100%";
            // add it to the dialog
            this.elements.content.appendChild(iframe);

            //give the dialog initial height (half the screen height).
            this.elements.body.style.minHeight = screen.height * .5 + 'px';
         },
         // dialog custom settings
         settings: {
            videoId: undefined
         },
         // listen and respond to changes in dialog settings.
         settingUpdated: function (key, oldValue, newValue) {
            switch (key) {
               case 'videoId':
                  iframe.src = `graficas_reportes_diario/`;
                  break;
            }
         },
         hooks: {
            // triggered when the dialog is closed, this is seperate from user defined onclose
            onclose: function () {
               iframe.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
            },
            // triggered when a dialog option gets update.
            // warning! this will not be triggered for settings updates.
            onupdate: function (option, oldValue, newValue) {
               switch (option) {
                  case 'resizable':
                     if (newValue) {
                        this.elements.content.removeAttribute('style');
                        iframe && iframe.removeAttribute('style');
                     } else {
                        this.elements.content.style.minHeight = 'inherit';
                        iframe && (iframe.style.minHeight = 'inherit');
                     }
                     break;
               }
            }
         }
      };
   });
   //show the dialog
   alertify.Gift('GODhPuM5cEE').set({ frameless: true });
})


const exportarTareasAIncidencias = (idDestino) => {
   let idUsuario = localStorage.getItem('usuario');

   fetch(`php/select_REST_planner.php?action=exportarTareasAIncidencias&idDestino=${idDestino}&idUsuario=${idUsuario}`)
      .then(array => array.json())
      .then(array => {
         console.log(array)
      })
      .catch(function (err) {
         fetch(APIERROR + err);
      })
}


//EVENTO PARA INICIAR BUSCADOR DE OT
btnBuscarOT.addEventListener('click', () => {
   abrirmodal('modalBuscarOT');
   alertaImg('Digíte el Número OT y Presione ENTER', '', 'info', 2000);
   inputNumeroOT.value = '';
   dataBuscarOT.innerHTML = '';
})


// EVENTO PARA BUSCAR OT
inputNumeroOT.addEventListener('keyup', event => {

   if (event.keyCode === 13 && inputNumeroOT.value.length >= 2) {

      const idOT = inputNumeroOT.value.replace(/[A-Za-z#&]/gi, '');

      const action = 'buscarOT';
      const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idOT=${idOT}`;

      btnBuscarNumeroOT.innerHTML = iconoLoader;

      fetch(URL)
         .then(array => array.json())
         .then(array => {
            dataBuscarOT.innerHTML = '';
            return array;
         })
         .then(array => {

            // INCIDENCIA DE EQUIPOS
            if (array.incidencias) {
               for (let x = 0; x < array.incidencias.length; x++) {
                  const idOT = array.incidencias[x].idOT;
                  const tipo = array.incidencias[x].tipo;
                  const status = array.incidencias[x].status;
                  const idEquipo = array.incidencias[x].idEquipo;
                  const idSeccion = array.incidencias[x].idSeccion;
                  const idSubseccion = array.incidencias[x].idSubseccion;

                  const fVerOT = `onclick="redireccionarOTVerEnPlanner('INCIDENCIA', ${idOT})"`;
                  const fEdit = `onclick="obtenerIncidenciaEquipos(${idOT}); toggleModalTailwind('modalVerEnPlannerIncidencia');"`;
                  const fView = `onclick="actualizarSeccionSubseccion(${idSeccion}, ${idSubseccion}); obtenerFallas(${idEquipo}); toggleModalTailwind('modalTareasFallas');"`;

                  const estiloStatus = status == "PENDIENTE" ?
                     `<h1 class="bg-yellow-200 text-yellow-500 px-2 rounded-full">En proceso</h1>`
                     : `<h1 class="bg-green-200 text-green-500 px-2 rounded-full">Solucionada</h1>`;

                  const codigo = `
                    <div class="w-full bg-white rounded mt-2 flex overflow-hidden flex-none" style="height: 90px;">
                        <div class="w-full text-left px-2 flex flex-col">
                            <div class="font-bold text-3xl text-gray-700">
                                <h1>#${idOT}</h1>
                            </div>
                            <div class="font-bold text-gray-700 uppercase">
                                <h1>${tipo}</h1>
                            </div>
                            <div class="font-bold text-gray-700 flex">
                                ${estiloStatus}
                            </div>
                        </div>
                        
                        <div class="w-1/6 bg-blue-200 flex flex-col items-center text-center justify-center text-blue-500 cursor-pointer hover:bg-blue-100" ${fEdit}>
                            <i class="fas fa-edit text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">Edit</h1>
                        </div>
                      
                        <div class="w-1/6 bg-green-200 flex flex-col items-center text-center justify-center text-green-500 cursor-pointer hover:bg-green-100" ${fVerOT}>
                            <i class="fas fa-print text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">PDF</h1>
                        </div>
                       
                        <div class="w-1/6 bg-orange-200 flex flex-col items-center text-center justify-center text-orange-500 cursor-pointer hover:bg-orange-100" ${fView}>
                            <i class="fas fa-eye text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">EQUIPO</h1>
                        </div>

                    </div>
                  `;
                  dataBuscarOT.insertAdjacentHTML('beforeend', codigo);
               }
            }

            // INCIDENCIAS GENERALES
            if (array.incidenciaGeneral) {
               for (let x = 0; x < array.incidenciaGeneral.length; x++) {
                  const idOT = array.incidenciaGeneral[x].idOT;
                  const tipo = array.incidenciaGeneral[x].tipo;
                  const status = array.incidenciaGeneral[x].status;
                  const idSeccion = array.incidenciaGeneral[x].idSeccion;
                  const idSubseccion = array.incidenciaGeneral[x].idSubseccion;

                  const fVerOT = `onclick="redireccionarOTVerEnPlanner('INCIDENCIAGENERAL', ${idOT})"`;
                  const fEdit = `onclick="obtenerIncidenciaGeneral(${idOT}); toggleModalTailwind('modalVerEnPlannerIncidencia');"`;
                  const fView = `onclick="actualizarSeccionSubseccion(${idSeccion}, ${idSubseccion}); obtenerTareas(0); toggleModalTailwind('modalTareasFallas');"`;

                  const estiloStatus = status == "PENDIENTE" ?
                     `<h1 class="bg-yellow-200 text-yellow-500 px-2 rounded-full">En proceso</h1>`
                     : `<h1 class="bg-green-200 text-green-500 px-2 rounded-full">Solucionada</h1>`;

                  const codigo = `
                    <div class="w-full bg-white rounded mt-2 flex overflow-hidden flex-none" style="height: 90px;">
                        <div class="w-full text-left px-2 flex flex-col">
                            <div class="font-bold text-3xl text-gray-700">
                                <h1>#${idOT}</h1>
                            </div>
                            <div class="font-bold text-gray-700 uppercase">
                                <h1>${tipo}</h1>
                            </div>
                            <div class="font-bold text-gray-700 flex">
                                ${estiloStatus}
                            </div>
                        </div>
                        <div class="w-1/6 bg-blue-200 flex flex-col items-center text-center justify-center text-blue-500 cursor-pointer hover:bg-blue-100" ${fEdit}>
                            <i class="fas fa-edit text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">Edit</h1>
                        </div>
                        <div class="w-1/6 bg-green-200 flex flex-col items-center text-center justify-center text-green-500 cursor-pointer hover:bg-green-100" ${fVerOT}>
                            <i class="fas fa-print text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">PDF</h1>
                        </div>
                        <div class="w-1/6 bg-orange-200 flex flex-col items-center text-center justify-center text-orange-500 cursor-pointer hover:bg-orange-100" ${fView}>
                            <i class="fas fa-eye text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">GENERAL</h1>
                        </div>
                    </div>
                  `;
                  dataBuscarOT.insertAdjacentHTML('beforeend', codigo);
               }
            }

            // PDA DE PROYECTOS
            if (array.proyectos) {
               for (let x = 0; x < array.proyectos.length; x++) {
                  const idOT = array.proyectos[x].idOT;
                  const tipo = array.proyectos[x].tipo;
                  const status = array.proyectos[x].status;
                  const idSeccion = array.proyectos[x].idSeccion;
                  const idSubseccion = array.proyectos[x].idSubseccion;

                  const fVerOT = `onclick="redireccionarOTVerEnPlanner('PDA', ${idOT})"`;
                  const fEdit = `onclick="verEnPlannerPlanaccion(${idOT}); toggleModalTailwind('modalVerEnPlannerPlanaccion');"`;
                  const fView = `onclick="actualizarSeccionSubseccion(${idSeccion}, ${idSubseccion});  toggleModalTailwind('modalProyectos'); obtenerProyectos(${idSeccion}, 'PENDIENTE');"`;

                  const estiloStatus = status == "PENDIENTE" ?
                     `<h1 class="bg-yellow-200 text-yellow-500 px-2 rounded-full">En proceso</h1>`
                     : `<h1 class="bg-green-200 text-green-500 px-2 rounded-full">Solucionada</h1>`;

                  const codigo = `
                    <div class="w-full bg-white rounded mt-2 flex overflow-hidden flex-none" style="height: 90px;">
                        <div class="w-full text-left px-2 flex flex-col">
                            <div class="font-bold text-3xl text-gray-700">
                                <h1>#P${idOT}</h1>
                            </div>
                            <div class="font-bold text-gray-700 uppercase">
                                <h1>${tipo}</h1>
                            </div>
                            <div class="font-bold text-gray-700 flex">
                                ${estiloStatus}
                            </div>
                        </div>
                        <div class="w-1/6 bg-blue-200 flex flex-col items-center text-center justify-center text-blue-500 cursor-pointer hover:bg-blue-100" ${fEdit}>
                            <i class="fas fa-edit text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">Edit</h1>
                        </div>
                        <div class="w-1/6 bg-green-200 flex flex-col items-center text-center justify-center text-green-500 cursor-pointer hover:bg-green-100" ${fVerOT}>
                            <i class="fas fa-print text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">PDF</h1>
                        </div>
                        <div class="w-1/6 bg-orange-200 flex flex-col items-center text-center justify-center text-orange-500 cursor-pointer hover:bg-orange-100" ${fView}>
                            <i class="fas fa-eye text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">PROYE</h1>
                        </div>
                    </div>
                  `;
                  dataBuscarOT.insertAdjacentHTML('beforeend', codigo);
               }
            }

            // PREVENTIVOS DE EQUIPOS
            if (array.preventivos) {
               for (let x = 0; x < array.preventivos.length; x++) {
                  const idOT = array.preventivos[x].idOT;
                  const tipo = array.preventivos[x].tipo;
                  const status = array.preventivos[x].status;
                  const semana = array.preventivos[x].semana;
                  const idEquipo = array.preventivos[x].idEquipo;
                  const idPlan = array.preventivos[x].idPlan;

                  const fVerOT = `onclick="VerOTMPSolucionado(${idEquipo}, ${semana}, ${idPlan})"`;
                  const fEdit = `onclick="obtenerOTDigital(${idEquipo}, ${semana}, ${idPlan})"`;
                  const fView = `onclick="informacionEquipo(${idEquipo});  abrirmodal('modalMPEquipo');"`;

                  const estiloStatus = status == "PENDIENTE" ?
                     `<h1 class="bg-yellow-200 text-yellow-500 px-2 rounded-full">En proceso</h1>`
                     : `<h1 class="bg-green-200 text-green-500 px-2 rounded-full">Solucionada</h1>`;

                  const codigo = `
                    <div class="w-full bg-white rounded mt-2 flex overflow-hidden flex-none" style="height: 90px;">
                        <div class="w-full text-left px-2 flex flex-col">
                            <div class="font-bold text-3xl text-gray-700">
                                <h1>#${idOT}</h1>
                            </div>
                            <div class="font-bold text-gray-700 uppercase">
                                <h1>${tipo}</h1>
                            </div>
                            <div class="font-bold text-gray-700 flex">
                                ${estiloStatus}
                            </div>
                        </div>
                        <div class="w-1/6 bg-blue-200 flex flex-col items-center text-center justify-center text-blue-500 cursor-pointer hover:bg-blue-100" ${fEdit}>
                            <i class="fas fa-edit text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">Edit</h1>
                        </div>
                        <div class="w-1/6 bg-green-200 flex flex-col items-center text-center justify-center text-green-500 cursor-pointer hover:bg-green-100" ${fVerOT}>
                            <i class="fas fa-print text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">PDF</h1>
                        </div>
                        <div class="w-1/6 bg-orange-200 flex flex-col items-center text-center justify-center text-orange-500 cursor-pointer hover:bg-orange-100" ${fView}>
                            <i class="fas fa-eye text-2xl"></i>
                            <h1 class="font-bold text-xxs uppercase">GENERAL</h1>
                        </div>
                    </div>
                  `;
                  dataBuscarOT.insertAdjacentHTML('beforeend', codigo);
               }
            }

         })
         .then(() => {
            btnBuscarNumeroOT.innerText = 'Buscar';
         })
         .catch(err => {
            fetch(APIERROR + err + ' BUSCADOR OT');
            dataBuscarOT.innerHTML = '';
            btnBuscarNumeroOT.innerText = 'Buscar';
         })

      alertaImg('Buscando OT #' + idOT, '', 'info', 1500);

   } else if (inputNumeroOT.value.length < 2) {
      alertaImg('Ingrese más Datos', '', 'info', 1500);
   }
})



// OPCIONES INICIALES PARA AGREGAR INCIDENCIAS ENTREGAS
btnModalAgregarIncidenciasEntrega.addEventListener('click', async () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   abrirmodal('modalAgregarIncidenciasEntrega');
   btnTGEntregas.setAttribute('onclick', "obtenerEquiposEntregas('TG'); tipoAsignacionEntregas('TG')");
   btnEquipoEntregas.setAttribute('onclick', "obtenerEquiposEntregas('EQUIPO'); tipoAsignacionEntregas('EQUIPO')");
   btnLocalEntregas.setAttribute('onclick', "obtenerEquiposEntregas('LOCAL'); tipoAsignacionEntregas('LOCAL')");
   btnCrearEntregas.setAttribute('onclick', "crearEntregas()");
   tipoAsignacionEntregas('');

   btnEmergenciaEntregas.setAttribute('onclick', "tipoIncidenciaEntregas('EMERGENCIA')");
   btnUrgenciaEntregas.setAttribute('onclick', "tipoIncidenciaEntregas('URGENCIA')");
   btnAlarmaEntregas.setAttribute('onclick', "tipoIncidenciaEntregas('ALARMA')");
   btnAlertaEntregas.setAttribute('onclick', "tipoIncidenciaEntregas('ALERTA')");
   btnSeguimientoEntregas.setAttribute('onclick', "tipoIncidenciaEntregas('SEGUIMIENTO')");
   tipoIncidenciaEntregas('');

   cantidadAdjuntosEntregas.innerHTML = '';
   descripcionEntregas.value = '';
   comentarioEntregas.value = '';
   inputAdjuntosEntregas.value = '';

   // SECCIONES
   const action = "obtenerSeccionesPorDestino";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         seccionEntregas.innerHTML = '<option value="0">Seleccione</option>';
         seccionEntregas.setAttribute('onchange', 'obtenerSubseccionesEntregas()');
         return array;
      })
      .then(array => {
         if (array.length) {
            for (let x = 0; x < array.length; x++) {
               const idSeccion = array[x].idSeccion;
               const seccion = array[x].seccion;
               const codigo = `<option value="${idSeccion}">${seccion}</option>`;
               seccionEntregas.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         equipoLocalEntregas.innerHTML = '<option value="">Seleccione</option>';
         seccionEntregas.innerHTML = '';
         fetch(APIERROR + err);
      })


   // RESPONSABLES
   const action2 = "obtenerUsuarios";
   const URL2 = `php/select_REST_planner.php?action=${action2}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

   fetch(URL2)
      .then(array => array.json())
      .then(array => {
         responsablesEntregas.innerHTML = '<option value="0">Seleccione Responsable</option>';
         return array;
      })
      .then(array => {
         if (array.length) {
            for (let x = 0; x < array.length; x++) {
               const idUsuarioX = array[x].idUsuario;
               const nombre = array[x].nombre;
               const apellido = array[x].apellido;
               const codigo = `<option value="${idUsuarioX}">${nombre + ' ' + apellido}</option>`;
               responsablesEntregas.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         responsablesEntregas.innerHTML = '';
         fetch(APIERROR + err);
      })


   // RESPONSABLES EJECUCION
   const action3 = "empresasResponsabes";
   const URL3 = `php/select_REST_planner.php?action=${action3}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

   fetch(URL3)
      .then(array => array.json())
      .then(array => {
         responsablesEjecucionEntregas.innerHTML = '<option value="0">Seleccione Empresa</option>';
         return array;
      })
      .then(array => {
         if (array.length) {
            for (let x = 0; x < array.length; x++) {
               const idEmpresa = array[x].idEmpresa;
               const empresa = array[x].empresa;
               const codigo = `<option value="${idEmpresa}">${empresa}</option>`;
               responsablesEjecucionEntregas.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         responsablesEjecucionEntregas.innerHTML = '';
         fetch(APIERROR + err);
      })
})


// OBTIENE SUBSECCIONES SEGÚN DESTINO Y SECCIÓN
const obtenerSubseccionesEntregas = () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "obtenerSubseccionPorSeccion";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${seccionEntregas.value}`;

   tipoAsignacionEntregas('');

   if (seccionEntregas.value > 0) {
      fetch(URL)
         .then(array => array.json())
         .then(array => {
            subseccionEntregas.innerHTML = '';
            return array;
         })
         .then(array => {
            if (array.length) {
               for (let x = 0; x < array.length; x++) {
                  const idSubseccion = array[x].idSubseccion;
                  const subseccion = array[x].subseccion;
                  const codigo = `<option value="${idSubseccion}">${subseccion}</option>`;
                  subseccionEntregas.insertAdjacentHTML('beforeend', codigo);
               }
            }
         })
         .catch(function (err) {
            subseccionEntregas.innerHTML = '';
            fetch(APIERROR + err);
         })
   } else {
      subseccionEntregas.innerHTML = '';
      alertaImg('Intente de Nuevo', '', 'info', 1500);
   }
}


// INICIALIZA EL SELECT PARA OPCION DE EQUIPOS Y LOCALES
subseccionEntregas.addEventListener('change', () => {
   tipoAsignacionEntregas('');
})


// OBTIENE EQUIPOS Y LOCALES
const obtenerEquiposEntregas = tipo => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "obtenerEquipoLocal";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&tipo=${tipo}&idSeccion=${seccionEntregas.value}&idSubseccion=${subseccionEntregas.value}`;

   if (tipo == "TG") {
      equipoLocalEntregas.innerHTML = '<option value="0">INCIDENCIA GENERAL</option>';
      return
   }

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         equipoLocalEntregas.innerHTML = '<option value="">Seleccione</option>';
         return array;
      })
      .then(array => {
         if (array.length) {
            for (let x = 0; x < array.length; x++) {
               const idEquipo = array[x].idEquipo;
               const equipo = array[x].equipo;
               const codigo = `<option value="${idEquipo}">${equipo}</option>`;
               equipoLocalEntregas.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         equipoLocalEntregas.innerHTML = '<option value="">Seleccione</option>';
         fetch(APIERROR + err);
      })
}


// ADJUNTOS PARA ENTREGAS
inputAdjuntosEntregas.addEventListener('change', () => {
   cantidadAdjuntosEntregas.innerHTML = inputAdjuntosEntregas.files.length;
})


// DISEÑO DE BOTONES INCIDENCIAS ENTREGAS PROYECTO(TG, EQUIPO, LOCAL)
const tipoAsignacionEntregas = tipo => {
   btnTGEntregas.classList.remove('bg-blue-600', 'text-white');
   btnEquipoEntregas.classList.remove('bg-blue-600', 'text-white');
   btnLocalEntregas.classList.remove('bg-blue-600', 'text-white');
   btnTGEntregas.classList.add('text-blue-500');
   btnEquipoEntregas.classList.add('text-blue-500');
   btnLocalEntregas.classList.add('text-blue-500');
   contenedorEquipoLocalEntregas.classList.add('hidden');
   equipoLocalEntregas.value = '';

   if (tipo == "TG") {
      btnTGEntregas.classList.add('bg-blue-600', 'text-white');
      btnTGEntregas.classList.remove('text-blue-500');
      contenedorEquipoLocalEntregas.classList.remove('hidden');
      return
   }

   if (tipo == "EQUIPO") {
      btnEquipoEntregas.classList.add('bg-blue-600', 'text-white');
      btnEquipoEntregas.classList.remove('text-blue-500');
      contenedorEquipoLocalEntregas.classList.remove('hidden');
      return
   }

   if (tipo == "LOCAL") {
      btnLocalEntregas.classList.add('bg-blue-600', 'text-white');
      btnLocalEntregas.classList.remove('text-blue-500');
      contenedorEquipoLocalEntregas.classList.remove('hidden');
      return
   }
}


// DISEÑO DE BOTONES TIPO INCIDENCIAS ENTREGAS PROYECTO(EMERGENCIA, URGENCIA, ALARMA, ALERTA, SEGUIMIENTO)
const tipoIncidenciaEntregas = tipo => {
   btnEmergenciaEntregas.classList.remove('bg-red-600', 'text-white', 'tipo-entregas-select');
   btnUrgenciaEntregas.classList.remove('bg-orange-600', 'text-white', 'tipo-entregas-select');
   btnAlarmaEntregas.classList.remove('bg-yellow-600', 'text-white', 'tipo-entregas-select');
   btnAlertaEntregas.classList.remove('bg-blue-600', 'text-white', 'tipo-entregas-select');
   btnSeguimientoEntregas.classList.remove('bg-teal-600', 'text-white', 'tipo-entregas-select');

   if (tipo == "EMERGENCIA") {
      btnEmergenciaEntregas.classList.add('tipo-entregas-select', 'bg-red-600', 'text-white');
      btnEmergenciaEntregas.classList.remove('text-red-500');
      return
   }

   if (tipo == "URGENCIA") {
      btnUrgenciaEntregas.classList.add('tipo-entregas-select', 'bg-orange-600', 'text-white');
      btnUrgenciaEntregas.classList.remove('text-orange-500');
      return
   }

   if (tipo == "ALARMA") {
      btnAlarmaEntregas.classList.add('tipo-entregas-select', 'bg-yellow-600', 'text-white');
      btnAlarmaEntregas.classList.remove('text-yellow-500');
      return
   }

   if (tipo == "ALERTA") {
      btnAlertaEntregas.classList.add('tipo-entregas-select', 'bg-blue-600', 'text-white');
      btnAlertaEntregas.classList.remove('text-blue-500');
      return
   }

   if (tipo == "SEGUIMIENTO") {
      btnSeguimientoEntregas.classList.add('tipo-entregas-select', 'bg-teal-600', 'text-white');
      btnSeguimientoEntregas.classList.remove('text-teal-500');
      return
   }
}


// CREA LA INCIDENCIA DE ENTREGAS
const crearEntregas = () => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const tipoIncidencia = btnEmergenciaEntregas.classList.contains('tipo-entregas-select') ? 'EMERGENCIA' :
      btnUrgenciaEntregas.classList.contains('tipo-entregas-select') ? 'URGENCIA' :
         btnAlarmaEntregas.classList.contains('tipo-entregas-select') ? 'ALARMA' :
            btnAlertaEntregas.classList.contains('tipo-entregas-select') ? 'ALERTA' :
               btnSeguimientoEntregas.classList.contains('tipo-entregas-select') ? 'SEGUIMIENTO' :
                  '';


   const data = new FormData();
   data.append('idSeccion', seccionEntregas.value);
   data.append('idSubseccion', subseccionEntregas.value);
   data.append('idEquipo', equipoLocalEntregas.value);
   data.append('descripcion', descripcionEntregas.value);
   data.append('comentario', comentarioEntregas.value);
   data.append('tipoIncidencia', tipoIncidencia);
   data.append('idResponsable', responsablesEntregas.value);
   data.append('idResponsableEjecucion', responsablesEjecucionEntregas.value);

   const action = "crearEntregas";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

   if (seccionEntregas.value > 0 &&
      subseccionEntregas.value > 0 &&
      equipoLocalEntregas.value != "" &&
      responsablesEntregas.value > 0 &&
      tipoIncidencia != "" &&
      descripcionEntregas.value.length > 0
   ) {

      fetch(URL, {
         method: 'POST',
         body: data
      })
         .then(array => array.json())
         .then(array => {
            if (array.resp == 1) {
               alertaImg(`Incidencia Entregas de Proyecto, Agregada`, '', 'success', 1500);
               cerrarmodal('modalAgregarIncidenciasEntrega');
               if (inputAdjuntosEntregas.files.length && array.idIncidencia) {
                  agregarAdjuntosEntregas(array.idIncidencia, array.tipoIncidencia);
               }
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
}


// AGREGA LOS ADJUNTOS DE INCIDENCIAS DE LAS ENTREGAS DE PROYECTO
const agregarAdjuntosEntregas = (idIncidencia, tipoIncidencia) => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   const action = "agregarAdjuntosEntregas";
   const URL = `php/adjuntos.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&tipoIncidencia=${tipoIncidencia}`;

   // VARIABLES DEL ADJUNTO
   const formData = new FormData()

   if (inputAdjuntosEntregas.files) {
      for (let x = 0; x < inputAdjuntosEntregas.files.length; x++) {
         formData.append('file', inputAdjuntosEntregas.files[x]);

         fetch(URL, {
            method: "POST",
            body: formData
         })
            .then(array => array.json())
            .then(array => {
               if (array == 1) {
                  alertaImg('Adjunto Agregado', '', 'success', 1500);
               } else {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
               }
            })
            .then(() => {
               inputAdjuntosEntregas.value = '';
            })
            .catch(function (err) {
               fetch(APIERROR + err + ` agregarAdjuntosEntregas(${idIncidencia}, ${tipoIncidencia})`)
               alertaImg('Intente de Nuevo', '', 'info', 1500);
               inputAdjuntosEntregas.value = '';
            })
      }
   }
}


// OBTIENE LOS MATERIALES DE LAS INCIDENCIAS
const obtenerMaterialesIncidencias = (idIncidencia, tipoIncidencia) => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   abrirmodal('modalOpcionesMaterialesEquipo');

   const action = "obtenerMaterialesIncidencias";
   const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idIncidencia=${idIncidencia}&tipoIncidencia=${tipoIncidencia}`;

   fetch(URL)
      .then(array => array.json())
      .then(array => {
         dataOpcionesMaterialesEquipo.innerHTML = '';
         return array;
      })
      .then(array => {
         if (array.length) {
            for (let x = 0; x < array.length; x++) {
               const idItem = array[x].idItem;
               const cod2bend = array[x].cod2bend;
               const descripcion = array[x].descripcion;
               const sstt = array[x].sstt;
               const caracteristicas = array[x].caracteristicas;
               const marca = array[x].marca;
               const modelo = array[x].modelo;
               const cantidad = array[x].cantidad;

               const codigo = `
                  <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
                    
                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1" data-title-material="${cod2bend}">
                           <h1 class="truncate w-16">${cod2bend}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${descripcion}">
                           <h1 class="truncate w-40">${descripcion}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${sstt}">
                           <h1 class="truncate w-40">${sstt}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${caracteristicas}">
                           <h1 class="truncate w-32">${caracteristicas}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${marca}">
                           <h1 class="truncate w-24">${marca}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-auto" data-title-material="${modelo}">
                           <h1 class="truncate w-24">${modelo}</h1>
                     </td>

                     <td class="border-b border-gray-200 uppercase text-center px-2 py-1 w-12">
                        <div class="w-12">
                           <input id="item_material_incidencia_${idItem}" class="border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 w-12 rounded-md text-sm focus:outline-none" type="text" placeholder="Cantidad" min="0" value="${cantidad}" autocomplete="off" onchange="asignarMaterialIncidencia(${idItem}, ${idIncidencia}, '${tipoIncidencia}')">
                        </div>
                     </td>
                  </tr>               
               `;
               dataOpcionesMaterialesEquipo.insertAdjacentHTML('beforeend', codigo);
            }
         }
      })
      .catch(function (err) {
         dataOpcionesMaterialesEquipo.innerHTML = '';
         fetch(APIERROR + err);
      })
}

// ASIGNA CANTIDADES A UNA INCIDENCIA
const asignarMaterialIncidencia = (idItem, idIncidencia, tipoIncidencia) => {
   let idDestino = localStorage.getItem('idDestino');
   let idUsuario = localStorage.getItem('usuario');

   if (cantidad = document.querySelector("#item_material_incidencia_" + idItem)) {
      if (cantidad.value >= 0) {
         const action = "asignarMaterialIncidencia";
         const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idItem=${idItem}&idIncidencia=${idIncidencia}&tipoIncidencia=${tipoIncidencia}&cantidad=${cantidad.value}`;

         fetch(URL)
            .then(array => array.json())
            .then(array => {
               // CANTIDAD AGREGADA
               if (array == 1) {
                  alertaImg('Material Agregado', '', 'success', 1500);
                  return
               }

               // CANTIDAD ACTUALIZADA
               if (array == 2) {
                  alertaImg('Material Agregado', '', 'success', 1500);
                  return
               }

               // RESPUESTA INESPERADA
               if (array == 0) {
                  alertaImg('Intente de Nuevo', '', 'info', 1500);
                  return
               }
            })
            .catch(function (err) {
               fetch(APIERROR + err);
            })
      } else {
         alertaImg('Cantidad No Valida', '', 'info', 1500);
      }
   } else {
      alertaImg('Cantidad No Valida', '', 'info', 1500);
   }
}