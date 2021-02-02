'use strict'

const datosPlanEquipo = params => {
    return `
        <div class="flex-none flex flex-row w-100 justify-evenly items-center flex-wrap cursor-pointer rounded-lg p-2 mr-6 border border-gray-300 my-1">

            <div class="w-full text-center font-semibold text-xs uppercase flex flex-row items-center justify-between leading-none mb-2"> 

                <div class="flex flex-col items-start">
                    <h1 class="text-lg">ID: ${params.idPlan}</h1>
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

// Oculta tooltip de las semanas
function cerrarTooltip(id) {
    document.getElementById(id).classList.add('hidden');
}