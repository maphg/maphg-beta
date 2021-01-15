<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
    <title>MAPHG Planner</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/fontawesome/css/regular.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/jPages.css">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/planner_cols.css">

    <style>
        .contenedor {
            width: 100%;
        }

        @media (min-width: 640px) {
            .contenedor {
                max-width: 640px;
            }
        }

        @media (min-width: 850px) {
            .contenedor {
                max-width: 850px;
            }
        }

        @media (min-width: 1024px) {
            .contenedor {
                max-width: 1024px;
            }
        }

        @media (min-width: 1200px) {
            .contenedor {
                max-width: 1220px;
            }
        }

        @media (min-width: 1366px) {
            .contenedor {
                max-width: 1366px;
            }
        }

        @media (min-width: 1920px) {
            .contenedor {
                max-width: 1920px;
            }
        }

        @media (min-width: 2176px) {
            .contenedor {
                max-width: 2176px;
            }
        }

        /* Arrow TOOLTIP */

        #arrowtooltipActividadesGeneral,
        #arrowtooltipActividadesGeneral::before {
            position: absolute;
            width: 8px;
            height: 8px;
            z-index: -1;
        }

        #arrowtooltipActividadesGeneral::before {
            content: '';
            transform: rotate(45deg);
            background: #333;
        }

        #tooltipActividadesGeneral[data-popper-placement^='top']>#arrowtooltipActividadesGeneral {
            bottom: -4px;
        }

        #tooltipActividadesGeneral[data-popper-placement^='bottom']>#arrowtooltipActividadesGeneral {
            top: -4px;
        }

        #tooltipActividadesGeneral[data-popper-placement^='left']>#arrowtooltipActividadesGeneral {
            right: -4px;
        }

        #tooltipActividadesGeneral[data-popper-placement^='right']>#arrowtooltipActividadesGeneral {
            left: -4px;
        }

        /* Arrow TOOLTIP */
        #arrowtooltipActividadesProyecto,
        #arrowtooltipActividadesProyecto::before {
            position: absolute;
            width: 8px;
            height: 8px;
            z-index: -1;
        }

        #arrowtooltipActividadesProyecto::before {
            content: '';
            transform: rotate(45deg);
            background: #333;
        }

        #tooltipActividadesPlanaccion[data-popper-placement^='top']>#arrowtooltipActividadesProyecto {
            bottom: -4px;
        }

        #tooltipActividadesPlanaccion[data-popper-placement^='bottom']>#arrowtooltipActividadesProyecto {
            top: -4px;
        }

        #tooltipActividadesPlanaccion[data-popper-placement^='left']>#arrowtooltipActividadesProyecto {
            right: -4px;
        }

        #tooltipActividadesPlanaccion[data-popper-placement^='right']>#arrowtooltipActividadesProyecto {
            left: -4px;
        }
    </style>
</head>

<body class="bg-gray-200" style="font-family: 'Roboto', sans-serif;">
    <!-- MENÚ -->
    <div class="w-full absolute top-0">
        <?php
        include 'navbartopJS.php';
        include 'menuJS.php';
        ?>
    </div>
    <!-- MENÚ -->

    <!-- BOTON FLOTANTE -->
    <div class="absolute bottom-0 right-0 flex flex-row items-end" style="z-index: 100;">

        <div id="btnFlotanteOpciones" class="flex flex-col-reverse items-end font-medium mb-4 animated hidden">
            <button id="btnModalAgregarIncidencias" class="py-1 hover:bg-red-500 font-semibold text-red-500 hover:text-white px-2 mb-2 rounded border-red-500 border-2">Incidencia</button>
            <button class="py-1 hover:bg-red-500 font-semibold text-red-500 hover:text-white px-2 mb-2 rounded border-red-500 border-2">Proyecto</button>
            <button class="py-1 hover:bg-red-500 font-semibold text-red-500 hover:text-white px-2 mb-2 rounded border-red-500 border-2">Checklist</button>
            <button class="py-1 hover:bg-red-500 font-semibold text-red-500 hover:text-white px-2 mb-2 rounded border-red-500 border-2">MP</button>
            <button class="py-1 hover:bg-red-500 font-semibold text-red-500 hover:text-white px-2 mb-2 rounded border-red-500 border-2">Predictivo</button>
        </div>

        <div class="">
            <button id="btnFlotante" class="text-red-500 text-5xl m-4 hover:text-red-400">
                <i class="fad fa-plus-circle"></i>
            </button>
        </div>

    </div>
    <!-- BOTON FLOTANTE -->


    <div class="flex flex-col justify-evenly items-center w-full h-screen pt-12">
        <div class="flex flex-row justify-start items-start w-full overflow-x-auto px-4 flex pt-10 scrollbar pb-24">


            <div class="flex flex-col flex-wrap justify-center items-center w-22rem leading-none text-bluegray-100 mr-4">

                <div class="flex flex-row justify-center items-center w-full">
                    <p id="dia" class="font-semibold dia"></p>
                </div>
                <div class="flex flex-row justify-center items-center w-full">
                    <p id="mes" class="font-semibold dia"></p>
                </div>
                <div class="flex flex-row justify-center items-center w-full">
                    <p id="hora" class="font-semibold text-md"></p>
                </div>
                <div class="flex flex-row justify-center items-center w-full">
                    <p class="font-semibold text-md">
                        <i class="fas fa-map-marker-alt mt-1"></i>
                        <span id="nombreDestino"></span>
                    </p>
                </div>

                <div class="flex flex-col justify-end mt-6 items-end w-full pr-10">
                    <!-- <img src="svg/calendario/lunes.svg" class="w-5/12" alt=""> -->
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-lunes" class="text-sm font-bold mr-4">LUNES</h1>
                        <h1 onclick="botones('zia');" id="btn-zia" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZIA
                        </h1>
                        <h1 onclick="botones('zhp');" id="btn-zhp" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZHP
                        </h1>
                    </div>
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-martes" class="text-sm font-bold mr-4">MARTES</h1>
                        <h1 onclick="botones('zic');" id="btn-zic" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZIC
                        </h1>
                        <h1 class="w-8 h-8 mr-2"></h1>
                    </div>
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-miercoles" class=" text-sm font-bold mr-4">MIERCOLES</h1>
                        <h1 onclick="botones('dec');" id="btn-dec" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            DEC
                        </h1>
                        <h1 onclick="botones('zie');" id="btn-zie" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZIE
                        </h1>
                    </div>
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-jueves" class=" text-sm font-bold mr-4">JUEVES</h1>
                        <h1 onclick="botones('zhc');" id="btn-zhc" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZHC
                        </h1>
                        <h1 onclick="botones('zha');" id="btn-zha" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZHA
                        </h1>
                    </div>
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-viernes" class=" text-sm font-bold mr-4">VIERNES</h1>
                        <h1 onclick="botones('zil');" id="btn-zil" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZIL
                        </h1>
                        <h1 onclick="botones('auto');" id="btn-auto" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            AUT
                        </h1>
                    </div>
                    <div class="flex flex-row items-center justify-center mb-2">
                        <h1 onclick="botones('dep');" id="btn-dep" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            DEP
                        </h1>
                        <h1 onclick="botones('zhh');" id="btn-zhh" class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZHH
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Inicio Columna -->
            <div id="columnasPendientes" class="flex items-center relative">
                <div class="flex flex-row justify-start items-start w-full overflow-x-auto px-6 flex scrollbar">
                    <div class="flex items-center">
                        <div id="userpendings" class="scrollbar flex flex-col justify-center items-center w-84 py-3">
                            <div class="bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full">
                                <div class="bg-cyan-100 shadow-md rounded-full flex items-center justify-center px-3 absolute py-2 text-cyan-700 text-2xl w-12 h-12" style="top: -20px;">
                                    <i class="fad fa-clipboard-list-check"></i>
                                    <h1 class="text-xs">
                                        <span id="loadPendientes" class="text-cyan-900"></span>
                                    </h1>
                                </div>
                                <div class="w-full flex flex-col justify-between overflow-y-auto mt-4 scrollbar" style="max-height:55vh;">
                                    <div class="flex text-xs font-semibold my-3 justify-center items-center w-full sticky top-0">

                                        <div id="misPendientesIncidencias" class="hover:bg-red-200 hover:text-red-500 px-2 bg-gray-300 text-gray-600 rounded-l-md w-1/2 text-center cursor-pointer">
                                            <h1 id="totalPendientesFallas">Incidencias (0)</h1>
                                        </div>

                                        <div id="misPendientesTareas" class="hover:bg-orange-200 hover:text-orange-500 px-2 bg-gray-300 text-gray-600 w-1/3 text-center cursor-pointer hidden">
                                            <h1 id="totalPendientesTareas">Tareas (0)</h1>
                                        </div>

                                        <div id="misPendientesPDA" class="hover:bg-purple-200 hover:text-purple-500 px-2 bg-gray-300 text-gray-600 rounded-r-md w-1/2 text-center cursor-pointer">
                                            <h1 id="totalPendientesPDA">PDA Proyectos (0)</h1>
                                        </div>

                                    </div>

                                    <div id="dataPendientesUsuario" class="flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="columnasSeccionesEnergeticos" class="flex items-center py-3"></div>
            <div id="columnasSeccionesZIL" class="flex items-center py-3"></div>
            <div id="columnasSeccionesZIE" class="flex items-center py-3"></div>
            <div id="columnasSeccionesAUTO" class="flex items-center py-3"></div>
            <div id="columnasSeccionesDEC" class="flex items-center py-3"></div>
            <div id="columnasSeccionesDEP" class="flex items-center py-3"></div>
            <div id="columnasSeccionesOMA" class="flex items-center py-3"></div>
            <div id="columnasSeccionesZHA" class="flex items-center py-3"></div>
            <div id="columnasSeccionesZHC" class="flex items-center py-3"></div>
            <div id="columnasSeccionesZHH" class="flex items-center py-3"></div>
            <div id="columnasSeccionesZHP" class="flex items-center py-3"></div>
            <div id="columnasSeccionesZIA" class="flex items-center py-3"></div>
            <div id="columnasSeccionesZIC" class="flex items-center py-3"></div>
        </div>
    </div>


    <!-- Inicio de Modales Modales -->

    <!-- ********** MODALES PRINCIPALES ********** -->

    <!-- MODAL EQUIPOS Y LOCALES -->
    <div id="modalEquiposAmerica" class="modal">
        <div id="modalEquiposAmericaBG" class="w-full h-screen bg-gray-300">
            <div class="flex justify-center items-center mb-5 relative pt-4">
                <div class="font-light text-3xl ml-3 leading-none text-bluegray-700 mr-12">
                    <h1 class="text-center mb-2">Equipos & Locales</h1>
                    <h1 id="seccionSubseccionDestinoEquiposAmerica" class="text-xs font-normal text-center"></h1>
                </div>
                <div class="relative text-gray-600 w-72">
                    <input id="palabraEquipoAmerica" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar equipo o local" autocomplete="off">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <i class="fad fa-search"></i>
                    </button>
                </div>
                <div id="reporteEquipos" class="text-blue-500 text-sm cursor-pointer bg-blue-300 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-blue-200 px-2">
                    <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                    <h1>Exportar</h1>
                </div>
            </div>

            <div id="btnCerrarModalEquiposAmerica" class="absolute right-0 top-0 text-red-500 text-lg cursor-pointer bg-red-300 rounded-full w-auto px-2 h-6 flex justify-center items-center m-2 hover:bg-red-200" onclick="cerrarmodal('modalEquiposAmerica');">
                <i class="fas fa-times"></i>
                <h1 class="ml-1 uppercase font-semibold text-xs">Cerrar</h1>
            </div>

            <div class="w-full h-auto">
                <div class="flex flex-col container mx-auto scrollbar">
                    <div class="flex items-center justify-start ">

                        <div id="tareasGeneralesEquipo" class="flex-none flex items-center bg-white rounded mb-2 cursor-pointer hover:bg-gray-200 shadow-sm mr-6" data-title="Clic, para mostrar Tareas Generales">
                            <div class="text-sm px-3 leading-noene font-semibold text-bluegray-800 uppercase flex py-1">
                                <h1><i class="fad fa-circle mr-2 text-red-400"></i>Incidencias generales de área</h1>
                            </div>
                            <div id="totalesTareasGenerales" class="text-sm px-3 leading-noene font-bold text-center text-bluegray-700 uppercase flex flex-col justify-center leading-none py-1 bg-bluegray-800 rounded-r relative">
                                <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
                                </div>
                                <h1 class="text-red-400">-</h1>
                                <h1 class=" text-green-400 text-xs font-semibold">-</h1>
                            </div>
                        </div>

                        <div id="btnColumnasInicdencias" class="flex items-center bg-red-300 rounded mb-2 cursor-pointer hover:bg-red-200 shadow-sm mr-6" data-title="Clic, para mostrar Columnas Incidencias">
                            <div class="text-sm px-3 leading-noene font-semibold text-red-600 uppercase flex py-1">
                                <h1>INCIDENCIAS</h1>
                            </div>
                            <div id="totalesFallas" class="text-sm px-3 leading-noene font-bold text-center text-bluegray-700 uppercase flex flex-col justify-center leading-none py-1 bg-bluegray-800 rounded-r relative">
                                <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
                                </div>
                                <h1 class="text-red-400">-</h1>
                                <h1 class=" text-green-400 text-xs font-semibold">-</h1>
                            </div>
                        </div>

                        <div id="btnColumnasPreventivos" class="flex items-center bg-blue-300 rounded mb-2 cursor-pointer hover:bg-blue-200 shadow-sm mr-6" data-title="Clic, para mostrar Columnas Preventivos">
                            <div class="text-sm px-3 leading-noene font-semibold text-blue-600 uppercase flex py-1">
                                <h1>PREVENTIVOS</h1>
                            </div>
                            <div id="totalesPreventivos" class="text-sm px-3 leading-noene font-bold text-center text-bluegray-700 uppercase flex flex-col justify-center leading-none py-1 bg-bluegray-800 rounded-r relative">
                                <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
                                </div>
                                <h1 class="text-red-400">-</h1>
                                <h1 class=" text-green-400 text-xs font-semibold">-</h1>
                            </div>
                        </div>

                        <div id="btnColumnasPredictivos" class="flex items-center bg-indigo-300 rounded mb-2 cursor-pointer hover:bg-indigo-200 shadow-sm mr-6" data-title="Clic, para mostrar Columnas Predictivos">
                            <div class="text-sm px-3 leading-noene font-semibold text-indigo-600 uppercase flex py-1">
                                <h1>PREDICTIVOS</h1> 
                            </div>
                            <div id="totalesTest" class="text-sm px-3 leading-noene font-bold text-center text-bluegray-700 uppercase flex flex-col justify-center leading-none py-1 bg-bluegray-800 rounded-r relative">
                                <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
                                </div>
                                <h1 class=" text-white text-xs font-semibold py-1">-</h1>
                            </div>
                        </div>

                        <div class="flex items-center bg-black rounded mb-2 cursor-pointer hover:bg-gray-800 shadow-sm mr-6" data-title="Clic, para mostrar Materiales">
                            <div class="text-sm px-3 leading-noene font-semibold text-white uppercase flex py-1">
                                <h1>Materiales</h1>
                            </div>
                            <div class="text-sm px-3 leading-noene font-bold text-center text-bluegray-700 uppercase flex flex-col justify-center leading-none py-1 bg-bluegray-800 rounded-r relative">
                                <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
                                </div>
                                <h1 class=" text-white text-xs font-semibold py-1">-</h1>
                            </div>
                        </div>

                        <div class="flex items-center bg-blue-300 rounded mb-2 cursor-pointer hover:bg-blue-200 shadow-sm mr-6">
                            <div class="text-sm px-3 leading-noene font-semibold text-blue-600 uppercase flex py-1">
                                <h1>INFO</h1>
                            </div>
                            <div class="text-sm px-3 leading-noene font-bold text-center text-bluegray-700 uppercase flex flex-col justify-center leading-none py-1 bg-bluegray-800 rounded-r relative">
                                <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
                                </div>
                                <h1 class=" text-white text-xs font-semibold py-1">-</h1>
                            </div>
                        </div>

                        <div class="flex items-center bg-orange-300 rounded mb-2 cursor-pointer hover:bg-orange-200 shadow-sm hidden">
                            <div class="text-sm px-3 leading-noene font-semibold text-orange-600 uppercase flex py-1">
                                <h1>TAREAS</h1>
                            </div>
                            <div id="totalesTareas" class="text-sm px-3 leading-noene font-bold text-center text-bluegray-700 uppercase flex flex-col justify-center leading-none py-1 bg-bluegray-800 rounded-r relative">
                                <div class="absolute bg-bluegray-800 fa-value-absolute w-3 h-3" style="transform: rotate(45deg); left: -12%;">
                                </div>
                                <h1 class="text-red-400">-</h1>
                                <h1 class=" text-green-400 text-xs font-semibold">-</h1>
                            </div>
                        </div>
                    </div>

                    <div class="-my-2 py-2 overflow-x-auto  scrollbar">
                        <div class="align-middle inline-block min-w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 scrollbar relative bg-white" style="min-height: 60vh; max-height: 75vh;">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed sortable">
                                <thead>
                                    <tr class="cursor-pointer">

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_0">
                                            Equipo/Local
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_1">
                                            Incidencias
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_2">
                                            Emergencia
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_3">
                                            Urgencia
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_4">
                                            Alarma
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_5">
                                            Alerta
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_6">
                                            Seguimiento
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_7 hidden">
                                            PREVENTIVOS
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_8 hidden">
                                            Último MP
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_9 hidden">
                                            Proximo MP
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_10 hidden">
                                            Tareas
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_11 hidden">
                                            Predictivo
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_12 hidden">
                                            Último Predictivo
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_13 hidden">
                                            Cot
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_14">
                                            Pics
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_15">
                                            Coments
                                        </th>

                                        <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_16">
                                            Despiece
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="contenedorEquiposAmerica" class="bg-white divide-y divide-gray-200">
                                    <!-- More rows... -->
                                </tbody>
                            </table>

                            <!-- DESPIECE DE EQUIPOS AMERICA -->
                            <div id="tooltipDespieceEquipo" role="tooltip" class="w-full border-solid border-4 border-gray-600 scrollbar overflow-y-auto rounded hidden" style="max-height: 40vh;">

                                <div class="flex items-center justify-center relative bg-white p-2">

                                </div>

                                <table class="min-w-full divide-y divide-gray-200 table-fixed sortable pt-1">
                                    <thead>
                                        <tr class="cursor-pointer bg-white">

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_0">
                                                Equipo / Local
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_1">
                                                Incidencias
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_2">
                                                Emergencia
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_3">
                                                Urgencia
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_4">
                                                Alarma
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_5">
                                                Alerta
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_">
                                                Seguimiento
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_7 hidden">
                                                PREVENTIVOS
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_8 hidden">
                                                Último MP
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_9 hidden">
                                                Proximo MP
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_10 hidden">
                                                Tareas
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_11 hidden">
                                                Predictivo
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_12 hidden">
                                                Último Predictivo
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_13 hidden">
                                                Cot
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_14">
                                                Pics
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_15">
                                                Coments
                                            </th>

                                            <th class="py-3 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 columna_ columna_16">
                                                Despiece
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody id="contenedorEquiposAmericaDespice" class="bg-white divide-y divide-gray-200"></tbody>
                                </table>
                            </div>
                            <!-- DESPIECE DE EQUIPOS AMERICA -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL PARA EQUIPOS -->
    <div id="modalEquipos" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1200px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalEquipos');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div id="estiloSeccionEquipos" class="flex justify-center items-center rounded-b-md w-16 h-10 shadow-xs">
                    <h1 id="seccionEquipos" class="font-medium text-base"><i class="fas fa-spinner fa-pulse fa-2x fa-fw"></i></h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded">
                    <h1>SUBSECCION / EQUIPOS Y LOCALES</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 mt-6 flex justify-center items-center flex-col">
                <div class="flex flex-row items-center w-full">
                    <div class="ml-10 relative text-gray-600 w-2/6 self-start">
                        <input id="inputPalabraEquipo" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Equipo/Local" onkeyup="if(event.keyCode == 13) llamarFuncionX('obtenerEquipos')" autocomplete="off">
                        <button type="submit" class="absolute right-0 top-0 mt-1 mr-4" onclick="llamarFuncionX('obtenerEquipos');">
                            <i class="fad fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Contenedor de los equipos y locales(Tabla) -->
                <div class="mt-2 w-full flex flex-col justify-center items-center">
                    <!-- titulos -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-white sticky top-0">

                        <div class="w-2/6 h-full flex items-center justify-center cursor-pointer">
                            <h1 id="tipoOrdenamientoNombreEquipo">EQUIPOS / LOCALES</h1>
                        </div>

                        <div class="w-16 h-full flex items-center justify-center cursor-pointer">
                            <h1 id="tipoOrdenamientoMCN">Incidencias P</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center cursor-pointer">
                            <h1 id="tipoOrdenamientoMCF">Incidencias S</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>TAREAS P</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>TAREAS S</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>MP-P</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>MP-S</h1>
                        </div>

                        <div class="w-24 flex h-full items-center justify-center">
                            <h1>U MP</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>TEST</h1>
                        </div>

                        <div class="w-24 flex h-full items-center justify-center">
                            <h1>U TEST</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>COT</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>INFO</h1>
                        </div>

                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>MEDIA</h1>
                        </div>

                    </div>

                    <!-- Equipos Obtenidos -->
                    <div id="dataTG" class="w-full"></div>
                    <div id="dataEquipos" class="w-full"></div>
                </div>
            </div>
            <div class="px-4 py-3 flex items-center justify-center border-t border-gray-200 sm:px-6">
                <!-- paginación. -->
                <div>
                    <!-- Se agrega la paginación de los equipos -->
                    <!-- <nav id="paginacionEquipos" class="relative inline-flex shadow-sm col">
                        <div class="holder"></div>
                    </nav> -->
                    <nav class="relative inline-flex shadow-sm col">
                        <div class="holder"></div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL EQUIPOS Y LOCALES -->


    <!-- MODAL EQUIPO PARA LOS MP-->
    <div id="modalMPEquipo" class="modal relative">
        <div class="modal-window flex shadow-lg flex-col justify-center items-center text-bluegray-800 pt-10 rounded-lg " style="width: 1000px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMPEquipo')" class="cursor-pointer text-md  text-red-500 bg-red-200 px-2 rounded-bl-lg rounded-tr-lg font-normal shadow-md">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-lg rounded-tl-lg">
                    <h1>INFORMACIÓN DEL EQUIPO</h1>
                </div>
            </div>

            <!-- ENCABEZADO -->
            <div class="flex flex-row w-full justify-start px-4 relative">
                <div class="font-bold text-xl flex flex-col justify-center items-center uppercase truncate w-full text-center">
                    <input id="nombreEquipo" type="text" class="font-bold text-xl flex flex-col justify-center items-center uppercase truncate w-full text-center bg-white" value="" autocomplete="off">
                    <div class="flex mt-1">
                        <div id="contenedorEstadoEquipo" class="flex items-center px-1  rounded-full w-auto cursor-pointer mr-4">
                            <i id="iconEstadoEquipo" class="fad fa-circle my-1 mr-1 fa-lg"></i>

                            <select id="estadoEquipo" class="text-xs font-bold">
                                <option value="OPERATIVO">OPERATIVO</option>
                                <option value="BAJA">BAJA</option>
                                <option value="TALLER">TALLER</option>
                                <option value="FUERADESERVICIO">FUERA DE SERVICIO</option>
                            </select>

                        </div>
                        <div class="flex items-center text-xs font-bold text-purple-400 px-1 bg-purple-100 rounded-full w-auto cursor-pointer mr-4">
                            <i class="fas fa-cog mr-1 fa-lg text-purple-300"></i>
                            <h2 class="mr-2">
                                <select id="tipoLocalEquipo" class="text-xs font-bold">
                                    <option value="EQUIPO">EQUIPO</option>
                                    <option value="LOCAL">LOCAL</option>
                                </select>
                            </h2>
                            <h2 id="jerarquiaEquipo2"></h2>
                        </div>
                        <div class="flex items-center text-xs text-blue-300 px-1 bg-blue-100 rounded-full w-auto cursor-pointer mr-4">
                            <i class="mr-1 text-blue-400">BITÁCORAS:</i>
                            <select id="idFaseEquipo" class="text-xs font-bold">
                                <option value="1">GP</option>
                                <option value="2">TRS</option>
                                <option value="3">ZI</option>
                            </select>
                        </div>
                        <div class="flex items-center text-xs text-red-400 px-1 bg-red-100 rounded-full w-auto cursor-pointer">
                            <i class="mr-1 text-red-300">R</i>
                            <h2>REEMPLAZADO</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOTOS -->
            <div class="w-full h-32 mt-2 px-4 overflow-x-auto scrollbar flex items-center">
                <div id="btnAdjuntosEquipo" class="flex items-center justify-center w-10 h-10 bg-bluegray-900 hover:bg-indigo-300 hover:text-indigo-500 border-2 border-gray-200 text-bluegray-300 rounded-full absolute left-0 cursor-pointer" data-anijs="if: mouseover, do: tada animated">
                    <i class="fas fa-plus ga-lg"></i>
                </div>
                <div class="bg-cover bg-center w-24 h-24 rounded-lg cursor-pointer flex-none mr-2 hover:shadow-lg">
                    <img id="QREquipo">
                </div>
                <div id="dataImagenesEquipo" class="w-full h-32 overflow-x-auto scrollbar flex items-center"></div>
            </div>

            <!-- CARACTRISTICAS -->
            <div class="text-xs uppercase font-bold w-full px-2 my-2 flex">
                <h1>INFORMACIÓN</h1>

                <button id="btnEditarEquipo" class="text-xxs px-2 bg-yellow-300 ml-3 rounded font-semibold hover:shadow">Editar</button>

                <button id="btnGuardarEquipo" class="text-xxs px-2 bg-green-300 ml-3 rounded font-semibold hover:shadow">Guardar</button>

                <button id="btnCancelarEquipo" class="text-xxs px-2 bg-red-300 ml-3 rounded font-semibold hover:shadow">Cancelar</button>
            </div>

            <div class="flex flex-row w-full bg-fondos-4">
                <div class="w-9/12 flex-none h-auto px-4 overflow-x-auto scrollbar flex flex-no-wrap justify-start items-start text-xxs pt-2 ">
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">SECCIÓN</h1>
                            <select id="seccionEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">SUBSECCIÓN</h1>
                            <select id="subseccionEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">TIPO</h1>
                            <select id="tipoEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">JERARQUIA</h1>
                            <select id="jerarquiaEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                                <option value="PRINCIPAL">PRINCIPAL</option>
                                <option value="SECUNDARIO">SECUNDARIO</option>
                            </select>
                        </div>

                        <div id="contenedorDataOpcionesEquipos" class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">EQUIPO PRIMARIO</h1>
                            <select id="dataOpcionesEquipos" class="bg-fondos-4 font-semibold truncate w-24"></select>
                        </div>

                    </div>

                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">MARCA</h1>
                            <select id="marcaEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                            </select>

                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">Modelo</h1>
                            <input type="text" delo" value="-" id="modeloEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">Número de Serie</h1>
                            <input type="text" value="-" id="serieEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">Código Fabricante</h1>
                            <input type="text" value="-" id="codigoFabricanteEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">Código Interno Compras</h1>
                            <input type="text" value="-" id="codigoInternoComprasEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                    </div>
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">LARGO</h1>
                            <input type="text" value="-" id="largoEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">ANCHO</h1>
                            <input type="text" value="-" id="anchoEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">ALTO</h1>
                            <input type="text" value="-" id="altoEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>
                    </div>

                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ELEC. (HP)</h1>
                            <input type="text" value="-" id="potenciaElectricaHPEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ELEC. (KW)</h1>
                            <input type="text" value="-" id="potenciaElectricaKWEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">VOLTAJE (V)</h1>
                            <input type="text" value="-" id="voltajeEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">FRECUENCIA (HZ)</h1>
                            <input type="text" value="-" id="frecuenciaEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                    </div>
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AGUA (M3/H)</h1>
                            <input type="text" value="-" id="caudalAguaM3HEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AGUA (GPH)</h1>
                            <input type="text" value="-" id="caudalAguaGPHEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CARGA (M.C.A)</h1>
                            <input type="text" value="-" id="cargaMCAEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                    </div>
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA FRIO(KW)</h1>
                            <input type="text" value="-" id="PotenciaEnergeticaFrioKWEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA FRIO(TR)</h1>
                            <input type="text" value="-" id="potenciaEnergeticaFrioTREquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA CALOR (KCAL)</h1>
                            <input type="text" value="-" id="potenciaEnergeticaCalorKCALEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AIRE(M3/H)</h1>
                            <input type="text" value="-" id="caudalAireM3HEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AIRE(CFM)</h1>
                            <input type="text" value="-" id="caudalAireCFMEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                    </div>
                </div>
                <div class="flex-none flex flex-col items-start justify-start border-l w-3/12 text-xs uppercase font-bold px-2">

                    <h1 class="my-2">DESPIECE</h1>

                    <div id="dataDespieceEquipo" class="w-full flex flex-col overflow-y-auto scrollbar" style="max-height: 200px;"></div>
                </div>

            </div>
            <!-- CARACTRISTICAS -->

            <!-- PLANES MP -->
            <div class="text-xs uppercase font-bold w-full px-2 my-2">
                <h1>Planes Preventivos</h1>
            </div>

            <div id="contenedorPlanesEquipo" class="flex flex-wrap w-full justify-start p-4  overflow-x-auto scrollbar" style="max-height:300.5px; min-height:150px;">
            </div>
            <!-- PLANES MP -->

            <!-- MENÚ OPCIONES MP -->
            <div id="tooltipMP" role="tooltip" class="flex flex-col items-center justify-center mx-auto contextmenu-menu hidden" style="z-index:100">
                <div class=" text-sm leading-none w-full  mx-auto contextmenu-menu" style="background: #414646; z-index:90;">

                    <h1 class="mr-1 text-right absolute right-0" style="color: #ffff;" onclick="cerrarTooltip('tooltipMP')">
                        <i class="fas fa-times fa-lg"></i>
                    </h1>

                    <h1 class="my-2" style="color: #a9aaaa; background-color: #454A4A;">Programación <span id="semanaProgramacionMP"></span></h1>

                    <h1 id="programarMPIndividual" class="contextmenu-item"><i class="fas fa-long-arrow-down mr-2 text-blue-400"></i>Programar (Individual)</h1>

                    <h1 id="programarMPDesdeAqui" class="contextmenu-item"><i class="fas fa-random mr-2 text-blue-400"></i>Reprogramar desde aquí</h1>

                    <h1 id="opcionMPPersonalizado" class="contextmenu-item" onclick="expandir(this.id)">
                        <i class="fas fa-random mr-2 text-blue-400"></i>Program. Personalizada
                    </h1>

                    <div id="opcionMPPersonalizadotoggle" class="flex flex-row items-center justify-center mb-3 hidden">
                        <input id="numeroSemanasPersonalizadasMP" class="w-1/4 text-center shadow appearance-none border border-red-500 rounded w-full py-1 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="1" max="52" pattern="[0-9]" autocomplete="off">
                        <button id="programarMPPersonalizado" class="w-3/4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 ml-1 rounded">Programar</button>
                    </div>

                    <h1 id="eliminarMPIndividual" class="contextmenu-item"><i class="fas fa-trash-alt mr-2 text-red-500"></i>Eliminar (individual)</h1>

                    <h1 id="eliminarMPDesdeAqui" class="contextmenu-item"><i class="fas fa-trash-alt mr-2 text-red-500"></i>Eliminar desde aquí</h1>

                    <h1 class="my-2" style="color: #a9aaaa;">Ordenes de Trabajo</h1>

                    <h1 id="VerOTMP" class="contextmenu-item"><i class="fas fa-eye mr-2 text-teal-500"></i>Ver OT</h1>

                    <h1 id="generarOTMP" class="contextmenu-item"><i class="fas fa-file mr-2 text-amber-400"></i>Generar OT</h1>

                    <h1 id="solucionarOTMP" class="contextmenu-item"><i class="fas fa-check mr-2 text-green-500"></i>Solucionar
                        OT</h1>

                    <h1 id="cancelarOTMP" class="contextmenu-item"><i class="fas fa-ban mr-2 text-red-500"></i>Cancelar OT</h1>

                </div>
                <i class="fas fa-sort-down w-full text-center fa-4x " style="color: #414646; margin-top: -29px; margin-bottom: -12.5px; z-index:85;"></i>
            </div>
            <!-- MENÚ OPCIONES MP -->

        </div>
    </div>
    <!-- MODAL EQUIPO PARA LOS MP-->


    <!-- MODAL PARA PENDIENTES POR SECCIONES -->
    <div id="modalPendientes" class="modal">
        <div class="modal-window py-10 rounded-md" style="width: 1300px;">
            <div class=" flex flex-col items-center justify-center">
                <div class="absolute top-0 right-0">
                    <button onclick="cerrarmodal('modalPendientes')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="absolute top-0 left-0 flex flex-row">
                    <div>
                        <button id="btnExpandirMenu" onclick="expandir(this.id)" class="py-1 px-2 rounded-br-md bg-indigo-200 text-indigo-500 hover:shadow-sm rounded-tl-md font-normal relative">
                            <i class="fas fa-arrow-to-bottom mr-1"></i>Exportar Pendientes
                        </button>

                        <div id="btnExpandirMenutoggle" class="hidden absolute top-0 mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs z-30">

                            <a id="exportarMisPendientes" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Mis Pendientes (EXCEL)
                            </a>

                            <a id="exportarSeccion" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Sección Completa (EXCEL)
                            </a>

                            <!-- Pendiente por terminar  -->
                            <a id="exportarExportarSubseccionEXCEL" href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="toggleSubseccionesTipo('dataExportarSubseccionesEXCEL', 'dataExportarSubseccionesPDF')">Subsecciones
                                (EXCEL)</a>

                            <a id="responsableUsuario" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Responsable (EXCEL)
                            </a>

                            <a id="exportarMisCreados" href="#" class="py-1 px-2 w-full hover:bg-gray-700"> Creados Por
                                Mi (EXCEL)</a>

                            <a id="exportarCreadosPorEXCEL" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Creados Por (EXCEL)
                            </a>

                            <a id="exportarMisPendientesPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Mis Pendientes (PDF)</a>

                            <a id="exportarMisCreadosPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700"> Creados
                                Por Mi (PDF)</a>

                            <a id="exportarSubseccionesPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="toggleSubseccionesTipo('dataExportarSubseccionesPDF', 'dataExportarSubseccionesEXCEL')">Subsecciones
                                (PDF)</a>

                            <a id="exportarCreadosPorPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Colaborador (PDF)</a>

                        </div>
                    </div>
                    <div class="ml-3" (Excel)>
                        <button id="btnvisualizarpendientesde" onclick="expandir(this.id)" class="py-1 px-2 rounded-b-md bg-teal-200 text-teal-500 hover:shadow-sm font-normal relative">
                            <i class="fas fa-eye mr-1"></i><span id="tipoPendienteNombre"></span>
                        </button>
                        <div id="btnvisualizarpendientesdetoggle" class="hidden absolute top-0  mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs">

                            <a id="misPendientesUsuario" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Mis
                                Pendientes</a>

                            <a id="misPendientesCreados" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Creados Por
                                Mi</a>

                            <a id="misPendientesSinUsuario" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Sin
                                Responsable</a>

                            <a id="misPendientesSeccion" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Todos</a>

                        </div>
                    </div>
                    <div class="ml-3">
                        <button id="dataOpcionesSubsecciones" onclick="expandir(this.id)" class="py-1 px-2 rounded-b-md bg-orange-200 text-orange-500 hover:shadow-sm font-normal relative">
                            <i class="fas fa-eye mr-1"></i>Subsecciones
                        </button>
                        <div id="dataOpcionesSubseccionestoggle" class="hidden absolute top-0  mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs z-30">
                        </div>
                    </div>
                </div>

                <div class="text-blue-700 bg-blue-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12">
                    <h1 id="estiloSeccion" class="font-medium text-md">
                        <i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
                    </h1>
                </div>
                <div class="flex flex-row text-sm bg-white mt-4">
                    <div class="py-1 px-2 rounded-l-md bg-red-200 text-red-500 font-normal cursor-pointer">
                        <h1>Incidencias Y Tareas</h1>
                    </div>

                    <a class="py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer" href="graficas_reportes_diario/">
                        <div>
                            <h1>Reporte Incidencias Y Tareas</h1>
                        </div>
                    </a>

                    <div class="py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                        <h1>Preventivo</h1>
                    </div>
                    <div class="py-1 px-2 rounded-r-md bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                        <h1>Proyectos</h1>
                    </div>
                </div>
            </div>

            <div class="px-2 mt-12">
                <table id="tablaPendientes" class="table-auto text-xs text-center w-full">
                    <thead>
                        <tr class="cursor pointer">
                            <th class="px-4 py-2">Subsección</th>
                            <th class="px-4 py-2">Pendientes</th>
                            <th class="px-4 py-2">Pendiente DEP</th>
                            <th class="px-4 py-2">Trabajando</th>
                            <th class="px-4 py-2">Solucionado</th>
                        </tr>
                    </thead>
                    <tbody id="dataSubseccionesPendientes" class="divide-y">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- MODAL PARA PENDIENTES POR SECCIONES -->


    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->
    <div id="modalPendientesX-" class="modal">
        <div class="modal-window rounded-md pt-10 w-auto md:w-10/12 lg:w-9/12">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalPendientesX')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div id="estiloSeccionMCN" class="flex justify-center items-center rounded-b-md w-16 h-10 shadow-xs">
                    <h1 id="seccionMCN" class="font-medium text-base"></h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded">
                    <h1><span id="nombreEquipoMCN"></span> / <span id="tipoPendientesX"></span></h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Opciones para MC -->
                <div class="flex items-center justify-center text-sm font-semibold">
                    <div id="btnAgregarPendiente" class="py-1 cursor-pointer px-3 rounded-l hover:bg-red-200 bg-red-100 text-red-500">
                        <h1>
                            <i class="fas fa-plus mr-2"></i><span id="agregarPendiente">Agregar</span>
                        </h1>
                    </div>
                    <div id="verGANTT" class="py-1 cursor-pointer px-3 hover:bg-indigo-200 bg-indigo-100 text-indigo-500">
                        <h1>
                            <i class="fas fa-tasks-alt mr-2"></i>VER GANTT
                        </h1>
                    </div>
                    <div id="exportarPendientes" class="py-1 cursor-pointer px-3 rounded-r hover:bg-teal-200 bg-teal-100 text-teal-500">
                        <h1>
                            <i class="fas fa-arrow-to-bottom mr-2"></i>EXPORTAR
                        </h1>
                    </div>
                </div>

                <!-- Contenedor de los equipos y locales(Tabla) -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- titulos -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-full h-full flex items-center justify-center">
                            <h1 id="tipoPendiente">--</h1>
                        </div>
                        <div class="w-48 h-full flex items-center justify-center">
                            <h1>RESPONSABLE</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>FECHA</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>MEDIA</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>COMENT</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>STATUS</h1>
                        </div>
                    </div>

                    <!--Data MCN equipo -->
                    <div id="dataPendientes" class="w-full"></div>

                </div>
            </div>
        </div>
    </div>
    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->


    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->
    <div id="modalTareasFallas" class="modal">
        <div id="contenedorPrincipalTareasFallas" class="modal-window rounded-md pt-10 w-auto md:w-10/12 lg:w-11/12 overflow-x-auto scrollbar">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalTareasFallas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div id="estiloSeccionFallaTarea" class="flex justify-center items-center rounded-b-md w-16 h-10 shadow-xs">
                    <h1 id="seccionFallaTarea" class="font-medium text-base"></h1>
                </div>
                <div id="estiloEquipoFallaTarea" class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded">
                    <h1 id="equipoFallaTarea">. . .</h1>
                </div>
            </div>

            <div id="contenidoOpcionesFallaTarea" class="flex justify-center items-center mb-5 relative pt-4">

                <div class="relative text-gray-600 w-72">
                    <input id="palabraFallaTarea" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." autocomplete="off">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <i class="fad fa-search"></i>
                    </button>
                </div>

                <div id="agregarFallaTarea" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2">
                    <i class="fas fa-plus mr-1 text-xs"></i>
                    <h1>Nuevo</h1>
                </div>

                <div id="opcionFallaPendiente" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2">
                    <i class="fas fa-list mr-1 font-normal text-xs"></i>
                    <h1 id="tipoFallaTarea"></h1>
                </div>

                <div id="ganttFallaTarea" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2">
                    <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                    <h1>Gantt</h1>
                </div>

                <div id="pendienteFallaTarea" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2">
                    <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                    <h1>Pendientes</h1>
                </div>

                <div id="solucionadosFallaTarea" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2">
                    <i class="fas fa-check mr-1 font-normal text-xs"></i>
                    <h1>Solucionados</h1>
                </div>

                <div id="exportarFallaTarea" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2" id="exportarProyectos">
                    <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                    <h1>Exportar</h1>
                </div>
            </div>

            <!-- CONTENIDO TAREAS FALLAS -->
            <div id="pendientesFallasTareas" class="p-2 flex justify-center items-center flex-col w-full">

                <div class="overflow-x-auto scrollbar">
                    <div class="align-middle inline-block min-w-full shadow-md border rounded border-b border-gray-200" style="max-height: 45vh;">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed border rounded sortable">
                            <thead>
                                <tr class="cursor-pointer bg-white">

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Incidencia
                                    </th>
                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Acciones
                                    </th>
                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Responsable
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Fechas
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Comentarios
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Adjuntos
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Status
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        OT
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    </th>

                                </tr>
                            </thead>

                            <tbody id="dataPendientesX" class="bg-white divide-y divide-gray-200">
                                <!-- More rows... -->
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <!-- CONTENIDO TAREAS FALLAS -->

            <!-- CONTENIDO GANTT TAREAS FALLAS -->
            <div id="ganttFallasTareas" class="p-2 flex justify-center items-center flex-col w-full hidden">
                <div class="align-middle inline-block min-w-full shadow-md border rounded border-b border-gray-200 mx-auto overflow-y-auto scrollbar bg-white" style="max-height: 45vh;">
                    <div class="min-w-full divide-y divide-gray-200 table-fixed border rounded">
                        <div class="text-xxs uppercase mt-5 w-full h-full mx-auto" id="dataGanttFallasPendientes"></div>
                    </div>
                </div>
            </div>
            <!-- CONTENIDO GANTT TAREAS FALLAS -->


        </div>

        <!-- ACTIVIDADES PARA TAREAS Y FALLAS -->
        <div id="tooltipActividadesGeneral" class="w-84 h-auto bg-bluegray-900 rounded-md p-1 flex hidden absolute" role="tooltip" style="z-index:200">
            <div id="arrowtooltipActividadesGeneral" data-popper-arrow></div>
            <div class="bg-white rounded p-2 flex flex-col text-xxs font-semibold w-full">
                <div class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-fondos-2">
                    <div class="w-4 h-4  mr-2 flex-none"></div>
                    <div class=" text-justify w-full h-full">
                        <input id="agregarActividadGeneral" type="text" class="w-full h-full text-xs focus:outline-none appearance-none py-1 bg-transparent" placeholder="Añadir Actividad" autocomplete="off">
                    </div>
                    <div id="btnAgregarActividadGeneral" class="flex items-center justify-center text-blue-300 cursor-pointer w-6 h-6 rounded-full flex-none text-sm">
                        <i class="fas fa-plus"></i>
                    </div>
                </div>
                <div id="dataActividadesGeneral" class="w-auto overflow-y-auto scrollbar" style="max-height: 20vh;"></div>
            </div>
        </div>
        <!-- ACTIVIDADES PARA TAREAS Y FALLAS -->

    </div>
    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->


    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->
    <div id="modalTestEquipo" class="modal">
        <div id="contenedorPrincipalTareasFallas" class="modal-window rounded-md pt-10 w-auto md:w-10/12 lg:w-11/12 overflow-x-auto scrollbar" style="background:#DBEAFE; min-height: 60vh;">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalTestEquipo')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div id="estiloSeccionTest" class="">
                    <h1 id="seccionTest" class="font-bold text-black"></h1>
                </div>
                <div id="" class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded">
                    <h1 id="equipoTest"> </h1>
                </div>
            </div>

            <div class="flex justify-center items-center mb-5 relative pt-4">

                <div class="relative text-gray-600 w-72">
                    <input id="palabraTest" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." autocomplete="off">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <i class="fad fa-search"></i>
                    </button>
                </div>

                <div id="agregarTest" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2 bg-indigo-600 hover:bg-indigo-200">
                    <i class="fas fa-plus mr-1 text-xs"></i>
                    <h1>Nuevo</h1>
                </div>

                <div id="opcionTest" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2 bg-indigo-600 hover:bg-indigo-200">
                    <i class="fas fa-list mr-1 font-normal text-xs"></i>
                    <h1>Test</h1>
                </div>

                <div id="ganttTest" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2 bg-indigo-600 hover:bg-indigo-200">
                    <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                    <h1>Gantt</h1>
                </div>

                <div id="exportarTest" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2 bg-indigo-600 hover:bg-indigo-200" id="exportarProyectos">
                    <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                    <h1>Exportar</h1>
                </div>
            </div>

            <!-- CONTENIDO TAREAS FALLAS -->
            <div id="" class="p-2 flex justify-center items-center flex-col w-full">

                <div class="overflow-x-auto scrollbar">
                    <div class="align-middle inline-block min-w-full shadow-md border rounded border-b border-gray-200" style="max-height: 45vh;">
                        <table id="tablaTestEquipo" class="min-w-full divide-y divide-gray-200 table-fixed border rounded sortable">
                            <thead>
                                <tr class="cursor-pointer bg-white">

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Descripción
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Unidad de Medida
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Responsable
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Fechas
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Comentarios
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Adjuntos
                                    </th>

                                </tr>
                            </thead>

                            <tbody id="dataTestEquipo" class="bg-white divide-y divide-gray-200">
                                <!-- More rows... -->
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <!-- CONTENIDO TAREAS FALLAS -->

        </div>

    </div>
    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->


    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->
    <div id="modalEnergeticos" class="modal">
        <div id="contenedorPrincipalTareasFallas" class="modal-window rounded-md pt-10 w-auto md:w-10/12 lg:w-11/12 overflow-x-auto scrollbar" style="background: rgb(252, 211, 77);min-height: 60vh;">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalEnergeticos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div id="" class="">
                    <h1 id="" class="font-bold text-black"></h1>
                </div>
                <div id="" class="ml-4 font-bold bg-yellow-400 text-yellow-700 text-xs py-1 px-2 rounded">
                    <h1 id="tituloEnergeticos"><i class="fas fa-plug fa-lg"></i> Energéticos</h1>
                </div>
            </div>

            <div class="flex justify-center items-center mb-5 relative pt-4">

                <div class="relative text-gray-600 w-72">
                    <input id="palabraEnergeticos" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." autocomplete="off">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <i class="fad fa-search"></i>
                    </button>
                </div>

                <div id="btnModalAgregarEnergeticos" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2 bg-indigo-600 hover:bg-indigo-200">
                    <i class="fas fa-plus mr-1 text-xs"></i>
                    <h1>Nuevo</h1>
                </div>

                <div id="" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2 bg-indigo-600 hover:bg-indigo-200">
                    <i class="fas fa-list mr-1 font-normal text-xs"></i>
                    <h1>Energeticos</h1>
                </div>

                <div id="" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2 bg-indigo-600 hover:bg-indigo-200 hidden">
                    <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                    <h1>Gantt</h1>
                </div>

                <div id="" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2 bg-indigo-600 hover:bg-indigo-200 hidden" id="exportarProyectos">
                    <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                    <h1>Exportar</h1>
                </div>
            </div>

            <!-- CONTENIDO TAREAS FALLAS -->
            <div id="" class="p-2 flex justify-center items-center flex-col w-full">

                <div class="overflow-x-auto scrollbar">
                    <div class="align-middle inline-block min-w-full shadow-md border rounded border-b border-gray-200" style="max-height: 45vh;">
                        <table id="" class="min-w-full divide-y divide-gray-200 table-fixed border rounded sortable">
                            <thead>
                                <tr class="cursor-pointer bg-white">

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Descripción
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Responsable
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Fechas
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Adjuntos
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Comentarios
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">

                                    </th>

                                </tr>
                            </thead>

                            <tbody id="dataEnergeticos" class="bg-white divide-y divide-gray-200">
                                <!-- More rows... -->
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <!-- CONTENIDO TAREAS FALLAS -->

        </div>

    </div>
    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->


    <!-- MODAL para FALLAS Y TAREAS SOLUCIONADOS -->
    <div id="modalSolucionadosX" class="modal">
        <div class="modal-window rounded-md pt-10 w-auto md:w-10/12 lg:w-9/12 h-full">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalSolucionadosX')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- BOTON CERRARL -->

            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div id="estiloSeccionMCF" class="flex justify-center items-center rounded-b-md w-16 h-10 shadow-xs">
                    <h1 id="seccionMCF" class="font-medium text-base"></h1>
                </div>
                <div class="ml-4 font-bold bg-green-200 text-green-500 text-xs py-1 px-2 rounded">
                    <h1><span id="nombreEquipoMCF"></span> / <span id="tipoSolucionadosX"></span></h1>
                </div>
            </div>
            <!-- SECCION Y UBICACION -->

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">

                <!-- Opciones para MC -->
                <div class="invisible flex items-center justify-center text-sm font-semibold">
                    <div class="py-1 cursor-pointer px-3 rounded-l hover:bg-red-200 bg-red-100 text-red-500">
                        <h1>
                            <i class="fas fa-plus mr-2"></i>AGREGAR MC
                        </h1>
                    </div>
                    <div class="py-1 cursor-pointer px-3 hover:bg-indigo-200 bg-indigo-100 text-indigo-500">
                        <h1>
                            <i class="fas fa-tasks-alt mr-2"></i>VER GANTT
                        </h1>
                    </div>
                    <div class="py-1 cursor-pointer px-3 rounded-r hover:bg-teal-200 bg-teal-100 text-teal-500">
                        <h1>
                            <i class="fas fa-arrow-to-bottom mr-2"></i>EXPORTAR
                        </h1>
                    </div>
                </div>
                <!-- Contenedor de los equipos y locales(Tabla) -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- titulos -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-full h-full flex items-center justify-center">
                            <h1 id="tipoSolucionado">--</h1>
                        </div>
                        <div class="w-48 h-full flex items-center justify-center">
                            <h1>RESPONSABLE</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>FECHA</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>MEDIA</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>COMENT</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>REGRESAR</h1>
                        </div>
                    </div>

                    <!-- equipo -->
                    <div id="dataMCF" class="w-full"></div>
                    <!-- equipo -->
                </div>
            </div>

        </div>
    </div>
    <!-- MODAL para FALLAS Y TAREAS SOLUCIONADOS -->


    <!-- MODAL VER EN PLANNER PARA LOS PENDIENTES  -->
    <div id="modalVerEnPlanner" class="modal">
        <div class="modal-window rounded-md" style="width: 900px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0 z-30">
                <button onclick="cerrarmodal('modalVerEnPlanner')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 flex flex-row items-center justify-start w-full">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md">
                    <h1>Detalles</h1>
                </div>
            </div>
            <div class="absolute top-0 flex flex-row items-center justify-center w-full">
                <div class="font-bold bg-teal-200 text-teal-500 text-xs py-1 px-2 rounded-b-md">
                    <h1 id="tipoPendienteVP"></h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center w-full py-6">
                <div class="mb-3 flex flex-col w-full leading-none">
                    <h1 id="descripcionPendienteVP" class="px-2 py-1 w-full text-xl font-medium uppercase" style="color: #282B3B;"></h1>
                    <h1 class="px-2 py-1 w-full text-xs font-medium" style="color: #ABADB7;">Creado por:
                        <span id="creadoPorVP" class="uppercase ml-1"></span>
                    </h1>
                </div>

                <div class="w-full flex">
                    <div class="w-1/2 text-sm px-2 flex flex-col">
                        <h1 class="mb-1"></h1>
                        <div class="flex flex-wrap w-full justify-start items-center">

                            <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                                <span id="fechaVP" class="bg-purple-200"></span>
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2 text-sm px-2 flex flex-col">
                        <h1 class="mb-1">Responsables</h1>
                        <div class="flex flex-wrap w-full justify-start items-center">

                            <div id="responsableVP" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                                <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                            </div>

                            <div id="dataResponsablesVP"></div>

                        </div>
                    </div>
                </div>

                <div class="w-full text-sm px-2 flex flex-col mt-3">
                    <h1 class="mb-1">Status</h1>
                    <div class="flex flex-wrap w-full justify-start items-center">
                        <div id="dataStatusVP" class="flex flex-wrap w-full justify-start items-center"></div>
                    </div>
                </div>

                <div class="w-full flex text-sm mt-5">
                    <div class="w-1/2 mt-3">
                        <h1 class="mb-6">Comentarios</h1>
                        <div class="px-4 overflow-y-auto scrollbar flex flex-col w-full" style="min-height: 499px; max-height: 500px;">

                            <div id="dataComentariosVP" class="flex justify-center items-center flex-col-reverse w-full"></div>

                            <div class="flex flex-row justify-center items-center w-full h-10 mt-4">
                                <input id="comentarioVP" type="text" placeholder="   Añadir comentario" class="h-full w-full rounded-l-md text-gray-600 font-medium border-2 border-r-0 focus:outline-none" autocomplete="off">
                                <button id="btnComentarioVP" class="py-2 h-full w-12 rounded-r-md bg-teal-200 text-teal-500 font-bold text-sm hover:shadow-md">
                                    <i class="fad fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2  mt-3">
                        <div class="flex items-center justify-start">
                            <h1 class="mr-2">Adjuntos</h1>
                            <div id="adjuntosVP" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                                <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                            </div>
                        </div>
                        <div class="w-full px-1 font-medium text-sm text-gray-400 overflow-y-auto scrollbar">
                            <div id="dataAdjuntosVP" class="flex flex-row flex-wrap justify-evenly items-start overflow-y-auto scrollbar mb-4" style="max-height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL VER EN PLANNER PARA LOS PENDIENTES  -->


    <!-- MODAL VER EN PLANNER PARA LOS PLANES DE ACCION -->
    <div id="modalVerEnPlannerPlanaccion" class="modal">
        <div class="modal-window rounded-md" style="width: 900px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0 z-30">
                <button onclick="cerrarmodal('modalVerEnPlannerPlanaccion')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 flex flex-row items-center justify-start w-full">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>Detalles</h1>
                </div>
            </div>
            <div class="absolute top-0 flex flex-row items-center justify-center w-full">
                <div class="font-bold bg-teal-100 text-teal-500 text-xs py-1 px-2 rounded-b-md">
                    <h1>ACTIVIDAD DE PLAN DE ACCIÓN</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center w-full py-6">
                <div class="mb-3 flex flex-col w-full leading-none">
                    <h1 id="tiluloPlanaccion" class="px-2 pt-4 w-full text-xl font-medium uppercase text-center" style="color: #282B3B;"></h1>
                    <h1 class="px-2 py-1 w-full text-xs font-medium text-center" style="color: #ABADB7;">
                        Fecha de
                        creacion:
                        <span id="fechaCreacionPlanaccion" class="uppercase ml-1"></span>
                    </h1>
                </div>
                <div class="w-full  self-start flex flex-wrap border-b-2 border-gray-100">
                    <div class="w-1/2 border-r-2 border-gray-100">
                        <div class="w-full flex-none text-sm px-2 flex flex-col mb-3">
                            <h1 class="mb-1" style="color: #ABADB7;">Creado por:</h1>
                            <div class="flex flex-wrap w-full justify-start items-center">
                                <div class="bg-gray-200 text-gray-700 px-2 rounded flex items-center mr-2">
                                    <h1 id="creadoPorPlanaccion" class="font-medium"></h1>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex-none text-sm px-2 flex flex-col mb-3">
                            <h1 class="mb-1" style="color: #ABADB7;">Responsables asignados:</h1>
                            <div class="flex flex-wrap w-full justify-start items-center">

                                <div id="btnResponsablePlanaccion" class="bg-gray-500 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                                    <h1 class="font-medium text-sm">
                                        <i class="fas fa-plus"></i>
                                    </h1>
                                </div>
                                <div>
                                    <div id="dataResponsablesAsignadosPlanaccion" class="flex flex-wrap w-full justify-start items-center">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="w-full flex-none text-sm px-2 flex flex-col mb-3">
                            <h1 class="mb-1" style="color: #ABADB7;">Status:</h1>
                            <div class="flex flex-wrap w-full justify-start items-center">
                                <div id="btnStatusPlanaccion" class="bg-gray-500 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                                    <h1 class="font-medium text-sm">
                                        <i class="fas fa-plus"></i>
                                    </h1>
                                </div>

                                <div id="dataStatusPlanaccion" class="flex flex-wrap w-full justify-start items-center"> </div>

                            </div>
                        </div>
                        <div class="w-full flex-none text-sm px-2 flex flex-col mb-3">
                            <h1 class="mb-1" style="color: #ABADB7;">Fecha Solucion estimada:</h1>
                            <div class="flex flex-wrap w-full justify-start items-center">
                                <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2 ">
                                    <span id="rangoFechaPlanaccion" class="bg-purple-200" onclick="abrirmodal('modalRangoFechaX')">Sin Fecha asignada</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex-none text-sm px-2 flex flex-col mb-3">
                            <h1 class="mb-1" style="color: #ABADB7;">Proviene del proyecto:</h1>
                            <div class="flex flex-wrap w-full justify-start items-center">
                                <div class="bg-gray-200 text-gray-700 px-2 rounded flex items-center mr-2 uppercase cursor-pointer">
                                    <h1 id="proyectoPlanaccion" class="font-medium"></h1>
                                </div>
                                <div class="bg-gray-200 text-gray-700 px-2 rounded flex items-center mr-2 uppercase cursor-pointer">
                                    <h1 id="tipoProyectoPlanaccion" class="font-medium"></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div class="w-full flex-none text-sm px-2 flex flex-col mb-3">
                            <h1 class="mb-1" style="color: #ABADB7;">Subtareas:
                                <div class="flex flex-wrap w-full justify-start items-center">
                                    <div class="w-full h-auto rounded-md flex" role="tooltip" data-popper-placement="bottom" data-popper-reference-hidden="">
                                        <div class="bg-white rounded p-2 flex flex-col text-xxs font-semibold w-full">
                                            <div class="flex items-center justify-between uppercase border-2 py-2 hover:bg-fondos-2 border-gray-100 rounded mb-2">
                                                <div class="w-4 h-4  mr-2 flex-none"></div>
                                                <div class=" text-justify w-full h-full ">
                                                    <input id="inputActividadPlanaccion" type="text" class="w-full h-full text-xs focus:outline-none appearance-none py-1 bg-transparent" placeholder="Añadir Actividad" autocomplete="off">
                                                </div>
                                                <div id="btnAgregarActividadPlanaccionX" class="flex items-center justify-center text-blue-300 cursor-pointer w-6 h-6 rounded-full flex-none text-sm">
                                                    <i class="fas fa-plus"></i>
                                                </div>
                                                <div id="btnAbrirOTPlanaccion" class="ml-2 flex items-center justify-center text-white cursor-pointer h-6 rounded px-2 flex-none text-sm bg-blue-500">
                                                    <h1>Ver OT</h1>
                                                </div>
                                            </div>

                                            <div id="dataActividadesPlanaccion" class="w-auto overflow-y-auto scrollbar" style="max-height: 200px;">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="w-full flex text-sm ">
                    <div class="w-1/2 relative border-r-2 border-gray-100 px-2 mt-2">
                        <h1 class="mb-2" style="color: #ABADB7;">Comentarios:</h1>

                        <div id="dataComentariosPlanaccion" class="px-4 overflow-y-auto scrollbar flex flex-col w-full pb-10" style="min-height: 499px; min-height: 499px; max-height: 500px;">



                        </div>
                        <div class="flex flex-row justify-center items-center w-full h-10 absolute bottom-0">
                            <input id="inputComentarioPlanaccion" type="text" placeholder="   Añadir comentario" class="h-full w-full rounded-l-md text-gray-600 font-medium border-2 border-r-0 focus:outline-none" autocomplete="off">
                            <button id="btnAgregarComentarioPlanaccion" class="py-2 h-full w-12 rounded-r-md bg-teal-200 text-teal-500 font-bold text-sm hover:shadow-md">
                                <i class="fad fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>

                    <div class="w-1/2 px-2 mt-2">
                        <div class="flex items-center justify-start relative z-20">
                            <h1 class="mr-2" style="color: #ABADB7;">Adjuntos</h1>
                            <div class="bg-gray-500 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                                <h1 class="font-medium text-sm">
                                    <i class="fas fa-plus"></i>
                                </h1>
                                <input type="file" id="inputFilePlanaccion" multiple class="absolute top-0 opacity-0">
                            </div>

                        </div>

                        <div class="w-full px-1 font-medium text-sm text-gray-400 overflow-y-auto scrollbar">
                            <div id="dataAdjutnosPlanaccion" class="flex flex-row flex-wrap justify-evenly items-start overflow-y-auto scrollbar mb-4" style="max-height: 450px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOOLTIP -->
            <div id="tooltipOpcionesActividadPlanaccion" role="tooltip" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden">
                <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">

                    <div class="w-full flex flex-row">

                        <button id="btnNuevoTituloPlanaccion" class="block w-1/2 text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem" onclick="expandir('btnNuevoTituloPlanaccion'); expandir('btnAplicarNuevoTituloPlanaccion')">
                            Editar <i class="fa fa-pencil mx-2"></i>
                        </button>

                        <button id="btnAplicarNuevoTituloPlanacciontoggle" class="block w-1/2 text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 hidden" role="menuitem" onclick="expandir(this.id)">
                            Aplicar <i class="fa fa-check-circle mx-2"></i>
                        </button>
                    </div>

                    <div id="btnNuevoTituloPlanacciontoggle" class="px-1 mb-4 hidden">
                        <input id="nuevoTituloPlanaccion" type="text" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Nuevo Titulo" autocomplete="off">
                    </div>

                    <button id="btnEliminarActividadPlanaccion" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900" role="menuitem">
                        Eliminar <i class="fa fa-trash mx-2"></i>
                    </button>

                </div>
            </div>
            <!-- TOOLTIP -->
        </div>
    </div>
    <!-- MODAL VER EN PLANNER PARA LOS PLANES DE ACCION -->


    <!-- MODAL PROYECTOS -->
    <div id="modalProyectos" class="modal">
        <div class="w-full h-screen bg-purple-400 relative">
            <div id="contenidoOpcionesProyectos" class="flex justify-center items-center mb-5 relative pt-4">
                <div class="font-light text-3xl ml-3 leading-none text-purple-600 absolute left-0 text-center">
                    <h1>Proyectos</h1><span id="loadProyectos"></span>
                </div>

                <div class="relative text-gray-600 w-72">
                    <input id="palabraProyecto" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Proyecto" autocomplete="off">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <i class="fad fa-search"></i>
                    </button>
                </div>

                <div id="agregarProyecto" class="text-purple-400 text-sm cursor-pointer bg-purple-600 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                    <i class="fas fa-plus mr-1 text-xs"></i>
                    <h1>Nuevo</h1>
                </div>

                <div id="opcionProyectos" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2">
                    <i class="fas fa-list mr-1 font-normal text-xs"></i>
                    <h1>Proyectos</h1>
                </div>
                <div id="opcionGanttProyectos" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                    <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                    <h1>Gantt</h1>
                </div>

                <div id="proyectosPendientes" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2">
                    <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                    <h1>Pendientes</h1>
                </div>
                <div id="proyectosSolucionados" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                    <i class="fas fa-check mr-1 font-normal text-xs"></i>
                    <h1>Solucionados</h1>
                </div>

                <div class="text-purple-400 text-sm cursor-pointer bg-purple-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2" id="exportarProyectos">
                    <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                    <h1>Exportar</h1>
                </div>
            </div>

            <div id="btnCerrerModalProyectos" class="absolute right-0 top-0 text-red-500 text-lg cursor-pointer bg-red-300 rounded-full w-auto px-2 h-6 flex justify-center items-center m-2 hover:bg-purple-200" onclick="toggleModalTailwind('modalProyectos')">
                <i class="fas fa-times"></i>
                <h1 class="ml-1 uppercase font-semibold text-xs">Cerrar</h1>
            </div>

            <!-- CONTENIDO PROYECTOS -->
            <div id="contenidoProyectos" class="flex flex-col mx-auto contenedor">
                <div class="align-middle inline-block shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 scrollbar w-auto mx-auto relative bg-white" style="min-height: 79vh; max-height: 80vh;">
                    <table class="divide-y divide-gray-200  sortable">
                        <thead>
                            <tr class="cursor-pointer bg-white">

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Proyecto
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    PDA
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Responsable
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Fechas
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Cotizaciones
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Tipo
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Justificación
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Coste
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Status
                                </th>

                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                </th>

                            </tr>
                        </thead>
                        <tbody id="contenedorDeProyectos" class="bg-white divide-y divide-gray-200">
                            <!-- More rows... -->
                        </tbody>
                    </table>

                    <!-- PLANACCION PROYECTOS -->
                    <div id="tooltipProyectos" role="tooltip" class="bg-bluegray-900 p-1 rounded-lg contenedor hidden" style="z-index:100">
                        <div class="flex flex-col">
                            <div class="flex justify-center items-center mb-5 relative pt-4">

                                <div class="relative text-gray-600">
                                    <input id="agregarPlanaccion" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="input" placeholder="Agregar Plan Acción" autocomplete="off">
                                </div>

                                <div id="btnagregarPlanaccion" class="text-purple-400 text-sm cursor-pointer bg-purple-600 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                                    <i class="fas fa-plus mr-1 text-xs"></i>
                                    <h1>Nuevo</h1>
                                </div>

                                <div id="planaccionPendientes" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2 bg-purple-200">
                                    <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                                    <h1>Pendientes</h1>
                                </div>

                                <div id="planaccionSolucionados" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2 bg-purple-600">
                                    <i class="fas fa-check mr-1 font-normal text-xs"></i>
                                    <h1>Solucionados</h1>
                                </div>

                            </div>
                            <div class="-my-2 py-2 overflow-x-auto scrollbar">
                                <div class="align-middle inline-block min-w-full shadow-md overflow-auto rounded border-b border-gray-200 scrollbar" style="max-height: 35vh;">
                                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                        <thead>
                                            <tr class="cursor-pointer bg-white">

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Planacción
                                                </th>
                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Actividades
                                                </th>
                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Responsable
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Fechas
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Comentarios
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Adjuntos
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    OT
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody id="contenedorDePlanesdeaccion" class="bg-white divide-y divide-gray-200">
                                            <!-- More rows... -->
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PLANACCION PROYECTOS -->
                </div>

            </div>
            <!-- CONTENIDO PROYECTOS -->

            <!-- CONTENIDO GANTT -->
            <div id="contenidoGantt" class="flex flex-col mx-auto contenedor overflow-x-auto scrollbar hidden">
                <div class="mt-2 mx-auto flex flex-row justify-center items-start font-semibold text-xs text-bluegray-500 cursor-pointer overflow-y-auto scrollbar bg-white sm:rounded-lg border-b border-gray-200 w-full h-full" style="max-height: 80vh;">
                    <div class="text-xxs uppercase mt-5 w-full h-full mx-auto" id="chartdiv"></div>
                </div>
            </div>
            <!-- CONTENIDO GANTT -->
        </div>
    </div>
    <!-- MODAL PROYECTOS -->


    <!-- MODAL PROYECTOS DEP -->
    <div id="modalProyectosDEP" class="modal">
        <div class="w-full h-screen bg-fondos-7 relative">
            <div class="flex justify-center items-center mb-5 relative pt-4">
                <div class="font-light text-xl ml-3 leading-none text-bluegray-600 absolute left-0 text-center">
                    <h1 id="ProyectosSubseccionDEP"></h1><span class="text-center" id="loadProyectosDEP"></span>
                </div>
                <div class="relative text-gray-600 w-72">
                    <input id="palabraProyectoDEP" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Proyecto" autocomplete="off">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <i class="fad fa-search"></i>
                    </button>
                </div>

                <div id="agregarProyectoDEP" class="text-bluegray-50 text-sm cursor-pointer bg-bluegray-800 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-gray-400 hover:text-bluegray-900 px-2">
                    <i class="fas fa-plus mr-1 text-xs"></i>
                    <h1>Nuevo</h1>
                </div>

                <div id="opcionProyectosDEP" class="text-bluegray-50 text-sm cursor-pointer bg-bluegray-800 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-gray-400 hover:text-bluegray-900 px-2">
                    <i class="fas fa-list mr-1 font-normal text-xs"></i>
                    <h1>Proyectos</h1>
                </div>
                <div class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 bg-gray-400 text-bluegray-900 px-2 hidden">
                    <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                    <h1>Gantt</h1>
                </div>

                <div id="etiquetadoProyectosDEP" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 bg-red-300 text-red-500 px-2 font-semibold border-2 border-red-200">
                    <i class="fas fa-star mr-1"></i>
                    <h1>Etiquetado <span id="etiquetadoDEP"></span></h1>
                </div>

                <div id="proyectosPendientesDEP" class="text-bluegray-50 text-sm cursor-pointer bg-bluegray-800 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-gray-400 hover:text-bluegray-900 px-2">
                    <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                    <h1>Pendientes</h1>
                </div>

                <div id="proyectosSolucionadosDEP" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 bg-gray-400 text-bluegray-900 px-2">
                    <i class="fas fa-check mr-1 font-normal text-xs"></i>
                    <h1>Solucionados</h1>
                </div>

                <div id="exportarProyectosDEP" class="text-bluegray-50 text-sm cursor-pointer bg-bluegray-800 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-gray-400 hover:text-bluegray-900 px-2">
                    <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                    <h1>Exportar</h1>
                </div>
            </div>

            <div id="btnCerrerModalProyectosDEP" class="absolute right-0 top-0 text-red-500 text-lg cursor-pointer bg-red-300 rounded-full w-auto px-2 h-6 flex justify-center items-center m-2 hover:bg-bluegray-200 hover:text-white" onclick="toggleModalTailwind('modalProyectosDEP');">
                <i class="fas fa-times"></i>
                <h1 class="ml-1 uppercase font-semibold text-xs">Cerrar</h1>
            </div>

            <div id="contenedorDEP" class="w-full mx-auto p-1">
                <div class="flex flex-col contenedor mx-auto scrollbar">
                    <div class="-my-2 py-2 overflow-x-auto mx-auto scrollbar">
                        <div class="align-middle inline-block w-auto shadow-md overflow-auto sm:rounded-lg bg-white border-b border-gray-200 scrollbar mx-auto relative" style="max-height: 80vh; min-height: 70vh;">
                            <table id="tablaProyectosDEP" class="min-w-full divide-y divide-gray-200 table-fixed sortable">
                                <thead>
                                    <tr class="cursor-pointer bg-white">

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Proyecto
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            PDA
                                        </th>
                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Responsable
                                        </th>

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Fechas
                                        </th>

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Cotizaciones
                                        </th>

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Tipo
                                        </th>

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Justificación
                                        </th>

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Coste
                                        </th>

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Status
                                        </th>

                                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="contenedorDeProyectosDEP" class="bg-white divide-y divide-gray-200">
                                    <!-- More rows... -->
                                </tbody>
                            </table>
                            <!-- PLANACCION PROYECTOS DEP -->
                            <div id="tooltipProyectosDEP" role="tooltip" class="bg-bluegray-900 py-4 px-2 rounded contenedor hidden">
                                <div class="flex flex-col contenedor mx-auto scrollbar">
                                    <div class="flex justify-center items-center mb-5 relative pt-4">

                                        <div class="relative text-gray-600 w-72">
                                            <input id="agregarPlanaccionDEP" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="input" placeholder="Agregar Plan Acción" autocomplete="off">
                                        </div>

                                        <div id="btnagregarPlanaccionDEP" class="text-purple-400 text-sm cursor-pointer bg-purple-600 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                                            <i class="fas fa-plus mr-1 text-xs"></i>
                                            <h1>Nuevo</h1>
                                        </div>

                                        <div id="planaccionPendientesDEP" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2 bg-purple-200">
                                            <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                                            <h1>Pendientes</h1>
                                        </div>

                                        <div id="planaccionSolucionadosDEP" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2 bg-purple-600">
                                            <i class="fas fa-check mr-1 font-normal text-xs"></i>
                                            <h1>Solucionados</h1>
                                        </div>

                                    </div>
                                    <div class="-my-2 py-2 overflow-x-auto  scrollbar">
                                        <div class="align-middle inline-block min-w-full shadow-md overflow-auto rounded border-b border-gray-200 scrollbar" style="max-height: 25vh;">
                                            <table class="min-w-full divide-y divide-gray-200 table-fixed sortable">
                                                <thead>
                                                    <tr class="cursor-pointer bg-white">

                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Planacción
                                                        </th>
                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Actividades
                                                        </th>
                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Responsable
                                                        </th>

                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Fechas
                                                        </th>

                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Comentarios
                                                        </th>

                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Adjuntos
                                                        </th>

                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            Status
                                                        </th>

                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                            OT
                                                        </th>

                                                        <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                        </th>

                                                    </tr>
                                                </thead>

                                                <tbody id="contenedorDePlanesdeaccionDEP" class="bg-white divide-y divide-gray-200">
                                                    <!-- More rows... -->
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- PLANACCION PROYECTOS DEP -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- ETIQUETADO -->
            <div id="contendorEtiquetado" class="w-full bg-bluegray-900 py-4 hidden">
                <div class="flex flex-col container mx-auto scrollbar">
                    <div class="-my-2 py-2 overflow-x-auto  scrollbar">
                        <div class="align-middle inline-block min-w-full shadow-md overflow-auto rounded border-b border-gray-200 scrollbar" style="max-height: 80vh;">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed sortable">
                                <thead>
                                    <tr class="cursor-pointer bg-white">
                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Origen
                                        </th>
                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Sección
                                        </th>
                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            #OT
                                        </th>
                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Responsable
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Fechas
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Comentarios
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Adjuntos
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Status
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            Cod2Bend
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                            CodSap
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        </th>

                                    </tr>
                                </thead>
                                <tbody id="contenedorDeEtiquetados" class="bg-white divide-y divide-gray-200 min-w-full table-fixed">
                                    <!-- More rows... -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ETIQUETADO -->

        </div>
    </div>
    <!-- MODAL PROYECTOS DEP -->


    <!-- MODAL PARA FINALIZAR OT -->
    <div id="modalSolucionarOT" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1000px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalSolucionarOT')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex flex-col leading-none justify-center items-center bg-bluegray-900 rounded-b-md w-16 h-10">
                    <h1 class="font-bold text-sm text-white">OT</h1>
                    <h1 id="numeroOT" class="font-bold text-xs text-bluegray-100">234</h1>
                </div>
                <div id="tipoOT" class="ml-4 font-bold bg-purple-200 text-purple-500 text-xs py-1 px-2 rounded">
                    <h1>OT PREVENTIVA</h1>
                </div>
                <div id="statusOT" class="ml-4 font-bold text-xs py-1 px-2 rounded">
                    <h1>EN PROCESO</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor de los equipos y locales(Tabla) -->

                <div class="flex items-center justify-center w-full">
                    <div class="w-full flex">
                        <div class="w-1/2 text-sm px-2 flex flex-col">
                            <h1 class="mb-1">Fecha</h1>
                            <div class="flex flex-wrap w-full justify-start items-center">

                                <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                                    <h1 id="semanaOT">Semana 8</h1>
                                </div>
                            </div>
                        </div>

                        <div class="w-1/2 text-sm px-2 flex flex-col">
                            <h1 class="mb-1">Responsables</h1>
                            <div id="responsablesOT" class="flex flex-wrap w-full justify-start items-center"></div>
                        </div>

                    </div>
                </div>

                <div class="w-full text-sm px-2 flex flex-col mt-3">
                    <h1 class="mb-1">Status</h1>
                    <div id="dataStatusOT" class="flex flex-wrap w-full justify-start items-center"></div>
                </div>

                <div class="flex w-full text-sm mt-4">
                    <div class="w-1/2 flex flex-col items-start justify-start">
                        <div class="flex flex-col w-full ">
                            <h1 class="mb-2">Actividades Predefinidas</h1>

                            <div id="actividadesOT" class="flex flex-col w-full border-2 border-gray-300 text-xs rounded p-1 overflow-y-auto scrollbar" style="max-height: 251px; height: 250px;"></div>
                        </div>

                        <div class="flex flex-col w-full p-2 mt-2 text-xs">
                            <h1 class="mb-2">Actividades Extra</h1>
                            <div class="w-full">
                                <input id="inputActividadesExtra" type="text" placeholder="Añadir Actividad Extra..." class="w-full p-2 border border-gray-200 rounded mb-1" autocomplete="off">
                            </div>

                            <div id="actividadesExtraOT" class="w-full overflow-y-auto scrollbar" style="max-height: 200px; height: 199px;"></div>

                        </div>
                    </div>

                    <div class="w-1/2 flex flex-col items-start justify-start px-4">
                        <div class="flex flex-col w-full mb-2">
                            <h1 class="">Observaciones / Comentarios</h1>
                        </div>

                        <div class="w-full">
                            <textarea id="comentarioOT" cols="30" rows="5" class="w-full  border-2 border-gray-300 rounded leading-none"></textarea>
                        </div>

                        <div class="flex w-full mb-2">
                            <h1 class="mr-2">Archivos Adjuntos</h1>
                            <div id="btnAdjuntosOT" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600" onclick="toggleModalTailwind('modalMedia');">
                                <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="w-full px-1 font-medium text-sm text-gray-400 overflow-y-auto scrollbar border-2 border-gray-300 rounded">
                                <div id="imagenesOT" class="flex flex-row flex-wrap justify-evenly items-start overflow-y-auto scrollbar mb-4" style="max-height: 300px;"></div>
                                <div id="documentosOT" class="flex flex-col overflow-y-auto scrollbar px-1 mb-4 text-xs" style="max-height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-center items-center my-4">
                    <div id="btnGuardarOT" class="btn btn-blue mr-4">
                        <h1>Guardar Cambios</h1>
                    </div>
                    <div id="btnFinalizarOT" class="btn btn-green mr-4">
                        <h1>Finalizar esta OT</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA FINALIZAR OT -->


    <!-- ********** MODALES SECUNDARIOS ********** -->

    <!-- MODAL Exportar Secciones Usuarios -->
    <div id="modalExportarSeccionesUsuarios" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 370px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalExportarSeccionesUsuarios')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>Colaboradores</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div class="mb-3 w-full">
                    <input id="palabraUsuarioExportar" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." autocomplete="off">
                </div>
                <div id="dataExportarSeccionesUsuarios" class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL Exportar Subsecciones -->
    <div id="modalExportarSubsecciones" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 370px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalExportarSubsecciones');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>Subsecciones</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div id="dataExportarSubseccionesEXCEL" class="hidden divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
                </div>
                <div id="dataExportarSubseccionesPDF" class="hidden divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL RESPONSABLE -->
    <div id="modalUsuarios" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 450px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalUsuarios')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>RESPONSABLE</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div class="mb-3 w-full">
                    <input id="palabraUsuario" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." autocomplete="off">
                </div>

                <div class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="height: 400px;">
                    <div id="dataUsuarios"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL MEDIA -->
    <div id="modalMedia" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMedia')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>ARCHIVOS ADJUNTOS</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div class="mb-3">
                    <button class="relative py-2 px-3 w-full bg-teal-200 text-teal-500 font-bold text-sm rounded-md hover:shadow-md">
                        <i class="fad fa-cloud-upload fa-lg mr-2"></i>
                        ADJUNTAR ARCHIVOS

                        <!-- INPUT -->
                        <input id="inputAdjuntos" type="file" class="absolute opacity-0 item-center mx-0 my-0 justify-center w-full" style="top:1px; left:5px;" name="inputAdjuntos[]" multiple>
                        <!-- INPUT -->

                    </button>
                </div>

                <!-- Icon upload -->
                <span id="cargandoAdjunto" class="text-center"></span>
                <!-- Icon upload -->

                <div class="w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar">

                    <div id="contenedorImagenes">
                        <div class="font-bold divide-y">
                            <h1>IMÁGENES</h1>
                            <p> </p>
                        </div>
                        <!-- Data para las imagenes -->
                        <div id="dataImagenes" class="flex flex-row flex-wrap text-center"></div>
                    </div>

                    <div id="contenedorDocumentos">
                        <div class="font-bold divide-y mb-4">
                            <h1>DOCUMENTOS</h1>
                            <p> </p>
                        </div>
                        <div id="dataAdjuntos" class="flex flex-col"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- MODAL COMENTARIOS -->
    <div id="modalComentarios" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalComentarios')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>COMENTARIOS</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6 relative">

                <div id="scrollDataComentarios" class="px-4 overflow-y-auto scrollbar flex flex-col w-full" style="max-height: 50vh;">
                    <div id="dataComentarios" class="flex justify-center items-center flex-col-reverse w-full"></div>
                </div>
                <div class="flex flex-row justify-center items-center w-full h-10 px-16 mt-4">
                    <input id="inputComentario" type="text" placeholder="    Añadir comentario" class="h-full w-full rounded-l-md text-gray-600 font-medium border-2 border-r-0 focus:outline-none" autocomplete="off">
                    <button id="btnComentario" class="py-2 h-full w-12 rounded-r-md bg-teal-200 text-teal-500 font-bold text-sm hover:shadow-md">
                        <i class="fad fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL STATUS   -->
    <div id="modalStatus" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalStatus')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>STATUS</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center flex-col w-full font-bold text-sm">

                <div id="statusUrgente" class="hidden w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-red-500 bg-gray-200 hover:bg-red-200 text-xs">
                    <div class="">
                        <h1>ES URGENTE</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <i class="fas fa-siren-on animated flash infinite"></i>
                    </div>
                </div>

                <div id="statusMaterial" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs" onclick="toggleHidden('statusMaterialCod2bend');">
                    <div class="">
                        <h1>NO HAY MATERIAL</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>M</h1>
                    </div>
                </div>
                <!-- 
                <div id="statusMaterialCod2bend" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs hidden">
                    <input type="text" placeholder="Ingrese COD2BEND" class="w-full h-full text-center rounded border border-red-400 font-bold text-gray-500 autocomplet="off">
                </div> -->

                <div id="statusMaterialCod2bend" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs hidden">

                    <input id="inputCod2bend" type="text" placeholder="Ingrese COD2BEND" class="w-full h-full text-center rounded border border-red-400 font-bold text-gray-500" autocomplete="off">

                    <button id="btnStatusMaterial" class="bg-blue-500 hover:bg-blue-700 text-white font-bold mx-1 px-3 py-2 rounded focus:outline-none focus:shadow-outline" id="btnConfirmEditarTitulo" type="button">
                        <i class="fas fa-check fa-1x"></i>
                    </button>
                </div>

                <div id="statusTrabajare" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-blue-500 bg-gray-200 hover:bg-blue-200 text-xs">
                    <div class="">
                        <h1>TRABAJANDO</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>T</h1>
                    </div>
                </div>

                <div id="statusenergeticos" onclick="expandir(this.id)" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                    <div class="">
                        <h1>ENERGÉTICOS</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>E</h1>
                    </div>
                </div>
                <div id="statusenergeticostoggle" class="hidden w-full flex flex-row justify-center items-center text-sm px-2 flex-wrap">
                    <div id="statusElectricidad" class="w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>ELECTRICIDAD</h1>
                        </div>
                    </div>
                    <div id="statusAgua" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>AGUA</h1>
                        </div>
                    </div>
                    <div id="statusDiesel" class="w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>DIESEL</h1>
                        </div>
                    </div>
                    <div id="statusGas" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>GAS</h1>
                        </div>
                    </div>
                </div>

                <div id="statusdep" onclick="expandir(this.id)" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                    <div class="">
                        <h1>DEPARTAMENTO</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>D</h1>
                    </div>
                </div>
                <div id="statusdeptoggle" class="hidden w-full flex flex-row justify-center items-center text-sm px-2 flex-wrap">
                    <div id="statusRRHH" class="w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>RRHH</h1>
                        </div>
                    </div>
                    <div id="statusCalidad" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>CALIDAD</h1>
                        </div>
                    </div>
                    <div id="statusDireccion" class="w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>DIRECCION</h1>
                        </div>
                    </div>
                    <div id="statusFinanzas" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>FINANZAS</h1>
                        </div>
                    </div>
                    <div id="statusCompras" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>COMPRAS</h1>
                        </div>
                    </div>
                </div>

                <div id="statusbitacora" onclick="expandir(this.id)" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                    <div class="">
                        <h1>BITACORA</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>B</h1>
                    </div>
                </div>
                <div id="statusbitacoratoggle" class="hidden w-full flex flex-row justify-center items-center text-sm px-2">
                    <div id="statusGP" class="w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>GP</h1>
                        </div>
                    </div>
                    <div id="statusTRS" class="w-full text-center h-8  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>TRS</h1>
                        </div>
                    </div>
                    <div id="statusZI" class="w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>ZI</h1>
                        </div>
                    </div>
                </div>
                <div id="statusFinalizar" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
                    <div class="">
                        <h1>SOLUCIONAR</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <i class="fas fa-check"></i>
                    </div>
                </div>

                <div class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs">
                    <div id="btnEditarTituloX" class="bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="expandir(this.id)">
                        <div class="">
                            <i class="fas fa-pen fa-lg"></i>
                        </div>
                    </div>
                    <div class=" bg-gray-200 w-full text-center h-8 cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                        <div class="">
                            <i class="fas fa-random fa-lg"></i>
                        </div>
                    </div>
                    <div id="statusActivo" class=" bg-gray-200 w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                        <div class="">
                            <i class="fas fa-trash fa-lg"></i>
                        </div>
                    </div>

                </div>

                <div id="btnEditarTituloXtoggle" class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs hidden">
                    <div class=" w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center text-gray-500 px-1">
                        <input id="editarTitulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="off" type="text" placeholder="Nuevo Título" maxlength="60">

                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold mx-1 px-3 py-2 rounded focus:outline-none focus:shadow-outline" id="btnEditarTitulo" type="button">
                            <i class="fas fa-check fa-1x"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- MODAL STATUS   -->
    <div id="modalTituloEliminar" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalTituloEliminar')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>STATUS</h1>
                </div>
            </div>
            <!-- CONTENIDO -->

            <div id="finalizar" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
                <div class="">
                    <h1>SOLUCIONAR</h1>
                </div>
                <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs">
                <div class=" bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="toggleModalTailwind('modalEditarTitulo');">
                    <div class="">
                        <i class="fas fa-pen fa-lg"></i>
                    </div>
                </div>
                <div class=" bg-gray-200 w-full text-center h-8 cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                    <div class="">
                        <i class="fas fa-random fa-lg"></i>
                    </div>
                </div>
                <div id="eliminar" class=" bg-gray-200 w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                    <div class="">
                        <i class="fas fa-trash fa-lg"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- MODAL EDITAR TITULO   -->
    <div id="modalEditarTitulo" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalEditarTitulo')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1><i class="fas fa-pen fa-lg"></i></h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm">

                <h1>Editar titulo</h1>
                <input class="mt-4 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="inputEditarTitulo" type="text" placeholder="Escriba titulo" value="" autocomplete="off">
                <button id="btnEditarTitulo" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded mt-4"><i class="fas fa-save fa-lg"></i> Guardar cambios</button>
            </div>
        </div>
    </div>


    <!-- MODAL EDITAR FECHA EN FALLAS -->
    <div id="modalFechaMC" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalFechaMC')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>RANGO DE FECHA</h1>
                </div>
            </div>
            <div class="flex flex-row items-center pt-10">
                <input id="fechaMC" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="fechaMC" value="" autocomplete="off">
            </div>
        </div>
    </div>


    <!-- MODAL EDITAR FECHA EN FALLAS   -->
    <div id="modalFechaTareas" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalFechaTareas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="flex flex-row items-center pt-10">
                <input id="fechaTareas" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="fechaTareas" value="" autocomplete="off">
            </div>
        </div>
    </div>


    <!-- MODAL EDITAR TITULO   -->
    <div id="modalAgregarMC" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalAgregarMC')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>

                        <h1><i class="fas fa-plus mr-2"></i>AÑADIR Pendiente</h1>
                    </h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm leading-none">
                <h1 class="mb-2 self-start">Equipo/Local afectado:</h1>
                <div class="bg-red-200 text-red-500 p-3 rounded self-start mb-4">
                    <h1 id="nombreEquipoMC"></h1>
                </div>
                <h1 class="self-start mb-2">Descripción:</h1>
                <input id="inputActividadMC" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Descripción (Max: 60 Caracteres)" maxlength="60" autocomplete="off">
                <div class="flex w-full items-center justify-center">

                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">Fecha inicio y Fecha tentativa de finalización:</h1>
                        <input id="inputRangoFechaMC" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" name="datefilter" value="---">
                    </div>

                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Responsable:</h1>
                        <div class="relative">
                            <select id="responsableMC" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" id="grid-state">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <h1 class="self-start mb-2">Comentario:</h1>
                <input id="comentarioMC" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Añadir comentario" autocomplete="off">

                <button id="btnAgregarMC" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-8 rounded mb-2">
                    <i class="fas fa-check"></i> Crear
                </button>
            </div>
        </div>
    </div>


    <!-- MODAL EDITAR INFORMACION -->
    <div id="modalActualizarProyecto" class="modal">
        <div class="modal-window rounded-md pb-2 px-5 py-3 text-center" style="width: 550px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalActualizarProyecto')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1 id="tituloActualizarProyecto">-</h1>
                </div>
            </div>

            <div id="tipoProyectoDiv" class="hidden flex flex-row items-center pt-10 justify-center">
                <div class="inline-block relative w-64">
                    <select id="tipoProyecto" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option>CAPIN</option>
                        <option>CAPEX</option>
                        <option>PROYECTO</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div id="justificacionProyectoDiv" class="hidden flex flex-row items-center pt-10">
                <textarea id="justificacionProyecto" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" cols="30" rows="5"></textarea>
            </div>

            <div id="costeProyectoDiv" class="hidden flex flex-row items-center pt-10 justify-center">
                <input id="costeProyecto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="0" placeholder="Cantidad">
            </div>

            <button id="btnGuardarInformacion" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded mt-4"><i class="fas fa-save fa-lg"></i>
                Guardar Cambios
            </button>

            <!-- CONTENIDO MEDIA -->
            <div id="mediaProyectos" class="hidden mt-10 p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div class="mb-3">
                    <button class="relative py-2 px-3 w-full bg-teal-200 text-teal-500 font-bold text-sm rounded-md hover:shadow-md">
                        <i class="fad fa-cloud-upload fa-lg mr-2"></i>
                        ADJUNTAR ARCHIVOS

                        <!-- INPUT -->
                        <input id="inputAdjuntosJP" type="file" class="absolute opacity-0 item-center mx-0 my-0 justify-center w-full" style="top:1px; left:5px;" name="inputAdjuntosJP[]" multiple>
                        <!-- INPUT -->

                    </button>
                </div>

                <!-- Icon upload -->
                <span id="cargandoAdjuntoJP" class="text-center"></span>
                <!-- Icon upload -->

                <div class="w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar">

                    <div id="contenedorImagenesJP">
                        <div class="font-bold divide-y">
                            <h1 class="text-left">IMÁGENES</h1>
                            <p> </p>
                        </div>
                        <div id="dataImagenesProyecto" class="flex flex-row flex-wrap text-center overflow-y-auto scrollbar" style="max-height: 20vh;"></div>
                    </div>

                    <div id="contenedorDocumentosJP">

                        <div class="font-bold divide-y mb-4">
                            <h1 class="text-left">DOCUMENTOS</h1>
                            <p> </p>
                        </div>
                        <div id="dataAdjuntosProyecto" class="flex flex-col overflow-y-auto scrollbar" style="max-height: 20vh;"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>


    <!-- MODAL EDITAR FECHA EN PROYECTOS -->
    <div id="modalFechaProyectos" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalFechaProyectos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>RANGO DE FECHA</h1>
                </div>
            </div>
            <div class="flex flex-row items-center pt-10">
                <input id="fechaProyecto" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="fechaProyecto" value="" autocomplete="off">
            </div>
        </div>
    </div>


    <!-- MODAL AGREGAR PROYECTO -->
    <div id="modalAgregarProyecto" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalAgregarProyecto')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>

                        <h1><i class="fas fa-plus mr-2"></i>AÑADIR PROYECTO</h1>
                    </h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm leading-none">

                <h1 class="self-start mb-2">Descripción:</h1>
                <input id="tituloProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Descripción del Proyecto" autocomplete="off">
                <div class="flex w-full items-center justify-center">
                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">Coste en USD:</h1>
                        <input id="costeProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" autocomplete="off">
                    </div>

                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Tipo:</h1>
                        <div class="relative">
                            <select id="tipoProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" id="grid-state">
                                <option value="">Seleccione</option>
                                <option value="CAPEX">CAPEX</option>
                                <option value="CAPIN">CAPIN</option>
                                <option value="PROYECTO">PROYECTO</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex w-full items-center justify-center">
                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">Fecha inicio y Fecha tentativa de finalización:</h1>
                        <input id="fechaProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" name="datefilter" value="---">
                    </div>

                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Responsable:</h1>
                        <div class="relative">
                            <select id="responsableProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" id="grid-state">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <h1 class="self-start mb-2">Justificación:</h1>
                <input id="justificacionProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Escriba aquí la justificación del Proyecto" autocomplete="off">

                <button id="btnCrearProyecto" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-8 rounded mb-2">
                    <i class="fas fa-check"></i> Crear
                </button>
            </div>
        </div>
    </div>


    <!-- MODAL EDITAR RANGO FECHA -->
    <div id="modalRangoFechaX" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalRangoFechaX')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>RANGO DE FECHA</h1>
                </div>
            </div>
            <div class="flex flex-row items-center pt-10">
                <input id="rangoFechaX" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="rangoFechaX" value="-" autocomplete="off">

                <button id="btnAplicarRangoFecha" class="bg-indigo-300 hover:bg-indigo-400 text-indigo-800 font-bold rounded inline-flex items-center w-10 text-center mx-2 p-2">
                    <i class="fal fa-sync-alt fa-lg"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- MODAL EDITAR RANGO FECHA -->


    <!-- MODAL AGREGAR TEST -->
    <div id="modalAgregarTest" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalAgregarTest')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>

                        <h1><i class="fas fa-plus mr-2"></i>AÑADIR TEST</h1>
                    </h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm leading-none">
                <h1 class="mb-2 self-start">Equipo afectado:</h1>
                <div class="bg-red-200 text-red-500 p-3 rounded self-start mb-4">
                    <h1 id="nombreEquipoTest"></h1>
                </div>
                <h1 class="self-start mb-2">Descripción del Test:</h1>

                <input id="descripcionTest" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Descripción (Max: 60 Caracteres)" maxlength="60" autocomplete="off">

                <div class="w-full py-3">
                    <h1 class="self-start mb-2">Medición:</h1>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input id="valorTest" type="text" class="bg-gray-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md px-2 py-3" placeholder="Ejemplo: 12.01" autocomplete="off">

                        <div class="absolute inset-y-0 right-0 flex items-center">
                            <select id="medidaTest" class="focus:ring-indigo-500 focus:border-indigo-500 h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-800 sm:text-sm rounded-md py-3"></select>
                        </div>
                    </div>
                </div>

                <div class="flex w-full items-center justify-center">

                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">
                            Fecha inicio y Fecha tentativa de finalización:
                        </h1>
                        <input id="inputRangoFechaTest" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="DD/MM/AAAA - DD/MM/AAAA" autocomplete="off">
                    </div>

                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Responsable:</h1>
                        <div class="relative">
                            <select id="responsableTest" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" id="grid-state">
                                <option value="0">Seleccion Responsable</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <button id="btnAgregarTest" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-8 rounded mb-2">
                    <i class="fas fa-check"></i> Crear
                </button>
            </div>
        </div>
    </div>


    <!-- MODAL PARA AGREGAR INCIDENCIAS -->
    <div id="modalAgregarIncidencias" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalAgregarIncidencias')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1></h1>
                    <h1>
                        <i class="fas fa-plus mr-2"></i>
                        INCIDENCIAS
                    </h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm leading-none">
                <div class="flex w-full items-center justify-center">
                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">Sección:</h1>
                        <div class="relative">
                            <select id="seccionIncidencias" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Subseccion:</h1>
                        <div class="relative">
                            <select id="subseccionIncidencias" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="mb-2 self-start">Equipo/Local afectado:</h1>
                <div class="flex flex-row cursor-pointer justify-start items-start">

                    <button id="btnTGIncidencias" type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                        Tarea General
                    </button>

                    <button id="btnEquipoIncidencias" type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                        Equipo
                    </button>

                    <button id="btnLocalIncidencias" type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                        Local
                    </button>
                </div>

                <div id="contenedorEquipoLocalIncidencias" class="relative w-1/2 hidden">
                    <select id="equipoLocalIncidencias" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4">
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                            </path>
                        </svg>
                    </div>
                </div>

                <h1 class="self-start mb-2">Descripción:</h1>
                <input id="descripcionIncidencia" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Descripción (Max: 60 Caracteres)" maxlength="60" autocomplete="off">

                <div class="flex w-full items-left justify-left">
                    <div class="w-1/2 flex flex-col pr-4 hidden">
                        <h1 class="self-start mb-2">Fecha inicio y Fecha tentativa de finalización:</h1>
                        <input id="rangoFechaIncidencia" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" value="" name="datefilter">
                    </div>
                    <div class="w-1/2 flex flex-col">
                        <h1 class="self-start mb-2">Responsable:</h1>
                        <div class="relative">
                            <select id="responsablesIncidencias" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex w-full flex-col">
                    <h1 class="self-start mb-2">Clasifique la incidencia:</h1>
                    <div class="bg-white  py-4 my-3 w-full mx-auto flex items-center">
                        <div class="w-full text-center">

                            <button id="btnEmergenciaIncidencia" type="button" class="border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación INMEDIATA">
                                Emergencia
                            </button>

                            <button id="btnUrgenciaIncidencia" type="button" class="border border-orange-500 text-orange-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-orange-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación RÁPIDA(No Inmediata)">
                                Urgencia
                            </button>

                            <button id="btnAlarmaIncidencia" type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación en Pocos Días(El Fallo no es inminente)">
                                Alarma
                            </button>

                            <button id="btnAlertaIncidencia" type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación en Pocas Semanas o Meses. Además, requiere de Seguimiento de la situación por si se detecta algún cambio que obligue a modificar la PRIORIDAD">
                                Alerta
                            </button>

                            <button id="btnSeguimientoIncidencia" type="button" class="border border-teal-500 text-teal-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="NO Requiere de Intervención pero requiere EVALUACIÓN PERIÓDICA para ver si la Situcación ha Cambiado">
                                Seguimiento
                            </button>

                        </div>
                    </div>
                </div>

                <div class="flex w-full flex-col">
                    <h1 class="self-start mb-2">Comentario:</h1>
                    <input id="comentarioIncidencia" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Añadir comentario" autocomplete="off">
                </div>
                <button id="btnAgregarIncidencia" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-8 rounded mb-2">
                    <i class="fas fa-check"></i>
                    Crear
                </button>
            </div>
        </div>
    </div>
    <!-- MODAL PARA AGREGAR INCIDENCIAS -->




    <!-- MODAL AGREGAR ENERGETICO   -->
    <div id="modalAgregarEnergeticos" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalAgregarEnergeticos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>

                        <h1><i class="fas fa-plus mr-2"></i>AÑADIR Pendiente</h1>
                    </h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm leading-none">

                <h1 class="mb-2 self-start">subsección:</h1>
                <div class="bg-red-200 text-red-500 p-3 rounded self-start mb-4">
                    <h1 id="nombreSubseccionEnergeticos"></h1>
                </div>

                <div class="flex w-full flex-col">
                    <h1 class="self-start mb-2">Clasifique la incidencia:</h1>
                    <div class="bg-white  py-4 my-3 w-full mx-auto flex items-center">
                        <div class="w-full text-center">

                            <button id="btnEmergenciaEnergetico" type="button" class="border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación INMEDIATA">
                                Emergencia
                            </button>

                            <button id="btnUrgenciaEnergetico" type="button" class="border border-orange-500 text-orange-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-orange-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación RÁPIDA(No Inmediata)">
                                Urgencia
                            </button>

                            <button id="btnAlarmaEnergetico" type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación en Pocos Días(El Fallo no es inminente)">
                                Alarma
                            </button>

                            <button id="btnAlertaEnergetico" type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación en Pocas Semanas o Meses. Además, requiere de Seguimiento de la situación por si se detecta algún cambio que obligue a modificar la PRIORIDAD">
                                Alerta
                            </button>

                            <button id="btnSeguimientoEnergetico" type="button" class="border border-teal-500 text-teal-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="NO Requiere de Intervención pero requiere EVALUACIÓN PERIÓDICA para ver si la Situcación ha Cambiado">
                                Seguimiento
                            </button>

                        </div>
                    </div>
                </div>

                <h1 class="self-start mb-2">Descripción:</h1>
                <input id="tituloPendienteEnergeticos" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Descripción (Max: 60 Caracteres)" maxlength="60" autocomplete="off">

                <div class="flex w-full items-center justify-center">

                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">Fecha inicio y Fecha tentativa de finalización:</h1>
                        <input id="rangoFechaEnergeticos" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" name="datefilter" value="---" autocomplete="off">
                    </div>

                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Responsable:</h1>
                        <div class="relative">
                            <select id="responsableEnergeticos" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" id="grid-state">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <h1 class="self-start mb-2">Comentario:</h1>
                <input id="comentarioEnergeticos" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Añadir comentario" autocomplete="off">

                <button id="btnAgregarEnergeticos" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-8 rounded mb-2">
                    <i class="fas fa-check"></i> Crear
                </button>

            </div>
        </div>
    </div>
    <!-- MODAL AGREGAR ENERGETICO   -->


    <!-- Modales -->


    <!-- ***** TOOLTIPS ***** -->

    <!-- ACTIVIDADES MP -->
    <div id="tooltipActividadesMP" role="tooltip" class="w-auto bg-white text-bluegray-800 flex flex-col items-start justify-start px-3 py-2 text-justify font-semibold text-xs uppercase rounded-md border overflow-y-auto scrollbar hidden" style="z-index:100; max-width: 350px; max-height: 400px;">
    </div>
    <!-- ACTIVIDADES MP -->


    <!-- ACTIVIDADES PLAN DE ACCIÓN -->
    <div id="tooltipActividadesPlanaccion" class="w-84 h-auto bg-bluegray-900 rounded-md p-1 flex hidden" role="tooltip" style="z-index:200">
        <div id="arrowtooltipActividadesProyecto" data-popper-arrow></div>
        <div class="bg-white rounded p-2 flex flex-col text-xxs font-semibold w-full">
            <div class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-fondos-2">
                <div class="w-4 h-4  mr-2 flex-none"></div>
                <div class=" text-justify w-full h-full">
                    <input id="agregarActividadPlanaccion" type="text" class="w-full h-full text-xs focus:outline-none appearance-none py-1 bg-transparent" placeholder="Añadir Actividad" autocomplete="off">
                </div>
                <div id="btnAgregarActividadPlanaccion" class="flex items-center justify-center text-blue-300 cursor-pointer w-6 h-6 rounded-full flex-none text-sm">
                    <i class="fas fa-plus"></i>
                </div>
            </div>

            <div id="dataActividades" class="w-auto overflow-y-auto scrollbar" style="max-height: 20vh;"></div>

        </div>
    </div>
    <!-- ACTIVIDADES PLAN DE ACCIÓN -->


    <!-- ACTIVIDADES PLAN DE ACCIÓN DEP -->
    <div id="tooltipActividadesPlanaccionDEP" class="w-84 h-auto bg-bluegray-900 rounded-md p-1 flex hidden" role="tooltip" style="z-index:200">
        <div class="bg-white rounded p-2 flex flex-col text-xxs font-semibold w-full">
            <div class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-fondos-2">
                <div class="w-4 h-4  mr-2 flex-none"></div>
                <div class=" text-justify w-full h-full">
                    <input id="agregarActividadPlanaccionDEP" type="text" class="w-full h-full text-xs focus:outline-none appearance-none py-1 bg-transparent" placeholder="Añadir Actividad" autocomplete="off">
                </div>
                <div id="btnAgregarActividadPlanaccionDEP" class="flex items-center justify-center text-blue-300 cursor-pointer w-6 h-6 rounded-full flex-none text-sm">
                    <i class="fas fa-plus"></i>
                </div>
            </div>

            <div id="dataActividadesDEP" class="w-auto overflow-y-auto scrollbar" style="max-height: 20vh;"></div>

        </div>
    </div>
    <!-- ACTIVIDADES PLAN DE ACCIÓN -->


    <!-- OPCIONES PARA ELIMINAR, EDITAR Y SOLUCIONAR -->
    <div id="tooltipEditarEliminarSolucionar" class="hidden bg-white rounded-md" style="z-index: 201;">
        <div class="pt-10 p-2" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="hiddenVista('tooltipEditarEliminarSolucionar')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>STATUS</h1>
                </div>
            </div>
            <!-- CONTENIDO -->

            <div id="btnFinalizar" class="w-full text-center h-8 rounded-md cursor-pointer mb-4 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
                <div class="">
                    <h1>SOLUCIONAR</h1>
                </div>
                <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <div id="segmentoTitulo" class="w-full text-center h-8 rounded-md cursor-pointer mb-4 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 text-xs hidden">
                <div class="w-full">
                    <input id="inputTitulo" type="text" class="w-64 p-2 text-justify text-black bg-gray-200 rounded-md text-black" placeholder="Actualizar título" autocomplete="off">
                </div>
                <div id="btnTitulo" class="w-8 h-8 flex items-center justify-center font-black px-5 bg-green-200 rounded-md">
                    <i class="fas fa-sync-alt fa-1x"></i>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs">

                <div id="btnActualizarTitulo" class="bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                    <div class="">
                        <i class="fas fa-pen fa-lg"></i>
                    </div>
                </div>

                <div class="bg-gray-200 w-full text-center h-8 cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                    <div class="">
                        <i class="fas fa-random fa-lg"></i>
                    </div>
                </div>

                <div id="btnEliminar" class=" bg-gray-200 w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                    <div class="">
                        <i class="fas fa-trash fa-lg"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- OPCIONES PARA ELIMINAR, EDITAR Y SOLUCIONAR -->


    <!-- ***** TOOLTIPS ***** -->

    <!-- SCRIPT PARA SORTABLE: SIRVE PARA MOVER ELEMENTOS) -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <!-- SCRIPT PARA SORTABLE: SIRVE PARA MOVER ELEMENTOS) -->

    <!-- Librerias JS -->
    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/acordion.js"></script>
    <!-- <script src="js/sweetalert2@9.js"></script> -->
    <script src="js/alertasSweet.js"></script>
    <script src="js/plannerBetaJS.js"></script>
    <!-- <script src="js/jPages.js"></script> -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/sorttable.js"></script>
    <!-- Librerias JS -->

    <!-- JS para los planes de los equipos -->
    <script src="js/planes_equipo.js" type="text/javascript"></script>
    <!-- JS para los planes de los equipos -->

    <!-- Librerias JS -->

    <!-- DEPENDENCIAS DE LOS GRAFICOS am4core -->
    <script src="js/am4core_core.js"></script>
    <script src="js/am4core_charts.js"></script>
    <script src="js/am4core_animated.js"></script>
    <!-- DEPENDENCIAS DE LOS GRAFICOS am4core -->

    <!-- LIBRERIAS INDIVIDUALES POR MODULOS -->
    <script src="js/proyectos_planacciones.js" type="text/javascript"></script>
    <script src="js/funciones_tablas.js" type="text/javascript"></script>
    <script src="js/proyectos_dep.js" type="text/javascript"></script>
    <!-- LIBRERIAS INDIVIDUALES POR MODULOS -->

    <!-- SEGURIDAD DE SESSION -->
    <script src="js/seguridad_session.js" type="text/javascript"></script>
    <!-- SEGURIDAD DE SESSION -->
</body>

</html>