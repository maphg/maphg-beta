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
                    <div class="text-bluegray-900 border-4 border-bluegray-50 rounded-md w-full h-auto mt-4 flex flex-col">
                        <div class="font font-semibold text-bluegray-700 p-2 flex uppercase text-justify justify-center">
                            <div class="flex justify-center items-center">
                                <h1>VIDRIOS-SUMINISTRO DE PIEZA EN FORMA DE DIAMETRO DE.CRISTAL TEMPLADO 10MM PARA A </h1>
                            </div>
                            <div class="bg-red-200 text-red-500 flex justify-center items-center p-2 rounded-md ml-2">
                                <h1>$12312234</h1>
                            </div>
                        </div>
                        <div class="p-2 text-justify font-medium text-bluegray-700">
                            <h1>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iste error debitis autem sapiente laudantium odit recusandae, adipisci ipsa voluptas tempore, beatae placeat veniam, harum maxime delectus ex. Vitae, officiis quam.</h1>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-40 h-40 rounded-md overflow-hidden flex-none m-2">
                                <img src="https://www.maphg.com/beta/planner/proyectos/planaccion/PLANACCION_ID_2883_358flamingariocol2.jpg" class="h-full" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/html2canvas.js"></script>
    <script src="../js/exportarPdf.js"></script>
    <script src="js/generar_reporte_proyectos.js"></script>
</body>

</html>