<?php
session_set_cookie_params(60 * 60 * 24 * 364);
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


    <div class="w-full flex flex-row justify-center flex-wrap">
        <!-- CONTENEDOR WIDGETS DE SECCION -->
        <div class="flex flex-row justify-center items-center w-full mt-4">
            <!-- ESPACIO DEL WIDGET -->
            <h1 class="text-2xl font-light text-gray-700 text-center">Bitácora de <strong class=" font-semibold">ANTICIPACIÓN</strong></h1>
        </div>
        <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2 hidden">
            <!-- ESPACIO DEL WIDGET -->
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
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2">
            <!-- ESPACIO DEL WIDGET -->
            <div class="inline-block w-auto relative">
                <select id="opcion" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
                    <option value="ZI">ZI</option>
                    <option value="GP">GP</option>
                    <option value="TRS">TRS</option>
                    <option value="ENERGETICOS">ENERGETICOS</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="flex flex-row justify-center items-center w-auto mt-6 mx-2 hidden">
            <!-- ESPACIO DEL WIDGET -->
            <div class="inline-block w-auto relative">
                <div class="antialiased sans-serif">
                    <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                        <div class="container mx-auto px-4 py-2 md:py-10">
                            <div class="mb-5 w-64">
                                <div class="relative">
                                    <input type="hidden" name="date" x-ref="date">
                                    <input type="text" readonly x-model="datepickerValue" @click="showDatepicker = !showDatepicker" @keydown.escape="showDatepicker = false" class="w-full pl-4 pr-10 py-3 leading-none rounded-lg shadow-sm focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Fecha Selecionada">

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
                                                    <div x-text="day" class="text-gray-800 font-medium text-center text-xs">
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="flex flex-wrap -mx-1" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
                                            <template x-for=" blankday in blankdays">
                                                <div style="width: 14.28%" class="text-center border p-1 border-transparent text-sm">
                                                </div>
                                            </template>
                                            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                                <div style="width: 14.28%" class="px-1 mb-1">
                                                    <div @click="getDateValue(date); llamarFuncion('consumoDia');" x-text="date" class="cursor-pointer text-center text-sm leading-none rounded-full leading-loose transition ease-in-out duration-100" :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }">
                                                    </div>
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
            <div class="block appearance-none bg-white border border-grey-light hover:border-grey px-3 pt--3 cursor pr-3 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700 cursor-pointer" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
                Buscar
            </div>
        </div>

        <!-- Input para Seleccionar la Fecha. -->
        <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2 hidden">
            <div class="sans-serif inline-block w-auto relative" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
                <input id="dateGeneral" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700" type="date" placeholder="" value="<?= date('Y-m-d') ?>" min="2020-01-01" max="2030-12-31">
            </div>
        </div>

        <!-- Button para Cargar los Filtros Destino - Energetico - Fecha -->
        <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2 hidden">
            <div class="block appearance-none bg-white border border-grey-light hover:border-grey cursor px-4 py-2 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700 cursor-pointer" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
                Buscar
            </div>
        </div>
    </div>

    <div class="flex flex-col flex-wrap justify-start items-center p-2 w-full h-screen">
        <iframe src="https://app.powerbi.com/view?r=eyJrIjoiN2Y2MGFiYWEtYWM5OS00ZGI4LWEyNjYtMmYzMjliNTgzZWZjIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" width="100%" height="100%"></iframe>
    </div>

    <!-- Librerias JS -->
    <script src="js/jquery-3.3.1.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js"></script>
    <!-- CDN de SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <!-- Libreria para llamar a las alerta prediseñadas con parametros -->
    <script src="js/alertasSweet.js"></script>
    <script src="js/bitacora_energeticos.js"></script>
    <script src="js/refreshSession.js"></script>
</body>

<script>
    /* Graficos Energeticos*/
</script>

</html>