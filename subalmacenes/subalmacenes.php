<?php
include 'php/conexion.php';
session_start();
// Estas variables son Globales y nunca deben cambiar su valor, porque es la raiz de la session.
$destinoT = $_SESSION['idDestino'];
$usuario = $_SESSION['usuario'];
if (isset($_SESSION['usuario'])) {


    // Variables Globales.
    $arrayDestino = array(1 => "RM", 7 => "CMU", 2 => "PVR", 6 => "MBJ", 5 => "PUJ", 11 => "CAP", 3 => "SDQ", 4 => "SSA", 10 => "AME");
    $idDestino = $_SESSION['idDestino'];

    $queryNombre = "SELECT nombre, apellido FROM t_users INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id WHERE t_users.id = $usuario";
    if ($resultNombre = mysqli_query($conn_2020, $queryNombre)) {
        if ($rowNombre = mysqli_fetch_array($resultNombre)) {
            $nombre = $rowNombre['nombre'];
            $apellido = $rowNombre['apellido'];
            $nombreUsuario = $nombre . " " . $apellido;
        }
    } else {
        $nombreUsuario = "ND";
    }
} else {
    header('Location: ../login.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Almacenes</title>
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-300" style="font-family: 'Roboto', sans-serif;">
    <input type="hidden" id="inputIdDestinoSeleccionado" value="<?= $destinoT; ?>">

    <?php
    include 'php/navbartop.php';
    include 'php/menu-sidebar.php';
    ?>

    <!-- Inpus Temporales. -->

    <div class="flex flex-col justify-evenly items-center w-screen h-screen">
        <div class="container flex flex-col bg-gray-800 rounded-b-md z-10" style="border-top-left-radius: 1.3rem; border-top-right-radius: 1.3rem;">
            <div class="flex flex-row w-full m-3 items-center justify-start relative">
                <div class="mr-2 text-orange-500">
                    <i class="fad fa-box-alt fa-lg"></i>
                </div>
                <div class="font-medium text-xl text-gray-200">
                    <h1>Sub Almacenes & Bodegas</h1>
                </div>
                <div class="absolute right-0 mr-10">
                    <button data-target="modal-busqueda-general" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-search fa-lg mr-2"></i>Búsqueda General</button>
                    <button data-target="modal-informes" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-chart-line fa-lg mr-2"></i>Informes</button>
                </div>
            </div>

            <div class="flex flex-col justify-start items-center w-full rounded-b-md bg-white p-3" style="border-top-left-radius: 1.3rem; border-top-right-radius: 1.3rem; height: 80vh;">

                <div class="flex flex-col md:flex-row w-full">
                    <div class="w-full md:w-1/3 flex flex-col px-2 overflow-y-auto scrollbar" style="height: 77vh;">
                        <div class="text-center font-semibold text-gray-700 text-xl">
                            <h1>GP</h1>
                        </div>
                        <!-- SUBLAMACEN -->
                        <div id="1234567" onclick="expandir(this.id)" class="p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md">
                            <div>
                                <h1 class="truncate">xxxxxxxxxxxxxxxxxxxxxxxx </h1>
                            </div>
                            <div id="1234567toggle" class="hidden flex flex-row w-full mt-2 text-xs">
                                <div class="w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md">
                                    <h1 data-target="modal-entradas" data-toggle="modal"><i class="fad fa-arrow-to-right mr-2"></i>Entradas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700">
                                    <h1 data-target="modal-salidas" data-toggle="modal"><i class="fad fa-arrow-from-left fa-rotate-180 mr-2"></i>Salidas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md">
                                    <h1 data-target="modal-exitencias" data-toggle="modal"><i class="fad fa-list-ul mr-2"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- SUBLAMACEN -->

                        <!-- BODEGA -->
                        <div id="2334222" onclick="expandir(this.id)" class="p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md">
                            <div>
                                <h1 class="truncate">Bodega numero x234 </h1>
                            </div>
                            <div id="2334222toggle" class="hidden flex flex-row w-full mt-2 text-xs">
                                <div class="w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md">
                                    <h1><i class="fad fa-arrow-to-right mr-2"></i>Entradas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200">
                                    <h1><i class="fad fa-arrow-from-left fa-rotate-180 mr-2"></i>Salidas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md">
                                    <h1><i class="fad fa-list-ul mr-2"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- BODEGA -->

                        <!-- BODEGA -->
                        <div id="9876" onclick="expandir(this.id)" class="p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md">
                            <div>
                                <h1 class="truncate">Bodega numero 324234 </h1>
                            </div>
                            <div id="9876toggle" class="hidden flex flex-row w-full mt-2 text-xs">
                                <div class="w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md">
                                    <h1><i class="fad fa-arrow-to-right mr-2"></i>Entradas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200">
                                    <h1><i class="fad fa-arrow-from-left fa-rotate-180 mr-2"></i>Salidas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md">
                                    <h1><i class="fad fa-list-ul mr-2"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- BODEGA -->
                    </div>
                    <div class="w-full md:w-1/3 flex flex-col px-2 overflow-y-auto scrollbar">
                        <div class="text-center font-semibold text-gray-700 text-xl">
                            <h1>TRS</h1>
                        </div>
                        <!-- SUBLAMACEN -->
                        <div id="2322" onclick="expandir(this.id)" class="p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md">
                            <div>
                                <h1 class="truncate">Sub almacen numero 23 Lorem </h1>
                            </div>
                            <div id="2322toggle" class="hidden flex flex-row w-full mt-2 text-xs">
                                <div class="w-1/3 bg-gray-800 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md">
                                    <h1><i class="fad fa-arrow-to-right mr-2"></i>Entradas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-800 text-gray-100 py-1 hover:bg-gray-700">
                                    <h1><i class="fad fa-arrow-from-left fa-rotate-180 mr-2"></i>Salidas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-800 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md">
                                    <h1><i class="fad fa-list-ul mr-2"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- SUBLAMACEN -->
                    </div>
                    <div class="w-full md:w-1/3 flex flex-col px-2 overflow-y-auto scrollbar">
                        <div class="text-center font-semibold text-gray-700 text-xl">
                            <h1>ZI</h1>
                        </div>
                        <!-- SUBLAMACEN -->
                        <div id="23422" onclick="expandir(this.id)" class="p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md">
                            <div>
                                <h1 class="truncate">Sub almacen zi </h1>
                            </div>
                            <div id="23422toggle" class="hidden flex flex-row w-full mt-2 text-xs">
                                <div class="w-1/3 bg-gray-800 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md">
                                    <h1><i class="fad fa-arrow-to-right mr-2"></i>Entradas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-800 text-gray-100 py-1 hover:bg-gray-700">
                                    <h1><i class="fad fa-arrow-from-left fa-rotate-180 mr-2"></i>Salidas</h1>
                                </div>
                                <div class="w-1/3 bg-gray-800 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md">
                                    <h1><i class="fad fa-list-ul mr-2"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- SUBLAMACEN -->
                    </div>
                </div>

            </div>

        </div>


    </div>

    <!-- MODALES ------------------------------------------------------------------- -->

    <!-- grupo de compra 001(stock almacen) 002 (no almacenado se pide a compras)  -->


    <!-- MODAL EXISTENCIAS -->
    <div id="modal-exitencias" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-exitencias')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                        <input class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material">
                        <button class=" button bg-orange-300 text-orange-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-history mr-2 ga-lg"></i>Históricos</button>
                        <div id="exportarexis" onclick="expandir(this.id)" class="relative">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-file-excel fa-lg mr-2"></i>Exportar listado</button>
                            <div id="exportarexistoggle" class="absolute mt-2 hidden p-2 bg-white shadow-md border border-gray-200 w-full rounded-md divide-y divide-y-gray-200 text-xs font-medium text-center flex flex-col">
                                <a href="#" class="w-full p-2 hover:bg-gray-200 rounded-md mb-1">Exportar Todo</a>
                                <a href="#" class="w-full p-2 hover:bg-gray-200 rounded-md">Exportar stock 0</a>
                            </div>
                        </div>
                        <button data-target="modal-mover-items" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-random fa-lg mr-2"></i>Mover items</button>

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
                        </div>
                        <!-- ITEM -->
                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-red-500 bg-red-200 rounded hover:bg-indigo-100 cursor-pointer">
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
                                <h1>0</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <h1>PIEZA</h1>
                            </div>
                        </div>
                        <!-- ITEM -->
                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-yellow-700 bg-yellow-200 rounded hover:bg-indigo-100 cursor-pointer">
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
                                <h1>4</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <h1>PIEZA</h1>
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
                        </div>
                        <!-- ITEM -->
                    </div>







                </div>
            </div>
        </div>
    </div>


    <!-- MODAL SALIDAS -->
    <div id="modal-salidas" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1400px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-salidas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                            <div class="w-32 flex h-full items-center justify-center relative">
                                <input class="border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 px-2 rounded-r-md text-sm focus:outline-none w-full" type="number" name="cantidad" placeholder="#">
                                <button class="absolute rounded bg-red-300 text-red-500 h-6 w-6 flex items-center justify-center" style="right: 0%;">
                                    <i class="fas fa-plus fa-lg"></i>
                                </button>
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

    <!-- MODAL JUSTIFICACION DE SALIDAS -->
    <div id="modal-justificacion-salidas" class="modal">
        <div class="modal-window rounded-md pt-10 z-" style="width:600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-justificacion-salidas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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


                    <div class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 20vh;">
                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer">
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>20</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Tornillo de rosca corrida</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>media pulgada</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <h1>234234</h1>
                            </div>
                        </div>
                        <!-- ITEM -->

                    </div>

                    <div class="flex flex-col justify-center items-center w-full">
                        <div class="mb-3 w-full flex flex-row items-center justify-center">
                            <h1 class="text-lg font-light">Los materiales se emplearan en:</h1>
                        </div>
                        <div class="flex flex-row justify-center items-center w-full">
                            <div class="relative w-full">
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                    <option>MANTENIMIENTO PREVENTIVO</option>
                                    <option>MANTENIMIENTO CORRECTIVO</option>
                                    <option>AVERIA DE GIFT</option>
                                    <option>OTRO</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Salida</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ENTRADAS -->
    <div id="modal-entradas" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-entradas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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

                <div class="font-bold bg-teal-300 text-teal-600 text-xs py-1 px-2 rounded-r-md">
                    <h1>Entradas</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material">
                        <button data-target="modal-confirmacion-entradas" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Entrada</button>
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

    <!-- MODAL CONFIRMAR ENTRADA -->
    <div id="modal-confirmacion-entradas" class="modal">
        <div class="modal-window rounded-md pt-10 z-" style="width:600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-confirmacion-entradas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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


                    <div class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 20vh;">
                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer">
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>20</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Tornillo de rosca corrida</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>media pulgada</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <h1>234234</h1>
                            </div>
                        </div>
                        <!-- ITEM -->

                    </div>

                    <div class="flex flex-col justify-center items-center w-full">

                        <div class="mt-2">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Entrada</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BUSQUEDA GENERAL -->
    <div id="modal-busqueda-general" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-busqueda-general')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 class="font-medium text-base text-gray-300"> <i class="fas fa-search fa-lg"></i> </h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1>TODOS LOS SUBALMACENES & BODEGAS</h1>
                </div>

                <div class="font-bold bg-red-200 text-red-500 text-xs py-1 px-2 rounded-r-md">
                    <h1>BUSQUEDA GENERAL</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material">
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
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 text-center px-2">
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
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>UBICACIÓN</h1>
                        </div>
                    </div>
                    <!-- TITULOS -->


                    <div class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 70vh;">

                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer text-center">
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
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>PIEZA</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>SUB ALMACEN ZI</h1>
                            </div>
                        </div>
                        <!-- ITEM -->
                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer text-center">
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
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>PIEZA</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>SUB ALMACEN ZI</h1>
                            </div>
                        </div>
                        <!-- ITEM -->


                    </div>







                </div>
            </div>
        </div>
    </div>

    <!-- MODAL MOVER ITEMS -->
    <div id="modal-mover-items" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-mover-items')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 class="font-medium text-base text-gray-300"><i class="fas fa-random fa-lg"></i></h1>
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
                        <input class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material">
                        <button data-target="modal-confirmar-movimiento" data-toggle="modal" class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Movimiento</button>
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

    <!-- MODAL modal-confirmar-movimiento -->
    <div id="modal-confirmar-movimiento" class="modal">
        <div class="modal-window rounded-md pt-10 z-" style="width:600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modal-confirmar-movimiento')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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


                    <div class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 20vh;">
                        <!-- ITEM -->
                        <div class="mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer">
                            <div class="w-32 flex h-full items-center justify-center truncate">
                                <h1>20</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>Tornillo de rosca corrida</h1>
                            </div>
                            <div class="w-64 flex h-full items-center justify-center truncate">
                                <h1>media pulgada</h1>
                            </div>
                            <div class="w-32 flex h-full items-center justify-center">
                                <h1>234234</h1>
                            </div>
                        </div>
                        <!-- ITEM -->

                    </div>

                    <div class="flex flex-col justify-center items-center w-full">
                        <div class="mb-3 w-full flex flex-row items-center justify-center">
                            <h1 class="text-lg font-light">Los materiales se moveran de:</h1>
                        </div>
                        <div class="flex flex-row justify-center items-center w-full mb-3">
                            <div class="relative w-full">
                                <h1 class="w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight font-bold text-center">
                                    BODEGA ACTUAL</h1>

                            </div>
                        </div>
                        <div class="mb-3 w-full flex flex-row items-center justify-center">
                            <h1 class="text-lg font-light">a la siguiente ubicación:</h1>
                        </div>
                        <div class="flex flex-row justify-center items-center w-full">
                            <div class="relative w-full">
                                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                    <option>BODEGA 1</option>
                                    <option>BODEGA 2</option>
                                    <option>BODEGA 3</option>
                                    <option>BODEGA 4</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Movimiento</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL INFORMES -->
    <!-- MODALES ------------------------------------------------------------------- -->

    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/acordion.js"></script>
    <script src="js/subalmacenJS.js"></script>
    <script src="js/alertasSweet.js"></script>

    <script>
        function expandir(id) {
            let idtoggle = id + 'toggle';
            console.log(idtoggle);
            let toggle = document.getElementById(idtoggle);
            // toggle.classList.toggle("hidden");
            $("#" + idtoggle).toggleClass('hidden');
        }
    </script>
</body>

</html>