<?php
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
        WHERE c_rel_destino_seccion.id_destino=1";
        $result = mysqli_query($conn_2020, $query);
        if ($result) {
            if ($row = mysqli_fetch_array($result)) {
                $seccion = $row['seccion'];
                $subseccion = $row['grupo'];

                if ($seccion = "ZIC") {
                    $dataZIC .= $subseccion;
                }
            }
        } else {
            $error = "Proceso Finalizado";
        }
        $data['ZIC'] = $dataZIC;
        echo json_encode($data);
    }
}