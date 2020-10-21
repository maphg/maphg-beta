<!DOCTYPE html>
<html lang="Es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG OT MP</title>
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

        <button onclick="favoritos()" class="py-2 px-3 bg-yellow-200 shadow-sm font-bold uppercase text-yellow-500 text-xs rounded mr-4 hidden">
            <i class="fas fa-star font-normal"></i> Favoritos
        </button>

        <button onclick="telegram()" class="py-2 px-3 bg-indigo-200 shadow-sm font-bold uppercase text-indigo-500 text-xs rounded hidden">
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
                            <img src="../svg/logo-maphg.png" alt="">
                        </div>
                    </div>
                    <!-- BADGE DEL LOGO -->
                    <!-- DESTINO SECCION Y SUBSECCION -->
                    <div class="flex flex-row">
                        <div id="logoClassOT" class="relative">
                            <h1 id="seccionOT" class=""></h1>
                        </div>
                        <div class="flex flex-col justify-center items-start ml-1">
                            <div class="font-semibold text-sm px-1 rounded  text-bluegray-900 mb-1 flex justify-start items-center">
                                <h1 id="destinoOT" class="font-bold"></h1>
                            </div>
                            <div class="font-semibold text-sm px-1 rounded  text-bluegray-900 flex justify-start items-center">
                                <h1 id="subseccionOT" class="font-bold"></h1>
                            </div>
                        </div>
                    </div>
                    <!-- DESTINO SECCION Y SUBSECCION -->
                    <div class="flex flex-col uppercase items-start font-semibold text-bluegray-800 leading-none">
                        <div class="text-base font-semibold">
                            <h1 id="tipoMantenimientoOT" class=""></h1>
                        </div>
                        <div class="text-3xl">
                            <h1 id="numeroOT" class="">OT NÚMERO #</h1>
                        </div>
                        <div class="text-base font-semibold flex">
                            <h1 id="tipoMatenimiento2OT" class="mr-4"></h1>
                            <h1 id="periodicidadOT" class="mr-4"></h1>
                            <h1 id="semanaOT" class="mr-4"></h1>
                            <h1 id="añoOT" class="mr-4"></h1>
                        </div>
                    </div>
                    <div class="flex flex-col uppercase items-center font-semibold text-bluegray-800 leading-none">
                        <div class="text-xs font-semibold">
                            <h1 id="fechaOT" class=""></h1>
                        </div>
                        <div class="text-xl font-semibold py-1 px-2 rounded-full border-2 border-bluegray-900 mt-1">
                            <h1 id="statusOT" class=""></h1>
                        </div>
                    </div>
                </div>
                <div class="flex flex-row items-center justify-start w-full my-4">
                    <div class="relative flex flex-col items-center justify-center border-4 mr-2 border-bluegray-900 rounded-md">
                        <img src="svg/qractivefinder.svg" class="w-16 rounded-md" alt="">
                        <div class="absolute text-xs font-bold border rounded-sm px-1 border-bluegray-900 bg-bluegray-900 text-white flex flex-col items-center justify-center" style="margin-top: 6.5rem; z-index: 234234234234;">
                            <h1 style="z-index: 123123;">234234</h1>
                            <div class="w-3 h-3 bg-bluegray-900 rounded-sm transform rotate-45 absolute mx-auto" style="top: -20%; z-index: 123;"></div>
                        </div>
                    </div>
                    <div class="flex flex-col uppercase items-start font-semibold text-bluegray-800 leading-none">
                        <div class="truncate text-base font-semibold">
                            <h1 class=""></h1>
                        </div>
                        <div class="truncate w-252 text-3xl">
                            <h1 id="equipoOT" class=""></h1>
                        </div>
                        <div class="truncate text-base font-semibold flex">
                            <h1 id="marcaHotel" class="mr-4"></h1>
                            <h1 id="nombreHotel" class="mr-4"></h1>
                            <h1 id="nombreVilla" class="mr-4"></h1>
                            <h1 id="nombreHabitacion" class="mr-4"></h1>
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
                            <div id="mediaOT" class="w-full flex flex-row flex-wrap justify-evenly"></div>
                        </div>
                    </div>
                </div>
                <div class="text-bluegray-900 border-4 border-bluegray-50 rounded-md w-full h-32 mt-4">
                    <textarea id="comentarioOT" class="text-xs font-semibold p-2 text-gray-700 focus:outline-none focus:shadow-outline-none uppercase w-full h-full" placeholder="Observaciones / Comentarios" disabled></textarea>
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
    <script src="js/OT_JS.js"></script>
</body>

</html>