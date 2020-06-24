<?php
include 'php/conexion.php';
session_start();
// Estas variables son Globales y nunca deben cambiar su valor, porque es la raiz de la session.
$destinoT = $_SESSION['idDestino'];
$usuario = $_SESSION['usuario'];

// Variables Globales.
$arrayDestino = array(1 => "RM", 7 => "CMU", 2 => "PVR", 6 => "MBJ", 5 => "PUJ", 11 => "CAP", 3 => "SDQ", 4 => "SSA", 10 => "AME");
$idDestino = $_SESSION['idDestino'];


$nombreUsuario = "Eduardo";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Almacenes</title>
    <link rel="stylesheet" href="../css/tailwind.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/animate.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-300" style="font-family: 'Roboto', sans-serif;">

    <!-- Inputs Hidden para Guardar Información Temporal -->
    <input type="hidden" id="inputIdDestinoSeleccionado" value="<?= $destinoT; ?>">
    <input type="hidden" id="inputIdSubalmacenSeleccionado">

    <div class="container flex flex-col z-20 relative items-center">
        <div class="flex flex-row w-full items-center">
            <?php
            include 'php/navbartop.php';
            include 'php/menu-sidebar.php';
            ?>
        </div>
    </div>

    <div class="flex flex-col justify-evenly items-center  px-4 mt-5">
        <div class="container flex flex-col bg-gray-800 rounded-b-md z-10 relative" style="border-top-left-radius: 1.3rem; border-top-right-radius: 1.3rem;">
            <img src="img/export.jpg" class="absolute bottom-0 right-0 opacity-25 w-64 m-2" alt="">

            <div class="flex flex-row w-full m-3 items-center">
                <div class="mr-2 text-orange-500">
                    <i class="fad fa-box-alt fa-lg"></i>
                </div>
                <div class="font-medium text-xl text-gray-200">
                    <h1>Sub Almacenes & Bodegas</h1>
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

                    <div class="w-full md:w-1/3 flex flex-col px-2 overflow-y-auto scrollbar">
                        <div class="text-center font-semibold text-gray-700 text-xl">
                            <h1>TRS</h1>
                        </div>
                        <div id="subalmacenTRS"></div>
                    </div>

                    <div class="w-full md:w-1/3 flex flex-col px-2 overflow-y-auto scrollbar">
                        <div class="text-center font-semibold text-gray-700 text-xl">
                            <h1>ZI</h1>
                        </div>
                        <div id="subalmacenZI"></div>
                    </div>
                </div>

            </div>

        </div>


    </div>

    <!-- MODALES ------------------------------------------------------------------- -->
    <!-- MODAL EXISTENCIAS -->
    <div id="modalExistenciasSubalmacen" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalExistenciasSubalmacen')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 class="font-medium text-base text-gray-300">ZI</h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1>SUB ALMACEN ZONA INDUSTRIAL</h1>
                </div>

                <div class="font-bold bg-red-200 text-red-500 text-xs py-1 px-2 rounded-r-md">
                    <h1>EXISTENCIAS</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input id="inputPalabraBuscarSubalmacen" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material" onkeyup="if(event.keyCode == 13) busquedaExisenciaSubalmacen();" autocomplete="off" pattern="[A-Za-z0-9]{1,15}">
                        <button class=" button bg-orange-300 text-orange-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-history mr-2 ga-lg"></i>Históricos</button>
                        <div id="exportarexis" onclick="expandir(this.id)" class="relative">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-file-excel fa-lg mr-2"></i>Exportar listado</button>
                            <div id="exportarexistoggle" class="absolute mt-2 hidden p-2 bg-white shadow-md border border-gray-200 w-full rounded-md divide-y divide-y-gray-200 text-xs font-medium text-center flex flex-col">
                                <a href="#" class="w-full p-2 hover:bg-gray-200 rounded-md mb-1">Exportar Todo</a>
                                <a href="#" class="w-full p-2 hover:bg-gray-200 rounded-md">Exportar stock 0</a>
                            </div>
                        </div>

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
                    </div>
                    <!-- TITULOS -->

                    <!-- Contenido -->
                    <div class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 70vh;">
                        <div id="dataExistenciasSubalmacen"></div>
                    </div>
                    <!-- Fin Contenido -->
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL SALIDAS -->
    <div id="modalSalidasSubalmacen" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalSalidasSubalmacen')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 class="font-medium text-base text-gray-300">ZI</h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1>SUB ALMACEN ZONA INDUSTRIAL</h1>
                </div>

                <div class="font-bold bg-yellow-300 text-yellow-600 text-xs py-1 px-2 rounded-r-md">
                    <h1>SALIDAS</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material">
                        <button data-target="modal-justificacion-salidas" data-toggle="modal" class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Salida</button>
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


                    <div class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 70vh;">

                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer">
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>Herramienta</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>234234</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>Alañileria</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Tornillo de rosca corrida</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>media pulgada</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Proveedora de tornillos SA</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>22</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>34</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <h1>PIEZA</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <input class="border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 px-2 rounded-r-md text-sm focus:outline-none w-full" type="number" name="cantidad" placeholder="#">
                            </div>
                        </div>
                        <!-- ITEM -->

                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer">
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>Herramienta</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>234234</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>Alañileria</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Tornillo de rosca corrida</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>media pulgada</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Proveedora de tornillos SA</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>22</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>34</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <h1>PIEZA</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <input class="border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 px-2 rounded-r-md text-sm focus:outline-none w-full" type="number" name="cantidad" placeholder="#">
                            </div>
                        </div>
                        <!-- ITEM -->

                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer">
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>Herramienta</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>234234</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>Alañileria</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Tornillo de rosca corrida</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>media pulgada</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Proveedora de tornillos SA</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>22</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>34</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <h1>PIEZA</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <input class="border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 px-2 rounded-r-md text-sm focus:outline-none w-full" type="number" name="cantidad" placeholder="#">
                            </div>
                        </div>
                        <!-- ITEM -->

                    </div>







                </div>
            </div>
        </div>
    </div>

    <!-- MODALES ------------------------------------------------------------------- -->



    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/acordion.js"></script>
    <script src="js/subalmacenJS.js"></script>
    <script src="js/alertasSweet.js"></script>

    <script>
        function expandir(id) {
            idtoggle = id + 'toggle';
            var toggle = document.getElementById(idtoggle);
            toggle.classList.toggle("hidden");
        }
    </script>
</body>

</html>