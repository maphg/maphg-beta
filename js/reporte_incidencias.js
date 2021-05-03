// FILTROS
const filtroPalabra = document.getElementById("filtroPalabra");
const filtroResponsable = document.getElementById("filtroResponsable");
const filtroSeccion = document.getElementById("filtroSeccion");
const filtroSubseccion = document.getElementById("filtroSubseccion");
const filtroTipo = document.getElementById("filtroTipo");
const filtroTipoIncidencia = document.getElementById("filtroTipoIncidencia");
const filtroStatus = document.getElementById("filtroStatus");
const filtroStatusIncidencia = document.getElementById("filtroStatusIncidencia");
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
const btnColumnaTabla = document.getElementById("btnColumnaTabla");
// BTNS

// CONTENEDORES DIV
const contenedorRangoFecha = document.getElementById("contenedorRangoFecha");
const loader = document.getElementById("loader");
const totalPendientes = document.getElementById("totalPendientes");
const totalSolucionados = document.getElementById("totalSolucionados");
// CONTENEDORES DIV

// CONTENEDORES DATA
const dataPendientes = document.getElementById("dataPendientes");
const dataSolucionados = document.getElementById("dataSolucionados");
const contenedorSeccion = document.getElementById("contenedorSeccion");
const contenedorSubsecciones = document.getElementById("contenedorSubsecciones");
const contenedorTabla = document.getElementById("contenedorTabla");
const contenedorItems = document.getElementById("contenedorItems");
// CONTENEDORES DATA

// GRAFICA
const chartdiv2 = document.getElementById("chartdiv2");
// GRAFICA


// TOGGLE PARA CUALQUIER CLASE
const toggleClassX = (idElemento, claseX) => {
    if (document.getElementById(idElemento).classList.toggle(claseX)) {
    }
}

iconoLoader = '<img src="svg/lineal_animated_loop.svg" width="35px" height="35px">';

// GENERA REPORTE CON LOS FILTROS (COLUMNA: PRECESO - SOLUCIONADO)
const obtenerReporte = columna => {
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
    data.append('filtroStatusIncidencia', filtroStatusIncidencia.value);
    data.append('filtroFecha', filtroFecha.value);
    data.append('filtroFechaInicio', filtroFechaInicio.value);
    data.append('filtroFechaFin', filtroFechaFin.value);

    if (columna == "SUBSECCION") {
        crearContenedoresSubsecciones(filtroSeccion.value)
    }

    const action = "obtenerReporte";
    const URL = `php/reporte_incidencias.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;


    fetch(URL, {
        method: 'POST',
        body: data
    })
        .then(array => array.json())
        .then(array => {
            // LIMPIA CONTENEDORES
            loader.innerHTML = iconoLoader;
            dataPendientes.innerHTML = '';
            dataSolucionados.innerHTML = '';
            contenedorItems.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                // CONTADORES
                let contadorEmergencia = 0;
                let contadorUrgencia = 0;
                let contadorAlarma = 0;
                let contadorAlerta = 0;
                let contadorSeguimiento = 0;
                let arrayGrafica = [];
                let pendientes = 0;
                let solucionados = 0;
                let arraySecciones = [];
                let arraySubsecciones = [];

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
                    const totalAdjuntos = array[x].totalAdjuntos;
                    const idSeccion = array[x].idSeccion;
                    const seccion = array[x].seccion;
                    const idSubseccion = array[x].idSubseccion;
                    const subseccion = array[x].subseccion;
                    const equipoPrincipal = array[x].equipoPrincipal;
                    const equipoSecundario = array[x].equipoSecundario;
                    const proyecto = array[x].proyecto;
                    const pda = array[x].pda;
                    const responsable = array[x].responsable;
                    const cod2bend = array[x].cod2bend;
                    const fechaLlegada = '';
                    const fechaCreacion = array[x].fechaCreacion;

                    // COLORES POR SECCION
                    const colorSeccion = idSeccion == 9 ? 'red'
                        : idSeccion == 8 ? 'blue'
                            : idSeccion == 10 ? 'yellow'
                                : idSeccion == 11 ? 'green'
                                    : idSeccion == 24 ? 'cyan'
                                        : idSeccion == 1 ? 'purple'
                                            : idSeccion == 6 ? 'orange'
                                                : idSeccion == 12 ? 'blue'
                                                    : idSeccion == 5 ? 'indigo'
                                                        : idSeccion == 7 ? 'red'
                                                            : 'gray';

                    // ICONO PARA COMENTARIOS
                    const iconoComentario = comentario.length > 0 ?
                        `
                            <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full ml-2">
                                <i class="fas fa-comment-alt-dots"></i>
                            </div>
                        ` : '';

                    // ICONO PARA ADJUNTOS
                    const iconoAdjunto = totalAdjuntos > 0 ?
                        `
                            <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full">
                                <i class="fas fa-paperclip"></i>
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
                        : '<h1 class="text-xxs text-center font-semibold">Sin Comentarios</h1>'

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
                    const color = tipoIncidencia == "EMERGENCIA" ? `red`
                        : tipoIncidencia == "URGENCIA" ? `orange`
                            : tipoIncidencia == "ALARMA" ? `yellow`
                                : tipoIncidencia == "ALERTA" ? `blue`
                                    : tipoIncidencia == "SEGUIMIENTO" ? `green`
                                        : tipoIncidencia == "PREVENTIVO" ? `gray`
                                            : tipoIncidencia == "PROYECTO" ? `purple`
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

                    const diseñoStatus = status == "PENDIENTE" || status == "PROCESO" ? 'yellow' : 'green';

                    // CONTADOR DE PENDIENTES
                    if (columna == "COLUMNA") {
                        if (status == "SOLUCIONADO") {
                            pendientes++;
                        } else {
                            solucionados++;
                        }
                        if ((x + 1) == array.length) {
                            totalSolucionados.innerHTML = pendientes++;
                            totalPendientes.innerHTML = solucionados++;
                        }
                    } else if (columna == "SECCION") {
                        arraySecciones.push(idSeccion);
                        if ((x + 1) == array.length) {
                            contadorArray(arraySecciones);
                        }
                    } else if (columna == "SUBSECCION") {
                        arraySubsecciones.push(idSubseccion);
                        if ((x + 1) == array.length) {
                            contadorArray(arraySubsecciones);
                        }
                    }

                    const fExpandir = `onclick="toggleClassX('mostrar_mas_${x}', 'hidden'); 
                    toggleClassX('titulo_incidencia_${x}', 'truncate'); toggleClassX('titulo_incidencia_${x}', 'mb-1'); toggleClassX('titulo_incidencia_${x}', 'text-justify');"`;

                    const codigo = `
                        <div class="w-full flex flex-col h-auto my-3 rounded cursor-pointer relative ring ring-${color}-200 bg-${color}-100" 
                        ${fExpandir}>
                            <!-- PARTE VISIBLE -->
                            <div class="w-full p-1 flex flex-none flex-col">
                                <h1 id="titulo_incidencia_${x}" class="truncate font-semibold lowercase">${titulo}</h1>
                                <div class="flex justify-between">
                                    <div class="flex bg-white shadow py-1 px-2 rounded-full items-center text-bluegray-700">
                                        <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${creadoPor}" width="20" height="20" alt="">
                                        <p class="text-xs font-bold mx-1">${creadoPor}</p>
                                       ${iconoComentario}
                                        ${iconoAdjunto}
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
                            <div id="mostrar_mas_${x}" class="flex flex-col items-center justify-start p-2 text-xs w-full hidden">
                                <div class="rounded w-full p-2 bg-${color}-200">
                                    ${dataComentario}
                                </div>
                                <div class="flex px-2 mt-2 w-full">
                                    <button class="py-2 px-2 rounded-l w-1/2  bg-${color}-300 text-${color}-500 hover:bg-${color}-400 hover:text-${color}-200">Editar</button>
                                    <button class="py-2 px-2 rounded-r w-1/2 bg-${color}-300 text-${color}-500 hover:bg-${color}-400 hover:text-${color}-200">PDF</button>
                                </div>
                            </div>
                            <!-- PARTE TOOGLEABLE -->
                        </div>
                    `;

                    if (columna == "COLUMNA") {
                        if (status === "PENDIENTE") {
                            dataPendientes.insertAdjacentHTML('beforeend', codigo);
                        } else {
                            dataSolucionados.insertAdjacentHTML('beforeend', codigo);
                        }
                    } else if (columna == "SECCION") {
                        if (document.getElementById("dataPendientesSeccion_" + idSeccion)) {
                            document.getElementById("dataPendientesSeccion_" + idSeccion).
                                insertAdjacentHTML('beforeend', codigo)
                        }
                    } else if (columna == "SUBSECCION") {
                        if (document.getElementById("dataPendientesSubseccion_" + idSubseccion)) {
                            document.getElementById("dataPendientesSubseccion_" + idSubseccion).
                                insertAdjacentHTML('beforeend', codigo)
                        }
                    } else if (columna == "TABLA") {
                        const codigoTabla = `
                        <tr class="cursor-pointer hover:bg-gray-50">
                            <td class="px-6 py-4 text-left">
                                <p class="">
                                    ${seccion}
                                </p>
                                <p class="text-gray-500 font-semibold tracking-wide">
                                    ${subseccion}
                                </p>
                            </td>
                            <td>
                                <h1>${responsable}</h1>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <p>${equipoSecundario}</p>
                            </td>
                            <td>
                                <p>${titulo}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="">
                                    ${tipo}
                                </p>
                                <p class="text-${color}-500 font-semibold tracking-wide">
                                    ${tipoIncidencia}
                                </p>
                            </td>
                            <td class="px-6 py-4 bg-${diseñoStatus}-200">
                                <span class="text-${diseñoStatus}-800  font-semibold px-2 rounded-full">
                                    ${status}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="">
                                   ${creadoPor}
                                </p>
                                <p class="text-gray-500 font-semibold tracking-wide">
                                    ${fechaCreacion}
                                </p>
                            </td>
                            <td class="">
                                <div class="flex flex-wrap justify-around items-center">
                                        ${sMaterialX}
                                        ${sTrabajandoX}
                                        ${sEnergeticoX}
                                        ${sDepartamentoX}
                                        ${sEPX}
                                </div>
                            </td>
                            <td>
                                <p>${cod2bend}</p>
                            </td>
                            <td>
                                <p>${fechaLlegada}</p>
                            </td>
                        </tr>
                    `;
                        contenedorItems.insertAdjacentHTML('beforeend', codigoTabla);
                    }

                }
            } else {
                alertaImg('Sin Registros', '', 'info', 1500);
            }
        })
        .then(() => {
            loader.innerHTML = '';
        })
        .catch(function (err) {
            // fetch(APIERROR + err);
            // LIMPIA CONTENEDORES
            console.error(err);
            dataPendientes.innerHTML = '';
            dataSolucionados.innerHTML = '';
            contenedorSeccion.innerHTML = '';
            contenedorSubsecciones.innerHTML = '';
            loader.innerHTML = '';
        })
}


// CONTADOR DE RESULTADOS
const contadorArray = array => {
    if (array) {
        var repetidos = {};
        array.forEach(function (numero) {
            repetidos[numero] = (repetidos[numero] || 0) + 1;
        })

        for (const index in repetidos) {
            if (element = document.querySelector('#cantidad_incidencias_' + index)) {
                element.innerHTML = repetidos[index];
                if (repetidos[index] > 0 && (columna = document.querySelector('#columna_x_' + index))) {
                    columna.classList.remove('hidden');
                }
            }
        }
    } else {
        alertaImg('Sin Registros', '', 'info', 1500);
    }
}


// GRAFICA DE INCIDENCIAS
const graficaIncidencias = array => {
    chartdiv2.classList.remove('hidden');
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
        am4core.color("#66D4F1"),
        am4core.color("#62DDBD"),
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
            })
    } else {
        filtroSubseccion.innerHTML = '<option value="0">TODOS</option>';
    }
})


// EVENTO PARA OPCION DE COLUMNAS
btnColumnaPendientesSolucionados.addEventListener('click', () => {
    totalPendientes.innerHTML = 0;
    totalSolucionados.innerHTML = 0;
    btnColumnaPendientesSolucionados.classList.add('bg-white', 'shadow');
    btnColumnaSecciones.classList.remove('bg-white', 'shadow');
    btnColumnaSubsecciones.classList.remove('bg-white', 'shadow');
    btnColumnaTabla.classList.remove('bg-white', 'shadow');
    btnColumnaPendientesSolucionados.classList.remove('bg-gray-100', 'text-gray-300');
    btnColumnaSecciones.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSubsecciones.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaTabla.classList.add('bg-gray-100', 'text-gray-300');
    contenedorPendientesSolucionados.classList.remove('hidden');
    contenedorSeccion.classList.add('hidden');
    contenedorSubsecciones.classList.add('hidden');
    contenedorTabla.classList.add('hidden');
    btnFiltroPalabra.setAttribute('onclick', `obtenerReporte('COLUMNA')`);

    obtenerReporte('COLUMNA');
    btnFiltroPalabra.setAttribute('onclick', `obtenerReporte('COLUMNA');`);
})

btnColumnaSecciones.addEventListener('click', async () => {
    btnColumnaPendientesSolucionados.classList.remove('bg-white', 'shadow');
    btnColumnaSecciones.classList.add('bg-white', 'shadow');
    btnColumnaSubsecciones.classList.remove('bg-white', 'shadow');
    btnColumnaTabla.classList.remove('bg-white', 'shadow');
    btnColumnaPendientesSolucionados.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSecciones.classList.remove('bg-gray-100', 'text-gray-300');
    btnColumnaSubsecciones.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaTabla.classList.add('bg-gray-100', 'text-gray-300');
    contenedorPendientesSolucionados.classList.add('hidden');
    contenedorSeccion.classList.remove('hidden');
    contenedorSubsecciones.classList.add('hidden');
    contenedorTabla.classList.add('hidden');
    btnFiltroPalabra.setAttribute('onclick', `obtenerReporte('SECCION')`);

    await crearContenedoresSecciones()
    await obtenerReporte('SECCION')
    btnFiltroPalabra.setAttribute('onclick', `obtenerReporte('SECCION');`);
})

btnColumnaSubsecciones.addEventListener('click', async () => {
    btnColumnaPendientesSolucionados.classList.remove('bg-white', 'shadow');
    btnColumnaSecciones.classList.remove('bg-white', 'shadow');
    btnColumnaSubsecciones.classList.add('bg-white', 'shadow');
    btnColumnaPendientesSolucionados.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSecciones.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSubsecciones.classList.remove('bg-gray-100', 'text-gray-300');
    contenedorPendientesSolucionados.classList.add('hidden');
    contenedorSeccion.classList.add('hidden');
    contenedorSubsecciones.classList.add('hidden');
    contenedorTabla.classList.add('hidden');
    btnFiltroPalabra.setAttribute('onclick', `obtenerReporte('SUBSECCION')`);

    await obtenerReporte('SUBSECCION');
    await crearContenedoresSubsecciones(filtroSeccion.value);
    btnFiltroPalabra.setAttribute('onclick', `obtenerReporte('SUBSECCION');`);
})

btnColumnaTabla.addEventListener('click', () => {
    btnColumnaPendientesSolucionados.classList.remove('bg-white', 'shadow');
    btnColumnaSecciones.classList.remove('bg-white', 'shadow');
    btnColumnaSubsecciones.classList.remove('bg-white', 'shadow');
    btnColumnaTabla.classList.add('bg-white', 'shadow');
    btnColumnaPendientesSolucionados.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSecciones.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaSubsecciones.classList.add('bg-gray-100', 'text-gray-300');
    btnColumnaTabla.classList.remove('bg-gray-100', 'text-gray-300');
    contenedorPendientesSolucionados.classList.add('hidden');
    contenedorSeccion.classList.add('hidden');
    contenedorSubsecciones.classList.add('hidden');
    contenedorTabla.classList.remove('hidden');
    btnFiltroPalabra.setAttribute('onclick', `obtenerReporte('SUBSECCION')`);

    obtenerReporte('TABLA');
    btnFiltroPalabra.setAttribute('onclick', `obtenerReporte('TABLA');`);
})


// CREA CONTENEDORES SECCIONES
const crearContenedoresSecciones = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSeccionesPorDestino";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            contenedorSeccion.innerHTML = '';
            return array;
        })
        .then(array => {
            if (array) {
                for (let x = 0; x < array.length; x++) {
                    const idSeccion = array[x].idSeccion;
                    const seccion = array[x].seccion;

                    const estilo = idSeccion == 9 ? 'red'
                        : idSeccion == 8 ? 'blue'
                            : idSeccion == 10 ? 'yellow'
                                : idSeccion == 11 ? 'green'
                                    : idSeccion == 24 ? 'cyan'
                                        : idSeccion == 1 ? 'purple'
                                            : idSeccion == 6 ? 'orange'
                                                : idSeccion == 12 ? 'blue'
                                                    : idSeccion == 5 ? 'indigo'
                                                        : idSeccion == 7 ? 'red'
                                                            : 'gray';

                    const codigo = `  
                        <div id="columna_x_${idSeccion}" class="flex-none md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0 px-1 hidden">      
                            <div class="w-40 flex text-xxs rounded-full bg-${estilo}-100 pr-2 items-center">
                                <div class="w-6 h-6 rounded-full bg-${estilo}-300 text-${estilo}-500 font-bold flex items-center justify-center mr-2">
                                    <h1 id="cantidad_incidencias_${idSeccion}">0</h1>
                                </div>
                                <h1 class="font-bold text-gray-500 uppercase text-sm text-${estilo}-500">${seccion}</h1>
                            </div>
                            <div class="overflow-y-auto scrollbar px-1" style="max-height: 900px;">
                                <div id="dataPendientesSeccion_${idSeccion}"></div>
                             </div>
                        </div>
                    `;
                    contenedorSeccion.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            contenedorSeccion.innerHTML = '';
            // fetch(APIERROR + err);
        })
}


// CREA CONTENEDORES SUBSECCIONES
const crearContenedoresSubsecciones = idSeccion => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerSubseccionPorSeccion";
    const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${idSeccion}`;

    contenedorSubsecciones.innerHTML = '';

    if (idSeccion > 0) {
        fetch(URL)
            .then(array => array.json())
            .then(array => {
                if (array) {
                    for (let x = 0; x < array.length; x++) {
                        const idSubseccion = array[x].idSubseccion;
                        const subseccion = array[x].subseccion;

                        const estilo = idSeccion == 9 ? 'red'
                            : idSeccion == 8 ? 'blue'
                                : idSeccion == 10 ? 'yellow'
                                    : idSeccion == 11 ? 'green'
                                        : idSeccion == 24 ? 'cyan'
                                            : idSeccion == 1 ? 'purple'
                                                : idSeccion == 6 ? 'orange'
                                                    : idSeccion == 12 ? 'blue'
                                                        : idSeccion == 5 ? 'indigo'
                                                            : idSeccion == 7 ? 'red'
                                                                : 'gray';

                        const codigo = `  
                        <div id="columna_x_${idSubseccion}" class="flex-none md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0 px-1 hidden">
                            <div class="w-40 flex text-xxs rounded-full bg-${estilo}-100 pr-2 items-center">
                                <div class="w-6 h-6 rounded-full bg-${estilo}-300 text-${estilo}-500 font-bold flex items-center justify-center mr-2">
                                    <h1 id="cantidad_incidencias_${idSubseccion}">0</h1>
                                </div>
                                <h1 class="font-bold text-gray-500 uppercase text-xxs text-${estilo}-500">${subseccion}</h1>
                            </div>
                            <div class="overflow-y-auto scrollbar px-1" style="max-height: 900px;">
                                <div id="dataPendientesSubseccion_${idSubseccion}"></div>
                             </div>
                        </div>
                    `;
                        contenedorSubsecciones.insertAdjacentHTML('beforeend', codigo);
                    }
                }
            })
            .catch(function (err) {
                contenedorSubsecciones.innerHTML = '';
                // fetch(APIERROR + err);
            })
    } else {
        alertaImg('Agregue un Sección en el Filtro', '', 'info', 1400);
    }
}


filtroFecha.addEventListener('change', () => {
    if (filtroFecha.value == "RANGO") {
        contenedorRangoFecha.classList.remove('hidden');
    } else {
        contenedorRangoFecha.classList.add('hidden');
    }
})


btnExportarExcel.addEventListener('click', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const filtroPalabraX = filtroPalabra.value.replace(/|=| |-|^|`|'|"|&/gi, '');

    const URL = `php/exportar_excel_GET.php?action=reporteIncidencia&idDestino=${idDestino}&idUsuario=${idUsuario}&filtroPalabra=${filtroPalabraX}&filtroResponsable=${filtroResponsable.value}&filtroSeccion=${filtroSeccion.value}&filtroSubseccion=${filtroSubseccion.value}&filtroTipo=${filtroTipo.value}&filtroTipoIncidencia=${filtroTipoIncidencia.value}&filtroStatus=${filtroStatus.value}&filtroStatusIncidencia=${filtroStatusIncidencia.value}&filtroFecha=${filtroFecha.value}&filtroFechaInicio=${filtroFechaInicio.value}&filtroFechaFin=${filtroFechaFin.value}`;

    window.open(URL);
})


// INICIA FILTROS DEPUES DE CARGAR
window.addEventListener('load', () => {
    obtenerUsuarios()
    obtenerSeccionesPorDestino()
    btnFiltroPalabra.setAttribute('onclick', () => { })
})


