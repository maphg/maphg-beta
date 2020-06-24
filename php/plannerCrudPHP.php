<?php
session_start();
include 'conexion.php';
if (isset($_POST['action'])) {

    // Variables Globales.
    $action = $_POST['action'];
    $idUsuario = $_SESSION['usuario'];
    $idDestino = $_SESSION['idDestino'];
    $superAdmin = $_SESSION['super_admin'];
    $fechaActual = date("Y-m-d H:m:s");

    if ($action == "consultaSubsecciones") {
        // Variables tipo array para acumular los resultados de las secciones.
        $data = array();
        $dataZIC = "";
        $query = "SELECT c_rel_seccion_subseccion.id, c_rel_seccion_subseccion.fase, c_rel_destino_seccion.id_destino, c_destinos.id, c_destinos.destino,  c_rel_destino_seccion.id_seccion, c_secciones.id, c_secciones.titulo_seccion, c_secciones.seccion, c_rel_seccion_subseccion.id_subseccion, c_subsecciones.id, c_subsecciones.grupo
        FROM c_rel_destino_seccion
        INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
        INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
        INNER JOIN c_destinos ON c_rel_destino_seccion.id_destino = c_destinos.id
        WHERE c_rel_destino_seccion.id_destino=1 AND c_subsecciones.id != 200 ORDER BY c_subsecciones.grupo";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {

            // Se genera el encabezado de las subsecciones.
            $dataZIC .= " 
                <div id=\"colzic\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                    <div
                        class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                        <div
                            class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                            <h1 class=\"font-medium text-md text-gray-100\">DEP</h1>
                        </div>
                        <div
                            class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                            <i data-target=\"modal-zia\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                        </div>
                        <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                        <div
                            class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
            ";

            while ($row = mysqli_fetch_array($result)) {
                $seccion = $row['seccion'];
                $subseccion = $row['grupo'];
                $pendientes = 22;

                if ($seccion == "ZIC") {
                    // $dataZIC .= $subseccion;
                    $dataZIC .= "
                        <!-- Subsecciones -->
                            <div id=\"abremodal\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        <!-- Subsecciones -->
                    ";
                }
            }

            $dataZIC .= "
                            </div>
                        </div>
                    </div>
                </div>
            ";
        } else {
            $error = "Proceso Finalizado";
        }
        $data['dataZIC'] = $dataZIC;
        echo json_encode($data);
    }
}