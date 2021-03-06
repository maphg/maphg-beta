// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

const asignadoA = document.querySelector('#asignadoA');
const mediaOT = document.querySelector('#mediaOT');
const dataMaterialesOT = document.querySelector('#dataMaterialesOT');
const comentarioOT = document.querySelector('#comentarioOT');

function validarOT() {
    let URL = window.location.hash;
    const idOT = URL.replace(/#|T|F|E|/gi, '');

    if (idOT > 0) {
        if (URL[1] == "T") {
            generarOT(idOT, 'TAREA');
        } else if (URL[1] == "F") {
            generarOT(idOT, 'FALLA');
        } else if (URL[1] == "E") {
            generarOT(idOT, 'ENERGETICO');
        }
        alertaImg('Generando OT #' + idOT, '', 'success', 1500);
    } else {
        alertaImg('No se Encontro #' + idOT, '', 'success', 1500);
    }
}


// GENERA OT
function generarOT(idOT, tipo) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "generarOT";
    const URL = `php/ot_fallas_tareas.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idOT=${idOT}&tipo=${tipo}`;

    fetch(URL)
        .then((array) => array.json())
        .then(array => {
            asignadoA.innerHTML = 'NOMBRE Y FIRMA';
            mediaOT.innerHTML = '';
            dataMaterialesOT.innerHTML = '';
            comentarioOT.innerHTML = '';
            return array;
        })
        .then(array => {

            if (array) {
                let tipo = '';
                if (array.datos.tipo == "FALLA") {
                    tipo = `INCIDENCIA: ${array.datos.tipoIncidencia}`;
                } else if (array.datos.tipo == "TAREA") {
                    tipo = `INCIDENCIA GENERAL: ${array.datos.tipoIncidencia}`;
                } else if (array.datos.tipo == "ENERGETICO") {
                    tipo = `ENERGETICO: ${array.datos.tipoIncidencia}`;
                }

                document.getElementById("idOTQR").innerHTML = array.datos.idOT;
                document.getElementById("numeroQR").innerHTML = array.datos.idOT;
                document.getElementById("numeroOT").innerHTML = 'OT NÚMERO #' + array.datos.idOT;
                document.getElementById("destinoOT").innerHTML = array.datos.destino;
                document.getElementById("rangoFecha").
                    innerHTML = ' <i class="fas fa-calendar-alt pl-1"></i> ' + array.datos.rangoFecha;

                if (array.datos.seccion == "ENERGETICOS") {
                    document.getElementById("seccionOT").innerHTML = '<i class="fas fa-plug"></i>';
                } else {
                    document.getElementById("seccionOT").innerHTML = array.datos.seccion;
                }

                document.getElementById("logoClassOT").className = '';
                document.getElementById("logoClassOT").
                    classList.add('relative', array.datos.seccion.toLowerCase() + '-logo');

                document.getElementById("subseccionOT").innerHTML = array.datos.subseccion;
                document.getElementById("tipoMantenimientoOT").innerHTML = tipo;
                document.getElementById("equipoOT").innerHTML = array.datos.equipo;
                document.getElementById("tipoMatenimiento2OT").innerHTML = array.datos.actividad;

                document.getElementById("statusOT").innerHTML = array.datos.status;
                document.getElementById("statusOT").classList.add('bg-red');

                asignadoA.innerHTML = array.datos.responsable;

                // ADJUNTOS
                if (array.datos.adjuntos) {
                    for (let x = 0; x < array.datos.adjuntos.length; x++) {
                        const idAdjunto = array.datos.adjuntos[x].idAdjunto;
                        const url = array.datos.adjuntos[x].url;
                        const tipo = array.datos.adjuntos[x].tipo;
                        const codigo = `<a href="${url}" target="_blank" class="pb-1">
                        <img src="${url}" class="w-20 h-20 rounded"></a>`;
                        if (tipo == "png" || tipo == "jpeg" || tipo == "gif" || tipo == "jpg") {
                            mediaOT.insertAdjacentHTML('beforeend', codigo);
                        }
                    }
                }

                // ACTIVIDADES
                if (array.actividades) {
                    for (let x = 0; x < array.actividades.length; x++) {
                        const actividad = array.actividades[x].actividad;
                        const status = array.actividades[x].status;

                        if (status == 'PENDIENTE') {
                            var actividadHTML = `
                            <div class="p-2 rounded font-semibold flex items-center justify-start bg-red-100 text-red-500 cursor-pointer mb-1">
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-red-600">
                                </div>
                                <div class="w-full text-justify">
                                    <h1>${actividad}</h1>
                                </div>
                            </div>
                        `;

                        } else {
                            var actividadHTML = `
                            <div class="p-2 rounded font-semibold flex items-center justify-start bg-green-100 text-green-500 cursor-pointer mb-1">
                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center mr-2 flex-none border-green-600">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="w-full text-justify">
                                    <h1>${actividad}</h1>
                                </div>
                            </div>
                        `;
                        }
                        document.getElementById("dataActividades").
                            insertAdjacentHTML('beforeend', actividadHTML);
                    }
                }

                // MATERIALES
                if (array.datos.materiales) {
                    for (let x = 0; x < array.datos.materiales.length; x++) {
                        const cod2bend = array.datos.materiales[x].cod2bend;
                        const cantidad = array.datos.materiales[x].cantidad;
                        const descripcion = array.datos.materiales[x].descripcion;
                        const codigo = `
                            <tr class="hover:bg-gray-200 cursor-pointer text-xs font-normal">
                                <td class="border-b border-gray-200 uppercase text-center px-1 w-16"
                                data-title-material="${cod2bend}">
                                    <h1 class="truncate w-16 text-xxs">${cod2bend}</h1>
                                </td>
                                <td class="border-b border-gray-200 uppercase text-center px-1 w-8"
                                 data-title-material="${cantidad}">
                                    <h1 class="truncate w-8">${cantidad}</h1>
                                </td>
                                <td class="border-b border-gray-200 uppercase text-center px-1 w-48"
                                 data-title-material="${descripcion}">
                                    <h1 class="truncate w-48 text-xxs text-left">${descripcion}</h1>
                                </td>
                            </tr>`;
                        dataMaterialesOT.insertAdjacentHTML('beforeend', codigo);
                    }
                }

                // COMENTARIO 
                if (array.datos.comentario) {
                    comentarioOT.innerHTML = array.datos.comentario;
                }
            }
        })
        .catch(function (err) {
            mediaOT.innerHTML = '';
            asignadoA.innerHTML = 'NOMBRE Y FIRMA';
            dataMaterialesOT.innerHTML = '';
            alertaImg('No se Encontro OT #' + idOT, '', 'success', 1500);
            fetch(APIERROR + err + ` generarOT(${idOT}, ${tipo})`);
        })
}


// Función Inicial
validarOT();