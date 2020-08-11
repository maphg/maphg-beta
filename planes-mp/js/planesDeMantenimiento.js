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
    //${claseMarca} ${params.status}
    //${params.urlfoto}
    return `
        <tr class="hover:bg-fondos-4 cursor-pointer"
        onclick="obtenerDetallesPlanMP(${params.idPlanMP});">
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

$tablaPlanesDeMantto.innerHTML += datosPlanes({ idPlanMP: 10, destino: 'rm', marca: 'ZI', tipoEquipo: 'Fan&coil', tipoPlan: 'PREVENTIVO', grado: 'MAYOR', periodicidad: 'Semestral' });

$tablaPlanesDeMantto.innerHTML += datosPlanes({ idPlanMP: 20, destino: 'rm', marca: 'FS', tipoEquipo: 'Junnior Suite', tipoPlan: 'CHECKLIST', grado: 'MENOR', periodicidad: 'Semestral' });

$tablaPlanesDeMantto.innerHTML += datosPlanes({ idPlanMP: 30, destino: 'rm', marca: 'GP', tipoEquipo: 'Fan&coil', tipoPlan: 'TEST', grado: 'OVERHAUL', periodicidad: 'Semestral' });

$tablaPlanesDeMantto.innerHTML += datosPlanes({ idPlanMP: 40, destino: 'rm', marca: 'TRS', tipoEquipo: 'Junnior Suite', tipoPlan: 'PREVENTIVO', grado: 'MAYOR', periodicidad: 'Semestral' });



// Funcion Global para Modales.
function toggleModalTailwind(idModal) {
    document.getElementById(idModal).classList.toggle('open');
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



// Funcion para obtener detalles de un plan MP al darle clic en la lista.
function obtenerDetallesPlanMP(idPlanMP) {
    // Operaciones Iniciales.
    localStorage.setItem('idPlanMP', idPlanMP);
    document.getElementById("modalDetallesPlanMP").classList.add('open');
    alertaImg(' Debe contener al menos una ACTIVIDAD', '', 'question', 9000);
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
            console.log(data);
            document.getElementById("dataActividadesPlanMP").innerHTML = data.dataActividades;
            document.getElementById("dataOptionDestinosMP").value = data.idDestino;
            document.getElementById("dataOpcionFaseMP").value = data.idFase;
            document.getElementById("equipoLocalPlanMP").value = data.local_equipo;
            document.getElementById("dataOpcionTipoEquiposMP").value = data.tipo_local_equipo;
            document.getElementById("dataOpcionFrecuenciaMP").value = data.idPeriodicidad;
        }
    });
}


// Funcion para Agregar un Plan MP.
function AgregarPlanMP() {
    obtenerOpcionesPlanMP();
    document.getElementById("modalDetallesPlanMP").classList.add('open');
    alertaImg(' Debe contener al menos una ACTIVIDAD', '', 'question', 9000);
    obtenerOpcionesPlanMP();

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
        dataType: "JSON",
        success: function (data) {
            localStorage.setItem('idPlanMP', data.idPlanMP);
            obtenerDetallesPlanMP(data.idPlanMP);
        }
    });
}


// Función para Agregar Activiades a Plan Accion Seleccionado localstorage('idPlanMP').
function agregarActividadPlanMP() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    let idPlanMP = localStorage.getItem('idPlanMP');
    let actividadPlan = document.getElementById("actividadPlanMP").value;
    let tipoActividadPlan = document.getElementById("tipoActividadPlanMP").value;

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
                tipoActividadPlan: tipoActividadPlan
            },
            dataType: "JSON",
            success: function (data) {
                console.log(data);
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