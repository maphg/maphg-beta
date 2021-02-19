<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG Reporte Incidencias</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion_2021.css">
    <!-- <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
</head>

<body style="background-color: #EEF0FC;" class="scrollbar">

    <div class="w-full h-screen flex sm:flex-col md:flex-row md:items-start md:justify-start p-8 sm:justify-start sm:items-center">
        <div class="bg-white md:w-80 sm:w-full h-auto rounded-xl shadow-lg flex flex-col justify-start items-center p-8 z-40 mb-4">
            <div class="flex">
                <input id="filtroPalabra" type="text" placeholder="Buscar incidencias" class="focus:outline-none focus:ring p-2 w-3/4 rounded-l-md mb-2 ring-bluegray-300" style="background-color: #F4F5F7;">
                <button id="btnFiltroPalabra" class="focus:outline-none focus:ring bg-gray-600 text-gray-50 p-2 rounded-r-md mb-2 cursor-pointer ring-lime-300">Buscar</button>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Responsable
                </label>
                <div class="relative">
                    <select id="filtroResponsable" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 scrollbar text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="0">TODOS</option>
                    </select>
                </div>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Sección
                </label>
                <div class="relative">
                    <select id="filtroSeccion" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="0">TODOS</option>
                    </select>
                </div>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Subsección
                </label>
                <div class="relative">
                    <select id="filtroSubseccion" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="0">TODOS</option>
                    </select>
                </div>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Tipo
                </label>
                <div class="relative">
                    <select id="filtroTipo" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="TODOS">TODOS</option>
                        <option value="INCIDENCIAS">Incidencias</option>
                        <option value="PREVENTIVOS">Preventivos</option>
                        <option value="PROYECTOS">Planes de acción proyectos</option>
                    </select>
                </div>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Criticidad
                </label>
                <div class="relative">
                    <select id="filtroTipoIncidencia" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="TODOS">TODOS</option>
                        <option value="EMERGENCIA">EMERGENCIA</option>
                        <option value="URGENCIA">URGENCIA</option>
                        <option value="ALARMA">ALARMA</option>
                        <option value="ALERTA">ALERTA</option>
                        <option value="SEGUIMIENTO">SEGUIMIENTO</option>
                    </select>
                </div>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Status
                </label>
                <div class="relative">
                    <select id="filtroStatus" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="TODOS">TODOS</option>
                        <option value="MATERIAL">MATERIAL</option>
                        <option value="TRABAJANDO">TRABAJANDO</option>
                        <option value="ELECTRICIDAD">ELECTRICIDAD</option>
                        <option value="AGUA">AGUA</option>
                        <option value="DIESEL">DIESEL</option>
                        <option value="GAS">GAS</option>
                        <option value="CALIDAD">CALIDAD</option>
                        <option value="COMPRAS">COMPRAS</option>
                        <option value="DIRECCION">DIRECCION</option>
                        <option value="FINANZAS">FINANZAS</option>
                        <option value="RRHH">RRHH</option>
                        <option value="EP">ENTREGAS PROYECTO</option>
                    </select>
                </div>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Fecha
                </label>
                <div class="relative">
                    <select id="filtroFecha" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="TODOS">TODOS</option>
                        <option value="SINPLANIFICAR">SIN PLANIFICAR</option>
                        <option value="PLANIFICADO">PLANIFICADO</option>
                        <option value="RANGO">RANGO</option>
                    </select>
                </div>
            </div>

            <div id="contenedorRangoFecha" class="w-full p-2 bg-gray-100 mb-2 hidden">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2 text-center" for="grid-state">
                    Seleccione rango
                </label>
                <label class="block tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    De:
                </label>
                <div class="relative">
                    <input id="filtroFechaInicio" type="date" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 bg-gray-200">
                </div>
                <label class="block tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    A:
                </label>
                <div class="relative">
                    <input id="filtroFechaFin" type="date" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 bg-gray-200">
                </div>

            </div>

            <div>
                <div id="chartdiv2" class="hidden" style="height: 280px; width: 100%;"></div>
            </div>

            <div class="flex justify-center items-center text-xs w-full">
                <button class="focus:outline-none focus:ring p-2 w-1/2 rounded-l-md  ring-lime-200 bg-lime-200 text-lime-900">
                    Exportar excel
                </button>
                <button class="focus:outline-none focus:ring p-2 w-1/2 rounded-r-md  ring-lime-200 bg-purple-200 text-purple-900">
                    Exportar OT
                </button>
            </div>
        </div>

        <div class="w-full flex flex-col px-4">
            <div class="w-full flex justify-start items-center p-4">
                <h1 class="font-bold text-xs text-gray-400 uppercase mr-4">Columnas</h1>

                <button id="btnColumnaPendientesSolucionados" class="bg-gray-100 text-gray-300 text-xs hover:bg-white hover:text-gray-700 hover:shadow uppercase font-bold rounded py-2 px-3 mr-4">Pendientes/Solucionados</button>

                <button id="btnColumnaSecciones" class="bg-gray-100 text-gray-300 text-xs hover:bg-white hover:text-gray-700 hover:shadow uppercase font-bold rounded py-2 px-3 mr-4">Secciones</button>

                <button id="btnColumnaSubsecciones" class="bg-gray-100 text-gray-300 text-xs hover:bg-white hover:text-gray-700 hover:shadow uppercase font-bold rounded py-2 px-3 mr-4">Subsecciones</button>

            </div>

            <div id="contenedorPendientesSolucionados" class="hidden w-full h-full flex sm:flex-col md:flex-row md:justify-start sm:justify-start">
                <div class="md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0">
                    <div class="flex text-xxs rounded-full bg-red-100 pr-2 items-center w-40">
                        <div class="w-6 h-6 rounded-full bg-red-300 text-red-500 font-bold flex items-center justify-center mr-2">
                            <h1>22</h1>
                        </div>
                        <h1 class="font-bold text-gray-500 uppercase text-sm text-red-500">Pendientes</h1>
                    </div>
                    <div class="overflow-y-auto scrollbar px-1" style="max-height: 80vh">
                        <div id="dataPendientes"> </div>
                    </div>
                </div>
                <div class="md:w-80 sm:w-full rounded flex flex-col justify-start p-4 z-40 md:mr-8 sm:mb-8 md:mb-0">
                    <div class="flex text-xxs rounded-full bg-green-100 pr-2 items-center w-40">
                        <div class="w-6 h-6 rounded-full bg-green-300 text-green-500 font-bold flex items-center justify-center mr-2">
                            <h1>10909</h1>
                        </div>
                        <h1 class="font-bold uppercase text-sm text-green-500">Solucionados</h1>
                    </div>
                    <div class="overflow-y-auto scrollbar px-1" style="max-height: 80vh">
                        <div id="dataSolucionados"> </div>
                    </div>
                </div>
            </div>

            <div id="contenedorSeccion" class="hidden w-full h-full flex sm:flex-col md:flex-row md:justify-start sm:justify-start overflow-x-auto scrollbar" style="max-height: 80vh"></div>

            <div id="contenedorSubsecciones" class="hidden w-full h-full flex sm:flex-col md:flex-row md:justify-start sm:justify-start" style="max-height: 80vh"></div>

        </div>
    </div>

    <!-- AM4CORE -->
    <script src="js/am4core_core.js"></script>
    <script src="js/am4core_charts.js"></script>
    <script src="js/am4core_animated.js"></script>
    <!-- AM4CORE -->

    <!-- JS -->
    <script src="js/reporte_incidencias.js" type="text/javascript"></script>
    <!-- JS -->


</body>

</html>