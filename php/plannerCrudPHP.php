<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';


if (isset($_POST['action'])) {
    // Se migro la session de PHP a JS, para evitar la caducidad de session_star();
    // $idUsuario = $_SESSION['usuario'];
    // $idDestino = $_SESSION['idDestino'];
    // $superAdmin = $_SESSION['super_admin'];



    // Variables Globales.
    $action = $_POST['action'];
    $idUsuario = $_POST['idUsuario'];
    $idDestino = $_POST['idDestino'];
    $idDestino = $_POST['idDestino'];
    $fechaActual = date("Y-m-d H:m:s");
    $idDestino = 1;
    $idUsuario = 1;

    $queryPermisosUsuario = "SELECT* FROM t_users WHERE id = $idUsuario";
    if ($resultPermisos = mysqli_query($conn_2020, $queryPermisosUsuario)) {
        if ($permiso = mysqli_fetch_array($resultPermisos)) {
            $ZIL_Permiso = $permiso['ZIL'];
            $AUTO_Permiso = $permiso['AUTO'];
            $DEC_Permiso = $permiso['DECC'];
            $DEP_Permiso = $permiso['DEP'];
            $OMA_Permiso = $permiso['OMA'];
            $ZHA_Permiso = $permiso['ZHA'];
            $ZHC_Permiso = $permiso['ZHC'];
            $ZHH_Permiso = $permiso['ZHH'];
            $ZHP_Permiso = $permiso['ZHP'];
            $ZIA_Permiso = $permiso['ZIA'];
            $ZIC_Permiso = $permiso['ZIC'];
            $ZIE_Permiso = $permiso['ZIE'];
        }
    }


    if ($action == "consultaSubsecciones") {
        // Variables tipo array para acumular los resultados de las secciones.
        $data = array();
        $dataZIL = "";
        $dataZIE = "";
        $dataAUTO = "";
        $dataDEC = "";
        $dataDEP = "";
        $dataOMA = "";
        $dataZHA = "";
        $dataZHC = "";
        $dataZHH = "";
        $dataZHP = "";
        $dataZIA = "";
        $dataZIC = "";

        // ZIL
        if ($ZIL_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 11)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];
                    $idSeccion = $row['id_seccion'];

                    $dataZIL .= " 
                        <div id=\"colzil\" class=\" scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MC', '$seccion');\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataZIL .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataZIL .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // ZIE
        if ($ZIE_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino,10)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    // ZIC
                    $dataZIE .= " 
                        <div id=\"colzie\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        # code...
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;
                        $dataZIE .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataZIE .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // AUTO
        if ($AUTO_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 24)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataAUTO .= " 
                        <div id=\"colauto\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        # code...
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;
                        $dataAUTO .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataAUTO .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // DEC
        if ($DEC_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataDEC .= " 
                        <div id=\"coldec\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataDEC .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataDEC .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // DEP
        if ($DEP_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 23)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataDEP .= " 
                        <div id=\"coldep\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataDEP .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataDEP .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // OMA 
        if ($OMA_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 19)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataOMA .= " 
                        <div id=\"coloma\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataOMA .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataOMA .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // ZHA
        if ($ZHA_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 5)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataZHA .= " 
                        <div id=\"colzha\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataZHA .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataZHA .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // ZHC
        if ($ZHC_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 6)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataZHC .= " 
                        <div id=\"colzhc\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataZHC .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataZHC .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // ZHH
        if ($ZHH_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 7)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataZHH .= " 
                        <div id=\"colzhh\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataZHH .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataZHH .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // ZHP
        if ($ZHP_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 12)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataZHP .= " 
                        <div id=\"colzhp\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataZHP .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataZHP .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // ZIA
        if ($ZIA_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 8)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    $dataZIA .= " 
                        <div id=\"colzia\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;

                        $dataZIA .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataZIA .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                $result->close();
                $conn_2020->next_result();
            }
        }

        // ZIC
        if ($ZIC_Permiso == 1) {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino,9)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $contador = 0;
                if ($row = mysqli_fetch_array($result)) {
                    $seccion = $row['seccion'];

                    // ZIC
                    $dataZIC .= " 
                        <div id=\"colzic\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"flex justify-center items-center absolute top-20 bg-gray-800 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md text-gray-100\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i data-target=\"modalPendientes\" data-toggle=\"modal\" class=\"fad fa-expand-arrows\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    foreach ($result as $value) {
                        # code...
                        $contador++;
                        $subseccion = $value['grupo'];
                        $pendientes = $contador;
                        $dataZIC .= "
                            <div id=\"abremodal\" data-id=\"$pendientes\" data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                class=\"p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\">
                                <h1 class=\"truncate mr-2\">$subseccion</h1>
                                <div
                                    class=\" bg-red-400 text-red-700 text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                    <h1>$pendientes</h1>
                                </div>
                            </div>
                        ";
                    }
                    // Cierre de Columnas.
                    $dataZIC .= "
                                    </div>
                                </div>
                            </div>
                        </div>
                    ";
                }
                // Cierra resultados de CALL, para saltar Error.
                $result->close();
                $conn_2020->next_result();
            }
        }

        // Datos almacenados.
        $data['dataZIE'] = $dataZIE;
        $data['dataAUTO'] = $dataAUTO;
        $data['dataDEC'] = $dataDEC;
        $data['dataDEP'] = $dataDEP;
        $data['dataOMA'] = $dataOMA;
        $data['dataZHA'] = $dataZHA;
        $data['dataZHC'] = $dataZHC;
        $data['dataZHH'] = $dataZHH;
        $data['dataZHP'] = $dataZHP;
        $data['dataZIA'] = $dataZIA;
        $data['dataZIC'] = $dataZIC;
        $data['dataZIL'] = $dataZIL;

        echo json_encode($data);
    }

    // **************************************************************************************************************
    // Pendientes por Subsecciones.
    if ($action == "consultarPendientesSubsecciones") {
        // Variables recibidad de Ajax.
        $idSeccion = $_POST['idSeccion'];
        $idDestino = $_POST['idDestino'];

        $arrayData = array();
        $data = "";


        // Query para obtener todas las subsecciones, según la sección.
        $query = "SELECT c_rel_seccion_subseccion.id, c_rel_seccion_subseccion.fase, c_rel_destino_seccion.id_destino, c_destinos.id, c_destinos.destino, c_rel_destino_seccion.id_seccion, c_secciones.id, c_secciones.titulo_seccion, c_secciones.seccion, c_rel_seccion_subseccion.id_subseccion, c_subsecciones.id, c_subsecciones.grupo FROM c_rel_destino_seccion INNER JOIN c_rel_seccion_subseccion ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id INNER JOIN c_destinos ON c_rel_destino_seccion.id_destino = c_destinos.id WHERE c_destinos.id = $idDestino AND c_secciones.id = $idSeccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            while ($row = mysqli_fetch_array($result)) {
                $subseccion = $row['grupo'];
                $idSubseccion = $row['id_subseccion'];

                $data .= "
                    <div class=\"flex flex-row justify-center items-center w-full py-4\">
                        <div class=\"w-2/12 font-medium text-sm text-gray-800 text-center\">
                            <h1>$subseccion</h1>
                        </div>
                        
                        <!-- Contenedor de las 4 columnas -->

                        <div
                        class=\"flex flex-wrap justify-center items-center w-full text-gray-800 text-center font-semibold text-xs\">
                        

                        <!-- Contenedor de tareas -->
                            <div id=\"filtrospen\" ondblclick=\"expandirpapa(this.id)\"
                                class=\"w-1/4 h-40 overflow-y-auto scrollbar px-2 rounded-md\">
                                <!-- COLUMNA PENDIENTES -->
                                
                                <!-- Aquí WHILE *********************+-->
                                <!-- Contenedor de tarea -->
                ";
                // Se obtienen los MC.
                $query = "SELECT* FROM t_mc WHERE id_destino = $idDestino ORDER BY id DESC LIMIT 20";
                $result = mysqli_query($conn_2020, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $actividad = $row['actividad'];


                    $data .= "
                                <div id=\"567\" onclick=\"expandir(this.id)\"
                                    class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                        
                                    <!-- Titulo -->
                                    <div class=\"my-1\">
                                        <p id=\"567titulo\" class=\"truncate\">$actividad</p>
                                    </div>
                                    <!-- Iconos -->
                                    <div class=\"flex flex-row justify-between items-center text-sm\">
                                        <div class=\"flex flex-row\">
                                            <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses\"
                                                width=\"20\" height=\"20\" alt=\"\">
                                            <p class=\"text-xs font-bold ml-1 text-gray-600\">Eduardo Meneses</p>
                                        </div>
                                        <div class=\"text-gray-600\">
                                            <i class=\"fas fa-paperclip mr-2\"></i>
                                            <i class=\"fas fa-comment-dots\"></i>
                                        </div>
                                    </div>
                                    <!-- Toogle -->
                                    <div id=\"567toggle\" class=\"hidden mt-2\">
                                        <div
                                            class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                            <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                                recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                                temporibus.</p>
                                            <div class=\"flex flex-row mt-1 self-center\">
                                                <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D\"
                                                    width=\"20\" height=\"20\" alt=\"\">
                                                <p class=\"text-xs font-bold ml-1 text-gray-600\">Javier Duarte</p>
                                                <p class=\"text-xs font-bold ml-6 text-gray-600\">13/09/2020 14:22:45</p>
                                            </div>
                                        </div>
                                        <button
                                            class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\">
                                            <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver en Planner
                                        </button>
                                    </div>
                                </div>

                ";
                }

                $data .= "                
                            </div>
                            <!-- Fin contenedor 1 *******************************-->

                            <!-- contenedor 2 *******************************-->
                            <div id=\"filtrodep\" ondblclick=\"expandirpapa(this.id)\"
                                class=\"w-1/4 h-40 overflow-y-auto scrollbar px-2\">
                                <!-- COLUMNA DEP -->
                                <!-- Contenedor de tarea -->
                                <div id=\"123\" onclick=\"expandir(this.id)\"
                                    class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                                    <!-- Titulo -->
                                    <div class=\"my-1\">
                                        <p id=\"123titulo\" class=\"truncate\">Aqui iria el titulo de la tarea correctiva o la
                                            descripcion de la misma.</p>
                                    </div>
                                    <!-- Iconos -->
                                    <div class=\"flex flex-row justify-between items-center text-sm\">
                                        <div class=\"flex flex-row\">
                                            <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses\"
                                                width=\"20\" height=\"20\" alt=\"\">
                                            <p class=\"text-xs font-bold ml-1 text-gray-600\">Eduardo Meneses</p>
                                        </div>
                                        <div class=\"flex flex-row items-center text-gray-600\">
                                            <i class=\"fas fa-paperclip mr-2\"></i>
                                            <i class=\"fas fa-comment-dots mr-2\"></i>
                                            <p class=\"text-xs font-normal bg-red-200 text-red-500 py-1 px-2 rounded-full\">
                                                Material</p>
                                        </div>
                                    </div>
                                    <!-- Toogle -->
                                    <div id=\"123toggle\" class=\"hidden mt-2\">
                                        <div
                                            class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                            <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                                recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                                temporibus.</p>
                                            <div class=\"flex flex-row mt-1 self-center\">
                                                <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D\"
                                                    width=\"20\" height=\"20\" alt=\"\">
                                                <p class=\"text-xs font-bold ml-1 text-gray-600\">Javier Duarte</p>
                                                <p class=\"text-xs font-bold ml-6 text-gray-600\">13/09/2020 14:22:45</p>
                                            </div>
                                        </div>
                                        <button
                                            class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\">
                                            <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver en Planner
                                        </button>
                                    </div>
                                </div>

                                <!-- Contenedor de tarea -->
                                <div id=\"456\" onclick=\"expandir(this.id)\"
                                    class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                                    <!-- Titulo -->
                                    <div class=\"my-1\">
                                        <p id=\"456titulo\" class=\"truncate\">Aqui iria el titulo de la tarea correctiva o la
                                            descripcion de la misma.</p>
                                    </div>
                                    <!-- Iconos -->
                                    <div class=\"flex flex-row justify-between items-center text-sm\">
                                        <div class=\"flex flex-row\">
                                            <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses\"
                                                width=\"20\" height=\"20\" alt=\"\">
                                            <p class=\"text-xs font-bold ml-1 text-gray-600\">Eduardo Meneses</p>
                                        </div>
                                        <div class=\"flex flex-row items-center text-gray-600\">
                                            <i class=\"fas fa-paperclip mr-2\"></i>
                                            <i class=\"fas fa-comment-dots mr-2\"></i>
                                            <p class=\"text-xs font-normal bg-blue-200 text-blue-500 py-1 px-2 rounded-full\">
                                                Calidad</p>
                                        </div>
                                    </div>
                                    <!-- Toogle -->
                                    <div id=\"456toggle\" class=\"hidden mt-2\">
                                        <div
                                            class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                            <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                                recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                                temporibus.</p>
                                            <div class=\"flex flex-row mt-1 self-center\">
                                                <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D\"
                                                    width=\"20\" height=\"20\" alt=\"\">
                                                <p class=\"text-xs font-bold ml-1 text-gray-600\">Javier Duarte</p>
                                                <p class=\"text-xs font-bold ml-6 text-gray-600\">13/09/2020 14:22:45</p>
                                            </div>
                                        </div>
                                        <button
                                            class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\">
                                            <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver en Planner
                                        </button>
                                    </div>
                                </div>

                                <!-- Contenedor de tarea -->
                                <div id=\"678\" onclick=\"expandir(this.id)\"
                                    class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                                    <!-- Titulo -->
                                    <div class=\"my-1\">
                                        <p id=\"678titulo\" class=\"truncate\">Aqui iria el titulo de la tarea correctiva o la
                                            descripcion de la misma.</p>
                                    </div>
                                    <!-- Iconos -->
                                    <div class=\"flex flex-row justify-between items-center text-sm\">
                                        <div class=\"flex flex-row\">
                                            <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses\"
                                                width=\"20\" height=\"20\" alt=\"\">
                                            <p class=\"text-xs font-bold ml-1 text-gray-600\">Eduardo Meneses</p>
                                        </div>
                                        <div class=\"flex flex-row items-center text-gray-600\">
                                            <i class=\"fas fa-paperclip mr-2\"></i>
                                            <i class=\"fas fa-comment-dots mr-2\"></i>
                                            <p
                                                class=\"text-xs font-normal bg-purple-200 text-purple-500 py-1 px-2 rounded-full\">
                                                Dirección</p>
                                        </div>
                                    </div>
                                    <!-- Toogle -->
                                    <div id=\"678toggle\" class=\"hidden mt-2\">
                                        <div
                                            class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                            <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                                recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                                temporibus.</p>
                                            <div class=\"flex flex-row mt-1 self-center\">
                                                <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D\"
                                                    width=\"20\" height=\"20\" alt=\"\">
                                                <p class=\"text-xs font-bold ml-1 text-gray-600\">Javier Duarte</p>
                                                <p class=\"text-xs font-bold ml-6 text-gray-600\">13/09/2020 14:22:45</p>
                                            </div>
                                        </div>
                                        <button
                                            class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\">
                                            <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver en Planner
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- contenedor 2 *******************************-->


                            <!-- contenedor 3 *******************************-->
                            <div id=\"filtrotra\" ondblclick=\"expandirpapa(this.id)\"
                                class=\"w-1/4 h-40 overflow-y-auto scrollbar px-2\">
                                <!-- COLUMNA TRABAJANDO -->
                                <!-- Contenedor de tarea -->
                                <div id=\"980\" onclick=\"expandir(this.id)\"
                                    class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                                    <!-- Titulo -->
                                    <div class=\"my-1\">
                                        <p id=\"980titulo\" class=\"truncate\">Aqui iria el titulo de la tarea correctiva o la
                                            descripcion de la misma.</p>
                                    </div>
                                    <!-- Iconos -->
                                    <div class=\"flex flex-row justify-between items-center text-sm\">
                                        <div class=\"flex flex-row\">
                                            <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses\"
                                                width=\"20\" height=\"20\" alt=\"\">
                                            <p class=\"text-xs font-bold ml-1 text-gray-600\">Eduardo Meneses</p>
                                        </div>
                                        <div class=\"flex flex-row items-center text-gray-600\">
                                            <i class=\"fas fa-paperclip mr-2\"></i>
                                            <i class=\"fas fa-comment-dots mr-2\"></i>
                                            <p class=\"text-xs font-black bg-blue-200 text-blue-500 py-1 px-2 rounded\">T</p>
                                        </div>
                                    </div>
                                    <!-- Toogle -->
                                    <div id=\"980toggle\" class=\"hidden mt-2\">
                                        <div
                                            class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                            <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                                recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                                temporibus.</p>
                                            <div class=\"flex flex-row mt-1 self-center\">
                                                <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D\"
                                                    width=\"20\" height=\"20\" alt=\"\">
                                                <p class=\"text-xs font-bold ml-1 text-gray-600\">Javier Duarte</p>
                                                <p class=\"text-xs font-bold ml-6 text-gray-600\">13/09/2020 14:22:45</p>
                                            </div>
                                        </div>
                                        <button
                                            class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\">
                                            <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver en Planner
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- contenedor 3 *******************************-->
                            
                            <!-- contenedor 4 *******************************-->
                            <div id=\"filtrossol\" ondblclick=\"expandirpapa(this.id)\"
                                class=\"w-1/4 h-40 overflow-y-auto scrollbar px-2\">
                ";

                $query = "SELECT* FROM t_mc WHERE id_destino = $idDestino and status='F' ORDER BY id DESC LIMIT 20";
                $result = mysqli_query($conn_2020, $query);
                while ($row = mysqli_fetch_array($result)) {
                    $actividad = $row['actividad'];
                    $data .= "

                                <!-- COLUMNA SOLUCIONADOS -->
                                <!-- Contenedor de tarea -->
                                <div id=\"111\" onclick=\"expandir(this.id)\"
                                    class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                                    <!-- Titulo -->
                                    <div class=\"my-1\">
                                        <p id=\"111titulo\" class=\"truncate\">$actividad</p>
                                    </div>
                                    <!-- Iconos -->
                                    <div class=\"flex flex-row justify-between items-center text-sm\">
                                        <div class=\"flex flex-row\">
                                            <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=Eduardo%20Meneses\"
                                                width=\"20\" height=\"20\" alt=\"\">
                                            <p class=\"text-xs font-bold ml-1 text-gray-600\">Eduardo Meneses</p>
                                        </div>
                                        <div class=\"flex flex-row items-center text-gray-600\">
                                            <i class=\"fas fa-paperclip mr-2\"></i>
                                            <i class=\"fas fa-comment-dots mr-2\"></i>
                                            <p class=\"text-xs font-black bg-green-200 text-green-500 py-1 px-2 rounded\">F
                                            </p>
                                        </div>
                                    </div>
                                    <!-- Toogle -->
                                    <div id=\"111toggle\" class=\"hidden mt-2\">
                                        <div
                                            class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                            <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellat,
                                                recusandae natus vel dolor placeat expedita unde repudiandae voluptatem
                                                temporibus.</p>
                                            <div class=\"flex flex-row mt-1 self-center\">
                                                <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=J%20D\"
                                                    width=\"20\" height=\"20\" alt=\"\">
                                                <p class=\"text-xs font-bold ml-1 text-gray-600\">Javier Duarte</p>
                                                <p class=\"text-xs font-bold ml-6 text-gray-600\">13/09/2020 14:22:45</p>
                                            </div>
                                        </div>
                                        <button
                                            class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\">
                                            <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver en Planner
                                        </button>
                                    </div>
                                </div>
                                ";
                }
                $data .= "                
                            </div>
                            <!-- contenedor 4 *******************************-->
                        </div>
                    </div>
                ";
            }
            $arrayData['result'] = $data;
        }
        echo json_encode($arrayData);
    }
}