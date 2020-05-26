<?php

$usuario = "Invitado CAP";
$idDestino = 11;

$array_destino = array(10 => "AME", 1 => "RM", 2 => "PVR", 3 => "SDQ", 4 => "SSA", 5 => "PUJ", 6 => "MBJ", 7 => "CMU", 11 => "CAP");

include 'php/conexion.php';
date_default_timezone_set('America/Cancun');

// fecha de las Bitacoras, segun el día seleccionado por ejemplo 2020-12-30 00:00:00 rango Inicial- 2020-12-30 04:00:00 Rango Final- 2020-12-31 04:00:00
// Variable para fecha Dinamica.
$fecha = date("Y-m-d");
// $fecha = "2020-04-27";

$fecha_seleccionada = new DateTime($fecha);

$fecha_inicial = $fecha_seleccionada->add(new DateInterval('PT4H01S'));
$fecha_inicial = $fecha_inicial->format('Y-m-d H:i:s');

$fecha_final = $fecha_seleccionada->add(new DateInterval('PT24H01S'));
$fecha_final = $fecha_final->format('Y-m-d H:i:s');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bitacora</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/app.css">
</head>
<style>
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        display: none;
        overflow: auto;
        background-color: #000000;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 9999;
    }

    .modal-window {
        position: relative;
        background-color: #FFFFFF;
        margin: 10% auto;
        padding: 20px;
    }

    .modal-window.small {
        width: 30%;
    }

    .modal-window.large {
        width: 75%;
    }

    .close {
        position: absolute;
        top: 0;
        right: 0;
        color: rgba(0, 0, 0, 0.3);
        height: 30px;
        width: 30px;
        font-size: 30px;
        line-height: 30px;
        text-align: center;
    }

    .close:hover,
    .close:focus {
        color: #000000;
        cursor: pointer;
    }

    .open {
        display: block;
    }

    [x-cloak] {
        display: none;
    }
</style>

<body class="bg-gray-300" style="font-family: 'Manrope', sans-serif;">
    <!-- Inputs ocultos para Guardar información Común -->

    <div class="flex flex-col flex-wrap justify-start items-center">
        <!-- ---------------- SECCION 1 TITULO Y SELECTORES ---------------- -->
        <div class="w-full flex flex-row justify-center flex-wrap">
            <!-- CONTENEDOR WIDGETS DE SECCION -->
            <div class="flex flex-row justify-center items-center w-full mt-4">
                <!-- ESPACIO DEL WIDGET -->
                <h1 class="text-2xl font-light text-gray-700 text-center">Bitácora Diaria de <strong class=" font-semibold">Mantenimiento</strong></h1>
            </div>
            <!-- ESPACIO DEL WIDGET -->

            <div class="flex flex-row justify-center items-center w-auto mt-2 mx-2">
                <div class="inline-block w-auto relative">
                    <select id="idDestino" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700" onclick="funcionNombre('gremioCantidad'); funcionNombre('cantidadTurno'); funcionNombre('MPMCPROYECTOS');funcionNombre('empresasExternasConsulta'); funcionNombre('acontecimientoConsulta'); funcionNombre('giftHabitacionesConsulta'); funcionNombre('giftCocinasConsulta');">
                        <?php
                        if ($idDestino != 10) {
                            echo "<option value=\"$idDestino\">$array_destino[$idDestino]</option>";
                        } else {
                            foreach ($array_destino as $key => $value) {
                                echo "<option value=\"$key\">$value</option>";
                            }
                        }

                        ?>


                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-center items-center w-auto mt-2 mx-2">

                <div class="inline-block w-auto relative">
                    <select id="zona" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700" onclick="funcionNombre('cantidadTurno'); funcionNombre('MPMCPROYECTOS'); funcionNombre('empresasExternasConsulta'); funcionNombre('acontecimientoConsulta'); funcionNombre('giftHabitacionesConsulta'); funcionNombre('giftCocinasConsulta'); ocultarGift();">
						<option value="ZI">ZI</option>
                        <option value="GP">GP</option>
                        <option value="TRS">TRS</option>
                        <option value="ENERGETICOS">ENERGETICOS</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                    </div>
                </div>
            </div>
            <div class="flex flex-row justify-center items-center w-auto mt-6 mx-2">
                <!-- ESPACIO DEL WIDGET -->
                <div class="inline-block w-auto relative">
                    <div class="antialiased sans-serif">
                        <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                            <div class="container mx-auto px-4 py-2 md:py-10">
                                <div class="mb-5 w-64">
                                    <div class="relative">
                                        <input type="hidden" name="date" x-ref="date">
                                        <input id="dateGeneral" type="text" readonly x-model="datepickerValue" @click="showDatepicker = !showDatepicker" @keydown.escape="showDatepicker = false" class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Fecha Selecionada">

                                        <div class="absolute top-0 right-0 px-3 py-2">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0" style="width: 17rem" x-show.transition="showDatepicker" @click.away="showDatepicker = false">
                                            <div class="flex justify-between items-center mb-2">
                                                <div>
                                                    <span x-text="MONTH_NAMES[month]" class="text-lg font-bold text-gray-800"></span>
                                                    <span x-text="year" class="ml-1 text-lg text-gray-600 font-normal"></span>
                                                </div>
                                                <div>
                                                    <button type="button" class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" :class="{'cursor-not-allowed opacity-25': month == 0 }" :disabled="month == 0 ? true : false" @click="month--; getNoOfDays()">
                                                        <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" class="transition ease-in-out duration-100 inline-flex cursor-pointer hover:bg-gray-200 p-1 rounded-full" :class="{'cursor-not-allowed opacity-25': month == 11 }" :disabled="month == 11 ? true : false" @click="month++; getNoOfDays()">
                                                        <svg class="h-6 w-6 text-gray-500 inline-flex" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex flex-wrap mb-3 -mx-1">
                                                <template x-for="(day, index) in DAYS" :key="index">
                                                    <div style="width: 14.26%" class="px-1">
                                                        <div x-text="day" class="text-gray-800 font-medium text-center text-xs"></div>
                                                    </div>
                                                </template>
                                            </div>
                                            <div class="flex flex-wrap -mx-1" onclick="funcionNombre('MPMCPROYECTOS'); funcionNombre('cantidadTurno'); funcionNombre('empresasExternasConsulta'); funcionNombre('acontecimientoConsulta'); funcionNombre('giftHabitacionesConsulta'); funcionNombre('giftCocinasConsulta');">
                                                <template x-for=" blankday in blankdays">
                                                    <div style="width: 14.28%" class="text-center border p-1 border-transparent text-sm"></div>
                                                </template>
                                                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                                    <div style="width: 14.28%" class="px-1 mb-1">
                                                        <div @click="getDateValue(date)" x-text="date" class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100" :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"></div>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="block appearance-none bg-white border border-grey-light hover:border-grey px-3 pt--3 cursor pr-3 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700 cursor-pointer" onclick="funcionNombre('MPMCPROYECTOS'); funcionNombre('cantidadTurno'); funcionNombre('empresasExternasConsulta'); funcionNombre('acontecimientoConsulta');">Buscar</div>
            </div>
        </div>
        <!-- Codigo para rango de Horario según el día -->
        <!-- onclick="funcionNombre('MPMCPROYECTOS'); funcionNombre('cantidadTurno'); funcionNombre('empresasExternasConsulta'); funcionNombre('acontecimientoConsulta');" -->

        <!-- ---------------- SECCION 2 PERSONAL ---------------- -->
        <div class="w-full flex flex-col items-center flex-wrap">
            <div class="cursor-pointer flex self-start my-3" onclick="funcionNombre('gremioCantidad'); funcionNombre('cantidadTurno');">
                <!-- CONTENEDOR DE TITULO -->
                <h1 data-target="modal-personal" data-toggle="modal" class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-blue-400 mr-1"></i></span>Personal</h1>
            </div>
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
                <!-- CONTENEDOR WIDGETS DE SECCION -->
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-auto h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="tmat" class="w-56 h-auto"></canvas>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 class="text-gray-700 font-bold text-6xl "><span id="totalgremio1">55</span><span id="totalColaboradores1" class="text-3xl text-gray-500">/50</span></h1>
                        <h1 class="text-gray-600 font-medium text-sm">Colaboradores</h1>
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 mt-3 rounded-full">Primer turno</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 class="text-gray-700 font-bold text-6xl "><span id="totalgremio2">55</span><span id="totalColaboradores2" class="text-3xl text-gray-500">/50</span></h1>
                        <h1 class="text-gray-600 font-medium text-sm">Colaboradores</h1>
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 mt-3 rounded-full">Segundo turno</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 class="text-gray-700 font-bold text-6xl "><span id="totalgremio3">55</span><span id="totalColaboradores3" class="text-3xl text-gray-500">/50</span></h1>
                        <h1 class="text-gray-600 font-medium text-sm">Colaboradores</h1>
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 mt-3 rounded-full">Tercer turno</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-auto h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="personalbarras" class="w-auto h-56"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ---------------- SECCION 3 MP MC PROYECTOS ---------------- -->
        <div class="w-full flex flex-col items-center flex-wrap">
            <div class="flex self-start my-3" onclick="funcionNombre('MPMCPROYECTOS');">
                <!-- CONTENEDOR DE TITULO -->
                <h1 class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-red-400 mr-1"></i></span>MP / MC / PROYECTOS</h1>
            </div>

            <!-- FILA DE CORRECTIVOS -->
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
                <!-- CONTENEDOR WIDGETS DE SECCION -->

                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 id="totalmc" class="text-gray-700 font-bold text-6xl ">0</h1>
                        <h1 class="text-gray-600 font-medium text-sm">Correctivos</h1>
                        <h1 class=" font-semibold text-red-400 bg-red-200 py-1 px-3 mt-3 rounded-full">MC</h1>
                    </div>
                </div>

                <div id="bitacoraMC" class="flex flex-col items-center justify-start w-screen md:w-1/2 mb-3 mx-4 bg-white rounded h-56 shadow-md p-2 overflow-auto">
                    <!-- ESPACIO DEL WIDGET -->
                    <!-- ITEM DE CORRECTIVO ........................................................................................................................... -->
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-auto h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="hmc" class="w-auto h-56"></canvas>
                    </div>
                </div>
            </div>


            <!-- FILA DE PREVENTIVOS -->
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
                <!-- CONTENEDOR WIDGETS DE SECCION -->

                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 id="totalMP" class="text-gray-700 font-bold text-6xl "></h1>
                        <h1 class="text-gray-600 font-medium text-sm">OT´S DE MP</h1>
                        <h1 class=" font-semibold text-green-400 bg-green-200 py-1 px-3 mt-3 rounded-full">MP</h1>
                    </div>
                </div>

                <div id="bitacoraMP" class="flex flex-col items-center justify-start w-screen md:w-1/2 mb-3 mx-4 bg-white rounded h-56 shadow-md p-2 overflow-auto">
                    <!-- ESPACIO DEL WIDGET -->
                    <!-- ITEM DE Preventivo ......................-->
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-auto h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="hmp" class="w-auto h-56"></canvas>
                    </div>
                </div>
            </div>

            <!-- FILA DE PROYECTOS -->
            <!-- SQL para Proyectos -->
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
                <!-- CONTENEDOR WIDGETS DE SECCION -->
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <!-- Imprime el Total de los Proyectos Finalizados -->
                        <h1 id="bitacoraProyectoTotal" class="text-gray-700 font-bold text-6xl ">0</h1>
                        <h1 class="text-gray-600 font-medium text-sm">ACTIVIDADES DE PDA</h1>
                        <h1 class=" font-semibold text-yellow-400 bg-yellow-200 py-1 px-3 mt-3 rounded-full">PROYECTOS</h1>
                    </div>
                </div>
                <div id="bitacoraProyecto" class="flex flex-col items-center justify-start w-screen md:w-1/2 mb-3 mx-4 bg-white rounded h-56 shadow-md p-2 overflow-auto">
                </div>


                <div class="flex flex-row items-center justify-center w-auto mb-3">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-auto h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="py" class="w-auto h-56"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <!-- ---------------- SECCION 4 ---------------- -->

        <div id="seccion4Gift" class="w-full flex flex-col items-center flex-wrap">

            <div class="cursor-pointer flex self-start flex-row my-3" onclick="funcionNombre('giftHabitacionesConsulta')">
                <!-- CONTENEDOR DE TITULO -->
                <h1 data-target="modal-gift" data-toggle="modal" class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-green-400 mr-1"></i></span>GIFT</h1>
                <h1 data-target="modal-gift" data-toggle="modal" class="text-red-400 bg-red-200 px-3 py-3 uppercase rounded-full font-semibold my-3 ml-4 shadow">Habitaciones</h1>
            </div>
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
                <!-- CONTENEDOR WIDGETS DE SECCION -->

                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 class="text-green-400 font-bold text-6xl "><span id="solucionadoGH">0</span><span class="text-3xl text-yellow-400">/<span id="pendienteGH">0</span></span></h1>
                        <h1 class="text-gray-600 font-medium text-sm">Solucionado/En proceso</h1>
                        <h1 class=" font-semibold text-green-400 bg-green-200 py-1 px-3 mt-3 rounded-full">Averias</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 id="MSGH" class="text-gray-700 font-bold text-2xl  my-1">0d 0h 00m</h1>
                        <h1 class=" font-semibold text-sm text-gray-700 bg-gray-400 py-1 px-3 rounded-full my-1">Media Solucion</h1>
                        <h1 id="MAGH" class="text-gray-700 font-bold text-2xl  my-1">0d 0h 00m</h1>
                        <h1 class=" font-semibold text-sm text-gray-700 bg-gray-400 py-1 px-3 rounded-full my-1">Media Asignacion</h1>
                        <h1 id="MRGH" class="text-gray-700 font-bold text-2xl  my-1">0d 0h 00m</h1>
                        <h1 class=" font-semibold text-sm text-gray-700 bg-gray-400 py-1 px-3 rounded-full my-1">Media Reparacion</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 id="satisfaccionGH" class="text-gray-700 font-bold text-6xl ">0.0</h1>
                        <h1 class=" font-semibold text-green-400 bg-green-200 py-1 px-3 mt-3 rounded-full">Satisfaccion</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-auto h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <h1 class="text-center text-gray-600 font-bold text-xl my-2 uppercase">Origen</h1>
                        <canvas id="origen" class="w-56 h-auto"></canvas>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-full md:w-1/4 mb-3">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-full h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="top5" class="w-full h-full"></canvas>
                    </div>
                </div>

            </div>

            <!-- COCINAS -->

            <div class="cursor-pointer flex self-start flex-row my-3" onclick="">
                <!-- CONTENEDOR DE TITULO -->
                <h1 data-target="modal-cobare" data-toggle="modal" class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-green-400 mr-1"></i></span>GIFT</h1>
                <h1 data-target="modal-cobare" data-toggle="modal" class="text-red-400 bg-red-200 px-3 py-3 uppercase rounded-full font-semibold my-3 ml-4 shadow">COCINAS</h1>
            </div>
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
                <!-- CONTENEDOR WIDGETS DE SECCION -->

                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 class="text-green-400 font-bold text-6xl">
                            <span id="solucionadoGC">0</span>
                            <span class="text-3xl text-yellow-400">/</span>
                            <span id="pendientesGC" class="text-3xl text-yellow-400">0</span>
                        </h1>
                        <h1 class="text-gray-600 font-medium text-sm">Solucionado/En proceso</h1>
                        <h1 class=" font-semibold text-green-400 bg-green-200 py-1 px-3 mt-3 rounded-full">Averias</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 id="mediaSolucionGC" class="text-gray-700 font-bold text-2xl  my-1">0d 0h 0m</h1>
                        <h1 class=" font-semibold text-sm text-gray-700 bg-gray-400 py-1 px-3 rounded-full my-1">Media Solucion</h1>
                        <h1 id="mediaAsignacionGC" class="text-gray-700 font-bold text-2xl  my-1">0d 0h 0m</h1>
                        <h1 class=" font-semibold text-sm text-gray-700 bg-gray-400 py-1 px-3 rounded-full my-1">Media Asignacion</h1>
                        <h1 id="mediaReparacionGC" class="text-gray-700 font-bold text-2xl  my-1">0d 0h 0m</h1>
                        <h1 class=" font-semibold text-sm text-gray-700 bg-gray-400 py-1 px-3 rounded-full my-1">Media Reparacion</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-full md:w-1/4 mb-3">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-full h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="top5c" class="w-full h-full"></canvas>
                    </div>
                </div>

            </div>

        </div><!-- FIN SECCION 4 -->


        <!-- ---------------- SECCION 5 ---------------- -->

        <div class="w-full flex flex-col items-center flex-wrap">
            <div class="cursor-pointer flex self-start my-3" onclick="funcionNombre('empresasExternasConsulta');">
                <!-- CONTENEDOR DE TITULO -->
                <h1 data-target="modal-empresas" data-toggle="modal" class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-blue-400 mr-1"></i></span>EMPRESAS EXTERNAS</h1>
            </div>
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
                <!-- CONTENEDOR WIDGETS DE SECCION -->

                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 id="totalEmpresas" class="text-gray-700 font-bold text-6xl ">0</h1>
                        <h1 class="text-gray-600 font-medium text-sm">Empresas</h1>
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 mt-3 rounded-full">Empresas Externas</h1>
                    </div>
                </div>
                <div id="registroEmpresas" class="flex flex-col items-center justify-start w-screen md:w-1/4 mb-3 mx-4 bg-white rounded h-56 shadow-md p-2 overflow-auto">
                    <!-- ESPACIO DEL WIDGET -->
                    <!-- ITEM DE EMPRESA EXTERNA ........................................................................................................................... -->
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-auto h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="empresas" class="w-auto h-56"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- ---------------- SECCION 6 ---------------- -->

        <div class="w-full flex flex-col items-center flex-wrap">
            <div class="cursor-pointer  self-start my-3">
                <!-- CONTENEDOR DE TITULO -->
                <h1 data-target="modal-acontecimientos" data-toggle="modal" class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-yellow-400 mr-1"></i></span>ACONTECIMIENTOS</h1>
            </div>
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
                <!-- CONTENEDOR WIDGETS DE SECCION -->

                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none">
                        <!--WIDGET CUADRADO-->
                        <h1 id="totalAcontecimiento" class="text-gray-700 font-bold text-6xl ">0</h1>
                        <h1 class="text-gray-600 font-medium text-sm">Hoy</h1>
                        <h1 class=" font-semibold text-yellow-700 bg-yellow-200 py-1 px-3 mt-3 rounded-full">Acontecimientos</h1>
                    </div>
                </div>
                <div id="registroAcontecimiento" class="flex flex-col items-center justify-start w-screen md:w-1/4 mb-3 mx-4 bg-white rounded h-56 shadow-md p-2 overflow-auto">
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3">
                    <!-- ESPACIO DEL WIDGET -->
                    <div class="w-auto h-auto bg-white shadow-md rounded-md">
                        <!--WIDGET CUADRADO-->
                        <canvas id="acontecimiento" class="w-auto h-56"></canvas>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="w-full flex flex-row items-center justify-center">
        <h1 class=" my-12 font-semibold text-gray-500 text-sm">Este informe se genera de forma dinamica mostrando informacion generada de 7:00 pm del dia anterior a 7:00 pm del dia actual.</h1>
    </div>

    <!-- ************************** INICIO Aréa de Modals ***************************************** -->

    <!-- modal-personal -->
    <div id="modal-personal" class="modal">
        <div class="modal-window w-full md:w-2/4 rounded-lg">
            <!-- CONTENIDO MODAL -->

            <div class="flex flex-col flex-wrap justify-center items-center">

                <div class="flex justify-center mb-6 p-4 w-full bg-gray-300 uppercase text-gray-600 text-xl font-bold rounded-lg">
                    <h1 id="tituloTurno" class="">Primer Turno</h1>
                </div>
                <div class="flex flex-col flex-wrap mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Turno </label>
                    <div class=" relative">
                        <select id="turnoSeleccionado" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state" onclick="turnoSeleccionado(); funcionNombre('gremioCantidad');">
                            <option selected="selected" value="1">Primer Turno</option>
                            <option value="2">Segundo Turno</option>
                            <option value="3">Tercer Turno</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col flex-wrap mb-6">
                    <div class="w-auto px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Total de la plantilla</label>
                        <input id="totalPlantillaPorTurno" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="number" min="0" placeholder="Total" pattern="[0-9]">
                    </div>
                </div>

                <div class=" flex flex-row flex-wrap justify-center items-center">

                    <div class="flex flex-r flex-wrap mb-6">
                        <div class="w-auto px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Gremio</label>
                            <div class=" relative">
                                <select id="gremio" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                                    <?php
                                    $query_gremio = "SELECT* FROM bitacora_gremio";
                                    $result_gremio = mysqli_query($conn_2020, $query_gremio);
                                    while ($row_gremio = mysqli_fetch_array($result_gremio)) {
                                        $id = $row_gremio['id'];
                                        $nombre_gremio = $row_gremio['nombre_gremio'];

                                        echo "<option value=\"$id\">$nombre_gremio</option>";
                                    }
                                    ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col flex-wrap mb-6">
                        <div class="w-auto px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Cantidad</label>
                            <input id="cantidadPorGremio" class=" appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="number" placeholder="Cantidad" min="0" placeholder="Total" pattern="[0-9]">
                        </div>
                    </div>
                    <div class=" flex">
                        <button class="bg-blue-300 hover:bg-blue-400 text-white font-bold py-2 px-4 border-b-4 border-blue-400 hover:border-blue-500 rounded" onclick="bitacoraPersonal(); funcionNombre('gremioCantidad'); funcionNombre('cantidadTurno');">
                            Agregar
                        </button>
                    </div>
                </div>
                <div id="gremioCantidad" class="flex flex-col flex-wrap mb-6 bg-gray-200 p-4 rounded-md">
                    <h1 class="font-semibold text-xl text-gray-500"><span>0</span> Sin Datos <span><i class="fad fa-times-circle text-red-400 text-xl"></i></span></h1>
                </div>
            </div>
        </div>
    </div>
    <!-- modal-personal -->

    <!-- modal-gift -->
    <div id="modal-gift" class="modal">
        <div class="modal-window w-full md:w-2/5 rounded-lg flex flex-col items-center justify-center">
            <!-- CONTENIDO MODAL -->
            <div class="flex self-end mb-2">
                <i class="fad fa-times-circle close" data-dismiss="modal"></i>
            </div>
            <form class="w-full">
                <input type="hidden" id="idGiftHabitaciones" name="idGiftHabitaciones">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Pendientes
                        </label>
                        <input id="giftHPendientes" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Pendientes">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Solucionados
                        </label>
                        <input id="giftHSolucionados" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Solucionados">
                    </div>
                </div>

                <div class="text-center py-4 lg:px-4">
                    <div class="p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="font-semibold mx-2 text-left flex-auto">Tiempos</span>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Media solucion
                        </label>
                        <input id="giftHMediaSolucion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="0d 5h 20m">
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Media asignacion
                        </label>
                        <input id="giftHMediaAsignacion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="0d 5h 20m">
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Media reparacion
                        </label>
                        <input id="giftHMediaReparacion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="0d 5h 20m">
                    </div>
                </div>

                <div class="text-center py-4 lg:px-4">
                    <div class="p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="font-semibold mx-2 text-left flex-auto">Satisfaccion</span>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Satisfaccion
                        </label>
                        <input id="giftHSatisfaccion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Satisfaccion">
                    </div>
                </div>

                <div class="text-center py-4 lg:px-4">
                    <div class="p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="font-semibold mx-2 text-left flex-auto">Origen</span>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            No alojado
                        </label>
                        <input id="giftHNoAlojadoOrigen" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="No alojado">
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Trabajador
                        </label>
                        <input id="giftHTrabajadorOrigen" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Trabajador">
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Huesped
                        </label>
                        <input id="giftHHuspedOrigen" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Huesped">
                    </div>
                </div>

                <div class="text-center py-4 lg:px-4">
                    <div class="p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="font-semibold mx-2 text-left flex-auto">Top 5</span>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftHTTop1" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftHTop1" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftHTTop2" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftHTop2" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftHTTop3" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftHTop3" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftHTTop4" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftHTop4" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftHTTop5" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftHTop5" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
            </form>
        </div>
        <div class="w-full md:w-1/2 px-3 text-center">
            <div id="btnGiftHabitaciones" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full cursor-pointer" onclick="funcionNombre('giftHabitacionesCaptura')">
                Agregar
            </div>
        </div>


        <!-- CONTENIDO MODAL -->
    </div>
    </div>
    <!-- modal-gift -->

    <!-- modal-cobare Cocinas -->
    <div id="modal-cobare" class="modal">
        <div class="modal-window w-full md:w-2/5 rounded-lg flex flex-col items-center justify-center">
            <!-- CONTENIDO MODAL -->
            <div class="flex self-end mb-2">
                <i class="fad fa-times-circle close" data-dismiss="modal"></i>
            </div>
            <form class="w-full">
                <input type="hidden" id="idGiftCocinas" name="idGiftCocinas">
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Pendientes
                        </label>
                        <input id="giftCocinasPendientes" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Pendientes">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Solucionados
                        </label>
                        <input id="giftCocinasSolucionados" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Solucionados">
                    </div>
                </div>

                <div class="text-center py-4 lg:px-4">
                    <div class="p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="font-semibold mx-2 text-left flex-auto">Tiempos</span>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Media solucion
                        </label>
                        <input id="giftCocinasMediaSolucion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="0d 0h 0m">
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Media asignacion
                        </label>
                        <input id="giftCocinasMediaAsignacion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="0d 0h 0m">
                    </div>
                    <div class="w-full md:w-1/3 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Media reparacion
                        </label>
                        <input id="giftCocinasMediaReparacion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="0d 0h 0m">
                    </div>
                </div>

                <div class="text-center py-4 lg:px-4">
                    <div class="p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="font-semibold mx-2 text-left flex-auto">Top 5</span>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftCocinasAveriaTop1" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftCocinasTop1" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftCocinasAveriasTop2" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftCocinasTop2" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftCocinasAveriasTop3" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftCocinasTop3" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftCocinasAveriasTop4" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftCocinasTop4" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Tipificacion
                        </label>
                        <input id="giftCocinasAveriasTop5" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Averia">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Total
                        </label>
                        <input id="giftCocinasTop5" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Total">
                    </div>
                </div>

            </form>
            <div class="w-full md:w-1/2 px-3 text-center">
                <div id="btnGiftCocinas" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full cursor-pointer" onclick="funcionNombre('giftCocinasCaptura'); funcionNombre('giftCocinasConsulta');">
                    Agregar
                </div>
            </div>
            <!-- CONTENIDO MODAL -->
        </div>
    </div>
    <!-- modal-cobare -->

    <!-- modal-empresas -->
    <div id="modal-empresas" class="modal">
        <div class="modal-window w-full md:w-2/5 rounded-lg flex flex-col items-center justify-center">
            <!-- CONTENIDO MODAL -->
            <div class="flex self-end mb-2">
                <i class="fad fa-times-circle close" data-dismiss="modal"></i>
            </div>
            <form class="w-full">
                <div class="text-center py-4 lg:px-4">
                    <div class="p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="font-semibold mx-2 text-left flex-auto">Empresas Externas</span>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Empresa
                        </label>
                        <input id="bitacoraNombreEmpresaExterna" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Empresa">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Motivo
                        </label>
                        <input id="bitacoraMotivoEmpresaExterna" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Motivo" onkeyup="if(event.keyCode == 13) funcionNombre('empresasExternasCaptura')">
                    </div>
                </div>
                <div id="registrosBitacoraEmpresa" class="flex flex-wrap flex-col bg-gray-200 items-start justify-center m-10 p-2 font-bold">

                </div>
        </div>
        </form>

        <!-- CONTENIDO MODAL -->
    </div>
    </div>
    <!-- modal-empresas -->

    <!-- modal-acontecimientos -->
    <div id="modal-acontecimientos" class="modal">
        <div class="modal-window w-full md:w-2/5 rounded-lg flex flex-col items-center justify-center">
            <!-- CONTENIDO MODAL -->
            <div class="flex self-end mb-2">
                <i class="fad fa-times-circle close" data-dismiss="modal"></i>
            </div>
            <form class="w-full">
                <div class="text-center py-4 lg:px-4">
                    <div class=" p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex" onclick="funcionNombre('acontecimientoCaptura')">
                        <span class="font-semibold mx-2 text-left flex-auto">Acontecimientos Importantes</span>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Titulo
                        </label>
                        <input id="bitacoraAcontecimiento" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Titulo">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                            Descripcion
                        </label>
                        <input id="bitacoraAcontecimientoDescripcion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Descripcion" onkeyup="if(event.keyCode == 13) funcionNombre('acontecimientoCaptura')">
                    </div>
                </div>
                <div id="bitacoraAcontecimientoConsulta" class="flex flex-wrap flex-col bg-gray-200 items-start justify-center m-10 p-2 font-bold ">
                    <div class="px-3 flex justify-between my-2">
                        <h1>Titulo del acontecimiento</h1>
                        <h1 class="mx-3"> / </h1>
                        <h1>Descripcion <span><i class="ml-3 fad fa-times-circle text-red-400 text-xl"></i></span></h1>
                    </div>
                </div>
            </form>

            <!-- CONTENIDO MODAL -->
        </div>
    </div>
    <!-- modal-acontecimientos -->


    <!-- ************************* FIN DE MODALS ************************************************++ -->


    <!-- Libreria Scripts -->
    <script src="js/jquery-3.3.1.js"></script>
    <!-- CDN para Alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- CDN para DataPicker -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
    <script src="js/bitacora_manttoJS.js"></script>
    <script src="css/fontawesome/js/all.js"></script>

</body>

</html>