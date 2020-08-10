'use strict'

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
        <tr class="hover:bg-fondos-4 cursor-pointer" onclick="openmodal('modal-detallesDelPlan')">
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

$tablaPlanesDeMantto.innerHTML += datosPlanes({ destino: 'rm', marca: 'ZI', tipoEquipo: 'Fan&coil', tipoPlan: 'PREVENTIVO', grado: 'MAYOR', periodicidad: 'Semestral' }, { destino: 'rm', marca: 'ZI', tipoEquipo: 'Fan&coil', tipoPlan: 'PREVENTIVO', grado: 'MAYOR', periodicidad: 'Semestral' });
$tablaPlanesDeMantto.innerHTML += datosPlanes({ destino: 'rm', marca: 'FS', tipoEquipo: 'Junnior Suite', tipoPlan: 'CHECKLIST', grado: 'MENOR', periodicidad: 'Semestral' });

$tablaPlanesDeMantto.innerHTML += datosPlanes({ destino: 'rm', marca: 'GP', tipoEquipo: 'Fan&coil', tipoPlan: 'TEST', grado: 'OVERHAUL', periodicidad: 'Semestral' });
$tablaPlanesDeMantto.innerHTML += datosPlanes({ destino: 'rm', marca: 'TRS', tipoEquipo: 'Junnior Suite', tipoPlan: 'PREVENTIVO', grado: 'MAYOR', periodicidad: 'Semestral' });


