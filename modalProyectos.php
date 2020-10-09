<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
    <title>Planner</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link rel="stylesheet" href="css/fontawesome/css/regular.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/jPages.css">
    <link rel="stylesheet" href="css/alertify.min.css">
</head>

<body>
    <div id="modalProyectos" class="modal open">
        <div class="modal-window rounded-md pt-10" style="width: 1300px;">
            <!-- SECCION Y UBICACION -->
            <div class="absolute top-0 left-0 ml-4 flex flex-row items-center">
                <div id="estiloSeccionProyectos" class="flex justify-center items-center rounded-b-md w-16 h-10 shadow-xs">
                    <h1 id="seccionProyectos" class="font-medium text-base"></h1>
                </div>
                <div class="ml-4 font-bold bg-teal-200 text-teal-500 text-xs py-1 px-2 rounded">
                    <h1>PROYECTOS</h1>
                </div>
            </div>

            <!-- CONTENIDO PROYECTOS-->
            <div class="p-2 mt-6 flex justify-center items-center flex-col">
                <div class="flex flex-row items-center w-full">
                    <div class="ml-10 relative text-gray-600 w-2/6 self-start">
                        <input id="palabraProyecto" class="border-2 border-gray-300 bg-white h-8 px-5 pr-16 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar Proyecto" autocomplete="off">
                        <button type="submit" class="absolute right-0 top-0 mt-1 mr-4">
                            <i class="fad fa-search"></i>
                        </button>
                    </div>
                    <div class="text-xs ml-2">

                        <button id="btnNuevoProyecto" class=" px-2 py-1 bg-indigo-300 text-indigo-500 font-bold  rounded"> <i class="fas fa-plus"></i> Nuevo</button>

                        <button id="btnProyecto" class=" px-2 py-1 hover:bg-blue-300 text-blue-500 border-blue-300 border-2 font-bold rounded ml-24"><i class="fas fa-tasks"></i> Proyectos</button>

                        <button id="btnGanttProyecto" class=" px-2 py-1 hover:bg-blue-300 text-blue-500 border-blue-300 border-2 font-bold rounded"><i class="fas fa-stream"></i> Gantt</button>

                        <button id="btnSolucionadosProyectos" class="px-2 py-1 hover:bg-green-300 text-green-500 border-green-300 border-2 font-bold ml-24 rounded"><i class="fas fa-check"></i> Solucionados
                        </button>

                        <button id="btnPendientesProyectos" class=" px-2 py-1 hover:bg-red-300 text-red-500 border-red-300 border-2 font-bold rounded"><i class="fas fa-check"></i> Pendientes</button>

                    </div>
                </div>
                <!-- Contenedor de los equipos y locales(Tabla) -->
                <div id="contenidoProyectos" class="hidden mt-2 w-full flex flex-col justify-center items-center overflow-y-auto scrollbar" style="max-height: 80vh;">
                    <!-- titulos -->
                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xxs h-8 text-bluegray-500 divide-x">
                        <div id="proyectoOrden" class="w-2/5 h-full flex items-center justify-center ">
                            <h1>PROYECTO</h1>
                        </div>
                        <div id="proyectoOrdenPDA" class="w-24 h-full flex items-center justify-center">
                            <h1>PDA</h1>
                        </div>
                        <div id="proyectoOrdenRESP" class="w-32 flex h-full items-center justify-center">
                            <h1>RESP.</h1>
                        </div>
                        <div id="proyectoOrdenFECHA" class="w-24 flex h-full items-center justify-center">
                            <h1>FECHA</h1>
                        </div>
                        <div id="proyectoOrdenCOT" class="w-24 flex h-full items-center justify-center">
                            <h1>COT</h1>
                        </div>
                        <div id="proyectoOrdenTIPO" class="w-24 flex h-full items-center justify-center">
                            <h1>TIPO</h1>
                        </div>
                        <div id="proyectoOrdenJUST" class="w-24 flex h-full items-center justify-center">
                            <h1>JUST</h1>
                        </div>
                        <div id="proyectoOrdenCOSTE" class="w-24 flex h-full items-center justify-center">
                            <h1>COSTE</h1>
                        </div>
                        <div class="w-24 flex h-full items-center justify-center">
                            <h1>STATUS</h1>
                        </div>
                    </div>

                    <div id="dataProyectos" class="w-full"></div>
                </div>
            </div>
            <div id="paginacionProyectos" class="px-4 py-3 flex items-center justify-center border-t border-gray-200 sm:px-6"></div>
            <!-- CONTENIDO PROYECTOS -->

            <!-- CONTENIDO GANTT -->
            <div id="contenidoGantt" class="mt-2 w-full flex flex-col justify-center items-center">
                <div class="mt-2 w-full  flex flex-row justify-center items-start font-semibold text-xs text-bluegray-500 cursor-pointer overflow-y-auto scrollbar" style="max-height: 80vh;">
                    <div class="w-full h-full text-xxs uppercase mt-5" id="chartdiv"></div>
                </div>
            </div>
            <!-- CONTENIDO GANTT -->

        </div>
    </div>


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

                <div class="px-4 overflow-y-auto scrollbar flex flex-col w-full" style="max-height: 80vh;">
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

                <div id="statusMaterial" class="w-full hover:shadow-md hover:shadow-md hover:text-orange-500 hover:bg-orange-200 bg-gray-200 rounded-md">

                    <div onclick="expandir('statusMaterial');" class="w-full text-center h-8 cursor-pointer relative flex items-center justify-center text-gray-500 text-xs">
                        <div class="">
                            <h1>NO HAY MATERIAL</h1>
                        </div>
                        <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                            <h1>M</h1>
                        </div>
                    </div>

                    <div id="statusMaterialtoggle" class="w-full text-center h-10 cursor-pointer relative flex items-center justify-center text-gray-500 text-xs hidden" style="margin-top:-6px;">
                        <input id="codigoSeguimiento" class="py-1 rounded ml-1 font-bold text-center" type="text" placeholder="Código Seguimiento" autocomplete="off">
                        <button id="statusMaterialBtn" class="mx-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded">Aplicar</button>
                    </div>

                </div>

                <div id="statusTrabajare" class="w-full text-center h-8 rounded-md cursor-pointer my-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-blue-500 bg-gray-200 hover:bg-blue-200 text-xs">
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
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
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
                <input id="fechaProyecto" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="fechaProyecto" value="--" autocomplete="off">
            </div>
        </div>
    </div>


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
                                <option value="CAPEX">CAPEX</option>
                                <option value="CAPIN">CAPIN</option>
                                <option value="PROYECTO">PROYECTO</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 mb-3 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
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
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <h1 class="self-start mb-2">Justificacion:</h1>
                <input id="justificacionProyectoN" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mb-4" type="text" placeholder="Escriba aquí la justificación del Proyecto" autocomplete="off">

                <button id="btnCrearProyecto" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-8 rounded mb-2">
                    <i class="fas fa-check"></i> Crear
                </button>
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
                <button id="btnEditarTitulo" class="bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded mt-4"><i class="fas fa-save fa-lg"></i> Guardar cambios</button>
            </div>
        </div>
    </div>


    <!-- Librerias -->
    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/acordion.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script src="js/jPages.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <!-- Librerias -->

    <!-- DEPENDENCIAS DEL GRAFICO -->
    <script src="js/am4core_core.js"></script>
    <script src="js/am4core_charts.js"></script>
    <script src="js/am4core_animated.js"></script>
    <!-- DEPENDENCIAS DEL GRAFICO -->

    <script>
        // ---------- PROYECTOS ----------

        function expandir(id) {
            let idtoggle = id + 'toggle';
            let idtitulo = id + 'titulo';
            var toggle = document.getElementById(idtoggle);
            toggle.classList.toggle("hidden");
            document.getElementById(idtitulo).classList.toggle('truncate');
        }


        // Función para Input Fechas para Agregar MC.
        $(function() {
            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                showWeekNumbers: true,
                locale: {
                    cancelLabel: 'Cancelar',
                    applyLabel: "Aplicar",
                    fromLabel: "De",
                    toLabel: "A",
                    customRangeLabel: "Personalizado",
                    weekLabel: "S",
                    daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                }
            });
            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });


        // Función para Input Fechas PROYECTOS
        $(function() {
            $('input[name="fechaProyecto"]').daterangepicker({
                autoUpdateInput: false,
                showWeekNumbers: true,
                locale: {
                    cancelLabel: 'Cancelar',
                    applyLabel: "Aplicar",
                    fromLabel: "De",
                    toLabel: "A",
                    customRangeLabel: "Personalizado",
                    weekLabel: "S",
                    daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    monthNames: ["Enero", "Febreo", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                }
            });
            $('input[name="fechaProyecto"]').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));

                // Actualiza fecha TAREAS cuando se Aplica el rango.
                let rangoFecha = picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY');
                let idProyecto = localStorage.getItem('idProyecto');
                actualizarProyectos(rangoFecha, 'rango_fecha', idProyecto);
            });
            $('input[name="fechaProyecto"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        })


        // Expande las actividades de los proyectos y Cambia el icono
        function expandirProyectos(id, idProyecto) {
            document.getElementById(id + "toggle").classList.toggle("hidden");

            if (document.getElementById("icono" + idProyecto).classList[1] == "fa-chevron-down") {
                document.getElementById("icono" + idProyecto).classList.remove("fa-chevron-down");
                document.getElementById("icono" + idProyecto).classList.add("fa-chevron-right");
            } else {
                document.getElementById("icono" + idProyecto).classList.add("fa-chevron-down");
                document.getElementById("icono" + idProyecto).classList.remove("fa-chevron-right");
            }
        }


        // Obtiene los proyectos de las secciones
        function obtenerProyectosP(tipoOrden) {
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let idSeccion = localStorage.getItem('idSeccion');
            let idSubseccion = localStorage.getItem('idSubseccion');
            let palabraProyecto = document.getElementById("palabraProyecto").value;
            // Función para darle estilo a los botones
            claseBotonesProyecto('proyectosPendientes');

            // Agrega el tipo de orden en las columnas.
            document.getElementById("proyectoOrden").setAttribute('onclick', 'obtenerProyectosP("PROYECTO")');
            document.getElementById("proyectoOrdenPDA").setAttribute('onclick', 'obtenerProyectosP("PDA")');
            document.getElementById("proyectoOrdenRESP").setAttribute('onclick', 'obtenerProyectosP("RESP")');
            document.getElementById("proyectoOrdenFECHA").setAttribute('onclick', 'obtenerProyectosP("FECHA")');
            document.getElementById("proyectoOrdenCOT").setAttribute('onclick', 'obtenerProyectosP("COT")');
            document.getElementById("proyectoOrdenTIPO").setAttribute('onclick', 'obtenerProyectosP("TIPO")');
            document.getElementById("proyectoOrdenJUST").setAttribute('onclick', 'obtenerProyectosP("JUST")');
            document.getElementById("proyectoOrdenCOSTE").setAttribute('onclick', 'obtenerProyectosP("COSTE")');

            // Secciones de Botones.
            document.getElementById("seccionProyectos").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
            document.getElementById("btnProyecto").setAttribute('onclick', 'obtenerProyectosP("PROYECTO")');
            document.getElementById("palabraProyecto").setAttribute('onkeyup', 'obtenerProyectosP("PROYECTO")');
            document.getElementById("modalProyectos").classList.add('open');
            document.getElementById("btnCrearProyecto").setAttribute('onclick', 'agregarProyecto()');
            document.getElementById("btnNuevoProyecto").setAttribute('onclick', 'datosAgregarProyecto()');
            document.getElementById("btnSolucionadosProyectos").setAttribute('onclick', 'obtenerProyectosS("PROYECTO")');
            document.getElementById("btnGanttProyecto").setAttribute('onclick', 'ganttP()');

            // Oculta y Muestra contenido
            document.getElementById("contenidoProyectos").classList.remove('hidden');
            document.getElementById("paginacionProyectos").classList.remove('hidden');
            document.getElementById("contenidoGantt").classList.add('hidden');

            const action = "obtenerProyectosP";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idSeccion: idSeccion,
                    idSubseccion: idSubseccion,
                    palabraProyecto: palabraProyecto,
                    tipoOrden: tipoOrden
                },
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    // alertaImg('Proyectos Pendientes: ' + data.totalProyectos, '', 'info', 4000);
                    document.getElementById("dataProyectos").innerHTML = data.dataProyectos;
                    document.getElementById("seccionProyectos").innerHTML = data.seccion;
                    estiloSeccionModal('estiloSeccionProyectos', data.seccion);
                    paginacionProyectos();
                }
            });
        }


        // Obtiene los proyectos de las secciones
        function obtenerProyectosS(tipoOrden) {
            // Obtiene datos
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let idSeccion = localStorage.getItem('idSeccion');
            let idSubseccion = localStorage.getItem('idSubseccion');
            let palabraProyecto = document.getElementById("palabraProyecto").value;

            // Función para Botones
            claseBotonesProyecto('proyectosSolucionados');

            // Agrega el tipo de orden en las columnas.
            document.getElementById("proyectoOrden").setAttribute('onclick', 'obtenerProyectosS("PROYECTO")');
            document.getElementById("proyectoOrdenPDA").setAttribute('onclick', 'obtenerProyectosS("PDA")');
            document.getElementById("proyectoOrdenRESP").setAttribute('onclick', 'obtenerProyectosS("RESP")');
            document.getElementById("proyectoOrdenFECHA").setAttribute('onclick', 'obtenerProyectosS("FECHA")');
            document.getElementById("proyectoOrdenCOT").setAttribute('onclick', 'obtenerProyectosS("COT")');
            document.getElementById("proyectoOrdenTIPO").setAttribute('onclick', 'obtenerProyectosS("TIPO")');
            document.getElementById("proyectoOrdenJUST").setAttribute('onclick', 'obtenerProyectosS("JUST")');
            document.getElementById("proyectoOrdenCOSTE").setAttribute('onclick', 'obtenerProyectosS("COSTE")');


            document.getElementById("seccionProyectos").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
            document.getElementById("palabraProyecto").setAttribute('onkeyup', 'obtenerProyectosS("PROYECTO")');
            document.getElementById("modalProyectos").classList.add('open');
            document.getElementById("btnCrearProyecto").setAttribute('onclick', 'agregarProyecto()');
            document.getElementById("btnNuevoProyecto").setAttribute('onclick', 'datosAgregarProyecto()');
            document.getElementById("btnPendientesProyectos").setAttribute('onclick', 'obtenerProyectosP("PROYECTO")');

            // Oculta y Muestra contenido
            document.getElementById("contenidoProyectos").classList.remove('hidden');
            document.getElementById("paginacionProyectos").classList.remove('hidden');
            document.getElementById("contenidoGantt").classList.add('hidden');

            const action = "obtenerProyectosS";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idSeccion: idSeccion,
                    idSubseccion: idSubseccion,
                    palabraProyecto: palabraProyecto,
                    tipoOrden: tipoOrden
                },
                dataType: "JSON",
                success: function(data) {
                    alertaImg('Proyectos Finalizados: ' + data.totalProyectos, '', 'info', 4000);
                    document.getElementById("dataProyectos").innerHTML = data.dataProyectos;
                    document.getElementById("seccionProyectos").innerHTML = data.seccion;
                    estiloSeccionModal('estiloSeccionProyectos', data.seccion);
                    paginacionProyectos();
                }
            });
        }


        // Función para Paginar los resultados de los Equipos Obtenidos.
        function paginacionProyectos() {
            $("#paginacionProyectos").jPages({
                containerID: 'dataProyectos',
                perPage: 15,
                startPage: 1,
                endRange: 1,
                midRange: 1,
                previous: 'anterior',
                next: 'siguiente',
                animation: false,
            });
            $("#paginacionProyectos>a").addClass('-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150');

        }


        // Obtener Opciones de Responsables para Proyectos
        function datosAgregarProyecto() {
            document.getElementById("responsableProyectoN").innerHTML = '';
            document.getElementById("modalAgregarProyecto").classList.add('open');
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');

            const action = "obtenerResponsables";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino
                },
                dataType: "JSON",
                success: function(data) {
                    document.getElementById("responsableProyectoN").innerHTML = data.dataUsuarios;
                }
            });
        }


        // Agregar Proyecto
        function agregarProyecto() {
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let idSeccion = localStorage.getItem('idSeccion');
            let idSubseccion = 200;
            let titulo = document.getElementById("tituloProyectoN").value;
            let tipo = document.getElementById("tipoProyectoN").value;
            let fecha = document.getElementById("fechaProyectoN").value;
            let responsable = document.getElementById("responsableProyectoN").value;
            let justificacion = document.getElementById("justificacionProyectoN").value;
            let coste = document.getElementById("costeProyectoN").value;
            const action = "agregarProyecto";
            if (titulo.length >= 1 && tipo.length >= 1 && fecha.length >= 5 && justificacion.length >= 1 && coste >= 0 && responsable > 0) {
                $.ajax({
                    type: "POST",
                    url: "php/plannerCrudPHP.php",
                    data: {
                        action: action,
                        idUsuario: idUsuario,
                        idDestino: idDestino,
                        idSeccion: idSeccion,
                        idSubseccion: idSubseccion,
                        titulo: titulo,
                        tipo: tipo,
                        fecha: fecha,
                        responsable: responsable,
                        justificacion: justificacion,
                        coste: coste
                    },
                    // dataType: "JSON",
                    success: function(data) {
                        if (data == 1) {
                            obtenerProyectosP('PROYECTO');
                            alertaImg('Proyecto Agregado', '', 'success', 2500);
                            document.getElementById("tituloProyectoN").value = '';
                            document.getElementById("tipoProyectoN").value = '';
                            document.getElementById("fechaProyectoN").value = '';
                            document.getElementById("responsableProyectoN").value = '';
                            document.getElementById("justificacionProyectoN").value = '';
                            document.getElementById("costeProyectoN").value = '';
                            document.getElementById("modalAgregarProyecto").classList.remove('open');
                        } else {
                            alertaImg('Intente de Nuevo', '', 'info', 3000);
                        }
                    }
                });
            } else {
                alertaImg('Información NO Valida', '', 'warning', 3000);
            }
        }


        //Optienes Usuarios posible para asignar responsable en Proyectos. 
        function obtenerResponsablesProyectos(idProyecto) {
            document.getElementById("palabraUsuario").setAttribute('onkeyup', 'obtenerResponsablesProyectos(' + idProyecto + ')');
            document.getElementById("modalUsuarios").classList.add('open');
            let idItem = idProyecto;
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let tipoAsginacion = "asignarProyecto";
            let palabraUsuario = document.getElementById("palabraUsuario").value;
            const action = "obtenerUsuarios";

            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idItem: idItem,
                    tipoAsginacion: tipoAsginacion,
                    palabraUsuario: palabraUsuario
                },
                dataType: "JSON",
                success: function(data) {
                    document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
                    alertaImg('Usuarios Obtenidos: ' + data.totalUsuarios, '', 'info', 200);
                }
            });
        }


        // Función para  Actualizar Información de un proyecto en la tabla t_proyectos
        function actualizarProyectos(valor, columna, idProyecto) {
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let tipo = document.getElementById("tipoProyecto").value;
            let justificacion = document.getElementById("justificacionProyecto").value;
            let coste = document.getElementById("costeProyecto").value;
            let titulo = document.getElementById("inputEditarTitulo").value;
            const action = "actualizarProyectos";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    valor: valor,
                    columna: columna,
                    idProyecto: idProyecto,
                    justificacion: justificacion,
                    tipo: tipo,
                    coste: coste,
                    titulo: titulo
                },
                // dataType: "JSON",
                success: function(data) {
                    if (data == 1) {
                        obtenerProyectosP('PROYECTO');
                        alertaImg('Responsable Actualizado', '', 'success', 2000);
                        document.getElementById("modalUsuarios").classList.remove('open');
                    } else if (data == 2) {
                        obtenerProyectosP('PROYECTO');
                        document.getElementById("modalActualizarProyecto").classList.remove('open');
                        alertaImg('Justifiacion Actualizado', '', 'success', 2000);
                    } else if (data == 3) {
                        obtenerProyectosP('PROYECTO');
                        document.getElementById("modalActualizarProyecto").classList.remove('open');
                        alertaImg('Coste Actualizado', '', 'success', 2000);
                    } else if (data == 4) {
                        obtenerProyectosP('PROYECTO');
                        document.getElementById("modalActualizarProyecto").classList.remove('open');
                        alertaImg('Tipo Actualizado', '', 'success', 2000);
                    } else if (data == 5) {
                        obtenerProyectosP('PROYECTO');
                        document.getElementById("modalFechaProyectos").classList.remove('open');
                        alertaImg('Fecha Actualizada', '', 'success', 2000);
                    } else if (data == 6) {
                        obtenerProyectosP('PROYECTO');
                        document.getElementById("modalTituloEliminar").classList.remove('open');
                        alertaImg('Proyecto Eliminado', '', 'success', 2000);
                    } else if (data == 7) {
                        obtenerProyectosP('PROYECTO');
                        document.getElementById("modalTituloEliminar").classList.remove('open');
                        document.getElementById("modalEditarTitulo").classList.remove('open');
                        alertaImg('Título Actualizado', '', 'success', 2000);
                    } else if (data == 8) {
                        obtenerProyectosP('PROYECTO');
                        document.getElementById("modalTituloEliminar").classList.remove('open');
                        alertaImg('Proyecto Finalizado', '', 'success', 2000);
                    } else if (data == 9) {
                        obtenerProyectosP('PROYECTO');
                        document.getElementById("modalTituloEliminar").classList.remove('open');
                        alertaImg('Proyecto Restaurado', '', 'success', 2000);
                    } else if (data == 10) {
                        alertaImg("Solucione todas las actividades para poder Solucionar el Proyecto", "", "warning", 4000);
                    } else {
                        alertaImg('Intente de Nuevo', '', 'info', 3000);
                    }
                }
            });
        }


        // ACTUALIZA LA JUSTIFICACION DE LOS PROYECTOS
        function obtenerDatoProyectos(idProyecto, columna) {
            localStorage.setItem("idProyecto", idProyecto);

            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");

            // Oculta Media en Justificación
            document.getElementById("mediaProyectos").classList.add('hidden');
            document.getElementById("dataImagenesProyecto").innerHTML = '';
            document.getElementById("dataAdjuntosProyecto").innerHTML = '';

            document.getElementById("tipoProyectoDiv").classList.add("hidden");
            document.getElementById("justificacionProyectoDiv").classList.add("hidden");
            document.getElementById("costeProyectoDiv").classList.add("hidden");

            if (columna == "justificacion") {
                justificacionAdjuntosProyectos(idProyecto);
                document.getElementById("modalActualizarProyecto").classList.add("open");
                document.getElementById("tituloActualizarProyecto").innerHTML =
                    "JUSTIFIACIÓN";

                document
                    .getElementById("justificacionProyectoDiv")
                    .classList.remove("hidden");

                document
                    .getElementById("inputAdjuntosJP")
                    .setAttribute(
                        "onchange",
                        "subirJustificacionProyectos(" + idProyecto + ', "t_proyectos_justificaciones")'
                    );

            } else if (columna == "coste") {
                document.getElementById("modalActualizarProyecto").classList.add("open");
                document.getElementById("tituloActualizarProyecto").innerHTML = "COSTE";
                document.getElementById("costeProyectoDiv").classList.remove("hidden");
            } else if (columna == "tipo") {
                document.getElementById("modalActualizarProyecto").classList.add("open");
                document.getElementById("tituloActualizarProyecto").innerHTML = "TIPO";
                document.getElementById("tipoProyectoDiv").classList.remove("hidden");
            } else if (columna == "rango_fecha") {
                document.getElementById("modalFechaProyectos").classList.add("open");
            }

            const action = "obtenerDatoProyectos";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idProyecto: idProyecto,
                    columna: columna,
                },
                dataType: "JSON",
                success: function(data) {
                    document.getElementById("tipoProyecto").value = data.tipo;
                    document.getElementById("justificacionProyecto").value =
                        data.justificacion;
                    document.getElementById("costeProyecto").value = data.coste;
                    document.getElementById("fechaProyecto").value = data.rangoFecha;

                    document
                        .getElementById("btnGuardarInformacion")
                        .setAttribute(
                            "onclick",
                            'actualizarProyectos(0, "' + columna + '",' + idProyecto + ")"
                        );
                },
            });
        }


        //Sube Justificacion de Proyectos
        function subirJustificacionProyectos(idTabla, tabla) {
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let img = document.getElementById("inputAdjuntosJP").files;

            for (let index = 0; index < img.length; index++) {
                let imgData = new FormData();
                const action = "subirImagenGeneral";
                document.getElementById("cargandoAdjuntoJP").innerHTML =
                    '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

                imgData.append("adjuntoUrl", img[index]);
                imgData.append("action", action);
                imgData.append("idUsuario", idUsuario);
                imgData.append("idDestino", idDestino);
                imgData.append("tabla", tabla);
                imgData.append("idTabla", idTabla);

                $.ajax({
                    data: imgData,
                    type: "POST",
                    url: "php/plannerCrudPHP.php",
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data == 1) {
                            alertaImg("Proceso Cancelado", "", "info", 3000);
                        } else if (data == 6) {
                            alertaImg("Adjunto Agregado", "", "success", 2500);
                            obtenerDatoProyectos(idTabla, 'justificacion');
                        } else {
                            alertaImg("Intente de Nuevo", "", "info", 3000);
                        }
                        document.getElementById("cargandoAdjuntoJP").innerHTML = '';
                    },
                });
            }
        }


        // Justificación Proyectos Adjuntos
        function justificacionAdjuntosProyectos(idProyecto) {

            document.getElementById("dataImagenesProyecto").innerHTML = '';
            document.getElementById("dataAdjuntosProyecto").innerHTML = '';
            document.getElementById("mediaProyectos").classList.remove('hidden');
            document.getElementById("contenedorImagenesJP").classList.add('hidden');
            document.getElementById("contenedorDocumentosJP").classList.add('hidden');


            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let idTabla = idProyecto;
            const tabla = "t_proyectos_justificaciones";
            const action = "obtenerAdjuntos";

            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idProyecto: idProyecto,
                    idTabla: idTabla,
                    tabla: tabla
                },
                dataType: "JSON",
                success: function(data) {
                    if (data.imagen != "") {
                        document.getElementById("dataImagenesProyecto").innerHTML = data.imagen;
                        document.getElementById("contenedorImagenesJP").classList.remove('hidden');
                    }

                    if (data.documento != "") {
                        document.getElementById("dataAdjuntosProyecto").innerHTML = data.documento;
                        document.getElementById("contenedorDocumentosJP").classList.remove('hidden');
                    }

                }
            });
        }


        // Obtener Status de proyectos
        function statusProyecto(idProyecto) {
            document.getElementById("modalTituloEliminar").classList.add('open');
            let tituloActual = document.getElementById("tituloP" + idProyecto).innerHTML;
            document.getElementById("inputEditarTitulo").value = tituloActual;

            document.getElementById("btnEditarTitulo").
            setAttribute('onclick', 'actualizarProyectos(0, "titulo",' + idProyecto + ')');

            document.getElementById("eliminar").
            setAttribute('onclick', 'actualizarProyectos(0, "eliminar",' + idProyecto + ')');

            document.getElementById("finalizar").
            setAttribute('onclick', 'actualizarProyectos("F", "status",' + idProyecto + ')');
        }


        // Obtienes las Cotizaciones de PROYECTOS
        function cotizacionesProyectos(idProyecto) {
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let idTabla = idProyecto;
            let tabla = "t_proyectos_adjuntos";

            document.getElementById("contenedorImagenes").classList.add('hidden');
            document.getElementById("contenedorDocumentos").classList.add('hidden');

            document.getElementById("modalMedia").classList.add("open");
            document
                .getElementById("inputAdjuntos")
                .setAttribute(
                    "onchange",
                    "subirImagenGeneral(" + idProyecto + ', "t_proyectos_adjuntos")'
                );

            const action = "obtenerAdjuntos";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idTabla: idTabla,
                    tabla: tabla,
                },
                dataType: "JSON",
                success: function(data) {

                    if (data.imagen != "") {
                        document.getElementById("dataImagenes").innerHTML = data.imagen;
                        document.getElementById("contenedorImagenes").classList.remove('hidden');
                    }

                    if (data.documento != "") {
                        document.getElementById("dataAdjuntos").innerHTML = data.documento;
                        document.getElementById("contenedorDocumentos").classList.remove('hidden');
                    }
                },
            });
        }


        // Agrega una Actividad en PROYECTOS.
        function agregarPlanaccion(idProyecto) {
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let actividad = document.getElementById("NA" + idProyecto).value;
            if (actividad.length >= 1) {
                const action = "agregarPlanaccion";
                $.ajax({
                    type: "POST",
                    url: "php/plannerCrudPHP.php",
                    data: {
                        action: action,
                        idUsuario: idUsuario,
                        idDestino: idDestino,
                        idProyecto: idProyecto,
                        actividad: actividad
                    },
                    // dataType: "JSON",
                    success: function(data) {
                        if (data.length > 1) {
                            obtenerProyectosP('PROYECTO');
                            alertaImg('Actividad Agregada', '', 'success', 2500);
                            expandir('proyecto' + idProyecto);
                        } else {
                            alertaImg('Intente de Nuevo', '', 'info', 3000);
                        }
                    }
                });
            } else {
                alertaImg('Intente de Nuevo', '', 'info', 3000);
            }
        }


        // Obtener posibles RESPONSABLES para PLANACCION
        function obtenerResponsablesPlanaccion(idPlanaccion) {
            document.getElementById("palabraUsuario").setAttribute('onkeyup', 'obtenerResponsablesPlanaccion(' + idPlanaccion + ')');
            document.getElementById("modalUsuarios").classList.add('open');
            let idItem = idPlanaccion;
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let tipoAsginacion = "asignarPlanaccion";
            let palabraUsuario = document.getElementById("palabraUsuario").value;
            const action = "obtenerUsuarios";

            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idItem: idItem,
                    tipoAsginacion: tipoAsginacion,
                    palabraUsuario: palabraUsuario
                },
                dataType: "JSON",
                success: function(data) {
                    document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
                    alertaImg('Usuarios Obtenidos: ' + data.totalUsuarios, '', 'info', 200);
                }
            });
        }


        // Actualizar PLANACCION
        function actualizarPlanaccion(valor, columna, idPlanaccion) {
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let idSeccion = localStorage.getItem('idSeccion');
            let actividad = document.getElementById("inputEditarTitulo").value;
            let codigoSeguimiento = document.getElementById("codigoSeguimiento").value;

            const action = "actualizarPlanaccion";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idSeccion: idSeccion,
                    idPlanaccion: idPlanaccion,
                    valor: valor,
                    columna: columna,
                    actividad: actividad,
                    codigoSeguimiento: codigoSeguimiento

                },
                // dataType: "JSON",
                success: function(data) {
                    obtenerProyectosP('PROYECTO');
                    if (data == 1) {
                        document.getElementById("modalUsuarios").classList.remove('open');
                        alertaImg('Responsable Actualizado', '', 'success', 2500);
                    } else if (data == 2) {
                        document.getElementById("modalEditarTitulo").classList.remove('open');
                        document.getElementById("modalStatus").classList.remove('open');
                        alertaImg('Actividad Actualizada', '', 'success', 2500);
                    } else if (data == 3) {
                        document.getElementById("modalStatus").classList.remove('open');
                        alertaImg('Actividad Eliminada', '', 'success', 2500);
                    } else if (data == 4) {
                        document.getElementById("modalStatus").classList.remove('open');
                        alertaImg('Actividad Solucionada', '', 'success', 2500);
                    } else if (data == 5) {
                        document.getElementById("modalStatus").classList.remove('open');
                        alertaImg('Status Actualizado', '', 'success', 2500);
                    } else if (data == 6) {
                        document.getElementById("modalStatus").classList.remove('open');
                        alertaImg('Actividad Restaurada', '', 'success', 2500);
                    } else if (data == 7) {
                        document.getElementById("modalStatus").classList.remove('open');
                        alertaImg('Status Material, Activado', '', 'success', 2500);
                    } else if (data == 8) {
                        document.getElementById("modalStatus").classList.remove('open');
                        alertaImg('Status Material, Desactivado', '', 'success', 2500);
                    }
                }
            });
        }


        // Status para Planaccion
        function statusPlanaccion(idPlanaccion) {
            let actividadActual = document.getElementById("AP" + idPlanaccion).innerHTML;

            document.getElementById("inputEditarTitulo").value = actividadActual;
            document.getElementById("modalStatus").classList.add("open");
            document.getElementById("statusMaterialtoggle").classList.add("hidden");

            // Agregan Funciones en los Botones del modalStatus para poder Aplicar un Status
            document.getElementById("btnEditarTitulo").setAttribute("onclick", 'actualizarPlanaccion(0,"actividad",' + idPlanaccion + ")");

            document.getElementById("statusActivo").setAttribute("onclick", 'actualizarPlanaccion(0,"activo",' + idPlanaccion + ")");

            document.getElementById("statusFinalizar").setAttribute("onclick", 'actualizarPlanaccion("F","status",' + idPlanaccion + ")");

            document.getElementById("statusMaterialBtn").setAttribute("onclick", 'actualizarPlanaccion(1, "status_material",' + idPlanaccion + ")");

            document.getElementById("statusTrabajare").setAttribute("onclick", 'actualizarPlanaccion(1, "status_trabajando",' + idPlanaccion + ")");

            document.getElementById("statusElectricidad").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_electricidad",' + idPlanaccion + ")");

            document.getElementById("statusAgua").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_agua",' + idPlanaccion + ")");

            document.getElementById("statusDiesel").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_diesel",' + idPlanaccion + ")");

            document.getElementById("statusGas").setAttribute("onclick", 'actualizarPlanaccion(1, "energetico_gas",' + idPlanaccion + ")");

            document.getElementById("statusRRHH").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_rrhh",' + idPlanaccion + ")");

            document.getElementById("statusCalidad").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_calidad",' + idPlanaccion + ")");

            document.getElementById("statusDireccion").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_direccion",' + idPlanaccion + ")");

            document.getElementById("statusFinanzas").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_finanzas",' + idPlanaccion + ")");

            document.getElementById("statusCompras").setAttribute("onclick", 'actualizarPlanaccion(1, "departamento_compras",' + idPlanaccion + ")");

            // Llama la función para formatear el Modal de Status
            estiloDefectoModalStatus();

            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let idSeccion = localStorage.getItem("idSeccion");
            const action = "statusPlanaccion";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idSeccion: idSeccion,
                    idPlanaccion: idPlanaccion,
                },
                dataType: "JSON",
                success: function(data) {
                    document.getElementById("codigoSeguimiento").value = data.codsap;

                    if (data.sMaterial == 1) {
                        document.getElementById("statusMaterial").classList.add("bg-orange-200");
                    }

                    if (data.sTrabajando == 1) {
                        document.getElementById("statusTrabajare").classList.add("bg-blue-200");
                    }

                    if (
                        data.eElectricidad == 1 ||
                        data.eAgua == 1 ||
                        data.eDiesel == 1 ||
                        data.eGas == 1
                    ) {
                        document
                            .getElementById("statusenergeticos")
                            .classList.add("bg-yellow-200");
                    }

                    if (data.eElectricidad == 1) {
                        document
                            .getElementById("statusElectricidad")
                            .classList.add("bg-yellow-200");
                    }

                    if (data.eAgua == 1) {
                        document.getElementById("statusAgua").classList.add("bg-yellow-200");
                    }

                    if (data.eDiesel == 1) {
                        document.getElementById("statusDiesel").classList.add("bg-yellow-200");
                    }

                    if (data.eGas == 1) {
                        document.getElementById("statusGas").classList.add("bg-yellow-200");
                    }

                    if (
                        data.dCalidad == 1 ||
                        data.dCompras == 1 ||
                        data.dDireccion == 1 ||
                        data.dFinanzas == 1 ||
                        data.dRRHH == 1
                    ) {
                        document.getElementById("statusdep").classList.add("bg-teal-200");
                    }

                    if (data.dCalidad == 1) {
                        document.getElementById("statusCalidad").classList.add("bg-teal-200");
                    }

                    if (data.dCompras == 1) {
                        document.getElementById("statusCompras").classList.add("bg-teal-200");
                    }

                    if (data.dDireccion == 1) {
                        document.getElementById("statusDireccion").classList.add("bg-teal-200");
                    }

                    if (data.dFinanzas == 1) {
                        document.getElementById("statusFinanzas").classList.add("bg-teal-200");
                    }

                    if (data.dRRHH == 1) {
                        document.getElementById("statusRRHH").classList.add("bg-teal-200");
                    }
                },
            });
        }


        // Comentarios para Planaccion
        function comentariosPlanaccion(idPlanaccion) {
            document.getElementById("btnComentario").
            setAttribute('onclick', 'agregarComentarioPlanaccion(' + idPlanaccion + ')');
            document.getElementById("modalComentarios").classList.add('open');

            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');

            const action = "comentariosPlanaccion";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idPlanaccion: idPlanaccion
                },
                // dataType: "JSON",
                success: function(data) {
                    document.getElementById("dataComentarios").innerHTML = data;
                }
            });
        }


        // Muestra los adjuntos de Planaccion
        function adjuntosPlanaccion(idPlanaccion) {
            document.getElementById("modalMedia").classList.add('open');
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let idTabla = idPlanaccion;
            let tabla = "t_proyectos_planaccion_adjuntos";

            document.getElementById("inputAdjuntos").setAttribute('onchange', 'subirImagenGeneral(' + idPlanaccion + ', "t_proyectos_planaccion_adjuntos")');

            const action = "obtenerAdjuntos";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idTabla: idTabla,
                    tabla: tabla
                },
                dataType: "JSON",
                success: function(data) {
                    document.getElementById("dataImagenes").innerHTML = data.imagen;
                    document.getElementById("dataAdjuntos").innerHTML = data.documento;
                }
            });
        }


        // Agrega Comentario en Planaccion
        function agregarComentarioPlanaccion(idPlanaccion) {
            let comentario = document.getElementById("inputComentario").value;
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');

            const action = "agregarComentarioPlanaccion";
            if (comentario.length > 0) {
                $.ajax({
                    type: "POST",
                    url: "php/plannerCrudPHP.php",
                    data: {
                        action: action,
                        idUsuario: idUsuario,
                        idDestino: idDestino,
                        idPlanaccion: idPlanaccion,
                        comentario: comentario
                    },
                    // dataType: "JSON",
                    success: function(data) {
                        if (data == 1) {
                            obtenerProyectosP('PROYECTO');
                            comentariosPlanaccion(idPlanaccion);
                            document.getElementById("inputComentario").value = '';
                            alertaImg('Comentario Agregado', '', 'success', 2500);
                        } else {
                            alertaImg('Intente de Nuevo', '', 'info', 2500);
                        }
                    }
                });
            } else {
                alertaImg('Comentario NO Valido', '', 'info', 2500);
            }
        }


        // Sube imagenes con dos parametros, con el formulario #inputAdjuntos
        function subirImagenGeneral(idTabla, tabla) {
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let img = document.getElementById("inputAdjuntos").files;

            for (let index = 0; index < img.length; index++) {

                let imgData = new FormData();
                const action = "subirImagenGeneral";
                document.getElementById("cargandoAdjunto").
                innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

                imgData.append("adjuntoUrl", img[index]);
                imgData.append("action", action);
                imgData.append("idUsuario", idUsuario);
                imgData.append("idDestino", idDestino);
                imgData.append("tabla", tabla);
                imgData.append("idTabla", idTabla);

                $.ajax({
                    data: imgData,
                    type: "POST",
                    url: "php/plannerCrudPHP.php",
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        document.getElementById("cargandoAdjunto").innerHTML = '';
                        document.getElementById("inputAdjuntos").value = '';
                        if (data == 1) {
                            alertaImg('Proceso Cancelado', '', 'info', 3000);
                        } else if (data == 2) {
                            alertaImg('Archivo Pesado (MAX:99MB)', '', 'info', 3000);

                            // Sube y Actualiza la Vista para las Cotizaciones de Proyectos.
                        } else if (data == 3) {
                            alertaImg('Cotización Agregada', '', 'success', 2500);
                            obtenerProyectosP('PROYECTO');
                            cotizacionesProyectos(idTabla);

                            // Sube y Actualiza la Vista para los Adjuntos de Planaccion.
                        } else if (data == 4) {
                            alertaImg('Adjunto Agregado', '', 'success', 2500);
                            obtenerProyectosP('PROYECTO');
                            adjuntosPlanaccion(idTabla);
                        } else if (data == 5) {
                            alertaImg('Adjunto Agregado', '', 'success', 2500);
                            obtenerMediaEquipo(idTabla);
                        } else {
                            alertaImg('Intente de Nuevo', '', 'info', 3000);
                        }
                    }
                });
            }
        }


        function ganttP() {
            // Cambia diseño de Botones en Proyectos
            claseBotonesProyecto('ganttPendientes');

            // Oculta y Muestra contenido
            document.getElementById("contenidoProyectos").classList.add('hidden');
            document.getElementById("paginacionProyectos").classList.add('hidden');
            document.getElementById("contenidoGantt").classList.remove('hidden');

            document.getElementById("btnPendientesProyectos").setAttribute('onclick', 'ganttP()');
            document.getElementById("btnSolucionadosProyectos").setAttribute('onclick', 'ganttS()');
            document.getElementById("palabraProyecto").setAttribute('onkeyup', 'ganttP()');

            // Data URL
            const action = "ganttProyectosP";
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let idSeccion = localStorage.getItem('idSeccion');
            let idSubseccion = 200;
            let palabraProyecto = document.getElementById("palabraProyecto").value;
            let dataURL = 'php/graficas_am4charts.php?action=' + action + '&idUsuario=' + idUsuario + '&idDestino=' + idDestino + '&idSeccion=' + idSeccion + '&idSubseccion=' + idSubseccion + '&palabraProyecto=' + palabraProyecto;

            fetch(dataURL)
                .then(res => res.json())
                .then(dataGantt => {

                    const arrayTratado = new Promise((resolve, recject) => {
                        for (var i = 0; i < dataGantt.length; i++) {
                            var colorSet = new am4core.ColorSet();
                            dataGantt[i]['color'] = colorSet.getIndex(i);
                        }
                        resolve(dataGantt);
                    });

                    arrayTratado.then((response) => {
                        generarGantt(response);
                    }).catch((error) => {});

                    alertaImg('Gantt Pendientes: ' + dataGantt.length, '', 'info', 4000);
                    let size = 100 + (dataGantt.length * 50);
                    document.getElementById("chartdiv").setAttribute('style', 'height:' + size + 'px');
                });

            function generarGantt(dataGantt) {

                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart = am4core.create("chartdiv", am4charts.XYChart);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart.paddingRight = 30;
                chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

                var colorSet = new am4core.ColorSet();
                colorSet.saturation = 0.4;

                chart.data = dataGantt;
                chart.dateFormatter.dateFormat = "yyyy-MM-dd";
                chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "category";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.inversed = true;

                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.renderer.minGridDistance = 70;
                dateAxis.baseInterval = {
                    count: 1,
                    timeUnit: "day"
                };
                dateAxis.renderer.tooltipLocation = 0;

                var series1 = chart.series.push(new am4charts.ColumnSeries());
                series1.columns.template.height = am4core.percent(70);
                series1.columns.template.tooltipText = "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

                series1.dataFields.openDateX = "start";
                series1.dataFields.dateX = "end";
                series1.dataFields.categoryY = "category";
                series1.columns.template.propertyFields.fill = "color"; // get color from data
                series1.columns.template.propertyFields.stroke = "color";
                series1.columns.template.strokeOpacity = 1;

                chart.scrollbarX = new am4core.Scrollbar();
            }
        }


        function ganttS() {
            // Cambia estilo de Botones en Proyectos
            claseBotonesProyecto('ganttSolucionados');

            // Oculta y Muestra contenido
            document.getElementById("contenidoProyectos").classList.add('hidden');
            document.getElementById("paginacionProyectos").classList.add('hidden');
            document.getElementById("contenidoGantt").classList.remove('hidden');

            document.getElementById("btnGanttProyecto").setAttribute('onclick', 'ganttS()');
            document.getElementById("palabraProyecto").setAttribute('onkeyup', 'ganttS()');

            // Data URL
            const action = "ganttProyectosS";
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            let idSeccion = localStorage.getItem('idSeccion');
            let idSubseccion = 200;
            let palabraProyecto = document.getElementById("palabraProyecto").value;
            let dataURL = 'php/graficas_am4charts.php?action=' + action + '&idUsuario=' + idUsuario + '&idDestino=' + idDestino + '&idSeccion=' + idSeccion + '&idSubseccion=' + idSubseccion + '&palabraProyecto=' + palabraProyecto;


            fetch(dataURL)
                .then(res => res.json())
                .then(dataGantt => {

                    const arrayTratado = new Promise((resolve, recject) => {
                        for (var i = 0; i < dataGantt.length; i++) {
                            var colorSet = new am4core.ColorSet();
                            dataGantt[i]['color'] = colorSet.getIndex(i);
                        }
                        resolve(dataGantt);
                    });

                    arrayTratado.then((response) => {
                        generarGantt(response);
                    }).catch((error) => {});

                    alertaImg('Gantt Solucionados: ' + dataGantt.length, '', 'info', 4000);
                    let size = 100 + (dataGantt.length * 50);
                    document.getElementById("chartdiv").setAttribute('style', 'height:' + size + 'px');
                });

            function generarGantt(dataGantt) {

                am4core.useTheme(am4themes_animated);
                // Themes end

                var chart = am4core.create("chartdiv", am4charts.XYChart);
                chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

                chart.paddingRight = 30;
                chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm";

                var colorSet = new am4core.ColorSet();
                colorSet.saturation = 0.4;

                chart.data = dataGantt;
                chart.dateFormatter.dateFormat = "yyyy-MM-dd";
                chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

                var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
                categoryAxis.dataFields.category = "category";
                categoryAxis.renderer.grid.template.location = 0;
                categoryAxis.renderer.inversed = true;

                var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
                dateAxis.renderer.minGridDistance = 70;
                dateAxis.baseInterval = {
                    count: 1,
                    timeUnit: "day"
                };
                dateAxis.renderer.tooltipLocation = 0;

                var series1 = chart.series.push(new am4charts.ColumnSeries());
                series1.columns.template.height = am4core.percent(70);
                series1.columns.template.tooltipText = "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

                series1.dataFields.openDateX = "start";
                series1.dataFields.dateX = "end";
                series1.dataFields.categoryY = "category";
                series1.columns.template.propertyFields.fill = "color"; // get color from data
                series1.columns.template.propertyFields.stroke = "color";
                series1.columns.template.strokeOpacity = 1;

                chart.scrollbarX = new am4core.Scrollbar();
            }
        }


        // Funcion para restablecer Estilo ModalStatus
        function estiloDefectoModalStatus() {
            document.getElementById("statusMaterial").classList.remove("bg-orange-200");
            document.getElementById("statusTrabajare").classList.remove("bg-blue-200");

            //Energeticos
            document
                .getElementById("statusenergeticos")
                .classList.remove("bg-yellow-200");
            document
                .getElementById("statusElectricidad")
                .classList.remove("bg-yellow-200");
            document.getElementById("statusAgua").classList.remove("bg-yellow-200");
            document.getElementById("statusDiesel").classList.remove("bg-yellow-200");
            document.getElementById("statusGas").classList.remove("bg-yellow-200");

            //Departamentos
            document.getElementById("statusdep").classList.remove("bg-teal-200");
            document.getElementById("statusRRHH").classList.remove("bg-teal-200");
            document.getElementById("statusCalidad").classList.remove("bg-teal-200");
            document.getElementById("statusDireccion").classList.remove("bg-teal-200");
            document.getElementById("statusFinanzas").classList.remove("bg-teal-200");
            document.getElementById("statusCompras").classList.remove("bg-teal-200");

            //Bitacora
            document.getElementById("statusbitacora").classList.remove("bg-lightblue-50");
            document.getElementById("statusGP").classList.remove("bg-lightblue-50");
            document.getElementById("statusTRS").classList.remove("bg-lightblue-50");
            document.getElementById("statusZI").classList.remove("bg-lightblue-50");
        }


        // Mantener de Ultimo.

        //Funcion para los Botones de Proyectos (Gantt Proyectos)
        function claseBotonesProyecto(tipoSeleccion) {
            document.getElementById("btnProyecto").classList.remove('bg-blue-300');
            document.getElementById("btnGanttProyecto").classList.remove('bg-blue-300');
            document.getElementById("btnSolucionadosProyectos").classList.remove('bg-green-300');
            document.getElementById("btnPendientesProyectos").classList.remove('bg-red-300');

            if (tipoSeleccion == "proyectosPendientes") {
                document.getElementById("btnProyecto").classList.add('bg-blue-300');
                document.getElementById("btnPendientesProyectos").classList.add('bg-red-300');
            } else if (tipoSeleccion == "proyectosSolucionados") {
                document.getElementById("btnProyecto").classList.add('bg-blue-300');
                document.getElementById("btnSolucionadosProyectos").classList.add('bg-green-300');
            } else if (tipoSeleccion == "ganttPendientes") {
                document.getElementById("btnGanttProyecto").classList.add('bg-blue-300');
                document.getElementById("btnPendientesProyectos").classList.add('bg-red-300');
            } else if (tipoSeleccion == "ganttSolucionados") {
                document.getElementById("btnGanttProyecto").classList.add('bg-blue-300');
                document.getElementById("btnSolucionadosProyectos").classList.add('bg-green-300');
            }
        }


        // El estilo se aplica DIV>H1(class="zie-logo").
        function estiloSeccionModal(padreSeccion, seccion) {
            let seccionClase = seccion.toLowerCase() + '-logo-modal';
            document.getElementById(padreSeccion).classList.remove('zil-logo-modal');
            document.getElementById(padreSeccion).classList.remove('zie-logo-modal');
            document.getElementById(padreSeccion).classList.remove('auto-logo-modal');
            document.getElementById(padreSeccion).classList.remove('dec-logo-modal');
            document.getElementById(padreSeccion).classList.remove('dep-logo-modal');
            document.getElementById(padreSeccion).classList.remove('zha-logo-modal');
            document.getElementById(padreSeccion).classList.remove('zhc-logo-modal');
            document.getElementById(padreSeccion).classList.remove('zhp-logo-modal');
            document.getElementById(padreSeccion).classList.remove('zia-logo-modal');
            document.getElementById(padreSeccion).classList.remove('zic-logo-modal');

            document.getElementById(padreSeccion).classList.add(seccionClase);
        }

        // toggleClass Modal TailWind con la clase OPEN.
        function toggleModalTailwind(idModal) {
            $("#" + idModal).toggleClass('open');
        }


        // Funcion toggle por CLASENAME 
        function classNameToggle(nameClass) {
            var x = document.getElementsByClassName(nameClass);
            var i;
            for (i = 0; i < x.length; i++) {
                document.getElementsByClassName(nameClass)[i].classList.toggle('hidden');
            }
        }


        // Actualiza el Coste de Planacción de Proyecto.
        function actualizarPlanaccionReporte(idPlanaccion, input, columna) {
            let valor = document.getElementById(input).value;
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');

            const action = "actualizarPlanaccionReporte";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idPlanaccion: idPlanaccion,
                    valor: valor,
                    columna: columna
                },
                // dataType: "JSON",
                success: function(data) {
                    // console.log(data);

                    let cantidad = document.getElementById("cantidad" + idPlanaccion).value;
                    let coste = document.getElementById("coste" + idPlanaccion).value;
                    document.getElementById("costeTotal" + idPlanaccion).value = cantidad * coste;

                    if (data != 1) {
                        alertaImg('Coste NO Valido', '', 'info', 2500);
                    }
                }
            });
        }


        function generarReporteProyecto(tipoReporte, idProyecto) {
            if (tipoReporte == "excel") {
                // location.href = `php/generar_reporte_proyecto.php?idProyecto=${idProyecto}`;
                window.open(`php/generar_reporte_proyecto.php?idProyecto=${idProyecto}`, "Reporte Excel", "width=300, height=200")
            } else if (tipoReporte == "pdf") {
                location.href = `reportes_PDF/generar_reporte_proyectos.php?idProyecto=${idProyecto}`;
            }
        }



        // Funcion Default.
        obtenerProyectosP('PROYECTO');
    </script>
</body>

</html>