'use strict'

//Variables Globales.
let idDestino = localStorage.getItem('idDestino');
let idUsuario = localStorage.getItem('usuario');

const $tablaPlanesDeMantto = document.getElementById('contenedorDePlanes');
const datosPlanes = params => {
    var marca = params.marca;
    var plan = params.tipoPlan;
    var grado = params.grado;
    var claseMarca = ';'
    var clasePlan = ';'
    var claseGrado = ';'

    switch (marca) {
        case 'GP':
            claseMarca = 'bg-amber-300 text-amber-800';
            break;
        case 'TRS':
            claseMarca = 'bg-bluegray-200 text-bluegray-900';
            break;
        case 'FS':
            claseMarca = 'bg-amber-300 text-amber-800';
            break;
        case 'ZI':
            claseMarca = 'bg-bluegray-800 text-white';
            break;
        default:
            claseMarca = 'bg-gray-200 text-bluegray-800';
    }

    switch (plan) {
        case 'PREVENTIVO':
            clasePlan = 'bg-blue-100 text-blue-500';
            break;
        case 'CHECKLIST':
            clasePlan = 'bg-purple-100 text-purple-500';
            break;
        case 'TEST':
            clasePlan = 'bg-red-100 text-red-500';
            break;
        default:
            clasePlan = 'bg-gray-100 text-bluegray-800';
    }

    switch (grado) {
        case 'MENOR':
            claseGrado = 'bg-orange-200 text-orange-500';
            break;
        case 'MAYOR':
            claseGrado = 'bg-red-200 text-red-500';
            break;
        case 'OVERHAUL':
            claseGrado = 'bg-bluegray-200 text-bluegray-900';
            break;
        default:
            claseGrado = 'bg-gray-200 text-bluegray-800';
    }
    return `
        <tr class="animate__pulse hover:bg-fondos-4 cursor-pointer" onclick="obtenerDetallesPlanMP(${params.idPlanMP})">
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 uppercase font-semibold">
                ${params.destino}
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <span class="px-4 inline-flex text-xs leading-5 font-bold rounded-full ${claseMarca} uppercase">
                    ${params.marca}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 uppercase font-semibold">
                ${params.tipoEquipo}
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full ${clasePlan} uppercase">
                    ${params.tipoPlan}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <span class="px-2 inline-flex text-xs leading-5 font-bold rounded-full ${claseGrado} uppercase">
                    ${params.grado}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 uppercase font-semibold">
                ${params.periodicidad}
            </td>
        </tr>
    `;
};


// Funcion Global para Modales.
function toggleModalTailwind(idModal) {
    document.getElementById(idModal).classList.toggle('open');
}


// Funcion Global para Modales.
function showInfoPlanMP() {
    document.getElementById("infoActividadPlanMP").classList.toggle('hidden');
}


function obtenerPlanesMP(tipoOrden) {

    document.getElementById('contenedorDePlanes').innerHTML = '';
    let palabraBuscar = document.getElementById("buscarPlanMP").value;
    // console.log(palabraBuscar);
    const action = "obtenerPlanesMP";
    $.ajax({
        type: "POST",
        url: "php/planes_mantenimiento_crud.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario,
            palabraBuscar: palabraBuscar,
            tipoOrden: tipoOrden
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            data.forEach(element => {
                // console.log(element);
               
                setTimeout(function () { $tablaPlanesDeMantto.innerHTML += datosPlanes(element); }, 90);
            });



        }
    });
}


// Funcion para Buscar las posibles opciones Generales de un Plan MP.
function obtenerOpcionesPlanMP() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerOpcionesPlanMP";
    $.ajax({
        type: "POST",
        url: "php/planes_mantenimiento_crud.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataOptionDestinosMP").innerHTML = data.dataDestinos;
            document.getElementById("dataOpcionFaseMP").innerHTML = data.dataFases;
            document.getElementById("dataOpcionTipoEquiposMP").innerHTML = data.dataTipos;
            document.getElementById("dataOpcionFrecuenciaMP").innerHTML = data.dataFrecuencia;
        }
    });
}



// Funcion para Agregar un Plan MP.
function AgregarPlanMP() {
    // console.log('AgregarPlanMP');
    obtenerOpcionesPlanMP();
    document.getElementById("modalDetallesPlanMP").classList.add('open');
    alertaImg(' Debe contener al menos una ACTIVIDAD', '', 'question', 9000);

    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "AgregarPlanMP";
    $.ajax({
        type: "POST",
        url: "php/planes_mantenimiento_crud.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario
        },
        // dataType: "JSON",
        success: function (data) {
            // console.log('Data: ', data);
            if (data > 0) {
                localStorage.setItem('idPlanMP', data);
                obtenerDetallesPlanMP(data);
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 2500);
            }
        }
    });
}


// Funcion para obtener detalles de un plan MP al darle clic en la lista.
function obtenerDetallesPlanMP(idPlanMP) {
    // Operaciones Iniciales.
    localStorage.setItem('idPlanMP', idPlanMP);
    document.getElementById("modalDetallesPlanMP").classList.add('open');
    alertaImg(' Debe contener al menos una ACTIVIDAD', '', 'question', 5000);
    obtenerOpcionesPlanMP();

    // Datos Basicos.
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerDetallesPlanMP";
    $.ajax({
        type: "POST",
        url: "php/planes_mantenimiento_crud.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario,
            idPlanMP: idPlanMP
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("dataActividadesPlanMP").innerHTML = data.dataActividades;
            document.getElementById("dataOptionDestinosMP").value = data.idDestino;
            document.getElementById("dataOpcionFaseMP").value = data.idFase;
            document.getElementById("equipoLocalPlanMP").value = data.local_equipo;
            document.getElementById("dataOpcionTipoPlan").value = data.tipoPlan;
            document.getElementById("dataOpcionGradoPlanMP").value = data.grado;
            document.getElementById("dataOpcionTipoEquiposMP").value = data.tipo_local_equipo;
            document.getElementById("dataOpcionFrecuenciaMP").value = data.idPeriodicidad;
            document.getElementById("dataObservacionesPlanMP").value = data.descripcion;
            document.getElementById("dataPersonasPlanMP").value = data.personas;
        }
    });
}


// Función para Guardar Cambios Ó Desactivar el Plan.
function guardarCambiosPlanMP(status) {

    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let idPlanMP = localStorage.getItem('idPlanMP');

    let idDestinoSeleccionado = document.getElementById("dataOptionDestinosMP").value;
    let opcionFase = document.getElementById("dataOpcionFaseMP").value;
    let localEquipo = document.getElementById("equipoLocalPlanMP").value;
    let tipoEquipo = document.getElementById("dataOpcionTipoEquiposMP").value;
    let tipoPlan = document.getElementById("dataOpcionTipoPlan").value;
    let gradoPlan = document.getElementById("dataOpcionGradoPlanMP").value;
    let periodicidad = document.getElementById("dataOpcionFrecuenciaMP").value;
    let personas = document.getElementById("dataPersonasPlanMP").value;
    let observacion = document.getElementById("dataObservacionesPlanMP").value;

    // console.log(status, idDestinoSeleccionado, opcionFase, localEquipo, tipoEquipo, tipoPlan, gradoPlan, periodicidad, tiempoEjecucion, observacion);

    function limpiarCamposPlanMP() {
        document.getElementById("dataOptionDestinosMP").value = '';
        document.getElementById("dataOpcionFaseMP").value = '';
        document.getElementById("equipoLocalPlanMP").value = '';
        document.getElementById("dataOpcionTipoEquiposMP").value = '';
        document.getElementById("dataOpcionTipoPlan").value = '';
        document.getElementById("dataOpcionGradoPlanMP").value = '';
        document.getElementById("dataOpcionFrecuenciaMP").value = '';
        document.getElementById("dataPersonasPlanMP").value = '';
        document.getElementById("dataObservacionesPlanMP").value = '';
        document.getElementById("modalDetallesPlanMP").classList.remove('open');
    }

    if (status != '' && idDestinoSeleccionado != '') {
        const action = "guardarCambiosPlanMP";
        $.ajax({
            type: "POST",
            url: "php/planes_mantenimiento_crud.php",
            data: {
                action: action,
                status: status,
                idDestino: idDestino,
                idUsuario: idUsuario,
                idPlanMP: idPlanMP,
                idDestinoSeleccionado: idDestinoSeleccionado,
                opcionFase: opcionFase,
                localEquipo: localEquipo,
                tipoEquipo: tipoEquipo,
                tipoPlan: tipoPlan,
                gradoPlan: gradoPlan,
                periodicidad: periodicidad,
                personas: personas,
                observacion: observacion
            },
            dataType: "JSON",
            success: async function (data) {
                // console.log(data);
                if (data.respuesta == 1) {
                    alertaImg('Plan Actualizado', '', 'success', 2500);
                    localStorage.setItem('idPlanMP', 0);
                    await limpiarCamposPlanMP();
                    await obtenerPlanesMP('ORDENID');
                } else if (data.respuesta == 2) {
                    alertaImg('Plan Desactivado', '', 'info', 2500);
                    await localStorage.setItem('idPlanMP', 0);
                    await limpiarCamposPlanMP();
                    obtenerPlanesMP('ORDENID');
                } else if (data.respuesta == 0) {
                    alertaImg('Intente de Nuevo', '', 'error', 2500);
                }
            }
        });
    } else {
        alertaImg('Información NO Valida', '', 'question', 2500);
    }
}

// Función para Ocultar Boton Desactivar y Agregar funcion Agregar..();
function ocultarContenidoActividadMP() {
    document.getElementById("modalAgregarActividadMP").classList.add('open');
    document.getElementById("actualizarActividadPlanMP").innerHTML = "AGREGAR ACTIVIDAD";
    document.getElementById("actualizarActividadPlanMP").setAttribute('onclick', 'agregarActividadPlanMP();');
    document.getElementById("desactivarActividadPlanMP").classList.add('invisible');

}


// Función para Agregar Activiades a Plan Accion Seleccionado localstorage('idPlanMP').
function agregarActividadPlanMP() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let idPlanMP = localStorage.getItem('idPlanMP');
    let actividadPlan = document.getElementById("actividadPlanMP").value;
    let tipoActividadPlan = document.getElementById("tipoActividadPlanMP").value;
    let tiempoActividad = document.getElementById("dataTiempoActividadPlanMP").value;

    if (actividadPlan.length > 0 && tipoActividadPlan.length > 0) {
        const action = "agregarActividadPlanMP";
        $.ajax({
            type: "POST",
            url: "php/planes_mantenimiento_crud.php",
            data: {
                action: action,
                idDestino: idDestino,
                idUsuario: idUsuario,
                idPlanMP: idPlanMP,
                actividadPlan: actividadPlan,
                tipoActividadPlan: tipoActividadPlan,
                tiempoActividad: tiempoActividad
            },
            dataType: "JSON",
            success: function (data) {
                // console.log(data);
                if (data.resultado == 1) {
                    obtenerDetallesPlanMP(idPlanMP);
                    document.getElementById("modalAgregarActividadMP").classList.remove('open');
                    document.getElementById("actividadPlanMP").value = '';

                    alertaImg('Actividad Agregada', '', 'success', 3000);
                } else if (data.resultado == 2) {
                    alertaImg('Actividad Repetida', '', 'question', 3000);
                } else {
                    alertaImg('Intente de Nuevo', '', 'error', 3000);
                }
            }
        });
    } else {
        alertaImg('Información NO Valida', '', 'question', 3000);
    }
}


// Obtiene la información de cada Actividad.
function obtenerActividadPlanMP(idActividadMP, tipoActividad) {
    document.getElementById("modalAgregarActividadMP").classList.add('open');
    document.getElementById("actualizarActividadPlanMP").innerHTML = "ACTUALIZAR CAMBIOS";
    document.getElementById("desactivarActividadPlanMP").classList.remove('invisible');
    // console.log(idActividadMP, tipoActividad);
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const action = "obtenerActividadPlanMP";

    $.ajax({
        type: "POST",
        url: "php/planes_mantenimiento_crud.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario,
            idActividadMP: idActividadMP,
            tipoActividad: tipoActividad
        },
        dataType: "JSON",
        success: function (data) {
            // console.log(data);
            document.getElementById("actividadPlanMP").value = data.actividad;
            document.getElementById("tipoActividadPlanMP").value = data.tipoActividad;
            document.getElementById("dataTiempoActividadPlanMP").value = data.promedio;
            document.getElementById("actualizarActividadPlanMP").setAttribute('onclick', 'actualizarActividadPlanMP("ACTIVO",' + data.idPlanMP + ', ' + data.idActividad + ', "' + data.tipoActividad + '");');
            document.getElementById("desactivarActividadPlanMP").setAttribute('onclick', 'actualizarActividadPlanMP("BAJA",' + data.idPlanMP + ', ' + data.idActividad + ', "' + data.tipoActividad + '");');
        }
    });
}


// Actualiza Ó Desactiva la Actividad.
function actualizarActividadPlanMP(tipoActualizacion, idPlanMP, idActividadPlanMP, tipoActividad) {

    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let actividadPlan = document.getElementById("actividadPlanMP").value;
    let tipoActividadNuevo = document.getElementById("tipoActividadPlanMP").value;
    let tiempoActividad = document.getElementById("dataTiempoActividadPlanMP").value;
    const action = "actualizarActividadPlanMP";

    $.ajax({
        type: "POST",
        url: "php/planes_mantenimiento_crud.php",
        data: {
            action: action,
            idDestino: idDestino,
            idUsuario: idUsuario,
            tipoActualizacion: tipoActualizacion,
            idPlanMP: idPlanMP,
            idActividadPlanMP: idActividadPlanMP,
            tipoActividad: tipoActividad,
            actividadPlan: actividadPlan,
            tipoActividadNuevo: tipoActividadNuevo,
            tiempoActividad: tiempoActividad
        },
        // dataType: "JSON",
        success: function (data) {
            // console.log(data);
            if (data = 1) {
                document.getElementById("modalAgregarActividadMP").classList.remove('open');
                document.getElementById("actualizarActividadPlanMP").setAttribute('onclick', 'agregarActividadPlanMP();');
                document.getElementById("desactivarActividadPlanMP").setAttribute('onclick', '');
                obtenerDetallesPlanMP(idPlanMP);
                alertaImg('Actividad Actualiza', '', 'success', 2000);
            } else if (data == 2) {
                alertaImg('Tipo Actividad, Actualiza', '', 'success', 2000);
                document.getElementById("modalAgregarActividadMP").classList.remove('open');
                document.getElementById("actualizarActividadPlanMP").setAttribute('onclick', 'agregarActividadPlanMP();');
                document.getElementById("desactivarActividadPlanMP").setAttribute('onclick', '');
                obtenerDetallesPlanMP(idPlanMP);
            } else if (data == 0) {
                alertaImg('Intente de Nuevo', '', 'error', 2500);
            }
        }
    });
}


// Funciones Iniciales:
obtenerPlanesMP('SINORDEN');