<!DOCTYPE html>
<html lang="Es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas</title>
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

    </div>
    <div id="33" class="">
        <div class="flex flex-col items-center justify-start bg-white pt-3 px-4 overflow-oculto mt-1 relative rounded h-auto" style="width: 1223px; z-index: 888;">
            <div class="flex flex-col justify-center items-start w-full relative">
                <div class="flex flex-row justify-between items-center w-252">

                    <!-- BADGE DEL LOGO -->
                    <div class=" flex flex-col items-center justify-center">
                        <div class="w-12">
                            <img src="../svg/logo-maphg.png" alt="">
                        </div>
                    </div>
                    <!-- BADGE DEL LOGO -->
                    <!-- DESTINO SECCION Y SUBSECCION -->
                    <div class="flex flex-row flex-none">
                        <div id="claseSeccion" class="zic-logo relative">
                            <h1 id="seccion" class=""></h1>
                        </div>
                        <div class="flex flex-col justify-center items-start ml-1">
                            <div class="font-semibold text-sm px-1 rounded  text-bluegray-900 mb-1 flex justify-start items-center">
                                <h1 id="destino" class="font-bold"></h1>
                            </div>
                            <div class="font-semibold text-sm px-1 rounded  text-bluegray-900 flex justify-start items-center">
                                <h1 class="font-bold">PROYECTOS</h1>
                            </div>
                        </div>
                    </div>
                    <!-- DESTINO SECCION Y SUBSECCION -->
                    <div class="flex flex-col uppercase items-start font-semibold text-bluegray-800 leading-none">

                        <div class="text-2xl flex-none">
                            <h1 id="proyecto" class=""></h1>
                        </div>
                        <div class="text-base font-semibold flex-none">
                            <h1 id="cantidadActividades" class="mr-4"></h1>
                        </div>
                    </div>

                </div>

                <!-- LISTA DE ACTIVIDADES A REALIZAR -->
                <div id="dataActividades" class="w-full">
                </div>
            </div>
        </div>
    </div>
    <script src="../js/html2canvas.js"></script>
    <script src="../js/exportarPdf.js"></script>
    <script src="js/generar_reporte_proyectos.js"></script>
</body>

</html>