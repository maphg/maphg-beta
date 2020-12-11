<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../../php/conexion.php';

if (isset($_GET['action'])) {

    //Variables Globales 
    $action = $_GET['action'];
    $idUsuario = $_GET['idUsuario'];
    $idDestino = $_GET['idDestino'];
    $fechaActual = date('Y-m-d H:m:s');
    $añoActual = date('Y');
    $semanaActual = date('W');


    if ($action == "consultaEquiposLocales") {
        $filtroDestino = intval($_GET['filtroDestino']);
        $filtroSeccion = intval($_GET['filtroSeccion']);
        $filtroSubseccion = intval($_GET['filtroSubseccion']);
        $filtroTipo = $_GET['filtroTipo'];
        $filtroStatus = $_GET['filtroStatus'];
        $filtroSemana = $_GET['filtroSemana'];
        $filtroPalabra = $_GET['filtroPalabra'];
        $array = array();

        if ($filtroDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and t_equipos_america.id_destino = $filtroDestino";
        }

        if ($filtroTipo > 0) {
            $filtroTipo = "and t_equipos_america.id_tipo = '$filtroTipo'";
        } else {
            $filtroTipo = "";
        }

        if ($filtroStatus != "") {
            $filtroStatus = "and t_equipos_america.status = '$filtroStatus'";
        } else {
            $filtroStatus = "";
        }

        if ($filtroSeccion > 0) {
            $filtroSeccion = "and t_equipos_america.id_seccion = $filtroSeccion";
        } else {
            $filtroSeccion = "";
        }

        if ($filtroSubseccion > 0) {
            $filtroSubseccion = "and t_equipos_america.id_subseccion = $filtroSubseccion";
        } else {
            $filtroSubseccion = "";
        }

        if ($filtroPalabra == "") {
            $filtroPalabra = "";
        } else {
            $filtroPalabra = "and (t_equipos_america.equipo LIKE '%$filtroPalabra%')";
        }

        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, t_equipos_america.local_equipo, t_equipos_america.modelo, t_equipos_america.status, t_equipos_america.id_fases,
        c_secciones.seccion, c_subsecciones.grupo, c_tipos.id 'id_tipo', c_tipos.tipo, c_marcas.marca, c_ubicaciones.ubicacion, 
        c_destinos.destino
        FROM t_equipos_america
        LEFT JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        LEFT JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        LEFT JOIN c_tipos ON t_equipos_america.id_tipo = c_tipos.id
        LEFT JOIN c_marcas ON t_equipos_america.id_marca = c_marcas.id
        LEFT JOIN c_ubicaciones ON t_equipos_america.id_ubicacion = c_ubicaciones.id
        LEFT JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
        WHERE t_equipos_america.activo = 1 
        $filtroDestino $filtroSeccion  $filtroSubseccion $filtroTipo $filtroStatus $filtroPalabra";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $equipo = $i['equipo'];
                $local_equipo = $i['local_equipo'];
                $status = $i['status'];
                $seccion = $i['seccion'];
                $subseccion = $i['grupo'];
                $idTipo = $i['id_tipo'];
                $tipo = $i['tipo'];
                $marca = $i['marca'];
                $ubicacion = $i['ubicacion'];
                $modelo = $i['modelo'];
                $idFases = $i['id_fases'];
                $destino = $i['destino'];
                $resultx = array();

                // Contadores para Resumen MP
                $contadorPlanificado = 0;
                $contadorProceso = 0;
                $contadorSolucionado = 0;

                if ($filtroSemana <= 0 || $filtroSemana == "") {
                    $mp = "SELECT* FROM t_mp_planeacion_proceso WHERE id_equipo = $id AND activo = 1 AND año = '$añoActual'";
                    if ($result = mysqli_query($conn_2020, $mp)) {

                        foreach ($result as $x) {
                            for ($i = $semanaActual; $i < 53; $i++) {
                                $semana = $x['semana_' . $i];
                                if ($semana == "PROCESO") {
                                    $proximoMP = $i;
                                    $resultx[] = $proximoMP;
                                    $i = 52;
                                }
                            }
                        }

                        foreach ($result as $x) {
                            // Resumen MP
                            for ($i = 1; $i < 52; $i++) {
                                $semana = $x['semana_' . $i];
                                if ($semana == "PROCESO") {
                                    $contadorProceso++;
                                }
                                if ($semana == "SOLUCIONADO") {
                                    $contadorSolucionado++;
                                }
                            }
                        }
                    }

                    $mp = "SELECT* FROM t_mp_planeacion_semana WHERE id_equipo = $id AND activo = 1 AND año = '$añoActual'";
                    if ($result = mysqli_query($conn_2020, $mp)) {
                        foreach ($result as $x) {
                            for ($i = $semanaActual; $i < 53; $i++) {
                                $semana = $x['semana_' . $i];
                                if ($semana == "PLANIFICADO") {
                                    $proximoMP = $i;
                                    $resultx[] = $proximoMP;
                                    $i = 52;
                                }
                            }
                        }

                        foreach ($result as $x) {
                            for ($i = 1; $i < 53; $i++) {
                                $semana = $x['semana_' . $i];
                                if ($semana == "PLANIFICADO") {
                                    $contadorPlanificado++;
                                }
                            }
                        }
                    }
                } else {
                    $filtroSemana = intval($filtroSemana);
                    $mp = "SELECT semana_$filtroSemana FROM t_mp_planeacion_proceso WHERE id_equipo = $id AND activo = 1 AND año = '$añoActual'";
                    if ($result = mysqli_query($conn_2020, $mp)) {

                        foreach ($result as $x) {
                            $semana = $x['semana_' . $filtroSemana];
                            if ($semana == "PROCESO") {
                                $resultx[] = $filtroSemana;
                            }
                        }

                        foreach ($result as $x) {
                            // Resumen MP
                            $semana = $x['semana_' . $filtroSemana];
                            if ($semana == "PROCESO") {
                                $contadorProceso++;
                            }
                            if ($semana == "SOLUCIONADO") {
                                $contadorSolucionado++;
                            }
                        }
                    }

                    $mp = "SELECT semana_$filtroSemana FROM t_mp_planeacion_semana WHERE id_equipo = $id AND activo = 1 AND año = '$añoActual'";
                    if ($result = mysqli_query($conn_2020, $mp)) {
                        foreach ($result as $x) {
                            $semana = $x['semana_' . $filtroSemana];
                            if ($semana == "PLANIFICADO") {
                                $resultx[] = $filtroSemana;
                            }
                        }

                        foreach ($result as $x) {
                            $semana = $x['semana_' . $filtroSemana];
                            if ($semana == "PLANIFICADO") {
                                $contadorPlanificado++;
                            }
                        }
                    }
                }

                $resuly = array_count_values($resultx);
                $xc = "";
                foreach ($resuly as $key => $value) {
                    if ($value > 1) {
                        $xc .= " " . $key . "(" . $value . ") ";
                    } else {
                        $xc .= " " . $key;
                    }
                }


                $fase = "";
                $fases = "SELECT fase FROM c_fases WHERE id IN($idFases)";
                if ($result = mysqli_query($conn_2020, $fases)) {
                    foreach ($result as $i) {
                        $fase .= $i['fase'] . " ";
                    }
                }

                $arrayTemp = array(
                    "id" => "$id",
                    "destino" => "$destino",
                    "equipo" => "$equipo",
                    "seccion" => "$seccion",
                    "subseccion" => "$subseccion",
                    "marca" => "$fase",
                    "idtipoEquipo" => intval($idTipo),
                    "tipoEquipo" => "$tipo",
                    "status" => "$status",
                    "marcaEquipo" => "$marca",
                    "modelo" => "$modelo",
                    "equipoLocal" => "$local_equipo",
                    "ubicacion" => "$ubicacion",
                    "proximoMP" => $xc,
                    "proceso" => $contadorProceso,
                    "solucionado" => $contadorSolucionado,
                    "planificado" => $contadorPlanificado,
                    "semanaActual" => $semanaActual
                );

                $array[] = $arrayTemp;
            }
        }
        echo json_encode($array);
    }


    if ($action == "consultarDestinos") {
        $array = array();

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "and id = $idDestino";
        }

        $query = "SELECT id, destino FROM c_destinos WHERE status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $destino = $i['destino'];

                $arrayTemp = array("id" => "$id", "destino" => "$destino");
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }


    if ($action == "consultarSecciones") {
        $array = array();

        $query = "SELECT id, seccion FROM c_secciones WHERE status = 'A' and id IN(11,10,24,1,23,19,5,6,7,12,8,9)";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $seccion = $i['seccion'];

                $arrayTemp = array("id" => "$id", "seccion" => "$seccion");
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }


    // Opciones para el Filtro de Subsecciones según la Seccion Asignada en el Filtro
    if ($action == "consultarSubsecciones") {
        $idSeccion =  $_GET['idSeccion'];
        $array = array();

        $query = "SELECT id, grupo FROM c_subsecciones WHERE id_seccion = $idSeccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $subseccion = $i['grupo'];

                $arrayTemp = array("id" => "$id", "subseccion" => "$subseccion");
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }


    // Consulta el despiece de Equipos incluyendo el Equipo Padre
    if ($action == "despieceEquipos") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();
        $query = "SELECT t_equipos_america.id, t_equipos_america.equipo, t_equipos_america.jerarquia FROM t_equipos_america WHERE t_equipos_america.activo = 1 and (t_equipos_america.id = $idEquipo OR t_equipos_america.id_equipo_principal = $idEquipo)";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $equipo = $i['equipo'];
                $jerarquia = $i['jerarquia'];

                $arrayTemp = array("id" => "$id", "equipo" => "$equipo", "jerarquia" => "$jerarquia");
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }


    // Consulta posibles Equipos Jerarquicos
    if ($action == "opcionesJerarquiaEquipo") {
        $idEquipo = $_GET['idEquipo'];
        $array = array();

        $query = "SELECT t_equipos_america.id, t_equipos_america.id_destino, t_equipos_america.id_subseccion FROM t_equipos_america WHERE t_equipos_america.activo = 1 AND t_equipos_america.id = $idEquipo";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idDestino = $i['id_destino'];
                $idSubseccion = $i['id_subseccion'];

                $query = "SELECT id, equipo FROM t_equipos_america WHERE id_destino = $idDestino AND id_subseccion = $idSubseccion";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $id = $i['id'];
                        $equipo = $i['equipo'];

                        $arrayTemp = array("id" => "$id", "equipo" => "$equipo");
                        $array[] = $arrayTemp;
                    }
                }
            }
            echo json_encode($array);
        }
    }


    // Consulta posibles Equipos Jerarquicos
    if ($action == "jerarquiaEquipo") {
        $idSeccion = $_GET['idSeccion'];
        $idSubseccion = $_GET['idSubseccion'];
        $array = array();

        $query = "SELECT id, equipo FROM t_equipos_america WHERE id_destino = $idDestino and id_seccion = $idSubseccion and id_subseccion = $idSubseccion";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $equipo = $i['equipo'];

                $array[] = array("idEquipo" => "$id", "equipo" => "$equipo");
            }
        }
        echo json_encode($array);
    }


    // OBTIENE OPCIONES PARA CREAR EQUIPO / LOCAL
    if ($action == "obtenerOpcionesEquipo") {
        $array = array();
        $idSeccion = $_GET['idSeccion'];

        // FILTROS
        if ($idDestino == 10) {
            $filtroDestino = "and id != 10";
        } else {
            $filtroDestino = " and id = $idDestino";
        }

        // DESTINOS
        $query = "SELECT id, destino FROM c_destinos WHERE status = 'A' $filtroDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idDestino = $x["id"];
                $destino = $x["destino"];

                $array["destinos"][] = array(
                    "idDestino" => intval($idDestino),
                    "destino" => $destino
                );
            }
        }

        // SECCIONES
        $query = "SELECT c_rel_destino_seccion.id_seccion, c_secciones.seccion
        FROM c_rel_destino_seccion
        INNER JOIN c_secciones ON c_rel_destino_seccion.id_seccion = c_secciones.id
        WHERE id_destino = $idDestino ORDER BY c_secciones.seccion ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idSeccionX = $x["id_seccion"];
                $seccion = $x['seccion'];

                $array["secciones"][] = array(
                    "idSeccion" => $idSeccionX,
                    "seccion" => $seccion
                );
            }
        }

        // SUBSECCIONES
        if ($idSeccion <= 0) {
            $array["subsecciones"][] = array(
                "idSubseccion" => "",
                "subseccion" => ""
            );
        } else {
            $query = "SELECT id, grupo FROM c_subsecciones 
            WHERE id_seccion = $idSeccion ORDER BY grupo ASC";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $x) {
                    $idSubseccion = $x["id"];
                    $subseccion = $x["grupo"];

                    $array["subsecciones"][] = array(
                        "idSubseccion" => $idSubseccion,
                        "subseccion" => $subseccion
                    );
                }
            }
        }

        // TIPOS DE EQUIPOS
        $query = "SELECT id, tipo FROM c_tipos WHERE status = 'A' ORDER BY tipo ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTipo = $x["id"];
                $tipo = $x["tipo"];

                $array["tipos"][] = array(
                    "idTipo" => intval($idTipo),
                    "tipo" => $tipo
                );
            }
        }

        // MARCAS
        $query = "SELECT id, marca FROM c_marcas WHERE status = 'A' ORDER BY marca ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idMarca = $x["id"];
                $marca = $x["marca"];

                $array["marcas"][] = array(
                    "idMarca" => intval($idMarca),
                    "marca" => $marca
                );
            }
        }

        // TIPO LOCAL O EQUIPO
        $array['tipoEquipo'][] = array("idTipoEquipo" => "EQUIPO", "tipo" => "EQUIPO");
        $array['tipoEquipo'][] = array("idTipoEquipo" => "LOCAL", "tipo" => "LOCAL");

        // STATUS LOCAL O EQUIPO
        $array['status'][] = array("idStatus" => "OPERATIVO", "status" => "OPERATIVO");
        $array['status'][] = array("idStatus" => "BAJA", "status" => "BAJA");
        $array['status'][] = array("idStatus" => "TALLER", "status" => "TALLER");

        echo json_encode($array);
    }

    if ($action == "agregarEquipoLocal") {
        $equipo = $_GET['equipo'];
        $destino = $_GET['destino'];
        $seccion = $_GET['seccion'];
        $subseccion = $_GET['subseccion'];
        $tipo = $_GET['tipo'];
        $marca = $_GET['marca'];
        $equipolocal = $_GET['equipolocal'];
        $modelo = $_GET['modelo'];
        $jerarquia = $_GET['jerarquia'];
        $equipoPadre = $_GET['equipoPadre'];
        $resp = 0;

        if ($jerarquia == "PRINCIPAL") {
            $equipoPadre = 0;
        }

        $query = "INSERT INTO t_equipos_america(id_equipo_principal, equipo, id_destino, id_seccion, id_subseccion, id_tipo, local_equipo, jerarquia, id_marca, modelo, id_fases, status, activo) VALUES($equipoPadre, '$equipo', $destino, $seccion, $subseccion, $tipo, '$equipolocal', '$jerarquia', $marca, '$modelo', '', 'OPERATIVO', 1)";
        if ($result = mysqli_query($conn_2020, $query)) {
            $resp = 1;
        }
        echo json_encode($resp);
    }




    // FIN
}
