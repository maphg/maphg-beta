// FILTROS
const filtroPalabra = document.getElementById("filtroPalabra");
const filtroResponsable = document.getElementById("filtroResponsable");
const filtroSeccion = document.getElementById("filtroSeccion");
const filtroSubseccion = document.getElementById("filtroSubseccion");
const filtroEquipos = document.getElementById("filtroEquipos");
const filtroTipo = document.getElementById("filtroTipo");
const filtroTipoIncidencia = document.getElementById("filtroTipoIncidencia");
const filtroStatus = document.getElementById("filtroStatus");
const filtroStatusIncidencia = document.getElementById("filtroStatusIncidencia");
const filtroFecha = document.getElementById("filtroFecha");
// FILTROS

// BTNS
const btnExportarExcel = document.getElementById("btnExportarExcel");
const btnExportarPDF = document.getElementById("btnExportarPDF");
const btnFiltroPalabra = document.getElementById("btnFiltroPalabra");
const btnColumnaPendientesSolucionados = document.getElementById("btnColumnaPendientesSolucionados");
const btnColumnaSecciones = document.getElementById("btnColumnaSecciones");
const btnColumnaSubsecciones = document.getElementById("btnColumnaSubsecciones");
const btnColumnaActivosPrincipales = document.getElementById("btnColumnaActivosPrincipales");
const btnColumnaActivosSecundarios = document.getElementById("btnColumnaActivosSecundarios");
// BTNS

// CONTENEDORES DIV
const contenedorRangoFecha = document.getElementById("contenedorRangoFecha");
const loader = document.getElementById("loader");
const contenedor = document.getElementById("contenedor");
// CONTENEDORES DIV

// GRAFICA
const chartdiv2 = document.getElementById("chartdiv2");
// GRAFICA


// TOGGLE PARA CUALQUIER CLASE
const toggleClassX = (idElemento, claseX) => {
    if (x = document.getElementById(idElemento)) {
        x.classList.toggle(claseX);
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
    data.append('filtroResponsableEjecucion', filtroResponsableEjecucion.value);
    data.append('filtroSeccion', filtroSeccion.value);
    data.append('filtroSubseccion', filtroSubseccion.value);
    data.append('filtroEquipos', filtroEquipos.value);
    data.append('filtroTipo', filtroTipo.value);
    data.append('filtroTipoIncidencia', filtroTipoIncidencia.value);
    data.append('filtroStatus', filtroStatus.value);
    data.append('filtroStatusIncidencia', filtroStatusIncidencia.value);
    data.append('filtroFecha', filtroFecha.value);

    const action = "obtenerReporte";
    const URL = `php/reporte_entregas.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    loader.innerHTML = iconoLoader;

    fetch(URL, {
        method: 'POST',
        body: data
    })
        .then(array => array.json())
        .then(array => {
            if (array.length) {
                // CONTADORES
                let contadorEmergencia = 0;
                let contadorUrgencia = 0;
                let contadorAlarma = 0;
                let contadorAlerta = 0;
                let contadorSeguimiento = 0;
                let arrayGrafica = [];
                let pendientes = 0;
                let solucionados = 0;
                const arrayItems = [];

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
                    const adjuntos = array[x].adjuntos;
                    const idSeccion = array[x].idSeccion;
                    const idSubseccion = array[x].idSubseccion;
                    const equipoPrincial = array[x].equipoPrincial;
                    const equipoSecundario = array[x].equipoSecundario;
                    const seccion = array[x].seccion;
                    const subseccion = array[x].subseccion;
                    const idEquipo = array[x].idEquipo;
                    const idEquipoPrincipal = array[x].idEquipoPrincipal;
                    const idEquipoSecundario = array[x].idEquipoSecundario;
                    const empresa = array[x].empresa;

                    // OPCION DE STATUS
                    const fStatus = status == 'SOLUCIONADO' ?
                        `onclick="cambiarStatus('INCIDENCIA',${idItem})"`
                        : `onclick="cambiarStatus('INCIDENCIA',${idItem})"`;

                    // HTML PARA COMENTARIO (COMENTARIO, CREADO POR, FECHA)
                    const dataComentario = comentario.length > 0 ?
                        `
                            <h1 class="text-center mb-2 font-semibold">Ultimo Mensaje</h1>
                            <div class="rounded w-full p-2 bg-green-200">
                                <p class="text-justify">${comentario}</p>
                            </div>
                            <div class="flex py-1 px-2 rounded-full items-center text-bluegray-700 justify-center text-xxs">
                                <h1 class="mr-1">Por: </h1>
                                <h1 class="font-bold mr-2">${ComentarioDe}</h1>
                                <h1 class="">${comentarioFecha}</h1>
                            </div>
                        `
                        : `
                        <div class="rounded w-full p-2 bg-green-200">
                            <h1 class="text-xxs text-center font-semibold">Sin Comentarios</h1>
                        </div>
                        `


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

                    const sEPX = sEP >= 1 ? `
                        <div class="w-5 h-5 flex items-center justify-center flex-none rounded-full mr-1 bg-purple-300 text-purple-600 text-xxs font-bold text-white text-center">
                            <h1>EP</h1>
                        </div>                    
                    ` : ``;

                    const equipoPrincipalX = equipoPrincial != "" ?
                        `<div class="uppercase py-1 px-2 bg-white rounded mb-1 shadow">
                                <h1>${equipoPrincial}</h1>
                            </div>`
                        : '';

                    const equipoSecundarioX = equipoSecundario != "" ?
                        `<div class="uppercase py-1 px-2 bg-white rounded mr-2 mb-1 shadow">
                                <h1>${equipoSecundario}</h1>
                            </div>`
                        : '';

                    const fExpandir = `onclick="toggleClassX('mostrar_mas_${idItem}', 'hidden'); 
                    toggleClassX('titulo_incidencia_${idItem}', 'truncate'); toggleClassX('titulo_incidencia_${idItem}', 'mb-1'); toggleClassX('titulo_incidencia_${idItem}', 'text-justify');"`;

                    const colorStatus = status == "SOLUCIONADO" ? 'orange' : 'green';
                    const textoStatus = status == "SOLUCIONADO" ? 'CAMBIAR COMO PENDIENTE' : 'SOLUCIONAR';

                    // CONTADOR DE PENDIENTES
                    if (columna == "COLUMNA") {
                        if (status == "SOLUCIONADO") {
                            pendientes++;
                        } else {
                            solucionados++;
                        }
                        if ((x + 1) == array.length) {
                            document.getElementById("totalSolucionados").innerHTML = pendientes++;
                            document.getElementById("totalPendientes").innerHTML = solucionados++;
                        }
                    } else if (columna == "SECCIONES") {
                        arrayItems.push(idSeccion);
                        if ((x + 1) == array.length) {
                            contadorArray(arrayItems);
                        }
                    } else if (columna == "SUBSECCIONES") {
                        arrayItems.push(idSubseccion);
                        if ((x + 1) == array.length) {
                            contadorArray(arrayItems);
                        }
                    } else if (columna == "ACTIVOSPRINCIPALES") {
                        if (idEquipoPrincipal > 0) {
                            arrayItems.push(idEquipoPrincipal);
                        } else {
                            arrayItems.push(idEquipo);
                        }
                        if ((x + 1) == array.length) {
                            contadorArray(arrayItems);
                        }
                    } else if (columna == "ACTIVOSSECUNDARIOS") {
                        arrayItems.push(idEquipo);
                        if ((x + 1) == array.length) {
                            contadorArray(arrayItems);
                        }
                    }

                    // ADJUNTOS DE LAS INCIDENCIAS
                    const adjuntosX = (adjuntos) => {
                        let codigo = '';
                        if (adjuntos.length) {
                            for (let x = 0; x < adjuntos.length; x++) {
                                const url = adjuntos[x].url;
                                const tipo = adjuntos[x].tipo;
                                if (tipo == "jpeg" || tipo == "jpg" || tipo == "png") {
                                    codigo += `<a href="planner/tareas/adjuntos/${url}" target="_blank" data-title="Clic para Abrir" draggable="false">
                                    <div class="bg-local bg-cover bg-center w-14 h-14 rounded-md border-2 mx-1 my-2 cursor-pointer" style="background-image: url(planner/tareas/adjuntos/${url})">
                                    </div>
                                </a>`;
                                } else {
                                    codigo += `<a href="planner/tareas/adjuntos/${url}" target="_blank">
                                        <div class="auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mx-1 my-2  w-14 h-14">
                                            <i class="fad fa-file-alt fa-4x"></i>
                                            </p>
                                        </div>
                                    </a>`
                                }
                            }
                        }
                        return codigo;
                    }
                    // EMPRESA RESPONSABLE
                    const empresaX = empresa.length > 0 ?
                        `<div class="flex bg-white shadow py-1 px-2 rounded-full items-center text-bluegray-700">
                            <p class="text-xs font-bold mx-1">${empresa}</p>
                        </div>` : '';

                    const codigo = `
                        <div class="w-6/6 flex flex-col h-auto mx-2 my-3 rounded cursor-pointer relative ring ring-${color}-200 bg-green-100" ${fExpandir}>
                        <!-- PARTE VISIBLE -->
                        <div class="w-full p-1 flex flex-none flex-col">
                            <h1 id="titulo_incidencia_${idItem}" class="font-semibold lowercase mb-1 text-justify truncate">
                            ${titulo}</h1>
                            <div class="flex justify-between">
                            <div class="flex bg-white shadow py-1 px-2 rounded-full items-center text-bluegray-700">
                                <img src="https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=${creadoPor}" width="20" height="20" alt="" />
                                <p class="text-xs font-bold mx-1">${creadoPor}</p>
                            </div>
                            ${empresaX}
                            <div class="flex justify-around items-center">
                                ${sEPX}
                            </div>
                            </div>
                            <div class="flex leading-none text-xs px-1 mt-2 font-semibold flex-wrap">
                            <div class="uppercase py-1 px-2 bg-white rounded mr-2 mb-1 shadow">
                                <h1>${seccion}</h1>
                            </div>
                            <div class="uppercase py-1 px-2 bg-white rounded mr-2 mb-1 shadow">
                                <h1>${subseccion}</h1>
                            </div>
                            ${equipoPrincipalX}
                            ${equipoSecundarioX}
                            </div>
                        </div>
                        <!-- PARTE VISIBLE -->
                        <!-- PARTE TOOGLEABLE -->
                        <div id="mostrar_mas_${idItem}" class="flex flex-col items-center justify-start p-2 text-xs w-full hidden">
                        <div class="py-2 flex flex-row justify-center items-center">${adjuntosX(adjuntos)}</div>
                            ${dataComentario}
                            <div class="flex px-2 mt-2 w-full">
                            <button class="py-2 px-2 rounded-l w-full bg-${colorStatus}-300 text-${colorStatus}-500 hover:bg-${colorStatus}-400 hover:text-${colorStatus}-200" ${fStatus}>${textoStatus}</button>
                            </div>
                        </div>
                        <!-- PARTE TOOGLEABLE -->
                        </div>
                    `;

                    if (columna == "COLUMNA") {
                        if (status == "PENDIENTE") {
                            if (contenedorX = document.getElementById("dataPendientes")) {
                                contenedorX.classList.remove('hidden');
                                contenedorX.insertAdjacentHTML('beforeend', codigo);
                            }
                        } else {
                            if (contenedorX = document.getElementById("dataSolucionados")) {
                                contenedorX.classList.remove('hidden');
                                contenedorX.insertAdjacentHTML('beforeend', codigo);
                            }
                        }
                    } else if (columna == "SECCIONES") {
                        if (contenedorX = document.getElementById("dataPendientesSeccion_" + idSeccion)) {
                            contenedorX.classList.remove('hidden');
                            contenedorX.insertAdjacentHTML('beforeend', codigo);
                        }
                    } else if (columna == "SUBSECCIONES") {
                        if (contenedorX = document.getElementById("dataPendientesSubseccion_" + idSubseccion)) {
                            contenedorX.classList.remove('hidden');
                            contenedorX.insertAdjacentHTML('beforeend', codigo)
                        }
                    } else if (columna == "ACTIVOSPRINCIPALES") {
                        if (contenedorX = document.getElementById("dataPendientesSubseccion_" + idEquipoPrincipal)) {
                            contenedorX.insertAdjacentHTML('beforeend', codigo)
                        }

                        if (contenedorY = document.getElementById("dataPendientesSubseccion_" + idEquipo)) {
                            contenedorY.insertAdjacentHTML('beforeend', codigo)
                        }

                    } else if (columna == "ACTIVOSSECUNDARIOS") {
                        if (contenedorZ = document.getElementById("dataPendientesSubseccion_" + idEquipo)) {
                            contenedorZ.insertAdjacentHTML('beforeend', codigo)
                        }
                    }
                }
            } else {
                alertaImg('No hay Datos', '', 'info', 1500);
            }
        })
        .then(() => {
            loader.innerHTML = '';
        })
        .catch(function (err) {
            // LIMPIA CONTENEDORES
            loader.innerHTML = '';
            contenedor.innerHTML = '';
        })
}


// OPCIÓN DE STATUS
const cambiarStatus = (tipo, idItem) => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "cambiarStatus";
    const URL = `php/reporte_entregas.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&tipo=${tipo}&idItem=${idItem}`;

    alertify.confirm('MAPHG', '¿Desea Aplicar la Acción?', () => {

        fetch(URL)
            .then(array => array.json())
            .then(array => {
                if (array == 1) {
                    alertaImg('Incidencia Solucionada', '', 'success', 1500);
                    btnFiltroPalabra.click();
                } else if (array == 2) {
                    alertaImg('Incidencia Restaurada', '', 'success', 1500);
                    btnFiltroPalabra.click();
                } else {
                    alertaImg('Intente de Nuevo', '', 'info', 1500);
                }
            })
            .catch(function (err) {
                alertaImg('Intente de Nuevo', '', 'info', 1500);
            })
    }
        , () => { alertaImg('Operación Cancelada', '', 'error', 1500) });
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
        alertaImg('No hay Datos', '', 'info', 1500);
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


// OBTIENE LOS RESPONSABLES DE EJECUCIÓN
const obtenerResponsablesEjecucion = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerResponsablesEjecucion";
    const URL = `php/reporte_entregas.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            filtroResponsableEjecucion.innerHTML = '<option value="0">Todos</option>';
            return array;
        })
        .then(array => {
            if (array.length) {
                for (let x = 0; x < array.length; x++) {
                    const idEmpresa = array[x].idEmpresa;
                    const empresa = array[x].empresa;
                    const codigo = `<option value="${idEmpresa}">${empresa}</option>`;
                    filtroResponsableEjecucion.insertAdjacentHTML('beforeend', codigo);
                }
            }
        })
        .catch(function (err) {
            filtroResponsableEjecucion.innerHTML = '<option value="0">Todos</option>';
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
                filtroEquipos.innerHTML = '<option value="0">Todos</option>';
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
                filtroEquipos.innerHTML = '<option value="0">Todos</option>';
            })
    } else {
        filtroSubseccion.innerHTML = '<option value="0">TODOS</option>';
    }
})


filtroSubseccion.addEventListener('change', () => {
    obtenerOpcionEquipos();
})


// OBTIENE EQUIPOS SEGÚN LA SECCIÓN Y SUBSECCIÓN
const obtenerOpcionEquipos = () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const action = "obtenerOpcionEquipos";
    const URL = `php/reporte_entregas.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&filtroSeccion=${filtroSeccion.value}&filtroSubseccion=${filtroSubseccion.value}`;

    fetch(URL)
        .then(array => array.json())
        .then(array => {
            filtroEquipos.innerHTML = '<option value="0">Todos</option>';
            return array;
        })
        .then(array => {
            if (array.length) {
                for (let x = 0; x < array.length; x++) {
                    const idEquipo = array[x].idEquipo;
                    const equipo = array[x].equipo;
                    const codigo = `<option value="${idEquipo}">${equipo}</option>`;
                    filtroEquipos.insertAdjacentHTML('beforeend', codigo);
                }
            } else {
                alertaImg('No se Encontraron Activos Principales', '', 'info', 1500);
            }
        })
        .catch(function (err) {
            // fetch(APIERROR + err);
            filtroEquipos.innerHTML = '<option value="0">Todos</option>';
        })
}


// DISEÑO DE BOTONES
const opcionBotones = btn => {
    btnColumnaPendientesSolucionados.classList.remove('text-gray-7000', 'bg-white', 'shadow');
    btnColumnaPendientesSolucionados.classList.add('bg-gray-100');
    btnColumnaSecciones.classList.remove('text-gray-7000', 'bg-white', 'shadow');
    btnColumnaSecciones.classList.add('bg-gray-100');
    btnColumnaSubsecciones.classList.remove('text-gray-7000', 'bg-white', 'shadow');
    btnColumnaSubsecciones.classList.add('bg-gray-100');
    btnColumnaActivosPrincipales.classList.remove('text-gray-7000', 'bg-white', 'shadow');
    btnColumnaActivosPrincipales.classList.add('bg-gray-100');
    btnColumnaActivosSecundarios.classList.remove('text-gray-7000', 'bg-white', 'shadow');
    btnColumnaActivosSecundarios.classList.add('bg-gray-100');

    if (btn == "COLUMNA") {
        btnColumnaPendientesSolucionados.classList.add('text-gray-700', 'bg-white', 'shadow');
        btnColumnaPendientesSolucionados.classList.remove('bg-gray-100');
        btnFiltroPalabra.setAttribute('onclick', `opcionBotones('${btn}')`);
        return
    }

    if (btn == "SECCIONES") {
        btnColumnaSecciones.classList.add('text-gray-700', 'bg-white', 'shadow');
        btnColumnaSecciones.classList.remove('bg-gray-100');
        btnFiltroPalabra.setAttribute('onclick', `opcionBotones('${btn}')`);
        return
    }

    if (btn == "SUBSECCIONES") {
        btnColumnaSubsecciones.classList.add('text-gray-700', 'bg-gray-100', 'text-gray-300');
        btnColumnaSubsecciones.classList.remove('bg-gray-100');
        btnFiltroPalabra.setAttribute('onclick', `opcionBotones('${btn}')`);
        return
    }

    if (btn == "ACTIVOSPRINCIPALES") {
        btnColumnaActivosPrincipales.classList.add('text-gray-700', 'bg-white', 'shadow');
        btnColumnaActivosPrincipales.classList.remove('bg-gray-100');
        btnFiltroPalabra.setAttribute('onclick', `opcionBotones('${btn}')`);
        return
    }

    if (btn == "ACTIVOSSECUNDARIOS") {
        btnColumnaActivosSecundarios.classList.add('text-gray-700', 'bg-white', 'shadow');
        btnColumnaActivosSecundarios.classList.remove('bg-gray-100');
        btnFiltroPalabra.setAttribute('onclick', `opcionBotones('${btn}')`);
        return
    }
}



// EXPORTA EXCEL
btnExportarExcel.addEventListener('click', () => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');

    const filtroPalabraX = filtroPalabra.value.replace(/|=| |-|^|`|'|"|&/gi, '');

    const URL = `php/exportar_excel_GET.php?action=reporteIncidencia&idDestino=${idDestino}&idUsuario=${idUsuario}&filtroPalabra=${filtroPalabraX}&filtroResponsable=${filtroResponsable.value}&filtroSeccion=${filtroSeccion.value}&filtroSubseccion=${filtroSubseccion.value}&filtroTipo=${filtroTipo.value}&filtroTipoIncidencia=${filtroTipoIncidencia.value}&filtroStatus=${filtroStatus.value}&filtroStatusIncidencia=${filtroStatusIncidencia.value}&filtroFecha=${filtroFecha.value}&filtroFechaInicio=&filtroFechaFin=`;

    window.open(URL);
})


// CREA LOS CONTENEDORES DE RESULTADOS
const crearContenedores = tipoContenedor => {
    let idDestino = localStorage.getItem('idDestino');
    let idUsuario = localStorage.getItem('usuario');


    //COLUMNA DE PENDIENTES Y SOLUCIONADOS. 
    if (tipoContenedor == "COLUMNA") {
        contenedor.innerHTML = '';

        contenedor.insertAdjacentHTML('beforeend', `
            <div class="md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0">
                <div class="flex text-xxs rounded-full bg-red-100 pr-2 items-center w-40">
                    <div class="w-6 h-6 rounded-full bg-red-300 text-red-500 font-bold flex items-center justify-center mr-2 flex-none">
                        <h1 id="totalPendientes">0</h1>
                    </div>
                    <h1 class="font-bold text-gray-500 uppercase text-sm text-red-500">Pendientes</h1>
                </div>
                <div class="overflow-y-auto scrollbar px-1" style="max-height: 80vh">
                    <div id="dataPendientes"></div>
                </div>
            </div>
            <div class="md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0">
                <div class="flex text-xxs rounded-full bg-green-100 pr-2 items-center w-40">
                    <div class="w-6 h-6 rounded-full bg-green-300 text-green-500 font-bold flex items-center justify-center mr-2 flex-none">
                        <h1 id="totalSolucionados">0</h1>
                    </div>
                    <h1 class="font-bold uppercase text-sm text-green-500">Solucionados</h1>
                </div>
                <div class="overflow-y-auto scrollbar px-1" style="max-height: 80vh">
                    <div id="dataSolucionados"></div>
                </div>
            </div>
        `)
        obtenerReporte(tipoContenedor);
        opcionBotones(tipoContenedor);
        return
    }


    // COLUMNAS DE SECCIONES
    if (tipoContenedor == "SECCIONES") {
        contenedor.innerHTML = '';

        const action = "obtenerSeccionesPorDestino";
        const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}`;

        fetch(URL)
            .then(array => array.json())
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
                                <div class="w-6 h-6 rounded-full bg-${estilo}-300 text-${estilo}-500 font-bold flex items-center justify-center mr-2 flex-none">
                                    <h1 id="cantidad_incidencias_${idSeccion}">0</h1>
                                </div>
                                <h1 class="font-bold text-gray-500 uppercase text-sm text-${estilo}-500">${seccion}</h1>
                            </div>
                            <div class="overflow-y-auto scrollbar px-1" style="max-height: 900px;">
                                <div id="dataPendientesSeccion_${idSeccion}"></div>
                             </div>
                        </div>
                    `;
                        contenedor.insertAdjacentHTML('beforeend', codigo);
                    }
                }
            })
            .then(() => {
                obtenerReporte(tipoContenedor);
                opcionBotones(tipoContenedor);
            })
            .catch(function (err) {
                contenedor.innerHTML = '';
            })
        return
    }


    // COLUMNA DE SUBSECCIONES
    if (tipoContenedor == "SUBSECCIONES") {

        const action = "obtenerSubseccionPorSeccion";
        const URL = `php/select_REST_planner.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&idSeccion=${filtroSeccion.value}`;

        if (filtroSeccion.value > 0) {
            contenedor.innerHTML = '';
            fetch(URL)
                .then(array => array.json())
                .then(array => {
                    if (array) {
                        for (let x = 0; x < array.length; x++) {
                            const idSubseccion = array[x].idSubseccion;
                            const subseccion = array[x].subseccion;

                            const estilo = filtroSeccion.value == 9 ? 'red'
                                : filtroSeccion.value == 8 ? 'blue'
                                    : filtroSeccion.value == 10 ? 'yellow'
                                        : filtroSeccion.value == 11 ? 'green'
                                            : filtroSeccion.value == 24 ? 'cyan'
                                                : filtroSeccion.value == 1 ? 'purple'
                                                    : filtroSeccion.value == 6 ? 'orange'
                                                        : filtroSeccion.value == 12 ? 'blue'
                                                            : filtroSeccion.value == 5 ? 'indigo'
                                                                : filtroSeccion.value == 7 ? 'red'
                                                                    : 'gray';

                            const codigo = `  
                                <div id="columna_x_${idSubseccion}" class="flex-none md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0 px-1 hidden">
                                    <div class="w-40 flex text-xxs rounded-full bg-${estilo}-100 pr-2 items-center">
                                        <div class="w-6 h-6 rounded-full bg-${estilo}-300 text-${estilo}-500 font-bold flex items-center justify-center mr-2 flex-none">
                                            <h1 id="cantidad_incidencias_${idSubseccion}">0</h1>
                                        </div>
                                        <h1 class="font-bold text-gray-500 uppercase text-xxs text-${estilo}-500">${subseccion}</h1>
                                    </div>
                                    <div class="overflow-y-auto scrollbar px-1" style="max-height: 900px;">
                                        <div id="dataPendientesSubseccion_${idSubseccion}"></div>
                                    </div>
                                </div>
                            `;
                            contenedor.insertAdjacentHTML('beforeend', codigo);
                        }
                    }
                })
                .then(() => {
                    obtenerReporte(tipoContenedor);
                    opcionBotones(tipoContenedor)
                })
                .catch(function (err) {
                    contenedor.innerHTML = '';
                })
        } else {
            alertaImg('Elija una Sección en el Filtro', '', 'info', 1500);
        }
        return
    }


    // COLUMNA DE EQUIPOS PRINCIPALES
    if (tipoContenedor == "ACTIVOSPRINCIPALES") {

        const action = "obtenerEquiposPrincipales";
        const URL = `php/reporte_entregas.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&filtroSeccion=${filtroSeccion.value}&filtroSubseccion=${filtroSubseccion.value}`
        filtroEquipos.value = 0;

        if (filtroSeccion.value > 0 && filtroSubseccion.value > 0) {
            contenedor.innerHTML = '';
            fetch(URL)
                .then(array => array.json())
                .then(array => {
                    if (array.length) {
                        for (let x = 0; x < array.length; x++) {
                            const idEquipo = array[x].idEquipo;
                            const equipo = array[x].equipo;
                            const codigo = `  
                                <div id="columna_x_${idEquipo}" class="flex-none md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0 px-1 hidden">
                                    <div class="w-auto flex text-xxs rounded-full bg-white pr-2 items-center">
                                        <div class="w-6 h-6 rounded-full bg-gray-900 font-bold flex items-center justify-center mr-2 flex-none">
                                            <h1 id="cantidad_incidencias_${idEquipo}" class="text-white w-auto">0</h1>
                                        </div>
                                        <h1 class="font-bold uppercase text-xxs text-gray-900">${equipo}</h1>
                                    </div>
                                    <div class="overflow-y-auto scrollbar px-1" style="max-height: 900px;">
                                        <div id="dataPendientesSubseccion_${idEquipo}"></div>
                                    </div>
                                </div>
                            `;
                            contenedor.insertAdjacentHTML('beforeend', codigo);
                        }
                    } else {
                        alertaImg('No se Encontraron Equipos', '', 'info', 1500);
                    }
                })
                .then(() => {
                    obtenerReporte(tipoContenedor);
                    opcionBotones(tipoContenedor);
                })
                .catch(function (err) {
                })
        } else {
            alertaImg('Elija Sección y Subsección', '', 'info', 1500);
        }
    }


    // COLUMNA DE EQUIPOS SECUNDARIOS
    if (tipoContenedor == "ACTIVOSSECUNDARIOS") {

        const action = "obtenerEquiposSecundarios";
        const URL = `php/reporte_entregas.php?action=${action}&idDestino=${idDestino}&idUsuario=${idUsuario}&filtroSeccion=${filtroSeccion.value}&filtroSubseccion=${filtroSubseccion.value}&filtroEquipos=${filtroEquipos.value}`

        if (filtroEquipos.value > 0) {
            contenedor.innerHTML = '';
            fetch(URL)
                .then(array => array.json())
                .then(array => {
                    if (array.length) {
                        for (let x = 0; x < array.length; x++) {
                            const idEquipo = array[x].idEquipo;
                            const equipo = array[x].equipo;
                            const codigo = `  
                                <div id="columna_x_${idEquipo}" class="flex-none md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0 px-1 hidden">
                                    <div class="w-auto flex text-xxs rounded-full bg-white pr-2 items-center">
                                        <div class="w-6 h-6 rounded-full bg-gray-900 font-bold flex items-center justify-center mr-2 flex-none">
                                            <h1 id="cantidad_incidencias_${idEquipo}" class="text-white w-auto">0</h1>
                                        </div>
                                        <h1 class="font-bold uppercase text-xxs text-gray-900">${equipo}</h1>
                                    </div>
                                    <div class="overflow-y-auto scrollbar px-1" style="max-height: 900px;">
                                        <div id="dataPendientesSubseccion_${idEquipo}"></div>
                                    </div>
                                </div>
                            `;
                            contenedor.insertAdjacentHTML('beforeend', codigo);
                        }
                    } else {
                        alertaImg('No se Encontraron Equipos', '', 'info', 1500);
                    }
                })
                .then(() => {
                    obtenerReporte(tipoContenedor);
                    opcionBotones(tipoContenedor);
                })
                .catch(function (err) {
                })
        } else {
            alertaImg('Seleccione el Equipo Principal', '', 'info', 1500);
        }
    }
}


// INICIA FILTROS DEPUES DE CARGAR
window.addEventListener('load', () => {
    obtenerUsuarios();
    obtenerSeccionesPorDestino();
    obtenerResponsablesEjecucion();

    btnColumnaPendientesSolucionados.setAttribute('onclick', "crearContenedores('COLUMNA')");
    btnColumnaSecciones.setAttribute('onclick', "crearContenedores('SECCIONES')");
    btnColumnaSubsecciones.setAttribute('onclick', "crearContenedores('SUBSECCIONES')");
    btnColumnaActivosPrincipales.setAttribute('onclick', "crearContenedores('ACTIVOSPRINCIPALES')");
    btnColumnaActivosSecundarios.setAttribute('onclick', "crearContenedores('ACTIVOSSECUNDARIOS')");

    document.getElementById('destinosSelecciona').addEventListener('click', () => {
        obtenerUsuarios();
        obtenerSeccionesPorDestino();
        opcionBotones('');
        contenedor.innerHTML = '';
    })
})