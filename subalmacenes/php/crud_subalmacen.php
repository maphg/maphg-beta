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
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\" data-target=\"modalSalidasSubalmacen\" data-toggle=\"modal\">
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
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\">
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
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\">
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
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\">
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
                                <div class=\"w-1/3 bg-gray-900 text-gray-100 py-1 hover:bg-gray-700\">
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
                                <div class=\"w-1/3 bg-gray-400 text-gray-900 py-1 hover:bg-gray-200\">
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

        $query = "SELECT* FROM t_subalmacenes_items WHERE id_subalmacen = $idSubalmacen $palabraBuscar";
        $result = mysqli_query($conn_2020, $query);
        while ($row = mysqli_fetch_array($result)) {
            $contador++;
            $idSubalmacen = $row['id'];
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
}//Fin $action.