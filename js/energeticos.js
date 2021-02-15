// CONTENEDORES DATA 
const dataEnergeticos = document.getElementById("dataEnergeticos");
const dataPowerbin = document.getElementById("dataPowerbin");
const destinosSelecciona = document.getElementById("destinosSelecciona");
const contenedorEnergeticos = document.getElementById("contenedorEnergeticos");
const dataUsuarios = document.getElementById("dataUsuarios");

// BTN
const btnPendientesEnergeticos = document.getElementById("btnPendientesEnergeticos");
const btnModalAgregarEnergeticos = document.getElementById("btnModalAgregarEnergeticos");
const btnEmergenciaEnergetico = document.getElementById("btnEmergenciaEnergetico");
const btnUrgenciaEnergetico = document.getElementById("btnUrgenciaEnergetico");
const btnAlarmaEnergetico = document.getElementById("btnAlarmaEnergetico");
const btnAlertaEnergetico = document.getElementById("btnAlertaEnergetico");
const btnSeguimientoEnergetico = document.getElementById("btnSeguimientoEnergetico");
const rangoFechaEnergeticos = document.getElementById("rangoFechaEnergeticos");
const btnOpcionIncidencia = document.getElementsByClassName("btnOpcionIncidencia");

// INPTUS
const inputRangoFecha = document.getElementById("rangoFechaX");
const palabraEnergeticos = document.getElementById("palabraEnergeticos");

// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

// ICONOS 
const iconoLoader = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
const iconoDefault = '<i class="fad fa-minus text-xl text-red-400"></i>';

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
const btnStatusEP = document.getElementById("statusEP");
const btnStatusActivo = document.getElementById("statusActivo");
const btnEditarTitulo = document.getElementById("btnEditarTitulo");
const btnStatusGP = document.getElementById("statusGP");
const btnStatusTRS = document.getElementById("statusTRS");
const btnStatusZI = document.getElementById("statusZI");
const editarTitulo = document.getElementById("editarTitulo");
// BOTONES PARA EL MODAL STATUS

// TOGGLE HIDDEN
const toggleHidden = idElement => {
    if (idElement = document.getElementById(idElement)) {
        idElement.classList.toggle("hidden");
    }
}


// toggleClass Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
    if (document.getElementById(idModal)) {
        document.getElementById(idModal).classList.toggle("open");
    }
}


// Oculta Vista con la clase HIDDEN
function hiddenVista(idVista) {
    if (document.getElementById(idVista)) {
        document.getElementById(idVista).classList.add('hidden')
    }
}


// INICIA
window.onload = () => {
    obtenerEnlaces();
    obtenerSecciones(1001, 2);
};


destinosSelecciona.addEventListener("click", () => {
    obtenerEnlaces();
    obtenerSecciones(1001, 2);
})


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


// OBTIENE ENLACES SEGÚN DESTINO
const obtenerEnlaces = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerEnlaces";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&tipoEnlace=ENERGETICO`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataPowerbin.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                if (array.length > 1) {
                    dataPowerbin.classList.remove('grid-rows-1', 'grid-cols-1');
                    dataPowerbin.classList.add('grid-rows-3', 'grid-cols-3');
                } else {
                    dataPowerbin.classList.remove('grid-rows-3', 'grid-cols-3');
                    dataPowerbin.classList.add('grid-rows-1', 'grid-cols-1');
                }

                for (let x = 0; x < array.length; x++) {
                    const idDestinoX = array[x].idDestino;
                    const url = array[x].url;

                    const sizeW = array.length > 1 ? '400px;' : '800px;';
                    const sizeH = array.length > 1 ? '350px;' : '700px;';
                    const iconSize = array.length > 1 ?
                        `<i class="fas fa-arrows-alt absolute top-0 right-0 fa-lg py-2 cursor-pointer" onclick="url('url_${idDestinoX}');"></i>` : '';

                    const codigo = `
                    <div class="py-1 mx-auto relative text-transparent hover:text-gray-500">
                    ${iconSize}
                    <iframe id="url_${idDestinoX}" class="iframe" width="${sizeW}" height="${sizeH}" src="${url}" frameborder="0" allowFullScreen="true"></iframe>
                    </div>            
                    `;
                    dataPowerbin.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            dataPowerbin.innerHTML = '';
            // fetch(APIERROR + err);
            console.log(err);
        })
}


// OBTIENE ENLACE PARA RENDERIZAR EN VENTANA MODAL
function url(idUrl) {
    alertify.powerbi || alertify.dialog('powerbi', function () {
        var iframe;
        return {
            // dialog constructor function, this will be called when the user calls alertify.powerbi(videoId)
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
                        iframe.src = newValue;
                        break;
                }
            },
            // listen to internal dialog events.
            hooks: {
                // triggered when the dialog is closed, this is seperate from user defined onclose
                onclose: function () {
                    iframe.contentWindow.postMessage(
                        '{"event":"command","func":"pauseVideo","args":""}', '*');
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

    let x = document.getElementById(idUrl).getAttribute('src');
    //show the dialog
    alertify.powerbi(x).set({
        frameless: false
    });
}


// OBTIENE LAS SECCIONES SEGÚN EL DESTINO
const obtenerSecciones = (idSeccion) => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSecciones";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array) {
                // ORDENA LAS SUBSECCIONES POR PENDIENTES
                array.subsecciones.sort(function (a, b) {
                    return b.total - a.total;
                });

                // LIMPIA CONTENEDOR
                contenedorEnergeticos.innerHTML = '';

                // RETORNA RESULTADOS
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
                     <h1 class="truncate mr-2">${subseccion}</h1>
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
                    if (contenedorEnergeticos) {
                        contenedorEnergeticos.insertAdjacentHTML('beforeend', codigo);
                    }
                }
            }
        })
        .catch(function (err) {
            // fetch(APIERROR + err + ` obtenerSecciones = (${idSeccion})`);
        })
}


// Funciones para actualizar idSeccion y idSubseccion en localstorage..
function actualizarSeccionSubseccion(idSeccion, idSubseccion) {
    localStorage.setItem("idSeccion", idSeccion);
    localStorage.setItem("idSubseccion", idSubseccion);
}


// RANGO FECHA
function obtenerRangoFecha(idEnergetico, columna, valor) {
    btnAplicarRangoFecha.
        setAttribute('onclick', `actualizarEnergetico(${idEnergetico}, '${columna}', 0)`);
    inputRangoFecha.value = valor;
}


// FUNCION PARA OBTENER LOS PENDIENTES DE ENERGETICOS
function obtenerEnergeticos(idSeccion, idSubseccion, status) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

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
            dataEnergeticos.innerHTML = '';
            console.log(array);
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idEnergetico = array[x].idEnergetico;
                    const actividad = array[x].actividad;
                    const creadoPor = array[x].creadoPor;
                    const responsable = array[x].responsable;
                    const fechaInicio = array[x].fechaInicio;
                    const fechaFin = array[x].fechaFin;
                    const status = array[x].status;
                    const sTrabajare = array[x].sTrabajare;
                    const sUrgente = array[x].sUrgente;
                    const sDepartamentos = array[x].sDepartamentos;
                    const sEnergeticos = array[x].sEnergeticos;
                    const materiales = array[x].materiales;
                    const adjuntos = array[x].adjuntos
                    const comentarios = array[x].comentarios;

                    if (materiales >= 1) {
                        materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
                    } else {
                        materialesx = '';
                    }

                    if (sDepartamentos >= 1) {
                        departamentosx = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
                    } else {
                        departamentosx = '';
                    }

                    if (sEnergeticos >= 1) {
                        energeticosx = '<div class="bg-yellow-300 w-5 h-5 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>E</h1></div>';
                    } else {
                        energeticosx = '';
                    }

                    if (sTrabajare >= 1) {
                        trabajandox = '<div class="bg-cyan-300 w-5 h-5 rounded-full flex justify-center items-center text-cyan-600 mr-1"><h1>T</h1></div>';
                    } else {
                        trabajandox = '';
                    }

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

                    // DISEÑO TIPO INCIDENCIA
                    const tipoIncidencia = array[x].tipoIncidencia;
                    const estiloTipoIncidencia =
                        tipoIncidencia == 'URGENCIA' ?
                            `<span class="text-red-500 text-xs">${tipoIncidencia}</span>`
                            : tipoIncidencia == "EMERGENCIA" ?
                                `<span class="text-orange-500 text-xs">${tipoIncidencia}</span>`
                                : tipoIncidencia == "ALARMA" ?
                                    `<span class="text-yellow-500 text-xs">${tipoIncidencia}</span>`
                                    : tipoIncidencia == "ALERTA" ?
                                        `<span class="text-blue-500 text-xs">${tipoIncidencia}</span>`
                                        : `<span class="text-teal-500 text-xs">${tipoIncidencia}</span>`;

                    const fResponsable = status == "PENDIENTE" ?
                        `onclick="obtenerResponsableEnergetico(${idEnergetico}); toggleModalTailwind('modalUsuarios')"` : '';

                    const fRangoFecha = status == "PENDIENTE" ?
                        `onclick="obtenerRangoFecha(${idEnergetico}, 'rangoFecha', '${fechaInicio} - ${fechaFin}'); toggleModalTailwind('modalRangoFechaX')"` : '';

                    const fAdjuntos = `onclick="obtenerAdjuntosEnergetico(${idEnergetico}); toggleModalTailwind('modalMedia')"`;

                    const fComentarios = `onclick="obtenerComentariosEnergetico(${idEnergetico}); toggleModalTailwind('modalComentarios')"`;

                    if (status == "PENDIENTE") {
                        fStatus = `onclick="obtenerStatusEnergetico(${idEnergetico}); toggleModalTailwind('modalStatus')"`;
                        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
                    } else {
                        fStatus = `onclick="actualizarEnergetico(${idEnergetico}, 'restaurar', 'F')"`;
                        iconoStatus = '<i class="fas fa-redo-alt fa-lg text-red-500"></i>';
                    }

                    const codigo = `
                        <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
                
                            <td class="px-4 border-b border-gray-200 py-3" style="max-width: 360px;">
                                <div class="font-semibold uppercase leading-4" data-title="${actividad}">
                                <h1 class="truncate w-48">${actividad} </h1>
                                </div>
                                <div class="text-gray-500 leading-3 flex">
                                <h1>Creado por: ${creadoPor}</h1>
                                </div>
                            </td>

                            <td class="whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3">
                                <h1>0</h1>
                            </td>

                            <td class="whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" data-title="${responsable}" ${fResponsable}>
                                <h1 class="truncate">${responsable}</h1>
                            </td>

                            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fRangoFecha}>
                                <div class="leading-4">${fechaInicio}</div>
                                <div class="leading-3">${fechaFin}</div>
                            </td>

                            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fAdjuntos}>
                                <h1>${adjuntosX}</h1>
                            </td>

                            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fComentarios}>
                                <h1>${comentariosX}</h1>
                            </td>

                            <td class="px-2 whitespace-no-wrap text-center py-3 flex flex-row justify-center" ${fStatus}>
                                ${materialesx}
                                ${departamentosx}
                                ${energeticosx}
                                ${trabajandox}
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3">
                                <a href="OT_Fallas_Tareas/#E${idEnergetico}" target="_blank" class="text-gray-600 cursor-pointer hover:text-gray-900 font-semibold">E${idEnergetico}</a>
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                                <div class="px-2">
                                ${iconoStatus}
                                </div>
                            </td>

                            <td class="px-2 whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3">
                                ${estiloTipoIncidencia}
                            </td>

                        </tr>
                    `;
                    dataEnergeticos.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            fetch(APIERROR + err + ``);
            dataEnergeticos.innerHTML = '';
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
                toggleModalTailwind('modalUsuarios');
            } else if (array == "titulo") {
                alertaImg('Título Actualizado', '', 'success', 1400);
                toggleModalTailwind('modalStatus');
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
                toggleModalTailwind('modalStatus');
            } else if (array == "eliminado") {
                alertaImg('Energético Eliminado', '', 'success', 1400);
                toggleModalTailwind('modalStatus');
            } else if (array == "restuarado") {
                alertaImg('Energético Restaurado', '', 'success', 1400);
                toggleModalTailwind('modalStatus');
            } else if (array == "material") {
                alertaImg('Status Material, Actualizado', '', 'success', 1400);
            } else if (array == "rangoFecha") {
                alertaImg('Rango Fecha, Actualizado', '', 'success', 1400);
                toggleModalTailwind('modalRangoFechaX');
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1400);
                toggleModalTailwind('modalStatus');
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


// MODAL PARA FORMULARIO DE ENERGETICOS
btnModalAgregarEnergeticos.addEventListener('click', () => {
    toggleModalTailwind('modalAgregarEnergeticos');
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
            fetch(APIERROR + err + ` btnModalAgregarEnergeticos`);
        })
})


// ESTILO PARA TIPO DE INCIDENCIA
function estiloDefaultBotonesIncidencias() {
    btnEmergenciaEnergetico.removeAttribute('style');
    btnUrgenciaEnergetico.removeAttribute('style');
    btnAlarmaEnergetico.removeAttribute('style');
    btnAlertaEnergetico.removeAttribute('style');
    btnSeguimientoEnergetico.removeAttribute('style');
}


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


// BTN PARA AGREGAR INCIDENCIA DE ENERGETICO
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
                    toggleModalTailwind('modalAgregarEnergeticos');
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
                    adjuntosPlanaccion(idTabla);
                } else if (data == 5) {
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                    // obtenerMediaEquipo(idTabla);
                    // obtenerEquiposAmerica(idSeccion, idSubseccion);
                    obtenerImagenesEquipo(idTabla);
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


// ********** PROYECTOS **********
'use strict'
// const $tablaProyectos = document.getElementById('contenedorDeProyectos');
const datosProyectos = params => {
    var cotizaciones = params.cotizaciones;
    var valorCotizaciones = '';

    var tipo = params.tipo;
    var valorTipo = '';

    var justificacion = params.justificacion;
    var valorjustificacion = '';

    var materiales = params.materiales;
    var materialesx = ''

    var departamento = params.departamento;
    var departamentox = ''

    var energeticos = params.energeticos;
    var energeticosx = ''

    var trabajando = params.trabajando;
    var trabajandox = ''

    var idProyecto = params.id;

    switch (cotizaciones) {
        case 0:
            valorCotizaciones = '<i class="fad fa-minus text-xl text-red-400"></i>';
            break;
        default:
            valorCotizaciones = params.cotizaciones;
    }

    switch (tipo) {
        case 'CAPIN':
            valorTipo = '<div class="px-2 bg-red-300 text-red-600 rounded-full uppercase"><h1>capin</h1></div>';
            break;
        case 'CAPEX':
            valorTipo = '<div class="px-2 bg-yellow-300 text-yellow-600 rounded-full uppercase"><h1>capex</h1></div>';
            break;
        case 'PROYECTO':
            valorTipo = '<div class="px-2 bg-blue-300 text-blue-600 rounded-full uppercase"><h1>proyecto</h1></div>';
            break;
        default:
            valorTipo = '';
    }

    switch (justificacion) {
        case 'NO':
            valorjustificacion = '<i class="fad fa-minus text-xl text-red-400"></i>';
            break;
        case 'SI':
            valorjustificacion = '<i class="fas fa-check text-xl text-green-300"></i>';
            break;
        default:
            valorjustificacion = params.justificacion;
    }

    switch (materiales) {
        case 1:
            materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
            break;
        default:
            materialesx = '';
    }

    switch (departamento) {
        case 1:
            departamentox = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
            break;
        default:
            departamentox = '';
    }

    switch (energeticos) {
        case 1:
            energeticosx = '<div class="bg-yellow-300 w-5 h-5 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>E</h1></div>';
            break;
        default:
            energeticosx = '';
    }

    switch (trabajando) {
        case 1:
            trabajandox = '<div class="bg-cyan-300 w-5 h-5 rounded-full flex justify-center items-center text-cyan-600 mr-1"><h1>T</h1></div>';
            break;
        default:
            trabajandox = '';
    }

    // Valor Inicial
    var fResponsable = '';
    var fJustificacionAdjunto = '';
    var fStatus = '';
    var fRangoFecha = '';
    var fCotizaciones = '';
    var fTipo = '';
    var fJustificacion = '';
    var fCoste = '';
    var fPresupuesto = '';
    var fToolTip = '';
    var iconoStatus = '';
    var ocultarActividades = `onclick="hiddenVista('tooltipActividadesPlanaccion'); hiddenVista('tooltipEditarEliminarSolucionar');"`;

    if (params.status == "PENDIENTE" || params.status == "N") {
        fResponsable = `onclick="hiddenVista('tooltipProyectos'); obtenerResponsablesProyectos(${idProyecto})"`;

        fStatus = `onclick="hiddenVista('tooltipProyectos'); statusProyecto(${idProyecto});"`;
        fRangoFecha = `onclick="hiddenVista('tooltipProyectos'); obtenerDatoProyectos(${idProyecto},'rango_fecha');"`;

        fCotizaciones = `onclick="hiddenVista('tooltipProyectos'); cotizacionesProyectos(${idProyecto});"`;

        fTipo = `onclick="hiddenVista('tooltipProyectos'); obtenerDatoProyectos(${idProyecto}, 'tipo');"`;

        fJustificacion = `onclick="hiddenVista('tooltipProyectos'); obtenerDatoProyectos(${idProyecto},'justificacion');"`;

        fCoste = `onclick="hiddenVista('tooltipProyectos'); obtenerDatoProyectos(${idProyecto},'coste');"`;

        fPresupuesto = `onclick="hiddenVista('tooltipProyectos'); obtenerPresupuestoProyecto(${idProyecto}); toggleModalTailwind('modalPresupuestoProyecto')"`;

        fToolTip = `onclick="tooltipProyectos(${idProyecto}); obtenerPlanaccion(${idProyecto});"`;
        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';

    } else {
        iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        fStatus = `onclick="actualizarProyectos('N', 'status', ${idProyecto});"`;
    }

    return `
        <tr id="${params.id}proyecto" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-proyectos-select" ${ocultarActividades}>

            <td class="px-4 border-b border-gray-200 py-3" ${fToolTip} style="max-width: 360px;">
                <div class="font-semibold uppercase leading-4" data-title="${params.proyecto}">
                    <h1 id="${params.id}tituloProyecto" class="truncate">${params.proyecto}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1 class="mr-2 font-semibold">${params.destino}</h1>
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fToolTip}>
                <h1>${params.pda}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable}>
                <h1>${params.responsable}</h1>
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fRangoFecha}>
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fCotizaciones}>
                <h1>${valorCotizaciones}</h1>
            </td>

            <td class="  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fTipo}>
                ${valorTipo}
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 text-center text-lg py-3" ${fJustificacion}>
                ${valorjustificacion}
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" 
            ${fCoste}>
                <h1>$ ${params.coste}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" 
            ${fPresupuesto}>
                <h1>$ ${params.presupuesto}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3">
                <div class="text-sm flex justify-center items-center font-bold">
                    ${materialesx}
                    ${energeticosx}
                    ${departamentox}
                    ${trabajandox}                                                
                </div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center text-gray-400 hover:text-purple-500 py-3" ${fStatus}>
                <div class="px-2">
                    ${iconoStatus}
                </div>
            </td>
            
        </tr>
        `;
}


// const $tablaPlanes = document.getElementById('contenedorDePlanesdeaccion');
const datosPlanes = params => {
    var idPlanaccion = params.id;

    var comentarios = params.comentarios;
    var valorcomentarios = 'X'

    var adjuntos = params.adjuntos;
    var valoradjuntos = 'X'

    var materiales = params.materiales;
    var materialesx = ''

    var departamentos = params.departamentos;
    var departamentosx = ''

    var energeticos = params.energeticos;
    var energeticosx = ''

    var trabajando = params.trabajando;
    var trabajandox = ''

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

    switch (materiales) {
        case 1:
            materialesx = '<div class="bg-bluegray-800 w-5 h-5 rounded-full flex justify-center items-center text-white mr-1"><h1>M</h1></div>';
            break;
        default:
            materialesx = '';
    }

    switch (departamentos) {
        case 1:
            departamentosx = '<div class="bg-teal-300 w-5 h-5 rounded-full flex justify-center items-center text-teal-600 mr-1"><h1>D</h1></div>';
            break;
        default:
            departamentosx = '';
    }

    switch (energeticos) {
        case 1:
            energeticosx = '<div class="bg-yellow-300 w-5 h-5 rounded-full flex justify-center items-center text-yellow-600 mr-1"><h1>E</h1></div>';
            break;
        default:
            energeticosx = '';
    }

    switch (trabajando) {
        case 1:
            trabajandox = '<div class="bg-cyan-300 w-5 h-5 rounded-full flex justify-center items-center text-cyan-600 mr-1"><h1>T</h1></div>';
            break;
        default:
            trabajandox = '';
    }

    var fResponsable = '';
    var fComentarios = '';
    var fAdjuntos = '';
    var fStatus = '';
    var iconoStatus = '';
    var fToolTip = `onclick="tooltipPlanaccion(${idPlanaccion}); obtenerActividadesPlanaccion(${idPlanaccion});"`;
    // var fOT = `onclick="generarOTPlanaccion(${idPlanaccion});"`;
    var fOT = `<a href="OT_proyectos/#P${idPlanaccion}" class="text-black" target="_blank"> 
    ${idPlanaccion}</a>`;
    var fRangoFecha = '';
    var statusPlanaccion = '';
    var ocultarActividades = `onclick="hiddenVista('tooltipEditarEliminarSolucionar');"`;
    if (params.status == "PENDIENTE") {
        statusPlanaccion = 'planaccion_PENDIENTE';
        fResponsable = `onclick="obtenerResponsablesPlanaccion(${idPlanaccion});"`;
        fComentarios = `onclick="hiddenVista('tooltipActividadesPlanaccion'); comentariosPlanaccion(${idPlanaccion}); nivelVista(1,'modalComentarios');"`;
        fAdjuntos = `onclick="hiddenVista('tooltipActividadesPlanaccion'); adjuntosPlanaccion(${idPlanaccion}); nivelVista(1,'modalMedia');"`;
        fStatus = `onclick="hiddenVista('tooltipActividadesPlanaccion'); statusPlanaccion(${idPlanaccion}); nivelVista(1,'modalStatus');"`;
        iconoStatus = '<i class="fas fa-ellipsis-h  text-lg"></i>';
        fRangoFecha = `onclick="abrirmodal('modalRangoFechaX'); obtenerRangoFechaPlanaccion(${idPlanaccion})"`;
    } else {
        fStatus = `onclick="actualizarPlanaccion('N','status', ${idPlanaccion});"`;
        iconoStatus = '<i class="fas fa-undo fa-lg text-red-500"></i>';
        statusPlanaccion = 'planaccion_SOLUCIONADO hidden';
    }

    return `
    <tr id="${idPlanaccion}planaccion" class="hover:bg-gray-200 cursor-pointer text-xs font-normal fila-planaccion-select ${statusPlanaccion}" ${ocultarActividades}>
            <td class="px-4 border-b border-gray-200 truncate py-3" style="max-width: 360px;" 
            ${fToolTip}>
                <div class="font-semibold uppercase leading-4">
                    <h1 id="AP${idPlanaccion}">${params.actividad}</h1>
                </div>
                <div class="text-gray-500 leading-3 flex">
                    <h1>Creado por: ${params.creadoPor}</h1>
                </div>
            </td>

            <td id="${idPlanaccion}planaccionX" class=" whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fToolTip}>
                <h1>${params.subTareas}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 uppercase text-center py-3" ${fResponsable}>
                <h1>${params.responsable}</h1>
            </td>

            <td class="whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fRangoFecha}>
                <div class="leading-4">${params.fechaInicio}</div>
                <div class="leading-3">${params.fechaFin}</div>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fComentarios}>
                <h1>${valorcomentarios}</h1>
            </td>

            <td class=" whitespace-no-wrap border-b border-gray-200 text-center py-3" ${fAdjuntos}>
                <h1>${valoradjuntos}</h1>
            </td>

            <td class="px-2  whitespace-no-wrap border-b border-gray-200 text-center cursor-pointer py-3">
                <div class="text-sm flex justify-center items-center font-bold" ${fStatus}>
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
}


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
})


// TOOLTIP PARA MOSTRAR LOS PLANESACCIÓN DE LOS PROYECTOS
function tooltipProyectos(idproyecto) {
    // Ciclo para quitar bg-gray-200
    let filas = document.getElementsByClassName("fila-proyectos-select");
    for (let x = 0; x < filas.length; x++) {
        filas[x].classList.remove('bg-gray-300');
    }
    document.getElementById("tooltipProyectos").classList.toggle('hidden');

    if (document.getElementById("tooltipProyectos").classList.contains('hidden')) {
        document.getElementById(idproyecto + 'proyecto').classList.remove('bg-gray-300');
    } else {
        document.getElementById(idproyecto + 'proyecto').classList.add('bg-gray-300');
    }

    // Propiedades para el tooltip
    const button = document.getElementById(idproyecto + 'proyecto');
    const tooltip = document.getElementById('tooltipProyectos');
    Popper.createPopper(button, tooltip);
}


// TOOLTIP PARA MOSTRAR LOS PLANESACCIÓN DE LOS PROYECTOS
function tooltipEditarEliminarSolucionar(idActividad) {
    localStorage.setItem('idActividad', idActividad);
    let tituloActividad = document.getElementById('tituloActividad' + idActividad).innerHTML;
    document.getElementById("inputTitulo").value = tituloActividad;

    // Ciclo para quitar bg-gray-200
    let filas = document.getElementsByClassName("fila-actividad-select");
    for (let x = 0; x < filas.length; x++) {
        filas[x].classList.remove('bg-gray-300');
    }
    document.getElementById("tooltipEditarEliminarSolucionar").classList.toggle('hidden');

    if (document.getElementById("tooltipEditarEliminarSolucionar").classList.contains('hidden')) {
        document.getElementById(idActividad + 'actividad').classList.remove('bg-gray-300');
    } else {
        document.getElementById(idActividad + 'actividad').classList.add('bg-gray-300');
    }

    // Propiedades para el tooltip
    const button = document.getElementById(idActividad + 'actividad');
    const tooltip = document.getElementById('tooltipEditarEliminarSolucionar');
    Popper.createPopper(button, tooltip, {
        placement: 'top'
    });

    document.getElementById("btnFinalizar").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, 'SOLUCIONADO', 'STATUS')`);

    document.getElementById("btnTitulo").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, 'ACTIVIDAD', 'ACTIVIDAD')`);

    document.getElementById("btnEliminar").setAttribute('onclick', `actualizarActividadPlanaccion(${idActividad}, '0', 'ACTIVO')`);

    if (document.getElementById(idActividad + 'actividad').childNodes[1].classList.contains('bg-green-300')) {
        document.getElementById("btnFinalizar").classList.remove('hover:bg-green-200');
        document.getElementById("btnFinalizar").classList.add('bg-green-200');
    } else {
        document.getElementById("btnFinalizar").classList.add('hover:bg-green-200');
        document.getElementById("btnFinalizar").classList.remove('bg-green-200');
    }
}


// OBTIENES LOS PROYECTOS
function obtenerProyectos(idSeccion, status = 'PENDIENTE') {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSubseccion = localStorage.getItem('idSubseccion');

    // Atributos Iniciales
    document.getElementById("proyectosPendientes").setAttribute('onclick', `obtenerProyectos(${idSeccion}, "PENDIENTE");`);
    document.getElementById("proyectosSolucionados").setAttribute('onclick', `obtenerProyectos(${idSeccion}, "SOLUCIONADO");`);
    // Atributos Iniciales

    // Actualiza la Sección
    localStorage.setItem("idSeccion", idSeccion);

    // Estilo para Botones Superiores
    estiloBotonesProyectos(status, 'PROYECTOS');

    // Secciones de Botones.
    document.getElementById("btnCrearProyecto")
        .setAttribute("onclick", "agregarProyecto()");

    const action = "obtenerProyectos";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}&status=${status}`;
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';

    fetch(URL)
        .then(resp => resp.json())
        .then(array => {
            if (array.length > 0) {
                document.getElementById('contenedorDeProyectos').innerHTML = '';
                for (let x = 0; x < array.length; x++) {
                    const id = array[x].id;
                    const destino = array[x].destino;
                    const proyecto = array[x].proyecto;
                    const creadoPor = array[x].creadoPor;
                    const pda = array[x].pda;
                    const responsable = array[x].responsable;
                    const fechaInicio = array[x].fechaInicio;
                    const fechaFin = array[x].fechaFin;
                    const cotizaciones = array[x].cotizaciones;
                    const tipo = array[x].tipo;
                    const justificacion = array[x].justificacion;
                    const coste = array[x].coste;
                    const presupuesto = array[x].presupuesto;
                    const status = array[x].status;
                    const materiales = array[x].materiales;
                    const energeticos = array[x].energeticos;
                    const departamento = array[x].departamento;
                    const trabajando = array[x].trabajando;
                    const dataProyectos = datosProyectos({
                        id: id,
                        destino: destino,
                        proyecto: proyecto,
                        creadoPor: creadoPor,
                        pda: pda,
                        responsable: responsable,
                        fechaInicio: fechaInicio,
                        fechaFin: fechaFin,
                        cotizaciones: cotizaciones,
                        tipo: tipo,
                        justificacion: justificacion,
                        coste: coste,
                        presupuesto: presupuesto,
                        status: status,
                        materiales: materiales,
                        energeticos: energeticos,
                        departamento: departamento,
                        trabajando: trabajando
                    });

                    document.getElementById("contenedorDeProyectos").insertAdjacentHTML('beforeend', dataProyectos);
                }
            } else {
                alertaImg('Sin Proyectos', '', 'info', 1500);
                document.getElementById('contenedorDeProyectos').innerHTML = '';
            }
        })
        .then(() => {
            // Quita el Loader hasta que Finalize la carga de Proyectos
            document.getElementById("loadProyectos").innerHTML = '';
        })
        .catch(function () {
            document.getElementById("loadProyectos").innerHTML = '';
            document.getElementById('contenedorDeProyectos').innerHTML = '';
        });
}


// FORMATEA Y APLICA EL ESTILO A LOS DE BOTONES, EN LA PARTE DE MODALPROYECTOS
function estiloBotonesProyectos(status, opcion = 'PROYECTOS') {
    let botones = ['opcionGanttProyectos', 'opcionProyectos', 'proyectosPendientes', 'proyectosSolucionados'];
    for (let x = 0; x < botones.length; x++) {
        const boton = botones[x];
        document.getElementById(boton).classList.remove('bg-purple-200');
        document.getElementById(boton).classList.add('bg-purple-600');
    }

    if (opcion == "PROYECTOS") {
        document.getElementById("opcionProyectos").classList.add('bg-purple-200');
        document.getElementById("opcionProyectos").classList.remove('bg-purple-600');
    } else {
        document.getElementById("opcionGanttProyectos").classList.add('bg-purple-200');
        document.getElementById("opcionGanttProyectos").classList.remove('bg-purple-600');
    }

    if (status == "PENDIENTE") {
        document.getElementById("proyectosPendientes").classList.add('bg-purple-200');
        document.getElementById("proyectosPendientes").classList.remove('bg-purple-600');
    } else {
        document.getElementById("proyectosSolucionados").classList.add('bg-purple-200');
        document.getElementById("proyectosSolucionados").classList.remove('bg-purple-600');
    }
}


function obtenerRangoFechaPlanaccion(idPlanaccion) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerRangoFechaPlanaccion";

    document.getElementById("btnAplicarRangoFecha").
        setAttribute('onclick', `actualizarPlanaccion(1, 'rango_fecha', ${idPlanaccion});`);

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario,
            idPlanaccion: idPlanaccion
        },
        dataType: "JSON",
        success: function (data) {
            if (document.getElementById("rangoFechaX")) {
                document.getElementById("rangoFechaX").value = data;
            }
        }
    })
}


// ACTUALIZA DATOS DEL PROYECTO (T_PROYECTOS)
function actualizarProyectos(valor, columna, idProyecto) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let tipo = document.getElementById("tipoProyecto").value;
    let justificacion = document.getElementById("justificacionProyecto").value;
    let coste = document.getElementById("costeProyecto").value;
    let titulo = document.getElementById("inputEditarTitulo").value;
    let presupuesto = presupuestoProyecto.value;

    const action = "actualizarProyectos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            valor: valor,
            columna: columna,
            idProyecto: idProyecto,
            justificacion: justificacion,
            tipo: tipo,
            coste: coste,
            titulo: titulo,
            presupuesto: presupuesto
        },
        // dataType: "JSON",
        success: function (data) {
            if (data == 1) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                alertaImg("Responsable Actualizado", "", "success", 2000);
                document.getElementById("modalUsuarios").classList.remove("open");
            } else if (data == 2) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalActualizarProyecto');
                alertaImg("Justifiación Actualizado", "", "success", 2000);
            } else if (data == 3) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalActualizarProyecto');
                alertaImg("Coste Actualizado", "", "success", 2000);
            } else if (data == 4) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalActualizarProyecto');
                alertaImg("Tipo Actualizado", "", "success", 2000);
            } else if (data == 5) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalFechaProyectos');
                alertaImg("Fecha Actualizada", "", "success", 2000);
            } else if (data == 6) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalTituloEliminar');
                alertaImg("Proyecto Eliminado", "", "success", 2000);
            } else if (data == 7) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalTituloEliminar');
                cerrarmodal('modalEditarTitulo');
                alertaImg("Título Actualizado", "", "success", 2000);
            } else if (data == 8) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalTituloEliminar');
                alertaImg("Proyecto Finalizado", "", "success", 2000);
            } else if (data == 9) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalTituloEliminar');
                alertaImg("Proyecto Restaurado", "", "success", 2000);
            } else if (data == 11) {
                obtenerProyectos(idSeccion, "PENDIENTE");
                cerrarmodal('modalPresupuestoProyecto');
                alertaImg("Presupuesto Actualizado", "", "success", 2000);
            } else if (data == 10) {
                alertaImg("Solucione todas las actividades para poder Solucionar el Proyecto", "", "warning", 4000);
            } else {
                alertaImg("Intente de Nuevo", "", "info", 3000);
            }
        },
    });
}


// OBTIENE DATOS DE PROYECTOS
function obtenerDatoProyectos(idProyecto, columna) {
    localStorage.setItem("idProyecto", idProyecto);

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");

    // Oculta Media en Justificación
    document.getElementById("mediaProyectos").classList.add('hidden');
    document.getElementById("dataImagenesProyecto").innerHTML = '';
    document.getElementById("dataAdjuntosProyecto").innerHTML = '';


    document.getElementById("tipoProyectoDiv").classList.add("hidden");
    document.getElementById("justificacionProyectoDiv").classList.add("hidden");
    document.getElementById("costeProyectoDiv").classList.add("hidden");

    if (columna == "justificacion") {
        justificacionAdjuntosProyectos(idProyecto);
        document.getElementById("modalActualizarProyecto").classList.add("open");
        document.getElementById("tituloActualizarProyecto").innerHTML = "JUSTIFIACIÓN";

        document.getElementById("justificacionProyectoDiv").classList.remove("hidden");

        document.getElementById("inputAdjuntosJP")
            .setAttribute("onchange",
                "subirJustificacionProyectos(" + idProyecto + ', "t_proyectos_justificaciones")');

    } else if (columna == "coste") {
        document.getElementById("modalActualizarProyecto").classList.add("open");
        document.getElementById("tituloActualizarProyecto").innerHTML = "COSTE";
        document.getElementById("costeProyectoDiv").classList.remove("hidden");
    } else if (columna == "tipo") {
        document.getElementById("modalActualizarProyecto").classList.add("open");
        document.getElementById("tituloActualizarProyecto").innerHTML = "TIPO";
        document.getElementById("tipoProyectoDiv").classList.remove("hidden");
    } else if (columna == "rango_fecha") {
        document.getElementById("modalFechaProyectos").classList.add("open");
    }

    const action = "obtenerDatoProyectos";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idProyecto: idProyecto,
            columna: columna,
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("tipoProyecto").value = data.tipo;
            document.getElementById("justificacionProyecto").value = data.justificacion;
            document.getElementById("costeProyecto").value = data.coste;
            document.getElementById("fechaProyecto").value = data.rangoFecha;

            document.getElementById("btnGuardarInformacion")
                .setAttribute("onclick", 'actualizarProyectos(0, "' + columna + '",' + idProyecto + ")");
        },
    });
}


const obtenerPresupuestoProyecto = (idProyecto) => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('idUsuario');

    btnPresupuestoProyecto.
        setAttribute('onclick', `actualizarProyectos(0, 'presupuesto', ${idProyecto})`);

    const action = "obtenerProyectoPorID";
    const URL = `php/proyectos_planacciones.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idProyecto=${idProyecto}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const presupuesto = array[x].presupuesto;
                    presupuestoProyecto.value = presupuesto;
                }
            }
        })
}

// Obtener Opciones de Responsables para Proyectos
function datosAgregarProyecto() {
    document.getElementById("responsableProyectoN").innerHTML = "";
    document.getElementById("modalAgregarProyecto").classList.add("open");
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");

    const action = "obtenerResponsables";
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
            document.getElementById("responsableProyectoN").innerHTML = data.dataUsuarios;
        },
    });
}


// Agregar Proyecto
function agregarProyecto() {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let idSubseccion = localStorage.getItem('idSubseccion');
    let titulo = document.getElementById("tituloProyectoN").value;
    let tipo = document.getElementById("tipoProyectoN").value;
    let fecha = document.getElementById("fechaProyectoN").value;
    let responsable = document.getElementById("responsableProyectoN").value;
    let justificacion = document.getElementById("justificacionProyectoN").value;
    let coste = document.getElementById("costeProyectoN").value;
    const action = "agregarProyecto";
    if (titulo.length >= 1 && tipo.length >= 1 && fecha.length >= 1 && justificacion.length >= 1 && coste >= 0 && responsable > 0) {
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idSeccion: idSeccion,
                idSubseccion: idSubseccion,
                titulo: titulo,
                tipo: tipo,
                fecha: fecha,
                responsable: responsable,
                justificacion: justificacion,
                coste: coste,
            },
            // dataType: "JSON",
            success: function (data) {
                if (data == 1) {
                    obtenerProyectos(idSeccion, "PENDIENTE");
                    obtenerDatosUsuario(idDestino);
                    alertaImg("Proyecto Agregado", "", "success", 2500);
                    document.getElementById("tituloProyectoN").value = "";
                    document.getElementById("tipoProyectoN").value = "";
                    document.getElementById("fechaProyectoN").value = "";
                    document.getElementById("responsableProyectoN").value = "";
                    document.getElementById("justificacionProyectoN").value = "";
                    document.getElementById("costeProyectoN").value = "";
                    document.getElementById("modalAgregarProyecto").classList.remove("open");
                    document.getElementById("contenidoProyectos").classList.remove('hidden');
                    document.getElementById("contenidoGantt").classList.add('hidden');
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
            },
        });
    } else {
        alertaImg("Información NO Valida", "", "warning", 3000);
    }
}


//Optienes Usuarios posible para asignar responsable en Proyectos.
function obtenerResponsablesProyectos(idProyecto) {
    document.getElementById("palabraUsuario").setAttribute("onkeyup", `obtenerResponsablesProyectos(${idProyecto})`);

    document.getElementById("modalUsuarios").classList.add("open");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let palabraUsuario = document.getElementById("palabraUsuario").value;

    const action = "obtenerUsuarios";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&palabraUsuario=${palabraUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataUsuarios.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idUsuarioX = array[x].idUsuario;
                    const nombre = array[x].nombre;
                    const apellido = array[x].apellido;
                    const cargo = array[x].cargo;

                    const codigo = `
                        <div class="w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate" onclick="actualizarProyectos(${idUsuarioX}, 'asignarProyecto', ${idProyecto});">
                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="20" height="20" alt="">
                        <h1 class="ml-2">${nombre} ${apellido}</h1>
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
            fetch(APIERROR + err);
        })
}


//SUBÉ JUSTIFICACIÓN DE PROYECTOS
function subirJustificacionProyectos(idTabla, tabla) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let img = document.getElementById("inputAdjuntosJP").files;

    for (let index = 0; index < img.length; index++) {
        let imgData = new FormData();
        const action = "subirImagenGeneral";
        document.getElementById("cargandoAdjuntoJP").innerHTML =
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
                if (data == 1) {
                    alertaImg("Proceso Cancelado", "", "info", 3000);
                } else if (data == 6) {
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                    obtenerDatoProyectos(idTabla, 'justificacion');
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
                document.getElementById("cargandoAdjuntoJP").innerHTML = '';
            },
        });
    }
}


// JUSTIFICACIÓN PROYECTOS ADJUNTOS
function justificacionAdjuntosProyectos(idProyecto) {

    document.getElementById("mediaProyectos").classList.remove('hidden');
    document.getElementById("contenedorImagenesJP").classList.add('hidden');
    document.getElementById("contenedorDocumentosJP").classList.add('hidden');

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idTabla = idProyecto;
    const tabla = "t_proyectos_justificaciones";
    const action = "obtenerAdjuntos";

    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idProyecto: idProyecto,
            idTabla: idTabla,
            tabla: tabla
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("dataImagenesProyecto").innerHTML = '';
            document.getElementById("dataAdjuntosProyecto").innerHTML = '';
            if (data.imagen != "") {
                document.getElementById("dataImagenesProyecto").innerHTML = data.imagen;
                document.getElementById("contenedorImagenesJP").classList.remove('hidden');
            }

            if (data.documento != "") {
                document.getElementById("dataAdjuntosProyecto").innerHTML = data.documento;
                document.getElementById("contenedorDocumentosJP").classList.remove('hidden');
            }
        }
    });
}


// OBTENER STATUS PLANACCIÓN
function statusProyecto(idProyecto) {
    document.getElementById("modalTituloEliminar").classList.add("open");
    let tituloActual = document.getElementById(idProyecto + 'tituloProyecto').innerHTML;
    document.getElementById("inputEditarTitulo").value = tituloActual;

    document.getElementById("btnconfirmEditarTitulo")
        .setAttribute("onclick", 'actualizarProyectos(0, "titulo",' + idProyecto + ")");

    document.getElementById("eliminar").
        setAttribute("onclick", 'actualizarProyectos(0, "eliminar",' + idProyecto + ")");

    document.getElementById("finalizar").
        setAttribute("onclick", 'actualizarProyectos("F", "status",' + idProyecto + ")");
}


// Obtienes las Cotizaciones de PROYECTOS
function cotizacionesProyectos(idProyecto) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idTabla = idProyecto;
    let tabla = "t_proyectos_adjuntos";

    document.getElementById("contenedorImagenes").classList.add('hidden');
    document.getElementById("contenedorDocumentos").classList.add('hidden');

    document.getElementById("modalMedia").classList.add("open");
    document
        .getElementById("inputAdjuntos")
        .setAttribute(
            "onchange",
            "subirImagenGeneral(" + idProyecto + ', "t_proyectos_adjuntos")'
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


// OBTIEN LOS PLANES DE ACCIÓN POR PORYECTO
function obtenerPlanaccion(idProyecto) {
    localStorage.setItem('idProyecto', idProyecto);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = 'obtenerPlanaccion';
    const ruta = 'php/proyectos_planacciones.php?';
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idProyecto=${idProyecto}`;
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    fetch(URL)
        .then(array => array.json())
        .then(array => {
            document.getElementById("contenedorDePlanesdeaccion").innerHTML = '';
            if (!document.getElementById('tooltipProyectos').classList.contains('hidden')) {
                if (array.length > 0) {
                    document.getElementById('palabraProyecto').value = '';
                    for (let x = 0; x < array.length; x++) {
                        const id = array[x].id;
                        const destino = array[x].destino;
                        const actividad = array[x].actividad;
                        const creadoPor = array[x].creadoPor;
                        const subTareas = array[x].subTareas;
                        const responsable = array[x].responsable;
                        const fechaInicio = array[x].fechaInicio;
                        const fechaFin = array[x].fechaFin;
                        const comentarios = array[x].comentarios;
                        const adjuntos = array[x].adjuntos;
                        const justificacion = array[x].justificacion;
                        const coste = array[x].coste;
                        const status = array[x].status;
                        const materiales = array[x].materiales;
                        const energeticos = array[x].energeticos;
                        const departamentos = array[x].departamentos;
                        const trabajando = array[x].trabajando;

                        const dataPlanaccion = datosPlanes({
                            id: id,
                            destino: destino,
                            actividad: actividad,
                            creadoPor: creadoPor,
                            subTareas: subTareas,
                            responsable: responsable,
                            fechaInicio: fechaInicio,
                            fechaFin: fechaFin,
                            comentarios: comentarios,
                            adjuntos: adjuntos,
                            justificacion: justificacion,
                            coste: coste,
                            status: status,
                            materiales: materiales,
                            energeticos: energeticos,
                            departamentos: departamentos,
                            trabajando: trabajando
                        });

                        document.getElementById("contenedorDePlanesdeaccion")
                            .insertAdjacentHTML('beforeend', dataPlanaccion);
                    }
                } else {
                    alertaImg('Sin Plan de Acción', '', 'info', 1500);
                }
            } else {
                document.getElementById('contenedorDePlanesdeaccion').innerHTML = '';
            }
        })
        .then(() => {
            document.getElementById("loadProyectos").innerHTML = '';
        })
        .catch(function () {
            document.getElementById("loadProyectos").innerHTML = '';
            document.getElementById('contenedorDePlanesdeaccion').innerHTML = '';
        });
}


// OBTIENE RESPONSABLE PARA PLAN DE ACCIÓN
function obtenerResponsablesPlanaccion(idPlanaccion) {
    document.getElementById("palabraUsuario").setAttribute("onkeyup", `obtenerResponsablesPlanaccion(${idPlanaccion})`);
    document.getElementById("modalUsuarios").classList.add("open");

    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let palabraUsuario = document.getElementById("palabraUsuario").value;

    const action = "obtenerUsuarios";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&palabraUsuario=${palabraUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            dataUsuarios.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idUsuarioX = array[x].idUsuario;
                    const nombre = array[x].nombre;
                    const apellido = array[x].apellido;
                    const cargo = array[x].cargo;

                    const codigo = `
                        <div class="w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate" onclick="actualizarPlanaccion(${idUsuarioX}, 'asignarPlanaccion', ${idPlanaccion});">
                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${nombre}%${apellido}" width="20" height="20" alt="">
                        <h1 class="ml-2">${nombre} ${apellido}</h1>
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
            fetch(APIERROR + err);
        })

}


// ACTUALIZAR PLANACCIÓN
function actualizarPlanaccion(valor, columna, idPlanaccion) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let actividad = document.getElementById("editarTitulo").value;
    let idProyecto = localStorage.getItem('idProyecto');
    let codigoSeguimiento = document.getElementById("inputCod2bend").value;
    let rangoFecha = document.getElementById("rangoFechaX").value;
    const action = "actualizarPlanaccion";
    $.ajax({
        type: "POST",
        url: "php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idSeccion: idSeccion,
            idPlanaccion: idPlanaccion,
            valor: valor,
            columna: columna,
            actividad: actividad,
            codigoSeguimiento: codigoSeguimiento,
            rangoFecha: rangoFecha
        },
        // dataType: "JSON",
        success: function (data) {

            if (data == 1) {
                document.getElementById("modalUsuarios").classList.remove("open");
                alertaImg("Responsable Actualizado", "", "success", 2500);
            } else if (data == 2) {
                document.getElementById("modalEditarTitulo").classList.remove("open");
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Actualizada", "", "success", 2500);
            } else if (data == 3) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Eliminada", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 4) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Solucionada", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 5) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Status Actualizado", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 6) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Actividad Restaurada", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 7) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Status Actualizado", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else if (data == 8) {
                cerrarmodal('modalRangoFechaX');
                alertaImg("Fecha Actualizada", "", "success", 1500);
            } else if (data == 9) {
                document.getElementById("modalStatus").classList.remove("open");
                alertaImg("Bitácora Actualizada", "", "success", 2500);
                obtenerProyectos(idSeccion, 'PENDIENTE');
            } else {
                alertaImg("Intente de Nuevo", "", "info", 1200);
            }

            obtenerPlanaccion(idProyecto);
        },
    });
}


// STATUS PLANACCIÓN
function statusPlanaccion(idPlanaccion) {

    document.getElementById("modalStatus").classList.add("open");

    // Agregan Funciones en los Botones del modalStatus para poder Aplicar un Status
    document.getElementById("btnEditarTitulo").setAttribute("onclick", 'actualizarPlanaccion(0,"actividad",' + idPlanaccion + ")");

    document.getElementById("statusActivo").setAttribute("onclick", 'actualizarPlanaccion(0,"activo",' + idPlanaccion + ")");

    document.getElementById("statusFinalizar").setAttribute("onclick", 'actualizarPlanaccion("F","status",' + idPlanaccion + ")");

    document.getElementById("btnStatusMaterial").setAttribute("onclick", 'actualizarPlanaccion(1, "status_material",' + idPlanaccion + ")");

    document.getElementById("statusTrabajare").setAttribute("onclick", 'actualizarPlanaccion(1, "status_trabajando",' + idPlanaccion + ")");

    document.getElementById("statusElectricidad").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_electricidad",' + idPlanaccion + ")");

    document.getElementById("statusAgua").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_agua",' + idPlanaccion + ")");

    document.getElementById("statusDiesel").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_diesel",' + idPlanaccion + ")");

    document.getElementById("statusGas").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_gas",' + idPlanaccion + ")");

    document.getElementById("statusRRHH").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_rrhh",' + idPlanaccion + ")");

    document.getElementById("statusCalidad").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_calidad",' + idPlanaccion + ")");

    document.getElementById("statusDireccion").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_direccion",' + idPlanaccion + ")");

    document.getElementById("statusFinanzas").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_finanzas",' + idPlanaccion + ")");

    document.getElementById("statusCompras").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_compras",' + idPlanaccion + ")");

    document.getElementById("statusGP").setAttribute("onclick", 'actualizarPlanaccion(1, "bitacora_gp",' + idPlanaccion + ")");

    document.getElementById("statusTRS").setAttribute("onclick", 'actualizarPlanaccion(1, "bitacora_trs",' + idPlanaccion + ")");

    document.getElementById("statusZI").setAttribute("onclick", 'actualizarPlanaccion(1, "bitacora_zi",' + idPlanaccion + ")");

    nivelVista(2, 'modalEditarTitulo');
    estiloModalStatus(idPlanaccion, 'PLANACCION');
}


// Comentarios para Planaccion
function comentariosPlanaccion(idPlanaccion) {
    document.getElementById("modalComentarios").classList.add("open");

    document.getElementById("btnComentario")
        .setAttribute("onclick", "agregarComentarioPlanaccion(" + idPlanaccion + ")");

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



// AGREGAR COMENTARIO PLAN DE ACCIÓN
function agregarComentarioPlanaccion(idPlanaccion) {
    let comentario = document.getElementById("inputComentario").value;
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idProyecto = localStorage.getItem('idProyecto');
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
                    comentariosPlanaccion(idPlanaccion);
                    obtenerPlanaccion(idProyecto);
                    document.getElementById("inputComentario").value = "";
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


// AGREGA PLANESACCIÓN A PROYECTOS
function agregarPlanaccion() {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let actividad = document.getElementById("agregarPlanaccion");
    let idSeccion = localStorage.getItem('idSeccion');
    let idProyecto = localStorage.getItem('idProyecto');
    if (actividad.value.length >= 1) {
        const action = "agregarPlanaccion";
        $.ajax({
            type: "POST",
            url: "php/plannerCrudPHP.php",
            data: {
                action: action,
                idUsuario: idUsuario,
                idDestino: idDestino,
                idProyecto: idProyecto,
                actividad: actividad.value
            },
            dataType: "JSON",
            success: function (data) {
                if (data == 1) {
                    document.getElementById("agregarPlanaccion").value = '';
                    obtenerProyectos(idSeccion, 'PENDIENTE');
                    obtenerPlanaccion(idProyecto);
                    alertaImg("Actividad Agregada", "", "success", 2500);
                    actividad.value = '';
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
            },
        });
    } else {
        alertaImg("Intente de Nuevo", "", "info", 3000);
    }
}


function statusPlanaccionx(status) {
    if (document.getElementsByClassName('planaccion_' + status).length > 0) {

        document.getElementById('planaccionPendientes').
            classList.remove('bg-purple-600', 'bg-purple-200');
        document.getElementById('planaccionSolucionados').
            classList.remove('bg-purple-600', 'bg-purple-200');

        if (status == "SOLUCIONADO") {
            for (let x = 0; x < document.getElementsByClassName('planaccion_SOLUCIONADO').length; x++) {
                document.getElementsByClassName('planaccion_SOLUCIONADO')[x].
                    classList.remove('hidden');
            }

            for (let x = 0; x < document.getElementsByClassName('planaccion_PENDIENTE').length; x++) {
                document.getElementsByClassName('planaccion_PENDIENTE')[x].
                    classList.add('hidden');
            }

            document.getElementById('planaccionPendientes').classList.add('bg-purple-200');
            document.getElementById('planaccionSolucionados').classList.add('bg-purple-600');

        } else {
            for (let x = 0; x < document.getElementsByClassName('planaccion_PENDIENTE').length; x++) {
                document.getElementsByClassName('planaccion_PENDIENTE')[x].
                    classList.remove('hidden');
            }

            for (let x = 0; x < document.getElementsByClassName('planaccion_SOLUCIONADO').length; x++) {
                document.getElementsByClassName('planaccion_SOLUCIONADO')[x].
                    classList.add('hidden');
            }
            document.getElementById('planaccionSolucionados').classList.add('bg-purple-200');
            document.getElementById('planaccionPendientes').classList.add('bg-purple-600');
        }
    } else {
        alertaImg('Sin: ' + status + 'S', '', 'info', 1000);
    }
}


// OBTIENE LAS ACTIVIDAD RELACIONADAS PARA EL PLAN DE ACCIÓN
function obtenerActividadesPlanaccion(idPlanaccion) {
    localStorage.setItem('idPlanaccion', idPlanaccion);
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    const action = "obtenerActividadesPlanaccion";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idPlanaccion=${idPlanaccion}`;
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            document.getElementById("dataActividades").innerHTML = '';
            if (array.length > 0) {
                for (let x = 0; x < array.length; x++) {
                    const idActividad = array[x].id;
                    const actividad = array[x].actividad;
                    var status = array[x].status;

                    if (status == "SOLUCIONADO") {
                        status = 'bg-green-300';
                    } else {
                        status = 'hove:bg-green-300';
                    }

                    document.getElementById("dataActividades").innerHTML += `
                        <div id="${idActividad}actividad" class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-fondos-2 fila-actividad-select">
                            <div class="w-4 h-4 border-2 border-gray-300 ${status} hover:border-green-400 cursor-pointer rounded-full mr-2 flex-none"></div>
                            <div class=" text-justify">
                                <h1 id="tituloActividad${idActividad}">${actividad}</h1>
                            </div>
                            <div class="px-2 text-gray-400 hover:text-purple-500 cursor-pointer" onclick="tooltipEditarEliminarSolucionar(${idActividad})">
                                <i class="fas fa-ellipsis-h  text-sm"></i>
                            </div>
                        </div>
                    `;
                }
            }
        }).then(() => {
            document.getElementById("loadProyectos").innerHTML = '';
        })
        .catch(function () {
            document.getElementById("loadProyectos").innerHTML = '';
            document.getElementById("dataActividades").innerHTML = '';
            alertaImg('Sin Actividades', '', 'info', 1200);
        })
}


// AGREGA ACTIVIDAD PARA EL PLAN DE ACCIÓN
function agregarActividadPlanaccion() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idPlanaccion = localStorage.getItem('idPlanaccion');
    let actividad = document.getElementById("agregarActividadPlanaccion").value;
    let idProyecto = localStorage.getItem('idProyecto');
    const ruta = "php/proyectos_planacciones.php?";
    const action = "agregarActividadPlanaccion";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idPlanaccion=${idPlanaccion}&actividad=${actividad}`;
    if (actividad.length > 0) {
        fetch(URL)
            .then(res => res.json())
            .then(array => {
                if (array == "Agregado") {
                    alertaImg('Actividas Agregada', '', 'success', 1200);
                    document.getElementById("agregarActividadPlanaccion").value = '';
                    obtenerPlanaccion(idProyecto);
                    obtenerActividadesPlanaccion(idPlanaccion);
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1200);
                }
            })
    } else {
        alertaImg('Intente de Nuevo', '', 'info', 1200);
    }
}


//Función para Generar Grafica GANTT de PROYECTOS PENDIENTES 
function ganttP() {
    // Cambia diseño de Botones en Proyectos

    // Oculta y Muestra contenido
    document.getElementById("palabraProyecto")
        .setAttribute("onkeyup", "ganttP()");
    estiloBotonesProyectos('PENDIENTE', 'GANTT');
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    // Data URL
    const action = "ganttProyectosP";
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let idSubseccion = 200;
    let palabraProyecto = document.getElementById("palabraProyecto").value;
    let dataURL =
        "php/graficas_am4charts.php?action=" +
        action +
        "&idUsuario=" +
        idUsuario +
        "&idDestino=" +
        idDestino +
        "&idSeccion=" +
        idSeccion +
        "&idSubseccion=" +
        idSubseccion +
        "&palabraProyecto=" +
        palabraProyecto;

    fetch(dataURL)
        .then((res) => res.json())
        .then((dataGantt) => {
            const arrayTratado = new Promise((resolve, recject) => {
                for (var i = 0; i < dataGantt.length; i++) {
                    var colorSet = new am4core.ColorSet();
                    dataGantt[i]["color"] = colorSet.getIndex(i);
                }
                resolve(dataGantt);
            });

            arrayTratado
                .then((response) => {
                    generarGantt(response);
                    document.getElementById("loadProyectos").innerHTML = '';
                })
                .catch((error) => {
                    document.getElementById("loadProyectos").innerHTML = '';
                });

            let size = 100 + dataGantt.length * 50;
            document
                .getElementById("chartdiv")
                .setAttribute("style", "height:" + size + "px");
        });

    function generarGantt(dataGantt) {
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

        chart.paddingRight = 30;
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

        var colorSet = new am4core.ColorSet();
        colorSet.saturation = 0.4;

        chart.data = dataGantt;
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


//Función para Generar Grafica GANTT de PROYECTOS SOLUCIONADOS 
function ganttS() {

    // Oculta y Muestra contenido
    document.getElementById("palabraProyecto")
        .setAttribute("onkeyup", "ganttS()");
    estiloBotonesProyectos('SOLUCIONADO', 'GANTT');
    document.getElementById("loadProyectos").innerHTML =
        '<i class="fa fa-spinner fa-pulse fa-sm"></i>';
    // Data URL
    const action = "ganttProyectosS";
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let idSeccion = localStorage.getItem("idSeccion");
    let idSubseccion = 200;
    let palabraProyecto = document.getElementById("palabraProyecto").value;
    let dataURL =
        "php/graficas_am4charts.php?action=" +
        action +
        "&idUsuario=" +
        idUsuario +
        "&idDestino=" +
        idDestino +
        "&idSeccion=" +
        idSeccion +
        "&idSubseccion=" +
        idSubseccion +
        "&palabraProyecto=" +
        palabraProyecto;

    fetch(dataURL)
        .then((res) => res.json())
        .then((dataGantt) => {
            const arrayTratado = new Promise((resolve, recject) => {
                for (var i = 0; i < dataGantt.length; i++) {
                    var colorSet = new am4core.ColorSet();
                    dataGantt[i]["color"] = colorSet.getIndex(i);
                }
                resolve(dataGantt);
            });

            arrayTratado
                .then((response) => {
                    generarGantt(response);
                    document.getElementById("loadProyectos").innerHTML = '';
                })
                .catch((error) => {
                    document.getElementById("loadProyectos").innerHTML = '';
                });
            let size = 100 + dataGantt.length * 50;
            document
                .getElementById("chartdiv")
                .setAttribute("style", "height:" + size + "px");
        });

    function generarGantt(dataGantt) {
        am4core.useTheme(am4themes_animated);
        // Themes end

        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

        chart.paddingRight = 30;
        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

        var colorSet = new am4core.ColorSet();
        colorSet.saturation = 0.4;

        chart.data = dataGantt;
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


// REDIRECIONA (OT_proyectos/) PARA GENERAR LA OT CON localStorage.setItem('URL', idPlanaccion)
function generarOTPlanaccion(idPlanaccion) {
    alertaImg('Generando... OT #' + idPlanaccion, '', 'success', 1200);
    localStorage.setItem('URL', idPlanaccion);
    let URL = 'https://www.maphg.com/beta/OT_proyectos/';
    window.open(URL, "OT PROYECTO #" + idPlanaccion, "width=1300px, height=900px");
}


function actualizarActividadPlanaccion(idActividad, parametro, columna) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let idProyecto = localStorage.getItem('idProyecto');
    let idPlanaccion = localStorage.getItem('idPlanaccion');

    if (columna == "ACTIVIDAD") {
        parametro = document.getElementById("inputTitulo").value;
    }

    const action = "actualizarActividadPlanaccion";
    const ruta = "php/proyectos_planacciones.php?";
    const URL = `${ruta}action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idActividad=${idActividad}&parametro=${parametro}&columna=${columna}`;
    fetch(URL)
        .then(resp => resp.json())
        .then(resp => {
            if (resp.resp == "ELIMINADO") {
                alertaImg('Actividad Eliminada', '', 'success', 1200);
                document.getElementById('tooltipEditarEliminarSolucionar').classList.add('hidden');
                obtenerPlanaccion(idProyecto);
                obtenerActividadesPlanaccion(idPlanaccion);
            } else if (resp.resp == "TITULO") {
                alertaImg('Actividad Actualizada', '', 'success', 1200);
                document.getElementById('segmentoTitulo').classList.add('hidden');
                document.getElementById('tooltipEditarEliminarSolucionar').classList.add('hidden');
                obtenerActividadesPlanaccion(idPlanaccion);
            } else if (resp.resp == "PENDIENTE" || resp.resp == "SOLUCIONADO") {
                alertaImg('Status Acualizado', '', 'success', 1200);
                document.getElementById('tooltipEditarEliminarSolucionar').classList.add('hidden');
                document.getElementById('tooltipEditarEliminarSolucionar').classList.add('hidden');
                obtenerActividadesPlanaccion(idPlanaccion);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 1200);
            }
        })
        .catch(function () {
            obtenerPlanaccion(idProyecto);
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

    document.getElementById("inputAdjuntos")
        .setAttribute("onchange", "subirImagenGeneral(" + idPlanaccion + ',"t_proyectos_planaccion_adjuntos")');

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


// ********** FRAGMENTO PARA LOS EVENTOS **********
// EVENTO PARA EXPORTA PROYECTOS EN EXCEL
document.getElementById("exportarProyectos").addEventListener('click', function () {
    tableToExcel('contenedorDeProyectos', 'PROYECTOS');
});

// EVENTO PARA BUSCAR PROYECTOS EN LA TABLA
document.getElementById("palabraProyecto").addEventListener('keyup', function () {
    buscadorTabla('contenedorDeProyectos', 'palabraProyecto', 0);
});

// EVENTO PARA PROYECTOS SOLUCIONADOS
document.getElementById("btnCerrerModalProyectos").addEventListener('click', function () {
    document.getElementById("tooltipProyectos").classList.add('hidden');
    document.getElementById("tooltipActividadesPlanaccion").classList.add('hidden');
});

// EVENTO PARA  AGREGAR PROYECTO
document.getElementById("agregarProyecto").addEventListener('click', datosAgregarProyecto);

// EVENTO PARA  MOSTRAR PLANACCIÓN PENDIENTES
document.getElementById("planaccionPendientes").addEventListener('click', () => {
    statusPlanaccionx('PENDIENTE');
});

// EVENTO PARA  MOSTRAR PLANACCIÓN SOLUCIONADOS
document.getElementById("planaccionSolucionados").addEventListener('click', () => {
    statusPlanaccionx('SOLUCIONADO');
});

// EVENTO PARA  AGREGAR PLANACCIÓN
document.getElementById("agregarPlanaccion").addEventListener('keyup', event => {
    if (event.keyCode === 13) {
        agregarPlanaccion();
    }
});

// EVENTO PARA  AGREGAR PLANACCIÓN
document.getElementById("btnagregarPlanaccion").addEventListener('click', agregarPlanaccion);

// EVENTO PARA  AGREGAR ACTIVIDAD EN PLANACCIÓN
document.getElementById("agregarActividadPlanaccion").addEventListener('keyup', event => {
    if (event.keyCode === 13) {
        agregarActividadPlanaccion();
    }
});

// EVENTO PARA  AGREGAR ACTIVIDAD EN PLANACCIÓN
document.getElementById("btnAgregarActividadPlanaccion").addEventListener('click', agregarActividadPlanaccion);

// EVENTO PARA  MOSTRAR GANTT 
document.getElementById("opcionGanttProyectos").addEventListener('click', () => {
    document.getElementById("contenidoProyectos").classList.add("hidden");
    document.getElementById("contenidoGantt").classList.remove("hidden");
    estiloBotonesProyectos('PENDIENTE', 'PROYECTO');
    ganttP();

    document.getElementById("proyectosPendientes").setAttribute('onclick', 'ganttP()');
    document.getElementById("proyectosSolucionados").setAttribute('onclick', 'ganttS()');
});


// OCULTA SUBVENTANAS DE LOS PROYECTOS
document.getElementById("contenidoOpcionesProyectos").addEventListener('click', function () {
    hiddenVista("tooltipActividadesPlanaccion");
    hiddenVista("tooltipProyectos");
    hiddenVista("tooltipEditarEliminarSolucionar");
});

// EVENTO PARA  MOSTRAR PROYECTOS 
document.getElementById("opcionProyectos").addEventListener('click', () => {
    let idSeccion = localStorage.getItem('idSeccion');
    document.getElementById("contenidoProyectos").classList.remove("hidden");
    document.getElementById("contenidoGantt").classList.add("hidden");
    estiloBotonesProyectos('PENDIENTE', 'GANTT');
    obtenerProyectos(idSeccion, 'PENDIENTE');

    document.getElementById("proyectosPendientes").setAttribute('onclick', `obtenerProyectos(${idSeccion}, "PENDIENTE");`);

    document.getElementById("proyectosSolucionados").setAttribute('onclick', `obtenerProyectos(${idSeccion}, "SOLUCIONADO");`);

});

// ********** FRAGMENTO PARA LOS EVENTOS **********
// ********** PROYECTOS **********