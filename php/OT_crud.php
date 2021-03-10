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


    function notifiacionMP($idOT)
    {
        $equipo = "";
        $asignadoPor = "";
        $asignadoA = "";
        $idResponsable = 0;
        $token = "";
        $chatId = "";

        $query = "SELECT t_mp_planificacion_iniciada.id, t_colaboradores.nombre, t_equipos_america.equipo, t_mp_planificacion_iniciada.id_responsables
        FROM t_mp_planificacion_iniciada
        INNER JOIN t_users ON t_mp_planificacion_iniciada.id_usuario = t_users.id
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        WHERE t_mp_planificacion_iniciada.id = $idOT";
        if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
                $asignadoPor = $x['nombre'];
                $equipo = $x['equipo'];
                $idOT = $x['id'];
                $idResponsable = $x['id_responsables'];
            }
        }

        $query = "SELECT t_colaboradores.nombre, t_users.telegram_chat_id
        FROM t_users 
        INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id 
        WHERE t_users.id = $idResponsable";
        if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
                $asignadoA = $x['nombre'];
                $chatId = $x['telegram_chat_id'];
            }
        }

        $query = "SELECT url FROM t_enlaces WHERE tipo_enlace = 'BOTMAPHG' and activo = 1";
        if ($result = mysqli_query($GLOBALS['conn_2020'], $query)) {
            foreach ($result as $x) {
                $token = $x['url'];
            }
        }

        $equipo = preg_replace('([^A-Za-z0-9 ])', '', $equipo);
        $msg = "Hola <strong>$asignadoA</strong>, te han asignado una OT de Preventivos por <strong>$asignadoPor</strong>, <strong>\"OT $idOT\"</strong> del equipo <strong>🚩$equipo</strong> 📅 " . $GLOBALS['fechaActual'];

        $APITelegram = "https://api.telegram.org/bot$token/sendMessage?chat_id=$chatId" .
            "&text=$msg&parse_mode=html";
        if ($token != "" and $chatId != "" and $msg != "") {
            file_get_contents($APITelegram);
        }
    }

    if ($action == "obtenerOTDigital") {
        $idEquipo = $_GET['idEquipo'];
        $idPlan = $_GET['idPlan'];
        $semanaX = $_GET['semanaX'];
        $array = array();
        $responsables = array();
        $actividades = array();
        $adjuntos = array();

        $query = "SELECT t_mp_planificacion_iniciada.id, t_mp_planificacion_iniciada.id_responsables, t_mp_planificacion_iniciada.status, t_mp_planificacion_iniciada.semana, t_mp_planificacion_iniciada.comentario, t_mp_planes_mantenimiento.id 'id_plan', t_mp_planes_mantenimiento.tipo_plan, t_mp_planificacion_iniciada.actividades_extra
        FROM t_mp_planificacion_iniciada 
        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan = t_mp_planes_mantenimiento.id
        WHERE t_mp_planificacion_iniciada.id_plan = $idPlan and t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.semana = $semanaX and t_mp_planificacion_iniciada.activo = 1 and t_mp_planificacion_iniciada.año = $añoActual and t_mp_planificacion_iniciada.status IN('SOLUCIONADO', 'PROCESO')";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idOT = $i['id'];
                $idPlan = $i['id_plan'];
                $statusOT = $i['status'];
                $semana = $i['semana'];
                $comentario = $i['comentario'];
                $tipoPlan = $i['tipo_plan'];
                $idResponsables = $i['id_responsables'];
                $actividadesExtra = $i['actividades_extra'];
                $actividadesExtra = explode(";", $actividadesExtra);

                if ($statusOT == "PROCESO") {
                    $statusOT = "EN PROCESO";
                } elseif ($statusOT == "SOLUCIONADO") {
                    $statusOT = "SOLUCIONADO";
                }

                #RESPONSABLE 
                $responsable = "Nombre y Firma";
                $query = "SELECT t_colaboradores.nombre, t_colaboradores.apellido
                FROM t_users 
                INNER JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id IN($idResponsables)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $responsable = $x['nombre'] . " " . $x['apellido'];
                    }
                }

                // ACTIVIDADES NORMALES
                $query = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_preventivos WHERE id_plan = $idPlan and status = 'ACTIVO' and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $id = $i['id'];
                        $tipoActividad = $i['tipo_actividad'];
                        $actividad = $i['descripcion_actividad'];

                        $actividadesTemp = array("id" => $id, "tipoActividad" => $tipoActividad, "actividad" => $actividad, "medicion" => "");
                        $actividades[] = $actividadesTemp;
                    }
                }

                // ACTIVIDADES CHECK
                $query = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_checklist WHERE id_plan = $idPlan and status = 'ACTIVO' and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $id = $i['id'];
                        $tipoActividad = $i['tipo_actividad'];
                        $actividad = $i['descripcion_actividad'];

                        $actividadesTemp = array("id" => $id, "tipoActividad" => $tipoActividad, "actividad" => $actividad, "medicion" => "");
                        $actividades[] = $actividadesTemp;
                    }
                }

                // ACTIVIDADES LIST
                $query = "SELECT id, tipo_actividad, descripcion_actividad, tipo_medicion FROM t_mp_planes_actividades_test WHERE id_plan = $idPlan and status = 'ACTIVO' and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $id = $i['id'];
                        $tipoActividad = $i['tipo_actividad'];
                        $actividad = $i['descripcion_actividad'];
                        $medicion = $i['tipo_medicion'];

                        $actividadesTemp = array("id" => $id, "tipoActividad" => $tipoActividad, "actividad" => $actividad, "medicion" => $medicion);
                        $actividades[] = $actividadesTemp;
                    }
                }

                // Array Temporal para cada iteración
                $arrayTemp = array(
                    "OT" => "$idOT",
                    "statusOT" => "$statusOT",
                    "semana" => "Semana $semana",
                    "observacion" => "$idOT",
                    "comentario" => "$comentario",
                    "tipoPlan" => "OT $tipoPlan",
                    "actividades" => $actividades,
                    "actividadesExtra" => $actividadesExtra,
                    "responsable" => $responsable
                );

                // Array para almacenar resultados de las iteraciones
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }

    if ($action == "agregarActividadesExtra") {
        $actividad = $_GET['actividadesExtra'];
        $idOT = $_GET['idOT'];
        $array = array();

        $query = "SELECT actividades_extra FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $actividades = $i['actividades_extra'];
                $actividadesTemp = explode(";", $actividades);
                $totalActividades = count($actividadesTemp);
                if ($totalActividades > 0) {
                    $actividades = "$actividades" . ";$actividad";
                    $query = "UPDATE t_mp_planificacion_iniciada SET actividades_extra = '$actividades' WHERE id = $idOT";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $respuesta = "Agregada";
                    }
                }
            }
        }
        echo json_encode($respuesta);
    }


    if ($action == "consultarActividadesExtraOT") {
        $idOT = $_GET['idOT'];
        $array = array();

        $query = "SELECT actividades_extra FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $actividadesExtra = $i['actividades_extra'];
                $actividadesExtra = explode(";", $actividadesExtra);
                $arrayTemp = array("actividadesExtra" => $actividadesExtra);
                $array[] = $arrayTemp;
            }
            echo json_encode($array);
        }
    }


    if ($action == "eliminarActividadesExtra") {
        $idOT = $_GET['idOT'];
        $posicionItem = $_GET['posicionItem'];
        $array = array();

        $query = "SELECT actividades_extra FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $actividadesExtra = $i['actividades_extra'];
                $actividadesExtra = explode(";", $actividadesExtra);
                if ($posicionItem >= 0) {
                    unset($actividadesExtra[$posicionItem]);
                    $actividadesExtra = implode(";", $actividadesExtra);
                    $query = "UPDATE t_mp_planificacion_iniciada SET actividades_extra = '$actividadesExtra' WHERE id = $idOT";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $respuesta = "Eliminada";
                    } else {
                        $respuesta = "NoEliminada";
                    }
                }
            }
            echo json_encode($respuesta);
        }
    }


    if ($action == "consultarAdjuntosOT") {
        $idOT = $_GET['idOT'];
        $array = array();

        $query = "SELECT t_mp_planificacion_iniciada_adjuntos.id, t_mp_planificacion_iniciada_adjuntos.url, t_colaboradores.nombre, t_colaboradores.apellido
        FROM t_mp_planificacion_iniciada_adjuntos 
        LEFT JOIN t_users ON t_mp_planificacion_iniciada_adjuntos.id_usuario = t_users.id
        LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
        WHERE t_mp_planificacion_iniciada_adjuntos.id_planificacion_iniciada = $idOT and t_mp_planificacion_iniciada_adjuntos.activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $nombre  = $i['nombre'] . " " . $i['apellido'];
                $url = $i['url'];

                if (strpos($url, "jpg") || strpos($url, "jpeg") || strpos($url, "png") || strpos($url, "gif")) {
                    $tipo = "imagenes";
                } else {
                    $tipo = "documentos";
                }

                $array[] = array(
                    "id" => $id,
                    "nombre" => $nombre,
                    "url" => $url,
                    "tipo" => $tipo
                );
            }
            echo json_encode($array);
        }
    }


    if ($action == "consultarStatusOT") {
        $idOT = $_GET['idOT'];
        $array = array();
        $query = "SELECT* FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $statusUrgente = $i['status_urgente'];
                $statusTrabajare = $i['status_trabajando'];
                $statusMaterial = $i['status_material'];
                $statusElectricidad = $i['energetico_electricidad'];
                $statusAgua = $i['energetico_agua'];
                $statusGas = $i['energetico_gas'];
                $statusDiesel = $i['energetico_diesel'];
                $statusCompras = $i['departamento_compras'];
                $statusFinanzas = $i['departamento_finanzas'];
                $statusRRHH = $i['departamento_rrhh'];
                $statusDireccion = $i['departamento_direccion'];
                $statusCalidad = $i['departamento_calidad'];
                $cod2bend = $i['cod2bend'];

                $array['statusUrgente'] = $statusUrgente;
                $array['statusTrabajare'] = $statusTrabajare;
                $array['statusMaterial'] = $statusMaterial;
                $array['statusElectricidad'] = $statusElectricidad;
                $array['statusAgua'] = $statusAgua;
                $array['statusGas'] = $statusGas;
                $array['statusDiesel'] = $statusDiesel;
                $array['statusCompras'] = $statusCompras;
                $array['statusFinanzas'] = $statusFinanzas;
                $array['statusRRHH'] = $statusRRHH;
                $array['statusDireccion'] = $statusDireccion;
                $array['statusCalidad'] = $statusCalidad;
                $array['cod2bend'] = $cod2bend;
            }
            echo  json_encode($array);
        }
    }

    if ($action == "actualizaStatusOT") {
        $idOT = $_GET['idOT'];
        $status = $_GET['status'];
        $array = array();

        if (
            $status == "status_trabajando" || $status == "energetico_electricidad" || $status == "energetico_agua" ||
            $status == "energetico_diesel" || $status == "energetico_gas" || $status == "departamento_rrhh" || $status == "departamento_direccion" ||
            $status == "departamento_finanzas" || $status == "departamento_calidad" || $status == "departamento_compras" || $status == "bitacora_gp" || $status == "bitacora_trs" || $status == "bitacora_zi"
        ) {
            $query = "SELECT $status FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $valorStatus = $i[$status];
                    $array['status'] = $valorStatus;
                }
                if ($valorStatus == 1) {
                    $query = "UPDATE t_mp_planificacion_iniciada SET $status = '0' WHERE id = $idOT and activo = 1";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $array['respuesta'] = "DESACTIVADO";
                    }
                } else {
                    $query = "UPDATE t_mp_planificacion_iniciada SET $status = '1' WHERE id = $idOT and activo = 1";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $array['respuesta'] = "ACTIVADO";
                    }
                }
            }
        } elseif ($status == "status") {
            $query = "SELECT id, semana, id_plan, id_equipo, año FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $idOT = $i['id'];
                    $semana = $i['semana'];
                    $idPlan = $i['id_plan'];
                    $idEquipo = $i['id_equipo'];
                    $año = $i['año'];
                }
                $query = "UPDATE t_mp_planificacion_iniciada SET status = 'SOLUCIONADO', fecha_finalizado = '$fechaActual'  WHERE id = $idOT and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {

                    $query = "UPDATE t_mp_planeacion_proceso SET semana_$semana = 'SOLUCIONADO' 
                    WHERE id_plan = $idPlan and id_equipo = $idEquipo and año = $año and semana_$semana ='PROCESO'";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $array['respuesta'] = "SOLUCIONADO";
                        $array['idOT'] = $idOT;
                    }
                }
            }
        } elseif ($status == "status_material") {
            $cod2bend = $_GET['cod2bend'];
            $query = "SELECT status_material FROM  t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                $status = 1;
                foreach ($result as $x) {
                    $status = $x['status_material'];
                }

                if ($status == 1) {
                    $status = 0;
                } else {
                    $status = 1;
                }

                $query = "UPDATE t_mp_planificacion_iniciada SET status_material = $status, cod2bend = '$cod2bend'  
                WHERE id = $idOT and activo = 1";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $array['respuesta'] = "ACTIVADO";
                }
            }
        }
        echo json_encode($array);
    }

    if ($action == "actividadRealizadaOT") {
        $idOT = $_GET['idOT'];
        $idActividad = intval($_GET['idActividad']);
        $tipoActividadTemp = $_GET['tipoActividad'];
        $valor = $_GET['valor'];
        $actividades = "";
        $array = array();
        $contador = 0;

        if ($tipoActividadTemp == "actividad") {
            $tipoActividad = "actividades_preventivo_realizadas";
        } elseif ($tipoActividadTemp == "checkList") {
            $tipoActividad = "actividades_check_realizadas";
        } elseif ($tipoActividadTemp == "test") {
            $tipoActividad = "actividades_test_realizadas";
        }


        $query = "SELECT $tipoActividad FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {

            if ($tipoActividadTemp == "test") {
                foreach ($result as $i) {

                    $actividades = $i[$tipoActividad];
                    if ($actividades != "") {
                        $actividades = explode(';', $actividades);

                        foreach ($actividades as $x => $value) {
                            $actividades_2 = explode("=", $value);
                            if ($actividades_2[0] == $idActividad) {
                                $key = $x;
                            }
                        }

                        if ($key >= 0) {
                            unset($actividades[$key]);
                            $actividades[] = "$idActividad=$valor";
                            $actividades = implode(";", $actividades);
                            $query = "UPDATE t_mp_planificacion_iniciada SET actividades_test_realizadas = '$actividades' WHERE id = $idOT and activo = 1";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $array[] = "Actualizado";
                            }
                        }
                    } else {
                        $query = "UPDATE t_mp_planificacion_iniciada SET actividades_test_realizadas = '$idActividad=$valor' WHERE id = $idOT and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $array[] = "Actualizado";
                        }
                    }
                }
            } elseif ($tipoActividadTemp == "checkList") {
                foreach ($result as $i) {

                    $actividades = $i[$tipoActividad];
                    if ($actividades != "") {
                        $actividades = explode(';', $actividades);

                        foreach ($actividades as $x => $value) {
                            $actividades_2 = explode("=", $value);
                            if ($actividades_2[0] == $idActividad) {
                                $key = $x;
                            }
                        }

                        if ($key >= 0) {
                            unset($actividades[$key]);
                            $actividades[] = "$idActividad=$valor";
                            $actividades = implode(";", $actividades);
                            $query = "UPDATE t_mp_planificacion_iniciada SET actividades_check_realizadas = '$actividades' WHERE id = $idOT and activo = 1";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $array[] = "Actualizado";
                            }
                        }
                    } else {
                        $query = "UPDATE t_mp_planificacion_iniciada SET actividades_check_realizadas = '$idActividad=$valor' WHERE id = $idOT and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $array[] = "Actualizado";
                        }
                    }
                }
            } elseif ($tipoActividadTemp == "actividad") {
                foreach ($result as $i) {
                    $actividades = $i[$tipoActividad];

                    if ($actividades != "") {
                        $actividades = explode(';', $actividades);

                        foreach ($actividades as $x => $value) {
                            if ($value == $idActividad) {
                                $contador++;
                                $key = $x;
                            }
                        }

                        if ($contador > 0) {
                            unset($actividades[$key]);
                            $actividades = implode(";", $actividades);
                            $query = "UPDATE t_mp_planificacion_iniciada SET actividades_preventivo_realizadas = '$actividades' WHERE id = $idOT and activo = 1";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $array[] = "Actualizado";
                            }
                        } else {
                            $actividades[] = "$idActividad";
                            $actividades = implode(";", $actividades);
                            $query = "UPDATE t_mp_planificacion_iniciada SET actividades_preventivo_realizadas = '$actividades' WHERE id = $idOT and activo = 1";
                            if ($result = mysqli_query($conn_2020, $query)) {
                                $array[] = "Actualizado";
                            }
                        }
                    } else {
                        $query = "UPDATE t_mp_planificacion_iniciada SET actividades_preventivo_realizadas = '$idActividad' WHERE id = $idOT and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $array[] = "Actualizado";
                        }
                    }
                }
            }
        }
        echo json_encode($array);
    }


    if ($action == "consultarActividadRealizadaOT") {
        $idOT = $_GET['idOT'];
        $array = array();

        $query = "SELECT actividades_preventivo_realizadas, actividades_check_realizadas, actividades_test_realizadas  
        FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $actividades = $i['actividades_preventivo_realizadas'];
                $check = $i['actividades_check_realizadas'];
                $test = $i['actividades_test_realizadas'];

                $array['actividades'] = $actividades;
                $array['check'] = $check;
                $array['test'] = $test;
            }
            echo json_encode($array);
        }
    }


    // Obtiene responsables asignados
    if ($action == "consultaResponsablesOT") {
        $idOT = $_GET['idOT'];
        $array = array();

        $query = "SELECT id_responsables FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $idResponsables = $i['id_responsables'];
                $query = "SELECT t_users.id, t_colaboradores.nombre, t_colaboradores.apellido
                FROM t_users
                LEFT JOIN t_colaboradores ON t_users.id_colaborador = t_colaboradores.id
                WHERE t_users.id IN($idResponsables)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $idUsuario = $i['id'];
                        $nombre = $i['nombre'];
                        $apellido = $i['apellido'];

                        $responsablesTemp = array("idUsuario" => $idUsuario, "nombre" => $nombre, "apellido" => $apellido);
                        $array[] = $responsablesTemp;
                    }
                }
            }
        }
        echo json_encode($array);
    }

    if ($action == "eliminarResponsbleOT") {
        $idOT = $_GET['idOT'];
        $idResponsable = $_GET['idResponsable'];
        $array = array();
        $contador = 0;

        $query = "SELECT id_responsables FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $responsables = $i['id_responsables'];

                if ($responsables != "") {
                    $responsables = explode(',', $responsables);

                    foreach ($responsables as $x => $value) {
                        if ($value == $idResponsable) {
                            $contador++;
                            $key = $x;
                        }
                    }

                    if ($contador > 0) {
                        unset($responsables[$key]);
                        $responsables = implode(",", $responsables);
                        $query = "UPDATE t_mp_planificacion_iniciada SET id_responsables = '$responsables' 
                        WHERE id = $idOT and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $array[] = "Eliminado";
                            notifiacionMP($idOT);
                        }
                    } else {
                        $responsables[] = "$idResponsable";
                        $responsables = implode(",", $responsables);
                        $query = "UPDATE t_mp_planificacion_iniciada SET id_responsables = '$responsables' 
                        WHERE id = $idOT and activo = 1";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            $array[] = "Agregado";
                            notifiacionMP($idOT);
                        }
                    }
                } else {
                    $query = "UPDATE t_mp_planificacion_iniciada SET id_responsables = '$idResponsable' 
                    WHERE id = $idOT and activo = 1";
                    if ($result = mysqli_query($conn_2020, $query)) {
                        $array[] = "Agregado";
                        notifiacionMP($idOT);
                    }
                }
            }
        }
        echo json_encode($array);
    }

    if ($action == "guardarCambiosOT") {
        $idOT = $_GET['idOT'];
        $array = array();
        $comentario = $_GET['comentario'];

        $query = "UPDATE t_mp_planificacion_iniciada SET comentario = '$comentario' WHERE id = $idOT and activo = 1";
        if ($result = mysqli_query($conn_2020, $query)) {
            $array[] = "Actualizado";
        } else {
            $array[] = "NOActualizado";
        }
        echo json_encode($array);
    }


    if ($action == "consultaActividadesOT") {
        $idOT = $_GET['idOT'];
        $array = array();
        $actividades = array();
        $check = array();
        $test = array();

        // ACTIVIDADES NORMALES
        $query = "SELECT actividades_preventivo, actividades_test, actividades_check, actividades_extra FROM t_mp_planificacion_iniciada WHERE id = $idOT and activo =1";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {

                $idActividades = $i['actividades_preventivo'];
                $idTest = $i['actividades_test'];
                $idCheck = $i['actividades_check'];
                $actividadesExtra = $i['actividades_extra'];
                $actividadesExtra = explode(";", $actividadesExtra);

                // Actividades Extra
                $array['actividadesExtra'] = $actividadesExtra;



                // ACTIVIDADES CHECK
                $query = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_checklist WHERE id IN($idCheck)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $id = $i['id'];
                        $tipoActividad = $i['tipo_actividad'];
                        $actividad = $i['descripcion_actividad'];

                        $checkTemp = array("id" => $id, "tipoActividad" => $tipoActividad, "actividad" => $actividad, "medicion" => "");
                        $check[] = $checkTemp;
                    }
                    $array['check'] = $check;
                }

                // ACTIVIDADES TEST
                $query = "SELECT id, tipo_actividad, descripcion_actividad, tipo_medicion FROM t_mp_planes_actividades_test WHERE id IN($idTest)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $id = $i['id'];
                        $tipoActividad = $i['tipo_actividad'];
                        $actividad = $i['descripcion_actividad'];
                        $medicion = $i['tipo_medicion'];

                        $testTemp = array("id" => $id, "tipoActividad" => $tipoActividad, "actividad" => $actividad, "medicion" => $medicion);
                        $test[] = $testTemp;
                    }
                    $array['test'] = $test;
                }

                // ACTIVIDADES PREVENTIVO
                $query = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_preventivos WHERE id IN($idActividades)";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $i) {
                        $id = $i['id'];
                        $tipoActividad = $i['tipo_actividad'];
                        $actividad = $i['descripcion_actividad'];

                        $actividadesTemp = array("id" => $id, "tipoActividad" => $tipoActividad, "actividad" => $actividad, "medicion" => "");
                        $actividades[] = $actividadesTemp;
                    }
                    $array['actividades'] = $actividades;
                }
            }
            echo json_encode($array);
        }
    }
}
