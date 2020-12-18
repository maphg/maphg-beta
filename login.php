<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG</title>
    <link rel="stylesheet" href="css/tailwind.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="icon" href="svg/logo6.png">
    <link rel="stylesheet" href="css/alertify.min.css">
</head>

<body>
    <div class="flex flex-row justify-center items-center w-screen h-screen bg-gray-200">
        <div class="w-full p-12 absolute flex justify-center">
            <form class="animated fadeIn delay-4s bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 max-w-sm flex flex-col items-center justify-center">
                <div class="flex justify-center items-center mb-4 absolute top-0 bg-black shadow-lg rounded-full w-20 h-20">
                    <img src="svg/logo-white2.svg" class="w-32 text-center" alt="">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-800 text-sm font-bold mb-2" for="username">
                        Usuario
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="inputusuario" type="text" placeholder="Usuario">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-800 text-sm font-bold mb-2" for="password">
                        Contraseña
                    </label>
                    <input class="shadow appearance-none border rounded py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" id="inputcontrasena" type="password" placeholder="******************" onkeyup="if(event.keyCode == 13) validarUsuario('');">
                    <i id="icono" class="fas fa-eye-slash"></i>
                </div>
                <div class="flex items-center justify-center">
                    <button class="bg-black hover:bg-gray-300 hover:text-gray-900 text-white w-12 h-12 rounded-full focus:outline-none focus:shadow-outline" type="button" onclick="validarUsuario();">
                        <i class="fad fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="js/usuariosJS.js"></script>
    <script>
        document.getElementById("icono").addEventListener("click", () => {
            let icono = document.getElementById("icono");
            let contraseña = document.getElementById("inputcontrasena");
            if (icono.classList.contains("fa-eye-slash")) {
                icono.className = 'fas fa-eye';
                contraseña.setAttribute('type', 'text');
            } else {
                icono.className = 'fas fa-eye-slash';
                contraseña.setAttribute('type', 'password');
            }
        })
    </script>
</body>

</html>