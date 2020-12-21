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


    #OBTIENE LOS PROYECTOS SEGÚN LA SECCIÓN Y DESTINO
    if ($action == "actualizarActividadOT") {
        $idActividad = $_GET['idActividad'];
        $idTipo = $_GET['idTipo'];
        $tipo = $_GET['tipo'];
        $actividad = $_GET['actividad'];
        $columna = $_GET['columna'];
        $resp = array();
        $resp[0] = "ERROR";

        if ($tipo == "FALLA") {
            $tabla = "t_mc_actividades_ot";
        } elseif ($tipo == "TAREA") {
            $tabla = "t_mp_np_actividades_ot";
        }

        if ($columna == "activo") {
            $query = "UPDATE $tabla SET activo = 0 WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp[0] = "ELIMINADO";
            }
        } elseif ($columna == "status") {
            $query = "UPDATE $tabla SET status = 'SOLUCIONADO' WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp[0] = "SOLUCIONADO";
            }
        } elseif ($columna == "actividad") {
            $query = "UPDATE $tabla SET actividad = '$actividad' WHERE id = $idActividad";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp[0] = "ACTIVIDAD";
            }
        } elseif ($columna == "nuevo") {
            $tipo = strtolower($tipo);
            $query  = "INSERT INTO $tabla (id_$tipo , actividad) VALUES($idTipo, '$actividad')";
            if ($result = mysqli_query($conn_2020, $query)) {
                $resp[0] = "AGREGADO";
            }
        } else {
            $resp[0] = "NOOPCION";
        }

        echo json_encode($resp);
    }


    // EXPORTA EQUIPOS A LA NUEVA SERSIÓN
    if ($action == "exportarEquipos") {
        $array = array();
        $contador = 0;

        $query = "SELECT id FROM t_equipos WHERE id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id'];

                $query = "SELECT id FROM t_equipos_america WHERE id = $idEquipo";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $contador++;
                        $idEquiposX = $x['id'];
                        $arrayTemp = array("idEquipo" => intval($idEquiposX));
                        $array['equipo'][] = $arrayTemp;
                    }
                }
                $array['totalEquipos'] = $contador;
            }
        }
        echo json_encode($array);
    }


    // EXPORTA TAREAS GENERALES (T_MC -> T_MP_NP)  A LA NUEVA VERSIÓN
    if ($action == "exportarTareasGenerales") {
        $array = array();

        $query = "SELECT * FROM t_mc 
        WHERE id_equipo = 0 and id_destino = $idDestino and activo != 2";
        // $query = "SELECT * FROM t_mc WHERE id = 14316";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idTG = $x['id'];
                $actividad = $x['actividad'];
                $status = $x['status'];
                $creadoPor = $x['creado_por'];
                $responsable = $x['responsable'];
                $realizador = $x['realizado_por'];
                $fechaCreacion = $x['fecha_creacion'];
                $ultimaModificacion = $x['ultima_modificacion'];
                $idDestinoX = $x['id_destino'];
                $idSeccion = $x['id_seccion'];
                $idSubseccion = $x['id_subseccion'];
                $rangoFecha = $x['rango_fecha'];
                $sMaterial = $x['status_material'];
                $sTrabajare = $x['status_trabajare'];
                $sUrgente = $x['status_urgente'];
                $sCalidad = $x['departamento_calidad'];
                $sCompras = $x['departamento_compras'];
                $sDireccion = $x['departamento_direccion'];
                $sFinanzas = $x['departamento_finanzas'];
                $sRRHH = $x['departamento_rrhh'];
                $sElectricidad = $x['energetico_electricidad'];
                $sAgua = $x['energetico_agua'];
                $sDiesel = $x['energetico_diesel'];
                $sGas = $x['energetico_gas'];
                $zona = $x['zona'];
                $cod2bend = $x['cod2bend'];
                $codsap = $x['codsap'];
                $bitacoraGP = $x['bitacora_gp'];
                $bitacoraTRS = $x['bitacora_trs'];
                $bitacoraZI = $x['bitacora_zi'];
                $activo = $x['activo'];

                if ($status == "N" || $status == "") {
                    $status = "PENDIENTE";
                } else {
                    $status = "SOLUCIONADO";
                }

                if ($fechaCreacion != "") {
                    $fechaCreacion = (new DateTime($fechaCreacion))->format('Y-m-d H:m:s');
                }

                if ($sMaterial != "") {
                    $sMaterial = 1;
                } else {
                    $sMaterial = 0;
                }

                if ($sTrabajare != "") {
                    $sTrabajare = 1;
                } else {
                    $sTrabajare = 0;
                }

                if ($sUrgente != "") {
                    $sUrgente = 1;
                } else {
                    $sUrgente = 0;
                }

                if ($sCalidad != "") {
                    $sCalidad = 1;
                } else {
                    $sCalidad = 0;
                }

                if ($sCompras != "") {
                    $sCompras = 1;
                } else {
                    $sCompras = 0;
                }

                if ($sDireccion != "") {
                    $sDireccion = 1;
                } else {
                    $sDireccion = 0;
                }

                if ($sFinanzas != "") {
                    $sFinanzas = 1;
                } else {
                    $sFinanzas = 0;
                }

                if ($sRRHH != "") {
                    $sRRHH = 1;
                } else {
                    $sRRHH = 0;
                }

                if ($sElectricidad != "") {
                    $sElectricidad = 1;
                } else {
                    $sElectricidad = 0;
                }

                if ($sAgua != "") {
                    $sAgua = 1;
                } else {
                    $sAgua = 0;
                }

                if ($sDiesel != "") {
                    $sDiesel = 1;
                } else {
                    $sDiesel = 0;
                }

                if ($sGas != "") {
                    $sGas = 1;
                } else {
                    $sGas = 0;
                }

                if ($zona != "") {
                    $zona = " ";
                }

                if ($cod2bend != "") {
                    $cod2bend = " ";
                }

                if ($codsap != "") {
                    $codsap = " ";
                }

                if ($bitacoraGP != "") {
                    $bitacoraGP = " ";
                }

                if ($bitacoraTRS != "") {
                    $bitacoraTRS = " ";
                }

                if ($bitacoraZI != "") {
                    $bitacoraZI = " ";
                }

                $idNuevo = 0;
                $query = "SELECT max(id) 'id' FROM t_mp_np";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $idNuevo = intval($x['id']) + 1;
                    }
                }

                if ($idNuevo > 0) {
                    $query = "INSERT INTO t_mp_np(id, id_equipo, id_usuario, id_destino, id_seccion, id_subseccion, titulo, responsable, fecha, rango_fecha, status, status_urgente, status_material, status_trabajando, energetico_electricidad, energetico_agua, energetico_diesel, energetico_gas, departamento_calidad, departamento_compras, departamento_direccion, departamento_finanzas, departamento_rrhh, cod2bend, codsap, activo) value($idNuevo, 0, $creadoPor, $idDestinoX, $idSeccion, $idSubseccion, '$actividad', $responsable, '$fechaCreacion', '$rangoFecha', '$status', $sUrgente, $sMaterial, $sTrabajare, $sElectricidad, $sAgua, $sDiesel, $sGas, $sCalidad, $sCompras, $sDireccion, $sFinanzas, $sRRHH, '$cod2bend', '$codsap', $activo)";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $query = "UPDATE t_mc SET activo = 2 WHERE id = $idTG";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $resp = 1;
                        }
                    }

                    $arrayC = array();
                    $query = "SELECT* FROM t_mc_comentarios WHERE id_mc = $idTG";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $comentarioC = $x['comentario'];
                            $idUsuarioC = $x['id_usuario'];
                            $fechaC  = $x['fecha'];
                            $activoC = $x['activo'];

                            $query = "INSERT INTO comentarios_mp_np(id_mp_np, id_usuario, comentario, fecha, activo) VALUES($idNuevo, $idUsuarioC, '$comentarioC', '$fechaC', '$activoC')";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $resp = 1;
                            }

                            $arrayC[] = array(
                                "comentario" => $comentarioC,
                                "idUsuario" => $idUsuarioC,
                                "fecha" => $fechaC,
                                "activo" => $activoC
                            );
                        }
                    }

                    $arrayA = array();
                    $query = "SELECT* FROM t_mc_adjuntos WHERE id_mc = $idTG";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        foreach ($result as $x) {
                            $url_adjuntoA = $x['url_adjunto'];
                            $fechaA = $x['fecha'];
                            $subido_porA = $x['subido_por'];
                            $activoA = $x['activo'];

                            $arrayA[] = array(
                                "url_adjunto" => $url_adjuntoA,
                                "fecha" => $fechaA,
                                "subido_por" => intval($subido_porA),
                                "activo" => intval($activoA)
                            );

                            $query = "INSERT INTO adjuntos_mp_np(id_usuario, id_mp_np, url, fecha, activo) VALUES($subido_porA, $idNuevo, '$url_adjuntoA', '$fechaA', $activoA)";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $resp = 1;
                            }
                        }
                    }
                }

                $array[] = array(
                    "idNuevo" => intval($idNuevo),
                    "idTG" => intval($idTG),
                    "actividad" => $actividad,
                    "status" => $status,
                    "creadoPor" => intval($creadoPor),
                    "responsable" => intval($responsable),
                    "realizador" => intval($realizador),
                    "fechaCreacion" => $fechaCreacion,
                    "ultimaModificacion" => $ultimaModificacion,
                    "idDestinoX" => intval($idDestinoX),
                    "idSeccion" => intval($idSeccion),
                    "idSubseccion" => intval($idSubseccion),
                    "rangoFecha" => $rangoFecha,
                    "sMaterial" => $sMaterial,
                    "sTrabajare" => $sTrabajare,
                    "sUrgente" => $sUrgente,
                    "sCalidad" => $sCalidad,
                    "sCompras" => $sCompras,
                    "sDireccion" => $sDireccion,
                    "sFinanzas" => $sFinanzas,
                    "sRRHH" => $sRRHH,
                    "sElectricidad" => $sElectricidad,
                    "sAgua" => $sAgua,
                    "sDiesel" => $sDiesel,
                    "sGas" => $sGas,
                    "zona" => $zona,
                    "cod2bend" => $cod2bend,
                    "codsap" => $codsap,
                    "bitacoraGP" => $bitacoraGP,
                    "bitacoraTRS" => $bitacoraTRS,
                    "bitacoraZI" => $bitacoraZI,
                    "activo" => intval($activo),
                    "adjuntos" => $arrayA,
                    "comentarios" => $arrayC
                );
            }
        }
        echo json_encode($array);
    }


    if ($action == "exportarEquiposConfirmado") {
        $array = array();
        $contadorExportados = 0;
        $contadorEquipos = -1;

        $query = "SELECT * FROM t_equipos WHERE id_destino = $idDestino";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $x) {
                $idEquipo = $x['id'];
                $cod2bend = $x['cod2bend'];
                $equipo = $x['equipo'];
                $matricula = $x['matricula'];
                $id_marca = $x['id_marca'];
                $modelo = $x['modelo'];
                $serie = $x['serie'];
                $id_tipo = $x['id_tipo'];
                $id_ccoste = $x['id_ccoste'];
                $id_destino = $x['id_destino'];
                $id_hotel = $x['id_hotel'];
                $id_seccion = $x['id_seccion'];
                $id_subseccion = $x['id_subseccion'];
                $id_area = $x['id_area'];
                $id_localizacion = $x['id_localizacion'];
                $id_ubicacion = $x['id_ubicacion'];
                $id_sububicacion = $x['id_sububicacion'];
                $status_equipo = $x['status_equipo'];
                $categoria = $x['categoria'];
                $status = $x['status'];
                $coste = $x['coste'];
                $contadorEquipos++;

                if ($status == "A") {
                    $status = "OPERATIVO";
                } else {
                    $status = "BAJA";
                }
                $arrayTemp = array("id" => $idEquipo, "status" => "No Agregado");
                $array['equipo'][] = $arrayTemp;

                $query = "INSERT INTO  t_equipos_america(id, equipo, cod2bend, matricula, serie, id_destino, id_seccion, id_subseccion, id_tipo, id_ccoste, id_hotel, id_area, id_localizacion, id_ubicacion, id_sububicacion, categoria, local_equipo, jerarquia, id_marca, modelo, numero_serie, codigo_fabricante, coste, id_fases, status, activo) VALUES($idEquipo, '$equipo', '$cod2bend', '$matricula', '$serie', '$id_destino', '$id_seccion', '$id_subseccion', '$id_tipo', '$id_ccoste', '$id_hotel', '$id_area', '$id_localizacion', '$id_ubicacion', '$id_sububicacion', '$categoria', 'EQUIPO', 'PRINCIPAL', '$id_marca', '$modelo', '', '', '$coste', '', '$status', 1)";
                // $array['EQUIPO'][$idEquipo]['QUERY'] = $query;

                if ($result = mysqli_query($conn_2020, $query)) {
                    $arrayTemp = array("id" => $idEquipo, "status" => "Agregado");
                    $array['equipo'][$contadorEquipos] = $arrayTemp;
                    $contadorExportados++;
                }
            }
            $array['totalEquipos'] = intval($contadorEquipos) + 1;
            $array['totalExportados'] = $contadorExportados;
        }
        echo json_encode($array);
    }
}
