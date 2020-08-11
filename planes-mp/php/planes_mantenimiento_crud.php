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

    if ($action == "agregarActividadMP") {
        echo "ok";
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


    if ($action == "AgregarPlanMP") {
        $data = array();
        $query = "SELECT id FROM t_mp_planes_mantenimiento WHERE creado_por = $idUsuario AND status = 'PENDIENTE'";
        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $value) {
                $idPlanMP = $value['id'];
            }
            if ($idPlanMP != '') {
                $data['idPlanMP'] = $idPlanMP;
            } else {
                $query = "SELECT MAX(id) FROM t_mp_planes_mantenimiento WHERE creado_por = $idUsuario";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $value) {
                        $idPlanMP = $value['id'];
                        $idNuevoPlanMP = $idPlanMP + 1;

                        $query = "INSERT INTO t_mp_planes_mantenimiento(id, id_destino, creado_por,fecha_creado, status) VALUES($idNuevoPlanMP, $idDestino, $idUsuario, '$fechaActual', 'PENDIENTE')";
                        if ($query = mysqli_query($conn_2020, $query)) {
                            $data['idPlanMP'] = $idNuevoPlanMP;
                        }
                    }
                }
            }
        }
        echo json_encode($data);
    }


    if ($action == "agregarActividadPlanMP") {
        $data = array();

        $idPlanMP = $_POST['idPlanMP'];
        $actividadPlan = $_POST['actividadPlan'];
        $tipoActividadPlan = $_POST['tipoActividadPlan'];

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
                $query = "INSERT INTO $tabla (id_plan, tipo_actividad, descripcion_actividad, creado_por, fecha_creado, status) 
                VALUES($idPlanMP, '$tipoActividadPlan', '$actividadPlan', $idUsuario, '$fechaActual', 'ACTIVO')";
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


    if ($action == "obtenerDetallesPlanMP") {
        $data = array();
        $dataActividades = "";
        $idPlanMP = $_POST['idPlanMP'];
        $query = "SELECT t_mp_planes_mantenimiento.id, t_mp_planes_mantenimiento.id_fase, t_mp_planes_mantenimiento.local_equipo, t_mp_planes_mantenimiento.tipo_local_equipo, 
        t_mp_planes_mantenimiento.descripcion, t_mp_planes_mantenimiento.numero_personas_requeridas,
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
                $idPeriodicidad = $value['idPeriodicidad'];
                $idDestino = $value['idDestino'];
                $descripcion = $value['descripcion'];
                $numperoPersonas = $value['numero_personas_requeridas'];

                $data['idPlanMP'] = $idPlanMP;
                $data['idFase'] = $idFase;
                $data['local_equipo'] = $local_equipo;
                $data['tipo_local_equipo'] = $tipo_local_equipo;
                $data['idPeriodicidad'] = $idPeriodicidad;
                $data['idDestino'] = $idDestino;
                $data['descripcion'] = $descripcion;
                $data['numperoPersonas'] = $numperoPersonas;
            }
        }

        $queryPreventivo = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_preventivos WHERE id_plan = $idPlanMP";

        $queryCheck = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_checklist WHERE id_plan = $idPlanMP";

        $queryTest = "SELECT id, tipo_actividad, descripcion_actividad FROM t_mp_planes_actividades_test WHERE id_plan = $idPlanMP";

        if ($resultPreventivo = mysqli_query($conn_2020, $queryPreventivo) and $resultCheck = mysqli_query($conn_2020, $queryCheck) and $resultTest = mysqli_query($conn_2020, $queryTest)) {

            foreach ($resultPreventivo as $value) {
                $id = $value['id'];
                $tipoActividad = $value['tipo_actividad'];
                $descripcion = $value['descripcion_actividad'];

                $dataActividades .= "
                    <div class=\"w-full bg-blue-200 text-blue-500 rounded-md p-2 text-left font-bold uppercase text-sm  mb-2 shadow cursor-pointer flex flex-row flex-wrap\">
                        <h1><span class=\"px-2 text-xs font-bold rounded-full bg-blue-500 text-blue-100 mr-1 uppercase\">ACTIVIDAD</span>$descripcion</h1>
                    </div>
                ";
            }

            foreach ($resultCheck as $value) {
                $id = $value['id'];
                $tipoActividad = $value['tipo_actividad'];
                $descripcion = $value['descripcion_actividad'];

                $dataActividades .= "
                    <div class=\"w-full bg-purple-200 text-purple-500 rounded-md p-2 text-left font-bold uppercase text-sm  mb-2 shadow cursor-pointer flex flex-row flex-wrap\">
                        <h1><span class=\"px-2 text-xs font-bold rounded-full bg-purple-500 text-purple-100 mr-1 uppercase\">CHECKLIST</span>$descripcion</h1>
                    </div>
                ";
            }

            foreach ($resultTest as $value) {
                $id = $value['id'];
                $tipoActividad = $value['tipo_actividad'];
                $descripcion = $value['descripcion_actividad'];

                $dataActividades .= "
                    <div class=\"w-full bg-orange-200 text-orange-500 rounded-md p-2 text-left font-bold uppercase text-sm  mb-2 shadow cursor-pointer flex flex-row flex-wrap\">
                        <h1><span class=\"px-2 text-xs font-bold rounded-full bg-orange-500 text-orange-100 mr-1 uppercase\">TEST</span>$descripcion</h1>
                    </div>
                ";
            }

            $data['dataActividades'] = $dataActividades;
        }

        echo json_encode($data);
    }









    // Fin se Action.
}
