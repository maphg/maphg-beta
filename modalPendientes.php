<?php
include 'php/conexion.php';

// Variables recibidad de $_GET.
$idSeccion = $_GET['idSeccion'];
$idDestino = $_GET['idDestino'];
$tipoPendiente = $_GET['tipoPendiente'];
$idUsuario = $_GET['idUsuario'];


if ($idDestino == 10) {
    $filtroDestino = "";
} else {
    $filtroDestino = "AND t_users.id_destino = $idDestino";
}

$arrayData = array();
$data = "";
$resultData = "";
$dataOpcionesSubsecciones = "";
$exportarSubseccion = "";
$exportarSubseccionPDF = "";
$exportarSeccion = "";
$exportarMisPendientes = "";
$exportarCreadosDe = "";
$exportarCreadosPorPDF = "";
$exportarPorResponsable = "";

// Identifica si el filtro es en General, Usuario Responsable, Usuario Creao o Seccion.
$tipoPendienteNombre = "";
$filtroSeccion = "";
$filtroUsuario = "";
$filtroSeccionT = "";
$filtroUsuarioT = "";

if ($tipoPendiente == "MCU") {
    $tipoPendienteNombre = "Mis Pendientes";
    $filtroUsuario = "AND t_mc.responsable = $idUsuario AND t_mc.id_seccion = $idSeccion";
    $filtroUsuarioT = "AND t_mp_np.responsable = $idUsuario AND t_equipos.id_seccion = $idSeccion";
} elseif ($tipoPendiente == "MCU0") {
    $tipoPendienteNombre = "Sin Responsable";
    $filtroUsuario = "AND (t_mc.responsable = 0 OR t_mc.responsable = '')";
    $filtroUsuarioT = "AND (t_mp_np.responsable = 0 OR t_mp_np.responsable = '')";
} elseif ($tipoPendiente == "MCS") {
    $tipoPendienteNombre = "Todos";
    $filtroSeccion = "AND t_mc.id_seccion = $idSeccion";
    $filtroSeccionT = "AND t_equipos.id_seccion = $idSeccion";
} elseif ($tipoPendiente == "MCC") {
    $tipoPendienteNombre = "Creados Por Mi";
    $filtroUsuario = "AND t_mc.creado_por = $idUsuario AND t_mc.id_seccion = $idSeccion";
    $filtroUsuarioT = "AND t_mp_np.id_usuario = $idUsuario AND t_equipos.id_seccion = $idSeccion";
} else {
    $tipoPendienteNombre = "";
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
    $query = "SELECT 
    c_subsecciones.id 'id_subseccion', c_subsecciones.grupo, c_secciones.seccion  
    FROM c_subsecciones 
    INNER JOIN c_secciones ON c_subsecciones.id_seccion = c_secciones.id
    WHERE id_seccion = $idSeccion";
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
        $misPendientesCreado = "$idSeccion, 'MCC', '$nombreSeccion', $idUsuario, $idDestino";
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

        $estiloSeccion = strtolower("$nombreSeccion" . "-logo");

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
        AND t_mc.status = 'N' AND t_mc.activo = 1 $filtroUsuario $filtroSeccion $filtroDestinoMC
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

            if ($nombreCompleto == "Sin Responsable" or $nombreCompleto == "") {
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
            $comentarioMC = "";
            if ($rowComentarioMC = mysqli_fetch_array($resultComentarioMC)) {
                $comentarioMC = $rowComentarioMC['comentario'];
                $nombreMC = $rowComentarioMC['nombre'];
                $apellidoMC = $rowComentarioMC['apellido'];
                $fechaMC = (new DateTime($rowComentarioMC['fecha']))->format('d-m-y');
                $nombreCompletoMC = strtok($nombreMC, ' ') . " " . strtok($apellidoMC, ' ');

                if (mysqli_num_rows($resultComentarioMC) > 0) {
                    $iconoComentarioMC = " <i class=\"fas fa-comment-dots\"></i>";
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
            if ($actividad != "") {
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
                                    <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver en Planner
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
        INNER JOIN t_equipos ON t_mp_np.id_equipo = t_equipos.id
        WHERE t_equipos.id_subseccion = $idSubseccion AND t_mp_np.activo = 1 AND (t_mp_np.status= 'N' OR t_mp_np.status= 'P') 
        $filtroSeccionT $filtroUsuarioT $filtroDestinoTareas";
        // echo $queryTareas;
        if ($resultTareas = mysqli_query($conn_2020, $queryTareas)) {
            foreach ($resultTareas as $value) {
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
                                    <i class=\"fas fa-eye mr-1  text-sm\"></i>Ver en Planner
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
                                class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\" onclick=\"verEnPlanner('FALLA', $idMC)\">
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
            $actividad = $t['actividad'];
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
                            <p id=\"" . $idMC . "Ttitulo\" class=\"truncate\">$actividad</p>
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
        $fechaActual = date('Y-m-d 23:59:59');
        $fechaFin = date("Y-m-d 00:00:00", strtotime($fechaActual . "- 70 days"));

        $queryT = "SELECT t_mc.id, t_mc.actividad, t_colaboradores.nombre, t_colaboradores.apellido  
            FROM t_mc 
            LEFT JOIN t_users ON t_mc.responsable = t_users.id 
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
            WHERE t_mc.id_subseccion = $idSubseccion 
            AND t_mc.status = 'F' AND activo = 1 AND t_mc.fecha_creacion BETWEEN '$fechaFin' AND '$fechaActual'
            $filtroUsuario $filtroSeccion $filtroDestinoMC  

            ORDER BY t_mc.id DESC";
        $resultT = mysqli_query($conn_2020, $queryT);

        foreach ($resultT as $t) {
            $idMC = $t['id'];
            $actividad = $t['actividad'];
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
                            <p id=\"" . $idMC . "Stitulo\" class=\"truncate\">$actividad</p>
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
                                class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\" onclick=\"verEnPlanner('FALLA', $idMC);\">
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
        // echo $resultData;
    }

    // Resultados Finales
    $arrayData['resultData'] = $resultData;
    $arrayData['dataOpcionesSubsecciones'] = $dataOpcionesSubsecciones;
    $arrayData['misPendientesUsuario'] = $misPendientesUsuario;
    $arrayData['misPendientesCreado'] = $misPendientesCreado;
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
}
// echo json_encode($arrayData);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 user-scalable=no">
    <title>Planner</title>
    <link rel="shortcut icon" href="svg/logo6.png" type="image/x-icon">
    <link rel="stylesheet" href="css/tailwindproduccion.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/modales.css">
    <link rel="stylesheet" href="css/fontawesome/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="css/alertify.min.css">

    <style>
        .w-22rem {
            width: 265px;
        }

        .shadow {
            display: block;
        }

        .mh {
            max-height: 500px;
        }

        .dia {
            font-size: 70px;
        }

        .top-20 {
            top: -2rem;
        }

        .btn-activo {
            color: white;
            background-color: #2d3748 !important;
        }

        .btn-inactivo {
            background-color: #e2e8f0;
        }
    </style>
</head>

<body class="bg-gray-200" style="font-family: 'Roboto', sans-serif;">

    <div id="modalPendientes" class="">
        <div class="modal-window py-10 rounded-md" style="width: 1300px;">
            <div class=" flex flex-col items-center justify-center">
                <div class="absolute top-0 left-0 flex flex-row">
                    <div>
                        <button id="btnExpandirMenu" onclick="expandir(this.id)" class="py-1 px-2 rounded-br-md bg-indigo-200 text-indigo-500 hover:shadow-sm rounded-tl-md font-normal relative">
                            <i class="fas fa-arrow-to-bottom mr-1"></i>Exportar Pendientes
                        </button>
                        <div id="btnExpandirMenutoggle" class="hidden absolute top-0 mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs z-30">

                            <a onclick="exportarPendientes(<?= $exportarMisPendientes; ?>);" id="exportarMisPendientes" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Mis
                                Pendientes (EXCEL)</a>

                            <a onclick="exportarPendientes(<?= $exportarSeccion; ?>);" id="exportarSeccion" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Sección
                                completa (EXCEL)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="toggleSubseccionesTipo('modalExportarSubsecciones', 'subseccionesEXCEL', 'subseccionesPDF');">Subsecciones
                                (EXCEL)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="exportarPorUsuario(<?= $exportarPorResponsable; ?>);">Responsable
                                (EXCEL)</a>

                            <a onclick="exportarPendientes(<?= $exportarMisCreados; ?>);" id="exportarMisPendientes" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Creados Por Mi (EXCEL)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="exportarPorUsuario(<?= $exportarCreadosDe; ?>);">Creados Por (EXCEL)</a>

                            <a onclick="exportarPendientes(<?= $exportarMisPendientesPDF; ?>);" id="exportarMisPendientesPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Mis Pendientes (PDF)</a>

                            <a onclick="exportarPendientes(<?= $exportarMisCreadosPDF; ?>);" id="exportarMisPendientesPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Creado Por Mi (PDF)</a>

                            <a id="exportarMisPendientesPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="toggleSubseccionesTipo('modalExportarSubsecciones', 'subseccionesPDF', 'subseccionesEXCEL');">
                                Subsección (PDF)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="exportarPorUsuario(<?= $exportarCreadosPorPDF; ?>);">Colaborador(PDF)</a>
                        </div>
                    </div>
                    <div class="ml-3">

                        <button id="btnvisualizarpendientesde" onclick="expandir(this.id)" class="py-1 px-2 rounded-b-md bg-teal-200 text-teal-500 hover:shadow-sm font-normal relative">
                            <i class="fas fa-eye mr-1"></i><?= $tipoPendienteNombre; ?>
                        </button>

                        <div id="btnvisualizarpendientesdetoggle" class="hidden absolute top-0  mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs z-30">

                            <a id="misPendientesCreados" onclick="pendientesSeccion(<?= $misPendientesCreado; ?>);" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Creados Por Mi</a>

                            <a id="misPendientesUsuario" onclick="pendientesSeccion(<?= $misPendientesUsuario; ?>);" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Mis Pendientes</a>

                            <a id="misPendientesSinUsuario" onclick="pendientesSeccion(<?= $misPendientesSinUsuario; ?>);" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Sin Responsable</a>

                            <a id="misPendientesSeccion" onclick="pendientesSeccion(<?= $misPendientesSeccion; ?>);" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Todos</a>

                        </div>
                    </div>
                    <div class="ml-3">
                        <button id="dataOpcionesSubsecciones" onclick="expandir(this.id)" class="py-1 px-2 rounded-b-md bg-orange-200 text-orange-500 hover:shadow-sm font-normal relative">
                            <i class="fas fa-eye mr-1"></i>Subsecciones
                        </button>
                        <div id="dataOpcionesSubseccionestoggle" class="hidden absolute top-0  mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs z-30">
                            <?= $dataOpcionesSubsecciones; ?>
                        </div>
                    </div>
                </div>


                <div class="text-blue-700 bg-blue-400 flex justify-center items-center top-20 shadow-md rounded-lg w-12 h-12">
                    <h1 id="estiloSeccion" class="font-medium text-md <?= $estiloSeccion; ?>">
                        <?= $nombreSeccion; ?>
                    </h1>
                </div>
                <div class="flex flex-row text-sm bg-white mt-4">
                    <div class="py-1 px-2 rounded-l-md bg-red-200 text-red-500 font-normal cursor-pointer" onclick="mostrarOpcion('pendientesFallasTareas');">
                        <h1>Fallas y Tareas</h1>
                    </div>
                    <div class="py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                        <a href="graficas_reportes_diario/">
                            <h1>Reporte Fallas Y Tareas</h1>
                        </a>
                    </div>
                    <div class="py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                        <h1>Preventivo</h1>
                    </div>
                    <div class="py-1 px-2 rounded-r-md bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer" onclick="mostrarOpcion('diagramaGantt');">
                        <h1>Proyectos</h1>
                    </div>
                </div>
            </div>

            <div id="pendientesFallasTareas" class="px-2 mt-12">
                <table class="table-auto text-xs text-center w-full">
                    <thead>
                        <tr class="cursor pointer">
                            <th class="px-4 py-2">Subsección</th>
                            <th class="px-4 py-2">Fallas y Tareas</th>
                            <th class="px-4 py-2">Pendiente DEP</th>
                            <th class="px-4 py-2">Trabajando</th>
                            <th class="px-4 py-2">Solucionado (10 Semanas)</th>
                        </tr>
                    </thead>
                    <tbody id="dataSubseccionesPendientes" class="divide-y">
                        <?= $resultData; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- MODAL VER EN PLANNER PARA LOS PENDIENTES  -->
    <div id="modalVerEnPlanner" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 900px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0 z-30">
                <button onclick="cerrarmodal('modalVerEnPlanner')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 flex flex-row items-center justify-start w-full">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md">
                    <h1>Detalles</h1>
                </div>
            </div>
            <div class="absolute top-0 flex flex-row items-center justify-center w-full">
                <div class="font-bold bg-teal-200 text-teal-500 text-xs py-1 px-2 rounded-b-md">
                    <h1 id="tipoPendienteVP"></h1>
                </div>
            </div>
            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center w-full pb-6">
                <div class="mb-3 flex flex-col w-full leading-none">
                    <h1 id="descripcionPendienteVP" class="px-2 py-1 w-full text-xl font-medium uppercase" style="color: #282B3B;"></h1>
                    <h1 class="px-2 py-1 w-full text-xs font-medium" style="color: #ABADB7;">Creado por:
                        <span id="creadoPorVP" class="uppercase ml-1"></span>
                    </h1>
                </div>

                <div class="w-full flex">
                    <div class="w-1/2 text-sm px-2 flex flex-col">
                        <h1 class="mb-1"></h1>
                        <div class="flex flex-wrap w-full justify-start items-center">

                            <div class="bg-purple-200 text-purple-700 px-2 rounded-full flex items-center mr-2">
                                <span id="fechaVP" class="bg-purple-200"></span>
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2 text-sm px-2 flex flex-col">
                        <h1 class="mb-1">Responsables</h1>
                        <div class="flex flex-wrap w-full justify-start items-center">

                            <div id="responsableVP" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                                <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                            </div>

                            <div id="dataResponsablesVP"></div>

                        </div>
                    </div>
                </div>

                <div class="w-full text-sm px-2 flex flex-col mt-3">
                    <h1 class="mb-1">Status</h1>
                    <div class="flex flex-wrap w-full justify-start items-center">
                        <div id="dataStatusVP" class="flex flex-wrap w-full justify-start items-center"></div>
                    </div>
                </div>

                <div class="w-full flex text-sm mt-5">
                    <div class="w-1/2 mt-3">
                        <h1 class="mb-6">Comentarios</h1>
                        <div class="px-4 overflow-y-auto scrollbar flex flex-col w-full" style="min-height: 499px; max-height: 500px;">

                            <div id="dataComentariosVP" class="flex justify-center items-center flex-col-reverse w-full"></div>

                            <div class="flex flex-row justify-center items-center w-full h-10 mt-4">
                                <input id="comentarioVP" type="text" placeholder="   Añadir comentario" class="h-full w-full rounded-l-md text-gray-600 font-medium border-2 border-r-0 focus:outline-none" autocomplete="off">
                                <button id="btnComentarioVP" class="py-2 h-full w-12 rounded-r-md bg-teal-200 text-teal-500 font-bold text-sm hover:shadow-md">
                                    <i class="fad fa-paper-plane"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="w-1/2  mt-3">
                        <div class="flex items-center justify-start">
                            <h1 class="mr-2">Adjuntos</h1>
                            <div id="adjuntosVP" class="bg-bluegray-900 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 cursor-pointer hover:bg-indigo-200 hover:text-indigo-600">
                                <h1 class="font-medium text-sm"> <i class="fas fa-plus"></i></h1>
                            </div>
                        </div>
                        <div class="w-full px-1 font-medium text-sm text-gray-400 overflow-y-auto scrollbar">
                            <div id="dataAdjuntosVP" class="flex flex-row flex-wrap justify-evenly items-start overflow-y-auto scrollbar mb-4" style="max-height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL Exportar Secciones Usuarios -->
    <div id="modalExportarSeccionesUsuarios" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 370px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalExportarSeccionesUsuarios');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>Colaboradores</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div class="mb-3 w-full">
                    <input id="palabraUsuarioExportar" class="border border-gray-200 shadow-md bg-white h-10 px-2 rounded-md text-sm focus:outline-none w-full" type="search" name="search" placeholder="Buscar..." autocomplete="off">
                </div>
                <div id="dataExportarSeccionesUsuarios" class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL Exportar Subsecciones -->
    <div id="modalExportarSubsecciones" class="modal">
        <div class="modal-window rounded-md pt-10" style="width: 370px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalExportarSubsecciones');" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="absolute top-0 left-0 flex flex-row items-center">
                <div class="font-bold bg-indigo-200 text-indigo-500 text-xs py-1 px-2 rounded-br-md rounded-tl-md">
                    <h1>Subsecciones</h1>
                </div>
            </div>

            <!-- CONTENIDO -->
            <div id="subseccionesEXCEL" class="hidden p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div id="dataModalOpciones" class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
                    <?= $exportarSubseccion; ?>
                </div>
            </div>
            <div id="subseccionesPDF" class="hidden p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div id="dataModalOpciones" class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
                    <?= $exportarSubseccionPDF; ?>
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

                <div id="statusMaterial" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-orange-500 bg-gray-200 hover:bg-orange-200 text-xs">
                    <div class="">
                        <h1>NO HAY MATERIAL</h1>
                    </div>
                    <div class="absolute left-0 top-0 w-8 h-8 rounded-l-md flex items-center justify-center font-black">
                        <h1>M</h1>
                    </div>
                </div>

                <div id="statusTrabajare" class="w-full text-center h-8 rounded-md cursor-pointer mb-2 relative flex items-center justify-center hover:shadow-md hover:shadow-md text-gray-500 hover:text-blue-500 bg-gray-200 hover:bg-blue-200 text-xs">
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


    <!-- MODAL EDITAR FECHA EN FALLAS   -->
    <div id="modalFechaTareas" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalFechaTareas')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- INDICACION -->
            <div class="flex flex-row items-center pt-10">
                <input id="fechaTareas" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="fechaTareas" value="---">
            </div>
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



    <!-- MODAL EDITAR FECHA EN FALLAS   -->
    <div id="modalFechaMC" class="modal">
        <div class="modal-window rounded-md pb-2 px-5" style="width: 300px;">
            <!-- BOTON CERRARL -->
            <div class="absolute top-0 right-0">
                <button onclick="cerrarmodal('modalFechaMC')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
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
                <input id="fechaMC" class="appearance-none block w-full border rounded p-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500 w-full text-center" type="text" name="fechaMC" value="---">
            </div>
        </div>
    </div>

    <!-- Modales -->


    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <script src="js/alertify.min.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/acordion.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script src="js/alertasSweet.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        function expandir(id) {
            idtoggle = id + 'toggle';
            var toggle = document.getElementById(idtoggle);
            toggle.classList.toggle("hidden");

            var titulox = document.getElementById(idtitulo);
            titulox.classList.remove("truncate");
        }


        function expandirpapa(idpapa) {
            var expandeapapa = document.getElementById(idpapa);
            expandeapapa.classList.toggle("h-40");
        }


        // toggle Inivisible Generico.
        function toggleInivisble(id) {
            $("#" + id).toggleClass('modal');
        }

        // toggleClass Modal TailWind con la clase OPEN.
        function toggleModalTailwind(idModal) {
            $("#" + idModal).toggleClass('open');
        }

        // Funcion para ocultar y mostrar con clases.
        function mostrarOcultar(claseMostrar, claseOcultar) {
            $("." + claseMostrar).removeClass('hidden invisible');
            $("." + claseOcultar).addClass('hidden invisible');
        }


        function pendientesSeccion(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino) {

            if (tipoPendiente != "") {
                // idSeccion = 1 & idDestino = 1 & tipoPendiente = MCS & idUsuario = 1#
                page = 'modalPendientes.php?idSeccion=' + idSeccion + '&tipoPendiente=' + tipoPendiente + '&idUsuario=' +
                    idUsuario + '&idDestino=' + idDestino;
                window.location = page;
            }
        }

        function exportarPendientes(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar) {
            // console.log(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar);
            const action = "consultaFinalExcel";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idSeccion: idSeccion,
                    idSubseccion: idSubseccion,
                    tipoExportar: tipoExportar
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data.listaIdT);
                    console.log(data.listaIdF);
                    let usuarioSession = localStorage.getItem('usuario');

                    if (tipoExportar == "exportarMisPendientes") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarSeccion") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarSubseccion") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarPorResponsable") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarMisCreados") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarCreadosDe") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarMisCreadosPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&idDestino=' + idDestino + '&idUsuario=' + idUsuario + '&idSeccion=' +
                            idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Fallas Y Tareas PDF",
                            "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    } else if (tipoExportar == "exportarMisPendientesPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&idDestino=' + idDestino + '&idUsuario=' + idUsuario + '&idSeccion=' +
                            idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Fallas Y Tareas PDF",
                            "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    } else if (tipoExportar == "exportarCreadosPorPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&idDestino=' + idDestino +
                            '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Fallas Y Tareas PDF",
                            "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    } else if (tipoExportar == "exportarSubseccionPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data
                            .listaIdF + '&idDestino=' + idDestino +
                            '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Fallas Y Tareas PDF",
                            "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    }
                }
            });
        }

        function exportarPorUsuario(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar) {
            document.getElementById("dataExportarSeccionesUsuarios").innerHTML = '';
            let palabraUsuario = document.getElementById("palabraUsuarioExportar").value;
            // Agrega la función en el Input palabraUsuarioExportar.
            document.getElementById("palabraUsuarioExportar").
            setAttribute('onkeyup', 'exportarPorUsuario(' + idUsuario + ', ' + idDestino + ', ' + idSeccion + ', ' +
                idSubseccion + ', "' + tipoExportar + '")');
            const action = "exportarPorUsuario";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idSeccion: idSeccion,
                    idSubseccion: idSubseccion,
                    tipoExportar: tipoExportar,
                    palabraUsuario: palabraUsuario
                },
                // dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    document.getElementById("modalExportarSeccionesUsuarios").classList.add('open');
                    document.getElementById("dataExportarSeccionesUsuarios").innerHTML = data;
                }
            });
        }

        // Función para buscar usuarios para Exportar.
        function exportarListarUsuarios(idUsuario, idDestino, idSeccion) {
            const action = "exportarListarUsuarios";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idSeccion: idSeccion,
                },
                // dataType: "JSON",
                success: function(data) {
                    $("#dataExportarSeccionesUsuarios").html(data);
                }
            });
        }

        function toggleSubseccionesTipo(idUno, idDos, idTres) {
            document.getElementById(idUno).classList.add('open');
            document.getElementById(idDos).classList.remove('hidden');
            document.getElementById(idTres).classList.add('hidden');
        }

        function verEnPlanner(tipoPendiente, idPendiente) {
            document.getElementById("modalVerEnPlanner").classList.add('open');
            let idUsuario = localStorage.getItem('usuario');
            let idDestino = localStorage.getItem('idDestino');
            const action = "verEnPlanner";
            document.getElementById("dataStatusVP").
            setAttribute('onclick', 'verEnPlanner("' + tipoPendiente + '",+' + idPendiente + ')');


            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    tipoPendiente: tipoPendiente,
                    idPendiente: idPendiente
                },
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    document.getElementById("tipoPendienteVP").innerHTML = tipoPendiente + ': ' + data
                        .idPendiente;
                    document.getElementById("descripcionPendienteVP").innerHTML = data.actividad;
                    document.getElementById("creadoPorVP").innerHTML = data.creadoPor;
                    document.getElementById("fechaVP").value = data.fecha;
                    document.getElementById("dataResponsablesVP").innerHTML = data.responsable;
                    document.getElementById("dataStatusVP").innerHTML = data.status;
                    document.getElementById("dataComentariosVP").innerHTML = data.dataComentariosVP;
                    document.getElementById("dataAdjuntosVP").innerHTML = data.adjuntos;

                    if (tipoPendiente == "FALLA") {

                        // FECHA
                        document.getElementById("fechaVP").
                        setAttribute('onclick', 'obtenerFechaMC(' + idPendiente + ', "' + data.fecha + '")');
                        document.getElementById("fechaVP").innerHTML = data.fecha;
                        document.getElementById("fechaTareas").value = data.fecha;


                        // RESPONSABLE
                        document.getElementById("responsableVP").
                        setAttribute('onclick', 'obtenerUsuarios("asignarMC",' + idPendiente + ')');


                        // ADJUNTOS
                        document.getElementById("adjuntosVP").
                        setAttribute('onclick', 'obtenerAdjuntosMC(' + idPendiente + ')');

                        // COMENTARIOS
                        document.getElementById("btnComentarioVP").
                        setAttribute('onclick', 'agregarComentarioVP("' + tipoPendiente + '", ' + idPendiente +
                            ')');

                    } else if (tipoPendiente == "TAREA") {

                        // FECHA
                        document.getElementById("fechaVP").
                        setAttribute('onclick', 'obtenerFechaTareas(' + idPendiente + ', "' + data.fecha +
                            '")');
                        document.getElementById("fechaVP").innerHTML = data.fecha;
                        document.getElementById("fechaTareas").value = data.fecha;


                        // RESPONSABLE
                        document.getElementById("responsableVP").
                        setAttribute('onclick', 'obtenerUsuarios("asignarTarea",' + idPendiente + ')');


                        // ADJUNTOS
                        document.getElementById("adjuntosVP").
                        setAttribute('onclick', 'obtenerAdjuntosTareas(' + idPendiente + ')');

                        // COMENTARIOS
                        document.getElementById("btnComentarioVP").
                        setAttribute('onclick', 'agregarComentarioVP("' + tipoPendiente + '", ' + idPendiente +
                            ')');
                    }
                }
            });
        }


        function agregarComentarioVP(tipoPendiente, idPendiente) {
            let comentario = document.getElementById("comentarioVP").value;
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            const action = "comentarioVP";

            if (comentario.length > 0) {
                $.ajax({
                    type: "POST",
                    url: "php/plannerCrudPHP.php",
                    data: {
                        action: action,
                        idUsuario: idUsuario,
                        idDestino: idDestino,
                        idPendiente: idPendiente,
                        comentario: comentario,
                        tipoPendiente: tipoPendiente
                    },
                    // dataType: "JSON",
                    success: function(data) {

                        if (data == 1) {
                            verEnPlanner(tipoPendiente, idPendiente);
                            alertaImg("Comentario Agregado", "", "success", 2000);
                            document.getElementById("comentarioVP").value = "";
                        } else {
                            alertaImg("Intente de Nuevo", "", "question", 2000);
                        }

                    },
                });

            } else {
                alertaImg("Comentario Vacio", "", "info", 2000);
            }
        }

        // Función para Obtener el Status y agregar la funcion para poder actualizarlo.
        function obtenerstatusMC(idMC) {
            document.getElementById("modalStatus").classList.add("open");
            localStorage.setItem("idMC", idMC);
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            const action = "obtenerStatusMC";

            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idMC: idMC,
                },
                dataType: "JSON",
                success: function(data) {
                    // Llama a la Función para reflejar los cambios en los MC por Equipo.

                    // console.log(data);
                    // Status
                    document
                        .getElementById("statusUrgente")
                        .setAttribute("onclick", data.dataStatusUrgente);
                    document
                        .getElementById("statusMaterial")
                        .setAttribute("onclick", data.dataStatusMaterial);
                    document
                        .getElementById("statusTrabajare")
                        .setAttribute("onclick", data.dataStatusTrabajare);
                    // Status Departamento.
                    document
                        .getElementById("statusCalidad")
                        .setAttribute("onclick", data.dataStatusCalidad);
                    document
                        .getElementById("statusCompras")
                        .setAttribute("onclick", data.dataStatusCompras);
                    document
                        .getElementById("statusDireccion")
                        .setAttribute("onclick", data.dataStatusDireccion);
                    document
                        .getElementById("statusFinanzas")
                        .setAttribute("onclick", data.dataStatusFinanzas);
                    document
                        .getElementById("statusRRHH")
                        .setAttribute("onclick", data.dataStatusRRHH);
                    // Status Energéticos.
                    document
                        .getElementById("statusElectricidad")
                        .setAttribute("onclick", data.dataStatusElectricidad);
                    document
                        .getElementById("statusAgua")
                        .setAttribute("onclick", data.dataStatusAgua);
                    document
                        .getElementById("statusDiesel")
                        .setAttribute("onclick", data.dataStatusDiesel);
                    document
                        .getElementById("statusGas")
                        .setAttribute("onclick", data.dataStatusGas);
                    // Finalizar MC.
                    document
                        .getElementById("statusFinalizar")
                        .setAttribute("onclick", data.dataStatus);
                    // Activo MC.
                    document
                        .getElementById("statusActivo")
                        .setAttribute("onclick", data.dataStatusActivo);
                    // Titulo MC.
                    document
                        .getElementById("btnEditarTitulo")
                        .setAttribute("onclick", data.dataStatusTitulo);
                    document.getElementById("inputEditarTitulo").value = data.dataTituloMC;
                },
            });
        }

        function obtenerUsuarios(tipoAsginacion, idItem) {
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let palabraUsuario = document.getElementById("palabraUsuario").value;

            document.getElementById("modalUsuarios").classList.add("open");
            document.getElementById("dataUsuarios").innerHTML =
                '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';

            const action = "obtenerUsuarios";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    palabraUsuario: palabraUsuario,
                    tipoAsginacion: tipoAsginacion,
                    idItem: idItem,
                },
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);
                    alertaImg("Usuarios Obtenidos: " + data.totalUsuarios, "", "info", 2000);
                    document.getElementById("dataUsuarios").innerHTML = data.dataUsuarios;
                    document
                        .getElementById("palabraUsuario")
                        .setAttribute(
                            "onkeydown",
                            'obtenerUsuarios("' + tipoAsginacion + '",' + idItem + ")"
                        );
                },
            });
        }

        // Función para actualizar Status t_mc.
        function actualizarStatusMC(idMC, status, valorStatus) {
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let idEquipo = localStorage.getItem("idEquipo");
            let tituloMC = document.getElementById("inputEditarTitulo").value;
            const action = "actualizarStatusMC";

            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idMC: idMC,
                    status: status,
                    valorStatus: valorStatus,
                    tituloMC: tituloMC,
                },
                // dataType: "JSON",
                success: function(data) {
                    verEnPlanner('FALLA', idMC);
                    if (data == 1) {
                        alertaImg("Información Actualizada", "", "success", 2000);
                        if (status == "activo" || status == "status") {
                            obtenerDatosUsuario(idDestino);
                        }
                        if (valorStatus == "F") {
                            verEnPlanner('FALLA', idMC);
                        } else {
                            // obtenerMCN(idEquipo);
                            document.getElementById("modalEditarTitulo").classList.remove("open");
                            document.getElementById("modalStatus").classList.remove("open");
                        }
                        // Cierra el Modal de Fecha MC.
                        document.getElementById("modalFechaMC").classList.remove("open");
                    } else {
                        alertaImg("Intente de Nuevo", "", "question", 2000);
                    }
                },
            });
        }


        // Función para Asignar usuario.
        function asignarUsuario(idUsuarioSeleccionado, tipoAsginacion, idItem) {
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");

            const action = "asignarUsuario";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idUsuarioSeleccionado: idUsuarioSeleccionado,
                    idDestino: idDestino,
                    tipoAsginacion: tipoAsginacion,
                    idItem: idItem,
                },
                // dataType: "JSON",
                success: function(data) {
                    // console.log(data);

                    if (data == "MC") {
                        alertaImg("Responsable Actualizado", "", "success", 2500);
                        document.getElementById("modalUsuarios").classList.remove("open");
                        let idEquipo = localStorage.getItem("idEquipo");
                        verEnPlanner("FALLA", idItem);

                        // TAREAS
                    } else if (data == "TAREA") {
                        alertaImg("Responsable Actualizado", "", "success", 2500);
                        document.getElementById("modalUsuarios").classList.remove("open");
                        let idEquipo = localStorage.getItem("idEquipo");
                        verEnPlanner("TAREA", idItem);
                    } else {
                        alertaImg("Intenete de Nuevo", "", "question", 2500);
                    }
                },
            });
        }


        // Funcion para Obtener Adjuntos.
        function obtenerAdjuntosMC(idMC) {
            // Actualiza el MC seleccionado.
            localStorage.setItem("idMC", idMC);

            // Recupera datos.
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let idEquipo = localStorage.getItem("idEquipo");

            document.getElementById("dataImagenes").innerHTML =
                '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
            document.getElementById("dataAdjuntos").classList.add("justify-center");

            document.getElementById("dataAdjuntos").innerHTML =
                '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
            document.getElementById("dataImagenes").classList.add("justify-center");
            document.getElementById("modalMedia").classList.add("open");
            document.getElementById("contenedorImagenes").classList.add('hidden');
            document.getElementById("contenedorDocumentos").classList.add('hidden');

            document.getElementById("inputAdjuntos").
            setAttribute("onchange", "subirImagenGeneral(" + idMC + ',"t_mc_adjuntos")');

            const action = "obtenerAdjuntosMC";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idMC: idMC
                },
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);

                    if (data.imagen != "") {
                        document.getElementById("dataImagenes").innerHTML = data.imagen;
                        document.getElementById("contenedorImagenes").classList.remove('hidden');
                        document.getElementById("dataImagenes").classList.remove("justify-center");
                    }

                    if (data.documento != "") {
                        document.getElementById("dataAdjuntos").innerHTML = data.documento;
                        document.getElementById("contenedorDocumentos").classList.remove('hidden');
                        document.getElementById("dataAdjuntos").classList.remove("justify-center");
                    }

                },
            });
        }


        // Sube imagenes con dos parametros, con el formulario #inputAdjuntos
        function subirImagenGeneral(idTabla, tabla) {
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let img = document.getElementById("inputAdjuntos").files;

            for (let index = 0; index < img.length; index++) {
                let imgData = new FormData();
                const action = "subirImagenGeneral";
                document.getElementById("cargandoAdjunto").innerHTML =
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
                        document.getElementById("cargandoAdjunto").innerHTML = "";
                        document.getElementById("inputAdjuntos").value = "";
                        if (data == 1) {
                            alertaImg("Proceso Cancelado", "", "info", 3000);
                        } else if (data == 2) {
                            alertaImg("Archivo Pesado (MAX:99MB)", "", "info", 3000);

                            // Sube y Actualiza la Vista para las Cotizaciones de Proyectos.
                        } else if (data == 3) {
                            alertaImg("Cotización Agregada", "", "success", 2500);
                            obtenerProyectosP("PROYECTO");
                            cotizacionesProyectos(idTabla);

                            // Sube y Actualiza la Vista para los Adjuntos de Planaccion.
                        } else if (data == 4) {
                            alertaImg("Adjunto Agregado", "", "success", 2500);
                            obtenerProyectosP("PROYECTO");
                            adjuntosPlanaccion(idTabla);
                        } else if (data == 5) {
                            alertaImg("Adjunto Agregado", "", "success", 2500);
                            obtenerMediaEquipo(idTabla);
                        } else if (data == 7) {
                            verEnPlanner('TAREA', idTabla);
                            obtenerAdjuntosTareas(idTabla)
                            alertaImg("Adjunto Agregado", "", "success", 2500);
                        } else if (data == 8) {
                            obtenerAdjuntosMC(idTabla);
                            verEnPlanner('FALLA', idTabla);
                            alertaImg("Adjunto Agregado", "", "success", 2500);
                        } else {
                            alertaImg("Intente de Nuevo", "", "info", 3000);
                        }
                        // console.log(data);
                    },
                });
            }
        }

        // Modifica Status o alguna Columna(titulo, activo, status) en TAREAS
        function obtenerInformacionTareas(idTarea, tituloTarea) {
            document.getElementById("modalStatus").classList.add("open");
            localStorage.setItem("idTarea", idTarea);

            // La función actulizarTarea(), recibe 3 parametros idTarea, columna a modificar y el tercer parametro solo funciona para el titulo por ahora

            // Status
            document
                .getElementById("statusUrgente")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "status_urgente", 0)'
                );
            document
                .getElementById("statusMaterial")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "status_material", 0)'
                );
            document
                .getElementById("statusTrabajare")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "status_trabajando", 0)'
                );

            // Status Departamento.
            document
                .getElementById("statusCalidad")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "departamento_calidad", 0)'
                );
            document
                .getElementById("statusCompras")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "departamento_compras", 0)'
                );
            document
                .getElementById("statusDireccion")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "departamento_direccion", 0)'
                );
            document
                .getElementById("statusFinanzas")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "departamento_finanzas", 0)'
                );
            document
                .getElementById("statusRRHH")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "departamento_rrhh", 0)'
                );

            // Status Energéticos.
            document
                .getElementById("statusElectricidad")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "energetico_electricidad", 0)'
                );
            document
                .getElementById("statusAgua")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "energetico_agua", 0)'
                );
            document
                .getElementById("statusDiesel")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "energetico_diesel", 0)'
                );
            document
                .getElementById("statusGas")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "energetico_gas", 0)'
                );

            // Finalizar MC.
            document
                .getElementById("statusFinalizar")
                .setAttribute(
                    "onclick",
                    "actualizarTareas(" + idTarea + ', "status", "F")'
                );
            // Activo MC.
            document
                .getElementById("statusActivo")
                .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "activo", 0)');
            // Titulo MC.
            document
                .getElementById("btnEditarTitulo")
                .setAttribute("onclick", "actualizarTareas(" + idTarea + ', "titulo", 0)');
            document.getElementById("inputEditarTitulo").value = tituloTarea;
        }


        // Actualiza Datos de las Tareas
        function actualizarTareas(idTarea, columna, valor) {
            let tituloNuevo = document.getElementById("inputEditarTitulo").value;
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");
            let idEquipo = localStorage.getItem("idEquipo");
            const action = "actualizarTareas";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idTarea: idTarea,
                    columna: columna,
                    valor: valor,
                    tituloNuevo: tituloNuevo,
                },
                // dataType: "JSON",
                success: function(data) {
                    if (data == 1) {
                        verEnPlanner("TAREA", idTarea);
                        alertaImg("Status Actualizado", "", "success", 2000);
                        document.getElementById("modalStatus").classList.remove("open");
                    } else if (data == 2) {
                        obtenerDatosUsuario(idDestino);
                        llamarFuncionX("obtenerEquipos");
                        verEnPlanner("TAREA", idTarea);
                        alertaImg("Tarea SOLUCIONADA", "", "success", 2000);
                        document.getElementById("modalStatus").classList.remove("open");
                    } else if (data == 3) {
                        obtenerDatosUsuario(idDestino);
                        obtenerTareasS(idTarea);
                        llamarFuncionX("obtenerEquipos");
                        alertaImg("Tarea Recuperada como PENDIENTE", "", "success", 2000);
                        document.getElementById("modalStatus").classList.remove("open");
                    } else if (data == 4) {
                        verEnPlanner("TAREA", idTarea);
                        obtenerDatosUsuario(idDestino);
                        llamarFuncionX("obtenerEquipos");
                        alertaImg("Tarea Eliminada", "", "success", 2000);
                        document.getElementById("modalStatus").classList.remove("open");
                    } else if (data == 5) {
                        verEnPlanner("TAREA", idTarea);
                        alertaImg("Título Actualizado", "", "success", 2000);
                        document.getElementById("modalStatus").classList.remove("open");
                    } else if (data == 6) {
                        verEnPlanner("TAREA", idTarea);
                        alertaImg("Rango de Fecha, Actualizada", "", "success", 2000);
                        document.getElementById("modalStatus").classList.remove("open");
                    } else {
                        alertaImg("Intente de Nuevo", "", "question", 2000);
                    }
                },
            });
        }

        // Obtener Media para las TAREAS.
        function obtenerAdjuntosTareas(idTarea) {
            // Actualiza id TAREA seleccionado.
            localStorage.setItem("idTarea", idTarea);

            // Recupera datos.
            let idUsuario = localStorage.getItem("usuario");
            let idDestino = localStorage.getItem("idDestino");

            document.getElementById("dataImagenes").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
            document.getElementById("dataAdjuntos").classList.add("justify-center");

            document.getElementById("dataAdjuntos").innerHTML = '<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>';
            document.getElementById("dataImagenes").classList.add("justify-center");
            document.getElementById("modalMedia").classList.add("open");
            document.getElementById("contenedorImagenes").classList.add('hidden');
            document.getElementById("contenedorDocumentos").classList.add('hidden');

            document.getElementById("inputAdjuntos").
            setAttribute("onchange", "subirImagenGeneral(" + idTarea + ',"adjuntos_mp_np")');

            const action = "obtenerAdjuntosTareas";
            $.ajax({
                type: "POST",
                url: "php/plannerCrudPHP.php",
                data: {
                    action: action,
                    idUsuario: idUsuario,
                    idDestino: idDestino,
                    idTarea: idTarea
                },
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);

                    if (data.dataImagenes != "") {
                        document.getElementById("dataImagenes").innerHTML = data.dataImagenes;
                        document.getElementById("dataImagenes").classList.remove("justify-center");
                        document.getElementById("contenedorImagenes").classList.remove('hidden');
                    }

                    if (data.dataAdjuntos != "") {
                        document.getElementById("dataAdjuntos").innerHTML = data.dataAdjuntos;
                        document.getElementById("dataAdjuntos").classList.remove("justify-center");
                        document.getElementById("contenedorDocumentos").classList.remove('hidden');
                    }
                },
            });
        }

        // Agregar Fecha MC.
        function obtenerFechaTareas(idTarea, rangoFecha) {
            document.getElementById("modalFechaTareas").classList.add("open");
            document.getElementById("fechaTareas").value = rangoFecha;
            localStorage.setItem("idTarea", idTarea);
        }


        // Función para Input Fechas para Agregar MC.
        $(function() {
            $('input[name="datefilter"]').daterangepicker({
                autoUpdateInput: false,
                showWeekNumbers: true,
                locale: {
                    cancelLabel: "Cancelar",
                    applyLabel: "Aplicar",
                    fromLabel: "De",
                    toLabel: "A",
                    customRangeLabel: "Personalizado",
                    weekLabel: "S",
                    daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    monthNames: [
                        "Enero",
                        "Febreo",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            });
            $('input[name="datefilter"]').on("apply.daterangepicker", function(
                ev,
                picker
            ) {
                $(this).val(
                    picker.startDate.format("DD/MM/YYYY") +
                    " - " +
                    picker.endDate.format("DD/MM/YYYY")
                );
            });
            $('input[name="datefilter"]').on("cancel.daterangepicker", function(
                ev,
                picker
            ) {
                // console.log(picker);
                $(this).val("");
            });
        });


        // Función para Input Fechas TAREAS
        $(function() {
            $('input[name="fechaTareas"]').daterangepicker({
                autoUpdateInput: false,
                showWeekNumbers: true,
                locale: {
                    cancelLabel: "Cancelar",
                    applyLabel: "Aplicar",
                    fromLabel: "De",
                    toLabel: "A",
                    customRangeLabel: "Personalizado",
                    weekLabel: "S",
                    daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    monthNames: [
                        "Enero",
                        "Febreo",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            });
            $('input[name="fechaTareas"]').on("apply.daterangepicker", function(
                ev,
                picker
            ) {
                $(this).val(
                    picker.startDate.format("DD/MM/YYYY") +
                    " - " +
                    picker.endDate.format("DD/MM/YYYY")
                );

                // Actualiza fecha TAREAS cuando se Aplica el rango.
                let rangoFecha =
                    picker.startDate.format("DD/MM/YYYY") +
                    " - " +
                    picker.endDate.format("DD/MM/YYYY");
                let idTarea = localStorage.getItem("idTarea");
                actualizarTareas(idTarea, "rango_fecha", rangoFecha);
            });
            $('input[name="fechaTareas"]').on("cancel.daterangepicker", function(
                ev,
                picker
            ) {
                // console.log(picker);
                $(this).val("");
            });
        });


        // Función para Input Fechas FALLAS
        $(function() {
            $('input[name="fechaMC"]').daterangepicker({
                autoUpdateInput: false,
                showWeekNumbers: true,
                locale: {
                    cancelLabel: "Cancelar",
                    applyLabel: "Aplicar",
                    fromLabel: "De",
                    toLabel: "A",
                    customRangeLabel: "Personalizado",
                    weekLabel: "S",
                    daysOfWeek: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    monthNames: [
                        "Enero",
                        "Febreo",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            });
            $('input[name="fechaMC"]').on("apply.daterangepicker", function(ev, picker) {
                $(this).val(
                    picker.startDate.format("DD/MM/YYYY") +
                    " - " +
                    picker.endDate.format("DD/MM/YYYY")
                );

                // Actualiza fecha MC cuando se Aplica el rango.
                let rangoFecha =
                    picker.startDate.format("DD/MM/YYYY") +
                    " - " +
                    picker.endDate.format("DD/MM/YYYY");
                let idMC = localStorage.getItem("idMC");
                actualizarStatusMC(idMC, "rango_fecha", rangoFecha);
            });
            $('input[name="fechaMC"]').on("cancel.daterangepicker", function(
                ev,
                picker
            ) {
                // console.log(picker);
                $(this).val("");
            });
        });


        // Agregar Fecha MC.
        function obtenerFechaMC(idMC, rangoFecha) {
            document.getElementById("modalFechaMC").classList.add("open");
            document.getElementById("fechaMC").value = rangoFecha;
            localStorage.setItem("idMC", idMC);
        }
    </script>

</body>

</html>