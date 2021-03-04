<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');
// Modulo para importar la Conxión a la DB.
include 'conexion.php';

if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $semanaActual = date('W');
    $array = array();

    #OBTIENE ENLACES DEL MENU
    if ($action == "obtenerMenu") {

        // PRINCIPAL
        $query = "SELECT id, id_padre, nivel, titulo, link, icono FROM t_menu 
        WHERE activo = 1 and id_permiso = 0 and id_padre = 0 and jerarquia = 'UNO' 
        ORDER BY nivel ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idOpcion = $x['id'];
                $idPadreX = $x['id'];
                $nivel = $x['nivel'];
                $titulo = $x['titulo'];
                $link = $x['link'];
                $icono = $x['icono'];

                $array2 = array();
                $query = "SELECT id, id_padre, nivel, titulo, link, icono FROM t_menu 
                WHERE activo = 1 and id_permiso = 0 and id_padre = $idPadreX and jerarquia = 'DOS' 
                ORDER BY id ASC";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idOpcion2 = $x['id'];
                        $idPadreY = $x['id'];
                        $nivel2 = $x['nivel'];
                        $titulo2 = $x['titulo'];
                        $link2 = $x['link'];
                        $icono2 = $x['icono'];

                        $array3 = array();
                        $query = "SELECT id, id_padre, nivel, titulo, link, icono FROM t_menu 
                        WHERE activo = 1 and id_permiso = 0 and id_padre = $idPadreY and jerarquia = 'TRES' 
                        ORDER BY nivel ASC";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            foreach ($result as $x) {
                                $idOpcion3 = $x['id'];
                                $idPadreZ = $x['id'];
                                $nivel3 = $x['nivel'];
                                $titulo3 = $x['titulo'];
                                $link3 = $x['link'];
                                $icono3 = $x['icono'];

                                $array3[] = array(
                                    "idOpcion" => intval($idOpcion),
                                    "idPadre" => intval($idPadreZ),
                                    "nivel" => $nivel3,
                                    "titulo" => $titulo3,
                                    "link" => $link3,
                                    "icono" => $icono3
                                );
                            }
                        }

                        $array2[] = array(
                            "idOpcion" => intval($idOpcion2),
                            "idPadre" => intval($idPadreY),
                            "nivel" => $nivel2,
                            "titulo" => $titulo2,
                            "link" => $link2,
                            "icono" => $icono2,
                            "menu3" => $array3

                        );
                    }
                }

                $array[] = array(
                    "idOpcion" => intval($idOpcion),
                    "idPadre" => intval($idPadreX),
                    "nivel" => $nivel,
                    "titulo" => $titulo,
                    "link" => $link,
                    "icono" => $icono,
                    "menu2" => $array2
                );
            }
        }
        echo json_encode($array);
    }


    #OBTIENE DATOS DEL CALENDARIO
    if ($action == "obtenerDatosCalendario") {
        $query = "SELECT id, destino FROM c_destinos WHERE id  = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestino = $x['id'];
                $destino = $x['destino'];

                $array = array(
                    "idDestino" => intval($idDestino),
                    "destino" => $destino
                );
            }
        }
        echo json_encode($array);
    }


    # OBTIENE LOS DESTINOS QUE TIENE ACCESO EL USUARIO
    if ($action == "obtenerDestinosUsuario") {
        $array = array();

        $idDestinoX = 0;
        $query = "SELECT id_destino FROM t_users WHERE id = $idUsuario";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoX = $x['id_destino'];
            }
        }

        if ($idDestinoX == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id = $idDestinoX";
        }

        $query = "SELECT id, destino, ubicacion FROM c_destinos WHERE status = 'A' $filtroDestino 
        ORDER BY id ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestinoY = $x['id'];
                $destino = $x['destino'];
                $ubicacion = $x['ubicacion'];

                $array[] = array(
                    "idDestinoX" => intval($idDestinoY),
                    "destino" => $destino,
                    "ubicacion" => $ubicacion
                );
            }
        }
        echo json_encode($array);
    }


    #OBTIENE INFORMACIÓN DE USUARIO
    if ($action == "obtenerInformacionUsuario") {
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id_destino = $idDestino";
        }

        $incidencias = 0;
        $query = "SELECT count(id) 'total' 
        FROM t_mc 
        WHERE activo = 1 and status IN('PENDIENTE', 'N', 'P') and responsable IN($idUsuario) $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $incidencias += $x['total'];
            }
        }

        $query = "SELECT count(id) 'total'
        FROM t_mp_np
        WHERE activo = 1 and status IN('PENDIENTE', 'N', 'P') and responsable IN($idUsuario) $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $incidencias += $x['total'];
            }
        }

        $destino = "ND";
        $query = "SELECT destino FROM c_destinos WHERE id = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $destino = $x['destino'];
            }
        }

        $query = "SELECT t_users.id, c_cargos.cargo, t_colaboradores.nombre, t_colaboradores.apellido, 
        t_colaboradores.foto
        FROM t_users
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN c_cargos ON t_colaboradores.id_cargo = c_cargos.id
        WHERE t_users.id = $idUsuario";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idUsuarioX = $x['id'];
                $nombre = $x['nombre'];
                $apellido = $x['apellido'];
                $cargo = $x['cargo'];
                $avatar = $x['foto'];

                if ($avatar == "") {
                    $avatar = "AVATAR_ID_0_0.svg";
                }

                $array = array(
                    "idUsuario" => intval($idUsuarioX),
                    "nombre" => $nombre,
                    "apellido" => $apellido,
                    "cargo" => $cargo,
                    "avatar" => $avatar,
                    "destino" => $destino,
                    "incidencias" => $incidencias
                );
            }
        }
        echo json_encode($array);
    }


    #ACTUALIZA AVATAR
    if ($action == "subirAvatarUsuario") {
        $resp = 0;

        $rutaTemporal = $_FILES["file"]["tmp_name"];
        $nombreTemporal = $_FILES["file"]["name"];
        $extension = pathinfo($nombreTemporal, PATHINFO_EXTENSION);
        $url = "AVATAR_ID_$idUsuario" . "_" . rand(0, 1000) . ".$extension";

        if (move_uploaded_file($rutaTemporal, "../planner/avatars/" . $url)) {
            $query = "UPDATE t_users 
            INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
            SET t_colaboradores.foto ='$url' WHERE t_users.id = $idUsuario and t_users.activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }


    if ($action == "comprobarCodigoTelegram") {
        $chatID = $_GET['chatID'];
        $resp = 0;
        $url = "";

        $query = "SELECT url FROM t_enlaces WHERE tipo_enlace = 'BOTMAPHG' and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $url = $x['url'];
            }
        }

        $apiTelegram = "https://api.telegram.org/bot$url/sendMessage?chat_id=$chatID" . "&text=Vinculación Exitosa!";
        if (file_get_contents($apiTelegram)) {
            $query = "UPDATE t_users SET telegram_chat_id = '$chatID' WHERE id = $idUsuario";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp = 1;
            }
        }
        echo json_encode($resp);
    }

    
    #OBTIENE ENLACES DE LAS CARPETAS DE LOS INVENTARIOS DE SUBALMACENES
    if ($action == "abrirEnlace") {
        $tipoEnlace = $_GET['tipoEnlace'];

        $array = array();

        $query = "SELECT url FROM t_enlaces WHERE id_destino = $idDestino and tipo_enlace = '$tipoEnlace'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $url = $x['url'];

                $array = array(
                    "url" => $url
                );
            }
        }
        echo json_encode($array);
    }
}
