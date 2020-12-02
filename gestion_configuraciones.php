<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG Configuraciones</title>
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">

</head>

<body class="p-1">

    <div class="flex justify-star items-center mb-5 relative container mx-auto mt-10">

        <div class="font-light text-xl ml-3 leading-none text-bluegray-600 mr-8">
            <h1>Gestión Usuarios
                <span id="load" class="text-center ml-4 text-2xl"></span>
            </h1>
        </div>

        <div class="relative text-gray-600 w-72">
            <input id="palabraUsuario" type="search" placeholder="Buscar Usuario" class="bg-white border border-gray-300 rounded mr-4 w-full text-gray-600 text-sm focus:outline-none focus:border-gray-400 px-2 h-10" autocomplete="off">
        </div>

        <button id="btnNuevoUsuario" class="btn btn-green mx-4 h-10 normal-case">
            <i class="fas fa-user-plus fa-lg mx-1"></i> Agrear
        </button>

    </div>

    <div class="container mx-auto shadow rounded overflow-auto scrollbar" style="max-height: 80vh;">
        <table class="min-w-full divide-y divide-gray-200 sortable mx-auto rounded">
            <thead class="bg-gray-200 cursor-pointer ">
                <tr>
                    <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                        Avatar
                    </th>
                    <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                        Nombre
                    </th>

                    <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                        Cargo
                    </th>

                    <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                        Rol
                    </th>

                    <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10 sm:hidden md:block lg:block xl:block 2xl:block">
                        Secciónes Asignadas
                    </th>

                    <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                        Fase
                    </th>

                    <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                        Status
                    </th>

                    <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                        <span class="sr-only">Edit</span>
                    </th>
                </tr>
            </thead>
            <tbody id="dataUsuarios" class="bg-white divide-y divide-gray-200"></tbody>
        </table>
    </div>


    <!-- MODAL PARA EDITAR USUARIO -->
    <div id="modalEditarUsuario" class="modal">
        <div class="modal-window rounded-md" style="width: 750px;">

            <h1 class="text-center text-blue-400 font-semibold uppercase">
                Gestión de Usuarios</h1>

            <div class="md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">

                        <div class="grid grid-cols-8 gap-6">

                            <div class="col-span-6 sm:col-span-4">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                                <input autocomplete="off" type="text" id="nombreUsuario" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                <input autocomplete="off" type="text" id="apellidoUsuario" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="correoUsuario" class="block text-sm font-medium text-gray-700">Correo</label>
                                <input autocomplete="off" type="email" id="correoUsuario" name="correoUsuario" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <div id="labelCorreoUsuario"></div>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="telefono" class="block text-sm font-medium text-gray-700">Telefono</label>
                                <input autocomplete="off" type="text" id="telefonoUsuario" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>

                        <div id="datosComplementariosUsuario" class="w-full grid grid-cols-8 gap-6 mt-4 hidden">

                            <!-- FASES -->
                            <div class="col-span-5 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700"> Fases</label>
                                <div class="relative inline-block text-left">
                                    <div onclick="toggleHidden('fasestoggle');">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" aria-haspopup="true" aria-expanded="true">
                                            Multi Selección
                                            <!-- Heroicon name: chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="fasestoggle" class="origin-top-right absolute right-0 mt-2 w-24 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 cursor-pointer z-10 hidden">
                                        <div id="dataFases" class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SECCIONES -->
                            <div class="col-span-5 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700"> Secciones</label>
                                <div class="relative inline-block text-left">
                                    <div onclick="toggleHidden('seccionestoggle');">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" aria-haspopup="true" aria-expanded="true">
                                            Multi Selección
                                            <!-- Heroicon name: chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="seccionestoggle" class="origin-top-right absolute right-0 mt-2 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 cursor-pointer z-10 hidden">
                                        <div id="dataSecciones" class="py-1 overflow-y-auto scrollbar" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="max-height:200px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- DESTINOS -->
                            <div class="col-span-5 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700"> Destinos</label>
                                <div class="relative inline-block text-left">
                                    <div onclick="toggleHidden('destinostoggle');">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" aria-haspopup="true" aria-expanded="true">
                                            Multi Selección
                                            <!-- Heroicon name: chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="destinostoggle" class="origin-top-right absolute right-0 mt-2 w-24 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 cursor-pointer z-10 hidden">
                                        <div id="dataDestinos" class="py-1 overflow-y-auto scrollbar" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="max-height:200px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- CARGO -->
                            <div class="col-span-5 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Cargo</label>
                                <div class="relative inline-block text-left">
                                    <div onclick="toggleHidden('cargotoggle');">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" aria-haspopup="true" aria-expanded="true">
                                            Multi Selección
                                            <!-- Heroicon name: chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="cargotoggle" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 cursor-pointer z-10 hidden">
                                        <div id="dataCargos" class="py-1 overflow-y-auto scrollbar" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="max-height:200px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ROL -->
                            <div class="col-span-5 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Rol</label>
                                <div class="relative inline-block text-left">
                                    <div onclick="toggleHidden('roltoggle');">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" aria-haspopup="true" aria-expanded="true">
                                            Multi Selección
                                            <!-- Heroicon name: chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="roltoggle" class="origin-top-right absolute right-0 mt-2 w-30 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 cursor-pointer z-10 hidden">
                                        <div id="dataRoles" class="py-1 overflow-y-auto scrollbar" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="max-height:200px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div class="col-span-5 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="relative inline-block text-left">
                                    <div onclick="toggleHidden('statustoggle');">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" aria-haspopup="true" aria-expanded="true">
                                            Multi Selección
                                            <!-- Heroicon name: chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="statustoggle" class="origin-top-right absolute right-0 mt-2 w-30 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 cursor-pointer z-10 hidden">
                                        <div id="dataStatus" class="py-1 overflow-y-auto scrollbar" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="max-height:200px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- PERMISOS SUBALMACÉN -->
                            <div class="col-span-5 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700"> Opción Subalmacenes</label>
                                <div class="relative inline-block text-left">
                                    <div onclick="toggleHidden('opcionSubalmacenestoggle');">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" aria-haspopup="true" aria-expanded="true">
                                            Multi Selección
                                            <!-- Heroicon name: chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="opcionSubalmacenestoggle" class="origin-top-right absolute right-0 mt-2 w-30 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 cursor-pointer hidden">
                                        <div id="dataOpcionSubalmacenes" class="py-1 overflow-y-auto scrollbar" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="max-height:150px">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SUBALMACENES -->
                            <div class="col-span-5 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Subalmacenes</label>
                                <div class="relative inline-block text-left">
                                    <div onclick="toggleHidden('subalmacenestoggle');">
                                        <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" aria-haspopup="true" aria-expanded="true">
                                            Multi Selección
                                            <!-- Heroicon name: chevron-down -->
                                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>

                                    <div id="subalmacenestoggle" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 cursor-pointer z-10 hidden">
                                        <div id="dataSubalmacenes" class="py-1 overflow-y-auto scrollbar" role="menu" aria-orientation="vertical" aria-labelledby="options-menu" style="max-height:125px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex flex-row items-center justify-center w-full">
                        <div class="col-span-7 sm:col-span-7 lg:col-span-7 mx-5 my-2">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">Usuario</label>
                            <input id="usuarioUsuario" autocomplete="off" type="text" id="postal_code" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-7 sm:col-span-7 lg:col-span-7 mx-5 my-2">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <div class="flex flex-row">
                                <input id="contraseñaUsuario" type="password" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md">
                                <i id="contraseñaEyes" class="fa far fa-eye-slash p-2 mx-2 mt-1"></i>
                            </div>
                        </div>

                        <div class="col-span-7 sm:col-span-7 lg:col-span-7 mx-5 my-2 text-center">
                            <label class="block text-sm font-medium text-gray-700">Notifiaciones</label>
                            <i id="checkNotificaciones" class="fad fa-toggle-on fa-2x px-2 mx-2 text-center text-blue-400"></i>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-center items-center">
                        <button id="btnGuardarUsuario" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mx-2">
                            Guardar
                        </button>
                        <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm
                            font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-red-500 mx-2" onclick=" cerrarmodal('modalEditarUsuario');">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA EDITAR USUARIO -->

</body>
<script src="js/alertify.min.js"></script>
<script src="js/alertasSweet.js"></script>
<script src="js/modales.js"></script>
<script src="js/sorttable.js"></script>
<script src="js/gestion_configuraciones.js"></script>
<script src="js/funciones_tablas.js"></script>

</html>