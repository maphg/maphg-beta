<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG Energéticos</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

</head>

<style>
    /* Arrow TOOLTIP */

    #arrowtooltipActividadesGeneral,
    #arrowtooltipActividadesGeneral::before {
        position: absolute;
        width: 8px;
        height: 8px;
        z-index: -1;
    }

    #arrowtooltipActividadesGeneral::before {
        content: '';
        transform: rotate(45deg);
        background: #333;
    }

    #tooltipActividadesGeneral[data-popper-placement^='top']>#arrowtooltipActividadesGeneral {
        bottom: -4px;
    }

    #tooltipActividadesGeneral[data-popper-placement^='bottom']>#arrowtooltipActividadesGeneral {
        top: -4px;
    }

    #tooltipActividadesGeneral[data-popper-placement^='left']>#arrowtooltipActividadesGeneral {
        right: -4px;
    }

    #tooltipActividadesGeneral[data-popper-placement^='right']>#arrowtooltipActividadesGeneral {
        left: -4px;
    }

    /* Arrow TOOLTIP */
    #arrowtooltipActividadesProyecto,
    #arrowtooltipActividadesProyecto::before {
        position: absolute;
        width: 8px;
        height: 8px;
        z-index: -1;
    }

    #arrowtooltipActividadesProyecto::before {
        content: '';
        transform: rotate(45deg);
        background: #333;
    }

    #tooltipActividadesPlanaccion[data-popper-placement^='top']>#arrowtooltipActividadesProyecto {
        bottom: -4px;
    }

    #tooltipActividadesPlanaccion[data-popper-placement^='bottom']>#arrowtooltipActividadesProyecto {
        top: -4px;
    }

    #tooltipActividadesPlanaccion[data-popper-placement^='left']>#arrowtooltipActividadesProyecto {
        right: -4px;
    }

    #tooltipActividadesPlanaccion[data-popper-placement^='right']>#arrowtooltipActividadesProyecto {
        left: -4px;
    }
</style>

<body class="bg-gray-200 scrollbar h-screen">

    <!-- MENÚ -->
    <menu-menu></menu-menu>
    <menu-sidebar clases="z-10 sticky top-0 shadow-sm mb-1"></menu-sidebar>

    <!-- CONFIGURACIONES SIDEBAR -->
    <configuracion-telegram></configuracion-telegram>
    <menu-notificaciones clases="h-screen"></menu-notificaciones>
    <menu-favoritos clases="h-screen"></menu-favoritos>
    <menu-telegram clases="h-screen"></menu-telegram>
    <menu-agenda clases="h-screen"></menu-agenda>
    <!-- MENÚ -->

    <div class="absolute left-0 z-10" style="margin: 15px 0 0 15px;">
        <div class="flex justify-center w-full absolute z-10" style="top: -15px;">
            <div class="energeticos-logo">
                <i class="fas fa-plug fa-lg absolute cursor-pointer" style="margin-left: 5px; margin-top: -5px" onclick="toggleHidden('contenedorEnergeticos')"></i>
            </div>
        </div>
        <div id="contenedorEnergeticos" class="flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800 bg-white w-48 rounded-md pt-5 px-2" style="margin-top: 10px"></div>
    </div>

    <div id="contenedor" class="container-fluid mx-auto">
        <div id="dataPowerbin" class="grid grid-flow-row p-1 mx-auto"></div>
    </div>


    <!-- ************************ MODALES ************************ -->


    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->
    <div id="modalEnergeticos" class="modal">
        <div id="contenedorPrincipalTareasFallas" class="modal-window rounded-md pt-10 w-auto md:w-10/12 lg:w-11/12 overflow-x-auto scrollbar" style="background: rgb(252, 211, 77);min-height: 60vh;">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalEnergeticos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div class="">
                    <h1 class="font-bold text-black"></h1>
                </div>
                <div class="ml-4 font-bold bg-yellow-400 text-yellow-700 text-xs py-1 px-2 rounded">
                    <h1 id="tituloEnergeticos"><i class="fas fa-plug fa-lg"></i>Energéticos</h1>
                </div>
            </div>

            <div class="flex justify-center items-center mb-5 relative pt-4">

                <div class="relative text-gray-600 w-72">
                    <input id="palabraEnergeticos" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." autocomplete="off">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <i class="fad fa-search"></i>
                    </button>
                </div>

                <div id="btnModalAgregarEnergeticos" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2 bg-indigo-600 hover:bg-indigo-200">
                    <i class="fas fa-plus mr-1 text-xs"></i>
                    <h1>Nuevo</h1>
                </div>

                <div class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2 bg-indigo-600 hover:bg-indigo-200 hidden">
                    <i class="fas fa-list mr-1 font-normal text-xs"></i>
                    <h1>Energeticos</h1>
                </div>

                <div class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 px-2 bg-indigo-600 hover:bg-indigo-200 hidden">
                    <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                    <h1>Gantt</h1>
                </div>

                <div id="btnPendientesEnergeticos" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2 bg-indigo-600 hover:bg-indigo-200">
                    <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                    <h1>Pendientes</h1>
                </div>

                <div id="btnSolucionadosEnergeticos" class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2 bg-indigo-600 hover:bg-indigo-200">
                    <i class="fas fa-check mr-1 font-normal text-xs"></i>
                    <h1>Solucionados</h1>
                </div>
            </div>

            <div class="text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 px-2 bg-indigo-600 hover:bg-indigo-200 hidden" id="exportarProyectos">
                <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                <h1>Exportar</h1>
            </div>

            <!-- CONTENIDO TAREAS FALLAS -->
            <div class="p-2 flex justify-center items-center flex-col w-full">

                <div class="overflow-x-auto scrollbar">
                    <div class="align-middle inline-block min-w-full shadow-md border rounded border-b border-gray-200" style="max-height: 45vh;">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed border rounded sortable">
                            <thead>
                                <tr class="cursor-pointer bg-white">

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Descripción
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        ACCIONES
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Responsable
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Fechas
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Adjuntos
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Comentarios
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Status
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        OT
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    </th>

                                    <th class="px-6 py-1 border-b border-gray-200 bg-white text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Tipo
                                    </th>

                                </tr>
                            </thead>

                            <tbody id="dataEnergeticos" class="bg-white divide-y divide-gray-200">
                                <!-- More rows... -->
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <!-- CONTENIDO TAREAS FALLAS -->

        </div>

    </div>
    <!-- MODAL para FALLAS Y TAREAS PENDIENTES -->


    <!-- MODAL PROYECTOS -->
    <div id="modalProyectos" class="modal">
        <div class="w-full h-screen bg-purple-400 relative">
            <div id="contenidoOpcionesProyectos" class="flex justify-center items-center mb-5 relative pt-4">
                <div class="font-light text-3xl ml-3 leading-none text-purple-600 absolute left-0 text-center">
                    <h1>Proyectos</h1><span id="loadProyectos"></span>
                </div>

                <div class="relative text-gray-600 w-72">
                    <input id="palabraProyecto" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Proyecto" autocomplete="off">
                    <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                        <i class="fad fa-search"></i>
                    </button>
                </div>

                <div id="agregarProyecto" class="text-purple-400 text-sm cursor-pointer bg-purple-600 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                    <i class="fas fa-plus mr-1 text-xs"></i>
                    <h1>Nuevo</h1>
                </div>

                <div id="opcionProyectos" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2">
                    <i class="fas fa-list mr-1 font-normal text-xs"></i>
                    <h1>Proyectos</h1>
                </div>
                <div id="opcionGanttProyectos" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                    <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                    <h1>Gantt</h1>
                </div>

                <div id="proyectosPendientes" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2">
                    <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                    <h1>Pendientes</h1>
                </div>
                <div id="proyectosSolucionados" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                    <i class="fas fa-check mr-1 font-normal text-xs"></i>
                    <h1>Solucionados</h1>
                </div>

                <div class="text-purple-400 text-sm cursor-pointer bg-purple-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2" id="exportarProyectos">
                    <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                    <h1>Exportar</h1>
                </div>
            </div>

            <div id="btnCerrerModalProyectos" class="absolute right-0 top-0 text-red-500 text-lg cursor-pointer bg-red-300 rounded-full w-auto px-2 h-6 flex justify-center items-center m-2 hover:bg-purple-200" onclick="toggleModalTailwind('modalProyectos')">
                <i class="fas fa-times"></i>
                <h1 class="ml-1 uppercase font-semibold text-xs">Cerrar</h1>
            </div>

            <!-- CONTENIDO PROYECTOS -->
            <div id="contenidoProyectos" class="flex flex-col mx-auto contenedor">
                <div class="align-middle inline-block shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 scrollbar w-auto mx-auto relative bg-white" style="min-height: 79vh; max-height: 80vh;">
                    <table class="divide-y divide-gray-200  sortable">
                        <thead>
                            <tr class="cursor-pointer bg-white">

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Proyecto
                                </th>
                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    PDA
                                </th>
                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Responsable
                                </th>

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Fechas
                                </th>

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Cotizaciones
                                </th>

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Tipo
                                </th>

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Justificación
                                </th>

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Importe
                                </th>

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Presupuesto
                                </th>

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                    Status
                                </th>

                                <th class="px-5 py-3 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 bg-white">
                                </th>

                            </tr>
                        </thead>
                        <tbody id="contenedorDeProyectos" class="bg-white divide-y divide-gray-200">
                            <!-- More rows... -->
                        </tbody>
                    </table>

                    <!-- PLANACCION PROYECTOS -->
                    <div id="tooltipProyectos" role="tooltip" class="w-full bg-bluegray-900 p-1 rounded-lg contenedor hidden" style="z-index:100">
                        <div class="flex flex-col">
                            <div class="flex justify-center items-center mb-5 relative pt-4">

                                <div class="relative text-gray-600">
                                    <input id="agregarPlanaccion" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="input" placeholder="Agregar Plan Acción" autocomplete="off">
                                </div>

                                <div id="btnagregarPlanaccion" class="text-purple-400 text-sm cursor-pointer bg-purple-600 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2">
                                    <i class="fas fa-plus mr-1 text-xs"></i>
                                    <h1>Nuevo</h1>
                                </div>

                                <div id="planaccionPendientes" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-purple-200 px-2 bg-purple-200">
                                    <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                                    <h1>Pendientes</h1>
                                </div>

                                <div id="planaccionSolucionados" class="text-purple-400 text-sm cursor-pointer rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-purple-200 px-2 bg-purple-600">
                                    <i class="fas fa-check mr-1 font-normal text-xs"></i>
                                    <h1>Solucionados</h1>
                                </div>

                            </div>
                            <div class="-my-2 py-2 overflow-x-auto scrollbar">
                                <div class="align-middle inline-block min-w-full shadow-md overflow-auto rounded border-b border-gray-200 scrollbar" style="max-height: 35vh;">
                                    <table class="min-w-full divide-y divide-gray-200 table-fixed">
                                        <thead>
                                            <tr class="cursor-pointer bg-white">

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Planacción
                                                </th>
                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Actividades
                                                </th>
                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Responsable
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Fechas
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Comentarios
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Adjuntos
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    Status
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                    OT
                                                </th>

                                                <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                </th>

                                            </tr>
                                        </thead>

                                        <tbody id="contenedorDePlanesdeaccion" class="bg-white divide-y divide-gray-200">
                                            <!-- More rows... -->
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PLANACCION PROYECTOS -->
                </div>

            </div>
            <!-- CONTENIDO PROYECTOS -->

            <!-- CONTENIDO GANTT -->
            <div id="contenidoGantt" class="flex flex-col mx-auto contenedor overflow-x-auto scrollbar hidden">
                <div class="mt-2 mx-auto flex flex-row justify-center items-start font-semibold text-xs text-bluegray-500 cursor-pointer overflow-y-auto scrollbar bg-white sm:rounded-lg border-b border-gray-200 w-full h-full" style="max-height: 80vh;">
                    <div class="text-xxs uppercase mt-5 w-full h-full mx-auto" id="chartdiv"></div>
                </div>
            </div>
            <!-- CONTENIDO GANTT -->
        </div>
    </div>
    <!-- MODAL PROYECTOS -->


    <!-- MODAL AGREGAR PROYECTO -->
    <div id="modalAgregarProyecto" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalAgregarProyecto')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>

                        <h1><i class="fas fa-plus mr-2"></i>AÑADIR PROYECTO</h1>
                    </h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm leading-none">

                <h1 class="self-start mb-2">Descripción:</h1>
                <input id="tituloProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Descripción del Proyecto" autocomplete="off">
                <div class="flex w-full items-center justify-center">
                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">Coste en USD:</h1>
                        <input id="costeProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" autocomplete="off">
                    </div>

                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Tipo:</h1>
                        <div class="relative">
                            <select id="tipoProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" id="grid-state">
                                <option value="">Seleccione</option>
                                <option value="CAPEX">FF&E</option>
                                <option value="CAPIN">CAPIN</option>
                                <option value="PROYECTO">PROYECTO</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex w-full items-center justify-center">
                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">Fecha inicio y Fecha tentativa de finalización:</h1>
                        <input id="fechaProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" name="datefilter" value="---">
                    </div>

                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Responsable:</h1>
                        <div class="relative">
                            <select id="responsableProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" id="grid-state">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <h1 class="self-start mb-2">Justificación:</h1>
                <input id="justificacionProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Escriba aquí la justificación del Proyecto" autocomplete="off">

                <button id="btnCrearProyecto" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-8 rounded mb-2">
                    <i class="fas fa-check"></i> Crear
                </button>
            </div>
        </div>
    </div>


    <!-- MODAL AGREGAR ENERGETICO   -->
    <div id="modalAgregarEnergeticos" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalAgregarEnergeticos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>

                        <h1><i class="fas fa-plus mr-2"></i>AÑADIR Pendiente</h1>
                    </h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm leading-none">

                <h1 class="mb-2 self-start">subsección:</h1>
                <div class="bg-red-200 text-red-500 p-3 rounded self-start mb-4">
                    <h1 id="nombreSubseccionEnergeticos"></h1>
                </div>

                <div class="flex w-full flex-col">
                    <h1 class="self-start mb-2">Clasifique la incidencia:</h1>
                    <div class="bg-white  py-4 my-3 w-full mx-auto flex items-center">
                        <div class="w-full text-center">

                            <button id="btnEmergenciaEnergetico" type="button" class="border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación INMEDIATA">
                                Emergencia
                            </button>

                            <button id="btnUrgenciaEnergetico" type="button" class="border border-orange-500 text-orange-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-orange-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación RÁPIDA(No Inmediata)">
                                Urgencia
                            </button>

                            <button id="btnAlarmaEnergetico" type="button" class="border border-yellow-500 text-yellow-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-yellow-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación en Pocos Días(El Fallo no es inminente)">
                                Alarma
                            </button>

                            <button id="btnAlertaEnergetico" type="button" class="border border-blue-500 text-blue-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-blue-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="Requiere Actuación en Pocas Semanas o Meses. Además, requiere de Seguimiento de la situación por si se detecta algún cambio que obligue a modificar la PRIORIDAD">
                                Alerta
                            </button>

                            <button id="btnSeguimientoEnergetico" type="button" class="border border-teal-500 text-teal-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-teal-600 focus:outline-none focus:shadow-outline btnOpcionIncidencia" data-title-info="NO Requiere de Intervención pero requiere EVALUACIÓN PERIÓDICA para ver si la Situcación ha Cambiado">
                                Seguimiento
                            </button>

                        </div>
                    </div>
                </div>

                <h1 class="self-start mb-2">Descripción:</h1>
                <input id="tituloPendienteEnergeticos" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Descripción (Max: 60 Caracteres)" maxlength="60" autocomplete="off">

                <div class="flex w-full items-center justify-center">

                    <div class="w-1/2 flex flex-col pr-4">
                        <h1 class="self-start mb-2">Fecha inicio y Fecha tentativa de finalización:</h1>
                        <input id="rangoFechaEnergeticos" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" name="datefilter" value="---" autocomplete="off">
                    </div>

                    <div class="w-1/2 flex flex-col pl-4">
                        <h1 class="self-start mb-2">Responsable:</h1>
                        <div class="relative">
                            <select id="responsableEnergeticos" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" id="grid-state">
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <h1 class="self-start mb-2">Comentario:</h1>
                <input id="comentarioEnergeticos" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Añadir comentario" autocomplete="off">

                <button id="btnAgregarEnergeticos" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-8 rounded mb-2">
                    <i class="fas fa-check"></i> Crear
                </button>

            </div>
        </div>
    </div>
    <!-- MODAL AGREGAR ENERGETICO   -->


    <!-- MODAL STATUS   -->
    <div id="modalStatus" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalStatus')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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

                <div id="statusMaterial" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs" onclick="toggleHidden('statusMaterialCod2bend');">
                    <div class="">
                        <h1>NO HAY MATERIAL</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>M</h1>
                    </div>
                </div>

                <div id="statusMaterialCod2bend" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs hidden">

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

                <div id="statusenergeticos" onclick="toggleHidden('statusenergeticostoggle')" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-yellow-500 bg-gray-200 hover:bg-yellow-200 text-xs">
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

                <div id="statusdep" onclick="toggleHidden('statusdeptoggle')" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-teal-500 bg-gray-200 hover:bg-teal-200 text-xs">
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

                <div id="statusbitacora" onclick="toggleHidden('statusbitacoratoggle')" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-lightblue-500 bg-gray-200 hover:bg-lightblue-50 text-xs">
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
                <div id="statusEP" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
                    <div class="">
                        <h1>ENTREGAS PROYECTO</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>EP</h1>
                    </div>
                </div>

                <div class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs">
                    <div id="btnEditarTituloX" class="bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="toggleHidden('btnEditarTituloXtoggle')">
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


    <!-- MODAL RESPONSABLE -->
    <div id="modalUsuarios" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 450px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalUsuarios')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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


    <!-- MODAL EDITAR RANGO FECHA -->
    <div id="modalRangoFechaX" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalRangoFechaX')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>RANGO DE FECHA</h1>
                </div>
            </div>
            <div class="flex flex-row items-center pt-10">
                <input id="rangoFechaX" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="rangoFechaX" value="-" autocomplete="off">

                <button id="btnAplicarRangoFecha" class="bg-indigo-300 hover:bg-indigo-400 text-indigo-800 font-bold rounded inline-flex items-center w-10 text-center mx-2 p-2">
                    <i class="fal fa-sync-alt fa-lg"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- MODAL EDITAR RANGO FECHA -->


    <!-- MODAL MEDIA -->
    <div id="modalMedia" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalMedia')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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


    <!-- MODAL COMENTARIOS -->
    <div id="modalComentarios" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 600px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalComentarios')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>COMENTARIOS</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6 relative">

                <div id="scrollDataComentarios" class="px-4 overflow-y-auto scrollbar flex flex-col w-full" style="max-height: 50vh;">
                    <div id="dataComentarios" class="flex justify-center items-center flex-col-reverse w-full"></div>
                </div>
                <div class="flex flex-row justify-center items-center w-full h-10 px-16 mt-4">
                    <input id="inputComentario" type="text" placeholder="Añadir comentario" class="h-full w-full rounded-l-md text-gray-600 font-medium border-2 border-r-0 focus:outline-none px-4" autocomplete="off">
                    <button id="btnComentario" class="py-2 h-full w-12 rounded-r-md bg-teal-200 text-teal-500 font-bold text-sm hover:shadow-md">
                        <i class="fad fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL STATUS   -->
    <div id="modalTituloEliminar" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalTituloEliminar')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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

            <div id="finalizar" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
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
                <div id="eliminar" class=" bg-gray-200 w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                    <div class="">
                        <i class="fas fa-trash fa-lg"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- MODAL EDITAR INFORMACION -->
    <div id="modalActualizarProyecto" class="modal">
        <div class="modal-window rounded-md pb-2 px-5 py-3 text-center" style="width: 550px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalActualizarProyecto')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1 id="tituloActualizarProyecto">-</h1>
                </div>
            </div>

            <div id="tipoProyectoDiv" class="hidden flex flex-row items-center pt-10 justify-center">
                <div class="inline-block relative w-64">
                    <select id="tipoProyecto" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        <option>CAPIN</option>
                        <option>FF&E</option>
                        <option>PROYECTO</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div id="justificacionProyectoDiv" class="hidden flex flex-row items-center pt-10">
                <textarea id="justificacionProyecto" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" cols="30" rows="5"></textarea>
            </div>

            <div id="costeProyectoDiv" class="hidden flex flex-row items-center pt-10 justify-center">
                <input id="costeProyecto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="0" placeholder="Cantidad">
            </div>

            <button id="btnGuardarInformacion" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded mt-4"><i class="fas fa-save fa-lg"></i>
                Guardar Cambios
            </button>

            <!-- CONTENIDO MEDIA -->
            <div id="mediaProyectos" class="hidden mt-10 p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div class="mb-3">
                    <button class="relative py-2 px-3 w-full bg-teal-200 text-teal-500 font-bold text-sm rounded-md hover:shadow-md">
                        <i class="fad fa-cloud-upload fa-lg mr-2"></i>
                        ADJUNTAR ARCHIVOS

                        <!-- INPUT -->
                        <input id="inputAdjuntosJP" type="file" class="absolute opacity-0 item-center mx-0 my-0 justify-center w-full" style="top:1px; left:5px;" name="inputAdjuntosJP[]" multiple>
                        <!-- INPUT -->

                    </button>
                </div>

                <!-- Icon upload -->
                <span id="cargandoAdjuntoJP" class="text-center"></span>
                <!-- Icon upload -->

                <div class="w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar">

                    <div id="contenedorImagenesJP">
                        <div class="font-bold divide-y">
                            <h1 class="text-left">IMÁGENES</h1>
                            <p> </p>
                        </div>
                        <div id="dataImagenesProyecto" class="flex flex-row flex-wrap text-center overflow-y-auto scrollbar" style="max-height: 20vh;"></div>
                    </div>

                    <div id="contenedorDocumentosJP">

                        <div class="font-bold divide-y mb-4">
                            <h1 class="text-left">DOCUMENTOS</h1>
                            <p> </p>
                        </div>
                        <div id="dataAdjuntosProyecto" class="flex flex-col overflow-y-auto scrollbar" style="max-height: 20vh;"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- MODAL EDITAR INFORMACION -->


    <!-- MODAL EDITAR INFORMACION -->
    <div id="modalPresupuestoProyecto" class="modal">
        <div class="modal-window rounded-md pb-2 px-5 py-3 text-center" style="width: 550px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalPresupuestoProyecto')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md uppercase">
                    <h1>Presupuesto de Proyecto</h1>
                </div>
            </div>

            <div class="pt-10 ">
                <input id="presupuestoProyecto" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="number" min="0" placeholder="Cantidad">

                <button id="btnPresupuestoProyecto" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded mt-4"><i class="fas fa-save fa-lg"></i>
                    Guardar Cambios
                </button>
            </div>

        </div>
    </div>
    <!-- MODAL EDITAR INFORMACION -->


    <!-- MODAL EDITAR FECHA EN PROYECTOS -->
    <div id="modalFechaProyectos" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalFechaProyectos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>RANGO DE FECHA</h1>
                </div>
            </div>
            <div class="flex flex-row items-center pt-10">
                <input id="fechaProyecto" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="fechaProyecto" value="" autocomplete="off">
            </div>
        </div>
    </div>


    <!-- MODAL EDITAR TITULO   -->
    <div id="modalEditarTitulo" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 800px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalEditarTitulo')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1><i class="fas fa-pen fa-lg"></i></h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="px-8 py-2 flex flex-col justify-center items-center w-full font-bold text-sm">

                <h1>Editar titulo</h1>
                <input class="mt-4 appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="inputEditarTitulo" type="text" placeholder="Escriba titulo" value="" autocomplete="off">
                <button id="btnconfirmEditarTitulo" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded mt-4"><i class="fas fa-save fa-lg"></i> Guardar cambios</button>
            </div>
        </div>
    </div>


    <!-- ACTIVIDADES PLAN DE ACCIÓN -->
    <div id="tooltipActividadesPlanaccion" class="w-84 h-auto bg-bluegray-900 rounded-md p-1 flex hidden" role="tooltip" style="z-index:200">
        <div id="arrowtooltipActividadesProyecto" data-popper-arrow></div>
        <div class="bg-white rounded p-2 flex flex-col text-xxs font-semibold w-full">
            <div class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-fondos-2">
                <div class="w-4 h-4  mr-2 flex-none"></div>
                <div class=" text-justify w-full h-full">
                    <input id="agregarActividadPlanaccion" type="text" class="w-full h-full text-xs focus:outline-none appearance-none py-1 bg-transparent" placeholder="Añadir Actividad" autocomplete="off">
                </div>
                <div id="btnAgregarActividadPlanaccion" class="flex items-center justify-center text-blue-300 cursor-pointer w-6 h-6 rounded-full flex-none text-sm">
                    <i class="fas fa-plus"></i>
                </div>
            </div>

            <div id="dataActividades" class="w-auto overflow-y-auto scrollbar" style="max-height: 20vh;"></div>

        </div>
    </div>
    <!-- ACTIVIDADES PLAN DE ACCIÓN -->


    <!-- OPCIONES PARA ELIMINAR, EDITAR Y SOLUCIONAR -->
    <div id="tooltipEditarEliminarSolucionar" class="hidden bg-white rounded-md" style="z-index: 201;">
        <div class="pt-10 p-2" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="hiddenVista('tooltipEditarEliminarSolucionar')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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

            <div id="btnFinalizar" class="w-full text-center h-8 rounded-md cursor-pointer mb-4 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-green-500 bg-gray-200 hover:bg-green-200 text-xs">
                <div class="">
                    <h1>SOLUCIONAR</h1>
                </div>
                <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                    <i class="fas fa-check"></i>
                </div>
            </div>

            <div id="segmentoTitulo" class="w-full text-center h-8 rounded-md cursor-pointer mb-4 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 text-xs hidden">
                <div class="w-full">
                    <input id="inputTitulo" type="text" class="w-64 p-2 text-justify text-black bg-gray-200 rounded-md text-black" placeholder="Actualizar título" autocomplete="off">
                </div>
                <div id="btnTitulo" class="w-8 h-8 flex items-center justify-center font-black px-5 bg-green-200 rounded-md">
                    <i class="fas fa-sync-alt fa-1x"></i>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs">

                <div id="btnActualizarTitulo" class="bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="toggleHidden('segmentoTitulo')">
                    <div class="">
                        <i class="fas fa-pen fa-lg"></i>
                    </div>
                </div>

                <div class="bg-gray-200 w-full text-center h-8 cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                    <div class="">
                        <i class="fas fa-random fa-lg"></i>
                    </div>
                </div>

                <div id="btnEliminar" class=" bg-gray-200 w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
                    <div class="">
                        <i class="fas fa-trash fa-lg"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- OPCIONES PARA ELIMINAR, EDITAR Y SOLUCIONAR -->

    <!-- LIBRERIAS -->

    <!-- RANGE DATE -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/moment.min.js"></script>
    <script type="text/javascript" src="js/daterangepicker.min.js"></script>

    <script src="js/popper.min.js"></script>

    <script src=" js/alertify.min.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script src="js/energeticos.js"></script>
    <script src="js/seguridad_session.js"></script>
    <script src="js/funciones_tablas.js"></script>
    <script src="js/modales.js"></script>
    <!-- LIBRERIAS -->

    <!-- MENU JS -->
    <script src="js/menu.js" type="text/javascript"></script>
    <!-- MENU JS -->
</body>

</html>