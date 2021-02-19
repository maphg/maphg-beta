// FILTROS
const filtroPalabra = document.getElementById("filtroPalabra");
const filtroResponsable = document.getElementById("filtroResponsable");
const filtroSeccion = document.getElementById("filtroSeccion");
const filtroSubseccion = document.getElementById("filtroSubseccion");
const filtroTipo = document.getElementById("filtroTipo");
const filtroTipoIncidencia = document.getElementById("filtroTipoIncidencia");
const filtroStatus = document.getElementById("filtroStatus");
const filtroFecha = document.getElementById("filtroFecha");
const filtroFechaInicio = document.getElementById("filtroFechaInicio");
const filtroFechaFin = document.getElementById("filtroFechaFin");
// FILTROS

// BTNS
const btnExportarExcel = document.getElementById("btnExportarExcel");
const btnExportarPDF = document.getElementById("btnExportarPDF");
const btnFiltroPalabra = document.getElementById("btnFiltroPalabra");
const btnColumnaPendientesSolucionados = document.getElementById("btnColumnaPendientesSolucionados");
const btnColumnaSecciones = document.getElementById("btnColumnaSecciones");
const btnColumnaSubsecciones = document.getElementById("btnColumnaSubsecciones");
// BTNS

// CONTENEDORES DIV
const contenedorRangoFecha = document.getElementById("contenedorRangoFecha");
// CONTENEDORES DIV

// CONTENEDORES DATA
const dataPendientes = document.getElementById("dataPendientes");
const dataSolucionados = document.getElementById("dataSolucionados");
const contenedorSeccion = document.getElementById("contenedorSeccion");
const contenedorSubsecciones = document.getElementById("contenedorSubsecciones");
// CONTENEDORES DATA


// EXPANDIR
const expandir = idElemento => {
    if (document.getElementById(idElemento).classList.toggle('hidden')) {
    }
}

// GENERA REPORTE CON LOS FILTROS
const obtenerReporte = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const data = new FormData();
    data.append('filtroPalabra', filtroPalabra.value);
    data.append('filtroResponsable', filtroResponsable.value);
    data.append('filtroSeccion', filtroSeccion.value);
    data.append('filtroSubseccion', filtroSubseccion.value);
    data.append('filtroTipo', filtroTipo.value);
    data.append('filtroTipoIncidencia', filtroTipoIncidencia.value);
    data.append('filtroStatus', filtroStatus.value);
    data.append('filtroFecha', filtroFecha.value);
    data.append('filtroFechaInicio', filtroFechaInicio.value);
    data.append('filtroFechaFin', filtroFechaFin.value);

    const action = "obtenerReporte";
    const URL = `php/reporte_incidencias.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    dataPendientes.innerHTML = '<img src="svg/lineal_animated_loop.svg" width="120px" height="120px">';
    dataSolucionados.innerHTML = '<img src="svg/lineal_animated_loop.svg" width="120px" height="120px">';

    fetch(URL, {
        method: 'POST',
        body: data
    })
        .then(array => array.json())
        .then(array => {
            // LIMPIA CONTENEDORES
            dataPendientes.innerHTML = '';
            dataSolucionados.innerHTML = '';
            contenedorSeccion.innerHTML = '';
            contenedorSubsecciones.innerHTML = '';

            console.log(array.length);
            return array;
        })
        .then(array => {
            if (array) {
                let contadorEmergencia = 0;
                let contadorUrgencia = 0;
                let contadorAlarma = 0;
                let contadorAlerta = 0;
                let contadorSeguimiento = 0;
                let arrayGrafica = [];
                for (let x = 0; x < array.length; x++) {
                    const idItem = array[x].idItem;
                    const titulo = array[x].titulo;
                    const status = array[x].status;
                    const tipo = array[x].tipo;
                    const tipoIncidencia = array[x].tipoIncidencia;
                    const sMaterial = array[x].sMaterial;
                    const sTrabajando = array[x].sTrabajando;
                    const sEnergetico = array[x].sEnergetico;
                    const sDepartamento = array[x].sDepartamento;
                    const sEP = array[x].sEP;
                    const creadoPor = array[x].creadoPor;
                    const comentario = array[x].comentario;
                    const comentarioFecha = array[x].comentarioFecha;
                    const ComentarioDe = array[x].ComentarioDe;

                    // ICONO PARA COMENTARIOS
                    const iconoComentario = comentario.length > 0 ?
                        `
                            <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full ml-2">
                                <i class="fas fa-comment-alt-dots"></i>
                            </div>
                        ` : '';

                    // HTML PARA COMENTARIO (COMENTARIO, CREADO POR, FECHA)
                    const dataComentario = comentario.length > 0 ?
                        `
                            <h1 class="text-center mb-2 font-semibold">Ultimo Mensaje</h1>
                            <p class="text-justify">${comentario}</p>
                            <div class="flex py-1 px-2 rounded-full items-center text-bluegray-700 justify-center text-xxs">
                            <h1 class="mr-1">Por: </h1>
                            <h1 class="font-bold mr-2">${ComentarioDe}</h1>
                            <h1 class="">${comentarioFecha}</h1>
                            </div>
                        `
                        : '<h1 class="text-center mb-2 font-semibold">Sin Mensaje</h1>'


                    tipoIncidencia == "EMERGENCIA" ? contadorEmergencia++
                        : tipoIncidencia == "URGENCIA" ? contadorUrgencia++
                            : tipoIncidencia == "ALARMA" ? contadorAlarma++
                                : tipoIncidencia == "ALERTA" ? contadorAlerta++
                                    : tipoIncidencia == "SEGUIMIENTO" ? contadorSeguimiento++
                                        : ''

                    // DATOS PARA GENERAR GRAFICA
                    if ((x + 1) == array.length) {
                        const totalIncidencias = 100 / (contadorEmergencia + contadorUrgencia + contadorAlarma + contadorAlerta + contadorSeguimiento);

                        arrayGrafica.push(contadorEmergencia * totalIncidencias);
                        arrayGrafica.push(contadorUrgencia * totalIncidencias);
                        arrayGrafica.push(contadorAlarma * totalIncidencias);
                        arrayGrafica.push(contadorAlerta * totalIncidencias);
                        arrayGrafica.push(contadorSeguimiento * totalIncidencias);
                        arrayGrafica.push(contadorEmergencia + contadorUrgencia + contadorAlarma + contadorAlerta + contadorSeguimiento);
                        graficaIncidencias(arrayGrafica);
                    }

                    // ESTILO PARA EL BORDE(RING)
                    const estiloIncidencia = tipoIncidencia == "EMERGENCIA" ? `ring ring-red-400 bg-red-100`
                        : tipoIncidencia == "URGENCIA" ? `ring ring-orange-400 bg-orange-100`
                            : tipoIncidencia == "ALARMA" ? `ring ring-yellow-400 bg-yellow-100`
                                : tipoIncidencia == "ALERTA" ? `ring ring-blue-400 bg-blue-100`
                                    : tipoIncidencia == "SEGUIMIENTO" ? `ring ring-green-400 bg-green-100`
                                        : tipoIncidencia == "PREVENTIVO" ? `ring ring-gray-400 bg-gray-100`
                                            : tipoIncidencia == "PROYECTO" ? `ring ring-purple-400 bg-purple-100`
                                                : ''

                    // ESTILO BACKGROUND 200
                    const bg200 = tipoIncidencia == "EMERGENCIA" ? `bg-red-200`
                        : tipoIncidencia == "URGENCIA" ? `bg-orange-200`
                            : tipoIncidencia == "ALARMA" ? `bg-yellow-200`
                                : tipoIncidencia == "ALERTA" ? `bg-blue-200`
                                    : tipoIncidencia == "SEGUIMIENTO" ? `bg-green-200`
                                        : tipoIncidencia == "PREVENTIVO" ? `bg-gray-200`
                                            : tipoIncidencia == "PROYECTO" ? `bg-purple-200`
                                                : ''

                    // ESTILO BACKGROUND 400
                    const bg400 = tipoIncidencia == "EMERGENCIA" ? `bg-red-400`
                        : tipoIncidencia == "URGENCIA" ? `bg-orange-400`
                            : tipoIncidencia == "ALARMA" ? `bg-yellow-400`
                                : tipoIncidencia == "ALERTA" ? `bg-blue-400`
                                    : tipoIncidencia == "SEGUIMIENTO" ? `bg-green-400`
                                        : tipoIncidencia == "PREVENTIVO" ? `bg-gray-400`
                                            : tipoIncidencia == "PROYECTO" ? `bg-purple-400`
                                                : ''

                    // ESTILO BACKGROUND 300
                    const bg300 = tipoIncidencia == "EMERGENCIA" ? `bg-red-300`
                        : tipoIncidencia == "URGENCIA" ? `bg-orange-300`
                            : tipoIncidencia == "ALARMA" ? `bg-yellow-300`
                                : tipoIncidencia == "ALERTA" ? `bg-blue-300`
                                    : tipoIncidencia == "SEGUIMIENTO" ? `bg-green-300`
                                        : tipoIncidencia == "PREVENTIVO" ? `bg-gray-300`
                                            : tipoIncidencia == "PROYECTO" ? `bg-purple-300`
                                                : ''

                    // ESTILO TEXT 200
                    const text200 = tipoIncidencia == "EMERGENCIA" ? `text-red-200`
                        : tipoIncidencia == "URGENCIA" ? `text-orange-200`
                            : tipoIncidencia == "ALARMA" ? `text-yellow-200`
                                : tipoIncidencia == "ALERTA" ? `text-blue-200`
                                    : tipoIncidencia == "SEGUIMIENTO" ? `text-green-200`
                                        : tipoIncidencia == "PREVENTIVO" ? `text-gray-200`
                                            : tipoIncidencia == "PROYECTO" ? `text-purple-200`
                                                : ''

                    // ESTILO TEXT 500
                    const text500 = tipoIncidencia == "EMERGENCIA" ? `text-red-500`
                        : tipoIncidencia == "URGENCIA" ? `text-orange-500`
                            : tipoIncidencia == "ALARMA" ? `text-yellow-500`
                                : tipoIncidencia == "ALERTA" ? `text-blue-500`
                                    : tipoIncidencia == "SEGUIMIENTO" ? `text-green-500`
                                        : tipoIncidencia == "PREVENTIVO" ? `text-gray-500`
                                            : tipoIncidencia == "PROYECTO" ? `text-purple-500`
                                                : ''

                    const sMaterialX = sMaterial >= 1 ? `
                        <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full mr-1 bg-bluegray-900 text-bluegray-100 text-xxs font-bold text-white text-center">
                            <h1>M</h1>
                        </div>                    
                    ` : ``;
                    const sTrabajandoX = sTrabajando >= 1 ? `
                        <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full mr-1 bg-blue-300 text-blue-600 text-xxs font-bold text-white text-center">
                            <h1>T</h1>
                        </div>                    
                    ` : ``;
                    const sEnergeticoX = sEnergetico >= 1 ? `
                        <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full mr-1 bg-yellow-300 text-yellow-600 text-xxs font-bold text-white text-center">
                            <h1>E</h1>
                        </div>                    
                    ` : ``;
                    const sDepartamentoX = sDepartamento >= 1 ? `
                        <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full mr-1 bg-cyan-300 text-cyan-600 text-xxs font-bold text-white text-center">
                            <h1>D</h1>
                        </div>                    
                    ` : ``;
                    const sEPX = sEP >= 1 ? `
                        <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full mr-1 bg-purple-300 text-purple-600 text-xxs font-bold text-white text-center">
                            <h1>EP</h1>
                        </div>                    
                    ` : ``;

                    const fExpandir = `onclick="expandir('mostrar_mas_${idItem}')"`;

                    const codigo = `
                        <div class="w-full flex flex-col h-auto my-2 rounded cursor-pointer ${estiloIncidencia}" ${fExpandir}>
                            <!-- PARTE VISIBLE -->
                            <div class="w-full p-1 flex flex-none flex-col">
                                <h1 class="truncate font-semibold">${titulo}</h1>
                                <div class="flex justify-between">
                                    <div class="flex bg-orange-300 py-1 px-2 rounded-full items-center text-bluegray-700">
                                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${creadoPor}" width="20" height="20" alt="">
                                        <p class="text-xs font-bold mx-1">${creadoPor}</p>
                                       ${iconoComentario}
                                        <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full hidden">
                                            <i class="fas fa-paperclip"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="flex justify-around items-center">
                                        ${sMaterialX}
                                        ${sTrabajandoX}
                                        ${sEnergeticoX}
                                        ${sDepartamentoX}
                                        ${sEPX}
                                    </div>
                                </div>
                            </div>
                            <!-- PARTE VISIBLE -->

                            <!-- PARTE TOOGLEABLE -->
                            <div id="mostrar_mas_${idItem}" class="flex flex-col items-center justify-start p-2 text-xs w-full hidden">
                                <div class="rounded w-full p-2 ${bg200}">
                                    ${dataComentario}
                                </div>
                                <div class="flex px-2 mt-2 w-full">
                                    <button class="py-2 px-2 rounded-l w-1/2 ${bg300} ${text500} hover:${bg400} hover:${text200}">Editar</button>
                                    <button class="py-2 px-2 rounded-r w-1/2 ${bg300} ${text500} hover:${bg400} hover:${text200}">PDF</button>
                                </div>
                            </div>
                            <!-- PARTE TOOGLEABLE -->

                        </div>
                    `;

                    if (status === "PENDIENTE") {
                        dataPendientes.insertAdjacentHTML('beforeend', codigo);
                    } else {
                        dataSolucionados.insertAdjacentHTML('beforeend', codigo);
                    }
                }
            }
        })
        .catch(function (err) {
            // fetch(APIERROR + err);
            console.log(err);
            // LIMPIA CONTENEDORES
            dataPendientes.innerHTML = '';
            dataSolucionados.innerHTML = '';
            contenedorSeccion.innerHTML = '';
            contenedorSubsecciones.innerHTML = '';
        })
}


// GRAFICA DE INCIDENCIAS
const graficaIncidencias = array => {
    // Themes begin
    am4core.useTheme(am4themes_animated);

    // Create chart instance
    var chart = am4core.create("chartdiv2", am4charts.RadarChart);

    // Add data
    chart.data = [{
        "category": "Emergencia",
        "value": array[0],
        "full": array[5]
    }, {
        "category": "Urgencia",
        "value": array[1],
        "full": array[5]
    }, {
        "category": "Alarma",
        "value": array[2],
        "full": array[5]
    }, {
        "category": "Alerta",
        "value": array[3],
        "full": array[5]
    }, {
        "category": "Seguimiento",
        "value": array[4],
        "full": array[5]
    }];

    // Make chart not full circle
    chart.startAngle = -90;
    chart.endAngle = 180;
    chart.innerRadius = am4core.percent(20);

    // Set number format
    chart.numberFormatter.numberFormat = "#.#'%'";

    // Create axes
    var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "category";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.grid.template.strokeOpacity = 0;
    categoryAxis.renderer.labels.template.horizontalCenter = "right";
    categoryAxis.renderer.labels.template.fontWeight = 500;
    categoryAxis.renderer.labels.template.adapter.add("fill", function (fill, target) {
        return (target.dataItem.index >= 0) ? chart.colors.getIndex(target.dataItem.index) : fill;
    });
    categoryAxis.renderer.minGridDistance = 10;

    var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
    valueAxis.renderer.grid.template.strokeOpacity = 0;
    valueAxis.min = 0;
    valueAxis.max = 100;
    valueAxis.strictMinMax = true;
    valueAxis.disabled = true;

    // Create series
    var series1 = chart.series.push(new am4charts.RadarColumnSeries());
    series1.dataFields.valueX = "full";
    series1.dataFields.categoryY = "category";
    series1.clustered = false;
    series1.columns.template.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
    series1.columns.template.fillOpacity = 0.08;
    series1.columns.template.cornerRadiusTopLeft = 20;
    series1.columns.template.strokeWidth = 0;
    series1.columns.template.radarColumn.cornerRadius = 20;

    var series2 = chart.series.push(new am4charts.RadarColumnSeries());
    series2.dataFields.valueX = "value";
    series2.dataFields.categoryY = "category";
    series2.clustered = false;
    series2.columns.template.strokeWidth = 0;
    series2.columns.template.tooltipText = "{category}: [bold]{value}[/]";
    series2.columns.template.radarColumn.cornerRadius = 20;

    series2.columns.template.adapter.add("fill", function (fill, target) {
        return chart.colors.getIndex(target.dataItem.index);
    });

    // Add cursor
    chart.cursor = new am4charts.RadarCursor();

    chart.colors.list = [
        am4core.color("#F76D82"),
        am4core.color("#FC8370"),
        am4core.color("#FCD277"),
        am4core.color("#62DDBD"),
        am4core.color("#66D4F1"),
        am4core.color("#F9F871")
    ];
}


// FILTRO PARA RESPONSABLES
const obtenerUsuarios = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerUsuarios";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            filtroResponsable.innerHTML = '<option value="0">Todos</option>';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idUsuarioX = array[x].idUsuario;
                    const nombre = array[x].nombre;
                    const apellido = array[x].apellido;

                    const codigo = `<option value="${idUsuarioX}">${nombre} ${apellido}</option>`;
                    filtroResponsable.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            filtroResponsable.innerHTML = '<option value="0">Todos</option>';
            // rerporteEror(err, '');
        })
}


// FILTRO PARA SECCIONES
const obtenerSeccionesPorDestino = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSeccionesPorDestino";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            filtroSeccion.innerHTML = '<option value="0">Todos</option>';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idSeccion = array[x].idSeccion;
                    const seccion = array[x].seccion;

                    const codigo = `<option value="${idSeccion}">${seccion}</option>`;
                    filtroSeccion.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            filtroSeccion.innerHTML = '<option value="0">Todos</option>';
            // rerporteEror(err, '');
        })
}


// FILTRO PARA SUBSECCIONES
filtroSeccion.addEventListener('change', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSubseccionPorSeccion";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${filtroSeccion.value}`;

    // ACTUALIZA RESULTADOS
    obtenerReporte();

    if (filtroSeccion.value > 0) {
        fetch(URL)
            .then(array => array.json())
            .then(array => {
                filtroSubseccion.innerHTML = '<option value="0">TODOS</option>';
                return array;
            })
            .then(array => {
                if (array) {
                    for (let x = 0; x < array.length; x++) {
                        const idSubseccion = array[x].idSubseccion;
                        const subseccion = array[x].subseccion;
                        const codigo = `<option value="${idSubseccion}">${subseccion}</option>`;

                        filtroSubseccion.insertAdjacentHTML('beforeend', codigo);
                    }
                }
            })
            .catch(function (err) {
                filtroSubseccion.innerHTML = '<option value="0">TODOS</option>';
                obtenerReporte();
            })
    } else {
        filtroSubseccion.innerHTML = '<option value="0">TODOS</option>';
    }
})


// EVENTO PARA OPCION DE COLUMNAS
btnColumnaPendientesSolucionados.addEventListener('click', () => {
    btnColumnaPendientesSolucionados.classList.add('bg-white', 'shadow');
    btnColumnaSecciones.classList.remove('bg-white', 'shadow');
    btnColumnaSubsecciones.classList.remove('bg-white', 'shadow');
    btnColumnaPendientesSolucionados.classList.remove('bg-gray-100', 'text-gray-300');
    btnColumnaSecciones.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSubsecciones.classList.add('bg-gray-100', 'text-gray-300');
    obtenerReporte();
})
btnColumnaSecciones.addEventListener('click', () => {
    btnColumnaPendientesSolucionados.classList.remove('bg-white', 'shadow');
    btnColumnaSecciones.classList.add('bg-white', 'shadow');
    btnColumnaSubsecciones.classList.remove('bg-white', 'shadow');
    btnColumnaPendientesSolucionados.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSecciones.classList.remove('bg-gray-100', 'text-gray-300');
    btnColumnaSubsecciones.classList.add('bg-gray-100', 'text-gray-300');
    obtenerReporte();
})
btnColumnaSubsecciones.addEventListener('click', () => {
    btnColumnaPendientesSolucionados.classList.remove('bg-white', 'shadow');
    btnColumnaSecciones.classList.remove('bg-white', 'shadow');
    btnColumnaSubsecciones.classList.add('bg-white', 'shadow');
    btnColumnaPendientesSolucionados.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSecciones.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSubsecciones.classList.remove('bg-gray-100', 'text-gray-300');
    obtenerReporte();
})


// EVENTOS PARA ACTUALIZAR RESULTADOS
btnFiltroPalabra.addEventListener('click', obtenerReporte)
filtroResponsable.addEventListener('change', obtenerReporte)
filtroSubseccion.addEventListener('change', obtenerReporte)
filtroTipo.addEventListener('change', obtenerReporte)
filtroTipoIncidencia.addEventListener('change', obtenerReporte)
filtroStatus.addEventListener('change', obtenerReporte)
filtroFecha.addEventListener('change', () => {
    obtenerReporte();
    if (filtroFecha.value == "RANGO") {
        contenedorRangoFecha.classList.remove('hidden');
    } else {
        // contenedorRangoFecha.classList.add('hidden');
    }
})
// filtroFechaFin.addEventListener('change', obtenerReporte)


filtroFechaFin.addEventListener('change', () => {
    obtenerReporte()
    console.log(filtroFechaFin.value);
    console.log(filtroFechaInicio.value);
})


// INICIA FILTROS DEPUES DE CARGAR
window.addEventListener('load', () => {
    obtenerUsuarios()
    obtenerSeccionesPorDestino()
})
