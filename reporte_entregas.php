<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG Reporte Incidencias</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion_2021.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/animate.css">
</head>

<body style="background-color: #EEF0FC;" class="scrollbar relative">
    <!-- MENÚ -->
    <!-- <menu-sidebar clases="z-20 mb-6"></menu-sidebar> -->
    <!-- <menu-menu></menu-menu> -->

    <!-- CONFIGURACIONES SIDEBAR -->
    <!-- <configuracion-telegram></configuracion-telegram>
    <menu-notificaciones clases="h-screen"></menu-notificaciones>
    <menu-favoritos clases="h-screen"></menu-favoritos>
    <menu-telegram clases="h-screen"></menu-telegram>
    <menu-agenda clases="h-screen"></menu-agenda> -->
    <!-- MENÚ -->


    <!-- CONTENEDOR -->
    <div class="w-full h-screen flex sm:flex-col md:flex-row md:items-start md:justify-start px-8 sm:justify-start sm:items-center">
        <div class="flex-none bg-white md:w-80 sm:w-full h-auto rounded-xl shadow-lg flex flex-col justify-start items-center p-8 z-40 mb-4">
            <div class="flex">
                <input id="filtroPalabra" type="text" placeholder="Buscar incidencias" class="focus:outline-none focus:ring p-2 w-3/4 rounded-l-md mb-2 ring-bluegray-300" style="background-color: #F4F5F7;">
                <button id="btnFiltroPalabra" class="focus:outline-none focus:ring bg-gray-600 text-gray-50 p-2 rounded-r-md mb-2 cursor-pointer ring-lime-300">Buscar</button>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Responsable Seguimiento
                </label>
                <div class="relative">
                    <select id="filtroResponsable" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 scrollbar text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="0">TODOS</option>
                    </select>
                </div>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Responsable Ejecución
                </label>
                <div class="relative">
                    <select id="filtroResponsableEjecucion" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 scrollbar text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
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
                    Activos Principales
                </label>
                <div class="relative">
                    <select id="filtroEquipos" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
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
                        <option value="INCIDENCIAS">Incidencias</option>
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
                        <option value="EP">ENTREGAS PROYECTO</option>
                    </select>
                </div>
            </div>

            <div class="w-full mb-3">
                <label class="block uppercase tracking-wide text-gray-500 text-xs font-bold mb-2" for="grid-state">
                    Status Incidencias
                </label>
                <div class="relative">
                    <select id="filtroStatusIncidencia" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-lime-200 text-xs uppercase text-gray-500" style="background-color: #F4F5F7;">
                        <option value="TODOS">TODOS</option>
                        <option value="PENDIENTE">PENDIENTE</option>
                        <option value="SOLUCIONADO">SOLUCIONADO</option>
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
                    </select>
                </div>
            </div>

            <div>
                <div id="chartdiv2" class="hidden" style="height: 280px; width: 100%;"></div>
            </div>

            <div class="flex justify-center items-center text-xs w-full">
                <button id="btnExportarExcel" class="focus:outline-none focus:ring p-2 w-1/2 rounded-md  ring-lime-200 bg-lime-200 text-lime-900">
                    Exportar excel
                </button>
            </div>
        </div>

        <div class="flex-none">
            <div class="overflow-x-auto scrollbar mx-auto" style="width: 100%">
                <div class="w-full flex justify-start items-center p-4">
                    <h1 class="font-bold text-xs text-gray-400 uppercase mr-4">Columnas</h1>

                    <button id="btnColumnaPendientesSolucionados" class="bg-gray-100 text-gray-300 text-xs hover:bg-white hover:text-gray-700 hover:shadow uppercase font-bold rounded py-2 px-3 mr-4">Pendientes/Solucionados</button>

                    <button id="btnColumnaSecciones" class="bg-gray-100 text-gray-300 text-xs hover:bg-white hover:text-gray-700 hover:shadow uppercase font-bold rounded py-2 px-3 mr-4">Secciones</button>

                    <button id="btnColumnaSubsecciones" class="bg-gray-100 text-gray-300 text-xs hover:bg-white hover:text-gray-700 hover:shadow uppercase font-bold rounded py-2 px-3 mr-4">Subsecciones</button>

                    <button id="btnColumnaActivosPrincipales" class="bg-gray-100 text-gray-300 text-xs hover:bg-white hover:text-gray-700 hover:shadow uppercase font-bold rounded py-2 px-3 mr-4">Activos Principales</button>

                    <button id="btnColumnaActivosSecundarios" class="bg-gray-100 text-gray-300 text-xs hover:bg-white hover:text-gray-700 hover:shadow uppercase font-bold rounded py-2 px-3 mr-4">Activos Secundarios</button>

                    <div id="loader" class=""></div>
                </div>

                <!-- CONTENEDOR PRINCIPAL -->
                <div id="contenedor" class="w-full h-full flex sm:flex-col md:flex-row md:justify-start sm:justify-start overflow-auto scrollbar" style="max-height: 80vh"></div>
                <!-- CONTENEDOR PRINCIPAL -->

            </div>
        </div>
    </div>
    <!-- CONTENEDOR -->


    <!-- MODAL LOGIN -->
    <div id="modalSession" class="w-full h-screen modal open flex flex-row justify-center items-center" style="z-index:100;">
        <!-- CONTENIDO -->
        <div class="w-full h-screen bg-red-50 flex justify-center items-center">
            <div class="w-80 h-132 rounded-3xl shadow-lg flex flex-col justify-center p-4 z-40 bg-white overflow-hidden opacity-100">
                <div class="w-full flex justify-center items-center">
                    <img class="w-32" src="svg/lineal_animated.svg" srcset="svg/lineal_animated.svg" alt="">
                </div>
                <div class="justify-evenl">
                    <input id="inputusuario" type="text" placeholder="Usuario" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-bluegray-300" style="background-color: #F4F5F7;">
                    <div class="flex flex-row items-center">
                        <input id="inputcontraseña" type="password" placeholder="Contraseña" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-bluegray-300" style="background-color: #F4F5F7;">
                        <i id="icono" class="fas fa-eye-slash"></i>
                    </div>
                    <button id="btnIniciarSession" class="focus:outline-none focus:ring bg-gray-600 text-gray-50 p-2 w-full rounded-md mb-2 cursor-pointer ring-lime-300">Entrar</button>
                    <div class="text-xs w-full text-center text-gray-400 hover:text-blue-300">
                        <a href="#">Olvidé mi contraseña</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL LOGIN -->

    <div id="cerrarSession" class="w-24 text-center absolute top-0 right-0 cursor-pointer p-2 text-red-400">
        <p class="text-xs">Cerrar sesión</p> <i class="fas fa-sign-out fa-lg"></i>
    </div>


    <!-- AM4CORE -->
    <script src="js/am4core_core.js" type="text/javascript"></script>
    <script src="js/am4core_charts.js" type="text/javascript"></script>
    <script src="js/am4core_animated.js" type="text/javascript"></script>
    <!-- AM4CORE -->

    <!-- SCRIPTS ALERTIFY -->
    <script src="js/alertify.min.js" type="text/javascript"></script>
    <script src="js/alertasSweet.js" type="text/javascript"></script>
    <!-- SCRIPTS ALERTIFY -->

    <!-- JS -->
    <script src="js/reporte_entregas.js" type="text/javascript"></script>
    <!-- JS -->

    <!-- SCRIPT SEGURIDAD -->
    <!-- <script src="js/seguridad_session.js" type="text/javascript"></script> -->
    <!-- SCRIPT SEGURIDAD -->

    <!-- MENU JS -->
    <!-- <script src="js/menu.js" type="text/javascript"></script> -->
    <!-- MENU JS -->

</body>

</html>