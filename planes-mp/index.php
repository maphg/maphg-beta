<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG Gestion Planes</title>
    <link rel="stylesheet" href="../css/tailwindproduccion.css">
    <link rel="stylesheet" href="../css/fontawesome/css/all.css">
    <link rel="stylesheet" href="../css/modales.css">
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
    <link rel="alternate" href="../css/animate.css" type="application/rss+xml" title="RSS">
    <link rel="stylesheet" href="../css/alertify.min.css">
</head>

<body class="bg-fondos-7 text-bluegray-800 scrollbar">
    <!-- Principal -->
    <div class="flex flex-col container mx-auto py-10 font-light text-3xl">
        <h1>Planes de Mantenimiento</h1>
    </div>
    <div class="flex flex-row container mx-auto text-base mb-6">
        <input id="buscarPlanMP" type="search" name="" id="" placeholder="Buscar Plan"
            class="w-1/4 px-3 bg-white focus:outline-none py-2 rounded-lg shadow-md">
        <button class="btn btn-indigo shadow-md mx-4" onclick="AgregarPlanMP();">
            <i class="fas fa-plus"></i>
            Crear Plan
        </button>
    </div>
    <div class="flex flex-col container mx-auto scrollbar">
        <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 scrollbar">
            <div class="align-middle inline-block min-w-full shadow-md overflow-auto sm:rounded-lg border-b border-gray-200 scrollbar"
                style="max-height: 65vh;">
                <table id="tablaGestionPlanes" class="min-w-full divide-y divide-gray-200 sortable">
                    <thead>
                        <tr class="cursor-pointer">
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                Destino
                            </th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                Marca
                            </th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                Tipo equipo/local
                            </th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                Tipo de plan
                            </th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                Grado
                            </th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-white text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider sticky top-0">
                                Periodicidad
                            </th>
                        </tr>
                    </thead>
                    <tbody id="contenedorDePlanes" class="bg-white divide-y divide-gray-200">
                        <!-- PLANES MANTENIMIENTO... -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Fin Principal -->

    <!-- Modals -->

    <!-- MODAL DETALLES DEL PLAN -->
    <div id="modalDetallesPlanMP" class="modal">
        <div
            class="modal-window w-11/12 flex shadow-lg flex-col justify-center items-center mx-auto text-bluegray-800 pt-10 rounded-lg">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalDetallesPlanMP')"
                    class="cursor-pointer text-md  text-red-500 bg-red-200 px-2 rounded-bl-lg rounded-tr-lg font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-lg rounded-tl-lg">
                    <h1>NUEVO PLAN DE MANTENIMIENTO</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-start flex-row w-full flex-wrap">
                <div class="flex flex-col flex-wrap justify-center items-center mt-6 w-1/4">
                    <div class="w-full px-3 mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            DESTINO
                        </label>
                        <div class="relative">
                            <select id="dataOptionDestinosMP"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-3 mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            MARCA
                        </label>
                        <div class="relative">
                            <select id="dataOpcionFaseMP"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-3 mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            EQUIPO/LOCAL
                        </label>
                        <div class="relative">
                            <select id="equipoLocalPlanMP"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="EQUIPO">EQUIPO</option>
                                <option value="LOCAL">LOCAL</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-3 mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            TIPO DE EQUIPO
                        </label>
                        <div class="relative">
                            <select id="dataOpcionTipoEquiposMP"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">

                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-3 mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            TIPO DE PLAN
                        </label>
                        <div class="relative">
                            <select id="dataOpcionTipoPlan"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="PREVENTIVO">PREVENTIVO</option>
                                <option value="TEST">TEST</option>
                                <option value="CHECKLIST">CHECKLIST</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-3 mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            GRADO
                        </label>
                        <div class="relative">
                            <select id="dataOpcionGradoPlanMP"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option>MENOR</option>
                                <option>MAYOR</option>
                                <option>OVERHAUL</option>
                                <option>N/A</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-3 mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            PERIODICIDAD
                        </label>
                        <div class="relative">
                            <select id="dataOpcionFrecuenciaMP"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="w-full px-3 mb-4">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            Personal requerido
                        </label>
                        <div class="relative">

                            <input id="dataPersonasPlanMP"
                                placeholder="Cantidad de operadores requeridos para la ejecucion" type="number" name=""
                                id=""
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                min="1" value="1">

                        </div>
                    </div>
                </div>

                <div class="w-3/4 flex flex-col md:flex-row items-start justify-center mt-6 h-full">
                    <div class="w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            ACTIVIDADES
                        </label>
                        <div class="w-full bg-gray-200 text-gray-700 p-4 rounded flex flex-col scrollbar overflow-y-auto"
                            style="max-height: 575px;">
                            <div onclick="ocultarContenidoActividadMP('')"
                                class="text-gray-500 rounded-md p-2 text-center font-bold uppercase text-sm mb-2 border-dashed border-2 border-gray-500 hover:bg-gray-300 hover:border-gray-300 hover:text-gray-600 cursor-pointer">
                                <h1>Añadir Actividad</h1>
                            </div>
                            <div id="dataActividadesPlanMP"></div>

                        </div>
                    </div>
                    <div class="w-full px-3 mb-6">

                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                            for="grid-state">
                            MATERIALES
                        </label>
                        <div class="w-full bg-gray-200 text-gray-700 p-4 rounded flex flex-col justify-center scrollbar overflow-y-auto"
                            style="max-height: 575px;">
                            <!-- MATERIAL -->
                            <div class="text-gray-500 rounded-md p-2 text-center font-bold uppercase text-sm mb-2 border-dashed border-2 border-gray-500 hover:bg-gray-300 hover:border-gray-300 hover:text-gray-600 cursor-pointer"
                                onclick="consultarMaterialesSubalmacen();">
                                <h1>Añadir Material</h1>
                            </div>
                            <!-- MATERIAL -->
                            <div id="dataMaterialesPlanMP"></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0 mt-6">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                    OBSERVACIONES / COMENTARIOS O INDICACIONES EXTRA
                </label>
                <div
                    class="w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 flex flex-col justify-center items-center">
                    <!-- MATERIAL -->
                    <div class="w-full text-left font-bold uppercase text-sm  mb-2 flex">
                        <textarea id="dataObservacionesPlanMP" name="textarea" rows="10" cols="50"
                            class="w-full bg-gray-200 focus:outline-none"></textarea>
                    </div>
                    <!-- MATERIAL -->
                </div>
            </div>
            <div class="my-10 flex">
                <button onclick="guardarCambiosPlanMP('ACTIVO');" class="btn btn-indigo mr-10">
                    GUARDAR CAMBIOS
                </button>

                <button onclick="guardarCambiosPlanMP('BAJA');" class="btn btn-orange">
                    DESACTIVAR ESTE PLAN
                </button>
            </div>
        </div>
    </div>


    <!-- MODAL AGREGAR ACTIVIDAD-->
    <div id="modalAgregarActividadMP" class="modal">
        <div
            class="modal-window w-10/12 flex shadow-lg flex-col justify-center items-center mx-auto text-bluegray-800 pt-10 rounded-lg">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">

                <button onclick="showInfoPlanMP();"
                    class="cursor-pointer text-md  text-blue-500 bg-blue-200 px-2 rounded-bl-lg rounded-tr-lg font-normal">
                    <i class="fas fa-info"></i>
                </button>

                <button onclick="toggleModalTailwind('modalAgregarActividadMP')"
                    class="cursor-pointer text-md  text-red-500 bg-red-200 px-2 rounded-bl-lg rounded-tr-lg font-normal">
                    <i class="fas fa-times"></i>
                </button>

            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-lg rounded-tl-lg">
                    <h1>NUEVO PLAN DE MANTENIMIENTO</h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-start flex-row w-full flex-wrap">

                <div class="w-1/5 px-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="grid-first-name">
                        Actividad
                    </label>
                    <input id="actividadPlanMP"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-gray-100 focus:shadow"
                        id="" type="text" placeholder="Describa actividad a realizar" autocomplete="off">

                </div>

                <div class="w-1/5 px-3 mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                        ¿Qué tipo de actividad será?
                    </label>
                    <div class="relative">
                        <select id="tipoActividadPlanMP"
                            class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-state">
                            <option value="actividad">Normal (indicación)</option>
                            <option value="checkList">Checklist (con respuesta limitada si - no - n/a)</option>
                            <option value="test">Test (Solicitar toma parametros o mediciones)</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="w-1/5 px-3 mb-4">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                        Tiempo estimado de ejecucion
                    </label>
                    <div class="relative">
                        <div class="relative">
                            <input id="dataTiempoActividadPlanMP" placeholder="En minutos" type="number"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                                min="0" value="1">

                        </div>
                    </div>
                </div>

                <div id="medicionTest" class="w-1/5 px-3 mb-4 hidden">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                        Tipo Medición Test
                    </label>
                    <div class="relative">
                        <div class="relative">
                            <select id="dataMedicionActividadPlanMP"
                                class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                            </select>

                        </div>
                    </div>
                </div>



                <div class="w-1/5 mt-5 px-3 mb-6 flex items-center justify-center">
                    <button id="actualizarActividadPlanMP" class="btn btn-indigo mr-10"
                        onclick="agregarActividadPlanMP();">
                        GUARDAR CAMBIOS
                    </button>

                    <button id="desactivarActividadPlanMP" class="btn btn-red">
                        DESACTIVAR ACTIVIDAD
                    </button>
                </div>

                <div id="infoActividadPlanMP" class="hidden w-full bg-bluegray-900 rounded flex flex-col p-6">
                    <h1 class="mb-10 text-white font-bold text-center text-lg">¿Que diferencia hay entre los tipos de
                        actividades?</h1>

                    <div class="w-full flex flex-row justify-around mb-6">
                        <div class="w-1/2 justify-center items-center px-4 py-2 rounded flex flex-col">
                            <h1 class="mb-4 font-bold text-left text-sm text-blue-500">ACTIVIDADES NORMALES
                                (INDICACIONES)</h1>
                            <p class="text-white text-justify">Uselas para indicar acciones a realizar.</p>
                        </div>
                        <div class="w-1/2 bg-white px-4 py-2 rounded flex flex-col">
                            <h1 class="font-bold text-center">Así es como se verá en la OT</h1>
                            <h1 class="text-left p-2 border-2 mt-4 rounded border-blue-500"><span
                                    class="font-bold uppercase ml-4">CAMBIAR LOS RODAMIENTOS</span></h1>
                        </div>
                    </div>

                    <div class="w-full flex flex-row justify-around mb-6">
                        <div class="w-1/2 justify-center items-center px-4 py-2 rounded flex flex-col">
                            <h1 class="mb-4 font-bold text-left text-sm text-purple-500">ACTIVIDADES TIPO CHECKLIST</h1>
                            <p class="text-white text-justify">En la OT se muestran con tres posibles respuestas "si,
                                no, n/a" pensadas para ser usadas en los checklist de verificacion de cuartos por
                                ejemplo.</p>
                        </div>
                        <div class="w-1/2 bg-white px-4 py-2 rounded flex flex-col">
                            <h1 class="font-bold text-center">Así es como se verá en la OT</h1>
                            <h1 class="text-left p-2 border-2 mt-4 rounded border-purple-500"><i
                                    class="far fa-circle"></i> si - <i class="far fa-circle"></i> no - <i
                                    class="far fa-circle"></i> n/a <span class="font-bold uppercase ml-4">¿El WC
                                    funciona correctamente?</span></h1>
                        </div>
                    </div>

                    <div class="w-full flex flex-row justify-around mb-6">
                        <div class="w-1/2 justify-center items-center px-4 py-2 rounded flex flex-col">
                            <h1 class="mb-4 font-bold text-left text-sm text-orange-500">ACTIVIDADES TEST</h1>
                            <p class="text-white text-justify">Uselas para solicitar la realizacion de algun test o
                                cuando requiera tome el registro de algun dato como por ejemplo medicion de voltaje,
                                amperaje vibrometro, temperatura etc. Al usar este tipo de actividad siempre se pedira
                                la introduccion de un dato.</p>
                        </div>
                        <div class="w-1/2 bg-white px-4 py-2 rounded flex flex-col">
                            <h1 class="font-bold text-center">Así es como se verá en la OT</h1>
                            <h1 class="text-left p-2 border-2 mt-4 rounded border-orange-500"><span
                                    class="font-bold uppercase ml-4">_____________ VOLTAJE DE ENTRADA DEL EQUIPO</span>
                            </h1>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>


    <!-- MODAL SALIDAS Subalmacenes-->
    <div id="modalSalidasSubalmacen" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 1550px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="toggleModalTailwind('modalSalidasSubalmacen');"
                    class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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

                        <input id="inputPalabraBuscarSubalmacenSalida"
                            class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-1/2"
                            type="search" name="search" placeholder="Buscar Material" autocomplete="off"
                            onkeydown=" if(event.keyCode == 13) consultarMaterialesSubalmacen();">

                    </div>
                    <!-- BUSCADOR -->
                    <!-- TITULOS -->
                    <div
                        class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-12 flex h-full items-center justify-center">
                            <h1>DESTINO</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>NOMBRE</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>CATEGORÍA</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>COD2BEND</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>GREMIO</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>DESCRIPCION</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>CARACTERISTICAS</h1>
                        </div>
                        <div class="w-64 flex h-full items-center justify-center">
                            <h1>MARCA/PROVEEDOR</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>STOCK TEÓRICO</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>STOCK ACTUAL</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>U DE M</h1>
                        </div>
                        <div class="w-32 flex h-full items-center justify-center">
                            <h1>CANTIDAD</h1>
                        </div>
                    </div>
                    <!-- TITULOS -->

                    <!-- Contenido -->
                    <div id="dataSalidasSubalmacen"
                        class="border w-full py-1 px-2 scrollbar overflow-y-auto rounded-md mb-4" style="height: 70vh;">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->

    <script src="../js/jquery-3.3.1.js"></script>
    <script src="../js/sweetalert2@9.js"></script>
    <script src="../js/alertify.min.js"></script>
    <script src="../js/alertasSweet.js"></script>
    <script src="js/planesDeMantenimiento.js"></script>
    <script src="../js/sorttable.js"></script>
    <script src="../js/funciones_tablas.js"></script>
</body>

</html>