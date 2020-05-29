<?php
session_set_cookie_params(60*60*24*364);
session_start();

$usuario = $_SESSION['usuario'];
$idDestino = $_SESSION['idDestino'];

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
}

$array_destino = array(10 => "AME", 1 => "RM", 2 => "PVR", 3 => "SDQ", 4 => "SSA", 5 => "PUJ", 6 => "MBJ", 7 => "CMU", 11 => "CAP");

date_default_timezone_set('America/Cancun');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG</title>
    <link rel="icon" href="svg/logo6.png">
    <link rel="stylesheet" href="css/tailwind.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="js/Chart.js"></script>
</head>
<body class="bg-gray-300" style="font-family: 'Manrope', sans-serif;">
    <div class="flex flex-col flex-wrap justify-start items-center">

        <!-- ---------------- SECCION 1 TITULO Y SELECTORES ---------------- -->

        <div class="w-full flex flex-row justify-center flex-wrap"><!-- CONTENEDOR WIDGETS DE SECCION -->
            <div class="flex flex-row justify-center items-center w-full mt-4"><!-- ESPACIO DEL WIDGET -->
                <h1 class="text-2xl font-light text-gray-700 text-center">Bitácora Diaria de <strong class=" font-semibold">Mantenimiento</strong></h1>
            </div>
            <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2"><!-- ESPACIO DEL WIDGET -->
                <div class="inline-block w-auto relative">
                    <select id="idDestino" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
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
            <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2"><!-- ESPACIO DEL WIDGET -->
                
                <div class="inline-block w-auto relative">
                    <select id="opcion" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
						<option value="ZI">ZI</option>
                        <option value="GP">GP</option>
                        <option value="TRS">TRS</option>
                        <option value="ENERGETICOS">ENERGETICOS</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
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
                                        <div class="z-30 bg-white mt-12 rounded-lg shadow p-4 absolute top-0 left-0" style="width: 17rem" x-show.transition="showDatepicker" @click.away="showDatepicker = false">
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
                                            <div class="flex flex-wrap -mx-1" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
                                                <template x-for=" blankday in blankdays">
                                                    <div style="width: 14.28%" class="text-center border p-1 border-transparent text-sm"></div>
                                                </template>
                                                <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                                    <div style="width: 14.28%" class="px-1 mb-1">
                                                        <div @click="getDateValue(date); llamarFuncion('consumoDia');" x-text="date" class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100" :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"></div>
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
                <div class="block appearance-none bg-white border border-grey-light hover:border-grey px-3 pt--3 cursor pr-3 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700 cursor-pointer" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">Buscar</div>
            </div>
        </div>

        <!-- ---------------- SECCION 1 CONSUMO DE HOY ---------------- -->

        <div class="w-full flex flex-col items-center flex-wrap">
            <div class="cursor-pointer flex self-start my-3"><!-- CONTENEDOR DE TITULO -->
                <h1 class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-blue-400 mr-1"></i></span>Consumo del dia</h1>
            </div>
            <div class="flex flex-row flex-wrap justify-center items-center w-full">
            <!-- CONTENEDOR WIDGETS DE SECCION --> 

                <!-- Electricidad -->
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div id="iconElectricidad" class="absolute bottom-0 mb-4 text-2xl">
                            <i class="fad fa-chevron-double-up"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-yellow-500 text-3xl">
                            <i class="fad fa-plug"></i>
                        </div>
                        <h1 id="dataElectricidad" class="text-gray-700 font-bold text-2xl ">20</h1>
                        <h1 class="text-gray-600 font-medium text-base">kwh</h1>
                        <h1 class=" font-semibold text-yellow-600 bg-yellow-200 py-1 px-3 mt-3 rounded-full">Eléctricidad</h1>
                    </div>
                </div>
                
                <!-- Agua -->
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div id="iconAgua" class="absolute bottom-0 mb-4 text-2xl">
                            <i class="fad fa-chevron-double-down"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-blue-500 text-3xl">
                            <i class="fad fa-tint"></i>
                        </div>
                        <h1 id="dataAgua" class="text-gray-700 font-bold text-2xl ">55</h1>
                        <h1 class="text-gray-600 font-medium text-base">metros³</h1>
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 mt-3 rounded-full">Agua</h1>
                    </div>
                </div>

                <!-- Gas -->
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div id="iconGas" class="absolute bottom-0 mb-4 text-2xl">
                            <i class="fad fa-chevron-double-up"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-red-500 text-3xl">
                            <i class="fad fa-flame"></i>
                        </div>
                        <h1 id="dataGas" class="text-gray-700 font-bold text-2xl ">66</h1>
                        <h1 class="text-gray-600 font-medium text-base">litros</h1>
                        <h1 class=" font-semibold text-red-400 bg-red-200 py-1 px-3 mt-3 rounded-full">Gas</h1>
                    </div>
                </div>

                <!-- Diesel -->
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div id="iconDiesel" class="absolute bottom-0 mb-4 text-2xl">
                            <i class="fad fa-chevron-double-down"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-orange-500 text-3xl">
                            <i class="fad fa-gas-pump"></i>
                        </div>
                        <h1 id="dataDiesel" class="text-gray-700 font-bold text-2xl ">66</h1>
                        <h1 class="text-gray-600 font-medium text-base">litros</h1>
                        <h1 class=" font-semibold text-orange-400 bg-orange-200 py-1 px-3 mt-3 rounded-full">Diesel</h1>
                    </div>
                </div>

                <!-- Ocupación -->
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div id="iconOcupacion" class="absolute bottom-0 mb-4 text-2xl">
                            <i class="fad fa-chevron-double-up"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-gray-500 text-3xl">
                            <i class="fad fa-hotel"></i>
                        </div>
                        <h1 id="dataOcupacion" class="text-gray-700 font-bold text-2xl ">66<span class="text-2xl text-gray-500">%</span></h1>
                        <h1 class="text-gray-600 font-medium text-base">Porcentaje</h1>
                        <h1 class=" font-semibold text-gray-600 bg-gray-200 py-1 px-3 mt-3 rounded-full">Ocupación</h1>
                    </div>
                </div>

                <!-- Pax -->
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div id="iconPax" class="absolute bottom-0 mb-4 text-2xl">
                            <i class="fad fa-chevron-double-up"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-gray-500 text-3xl">
                            <i class="fad fa-users"></i>
                        </div>
                        <h1 id="dataPax" class="text-gray-700 font-bold text-2xl ">66</h1>
                        <h1 class="text-gray-600 font-medium text-base">Huespedes</h1>
                        <h1 class=" font-semibold text-gray-600 bg-gray-200 py-1 px-3 mt-3 rounded-full">Pax</h1>
                    </div>
                </div>
            </div>

            <div class="cursor-pointer flex self-start my-3" onclick="modalTailwind('modal-acontecimientos','toggle');"><!-- CONTENEDOR DE TITULO -->
                <h1 class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-red-400 mr-1"></i></span>Acontecimientos del dia</h1>
            </div>
            <!-- acontecimientos -->
            <div class="flex flex-row items-center justify-evenly w-full mb-3 overflow-x-auto">
                <div class="sm:w-full md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-yellow-600 bg-yellow-200 py-1 px-3 my-2 rounded-full">Electricidad</h1>
                    </div>
                    <!-- Recibe los resultados obtenidos de Electricidad -->
                    <div id="dataAcontecimientosElectricidad"></div>
                </div>

                <div class="sm:w-full md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 my-2 rounded-full">Agua</h1>
                    </div>
                    <!-- items de acontecimientos -->
                    <div id="dataAcontecimientosElectricidadAgua"></div>
                </div>

                <div class="sm:w-full md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-red-600 bg-red-200 py-1 px-3 my-2 rounded-full">Gas</h1>
                    </div>
                    <!-- items de acontecimientos -->
                    <div id="dataAcontecimientosElectricidadGas"></div>

                </div>

                <div class="sm:w-full md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-orange-400 bg-orange-200 py-1 px-3 my-2 rounded-full">Diesel</h1>
                    </div>
                    <!-- items de acontecimientos -->
                    <div id="dataAcontecimientosElectricidadDiesel"></div>
                    
                </div>
            </div>


            <div class="cursor-pointer flex self-start my-3"><!-- CONTENEDOR DE TITULO -->
                <h1 class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-green-400 mr-1"></i></span>Ultima semana</h1>
            </div>

            <!-- graficos -->
            <div class="flex flex-row items-start justify-evenly w-full mb-3 overflow-x-auto">
                <div class="sm:w-5/6 md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-yellow-600 bg-yellow-200 py-1 px-3 my-2 rounded-full">Electricidad</h1>
                    </div>
                    <canvas id="gelectricidad" class="w-auto h-auto"></canvas>
                    <!-- acontecimientos de la semana -->
                    <p class="truncate font-bold text-gray-600 text-base text-center my-1">Acontecimientos de la semana</p>
                    <div id="dataAcontecimientosElectricidadSemana"></div>
                </div>

                <div class="sm:w-5/6 md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 my-2 rounded-full">Agua</h1>
                    </div>
                    <canvas id="gagua" class="w-auto h-auto"></canvas>
                    <!-- acontecimientos de la semana -->
                    <p class="truncate font-bold text-gray-600 text-base text-center my-1">Acontecimientos de la semana</p>
                    <div id="dataAcontecimientosAguaSemana"></div>
                </div>

                <div class="sm:w-5/6 md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-red-600 bg-red-200 py-1 px-3 my-2 rounded-full">Gas</h1>
                    </div>
                    <canvas id="ggas" class="w-auto h-auto"></canvas>
                    <p class="truncate font-bold text-gray-600 text-base text-center my-1">Acontecimientos de la semana</p>
                    <div id="dataAcontecimientosGasSemana"></div>
                </div>

                <div class="sm:w-5/6 md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-orange-400 bg-orange-200 py-1 px-3 my-2 rounded-full">Diesel</h1>
                    </div>
                    <canvas id="gdiesel" class="w-auto h-auto"></canvas> 
                    <p class="truncate font-bold text-gray-600 text-base text-center my-1">Acontecimientos de la semana</p>
                    <div id="dataAcontecimientosDiselSemana"></div>         
                </div>
            </div>
        </div>
    </div>        

        <!-- modal-acontecimientos -->
    <div id="modal-acontecimientos" class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center hidden">
        <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" onclick="modalTailwind('modal-acontecimientos','toggle');"></div>
        
            <div class="modal-window w-full md:w-2/5 rounded-lg flex flex-col items-center justify-center bg-white z-50 p-6">
               
                <!-- CONTENIDO MODAL -->
                <div class="flex self-end mb-2" onclick="modalTailwind('modal-acontecimientos','toggle');">
                    <i class="fad fa-times-circle close" data-dismiss="modal"></i>
                </div>
                <form class="w-full" autocomplete="off">
                    <div class="text-center py-4 lg:px-4">
                        <div class="p-2 bg-gray-800 items-center text-indigo-100 leading-none lg:rounded-full flex lg:inline-flex">
                        <span class="font-semibold mx-2 text-left flex-auto">Acontecimientos Energéticos</span>
                        </div>
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-6">
                        <div class="w-full md:w-1/3 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Título
                            </label>
                            <input id="acontecimientosTitulo" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Título">
                        </div>
                        <div class="w-full md:w-1/3 px-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">
                                Descripción
                            </label>
                            <input id="acontecimientosDescripcion" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Descripción" onkeyup = "if(event.keyCode == 13) llamarFuncion('agregarAcontecimiento')">
                        </div>
                        <div class="w-full md:w-1/3 px-3 pt-6">
                            <select id="acontecimientosEnergetico" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700" onclick="llamarFuncion('consultaAcontecimientos');">
                            <option value"electricidad">Electricidad</option>
                            <option value"agua">Agua</option>
                            <option value"gas">Gas</option>
                            <option value"diesel">Diesel</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap flex-col bg-gray-200 items-start justify-center m-10 p-2 font-bold ">
                        <div id="dataModalAcontecimientosElectricidad"></div>
                        <div id="dataModalAcontecimientosAgua"></div>
                        <div id="dataModalAcontecimientosGas"></div>
                        <div id="dataModalAcontecimientosDiesel"></div>
                    </div> 
                </form>
                <!-- CONTENIDO MODAL -->
        </div>
    </div>
    <!-- modal-acontecimientos -->

    <!-- Librerias JS -->
    <script src="js/jquery-3.3.1.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>
    <!-- CDN de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- Libreria para llamar a las alerta prediseñadas con parametros -->
    <script src="js/alertasSweet.js"></script>
    <script src="js/bitacora_energeticos.js"></script>
</body>

<script>
/* Graficos Energeticos*/

</script>
</html>