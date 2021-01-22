<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG STOCK</title>
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/modales.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/alertify.min.css">

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

        @media (min-width: 1280px) {
            .contenedor {
                max-width: 1350px;
            }
        }
    </style>
</head>

<body style="font-family: 'Source Sans Pro', sans-serif;" class="scrollbar">

    <!-- MENÚ -->
    <div class="w-full absolute top-0 relative">
        <?php
        include 'navbartopJS.php';
        include 'menuJS.php';
        ?>
    </div>
    <!-- MENÚ -->


    <div class="w-full h-screen bg-white" style="height: calc(100% - 20px);">

        <div class="flex justify-center items-center relative py-8">
            <div class="font-light text-xl ml-3 leading-none text-bluegray-600 mr-8">
                <h1>Items
                    <span id="loadProyectos" class="text-center ml-4 text-2xl"></span>
                </h1>
            </div>

            <div class="relative text-gray-600 w-72">
                <input id="palabraItems" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Item" autocomplete="off">
                <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                    <i class="fad fa-search"></i>
                </button>
            </div>

            <div id="btnProyectos" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2 hidden">
                <i class="fas fa-list mr-1 font-normal text-xs"></i>
                <h1>Items</h1>
            </div>

            <div id="btnGantt" class="text-white text-sm cursor-pointer bg-bluegray-200 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-bluegray-200 px-2 hidden">
                <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                <h1>Gantt</h1>
            </div>

            <div id="btnPendientes" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2 hidden">
                <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                <h1>Pendientes</h1>
            </div>

            <div id="btnSolucionados" class="text-white text-sm cursor-pointer bg-bluegray-200 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-bluegray-200 px-2 hidden">
                <i class="fas fa-check mr-1 font-normal text-xs"></i>
                <h1>Solucionados</h1>
            </div>

            <div id="btnExportarItems" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2">
                <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                <h1>Exportar</h1>
            </div>
        </div>

        <div class="w-full h-auto">
            <div class="flex flex-col container mx-auto scrollbar">
                <div class="-my-2 py-2 overflow-x-auto relative scrollbar">
                    <div class="align-middle inline-block w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="max-height: 50vh;">

                        <table id="dataItems" class="w-full divide-y divide-gray-200 table table-fixed sortable">
                            <thead>
                                <tr class="cursor-pointer bg-bluegray-50">
                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        DESTINO
                                    </th>
                                    <th class=" px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        COD2BEND
                                    </th>

                                    <th class=" px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        DESC. 2BEND
                                    </th>
                                    <th class=" px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        DESC. SSTT
                                    </th>
                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        SECCIÓN
                                    </th>
                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        ÁREA
                                    </th>

                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        CATEGORIA
                                    </th>

                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        STOCK T
                                    </th>

                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        STOCK R
                                    </th>

                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        MARCA
                                    </th>

                                    <th class=" px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        MODELO
                                    </th>

                                    <th class=" px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        CARACT.
                                    </th>

                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        SUBFAMILIA
                                    </th>

                                    <th class="px-2 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        SUBALMACÉN
                                    </th>

                                </tr>
                            </thead>
                            <tbody id="contenedorDeItems" class="bg-white divide-y divide-gray-200">
                                <!-- More rows... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <script src="js/complemento_menuJS.js"></script>
    <script src="js/funciones_tablas.js"></script>
    <script src="js/sorttable.js"></script>
    <script src="js/seguridad_session.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/stock.js"></script>
</body>

</html>