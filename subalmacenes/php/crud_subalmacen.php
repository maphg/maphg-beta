<?php
include "conexion.php";
session_start();

if (isset($_POST['action'])) {
    // Variables Globales.
    $idDestino = $_SESSION['idDestino'];
    $idUsuario = $_SESSION['usuario'];
    $superAdmin = $_SESSION['super_admin'];

    $action = $_POST['action'];

    if ($action == "Agregar") {
        $idDestino = $_POST['idDestino'];
        $idFase = $_POST['idFase'];
        $subalmacen = $_POST['subalmacen'];

        switch ($idFase) {
            case 1:
                $fase = "GP";
                break;

            case 2:
                $fase = "TRS";
                break;

            case 3:
                $fase = "ZI";
                break;
        }


        $query = "INSERT INTO  t_subalmacenes(id_destino, id_fase, nombre, fase) VALUES($idDestino, $idFase, '$subalmacen', '$fase')";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "1";
        } else {
            echo "0";
        }
    }

    if ($action == "Actualizar") {
        $idDestino = $_POST['idDestino'];
        $idFase = $_POST['idFase'];
        $subalmacen = $_POST['subalmacen'];
        $idSubalmacen = $_POST['idSubalmacen'];

        switch ($idFase) {
            case 1:
                $fase = "GP";
                break;

            case 2:
                $fase = "TRS";
                break;

            case 3:
                $fase = "ZI";
                break;
        }


        $query = "UPDATE  t_subalmacenes SET nombre='$subalmacen', id_fase=$idFase,  fase='$fase' WHERE id=$idSubalmacen";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Agregado";
        } else {
            echo "Error Agregar";
        }
    }

    if ($action == "eliminarSubalmacen") {
        $idDestino = $_POST['idDestino'];
        $idFase = $_POST['idFase'];
        $subalmacen = $_POST['subalmacen'];
        $idSubalmacen = $_POST['idSubalmacen'];

        switch ($idFase) {
            case 1:
                $fase = "GP-eliminado";
                break;

            case 2:
                $fase = "TRS-eliminado";
                break;

            case 3:
                $fase = "ZI-eliminado";
                break;
        }


        $query = "UPDATE  t_subalmacenes SET fase='$fase' WHERE id=$idSubalmacen";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Agregado";
        } else {
            echo "Error Agregar";
        }
    }



    if ($action == "consultaSubalmacen") {
        $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
        $arraySubalmacen = array();
        $dataGP = "";
        $dataTRS = "";
        $dataZI = "";

        if ($idDestinoSeleccionado == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND id_destino = $idDestinoSeleccionado";
        }

        $query = "SELECT 
        id, id_destino, id_fase, nombre, fase, tipo 
        FROM t_subalmacenes 
        WHERE activo = 1 $filtroDestino";
        $result = mysqli_query($conn_2020, $query);

        while ($row = mysqli_fetch_array($result)) {
            $idSubalmacen = $row['id'];
            $idFase = $row['id_fase'];
            $nombre = $row['nombre'];
            $fase = $row['fase'];
            $tipo = $row['tipo'];

            if ($fase == "GP") {
                if ($tipo == "SUBALMACEN") {
                    $dataGP .= "
                        <!-- SUBALMACEN -->
                        <div id=\"$idSubalmacen\" onclick=\"expandir(this.id)\"
                            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
                            <div>
                                <h1 class=\"truncate\">$nombre</h1>
                            </div>
                            <div id=\"$idSubalmacen" . "toggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md\">
                                    <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- SUBALMACEN -->              
                    ";
                } elseif ($tipo == "BODEGA") {
                    $dataGP .= "
                        <!-- BODEGA -->
                        <div id=\"$idSubalmacen\" onclick=\"expandir(this.id)\"
                            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
                            <div>
                                <h1 class=\"truncate\">$nombre</h1>
                            </div>
                            <div id=\"$idSubalmacen" . "toggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md\">
                                    <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- BODEGA -->            
                    ";
                }
            } elseif ($fase == "TRS") {
                if ($tipo == "SUBALMACEN") {
                    $dataTRS .= "
                        <!-- SUBALMACEN -->
                        <div id=\"$idSubalmacen\" onclick=\"expandir(this.id)\"
                            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
                            <div>
                                <h1 class=\"truncate\">$nombre</h1>
                            </div>
                            <div id=\"$idSubalmacen" . "toggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md\">
                                    <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- SUBALMACEN -->              
                    ";
                } elseif ($tipo == "BODEGA") {
                    $dataTRS .= "
                        <!-- BODEGA -->
                        <div id=\"$idSubalmacen\" onclick=\"expandir(this.id)\"
                            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
                            <div>
                                <h1 class=\"truncate\">$nombre</h1>
                            </div>
                            <div id=\"$idSubalmacen" . "toggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md\">
                                    <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- BODEGA -->            
                    ";
                }
            } elseif ($fase == "ZI") {
                if ($tipo == "SUBALMACEN") {
                    $dataZI .= "
                        <!-- SUBALMACEN -->
                        <div id=\"$idSubalmacen\" onclick=\"expandir(this.id)\"
                            class=\"p-3 m-1 bg-gray-800 text-gray-300 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-red-500 hover:shadow-md animated fadeInUp\">
                            <div>
                                <h1 class=\"truncate\">$nombre</h1>
                            </div>
                            <div id=\"$idSubalmacen" . "toggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-l-md\">
                                    <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- SUBALMACEN -->              
                    ";
                } elseif ($tipo == "BODEGA") {
                    $dataZI .= "
                        <!-- BODEGA -->
                        <div id=\"$idSubalmacen\" onclick=\"expandir(this.id)\"
                            class=\"p-3 m-1 bg-gray-300 text-gray-900 rounded-lg cursor-pointer w-full font-medium text-sm text-center flex-flex-col border-l-4 border-orange-300 hover:shadow-md animated fadeInUp\">
                            <div>
                                <h1 class=\"truncate\">$nombre</h1>
                            </div>
                            <div id=\"$idSubalmacen" . "toggle\" class=\"hidden flex flex-row w-full mt-2 text-xs\">
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-l-md\">
                                    <h1><i class=\"fad fa-arrow-to-right mr-2\"></i>Entradas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\" onclick=\"salidasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-arrow-from-left fa-rotate-180 mr-2\"></i>Salidas</h1>
                                </div>
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200 rounded-r-md\" onclick=\"consultaExistenciasSubalmacen($idSubalmacen, '');\">
                                    <h1><i class=\"fad fa-list-ul mr-2\"></i>Existencias</h1>
                                </div>
                            </div>
                        </div>
                        <!-- BODEGA -->            
                    ";
                }
            }
        }

        $arraySubalmacen['dataGP'] = $dataGP;
        $arraySubalmacen['dataTRS'] = $dataTRS;
        $arraySubalmacen['dataZI'] = $dataZI;

        echo json_encode($arraySubalmacen);
    }


    if ($action == "agregarSubalmacen") {
        // $idDestino Se obtiene de la session.
        $titulo = $_POST['titulo'];
        $fase = $_POST['fase'];
        $faseArray = array("GP" => 1, "TRS" => 2, "ZI" => 3);
        $idFase = $faseArray[$fase];

        $query = "INSERT INTO 
        t_subalmacenes(id_destino, id_fase, nombre, fase) 
        VALUES($idDestino, $idFase, '$titulo', '$fase')";

        if (mysqli_query($conn_2020, $query)) {
            echo "Se agrego Subalmacén ($titulo)";
        } else {
            echo "Error al agregar Subalmacén ($titulo)";
        }
    }


    // Nuevas funciones para la version Beta_2020.

    if ($action == "eliminar_Subalmacen") {
        $idSubalmacen = $_POST['idSubalmacen'];
        $query = "UPDATE t_subalmacenes SET activo = 0 WHERE id = $idSubalmacen";
        if (mysqli_query($conn_2020, $query)) {
            echo "Subalmacén Eliminado";
        } else {
            echo "Error al Eliminar Subalmacén";
        }
    }


    if ($action == "editarSubalmacen") {
        $idSubalmacen = $_POST['idSubalmacen'];
        $tituloSubalmacen = $_POST['tituloSubalmacen'];

        $query = "UPDATE t_subalmacenes SET nombre = '$tituloSubalmacen' WHERE id = $idSubalmacen";
        if (mysqli_query($conn_2020, $query)) {
            echo "Subalmacén Actualizado";
        } else {
            echo "Error al Actualizar";
        }
    }


    if ($action == "consultaExistenciasSubalmacen") {
        $idSubalmacen = $_POST['idSubalmacen'];
        $arrayExistenciaSubalmacen = array();
        $dataExistenciaSubalmacen = "";
        $palabraBuscar = $_POST['palabraBuscar'];
        $contador = 0;

        if ($palabraBuscar != "") {
            $palabraBuscar = "AND (categoria LIKE '%$palabraBuscar%' OR cod2bend LIKE '%$palabraBuscar%' OR descripcion LIKE '%$palabraBuscar%' OR caracteristicas LIKE '%$palabraBuscar%' OR marca LIKE '%$palabraBuscar%')";
        } else {
            $palabraBuscar = "";
        }

        $query_subalmacen = "SELECT nombre, fase FROM t_subalmacenes WHERE id = $idSubalmacen";
        $result_subalmacen = mysqli_query($conn_2020, $query_subalmacen);
        if ($row_subalmacen = mysqli_fetch_array($result_subalmacen)) {
            $nombre = $row_subalmacen['nombre'];
            $fase = $row_subalmacen['fase'];

            $arrayExistenciaSubalmacen['nombreSubalmacen'] = $nombre;
            $arrayExistenciaSubalmacen['faseSubalmacen'] = $fase;
        }

        $query = "SELECT* FROM t_subalmacenes_items WHERE id_subalmacen = $idSubalmacen $palabraBuscar";
        $result = mysqli_query($conn_2020, $query);
        while ($row = mysqli_fetch_array($result)) {
            $contador++;
            $idItem = $row['id'];
            $categoria = $row['categoria'];
            $cod2bend = $row['cod2bend'];
            $gremio = $row['tipo_material'];
            $descripcion = $row['descripcion'];
            $caracteristicas = $row['caracteristicas'];
            $marca = $row['marca'];
            $cantidadTeorico = $row['cantidad'];
            $cantidadActual = $row['cantidad'];
            $unidad = $row['unidad'];
            $colorstilo = "text-bluegray-500 bg-bluegray-50";

            if ($cantidadActual <= 0) {
                $colorstilo = "text-red-500 bg-red-200";
            } elseif ($cantidadActual > ($cantidadActual + 1)) {
                $colorstilo = "text-bluegray-500 bg-bluegray-50";
            }

            $dataExistenciaSubalmacen .= "
                <div
                    class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 rounded hover:bg-indigo-100 cursor-pointer $colorstilo\">
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$contador $categoria</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cod2bend</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$gremio</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$descripcion</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$caracteristicas</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$marca</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cantidadTeorico</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cantidadActual</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center\">
                        <h1>$unidad</h1>
                    </div>
                </div>            
            ";
        }
        if ($totalResultados = mysqli_num_rows($result)) {
            $arrayExistenciaSubalmacen['totalResultados'] = $totalResultados;
        } else {
            $arrayExistenciaSubalmacen['totalResultados'] = 0;
        }

        $arrayExistenciaSubalmacen['dataExistenciaSubalmacen'] = $dataExistenciaSubalmacen;
        echo json_encode($arrayExistenciaSubalmacen);
    }


    if ($action == "consultaSalidaSubalmacen") {

        $idSubalmacen = $_POST['idSubalmacen'];
        $arraySalidaSubalmacen = array();
        $dataSalidaSubalmacen = "";
        $palabraBuscar = $_POST['palabraBuscar'];
        $contador = 0;

        if ($palabraBuscar != "") {
            $palabraBuscar = "AND (categoria LIKE '%$palabraBuscar%' OR cod2bend LIKE '%$palabraBuscar%' OR descripcion LIKE '%$palabraBuscar%' OR caracteristicas LIKE '%$palabraBuscar%' OR marca LIKE '%$palabraBuscar%')";
        } else {
            $palabraBuscar = "";
        }

        $query_subalmacen = "SELECT nombre, fase FROM t_subalmacenes WHERE id = $idSubalmacen";
        $result_subalmacen = mysqli_query($conn_2020, $query_subalmacen);
        if ($row_subalmacen = mysqli_fetch_array($result_subalmacen)) {
            $nombre = $row_subalmacen['nombre'];
            $fase = $row_subalmacen['fase'];

            $arraySalidaSubalmacen['nombreSubalmacen'] = $nombre;
            $arraySalidaSubalmacen['faseSubalmacen'] = $fase;
        }

        $query = "SELECT* FROM t_subalmacenes_items WHERE id_subalmacen = $idSubalmacen $palabraBuscar AND cantidad > 0";
        $result = mysqli_query($conn_2020, $query);
        while ($row = mysqli_fetch_array($result)) {
            $contador++;
            $idItem = $row['id'];
            $idSubalmacen = $row['id_subalmacen'];
            $categoria = $row['categoria'];
            $cod2bend = $row['cod2bend'];
            $gremio = $row['tipo_material'];
            $descripcion = $row['descripcion'];
            $caracteristicas = $row['caracteristicas'];
            $marca = $row['marca'];
            $cantidadTeorico = $row['cantidad'];
            $cantidadActual = $row['cantidad'];
            $unidad = $row['unidad'];

            $dataSalidaSubalmacen .= "
                <!-- ITEM -->
                <div class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer\">
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$categoria</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cod2bend</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$gremio</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$descripcion</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$caracteristicas</h1>
                    </div>
                    <div class=\"w-64 flex h-full items-center justify-center truncate\">
                        <h1>$marca</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cantidadTeorico</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center truncate\">
                        <h1>$cantidadActual</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center\">
                        <h1>$unidad</h1>
                    </div>
                    <div class=\"w-32 flex h-full items-center justify-center\">
                    <input id=\"$idItem\" class=\"border border-gray-200 bg-indigo-200 text-indigo-600 font-semibold text-center h-8 px-2 rounded-r-md text-sm focus:outline-none w-full\" type=\"number\" value=\"0\" placeholder=\"Cantidad\" min=\"1\" onkeyup=\"if(event.keyCode)validarCantidaSalidaSubalmacen($idItem, '$descripcion', $cantidadActual, $idSubalmacen);\">
                    </div>
                </div>
                <!-- ITEM -->            
            ";
        }

        if ($totalResultados = mysqli_num_rows($result)) {
            $arraySalidaSubalmacen['totalResultados'] = $totalResultados;
        } else {
            $arraySalidaSubalmacen['totalResultados'] = 0;
        }
        $arraySalidaSubalmacen['dataSalidaSubalmacen'] = $dataSalidaSubalmacen;
        echo json_encode($arraySalidaSubalmacen);
    }


    if ($action == "validarCantidaSalidaSubalmacen") {
        $idDestino = $_POST['idDestino'];
        $idItem = $_POST['idItem'];
        $cantidadAnterior = $_POST['cantidadActual'];
        $cantidad = $_POST['cantidad'];
        $cantidadActual = $cantidadAnterior - $cantidad;
        $idSubalmacen = $_POST['idSubalmacen'];

        $query = "INSERT INTO t_subalmacenes_movimientos_salidas_temp(id_usuario, id_destino, id_subalmacen, id_material, cantidad_salida, cantidad_anterior, cantidad_actual) 
        VALUES($idUsuario, $idDestino, $idSubalmacen, $idItem, $cantidad, $cantidadAnterior, $cantidadActual)";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            echo "Se agrego al Carrito";
        } else {
            echo "Error al Agregar";
        }
    }
    if ($action == "consultaCarritoSalida") {
        $idDestino = $_POST['idDestino'];
        $idSubalmacen = $_POST['idSubalmacen'];
        $arrayCarritoSalidas = array();
        $dataCarritoSalidas = "";
        $cantidadCarrito = "";
        $idItemCarrito = "";
        $idRegistro = "";

        $query = "SELECT 
            t_subalmacenes_movimientos_salidas_temp.id,
            t_subalmacenes_movimientos_salidas_temp.cantidad_salida, 
            t_subalmacenes_items.descripcion, 
            t_subalmacenes_items.caracteristicas,
            t_subalmacenes_items.precio,
            t_subalmacenes_movimientos_salidas_temp.id_material
            FROM t_subalmacenes_movimientos_salidas_temp 
            INNER JOIN t_subalmacenes_items ON t_subalmacenes_movimientos_salidas_temp.id_material = t_subalmacenes_items.id
            WHERE 
            t_subalmacenes_movimientos_salidas_temp.id_usuario = $idUsuario 
            AND t_subalmacenes_movimientos_salidas_temp.id_subalmacen = $idSubalmacen 
            AND t_subalmacenes_movimientos_salidas_temp.id_destino = $idDestino
            AND t_subalmacenes_movimientos_salidas_temp.status = 'ESPERA'
            ORDER BY t_subalmacenes_movimientos_salidas_temp.fecha_salida ASC
            ";


        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['id'];
                $idItem = $row['id_material'];
                $cantidad = $row['cantidad_salida'];
                $descripcion = $row['descripcion'];
                $caracteristicas = $row['caracteristicas'];
                $precio = $row['precio'];

                $idItemCarrito .= $idItem . ",";
                $cantidadCarrito .= $cantidad . ",";
                $idRegistro .= $id . ",";

                $dataCarritoSalidas .= " 
                    <!-- ITEM -->
                    <div
                        class=\"mt-1 w-full flex flex-row justify-center items-center font-bold text-xs h-8 text-bluegray-500 bg-bluegray-50 rounded hover:bg-indigo-100 cursor-pointer\">
                        <div class=\"w-32 flex h-full items-center justify-center truncate\">
                            <h1>$cantidad</h1>
                        </div>
                        <div class=\"w-64 flex h-full items-center justify-center truncate\">
                            <h1>$descripcion</h1>
                        </div>
                        <div class=\"w-64 flex h-full items-center justify-center truncate\">
                            <h1>$caracteristicas</h1>
                        </div>
                        <div class=\"w-32 flex h-full items-center justify-center\">
                            <h1>$precio</h1>
                        </div>
                    </div>
                    <!-- ITEM -->
                ";
            }
        }

        $arrayCarritoSalidas['dataCarritoSalidas'] = $dataCarritoSalidas;
        $arrayCarritoSalidas['cantidadCarrito'] = $cantidadCarrito;
        $arrayCarritoSalidas['idItemCarrito'] = $idItemCarrito;
        $arrayCarritoSalidas['idRegistro'] = $idRegistro;
        echo json_encode($arrayCarritoSalidas);
    }


    if ($action == "consultaSeccion") {
        $idDestino = $_POST['idDestino'];
        $paso = $_POST['paso'];
        $dataSecciones = "";
        $dataSubsecciones = "";
        $dataEquipos = "";
        $dataMCE = "";
        $dataMCTG = "";
        $dataMP = "";

        if ($paso == "paso1") {
            $query = "SELECT c_secciones.id, c_secciones.seccion 
        FROM c_rel_destino_seccion
        INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino";

            if ($result = mysqli_query($conn_2020, $query)) {
                $dataSecciones .= "
            <select id=\"opcionSeccion\"
                class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('paso2');\">
        ";

                while ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id'];
                    $seccion = $row['seccion'];

                    $dataSecciones .= "
                        <option value=\"$idSeccion\">$seccion</option>
                    ";
                }

                $dataSecciones .= "</select>";
            }
            echo $dataSecciones;
        } elseif ($paso == "paso2") {
            $idSeccion = $_POST['idSeccion'];

            $query = "
            SELECT 
            c_subsecciones.id, c_subsecciones.grupo
            FROM c_rel_destino_seccion
            INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
            INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
            WHERE c_rel_destino_seccion.id_destino= $idDestino AND c_rel_destino_seccion.id_seccion = $idSeccion            
            ";
            if ($result = mysqli_query($conn_2020, $query)) {
                $dataSubsecciones .= "
                    <select id=\"opcionSubseccion\"
                        class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('paso3');\">
                 ";
                while ($row = mysqli_fetch_array($result)) {
                    $idSubseccion = $row['id'];
                    $subseccion = $row['grupo'];

                    $dataSubsecciones .= "
                        <option value=\"$idSubseccion\">$subseccion</option>
                    ";
                }
                $dataSubsecciones .= "$idDestino</select>";
            }
            echo $dataSubsecciones;
        } elseif ($paso == "paso3") {
            $idSeccion = $_POST['idSeccion'];
            $idSubseccion = $_POST['idSubseccion'];

            $query = "SELECT id, equipo FROM t_equipos 
            WHERE 
            id_destino = $idDestino AND 
            id_seccion = $idSeccion AND 
            id_subseccion = $idSubseccion AND 
            status = 'A'
            ";

            if ($result = mysqli_query($conn_2020, $query)) {
                $dataEquipos .= "
                    <select id=\"opcionEquipo\"
                        class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('paso4');\">
                ";
                while ($row = mysqli_fetch_array($result)) {
                    $idEquipo = $row['id'];
                    $equipo = $row['equipo'];

                    $dataEquipos .= "
                        <option value=\"$idEquipo\">$equipo </option>
                    ";
                }
                $dataEquipos .= "</select>";
            }
            echo $dataEquipos;
        } elseif ($paso == "MCE") {
            $idEquipo = $_POST['idEquipo'];

            $query = "SELECT id, actividad FROM t_mc 
            WHERE id_equipo = $idEquipo AND activo = 1 AND status = 'N'";

            if ($result = mysqli_query($conn_2020, $query)) {
                $dataMCE .= "
                    <select id=\"idMCE\"
                        class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('paso5');\">
                ";
                while ($row = mysqli_fetch_array($result)) {
                    $idMCE = $row['id'];
                    $actividad = $row['actividad'];

                    $dataMCE .= "
                        <option value=\"$idMCE\">$actividad </option>
                    ";
                }
                $dataMCE .= "</select>";
            }
            echo $dataMCE;
        } elseif ($paso == "MP") {
            $idEquipo = $_POST['idEquipo'];

            $query = "SELECT t_mp_planeacion.id, t_mp_planeacion.semana, t_ordenes_trabajo.folio 
            FROM t_mp_planeacion 
            INNER JOIN t_ordenes_trabajo ON t_mp_planeacion.id = t_ordenes_trabajo.id_planeacion_mp
            WHERE t_mp_planeacion.id_equipo = $idEquipo AND 
            t_mp_planeacion.status = 'P' AND t_mp_planeacion.activo = 1 AND t_mp_planeacion.tipoplan = 'MP'";

            if ($result = mysqli_query($conn_2020, $query)) {
                $dataMP .= "
                    <select id=\"idMCE\"
                        class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('paso5');\">
                ";
                while ($row = mysqli_fetch_array($result)) {
                    $idMP = $row['id'];
                    $semana = $row['semana'];
                    $folio = $row['folio'];

                    $dataMP .= "
                        <option value=\"$idMP\">Semana: $semana  Folio:$folio </option>
                    ";
                }
                $dataMP .= "</select>";
            }
            echo $dataMP;
        } elseif ($paso == "pasoTG") {
            $idSeccion = $_POST['idSeccion'];
            $idSubseccion = $_POST['idSubseccion'];

            $query = "SELECT id, actividad FROM t_mc 
            WHERE id_equipo = 0 AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion AND id_destino = $idDestino AND activo = 1 AND status = 'N'";

            if ($result = mysqli_query($conn_2020, $query)) {
                $dataMCTG .= "
                    <select id=\"idMCE\"
                        class=\"block appearance-none w-full bg-gray-200 border border-gray-200 font-bold text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 mt-4\" onclick=\"carritoSalidaMotivo('paso5');\">
                ";
                while ($row = mysqli_fetch_array($result)) {
                    $idMCE = $row['id'];
                    $actividad = $row['actividad'];

                    $dataMCTG .= "
                        <option value=\"$idMCE\">$actividad </option>
                    ";
                }
                $dataMCTG .= "</select>";
            }
            echo $dataMCTG;
        }
    }

    if ($action == "cerrarSalidaCarrito") {
        $idItemRegistro = $_POST['idSalidaItem'];

        $query = "SELECT* FROM t_subalmacenes_movimientos_salidas_temp 
            WHERE id = $idItemRegistro AND status = 'ESPERA' AND activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            while ($row = mysqli_fetch_array($result)) {
                $idUsuario = $row['id_usuario'];
                $idDestino = $row['id_destino'];
                $idSubalmacen = $row['id_subalmacen'];
                $idMaterial = $row['id_material'];
                $cantidadSalida = $row['cantidad_salida'];
                $cantidadAnterior = $row['cantidad_anterior'];
                $cantidadActual = $row['cantidad_actual'];

                $query_insert = "INSERT INTO t_subalmacenes_movimientos_salidas(id_usuario, id_destino, id_subalmacen, id_material, cantidad_salida, cantidad_anterior, cantidad_actual) 
                VALUES($idUsuario, $idDestino, $idSubalmacen, $idMaterial, $cantidadSalida, $cantidadAnterior, $cantidadActual)";

                if ($result_insert = mysqli_query($conn_2020, $query_insert)) {
                    $query_update = "UPDATE t_subalmacenes_movimientos_salidas_temp SET status = 'FINALIZADO' WHERE id = $idItemRegistro";

                    if ($result_update = mysqli_query($conn_2020, $query_update)) {
                        echo "Salida Finalizada";
                    } else {
                        echo "Error al Finalizar Salida";
                    }
                } else {
                    echo "Error al Finalizar Salida";
                }
            }
        } else {
            echo "Error al Finalizar Carrito";
        }
    }
}//Fin $action.