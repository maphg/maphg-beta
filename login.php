<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG LOGIN</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion_2021.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/alertify.min.css">
</head>

<body style="background-color: #EEF0FC;">
    <div class="w-full h-screen flex items-center md:justify-center md:pl-20 justify-center">
        <div class="bg-white w-80 h-132 rounded-3xl shadow-lg flex flex-col justify-evenly p-4 z-40 overflow-hidden">
            <div class="w-full justify-center items-center flex">
                <img class="w-32" src="svg/lineal_animated.svg" srcset="svg/lineal_animated.svg" alt="">
            </div>
            <div>
                <input id="inputusuario" type="text" placeholder="Usuario" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-bluegray-300" style="background-color: #F4F5F7;">
                <div class="flex flex-row items-center">
                    <input id="inputcontraseña" type="password" placeholder="Contraseña" class="focus:outline-none focus:ring p-2 w-full rounded-md mb-2 ring-bluegray-300" style="background-color: #F4F5F7;">
                    <i id="icono" class="fas fa-eye-slash"></i>
                </div>
                <button id="btnIniciarSession" class="focus:outline-none focus:ring bg-gray-600 text-gray-50 p-2 w-full rounded-md mb-2 cursor-pointer ring-lime-300">Entrar</button>
                <div class="text-xs w-full text-center text-gray-400 hover:text-blue-300">
                    <a href="#">Olvidé mi contraseña</a>
                </div>
            </div>
        </div>
    </div>

    <script src="js/alertify.min.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script src="js/usuariosJS.js"></script>
</body>

</html>