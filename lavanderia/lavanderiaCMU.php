<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

    <title>MAPHG</title>
    <link rel=" shortcut icon" href="../svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/tailwindproduccion.css">
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">

</head>

<body class="h-screen">

    <!-- MENU -->
    <?php
    include 'navbartopJS.php';
    include 'menuJS.php';
    ?>
    <!-- MENU -->

    <!-- Page Content  -->
    <ul class="flex border-b p-2">
        <li class="-mb-px mr-1" onclick="graficos();">
            <a id="pestañaGraficos" class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">GRÁFICOS</a>
        </li>
        <li class="mr-1" onclick="camaras();">
            <a id="pestañaCamaras" class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">CÁMARAS</a>
        </li>
        <li class="mr-1" onclick="pendientes();">
            <a id="pestañaPendientes" class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">PENDIENTES ZIL</a>
        </li>
    </ul>

    <div id="graficos" class="grid grid-flow-col gap-2 p-2">

        <div id="CMU" class="hidden border">
            <iframe width="100%" height="100%" class="border" src="https://app.powerbi.com/view?r=eyJrIjoiMzgzM2YzYWYtMGY4NC00MTIzLThjNmQtN2ZhN2YxMDE0MmI1IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="RM" class="hidden border">
            <iframe id="" width="100%" height="100%" class="border" src="https://app.powerbi.com/view?r=eyJrIjoiM2QwY2QxNmQtNDI1Ny00ZTc0LTlhYTYtYTkxNTI3ZWJhYjYyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="SSA" class="hidden border">
            <iframe id="" width="100%" height="100%" class="border" src="https://app.powerbi.com/view?r=eyJrIjoiNDlhODU1ODktMTE1Mi00YWZmLWIxMDItM2EzNmY3YzE3OWE2IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="MBJ" class="hidden border">
            <iframe id="" width="100%" height="100%" class="border" src="https://app.powerbi.com/view?r=eyJrIjoiZjNkN2Y2M2QtNjNhMC00ZWU0LTljMmUtMTA5MzE1MTMwOWY5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="PVR" class="hidden border">
            <iframe id="" width="100%" height="100%" class="border" src="https://app.powerbi.com/view?r=eyJrIjoiNDhjYzE0MmEtMDViNi00YzVjLWE3MWQtYTM5ZDhkOGMxNjExIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="PUJ" class="hidden border">
            <iframe id="" width="100%" height="100%" class="border" src="https://app.powerbi.com/view?r=eyJrIjoiMzdhYjBmZjUtMDAzNi00ZWVkLWI3MjYtNGU2MGE1ODZiODk5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

    </div>


    <div id="camaras" class="flex items-center content-center grid grid-cols-2 gap-1 text-center pt-5">
        <div class="flex justify-end"><img src="https://i.gifer.com/757D.gif" width="45%" alt=""></div>
        <div class="flex justify-left"><img src="https://i.gifer.com/757D.gif" width="45%" alt=""></div>
        <div class="flex justify-end"><img src="https://i.gifer.com/757D.gif" width="45%" alt=""></div>
        <div class="flex justify-left"><img src="https://i.gifer.com/757D.gif" width="45%" alt=""></div>
    </div>

    <div id="pendientes" class="grid grid-flow-col grid-cols-1 grid-rows-1 h-screen">
        <iframe id="iframPendientes" class="h-screen" width="100%" frameborder="0" allowFullScreen="true"></iframe>
    </div>


    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/complemento_menuJS.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/alertasSweet.js"></script>

    <script>
        document.getElementById("destinosSelecciona").setAttribute('onclick', 'graficos();');
        document.getElementById("camaras").setAttribute('onclick', 'graficos();');
        document.getElementById("pendientes").setAttribute('onclick', 'graficos();');

        function botonMenu() {
            alertaImg('ACCESO DENEGADO', '', 'warning', 2500);
        }

        let destino = 7;

        if (destino == 7) {
            document.getElementById("destinoNavBarTop").innerHTML = 'CMU';
        } else if (destino == 1) {
            document.getElementById("destinoNavBarTop").innerHTML = 'RM';
        } else if (destino == 4) {
            document.getElementById("destinoNavBarTop").innerHTML = 'SSA';
        } else if (destino == 6) {
            document.getElementById("destinoNavBarTop").innerHTML = 'MBJ';
        } else if (destino == 2) {
            document.getElementById("destinoNavBarTop").innerHTML = 'PVR';
        } else if (destino == 5) {
            document.getElementById("destinoNavBarTop").innerHTML = 'PUJ';
        }


        function graficos() {

            document.getElementById("CMU").classList.add('hidden');
            document.getElementById("RM").classList.add('hidden');
            document.getElementById("SSA").classList.add('hidden');
            document.getElementById("MBJ").classList.add('hidden');
            document.getElementById("PVR").classList.add('hidden');
            document.getElementById("PUJ").classList.add('hidden');

            document.getElementById("graficos").classList.remove('hidden');
            document.getElementById("camaras").classList.add('hidden');
            document.getElementById("pendientes").classList.add('hidden');

            document.getElementById("pestañaGraficos").classList.add('border-l', 'border-t', 'border-r', 'rounded-t');
            document.getElementById("pestañaCamaras").classList.remove('border-l', 'border-t', 'border-r', 'rounded-t');
            document.getElementById("pestañaPendientes").classList.remove('border-l', 'border-t', 'border-r', 'rounded-t');

            document.getElementById("CMU").setAttribute('style', 'height:280px');
            document.getElementById("RM").setAttribute('style', 'height:280px');
            document.getElementById("SSA").setAttribute('style', 'height:280px');
            document.getElementById("MBJ").setAttribute('style', 'height:280px');
            document.getElementById("PVR").setAttribute('style', 'height:280px');
            document.getElementById("PUJ").setAttribute('style', 'height:280px');


            if (destino == 10) {
                document.getElementById("graficos").classList.remove('grid-cols-1', 'grid-rows-1');
                document.getElementById("graficos").classList.add('grid-cols-3', 'grid-rows-2');

                document.getElementById("CMU").classList.remove('hidden');
                document.getElementById("RM").classList.remove('hidden');
                document.getElementById("SSA").classList.remove('hidden');
                document.getElementById("MBJ").classList.remove('hidden');
                document.getElementById("PVR").classList.remove('hidden');
                document.getElementById("PUJ").classList.remove('hidden');
            } else if (destino == 7) {
                document.getElementById("CMU").setAttribute('style', 'height:650px');
                document.getElementById("CMU").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 1) {
                document.getElementById("RM").setAttribute('style', 'height:650px');
                document.getElementById("RM").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 4) {
                document.getElementById("SSA").setAttribute('style', 'height:650px');
                document.getElementById("SSA").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 6) {
                document.getElementById("MBJ").setAttribute('style', 'height:650px');
                document.getElementById("MBJ").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 2) {
                document.getElementById("PVR").setAttribute('style', 'height:650px');
                document.getElementById("PVR").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 5) {
                document.getElementById("PUJ").setAttribute('style', 'height:650px');
                document.getElementById("PUJ").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            }
        }


        // Función para mostrar la VISTA de CAMARAS
        function camaras() {
            document.getElementById("graficos").classList.add('hidden');
            document.getElementById("camaras").classList.remove('hidden');
            document.getElementById("pendientes").classList.add('hidden');

            document.getElementById("pestañaGraficos").classList.remove('border-l', 'border-t', 'border-r', 'rounded-t');
            document.getElementById("pestañaCamaras").classList.add('border-l', 'border-t', 'border-r', 'rounded-t');
            document.getElementById("pestañaPendientes").classList.remove('border-l', 'border-t', 'border-r', 'rounded-t');
        }


        // Función para mostrar la VISTA de PENDIENTES
        function pendientes() {

            document.getElementById("graficos").classList.add('hidden');
            document.getElementById("camaras").classList.add('hidden');
            document.getElementById("pendientes").classList.remove('hidden');

            document.getElementById("pestañaGraficos").classList.remove('border-l', 'border-t', 'border-r', 'rounded-t');
            document.getElementById("pestañaCamaras").classList.remove('border-l', 'border-t', 'border-r', 'rounded-t');
            document.getElementById("pestañaPendientes").classList.add('border-l', 'border-t', 'border-r', 'rounded-t');

            document.getElementById("iframPendientes").src = '../modalPendientes.php?idSeccion=11&tipoPendiente=MCS&idUsuario=0&idDestino=' + destino;
        }


        graficos();
    </script>


</body>

</html>