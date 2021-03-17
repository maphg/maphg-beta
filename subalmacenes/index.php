<?php
include '../php/conexion.php';
session_start();
// Estas variables son Globales y nunca deben cambiar su valor, porque es la raiz de la session.
$destinoT = $_SESSION['idDestino'];
$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG SubAlmacenes</title>
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/tailwindproduccion.css">
    <link rel="stylesheet" href="../css/modales.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/alertify.min.css">
</head>

<body class="bg-gray-300 h-screen scrollbar" style="font-family: 'Roboto', sans-serif;">

    <!-- Inputs Hidden para Guardar Información Temporal -->
    <input type="hidden" id="inputIdDestinoSeleccionado" value="<?= $destinoT; ?>">
    <input type="hidden" id="inputIdSubalmacenSeleccionado">
    <input type="hidden" id="inputIndexEntradaCarrito">
    <input type="hidden" id="inputIndexMovimientosCarrito">
    <input type="hidden" id="inputID">
    <input type="hidden" id="inputResultadosXLS">

    <!-- MENÚ -->
    <menu-menu></menu-menu>
    <menu-sidebar clases="z-20"></menu-sidebar>

    <!-- CONFIGURACIONES SIDEBAR -->
    <configuracion-telegram></configuracion-telegram>
    <menu-notificaciones clases="h-screen"></menu-notificaciones>
    <menu-favoritos clases="h-screen"></menu-favoritos>
    <menu-telegram clases="h-screen"></menu-telegram>
    <menu-agenda clases="h-screen"></menu-agenda>
    <!-- MENÚ -->

    <div class="container mx-auto sm:pt-3">
        <div class="flex flex-col justify-evenly items-center w-full">
            <div class="container flex flex-col bg-gray-800 rounded-b-md z-10" style="border-top-left-radius: 1.3rem; border-top-right-radius: 1.3rem;">
                <div class="flex flex-row w-full m-3 items-center justify-start relative">
                    <div class="mr-2 text-orange-500">
                        <i class="fad fa-box-alt fa-lg"></i>
                    </div>
                    <div class="font-medium text-xl text-gray-200">
                        <h1>Sub Almacenes & Bodegas</h1>
                    </div>
                    <div class="absolute right-0 mr-10">
                        <button id="btnBusquedaGeneral" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-search fa-lg mr-2"></i>Búsqueda General</button>

                        <button class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-chart-line fa-lg mr-2"></i>Informes</button>
                    </div>
                </div>

                <div class="flex flex-col justify-start items-center w-full rounded-b-md bg-white p-3" style="border-top-left-radius: 1.3rem; border-top-right-radius: 1.3rem; height: 80vh;">

                    <div class="flex flex-col md:flex-row w-full">
                        <div class="w-full md:w-1/3 flex flex-col px-2 overflow-y-auto scrollbar" style="height: 77vh;">
                            <div class="text-center font-semibold text-gray-700 text-xl">
                                <h1>GP</h1>
                            </div>
                            <!-- Aquí se almacena la información obtenida.-->
                            <div id="subalmacenGP"></div>
                        </div>

                        <div class="w-full md:w-1/3 flex flex-col px-2 overflow-y-auto scrollbar" style="height: 77vh;">
                            <div class="text-center font-semibold text-gray-700 text-xl">
                                <h1>TRS</h1>
                            </div>
                            <div id="subalmacenTRS"></div>
                        </div>

                        <div class="w-full md:w-1/3 flex flex-col px-2 overflow-y-auto scrollbar" style="height: 77vh;">
                            <div class="text-center font-semibold text-gray-700 text-xl">
                                <h1>ZI</h1>
                            </div>
                            <div id="subalmacenZI"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALES ------------------------------------------------------------------- -->


    <!-- MODAL EXISTENCIAS -->
    <div id="modalExistenciasSubalmacen" class="modal">
        <div class="modal-window rounded-md relative" style="width: 1300px;">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalExistenciasSubalmacen')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-auto h-10 shadow-xs">
                    <h1 id="faseSubalmacen" class="font-medium text-base text-gray-300 px-1"></h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1 id="nombreSubalmacen"></h1>
                </div>

                <div class="font-bold bg-red-200 text-red-500 text-xs py-1 px-2 rounded-r-md">
                    <h1>EXISTENCIAS</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full pt-10">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-2">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input id="inputPalabraExistencias" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" placeholder="Buscar material" autocomplete="off">

                        <button class=" button bg-orange-300 text-orange-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-history mr-2 ga-lg"></i>Históricos</button>

                        <div id="exportarexis" onclick="expandir(this.id)" class="relative">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-file-excel fa-lg mr-2"></i>Exportar listado</button>
                            <div id="exportarexistoggle" class="absolute mt-2 hidden p-2 bg-white shadow-md border border-gray-200 w-full rounded-md divide-y divide-y-gray-200 text-xs font-medium text-center flex flex-col z-20">
                                <a onclick="generarXLSItems('subalmacen1');" href="#" class="w-full p-2 hover:bg-gray-200 rounded-md mb-1 text-gray-900">Exportar Todo</a>
                                <a onclick="generarXLSItems('subalmacen0');" href="#" class="w-full p-2 hover:bg-gray-200 rounded-md text-gray-900">Exportar stock 0</a>
                            </div>
                        </div>

                        <button onclick="movimientoExistenciasItems();" data-target="modalMoverItems" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-random fa-lg mr-2"></i>Traspasos</button>

                        <button id="btnModalAgregarItem" class="button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-plus fa-lg mr-2"></i>Agregar Item</button>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-col container mx-auto scrollbar">
                            <div class="py-2 overflow-x-auto relative scrollbar">
                                <div class="align-middle inline-block w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="height: 70vh;">
                                    <table class="w-full boder border-gray-200 divide-y divide-gray-200 table table-fixed sortable">
                                        <thead>
                                            <tr class="cursor-pointer bg-bluegray-50">
                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    CO2BEND
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    DESC. COD2BEND
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    DESC. SERV. TEC.
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SECCIÓN
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    ÁREA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    CATEGORÍA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                                    STOCK TEÓRICO
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                                    STOCK REAL
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    MARCA
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    MODELO
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-32">
                                                    CARACTERISTICAS
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SUBFAMILIA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-32">
                                                    SUBALMACÉN BODEGA
                                                </th>

                                                <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-8">

                                                </th>

                                            </tr>
                                        </thead>

                                        <!-- DATA -->
                                        <tbody id="dataSubalmacenExistencias" class="bg-white divide-y divide-gray-200">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- MODAL SALIDAS -->
    <div id="modalSalidasSubalmacen" class="modal">
        <div class="modal-window rounded-md" style="width: 1300px;">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalSalidasSubalmacen');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-auto h-10 shadow-xs">
                    <h1 id="faseSalidaSubalmacen" class="font-medium text-base text-gray-300 px-1">--</h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1 id="nombreSalidaSubalmacen">--</h1>
                </div>

                <div class="font-bold bg-yellow-300 text-yellow-600 text-xs py-1 px-2 rounded-r-md">
                    <h1>SALIDAS</h1>
                </div>
            </div>

            <div class="p-2 flex justify-center items-center flex-col w-full pt-10">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-2">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">

                        <input id="inputPalabraBuscarSalida" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" placeholder="Buscar material" autocomplete="off">

                        <button id="btnConsultaSalidaCarrito" class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Salida
                        </button>

                        <button id="btnRestablecerSalidas" class=" button bg-orange-300 text-orange-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md">
                            <i class="fas fa-redo mr-2 ga-lg"></i>Restablecer
                        </button>
                    </div>

                    <!-- CONTENIDO -->
                    <div class="w-full">
                        <div class="flex flex-col container mx-auto scrollbar">
                            <div class="py-2 overflow-x-auto relative scrollbar">
                                <div class="align-middle inline-block w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="height: 70vh;">
                                    <table class="w-full boder border-gray-200 divide-y divide-gray-200 table table-fixed sortable">
                                        <thead>
                                            <tr class="cursor-pointer bg-bluegray-50">
                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    CO2BEND
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    DESC. COD2BEND
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    DESC. SERV. TEC.
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SECCIÓN
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    ÁREA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    CATEGORÍA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                                    STOCK TEÓRICO
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                                    STOCK REAL
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    MARCA
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    MODELO
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-32">
                                                    CARACTERISTICAS
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SUBFAMILIA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SUBALMACÉN
                                                    BODEGA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-16">
                                                </th>

                                            </tr>
                                        </thead>

                                        <!-- DATA -->
                                        <tbody id="dataSalidasSubalmacen" class="bg-white divide-y divide-gray-200">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL JUSTIFICACION DE SALIDAS -->
    <div id="modalCarritoSalidas" class="modal">
        <div class="modal-window rounded-md pt-10 z-" style="width:600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalCarritoSalidas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">

                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-tl-md rounded-br-md">
                    <h1>JUSTIFICACIÓN</h1>
                </div>


            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <h1 class="text-lg font-light">Revise su solicitud y justifique la salida.</h1>
                    </div>
                    <!-- BUSCADOR -->
                    <!-- TITULOS -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>CANTIDAD</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>DESCRIPCION</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>CARACTERISTICAS</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>COSTE</h1>
                        </div>
                    </div>
                    <!-- TITULOS -->


                    <div id="dataCarritoSalidas" class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 30vh;">
                    </div>

                    <div id="justifiacionSalidaCarrito" class="flex flex-col justify-center items-center w-full">
                        <div class="mb-3 w-full flex flex-row items-center justify-center">
                            <h1 class="text-lg font-light">Los materiales se emplearan en:</h1>
                        </div>
                        <div class="flex flex-col justify-center items-center w-full py-1">

                            <!-- TIPO DE SALIDA -->
                            <select id="motivoSalidaCarrito" class="block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="">Seleccione el Tipo de Salida</option>
                                <option value="INCIDENCIA">INCIDENCIA </option>
                                <option value="INCIDENCIAGENERAL">INCIDENCIA GENERALE</option>
                                <option value="PREVENTIVO">MANTENIMIENTO PREVENTIVO</option>
                                <option value="GIFT">AVERIA DE GIFT</option>
                                <option value="OTRO">OTRO</option>
                            </select>

                            <!-- NUMERO OT -->
                            <div id="contendorOTSalida" class="hidden w-full mt-2">
                                <div class=" w-full mt-2">
                                    <label>Numero OT:</label>
                                    <input id="OTSalida" type="text" class="block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" autocomplete="off" placeholder="">
                                </div>

                                <div class="flex justify-center my-2">
                                    <button id="btnConfirmarSalidaCarrito" class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md">
                                        <i class="fas fa-check fa-lg mr-2"></i>Confirmar Salida
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL ENTRADAS -->
    <div id="modalSubalmacenEntradas" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1320px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalSubalmacenEntradas');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-auto h-10 shadow-xs">
                    <h1 class="font-medium text-base text-gray-300 px-1">
                        <div id="subalmacenEntradasFase"></div>
                    </h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1>
                        <div id="subalmacenEntradasTitulo"></div>
                    </h1>
                </div>

                <div class="font-bold bg-teal-300 text-teal-600 text-xs py-1 px-2 rounded-r-md">
                    <h1>Entradas</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input id="inputPablabraBuscarEntradas" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" placeholder="Buscar Material" autocomplete="off">

                        <button id="btnConsultaEntradaCarrito" class="button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md">
                            <i class="fas fa-check fa-lg mr-2"></i>Confirmar Entrada
                        </button>

                        <button id="btnRestablecerEntradas" class=" button bg-orange-300 text-orange-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md">
                            <i class="fas fa-redo mr-2 ga-lg"></i>Restablecer
                        </button>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-col container mx-auto scrollbar">
                            <div class="py-2 overflow-x-auto relative scrollbar">
                                <div class="align-middle inline-block w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="height: 70vh;">
                                    <table class="w-full boder border-gray-200 divide-y divide-gray-200 table table-fixed sortable">
                                        <thead>
                                            <tr class="cursor-pointer bg-bluegray-50">
                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    CO2BEND
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    DESC. COD2BEND
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    DESC. SERV. TEC.
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SECCIÓN
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    ÁREA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    CATEGORÍA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                                    STOCK TEÓRICO
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                                    STOCK REAL
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    MARCA
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    MODELO
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-32">
                                                    CARACTERISTICAS
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SUBFAMILIA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SUBALMACÉN
                                                    BODEGA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-16">
                                                </th>

                                            </tr>
                                        </thead>

                                        <!-- DATA -->
                                        <tbody id="dataSubalmacenEntradas" class="bg-white divide-y divide-gray-200">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL MOVER ITEMS -->
    <div id="modalMoverItems" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMoverItems')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-auto h-10 shadow-xs">
                    <h1 class="font-medium text-base text-gray-300 px-1"><i class="fas fa-random fa-lg"></i></h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1>MOVER ITEMS ENTRE ALMACENES & BODEGAS</h1>
                </div>

                <div class="font-bold bg-yellow-300 text-yellow-600 text-xs py-1 px-2 rounded-r-md">
                    <h1>TRASPASOS</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input id="inputBuscarMovimientos" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" placeholder="Buscar material" autocomplete="off" onkeyup="if(event.keyCode == 13) movimientoExistenciasItems();">
                        <button onclick="consultaMovimientoCarrito();" data-target="modalConfirmarMovimiento" data-toggle="modal" class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Movimiento</button>
                        <button class=" button bg-orange-300 text-orange-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-redo mr-2 ga-lg"></i>Restablecer</button>

                    </div>
                    <!-- BUSCADOR -->
                    <!-- TITULOS -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>CATEGORÍA</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>COD2BEND</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>GREMIO</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>DESCRIPCION</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>CARACTERISTICAS</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>MARCA/PROVEEDOR</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>STOCK TEÓRICO</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>STOCK ACTUAL</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>U DE M</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>CANTIDAD</h1>
                        </div>
                    </div>
                    <!-- TITULOS -->


                    <div id="dataMovimientos" class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 70vh;"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL modal-confirmar-movimiento -->
    <div id="modalConfirmarMovimiento" class="modal">
        <div class="modal-window rounded-md pt-10 z-" style="width:600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalConfirmarMovimiento');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">

                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-tl-md rounded-br-md">
                    <h1>MOVIMIENTO</h1>
                </div>


            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <h1 class="text-lg font-light">Revise su solicitud y confirme.</h1>
                    </div>
                    <!-- BUSCADOR -->
                    <!-- TITULOS -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>CANTIDAD</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>DESCRIPCION</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>CARACTERISTICAS</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>COSTE</h1>
                        </div>
                    </div>
                    <!-- TITULOS -->


                    <div id="dataMovimientosCarrito" class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 20vh;">
                    </div>

                    <div class="flex flex-col justify-center items-center w-full">
                        <div class="mb-3 w-full flex flex-row items-center justify-center">
                            <h1 class="text-lg font-light">Los materiales se moveran de:</h1>
                        </div>
                        <div class="flex flex-row justify-center items-center w-full mb-3">
                            <div class="relative w-full">
                                <h1 id="subalmacenSeleccionado" class="w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight font-bold text-center">
                                    BODEGA ACTUAL</h1>

                            </div>
                        </div>
                        <div class="mb-3 w-full flex flex-row items-center justify-center">
                            <h1 class="text-lg font-light">a la siguiente ubicación:</h1>
                        </div>
                        <div class="flex flex-row justify-center items-center w-full">
                            <div class="relative w-full">
                                <div id="opctionSubalmacenes"></div>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button id="btnFinalizarMovimiento" onclick="confirmarMovimientoCarrito();" class="invisible button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Movimiento</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- MODAL CONFIRMAR ENTRADA -->
    <div id="modalConfirmacionEntradas" class="modal">
        <div class="modal-window rounded-md pt-10 z-" style="width:600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalConfirmacionEntradas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-tl-md rounded-br-md">
                    <h1>ENTRADA DE MATERIAL</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <h1 class="text-lg font-light">Revise su solicitud y confirme</h1>
                    </div>
                    <!-- BUSCADOR -->

                    <!-- TITULOS -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>CANTIDAD</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>DESCRIPCIÓN</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>CARACTERISTICAS</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>COSTE</h1>
                        </div>
                    </div>
                    <!-- TITULOS -->

                    <div class="w-full border py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 30vh;">
                        <div id="dataCarritoEntradas"></div>
                    </div>

                    <div class="flex flex-col justify-center items-center w-full">
                        <div class="mt-2">
                            <button id="btnConfirmarEntrada" class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md">
                                <i class="fas fa-check fa-lg mr-2"></i>Confirmar Entrada</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL BUSQUEDA GENERAL -->
    <div id="modalBusquedaGeneral" class="modal">
        <div class="modal-window rounded-md relative" style="width: 1300px;">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalBusquedaGeneral')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-auto h-10 shadow-xs">
                    <h1 class="font-medium text-base text-gray-300 px-1"> <i class="fas fa-search fa-lg"></i> </h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1>TODOS LOS SUBALMACENES & BODEGAS</h1>
                </div>

                <div class="font-bold bg-red-200 text-red-500 text-xs py-1 px-2 rounded-r-md">
                    <h1>BUSQUEDA GENERAL</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full pt-10">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input id="inputPalabraBuscarTodo" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" placeholder="Buscar material" onkeyup="if(event.keyCode == 13) obtenerTodosItemsGlobales();" autocomplete="off">
                        <div id="generalExistencia" onclick="expandir(this.id);" class="relative">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-file-excel fa-lg mr-2"></i>Exportar listado</button>
                            <div id="generalExistenciatoggle" class="absolute hidden mt-2 p-2 bg-white shadow-md border border-gray-200 w-full rounded-md divide-y divide-y-gray-200 text-xs font-medium text-center flex flex-col z-20">
                                <a href="#" class="text-gray-900 w-full p-2 hover:bg-gray-400 rounded-md mb-1" onclick="generarXLSItems('destino1');">
                                    Exportar Todo
                                </a>
                                <a href="#" onclick="generarXLSItems('destino0');" class="text-gray-900 w-full p-2 hover:bg-gray-400 rounded-md">
                                    Exportar Stock 0
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="w-full">
                        <div class="flex flex-col container mx-auto scrollbar">
                            <div class="py-2 overflow-x-auto relative scrollbar">
                                <div class="align-middle inline-block w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="height: 70vh;">
                                    <table class="w-full boder border-gray-200 divide-y divide-gray-200 table table-fixed sortable">
                                        <thead>
                                            <tr class="cursor-pointer bg-bluegray-50">
                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    CO2BEND
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    DESC. COD2BEND
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    DESC. SERV. TEC.
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SECCIÓN
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    ÁREA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    CATEGORÍA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                                    STOCK TEÓRICO
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                                    STOCK REAL
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    MARCA
                                                </th>

                                                <th class=" px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    MODELO
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-32">
                                                    CARACTERISTICAS
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SUBFAMILIA
                                                </th>

                                                <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                                    SUBALMACÉN BODEGA
                                                </th>
                                            </tr>
                                        </thead>

                                        <!-- DATA -->
                                        <tbody id="dataTodosItems" class="bg-white divide-y divide-gray-200">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- MODAL CONFIRMAR ENTRADA -->
    <div id="modalAgregarItem" class="modal">
        <div class="modal-window rounded-md" style="width:400px;">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalAgregarItem')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-tl-md rounded-br-md">
                    <h1>Agregar Item</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="py-2 flex justify-center items-center flex-col w-full">
                <div class="mt-10 sm:mt-0 w-full">
                    <div class="pt-5 bg-white px-5">
                        <div class="grid grid-cols-6 gap-2">
                            <div class="col-span-6 sm:col-span-3">
                                <label class="text-xs font-semibold text-gray-700">COD2BEND</label>
                                <input id="cod2bendItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="text-xs font-semibold text-gray-700">SECCIÓN</label>
                                <select id="seccionItem" class="w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs"></select>
                            </div>

                            <div class="col-span-6">
                                <label class="text-xs font-semibold text-gray-700">DESCRIPCIÓN COD2BEND</label>
                                <input id="descripcionCod2bendItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                            <div class="col-span-6">
                                <label class="text-xs font-semibold text-gray-700">DESCRIPCIÓN SERVICIOS TECNICOS (SST)</label>
                                <input id="SSTItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                            <div class="col-span-6">
                                <label class="text-xs font-semibold text-gray-700">ÁREA</label>
                                <input id="areaItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                            <div class="col-span-6">
                                <label class="text-xs font-semibold text-gray-700">CATEGORÍA</label>
                                <input id="categoriaItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label class="text-xs font-semibold text-gray-700">STOCK TEÓRICO</label>
                                <input id="stockTeoricoItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label class="text-xs font-semibold text-gray-700">MARCA</label>
                                <input id="marcaItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="text-xs font-semibold text-gray-700">SUBFAMILIA</label>
                                <select id="subfamiliaItem" class="w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs">
                                    <option value="0">SELECCIONE</option>
                                    <option value="CONSUMIBLE">CONSUMIBLE</option>
                                    <option value="HERRAMIENTAS">HERRAMIENTAS</option>
                                    <option value="DESPIECE">DESPIECE</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="text-xs font-semibold text-gray-700">MODELO</label>
                                <input id="modeloItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                            <div class="col-span-6">
                                <label class="text-xs font-semibold text-gray-700">CARACTERÍSTICAS</label>
                                <input id="caracteristicasItem" type="text" autocomplete="off" class="focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:text-xs border border-blue-300 rounded-md py-1">
                            </div>

                        </div>
                    </div>

                    <div class="px-4 mt-4 bg-gray-50 sm:px-6 text-center">
                        <button id="btnAgregarItems" type="submit" class="inline-flex justify-center py-2 px-4 border-transparent shadow-sm text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            AGREGAR ITEM
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- SCRIPTS JS -->
    <script src="js/jquery-3.3.1.js" type="text/javascript"></script>
    <script src="../js/alertify.min.js" type="text/javascript"></script>
    <script src="../js/modales.js" type="text/javascript"></script>
    <script src="js/subalmacenJS.js" type="text/javascript"></script>
    <script src="../js/alertasSweet.js" type="text/javascript"></script>
    <script src="../js/sorttable.js"></script>
    <!-- SCRIPTS JS -->

    <!-- MENU JS -->
    <script src="../js/menu_sub.js"></script>
    <!-- MENU JS -->

    <script>
        function expandir(id) {
            let idtoggle = id + 'toggle';
            let toggle = document.getElementById(idtoggle);
            // toggle.classList.toggle("hidden");
            $("#" + idtoggle).toggleClass('hidden');
        }
    </script>
</body>

</html>