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
    <!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet"> -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet"> -->
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
                    <select class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700">
                      <option>DESTINO</option>
                      <option>DESTINO</option>
                      <option>DESTINO</option>
                      <option>DESTINO</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

            </div>
            <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2"><!-- ESPACIO DEL WIDGET -->
                
                <div class="inline-block w-auto relative">
                    <select class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700">
                      <option>GP</option>
                      <option>TRS</option>
                      <option>ZI</option>
                      <option>ENERGETICOS</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

            </div>
            <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2"><!-- ESPACIO DEL WIDGET -->
                <div class="inline-block w-auto relative">
                    <select class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700">
                      <option>13/marzo/2020</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>         
        </div>

        <!-- ---------------- SECCION 1 CONSUMO DE HOY ---------------- -->

        <div class="w-full flex flex-col items-center flex-wrap">
            <div class="cursor-pointer flex self-start my-3"><!-- CONTENEDOR DE TITULO -->
                <h1 class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-blue-400 mr-1"></i></span>Consumo del dia</h1>
            </div>
            <div class="flex flex-row flex-wrap justify-center items-center w-full"><!-- CONTENEDOR WIDGETS DE SECCION --> 
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div class="absolute bottom-0 mb-4 text-red-500 text-2xl">
                            <i class="fad fa-chevron-double-up"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-yellow-500 text-3xl">
                            <i class="fad fa-plug"></i>
                        </div>
                        <h1 class="text-gray-700 font-bold text-6xl ">20</h1>
                        <h1 class="text-gray-600 font-medium text-base">kwh</h1>
                        <h1 class=" font-semibold text-yellow-600 bg-yellow-200 py-1 px-3 mt-3 rounded-full">Electricidad</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div class="absolute bottom-0 mb-4 text-green-500 text-2xl">
                            <i class="fad fa-chevron-double-down"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-blue-500 text-3xl">
                            <i class="fad fa-tint"></i>
                        </div>
                        <h1 class="text-gray-700 font-bold text-6xl ">55</h1>
                        <h1 class="text-gray-600 font-medium text-base">metros³</h1>
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 mt-3 rounded-full">Agua</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div class="absolute bottom-0 mb-4 text-red-500 text-2xl">
                            <i class="fad fa-chevron-double-up"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-red-500 text-3xl">
                            <i class="fad fa-flame"></i>
                        </div>
                        <h1 class="text-gray-700 font-bold text-6xl ">66</h1>
                        <h1 class="text-gray-600 font-medium text-base">litros</h1>
                        <h1 class=" font-semibold text-red-400 bg-red-200 py-1 px-3 mt-3 rounded-full">Gas</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div class="absolute bottom-0 mb-4 text-green-500 text-2xl">
                            <i class="fad fa-chevron-double-down"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-orange-500 text-3xl">
                            <i class="fad fa-gas-pump"></i>
                        </div>
                        <h1 class="text-gray-700 font-bold text-6xl ">66</h1>
                        <h1 class="text-gray-600 font-medium text-base">litros</h1>
                        <h1 class=" font-semibold text-orange-400 bg-orange-200 py-1 px-3 mt-3 rounded-full">Diesel</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div class="absolute bottom-0 mb-4 text-red-500 text-2xl">
                            <i class="fad fa-chevron-double-up"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-gray-500 text-3xl">
                            <i class="fad fa-hotel"></i>
                        </div>
                        <h1 class="text-gray-700 font-bold text-6xl ">66<span class="text-2xl text-gray-500">%</span></h1>
                        <h1 class="text-gray-600 font-medium text-base">Porcentaje</h1>
                        <h1 class=" font-semibold text-gray-600 bg-gray-200 py-1 px-3 mt-3 rounded-full">Ocupación</h1>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-center w-auto mb-3 mx-4">
                    <div class="w-56 h-56 bg-white shadow-md rounded-md flex flex-col items-center justify-center leading-none relative">
                        <div class="absolute bottom-0 mb-4 text-red-500 text-2xl">
                            <i class="fad fa-chevron-double-up"></i>
                        </div>
                        <div class="absolute top-0 mt-4 text-gray-500 text-3xl">
                            <i class="fad fa-users"></i>
                        </div>
                        <h1 class="text-gray-700 font-bold text-6xl ">66</h1>
                        <h1 class="text-gray-600 font-medium text-base">Huespedes</h1>
                        <h1 class=" font-semibold text-gray-600 bg-gray-200 py-1 px-3 mt-3 rounded-full">Pax</h1>
                    </div>
                </div>
            </div>
            <div class="cursor-pointer flex self-start my-3"><!-- CONTENEDOR DE TITULO -->
                <h1 class="text-gray-200 bg-gray-900 pl-4 pr-3 py-3 uppercase rounded-r-full font-semibold my-3"><span><i class="fad fa-circle text-sm text-red-400 mr-1"></i></span>Acontecimientos del dia</h1>
            </div>
            <!-- acontecimientos -->
            <div class="flex flex-row items-center justify-evenly w-full mb-3 overflow-x-auto">
                <div class="sm:w-full md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-yellow-600 bg-yellow-200 py-1 px-3 my-2 rounded-full">Electricidad</h1>
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                </div>

                <div class="sm:w-full md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 my-2 rounded-full">Agua</h1>
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                </div>

                <div class="sm:w-full md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-red-600 bg-red-200 py-1 px-3 my-2 rounded-full">Gas</h1>
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                </div>

                <div class="sm:w-full md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-orange-400 bg-orange-200 py-1 px-3 my-2 rounded-full">Diesel</h1>
                    </div>
                    <!-- items de acontecimientos -->
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold">Sin acontecimientos...</h1>
                    </div>
                    
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
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold mr-2">16/12/2020</h1><!-- SECION -->
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->                      
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold mr-2">16/12/2020</h1><!-- SECION -->
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->                      
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                </div>

                <div class="sm:w-5/6 md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-blue-400 bg-blue-200 py-1 px-3 my-2 rounded-full">Agua</h1>
                    </div>
                    <canvas id="gagua" class="w-auto h-auto"></canvas>
                    <!-- acontecimientos de la semana -->
                    <p class="truncate font-bold text-gray-600 text-base text-center my-1">Acontecimientos de la semana</p>
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold mr-2">16/12/2020</h1><!-- SECION -->
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->                      
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                </div>

                <div class="sm:w-5/6 md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-red-600 bg-red-200 py-1 px-3 my-2 rounded-full">Gas</h1>
                    </div>
                    <canvas id="ggas" class="w-auto h-auto"></canvas>
                    <div class="flex justify-center items-center w-full bg-gray-200 rounded mb-2 text-gray-700 cursor-pointer py-2 text-xs px-1">
                        <h1 class="font-bold mr-2">16/12/2020</h1><!-- SECION -->
                        <h1 class="font-bold">Fuga</h1><!-- SECION -->
                        <P class="font-black mx-1">/</P><!-- DIVISION -->                      
                        <h1 class="truncate font-medium">Descripcion de la tarea Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut, perspiciatis?</h1><!-- DESCRIPCION DE LA TAREA -->
                    </div>
                </div>

                <div class="sm:w-5/6 md:w-1/4 mx-3 h-auto bg-white shadow-md rounded-md p-2">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class=" font-semibold text-orange-400 bg-orange-200 py-1 px-3 my-2 rounded-full">Diesel</h1>
                    </div>
                    <canvas id="gdiesel" class="w-auto h-auto"></canvas>
                    
                </div>
            </div>

            
            

        </div>


    </div>        
</body>
<script>
  
/* Graficos Energeticos*/
var ctx = document.getElementById('gelectricidad');
var gelectricidad = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'hoy'],
        datasets: [{
            label: 'Historico',
            data: [12, 19, 3, 5, 2, 9, 3],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor:'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {     
        
        legend:{
            display:false,
            position:'bottom',
            align:'center',
            },
            
        tooltips:{
            enabled: true,
        }
    }

});

var ctx = document.getElementById('gagua');
var gagua = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'hoy'],
        datasets: [{
            label: 'Historico',
            data: [12, 19, 3, 5, 2, 9, 3],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor:'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {     
        
        legend:{
            display:false,
            position:'bottom',
            align:'center',
            },
            
        tooltips:{
            enabled: true,
        }
    }

});

var ctx = document.getElementById('ggas');
var ggas = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'hoy'],
        datasets: [{
            label: 'Historico',
            data: [12, 19, 3, 5, 2, 9, 3],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor:'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {     
        
        legend:{
            display:false,
            position:'bottom',
            align:'center',
            },
            
        tooltips:{
            enabled: true,
        }
    }

});

var ctx = document.getElementById('gdiesel');
var gdiesel = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'hoy'],
        datasets: [{
            label: 'Historico',
            data: [12, 19, 3, 5, 2, 9, 3],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor:'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {     
        
        legend:{
            display:false,
            position:'bottom',
            align:'center',
            },
            
        tooltips:{
            enabled: true,
        }
    }

});
</script>
</html>