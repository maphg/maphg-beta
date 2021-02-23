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

    <div class="w-full h-screen bg-white pt-5">

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
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10" style="width:65px;">
                                        DEST
                                    </th>
                                    <th class=" px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10" style="width:65px;">
                                        Año
                                    </th>

                                    <th class=" px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10" style="width:80px;">
                                        Sección
                                    </th>
                                    <th class=" px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10" style="width:220px;">
                                        Proyecto
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        PDA
                                    </th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        Responsable
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        Fechas
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        Cotizaciones
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10">
                                        Tipo
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10" style="width:110px;">
                                        Justificación
                                    </th>

                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-200 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0 z-10" style="width:110px;">
                                        Status
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

            <!-- CONTENIDO MEDIA -->
            <div id="mediaProyectos" class="hidden p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div id="justificacionProyectoDiv" class="flex flex-row items-center pt-5">
                    <textarea id="justificacionProyecto" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" cols="30" rows="5"></textarea>
                </div>

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


    <!-- MODAL MEDIA -->
    <div id="modalMediaProyectos" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 610px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalMediaProyectos')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>COTIZACIONES ADJUNTOS</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">

                <!-- Icon upload -->
                <span id="loaderCotizacionesProyecto" class="text-center"></span>

                <div class="w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar">

                    <div id="" class="bg-yellow-200 font-bold px-2 rounded-md">
                        <h1 class="uppercase p-2">Catálogo de Conceptos</h1>
                        <!-- Data para las imagenes -->
                        <div id="dataCatalogoConcepto" class="flex flex-row flex-wrap items-center justify-center text-center"></div>
                    </div>

                    <div id="contenedorDocumentos" class="font-bold rounded-md mt-5 bg-white">
                        <h1 class="uppercase p-2">COTIZACIONES</h1>
                        <!-- Data para las imagenes -->
                        <div class="overflow-y-auto scrollbar" style="max-height: 50vh;">
                            <div id="dataCotizacionesImagenes" class="flex flex-wrap justify-center text-center"></div>
                            <div id="dataCotizacionesDocumentos" class="flex flex-col text-center mr-1"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- MODALES -->


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


</body>

<!-- JQUERY -->
<script src="js/jquery-3.3.1.js"></script>
<!-- JQUERY -->

<!-- ALERTIFY JS -->
<script src="js/alertify.min.js"></script>
<script src="js/alertasSweet.js"></script>
<!-- ALERTIFY JS -->

<!-- JS PARA ORDENAMIENTO DE TABLAS -->
<script src="js/sorttable.js"> </script>
<!-- JS PARA ORDENAMIENTO DE TABLAS -->

<!-- JS PARA ESTE MODULO -->
<script src="js/proyectos_view.js"></script>
<!-- JS PARA ESTE MODULO -->

<!-- FUNCIONES GENERALES PARA TABLAS (BUSCADOR Y EXPORT EXCEL PLANO) -->
<script src="js/funciones_tablas.js"></script>
<!-- FUNCIONES GENERALES PARA TABLAS (BUSCADOR Y EXPORT EXCEL PLANO) -->

<!-- JS POPPER -->
<script src="js/popper.min.js"></script>
<!-- JS POPPER -->

<!-- JS MODALES -->
<script src="js/modales.js"></script>
<!-- JS MODALES -->

</html>