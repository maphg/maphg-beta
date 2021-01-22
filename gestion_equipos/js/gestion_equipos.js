'use strict';

// INPUTS POR ID
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

// INPUTS POR ID


// API PARA REPORTE DE ERRORES
const APIERROR = 'https://api.telegram.org/bot1396322757:AAF5C0bcZxR8_mEEtm3BFEJGhgHvLcE3X_E/sendMessage?chat_id=989320528&text=Error: ';

const datosPlanes = params => {
    var idEquipo = params.idEquipo;
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

    if (params.planificado > 0) {
        var planificado = `
            <div class="programado-PLANIFICADO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                <h1>${params.planificado}</h1>
            </div>
        `;
    } else {
        var planificado = "";
    }

    if (params.proceso > 0) {
        var proceso = `
            <div class="status-PROCESO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                    <h1>${params.proceso}</h1>
            </div>
        `;
    } else {
        var proceso = "";
    }

    if (params.solucionado > 0) {
        var solucionado = `
            <div class="status-SOLUCIONADO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                <h1>${params.solucionado}</h1>
            </div>
        `;
    } else {
        var solucionado = "";
    }

    var result = `
            <tr id="equipo_${idEquipo}" class="hover:bg-fondos-4 cursor-pointer text-xs" 
            onclick="informacionEquipo(${idEquipo}); despieceEquipos(${idEquipo}); abrirmodal('modalMPEquipo')">

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                    <div class=" leading-5 text-gray-900 font-bold">${params.destino}</div>
                    <div class=" leading-5 text-gray-500">${params.marca}</div>
                </td>

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold w-4">
                    ${params.seccion}
                </td>

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                   <h1 class="texto-subseccion w-18" data-title="${params.subseccion}"> 
                   <p class="truncate">${params.subseccion}</p>
                   </h1>
                </td>
                
                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">
                    <div class=" leading-5 text-gray-900 w-18 texto-equipo" data-title="${params.equipo}"> <p class="truncate"> ${params.equipo}</p></div>
                    <div class=" leading-5 text-gray-500">ID: ${idEquipo}</div>
                </td> 

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">

                    <div class=" leading-5 text-gray-900 w-16" data-title="${params.tipoEquipo}">
                    <p class="truncate">${params.tipoEquipo}</p></div>

                    <div class=" leading-5 ${claseequipoLocal}"><i class="${icono} mr-2"></i>${params.equipoLocal}</div>

                </td> 

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold">

                    <div class="leading-5 text-gray-900 w-16" data-title="${params.marcaEquipo}">
                    <p class="truncate">
                    ${params.marcaEquipo}</p></div>

                    <div class="leading-5 text-gray-500 w-16" data-title="${params.modelo}">
                    <p class="truncate"> MOD: ${params.modelo}</p></div>

                </td>

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200  leading-5 uppercase font-semibold w-8" data-title="${params.ubicacion}">
                    <p class="truncate">${params.ubicacion}</p>
                </td>

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200">
                    <span class="px-2 inline-flex  leading-5 font-bold rounded-full ${claseStatus} uppercase">
                        ${params.status}
                    </span>
                </td>

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200">
                    <span class="px-2 inline-flex  leading-5 font-bold rounded-full uppercase">
                        ${params.proximoMP}
                    </span>
                </td>

                <td class="px-4 py-4 whitespace-no-wrap border-b border-gray-200">
                    <span class="px-2 inline-flex  leading-5 font-bold rounded-full uppercase">                   
                        ${planificado + proceso + solucionado} 
                    </span>
                </td>

            </tr>
        `;
    return result;
};


// const $ContenedorPlanesEquipos = document.getElementById('contenedorPlanesEquipo');
const datosPlanEquipo = params => {
    return `
        <div class="flex-none flex flex-row w-100 justify-evenly items-center flex-wrap cursor-pointer rounded-lg p-2 mr-6 border border-gray-300 my-1">

            <div class="w-full text-center font-semibold text-xs uppercase flex flex-row items-center justify-between leading-none mb-2"> 

                <div class="flex flex-col items-start">
                    <h1 class="text-lg">${params.periodicidad}</h1>
                    <h1 class="text-xs px-1 inline-flex leading-snug font-bold rounded-sm bg-red-200 text-red-500 uppercase">${params.tipoPlan}</h1>
                </div>

                <div class="flex text-xs font-bold">
                    <div class="programado-PLANIFICADO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                        <h1>${params.planificado}</h1>
                    </div>
                    <div class="status-PROCESO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                        <h1>${params.proceso}</h1>
                    </div>
                    <div class="status-SOLUCIONADO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                        <h1>${params.solucionado}</h1>
                    </div>
                    <div id="${params.idPlan + 'Actividades'}" class="mx-2 flex justify-center items-center text-xxs text-green-500 hover:text-green-400" onclick="consultarActividadesMP(${params.idPlan});">
                        <a href="#" class="text-green-500 hover:text-green-400">Ver detalles</a>
                    </div>
                </div>

            </div>     

            <div id="${params.idSemana + '_semana_1'}" aria-describedby="tooltip" class="flex items-center justify-center whc-1 programado-${params.semana_1} status-${params.proceso_1}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 1); 
            botonesMenuMP('${params.proceso_1}');">
                <h1 class="semana_1 relative">01</h1>
            </div>  

            <div id="${params.idSemana + '_semana_2'}" class="flex items-center justify-center whc-1 programado-${params.semana_2} status-${params.proceso_2}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 2); botonesMenuMP('${params.proceso_2}');">
                <h1 class="semana_2 relative">02</h1>
            </div> 

            <div id="${params.idSemana + '_semana_3'}" class="flex items-center justify-center whc-1 programado-${params.semana_3} status-${params.proceso_3}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 3); botonesMenuMP('${params.proceso_3}');">
                <h1 class="semana_3 relative">03</h1>
            </div> 

            <div id="${params.idSemana + '_semana_4'}" class="flex items-center justify-center whc-1 programado-${params.semana_4} status-${params.proceso_4}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 4); botonesMenuMP('${params.proceso_4}');">
                <h1 class="semana_4 relative">04</h1>
            </div> 

            <div id="${params.idSemana + '_semana_5'}" class="flex items-center justify-center whc-1 programado-${params.semana_5} status-${params.proceso_5}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 5); botonesMenuMP('${params.proceso_5}');">
                <h1 class="semana_5 relative">05</h1>
            </div> 

            <div id="${params.idSemana + '_semana_6'}" class="flex items-center justify-center whc-1 programado-${params.semana_6} status-${params.proceso_6}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 6); botonesMenuMP('${params.proceso_6}');">
                <h1 class="semana_6 relative">06</h1>
            </div> 

            <div id="${params.idSemana + '_semana_7'}" class="flex items-center justify-center whc-1 programado-${params.semana_7} status-${params.proceso_7}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 7); botonesMenuMP('${params.proceso_7}');">
                <h1 class="semana_7 relative">07</h1>
            </div> 

            <div id="${params.idSemana + '_semana_8'}" class="flex items-center justify-center whc-1 programado-${params.semana_8} status-${params.proceso_8}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 8); botonesMenuMP('${params.proceso_8}');">
                <h1 class="semana_8 relative">08</h1>
            </div> 

            <div id="${params.idSemana + '_semana_9'}" class="flex items-center justify-center whc-1 programado-${params.semana_9} status-${params.proceso_9}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 9); botonesMenuMP('${params.proceso_9}');">
                <h1 class="semana_9 relative">09</h1>
            </div> 

            <div id="${params.idSemana + '_semana_10'}" class="flex items-center justify-center whc-1 programado-${params.semana_10} status-${params.proceso_10}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 10); botonesMenuMP('${params.proceso_10}');">
                <h1 class="semana_10 relative">10</h1>
            </div> 

            <div id="${params.idSemana + '_semana_11'}" class="flex items-center justify-center whc-1 programado-${params.semana_11} status-${params.proceso_11}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 11); botonesMenuMP('${params.proceso_11}');">
                <h1 class="semana_11 relative">11</h1>
            </div> 
            
            <div id="${params.idSemana + '_semana_12'}" class="flex items-center justify-center whc-1 programado-${params.semana_12} status-${params.proceso_12}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 12); botonesMenuMP('${params.proceso_12}');">
                <h1 class="semana_12 relative">12</h1>
            </div> 

            <div id="${params.idSemana + '_semana_13'}" class="flex items-center justify-center whc-1 programado-${params.semana_13} status-${params.proceso_13}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 13); botonesMenuMP('${params.proceso_13}');">
                <h1 class="semana_13 relative">13</h1>
            </div> 

            <div id="${params.idSemana + '_semana_14'}" class="flex items-center justify-center whc-1 programado-${params.semana_14} status-${params.proceso_14}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 14); botonesMenuMP('${params.proceso_14}');">
                <h1 class="semana_14 relative">14</h1>
            </div> 

            <div id="${params.idSemana + '_semana_15'}" class="flex items-center justify-center whc-1 programado-${params.semana_15} status-${params.proceso_15}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 15); botonesMenuMP('${params.proceso_15}');">
                <h1 class="semana_15 relative">15</h1>
            </div> 

            <div id="${params.idSemana + '_semana_16'}" class="flex items-center justify-center whc-1 programado-${params.semana_16} status-${params.proceso_16}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 16); botonesMenuMP('${params.proceso_16}');">
                <h1 class="semana_16 relative">16</h1>
            </div> 

            <div id="${params.idSemana + '_semana_17'}" class="flex items-center justify-center whc-1 programado-${params.semana_17} status-${params.proceso_17}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 17); botonesMenuMP('${params.proceso_17}');">
                <h1 class="semana_17 relative">17</h1>
            </div> 

            <div id="${params.idSemana + '_semana_18'}" class="flex items-center justify-center whc-1 programado-${params.semana_18} status-${params.proceso_18}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 18); botonesMenuMP('${params.proceso_18}');">
                <h1 class="semana_18 relative">18</h1>
            </div> 

            <div id="${params.idSemana + '_semana_19'}" class="flex items-center justify-center whc-1 programado-${params.semana_19} status-${params.proceso_19}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 19); botonesMenuMP('${params.proceso_19}');">
                <h1 class="semana_19 relative">19</h1>
            </div> 

            <div id="${params.idSemana + '_semana_20'}" class="flex items-center justify-center whc-1 programado-${params.semana_20} status-${params.proceso_20}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 20); botonesMenuMP('${params.proceso_20}');">
                <h1 class="semana_20 relative">20</h1>
            </div>  

            <div id="${params.idSemana + '_semana_21'}" class="flex items-center justify-center whc-1 programado-${params.semana_21} status-${params.proceso_21}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 21); botonesMenuMP('${params.proceso_21}');">
                <h1 class="semana_21 relative">21</h1>
            </div> 

            <div id="${params.idSemana + '_semana_22'}" class="flex items-center justify-center whc-1 programado-${params.semana_22} status-${params.proceso_22}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 22); botonesMenuMP('${params.proceso_22}');">
                <h1 class="semana_22 relative">22</h1>
            </div> 

            <div id="${params.idSemana + '_semana_23'}" class="flex items-center justify-center whc-1 programado-${params.semana_23} status-${params.proceso_23}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 23); botonesMenuMP('${params.proceso_23}');">
                <h1 class="semana_23 relative">23</h1>
            </div> 

            <div id="${params.idSemana + '_semana_24'}" class="flex items-center justify-center whc-1 programado-${params.semana_24} status-${params.proceso_24}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 24); botonesMenuMP('${params.proceso_24}');">
                <h1 class="semana_24 relative">24</h1>
            </div> 

            <div id="${params.idSemana + '_semana_25'}" class="flex items-center justify-center whc-1 programado-${params.semana_25} status-${params.proceso_25}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 25); botonesMenuMP('${params.proceso_25}');">
                <h1 class="semana_25 relative">25</h1>
            </div> 

            <div id="${params.idSemana + '_semana_26'}" class="flex items-center justify-center whc-1 programado-${params.semana_26} status-${params.proceso_26}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 26); botonesMenuMP('${params.proceso_26}');">
                <h1 class="semana_26 relative">26</h1>
            </div> 

            <div id="${params.idSemana + '_semana_27'}" class="flex items-center justify-center whc-1 programado-${params.semana_27} status-${params.proceso_27}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 27); botonesMenuMP('${params.proceso_27}');">
                <h1 class="semana_27 relative">27</h1>
            </div>

            <div id="${params.idSemana + '_semana_28'}" class="flex items-center justify-center whc-1 programado-${params.semana_28} status-${params.proceso_28}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 28); botonesMenuMP('${params.proceso_28}');">
                <h1 class="semana_28 relative">28</h1>
            </div>

            <div id="${params.idSemana + '_semana_29'}" class="flex items-center justify-center whc-1 programado-${params.semana_29} status-${params.proceso_29}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 29); botonesMenuMP('${params.proceso_29}');">
                <h1 class="semana_29 relative">29</h1>
            </div>

            <div id="${params.idSemana + '_semana_30'}" class="flex items-center justify-center whc-1 programado-${params.semana_30} status-${params.proceso_30}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 30); botonesMenuMP('${params.proceso_30}');">
                <h1 class="semana_30 relative">30</h1>
            </div>

            <div id="${params.idSemana + '_semana_31'}" class="flex items-center justify-center whc-1 programado-${params.semana_31} status-${params.proceso_31}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 31); botonesMenuMP('${params.proceso_31}');">
                <h1 class="semana_31 relative">31</h1>
            </div>

            <div id="${params.idSemana + '_semana_32'}" class="flex items-center justify-center whc-1 programado-${params.semana_32} status-${params.proceso_32}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 32); botonesMenuMP('${params.proceso_32}');">
                <h1 class="semana_32 relative">32</h1>
            </div>

            <div id="${params.idSemana + '_semana_33'}" class="flex items-center justify-center whc-1 programado-${params.semana_33} status-${params.proceso_33}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 33); botonesMenuMP('${params.proceso_33}');">
                <h1 class="semana_33 relative">33</h1>
            </div>

            <div id="${params.idSemana + '_semana_34'}" class="flex items-center justify-center whc-1 programado-${params.semana_34} status-${params.proceso_34}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 34); botonesMenuMP('${params.proceso_34}');">
                <h1 class="semana_34 relative">34</h1>
            </div>

            <div id="${params.idSemana + '_semana_35'}" class="flex items-center justify-center whc-1 programado-${params.semana_35} status-${params.proceso_35}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 35); botonesMenuMP('${params.proceso_35}');">
                <h1 class="semana_35 relative">35</h1>
            </div>

            <div id="${params.idSemana + '_semana_36'}" class="flex items-center justify-center whc-1 programado-${params.semana_36} status-${params.proceso_36}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 36); botonesMenuMP('${params.proceso_36}');">
                <h1 class="semana_36 relative">36</h1>
            </div>

            <div id="${params.idSemana + '_semana_37'}" class="flex items-center justify-center whc-1 programado-${params.semana_37} status-${params.proceso_37}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 37); botonesMenuMP('${params.proceso_37}');">
                <h1 class="semana_37 relative">37</h1>
            </div>

            <div id="${params.idSemana + '_semana_38'}" class="flex items-center justify-center whc-1 programado-${params.semana_38} status-${params.proceso_38}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 38); botonesMenuMP('${params.proceso_38}');">
                <h1 class="semana_38 relative">38</h1>
            </div>

            <div id="${params.idSemana + '_semana_39'}" class="flex items-center justify-center whc-1 programado-${params.semana_39} status-${params.proceso_39}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 39); botonesMenuMP('${params.proceso_39}');">
                <h1 class="semana_39 relative">39</h1>
            </div>

            <div id="${params.idSemana + '_semana_40'}" class="flex items-center justify-center whc-1 programado-${params.semana_40} status-${params.proceso_40}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 40); botonesMenuMP('${params.proceso_40}');">
                <h1 class="semana_40 relative">40</h1>
            </div>

            <div id="${params.idSemana + '_semana_41'}" class="flex items-center justify-center whc-1 programado-${params.semana_41} status-${params.proceso_41}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 41); botonesMenuMP('${params.proceso_41}');">
                <h1 class="semana_41 relative">41</h1>
            </div>

            <div id="${params.idSemana + '_semana_42'}" class="flex items-center justify-center whc-1 programado-${params.semana_42} status-${params.proceso_42}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 42); botonesMenuMP('${params.proceso_42}');">
                <h1 class="semana_42 relative">42</h1>
            </div>

            <div id="${params.idSemana + '_semana_43'}" class="flex items-center justify-center whc-1 programado-${params.semana_43} status-${params.proceso_43}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 43); botonesMenuMP('${params.proceso_43}');">
                <h1 class="semana_43 relative">43</h1>
            </div>

            <div id="${params.idSemana + '_semana_44'}" class="flex items-center justify-center whc-1 programado-${params.semana_44} status-${params.proceso_44}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 44); botonesMenuMP('${params.proceso_44}');">
                <h1 class="semana_44 relative">44</h1>
            </div>

            <div id="${params.idSemana + '_semana_45'}" class="flex items-center justify-center whc-1 programado-${params.semana_45} status-${params.proceso_45}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 45); botonesMenuMP('${params.proceso_45}');">
                <h1 class="semana_45 relative">45</h1>
            </div>

            <div id="${params.idSemana + '_semana_46'}" class="flex items-center justify-center whc-1 programado-${params.semana_46} status-${params.proceso_46}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 46); botonesMenuMP('${params.proceso_46}');">
                <h1 class="semana_46 relative">46</h1>
            </div>

            <div id="${params.idSemana + '_semana_47'}" class="flex items-center justify-center whc-1 programado-${params.semana_47} status-${params.proceso_47}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 47); botonesMenuMP('${params.proceso_47}');">
                <h1 class="semana_47 relative">47</h1>
            </div>

            <div id="${params.idSemana + '_semana_48'}" class="flex items-center justify-center whc-1 programado-${params.semana_48} status-${params.proceso_48}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 48); botonesMenuMP('${params.proceso_48}');">
                <h1 class="semana_48 relative">48</h1>
            </div>

            <div id="${params.idSemana + '_semana_49'}" class="flex items-center justify-center whc-1 programado-${params.semana_49} status-${params.proceso_49}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 49); botonesMenuMP('${params.proceso_49}');">
                <h1 class="semana_49 relative">49</h1>
            </div>

            <div id="${params.idSemana + '_semana_50'}" class="flex items-center justify-center whc-1 programado-${params.semana_50} status-${params.proceso_50}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 50); botonesMenuMP('${params.proceso_50}');">
                <h1 class="semana_50 relative">50</h1>
            </div>

            <div id="${params.idSemana + '_semana_51'}" class="flex items-center justify-center whc-1 programado-${params.semana_51} status-${params.proceso_51}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 51); botonesMenuMP('${params.proceso_51}');">
                <h1 class="semana_51 relative">51</h1>
            </div>

            <div id="${params.idSemana + '_semana_52'}" class="flex items-center justify-center whc-1 programado-${params.semana_52} status-${params.proceso_52}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 52); botonesMenuMP('${params.proceso_52}');">
                <h1 class="semana_52 relative">52</h1>
            </div>

        </div>
    `
};


// Función para Consultar Equipos
function consultaEquiposLocales() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    // Datos para Aplicar los Filtros
    let filtroDestino = document.getElementById("filtroDestino").value;
    let filtroSeccion = document.getElementById("filtroSeccion").value;
    let filtroSubseccion = document.getElementById("filtroSubseccion").value;
    let filtroTipo = document.getElementById("filtroTipo").value;
    let filtroStatus = document.getElementById("filtroStatus").value;
    let filtroSemana = document.getElementById("filtroSemana").value;
    let filtroPalabra = document.getElementById("filtroPalabra").value;
    let load = document.getElementById("load");

    // BOTON PARA CREAR EQUIPOS, SE OCULTA EN AME
    if (filtroDestino != 10) {
        document.getElementById("agregarEquipoLocal").classList.remove("hidden");
    } else {
        document.getElementById("agregarEquipoLocal").classList.add("hidden");
    }

    const action = "consultaEquiposLocales";
    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&filtroDestino=${filtroDestino}&filtroSeccion=${filtroSeccion}&filtroSubseccion=${filtroSubseccion}&filtroTipo=${filtroTipo}&filtroStatus=${filtroStatus}&filtroSemana=${filtroSemana}&filtroPalabra=${filtroPalabra}`;

    // limpia el contendor, para nuevo resultado
    document.getElementById('contenedorDeEquipos').innerHTML = '';
    load.innerHTML = '<i class="fa fa-spinner fa-pulse fa-sm fa-fw"></i>';

    fetch(URL)
        .then(res => res.json())
        .then(array => {
            if (array) {
                // alertaImg(`Equipos Obtenidos: ${array.length}`, '', 'info', 2000);

                for (let x = 0; x < array.length; x++) {
                    const equiposX = datosPlanes({
                        idEquipo: array[x].idEquipo,
                        destino: array[x].destino,
                        equipo: array[x].equipo,
                        seccion: array[x].seccion,
                        subseccion: array[x].subseccion,
                        marca: array[x].marca,
                        tipoEquipo: array[x].tipoEquipo,
                        status: array[x].status,
                        marcaEquipo: array[x].marcaEquipo,
                        modelo: array[x].modelo,
                        equipoLocal: array[x].equipoLocal,
                        ubicacion: array[x].ubicacion,
                        proximoMP: array[x].proximoMP,
                        proceso: array[x].proceso,
                        solucionado: array[x].solucionado,
                        planificado: array[x].planificado
                    });
                    document.getElementById("contenedorDeEquipos")
                        .insertAdjacentHTML('beforeend', equiposX);
                }
            } else {
                alertaImg('Equipos Obtenidos: 0', '', 'info', 3000)
            }
            // return array[0].semanaActual;
            return array;
        })
        .then(array => {
            var xl = [];
            let option = document.getElementById("filtroTipo");

            option.innerHTML = '<option value="">Tipo Equipo Seleccionado</option>';
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idtipoEquipo = array[x].idtipoEquipo;
                    const tipoEquipo = array[x].tipoEquipo;
                    const id = array[x].id;
                    xl[idtipoEquipo] = { "idTipo": idtipoEquipo, "tipo": tipoEquipo + ' ' + id };
                }

                xl.forEach(x => {
                    const codigo = `<option value="${x.idTipo}">${x.tipo}</option>`;
                    option.insertAdjacentHTML('beforeend', codigo);
                });
            }
        })
        .then(() => {
            document.getElementById("filtroTipo").insertAdjacentHTML('afterbegin', '<option value="0">Todos</option>');
            load.innerHTML = '';
        })
        .catch(function (err) {
            fetch(APIERROR + err + ' consultaEquiposLocales()');
            load.innerHTML = '';
            document.getElementById('contenedorDeEquipos').innerHTML = '';
        })
}


// ********** FUNCIONES PARA MODAL DE EQUIPOS **********
// Función para los inptus de modalMPEquipos
function toggleDisabledEditarEquipo(estadoInputs) {
    let idEquipo = localStorage.getItem('idEquipo');

    const arrayBtnEquipo =
        [
            'estadoEquipo', 'nombreEquipo', 'seccionEquipo', 'subseccionEquipo', 'tipoEquipo', 'jerarquiaEquipo', 'marcaEquipo', 'modeloEquipo', 'serieEquipo', 'codigoFabricanteEquipo', 'codigoInternoComprasEquipo', 'largoEquipo', 'anchoEquipo', 'altoEquipo', 'potenciaElectricaHPEquipo', 'potenciaElectricaKWEquipo', 'voltajeEquipo', 'frecuenciaEquipo', 'caudalAguaM3HEquipo', 'caudalAguaGPHEquipo', 'cargaMCAEquipo', 'PotenciaEnergeticaFrioKWEquipo', 'potenciaEnergeticaFrioTREquipo', 'potenciaEnergeticaCalorKCALEquipo', 'caudalAireM3HEquipo', 'caudalAireCFMEquipo', 'estadoEquipo', 'idFaseEquipo', 'tipoLocalEquipo', 'dataOpcionesEquipos'
        ]

    arrayBtnEquipo.forEach(element => {
        if (estadoInputs == 1) {
            document.getElementById(element).removeAttribute('disabled');
        } else {
            document.getElementById(element).setAttribute('disabled', false);
        }
    });

    btnEditarEquipo.setAttribute('onclick', 'toggleDisabledEditarEquipo(1)');
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
        url: "../php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            tabla: tabla,
            idTabla: idTabla

        },
        dataType: "JSON",
        success: function (data) {
            // Limpia contendor de Adjuntos
            document.getElementById("dataImagenes").innerHTML = '';
            document.getElementById("dataImagenesEquipo").innerHTML = '';
            document.getElementById("dataAdjuntos").innerHTML = '';

            if (data.imagen != "") {
                document.getElementById("dataImagenes").innerHTML = data.imagenAux;
                document.getElementById("dataImagenesEquipo").innerHTML = data.imagenAux;
                document.getElementById("contenedorImagenes").classList.remove('hidden');
                document.getElementById("dataImagenes").classList.remove("justify-center");
            } else {
                document.getElementById("contenedorImagenes").classList.add('hidden');
            }

            if (data.documento != "") {
                document.getElementById("dataAdjuntos").innerHTML = data.documento;
                document.getElementById("contenedorDocumentos").classList.remove('hidden');
                document.getElementById("dataAdjuntos").classList.remove("justify-center");
            } else {
                document.getElementById("contenedorDocumentos").classList.add('hidden');
                document.getElementById("dataAdjuntos").classList.remove("justify-center");
            }
        },
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
        url: "../php/plannerCrudPHP.php",
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


// Oculta tooltip de las semanas
function cerrarTooltip(id) {
    document.getElementById(id).classList.add('hidden');
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


// Proceso para Ver OT
function VerOTMP(idSemana, idProceso, idEquipo, semanaX, idPlan, accionMP) {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let numeroSemanas = 0;

    const action = "programarMP";
    $.ajax({
        type: "POST",
        url: "../php/plannerCrudPHP.php",
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
            if (data == 13) {
                localStorage.setItem('URL', `${idSemana};${idProceso};${idEquipo};${semanaX};${idPlan}`);
                window.open('../OT/index.php', "OT", "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=1200px, height=650px");
            } else {
                alertaImg(`Semana ${semanaX}, Sin Proceso`, '', 'error', 3000);
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
        url: "../php/plannerCrudPHP.php",
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
            // consultarPlanEquipo(idEquipo);
            consultaEquiposLocales();
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
    Popper.createPopper(button, tooltip, {
        placement: 'top',
    });


    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = "consultarActividadesMP";
    $.ajax({
        type: "POST",
        url: "../php/plannerCrudPHP.php",
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


// Sube imagenes con dos parametros, con el formulario #inputAdjuntos
function subirImagenGeneral(idTabla, tabla) {
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    let img = document.getElementById("inputAdjuntos").files;

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
            url: "../php/plannerCrudPHP.php",
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
                    obtenerProyectosP("PROYECTO");
                    cotizacionesProyectos(idTabla);
                    // Sube y Actualiza la Vista para los Adjuntos de Planaccion.
                } else if (data == 4) {
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                    obtenerProyectosP("PROYECTO");
                    adjuntosPlanaccion(idTabla);
                } else if (data == 5) {
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                    obtenerMediaEquipo(idTabla);
                } else if (data == 7) {
                    obtenerAdjuntosTareas(idTabla);
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                } else if (data == 8) {
                    obtenerAdjuntosMC(idTabla);
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                } else if (data == 9) {
                    obtenerImagenesEquipo(idTabla);
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                } else if (data == 10) {
                    alertaImg("Adjunto Agregado", "", "success", 2500);
                    consultaAdjuntosOT(idTabla);
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
            },
        });
    }
}


function expandir(id) {
    let idtoggle = id + "toggle";
    let idtitulo = id + "titulo";
    var toggle = document.getElementById(idtoggle);
    toggle.classList.toggle("hidden");
}


// toggleClass Modal TailWind con la clase OPEN.
function toggleModalTailwind(idModal) {
    $("#" + idModal).toggleClass("open");
}


// AGREGAR EQUIPOS LOCALES
function modalAgregarEquipo() {
    let idDestino = document.getElementById("filtroDestino").value;
    let idUsuario = localStorage.getItem('usuario');

    document.getElementById("modalAgregarEquipo").classList.add('open');
    document.getElementById("btnAgregarEquipo").setAttribute('onclick', 'agregarEquipoLocal();');

    let contenedorDestino = document.getElementById("destinoXEquipo");
    let contenedorSeccion = document.getElementById("seccionXEquipo");
    let contenedorSubseccion = document.getElementById("subseccionXEquipo");
    let contenedorTipo = document.getElementById("tipoXEquipo");
    let contenedorMarca = document.getElementById("marcaXEquipo");
    let contenedorEquipoLocal = document.getElementById("equipoXLocal");

    let valorSeccion = contenedorSeccion.value;
    let valorTipo = contenedorTipo.value;
    let valorMarca = contenedorMarca.value;
    let valorEquipo = contenedorEquipoLocal.value;

    const action = "obtenerOpcionesEquipo";
    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${contenedorSeccion.value}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {

            // LIMPIA CONTENEDORES
            contenedorDestino.innerHTML = '';
            contenedorSeccion.innerHTML = '';
            contenedorSubseccion.innerHTML = '';
            contenedorTipo.innerHTML = '';
            contenedorMarca.innerHTML = '';
            contenedorEquipoLocal.innerHTML = '';

            // DESTINOS
            if (array.destinos.length > 0) {
                for (let x = 0; x < array.destinos.length; x++) {
                    const idDestinoX = array.destinos[x].idDestino;
                    const destino = array.destinos[x].destino;
                    const codigo = `<option value="${idDestinoX}">${destino}</option>`;
                    contenedorDestino.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // SECCIONES
            if (array.secciones.length > 0) {
                for (let x = 0; x < array.secciones.length; x++) {
                    const idSeccion = array.secciones[x].idSeccion;
                    const seccion = array.secciones[x].seccion;
                    const codigo = `<option value="${idSeccion}">${seccion}</option>`;
                    contenedorSeccion.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // SUBSECCIONES
            if (array.subsecciones.length > 0) {
                for (let x = 0; x < array.subsecciones.length; x++) {
                    const idSubseccion = array.subsecciones[x].idSubseccion;
                    const subseccion = array.subsecciones[x].subseccion;
                    const codigo = `<option value="${idSubseccion}">${subseccion}</option>`;
                    contenedorSubseccion.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // TIPOS
            if (array.tipos.length > 0) {
                for (let x = 0; x < array.tipos.length; x++) {
                    const idTipo = array.tipos[x].idTipo;
                    const tipo = array.tipos[x].tipo;
                    const codigo = `<option value="${idTipo}">${tipo}</option>`;
                    contenedorTipo.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // MARCAS
            if (array.marcas.length > 0) {
                for (let x = 0; x < array.marcas.length; x++) {
                    const idMarca = array.marcas[x].idMarca;
                    const marca = array.marcas[x].marca;
                    const codigo = `<option value="${idMarca}">${marca}</option>`;
                    contenedorMarca.insertAdjacentHTML('beforeend', codigo);
                }
            }

            // LOCAL O EQUIPO
            if (array.tipoEquipo.length > 0) {
                for (let x = 0; x < array.tipoEquipo.length; x++) {
                    const idTipoEquipo = array.tipoEquipo[x].idTipoEquipo;
                    const tipo = array.tipoEquipo[x].tipo;
                    const codigo = `<option value="${idTipoEquipo}">${tipo}</option>`;
                    contenedorEquipoLocal.insertAdjacentHTML('beforeend', codigo);
                }
            }

        })
        .then(() => {
            contenedorSeccion.value = valorSeccion;
            contenedorTipo.value = valorTipo;
            contenedorMarca.value = valorMarca;
            contenedorEquipoLocal.value = valorEquipo;
        })
        .catch(function (err) {
            // LIMPIA CONTENEDORES
            contenedorDestino.innerHTML = '';
            contenedorSeccion.innerHTML = '';
            contenedorSubseccion.innerHTML = '';
            contenedorTipo.innerHTML = '';
            contenedorMarca.innerHTML = '';
            contenedorEquipoLocal.innerHTML = '';

            fetch(APIERROR + err);
        })
}
document.getElementById("agregarEquipoLocal").
    addEventListener('click', modalAgregarEquipo);
document.getElementById("seccionXEquipo").
    addEventListener('change', modalAgregarEquipo);

// EVENTO PARA OPCIÓN DE JERARQUIA DE EQUIPO
document.getElementById("jerarquiaXEquipo").addEventListener('change', () => {
    let jerarquia = document.getElementById("jerarquiaXEquipo").value;
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = document.getElementById("destinoXEquipo").value;
    let idSeccion = document.getElementById("seccionXEquipo").value;
    let idSubseccion = document.getElementById("subseccionXEquipo").value;
    let contenedor = document.getElementById("jerarquiaPadreXEquipo");
    let contenedorEquipoPadre = document.getElementById("contenedorEquipoPadre");
    const action = "jerarquiaEquipo";
    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}&idSubseccion=${idSubseccion}`;

    if (idSeccion <= 0 && idSubseccion <= 0) {
        alertaImg('Se requiere Sección y Subsección', '', 'success', 1200);
    } else {
        if (jerarquia == "SECUNDARIO") {
            contenedorEquipoPadre.classList.remove('hidden');
            fetch(URL)
                .then(array => array.json())
                .then(array => {
                    contenedor.innerHTML = '';
                    if (array.length > 0) {
                        for (let x = 0; x < array.length; x++) {
                            const idEquipo = array[x].idEquipo;
                            const equipo = array[x].equipo;
                            const codigo = `<option value="${idEquipo}">${equipo}</option>`;
                            contenedor.insertAdjacentHTML('beforeend', codigo);
                        }
                    } else {
                        alertaImg('No se encontraron Equipos relacionados', '', 'success', 1200);
                    }
                })
                .catch(function (err) {
                    fetch(APIERROR + err);
                })
        } else {
            contenedorEquipoPadre.classList.add('hidden');
        }
    }
})


// FUNCIÓN PARA AGREGAR EQUIPO / LOCAL
function agregarEquipoLocal() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');

    let equipo = document.getElementById("descripcionXEquipo");
    let destino = document.getElementById("destinoXEquipo");
    let seccion = document.getElementById("seccionXEquipo");
    let subseccion = document.getElementById("subseccionXEquipo");
    let tipo = document.getElementById("tipoXEquipo");
    let marca = document.getElementById("marcaXEquipo");
    let equipolocal = document.getElementById("equipoXLocal");
    let modelo = document.getElementById("modeloXEquipo");
    let jerarquia = document.getElementById("jerarquiaXEquipo");
    let equipoPadre = document.getElementById("jerarquiaPadreXEquipo");

    const data = new FormData();


    const action = "agregarEquipoLocal";

    data.append("equipo", equipo.value);
    data.append("destino", destino.value);
    data.append("seccion", seccion.value);
    data.append("subseccion", subseccion.value);
    data.append("tipo", tipo.value);
    data.append("marca", marca.value);
    data.append("equipolocal", equipolocal.value);
    data.append("status", "OPERATIVO");
    data.append("modelo", modelo.value);
    data.append("jerarquia", jerarquia.value);
    data.append("equipoPadre", equipoPadre.value);

    if (equipo.value != "" && destino.value != "" && seccion.value != "" && subseccion.value != "" && tipo.value != "" && marca.value != "" && equipolocal.value != "" && jerarquia.value != "") {

        fetch(`php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}`, {
            method: 'POST',
            body: data
        })
            .then(array => array.json())
            .then(array => {
                if (array == 1) {
                    consultaEquiposLocales();
                    alertaImg(equipolocal.value + ' Agregado', '', 'success', 1200);
                    document.getElementById("modalAgregarEquipo").classList.remove('open');
                    equipo.value = '';
                    destino.value = '';
                    seccion.value = '';
                    subseccion.value = '';
                    tipo.value = '';
                    marca.value = '';
                    equipolocal.value = '';
                    modelo.value = '';
                    jerarquia.value = '';
                    equipoPadre.value = '';
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1200);
                }
            })
            .catch(function (err) {
                fetch(APIERROR + err + ' agregarEquipoLocal()');
            })
    } else {
        alertaImg('Datos Incorrectos', '', 'info', 1200);
    }
}



// ********** FUNCIONES PARA MODAL DE EQUIPOS **********


// Obtiene el despiece de los equipos
function despieceEquipos(idEquipo) {
    document.getElementById("dataDespieceEquipo").innerHTML = '';
    let idUsuario = localStorage.getItem("usuario");
    let idDestino = localStorage.getItem("idDestino");
    const action = "despieceEquipos";
    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idEquipo=${idEquipo}`;

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
                    despiece += `
                        <div class="flex-none cursor-pointer hover:bg-purple-200 hover:text-purple-700 w-full px-2 py-2 rounded-sm truncate flex items-center border-b" onclick="informacionEquipo(${id});">
                            <i class="fad fa-cog mr-1"></i>
                            <h1>${equipo}</h1>
                        </div>`
                        ;
                } else {
                    despiece += `
                        <div class="flex-none cursor-pointer hover:bg-purple-200 hover:text-purple-700 w-full px-2 py-2 rounded-sm truncate flex items-center border-b pl-6" onclick="informacionEquipo(${id});">
                            <i class="fad fa-cogs mr-1"></i>
                            <h1>${equipo}</h1>
                        </div>`
                        ;
                }
            }
            return despiece;
        }).then(despiece => {
            document.getElementById("dataDespieceEquipo").innerHTML = despiece;
        });

}


// Captura Eventos (Prueba)
function registroEventos(params) {
    if (params == "modalMPEquipo") {
    }
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
            let opcionDestinos = '';
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
        })
        .catch(function () {
            document.getElementById("loadequipos").innerHTML = '';
        });
}


//Consulta Secciones->Subsecciones, Disponibles 
function consultarSubsecciones() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    let idSeccion = document.getElementById("filtroSeccion").value;
    const action = "consultarSubsecciones";
    const URL = `php/gestion_equipos_crud.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&idSeccion=${idSeccion}`;

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


// Funciones Generales, para Abrir MODAL
function abrirmodal(idModal) {
    var abrirmodal = document.getElementById(idModal);
    abrirmodal.classList.add("open");
}

// Funciones Generales, para Cerrar MODAL
function cerrarmodal(idmodal) {
    var cerrarr = document.getElementById(idmodal);
    cerrarr.classList.remove('open');
};


// FUNCIONES INICIALES
// Funciones para los Filtros
generar52Semnas();
consultarDestinos();
consultarSecciones();

// Aplica Filtros Seleccionados
document.getElementById("filtroSeccion").addEventListener("change", consultarSubsecciones);
document.getElementById("filtroSubseccion").addEventListener("change", consultaEquiposLocales);
document.getElementById("filtroTipo").addEventListener("change", consultaEquiposLocales);
document.getElementById("filtroStatus").addEventListener("change", consultaEquiposLocales);
document.getElementById("filtroSemana").addEventListener("change", consultaEquiposLocales);
document.getElementById("filtroSeccion").addEventListener("change", consultaEquiposLocales);

// Cambia de destino en el FILTRO y en el MENU
document.getElementById("filtroDestino").addEventListener("change", () => {
    consultaEquiposLocales();
    let idDestino = document.getElementById("filtroDestino").value;
    localStorage.setItem('idDestino', idDestino);
    location.reload();
});

document.getElementById("filtroPalabra").
    addEventListener("keyup", function () {
        buscadorEquipo('tablaGestionEquipos', 'filtroPalabra', 3);
    });

// Función para
onload = QREquipo();

function QREquipo() {
    let URLactual = window.location.search;
    let arr = URLactual.split("?");
    if (arr[1] > 0) {
        let idEquipo = arra[1];
        informacionEquipo(idEquipo);
        despieceEquipos(idEquipo);
        document.getElementById("filtroPalabra").value = idEquipo;
        alertaImg('QR Detectado', '', 'success', 1500);
    }
}


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


// FUNCIÓN PARA EXPORTAR EQUIPOS
function exportarEquipos() {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    // Datos para Aplicar los Filtros
    let filtroDestino = document.getElementById("filtroDestino").value;
    let filtroSeccion = document.getElementById("filtroSeccion").value;
    let filtroSubseccion = document.getElementById("filtroSubseccion").value;
    let filtroTipo = document.getElementById("filtroTipo").value;
    let filtroStatus = document.getElementById("filtroStatus").value;
    let filtroSemana = document.getElementById("filtroSemana").value;
    let filtroPalabra = document.getElementById("filtroPalabra").value;

    const action = "reporteGestionEquipos";
    const URL = `../php/exportar_excel_GET.php?action=${action}&idUsuario=${idUsuario}&idDestino=${idDestino}&filtroDestino=${filtroDestino}&filtroSeccion=${filtroSeccion}&filtroSubseccion=${filtroSubseccion}&filtroTipo=${filtroTipo}&filtroStatus=${filtroStatus}&filtroSemana=${filtroSemana}&filtroPalabra=${filtroPalabra}`;

    window.location = URL;

    setTimeout(() => {
        alertaImg('Generando Reporte...', '', 'success', 1200);
    }, 1200);
}


// CARGA CONTENIDO INICIAL, DESPUES DE QUE CARGA COMPLETAMENTE
window.addEventListener("load", function () {
    // Función inicial para mostrar información de Equipos (t_equipos_america).
    let idDestino = localStorage.getItem("idDestino");
    document.getElementById("filtroDestino").value = idDestino;
    consultaEquiposLocales();
})


// EVENTO PARA EXPORTA EQUIPOS
document.getElementById("exportarPendientes").addEventListener('click', exportarEquipos);


document.getElementById("destinosSelecciona").addEventListener("click", () => {
    let idDestino = localStorage.getItem("idDestino");
    document.getElementById("filtroDestino").value = idDestino;
    location.reload();
})


function informacionEquipo(idEquipo) {
    localStorage.setItem("idEquipo", idEquipo);
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');



    // FUNCIONES INICIALES
    obtenerImagenesEquipo(idEquipo);
    // consultarPlanEquipo(idEquipo);
    toggleDisabledEditarEquipo(0);

    const URL = `../php/select_REST_planner.php?action=obtenerSeccionesSubseccionPorDestino&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;
    let promesa = new Promise((resolve, reject) => {
        console.log(1);
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
        resolve(resolve, reject)
    })
    promesa.then((resolve, reject) => {

        const URL2 = `../php/select_REST_planner.php?action=obtenerEquipoPorId&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;
        console.log(2);

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
            .then(() => {
                console.log(3);
                cancelarInformacionEquipo(idEquipo);
            })
            .catch(function (err) {
                fetch(APIERROR + err);
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
    })
    promesa.catch((err) => {
        fetch(APIERROR + err);
    })
}


function cancelarInformacionEquipo(idEquipo) {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');
    const URL = `../php/select_REST_planner.php?action=obtenerEquipoPorId&idDestino=${idDestino}&idUsuario=${idUsuario}&idEquipo=${idEquipo}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
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
    const URL = `../php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    const data = new FormData()
    data.append('idEquipo', idEquipo);
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