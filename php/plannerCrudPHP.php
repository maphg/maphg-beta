<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include 'conexion.php';


if (isset($_POST['action'])) {
    // Variables Globales.
    $action = $_POST['action'];
    $idUsuario = $_POST['idUsuario'];
    $idDestino = $_POST['idDestino'];
    $fechaActual = date("Y-m-d H:m:s");

    // Array para Secciones.
    $arraySeccion = array(11 => "ZIL", 10 => "ZIE", 24 => "AUTO", 1 => "DEC", 23 => "DEP", 19 => "OMA", 5 => "ZHA", 6 => "ZHC", 7 => "ZHH", 12 => "ZHP", 8 => "ZIA", 9 => "ZIC");

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
            // $ZIL_Permiso = 1;
            // $AUTO_Permiso = 1;
            // $DEC_Permiso = 1;
            // $DEP_Permiso = 1;
            // $OMA_Permiso = 1;
            // $ZHA_Permiso = 1;
            // $ZHC_Permiso = 1;
            // $ZHH_Permiso = 1;
            // $ZHP_Permiso = 1;
            // $ZIA_Permiso = 1;;
            // $ZIC_Permiso = 1;
            // $ZIE_Permiso = 1;
            $idDestinoUsuarioPermiso = $permiso['id_destino'];
        }
    }

    // Consulta los Destinos que tiene acceso el usuario.
    if ($action == "obtenerDatosUsuario") {
        $data = array();
        $destinosOpcion = "";

        $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido, c_cargos.cargo, c_destinos.id, c_destinos.destino
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN c_destinos ON t_users.id_destino = c_destinos.id
        INNER JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        WHERE t_users.id = $idUsuario AND t_users.status = 'A' LIMIT 1;
        ";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idDestinoUsuario = $value['id'];
                $nombre = $value['nombre'];
                $apellido = $value['apellido'];
                $cargo = $value['cargo'];
            }
            $data['nombre'] = $nombre;
            $data['apellido'] = $apellido;
            $data['cargo'] = $cargo;
        }

        if ($idDestinoUsuario == 10) {
            $query = "SELECT id, destino FROM c_destinos WHERE status='A' ORDER BY destino ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                while ($row = mysqli_fetch_array($result)) {
                    $idDestinoS = $row['id'];
                    $nombreDestino = $row['destino'];
                    $destinosOpcion .= "<a href=\"#\" onclick=\"obtenerDatosUsuario($idDestinoS);\" class=\"hover:text-white d6 m-0 p-2 mb-2\">$nombreDestino</a>";
                }

                $queryDestino = "SELECT destino FROM c_destinos WHERE id = $idDestino";
                if ($resultDestino = mysqli_query($conn_2020, $queryDestino)) {
                    if ($row = mysqli_fetch_array($resultDestino)) {
                        $destino = $row['destino'];
                    }
                    $data['destino'] = $destino;
                }
            }
        } else {
            $query = "SELECT id, destino FROM c_destinos WHERE id = $idDestinoUsuario";
            if ($result = mysqli_query($conn_2020, $query)) {
                if ($row = mysqli_fetch_array($result)) {
                    $idDestinoS = $row['id'];
                    $nombreDestino = $row['destino'];
                    $data['destino'] = $nombreDestino;
                    $destinosOpcion .= "<a href=\"#\" onclick=\"obtenerDatosUsuario($idDestinoS);\" class=\"hover:text-white d6 m-0 p-2 mb-2\">$nombreDestino</a>";
                }
            }
        }

        $data['destinosOpcion'] = $destinosOpcion;
        echo json_encode($data);
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

        // Lista para Ordenar Columnas
        $listaZIL = "";
        $listaZIE = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND id_destino = $idDestino";
        }

        // ZIL
        if ($ZIL_Permiso == 1) {
            if ($idDestino == 10) {
                $query = "SELECT 
                c_subsecciones.id, c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 11";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 11)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataZIL .= " 
                        <div id=\"colzil\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-green-700 bg-green-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div id=\"ordenarPadre$seccion\" class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800 ordenarHijos$seccion\">
                    ";

                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenZIL[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenZIL[] = 0;
                        }
                        $idSubseccionOrdenZIL[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenZIL, SORT_DESC, $idSubseccionOrdenZIL);

                    foreach ($idSubseccionOrdenZIL as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenZIL[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataZIL .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 10";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 10)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    // ZIE
                    $dataZIE .= " 
                        <div id=\"colzie\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-yellow-700 bg-yellow-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div id=\"ordenarPadre$seccion\"
                                    class=\"ordenarHijos$seccion flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenZIE[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenZIE[] = 0;
                        }
                        $idSubseccionOrdenZIE[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenZIE, SORT_DESC, $idSubseccionOrdenZIE);

                    foreach ($idSubseccionOrdenZIE as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenZIE[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataZIE .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 24";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 24)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataAUTO .= " 
                        <div id=\"colauto\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-teal-700 bg-teal-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";

                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenAUTO[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenAUTO[] = 0;
                        }
                        $idSubseccionOrdenAUTO[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenAUTO, SORT_DESC, $idSubseccionOrdenAUTO);

                    foreach ($idSubseccionOrdenAUTO as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenAUTO[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataAUTO .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 1";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 1)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataDEC .= " 
                        <div id=\"coldec\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-purple-700 bg-purple-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";


                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenDEC[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenDEC[] = 0;
                        }
                        $idSubseccionOrdenDEC[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenDEC, SORT_DESC, $idSubseccionOrdenDEC);

                    foreach ($idSubseccionOrdenDEC as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenDEC[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataDEC .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 23";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 23)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataDEP .= " 
                        <div id=\"coldep\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-gray-300 bg-gray-900 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";


                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenDEP[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenDEP[] = 0;
                        }
                        $idSubseccionOrdenDEP[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenDEP, SORT_DESC, $idSubseccionOrdenDEP);

                    foreach ($idSubseccionOrdenDEP as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenDEP[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataDEP .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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


        // ZHA
        if ($ZHA_Permiso == 1) {
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 5";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 5)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataZHA .= " 
                        <div id=\"colzha\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-indigo-700 bg-indigo-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";


                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenZHA[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenZHA[] = 0;
                        }
                        $idSubseccionOrdenZHA[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenZHA, SORT_DESC, $idSubseccionOrdenZHA);

                    foreach ($idSubseccionOrdenZHA as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenZHA[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataZHA .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 6";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 6)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataZHC .= " 
                        <div id=\"colzhc\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-orange-700 bg-orange-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";


                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenZHC[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenZHC[] = 0;
                        }
                        $idSubseccionOrdenZHC[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenZHC, SORT_DESC, $idSubseccionOrdenZHC);

                    foreach ($idSubseccionOrdenZHC as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenZHC[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataZHC .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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

        // ZHP
        if ($ZHP_Permiso == 1) {
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 12";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 12)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataZHP .= " 
                        <div id=\"colzhp\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-lightblue-700 bg-lightblue-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";


                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenZHP[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenZHP[] = 0;
                        }
                        $idSubseccionOrdenZHP[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenZHP, SORT_DESC, $idSubseccionOrdenZHP);

                    foreach ($idSubseccionOrdenZHP as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenZHP[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataZHP .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 8";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 8)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataZIA .= " 
                        <div id=\"colzia\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-blue-700 bg-blue-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";


                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenZIA[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenZIA[] = 0;
                        }
                        $idSubseccionOrdenZIA[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenZIA, SORT_DESC, $idSubseccionOrdenZIA);

                    foreach ($idSubseccionOrdenZIA as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenZIA[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataZIA .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 9";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 9)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    // ZIC
                    $dataZIC .= " 
                        <div id=\"colzic\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative mh\">
                                <div
                                    class=\"absolute text-red-700 bg-red-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md\">$seccion</h1>
                                </div>
                                <div
                                    class=\"flex justify-center items-center absolute text-gray-500 top-0 right-0 m-1 text-md cursor-pointer hover:text-gray-900\">
                                    <i class=\"fad fa-expand-arrows\" onclick=\"pendientesSubsecciones($idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino);\"></i>
                                </div>
                                <div class=\"w-full flex flex-col justify-between overflow-y-auto mt-3 scrollbar\">
                                <div
                                    class=\"flex flex-col justify-center items-center font-medium text-xxs divide-y divide-gray-300 text-gray-800\">
                    ";


                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryPendientes = "SELECT count(id) FROM t_mc WHERE id_subseccion = $idSubseccion AND status = 'N' AND activo = 1 $filtroDestino";
                        if ($resultPendientes = mysqli_query($conn_2020, $queryPendientes)) {
                            if ($value = mysqli_fetch_array($resultPendientes)) {

                                $totalPendiente = $value['count(id)'];
                                $totalSubseccionOrdenZIC[] = $totalPendiente;
                            }
                        } else {
                            $totalSubseccionOrdenZIC[] = 0;
                        }
                        $idSubseccionOrdenZIC[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenZIC, SORT_DESC, $idSubseccionOrdenZIC);

                    foreach ($idSubseccionOrdenZIC as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenZIC[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataZIC .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); llamarFuncionX('obtenerEquipos');\">
                                        <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                        <div
                                            class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                            <h1>$totalPendiente</h1>
                                        </div>
                                    </div>
                                ";
                            }
                        }
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
        $data['listaZIL'] = $listaZIL;
        $data['listaZIE'] = $listaZIE;

        echo json_encode($data);
    }

    // **************************************************************************************************************
    // Pendientes por Subsecciones.
    if ($action == "consultarPendientesSubsecciones") {
        // Variables recibidad de Ajax.
        $idSeccion = $_POST['idSeccion'];
        $tipoPendiente = $_POST['tipoPendiente'];

        $arrayData = array();
        $data = "";
        $resultData = "";
        $dataOpcionesSubsecciones = "";
        $exportarSubseccion = "";
        $exportarSeccion = "";
        $exportarMisPendientes = "";

        // Identifica si el filtro es en General, Usuario o Seccion.
        $filtroSeccion = "";
        $filtroUsuario = "";

        if ($tipoPendiente == "MCU") {
            $filtroUsuario = "AND (t_mc.creado_por = $idUsuario OR t_mc.responsable = $idUsuario)";
        } elseif ($tipoPendiente == "MCS") {
            $filtroSeccion = "AND t_mc.id_seccion = $idSeccion";
        } else {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, $idSeccion)";
            $result = mysqli_query($conn_2020, $query);
        }

        if ($idDestino == 10) {
            $filtroDestinoMC = "";
        } else {
            $filtroDestinoMC = "AND t_mc.id_destino = $idDestino";
        }

        // Query para obtener todas las subsecciones, según la sección.
        if ($idDestino == 10) {
            $query = "SELECT c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, 
            c_secciones.seccion  
            FROM c_subsecciones 
            INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
            WHERE c_subsecciones.id_seccion = $idSeccion";
            $result = mysqli_query($conn_2020, $query);
        } else {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, $idSeccion)";
            $result = mysqli_query($conn_2020, $query);
        }

        if ($result) {
            $conn_2020->next_result();
            foreach ($result as $row) {
                $data = "";
                $subseccion = $row['grupo'];
                $idSubseccion = $row['id_subseccion'];
                $nombreSeccion = $row['seccion'];
                $nombreSubseccion = $row['grupo'];

                // Se almacenan las subsecciones para mostrarlas en el select (dataOpcionesSubsecciones).
                $misPendientesUsuario = "$idSeccion, 'MCU', '$nombreSeccion', $idUsuario, $idDestino";
                $misPendientesSinUsuario = "$idSeccion, 'MCU', '$nombreSeccion', 0, $idDestino";
                $misPendientesSeccion = "$idSeccion, 'MCS', '$nombreSeccion', $idUsuario, $idDestino";

                // Exportar Pendientes.
                $exportarSeccion = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarSeccion'";
                $exportarMisPendientes = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisPendientes'";
                $exportarMisPendientesPDF = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisPendientesPDF'";
                $exportarSubseccion .= "
                    <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"exportarPendientes($idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarSubseccion');\">
                        <h1 class=\"ml-2\">$nombreSubseccion</h1>
                    </div>                
                ";


                $estiloSeccion = $nombreSeccion;

                $dataOpcionesSubsecciones .= "<a href=\"#\" class=\"py-1 px-2 w-full hover:bg-gray-700\" onclick=\"toggleInivisble($idSubseccion);\">$subseccion</a>";

                $data .= "
                    <tr id=\"$idSubseccion\" class=\"modal hover:shadow-md cursor-pointer\">
                        <td class=\"px-2 py-3 font-semibold text-xs text-center text-gray-800\">
                            <h1>$subseccion</h1>
                        </td>
                ";


                // Pendientes. 
                $data .= "
                    <td class=\"px-2 py-3\">
                        <div id=\"" . $idSubseccion . "PRow\" ondblclick=\"expandirpapa(this.id)\"
                            class=\"h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto\"
                            style=\"width: 270px;\">
                ";

                $queryMCP = "SELECT t_mc.id, t_mc.actividad, t_colaboradores.nombre, t_colaboradores.apellido  
                FROM t_mc 
                INNER JOIN t_users ON t_mc.responsable = t_users.id 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                WHERE t_mc.id_subseccion = $idSubseccion 
                AND t_mc.status = 'N' AND activo = 1 $filtroUsuario $filtroSeccion $filtroDestinoMC
                ORDER BY t_mc.id DESC";

                $resultMCP = mysqli_query($conn_2020, $queryMCP);
                foreach ($resultMCP as $pendiente) {
                    $idMC = "";
                    $actividad = "";
                    $nombre = "";
                    $apellido = "";
                    $idMC = $pendiente['id'];
                    $actividad = $pendiente['actividad'];
                    $nombre = $pendiente['nombre'];
                    $apellido = $pendiente['apellido'];
                    $nombreCompleto = strtok($nombre, ' ') . " " . strtok($apellido, ' ');

                    if ($nombreCompleto == "SIN RESPONSABLE") {
                        $estiloResponsable = "text-red-600";
                        $nombreCompleto = "SIN RESPONSABLE";
                        $iconoResponsable = "";
                    } else {
                        $estiloResponsable = "text-gray-600";
                        $iconoResponsable = "https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%20$apellido";
                    }

                    // Se obtiene los Adjuntos.
                    $queryAdjuntoMC = "CALL obtenerAdjuntos_t_mc($idMC)";
                    $resultAdjuntoMC = mysqli_query($conn_2020, $queryAdjuntoMC);

                    // Se libera la conexion.
                    $conn_2020->next_result();
                    if ($rowAdjuntoMC = mysqli_fetch_array($resultAdjuntoMC)) {
                        if (mysqli_num_rows($resultAdjuntoMC) > 0) {
                            $iconoAdjuntoMC = " <i class=\"fas fa-paperclip mx-2\"></i> ";
                        } else {
                            $iconoAdjuntoMC = "";
                        }
                    } else {
                        $iconoAdjuntoMC = "";
                    }


                    // Obtiene el ultimo Comentario.
                    $queryComentarioMC = "CALL obtenerComentario_t_mc($idMC)";
                    $resultComentarioMC = mysqli_query($conn_2020, $queryComentarioMC);

                    // Se libera la conexion.
                    $conn_2020->next_result();
                    if ($rowComentarioMC = mysqli_fetch_array($resultComentarioMC)) {
                        $comentarioMC = $rowComentarioMC['comentario'];
                        $nombreMC = $rowComentarioMC['nombre'];
                        $apellidoMC = $rowComentarioMC['apellido'];
                        $fechaMC = (new DateTime($rowComentarioMC['fecha']))->format('d-m-y');
                        $nombreCompletoMC = strtok($nombreMC, ' ') . " " . strtok($apellidoMC, ' ');

                        if (mysqli_num_rows($resultComentarioMC) > 0) {
                            $iconoComentarioMC = " <i class=\"fas fa-comment-dots\"></i> ";
                            $AvatarNombre = "https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=$nombreMC%$apellidoMC";
                        } else {
                            $iconoComentarioMC = "";
                            $comentarioMC = "Sin Comentario";
                            $AvatarNombre = "";
                            $fechaMC = "";
                            $nombreCompletoMC = "";
                        }
                    } else {
                        $iconoComentarioMC = "";
                        $comentarioMC = "Sin Comentario";
                        $AvatarNombre = "";
                        $fechaMC = "";
                        $nombreMC = "";
                        $apellidoMC = "";
                        $nombreCompletoMC = "";
                    }


                    $data .= "
                        <div id=\"" . $idMC . "P\" onclick=\"expandir(this.id)\"
                            class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                            <!-- Titulo -->
                            <div class=\"my-1\">
                                <p id=\"" . $idMC . "Ptitulo\" class=\"truncate\">$actividad</p>
                            </div>
                            <!-- Iconos -->
                            <div class=\"flex flex-row justify-between items-center text-sm\">
                                <div class=\"flex flex-row\">
                                    <img src=\"$iconoResponsable\"
                                        width=\"20\" height=\"20\" alt=\"\">
                                    <p class=\"text-xs font-bold ml-1 $estiloResponsable\">$nombreCompleto</p>
                                </div>
                                <div class=\"text-gray-600\">
                                    $iconoComentarioMC
                                    $iconoAdjuntoMC
                                </div>
                            </div>
                            <!-- Toogle -->
                            <div id=\"" . $idMC . "Ptoggle\" class=\"hidden mt-2\">
                                <div
                                    class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                    <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                    <p class=\"uppercase\">$comentarioMC</p>
                                    <div class=\"flex flex-row mt-1 self-center\">
                                        <img src=\"$AvatarNombre\"
                                            width=\"20\" height=\"20\" alt=\"\">
                                        <p class=\"text-xs font-bold ml-1 text-gray-600\">$nombreCompletoMC</p>
                                        <p class=\"text-xs font-bold ml-6 text-gray-600\">$fechaMC
                                        </p>
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
                    </td>
                ";
                // Pendientes.


                // DEP
                $data .= "    
                        <td class=\"px-2 py-3\">
                            <div id=\"" . $idSubseccion . "DEP\" ondblclick=\"expandirpapa(this.id)\"
                                class=\"h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto\"
                                style=\"width: 270px;\">
                ";

                $queryDEP = "SELECT 
                t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.departamento_direccion, t_mc.departamento_finanzas, t_mc.departamento_rrhh, t_mc.id, t_mc.actividad, t_colaboradores.nombre, t_colaboradores.apellido  
                FROM t_mc 
                INNER JOIN t_users ON t_mc.responsable = t_users.id 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                WHERE t_mc.id_subseccion = $idSubseccion 
                AND t_mc.status = 'N' AND activo = 1 
                AND(t_mc.departamento_calidad != '' OR t_mc.departamento_compras != '' OR t_mc.departamento_direccion != '' OR t_mc.departamento_finanzas != '' OR t_mc.departamento_rrhh != '') 
                $filtroUsuario $filtroSeccion $filtroDestinoMC
                ORDER BY t_mc.id DESC";
                $resultDEP = mysqli_query($conn_2020, $queryDEP);
                foreach ($resultDEP as $dep) {
                    $idMC = $dep['id'];
                    $actividad = $dep['actividad'];
                    $nombre = $dep['nombre'];
                    $apellido = $dep['apellido'];
                    $calidad = $dep['departamento_calidad'];
                    $compras = $dep['departamento_compras'];
                    $direccion = $dep['departamento_direccion'];
                    $finanzas = $dep['departamento_finanzas'];
                    $rrhh = $dep['departamento_rrhh'];
                    $nombreCompleto = strtok($nombre, ' ') . " " . strtok($apellido, ' ');

                    if ($nombreCompleto == "SIN RESPONSABLE") {
                        $estiloResponsable = "text-red-600";
                        $nombreCompleto = "SIN RESPONSABLE";
                        $iconoResponsable = "";
                    } else {
                        $estiloResponsable = "text-gray-600";
                        $iconoResponsable = "https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%20$apellido";
                    }

                    if ($calidad != "") {
                        $calidad = "CA";
                    } else {
                        $calidad = "";
                    }
                    if ($compras != "") {
                        $compras = "CO";
                    } else {
                        $compras = "";
                    }
                    if ($direccion != "") {
                        $direccion = "DI";
                    } else {
                        $direccion = "";
                    }
                    if ($finanzas != "") {
                        $finanzas = "FI";
                    } else {
                        $finanzas = "";
                    }
                    if ($rrhh != "") {
                        $rrhh = "RH";
                    } else {
                        $rrhh = "";
                    }

                    $departamentosMas = $calidad . $compras . $direccion . $finanzas . $rrhh;
                    if (strlen($departamentosMas) > 2) {
                        $iconoDepartamentos =
                            "<p class=\"text-xs font-normal bg-blue-200 text-blue-500 py-1 px-3 rounded-full\">
                            $calidad $compras $direccion $finanzas $rrhh </p>";
                    } else {
                        if ($departamentosMas == "CA") {
                            $iconoDepartamentos =
                                "<p class=\"text-xs font-normal bg-blue-200 text-blue-500 py-1 px-2 rounded-full\">Calidad</p>";
                        } elseif ($departamentosMas == "CO") {
                            $iconoDepartamentos =
                                "<p class=\"text-xs font-normal bg-red-200 text-red-500 py-1 px-2 rounded-full\">Compras</p>";
                        } elseif ($departamentosMas == "DI") {
                            $iconoDepartamentos =
                                "<p class=\"text-xs font-normal bg-purple-200 text-purple-500 py-1 px-2 rounded-full\">Dirección</p>";
                        } elseif ($departamentosMas == "FI") {
                            $iconoDepartamentos =
                                "<p class=\"text-xs font-normal bg-red-200 text-red-500 py-1 px-2 rounded-full\">Compras</p>";
                        } elseif ($departamentosMas == "RH") {
                            $iconoDepartamentos =
                                "<p class=\"text-xs font-normal bg-teal-200 text-teal-500 py-1 px-2 rounded-full\">RRHH</p>";
                        }
                    }


                    // Se obtiene los Adjuntos.
                    $queryAdjuntoMC = "CALL obtenerAdjuntos_t_mc($idMC)";
                    $resultAdjuntoMC = mysqli_query($conn_2020, $queryAdjuntoMC);

                    // Se libera la conexion.
                    $conn_2020->next_result();
                    if ($rowAdjuntoMC = mysqli_fetch_array($resultAdjuntoMC)) {
                        if (mysqli_num_rows($resultAdjuntoMC) > 0) {
                            $iconoAdjuntoMC = " <i class=\"fas fa-paperclip mx-3\"></i> ";
                        } else {
                            $iconoAdjuntoMC = "";
                        }
                    } else {
                        $iconoAdjuntoMC = "";
                    }


                    // Obtiene el ultimo Comentario.
                    $queryComentarioMC = "CALL obtenerComentario_t_mc($idMC)";
                    $resultComentarioMC = mysqli_query($conn_2020, $queryComentarioMC);

                    // Se libera la conexion.
                    $conn_2020->next_result();
                    if ($rowComentarioMC = mysqli_fetch_array($resultComentarioMC)) {
                        $comentarioMC = $rowComentarioMC['comentario'];
                        $nombreMC = $rowComentarioMC['nombre'];
                        $apellidoMC = $rowComentarioMC['apellido'];
                        $fechaMC = (new DateTime($rowComentarioMC['fecha']))->format('d-m-y');
                        $nombreCompletoMC = strtok($nombreMC, ' ') . " " . strtok($apellidoMC, ' ');

                        if (mysqli_num_rows($resultComentarioMC) > 0) {
                            $iconoComentarioMC = " <i class=\"fas fa-comment-dots mx-2\"></i> ";
                            $AvatarNombre = "https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=$nombreMC%$apellidoMC";
                        } else {
                            $iconoComentarioMC = "";
                            $comentarioMC = "Sin Comentario";
                            $AvatarNombre = "";
                            $fechaMC = "";
                            $nombreCompletoMC = "";
                        }
                    } else {
                        $iconoComentarioMC = "";
                        $comentarioMC = "Sin Comentario";
                        $AvatarNombre = "";
                        $fechaMC = "";
                        $nombreMC = "";
                        $apellidoMC = "";
                        $nombreCompletoMC = "";
                    }


                    $data .= "
                        <div id=\"" . $idMC . "D\" onclick=\"expandir(this.id)\"
                            class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                            <!-- Titulo -->
                            <div class=\"my-1\">
                                <p id=\"" . $idMC . "Dtitulo\" class=\"truncate\">$actividad</p>
                            </div>
                            <!-- Iconos -->
                            <div class=\"flex flex-row justify-between items-center text-sm\">
                                <div class=\"flex flex-row\">
                                    <img src=\"$iconoResponsable\"
                                        width=\"20\" height=\"20\" alt=\"\">
                                    <p class=\"text-xs font-bold ml-1 $estiloResponsable\">$nombreCompleto</p>
                                </div>
                                <div class=\"flex flex-row items-center text-gray-600\">
                                    <!-- Iconos -->
                                    $iconoComentarioMC 
                                    $iconoAdjuntoMC
                                    $iconoDepartamentos 
                                </div>
                            </div>
                            <!-- Toogle -->
                            <div id=\"" . $idMC . "Dtoggle\" class=\"hidden mt-2\">
                                <div
                                    class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                    <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                    <p class=\"uppercase\">$comentarioMC</p>
                                    <div class=\"flex flex-row mt-1 self-center\">
                                        <img src=\"$AvatarNombre\" width=\"20\" height=\"20\" alt=\"\">
                                        <p class=\"text-xs font-bold ml-1 text-gray-600\">$nombreCompletoMC</p>
                                        <p class=\"text-xs font-bold ml-6 text-gray-600\">$fechaMC
                                        </p>
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
                    </td>
                ";
                // DEP.

                // Trabajando.
                $data .= "
                        <td class=\"px-2 py-3\">
                            <div id=\"coltra\" ondblclick=\"expandirpapa(this.id)\"
                                class=\"h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto\"
                                style=\"width: 270px;\">
                ";

                $queryT = "SELECT t_mc.id, t_mc.actividad, t_colaboradores.nombre, t_colaboradores.apellido  
                FROM t_mc 
                LEFT JOIN t_users ON t_mc.responsable = t_users.id 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                WHERE t_mc.id_subseccion = $idSubseccion 
                AND t_mc.status = 'N' AND activo = 1 AND t_mc.status_trabajare !='' $filtroUsuario $filtroSeccion $filtroDestinoMC
                ORDER BY t_mc.id DESC";
                $resultT = mysqli_query($conn_2020, $queryT);

                foreach ($resultT as $t) {
                    $idMC = $t['id'];
                    $actidad = $t['actividad'];
                    $nombre = $t['nombre'];
                    $apellido = $t['apellido'];
                    $nombreCompleto = strtok($nombre, ' ') . " " . strtok($apellido, ' ');

                    if ($nombreCompleto == "SIN RESPONSABLE") {
                        $estiloResponsable = "text-red-600";
                        $nombreCompleto = "SIN RESPONSABLE";
                        $iconoResponsable = "";
                    } else {
                        $estiloResponsable = "text-gray-600";
                        $iconoResponsable = "https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%20$apellido";
                    }

                    // Se obtiene los Adjuntos.
                    $queryAdjuntoMC = "CALL obtenerAdjuntos_t_mc($idMC)";
                    $resultAdjuntoMC = mysqli_query($conn_2020, $queryAdjuntoMC);

                    // Se libera la conexion.
                    $conn_2020->next_result();
                    if ($rowAdjuntoMC = mysqli_fetch_array($resultAdjuntoMC)) {
                        if (mysqli_num_rows($resultAdjuntoMC) > 0) {
                            $iconoAdjuntoMC = " <i class=\"fas fa-paperclip mx-2\"></i> ";
                        } else {
                            $iconoAdjuntoMC = "";
                        }
                    } else {
                        $iconoAdjuntoMC = "";
                    }


                    // Obtiene el ultimo Comentario.
                    $queryComentarioMC = "CALL obtenerComentario_t_mc($idMC)";
                    $resultComentarioMC = mysqli_query($conn_2020, $queryComentarioMC);

                    // Se libera la conexion.
                    $conn_2020->next_result();
                    if ($rowComentarioMC = mysqli_fetch_array($resultComentarioMC)) {
                        $comentarioMC = $rowComentarioMC['comentario'];
                        $nombreMC = $rowComentarioMC['nombre'];
                        $apellidoMC = $rowComentarioMC['apellido'];
                        $fechaMC = (new DateTime($rowComentarioMC['fecha']))->format('d-m-y');
                        $nombreCompletoMC = strtok($nombreMC, ' ') . " " . strtok($apellidoMC, ' ');

                        if (mysqli_num_rows($resultComentarioMC) > 0) {
                            $iconoComentarioMC = " <i class=\"fas fa-comment-dots mx-2\"></i> ";
                            $AvatarNombre = "https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=$nombreMC%$apellidoMC";
                        } else {
                            $iconoComentarioMC = "";
                            $comentarioMC = "Sin Comentario";
                            $AvatarNombre = "";
                            $fechaMC = "";
                            $nombreCompletoMC = "";
                        }
                    } else {
                        $iconoComentarioMC = "";
                        $comentarioMC = "Sin Comentario";
                        $AvatarNombre = "";
                        $fechaMC = "";
                        $nombreMC = "";
                        $apellidoMC = "";
                        $nombreCompletoMC = "";
                    }

                    $data .= "
                        <div id=\"" . $idMC . "T\" onclick=\"expandir(this.id)\"
                            class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                            <!-- Titulo -->
                            <div class=\"my-1\">
                                <p id=\"" . $idMC . "Ttitulo\" class=\"truncate\">$actidad</p>
                            </div>
                            <!-- Iconos -->
                            <div class=\"flex flex-row justify-between items-center text-sm\">
                                <div class=\"flex flex-row\">
                                    <img src=\"$iconoResponsable\"
                                        width=\"20\" height=\"20\" alt=\"\">
                                    <p class=\"text-xs font-bold ml-1 $estiloResponsable\">$nombreCompleto</p>
                                </div>
                                <div class=\"flex flex-row items-center text-gray-600\">
                                    $iconoComentarioMC
                                    $iconoAdjuntoMC
                                    <p class=\"text-xs font-black bg-blue-200 text-blue-500 py-1 px-2 mx-2 rounded\">
                                        T
                                    </p>
                                </div>
                            </div>
                            <!-- Toogle -->
                            <div id=\"" . $idMC . "Ttoggle\" class=\"hidden mt-2\">
                                <div
                                    class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                    <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                    <p class=\"uppercase\">$comentarioMC</p>
                                    <div class=\"flex flex-row mt-1 self-center\">
                                        <img src=\"$AvatarNombre\" width=\"20\" height=\"20\" alt=\"\">
                                        <p class=\"text-xs font-bold ml-1 text-gray-600\">$nombreCompletoMC</p>
                                        <p class=\"text-xs font-bold ml-6 text-gray-600\">$fechaMC
                                        </p>
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
                        </td>
                ";
                // Trabajando.


                // Solucionado.
                $data .= "
                        <td class=\"px-2 py-3\">
                            <div id=\"" . $idSubseccion . "S\" ondblclick=\"expandirpapa(this.id)\"
                                class=\"h-40 overflow-y-auto scrollbar px-2 rounded-md  mx-auto\"
                                style=\"width: 270px;\">
                ";

                $queryT = "SELECT t_mc.id, t_mc.actividad, t_colaboradores.nombre, t_colaboradores.apellido  
                FROM t_mc 
                LEFT JOIN t_users ON t_mc.responsable = t_users.id 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
                WHERE t_mc.id_subseccion = $idSubseccion 
                AND t_mc.status = 'F' AND activo = 1 $filtroUsuario $filtroSeccion $filtroDestinoMC
                ORDER BY t_mc.id DESC";
                $resultT = mysqli_query($conn_2020, $queryT);

                foreach ($resultT as $t) {
                    $idMC = $t['id'];
                    $actidad = $t['actividad'];
                    $nombre = $t['nombre'];
                    $apellido = $t['apellido'];
                    $nombreCompleto = strtok($nombre, ' ') . " " . strtok($apellido, ' ');

                    if ($nombreCompleto == "SIN RESPONSABLE") {
                        $estiloResponsable = "text-red-600";
                        $nombreCompleto = "SIN RESPONSABLE";
                        $iconoResponsable = "";
                    } else {
                        $estiloResponsable = "text-gray-600";
                        $iconoResponsable = "https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%20$apellido";
                    }

                    // Se obtiene los Adjuntos.
                    $queryAdjuntoMC = "CALL obtenerAdjuntos_t_mc($idMC)";
                    $resultAdjuntoMC = mysqli_query($conn_2020, $queryAdjuntoMC);

                    // Se libera la conexion.
                    $conn_2020->next_result();
                    if ($rowAdjuntoMC = mysqli_fetch_array($resultAdjuntoMC)) {
                        if (mysqli_num_rows($resultAdjuntoMC) > 0) {
                            $iconoAdjuntoMC = " <i class=\"fas fa-paperclip mx-2\"></i> ";
                        } else {
                            $iconoAdjuntoMC = "";
                        }
                    } else {
                        $iconoAdjuntoMC = "";
                    }


                    // Obtiene el ultimo Comentario.
                    $queryComentarioMC = "CALL obtenerComentario_t_mc($idMC)";
                    $resultComentarioMC = mysqli_query($conn_2020, $queryComentarioMC);

                    // Se libera la conexion.
                    $conn_2020->next_result();
                    if ($rowComentarioMC = mysqli_fetch_array($resultComentarioMC)) {
                        $comentarioMC = $rowComentarioMC['comentario'];
                        $nombreMC = $rowComentarioMC['nombre'];
                        $apellidoMC = $rowComentarioMC['apellido'];
                        $fechaMC = (new DateTime($rowComentarioMC['fecha']))->format('d-m-y');
                        $nombreCompletoMC = strtok($nombreMC, ' ') . " " . strtok($apellidoMC, ' ');

                        if (mysqli_num_rows($resultComentarioMC) > 0) {
                            $iconoComentarioMC = " <i class=\"fas fa-comment-dots\"></i> ";
                            $AvatarNombre = "https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=$nombreMC%$apellidoMC";
                        } else {
                            $iconoComentarioMC = "";
                            $comentarioMC = "Sin Comentario";
                            $AvatarNombre = "";
                            $fechaMC = "";
                            $nombreCompletoMC = "";
                        }
                    } else {
                        $iconoComentarioMC = "";
                        $comentarioMC = "Sin Comentario";
                        $AvatarNombre = "";
                        $fechaMC = "";
                        $nombreMC = "";
                        $apellidoMC = "";
                        $nombreCompletoMC = "";
                    }
                    $data .= "
                        <div id=\"" . $idMC . "S\" onclick=\"expandir(this.id)\"
                            class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md\">
                            <!-- Titulo -->
                            <div class=\"my-1\">
                                <p id=\"" . $idMC . "Stitulo\" class=\"truncate\">$actidad</p>
                            </div>
                            <!-- Iconos -->
                            <div class=\"flex flex-row justify-between items-center text-sm\">
                                <div class=\"flex flex-row\">
                                    <img src=\"$iconoResponsable\"
                                        width=\"20\" height=\"20\" alt=\"\">
                                    <p class=\"text-xs font-bold ml-1 $estiloResponsable\">$nombreCompleto</p>
                                </div>
                                <div class=\"flex flex-row items-center text-gray-600\">
                                    $iconoComentarioMC
                                    $iconoAdjuntoMC
                                    <p
                                        class=\"text-xs font-black bg-green-200 text-green-500 py-1 px-2 mx-2 rounded\">
                                        F
                                    </p>
                                </div>
                            </div>
                            <!-- Toogle -->
                            <div id=\"" . $idMC . "Stoggle\" class=\"hidden mt-2\">
                                <div
                                    class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                    <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                    <p class=\"uppercase\">$comentarioMC</p>
                                    <div class=\"flex flex-row mt-1 self-center\">
                                        <img src=\"$AvatarNombre\"
                                            width=\"20\" height=\"20\" alt=\"\">
                                        <p class=\"text-xs font-bold ml-1 text-gray-600\">$nombreCompletoMC</p>
                                        <p class=\"text-xs font-bold ml-6 text-gray-600\">$fechaMC
                                        </p>
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
                    </td>
                ";
                // Solucionado.

                // Fin.
                $data .= "
                    </tr>
                ";

                $resultData .= $data;
            }
            $arrayData['resultData'] = $resultData;
            $arrayData['dataOpcionesSubsecciones'] = $dataOpcionesSubsecciones;
            $arrayData['misPendientesUsuario'] = $misPendientesUsuario;
            $arrayData['misPendientesSinUsuario'] = $misPendientesSinUsuario;
            $arrayData['misPendientesSeccion'] = $misPendientesSeccion;
            $arrayData['estiloSeccion'] = $estiloSeccion;
            $arrayData['exportarSubseccion'] = $exportarSubseccion;
            $arrayData['exportarSeccion'] = $exportarSeccion;
            $arrayData['exportarMisPendientes'] = $exportarMisPendientes;
            $arrayData['exportarMisPendientesPDF'] = $exportarMisPendientesPDF;
        }
        echo json_encode($arrayData);
    }


    if ($action == "exportarListarUsuarios") {
        $idSeccion = $_POST['idSeccion'];
        $exportarSeccionUsuario = "";
        if ($idDestinoUsuarioPermiso == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND t_users.id_destino = $idDestino";
        }

        $queryUsuario = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido 
        FROM t_users 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.status = 'A' $filtroDestino";
        if ($resultUsuario = mysqli_query($conn_2020, $queryUsuario)) {
            foreach ($resultUsuario as $row) {
                $idUsuario = $row['id'];
                $nombre = $row['nombre'];
                $apellido = $row['apellido'];
                $exportarSeccionUsuario .= "
                    <div class=\"exportarEXCEL hidden w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"exportarPendientes($idUsuario, $idDestino, $idSeccion, 0, 'exportarSeccionUsuario');\">
                        <h1 class=\"ml-2\">$nombre $apellido</h1>
                    </div> 

                    <div class=\"exportarPDF hidden w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"exportarPendientes($idUsuario, $idDestino, $idSeccion, 0, 'exportarSeccionUsuarioPDF');\">
                        <h1 class=\"ml-2\">$nombre $apellido</h1>
                    </div>                
                ";
            }
            echo $exportarSeccionUsuario;
        }
    }

    if ($action == "consultaFinalExcel") {
        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $tipoExportar = $_POST['tipoExportar'];
        $listaId = "";

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND id_destino = $idDestino";
        }


        if ($tipoExportar == "exportarMisPendientes") {
            $filtroTipo = "AND id_seccion = $idSeccion AND responsable = $idUsuario";
        } elseif ($tipoExportar == "exportarSeccion") {
            $filtroTipo = "AND id_seccion = $idSeccion $filtroDestino";
        } elseif ($tipoExportar == "exportarSubseccion") {
            $filtroTipo = "AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion $filtroDestino";
        } elseif ($tipoExportar == "exportarSeccionUsuario") {
            $filtroTipo = "AND id_seccion = $idSeccion AND responsable = $idUsuario $filtroDestino";
        } elseif ($tipoExportar == "exportarMisPendientesPDF") {
            $filtroTipo = "AND id_seccion = $idSeccion AND responsable = $idUsuario";
        } elseif ($tipoExportar == "exportarSeccionUsuarioPDF") {
            $filtroTipo = "AND id_seccion = $idSeccion AND responsable = $idUsuario $filtroDestino";
        } else {
            $filtroTipo = "activo = 2";
        }

        $query = "SELECT id FROM t_mc WHERE activo = 1 and status = 'N' $filtroTipo";
        if ($result = mysqli_query($conn_2020, $query)) {
            $totalResultados = mysqli_num_rows($result);
            $contador = 0;
            foreach ($result as $row) {
                $contador++;
                $id = $row['id'];

                if ($contador < $totalResultados) {
                    $listaId .= $id . ",";
                } else {
                    $listaId .= $id;
                }
            }
            // echo $filtroTipo . ";";
            echo $listaId;
        }
    }

    // Borrar.
    if ($action == "consultarPendientesSubseccionesExcel") {
        // Variables recibidad de Ajax.
        $idSeccion = $_POST['idSeccion'];
        $idDestino = $_POST['idDestino'];
        $tipoPendiente = $_POST['tipoPendiente'];

        // Identifica si el filtro es en General, Usuario o Seccion.
        $filtroSeccion = "";
        $filtroUsuario = "";

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND t_mc.id_destino = $idDestino";
        }

        if ($tipoPendiente == "MCU") {
            $filtroUsuario = "AND (t_mc.creado_por = $idUsuario OR t_mc.responsable = $idUsuario)";
        } elseif ($tipoPendiente == "MCS") {
            $filtroSeccion = "AND id_seccion = $idUsuario";
        }

        $queryExcel = "SELECT t_mc.id 
        FROM t_mc 
        WHERE  t_mc.id_subseccion = $idSubseccion 
        AND t_mc.status = 'N' AND activo = 1 $filtroUsuario $filtroSeccion $filtroDestino
        ORDER BY t_mc.id DESC";
        if ($resultExcel = mysqli_query($conn_2020, $queryExcel)) {
            foreach ($resultExcel as $idMC) {
                echo "";
            }
        }
    }


    if ($action == "obtenerEquipos") {
        // Variables AJAX.
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $palabraEquipo = $_POST['palabraEquipo'];
        $rangoInicial = intval($_POST['rangoInicial']);
        $rangoFinal = $_POST['rangoFinal'];
        $tipoOrdenamiento = $_POST['tipoOrdenamiento'];

        // Variables locales
        $contadorRango = 0;
        $data = array();
        $dataEquipos = "";
        $opcionBuscarEquipo = "";
        $paginacionEquipos = "";
        $ordenMCEquipos = array();
        $ordenIdEquipos = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND id_destino = $idDestino";
        }

        if ($palabraEquipo == "") {
            $filtroPalabraEquipo = "";
        } else {
            $filtroPalabraEquipo = "AND (equipo LIKE '%$palabraEquipo%' OR matricula LIKE '%$palabraEquipo%' OR id LIKE '%$palabraEquipo%')";
        }

        $opcionBuscarEquipo = "onclick=\"obtenerEquipos($idUsuario, $idDestino, $idSeccion, $idSubseccion);\"";
        $seccionEquipos = $arraySeccion[$idSeccion];

        // Busca Equipos.
        $queryEquipos = "SELECT id FROM t_equipos WHERE id_subseccion = $idSubseccion AND status = 'A' $filtroPalabraEquipo $filtroDestino ORDER BY equipo ASC";
        if ($resultEquipos = mysqli_query($conn_2020, $queryEquipos)) {
            $totalEquipos = mysqli_num_rows($resultEquipos);

            // Filtro para el tipo de Ordenamientos de los Equipos en la seccion de las Columnas.
            if ($tipoOrdenamiento == 'MCF') {
                foreach ($resultEquipos as $equipo) {
                    $idEquipo = $equipo['id'];
                        $queryMC = "SELECT COUNT(id) FROM t_MC WHERE id_equipo = $idEquipo AND status = 'F' AND activo = 1";

                        if ($resultMC = mysqli_query($conn_2020, $queryMC)) {
                            $MC = mysqli_fetch_array($resultMC);

                            // Valor MC Obtenidos.
                            $totalMC = $MC['COUNT(id)'];
                            $ordenMCEquipos[] = $totalMC;
                        }else{
                        $ordenMCEquipos[] = 0;
                        }
                    $ordenIdEquipos[] = $idEquipo;
                }
                array_multisort($ordenMCEquipos, SORT_DESC, $ordenIdEquipos);
            } elseif ($tipoOrdenamiento == 'MCN') {
                foreach ($resultEquipos as $equipo) {
                    $idEquipo = $equipo['id'];
                    $queryMC = "SELECT COUNT(id) FROM t_MC WHERE id_equipo = $idEquipo AND status = 'N' AND activo = 1";

                    if ($resultMC = mysqli_query($conn_2020, $queryMC)) {
                        $MC = mysqli_fetch_array($resultMC);

                        // Valor MC Obtenidos.
                        $totalMC = $MC['COUNT(id)'];
                        $ordenMCEquipos[] = $totalMC;
                    } else {
                        $totalMC = 0;
                        $ordenMCEquipos[] = $totalMC;
                    }
                    $ordenIdEquipos[] = $idEquipo;
                }
                array_multisort($ordenMCEquipos, SORT_DESC, $ordenIdEquipos);
            } elseif ($tipoOrdenamiento == 'nombreEquipo') {
                foreach ($resultEquipos as $equipo) {
                    $idEquipo = $equipo['id'];
                    $ordenIdEquipos[] = intval($idEquipo);
                }
            }

            $topeTotalEquipos = $totalEquipos - 1;

            for ($keyMC = 0; $keyMC <= $topeTotalEquipos; $keyMC++) {

                // Valores Inicializados para evitar Error Idex Array.
                $totalMCEquipo = 0;
                $idEquipo = 0;

                // Contador de Resultados Obtenidos.

                // Se obtiene el Id del Equipo, mediante el array previo ordenado.
                $idEquipo = $ordenIdEquipos[$keyMC];

                // Realiza busca los equipos con el arreglo ordenado
                $queryEquipos = "SELECT id, equipo FROM t_equipos WHERE id = $idEquipo";
                if ($resultEquipos = mysqli_query($conn_2020, $queryEquipos)) {
                    if ($rowEquipo = mysqli_fetch_array($resultEquipos)) {
                        // Variables Globales para los equipos.
                        $nombreEquipo = $rowEquipo['equipo'];
                        $idEquipo = $rowEquipo['id'];

                        //MC Pendientes N. 
                        $queryMCN = "SELECT COUNT(id) FROM t_mc 
                            WHERE id_equipo = $idEquipo AND status ='N' AND activo = 1";
                        if ($resultMCN = mysqli_query($conn_2020, $queryMCN)) {
                            if ($rowMCN = mysqli_fetch_array($resultMCN)) {
                                $totalMCN = $rowMCN['COUNT(id)'];
                                if ($totalMCN > 0) {
                                    $estiloMCN = "bg-red-200 text-red-400";
                                } else {
                                    $estiloMCN = "bg-white text-white-400";
                                    $totalMCN = "";
                                }
                            }
                        } else {
                            $totalMCN = "";
                            $estiloMCN = "bg-white text-white-400";
                        }

                        //MC Solucionados F. 
                        $queryMCF = "SELECT COUNT(id) FROM t_mc 
                            WHERE id_equipo = $idEquipo AND status ='F' AND activo = 1";
                        if ($resultMCF = mysqli_query($conn_2020, $queryMCF)) {
                            if ($rowMCF = mysqli_fetch_array($resultMCF)) {
                                $totalMCF = $rowMCF['COUNT(id)'];
                                if ($totalMCF > 0) {
                                    $estiloMCF = "bg-green-200 text-green-500";
                                } else {
                                    $estiloMCF = "bg-white text-white-400";
                                    $totalMCF = "";
                                }
                            }
                        } else {
                            $totalMCF = "";
                            $estiloMCF = "bg-white text-white-400";
                        }

                        //MP PLANIFICADOS Pendientes N. 
                        $queryMPN = "SELECT COUNT(id) FROM t_mp_planeacion 
                            WHERE id_equipo = $idEquipo AND (status ='N' OR status = 'P') AND tipoplan = 'MP' AND activo = 1";
                        if ($resultMPN = mysqli_query($conn_2020, $queryMPN)) {
                            if ($rowMPN = mysqli_fetch_array($resultMPN)) {
                                $totalMPN = $rowMPN['COUNT(id)'];
                            } else {
                                $totalMPN = "0";
                            }
                        } else {
                            $totalMPN = "0";
                        }

                        //MP NP PLANIFICADOS, todos Finalizados F. 
                        $queryMPNP = "SELECT COUNT(id) FROM t_mp_np 
                            WHERE id_equipo = $idEquipo AND status ='F' AND activo = 1";
                        if ($resultMPNP = mysqli_query($conn_2020, $queryMPNP)) {
                            if ($rowMPNP = mysqli_fetch_array($resultMPNP)) {
                                $totalMPNP = $rowMPNP['COUNT(id)'];
                            } else {
                                $totalMPNP = "0";
                            }
                        } else {
                            $totalMPNP = "0";
                        }

                        //MP PLANIFICADOS Finalizados F. 
                        $queryMPF = "SELECT fecha_registro, COUNT(id) FROM t_mp_planeacion 
                            WHERE id_equipo = $idEquipo AND status ='F' AND tipoplan = 'MP' AND activo = 1 ORDER BY fecha_registro DESC";
                        if ($resultMPF = mysqli_query($conn_2020, $queryMPF)) {
                            if ($rowMPF = mysqli_fetch_array($resultMPF)) {
                                $totalMPF = $rowMPF['COUNT(id)'];
                                $fechaMPF = $rowMPF['fecha_registro'];
                                $fechaMPF = (new DateTime($fechaMPF))->format('d-m-Y');
                            } else {
                                $totalMPF = "0";
                                $fechaMPF = "NA";
                            }
                        } else {
                            $totalMPF = "0";
                            $fechaMPF = "NA";
                        }

                        // Nombre de Equipo.
                        $dataEquipos .= "
                                <div class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\" style=\"display:flex;\">
                                    <div id=\"equipo123\" onclick=\"expandir(this.id)\" class=\"w-2/6 h-full flex flex-row items-center justify-between bg-blue-100 text-blue-500 rounded-l-md cursor-pointer hover:shadow-md\">
                                        <div class=\" flex flex-row items-center truncate\">
                                            <i class=\"fas fa-cog mx-2\"></i>
                                            <h1>$keyMC - $ordenIdEquipos[$keyMC] - $nombreEquipo</h1>
                                        </div>
                                        <div class=\"mx-2\">
                                            <i class=\"fas fa-chevron-down\"></i>
                                        </div>
                                    </div>
                            ";

                        //MC Pendientes N. 
                        $dataEquipos .= "       
                                <!-- MC PENDIENTES -->
                                <div onclick=\"obtenerMCN($idEquipo);\" class=\"w-16 h-full flex items-center justify-center $estiloMCN hover:shadow-md\">
                                    <h1>$totalMCN</h1>
                                </div>
                            ";

                        //MC Solucionados F 
                        $dataEquipos .= "
                                <!-- MC SOLUCIONADOS -->
                                <div onclick=\"obtenerMCF($idEquipo);\" class=\"w-16 flex h-full items-center justify-center $estiloMCF hover:shadow-md\">
                                    <h1>$totalMCF</h1>
                                </div>
                            ";

                        // MP Planificados.
                        $dataEquipos .= "
                                <!-- MP PLANIFICADOS -->
                                <div class=\"w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md\">
                                    <h1>$totalMPN</h1>
                                </div>
                            ";


                        // MP NO Planificados.
                        $dataEquipos .= "
                                <!-- MP NO PLANIFICADOS -->
                                <div class=\"w-16 flex h-full items-center justify-center bg-purple-200 text-purple-500 hover:shadow-md\">
                                    <h1>$totalMPNP</h1>
                                </div>
                            ";


                        // MP Finalizados.
                        $dataEquipos .= "
                                <!-- MP FINALIZADOS -->
                                <div class=\"w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md\">
                                    <h1>$totalMPF</h1>
                                </div>
                            ";


                        // MP Ultimo.
                        $dataEquipos .= "
                                <!--  ULTIMO MP -->
                                <div class=\"w-24 flex h-full items-center justify-center hover:shadow-md\">
                                    <h1 class=\"font-xs\">$fechaMPF</h1>
                                </div>
                            ";


                        // Test Equipo.
                        $dataEquipos .= "
                                <!--  TEST -->
                                <div class=\"w-16 flex h-full items-center justify-center bg-indigo-200 text-indigo-500 hover:shadow-md\">
                                    <h1>22</h1>
                                </div>
                            ";


                        // Ultimo TEST Equipo.
                        $dataEquipos .= "
                                <!--  ULTIMO TEST -->
                                <div class=\"w-24 flex h-full items-center justify-center hover:shadow-md\">
                                    <h1 class=\"font-xs\">AGO 2020</h1>
                                </div>
                            ";


                        // Cotizaciones Equipos.
                        $dataEquipos .= "
                                <!--  COTIZACIONES -->
                                <div class=\"w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md\">
                                    <h1>22</h1>
                                </div>
                            ";


                        // Info Equipos.
                        $dataEquipos .= "
                                <!--  INFO -->
                                <div class=\"w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 hover:shadow-md\">
                                    <h1><i class=\"fas fa-eye fa-lg\"></i></h1>
                                </div>
                            ";


                        // Fotos Equipos.
                        $dataEquipos .= "
                                <!--  MEDIA -->
                                <div class=\"w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 rounded-r-md hover:shadow-md\">
                                    <h1><i class=\"fas fa-photo-video fa-lg\"></i></h1>
                                </div>
                            ";

                        // Fin de Fila por Cada Equipo.
                        $dataEquipos .= "
                                </div>          
                            ";
                    }
                }
            }

            // Datos almacenados.
            $data['dataEquipos'] = $dataEquipos;
            $data['opcionBuscarEquipo'] = $opcionBuscarEquipo;
            $data['totalEquipos'] = "Total Equipos: $totalEquipos";
            $data['seccionEquipos'] = $seccionEquipos;
            $data['paginacionEquipos'] = $paginacionEquipos;
            unset($ordenMCEquipos, $ordenIdEquipos);
        }
        echo json_encode($data);
    }

    // Se obtienen todos los MCN - Pendientes por Equipo.
    if ($action == "obtenerMCN") {
        $idEquipo = $_POST['idEquipo'];
        $data = array();
        $MC = "";
        $contadorMC = 0;

        $query = "
            SELECT t_mc.id, t_mc.responsable, t_mc.actividad, t_mc.fecha_creacion, t_colaboradores.nombre, t_colaboradores.apellido 
            FROM t_mc 
            INNER JOIN t_users ON t_mc.creado_por = t_users.id
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_mc.id_equipo = $idEquipo AND t_mc.status = 'N' AND t_mc.activo = 1
        ";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $row) {
                $contadorMC++;
                $idMC = $row['id'];
                $responsable = $row['responsable'];
                $actividad = $row['actividad'];
                $creadoPor = strtok($row['nombre'], ' ') . " " . strtok($row['apellido'], ' ');
                $fechaCreacion = (new DateTime($row['fecha_creacion']))->format('m-Y');

                // Responsable.
                $queryResponsable = "
                SELECT t_colaboradores.id, t_colaboradores.nombre, t_colaboradores.apellido
                FROM t_users
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $responsable
                ";

                if ($resultResponsable = mysqli_query($conn_2020, $queryResponsable)) {
                    foreach ($resultResponsable as $value) {
                        $nombreResponsable = strtok($value['nombre'], ' ') . " " . strtok($value['apellido'], ' ');
                    }
                } else {
                    $nombreResponsable = "";
                }

                // Imagenes Y Documentos.
                $queryMedia = "SELECT COUNT(id) FROM t_mc_adjuntos WHERE id_mc = $idMC AND activo=1";
                if ($resultMedia = mysqli_query($conn_2020, $queryMedia)) {
                    foreach ($resultMedia as $value) {
                        $totalMedia = $value['COUNT(id)'];
                    }
                } else {
                    $totalMedia = 0;
                }

                // Comentarios.
                $queryComentario = "SELECT COUNT(id) FROM t_mc_comentarios WHERE id_mc = $idMC AND activo=1";
                if ($resultComentario = mysqli_query($conn_2020, $queryComentario)) {
                    foreach ($resultComentario as $value) {
                        $totalComentario = $value['COUNT(id)'];
                    }
                } else {
                    $totalComentario = 0;
                }

                $MC .= "
                    <div class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\">
                        <!-- FALLA -->
                        <div class=\"w-full h-full flex flex-row items-center justify-between bg-red-100 text-red-500 rounded-l-md cursor-pointer hover:shadow-md border-l-4 border-red-200 relative\">

                            <div class=\"absolute\" style=\"left: -17px;\">
                                <i class=\"fas fa-siren-on animated flash infinite fa-rotate-270\"></i>
                            </div>
                            <div class=\"absolute flex hover:opacity-25\" style=\"right: 0%; font-size: 9px;\">
                                <div class=\" bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">M</h1>
                                </div>
                                <div class=\" bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">T</h1>
                                </div>
                                <div class=\" bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Electricidad</h1>
                                </div>
                                <div class=\" bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Dirección</h1>
                                </div>
                            </div>

                            <div class=\" flex flex-row items-center truncate w-full\">
                                <div>
                                    <i class=\"fas fa-hammer mx-2\"></i>
                                </div>
                                <div class=\"flex flex-col leading-none w-full flex-wrap\">
                                    <h1 class=\"\"> $actividad </h1>
                                    <h1 class=\"tex-xs font-normal italic text-red-300\">creado por: $creadoPor</h1>

                                </div>
                            </div>
                        </div>

                        <!-- RESPONSABLE -->
                        <div onclick=\"obtenerUsuarios('asignarMC', $idMC);\" class=\"w-48 flex h-full items-center justify-center hover:shadow-md\">
                            <h1>$nombreResponsable</h1>
                        </div>

                        <!-- INICIO & FIN-->
                        <div class=\"w-64 flex h-full items-center justify-center hover:shadow-md\">
                            <input class=\"bg-white focus:outline-none focus:shadow-none py-2 px-4 block w-full appearance-none leading-normal font-semibold text-xs text-center\" type=\"text\" name=\"datefilter\" value=\"$fechaCreacion\">
                        </div>

                        <!--  ADJUNTOS -->
                        <div onclick=\"obtenerAdjuntos($idMC);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1 class=\"font-xs\">$totalMedia</h1>
                        </div>

                        <!--  COMENTARIOS -->
                        <div onclick=\"obtenerComentariosMC($idMC);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1>$totalComentario</h1>
                        </div>

                        <!--  STATUS -->
                        <div onclick=\"statusMC('');\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md hover:bg-teal-200 text-teal-500 rounded-r-md\">
                            <div><i class=\"fad fa-exclamation-circle fa-lg\"></i></div>
                        </div>

                    </div>                
                ";
            }
            $data['contadorMC'] = $contadorMC;
            $data['MC'] = $MC;
        }
        // l
        $query = "
            SELECT c_secciones.seccion, t_equipos.equipo 
            FROM t_equipos 
            INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
            WHERE t_equipos.id = $idEquipo;
        ";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $seccion = $value['seccion'];
                $equipo = $value['equipo'];

                $data['seccion'] = $seccion;
                $data['nombreEquipo'] = $equipo;
            }
        }
        echo json_encode($data);
    }


    // Busca Usuarios para Asignar responsable.
    if ($action == "obtenerUsuarios") {
        // Variables AJAX.
        $palabraUsuario = $_POST['palabraUsuario'];
        $tipoAsginacion = $_POST['tipoAsginacion'];
        $idItem = $_POST['idItem'];

        // Variables Locales.
        $data = array();
        $dataUsuarios = "";
        $totalUsuarios = 0;

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND (t_users.id_destino = $idDestino OR t_users.id_destino = 10)";
        }

        if ($palabraUsuario != "") {
            $filtroPalabraUsuario = "AND (t_colaboradores.nombre LIKE '%$palabraUsuario%' 
            OR t_colaboradores.apellido LIKE '%$palabraUsuario%' OR c_cargos.cargo LIKE '%$palabraUsuario%')";
        } else {
            $filtroPalabraUsuario = "";
        }

        $queryUsuarios = "SELECT t_users.id 'idUsuario', t_colaboradores.nombre, t_colaboradores.apellido, c_cargos.cargo 
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        WHERE t_users.status= 'A' AND t_users.id != 0 $filtroDestino $filtroPalabraUsuario ";
        if ($resultUsuarios = mysqli_query($conn_2020, $queryUsuarios)) {
            $totalUsuarios = mysqli_num_rows($resultUsuarios);

            //Tipo de Asignación sirve para mandar parametros especificos en las funciones. 
            if ($tipoAsginacion == "asignarMC") {
                foreach ($resultUsuarios as $value) {
                    $idUsuario = $value['idUsuario'];
                    $nombre = $value['nombre'];
                    $apellido = $value['apellido'];
                    $cargo = $value['cargo'];
                    $nombreCompleto = $nombre . " " . $apellido;

                    $dataUsuarios .= "
                    <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"asignarUsuario($idUsuario, 'asignarMC', $idItem);\">
                        <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"20\" height=\"20\" alt=\"\">
                        <h1 class=\"ml-2\">$nombreCompleto</h1>
                        <p class=\"font-bold mx-1\"> / </p>
                        <h1 class=\"font-normal text-xs\">$cargo</h1>
                    </div>
                ";
                }
            }
        }
        $data['dataUsuarios'] = $dataUsuarios;
        $data['totalUsuarios'] = $totalUsuarios;
        echo json_encode($data);
    }

    if ($action == "asignarUsuario") {
        $tipoAsginacion = $_POST['tipoAsginacion'];
        $idUsuarioSeleccionado = $_POST['idUsuarioSeleccionado'];
        $idItem = $_POST['idItem'];

        if ($tipoAsginacion == "asignarMC") {
            $query = "UPDATE t_mc SET responsable = $idUsuarioSeleccionado WHERE id = $idItem";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo "MC";
            } else {
                echo "0";
            }
        }
    }


    // obtiene Adjuntos e Imagenes.
    if ($action == "obtenerAdjuntosMC") {
        // Variables AJAX.
        $idMC = $_POST['idMC'];

        // Variables Locales.
        $data = array();
        $dataImagenes = "";
        $dataAdjuntos = "";

        $queryAdjuntos = "SELECT t_mc_adjuntos.id, t_mc_adjuntos.url_adjunto, t_mc_adjuntos.fecha, t_mc_adjuntos.subido_por FROM t_mc_adjuntos 
        WHERE t_mc_adjuntos.id_mc = $idMC AND t_mc_adjuntos.activo = 1";

        if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {

            foreach ($resultAdjuntos as $value) {
                $url = $value['url_adjunto'];

                if (file_exists("../planner/tareas/adjuntos/$url")) {
                    $adjuntoURL = "planner/tareas/adjuntos/$url";
                } elseif (file_exists("../../planner/tareas/adjuntos/$url")) {
                    $adjuntoURL = "../planner/tareas/adjuntos/$url";
                } else {
                    $adjunto = "";
                }

                // Admite solo Imagenes.
                if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png")) {
                    $dataImagenes .= "
                    <a href=\"$adjuntoURL\" target=\"_blank\">
                    <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                    </div>
                    </a>
                    ";

                    // Admite todo, menos lo anterior.
                } else {

                    $dataAdjuntos .= "
                        <a href=\"$adjuntoURL\" target=\"_blank\">
                            <div class=\"w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2\">
                                <i class=\"fad fa-file-alt fa-3x\"></i>
                                <p class=\"text-sm font-normal ml-2\">$url
                                </p>
                            </div>
                        </a>                    
                    ";
                }
            }
        }
        $data['dataImagenes'] = $dataImagenes;
        $data['dataAdjuntos'] = $dataAdjuntos;
        echo json_encode($data);
    }


    // obtiene Comentarios MC.
    if ($action == "obtenerComentariosMC") {
        // Variables AJAX.
        $idMC = $_POST['idMC'];

        // Variables Locales.
        $data = array();
        $dataComentarios = "";

        $queryComentario = "SELECT t_mc_comentarios.comentario, t_mc_comentarios.fecha, 
        t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_mc_comentarios
        INNER JOIN t_users ON t_mc_comentarios.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mc_comentarios.id_mc = $idMC AND t_mc_comentarios.activo = 1
        ORDER BY t_mc_comentarios.id DESC
        ";
        if ($resultComentario = mysqli_query($conn_2020, $queryComentario)) {
            foreach ($resultComentario as $value) {
                $comentario = $value['comentario'];
                $nombre = $value['nombre'];
                $apellido = $value['apellido'];
                $nombreCompleto = $value['nombre'] . " " . $value['apellido'];
                $fecha = (new DateTime($value['fecha']))->format('d-m-Y H:m:s');

                $dataComentarios .= "
                    <div class=\"flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer\">
                        <div class=\"flex items-center justify-center\" style=\"width: 48px;\">
                            <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"48\" height=\"48\" alt=\"\">
                        </div>
                        <div class=\"flex flex-col justify-start items-start p-2 w-full\">
                            <div class=\"text-xs font-bold flex flex-row justify-between w-full\">
                                <div>
                                    <h1>$nombreCompleto</h1>
                                </div>
                                <div>
                                    <p class=\"font-mono ml-2 text-gray-600\">$fecha</p>
                                </div>
                            </div>
                            <div class=\"text-xs w-full\">
                                <p>$comentario</p>
                            </div>
                        </div>
                    </div>                
                ";
            }
        }
        $data['dataComentarios'] = $dataComentarios;
        echo json_encode($data);
    }

    // Agregar Comentario MC.
    if ($action == "agregarComentarioMC") {
        // Variables AJAX.
        $idMC = $_POST['idMC'];
        $comentarioMC = $_POST['comentarioMC'];

        $query = "INSERT INTO t_mc_comentarios(id_mc, comentario, id_usuario) VALUES($idMC, '$comentarioMC', $idUsuario)";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }
}
