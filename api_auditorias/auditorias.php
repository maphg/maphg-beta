<?php
class Auditorias extends Conexion
{

    public static function all($post)
    {
        #OBTIENE TODOS LOS RESULTADOS
        $array = array();
        $tareasTotalGlobal = 0;
        $tareasEnProcesoGlobal = 0;
        $tareasPProveedorGlobal = 0;
        $tareasPAprovacionGlobal = 0;
        $tareasFinalizadoGlobal = 0;

        $auditorias = Auditorias::Grupos($_POST);

        foreach ($auditorias as $x) {
            $tareasTotal = 0;
            $tareasEnProceso = 0;
            $tareasPProveedor = 0;
            $tareasPAprovacion = 0;
            $tareasFinalizado = 0;

            $post['idGrupo'] = $x['idGrupo'];
            $tareas = Auditorias::Tareas($post);

            foreach ($tareas as $y) {
                $estado = $y['estado'];

                $tareasTotal++;

                if ($estado == "En Proceso") $tareasEnProceso++;
                if ($estado == "P. Proveedor") $tareasPProveedor++;
                if ($estado == "P. Aprovación") $tareasPAprovacion++;
                if ($estado == "Finalizado") $tareasFinalizado++;
            }

            $x['tareasTotalPorcentaje'] =
                $tareasTotal > 0 ? 100 / $tareasTotal : 0;

            $x['tareasTotal'] = $tareasTotal;
            $x['tareasEnProceso'] = $tareasEnProceso;
            $x['tareasPProveedor'] = $tareasPProveedor;
            $x['tareasPAprovacion'] = $tareasPAprovacion;
            $x['tareasFinalizado'] = $tareasFinalizado;

            $x['tareas'] = $tareas;

            #DATOS GLOBALES
            $tareasTotalGlobal += $tareasTotal;
            $tareasEnProcesoGlobal += $tareasEnProceso;
            $tareasPProveedorGlobal += $tareasPProveedor;
            $tareasPAprovacionGlobal += $tareasPAprovacion;
            $tareasFinalizadoGlobal += $tareasFinalizado;


            $array['data'][] = $x;
        }

        #DATOS GLOBALES
        $array['dataGlobales']['tareasTotalGlobal'] =
            $tareasTotalGlobal;

        $array['dataGlobales']['tareasTotalPorcentajeGlobal'] =
            $tareasTotalGlobal > 0 ? 100 / $tareasTotalGlobal : 0;

        $array['dataGlobales']['tareasEnProcesoGlobal'] =
            $tareasEnProcesoGlobal;

        $array['dataGlobales']['tareasPProveedorGlobal'] =
            $tareasPProveedorGlobal;

        $array['dataGlobales']['tareasPAprovacionGlobal'] =
            $tareasPAprovacionGlobal;

        $array['dataGlobales']['tareasFinalizadoGlobal'] =
            $tareasFinalizadoGlobal;

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
        a.activo,
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


    public static function updateGrupo($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();

        $array = array();

        $query = "UPDATE t_auditorias SET grupo = ?, activo = ? WHERE id = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "sii",
            $post['grupo'],
            $post['activo'],
            $post['idAuditoria']
        );

        if ($prepare->execute())
            $array = Auditorias::all($_POST);


        return $array;
    }


    public static function Tareas($post)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $estado = $post['estado'];
        $palabra = $post['palabra'];

        $filtroEstado =
            $estado === "" ? "" : "AND at.estado = '$estado'";
        $filtroPalabra =

            $palabra === "" ? "" : "AND at.descripcion LIKE '%$palabra%'";

        $query = "SELECT
        d.id 'idDestino',
        d.destino,
        a.id 'idGrupo',
        a.grupo,
        at.id 'idTarea',
        at.descripcion 'tarea',
        at.estado,
        at.fecha_alta 'fechaAlta',
        at.fecha_caducidad 'fechaCaducidad',
        at.fecha_subsanacion 'fechaSubsanacion',
        at.id_responsable 'idResponsable',
        CONCAT(c.nombre, ' ', c.apellido) 'responsable',
        at.activo
        FROM  t_auditorias AS a
        INNER JOIN t_auditorias_tareas AS at ON a.id = at.id_auditoria
        INNER JOIN c_destinos AS d ON a.id_destino = d.id
        INNER JOIN t_users AS u ON at.id_responsable = u.id
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE a.activo = 1 AND at.activo = 1 AND a.id = ?
        $filtroEstado $filtroPalabra
        ORDER BY at.descripcion ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $post['idGrupo']);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $x['responsable'] = strtolower($x['responsable']);

            $idTarea = $x['idTarea'];
            $comentarios = Auditorias::TareasComentarios($idTarea);
            $adjuntos = Auditorias::TareasAdjuntos($idTarea);

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
        $array = "ERROR";

        $query = "INSERT INTO t_auditorias_tareas(id_auditoria, descripcion, id_responsable, estado, fecha_alta, fecha_caducidad, fecha_subsanacion, fecha_creado, creado_por, activo) VALUES(?,?,?,?,?,?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "isisssssii",
            $post['idAuditoria'],
            $post['descripcion'],
            $post['idUsuario'],
            $post['estado'],
            $post['fechaAlta'],
            $post['fechaCaducidad'],
            $post['fechaSubsanacion'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute())
            $array = "SUCCESS";


        return $array;
    }


    public static function updateTarea($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = "ERROR";

        $query = "UPDATE t_auditorias_tareas SET
        descripcion = ?,
        id_responsable = ?,
        estado = ?,
        fecha_alta = ?,
        fecha_caducidad = ?,
        fecha_subsanacion = ?,
        activo = ?
        WHERE id = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "sissssii",
            $post['tarea'],
            $post['idResponsable'],
            $post['estado'],
            $post['fechaAlta'],
            $post['fechaCaducidad'],
            $post['fechaSubsanacion'],
            $post['activo'],
            $post['idTarea']
        );

        if ($prepare->execute())
            $array = "SUCCESS";


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
            $post['idTarea'],
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

        $rutaAbsoluta = "https://maphg.com/america/planner/avatars/AVATAR_ID_0_0.svg";
        if (strpos($_SERVER['REQUEST_URI'], "america") == true)
            $rutaAbsoluta = "https://maphg.com/america/Auditorias/adjuntos/";
        if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
            $rutaAbsoluta = "https://maphg.com/europa/Auditorias/adjuntos/";
        if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
            $rutaAbsoluta = "http://localhost/maphg-beta/Auditorias/adjuntos/";

        $query = "SELECT
        ata.id 'idAdjunto',
        ata.url,
        ata.descripcion,
        ata.posicion,
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

        foreach ($response as $x) {
            $x['url'] = $rutaAbsoluta . $x['url'];

            $array[] = $x;
        }

        return $array;
    }


    public static function addTareasAdjuntos($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = array();

        $query = "INSERT INTO t_auditorias_tareas_adjuntos(id_auditoria_tarea, url, descripcion, posicion, extension, fecha_creado, creado_por, activo) VALUES(?,?,?,?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "isssssii",
            $post['idAuditoriaTarea'],
            $post['url'],
            $post['descripcion'],
            $post['posicion'],
            $post['extension'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute())
            $array = "Auditorias::all()";


        return $array;
    }


    public static function responsables($idDestino)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT
        u.id 'idUsuario',
        u.id 'idResponsable',
        CONCAT(c.nombre, ' ', c.apellido) 'responsable'
        FROM  t_users AS u
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE u.activo = 1 AND u.status = 'A' AND u.id_destino IN(?, 10)
        ORDER BY c.nombre ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idDestino);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $x['responsable'] = strtolower($x['responsable']);

            $array[] = $x;
        }

        return $array;
    }


    public static function sesion($idUsuario)
    {
        // DEVULVE LOS HOTELES PERMITIDOS AL USUARIO (IDUSAURIO)
        $conexion = new Conexion();
        $conexion->conectar();

        $rutaAbsoluta = "https://maphg.com/america/planner/avatars/AVATAR_ID_0_0.svg";
        if (strpos($_SERVER['REQUEST_URI'], "america") == true)
            $rutaAbsoluta = "https://maphg.com/america/planner/avatars/";
        if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
            $rutaAbsoluta = "https://maphg.com/europa/planner/avatars/";
        if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
            $rutaAbsoluta = "https://maphg.com/america/planner/avatars/";

        $query = "SELECT
        u.id 'idUsuario',
        CONCAT(c.nombre, ' ', c.apellido) 'usuario',
        u.id_destino 'idDestino',
        c.foto
        FROM  t_users AS u
        INNER JOIN t_colaboradores AS c ON u.id_colaborador = c.id
        WHERE u.activo = 1 AND u.status = 'A' AND u.id = ?
        ORDER BY c.nombre ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("i", $idUsuario);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $idDestino = $x['idDestino'];

            $x['foto'] = $x['foto'] == "" ?
                $rutaAbsoluta . "AVATAR_ID_0_0.svg" : $rutaAbsoluta . $x['foto'];

            $destinosPermitidos = Auditorias::destinos($idDestino);
            $x['destinosPermitidos'] = $destinosPermitidos;

            $menuDestinos = array();

            foreach ($destinosPermitidos as $y)
                $menuDestinos[$y['pais']][] = $y;

            $x['menuDestinos'] = $menuDestinos;



            $array = $x;
        }

        return $array;
    }


    public static function destinos($idDestino)
    {
        // DEVULVE LOS DESTINOS ENCONTRADOS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $filtroDestino = $idDestino == 10 ? "" : "WHERE id = $idDestino";

        $query = "SELECT
        id 'idDestino',
        destino,
        ubicacion,
        continente,
        pais
        FROM  c_destinos
        $filtroDestino
        ORDER BY destino ASC";

        $prepare = mysqli_prepare($conexion->con, $query);
        // $prepare->bind_param("i", $idDestino);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x)
            $array[] = $x;


        return $array;
    }


    public static function login($post)
    {
        // DEVULVE LOS DESTINOS ENCONTRADOS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT
        id 'idUsuario',
        id_destino 'idDestino'
        FROM  t_users
        WHERE status = 'A' AND activo = 1 AND username = ? AND password = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("ss", $post['usuario'], $post['contraseña']);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $x['token'] = "lkj232kj323jkl123jk32lk3d";
            $x['fechaVencimiento'] = "";
            $array[] = $x;
        }


        return $array;
    }


    public static function validarSesion($post)
    {
        // DEVULVE LOS DESTINOS ENCONTRADOS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $query = "SELECT
        id 'idUsuario',
        id_destino 'idDestino'
        FROM  t_users
        WHERE status = 'A' AND activo = 1 AND id = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param("s", $post['idUsuario']);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $x['token'] = "lkj232kj323jkl123jk32lk3d";
            $x['fechaVencimiento'] = "";
            $array[] = $x;
        }


        return $array;
    }
}
