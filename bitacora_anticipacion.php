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

        <div class="flex flex-row justify-center items-center w-auto mt-4 mx-2">
            <!-- ESPACIO DEL WIDGET -->
            <div class="inline-block w-auto relative">
                <select id="opcion" class="block appearance-none w-full bg-white border border-grey-light hover:border-grey px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline font-black text-gray-700" value="ANTICIPACION" onclick="llamarFuncion('consumoDia'); llamarFuncion('consultaAcontecimientos'); llamarFuncion('consultaAcontecimientosSemana');">
                    <option value="ZI">ZI</option>
                    <option value="GP">GP</option>
                    <option value="TRS">TRS</option>
                    <option value="ENERGETICOS">ENERGETICOS</option>
                    <option value="ANTICIPACION">ANTICIPACIÓN</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
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
    <script src="js/refreshSession.js"></script>
</body>

<script>
    document.getElementById("opcion").value = 'ANTICIPACION';

    document.getElementById("opcion").addEventListener('change', () => {
        let zona = document.getElementById("opcion").value;
        if (zona == "ENERGETICOS") {
            location.href = "bitacora-energeticos.php";
        } else if (zona == "ANTICIPACION") {
            location.href = "bitacora_anticipacion.php";
        } else {
            location.href = "bitacora_mantto.php";
        }
    })
</script>

</html>