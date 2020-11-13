<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG Proyectos</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/alertify.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <style>
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

</head>

<body style="font-family: 'Source Sans Pro', sans-serif;">

    <!-- MENÚ -->
    <div class="w-full absolute top-0">
        <?php
        include 'navbartopJS.php';
        include 'menuJS.php';
        ?>
    </div>
    <!-- MENÚ -->

    <div class="w-full h-screen bg-white pt-20">

        <div class="flex justify-center items-center mb-5 relative pt-4">
            <div class="font-light text-xl ml-3 leading-none text-bluegray-600 mr-8">
                <h1>Proyectos (Global)
                    <span id="loadProyectos" class="text-center ml-4 text-2xl"></span>
                </h1>
            </div>

            <div class="relative text-gray-600 w-72">
                <input id="palabraProyecto" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Proyecto" autocomplete="off">
                <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                    <i class="fad fa-search"></i>
                </button>
            </div>

            <div id="btnProyectos" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2">
                <i class="fas fa-list mr-1 font-normal text-xs"></i>
                <h1>Proyectos</h1>
            </div>

            <div id="btnGantt" class="text-white text-sm cursor-pointer bg-bluegray-200 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-bluegray-200 px-2">
                <i class="fas fa-stream mr-1 font-normal text-xs"></i>
                <h1>Gantt</h1>
            </div>

            <div id="btnPendientes" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2">
                <i class="fas fa-minus mr-1 font-normal text-xs"></i>
                <h1>Pendientes</h1>
            </div>

            <div id="btnSolucionados" class="text-white text-sm cursor-pointer bg-bluegray-200 rounded-full w-auto h-6 flex justify-center items-center ml-2 hover:bg-bluegray-200 px-2">
                <i class="fas fa-check mr-1 font-normal text-xs"></i>
                <h1>Solucionados</h1>
            </div>

            <div id="btnExportar" class="text-white text-sm cursor-pointer bg-bluegray-600 rounded-full w-auto h-6 flex justify-center items-center ml-12 hover:bg-bluegray-200 px-2">
                <i class="fas fa-arrow-alt-circle-down mr-1 font-normal text-xs"></i>
                <h1>Exportar</h1>
            </div>
        </div>

        <div class="w-full h-auto">
            <div class="flex flex-col container mx-auto scrollbar">
                <div class="-my-2 py-2 overflow-x-auto relative scrollbar">
                    <div class="align-middle inline-block w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 relative scrollbar" style="max-height: 70vh;">

                        <table id="dataProyectos" class="w-full divide-y divide-gray-200 table table-fixed sortable hidden">
                            <thead>
                                <tr class="cursor-pointer bg-bluegray-50">
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0" style="width:65px;">
                                        DEST
                                    </th>
                                    <th class=" px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0" style="width:65px;">
                                        Año
                                    </th>

                                    <th class=" px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0" style="width:80px;">
                                        Sección
                                    </th>
                                    <th class=" px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0" style="width:220px;">
                                        Proyecto
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        PDA
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Responsable
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Fechas
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Cotizaciones
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Tipo
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0" style="width:110px;">
                                        Justificación
                                    </th>

                                    <th class=" px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Coste
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                    </th>

                                </tr>
                            </thead>
                            <tbody id="contenedorDeProyectos" class="bg-white divide-y divide-gray-200">
                                <!-- More rows... -->
                            </tbody>
                        </table>

                        <div id="chartProyectos" class="text-xxs uppercase mt-5 w-full h-full mx-auto hidden"></div>

                        <!-- PLANACCION PROYECTOS -->
                        <div id="tooltipProyectos" role="tooltip" class="bg-bluegray-900 py-1 px-4 rounded-lg contenedor w-full hidden">
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
                                                        Actividad
                                                    </th>
                                                    <th class="px-6 py-1 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                                        SubTareas
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

                            <!-- ACTIVIDADES PLAN DE ACCIÓN -->
                            <div id="tooltipActividadesPlanaccion" class="w-84 h-auto bg-bluegray-900 rounded-md p-1 flex hidden" role="tooltip" style="z-index:200">
                                <div id="arrowtooltipActividadesProyecto" data-popper-arrow></div>
                                <div class="bg-white rounded p-2 flex flex-col text-xxs font-semibold w-full">
                                    <div class="flex items-center justify-between uppercase border-b border-gray-200 py-2 hover:bg-fondos-2">
                                        <div class="w-4 h-4  mr-2 flex-none"></div>
                                        <div class=" text-justify w-full h-full">
                                            <input id="agregarActividadPlanaccion" type="text" class="w-full h-full text-xs focus:outline-none appearance-none py-1 bg-transparent" placeholder="Añadir Actividad" autocomplete="off">
                                        </div>
                                        <div id="btnAgregarActividadPlanaccion" class="flex items-center justify-center text-blue-300 cursor-pointer w-6 h-6 rounded-full flex-none text-sm" onclick="agregarActividadPlanaccion();">
                                            <i class="fas fa-plus"></i>
                                        </div>
                                    </div>

                                    <div id="dataActividades" class="w-auto overflow-y-auto scrollbar" style="max-height: 20vh;">

                                    </div>
                                </div>
                            </div>
                            <!-- ACTIVIDADES PLAN DE ACCIÓN -->

                        </div>
                        <!-- PLANACCION PROYECTOS -->

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
    <!-- MODAL RESPONSABLE -->


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
                        <option>CAPEX</option>
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
    <div id="modalTituloEliminar" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 360px;">
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
                <div class=" bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="expandir('editarTituloX');">
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

            <div id="editarTituloXtoggle" class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs hidden">
                <div id="eliminar" class=" w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center text-gray-500 px-2">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="off" id="inputEditarTituloX" type="text" placeholder="Nuevo Título">

                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold mx-1 px-3 py-2 rounded focus:outline-none focus:shadow-outline" id="btnEditarTituloX" type="button">
                        <i class="fas fa-check fa-1x"></i>
                    </button>
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

                <div id="statusMaterial" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs" onclick="expandir(this.id);">
                    <div class="">
                        <h1>NO HAY MATERIAL</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>M</h1>
                    </div>
                </div>

                <div id="statusMaterialtoggle" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs hidden">

                    <input id="inputCod2bend" type="text" placeholder="Ingrese COD2BEND" class="w-full h-full text-center rounded border border-red-400 font-bold text-gray-500">

                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold mx-1 px-3 py-2 rounded focus:outline-none focus:shadow-outline" id="btnConfirmEditarTitulo" type="button">
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
                            <h1>DIRECCIÓN</h1>
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
                    <div id="btnEditarTitulo" class=" bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200" onclick="expandir(this.id)">
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

                <div id="btnEditarTitulotoggle" class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs hidden">
                    <div class=" w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center text-gray-500 px-2">
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="off" id="editarTitulo" type="text" placeholder="Nuevo Título">

                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold mx-1 px-3 py-2 rounded focus:outline-none focus:shadow-outline" id="btnConfirmEditarTitulo" type="button">
                            <i class="fas fa-check fa-1x"></i>
                        </button>
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
                <button onclick="cerrarmodal('modalComentarios')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">

                <div class="px-4 overflow-y-auto scrollbar flex flex-col w-full" style="max-height: 50vh;">
                    <div id="dataComentarios" class="flex justify-center items-center flex-col-reverse w-full"></div>
                </div>
                <div class="flex flex-row justify-center items-center w-full h-10 px-16 mt-4">
                    <input id="inputComentario" type="text" placeholder="    Añadir comentario" class="h-full w-full rounded-l-md text-gray-600 font-medium border-2 border-r-0 focus:outline-none" autocomplete="off">
                    <button id="btnComentario" class="py-2 h-full w-12 rounded-r-md bg-teal-200 text-teal-500 font-bold text-sm hover:shadow-md">
                        <i class="fad fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL COMENTARIOS -->
    <div id="tooltipEditarEliminarSolucionar" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 280px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('tooltipEditarEliminarSolucionar')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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

                <div id="btnActualizarTitulo" onclick="expandir(this.id)" class="bg-gray-200 w-full text-center h-8 rounded-l-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md text-gray-500 hover:text-indigo-400 hover:bg-indigo-200">
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

            <div id="btnActualizarTitulotoggle" class="pt-2 border-t border-gray-300 w-full flex flex-row justify-center items-center text-xs hidden">
                <div class="w-full text-center h-8 rounded-r-md cursor-pointer mb-2 relative flex items-center justify-center text-gray-500 px-2">
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" autocomplete="off" id="editarTituloActividad" type="text" placeholder="Nuevo Título">

                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold mx-1 px-3 py-2 rounded focus:outline-none focus:shadow-outline" id="btnConfirmEditarTituloActividad" type="button">
                        <i class="fas fa-check fa-1x"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>


    <!-- MODAL RANGO FECHA EN FALLAS -->
    <div id="modalRangoFecha" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 310px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalRangoFecha')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                <input id="rangoFechaX" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="rangoFechaX" value="" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- MODAL RANGO FECHA EN FALLAS -->



</body>
<!-- Librerias JQUERY JS -->
<script src="js/jquery-3.3.1.js"></script>
<!-- Librerias JQUERY JS -->

<!-- JS OPCIONALES -->
<script src="js/modales.js"></script>
<!-- JS OPCIONALES -->

<!-- DATERANGEPICKER -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- DATERANGEPICKER -->

<!-- JS PARA ORDENAMIENTO DE TABLAS -->
<script src="js/sorttable.js"> </script>
<!-- JS PARA ORDENAMIENTO DE TABLAS -->

<!-- COMPLEMENTO PARA MOSTRAR DATOS DE MENU -->
<script src="js/complemento_menuJS.js"></script>
<!-- COMPLEMENTO PARA MOSTRAR DATOS DE MENU -->

<!-- JS PARA NOTIFICACIONES -->
<script src="js/alertify.min.js"></script>
<script src="js/alertasSweet.js"></script>
<!-- JS PARA NOTIFICACIONES -->

<!-- JS PARA ESTE MODULO -->
<script src="js/proyectos_global.js"></script>
<!-- JS PARA ESTE MODULO -->

<!-- FUNCIONES GENERALES PARA TABLAS (BUSCADOR Y EXPORT EXCEL PLANO) -->
<script src="js/funciones_tablas.js"></script>
<!-- FUNCIONES GENERALES PARA TABLAS (BUSCADOR Y EXPORT EXCEL PLANO) -->

<!-- DEPENDENCIAS DE LOS GRAFICOS am4core -->
<script src="js/am4core_core.js"></script>
<script src="js/am4core_charts.js"></script>
<script src="js/am4core_animated.js"></script>
<!-- DEPENDENCIAS DE LOS GRAFICOS am4core -->

<!-- SEGURIDAD DE SESSION -->
<script src="js/seguridad_session.js"></script>
<!-- SEGURIDAD DE SESSION -->

<!-- JS POPPER -->
<script src="js/popper.min.js"></script>
<!-- JS POPPER -->

</html>