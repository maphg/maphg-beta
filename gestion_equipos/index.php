<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de Equipos</title>
    <link rel="stylesheet" href="../css/tailwindproduccion.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/modales.css">
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/alertify.min.css">
</head>

<body class="bg-fondos-7 text-bluegray-800">
    <div class="flex flex-col container mx-auto py-10 font-light text-3xl">
        <h1>Equipos y Locales</h1>
    </div>


    <div class="flex flex-row container mx-auto text-base mb-6">
        <input id="filtroPalabra" type="search" name="" placeholder="Buscar Equipo o local" class="w-1/4 px-3 bg-white focus:outline-none py-2 rounded-lg shadow-md">

        <!-- <button class="btn btn-indigo shadow-md mx-4">
            <i class="fas fa-plus"></i>
            Crear Equipo o Local
        </button> -->


        <div class="w-3/4 px-3 flex flex-row">

            <select id="filtroDestino" class="border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white w-1/6">
                <option value="0">Destino</option>
            </select>

            <select id="filtroSeccion" class="border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white w-1/6">
                <option value="0">Sección</option>
            </select>

            <select id="filtroSubseccion" class="border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white w-1/6">
                <option value="0">Subsección</option>
            </select>

            <select id="filtroTipo" class="border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white w-1/6">
                <option value="0">Tipo</option>
                <option value="EQUIPO">EQUIPO</option>
                <option value="LOCAL">LOCAL</option>
            </select>

            <select id="filtroStatus" class="border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white w-1/6">
                <option value="0">Status</option>
                <option value="OPERATIVO">OPERATIVO</option>
                <option value="BAJA">BAJA</option>
                <option value="TALLER">TALLER</option>
            </select>

            <select id="filtroSemana" class="border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white w-1/6">
                <option value="0">Semana</option>
            </select>

        </div>
    </div>


    <div class="flex flex-col container mx-auto scrollbar">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 scrollbar">
            <div class="align-middle inline-block min-w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 scrollbar" style="max-height: 80vh;">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="cursor-pointer">
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Destino
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Sección
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Subsección
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Equipo
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Tipo equipo/local
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Marca Modelo
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Ubicacion
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Ultimo MP
                            </th>

                        </tr>
                    </thead>
                    <tbody id="contenedorDePlanes" class="bg-white divide-y divide-gray-200">
                        <!-- More rows... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- LIBRERIAS JS -->
    <script src="../js/alertify.min.js"></script>
    <script src="../js/alertasSweet.js"></script>
    <script src="js/gestion_equipos.js"></script>
    <!-- <script src="js/qrcode.min.js"></script> -->
    <!-- <script src="js/despiece.js"></script> -->
</body>

</html>