<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG Subcontratas Compras</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/animate.css">


</head>

<body class="bg-white scrollbar">
    <!-- MENÚ -->
    <div class="w-full absolute top-0">
        <?php
        include 'navbartopJS.php';
        include 'menuJS.php';
        ?>
    </div>
    <!-- MENÚ -->

    <div class="container-fluid mx-auto pt-16 bg-red-100">
        <div class="flex flex-col">

            <div id="contenedorPowerbi" class="">

                <!-- CAP -->
                <div id="powerbi_11" class="col-span-1 shadow rounded hidden">
                    <iframe class="my-iframe-all" width="100%" height="500px" src="" frameborder="0" allowFullScreen="true"></iframe>
                </div>

                <!-- RM -->
                <div id="powerbi_1" class="col-span-1 shadow rounded hidden">
                    <iframe class="my-iframe-all" width="100%" height="500px" src="" frameborder="0" allowFullScreen="true"></iframe>
                </div>

                <!-- CMU -->
                <div id="powerbi_7" class="col-span-1 shadow rounded hidden">
                    <iframe class="my-iframe-all" width="100%" height="500px" src="" frameborder="0" allowFullScreen="true"></iframe>
                </div>


                <!-- PVR -->
                <div id="powerbi_2" class="col-span-1 shadow rounded hidden">
                    <iframe class="my-iframe-all" width="100%" height="500px" src="" frameborder="0" allowFullScreen="true"></iframe>
                </div>

                <!-- MBJ -->
                <div id="powerbi_6" class="col-span-1 shadow rounded hidden">
                    <iframe class="my-iframe-all" width="100%" height="500px" src="" frameborder="0" allowFullScreen="true"></iframe>
                </div>

                <!-- PUJ -->
                <div id="powerbi_5" class="col-span-1 shadow rounded hidden">
                    <iframe class="my-iframe-all" width="100%" height="500px" src="" frameborder="0" allowFullScreen="true"></iframe>
                </div>

                <!-- SSA -->
                <div id="powerbi_4" class="col-span-1 shadow rounded hidden">
                    <iframe class="my-iframe-all" width="100%" height="500px" src="" frameborder="0" allowFullScreen="true"></iframe>
                </div>

                <!-- SDQ -->
                <div id="powerbi_3" class="col-span-1 shadow rounded hidden">
                    <iframe class="my-iframe-all" width="100%" height="500px" src="" frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>

            <div class="flex flex-row justify-center rounded mt-4 mb-1">
                <h1 id="opcionServicios" class="shadow mx-4 cursor-pointer hover:bg-gray-200 rounded p-2 text-center font-ls font-bold uppercase">
                    servicios</h1>
                <h1 id="opcionMateriales" class="shadow mx-4 cursor-pointer hover:bg-gray-200 rounded p-2 text-center font-ls font-bold uppercase">
                    materiales</h1>
            </div>
            <h1 id="load" class="text-center font-bold"> </h1>
            <div class="py-5 px-10">

                <div id="servicios" class="rounded hidden shadow">

                    <div class="mb-2 flex flex-row justify-end mt-2">
                        <div class="w-96 mt-1 relative rounded-md shadow-sm">
                            <input type="text" id="palabraServicios" class="block w-full pl-7 pr-12 focus:outline-none focus:ring focus:border-blue-300" placeholder="Buscar Por:">
                            <div class="absolute inset-y-0 right-0 flex items-center bg-gray-100 rounded">
                                <select id="columnaServicio" class="h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-600 sm:text-sm rounded-md">
                                    <option value="0">FECHA</option>
                                    <option value="1">CECO</option>
                                    <option value="2">ASIGNACIÓN</option>
                                    <option value="3">DESCRIPCIÓN</option>
                                    <option value="4">PROVEEDOR</option>
                                    <option value="5">IMPORTE</option>
                                    <option value="6">CUENTA</option>
                                </select>
                            </div>
                        </div>

                        <div id="btnExportarServicios" onclick="exportTableExcel('dataServicios', 'dataServicios', 'tablaServicios.xls')" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex
                        justify-center items-center mx-5 hover:bg-bluegray-200 p-2">
                            <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                            <h1>Exportar</h1>
                        </div>
                    </div>

                    <div class="w-full overflow-auto scrollbar shadow" style="max-height: 75vh;">
                        <table id="tablaServicios" class="min-w-full divide-y divide-gray-200 cursor-pointer border-b border-gray-200 sortable mx-auto
                        shadow-md sm:rounded-lg p-4">
                            <thead class="redounded uppercase">
                                <tr class="rounded">

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0 rounded-tl">
                                        fecha
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0 rounded-tr">
                                        ceco
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        asignación
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Descripción
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Proveedor AF
                                    </th>
                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        importe
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        cuenta mayor
                                    </th>

                                </tr>
                            </thead>

                            <tbody id="dataServicios" class="bg-white divide-y divide-gray-200 text-right"></tbody>

                        </table>
                    </div>
                </div>

                <div id="materiales" class="rounded hidden shadow">

                    <div class="mb-2 flex flex-row justify-end mt-2">
                        <div class="w-96 mt-1 relative rounded-md shadow-sm">
                            <input type="text" id="palabraMateriales" class="block w-full pl-7 pr-12 focus:outline-none focus:ring focus:border-blue-300" placeholder="Buscar Por:">
                            <div class="absolute inset-y-0 right-0 flex items-center bg-gray-100 rounded">
                                <select id="columnaMateriales" class="h-full py-0 pl-2 pr-7 border-transparent bg-transparent text-gray-600 sm:text-sm rounded-md">
                                    <option value="0">FECHA</option>
                                    <option value="1">CECO</option>
                                    <option value="2">ASIGNACIÓN</option>
                                    <option value="3">DESCRIPCIÓN</option>
                                    <option value="4">PROVEEDOR</option>
                                    <option value="5">IMPORTE</option>
                                    <option value="6">CUENTA</option>
                                </select>
                            </div>
                        </div>
                        <div id="btnExportarMateriales" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center mx-5 hover:bg-bluegray-200 px-2">
                            <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                            <h1>Exportar</h1>
                        </div>
                    </div>
                    <div class="w-full overflow-auto scrollbar shadow" style="max-height: 75vh;">
                        <table class="min-w-full divide-y divide-gray-200 cursor-pointer border-b border-gray-200 sortable mx-auto
                        shadow-md sm:rounded-lg p-4">
                            <thead class="redounded uppercase">
                                <tr class="rounded">

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0 rounded-tl">
                                        fecha
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0 rounded-tr">
                                        ceco
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        asignación
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Descripción
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Proveedor AF
                                    </th>
                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        importe
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4
                                font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        cuenta mayor
                                    </th>

                                </tr>
                            </thead>
                            <tbody id="dataMateriales" class="bg-white divide-y divide-gray-200 text-right">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>

<!-- JS PARA ALERTAS -->
<script src="js/alertify.min.js"></script>
<script src="js/alertasSweet.js"></script>
<!-- JS PARA ALERTAS -->

<!-- JS PARA TABLAS -->
<script src="js/sorttable.js"></script>
<script src="js/funciones_tablas.js"></script>
<!-- JS PARA TABLAS -->

<!-- JS MODULO -->
<script src="js/subcontratas_compras.js"></script>
<!-- JS MODULO -->

<!-- COMPLEMENTO MENU -->
<script src="js/complemento_menuJS.js"></script>
<!-- COMPLEMENTO MENU -->

</html>