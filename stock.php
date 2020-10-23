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

<body style="font-family: 'Source Sans Pro', sans-serif;" class="bg-orange-400 scrollbar">

    <!-- MENÚ -->
    <div class="w-full absolute top-0 relative">
        <?php
        include 'navbartopJS.php';
        include 'menuJS.php';
        ?>
    </div>
    <!-- MENÚ -->

    <!-- INICIA MODAL 100% -->
    <div class="w-full h-auto">

        <div class="flex justify-center items-center mb-5 relative pt-4">
            <div class="font-light text-3xl ml-3 leading-none text-orange-600 absolute left-0">
                <h1>Stock</h1>
            </div>
            <div class="relative text-gray-600 w-72">
                <input id="palabraMaterial" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Material" autocomplete="off">
                <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                    <i class="fad fa-search"></i>
                </button>
            </div>



            <div id="exportarStock" class="text-orange-400 text-sm cursor-pointer bg-orange-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-orange-200 px-2">
                <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                <h1>Exportar</h1>
            </div>
        </div>

        <div class="w-full h-auto">
            <div class="flex flex-col contenedor mx-auto scrollbar">
                <div class="-my-2 py-2 overflow-x-auto  scrollbar">
                    <div class="align-middle inline-block min-w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 scrollbar" style="max-height: 80vh;">
                        <table id="tablaStock" class="min-w-full divide-y divide-gray-200 table-fixed sortable">
                            <thead>
                                <tr class="cursor-pointer bg-white">

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Sección
                                    </th>
                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Área
                                    </th>
                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Descripción
                                    </th>
                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Marca
                                    </th>
                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Modelo
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Características
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Código
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Categoría
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Status
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Fecha
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Stock Real
                                    </th>

                                    <th class="px-1 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                        Stock Teórico
                                    </th>

                                </tr>
                            </thead>
                            <tbody id="contenedorDeMateriales" class="bg-white divide-y divide-gray-200">
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