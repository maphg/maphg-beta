<?php
include 'php/conexion.php';

// Variables recibidad de $_GET.
$idSeccion = $_GET['idSeccion'];
$idDestino = $_GET['idDestino'];
$tipoPendiente = $_GET['tipoPendiente'];
$idUsuario = $_GET['idUsuario'];


$exportarSeccionUsuario = "";
if ($idDestino == 10) {
    $filtroDestino = "";
} else {
    $filtroDestino = "AND t_users.id_destino = $idDestino";
}

if ($idDestino == 10) {
    $queryUsuario = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido 
    FROM t_users 
    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
    WHERE t_users.status = 'A' ORDER BY t_colaboradores.nombre ASC";
} else {
    $queryUsuario = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido 
    FROM t_users 
    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
    WHERE t_users.status = 'A' AND(t_users.id_destino = $idDestino OR t_users.id_destino = 10) ORDER BY t_colaboradores.nombre ASC";
}

if ($resultUsuario = mysqli_query($conn_2020, $queryUsuario)) {
    foreach ($resultUsuario as $row) {
        $idUsuario1 = $row['id'];
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
        $exportarSeccionUsuario .= "
            <div class=\"exportarEXCEL hidden w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
            onclick=\"exportarPendientes($idUsuario1, $idDestino, $idSeccion, 0, 'exportarSeccionUsuario');\">
                <h1 class=\"ml-2\">$nombre $apellido</h1>
            </div> 

            <div class=\"exportarPDF hidden w-full p-2 rounded-md mb-1 hover:text-gray-900 hover:bg-indigo-200 hover:text-indigo-500 hover:shadow-sm cursor-pointer flex flex-row items-center truncate\"
            onclick=\"exportarPendientes($idUsuario1, $idDestino, $idSeccion, 0, 'exportarSeccionUsuarioPDF');\">
                <h1 class=\"ml-2\">$nombre $apellido</h1>
            </div>                
                ";
    }
}



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
    $filtroUsuario = "AND t_mc.responsable = $idUsuario";
} elseif ($tipoPendiente == "MCU0") {
    $filtroUsuario = "AND (t_mc.responsable = 0 OR t_mc.responsable = '')";
} elseif ($tipoPendiente == "MCS") {
    $filtroSeccion = "AND t_mc.id_seccion = $idSeccion";
} else {
    $filtroSeccion = "AND id_seccion = 0";
    $filtroUsuario = "AND (t_mc.creado_por = 0 OR t_mc.responsable = 0)";
}

if ($idDestino == 10) {
    $filtroDestinoMC = "";
} else {
    $filtroDestinoMC = "AND t_mc.id_destino = $idDestino";
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
        $misPendientesSinUsuario = "$idSeccion, 'MCU0', '$nombreSeccion', $idUsuario, $idDestino";
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


        $estiloSeccion = strtolower("$nombreSeccion" . "-logo");

        $dataOpcionesSubsecciones .= "<a href=\"#\" class=\"py-1 px-2 w-full hover:bg-gray-700\" onclick=\"toggleInivisble($idSubseccion);\">$subseccion</a>";

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
    $arrayData['misPendientesSinUsuario'] = $misPendientesSinUsuario;
    $arrayData['misPendientesSeccion'] = $misPendientesSeccion;
    $arrayData['estiloSeccion'] = $estiloSeccion;
    $arrayData['exportarSubseccion'] = $exportarSubseccion;
    $arrayData['exportarSeccion'] = $exportarSeccion;
    $arrayData['exportarMisPendientes'] = $exportarMisPendientes;
    $arrayData['exportarMisPendientesPDF'] = $exportarMisPendientesPDF;
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
                <div class="absolute top-0 right-0">
                    <button onclick="cerrarmodal('modalPendientes')" class="cursor-pointer text-md  text-red-500  bg-red-200 px-2 rounded-bl-md rounded-tr-md font-normal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="absolute top-0 left-0 flex flex-row">
                    <div>
                        <button id="btnExpandirMenu" onclick="expandir(this.id)" class="py-1 px-2 rounded-br-md bg-indigo-200 text-indigo-500 hover:shadow-sm rounded-tl-md font-normal relative">
                            <i class="fas fa-arrow-to-bottom mr-1"></i>Exportar Pendientes
                        </button>
                        <div id="btnExpandirMenutoggle" class="hidden absolute top-0 mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs">

                            <a onclick="exportarPendientes(<?= $exportarMisPendientes; ?>);" id="exportarMisPendientes" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Mis
                                Pendientes (EXCEL)</a>

                            <a onclick="exportarPendientes(<?= $exportarSeccion; ?>);" id="exportarSeccion" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Sección
                                completa (EXCEL)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="toggleModalTailwind('modalExportarSubsecciones')">Subsecciones (EXCEL)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="mostrarOcultar('exportarEXCEL','exportarPDF'); toggleModalTailwind('modalExportarSeccionesUsuarios')">Colaborador
                                (EXCEL)</a>

                            <a onclick="exportarPendientes(<?= $exportarMisPendientesPDF; ?>);" id="exportarMisPendientesPDF" href="#" class="py-1 px-2 w-full hover:bg-gray-700">
                                Mis Pendientes (PDF)</a>

                            <a href="#" class="py-1 px-2 w-full hover:bg-gray-700" onclick="mostrarOcultar('exportarPDF','exportarEXCEL'); toggleModalTailwind('modalExportarSeccionesUsuarios')">Colaborador(PDF)</a>
                        </div>
                    </div>
                    <div class="ml-3" (Excel)>
                        <button id="btnvisualizarpendientesde" onclick="expandir(this.id)" class="py-1 px-2 rounded-b-md bg-teal-200 text-teal-500 hover:shadow-sm font-normal relative">
                            <i class="fas fa-eye mr-1"></i>Mis Pendientes
                        </button>
                        <div id="btnvisualizarpendientesdetoggle" class="hidden absolute top-0  mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs">
                            <a id="misPendientesUsuario" onclick="pendientesSubseccion(<?= $misPendientesUsuario; ?>);" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Mis
                                Pendientes</a>

                            <a id="misPendientesSinUsuario" onclick="pendientesSubseccion(<?= $misPendientesSinUsuario; ?>);" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Sin
                                Responsable</a>
                            <a id="misPendientesSeccion" onclick="pendientesSubseccion(<?= $misPendientesSeccion; ?>);" href="#" class="py-1 px-2 w-full hover:bg-gray-700">Todos</a>
                        </div>
                    </div>
                    <div class="ml-3">
                        <button id="dataOpcionesSubsecciones" onclick="expandir(this.id)" class="py-1 px-2 rounded-b-md bg-orange-200 text-orange-500 hover:shadow-sm font-normal relative">
                            <i class="fas fa-eye mr-1"></i>Subsecciones
                        </button>
                        <div id="dataOpcionesSubseccionestoggle" class="hidden absolute top-0  mt-10 w-auto bg-gray-800 shadow-md p-2 rounded-md divide-y divide-gray-700 text-gray-100 flex flex-col text-xs">
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
                        <h1>Correctivo</h1>
                    </div>
                    <div class="py-1 px-2 bg-gray-200 text-gray-900 hover:bg-red-200 hover:text-red-500 font-normal cursor-pointer">
                        <a href="graficas_reportes_diario/">
                            <h1>Reporte MC</h1>
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
                            <th class="px-4 py-2">Pendientes</th>
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
                <div id="dataExportarSeccionesUsuarios" class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
                    <?= $exportarSeccionUsuario; ?>
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
            <div class="p-2 flex flex-col justify-center items-center flex-col w-full pb-6">
                <div id="dataModalOpciones" class="divide-y divide-gray-200 w-full px-1 font-medium text-sm text-gray-500 overflow-y-auto scrollbar" style="max-height: 80vh;">
                    <?= $exportarSubseccion; ?>
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


        function pendientesSubseccion(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino) {
            console.log(idSeccion, tipoPendiente, nombreSeccion, idUsuario, idDestino);
            if (tipoPendiente != "") {
                // idSeccion = 1 & idDestino = 1 & tipoPendiente = MCS & idUsuario = 1#
                page = 'modalPendientes.php?idSeccion=' + idSeccion + '&tipoPendiente=' + tipoPendiente + '&idUsuario=' +
                    idUsuario + '&idDestino=' + idDestino;
                window.location = page;
            }
        }

        function exportarPendientes(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar) {
            console.log(idUsuario, idDestino, idSeccion, idSubseccion, tipoExportar);
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
                // dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    let usuarioSession = localStorage.getItem('usuario');

                    if (tipoExportar == "exportarMisPendientes") {
                        page = 'php/generarPendientesExcel.php?listaIdMC=' + data;
                        window.location = page;
                    } else if (tipoExportar == "exportarSeccion") {
                        page = 'php/generarPendientesExcel.php?listaIdMC=' + data;
                        window.location = page;
                    } else if (tipoExportar == "exportarSubseccion") {
                        page = 'php/generarPendientesExcel.php?listaIdMC=' + data;
                        window.location = page;
                    } else if (tipoExportar == "exportarSeccionUsuario") {
                        page = 'php/generarPendientesExcel.php?listaIdMC=' + data;
                        window.location = page;
                    } else if (tipoExportar == "exportarMisPendientesPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdMC=' + data + '&idDestino=' + idDestino +
                            '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Pendientes PDF",
                            "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    } else if (tipoExportar == "exportarSeccionUsuarioPDF") {
                        page = 'php/generarPendientesPDF.php?listaIdMC=' + data + '&idDestino=' + idDestino +
                            '&idUsuario=' + idUsuario + '&idSeccion=' + idSeccion + '&usuarioSession=' +
                            usuarioSession;
                        window.open(page, "Reporte Pendientes PDF",
                            "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no, width=800, height=800"
                        );
                    }
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
    </script>

</body>

</html>