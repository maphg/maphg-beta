<?php
session_start();
// session_refresh_expire.php
include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    // Recupera la session desde localstorage.
    if ($action == "recuperarSession") {
        $idUsuario = $_POST['idUsuario'];
        $idDestino = $_POST['idDestino'];
        $superAdmin = $_POST['superAdmin'];
        if ($idUsuario != "" and $idDestino != "" and $superAdmin != "") {
            $_SESSION['usuario'] = $idUsuario;
            $_SESSION['idDestino'] = $idDestino;
            $_SESSION['super_admin'] = $superAdmin;
        }
        // echo $idUsuario . $idDestino . $superAdmin;
    }
}