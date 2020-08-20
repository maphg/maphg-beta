<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Datos</title>
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexboxgrid/6.3.1/flexboxgrid.min.css" type="text/css">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css"">



</head>

<body class=" p-2 bg-gray-100 text-center">

    <div class="text-center py-3">Nombre Tabla:
        <div class="inline-block relative w-120">
            <select id="inputTabla" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" onchange="obtenerNombreColumnas();">
                <option value="">Tablas</option>
                <option value="t_gastos_servicios">Subcontratas AME (t_gastos_servicios)</option>
                <option value="t_gastos_materiales">Compras AME (t_gastos_materiales)</option>
                <option value="t_pedidos_por_entregar">Pedidos CON Documento (t_pedidos_por_entregar)</option>
                <option value="t_pedidos_sin_orden">Pedidos SIN Documento (t_pedidos_sin_orden)</option>
                <option value="t_users">Usuarios (t_users)</option>
                <option value="t_colaboradores">Colaboradores (t_colaboradores)</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" /></svg>
            </div>
        </div>
    </div>

    <div class="flex">

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 1</div>
            <div class="my-2"><input id="columna1" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna1" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 2</div>
            <div class="my-2"><input id="columna2" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna2" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 3</div>
            <div class="my-2"><input id="columna3" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna3" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 4</div>
            <div class="my-2"><input id="columna4" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna4" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 5</div>
            <div class="my-2"><input id="columna5" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna5" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 6</div>
            <div class="my-2"><input id="columna6" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna6" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 7</div>
            <div class="my-2"><input id="columna7" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna7" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 8</div>
            <div class="my-2"><input id="columna8" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna8" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 9</div>
            <div class="my-2"><input id="columna9" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna9" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 10</div>
            <div class="my-2"><input id="columna10" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna10" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 11</div>
            <div class="my-2"><input id="columna11" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna11" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 12</div>
            <div class="my-2"><input id="columna12" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna12" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 13</div>
            <div class="my-2"><input id="columna13" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna13" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 14</div>
            <div class="my-2"><input id="columna14" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna14" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 15</div>
            <div class="my-2"><input id="columna15" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna15" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 16</div>
            <div class="my-2"><input id="columna16" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna16" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 17</div>
            <div class="my-2"><input id="columna17" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna17" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 18</div>
            <div class="my-2"><input id="columna18" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna18" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 19</div>
            <div class="my-2"><input id="columna19" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna19" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 20</div>
            <div class="my-2"><input id="columna20" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna20" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 21</div>
            <div class="my-2"><input id="columna21" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna21" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 22</div>
            <div class="my-2"><input id="columna22" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna22" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 23</div>
            <div class="my-2"><input id="columna23" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna23" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 24</div>
            <div class="my-2"><input id="columna24" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna24" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 25</div>
            <div class="my-2"><input id="columna25" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna25" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 26</div>
            <div class="my-2"><input id="columna26" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna26" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 27</div>
            <div class="my-2"><input id="columna27" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna27" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 28</div>
            <div class="my-2"><input id="columna28" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna28" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 29</div>
            <div class="my-2"><input id="columna29" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna29" cols="25" rows="20"></textarea></div>
        </div>

        <!-- Columna X -->
        <div class="flex-initial px-4 py-2 m-2 bg-gray-200 text-center">
            <div class="my-1 text-2xl">Columna 30</div>
            <div class="my-2"><input id="columna30" class="text-center" type="text" placeholder="nombre_columna" autocomplete="off"></div>
            <div class="my-1"><textarea name="" id="valorColumna30" cols="25" rows="20"></textarea></div>
        </div>

    </div>

    <button onclick="cargarDatosX();" class="bg-green-300 hover:bg-green-400 text-blue-800 font-bold my-3 p-4 rounded inline-flex items-center">
        <span>Cargar Datos</span>
    </button>

    <div class="footer text-center">Formato Fecha (Corta: 2020-12-31) (Larga 2020-12-31 23:59:59) </div>


    <!-- Modal Info -->
    <div id="modalDataInfo" class="modal flex justify-center items-center open">
        <div class="modal-window rounded-md w-auto md:w-3/12 lg:w-3/12">

            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarModal('modalDataInfo')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    Close
                </button>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex justify-center items-center flex-col w-full">
                <div class="mt-2 w-full flex flex-col justify-center items-center px-10 pb-5">

                    <div class="mt-2 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500">
                        <div class="w-full h-full flex items-center justify-left">
                            <h1>Resultado:</h1>
                        </div>
                    </div>
                    <div id="dataInfo" class="w-full flex flex-row justify-center p-2">
                        <i class="fad fa-spinner-third fa-4x fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.3.1.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script>
        function cargarDatosX() {
            document.getElementById("dataInfo").
            innerHTML = '<i class="fad fa-spinner-third fa-4x fa-spin"></i>';
            // Nombre Columna
            let columna1 = document.getElementById("columna1").value;
            let columna2 = document.getElementById("columna2").value;
            let columna3 = document.getElementById("columna3").value;
            let columna4 = document.getElementById("columna4").value;
            let columna5 = document.getElementById("columna5").value;
            let columna6 = document.getElementById("columna6").value;
            let columna7 = document.getElementById("columna7").value;
            let columna8 = document.getElementById("columna8").value;
            let columna9 = document.getElementById("columna9").value;
            let columna10 = document.getElementById("columna10").value;
            let columna11 = document.getElementById("columna11").value;
            let columna12 = document.getElementById("columna12").value;
            let columna13 = document.getElementById("columna13").value;
            let columna14 = document.getElementById("columna14").value;
            let columna15 = document.getElementById("columna15").value;
            let columna16 = document.getElementById("columna16").value;
            let columna17 = document.getElementById("columna17").value;
            let columna18 = document.getElementById("columna18").value;
            let columna19 = document.getElementById("columna19").value;
            let columna20 = document.getElementById("columna20").value;
            let columna21 = document.getElementById("columna21").value;
            let columna22 = document.getElementById("columna22").value;
            let columna23 = document.getElementById("columna23").value;
            let columna24 = document.getElementById("columna24").value;
            let columna25 = document.getElementById("columna25").value;
            let columna26 = document.getElementById("columna26").value;
            let columna27 = document.getElementById("columna27").value;
            let columna28 = document.getElementById("columna28").value;
            let columna29 = document.getElementById("columna29").value;
            let columna30 = document.getElementById("columna30").value;

            // Datos Columna
            let valorColumna1 = document.getElementById("valorColumna1").value;
            let valorColumna2 = document.getElementById("valorColumna2").value;
            let valorColumna3 = document.getElementById("valorColumna3").value;
            let valorColumna4 = document.getElementById("valorColumna4").value;
            let valorColumna5 = document.getElementById("valorColumna5").value;
            let valorColumna6 = document.getElementById("valorColumna6").value;
            let valorColumna7 = document.getElementById("valorColumna7").value;
            let valorColumna8 = document.getElementById("valorColumna8").value;
            let valorColumna9 = document.getElementById("valorColumna9").value;
            let valorColumna10 = document.getElementById("valorColumna10").value;
            let valorColumna11 = document.getElementById("valorColumna11").value;
            let valorColumna12 = document.getElementById("valorColumna12").value;
            let valorColumna13 = document.getElementById("valorColumna13").value;
            let valorColumna14 = document.getElementById("valorColumna14").value;
            let valorColumna15 = document.getElementById("valorColumna15").value;
            let valorColumna16 = document.getElementById("valorColumna16").value;
            let valorColumna17 = document.getElementById("valorColumna17").value;
            let valorColumna18 = document.getElementById("valorColumna18").value;
            let valorColumna19 = document.getElementById("valorColumna19").value;
            let valorColumna20 = document.getElementById("valorColumna20").value;
            let valorColumna21 = document.getElementById("valorColumna21").value;
            let valorColumna22 = document.getElementById("valorColumna22").value;
            let valorColumna23 = document.getElementById("valorColumna23").value;
            let valorColumna24 = document.getElementById("valorColumna24").value;
            let valorColumna25 = document.getElementById("valorColumna25").value;
            let valorColumna26 = document.getElementById("valorColumna26").value;
            let valorColumna27 = document.getElementById("valorColumna27").value;
            let valorColumna28 = document.getElementById("valorColumna28").value;
            let valorColumna29 = document.getElementById("valorColumna29").value;
            let valorColumna30 = document.getElementById("valorColumna30").value;

            let tabla = document.getElementById("inputTabla").value;
            const action = "cargarDatosX";
            // Envía los Datos.

            if (tabla != "" && columna1 != "" && valorColumna1 != "") {
                document.getElementById("modalDataInfo").classList.add('open');
                $.ajax({
                    type: "POST",
                    url: "php/subir_datos_genericos.php",
                    data: {
                        action: action,
                        columna1: columna1,
                        columna2: columna2,
                        columna3: columna3,
                        columna4: columna4,
                        columna5: columna5,
                        columna6: columna6,
                        columna7: columna7,
                        columna8: columna8,
                        columna9: columna9,
                        columna10: columna10,
                        columna11: columna11,
                        columna12: columna12,
                        columna13: columna13,
                        columna14: columna14,
                        columna15: columna15,
                        columna16: columna16,
                        columna17: columna17,
                        columna18: columna18,
                        columna19: columna19,
                        columna20: columna20,
                        columna21: columna21,
                        columna22: columna22,
                        columna23: columna23,
                        columna24: columna24,
                        columna25: columna25,
                        columna26: columna26,
                        columna27: columna27,
                        columna28: columna28,
                        columna29: columna29,
                        columna30: columna30,
                        valorColumna1: valorColumna1,
                        valorColumna2: valorColumna2,
                        valorColumna3: valorColumna3,
                        valorColumna4: valorColumna4,
                        valorColumna5: valorColumna5,
                        valorColumna6: valorColumna6,
                        valorColumna7: valorColumna7,
                        valorColumna8: valorColumna8,
                        valorColumna9: valorColumna9,
                        valorColumna10: valorColumna10,
                        valorColumna11: valorColumna11,
                        valorColumna12: valorColumna12,
                        valorColumna13: valorColumna13,
                        valorColumna14: valorColumna14,
                        valorColumna15: valorColumna15,
                        valorColumna16: valorColumna16,
                        valorColumna17: valorColumna17,
                        valorColumna18: valorColumna18,
                        valorColumna19: valorColumna19,
                        valorColumna20: valorColumna20,
                        valorColumna21: valorColumna21,
                        valorColumna22: valorColumna22,
                        valorColumna23: valorColumna23,
                        valorColumna24: valorColumna24,
                        valorColumna25: valorColumna25,
                        valorColumna26: valorColumna26,
                        valorColumna27: valorColumna27,
                        valorColumna28: valorColumna28,
                        valorColumna29: valorColumna29,
                        valorColumna30: valorColumna30,
                        tabla: tabla
                    },
                    // dataType: "JSON",
                    success: function(response) {
                        document.getElementById("dataInfo").innerHTML = response;
                        // alertaImg(response, '', 'info', 10000);
                    }
                });
            } else {
                if (tabla == "") {
                    alertaImg('Nombre Tabla Vacio', '', 'info', 5000);
                } else {
                    alertaImg('Error en nombre_colummna o Datos', '', 'info', 5000);
                }
            }
        }

        // Obtiene el nombre de la tabla para mostrar las columnas correspondientes
        function obtenerNombreColumnas() {
            let tabla = document.getElementById("inputTabla").value;
            if (tabla == "t_gastos_servicios") {
                document.getElementById("columna1").value = "cuenta";
                document.getElementById("columna2").value = "num_documento";
                document.getElementById("columna3").value = "clase_documento";
                document.getElementById("columna4").value = "fecha_contabilizacion";
                document.getElementById("columna5").value = "fecha_documento";
                document.getElementById("columna6").value = "sociedad";
                document.getElementById("columna7").value = "division";
                document.getElementById("columna8").value = "importe_ml";
                document.getElementById("columna9").value = "moneda_local";
                document.getElementById("columna10").value = "doc_compensacion";
                document.getElementById("columna11").value = "importe_ml3";
                document.getElementById("columna12").value = "moneda_local_3";
                document.getElementById("columna13").value = "importe_ml2";
                document.getElementById("columna14").value = "moneda_local_2";
                document.getElementById("columna15").value = "ceco";
                document.getElementById("columna16").value = "asignacion";
                document.getElementById("columna17").value = "referencia";
                document.getElementById("columna18").value = "texto";
                document.getElementById("columna19").value = "proveedor_af";
                document.getElementById("columna20").value = "nombre_proveedor_af";
                document.getElementById("columna21").value = "indicador_impuestos";
                document.getElementById("columna22").value = "nombre_1";
            } else if (tabla == "t_gastos_materiales") {
                document.getElementById("columna1").value = "cuenta";
                document.getElementById("columna2").value = "num_documento";
                document.getElementById("columna3").value = "clase_documento";
                document.getElementById("columna4").value = "fecha_contabilizacion";
                document.getElementById("columna5").value = "fecha_documento";
                document.getElementById("columna6").value = "sociedad";
                document.getElementById("columna7").value = "division";
                document.getElementById("columna8").value = "importe_ml";
                document.getElementById("columna9").value = "moneda_local";
                document.getElementById("columna10").value = "doc_compensacion";
                document.getElementById("columna11").value = "importe_ml3";
                document.getElementById("columna12").value = "moneda_local_3";
                document.getElementById("columna13").value = "importe_ml2";
                document.getElementById("columna14").value = "moneda_local_2";
                document.getElementById("columna15").value = "ceco";
                document.getElementById("columna16").value = "asignacion";
                document.getElementById("columna17").value = "referencia";
                document.getElementById("columna18").value = "texto";
                document.getElementById("columna19").value = "proveedor_af";
                document.getElementById("columna20").value = "nombre_proveedor_af";
                document.getElementById("columna21").value = "indicador_impuestos";
                document.getElementById("columna22").value = "nombre_1";
                document.getElementById("columna23").value = "doc_compras";

            }
        }

        function cerrarModal() {
            document.getElementById("modalDataInfo").classList.remove('open');
        }
    </script>
    </body>

</html>