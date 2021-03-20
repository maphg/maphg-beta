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
    <link rel="stylesheet" href="css/animate.css">

</head>

<body class="relative">

    <!-- MENÚ -->
    <menu-menu></menu-menu>
    <menu-sidebar clases="z-20 sticky top-0 shadow-sm"></menu-sidebar>

    <!-- CONFIGURACIONES SIDEBAR -->
    <configuracion-telegram></configuracion-telegram>
    <menu-notificaciones clases="h-screen"></menu-notificaciones>
    <menu-favoritos clases="h-screen"></menu-favoritos>
    <menu-telegram clases="h-screen"></menu-telegram>
    <menu-agenda clases="h-screen"></menu-agenda>
    <!-- MENÚ -->

    <div id="btnConfiguraciones" class="absolute bg-blue-400 cursor-pointer rounded-full shadow-md text-center w-2/12 hidden">
        <ul class="text-white px-3 p-1 text-sm font-medium uppercase">
            <i class="fa fa-cogs"></i> MENÚ Opciones
        </ul>
    </div>

    <div class="flex flex-row">

        <div id="menuConfiguraciones" class="mr-2 w-2/12 py-1 px-3 rounded-md shadow mt-8 border border-gray-400 relative h-auto">

            <!-- GESTIÓN DE USUARIOS -->
            <ul id="btnGestionUsuarios" class="list-inside btn my-6 shadow-md hover:bg-rose-100 bg-blue-400 hover:bg-blue-500 text-white">
                <li>
                    <i class="fas fa-users fa-lg mx-2"></i>
                    Gestión de Usuarios
                </li>
            </ul>

            <!-- GESTIÓN DE CARGOS -->
            <ul id="btnGestionCargos" class="list-inside btn my-6 shadow-md hover:bg-rose-100 bg-blue-400 hover:bg-blue-500 text-white">
                <li>
                    <i class="fas fa-users fa-lg mx-2"></i>
                    Cargos
                </li>
            </ul>

            <!-- SECCIONES -->
            <ul class="list-inside btn my-6 shadow-md hover:bg-rose-100 bg-blue-400 hover:bg-blue-500 text-white">
                <li>
                    <i class="fas fa-list fa-lg mx-2"></i>
                    Secciones
                </li>
            </ul>

            <!-- SUBSECCIONES -->
            <ul class="list-inside btn my-6 shadow-md hover:bg-rose-100 bg-blue-400 hover:bg-blue-500 text-white">
                <li>
                    <i class="fas fa-list fa-lg mx-2"></i>
                    Subsecciones
                </li>
            </ul>

            <!-- DESTINOS -->
            <ul class="list-inside btn my-6 shadow-md hover:bg-rose-100 bg-blue-400 hover:bg-blue-500 text-white">
                <li>
                    <i class="fas fa-flag fa-lg mx-2"></i>
                    Destinos
                </li>
            </ul>

            <!-- ASIGNACION DE SUBSECCIONES A SECCIONES -->
            <ul class="list-inside btn my-6 shadow-md hover:bg-rose-100 bg-blue-400 hover:bg-blue-500 text-white">
                <li>
                    <i class="fas fa-arrows-h fa-lg mx-2"></i>
                    Asignaciones (Subsección -> Sección)
                </li>
            </ul>

            <!-- TIPO EQUIPOS -->
            <ul class="list-inside btn my-6 shadow-md hover:bg-rose-100 bg-blue-400 hover:bg-blue-500 text-white">
                <li>
                    <i class="fas fa-list-alt fa-lg mx-2"></i>
                    Tipo equipos
                </li>
            </ul>

            <!-- MARCA EQUIPOS -->
            <ul class="list-inside btn my-6 shadow-md hover:bg-rose-100 bg-blue-400 hover:bg-blue-500 text-white">
                <li>
                    <i class="fas fa-clipboard-list fa-lg mx-2"></i>
                    Marca equipos
                </li>
            </ul>

            <!-- SALIR DE LAS CONFIGURACIONES www.maphg.com -->
            <ul id="btnSalir" class="list-inside btn my-6 hover:text-red-700 absolute bottom-0 right-0  text-red-500">
                <li>
                    <i class="fas fa-sign-out-alt fa-3x mx-1"></i>
                </li>
            </ul>
            <!-- SALIR DE LAS CONFIGURACIONES www.maphg.com -->

        </div>

        <div id="columna2" class="w-10/12 mx-auto">

            <!-- GESTIÓN DE USUARIOS -->
            <div id="gestionUsuarios" class="rounded-md shadow mt-8 w-full mx-auto hidden">
                <div class="flex justify-star items-center relative container mx-auto py-3">

                    <div class="font-light text-xl ml-3 leading-none text-bluegray-600 mr-8">
                        <h1>Gestión Usuarios
                            <span id="load" class="text-center ml-4 text-2xl"></span>
                        </h1>
                    </div>

                    <div class="relative text-gray-600 w-72">
                        <input id="palabraUsuario" type="search" placeholder="Buscar Usuario" class="bg-white border border-gray-300 rounded mr-4 w-full text-gray-600 text-sm focus:outline-none focus:border-gray-400 px-2 h-10" autocomplete="off">
                    </div>

                    <button id="btnNuevoUsuario" class="btn btn-green mx-4 h-10 normal-case">
                        <i class="fas fa-user-plus fa-lg mx-1"></i> Agregar
                    </button>

                </div>

                <div class="container mx-auto shadow rounded overflow-auto scrollbar" style="max-height: 75vh;">
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
            </div>
            <!-- GESTIÓN DE USUARIOS -->

            <!-- GESTIÓN DE CARGOS -->
            <div id="cargosUsuarios" class="ounded-md shadow mt-8 w-full mx-auto hidden">

                <div class="flex justify-star items-center relative container mx-auto py-3">

                    <div class="font-light text-xl ml-3 leading-none text-bluegray-600 mr-8">
                        <h1>Gestión Cargos
                            <span id="loadCargos" class="text-center ml-4 text-2xl"></span>
                        </h1>
                    </div>

                    <div class="relative text-gray-600 w-72">
                        <input id="palabraCargos" type="search" placeholder="Buscar Cargo" class="bg-white border border-gray-300 rounded mr-4 w-full text-gray-600 text-sm focus:outline-none focus:border-gray-400 px-2 h-10" autocomplete="off">
                    </div>

                    <button id="btnNuevoCargo" class="btn btn-green mx-4 h-10 normal-case">
                        <i class="fas fa-user-plus fa-lg mx-1"></i> Agregar
                    </button>

                </div>

                <div class="container mx-auto shadow rounded overflow-auto scrollbar" style="max-height: 75vh;">
                    <table class="min-w-full divide-y divide-gray-200 sortable mx-auto rounded">
                        <thead class="bg-gray-200 cursor-pointer ">
                            <tr>
                                <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                    ID
                                </th>

                                <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                    Cargo
                                </th>

                                <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                    Asignados
                                </th>

                                <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                    Status
                                </th>

                                <th scope="col" class="px-6 py-3 bg-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                    <span class="sr-only">Edit</span>
                                </th>

                            </tr>
                        </thead>
                        <tbody id="dataTablaCargos" class="bg-white divide-y divide-gray-200"></tbody>
                    </table>
                </div>
            </div>
            <!-- GESTIÓN DE CARGOS -->

        </div>

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
                                <input autocomplete="off" type="text" id="nombreUsuarioGU" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Apellidos</label>
                                <input autocomplete="off" type="text" id="apellidoUsuarioGU" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="correoUsuario" class="block text-sm font-medium text-gray-700">Correo</label>
                                <input autocomplete="off" type="email" id="correoUsuarioGU" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                <div id="labelCorreoUsuario"></div>
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="telefono" class="block text-sm font-medium text-gray-700">Telefono</label>
                                <input autocomplete="off" type="text" id="telefonoUsuarioGU" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
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
                            <input id="usuarioUsuarioGU" autocomplete="off" type="text" id="postal_code" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-7 sm:col-span-7 lg:col-span-7 mx-5 my-2">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">Contraseña</label>
                            <div class="flex flex-row">
                                <input id="contraseñaUsuarioGU" type="password" class="border border-blue-200 p-1 mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-auto sm:text-sm border-gray-300 rounded-md">
                                <i id="contraseñaEyesGU" class="fa far fa-eye-slash p-2 mx-2 mt-1"></i>
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

    <!-- MODAL PARA EDITAR CARGOS -->
    <div id="modalEditarCargos" class="modal">
        <div class="modal-window rounded-md" style="width: 750px;">
            <h1 class="text-center text-blue-400 font-semibold uppercase py-1">
                Gestión de Cargos</h1>

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalEditarCargos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="md:mt-0 md:col-span-2">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-3 py-5 bg-white sm:p-3">

                        <div class="grid grid-cols-8 gap-6">

                            <div class="col-span-6 sm:col-span-4">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">Cargo</label>
                                <input id="inputCargo" autocomplete="off" type="text" class="border border-blue-200 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md py-2 px-2">
                            </div>

                            <div class="col-span-2 sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Status
                                </label>

                                <div class="inline-block relative">
                                    <select id="statusCargo" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-2 py-2 pr-8 rounded  leading-tight focus:outline-none">
                                        <option value="ACTIVO">ACTIVO </option>
                                        <option value="BAJA">BAJA</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="col-span-2 sm:col-span-2">
                                <button id="btnGuardarCargo" class="bg-blue-500 hover:bg-blue-700 text-white font-bold my-4 py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button">
                                    Guardar
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA EDITAR CARGOS -->

    <script src="js/alertify.min.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/sorttable.js"></script>
    <script src="js/gestion_configuraciones.js"></script>
    <script src="js/funciones_tablas.js"></script>

    <!-- MENU JS -->
    <script src="js/menu.js" type="text/javascript"></script>
    <!-- MENU JS -->
</body>

</html>