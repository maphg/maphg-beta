'use strict'

const $tablaPlanesDeMantto = document.getElementById('contenedorDePlanes');
const datosPlanes = params => {
    var status = params.status;
    var claseStatus = ';'
    var claseequipoLocal = ';'
    var equipoLocal = params.equipoLocal;
    var icono = "fad fa-dot-circle"



    switch (status) {
        case 'OPERATIVO':
            claseStatus = 'bg-green-200 text-green-500';
            break;
        case 'TALLER':
            claseStatus = 'bg-orange-200 text-orange-500';
            break;
        case 'BAJA':
            claseStatus = 'bg-red-200 text-red-500';
            break;
        default:
            claseStatus = 'bg-gray-100 text-bluegray-800';
    }

    switch (equipoLocal) {
        case 'EQUIPO':
            claseequipoLocal = 'text-blue-500';
            icono = "fas fa-cog"
            break;
        case 'LOCAL':
            claseequipoLocal = 'text-purple-500';
            icono = "fas fa-home-lg"
            break;

        default:
            claseequipoLocal = ' text-bluegray-800';
            icono = "fad fa-dot-circle";
    }

    return `
        <tr id="equipo_${params.id}" class="hover:bg-fondos-4 cursor-pointer text-xs" onclick="openmodal('modal-detallesDelPlan','${params.id}')">
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                <div class=" leading-5 text-gray-900 font-bold">${params.destino}</div>
                <div class=" leading-5 text-gray-500">${params.marca}</div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                ${params.seccion}
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                ${params.subseccion}
            </td>
            
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                <div class=" leading-5 text-gray-900">${params.equipo}</div>
                <div class=" leading-5 text-gray-500">ID ${params.id}</div>
            </td> 
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                <div class=" leading-5 text-gray-900">${params.tipoEquipo}</div>
                <div class=" leading-5 ${claseequipoLocal}"><i class="${icono} mr-2"></i>${params.equipoLocal}</div>
            </td>           
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                <div class=" leading-5 text-gray-900">${params.marcaEquipo}</div>
                <div class=" leading-5 text-gray-500">MOD ${params.modelo}</div>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                ${params.ubicacion}
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <span class="px-2 inline-flex  leading-5 font-bold rounded-full ${claseStatus} uppercase">
                    ${params.status}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                <span class="px-2 inline-flex  leading-5 font-bold rounded-full ${claseStatus} uppercase">
                    ${params.ultimoMP}
                </span>
            </td>
        </tr>
        `;
};

$tablaPlanesDeMantto.innerHTML += datosPlanes({ id: '5678', destino: 'rm', equipo: 'FAN&COIL HABITACION 1040', seccion: 'ZIC', subseccion: 'FAN&COILS', marca: 'ZI', tipoEquipo: 'Fan&coil', status: 'OPERATIVO', marcaEquipo: 'MARCA', modelo: 'MODELO', equipoLocal: 'EQUIPO', ubicacion: 'Habitacion 1104', ultimoMP: '2(X)' });

$tablaPlanesDeMantto.innerHTML += datosPlanes({ id: '76856', destino: 'rm', equipo: 'FAN&COIL HABITACION 1040', seccion: 'ZIC', subseccion: 'FAN&COILS', marca: 'FS', tipoEquipo: 'Junnior Suite', status: 'TALLER', marcaEquipo: 'MARCA', modelo: 'MODELO', equipoLocal: 'EQUIPO', ubicacion: 'Habitacion 1104', ultimoMP: '2(X)' });

$tablaPlanesDeMantto.innerHTML += datosPlanes({ id: '234', destino: 'rm', equipo: 'FAN&COIL HABITACION 1040', seccion: 'ZIC', subseccion: 'FAN&COILS', marca: 'GP', tipoEquipo: 'Fan&coil', status: 'BAJA', marcaEquipo: 'MARCA', modelo: 'MODELO', equipoLocal: 'EQUIPO', ubicacion: 'Habitacion 1104', ultimoMP: '2(X)' });

$tablaPlanesDeMantto.innerHTML += datosPlanes({ id: '3425', destino: 'rm', equipo: 'FAN&COIL HABITACION 1040', seccion: 'ZIC', subseccion: 'FAN&COILS', marca: 'TRS', tipoEquipo: 'Junnior Suite', status: 'OPERATIVO', marcaEquipo: 'MARCA', modelo: 'MODELO', equipoLocal: 'LOCAL', ubicacion: 'Habitacion 1104', ultimoMP: '2(X)' });


// Función para Consultar Equipos.
function consultaEquiposLocales() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    // Datos para Aplicar los Filtros
    let filtroDestino = document.getElementById("filtroDestino").value;
    let filtroSeccion = document.getElementById("filtroSeccion").value;
    let filtroSubseccion = document.getElementById("filtroSubseccion").value;
    let filtroTipo = document.getElementById("filtroTipo").value;
    let filtroStatus = document.getElementById("filtroStatus").value;
    let filtroPalabra = document.getElementById("filtroPalabra").value;
    const action = "consultaEquiposLocales";

    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&filtroDestino=${filtroDestino}&filtroSeccion=${filtroSeccion}&filtroSubseccion=${filtroSubseccion}&filtroTipo=${filtroTipo}&filtroStatus=${filtroStatus}&filtroPalabra=${filtroPalabra}`;

    console.log(URL);
    // limpia el contendor, para nuevo resultado
    document.getElementById('contenedorDePlanes').innerHTML = '';
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            if (array.length > 0) {
                alertaImg(`Equipos Obtenidos: ${array.length}`, '', 'info', 2000);

                for (let index = 0; index < array.length; index++) {
                    $tablaPlanesDeMantto.innerHTML += datosPlanes({
                        id: array[index].id,
                        destino: array[index].destino,
                        equipo: array[index].equipo,
                        seccion: array[index].seccion,
                        subseccion: array[index].subseccion,
                        marca: array[index].marca,
                        tipoEquipo: array[index].tipoEquipo,
                        status: array[index].status,
                        marcaEquipo: array[index].marcaEquipo,
                        modelo: array[index].modelo,
                        equipoLocal: array[index].equipoLocal,
                        ubicacion: array[index].ubicacion,
                        ultimoMP: array[index].ultimoMP
                    });
                }
            } else {
                alertaImg('Equipos Obtenidos: 0', '', 'info', 3000)
            }
        });
}


// ********** FILTROS PARA EQUIPOS **********

// Genera las 52 Semanas de Año para los MP
function generar52Semnas() {
    var opcionesSemanas = `<option value="0">Semanas </option>`;

    for (let index = 1; index <= 52; index++) {
        opcionesSemanas += `<option value="${index}">Semana ${index}</option>`;
    }
    document.getElementById("filtroSemana").innerHTML = opcionesSemanas;
}


//Consulta Destinos, Disponibles 
function consultarDestinos() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = "consultarDestinos";
    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

    // limpia el contendor, para nuevo resultado
    document.getElementById('filtroDestino').innerHTML = '';

    // Fetch ASYC
    fetch(URL)
        .then(res => res.json())
        .then(array => {
            let opcionDestinos = `<option value="0">Destinos </option>`;
            for (let index = 0; index < array.length; index++) {
                opcionDestinos += `<option value="${array[index].id}">${array[index].destino}</option>`;
            }
            return opcionDestinos;
        }).then(opcionDestinos => {
            document.getElementById("filtroDestino").innerHTML = opcionDestinos;
        });
}


//Consulta Secciones->Subsecciones, Disponibles 
function consultarSecciones() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = "consultarSecciones";
    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`;

    // limpia el contendor, para nuevo resultado
    document.getElementById('filtroSeccion').innerHTML = '';

    fetch(URL)
        .then(res => res.json())
        .then(array => {
            let opcionSecciones = `<option value="0">Secciones </option>`;
            for (let index = 0; index < array.length; index++) {
                opcionSecciones += `<option value="${array[index].id}">${array[index].seccion}</option>`;
            }
            return opcionSecciones;
        }).then(opcionSecciones => {
            document.getElementById("filtroSeccion").innerHTML = opcionSecciones;
        });
}


//Consulta Secciones->Subsecciones, Disponibles 
function consultarSubsecciones() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSeccion = document.getElementById("filtroSeccion").value;
    const action = "consultarSubsecciones";
    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}`;

    console.log(URL);

    // limpia el contendor, para nuevo resultado
    document.getElementById("filtroSubseccion").innerHTML = '';
    if (idSeccion > 0) {
        fetch(URL)
            .then(res => res.json())
            .then(array => {
                let opcionSubsecciones = `<option value="0">Subsecciones </option>`;
                for (let index = 0; index < array.length; index++) {
                    opcionSubsecciones += `<option value="${array[index].id}">${array[index].subseccion}</option>`;
                }
                return opcionSubsecciones;
            }).then(opcionSubsecciones => {
                document.getElementById("filtroSubseccion").innerHTML = opcionSubsecciones;
            });
    } else {
        alertaImg('Sección, Sin Subsecciones Asignadas', '', 'warning', 2500);
    }
}

// ********** FILTROS PARA EQUIPOS **********



// Funciones Generales
function openmodal(modal) {
    var abrirmodal = document.getElementById(modal);
    abrirmodal.classList.add("open");
}

function cerrarmodal(idmodal) {
    var cerrarr = document.getElementById(idmodal);
    cerrarr.classList.remove('open');
};



// Función inicial para mostrar información de Equipos (t_equipos_america).
consultaEquiposLocales();

// Funciones para los Filtros
generar52Semnas();
consultarDestinos();
consultarSecciones();
document.getElementById("filtroSeccion").addEventListener("change", consultarSubsecciones);


// Aplica Filtros Seleccionados
document.getElementById("filtroDestino").addEventListener("change", consultaEquiposLocales);
document.getElementById("filtroSubseccion").addEventListener("change", consultaEquiposLocales);
document.getElementById("filtroTipo").addEventListener("change", consultaEquiposLocales);
document.getElementById("filtroStatus").addEventListener("change", consultaEquiposLocales);
document.getElementById("filtroPalabra").addEventListener("keydown", consultaEquiposLocales);

