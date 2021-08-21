<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG Pedidos</title>
    <link rel="stylesheet" href="css/tailwindproduccion_2021.css">
    <link rel="shortcut icon" href="svg/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/alertify.min.css">
</head>

<body class="bg-gray-100 w-full h-screen">
    <!-- MENÚ -->
    <menu-menu></menu-menu>
    <menu-sidebar clases="z-20 sticky top-0 shadow-sm"></menu-sidebar>

    <!-- CONFIGURACIONES SIDEBAR -->
    <configuracion-telegram></configuracion-telegram>
    <menu-notificaciones clases="h-screen"></menu-notificaciones>
    <menu-favoritos clases="h-screen"></menu-favoritos>
    <menu-telegram clases="h-screen"></menu-telegram>
    <menu-agenda clases="h-screen"></menu-agenda>
    <!-- MENÚ -->

    <div class="w-full mt-5">
        <div class="flex flex-row items-center justify-center uppercase text-gray-400 font-semibold">
            <div id="btnSolicitudes" class="hover:text-gray-700 border-b border-gray-400 hover:border-gray-900 mx-5 px-2 cursor-pointer">Solicitudes 2BEND</div>
            <div id="btnCompras" class="hover:text-gray-700 border-b border-gray-400 hover:border-gray-900 mx-5 px-2 cursor-pointer">Pedidos sin orden de compra</div>
            <div id="btnEntregasNo" class="hover:text-gray-700 border-b border-gray-400 hover:border-gray-900 mx-5 px-2 cursor-pointer">Pedidos pendientes de entregar</div>
            <div id="btnEntragasSi" class="hover:text-gray-700 border-b border-gray-400 hover:border-gray-900 mx-2 px-2 cursor-pointer">Pedidos Entregados</div>
        </div>

        <div class="w-full mt-8">
            <p id="fechaActualizacion" class="text-right container py-1 text-gray-400"></p>

            <div id="contenedorSolicitudes" class="hidden container mx-auto">
                <div class="flex justify-end items-center relative pb-2">
                    <div class="flex flex-row justify-center items-center font-semibold text-xl ml-3 leading-none text-bluegray-600 mr-8">
                        <h1>ITEMS</h1>
                        <span id="loadSolicitudes" class="text-center ml-4 text-2xl"></span>
                    </div>

                    <div class="relative text-gray-600 w-72">
                        <input id="palabraSolicitudes" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Número 2BEND" autocomplete="off">
                        <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                            <i class="fad fa-search"></i>
                        </button>
                    </div>

                    <div id="btnExportarSolicitudes" class="hidden text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2">
                        <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                        <h1>Exportar</h1>
                    </div>
                </div>

                <div class="flex items-center justify-center py-2 overflow-x-auto relative scrollbar">
                    <div class="shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="height: 58vh;">
                        <table class="table table-fixed ring ring-gray-200 divide-y divide-gray-200 sortable">
                            <thead>
                                <tr class="cursor-pointer bg-bluegray-50">
                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-20">
                                        DESTINO
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                        NÚMERO 2BEND
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-64">
                                        NOMBRE
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                        COSTE
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-32">
                                        ESTADO
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                        FECHA
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                        PERÍODO DE
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                        PERÍODO A
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-40">
                                        HOTEL
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-48">
                                        CENTRO COSTE
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                        SOLICITUD SAP
                                    </th>

                                </tr>
                            </thead>

                            <!-- DATA -->
                            <tbody id="dataSolicitudes" class="bg-white divide-y divide-gray-200 px-2 border-b border-gray-200 text-left py-2 font-semibold"></tbody>

                            <footer>
                                <tr class="cursor-pointer bg-bluegray-50">
                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 flex flex-col items-center justify-center">
                                        <select id="destinoSolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="numero2bendSolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="nombreSolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="costeSolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="estadoSolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="fechaSolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-1 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="pedriodoDESolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="periodoASolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="hotelSolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="centroCosteSolicitudes" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10">
                                        <select id="solicitudSapSolicitudes" class="w-full"></select>
                                    </th>

                                </tr>
                            </footer>
                        </table>
                    </div>
                </div>
            </div>

            <div id="contenedorCompras" class="hidden">
                <div class="flex justify-end items-center relative pb-2 mx-auto container">
                    <div class="flex flex-row justify-center items-center font-semibold text-xl ml-3 leading-none text-bluegray-600 mr-8">
                        <h1>ITEMS</h1>
                        <span id="loadCompras" class="text-center ml-4 text-2xl"></span>
                    </div>

                    <div class="relative text-gray-600 w-72">
                        <input id="palabraCompras" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar CECO" autocomplete="off">
                        <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                            <i class="fad fa-search"></i>
                        </button>
                    </div>

                    <div id="btnExportarCompras" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2">
                        <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                        <h1>Exportar</h1>
                    </div>
                </div>

                <div class="flex flex-col container mx-auto scrollbar">
                    <div class="py-2 overflow-x-auto relative scrollbar">
                        <div class="align-middle inline-block w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="height: 70vh;">
                            <table id="tableCompras" class="w-full ring ring-gray-200 divide-y divide-gray-200 table table-fixed sortable">
                                <thead>
                                    <tr class="cursor-pointer bg-bluegray-50">
                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-40">
                                            CECO
                                        </th>

                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-16">
                                            <i class="fas fa-hashtag mx-1"></i>
                                            SOLICITUD
                                        </th>

                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12" data-type="date" data-format="DD/MM/YYYY">
                                            Fecha Solicitud
                                        </th>

                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                            Material
                                        </th>

                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-40">
                                            Descripción Material
                                        </th>

                                        <th class="px-1 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                            Cantidad Solicitada
                                        </th>

                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                            Unidad Madida
                                        </th>

                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                            Grupo Compras
                                        </th>

                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                            Sección
                                        </th>

                                        <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-14">
                                            Solicitud Borrada
                                        </th>

                                    </tr>
                                </thead>

                                <!-- DATA -->
                                <tbody id="dataCompras" class="bg-white divide-y divide-gray-200"></tbody>
                                <footer>
                                    <tr class="cursor-pointer bg-bluegray-50">
                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full flex flex-col items-center justify-center">
                                            <select id="cecoCompras" class="w-full"></select>
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="solicitudCompras" class="w-full"></select>

                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="fechaCompras" class="w-full"></select>
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="materialCompras" class="w-full"></select>
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="materialDescipcionCompras" class="w-full"></select>
                                        </th>

                                        <th class="px-1 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="cantidadCompras" class="w-full"></select>
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="unidadCompras" class="w-full"></select>
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="grupoCompras" class="w-full"></select>
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="seccionCompras" class="w-full"></select>
                                        </th>

                                        <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                            <select id="borradaCompras" class="w-full"></select>
                                        </th>
                                    </tr>
                                </footer>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div id="contenedorEntregas" class="hidden container mx-auto">
                <div class="flex justify-end items-center relative pb-2">
                    <div class="flex flex-row justify-center items-center font-semibold text-xl ml-3 leading-none text-bluegray-600 mr-8">
                        <h1>ITEMS</h1>
                        <span id="loadEntregas" class="text-center ml-4 text-2xl"></span>
                    </div>

                    <div class="relative text-gray-600 w-72">
                        <input id="palabraEntregas" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar CECO" autocomplete="off">
                        <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                            <i class="fad fa-search"></i>
                        </button>
                    </div>

                    <div id="btnExportarEntregas" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2">
                        <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                        <h1>Exportar</h1>
                    </div>
                </div>
                <div class="py-2 overflow-x-auto relative scrollbar">
                    <div class="align-middle inline-block shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="height: 58vh;">
                        <table id="tableEntregas" class="ring ring-gray-200 divide-y divide-gray-200 table table-fixed sortable">
                            <thead>
                                <tr class="cursor-pointer bg-bluegray-50">
                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-40">
                                        CECO
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-16">
                                        <i class="fas fa-hashtag mx-1"></i>
                                        SOLICITUD
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12" data-type="date" data-format="DD/MM/YYYY">
                                        Fecha Solicitud
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                        Documento Compras
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12" data-type="date" data-format="DD/MM/YYYY">
                                        Fecha Entrega
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12" data-type="date" data-format="DD/MM/YYYY">
                                        Fecha Documento
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                        Proveedor
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-24">
                                        Material
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-40">
                                        Descripción Material
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                        Cantidad Solicitada SS.TT.
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                        Cantidad Por Entregar
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                        Tipo
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                        Valor USD
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 w-12">
                                        Sección
                                    </th>

                                </tr>
                            </thead>

                            <!-- DATA -->
                            <tbody id="dataEntregas" class="bg-white divide-y divide-gray-200"></tbody>

                            <footer>
                                <tr class="cursor-pointer bg-bluegray-50">
                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full flex flex-col items-center justify-center">
                                        <select id="cecoEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="solicitudEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="fechaEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="documentoEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="fechaEntregEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="fechaDocEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-1 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="proveedorEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="materialEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="descripcionMaterialEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="cantidadEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="porEntregarEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="tipoEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="valorEntregas" class="w-full"></select>
                                    </th>

                                    <th class="px-2 py-1 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky bottom-0 z-10 w-full">
                                        <select id="seccionEntregas" class="w-full"></select>
                                    </th>
                                </tr>
                            </footer>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL Exportar Secciones Usuarios -->
    <div id="modalDetalles" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalDetalles');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>Detalles</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6 text-gray-500">
                <div>
                    <p class="text-lg uppercase font-bold text-center">SOLICITUDES 2BEND</p>
                </div>

                <div class="w-full flex flex-col items-start justify-start px-12 my-5 text-gray-500">
                    <h1 class="flex flex-row font-semibold">
                        DESTINO: <p id="destinoDetalle" class="ml-2 text-gray-400 font-normal"></p>
                    </h1>
                    <h1 class="flex flex-row font-semibold">
                        NOMBRE CECO: <p id="nombreCecoDetalle" class="ml-2 text-gray-400 font-normal"></p>
                    </h1>

                    <h1 class="flex flex-row font-semibold">
                        SOLICITUD 2BEND: <p id="solicitud2bendDetalle" class="ml-2 text-gray-400 font-normal"></p>
                    </h1>
                    <h1 class="flex flex-row font-semibold">
                        FECHA SOLICITUDE 2BEND: <p id="fechaDetalle" class="ml-2 text-gray-400 font-normal"></p>
                    </h1>
                </div>

                <div class="w-full flex items-center justify-center py-2 px-1 overflow-x-auto relative scrollbar">
                    <div class="shadow-md overflow-auto sm:rounded-lg ring-b ring-gray-200 relative scrollbar" style="height: 58vh;">
                        <table class="table table-auto border border-gray-200 divide-y divide-gray-200 sortable">
                            <thead>
                                <tr class="cursor-pointer bg-bluegray-50 text-xs font-medium text-gray-500 uppercase border-b border-gray-200">
                                    <th class="px-2 py-2 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        SOLICITUD PEDIDO
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center sticky top-0 z-10 w-auto">
                                        FECHA SOLICITUD
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        DOCUMENTO COMPRAS
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        FECHA DOCUMENTO
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        FECHA ENTREGA
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        PROVEEDOR
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        MATERIAL
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        DESCRIPCIÓN MATERIAL
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        CANTIDAD SOLICITADA
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        CANTIDAD POR ENTREGAR
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        VALOR USD
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        GRUPO COMPRAS
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        SECCIÓN
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        ESTATUS LIBERACIÓN
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        SOLICITUD BORRADA
                                    </th>

                                    <th class="px-2 py-2 border-b border-gray-200 bg-gray-200 text-center leading-4 sticky top-0 z-10 w-auto">
                                        TIPO
                                    </th>

                                </tr>
                            </thead>

                            <!-- DATA -->
                            <tbody id="dataSolicitudes2bend" class="bg-white divide-y divide-gray-200 px-2 border-b border-gray-200 text-left py-2 font-normal text-xs">
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/sorttable.js" type="text/javascript"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script src="js/menu.js"></script>
    <script src="js/funciones_tablas.js"></script>
    <script src="js/pedidos.js"></script>
</body>

</html>