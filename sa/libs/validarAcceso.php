<?php

include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "validarAccesoEntradas") {
        $codigoSA = $_POST['codigoSA'];
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT * FROM t_colaboradores WHERE codigo_sa = '$codigoSA'";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $nombre = $dts['nombre'];
                    $apellido = $dts['apellido'];
                    $permiso = $dts['id_permiso'];
                }
                $resp = $permiso;
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }
        
        echo $resp;
    }
}
?>