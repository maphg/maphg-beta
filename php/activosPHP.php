<?php

include 'conexion.php';
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action == "obtActivoXPagina") {
        $pagina = $_POST['pagina'];
        $obj = new Activos();
        $resp = $obj->obtActivoXPagina($pagina);
        echo $resp;
    }
    
    if($action == "busqueda"){
        $busqueda = $_POST['busqueda'];
        $pagina = $_POST['pagina'];
        $obj = new Activos();
        $resp = $obj->obtActivoXBusqueda($busqueda, $pagina);
        echo $resp;
    }
}

Class Activos {

    public function obtActivoXPagina($pagina) {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "<div class=\"columns is-gapless my-1 is-mobile\">
                <div class=\"column\">
                    <div class=\"columns is-gapless\">
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Naturaleza</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">SubFam 2bend</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">MaTerial</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Texto breve</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Unidad</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Subfamilia</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Activo/No Activo</p></div>
                    </div>
                </div>
            </div>";

        $query = "SELECT * FROM t_activos";
        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 50;
        } catch (Exception $ex) {
            $salida = $ex;
        }
        

        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        $query = "SELECT * FROM t_activos "
                . "LIMIT $desde, $porPagina";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $id = $dts['id'];
                    $naturaleza = $dts['naturaleza'];
                    $subfamilia2Bend = $dts['subfamilia2bend'];
                    $cod2bend = $dts['material_cod2bend'];
                    $texto = $dts['texto_breve'];
                    $unidad = $dts['unidad'];
                    $subfamilia = $dts['subfamilia'];
                    $activo = $dts['activo'];


                    $salida .= "<div class=\"columns is-gapless my-1 is-mobile\">"
                            . "<div class=\"column\">"
                            . "<div class=\"columns is-gapless\">"
                            . "<div class=\"column\"><p class=\"t-normal\">$naturaleza</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$subfamilia2Bend</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$cod2bend</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal text-truncate\">$texto</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$unidad</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$subfamilia</p></div>";
                    if ($activo == "ACTIVO") {
                        $salida .= "<div class=\"column\"><p class=\"t-solucionado\"><span></span>$activo</p></div>";
                    } else {
                        $salida .= "<div class=\"column\"><p class=\"t-proceso\"><span></span>$activo</p></div>";
                    }

                    $salida .= "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "<div class=\"columns is-centered\">"
                . "<div class=\"column is-8\">"
                . "<nav class=\"pagination is-centered\" role=\"navigation\" aria-label=\"pagination\">";

        if ($pagina != 1) {

            $salida .= "<a class=\"pagination-previous\" onclick=\"obtActivoXPagina(1);\" href=\"#\">Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" onclick=\"obtActivoXPagina(" . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {

            $salida .= "<a class=\"pagination-next\" onclick=\"obtActivoXPagina(" . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>";
            $salida .= " <a class=\"pagination-next\" onclick=\"obtActivoXPagina(" . $totalPaginas . ");\" href=\"#\">Fin</a>";
        } else {

            $salida .= "<a class=\"pagination-next\" href=\"#\" disabled>Siguiente</a>";
            $salida .= " <a class=\"pagination-next\" href=\"#\" disabled>Fin</a>";
        }

        $salida .= "<ul class=\"pagination-list\">";
        $rango = 2;
        $desde = $pagina - $rango;
        $hasta = $pagina + $rango;
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == 1 || $i == $totalPaginas || $i >= $desde && $i <= $hasta) {
                if ($i == $pagina) {

                    if (($pagina - 1) == 0) {
                        $salida .= "<li class=\"pagination-link is-current\">1</li>";
                    } elseif (($pagina - 1) == 1) {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina(" . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina(1);\" href=\"#\">1</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina(" . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                        
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina(" . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoXPagina($totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
                    }
                }
            }
        }


        $salida .= "</ul>"
                . "</nav>"
                . "</div>"
                . "</div>";
        
        $conn->cerrar();
        return $salida;
    }
    
    public function obtActivoXBusqueda($busqueda, $pagina) {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "<div class=\"columns is-gapless my-1 is-mobile\">
                <div class=\"column\">
                    <div class=\"columns is-gapless\">
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Naturaleza</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">SubFam 2bend</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">MaTerial</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Texto breve</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Unidad</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Subfamilia</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Activo/No Activo</p></div>
                    </div>
                </div>
            </div>";

        $query = "SELECT * FROM t_activos "
                . "WHERE material_cod2bend LIKE '%$busqueda%' "
                . "OR texto_breve LIKE '%$busqueda%' "
                . "OR subfamilia LIKE '%$busqueda%' "
                . "OR activo LIKE '$busqueda%' ";
        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 50;
        } catch (Exception $ex) {
            $salida = $ex;
        }
        

        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        $query = "SELECT * FROM t_activos "
                . "WHERE material_cod2bend LIKE '%$busqueda%' "
                . "OR texto_breve LIKE '%$busqueda%' "
                . "OR subfamilia LIKE '%$busqueda%' "
                . "OR activo LIKE '$busqueda%' "
                . "LIMIT $desde, $porPagina";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $id = $dts['id'];
                    $naturaleza = $dts['naturaleza'];
                    $subfamilia2Bend = $dts['subfamilia2bend'];
                    $cod2bend = $dts['material_cod2bend'];
                    $texto = $dts['texto_breve'];
                    $unidad = $dts['unidad'];
                    $subfamilia = $dts['subfamilia'];
                    $activo = $dts['activo'];


                    $salida .= "<div class=\"columns is-gapless my-1 is-mobile\">"
                            . "<div class=\"column\">"
                            . "<div class=\"columns is-gapless\">"
                            . "<div class=\"column\"><p class=\"t-normal\">$naturaleza</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$subfamilia2Bend</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$cod2bend</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal text-truncate\">$texto</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$unidad</p></div>"
                            . "<div class=\"column\"><p class=\"t-normal\">$subfamilia</p></div>";
                    if ($activo == "ACTIVO") {
                        $salida .= "<div class=\"column\"><p class=\"t-solucionado\"><span></span>$activo</p></div>";
                    } else {
                        $salida .= "<div class=\"column\"><p class=\"t-proceso\"><span></span>$activo</p></div>";
                    }

                    $salida .= "</div>"
                            . "</div>"
                            . "</div>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $salida .= "<div class=\"columns is-centered\">"
                . "<div class=\"column is-8\">"
                . "<nav class=\"pagination is-centered\" role=\"navigation\" aria-label=\"pagination\">";

        if ($pagina != 1) {

            $salida .= "<a class=\"pagination-previous\" onclick=\"obtActivoXBusquedaXPagina(1);\" href=\"#\">Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" onclick=\"obtActivoXBusquedaXPagina(" . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {

            $salida .= "<a class=\"pagination-next\" onclick=\"obtActivoXBusquedaXPagina(" . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>";
            $salida .= " <a class=\"pagination-next\" onclick=\"obtActivoXBusquedaXPagina(" . $totalPaginas . ");\" href=\"#\">Fin</a>";
        } else {

            $salida .= "<a class=\"pagination-next\" href=\"#\" disabled>Siguiente</a>";
            $salida .= " <a class=\"pagination-next\" href=\"#\" disabled>Fin</a>";
        }

        $salida .= "<ul class=\"pagination-list\">";
        $rango = 2;
        $desde = $pagina - $rango;
        $hasta = $pagina + $rango;
        for ($i = 1; $i <= $totalPaginas; $i++) {
            if ($i == 1 || $i == $totalPaginas || $i >= $desde && $i <= $hasta) {
                if ($i == $pagina) {

                    if (($pagina - 1) == 0) {
                        $salida .= "<li class=\"pagination-link is-current\">1</li>";
                    } elseif (($pagina - 1) == 1) {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoXBusquedaXPagina(" . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoobtActivoXBusquedaXPaginaXPagina(1);\" href=\"#\">1</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoXBusquedaXPagina(" . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                        
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtActivoXBusquedaXPagina(" . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtAobtActivoXBusquedaXPaginactivoXPagina($totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
                    }
                }
            }
        }


        $salida .= "</ul>"
                . "</nav>"
                . "</div>"
                . "</div>";
        
        $conn->cerrar();
        return $salida;
    }

}

?>