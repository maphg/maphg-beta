<?php
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

include 'conexion.php';

$fecha = date('Y-m-d H:m:s');
$data = "";
$nombreDestino = "NA";
$nombreCompleto = "NA";
$totalResultados = 0;

if (isset($_GET['listaIdF'])) {
    $listaIdF = $_GET['listaIdF'];
    $listaIdT = $_GET['listaIdT'];
    $idDestino = $_GET['idDestino'];
    $idUsuario = $_GET['idUsuario'];
    $idSeccion = $_GET['idSeccion'];
    $usuarioSession = $_GET['usuarioSession'];

    // Busca el destino.
    $queryDestino = "SELECT destino FROM c_destinos WHERE id = $idDestino";
    if ($resultDestino = mysqli_query($conn_2020, $queryDestino)) {
        foreach ($resultDestino as $destino) {
            $nombreDestino = $destino['destino'];
        }
    } else {
        $nombreDestino = "NA";
    }

    // Busca la seccion
    $querySeccion = "SELECT seccion FROM c_secciones WHERE id = $idSeccion";
    if ($resultSeccion = mysqli_query($conn_2020, $querySeccion)) {
        foreach ($resultSeccion as $s) {
            $seccion = $s['seccion'];
        }
    } else {
        $seccion = "ND";
    }

    // Busca el Usuario que creo el reporte.
    $queryUsuario = "SELECT t_colaboradores.nombre, t_colaboradores.apellido
    FROM t_users 
    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
    WHERE t_users.id = $usuarioSession LIMIT 1";
    if ($resulUsuario = mysqli_query($conn_2020, $queryUsuario)) {
        foreach ($resulUsuario as $usuario) {
            $nombreCompleto = $usuario['nombre'] . " " . $usuario['apellido'];
        }
    } else {
        $nombreCompleto = "NA";
    }

    if ($listaIdF != "") {
        $filtroF = "AND t_mc.id IN($listaIdF)";
    } else {
        $filtroF = "AND t_mc.id IN(0)";
    }

    if ($listaIdT != "") {
        $filtroT = "AND t_mp_np.id IN($listaIdT)";
    } else {
        $filtroT = "AND t_mp_np.id IN(0)";
    }


    //Fallas
    $query = "SELECT t_mc.id, t_mc.status_material, t_mc.codsap, t_mc.cod2bend, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, t_equipos_america.equipo, t_mc.actividad, t_mc.tipo_incidencia, t_colaboradores.nombre, t_colaboradores.apellido, t_mc.fecha_creacion 
    FROM t_mc 
    INNER JOIN c_destinos ON t_mc.id_destino = c_destinos.id 
    INNER JOIN c_secciones ON t_mc.id_seccion = c_secciones.id 
    INNER JOIN c_subsecciones ON t_mc.id_subseccion = c_subsecciones.id 
    INNER JOIN t_equipos_america ON t_mc.id_equipo = t_equipos_america.id 
    LEFT JOIN t_users ON t_mc.responsable = t_users.id 
    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
    WHERE t_mc.activo = 1 $filtroF;
    ";

    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $row) {
            $totalResultados++;
            $idMC = $row['id'];
            $destino = $row['destino'];
            $seccion = $row['seccion'];
            $subseccion = $row['grupo'];
            $equipo = $row['equipo'];
            $actividad = $row['actividad'];
            $responsable = $row['nombre'] . " " . $row['apellido'];
            $fecha = $row['fecha_creacion'];
            $materialF = $row['status_material'];
            $codsapF = $row['codsap'];
            $cod2bendF = $row['cod2bend'];
            $tipoIncidenciaF = $row['tipo_incidencia'];

            if ($materialF != 0) {
                $codsapF = "<h1 class=\"\">CODSAP: <span class=\"font-bold\">$codsapF</span>";
                $cod2bendF = "<h1 class=\"\">COD2BEND: <span class=\"font-bold\">$cod2bend</span>";
            } else {
                $codsapF = "";
                $cod2bendF = "";
            }

            if ($fecha != "") {
                $fecha = (new DateTime($fecha))->format('d-m-Y');
            } else {
                $fecha = "";
            }

            $queryComentario = "SELECT t_mc_comentarios.comentario, t_colaboradores.nombre, t_colaboradores.apellido
            FROM t_mc_comentarios 
            LEFT JOIN t_users ON t_mc_comentarios.id_usuario = t_users.id
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE t_mc_comentarios.id_mc = $idMC 
            ORDER BY t_mc_comentarios.fecha DESC LIMIT 1";

            $resultComentario = mysqli_query($conn_2020, $queryComentario);
            if ($rowComentario = mysqli_fetch_array($resultComentario)) {
                $comentario = $rowComentario['comentario'];
                $realizoComentario = $rowComentario['nombre'] . " " . $rowComentario['apellido'];
            } else {
                $realizoComentario = "";
                $comentario = "";
            }

            if ($equipo == "") {
                $equipo = "Fallas Generales";
            }

            if ($responsable == "") {
                $responsable = "Sin Responsable";
            }

            $data .= "
                <div
                    class=\"w-full border-t-2 border-b-8 border-r-2 rounded-r-md h-10 rounded-l-md flex flex-row items-center justify-start border-l-2 border-gray-300 mb-2\">
                    <div class=\"flex flex-col items-start justify-center leading-none font-bold uppercase w-full\">
                        <div class=\"ml-4 mt-2 text-base truncate\">
                            <h1>$actividad</h1>
                        </div>
                        <div
                            class=\"flex flex-row items-center justify-evenly w-full text-xs font-semibold flex-wrap py-1 bg-gray-300 text-gray-800\">
                            <h1>Tipo Incidencia: <span class=\"font-bold\">$tipoIncidenciaF</span></h1>
                            <h1>ID: <span class=\"font-bold\">$idMC</span></h1>
                            <h1>Creado el: <span class=\"font-bold\">$fecha</span></h1>
                            <h1>Subsección: <span class=\"font-bold\">$subseccion</span></h1>
                            <h1 class=\"font-bold\">$equipo</h1>
                            <h1 class=\"\">Responsable: <span class=\"font-bold\">$responsable</span>
                            $codsapF
                            $cod2bendF
                            </h1>
                        </div>
                    </div>
                </div>
            ";
        }
    }

    //Tareas
    $query = "SELECT t_mp_np.id, t_mp_np.status_material, t_mp_np.codsap, t_mp_np.cod2bend, c_destinos.destino, c_secciones.seccion, c_subsecciones.grupo, t_mp_np.titulo, t_mp_np.tipo_incidencia, t_colaboradores.nombre, t_colaboradores.apellido, t_mp_np.fecha 
    FROM t_mp_np 
    INNER JOIN c_destinos ON t_mp_np.id_destino = c_destinos.id 
    INNER JOIN c_secciones ON t_mp_np.id_seccion = c_secciones.id 
    INNER JOIN c_subsecciones ON t_mp_np.id_subseccion = c_subsecciones.id 
    LEFT JOIN t_users ON t_mp_np.responsable = t_users.id 
    INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
    WHERE t_mp_np.activo = 1 $filtroT;
    ";

    if ($result = mysqli_query($conn_2020, $query)) {
        foreach ($result as $row) {
            $totalResultados++;
            $idT = $row['id'];
            $destino = $row['destino'];
            $seccion = $row['seccion'];
            $subseccion = $row['grupo'];
            $equipo = "Incidencia General";
            $actividad = $row['titulo'];
            $responsable = $row['nombre'] . " " . $row['apellido'];
            $fecha = $row['fecha'];
            $materialT = $row['status_material'];
            $codsapT = $row['codsap'];
            $cod2bendT = $row['cod2bend'];
            $tipoIncidenciaT = $row['tipo_incidencia'];

            if ($materialT != 0) {
                $codsapT = "<h1 class=\"\">CODSAP: <span class=\"font-bold\">$codsapT</span>";
                $cod2bendT = "<h1 class=\"\">COD2BEND: <span class=\"font-bold\">$cod2bendT</span>";
            } else {
                $codsapT = "";
                $cod2bendT = "";
            }

            if ($fecha != "") {
                $fecha = (new DateTime($fecha))->format('d-m-Y');
            } else {
                $fecha = "";
            }

            $queryComentario = "SELECT comentarios_mp_np.comentario, t_colaboradores.nombre, t_colaboradores.apellido
            FROM comentarios_mp_np 
            LEFT JOIN t_users ON comentarios_mp_np.id_usuario = t_users.id
            LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            WHERE comentarios_mp_np.id_mp_np = $idT 
            ORDER BY comentarios_mp_np.fecha DESC LIMIT 1";

            $resultComentario = mysqli_query($conn_2020, $queryComentario);
            if ($rowComentario = mysqli_fetch_array($resultComentario)) {
                $comentario = $rowComentario['comentario'];
                $realizoComentario = $rowComentario['nombre'] . " " . $rowComentario['apellido'];
            } else {
                $realizoComentario = "";
                $comentario = "";
            }

            if ($equipo == "") {
                $equipo = "Incidencias Generales";
            }

            if ($responsable == "") {
                $responsable = "Sin Responsable";
            }

            $data .= "
                <div
                    class=\"w-full border-t-2 border-b-8 border-r-2 rounded-r-md h-10 rounded-l-md flex flex-row items-center justify-start border-l-2 border-gray-300 mb-2\">
                    <div class=\"flex flex-col items-start justify-center leading-none font-bold uppercase w-full\">
                        <div class=\"ml-4 mt-2 text-base truncate\">
                            <h1>Tarea: $actividad</h1>
                        </div>
                        <div
                            class=\"flex flex-row items-center justify-evenly w-full text-xs font-semibold flex-wrap py-1 bg-gray-300 text-gray-800\">
                            <h1>Tipo Incidencia: <span class=\"font-bold\">$tipoIncidenciaT</span></h1>
                            <h1>ID: <span class=\"font-bold\">$idT</span></h1>
                            <h1>Creado el: <span class=\"font-bold\">$fecha</span></h1>
                            <h1>Subsección: <span class=\"font-bold\">$subseccion</span></h1>
                            <h1 class=\"font-bold\">$equipo</h1>
                            <h1 class=\"\">Responsable: 
                                <span class=\"font-bold\">$responsable</span>
                            </h1>
                            $codsapT
                            $cod2bendT
                        </div>
                    </div>
                </div>
            ";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="Es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAPHG</title>
    <link rel="stylesheet" href="../css/tailwindproduccion.css">
    <link rel="shortcut icon" href="../svg/logo6.png" type="image/x-icon">
</head>

<body class="flex flex-col justify-start items-start h-auto bg-gray-900">

    <div id="33">
        <div class="flex flex-col items-start justify-start bg-white pt-4 px-4 overflow-hidden mt-1 relative" style="width: 1223px; min-height: 1576px;">

            <div class="w-12 flex items-center justify-center absolute w-full h-full">
                <div class="p-20">
                    <img src="../svg/marcadeagua9.png" alt="">
                </div>
            </div>

            <div class="flex flex-col justify-center items-center w-full">

                <div class="flex flex-row justify-evenly items-center w-full">

                    <div class="w-12 flex items-center justify-center">
                        <img src="../svg/logo2.png" alt="">
                    </div>

                    <div class="<?= strtolower($seccion); ?>-logo relative">
                        <h1 class=""><?= $seccion; ?></h1>
                        <div class="font-semibold text-xs px-1 rounded bg-red-300 text-red-600 absolute" style="bottom: -20%; right: -30%;">
                            <h1 class="font-bold"><?= $nombreDestino; ?></h1>
                        </div>
                    </div>

                    <div class="ml-2 font-light text-4xl flex flex-col leading-none">
                        <div>
                            <h1 class="">INCIDENCIAS PENDIENTES</h1>
                        </div>
                        <div class="flex flex-col ml-2 font-light text-base  justify-center items-center">
                            <h1 class="mt-1">Total: <span class="font-bold"><?= $totalResultados; ?></span></h1>
                        </div>
                    </div>

                    <div class="flex flex-col ml-2 font-semibold text-sm leading-none justify-center items-center">
                        <h1>Generado por: <span class="font-bold"><?= $nombreCompleto; ?></span></h1>
                        <h1 class="mt-1"><?= date('d-m-Y H:m:s'); ?></h1>
                    </div>
                    <div class="w-20 h-10 relative flex justify-center items-center">
                        <div class="w-24 mt-1 absolute">
                            <img class=" " src="../svg/qr.png" alt="">
                        </div>
                    </div>

                </div>

                <div class="flex flex-col items-center justify-center w-full mt-6">
                    <?= $data; ?>
                </div>

            </div>
        </div>

    </div>

    <div class="absolute top-0 left-0 w-full bg-black opacity-75 h-screen flex items-center justify-center" id="boton">
        <button onclick="screenShot()" class="py-3 px-4 bg-teal-200 text-teal-500 text-2xl rounded-md">
            <i class="fas fa-download mr-2 fa-lg"></i>Descargar PDF
        </button>
    </div>
    <script src="../js/html2canvas.js"></script>
    <script src="../js/exportarPdf.js"></script>
</body>

</html>