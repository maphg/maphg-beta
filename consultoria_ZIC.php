<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/alertify.min.css">
</head>

<body class="bg-red-400">
    <?php
    include 'navbartopJS.php';
    include 'menuJS.php';
    ?>

    <div class="flex flex-col md:flex-row">
        <div class="w-1/2 h-0 md:h-screen flex flex-col items-center justify-center">
            <div class="bg-white w-40 h-40 rounded-full flex items-center justify-center">
                <div class="text-red-700 bg-red-400 font-medium flex justify-center items-center shadow-md rounded-lg text-2xl w-20 h-20">
                    <h1 class="">ZIC</h1>
                </div>
            </div>
            <h1 class="font-bold text-3xl text-red-700">CONSULTORÍA</h1>
        </div>
        <iframe class="w-full md:w-1/2 h-screen" src="https://chatbro.com/76j9S" frameborder="0"></iframe>
    </div>

    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/complemento_menuJS.js"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/alertasSweet.js"></script>
</body>

</html>