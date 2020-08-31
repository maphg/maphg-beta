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
    <link rel=" shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">

</head>

<body>

    <!-- MENU -->
    <?php
    include 'navbartopJS.php';
    include 'menuJS.php';
    ?>
    <!-- MENU -->

    <!-- Page Content  -->
    <ul class="flex border-b p-2">
        <li class="-mb-px mr-1" onclick="graficos();">
            <a id="pestañaGraficos" class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">Gráficos</a>
        </li>
        <li class="mr-1" onclick="camaras();">
            <a id="pestañaCamaras" class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">Camaras</a>
        </li>
        <li class="mr-1" onclick="pendientes();">
            <a id="pestañaPendientes" class="bg-white inline-block py-2 px-4 text-blue-500 hover:text-blue-800 font-semibold" href="#">Pendientes</a>
        </li>
    </ul>

    <div id="graficos" class="grid grid-flow-col grid-cols-3 grid-rows-2 gap-4 p-4">

        <div id="CMU" class="hidden">
            <iframe width="100%" height="450" src="https://app.powerbi.com/view?r=eyJrIjoiMzgzM2YzYWYtMGY4NC00MTIzLThjNmQtN2ZhN2YxMDE0MmI1IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="RM" class="hidden">
            <iframe id="" width="100%" height="450" src="https://app.powerbi.com/view?r=eyJrIjoiM2QwY2QxNmQtNDI1Ny00ZTc0LTlhYTYtYTkxNTI3ZWJhYjYyIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="SSA" class="hidden">
            <iframe id="" width="100%" height="450" src="https://app.powerbi.com/view?r=eyJrIjoiNDlhODU1ODktMTE1Mi00YWZmLWIxMDItM2EzNmY3YzE3OWE2IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="MBJ" class="hidden">
            <iframe id="" width="100%" height="450" src="https://app.powerbi.com/view?r=eyJrIjoiZjNkN2Y2M2QtNjNhMC00ZWU0LTljMmUtMTA5MzE1MTMwOWY5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="PVR" class="hidden">
            <iframe id="" width="100%" height="450" src="https://app.powerbi.com/view?r=eyJrIjoiNDhjYzE0MmEtMDViNi00YzVjLWE3MWQtYTM5ZDhkOGMxNjExIiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

        <div id="PUJ" class="hidden">
            <iframe id="" width="100%" height="450" src="https://app.powerbi.com/view?r=eyJrIjoiMzdhYjBmZjUtMDAzNi00ZWVkLWI3MjYtNGU2MGE1ODZiODk5IiwidCI6IjAzMDQ5MzNhLTA1YTItNDEwZC1iMjc5LWEyYTRhNTUxYTNlYSIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
        </div>

    </div>


    <div id="camaras" class="p-4">
        No Disponible
    </div>

    <div id="pendientes" class="grid grid-flow-col grid-cols-1 grid-rows-1">
        <iframe id="iframPendientes" width="100%" height="500" frameborder="0" allowFullScreen="true"></iframe>
    </div>


    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/complemento_menuJS.js"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/alertasSweet.js"></script>

    <script>
        document.getElementById("destinosSelecciona").setAttribute('onclick', 'graficos();');
        document.getElementById("camaras").setAttribute('onclick', 'graficos();');
        document.getElementById("pendientes").setAttribute('onclick', 'graficos();');

        // Función para mostrar la VISTA de GRAFICOS
        function graficos() {
            console.log("Gráficos");
            let destino = localStorage.getItem('idDestino');

            document.getElementById("graficos").classList.remove('hidden');
            document.getElementById("camaras").classList.add('hidden');
            document.getElementById("pendientes").classList.add('hidden');

            document.getElementById("pestañaGraficos").classList.add('bg-blue-200');
            document.getElementById("pestañaCamaras").classList.remove('bg-blue-200');
            document.getElementById("pestañaPendientes").classList.remove('bg-blue-200');

            document.getElementById("CMU").classList.add('hidden');
            document.getElementById("RM").classList.add('hidden');
            document.getElementById("SSA").classList.add('hidden');
            document.getElementById("MBJ").classList.add('hidden');
            document.getElementById("PVR").classList.add('hidden');
            document.getElementById("PUJ").classList.add('hidden');
            if (destino == 10) {
                document.getElementById("CMU").classList.remove('hidden');
                document.getElementById("RM").classList.remove('hidden');
                document.getElementById("SSA").classList.remove('hidden');
                document.getElementById("MBJ").classList.remove('hidden');
                document.getElementById("PVR").classList.remove('hidden');
                document.getElementById("PUJ").classList.remove('hidden');
                document.getElementById("graficos").classList.add('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.remove('grid-cols-1', 'grid-rows-1');
            } else if (destino == 7) {
                document.getElementById("CMU").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 1) {
                document.getElementById("RM").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 4) {
                document.getElementById("SSA").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 6) {
                document.getElementById("MBJ").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 2) {
                document.getElementById("PVR").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            } else if (destino == 5) {
                document.getElementById("PUJ").classList.remove('hidden');
                document.getElementById("graficos").classList.remove('grid-cols-3', 'grid-rows-2');
                document.getElementById("graficos").classList.add('grid-cols-1', 'grid-rows-1');
            }
        }


        // Función para mostrar la VISTA de CAMARAS
        function camaras() {
            console.log("camaras");
            document.getElementById("graficos").classList.add('hidden');
            document.getElementById("camaras").classList.remove('hidden');
            document.getElementById("pendientes").classList.add('hidden');

            document.getElementById("pestañaGraficos").classList.remove('bg-blue-200');
            document.getElementById("pestañaCamaras").classList.add('bg-blue-200');
            document.getElementById("pestañaPendientes").classList.remove('bg-blue-200');
        }


        // Función para mostrar la VISTA de PENDIENTES
        function pendientes() {

            let idDestino = localStorage.getItem('idDestino');
            let idUsuario = localStorage.getItem('usuario');
            console.log('Usuario:' + idUsuario, 'Desitno:' + idDestino)

            document.getElementById("graficos").classList.add('hidden');
            document.getElementById("camaras").classList.add('hidden');
            document.getElementById("pendientes").classList.remove('hidden');

            document.getElementById("pestañaGraficos").classList.remove('bg-blue-200');
            document.getElementById("pestañaCamaras").classList.remove('bg-blue-200');
            document.getElementById("pestañaPendientes").classList.add('bg-blue-200');

            document.getElementById("iframPendientes").src = 'http://maphg.com/beta/modalPendientes.php?idSeccion=11&tipoPendiente=MCS&idUsuario=' + idUsuario + '&idDestino=' + idDestino;
        }


        graficos();
    </script>


</body>

</html>