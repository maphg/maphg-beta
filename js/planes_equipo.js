'use strict'

const $ContenedorPlanesEquipos = document.getElementById('contenedorPlanesEquipo');
const datosPlanEquipo = params => {
    return `
        <div class="flex-none flex flex-row w-100 justify-evenly items-center flex-wrap cursor-pointer rounded-lg p-2 mr-6 border border-gray-300">

            <div class="w-full text-center font-semibold text-xs uppercase flex flex-row items-center justify-between leading-none mb-2"> 

                <div class="flex flex-col items-start">
                    <h1 class="text-lg">${params.periodicidad}</h1>
                    <h1 class="text-xs px-1 inline-flex leading-snug font-bold rounded-sm bg-red-200 text-red-500 uppercase">${params.tipoPlan}</h1>
                </div>

                <div class="flex text-xs font-bold">
                    <div class="programado-PLANIFICADO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                        <h1>5</h1>
                    </div>
                    <div class="status-PROCESO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                        <h1>5</h1>
                    </div>
                    <div class="status-SOLUCIONADO w-6 h-6 rounded-full mr-1 flex justify-center items-center">
                        <h1>4</h1>
                    </div>
                    <div class="mx-2 flex justify-center items-center text-xxs">
                        <a href="#">Ver detalles</a>
                    </div>
                </div>

            </div>     

            <div id="${params.idPlaneacion + '_semana_1'}" aria-describedby="tooltip" class="flex items-center justify-center whc-1 programado-${params.semana_1} status-${params.semana_1}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 1);">
                <h1 class="">01</h1>
            </div>  

            <div id="${params.idPlaneacion + '_semana_2'}" class="flex items-center justify-center whc-1 programado-${params.semana_2} status-${params.semana_2}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 2);">
                <h1 class="">02</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_3'}" class="flex items-center justify-center whc-1 programado-${params.semana_3} status-${params.semana_3}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 3);">
                <h1 class="">03</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_4'}" class="flex items-center justify-center whc-1 programado-${params.semana_4} status-${params.semana_4}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 4);">
                <h1 class="">04</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_5'}" class="flex items-center justify-center whc-1 programado-${params.semana_5} status-${params.semana_5}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 5);">
                <h1 class="">05</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_6'}" class="flex items-center justify-center whc-1 programado-${params.semana_6} status-${params.semana_6}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 6);">
                <h1 class="">06</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_7'}" class="flex items-center justify-center whc-1 programado-${params.semana_7} status-${params.semana_7}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 7);">
                <h1 class="">07</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_8'}" class="flex items-center justify-center whc-1 programado-${params.semana_8} status-${params.semana_8}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 8);">
                <h1 class="">08</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_9'}" class="flex items-center justify-center whc-1 programado-${params.semana_9} status-${params.semana_9}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 9);">
                <h1 class="">09</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_10'}" class="flex items-center justify-center whc-1 programado-${params.semana_10} status-${params.semana_10}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 10);">
                <h1 class="">10</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_11'}" class="flex items-center justify-center whc-1 programado-${params.semana_11} status-${params.semana_11}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 11);">
                <h1 class="">11</h1>
            </div> 
            
            <div id="${params.idPlaneacion + '_semana_12'}" class="flex items-center justify-center whc-1 programado-${params.semana_12} status-${params.semana_12}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 12);">
                <h1 class="">12</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_13'}" class="flex items-center justify-center whc-1 programado-${params.semana_13} status-${params.semana_13}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 13);">
                <h1 class="">13</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_14'}" class="flex items-center justify-center whc-1 programado-${params.semana_14} status-${params.semana_14}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 14);">
                <h1 class="">14</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_15'}" class="flex items-center justify-center whc-1 programado-${params.semana_15} status-${params.semana_15}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 15);">
                <h1 class="">15</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_16'}" class="flex items-center justify-center whc-1 programado-${params.semana_16} status-${params.semana_16}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 16);">
                <h1 class="">16</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_17'}" class="flex items-center justify-center whc-1 programado-${params.semana_17} status-${params.semana_17}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 17);">
                <h1 class="">17</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_18'}" class="flex items-center justify-center whc-1 programado-${params.semana_18} status-${params.semana_18}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 18);">
                <h1 class="">18</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_19'}" class="flex items-center justify-center whc-1 programado-${params.semana_19} status-${params.semana_19}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 19);">
                <h1 class="">19</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_20'}" class="flex items-center justify-center whc-1 programado-${params.semana_20} status-${params.semana_20}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 20);">
                <h1 class="">20</h1>
            </div>  

            <div id="${params.idPlaneacion + '_semana_21'}" class="flex items-center justify-center whc-1 programado-${params.semana_21} status-${params.semana_21}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 21);">
                <h1 class="">21</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_22'}" class="flex items-center justify-center whc-1 programado-${params.semana_22} status-${params.semana_22}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 22);">
                <h1 class="">22</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_23'}" class="flex items-center justify-center whc-1 programado-${params.semana_23} status-${params.semana_23}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 23);">
                <h1 class="">23</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_24'}" class="flex items-center justify-center whc-1 programado-${params.semana_24} status-${params.semana_24}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 24);">
                <h1 class="">24</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_25'}" class="flex items-center justify-center whc-1 programado-${params.semana_25} status-${params.semana_25}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 25);">
                <h1 class="">25</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_26'}" class="flex items-center justify-center whc-1 programado-${params.semana_26} status-${params.semana_26}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 26);">
                <h1 class="">26</h1>
            </div> 

            <div id="${params.idPlaneacion + '_semana_27'}" class="flex items-center justify-center whc-1 programado-${params.semana_27} status-${params.semana_27}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 27);">
                <h1 class="">27</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_28'}" class="flex items-center justify-center whc-1 programado-${params.semana_28} status-${params.semana_28}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 28);">
                <h1 class="">28</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_29'}" class="flex items-center justify-center whc-1 programado-${params.semana_29} status-${params.semana_29}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 29);">
                <h1 class="">29</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_30'}" class="flex items-center justify-center whc-1 programado-${params.semana_30} status-${params.semana_30}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 30);">
                <h1 class="">30</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_31'}" class="flex items-center justify-center whc-1 programado-${params.semana_31} status-${params.semana_31}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 31);">
                <h1 class="">31</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_32'}" class="flex items-center justify-center whc-1 programado-${params.semana_32} status-${params.semana_32}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 32);">
                <h1 class="">32</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_33'}" class="flex items-center justify-center whc-1 programado-${params.semana_33} status-${params.semana_33}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 33);">
                <h1 class="">33</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_34'}" class="flex items-center justify-center whc-1 programado-${params.semana_34} status-${params.semana_34}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 34);">
                <h1 class="">34</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_35'}" class="flex items-center justify-center whc-1 programado-${params.semana_35} status-${params.semana_35}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 35);">
                <h1 class="">35</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_36'}" class="flex items-center justify-center whc-1 programado-${params.semana_36} status-${params.semana_36}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 36);">
                <h1 class="">36</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_37'}" class="flex items-center justify-center whc-1 programado-${params.semana_37} status-${params.semana_37}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 37);">
                <h1 class="">37</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_38'}" class="flex items-center justify-center whc-1 programado-${params.semana_38} status-${params.semana_38}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 38);">
                <h1 class="">38</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_39'}" class="flex items-center justify-center whc-1 programado-${params.semana_39} status-${params.semana_39}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 39);">
                <h1 class="">39</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_40'}" class="flex items-center justify-center whc-1 programado-${params.semana_40} status-${params.semana_40}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 40);">
                <h1 class="">40</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_41'}" class="flex items-center justify-center whc-1 programado-${params.semana_41} status-${params.semana_41}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 41);">
                <h1 class="">41</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_42'}" class="flex items-center justify-center whc-1 programado-${params.semana_42} status-${params.semana_42}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 42);">
                <h1 class="">42</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_43'}" class="flex items-center justify-center whc-1 programado-${params.semana_43} status-${params.semana_43}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 43);">
                <h1 class="">43</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_44'}" class="flex items-center justify-center whc-1 programado-${params.semana_44} status-${params.semana_44}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 44);">
                <h1 class="">44</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_45'}" class="flex items-center justify-center whc-1 programado-${params.semana_45} status-${params.semana_45}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 45);">
                <h1 class="">45</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_46'}" class="flex items-center justify-center whc-1 programado-${params.semana_46} status-${params.semana_46}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 46);">
                <h1 class="">46</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_47'}" class="flex items-center justify-center whc-1 programado-${params.semana_47} status-${params.semana_47}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 47);">
                <h1 class="">47</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_48'}" class="flex items-center justify-center whc-1 programado-${params.semana_48} status-${params.semana_48}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 48);">
                <h1 class="">48</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_49'}" class="flex items-center justify-center whc-1 programado-${params.semana_49} status-${params.semana_49}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 49);">
                <h1 class="">49</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_50'}" class="flex items-center justify-center whc-1 programado-${params.semana_50} status-${params.semana_50}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 50);">
                <h1 class="">50</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_51'}" class="flex items-center justify-center whc-1 programado-${params.semana_51} status-${params.semana_51}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 51);">
                <h1 class="">51</h1>
            </div>

            <div id="${params.idPlaneacion + '_semana_52'}" class="flex items-center justify-center whc-1 programado-${params.semana_52} status-${params.semana_52}" onclick="opcionesMenuMP(this.id, ${params.idPlaneacion}, ${params.idEquipo}, 52);">
                <h1 class="">52</h1>
            </div>

        </div>
    `
};

function opcionesMenuMP(id, idPlaneacion, idEquipo, semanaX) {
    console.log(id, idPlaneacion, idEquipo, semanaX);

    document.getElementById("tooltipMP").classList.remove('hidden');

    document.getElementById('semanaProgramacionMP').innerHTML = '(Semana ' + semanaX + ')';
    const button = document.getElementById(id);
    const tooltip = document.getElementById('tooltipMP');

    Popper.createPopper(button, tooltip, {
        placement: 'top',
    });

    document.getElementById("programarMPIndividual").
        setAttribute('onclick', `programarMP(${idPlaneacion}, ${idEquipo}, ${semanaX}, "PROGRAMARINDIVIDUAL")`);

    document.getElementById("programarMPDesdeAqui").
        setAttribute('onclick', `programarMP(${idPlaneacion}, ${idEquipo}, ${semanaX}, "PROGRAMARDESDEAQUI")`);

    document.getElementById("programarMPPersonalizado").
        setAttribute('onclick', `programarMP(${idPlaneacion}, ${idEquipo}, ${semanaX}, "PROGRAMARPERSONALIZADO")`);
    document.getElementById("eliminarMPIndividual").
        setAttribute('onclick', `programarMP(${idPlaneacion}, ${idEquipo}, ${semanaX}, "ELIMINARINDIVIDUAL")`);

    document.getElementById("eliminarMPDesdeAqui").
        setAttribute('onclick', `programarMP(${idPlaneacion}, ${idEquipo}, ${semanaX}, "ELIMINARDESDEAQUI")`);

    document.getElementById("generarOTMP").
        setAttribute('onclick', `programarMP(${idPlaneacion}, ${idEquipo}, ${semanaX}, "GENERAROT")`);

    document.getElementById("solucionarOTMP").
        setAttribute('onclick', `programarMP(${idPlaneacion}, ${idEquipo}, ${semanaX}, "SOLUCIONAROT")`);

    document.getElementById("cancelarOTMP").
        setAttribute('onclick', `programarMP(${idPlaneacion}, ${idEquipo}, ${semanaX}, "CANCELAROT")`);


}


// Oculta tooltip de las semanas
function cerrarTooltip(id) {
    document.getElementById(id).classList.add('hidden');
}