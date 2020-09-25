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
        <tr id="equipo_${params.id}" class="hover:bg-fondos-4 cursor-pointer text-xs" 
        onclick="informacionEquipo(${params.id});">
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


const $ContenedorPlanesEquipos = document.getElementById('contenedorPlanesEquipo');
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
                <h1 class="">01</h1>
            </div>  

            <div id="${params.idSemana + '_semana_2'}" class="flex items-center justify-center whc-1 programado-${params.semana_2} status-${params.proceso_2}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 2); botonesMenuMP('${params.proceso_2}');">
                <h1 class="">02</h1>
            </div> 

            <div id="${params.idSemana + '_semana_3'}" class="flex items-center justify-center whc-1 programado-${params.semana_3} status-${params.proceso_3}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 3); botonesMenuMP('${params.proceso_3}');">
                <h1 class="">03</h1>
            </div> 

            <div id="${params.idSemana + '_semana_4'}" class="flex items-center justify-center whc-1 programado-${params.semana_4} status-${params.proceso_4}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 4); botonesMenuMP('${params.proceso_4}');">
                <h1 class="">04</h1>
            </div> 

            <div id="${params.idSemana + '_semana_5'}" class="flex items-center justify-center whc-1 programado-${params.semana_5} status-${params.proceso_5}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 5); botonesMenuMP('${params.proceso_5}');">
                <h1 class="">05</h1>
            </div> 

            <div id="${params.idSemana + '_semana_6'}" class="flex items-center justify-center whc-1 programado-${params.semana_6} status-${params.proceso_6}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 6); botonesMenuMP('${params.proceso_6}');">
                <h1 class="">06</h1>
            </div> 

            <div id="${params.idSemana + '_semana_7'}" class="flex items-center justify-center whc-1 programado-${params.semana_7} status-${params.proceso_7}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 7); botonesMenuMP('${params.proceso_7}');">
                <h1 class="">07</h1>
            </div> 

            <div id="${params.idSemana + '_semana_8'}" class="flex items-center justify-center whc-1 programado-${params.semana_8} status-${params.proceso_8}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 8); botonesMenuMP('${params.proceso_8}');">
                <h1 class="">08</h1>
            </div> 

            <div id="${params.idSemana + '_semana_9'}" class="flex items-center justify-center whc-1 programado-${params.semana_9} status-${params.proceso_9}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 9); botonesMenuMP('${params.proceso_9}');">
                <h1 class="">09</h1>
            </div> 

            <div id="${params.idSemana + '_semana_10'}" class="flex items-center justify-center whc-1 programado-${params.semana_10} status-${params.proceso_10}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 10); botonesMenuMP('${params.proceso_10}');">
                <h1 class="">10</h1>
            </div> 

            <div id="${params.idSemana + '_semana_11'}" class="flex items-center justify-center whc-1 programado-${params.semana_11} status-${params.proceso_11}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 11); botonesMenuMP('${params.proceso_11}');">
                <h1 class="">11</h1>
            </div> 
            
            <div id="${params.idSemana + '_semana_12'}" class="flex items-center justify-center whc-1 programado-${params.semana_12} status-${params.proceso_12}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 12); botonesMenuMP('${params.proceso_12}');">
                <h1 class="">12</h1>
            </div> 

            <div id="${params.idSemana + '_semana_13'}" class="flex items-center justify-center whc-1 programado-${params.semana_13} status-${params.proceso_13}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 13); botonesMenuMP('${params.proceso_13}');">
                <h1 class="">13</h1>
            </div> 

            <div id="${params.idSemana + '_semana_14'}" class="flex items-center justify-center whc-1 programado-${params.semana_14} status-${params.proceso_14}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 14); botonesMenuMP('${params.proceso_14}');">
                <h1 class="">14</h1>
            </div> 

            <div id="${params.idSemana + '_semana_15'}" class="flex items-center justify-center whc-1 programado-${params.semana_15} status-${params.proceso_15}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 15); botonesMenuMP('${params.proceso_15}');">
                <h1 class="">15</h1>
            </div> 

            <div id="${params.idSemana + '_semana_16'}" class="flex items-center justify-center whc-1 programado-${params.semana_16} status-${params.proceso_16}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 16); botonesMenuMP('${params.proceso_16}');">
                <h1 class="">16</h1>
            </div> 

            <div id="${params.idSemana + '_semana_17'}" class="flex items-center justify-center whc-1 programado-${params.semana_17} status-${params.proceso_17}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 17); botonesMenuMP('${params.proceso_17}');">
                <h1 class="">17</h1>
            </div> 

            <div id="${params.idSemana + '_semana_18'}" class="flex items-center justify-center whc-1 programado-${params.semana_18} status-${params.proceso_18}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 18); botonesMenuMP('${params.proceso_18}');">
                <h1 class="">18</h1>
            </div> 

            <div id="${params.idSemana + '_semana_19'}" class="flex items-center justify-center whc-1 programado-${params.semana_19} status-${params.proceso_19}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 19); botonesMenuMP('${params.proceso_19}');">
                <h1 class="">19</h1>
            </div> 

            <div id="${params.idSemana + '_semana_20'}" class="flex items-center justify-center whc-1 programado-${params.semana_20} status-${params.proceso_20}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 20); botonesMenuMP('${params.proceso_20}');">
                <h1 class="">20</h1>
            </div>  

            <div id="${params.idSemana + '_semana_21'}" class="flex items-center justify-center whc-1 programado-${params.semana_21} status-${params.proceso_21}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 21); botonesMenuMP('${params.proceso_21}');">
                <h1 class="">21</h1>
            </div> 

            <div id="${params.idSemana + '_semana_22'}" class="flex items-center justify-center whc-1 programado-${params.semana_22} status-${params.proceso_22}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 22); botonesMenuMP('${params.proceso_22}');">
                <h1 class="">22</h1>
            </div> 

            <div id="${params.idSemana + '_semana_23'}" class="flex items-center justify-center whc-1 programado-${params.semana_23} status-${params.proceso_23}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 23); botonesMenuMP('${params.proceso_23}');">
                <h1 class="">23</h1>
            </div> 

            <div id="${params.idSemana + '_semana_24'}" class="flex items-center justify-center whc-1 programado-${params.semana_24} status-${params.proceso_24}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 24); botonesMenuMP('${params.proceso_24}');">
                <h1 class="">24</h1>
            </div> 

            <div id="${params.idSemana + '_semana_25'}" class="flex items-center justify-center whc-1 programado-${params.semana_25} status-${params.proceso_25}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 25); botonesMenuMP('${params.proceso_25}');">
                <h1 class="">25</h1>
            </div> 

            <div id="${params.idSemana + '_semana_26'}" class="flex items-center justify-center whc-1 programado-${params.semana_26} status-${params.proceso_26}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 26); botonesMenuMP('${params.proceso_26}');">
                <h1 class="">26</h1>
            </div> 

            <div id="${params.idSemana + '_semana_27'}" class="flex items-center justify-center whc-1 programado-${params.semana_27} status-${params.proceso_27}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 27); botonesMenuMP('${params.proceso_27}');">
                <h1 class="">27</h1>
            </div>

            <div id="${params.idSemana + '_semana_28'}" class="flex items-center justify-center whc-1 programado-${params.semana_28} status-${params.proceso_28}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 28); botonesMenuMP('${params.proceso_28}');">
                <h1 class="">28</h1>
            </div>

            <div id="${params.idSemana + '_semana_29'}" class="flex items-center justify-center whc-1 programado-${params.semana_29} status-${params.proceso_29}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 29); botonesMenuMP('${params.proceso_29}');">
                <h1 class="">29</h1>
            </div>

            <div id="${params.idSemana + '_semana_30'}" class="flex items-center justify-center whc-1 programado-${params.semana_30} status-${params.proceso_30}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 30); botonesMenuMP('${params.proceso_30}');">
                <h1 class="">30</h1>
            </div>

            <div id="${params.idSemana + '_semana_31'}" class="flex items-center justify-center whc-1 programado-${params.semana_31} status-${params.proceso_31}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 31); botonesMenuMP('${params.proceso_31}');">
                <h1 class="">31</h1>
            </div>

            <div id="${params.idSemana + '_semana_32'}" class="flex items-center justify-center whc-1 programado-${params.semana_32} status-${params.proceso_32}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 32); botonesMenuMP('${params.proceso_32}');">
                <h1 class="">32</h1>
            </div>

            <div id="${params.idSemana + '_semana_33'}" class="flex items-center justify-center whc-1 programado-${params.semana_33} status-${params.proceso_33}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 33); botonesMenuMP('${params.proceso_33}');">
                <h1 class="">33</h1>
            </div>

            <div id="${params.idSemana + '_semana_34'}" class="flex items-center justify-center whc-1 programado-${params.semana_34} status-${params.proceso_34}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 34); botonesMenuMP('${params.proceso_34}');">
                <h1 class="">34</h1>
            </div>

            <div id="${params.idSemana + '_semana_35'}" class="flex items-center justify-center whc-1 programado-${params.semana_35} status-${params.proceso_35}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 35); botonesMenuMP('${params.proceso_35}');">
                <h1 class="">35</h1>
            </div>

            <div id="${params.idSemana + '_semana_36'}" class="flex items-center justify-center whc-1 programado-${params.semana_36} status-${params.proceso_36}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 36); botonesMenuMP('${params.proceso_36}');">
                <h1 class="">36</h1>
            </div>

            <div id="${params.idSemana + '_semana_37'}" class="flex items-center justify-center whc-1 programado-${params.semana_37} status-${params.proceso_37}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 37); botonesMenuMP('${params.proceso_37}');">
                <h1 class="">37</h1>
            </div>

            <div id="${params.idSemana + '_semana_38'}" class="flex items-center justify-center whc-1 programado-${params.semana_38} status-${params.proceso_38}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 38); botonesMenuMP('${params.proceso_38}');">
                <h1 class="">38</h1>
            </div>

            <div id="${params.idSemana + '_semana_39'}" class="flex items-center justify-center whc-1 programado-${params.semana_39} status-${params.proceso_39}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 39); botonesMenuMP('${params.proceso_39}');">
                <h1 class="">39</h1>
            </div>

            <div id="${params.idSemana + '_semana_40'}" class="flex items-center justify-center whc-1 programado-${params.semana_40} status-${params.proceso_40}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 40); botonesMenuMP('${params.proceso_40}');">
                <h1 class="">40</h1>
            </div>

            <div id="${params.idSemana + '_semana_41'}" class="flex items-center justify-center whc-1 programado-${params.semana_41} status-${params.proceso_41}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 41); botonesMenuMP('${params.proceso_41}');">
                <h1 class="">41</h1>
            </div>

            <div id="${params.idSemana + '_semana_42'}" class="flex items-center justify-center whc-1 programado-${params.semana_42} status-${params.proceso_42}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 42); botonesMenuMP('${params.proceso_42}');">
                <h1 class="">42</h1>
            </div>

            <div id="${params.idSemana + '_semana_43'}" class="flex items-center justify-center whc-1 programado-${params.semana_43} status-${params.proceso_43}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 43); botonesMenuMP('${params.proceso_43}');">
                <h1 class="">43</h1>
            </div>

            <div id="${params.idSemana + '_semana_44'}" class="flex items-center justify-center whc-1 programado-${params.semana_44} status-${params.proceso_44}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 44); botonesMenuMP('${params.proceso_44}');">
                <h1 class="">44</h1>
            </div>

            <div id="${params.idSemana + '_semana_45'}" class="flex items-center justify-center whc-1 programado-${params.semana_45} status-${params.proceso_45}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 45); botonesMenuMP('${params.proceso_45}');">
                <h1 class="">45</h1>
            </div>

            <div id="${params.idSemana + '_semana_46'}" class="flex items-center justify-center whc-1 programado-${params.semana_46} status-${params.proceso_46}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 46); botonesMenuMP('${params.proceso_46}');">
                <h1 class="">46</h1>
            </div>

            <div id="${params.idSemana + '_semana_47'}" class="flex items-center justify-center whc-1 programado-${params.semana_47} status-${params.proceso_47}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 47); botonesMenuMP('${params.proceso_47}');">
                <h1 class="">47</h1>
            </div>

            <div id="${params.idSemana + '_semana_48'}" class="flex items-center justify-center whc-1 programado-${params.semana_48} status-${params.proceso_48}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 48); botonesMenuMP('${params.proceso_48}');">
                <h1 class="">48</h1>
            </div>

            <div id="${params.idSemana + '_semana_49'}" class="flex items-center justify-center whc-1 programado-${params.semana_49} status-${params.proceso_49}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 49); botonesMenuMP('${params.proceso_49}');">
                <h1 class="">49</h1>
            </div>

            <div id="${params.idSemana + '_semana_50'}" class="flex items-center justify-center whc-1 programado-${params.semana_50} status-${params.proceso_50}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 50); botonesMenuMP('${params.proceso_50}');">
                <h1 class="">50</h1>
            </div>

            <div id="${params.idSemana + '_semana_51'}" class="flex items-center justify-center whc-1 programado-${params.semana_51} status-${params.proceso_51}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 51); botonesMenuMP('${params.proceso_51}');">
                <h1 class="">51</h1>
            </div>

            <div id="${params.idSemana + '_semana_52'}" class="flex items-center justify-center whc-1 programado-${params.semana_52} status-${params.proceso_52}" onclick="opcionesMenuMP(this.id, ${params.idSemana}, ${params.idProceso}, ${params.idEquipo}, ${params.idPlan}, 52); botonesMenuMP('${params.proceso_52}');">
                <h1 class="">52</h1>
            </div>

        </div>
    `
};


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


// ********** FUNCIONES PARA MODAL DE EQUIPOS **********
// Función para los inptus de modalMPEquipos
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
        url: "../php/plannerCrudPHP.php",
        data: {
            action: action,
            idUsuario: idUsuario,
            idDestino: idDestino,
            idEquipo: idEquipo
        },
        dataType: "JSON",
        success: function (data) {
            document.getElementById("btnAdjuntosEquipo").
                setAttribute('onclick', 'toggleModalTailwind("modalMedia")');

            obtenerImagenesEquipo(idEquipo);
            consultarPlanEquipo(idEquipo);
            document.getElementById("inputAdjuntos").
                setAttribute("onchange", "subirImagenGeneral(" + idEquipo + ',"t_equipos_adjuntos_america")');

            document.getElementById("QREquipo").
                setAttribute("src", "https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=svg&bgcolor=fff&color=4a5568&data=www.maphg.com/equipos?id=" + idEquipo);

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


// Obtiene el Calendario de MP de los Equipos
function consultarPlanEquipo(idEquipo) {
    document.getElementById("contenedorPlanesEquipo").innerHTML = '';
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = "consultarPlanEquipo";
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
        setAttribute('onclick', `programarMP(${idSemana}, ${idProceso}, ${idEquipo}, ${semanaX}, ${idPlan}, "SOLUCIONAROT")`);

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


// Obtiene las posibles opciones del Equipo para Actualizarlo
function consultarOpcionesEquipo() {
    let idUsuario = localStorage.getItem('usuario');
    let idDestino = localStorage.getItem('idDestino');
    const action = "consultarOpcionesEquipo";
    $.ajax({
        type: "POST",
        url: "../php/plannerCrudPHP.php",
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
        url: "../php/plannerCrudPHP.php",
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
                consultaEquiposLocales();
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 3000);
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
            // console.log(data);
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
                } else {
                    alertaImg("Intente de Nuevo", "", "info", 3000);
                }
                // console.log(data);
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

// ********** FUNCIONES PARA MODAL DE EQUIPOS **********






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

