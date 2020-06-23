<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planner</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <style>
    .w-22rem {
        width: 230px;
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

    <div class="flex flex-col justify-evenly items-center w-screen h-screen">


        <div class="scroll flex flex-row justify-start items-start w-full overflow-x-auto py-24 px-4">
            <div
                class="flex flex-col flex-wrap justify-center items-center w-22rem leading-none text-bluegray-100 mr-4">
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
                        <i class="fas fa-map-marker-alt mt-1"></i> Riviera Maya
                    </p>
                </div>
                <div class="flex flex-col justify-end mt-6 items-end w-full pr-10">
                    <!-- <img src="svg/calendario/lunes.svg" class="w-5/12" alt=""> -->
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-lunes" class="text-sm font-bold mr-4">LUNES</h1>
                        <h1 onclick="botones('zia');" id="btn-zia"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZIA
                        </h1>
                        <h1 onclick="botones('zhp');" id="btn-zhp"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZHP
                        </h1>
                    </div>
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-martes" class="text-sm font-bold mr-4">MARTES</h1>
                        <h1 onclick="botones('zic');" id="btn-zic"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZIC
                        </h1>
                        <h1 class="w-8 h-8 mr-2"></h1>
                    </div>
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-miercoles" class=" text-sm font-bold mr-4">MIERCOLES</h1>
                        <h1 onclick="botones('dec');" id="btn-dec"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            DEC
                        </h1>
                        <h1 onclick="botones('zie');" id="btn-zie"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZIE
                        </h1>
                    </div>
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-jueves" class=" text-sm font-bold mr-4">JUEVES</h1>
                        <h1 onclick="botones('zhc');" id="btn-zhc"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZHC
                        </h1>
                        <h1 onclick="botones('zha');" id="btn-zha"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZHA
                        </h1>
                    </div>
                    <div class="flex flex-row items-center justify-end mb-2">
                        <h1 id="label-viernes" class=" text-sm font-bold mr-4">VIERNES</h1>
                        <h1 onclick="botones('zil');" id="btn-zil"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            ZIL
                        </h1>
                        <h1 onclick="botones('aut');" id="btn-auto"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            AUT
                        </h1>
                    </div>
                    <div class="flex flex-row items-center justify-center mb-2">
                        <h1 onclick="botones('dep');" id="btn-dep"
                            class="w-8 h-8 btn-inactivo text-xs rounded-md flex flex-row justify-center items-center font-semibold mr-2 cursor-pointer hover:bg-gray-800 hover:text-gray-100">
                            DEP
                        </h1>
                        <h1 class="w-8 h-8 mr-2"></h1>
                    </div>
                </div>
            </div>

            <div id="coldep" class="hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4">
                <div
                    class="bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh">
                    <div
                        class="flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12">
                        <h1 class="font-medium text-md text-gray-100">DEP</h1>
                    </div>
                    <div
                        class="flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900">
                        <i data-target="modal-zia" data-toggle="modal" class="fad fa-expand-arrows"></i>
                    </div>
                    <div class="w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar">
                        <!-- subsecciones -->
                        <div
                            class="flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800">
                            <div id="abremodal" data-target="modal-subseccion" data-toggle="modal"
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">CALIDAD</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">RRHH</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">COMPRAS</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">DIRECCION</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">PROYECTOS</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


            <div id="colzia" class="hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4">
                <div
                    class="bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh">
                    <div
                        class="zia-icon flex justify-center items-center absolute top-20 shadow-md rounded-lg w-12 h-12">
                        <h1 class="font-medium text-md">ZIA</h1>
                    </div>
                    <div
                        class="flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900">
                        <i data-target="modal-zia" data-toggle="modal" class="fad fa-expand-arrows"></i>
                    </div>
                    <div class="w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar">
                        <!-- subsecciones -->
                        <div
                            class="flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800">
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">FILTROS - SUAVIZADORES - OSMOSIS</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">FILTROS - SUAVIZADORES - OSMOSIS</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">FILTROS - SUAVIZADORES - OSMOSIS</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">FILTROS - SUAVIZADORES - OSMOSIS</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>
                            <div
                                class="p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center">
                                <h1 class="truncate mr-2">FILTROS - SUAVIZADORES - OSMOSIS</h1>
                                <div
                                    class=" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center">
                                    <h1>22</h1>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div id="colzie"
                class="flex flex-row justify-center items-center bg-gray-900 w-64 h-64 hidden mx-3 rounded-full">
                <h1 class="text-white">zie</h1>
            </div>
            <div id="coldec"
                class="flex flex-row justify-center items-center bg-gray-800 w-64 h-64 hidden mx-3 rounded-full">
                <h1 class="text-white">dec</h1>
            </div>
            <div id="colzhp"
                class="flex flex-row justify-center items-center bg-gray-700 w-64 h-64 hidden mx-3 rounded-full">
                <h1 class="text-white">zhp</h1>
            </div>
            <div id="colzic"
                class="flex flex-row justify-center items-center bg-gray-600 w-64 h-64 hidden mx-3 rounded-full">
                <h1 class="text-white">zic</h1>
            </div>
            <div id="colzhc"
                class="flex flex-row justify-center items-center bg-gray-500 w-64 h-64 hidden mx-3 rounded-full">
                <h1 class="text-white">zhc</h1>
            </div>
            <div id="colzha"
                class="flex flex-row justify-center items-center bg-gray-400 w-64 h-64 hidden mx-3 rounded-full">
                <h1 class="text-white">zha</h1>
            </div>
            <div id="colzil"
                class="flex flex-row justify-center items-center bg-blue-900 w-64 h-64 hidden mx-3 rounded-full">
                <h1 class="text-white">zil</h1>
            </div>
            <div id="colauto"
                class="flex flex-row justify-center items-center bg-red-900 w-64 h-64 hidden mx-3 rounded-full">
                <h1 class="text-white">uto</h1>
            </div>
        </div>
    </div>
    <!-- Modales -->

    <!-- MODAL EQUIPOS Y LOCALES -->
    <div id="modal-subseccion" class="modal ">
        <div class="modal-window rounded-md pt-10" style="width: 1300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-subseccion')"
                    class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-blue-200 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 class="font-medium text-base text-blue-500">ZIA</h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded">
                    <h1>SUBSECCION / EQUIPOS Y LOCALES</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 mt-6 flex justify-center items-center flex-col">
                <div class="flex flex-row items-center w-full">
                    <div class="ml-10 relative text-gray-600 w-2/6 self-start">
                        <input
                            class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full"
                            type="search" name="search" placeholder="Buscar Equipo/Local">
                        <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                            <i class="fad fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Contenedor de los equipos y locales(Tabla) -->
                <div class="mt-2 w-full flex flex-col justify-center items-center">
                    <!-- titulos -->
                    <div
                        class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-2/6 h-full flex items-center justify-center">
                            <h1>EQUIPOS / LOCALES</h1>
                        </div>
                        <div class="w-16 h-full flex items-center justify-center">
                            <h1>MC-P</h1>
                        </div>
                        <div class="w-16 flex h-full items-center justify-center">
                            <h1>MC-S</h1>
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

                    <!-- equipo -->
                    <div
                        class="mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer">
                        <div id="equipo123" onclick="expandir(this.id)"
                            class="w-2/6 h-full flex flex-row items-center justify-between bg-blue-100 text-blue-500 rounded-l-md cursor-pointer hover:shadow-md">
                            <div class=" flex flex-row items-center truncate">
                                <i class="fas fa-cog mx-2"></i>
                                <h1>UMA 01 CHICK CABARET</h1>
                            </div>
                            <div class="mx-2">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <!-- MC PENDIENTES -->
                        <div data-target="modal-mc-p" data-toggle="modal"
                            class="w-16 h-full flex items-center justify-center bg-red-200 text-red-400 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!-- MC SOLUCIONADOS -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!-- MP PLANIFICADOS -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!-- MP NO PLANIFICADOS -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-purple-200 text-purple-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!-- MP FINALIZADOS -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!--  ULTIMO MP -->
                        <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                            <h1 class="font-xs">ENE 2020</h1>
                        </div>
                        <!--  TEST -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-indigo-200 text-indigo-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!--  ULTIMO TEST -->
                        <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                            <h1 class="font-xs">AGO 2020</h1>
                        </div>
                        <!--  COTIZACIONES -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!--  INFO -->
                        <div
                            class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 hover:shadow-md">
                            <h1><i class="fas fa-eye fa-lg"></i></h1>
                        </div>
                        <!--  MEDIA -->
                        <div
                            class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 rounded-r-md hover:shadow-md">
                            <h1><i class="fas fa-photo-video fa-lg"></i></h1>
                        </div>
                    </div>
                    <!-- despiece -->
                    <div id="equipo123toggle" class="hidden w-full mb-2">
                        <!-- equipo de despiece -->
                        <div
                            class="mt-1 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer border-gray-600">
                            <div class="w-2/6 h-full flex flex-row items-center justify-between">
                                <div
                                    class="ml-3 flex flex-row items-center truncate bg-gray-200 h-full w-full rounded-l-md hover:shadow-md">
                                    <i class="fas fa-level-up mx-2 fa-rotate-90"></i>
                                    <i class="fas fa-cog mr-2"></i>
                                    <h1>BOMBA X</h1>
                                </div>
                            </div>
                            <!-- MC PENDIENTES -->
                            <div class="w-16 h-full flex items-center justify-center text-red-400 hover:shadow-md">
                                <h1>---</h1>
                            </div>
                            <!-- MC SOLUCIONADOS -->
                            <div class="w-16 flex h-full items-center justify-center text-green-500">
                                <h1>---</h1>
                            </div>
                            <!-- MP PLANIFICADOS -->
                            <div class="w-16 flex h-full items-center justify-center text-blue-500 hover:shadow-md">
                                <h1>---</h1>
                            </div>
                            <!-- MP NO PLANIFICADOS -->
                            <div class="w-16 flex h-full items-center justify-center text-purple-500 hover:shadow-md">
                                <h1>---</h1>
                            </div>
                            <!-- MP FINALIZADOS -->
                            <div class="w-16 flex h-full items-center justify-center text-green-500 hover:shadow-md">
                                <h1>---</h1>
                            </div>
                            <!--  ULTIMO MP -->
                            <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                                <h1 class="font-xs">---</h1>
                            </div>
                            <!--  TEST -->
                            <div class="w-16 flex h-full items-center justify-center hover:shadow-md">
                                <h1>---</h1>
                            </div>
                            <!--  ULTIMO TEST -->
                            <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                                <h1 class="font-xs">---</h1>
                            </div>
                            <!--  COTIZACIONES -->
                            <div class="w-16 flex h-full items-center justify-center text-blue-500 hover:shadow-md">
                                <h1>---</h1>
                            </div>
                            <!--  INFO -->
                            <div
                                class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 hover:shadow-md">
                                <h1><i class="fas fa-eye fa-lg"></i></h1>
                            </div>
                            <!--  MEDIA -->
                            <div
                                class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 rounded-r-md hover:shadow-md">
                                <h1><i class="fas fa-photo-video fa-lg"></i></h1>
                            </div>
                        </div>

                        <!-- equipo de despiece -->
                        <div
                            class="mt-1 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer border-gray-600">
                            <div class="w-2/6 h-full flex flex-row items-center justify-between ">
                                <div
                                    class="ml-3 flex flex-row items-center truncate bg-gray-200 h-full w-full rounded-l-md  hover:shadow-md">
                                    <i class="fas fa-level-up mx-2 fa-rotate-90"></i>
                                    <i class="fas fa-cog mr-2"></i>
                                    <h1>CONDENSADOR Y</h1>
                                </div>
                            </div>
                            <!-- MC PENDIENTES -->
                            <div
                                class="w-16 h-full flex items-center justify-center bg-red-200 text-red-400 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MC SOLUCIONADOS -->
                            <div class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500">
                                <h1>22</h1>
                            </div>
                            <!-- MP PLANIFICADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MP NO PLANIFICADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-purple-200 text-purple-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MP FINALIZADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  ULTIMO MP -->
                            <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                                <h1 class="font-xs">ENE 2020</h1>
                            </div>
                            <!--  TEST -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-indigo-200 text-indigo-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  ULTIMO TEST -->
                            <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                                <h1 class="font-xs">AGO 2020</h1>
                            </div>
                            <!--  COTIZACIONES -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  INFO -->
                            <div
                                class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 hover:shadow-md">
                                <h1><i class="fas fa-eye fa-lg"></i></h1>
                            </div>
                            <!--  MEDIA -->
                            <div
                                class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 rounded-r-md hover:shadow-md">
                                <h1><i class="fas fa-photo-video fa-lg"></i></h1>
                            </div>
                        </div>
                    </div>

                    <!-- local -->
                    <div
                        class="mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer">
                        <div id="local123" onclick="expandir(this.id)"
                            class="w-2/6 h-full flex flex-row items-center justify-between bg-purple-100 text-purple-500 rounded-l-md cursor-pointer hover:shadow-md">
                            <div class=" flex flex-row items-center truncate">
                                <i class="fas fa-home-lg mx-2"></i>
                                <h1>VILLA 65 COLONIAL</h1>
                            </div>
                            <div class="mx-2">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>
                        <!-- MC PENDIENTES -->
                        <div
                            class="w-16 h-full flex items-center justify-center bg-red-200 text-red-400 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!-- MC SOLUCIONADOS -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!-- MP PLANIFICADOS -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!-- MP NO PLANIFICADOS -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-purple-200 text-purple-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!-- MP FINALIZADOS -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!--  ULTIMO MP -->
                        <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                            <h1 class="font-xs">ENE 2020</h1>
                        </div>
                        <!--  TEST -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-indigo-200 text-indigo-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!--  ULTIMO TEST -->
                        <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                            <h1 class="font-xs">AGO 2020</h1>
                        </div>
                        <!--  COTIZACIONES -->
                        <div
                            class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                            <h1>22</h1>
                        </div>
                        <!--  INFO -->
                        <div
                            class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 hover:shadow-md">
                            <h1><i class="fas fa-eye fa-lg"></i></h1>
                        </div>
                        <!--  MEDIA -->
                        <div
                            class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 rounded-r-md hover:shadow-md">
                            <h1><i class="fas fa-photo-video fa-lg"></i></h1>
                        </div>
                    </div>
                    <!-- despiece -->
                    <div id="local123toggle" class="hidden w-full mb-2">
                        <!-- equipo de despiece -->
                        <div
                            class="mt-1 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer border-gray-600">
                            <div class="w-2/6 h-full flex flex-row items-center justify-between">
                                <div
                                    class="ml-3 flex flex-row items-center truncate bg-gray-200 h-full w-full rounded-l-md hover:shadow-md">
                                    <i class="fas fa-level-up mx-2 fa-rotate-90"></i>
                                    <i class="fas fa-home-lg-alt mr-2"></i>
                                    <h1>HABITACIÓN 6501</h1>
                                </div>
                            </div>
                            <!-- MC PENDIENTES -->
                            <div
                                class="w-16 h-full flex items-center justify-center bg-red-200 text-red-400 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MC SOLUCIONADOS -->
                            <div class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500">
                                <h1>22</h1>
                            </div>
                            <!-- MP PLANIFICADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MP NO PLANIFICADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-purple-200 text-purple-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MP FINALIZADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  ULTIMO MP -->
                            <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                                <h1 class="font-xs">ENE 2020</h1>
                            </div>
                            <!--  TEST -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-indigo-200 text-indigo-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  ULTIMO TEST -->
                            <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                                <h1 class="font-xs">AGO 2020</h1>
                            </div>
                            <!--  COTIZACIONES -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  INFO -->
                            <div
                                class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 hover:shadow-md">
                                <h1><i class="fas fa-eye fa-lg"></i></h1>
                            </div>
                            <!--  MEDIA -->
                            <div
                                class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 rounded-r-md hover:shadow-md">
                                <h1><i class="fas fa-photo-video fa-lg"></i></h1>
                            </div>
                        </div>

                        <!-- equipo de despiece -->
                        <div
                            class="mt-1 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer border-gray-600">
                            <div class="w-2/6 h-full flex flex-row items-center justify-between">
                                <div
                                    class="ml-3 flex flex-row items-center truncate bg-gray-200 h-full w-full rounded-l-md hover:shadow-md">
                                    <i class="fas fa-level-up mx-2 fa-rotate-90"></i>
                                    <i class="fas fa-home-lg-alt mr-2"></i>
                                    <h1>HABITACIÓN 6502</h1>
                                </div>
                            </div>
                            <!-- MC PENDIENTES -->
                            <div
                                class="w-16 h-full flex items-center justify-center bg-red-200 text-red-400 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MC SOLUCIONADOS -->
                            <div class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500">
                                <h1>22</h1>
                            </div>
                            <!-- MP PLANIFICADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MP NO PLANIFICADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-purple-200 text-purple-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!-- MP FINALIZADOS -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  ULTIMO MP -->
                            <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                                <h1 class="font-xs">ENE 2020</h1>
                            </div>
                            <!--  TEST -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-indigo-200 text-indigo-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  ULTIMO TEST -->
                            <div class="w-24 flex h-full items-center justify-center hover:shadow-md">
                                <h1 class="font-xs">AGO 2020</h1>
                            </div>
                            <!--  COTIZACIONES -->
                            <div
                                class="w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md">
                                <h1>22</h1>
                            </div>
                            <!--  INFO -->
                            <div
                                class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 hover:shadow-md">
                                <h1><i class="fas fa-eye fa-lg"></i></h1>
                            </div>
                            <!--  MEDIA -->
                            <div
                                class="w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 rounded-r-md hover:shadow-md">
                                <h1><i class="fas fa-photo-video fa-lg"></i></h1>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="px-4 py-3 flex items-center justify-center border-t border-gray-200 sm:px-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#"
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        Previous
                    </a>
                    <a href="#"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                        Next
                    </a>
                </div>
                <div>
                    <nav class="relative inline-flex shadow-sm">
                        <button type="button"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                            aria-label="Previous">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <button type="button"
                            class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            1
                        </button>
                        <button type="button"
                            class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            2
                        </button>
                        <button type="button"
                            class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                            aria-label="Next">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    </div>


    <!-- Modal Pendientes -->
    <div id="modal-zia" class="modal">
        <div class="modal-window rounded-md pt-10 w-11/12 rounded-md">
            <!-- CONTENIDO MODAL -->
            <div class="flex flex-row-items-center justify-center">
                <div class="absolute top-0 right-0">
                    <button onclick="cerrarmodal('modal-zia')"
                        class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="absolute top-0 left-0 flex flex-row">
                    <div>
                        <button id="btnExpandirMenu" onclick="expandir(this.id)"
                            class="py-1 px-2 rounded-br-md bg-indigo-200 text-indigo-500 hover:shadow-sm rounded-tl-md font-normal">
                            <i class="fas fa-arrow-to-bottom mr-1"></i>Exportar Pendientes
                        </button>
                    </div>
                    <div class="ml-3">
                        <button id="btnExpandirGantt" onclick="expandir(this.id)"
                            class="py-1 px-2 rounded-b-md bg-teal-200 text-teal-500 hover:shadow-sm font-normal">
                            <i class="fas fa-project-diagram mr-1"></i>Gantt
                        </button>
                    </div>
                </div>
                <div id="btnExpandirMenutoggle"
                    class="hidden absolute top-0 left-0 mt-10 ml-3 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs">
                    <a href="#" class="py-1 px-2 w-full hover:bg-gray-700">Sección completa</a>
                    <a href="#" class="py-1 px-2 w-full hover:bg-gray-700">Subseccion</a>
                    <a href="#" class="py-1 px-2 w-full hover:bg-gray-700">Colaborador</a>
                </div>

                <div
                    class="flex justify-center items-center absolute top-0 bg-blue-200 rounded-b-md w-16 h-10 shadow-xs mx-auto">
                    <h1 class="font-normal text-base text-blue-500">ZIA</h1>
                </div>
            </div>

            <!-- Contenedor principal como columnas -->
            <div class="flex flex-col justify-center items-center mt-10 w-full divide-y divide-gray-200">
                <!-- Fila de Titulos -->
                <div class="flex flex-row justify-center items-center w-full my-4">
                    <div class="w-2/12 flex flex-row text-sm bg-white ml-6">
                        <div class="py-1 px-2 rounded-l-md bg-red-200 text-red-500 font-normal cursor-pointer">
                            <h1>Correctivo</h1>
                        </div>
                        <div
                            class="py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                            <h1>Preventivo</h1>
                        </div>
                        <div
                            class="py-1 px-2 rounded-r-md bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                            <h1>Proyectos</h1>
                        </div>
                    </div>
                    <!-- Contenedor de las 4 columnas -->
                    <div
                        class="flex flex-wrap justify-center items-center w-full text-gray-800 text-center font-semibold text-xl divide-x divide-gray-200">
                        <div class="w-1/4">
                            <h1>Pendientes</h1>
                        </div>
                        <div class="w-1/4">
                            <h1>Pendiente DEP</h1>
                        </div>
                        <div class="w-1/4">
                            <h1>Trabajando</h1>
                        </div>
                        <div class="w-1/4">
                            <h1>Solucionado</h1>
                        </div>
                    </div>
                </div>
                <!-- Fila de subseccion -->
                <div class="flex flex-row justify-center items-center w-full py-4">
                    <div class="w-2/12 font-medium text-sm text-gray-800 text-center">
                        <h1>FILTROS - OSMOSIS - SUAVIZADORES</h1>
                    </div>
                    <!-- Contenedor de las 4 columnas -->
                    <div
                        class="flex flex-wrap justify-center items-center w-full text-gray-800 text-center font-semibold text-xs">
                        <!-- Contenedor de tareas -->
                        <div id="filtrospen" ondblclick="expandirpapa(this.id)"
                            class="w-1/4 h-40 overflow-y-auto scrollbar px-2 rounded-md">
                            <!-- COLUMNA PENDIENTES -->
                            <!-- Contenedor de tarea -->
                            <div id="567" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="567titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="567toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="filtrodep" ondblclick="expandirpapa(this.id)"
                            class="w-1/4 h-40 overflow-y-auto scrollbar px-2">
                            <!-- COLUMNA DEP -->
                            <!-- Contenedor de tarea -->
                            <div id="123" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="123titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-normal bg-red-200 text-red-500 py-1 px-2 rounded-full">
                                            Material</p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="123toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                            <!-- Contenedor de tarea -->
                            <div id="456" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="456titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-normal bg-blue-200 text-blue-500 py-1 px-2 rounded-full">
                                            Calidad</p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="456toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                            <!-- Contenedor de tarea -->
                            <div id="678" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="678titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p
                                            class="text-xs font-normal bg-purple-200 text-purple-500 py-1 px-2 rounded-full">
                                            Dirección</p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="678toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="filtrotra" ondblclick="expandirpapa(this.id)"
                            class="w-1/4 h-40 overflow-y-auto scrollbar px-2">
                            <!-- COLUMNA TRABAJANDO -->
                            <!-- Contenedor de tarea -->
                            <div id="980" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="980titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-blue-200 text-blue-500 py-1 px-2 rounded">T</p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="980toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="filtrossol" ondblclick="expandirpapa(this.id)"
                            class="w-1/4 h-40 overflow-y-auto scrollbar px-2">
                            <!-- COLUMNA SOLUCIONADOS -->
                            <!-- Contenedor de tarea -->
                            <div id="111" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="111titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded">F
                                        </p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="111toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                            <!-- Contenedor de tarea -->
                            <div id="222" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="222titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded">F
                                        </p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="222toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                            <!-- Contenedor de tarea -->
                            <div id="333" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="333titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded">F
                                        </p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="333toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                            <!-- Contenedor de tarea -->
                            <div id="444" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="444titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded">F
                                        </p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="444toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                            <!-- Contenedor de tarea -->
                            <div id="555" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="555titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded">F
                                        </p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="555toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                            <!-- Contenedor de tarea -->
                            <div id="666" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="666titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded">F
                                        </p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="666toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                            <!-- Contenedor de tarea -->
                            <div id="777" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="777titulo" class="truncate">xxxxxAqui iria el titulo de la tarea correctiva o
                                        la descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded">F
                                        </p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="777toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>cccccccccccccccccccccccct consectetur adipisicing elit. Repellat, recusandae
                                            natus vel dolor placeat expedita unde repudiandae voluptatem temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fila de subseccion -->
                <div class="flex flex-row justify-center items-center w-full py-4">
                    <div class="w-2/12 font-medium text-sm text-gray-800 text-center">
                        <h1>PTAR</h1>
                    </div>
                    <!-- Contenedor de las 4 columnas -->
                    <div
                        class="flex flex-wrap justify-center items-center w-full text-gray-800 text-center font-semibold text-xs">
                        <!-- Contenedor de tareas -->
                        <div id="filtrospen" ondblclick="expandirpapa(this.id)"
                            class="w-1/4 h-40 overflow-y-auto scrollbar px-2 rounded-md">
                            <!-- COLUMNA PENDIENTES -->
                            <!-- Contenedor de tarea -->
                            <div id="567" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="567titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots"></i>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="567toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="filtrodep" ondblclick="expandirpapa(this.id)"
                            class="w-1/4 h-40 overflow-y-auto scrollbar px-2">
                            <!-- COLUMNA DEP -->
                            <!-- Contenedor de tarea -->
                            <div id="678" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="678titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p
                                            class="text-xs font-normal bg-purple-200 text-purple-500 py-1 px-2 rounded-full">
                                            Dirección</p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="678toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="filtrotra" ondblclick="expandirpapa(this.id)"
                            class="w-1/4 h-40 overflow-y-auto scrollbar px-2">
                            <!-- COLUMNA TRABAJANDO -->
                            <!-- Contenedor de tarea -->
                            <div id="980" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="980titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-blue-200 text-blue-500 py-1 px-2 rounded">T</p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="980toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="filtrossol" ondblclick="expandirpapa(this.id)"
                            class="w-1/4 h-40 overflow-y-auto scrollbar px-2 relative">
                            <!-- COLUMNA SOLUCIONADOS -->
                            <!-- Contenedor de tarea -->
                            <div id="111" onclick="expandir(this.id)"
                                class="flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md">
                                <!-- Titulo -->
                                <div class="my-1">
                                    <p id="111titulo" class="truncate">Aqui iria el titulo de la tarea correctiva o la
                                        descripcion de la misma.</p>
                                </div>
                                <!-- Iconos -->
                                <div class="flex flex-row justify-between items-center text-sm">
                                    <div class="flex flex-row">
                                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                            width="20" height="20" alt="">
                                        <p class="text-xs font-bold ml-1 text-gray-600">Eduardo Meneses</p>
                                    </div>
                                    <div class="flex flex-row items-center text-gray-600">
                                        <i class="fas fa-paperclip mr-2"></i>
                                        <i class="fas fa-comment-dots mr-2"></i>
                                        <p class="text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded">F
                                        </p>
                                    </div>
                                </div>
                                <!-- Toogle -->
                                <div id="111toggle" class="hidden mt-2">
                                    <div
                                        class="flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal">
                                        <h1 class="text-left font-bold text-left mb-1">Último comentario:</h1>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                            recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                            temporibus.</p>
                                        <div class="flex flex-row mt-1 self-center">
                                            <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D"
                                                width="20" height="20" alt="">
                                            <p class="text-xs font-bold ml-1 text-gray-600">Javier Duarte</p>
                                            <p class="text-xs font-bold ml-6 text-gray-600">13/09/2020 14:22:45</p>
                                        </div>
                                    </div>
                                    <button
                                        class="py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold">
                                        <i class="fas fa-eye mr-1  text-sm"></i>Ver en Planner
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <!-- CONTENIDO MODAL -->
        </div>
    </div>

    <!-- MODAL MC-P -->
    <div id="modal-mc-p" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-mc-p')"
                    class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-blue-200 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 class="font-medium text-base text-blue-500">ZIA</h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded">
                    <h1>CHILLER 01 / CORRECTIVOS PENDIENTES</h1>
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
                    <div
                        class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
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

                    <!-- equipo -->
                    <div
                        class="mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer">
                        <!-- FALLA -->
                        <div
                            class="w-full h-full flex flex-row items-center justify-between bg-red-100 text-red-500 rounded-l-md cursor-pointer hover:shadow-md border-l-4 border-red-200 relative">

                            <div class="absolute" style="left: -17px;">
                                <i class="fas fa-siren-on animated flash infinite fa-rotate-270"></i>
                            </div>
                            <div class="absolute flex hover:opacity-25" style="right: 0%; font-size: 9px;">
                                <div
                                    class=" bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1">
                                    <h1 class="">M</h1>
                                </div>
                                <div
                                    class=" bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1">
                                    <h1 class="">T</h1>
                                </div>
                                <div
                                    class=" bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1">
                                    <h1 class="">Electricidad</h1>
                                </div>
                                <div
                                    class=" bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1">
                                    <h1 class="">Dirección</h1>
                                </div>
                            </div>

                            <div class=" flex flex-row items-center truncate w-full">
                                <div>
                                    <i class="fas fa-hammer mx-2"></i>
                                </div>
                                <div class="flex flex-col leading-none w-full flex-wrap">
                                    <h1 class="">CAMBIAR LOS BALEROS A LA BOMBA Y REPARAR OTRA COSA. </h1>
                                    <h1 class="tex-xs font-normal italic text-red-300">creado por: Eduardo Meneses</h1>

                                </div>
                            </div>
                        </div>
                        <!-- RESPONSABLE -->
                        <div data-target="modal-responsable" data-toggle="modal"
                            class="w-48 flex h-full items-center justify-center hover:shadow-md">
                            <h1>Eduardo Meneses</h1>
                        </div>
                        <!-- INICIO & FIN-->
                        <div class="w-64 flex h-full items-center justify-center hover:shadow-md">
                            <input
                                class="bg-white focus:outline-none focus:shadow-none py-2 px-4 block w-full appearance-none leading-normal font-semibold text-xs text-center"
                                type="text" type="text" name="datefilter" value="---" />
                        </div>
                        <!--  ADJUNTOS -->
                        <div data-target="modal-media" data-toggle="modal"
                            class="w-32 flex h-full items-center justify-center hover:shadow-md">
                            <h1 class="font-xs">8</h1>
                        </div>
                        <!--  COMENTARIOS -->
                        <div data-target="modal-comentarios" data-toggle="modal"
                            class="w-32 flex h-full items-center justify-center hover:shadow-md">
                            <h1>1</h1>
                        </div>
                        <!--  STATUS -->
                        <div data-target="modal-status" data-toggle="modal"
                            class="w-32 flex h-full items-center justify-center hover:shadow-md hover:bg-teal-200 text-teal-500 rounded-r-md">
                            <div><i class="fad fa-exclamation-circle fa-lg"></i></div>
                        </div>
                    </div>

                    <!-- equipo -->
                    <div
                        class="mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer">
                        <!-- FALLA -->
                        <div
                            class="w-full h-full flex flex-row items-center justify-between bg-red-100 text-red-500 rounded-l-md cursor-pointer hover:shadow-md border-l-4 border-red-200 relative">

                            <div class="absolute" style="left: -17px;">
                                <!-- AQUI QUITARIAS Y PONDRIAS LA SIRENA SI ES URGENTE O NO -->
                                <!-- <i class="fas fa-siren-on animated flash infinite fa-rotate-270" ></i> -->
                            </div>
                            <div class="absolute flex hover:opacity-25" style="right: 0%; font-size: 9px;">
                                <div
                                    class=" bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1">
                                    <h1 class="">M</h1>
                                </div>
                                <div
                                    class=" bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1">
                                    <h1 class="">T</h1>
                                </div>
                                <div
                                    class=" bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1">
                                    <h1 class="">Electricidad</h1>
                                </div>
                                <div
                                    class=" bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1">
                                    <h1 class="">Dirección</h1>
                                </div>
                            </div>

                            <div class=" flex flex-row items-center truncate w-full">
                                <div>
                                    <i class="fas fa-hammer mx-2"></i>
                                </div>
                                <div class="flex flex-col leading-none w-full flex-wrap">
                                    <h1 class="">CAMBIAR LOS BALEROS A LA BOMBA Y REPARAR OTRA COSA. </h1>
                                    <h1 class="tex-xs font-normal italic text-red-300">creado por: Eduardo Meneses</h1>

                                </div>
                            </div>
                        </div>
                        <!-- RESPONSABLE -->
                        <div data-target="modal-responsable" data-toggle="modal"
                            class="w-48 flex h-full items-center justify-center hover:shadow-md">
                            <h1>Eduardo Meneses</h1>
                        </div>
                        <!-- INICIO & FIN-->
                        <div class="w-64 flex h-full items-center justify-center hover:shadow-md">
                            <input
                                class="bg-white focus:outline-none focus:shadow-none py-2 px-4 block w-full appearance-none leading-normal font-semibold text-xs text-center"
                                type="text" type="text" name="datefilter" value="---" />
                        </div>
                        <!--  ADJUNTOS -->
                        <div data-target="modal-media" data-toggle="modal"
                            class="w-32 flex h-full items-center justify-center hover:shadow-md">
                            <h1 class="font-xs">8</h1>
                        </div>
                        <!--  COMENTARIOS -->
                        <div data-target="modal-comentarios" data-toggle="modal"
                            class="w-32 flex h-full items-center justify-center hover:shadow-md">
                            <h1>1</h1>
                        </div>
                        <!--  STATUS -->
                        <div data-target="modal-status" data-toggle="modal"
                            class="w-32 flex h-full items-center justify-center hover:shadow-md hover:bg-teal-200 text-teal-500 rounded-r-md">
                            <div><i class="fad fa-exclamation-circle fa-lg"></i></div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <!-- MODAL RESPONSABLE -->
    <div id="modal-responsable" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 370px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-responsable')"
                    class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                    <input
                        class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-full"
                        type="search" name="search" placeholder="Buscar...">
                </div>

                <div class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar"
                    style="height: 400px;">
                    <div
                        class="w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate">
                        <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                            width="20" height="20" alt="">
                        <h1 class="ml-2">Eduardo Meneses Denis</h1>
                        <p class="font-bold mx-1"> / </p>
                        <h1 class="font-normal text-xs">Coordinador MP América</h1>
                    </div>
                </div>


            </div>
        </div>
    </div>




    <!-- MODAL MEDIA -->
    <div id="modal-media" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-media')"
                    class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                    <button
                        class="py-2 px-3 w-full bg-teal-200 text-teal-500 font-bold text-sm rounded-md hover:shadow-md">
                        <i class="fad fa-cloud-upload fa-lg mr-2"></i>
                        ADJUNTAR ARCHIVOS
                    </button>
                </div>
                <div class="w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar">
                    <div class="font-bold divide-y">
                        <h1>IMÁGENES</h1>
                        <p> </p>
                    </div>
                    <div class="flex flex-row flex-wrap">
                        <a href="https://picsum.photos/id/237/200/300" target="_blank">
                            <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer"
                                style="background-image: url(https://picsum.photos/id/123/200/300)">
                            </div>
                        </a>

                        <a href="https://picsum.photos/id/123/200/300" target="_blank">
                            <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer"
                                style="background-image: url(https://picsum.photos/id/432/200/300)">
                            </div>
                        </a>

                        <a href="https://picsum.photos/id/234/200/300" target="_blank">
                            <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer"
                                style="background-image: url(https://picsum.photos/id/237/200/300)">
                            </div>
                        </a>

                        <a href="https://picsum.photos/id/322/200/300" target="_blank">
                            <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer"
                                style="background-image: url(https://picsum.photos/id/223/200/300)">
                            </div>
                        </a>

                        <a href="https://picsum.photos/id/443/200/300" target="_blank">
                            <div class="bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer"
                                style="background-image: url(https://picsum.photos/id/432/200/300)">
                            </div>
                        </a>
                    </div>
                    <div class="font-bold divide-y mb-4">
                        <h1>DOCUMENTOS</h1>
                        <p> </p>
                    </div>
                    <div class="flex flex-col">

                        <a href="https://picsum.photos/id/237/200/300" target="_blank">
                            <div
                                class="w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                                <i class="fad fa-file-alt fa-3x"></i>
                                <p class="text-sm font-normal ml-2">Lorem, ipsum dolor sit asdjasjdasd as da sd asd .pdf
                                </p>
                            </div>
                        </a>
                        <a href="https://picsum.photos/id/237/200/300" target="_blank">
                            <div
                                class="w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2">
                                <i class="fad fa-file-alt fa-3x"></i>
                                <p class="text-sm font-normal ml-2 truncate">Lsdfasdfasdf asdf asd fasdfasd fads f asdf
                                    a sdf asd f asdf saoremd as da sd asd .pdf</p>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL COMENTARIOS -->
    <div id="modal-comentarios" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-comentarios')"
                    class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                    <div class="flex justify-center items-center flex-col-reverse w-full">

                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>1 </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>2 </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>3 </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>4 </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>5 </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>6 </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>7 </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>xxxxxx </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>xxxxxx </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>xxxxxx </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>xxxxxx </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer">
                            <div class="flex items-center justify-center" style="width: 48px;">
                                <img src="https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses"
                                    width="48" height="48" alt="">
                            </div>
                            <div class="flex flex-col justify-start items-start p-2 w-full">
                                <div class="text-xs font-bold flex flex-row justify-between w-full">
                                    <div>
                                        <h1>Eduardo Rigoberto Meneses Denis</h1>
                                    </div>
                                    <div>
                                        <p class="font-mono ml-2 text-gray-600">14/11/20 11:12:33</p>
                                    </div>
                                </div>
                                <div class="text-xs w-full">
                                    <p>xxxxxx </p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="flex flex-row justify-center items-center w-full h-10 px-16 mt-4">
                    <input type="text" placeholder="    Añadir comentario"
                        class="h-full w-full rounded-l-md text-gray-600 font-medium border-2 border-r-0 focus:outline-none">
                    <button
                        class="py-2 h-full w-12 rounded-r-md bg-teal-200 text-teal-500 font-bold text-sm hover:shadow-md">
                        <i class="fad fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL STATUS   -->
    <div id="modal-status" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-status')"
                    class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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

                <div
                    class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-red-500 bg-gray-200 hover:bg-red-200 text-xs">
                    <div class="">
                        <h1>ES URGENTE</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <i class="fas fa-siren-on animated flash infinite"></i>
                    </div>
                </div>

                <div
                    class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs">
                    <div class="">
                        <h1>NO HAY MATERIAL</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>M</h1>
                    </div>
                </div>

                <div
                    class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-blue-500 bg-gray-200 hover:bg-blue-200 text-xs">
                    <div class="">
                        <h1>TRABAJANDO</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>T</h1>
                    </div>
                </div>



                <div id="statusenergeticos" onclick="expandir(this.id)"
                    class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                    <div class="">
                        <h1>ENERGETICOS</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>E</h1>
                    </div>
                </div>
                <div id="statusenergeticostoggle"
                    class="hidden w-full flex flex-row justify-center items-center text-sm px-2 flex-wrap">
                    <div
                        class="w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>ELECTRICIDAD</h1>
                        </div>
                    </div>
                    <div
                        class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>AGUA</h1>
                        </div>
                    </div>
                    <div
                        class="w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>DIESEL</h1>
                        </div>
                    </div>
                    <div
                        class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>GAS</h1>
                        </div>
                    </div>
                </div>


                <div id="statusdep" onclick="expandir(this.id)"
                    class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                    <div class="">
                        <h1>DEPARTAMENTO</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>D</h1>
                    </div>
                </div>
                <div id="statusdeptoggle"
                    class="hidden w-full flex flex-row justify-center items-center text-sm px-2 flex-wrap">
                    <div
                        class="w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>RRHH</h1>
                        </div>
                    </div>
                    <div
                        class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>CALIDAD</h1>
                        </div>
                    </div>
                    <div
                        class="w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>DIRECCION</h1>
                        </div>
                    </div>
                    <div
                        class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>FINANZAS</h1>
                        </div>
                    </div>
                </div>

                <div id="statusbitacora" onclick="expandir(this.id)"
                    class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                    <div class="">
                        <h1>BITACORA</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>B</h1>
                    </div>
                </div>
                <div id="statusbitacoratoggle"
                    class="hidden w-full flex flex-row justify-center items-center text-sm px-2">
                    <div
                        class="w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>GP</h1>
                        </div>
                    </div>
                    <div
                        class="w-full text-center h-8  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>TRS</h1>
                        </div>
                    </div>
                    <div
                        class="w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>ZI</h1>
                        </div>
                    </div>
                </div>
                <div
                    class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
                    <div class="">
                        <h1>SOLUCIONAR</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <i class="fas fa-check"></i>
                    </div>
                </div>

                <div class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs">
                    <div
                        class=" bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                        <div class="">
                            <i class="fas fa-pen fa-lg"></i>
                        </div>
                    </div>
                    <div
                        class=" bg-gray-200 w-full text-center h-8 cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                        <div class="">
                            <i class="fas fa-random fa-lg"></i>
                        </div>
                    </div>
                    <div
                        class=" bg-gray-200 w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                        <div class="">
                            <i class="fas fa-trash fa-lg"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modales -->


    <script src="../maphg-beta/js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/acordion.js"></script>
    <script src="js/calendarioBotones.js"></script>
    <script src="js/plannerBeta.js"></script>

    <script>
    function expandir(id) {
        idtoggle = id + 'toggle';
        var toggle = document.getElementById(idtoggle);
        toggle.classList.toggle("hidden");
    }

    function expandirpapa(idpapa) {
        var expandeapapa = document.getElementById(idpapa);
        expandeapapa.classList.toggle("h-40");
    }



    /* document.getElementById("abremodal").click();
    expandir("equipo123"); */
    </script>


    <script type="text/javascript">
    $(function() {

        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            showWeekNumbers: true,
            locale: {
                cancelLabel: 'Cancelar',
                applyLabel: "Aplicar",
                fromLabel: "De",
                toLabel: "A",
                customRangeLabel: "Personalizado",
                weekLabel: "S",
                daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto",
                    "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ],
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YY') + ' - ' + picker.endDate.format(
                'DD/MM/YY'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });
    </script>
</body>

</html>