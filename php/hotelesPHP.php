<?php

include 'conexion.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == "obtHoteles") {
        $idDestino = $_POST['idDestino'];
        $idSubseccion = $_POST['idSubseccion'];
        $pagina = $_POST['pagina'];
        $obj = new Hoteles();
        $resp = $obj->obtenerHoteles($idDestino, $idSubseccion, $pagina);
        echo $resp;
    }
}

Class Hoteles {

    public function obtenerHoteles($idDestino, $idSubseccion, $pagina) {
        $conn = new Conexion();
        $conn->conectar();

        $query = "SELECT c_subsecciones.id_seccion 'IDSECCION', "
                . "c_subsecciones.grupo 'SUBSECCION', "
                . "c_secciones.seccion 'SECCION' "
                . "FROM c_subsecciones "
                . "INNER JOIN c_secciones ON c_secciones.id = c_subsecciones.id_seccion "
                . "WHERE c_subsecciones.id = $idSubseccion";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        
        $query = "SELECT * FROM c_destinos WHERE id = $idDestino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $destino = $dts['destino'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }

        $salida = "<div id=\"hoteles\" class=\"columns is-multiline is-mobile is-centered mt-1\">";
        $query = "SELECT * FROM c_hoteles WHERE id_destino = $idDestino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $hotel = $dts['hotel'];
                    $query = "SELECT * "
                            . "FROM c_subcategorias_planner "
                            . "WHERE subcategoria "
                            . "LIKE '$hotel%'";
                    try {
                        $result = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($result as $d) {
                                $idSubcategoria = $d['id'];
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                    }
                    $salida .= "<div class=\"column hvr-grow\">"
                            . "<a href=\"#\" onclick=\"showHide('show'); obtenerEquipos($idSubseccion, $idDestino, 1, $idSubcategoria, 0, $pagina, '$destino', '$seccion', '$subseccion');\">"
                            . "<div class=\"card rounded-3\">"
                            . "<div class=\"card-content\">"
                            . "<div class=\"container\">"
                            . "<div class=\"columns is-centered\">"
                            . "<div class=\"column has-text-centered\">"
                            . "<h1 class=\"title is-size-6\">$hotel</h1>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
                            . "</a>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }
        $salida .= "</div>";
        $conn->cerrar();
        return $salida;
    }

}
