<?php
// Se establece la Zona Horaria.
date_default_timezone_set('America/Cancun');
setlocale(LC_MONETARY, 'es_ES');

// Modulo para importar la Conxión a la DB.
include '../../php/conexion.php';

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $idUsuario = $_POST['idUsuario'];
    $idDestino = $_POST['idDestino'];
    $fechaActual = date('Y-m-D H:m:s');

    if ($action == "GENERAROT") {
        $idEquipo = $_POST['idEquipo'];
        $idPlan = $_POST['idPlan'];
        $semanaX = $_POST['semanaX'];
        $data = array();
        $año = date('Y');

        // idActividades;
        $idActividades = 0;
        $idTest = 0;
        $idCheck = 0;
        $actividades = "";
        $contador = 0;
        $materiales = "";

        $query = "SELECT t_mp_planificacion_iniciada.id, t_equipos_america.equipo, 
        t_mp_planificacion_iniciada.semana, t_mp_planificacion_iniciada.año, t_mp_planificacion_iniciada.fecha_creacion, t_mp_planificacion_iniciada.comentario,
        c_secciones.seccion,
        c_subsecciones.grupo, 
        c_destinos.destino, 
        t_mp_planes_mantenimiento.tipo_plan, 
        t_mp_planes_mantenimiento.grado,
        t_mp_planes_mantenimiento.descripcion,
        c_frecuencias_mp.frecuencia,
        t_mp_planificacion_iniciada.actividades_preventivo,
        t_mp_planificacion_iniciada.actividades_test,
        t_mp_planificacion_iniciada.actividades_check,
        t_mp_planificacion_iniciada.status,
        t_mp_planificacion_iniciada.id_responsables,
        t_equipos_america.id_equipo_principal
        FROM t_mp_planificacion_iniciada 
        INNER JOIN t_equipos_america ON t_mp_planificacion_iniciada.id_equipo = t_equipos_america.id
        INNER JOIN c_secciones ON t_equipos_america.id_seccion = c_secciones.id
        INNER JOIN c_subsecciones ON t_equipos_america.id_subseccion = c_subsecciones.id
        INNER JOIN c_destinos ON t_equipos_america.id_destino = c_destinos.id
        INNER JOIN t_mp_planes_mantenimiento ON t_mp_planificacion_iniciada.id_plan =t_mp_planes_mantenimiento.id 
        INNER JOIN c_frecuencias_mp ON t_mp_planes_mantenimiento.id_periodicidad = c_frecuencias_mp.id
        WHERE t_mp_planificacion_iniciada.id_equipo = $idEquipo and t_mp_planificacion_iniciada.id_plan = $idPlan and t_mp_planificacion_iniciada.semana = $semanaX and t_mp_planificacion_iniciada.año = '$año' and t_mp_planificacion_iniciada.activo = 1 and t_mp_planificacion_iniciada.status IN('PROCESO', 'SOLUCIONADO')";

        if ($result = mysqli_query($conn_2020, $query)) {
            foreach ($result as $i) {
                $id = $i['id'];
                $equipo = $i['equipo'];
                $idEquipoPrincipal = $i['id_equipo_principal'];
                $seccion = $i['seccion'];
                $grupo = $i['grupo'];
                $destino = $i['destino'];
                $comentario = $i['comentario'];
                $tipo_plan = $i['tipo_plan'];
                $grado = $i['grado'];
                $semana = $i['semana'];
                $año = $i['año'];
                $fecha_creacion = (new DateTime($i['fecha_creacion']))->format('d/m/Y');
                $frecuencia = $i['frecuencia'];
                $descripcion = $i['descripcion'];
                $status = $i['status'];
                $idActividades = $i['actividades_preventivo'];
                $idTest = $i['actividades_test'];
                $idCheck = $i['actividades_check'];
                $idResponsables = $i['id_responsables'];

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

                #EQUIPO PRINCIPAL
                $equipoPrincial = "";
                $query = "SELECT equipo FROM t_equipos_america WHERE id = $idEquipoPrincipal";
                if ($result = mysqli_query($conn_2020, $query)) {
                    foreach ($result as $x) {
                        $equipoPrincial = $x['equipo'];
                    }
                }

                $data['id'] = $id;
                $data['equipo'] = $equipo;
                $data['equipoPrincial'] = $equipoPrincial;
                $data['seccion'] = $seccion;
                $data['grupo'] = $grupo;
                $data['destino'] = $destino;
                $data['comentario'] = $comentario;
                $data['tipo_plan'] = $tipo_plan;
                $data['grado'] = $grado;
                $data['semana'] = $semana;
                $data['año'] = $año;
                $data['fecha_creacion'] = $fecha_creacion;
                $data['frecuencia'] = $frecuencia;
                $data['descripcion'] = $descripcion;
                $data['status'] = $status;
                $data['responsable'] = $responsable;
            }

            $query = "SELECT id, descripcion_actividad FROM t_mp_planes_actividades_preventivos WHERE id IN($idActividades)";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $id = $i['id'];
                    $actividad = $i['descripcion_actividad'];

                    $actividades .= "
                        <div id=\"$id\" class=\"flex flex-row justify-start items-center uppercase w-full border-b cursor-pointer text-gray-700\">
                            <div class=\"mr-2 flex items-center justify-center font-bold text-base leading-none \">
                                <h1>$contador</h1>
                            </div>
                            <!-- CHECK -->
                            <div id=\"" . $id . "check1\" class=\"w-4 h-4 rounded-full border-gray-500 shadow-md mr-1 flex items-center justify-center\" style=\"border-width: 1.5px;\">
                                <div id=\"123check2\" class=\"invisible w-full flex items-center justify-center text-white\">
                                    <svg class=\"w-2 fill-current\" version=\"1.1\" id=\"Capa_1\" focusable=\"false\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 512 512\" style=\"enable-background:new 0 0 512 512;\" xml:space=\"preserve\">
                                        <g>
                                            <path class=\"st0\" d=\"M192,452.4c-8.3,0-16.1-3.2-22-9.1L3.6,276.9c-12.1-12.1-12.1-31.9,0-44l36.2-36.2c5.9-5.9,13.7-9.1,22-9.1
                                    s16.1,3.2,22,9.1L192,304.9L428.2,68.7c5.9-5.9,13.7-9.1,22-9.1s16.1,3.2,22,9.1l36.2,36.2c12.1,12.1,12.1,31.9,0,44L214,443.3
                                    C208.1,449.2,200.3,452.4,192,452.4z\" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <!-- CHECK -->
                            <div class=\"w-full\">
                                <h1 id=\"" . $id . "actividad\" class=\"leading-snug text-justify font-bold text-xs normal-case \">$actividad</h1>
                            </div>
                        </div>
                    ";
                }
            }

            $query = "SELECT id, descripcion_actividad FROM t_mp_planes_actividades_test WHERE id IN($idTest)";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $id = $i['id'];
                    $actividad = $i['descripcion_actividad'];

                    $actividades .= "
                        <div id=\"$id\" class=\"flex flex-row justify-start items-center uppercase w-full border-b cursor-pointer text-gray-700\">
                            <div class=\"mr-2 flex items-center justify-center font-bold text-base leading-none \">
                                <h1>$contador</h1>
                            </div>
                            <!-- CHECK -->
                            <div id=\"" . $id . "check1\" class=\"w-4 h-4 rounded-full border-gray-500 shadow-md mr-1 flex items-center justify-center\" style=\"border-width: 1.5px;\">
                                <div id=\"123check2\" class=\"invisible w-full flex items-center justify-center text-white\">
                                    <svg class=\"w-2 fill-current\" version=\"1.1\" id=\"Capa_1\" focusable=\"false\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 512 512\" style=\"enable-background:new 0 0 512 512;\" xml:space=\"preserve\">
                                        <g>
                                            <path class=\"st0\" d=\"M192,452.4c-8.3,0-16.1-3.2-22-9.1L3.6,276.9c-12.1-12.1-12.1-31.9,0-44l36.2-36.2c5.9-5.9,13.7-9.1,22-9.1
                                    s16.1,3.2,22,9.1L192,304.9L428.2,68.7c5.9-5.9,13.7-9.1,22-9.1s16.1,3.2,22,9.1l36.2,36.2c12.1,12.1,12.1,31.9,0,44L214,443.3
                                    C208.1,449.2,200.3,452.4,192,452.4z\" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <!-- CHECK -->
                            <div class=\"w-full\">
                                <h1 id=\"" . $id . "actividad\" class=\"leading-snug text-justify font-bold text-xs normal-case \">$actividad _____________</h1>
                            </div>
                        </div>
                    ";
                }
            }

            $query = "SELECT id, descripcion_actividad FROM t_mp_planes_actividades_checklist WHERE id IN($idCheck)";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $contador++;
                    $id = $i['id'];
                    $actividad = $i['descripcion_actividad'];

                    $actividades .= "
                        <div id=\"$id\" class=\"flex flex-row justify-start items-center uppercase w-full border-b cursor-pointer text-gray-700\">
                            <div class=\"mr-2 flex items-center justify-center font-bold text-base leading-none \">
                                <h1>$contador</h1>
                            </div>
                            <!-- CHECK -->
                            <div id=\"" . $id . "check1\" class=\"w-4 h-4 rounded-full border-gray-500 shadow-md mr-1 flex items-center justify-center\" style=\"border-width: 1.5px;\">
                                <div id=\"123check2\" class=\"invisible w-full flex items-center justify-center text-white\">
                                    <svg class=\"w-2 fill-current\" version=\"1.1\" id=\"Capa_1\" focusable=\"false\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\" viewBox=\"0 0 512 512\" style=\"enable-background:new 0 0 512 512;\" xml:space=\"preserve\">
                                        <g>
                                            <path class=\"st0\" d=\"M192,452.4c-8.3,0-16.1-3.2-22-9.1L3.6,276.9c-12.1-12.1-12.1-31.9,0-44l36.2-36.2c5.9-5.9,13.7-9.1,22-9.1
                                    s16.1,3.2,22,9.1L192,304.9L428.2,68.7c5.9-5.9,13.7-9.1,22-9.1s16.1,3.2,22,9.1l36.2,36.2c12.1,12.1,12.1,31.9,0,44L214,443.3
                                    C208.1,449.2,200.3,452.4,192,452.4z\" />
                                        </g>
                                    </svg>
                                </div>
                            </div>
                            <!-- CHECK -->
                            <div class=\"w-full\">
                                <h1 id=\"" . $id . "actividad\" class=\"leading-snug text-justify font-bold text-xs normal-case \">$actividad _____________</h1>
                            </div>
                        </div>
                    ";
                }
            }

            $query = "SELECT t_mp_planes_materiales.id, t_mp_planes_materiales.id_item_global, t_mp_planes_materiales.cantidad_material, t_subalmacenes_items_globales.descripcion_cod2bend
            FROM t_mp_planes_materiales 
            INNER JOIN t_subalmacenes_items_globales ON t_mp_planes_materiales.id_item_global = t_subalmacenes_items_globales.id
            WHERE t_mp_planes_materiales.id_plan = $idPlan and t_mp_planes_materiales.status = 'ACTIVO' and t_mp_planes_materiales.activo = 1";
            if ($result = mysqli_query($conn_2020, $query)) {
                foreach ($result as $i) {
                    $id = $i['id_item_global'];
                    $cantidad = $i['cantidad_material'];
                    $material = $i['descripcion_cod2bend'];

                    $materiales .= "
                        <div class=\"flex flex-row justify-start items-center uppercase w-full mb-2 border-b p-1 cursor-pointer\">
                            <div class=\"mr-2 flex items-center justify-center leading-none\">
                                <h1>$cantidad</h1>
                            </div>
                            <div class=\"mr-2 flex items-center justify-center leading-none\">
                                <h1>PZA</h1>
                            </div>
                            <div class=\"mr-2 flex items-center justify-center leading-none\">
                                <h1>$id</h1>
                            </div>
                            <div class=\"w-full\">
                                <h1 class=\"leading-snug text-justify\">$material</h1>
                            </div>
                        </div>
                    ";
                }
            }

            $data['materiales'] = $materiales;
            $data['actividades'] = $actividades;
        }
        echo json_encode($data);
    }
}
