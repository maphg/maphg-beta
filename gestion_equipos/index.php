<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>MAPHG Gestion Equipos</title>
    <link rel="stylesheet" href="../css/tailwindproduccion.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/modales.css">
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="../css/planner_cols.css">
</head>

<body class="bg-fondos-7 text-bluegray-800">
    <div class="flex flex-col container mx-auto py-10 font-light text-3xl">
        <h1>Equipos y Locales</h1>
    </div>


    <div class="flex flex-row container mx-auto text-base mb-6">
        <input id="filtroPalabra" type="search" name="" placeholder="Buscar Equipo o local" class="w-1/4 px-3 mr-6 bg-white focus:outline-none py-2 rounded-lg shadow-md">

        <!-- <button class="btn btn-indigo shadow-md mx-4">
            <i class="fas fa-plus"></i>
            Crear Equipo o Local
        </button> -->

        <div id="verGANTT" class="py-1 cursor-pointer px-3 hover:bg-indigo-200 bg-indigo-100 text-indigo-500">
            <h1>
                <i class="fas fa-tasks-alt mr-2"></i>VER GANTT
            </h1>
        </div>
        <div id="exportarPendientes" class="py-1 cursor-pointer px-3 rounded-r hover:bg-teal-200 bg-teal-100 text-teal-500">
            <h1>
                <i class="fas fa-arrow-to-bottom mr-2"></i>EXPORTAR
            </h1>
        </div>
    </div>

    <div class="flex flex-row container mx-auto text-base mb-6">
        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Destinos</h1>
            <div class="relative ">
                <select id="filtroDestino" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                </select>
            </div>
        </div>

        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Secciones</h1>
            <div class="relative">
                <select id="filtroSeccion" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                    <option value="0">Sección</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Subsecciones</h1>
            <div class="relative">
                <select id="filtroSubseccion" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                    <option value="0">Subsección</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Tipo</h1>
            <div class="relative">
                <select id="filtroTipo" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                    <option value="0">Tipo</option>
                    <option value="EQUIPO">EQUIPO</option>
                    <option value="LOCAL">LOCAL</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Status</h1>
            <div class="relative">
                <select id="filtroStatus" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                    <option value="0">Status</option>
                    <option value="OPERATIVO">OPERATIVO</option>
                    <option value="BAJA">BAJA</option>
                    <option value="TALLER">TALLER</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Semana</h1>
            <div class="relative">
                <select id="filtroSemana" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                    <option value="0">Semana</option>
                </select>
            </div>
        </div>

    </div>

    <div class="flex flex-col items-star lg:items-center mx-auto scrollbar">
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
                                Proximo MP
                            </th>

                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                Resumen MP
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




    <!-- ***** MODALES PRINCIPALES ***** -->

    <!-- MODAL EQUIPO PARA LOS MP-->
    <div id="modalMPEquipo" class="modal relative">
        <div class="modal-window flex shadow-lg flex-col justify-center items-center text-bluegray-800 pt-10 rounded-lg " style="width: 1000px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMPEquipo')" class="cursor-pointer text-md  text-red-500 bg-red-200 px-2 rounded-bl-lg rounded-tr-lg font-normal shadow-md">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-lg rounded-tl-lg">
                    <h1>INFORMACIÓN DEL EQUIPO</h1>
                </div>
            </div>

            <!-- ENCABEZADO -->
            <div class="flex flex-row w-full justify-start px-4 relative">
                <div class="font-bold text-xl flex flex-col justify-center items-center uppercase truncate w-full text-center">
                    <input id="nombreEquipo" type="text" class="font-bold text-xl flex flex-col justify-center items-center uppercase truncate w-full text-center bg-white" value="Maquina de hielo edificio 1226 grand palladium">
                    <div class="flex mt-1">

                        <div class="flex items-center text-xs font-bold text-green-400 px-1 bg-green-100 rounded-full w-auto cursor-pointer mr-4">
                            <i class="fad fa-circle mr-1 fa-lg text-green-300"></i>
                            <h2 id="estadoEquipo"></h2>
                        </div>
                        <div class="flex items-center text-xs font-bold text-purple-400 px-1 bg-purple-100 rounded-full w-auto cursor-pointer mr-4">
                            <i class="fas fa-cog mr-1 fa-lg text-purple-300"></i>
                            <h2 class="mr-2">EQUIPO <h2 id="jerarquiaEquipo2"> -</h2>
                            </h2>
                        </div>
                        <div class="flex items-center text-xs text-blue-300 px-1 bg-blue-100 rounded-full w-auto cursor-pointer mr-4">
                            <i class="mr-1 text-blue-400">BITÁCORAS:</i>
                            <h2>ZI</h2>
                        </div>
                        <div class="flex items-center text-xs text-red-400 px-1 bg-red-100 rounded-full w-auto cursor-pointer">
                            <i class="mr-1 text-red-300">R</i>
                            <h2>REEMPLAZADO</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOTOS -->
            <div class="w-full h-32 mt-2 px-4 overflow-x-auto scrollbar flex items-center">
                <div id="btnAdjuntosEquipo" class="flex items-center justify-center w-10 h-10 bg-bluegray-900 hover:bg-indigo-300 hover:text-indigo-500 border-2 border-gray-200 text-bluegray-300 rounded-full absolute left-0 cursor-pointer" data-anijs="if: mouseover, do: tada animated">
                    <i class="fas fa-plus ga-lg"></i>
                </div>
                <div class="bg-cover bg-center w-24 h-24 rounded-lg cursor-pointer flex-none mr-2 hover:shadow-lg">
                    <img id="QREquipo" class="" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=svg&bgcolor=fff&color=4a5568&data=www.maphg.com/beta/#">
                </div>
                <div id="dataImagenesEquipo" class="w-full h-32 overflow-x-auto scrollbar flex items-center"></div>
            </div>

            <!-- CARACTRISTICAS -->
            <div class="text-xs uppercase font-bold w-full px-2 my-2 flex">
                <h1>INFORMACIÓN</h1>

                <button id="btnEditarEquipo" class="text-xxs px-2 bg-yellow-300 ml-3 rounded font-semibold hover:shadow">Editar</button>

                <button id="btnGuardarEquipo" class="text-xxs px-2 bg-green-300 ml-3 rounded font-semibold hover:shadow">Guardar</button>

                <button id="btnCancelarEquipo" class="text-xxs px-2 bg-red-300 ml-3 rounded font-semibold hover:shadow">Cancelar</button>
            </div>

            <div class="flex flex-row w-full bg-fondos-4">
                <div class="w-9/12 flex-none h-auto px-4 overflow-x-auto scrollbar flex flex-no-wrap justify-start items-start text-xxs pt-2 ">
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">SECCIÓN</h1>
                            <select id="seccionEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">SUBSECCIÓN</h1>
                            <select id="subseccionEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">TIPO</h1>
                            <select id="tipoEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">JERARQUIA</h1>
                            <select id="jerarquiaEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                                <option value="PRINCIPAL">PRINCIPAL</option>
                                <option value="SECUNDARIO">SECUNDARIO</option>
                            </select>
                        </div>

                        <div id="contenedorDataOpcionesEquipos" class="flex flex-col justify-center items-start uppercase leading-tight mb-4 hidden">
                            <h1 class="font-bold text-bluegray-900 uppercase">EQUIPO PRIMARIO</h1>
                            <select id="dataOpcionesEquipos" class="bg-fondos-4 font-semibold truncate w-24"></select>
                        </div>

                    </div>

                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">MARCA</h1>
                            <select id="marcaEquipo" class="bg-fondos-4 font-semibold truncate w-24">
                            </select>

                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">modelo</h1>
                            <input type="text" delo" value="-" id="modeloEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">numero de serie</h1>
                            <input type="text" value="-" id="serieEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">Código Fabricante</h1>
                            <input type="text" value="-" id="codigoFabricanteEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">Código Interno compras</h1>
                            <input type="text" value="-" id="codigoInternoComprasEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                    </div>
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">LARGO</h1>
                            <input type="text" value="-" id="largoEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">ANCHO</h1>
                            <input type="text" value="-" id="anchoEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">ALTO</h1>
                            <input type="text" value="-" id="altoEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>
                    </div>

                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ELEC. (HP)</h1>
                            <input type="text" value="-" id="potenciaElectricaHPEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ELEC. (KW)</h1>
                            <input type="text" value="-" id="potenciaElectricaKWEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">VOLTAJE (V)</h1>
                            <input type="text" value="-" id="voltajeEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">FRECUENCIA (HZ)</h1>
                            <input type="text" value="-" id="frecuenciaEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                    </div>
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AGUA (M3/H)</h1>
                            <input type="text" value="-" id="caudalAguaM3HEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AGUA (GPH)</h1>
                            <input type="text" value="-" id="caudalAguaGPHEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CARGA (M.C.A)</h1>
                            <input type="text" value="-" id="cargaMCAEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                    </div>
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA FRIO(KW)</h1>
                            <input type="text" value="-" id="PotenciaEnergeticaFrioKWEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA FRIO(TR)</h1>
                            <input type="text" value="-" id="potenciaEnergeticaFrioTREquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA CALOR (KCAL)</h1>
                            <input type="text" value="-" id="potenciaEnergeticaCalorKCALEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AIRE(M3/H)</h1>
                            <input type="text" value="-" id="caudalAireM3HEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AIRE(CFM)</h1>
                            <input type="text" value="-" id="caudalAireCFMEquipo" class="bg-fondos-4 font-semibold" autocomplete="off">
                        </div>

                    </div>
                </div>
                <div class="flex-none flex flex-col items-start justify-start border-l w-3/12 text-xs uppercase font-bold px-2">

                    <h1 class="my-2">DESPIECE</h1>

                    <div id="dataDespieceEquipo" class="w-full flex flex-col overflow-y-auto scrollbar" style="max-height: 200px;">

                        <div class="flex-none cursor-pointer hover:bg-purple-200 hover:text-purple-700 w-full px-2 py-2 rounded-sm truncate flex items-center border-b">
                            <i class="fad fa-cog mr-1"></i>
                            <h1>MOTOR NO SE QUE VEGAS</h1>
                        </div>

                        <div class="flex-none cursor-pointer hover:bg-purple-200 hover:text-purple-700 w-full px-2 py-2 rounded-sm truncate flex items-center border-b pl-6">
                            <i class="fad fa-cogs mr-1"></i>
                            <h1>MOTOR NO SE QUE VEGAS</h1>
                        </div>

                    </div>

                </div>

            </div>
            <!-- CARACTRISTICAS -->

            <!-- PLANES MP -->
            <div class="text-xs uppercase font-bold w-full px-2 my-2">
                <h1>Planes Preventivos</h1>
            </div>

            <div id="contenedorPlanesEquipo" class="flex flex-wrap w-full justify-start px-4  overflow-x-auto scrollbar py-4">
            </div>
            <!-- PLANES MP -->
        </div>
    </div>
    <!-- MODAL EQUIPO PARA LOS MP-->


    <!-- MODAL PARA FINALIZAR OT -->
    <div id="modalSolucionarOT" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1000px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalSolucionarOT')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="flex flex-col leading-none justify-center items-center bg-bluegray-900 rounded-b-md w-16 h-10">
                    <h1 class="font-bold text-sm text-white">OT</h1>
                    <h1 id="numeroOT" class="font-bold text-xs text-bluegray-100">234</h1>
                </div>
                <div id="tipoOT" class="ml-4 font-bold bg-purple-200 text-purple-500 text-xs py-1 px-2 rounded">
                    <h1>OT PREVENTIVA</h1>
                </div>
                <div id="statusOT" class="ml-4 font-bold text-xs py-1 px-2 rounded">
                    <h1>EN PROCESO</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor de los equipos y locales(Tabla) -->

                <div class="flex items-center justify-center w-full">
                    <div class="w-full flex">
                        <div class="w-1/2 text-sm px-2 flex flex-col">
                            <h1 class="mb-1">Fecha</h1>
                            <div class="flex flex-wrap w-full justify-start items-center">

                                <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                                    <h1 id="semanaOT">Semana 8</h1>
                                </div>
                            </div>
                        </div>

                        <div class="w-1/2 text-sm px-2 flex flex-col">
                            <h1 class="mb-1">Responsables</h1>
                            <div id="responsablesOT" class="flex flex-wrap w-full justify-start items-center"></div>
                        </div>

                    </div>
                </div>

                <div class="w-full text-sm px-2 flex flex-col mt-3">
                    <h1 class="mb-1">Status</h1>
                    <div id="dataStatusOT" class="flex flex-wrap w-full justify-start items-center"></div>
                </div>

                <div class="flex w-full text-sm mt-4">
                    <div class="w-1/2 flex flex-col items-start justify-start">
                        <div class="flex flex-col w-full ">
                            <h1 class="mb-2">Actividades Predefinidas</h1>

                            <div id="actividadesOT" class="flex flex-col w-full border-2 border-gray-300 text-xs rounded  p-1"></div>
                        </div>

                        <div class="flex flex-col w-full p-2 mt-2 text-xs">
                            <h1 class="mb-2">Actividades Extra</h1>
                            <div class="w-full">
                                <input id="inputActividadesExtra" type="text" placeholder="Añadir Actividad Extra..." class="w-full p-2 border border-gray-200 rounded mb-1" autocomplete="off">
                            </div>

                            <div id="actividadesExtraOT" class="w-full overflow-y-auto scrollbar" style="max-height: 300px;"></div>

                        </div>
                    </div>

                    <div class="w-1/2 flex flex-col items-start justify-start px-4">
                        <div class="flex flex-col w-full mb-2">
                            <h1 class="">Observaciones / Comentarios</h1>
                        </div>

                        <div class="w-full">
                            <textarea id="comentarioOT" cols="30" rows="5" class="w-full  border-2 border-gray-300 rounded leading-none"></textarea>
                        </div>

                        <div class="flex w-full mb-2">
                            <h1 class="mr-2">Archivos Adjuntos</h1>
                            <div id="btnAdjuntosOT" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600" onclick="toggleModalTailwind('modalMedia');">
                                <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                            </div>
                        </div>

                        <div class="w-full">
                            <div class="w-full px-1 font-medium text-sm text-gray-400 overflow-y-auto scrollbar border-2 border-gray-300 rounded">
                                <div id="imagenesOT" class="flex flex-row flex-wrap justify-evenly items-start overflow-y-auto scrollbar mb-4" style="max-height: 300px;"></div>
                                <div id="documentosOT" class="flex flex-col overflow-y-auto scrollbar px-1 mb-4 text-xs" style="max-height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-center items-center my-4">
                    <div id="btnGuardarOT" class="btn btn-blue mr-4">
                        <h1>Guardar Cambios</h1>
                    </div>
                    <div id="btnFinalizarOT" class="btn btn-green mr-4">
                        <h1>Finalizar esta OT</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL PARA FINALIZAR OT -->

    <!-- ***** MODALES PRINCIPALES ***** -->




    <!-- ***** MODALES SECUNDARIO ***** -->

    <!-- MODAL MEDIA -->
    <div id="modalMedia" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMedia')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>ARCHIVOS ADJUNTOS</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div class="mb-3">
                    <button class="relative py-2 px-3 w-full bg-teal-200 text-teal-500 font-bold text-sm rounded-md hover:shadow-md">
                        <i class="fad fa-cloud-upload fa-lg mr-2"></i>
                        ADJUNTAR ARCHIVOS

                        <!-- INPUT -->
                        <input id="inputAdjuntos" type="file" class="absolute opacity-0 item-center mx-0 my-0 justify-center w-full" style="top:1px; left:5px;" name="inputAdjuntos[]" multiple>
                        <!-- INPUT -->

                    </button>
                </div>

                <!-- Icon upload -->
                <span id="cargandoAdjunto" class="text-center"></span>
                <!-- Icon upload -->

                <div class="w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar">

                    <div id="contenedorImagenes">
                        <div class="font-bold divide-y">
                            <h1>IMÁGENES</h1>
                            <p> </p>
                        </div>
                        <!-- Data para las imagenes -->
                        <div id="dataImagenes" class="flex flex-row flex-wrap text-center"></div>
                    </div>

                    <div id="contenedorDocumentos">
                        <div class="font-bold divide-y mb-4">
                            <h1>DOCUMENTOS</h1>
                            <p> </p>
                        </div>
                        <div id="dataAdjuntos" class="flex flex-col"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- MODALES -->


    <!-- MODAL STATUS   -->
    <div id="modalStatus" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalStatus')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>STATUS</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center flex-col w-full font-bold text-sm">

                <div id="statusUrgente" class="hidden w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-red-500 bg-gray-200 hover:bg-red-200 text-xs">
                    <div class="">
                        <h1>ES URGENTE</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <i class="fas fa-siren-on animated flash infinite"></i>
                    </div>
                </div>

                <div id="statusMaterial" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs">
                    <div class="">
                        <h1>NO HAY MATERIAL</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>M</h1>
                    </div>
                </div>

                <div id="statusTrabajare" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-blue-500 bg-gray-200 hover:bg-blue-200 text-xs">
                    <div class="">
                        <h1>TRABAJANDO</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>T</h1>
                    </div>
                </div>

                <div id="statusenergeticos" onclick="expandir(this.id)" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                    <div class="">
                        <h1>ENERGÉTICOS</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>E</h1>
                    </div>
                </div>
                <div id="statusenergeticostoggle" class="hidden w-full flex flex-row justify-center items-center text-sm px-2 flex-wrap">
                    <div id="statusElectricidad" class="w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>ELECTRICIDAD</h1>
                        </div>
                    </div>
                    <div id="statusAgua" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>AGUA</h1>
                        </div>
                    </div>
                    <div id="statusDiesel" class="w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>DIESEL</h1>
                        </div>
                    </div>
                    <div id="statusGas" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
                        <div class="">
                            <h1>GAS</h1>
                        </div>
                    </div>
                </div>

                <div id="statusdep" onclick="expandir(this.id)" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                    <div class="">
                        <h1>DEPARTAMENTO</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>D</h1>
                    </div>
                </div>
                <div id="statusdeptoggle" class="hidden w-full flex flex-row justify-center items-center text-sm px-2 flex-wrap">
                    <div id="statusRRHH" class="w-1/2 text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>RRHH</h1>
                        </div>
                    </div>
                    <div id="statusCalidad" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>CALIDAD</h1>
                        </div>
                    </div>
                    <div id="statusDireccion" class="w-1/2 text-center h-8 rounded-l-md  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>DIRECCION</h1>
                        </div>
                    </div>
                    <div id="statusFinanzas" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>FINANZAS</h1>
                        </div>
                    </div>
                    <div id="statusCompras" class="w-1/2 text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
                        <div class="">
                            <h1>COMPRAS</h1>
                        </div>
                    </div>
                </div>

                <div id="statusbitacora" onclick="expandir(this.id)" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                    <div class="">
                        <h1>BITACORA</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>B</h1>
                    </div>
                </div>
                <div id="statusbitacoratoggle" class="hidden w-full flex flex-row justify-center items-center text-sm px-2">
                    <div id="statusGP" class="w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>GP</h1>
                        </div>
                    </div>
                    <div id="statusTRS" class="w-full text-center h-8  cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>TRS</h1>
                        </div>
                    </div>
                    <div id="statusZI" class="w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
                        <div class="">
                            <h1>ZI</h1>
                        </div>
                    </div>
                </div>
                <div id="statusFinalizar" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
                    <div class="">
                        <h1>SOLUCIONAR</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <i class="fas fa-check"></i>
                    </div>
                </div>

                <div class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs">
                    <div class=" bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="toggleModalTailwind('modalEditarTitulo');">
                        <div class="">
                            <i class="fas fa-pen fa-lg"></i>
                        </div>
                    </div>
                    <div class=" bg-gray-200 w-full text-center h-8 cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                        <div class="">
                            <i class="fas fa-random fa-lg"></i>
                        </div>
                    </div>
                    <div id="statusActivo" class=" bg-gray-200 w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                        <div class="">
                            <i class="fas fa-trash fa-lg"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- MODAL STATUS   -->


    <!-- MENÚ OPCIONES MP -->
    <div id="tooltipMP" role="tooltip" class="flex flex-col items-center justify-center mx-auto contextmenu-menu hidden" style="z-index:100">
        <div class=" text-sm leading-none w-full  mx-auto contextmenu-menu" style="background: #414646;">

            <h1 class="mr-1 text-right absolute right-0" style="color: #ffff;" onclick="cerrarTooltip('tooltipMP')">
                <i class="fas fa-times fa-lg"></i>
            </h1>

            <h1 class="my-2" style="color: #a9aaaa; background-color: #454A4A;">Programación <span id="semanaProgramacionMP"></span></h1>

            <h1 id="programarMPIndividual" class="contextmenu-item"><i class="fas fa-long-arrow-down mr-2 text-blue-400"></i>Programar (Individual)</h1>

            <h1 id="programarMPDesdeAqui" class="contextmenu-item"><i class="fas fa-random mr-2 text-blue-400"></i>Reprogramar desde aquí</h1>

            <h1 id="opcionMPPersonalizado" class="contextmenu-item" onclick="expandir(this.id)">
                <i class="fas fa-random mr-2 text-blue-400"></i>Program. Personalizada
            </h1>

            <div id="opcionMPPersonalizadotoggle" class="flex flex-row items-center justify-center mb-3 hidden">
                <input id="numeroSemanasPersonalizadasMP" class="w-1/4 text-center shadow appearance-none border border-red-500 rounded w-full py-1 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="1" max="52" pattern="[0-9]" autocomplete="off">
                <button id="programarMPPersonalizado" class="w-3/4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 ml-1 rounded">Programar</button>
            </div>

            <h1 id="eliminarMPIndividual" class="contextmenu-item"><i class="fas fa-trash-alt mr-2 text-red-500"></i>Eliminar (individual)</h1>

            <h1 id="eliminarMPDesdeAqui" class="contextmenu-item"><i class="fas fa-trash-alt mr-2 text-red-500"></i>Eliminar desde aquí</h1>

            <h1 class="my-2" style="color: #a9aaaa;">Ordenes de Trabajo</h1>

            <h1 id="VerOTMP" class="contextmenu-item"><i class="fas fa-eye mr-2 text-teal-500"></i>Ver OT</h1>

            <h1 id="generarOTMP" class="contextmenu-item"><i class="fas fa-file mr-2 text-amber-400"></i>Generar OT</h1>

            <h1 id="solucionarOTMP" class="contextmenu-item"><i class="fas fa-check mr-2 text-green-500"></i>Solucionar OT</h1>

            <h1 id="cancelarOTMP" class="contextmenu-item"><i class="fas fa-ban mr-2 text-red-500"></i>Cancelar OT</h1>

        </div>
        <i class="fas fa-sort-down w-full text-center fa-4x " style="color: #414646; margin-top: -29px; margin-bottom: -12.5px; z-index:99;"></i>
    </div>
    <!-- MENÚ OPCIONES MP -->


    <!-- MODAL RESPONSABLE -->
    <div id="modalUsuarios" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 450px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalUsuarios')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>RESPONSABLE</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div class="mb-3 w-full">
                    <input id="palabraUsuario" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." autocomplete="off">
                </div>

                <div class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="height: 400px;">
                    <div id="dataUsuarios"></div>
                </div>
            </div>
        </div>
    </div>


    <!-- ACTIVIDADES MP -->
    <div id="tooltipActividadesMP" role="tooltip" class="w-auto bg-white text-bluegray-800 flex flex-col items-start justify-start px-3 py-2 text-justify font-semibold text-xs uppercase rounded-md border overflow-y-auto scrollbar hidden" style="z-index:100; max-width: 350px; max-height: 400px;" style="z-index:100">
    </div>
    <!-- ACTIVIDADES MP -->

    <!-- ***** MODALES SECUNDARIO ***** -->






    <!-- LIBRERIAS JS -->
    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/alertasSweet.js"></script>
    <script src="js/gestion_equipos.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/OT_JS.js"></script>
</body>

</html>