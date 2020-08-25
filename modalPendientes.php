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
                                    class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\">
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
                                    class=\"py-1 px-2 my-2 rounded-md bg-red-200 text-red-500 hover:shadow-sm w-full font-semibold\">
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

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="toggleSubseccionesTipo('modalExportarSubsecciones', 'subseccionesEXCEL', 'subseccionesPDF');">Subsecciones (EXCEL)</a>

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
                    <div class="py-1 px-2 rounded-l-md bg-red-200 text-red-500 font-normal cursor-pointer">
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
                    <div class="py-1 px-2 rounded-r-md bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                        <h1>Proyectos</h1>
                    </div>
                </div>
            </div>

            <div class="px-2 mt-12">
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

    <!-- Modales -->


    <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
    <script src="js/modales.js"></script>
    <script src="js/acordion.js"></script>
    <script src="js/sweetalert2@9.js"></script>
    <script src="js/alertasSweet.js"></script>
    <!-- <script src="js/plannerBetaJS.js"></script> -->
    <!-- <scriptpt src="js/calendarioBotones.js"></scriptpt> -->
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
                page = 'modalPendientes.php?idSeccion=' + idSeccion + '&tipoPendiente=' + tipoPendiente + '&idUsuario=' + idUsuario + '&idDestino=' + idDestino;
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
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarSeccion") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarSubseccion") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarPorResponsable") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarMisCreados") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarCreadosDe") {
                        page = 'php/generarPendientesExcel.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&generadoPor=' + usuarioSession;
                        window.location = page;
                    } else if (tipoExportar == "exportarMisCreadosPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&idDestino=' + idDestino + '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Fallas Y Tareas PDF",
                            "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    } else if (tipoExportar == "exportarMisPendientesPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&idDestino=' + idDestino + '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Fallas Y Tareas PDF",
                            "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    } else if (tipoExportar == "exportarCreadosPorPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&idDestino=' + idDestino +
                            '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Fallas Y Tareas PDF",
                            "directories=no, location=no, menubar=si, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    } else if (tipoExportar == "exportarSubseccionPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdT=' + data.listaIdT + '&listaIdF=' + data.listaIdF + '&idDestino=' + idDestino +
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
            setAttribute('onkeyup', 'exportarPorUsuario(' + idUsuario + ', ' + idDestino + ', ' + idSeccion + ', ' + idSubseccion + ', "' + tipoExportar + '")');
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
    </script>

</body>

</html>