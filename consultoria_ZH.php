<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG</title>
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/modales.css">
</head>

<body class="bg-orange-400 h-screen scrollbar">
    <!-- MENÚ -->
    <menu-menu></menu-menu>
    <menu-sidebar clases="z-10 sticky top-0 shadow-sm"></menu-sidebar>

    <!-- MODAL CONFIGURACIÓN TELEGRAM -->
    <configuracion-telegram></configuracion-telegram>

    <!-- MENÚ -->

    <div class="flex flex-col md:flex-row">
        <div class="w-1/2 h-0 md:h-screen flex flex-col items-center justify-center">
            <div class="bg-white w-40 h-40 rounded-full flex items-center justify-center">
                <div class="text-orange-700 bg-orange-400 font-medium flex justify-center items-center shadow-md rounded-lg text-2xl w-20 h-20">
                    <h1 class="">ZH</h1>
                </div>
            </div>
            <h1 class="font-bold text-3xl text-orange-700">CONSULTORÍA</h1>
        </div>
        <iframe class="w-full md:w-1/2 h-screen pb-20" src="https://chatbro.com/86j9T" frameborder="0"></iframe>
    </div>

    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/alertasSweet.js"></script><script src="js/menu.js" type="text/javascript"></script>
</body>

</html>