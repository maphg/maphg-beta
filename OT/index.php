<!DOCTYPE html>
<html lang="Es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG OT</title>
    <link rel="stylesheet" href="../css/tailwindproduccion.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/modales.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
</head>

<body class="flex flex-col justify-start items-start md:items-center h-auto bg-bluegray-900" style="font-family: 'Roboto', sans-serif;">
    <div class="w-full h-auto py-2 bg-white mb-6 flex items-center justify-center" id="boton" style="z-index: 9878;">
        <button onclick="screenShot()" class="py-2 px-3 bg-red-200 shadow-sm font-bold uppercase text-red-500 text-xs rounded mr-4">
            <i class="fas fa-download font-normal"></i> Descargar PDF
        </button>
        <button onclick="favoritos()" class="py-2 px-3 bg-yellow-200 shadow-sm font-bold uppercase text-yellow-500 text-xs rounded mr-4">
            <i class="fas fa-star font-normal"></i> Favoritos
        </button>
        <button onclick="telegram()" class="py-2 px-3 bg-indigo-200 shadow-sm font-bold uppercase text-indigo-500 text-xs rounded">
            <i class="fab fa-telegram-plane font-normal"></i> Telegram Alerts
        </button>
    </div>
    <div id="33" class="">
        <div class="flex flex-col items-center justify-start bg-white pt-3 px-4 overflow-hidden mt-1 relative rounded" style="width: 1223px; height: 1576px; z-index: 888;">
            <div class="flex flex-col justify-center items-start w-full relative">
                <div class="flex flex-row justify-between items-center w-252">
                    <!-- QR Y NUMERO DE OT -->
                    <div class="absolute top-0 right-0 border-4 border-bluegray-900 rounded-l flex flex-row items-center justify-start w-40 bg-bluegray-900">
                        <div>
                            <img class="w-32" src="svg/qrotfinder.svg" alt="">
                        </div>
                        <div class="font-semibold transform text-sm w-32 text-white absolute text-center" style="--transform-rotate: 270deg; right: -35%;">
                            <h1 id="idOTQR"></h1>
                        </div>
                    </div>
                    <!-- QR Y NUMERO DE OT -->
                    <!-- BADGE DEL LOGO -->
                    <div class=" flex flex-col items-center justify-center">
                        <div class="w-12">
                            <img src="svg/logo-maphg.png" alt="">
                        </div>
                    </div>
                    <!-- BADGE DEL LOGO -->
                    <!-- DESTINO SECCION Y SUBSECCION -->
                    <div class="flex flex-row">
                        <div id="logoClassOT" class="relative">
                            <h1 id="seccionOT" class="">ZIC</h1>
                        </div>
                        <div class="flex flex-col justify-center items-start ml-1">
                            <div class="font-semibold text-sm px-1 rounded  text-bluegray-900 mb-1 flex justify-start items-center">
                                <h1 id="destinoOT" class="font-bold">CMU</h1>
                            </div>
                            <div class="font-semibold text-sm px-1 rounded  text-bluegray-900 flex justify-start items-center">
                                <h1 id="subseccionOT" class="font-bold">FAN&COILS</h1>
                            </div>
                        </div>
                    </div>
                    <!-- DESTINO SECCION Y SUBSECCION -->
                    <div class="flex flex-col uppercase items-start font-semibold text-bluegray-800 leading-none">
                        <div class="text-base font-semibold">
                            <h1 id="tipoMantenimientoOT" class="">MANTENIMIENTO PREVENTIVO</h1>
                        </div>
                        <div class="text-3xl">
                            <h1 id="numeroOT" class="">OT NÚMERO 72627</h1>
                        </div>
                        <div class="text-base font-semibold flex">
                            <h1 id="tipoMatenimiento2OT" class="mr-4">MANTENIMIENTO MENOR</h1>
                            <h1 id="periodicidadOT" class="mr-4">SEMESTRAL</h1>
                            <h1 id="semanaOT" class="mr-4">SEMANA 44</h1>
                            <h1 id="añoOT" class="mr-4">2020</h1>
                        </div>
                    </div>
                    <div class="flex flex-col uppercase items-center font-semibold text-bluegray-800 leading-none">
                        <div class="text-xs font-semibold">
                            <h1 id="fechaOT" class="">GENERADA EL 24/07/2020</h1>
                        </div>
                        <div class="text-xl font-semibold py-1 px-2 rounded-full border-2 border-bluegray-900 mt-1">
                            <h1 id="statusOT" class=""></h1>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-start w-full my-4">
                    <div class="relative flex flex-col items-center justify-center border-4 mr-2 border-bluegray-900 rounded-md">
                        <img src="svg/qractivefinder.svg" class="w-16 rounded-md" alt="">
                        <div class="absolute text-xs font-bold border rounded-sm px-1 border-bluegray-900 bg-bluegray-900 text-white flex flex-col items-center justify-center" style="margin-top: 3.2rem; z-index: 234234234234;">
                            <h1 style="z-index: 123123;">234234</h1>
                            <div class="w-3 h-3 bg-bluegray-900 rounded-sm transform rotate-45 absolute mx-auto" style="top: -20%; z-index: 123;"></div>
                        </div>
                    </div>
                    <div class="flex flex-col uppercase items-start font-semibold text-bluegray-800 leading-none">
                        <div class="truncate text-base font-semibold">
                            <h1 class="">EQUIPO</h1>
                        </div>
                        <div class="truncate w-252 text-3xl">
                            <h1 id="equipoOT" class="">Fan & COIL habitacion 1403</h1>
                        </div>
                        <div class="truncate text-base font-semibold flex">
                            <h1 class="mr-4">GP</h1>
                            <h1 class="mr-4">HOTEL WHITE SAND</h1>
                            <h1 class="mr-4">VILLA 14</h1>
                            <h1 class="mr-4">HABITACION 1403</h1>
                        </div>
                    </div>
                </div>

                <!-- LISTA DE ACTIVIDADES A REALIZAR -->
                <div class="w-full mt-2 flex flex-row items-start justify-start" style="z-index: 3243254;">
                    <div class="w-2/3 flex flex-col items-center justify-start py-2 px-3 overflow-y-auto scrollbar text-bluegray-900 border-4 border-bluegray-50 rounded-md relative pt-8" style="min-height: 1100px; max-height: 1101px;">
                        <div class="font-bold text-base w-auto px-3 rounded-b-lg text-center mb-2 uppercase text-gray-600 bg-gray-200 absolute top-0">
                            <h1>Actividades a realizar</h1>
                        </div>
                        <div id="dataActividades" class="w-full"></div>


                    </div>
                    <div class="w-1/3 flex flex-col items-center justify-start ml-2">
                        <div class="flex flex-col items-center justify-start overflow-y-auto scrollbar text-bluegray-900 border-4 border-bluegray-50 rounded-md w-full py-2 px-3 mb-2 scrollbar relative pt-8" style="min-height: 15rem; max-height: 15.1rem;">
                            <div class="font-bold text-base w-auto px-3 rounded-b-lg text-center mb-2 uppercase text-gray-600 bg-gray-200 absolute top-0">
                                <h1>Indicaciones Adicionales</h1>
                            </div>
                            <div class="w-full">
                                <h1 id="indicacionesAdicionalesOT" class="leading-snug text-justify font-bold text-xs text-gray-700 normal-case"></h1>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-start overflow-y-auto scrollbar text-bluegray-900 border-4 border-bluegray-50 rounded-md w-full py-2 px-3 relative pt-6 text-gray-700 font-semibold text-xs" style="max-height: 26.4rem;">
                            <div class="font-bold text-base w-auto px-3 rounded-b-lg text-center mb-2 uppercase text-gray-600 bg-gray-200 absolute top-0">
                                <h1>materiales</h1>
                            </div>
                            <div id="dataMaterialesOT" class="w-full"></div>

                        </div>
                        <div class="flex flex-col items-center justify-start overflow-y-auto scrollbar text-bluegray-900 border-4 border-bluegray-50 rounded-md w-full py-2 px-3 mt-2 scrollbar relative pt-8" style="max-height: 26.4rem;">
                            <div class="font-bold text-base w-auto px-3 rounded-b-lg text-center mb-2 uppercase text-gray-600 bg-gray-200 absolute top-0">
                                <h1>Media</h1>
                            </div>
                            <div class="w-full flex flex-row flex-wrap justify-evenly">
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo1.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo2.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo3.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo1.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo2.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo3.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo1.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo2.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo3.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo1.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo2.jpg);"></div>
                                <div class="w-24 h-24 bg-cover bg-center m-1 rounded" style="background-image: url(img/equipo3.jpg);"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-bluegray-900 border-4 border-bluegray-50 rounded-md w-full h-32 mt-4">
                    <textarea name="" id="" class="text-xs font-semibold p-2 text-gray-700 focus:outline-none focus:shadow-outline-none uppercase w-full h-full" placeholder="Observaciones / Comentarios"></textarea>
                </div>
                <div class="w-full flex justify-evenly">
                    <div class="text-bluegray-900 rounded-md w-64 h-32 mt-4 flex flex-col justify-center items-center px-2">
                        <h1 class="font-semibold text-xs mb-6">ASIGNADA A</h1>
                        <h1 class="font-semibold text-sm truncate cursor-pointer"></h1>
                        <div class="text-xs font-bold border-t-2 border-bluegray-50 w-full text-center">
                            <h1>NOMBRE Y FIRMA</h1>
                        </div>
                    </div>
                    <div class="text-bluegray-900 rounded-md w-64 h-32 mt-4 flex flex-col justify-center items-center px-2">
                        <h1 class="font-semibold text-xs mb-6">SUPERVISADO POR</h1>
                        <h1 class="font-semibold text-sm truncate cursor-pointer text-white">---</h1>
                        <div class="text-xs font-bold border-t-2 border-bluegray-50 w-full text-center">
                            <h1>NOMBRE Y FIRMA</h1>
                        </div>
                    </div>
                    <div class="text-bluegray-900 rounded-md w-64 h-32 mt-4 flex flex-col justify-center items-center px-2">
                        <h1 class="font-semibold text-xs mb-6">AUDITADO POR</h1>
                        <h1 class="font-semibold text-sm truncate cursor-pointer text-white">---</h1>
                        <div class="text-xs font-bold border-t-2 border-bluegray-50 w-full text-center">
                            <h1>NOMBRE Y FIRMA</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/html2canvas.js"></script>
    <script src="../js/exportarPdf.js"></script>
    <script>
        function tachar(id) {
            idactividad = id + 'actividad';
            var toggle = document.getElementById(idactividad);
            toggle.classList.toggle("line-through");
            toggle.classList.toggle("text-gray-600");
            toggle.classList.toggle("italic");

            idcheck1 = id + 'check1';
            var toggle = document.getElementById(idcheck1);
            toggle.classList.toggle("bg-lightblue-500");
            toggle.classList.toggle("border-lightblue-500");

            idcheck2 = id + 'check2';
            var toggle = document.getElementById(idcheck2);
            toggle.classList.toggle("invisible");
        }

        function verOT() {
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let url = localStorage.getItem('URL').split(';');
            let idSemana = url[0];
            let idProceso = url[1];
            let idEquipo = url[2];
            let semanaX = url[3];
            let idPlan = url[4];
            const action = "GENERAROT";

            $.ajax({
                type: "POST",
                url: "php/ot_crud.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idSemana: idSemana,
                    idProceso: idProceso,
                    idEquipo: idEquipo,
                    semanaX: semanaX,
                    idPlan: idPlan
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    document.getElementById("dataActividades").innerHTML = data.actividades;
                    document.getElementById("idOTQR").innerHTML = data.id;
                    document.getElementById("seccionOT").innerHTML = data.seccion;
                    document.getElementById("destinoOT").innerHTML = data.destino;
                    document.getElementById("subseccionOT").innerHTML = data.grupo;
                    document.getElementById("tipoMantenimientoOT").innerHTML = 'Mantenimiento ' + data.tipo_plan;
                    document.getElementById("numeroOT").innerHTML = 'OT NÚMERO ' + data.id;
                    document.getElementById("tipoMatenimiento2OT").innerHTML = 'Mantenimiento ' + data.grado;
                    document.getElementById("periodicidadOT").innerHTML = data.frecuencia;
                    document.getElementById("semanaOT").innerHTML = 'Semana ' + data.semana;
                    document.getElementById("añoOT").innerHTML = data.año;
                    document.getElementById("equipoOT").innerHTML = data.equipo;
                    document.getElementById("fechaOT").innerHTML = 'GENERADA EL ' + data.fecha_creacion;
                    document.getElementById("logoClassOT").classList.remove();
                    document.getElementById("logoClassOT").classList.add(data.seccion.toLowerCase() + '-logo');
                    document.getElementById("dataMaterialesOT").innerHTML = data.materiales;
                    document.getElementById("indicacionesAdicionalesOT").innerHTML = data.descripcion;
                    if (data.status = "PROCESO") {
                        document.getElementById("statusOT").innerHTML = 'EN ' + data.status;
                    } else {
                        document.getElementById("statusOT").innerHTML = data.status;
                    }


                }
            });
        }
        verOT();
    </script>
</body>

</html>