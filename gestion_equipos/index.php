<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>MAPHG Gestión Equipos</title>
    <link rel="stylesheet" href="../css/tailwindproduccion.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/modales.css">
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/alertify.min.css">
    <link rel="stylesheet" href="../css/planner_cols.css">
    <link rel="stylesheet" href="../css/animate.css">

    <style>
        .texto-equipo {
            max-width: 180px;
            word-wrap: break-word;
        }

        .texto-subseccion {
            max-width: 120px;
            word-wrap: break-word;
        }
    </style>
</head>

<body class=" bg-fondos-7 text-bluegray-800 scrollbar h-screen">

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

    <div class="flex flex-col container mx-auto font-light text-3xl">
        <h1>Equipos y Locales <span id="load"></span></h1>
    </div>

    <div class="flex flex-row container mx-auto text-base mb-6">

        <input id="filtroPalabra" type="search" name="" placeholder="Buscar Equipo o local" class="w-1/4 px-3 mr-6 bg-white focus:outline-none py-2 rounded-lg shadow-md" autocomplete="off">

        <button class="btn btn-indigo shadow-md mx-4 hidden">
            <i class="fas fa-plus"></i>
            Crear Equipo o Local
        </button>

        <div id="verGANTT" class="btn btn-indigo shadow-md mx-4 hidden">
            <h1>
                <i class="fas fa-tasks-alt mr-2"></i>VER GANTT
            </h1>
        </div>

        <div id="exportarPendientes" class="btn btn-indigo shadow-md mx-4">
            <h1><i class="fas fa-arrow-alt-circle-down mx-1"></i>EXPORTAR</h1>
        </div>

        <div id="agregarEquipoLocal" class="btn btn-blue shadow-md mx-4">
            <h1><i class="fas fa-plus-circle mx-1"></i>Agregar Equipo / Local</h1>
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
                    <option value="">Sección</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Subsecciones</h1>
            <div class="relative">
                <select id="filtroSubseccion" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                    <option value="">Subsección</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Tipo</h1>
            <div class="relative">
                <select id="filtroTipo" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                    <option value="">Tipo</option>
                </select>
            </div>
        </div>

        <div class="flex flex-col pl-4 w-1/6">
            <h1 class="self-start mb-2">Estado</h1>
            <div class="relative">
                <select id="filtroStatus" class="w-full border border-gray-200 text-gray-700 rounded-lg leading-tight focus:outline-none hover:bg-gray-200 focus:border-gray-500 mx-2 bg-white">
                    <option value="">Seleccione</option>
                    <option value="OPERATIVO">OPERATIVO</option>
                    <option value="BAJA">BAJA</option>
                    <option value="TALLER">TALLER</option>
                    <option value="FUERASERVICIO">FUERA DE SERVICIO</option>
                    <option value="OPERAMAL">OPERA MAL</option>
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

    <div class="flex flex-col items-star lg:items-center mx-auto container mx-auto">
        <div class="-my-2 py-2 overflow-x-auto scrollbar">
            <div class="align-middle inline-block min-w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 scrollbar" style="max-height: 60vh;">
                <table id="tablaGestionEquipos" class="min-w-full divide-y divide-gray-200 sortable">
                    <thead>
                        <tr class="cursor-pointer">
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Destino
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Sección
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Subsección
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Equipo
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Tipo equipo/local
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Marca Modelo
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Ubicacion
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Status
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Proximo MP
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Resumen MP
                            </th>
                            <th class="px-4 py-3 border-b border-gray-200 bg-bluegray-900 text-white text-left text-xs leading-4 font-medium uppercase tracking-wider sticky top-0 z-10">
                                Resumen Incidencias
                            </th>
                        </tr>
                    </thead>
                    <tbody id="contenedorDeEquipos" class="bg-white divide-y divide-gray-200">
                        <!-- DATA EQUIPOS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- ***** MODALES PRINCIPALES ***** -->

    <!-- MODAL EQUIPO PARA LOS MP-->
    <div id="modalMPEquipo" class="modal relative">
        <div class="modal-window flex shadow-lg flex-col justify-center items-center text-bluegray-800 pt-10 rounded-lg" style="width: 1050px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMPEquipo')" class="cursor-pointer text-md  text-red-500 bg-red-200 px-2 rounded-bl-lg rounded-tr-lg font-normal shadow-md">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- ENCABEZADO -->
            <div class="flex flex-row w-full justify-start px-4 relative">
                <div class="font-bold text-xl flex flex-col justify-center items-start uppercase truncate w-full text-center">
                    <input id="nombreEquipo" type="text" class="font-bold text-xl flex flex-col justify-center items-center uppercase truncate w-full text-center bg-white" value="" autocomplete="off">
                    <div class="flex mt-1">

                        <div id="contenedorEstadoEquipo" class="flex items-center px-1  rounded-full w-auto cursor-pointer mr-4 bg-green-200">
                            <i id="iconEstadoEquipo" class="fad fa-circle my-1 mr-1 fa-lg text-green-500"></i>

                            <select id="estadoEquipo" class="text-xs font-bold bg-green-200 text-green-500 select-sinarrow">
                                <option value="">Seleccione</option>
                                <option value="OPERATIVO">OPERATIVO</option>
                                <option value="BAJA">BAJA</option>
                                <option value="TALLER">TALLER</option>
                                <option value="FUERASERVICIO">FUERA DE SERVICIO</option>
                                <option value="OPERAMAL">OPERA MAL</option>
                            </select>

                        </div>

                        <div class="flex items-center text-xs font-bold text-purple-400 px-1 bg-purple-100 rounded-full w-auto cursor-pointer mr-4 hidden">
                            <i class="fas fa-cog mr-1 fa-lg text-purple-300"></i>
                            <h2 class="mr-2">
                                <select id="tipoLocalEquipo" class="text-xs font-bold">
                                    <option value="EQUIPO">EQUIPO</option>
                                    <option value="LOCAL">LOCAL</option>
                                </select>
                            </h2>
                            <h2 id="jerarquiaEquipo2"></h2>
                        </div>

                        <div class="flex items-center text-xs text-blue-300 px-1 bg-blue-100 rounded-full w-auto cursor-pointer mr-4">
                            <i class="mr-1 text-blue-400">FASE:</i>
                            <select id="idFaseEquipo" class="text-lg font-bold text-blue-400 bg-blue-100">
                                <option value="1">GP</option>
                                <option value="2">TRS</option>
                                <option value="3">ZI</option>
                            </select>
                        </div>

                        <div class="flex items-center text-xs text-red-400 px-1 bg-red-100 rounded-full w-auto cursor-pointer hidden">
                            <i class="mr-1 text-red-300">R</i>
                            <h2>REEMPLAZADO</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOTOS -->
            <div class="w-full h-32 mt-2 px-4 overflow-x-auto scrollbar flex items-center">

                <div class="flex items-center justify-center w-10 h-10 bg-bluegray-900 hover:bg-indigo-300 hover:text-indigo-500 border-2 border-gray-200 text-bluegray-300 rounded-full absolute left-0 cursor-pointer" data-anijs="if: mouseover, do: tada animated">
                    <i class="fas fa-plus ga-lg"></i>
                    <input id="inputFotografiaEquipo" type="file" class="absolute opacity-0 item-center mx-0 my-0 justify-center w-full" style="top:1px; left:5px" multiple="">
                </div>
                <div class="bg-cover bg-center w-24 h-24 rounded-lg cursor-pointer flex-none mr-2 hover:shadow-lg">
                    <img id="QREquipo">
                </div>
                <div id="dataImagenesEquipo" class="w-full h-auto flex items-center overflow-x-auto overflow-y-hidden scrollbar"></div>
            </div>

            <!-- OPCIONES SUPERIORES -->
            <div class="w-full py-2 border-t my-1">
                <div class="flex justify-center items-center text-xs">
                    <button id="btnInformacionEquipo" class="bg-gray-200 text-gray-500 w-20 h-6 rounded mr-2 hover:bg-purple-200 hover:text-purple-500">Información</button>
                    <button id="btnDespieceEquipo" class="bg-gray-200 text-gray-500 w-20 h-6 rounded mr-2 hover:bg-purple-200 hover:text-purple-500">Componentes</button>
                    <button id="btnDocumentosEquipo" class="bg-gray-200 text-gray-500 w-20 h-6 rounded mr-2 hover:bg-purple-200 hover:text-purple-500">Adjuntos</button>
                    <button id="btnCotizacionesEquipo" class="bg-gray-200 text-gray-500 w-20 h-6 rounded mr-2 hover:bg-purple-200 hover:text-purple-500">Cotizaciones</button>
                </div>
            </div>

            <!-- CARACTRISTICAS -->
            <div id="contenedorCaracteristicasEquipo" class="w-full bg-white hidden">
                <div class="text-xs uppercase font-bold w-full px-2 my-2 flex">

                    <button id="btnEditarEquipo" class="text-xxs px-2 bg-yellow-300 text-yellow-700 ml-3 rounded font-semibold hover:shadow">Editar <i class="fas fa-edit ml-1"></i></button>

                    <button id="btnGuardarEquipo" class="text-xxs px-2 bg-green-300 text-green-700 ml-3 rounded font-semibold hover:shadow">Guardar <i class="fad fa-save ml-1"></i></button>

                    <button id="btnCancelarEquipo" class="text-xxs px-2 bg-red-300 text-red-700 ml-3 rounded font-semibold hover:shadow">Cancelar <i class="fas fa-times-circle ml-1"></i></button>
                </div>

                <div class="flex flex-row justify-center items-center w-full">
                    <div class="h-auto px-2 overflow-x-auto scrollbar flex flex-no-wrap justify-start items-start text-xxs pt-2 w-full mx-auto">
                        <div class="flex-none w-2/12">

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">SECCIÓN</h1>
                                <select id="seccionEquipo" class="font-semibold truncate bg-white w-32 select-sinarrow">
                                </select>
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">SUBSECCIÓN</h1>
                                <select id="subseccionEquipo" class="font-semibold truncate bg-white w-32 select-sinarrow">
                                </select>
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">TIPO</h1>
                                <select id="tipoEquipo" class="font-semibold truncate bg-white w-32 select-sinarrow">
                                </select>
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">JERARQUIA</h1>
                                <select id="jerarquiaEquipo" class="font-semibold truncate bg-white w-32 select-sinarrow">
                                    <option value="PRINCIPAL">PRINCIPAL</option>
                                    <option value="SECUNDARIO">SECUNDARIO</option>
                                </select>
                            </div>

                            <div id="contenedorDataOpcionesEquipos" class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">EQUIPO PRIMARIO</h1>
                                <select id="dataOpcionesEquipos" class="font-semibold truncate bg-white w-32 select-sinarrow"></select>
                            </div>

                        </div>

                        <div class="flex-none w-2/12">

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">MARCA</h1>
                                <select id="marcaEquipo" class="font-semibold truncate bg-white w-24 select-sinarrow">
                                </select>

                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Modelo</h1>
                                <input type="text" value="-" id="modeloEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Número de Serie</h1>
                                <input type="text" value="-" id="serieEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Código Fabricante</h1>
                                <input type="text" value="-" id="codigoFabricanteEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Código Interno Compras</h1>
                                <input type="text" value="-" id="codigoInternoComprasEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                        </div>

                        <div class="flex-none w-2/12">
                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Fecha de Instalación</h1>
                                <input id="fechaInstalacionEquipo" type="date" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Fecha de Compra</h1>
                                <input id="fechaCompraEquipo" type="date" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Años de Garantía</h1>
                                <input id="añoGarantiaEquipo" type="number" min="0" step="1" value="0" class="font-semibold bg-white">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Años de Vida Util</h1>
                                <input id="añoVidaUtilEquipo" type="number" min="0" step="1" value="0" class="font-semibold bg-white">
                            </div>
                        </div>

                        <div class="flex-none w-2/12">
                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">Cantidad</h1>
                                <input id="cantidadEquipo" type="text" placeholder="0" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">LARGO</h1>
                                <input type="text" value="-" id="largoEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">ANCHO</h1>
                                <input type="text" value="-" id="anchoEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">ALTO</h1>
                                <input type="text" value="-" id="altoEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>
                        </div>

                        <div class="flex-none w-2/12">

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">POT ELEC. (HP)</h1>
                                <input type="text" value="-" id="potenciaElectricaHPEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">POT ELEC. (KW)</h1>
                                <input type="text" value="-" id="potenciaElectricaKWEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">VOLTAJE (V)</h1>
                                <input type="text" value="-" id="voltajeEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">FRECUENCIA (HZ)</h1>
                                <input type="text" value="-" id="frecuenciaEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">CAPACIDAD</h1>
                                <input type="text" id="capacidadEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                        </div>

                        <div class="flex-none w-2/12">

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AGUA (M3/H)</h1>
                                <input type="text" value="-" id="caudalAguaM3HEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AGUA (GPH)</h1>
                                <input type="text" value="-" id="caudalAguaGPHEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">CARGA (M.C.A)</h1>
                                <input type="text" value="-" id="cargaMCAEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                        </div>

                        <div class="flex-none w-2/12">

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA FRIO(KW)</h1>
                                <input type="text" value="-" id="PotenciaEnergeticaFrioKWEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA FRIO(TR)</h1>
                                <input type="text" value="-" id="potenciaEnergeticaFrioTREquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">POT ENERGÉTICA CALOR (KCAL)</h1>
                                <input type="text" value="-" id="potenciaEnergeticaCalorKCALEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AIRE(M3/H)</h1>
                                <input type="text" value="-" id="caudalAireM3HEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                            <div class="flex flex-col justify-center items-start uppercase leading-tight mb-4">
                                <h1 class="font-bold text-bluegray-900 uppercase">CAUDAL AIRE(CFM)</h1>
                                <input type="text" value="-" id="caudalAireCFMEquipo" class="font-semibold bg-white" autocomplete="off">
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- DESPIECE -->
            <div id="contenedorDespiedeEquipo" class="flex flex-row w-full bg-white hidden">
                <div class="flex-none flex flex-col items-start justify-start border-l text-xs uppercase font-bold px-2 w-1/2">
                    <h1 class="my-2">Equipos Componentes</h1>
                    <div id="dataDespieceEquipo" class="w-full flex flex-col overflow-y-auto scrollbar" style="height: 200px;"></div>
                </div>
                <div class="flex-none flex flex-col items-start justify-start border-l text-xs uppercase font-bold px-2 w-1/2">
                    <div class="flex items-center justify-center">
                        <div>
                            <h1 id="cantidadDespieceMaterialEquipo" class="my-2">DESPIECE MATERIALES</h1>
                        </div>
                        <div class="ml-4">
                            <button id="btnAñadirMaterialEquipo" class="px-2 bg-blue-200 text-blue-500 uppercase font-bold rounded py-1 text-xxs">Añadir material</button>
                        </div>
                    </div>
                    <!-- DATA MATERIALES DE EQUIPO -->
                    <div class="w-full flex flex-col overflow-y-auto scrollbar" style="height: 200px;">
                        <div class="align-middle inline-block min-w-full shadow-md border rounded border-b border-gray-200" style="max-height: 250px;">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed border rounded sortable">
                                <thead>
                                    <tr class="cursor-pointer bg-white">

                                        <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 w-24">
                                            Cod2Bend
                                        </th>
                                        <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            Cantidad
                                        </th>
                                        <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            Descripción
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="dataDespieceMaterialesEquipo" class="bg-white divide-y divide-gray-200">
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>

            <!-- ADJUNTOS (COTIZACIONES Y MANUALES)-->
            <div id="contenedorAdjuntosEquipo" class="w-full bg-white hidden">
                <div class="flex-none flex flex-col items-start justify-start border-l text-xs uppercase font-bold px-2 overflow-y-auto scrollbar" style="height: 201px;">

                    <div class="w-full flex flex-row items-center justify-center my-1">
                        <button class="relative py-2 px-3 bg-teal-200 text-teal-500 font-bold text-xxs rounded-md hover:shadow-md">
                            <i class="fad fa-cloud-upload fa-lg mr-2"></i>
                            ADJUNTAR
                            <!-- INPUT -->
                            <input id="inputAdjuntosEquipo" type="file" class="absolute opacity-0 item-center mx-0 my-0 justify-center w-full" style="top:1px; left:5px" multiple="">
                            <!-- INPUT -->
                        </button>
                    </div>

                    <div id="dataAdjuntosEquipo" class="w-full flex flex-wrap"></div>
                </div>
            </div>

            <!-- OPCIONES INFERIORES MP -->
            <div class="w-full my-2 py-2 border-t">
                <div class="flex justify-center items-center text-xs">
                    <button id="btnPreventivosEquipo" class="bg-gray-200 text-gray-500 w-20 h-6 rounded mr-2 hover:bg-purple-200 hover:text-purple-500">Preventivo</button>
                    <button id="btnIncidenciasEquipo" class="bg-gray-200 text-gray-500 w-20 h-6 rounded mr-2 hover:bg-purple-200 hover:text-purple-500">Incidencias</button>
                    <button id="btnChecklistEquipo" class="bg-gray-200 text-gray-500 w-20 h-6 rounded mr-2 hover:bg-purple-200 hover:text-purple-500">Checklist
                        MP</button>
                    <button id="btnBitacorasEquipo" class="bg-gray-200 text-gray-500 px-2 h-6 rounded mr-2 hover:bg-purple-200 hover:text-purple-500">Inspección/Bitácoras</button>
                </div>
            </div>

            <!-- PLANES MP EQUIPO -->
            <div id="contenedorPlanesEquipo" class="flex flex-wrap w-full justify-start p-4  overflow-x-auto scrollbar hidden" style="max-height:300.5px; min-height:150px;">
            </div>

            <!-- INCIDENCIAS EQUIPO -->
            <div id="contenedorIncidenciasEquipo" class="flex flex-wrap w-full justify-start p-1 overflow-x-auto scrollbar hidden" style="height:300px;">
                <div class="align-middle inline-block min-w-full shadow-md border rounded border-b border-gray-200" style="max-height: 250px;">
                    <table class="min-w-full divide-y divide-gray-200 table-fixed border rounded sortable">
                        <thead>
                            <tr class="cursor-pointer bg-white">

                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 w-24">
                                    Incidencia
                                </th>
                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    Acciones
                                </th>
                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    Responsable
                                </th>

                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    Fechas
                                </th>

                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    Comentarios
                                </th>

                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    Adjuntos
                                </th>

                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    Status
                                </th>

                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    OT
                                </th>

                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                </th>

                                <th class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 hidden">
                                    Tipo
                                </th>

                            </tr>
                        </thead>

                        <tbody id="dataIncidenciasEquipo" class="bg-white divide-y divide-gray-200">
                            <!-- More rows... -->
                        </tbody>

                    </table>
                </div>
            </div>

            <!-- CHECKLIST EQUIPO -->
            <div id="contenedorChecklistEquipo" class="flex flex-wrap w-full justify-start p-4  overflow-x-auto scrollbar hidden" style="max-height:300.5px; min-height:150px;">
            </div>

            <!-- BITACORA EQUIPO -->
            <div id="contenedorBitacoraEquipo" class="flex flex-wrap w-full justify-start p-4  overflow-x-auto scrollbar hidden" style="max-height:300.5px; min-height:150px;">
            </div>

            <!-- MENÚ OPCIONES MP -->
            <div id="tooltipMP" role="tooltip" class="flex flex-col items-center justify-center mx-auto contextmenu-menu hidden" style="z-index:100">
                <div class=" text-sm leading-none w-full  mx-auto contextmenu-menu" style="background: #414646; z-index:90;">

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

                    <div id="contenedorFechaProgramadaOT" class="contextmenu-item">
                        <label for="fechaProgramadaOT" class="mr-2">Programar Para:</label>
                        <input id="fechaProgramadaOT" type="date" class="w-32 mr-2 text-white px-2 border-sm-b border-white shadow" style="background-color: #454A4A;">
                    </div>

                    <h1 id="VerOTMP" class="contextmenu-item">
                        <i class="fas fa-eye mr-2 text-teal-500"></i>Ver OT
                    </h1>

                    <h1 id="generarOTMP" class="contextmenu-item">
                        <i class="fas fa-file mr-2 text-amber-400"></i>Generar OT
                    </h1>

                    <h1 id="solucionarOTMP" class="contextmenu-item">
                        <i class="fas fa-check mr-2 text-green-500"></i>Solucionar
                        OT
                    </h1>

                    <h1 id="cancelarOTMP" class="contextmenu-item">
                        <i class="fas fa-ban mr-2 text-red-500"></i>Cancelar OT
                    </h1>

                </div>
                <i class="fas fa-sort-down w-full text-center fa-4x " style="color: #414646; margin-top: -29px; margin-bottom: -12.5px; z-index:85;"></i>
            </div>
            <!-- MENÚ OPCIONES MP -->

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

                            <div id="actividadesOT" class="flex flex-col w-full border-2 border-gray-300 text-xs rounded p-1 overflow-y-auto scrollbar" style="max-height: 251px; height: 250px;"></div>
                        </div>

                        <div class="flex flex-col w-full p-2 mt-2 text-xs">
                            <h1 class="mb-2">Actividades Extra</h1>
                            <div class="w-full">
                                <input id="inputActividadesExtra" type="text" placeholder="Añadir Actividad Extra..." class="w-full p-2 border border-gray-200 rounded mb-1" autocomplete="off">
                            </div>

                            <div id="actividadesExtraOT" class="w-full overflow-y-auto scrollbar" style="max-height: 200px; height: 199px;"></div>

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


    <!-- MODAL CONFIRMAR ENTRADA -->
    <div id="modalAgregarEquipo" class="modal">
        <div class="modal-window rounded-md" style="width:400px;">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalAgregarEquipo')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-tl-md rounded-br-md">
                    <h1>Agregar Equipo / Local <i class="fas fa-plus-circle"></i></h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="pt-10 pb-2 px-2 flex justify-center items-center flex-col w-full">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">

                            <div class="col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Equipo / Local</label>
                                <input id="descripcionXEquipo" type="text" autocomplete="off" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border border-blue-300 rounded-md" maxlength="150" title="(Max 60 Caracteres)" placeholder="Nombre De Equipo/Local">
                            </div>


                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Destino</label>
                                <select id="destinoXEquipo" class="mt-1 block w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Sección
                                </label>
                                <select id="seccionXEquipo" class="mt-1 block w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Subsección
                                </label>
                                <select id="subseccionXEquipo" class="mt-1 block w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Tipo Equipo / Local
                                </label>
                                <select id="tipoXEquipo" class="mt-1 block w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Marca
                                </label>
                                <select id="marcaXEquipo" class="mt-1 block w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Equipo / Local
                                </label>
                                <select id="equipoXLocal" class="mt-1 block w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">
                                    Jerarquia
                                </label>
                                <select id="jerarquiaXEquipo" class="mt-1 block w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="PRINCIPAL">PRINCIPAL</option>
                                    <option value="SECUNDARIO">SECUNDARIO</option>
                                </select>
                            </div>

                            <div id="contenedorEquipoPadre" class="col-span-6 sm:col-span-3 hidden">
                                <label class="block text-sm font-medium text-gray-700">
                                    Equipo Principal
                                </label>
                                <select id="jerarquiaPadreXEquipo" class="mt-1 block w-full py-1 px-3 border border-blue-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></select>
                            </div>

                            <div class="col-span-6">
                                <label for="state" class="block text-sm font-medium text-gray-700">Modelo</label>
                                <input id="modeloXEquipo" type="text" class="mt-1 block w-full py-1 shadow-sm sm:text-sm border border-blue-400 rounded-md" autocomplete="off">
                            </div>

                        </div>
                    </div>

                    <div class="px-4 py-3 sm:px-6 text-center">
                        <button id="btnAgregarEquipo" type="submit" class="inline-flex justify-center py-2 px-4 shadow-sm text-sm font-medium rounded-md text-white hover:bg-blue-600 bg-blue-400">
                            Agregar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL SALIDAS Subalmacenes-->
    <div id="modalOpcionesMaterialesEquipo" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1250px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalOpcionesMaterialesEquipo');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- MARCA Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="font-bold bg-yellow-300 text-yellow-600 text-xs py-1 px-2 rounded-r-md">
                    <h1>MATERIALES</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <!-- Contenedor TABLA -->
                <div class="mt-2 w-full flex flex-col justify-center items-center px-5">
                    <!-- BUSCADOR -->
                    <div class="mb-3 w-full flex flex-row items-center justify-center">

                        <input id="inputDespieceMaterialesEquipo" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2" type="search" placeholder="Buscar Material por Descripción" autocomplete="off">

                    </div>
                    <!-- BUSCADOR -->
                    <!-- TITULOS -->
                    <div class="w-full flex flex-col overflow-y-auto scrollbar" style="min-height: 50vh; max-height: 70vh;">
                        <div class="align-middle inline-block min-w-full shadow-md border rounded border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed border rounded sortable">
                                <thead>
                                    <tr class="cursor-pointer bg-white">
                                        <td class="px-2 py-1  border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 w-8">
                                            <h1>DESTINO</h1>
                                        </td>
                                        <td class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            <h1>CATEGORÍA</h1>
                                        </td>
                                        <td class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            <h1>COD2BEND</h1>
                                        </td>
                                        <td class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            <h1>GREMIO</h1>
                                        </td>
                                        <td class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            <h1>DESCRIPCION</h1>
                                        </td>
                                        <td class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            <h1>CARACTERISTICAS</h1>
                                        </td>
                                        <td class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            <h1>MARCA/PROVEEDOR</h1>
                                        </td>
                                        <td class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            <h1>U DE M</h1>
                                        </td>
                                        <td class="px-2 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                            <h1>CANTIDAD</h1>
                                        </td>
                                    </tr>
                                </thead>

                                <tbody id="dataOpcionesMaterialesEquipo" class="bg-white divide-y divide-gray-200">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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

                <div id="statusMaterial" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs" onclick="expandir('statusMaterialCod2bend');">
                    <div class="">
                        <h1>NO HAY MATERIAL</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>M</h1>
                    </div>
                </div>

                <div id="statusMaterialCod2bendtoggle" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs hidden">

                    <input id="inputCod2bend" type="text" placeholder="Ingrese COD2BEND" class="w-full h-full text-center rounded border border-red-400 font-bold text-gray-500" autocomplete="off">

                    <button id="btnStatusMaterial" class="bg-blue-500 hover:bg-blue-700 text-white font-bold mx-1 px-3 py-2 rounded focus:outline-none focus:shadow-outline" id="btnConfirmEditarTitulo" type="button">
                        <i class="fas fa-check fa-1x"></i>
                    </button>
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
                    <div id="btnEditarTituloX" class="bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="expandir('btnEditarTituloX')">
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

                <div id="btnEditarTituloXtoggle" class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs hidden">
                    <div class=" w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center text-gray-500 px-1">
                        <input id="editarTitulo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="off" type="text" placeholder="Nuevo Título" maxlength="60">

                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold mx-1 px-3 py-2 rounded focus:outline-none focus:shadow-outline" id="btnEditarTitulo" type="button">
                            <i class="fas fa-check fa-1x"></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ***** MODALES SECUNDARIO ***** -->


    <!-- LIBRERIAS JS -->
    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/alertasSweet.js"></script>
    <script src="js/gestion_equipos.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/OT_JS.js"></script>
    <script src="../js/sorttable.js"></script>
    <script src="../js/funciones_tablas.js"></script>

    <!-- MENU JS -->
    <script src="../js/menu_sub.js" type="text/javascript"></script>
    <!-- MENU JS -->
</body>

</html>