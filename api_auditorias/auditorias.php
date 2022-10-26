<?php
class Auditorias extends Conexion
{

    public static function all($post)
    {
        #OBTIENE TODOS LOS RESULTADOS
        $array = array();

        $auditorias = Auditorias::Grupos($_POST);

        foreach ($auditorias as $x) {

            $idGrupo = $x['idGrupo'];
            $tareas = Auditorias::Tareas($idGrupo);

            $x['tareas'] = $tareas;


            $array[] = $x;
        }

        return $array;
    }


    public static function Grupos($post)
    {
        // DEVULVE LOS GRUPOS
        $conexion = new Conexion();
        $conexion->conectar();

        $idDestino = $post['idDestino'];

        $filtroDestino = $idDestino == 10 ? "" :
            "AND a.id_destino = $idDestino";

        $query = "SELECT
        a.id 'idGrupo',
        a.grupo,
        d.id 'idDestino',
        d.destino,
        d.ubicacion
        FROM  t_auditorias AS a
        INNER JOIN c_destinos AS d ON a.id_destino = d.id
        WHERE a.activo = 1 $filtroDestino
        ORDER BY a.id DESC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x)
            $array[] = $x;

        return $array;
    }


    public static function addGrupo($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = array();

        $query = "INSERT INTO t_auditorias(id_destino, grupo, fecha_creado, creado_por, activo) VALUES(?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "issii",
            $post['idDestino'],
            $post['grupo'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute())
            $array = Auditorias::all($_POST);


        return $array;
    }


    public static function Tareas($idGrupo)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT
        d.id 'idDestino',
        d.destino,
        a.id 'idGrupo',
        a.grupo,
        at.id 'idTarea',
        at.descripcion 'tarea',
        at.estado,
        at.fecha_alta,
        at.fecha_caducidad,
        at.fecha_subsanacion,
        CONCAT(c.nombre, ' ', c.apellido) 'creadoPor'
        FROM  t_auditorias AS a
        INNER JOIN t_auditorias_tareas AS at ON a.id = at.id_auditoria
        INNER JOIN c_destinos AS d ON a.id_destino = d.id
        INNER JOIN t_users AS u ON at.creado_por = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE a.activo = 1 AND at.activo = 1 AND a.id = ?
        ORDER BY at.descripcion DESC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idGrupo);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $idTarea = $x['idTarea'];
            $adjuntos = Auditorias::TareasComentarios($idTarea);
            $comentarios = Auditorias::TareasAdjuntos($idTarea);

            #COMENTARIOS
            $x['comentarios'] = $comentarios;
            $x['comentariosTotal'] = count($comentarios);

            #ADJUNTOS
            $x['adjuntos'] = $adjuntos;
            $x['adjuntosTotal'] = count($adjuntos);

            $array[] = $x;
        }

        return $array;
    }


    public static function addTarea($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = array();

        $query = "INSERT INTO t_auditorias_tareas(id_auditoria, descripcion, id_responsable, estado, fecha_alta, fecha_caducidad, fecha_subsanacion, fecha_creado, creado_por, activo) VALUES(?,?,?,?,?,?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "isisssssii",
            $post['idAuditoria'],
            $post['descripcion'],
            $post['idResponsable'],
            $post['estado'],
            $post['fechaAlta'],
            $post['fechaCaducidad'],
            $post['fechaSubsanacion'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute())
            $array = Auditorias::all($_POST);


        return $array;
    }


    public static function TareasComentarios($idTarea)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT
        atc.id 'idComentario',
        atc.comentario,
        atc.fecha_creado 'fechaCreado',
        CONCAT(c.nombre, ' ', c.apellido) 'creadoPor'
        FROM  t_auditorias_tareas_comentarios AS atc
        INNER JOIN t_users AS u ON atc.creado_por = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE atc.activo = 1 AND atc.id_auditoria_tarea = ?
        ORDER BY atc.id DESC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idTarea);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x)
            $array[] = $x;

        return $array;
    }


    public static function addTareasComentarios($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = array();

        $query = "INSERT INTO t_auditorias_tareas_comentarios(id_auditoria_tarea, comentario, fecha_creado, creado_por, activo) VALUES(?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "issii",
            $post['idAuditoriaTarea'],
            $post['comentario'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute())
            $array = Auditorias::all($_POST);


        return $array;
    }

    public static function TareasAdjuntos($idTarea)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT
        ata.id 'idAdjunto',
        ata.url,
        ata.descripcion,
        ata.extension,
        ata.fecha_creado 'fechaCreado',
        ata.creado_por 'idCreadoPor',
        CONCAT(c.nombre, ' ', c.apellido) 'creadoPor'
        FROM  t_auditorias_tareas_adjuntos AS ata
        INNER JOIN t_users AS u ON ata.creado_por = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE ata.activo = 1 AND ata.id_auditoria_tarea = ?
        ORDER BY ata.id DESC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idTarea);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x)
            $array[] = $x;

        return $array;
    }

    public static function addTareasAdjuntos($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = array();

        $query = "INSERT INTO t_auditorias_tareas_adjuntos(id_auditoria_tarea, url, descripcion, extension, fecha_creado, creado_por, activo) VALUES(?,?,?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "issssii",
            $post['idAuditoriaTarea'],
            $post['url'],
            $post['descripcion'],
            $post['extension'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute())
            $array = Auditorias::all($_POST);


        return $array;
    }
}
