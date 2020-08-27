<?php
include 'php/conexion.php';
session_start();
// Estas variables son Globales y nunca deben cambiar su valor, porque es la raiz de la session.
$destinoT = $_SESSION['idDestino'];
$usuario = $_SESSION['usuario'];

if ($destinoT == "" and $usuario == "") {
    header('Location: ../login.php');
}

// Variables Globales.
$arrayDestino = array(1 => "RM", 7 => "CMU", 2 => "PVR", 6 => "MBJ", 5 => "PUJ", 11 => "CAP", 3 => "SDQ", 4 => "SSA", 10 => "AME");
$idDestino = $_SESSION['idDestino'];

$queryNombre = "SELECT nombre, apellido FROM t_users 
INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
WHERE t_users.id = $usuario";
if ($resultNombre = mysqli_query($conn_2020, $queryNombre)) {
    if ($rowNombre = mysqli_fetch_array($resultNombre)) {
        $nombre = $rowNombre['nombre'];
        $apellido = $rowNombre['apellido'];
        $nombreUsuario = $nombre . " " . $apellido;
    }
} else {
    $nombreUsuario = "ND";
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sub Almacenes</title>
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/animate.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-300" style="font-family: 'Roboto', sans-serif;">

    <!-- Inputs Hidden para Guardar Información Temporal -->
    <input type="hidden" id="inputIdDestinoSeleccionado" value="<?= $destinoT; ?>">
    <input type="hidden" id="inputIdSubalmacenSeleccionado">
    <input type="hidden" id="inputIndexEntradaCarrito">
    <input type="hidden" id="inputIndexMovimientosCarrito">
    <input type="hidden" id="inputID">
    <input type="hidden" id="inputResultadosXLS">
    <div class="w-full">
        <?php
        include 'php/navbartop.php';
        include 'php/menu-sidebar.php';
        ?>
    </div>

    <div class="flex flex-col justify-evenly items-center w-full mt-8">
        <div class="container flex flex-col bg-gray-800 rounded-b-md z-10" style="border-top-left-radius: 1.3rem; border-top-right-radius: 1.3rem;">
            <div class="flex flex-row w-full m-3 items-center justify-start relative">
                <div class="mr-2 text-orange-500">
                    <i class="fad fa-box-alt fa-lg"></i>
                </div>
                <div class="font-medium text-xl text-gray-200">
                    <h1>Sub Almacenes & Bodegas</h1>
                </div>
                <div class="absolute right-0 mr-10">
                    <button data-target="modalBusquedaGeneral" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md" onclick="obtenerTodosItemsGlobales();"><i class="fas fa-search fa-lg mr-2"></i>Búsqueda
                        General</button>
                    <button data-target="modalInformes" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-chart-line fa-lg mr-2"></i>Informes</button>
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
                    <h1 id="faseSubalmacen" class="font-medium text-base text-gray-300"></h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1 id="nombreSubalmacen"></h1>
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
                                <a onclick="generarXLSItems('generalPorSubalmacen');" href="#" class="w-full p-2 hover:bg-gray-200 rounded-md mb-1 text-gray-900">Exportar Todo</a>
                                <a onclick="generarXLSItems('generalPorSubalmacenStock0');" href="#" class="w-full p-2 hover:bg-gray-200 rounded-md text-gray-900">Exportar stock 0</a>
                            </div>
                        </div>
                        <button onclick="movimientoExistenciasItems();" data-target="modalMoverItems" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-random fa-lg mr-2"></i>Traspasos</button>

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
        <div class="modal-window rounded-md pt-10" style="width: 1400px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalSalidasSubalmacen');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 id="faseSalidaSubalmacen" class="font-medium text-base text-gray-300">--</h1>
                </div>
                <div class="ml-4 font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-l-md">
                    <h1 id="nombreSalidaSubalmacen">--</h1>
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

                        <input id="inputPalabraBuscarSubalmacenSalida" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material" autocomplete="off">

                        <button onclick="toggleModalTailwind('modalCarritoSalidas'); recuperarCarrito();" class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar Salida
                        </button>

                        <button class=" button bg-orange-300 text-orange-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md" onclick="restablecerCarritoSalidasConfirmar() ;">
                            <i class="fas fa-redo mr-2 ga-lg"></i>Restablecer
                        </button>

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

                    <!-- Contenido -->
                    <div id="dataSalidasSubalmacen" class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 70vh;">
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
                <button onclick="toggleModalTailwind('modalCarritoSalidas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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


                    <div id="dataCarritoSalidas" class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 20vh;">
                    </div>

                    <div id="justifiacionSalidaCarrito" class="flex flex-col justify-center items-center w-full">
                        <div class="mb-3 w-full flex flex-row items-center justify-center">
                            <h1 class="text-lg font-light">Los materiales se emplearan en:</h1>
                        </div>
                        <div class="flex flex-row justify-center items-center w-full">
                            <div class="relative w-full">
                                <select id="carritoSalidaMotivo" onclick="carritoSalidaMotivo('opcionSeccion');" class="block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                    <option value="">Seleccione</option>
                                    <option value="MCE">MANTENIMIENTO CORRECTIVO (Equipos)</option>
                                    <option value="MP">MANTENIMIENTO PREVENTIVO</option>
                                    <option value="MCTG">MANTENIMIENTO CORRECTIVO (Tareas Generales)</option>
                                    <option value="GIFT">AVERIA DE GIFT</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                <div id="carritoSalidaSeccion"></div>
                                <div id="carritoSalidaSubseccion"></div>
                                <div id="carritoSalidaEquipo"></div>
                                <div id="carritoSalidaTG"></div>
                                <div id="carritoSalidaPendiente"></div>

                                <div id="opcionSalidaOtro" class="hidden">
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                                Motivo
                                            </label>
                                            <input id="inputJustificacionOtro" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Descripción del Motivo" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div id="opcionSalidaGift" class="hidden">
                                    <div class="flex flex-wrap -mx-3 mb-6">
                                        <div class="w-full px-3">
                                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-password">
                                                GIFT
                                            </label>
                                            <input id="giftSalida" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="number" placeholder="Digite el Número de GIFT" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2 mb-3" onclick="confirmarSalidaCarrito();">
                            <button id="confirmarSalidaCarrito" class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-check fa-lg mr-2"></i>Confirmar
                                Salida Carrito
                                <i id="spinnerConfirmarSalida" class="invisible text-3xl fas fa-spinner fa-spin absolute" style="margin-top:-24px;"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ENTRADAS -->
    <div id="modalSubalmacenEntradas" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalSubalmacenEntradas');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex justify-center items-center bg-gray-900 rounded-b-md w-16 h-10 shadow-xs">
                    <h1 class="font-medium text-base text-gray-300">
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
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">
                        <input id="inputPablabraBuscarEntradas" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material" autocomplete="off" onkeyup="if(event.keyCode == 13) entradasSubalmacen();">
                        <button data-target="modalConfirmacionEntradas" data-toggle="modal" class=" button bg-indigo-300 text-indigo-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md" onclick="consultaEntradaCarrito();"><i class="fas fa-check fa-lg mr-2"></i>Confirmar
                            Entrada</button>
                        <button class=" button bg-orange-300 text-orange-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md" onclick="restablecerCarritoEntradasConfirmar();">
                            <i class="fas fa-redo mr-2 ga-lg"></i>Restablecer
                        </button>

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
                        <div id="dataSubalmacenEntradas"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL MOVER ITEMS -->
    <div id="modalMoverItems" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalMoverItems')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                        <input id="inputBuscarMovimientos" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material" autocomplete="off" onkeyup="if(event.keyCode == 13) movimientoExistenciasItems();">
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
                <button onclick="toggleModalTailwind('modalConfirmarMovimiento');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                <button onclick="toggleModalTailwind('modalConfirmacionEntradas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                        <div id="dataCarritoEntradas"></div>
                    </div>
                    <div class="flex flex-col justify-center items-center w-full">

                        <div class="mt-2">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md" onclick="confirmarEntradaCarrito();"><i class="fas fa-check fa-lg mr-2"></i>Confirmar
                                Entrada</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL BUSQUEDA GENERAL -->
    <div id="modalBusquedaGeneral" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1500px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalBusquedaGeneral')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                        <input id="inputPalabraBuscarTodo" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" name="search" placeholder="Buscar material" onkeyup="if(event.keyCode == 13) obtenerTodosItemsGlobales();" autocomplete="off">
                        <div id="generalExistencia" onclick="expandir(this.id);" class="relative">
                            <button class=" button bg-green-300 text-green-700 py-2 px-4 rounded-md ml-2 font-medium text-xs hover:shadow-md"><i class="fas fa-file-excel fa-lg mr-2"></i>Exportar listado</button>
                            <div id="generalExistenciatoggle" class="absolute hidden mt-2 p-2 bg-white shadow-md border border-gray-200 w-full rounded-md divide-y divide-y-gray-200 text-xs font-medium text-center flex flex-col">
                                <a href="#" class="text-gray-900 w-full p-2 hover:bg-gray-400 rounded-md mb-1" onclick="generarXLSItems('generalPorDestino');">
                                    Exportar Todo
                                </a>
                                <a href="#" onclick="generarXLSItems('generarStock0');" class="text-gray-900 w-full p-2 hover:bg-gray-400 rounded-md">
                                    Exportar Stock 0
                                </a>
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


                    <div id="dataTodosItems" class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 70vh;">
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
            let idtoggle = id + 'toggle';
            let toggle = document.getElementById(idtoggle);
            // toggle.classList.toggle("hidden");
            $("#" + idtoggle).toggleClass('hidden');
        }
    </script>
</body>

</html>