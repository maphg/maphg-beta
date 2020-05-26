<?php

session_start();
include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "equipos") {
        $obj = new Config();
        $resp = $obj->equipos();
        echo $resp;
    }
}

Class Config {

    public function equipos() {
        $conn = new Conexion();
        $conn->conectar();
        $idDestino = $_SESSION['idDestino'];
        $query = "SELECT * FROM c_destinos WHERE id = $idDestino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $bandera = $dts['bandera'];
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $salida = "<div class=\"columns is-centered px-3 mt-1\">"
                . "<div class=\"column is-one-fifth\">"
                . "<div class=\"control has-icons-left has-text-centered\">"
                . "<div class=\"select is-medium is-fullwidth\">"
                . "<select id=\"cbDestinos\" onchange=\"cargarTareasDestino();\">";
        $query = "SELECT * FROM c_destinos ORDER BY destino";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idDest = $dts['id'];
                    $nombreDest = $dts['destino'];
                    if ($idDest == $idDestino) {
                        $salida .= "<option value=\"$idDest\" selected>$nombreDest</option>";
                    } else {
                        $salida .= "<option value=\"$idDest\">$nombreDest</option>";
                    }
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }
        $salida .= "</select>"
                . "<span class=\"icon is-small is-left  has-text-info\">"
                . "<img src=\"svg/banderas/$bandera\" width=\"20px\" alt=\"\">"
                . "</span>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "</div>"
                . "<div class=\"columns\">"
                . "<div class=\"column\">"
                . "<button class=\"button is-primary is-small\" onclick=\"showModal('modal-agregar-equipo');\">"
                . "<span class=\"icon is-small\">"
                . "<i class=\"fas fa-plus\"></i>"
                . "</span>"
                . "<span>Agregar equipo</span>"
                . "</button>"
                . "</div>"
                . "</div>";


        if ($idDestino == 10) {
            $query = "SELECT * FROM t_equipos ORDER BY id_destino";
        } else {
            $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino ORDER BY id_seccion";
        }

        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                $salida .= "<div class=\"columns mt-3\">"
                        . "<div class=\"column\">"
                        . "<div class=\"table-container\">"
                        . "<table id=\"tablaEquipos\" class=\"table is-fullwidth is-hoverable is-bordered is-size-7\">"
                        . "<thead>"
                        . "<tr>"
                        . "<th>Destino</th>"
                        . "<th>Seccion</th>"
                        . "<th>Subseccion</th>"
                        . "<th>Equipo</th>"
                        . "</tr>"
                        . "</thead>"
                        . "<tfoot>"
                        . "<tr>"
                        . "<th>Destino</th>"
                        . "<th>Seccion</th>"
                        . "<th>Subseccion</th>"
                        . "<th>Equipo</th>"
                        . "</tr>"
                        . "</tfoot>"
                        . "<tbody>";
                foreach ($resp as $dts) {
                    $idEquipo = $dts['id'];
                    $idDestinoEquipo = $dts['id_destino'];
                    $idSeccionEquipo = $dts['id_seccion'];
                    $idSubseccionEquipo = $dts['id_subseccion'];
                    $equipo = $dts['equipo'];

                    $query = "SELECT * FROM c_destinos WHERE id = $idDestinoEquipo";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreDestEquipo = $dts['destino'];
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }
                    
                    $query = "SELECT * FROM c_secciones WHERE id = $idSeccionEquipo";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreSeccionEquipo = $dts['seccion'];
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }
                    
                    $query = "SELECT * FROM c_subsecciones WHERE id = $idSubseccionEquipo";
                    try {
                        $resp = $conn->obtDatos($query);
                        if ($conn->filasConsultadas > 0) {
                            foreach ($resp as $dts) {
                                $nombreSubseccionEquipo = $dts['grupo'];
                            }
                        }
                    } catch (Exception $ex) {
                        $salida = $ex;
                        exit($ex);
                    }

                    $salida .= "<tr>"
                            . "<td>$nombreDestEquipo</td>"
                            . "<td>$nombreSeccionEquipo</td>"
                            . "<td>$nombreSubseccionEquipo</td>"
                            . "<td>$equipo</td>"
                            . "</tr>";
                }
                $salida .= "</tbody>"
                        . "</table>"
                        . "</div>"
                        . "</div>"
                        . "</div>";
            } else {
                $salida .= "<p>SIN RESULTADOS</p>";
            }
        } catch (Exception $ex) {
            $salida = $ex;
            exit($ex);
        }


        $conn->cerrar();
        return $salida;
    }

}

?>