<?php
class Auditorias extends Conexion
{

    public static function all($post)
    {
        #OBTIENE TODOS LOS RESULTADOS
        $array = array();
        $tareasTotalGlobal = 0;

        // Estados
        $FinalizadoGlobal = 0;
        $CotizacionGlobal = 0;
        $CatalogoConceptosGlobal = 0;
        $AprobacionGlobal = 0;
        $PProveedorGlobal = 0;
        $Ejecucion60Global = 0;
        $Ejecucion80Global = 0;

        $auditorias = Auditorias::Grupos($_POST);

        foreach ($auditorias as $x) {
            $tareasTotal = 0;

            $Finalizado = 0;
            $Cotizacion = 0;
            $CatalogoConceptos = 0;
            $Aprobacion = 0;
            $PProveedor = 0;
            $Ejecucion60 = 0;
            $Ejecucion80 = 0;

            $post['idGrupo'] = $x['idGrupo'];
            $tareas = Auditorias::Tareas($post);

            foreach ($tareas as $y) {
                $estado = $y['estado'];

                $tareasTotal++;

                if ($estado == "Finalizado") $Finalizado++;

                if ($estado == "Cotización" || $estado == "Cotizacion")
                    $Cotizacion++;

                if ($estado == "Catalogo Conceptos") $CatalogoConceptos++;

                if ($estado == "Aprobación" || $estado == "Aprobación")
                    $Aprobacion++;

                if ($estado == "P. Proveedor")
                    $PProveedor++;

                if ($estado == "Ejecución 60%" || $estado == "Ejecucion 60%")
                    $Ejecucion60++;

                if ($estado == "Ejecución 80%" || $estado == "Ejecucion 80%")
                    $Ejecucion80++;
            }

            $x['tareasTotalPorcentaje'] =
                $tareasTotal > 0 ? 100 / $tareasTotal : 0;

            $x['tareasTotal'] = $tareasTotal;
            $x['Finalizado'] = $Finalizado;
            $x['Cotizacion'] = $Cotizacion;
            $x['CatalogoConceptos'] = $CatalogoConceptos;
            $x['Aprobacion'] = $Aprobacion;
            $x['PProveedor'] = $PProveedor;
            $x['Ejecucion60'] = $Ejecucion60;
            $x['Ejecucion80'] = $Ejecucion80;

            $x['tareas'] = $tareas;

            #DATOS GLOBALES
            $tareasTotalGlobal += $tareasTotal;
            $FinalizadoGlobal += $Finalizado;
            $CotizacionGlobal += $Cotizacion;
            $CatalogoConceptosGlobal += $CatalogoConceptos;
            $AprobacionGlobal += $Aprobacion;
            $PProveedorGlobal += $PProveedor;
            $Ejecucion60Global += $Ejecucion60;
            $Ejecucion80Global += $Ejecucion80;

            $array['data'][] = $x;
        }

        #DATOS GLOBALES
        $array['dataGlobales']['tareasTotalGlobal'] =
            $tareasTotalGlobal;

        $array['dataGlobales']['tareasTotalPorcentajeGlobal'] =
            $tareasTotalGlobal > 0 ? 100 / $tareasTotalGlobal : 0;

        $array['dataGlobales']['FinalizadoGlobal'] =
            $FinalizadoGlobal;

        $array['dataGlobales']['CotizacionGlobal'] =
            $CotizacionGlobal;

        $array['dataGlobales']['CatalogoConceptosGlobal'] =
            $CatalogoConceptosGlobal;

        $array['dataGlobales']['AprobacionGlobal'] =
            $AprobacionGlobal;

        $array['dataGlobales']['PProveedorGlobal'] =
            $PProveedorGlobal;

        $array['dataGlobales']['Ejecucion60Global'] =
            $Ejecucion60Global;

        $array['dataGlobales']['Ejecucion80Global'] =
            $Ejecucion80Global;

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
        FROM  t_ffande AS a
        INNER JOIN c_destinos AS d ON a.id_destino = d.id
        WHERE a.activo = 1 $filtroDestino
        ORDER BY a.id DESC";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->execute();
        $response = $prepare->get_result();

        #ARRAYS
        $array = array();

        foreach ($response as $x) {
            $array[] = $x;
        }

        return $array;
    }

    public static function addGrupo($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = array();

        $query = "INSERT INTO t_ffande(
        id_destino,
        grupo,
        fecha_creado,
        creado_por,
        activo)
        VALUES(?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "issii",
            $post['idDestino'],
            $post['grupo'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute()) {
            $array = "AGREGADO";
        }

        return $array;
    }

    public static function updateGrupo($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();

        $array = array();

        $query = "UPDATE t_ffande SET grupo = ?, activo = ? WHERE id = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "sii",
            $post['grupo'],
            $post['activo'],
            $post['idAuditoria']
        );

        if ($prepare->execute())
            $array = "ACTUALIZADO";


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
        at.justificacion,
        at.estado,
        at.fecha_alta 'fechaAlta',
        at.fecha_caducidad 'fechaCaducidad',
        at.fecha_subsanacion 'fechaSubsanacion',
        at.año_natural 'añoNatural',
        at.importe_previo 'importePrevio',
        at.importe_actual 'importeActual',
        at.id_responsable 'idResponsable',
        at.id_responsable 'idResponsable',
        at.campo1,
        at.campo2,
        at.campo3,
        at.campo4,
        at.campo5,
        at.campo6,
        at.campo7,
        at.campo8,
        at.campo9,
        at.campo10,
        CONCAT(c.nombre, ' ', c.apellido) 'responsable',
        at.activo
        FROM  t_ffande AS a
        INNER JOIN t_ffande_tareas AS at ON a.id = at.id_auditoria
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

        $query = "INSERT INTO t_ffande_tareas
        (
        id_auditoria,
        descripcion,
        justificacion,
        id_responsable,
        estado,
        fecha_alta,
        fecha_caducidad,
        fecha_subsanacion,
        año_natural,
        importe_previo,
        importe_actual,
        campo1,
        campo2,
        campo3,
        campo4,
        campo5,
        campo6,
        campo7,
        campo8,
        campo9,
        campo10,
        fecha_creado,
        creado_por,
        activo
        )
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "ississssssssssssssssssii",
            $post['idAuditoria'],
            $post['descripcion'],
            $post['justificacion'],
            $post['idUsuario'],
            $post['estado'],
            $post['fechaAlta'],
            $post['fechaCaducidad'],
            $post['fechaSubsanacion'],
            $post['añoNatural'],
            $post['importePrevio'],
            $post['importeActual'],
            $post['campo1'],
            $post['campo2'],
            $post['campo3'],
            $post['campo4'],
            $post['campo5'],
            $post['campo6'],
            $post['campo7'],
            $post['campo8'],
            $post['campo9'],
            $post['campo10'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute()) {
            $array = "SUCCESS";
        }

        return $array;
    }

    public static function updateTarea($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = "ERROR";

        $query = "UPDATE t_ffande_tareas SET
        descripcion = ?,
        justificacion = ?,
        id_responsable = ?,
        estado = ?,
        fecha_alta = ?,
        fecha_caducidad = ?,
        fecha_subsanacion = ?,
        año_natural = ?,
        importe_previo = ?,
        importe_actual = ?,
        campo1 = ?,
        campo2 = ?,
        campo3 = ?,
        campo4 = ?,
        campo5 = ?,
        campo6 = ?,
        campo7 = ?,
        campo8 = ?,
        campo9 = ?,
        campo10 = ?,
        activo = ?
        WHERE id = ?";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "ssisssssssssssssssssii",
            $post['tarea'],
            $post['justificacion'],
            $post['idResponsable'],
            $post['estado'],
            $post['fechaAlta'],
            $post['fechaCaducidad'],
            $post['fechaSubsanacion'],
            $post['añoNatural'],
            $post['importePrevio'],
            $post['importeActual'],
            $post['campo1'],
            $post['campo2'],
            $post['campo3'],
            $post['campo4'],
            $post['campo5'],
            $post['campo6'],
            $post['campo7'],
            $post['campo8'],
            $post['campo9'],
            $post['campo10'],
            $post['activo'],
            $post['idTarea']
        );

        if ($prepare->execute()) {
            $array = "SUCCESS";
        }

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
        FROM  t_ffande_tareas_comentarios AS atc
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

        foreach ($response as $x) {
            $array[] = $x;
        }

        return $array;
    }

    public static function addTareasComentarios($post)
    {
        $conexion = new Conexion();
        $conexion->conectar();
        $activo = 1;
        $array = array();

        $query = "INSERT INTO t_ffande_tareas_comentarios(id_auditoria_tarea, comentario, fecha_creado, creado_por, activo) VALUES(?,?,?,?,?)";

        $prepare = mysqli_prepare($conexion->con, $query);
        $prepare->bind_param(
            "issii",
            $post['idTarea'],
            $post['comentario'],
            $post['fechaCreado'],
            $post['idUsuario'],
            $activo
        );

        if ($prepare->execute()) {
            $array = Auditorias::all($_POST);
        }

        return $array;
    }

    public static function TareasAdjuntos($idTarea)
    {
        // DEVULVE LOS HOTELES ENCONTRADAS (DESTINO)
        $conexion = new Conexion();
        $conexion->conectar();

        $rutaAbsoluta = "https://maphg.com/america/planner/avatars/AVATAR_ID_0_0.svg";
        if (strpos($_SERVER['REQUEST_URI'], "america") == true)
            $rutaAbsoluta = "https://maphg.com/america/ffande/adjuntos/";

        if (strpos($_SERVER['REQUEST_URI'], "europa") == true)
            $rutaAbsoluta = "https://maphg.com/europa/ffande/adjuntos/";

        if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true)
            $rutaAbsoluta = "../maphg-beta/ffande/adjuntos/";


        $query = "SELECT
        ata.id 'idAdjunto',
        ata.url,
        ata.descripcion,
        ata.posicion,
        ata.extension,
        ata.fecha_creado 'fechaCreado',
        ata.creado_por 'idCreadoPor',
        CONCAT(c.nombre, ' ', c.apellido) 'creadoPor'
        FROM  t_ffande_tareas_adjuntos AS ata
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

        $query = "INSERT INTO t_ffande_tareas_adjuntos(id_auditoria_tarea, url, descripcion, posicion, extension, fecha_creado, creado_por, activo) VALUES(?,?,?,?,?,?,?,?)";

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

        if ($prepare->execute()) {
            $array = "Auditorias::all()";
        }

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
        if (strpos($_SERVER['REQUEST_URI'], "america") == true) {
            $rutaAbsoluta = "https://maphg.com/america/planner/avatars/";
        }

        if (strpos($_SERVER['REQUEST_URI'], "europa") == true) {
            $rutaAbsoluta = "https://maphg.com/europa/planner/avatars/";
        }

        if (strpos($_SERVER['REQUEST_URI'], "maphg-beta") == true) {
            $rutaAbsoluta = "https://maphg.com/america/planner/avatars/";
        }

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

            foreach ($destinosPermitidos as $y) {
                $menuDestinos[$y['pais']][] = $y;
            }

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

        foreach ($response as $x) {
            $array[] = $x;
        }

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
