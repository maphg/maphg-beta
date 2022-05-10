<?php
class AuditoriaProyectos extends Conexion
{
    public static function all($idDestino)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT p.id 'idProyecto', s.seccion, p.titulo 'proyecto', CONCAT(c.nombre, ' ', c.apellido) 'responsable'
        FROM t_proyectos AS p
        INNER JOIN c_secciones AS s ON p.id_seccion = s.id
        LEFT JOIN t_users AS u ON p.responsable = u.id
        LEFT JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE p.id_destino = ? and p.titulo LIKE '%AUDITORIA%'  and p.activo = 1 ORDER BY p.id ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idDestino);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $idProyecto = intval($x['idProyecto']);

            $tareas = AuditoriaProyectos::tareas($idProyecto);
            $totalTareas = 0;
            $solucionasTareas = 0;
            $pendientesTareas = 0;
            $aprobadasTareas = 0;
            $porAprobarTareas = 0;
            $porcentajeTareas = 0;

            // TAREAS DEL PROYECTO
            foreach ($tareas as $y) {
                $totalTareas++;

                if ($y['status'] == "SOLUCIONADA") $solucionasTareas++;


                if ($y['status'] == "PENDIENTE") $pendientesTareas++;
            }

            #PORCENTAJE SOLUCIONADAS
            if ($totalTareas > 0)
                $porcentajeTareas = (100 / $totalTareas) * $solucionasTareas;


            $x['totalTareas'] = $totalTareas;
            $x['solucionasTareas'] = $solucionasTareas;
            $x['pendientesTareas'] = $pendientesTareas;
            $x['aprobadasTareas'] = $aprobadasTareas;
            $x['porAprobarTareas'] = $porAprobarTareas;
            $x['porcentajeTareas'] = $porcentajeTareas;
            $x['tareas'] = $tareas;

            #RESULTADO FINAL DE PROYECTOS
            $array[] = $x;
        }

        return $array;
    }


    public static function tareas($idProyecto)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT t.id 'idTarea', t.actividad 'tarea',
        CONCAT(c.nombre, ' ', c.apellido) 'responsable', t.status
        FROM t_proyectos_planaccion AS t
        LEFT JOIN t_users AS u ON t.responsable = u.id
        LEFT JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE t.id_proyecto = ? and t.activo = 1 ORDER BY t.id ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idProyecto);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $idTarea = $x['idTarea'];

            if ($x['status'] == "F" || $x['status'] == "FINALIZADO" || $x['status'] == "SOLUCIONADO") {
                $x['status'] = "SOLUCIONADA";
            } else {
                $x['status'] = "PENDIENTE";
            }

            $x['adjuntos'] = AuditoriaProyectos::adjuntos($idTarea);
            $array[] = $x;
        }

        #RESULTADO FINAL DE PROYECTOS
        return $array;
    }


    public static function adjuntos($idTarea)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT id 'idAdjunto', url_adjunto 'url'
        FROM t_proyectos_planaccion_adjuntos
        WHERE id_actividad = ? and status = 1
        ORDER BY id ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idTarea);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        $path = "_PATH/";
        if (strpos($_SERVER['REQUEST_URI'], "america") == true)
            $path = "https://www.maphg.com/planner/proyectos/";
        if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
            $path = "https://www.maphg.com/planner/proyectos/";

        foreach ($response as $x) {
            $x['posicion'] = "PRINCIPAL";
            $x['url'] = $path . $x['url'];

            $array[] = $x;
        }

        #RESULTADO FINAL DE PROYECTOS
        return $array;
    }
}
