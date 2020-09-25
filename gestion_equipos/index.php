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
    <link rel="stylesheet" href="../css/planner_cols.css">
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
                                Prox. MP
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


    <!-- MODALES -->

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
                    <img id="QREquipo" class="" src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&format=svg&bgcolor=fff&color=4a5568&data=www.maphg.com/equipos?0">
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
                            <select id="seccionEquipo" class="bg-fondos-4 font-semibold truncate">
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">SUBSECCIÓN</h1>
                            <select id="subseccionEquipo" class="bg-fondos-4 font-semibold truncate" disabled>
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">TIPO</h1>
                            <select id="tipoEquipo" class="bg-fondos-4 font-semibold truncate" disabled>
                            </select>
                        </div>

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">JERARQUIA</h1>
                            <select id="jerarquiaEquipo" class="bg-fondos-4 font-semibold truncate" disabled>
                                <option value="PRINCIPAL">PRINCIPAL</option>
                                <option value="SECUNDARIO">SECUNDARIO</option>
                            </select>
                        </div>

                    </div>
                    <div class="flex-none w-1/6">

                        <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                            <h1 class="font-bold text-bluegray-900 uppercase">MARCA</h1>
                            <select id="marcaEquipo" class="bg-fondos-4 font-semibold truncate" disabled>
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

                        <!-- <div class="flex-none cursor-pointer hover:bg-purple-200 hover:text-purple-700 w-full px-2 py-2 rounded-sm truncate flex items-center border-b">
                            <i class="fad fa-cog mr-1"></i>
                            <h1>MOTOR NO SE QUE VEGAS</h1>
                        </div> -->

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
        <i class="fas fa-sort-down w-full text-center fa-4x " style="color: #414646; margin-top: -29px; margin-bottom: -12.5px;"></i>
    </div>
    <!-- MENÚ OPCIONES MP -->


    <!-- ACTIVIDADES MP -->
    <div id="tooltipActividadesMP" role="tooltip" class="w-auto bg-white text-bluegray-800 flex flex-col items-start justify-start px-3 py-2 text-justify font-semibold text-xs uppercase rounded-md border overflow-y-auto scrollbar hidden" style="z-index:100; max-width: 350px; max-height: 400px;" style="z-index:100">
    </div>
    <!-- ACTIVIDADES MP -->



    <!-- LIBRERIAS JS -->
    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/alertasSweet.js"></script>
    <script src="js/gestion_equipos.js"></script>
    <script src="../js/popper.min.js"></script>
</body>

</html>