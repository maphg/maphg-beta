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
    $semanaActual = date('W');
    $añoActual = date("Y");


    // FUNCION PARA NOTIFICACIONES TELEGRAM
    function notificacionProyectos($De, $Para, $id, $opcion, $titulo)
    {
        $chatId = "";
        $asignadoA = "";
        $asignadoPor = "";
        $token = "";
        $msg = "";
        $proyecto = "";

        if ($opcion == "PLANACCION") {
            $query = "SELECT titulo FROM t_proyectos WHERE id = $id";
            if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
                foreach ($result as $x) {
                    $titulo = $x['titulo'];
                }
            }
        } elseif ($opcion == "ACTUALIZADOPLANACCION") {
            $query = "SELECT t_proyectos.titulo, t_proyectos_planaccion.actividad 
            FROM t_proyectos_planaccion 
            INNER JOIN t_proyectos ON t_proyectos_planaccion.id_proyecto = t_proyectos.id
            WHERE t_proyectos_planaccion.id = $id";
            if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
                foreach ($result as $x) {
                    $proyecto = $x['titulo'];
                    $titulo = $x['actividad'];
                }
            }
        } elseif ($opcion == "ACTUALIZADOPROYECTO") {
            $query = "SELECT titulo FROM t_proyectos WHERE id = $id";
            if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
                foreach ($result as $x) {
                    $proyecto = $x['titulo'];
                }
            }
        }

        $query = "SELECT t_users.telegram_chat_id, t_colaboradores.nombre
        FROM t_users 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.id = $De";
        if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
                $asignadoPor = $x['nombre'];
            }
        }

        $query = "SELECT t_users.telegram_chat_id, t_colaboradores.nombre
        FROM t_users 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.id = $Para";
        if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
                $chatId = $x['telegram_chat_id'];
                $asignadoA = $x['nombre'];
            }
        }

        $query = "SELECT url FROM t_enlaces WHERE tipo_enlace = 'BOTMAPHG' and activo = 1";
        if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
                $token = $x['url'];
            }
        }

        if ($opcion == "ACTUALIZADOPLANACCION") {
            $msg = "Hola <strong>$asignadoA</strong>, te han asignado un PDA por <strong>$asignadoPor</strong>, <strong>\"$titulo\"</strong> en el Proyecto <strong>🚩 $proyecto</strong> 📅 " . $GLOBALS['fechaActual'];
        } else if ($opcion == "PLANACCION") {
            $msg = "Hola <strong>$asignadoA</strong>, te han asignado un PDA por <strong>$asignadoPor</strong>, <strong>\"$titulo\"</strong> en el Proyecto <strong>🚩 $proyecto</strong> 📅 " . $GLOBALS['fechaActual'];
        } else if ($opcion == "PROYECTO") {
            $msg = "Hola <strong>$asignadoA</strong>, te han asignado un Proyecto por <strong>$asignadoPor</strong>, <strong>\"$titulo\"</strong> 📅 " . $GLOBALS['fechaActual'];
        } else if ($opcion == "ACTUALIZADOPROYECTO") {
            $msg = "Hola <strong>$asignadoA</strong>, te han asignado un Proyecto por <strong>$asignadoPor</strong>, <strong>\"$proyecto\"</strong> 📅 " . $GLOBALS['fechaActual'];
        }

        $APITelegram = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId" . "&text=$msg&parse_mode=html";
        if ($token != "" and $chatId != "" and $msg != "") {
            file_get_contents($APITelegram);
        }
    }


    // Array para Secciones.
    $arraySeccion = array(11 => "ZIL", 10 => "ZIE", 24 => "AUTO", 1 => "DEC", 23 => "DEP", 19 => "OMA", 5 => "ZHA", 6 => "ZHC", 7 => "ZHH", 12 => "ZHP", 8 => "ZIA", 9 => "ZIC", 0 => "", 1001 => "Energeticos");


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
            $ZHH_Permiso = $permiso['ZHH'];
            $ZIL_Permiso = 1;
            $AUTO_Permiso = 1;
            $DEC_Permiso = 1;
            $DEP_Permiso = 1;
            //$OMA_Permiso = 1;
            $ZHA_Permiso = 1;
            $ZHC_Permiso = 1;
            $ZHP_Permiso = 1;
            $ZIA_Permiso = 1;;
            $ZIC_Permiso = 1;
            $ZIE_Permiso = 1;
            $ZHH_Permiso = 1;
            $Energeticos_Permiso = 1;
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
        WHERE t_users.id = $idUsuario AND t_users.status = 'A' LIMIT 1";

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
        $dataEnergeticos = "";
        $dataAux = "";
        // Lista para Ordenar Columnas
        $listaZIL = "";
        $listaZIE = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND id_destino = $idDestino";
        }

        if ($idDestino == 10) {
            $filtroDestinoEquipo = "";
            $filtroDestinoTG = "";
            $filtroDestinoPlanaccion = "";
        } else {
            $filtroDestinoEquipo = "and t_equipos_america.id_destino = $idDestino";
            $filtroDestinoTG = "and id_destino = $idDestino";
            $filtroDestinoPlanaccion = "and t_proyectos.id_destino = $idDestino";
        }

        // OMA
        if ($OMA_Permiso == 1) {
            if ($idDestino == 10) {
                $query = "SELECT c_subsecciones.id, c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 19";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 19)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    $dataOMA .= " 
                        <div id=\"coloma\" class=\"scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenOMA[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
                        $idSubseccionOrdenOMA[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenOMA, SORT_DESC, $idSubseccionOrdenOMA);

                    foreach ($idSubseccionOrdenOMA as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenOMA[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }

                                $dataOMA .= "
                                    <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                        class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                        onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 19 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataOMA .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(19, 200); obtenerProyectos(19, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenZIL[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
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
                                        onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 11 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataZIL .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(11, 200); obtenerProyectos(11, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenZIE[] = intval($totalTareas) + intval($totalFallas) + intval($totalTareasGenerales);
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

                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataZIE .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 10 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataZIE .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(10, 200);  toggleModalTailwind('modalProyectos'); obtenerProyectos(10, 'PENDIENTE');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataZIE = $dataZIE . $dataAux;
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenAUTO[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
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

                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataAUTO .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 24 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataAUTO .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(24, 200); obtenerProyectos(24, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataAUTO = $dataAUTO . $dataAux;
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenDEC[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
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

                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataDEC .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 1 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataDEC .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(1, 200); obtenerProyectos(1, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataDEC = $dataDEC . $dataAux;
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                    if ($idDestino == 10) {
                        $filtroDestinoDEP = "";
                    } else {
                        $filtroDestinoDEP = "and id_destino = $idDestino";
                    }

                    // Obtiene Total de Pendientes para Ordenarlos.
                    foreach ($result as $value) {
                        $idSubseccion = $value['id_subseccion'];

                        $queryTareas = "SELECT count(id) 
                        FROM t_proyectos
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion 
                        and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') $filtroDestinoDEP";
                        $totalProyectos = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalProyectos = $x['count(id)'];
                            }
                        }

                        $totalSubseccionOrdenDEP[] = intval($totalProyectos);
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

                                if ($idSubseccion == 200) {
                                    $dataAux = "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); obtenerDEP($idSubseccion);\">
                                            <h1 class=\"truncate mr-2\">$nombreSubseccion</h1>
                                            <div
                                                class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                                <h1>$totalPendiente</h1>
                                            </div>
                                        </div>
                                    ";
                                } else {
                                    $dataDEP .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); obtenerProyectosDEP($idSubseccion, 'PENDIENTE');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 23 and id_subseccion = 200 and activo = 1 and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataDEP .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(23, 200); obtenerProyectos(23, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataDEP = $dataDEP . $dataAux;
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenZHA[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
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

                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataZHA .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 5 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataZHA .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(5, 200); obtenerProyectos(5, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataZHA = $dataZHA . $dataAux;
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenZHC[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
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

                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataZHC .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 6 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataZHC .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(6, 200);  toggleModalTailwind('modalProyectos'); obtenerProyectos(6, 'PENDIENTE');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataZHC = $dataZHC . $dataAux;
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenZHP[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
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

                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataZHP .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 12 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataZHP .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(12, 200); obtenerProyectos(12, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataZHP = $dataZHP . $dataAux;
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenZIA[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
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

                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataZIA .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 8 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataZIA .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(8, 200); obtenerProyectos(8, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataZIA = $dataZIA . $dataAux;
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
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenZIC[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
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
                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataZIC .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 9 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataZIC .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(9, 200); obtenerProyectos(9, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataZIC = $dataZIC . $dataAux;
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

        // ZHH
        if ($ZHH_Permiso == 1) {
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
                FROM c_subsecciones 
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 7";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 7)";
            }

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    // ZHH
                    $dataZHH .= " 
                        <div id=\"colzhh\" class=\"hidden scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
                                <div
                                    class=\"absolute text-cyan-700 bg-cyan-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
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

                        $queryTareas = "SELECT count(t_mp_np.id) 
                        FROM t_mp_np
                        INNER JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and t_equipos_america.id_subseccion = $idSubseccion and t_equipos_america.activo = 1 and (t_mp_np.status = 'PENDIENTE' or t_mp_np.status = 'P' or t_mp_np.status = 'N') and t_mp_np.activo = 1 $filtroDestinoEquipo";
                        $totalTareas = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareas = $x['count(t_mp_np.id)'];
                            }
                        }

                        $queryTareas = "SELECT count(id) 
                        FROM t_mp_np
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and id_equipo = 0 and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $queryFallas = "SELECT count(t_mc.id) 
                        FROM t_mc
                        INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id
                        WHERE t_equipos_america.id_seccion = $idSeccion and 
                        t_equipos_america.id_subseccion = $idSubseccion and 
                        t_equipos_america.activo = 1 and
                        (t_mc.status = 'PENDIENTE' or t_mc.status = 'N' or t_mc.status = 'P') 
                        and t_mc.activo = 1 $filtroDestinoEquipo";
                        $totalFallas = 0;
                        if ($resultFallas = mysqli_query($conn_2020, $queryFallas)) {
                            foreach ($resultFallas as $x) {
                                $totalFallas = $x['count(t_mc.id)'];
                            }
                        }

                        $totalSubseccionOrdenZHH[] = intval($totalFallas) + intval($totalTareas) + intval($totalTareasGenerales);
                        $idSubseccionOrdenZHH[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenZHH, SORT_DESC, $idSubseccionOrdenZHH);

                    foreach ($idSubseccionOrdenZHH as $key => $value) {
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
                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataZHH .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                            onclick=\"obtenerEquiposAmerica($idSeccion, $idSubseccion); toggleModalTailwind('modalEquiposAmerica');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = 7 and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataZHH .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion(7, 200); obtenerProyectos(7, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataZHH = $dataZHH . $dataAux;
                    // Cierre de Columnas.
                    $dataZHH .= "
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

        // Energéticos
        if ($Energeticos_Permiso == 1) {
            if ($idDestino == 10) {
                $query = "SELECT 
                c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion
                FROM c_subsecciones
                INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                WHERE id_seccion = 1001";
            } else {
                $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, 1001)";
            }
            $data[] = $query;

            if ($result = mysqli_query($conn_2020, $query)) {
                $conn_2020->next_result();
                if ($row = mysqli_fetch_array($result)) {
                    $idSeccion = $row['id_seccion'];
                    $seccion = $row['seccion'];

                    // Energeticos
                    $dataEnergeticos .= " 
                        <div id=\"colEnergeticos\" class=\"scrollbar flex flex-col justify-center items-center w-22rem mr-4\">
                            <div
                                class=\"bg-white shadow-lg rounded-lg px-3 py-1 flex flex-col items-center justify-center w-full relative\">
                                <div
                                    class=\"absolute text-yellow-700 bg-yellow-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12\">
                                    <h1 class=\"font-medium text-md truncate\"><i class=\"fas fa-plug fa-lg\"></i></h1>
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

                        $queryTareas = "SELECT count(id) 
                        FROM t_energeticos
                        WHERE id_seccion = $idSeccion and id_subseccion = $idSubseccion and activo = 1 and (status = 'PENDIENTE' or status = 'P' or status = 'N') and activo = 1 $filtroDestinoTG";
                        $totalTareasGenerales = 0;
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            foreach ($resultTareas as $x) {
                                $totalTareasGenerales = $x['count(id)'];
                            }
                        }

                        $totalSubseccionOrdenEnergeticos[] =  intval($totalTareasGenerales);
                        $idSubseccionOrdenEnergeticos[] = $idSubseccion;
                    }
                    array_multisort($totalSubseccionOrdenEnergeticos, SORT_DESC, $idSubseccionOrdenEnergeticos);

                    foreach ($idSubseccionOrdenEnergeticos as $key => $value) {
                        $idSubseccion = $value;

                        $querySubseccion = "SELECT id, id_seccion, grupo FROM c_subsecciones 
                        WHERE id = $idSubseccion";
                        if ($resultSubseccion = mysqli_query($conn_2020, $querySubseccion)) {
                            if ($rowSubseccion = mysqli_fetch_array($resultSubseccion)) {
                                $idSubseccion = $rowSubseccion['id'];
                                $idSeccion = $rowSubseccion['id_seccion'];
                                $nombreSubseccion = $rowSubseccion['grupo'];
                                $totalPendiente = $totalSubseccionOrdenEnergeticos[$key];

                                if ($totalPendiente > 0) {
                                    $estiloSubseccion = "bg-red-400 text-red-700";
                                } else {
                                    $estiloSubseccion = "";
                                    $totalPendiente = "";
                                }
                                if ($idSubseccion == 200) {
                                    $dataAux = "
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
                                } else {
                                    $dataEnergeticos .= "
                                        <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                            class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                           onclick=\"actualizarSeccionSubseccion($idSeccion, $idSubseccion); obtenerEnergeticos($idSeccion, $idSubseccion, 'PENDIENTE'); toggleModalTailwind('modalEnergeticos');\">
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
                    }

                    // PROYECTOS
                    $queryProyectos = "SELECT count(id) FROM t_proyectos 
                    WHERE id_seccion = $idSeccion and id_subseccion = 200 and activo = 1 
                    and (status='N' or status = 'PENDIENTE') $filtroDestino ";
                    if ($resultProyectos = mysqli_query($conn_2020, $queryProyectos)) {
                        if ($row = mysqli_fetch_array($resultProyectos)) {
                            $totalProyecto = intval($row['count(id)']);

                            if ($totalProyecto > 0) {
                                $estiloSubseccion = "bg-red-400 text-red-700";
                            } else {
                                $estiloSubseccion = "";
                                $totalProyecto = "";
                            }

                            $dataEnergeticos .= "
                                <div data-target=\"modal-subseccion\" data-toggle=\"modal\"
                                    class=\"ordenarHijos$seccion p-2 w-full rounded-sm cursor-pointer hover:bg-gray-100 flex flex-row justify-between items-center\" 
                                    onclick=\"actualizarSeccionSubseccion($idSeccion, 200); obtenerProyectos($idSeccion, 'PENDIENTE'); toggleModalTailwind('modalProyectos');\">
                                    <h1 class=\"truncate mr-2\">PROYECTOS</h1>
                                    <div
                                        class=\"$estiloSubseccion text-xxs h-5 w-5 rounded-md font-bold flex flex-row justify-center items-center\">
                                        <h1>$totalProyecto</h1>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    $dataEnergeticos = $dataEnergeticos . $dataAux;
                    // Cierre de Columnas.
                    $dataEnergeticos .= "
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
        $data['dataEnergeticos'] = $dataEnergeticos;
        $data['listaZIL'] = $listaZIL;
        $data['listaZIE'] = $listaZIE;

        echo json_encode($data);
    }

    // *********************************************************************************************

    // Pendientes Por Subsecciones
    if ($action == "consultarPendientesSubsecciones") {
        // Variables recibidad de Ajax.
        $idSeccion = $_POST['idSeccion'];
        $tipoPendiente = $_POST['tipoPendiente'];

        $arrayData = array();
        $data = "";
        $resultData = "";
        $dataOpcionesSubsecciones = "";
        $exportarSubseccion = "";
        $exportarSubseccionPDF = "";
        $exportarSeccion = "";
        $exportarMisPendientes = "";

        // Contadores
        $contadorTyF = 0;
        $contadorDEP = 0;
        $contadorT = 0;
        $contadorS = 0;

        // Identifica si el filtro es en General, Usuario o Seccion.
        $filtroSeccion = "";
        $filtroUsuario = "";
        $filtroSeccionT = "";
        $filtroUsuarioT = "";

        if ($tipoPendiente == "MCU") {
            $arrayData['tipoPendienteNombre'] = "Mis Pendientes";
            $filtroUsuario = "AND t_mc.responsable = $idUsuario AND t_mc.id_seccion = $idSeccion";
            $filtroUsuarioT = "AND t_mp_np.responsable = $idUsuario AND t_equipos.id_seccion = $idSeccion";
        } elseif ($tipoPendiente == "MCU0") {
            $arrayData['tipoPendienteNombre'] = "Sin Responsable";
            $filtroUsuario = "AND (t_mc.responsable = 0 OR t_mc.responsable = '')";
            $filtroUsuarioT = "AND (t_mp_np.responsable = 0 OR t_mp_np.responsable = '')";
        } elseif ($tipoPendiente == "MCS") {
            $arrayData['tipoPendienteNombre'] = "Todos";
            $filtroSeccion = "AND t_mc.id_seccion = $idSeccion";
            $filtroSeccionT = "AND t_equipos.id_seccion = $idSeccion";
        } elseif ($tipoPendiente == "MCC") {
            $arrayData['tipoPendienteNombre'] = "Creados Por Mi";
            $filtroUsuario = "AND t_mc.creado_por = $idUsuario AND t_mc.id_seccion = $idSeccion";
            $filtroUsuarioT = "AND t_mp_np.id_usuario = $idUsuario AND t_equipos.id_seccion = $idSeccion";
        } else {
            $arrayData['tipoPendienteNombre'] = "";
            $filtroSeccion = "AND t_mc.id_seccion = 0";
            $filtroUsuario = "";
            $filtroSeccionT = "AND t_equipos.id_seccion = 0";
            $filtroUsuarioT = "";
        }

        // Query para obtener todas las subsecciones, según la sección.
        $query = "SELECT c_secciones.id 'id_seccion', c_secciones.seccion, c_subsecciones.id 'id_subseccion', c_subsecciones.grupo
        FROM c_rel_destino_seccion
        INNER JOIN c_secciones  ON c_rel_destino_seccion.id_seccion = c_secciones.id
        INNER JOIN c_rel_seccion_subseccion  ON c_rel_destino_seccion.id = c_rel_seccion_subseccion.id_rel_seccion
        INNER JOIN c_subsecciones ON c_rel_seccion_subseccion.id_subseccion = c_subsecciones.id
        WHERE c_rel_destino_seccion.id_destino = $idDestino and c_rel_destino_seccion.id_seccion = $idSeccion
        ORDER BY c_secciones.seccion ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $row) {
                $idSeccion = $row['id_seccion'];
                $seccion = $row['seccion'];
                $idSubseccion = $row['id_subseccion'];
                $subseccion = $row['grupo'];

                // Se almacenan las subsecciones para mostrarlas en el select (dataOpcionesSubsecciones).
                $misPendientesUsuario = "$idSeccion, 'MCU', '$seccion', $idUsuario, $idDestino";
                $misPendientesCreados = "$idSeccion, 'MCC', '$seccion', $idUsuario, $idDestino";
                $misPendientesSinUsuario = "$idSeccion, 'MCU0', '$seccion', $idUsuario, $idDestino";
                $misPendientesSeccion = "$idSeccion, 'MCS', '$seccion', $idUsuario, $idDestino";

                // Exportar Pendientes.
                $exportarSeccion = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarSeccion'";
                $exportarMisPendientes = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisPendientes'";
                $exportarCreadosDe = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarCreadosDe'";
                $exportarPorResponsable = "$idUsuario, $idDestino, $idSeccion, $idSubseccion, 'exportarPorResponsable'";
                $exportarMisCreados = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisCreados'";
                $exportarMisPendientesPDF = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisPendientesPDF'";
                $exportarCreadosPorPDF = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarCreadosPorPDF'";
                $exportarMisCreadosPDF = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisCreadosPDF'";

                $exportarSubseccion .= "
                    <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"exportarPendientes($idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarSubseccion');\">
                        <h1 class=\"ml-2\">$subseccion</h1>
                    </div>                
                ";

                $exportarSubseccionPDF .= "
                    <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"exportarPendientes($idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarSubseccionPDF');\">
                        <h1 class=\"ml-2\">$subseccion</h1>
                    </div>                
                ";
            }

            $arrayData['misPendientesUsuario'] = $misPendientesUsuario;
            $arrayData['misPendientesCreados'] = $misPendientesCreados;
            $arrayData['misPendientesSinUsuario'] = $misPendientesSinUsuario;
            $arrayData['misPendientesSeccion'] = $misPendientesSeccion;

            $arrayData['exportarSubseccion'] = $exportarSubseccion;
            $arrayData['exportarSeccion'] = $exportarSeccion;
            $arrayData['exportarMisPendientes'] = $exportarMisPendientes;
            $arrayData['exportarCreadosDe'] = $exportarCreadosDe;
            $arrayData['exportarPorResponsable'] = $exportarPorResponsable;
            $arrayData['exportarMisCreados'] = $exportarMisCreados;
            $arrayData['exportarCreadosPorPDF'] = $exportarCreadosPorPDF;
            $arrayData['exportarMisCreadosPDF'] = $exportarMisCreadosPDF;
            $arrayData['exportarMisPendientesPDF'] = $exportarMisPendientesPDF;
            $arrayData['exportarSubseccionPDF'] = $exportarSubseccionPDF;
        }
        echo json_encode($arrayData);
    }

    // Pendientes Por Subsecciones
    if ($action == "consultarPendientesSubseccionesOriginal") {
        // Variables recibidad de Ajax.
        $idSeccion = $_POST['idSeccion'];
        $tipoPendiente = $_POST['tipoPendiente'];

        $arrayData = array();
        $data = "";
        $resultData = "";
        $dataOpcionesSubsecciones = "";
        $exportarSubseccion = "";
        $exportarSubseccionPDF = "";
        $exportarSeccion = "";
        $exportarMisPendientes = "";

        // Contadores
        $contadorTyF = 0;
        $contadorDEP = 0;
        $contadorT = 0;
        $contadorS = 0;

        // Identifica si el filtro es en General, Usuario o Seccion.
        $filtroSeccion = "";
        $filtroUsuario = "";
        $filtroSeccionT = "";
        $filtroUsuarioT = "";

        if ($tipoPendiente == "MCU") {
            $arrayData['tipoPendienteNombre'] = "Mis Pendientes";
            $filtroUsuario = "AND t_mc.responsable = $idUsuario AND t_mc.id_seccion = $idSeccion";
            $filtroUsuarioT = "AND t_mp_np.responsable = $idUsuario AND t_equipos.id_seccion = $idSeccion";
        } elseif ($tipoPendiente == "MCU0") {
            $arrayData['tipoPendienteNombre'] = "Sin Responsable";
            $filtroUsuario = "AND (t_mc.responsable = 0 OR t_mc.responsable = '')";
            $filtroUsuarioT = "AND (t_mp_np.responsable = 0 OR t_mp_np.responsable = '')";
        } elseif ($tipoPendiente == "MCS") {
            $arrayData['tipoPendienteNombre'] = "Todos";
            $filtroSeccion = "AND t_mc.id_seccion = $idSeccion";
            $filtroSeccionT = "AND t_equipos.id_seccion = $idSeccion";
        } elseif ($tipoPendiente == "MCC") {
            $arrayData['tipoPendienteNombre'] = "Creados Por Mi";
            $filtroUsuario = "AND t_mc.creado_por = $idUsuario AND t_mc.id_seccion = $idSeccion";
            $filtroUsuarioT = "AND t_mp_np.id_usuario = $idUsuario AND t_equipos.id_seccion = $idSeccion";
        } else {
            $arrayData['tipoPendienteNombre'] = "";
            $filtroSeccion = "AND t_mc.id_seccion = 0";
            $filtroUsuario = "";
            $filtroSeccionT = "AND t_equipos.id_seccion = 0";
            $filtroUsuarioT = "";
        }


        if ($idDestino == 10) {
            $filtroDestinoMC = "";
            $filtroDestinoTareas = "";
        } else {
            $filtroDestinoMC = "AND t_mc.id_destino = $idDestino";
            $filtroDestinoTareas = "AND t_mp_np.id_destino = $idDestino";
        }

        // Query para obtener todas las subsecciones, según la sección.
        if ($idDestino == 10) {
            $query = "SELECT c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, 
            c_secciones.seccion  
            FROM c_subsecciones 
            INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
            WHERE c_subsecciones.id_seccion = $idSeccion";
        } else {
            $query = "CALL obtenerSubseccionesDestinoSeccion($idDestino, $idSeccion)";
        }

        if ($result = mysqli_query($conn_2020, $query)) {
            $conn_2020->next_result();
            foreach ($result as $row) {
                $data = "";
                $subseccion = $row['grupo'];
                $idSubseccion = $row['id_subseccion'];
                $nombreSeccion = $row['seccion'];
                $nombreSubseccion = $row['grupo'];

                // Se almacenan las subsecciones para mostrarlas en el select (dataOpcionesSubsecciones).
                $misPendientesUsuario = "$idSeccion, 'MCU', '$nombreSeccion', $idUsuario, $idDestino";
                $misPendientesCreados = "$idSeccion, 'MCC', '$nombreSeccion', $idUsuario, $idDestino";
                $misPendientesSinUsuario = "$idSeccion, 'MCU0', '$nombreSeccion', $idUsuario, $idDestino";
                $misPendientesSeccion = "$idSeccion, 'MCS', '$nombreSeccion', $idUsuario, $idDestino";

                // Exportar Pendientes.
                $exportarSeccion = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarSeccion'";
                $exportarMisPendientes = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisPendientes'";
                $exportarCreadosDe = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarCreadosDe'";
                $exportarPorResponsable = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarPorResponsable'";
                $exportarMisCreados = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisCreados'";
                $exportarMisPendientesPDF = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisPendientesPDF'";
                $exportarCreadosPorPDF = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarCreadosPorPDF'";
                $exportarMisCreadosPDF = "$idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarMisCreadosPDF'";

                $exportarSubseccion .= "
                    <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"exportarPendientes($idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarSubseccion');\">
                        <h1 class=\"ml-2\">$nombreSubseccion</h1>
                    </div>                
                ";

                $exportarSubseccionPDF .= "
                    <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"exportarPendientes($idUsuario, $idDestino,$idSeccion, $idSubseccion, 'exportarSubseccionPDF');\">
                        <h1 class=\"ml-2\">$nombreSubseccion</h1>
                    </div>                
                ";


                $estiloSeccion = $nombreSeccion;

                $dataOpcionesSubsecciones .= "
                    <div class=\"py-1 px-2 w-full hover:bg-gray-700\" onchange=\"toggleInivisble($idSubseccion);\">
                        <div class=\"py-1 px-2 w-full hover:bg-gray-700\"></div>
                        <label class=\"md:w-2/3 block text-gray-500 font-bold\">
                            <input class=\"leading-tight\" type=\"checkbox\" checked>
                            <span class=\"\">
                                $subseccion
                            </span>
                        </label>
                    </div>";

                // Columna de Subsecciones
                $data .= "
                    <tr id=\"$idSubseccion\" class=\"hover:shadow-md cursor-pointer\">
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
                AND (t_mc.status = 'N' or t_mc.status = 'PENDIENTE') AND t_mc.activo = 1 $filtroUsuario $filtroSeccion $filtroDestinoMC
                ORDER BY t_mc.id DESC";

                if ($resultMCP = mysqli_query($conn_2020, $queryMCP)) {
                    foreach ($resultMCP as $pendiente) {
                        $contadorTyF++;

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
                            class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative\">
                            <!-- Titulo -->
                            <div class=\"absolute right-0 top-0 w-4 h-4 absolute bg-red-200 text-red-700 rounded-full text-xxs font-bold flex items-center justify-center\">
                                <h1>F</h1>
                            </div>
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
                                    class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\" onclick=\"verEnPlanner('FALLA', $idMC);\">
                                    <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver más
                                </button>
                            </div>
                        </div>
                    ";
                    }
                }

                $queryTareas = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.fecha_finalizado, t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_mp_np
                INNER JOIN t_users ON t_mp_np.responsable = t_users.id 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                LEFT JOIN t_equipos_america ON t_mp_np.id_equipo = t_equipos_america.id
                WHERE t_mp_np.id_seccion = $idSeccion and t_mp_np.id_subseccion = $idSubseccion AND t_mp_np.activo = 1 AND (t_mp_np.status= 'N' OR t_mp_np.status= 'P') $filtroUsuarioT $filtroDestinoTareas";
                if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                    foreach ($resultTareas as $value) {
                        $contadorTyF++;
                        $tarea = "";
                        $idTarea = $value['id'];
                        $tarea = $value['titulo'];
                        $nombreCompleto_T = strtok($value['nombre'], ' ') . " " . strtok($value['apellido'], ' ');

                        if ($nombreCompleto_T != "" and $nombreCompleto_T != "Sin Responsable") {
                            $estiloResponsableT = "text-gray-600";
                            $avatarResponsableT = "https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombreCompleto_T";
                        } else {
                            $estiloResponsableT = "text-red-600";
                            $avatarResponsableT = "";
                        }

                        $queryComentarioT = "SELECT count(comentarios_mp_np.id), comentarios_mp_np.comentario, comentarios_mp_np.fecha,
                        t_colaboradores.nombre, t_colaboradores.apellido  
                        FROM comentarios_mp_np
                        INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id 
                        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                        WHERE comentarios_mp_np.activo = 1 AND comentarios_mp_np.id_mp_np = $idTarea";
                        if ($resultComentarioT = mysqli_query($conn_2020, $queryComentarioT)) {
                            foreach ($resultComentarioT as $value) {
                                $comentarioT = $value['comentario'];
                                $nombreCompletoT = $value['nombre'] . " " . $value['apellido'];
                                $fechaComentarioT = $value['fecha'];

                                if ($fechaComentarioT != "") {
                                    $fechaComentarioT = (new DateTime($fechaComentarioT))->format('d-m-y');
                                } else {
                                    $fechaComentarioT = "";
                                }

                                if ($comentarioT != "") {
                                    $iconoComentarioT = " <i class=\"fas fa-comment-dots\"></i>";
                                    $avatarComentarioT = "https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombreCompletoT";
                                } else {
                                    $iconoComentarioT = "";
                                    $avatarComentarioT = "";
                                }
                            }
                        } else {
                            $iconoComentarioT = "";
                            $avatarComentarioT = "";
                        }

                        $queryAdjuntosT = "SELECT count(id) FROM adjuntos_mp_np WHERE id_mp_np = $idTarea";
                        if ($resultAdjuntoT = mysqli_query($conn_2020, $queryAdjuntosT)) {
                            foreach ($resultAdjuntoT as $value) {
                                $totalAdjuntosT = $value['count(id)'];
                                if ($totalAdjuntosT > 0) {
                                    $iconoAdjuntoT = " <i class=\"fas fa-paperclip mx-2\"></i> ";
                                } else {
                                    $iconoAdjuntoT = "";
                                }
                            }
                        }

                        if ($tarea != "") {
                            $data .= "
                        <div id=\"" . $idTarea . "P\" onclick=\"expandir(this.id)\"
                            class=\"flex flex-col w-full my-2 px-3 py-1 rounded-md cursor-pointer bg-gray-200 text-gray-800 text-left font-medium hover:shadow-md relative\">
                            <!-- Titulo -->
                            <div class=\"absolute right-0 top-0 w-4 h-4 absolute bg-purple-200 text-purple-700 rounded-full text-xxs font-bold flex items-center justify-center\">
                            <h1>T</h1>
                            </div>
                            <div class=\"my-1\">
                                <p id=\"" . $idTarea . "Ptitulo\" class=\"truncate\">$tarea</p>
                            </div>
                            <!-- Iconos -->
                            <div class=\"flex flex-row justify-between items-center text-sm\">
                                <div class=\"flex flex-row\">
                                    <img src=\"$avatarResponsableT\"
                                        width=\"20\" height=\"20\" alt=\"\">
                                    <p class=\"text-xs font-bold ml-1 $estiloResponsableT\">$nombreCompleto_T</p>
                                </div>
                                <div class=\"text-gray-600\">
                                $iconoComentarioT
                                $iconoAdjuntoT
                                </div>
                            </div>
                            <!-- Toogle -->
                            <div id=\"" . $idTarea . "Ptoggle\" class=\"hidden mt-2\">
                                <div
                                    class=\"flex flex-col flex-wrap text-justify p-2 bg-white rounded-md font-normal\">
                                    <h1 class=\"text-left font-bold text-left mb-1\">Último comentario:</h1>
                                    <p class=\"uppercase\">$comentarioT</p>
                                    <div class=\"flex flex-row mt-1 self-center\">
                                        <img src=\"$avatarComentarioT\"
                                            width=\"20\" height=\"20\" alt=\"\">
                                        <p class=\"text-xs font-bold ml-1 text-gray-600\">$nombreCompletoT</p>
                                        <p class=\"text-xs font-bold ml-6 text-gray-600\">$fechaComentarioT</p>
                                    </div>
                                </div>
                                <button
                                    class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\" onclick=\"verEnPlanner('TAREA', $idTarea);\">
                                    <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver más
                                </button>
                            </div>
                        </div>
                    ";
                        }
                    }
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
                AND t_mc.status = 'N' AND t_mc.activo = 1 
                AND(t_mc.departamento_calidad != '' OR t_mc.departamento_compras != '' OR t_mc.departamento_direccion != '' OR t_mc.departamento_finanzas != '' OR t_mc.departamento_rrhh != '') 
                $filtroUsuario $filtroSeccion $filtroDestinoMC
                ORDER BY t_mc.id DESC";
                if ($resultDEP = mysqli_query($conn_2020, $queryDEP)) {
                    foreach ($resultDEP as $dep) {
                        $contadorDEP++;
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
                                    class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\" onclick=\"verEnPlanner('FALLA', $idMC)\">
                                    <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver más
                                </button>
                            </div>
                        </div>
                    ";
                    }
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
                AND t_mc.status = 'N' AND t_mc.activo = 1 AND t_mc.status_trabajare !='' $filtroUsuario $filtroSeccion $filtroDestinoMC
                ORDER BY t_mc.id DESC";
                if ($resultT = mysqli_query($conn_2020, $queryT)) {

                    foreach ($resultT as $t) {
                        $contadorT++;
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
                                    class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\" onclick=\"verEnPlanner('FALLA', $idMC)\">
                                    <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver más
                                </button>
                            </div>
                        </div>
                    ";
                    }
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
                AND t_mc.status = 'F' AND t_mc.activo = 1 $filtroUsuario $filtroSeccion $filtroDestinoMC
                ORDER BY t_mc.id DESC";
                if ($resultT = mysqli_query($conn_2020, $queryT)) {
                    foreach ($resultT as $t) {
                        $contadorS++;
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
                                    class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\" onclick=\"verEnPlanner('FALLA', $idMC)\">
                                    <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver más
                                </button>
                            </div>
                        </div>
                    ";
                    }
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
            $arrayData['misPendientesCreados'] = $misPendientesCreados;
            $arrayData['misPendientesSinUsuario'] = $misPendientesSinUsuario;
            $arrayData['misPendientesSeccion'] = $misPendientesSeccion;
            $arrayData['estiloSeccion'] = $estiloSeccion;

            $arrayData['exportarSubseccion'] = $exportarSubseccion;
            $arrayData['exportarSeccion'] = $exportarSeccion;
            $arrayData['exportarMisPendientes'] = $exportarMisPendientes;
            $arrayData['exportarCreadosDe'] = $exportarCreadosDe;
            $arrayData['exportarPorResponsable'] = $exportarPorResponsable;
            $arrayData['exportarMisCreados'] = $exportarMisCreados;
            $arrayData['exportarCreadosPorPDF'] = $exportarCreadosPorPDF;
            $arrayData['exportarMisCreadosPDF'] = $exportarMisCreadosPDF;
            $arrayData['exportarMisPendientesPDF'] = $exportarMisPendientesPDF;
            $arrayData['exportarSubseccionPDF'] = $exportarSubseccionPDF;

            // Resultado Contadores
            $arrayData['contadorTyF'] = $contadorTyF;
            $arrayData['contadorDEP'] = $contadorDEP;
            $arrayData['contadorT'] = $contadorT;
            $arrayData['contadorS'] = $contadorS;
        }
        echo json_encode($arrayData);
    }


    if ($action == "exportarPorUsuario") {
        $data = "";
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $tipoExportar = $_POST['tipoExportar'];
        $palabraUsuario = $_POST['palabraUsuario'];

        if ($idDestino == 10 || $idDestinoUsuarioPermiso == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND(t_users.id_destino = $idDestino OR t_users.id_destino = 10)";
        }

        if ($palabraUsuario == "") {
            $filtroPalabraEquipo = "";
        } else {
            $filtroPalabraEquipo = "and (t_colaboradores.nombre LIKE '%$palabraUsuario%' OR t_colaboradores.apellido  LIKE '%$palabraUsuario%')";
        }

        $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido 
        FROM t_users 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.status = 'A' $filtroDestino $filtroPalabraEquipo ORDER BY t_colaboradores.nombre ASC";

        if ($resultUsuario = mysqli_query($conn_2020, $query)) {
            foreach ($resultUsuario as $row) {
                $idUsuarioExport = $row['id'];
                $nombre = $row['nombre'];
                $apellido = $row['apellido'];

                $data .= "
                    <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                    onclick=\"exportarPendientes($idUsuarioExport, $idDestino, $idSeccion, 0, '$tipoExportar');\">
                        <h1 class=\"ml-2\">$nombre $apellido</h1>
                    </div>                
                ";
            }
        }
        echo $data;
    }


    if ($action == "consultaFinalExcel") {
        $data = array();
        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $tipoExportar = $_POST['tipoExportar'];
        $listaIdF = "";
        $listaIdT = "";

        if ($idDestino == 10) {
            $filtroDestinoF = "";
            $filtroDestinoT = "";
        } else {
            $filtroDestinoF = "AND id_destino = $idDestino";
            $filtroDestinoT = "AND t_mp_np.id_destino = $idDestino";
        }

        // Filtros para Generar Reporte Fallas.
        if ($tipoExportar == "exportarMisPendientes") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND responsable = $idUsuario";
            $filtroTipoT = "AND id_seccion = $idSeccion AND t_mp_np.responsable = $idUsuario";
        } elseif ($tipoExportar == "exportarSeccion") {
            $filtroTipoF = "AND id_seccion = $idSeccion";
            $filtroTipoT = "AND id_seccion = $idSeccion";
        } elseif ($tipoExportar == "exportarSubseccion") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion";
            $filtroTipoT = "AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion";
        } elseif ($tipoExportar == "exportarPorResponsable") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND responsable = $idUsuario";
            $filtroTipoT = "AND id_seccion = $idSeccion AND t_mp_np.responsable = $idUsuario";
        } elseif ($tipoExportar == "exportarMisCreadosPDF") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND responsable = $idUsuario";
            $filtroTipoT = "AND id_seccion = $idSeccion AND t_mp_np.id_usuario = $idUsuario";
        } elseif ($tipoExportar == "exportarMisPendientesPDF") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND responsable = $idUsuario";
            $filtroTipoT = "AND id_seccion = $idSeccion AND t_mp_np.responsable = $idUsuario";
        } elseif ($tipoExportar == "exportarCreadosPorPDF") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND responsable = $idUsuario";
            $filtroTipoT = "AND id_seccion = $idSeccion AND t_mp_np.responsable = $idUsuario";
        } elseif ($tipoExportar == "exportarMisCreados") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND creado_por = $idUsuario";
            $filtroTipoT = "AND id_seccion = $idSeccion AND t_mp_np.id_usuario = $idUsuario";
        } elseif ($tipoExportar == "exportarCreadosDe") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND creado_por = $idUsuario";
            $filtroTipoT = "AND id_seccion = $idSeccion AND t_mp_np.id_usuario = $idUsuario";
        } elseif ($tipoExportar == "exportarSubseccionPDF") {
            $filtroTipoF = "AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion";
            $filtroTipoT = "AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion";
        } else {
            $filtroTipoF = "activo = 29";
            $filtroTipoT = "t_mp_np.activo = 29";
        }

        // Genera lista ID de Fallas.
        $query = "SELECT id FROM t_mc WHERE activo = 1 and status IN('N', 'PENDIENTE', 'P') $filtroTipoF $filtroDestinoF";
        $data["query1"] = $query;
        if ($result = mysqli_query($conn_2020, $query)) {
            $totalResultados = mysqli_num_rows($result);
            $contador = 0;
            foreach ($result as $row) {
                $contador++;
                $id = $row['id'];

                if ($contador < $totalResultados) {
                    $listaIdF .= $id . ",";
                } else {
                    $listaIdF .= $id;
                }
            }
            $data['listaIdF'] = $listaIdF;
        }

        // Genera lista ID Tareas
        $queryT = "SELECT t_mp_np.id FROM t_mp_np 
        WHERE t_mp_np.activo = 1 AND t_mp_np.status IN('N', 'P', 'PENDIENTE') 
        $filtroTipoT $filtroDestinoT";
        $data["query2"] = $queryT;
        if ($resultT = mysqli_query($conn_2020, $queryT)) {
            $contador = 0;
            foreach ($resultT as $value) {
                $contador++;
                $idT = $value['id'];
                if ($contador >= 2) {
                    $listaIdT .= "," . $idT;
                } else {
                    $listaIdT .= $idT;
                }
            }
            $data['listaIdT'] = $listaIdT;
        }
        echo json_encode($data);
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

        // Tareas Generales SOLUCIONADO
        $queryTGF = "SELECT id FROM t_mp_np WHERE activo = 1 and (status='SOLUCIONADO' or status = 'F') and 
        id_seccion = $idSeccion and id_subseccion = $idSubseccion 
        and (t_mp_np.id_equipo = 0 OR t_mp_np.id_equipo = '') $filtroDestino";
        if ($resultTGF = mysqli_query($conn_2020, $queryTGF)) {
            $totalTGF = mysqli_num_rows($resultTGF);
        }

        // Tareas Generales PENDIENTE
        $queryTGN = "SELECT id FROM t_mp_np WHERE activo = 1 and 
        (status = 'N' or status='PENDIENTE' or status='P') and id_subseccion = $idSubseccion and id_seccion = $idSeccion 
        and (t_mp_np.id_equipo = 0 OR t_mp_np.id_equipo = '') $filtroDestino";
        if ($resultTGN = mysqli_query($conn_2020, $queryTGN)) {
            $totalTGN = mysqli_num_rows($resultTGN);
        }

        $dataTG = "
            <div class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer self-start\" style=\"display:flex;\">
                <div class=\"w-2/6 h-full flex flex-row items-center justify-between bg-red-100 text-red-500 rounded-l-md cursor-pointer hover:shadow-md\">
                    <div class=\" flex flex-row items-center truncate\">
                        <i class=\"fad fa-dot-circle mx-2\"></i>
                        <h1>TAREAS GENERALES DEL ÁREA</h1>
                    </div>
                </div>
                <div class=\"w-16 flex h-full items-center justify-center relative\">
                </div>
                <div class=\"w-16 flex h-full items-center justify-center relative\">
                </div>
                <!-- MC PENDIENTES -->
                <div onclick=\"obtenerTareas(0); toggleModalTailwind('modalTareasFallas');\" class=\"w-16 h-full flex items-center justify-center bg-red-200 text-red-400 hover:shadow-md\">
                    <h1>$totalTGN</h1>
                </div>
                <!-- MC SOLUCIONADOS -->
                <div onclick=\"obtenerTareas(0); toggleModalTailwind('modalTareasFallas');\" class=\"w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md rounded-r\">
                    <h1>$totalTGF</h1>
                </div>
                <div class=\"w-16 flex h-full items-center justify-center relative\">
                </div>
                <div class=\"w-24 flex h-full items-center justify-center relative\">
                </div>
                <div class=\"w-16 flex h-full items-center justify-center relative\">
                </div>
                <div class=\"w-24 flex h-full items-center justify-center relative\">
                </div>
                <div class=\"w-16 flex h-full items-center justify-center relative\">
                </div>
                <div class=\"w-16 flex h-full items-center justify-center relative\">
                </div>
                <div class=\"w-16 flex h-full items-center justify-center relative\">
                </div>
                <div class=\"w-16 flex h-full items-center justify-center relative\">
                </div>
            </div>
        ";

        // Busca Equipos.
        $queryEquipos = "SELECT id FROM t_equipos_america WHERE id_subseccion = $idSubseccion AND (status = 'A' or status = 'OPERATIVO') $filtroPalabraEquipo $filtroDestino 
        ORDER BY id DESC";
        if ($resultEquipos = mysqli_query($conn_2020, $queryEquipos)) {
            $totalEquipos = mysqli_num_rows($resultEquipos);

            // Filtro para el tipo de Ordenamientos de los Equipos en la seccion de las Columnas.
            if ($tipoOrdenamiento == 'MCF') {
                foreach ($resultEquipos as $equipo) {
                    $idEquipo = $equipo['id'];
                    $ordenIdEquipos[] = intval($idEquipo);

                    $queryMC = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo AND status = 'F' AND activo = 1";

                    if ($resultMC = mysqli_query($conn_2020, $queryMC)) {
                        if ($MC = mysqli_fetch_array($resultMC)) {
                            // Valor MC Obtenidos.
                            $totalMC = $MC['count(id)'];
                            $ordenMCEquipos[] = intval($totalMC);
                        }
                    }
                }
                array_multisort($ordenMCEquipos, SORT_DESC, $ordenIdEquipos);
            } elseif ($tipoOrdenamiento == 'MCN') {
                foreach ($resultEquipos as $equipo) {
                    $idEquipo = $equipo['id'];
                    $ordenIdEquipos[] = intval($idEquipo);

                    $queryMC = "SELECT count(id) FROM t_mc WHERE id_equipo = $idEquipo AND status = 'N' AND activo = 1";

                    if ($resultMC = mysqli_query($conn_2020, $queryMC)) {
                        if ($MC = mysqli_fetch_array($resultMC)) {
                            // Valor MC Obtenidos.
                            $totalMC = $MC['count(id)'];
                            $ordenMCEquipos[] = intval($totalMC);
                        }
                    }
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
                $queryEquipos = "SELECT id, equipo FROM t_equipos_america WHERE id = $idEquipo";
                if ($resultEquipos = mysqli_query($conn_2020, $queryEquipos)) {
                    if ($rowEquipo = mysqli_fetch_array($resultEquipos)) {
                        // Variables Globales para los equipos.
                        $nombreEquipo = $rowEquipo['equipo'];
                        $idEquipo = $rowEquipo['id'];

                        //FALLAS PENDIENTES 
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

                        //FALLAS SOLUCIONADAS. 
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

                        //TAREAS PENDIENTES. 
                        $queryTareas = "SELECT count(id) FROM t_mp_np 
                        WHERE id_equipo = $idEquipo and id_seccion = $idSeccion and id_subseccion = $idSubseccion and (status ='F' or status = 'PENDIENTE') and activo = 1";
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            if ($row = mysqli_fetch_array($resultTareas)) {
                                $totalTareasF = $row['count(id)'];
                                if ($totalTareasF > 0) {
                                    $estiloTareasF = "bg-green-200 text-green-400";
                                } else {
                                    $totalTareasF = "";
                                    $estiloTareasF = "bg-white text-white-400";
                                }
                            }
                        }

                        //TAREAS SOLUCIONADAS 
                        $queryTareas = "SELECT count(id) FROM t_mp_np 
                        WHERE id_equipo = $idEquipo and id_seccion = $idSeccion and id_subseccion = $idSubseccion and (status ='N' or status ='SOLUCIONADO' or status = 'P' or status = '') and activo = 1";
                        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
                            if ($row = mysqli_fetch_array($resultTareas)) {
                                $totalTareasP = $row['count(id)'];
                                if ($totalTareasP > 0) {
                                    $estiloTareasP = "bg-red-200 text-red-400";
                                } else {
                                    $totalTareasP = "";
                                    $estiloTareasP = "bg-white text-white-400";
                                }
                            }
                        }

                        //MP PLANIFICADOS PROCESO. 
                        $queryMPN = "SELECT COUNT(id) FROM t_mp_planificacion_iniciada 
                        WHERE id_equipo = $idEquipo AND status = 'PROCESO' AND activo = 1";
                        if ($resultMPN = mysqli_query($conn_2020, $queryMPN)) {
                            if ($rowMPN = mysqli_fetch_array($resultMPN)) {
                                $totalMPN = $rowMPN['COUNT(id)'];
                            } else {
                                $totalMPN = "0";
                            }
                        }

                        //MP PLANIFICADOS SOLUCIONADO. 
                        $queryMPN = "SELECT COUNT(id) FROM t_mp_planificacion_iniciada 
                        WHERE id_equipo = $idEquipo AND status = 'SOLUCIONADO' AND activo = 1";
                        if ($resultMPN = mysqli_query($conn_2020, $queryMPN)) {
                            if ($rowMPF = mysqli_fetch_array($resultMPN)) {
                                $totalMPF = $rowMPF['COUNT(id)'];
                            } else {
                                $totalMPF = "0";
                            }
                        }

                        //MP PLANIFICADOS FECHA ULTIMO. 
                        $queryMPFecha = "SELECT fecha_creacion FROM t_mp_planificacion_iniciada 
                        WHERE id_equipo = $idEquipo AND status ='SOLUCIONADO' AND activo = 1 ORDER BY id ASC LIMIT 1";
                        if ($resultMPFecha = mysqli_query($conn_2020, $queryMPFecha)) {
                            if ($rowMPFecha = mysqli_fetch_array($resultMPFecha)) {
                                $fechaMPFecha = $rowMPFecha['fecha_creacion'];

                                if ($fechaMPFecha == "") {
                                    $fechaMPFecha = "NA";
                                } else {
                                    $fechaMPFecha = (new DateTime($fechaMPFecha))->format('d-m-Y');
                                }
                            } else {
                                $fechaMPFecha = "NA";
                            }
                        }

                        // Nombre de Equipo.
                        $dataEquipos .= "
                                <div class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\" style=\"display:flex;\">
                                    <div id=\"" . $idEquipo . "E\" onclick=\"expandir(this.id)\" class=\"w-2/6 h-full flex flex-row items-center justify-between bg-blue-100 text-blue-500 rounded-l-md cursor-pointer hover:shadow-md truncate relative\">
                                        <div class=\" flex flex-row items-center w-full\">
                                            <i class=\"fas fa-cog mx-2\"></i>
                                            <div class=\"mx-2 absolute right-0 mr-2\">
                                                <i class=\"fas fa-chevron-down\"></i>
                                            </div>
                                            <h1 class=\"truncate mr-6\">$nombreEquipo</h1>
                                        </div>
                                    </div>
                            ";

                        //Fallas Pendientes N. 
                        $dataEquipos .= "       
                                <div onclick=\"obtenerFallas($idEquipo); toggleModalTailwind('modalTareasFallas');\" class=\"w-16 h-full flex items-center justify-center $estiloMCN hover:shadow-md\">
                                    <h1>$totalMCN</h1>
                                </div>
                            ";

                        //Fallas Solucionados F 
                        $dataEquipos .= "
                                <div onclick=\"obtenerFallas($idEquipo); toggleModalTailwind('modalTareasFallas');\" class=\"w-16 flex h-full items-center justify-center $estiloMCF hover:shadow-md\">
                                    <h1>$totalMCF</h1>
                                </div>
                            ";

                        // Tareas P
                        $dataEquipos .= "
                                <div onclick=\"obtenerTareas($idEquipo); toggleModalTailwind('modalTareasFallas');\" class=\"w-16 flex h-full items-center justify-center hover:shadow-md $estiloTareasP\">
                                    <h1>$totalTareasP</h1>
                                </div>
                            ";

                        // Tareas F
                        $dataEquipos .= "
                                <div onclick=\"obtenerTareas($idEquipo); toggleModalTailwind('modalTareasFallas');\" class=\"w-16 flex h-full items-center justify-center hover:shadow-md $estiloTareasF\">
                                    <h1>$totalTareasF</h1>
                                </div>
                            ";

                        // MP Planificados
                        $dataEquipos .= "
                                <div class=\"w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md\" onclick=\"\">
                                    <h1>$totalMPN</h1>
                                </div>
                            ";

                        // MP Finalizados
                        $dataEquipos .= "
                                <div class=\"w-16 flex h-full items-center justify-center bg-green-200 text-green-500 hover:shadow-md\">
                                    <h1>$totalMPF</h1>
                                </div>
                            ";

                        // MP Ultimo
                        $dataEquipos .= "
                                <div class=\"w-24 flex h-full items-center justify-center hover:shadow-md\">
                                    <h1 class=\"font-xs\">$fechaMPFecha</h1>
                                </div>
                            ";

                        // Test Equipo
                        $dataEquipos .= "
                                <div class=\"w-16 flex h-full items-center justify-center bg-indigo-200 text-indigo-500 hover:shadow-md\">
                                    <h1>0</h1>
                                </div>
                            ";

                        // Ultimo TEST Equipo
                        $dataEquipos .= "
                                <div class=\"w-24 flex h-full items-center justify-center hover:shadow-md\">
                                    <h1 class=\"font-xs\"></h1>
                                </div>
                            ";

                        // Cotizaciones Equipos
                        $dataEquipos .= "
                                <div class=\"w-16 flex h-full items-center justify-center bg-blue-200 text-blue-500 hover:shadow-md\">
                                    <h1>0</h1>
                                </div>
                            ";

                        // Info Equipos
                        $dataEquipos .= "
                                <div class=\"w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 hover:shadow-md\" onclick=\"informacionEquipo($idEquipo);\">
                                    <h1><i class=\"fas fa-eye fa-lg\"></i></h1>
                                </div>
                            ";

                        // Fotos Equipos
                        $dataEquipos .= "
                                <div class=\"w-16 flex h-full items-center justify-center hover:bg-teal-200 hover:text-teal-500 rounded-r-md hover:shadow-md\" 
                                onclick=\"obtenerMediaEquipo($idEquipo)\">
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
            $data['dataEquipos'] = $dataTG . $dataEquipos;
            $data['opcionBuscarEquipo'] = $opcionBuscarEquipo;
            $data['totalEquipos'] = $totalEquipos;
            $data['seccionEquipos'] = $seccionEquipos;
            $data['paginacionEquipos'] = $paginacionEquipos;
            unset($ordenMCEquipos, $ordenIdEquipos);
        }
        echo json_encode($data);
    }


    // Obtiene Datos para Crear un MC.
    if ($action == "obtenerDatosAgregarMC") {
        $data = array();
        $dataUsuarios = "";
        $idEquipo = $_POST['idEquipo'];

        if ($idEquipo == 0) {
            $data['nombreEquipo'] = "Tarea General";
        } else {
            $query = "SELECT equipo FROM t_equipos_america WHERE id = $idEquipo";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $nombreEquipo = $value['equipo'];
                }
                $data['nombreEquipo'] = $nombreEquipo;
            }
        }

        $query = "SELECT max(id) FROM t_mc";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idUltimoMC = $value['max(id)'];
            }
            $data['idUltimoMC'] = $idUltimoMC;
        }

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND (t_users.id_destino = 10 OR t_users.id_destino = $idDestino)";
        }
        $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.status = 'A' AND t_users.id != 0 $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idUser = $value['id'];
                $nombre = $value['nombre'];
                $apellido = $value['apellido'];

                $dataUsuarios .= "<option value=\"$idUser\">$nombre $apellido</option>";
            }
            $data['dataUsuarios'] = $dataUsuarios;
        }
        echo json_encode($data);
    }


    // Agregar MC.
    if ($action == "agregarMC") {
        $actividadMC = $_POST['actividadMC'];
        $idMC = $_POST['idMC'];
        $idEquipo = $_POST['idEquipo'];
        $responsableMC = $_POST['responsableMC'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $rangoFechaMC = $_POST['rangoFechaMC'];

        $query = "INSERT INTO t_mc(id, id_equipo, actividad, status, creado_por, responsable, fecha_creacion, ultima_modificacion, id_destino, id_seccion, id_subseccion, rango_fecha) 
        VALUES($idMC, $idEquipo, '$actividadMC', 'N', $idUsuario, $responsableMC, '$fechaActual', '$fechaActual', $idDestino, $idSeccion, $idSubseccion, '$rangoFechaMC')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    // Se obtienes los MC Finalizados por Equipo.
    if ($action == "obtenerMCF") {
        $idEquipo = $_POST['idEquipo'];
        $idSubseccion = $_POST['idSubseccion'];
        $data = array();
        $dataMCF = "";

        if ($idEquipo == 0) {
            // Obtiene la Seccion y Equipo.
            $query = "
                    SELECT c_secciones.seccion 
                    FROM c_subsecciones 
                    INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                    WHERE c_subsecciones.id = $idSubseccion;
                ";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $seccion = $value['seccion'];
                    $equipo = "Tareas Generales";

                    $data['seccion'] = $seccion;
                    $data['nombreEquipo'] = $equipo;
                }
            }
        } else {
            // Obtiene la Seccion y Equipo.
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
        }


        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND t_mc.id_destino = $idDestino";
        }

        if ($idEquipo == 0) {
            $queryMCF = "
                SELECT 
                t_mc.status_material, t_mc.status_trabajare, t_mc.status_urgente,
                t_mc.energetico_electricidad, t_mc.energetico_agua, t_mc.energetico_diesel, t_mc.energetico_gas,
                t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.departamento_direccion, 
                t_mc.departamento_finanzas, t_mc.departamento_rrhh,
                t_mc.id, t_mc.responsable, t_mc.actividad, t_mc.fecha_realizado, t_mc.fecha_creacion, t_colaboradores.nombre, t_colaboradores.apellido, t_mc.rango_fecha 
                FROM t_mc 
                LEFT JOIN t_users ON t_mc.creado_por = t_users.id
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_mc.status = 'F' AND t_mc.activo = 1 AND t_mc.id_subseccion = $idSubseccion 
                AND(t_mc.id_equipo = 0 OR t_mc.id_equipo = '') $filtroDestino ORDER BY t_mc.id DESC
            ";
        } else {
            $queryMCF = "
                SELECT 
                t_mc.status_material, t_mc.status_trabajare, t_mc.status_urgente,
                t_mc.energetico_electricidad, t_mc.energetico_agua, t_mc.energetico_diesel, t_mc.energetico_gas,
                t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.departamento_direccion, 
                t_mc.departamento_finanzas, t_mc.departamento_rrhh,
                t_mc.id, t_mc.responsable, t_mc.actividad, t_mc.fecha_realizado, t_mc.fecha_creacion, t_colaboradores.nombre, t_colaboradores.apellido, t_mc.rango_fecha 
                FROM t_mc 
                LEFT JOIN t_users ON t_mc.creado_por = t_users.id
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_mc.id_equipo = $idEquipo AND t_mc.status = 'F' AND t_mc.activo = 1
            ";
        }

        if ($resultMCF = mysqli_query($conn_2020, $queryMCF)) {
            $totalMCF = mysqli_num_rows($resultMCF);
            foreach ($resultMCF as $row) {
                $idMC = $row['id'];
                $responsable = $row['responsable'];
                $actividad = $row['actividad'];
                $creadoPor = strtok($row['nombre'], ' ') . " " . strtok($row['apellido'], ' ');
                $fechaRealizado = (new DateTime($row['fecha_realizado']))->format('d/m/y');
                $fechaCreacion = (new DateTime($row['fecha_creacion']))->format('d/m/y');
                $fechaRango = $row['rango_fecha'];
                $fechaMC = "";

                // Si no Tiene fecha Rango toma la fecha de creación.
                if ($fechaCreacion != "") {
                    $fechaMC = $fechaRango;
                } else {
                    $fechaMC = "$fechaCreacion - $fechaCreacion";
                }


                // Status
                $statusUrgente = $row['status_urgente'];
                if ($statusUrgente == 0 or $statusUrgente == "") {
                    $statusUrgente = "hidden";
                } else {
                    $statusUrgente = "";
                }
                $statusTrabajare = $row['status_trabajare'];
                if ($statusTrabajare == 0 or $statusTrabajare == "") {
                    $statusTrabajare = "hidden";
                } else {
                    $statusTrabajare = "";
                }
                $statusMaterial = $row['status_material'];
                if ($statusMaterial == 0 or $statusMaterial == "") {
                    $statusMaterial = "hidden";
                } else {
                    $statusMaterial = "";
                }
                $statusElectricidad = $row['energetico_electricidad'];
                if ($statusElectricidad == 0 or $statusElectricidad == "") {
                    $statusElectricidad = "hidden";
                } else {
                    $statusElectricidad = "";
                }
                $statusAgua = $row['energetico_agua'];
                if ($statusAgua == 0 or $statusAgua == "") {
                    $statusAgua = "hidden";
                } else {
                    $statusAgua = "";
                }
                $statusGas = $row['energetico_gas'];
                if ($statusGas == 0 or $statusGas == "") {
                    $statusGas = "hidden";
                } else {
                    $statusGas = "";
                }
                $statusDiesel = $row['energetico_diesel'];
                if ($statusDiesel == 0 or $statusDiesel == "") {
                    $statusDiesel = "hidden";
                } else {
                    $statusDiesel = "";
                }
                $statusCompras = $row['departamento_compras'];
                if ($statusCompras == 0 or $statusCompras == "") {
                    $statusCompras = "hidden";
                } else {
                    $statusCompras = "";
                }
                $statusFinanzas = $row['departamento_finanzas'];
                if ($statusFinanzas == 0 or $statusFinanzas == "") {
                    $statusFinanzas = "hidden";
                } else {
                    $statusFinanzas = "";
                }
                $statusRRHH = $row['departamento_rrhh'];
                if ($statusRRHH == 0 or $statusRRHH == "") {
                    $statusRRHH = "hidden";
                } else {
                    $statusRRHH = "";
                }
                $statusCalidad = $row['departamento_calidad'];
                if ($statusCalidad == 0 or $statusCalidad == "") {
                    $statusCalidad = "hidden";
                } else {
                    $statusCalidad = "";
                }
                $statusDireccion = $row['departamento_direccion'];
                if ($statusDireccion == 0 or $statusDireccion == "") {
                    $statusDireccion = "hidden";
                } else {
                    $statusDireccion = "";
                }


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

                $dataMCF .= "
                    <div class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\">
                        <!-- FALLA -->
                        <div class=\"w-full h-full flex flex-row items-center justify-between bg-green-100 text-green-500 rounded-l-md cursor-pointer hover:shadow-md border-l-4 border-green-200 relative\">

                            <div class=\"$statusUrgente absolute\" style=\"left: -17px;\">
                                <i class=\"fas fa-siren-on animated flash infinite fa-rotate-270\"></i>
                            </div>
                            <div class=\"absolute flex hover:opacity-25\" style=\"right: 0%; font-size: 9px;\">
                                <div class=\"$statusMaterial bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">M</h1>
                                </div>
                                
                                <div class=\"$statusTrabajare bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">T</h1>
                                </div>
                                
                                <div class=\"$statusElectricidad bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Electricidad</h1>
                                </div>
                                
                                <div class=\"$statusAgua bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Agua</h1>
                                </div>
                               
                                <div class=\"$statusGas bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Gas</h1>
                                </div>
                                
                                <div class=\"$statusDiesel bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Diesel</h1>
                                </div>
                                
                                <div class=\"$statusDireccion bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Dirección</h1>
                                </div>
                                
                                <div class=\"$statusRRHH bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">RRHH</h1>
                                </div>
                                
                                <div class=\"$statusFinanzas bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Finanzas</h1>
                                </div>
                                
                                <div class=\"$statusCompras bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Compras</h1>
                                </div>
                                
                                <div class=\"$statusCalidad bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Calidad</h1>
                                </div>
                            </div>

                            <div class=\" flex flex-row items-center truncate w-full\">
                                <div>
                                    <i class=\"fas fa-hammer mx-2\"></i>
                                </div>
                                <div class=\"flex flex-col leading-none w-full flex-wrap\">
                                    <h1 class=\"\">$actividad</h1>
                                    <h1 class=\"tex-xs font-normal italic text-green-300\">creado por: $creadoPor
                                    </h1>
                                </div>
                            </div>
                        </div>

                        <!-- RESPONSABLE -->
                        <div data-target=\"modal-responsable\" data-toggle=\"modal\" class=\"w-48 flex h-full items-center justify-center hover:shadow-md\">
                            <h1>$nombreResponsable</h1>
                        </div>

                        <!-- INICIO & FIN-->
                        <div class=\"w-64 flex h-full items-center justify-center hover:shadow-md\">
                            <input class=\"bg-white focus:outline-none focus:shadow-none py-2 px-4 block w-full appearance-none leading-normal font-semibold text-xs text-center\" type=\"text\" name=\"\" value=\"$fechaMC\" disabled>
                        </div>

                        <!--  ADJUNTOS -->
                        <div onclick=\"obtenerAdjuntosMC($idMC);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1 class=\"font-xs\">$totalMedia</h1>
                        </div>

                        <!--  COMENTARIOS -->
                        <div onclick=\"obtenerComentariosMC($idMC);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1>$totalComentario</h1>
                        </div>

                        <!--  STATUS -->
                        <div onclick=\"actualizarStatusMC($idMC, 'status', 'F')\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md hover:bg-red-200 text-red-500 rounded-r-md\">
                            <div><i class=\"fas fa-undo fa-lg\"></i></div>
                        </div>
                    </div>
                ";
            }
            $data['dataMCF'] = $dataMCF;
            $data['totalMCF'] = $totalMCF;
        }

        $query = "
            SELECT c_secciones.seccion, t_equipos.equipo 
            FROM t_equipos 
            LEFT JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
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


    // Se obtienen todos los MCN - Pendientes por Equipo y TG.
    if ($action == "obtenerMCN") {
        $idEquipo = $_POST['idEquipo'];
        $idSubseccion = $_POST['idSubseccion'];
        $data = array();
        $MC = "";
        $contadorMC = 0;

        if ($idEquipo == 0) {
            // Obtiene la Seccion y Equipo.
            $query = "
                    SELECT c_secciones.seccion 
                    FROM c_subsecciones 
                    INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
                    WHERE c_subsecciones.id = $idSubseccion;
                ";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $seccion = $value['seccion'];
                    $equipo = "Tareas Generales";

                    $data['seccion'] = $seccion;
                    $data['nombreEquipo'] = $equipo;
                }
            }
        } else {
            // Obtiene la Seccion y Equipo.
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
        }

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND t_mc.id_destino = $idDestino";
        }

        if ($idEquipo == 0) {
            $query = "
                SELECT 
                t_mc.status_material, t_mc.status_trabajare, t_mc.status_urgente,
                t_mc.energetico_electricidad, t_mc.energetico_agua, t_mc.energetico_diesel, t_mc.energetico_gas,
                t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.departamento_direccion, 
                t_mc.departamento_finanzas, t_mc.departamento_rrhh,
                t_mc.id, t_mc.responsable, t_mc.actividad,t_mc.rango_fecha, t_mc.fecha_realizado, t_mc.fecha_creacion, t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_mc 
                INNER JOIN t_users ON t_mc.creado_por = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_mc.status = 'N' AND t_mc.activo = 1 AND t_mc.id_subseccion = $idSubseccion AND(t_mc.id_equipo = 0 OR t_mc.id_equipo='') $filtroDestino ORDER BY t_mc.id DESC
            ";
        } else {
            $query = "
                SELECT 
                t_mc.status_material, t_mc.status_trabajare, t_mc.status_urgente,
                t_mc.energetico_electricidad, t_mc.energetico_agua, t_mc.energetico_diesel, t_mc.energetico_gas,
                t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.departamento_direccion, 
                t_mc.departamento_finanzas, t_mc.departamento_rrhh,
                t_mc.id, t_mc.responsable, t_mc.actividad,t_mc.rango_fecha, t_mc.fecha_realizado, t_mc.fecha_creacion, t_colaboradores.nombre, t_colaboradores.apellido 
                FROM t_mc 
                INNER JOIN t_users ON t_mc.creado_por = t_users.id
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_mc.id_equipo = $idEquipo AND t_mc.status = 'N' AND t_mc.activo = 1
            ";
        }



        if ($result = mysqli_query($conn_2020, $query)) {

            foreach ($result as $row) {
                $contadorMC++;
                $idMC = $row['id'];
                $responsable = $row['responsable'];
                $actividad = $row['actividad'];
                $creadoPor = strtok($row['nombre'], ' ') . " " . strtok($row['apellido'], ' ');
                $fechaCreacion = (new DateTime($row['fecha_creacion']))->format('d/m/Y');
                $fechaRealizado = (new DateTime($row['fecha_realizado']))->format('d/m/Y');
                $fechaRango = $row['rango_fecha'];
                $fechaMC = "";

                // Si no Tiene fecha Rango toma la fecha de creación.
                if ($fechaRango != "") {
                    $fechaMC = $fechaRango;
                } else {
                    $fechaMC = $fechaCreacion . " - " . $fechaCreacion;
                }


                // Status
                $statusUrgente = $row['status_urgente'];
                if ($statusUrgente == 0 or $statusUrgente == "") {
                    $statusUrgente = "hidden";
                } else {
                    $statusUrgente = "";
                }
                $statusTrabajare = $row['status_trabajare'];
                if ($statusTrabajare == 0 or $statusTrabajare == "") {
                    $statusTrabajare = "hidden";
                } else {
                    $statusTrabajare = "";
                }
                $statusMaterial = $row['status_material'];
                if ($statusMaterial == 0 or $statusMaterial == "") {
                    $statusMaterial = "hidden";
                } else {
                    $statusMaterial = "";
                }
                $statusElectricidad = $row['energetico_electricidad'];
                if ($statusElectricidad == 0 or $statusElectricidad == "") {
                    $statusElectricidad = "hidden";
                } else {
                    $statusElectricidad = "";
                }
                $statusAgua = $row['energetico_agua'];
                if ($statusAgua == 0 or $statusAgua == "") {
                    $statusAgua = "hidden";
                } else {
                    $statusAgua = "";
                }
                $statusGas = $row['energetico_gas'];
                if ($statusGas == 0 or $statusGas == "") {
                    $statusGas = "hidden";
                } else {
                    $statusGas = "";
                }
                $statusDiesel = $row['energetico_diesel'];
                if ($statusDiesel == 0 or $statusDiesel == "") {
                    $statusDiesel = "hidden";
                } else {
                    $statusDiesel = "";
                }
                $statusCompras = $row['departamento_compras'];
                if ($statusCompras == 0 or $statusCompras == "") {
                    $statusCompras = "hidden";
                } else {
                    $statusCompras = "";
                }
                $statusFinanzas = $row['departamento_finanzas'];
                if ($statusFinanzas == 0 or $statusFinanzas == "") {
                    $statusFinanzas = "hidden";
                } else {
                    $statusFinanzas = "";
                }
                $statusRRHH = $row['departamento_rrhh'];
                if ($statusRRHH == 0 or $statusRRHH == "") {
                    $statusRRHH = "hidden";
                } else {
                    $statusRRHH = "";
                }
                $statusCalidad = $row['departamento_calidad'];
                if ($statusCalidad == 0 or $statusCalidad == "") {
                    $statusCalidad = "hidden";
                } else {
                    $statusCalidad = "";
                }
                $statusDireccion = $row['departamento_direccion'];
                if ($statusDireccion == 0 or $statusDireccion == "") {
                    $statusDireccion = "hidden";
                } else {
                    $statusDireccion = "";
                }


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
                    <div id=\"FALLA$idMC\" class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\">
                        <!-- FALLA -->
                        <div class=\"truncate w-full h-full flex flex-row items-center justify-between bg-red-100 text-red-500 rounded-l-md cursor-pointer hover:shadow-md border-l-4 border-red-200 relative\" onclick=\"obtenerActividadesOT($idMC, 'FALLA');\">

                            <div class=\" $statusUrgente absolute\" style=\"left:0%;\">
                               <i class=\"fas fa-siren-on animated flash infinite fa-rotate-270\"></i>
                            </div>
                            <div class=\"absolute flex hover:opacity-25\" style=\"right: 0%; font-size: 9px;\">
                                <div class=\"$statusMaterial bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">M</h1>
                                </div>
                                
                                <div class=\"$statusTrabajare bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">T</h1>
                                </div>
                                
                                <div class=\"$statusElectricidad bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Electricidad</h1>
                                </div>
                                
                                <div class=\"$statusAgua bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Agua</h1>
                                </div>
                               
                                <div class=\"$statusGas bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Gas</h1>
                                </div>
                                
                                <div class=\"$statusDiesel bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Diesel</h1>
                                </div>
                                
                                <div class=\"$statusDireccion bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Dirección</h1>
                                </div>
                                
                                <div class=\"$statusRRHH bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">RRHH</h1>
                                </div>
                                
                                <div class=\"$statusFinanzas bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Finanzas</h1>
                                </div>
                                
                                <div class=\"$statusCompras bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Compras</h1>
                                </div>
                                
                                <div class=\"$statusCalidad bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Calidad</h1>
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
                        <div class=\"w-64 flex h-full items-center justify-center hover:shadow-md self-start\">
                            <input id=\"fecha$idMC\" onclick=\"obtenerFechaMC($idMC, '$fechaMC');\"
                            id=\"fecha$idMC\" class=\"appearance-none block w-full text-gray-700 rounded py-3 px-4 leading-tight mb-4\" type=\"text\" name=\"fecha$idMC\" value=\"$fechaMC\">
                        </div>

                        <!--  ADJUNTOS -->
                        <div onclick=\"obtenerAdjuntosMC($idMC);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1 class=\"font-xs\">$totalMedia</h1>
                        </div>

                        <!--  COMENTARIOS -->
                        <div onclick=\"obtenerComentariosMC($idMC);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1>$totalComentario</h1>
                        </div>

                        <!--  STATUS -->
                        <div onclick=\"obtenerstatusMC($idMC);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md hover:bg-teal-200 text-teal-500 rounded-r-md\">
                            <div><i class=\"fad fa-exclamation-circle fa-lg\"></i></div>
                        </div>

                    </div>                
                ";
            }
            $data['contadorMC'] = $contadorMC;
            $data['MC'] = $MC;
        }
        echo json_encode($data);
    }


    // Busca Usuarios para Asignar responsable.
    if ($action == "obtenerUsuarios") {
        // Variables AJAX.
        $palabraUsuario = $_POST['palabraUsuario'];
        $tipoAsignacion = $_POST['tipoAsignacion'];
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

            //Tipo de Asignación sirve para mandar parametros especificos en las funciones. 
            if ($tipoAsignacion == "asignarMC") {
                $totalUsuarios = mysqli_num_rows($resultUsuarios);
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
            } elseif ($tipoAsignacion == "asignarTarea") {
                $totalUsuarios = mysqli_num_rows($resultUsuarios);
                foreach ($resultUsuarios as $value) {
                    $idUsuario = $value['idUsuario'];
                    $nombre = $value['nombre'];
                    $apellido = $value['apellido'];
                    $cargo = $value['cargo'];
                    $nombreCompleto = $nombre . " " . $apellido;

                    $dataUsuarios .= "
                        <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                        onclick=\"asignarUsuario($idUsuario, 'asignarTarea', $idItem);\">
                            <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"20\" height=\"20\" alt=\"\">
                            <h1 class=\"ml-2\">$nombreCompleto</h1>
                            <p class=\"font-bold mx-1\"> / </p>
                            <h1 class=\"font-normal text-xs\">$cargo</h1>
                        </div>
                    ";
                }
            } elseif ($tipoAsignacion == "asignarTest") {
                $totalUsuarios = mysqli_num_rows($resultUsuarios);
                foreach ($resultUsuarios as $value) {
                    $idUsuario = $value['idUsuario'];
                    $nombre = $value['nombre'];
                    $apellido = $value['apellido'];
                    $cargo = $value['cargo'];
                    $nombreCompleto = $nombre . " " . $apellido;

                    $dataUsuarios .= "
                        <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                        onclick=\"asignarUsuario($idUsuario, 'asignarTest', $idItem);\">
                            <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"20\" height=\"20\" alt=\"\">
                            <h1 class=\"ml-2\">$nombreCompleto</h1>
                            <p class=\"font-bold mx-1\"> / </p>
                            <h1 class=\"font-normal text-xs\">$cargo</h1>
                        </div>
                    ";
                }
            } elseif ($tipoAsignacion == "asignarProyecto") {
                $totalUsuarios = mysqli_num_rows($resultUsuarios);
                foreach ($resultUsuarios as $value) {
                    $idUsuario = $value['idUsuario'];
                    $nombre = $value['nombre'];
                    $apellido = $value['apellido'];
                    $cargo = $value['cargo'];
                    $nombreCompleto = $nombre . " " . $apellido;

                    $dataUsuarios .= "
                        <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                        onclick=\"actualizarProyectos($idUsuario, 'asignarProyecto', $idItem);\">
                            <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"20\" height=\"20\" alt=\"\">
                            <h1 class=\"ml-2\">$nombreCompleto</h1>
                            <p class=\"font-bold mx-1\"> / </p>
                            <h1 class=\"font-normal text-xs\">$cargo</h1>
                        </div>
                    ";
                }
            } elseif ($tipoAsignacion == "asignarProyectoDEP") {
                $totalUsuarios = mysqli_num_rows($resultUsuarios);
                foreach ($resultUsuarios as $value) {
                    $idUsuario = $value['idUsuario'];
                    $nombre = $value['nombre'];
                    $apellido = $value['apellido'];
                    $cargo = $value['cargo'];
                    $nombreCompleto = $nombre . " " . $apellido;

                    $dataUsuarios .= "
                        <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                        onclick=\"actualizarProyectosDEP($idUsuario, 'asignarProyecto', $idItem);\">
                            <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"20\" height=\"20\" alt=\"\">
                            <h1 class=\"ml-2\">$nombreCompleto</h1>
                            <p class=\"font-bold mx-1\"> / </p>
                            <h1 class=\"font-normal text-xs\">$cargo</h1>
                        </div>
                    ";
                }
            } elseif ($tipoAsignacion == "asignarPlanaccion") {
                $totalUsuarios = mysqli_num_rows($resultUsuarios);
                foreach ($resultUsuarios as $value) {
                    $idUsuario = $value['idUsuario'];
                    $nombre = $value['nombre'];
                    $apellido = $value['apellido'];
                    $cargo = $value['cargo'];
                    $nombreCompleto = $nombre . " " . $apellido;

                    $dataUsuarios .= "
                        <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                        onclick=\"actualizarPlanaccion($idUsuario, 'asignarPlanaccion', $idItem);\">
                            <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"20\" height=\"20\" alt=\"\">
                            <h1 class=\"ml-2\">$nombreCompleto</h1>
                            <p class=\"font-bold mx-1\"> / </p>
                            <h1 class=\"font-normal text-xs\">$cargo</h1>
                        </div>
                    ";
                }
            } elseif ($tipoAsignacion == "asignarOT") {
                $totalUsuarios = mysqli_num_rows($resultUsuarios);
                foreach ($resultUsuarios as $value) {
                    $idUsuario = $value['idUsuario'];
                    $nombre = $value['nombre'];
                    $apellido = $value['apellido'];
                    $cargo = $value['cargo'];
                    $nombreCompleto = $nombre . " " . $apellido;

                    $dataUsuarios .= "
                        <div class=\"w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
                        onclick=\"eliminarResponsbleOT($idItem, $idUsuario);\">
                            <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"20\" height=\"20\" alt=\"\">
                            <h1 class=\"ml-2\">$nombreCompleto</h1>
                            <p class=\"font-bold mx-1\"> / </p>
                            <h1 class=\"font-normal text-xs\">$cargo</h1>
                        </div>
                    ";
                }
            }

            $data['totalUsuarios'] = $totalUsuarios;
            $data['dataUsuarios'] = $dataUsuarios;
        }
        echo json_encode($data);
    }


    // Asigna Responsable de la Falla
    if ($action == "asignarUsuario") {
        $tipoAsignacion = $_POST['tipoAsignacion'];
        $idUsuarioSeleccionado = $_POST['idUsuarioSeleccionado'];
        $idItem = $_POST['idItem'];
        $resp = "0";

        if ($tipoAsignacion == "asignarMC") {
            $query = "UPDATE t_mc SET responsable = $idUsuarioSeleccionado, ultima_modificacion = '$fechaActual' WHERE id = $idItem";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "MC";
            }
        } elseif ($tipoAsignacion == "asignarTarea") {
            $query = "UPDATE t_mp_np SET responsable = '$idUsuarioSeleccionado' 
            WHERE id = $idItem";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "TAREA";
            }
        } elseif ($tipoAsignacion == "asignarTest") {
            $query = "UPDATE t_test_equipos SET responsable = '$idUsuarioSeleccionado' 
            WHERE id = $idItem";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = "TEST";
            }
        }
        echo json_encode($resp);
    }


    // obtiene Adjuntos e Imagenes de FALLAS o MC
    if ($action == "obtenerAdjuntosMC") {
        // Variables AJAX.
        $idMC = $_POST['idMC'];

        // Variables Locales.
        $data = array();
        $dataImagen = "";
        $dataAdjunto = "";

        $queryAdjuntos = "SELECT t_mc_adjuntos.id, t_mc_adjuntos.url_adjunto, t_mc_adjuntos.fecha, t_mc_adjuntos.subido_por FROM t_mc_adjuntos 
        WHERE t_mc_adjuntos.id_mc = $idMC AND t_mc_adjuntos.activo = 1";

        if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {

            foreach ($resultAdjuntos as $value) {
                $idAdjunto = $value['id'];
                $url = $value['url_adjunto'];

                if (file_exists("../planner/tareas/adjuntos/$url")) {
                    $adjuntoURL = "planner/tareas/adjuntos/$url";
                } elseif (file_exists("../../planner/tareas/adjuntos/$url")) {
                    $adjuntoURL = "../planner/tareas/adjuntos/$url";
                } else {
                    $adjuntoURL = "../planner/tareas/adjuntos/$url";
                }

                // Admite solo Imagenes.
                if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {

                    if (strpbrk($adjuntoURL, ' ')) {
                        $dataImagen .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">

                                <a href=\"$adjuntoURL\" target=\"_blank\" data-title=\"Clic para Abrir\">
                                    <div class=\"m-2 cursor-pointer overflow-hidden w-32 h-32 rounded-md op2\">
                                        <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                    </div>
                                </a>

                                <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'FALLA');\">
                                    <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                </div>

                            </div>
                        ";
                    } else {
                        $dataImagen .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">

                                <a href=\"$adjuntoURL\" target=\"_blank\" data-title=\"Clic para Abrir\">
                                    <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                    </div>
                                </a>

                                <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'FALLA');\">
                                    <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                </div>

                            </div>
                        ";
                    }

                    // Admite todo, menos lo anterior.
                } else {
                    $dataAdjunto .= "
                        <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                           
                            <a href=\"$adjuntoURL\" target=\"_blank\">
                                <div class=\"auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2\">
                                    <i class=\"fad fa-file-alt fa-3x\"></i>
                                    <p class=\"text-sm font-normal ml-2\">$url
                                    </p>
                                </div>
                            </a>     
                            
                            <div class=\"absolute text-red-700\" style=\"bottom: 22px; right: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'FALLA');\">
                                <i class=\"fas fa-trash-alt fa-2x\"></i>
                            </div>
                        </div>
                    ";
                }
            }
        }
        $data['imagen'] = $dataImagen;
        $data['documento'] = $dataAdjunto;
        echo json_encode($data);
    }


    // obtiene Comentarios FALLAS o MC.
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


    // Agregar Comentario FALLAS o MC.
    if ($action == "agregarComentarioMC") {
        // Variables AJAX.
        $idMC = $_POST['idMC'];
        $comentarioMC = $_POST['comentarioMC'];

        $query = "INSERT INTO t_mc_comentarios(id_mc, comentario, id_usuario, fecha) VALUES($idMC, '$comentarioMC', $idUsuario, '$fechaActual')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    // Obtener status FALLAS o MC.
    if ($action == "obtenerStatusMC") {
        $data = array();
        $idMC = $_POST['idMC'];
        $query = "SELECT 
        status, activo, actividad,
        status_material, status_trabajare, status_urgente,
        energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas,
        departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, bitacora_gp, bitacora_trs, bitacora_zi, status_ep
        FROM t_mc 
        WHERE id = $idMC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $status = $value['status'];
                $statusActivo = $value['activo'];
                // Status.
                $statusMaterial = $value['status_material'];
                $statusTrabajare = $value['status_trabajare'];
                $statusUrgente = $value['status_urgente'];
                // Status Energeticos.
                $statusElectricidad = $value['energetico_electricidad'];
                $statusAgua = $value['energetico_agua'];
                $statusDiesel = $value['energetico_diesel'];
                $statusGas = $value['energetico_gas'];
                // Status Departamentos.
                $statusCalidad = $value['departamento_calidad'];
                $statusCompras = $value['departamento_compras'];
                $statusDireccion = $value['departamento_direccion'];
                $statusFinanzas = $value['departamento_finanzas'];
                $statusRRHH = $value['departamento_rrhh'];
                $tituloMC = $value['actividad'];
                $bitacoraGP = $value['bitacora_gp'];
                $bitacoraTRS = $value['bitacora_trs'];
                $bitacoraZI = $value['bitacora_zi'];
                $sEP = $value['status_ep'];

                // Status.
                if ($statusMaterial == "" or $statusMaterial == "0") {
                    $dataStatusMaterial = "actualizarStatusMC($idMC, 'status_material', 0);";
                } else {
                    $dataStatusMaterial = "actualizarStatusMC($idMC, 'status_material', 1);";
                }

                if ($statusUrgente == "" or $statusUrgente == "0") {
                    $dataStatusUrgente = "actualizarStatusMC($idMC, 'status_urgente', 0);";
                } else {
                    $dataStatusUrgente = "actualizarStatusMC($idMC, 'status_urgente', 1);";
                }

                if ($statusTrabajare == "" or $statusTrabajare == "0") {
                    $dataStatusTrabajare = "actualizarStatusMC($idMC, 'status_trabajare', 0);";
                } else {
                    $dataStatusTrabajare = "actualizarStatusMC($idMC, 'status_trabajare', 1);";
                }

                // Status Departamentos.
                if ($statusCalidad == "" or $statusCalidad == "0") {
                    $dataStatusCalidad = "actualizarStatusMC($idMC, 'departamento_calidad', 0);";
                } else {
                    $dataStatusCalidad = "actualizarStatusMC($idMC, 'departamento_calidad', 1);";
                }
                if ($statusCompras == "" or $statusCompras == "0") {
                    $dataStatusCompras = "actualizarStatusMC($idMC, 'departamento_compras', 0);";
                } else {
                    $dataStatusCompras = "actualizarStatusMC($idMC, 'departamento_compras', 1);";
                }
                if ($statusDireccion == "" or $statusDireccion == "0") {
                    $dataStatusDireccion = "actualizarStatusMC($idMC, 'departamento_direccion', 0);";
                } else {
                    $dataStatusDireccion = "actualizarStatusMC($idMC, 'departamento_direccion', 1);";
                }
                if ($statusFinanzas == "" or $statusFinanzas == "0") {
                    $dataStatusFinanzas = "actualizarStatusMC($idMC, 'departamento_finanzas', 0);";
                } else {
                    $dataStatusFinanzas = "actualizarStatusMC($idMC, 'departamento_finanzas', 1);";
                }
                if ($statusRRHH == "" or $statusRRHH == "0") {
                    $dataStatusRRHH = "actualizarStatusMC($idMC, 'departamento_rrhh', 0);";
                } else {
                    $dataStatusRRHH = "actualizarStatusMC($idMC, 'departamento_rrhh', 1);";
                }
                // StatusEnergeticos
                if ($statusElectricidad == "" or $statusElectricidad == "0") {
                    $dataStatusElectricidad = "actualizarStatusMC($idMC, 'energetico_electricidad', 0);";
                } else {
                    $dataStatusElectricidad = "actualizarStatusMC($idMC, 'energetico_electricidad', 1);";
                }
                if ($statusAgua == "" or $statusAgua == "0") {
                    $dataStatusAgua = "actualizarStatusMC($idMC, 'energetico_agua', 0);";
                } else {
                    $dataStatusAgua = "actualizarStatusMC($idMC, 'energetico_agua', 1);";
                }
                if ($statusDiesel == "" or $statusDiesel == "0") {
                    $dataStatusDiesel = "actualizarStatusMC($idMC, 'energetico_diesel', 0);";
                } else {
                    $dataStatusDiesel = "actualizarStatusMC($idMC, 'energetico_diesel', 1);";
                }
                if ($statusGas == "" or $statusGas == "0") {
                    $dataStatusGas = "actualizarStatusMC($idMC, 'energetico_gas', 0);";
                } else {
                    $dataStatusGas = "actualizarStatusMC($idMC, 'energetico_gas', 1);";
                }
                // Finalizar MC
                if ($status == "N") {
                    $dataStatus = "actualizarStatusMC($idMC, 'status', 'N');";
                } else {
                    $dataStatus = "actualizarStatusMC($idMC, 'status', 'F');";
                }
                // Activo MC
                if ($statusActivo == "1") {
                    $dataStatusActivo = "actualizarStatusMC($idMC, 'activo', '1');";
                } else {
                    $dataStatusActivo = "actualizarStatusMC($idMC, 'activo', '0');";
                }
                // Título MC
                if ($tituloMC == "") {
                    $dataStatusTitulo = "actualizarStatusMC($idMC, 'actividad', '1');";
                    $dataTituloMC = $tituloMC;
                } else {
                    $dataStatusTitulo = "actualizarStatusMC($idMC, 'actividad', '0');";
                    $dataTituloMC = $tituloMC;
                }

                // BITACORA GP
                if ($bitacoraGP == 0) {
                    $dataBitacoraGP = "actualizarStatusMC($idMC, 'bitacora_gp', '0');";
                } else {
                    $dataBitacoraGP = "actualizarStatusMC($idMC, 'bitacora_gp', '1');";
                }
                // BITACORA TRS
                if ($bitacoraTRS == 0) {
                    $dataBitacoraTRS = "actualizarStatusMC($idMC, 'bitacora_trs', '0');";
                } else {
                    $dataBitacoraTRS = "actualizarStatusMC($idMC, 'bitacora_trs', '1');";
                }
                // BITACORA ZI
                if ($bitacoraZI == 0) {
                    $dataBitacoraZI = "actualizarStatusMC($idMC, 'bitacora_zi', '0');";
                } else {
                    $dataBitacoraZI = "actualizarStatusMC($idMC, 'bitacora_zi', '1');";
                }

                // STATUS EP
                if ($sEP == 0) {
                    $datasEP = "actualizarStatusMC($idMC, 'status_ep', '0');";
                } else {
                    $datasEP = "actualizarStatusMC($idMC, 'status_ep', '1');";
                }
            }
            $data['dataStatusMaterial'] = $dataStatusMaterial;
            $data['dataStatusUrgente'] = $dataStatusUrgente;
            $data['dataStatusTrabajare'] = $dataStatusTrabajare;
            $data['dataStatusCalidad'] = $dataStatusCalidad;
            $data['dataStatusCompras'] = $dataStatusCompras;
            $data['dataStatusDireccion'] = $dataStatusDireccion;
            $data['dataStatusFinanzas'] = $dataStatusFinanzas;
            $data['dataStatusRRHH'] = $dataStatusRRHH;
            $data['dataStatusElectricidad'] = $dataStatusElectricidad;
            $data['dataStatusAgua'] = $dataStatusAgua;
            $data['dataStatusDiesel'] = $dataStatusDiesel;
            $data['dataStatusGas'] = $dataStatusGas;
            $data['dataStatus'] = $dataStatus;
            $data['dataStatusActivo'] = $dataStatusActivo;
            $data['dataStatusTitulo'] = $dataStatusTitulo;
            $data['dataTituloMC'] = $dataTituloMC;
            $data['dataBitacoraGP'] = $dataBitacoraGP;
            $data['dataBitacoraTRS'] = $dataBitacoraTRS;
            $data['dataBitacoraZI'] = $dataBitacoraZI;
            $data['datasEP'] = $datasEP;
        }
        echo json_encode($data);
    }


    // Actualzar el status de las Fallas
    if ($action == "actualizarStatusMC") {
        $idIncidencia = $_POST['idMC'];
        $columna = $_POST['status'];
        $valor = $_POST['valorStatus'];
        $tituloMC = $_POST['tituloMC'];
        $cod2bend = $_POST['cod2bend'];
        $resp = 0;

        // BUSCA VALORES EN LOS STATUS PARA CREA EL TOGGLE
        if ($columna == "status_material" || $columna == "status_trabajare" || $columna == "status_urgente" || $columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh" || $columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas" || $columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi" || $columna == "status_ep") {
            $query = "SELECT $columna FROM t_mc WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valor = intval($x[$columna]);
                }
            }

            if ($valor == 0) {
                $valor = 1;
            } else {
                $valor = 0;
            }
        }

        if ($columna == "responsable") {
            $query = "UPDATE t_mc SET responsable = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "actividad") {
            $query = "UPDATE t_mc SET actividad = '$tituloMC' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "status_trabajare") {
            $query = "UPDATE t_mc SET status_trabajare = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "status_material" and $cod2bend != "") {
            $query = "UPDATE t_mc SET status_material = $valor, cod2bend = '$cod2bend' 
            WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh") {
            $query = "UPDATE t_mc SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas") {
            $query = "UPDATE t_mc SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $query = "UPDATE t_mc SET $columna = $valor WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "status") {
            $query = "UPDATE t_mc SET status = 'SOLUCIONADO', fecha_realizado = '$fechaActual' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "eliminar" || $columna == "activo") {
            $query = "UPDATE t_mc SET activo = 0 WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "restaurar") {
            $query = "UPDATE t_mc SET status = 'PENDIENTE' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "rango_fecha" && $valor != "") {
            $query = "UPDATE t_mc SET rango_fecha = '$valor' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        } elseif ($columna == "status_ep") {
            $query = "UPDATE t_mc SET status_ep = '$valor' WHERE id = $idIncidencia";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }

        echo $resp;
    }


    // Obtienes las TAREAS PENDIETES de los equipos.
    if ($action == "obtenerTareasP") {
        $data = array();
        $dataTareas = "";
        $idEquipo = $_POST['idEquipo'];
        $contadorTareas = 0;

        $queryEquipo = "SELECT t_equipos.equipo, c_secciones.seccion 
        FROM t_equipos 
        INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
        WHERE t_equipos.id = $idEquipo AND t_equipos.status = 'A'";

        if ($resultEquipo = mysqli_query($conn_2020, $queryEquipo)) {
            foreach ($resultEquipo as $value) {
                $equipo = $value['equipo'];
                $seccion = $value['seccion'];

                //Regresa datos. 
                $data['nombreEquipo'] = $equipo;
                $data['seccion'] = $seccion;
            }
        }

        $query = "SELECT t_mp_np.id, t_mp_np.rango_fecha, t_mp_np.titulo, t_mp_np.id_usuario, t_colaboradores.nombre, 
        t_colaboradores.apellido, t_mp_np.responsable,
        t_mp_np.status_urgente, t_mp_np.status_material, t_mp_np.status_trabajando, t_mp_np.energetico_electricidad, t_mp_np.energetico_agua, t_mp_np.energetico_diesel, t_mp_np.energetico_gas, t_mp_np.departamento_calidad, t_mp_np.departamento_compras, t_mp_np.departamento_direccion, t_mp_np.departamento_finanzas, 
        t_mp_np.departamento_rrhh
        FROM t_mp_np 
        INNER JOIN t_equipos ON t_mp_np.id_equipo = t_equipos.id 
        INNER JOIN t_users ON t_mp_np.id_usuario = t_users.id 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
        WHERE t_mp_np.id_equipo = $idEquipo AND t_mp_np.activo = 1 
        AND (t_mp_np.status = 'N' OR t_mp_np.status = 'PENDIENTE' OR t_mp_np.status = 'P' OR t_mp_np.status = '') ORDER BY t_mp_np.id DESC";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $contadorTareas++;

                $idTarea = $value['id'];
                $idResponsable = $value['responsable'];
                $actividad = $value['titulo'];
                $creadoPor = strtok($value['nombre'], '') . " " . strtok($value['apellido'], '');
                $fechaTarea = $value['rango_fecha'];
                $sUrgente = $value['status_urgente'];
                $sMaterial = $value['status_material'];
                $sTrabajando = $value['status_trabajando'];
                $eElectricidad = $value['energetico_electricidad'];
                $eAgua = $value['energetico_agua'];
                $eDiesel = $value['energetico_diesel'];
                $eGas = $value['energetico_gas'];
                $dCalidad = $value['departamento_calidad'];
                $dCompras = $value['departamento_compras'];
                $dDireccion = $value['departamento_direccion'];
                $dFinanzas = $value['departamento_finanzas'];
                $dRRHH = $value['departamento_rrhh'];

                // Obtiene el Responsable
                $queryResponsable = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM  t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                $responsable = "";
                if ($resultResponsable = mysqli_query($conn_2020, $queryResponsable)) {
                    foreach ($resultResponsable as $value) {
                        $responsable = strtok($value['nombre'], ' ') . " " . strtok($value['apellido'], ' ');
                    }
                }


                // Obtiene el numero de Comentarios
                $queryComentario = "SELECT id FROM comentarios_mp_np WHERE id_mp_np = $idTarea";
                if ($resultComentarios = mysqli_query($conn_2020, $queryComentario)) {
                    $totalComentarios = mysqli_num_rows($resultComentarios);
                }

                // Obtiene el numero de Adjuntos
                $queryMedia = "SELECT id FROM adjuntos_mp_np WHERE id_mp_np = $idTarea";
                if ($resultMedia = mysqli_query($conn_2020, $queryMedia)) {
                    $totalMedia = mysqli_num_rows($resultMedia);
                }

                //El estatus urgente se quito temporalmente 
                if ($sUrgente == 1 or $sUrgente != "0") {
                    $sUrgente = "";
                } else {
                    $sUrgente = "hidden";
                }

                if ($sMaterial == 1 or $sMaterial != "0") {
                    $sMaterial = "";
                } else {
                    $sMaterial = "hidden";
                }

                if ($sTrabajando == 1 or $sTrabajando != "0") {
                    $sTrabajando = "";
                } else {
                    $sTrabajando = "hidden";
                }

                if ($eElectricidad == 1 or $eElectricidad != "0") {
                    $eElectricidad = "";
                } else {
                    $eElectricidad = "hidden";
                }

                if ($eAgua == 1 or $eAgua != "0") {
                    $eAgua = "";
                } else {
                    $eAgua = "hidden";
                }

                if ($eDiesel == 1 or $eDiesel != "0") {
                    $eDiesel = "";
                } else {
                    $eDiesel = "hidden";
                }

                if ($eGas == 1 or $eGas != "0") {
                    $eGas = "";
                } else {
                    $eGas = "hidden";
                }

                if ($dCalidad == 1 or $dCalidad != "0") {
                    $dCalidad = "";
                } else {
                    $dCalidad = "hidden";
                }

                if ($dCompras == 1 or $dCompras != "0") {
                    $dCompras = "";
                } else {
                    $dCompras = "hidden";
                }

                if ($dDireccion == 1 or $dDireccion != "0") {
                    $dDireccion = "";
                } else {
                    $dDireccion = "hidden";
                }

                if ($dFinanzas == 1 or $dFinanzas != "0") {
                    $dFinanzas = "";
                } else {
                    $dFinanzas = "hidden";
                }

                if ($dRRHH == 1 or $dRRHH != "0") {
                    $dRRHH = "";
                } else {
                    $dRRHH = "hidden";
                }

                $dataTareas .= "
                    <div id=\"TAREA$idTarea\" class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\">
                        <!-- FALLA -->
                        <div onclick=\"obtenerActividadesOT($idTarea, 'TAREA');\" class=\"truncate w-full h-full flex flex-row items-center justify-between bg-red-100 text-red-500 rounded-l-md cursor-pointer hover:shadow-md border-l-4 border-red-200 relative\">

                            <div class=\" hidden absolute\" style=\"left:0%;\">
                               <i class=\"fas fa-siren-on animated flash infinite fa-rotate-270\"></i>
                            </div>
                            <div class=\"absolute flex hover:opacity-25\" style=\"right: 0%; font-size: 9px;\">
                            
                                <div class=\"$sMaterial bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">M</h1>
                                </div>
                                
                                <div class=\"$sTrabajando bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">T</h1>
                                </div>
                                
                                <div class=\"$eElectricidad bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Electricidad</h1>
                                </div>
                                
                                <div class=\"$eAgua bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Agua</h1>
                                </div>
                               
                                <div class=\"$eGas bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Gas</h1>
                                </div>
                                
                                <div class=\"$eDiesel bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Diesel</h1>
                                </div>
                                
                                <div class=\"$dDireccion bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Dirección</h1>
                                </div>
                                
                                <div class=\"$dRRHH bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">RRHH</h1>
                                </div>
                                
                                <div class=\"$dFinanzas bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Finanzas</h1>
                                </div>
                                
                                <div class=\"$dCompras bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Compras</h1>
                                </div>
                                
                                <div class=\"$dCalidad bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Calidad</h1>
                                </div>
                            </div>

                            <div class=\" flex flex-row items-center truncate w-full\">
                                <div>
                                    <i class=\"fas fa-hammer mx-2\"></i>
                                </div>
                                <div class=\"flex flex-col leading-none w-full flex-wrap\">
                                    <h1 class=\"\"> $actividad </h1>
                                    <h1 class=\"tex-xs font-normal italic text-red-300\">
                                        creado por: $creadoPor
                                    </h1>

                                </div>
                            </div>
                        </div>

                        <!-- RESPONSABLE -->
                        <div onclick=\"obtenerUsuarios('asignarTarea', $idTarea);\" class=\"w-48 flex h-full items-center justify-center\">
                            <h1>$responsable</h1>
                        </div>

                        <!-- INICIO & FIN-->
                        <div class=\"w-64 flex h-full items-center justify-center self-start\">
                            <input id=\"fecha$idTarea\" onclick=\"obtenerFechaTareas($idTarea, '$fechaTarea');\"
                            id=\"fecha$idTarea\" class=\"appearance-none block w-full text-gray-700 rounded py-3 px-4 leading-tight mb-4\" type=\"text\" name=\"fecha$idTarea\" value=\"$fechaTarea\">
                        </div>

                        <!--  ADJUNTOS -->
                        <div onclick=\"obtenerAdjuntosTareas($idTarea);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1 class=\"font-xs\">$totalMedia</h1>
                        </div>

                        <!--  COMENTARIOS -->
                        <div onclick=\"obtenerComentariosTareas($idTarea);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1>$totalComentarios</h1>
                        </div>

                        <!--  STATUS -->
                        <div onclick=\"obtenerInformacionTareas($idTarea, '$actividad');\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md hover:bg-teal-200 text-teal-500 rounded-r-md\">
                            <div><i class=\"fad fa-exclamation-circle fa-lg\"></i></div>
                        </div>

                    </div>                
                ";
            }
            $data['dataTareas'] = $dataTareas;
            $data['contadorTareas'] = $contadorTareas;
        }
        echo json_encode($data);
    }


    // Obtienes las TAREAS PENDIETES de los equipos.
    if ($action == "obtenerTareasS") {
        $data = array();
        $dataTareas = "";
        $idEquipo = $_POST['idEquipo'];
        $contadorTareas = 0;

        $queryEquipo = "SELECT t_equipos.equipo, c_secciones.seccion 
        FROM t_equipos 
        INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id
        WHERE t_equipos.id = $idEquipo AND t_equipos.status = 'A'";

        if ($resultEquipo = mysqli_query($conn_2020, $queryEquipo)) {
            foreach ($resultEquipo as $value) {
                $equipo = $value['equipo'];
                $seccion = $value['seccion'];

                //Regresa datos. 
                $data['nombreEquipo'] = $equipo;
                $data['seccion'] = $seccion;
            }
        }

        $query = "SELECT t_mp_np.id, t_mp_np.fecha, t_mp_np.titulo, t_mp_np.id_usuario, t_colaboradores.nombre, 
        t_colaboradores.apellido, t_mp_np.responsable,
        t_mp_np.status_urgente, t_mp_np.status_material, t_mp_np.status_trabajando, t_mp_np.energetico_electricidad, t_mp_np.energetico_agua, t_mp_np.energetico_diesel, t_mp_np.energetico_gas, t_mp_np.departamento_calidad, t_mp_np.departamento_compras, t_mp_np.departamento_direccion, t_mp_np.departamento_finanzas, 
        t_mp_np.departamento_rrhh
        FROM t_mp_np 
        INNER JOIN t_equipos ON t_mp_np.id_equipo = t_equipos.id 
        INNER JOIN t_users ON t_mp_np.id_usuario = t_users.id 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
        WHERE t_mp_np.id_equipo = $idEquipo AND t_mp_np.activo = 1 
        AND (t_mp_np.status = 'F' OR t_mp_np.status = 'SOLUCIONADA' OR t_mp_np.status = 'FINALIZADA') ORDER BY t_mp_np.id DESC";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $contadorTareas++;

                $idTarea = $value['id'];
                $idResponsable = $value['responsable'];
                $actividad = $value['titulo'];
                $creadoPor = strtok($value['nombre'], '') . " " . strtok($value['apellido'], '');
                $fechaTarea = $value['fecha'];
                $sUrgente = $value['status_urgente'];
                $sMaterial = $value['status_material'];
                $sTrabajando = $value['status_trabajando'];
                $eElectricidad = $value['energetico_electricidad'];
                $eAgua = $value['energetico_agua'];
                $eDiesel = $value['energetico_diesel'];
                $eGas = $value['energetico_gas'];
                $dCalidad = $value['departamento_calidad'];
                $dCompras = $value['departamento_compras'];
                $dDireccion = $value['departamento_direccion'];
                $dFinanzas = $value['departamento_finanzas'];
                $dRRHH = $value['departamento_rrhh'];

                // Obtiene el Responsable
                $queryResponsable = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                FROM  t_users
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id = $idResponsable";
                $responsable = "";
                if ($resultResponsable = mysqli_query($conn_2020, $queryResponsable)) {
                    foreach ($resultResponsable as $value) {
                        $responsable = strtok($value['nombre'], ' ') . " " . strtok($value['apellido'], ' ');
                    }
                }


                // Obtiene el numero de Comentarios
                $queryComentario = "SELECT id FROM comentarios_mp_np WHERE id_mp_np = $idTarea";
                if ($resultComentarios = mysqli_query($conn_2020, $queryComentario)) {
                    $totalComentarios = mysqli_num_rows($resultComentarios);
                }

                // Obtiene el numero de Adjuntos
                $queryMedia = "SELECT id FROM adjuntos_mp_np WHERE id_mp_np = $idTarea";
                if ($resultMedia = mysqli_query($conn_2020, $queryMedia)) {
                    $totalMedia = mysqli_num_rows($resultMedia);
                }

                //El estatus urgente se quito temporalmente 
                if ($sUrgente == 1 or $sUrgente != "0") {
                    $sUrgente = "";
                } else {
                    $sUrgente = "hidden";
                }

                if ($sMaterial == 1 or $sMaterial != "0") {
                    $sMaterial = "";
                } else {
                    $sMaterial = "hidden";
                }

                if ($sTrabajando == 1 or $sTrabajando != "0") {
                    $sTrabajando = "";
                } else {
                    $sTrabajando = "hidden";
                }

                if ($eElectricidad == 1 or $eElectricidad != "0") {
                    $eElectricidad = "";
                } else {
                    $eElectricidad = "hidden";
                }

                if ($eAgua == 1 or $eAgua != "0") {
                    $eAgua = "";
                } else {
                    $eAgua = "hidden";
                }

                if ($eDiesel == 1 or $eDiesel != "0") {
                    $eDiesel = "";
                } else {
                    $eDiesel = "hidden";
                }

                if ($eGas == 1 or $eGas != "0") {
                    $eGas = "";
                } else {
                    $eGas = "hidden";
                }

                if ($dCalidad == 1 or $dCalidad != "0") {
                    $dCalidad = "";
                } else {
                    $dCalidad = "hidden";
                }

                if ($dCompras == 1 or $dCompras != "0") {
                    $dCompras = "";
                } else {
                    $dCompras = "hidden";
                }

                if ($dDireccion == 1 or $dDireccion != "0") {
                    $dDireccion = "";
                } else {
                    $dDireccion = "hidden";
                }

                if ($dFinanzas == 1 or $dFinanzas != "0") {
                    $dFinanzas = "";
                } else {
                    $dFinanzas = "hidden";
                }

                if ($dRRHH == 1 or $dRRHH != "0") {
                    $dRRHH = "";
                } else {
                    $dRRHH = "hidden";
                }

                $dataTareas .= "
                    <div class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\">
                        <!-- FALLA -->
                        <div class=\"w-full h-full flex flex-row items-center justify-between bg-green-100 text-green-500 rounded-l-md cursor-pointer hover:shadow-md border-l-4 border-green-200 relative\">

                            <div class=\"$sUrgente absolute\" style=\"left: -17px;\">
                                <i class=\"fas fa-siren-on animated flash infinite fa-rotate-270\"></i>
                            </div>
                            <div class=\"absolute flex hover:opacity-25\" style=\"right: 0%; font-size: 9px;\">
                                <div class=\"$sMaterial bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">M</h1>
                                </div>
                                
                                <div class=\"$sTrabajando bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                    <h1 class=\"\">T</h1>
                                </div>
                                
                                <div class=\"$eElectricidad bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Electricidad</h1>
                                </div>
                                
                                <div class=\"$eAgua bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Agua</h1>
                                </div>
                               
                                <div class=\"$eGas bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Gas</h1>
                                </div>
                                
                                <div class=\"$eDiesel bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                    <h1 class=\"\">Diesel</h1>
                                </div>
                                
                                <div class=\"$dDireccion bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Dirección</h1>
                                </div>
                                
                                <div class=\"$dRRHH bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">RRHH</h1>
                                </div>
                                
                                <div class=\"$dFinanzas bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Finanzas</h1>
                                </div>
                                
                                <div class=\"$dCompras bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Compras</h1>
                                </div>
                                
                                <div class=\"$dCalidad bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                    <h1 class=\"\">Calidad</h1>
                                </div>
                            </div>

                            <div class=\" flex flex-row items-center truncate w-full\">
                                <div>
                                    <i class=\"fas fa-hammer mx-2\"></i>
                                </div>
                                <div class=\"flex flex-col leading-none w-full flex-wrap\">
                                    <h1 class=\"\">$actividad</h1>
                                    <h1 class=\"tex-xs font-normal italic text-green-300\">creado por: $creadoPor
                                    </h1>
                                </div>
                            </div>
                        </div>

                        <!-- RESPONSABLE -->
                        <div data-target=\"modal-responsable\" data-toggle=\"modal\" class=\"w-48 flex h-full items-center justify-center hover:shadow-md\">
                            <h1>$responsable</h1>
                        </div>

                        <!-- INICIO & FIN-->
                        <div class=\"w-64 flex h-full items-center justify-center hover:shadow-md\">
                            <input class=\"bg-white focus:outline-none focus:shadow-none py-2 px-4 block w-full appearance-none leading-normal font-semibold text-xs text-center\" type=\"text\" name=\"\" value=\"$fechaTarea\" disabled>
                        </div>

                        <!--  ADJUNTOS -->
                        <div onclick=\"obtenerAdjuntosTareas($idTarea);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1 class=\"font-xs\">$totalMedia</h1>
                        </div>

                        <!--  COMENTARIOS -->
                        <div onclick=\"obtenerComentariosTareas($idTarea);\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md\">
                            <h1>$totalComentarios</h1>
                        </div>

                        <!--  STATUS -->
                        <div onclick=\"actualizarTareas($idTarea,  'status', 'P');\" class=\"w-32 flex h-full items-center justify-center hover:shadow-md hover:bg-red-200 text-red-500 rounded-r-md\">
                            <div><i class=\"fas fa-undo fa-lg\"></i></div>
                        </div>
                    </div>
                ";
            }
            $data['dataTareas'] = $dataTareas;
            $data['contadorTareas'] = $contadorTareas;
        }
        echo json_encode($data);
    }


    // obtiene Adjuntos e Imagenes TAREAS
    if ($action == "obtenerAdjuntosTareas") {
        // Variables AJAX.
        $idTarea = $_POST['idTarea'];

        // Variables Locales.
        $data = array();
        $dataImagenes = "";
        $dataAdjuntos = "";

        $queryAdjuntos = "SELECT adjuntos_mp_np.id, adjuntos_mp_np.url, adjuntos_mp_np.fecha, 
        adjuntos_mp_np.id_usuario FROM adjuntos_mp_np 
        WHERE adjuntos_mp_np.id_mp_np = $idTarea AND adjuntos_mp_np.activo = 1";

        if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {

            foreach ($resultAdjuntos as $value) {
                $url = $value['url'];
                $idAdjunto = $value['id'];

                if (file_exists("../img/equipos/mpnp/$url")) {
                    $adjuntoURL = "img/equipos/mpnp/$url";
                } else {
                    $adjuntoURL = "";
                }

                // Admite solo Imagenes.
                if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {
                    $dataImagenes .= "
                        <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                            <a href=\"$adjuntoURL\" target=\"_blank\">
                                <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                </div>
                            </a>
                            
                            <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'TAREA');\">
                                    <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                            </div>
                        </div>
                    ";

                    // Admite todo, menos lo anterior.
                } else {

                    $dataAdjuntos .= "
                        <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                            <a href=\"$adjuntoURL\" target=\"_blank\">
                                <div class=\"rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2\">
                                    <i class=\"fad fa-file-alt fa-3x\"></i>
                                    <p class=\"text-sm font-normal ml-2\">$url</p>
                                </div>
                            </a>  

                            <div class=\"absolute text-red-700\" style=\"bottom: 22px; right: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'TAREA');\">
                                <i class=\"fas fa-trash-alt fa-2x\"></i>
                            </div>
                        </div>
                    ";
                }
            }
        }
        $data['dataImagenes'] = $dataImagenes;
        $data['dataAdjuntos'] = $dataAdjuntos;
        echo json_encode($data);
    }


    // obtiene Comentarios TAREAS.
    if ($action == "obtenerComentariosTareas") {
        // Variables AJAX.
        $idTarea = $_POST['idTarea'];

        // Variables Locales.
        $data = array();
        $dataComentarios = "";

        $queryComentario = "SELECT comentarios_mp_np.comentario, comentarios_mp_np.fecha, 
        t_colaboradores.nombre, t_colaboradores.apellido
        FROM comentarios_mp_np
        INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE comentarios_mp_np.id_mp_np = $idTarea AND comentarios_mp_np.activo = 1
        ORDER BY comentarios_mp_np.id DESC
        ";
        if ($resultComentario = mysqli_query($conn_2020, $queryComentario)) {
            foreach ($resultComentario as $value) {
                $comentario = $value['comentario'];
                $nombre = $value['nombre'];
                $apellido = $value['apellido'];
                $nombreCompleto = $value['nombre'] . " " . $value['apellido'];
                $fecha = $value['fecha'];

                if ($fecha != "") {
                    $fecha = (new DateTime($fecha))->format('d-m-Y H:m:s');
                } else {
                    $fecha = "";
                }

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


    // Agregar Comentario FALLAS o MC.
    if ($action == "agregarComentarioTarea") {
        // Variables AJAX.
        $idTarea = $_POST['idTarea'];
        $comentarioTarea = $_POST['comentarioTarea'];

        $query = "INSERT INTO comentarios_mp_np(id_mp_np, comentario, id_usuario, fecha) VALUES($idTarea, '$comentarioTarea', $idUsuario, '$fechaActual')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    // Actualiza la información de las Tareas
    if ($action == "actualizarTareas") {
        $columna = $_POST['columna'];
        $idTarea = $_POST['idTarea'];
        $valor = $_POST['valor'];
        $tituloNuevo = $_POST['tituloNuevo'];
        $resp = 0;

        if ($columna == "status_urgente" || $columna == "status_trabajando" || $columna == "departamento_calidad" || $columna == "departamento_compras" || $columna == "departamento_direccion" || $columna == "departamento_finanzas" || $columna == "departamento_rrhh" || $columna == "energetico_electricidad" || $columna == "energetico_agua" || $columna == "energetico_diesel" || $columna == "energetico_gas") {
            $query = "SELECT $columna FROM t_mp_np WHERE id =  $idTarea";
            if ($result = mysqli_query($conn_2020, $query)) {
                if ($row = mysqli_fetch_array($result))
                    $valorAnterior = $row[$columna];
                if ($valorAnterior == "0") {
                    $valorNuevo = 1;
                    $update = "UPDATE t_mp_np SET $columna = '$valorNuevo' WHERE id = $idTarea";
                    if ($result = mysqli_query($conn_2020, $update)) {
                        $resp = 1;
                    }
                } else {
                    $valorNuevo = 0;
                    $update = "UPDATE t_mp_np SET $columna = '$valorNuevo' WHERE id = $idTarea";
                    if ($result = mysqli_query($conn_2020, $update)) {
                        $resp = 1;
                    }
                }
            }
        } elseif ($columna == "status" and $valor == "F") {
            $update = "UPDATE t_mp_np SET status = 'F', fecha_finalizado = '$fechaActual'  
            WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $update)) {
                $resp = 2;
            }
        } elseif ($columna == "status" and $valor == "P") {
            $update = "UPDATE t_mp_np SET status = 'P' WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $update)) {
                $resp = 3;
            }
        } elseif ($columna == "activo" and $valor == "0") {
            $update = "UPDATE t_mp_np SET $columna = '0' WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $update)) {
                $resp = 4;
            }
        } elseif ($columna == "titulo" and $tituloNuevo != "") {
            $update = "UPDATE t_mp_np SET titulo = '$tituloNuevo' WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $update)) {
                $resp = 5;
            }
        } elseif ($columna == "rango_fecha" and $valor != "") {
            $update = "UPDATE t_mp_np SET rango_fecha = '$valor' WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $update)) {
                $resp = 6;
            }
        } elseif ($columna == "status_material") {
            $cod2bend = $_POST['cod2bend'];
            if ($cod2bend != "") {
                $valorX = 0;
                $query = "SELECT status_material FROM t_mp_np WHERE id = $idTarea";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $valorX = $x['status_material'];
                    }
                }
                if ($valorX == 0) {
                    $valor = 1;
                }
                $update = "UPDATE t_mp_np SET status_material = '$valor', cod2bend = '$cod2bend' WHERE id = $idTarea";
                if ($result = mysqli_query($conn_2020, $update)) {
                    $resp = 7;
                }
            }
        } elseif ($columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $valor = 1;
            $query = "SELECT $columna FROM t_mp_np WHERE id =  $idTarea";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valor = $x[$columna];
                }
            }
            if ($valor == 1) {
                $valor = 0;
            } else {
                $valor = 1;
            }
            $update = "UPDATE t_mp_np SET $columna = '$valor' WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $update)) {
                $resp = 8;
            }
        } elseif ($columna == "status_ep") {
            $valor = 0;
            $query = "SELECT status_ep FROM t_mp_np WHERE id =  $idTarea";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valor = $x['status_ep'];
                }
                if ($valor == 0) {
                    $valor = 1;
                } else {
                    $valor = 0;
                }
            }

            $update = "UPDATE t_mp_np SET status_ep = $valor WHERE id = $idTarea";
            if ($result = mysqli_query($conn_2020, $update)) {
                $resp = 9;
            }
        }

        // Respuesta Final
        echo $resp;
    }


    // Agrega una Nueva TAREA con Comentario(opcional).
    if ($action == "agregarTarea") {
        $idEquipo = $_POST['idEquipo'];
        $titulo = $_POST['titulo'];
        $responsable = $_POST['responsable'];
        $rangoFecha = $_POST['rangoFecha'];
        $comentario = $_POST['comentario'];
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];

        $query = "SELECT max(id) FROM t_mp_np";
        $id = 0;
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idUltimo = intval($value['max(id)']) + 1;
            }
            $query = "INSERT INTO t_mp_np(id, id_equipo, id_usuario, id_destino, id_seccion, id_subseccion, titulo, responsable, rango_fecha, fecha) 
            VALUES($idUltimo, $idEquipo, $idUsuario, $idDestino, $idSeccion, $idSubseccion, '$titulo', '$responsable', '$rangoFecha', '$fechaActual')";
            if ($result = mysqli_query($conn_2020, $query)) {
                if ($comentario != "" and $idUltimo > 0) {
                    $queryComentario = "INSERT INTO comentarios_mp_np(id_mp_np, id_usuario, comentario, fecha) 
                    VALUES($idUltimo, $idUsuario, '$comentario', '$fechaActual')";
                    if ($result = mysqli_query($conn_2020, $queryComentario)) {
                        echo 2;
                    } else {
                        echo 0;
                    }
                } else {
                    echo 1;
                }
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
    }


    // Obtiene los Proyectos PENDIENTES.
    if ($action == "obtenerProyectosP") {
        $data = array();
        $dataProyectos = "";
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $palabraProyecto = $_POST['palabraProyecto'];
        $tipoOrden = $_POST['tipoOrden'];
        $idResult = array();
        $total = array();

        // Filtro para Destinos
        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND t_proyectos.id_destino = $idDestino";
        }

        //Filtro para Buscar Proyecto 
        if ($palabraProyecto != "") {
            $filtroPalabreProyecto = "AND t_proyectos.titulo LIKE '%$palabraProyecto%'";
        } else {
            $filtroPalabreProyecto = "";
        }

        $contador = 0;
        if ($tipoOrden == "PROYECTO") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabreProyecto 
            ORDER BY titulo ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "PDA") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $id = $i['id'];
                    $queryTotalActividades = "SELECT count(id) FROM t_proyectos_planaccion 
                    WHERE id_proyecto = $id and activo = 1";
                    if ($resultTotalActividades = mysqli_query($conn_2020, $queryTotalActividades)) {
                        foreach ($resultTotalActividades as $i) {
                            $contador++;
                            $totalActividades = $i['count(id)'];
                            $total[] = $totalActividades;
                        }
                    }
                    $idResult[] = $id;
                }
            }
            array_multisort($total, SORT_DESC, $idResult);
        } elseif ($tipoOrden == "COT") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $id = $i['id'];
                    $queryTotalActividades = "SELECT count(id) FROM t_proyectos_adjuntos 
                    WHERE id_proyecto = $id and status = 1";
                    if ($resultTotalActividades = mysqli_query($conn_2020, $queryTotalActividades)) {
                        foreach ($resultTotalActividades as $i) {
                            $contador++;
                            $totalActividades = $i['count(id)'];
                            $total[] = $totalActividades;
                        }
                    }
                    $idResult[] = $id;
                }
            }
            array_multisort($total, SORT_DESC, $idResult);
        } elseif ($tipoOrden == "RESP") {
            $query = "SELECT t_proyectos.id 
            FROM t_proyectos 
            INNER JOIN t_users ON t_proyectos.responsable = t_users.id 
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE activo = 1 AND (t_proyectos.status = 'N' OR t_proyectos.status = 'PENDIENTE' OR 
            t_proyectos.status = 'P' OR t_proyectos.status = '') and t_proyectos.id_seccion = $idSeccion and t_proyectos.id_subseccion = $idSubseccion $filtroDestino $filtroPalabreProyecto ORDER BY t_colaboradores.nombre ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "TIPO") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabreProyecto ORDER BY tipo ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "JUST") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabreProyecto ORDER BY justificacion DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "COSTE") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabreProyecto ORDER BY coste DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "FECHA") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabreProyecto ORDER BY fecha_creacion DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        }

        // Obtiene el Total de Proyectos.
        $data['totalProyectos'] = $contador;


        // Obtiene el nombre de la SECCION
        $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $seccion = $value['seccion'];
                $data['seccion'] = $seccion;
            }
        }

        $data['idResult'] = $idResult;
        $x = "";

        // Convierte el Resultado en un arreglo

        foreach ($idResult as $i) {
            $x .= $i;
            $idProyecto = $i;
            $query = "SELECT t_proyectos.id, t_proyectos.titulo, t_colaboradores.nombre, t_colaboradores.apellido, t_proyectos.rango_fecha, t_proyectos.fecha_creacion,
            t_proyectos.tipo, t_proyectos.justificacion, t_proyectos.coste
            FROM t_proyectos 
            LEFT JOIN t_users ON t_proyectos.responsable = t_users.id
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_proyectos.id = $idProyecto";

            if ($result = mysqli_query($conn_2020, $query)) {

                foreach ($result as $value) {
                    $idProyecto = 0;
                    $idProyecto = $value['id'];
                    $titulo = $value['titulo'];
                    $responsable = strtok($value['nombre'], ' ') . " " . strtok($value['apellido'], ' ');
                    $rangoFecha = $value['rango_fecha'];
                    $fechaCreacion = (new DateTime($value['fecha_creacion']))->format('d-m-Y');
                    $tipo = $value['tipo'];
                    $justificacion = $value['justificacion'];
                    $coste = $value['coste'];

                    if ($responsable == "Sin Responsable") {
                        $queryResponsable = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                        FROM t_tareas_asignaciones 
                        LEFT JOIN t_users ON t_tareas_asignaciones.id_usuario = t_users.id 
                        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                        WHERE t_tareas_asignaciones.id_tarea = $idProyecto";
                        if ($resultResponsable = mysqli_query($conn_2020, $queryResponsable)) {
                            $responsableTemp = "Sin Responsable";
                            foreach ($resultResponsable as $i) {
                                $responsableTemp = strtok($i['nombre'], ' ') . " " . strtok($i['apellido'], ' ');
                            }
                            if ($responsableTemp != "" or $responsableTemp == "Sin Responsable") {
                                $responsable = $responsableTemp;
                            }
                        }
                    }

                    $queryAdjuntos = "SELECT count(id) FROM t_proyectos_adjuntos WHERE id_proyecto = $idProyecto AND status = 1";
                    if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {
                        foreach ($resultAdjuntos as $value) {
                            $totalAdjuntos = $value['count(id)'];
                        }
                    }

                    $queryPlanaccionTotal = "SELECT count(id) FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto AND activo = 1";

                    $queryPlanaccionF = "SELECT count(id) FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto AND activo = 1 and status = 'F'";

                    if (
                        $resultPlanaccionTotal = mysqli_query($conn_2020, $queryPlanaccionTotal) and
                        $resultPlanaccionF = mysqli_query($conn_2020, $queryPlanaccionF)
                    ) {

                        foreach ($resultPlanaccionTotal as $value) {
                            $totalPlanaccionTotal = $value['count(id)'];
                        }

                        foreach ($resultPlanaccionF as $value) {
                            $totalPlanaccionF = $value['count(id)'];
                        }

                        if (($totalPlanaccionTotal <= 0 or $totalPlanaccionTotal == "") and
                            ($totalPlanaccionF <= 0 or $totalPlanaccionF == "")
                        ) {
                            $PDA = "<i class=\"fas fa-window-minimize\"></i>";
                            $bgTotalPlanaccion = "bg-white";
                        } else {
                            $PDA = "$totalPlanaccionF / $totalPlanaccionTotal";
                            $bgTotalPlanaccion = "text-green-500 bg-green-200";
                        }
                    }

                    if ($totalAdjuntos <= 0 or $totalAdjuntos == "") {
                        $bgAdjuntos = "bg-white";
                        $totalAdjuntos = "<i class=\"fas fa-window-minimize\"></i>";
                    } else {
                        $bgAdjuntos = "bg-orange-200 text-orange-500";
                    }

                    if ($rangoFecha == "") {
                        $rangoFecha = "$fechaCreacion - <br>$fechaCreacion";
                    }

                    if ($justificacion == "" or $justificacion == " ") {
                        $bgJustificacion = "bg-white";
                        $justificacion = "<i class=\"fas fa-window-minimize\"></i>";
                    } else {
                        $bgJustificacion = "bg-green-200 text-green-500";
                        $justificacion = "<i class=\"fas as fa-check\"></i>";
                    }

                    if ($coste < 0 or $coste == "") {
                        $coste = "<i class=\"fas fa-window-minimize\"></i>";
                    }

                    if ($tipo == "") {
                        $tipo = "<i class=\"fas fa-window-minimize\"></i>";
                    }

                    // PROYECTOS
                    $dataProyectos .= "
                        <div class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\" style=\"display:flex;\">
                            <div id=\"proyecto$idProyecto\" onclick=\"expandirProyectos(this.id, $idProyecto)\" class=\"w-2/5 h-full flex flex-row items-center justify-between bg-purple-200 text-purple-700 rounded-l-md cursor-pointer truncate\">
                                <div class=\"flex flex-row items-center\">
                                    <i class=\"fad fa-scrubber mx-2 text-red-500\"></i>
                                    <h1 id=\"tituloP$idProyecto\">$titulo</h1>
                                </div>
                                <div  class=\"mx-2\">
                                    <i id=\"icono$idProyecto\" class=\"fas fa-chevron-right\"></i>
                                </div>
                            </div>
                            <div class=\"w-24 h-full flex items-center justify-center $bgTotalPlanaccion\" onclick=\"expandirProyectos('proyecto$idProyecto', $idProyecto)\">
                                $PDA
                            </div>
                            <div class=\"w-32 flex h-full items-center justify-center leading-none text-center text-xxs font-bold\"
                            onclick=\"obtenerResponsablesProyectos($idProyecto);\">
                                <h1>$responsable</h1>
                            </div>
                            <div class=\"w-24 flex h-full items-center justify-center text-xxs text-center\" onclick=\"obtenerDatoProyectos($idProyecto,'rango_fecha');\">
                                <h1>$rangoFecha</h1>
                            </div>
                            <div class=\"w-24 flex h-full items-center justify-center $bgAdjuntos\" onclick=\"cotizacionesProyectos($idProyecto);\">
                                <h1>$totalAdjuntos</h1>
                            </div>
                            <div class=\"w-24 flex h-full items-center justify-center font-bold\" onclick=\"obtenerDatoProyectos($idProyecto,'tipo');\">
                                <h1>$tipo</h1>
                            </div>
                            <div class=\"w-24 h-full flex items-center justify-center $bgJustificacion\" onclick=\"obtenerDatoProyectos($idProyecto,'justificacion');\">
                                $justificacion
                            </div>
                            <div class=\"w-24 flex h-full items-center justify-center font-bold\" onclick=\"obtenerDatoProyectos($idProyecto,'coste');\">
                                <h1>$coste</h1>
                            </div>
                            <div class=\"w-24 flex h-full items-center justify-center hover:shadow-md hover:bg-teal-200 text-teal-500 rounded-r-md\" onclick=\"statusProyecto($idProyecto);\">
                                <div><i class=\"fad fa-exclamation-circle fa-lg\"></i></div>
                            </div>
                        </div>
                    ";
                    // PROYECTOS


                    // ENCABEZADO PRINCIPAL PLANACCION
                    $dataProyectos .= "
                        <div id=\"proyecto" . $idProyecto . "toggle\" class=\"hidden w-full mb-2 text-xxs px-6 py-2 bg-fondos-7 border-b border-r border-l rounded-b-md flex flex-col items-center justify-center my-1\">


                            <div class=\"w-full flex py-1\">
                                <input id=\"NA$idProyecto\" type=\"text\" name=\"\" placeholder=\"Añadir Actividad\" class=\"px-2 w-1/4 text-bluegray-900 text-xs leading-none font-semibold rounded-l py-1\" autocomplete=\"off\">
                                <button class=\" px-2 py-1 bg-indigo-300 text-indigo-500 font-bold rounded-r\" onclick=\"agregarPlanaccion($idProyecto);\">Añadir</button>
                                <button class=\" px-2 py-1 bg-teal-300 text-teal-500 font-bold ml-2 rounded\" onclick=\"classNameToggle('actividades$idProyecto');\">Ver
                                    solucionados</button>

                                <button onclick=\"generarReporteProyecto('excel', $idProyecto)\" class=\"px-2 py-1 bg-orange-300 text-orange-500 font-bold ml-2 rounded\"> 
                                    Generar Excel
                                </button>

                                <button onclick=\"generarReporteProyecto('pdf', $idProyecto)\" class=\"px-2 py-1 bg-orange-300 text-orange-500 font-bold ml-2 rounded\"> 
                                    Generar PDF
                                </button>

                            </div>
                    ";

                    // ENCABEZADO ACTIVIDADES PLANACCION
                    $dataProyectos .= "
                        <div class=\"w-full\">
                            <div class=\"flex items-center font-bold text-xxs text-bluegray-500 cursor-pointer w-full justify-start px-3 rounded\">
                                <div class=\"w-3/4 h-full flex items-center justify-start \">
                                    <h1>ACTIVIDAD</h1>
                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\">
                                    <h1>RESPONSABLE</h1>
                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\">
                                    <h1>COMENTARIOS</h1>
                                </div>

                                <div class=\"w-24 h-full flex items-center justify-center\">
                                    <h1>ADJUNTOS</h1>
                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\">
                                    <h1>STATUS</h1>
                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\">
                                    <h1>ÁREA</h1>
                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\">
                                    <h1>UND</h1>
                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\">
                                    <h1>CANTIDAD</h1>
                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\">
                                    <h1>COSTE UNIT USD</h1>
                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\">
                                    <h1>COSTE TOTAL USD</h1>
                                </div>

                            </div>

                            <div class=\"w-full flex flex-col rounded\">
                    ";

                    //ACTIVIDADES PLANACCION 
                    $queryPlanaccion = "SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.status, t_colaboradores.nombre, t_colaboradores.apellido, t_proyectos_planaccion.responsable, t_proyectos_planaccion.fecha_creacion,
                    t_proyectos_planaccion.status_urgente,
                    t_proyectos_planaccion.status_material,
                    t_proyectos_planaccion.status_trabajando,
                    t_proyectos_planaccion.energetico_electricidad,
                    t_proyectos_planaccion.energetico_agua,
                    t_proyectos_planaccion.energetico_diesel,
                    t_proyectos_planaccion.energetico_gas,
                    t_proyectos_planaccion.departamento_calidad,
                    t_proyectos_planaccion.departamento_compras,
                    t_proyectos_planaccion.departamento_direccion,
                    t_proyectos_planaccion.departamento_finanzas,
                    t_proyectos_planaccion.departamento_rrhh,
                    t_proyectos_planaccion.area,
                    t_proyectos_planaccion.unidad_medida,
                    t_proyectos_planaccion.cantidad,
                    t_proyectos_planaccion.coste
                    FROM t_proyectos_planaccion
                    LEFT JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
                    LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_proyectos_planaccion.activo = 1 AND t_proyectos_planaccion.id_proyecto = $idProyecto
                    ORDER BY t_proyectos_planaccion.id DESC
                    ";
                    if ($resultPlanaccion = mysqli_query($conn_2020, $queryPlanaccion)) {
                        foreach ($resultPlanaccion as $value) {
                            $idPlanaccion = $value['id'];
                            $actividad = $value['actividad'];
                            $creadoPor = $value['nombre'] . " " . $value['apellido'];
                            $fecha = $value['fecha_creacion'];
                            $idResponsable = $value['responsable'];
                            $status = $value['status'];
                            $sUrgente = $value['status_urgente'];
                            $sMaterial = $value['status_material'];
                            $sTrabajando = $value['status_trabajando'];
                            $eElectricidad = $value['energetico_electricidad'];
                            $eAgua = $value['energetico_agua'];
                            $eDiesel = $value['energetico_diesel'];
                            $eGas = $value['energetico_gas'];
                            $dCalidad = $value['departamento_calidad'];
                            $dCompras = $value['departamento_compras'];
                            $dDireccion = $value['departamento_direccion'];
                            $dFinanzas = $value['departamento_finanzas'];
                            $dRRHH = $value['departamento_rrhh'];
                            $area = $value['area'];
                            $unidad = $value['unidad_medida'];
                            $cantidad = $value['cantidad'];
                            $coste = $value['coste'];
                            $total = $cantidad * $coste;

                            if ($fecha == "" or $fecha == " ") {
                                $fecha = "-";
                            }

                            if ($status == "F" or $status == "FINALIZADO" or $status == "SOLUCIONADO") {
                                $solucionados = "actividades$idProyecto hidden";
                            } else {
                                $solucionados = "";
                            }

                            //Status, Energeticos y Departamentos. 
                            if ($sUrgente == 1 or $sUrgente != "0") {
                                $sUrgente = "";
                            } else {
                                $sUrgente = "hidden";
                            }

                            if ($sMaterial == 1 or $sMaterial != "0") {
                                $sMaterial = "";
                            } else {
                                $sMaterial = "hidden";
                            }

                            if ($sTrabajando == 1 or $sTrabajando != "0") {
                                $sTrabajando = "";
                            } else {
                                $sTrabajando = "hidden";
                            }

                            if ($eElectricidad == 1 or $eElectricidad != "0") {
                                $eElectricidad = "";
                            } else {
                                $eElectricidad = "hidden";
                            }

                            if ($eAgua == 1 or $eAgua != "0") {
                                $eAgua = "";
                            } else {
                                $eAgua = "hidden";
                            }

                            if ($eDiesel == 1 or $eDiesel != "0") {
                                $eDiesel = "";
                            } else {
                                $eDiesel = "hidden";
                            }

                            if ($eGas == 1 or $eGas != "0") {
                                $eGas = "";
                            } else {
                                $eGas = "hidden";
                            }

                            if ($dCalidad == 1 or $dCalidad != "0") {
                                $dCalidad = "";
                            } else {
                                $dCalidad = "hidden";
                            }

                            if ($dCompras == 1 or $dCompras != "0") {
                                $dCompras = "";
                            } else {
                                $dCompras = "hidden";
                            }

                            if ($dDireccion == 1 or $dDireccion != "0") {
                                $dDireccion = "";
                            } else {
                                $dDireccion = "hidden";
                            }

                            if ($dFinanzas == 1 or $dFinanzas != "0") {
                                $dFinanzas = "";
                            } else {
                                $dFinanzas = "hidden";
                            }

                            if ($dRRHH == 1 or $dRRHH != "0") {
                                $dRRHH = "";
                            } else {
                                $dRRHH = "hidden";
                            }

                            // RESPONSABLE DE LA ACTIVIDAD
                            $queryResponsable = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                            FROM t_users
                            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                            WHERE t_users.id = $idResponsable
                            ";
                            if ($resultResponsable = mysqli_query($conn_2020, $queryResponsable)) {
                                foreach ($resultResponsable as $value) {
                                    $responsable = $value['nombre'] . " " . $value['apellido'];
                                }
                            } else {
                                $responsable = "";
                            }

                            // TOTAL DE COMENTARIOS
                            $queryComentarios = "SELECT count(id) FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $idPlanaccion";
                            if ($resultComentarios = mysqli_query($conn_2020, $queryComentarios)) {
                                foreach ($resultComentarios as $value) {
                                    $totalComentarios = $value['count(id)'];
                                }
                                if ($totalComentarios <= 0) {
                                    $totalComentarios = "<i class=\"fas fa-window-minimize\"></i>";
                                }
                            }

                            // TOTAL DE ADJUNTOS
                            $queryAdjuntos = "SELECT count(id) FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idPlanaccion and status = 1";
                            if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {
                                foreach ($resultAdjuntos as $value) {
                                    $totalAdjuntos = $value['count(id)'];
                                }

                                if ($totalAdjuntos <= 0) {
                                    $totalAdjuntos = "<i class=\"fas fa-window-minimize\"></i>";
                                }
                            }

                            if ($status == "F" or $status == "FINALIZADO" or $status == "SOLUCIONADO") {
                                // Actividades PLANAACION PENDIENTE
                                $dataProyectos .= "     

                                    <div class=\"$solucionados bg-white text-bluegray-700 flex items-center font-semibold text-xxs cursor-pointer w-full justify-start my-1 rounded relative px-3\">

                                        <div class=\"truncate w-3/4 flex flex-row items-center justify-between cursor-pointer relative\">

                                            <div class=\" hidden absolute\" style=\"left:0%;\">
                                                <i class=\"fas fa-siren-on animated flash infinite fa-rotate-270\"></i>
                                            </div>

                                            <div class=\"absolute flex hover:opacity-25\" style=\"right: 0%; font-size: 9px; mr-5\">
                                        
                                                <div class=\"$sMaterial bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                                    <h1 class=\"\">M</h1>
                                                </div>
                                                
                                                <div class=\"$sTrabajando bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                                    <h1 class=\"\">T</h1>
                                                </div>
                                                
                                                <div class=\"$eElectricidad bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                                    <h1 class=\"\">Electricidad</h1>
                                                </div>
                                                
                                                <div class=\"$eAgua bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                                    <h1 class=\"\">Agua</h1>
                                                </div>
                                            
                                                <div class=\"$eGas bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                                    <h1 class=\"\">Gas</h1>
                                                </div>
                                                
                                                <div class=\"$eDiesel bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                                    <h1 class=\"\">Diesel</h1>
                                                </div>
                                                
                                                <div class=\"$dDireccion bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">Dirección</h1>
                                                </div>
                                                
                                                <div class=\"$dRRHH bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">RRHH</h1>
                                                </div>
                                                
                                                <div class=\"$dFinanzas bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">Finanzas</h1>
                                                </div>
                                                
                                                <div class=\"$dCompras bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">Compras</h1>
                                                </div>
                                                
                                                <div class=\"$dCalidad bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">Calidad</h1>
                                                </div>

                                            </div>

                                            <div class=\"w-3/4 flex flex-col items-center justify-center\">
                                                <div class=\"w-full leading-none pt-1 uppercase text-xs truncate flex relative\">
                                                    <i class=\"fas fa-dot-circle mr-1 text-green-400\"></i>
                                                    <h1 id=\"AP$idPlanaccion\">$actividad</h1>
                                                </div>
                                                <div class=\"self-start\">
                                                    <h1>$creadoPor - $fecha</h1>
                                                </div>
                                            </div>                                       

                                        </div>

                                        <div class=\"w-32 flex h-full items-center justify-center\" 
                                        onclick=\"obtenerResponsablesPlanaccion($idPlanaccion);\"> 
                                            <h1>$responsable</h1>
                                        </div>
                                        <div class=\"w-32 flex h-full items-center justify-center\" onclick=\"comentariosPlanaccion($idPlanaccion);\">
                                            <h1>$totalComentarios</h1>
                                        </div>
                                        <div class=\"w-24 h-full flex items-center justify-center\" onclick=\"adjuntosPlanaccion($idPlanaccion);\">
                                            <h1>$totalAdjuntos</h1>
                                        </div>
                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\" onclick=\"actualizarPlanaccion('N','status',$idPlanaccion)\">
                                            <div><i class=\"fas fa-undo fa-lg text-red-500\"></i></div>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"area$idPlanaccion\" type=\"text\" placeholder=\"Área\" value=\"$area\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'area$idPlanaccion', 'area');\">
                                            </h1>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"unidad$idPlanaccion\" type=\"text\" placeholder=\"Unidad\" value=\"$unidad\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'unidad$idPlanaccion', 'unidad');\">
                                            </h1>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"cantidad$idPlanaccion\" type=\"text\" placeholder=\"Coste\" value=\"$cantidad\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'cantidad$idPlanaccion', 'cantidad');\">
                                            </h1>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"coste$idPlanaccion\" type=\"text\" placeholder=\"Coste\" value=\"$coste\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'coste$idPlanaccion', 'coste');\">
                                            </h1>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"costeTotal$idPlanaccion\" type=\"text\" placeholder=\"Coste\" value=\"$total\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'costeTotal$idPlanaccion', 'costeTotal');\" disabled>
                                            </h1>
                                        </div>

                                    </div>
                                ";
                                // Actividades PLANAACION PENDIENTE
                            } else {
                                // Actividades PLANAACION SOLUCIONADO
                                $dataProyectos .= "            
                                    <div class=\"$solucionados bg-white text-bluegray-700 flex items-center font-semibold text-xxs cursor-pointer w-full justify-start px-3 my-1 rounded\">
                                        <div class=\"truncate w-3/4 flex flex-row items-center justify-between cursor-pointer relative\">

                                            <div class=\" hidden absolute\" style=\"left:0%;\">
                                                <i class=\"fas fa-siren-on animated flash infinite fa-rotate-270\"></i>
                                            </div>

                                            <div class=\"absolute flex hover:opacity-25\" style=\"right: 0%; font-size: 9px; mr-5\">
                                        
                                                <div class=\"$sMaterial bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                                    <h1 class=\"\">M</h1>
                                                </div>
                                                
                                                <div class=\"$sTrabajando bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                                    <h1 class=\"\">T</h1>
                                                </div>
                                                
                                                <div class=\"$eElectricidad bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                                    <h1 class=\"\">Electricidad</h1>
                                                </div>
                                                
                                                <div class=\"$eAgua bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                                    <h1 class=\"\">Agua</h1>
                                                </div>
                                            
                                                <div class=\"$eGas bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                                    <h1 class=\"\">Gas</h1>
                                                </div>
                                                
                                                <div class=\"$eDiesel bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                                    <h1 class=\"\">Diesel</h1>
                                                </div>
                                                
                                                <div class=\"$dDireccion bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">Dirección</h1>
                                                </div>
                                                
                                                <div class=\"$dRRHH bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">RRHH</h1>
                                                </div>
                                                
                                                <div class=\"$dFinanzas bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">Finanzas</h1>
                                                </div>
                                                
                                                <div class=\"$dCompras bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">Compras</h1>
                                                </div>
                                                
                                                <div class=\"$dCalidad bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                                    <h1 class=\"\">Calidad</h1>
                                                </div>

                                            </div>

                                            <div class=\"w-3/4 flex flex-col items-center justify-center\">
                                                <div class=\"w-full leading-none pt-1 uppercase text-xs truncate flex relative\">
                                                    <i class=\"fas fa-dot-circle mr-1 text-red-400\"></i>
                                                    <h1 id=\"AP$idPlanaccion\">$actividad</h1>
                                                </div>
                                                <div class=\"self-start\">
                                                    <h1>$creadoPor - $fecha</h1>
                                                </div>
                                            </div>                                       

                                        </div>
                                        <div class=\"w-32 flex h-full items-center justify-center\" 
                                        onclick=\"obtenerResponsablesPlanaccion($idPlanaccion);\"> 
                                            <h1>$responsable</h1>
                                        </div>
                                        <div class=\"w-32 flex h-full items-center justify-center\" onclick=\"comentariosPlanaccion($idPlanaccion);\">
                                            <h1>$totalComentarios</h1>
                                        </div>
                                        <div class=\"w-24 h-full flex items-center justify-center\" onclick=\"adjuntosPlanaccion($idPlanaccion);\">
                                            <h1>$totalAdjuntos</h1>
                                        </div>
                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\" onclick=\"statusPlanaccion($idPlanaccion);\">
                                            <div><i class=\"fa fa-exclamation-circle fa-lg\"></i></div>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"area$idPlanaccion\" type=\"text\" placeholder=\"Área\" value=\"$area\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'area$idPlanaccion', 'area');\">
                                            </h1>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"unidad$idPlanaccion\" type=\"text\" placeholder=\"Unidad\" value=\"$unidad\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'unidad$idPlanaccion', 'unidad');\">
                                            </h1>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"cantidad$idPlanaccion\" type=\"text\" placeholder=\"Coste\" value=\"$cantidad\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'cantidad$idPlanaccion', 'cantidad');\">
                                            </h1>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"coste$idPlanaccion\" type=\"text\" placeholder=\"Coste\" value=\"$coste\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'coste$idPlanaccion', 'coste');\">
                                            </h1>
                                        </div>

                                        <div class=\"w-32 h-full flex items-center justify-center rounded-r-md\">
                                            <h1>
                                                <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"costeTotal$idPlanaccion\" type=\"text\" placeholder=\"Coste\" value=\"$total\" onkeyup=\"actualizarPlanaccionReporte($idPlanaccion, 'costeTotal$idPlanaccion', 'costeTotal');\" disabled>
                                            </h1>
                                        </div>

                                    </div>
                                ";
                                // Actividades PLANAACION SOLUCIONADO                            
                            }
                        }
                    }

                    // CIERRE DE ENCABEZADOS
                    $dataProyectos .= "
                                </div>
                            </div>
                        </div>
                    ";
                }
            }
        }
        $data['dataProyectos'] = $dataProyectos;
        $data['x'] = $x;
        echo json_encode($data);
    }


    // Obtiene los Proyectos SOLUCIONADOS
    if ($action == "obtenerProyectosS") {
        $data = array();
        $dataProyectos = "";
        $idSeccion = $_POST['idSeccion'];
        $idSubseccion = $_POST['idSubseccion'];
        $palabraProyecto = $_POST['palabraProyecto'];
        $tipoOrden = $_POST['tipoOrden'];
        $idResult = array();
        $total = array();


        // Filtro para Destinos
        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND t_proyectos.id_destino = $idDestino";
        }

        //Filtro para Buscar Proyecto 
        if ($palabraProyecto != "") {
            $filtroPalabraProyecto = "AND t_proyectos.titulo LIKE '%$palabraProyecto%'";
        } else {
            $filtroPalabraProyecto = "";
        }

        $contador = 0;
        if ($tipoOrden == "PROYECTO") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND(t_proyectos.status = 'F' OR t_proyectos.status = 'FINALIZADO' OR t_proyectos.status = 'SOLUCIONADOS') AND id_seccion = $idSeccion AND id_subseccion = $idSubseccion $filtroDestino $filtroPalabraProyecto 
            ORDER BY titulo ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "PDA") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabraProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $id = $i['id'];
                    $queryTotalActividades = "SELECT count(id) FROM t_proyectos_planaccion 
                    WHERE id_proyecto = $id and activo = 1";
                    if ($resultTotalActividades = mysqli_query($conn_2020, $queryTotalActividades)) {
                        foreach ($resultTotalActividades as $i) {
                            $contador++;
                            $totalActividades = $i['count(id)'];
                            $total[] = $totalActividades;
                        }
                    }
                    $idResult[] = $id;
                }
            }
            array_multisort($total, SORT_DESC, $idResult);
        } elseif ($tipoOrden == "COT") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabraProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $id = $i['id'];
                    $queryTotalActividades = "SELECT count(id) FROM t_proyectos_adjuntos 
                    WHERE id_proyecto = $id and status = 1";
                    if ($resultTotalActividades = mysqli_query($conn_2020, $queryTotalActividades)) {
                        foreach ($resultTotalActividades as $i) {
                            $contador++;
                            $totalActividades = $i['count(id)'];
                            $total[] = $totalActividades;
                        }
                    }
                    $idResult[] = $id;
                }
            }
            array_multisort($total, SORT_DESC, $idResult);
        } elseif ($tipoOrden == "RESP") {
            $query = "SELECT t_proyectos.id 
            FROM t_proyectos 
            INNER JOIN t_users ON t_proyectos.responsable = t_users.id 
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE activo = 1 AND (t_proyectos.status = 'N' OR t_proyectos.status = 'PENDIENTE' OR 
            t_proyectos.status = 'P' OR t_proyectos.status = '') and t_proyectos.id_seccion = $idSeccion and t_proyectos.id_subseccion = $idSubseccion $filtroDestino $filtroPalabraProyecto ORDER BY t_colaboradores.nombre ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "TIPO") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabraProyecto ORDER BY tipo ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "JUST") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabraProyecto ORDER BY justificacion DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "COSTE") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabraProyecto ORDER BY coste DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        } elseif ($tipoOrden == "FECHA") {
            $query = "SELECT id FROM t_proyectos WHERE activo = 1 AND (status = 'N' OR status = 'PENDIENTE' OR status = 'P' OR status = '') and id_seccion = $idSeccion and id_subseccion = $idSubseccion $filtroDestino $filtroPalabraProyecto ORDER BY fecha_creacion DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $idProyecto = $i['id'];

                    // Se agregan los ID en el arreglo
                    $idResult[] = $idProyecto;
                }
            }
        }

        // Obtiene el Total de Proyectos.
        $data['totalProyectos'] = $contador;

        // Obtiene el nombre de la SECCION
        $query = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $seccion = $value['seccion'];
                $data['seccion'] = $seccion;
            }
        }

        foreach ($idResult as $i) {
            $idProyecto = $i;
            $query = "SELECT t_proyectos.id, t_proyectos.titulo, t_colaboradores.nombre, t_colaboradores.apellido, t_proyectos.rango_fecha, t_proyectos.fecha_creacion, t_proyectos.tipo, t_proyectos.justificacion, t_proyectos.coste
            FROM t_proyectos 
            LEFT JOIN t_users ON t_proyectos.responsable = t_users.id
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_proyectos.activo = 1 AND t_proyectos.id = $idProyecto
            ";

            if ($result = mysqli_query($conn_2020, $query)) {

                foreach ($result as $value) {
                    // $idProyecto = 0;
                    $idProyecto = $value['id'];
                    $titulo = $value['titulo'];
                    $responsable = strtok($value['nombre'], ' ') . " " . strtok($value['apellido'], ' ');
                    $rangoFecha = $value['rango_fecha'];
                    $fechaCreacion = (new DateTime($value['fecha_creacion']))->format('d-m-Y');
                    $tipo = $value['tipo'];
                    $justificacion = $value['justificacion'];
                    $coste = $value['coste'];

                    if ($responsable == "Sin Responsable") {
                        $queryResponsable = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                        FROM t_tareas_asignaciones 
                        LEFT JOIN t_users ON t_tareas_asignaciones.id_usuario = t_users.id 
                        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                        WHERE t_tareas_asignaciones.id_tarea = $idProyecto";
                        if ($resultResponsable = mysqli_query($conn_2020, $queryResponsable)) {
                            $responsableTemp = "Sin Responsable";
                            foreach ($resultResponsable as $i) {
                                $responsableTemp = strtok($i['nombre'], ' ') . " " . strtok($i['apellido'], ' ');
                            }
                            if ($responsableTemp != "" or $responsableTemp == "Sin Responsable") {
                                $responsable = $responsableTemp;
                            }
                        }
                    }


                    $queryAdjuntos = "SELECT count(id) FROM t_proyectos_adjuntos WHERE id_proyecto = $idProyecto AND status = 1";
                    if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {
                        foreach ($resultAdjuntos as $value) {
                            $totalAdjuntos = $value['count(id)'];
                        }
                    }


                    $queryPlanaccionTotal = "SELECT count(id) FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto AND activo = 1";

                    $queryPlanaccionF = "SELECT count(id) FROM t_proyectos_planaccion WHERE id_proyecto = $idProyecto AND activo = 1 and status = 'F'";

                    if (
                        $resultPlanaccionTotal = mysqli_query($conn_2020, $queryPlanaccionTotal) and
                        $resultPlanaccionF = mysqli_query($conn_2020, $queryPlanaccionF)
                    ) {

                        foreach ($resultPlanaccionTotal as $value) {
                            $totalPlanaccionTotal = $value['count(id)'];
                        }

                        foreach ($resultPlanaccionF as $value) {
                            $totalPlanaccionF = $value['count(id)'];
                        }

                        if (($totalPlanaccionTotal <= 0 or $totalPlanaccionTotal == "") and
                            ($totalPlanaccionF <= 0 or $totalPlanaccionF == "")
                        ) {
                            $PDA = "<i class=\"fas fa-window-minimize\"></i>";
                            $bgTotalPlanaccion = "bg-white";
                        } else {
                            $PDA = "$totalPlanaccionF / $totalPlanaccionTotal";
                            $bgTotalPlanaccion = "text-green-500 bg-green-200";
                        }
                    }

                    if ($totalAdjuntos <= 0 or $totalAdjuntos == "") {
                        $bgAdjuntos = "bg-white";
                        $totalAdjuntos = "<i class=\"fas fa-window-minimize\"></i>";
                    } else {
                        $bgAdjuntos = "bg-orange-200 text-orange-500";
                    }

                    if ($rangoFecha == "") {
                        $rangoFecha = "$fechaCreacion - <br> $fechaCreacion";
                    }

                    if ($justificacion == "" or $justificacion == " ") {
                        $bgJustificacion = "bg-white";
                        $justificacion = "<i class=\"fas fa-window-minimize\"></i>";
                    } else {
                        $bgJustificacion = "bg-green-200 text-green-500";
                        $justificacion = "<i class=\"fas as fa-check\"></i>";
                    }

                    if ($coste < 0 or $coste == "") {
                        $coste = "<i class=\"fas fa-window-minimize\"></i>";
                    }

                    if ($tipo == "") {
                        $tipo = "<i class=\"fas fa-window-minimize\"></i>";
                    }

                    // PROYECTOS
                    $dataProyectos .= "
                    <div class=\"mt-2 w-full flex flex-row justify-center items-center font-semibold text-xs h-8 text-bluegray-500 cursor-pointer\" style=\"display:flex;\">
                        <div id=\"proyecto$idProyecto\" onclick=\"expandirProyectos(this.id, $idProyecto)\" class=\"w-2/5 h-full flex flex-row items-center justify-between bg-teal-100 text-teal-500 rounded-l-md cursor-pointer truncate\">
                            <div class=\" flex flex-row items-center\">
                                <i class=\"fad fa-scrubber mx-2 text-green-500\"></i>
                                <h1 id=\"tituloP$idProyecto\">$titulo</h1>
                            </div>
                            <div  class=\"mx-2\">
                                <i id=\"icono$idProyecto\" class=\"fas fa-chevron-right\"></i>
                            </div>
                        </div>
                        <div class=\"$bgTotalPlanaccion w-24 h-full flex items-center justify-center\" onclick=\"expandirProyectos('proyecto$idProyecto', $idProyecto)\">
                            $PDA
                        </div>
                        <div class=\"w-32 flex h-full items-center justify-center leading-none text-center text-xxs font-bold\"
                        onclick=\"obtenerResponsablesProyectos($idProyecto);\">
                            <h1>$responsable</h1>
                        </div>
                        <div class=\"w-24 flex h-full items-center justify-center text-xxs text-center\" onclick=\"obtenerDatoProyectos($idProyecto,'rango_fecha');\">
                            <h1>$rangoFecha</h1>
                        </div>
                        <div class=\"$bgAdjuntos w-24 flex h-full items-center justify-center\" onclick=\"cotizacionesProyectos($idProyecto);\">
                            <h1>$totalAdjuntos</h1>
                        </div>
                        <div class=\"w-24 flex h-full items-center justify-center font-bold\" onclick=\"obtenerDatoProyectos($idProyecto,'tipo');\">
                            <h1>$tipo</h1>
                        </div>
                        <div class=\"$bgJustificacion w-24 h-full flex items-center justify-center\" onclick=\"obtenerDatoProyectos($idProyecto,'justificacion');\">
                            $justificacion
                        </div>
                        <div class=\"w-24 flex h-full items-center justify-center font-bold\" onclick=\"obtenerDatoProyectos($idProyecto,'coste');\">
                            <h1>$coste</h1>
                        </div>
                        
                        <div class=\"w-24 flex h-full items-center justify-center hover:shadow-md hover:bg-teal-200 text-teal-500 rounded-r-md\" onclick=\"actualizarProyectos('N', 'status', $idProyecto);\">
                            <div><i class=\"fas fa-undo fa-lg text-red-500\"></i></div>
                        </div>
                    </div>
                ";
                    // PROYECTOS


                    // ENCABEZADO PRINCIPAL PLANACCION
                    $dataProyectos .= "
                    <div id=\"proyecto" . $idProyecto . "toggle\" class=\"hidden w-full mb-2 text-xxs px-6 py-2 bg-fondos-7 border-b border-r border-l rounded-b-md flex flex-col items-center justify-center my-1\">

                        <div class=\"w-full flex py-1\">
                            <input id=\"NA$idProyecto\" type=\"text\" name=\"\" placeholder=\"Añadir Actividad\" class=\"px-2 w-1/4 text-bluegray-900 uppercase text-xs leading-none font-semibold rounded-l py-1\" autocomplete=\"off\">
                            <button class=\" px-2 py-1 bg-indigo-300 text-indigo-500 font-bold uppercase rounded-r\">Añadir</button>
                            <button class=\" px-2 py-1 bg-teal-300 text-teal-500 font-bold uppercase ml-2 rounded\" onclick=\"classNameToggle('actividades$idProyecto');\">Ver
                                solucionados</button>
                            
                            <button onclick=\"generarReporteProyecto('excel', $idProyecto)\" class=\"px-2 py-1 bg-orange-300 text-orange-500 font-bold ml-2 rounded\"> 
                                Generar Excel
                            </button>

                            <button onclick=\"generarReporteProyecto('pdf', $idProyecto)\" class=\"px-2 py-1 bg-orange-300 text-orange-500 font-bold ml-2 rounded\"> 
                                Generar PDF
                            </button>

                        </div>
                ";

                    // ENCABEZADO ACTIVIDADES PLANACCION
                    $dataProyectos .= "
                    <div class=\"w-full\">
                        <div class=\"flex items-center font-bold text-xxs text-bluegray-500 cursor-pointer w-full justify-start px-3 rounded\">
                            <div class=\"w-3/4 h-full flex items-center justify-start \">
                                <h1>ACTIVIDAD</h1>
                            </div>
                            <div class=\"w-32 flex h-full items-center justify-center\">
                                <h1>RESPONSABLE</h1>
                            </div>
                            <div class=\"w-32 flex h-full items-center justify-center\">
                                <h1>COMENTARIOS</h1>
                            </div>
                            <div class=\"w-24 h-full flex items-center justify-center\">
                                <h1>ADJUNTOS</h1>
                            </div>
                            <div class=\"w-32 flex h-full items-center justify-center\">
                                <h1>STATUS</h1>
                            </div>
                            <div class=\"w-32 flex h-full items-center justify-center\">
                                <h1>COSTE</h1>
                            </div>
                        </div>

                        <div class=\"w-full flex flex-col rounded\">
                ";

                    //ACTIVIDADES PLANACCION 
                    $queryPlanaccion = "SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.status, t_colaboradores.nombre, t_colaboradores.apellido, t_proyectos_planaccion.responsable, t_proyectos_planaccion.fecha_creacion,
                    t_proyectos_planaccion.status_urgente,
                    t_proyectos_planaccion.status_material,
                    t_proyectos_planaccion.status_trabajando,
                    t_proyectos_planaccion.energetico_electricidad,
                    t_proyectos_planaccion.energetico_agua,
                    t_proyectos_planaccion.energetico_diesel,
                    t_proyectos_planaccion.energetico_gas,
                    t_proyectos_planaccion.departamento_calidad,
                    t_proyectos_planaccion.departamento_compras,
                    t_proyectos_planaccion.departamento_direccion,
                    t_proyectos_planaccion.departamento_finanzas,
                    t_proyectos_planaccion.departamento_rrhh,
                    t_proyectos_planaccion.coste
                    FROM t_proyectos_planaccion
                    INNER JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_proyectos_planaccion.activo = 1 and t_proyectos_planaccion.id_proyecto = $idProyecto
                    ORDER BY t_proyectos_planaccion.id DESC";
                    if ($resultPlanaccion = mysqli_query($conn_2020, $queryPlanaccion)) {
                        foreach ($resultPlanaccion as $value) {
                            $idPlanaccion = $value['id'];
                            $actividad = $value['actividad'];
                            $creadoPor = $value['nombre'] . " " . $value['apellido'];
                            $fecha = $value['fecha_creacion'];
                            $idResponsable = $value['responsable'];
                            $status = $value['status'];
                            $sUrgente = $value['status_urgente'];
                            $sMaterial = $value['status_material'];
                            $sTrabajando = $value['status_trabajando'];
                            $eElectricidad = $value['energetico_electricidad'];
                            $eAgua = $value['energetico_agua'];
                            $eDiesel = $value['energetico_diesel'];
                            $eGas = $value['energetico_gas'];
                            $dCalidad = $value['departamento_calidad'];
                            $dCompras = $value['departamento_compras'];
                            $dDireccion = $value['departamento_direccion'];
                            $dFinanzas = $value['departamento_finanzas'];
                            $dRRHH = $value['departamento_rrhh'];
                            $coste = $value['coste'];

                            if ($fecha == "" or $fecha == " ") {
                                $fecha = "-";
                            }

                            if ($status == "F" or $status == "FINALIZADO" or $status == "SOLUCIONADO") {
                                $solucionados = "actividades$idProyecto";
                            } else {
                                $solucionados = "";
                            }

                            //Status, Energeticos y Departamentos. 
                            if ($sUrgente == 1 or $sUrgente != "0") {
                                $sUrgente = "";
                            } else {
                                $sUrgente = "hidden";
                            }

                            if ($sMaterial == 1 or $sMaterial != "0") {
                                $sMaterial = "";
                            } else {
                                $sMaterial = "hidden";
                            }

                            if ($sTrabajando == 1 or $sTrabajando != "0") {
                                $sTrabajando = "";
                            } else {
                                $sTrabajando = "hidden";
                            }

                            if ($eElectricidad == 1 or $eElectricidad != "0") {
                                $eElectricidad = "";
                            } else {
                                $eElectricidad = "hidden";
                            }

                            if ($eAgua == 1 or $eAgua != "0") {
                                $eAgua = "";
                            } else {
                                $eAgua = "hidden";
                            }

                            if ($eDiesel == 1 or $eDiesel != "0") {
                                $eDiesel = "";
                            } else {
                                $eDiesel = "hidden";
                            }

                            if ($eGas == 1 or $eGas != "0") {
                                $eGas = "";
                            } else {
                                $eGas = "hidden";
                            }

                            if ($dCalidad == 1 or $dCalidad != "0") {
                                $dCalidad = "";
                            } else {
                                $dCalidad = "hidden";
                            }

                            if ($dCompras == 1 or $dCompras != "0") {
                                $dCompras = "";
                            } else {
                                $dCompras = "hidden";
                            }

                            if ($dDireccion == 1 or $dDireccion != "0") {
                                $dDireccion = "";
                            } else {
                                $dDireccion = "hidden";
                            }

                            if ($dFinanzas == 1 or $dFinanzas != "0") {
                                $dFinanzas = "";
                            } else {
                                $dFinanzas = "hidden";
                            }

                            if ($dRRHH == 1 or $dRRHH != "0") {
                                $dRRHH = "";
                            } else {
                                $dRRHH = "hidden";
                            }

                            // RESPONSABLE DE LA ACTIVIDAD
                            $queryResponsable = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                        FROM t_users
                        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                        WHERE t_users.id = $idResponsable
                        ";
                            if ($resultResponsable = mysqli_query($conn_2020, $queryResponsable)) {
                                foreach ($resultResponsable as $value) {
                                    $responsable = $value['nombre'] . " " . $value['apellido'];
                                }
                            } else {
                                $responsable = "";
                            }

                            // TOTAL DE COMENTARIOS
                            $queryComentarios = "SELECT count(id) FROM t_proyectos_planaccion_comentarios WHERE id_actividad = $idPlanaccion";
                            if ($resultComentarios = mysqli_query($conn_2020, $queryComentarios)) {
                                foreach ($resultComentarios as $value) {
                                    $totalComentarios = $value['count(id)'];
                                }
                                if ($totalComentarios <= 0) {
                                    $totalComentarios = "<i class=\"fas fa-window-minimize\"></i>";
                                }
                            }

                            // TOTAL DE ADJUNTOS
                            $queryAdjuntos = "SELECT count(id) FROM t_proyectos_planaccion_adjuntos WHERE id_actividad = $idPlanaccion and activo = 1";
                            if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {
                                foreach ($resultAdjuntos as $value) {
                                    $totalAdjuntos = $value['count(id)'];
                                }

                                if ($totalAdjuntos <= 0) {
                                    $totalAdjuntos = "<i class=\"fas fa-window-minimize\"></i>";
                                }
                            }


                            // Actividades PLANAACION PENDIENTE
                            $dataProyectos .= "     

                            <div class=\"$solucionados flex bg-white items-center font-semibold text-xxs text-bluegray-500 hover:bg-teal-100 cursor-pointer w-full justify-start my-1 rounded relative px-3\">

                                <div class=\"truncate w-3/4 flex flex-row items-center justify-between cursor-pointer hover:shadow-md relative\">

                                    <div class=\" hidden absolute\" style=\"left:0%;\">
                                        <i class=\"fas fa-siren-on animated flash infinite fa-rotate-270\"></i>
                                    </div>

                                    <div class=\"absolute flex hover:opacity-25\" style=\"right: 0%; font-size: 9px; mr-5\">
                                
                                        <div class=\"$sMaterial bg-orange-400 text-orange-800 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                            <h1 class=\"\">M</h1>
                                        </div>
                                        
                                        <div class=\"$sTrabajando bg-blue-200 text-blue-500 w-4 h-4 rounded-sm flex items-center justify-center font-semibold mr-1\">
                                            <h1 class=\"\">T</h1>
                                        </div>
                                        
                                        <div class=\"$eElectricidad bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                            <h1 class=\"\">Electricidad</h1>
                                        </div>
                                        
                                        <div class=\"$eAgua bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                            <h1 class=\"\">Agua</h1>
                                        </div>
                                    
                                        <div class=\"$eGas bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                            <h1 class=\"\">Gas</h1>
                                        </div>
                                        
                                        <div class=\"$eDiesel bg-yellow-300 text-yellow-800 w-auto h-4 rounded-sm flex items-center justify-center font-semibold mr-1 px-1\">
                                            <h1 class=\"\">Diesel</h1>
                                        </div>
                                        
                                        <div class=\"$dDireccion bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                            <h1 class=\"\">Dirección</h1>
                                        </div>
                                        
                                        <div class=\"$dRRHH bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                            <h1 class=\"\">RRHH</h1>
                                        </div>
                                        
                                        <div class=\"$dFinanzas bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                            <h1 class=\"\">Finanzas</h1>
                                        </div>
                                        
                                        <div class=\"$dCompras bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                            <h1 class=\"\">Compras</h1>
                                        </div>
                                        
                                        <div class=\"$dCalidad bg-teal-100 text-teal-400 w-auto px-2 h-4 rounded-sm flex items-center justify-center font-medium px-1\">
                                            <h1 class=\"\">Calidad</h1>
                                        </div>

                                    </div>

                                    <div class=\"w-3/4 flex flex-col items-center justify-center\">
                                        <div class=\"w-full leading-none pt-1 text-bluegray-900 uppercase text-xs truncate flex relative\">
                                            <i class=\"fas fa-dot-circle mr-1 text-green-400\"></i>
                                            <h1 id=\"AP$idPlanaccion\">$actividad</h1>
                                        </div>
                                        <div class=\"self-start\">
                                            <h1>$creadoPor - $fecha</h1>
                                        </div>
                                    </div>                                       

                                </div>

                                <div class=\"w-32 flex h-full items-center justify-center\"> 
                                    <h1>$responsable</h1>
                                </div>
                                <div class=\"w-32 flex h-full items-center justify-center\" onclick=\"comentariosPlanaccion($idPlanaccion);\">
                                    <h1>$totalComentarios</h1>
                                </div>
                                <div class=\"w-24 h-full flex items-center justify-center\" onclick=\"adjuntosPlanaccion($idPlanaccion);\">
                                    <h1>$totalAdjuntos</h1>
                                </div>
                                <div class=\"w-32 h-full flex items-center justify-center text-teal-500 rounded-r-md\">
                                    <div><i class=\"fad fa-exclamation-circle fa-lg\"></i></div>
                                </div>
                                
                                <div class=\"w-24 flex h-full items-center justify-center hover:shadow-md hover:bg-teal-200 text-teal-500 rounded-r-md\">
                                    <h1>
                                        <input class=\"shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight fcus:outline-none focus:shadow-outline text-center p-1\" id=\"costePlanaccion$idPlanaccion\" type=\"text\" placeholder=\"Coste\" value=\"$coste\" onkeyup=\"actualizarCostePlanaccion($idPlanaccion);\">
                                    </h1>
                                </div>
                            </div>
                        ";
                            // Actividades PLANAACION PENDIENTE
                        }
                    }

                    // CIERRE DE ENCABEZADOS
                    $dataProyectos .= "
                            </div>
                        </div>
                    </div>
                ";
                }
            }
        }
        $data['dataProyectos'] = $dataProyectos;
        echo json_encode($data);
    }


    // Agrega Proyectos
    if ($action == "agregarProyecto") {
        $idSubseccion = $_POST['idSubseccion'];
        $idSeccion = $_POST['idSeccion'];
        $titulo = $_POST['titulo'];
        $tipo = $_POST['tipo'];
        $rangoFecha = $_POST['fecha'];
        $responsable = $_POST['responsable'];
        $justificacion = $_POST['justificacion'];
        $coste = $_POST['coste'];
        $año = date('Y');

        $query = "INSERT INTO t_proyectos(id_destino, id_seccion, id_subseccion, titulo, justificacion, fecha_creacion, rango_fecha, creado_por, responsable, status, tipo, coste, año, activo) 
        VALUES($idDestino, $idSeccion, $idSubseccion, '$titulo', '$justificacion', '$fechaActual', '$rangoFecha', $idUsuario, $responsable, 'N', '$tipo', '$coste', '$año', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
            notificacionProyectos($idUsuario, $responsable, 0, 'PROYECTO', $titulo);
        } else {
            echo 0;
        }
    }


    // Obtines Responsables en SELECT
    if ($action == "obtenerResponsables") {
        $data = array();
        $dataUsuarios = "<option value=\"\">Seleccione</option>";

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND (t_users.id_destino = 10 OR t_users.id_destino = $idDestino)";
        }

        $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_users.status = 'A' AND t_users.id != 0 $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idUser = $value['id'];
                $nombre = $value['nombre'];
                $apellido = $value['apellido'];

                $dataUsuarios .= "<option value=\"$idUser\">$nombre $apellido</option>";
            }
            $data['dataUsuarios'] = $dataUsuarios;
        }
        echo json_encode($data);
    }


    // Actualiza la información de los Proyectos
    if ($action == "actualizarProyectos") {
        $valor = $_POST['valor'];
        $columna = $_POST['columna'];
        $idProyecto = $_POST['idProyecto'];
        $justificacion = $_POST['justificacion'];
        $coste = $_POST['coste'];
        $tipo = $_POST['tipo'];
        $titulo = $_POST['titulo'];
        $resp = 0;

        if ($columna == "asignarProyecto") {
            $columna = "responsable";
            $query = "UPDATE t_proyectos SET responsable = '$valor' WHERE id = $idProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
                notificacionProyectos($idUsuario, $valor, $idProyecto, 'ACTUALIZADOPROYECTO', '');
            }
        } elseif ($columna == "justificacion" and $justificacion != "") {
            $query = "UPDATE t_proyectos SET justificacion = '$justificacion' WHERE id = $idProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 2;
            }
        } elseif ($columna == "coste" and $coste > 0) {
            $query = "UPDATE t_proyectos SET coste = '$coste' WHERE id = $idProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 3;
            }
        } elseif ($columna == "tipo" and $tipo != "") {
            $query = "UPDATE t_proyectos SET tipo = '$tipo' WHERE id = $idProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 4;
            }
        } elseif ($columna == "rango_fecha" and $valor != "") {
            // Obtiene el año apartir del rengo de fecha
            $año = $valor[6] . $valor[7] . $valor[8] . $valor[9];

            $query = "UPDATE t_proyectos SET rango_fecha = '$valor', año = '$año' WHERE id = $idProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {

                $resp = 5;
            }
        } elseif ($columna == "eliminar" and $valor == 0) {
            $query = "UPDATE t_proyectos SET activo = '0' WHERE id = $idProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 6;
            }
        } elseif ($columna == "titulo" and $titulo != "") {
            $query = "UPDATE t_proyectos SET titulo = '$titulo' WHERE id = $idProyecto";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 7;
            }
        } elseif ($columna == "status" and $valor == "F") {
            $query = "SELECT count(id) FROM t_proyectos_planaccion 
            WHERE id_proyecto = $idProyecto AND status = 'N' and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $pendientes = $value['count(id)'];
                }
                if ($pendientes == 0) {
                    $query = "UPDATE t_proyectos SET status = 'F', finalizado_por = '$idUsuario', 
                    fecha_finalizado = '$fechaActual' WHERE id = $idProyecto";
                    if ($result = mysqli_query($conn_2020, $query)) {

                        $query = "UPDATE t_proyectos_planaccion SET status = 'F', realizado_por = $idUsuario 
                        WHERE id_proyecto = $idProyecto AND activo = 1 AND status != 'F'";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $resp = 8;
                        }
                    }
                }
            }
        } elseif ($columna == "status" and $valor == "N") {
            $query = "UPDATE t_proyectos SET status = 'N' WHERE id = $idProyecto AND activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 9;
            }
        } elseif ($columna == 'presupuesto') {
            $presupuesto = $_POST['presupuesto'];
            $query = "UPDATE t_proyectos SET presupuesto = '$presupuesto' 
            WHERE id = $idProyecto and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 11;
            }
        } elseif ($columna == 'status_i') {
            $valor = 0;
            $query = "SELECT status_i FROM t_proyectos WHERE id = $idProyecto and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valor = $x['status_i'];
                }
            }
            if ($valor == 0) {
                $valor = 1;
            } else {
                $valor = 0;
            }

            $query = "UPDATE t_proyectos SET status_i = '$valor' 
            WHERE id = $idProyecto and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 12;
            }
        } elseif ($columna == 'status_ap') {
            $valor = 0;
            $query = "SELECT status_ap FROM t_proyectos WHERE id = $idProyecto and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valor = $x['status_ap'];
                }
            }
            if ($valor == 0) {
                $valor = 1;
            } else {
                $valor = 0;
            }

            $total = 0;
            $query = "SELECT  count(id) 'total' FROM t_proyectos_adjuntos 
            WHERE id_proyecto = $idProyecto and status = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $total = $x['total'];
                }
            }

            if ($total > 0) {
                $query = "UPDATE t_proyectos SET status_ap = '$valor' 
                WHERE id = $idProyecto and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $resp = 12;
                }
            } else {
                $resp = 13;
            }
        }
        echo $resp;
    }


    //Obtiene datos de las columnas de los Proyectos 
    if ($action == "obtenerDatoProyectos") {
        $data = array();
        $idProyecto = $_POST['idProyecto'];
        $columna = $_POST['columna'];

        $query = "SELECT id, coste, justificacion, tipo, rango_fecha  FROM t_proyectos WHERE id = $idProyecto";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $tipo = $value['tipo'];
                $justificacion = $value['justificacion'];
                $coste = $value['coste'];
                $rangoFecha = $value['rango_fecha'];

                if ($rangoFecha != "") {
                    $rangoFecha = "$rangoFecha[3]$rangoFecha[4]/$rangoFecha[0]$rangoFecha[1]/$rangoFecha[6]$rangoFecha[7]$rangoFecha[8]$rangoFecha[9] - $rangoFecha[16]$rangoFecha[17]/$rangoFecha[13]$rangoFecha[14]/$rangoFecha[19]$rangoFecha[20]$rangoFecha[21]$rangoFecha[22]";
                }

                $data['tipo'] = $tipo;
                $data['justificacion'] = $justificacion;
                $data['coste'] = $coste;
                $data['rangoFecha'] = $rangoFecha;
            }
        }
        echo json_encode($data);
    }


    // Agrega planaccion en PROYECTOS
    if ($action == "agregarPlanaccion") {
        $idProyecto = $_POST['idProyecto'];
        $actividad = $_POST['actividad'];
        $resp = 0;

        $query = "SELECT responsable, titulo, rango_fecha FROM t_proyectos WHERE id = $idProyecto";
        if ($result = mysqli_query($conn_2020, $query)) {
            $responsable = 0;
            foreach ($result as $value) {
                $responsable = $value['responsable'];
                $proyecto = $value['titulo'];
                $rangoFecha = $value['rango_fecha'];
            }
            $query = "INSERT INTO t_proyectos_planaccion(id_proyecto, actividad, status, creado_por, fecha_creacion, rango_fecha, responsable, activo) VALUES($idProyecto, '$actividad', 'N', $idUsuario, '$fechaActual', '$rangoFecha', $responsable, 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
                notificacionProyectos($idUsuario, $responsable, $idProyecto, 'PLANACCION', $actividad);
            }
        }
        echo json_encode($resp);
    }


    // ACTUALIZA LOS STATUS DE PLAN DE ACCION
    if ($action == "actualizarPlanaccion") {
        $columna = $_POST['columna'];
        $valor = $_POST['valor'];
        $idPlanaccion = $_POST['idPlanaccion'];
        $actividad = $_POST['actividad'];
        $idSeccion = $_POST['idSeccion'];

        if ($columna == "asignarPlanaccion" and $valor >= 0) {
            $query = "UPDATE t_proyectos_planaccion SET responsable = $valor WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 1;
                notificacionProyectos($idUsuario, $valor, $idPlanaccion, 'ACTUALIZADOPLANACCION', '');
            } else {
                echo 0;
            }
        } elseif ($columna == "actividad" and $actividad != "") {
            $query = "UPDATE t_proyectos_planaccion SET actividad = '$actividad' WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 2;
            } else {
                echo 0;
            }
        } elseif ($columna == "activo") {
            $query = "UPDATE t_proyectos_planaccion SET activo = '0' WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 3;
            } else {
                echo 0;
            }
        } elseif ($columna == "status" and $valor == "F") {
            $query = "UPDATE t_proyectos_planaccion SET $columna = '$valor' ,fecha_realizado = '$fechaActual'  
            WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {

                $query = "SELECT id_proyecto FROM t_proyectos_planaccion WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $idProyecto = $i['id_proyecto'];
                    }
                    $query = "INSERT INTO reporte_status_proyecto(id_usuario, id_destino, id_seccion, id_subseccion, id_proyecto, id_planaccion, status) VALUES($idUsuario, $idDestino, $idSeccion, 200, $idProyecto, $idPlanaccion, 'status_solucionado')";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        echo 4;
                    } else {
                        echo 0;
                    }
                }
            } else {
                echo 0;
            }
        } elseif ($columna == "status_urgente" or $columna == "status_trabajando" or $columna == "energetico_electricidad" or $columna == "energetico_agua" or $columna == "energetico_diesel" or $columna == "energetico_gas" or $columna == "departamento_calidad" or $columna == "departamento_compras" or $columna == "departamento_direccion" or $columna == "departamento_finanzas" or $columna == "departamento_rrhh") {
            $select = "SELECT $columna FROM t_proyectos_planaccion WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $select)) {
                foreach ($result as $value) {
                    $dato = $value[$columna];
                    if ($dato == 1) {
                        $valor = 0;
                    } else {
                        $valor = 1;
                    }

                    $query = "UPDATE t_proyectos_planaccion SET $columna = '$valor' WHERE id = $idPlanaccion";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        echo 5;
                    } else {
                        echo 0;
                    }
                }
            } else {
                echo 0;
            }
        } elseif ($columna == "status" and $valor == "N") {
            $query = "UPDATE t_proyectos_planaccion SET status = 'N' WHERE id = $idPlanaccion";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 6;
            } else {
                echo 0;
            }
        } elseif ($columna == "status_material") {
            $codigoSeguimiento = $_POST['codigoSeguimiento'];
            if ($codigoSeguimiento != "") {
                $select = "SELECT status_material FROM t_proyectos_planaccion 
                WHERE id = $idPlanaccion";
                $valor = 0;
                if ($result = mysqli_query($conn_2020, $select)) {
                    foreach ($result as $value) {
                        $dato = $value['status_material'];
                        if ($dato == 1) {
                            $valor = 0;
                        } else {
                            $valor = 1;
                        }
                    }

                    $query = "UPDATE t_proyectos_planaccion SET status_material = '$valor', cod2bend = '$codigoSeguimiento' WHERE id = $idPlanaccion";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        echo 7;
                    }
                }
            }
        } elseif ($columna == "rango_fecha") {
            $rangoFecha = $_POST['rangoFecha'];
            if ($rangoFecha != "") {
                $query = "UPDATE t_proyectos_planaccion SET rango_fecha = '$rangoFecha'
                WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    echo 8;
                }
            } else {
                echo 0;
            }
        } elseif ($columna == "bitacora_gp" || $columna == "bitacora_trs" || $columna == "bitacora_zi") {
            $query = "SELECT $columna FROM t_proyectos_planaccion WHERE id = $idPlanaccion";
            $valorX = 1;
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valorX = $x[$columna];
                }
                if ($valorX == 0) {
                    $valor = 1;
                } else {
                    $valor = 0;
                }

                $query = "UPDATE t_proyectos_planaccion SET $columna = '$valor' WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    echo 9;
                }
            }
        } elseif ($columna == "status_ep") {
            $query = "SELECT status_ep FROM t_proyectos_planaccion WHERE id = $idPlanaccion";
            $valorX = 1;
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $valorX = $x['status_ep'];
                }
                if ($valorX == 0) {
                    $valor = 1;
                } else {
                    $valor = 0;
                }

                $query = "UPDATE t_proyectos_planaccion SET status_ep = '$valor' WHERE id = $idPlanaccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    echo 10;
                }
            }
        } else {
            echo 0;
        }
    }


    // Comentarios para Planaccion
    if ($action == "comentariosPlanaccion") {
        $data = "";
        $idPlanaccion = $_POST['idPlanaccion'];

        $query = "SELECT t_proyectos_planaccion_comentarios.comentario, t_proyectos_planaccion_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_proyectos_planaccion_comentarios
        INNER JOIN t_users ON t_proyectos_planaccion_comentarios.usuario = t_users.id 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_proyectos_planaccion_comentarios.id_actividad = $idPlanaccion 
        ORDER BY t_proyectos_planaccion_comentarios.id DESC
        ";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $comentario = $value['comentario'];
                $fecha = $value['fecha'];
                $nombreCompleto = $value['nombre'] . "" . $value['apellido'];

                $data .= "
                    <div class=\"flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer\">
                        <div class=\"flex items-center justify-center\" style=\"width: 48px;\">
                            <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombreCompleto\" width=\"48\" height=\"48\" alt=\"\">
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
            echo $data;
        }
    }


    if ($action == "agregarComentarioPlanaccion") {
        $idPlanaccion = $_POST['idPlanaccion'];
        $comentario = $_POST['comentario'];

        $query = "INSERT INTO t_proyectos_planaccion_comentarios(id_actividad, comentario, usuario, fecha) VALUES($idPlanaccion, '$comentario', $idUsuario, '$fechaActual')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    // Obtien los Status Marcados para dar diseño en el modal
    if ($action == "statusPlanaccion") {
        $data = array();
        $idPlanaccion = $_POST['idPlanaccion'];

        // Default
        $data['sUrgente'] = 0;
        $data['sMaterial'] = 0;
        $data['sTrabajando'] = 0;
        $data['eElectricidad'] = 0;
        $data['eAgua'] = 0;
        $data['eDiesel'] = 0;
        $data['eGas'] = 0;
        $data['dCalidad'] = 0;
        $data['dCompras'] = 0;
        $data['dDireccion'] = 0;
        $data['dFinanzas'] = 0;
        $data['dRRHH'] = 0;
        $data['codsap'] = "";

        $query = "SELECT codsap, status_urgente, status_material, status_trabajando, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh 
        FROM t_proyectos_planaccion WHERE id = $idPlanaccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $sUrgente = $i['status_urgente'];
                $sMaterial = $i['status_material'];
                $sTrabajando = $i['status_trabajando'];
                $eElectricidad = $i['energetico_electricidad'];
                $eAgua = $i['energetico_agua'];
                $eDiesel = $i['energetico_diesel'];
                $eGas = $i['energetico_gas'];
                $dCalidad = $i['departamento_calidad'];
                $dCompras = $i['departamento_compras'];
                $dDireccion = $i['departamento_direccion'];
                $dFinanzas = $i['departamento_finanzas'];
                $dRRHH = $i['departamento_rrhh'];
                $codsap = $i['codsap'];

                $data['sUrgente'] = $sUrgente;
                $data['sMaterial'] = $sMaterial;
                $data['sTrabajando'] = $sTrabajando;
                $data['eElectricidad'] = $eElectricidad;
                $data['eAgua'] = $eAgua;
                $data['eDiesel'] = $eDiesel;
                $data['eGas'] = $eGas;
                $data['dCalidad'] = $dCalidad;
                $data['dCompras'] = $dCompras;
                $data['dDireccion'] = $dDireccion;
                $data['dFinanzas'] = $dFinanzas;
                $data['dRRHH'] = $dRRHH;
                $data['codsap'] = $codsap;
            }
        }
        echo json_encode($data);
    }


    // Sube Adjuntos (TABLA, IDTABLA)
    if ($action == "subirImagenGeneral") {
        $tabla = $_POST['tabla'];
        $idTabla = $_POST['idTabla'];
        $img = $_FILES['adjuntoUrl'];
        $extension = "." . pathinfo($img['name'], PATHINFO_EXTENSION);
        $nombreTratado = preg_replace('([^A-Za-z0-9.])', '', $img['name']);
        $aleatorio = rand(1, 1500);

        // Cambia Tabla, Ruta y Nombre de Archivos, donde se enviara.
        if ($tabla == "t_proyectos_adjuntos") {
            $imgNombre = "COT_PROYECTO_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/proyectos/";

            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_proyectos_adjuntos(id_proyecto, url_adjunto, fecha, subido_por, status) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 3;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "t_proyectos_planaccion_adjuntos") {
            $imgNombre = "PLANACCION_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/proyectos/planaccion/";

            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_proyectos_planaccion_adjuntos(id_actividad, url_adjunto, fecha_creado, subido_por, status) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 4;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "t_equipos_america_adjuntos") {
            $imgNombre = "EQUIPO_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/equipos/";

            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_equipos_america_adjuntos(id_equipo, url_adjunto, fecha, subido_por, activo) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 5;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "t_proyectos_justificaciones") {
            $imgNombre = "JUSTIFICACION_PROYECTO_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/proyectos/";

            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_proyectos_justificaciones(id_proyecto, url_adjunto, fecha, subido_por, status) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 6;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "adjuntos_mp_np") {
            $imgNombre = "TAREAS_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../img/equipos/mpnp/";

            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO adjuntos_mp_np(id_usuario, id_mp_np, url, fecha, activo) VALUES($idUsuario, $idTabla, '$imgNombre', '$fechaActual', 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 7;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "t_mc_adjuntos") {
            $imgNombre = "FALLAS_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/tareas/adjuntos/";
            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_mc_adjuntos(id_mc, url_adjunto, fecha, subido_por, activo) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 8;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "t_equipos_adjuntos_america") {
            $imgNombre = "EQUIPO_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/equipos/";
            if ($extension == "png" || $extension == "jpg" || $extension == "jpeg" || $extension == "gif" || $extension == "PNG" || $extension == "JPG" || $extension == "JPEG" || $extension == "GIF") {
                if ($img['name'] != "") {
                    if (($img['size'] / 1000) < 100000) {
                        if (move_uploaded_file($img['tmp_name'], "$ruta" . "$imgNombre")) {
                            $query = "INSERT INTO t_equipos_america_adjuntos(id_equipo, url_adjunto, fecha, subido_por, activo) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                echo 9;
                            } else {
                                echo 0;
                            }
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 2;
                    }
                } else {
                    echo 1;
                }
            } else {
                echo -1;
            }
        } elseif ($tabla == "t_mp_planificacion_iniciada_adjuntos") {
            $imgNombre = "OT_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/mp_ot/";
            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_mp_planificacion_iniciada_adjuntos(id_planificacion_iniciada, id_usuario, url, fecha_subida, activo) 
                        VALUES($idTabla, $idUsuario, '$imgNombre', '$fechaActual', 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 10;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "t_equipos_cotizaciones") {
            $imgNombre = "EQUIPO_ID_COT_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../img/equipos/cotizaciones/";

            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_equipos_cotizaciones(id_equipo, url_archivo, fecha, subido_por, activo) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 11;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "t_proyectos_adjuntos_DEP") {
            $imgNombre = "COT_PROYECTO_DEP_ID_" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/proyectos/";
            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_proyectos_adjuntos(id_proyecto, url_adjunto, fecha, subido_por, status) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 12;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } elseif ($tabla == "t_proyectos_planaccion_adjuntos_DEP") {
            $imgNombre = "PLANACCION_ID_DEP" . $idTabla . "_$aleatorio" . $extension;
            $ruta = "../planner/proyectos/planaccion/";

            if ($img['name'] != "") {
                if (($img['size'] / 1000) < 100000) {
                    if (move_uploaded_file($img['tmp_name'], "$ruta$imgNombre")) {
                        $query = "INSERT INTO t_proyectos_planaccion_adjuntos(id_actividad, url_adjunto, fecha_creado, subido_por, status) VALUES($idTabla, '$imgNombre', '$fechaActual', $idUsuario, 1)";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo 13;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 2;
                }
            } else {
                echo 1;
            }
        } else {
            echo 0;
        }
    }


    //Obtener Adjuntos (TABLA, IDTABLA)
    if ($action == "obtenerAdjuntos") {
        $tabla = $_POST['tabla'];
        $idTabla = $_POST['idTabla'];
        $data = array();
        $imagen = "";
        $imagenAux = "";
        $documento = "";

        $data['imagenAux'] = $imagenAux;
        $data['imagen'] = $imagen;
        $data['documento'] = $documento;

        if ($tabla == "t_proyectos_adjuntos") {

            $query = "SELECT t_proyectos_adjuntos.id, t_proyectos_adjuntos.url_adjunto, 
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_proyectos_adjuntos 
            LEFT JOIN t_users ON t_proyectos_adjuntos.subido_por = t_users.id 
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE id_proyecto = $idTabla AND t_proyectos_adjuntos.status = 1
            ORDER BY t_proyectos_adjuntos.fecha DESC";

            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $url = $value['url_adjunto'];
                    $idAdjunto = $value['id'];

                    if (file_exists("../planner/proyectos/$url")) {
                        $adjuntoURL = "planner/proyectos/$url";
                    } else {
                        $adjuntoURL = "../planner/proyectos/$url";
                    }

                    // Admite solo Imagenes.
                    if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {

                        if (strpbrk($adjuntoURL, ' ')) {
                            $dataImagen .= "
                                <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">

                                    <a href=\"$adjuntoURL\" target=\"_blank\" data-title=\"Clic para Abrir\">
                                        <div class=\"m-2 cursor-pointer overflow-hidden w-32 h-32 rounded-md op2\">
                                            <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                        </div>
                                    </a>

                                    <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'COTIZACIONPROYECTO');\">
                                        <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                    </div>

                                </div>
                            ";
                        } else {
                            $imagen .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">

                                <a href=\"$adjuntoURL\" target=\"_blank\" data-title=\"Clic para Abrir\">
                                    <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                    </div>
                                </a>

                                <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'COTIZACIONPROYECTO');\">
                                    <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                </div>

                            </div>
                            ";
                        }
                    } else {
                        $documento .= "
                        <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                           
                            <a href=\"$adjuntoURL\" target=\"_blank\">
                                <div class=\"auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2\">
                                    <i class=\"fad fa-file-alt fa-3x\"></i>
                                    <p class=\"text-sm font-normal ml-2\">$url
                                    </p>
                                </div>
                            </a>     
                            
                            <div class=\"absolute text-red-700\" style=\"bottom: 22px; right: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'COTIZACIONPROYECTO');\">
                                <i class=\"fas fa-trash-alt fa-2x\"></i>
                            </div>
                        </div>                  
                        ";
                    }
                }
                $data['imagen'] = $imagen;
                $data['documento'] = $documento;
            }
        } elseif ($tabla == "t_proyectos_planaccion_adjuntos") {
            $query = "SELECT t_proyectos_planaccion_adjuntos.id, t_proyectos_planaccion_adjuntos.url_adjunto, 
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_proyectos_planaccion_adjuntos 
            LEFT JOIN t_users ON t_proyectos_planaccion_adjuntos.subido_por = t_users.id 
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE id_actividad = $idTabla AND t_proyectos_planaccion_adjuntos.status = 1
            ORDER BY t_proyectos_planaccion_adjuntos.fecha_creado DESC
            ";

            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $url = $value['url_adjunto'];
                    $idAdjunto = $value['id'];

                    if (file_exists("../planner/proyectos/$url")) {
                        $adjuntoURL = "planner/proyectos/$url";
                    } elseif (file_exists("../planner/proyectos/planaccion/$url")) {
                        $adjuntoURL = "planner/proyectos/planaccion/$url";
                    } elseif (file_exists("../../planner/proyectos/$url")) {
                        $adjuntoURL = "../planner/proyectos/$url";
                    } else {
                        $adjuntoURL = "../planner/proyectos/planaccion/$url";
                    }

                    // Admite solo Imagenes.
                    if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {

                        if (strpbrk($adjuntoURL, ' ')) {
                            $dataImagen .= "
                                <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                    <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"m-2 cursor-pointer overflow-hidden w-32 h-32 rounded-md op2\">
                                            <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                        </div>
                                    </a>
                                    
                                    <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'PLANACCION');\">
                                        <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                    </div>
                                </div>
                            ";
                        } else {

                            $imagen .= "
                                <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                    <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                        </div>
                                    </a>

                                    <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'PLANACCION');\">
                                        <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                    </div>
                                
                                </div>
                            ";
                        }
                    } else {
                        $documento .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2\">
                                        <i class=\"fad fa-file-alt fa-3x\"></i>
                                        <p class=\"text-sm font-normal ml-2\">$url</p>
                                    </div>
                                </a> 
                                
                                <div class=\"absolute text-red-700\" style=\"bottom: 22px; right: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'PLANACCION');\">
                                    <i class=\"fas fa-trash-alt fa-2x\"></i>
                                </div>

                            </div>
                        ";
                    }
                }
                $data['imagen'] = $imagen;
                $data['documento'] = $documento;
            }
        } elseif ($tabla == "t_equipos_america_adjuntos_1") {
            $query = "SELECT t_equipos_america_adjuntos.id, t_equipos_america_adjuntos.url_adjunto, 
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_equipos_america_adjuntos 
            LEFT JOIN t_users ON t_equipos_america_adjuntos.subido_por = t_users.id 
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_equipos_america_adjuntos.id_equipo = $idTabla AND t_equipos_america_adjuntos.activo = 1
            ORDER BY t_equipos_america_adjuntos.fecha DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $idAdjunto = $value['id'];
                    $url = $value['url_adjunto'];

                    if (file_exists("../../equipos/files/$url")) {
                        $adjuntoURL = "../../equipos/files/$url";
                    } elseif (file_exists("../img/equipos/$url")) {
                        $adjuntoURL = "../img/equipos/$url";
                    } else {
                        $adjuntoURL = "";
                    }

                    // RUTA ABSOLUTA
                    $adjuntoURL = "planner/equipos/$url";

                    // Admite solo Imagenes.
                    if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {
                        if (strpbrk($adjuntoURL, ' ')) {
                            $imagen .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"m-2 cursor-pointer overflow-hidden w-32 h-32 rounded-md\">
                                        <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                    </div>
                                </a>
                                <div class=\"w-full absolute text-transparent hover:text-red-700 text-center\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'equipo');\">
                                    <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                </div>
                            </div>
                        ";
                        } else {
                            $imagen .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 p-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                    </div>
                                </a>
                                <div class=\"w-full absolute text-transparent hover:text-red-700 text-center\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'equipo');\">
                                    <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        $documento .= "
                        <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                            <a href=\"$adjuntoURL\" target=\"_blank\">
                                <div class=\"w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2\">
                                    <i class=\"fad fa-file-alt fa-3x\"></i>
                                    <p class=\"text-sm font-normal ml-2\">$url
                                    </p>
                                </div>
                            </a>
                            <div class=\"w-full absolute text-transparent hover:text-red-700 text-center\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'equipo');\">
                                <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                            </div>
                        </div>                    
                        ";
                    }
                }
                $data['imagen'] = $imagen;
                $data['documento'] = $documento;
            }
        } elseif ($tabla == "t_equipos_america_adjuntos") {
            $query = "SELECT t_equipos_america_adjuntos.id, t_equipos_america_adjuntos.url_adjunto, 
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_equipos_america_adjuntos 
            LEFT JOIN t_users ON t_equipos_america_adjuntos.subido_por = t_users.id 
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_equipos_america_adjuntos.id_equipo = $idTabla AND t_equipos_america_adjuntos.activo = 1
            ORDER BY t_equipos_america_adjuntos.fecha DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $idAdjunto = $value['id'];
                    $url = $value['url_adjunto'];

                    if (file_exists("../../equipos/files/$url")) {
                        $adjuntoURL = "../equipos/files/$url";
                    } elseif (file_exists("../img/equipos/$url")) {
                        $adjuntoURL = "img/equipos/$url";
                    } else {
                        $adjuntoURL = "";
                    }

                    // RUTA ABSOLUTA
                    $adjuntoURL = "planner/equipos/$url";

                    // Admite solo Imagenes.
                    if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {
                        if (strpbrk($adjuntoURL, ' ')) {
                            $imagen .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"m-2 cursor-pointer overflow-hidden w-32 h-32 rounded-md\">
                                        <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                    </div>
                                </a>
                                <div class=\"w-full absolute text-transparent hover:text-red-700 text-center\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'equipo');\">
                                    <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                </div>
                            </div>
                        ";
                        } else {
                            $imagen .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 p-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                    </div>
                                </a>
                                <div class=\"w-full absolute text-transparent hover:text-red-700 text-center\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'equipo');\">
                                    <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                </div>
                            </div>
                            ";
                        }
                    } else {
                        $documento .= "
                        <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                            <a href=\"$adjuntoURL\" target=\"_blank\">
                                <div class=\"w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2\">
                                    <i class=\"fad fa-file-alt fa-3x\"></i>
                                    <p class=\"text-sm font-normal ml-2\">$url
                                    </p>
                                </div>
                            </a>
                            <div class=\"w-full absolute text-transparent hover:text-red-700 text-center\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'equipo');\">
                                <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                            </div>
                        </div>                    
                        ";
                    }
                }
                $data['imagen'] = $imagen;
                $data['documento'] = $documento;
            }
        } elseif ($tabla == "t_equipos_cotizaciones") {
            $query = "SELECT t_equipos_cotizaciones.id, t_equipos_cotizaciones.url_archivo, 
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_equipos_cotizaciones 
            LEFT JOIN t_users ON t_equipos_cotizaciones.subido_por = t_users.id 
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_equipos_cotizaciones.id_equipo = $idTabla AND t_equipos_cotizaciones.activo = 1
            ORDER BY t_equipos_cotizaciones.id DESC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $url = $value['url_archivo'];

                    if (file_exists("../../equipos/cotizaciones/$url")) {
                        $adjuntoURL = "../equipos/cotizaciones/$url";
                    } elseif (file_exists("../img/equipos/cotizaciones/$url")) {
                        $adjuntoURL = "img/equipos/cotizaciones/$url";
                    } else {
                        $adjuntoURL = "";
                    }

                    // Admite solo Imagenes.
                    if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {
                        if (strpbrk($adjuntoURL, ' ')) {
                            $imagen .= "
                            <a href=\"$adjuntoURL\" target=\"_blank\">
                                <div class=\"m-2 cursor-pointer overflow-hidden w-32 h-32 rounded-md op2\">
                                    <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                </div>
                            </a>
                        ";
                        } else {
                            $imagen .= "
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                    </div>
                                </a>
                            ";
                        }
                    } else {
                        $documento .= "
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
                $data['imagen'] = $imagen;
                $data['documento'] = $documento;
            }
        } elseif ($tabla == "t_proyectos_justificaciones") {
            $query = "SELECT t_proyectos_justificaciones.id, t_proyectos_justificaciones.url_adjunto, 
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_proyectos_justificaciones 
            LEFT JOIN t_users ON t_proyectos_justificaciones.subido_por = t_users.id 
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_proyectos_justificaciones.id_proyecto = $idTabla AND t_proyectos_justificaciones.status = 1
            ORDER BY t_proyectos_justificaciones.id ASC";

            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $url = $value['url_adjunto'];
                    $idAdjunto = $value['id'];

                    if (file_exists("../planner/proyectos/$url")) {
                        $adjuntoURL = "planner/proyectos/$url";
                    } else {
                        $adjuntoURL = "../planner/proyectos/$url";
                    }

                    // Admite solo Imagenes.
                    if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {
                        if (strpbrk($adjuntoURL, ' ')) {
                            $imagen .= "
                                <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                    <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"m-2 cursor-pointer overflow-hidden w-32 h-32 rounded-md op2\">
                                            <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                        </div>
                                    </a>
                                    
                                    <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'JUSTIFICACIONPROYECTO');\">
                                        <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                    </div>

                                </div>
                            ";
                        } else {
                            $imagen .= "
                                <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                    <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"bg-local bg-cover bg-center w-32 h-32 rounded-md border-2 m-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                        </div>
                                    </a>
                                    
                                    <div class=\"w-full absolute text-transparent hover:text-red-700\" style=\"bottom: 12px; left: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'JUSTIFICACIONPROYECTO');\">
                                        <i class=\"fas fa-trash-alt fa-2x\" data-title=\"Clic para Eliminar\"></i>
                                    </div>
                                </div>
                            ";
                        }
                    } else {
                        $documento .= "
                            <div id=\"modalMedia_adjunto_img_$idAdjunto\" class=\"relative\">
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"w-full auto rounded-md cursor-pointer flex flex-row justify-start text-left items-center text-gray-500 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm mb-2 p-2\">
                                        <i class=\"fad fa-file-alt fa-3x\"></i>
                                        <p class=\"text-sm font-normal ml-2\">$url</p>
                                    </div>
                                </a> 

                                <div class=\"absolute text-red-700\" style=\"bottom: 22px; right: 0px;\" onclick=\"eliminarAdjunto($idAdjunto, 'JUSTIFICACIONPROYECTO');\">
                                    <i class=\"fas fa-trash-alt fa-2x\"></i>
                                </div>                                
                            </div>
                        ";
                    }
                }
                $data['imagen'] = $imagen;
                $data['documento'] = $documento;
            }
        } elseif ($tabla == "t_equipos_adjuntos_america") {
            $query = "SELECT t_equipos_america_adjuntos.id, t_equipos_america_adjuntos.url_adjunto, 
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_equipos_america_adjuntos 
            LEFT JOIN t_users ON t_equipos_america_adjuntos.subido_por = t_users.id 
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_equipos_america_adjuntos.id_equipo = $idTabla AND t_equipos_america_adjuntos.activo = 1
            ORDER BY t_equipos_america_adjuntos.id DESC";

            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $value) {
                    $url = $value['url_adjunto'];

                    if (file_exists("../planner/equipos/$url")) {
                        $adjuntoURL = "planner/equipos/$url";
                        $adjuntoURL_beta = "../planner/equipos/$url";
                    } else {
                        $adjuntoURL = "../planner/equipos/$url";
                        $adjuntoURL_beta = "../../planner/equipos/$url";
                    }
                    $adjuntoURL = "planner/equipos/$url";
                    $adjuntoURL_beta = "planner/equipos/$url";

                    // Admite solo Imagenes.
                    if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "gif") || strpos($url, "PNG")) {
                        if (strpbrk($adjuntoURL, ' ')) {
                            $imagen .= "
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"bg-cover bg-center w-24 h-24 rounded cursor-pointer flex-none mr-2 hover:shadow-lg overflow-hidden\">
                                        <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                    </div>
                                </a>
                            ";

                            $imagenAux .= "
                                <a href=\"$adjuntoURL_beta\" target=\"_blank\">
                                    <div class=\"bg-cover bg-center w-24 h-24 rounded cursor-pointer flex-none mr-2 hover:shadow-lg overflow-hidden\">
                                        <img src=\"$adjuntoURL_beta\" class=\"w-full\" alt=\"\">
                                    </div>
                                </a>
                            ";
                        } else {

                            $imagen .= "
                                <a href=\"$adjuntoURL\" target=\"_blank\">
                                    <div class=\"bg-cover bg-center w-24 h-24 rounded cursor-pointer flex-none mr-2 hover:shadow-lg\" style=\"background-image: url($adjuntoURL)\">
                                    </div>
                                </a>
                            ";

                            $imagenAux .= "
                                <a href=\"$adjuntoURL_beta\" target=\"_blank\">
                                    <div class=\"bg-cover bg-center w-24 h-24 rounded cursor-pointer flex-none mr-2 hover:shadow-lg\" style=\"background-image: url($adjuntoURL_beta)\">
                                    </div>
                                </a>
                            ";
                        }
                    } else {
                        $documento .= "
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
                $data['imagen'] = $imagen;
                $data['imagenAux'] = $imagenAux;
                $data['documento'] = $documento;
            }
        }

        echo json_encode($data);
    }


    #****************** VER EN PLANNER  ******************

    // Obtiene Datos (FALLAS, TAREAS) para Modal Ver en Planner.
    if ($action == "verEnPlanner") {
        $tipoPendiente = $_POST['tipoPendiente'];
        $idPendiente = $_POST['idPendiente'];
        $data = array();
        $fecha = "- -";
        $status = "";
        $dataComentariosVP = "";
        $dataImagen = "";
        $dataAdjunto = "";
        $responsable = "";

        if ($tipoPendiente == "FALLA" || $tipoPendiente == "INCIDENCIA") {
            $query = "SELECT t_mc.id, t_equipos.equipo, t_mc.actividad, t_mc.rango_fecha, t_mc.responsable,
            t_mc.status_material, t_mc.status_trabajare, t_mc.status_urgente,
            t_mc.energetico_electricidad, t_mc.energetico_agua, t_mc.energetico_diesel, t_mc.energetico_gas,
            t_mc.departamento_calidad, t_mc.departamento_compras, t_mc.departamento_direccion, 
            t_mc.departamento_finanzas, t_mc.departamento_rrhh, t_mc.fecha_inicio,
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_mc 
            LEFT JOIN t_users ON t_mc.creado_por = t_users.id
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            LEFT JOIN t_equipos ON t_mc.id_equipo = t_equipos.id
            WHERE t_mc.id = $idPendiente and t_mc.activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $idFalla = $i['id'];
                    $actividad = $i['actividad'];
                    $creadoPor = $i['nombre'] . " " . $i['apellido'];
                    $rangoFecha = $i['rango_fecha'];
                    $fechaInicio = $i['fecha_inicio'];
                    $responsable = $i['responsable'];
                    $equipo = $i['equipo'];

                    if ($equipo == "") {
                        $equipo = "FALLA GENERAL";
                    }

                    // Status
                    $statusUrgente = $i['status_urgente'];
                    $statusTrabajare = $i['status_trabajare'];
                    $statusMaterial = $i['status_material'];
                    $statusElectricidad = $i['energetico_electricidad'];
                    $statusAgua = $i['energetico_agua'];
                    $statusGas = $i['energetico_gas'];
                    $statusDiesel = $i['energetico_diesel'];
                    $statusCompras = $i['departamento_compras'];
                    $statusFinanzas = $i['departamento_finanzas'];
                    $statusRRHH = $i['departamento_rrhh'];
                    $statusDireccion = $i['departamento_direccion'];
                    $statusCalidad = $i['departamento_calidad'];

                    // COMPROVACIÓN RANGO FECHA
                    if ($rangoFecha == "") {
                        $rangoFecha = (new DateTime($fechaInicio))->format('Y-m-d');
                    }

                    // AGREGAR STATUS MODALSTATUS
                    $status .= "                 
                        <div class=\"bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600\" onclick=\"obtenerstatusMC($idPendiente);\">
                            <h1 class=\"font-medium text-sm\"> <i class=\"fas fa-plus\"></i></h1>
                        </div>
                    ";

                    if ($statusUrgente == 0 or $statusUrgente == "") {
                        $status .= "";
                    } else {
                        $status .= "";
                    }

                    if ($statusTrabajare == 0 or $statusTrabajare == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-blue-200 text-blue-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Trabajando</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'status_trabajare', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusMaterial == 0 or $statusMaterial == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-orange-200 text-orange-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Material</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'status_material', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusElectricidad == 0 or $statusElectricidad == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Electricidad</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'energetico_electricidad', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusAgua == 0 or $statusAgua == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Agua</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'energetico_agua', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusGas == 0 or $statusGas == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Gas</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'energetico_gas', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusDiesel == 0 or $statusDiesel == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Diesel</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'energetico_diesel', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusCompras == 0 or $statusCompras == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Compras</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'departamento_compras', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusFinanzas == 0 or $statusFinanzas == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Finanzas</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'departamento_finanzas', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusRRHH == 0 or $statusRRHH == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">RRHH</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'departamento_rrhh', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusCalidad == 0 or $statusCalidad == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Calidad</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'departamento_calidad', 1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusDireccion == 0 or $statusDireccion == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Dirección</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarStatusMC($idPendiente, 'departamento_direccion', 1)\"></i>
                            </div>
                        ";
                    }

                    // RESPONSABLE
                    $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_users 
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id = $responsable";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $responsable = $i['nombre'] . " " . $i['apellido'];

                            $responsable = "
                            <div class=\"bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">$responsable</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\"></i>
                            </div>
                            ";
                        }
                    }

                    // COMENTARIOS
                    $query = "SELECT t_mc_comentarios.comentario, t_mc_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_mc_comentarios
                    INNER JOIN t_users ON t_mc_comentarios.id_usuario = t_users.id
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_mc_comentarios.id_mc = $idFalla and t_mc_comentarios.activo = 1 
                    ORDER BY t_mc_comentarios.id DESC";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $comentario = $i['comentario'];
                            $usuarioComentario = $i['nombre'] . " " . $i['apellido'];
                            $fechaComentario = $i['fecha'];

                            $dataComentariosVP .= "
                                <div class=\"flex flex-row justify-center items-center mb-3 w-full bg-teal-100 text-teal-600 p-2 rounded-md hover:shadow-md cursor-pointer relative\">
                                        <div class=\"flex items-center justify-center\" style=\"width: 30px;\">
                                            <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=$usuarioComentario\" width=\"30\" height=\"30\" alt=\"\">
                                        </div>
                                        <div class=\"flex flex-col justify-start items-start p-2 w-full\">
                                            <div class=\"font-bold flex flex-row justify-between w-full text-xxs\">
                                                <div>
                                                    <h1>$usuarioComentario</h1>
                                                </div>
                                                <div class=\"absolute bottom-0 right-0 mr-1 mb-1\">
                                                    <p class=\"font-mono ml-2 text-teal-400\">$fechaComentario</p>
                                                </div>
                                            </div>
                                            <div class=\"w-full text-xs text-justify\">
                                                <p>$comentario</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    // ADJUNTOS
                    $queryAdjuntos = "SELECT t_mc_adjuntos.id, t_mc_adjuntos.url_adjunto, t_mc_adjuntos.fecha, t_mc_adjuntos.subido_por FROM t_mc_adjuntos 
                    WHERE t_mc_adjuntos.id_mc = $idFalla AND t_mc_adjuntos.activo = 1";
                    if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {

                        foreach ($resultAdjuntos as $value) {
                            $url = $value['url_adjunto'];

                            if (file_exists("../planner/tareas/adjuntos/$url")) {
                                $adjuntoURL = "planner/tareas/adjuntos/$url";
                            } else {
                                $adjuntoURL = "../planner/tareas/adjuntos/$url";
                            }

                            // Admite solo Imagenes.
                            if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {

                                if (strpbrk($adjuntoURL, ' ')) {
                                    $dataImagen .= "
                                    <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"m-2 cursor-pointer overflow-hidden w-20 h-20 rounded-md op2\">
                                            <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                        </div>
                                    </a>
                                    ";
                                } else {
                                    $dataImagen .= "
                                        <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 m-2 cursor-pointer op1\" style=\"background-image: url($adjuntoURL)\">
                                        </div>
                                        </a>
                                    ";
                                }

                                // Admite todo, menos lo anterior.
                            } else {
                                $dataAdjunto .= "
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
                }
                $data['idPendiente'] = $idFalla;
                $data['actividad'] = $actividad;
                $data['fecha'] = $rangoFecha;
                $data['responsable'] = $responsable;
                $data['creadoPor'] = $creadoPor;
                $data['status'] = $status;
                $data['dataComentariosVP'] = $dataComentariosVP;
                $data['adjuntos'] = $dataImagen . $dataAdjunto;
                $data['equipo'] = $equipo;
            }
        } elseif ($tipoPendiente == "TAREA") {
            $query = "SELECT t_mp_np.id, t_mp_np.titulo, t_mp_np.rango_fecha, t_mp_np.responsable,
            t_mp_np.status_material, t_mp_np.status_trabajando, t_mp_np.status_urgente,
            t_mp_np.energetico_electricidad, t_mp_np.energetico_agua, t_mp_np.energetico_diesel, t_mp_np.energetico_gas,
            t_mp_np.departamento_calidad, t_mp_np.departamento_compras, t_mp_np.departamento_direccion, 
            t_mp_np.departamento_finanzas, t_mp_np.departamento_rrhh,
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_mp_np 
            INNER JOIN t_users ON t_mp_np.id_usuario = t_users.id
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_mp_np.id = $idPendiente and t_mp_np.activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $idTarea = $i['id'];
                    $actividad = $i['titulo'];
                    $creadoPor = $i['nombre'] . " " . $i['apellido'];
                    $rangoFecha = $i['rango_fecha'];
                    $responsable = $i['responsable'];
                    $actividadCaracteres = preg_replace('([^A-Za-z0-9 ])', '', $actividad);

                    // Status
                    $statusUrgente = $i['status_urgente'];
                    $statusTrabajare = $i['status_trabajando'];
                    $statusMaterial = $i['status_material'];
                    $statusElectricidad = $i['energetico_electricidad'];
                    $statusAgua = $i['energetico_agua'];
                    $statusGas = $i['energetico_gas'];
                    $statusDiesel = $i['energetico_diesel'];
                    $statusCompras = $i['departamento_compras'];
                    $statusFinanzas = $i['departamento_finanzas'];
                    $statusRRHH = $i['departamento_rrhh'];
                    $statusDireccion = $i['departamento_direccion'];
                    $statusCalidad = $i['departamento_calidad'];

                    // COMPROVACIÓN RANGO FECHA
                    if ($rangoFecha == "") {
                        $rangoFecha = "--";
                    }

                    // AGREGAR STATUS MODALSTATUS
                    $status .= "                 
                        <div onclick=\"obtenerInformacionTareas($idTarea,'$actividadCaracteres');\" class=\"bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600\">
                            <h1 class=\"font-medium text-sm\"> <i class=\"fas fa-plus\"></i></h1>
                        </div>
                    ";

                    if ($statusUrgente == 0 or $statusUrgente == "") {
                        $status .= "";
                    } else {
                        $status .= "";
                    }

                    if ($statusTrabajare == 0 or $statusTrabajare == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-blue-200 text-blue-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Trabajando</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'status_trabajando', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusMaterial == 0 or $statusMaterial == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-orange-200 text-orange-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Material</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'status_material', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusElectricidad == 0 or $statusElectricidad == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Electricidad</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'energetico_electricidad', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusAgua == 0 or $statusAgua == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Agua</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'energetico_agua', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusGas == 0 or $statusGas == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Gas</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'energetico_gas', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusDiesel == 0 or $statusDiesel == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Diesel</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'energetico_diesel', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusCompras == 0 or $statusCompras == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Compras</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'departamento_compras', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusFinanzas == 0 or $statusFinanzas == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Finanzas</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'departamento_finanzas', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusRRHH == 0 or $statusRRHH == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">RRHH</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'departamento_rrhh', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusCalidad == 0 or $statusCalidad == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Calidad</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'departamento_calidad', 0)\"></i>
                            </div>
                        ";
                    }

                    if ($statusDireccion == 0 or $statusDireccion == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Dirección</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarTareas($idPendiente, 'departamento_direccion', 0)\"></i>
                            </div>
                        ";
                    }

                    // RESPONSABLE
                    $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_users 
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id = $responsable";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $responsable = $i['nombre'] . " " . $i['apellido'];

                            $responsable = "
                            <div class=\"bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">$responsable</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\"></i>
                            </div>
                            ";
                        }
                    }

                    // COMENTARIOS
                    $queryComentario = "SELECT comentarios_mp_np.comentario, comentarios_mp_np.fecha, 
                    t_colaboradores.nombre, t_colaboradores.apellido
                    FROM comentarios_mp_np
                    INNER JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE comentarios_mp_np.id_mp_np = $idTarea AND comentarios_mp_np.activo = 1
                    ORDER BY comentarios_mp_np.id DESC
                    ";
                    if ($resultComentario = mysqli_query($conn_2020, $queryComentario)) {
                        foreach ($resultComentario as $value) {
                            $comentario = $value['comentario'];
                            $nombre = $value['nombre'];
                            $apellido = $value['apellido'];
                            $nombreCompleto = $value['nombre'] . " " . $value['apellido'];
                            $fecha = $value['fecha'];

                            if ($fecha != "") {
                                $fecha = (new DateTime($fecha))->format('d-m-Y H:m:s');
                            } else {
                                $fecha = "";
                            }

                            $dataComentariosVP .= "
                                <div class=\"flex flex-row justify-center items-center mb-3 w-full bg-gray-100 p-2 rounded-md hover:shadow-md cursor-pointer\">
                                    <div class=\"flex items-center justify-center\" style=\"width: 48px;\">
                                        <img src=\"https://ui-avatars.com/api/?format=svg&amp;rounded=true&amp;size=300&amp;background=2d3748&amp;color=edf2f7&amp;name=$nombre%$apellido\" width=\"30\" height=\"30\" alt=\"\">
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


                    // ADJUNTOS
                    $queryAdjuntos = "SELECT adjuntos_mp_np.id, adjuntos_mp_np.url, adjuntos_mp_np.fecha, 
                    adjuntos_mp_np.id_usuario FROM adjuntos_mp_np 
                    WHERE adjuntos_mp_np.id_mp_np = $idTarea AND adjuntos_mp_np.activo = 1";
                    if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {

                        foreach ($resultAdjuntos as $value) {
                            $url = $value['url'];

                            if (file_exists("../img/equipos/mpnp/$url")) {
                                $adjuntoURL = "img/equipos/mpnp/$url";
                            } else {
                                $adjuntoURL = "../img/equipos/mpnp/$url";
                            }

                            // Admite solo Imagenes.
                            if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {
                                if (strpbrk($adjuntoURL, ' ')) {
                                    $dataImagen .= "
                                    <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"m-2 cursor-pointer overflow-hidden w-20 h-20 rounded-md op2\">
                                            <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                        </div>
                                    </a>
                                    ";
                                } else {
                                    $dataImagen .= "
                                        <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 m-2 cursor-pointer op1\" style=\"background-image: url($adjuntoURL)\">
                                        </div>
                                        </a>
                                    ";
                                }

                                // Admite todo, menos lo anterior.
                            } else {

                                $dataAdjunto .= "
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
                }
                $data['idPendiente'] = $idTarea;
                $data['actividad'] = $actividad;
                $data['fecha'] = $rangoFecha;
                $data['responsable'] = $responsable;
                $data['creadoPor'] = $creadoPor;
                $data['status'] = $status;
                $data['dataComentariosVP'] = $dataComentariosVP;
                $data['adjuntos'] = $dataImagen . $dataAdjunto;
            }
        } elseif ($tipoPendiente == "PLANACCION") {
            $query = "SELECT t_proyectos_planaccion.id, t_proyectos_planaccion.actividad, t_proyectos_planaccion.responsable, t_proyectos_planaccion.status_urgente,
            t_proyectos_planaccion.rango_fecha, t_proyectos_planaccion.status_material,
            t_proyectos_planaccion.status_trabajando, 
            t_proyectos_planaccion.energetico_electricidad,
            t_proyectos_planaccion.energetico_agua,
            t_proyectos_planaccion.energetico_diesel,
            t_proyectos_planaccion.energetico_gas,
            t_proyectos_planaccion.departamento_calidad,
            t_proyectos_planaccion.departamento_compras,
            t_proyectos_planaccion.departamento_direccion,
            t_proyectos_planaccion.departamento_finanzas,
            t_proyectos_planaccion.departamento_rrhh,
            t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_proyectos_planaccion
            INNER JOIN t_users ON t_proyectos_planaccion.creado_por = t_users.id
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_proyectos_planaccion.id = $idPendiente";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idPlanaccion = $x['id'];
                    $actividad = $x['actividad'];
                    $creadoPor = $x['nombre'] . " " . $x['apellido'];
                    $rangoFecha = $x['rango_fecha'];
                    $responsable = $x['responsable'];

                    // Status
                    $statusUrgente = $x['status_urgente'];
                    $statusMaterial = $x['status_material'];
                    $statusTrabajare = $x['status_trabajando'];
                    $statusElectricidad = $x['energetico_electricidad'];
                    $statusAgua = $x['energetico_agua'];
                    $statusDiesel = $x['energetico_diesel'];
                    $statusGas = $x['energetico_gas'];
                    $statusCalidad = $x['departamento_calidad'];
                    $statusCompras = $x['departamento_compras'];
                    $statusDireccion = $x['departamento_direccion'];
                    $statusFinanzas = $x['departamento_finanzas'];
                    $statusRRHH = $x['departamento_rrhh'];


                    // COMPROVACIÓN RANGO FECHA
                    if ($rangoFecha == "") {
                        $rangoFecha = "--";
                    }

                    // AGREGAR STATUS MODALSTATUS
                    $status .= "                 
                        <div onclick=\"statusPlanaccion($idPlanaccion);\" class=\"bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600\">
                            <h1 class=\"font-medium text-sm\"> <i class=\"fas fa-plus\"></i></h1>
                        </div>
                    ";

                    if ($statusUrgente == 0 or $statusUrgente == "") {
                        $status .= "";
                    } else {
                        $status .= "";
                    }

                    if ($statusTrabajare == 0 or $statusTrabajare == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-blue-200 text-blue-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Trabajando</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'status_trabajando', $idPendiente)\"></i>
                            </div>
                        ";
                    }

                    if ($statusMaterial == 0 or $statusMaterial == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-orange-200 text-orange-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Material</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'status_material',$idPendiente1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusElectricidad == 0 or $statusElectricidad == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Electricidad</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'energetico_electricidad', $idPendiente)\"></i>
                            </div>
                        ";
                    }

                    if ($statusAgua == 0 or $statusAgua == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Agua</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'energetico_agua',$idPendiente1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusGas == 0 or $statusGas == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Gas</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'energetico_gas',$idPendiente1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusDiesel == 0 or $statusDiesel == "") {
                        $status .= "";
                    } else {
                        $status .= "
                            <div class=\"bg-yellow-200 text-yellow-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Diesel</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'energetico_diesel',$idPendiente1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusCompras == 0 or $statusCompras == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Compras</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'departamento_compras', $idPendiente)\"></i>
                            </div>
                        ";
                    }

                    if ($statusFinanzas == 0 or $statusFinanzas == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Finanzas</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'departamento_finanzas', $idPendiente)\"></i>
                            </div>
                        ";
                    }

                    if ($statusRRHH == 0 or $statusRRHH == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">RRHH</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'departamento_rrhh',$idPendiente1)\"></i>
                            </div>
                        ";
                    }

                    if ($statusCalidad == 0 or $statusCalidad == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Calidad</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'departamento_calidad', $idPendiente)\"></i>
                            </div>
                        ";
                    }

                    if ($statusDireccion == 0 or $statusDireccion == "") {
                        $status .= "";
                    } else {
                        $status .= "                        
                            <div class=\"bg-teal-200 text-teal-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">Dirección</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'departamento_direccion', $idPendiente)\"></i>
                            </div>
                        ";
                    }

                    // RESPONSABLE
                    $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_users 
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_users.id = $responsable";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $responsable = $i['nombre'] . " " . $i['apellido'];

                            $responsable = "
                            <div class=\"bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2\">
                                <h1 class=\"font-medium\">$responsable</h1>
                                <i class=\"fas fa-times ml-1 hover:text-red-500 cursor-pointer\" onclick=\"actualizarPlanaccion(0, 'asignarPlanaccion', $idPendiente);\"></i>
                            </div>
                            ";
                        }
                    }

                    // COMENTARIOS
                    $query = "SELECT t_proyectos_planaccion_comentarios.comentario, t_proyectos_planaccion_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido 
                    FROM t_proyectos_planaccion_comentarios
                    INNER JOIN t_users ON t_proyectos_planaccion_comentarios.usuario = t_users.id
                    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                    WHERE t_proyectos_planaccion_comentarios.id_actividad = $idPlanaccion and t_proyectos_planaccion_comentarios.activo = 1 
                    ORDER BY t_proyectos_planaccion_comentarios.id DESC";
                    $dataComentariosVP = "";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $comentario = $i['comentario'];
                            $usuarioComentario = $i['nombre'] . " " . $i['apellido'];
                            $fechaComentario = $i['fecha'];

                            $dataComentariosVP .= "
                                <div class=\"flex flex-row justify-center items-center mb-3 w-full bg-teal-100 text-teal-600 p-2 rounded-md hover:shadow-md cursor-pointer relative\">
                                        <div class=\"flex items-center justify-center\" style=\"width: 30px;\">
                                            <img src=\"https://ui-avatars.com/api/?format=svg&rounded=true&size=300&background=2d3748&color=edf2f7&name=$usuarioComentario\" width=\"30\" height=\"30\" alt=\"\">
                                        </div>
                                        <div class=\"flex flex-col justify-start items-start p-2 w-full\">
                                            <div class=\"font-bold flex flex-row justify-between w-full text-xxs\">
                                                <div>
                                                    <h1>$usuarioComentario</h1>
                                                </div>
                                                <div class=\"absolute bottom-0 right-0 mr-1 mb-1\">
                                                    <p class=\"font-mono ml-2 text-teal-400\">$fechaComentario</p>
                                                </div>
                                            </div>
                                            <div class=\"w-full text-xs text-justify\">
                                                <p>$comentario</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ";
                        }
                    }

                    // ADJUNTOS
                    $queryAdjuntos = "SELECT t_proyectos_planaccion_adjuntos.id, t_proyectos_planaccion_adjuntos.url_adjunto, t_proyectos_planaccion_adjuntos.fecha_creado, t_proyectos_planaccion_adjuntos.subido_por 
                    FROM t_proyectos_planaccion_adjuntos 
                    WHERE t_proyectos_planaccion_adjuntos.id_actividad = $idPlanaccion AND t_proyectos_planaccion_adjuntos.status = 1";
                    if ($resultAdjuntos = mysqli_query($conn_2020, $queryAdjuntos)) {

                        foreach ($resultAdjuntos as $value) {
                            $url = $value['url_adjunto'];

                            if (file_exists("../planner/proyectos/$url")) {
                                $adjuntoURL = "planner/proyectos/$url";
                            } elseif (file_exists("../planner/proyectos/planaccion/$url")) {
                                $adjuntoURL = "planner/proyectos/planaccion/$url";
                            } elseif (file_exists("../../planner/proyectos/$url")) {
                                $adjuntoURL = "../planner/proyectos/$url";
                            } else {
                                $adjuntoURL = "../planner/proyectos/planaccion/$url";
                            }

                            // Admite solo Imagenes.
                            if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "JPG") || strpos($url, "JPEG") || strpos($url, "PNG")) {
                                if (strpbrk($adjuntoURL, ' ')) {
                                    $dataImagen .= "
                                    <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"m-2 cursor-pointer overflow-hidden w-20 h-20 rounded-md\">
                                            <img src=\"$adjuntoURL\" class=\"w-full\" alt=\"\">
                                        </div>
                                    </a>
                                    ";
                                } else {
                                    $dataImagen .= "
                                        <a href=\"$adjuntoURL\" target=\"_blank\">
                                        <div class=\"bg-local bg-cover bg-center w-20 h-20 rounded-md border-2 m-2 cursor-pointer\" style=\"background-image: url($adjuntoURL)\">
                                        </div>
                                        </a>
                                    ";
                                }

                                // Admite todo, menos lo anterior.
                            } else {

                                $dataAdjunto .= "
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
                }

                $data['idPendiente'] = $idPlanaccion;
                $data['actividad'] = $actividad;
                $data['fecha'] = $rangoFecha;
                $data['responsable'] = $responsable;
                $data['creadoPor'] = $creadoPor;
                $data['status'] = $status;
                $data['dataComentariosVP'] = $dataComentariosVP;
                $data['adjuntos'] = $dataImagen . $dataAdjunto;
                $data['equipo'] = "PROYECTO";
            }
        }
        echo json_encode($data);
    }


    // Agrega comentario según el tipo de pendiente
    if ($action == "comentarioVP") {
        $idPendiente = $_POST['idPendiente'];
        $tipoPendiente = $_POST['tipoPendiente'];
        $comentario = $_POST['comentario'];

        if ($tipoPendiente == "TAREA") {
            $query = "INSERT INTO comentarios_mp_np(id_mp_np, comentario, id_usuario, fecha) VALUES($idPendiente, '$comentario', $idUsuario, '$fechaActual')";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 1;
            } else {
                echo 0;
            }
        } elseif ($tipoPendiente == "FALLA") {
            $query = "INSERT INTO t_mc_comentarios(id_mc, comentario, id_usuario, fecha, activo) VALUES($idPendiente, '$comentario', $idUsuario, '$fechaActual', 1)";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }


    #****************** INFORMACIÓN DE EQUIPO Y MP ******************

    // Obtiene información del Equipo
    if ($action == "informacionEquipo") {
        $idEquipo = $_POST['idEquipo'];
        $data = array();

        // Valores por DEFAULT
        $data['equipo'] = "";

        $query = "SELECT t_equipos_america.id, t_equipos_america.local_equipo, t_equipos_america.id_equipo_principal, t_equipos_america.id_marca, c_secciones.id 'id_seccion', c_subsecciones.id 'id_subseccion', t_equipos_america.equipo, t_equipos_america.status, t_equipos_america.jerarquia, t_equipos_america.id_tipo, t_equipos_america.modelo, t_equipos_america.numero_serie, t_equipos_america.codigo_fabricante, t_equipos_america.codigo_interno_compras, t_equipos_america.largo_cm, t_equipos_america.ancho_cm, t_equipos_america.alto_cm, t_equipos_america.potencia_electrica_hp, 
        t_equipos_america.potencia_electrica_kw, t_equipos_america.voltaje_v, t_equipos_america.frecuencia_hz, t_equipos_america.caudal_agua_m3h, t_equipos_america.caudal_agua_gph, t_equipos_america.carga_mca, t_equipos_america.potencia_energetica_frio_kw, t_equipos_america.potencia_energetica_frio_tr, t_equipos_america.potencia_energetica_calor_kcal, t_equipos_america.caudal_aire_m3h, 
        t_equipos_america.coste, t_equipos_america.caudal_aire_cfm, t_equipos_america.id_fases
        FROM t_equipos_america 
        INNER JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        INNER JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        WHERE t_equipos_america.id = $idEquipo and t_equipos_america.activo = 1";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $idEquipoPrincipal = $i['id_equipo_principal'];
                $equipo = $i['equipo'];
                $idSeccion = $i['id_seccion'];
                $idSubseccion = $i['id_subseccion'];
                $jerarquia = $i['jerarquia'];
                $modelo = $i['modelo'];
                $numero_serie = $i['numero_serie'];
                $codigo_fabricante = $i['codigo_fabricante'];
                $codigo_interno_compras = $i['codigo_interno_compras'];
                $largo_cm = $i['largo_cm'];
                $ancho_cm = $i['ancho_cm'];
                $alto_cm = $i['alto_cm'];
                $potencia_electrica_hp = $i['potencia_electrica_hp'];
                $potencia_electrica_kw = $i['potencia_electrica_kw'];
                $voltaje_v = $i['voltaje_v'];
                $frecuencia_hz = $i['frecuencia_hz'];
                $caudal_agua_m3h = $i['caudal_agua_m3h'];
                $caudal_agua_gph = $i['caudal_agua_gph'];
                $carga_mca = $i['carga_mca'];
                $potencia_energetica_frio_kw = $i['potencia_energetica_frio_kw'];
                $potencia_energetica_frio_tr = $i['potencia_energetica_frio_tr'];
                $potencia_energetica_calor_kcal = $i['potencia_energetica_calor_kcal'];
                $caudal_aire_m3h = $i['caudal_aire_m3h'];
                $coste = $i['coste'];
                $caudal_aire_cfm = $i['caudal_aire_cfm'];
                $status = $i['status'];
                $tipo = $i['id_tipo'];
                $idFases = $i['id_fases'];
                $tipoLocalEquipo = $i['local_equipo'];
                $id_marca = $i['id_marca'];

                $data['idEquipo'] = $id;
                $data['idEquipoPrincipal'] = $idEquipoPrincipal;
                $data['equipo'] = $equipo;
                $data['idSeccion'] = $idSeccion;
                $data['idSubseccion'] = $idSubseccion;
                $data['jerarquia'] = $jerarquia;
                $data['modelo'] = $modelo;
                $data['numero_serie'] = $numero_serie;
                $data['codigo_fabricante'] = $codigo_fabricante;
                $data['codigo_interno_compras'] = $codigo_interno_compras;
                $data['largo_cm'] = $largo_cm;
                $data['ancho_cm'] = $ancho_cm;
                $data['alto_cm'] = $alto_cm;
                $data['potencia_electrica_hp'] = $potencia_electrica_hp;
                $data['potencia_electrica_kw'] = $potencia_electrica_kw;
                $data['voltaje_v'] = $voltaje_v;
                $data['frecuencia_hz'] = $frecuencia_hz;
                $data['caudal_agua_m3h'] = $caudal_agua_m3h;
                $data['caudal_agua_gph'] = $caudal_agua_gph;
                $data['carga_mca'] = $carga_mca;
                $data['potencia_energetica_frio_kw'] = $potencia_energetica_frio_kw;
                $data['potencia_energetica_frio_tr'] = $potencia_energetica_frio_tr;
                $data['potencia_energetica_calor_kcal'] = $potencia_energetica_calor_kcal;
                $data['caudal_aire_m3h'] = $caudal_aire_m3h;
                $data['coste'] = $coste;
                $data['caudal_aire_cfm'] = $caudal_aire_cfm;
                $data['status'] = $status;
                $data['tipo'] = $tipo;
                $data['semanaActual'] = $semanaActual;
                $data['idFases'] = $idFases;
                $data['tipoLocalEquipo'] = $tipoLocalEquipo;
                $data['id_marca'] = $id_marca;
            }
        }
        echo json_encode($data);
    }


    if ($action == "actualizarEquipo") {
        $idEquipo = $_POST['idEquipo'];
        $nombreEquipo = $_POST['nombreEquipo'];
        $seccionEquipo = $_POST['seccionEquipo'];
        $subseccionEquipo = $_POST['subseccionEquipo'];
        $tipoEquipo = $_POST['tipoEquipo'];
        $jerarquiaEquipo = $_POST['jerarquiaEquipo'];
        $equipoPrincipal = $_POST['equipoPrincipal'];
        $marcaEquipo = $_POST['marcaEquipo'];
        $modeloEquipo = $_POST['modeloEquipo'];
        $serieEquipo = $_POST['serieEquipo'];
        $codigoFabricanteEquipo = $_POST['codigoFabricanteEquipo'];
        $codigoInternoComprasEquipo = $_POST['codigoInternoComprasEquipo'];
        $largoEquipo = $_POST['largoEquipo'];
        $anchoEquipo = $_POST['anchoEquipo'];
        $altoEquipo = $_POST['altoEquipo'];
        $potenciaElectricaHPEquipo = $_POST['potenciaElectricaHPEquipo'];
        $potenciaElectricaKWEquipo = $_POST['potenciaElectricaKWEquipo'];
        $voltajeEquipo = $_POST['voltajeEquipo'];
        $frecuenciaEquipo = $_POST['frecuenciaEquipo'];
        $caudalAguaM3HEquipo = $_POST['caudalAguaM3HEquipo'];
        $caudalAguaGPHEquipo = $_POST['caudalAguaGPHEquipo'];
        $cargaMCAEquipo = $_POST['cargaMCAEquipo'];
        $PotenciaEnergeticaFrioKWEquipo = $_POST['PotenciaEnergeticaFrioKWEquipo'];
        $potenciaEnergeticaFrioTREquipo = $_POST['potenciaEnergeticaFrioTREquipo'];
        $potenciaEnergeticaCalorKCALEquipo = $_POST['potenciaEnergeticaCalorKCALEquipo'];
        $caudalAireM3HEquipo = $_POST['caudalAireM3HEquipo'];
        $caudalAireCFMEquipo = $_POST['caudalAireCFMEquipo'];
        $estadoEquipo = $_POST['estadoEquipo'];
        $idFaseEquipo = $_POST['idFaseEquipo'];
        $tipoLocalEquipo = $_POST['tipoLocalEquipo'];

        if ($idFaseEquipo <= 0) {
            $idFaseEquipo = 0;
        }

        if ($jerarquiaEquipo == "PRIMARIO") {
            $equipoPrincipal = 0;
        }

        $query = "UPDATE t_equipos_america SET 
        id_equipo_principal = '$equipoPrincipal',
        equipo = '$nombreEquipo', 
        id_seccion = $seccionEquipo, 
        id_subseccion = $subseccionEquipo,
        id_tipo = $tipoEquipo,
        jerarquia = '$jerarquiaEquipo',
        id_marca = $marcaEquipo,
        modelo = '$modeloEquipo',
        numero_serie = '$serieEquipo',
        codigo_fabricante = '$codigoFabricanteEquipo',
        codigo_interno_compras = '$codigoInternoComprasEquipo',
        largo_cm = $largoEquipo,
        ancho_cm = $anchoEquipo,
        alto_cm = $altoEquipo,
        potencia_electrica_hp = $potenciaElectricaHPEquipo,
        potencia_electrica_kw = $potenciaElectricaKWEquipo,
        voltaje_v = $voltajeEquipo,
        frecuencia_hz = $frecuenciaEquipo, 
        caudal_agua_m3h = $caudalAguaM3HEquipo,
        caudal_agua_gph = $caudalAguaGPHEquipo,
        carga_mca = $cargaMCAEquipo,
        potencia_energetica_frio_kw = $PotenciaEnergeticaFrioKWEquipo,
        potencia_energetica_frio_tr = $potenciaEnergeticaFrioTREquipo,
        potencia_energetica_calor_kcal = $potenciaEnergeticaCalorKCALEquipo,
        caudal_aire_m3h = $caudalAireM3HEquipo,
        status = '$estadoEquipo',
        id_fases = '$idFaseEquipo',
        local_equipo = '$tipoLocalEquipo'
        WHERE id = $idEquipo";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    // OBTIENE PLANES TIPO EQUIPO Y (PREVENTIVO Y TEST)
    if ($action == "consultarPlanEquipo") {
        $idEquipo = $_POST['idEquipo'];
        $año = date('y');
        $data = array();
        $array = array();

        $query = "SELECT t_equipos_america.id 'idEquipo', t_equipos_america.id_destino, t_mp_planes_mantenimiento.tipo_local_equipo, t_mp_planes_mantenimiento.id 'idPlan', t_mp_planes_mantenimiento.tipo_plan, 
        c_frecuencias_mp.frecuencia, t_mp_planes_mantenimiento.grado
        FROM t_equipos_america 
        INNER JOIN t_mp_planes_mantenimiento ON t_equipos_america.id_tipo = t_mp_planes_mantenimiento.tipo_local_equipo
        and t_mp_planes_mantenimiento.local_equipo = t_equipos_america.local_equipo 
        and (t_equipos_america.id_destino = t_mp_planes_mantenimiento.id_destino ||
        t_mp_planes_mantenimiento.id_destino = 10) and
        (t_mp_planes_mantenimiento.tipo_plan = 'PREVENTIVO' || t_mp_planes_mantenimiento.tipo_plan = 'TEST')
        INNER JOIN c_frecuencias_mp ON t_mp_planes_mantenimiento.id_periodicidad = c_frecuencias_mp.id
        WHERE t_equipos_america.id = $idEquipo and t_equipos_america.activo = 1 and 
        t_mp_planes_mantenimiento.status = 'ACTIVO'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idEquipo = $i['idEquipo'];
                $idDestino = $i['id_destino'];
                $idPlan = $i['idPlan'];
                $idTipo = $i['tipo_local_equipo'];
                $tipoPlan = $i['tipo_plan'];
                $grado = $i['grado'];
                $periodicidad = $i['frecuencia'];

                $queryPlaneacion = "SELECT 
                t_mp_planeacion_semana.id_equipo, t_mp_planeacion_semana.id 'semana', 
                t_mp_planeacion_proceso.id 'proceso',
                t_mp_planeacion_semana.semana_1 'semana_1', t_mp_planeacion_semana.semana_2 'semana_2', t_mp_planeacion_semana.semana_3 'semana_3', t_mp_planeacion_semana.semana_4 'semana_4', t_mp_planeacion_semana.semana_5 'semana_5', t_mp_planeacion_semana.semana_6 'semana_6', t_mp_planeacion_semana.semana_7 'semana_7', t_mp_planeacion_semana.semana_8 'semana_8', t_mp_planeacion_semana.semana_9 'semana_9', t_mp_planeacion_semana.semana_10 'semana_10', t_mp_planeacion_semana.semana_11 'semana_11', t_mp_planeacion_semana.semana_12 'semana_12', t_mp_planeacion_semana.semana_13 'semana_13', t_mp_planeacion_semana.semana_14 'semana_14', t_mp_planeacion_semana.semana_15 'semana_15', t_mp_planeacion_semana.semana_16 'semana_16', t_mp_planeacion_semana.semana_17 'semana_17', t_mp_planeacion_semana.semana_18 'semana_18', t_mp_planeacion_semana.semana_19 'semana_19', t_mp_planeacion_semana.semana_20 'semana_20', t_mp_planeacion_semana.semana_21 'semana_21', t_mp_planeacion_semana.semana_22 'semana_22', t_mp_planeacion_semana.semana_23 'semana_23', t_mp_planeacion_semana.semana_24 'semana_24', t_mp_planeacion_semana.semana_25 'semana_25', t_mp_planeacion_semana.semana_26 'semana_26', t_mp_planeacion_semana.semana_27 'semana_27', t_mp_planeacion_semana.semana_28 'semana_28', t_mp_planeacion_semana.semana_29 'semana_29', t_mp_planeacion_semana.semana_30 'semana_30', t_mp_planeacion_semana.semana_31 'semana_31', t_mp_planeacion_semana.semana_32 'semana_32', t_mp_planeacion_semana.semana_33 'semana_33', t_mp_planeacion_semana.semana_34 'semana_34', t_mp_planeacion_semana.semana_35 'semana_35', t_mp_planeacion_semana.semana_36 'semana_36', t_mp_planeacion_semana.semana_37 'semana_37', t_mp_planeacion_semana.semana_38 'semana_38', t_mp_planeacion_semana.semana_39 'semana_39', t_mp_planeacion_semana.semana_40 'semana_40', t_mp_planeacion_semana.semana_41 'semana_41', t_mp_planeacion_semana.semana_42 'semana_42', t_mp_planeacion_semana.semana_43 'semana_43', t_mp_planeacion_semana.semana_44 'semana_44', t_mp_planeacion_semana.semana_45 'semana_45', t_mp_planeacion_semana.semana_46 'semana_46', t_mp_planeacion_semana.semana_47 'semana_47', t_mp_planeacion_semana.semana_48 'semana_48', t_mp_planeacion_semana.semana_49 'semana_49', t_mp_planeacion_semana.semana_50 'semana_50', t_mp_planeacion_semana.semana_51 'semana_51', t_mp_planeacion_semana.semana_52 'semana_52',
                t_mp_planeacion_proceso.semana_1 'proceso_1', t_mp_planeacion_proceso.semana_2 'proceso_2', t_mp_planeacion_proceso.semana_3 'proceso_3', t_mp_planeacion_proceso.semana_4 'proceso_4', t_mp_planeacion_proceso.semana_5 'proceso_5', t_mp_planeacion_proceso.semana_6 'proceso_6', t_mp_planeacion_proceso.semana_7 'proceso_7', t_mp_planeacion_proceso.semana_8 'proceso_8', t_mp_planeacion_proceso.semana_9 'proceso_9', t_mp_planeacion_proceso.semana_10 'proceso_10', t_mp_planeacion_proceso.semana_11 'proceso_11',t_mp_planeacion_proceso.semana_12 'proceso_12',t_mp_planeacion_proceso.semana_13 'proceso_13',t_mp_planeacion_proceso.semana_14 'proceso_14',t_mp_planeacion_proceso.semana_15 'proceso_15',t_mp_planeacion_proceso.semana_16 'proceso_16',t_mp_planeacion_proceso.semana_17 'proceso_17',t_mp_planeacion_proceso.semana_18 'proceso_18',t_mp_planeacion_proceso.semana_19 'proceso_19',t_mp_planeacion_proceso.semana_20 'proceso_20',t_mp_planeacion_proceso.semana_21 'proceso_21',t_mp_planeacion_proceso.semana_22 'proceso_22',t_mp_planeacion_proceso.semana_23 'proceso_23',t_mp_planeacion_proceso.semana_24 'proceso_24',t_mp_planeacion_proceso.semana_25 'proceso_25',t_mp_planeacion_proceso.semana_26 'proceso_26',t_mp_planeacion_proceso.semana_27 'proceso_27',t_mp_planeacion_proceso.semana_28 'proceso_28',t_mp_planeacion_proceso.semana_29 'proceso_29',t_mp_planeacion_proceso.semana_30 'proceso_30',t_mp_planeacion_proceso.semana_31 'proceso_31',t_mp_planeacion_proceso.semana_32 'proceso_32',t_mp_planeacion_proceso.semana_33 'proceso_33',t_mp_planeacion_proceso.semana_34 'proceso_34',t_mp_planeacion_proceso.semana_35 'proceso_35',t_mp_planeacion_proceso.semana_36 'proceso_36',t_mp_planeacion_proceso.semana_37 'proceso_37',t_mp_planeacion_proceso.semana_38 'proceso_38',t_mp_planeacion_proceso.semana_39 'proceso_39',t_mp_planeacion_proceso.semana_40 'proceso_40',t_mp_planeacion_proceso.semana_41 'proceso_41',t_mp_planeacion_proceso.semana_42 'proceso_42',t_mp_planeacion_proceso.semana_43 'proceso_43',t_mp_planeacion_proceso.semana_44 'proceso_44',t_mp_planeacion_proceso.semana_45 'proceso_45',t_mp_planeacion_proceso.semana_46 'proceso_46',t_mp_planeacion_proceso.semana_47 'proceso_47',t_mp_planeacion_proceso.semana_48 'proceso_48',t_mp_planeacion_proceso.semana_49 'proceso_49',t_mp_planeacion_proceso.semana_50 'proceso_50',t_mp_planeacion_proceso.semana_51 'proceso_51',t_mp_planeacion_proceso.semana_52 'proceso_52'
                FROM t_mp_planeacion_semana 
                INNER JOIN t_mp_planeacion_proceso ON t_mp_planeacion_semana.id_equipo = t_mp_planeacion_proceso.id_equipo and t_mp_planeacion_semana.id_plan = t_mp_planeacion_proceso.id_plan
                WHERE t_mp_planeacion_semana.id_plan = $idPlan and t_mp_planeacion_semana.id_equipo = $idEquipo and t_mp_planeacion_proceso.año = '$año'";
                if ($resultPlaneacion = mysqli_query($conn_2020, $queryPlaneacion)) {
                    if (mysqli_num_rows($resultPlaneacion) > 0) {
                        foreach ($resultPlaneacion as $key => $i) {
                            $idSemana = $i['semana'];
                            $idProceso = $i['proceso'];
                            $idEquipo = $i['id_equipo'];
                            $semana_planificacion_1 = $i['semana_1'];
                            $semana_planificacion_2 = $i['semana_2'];
                            $semana_planificacion_3 = $i['semana_3'];
                            $semana_planificacion_4 = $i['semana_4'];
                            $semana_planificacion_5 = $i['semana_5'];
                            $semana_planificacion_6 = $i['semana_6'];
                            $semana_planificacion_7 = $i['semana_7'];
                            $semana_planificacion_8 = $i['semana_8'];
                            $semana_planificacion_9 = $i['semana_9'];
                            $semana_planificacion_10 = $i['semana_10'];
                            $semana_planificacion_11 = $i['semana_11'];
                            $semana_planificacion_12 = $i['semana_12'];
                            $semana_planificacion_13 = $i['semana_13'];
                            $semana_planificacion_14 = $i['semana_14'];
                            $semana_planificacion_15 = $i['semana_15'];
                            $semana_planificacion_16 = $i['semana_16'];
                            $semana_planificacion_17 = $i['semana_17'];
                            $semana_planificacion_18 = $i['semana_18'];
                            $semana_planificacion_19 = $i['semana_19'];
                            $semana_planificacion_20 = $i['semana_20'];
                            $semana_planificacion_21 = $i['semana_21'];
                            $semana_planificacion_22 = $i['semana_22'];
                            $semana_planificacion_23 = $i['semana_23'];
                            $semana_planificacion_24 = $i['semana_24'];
                            $semana_planificacion_25 = $i['semana_25'];
                            $semana_planificacion_26 = $i['semana_26'];
                            $semana_planificacion_27 = $i['semana_27'];
                            $semana_planificacion_28 = $i['semana_28'];
                            $semana_planificacion_29 = $i['semana_29'];
                            $semana_planificacion_30 = $i['semana_30'];
                            $semana_planificacion_31 = $i['semana_31'];
                            $semana_planificacion_32 = $i['semana_32'];
                            $semana_planificacion_33 = $i['semana_33'];
                            $semana_planificacion_34 = $i['semana_34'];
                            $semana_planificacion_35 = $i['semana_35'];
                            $semana_planificacion_36 = $i['semana_36'];
                            $semana_planificacion_37 = $i['semana_37'];
                            $semana_planificacion_38 = $i['semana_38'];
                            $semana_planificacion_39 = $i['semana_39'];
                            $semana_planificacion_40 = $i['semana_40'];
                            $semana_planificacion_41 = $i['semana_41'];
                            $semana_planificacion_42 = $i['semana_42'];
                            $semana_planificacion_43 = $i['semana_43'];
                            $semana_planificacion_44 = $i['semana_44'];
                            $semana_planificacion_45 = $i['semana_45'];
                            $semana_planificacion_46 = $i['semana_46'];
                            $semana_planificacion_47 = $i['semana_47'];
                            $semana_planificacion_48 = $i['semana_48'];
                            $semana_planificacion_49 = $i['semana_49'];
                            $semana_planificacion_50 = $i['semana_50'];
                            $semana_planificacion_51 = $i['semana_51'];
                            $semana_planificacion_52 = $i['semana_52'];
                            $semana_proceso_1 = $i['proceso_1'];
                            $semana_proceso_2 = $i['proceso_2'];
                            $semana_proceso_3 = $i['proceso_3'];
                            $semana_proceso_4 = $i['proceso_4'];
                            $semana_proceso_5 = $i['proceso_5'];
                            $semana_proceso_6 = $i['proceso_6'];
                            $semana_proceso_7 = $i['proceso_7'];
                            $semana_proceso_8 = $i['proceso_8'];
                            $semana_proceso_9 = $i['proceso_9'];
                            $semana_proceso_10 = $i['proceso_10'];
                            $semana_proceso_11 = $i['proceso_11'];
                            $semana_proceso_12 = $i['proceso_12'];
                            $semana_proceso_13 = $i['proceso_13'];
                            $semana_proceso_14 = $i['proceso_14'];
                            $semana_proceso_15 = $i['proceso_15'];
                            $semana_proceso_16 = $i['proceso_16'];
                            $semana_proceso_17 = $i['proceso_17'];
                            $semana_proceso_18 = $i['proceso_18'];
                            $semana_proceso_19 = $i['proceso_19'];
                            $semana_proceso_20 = $i['proceso_20'];
                            $semana_proceso_21 = $i['proceso_21'];
                            $semana_proceso_22 = $i['proceso_22'];
                            $semana_proceso_23 = $i['proceso_23'];
                            $semana_proceso_24 = $i['proceso_24'];
                            $semana_proceso_25 = $i['proceso_25'];
                            $semana_proceso_26 = $i['proceso_26'];
                            $semana_proceso_27 = $i['proceso_27'];
                            $semana_proceso_28 = $i['proceso_28'];
                            $semana_proceso_29 = $i['proceso_29'];
                            $semana_proceso_30 = $i['proceso_30'];
                            $semana_proceso_31 = $i['proceso_31'];
                            $semana_proceso_32 = $i['proceso_32'];
                            $semana_proceso_33 = $i['proceso_33'];
                            $semana_proceso_34 = $i['proceso_34'];
                            $semana_proceso_35 = $i['proceso_35'];
                            $semana_proceso_36 = $i['proceso_36'];
                            $semana_proceso_37 = $i['proceso_37'];
                            $semana_proceso_38 = $i['proceso_38'];
                            $semana_proceso_39 = $i['proceso_39'];
                            $semana_proceso_40 = $i['proceso_40'];
                            $semana_proceso_41 = $i['proceso_41'];
                            $semana_proceso_42 = $i['proceso_42'];
                            $semana_proceso_43 = $i['proceso_43'];
                            $semana_proceso_44 = $i['proceso_44'];
                            $semana_proceso_45 = $i['proceso_45'];
                            $semana_proceso_46 = $i['proceso_46'];
                            $semana_proceso_47 = $i['proceso_47'];
                            $semana_proceso_48 = $i['proceso_48'];
                            $semana_proceso_49 = $i['proceso_49'];
                            $semana_proceso_50 = $i['proceso_50'];
                            $semana_proceso_51 = $i['proceso_51'];
                            $semana_proceso_52 = $i['proceso_52'];


                            // Contador de MP
                            $proceso = 0;
                            $solucionado = 0;
                            $planificado = 0;

                            $z =
                                $semana_proceso_1 . ";" . $semana_proceso_2 . ";" . $semana_proceso_3 . ";" . $semana_proceso_4 . ";" . $semana_proceso_5 . ";" . $semana_proceso_6 . ";" . $semana_proceso_7 . ";" . $semana_proceso_8 . ";" . $semana_proceso_9 . ";" . $semana_proceso_10 . ";" . $semana_proceso_11 . ";" . $semana_proceso_12 . ";" . $semana_proceso_13 . ";" . $semana_proceso_14 . ";" . $semana_proceso_15 . ";" . $semana_proceso_16 . ";" . $semana_proceso_17 . ";" . $semana_proceso_18 . ";" . $semana_proceso_19 . ";" . $semana_proceso_20 . ";" . $semana_proceso_21 . ";" . $semana_proceso_22 . ";" . $semana_proceso_23 . ";" . $semana_proceso_24 . ";" . $semana_proceso_25 . ";" . $semana_proceso_26 . ";" . $semana_proceso_27 . ";" . $semana_proceso_28 . ";" . $semana_proceso_29 . ";" . $semana_proceso_30 . ";" . $semana_proceso_31 . ";" . $semana_proceso_32 . ";" . $semana_proceso_33 . ";" . $semana_proceso_34 . ";" . $semana_proceso_35 . ";" . $semana_proceso_36 . ";" . $semana_proceso_37 . ";" . $semana_proceso_38 . ";" . $semana_proceso_39 . ";" . $semana_proceso_40 . ";" . $semana_proceso_41 . ";" . $semana_proceso_42 . ";" . $semana_proceso_43 . ";" . $semana_proceso_44 . ";" . $semana_proceso_45 . ";" . $semana_proceso_46 . ";" . $semana_proceso_47 . ";" . $semana_proceso_48 . ";" . $semana_proceso_49 . ";" . $semana_proceso_50 . ";" . $semana_proceso_51 . ";" . $semana_proceso_52;
                            $z = explode(";", $z);

                            for ($i = 0; $i < count($z); $i++) {

                                if ($z[$i] == "PROCESO") {
                                    $proceso++;
                                } elseif ($z[$i] == "SOLUCIONADO") {
                                    $solucionado++;
                                }
                            }

                            $y =
                                $semana_planificacion_1 . ";" . $semana_planificacion_2 . ";" . $semana_planificacion_3 . ";" . $semana_planificacion_4 . ";" . $semana_planificacion_5 . ";" . $semana_planificacion_6 . ";" . $semana_planificacion_7 . ";" . $semana_planificacion_8 . ";" . $semana_planificacion_9 . ";" . $semana_planificacion_10 . ";" . $semana_planificacion_11 . ";" . $semana_planificacion_12 . ";" . $semana_planificacion_13 . ";" . $semana_planificacion_14 . ";" . $semana_planificacion_15 . ";" . $semana_planificacion_16 . ";" . $semana_planificacion_17 . ";" . $semana_planificacion_18 . ";" . $semana_planificacion_19 . ";" . $semana_planificacion_20 . ";" . $semana_planificacion_21 . ";" . $semana_planificacion_22 . ";" . $semana_planificacion_23 . ";" . $semana_planificacion_24 . ";" . $semana_planificacion_25 . ";" . $semana_planificacion_26 . ";" . $semana_planificacion_27 . ";" . $semana_planificacion_28 . ";" . $semana_planificacion_29 . ";" . $semana_planificacion_30 . ";" . $semana_planificacion_31 . ";" . $semana_planificacion_32 . ";" . $semana_planificacion_33 . ";" . $semana_planificacion_34 . ";" . $semana_planificacion_35 . ";" . $semana_planificacion_36 . ";" . $semana_planificacion_37 . ";" . $semana_planificacion_38 . ";" . $semana_planificacion_39 . ";" . $semana_planificacion_40 . ";" . $semana_planificacion_41 . ";" . $semana_planificacion_42 . ";" . $semana_planificacion_43 . ";" . $semana_planificacion_44 . ";" . $semana_planificacion_45 . ";" . $semana_planificacion_46 . ";" . $semana_planificacion_47 . ";" . $semana_planificacion_48 . ";" . $semana_planificacion_49 . ";" . $semana_planificacion_50 . ";" . $semana_planificacion_51 . ";" . $semana_planificacion_52;
                            $y = explode(";", $y);

                            for ($i = 0; $i < count($y); $i++) {

                                if ($y[$i] == "PLANIFICADO") {
                                    $planificado++;
                                }
                            }

                            #BUSCA ID DE SEMANA
                            $arrayX = array();
                            $query = "SELECT id, semana, año, fecha_creacion, status 
                            FROM t_mp_planificacion_iniciada
                            WHERE id_equipo = $idEquipo and activo = 1 and status IN('PROCESO', 'SOLUCIONADO') and id_plan = $idPlan and año = '$año'";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                foreach ($result as $x) {
                                    $idOT_x = $x['id'];
                                    $samanaX_x = $x['semana'];
                                    $año_x = $x['año'];
                                    $fechaCreado_x = $x['fecha_creacion'];
                                    $status_x = $x['status'];

                                    $arrayX[$samanaX_x] = array(
                                        "idOT" => intval($idOT_x),
                                        "samanaX" => intval($samanaX_x),
                                        "año" => $año_x,
                                        "fechaCreado" => $fechaCreado_x,
                                        "status" => $status_x
                                    );
                                }
                            }

                            $array['planes'][] =
                                array(
                                    "proceso" => $proceso,
                                    "solucionado" => $solucionado,
                                    "planificado" => $planificado,
                                    "idSemana" => $idSemana,
                                    "idProceso" => $idProceso,
                                    "idEquipo" => $idEquipo,
                                    "idPlan" => $idPlan,
                                    "grado" => $grado,
                                    "periodicidad" => $periodicidad,
                                    "tipoPlan" => $tipoPlan,
                                    "ids" => $arrayX,
                                    "semana_1" => $semana_planificacion_1,
                                    "semana_2" => $semana_planificacion_2,
                                    "semana_3" => $semana_planificacion_3,
                                    "semana_4" => $semana_planificacion_4,
                                    "semana_5" => $semana_planificacion_5,
                                    "semana_6" => $semana_planificacion_6,
                                    "semana_7" => $semana_planificacion_7,
                                    "semana_8" => $semana_planificacion_8,
                                    "semana_9" => $semana_planificacion_9,
                                    "semana_10" => $semana_planificacion_10,
                                    "semana_11" => $semana_planificacion_11,
                                    "semana_12" => $semana_planificacion_12,
                                    "semana_13" => $semana_planificacion_13,
                                    "semana_14" => $semana_planificacion_14,
                                    "semana_15" => $semana_planificacion_15,
                                    "semana_16" => $semana_planificacion_16,
                                    "semana_17" => $semana_planificacion_17,
                                    "semana_18" => $semana_planificacion_18,
                                    "semana_19" => $semana_planificacion_19,
                                    "semana_20" => $semana_planificacion_20,
                                    "semana_21" => $semana_planificacion_21,
                                    "semana_22" => $semana_planificacion_22,
                                    "semana_23" => $semana_planificacion_23,
                                    "semana_24" => $semana_planificacion_24,
                                    "semana_25" => $semana_planificacion_25,
                                    "semana_26" => $semana_planificacion_26,
                                    "semana_27" => $semana_planificacion_27,
                                    "semana_28" => $semana_planificacion_28,
                                    "semana_29" => $semana_planificacion_29,
                                    "semana_30" => $semana_planificacion_30,
                                    "semana_31" => $semana_planificacion_31,
                                    "semana_32" => $semana_planificacion_32,
                                    "semana_33" => $semana_planificacion_33,
                                    "semana_34" => $semana_planificacion_34,
                                    "semana_35" => $semana_planificacion_35,
                                    "semana_36" => $semana_planificacion_36,
                                    "semana_37" => $semana_planificacion_37,
                                    "semana_38" => $semana_planificacion_38,
                                    "semana_39" => $semana_planificacion_39,
                                    "semana_40" => $semana_planificacion_40,
                                    "semana_41" => $semana_planificacion_41,
                                    "semana_42" => $semana_planificacion_42,
                                    "semana_43" => $semana_planificacion_43,
                                    "semana_44" => $semana_planificacion_44,
                                    "semana_45" => $semana_planificacion_45,
                                    "semana_46" => $semana_planificacion_46,
                                    "semana_47" => $semana_planificacion_47,
                                    "semana_48" => $semana_planificacion_48,
                                    "semana_49" => $semana_planificacion_49,
                                    "semana_50" => $semana_planificacion_50,
                                    "semana_51" => $semana_planificacion_51,
                                    "semana_52" => $semana_planificacion_52,
                                    "proceso_1" => $semana_proceso_1,
                                    "proceso_2" => $semana_proceso_2,
                                    "proceso_3" => $semana_proceso_3,
                                    "proceso_4" => $semana_proceso_4,
                                    "proceso_5" => $semana_proceso_5,
                                    "proceso_6" => $semana_proceso_6,
                                    "proceso_7" => $semana_proceso_7,
                                    "proceso_8" => $semana_proceso_8,
                                    "proceso_9" => $semana_proceso_9,
                                    "proceso_10" => $semana_proceso_10,
                                    "proceso_11" => $semana_proceso_11,
                                    "proceso_12" => $semana_proceso_12,
                                    "proceso_13" => $semana_proceso_13,
                                    "proceso_14" => $semana_proceso_14,
                                    "proceso_15" => $semana_proceso_15,
                                    "proceso_16" => $semana_proceso_16,
                                    "proceso_17" => $semana_proceso_17,
                                    "proceso_18" => $semana_proceso_18,
                                    "proceso_19" => $semana_proceso_19,
                                    "proceso_20" => $semana_proceso_20,
                                    "proceso_21" => $semana_proceso_21,
                                    "proceso_22" => $semana_proceso_22,
                                    "proceso_23" => $semana_proceso_23,
                                    "proceso_24" => $semana_proceso_24,
                                    "proceso_25" => $semana_proceso_25,
                                    "proceso_26" => $semana_proceso_26,
                                    "proceso_27" => $semana_proceso_27,
                                    "proceso_28" => $semana_proceso_28,
                                    "proceso_29" => $semana_proceso_29,
                                    "proceso_30" => $semana_proceso_30,
                                    "proceso_31" => $semana_proceso_31,
                                    "proceso_32" => $semana_proceso_32,
                                    "proceso_33" => $semana_proceso_33,
                                    "proceso_34" => $semana_proceso_34,
                                    "proceso_35" => $semana_proceso_35,
                                    "proceso_36" => $semana_proceso_36,
                                    "proceso_37" => $semana_proceso_37,
                                    "proceso_38" => $semana_proceso_38,
                                    "proceso_39" => $semana_proceso_39,
                                    "proceso_40" => $semana_proceso_40,
                                    "proceso_41" => $semana_proceso_41,
                                    "proceso_42" => $semana_proceso_42,
                                    "proceso_43" => $semana_proceso_43,
                                    "proceso_44" => $semana_proceso_44,
                                    "proceso_45" => $semana_proceso_45,
                                    "proceso_46" => $semana_proceso_46,
                                    "proceso_47" => $semana_proceso_47,
                                    "proceso_48" => $semana_proceso_48,
                                    "proceso_49" => $semana_proceso_49,
                                    "proceso_50" => $semana_proceso_50,
                                    "proceso_51" => $semana_proceso_51,
                                    "proceso_52" => $semana_proceso_52,
                                    "semanaActual" => $semanaActual
                                );
                        }
                    } else {
                        $array['creado'] = "NO";

                        // CREA POR DEFAUL LA PLANEACION ANTERIOR
                        $query = "";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $array['creado'] = "SI";
                        }



                        // CREA POR DEFAUL LA PLANEACION
                        $query = "INSERT INTO t_mp_planeacion_proceso(id_destino, id_plan, id_equipo, fecha_creado, ultima_modificacion, año) VALUES($idDestino, $idPlan, $idEquipo, '$fechaActual', '$fechaActual', '$año')";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $array['creado'] = "SI";

                            $query = "SELECT count(id) 'total' FROM t_mp_planeacion_semana WHERE id_destino = $idDestino and id_plan = $idPlan and id_equipo = $idEquipo";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $total = 0;
                                foreach ($result as $x) {
                                    $total = $x['total'];
                                }

                                if ($total == 0) {
                                    $query = "INSERT INTO t_mp_planeacion_semana(id_destino, id_plan, id_equipo, fecha_creado, ultima_modificacion, año) VALUES($idDestino, $idPlan, $idEquipo, '$fechaActual', '$fechaActual', '$año')";
                                    if ($result = mysqli_query($conn_2020, $query)) {
                                        $array['creado'] = "SI";
                                    }
                                }
                            }
                        }
                    }
                }
            }
            echo json_encode($array);
        }
    }


    // OBTIENE PLANES TIPO EQUIPO Y (PREVENTIVO Y TEST)
    if ($action == "consultarPlanLocal") {
        $idEquipo = $_POST['idEquipo'];
        $año = date('y');
        $data = array();
        $array = array();
        $contador = 0;

        $query = "SELECT t_equipos_america.id 'idEquipo', t_equipos_america.id_destino, t_mp_planes_mantenimiento.tipo_local_equipo, t_mp_planes_mantenimiento.id 'idPlan', t_mp_planes_mantenimiento.tipo_plan, 
        c_frecuencias_mp.frecuencia, t_mp_planes_mantenimiento.grado
        FROM t_equipos_america 
        INNER JOIN t_mp_planes_mantenimiento ON t_equipos_america.id_tipo = t_mp_planes_mantenimiento.tipo_local_equipo
        and t_mp_planes_mantenimiento.local_equipo = t_equipos_america.local_equipo 
        and t_equipos_america.id_destino = t_mp_planes_mantenimiento.id_destino 
        and t_mp_planes_mantenimiento.tipo_plan = 'CHECKLIST' 
        and t_mp_planes_mantenimiento.id_fase = t_equipos_america.id_fases
        INNER JOIN c_frecuencias_mp ON t_mp_planes_mantenimiento.id_periodicidad = c_frecuencias_mp.id
        WHERE t_equipos_america.id = $idEquipo and t_equipos_america.activo = 1 and 
        t_mp_planes_mantenimiento.status = 'ACTIVO'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idEquipo = $i['idEquipo'];
                $idDestino = $i['id_destino'];
                $idPlan = $i['idPlan'];
                $idTipo = $i['tipo_local_equipo'];
                $tipoPlan = $i['tipo_plan'];
                $grado = $i['grado'];
                $periodicidad = $i['frecuencia'];

                $queryPlaneacion = "SELECT 
                t_mp_planeacion_semana.id_equipo, t_mp_planeacion_semana.id 'semana', 
                t_mp_planeacion_proceso.id 'proceso',
                t_mp_planeacion_semana.semana_1 'semana_1', t_mp_planeacion_semana.semana_2 'semana_2', t_mp_planeacion_semana.semana_3 'semana_3', t_mp_planeacion_semana.semana_4 'semana_4', t_mp_planeacion_semana.semana_5 'semana_5', t_mp_planeacion_semana.semana_6 'semana_6', t_mp_planeacion_semana.semana_7 'semana_7', t_mp_planeacion_semana.semana_8 'semana_8', t_mp_planeacion_semana.semana_9 'semana_9', t_mp_planeacion_semana.semana_10 'semana_10', t_mp_planeacion_semana.semana_11 'semana_11', t_mp_planeacion_semana.semana_12 'semana_12', t_mp_planeacion_semana.semana_13 'semana_13', t_mp_planeacion_semana.semana_14 'semana_14', t_mp_planeacion_semana.semana_15 'semana_15', t_mp_planeacion_semana.semana_16 'semana_16', t_mp_planeacion_semana.semana_17 'semana_17', t_mp_planeacion_semana.semana_18 'semana_18', t_mp_planeacion_semana.semana_19 'semana_19', t_mp_planeacion_semana.semana_20 'semana_20', t_mp_planeacion_semana.semana_21 'semana_21', t_mp_planeacion_semana.semana_22 'semana_22', t_mp_planeacion_semana.semana_23 'semana_23', t_mp_planeacion_semana.semana_24 'semana_24', t_mp_planeacion_semana.semana_25 'semana_25', t_mp_planeacion_semana.semana_26 'semana_26', t_mp_planeacion_semana.semana_27 'semana_27', t_mp_planeacion_semana.semana_28 'semana_28', t_mp_planeacion_semana.semana_29 'semana_29', t_mp_planeacion_semana.semana_30 'semana_30', t_mp_planeacion_semana.semana_31 'semana_31', t_mp_planeacion_semana.semana_32 'semana_32', t_mp_planeacion_semana.semana_33 'semana_33', t_mp_planeacion_semana.semana_34 'semana_34', t_mp_planeacion_semana.semana_35 'semana_35', t_mp_planeacion_semana.semana_36 'semana_36', t_mp_planeacion_semana.semana_37 'semana_37', t_mp_planeacion_semana.semana_38 'semana_38', t_mp_planeacion_semana.semana_39 'semana_39', t_mp_planeacion_semana.semana_40 'semana_40', t_mp_planeacion_semana.semana_41 'semana_41', t_mp_planeacion_semana.semana_42 'semana_42', t_mp_planeacion_semana.semana_43 'semana_43', t_mp_planeacion_semana.semana_44 'semana_44', t_mp_planeacion_semana.semana_45 'semana_45', t_mp_planeacion_semana.semana_46 'semana_46', t_mp_planeacion_semana.semana_47 'semana_47', t_mp_planeacion_semana.semana_48 'semana_48', t_mp_planeacion_semana.semana_49 'semana_49', t_mp_planeacion_semana.semana_50 'semana_50', t_mp_planeacion_semana.semana_51 'semana_51', t_mp_planeacion_semana.semana_52 'semana_52',
                t_mp_planeacion_proceso.semana_1 'proceso_1', t_mp_planeacion_proceso.semana_2 'proceso_2', t_mp_planeacion_proceso.semana_3 'proceso_3', t_mp_planeacion_proceso.semana_4 'proceso_4', t_mp_planeacion_proceso.semana_5 'proceso_5', t_mp_planeacion_proceso.semana_6 'proceso_6', t_mp_planeacion_proceso.semana_7 'proceso_7', t_mp_planeacion_proceso.semana_8 'proceso_8', t_mp_planeacion_proceso.semana_9 'proceso_9', t_mp_planeacion_proceso.semana_10 'proceso_10', t_mp_planeacion_proceso.semana_11 'proceso_11',t_mp_planeacion_proceso.semana_12 'proceso_12',t_mp_planeacion_proceso.semana_13 'proceso_13',t_mp_planeacion_proceso.semana_14 'proceso_14',t_mp_planeacion_proceso.semana_15 'proceso_15',t_mp_planeacion_proceso.semana_16 'proceso_16',t_mp_planeacion_proceso.semana_17 'proceso_17',t_mp_planeacion_proceso.semana_18 'proceso_18',t_mp_planeacion_proceso.semana_19 'proceso_19',t_mp_planeacion_proceso.semana_20 'proceso_20',t_mp_planeacion_proceso.semana_21 'proceso_21',t_mp_planeacion_proceso.semana_22 'proceso_22',t_mp_planeacion_proceso.semana_23 'proceso_23',t_mp_planeacion_proceso.semana_24 'proceso_24',t_mp_planeacion_proceso.semana_25 'proceso_25',t_mp_planeacion_proceso.semana_26 'proceso_26',t_mp_planeacion_proceso.semana_27 'proceso_27',t_mp_planeacion_proceso.semana_28 'proceso_28',t_mp_planeacion_proceso.semana_29 'proceso_29',t_mp_planeacion_proceso.semana_30 'proceso_30',t_mp_planeacion_proceso.semana_31 'proceso_31',t_mp_planeacion_proceso.semana_32 'proceso_32',t_mp_planeacion_proceso.semana_33 'proceso_33',t_mp_planeacion_proceso.semana_34 'proceso_34',t_mp_planeacion_proceso.semana_35 'proceso_35',t_mp_planeacion_proceso.semana_36 'proceso_36',t_mp_planeacion_proceso.semana_37 'proceso_37',t_mp_planeacion_proceso.semana_38 'proceso_38',t_mp_planeacion_proceso.semana_39 'proceso_39',t_mp_planeacion_proceso.semana_40 'proceso_40',t_mp_planeacion_proceso.semana_41 'proceso_41',t_mp_planeacion_proceso.semana_42 'proceso_42',t_mp_planeacion_proceso.semana_43 'proceso_43',t_mp_planeacion_proceso.semana_44 'proceso_44',t_mp_planeacion_proceso.semana_45 'proceso_45',t_mp_planeacion_proceso.semana_46 'proceso_46',t_mp_planeacion_proceso.semana_47 'proceso_47',t_mp_planeacion_proceso.semana_48 'proceso_48',t_mp_planeacion_proceso.semana_49 'proceso_49',t_mp_planeacion_proceso.semana_50 'proceso_50',t_mp_planeacion_proceso.semana_51 'proceso_51',t_mp_planeacion_proceso.semana_52 'proceso_52'
                FROM t_mp_planeacion_semana
                INNER JOIN t_mp_planeacion_proceso ON t_mp_planeacion_semana.id_equipo = t_mp_planeacion_proceso.id_equipo and t_mp_planeacion_semana.id_plan = t_mp_planeacion_proceso.id_plan
                WHERE t_mp_planeacion_semana.id_plan = $idPlan and t_mp_planeacion_semana.id_equipo = $idEquipo and t_mp_planeacion_proceso.año = '$año'";
                if ($resultPlaneacion = mysqli_query($conn_2020, $queryPlaneacion)) {

                    if (mysqli_num_rows($resultPlaneacion) > 0) {
                        foreach ($resultPlaneacion as $key => $i) {
                            $idSemana = $i['semana'];
                            $idProceso = $i['proceso'];
                            $idEquipo = $i['id_equipo'];
                            $semana_planificacion_1 = $i['semana_1'];
                            $semana_planificacion_2 = $i['semana_2'];
                            $semana_planificacion_3 = $i['semana_3'];
                            $semana_planificacion_4 = $i['semana_4'];
                            $semana_planificacion_5 = $i['semana_5'];
                            $semana_planificacion_6 = $i['semana_6'];
                            $semana_planificacion_7 = $i['semana_7'];
                            $semana_planificacion_8 = $i['semana_8'];
                            $semana_planificacion_9 = $i['semana_9'];
                            $semana_planificacion_10 = $i['semana_10'];
                            $semana_planificacion_11 = $i['semana_11'];
                            $semana_planificacion_12 = $i['semana_12'];
                            $semana_planificacion_13 = $i['semana_13'];
                            $semana_planificacion_14 = $i['semana_14'];
                            $semana_planificacion_15 = $i['semana_15'];
                            $semana_planificacion_16 = $i['semana_16'];
                            $semana_planificacion_17 = $i['semana_17'];
                            $semana_planificacion_18 = $i['semana_18'];
                            $semana_planificacion_19 = $i['semana_19'];
                            $semana_planificacion_20 = $i['semana_20'];
                            $semana_planificacion_21 = $i['semana_21'];
                            $semana_planificacion_22 = $i['semana_22'];
                            $semana_planificacion_23 = $i['semana_23'];
                            $semana_planificacion_24 = $i['semana_24'];
                            $semana_planificacion_25 = $i['semana_25'];
                            $semana_planificacion_26 = $i['semana_26'];
                            $semana_planificacion_27 = $i['semana_27'];
                            $semana_planificacion_28 = $i['semana_28'];
                            $semana_planificacion_29 = $i['semana_29'];
                            $semana_planificacion_30 = $i['semana_30'];
                            $semana_planificacion_31 = $i['semana_31'];
                            $semana_planificacion_32 = $i['semana_32'];
                            $semana_planificacion_33 = $i['semana_33'];
                            $semana_planificacion_34 = $i['semana_34'];
                            $semana_planificacion_35 = $i['semana_35'];
                            $semana_planificacion_36 = $i['semana_36'];
                            $semana_planificacion_37 = $i['semana_37'];
                            $semana_planificacion_38 = $i['semana_38'];
                            $semana_planificacion_39 = $i['semana_39'];
                            $semana_planificacion_40 = $i['semana_40'];
                            $semana_planificacion_41 = $i['semana_41'];
                            $semana_planificacion_42 = $i['semana_42'];
                            $semana_planificacion_43 = $i['semana_43'];
                            $semana_planificacion_44 = $i['semana_44'];
                            $semana_planificacion_45 = $i['semana_45'];
                            $semana_planificacion_46 = $i['semana_46'];
                            $semana_planificacion_47 = $i['semana_47'];
                            $semana_planificacion_48 = $i['semana_48'];
                            $semana_planificacion_49 = $i['semana_49'];
                            $semana_planificacion_50 = $i['semana_50'];
                            $semana_planificacion_51 = $i['semana_51'];
                            $semana_planificacion_52 = $i['semana_52'];
                            $semana_proceso_1 = $i['proceso_1'];
                            $semana_proceso_2 = $i['proceso_2'];
                            $semana_proceso_3 = $i['proceso_3'];
                            $semana_proceso_4 = $i['proceso_4'];
                            $semana_proceso_5 = $i['proceso_5'];
                            $semana_proceso_6 = $i['proceso_6'];
                            $semana_proceso_7 = $i['proceso_7'];
                            $semana_proceso_8 = $i['proceso_8'];
                            $semana_proceso_9 = $i['proceso_9'];
                            $semana_proceso_10 = $i['proceso_10'];
                            $semana_proceso_11 = $i['proceso_11'];
                            $semana_proceso_12 = $i['proceso_12'];
                            $semana_proceso_13 = $i['proceso_13'];
                            $semana_proceso_14 = $i['proceso_14'];
                            $semana_proceso_15 = $i['proceso_15'];
                            $semana_proceso_16 = $i['proceso_16'];
                            $semana_proceso_17 = $i['proceso_17'];
                            $semana_proceso_18 = $i['proceso_18'];
                            $semana_proceso_19 = $i['proceso_19'];
                            $semana_proceso_20 = $i['proceso_20'];
                            $semana_proceso_21 = $i['proceso_21'];
                            $semana_proceso_22 = $i['proceso_22'];
                            $semana_proceso_23 = $i['proceso_23'];
                            $semana_proceso_24 = $i['proceso_24'];
                            $semana_proceso_25 = $i['proceso_25'];
                            $semana_proceso_26 = $i['proceso_26'];
                            $semana_proceso_27 = $i['proceso_27'];
                            $semana_proceso_28 = $i['proceso_28'];
                            $semana_proceso_29 = $i['proceso_29'];
                            $semana_proceso_30 = $i['proceso_30'];
                            $semana_proceso_31 = $i['proceso_31'];
                            $semana_proceso_32 = $i['proceso_32'];
                            $semana_proceso_33 = $i['proceso_33'];
                            $semana_proceso_34 = $i['proceso_34'];
                            $semana_proceso_35 = $i['proceso_35'];
                            $semana_proceso_36 = $i['proceso_36'];
                            $semana_proceso_37 = $i['proceso_37'];
                            $semana_proceso_38 = $i['proceso_38'];
                            $semana_proceso_39 = $i['proceso_39'];
                            $semana_proceso_40 = $i['proceso_40'];
                            $semana_proceso_41 = $i['proceso_41'];
                            $semana_proceso_42 = $i['proceso_42'];
                            $semana_proceso_43 = $i['proceso_43'];
                            $semana_proceso_44 = $i['proceso_44'];
                            $semana_proceso_45 = $i['proceso_45'];
                            $semana_proceso_46 = $i['proceso_46'];
                            $semana_proceso_47 = $i['proceso_47'];
                            $semana_proceso_48 = $i['proceso_48'];
                            $semana_proceso_49 = $i['proceso_49'];
                            $semana_proceso_50 = $i['proceso_50'];
                            $semana_proceso_51 = $i['proceso_51'];
                            $semana_proceso_52 = $i['proceso_52'];

                            // Contador de MP
                            $proceso = 0;
                            $solucionado = 0;
                            $planificado = 0;

                            $z =
                                $semana_proceso_1 . ";" . $semana_proceso_2 . ";" . $semana_proceso_3 . ";" . $semana_proceso_4 . ";" . $semana_proceso_5 . ";" . $semana_proceso_6 . ";" . $semana_proceso_7 . ";" . $semana_proceso_8 . ";" . $semana_proceso_9 . ";" . $semana_proceso_10 . ";" . $semana_proceso_11 . ";" . $semana_proceso_12 . ";" . $semana_proceso_13 . ";" . $semana_proceso_14 . ";" . $semana_proceso_15 . ";" . $semana_proceso_16 . ";" . $semana_proceso_17 . ";" . $semana_proceso_18 . ";" . $semana_proceso_19 . ";" . $semana_proceso_20 . ";" . $semana_proceso_21 . ";" . $semana_proceso_22 . ";" . $semana_proceso_23 . ";" . $semana_proceso_24 . ";" . $semana_proceso_25 . ";" . $semana_proceso_26 . ";" . $semana_proceso_27 . ";" . $semana_proceso_28 . ";" . $semana_proceso_29 . ";" . $semana_proceso_30 . ";" . $semana_proceso_31 . ";" . $semana_proceso_32 . ";" . $semana_proceso_33 . ";" . $semana_proceso_34 . ";" . $semana_proceso_35 . ";" . $semana_proceso_36 . ";" . $semana_proceso_37 . ";" . $semana_proceso_38 . ";" . $semana_proceso_39 . ";" . $semana_proceso_40 . ";" . $semana_proceso_41 . ";" . $semana_proceso_42 . ";" . $semana_proceso_43 . ";" . $semana_proceso_44 . ";" . $semana_proceso_45 . ";" . $semana_proceso_46 . ";" . $semana_proceso_47 . ";" . $semana_proceso_48 . ";" . $semana_proceso_49 . ";" . $semana_proceso_50 . ";" . $semana_proceso_51 . ";" . $semana_proceso_52;
                            $z = explode(";", $z);

                            for ($i = 0; $i < count($z); $i++) {

                                if ($z[$i] == "PROCESO") {
                                    $proceso++;
                                } elseif ($z[$i] == "SOLUCIONADO") {
                                    $solucionado++;
                                }
                            }

                            $y =
                                $semana_planificacion_1 . ";" . $semana_planificacion_2 . ";" . $semana_planificacion_3 . ";" . $semana_planificacion_4 . ";" . $semana_planificacion_5 . ";" . $semana_planificacion_6 . ";" . $semana_planificacion_7 . ";" . $semana_planificacion_8 . ";" . $semana_planificacion_9 . ";" . $semana_planificacion_10 . ";" . $semana_planificacion_11 . ";" . $semana_planificacion_12 . ";" . $semana_planificacion_13 . ";" . $semana_planificacion_14 . ";" . $semana_planificacion_15 . ";" . $semana_planificacion_16 . ";" . $semana_planificacion_17 . ";" . $semana_planificacion_18 . ";" . $semana_planificacion_19 . ";" . $semana_planificacion_20 . ";" . $semana_planificacion_21 . ";" . $semana_planificacion_22 . ";" . $semana_planificacion_23 . ";" . $semana_planificacion_24 . ";" . $semana_planificacion_25 . ";" . $semana_planificacion_26 . ";" . $semana_planificacion_27 . ";" . $semana_planificacion_28 . ";" . $semana_planificacion_29 . ";" . $semana_planificacion_30 . ";" . $semana_planificacion_31 . ";" . $semana_planificacion_32 . ";" . $semana_planificacion_33 . ";" . $semana_planificacion_34 . ";" . $semana_planificacion_35 . ";" . $semana_planificacion_36 . ";" . $semana_planificacion_37 . ";" . $semana_planificacion_38 . ";" . $semana_planificacion_39 . ";" . $semana_planificacion_40 . ";" . $semana_planificacion_41 . ";" . $semana_planificacion_42 . ";" . $semana_planificacion_43 . ";" . $semana_planificacion_44 . ";" . $semana_planificacion_45 . ";" . $semana_planificacion_46 . ";" . $semana_planificacion_47 . ";" . $semana_planificacion_48 . ";" . $semana_planificacion_49 . ";" . $semana_planificacion_50 . ";" . $semana_planificacion_51 . ";" . $semana_planificacion_52;
                            $y = explode(";", $y);

                            for ($i = 0; $i < count($y); $i++) {

                                if ($y[$i] == "PLANIFICADO") {
                                    $planificado++;
                                }
                            }
                            $contador++;
                            $array['planes'][] =
                                array(
                                    "proceso" => $proceso,
                                    "solucionado" => $solucionado,
                                    "planificado" => $planificado,
                                    "idSemana" => $idSemana,
                                    "idProceso" => $idProceso,
                                    "idEquipo" => $idEquipo,
                                    "idPlan" => $idPlan,
                                    "periodicidad" => $periodicidad,
                                    "tipoPlan" => $tipoPlan,
                                    "grado" => $grado,
                                    "semana_1" => $semana_planificacion_1,
                                    "semana_2" => $semana_planificacion_2,
                                    "semana_3" => $semana_planificacion_3,
                                    "semana_4" => $semana_planificacion_4,
                                    "semana_5" => $semana_planificacion_5,
                                    "semana_6" => $semana_planificacion_6,
                                    "semana_7" => $semana_planificacion_7,
                                    "semana_8" => $semana_planificacion_8,
                                    "semana_9" => $semana_planificacion_9,
                                    "semana_10" => $semana_planificacion_10,
                                    "semana_11" => $semana_planificacion_11,
                                    "semana_12" => $semana_planificacion_12,
                                    "semana_13" => $semana_planificacion_13,
                                    "semana_14" => $semana_planificacion_14,
                                    "semana_15" => $semana_planificacion_15,
                                    "semana_16" => $semana_planificacion_16,
                                    "semana_17" => $semana_planificacion_17,
                                    "semana_18" => $semana_planificacion_18,
                                    "semana_19" => $semana_planificacion_19,
                                    "semana_20" => $semana_planificacion_20,
                                    "semana_21" => $semana_planificacion_21,
                                    "semana_22" => $semana_planificacion_22,
                                    "semana_23" => $semana_planificacion_23,
                                    "semana_24" => $semana_planificacion_24,
                                    "semana_25" => $semana_planificacion_25,
                                    "semana_26" => $semana_planificacion_26,
                                    "semana_27" => $semana_planificacion_27,
                                    "semana_28" => $semana_planificacion_28,
                                    "semana_29" => $semana_planificacion_29,
                                    "semana_30" => $semana_planificacion_30,
                                    "semana_31" => $semana_planificacion_31,
                                    "semana_32" => $semana_planificacion_32,
                                    "semana_33" => $semana_planificacion_33,
                                    "semana_34" => $semana_planificacion_34,
                                    "semana_35" => $semana_planificacion_35,
                                    "semana_36" => $semana_planificacion_36,
                                    "semana_37" => $semana_planificacion_37,
                                    "semana_38" => $semana_planificacion_38,
                                    "semana_39" => $semana_planificacion_39,
                                    "semana_40" => $semana_planificacion_40,
                                    "semana_41" => $semana_planificacion_41,
                                    "semana_42" => $semana_planificacion_42,
                                    "semana_43" => $semana_planificacion_43,
                                    "semana_44" => $semana_planificacion_44,
                                    "semana_45" => $semana_planificacion_45,
                                    "semana_46" => $semana_planificacion_46,
                                    "semana_47" => $semana_planificacion_47,
                                    "semana_48" => $semana_planificacion_48,
                                    "semana_49" => $semana_planificacion_49,
                                    "semana_50" => $semana_planificacion_50,
                                    "semana_51" => $semana_planificacion_51,
                                    "semana_52" => $semana_planificacion_52,
                                    "proceso_1" => $semana_proceso_1,
                                    "proceso_2" => $semana_proceso_2,
                                    "proceso_3" => $semana_proceso_3,
                                    "proceso_4" => $semana_proceso_4,
                                    "proceso_5" => $semana_proceso_5,
                                    "proceso_6" => $semana_proceso_6,
                                    "proceso_7" => $semana_proceso_7,
                                    "proceso_8" => $semana_proceso_8,
                                    "proceso_9" => $semana_proceso_9,
                                    "proceso_10" => $semana_proceso_10,
                                    "proceso_11" => $semana_proceso_11,
                                    "proceso_12" => $semana_proceso_12,
                                    "proceso_13" => $semana_proceso_13,
                                    "proceso_14" => $semana_proceso_14,
                                    "proceso_15" => $semana_proceso_15,
                                    "proceso_16" => $semana_proceso_16,
                                    "proceso_17" => $semana_proceso_17,
                                    "proceso_18" => $semana_proceso_18,
                                    "proceso_19" => $semana_proceso_19,
                                    "proceso_20" => $semana_proceso_20,
                                    "proceso_21" => $semana_proceso_21,
                                    "proceso_22" => $semana_proceso_22,
                                    "proceso_23" => $semana_proceso_23,
                                    "proceso_24" => $semana_proceso_24,
                                    "proceso_25" => $semana_proceso_25,
                                    "proceso_26" => $semana_proceso_26,
                                    "proceso_27" => $semana_proceso_27,
                                    "proceso_28" => $semana_proceso_28,
                                    "proceso_29" => $semana_proceso_29,
                                    "proceso_30" => $semana_proceso_30,
                                    "proceso_31" => $semana_proceso_31,
                                    "proceso_32" => $semana_proceso_32,
                                    "proceso_33" => $semana_proceso_33,
                                    "proceso_34" => $semana_proceso_34,
                                    "proceso_35" => $semana_proceso_35,
                                    "proceso_36" => $semana_proceso_36,
                                    "proceso_37" => $semana_proceso_37,
                                    "proceso_38" => $semana_proceso_38,
                                    "proceso_39" => $semana_proceso_39,
                                    "proceso_40" => $semana_proceso_40,
                                    "proceso_41" => $semana_proceso_41,
                                    "proceso_42" => $semana_proceso_42,
                                    "proceso_43" => $semana_proceso_43,
                                    "proceso_44" => $semana_proceso_44,
                                    "proceso_45" => $semana_proceso_45,
                                    "proceso_46" => $semana_proceso_46,
                                    "proceso_47" => $semana_proceso_47,
                                    "proceso_48" => $semana_proceso_48,
                                    "proceso_49" => $semana_proceso_49,
                                    "proceso_50" => $semana_proceso_50,
                                    "proceso_51" => $semana_proceso_51,
                                    "proceso_52" => $semana_proceso_52,
                                    "semanaActual" => $semanaActual
                                );
                        }
                    } else {
                        $array['creado'] = "NO";

                        // CREA POR DEFAUL LA PLANEACION
                        $query = "INSERT INTO t_mp_planeacion_proceso(id_destino, id_plan, id_equipo, fecha_creado, ultima_modificacion, año) VALUES($idDestino, $idPlan, $idEquipo, '$fechaActual', '$fechaActual', '$año')";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $array['creado'] = "SI";

                            $query = "SELECT count(id) 'total' FROM t_mp_planeacion_semana WHERE id_destino = $idDestino and id_plan = $idPlan and id_equipo = $idEquipo";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $total = 0;
                                foreach ($result as $x) {
                                    $total = $x['total'];
                                }

                                if ($total == 0) {
                                    $query = "INSERT INTO t_mp_planeacion_semana(id_destino, id_plan, id_equipo, fecha_creado, ultima_modificacion, año) VALUES($idDestino, $idPlan, $idEquipo, '$fechaActual', '$fechaActual', '$año')";
                                    if ($result = mysqli_query($conn_2020, $query)) {
                                        $array['creado'] = "SI";
                                    }
                                }
                            }
                        }
                    }
                }
            }
            echo json_encode($array);
        }
    }

    if ($action == "programarMP") {
        $idEquipo = $_POST['idEquipo'];
        $idSemana = $_POST['idSemana'];
        $idProceso = $_POST['idProceso'];
        $semanaX = $_POST['semanaX'];
        $accionMP = $_POST['accionMP'];
        $semana = array();
        $resultado = 0;
        $numeroSemanas = $_POST['numeroSemanas'];
        $año = date('y');
        $idPlan = $_POST['idPlan'];

        $query = "SELECT *
        FROM t_mp_planeacion_semana 
        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planeacion_semana.id_plan = t_mp_planes_mantenimiento.id
        INNER JOIN c_frecuencias_mp ON t_mp_planes_mantenimiento.id_periodicidad = c_frecuencias_mp.id
        WHERE t_mp_planeacion_semana.id = $idSemana and t_mp_planeacion_semana.id_equipo = $idEquipo and t_mp_planeacion_semana.activo = 1 and t_mp_planes_mantenimiento.status = 'ACTIVO'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idPlan = $i["id_plan"];
                $valoSemanaX = $i["semana_" . $semanaX];
                $semanas = $i["semanas"];
                $saltos = $i["saltos"];

                // Lista de Semanas
                $semana[1] = $i['semana_1'];
                $semana[2] = $i['semana_2'];
                $semana[3] = $i['semana_3'];
                $semana[4] = $i['semana_4'];
                $semana[5] = $i['semana_5'];
                $semana[6] = $i['semana_6'];
                $semana[7] = $i['semana_7'];
                $semana[8] = $i['semana_8'];
                $semana[9] = $i['semana_9'];
                $semana[10] = $i['semana_10'];
                $semana[11] = $i['semana_11'];
                $semana[12] = $i['semana_12'];
                $semana[13] = $i['semana_13'];
                $semana[14] = $i['semana_14'];
                $semana[15] = $i['semana_15'];
                $semana[16] = $i['semana_16'];
                $semana[17] = $i['semana_17'];
                $semana[18] = $i['semana_18'];
                $semana[19] = $i['semana_19'];
                $semana[20] = $i['semana_20'];
                $semana[21] = $i['semana_21'];
                $semana[22] = $i['semana_22'];
                $semana[23] = $i['semana_23'];
                $semana[24] = $i['semana_24'];
                $semana[25] = $i['semana_25'];
                $semana[26] = $i['semana_26'];
                $semana[27] = $i['semana_27'];
                $semana[28] = $i['semana_28'];
                $semana[29] = $i['semana_29'];
                $semana[30] = $i['semana_30'];
                $semana[31] = $i['semana_31'];
                $semana[32] = $i['semana_32'];
                $semana[33] = $i['semana_33'];
                $semana[34] = $i['semana_34'];
                $semana[35] = $i['semana_35'];
                $semana[36] = $i['semana_36'];
                $semana[37] = $i['semana_37'];
                $semana[38] = $i['semana_38'];
                $semana[39] = $i['semana_39'];
                $semana[40] = $i['semana_40'];
                $semana[41] = $i['semana_41'];
                $semana[42] = $i['semana_42'];
                $semana[43] = $i['semana_43'];
                $semana[44] = $i['semana_44'];
                $semana[45] = $i['semana_45'];
                $semana[46] = $i['semana_46'];
                $semana[47] = $i['semana_47'];
                $semana[48] = $i['semana_48'];
                $semana[49] = $i['semana_49'];
                $semana[50] = $i['semana_50'];
                $semana[51] = $i['semana_51'];
                $semana[52] = $i['semana_52'];

                if ($accionMP == "PROGRAMARINDIVIDUAL" and ($valoSemanaX == 0 || $valoSemanaX == "PLANIFICADO")) {
                    $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$semanaX = 'PLANIFICADO' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                    if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                        $resultado = 2;
                    } else {
                        $resultado = 0;
                    }
                } elseif ($accionMP == "PROGRAMARDESDEAQUI") {

                    if ($saltos == 52) {
                        for ($i = $semanaX; $i <= 52; $i++) {
                            $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$i = 'PLANIFICADO' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                            if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                                $resultado = 3;
                            } else {
                                $resultado = 0;
                            }
                        }
                    } else {
                        // echo ": $semanas $saltos :";
                        $contador = -1;
                        for ($i = $semanaX; $i <= 52; ++$i) {
                            $contador++;
                            if ($i == $semanaX) {
                                $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$i = 'PLANIFICADO' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                                if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                                    $resultado = 3;
                                } else {
                                    $resultado = 0;
                                }
                            } elseif ($semanas == $contador) {

                                $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$i = 'PLANIFICADO' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                                if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                                    $resultado = 3;
                                } else {
                                    $resultado = 0;
                                }
                                $contador = 0;
                            } else {
                                $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$i = '0' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                                if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                                    $resultado = 3;
                                } else {
                                    $resultado = 0;
                                }
                            }
                        }
                    }
                } elseif ($accionMP == "PROGRAMARPERSONALIZADO") {

                    $contador = -1;
                    for ($i = $semanaX; $i <= 52; ++$i) {
                        $contador++;

                        if ($i == $semanaX) {
                            $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$i = 'PLANIFICADO' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                            if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                                $resultado = 4;
                            } else {
                                $resultado = 0;
                            }
                        } elseif ($numeroSemanas == $contador) {

                            $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$i = 'PLANIFICADO' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                            if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                                $resultado = 4;
                            } else {
                                $resultado = 0;
                            }
                            $contador = 0;
                        } else {
                            $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$i = '0' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                            if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                                $resultado = 4;
                            } else {
                                $resultado = 0;
                            }
                        }
                    }
                } elseif ($accionMP == "ELIMINARINDIVIDUAL") {
                    $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$semanaX = '0' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                    if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                        $resultado = 5;
                    } else {
                        $resultado = 0;
                    }
                } elseif ($accionMP == "ELIMINARDESDEAQUI") {
                    for ($i = $semanaX; $i <= 52; $i++) {

                        $programarMP = "UPDATE t_mp_planeacion_semana SET semana_$i = '0' WHERE id = $idSemana and id_equipo = $idEquipo and activo = 1";
                        if ($resultProgramacion = mysqli_query($conn_2020, $programarMP)) {
                            $resultado = 6;
                        } else {
                            $resultado = 0;
                        }
                    }
                } elseif ($accionMP == "GENERAROT") {
                    $idActividadesPreventivos = "";
                    $idActividadesTest = "";
                    $idActividadesCheck = "";

                    // Actividades Preventivo
                    $contador = 0;
                    $query = "SELECT id FROM t_mp_planes_actividades_preventivos WHERE id_plan = $idPlan and status= 'ACTIVO' and activo = 1";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $contador++;
                            $id = $i['id'];
                            if ($contador > 1) {
                                $idActividadesPreventivos .= ", $id";
                            } else {
                                $idActividadesPreventivos .= "$id";
                            }
                        }
                    }

                    // Actividades TEST
                    $contador = 0;
                    $query = "SELECT id FROM t_mp_planes_actividades_test WHERE id_plan = $idPlan and status= 'ACTIVO' and activo = 1";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $contador++;
                            $id = $i['id'];
                            if ($contador > 1) {
                                $idActividadesTest .= ", $id";
                            } else {
                                $idActividadesTest .= "$id";
                            }
                        }
                    }

                    // Actividades CHECK
                    $contador = 0;
                    $query = "SELECT id FROM t_mp_planes_actividades_checklist WHERE id_plan = $idPlan and status= 'ACTIVO' and activo = 1";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $i) {
                            $contador++;
                            $id = $i['id'];
                            if ($contador > 1) {
                                $idActividadesCheck .= ", $id";
                            } else {
                                $idActividadesCheck .= "$id";
                            }
                        }
                    }

                    $query = "SELECT id FROM t_mp_planeacion_proceso WHERE id_equipo = $idEquipo
                    and id_plan = $idPlan and año = '$año' and semana_$semanaX IN ('PROCESO', 'SOLUCIONADO') and activo = 1";
                    if ($result = mysqli_query($conn_2020, $query)) {

                        if (mysqli_num_rows($result) > 0) {
                            $resultado = 10;
                        } else {
                            $query = "INSERT INTO t_mp_planificacion_iniciada(id_usuario, id_plan, id_equipo, semana, año, fecha_creacion, creado_por, actividades_preventivo, actividades_test, actividades_check, status, activo) VALUES($idUsuario, $idPlan, $idEquipo, $semanaX, '$año', '$fechaActual', $idUsuario, '$idActividadesPreventivos', '$idActividadesTest', '$idActividadesCheck', 'PROCESO', 1)";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $programarMP = "UPDATE t_mp_planeacion_proceso SET semana_$semanaX = 'PROCESO', ultima_modificacion = '$fechaActual' WHERE id_plan = $idPlan and id_equipo = $idEquipo and semana_$semanaX = '0' and activo = 1 and año = '$año'";
                                if ($result = mysqli_query($conn_2020, $programarMP)) {
                                    $resultado = 7;
                                }
                            }
                        }
                    }
                } elseif ($accionMP == "SOLUCIONAROT") {
                    $query = "SELECT id FROM t_mp_planeacion_proceso WHERE id_equipo = $idEquipo
                         and id_plan = $idPlan and semana_$semanaX = 'PROCESO' and activo = 1 and año = '$año'";
                    if ($result = mysqli_query($conn_2020, $query)) {

                        if (mysqli_num_rows($result) > 0) {
                            $query = "UPDATE t_mp_planeacion_proceso SET semana_$semanaX = 'SOLUCIONADO' WHERE id_plan = $idPlan and id_equipo = $idEquipo and activo = 1 and semana_$semanaX = 'PROCESO'";
                            if ($resultProgramacion = mysqli_query($conn_2020, $query)) {
                                $resultado = 8;
                            }
                        } else {
                            $resultado = 11;
                        }
                    }
                } elseif ($accionMP == "CANCELAROT") {
                    $query = "SELECT id FROM t_mp_planeacion_proceso WHERE id_equipo = $idEquipo
                         and id_plan = $idPlan and semana_$semanaX = 'PROCESO' and activo = 1 and año = '$año'";
                    if ($result = mysqli_query($conn_2020, $query)) {

                        if (mysqli_num_rows($result) > 0) {
                            $query = "UPDATE t_mp_planeacion_proceso SET semana_$semanaX = '0' WHERE id_plan = $idPlan and id_equipo = $idEquipo and activo = 1 and semana_$semanaX ='PROCESO' and año = '$año'";
                            if ($query = mysqli_query($conn_2020, $query)) {
                                $query = "UPDATE t_mp_planificacion_iniciada SET status ='CANCELADO', fecha_finalizado = '$fechaActual', activo = 0
                                WHERE id_plan = $idPlan and id_equipo = $idEquipo and activo = 1 and status ='PROCESO' and año = '$año' and semana = '$semanaX'";
                                if ($result = mysqli_query($conn_2020, $query)) {
                                    $resultado = 9;
                                } else {
                                    $resultado = 12;
                                }
                            }
                        } else {
                            $resultado = 12;
                        }
                    }
                } elseif ($accionMP == "VEROT") {
                    $query = "SELECT id FROM t_mp_planeacion_proceso WHERE id_equipo = $idEquipo
                         and id_plan = $idPlan and (semana_$semanaX = 'PROCESO' or semana_$semanaX = 'SOLUCIONADO') and activo = 1 and año = '$año'";
                    if ($result = mysqli_query($conn_2020, $query)) {

                        if (mysqli_num_rows($result) > 0) {
                            $resultado = 13;
                        } else {
                            $resultado = 14;
                        }
                    }
                }
            }
        } else {
            $resultado = 0;
        }
        echo $resultado;
    }


    if ($action == "consultarActividadesMP") {
        $data = array();
        $contador = 0;
        $actividades = "";
        $idPlan = $_POST['idPlan'];

        // Actividades Preventivo
        $query = "SELECT id, descripcion_actividad FROM t_mp_planes_actividades_preventivos WHERE id_plan = $idPlan and status = 'ACTIVO' and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $contador++;
                $actividad = $i['descripcion_actividad'];

                $actividades .= "
                    <div class=\"flex items-center mb-2\">
                        <i class=\"fad fa-circle mr-2 text-bluegray-500\"></i>
                        <h1>$actividad</h1>
                    </div>               
                ";
            }
        }

        // Actividades TEST
        $query = "SELECT id, descripcion_actividad FROM t_mp_planes_actividades_test WHERE id_plan = $idPlan and status= 'ACTIVO' and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $contador++;
                $actividad = $i['descripcion_actividad'];

                $actividades .= "
                    <div class=\"flex items-center mb-2\">
                        <i class=\"fad fa-circle mr-2 text-bluegray-500\"></i>
                        <h1>$actividad</h1>
                    </div>               
                ";
            }
        }

        // Actividades CHECK
        $query = "SELECT id, descripcion_actividad FROM t_mp_planes_actividades_checklist WHERE id_plan = $idPlan and status= 'ACTIVO' and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $contador++;
                $actividad = $i['descripcion_actividad'];

                $actividades .= "
                    <div class=\"flex items-center mb-2\">
                        <i class=\"fad fa-circle mr-2 text-bluegray-500\"></i>
                        <h1>$actividad</h1>
                    </div>               
                ";
            }
        }

        $titulo = "<h1 class=\"my-2 self-start\" style=\"color: #a9aaaa;\">Actividades ($contador)</h1>";
        $data['actividades'] = $titulo . $actividades;
        $data['totalActividades'] = $contador;
        echo json_encode($data);
    }


    if ($action == "consultarOpcionesEquipo") {
        $data = array();
        $secciones = "";
        $subsecciones = "";
        $tipos = "";
        $marcas = "";

        $secciones .= "<option value=\"0\" class=\"truncate\">Seleccione</option>";
        $querySecciones = "SELECT id, seccion FROM c_secciones 
        WHERE status = 'A' ORDER BY seccion ASC";
        if ($result = mysqli_query($conn_2020, $querySecciones)) {
            foreach ($result as $i) {
                $idSeccion = $i['id'];
                $seccion = $i['seccion'];

                $secciones .= "<option value=\"$idSeccion\" class=\"truncate\">$seccion</option>";
            }
        }

        $subsecciones .= "<option value=\"0\" class=\"truncate\">Seleccione</option>";
        $querySubsecciones = "SELECT id, grupo FROM c_subsecciones ORDER BY grupo ASC";
        if ($result = mysqli_query($conn_2020, $querySubsecciones)) {
            foreach ($result as $i) {
                $idSubseccion = $i['id'];
                $subseccion = $i['grupo'];

                $subsecciones .= "<option value=\"$idSubseccion\" class=\"truncate\">$subseccion</option>";
            }
        }

        $tipos .= "<option value=\"0\" class=\"truncate\">Seleccione</option>";
        $queryTipos = "SELECT id, tipo FROM c_tipos WHERE status = 'A' ORDER BY tipo ASC";
        if ($result = mysqli_query($conn_2020, $queryTipos)) {
            foreach ($result as $i) {
                $idTipo = $i['id'];
                $tipo = $i['tipo'];

                $tipos .= "<option value=\"$idTipo\" class=\"truncate\">$tipo</option>";
            }
        }

        $marcas .= "<option value=\"0\" class=\"truncate\">Seleccione</option>";
        $queryTipos = "SELECT id, marca FROM c_marcas WHERE status = 'A' ORDER BY marca ASC";
        if ($result = mysqli_query($conn_2020, $queryTipos)) {
            foreach ($result as $i) {
                $idMarca = $i['id'];
                $marca = $i['marca'];

                $marcas .= "<option value=\"$idMarca\" class=\"truncate\">$marca</option>";
            }
        }

        $data['secciones'] = $secciones;
        $data['subsecciones'] = $subsecciones;
        $data['tipos'] = $tipos;
        $data['marcas'] = $marcas;

        echo json_encode($data);
    }


    if ($action == "actualizarPlanaccionReporte") {
        $valor = $_POST['valor'];
        $idPlanaccion = $_POST['idPlanaccion'];
        $columna = $_POST['columna'];

        if ($columna == "area") {
            $columna = "area";
        } elseif ($columna == "unidad") {
            $columna = "unidad_medida";
        } elseif ($columna == "cantidad") {
            $columna = "cantidad";
        } elseif ($columna == "coste") {
            $columna = "coste";
        }

        $query = "UPDATE t_proyectos_planaccion SET $columna = '$valor' WHERE id = $idPlanaccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    #OBTIENE LOS COMENTARIOS POR EQUIPO
    if ($action == "obtenerComentariosEquipos") {
        $idEquipo = $_POST['idEquipo'];
        $array = array();

        $query = "SELECT t_equipos_america_comentarios.id, t_equipos_america_comentarios.comentarios, 
        t_equipos_america_comentarios.fecha, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_equipos_america_comentarios 
        INNER JOIN t_users ON t_equipos_america_comentarios.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_equipos_america_comentarios.id_equipo = $idEquipo and t_equipos_america_comentarios.status = '1' ORDER BY t_equipos_america_comentarios.id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idComentario = $x['id'];
                $comentario = $x['comentarios'];
                $nombre = strtok($x['nombre'], ' ') . " " . strtok($x['apellido'], ' ');
                $fecha = (new DateTime($x['fecha']))->format('d/m/Y H:m:s');
                $arrayTemp = array(
                    "idComentario" => $idComentario,
                    "tipo" => "SEGUIMIENTO",
                    "comentario" => $comentario,
                    "nombre" => $nombre,
                    "fecha" => $fecha
                );

                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    if ($action == "agregarComentarioEquipo") {
        $idEquipo = $_POST["idEquipo"];
        $comentario = $_POST["comentario"];

        $query = "INSERT INTO t_equipos_america_comentarios(fecha, comentarios, id_equipo, id_usuario, status) VALUES('$fechaActual', '$comentario', $idEquipo, $idUsuario, '1')";
        if ($result = mysqli_query($conn_2020, $query)) {
            echo 1;
        } else {
            echo 0;
        }
    }


    if ($action == "obtenerRangoFechaPlanaccion") {
        $idPlanaccion = $_POST['idPlanaccion'];
        $rangoFecha = "";
        $query = "SELECT rango_fecha, fecha_creacion FROM t_proyectos_planaccion WHERE id = $idPlanaccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $rangoFecha = $x['rango_fecha'];
                $fechaCreacion = (new DateTime($x['fecha_creacion']))->format('d/m/Y');

                if ($rangoFecha == "" || $rangoFecha == " ") {
                    $rangoFecha = $fechaCreacion . ' - ' . $fechaCreacion;
                }
            }
        }
        echo json_encode($rangoFecha);
    }


    // ACTUALIZA FECHA PROGRAMADA
    if ($action == "programarFechaMP") {
        $idEquipo = $_POST['idEquipo'];
        $semana = $_POST['semana'];
        $idPlan = $_POST['idPlan'];
        $fecha = $_POST['fecha'];
        $resp = 0;

        $query = "UPDATE t_mp_planificacion_iniciada SET fecha_programada = '$fecha' 
        WHERE id_equipo = $idEquipo and semana = $semana and id_plan = $idPlan and activo = 1 and status = 'PROCESO' and año = '$añoActual'";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }


    if ($action == "obtenerDatosOT") {
        $idEquipo = $_POST['idEquipo'];
        $semana = $_POST['semana'];
        $idPlan = $_POST['idPlan'];
        $array = array();

        $query = "SELECT id, fecha_programada
        FROM t_mp_planificacion_iniciada 
        WHERE id_equipo = $idEquipo and semana = $semana and id_plan = $idPlan and activo = 1 and status = 'PROCESO' and año = '$añoActual' ORDER BY id DESC LIMIT 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idOT = $x['id'];
                $fechaProgramada = $x['fecha_programada'];

                $array['idOT'] = intval($idOT);
                $array['fechaProgramada'] = $fechaProgramada;
            }
        }
        echo json_encode($array);
    }


    // FIN
}
