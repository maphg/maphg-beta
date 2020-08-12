<?php
// Horario
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Conexion para la DB.
include '../../php/conexion.php';

if (isset($_POST['action'])) {

    // Varibles Globales.
    $action = $_POST['action'];
    $idDestino = $_POST['idDestino'];
    $idUsuario = $_POST['idUsuario'];
    $fechaActual = date('Y-m-d H:m:s');

    if ($action == "obtenerPlanesMP") {
        // { idPlanMP: 1, destino: 'rm', marca: 'ZI', tipoEquipo: 'Fan&coil', tipoPlan: 'PREVENTIVO', grado: 'MAYOR', periodicidad: 'Semestral' }
        $data = array();
        $palabraBuscar = $_POST['palabraBuscar'];
        $tipoOrden = $_POST['tipoOrden'];

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND t_mp_planes_mantenimiento.id_destino = $idDestino";
        }

        if ($palabraBuscar == "") {
            $filtroPalabraBuscar = "";
        } else {
            $filtroPalabraBuscar = "AND(c_destinos.destino LIKE '%$palabraBuscar%' OR c_fases.fase LIKE '%$palabraBuscar%' OR c_tipos.tipo LIKE '%$palabraBuscar%' OR t_mp_planes_mantenimiento.tipo_plan LIKE '%$palabraBuscar%' OR c_frecuencias_mp.frecuencia LIKE '%$palabraBuscar%')";
        }

        if ($tipoOrden == "ORDENID") {
            $filtroOrdenar = "ORDER BY t_mp_planes_mantenimiento.id ASC";
        } elseif ($tipoOrden == "ORDENARDESTINO") {
            $filtroOrdenar = "ORDER BY c_destinos.destino ASC";
        } elseif ($tipoOrden == "ORDENARMARCA") {
            $filtroOrdenar = "ORDER BY c_fases.fase ASC";
        } elseif ($tipoOrden == "ORDENARTIPO") {
            $filtroOrdenar = "ORDER BY c_tipos.tipo ASC";
        } elseif ($tipoOrden == "ORDENARPLAN") {
            $filtroOrdenar = "ORDER BY t_mp_planes_mantenimiento.tipo_plan ASC";
        } elseif ($tipoOrden == "ORDENARGRADO") {
            $filtroOrdenar = "ORDER BY t_mp_planes_mantenimiento.grado ASC";
        } elseif ($tipoOrden == "ORDENARPERIODICIDAD") {
            $filtroOrdenar = "ORDER BY c_frecuencias_mp.id ASC";
        } else {
            $filtroOrdenar = "ORDER BY c_destinos.destino ASC";
        }

        $query  = "SELECT 
        c_destinos.destino, 
        t_mp_planes_mantenimiento.id, 
        c_fases.fase,
        c_tipos.tipo,
        t_mp_planes_mantenimiento.tipo_plan,
        t_mp_planes_mantenimiento.grado,
        c_frecuencias_mp.frecuencia
        FROM t_mp_planes_mantenimiento 
        INNER JOIN c_destinos ON t_mp_planes_mantenimiento.id_destino = c_destinos.id
        INNER JOIN c_fases ON t_mp_planes_mantenimiento.id_fase = c_fases.id
        INNER JOIN c_tipos ON t_mp_planes_mantenimiento.tipo_local_equipo = c_tipos.id
        INNER JOIN c_frecuencias_mp ON t_mp_planes_mantenimiento.id_periodicidad = c_frecuencias_mp.id
        WHERE t_mp_planes_mantenimiento.status = 'ACTIVO' AND t_mp_planes_mantenimiento.activo = 1 $filtroDestino 
        $filtroPalabraBuscar 
        $filtroOrdenar 
        ";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idPlanMP = $value['id'];
                $destino = $value['destino'];
                $fase = $value['fase'];
                $tipo = $value['tipo'];
                $tipoPlan = $value['tipo_plan'];
                $grado = $value['grado'];
                $periodicidad = $value['frecuencia'];

                $dataAux = array("idPlanMP" => "$idPlanMP", "destino" => "$destino", "marca" => "$fase", "tipoEquipo" => "$tipo", "tipoPlan" => "$tipoPlan", "grado" => "$grado", "periodicidad" => "$periodicidad");
                $data[] = $dataAux;
            }
        } else {
            $data['error'] = "Error";
        }
        echo json_encode($data);
    }


    if ($action == "obtenerOpcionesPlanMP") {
        $data = array();
        $dataDestinos = "";
        $dataFases = "";
        $dataTipos = "";
        $dataFrecuencia = "";

        if ($idDestino == 10) {
            $filtroDestino = "";
        } else {
            $filtroDestino = "AND id = $idDestino";
        }

        // Obtienes las opciones para los destinos.
        $query = "SELECT id, destino FROM c_destinos WHERE status = 'A' $filtroDestino 
        ORDER BY destino DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idDestino = $value['id'];
                $destino = $value['destino'];
                $dataDestinos .= "<option value=\"$idDestino\">$destino</option>";
            }
            $data['dataDestinos'] = $dataDestinos;
        }

        // obtienen las Fases.GP, TRS, ZI etc.
        $query = "SELECT id, fase FROM c_fases WHERE status = 'A' 
        ORDER BY fase ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idFase = $value['id'];
                $fase = $value['fase'];
                $dataFases .= "<option value=\"$idFase\">$fase</option>";
            }
            $data['dataFases'] = $dataFases;
        }

        // obtienen Tipos de Equipos/Local.
        $query = "SELECT id, tipo FROM c_tipos WHERE status = 'A' 
        ORDER BY tipo ASC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idTipo = $value['id'];
                $tipo = $value['tipo'];
                $dataTipos .= "<option value=\"$idTipo\">$tipo</option>";
            }
            $data['dataTipos'] = $dataTipos;
        }

        // obtienen La frecuencia de MP.
        #Agregar columna status:'A'
        $query = "SELECT id, frecuencia FROM c_frecuencias_mp WHERE status = 'A' 
        ORDER BY id DESC";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idFrecuencia = $value['id'];
                $frecuencia = $value['frecuencia'];
                $dataFrecuencia .= "<option value=\"$idFrecuencia\">$frecuencia</option>";
            }
            $data['dataFrecuencia'] = $dataFrecuencia;
        }
        echo json_encode($data);
    }


    if ($action == "obtenerDetallesPlanMP") {
        $data = array();
        $dataActividades = "";
        $idPlanMP = $_POST['idPlanMP'];
        $query = "SELECT t_mp_planes_mantenimiento.id, t_mp_planes_mantenimiento.id_fase, t_mp_planes_mantenimiento.local_equipo, t_mp_planes_mantenimiento.tipo_local_equipo, t_mp_planes_mantenimiento.tipo_plan, t_mp_planes_mantenimiento.grado, t_mp_planes_mantenimiento.descripcion, t_mp_planes_mantenimiento.numero_personas_requeridas,
        c_frecuencias_mp.id 'idPeriodicidad',
        c_destinos.id 'idDestino'
        FROM t_mp_planes_mantenimiento
        LEFT JOIN c_frecuencias_mp ON t_mp_planes_mantenimiento.id_periodicidad = c_frecuencias_mp.id
        LEFT JOIN c_destinos ON t_mp_planes_mantenimiento.id_destino = c_destinos.id
        WHERE t_mp_planes_mantenimiento.id = $idPlanMP";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idPlanMP = $value['id'];
                $idFase = $value['id_fase'];
                $local_equipo = $value['local_equipo'];
                $tipo_local_equipo = $value['tipo_local_equipo'];
                $tipoPlan = $value['tipo_plan'];
                $grado = $value['grado'];
                $idPeriodicidad = $value['idPeriodicidad'];
                $idDestino = $value['idDestino'];
                $descripcion = $value['descripcion'];
                $personas = $value['numero_personas_requeridas'];

                $data['idPlanMP'] = $idPlanMP;
                $data['idFase'] = $idFase;
                $data['local_equipo'] = $local_equipo;
                $data['tipo_local_equipo'] = $tipo_local_equipo;
                $data['tipoPlan'] = $tipoPlan;
                $data['grado'] = $grado;
                $data['idPeriodicidad'] = $idPeriodicidad;
                $data['idDestino'] = $idDestino;
                $data['descripcion'] = $descripcion;
                $data['personas'] = $personas;
            }
        }

        $queryPreventivo = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_preventivos WHERE id_plan = $idPlanMP AND status = 'ACTIVO'";

        $queryCheck = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_checklist WHERE id_plan = $idPlanMP AND status = 'ACTIVO'";

        $queryTest = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_test WHERE id_plan = $idPlanMP AND status = 'ACTIVO'";

        if ($resultPreventivo = mysqli_query($conn_2020, $queryPreventivo) and $resultCheck = mysqli_query($conn_2020, $queryCheck) and $resultTest = mysqli_query($conn_2020, $queryTest)) {

            foreach ($resultPreventivo as $value) {
                $id = $value['id'];
                $tipoActividad = $value['tipo_actividad'];
                $descripcion = $value['descripcion_actividad'];

                $dataActividades .= "
                    <div onclick=\"obtenerActividadPlanMP($id, 't_mp_planes_actividades_preventivos');\" class=\"w-full bg-blue-200 text-blue-500 rounded-md p-2 text-left font-bold uppercase text-sm  mb-2 shadow cursor-pointer flex flex-row flex-wrap\">
                        <h1><span class=\"px-2 text-xs font-bold rounded-full bg-blue-500 text-blue-100 mr-1 uppercase\">ACTIVIDAD</span>$descripcion</h1>
                    </div>
                ";
            }

            foreach ($resultCheck as $value) {
                $id = $value['id'];
                $tipoActividad = $value['tipo_actividad'];
                $descripcion = $value['descripcion_actividad'];

                $dataActividades .= "
                    <div onclick=\"obtenerActividadPlanMP($id, 't_mp_planes_actividades_checklist');\" class=\"w-full bg-purple-200 text-purple-500 rounded-md p-2 text-left font-bold uppercase text-sm  mb-2 shadow cursor-pointer flex flex-row flex-wrap\">
                        <h1><span class=\"px-2 text-xs font-bold rounded-full bg-purple-500 text-purple-100 mr-1 uppercase\">CHECKLIST</span>$descripcion</h1>
                    </div>
                ";
            }

            foreach ($resultTest as $value) {
                $id = $value['id'];
                $tipoActividad = $value['tipo_actividad'];
                $descripcion = $value['descripcion_actividad'];

                $dataActividades .= "
                    <div onclick=\"obtenerActividadPlanMP($id, 't_mp_planes_actividades_test');\" class=\"w-full bg-orange-200 text-orange-500 rounded-md p-2 text-left font-bold uppercase text-sm  mb-2 shadow cursor-pointer flex flex-row flex-wrap\">
                        <h1><span class=\"px-2 text-xs font-bold rounded-full bg-orange-500 text-orange-100 mr-1 uppercase\">TEST</span>$descripcion</h1>
                    </div>
                ";
            }

            $data['dataActividades'] = $dataActividades;
        }

        echo json_encode($data);
    }


    if ($action == "guardarCambiosPlanMP") {
        $data = array();

        $idPlanMP = $_POST['idPlanMP'];
        $status = $_POST['status'];
        $idDestinoSeleccionado = $_POST['idDestinoSeleccionado'];
        $opcionFase = $_POST['opcionFase'];
        $localEquipo = $_POST['localEquipo'];
        $tipoEquipo = $_POST['tipoEquipo'];
        $tipoPlan = $_POST['tipoPlan'];
        $gradoPlan = $_POST['gradoPlan'];
        $periodicidad = $_POST['periodicidad'];
        $personas = $_POST['personas'];
        $observacion = $_POST['observacion'];

        $query = "UPDATE t_mp_planes_mantenimiento SET id_fase = $opcionFase, local_equipo = '$localEquipo', tipo_local_equipo = '$tipoEquipo', tipo_plan = '$tipoPlan', grado = '$gradoPlan', id_periodicidad = $periodicidad, id_destino = $idDestinoSeleccionado, descripcion = '$observacion', numero_personas_requeridas = $personas, status = '$status'
        WHERE id = $idPlanMP";
        if ($result  = mysqli_query($conn_2020, $query) and $status == "ACTIVO") {
            $data['respuesta'] = 1;
        } elseif ($result  = mysqli_query($conn_2020, $query) and $status == "BAJA") {
            $data['respuesta'] = 2;
        } else {
            $data['respuesta'] = 0;
        }
        echo json_encode($data);
    }



    if ($action == "AgregarPlanMP") {
        $idPlanResult = 0;
        $query = "SELECT id FROM t_mp_planes_mantenimiento WHERE creado_por = $idUsuario AND status = 'PENDIENTE'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idPlanResult = intval($value['id']);
            }

            if ($idPlanResult > 0) {
                echo $idPlanResult;
            } else {
                $query = "SELECT max(id) FROM t_mp_planes_mantenimiento";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $value) {
                        $nuevoIdPlan = intval($value['max(id)'] + 1);
                        $query = "INSERT INTO t_mp_planes_mantenimiento(id, id_destino, creado_por, fecha_creado, status) VALUES($nuevoIdPlan, $idDestino, $idUsuario, '$fechaActual', 'PENDIENTE')";
                        if ($result = mysqli_query($conn_2020, $query)) {
                            echo $nuevoIdPlan;
                        }
                    }
                }
            }
        } else {
            echo 0;
        }
    }


    if ($action == "obtenerActividadPlanMP") {
        $data = array();
        $idActividadMP = $_POST['idActividadMP'];
        $tipoActividad = $_POST['tipoActividad'];
        $query = "SELECT id, id_plan, descripcion_actividad, tipo_actividad, promedio_ejecucion FROM $tipoActividad WHERE id = $idActividadMP AND status = 'ACTIVO'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idActividad = $value['id'];
                $idPlanMP = $value['id_plan'];
                $actividad = $value['descripcion_actividad'];
                $tipoActividad = $value['tipo_actividad'];
                $promedio = $value['promedio_ejecucion'];

                $data['idActividad'] = $idActividad;
                $data['idPlanMP'] = $idPlanMP;
                $data['actividad'] = $actividad;
                $data['tipoActividad'] = $tipoActividad;
                $data['promedio'] = $promedio;
            }
        }
        echo json_encode($data);
    }


    if ($action == "agregarActividadPlanMP") {
        $data = array();

        $idPlanMP = $_POST['idPlanMP'];
        $actividadPlan = $_POST['actividadPlan'];
        $tipoActividadPlan = $_POST['tipoActividadPlan'];
        $tiempoActividad = $_POST['tiempoActividad'];

        if ($tipoActividadPlan == "actividad") {
            $tabla = "t_mp_planes_actividades_preventivos";
        } elseif ($tipoActividadPlan == "checkList") {
            $tabla = "t_mp_planes_actividades_checklist";
        } elseif ($tipoActividadPlan == "test") {
            $tabla = "t_mp_planes_actividades_test";
        }

        $query = "SELECT id FROM $tabla WHERE id_plan = $idPlanMP AND descripcion_actividad 
        LIKE '$actividadPlan'";
        if ($result = mysqli_query($conn_2020, $query)) {
            if (mysqli_num_rows($result) > 0) {
                $data['resultado'] = 2;
            } else {
                $query = "INSERT INTO $tabla (id_plan, tipo_actividad, descripcion_actividad, creado_por, fecha_creado, promedio_ejecucion, status) 
                VALUES($idPlanMP, '$tipoActividadPlan', '$actividadPlan', $idUsuario, '$fechaActual', $tiempoActividad, 'ACTIVO')";
                if ($result = mysqli_query($conn_2020, $query)) {
                    $data['resultado'] = 1;
                } else {
                    $data['resultado'] = 0;
                }
            }
        } else {
            $data['resultado'] = 0;
        }
        echo json_encode($data);
    }


    if ($action == "actualizarActividadPlanMP") {
        $idActividadPlanMP = $_POST['idActividadPlanMP'];
        $idPlanMP = $_POST['idPlanMP'];
        $actividadPlan = $_POST['actividadPlan'];
        $tipoActividad = $_POST['tipoActividad'];
        $tipoActividadNuevo = $_POST['tipoActividadNuevo'];
        $tiempoActividad = $_POST['tiempoActividad'];
        $tipoActividadNuevoAux = $tipoActividadNuevo;

        if ($tipoActividad == "actividad") {
            $tipoActividad = "t_mp_planes_actividades_preventivos";
        } elseif ($tipoActividad == "checkList") {
            $tipoActividad = "t_mp_planes_actividades_checklist";
        } elseif ($tipoActividad == "test") {
            $tipoActividad = "t_mp_planes_actividades_test";
        }

        if ($tipoActividadNuevo == "actividad") {
            $tipoActividadNuevo = "t_mp_planes_actividades_preventivos";
        } elseif ($tipoActividadNuevo == "checkList") {
            $tipoActividadNuevo = "t_mp_planes_actividades_checklist";
        } elseif ($tipoActividadNuevo == "test") {
            $tipoActividadNuevo = "t_mp_planes_actividades_test";
        }

        if ($tipoActividad == $tipoActividadNuevo) {
            $query = "UPDATE $tipoActividad SET descripcion_actividad = '$actividadPlan', promedio_ejecucion = $tiempoActividad WHERE id = $idActividadPlanMP";
            if ($result = mysqli_query($conn_2020, $query)) {
                echo 1;
            } else {
                echo 0;
            }
        } elseif ($tipoActividad != $tipoActividadNuevo) {
            $query = "UPDATE $tipoActividad SET status='BAJA', activo = 0 WHERE id = $idActividadPlanMP";
            if ($result = mysqli_query($conn_2020, $query)) {
                $query = "INSERT INTO $tipoActividadNuevo(id_plan, tipo_actividad, descripcion_actividad, promedio_ejecucion, creado_por, fecha_creado, status) VALUES($idPlanMP, '$tipoActividadNuevoAux', '$actividadPlan', $tiempoActividad, $idUsuario, '$fechaActual', 'ACTIVO')";
                if ($result = mysqli_query($conn_2020, $query)) {
                    echo 2;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        }
    }









    // Fin se Action.
}