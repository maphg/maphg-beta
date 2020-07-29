<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
    <title>Planner</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="css/jPages.css">

    <style>
        .w-22rem {
            width: 265px;
        }

        .shadow {
            display: block;
        }

        .mh {
            max-height: 500px;
        }

        .dia {
            font-size: 70px;
        }

        .top-20 {
            top: -2rem;
        }

        .btn-activo {
            color: white;
            background-color: #2d3748 !important;
        }

        .btn-inactivo {
            background-color: #e2e8f0;
        }
    </style>
</head>

<body class="bg-gray-200" style="font-family: 'Roboto', sans-serif;">

    <div class="w-full">
        <?php
        include 'navbartopJS.php';
        include 'menuJS.php';
        ?>
    </div>

    <!-- Inputs Temporales -->
    <input type="hidden" id="idDestinoSeleccionado">

    <div class="flex flex-col justify-evenly items-center w-full">
        <div class="scroll flex flex-row justify-start items-start w-full overflow-x-auto py-24 px-4">
            <div class="flex flex-col flex-wrap justify-center items-center w-22rem leading-none text-bluegray-100 mr-4">
                <div class="flex flex-row justify-center items-center w-full">
                    <p id="dia" class="font-semibold dia">00</p>
                </div>
                <div class="flex flex-row justify-center items-center w-full">
                    <p id="mes" class="font-semibold dia">00</p>
                </div>
                <div class="flex flex-row justify-center items-center w-full">
                    <p id="hora" class="font-semibold text-md">00:00</p>
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
                        <h1 class="w-8 h-8 mr-2"></h1>
                    </div>
                </div>
            </div>

            <!-- Inicio Columna -->
            <div id="columnasSeccionesZIL"></div>
            <div id="columnasSeccionesZIE"></div>
            <div id="columnasSeccionesAUTO"></div>
            <div id="columnasSeccionesDEC"></div>
            <div id="columnasSeccionesDEP"></div>
            <div id="columnasSeccionesOMA"></div>
            <div id="columnasSeccionesZHA"></div>
            <div id="columnasSeccionesZHC"></div>
            <div id="columnasSeccionesZHH"></div>
            <div id="columnasSeccionesZHP"></div>
            <div id="columnasSeccionesZIA"></div>
            <div id="columnasSeccionesZIC"></div>
        </div>
    </div>


    <!-- Inicio de Modales Modales -->

    <!-- MODAL EQUIPOS Y LOCALES -->
    <div id="modalEquipos" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1200px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalEquipos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-blue-200 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 id="seccionEquipos" class="font-medium text-base text-blue-500"><i class="fas fa-spinner fa-pulse fa-2x fa-fw"></i></h1>
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
                            <h1 id="tipoOrdenamientoMCN">MC-P</h1>
                        </div>
                        <div class="w-16 flex h-full items-center justify-center cursor-pointer">
                            <h1 id="tipoOrdenamientoMCF">MC-S</h1>
                        </div>
                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>MP-P</h1>
                        </div>
                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>MP-NP</h1>
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
                        <div id="btnExpandirMenutoggle" class="hidden absolute top-0 mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs">

                            <a id="exportarMisPendientes" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Mis
                                Pendientes (EXCEL)</a>

                            <a id="exportarSeccion" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Sección
                                completa (EXCEL)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="toggleModalTailwind('modalExportarSubsecciones')">Subsecciones (EXCEL)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="mostrarOcultar('exportarEXCEL','exportarPDF'); toggleModalTailwind('modalExportarSeccionesUsuarios')">Colaborador
                                (EXCEL)</a>

                            <a id="exportarMisPendientesPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Mis Pendientes (PDF)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="mostrarOcultar('exportarPDF','exportarEXCEL'); toggleModalTailwind('modalExportarSeccionesUsuarios')">Colaborador(PDF)</a>
                        </div>
                    </div>
                    <div class="ml-3" (Excel)>
                        <button id="btnvisualizarpendientesde" onclick="expandir(this.id)" class="py-1 px-2 rounded-b-md bg-teal-200 text-teal-500 hover:shadow-sm font-normal relative">
                            <i class="fas fa-eye mr-1"></i>Mis Pendientes
                        </button>
                        <div id="btnvisualizarpendientesdetoggle" class="hidden absolute top-0  mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs">
                            <a id="misPendientesUsuario" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Mis
                                Pendientes</a>
                            <a id="misPendientesSinUsuario" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Sin
                                Responsable</a>
                            <a id="misPendientesSeccion" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Todos</a>
                        </div>
                    </div>
                    <div class="ml-3">
                        <button id="dataOpcionesSubsecciones" onclick="expandir(this.id)" class="py-1 px-2 rounded-b-md bg-orange-200 text-orange-500 hover:shadow-sm font-normal relative">
                            <i class="fas fa-eye mr-1"></i>Subsecciones
                        </button>
                        <div id="dataOpcionesSubseccionestoggle" class="hidden absolute top-0  mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs">
                            <div id=""></div>
                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700">Subseccion 1</a>
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
                        <h1>Correctivo</h1>
                    </div>
                    <div class="py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                        <h1>Preventivo</h1>
                    </div>
                    <div class="py-1 px-2 rounded-r-md bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                        <h1>Proyectos</h1>
                    </div>
                </div>
            </div>

            <div class="px-2 mt-12">
                <table class="table-auto text-xs text-center w-full">
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


    <!-- MODAL MC Nuevos -->
    <div id="modalMCN" class="modal">
        <div class="modal-window rounded-md pt-10 w-auto md:w-10/12 lg:w-8/12">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMCN')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-blue-200 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 id="seccionMCN" class="font-medium text-base text-blue-500"></h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded">
                    <h1><span id="nombreEquipoMCN"></span> / CORRECTIVOS PENDIENTES</h1>
                </div>
            </div>

            <div class="hidden flex row justify-center items-center w-full text-xs">
                <div class="py-1 px-2 bg-red-300 text-red-700 rounded-l-md cursor-pointer">
                    <h1>AÑADIR CORRECTIVO</h1>
                </div>
                <div class="py-1 px-2 bg-indigo-300 text-indigo-700 cursor-pointer">
                    <h1>EXPORTAR LISTADO</h1>
                </div>
                <div class="py-1 px-2 bg-green-300 text-green-700 rounded-r-md cursor-pointer">
                    <h1>VER SOLUCIONADO</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor de los equipos y locales(Tabla) -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- titulos -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-full h-full flex items-center justify-center">
                            <h1>FALLA</h1>
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
                    <div id="dataMCN" class="w-full"></div>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL MCF -->
    <div id="modalMCF" class="modal">
        <div class="modal-window rounded-md pt-10 w-auto md:w-10/12 lg:w-8/12">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMCF')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-blue-200 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 class="font-medium text-base text-blue-500">ZIA</h1>
                </div>
                <div class="ml-4 font-bold bg-green-200 text-green-500 text-xs py-1 px-2 rounded">
                    <h1>CHILLER 01 / CORRECTIVOS SOLUCIONADOS</h1>
                </div>
            </div>

            <!-- <div class="flex row justify-center items-center w-full text-xs">
                <div class="py-1 px-2 bg-red-300 text-red-700 rounded-l-md cursor-pointer">
                    <h1>AÑADIR CORRECTIVO</h1>
                </div>
                <div class="py-1 px-2 bg-indigo-300 text-indigo-700 cursor-pointer">
                    <h1>EXPORTAR LISTADO</h1>
                </div>
                <div class="py-1 px-2 bg-green-300 text-green-700 rounded-r-md cursor-pointer">
                    <h1>VER SOLUCIONADO</h1>
                </div>
            </div> -->

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor de los equipos y locales(Tabla) -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- titulos -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-full h-full flex items-center justify-center">
                            <h1>FALLA</h1>
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
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer">
                        <!-- FALLA -->
                        <div class="w-full h-full flex flex-row items-center justify-between bg-green-100 text-green-500 rounded-l-md cursor-pointer hover:shadow-md border-l-4 border-green-200 relative">

                            <div class="absolute" style="left: -17px;">
                                <i class="fas fa-siren-on animated flash infinite fa-rotate-270"></i>
                            </div>
                            <div class="absolute flex hover:opacity-25" style="right: 0%; font-size: 9px;">
                                <div class=" bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1">
                                    <h1 class="">M</h1>
                                </div>
                                <div class=" bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1">
                                    <h1 class="">T</h1>
                                </div>
                                <div class=" bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1">
                                    <h1 class="">Electricidad</h1>
                                </div>
                                <div class=" bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1">
                                    <h1 class="">Dirección</h1>
                                </div>
                            </div>

                            <div class=" flex flex-row items-center truncate w-full">
                                <div>
                                    <i class="fas fa-hammer mx-2"></i>
                                </div>
                                <div class="flex flex-col leading-none w-full flex-wrap">
                                    <h1 class="">CAMBIAR LOS BALEROS A LA BOMBA Y REPARAR OTRA COSA. </h1>
                                    <h1 class="tex-xs font-normal italic text-green-300">creado por: Eduardo Meneses
                                    </h1>

                                </div>
                            </div>
                        </div>

                        <!-- RESPONSABLE -->
                        <div data-target="modal-responsable" data-toggle="modal" class="w-48 flex h-full items-center justify-center hover:shadow-md">
                            <h1>Eduardo Meneses</h1>
                        </div>

                        <!-- INICIO & FIN-->
                        <div class="w-64 flex h-full items-center justify-center hover:shadow-md">
                            <input class="bg-white focus:outline-none focus:shadow-none py-2 px-4 block w-full appearance-none leading-normal font-semibold text-xs text-center" type="text" type="text" name="datefilter" value="---" />
                        </div>
                        <!--  ADJUNTOS -->
                        <div data-target="modal-media" data-toggle="modal" class="w-32 flex h-full items-center justify-center hover:shadow-md">
                            <h1 class="font-xs">8</h1>
                        </div>
                        <!--  COMENTARIOS -->
                        <div data-target="modal-comentarios" data-toggle="modal" class="w-32 flex h-full items-center justify-center hover:shadow-md">
                            <h1>1</h1>
                        </div>
                        <!--  STATUS -->
                        <div class="w-32 flex h-full items-center justify-center hover:shadow-md hover:bg-red-200 text-red-500 rounded-r-md">
                            <div><i class="fas fa-undo fa-lg"></i></div>
                        </div>
                    </div>

                    <!-- equipo -->
                </div>
            </div>
        </div>
    </div>


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
                <button onkeydown="cerrarmodal('modalExportarSubsecciones')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                <div id="dataModalOpciones" class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
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
                    <input id="palabraUsuario" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." onkeydown=" obtenerUsuarios();" autocomplete="off">
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
                        <input id="inputAdjuntos" type="file" class="absolute opacity-0 item-center mx-0 my-0 justify-center w-full" style="top:1px; left:5px;">
                    </button>
                </div>
                <div class="w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar">
                    <div class="font-bold divide-y">
                        <h1>IMÁGENES</h1>
                        <p> </p>
                    </div>
                    <!-- Data para las imagenes -->
                    <div id="dataImagenes" class="flex flex-row flex-wrap text-center"></div>
                    <div class="font-bold divide-y mb-4">
                        <h1>DOCUMENTOS</h1>
                        <p> </p>
                    </div>
                    <div id="dataAdjuntos" class="flex flex-col"></div>
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
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">

                <div class="px-4 overflow-y-auto scrollbar flex flex-col w-full" style="max-height: 80vh;">
                    <div id="dataComentarios" class="flex justify-center items-center flex-col-reverse w-full"></div>
                </div>
                <div class="flex flex-row justify-center items-center w-full h-10 px-16 mt-4">
                    <input id="inputComentario" type="text" placeholder="    Añadir comentario" class="h-full w-full rounded-l-md text-gray-600 font-medium border-2 border-r-0 focus:outline-none">
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

                <div id="statusUrgente" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-red-500 bg-gray-200 hover:bg-red-200 text-xs">
                    <div class="">
                        <h1>ES URGENTE</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <i class="fas fa-siren-on animated flash infinite"></i>
                    </div>
                </div>

                <div id="statusMaterial" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs">
                    <div class="">
                        <h1>NO HAY MATERIAL</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>M</h1>
                    </div>
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
                    <div class="w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>GP</h1>
                        </div>
                    </div>
                    <div class="w-full text-center h-8  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>TRS</h1>
                        </div>
                    </div>
                    <div class="w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>ZI</h1>
                        </div>
                    </div>
                </div>
                <div id="statusFinalizarMC" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
                    <div class="">
                        <h1>SOLUCIONAR</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <i class="fas fa-check"></i>
                    </div>
                </div>

                <div class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs">
                    <div class=" bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="toggleModalTailwind('modalEditarTituloMC');">
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
            </div>
        </div>
    </div>


    <!-- MODAL EDITAR TITULO   -->
    <div id="modalEditarTituloMC" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalEditarTituloMC')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                <input class="mt-4 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="inputEditarTituloMC" type="text" placeholder="Escriba titulo" value="">
                <button id="btnEditarTituloMC" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded mt-4"><i class="fas fa-save fa-lg"></i> Guardar cambios</button>
            </div>
        </div>
    </div>

    <!-- Modales -->


    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
    <script src="js/modales.js"></script>
    <script src="js/acordion.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script src="js/calendarioBotones.js"></script>
    <script src="js/plannerBetaJS.js"></script>
    <script src="js/jPages.js"></script>

</body>

</html>