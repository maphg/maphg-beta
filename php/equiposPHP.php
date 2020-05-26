<?php

include 'conexion.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    if ($action == "obtenerSubsecciones") {
        $idSeccion = $_POST['idSeccion'];
        $obj = new Equipos();
        $resp = $obj->obtenerSubsecciones($idSeccion);
        echo $resp;
    }

    if ($action == "agregarMP") {
        $idPlan = $_POST['idPlan'];
        $idEquipo = $_POST['idEquipo'];
        $semana = $_POST['semana'];
        $obj = new Equipos();
        $resp = $obj->agremarMP($idPlan, $idEquipo, $semana);
        echo $resp;
    }

    if ($action == "obtEquipoXPagina") {
        $pagina = $_POST['pagina'];
        $idDestino = $_POST['idDestino'];
        $obj = new Equipos();
        $resp = $obj->obtEquipoXPagina($idDestino, $pagina);
        echo $resp;
    }

    if ($action == "busqueda") {
        $idDestino = $_POST['idDestino'];
        $busqueda = $_POST['busqueda'];
        $pagina = $_POST['pagina'];
        $obj = new Equipos();
        $resp = $obj->obtEquipoXBusqueda($idDestino, $busqueda, $pagina);
        echo $resp;
    }

    if ($action == "filtrar") {
        $idDestino = $_POST['idDestino'];
        $seccion = $_POST['seccion'];
        $subseccion = $_POST['subseccion'];
        $pagina = $_POST['pagina'];
        $obj = new Equipos();
        $resp = $obj->obtEquipoXFiltro($idDestino, $seccion, $subseccion, $pagina);
        echo $resp;
    }
}

Class Equipos {

    public function obtenerSubsecciones($idSeccion) {
        $conn = new Conexion();
        $conn->conectar();
        $salida = "<option>Subseccion</option>";
        $query = "SELECT * FROM c_subsecciones WHERE id_seccion = $idSeccion ORDER BY grupo";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idSubseccion = $dts['id'];
                    $subseccion = $dts['grupo'];
                    $salida .= "<option value=\"$idSubseccion\">$subseccion</option>";
                }
            }
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $conn->cerrar();
        return $salida;
    }

    public function agremarMP($idPlan, $idEquipo, $semana) {
        $conn = new Conexion();
        $conn->conectar();
        session_start();
        $idDestino = $_SESSION['idDestino'];
        $idUsuario = $_SESSION['usuario'];
        date_default_timezone_set('America/Cancun');
        $hoy = date('Y-m-d H:i:s');
        $año = date('Y');
        //Obtener el numero de semanas que deben transcurrir para ejecutar el mp
        $query = "SELECT semanas, tipoplan FROM t_planes_mantto WHERE id = $idPlan";
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $tipoPlan = $dts['tipoplan'];
                    $semanas = $dts['semanas'];
                }
            }
        } catch (Exception $ex) {
            $resp = $ex;
        }

        while ($semana <= 52) {
            $query = "INSERT INTO t_mp_planeacion (id_destino, id_equipo, id_plan, semana, fecha_registro, creado_por, año, status, activo, tipoplan) "
                    . "VALUES($idDestino, $idEquipo, $idPlan, $semana, '$hoy', $idUsuario, '$año', 'N', 1, '$tipoPlan')";
            try {
                $resp = $conn->consulta($query);
            } catch (Exception $ex) {
                $resp = $ex;
                exit($ex);
            }
            $semana += $semanas;
        }


        $conn->cerrar();
        return $resp;
    }

    public function obtEquipoXPagina($idDestino, $pagina) {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "<div class=\"columns is-gapless my-1 is-mobile\">
                <div class=\"column\">
                    <div class=\"columns is-gapless\">
                        <div class=\"column is-4\"><p class=\"t-titulos has-background-dark has-text-white\">Equipo</p></div>
                        <div class=\"column is-1\"><p class=\"t-titulos has-background-dark has-text-white\">Destino</p></div>
                        <div class=\"column is-1\"><p class=\"t-titulos has-background-dark has-text-white\">Seccion</p></div>
                        <div class=\"column is-3\"><p class=\"t-titulos has-background-dark has-text-white\">Subseccion</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Opciones</p></div>
                    </div>
                </div>
            </div>";

        if ($idDestino == 10) {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.status = 'A'";
        } else {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.id_destino = $idDestino AND t_equipos.status = 'A'";
        }
        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 10;
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        if ($idDestino == 10) {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.status = 'A' "
                    . "ORDER BY t_equipos.id_destino "
                    . "LIMIT $desde, $porPagina ";
        } else {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.id_destino = $idDestino AND t_equipos.status = 'A' "
                    . "ORDER BY t_equipos.id_destino "
                    . "LIMIT $desde, $porPagina ";
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['ID'];
                    $equipo = $dts['EQUIPO'];
                    $destino = $dts['DESTINO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];


                    $salida .= "<div class=\"columns is-gapless my-1 is-mobile\">"
                            . "<div class=\"column\">"
                            . "<div class=\"columns is-gapless\">"
                            . "<div class=\"column is-4\"><p class=\"t-normal\">$equipo</p></div>"
                            . "<div class=\"column is-1\"><p class=\"t-normal\">$destino</p></div>"
                            . "<div class=\"column is-1\"><p class=\"t-normal\">$seccion</p></div>"
                            . "<div class=\"column is-3\"><p class=\"t-normal\">$subseccion</p></div>"
                            . "<div class=\"column t-normal\">"
                            . "<div class=\"field has-addons has-addons-centered\">"
                            . "<p class=\"control\">"
                            . "<button class=\"button is-info is-small\" onclick=\"showModal('modal-editar-equipo'); editarEquipo($idEquipo);\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-edit\"></i>"
                            . "</span>"
                            . "<span>Editar</span>"
                            . "</button>"
                            . "</p>"
                            . "<p class=\"control\">"
                            . "<button class=\"button is-danger is-small\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-trash\"></i>"
                            . "</span>"
                            . "<span>Eliminar</span>"
                            . "</button>"
                            . "</p>"
                            . "<p class=\"control\">"
                            . "<a href=\"equipos_mp.php?idEquipo=$idEquipo\" class=\"button is-primary is-small\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-wrench\"></i>"
                            . "</span>"
                            . "<span>MP</span>"
                            . "</a>"
                            . "</p>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
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

            $salida .= "<a class=\"pagination-previous\" onclick=\"obtEquipoXPagina($idDestino,1);\" href=\"#\">Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" onclick=\"obtEquipoXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {

            $salida .= "<a class=\"pagination-next\" onclick=\"obtEquipoXPagina($idDestino," . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>";
            $salida .= " <a class=\"pagination-next\" onclick=\"obtEquipoXPagina($idDestino," . $totalPaginas . ");\" href=\"#\">Fin</a>";
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
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestino,1);\" href=\"#\">1</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                        
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestino," . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXPagina($idDestino,$totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
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

    public function obtEquipoXBusqueda($idDestino, $busqueda, $pagina) {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "<div class=\"columns is-gapless my-1 is-mobile\">
                <div class=\"column\">
                    <div class=\"columns is-gapless\">
                        <div class=\"column is-4\"><p class=\"t-titulos has-background-dark has-text-white\">Equipo</p></div>
                        <div class=\"column is-1\"><p class=\"t-titulos has-background-dark has-text-white\">Destino</p></div>
                        <div class=\"column is-1\"><p class=\"t-titulos has-background-dark has-text-white\">Seccion</p></div>
                        <div class=\"column is-3\"><p class=\"t-titulos has-background-dark has-text-white\">Subseccion</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Opciones</p></div>
                    </div>
                </div>
            </div>";

        if ($idDestino == 10) {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.status = 'A' "
                    . "AND (t_equipos.id LIKE '%$busqueda%' "
                    . "OR t_equipos.equipo LIKE '%$busqueda%')";
        } else {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.id_destino = $idDestino AND t_equipos.status = 'A' "
                    . "AND (t_equipos.id LIKE '%$busqueda%' "
                    . "OR t_equipos.equipo LIKE '%$busqueda%')";
        }
        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 10;
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        if ($idDestino == 10) {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.status = 'A' "
                    . "AND (t_equipos.id LIKE '%$busqueda%' "
                    . "OR t_equipos.equipo LIKE '%$busqueda%')"
                    . "ORDER BY t_equipos.id_destino "
                    . "LIMIT $desde, $porPagina ";
        } else {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.id_destino = $idDestino AND t_equipos.status = 'A' "
                    . "AND (t_equipos.id LIKE '%$busqueda%' "
                    . "OR t_equipos.equipo LIKE '%$busqueda%') "
                    . "ORDER BY t_equipos.id_destino "
                    . "LIMIT $desde, $porPagina ";
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['ID'];
                    $equipo = $dts['EQUIPO'];
                    $destino = $dts['DESTINO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];


                    $salida .= "<div class=\"columns is-gapless my-1 is-mobile\">"
                            . "<div class=\"column\">"
                            . "<div class=\"columns is-gapless\">"
                            . "<div class=\"column is-4\"><p class=\"t-normal\">$equipo</p></div>"
                            . "<div class=\"column is-1\"><p class=\"t-normal\">$destino</p></div>"
                            . "<div class=\"column is-1\"><p class=\"t-normal\">$seccion</p></div>"
                            . "<div class=\"column is-3\"><p class=\"t-normal\">$subseccion</p></div>"
                            . "<div class=\"column t-normal\">"
                            . "<div class=\"field has-addons has-addons-centered\">"
                            . "<p class=\"control\">"
                            . "<button class=\"button is-info is-small\" onclick=\"showModal('modal-editar-equipo'); editarEquipo($idEquipo);\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-edit\"></i>"
                            . "</span>"
                            . "<span>Editar</span>"
                            . "</button>"
                            . "</p>"
                            . "<p class=\"control\">"
                            . "<button class=\"button is-danger is-small\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-trash\"></i>"
                            . "</span>"
                            . "<span>Eliminar</span>"
                            . "</button>"
                            . "</p>"
                            . "<p class=\"control\">"
                            . "<a href=\"equipos_mp.php?idEquipo=$idEquipo\" class=\"button is-primary is-small\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-wrench\"></i>"
                            . "</span>"
                            . "<span>MP</span>"
                            . "</a>"
                            . "</p>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
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

            $salida .= "<a class=\"pagination-previous\" onclick=\"obtEquipoXBusquedaXPagina($idDestino,1);\" href=\"#\">Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" onclick=\"obtEquipoXBusquedaXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {

            $salida .= "<a class=\"pagination-next\" onclick=\"obtEquipoXBusquedaXPagina($idDestino," . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>";
            $salida .= " <a class=\"pagination-next\" onclick=\"obtEquipoXBusquedaXPagina($idDestino," . $totalPaginas . ");\" href=\"#\">Fin</a>";
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
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXBusquedaXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXBusquedaXPagina($idDestino,1);\" href=\"#\">1</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXBusquedaXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                        
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXBusquedaXPagina($idDestino," . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquipoXBusquedaXPagina($idDestino,$totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
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

    public function obtEquipoXFiltro($idDestino, $seccion, $subseccion, $pagina) {
        $conn = new Conexion();
        $conn->conectar();

        $salida = "<div class=\"columns is-gapless my-1 is-mobile\">
                <div class=\"column\">
                    <div class=\"columns is-gapless\">
                        <div class=\"column is-4\"><p class=\"t-titulos has-background-dark has-text-white\">Equipo</p></div>
                        <div class=\"column is-1\"><p class=\"t-titulos has-background-dark has-text-white\">Destino</p></div>
                        <div class=\"column is-1\"><p class=\"t-titulos has-background-dark has-text-white\">Seccion</p></div>
                        <div class=\"column is-3\"><p class=\"t-titulos has-background-dark has-text-white\">Subseccion</p></div>
                        <div class=\"column\"><p class=\"t-titulos has-background-dark has-text-white\">Opciones</p></div>
                    </div>
                </div>
            </div>";

        if ($idDestino == 10) {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.status = 'A' ";
            if ($seccion != 0) {
                $query .= "AND t_equipos.id_seccion = $seccion ";
            }
            if ($subseccion != 0) {
                $query .= "AND t_equipos.id_subseccion = $subseccion";
            }
        } else {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.id_destino = $idDestino AND t_equipos.status = 'A' ";
            if ($seccion != 0) {
                $query .= "AND t_equipos.id_seccion = $seccion ";
            }
            if ($subseccion != 0) {
                $query .= "AND t_equipos.id_subseccion = $subseccion";
            }
        }
        try {
            $resp = $conn->obtDatos($query);
            $totalRegistros = $conn->filasConsultadas;
            $porPagina = 10;
        } catch (Exception $ex) {
            $salida = $ex;
        }

        $desde = ($pagina - 1) * $porPagina;
        $totalPaginas = ceil($totalRegistros / $porPagina);

        if ($idDestino == 10) {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.status = 'A' ";
            if ($seccion != 0) {
                $query .= "AND t_equipos.id_seccion = $seccion ";
            }
            if ($subseccion != 0) {
                $query .= "AND t_equipos.id_subseccion = $subseccion";
            }
            $query .= "ORDER BY t_equipos.id_destino "
                    . "LIMIT $desde, $porPagina ";
        } else {
            $query = "SELECT t_equipos.id 'ID', "
                    . "t_equipos.equipo 'EQUIPO', "
                    . "t_equipos.id_destino 'IDDESTINO', "
                    . "t_equipos.id_seccion 'IDSECCION', "
                    . "t_equipos.id_subseccion 'IDSUBSECCION', "
                    . "c_destinos.destino 'DESTINO', "
                    . "c_secciones.seccion 'SECCION', "
                    . "c_subsecciones.grupo 'SUBSECCION' "
                    . "FROM t_equipos "
                    . "INNER JOIN c_destinos ON t_equipos.id_destino = c_destinos.id "
                    . "INNER JOIN c_secciones ON t_equipos.id_seccion = c_secciones.id "
                    . "INNER JOIN c_subsecciones ON t_equipos.id_subseccion = c_subsecciones.id "
                    . "WHERE t_equipos.id_destino = $idDestino "
                    . "AND t_equipos.status = 'A' ";
            if ($seccion != 0) {
                $query .= "AND t_equipos.id_seccion = $seccion ";
            }
            if ($subseccion != 0) {
                $query .= "AND t_equipos.id_subseccion = $subseccion ";
            }
            $query .= "ORDER BY t_equipos.id_destino "
                    . "LIMIT $desde, $porPagina ";
        }
        try {
            $resp = $conn->obtDatos($query);
            if ($conn->filasConsultadas > 0) {
                foreach ($resp as $dts) {
                    $idEquipo = $dts['ID'];
                    $equipo = $dts['EQUIPO'];
                    $destino = $dts['DESTINO'];
                    $seccion = $dts['SECCION'];
                    $subseccion = $dts['SUBSECCION'];


                    $salida .= "<div class=\"columns is-gapless my-1 is-mobile\">"
                            . "<div class=\"column\">"
                            . "<div class=\"columns is-gapless\">"
                            . "<div class=\"column is-4\"><p class=\"t-normal\">$equipo</p></div>"
                            . "<div class=\"column is-1\"><p class=\"t-normal\">$destino</p></div>"
                            . "<div class=\"column is-1\"><p class=\"t-normal\">$seccion</p></div>"
                            . "<div class=\"column is-3\"><p class=\"t-normal\">$subseccion</p></div>"
                            . "<div class=\"column t-normal\">"
                            . "<div class=\"field has-addons has-addons-centered\">"
                            . "<p class=\"control\">"
                            . "<button class=\"button is-info is-small\" onclick=\"showModal('modal-editar-equipo'); editarEquipo($idEquipo);\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-edit\"></i>"
                            . "</span>"
                            . "<span>Editar</span>"
                            . "</button>"
                            . "</p>"
                            . "<p class=\"control\">"
                            . "<button class=\"button is-danger is-small\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-trash\"></i>"
                            . "</span>"
                            . "<span>Eliminar</span>"
                            . "</button>"
                            . "</p>"
                            . "<p class=\"control\">"
                            . "<a href=\"equipos_mp.php?idEquipo=$idEquipo\" class=\"button is-primary is-small\">"
                            . "<span class=\"icon is-small\">"
                            . "<i class=\"fas fa-wrench\"></i>"
                            . "</span>"
                            . "<span>MP</span>"
                            . "</a>"
                            . "</p>"
                            . "</div>"
                            . "</div>"
                            . "</div>"
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

            $salida .= "<a class=\"pagination-previous\" onclick=\"obtEquiposXFiltradoXPagina($idDestino,1);\" href=\"#\">Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" onclick=\"obtEquiposXFiltradoXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">Anterior</a>";
        } else {

            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Inicio</a>";
            $salida .= "<a class=\"pagination-previous\" href=\"#\" disabled>Anterior</a>";
        }
        if ($pagina != $totalPaginas) {

            $salida .= "<a class=\"pagination-next\" onclick=\"obtEquiposXFiltradoXPagina($idDestino," . intval($pagina + 1) . ");\" href=\"#\">Siguiente</a>";
            $salida .= " <a class=\"pagination-next\" onclick=\"obtEquiposXFiltradoXPagina($idDestino," . $totalPaginas . ");\" href=\"#\">Fin</a>";
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
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquiposXFiltradoXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquiposXFiltradoXPagina($idDestino,1);\" href=\"#\">1</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquiposXFiltradoXPagina($idDestino," . intval($pagina - 1) . ");\" href=\"#\">" . intval($pagina - 1) . "</a></li>";
                        $salida .= "<li class=\"pagination-link is-current\">$i</li>";
                    }

                    if ($pagina == $totalPaginas) {
                        
                    } else {
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquiposXFiltradoXPagina($idDestino," . intval($pagina + 1) . ");\" href=\"#\">" . intval($i + 1) . "</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" href=\"\">...</a></li>";
                        $salida .= "<li><a class=\"pagination-link\" onclick=\"obtEquiposXFiltradoXPagina($idDestino,$totalPaginas);\" href=\"#\">$totalPaginas</a></li>";
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
