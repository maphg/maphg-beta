<?php
class AuditoriaProyectos extends Conexion
{
    public static function all($destino, $post)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        #FILTRO DESTINOS
        $filtroDestino = "AND p.id_destino = 0";
        if ($destino == "AME") $filtroDestino = "";
        if ($destino == "MEX") $filtroDestino = "AND p.id_destino IN(1,2,7)";
        if ($destino == "RVM") $filtroDestino = "AND p.id_destino IN(1)";
        if ($destino == "PVR") $filtroDestino = "AND p.id_destino IN(2)";
        if ($destino == "CMU") $filtroDestino = "AND p.id_destino IN(7)";
        if ($destino == "DOM") $filtroDestino = "AND p.id_destino IN(5,11)";
        if ($destino == "PUJ") $filtroDestino = "AND p.id_destino IN(5)";
        if ($destino == "CAP") $filtroDestino = "AND p.id_destino IN(11)";
        if ($destino == "SDQ") $filtroDestino = "AND p.id_destino IN(3)";
        if ($destino == "SSA") $filtroDestino = "AND p.id_destino IN(4)";
        if ($destino == "MBJ") $filtroDestino = "AND p.id_destino IN(6)";

        $query = "SELECT
        p.id 'idProyecto',
        s.seccion,
        p.titulo 'proyecto',
        p.fase,
        CONCAT(c.nombre, ' ', c.apellido) 'responsable',
        p.status
        FROM t_proyectos AS p
        INNER JOIN c_secciones AS s ON p.id_seccion = s.id
        LEFT JOIN t_users AS u ON p.responsable = u.id
        LEFT JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE p.titulo LIKE '%AUDITORIA%'  and p.activo = 1 $filtroDestino ORDER BY p.id ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        // $prepare->bind_param("i", $idDestino);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $idProyecto = intval($x['idProyecto']);

            $tareas = AuditoriaProyectos::tareas($idProyecto, $post);
            $ots = 0;
            $finalizados = 0;
            $proceso = 0;
            $proveedor = 0;
            $pAprobar = 0;
            $avance = 0;
            $x['fase'] = explode(",", $x['fase']);

            // TAREAS DEL PROYECTO
            foreach ($tareas as $y) {
                $ots++;
                if ($y['statusAlterno'] == "FINALIZADO") $finalizados++;
                if ($y['statusAlterno'] == "PROCESO") $proceso++;
                if ($y['statusAlterno'] == "P. APROBACION") $pAprobar++;
                if ($y['statusAlterno'] == "P. PROVEEDOR") $proveedor++;
            }

            #PORCENTAJE SOLUCIONADAS
            if ($ots > 0)
                $avance = (100 / $ots) * $finalizados;

            $x['ots'] = $ots;
            $x['finalizados'] = $finalizados;
            $x['proceso'] = $proceso;
            $x['proveedor'] = $proveedor;
            $x['pAprobar'] = $pAprobar;
            $x['avance'] = $avance;

            if (
                $x['status'] === "F" ||
                $x['status'] === "SOLUCIONADA" ||
                $x['status'] === "FINALIZADO"
            ) {
                $x['status'] = "FINALIZADO";
            } else {
                $x['status'] = "PROCESO";
            }

            $x['tareas'] = $tareas;

            #RESULTADO FINAL DE PROYECTOS
            $array[] = $x;
        }

        return $array;
    }


    #OBTIENE TAREAS DEL PROYECTO
    public static function tareas($idProyecto, $post)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        #FILTROS PARA STATUS
        $filtroStatus = "";

        if ($post['status'] == "FINALIZADO")
            $filtroStatus = "AND t.status IN('F', 'FINALIZADO', 'SOLUCIONADO')";

        if ($post['status'] == "PROCESO")
            $filtroStatus = "AND t.status IN('N', 'PENDIENTE', 'PROCESO') AND t.departamento_direccion = '0' AND t.departamento_compras = '0'";

        if ($post['status'] == "P. APROBACION")
            $filtroStatus = "AND t.departamento_direccion = '1' AND t.status IN('N', 'PENDIENTE', 'PROCESO')";

        if ($post['status'] == "P. PROVEEDOR")
            $filtroStatus = "AND t.departamento_compras = '1' AND t.departamento_direccion = '0' AND t.status IN('N', 'PENDIENTE', 'PROCESO')";


        #FILTROS PARA FECHAS
        $filtroFechas = "";
        $fechaInicio = $post['fechaInicio'];
        $fechaFin = $post['fechaFin'];

        if ($post['fechaDe'] == "ALTA") $filtroFechas = "AND t.fecha_alta BETWEEN '$fechaInicio' AND '$fechaFin'";

        if ($post['fechaDe'] == "CADUCIDAD") $filtroFechas = "AND t.fecha_caducidad BETWEEN '$fechaInicio' AND '$fechaFin'";

        if ($post['fechaDe'] == "SUBSANACION") $filtroFechas = "AND t.fecha_subsanacion BETWEEN '$fechaInicio' AND '$fechaFin'";


        #FILTROS PARA PALABRA
        $filtroPalabra = "";
        $palabra = $post['palabra'];

        if (strlen($palabra) > 0) $filtroPalabra = "AND t.actividad LIKE '%$palabra%'";

        $query = "SELECT
        t.id 'idTarea',
        t.actividad 'tarea',
        CONCAT(c.nombre, ' ', c.apellido) 'responsable',
        t.departamento_direccion 'aprobado',
        t.departamento_compras 'proveedor',
        t.fecha_alta 'fechaAlta',
        t.fecha_caducidad 'fechaCaducidad',
        t.fecha_subsanacion 'fechaSubsanacion',
        t.status
        FROM t_proyectos_planaccion AS t
        LEFT JOIN t_users AS u ON t.responsable = u.id
        LEFT JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE t.id_proyecto = ? and t.activo = 1 $filtroStatus $filtroFechas $filtroPalabra
        ORDER BY t.id ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idProyecto);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $idTarea = $x['idTarea'];

            $x['statusAlterno'] = "PROCESO";

            if ($x['proveedor'] == 1) $x['statusAlterno'] = "P. PROVEEDOR";
            if ($x['aprobado'] == 1) $x['statusAlterno'] = "P. APROBACION";

            if (
                $x['status'] == "F" ||
                $x['status'] == "FINALIZADO" ||
                $x['status'] == "SOLUCIONADO"
            ) {
                $x['status'] = "FINALIZADO";
                $x['statusAlterno'] = "FINALIZADO";
            } else {
                $x['status'] = "PROCESO";
            }

            $x['comentarios'] = AuditoriaProyectos::comentarios($idTarea);
            $x['adjuntos'] = AuditoriaProyectos::adjuntos($idTarea);

            $array[] = $x;
        }

        #RESULTADO FINAL DE PROYECTOS
        return $array;
    }

    #ADJUNTOS DE LAS TAREAS POR ID
    public static function adjuntos($idTarea)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT id 'idAdjunto', url_adjunto 'url', posicion
        FROM t_proyectos_planaccion_adjuntos
        WHERE id_actividad = ? and status = 1
        ORDER BY id ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idTarea);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();
        $array['all'] = array();
        $array['antes'] = array();
        $array['despues'] = array();



        $path = "https://www.maphg.com";
        if (strpos($_SERVER['REQUEST_URI'], "america") == true)
            $path = "https://www.maphg.com/america";
        if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
            $path = "https://www.maphg.com/europa";

        foreach ($response as $x) {
            $posicion = $x['posicion'];
            $adjunto = $x['url'];
            $url = $x['url'];

            if (file_exists("../../planner/proyectos/$adjunto")) {
                $url = "https://www.maphg.com/planner/proyectos/$adjunto";
            } elseif (file_exists("../planner/proyectos/$adjunto")) {
                $url = "$path/planner/proyectos/$adjunto";
            } elseif (file_exists("../planner/proyectos/planaccion/$adjunto")) {
                $url = "$path/planner/proyectos/planaccion/$adjunto";
            }

            $x['idTarea'] = $idTarea;
            $x['tipo'] = pathinfo($adjunto, PATHINFO_EXTENSION);
            $x['url'] = $url;

            if ($posicion == "ANTES") $array['antes'][] = $x;
            if ($posicion == "DESPUES") $array['despues'][] = $x;

            $array['all'][] = $x;
        }

        #RESULTADO FINAL DE PROYECTOS
        return $array;
    }

    #COMENTARIOS DE LAS TAREAS POR ID
    public static function comentarios($idTarea)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT
        c.id 'idComentario',
        c.comentario,
        CONCAT(col.nombre, ' ', col.apellido) 'nombre',
        c.fecha
        FROM t_proyectos_planaccion_comentarios AS c
        INNER JOIN t_users AS u ON c.usuario = u.id
        INNER JOIN t_colaboradores AS col ON u.id_colaborador = col.id
        WHERE c.id_actividad = ? and c.activo = 1
        ORDER BY c.id ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idTarea);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $array[] = $x;
        }

        #RESULTADO FINAL DE PROYECTOS
        return $array;
    }

    #ACTUALIZAR TAREAS
    public static function actualizarTareas($post)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "UPDATE t_proyectos_planaccion SET fecha_alta = ?, fecha_caducidad = ?, fecha_subsanacion = ? WHERE id = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("sssi", $post['fechaAlta'], $post['fechaCaducidad'], $post['fechaSubsanacion'], $post['idTarea']);

        $respuesta = false;
        if ($prepare->execute()) $respuesta = true;

        #RESULTADO FINAL
        return $respuesta;
    }

    #ACTUALIZAR ADJUNTO
    public static function actualizarAdjunto($post)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "UPDATE t_proyectos_planaccion_adjuntos SET posicion = ?
        WHERE id = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("si", $post['posicion'], $post['idAdjunto']);

        $respuesta = array();
        if ($prepare->execute()) {
            $respuesta = AuditoriaProyectos::adjuntos($post['idTarea']);
        }

        #RESULTADO FINAL
        return $respuesta;
    }

    #ACTUALIZAR FASE
    public static function actualizarFase($post)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $valor = implode(',', $post['fase']);

        $query = "UPDATE t_proyectos SET fase = ?
        WHERE id = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("si", $valor, $post['idProyecto']);

        $respuesta = false;
        if ($prepare->execute())
            $respuesta = true;

        #RESULTADO FINAL
        return $respuesta;
    }
}
